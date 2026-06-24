<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\DateFactory;
use Illuminate\Support\Carbon;

use DateTime;
use DatePeriod;
use DateInterval;


class Dashboard extends Controller
{
    //
    //public $currentUser;
    protected $timezone = array(
      'Victoria' => 'Australia/Melbourne',
      'New South Whales' => 'Australia/Sydney',
      'Queensland' => 'Australia/Brisbane',
      'Tasmania' => 'Australia/Hobart',
      'Western Australia' => 'Australia/Perth',
      'South Australia' => 'Australia/Adelaide',
      'ACT' => 'Australia/Canberra'
  );
    public function __construct()
    {

    }
    function server_time(){
        echo date('m/d/Y h:i a');
    }
    function updateTime()
    {
        // $roster_data = DB::table('job_new_roster')->where('update_time', 0)->get();
        // foreach ($roster_data as $key => $value) {
        //     $start = str_replace('T', ' ', $value->start);
        //     $start = explode('+', $start);
        //     $start = $start[0];

        //     $end = str_replace('T', ' ', $value->end);
        //     $end = explode('+', $end);
        //     $end = $end[0];

        //     $value->temp_start = $start;
        //     $value->temp_end = $end;
        //     $value->job_start = strtotime($start);
        //     $value->job_end = strtotime($end);

        //     DB::table('job_new_roster')->where('roster_id', $value->roster_id)->update([
        //         'temp_start' => $value->temp_start,
        //         'temp_end' => $value->temp_end,
        //         'job_start' => $value->job_start,
        //         'job_end' => $value->job_end,
        //         'update_time' => 1
        //     ]);
        // }
        // echo count($roster_data);
    }
    private function uploader_base64($file) {
        try {
            // $destinationPath =  rtrim(app()->basePath('public/asset_uploads/'), '');
            // $destinationPath =  rtrim('../../asset_uploads/');
            $public_path = public_path();
            $public_path = str_replace('portal/public', '', $public_path);
            $public_path = str_replace('apis/public', '', $public_path);
            $path = $public_path.'asset_uploads/';
            
            $newName = Str::random(25);
            
            $fileName = $newName . '.jpg';
            
            
            $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
            file_put_contents($path.$fileName, $file);
            
            return $fileName;
        } catch (Exception $e) {
            // echo $e->getMessage();
            return '';
        }
    }
    function mercy_hospital_signin_form(Request $request)
    {
        // $public_path = public_path();
        // $public_path = str_replace('portal/public', '', $public_path);
        // $public_path = str_replace('apis/public', '', $public_path);
        // $path = $public_path.'asset_uploads/';
        // $imageName = time().'.'.$request->image->extension();
        // $request->image->move($path, $imageName);
        if ($request->guard_id == 0 || $request->guard_id == '' || $request->guard_id == 'undefined') {
            return response()->json(['success' => false, 'message' =>  'Please select guard first!']);
        }
        $imageName = $this->uploader_base64($request->image);

        $date = time();
        $date = strtotime($request->signin_time);
        $guard = DB::table('guards')->where('id', $request->guard_id)->first();
        if ($request->type == 'core') {
            if ($request->core_action == 'signin') {
                $is_already_logged_in = DB::table('job_new_roster')
                ->where('guard_id', $request->guard_id)
                ->where('site_id', $request->site_id)
                ->where('job_end' , '=', '')
                ->where('signin_status', 1)
                ->first();
                if (!empty($is_already_logged_in)) {
                    return response()->json(['success' => false, 'message' =>  'You already signin in another job. First complete your previous job!']);
                }

                $start = date('Y-m-d H:i:s', $date);
                $start = str_replace(' ', 'T', $start) .'+10:00';
                $end = '';
                $event = DB::table('job_new_roster')->orderBy('event_id', 'desc')->first();
                $site = DB::table('jobs')->where('id', $request->site_id)->first();
                $roster = [
                    'event_id' => !empty($event) ? $event->event_id + 1 : 1,
                    'guard_id' => $request->guard_id,
                    'site_id' => $request->site_id,
                    'start' => $start,
                    'end' => $end,
                    'temp_date' => date('Y-m-d', $date),
                    'temp_start' => date('Y-m-d H:i:s', $date),
                    'temp_end' => '',
                    'publish_status' => 1,
                    'add_status' => 1,
                    'job_status' => 'confirmed',
                    'post_status' => 0,
                    'job_start' => $date,
                    'job_end' => '',
                    'signin_status' => 1
                ];
                $roster_id =  DB::table('job_new_roster')->insertGetId($roster);
                $activity = [
                    'guard_id' => $request->guard_id,
                    'job_roster_id' => $roster_id,
                    'signin_time' => $start,
                    'signin_selfie' => $imageName,
                    'location' => $site->coordinates,
                    'status' => 1
                ];
                DB::table('job_roster_activities')->insert($activity);
                DB::table('job_new_roster')->where('roster_id', $roster_id)->update(['signin_status' => 1]);
                return response()->json(['success' => true, 'message' =>  'Thanks '.$guard->name.', you are successfully signed-in. ']);
            }else{
                $site = DB::table('jobs')
                ->join('job_new_roster', 'job_new_roster.site_id', '=', 'jobs.id')
                ->where('job_new_roster.roster_id', $request->core_roster_id)->select('jobs.*')->first();
                $end = date('Y-m-d H:i:s', $date);
                $end = str_replace(' ', 'T', $end) .'+10:00';
                DB::table('job_new_roster')->where('roster_id', $request->core_roster_id)->update(
                    [
                        'end' => $end,
                        'temp_end' => date('Y-m-d H:i:s', $date),
                        'job_status' => 'completed',
                        'job_end' => $date,
                        'signin_status' => 0
                    ]);
                DB::table('job_roster_activities')->where('job_roster_id', $request->core_roster_id)->update(
                    [
                        'signout_time' => $end,
                        'status' => 0,
                        'signout_selfie' => $imageName,
                        'signout_location' => $site->coordinates
                    ]);
                return response()->json(['success' => true, 'message' =>  'Thanks '.$guard->name.', you are successfully signed-out. ']);
            }
        }else{
            if ($request->adhoc_action == 'signin') {
                $start = date('Y-m-d H:i:s', $date);
                $start = str_replace(' ', 'T', $start) .'+10:00';
                $roster_id =  $request->roster_id;
                $site = DB::table('jobs')
                ->join('job_new_roster', 'job_new_roster.site_id', '=', 'jobs.id')
                ->where('job_new_roster.roster_id', $roster_id)->select('jobs.*')->first();
                $activity = [
                    'guard_id' => $request->guard_id,
                    'job_roster_id' => $roster_id,
                    'signin_time' => $start,
                    'signin_selfie' => $imageName,
                    'location' => $site->coordinates,
                    'status' => 1
                ];
                DB::table('job_roster_activities')->insert($activity);
                DB::table('job_new_roster')->where('roster_id', $roster_id)->update(['signin_status' => 1]);
                return response()->json(['success' => true, 'message' =>  'Thanks '.$guard->name.', you are successfully signed-in. ']);
            }else{
                $site = DB::table('jobs')
                ->join('job_new_roster', 'job_new_roster.site_id', '=', 'jobs.id')
                ->where('job_new_roster.roster_id', $request->roster_id)->select('jobs.*')->first();
                $end = date('Y-m-d H:i:s', $date);
                $end = str_replace(' ', 'T', $end) .'+10:00';
                DB::table('job_new_roster')->where('roster_id', $request->roster_id)->update(
                    [
                        'job_status' => 'completed',
                        'signin_status' => 0
                    ]);
                DB::table('job_roster_activities')->where('job_roster_id', $request->roster_id)->update(
                    [
                        'signout_time' => $end,
                        'status' => 0,
                        'signout_selfie' => $imageName,
                        'signout_location' => $site->coordinates
                    ]);
                return response()->json(['success' => true, 'message' =>  'Thanks '.$guard->name.', you are successfully signed-out. ']);
            }
        }
    }

