<?php
namespace App\Http\Controllers\Api;

use App\Http\Resources\Job\JobResource;
use App\Http\Resources\Job\JobRosterCollection;
use App\Http\Resources\Job\JobRosterResource;
use App\Models\JobNewRoster;
use App\Models\JobRosterActivity;
use App\Models\GreenCall;
use App\Models\GuardJobActivity;
use App\Repositories\JobRepository;
use App\Repositories\JobRosterActivityRepository;
use App\Repositories\JobRosterRepository;
use App\Repositories\GuardJobActivityRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use App\Models\User;


class JobController extends ApiController
{
    public $repo;
    public $jobRosterRepo;
    public $jobRosterActivityRepo;
    public $currentUser;
    public $request;
    public $greenCall;
    public $guardJobActivityRepo;
    const JOB_STATUS_CONFIRMED = 'confirmed';
    const JOB_STATUS_PENDING = 'pending';
    const JOB_STATUS_REJECTED = 'rejected';
    protected $timezone = array(
      'Victoria' => 'Australia/Melbourne',
      'New South Whales' => 'Australia/Sydney',
      'Queensland' => 'Australia/Brisbane',
      'Tasmania' => 'Australia/Hobart',
      'Western Australia' => 'Australia/Perth',
      'South Australia' => 'Australia/Adelaide',
      'ACT' => 'Australia/Canberra'
  );

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, JobRepository $jobRepository, JobRosterRepository $jobRosterRepository, JobRosterActivityRepository $jobRosterActivityRepository, GreenCall $greenCall, GuardJobActivityRepository $guardJobActivityRepository, Notification $notification) {
        parent::__construct($request);
        
/*        header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");*/

$this->repo = $jobRepository;
$this->jobRosterRepo = $jobRosterRepository;
$this->jobRosterActivityRepo = $jobRosterActivityRepository;
$this->greenCall = $greenCall;
$this->guardJobActivityRepo = $guardJobActivityRepository;
$this->notification = $notification;
}
public function guard_sos_call(Request $request, $id)
{
    $this->request = $request;
    $this->setValidationRules(['location' => 'required']);
    if ($this->isValidRequest()) {
        $this->response = ['success' => false, 'error' => $this->getErrors()];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
    $guard = DB::table('guards')->where('id', $this->currentUser->id)->first();
    $roster = DB::table('job_new_roster')->where('roster_id', $id)->first();
    $job1 = DB::table('jobs')->where('id', $roster->site_id)->first();
    $notification = array(
        'guard_id' => $guard->id, 
        'record_id' => $id,
        'message' => $guard->name.' just clicked the emergancy SOS button at '. $job1->site_name,
        'type' => 'sos_call',
        'send_time' => time(),
        'title' => 'Guard Clicked SOS Button'
    );
    DB::table('portal_notifications')->insert($notification);

    DB::table('roster_complete_activity')->insert([
        'roster_id' => $id,
        'activity' => $guard->name.' just clicked the emergancy SOS button at location.',
        'type' => 'sos_call',
        'record_id' =>  $id,
        'activity_time' => time(),
        'activity_by' => $guard->id
    ]);
    DB::table('sos_call')->insert([
        'roster_id' => $id,
        'guard_id' => $guard->id,
        'location' => $request->location
    ]);
    $administrators = DB::table('portal_settings')
    ->where('permission_name', 'sos_call')
    ->where('permission', 1)
    ->first();
    $message = $guard->name.' Clicked SOS Button.<br>
    <style type="text/css">
    table, th, td {
        border: 1px solid black;
    }
    </style>
    <table style="width:100%">
    <tr>
    <th>Start Date & Time</th>
    <th>End Date & Time</th>
    <th>Address</th>
    </tr>
    <tr>
    <td>'.date('d/m/Y H:i', strtotime($roster->temp_start)).'</td>
    <td>'.date('d/m/Y H:i', strtotime($roster->temp_end)).'</td>
    <td>'.$job1->site_name.' ('.$job1->site_description.')</td>
    </tr>
    </table>';
    if (!empty($administrators)) {
        $admin_emails = explode(',', $administrators->users_emails);
        foreach ($admin_emails as $key => $admin_email) {
            $email_data['name'] = '';
            $email_data['email'] = $admin_email;
            $this->notification->sendGuardMail($email_data, 'Guard Clicked SOS Button', $message);
        }
    }
    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'success' => true,
        'message' => 'Event Log successfull.',
    ];
    return $this->sendResponse();

}
public function jobDetail($id) {
    return new JobResource($this->repo->getJobById($id,$this->currentUser->id));
}

public function getGuardJobs(Request $request, $type, $duration) {
    $week = ($request->input('week_no') != null) ? $request->input('week_no') : 0;
    $results = $this->jobRosterRepo->getCurrentMonthJobsByGuard(($this->currentUser) ? $this->currentUser->id : [], $type, $duration, $week);
    return new JobRosterCollection(JobRosterResource::collection($results));
}

public function jobSpecificDetail(Request $request, $id) {
    $results = $this->jobRosterRepo->jobSpecificDetail(($this->currentUser) ? $this->currentUser->id : [], $id);
    return new JobRosterCollection(JobRosterResource::collection($results));
}


public function getJobs(Request $request, $type, $duration, $id) {
    $week = ($request->input('week_no') != null) ? $request->input('week_no') : 0;
    $results = $this->jobRosterRepo->getJobs($id, $type, $duration, $week);
    return new JobRosterCollection(JobRosterResource::collection($results));
}

public function confirmJob($id) {
    if ($this->jobRosterRepo->updateJobStatus($id, self::JOB_STATUS_CONFIRMED)) {
        $roster = DB::table('job_new_roster')->where('roster_id', $id)->first();
        $guard = DB::table('guards')->where('id', $roster->guard_id)->first();
        $job = DB::table('jobs')->where('id', $roster->site_id)->first();
        $notification = array(
            'guard_id' => $roster->guard_id, 
            'record_id' => $id,
            'message' => $guard->name.' confirm his/her job at '. $job->site_name,
            'type' => 'job_confirm',
            'send_time' => time(),
            'title' => 'Job Confirmation'
        );
        DB::table('portal_notifications')->insert($notification);
        DB::table('roster_complete_activity')->insert([
            'roster_id' => $id,
            'activity' => $guard->name.' confirm his/her job.',
            'type' => 'job_confirm',
            'record_id' => $id,
            'activity_time' => time(),
            'activity_by' => $roster->guard_id
        ]);
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => true,
            'message' => 'Your job is confirmed.'
        ];
        return $this->sendResponse();
    }
    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'success' => false,
        'message' => 'Your job is not been confirmed.'
    ];
    return $this->sendResponse();
}

public function rejectJob($id) {
        // $this->statusCode = self::STATUS_CODE_200;
        // $this->response = [
        //     'success' => false,
        //     'message' => 'Your can\'t reject job!'
        // ];
        // return $this->sendResponse();
        // exit();
    $roster = DB::table('job_new_roster')->where('roster_id', $id)->first();
    $guard = DB::table('guards')->where('id', $roster->guard_id)->first();
    $job = DB::table('jobs')->where('id', $roster->site_id)->first();
    if ($this->jobRosterRepo->updateJobStatus($id, self::JOB_STATUS_REJECTED)) {   
        DB::table('job_new_roster')->where('roster_id', $id)->update(['rejected_by' => $roster->guard_id]);
        $notification = array(
            'guard_id' => $roster->guard_id, 
            'record_id' => $id,
            'message' => $guard->name.' rejected his/her job at '. $job->site_name,
            'type' => 'job_reject',
            'send_time' => time(),
            'title' => 'Job Rejection'
        );
        DB::table('portal_notifications')->insert($notification);
        DB::table('roster_complete_activity')->insert([
            'roster_id' => $id,
            'activity' => $guard->name.' rejected his/her job.',
            'type' => 'job_confirm',
            'record_id' => $id,
            'activity_time' => time(),
            'activity_by' => $roster->guard_id
        ]);
        $administrators = DB::table('portal_settings')
        ->where('permission_name', 'job_rejection')
        ->where('permission', 1)
        ->first();
        $message = $guard->name.' rejected his/her job.<br>
        <style type="text/css">
        table, th, td {
            border: 1px solid black;
        }
        </style>
        <table style="width:100%">
        <tr>
        <th>Start Date & Time</th>
        <th>End Date & Time</th>
        <th>Address</th>
        </tr>
        <tr>
        <td>'.date('d/m/Y H:i', strtotime($roster->temp_start)).'</td>
        <td>'.date('d/m/Y H:i', strtotime($roster->temp_end)).'</td>
        <td>'.$job->site_name.' ('.$job->site_description.')</td>
        </tr>
        </table>';
        if (!empty($administrators)) {
            $admin_emails = explode(',', $administrators->users_emails);
            foreach ($admin_emails as $key => $admin_email) {
                $email_data['name'] = '';
                $email_data['email'] = $admin_email;
                $this->notification->sendGuardMail($email_data, 'Job Rejection', $message);
            }
        }
        
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => true,
            'message' => 'Your job is rejected.'
        ];
        return $this->sendResponse();
    }
    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'success' => false,
        'message' => 'Your job is not rejected.'
    ];
    return $this->sendResponse();
}

