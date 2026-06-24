<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Resources\Admin\AdminResource;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Leave\LeaveCollection;
use App\Http\Resources\Leave\LeaveResource;
use App\Models\AuditForm;
class AdminController extends ApiController
{
    public  $administrator;

    public function __construct(Request $request, Administrator $administrator)
    {
        parent::__construct($request);
        $this->administrator = $administrator;
    }
    //
    function updateNotificationToken(Request $request)
    {
        $this->request = $request;
        $this->setValidationRules(['notification_token' => 'required', 'admin_id' => 'required']);
        if ($this->isValidRequest()) {
            $this->response = ['success' => false, 'error' => $this->getErrors()];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }
        $save = Administrator::where('id', $request->admin_id)->update(['notification_token' => $request->notification_token]);
        if($save){
            $this->response = ['status' => true, 'message' => 'Notification token save successfully.'];
        }else{
            $this->response = ['status' => false, 'error' => 'Fail to update notification token!'];
        } 
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
    
    public function login(Request $request) 
    {
        $this->request = $request;
        $this->setValidationRules(['email' => 'required|email', 'password' => 'required']);
        if ($this->isValidRequest()) {
            $this->response = ['success' => false, 'error' => $this->getErrors()];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }

        $user = Administrator::where(['email'=> $request->input('email'), 'status' => 'active'])->first();
        if (empty($user)) {
            // Temp code wll remove when permissions done

             $this->response = ['status' => false, 'error' => 'Your account is inactive please contact your Administrator.'];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }
        if($user && $user->status !== Administrator::ACTIVE_STATUS) {
            $this->response = ['status' => false, 'error' => 'Your account is inactive please contact your Administrator.'];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }

        if($user && Hash::check($request->input('password'), $user->password)){
            if ($user->specific_sites != '') {
                $specific_sites_id = json_decode($user->specific_sites, true);
                if (is_array($specific_sites_id) && !empty($specific_sites_id)) {
                    $specific_sites = DB::table('jobs')
                    ->where(function($query) use ($specific_sites_id){
                        foreach ($specific_sites_id as $key => $id) {
                            if ($key == 0) {
                                $query->where('id', $id);
                            }else{
                                $query->orWhere('id', $id);

                            }
                        }
                    })
                    ->select('id', 'site_name', 'site_description')->get();
                    
                }else{
                    $specific_sites = array();

                }
            }else{
                $specific_sites = array();
            }
            $user->specific_sites = $specific_sites;
            if ($user->specific_customer != '') {
                $specific_customer_id = json_decode($user->specific_customer, true);
                if (is_array($specific_customer_id) && !empty($specific_customer_id)) {
                    $specific_customer = DB::table('customers')
                    ->where(function($query) use ($specific_customer_id){
                        foreach ($specific_customer_id as $key => $id) {
                            if ($key == 0) {
                                $query->where('id', $id);
                            }else{
                                $query->orWhere('id', $id);

                            }
                        }
                    })
                    ->select('id', 'name')->get();
                    
                }else{
                    $specific_customer = array();

                }
            }else{
                $specific_customer = array();
            }
            $access = DB::table('acces_level_defination')->where('id', $user->access_level_id)->first();
            $user->specific_customer = $specific_customer;
            $user->access = $access;
            if (!empty($access)) {
                $user->acces_level = $access->title;
                $permissions = json_decode($access->permissions, true);
                if ($user->is_super_admin == 1) {
                    foreach ($permissions as $key => $value) {
                        if ($value == 'false' || $value == false) {
                            $permissions[$key] = true;
                        }
                        if ($value == 'view_only') {
                            $permissions[$key] = 'full_access';
                        }
                    }
                }
                $user->permissions = $permissions;

            }else{
               $user->permissions = array();
           }
           return new AdminResource($user);
       }
       $this->response = ['status' => false, 'error' => 'Username or Password invalid.'];
       $this->statusCode = self::STATUS_CODE_200;
       return $this->sendResponse();
   }

   public function guardLeaveRequests(Request $request)
   {
    $this->request = $request;
        // $this->setValidationRules(['admin_id' => 'required|email']);
        // if ($this->isValidRequest()) {
        //     $this->response = ['success' => false, 'error' => $this->getErrors()];
        //     $this->statusCode = self::STATUS_CODE_200;
        //    return $this->sendResponse();
        // }
    $leaveRequests = DB::table('guard_leave_requests')->join('guards', 'guards.id', '=', 'guard_leave_requests.guard_id')->where('guard_leave_requests.status', 'pending')->select('guard_leave_requests.*', 'guards.name')->get();
    if (count($leaveRequests) > 0) {
        return new LeaveCollection(LeaveResource::collection($leaveRequests));
    }
    $this->response = ['status' => false, 'error' => 'No data found!'];
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}

public function changeGuardLeaveStatus(Request $request, $status, $leaveId)
{
    $check = DB::table('guard_leave_requests')->where('id', $leaveId)->update(['status' => $status]);
    if ($check) {
        $this->response = ['status' => true, 'message' => 'Leave '.$status];
    }else{
        $this->response = ['status' => false, 'error' => 'Not '.$status];
    }
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}
function administrators(Request $request)
{
    $admins = DB::table('administrators')
    ->join('acces_level_defination','acces_level_defination.id','=','administrators.access_level_id')
    ->select('administrators.*','acces_level_defination.id as access_id','acces_level_defination.title as role_name')
    ->where('status', '!=', 'deleted')->orderBy('administrators.name', 'ASC')->get();
    if (count($admins) > 0) {
        foreach ($admins as $admin) {
            $admin->specific_sites_id = json_decode($admin->specific_sites_id, true);
            $admin->multiple_states = json_decode($admin->multiple_states, true);
            $admin->specific_customer = json_decode($admin->specific_customer, true);
            $admin->specific_sites = json_decode($admin->specific_sites, true);
            if ($admin->image != '' || $admin->image != null) {
                $admin->image = $admin->image != '' ? 'https://'.request()->getHttpHost().'/asset_uploads/'.$admin->image : "";
            }
        }
        $this->response = ['status' => true, 'message' => 'Data found', 'admins' => $admins];
    }else{
        $this->response = ['status' => false, 'error' => 'Not admin found!'];
    }
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}
function getAccess(Request $request)
{
    $access = DB::table('acces_level_defination')
    ->orderBy('title', 'ASC')->get();
    if (count($access) > 0) {
        foreach ($access as $a) {
            $a->specific_customer = json_decode($a->specific_customer, true);
            $a->sites = json_decode($a->sites, true);
            $a->permissions = json_decode($a->permissions, true);
            $a->permissions['break_bypass'] = true;
            $a->permissions['hour_16_limit'] =  isset($a->permissions['16_hour_limit']) ? $a->permissions['16_hour_limit'] : false;
        }
        $this->response = ['status' => true, 'message' => 'Data found', 'access' => $access];
    }else{
        $this->response = ['status' => false, 'error' => 'Not access found!'];
    }
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}

public function editUser($id, Request $request)
{
    $admin_id = 0;
    if ($request->has('admin_id') && $request->admin_id != '') {
        $admin_id =  $request->admin_id;
    }
    $image = $request->file('avatar');
    if($image){
        $filename = time().'.'.$image->getClientOriginalExtension();
        $public_path = public_path();
        $public_path = str_replace('portal/public', '', $public_path);
        $public_path = str_replace('apis/public', '', $public_path);
        $destinationPath = $public_path.'asset_uploads/';
        $save = $image->move($destinationPath, $filename);

    }else{
        $filename = DB::table('administrators')->where('id', $id)->value('image');;
    }
    $data['image'] = $filename;
    if($request->has('name')){
        $data['name'] = $request->name;
    }
    if($request->has('access_level_id')){
        $data['access_level_id'] = $request->access_level_id;
    }
    if($request->has('multiple_states')){
        $request->multiple_states = explode(',', $request->multiple_states);
        $data['multiple_states'] = json_encode($request->multiple_states);
    }
    if($request->has('state')){
      $data['state'] = $request->state;
  }
  if($request->has('status')){
      $data['status'] = $request->status;
  }
  $data=  DB::table('administrators')->where('id', $id)->first();

  $query=  DB::table('administrators')
  ->where('id', $id)
  ->update($data);
  if($query){
    $action = 'admin_update';
    $this->administrator->log_user_activity($action, $data, $admin_id);
    $this->response = ['status' => true, 'message' => 'Profile update successfully.'];
}else{
    $this->response = ['status' => false, 'error' => 'Fail to update profile!'];
}
$this->statusCode = self::STATUS_CODE_200;
return $this->sendResponse();
}

public function deleteUser($id, Request $request){
    $admin_id = 0;
    if ($request->has('admin_id') && $request->admin_id != '') {
        $admin_id =  $request->admin_id;
    }
    $data=  DB::table('administrators')->where('id', $id)->first();
    $query=  DB::table('administrators')->where('id', $id)->update(['status' => "deleted"]);
    if($query){
        $action = 'admin_delete';
        $this->administrator->log_user_activity($action, $data, $admin_id);
        $this->response = ['status' => true, 'message' => 'Profile deleted successfully.'];
    }else{
        $this->response = ['status' => false, 'error' => 'Fail to delete profile!'];
    }
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}

function updateAccess(Request $request, $id)
{
    $role_name = $request->title;
//     $data['dashboard'] = true;
//     $data['job_roster'] = ($request->has('job_roster') && $request->job_roster == true) ? true : false;
//     $data['add_site'] = ($request->has('add_site') && $request->add_site == true) ? true : false;
//     $data['adhoc_shift'] = ($request->has('adhoc_shift') && $request->adhoc_shift == true) ? true : false;
//     $data['roster_report'] = ($request->has('roster_report') && $request->roster_report == true) ? true : false;
//     $data['roster_action'] = ($request->has('roster_action') && $request->roster_action == true) ? true : false;
//     $data['view_by_guard'] = ($request->has('view_by_guard') && $request->view_by_guard == true) ? true : false;
//     $data['roster_shifts'] = ($request->has('roster_shifts') && $request->roster_shifts == true) ? true : false;
//     $data['site_edit_delete'] = ($request->has('site_edit_delete') && $request->site_edit_delete == true) ? true : false;
//     $data['timesheet'] = ($request->has('timesheet') && $request->timesheet == true) ? true : false;
//     $data['leave_management'] = ($request->has('leave_management') && $request->leave_management == true) ? true : false;
//     $data['time_clock'] = ($request->has('time_clock') && $request->time_clock == true) ? true : false;
//     $data['job_tracker'] = ($request->has('job_tracker') && $request->job_tracker == true) ? true : false;
//     $data['administrator'] = ($request->has('administrator') && $request->administrator == true) ? true : false;
//     $data['guard'] = ($request->has('guard') && $request->guard == true) ? true : false;
//     $data['customer'] = ($request->has('customer') && $request->customer == true) ? true : false;
//     $data['contractor'] = ($request->has('contractor') && $request->contractor == true) ? true : false;
//     $data['reports'] = ($request->has('reports') && $request->reports == true) ? true : false;
//     $data['guard_report'] = ($request->has('guard_report') && $request->guard_report == true) ? true : false;
//     $data['customer_report'] = ($request->has('customer_report') && $request->customer_report == true) ? true : false;
//     $data['contractor_report'] = ($request->has('contractor_report') && $request->contractor_report == true) ? true : false;
//     $data['green_and_welfare_report'] = ($request->has('green_and_welfare_report') && $request->green_and_welfare_report == true) ? true : false;
//     $data['task_report'] = ($request->has('task_report') && $request->task_report == true) ? true : false;
//     $data['paysheet_report'] = ($request->has('paysheet_report') && $request->paysheet_report == true) ? true : false;
//     $data['incident_report'] = ($request->has('incident_report') && $request->incident_report == true) ? true : false;
//     $data['invoice_report'] = ($request->has('invoice_report') && $request->invoice_report == true) ? true : false;
//     $data['complete_report'] = ($request->has('complete_report') && $request->complete_report == true) ? true : false;
//     $data['staff_audit'] = ($request->has('staff_audit') && $request->staff_audit == true) ? true : false;
//     $data['communication'] = ($request->has('communication') && $request->communication == true) ? true : false;
//     $data['tutorial'] = ($request->has('tutorial') && $request->tutorial == true) ? true : false;
//     $data['announcements'] = ($request->has('announcements') && $request->announcements == true) ? true : false;
//     $data['rosterControl'] = ($request->has('rosterControl') && $request->rosterControl == true) ? true : false;
//     $data['charge_rates'] = ($request->has('charge_rates') && $request->charge_rates == true) ? true : false;
//     $data['pay_rates'] = ($request->has('pay_rates') && $request->pay_rates == true) ? true : false;
//     $data['app_settings'] = ($request->has('app_settings') && $request->app_settings == true) ? true : false;
//     $data['break_bypass'] = ($request->has('break_bypass') && $request->break_bypass == true) ? true : false;
//     $data['lock_roster'] = ($request->has('lock_roster') && $request->lock_roster == true) ? true : false;
//     $data['16_hour_limit'] = (isset($_POST['16_hour_limit']) && $_POST['16_hour_limit'] == true) ? true : false;
//         // $data['sites'] = $sites;

//     foreach ($data as $key => $value) {
//        if ($value == '') {
//           $data[$key] = false;
//       }else{
//           $data[$key] = true;

//       }
//   }
//   foreach ($data as $key => $value) {
//    $data[$key.'_full_access'] = $request->has($key.'_full_access') ? $request->$key.'_full_access' : 'view_only';
// }
    $dat['permissions'] = json_decode(json_encode($request->permissions), true);

    if (isset($dat['permissions']['hour_16_limit'])) {
        $dat['permissions']['16_hour_limit'] = $dat['permissions']['hour_16_limit'];
    }
    $dat['permissions'] = json_encode($dat['permissions']);
    $result = DB::table('acces_level_defination')
    ->where('id', $id)
    ->update(['title'=> $role_name , 'permissions' =>$dat['permissions']]);
    if ($result) {
        $this->response = ['status' => true, 'message' => 'Access update successfully.'];
    }else{
        $this->response = ['status' => false, 'error' => 'Fail to update access!'];

    }
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}

public function deleteAccess($id){
   $query=  DB::table('acces_level_defination')->where('id', $id)->delete();
   if($query){
    $this->response = ['status' => true, 'message' => 'Access deleted Successfully'];
}else{
    $this->response = ['status' => false, 'error' => 'Fail to deleted access!'];
}
$this->statusCode = self::STATUS_CODE_200;
return $this->sendResponse();
}

function submitAuditForm(Request $request)
{
    $auditForm = new AuditForm();
    $auditForm->customer_id = $request->customer_id;
    $auditForm->site_id = $request->site_id;
    $auditForm->guard_id = ($request->has('guard_id') && $request->guard_id != '') ? $request->guard_id : '';
    $auditForm->guard_name = $request->guard_name;
    $auditForm->guard_email = $request->guard_email;
    $auditForm->guard_phone = $request->guard_phone;
    $auditForm->guard_security_license = $request->guard_security_license;
    $auditForm->guard_license_expiry = $request->guard_license_expiry;
    $auditForm->admin_id = $request->admin_id;
    $auditForm->have_uniform = $request->have_uniform;
    $auditForm->uniform_text = $request->uniform_text;
    if ($request->has('uniform_image') && count($request->uniform_image)>0) {
        $auditForm->uniform_image = $request->uniform_image[0];
    }
    $auditForm->have_shoes = $request->have_shoes;
    $auditForm->shoes_text = $request->shoes_text;
    if ($request->has('shoes_image') && count($request->shoes_image)>0) {
        $auditForm->shoes_image = $request->shoes_image[0];
    }
    $auditForm->have_license = $request->have_license;
    $auditForm->license_text = $request->license_text;
    if ($request->has('license_image') && count($request->license_image)>0) {
        $auditForm->license_image = $request->license_image[0];
    }
    $auditForm->have_induction_card = $request->have_induction_card;
    $auditForm->induction_card_text = $request->induction_card_text;
    if ($request->has('induction_card_image') && count($request->induction_card_image)>0) {
        $auditForm->induction_card_image = $request->induction_card_image[0];
    }
    $auditForm->have_notebook_pen = $request->have_notebook_pen;
    $auditForm->notebook_pen_text = $request->notebook_pen_text;
    if ($request->has('notebook_pen_image') && count($request->notebook_pen_image)>0) {
        $auditForm->notebook_pen_image = $request->notebook_pen_image[0];
    }
    $auditForm->log_book = $request->log_book;
    $auditForm->book_text = $request->book_text;
    if ($request->has('log_book_image') && count($request->log_book_image)>0) {
        $auditForm->log_book_image = $request->log_book_image[0];
    }
    $auditForm->on_time = $request->on_time;
    $auditForm->on_time_text = $request->on_time_text;
    if ($request->has('on_time_image') && count($request->on_time_image)>0) {
        $auditForm->on_time_image = $request->on_time_image[0];
    }
    $auditForm->job_understanding = $request->job_understanding;
    $auditForm->job_understanding_text = $request->job_understanding_text;
    if ($request->has('job_understanding_image') && count($request->job_understanding_image)>0) {
        $auditForm->job_understanding_image = $request->job_understanding_image[0];
    }
    $auditForm->have_firstaid = $request->have_firstaid;
    $auditForm->firstaid_text = $request->firstaid_text;
    if ($request->has('firstaid_image') && count($request->firstaid_image)>0) {
        $auditForm->firstaid_image = $request->firstaid_image[0];
    }
    $auditForm->have_site_knowledge = $request->have_site_knowledge;
    $auditForm->site_knowledge_text = $request->site_knowledge_text;
    if ($request->has('site_knowledge_image') && count($request->site_knowledge_image)>0) {
        $auditForm->site_knowledge_image = $request->site_knowledge_image[0];
    }
    $auditForm->have_assigned_petrol = $request->have_assigned_petrol;
    $auditForm->assigned_petrol_text = $request->assigned_petrol_text;
    if ($request->has('assigned_petrol_image') && count($request->assigned_petrol_image)>0) {
        $auditForm->assigned_petrol_image = $request->assigned_petrol_image[0];
    }
    $auditForm->have_rsa_certificate = $request->have_rsa_certificate;
    $auditForm->rsa_certificate_text = $request->rsa_certificate_text;
    if ($request->has('rsa_certificate_image') && count($request->rsa_certificate_image)>0) {
        $auditForm->rsa_certificate_image = $request->rsa_certificate_image[0];
    }
    $auditForm->have_white_card = $request->have_white_card;
    $auditForm->white_card_text = $request->white_card_text;
    if ($request->has('white_card_image') && count($request->white_card_image)>0) {
        $auditForm->white_card_image = $request->white_card_image[0];
    }
    $auditForm->have_children_check = $request->have_children_check;
    $auditForm->children_check_text = $request->children_check_text;
    if ($request->has('children_check_image') && count($request->children_check_image)>0) {
        $auditForm->children_check_image = $request->children_check_image[0];
    }
    $auditForm->have_site_eqipment = $request->have_site_eqipment;
    $auditForm->site_eqipment_text = $request->site_eqipment_text;
    if ($request->has('site_eqipment_image') && count($request->site_eqipment_image)>0) {
        $auditForm->site_eqipment_image = $request->site_eqipment_image[0];
    }
    $auditForm->have_well_groomed = $request->have_well_groomed;
    $auditForm->well_groomed_text = $request->well_groomed_text;
    if ($request->has('well_groomed_image') && count($request->well_groomed_image)>0) {
        $auditForm->well_groomed_image = $request->well_groomed_image[0];
    }
    $auditForm->have_emergency_protocol = $request->have_emergency_protocol;
    $auditForm->emergency_protocol_text = $request->emergency_protocol_text;
    if ($request->has('emergency_protocol_image') && count($request->emergency_protocol_image)>0) {
        $auditForm->emergency_protocol_image = $request->emergency_protocol_image[0];
    }
    $auditForm->have_on_site = $request->have_on_site;
    $auditForm->on_site_text = $request->on_site_text;
    if ($request->has('on_site_image') && count($request->on_site_image)>0) {
        $auditForm->on_site_image = $request->on_site_image[0];
    }

    if ($request->has('signature') && $request->signature != '') {
        $auditForm->signature = $request->signature;
    }

    $auditForm->notes = $request->notes;
    $inserted = $auditForm->save();
    if($inserted){
        $this->response = ['status' => true, 'message' => 'Audit form submitted successfully.'];
    }else{
        $this->response = ['status' => false, 'error' => 'Fail to submit audit form!'];
    }
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();

}
private function publicPath()
{
    $public_path = app()->basePath('public');
    $public_path = str_replace('portal/public', '', $public_path);
    $public_path = str_replace('apis/public', '', $public_path);
    
    return $public_path;
}
private function getBaseUrl()
{
    $url = app()->make('request')->root();
    $url = str_replace('portal/public', '', $url);
    $url = str_replace('apis/public', '', $url);

    return $url;
}
public function uploadImage(Request $request){
    try {
        $base64Image = $request->file;
        $image = $this->saveBase64Image($base64Image);

        return response()->json(['success'=>true,'url' => $image], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
}
private function saveBase64Image($base64Image)
{
    $public_path = public_path();
    $public_path = str_replace('portal/public', '', $public_path);
    $public_path = str_replace('apis/public', '', $public_path);
    $destinationPath = $public_path.'asset_uploads/';
    $newName = Str::random(25);
    $fileName = $newName . '.png';

    $fileContent = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
    
    if (!$fileContent) {
        throw new \Exception('Failed to decode base64 image.');
    }

    if (!file_put_contents($destinationPath . $fileName, $fileContent)) {
        throw new \Exception('Failed to save image.');
    }

    $imageUrl = 'https://'.request()->getHttpHost().'/asset_uploads/'. $fileName;

    return $imageUrl;
}
private function uploader_base64($file) {
    if (is_array($file)) {
        $images = array();
        foreach ($file as $key => $f) {
            try {
                // $destinationPath =  rtrim('../../asset_uploads/');
                $public_path = public_path();
                $public_path = str_replace('portal/public', '', $public_path);
                $public_path = str_replace('apis/public', '', $public_path);
                $destinationPath = $public_path.'asset_uploads/';
                $newName = Str::random(25);
                $fileName = $newName . '.png';
                $f = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $f));
                file_put_contents($destinationPath.$fileName, $f);
                $images[] = $fileName;
            } catch (Exception $e) {

            }
        }
        return json_encode($images);
    }else{
        try {
            // $destinationPath =  rtrim('../../asset_uploads/');
            $public_path = public_path();
            $public_path = str_replace('portal/public', '', $public_path);
            $public_path = str_replace('apis/public', '', $public_path);
            $destinationPath = $public_path.'asset_uploads/';
            $newName = Str::random(25);
            $fileName = $newName . '.png';
            $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
            file_put_contents($destinationPath.$fileName, $file);
            return $fileName;
        } catch (Exception $e) {
            return '';
        }
    }
}
function getImageUrl($images)
{
    if (is_array($images)) {
    foreach ($images as $key => $i) {
        $images[$key] = 'https://'.request()->getHttpHost().'/asset_uploads/'.$i;
    }
    return $images;
    }else{
        return [];
    }
}

function getAduitData(Request $request, $id)
{
    $audit_forms = DB::table('audit_form')->where('admin_id', $id)->latest()->get();
    foreach ($audit_forms as $key => $af) {
        $customer = DB::table('customers')->where('id', $af->customer_id)->select('name')->first();
        $af->customer_name = $customer->name;
        $site = DB::table('jobs')->where('id', $af->site_id)->select('site_name', 'site_description')->first();
        $af->site_name = $site->site_name;
        // if ($af->uniform_image != '') {
        //     $af->uniform_image = $this->getImageUrl([$af->uniform_image]);
        // }
        // if ($af->shoes_image != '') {
        //     $af->shoes_image = $this->getImageUrl([$af->shoes_image]);
        // }
        // if ($af->license_image != '') {
        //     $af->license_image = $this->getImageUrl([$af->license_image]);
        // }
        // if ($af->induction_card_image != '') {
        //     $af->induction_card_image = $this->getImageUrl([$af->induction_card_image]);
        // }
        // if ($af->notebook_pen_image != '') {
        //     $af->notebook_pen_image = $this->getImageUrl([$af->notebook_pen_image]);
        // }
        // if ($af->log_book_image != '') {
        //     $af->log_book_image = $this->getImageUrl([$af->log_book_image]);
        // }
        // if ($af->on_time_image != '') {
        //     $af->on_time_image = $this->getImageUrl([$af->on_time_image]);
        // }
        // if ($af->job_understanding_image != '') {
        //     $af->job_understanding_image = $this->getImageUrl([$af->job_understanding_image]);
        // }
        // if ($af->firstaid_image != '') {
        //     $af->firstaid_image = $this->getImageUrl([$af->firstaid_image]);
        // }
        // if ($af->site_knowledge_image != '') {
        //     $af->site_knowledge_image = $this->getImageUrl([$af->site_knowledge_image]);
        // }
        // if ($af->assigned_petrol_image != '') {
        //     $af->assigned_petrol_image = $this->getImageUrl([$af->assigned_petrol_image]);
        // }
        // if ($af->rsa_certificate_image != '') {
        //     $af->rsa_certificate_image = $this->getImageUrl([$af->rsa_certificate_image]);
        // }
        // if ($af->white_card_image != '') {
        //     $af->white_card_image = $this->getImageUrl([$af->white_card_image]);
        // }
        // if ($af->children_check_image != '') {
        //     $af->children_check_image = $this->getImageUrl([$af->children_check_image]);
        // }
        // if ($af->site_eqipment_image != '') {
        //     $af->site_eqipment_image = $this->getImageUrl([$af->site_eqipment_image]);
        // }
        // if ($af->well_groomed_image != '') {
        //     $af->well_groomed_image = $this->getImageUrl([$af->well_groomed_image]);
        // }
        // if ($af->on_site_image != '') {
        //     $af->on_site_image = $this->getImageUrl([$af->on_site_image]);
        // }
        // if ($af->emergency_protocol_image != '') {
        //     $af->emergency_protocol_image = $this->getImageUrl([$af->emergency_protocol_image]);
        // }
        // if ($af->signature != '') {
        //     $af->signature = 'https://'.request()->getHttpHost().'/asset_uploads/'.$af->signature;
        // }
    }

    if (count($audit_forms) > 0) {
        $this->response = ['status' => true, 'message' => 'Audit form data', 'data' => $audit_forms];
    }else{
        $this->response = ['status' => false, 'error' => 'No Audit form data.'];
    }
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}
public function BusinessData()
{
    $demo_businesses = DB::connection('mysql2')->table('business_data')->where('show_status', 1)->select('business_data.*')->get();
        // $demo_businesses = DB::connection('mysql2')->table('business_data')->where('business_type', '=', 'demo')->select('business_data.id', 'business_data.title', 'business_data.domain', 'business_data.unique_id')->get();

    if (count($demo_businesses) > 0) {
        $demo = array();
        foreach ($demo_businesses as $db) {
            $demo[] = array(
                'title' => $db->title,
                'subTitle' => $db->sub_title,
                'logo' => $db->logo != '' ? 'https://'.request()->getHttpHost().'/asset_uploads/'.$db->logo : "",
                'bundleID' => $db->bundle_id,
                'appName' => $db->title,
                'oneSignalAppID' => $db->app_id,
                'oneSignalServerKey' => $db->server_key,
                'oneSignalSenderID' => $db->one_signal_sender_id,
                'domain'=> 'https://'.$db->domain.'.247staffingsolutions.com.au/',
                'id' => $db->id,
                'businessType' => $db->business_type,
                'uniqueID' => $db->unique_id
            );
        }
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'status' => true,
            'message' => 'Demo business Found.',
            'data' => $demo
        ];
        return $this->sendResponse();
    }
    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'status' => false,
        'message' => 'No business found!',
        'data' => null
    ];
    return $this->sendResponse();
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
    $roster=DB::table('job_new_roster')->whereMonth('temp_start',$month_number[$i])->get();
    $hours=0;