    function mercy_hospital(Request $request)
    {
        config(['app.timezone' => $this->timezone['Victoria']]);
        date_default_timezone_set($this->timezone['Victoria']);
        $core_guards = DB::table('guards')
        ->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')
        ->select('guards.id', 'guards.name')
        ->where('jobs_guards.job_id', 38)
        ->where('guards.status', 'active')
        ->where('guards.admin_approved', 1)
        ->get();
        $core_site = DB::table('jobs')->where('id', 38)->select('id', 'site_name', 'site_description', 'address')->first();
        $adhoc_sites = [12, 17, 21, 22, 31, 54, 77, 78, 81, 85, 87, 92, 93, 94, 95, 98, 100, 101, 102, 139, 149, 153, 154, 184, 193];

        $adhoc_guards = DB::table('guards')
        // ->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')
        ->join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')
        ->where('guards.status', 'active')
        ->select('guards.id', 'guards.name')
        ->where(function($query) use ($adhoc_sites){
            foreach ($adhoc_sites as $key => $id) {
                if ($key == 0) {
                    $query->where('job_new_roster.site_id', $id);
                }else{
                    $query->orWhere('job_new_roster.site_id', $id);
                }
            }
        })
        ->where('job_new_roster.temp_start', '>=', date('Y-m-d H:i:s', (time() - 60 * 60*24)))
        ->where(function($query){
            // $query->where(function($query1){
            //     $query1->where('job_new_roster.temp_start', '>=', date('Y-m-d H:i:s', (time() - 60 * 30)))
            //     ->where('job_new_roster.temp_start', '<=', date('Y-m-d H:i:s', time()))
            //     ->where('job_new_roster.temp_end', '>', date('Y-m-d H:i:s', time()));
            // });
            $query->where(function($query1){
                $query1->where('job_new_roster.temp_start', '>=', date('Y-m-d H:i:s', (time() - 60 * 30)))
                ->where('job_new_roster.temp_start', '<=', date('Y-m-d H:i:s', (time() + 60 * 30)))
                ->where('job_new_roster.temp_end', '>', date('Y-m-d H:i:s', time()));
            });
            $query->orWhere('job_new_roster.signin_status', 1);
        })
        ->groupBy('guards.id')
        ->get();

        return view('mercy_hospital', compact('core_guards', 'core_site', 'adhoc_guards'));
    }

    function getGuardShift(Request $request)
    {
        config(['app.timezone' => $this->timezone['Victoria']]);
        date_default_timezone_set($this->timezone['Victoria']);
        $adhoc_sites = [12, 17, 21, 22, 31, 54, 77, 78, 81, 85, 87, 92, 93, 94, 95, 98, 100, 101, 102, 139, 149, 153, 154, 184, 193];
        $roster = DB::table('job_new_roster')
        ->where('guard_id', $request->guard_id)
        ->where('job_new_roster.temp_start', '>=', date('Y-m-d H:i:s', (time() - 60 * 60*24)))
        ->where(function($query){
            $query->where(function($query1){
                $query1->where('job_new_roster.temp_start', '>=', date('Y-m-d H:i:s', (time() - 60 * 30)))
                ->where('job_new_roster.temp_start', '<=', date('Y-m-d H:i:s', time()))
                ->where('job_new_roster.temp_end', '>', date('Y-m-d H:i:s', time()));
            });
            $query->orWhere('job_new_roster.signin_status', 1);
        })
        
        // ->where('temp_start', '>=', date('Y-m-d H:i:s', (time() - 60 * 30)))
        // ->where('temp_start', '<=', date('Y-m-d H:i:s', time()))
        // ->where('temp_end', '>', date('Y-m-d H:i:s', time()))
        ->where(function($query) use ($adhoc_sites){
            foreach ($adhoc_sites as $key => $id) {
                if ($key == 0) {
                    $query->where('site_id', $id);
                }else{
                    $query->orWhere('site_id', $id);
                }
            }
        })
        ->first();
        if (empty($roster)) {
            $roster = DB::table('job_new_roster')
            ->where('job_new_roster.temp_start', '>=', date('Y-m-d H:i:s', (time() - 60 * 60*24)))
            ->where('guard_id', $request->guard_id)
            // ->where('temp_start', '>=', date('Y-m-d H:i:s', (time() - 60 * 30)))
            // ->where('temp_start', '<=', date('Y-m-d H:i:s', (time() + 60 * 30)))
            // ->where('temp_end', '>', date('Y-m-d H:i:s', time()))
            ->where(function($query){
                $query->where(function($query1){
                    $query1->where('job_new_roster.temp_start', '>=', date('Y-m-d H:i:s', (time() - 60 * 30)))
                    ->where('job_new_roster.temp_start', '<=', date('Y-m-d H:i:s', (time() + 60 * 30)))
                    ->where('job_new_roster.temp_end', '>', date('Y-m-d H:i:s', time()));
                });
                $query->orWhere('job_new_roster.signin_status', 1);
            })
            ->where(function($query) use ($adhoc_sites){
                foreach ($adhoc_sites as $key => $id) {
                    if ($key == 0) {
                        $query->where('site_id', $id);
                    }else{
                        $query->orWhere('site_id', $id);
                    }
                }
            })
            ->first();
        }
        $guard = DB::table('guards')->where('id', $request->guard_id)->select('profile_image')->first();
        if ($guard->profile_image != '') {
            $guard->profile_image = 'https://'.request()->getHttpHost().'/asset_uploads/'.$guard->profile_image;
        }
        if (empty($roster)) {
            return response()->json(['success' => false, 'message' =>  'No Active Shift', 'guard' => $guard]);
        }else{
            return response()->json(['success' => true, 'message' =>  'Shift successfully!', 'shift' => $roster, 'guard' => $guard]);
        }
    }