public function jobSignin(Request $request, $id) {
    $this->request = $request;
    $this->setValidationRules(['time' => 'required', 'selfie' => 'required', 'location' => 'required']);
    if ($this->isValidRequest()) {
        $this->response = ['success' => false, 'error' => $this->getErrors()];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
        // $is_already_signin
        // $job_roaster = JobNewRoster::where('roster_id', $id)->first();
        // $job = new JobResource($this->repo->getJobById($job_roaster->site_id));
    $job = new JobResource($this->repo->getJobById($request->jobId, $this->currentUser->id));
    
    $roster_data = DB::table('job_new_roster')->where('roster_id',$id)->first();
    
    $job_start_time = $roster_data->job_start;
        // $job_start_time = strtotime($job_start_time);
    if ($request->has('signin_time')) {
        $current_time = $request->input('signin_time');
            // $current_time = str_replace('T', ' ', $current_time);
            // $current_time = str_replace('Z', ' ', $current_time);
            // $current_time = str_replace('GMT', ' ', $current_time);
            // $current_time = explode('+', $current_time);
            // $current_time = $current_time[0];
        $current_time = strtotime($current_time);
    }else{
        $current_time = time();
    }
    $diff = round(($job_start_time - $current_time) / 60,2);
        // if ($diff > 30) {
        //     $this->response = ['success' => false, 'error' => 'You can only sign-in 30 minutes prior to your shift. ', 'message' => 'You can only sign-in 30 minutes prior to your shift.'];
        //     $this->statusCode = self::STATUS_CODE_200;
        //     return $this->sendResponse();
        // }
        // elseif($diff < -30){
        //     $this->response = ['success' => false, 'error' => 'You are late more than 30 mins to your shift. Contact Operations now.', 'message' => 'You are late more than 30 mins to your shift. Contact Operations now.'];
        //     $this->statusCode = self::STATUS_CODE_200;
        //     return $this->sendResponse();
        // }
    $coordinates = explode(',', $request->input('location'));
    $coordinates1 = explode(',', $job->coordinates);
        // print_r($job->coordinates);
    $distance = $this->distance(trim($coordinates[0]), trim($coordinates[1]), trim($coordinates1[0]), trim($coordinates1[1]) );
    if($job->signin_radius > 0){
        $signin_radius = $job->signin_radius/1000;
    }else{
        $signin_radius = 0.31;
    }
    if($distance > $signin_radius){
        $this->response = ['success' => false, 'error' => 'You are '.number_format($distance, 2).' miles away from your job!', 'message' => 'You are '.number_format($distance, 2).' KM away from your job!'];

        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
    $is_already_signin = DB::table('job_roster_activities')->where(['job_roster_id' => $id])->first();
    if (!empty($is_already_signin)) {
     $this->response = ['success' => false, 'error' => 'You are already signin in this job!', 'message' => 'You are already signin in this job!'];
     $this->statusCode = self::STATUS_CODE_200;
     return $this->sendResponse();
 }
        // echo $distance;
        // exit();
 $field = 'selfie'; $media = '';
        // if ($this->request->hasFile($field)) {
            // $files = $this->request->file($field);
            // $media = $this->uploader($files);
 $media = $this->uploader_base64($this->request->input($field));
        // }
 $this->jobRosterActivityRepo->setStatusInactive($this->currentUser->id, $id);
 $model =  $this->jobRosterActivityRepo->insert([
    'guard_id' => $this->currentUser->id,
    'job_roster_id' => $id,
    'job_incident_report_id' => null,
    'signin_time' => $this->request->input('time'),
    'signin_selfie' => $media,
    'location' => $this->request->input('location'),
    'status' => 1,
    'signin_notes' => ($this->request->input('notes')) ? $this->request->input('notes') : ''
]);
 DB::table('job_new_roster')->where(['roster_id' => $id])->update(['update_status' => 1, 'signin_status' => 1]);
 $green_call_30 = DB::table('green_call')->where(['job_id' => $id, 'guard_id' =>  $this->currentUser->id])->first();
 $guard = DB::table('guards')->where('id',$this->currentUser->id)->first();
 if (empty($green_call_30)) {
    $notification = array(
        'guard_id' => $this->currentUser->id, 
        'record_id' => $id,
        'message' => $guard->name.' missed his/her 30 mints green call job at '. $job->site_name,
        'type' => 'greencall_missed',
        'send_time' => time(),
        'title' => 'Green Call Missed'
    );
    DB::table('portal_notifications')->insert($notification);
    $administrators = DB::table('portal_settings')
    ->where('permission_name', 'green_call_miss')
    ->where('permission', 1)
    ->first();
    if (!empty($administrators)) {
        $admins = explode(',', $administrators->users_emails);
        foreach ($admins as $key => $admin) {
            $email_data['name'] = '';
            $email_data['email'] = $admin;
            $this->notification->sendGuardMail($email_data, 'Green Call Missed', $guard->name.' missed his/her 30 minutes green call job at '. $job->site_name);
        }
    }
    
}
if ($model) {
    $notification = array(
        'guard_id' => $this->currentUser->id, 
        'record_id' => $id,
        'message' => $guard->name.' sign-in in his/her job at '. $job->site_name,
        'type' => 'job_signin',
        'send_time' => time(),
        'title' => 'Job Signin'
    );
    DB::table('roster_complete_activity')->insert([
        'roster_id' => $id,
        'activity' => $guard->name.' sign-in in his/her job',
        'type' => 'job_signin',
        'record_id' => $id,
        'activity_time' => time(),
        'activity_by' => $this->currentUser->id
    ]);
    $admin_tokens = DB::table('administrators')->where('notification_token', '!=', '')->where('notification_token', '!=', 'undefined')->select('notification_token')->get();
    if (count($admin_tokens) > 0) {
        foreach ($admin_tokens as $key => $t) {
            $not_data = array(
                'title' => 'Job Signin',
                'message' => $guard->name.' sign-in in his/her job at '. $job->site_name,
                'page' => 'home',
                'notification_token' => $t->notification_token
            );
            $this->notification->adminNotifiaction($not_data);
        }
    }
    DB::table('portal_notifications')->insert($notification);
    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'success' => true,
        'message' => 'Clocked-in Successfully!'
    ];
    return $this->sendResponse();
}
$this->statusCode = self::STATUS_CODE_200;
$this->response = [
    'success' => false,
    'message' => 'You are not Check-in your job.'
];
return $this->sendResponse();
}

public function jobSignout(Request $request, $id) {
    $this->request = $request;
    $this->setValidationRules(['time' => 'required', 'selfie' => 'required']);
    if ($this->isValidRequest()) {
        $this->response = ['success' => false, 'error' => $this->getErrors()];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
    
    
    $field = 'selfie'; $media = '';
        // if ($this->request->hasFile($field)) {
            // $files = $this->request->file($field);
            // $media = $this->uploader($files);
    $media = $this->uploader_base64($this->request->input($field));
        // }
    $signout_location = '';
    if ($request->has('location') && $request->location != '') {
        $job = new JobResource($this->repo->getJobById($request->jobId, $this->currentUser->id));
        $coordinates = explode(',', $request->input('location'));
        $coordinates1 = explode(',', $job->coordinates);
            // print_r($job->coordinates);
        $distance = $this->distance(trim($coordinates[0]), trim($coordinates[1]), trim($coordinates1[0]), trim($coordinates1[1]) );
        if($job->signin_radius > 0){
            $signin_radius = $job->signin_radius/1000;
        }else{
            $signin_radius = 0.31;
        }
        if($distance > $signin_radius){
            $this->response = ['success' => false, 'error' => 'You are '.number_format($distance, 2).' miles away from your job!', 'message' => 'You are '.number_format($distance, 2).' KM away from your job!'];
    
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }
        $signout_location = $request->coordinates;
    }
    $tasks_photos = [];
    if ($request->has('tasks_photos') && !empty($request->tasks_photos)) {
        $photos = json_decode($request->tasks_photos);
        foreach ($photos as $key => $tp) {
            $tasks_photos[] = $this->uploader_base64($tp);
        }
    }
    $model = $this->jobRosterActivityRepo->setStatusInactive($this->currentUser->id, $id, [
        'signout_time' => $this->request->input('time'),
        'signout_selfie' => $media,
        'status' => 0,
        'signout_location' => $signout_location,
        'signout_notes' => ($this->request->input('notes')) ? $this->request->input('notes') : '',
        'tasks_photos' => json_encode($tasks_photos)
    ]);

    if ($model) {
        DB::table('job_new_roster')->where('roster_id', $id)->update(['job_status' => 'completed', 'update_status' => 1, 'signin_status' => 0]);
        $guard = DB::table('guards')->where('id',$this->currentUser->id)->first();
        $notification = array(
            'guard_id' => $this->currentUser->id, 
            'record_id' => $id,
            'message' => $guard->name.' signout from his/her job.',
            'type' => 'job_signout',
            'send_time' => time(),
            'title' => 'Job Signout'
        );
        $this->guard_job_rating($id);
        $this->rosterCompleteActivityReport($id);
        DB::table('portal_notifications')->insert($notification);
        DB::table('roster_complete_activity')->insert([
            'roster_id' => $id,
            'activity' => $guard->name.' signout from his/her job.',
            'type' => 'job_signout',
            'record_id' => $id,
            'activity_time' => time(),
            'activity_by' => $this->currentUser->id
        ]);
        $admin_tokens = DB::table('administrators')->where('notification_token', '!=', '')->where('notification_token', '!=', 'undefined')->select('notification_token')->get();
        if (count($admin_tokens) > 0) {
            foreach ($admin_tokens as $key => $t) {
                $not_data = array(
                    'title' => 'Job Signout',
                    'message' => $guard->name.' signout from his/her job.',
                    'page' => 'home',
                    'notification_token' => $t->notification_token
                );
                $this->notification->adminNotifiaction($not_data);
            }
        }
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => true,
            'message' => 'Clocked-out Successfully!'
        ];
        return $this->sendResponse();
    }
    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'success' => false,
        'message' => 'You are not Check-out your job.'
    ];
    return $this->sendResponse();
}

