<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\guard_files;
use Carbon\Carbon;



class Guard extends Model
{
  use HasFactory;
  protected $table = 'guards';

  public function guard_files()
  {
    return $this->hasMany(guard_files::class, 'guard_id','id');
  }

  public function getAllsiteData($siteId, $start = null, $end = null)
  {
    $query = DB::table('job_new_roster')->where('site_id',$siteId)->where("publish_status","0")->where('guard_id', '!=', null)->where('guard_id', '!=', 0);
    if ($start != null) {

      $query->where('temp_start', '>=', date('Y-m-d 00:00:00', strtotime($start)));

    }
    if ($end != null) {
        // $end = strtotime($end) + (60*60*24);
        // $end = date('Y-m-d');

      $query->where('temp_start', '<=', date('Y-m-d 00:00:00', strtotime($end)));

    }
    $data = $query->get();
    return $data;
  }

  public function getAllsiteUpdateData($siteId, $start = null, $end = null)
  {
    $query = DB::table('job_new_roster')->where('site_id',$siteId)

      // ->where("publish_status", "1")
    ->where("record_update", 1)
    ->where('guard_id', '!=', null)
    ->where('guard_id', '!=', 0);
    if ($start != null) {

      $query->where('temp_start', '>=', date('Y-m-d 00:00:00', strtotime($start)));
    }
    if ($end != null) {
        // $end = strtotime($end) + (60*60*24);
        // $end = date('Y-m-d');

      $query->where('temp_start', '<=', date('Y-m-d 00:00:00', strtotime($end)));
    }
    $data = $query->get();
    return $data;
  }

  public function getAllsiteUpdateRollOverData($siteId, $start = null, $end = null)
  {
    $query = DB::table('job_new_roster')->where('site_id',$siteId)->where("roll_over",1)->where('guard_id', '!=', null)->where('guard_id', '!=', 0);
    if ($start != null) {

      $query->where('temp_start', '>=', date('Y-m-d 00:00:00', strtotime($start)));

    }
    if ($end != null) {
        // $end = strtotime($end) + (60*60*24);
        // $end = date('Y-m-d');

      $query->where('temp_start', '<=', date('Y-m-d 00:00:00', strtotime($end)));

    }
    $data = $query->get();
    return $data;
  }

  public function getAllSiteUpdateGuard($siteId)
  {
    $data = Db::table('job_new_roster')->join('guards', 'job_new_roster.guard_id','=', 'guards.id')->whereMonth('temp_date', date('m'))->whereYear('temp_date', date('Y'))->where('site_id',$siteId)
    ->where("record_update",1)

      // ->where("publish_status" , 1)
    ->select('job_new_roster.guard_id', 'guards.notification_token', 'guards.email', 'guards.name')->groupBy('guard_id')->get();

    return $data;

  }

  public function updatePublishStatus($roster_id){

    $data = array(

      "publish_status" => 1,
      'record_update' => 0,
      'roll_over' => 0,
      'update_status' => 1

    );

    DB::table('job_new_roster')->where('roster_id', $roster_id)->update($data);

    return true;

  }

  public function getAllSiteUpdateRollOverGuard($siteId){

      // $this->db->where('MONTH(temp_date)', date('m')); //For current month

      // $this->db->where('YEAR(temp_date)', date('Y')); // For current year

    $data = DB::table('job_new_roster')->join('guards', 'job_new_roster.guard_id', '=', 'guards.id')->where('site_id',$siteId)->where("roll_over",1)->groupBy('guard_id')->select('job_new_roster.guard_id', 'guards.notification_token', 'guards.email', 'guards.name')->get();
    return $data;

  }
  function send_push_notification($data){

    $content = array(
      "en" => $data['message']
      );

    $heading = array(
      "en" => $data['title']
      );
      $root = $_SERVER['HTTP_HOST'];
      $root = explode('.', $root);
      $sub_domain = 'staffingsolution';
      if($root[0] != 'wwww'){
          $sub_domain = $root[0];
      }else{
      $sub_domain = $root[1];
      }
      $config_data = DB::connection('mysql2')->table('business_data')->where('domain', '=', $sub_domain)->first();
    $fields = array(
      'app_id' => $config_data->app_id,
      'include_player_ids' => array($data['guards'][0]['notification_token']),
            'data' => array(
              'page' => $data['page'],
              'job_id' => isset($data['roster_id']) ? $data['roster_id'] : '1111',
              'job_data' => isset($data['job_data']) ? json_encode($data['job_data']) : json_encode(array())
              ),
      'contents' => $content,
      'headings' => $heading
    );
        
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
              'Authorization: Basic '.$config_data->server_key));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $result = curl_exec($ch);

    // echo $result;
    
    if ($result === FALSE) {
      die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;

    // $content = array(
    //   "en" => $data['message']
    //   );

    // $heading = array(
    //   "en" => $data['title']
    //   );

    // $fields = array(
    //   'app_id' => config('custom.app_id'),
    //   'include_player_ids' => array($data['guards'][0]['notification_token']),
    //         'data' => array(
    //           'page' => $data['page'],
    //           ),
    //   'contents' => $content,
    //   'headings' => $heading
    // );

    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
    //           'Authorization: Basic '.config('server_key')));
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    // curl_setopt($ch, CURLOPT_HEADER, FALSE);
    // curl_setopt($ch, CURLOPT_POST, TRUE);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    // $result = curl_exec($ch);
    // if ($result === FALSE) {
    //   // die('FCM Send Error: ' . curl_error($ch));
    // }
    // curl_close($ch);

    // return $result;

  }
  // function send_push_notification($data){



  //   $content = array(
  //     "en" => $data['message']
  //   );

  //   $heading = array(
  //     "en" => $data['title']
  //   );

  //   $fields = array(
  //     'app_id' => config('custom.app_id'),
  //     'include_player_ids' => array($data['guards'][0]['notification_token']),
  //     'data' => array(
  //       'page' => $data['page'],
  //     ),
  //     'contents' => $content,
  //     'headings' => $heading
  //   );

  //   $ch = curl_init();
  //   curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
  //   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
  //     'Authorization: Basic '.config('server_key')));
  //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  //   curl_setopt($ch, CURLOPT_HEADER, FALSE);
  //   curl_setopt($ch, CURLOPT_POST, TRUE);
  //   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
  //   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

  //   $result = curl_exec($ch);
  //   if ($result === FALSE) {
  //     // die('FCM Send Error: ' . curl_error($ch));
  //   }
  //   curl_close($ch);

  //   //return $result;

  // }

  public function getAllSiteGuard($siteId, $start = null, $end = null){

   $query = DB::table('job_new_roster')
   ->join('guards', 'job_new_roster.guard_id', '=', 'guards.id')
   ->where('site_id',$siteId)
   ->where("publish_status","0");
   if ($start != null) {
    $query->where('temp_start', '>=', date('Y-m-d 00:00:00', strtotime($start)));

  }
  if ($end != null) {
    $query->where('temp_start', '<=', date('Y-m-d 00:00:00', strtotime($end)));

  }
       // ->whereMonth('temp_date', date('m'))
       // ->whereYear('temp_date', date('Y'))
  $data = $query->groupBy('guard_id')
  ->select('job_new_roster.guard_id', 'guards.notification_token', 'guards.email', 'guards.name')
  ->get();

  return $data;

}