    function checkCoreGuardShift(Request $request)
    {
        $shift = DB::table('job_new_roster')
        ->join('job_roster_activities', 'job_roster_activities.job_roster_id' , '=', 'job_new_roster.roster_id')
        ->where('job_new_roster.end', '=', '')
        ->where('job_new_roster.guard_id', $request->guard_id)
        ->where('job_new_roster.site_id', 38)
        ->first();
        $guard = DB::table('guards')->where('id', $request->guard_id)->select('profile_image')->first();
        if ($guard->profile_image != '') {
            $guard->profile_image = 'https://'.request()->getHttpHost().'/asset_uploads/'.$guard->profile_image;
        }
        if (empty($shift)) {
            return response()->json(['success' => false, 'message' =>  'No Active Shift', 'guard' => $guard, 'shift' => $shift]);
        }else{
            return response()->json(['success' => true, 'message' =>  'Shift successfully!', 'shift' => $shift, 'guard' => $guard]);
        }
    }

    public function index()
    {

        if (!session()->has('userType')) {
            return view('admin/login');
        }else{
            $new_guards = $this->dashboard_new_guards();
            // $new_guards=array();
            if (session()->get('userType') == 'customer') {
                $ids = [''.session()->get('userId').''];
                $top_rated = DB::table('guards')
                ->where('status','!=','deleted')
                ->where('is_approved','=','yes')
                ->where('status','=','active')
                ->whereJsonContains('guards.specific_customers_id' , $ids)
                ->where('admin_approved','=','1')
                ->orderBy('rating','desc')
                ->paginate(5);
            }else{
                $top_rated = DB::table('guards')
                ->where('status','!=','deleted')
                ->where('is_approved','=','yes')
                ->where('status','=','active')
                ->where('admin_approved','=','1')
                ->orderBy('rating','desc')
                ->paginate(5);
            }

            // $shifts=$this->recent_shifts();
            $shifts=array();
            return view('admin/dashboard',['new_guards'=>$new_guards,'top_rated'=>$top_rated,'shifts' => $shifts]);
        }
    }

    public function home()
    {

    }
    public function administrators(){
        return view('admin/administrators');

    }

    public function recent_shifts(){
        $shifts =  DB::table('job_new_roster') ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
        ->join('guards', 'job_new_roster.guard_id', '=', 'guards.id')
        // ->leftJoin('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')
        ->join('customers', 'jobs.customer_id', '=', 'customers.id')
        ->leftJoin('contractors', 'jobs.contractor_id', '=', 'contractors.id')
        // ->leftJoin('administrators', 'job_new_roster.status_change_by', '=', 'administrators.id')
        ->select('job_new_roster.*', 'jobs.id AS job_id', 'jobs.booking_id',
            'jobs.customer_id',
            'jobs.site_name',
            'jobs.site_description',
            'jobs.contractor_id',
            'jobs.state',
            'jobs.stateType',
            'jobs.address',
            'jobs.details',
            'jobs.level',
            'jobs.status AS jobs_status',
            'customers.name AS customer_name' ,
            'contractors.name  AS contractor_name',
            'guards.guard_type',
            'guards.name  AS guard_name' ,
            'customers.flat_metro_week_day',
        // 'job_roster_activities.signin_time',
        // 'job_roster_activities.signout_time',
       // 'jobs.break',
            'jobs.chargeable',
            'jobs.payable',
       // 'administrators.name AS admin_name' 
        )->orderBy('job_new_roster.roster_id', 'desc')->paginate(5);
        return $shifts;

    }
    public function dashboard_new_guards(){
        if (session()->get('userType') == 'customer') {
            $ids = [''.session()->get('userId').''];
            $new_guards =  DB::table('guards')->where('is_approved', 'no')->whereJsonContains('guards.specific_customers_id' , $ids)->where('status','!=', 'deleted')->orderBy('id', 'desc')->paginate(5);
            
        }else{
            $new_guards =  DB::table('guards')->where('is_approved', 'no')->where('status','!=', 'deleted')->orderBy('id', 'desc')->paginate(5);
        }
        // $new_guards =  DB::table('guards')->where('is_approved', 'no')->where('status','!=', 'deleted')->orderBy('id', 'desc')->take(5)->get();
        return $new_guards;

    }