private function uploader($file) {
    try {
            // $destinationPath =  rtrim(app()->basePath('public/asset_uploads/'), '/');
            // $destinationPath =  rtrim('../../asset_uploads/');
        $public_path = public_path();
        $public_path = str_replace('portal/public', '', $public_path);
        $public_path = str_replace('apis/public', '', $public_path);
        $destinationPath = $public_path.'asset_uploads/';
        $newName = Str::random(25);
        $fileName = $newName . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);
        return $fileName;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

private function uploader_base64($file) {
    try {
            // $destinationPath =  rtrim(app()->basePath('public/asset_uploads/'), '');
        $destinationPath =  rtrim('../../asset_uploads/');
            // $public_path = public_path();
            // $public_path = str_replace('portal/public', '', $public_path);
            // $public_path = str_replace('apis/public', '', $public_path);
            // $destinationPath = $public_path.'asset_uploads/';
        
        $newName = Str::random(25);
        
        $fileName = $newName . '.jpg';
        
        
        $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
        file_put_contents($destinationPath.$fileName, $file);
        
        return $fileName;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


public function report_incident(Request $request, $id) {
    $this->request = $request;
    $this->setValidationRules(['guard_id' => 'required', 'type' => 'required', 'detail' => 'required', 'notified_to' => 'required', 'injuries_incurred' => 'required', 'damage' => 'required', 'people_involved' => 'required', 'action_taken' => 'required', 'is_correct' => 'required']);
    if ($this->isValidRequest()) {
        $this->response = ['success' => false, 'error' => $this->getErrors()];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }

    $media = '';
    if ($this->request->input('image')) {
        $media = $this->uploader_base64($this->request->input('image'));
    }

    DB::table('job_incident_reports')->insert(['job_id' => $id, 'guard_id' => $this->request->input('guard_id'), 'type' => $this->request->input('type'), 'detail' => $this->request->input('detail'), 'notified_to' => $this->request->input('notified_to'), 'injuries_incurred' => $this->request->input('injuries_incurred'), 'damage' => $this->request->input('damage'), 'people_involved' => $this->request->input('people_involved'), 'action_taken' => $this->request->input('action_taken'), 'is_correct' => $this->request->input('is_correct'), 'detailed_description' => 'n/a', 'image' => $media, 'date_added' => time()]);

    $guard = DB::table('guards')->where('id', '=', $this->request->input('guard_id'))->first();
    $email_data['name'] = $guard->name;
    $email_data['email'] = $guard->email;
    $this->notification->sendGuardMail($email_data, 'New Incident Report', 'Incident Report successfully submited.');
    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'success' => true,
        'message' => 'Incident reported successfully!'
    ];
    return $this->sendResponse();
    
}



public function leave_request(Request $request, $id) {
    $this->request = $request;
    $this->setValidationRules(['start_date' => 'required', 'end_date' => 'required', 'notes' => 'required']);
    if ($this->isValidRequest()) {
        $this->response = ['success' => false, 'error' => $this->getErrors()];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }

    

    $record_id = DB::table('guard_leave_requests')->insertGetId(['guard_id' => $id, 'start' => strtotime($this->request->input('start_date')), 'end' => strtotime($this->request->input('end_date')), 'start_date' => $this->request->input('start_date'), 'end_date' => $this->request->input('end_date'), 'notes' => $this->request->input('notes'), 'date_added' => time()]);
    
    $guard = DB::table('guards')->where('id', $id)->first();
    DB::table('portal_notifications')->insert([
        'guard_id' => $id,
        'message' => $guard->name .' submited a leave request.',
        'type' => 'leave',
        'status' => 'unseen',
        'send_time' => time(),
        'record_id' => $record_id,
        'title' => 'New Leave Request'
    ]);
    DB::table('roster_complete_activity')->insert([
        'roster_id' => $id,
        'activity' => $guard->name .' submited a leave request.',
        'type' => 'leave_request',
        'record_id' => $record_id,
        'activity_time' => time(),
        'activity_by' => $id
    ]);
    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'success' => true,
        'message' => 'Leave request submitted successfully!'
    ];
    return $this->sendResponse();
    
}



public function get_leave_requests(Request $request, $id) {
   $this->request = $request;

   $requests = DB::table('guard_leave_requests')->where(['guard_id' => $id])->get();

   $list = array();
   foreach($requests as $req)
   {
    $list[] = array('start' => date('d-m-Y H:i', $req->start), 'end' => date('d-m-Y H:i', $req->end), 'notes' => $req->notes, 'date_added' => date('d-m-Y H:i', $req->date_added), 'leave_id' => $req->id);
}


$this->statusCode = self::STATUS_CODE_200;
$this->response = [
    'success' => true,
    'message' => 'Leave requests',
    'list' => $list
];
return $this->sendResponse();

}



public function get_incident_reports(Request $request, $id) {
    $this->request = $request;
    

    
    $reports = DB::table('job_incident_reports')->
    join('job_roster_activities', 'job_roster_activities.job_roster_id', '=', 'job_incident_reports.roster_id')
    ->where(['job_incident_reports.guard_id' => $id, 'job_incident_reports.job_id' => $this->request->input('job_id'), 'job_roster_activities.job_roster_id' => $this->request->input('roster_id'), 'job_incident_reports.roster_id' => $this->request->input('roster_id')])->get();
    if (empty($reports)) {

       $reports = DB::table('job_incident_reports')->
       join('job_roster_activities', 'job_roster_activities.job_incident_report_id', '=', 'job_incident_reports.id')
       ->where(['job_incident_reports.guard_id' => $id, 'job_incident_reports.job_id' => $this->request->input('job_id'), 'job_roster_activities.job_roster_id' => $this->request->input('roster_id')])->get();
   }

   $list = array();


   foreach($reports as $rep){
    $images = array();
    if ($rep->image != '') {
        $imgs = json_decode($rep->image, true);
        if (is_array($imgs) && !empty($imgs)) {
            foreach ($imgs as $key => $value) {
                $images[] = 'https://'.request()->getHttpHost().'/asset_uploads/'.$value;
                
            }
        }else{
            $images[] = 'https://'.request()->getHttpHost().'/asset_uploads/'.$rep->image;
        }
    }
    {
        $list[] = array('job_id' => $rep->job_id, 'guard_id' => $rep->guard_id, 'type' => $rep->type, 'detail' => $rep->detail, 'notified_to' => $rep->notified_to, 'injuries_incurred' => $rep->injuries_incurred, 'damage' => $rep->damage, 'people_involved' => $rep->people_involved, 'action_taken' => $rep->action_taken, 'is_correct' => $rep->is_correct, 'detailed_description' => 'n/a', 'image' => $images, 'date_added' => date('d-m-Y H:i', $rep->date_added));
    }

}

$reports = DB::table('incident_reports')
->where('job_id', $this->request->input('job_id'))
->where('guard_id', $id)
->where('roster_id', $this->request->input('roster_id'))
->get();

foreach($reports as $rep){
    $images = array();
    if ($rep->photo != '') {
        $imgs = json_decode($rep->photo, true);
        if (is_array($imgs) && !empty($imgs)) {
            foreach ($imgs as $key => $value) {
                $images[] = 'https://'.request()->getHttpHost().'/asset_uploads/'.$value;
                
            }
        }else{
            $images[] = 'https://'.request()->getHttpHost().'/asset_uploads/'.$rep->photo;
        }
    }
    {
        $list[] = array('job_id' => $rep->job_id, 'guard_id' => $rep->guard_id, 'type' => $rep->injury_type, 'detail' => $rep->injury_detail, 'notified_to' => '', 'injuries_incurred' => '', 'damage' => '', 'people_involved' => count(json_decode($rep->people_involved, true)), 'action_taken' => '', 'is_correct' => '', 'detailed_description' => 'n/a', 'image' => $images, 'date_added' => $rep->incident_date .' '. $rep->incident_time);
    }

}


$this->statusCode = self::STATUS_CODE_200;
$this->response = [
    'success' => true,
    'message' => 'Incident reports',
    'list' => $list
];
return $this->sendResponse();

}



public function green_call_coordinates(Request $request, $id) {
    $this->request = $request;
    $status = $request->input('status');
    $job_id = explode(',', $request->input('job_id'));
        // $status = ($request->input('status') != null) ? $request->input('status') : 'no';
    $greenCall_id = $this->greenCall->insertGetId([
        'coordinates' => $request->input('coordinates'),
        'job_id' => $job_id[0],
        'guard_id' => $id,
        'status' => $status,
        'before_time' => $job_id[1]
    ]);
    $guard = DB::table('guards')->where('id', $id)->first();
    DB::table('portal_notifications')->insert([
        'guard_id' => $id,
        'message' => $guard->name .' submitted Green Call before '. $job_id[1],
        'type' => 'green_call',
        'status' => 'unseen',
        'send_time' => time(),
        'record_id' => $job_id[0],
        'title' => 'Green call'
    ]);
    DB::table('roster_complete_activity')->insert([
        'roster_id' => $job_id[0],
        'activity' => 'Green Call before '. $job_id[1],
        'type' => 'green_call',
        'record_id' =>  $greenCall_id,
        'activity_time' => time(),
        'activity_by' => $id
    ]);
    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'success' => true,
        'message' => 'Location reported successfully!',
        'coordinates' => $this->request->input('coordinates'),
        'job_id' => $job_id[0],
        'guard_id' => $id
    ];
    return $this->sendResponse();
    
}
public function check_welfare_call(Request $request, $id) {
    $this->request = $request;
    $job_roster = DB::table('job_new_roster')->where('roster_id',$request->input('job_id'))->first();
    if (!empty($job_roster) && $job_roster->last_send_welfare_call > 0) {
        $is_already = DB::table('welfare_call_data')->where('response_time', '>', $job_roster->last_send_welfare_call)->first();
    }else{
        $is_already = array();
    }
    // $is_already = DB::table('welfare_call_data')
    // ->join('job_new_roster', 'job_new_roster.roster_id', '=', 'welfare_call_data.job_roster_id')
    // // ->where('job_new_roster.last_send_welfare_call' , '<', 'welfare_call_data.response_time')
    // ->where('welfare_call_data.response_time' , '>', 'job_new_roster.last_send_welfare_call')
    // ->where('job_new_roster.roster_id', $request->input('job_id'))
    // ->where('job_new_roster.guard_id', $id)
    // ->orderBy('welfare_call_data.response_time', 'DESC')
    // ->first();

    if (!empty($is_already)) {
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => false,
            'message' => 'Welfare call response already submited!',
        ];
    }else{
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => true,
            'message' => 'Welfare call response pending.',
        ];
    }
    return $this->sendResponse();
}