public function saveRoster($siteId){

  $data = array(
    "add_status" => 1
  );
  DB::table('job_new_roster')->where('site_id', $siteId)->update($data);
  return true;
}

public function jobGuards($guardId, $siteId)
{
  $data = DB::table('jobs_guards')->where("guard_id",$guardId)->where("job_id",$siteId)->first();

  return $data;

}
public function getAllSiteGuards($siteID, $multiple_states = null, $state = null, $site_employer = null){
    // $superAdmin = $this->session->userdata('superAdmin');
  $superAdmin = false;

  $return = array();




  $query = DB::table('guards')->where('guards.status', 'active')->where('guards.is_approved', 'yes');
  if (!$superAdmin && $state != null && ($multiple_states == null || empty($multiple_states))) {
    $query->where('guards.state', $state);
  } 
  if ($site_employer != null && $site_employer == 'all') {
    $query->where(function($que){
      $que->where('guards.guard_type', 'Direct');
      $que->orWhere('guards.guard_type', 'Contractor');
    });
  }else{
        // $query->where('guards.guard_type', 'Direct');
  }   
  $data = $query->orderBy('name', 'ASC')->get();


  $customer = DB::table('jobs')->where('id', $siteID)->select('customer_id')->first();


  foreach ($data as $key => $value) {

    $value->site_trained = '';
    $res = $this->jobGuards($value->id, $siteID);

    if ($value->specific_customers_id != '') {
      $specific_customers_id = json_decode($value->specific_customers_id, true);
      foreach ($specific_customers_id as $key1 => $value1) {

        $blocked = DB::table('guard_sites_blocked')->where(array('guard_id' => $value->id, 'site_id' => $siteID, 'status' => 'Block'))->first();
        $value1 = $value1*1;
        if(empty($res) && empty($blocked) && ($value1*1) == $customer->customer_id){
          if ($multiple_states != null && !empty($multiple_states)) {
            foreach ($multiple_states as $key11 => $value11) {
              if ($value11 == $value->state) {
                array_push($return,$value);
              }
            }
          }elseif($state != null && $state == $value->state){
            array_push($return,$value);
          }else{
            array_push($return,$value);
          }
        }
      }
    }
  }
  return $return;

}

public function contractorsGuards($contractorId){

  $data = DB::table('guards')->where("contractor_id",$contractorId)->where("guard_type",'Contractor')->orderBy('name', 'ASC');
  return $data;
}

public function getContractorsGuards($contractorId, $jobId){

  $return = array();
  $data = DB::table('guards')->where('guards.status', 'active')->where('guards.is_approved', 'yes')->where('guards.guard_type', 'Contractor')->where('guards.contractor_id', $contractorId)->orderBy('name', 'ASC')->get();


  foreach ($data as $key => $value) {

    $value->site_trained = '';
    $res = $this->jobGuards($value->id, $jobId);
    $blocked = DB::table('guard_sites_blocked')->where(array('guard_id' => $value->id, 'site_id' => $jobId, 'status' => 'Block'))->first();

    if(empty($res) && empty($blocked)){
      array_push($return,$value);
    }
  }
  return $return;
}