    public function get_records($status){
        $query_append = '';
        $extra_query = '';
        if (session()->get('userType') == 'customer') {
            $extra_query = 'j.`customer_id` = '.session()->get('userId').' AND ';
        }
        if ($status == 'completed' || $status == 'confirmed') {
            $result = DB::select(
                "SELECT
                jr.*
                FROM job_new_roster AS jr
                INNER JOIN `guards` AS g ON g.`id` = jr.`guard_id`
                INNER JOIN `jobs` AS j ON j.`id` = jr.`site_id`
                WHERE ".$extra_query."jr.`temp_end` <= '".date('Y-m-d H:i:s')."' AND (jr.`job_status` = '".$status."' OR jr.`job_status`='pending' OR jr.`job_status` = 'confirmed') ORDER BY jr.job_end DESC LIMIT 50"
            );
        }elseif($status == 'inprogress'){
            $result = DB::select(
              "SELECT
              jr.`roster_id`
              FROM job_new_roster AS jr
              INNER JOIN job_roster_activities AS jsa ON jsa.`job_roster_id` = jr.`roster_id`
              INNER JOIN `guards` AS g ON g.`id` = jr.`guard_id`
              INNER JOIN `jobs` AS j ON j.`id` = jr.`site_id`
              WHERE ".$extra_query."jr.`temp_start` >= '".date('Y-m-d')."' AND jr.`job_status` = 'confirmed' ORDER BY jr.temp_start ASC"
          );
        }elseif($status == 'pending'){
            $result = DB::select(
                "SELECT
                jr.`roster_id`
                FROM job_new_roster AS jr
                INNER JOIN `jobs` AS j ON j.`id` = jr.`site_id`
                WHERE ".$extra_query."jr.`temp_start` >= '".date('Y-m-d')."' AND (jr.`job_status` = '".$status."' OR jr.`job_status` = 'confirmed') ORDER BY jr.temp_start ASC LIMIT 50"
            );
        }elseif($status == 'missed')
        {
           $result = DB::select(
            "SELECT
            jr.`roster_id`
            FROM job_new_roster AS jr
            INNER JOIN `jobs` AS j ON j.`id` = jr.`site_id`
            WHERE ".$extra_query."jr.`temp_start` <='".date('Y-m-d H:i:s')."' AND jr.`temp_end` >= '".date('Y-m-d H:i:s', time())."' AND jr.`signin_status` = 0 AND (jr.`job_status` = 'pending' OR jr.`job_status` = 'confirmed') ORDER BY jr.temp_start ASC"
        );
       }
            //     $results = DB::table('job_new_roster')
            //     ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
            //     ->join('guards', 'job_new_roster.guard_id', '=', 'guards.id')
            //     ->leftJoin('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')
            //     ->leftJoin('customers', 'jobs.customer_id', '=', 'customers.id')
            //     ->leftJoin('contractors', 'jobs.contractor_id', '=', 'contractors.id')
            //     ->leftJoin('administrators', 'job_new_roster.status_change_by', '=', 'administrators.id')
            //     ->select('job_new_roster.*', 'jobs.id AS job_id', 'jobs.booking_id',
            //          'jobs.customer_id',
            //     'jobs.contractor_id',
            //     'jobs.state',
            //     'jobs.stateType',
            //     'jobs.address',
            //     'jobs.details',
            //     'jobs.level',
            //     'customers.name AS customer_name' ,
            //     'contractors.name  AS contractor_name',
            //     'guards.guard_type',
            //     'guards.name  AS guard_name' ,
            //     'customers.flat_metro_week_day',
            //     'job_roster_activities.signin_time',
            //     'job_roster_activities.signout_time',
            //    'jobs.break',
            //    'jobs.chargeable',
            //    'jobs.payable',
            //    'administrators.name AS admin_name' 
            // );

            //             $results=$this->jobs_status($status,$results);
            //             $result=$results->orderBy('job_new_roster.roster_id', 'asc')->take(50)->get();

       return $result;

   }
   public function count_dashboard(){
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;
    $active_guards_query =  DB::table('guards');
        // if (session()->has('isAdmin') && session()->get('isAdmin') == 0) {
        //     if (session()->has('specific_sites')) {
        //         $specific_sites = json_decode(session()->get('specific_sites'));
        //         if (!empty($specific_sites)) {
        //             $active_guards_query->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')
        //             ->where(function ($query) use($specific_sites){
        //                 foreach ($specific_sites as $key => $site_id) {
        //                     if ($key == 0) {
        //                         $query->where('jobs_guards.job_id', $site_id);
        //                     }else{
        //                         $query->where('jobs_guards.job_id', $site_id);
        //                     }
        //                 }
        //             });
        //         }
        //     }elseif(session()->has('specific_customer')){
        //         $
        //         $specific_customer = json_decode(session()->get('specific_customer'));
        //         if (!empty($specific_sites)) {
        //             $active_guards_query->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')
        //             ->join('jobs', 'jobs.id', '=', 'jobs_guards.job_id')
        //             ->where(function ($query) use($specific_customer){
        //                 foreach ($specific_customer as $key => $customer_id) {
        //                     if ($key == 0) {
        //                         $query->where('jobs.customer_id', $customer_id);
        //                     }else{
        //                         $query->where('jobs.customer_id', $customer_id);
        //                     }
        //                 }
        //             });
        //         }
        //     }
        // }
    if (session()->get('userType') == 'customer') {
        $ids = [''.session()->get('userId').''];
        $active_guards_query->whereJsonContains('guards.specific_customers_id' , $ids);
    }
    $active_guards = $active_guards_query->where('guards.status', 'active')
    ->where('status', 'active')
    ->where('admin_approved', 1)
    ->where('is_approved', 'yes')
    ->where('address', '!=', '')
                        // ->where('gender','!=','')
    ->where('phone', '!=', '')
    ->where('name', '!=', '')
    ->where('name', '!=', null)
    ->where('email', '!=', '')
    ->where('email', '!=', null)
                        // ->where('emergency_contact_phone','!=','')
    ->where('security_license_number', '!=', '')
    ->where('security_license_file', '!=', '')
                        // ->where('payroll_bank_account_number','!=','')
                        // ->where('payroll_bank_name','!=','')
    ->orderBy('name', 'ASC')->get();

    $pending_guards_query =  DB::table('guards');
        // if (session()->has('isAdmin') && session()->get('isAdmin') == 0) {
        //     if (session()->has('specific_sites')) {
        //         $specific_sites = json_decode(session()->get('specific_sites'));
        //         if (!empty($specific_sites)) {
        //             $pending_guards_query->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')
        //             ->where(function ($query) use($specific_sites){
        //                 foreach ($specific_sites as $key => $site_id) {
        //                     if ($key == 0) {
        //                         $query->where('jobs_guards.job_id', $site_id);
        //                     }else{
        //                         $query->where('jobs_guards.job_id', $site_id);
        //                     }
        //                 }
        //             });
        //         }
        //     }elseif(session()->has('specific_customer')){
        //         $
        //         $specific_customer = json_decode(session()->get('specific_customer'));
        //         if (!empty($specific_sites)) {
        //             $pending_guards_query->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')
        //             ->join('jobs', 'jobs.id', '=', 'jobs_guards.job_id')
        //             ->where(function ($query) use($specific_customer){
        //                 foreach ($specific_customer as $key => $customer_id) {
        //                     if ($key == 0) {
        //                         $query->where('jobs.customer_id', $customer_id);
        //                     }else{
        //                         $query->where('jobs.customer_id', $customer_id);
        //                     }
        //                 }
        //             });
        //         }
        //     }
        // }
    if (session()->get('userType') == 'customer') {
        $ids = [''.session()->get('userId').''];
        $pending_guards_query->whereJsonContains('guards.specific_customers_id' , $ids);
    }
    $pending_guards = $pending_guards_query->where('guards.status', 'inactive')
    ->where('guards.is_approved', 'yes')
    ->where('guards.address','!=','')
    ->where('guards.state','!=','')
    ->where('guards.gender','!=','')
    ->where('guards.emergency_contact_phone','!=','')
    ->where('guards.security_license_number','!=','')
    ->where('guards.security_license_file','!=','')
    ->where('guards.payroll_bank_account_number','!=','')
    ->where('guards.payroll_bank_name','!=','')
    ->orderBy('name', 'ASC')->get();

    $query =  DB::table('guards')
    ->where('guards.status','=', 'inactive')
    ->where(function ($query){
        $query->where('guards.address','')
            // ->orWhere('gender','')
        ->orWhere('guards.emergency_contact_phone','')
        ->orWhere('guards.state','')
        ->orWhere('guards.security_license_number','')
        ->orWhere('guards.security_license_file','')
        ->orWhere('guards.security_license_file','null')
        ->orWhere('guards.security_license_file',null)
        ->orWhere('guards.payroll_bank_account_number','')
        ->orWhere('guards.payroll_bank_name','');


    });
    if (session()->get('userType') == 'customer') {
        $ids = [''.session()->get('userId').''];
        $query->whereJsonContains('guards.specific_customers_id' , $ids);
    }
            // ->orWhere('is_approved', '!=', 'yes')

    $new_guards = $query->orderBy('name', 'ASC')->get();


    $pending_guards_count=$pending_guards->count();
    $active_guards_count=$active_guards->count();
    $new_guards_count=$new_guards->count();
//roster
    if (session()->get('userType') == 'customer') {
        $roster = DB::table('job_new_roster')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->where('jobs.customer_id', session()->get('userId'))
        ->whereMonth('temp_start', $currentMonth)
        ->whereYear('temp_start', $currentYear)
        ->select('roster_id')->get();

        $completed_shifts = DB::table('job_new_roster')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->where('job_new_roster.job_status', 'completed')
        ->where('job_new_roster.job_status', 'completed')
        ->where('jobs.customer_id', session()->get('userId'))
        ->whereMonth('temp_start', $currentMonth)
        ->whereYear('temp_start', $currentYear)
        ->select('roster_id')->get();

        $completed_jobs_count = DB::table('job_new_roster')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->where('job_new_roster.job_status' , "completed")
        ->whereMonth('temp_start', $currentMonth)
        ->whereYear('temp_start', $currentYear)
        ->where('jobs.customer_id', session()->get('userId'))
        ->get()->count();

        $auto_completed_jobs_count=  $shifts =  DB::table('job_new_roster')
        ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
        ->join('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')
        ->where('job_new_roster.job_status' , "completed")
        ->whereMonth('temp_start', $currentMonth)
        ->whereYear('temp_start', $currentYear)
        ->where('jobs.customer_id', session()->get('userId'))
        ->where(function($query) {
            $query->where('job_roster_activities.signout_time' , '!=', "")
            ->orWhere('job_roster_activities.signout_selfie' , '!=', "");
        })->count();

        $asap_job_notification_counter=DB::table('job_new_roster')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->where('job_new_roster.asap_job_notification_counter' , 1)
        ->where('jobs.customer_id', session()->get('userId'))
        ->count();

    }else{
        $roster = DB::table('job_new_roster')->select('roster_id')->whereMonth('temp_start', $currentMonth)->whereYear('temp_start', $currentYear)->get();
        $completed_shifts=DB::table('job_new_roster')->where('job_status', 'completed')->whereMonth('temp_start', $currentMonth)->whereYear('temp_start', $currentYear)->select('roster_id')->get();
        $completed_jobs_count= DB::table('job_new_roster')->where('job_new_roster.job_status' , "completed")->whereMonth('temp_start', $currentMonth)->whereYear('temp_start', $currentYear)->get()->count();
        $auto_completed_jobs_count=  $shifts =  DB::table('job_new_roster')->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')->join('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')->where('job_new_roster.job_status' , "completed")->where(function($query) {
            $query->where('job_roster_activities.signout_time' , '!=', "")
            ->orWhere('job_roster_activities.signout_selfie' , '!=', "");
        })->whereMonth('temp_start', $currentMonth)->whereYear('temp_start', $currentYear)->count();
        $asap_job_notification_counter=DB::table('job_new_roster')->where('job_new_roster.asap_job_notification_counter' , 1)->count();

    }
    $completed_shifts_count=$completed_shifts->count();
    $shifts_count=$roster->count();





    
    $upcoming=$this->get_records($status="pending");
    $ongoing=$this->get_records($status="inprogress");
    $missed=$this->get_records($status="missed");

    $missed_count=count($missed);
              // $missed_count = 0;
    $ongoing_count=count($ongoing);
              // $ongoing_count = 0;
    $upcoming_count=count($upcoming);
              // $upcoming_count = 0;
            //   $upcoming_count=$upcoming->count();
            //   $ongoing_count=$missed->count();


    return response()->json(array('pending_guards_count' =>$pending_guards_count,
        'completed_shifts_count' =>$completed_shifts_count,
        'completed_jobs_count' =>$completed_jobs_count,
        
        'shifts_count' =>$shifts_count,
        'new_guards_count' =>$new_guards_count,
        'active_guards_count' =>$active_guards_count,
        'upcoming_count' =>$upcoming_count,
        'ongoing_count' =>$ongoing_count,
        'missed_count' =>$missed_count,
        'asap_job_notification_counter' =>$asap_job_notification_counter,
        'auto_completed_jobs_count' =>$auto_completed_jobs_count
        
    ));
}