public function welfare_call(Request $request, $id) {
    $this->request = $request;
    $jobId = DB::table('job_new_roster')->where('roster_id', $request->input('job_id'))->value('site_id');
    $job = new JobResource($this->repo->getJobById($jobId, $this->currentUser->id));
    if (!$request->has('coordinates') || $request->coordinates == '') {
        $coordinates = explode(',', '0,0');
    }else{
        $coordinates = explode(',', $request->input('coordinates'));
    }
    $coordinates1 = explode(',', $job->coordinates);
    $distance = $this->distance(trim($coordinates[0]), trim($coordinates[1]), trim($coordinates1[0]), trim($coordinates1[1]) );
    if($job->alert_radius > 0){
        $alert_radius = $job->alert_radius/1000;
    }else{
        $alert_radius = 0.18;
    }
    if($distance > $alert_radius)
    {
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => false,
            'message' => 'You are out of radius!',
            'coordinates' => $this->request->input('coordinates'),
            'job_id' => $this->request->input('job_id'),
            'guard_id' => $id
        ];
        return $this->sendResponse();
    }

    $data = array(
        'coordinates' => $request->input('coordinates'),
        'job_roster_id' => $request->input('job_id'),
        'guard_id' => $id,
        'status' => $request->input('status'),
        'notes' => $request->input('notes'),
        'response_time' => time()
    );
    $guard = DB::table('guards')->where('id', $id)->first();
    $result = DB::table('welfare_call_data')->insertGetId($data);
    if($result != ''){
        DB::table('roster_complete_activity')->insert([
            'roster_id' => $request->input('job_id'),
            'activity' => 'Welfare Call',
            'type' => 'welfare_call',
            'record_id' =>  $result,
            'activity_time' => time(),
            'activity_by' => $id
        ]);
        DB::table('portal_notifications')->insert([
            'guard_id' => $id,
            'message' => $guard->name .' submitted Welfare Call',
            'type' => 'welfare_call',
            'status' => 'unseen',
            'send_time' => time(),
            'record_id' => $request->input('job_id'),
            'title' => 'Welfare call'
        ]);
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => true,
            'message' => 'Welfare call log successfully!',
            'coordinates' => $this->request->input('coordinates'),
            'job_id' => $this->request->input('job_id'),
            'guard_id' => $id
        ];
    }else{
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => false,
            'message' => 'Fail to log Welfare call!',
            'coordinates' => $this->request->input('coordinates'),
            'job_id' => $this->request->input('job_id'),
            'guard_id' => $id
        ];
    }
    return $this->sendResponse();
    
}

function distance($lat1, $lon1, $lat2, $lon2)
{   
    $lat1 = doubleval($lat1);
    $lon1 = doubleval($lon1);
    $lat2 = doubleval($lat2);
    $lon2 = doubleval($lon2);

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $miles = $miles * 1.609;
    

    return $miles;

}
public function saveGuardLocation(Request $request, $id)
{
    $this->request = $request;
    $in_radius = true;
    $this->setValidationRules(['time' => 'required', 'location' => 'required', 'jobId' => 'required']);
    if ($this->isValidRequest()) {
        $this->response = ['success' => false, 'error' => $this->getErrors()];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
    $job = new JobResource($this->repo->getJobById($request->input('jobId'), $this->currentUser->id));
    $last_send_notification = User::where('id', $this->currentUser->id)->value('last_send_notification');
    $diff = 4;
    if ($last_send_notification != null) {
        $to_time = time();
        $from_time = $last_send_notification;
        $diff = round(abs($to_time - $from_time) / 60,2);
    }
    User::where('id', $this->currentUser->id)->update(['last_seen' => time()]);
    if (!$request->has('location') || $request->location == '') {
        $coordinates = explode(',', '0,0');
    }else{
        $coordinates = explode(',', $request->input('location'));
    }
    $coordinates1 = explode(',', $job->coordinates);
    $internet_enabled = true;
    if ($request->has('internet_enabled') && ($request->internet_enabled == 'false' || $request->internet_enabled == 'false')) {
        $internet_enabled = false;
    }
        // print_r($job->coordinates);
    $distance = $this->distance(trim($coordinates[0]), trim($coordinates[1]), trim($coordinates1[0]), trim($coordinates1[1]) );
    if($job->alert_radius > 0){
        $alert_radius = $job->alert_radius/1000;
    }else{
        $alert_radius = 0.18;
    }
    $signin_activity = DB::table('job_roster_activities')
    ->where(['guard_id' => $job->jobRoster[0]->guard_id, 'job_roster_id' => $id, 'status' => 1])
    ->first();
    if (empty($signin_activity)) {
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => false,
            'message' => 'Job Already completed!',
            'signin_status' => 0
        ];
        return $this->sendResponse();
    }
    $same_time = false;
        // || ($request->has('appClose') && ($request->appClose == true || $request->appClose == 'true') && $request->appClose != false && $request->appClose != 'false')
    if ($request->has('location_enabled') && ($request->location_enabled == 'false' || $request->location_enabled == 'false')) {

        if (($request->location_enabled == 'false' || $request->location_enabled == 'false')) {
            $same_time = true;
            DB::table('job_roster_activities')->where(['guard_id' => $job->jobRoster[0]->guard_id, 'job_roster_id' => $id, 'status' => 1])->update(['last_location_time' => $request->timestamp, 'last_location' => $request->location]);
        }
            // elseif($request->has('appClose') && ($request->appClose == true || $request->appClose == 'true') && $request->appClose != false && $request->appClose != 'false'){
            //     $same_time = true;
            // }
    }
                // if ($request->has('appClose') && ($request->appClose == true || $request->appClose == 'true') && $request->appClose != false && $request->appClose != 'false') {
            // $guard = DB::table('guards')->where('id', $job->jobRoster[0]->guard_id)->first();
            // $job1 = DB::table('jobs')->where('id', $request->input('jobId'))->first();
                // $same_time = true;

            // $notification = array(
            //     'guard_id' => $job->jobRoster[0]->guard_id, 
            //     'record_id' => $id,
            //     'message' => $guard->name.' just closed his/her app at '. $job1->site_name,
            //     'type' => 'leave_location',
            //     'send_time' => time(),
            //     'title' => 'Guard close his/her App'
            // );
            // DB::table('portal_notifications')->insert($notification);

            // DB::table('roster_complete_activity')->insert([
            //     'roster_id' => $id,
            //     'activity' => $guard->name.' just closed his/her app at location.',
            //     'type' => 'leave_location',
            //     'record_id' =>  $id,
            //     'activity_time' => time(),
            //     'activity_by' => $job->jobRoster[0]->guard_id
            //     ]);
        // }else
    if($internet_enabled == true && $request->location != '0,0' && ($distance > $alert_radius && $job->jobRoster[0]->break_status == 0 && !empty($signin_activity))) {
        // if(($distance > $alert_radius && $job->jobRoster[0]->break_status == 0 && !empty($signin_activity)) && $same_time == false){
        $this->guardJobActivityRepo->insert([
            'roster_id' => $id,
            'guard_id' => $job->jobRoster[0]->guard_id,
            'job_id' => $request->input('jobId'),
            'coordinates' => $request->input('location'),
            'event_time' => $request->input('time'),
            'distance' => round($distance, 2),
            'seen_status' => 'unseen'
        ]);
        $in_radius = false;

        $guard = DB::table('guards')->where('id', $job->jobRoster[0]->guard_id)->first();
        $job1 = DB::table('jobs')->where('id', $request->input('jobId'))->first();
        $notification = array(
            'guard_id' => $job->jobRoster[0]->guard_id, 
            'record_id' => $id,
            'message' => $guard->name.' leave his/her location at '. $job1->site_name,
            'type' => 'leave_location',
            'send_time' => time(),
            'title' => 'Guard Leave his/her Site'
        );
        if ($diff > 3) {
        User::where('id', $this->currentUser->id)->update(['last_send_notification' => time()]);
        DB::table('portal_notifications')->insert($notification);
        }

        DB::table('roster_complete_activity')->insert([
            'roster_id' => $id,
            'activity' => $guard->name.' leave his/her location.',
            'type' => 'leave_location',
            'record_id' =>  $id,
            'activity_time' => time(),
            'activity_by' => $job->jobRoster[0]->guard_id
        ]);
    }elseif ($same_time) {
        $guard = DB::table('guards')->where('id', $job->jobRoster[0]->guard_id)->first();
        $job1 = DB::table('jobs')->where('id', $request->input('jobId'))->first();
        $notification = array(
            'guard_id' => $job->jobRoster[0]->guard_id, 
            'record_id' => $id,
            'message' => $guard->name.' maybe turned off their GPS or close the app at '. $job1->site_name,
            'type' => 'leave_location',
            'send_time' => time(),
            'title' => 'Guard turned off GPS or close their app'
        );
        if ($diff > 3) {
        User::where('id', $this->currentUser->id)->update(['last_send_notification' => time()]);
        DB::table('portal_notifications')->insert($notification);
    }
        DB::table('roster_complete_activity')->insert([
            'roster_id' => $id,
            'activity' => $guard->name.' maybe turned off their GPS or close the app.',
            'type' => 'leave_location',
            'record_id' =>  $id,
            'activity_time' => time(),
            'activity_by' => $job->jobRoster[0]->guard_id
        ]);
    }
    elseif($internet_enabled == true && $request->location == '0,0')
    {
        $guard = DB::table('guards')->where('id', $job->jobRoster[0]->guard_id)->first();
        $job1 = DB::table('jobs')->where('id', $request->input('jobId'))->first();
        $notification = array(
            'guard_id' => $job->jobRoster[0]->guard_id, 
            'record_id' => $id,
            'message' => 'Due to some reason we are not able to track guard at '. $job1->site_name,
            'type' => 'internet',
            'send_time' => time(),
            'title' => 'Technical Issue'
        );
        if ($diff > 3) {
        User::where('id', $this->currentUser->id)->update(['last_send_notification' => time()]);
        DB::table('portal_notifications')->insert($notification);
    }
        DB::table('roster_complete_activity')->insert([
            'roster_id' => $id,
            'activity' => 'Due to some reason we are not able to track guard.',
            'type' => 'internet',
            'record_id' =>  $id,
            'activity_time' => time(),
            'activity_by' => $job->jobRoster[0]->guard_id
        ]);   
    }
    User::where('id', $this->currentUser->id)->update(['in_radius' => $in_radius]);

    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'success' => true,
        'message' => 'Event Log successfull.',
        'inRadius' => $in_radius,
        'signin_status' => 1
    ];
    return $this->sendResponse();
}

