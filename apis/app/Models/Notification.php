<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
class Notification extends BaseModel {

protected $timezone = array(
      'Victoria' => 'Australia/Melbourne',
      'New South Whales' => 'Australia/Sydney',
      'Queensland' => 'Australia/Brisbane',
      'Tasmania' => 'Australia/Hobart',
      'Western Australia' => 'Australia/Perth',
      'South Australia' => 'Australia/Adelaide',
      'ACT' => 'Australia/Canberra'
      );

  public function get_notifications()
	{
		$flag = false;
		$message = 'Data received';
    $data = array();

      $this->db->order_by('id', 'DESC');
    	$result = $this->db->get_where('broadcast_notifications')->result_array();

       foreach($result as $r){
          $data[] = array('id' => $r['id'], 'title' => $r['title'], 'message' => $r['message'], 'via' => $r['via'], 'to' => $r['to'], 'dateAdded' => date('m/d/Y h:i a', $r['date_added']));
       }
    
    	$rsp = array(
    	'success' => $flag,
        'message' => $message,
        'data' => $data
    		);

    	return $rsp;
    }


   public function add_notification($req){
      $flag = false;
    
    $message = 'Data received';
    $data = array();

     

           $req['date_added'] = time();

            unset($req['id']);

          $this->db->insert('broadcast_notifications', $req);  


 

          $flag = true;
            $message = 'Successfully added';         
           
        
    
      $rsp = array(
      'success' => $flag,
        'message' => $message,
        'data' => $data
        );

      return $rsp;
    }