public function shifts_hour_chart(){

    $months=[];
    $month_number=[];

    $current_month=date('m');
    for($i=0;$i<=11;$i++){
        $months[$i]= date('M', strtotime(date('M'). - $i. 'month'));
    };
    for($i=0;$i<=11;$i++){
       // $month_number[$i]= $current_month-$i;
       $month_number[$i]= date('m', strtotime(date('M'). - $i. 'month')) - 1;
       if ($month_number[$i] == 0) {
           $month_number[$i] = 12;
       }
   };
   $specific_month_hours=[];
   $shifts=[];
   $completed_jobs=[];
   $upcoming_jobs=[];  
   $tt=[];
   $hourss=[];

   $month_number = array_reverse($month_number);
     //    print_r($month_number) ;
     //    exit();

   $months = array_reverse($months);
   for($i=0;$i<=11;$i++){
       $results = DB::table('job_new_roster')
       ->join('jobs', 'jobs.id' , '=', 'job_new_roster.site_id');
       if (session()->get('userType') == 'customer') {
        $results->where('customer_id', session()->get('userId'));
    }
    if (session()->has('specific_customer') && session()->get('specific_customer') != '') {
        $specific_customer = json_decode(session()->get('specific_customer'));
        $results->where(function($query)  use($specific_customer){
            foreach ($specific_customer as $key => $id) {
                if ($key == 0) {
                    $query->where('jobs.customer_id', $id);
                }else{
                    $query->orWhere('jobs.customer_id', $id);
                }
            }
        });
    }elseif (session()->has('specific_sites') && session()->get('specific_sites') != '') {
        $specific_sites = json_decode(session()->get('specific_sites'));
        $results->where(function($query)  use($specific_sites){
            foreach ($specific_sites as $key => $id) {
                if ($key == 0) {
                    $query->where('jobs.id', $id);
                }else{
                    $query->orWhere('jobs.id', $id);
                }
            }
        });
    }
    $results->where(function($query) {
     $query->where('job_new_roster.job_status' , "completed")
     ->orWhere('job_new_roster.job_status' , "confirmed")
     ->orWhere('job_new_roster.job_status' , "pending")
     ->orWhere('job_new_roster.status_change_by' , '>', 0);
 });
    if ($month_number[$i] > date('m')) {
        $year = date('Y') - 1;
    }else{
        $year = date('Y');
    }
    if ($month_number[$i] < 10) {
        $month_number[$i] = '0'.$month_number[$i];
    }
    $start = $year.'-'.$month_number[$i].'-01';
    $end = date("Y-m-t", strtotime($start));
    $months[$i] = date('M', strtotime($start));
    $end = strtotime($end) + 60*60*24;
    $end = date('Y-m-d', $end);
    // $roster = $results->whereMonth('job_new_roster.temp_start', $month_number[$i])->whereYear('job_new_roster.temp_start', $year)->get();
    $roster = $results->whereBetween('job_new_roster.temp_start', [$start,$end])->get();
    $hours=0;

    foreach($roster as $result){
       $hour = $this->getTimeDiff($result->temp_start, $result->temp_end);
       $hour['hours'] = $hour['hours'] + ($hour['days'] * 24);
       if($hour['hours']==0){
        $temp = $hour['minutes'];
        $hour['hours'] = round($temp/60);
        $hour1 = $hour['hours'];
    }else{
        $hour1 = $hour['hours'] + ($hour['minutes']/60);
        $total_hours = explode('.', $hour1);
        if (sizeof($total_hours) > 1 ) {
          $partial = '.'.$total_hours[1];
          if ($partial < 0.1) {
             $hour1 = $total_hours[0];
         }
         if ($partial < 0.27 && $partial > 0.1) {
             $hour1 = $total_hours[0].'.25';
         }
         if ($partial > 0.27 && $partial <= 0.52) {
             $hour1 = $total_hours[0].'.5';
         }
         if ($partial > 0.52 && $partial <= 0.77) {
             $hour1 = $total_hours[0].'.75';
         }
         if ($partial > 0.77 && $partial < 1) {
             $hour1 = $total_hours[0]+ 1;
         }
     }
 }
 $hours = $hours + $hour1;
}
$tt[0] = $hours;

$hourss[$i]=$tt[0];
$shifts[$i]=$roster->count();



}

return ['months'=>$months,'shifts'=>$shifts,'hours'=>$hourss, 'mo' => $month_number];
}