public function report_new_incident(Request $request, $id) {

    $this->request = $request;
    $this->setValidationRules(['guard_id' => 'required', 'incident_date' => 'required', 'incident_time' => 'required', 'incident_type' => 'required', 'physical_contact_involved' => 'required', 'injury' => 'required', 'people_involved' => 'required', 'recovery_value' => 'required', 'loss_value' => 'required']);
    if ($this->isValidRequest()) {
        $this->response = ['success' => false, 'error' => $this->getErrors()];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }

    $media = array();
    if ($this->request->input('photo')) {
        $photo = json_decode($this->request->input('photo'), true);
        if (is_array($photo) && !empty($photo)) {
            foreach ($photo as $key => $value) {
                $media[] = $this->uploader_base64($value);
            }
        }else{
            $media[] = $this->uploader_base64($this->request->input('photo'));

        }
    }
    $signature = '';
    if ($this->request->input('signature')) {
        $signature = $this->uploader_base64($this->request->input('signature'));
    }
        //$roster = DB::table('job_new_roster')->where('roster_id', $id)->select('site_id')->first();

        //$id = $roster->site_id;
    $data = array(
        'job_id' => $id,
        'guard_id' => $this->request->input('guard_id'),
        'incident_date' => $this->request->input('incident_date'),
        'incident_time' => $this->request->input('incident_time'),
        'incident_type' => $this->request->input('incident_type'), 
        'type' => $this->request->input('incident_type'), 
        'physical_contact_involved' => $this->request->input('physical_contact_involved'),
        'weapon_involved' => $this->request->input('weapon_involved'), 
        'people_involved' => $this->request->input('people_involved'), 
        'injury' => $this->request->input('injury'), 
        'recovery_value' => $this->request->input('recovery_value'), 
        'loss_value' => $this->request->input('loss_value'), 
        'image' => json_encode($media),
        'signature' => $signature,
        'description' => $this->request->input('description'), 
        'detail' => $this->request->input('description'),
        'exit' => $this->request->input('exit'),
        'date_added' => time(), 
        'notified_to' => '', 
        'injuries_incurred' => $this->request->input('injury'), 
        'damage' => '', 
        'action_taken' => '', 
        'detailed_description' => $this->request->input('description'),
        'roster_id' => $this->request->input('roster_id')
    );

    $guard = DB::table('guards')->where('id', $this->request->input('guard_id'))->first();
    $job = DB::table('jobs')->where('id', $id)->first();
    $notification = array(
        'guard_id' => $this->request->input('guard_id'), 
        'record_id' => $this->request->input('roster_id'),
        'message' => $guard->name.' report new incident at '. $job->site_name,
        'type' => 'incident_report',
        'send_time' => time(),
        'title' => 'Report New Incident'
    );
    DB::table('portal_notifications')->insert($notification);
    if($this->request->input('physical_contact_involved') == 'yes')
    {
        $data['physical_contact_details'] = $this->request->input('physical_contact_detail');
    }else{
            // $data['physical_contact_details'] = '';
    }
    if($this->request->input('weapon_involved') == 'yes')
    {
        $data['weapon_types'] = $this->request->input('weapon_types');
    }else{
            // $data['weapon_types'] = '';
    }
    if($this->request->input('injury') == 'yes')
    {
        $data['injurie_details'] = $this->request->input('injurie_details');
    }else{
            // $data['injurie_details'] = '';
    }

    $job_incident_report_id = DB::table('job_incident_reports')->insertGetId($data);
    
    DB::table('job_roster_activities')->where('job_roster_id', $this->request->input('roster_id'))->where('guard_id', $this->request->input('guard_id'))->update(['job_incident_report_id' => $job_incident_report_id]);
    $people_involved_detail = json_decode($this->request->input('people_involved_detail'), true);
        // print_r($people_involved_detail);
        // exit();
    if($this->request->input('people_involved') > 0){
        foreach ($people_involved_detail as $details) {
            DB::table('job_incident_report_details')->insert([
                'job_incident_report_id' => $job_incident_report_id,
                'description' => $details['description'],
                'clothing_bottom' => $details['clothing_bottom'],
                'facial_hair' => $details['facial_hair'],
                'hair' => $details['hair'], 
                'height' => $details['height'],
                'build' => $details['build'],
                'gender' => $details['gender'],
                'age' => $details['age'],
                'appearace' => $details['appearace'],
                'dob' => $details['dob'],
                'phone' => $details['phone'],
                'name' => $details['name'],
                'was_involved_as' => $details['was_involved_as']
            ]);
        }
    }
    DB::table('roster_complete_activity')->insert([
        'roster_id' => $this->request->input('roster_id'),
        'activity' => $guard->name.' report new incident',
        'type' => 'incident_report',
        'record_id' => $job_incident_report_id,
        'activity_time' => time(),
        'activity_by' => $this->request->input('guard_id')
    ]);
    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'success' => true,
        'message' => 'Incident reported successfully!'
    ];
    return $this->sendResponse();
    
}