public function saveJobGuards($guardId, $siteId){

  $date = strtotime(date("Y/m/d"));

  $data = array(

    "guard_id" => $guardId,

    "job_id" => $siteId,

    "start_time" => 0,

    "complete_time" => 0,

    "location_photo" => "default-location-placeholder.png",

    "date_added" => $date

  );

  DB::table('jobs_guards')->insert($data);

  return true;



}
public function getAllNotSiteGuards($siteID, $multiple_states = null, $state = null){
    // $superAdmin = $this->session->userdata('superAdmin');
  $superAdmin = false;

  $return = array();

  $query = DB::table('guards')->where('guards.status', 'active')->where('guards.is_approved', 'yes')->where('guards.guard_type', 'Direct');
  if (!$superAdmin && $state != null && ($multiple_states == null || empty($multiple_states))) {
    $query->where('guards.state', $state);
  }
  $query->groupBy('guards.id');    
  $data = $query->orderBy('name', 'ASC')->get();


  $customer = DB::table('jobs')->where('id', $siteID)->select('customer_id')->first();


  foreach ($data as $key => $value) {

    $value->site_trained = '';
    $res = $this->jobGuards($value->id, $siteID);

    if ($value->specific_customers_id != '') {
      $specific_customers_id = json_decode($value->specific_customers_id, true);
      $is_in = false;
      foreach ($specific_customers_id as $key1 => $value1) {

        $blocked = DB::table('guard_sites_blocked')->where(array('guard_id' => $value->id, 'site_id' => $siteID, 'status' => 'Block'))->first();
        $check_guard_already_same_customer = DB::table('jobs_guards')->join('jobs', 'jobs.id', '=', 'jobs_guards.job_id')->where('jobs_guards.guard_id', $value->id)->where('jobs.customer_id', $customer->customer_id)->first();
        $value1 = $value1*1;
        if(empty($check_guard_already_same_customer) && empty($res) && empty($blocked) && ($value1*1) == $customer->customer_id){
          $is_in = true;
        }
      }
      if (!$is_in) {
        array_push($return,$value);
      }
    }else{
      array_push($return,$value);
    }
  }
  return $return;

}
function getAllCustomersSites($customer_id){
  $sites = DB::table('jobs')->where('customer_id', $customer_id)->select('id as siteId')->get();
  return $sites;
}

public function leaveDetails($request)
{
  $leaves = DB::table('guard_annual_leaves')->where('guard_id', $request->guard_id)->where('start_time', '>=', strtotime(date('Y').'-01-01'))->where('start_time', '<=', strtotime(date('Y').'-12-31'))->get();
  foreach ($leaves as $leave) {
    $leave->start_time = date('d/m/Y H:i', $leave->start_time); 
    $leave->end_time = date('d/m/Y H:i', $leave->end_time); 
  }
  return $leaves;
}
public function guard_leave_requests($request)
{
  $leaves = DB::table('guard_leave_requests')->where('guard_id', $request->guard_id)->where('status', 'pending')->get();
  foreach ($leaves as $leave) {
    $leave->start = date('d/m/Y H:i', $leave->start); 
    $leave->end = date('d/m/Y H:i', $leave->end); 
  }
  return $leaves;
}
public function changeLeaveStatus($leaveId, $status)
{
  $result = DB::table('guard_leave_requests')->where('id', $leaveId)->update(['status' => $status]);
  return $result;
}
function getAllPublishData($type, $customerId, $selected_Ids, $start = null, $end = null)
{
  $query = DB::table('job_new_roster')
  ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
  ->where("job_new_roster.publish_status","0")
  ->where('job_new_roster.guard_id', '!=', null)
  ->where('job_new_roster.guard_id', '!=', 0)
  ->where('jobs.customer_id', $customerId);
  if ($type == 'guard') {
    $query->where(function ($que)  use ($selected_Ids){
      foreach ($selected_Ids as $key => $value) {
        if ($key == 0) {
          $que->where('job_new_roster.guard_id', $value['value']);
        }else{
          $que->orWhere('job_new_roster.guard_id', $value['value']);
        }
      }
    });
  }else{
    $query->where(function ($que)  use ($selected_Ids){
      foreach ($selected_Ids as $key => $value) {
        if ($key == 0) {
          $que->where('job_new_roster.site_id', $value['value']);
        }else{
          $que->orWhere('job_new_roster.site_id', $value['value']);
        }
      }
    });
  }
  if ($start != null) {

    $query->where('job_new_roster.temp_start', '>=', date('Y-m-d 00:00:00', strtotime($start)));

  }
  if ($end != null) {
        // $end = strtotime($end) + (60*60*24);
        // $end = date('Y-m-d');

    $query->where('job_new_roster.temp_start', '<=', date('Y-m-d 00:00:00', strtotime($end)));

  }
  $data = $query->select('job_new_roster.*')->get();
  return $data;
}