    foreach($roster as $result){
        $hour = $this->getTimeDiff($result->temp_start, $result->temp_end);
        $hour1=$hour['hours'];
        $hours=$hours + $hour1;
    }
    $tt[0]=$hours;

    $hourss[$i]=$tt[0];
    $shifts[$i]=$roster->count();
    $roster1=DB::table('job_new_roster')->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')->where('job_new_roster.job_status','completed')->whereMonth('job_new_roster.temp_start',$month_number[$i])->get();
    $completed_shifts[$i]=$roster1->count();
        // $jobs=DB::table('jobs')->where('job_status','completed')->whereMonth('TIMESTAMP_INSERTED',$month_number[$i])->get();
        // $jobs1=DB::table('jobs')->where('job_status','upcoming')->whereMonth('TIMESTAMP_INSERTED',$month_number[$i])->get();
    $roster_completed=DB::table('job_new_roster')->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')->where('job_new_roster.job_status','completed')->whereMonth('job_new_roster.temp_start',$month_number[$i])->get();
    $roster_upcoming=DB::table('job_new_roster')->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')->where('job_new_roster.job_status','pending')->whereMonth('job_new_roster.temp_start',$month_number[$i])->get();

    $completed_jobs[$i]=$roster_completed->count();
    $upcoming_jobs[$i]=$roster_upcoming->count();



}