public function update_leave_request(Request $request, $action,  $id) {
    $this->request = $request;

    $leave_data = DB::table('guard_leave_requests')->where('id', $this->request->input('leave_id'))->first();
    if($leave_data->status == 'approved')
    {
        $this->response = ['success' => false, 'error' => "Sorry, you can't do anything now"];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
    if($action == 'delete')
    {
        DB::table('guard_leave_requests')->where('id', $this->request->input('leave_id'))->delete(); 
    }else{
        $this->setValidationRules(['start_date' => 'required', 'end_date' => 'required', 'notes' => 'required']);
        if ($this->isValidRequest()) {
            $this->response = ['success' => false, 'error' => $this->getErrors()];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }
        DB::table('guard_leave_requests')->where('id', $this->request->input('leave_id'))->update(['guard_id' => $id, 'start' => strtotime($this->request->input('start_date')), 'end' => strtotime($this->request->input('end_date')), 'start_date' => $this->request->input('start_date'), 'end_date' => $this->request->input('end_date'), 'notes' => $this->request->input('notes')]);
    }

    
    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'success' => true,
        'message' => 'Leave request update successfully!'
    ];
    return $this->sendResponse();
    
}

public function getAsapJobs() {
    $results = $this->jobRosterRepo->getAsapJobs($this->currentUser->id);
    return new JobRosterCollection(JobRosterResource::collection($results));
}
public function accept_asap_job(Request $request, $id)
{
    $a = null;
    $b = '';
    $roster = DB::table('job_new_roster')
    ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
    ->where('post_status', '=', '1')
    ->where('roster_id', '=', $request->input('roster_id'))->where(
      function ($query) use ($a, $b) {
          return $query->where('guard_id', '=', $a)
          ->orWhere('guard_id', '=', $b);
      }
  )
    ->select('job_new_roster.*', 'jobs.id as jobId', 'jobs.address', 'jobs.coordinates')
    ->first();
    //   print_r($roster);
    //   exit();
    if($roster != null){
        $flag = 0;
        $is_already_assign = DB::table('job_new_roster')
        ->where('guard_id', $id)
        ->whereBetween('temp_start', [$roster->temp_start, $roster->temp_end])
        ->select('job_new_roster.*')->first();
        if($is_already_assign != null){
            $flag = 1;
        }else{
            $is_already_assign = DB::table('job_new_roster')
            ->where('guard_id', $id)
            ->whereBetween('temp_end', [$roster->temp_start, $roster->temp_end])
            ->select('job_new_roster.*')->first();
            if($is_already_assign != null){
                $flag = 1;
            }
        }
        if($flag == 0){
            DB::table('job_new_roster')
            ->where('roster_id', '=', $request->input('roster_id'))
            ->update(['guard_id' => $id, 'update_status' => 1, 'publish_status' => 1, 'job_status' => 'confirmed']);
            $guard = DB::table('guards')->where('id', $id)->first();
            $notification = array(
                'guard_id' => $id, 
                'record_id' => $request->input('task_id'),
                'message' => $guard->name.' accepted and confirmed the job.',
                'type' => 'job_accept',
                'send_time' => time(),
                'title' => 'Accept ASAP Job',
                'record_id' => $request->input('roster_id')
            );
            DB::table('portal_notifications')->insert($notification);
            $this->statusCode = self::STATUS_CODE_200;
            $this->response = [
                'success' => true,
                'message' => 'Job accept successfully.'
            ];
        }else{
            $this->statusCode = self::STATUS_CODE_200;
            $this->response = [
                'success' => false,
                'message' => 'These timings are contradicting with other site timings because this guard is already added in another site.'
            ];
        }
    }else{
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => false,
            'message' => 'Job already accepted!'
        ];
    }
    return $this->sendResponse();
}
function auto_sign_out(Request $request)
{
    $current_time = time();
        // $closeTime = $current_time;
    $closeTime = $current_time + (60*60+24);
    $not_signout_shifts = DB::table('job_roster_activities')
    ->join('job_new_roster', 'job_roster_activities.job_roster_id', '=','job_new_roster.roster_id')
    ->where('job_roster_activities.status', 1)
    ->where('job_new_roster.temp_end','<=',date('Y-m-d H:i:s', $closeTime))
    // ->where('job_new_roster.temp_end','!=','')
    ->where('job_new_roster.temp_end','!=',null)
    ->select('job_roster_activities.id', 'job_roster_activities.job_roster_id', 'job_new_roster.temp_end')->get();
    $counter = 0;
    foreach ($not_signout_shifts as $not_closed) {

        $job_end_time = $not_closed->temp_end;
        $job_end_time = strtotime($job_end_time);
        $current_time = time();
        $diff = round(($current_time - $job_end_time) / 60,2);
        if ($diff > 30) {
            DB::table('job_roster_activities')->where('id', $not_closed->id)->update(['signout_time' => date('Y-m-d H:i:s'), 'auto_signout' => 1, 'status' => 0]);
            DB::table('job_new_roster')->where('roster_id', $not_closed->job_roster_id)->update(['job_status' => 'completed', 'signin_status' => 0]);
            DB::table('roster_complete_activity')->insert([
                'roster_id' => $not_closed->job_roster_id,
                'activity' => 'Auto signout from the job.',
                'type' => 'auto_signout',
                'record_id' => $not_closed->id,
                'activity_time' => time(),
                'activity_by' => ''
            ]);
            $this->guard_job_rating($not_closed->job_roster_id);
            $counter++;
        }
    }
    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'success' => true,
        'message' => 'Signout successfully',
        'closed_shifts' => $counter
    ];
    return $this->sendResponse();
}
public function confirm_task(Request $request,$id)
{
 $this->setValidationRules(['task_id' => 'required', 'roster_id' => 'required', 'complete_time' => 'required', 'location' => 'required']);
 if ($this->isValidRequest()) {
    $this->response = ['success' => false, 'error' => $this->getErrors()];
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}
        // DB::table('job_new_roster')->where('roster_id', )->update(['job_status' => 'completed']);
DB::table('job_roster_tasks')
->where(['roster_id' => $request->input('roster_id'), 'id' => $request->input('task_id')])
->update(['guard_id' => $id, 'task_complete_time' => $request->input('complete_time'), 'status' => 'confirmed', 'location' => $request->input('location')]);
$guard = DB::table('guards')->where('id', $id)->first();
$notification = array(
    'guard_id' => $id, 
    'record_id' => $request->input('roster_id'),
    'message' => $guard->name.' confirmed its task.',
    'type' => 'task',
    'send_time' => time(),
    'title' => 'Task Confirmation'
);
DB::table('portal_notifications')->insert($notification);
$this->statusCode = self::STATUS_CODE_200;
$this->response = [
    'success' => true,
    'message' => 'Task confirmed successfully!'
];
return $this->sendResponse();
}
function time_into_decimal($time)
{
    $time = explode(':', $time);
    if (isset($time[1])) {
        $time[1] = $time[1]/60;
    }else{
        $time[1] = 0;
    }
    return ($time[0] * 1) + $time[1];
}

public function start_task(Request $request,$id)
{
 $this->setValidationRules(['task_id' => 'required', 'roster_id' => 'required', 'start_time' => 'required', 'location' => 'required']);
 if ($this->isValidRequest()) {
    $this->response = ['success' => false, 'error' => $this->getErrors()];
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}
$task = DB::table('job_roster_tasks')->where(['id' => $request->task_id, 'roster_id' => $request->roster_id])->first();
$guard = DB::table('guards')->where('id', $id)->first();
if ($guard->state != '') {
    config(['app.timezone' => $this->timezone[$guard->state]]);
    date_default_timezone_set($this->timezone[$guard->state]);
}

$current_time = $this->time_into_decimal(date('H:i', time()));
$task_time = $this->time_into_decimal($task->task_time);
$diff = ($current_time - $task_time) * 60;
if ($diff > 30) {
    $this->response = ['success' => false, 'error' => 'You can\'t start a task!'];
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}
$active_task = DB::table('job_roster_tasks')->where('start_time','!=', '')->where('end_time', '=', '')->where('guard_id', '=', $id)->where('roster_id', '=', $request->input('roster_id'))->first();
if (!empty($active_task)) {
    $this->response = ['success' => false, 'error' => 'Please complete you previous task first!'];
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}
        // DB::table('job_new_roster')->where('roster_id', )->update(['job_status' => 'completed']);
DB::table('job_roster_tasks')
->where(['roster_id' => $request->input('roster_id'), 'id' => $request->input('task_id')])
->update(['guard_id' => $id, 'start_time' => $request->input('start_time'), 'start_location' => $request->input('location')]);
$guard = DB::table('guards')->where('id', $id)->first();
$notification = array(
    'guard_id' => $id, 
    'record_id' => $request->input('roster_id'),
    'message' => $guard->name.' start its task.',
    'type' => 'task',
    'send_time' => time(),
    'title' => 'Task start'
);
DB::table('portal_notifications')->insert($notification);
DB::table('roster_complete_activity')->insert([
    'roster_id' => $request->input('roster_id'),
    'activity' => $guard->name.' start its task.',
    'type' => 'task',
    'record_id' => $request->input('task_id'),
    'activity_time' => time(),
    'activity_by' => $id
]);
$this->statusCode = self::STATUS_CODE_200;
$this->response = [
    'success' => true,
    'message' => 'Task start successfully!'
];
return $this->sendResponse();
}