function getAllPublishGuards($type, $customerId, $selected_Ids, $start = null, $end = null)
{
  $query = DB::table('job_new_roster')
  ->join('guards', 'guards.id', '=', 'job_new_roster.guard_id')
  ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
  ->where("job_new_roster.publish_status","0")
  ->where("job_new_roster.record_update", 0)
  ->where('job_new_roster.guard_id', '!=', null)
  ->where('job_new_roster.guard_id', '!=', 0)
  // ->where('guards.notification_token', '!=', '')
  ->where('jobs.customer_id', $customerId);
  if ($type == 'guard') {
    $query->where(function ($que)  use ($selected_Ids){
      foreach ($selected_Ids as $key => $value) {
        if ($key == 0) {
          $que->where('job_new_roster.guard_id', $value['value']);
        }else{
          $que->orWhere('job_new_roster.guard_id', $value['value']);
        }
      }
    });
  }else{
    $query->where(function ($que)  use ($selected_Ids){
      foreach ($selected_Ids as $key => $value) {
        if ($key == 0) {
          $que->where('job_new_roster.site_id', $value['value']);
        }else{
          $que->orWhere('job_new_roster.site_id', $value['value']);
        }
      }
    });
  }
  if ($start != null) {

    $query->where('job_new_roster.temp_start', '>=', date('Y-m-d 00:00:00', strtotime($start)));

  }
  if ($end != null) {
        // $end = strtotime($end) + (60*60*24);
        // $end = date('Y-m-d');

    $query->where('job_new_roster.temp_start', '<=', date('Y-m-d 00:00:00', strtotime($end)));

  }
  $data = $query->select('guards.id', 'guards.name', 'guards.notification_token', 'guards.email', 'guards.phone')->groupBy('guards.id')->get();
  return $data;
}
function getAllUpdatedPublishGuards($type, $customerId, $selected_Ids, $start = null, $end = null)
{
  $query = DB::table('job_new_roster')
  ->join('guards', 'guards.id', '=', 'job_new_roster.guard_id')
  ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
  ->where("job_new_roster.publish_status","0")
  ->where("job_new_roster.record_update", 1)
  ->where('job_new_roster.guard_id', '!=', null)
  ->where('job_new_roster.guard_id', '!=', 0)
  // ->where('guards.notification_token', '!=', '')
  ->where('jobs.customer_id', $customerId);
  if ($type == 'guard') {
    $query->where(function ($que)  use ($selected_Ids){
      foreach ($selected_Ids as $key => $value) {
        if ($key == 0) {
          $que->where('job_new_roster.guard_id', $value['value']);
        }else{
          $que->orWhere('job_new_roster.guard_id', $value['value']);
        }
      }
    });
  }else{
    $query->where(function ($que)  use ($selected_Ids){
      foreach ($selected_Ids as $key => $value) {
        if ($key == 0) {
          $que->where('job_new_roster.site_id', $value['value']);
        }else{
          $que->orWhere('job_new_roster.site_id', $value['value']);
        }
      }
    });
  }
  if ($start != null) {

    $query->where('job_new_roster.temp_start', '>=', date('Y-m-d 00:00:00', strtotime($start)));

  }
  if ($end != null) {
        // $end = strtotime($end) + (60*60*24);
        // $end = date('Y-m-d');

    $query->where('job_new_roster.temp_start', '<=', date('Y-m-d 00:00:00', strtotime($end)));

  }
  $data = $query->select('guards.id', 'guards.name', 'guards.notification_token', 'guards.email', 'guards.phone')->groupBy('guards.id')->get();
  return $data;
}
function logPayChargeRate($roster_id, $charge_too = true)
{
  $sql = "SELECT
  jr.*,
  j.`id`,
  j.`booking_id`,
  j.`customer_id`,
  j.`contractor_id`,
  j.`state`,
  j.`stateType`,
  j.`address`,
  j.`details`,
  j.`site_name`,
  j.`site_description`,
  j.`level`,
  j.`payrol`,
  j.`site_payrate`,
  j.`payable` as break_payable,
  j.`break`,
  j.`payable_and_chargeable_time`,
  j.`other_metro_weekday_day`,
  j.`apply_date`,
  cust.`name` AS customer_name,
  c.`name` AS contractor_name,
  g.`phone`,
  g.`guard_type`,
  g.`phone` AS guard_phone,
  g.`id` AS guard_id,
  g.`email` AS guard_email,
  g.`address` AS guard_address,
  g.`profile_image` AS guard_image,
  g.`name` AS guard_name,
  g.`guard_type` AS guard_type,
  g.`payrates_id` AS guard_payrate_id,
  g.`suburb` AS guard_suburb,
  g.`city` AS guard_city,
  g.`state` AS guard_state,
  g.`coordinates` AS guard_coordinates,
  g.`postal_code` AS guard_postal_code,
  g.`dob` AS guard_dob,
  g.`gender` AS guard_gender,
  g.`emergency_contact_name` AS emergency_contact_name,
  g.`emergency_contact_phone` AS emergency_contact_phone,
  g.`registration_type` AS registration_type,
  g.`residential_status` AS residential_status,
  g.`passport_number` AS passport_number,
  g.`passport_expiration` AS passport_expiration,
  g.`visa_number` AS visa_number,
  g.`visa_expiration` AS visa_expiration,
  g.`security_license_number` AS security_license_number,
  g.`security_license_expiration` AS security_license_expiration,
  g.`driver_license_number` AS driver_license_number,
  g.`driver_license_expiration` AS driver_license_expiration,
  g.`is_approved` AS is_approved,
  g.`bsb` AS bsb,
  g.`payroll_bank_name` AS payroll_bank_name,
  g.`status` AS guard_status,
  g.`payroll_bank_account_number` AS payroll_bank_account_number,
  g.`covid` AS covid,
  g.`fortnightly_working_hours` AS fortnightly_working_hours,
  g.`payroll_tfn_number` AS payroll_tfn_number,
  g.`payroll_abn_number` AS payroll_abn_number,
  g.`payroll_superannutation` AS payroll_superannutation,
  g.`payroll_bank_name` AS payroll_bank_name,
  g.`payroll_bank_account_number` AS payroll_bank_account_number,
  gi.`internal_id`,
  gi.`external_id`,
  cust.`flat_metro_week_day`,
  gpi.`payroll_id`,
  jr.`roster_id` As roster_id
  FROM job_new_roster AS jr
  INNER JOIN jobs AS j ON j.`id` = jr.`site_id`
  LEFT JOIN `guards` AS g ON g.`id` = jr.`guard_id`
  LEFT JOIN customers AS cust ON j.`customer_id` = cust.`id`
  LEFT JOIN `contractors` AS c ON j.`contractor_id`= c.`id`
  LEFT JOIN `guard_ids` AS gi ON gi.`customer_id` = cust.`id` AND gi.`guard_id` = jr.`guard_id`
  LEFT JOIN `guard_payroll_ids` AS gpi ON gpi.`guard_id` = g.`id` AND gpi.`guard_id` = jr.`guard_id`
  WHERE jr.`payable` = 'yes' AND jr.`temp_date` AND jr.`roster_id` = " . $roster_id . " ORDER BY g.name ASC, jr.moke_guard, jr.temp_start";

  $query = DB::select($sql);
  $results = $query;
  foreach ($results as $result) {
    $total = $result->hours;
    if ($result->continuation == 0 && $total < 4) {
      $end = strtotime($result->temp_end);
      $remaining = 4 - $total;
      $end = $end + (60 * 60 * $remaining);
      $job_hours = $this->getShiftHours($result->temp_start, date('Y-m-d H:i', $end), $result->site_id);
    } else {
      $job_hours = $this->getShiftHours($result->temp_start, $result->temp_end, $result->site_id);
    }
    $job_hours['morning'] = $this->convertIntoWhole($job_hours['morning']);
    $job_hours['night'] = $this->convertIntoWhole($job_hours['night']);
    $job_hours['saturday_morning'] = $this->convertIntoWhole($job_hours['saturday_morning']);
    $job_hours['saturday_night'] = $this->convertIntoWhole($job_hours['saturday_night']);
    $job_hours['sunday_morning'] = $this->convertIntoWhole($job_hours['sunday_morning']);
    $job_hours['sunday_night'] = $this->convertIntoWhole($job_hours['sunday_night']);
    $job_hours['ph_morning'] = $this->convertIntoWhole($job_hours['ph_morning']);
    $job_hours['ph_night'] = $this->convertIntoWhole($job_hours['ph_night']);

    $pay_rate = 0;
    $day_rate = 0;
    $saturday_day_rate = 0;
    $saturday_night_rate = 0;
    $sunday_day_rate = 0;
    $sunday_night_rate = 0;
    $ph_day_rate = 0;
    $ph_night_rate = 0;
    $night_rate = 0;
    $ot_base_rate = 0;
    if ($result->payrate_applied != '' && !empty(json_decode($result->payrate_applied, true)) && $result->payrate_applied != "[]") {
      $guard_rates = $payrates = json_decode($result->payrate_applied);
    } else {
      if (config('custom.own_payrates') == 0) {
        if ($result->payrate_id > 0 && $result->payrate_id != null) {
          $guard_rates = $payrates = DB::table('payrates')->where('archive', 0)->where('id', $result->payrate_id)->first();
        } elseif ($result->site_payrate > 0) {
          $guard_rates = $payrates = DB::table('payrates')->where('archive', 0)->where('id', $result->site_payrate)->first();
          if ($result->apply_date != '') {
            if (strtotime($result->apply_date) <= strtotime($result->temp_start)) {
              $guard_rates = $payrates = DB::table('payrates')->where('archive', 0)->where('id', $result->site_payrate)->first();
            } else {
              $old_payrate = DB::table('site_payrate_history')->where('site_id', $result->site_id)
              ->where('apply_date', '<=', strtotime($result->temp_start))->orderBy('apply_date', 'desc')->first();
              if (!empty($old_payrate)) {
                $guard_rates = $payrates = DB::table('payrates')->where('archive', 0)->where('id', $old_payrate->payrate_id)->first();
              }
            }
          } else {
            $guard_rates = $payrates = DB::table('payrates')->where('archive', 0)->where('id', $result->site_payrate)->first();
          }
        } elseif ($result->guard_payrate_id > 0) {
          $guard_rates = $payrates = DB::table('payrates')->where('archive', 0)->where('id', $result->guard_payrate_id)->first();
        } else {
                    // $pay_rate = DB::table('payrates')->where('archive', 0)->where('id', $roster->site_payrate)->first();
          $guard_rates = $payrates = array();
        }
      }else{
        if(config('custom.own_payrates') == 1 && $result->own_payrate == 'custom' && false)
      {
        $guard_rates = $payrates = json_decode($result->custom_payrate);
        $payrates->ot_base_rate = 22.84;
      }else{
        // $guard_payrate = DB::table('guard_payrates')->where('guard_id', $result->guard_id)->first();
        // if (!empty($guard_payrate)) {
        //   $guard_rates = $payrates = json_decode($guard_payrate->payrate);
        //   $payrates->ot_base_rate = 22.84;
        // }else{
          $guard_rates = $payrates = array();
        // }
      }
    }
    }
    if (!empty($payrates)) {
      $ot_base_rate = $payrates->ot_base_rate;
      if (config('custom.own_payrates') == 1) {
        if ($result->own_payrate == 'default') {
          $result->payrol = 'Default Rates';
        }
      }
      if(config('custom.own_payrates') == 1 && $result->own_payrate == 'custom')
      {
        $guard_rates = $payrates = json_decode($result->custom_payrate);
        $guard_rates->title = 'Custom Rate on Shift';
        $payrates->title = 'Custom Rate on Shift';
        $payrates->ot_base_rate = 22.84;
        $pay_rate = $payrates->flat_metro_week_day_day;
        $day_rate = $payrates->flat_metro_week_day_day;
        $night_rate = $payrates->flat_metro_week_day_night;
        $sunday_day_rate = $payrates->flat_metro_sunday;
        $sunday_night_rate = $payrates->flat_metro_sunday_night;
        $saturday_day_rate = $payrates->flat_metro_saturday;
        $saturday_night_rate = $payrates->flat_metro_saturday_night;
        $ph_day_rate = $payrates->flat_metro_public_holiday;
        $ph_night_rate = $payrates->flat_metro_public_holiday_night;

      }elseif ($result->payrol == 'Default Rates') {
        if ($result->stateType == 'metropolitan') {
          $pay_rate = $payrates->flat_metro_week_day_day;
          $day_rate = $payrates->flat_metro_week_day_day;
          $night_rate = $payrates->flat_metro_week_day_night;

          $sunday_day_rate = $payrates->flat_metro_sunday;
          $sunday_night_rate = $payrates->flat_metro_sunday_night;
          $saturday_day_rate = $payrates->flat_metro_saturday;
          $saturday_night_rate = $payrates->flat_metro_saturday_night;
          $ph_day_rate = $payrates->flat_metro_public_holiday;
          $ph_night_rate = $payrates->flat_metro_public_holiday_night;
        } else {
          $pay_rate = $payrates->flat_regional_week_day_day;
          $day_rate = $payrates->flat_regional_week_day_day;
          $night_rate = $payrates->flat_regional_week_day_night;

          $sunday_day_rate = $payrates->flat_regional_sunday;
          $sunday_night_rate = $payrates->flat_regional_sunday_night;
          $saturday_day_rate = $payrates->flat_regional_saturday;
          $saturday_night_rate = $payrates->flat_regional_saturday_night;
          $ph_day_rate = $payrates->flat_regional_public_holiday;
          $ph_night_rate = $payrates->flat_regional_public_holiday_night;
        }
      } else {
                    // start eba rates
        if ($result->stateType == 'metropolitan') {
          $pay_rate = $payrates->eba_metro_weekday_day;
          $day_rate = $payrates->eba_metro_weekday_day;
          $night_rate = $payrates->eba_metro_weekday_night;

          $sunday_day_rate = $payrates->eba_metro_sunday_day;
          $sunday_night_rate = $payrates->eba_metro_sunday_day;
          $saturday_day_rate = $payrates->eba_metro_saturday_day;
          $saturday_night_rate = $payrates->eba_metro_saturday_night;
          $ph_day_rate = $payrates->eba_metro_public_holiday;
          $ph_night_rate = $payrates->eba_metro_public_holiday_night;
        } else {
          $pay_rate = $payrates->eba_regional_weekday_day;
          $day_rate = $payrates->eba_regional_weekday_day;
          $night_rate = $payrates->eba_regional_weekday_night;

          $sunday_day_rate = $payrates->eba_regional_sunday_day;
          $sunday_night_rate = $payrates->eba_regional_sunday_night;
          $saturday_day_rate = $payrates->eba_regional_saturday_day;
          $saturday_night_rate = $payrates->eba_regional_saturday_night;
          $ph_day_rate = $payrates->eba_regional_public_holiday;
          $ph_night_rate = $payrates->eba_regional_public_holiday_night;
        }
      }
    }
    $pay_rate = $result->overtime_value * $pay_rate;
    $day_rate = $result->overtime_value * $day_rate;
    $night_rate = $result->overtime_value * $night_rate;
    $sunday_day_rate = $result->overtime_value * $sunday_day_rate;
    $sunday_night_rate = $result->overtime_value * $sunday_night_rate;
    $saturday_day_rate = $result->overtime_value * $saturday_day_rate;
    $saturday_night_rate = $result->overtime_value * $saturday_night_rate;
    $ph_day_rate = $result->overtime_value * $ph_day_rate;
    $ph_night_rate = $result->overtime_value * $ph_night_rate;
            // end if

    if ($result->break_payable == 'no' && $result->break == 1) {
      $payable_and_chargeable_time = $result->payable_and_chargeable_time / 60;
      if ($payable_and_chargeable_time > 0 && $payable_and_chargeable_time <= 0.25) {
        $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0);
        $job_hours['morning'] = $breakCal[0];
        $job_hours['night'] = $breakCal[1];
      } elseif ($payable_and_chargeable_time > 0.25 && $payable_and_chargeable_time <= 0.5) {
        $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0.25);
        $job_hours['morning'] = $breakCal[0];
        $job_hours['night'] = $breakCal[1];
      } elseif ($payable_and_chargeable_time > 0.5 && $payable_and_chargeable_time <= 0.75) {
        $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.25);
        $job_hours['morning'] = $breakCal[0];
        $job_hours['night'] = $breakCal[1];
      } elseif ($payable_and_chargeable_time > 0.75 && $payable_and_chargeable_time <= 1) {
        $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.5);
        $job_hours['morning'] = $breakCal[0];
        $job_hours['night'] = $breakCal[1];
      }
    } else {
      $result->payable_and_chargeable_time = 0;
      $result->break_payable = '-';
    }
    $result->payable = $result->break_payable;
    if ($result->travel_time_amount == '' || $result->travel_time_amount ==  null) {
      $result->travel_time_amount = 0;
    }
    $total_amount_pay = ((($job_hours['morning'] + $result->travel_time) * $day_rate) + ($job_hours['night'] * $night_rate) + ($job_hours['sunday_morning'] * $sunday_day_rate) + ($job_hours['sunday_night'] * $sunday_night_rate) + ($job_hours['saturday_morning'] * $saturday_day_rate) + ($job_hours['saturday_night'] * $saturday_night_rate) + ($job_hours['ph_morning'] * $ph_day_rate) + ($job_hours['ph_night'] * $ph_night_rate) + $result->travel_time_amount);
    DB::table('job_new_roster')->where('roster_id', $roster_id)->update(['pay' => $total_amount_pay, 'payrate_applied' => json_encode($payrates)]);
  }
  if ($charge_too) {
    $this->calculateChargeRate($roster_id);
  }
        // end foreach
}