public function roster_progress(){

 $months=[];
 $month_number=[];

 $current_month=date('m');
 for($i=0;$i<=5;$i++){
     $months[$i]= date('M', strtotime(date('M'). - $i. 'month'));
 };
 for($i=0;$i<=5;$i++){
    $month_number[$i]= $current_month-$i;
};
$specific_month_hours=[];
$shifts=[];
$completed_jobs=[];
$upcoming_jobs=[];  
$tt=[];
$hourss=[];

$month_number=array_reverse($month_number);
//    print_r($month_number) ;
//    exit();

$months=array_reverse($months);
for($i=0;$i<=5;$i++){
    $total_hours=0;
    $que = DB::table('job_new_roster')->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')->whereMonth('temp_start',$month_number[$i]);
    if (session()->get('userType') == 'customer') {
        $que->where('customer_id', session()->get('userId'));
    }
    $roster = $que->get();
    $hours=0;

    foreach($roster as $result){
        $hour = $this->getTimeDiff($result->temp_start, $result->temp_end);
        $hour1=$hour['hours'];
        $hours=$hours + $hour1;
    }
    $tt[0]=$hours;

    $hourss[$i]=$tt[0];
    $shifts[$i]=$roster->count();
    $que1=DB::table('job_new_roster')->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')->where('job_new_roster.job_status','completed')->whereMonth('job_new_roster.temp_start',$month_number[$i]);
    if (session()->get('userType') == 'customer') {
        $que1->where('customer_id', session()->get('userId'));
    }
    $roster1 = $que1->get();
    $completed_shifts[$i]=$roster1->count();
        // $jobs=DB::table('jobs')->where('job_status','completed')->whereMonth('TIMESTAMP_INSERTED',$month_number[$i])->get();
        // $jobs1=DB::table('jobs')->where('job_status','upcoming')->whereMonth('TIMESTAMP_INSERTED',$month_number[$i])->get();
    $que2=DB::table('job_new_roster')->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')->where('job_new_roster.job_status','completed')->whereMonth('job_new_roster.temp_start',$month_number[$i]);
    if (session()->get('userType') == 'customer') {
        $que2->where('customer_id', session()->get('userId'));
    }
    $roster_completed = $que2->get();
    $que3=DB::table('job_new_roster')->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')->where('job_new_roster.job_status','pending')->whereMonth('job_new_roster.temp_start',$month_number[$i]);
    if (session()->get('userType') == 'customer') {
        $que3->where('customer_id', session()->get('userId'));
    }
    $roster_upcoming = $que3->get();


    $completed_jobs[$i]=$roster_completed->count();
    $upcoming_jobs[$i]=$roster_upcoming->count();



}

return ['months'=>$months,'shifts'=>$shifts,'completed_shifts'=>$completed_shifts,'completed_jobs'=>$completed_jobs,'hours'=>$hourss,'upcoming_jobs'=>$upcoming_jobs];
}

function monthly_jobs_progress(){
    $months=[];
    $month_number=[];

    $current_month=date('m');
    for($i=0;$i<=5;$i++){
     $months[$i]= date('M', strtotime(date('M'). - $i. 'month'));
 };
 for($i=0;$i<=5;$i++){
    $month_number[$i]= $current_month-$i;
};
$specific_month_hours=[];
$shifts=[];

$month_number=array_reverse($month_number);
//    print_r($month_number) ;
//    exit();

$months=array_reverse($months);
for($i=0;$i<=5;$i++){

    $jobs=DB::table('jobs')->whereMonth('temp_start',$month_number[$i])->select('roster_id','temp_start','temp_end')->get();
    $shifts[$i]=$roster->count();
    $roster1=DB::table('job_new_roster')->where('job_status','completed')->whereMonth('temp_start',$month_number[$i])->select('roster_id','temp_start','temp_end')->get();
    $completed_shifts[$i]=$roster1->count();

}

return ['months'=>$months,'shifts'=>$shifts,'completed_shifts'=>$completed_shifts];
}

function asap_jobs(){

    return view('admin/asap');
}

function asap_jobs_data(){
    $results = DB::table('job_new_roster')
    ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
    ->join('guards', 'job_new_roster.guard_id', '=', 'guards.id')
    ->leftJoin('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')
    ->leftJoin('customers', 'jobs.customer_id', '=', 'customers.id')
    ->leftJoin('contractors', 'jobs.contractor_id', '=', 'contractors.id')
    ->leftJoin('administrators', 'job_new_roster.status_change_by', '=', 'administrators.id')
    ->select('job_new_roster.*', 'jobs.id AS job_id', 'jobs.booking_id',
       'jobs.customer_id',
       'jobs.contractor_id',
       'jobs.state',
       'jobs.stateType',
       'jobs.address',
       'jobs.details',
       'jobs.level',
       'customers.name AS customer_name' ,
       'contractors.name  AS contractor_name',
       'guards.guard_type',
       'guards.name  AS guard_name' ,
       'customers.flat_metro_week_day',
       'job_roster_activities.signin_time',
       'job_roster_activities.signout_time',
       'jobs.break',
       'jobs.chargeable',
       'jobs.payable',
       'administrators.name AS admin_name' 
   )
    ->where('job_new_roster.asap_job_notification_counter',1)
    ->get();
    foreach($results as $result)
    {
        $hours = $this->getTimeDiff($result->temp_start, $result->temp_end);
        $result->hours=$hours['hours'];
        $result->temp_date=Date("d-m-Y",strtotime($result->temp_date));
        $result->temp_start=Date("H:i",strtotime($result->temp_start));
        $result->temp_end=Date("H:i",strtotime($result->temp_end));
    }

    return $results;
}