return ['months'=>$months,'shifts'=>$shifts,'completed_shifts'=>$completed_shifts,'completed_jobs'=>$completed_jobs,'hours'=>$hourss,'upcoming_jobs'=>$upcoming_jobs];
}

function getStats()
{
    $active_guards_query =  DB::table('guards');
    $active_guards_count = $active_guards_query->where('guards.status', 'active')
    ->where('guards.is_approved', 'yes')
    ->where('guards.address','!=','')
    ->where('guards.gender','!=','')
    ->where('guards.phone','!=','')
    ->where('guards.name','!=','')
    ->where('guards.name','!=',null)
    ->where('guards.email','!=','')
    ->where('guards.email','!=',null)
    ->where('guards.emergency_contact_phone','!=','')
    ->where('guards.security_license_number','!=','')
    ->where('guards.security_license_file','!=','')
    ->where('guards.payroll_bank_account_number','!=','')
    ->where('guards.payroll_bank_name','!=','')->orderBy('name', 'ASC')->count();

    $pending_guards_query =  DB::table('guards');
    $pending_guards_count = $pending_guards_query->where('guards.status', 'inactive')
    ->where('guards.is_approved', 'yes')
    ->where('guards.address','!=','')
    ->where('guards.state','!=','')
    ->where('guards.gender','!=','')
    ->where('guards.emergency_contact_phone','!=','')
    ->where('guards.security_license_number','!=','')
    ->where('guards.security_license_file','!=','')
    ->where('guards.payroll_bank_account_number','!=','')
    ->where('guards.payroll_bank_name','!=','')
    ->orderBy('name', 'ASC')->count();

    $new_guards_count =  DB::table('guards')
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


    })

    ->orderBy('name', 'ASC')->count();

    // $pending_guards_count=$pending_guards->count();
    // $active_guards_count=$active_guards->count();
    // $new_guards_count=$new_guards->count();