    function adminNotifiaction($data)
    {
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
      'app_id' => $config_data->admin_app_id,
      'include_player_ids' => array($data['notification_token']),
            'data' => array(
              'page' => $data['page'],
              ),
      'contents' => $content,
      'headings' => $heading
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
              'Authorization: Basic '.$config_data->admin_server_key));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $result = curl_exec($ch);
    if ($result === FALSE) {
      // die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);

    return $result;

  }

  public function send_push_notification($data){
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
      'include_player_ids' => array($data['fcm_token']),
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

    echo $result;
    
    if ($result === FALSE) {
      die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    
  }

  public function send_green_call_notifications()
  {
    $root= $_SERVER['HTTP_HOST'];
        $root = explode('.', $root);
        $postfix = 'staffingsolution';
        if($root[0] != 'wwww'){
            $postfix = $root[0];
        }else{
        $postfix = $root[1];
        }
        $config_data = DB::connection('mysql2')->table('business_data')->where('domain', '=', $postfix)->first();

    $current_time_next_two_hours = time() + (60*60*24);
    $jobs = DB::table('job_new_roster')
    ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
    ->join('guards', 'guards.id', '=', 'job_new_roster.guard_id')
    // ->whereBetween('job_new_roster.temp_start', [date('Y-m-d', time()), date('Y-m-d h:i:s', $current_time_next_two_hours)])
    ->whereBetween('job_new_roster.job_start', [time(), $current_time_next_two_hours])
    // ->where('job_new_roster.start','>=', date('Y-m-d', time()))
    // ->where('job_new_roster.start','<=', date('Y-m-d H:m:s', $current_time_next_two_hours))
    ->where('job_new_roster.green_call_notification','=', 'no')
    ->where('jobs.green_call','=', 'yes')
    ->select('job_new_roster.*', 'jobs.id as jobId','jobs.address', 'guards.notification_token', 'guards.id as guardId', 'guards.state as timezone')
    ->get();
    

		foreach($jobs as $job)
    {
      if ($job->timezone != '') {
        config(['app.timezone' => $this->timezone[$job->timezone]]);
        date_default_timezone_set($this->timezone[$job->timezone]);
      }

    $job_start_time = $job->temp_start;
    $job_start_time = strtotime($job_start_time);
    if ($job->job_start != '' && $config_data->time_format == 'timestamp') {
      $job_start_time = $job->job_start;
    }
    $current_time = time();
    $diff = round(($job_start_time - $current_time) / 60,2);
    if ($diff > ($config_data->first_green_call - 1) && $diff < ($config_data->first_green_call + 1)) {
      try{
        $this->send_push_notification(array('page' => 'green-call', 'title' => 'Green call', 'message' => 'You have a shift in 2 hour. Are you all good for your shift today at '.$job->address.'?', 'fcm_token' => $job->notification_token, 'roster_id' => $job->roster_id.',120'));
        DB::table('push_notifications')->insert(array(
          'page' => 'green_call',
          'title' => 'Green call',
          'message' => 'You have a shift in '.($config_data->first_green_call/60).' hour. Are you all good for your shift today?',
          'notification_to' => 'guard',
          'date_added' => time(),
          'notification_type' => 'green_call',
          'guard_id' => $job->guardId,
          'record_id' => $job->roster_id
        ));
      }catch(Exception $e)
      {

      }
      DB::table('job_new_roster')->where('roster_id', $job->roster_id)->update(['green_call_notification'=> 'yes']);
    }
    }
    $this->send_green_call_notifications_before_thirty();
    return true;
  }

  public function send_green_call_notifications_before_thirty()
  {
    $root= $_SERVER['HTTP_HOST'];
    $root = explode('.', $root);
        $postfix = 'staffingsolution';
        if($root[0] != 'wwww'){
            $postfix = $root[0];
        }else{
        $postfix = $root[1];
        }
        $config_data = DB::connection('mysql2')->table('business_data')->where('domain', '=', $postfix)->first();

    $current_time_next_two_hours = time() + (60*60*24);
    $jobs = DB::table('job_new_roster')
    ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
    ->join('guards', 'guards.id', '=', 'job_new_roster.guard_id')

    // ->whereBetween('job_new_roster.job_start', [time(), $current_time_next_two_hours])
    ->whereBetween('job_new_roster.temp_start', [date('Y-m-d H:i:s', time()), date('Y-m-d H:i:s', $current_time_next_two_hours)])
    // ->where('job_new_roster.start','>=', date('Y-m-d', time()))
    // ->where('job_new_roster.start','<=', date('Y-m-d H:m:s', $current_time_next_two_hours))
    ->where('job_new_roster.green_call_before_thirty','=', 'no')
    ->where('jobs.green_call','=', 'yes')
    ->select('job_new_roster.*', 'jobs.id as jobId','jobs.address', 'guards.notification_token', 'guards.id as guardId', 'guards.state as timezone')
    ->get();

    // print_r($jobs);
    // exit();
		foreach($jobs as $job)
    {
      if ($job->timezone != '') {
        config(['app.timezone' => $this->timezone[$job->timezone]]);
        date_default_timezone_set($this->timezone[$job->timezone]);
      }

    $job_start_time = $job->temp_start;
    $job_start_time = strtotime($job_start_time);
    if ($job->job_start != '' && $config_data->time_format == 'timestamp') {
      $job_start_time = $job->job_start;
    }
    $current_time = time();
    $diff = round(($job_start_time - $current_time) / 60,2);
    if ($diff > ($config_data->second_green_call - 1) && $diff < ($config_data->second_green_call + 1)) {
      $roster_activity = DB::table('job_roster_activities')->where('job_roster_id', '=', $job->roster_id)->first();
      if ($roster_activity != null) {

      }else{
      try{
        $this->send_push_notification(array('page' => 'green-call', 'title' => 'Green call', 'message' => 'You have a shift in 30 mins. Are you all good for your shift today at '.$job->address.'?', 'fcm_token' => $job->notification_token, 'roster_id' => $job->roster_id.',30'));
        DB::table('push_notifications')->insert(array(
          'page' => 'green_call',
          'title' => 'Green call',
          'message' => 'You have a shift in '.$config_data->second_green_call.' minutes. Are you all good for your shift today at '.$job->address.'?',
          'notification_to' => 'guard',
          'date_added' => time(),
          'notification_type' => 'green_call',
          'guard_id' => $job->guardId,
          'record_id' => $job->roster_id
        ));
      }catch(Exception $e)
      {

      }
      DB::table('job_new_roster')->where('roster_id', $job->roster_id)->update(['green_call_before_thirty'=> 'yes']);
    }
    }
    }
    return true;
  }

  public function send_welfare_notifications()
  {
    // $current_time_next_two_hours = time() + (60*60*2);
    $jobs = DB::table('job_new_roster')
    ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
    ->join('guards', 'guards.id', '=', 'job_new_roster.guard_id')
    ->join('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')
    // ->where('job_new_roster.start','>=', date('Y-m-d'))
    ->where('job_roster_activities.status','=', '1')
    // ->where('job_new_roster.start','<=', date('Y-m-d H:m:s', $current_time_next_two_hours))
    ->where('jobs.welfare_call','=', 'yes')
    ->select('job_new_roster.*', 'jobs.id as jobId', 'guards.notification_token', 'guards.id as guardId')
    ->get();

    // print_r($jobs);
    // exit();
		foreach($jobs as $job)
    {
      if($job->last_send_welfare_call == ''){
        $job->last_send_welfare_call = 0;
      }
      if($job->last_send_welfare_call < (time() - (60*60))){
      try{
        $this->send_push_notification(array('page' => 'welfare-call', 'title' => 'Welfare call', 'message' => 'Are you Fine?', 'fcm_token' => $job->notification_token));
        DB::table('push_notifications')->insert(array(
          'page' => 'welfare-call',
          'title' => 'Welfare call',
          'message' => 'Are you Fine?',
          'notification_to' => 'guard',
          'date_added' => time(),
          'notification_type' => 'welfare_call',
          'guard_id' => $job->guardId,
          'record_id' => $job->roster_id
        ));
        DB::table('job_new_roster')->where('roster_id', $job->roster_id)->update(['last_send_welfare_call' => time()]);
      }catch(Exception $e)
      {

      }
    }
      // DB::table('job_new_roster')->where('roster_id', $job->roster_id)->update(['green_call_notification'=> 'yes']);
    }
    return true;
  }

  public function notifications_list($guard_id)
  {
    $notifications = DB::table('push_notifications')
    ->where('guard_id', '=', $guard_id)
    ->orderBy('id', 'desc')
    ->limit(25)
    ->get();
    return $notifications;
  }

  public function find_guard()
  {
    $a = null;
    $b = '';
    $pending_jobs = DB::table('job_new_roster')
    ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
    ->where('job_new_roster.post_status', '=', '1')
    ->where('job_new_roster.convert_asap_status', '=', 0)
    ->where('job_new_roster.job_start', '>=', strtotime(date('m/d/Y')))->where(
      function ($query) use ($a, $b) {
      return $query->where('guard_id', '=', $a)
            ->orWhere('guard_id', '=', $b);
      }
  )
  ->select('job_new_roster.*', 'jobs.id as jobId', 'jobs.address', 'jobs.coordinates', 'jobs.booking_id', 'jobs.customer_id')
  ->first();
  if($pending_jobs != null){
    $guards = DB::table('guards')->where([
      ['coordinates' , '!=', ''],
      ['notification_token', '!=', '']
    ])->select('guards.id', 'guards.coordinates', 'guards.notification_token', 'guards.name', 'guards.email', 'guards.specific_customers_id')->get();
    $coordinates = explode(',', $pending_jobs->coordinates);
    foreach ($guards as $guard ) {
     $isGuard = false;
    $coordinates1 = explode(',', $guard->coordinates);
    $distance = $this->distance(trim($coordinates[0]), trim($coordinates[1]), trim($coordinates1[0]), trim($coordinates1[1]) );
   
    if($pending_jobs->asap_job_notification_counter == 0){
            $radius = 5;
    }
    elseif($pending_jobs->asap_job_notification_counter == 1){
        $radius = 10;
    }
    elseif($pending_jobs->asap_job_notification_counter == 2){
        $radius = 20;
    }
    else{
        $radius = 5;
    }
    if ($guard->specific_customers_id != '') {
      $specific_customers_id = json_decode($guard->specific_customers_id, true);
      foreach ($specific_customers_id as $key => $value) {
        if ($value == $pending_jobs->customer_id) {
          $isGuard = true;
        }
      }
    }
    $asap_jobs_rejected = DB::table('asap_jobs_rejected')->where(['guard_id' => $guard->id, 'roster_id' => $pending_jobs->roster_id])->first();
    if($distance <= $radius && $isGuard == true && empty($asap_jobs_rejected)){
      
      $job_data = array(
        'roster_id' => $pending_jobs->roster_id,
        'job_id' => $pending_jobs->site_id,
        'address' => $pending_jobs->address,
        'coordinates' => $pending_jobs->coordinates,
        'start' => $pending_jobs->start,
        'end' => $pending_jobs->end,
        'booking_id' => $pending_jobs->booking_id,
        'temp_start' => date('Y-m-d H:i:s', strtotime($pending_jobs->start)),
        'temp_end' => date('Y-m-d H:i:s', strtotime($pending_jobs->end)),
        'job_start_month' => date('M', strtotime($pending_jobs->start)),
        'job_start_day' => date('d', strtotime($pending_jobs->start)),
        'job_start_date' => date('D', strtotime($pending_jobs->start)),
        'Instructions' => ''
      );
      $this->send_push_notification(array('page' => 'asap-job-list', 'title' => 'Job Notification', 'message' => 'Accept this job?', 'fcm_token' => $guard->notification_token, 'job_data' => $job_data));
      $email_data['name'] = $guard->name;
      $email_data['email'] = $guard->email;
      $message = 'Accept this job?. Open app and accept job.<br>
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
                    <td>'.$pending_jobs->start.'</td>
                    <td>'.$pending_jobs->end.'</td>
                    <td>'.$pending_jobs->address.'</td>
                  </tr>
                </table>';

      $this->sendGuardMail($email_data, 'ASAP Job Notification', $message);
        DB::table('push_notifications')->insert(array(
          'page' => 'asap-job',
          'title' => 'Job Notification',
          'message' => 'Accept this job?',
          'notification_to' => 'guard',
          'date_added' => time(),
          'notification_type' => 'find_guard',
          'guard_id' => $guard->id,
          'record_id' => $pending_jobs->roster_id
        ));
        
        DB::table('job_new_roster')
            ->where('roster_id', $pending_jobs->roster_id)
            ->update(['asap_job_notification_counter' => ($pending_jobs->asap_job_notification_counter+1)]);
            
    // echo $distance;
    }
    // }
    // print_r($guards);
    // exit(); 
  }
  }
  $this->find_guard_asap();
    return true;
  }
  function count_today_working_hours($start, $end, $guard_id)
      {
        $today_start = strtotime(date('Y-m-d 00:00:00', strtotime($start)));
        $today_end = strtotime(date('Y-m-d 23:59:59', strtotime($start)));
          if (strtotime($end) > $today_end) {
          $current_shift_today_duration = ($today_end - strtotime($start))/(60*60);
          }else{
          $current_shift_today_duration = (strtotime($end) - strtotime($start))/(60*60);
          }
        $today_working_hours = 0;
        $jobs_today = DB::table('job_new_roster')->where('temp_start', '<', Date('Y-m-d H:i', $today_start))
        ->where('temp_end', '>', Date('Y-m-d H:i', $today_start))
    ->where('guard_id', '=', $guard_id);
    $jobs_today = $jobs_today->get();

    $jobs_today2 = DB::table('job_new_roster')->where('temp_start', '>=', Date('Y-m-d H:i', $today_start))
    ->where('temp_end', '<=', Date('Y-m-d H:i', $today_end))
    ->where('guard_id', '=', $guard_id);
    $jobs_today2 = $jobs_today2->get();


  $jobs_today1 = DB::table('job_new_roster')->where('temp_start', '<', Date('Y-m-d H:i', $today_end))
    ->where('temp_end', '>', Date('Y-m-d', $today_end))
    ->where('guard_id', '=', $guard_id);
  $jobs_today1 = $jobs_today1->get();
 
  
  // $jobs_today = $jobs_today->merge($jobs_today1);
  // $jobs_today = $jobs_today->merge($jobs_today2);

  foreach ($jobs_today as $jt) {
     if ($jt->job_start < $today_start) {
      $jt->job_start = $today_start;
    }
    if ($jt->job_end > $today_end) {
      $jt->job_end = $today_end;
    }
    $today_working_hours += (($jt->job_end - $jt->job_start)/(60*60));
  }
  foreach ($jobs_today2 as $jt2) {
     if ($jt2->job_start < $today_start) {
      $jt2->job_start = $today_start;
    }
    if ($jt2->job_end > $today_end) {
      $jt2->job_end = $today_end;
    }
    $today_working_hours += (($jt2->job_end - $jt2->job_start)/(60*60));
  }
  foreach ($jobs_today1 as $jt1) {
     if ($jt1->job_start < $today_start) {
      $jt1->job_start = $today_start;
    }
    if ($jt1->job_end > $today_end) {
      $jt1->job_end = $today_end;
    }
    $today_working_hours += (($jt1->job_end - $jt1->job_start)/(60*60));
  }
  return round($today_working_hours + $current_shift_today_duration);
      }
public function getAvailableGuards($customerId, $start, $end)
      {
        $customerId = '"'.$customerId.'"';

        $guards = DB::table('guards')
        ->where('status', 'active')
        ->where('is_approved', 'yes')
        ->where('admin_approved',1)
        ->where('address','!=','')
        ->where('phone','!=','')
        ->where('name','!=','')
        ->where('name','!=',null)
        ->where('email','!=','')
        ->where('email','!=',null)
        ->where('emergency_contact_phone','!=','')
        ->where('security_license_number','!=','')
        ->where('security_license_file','!=','')
        ->where('payroll_bank_account_number','!=','')
        ->where('payroll_bank_name','!=','')
        ->where('specific_customers_id', 'LIKE', '%'.$customerId.'%')
        ->select('guards.id', 'guards.coordinates', 'guards.notification_token', 'guards.name', 'guards.email', 'guards.specific_customers_id')->orderBy('name','ASC')
        ->get();

        $available_gaurds = array();
        foreach ($guards as $guard) 
        {
            $max_hours = $this->count_today_working_hours($start, $end, $guard->id);
            $guard->working_hours = $max_hours;
            // $max_hours = 0;
            $already = DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start' ,'<=', $start)->where('temp_end','>=', $start)->first();
          if (empty($already)) {
            $already = DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start', '<=', $end)->where('temp_end', '>=', $end)->first();
          }
          if (empty($already)) {
            $already = DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start', '>=', $start)->where('temp_end', '<=', $end)->first();
          }
          if (empty($already)) {
            $already = DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start', '>=', $start)->where('temp_start', '<=', $end)->first();
          }


          if (empty($already)) {
            $is_available = true;

            $prev_shift_res=  DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_end','<', $start )->orderBy('temp_start', 'desc')->first();
            if(!empty($prev_shift_res)){
         
            $site=DB::table('jobs')->where('id',$prev_shift_res->site_id)->first();
             $site_name=$site->address;
            // $prev_shift='';
                  $prev_shift = [
                      'guard_id'=>$prev_shift_res->guard_id,
                      'temp_date'=>Date("d-m-Y",strtotime($prev_shift_res->temp_date)),
                      'start'=> Date("H:i",strtotime($prev_shift_res->temp_start)),
                      'end'=> Date("H:i",strtotime($prev_shift_res->temp_end)),
                      'site'=>$site_name,
                      'job_time_end' => date('Y-m-d H:i', $prev_shift_res->job_end)
                  ];
               $seconds = strtotime($start) - $prev_shift_res->job_end;
               $hours = $seconds / 60 / 60;
               $guard->previous_shift_diff = $hours;

               if ($hours < 8 && $max_hours > 12) {
                    $is_available = false;
               }
              }else{
                $prev_shift = [];
              }
         
              $next_shift_res=  DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start' ,'>', $end)->orderBy('temp_start', 'asc')->first();
              if(!empty($next_shift_res)){
              
              $site=DB::table('jobs')->where('id',$next_shift_res->site_id)->first();
              $site_name=$site->address;
                  $next_shift = [
                      'guard_id'=>$next_shift_res->guard_id,
                      'temp_date'=>Date("d-m-Y",strtotime($next_shift_res->temp_date)),
                      'start'=> Date("H:i",strtotime($next_shift_res->temp_start)),
                      'end'=> Date("H:i",strtotime($next_shift_res->temp_end)),
                      'site'=>$site_name,
                  ];
                $seconds = $next_shift_res->job_start - strtotime($end);
                $hours = $seconds / 60 / 60;
                $guard->next_shift_diff = $hours;

               if ($hours < 8 && $max_hours > 12) {
                    $is_available = false;
               }
               
              }else{
                $next_shift = [];
              }
              $guard->next_shift=$next_shift;
              $guard->prev_shift=$prev_shift;
                if ($is_available) {
                    $available_gaurds[] = $guard;
                }
          }
         
        }
        return $available_gaurds;
      }
  public function find_guard_asap()
  {
    $pending_jobs = DB::table('job_new_roster')
    ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
    ->where('job_new_roster.publish_status', '=', '1')
    ->where('job_new_roster.convert_asap_status', '=', 1)
    ->where('job_new_roster.job_start', '>=', strtotime(date('m/d/Y')))->where(
      function ($query) {
      return $query->where('guard_id', '=', '')
            ->orWhere('guard_id', '=', null)
            ->orWhere('guard_id', '=', 0);
      }
  )
  ->select('job_new_roster.*', 'jobs.id as jobId', 'jobs.address', 'jobs.coordinates', 'jobs.booking_id', 'jobs.customer_id')
  ->first();
  if($pending_jobs != null){
        $customerId = '"'.$pending_jobs->customer_id.'"';
        $guards = $this->getAvailableGuards($pending_jobs->customer_id, $pending_jobs->temp_start, $pending_jobs->temp_end);
    foreach ($guards as $guard ) {
      $already = DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start' ,'<=', $pending_jobs->temp_start)->where('temp_end','>=', $pending_jobs->temp_start)->first();
          if (empty($already)) {
            $already = DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start', '<=', $pending_jobs->temp_end)->where('temp_end', '>=', $pending_jobs->temp_end)->first();
          }
          if (empty($already)) {
            $already = DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start', '>=', $pending_jobs->temp_start)->where('temp_end', '<=', $pending_jobs->temp_end)->first();
          }
          if (empty($already)) {
            $already = DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start', '>=', $pending_jobs->temp_start)->where('temp_start', '<=', $pending_jobs->temp_end)->first();
          }

          if (empty($already)) {
             $isGuard = true;
          }
    
   
    $asap_jobs_rejected = DB::table('asap_jobs_rejected')->where(['guard_id' => $guard->id, 'roster_id' => $pending_jobs->roster_id])->first();
    if($isGuard == true && empty($asap_jobs_rejected)){
      
      $job_data = array(
        'roster_id' => $pending_jobs->roster_id,
        'job_id' => $pending_jobs->site_id,
        'address' => $pending_jobs->address,
        'coordinates' => $pending_jobs->coordinates,
        'start' => $pending_jobs->start,
        'end' => $pending_jobs->end,
        'booking_id' => $pending_jobs->booking_id,
        'temp_start' => date('Y-m-d H:i:s', strtotime($pending_jobs->start)),
        'temp_end' => date('Y-m-d H:i:s', strtotime($pending_jobs->end)),
        'job_start_month' => date('M', strtotime($pending_jobs->start)),
        'job_start_day' => date('d', strtotime($pending_jobs->start)),
        'job_start_date' => date('D', strtotime($pending_jobs->start)),
        'Instructions' => ''
      );
      $this->send_push_notification(array('page' => 'asap-job-list', 'title' => 'Job Notification', 'message' => 'Accept this job?', 'fcm_token' => $guard->notification_token, 'job_data' => $job_data));
      $email_data['name'] = $guard->name;
      $email_data['email'] = $guard->email;
      $message = 'Accept this job?. Open app and accept job.<br>
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
                    <td>'.$pending_jobs->start.'</td>
                    <td>'.$pending_jobs->end.'</td>
                    <td>'.$pending_jobs->address.'</td>
                  </tr>
                </table>';

      $this->sendGuardMail($email_data, 'ASAP Job Notification', $message);
        DB::table('push_notifications')->insert(array(
          'page' => 'asap-job',
          'title' => 'Job Notification',
          'message' => 'Accept this job?',
          'notification_to' => 'guard',
          'date_added' => time(),
          'notification_type' => 'find_guard',
          'guard_id' => $guard->id,
          'record_id' => $pending_jobs->roster_id
        ));
        
        DB::table('job_new_roster')
            ->where('roster_id', $pending_jobs->roster_id)
            ->update(['asap_job_notification_counter' => ($pending_jobs->asap_job_notification_counter+1)]);
            
    // echo $distance;
    }
    // }
    // print_r($guards);
    // exit(); 
  }
  }
    return true;
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

        return $miles;

    }

    function sendGuardMail($user, $subject, $email_message) {

        $root= $_SERVER['HTTP_HOST'];
        $root = explode('.', $root);
        $postfix = 'staffingsolution';
        if($root[0] != 'wwww'){
            $postfix = $root[0];
        }else{
        $postfix = $root[1];
        }
        $config_data = DB::connection('mysql2')->table('business_data')->where('domain', '=', $postfix)->first();
  
          $to = $user['email'];
  
          $from = 'no-reply@'.$_SERVER['HTTP_HOST'];  
  
          $logo1 = 'https://'.$_SERVER['HTTP_HOST'] . '/uplaods/'. $config_data->logo;
  
          $logo2 = 'https://'.$_SERVER['HTTP_HOST']."/files/email-template/ASIAL-Member-Logo-11.png";
  
          $logo3 = 'https://'.$_SERVER['HTTP_HOST']."/portal/files/email-template/labour-hire-authority-post-banner-1.jpg";
  
  
  
  // To send HTML mail, the Content-type header must be set
  
          $headers  = 'MIME-Version: 1.0' . "\r\n";
  
          $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  
  
  
  // Create email headers
  
          $headers .= 'From: '.$from."\r\n".
  
              'Reply-To: '.$from."\r\n" .
  
              'X-Mailer: PHP/' . phpversion();
  
  
  
          // Compose a simple HTML email message
  
          $message = 'Hello '. $user['name'] . ',<br><br>';
  
          $message .= $email_message.'<br><br>';
  
          $message .= '<span style="color:blue;">Kind Regards,</span><br><br>';
  
          $message .= '<span style="color:blue;">Admin<span><br><br>';
  
          $message .= '<span style="font-size:large;font-weight:bold;color:black;">'.$config_data->title.' Pty Ltd<span><br>';
  
          $message .= '<span style="font-size:small;font-weight:bold;">A: '.$config_data->address.'<span><br>';
  
          $message .= '<span style="font-weight:bold;">W: <a href="https://'.$_SERVER['HTTP_HOST'] . '/portal/">https://'.$_SERVER['HTTP_HOST'] . '/portal/</a><span><br><br><br>';
  
          $message .= '<img src="'.$logo1.'" style="width:50%;float:left;"/>';
  
          $message .= '<img src="'.$logo2.'" style="width:50%;float:left;"/>';
  
          // $message .= '<img src="'.$logo3.'" style="width:33%;float:left;padding-top:2.5rem;"/>';
  // Sending email
          try{
          mail($to, $subject, $message, $headers);
          }catch(Exception $e)
          {
  
          }
      }

      function notifications_data($notification_id, $guard_id)
      {
        $return_data = array();
        $notification = DB::table('push_notifications')->where(['id' => $notification_id])->first();
        if ($notification->notification_type == 'welfare_call') {
          $roster_data = DB::table('job_new_roster')->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')->where(['job_new_roster.roster_id' => $notification->record_id, 'job_new_roster.guard_id' => $guard_id])->select('job_new_roster.*', 'jobs.id as siteId', 'jobs.site_name', 'jobs.site_description', 'jobs.address')->first();
          $response_data = DB::table('welfare_call_data')->where(['job_roster_id' => $notification->record_id, 'guard_id' => $guard_id])->orderBy('id', 'desc')->first();
          if (!empty($roster_data)) {
          $return_data = [
            'notification_id' => $notification->id,
            'notification_message' => $notification->message,
            'notification_send_time' => date('d-m-Y H:i', $notification->date_added),
            'notification_type' => $notification->notification_type,
            'job_start_time' => $roster_data->temp_start,
            'job_end_time' => $roster_data->temp_end,
            'address' => $roster_data->address,
            'site_name' => $roster_data->site_name,
            'site_description' => $roster_data->site_description,
            'site_id' => $roster_data->siteId,
            'notification_response' => array()
          ];
          }else{
            return false;
          }
          if (!empty($response_data)) {
            $return_data['notification_response'] = [
              'response_id' => $response_data->id,
              'notes' => $response_data->notes,
              'status' => $response_data->status,
              'response_time' => $response_data->created_at,
              'coordinates' => 'N/A'

            ];
          }
        }elseif ($notification->notification_type == 'green_call') {
          $mints  = 120;
          if ($notification->message != 'You have a shift in 2 hour. Are you all good for your shift today?') {
            $mints = 30;
          }
          $roster_data = DB::table('job_new_roster')->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')->where(['job_new_roster.roster_id' => $notification->record_id, 'job_new_roster.guard_id' => $guard_id])->select('job_new_roster.*', 'jobs.id as siteId', 'jobs.site_name', 'jobs.site_description', 'jobs.address')->first();
          $response_data = DB::table('green_call')->where(['job_id' => $notification->record_id, 'guard_id' => $guard_id, 'before_time' => $mints])->orderBy('id', 'desc')->first();
          if (!empty($roster_data)) {
          $return_data = [
            'notification_id' => $notification->id,
            'notification_message' => $notification->message,
            'notification_send_time' => date('d-m-Y H:i', $notification->date_added),
            'notification_type' => $notification->notification_type,
            'job_start_time' => $roster_data->temp_start,
            'job_end_time' => $roster_data->temp_end,
            'address' => $roster_data->address,
            'site_name' => $roster_data->site_name,
            'site_description' => $roster_data->site_description,
            'site_id' => $roster_data->siteId,
            'notification_response' => array()
          ];
        }else{
          return false;
        }
          if (!empty($response_data)) {
            $return_data['notification_response'] = [
              'response_id' => $response_data->id,
              'notes' => 'N/A',
              'status' => $response_data->status,
              'response_time' => $response_data->created_at,
              'coordinates' => $response_data->coordinates
            ];
          }
        }
        elseif ($notification->notification_type == 'find_guard') {
          
          $roster_data = DB::table('job_new_roster')->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')->where(['job_new_roster.roster_id' => $notification->record_id])->select('job_new_roster.*', 'jobs.id as siteId', 'jobs.site_name', 'jobs.site_description', 'jobs.address')->first();
          $response_data = array();
          if (!empty($roster_data)) {
            $return_data = [
              'notification_id' => $notification->id,
              'notification_message' => $notification->message,
              'notification_send_time' => date('d-m-Y H:i', $notification->date_added),
              'notification_type' => $notification->notification_type,
              'job_start_time' => $roster_data->temp_start,
              'job_end_time' => $roster_data->temp_end,
              'address' => $roster_data->address,
              'site_name' => $roster_data->site_name,
              'site_description' => $roster_data->site_description,
              'site_id' => $roster_data->siteId,
              'notification_response' => array()
            ];
          }else{
            return false;
          }
          if (!empty($response_data)) {
            $return_data['notification_response'] = [
              'response_id' => $response_data->id,
              'notes' => 'N/A',
              'status' => $response_data->status,
              'response_time' => $response_data->created_at,
              'coordinates' => $response_data->coordinates
            ];
          }
        }
        return $return_data;

      }
      function profile_incomplete_notification()
      {
        $incomplete_gaurds = DB::table('guards')->where('profile_completion','<', 70)->where('status', 'active')->get();

        foreach ($incomplete_gaurds as $key => $guard) {
          $email_data['name'] = $guard->name;
          $email_data['email'] = $guard->email;
          $message = 'Your prifile is incomplete.';

        $this->sendGuardMail($email_data, 'In-complete Profile Notification', $message);
        }
      return true;
      }
}