public function end_task(Request $request,$id)
{
 $this->setValidationRules(['task_id' => 'required', 'roster_id' => 'required', 'end_time' => 'required', 'location' => 'required']);
 if ($this->isValidRequest()) {
    $this->response = ['success' => false, 'error' => $this->getErrors()];
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}
        // DB::table('job_new_roster')->where('roster_id', )->update(['job_status' => 'completed']);
DB::table('job_roster_tasks')
->where(['roster_id' => $request->input('roster_id'), 'id' => $request->input('task_id')])
->update(['guard_id' => $id, 'end_time' => $request->input('end_time'), 'status' => 'completed', 'end_location' => $request->input('location')]);
$guard = DB::table('guards')->where('id', $id)->first();
$notification = array(
    'guard_id' => $id, 
    'record_id' => $request->input('roster_id'),
    'message' => $guard->name.' completed its task.',
    'type' => 'task',
    'send_time' => time(),
    'title' => 'Task Completion'
);
DB::table('portal_notifications')->insert($notification);
DB::table('roster_complete_activity')->insert([
    'roster_id' => $request->input('roster_id'),
    'activity' => $guard->name.' completed its task.',
    'type' => 'task',
    'record_id' => $request->input('task_id'),
    'activity_time' => time(),
    'activity_by' => $id
]);
$this->statusCode = self::STATUS_CODE_200;
$this->response = [
    'success' => true,
    'message' => 'Task completed successfully!'
];
return $this->sendResponse();
}

public function start_break(Request $request, $id)
{
    $this->setValidationRules(['notes' => 'required', 'roster_id' => 'required']);
    if ($this->isValidRequest()) {
        $this->response = ['success' => false, 'error' => $this->getErrors()];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
    $guard = DB::table('guards')->where('id', $id)->first();
    if ($guard->state != '') {
        config(['app.timezone' => $this->timezone[$guard->state]]);
        date_default_timezone_set($this->timezone[$guard->state]);
    }
    $job_signin_details = DB::table('job_roster_activities')->where(['guard_id' => $id, 'job_roster_id' => $request->input('roster_id')])->first();

    if ($job_signin_details) {
        if ($job_signin_details->status == 0) {
            $this->response = ['success' => false, 'error' => 'You can\'t take a break!'];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();    
        }else{
            $job_start_time = $job_signin_details->signin_time;
            $job_start_time = explode('GMT', $job_start_time);
            $job_start_time = strtotime($job_start_time[0]);
            $current_time = time();
            $diff = round(($current_time - $job_start_time) / (60 *60),2);
                // if ($diff < 4) {
                //     $this->response = ['success' => false, 'error' => 'You can take a break after 4 hours!'];
                //     $this->statusCode = self::STATUS_CODE_200;
                //     return $this->sendResponse();
                // }
        }

    }else{
        $this->response = ['success' => false, 'error' => 'You must be signin into you job to start break!'];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }

    $already_break = DB::table('job_breaks')->where(['guard_id' => $id, 'roster_id' => $request->input('roster_id')])->orderBy('id', 'desc')->first();
    if ($already_break) {
        if ($already_break->job_status == 1) {
            $this->response = ['success' => false, 'error' => 'You are already on a break!'];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }else{
            $job_start_time = $already_break->end_time;
            $job_start_time = strtotime($job_start_time);
            $current_time = time();
            $diff = round(($job_start_time - $current_time) / (60 *60),2);
            if ($diff < 4) {
                $this->response = ['success' => false, 'error' => 'You can take a break after 4 hours!'];
                $this->statusCode = self::STATUS_CODE_200;
                return $this->sendResponse();
            }
        }
    }
    $data = array(
        'roster_id' => $request->input('roster_id'),
        'guard_id' => $id,
        'start_time' => time(),
        'notes' => $request->input('notes'),
        'inform_to' => $request->input('inform'),
        'job_status' => 1, 
        'break_start_time' => time());
    DB::table('job_breaks')->insert($data);
    DB::table('job_new_roster')->where(['roster_id' => $request->input('roster_id'), 'guard_id' => $id])->update(['break_status' => 1]);
    DB::table('roster_complete_activity')->insert([
        'roster_id' => $request->input('roster_id'),
        'activity' => $guard->name.' start break.',
        'type' => 'break',
        'record_id' => $request->input('roster_id'),
        'activity_time' => time(),
        'activity_by' => $id
    ]);
    $this->response = ['success' => True, 'message' => 'Break start successfully.'];
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}


public function end_break(Request $request, $id)
{
    $this->setValidationRules(['roster_id' => 'required']);
    if ($this->isValidRequest()) {
        $this->response = ['success' => false, 'error' => $this->getErrors()];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
    $guard = DB::table('guards')->where('id', $id)->first();
    if ($guard->state != '') {
        config(['app.timezone' => $this->timezone[$guard->state]]);
        date_default_timezone_set($this->timezone[$guard->state]);
    }
    
    DB::table('job_breaks')->where(['roster_id' => $request->input('roster_id'), 'guard_id' => $id, 'job_status' => 1])->update(['job_status' => 0, 'end_time' => time(), 'break_end_time' => time(), 'break_end_notes' => ($request->has('notes') ? $request->notes : '')]);

    DB::table('job_new_roster')->where(['roster_id' => $request->input('roster_id'), 'guard_id' => $id])->update(['break_status' => 0]);
    DB::table('roster_complete_activity')->insert([
        'roster_id' => $request->input('roster_id'),
        'activity' => $guard->name.' end its break.',
        'type' => 'break',
        'record_id' => $request->input('roster_id'),
        'activity_time' => time(),
        'activity_by' => $id
    ]);
    $this->response = ['success' => True, 'message' => 'Break end successfully.'];
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();

}
public function get_admin_list(Request $request)
{
    $admin = DB::table('administrators')->where(['status' => 'active', 'access_level' => 'administrator'])->select('administrators.id', 'administrators.name')->get();
    $this->response = ['success' => True, 'message' => 'Admin list', 'data' => $admin];
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}
public function reject_asap_job(Request $request, $id)
{
    $guard = DB::table('guards')->where('id', $id)->first();
    $id = DB::table('asap_jobs_rejected')->insertGetId(['roster_id' => $request->input('roster_id'), 'guard_id' => $id]);
    if($id != ''){
        $notification = array(
            'guard_id' => $id, 
            'record_id' => $request->input('roster_id'),
            'message' => $guard->name.' rejected ASAP job.',
            'type' => 'job_reject',
            'send_time' => time(),
            'title' => 'Reject ASAP Job'
        );
        DB::table('portal_notifications')->insert($notification);
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => true,
            'message' => 'Job reject successfully.'
        ];
    }else{
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => false,
            'message' => 'Job not rejected!'
        ];
    }
    return $this->sendResponse();
}
private function getBaseUrl()
{
    $url = app()->make('request')->root();
    $url = str_replace('portal/public', '', $url);
    $url = str_replace('apis/public', '', $url);

    return $url;
}
public function get_foot_patrol_reports(Request $request, $id) {
    $this->request = $request;
    $list = array();
    $reports = DB::table('foot_patrol_reports')
    ->where('job_id', $this->request->input('job_id'))
    ->where('guard_id', $id)
    ->where('roster_id', $this->request->input('roster_id'))
    ->get();

    foreach($reports as $rep){
        $images = array();
        $signature = '';
        if ($rep->photo != '') {
            $imgs = json_decode($rep->photo, true);
            if (is_array($imgs) && !empty($imgs)) {
                foreach ($imgs as $key => $value) {
                    $newObject = new \stdClass();
                    $newObject->imgPath = $this->getBaseUrl() . 'asset_uploads/' .$value['imgPath'];
                    $newObject->timestamp = $value['timestamp'];
                    $images[] = $newObject;
                }
            }else{
                $images[] = $this->getBaseUrl() . 'asset_uploads/' . $rep->photo;
            }
        }
        if ($rep->signature != '') {
            $signature = $imageUrl = $this->getBaseUrl() . 'asset_uploads/' . $rep->signature;
        }
        // {
            $list[] = array('job_id' => $rep->job_id, 'guard_id' => $rep->guard_id, 'detail' => $rep->patrolling_detail, 'notified_to' => '', 'image' => $images, 'signature' => $signature,'site_name' => $rep->site_name);
        // }

    }


    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'success' => true,
        'message' => 'Incident reports',
        'list' => $list
    ];
    return $this->sendResponse();

}
public function footPatrolReport(Request $request, $id) 
{
    $this->request = $request;
    if(!isset($id) || $id == 0){
        return response()->json([
            'success' => false,
            'message' => 'Site not found'
        ], 500);
    }
    $this->setValidationRules(['guard_id' => 'required']);
    if ($this->isValidRequest()) {
        $this->response = ['success' => false, 'error' => $this->getErrors()];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }

    $media = array();
    if ($this->request->input('photo')) {
        $photo = json_decode($this->request->input('photo'), true);
        if (is_array($photo) && !empty($photo)) {
            foreach ($photo as $key => $value) {
                $newObject = new \stdClass();
                $newObject->imgPath = $this->uploader_base64($value['imgPath']);
                $newObject->timestamp = $value['timestamp'];
                $media[] = $newObject;
            }
        }
    }
    $signature = '';
    if ($this->request->input('signature')) {
        $signature = $this->uploader_base64($this->request->input('signature'));
    }
    $data = array(
        'job_id' => $id,
        'guard_id' => $this->request->input('guard_id'),
        'roster_id' => $this->request->input('roster_id'),
        'clicked_at' => $this->request->input('clicked_at'),
        'patrolling_detail' => $this->request->input('patrolling_detail'),
        'site_name' => $this->request->input('site_name'), 
        'photo' => json_encode($media),
        'signature' => $signature
    );
    $job_patrol_report_id = DB::table('foot_patrol_reports')->insertGetId($data);

    $guard = DB::table('guards')->where('id', $this->request->input('guard_id'))->first();
    $job = DB::table('jobs')->where('id', $id)->first();
    $main_roster = DB::table('job_new_roster')->where('roster_id', $this->request->input('roster_id'))->first();

    // $admins = DB::table('users')->where('status', 'active')->get();
    // if(count($admins) > 0){
    //     foreach ($admins as $key => $value) {
            $notification = array(
                'guard_id' => $this->request->input('guard_id'), 
                'record_id' => $this->request->input('roster_id'),
                'message' => $guard->first_name.' '.$guard->last_name.' reports foot patrol at '. $job->site_name,
                'type' => 'foot_patrol_report',
                'send_time' => time(),
                'title' => 'Foot Patrol Report',
                // 'send_to' => $value->id,
            );
            DB::table('portal_notifications')->insert($notification);
    //     }
    // }
    //push notification
    // $admins = DB::table('administrators')->where('notification_token', '!=', '')->select('notification_token')->get();
    // foreach($admins as $a)
    // {
    //     $notification_data = [
    //         'message' => $guard->first_name.' '.$guard->last_name.' report new foot patrol.',
    //         'title' => 'Foot Patrol Report',
    //         'fcm_token' => $a->notification_token,
    //         'page' => 'homepage',
    //         'roster_id' =>  $id
    //     ]; 
    //     // $this->notification->send_push_notification($notification_data);
    // }  
    // $this->statusCode = self::STATUS_CODE_200;
    return response()->json([
        'success' => true,
        'message' => 'Foot Patrol reported successfully!'
    ]);
}
public function report_incident_new(Request $request, $id) 
{
 $this->request = $request;
 $this->setValidationRules(['guard_id' => 'required', 'date' => 'required', 'time' => 'required']);
 if ($this->isValidRequest()) {
    $this->response = ['success' => false, 'error' => $this->getErrors()];
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}

$media = array();
if ($this->request->input('photo')) {
    $photo = json_decode($this->request->input('photo'), true);
    if (is_array($photo) && !empty($photo)) {
        foreach ($photo as $key => $value) {
            $media[] = $this->uploader_base64($value);
        }
    }else{
        $media[] = $this->uploader_base64($this->request->input('photo'));

    }
}
$signature = '';
if ($this->request->input('signature')) {
    $signature = $this->uploader_base64($this->request->input('signature'));
}
$data = array(
    'job_id' => $id,
    'guard_id' => $this->request->input('guard_id'),
    'roster_id' => $this->request->input('roster_id'),
    'incident_date' => $this->request->input('date'),
    'incident_time' => $this->request->input('time'),
    'site_name' => $this->request->input('site_name'), 
    'injury_type' => $this->request->input('injury_type'), 
    'injury_detail' => $this->request->input('injury_detail'),
    'people_involved' => $this->request->input('people_involved'), 
    'vehicle' => $this->request->input('vehicle'), 
    'emergency_services' => $this->request->input('emergency_services'), 
    'wittness' => $this->request->input('wittness'), 
    'photo' => json_encode($media),
    'signature' => $signature
);
$data['people_involved'] = str_replace('[{}]', '[]', $data['people_involved']);
$data['emergency_services'] = str_replace('[{}]', '[]', $data['emergency_services']);
$data['vehicle'] = str_replace('[{}]', '[]', $data['vehicle']);
$data['wittness'] = str_replace('[{}]', '[]', $data['wittness']);
$job_incident_report_id = DB::table('incident_reports')->insertGetId($data);

$guard = DB::table('guards')->where('id', $this->request->input('guard_id'))->first();
$job = DB::table('jobs')->where('id', $id)->first();
$notification = array(
    'guard_id' => $this->request->input('guard_id'), 
    'record_id' => $this->request->input('roster_id'),
    'message' => $guard->name.' report new incident at '. $job->site_name,
    'type' => 'incident_report',
    'send_time' => time(),
    'title' => 'Report New Incident'
);
DB::table('portal_notifications')->insert($notification);

DB::table('job_roster_activities')->where('job_roster_id', $this->request->input('roster_id'))->where('guard_id', $this->request->input('guard_id'))->update(['job_incident_report_id' => $job_incident_report_id]);
DB::table('roster_complete_activity')->insert([
    'roster_id' => $this->request->input('roster_id'),
    'activity' => $guard->name.' report new incident',
    'type' => 'incident_report',
    'record_id' => $job_incident_report_id,
    'activity_time' => time(),
    'activity_by' => $this->request->input('guard_id')
]);
$this->statusCode = self::STATUS_CODE_200;
$this->response = [
    'success' => true,
    'message' => 'Incident reported successfully!'
];
return $this->sendResponse();
}