//roster
    $shifts_count = DB::table('job_new_roster')->select('roster_id')->count();
    $completed_shifts_count=DB::table('job_new_roster')->where('job_status', 'completed')->select('roster_id')->count();
    // $completed_shifts_count=$completed_shifts->count();
    // $shifts_count=$roster->count();
    $completed_jobs_count= DB::table('job_new_roster')->where('job_new_roster.job_status' , "completed")->count();

    $auto_completed_jobs_count=  $shifts =  DB::table('job_new_roster')->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')->join('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')->where('job_new_roster.job_status' , "completed")->where(function($query) {
        $query->where('job_roster_activities.signout_time' , '!=', "")
        ->orWhere('job_roster_activities.signout_selfie' , '!=', "");
    })->count();


    $asap_job_notification_counter=DB::table('job_new_roster')->where('job_new_roster.asap_job_notification_counter' , 1)->count();
    $upcoming=$this->get_records($status="pending");
    $ongoing=$this->get_records($status="inprogress");
    $missed=$this->get_records($status="missed");

    $missed_count=count($missed);
    $ongoing_count=count($ongoing);
    $upcoming_count=count($upcoming);
    // $roster_progress = $this->roster_progress();
    // $yearly_stats = $this->shifts_hour_chart();
    return response()->json(['success' => true,
        // 'roster_progress' => $roster_progress,
        'upcoming_count' => $upcoming_count,
        'ongoing_count' => $ongoing_count,
        'missed_count' => $missed_count,
        'asap_job_notification_counter' => $asap_job_notification_counter,
        // 'yearly_stats' => $yearly_stats,

        'pending_guards_count' => $pending_guards_count,
        'completed_shifts_count' => $completed_shifts_count,
        'completed_jobs_count' => $completed_jobs_count,
        'shifts_count' => $shifts_count,
        'new_guards_count' => $new_guards_count,
        'active_guards_count' => $active_guards_count,
        'auto_completed_jobs_count' => $auto_completed_jobs_count,
    ]);
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
public function get_records($status){
    $query_append = '';
    $extra_query = '';
    if ($status == 'completed' || $status == 'confirmed') {
        $result = DB::select(
            "SELECT
            jr.*
            FROM job_new_roster AS jr
            INNER JOIN `guards` AS g ON g.`id` = jr.`guard_id`
            WHERE ".$extra_query."jr.`temp_end` <= '".date('Y-m-d H:i:s')."' AND (jr.`job_status` = '".$status."' OR jr.`job_status`='pending' OR jr.`job_status` = 'confirmed') ORDER BY jr.job_end DESC LIMIT 50"
        );
    }elseif($status == 'inprogress'){
        $result = DB::select(
          "SELECT
          jr.`roster_id`
          FROM job_new_roster AS jr
          INNER JOIN job_roster_activities AS jsa ON jsa.`job_roster_id` = jr.`roster_id`
          INNER JOIN `guards` AS g ON g.`id` = jr.`guard_id`
          WHERE ".$extra_query."jr.`temp_start` >= '".date('Y-m-d')."' AND jr.`job_status` = 'confirmed' ORDER BY jr.temp_start ASC"
      );
    }elseif($status == 'pending'){
        $result = DB::select(
            "SELECT
            jr.`roster_id`
            FROM job_new_roster AS jr
            WHERE ".$extra_query."jr.`temp_start` >= '".date('Y-m-d')."' AND (jr.`job_status` = '".$status."' OR jr.`job_status` = 'confirmed') ORDER BY jr.temp_start ASC LIMIT 50"
        );
    }elseif($status == 'missed')
    {
     $result = DB::select(
        "SELECT
        jr.`roster_id`
        FROM job_new_roster AS jr
        WHERE ".$extra_query."jr.`temp_start` <='".date('Y-m-d H:i:s')."' AND jr.`temp_end` >= '".date('Y-m-d H:i:s', time())."' AND jr.`signin_status` = 0 AND (jr.`job_status` = 'pending' OR jr.`job_status` = 'confirmed') ORDER BY jr.temp_start ASC"
    );
 }

 return $result;

}
function getGuardsList()
{
    // config(['app.timezone' => $this->timezone['Victoria']]);
        // date_default_timezone_set($this->timezone['Victoria']);
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
    return response()->json(['success' => true, 'adhoc_guards' => $adhoc_guards, 'core_guards' => $core_guards, 'core_site' => $core_site]);
}
function updateAuthenticationCode(Request $request)
{
    $this->request = $request;
    $this->setValidationRules(['authentication_code' => 'required']);
    if ($this->isValidRequest()) {
        $this->response = ['success' => false, 'error' => $this->getErrors()];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
    $is_any = DB::table('authentication_code')->first();
    if (!empty($is_any)) {
        $updated = DB::table('authentication_code')->where('id', $is_any->id)->update(['authentication_code' => $request->authentication_code]);
    }else{
        $updated = DB::table('authentication_code')->insert(['authentication_code' => $request->authentication_code]);
    }
    if ($updated) {
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'status' => true,
            'message' => 'Authentication code update successfully.',
        ];
        return $this->sendResponse();
    }

    $this->statusCode = self::STATUS_CODE_200;
    $this->response = [
        'status' => false,
        'message' => 'Fail to update code!',
    ];
    return $this->sendResponse();

}

}