function calculateBreakTiming($morning, $night, $breakTime1, $breakTime2)
{
  if ($morning == 0 || $night == 0) {
    if ($morning == 0) {
      return array(
        0 => 0,
        1 => $night - $breakTime1 - $breakTime2
      );
    } else {
      return array(
        0 => $morning - $breakTime1 - $breakTime2,
        1 => 0
      );
    }
  } else {
    if ($morning > $night) {
      return array(
        0 => $morning - $breakTime1,
        1 => $night - $breakTime2,
      );
    } elseif ($morning < $night) {
      return array(
        0 => $night - $breakTime1,
        1 => $morning - $breakTime2,
      );
    } else {
      return array(
        0 => $morning - $breakTime1,
        1 => $night - $breakTime2,
      );
    }
  }
}

function calculateChargeRate($roster_id)
{
  $result = DB::table('job_new_roster')
  ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
  ->join('customers', 'customers.id', '=', 'jobs.customer_id')
  ->where('job_new_roster.roster_id', $roster_id)
  ->select('job_new_roster.chargerate_id', 'customers.charged_rates_id AS customer_charge_rate_id', 'jobs.level', 'jobs.state', 'jobs.payrol', 'jobs.stateType', 'job_new_roster.hours', 'job_new_roster.chargerate_applied', 'job_new_roster.temp_start', 'jobs.site_charge_rate')
  ->first();

  $rate = 0;
  if ($result->chargerate_id > 0) {
  // if ($result->chargerate_applied != '') {
      $charge_rate = DB::table('charged_rates')->where('archive', 0)->where('id', $result->chargerate_id)->first();
    // $charge_rate = json_decode($result->chargerate_applied);
  } else {
    if ($result->chargerate_id != null && $result->chargerate_id > 0) {
      $charge_rate = DB::table('charged_rates')->where('archive', 0)->where('id', $result->chargerate_id)->first();
    } elseif ($result->customer_charge_rate_id != null && $result->customer_charge_rate_id > 0) {
      $charge_rate = DB::table('charged_rates')->where('archive', 0)->where('id', $result->customer_charge_rate_id)->first();
    }elseif($result->site_charge_rate != null && $result->site_charge_rate > 0){
      $charge_rate = DB::table('charged_rates')->where('archive', 0)->where('id', $result->site_charge_rate)->first();
    }else {
                // $charge_rate = DB::table('charged_rates')->where('archive', 0)->where('level', $result->level)->where('state', $result->state)->first();
      $charge_rate = [];
    }
  }

  if (!empty($charge_rate)) {
    if ($result->payrol == 'Default Rates') {
      if ($result->stateType == 'metropolitan') {
        $rate = $charge_rate->flat_metro_week_day_day;
      } else {
        $rate = $charge_rate->flat_regional_week_day_day;
      }
    } else {
      if ($result->stateType == 'metropolitan') {
        $rate = $charge_rate->eba_metro_weekday_day;
      } else {
        $rate = $charge_rate->eba_regional_weekday_day;
      }
    }
  }

  DB::table('job_new_roster')->where('roster_id', $roster_id)->update(['charge' => $result->hours * $rate, 'chargerate_applied' => json_encode($charge_rate)]);
}