public function shift_hours_detail(){
    return view('admin/shift_hours_detail');

}

public function security_license_expiry_check(){
    $start_date = date('Y-m-d');
    $end_date = date("Y-m-d", strtotime("+1 month", time()));
    // $guards= DB::table('guards')->select('id',
    //     'name',
    //     'security_license_expiration',
    //     'security_license_number')->whereBetween('security_license_expiration' ,[date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date))])->get();
    // foreach($guards as $d){
    //     $d->security_license_expiration=date('d-m-y', strtotime($d->security_license_expiration));
    // }
    $guards= DB::table('guards')->select('id',
    'name',
    'security_license_expiration',
    'security_license_number')->get();
    $mainArr = [];
    for ($i=0; $i < count($guards) ; $i++) {
        if (strpos($guards[$i]->security_license_expiration, '/') !== false) {
            $guards[$i]->security_license_expiration = str_replace('/', '-', $guards[$i]->security_license_expiration);
            $guards[$i]->formated_date = date('Y-m-d', strtotime($guards[$i]->security_license_expiration));
        }else{
            $guards[$i]->formated_date = date('d-m-Y', strtotime($guards[$i]->security_license_expiration));
        }
        if(Carbon::parse($guards[$i]->formated_date)->between($start_date, $end_date)){
            $mainArr[] = $guards[$i]; 
        }
    }
    return $mainArr;
}

public function uncovered_shifts_check(){
    $now = Carbon::now();
    $weekStartDate = $now->startOfWeek()->format('Y-m-d');
    $weekEndDate = $now->endOfWeek()->format('Y-m-d');
    $data= DB::table('job_new_roster')->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')->where('job_new_roster.guard_id', null)->whereBetween('job_new_roster.temp_date' ,[date('Y-m-d', strtotime($weekStartDate)),date('Y-m-d', strtotime($weekEndDate))])->get();
// $this->sendGuardMail($data);
    foreach($data as $d){
        $d->temp_start=date('H:i', strtotime($d->temp_date));
        $d->temp_end=date('H:i', strtotime($d->temp_end));
        $d->temp_date=date('d-m-y', strtotime($d->temp_date));

    }
// $view =$this->test_view($data);
    return $data;

}


public function shift_hours_detail_data(Request $request){

    $date=$request->from_to;
    $all_dates=[];
    $all_months=[];

    if ($date != null ) {

        $from_to = explode("-", $date);
        $from = trim($from_to[0]);
        $to = trim($from_to[1]);
        $timestamp = strtotime($from);
        $timestamp_to = strtotime($to) + 60*60*24;

        $from = date("Y-m-d", $timestamp);
        $to = date("Y-m-d", $timestamp_to);
        $timestamp_to = $timestamp_to - 60*60*24;
        $to1 = date("Y-m-d", $timestamp_to);
                // return $from;
                // exit();
                    // print_r($results);
                    // exit();

    }

    $startDate = new Carbon($from);
    $endDate = new Carbon($to1);
                                // $all_dates = array();
    while ($startDate->lte($endDate)){
        $all_dates[] = $startDate->toDateString();
        $all_months[] = $startDate->format('F');

        $startDate->addMonth();
    }
                                // print_r($all_dates);

                                // exit();



    if(sizeof($all_dates) > 12){
        return response()->json(['range' => true]);
        exit();

    }
    else{



                            // $months=array_reverse($months);
                            // echo $from . ' / ' . $to ;
                            // exit();
       $size=sizeof($all_dates);

                            //   print_r($all_months);

                            //     exit();
                            // $z=0;
       for($i=0;$i<$size;$i++){
        $total_hours=0;
        $results = DB::table('job_new_roster')
        ->join('jobs', 'jobs.id' , '=', 'job_new_roster.site_id');
        if (session()->has('specific_customer') && session()->get('specific_customer') != '') {
            $specific_customer = json_decode(session()->get('specific_customer'));
            $results->where(function($query)  use($specific_customer){
                foreach ($specific_customer as $key => $id) {
                    if ($key == 0) {
                        $query->where('jobs.customer_id', $id);
                    }else{
                        $query->orWhere('jobs.customer_id', $id);
                    }
                }
            });
        }elseif (session()->has('specific_sites') && session()->get('specific_sites') != '') {
            $specific_sites = json_decode(session()->get('specific_sites'));
            $results->where(function($query)  use($specific_sites){
                foreach ($specific_sites as $key => $id) {
                    if ($key == 0) {
                        $query->where('jobs.id', $id);
                    }else{
                        $query->orWhere('jobs.id', $id);
                    }
                }
            });
        }
        $results->where(function($query) {
         $query->where('job_new_roster.job_status' , "completed")
         ->orWhere('job_new_roster.job_status' , "confirmed")
         ->orWhere('job_new_roster.job_status' , "pending")
         ->orWhere('job_new_roster.status_change_by' , '>', 0);
     });
        $roster = $results->whereBetween('job_new_roster.temp_start', [$from, $to])->get();
                                // $roster=DB::table('job_new_roster')->whereDate('temp_start', $all_dates[$i])->get();
        $hours=0;
        foreach($roster as $result){
            $hour = $this->getTimeDiff($result->temp_start, $result->temp_end);
            $hour['hours'] = $hour['hours'] + ($hour['days'] * 24);
            if($hour['hours']==0){
                $temp = $hour['minutes'];
                $hour['hours'] = round($temp/60);
                $hour1 = $hour['hours'];
            }else{
                $hour1 = $hour['hours'] + ($hour['minutes']/60);
                $total_hours = explode('.', $hour1);
                if (sizeof($total_hours) > 1 ) {
                  $partial = '.'.$total_hours[1];
                  if ($partial < 0.1) {
                     $hour1 = $total_hours[0];
                 }
                 if ($partial < 0.27 && $partial > 0.1) {
                     $hour1 = $total_hours[0].'.25';
                 }
                 if ($partial > 0.27 && $partial <= 0.52) {
                     $hour1 = $total_hours[0].'.5';
                 }
                 if ($partial > 0.52 && $partial <= 0.77) {
                     $hour1 = $total_hours[0].'.75';
                 }
                 if ($partial > 0.77 && $partial < 1) {
                     $hour1 = $total_hours[0]+ 1;
                 }
             }
         }
                                    // $hour1 = $hour['hours'];
         $hours = $hours + $hour1;
     }
     $tt[0]=$hours;
     $hourss[$i]=$tt[0];
     $shifts[$i]=$roster->count();
 }
 return ['months'=>$all_months,'shifts'=>$shifts,'hours'=>$hourss, 'all_dates' => $all_dates, 'from' => $from, 'to' => $to];

}



}