public function guard_rating($guard_id){
    $rating_sum=DB::table('job_new_roster')->where('guard_id',$guard_id)->sum('job_rating');
    $job=DB::table('job_new_roster')->where('guard_id',$guard_id)->count();
    $rating=round($rating_sum/$job);
    DB::table('guards')->where('id',$guard_id)->update([
        'rating'=>$rating
    ]);
        // return $rating;
    return true;
}
public function guard_job_rating($roster_id)
{
  $rating=0;
  $job=DB::table('job_new_roster')
  ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
  ->join('job_roster_activities', 'job_roster_activities.job_roster_id', '=', 'job_new_roster.roster_id')
  ->where('job_new_roster.roster_id',$roster_id)->first();
    ///signin
  if((strtotime($job->temp_start) >= strtotime($this->gmt_to_date($job->signin_time))) && $job->signin_time!=null ){
    $diff=strtotime($job->temp_start) - strtotime($this->gmt_to_date($job->signin_time));
    
    if($diff/60 >=15){
        $rating+=16.6;
    }
    else{
        $rating+=15;
    }
}else{
  $rating+=0;
}
    //signout

if((strtotime($job->temp_end) <= strtotime($this->gmt_to_date($job->signout_time))) && $job->signout_time!=null ){
    $rating+=16.6;
}else{
    if($job->signout_time==null || $job->signout_time=='' ){
        $rating+=0;
    }else{
        $rating+=15;
    }
}
    //   green  call 

$green=DB::table('green_call')->where('job_id',$roster_id)->count();
if($green==2){
    $rating+=33.2;
}elseif($green==1){
    $rating+=16.6;
}else{
    $rating+=0;
}
            //    welfare call 

$green=DB::table('welfare_call_data')->where('job_roster_id',$roster_id)->count();
if($green==0){
    $rating+=0;
}else{
    $rating+=16.6;
}

            //status
$status=DB::table('job_new_roster')->where('roster_id',$roster_id)->first();
if($status->job_status=="completed" || $status->job_status=="confirmed" ){
    $rating+=16.6;
}else{
    $rating+=0;
}
DB::table('job_new_roster')->where('roster_id',$roster_id)->update([
    'job_rating'=>$rating
]);
            // return $rating;
$guard=DB::table('job_new_roster')->where('roster_id',$roster_id)->first();
$this->guard_rating($guard->guard_id);
return true;

}

public function gmt_to_date($gmt)
{
    $result=(object)[];
    $result->signin_time = $gmt;
    if(strpos($result->signin_time,'GMT')!==false){
        $result->signin_time_2= explode(" ",$result->signin_time);
        $result->signin_time_2=$result->signin_time_2[3].'-'. date('m',strtotime($result->signin_time_2[1])).'-'.$result->signin_time_2[2].' '.$result->signin_time_2[4];
    }
    else{
        if(strpos($result->signin_time,'M')!==false||strpos($result->signin_time,'T')!==false||strpos($result->signin_time,'W')!==false||strpos($result->signin_time,'F')!==false ||strpos($result->signin_time,'S')!==false)
        {
            $result->signin_time_2= explode(" ",$result->signin_time);
            $result->signin_time_2=$result->signin_time_2[3].'-'. date('m',strtotime($result->signin_time_2[1])).'-'.$result->signin_time_2[2].' '.$result->signin_time_2[4];
        }
        else{
            $result->signin_time_2=$result->signin_time;
        }
    }
    return $result->signin_time_2;
}
function rosterCompleteActivityReport($id)
{

}

public function testNotification()
{
    $admin_tokens = DB::table('administrators')->where('notification_token', '!=', '')->where('notification_token', '!=', 'undefined')->select('notification_token')->get();
        // dd($admin_tokens);
    
    if (count($admin_tokens) > 0) {
        foreach ($admin_tokens as $key => $t) {
            $not_data = array(
                'title' => 'Job Signout',
                'message' => 'Testing signout from his/her job.',
                'page' => 'home',
                'notification_token' => $t->notification_token
            );
            return $this->notification->adminNotifiaction($not_data);
        }
    }
}


}