function convertIntoWhole($hours)
{
  $total_hours = explode('.', $hours);
  if (sizeof($total_hours) > 1) {
    $partial = '.' . $total_hours[1];
    if ($partial < 0.1) {
      $hours = $total_hours[0];
    }
    if ($partial < 0.27 && $partial > 0.1) {
      $hours = $total_hours[0] . '.25';
    }
    if ($partial > 0.27 && $partial < 0.52) {
      $hours = $total_hours[0] . '.5';
    }
    if ($partial > 0.52 && $partial < 0.77) {
      $hours = $total_hours[0] . '.75';
    }
    if ($partial > 0.77 && $partial < 1) {
      $hours = $total_hours[0] + 1;
    }
  }
  return $hours;
}

private function getShiftHours($start, $end, $siteID = null)
{
  $day_start = Carbon::parse($start)->format('l');
  $day_end = Carbon::parse($end)->format('l');

  $start = strtotime($start);
  $end = strtotime($end);

  $diff = $end - $start;
  $hours = round($diff / (60 * 60), 2);
  $morning_start = 6;
  $morning_end = 18;

        /*$afternoon_start = strtotime("15:00");
        $afternoon_end = strtotime("23:00");*/

        $night_start = 18;
        $night_end = 6;

        $shift_start = $this->convert_into_fraction($start);
        $shift_end = $this->convert_into_fraction($end);
        // saturday calcultions
        $saturday_start = 0;
        $saturday_end = 0;
        $total_saturday_hours = 0;

        $total_ph_hours = 0;
        $ph_start = 0;
        $ph_end = 0;

        // publid holiday calculation start here
        $start_in_public_holiday = false;
        $end_in_public_holiday = false;
        if ($siteID != null) {
          $site_state = DB::table('jobs')->where('id', $siteID)->select('state')->first();
          $states_array = array(
            'Victoria' => 'vic',
            'New South Wales' => 'nsw',
            'NSW' => 'nsw',
            'Queensland' => 'qld',
            'Tasmania' => 'tas',
            'Western Australia' => 'wa',
            'South Australia' => 'sa',
            'ACT' => 'act'
          );
          if (!empty($site_state)) {
            $state = 'vic';
          } else {
            $state = $states_array[$site_state->state];
          }
        } else {
          $state = 'vic';
        }
        $public_holiday_start = DB::table('public_holidays')->where('date', date('Ymd', $start))->where('state', $state)->first();
        $public_holiday_end = DB::table('public_holidays')->where('date', date('Ymd', $end))->where('state', $state)->first();
        if (!empty($public_holiday_start)) {
          $start_in_public_holiday = true;
        }
        if (!empty($public_holiday_end)) {
          $end_in_public_holiday = true;
        }
        if ($start_in_public_holiday && $end_in_public_holiday) {
          $total_ph_hours = $hours;
          $hours = 0;
          $ph_start = $shift_start;
          $ph_end = $shift_end;
          $shift_start = 0;
          $shift_end = 0;
            // echo 'whole day in PH - ';

        } elseif ($start_in_public_holiday && !$end_in_public_holiday) {
          $ph_end = strtotime(date('m/d/Y 23:59:59', $start));
          $diff = $ph_end - $start;
          $total_ph_hours = round($diff / (60 * 60), 2);
          $ph_start = $this->convert_into_fraction($start);
          $ph_end = $this->convert_into_fraction($ph_end);
          $start = strtotime($public_holiday_start->date) + (60 * 60 * 24);
          $day_start = Carbon::parse(date('m/d/Y', $end))->format('l');
          $hours = $hours - $total_ph_hours;
            // echo 'Start in PH - ';
        } elseif (!$start_in_public_holiday && $end_in_public_holiday) {
          $ph_start = strtotime(date('m/d/Y 00:00:00', strtotime($public_holiday_end->date)));
          $diff = $end - $ph_start;
          $total_ph_hours = round($diff / (60 * 60), 2);
          $shift_end = 0;
          $end = $ph_start;
          $hours = $hours - $total_ph_hours;

            // echo $hours;
        }

        // end of public holiday calculation

        if ($day_start == 'Saturday' && $day_end == 'Saturday') {
          $total_saturday_hours = $hours;
          $saturday_start = $shift_start;
          $saturday_end = $shift_end;
          $shift_start = 0;
          $shift_end = 0;
          $hours = 0;
        }elseif($day_start == 'Saturday' && $day_end != 'Saturday')
        {
          $sat_end = strtotime(date('m/d/Y 23:59:59', $start));
          $diff = $sat_end - $start;
          $total_saturday_hours = round($diff / ( 60 * 60 ), 2);
          $saturday_start = $shift_start;
          $saturday_end = $this->convert_into_fraction($sat_end);
          $shift_start = 0;
          $shift_end = 0;
          $hours = $hours - $total_saturday_hours;
        }elseif($day_start != 'Saturday' && $day_end == 'Saturday')
        {
          $sat_start = strtotime(date('m/d/Y 00:00:00', $end));
          $diff = $end - $sat_start;
          $total_saturday_hours = round($diff / ( 60 * 60 ), 2);
          $saturday_start = $this->convert_into_fraction($sat_start);
          $saturday_end = $shift_end;
          $shift_end = 24;
          $hours = $hours - $total_saturday_hours;
        }
        // sunday_calcultaon
        $sunday_start = 0;
        $sunday_end = 0;
        $total_sunday_hours = 0;
        if ($day_start == 'Sunday' && $day_end == 'Sunday') {
          $total_sunday_hours = $hours;
          $sunday_start = $shift_start;
          $sunday_end = $shift_end;
          $shift_start = 0;
          $shift_end = 0;
          $hours = 0;
        }elseif($day_start == 'Sunday' && $day_end != 'Sunday')
        {
          $sun_end = strtotime(date('m/d/Y 23:59:59', $start));
          $diff = $sun_end - $start;
          $total_sunday_hours = round($diff / ( 60 * 60 ), 2);
          $sunday_start = $shift_start;
          $sunday_end = $this->convert_into_fraction($sun_end);

          $shift_start = 0;
          $hours = $hours-$total_sunday_hours;
        }elseif($day_start != 'Sunday' && $day_end == 'Sunday')
        {
          $sun_start = strtotime(date('m/d/Y 00:00:00', $end));
          $diff = $end - $sun_start;
          $total_sunday_hours = round($diff / ( 60 * 60 ), 2);
          $sunday_start = $this->convert_into_fraction($sun_start);
          $sunday_end = $this->convert_into_fraction($end);
          $shift_end = 24;
          $shift_start = 24;
          $hours = $hours - $total_sunday_hours;
        }
        if ($start_in_public_holiday && $end_in_public_holiday) {
          $shift_start = 0;
          $shift_end = 0;
          $saturday_start = 0;
          $saturday_end = 0;
          $sunday_start = 0;
          $sunday_end = 0;
          $total_sunday_hours = 0;
          $total_saturday_hours = 0;
        }


        $morning = round($this->calculateHoursMorning($shift_start, $shift_end, $morning_start, $morning_end), 2);
        $saturday_morning = round($this->calculateHoursMorning($saturday_start, $saturday_end, $morning_start, $morning_end), 2);

        $sunday_morning = round($this->calculateHoursMorning($sunday_start, $sunday_end, $morning_start, $morning_end), 2);

        $ph_morning = round($this->calculateHoursMorning($ph_start, $ph_end, $morning_start, $morning_end), 2);

        // echo $sunday_morning;
        // exit();

        if ($morning < 0) {
          $morning = 0;
        }
        if ($saturday_morning < 0) {
          $saturday_morning = 0;
        }
        if ($sunday_morning < 0) {
          $sunday_morning = 0;
        }
        // print_r($shift_end);
        return [
            // 'morning' => $this->intersection( $start1, $end, $morning_start, $morning_end ) / 3600,
          'morning' =>  $morning,
          'night' => round(((($hours - $morning) < 0) ? 0 : ($hours - $morning)), 2),
          'saturday_morning' => $saturday_morning,
          'saturday_night' => round(((($total_saturday_hours - $saturday_morning) < 0) ? 0 : ($total_saturday_hours - $saturday_morning)), 2),
          'sunday_morning' => $sunday_morning,
          'sunday_night' => round(((($total_sunday_hours - $sunday_morning) < 0) ? 0 : ($total_sunday_hours - $sunday_morning)), 2),
          'ph_morning' => $ph_morning,
          'ph_night' => round(((($total_ph_hours - $ph_morning) < 0) ? 0 : ($total_ph_hours - $ph_morning)), 2),

            // 'night' => $this->calculateHoursNight($shift_start, $shift_end, $night_start, $night_end ),
        ];
      }

      function convert_into_fraction($time)
      {
        return date('H', $time) + (date('i', $time) / 60);
      }

      function calculateHoursMorning($shift_start, $shift_end, $start, $end)
      {
        if (($shift_start >= $start && $shift_start < $end) && ($shift_end > $start && $shift_end <= $end)) {
          return $shift_end - $shift_start;
        } elseif (($shift_start >= $start && $shift_start < $end) && ($shift_end > $start && $shift_end > $end)) {
          $shift_end = $end;
          return $shift_end - $shift_start;
        } elseif (($shift_start > $start && $shift_start > $end) && ($shift_end > $start && $shift_end <= $end)) {
          $shift_start = $start;
          return $shift_end - $shift_start;
        } elseif (($shift_start < $start && $shift_start < $end) && ($shift_end > $start && $shift_end <= $end)) {
          $shift_start = $start;
          return $shift_end - $shift_start;
        } elseif ($shift_start < $start && $shift_end > $end) {
          return $end - $start;
        } else {
          return 0;
        }
      }
    }