function getMonthString($m){
    if($m==1){
        return "January";
    }else if($m==2){
        return "February";
    }else if($m==3){
        return "March";
    }else if($m==4){
        return "April";
    }else if($m==5){
        return "May";
    }else if($m==6){
        return "June";
    }else if($m==7){
        return "July";
    }else if($m==8){
        return "August";
    }else if($m==9){
        return "September";
    }else if($m==10){
        return "October";
    }else if($m==11){
        return "November";
    }else if($m==12){
        return "December";
    }
}
private function getTimeDiff($start, $end) {
    $return =  [
        'years' => 0,
        'months' => 0,
        'days' => 0,
        'hours' => 0,
        'minutes' => 0,
        'seconds' => 0
    ];
        // Declare and define two dates
    $date1 = strtotime($start);
    $date2 = strtotime($end);

        // Formulate the Difference between two dates
    $diff = abs($date2 - $date1);


        // To get the year divide the resultant date into
        // total seconds in a year (365*60*60*24)
    $years = floor($diff / (365*60*60*24));


        // To get the month, subtract it with years and
        // divide the resultant date into
        // total seconds in a month (30*60*60*24)
    $months = floor(($diff - $years * 365*60*60*24)
        / (30*60*60*24));


        // To get the day, subtract it with years and
        // months and divide the resultant date into
        // total seconds in a days (60*60*24)
    $days = floor(($diff - $years * 365*60*60*24 -
        $months*30*60*60*24)/ (60*60*24));


        // To get the hour, subtract it with years,
        // months & seconds and divide the resultant
        // date into total seconds in a hours (60*60)
    $hours = floor(($diff - $years * 365*60*60*24
        - $months*30*60*60*24 - $days*60*60*24)
    / (60*60));


        // To get the minutes, subtract it with years,
        // months, seconds and hours and divide the
        // resultant date into total seconds i.e. 60
    $minutes = floor(($diff - $years * 365*60*60*24
        - $months*30*60*60*24 - $days*60*60*24
        - $hours*60*60)/ 60);


// To get the minutes, subtract it with years,
// months, seconds, hours and minutes
    $seconds = floor(($diff - $years * 365*60*60*24
        - $months*30*60*60*24 - $days*60*60*24
        - $hours*60*60 - $minutes*60));

// Print the result
    return $return = [
        'years' => $years,
        'months' => $months,
        'days' => $days,
        'hours' => $hours,
        'minutes' => $minutes,
        'seconds' => $seconds
    ];
} 











function sendGuardMail($data) {

    $root= $_SERVER['HTTP_HOST'];
    $root = explode('.', $root);
    $postfix = 'staffingsolution';
    if($root[0] != 'wwww'){
        $postfix = $root[0];
    }else{
        $postfix = $root[1];
    }
    $config_title = config('custom.title');   
    $user =DB::table('administrators')->where('is_super_admin',1)->first();

        //   $to = $user->email;
    $to ='hussainhanif1612@gmail.com';
    $subject ='Uncovered Shifts ';

    // $from = 'no-reply@'.$_SERVER['HTTP_HOST'];
    $from = $postfix.'@247staffingsolution.com.au';
    $logo1 = config('custom.logo');

        //   $logo2 = base_url("files/email-template/ASIAL-Member-Logo-11.png");

        //   $logo3 = base_url("files/email-template/labour-hire-authority-post-banner-1.jpg");



  // To send HTML mail, the Content-type header must be set

    $headers  = 'MIME-Version: 1.0' . "\r\n";

    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



  // Create email headers

    $headers .= 'From: '.$from."\r\n".

    'Reply-To: '.$from."\r\n" .

    'X-Mailer: PHP/' . phpversion();



          // Compose a simple HTML email message

    $message = 'Hello '. $user->name . ',<br><br>';


    
    $message.=' <div style="padding-bottom: 30px">Please acknowledge the uncovered shift of this weak below.</div>';
    $message.='<h3  align="center" style="font-weight:bolder ;color :black; text-align:center">Uncovered Shifts </h3>';
    $message.='<table   align="center" border="1" cellpadding="3" cellspacing="3"   ><thead align="center"><tr><th>Site Name</th><th>Date</th></tr></thead><tbody>';
    foreach($data as $result){
        $message.='<tr align="center" ><td>'.$result->site_name.'</td><td>'.date('d-m-y', strtotime($result->temp_date)).'</td></tr>';
    }
    $message.='</tbody></table>';
    $message.='<div style="padding-bottom: 10px">Kind regards,
    <br>The '.$config_title.' Team.
    </div></div></td></tr><tr>
    <td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
    <p>'.config('custom.address').'</p>
    <p>Copyright ©
    <a href="https://keenthemes.com" rel="noopener" target="_blank">'.$config_title.'</a>.</p>
    </td></tr></tbody>
    </table>
    </div>';


        // $message .= '<div style="height:100%;width:100%;">Please acknowledge the new shift by clicking';
        // $message.=' <a href="'.$_SERVER['HTTP_HOST'].'/job_roster">here</a>';
        // $message.=', as soon as possible.</div>';
          // $message .= '<img src="'.$logo3.'" style="width:33%;float:left;padding-top:2.5rem;"/>';



  // Sending email
    try{
      mail($to, $subject, $message, $headers);
  }catch(Exception $e)
  {

  }

  
}

function test_view($data)

{
    $message = 'Hello Hissaom<br><br>';


    
    $message.=' <div style="padding-bottom: 30px">Please acknowledge the uncovered shift of this weak below.</div>';
    $message.='<h3  align="center" style="font-weight:bolder ;color :black; text-align:center">Uncovered Shifts </h3>';
    $message.='<table   align="center" border="1" cellpadding="3" cellspacing="3"   ><thead align="center"><tr><th>Site Name</th><th>Date</th></tr></thead><tbody>';
    foreach($data as $result){
        $message.='<tr align="center" ><td>'.$result->site_name.'</td><td>'.date('d-m-y', strtotime($result->temp_date)).'</td></tr>';
    }
    $message.='</tbody></table>';
    $config_title = config('custom.title');   

    $message.='<div style="padding-bottom: 10px">Kind regards,
    <br>The '.$config_title.' Team.
    </div></div></td></tr><tr>
    <td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
    <p>'.config('custom.address').'</p>
    <p>Copyright ©
    <a href="https://keenthemes.com" rel="noopener" target="_blank">'.$config_title.'</a>.</p>
    </td></tr></tbody>
    </table>
    </div>';
    return $message;

//   
}



}
