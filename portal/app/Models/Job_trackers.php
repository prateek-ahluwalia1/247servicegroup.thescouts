<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Job_trackers extends Model
{
  protected $table = 'job_new_roster';
  use HasFactory;

  public function get_search_record()
  {
   $results = DB::table('job_new_roster')
   ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
   ->leftJoin('guards', 'job_new_roster.guard_id', '=', 'guards.id')
   ->leftJoin('guard_payroll_ids', 'guards.id', '=', 'guard_payroll_ids.guard_id')
   ->join('customers', 'jobs.customer_id', '=', 'customers.id')
   ->leftJoin('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')
     // ->leftJoin('job_roster_activities as ja', 'job_new_roster.guard_id', '=', 'ja.guard_id')
   ->leftJoin('contractors', 'jobs.contractor_id', '=', 'contractors.id')
   ->leftJoin('administrators', 'job_new_roster.status_change_by', '=', 'administrators.id')
   ->select('job_new_roster.*', 'jobs.id AS job_id', 'jobs.booking_id',
     'jobs.customer_id',
     'jobs.contractor_id',
     'jobs.state',
     'jobs.stateType',
     'jobs.address',
     'jobs.site_description',
     'jobs.site_name',
     'jobs.details',
     'jobs.level',
     'jobs.payable as break_payable',
     'jobs.payable_and_chargeable_time',
     'customers.name AS customer_name' ,
     'contractors.name  AS contractor_name',
     'guards.guard_type',
     'guards.name  AS guard_name',
     'guards.phone  AS guard_phone',
     'guards.id  AS guard_ID',
     'customers.flat_metro_week_day',
     'job_roster_activities.signin_time',
     'job_roster_activities.signout_time',
     'job_roster_activities.auto_signout',
     'jobs.break',
     'jobs.chargeable',
     'jobs.payable',
     'administrators.name AS admin_name',
     'guard_payroll_ids.payroll_id AS guard_payroll_id' 
   );
   return $results;
 }
 public function get_records($status){
  $query_append = '';
  $extra_query = '';
  if (session()->has('specific_sites') && session()->get('specific_sites') != '') {
    $specific_sites = json_decode(session()->get('specific_sites'));
    if (!empty($specific_sites)) {
    $extra_query = "(";
    $i = 0;
    foreach ($specific_sites as $key => $id) {
      $extra_query .= "jr.`site_id` = '".$id."'";
          if ($i < sizeof($specific_sites) -1) {
            $extra_query .= " OR ";
          }
          $i++;
    }
    $extra_query .= ") AND ";
  }
  }
  if (session()->has('specific_customer') && session()->get('specific_customer') != '') {
    $specific_customer = json_decode(session()->get('specific_customer'));
    if (!empty($specific_customer)) {
    $extra_query = "(";
     $i = 0;
    foreach ($specific_customer as $key => $id) {
      $extra_query .= "j.`customer_id` = '".$id."'";
          if ($i < sizeof($specific_customer) -1) {
            $extra_query .= " OR ";
          }
          $i++;
    }
    $extra_query .= ") AND ";
  }
  }

  if ($status == 'completed' || $status == 'confirmed') {
    $result = DB::select(
      "SELECT
      jr.*,
      j.`id` AS job_id,
      j.`booking_id`,
      j.`customer_id`,
      j.`contractor_id`,
      j.`state`,
      j.`stateType`,
      j.`address`,
      j.`site_name`,
      j.`site_description`,
      j.`break`,
      j.`payable`,
      j.`chargeable`,
      cust.`name` AS customer_name,
      c.`name` AS contractor_name,
      g.`guard_type`,
      g.`phone` AS guard_phone,
      g.`id` AS guard_id,
      g.`email` AS guard_email,
      g.`address` AS guard_address,
      g.`profile_image` AS guard_image,
      g.`name` AS guard_name,
      ad.`name` AS admin_name,
      jsa.`signin_time`,
      j.`details`,
      j.`level`,
      gpi.`payroll_id` AS guard_payroll_id,
      jsa.`signout_time`,
      jsa.`auto_signout`
      FROM job_new_roster AS jr
      INNER JOIN jobs AS j ON j.`id` = jr.`site_id`
      LEFT JOIN job_roster_activities AS jsa ON jsa.`job_roster_id` = jr.`roster_id`
      LEFT JOIN `guards` AS g ON g.`id` = jr.`guard_id`
      LEFT JOIN `guard_payroll_ids` AS gpi ON g.`id` = gpi.`guard_id`
      LEFT JOIN customers AS cust ON j.`customer_id` = cust.`id`
      LEFT JOIN `contractors` AS c ON j.`contractor_id`= c.`id`
      LEFT JOIN `administrators` AS ad ON jr.`status_change_by` = ad.`id`
      WHERE ".$extra_query."jr.`temp_end` <= '".date('Y-m-d H:i:s')."' AND (jr.`job_status` = '".$status."' OR jr.`job_status`='pending' OR jr.`job_status` = 'confirmed' OR jr.`job_status` = 'rejected') ORDER BY jr.job_end DESC LIMIT 10"
    );
  }elseif($status == 'inprogress'){
    $result = DB::select(
      "SELECT
      jr.*,
      j.`id`,
      j.`booking_id`,
      j.`customer_id`,
      j.`contractor_id`,
      j.`state`,
      j.`stateType`,
      j.`address`,
      j.`site_name`,
      j.`site_description`,
      j.`break`,
      j.`payable`,
      j.`chargeable`,
      cust.`name` AS customer_name,
      c.`name` AS contractor_name,
      g.`guard_type`,
      g.`phone` AS guard_phone,
      g.`id` AS guard_id,
      g.`email` AS guard_email,
      g.`address` AS guard_address,
      g.`profile_image` AS guard_image,
      g.`name` AS guard_name,
      jsa.`signin_time`,
      j.`details`,
      j.`level`,
      jsa.`signout_time`,
      gpi.`payroll_id` AS guard_payroll_id,
      ad.`name` AS admin_name,
      jsa.`auto_signout`
      FROM job_new_roster AS jr
      LEFT JOIN jobs AS j ON j.`id` = jr.`site_id`
      INNER JOIN job_roster_activities AS jsa ON jsa.`job_roster_id` = jr.`roster_id`
      LEFT JOIN `guards` AS g ON g.`id` = jr.`guard_id`
      LEFT JOIN `guard_payroll_ids` AS gpi ON g.`id` = gpi.`guard_id`

      LEFT JOIN customers AS cust ON j.`customer_id` = cust.`id`
      LEFT JOIN `contractors` AS c ON j.`contractor_id`= c.`id`
      LEFT JOIN `administrators` AS ad ON jr.`status_change_by` = ad.`id`
      WHERE ".$extra_query."jr.`temp_start` >= '".date('Y-m-d')."' AND jr.`job_status` = 'confirmed' ORDER BY jr.temp_start ASC"
    );
  }elseif($status == 'pending'){
    $result = DB::select(
      "SELECT
      jr.*,
      j.`id`,
      j.`booking_id`,
      j.`customer_id`,
      j.`contractor_id`,
      j.`state`,
      j.`stateType`,
      j.`address`,
      j.`site_name`,
      j.`site_description`,
      j.`break`,
      j.`payable`,
      j.`chargeable`,
      cust.`name` AS customer_name,
      c.`name` AS contractor_name,
      g.`guard_type`,
      g.`phone` AS guard_phone,
      g.`id` AS guard_id,
      g.`email` AS guard_email,
      g.`address` AS guard_address,
      g.`profile_image` AS guard_image,
      g.`name` AS guard_name,
      jsa.`signin_time`,
      j.`details`,
      j.`level`,
      jsa.`signout_time`,
      gpi.`payroll_id` AS guard_payroll_id,
      jsa.`auto_signout`,
      ad.`name` AS admin_name
      FROM job_new_roster AS jr
      LEFT JOIN jobs AS j ON j.`id` = jr.`site_id`
      LEFT JOIN job_roster_activities AS jsa ON jsa.`job_roster_id` = jr.`roster_id`
      LEFT JOIN `guards` AS g ON g.`id` = jr.`guard_id`
      LEFT JOIN `guard_payroll_ids` AS gpi ON g.`id` = gpi.`guard_id`

      LEFT JOIN customers AS cust ON j.`customer_id` = cust.`id`
      LEFT JOIN `contractors` AS c ON j.`contractor_id`= c.`id`
      LEFT JOIN `administrators` AS ad ON jr.`status_change_by` = ad.`id`
      WHERE ".$extra_query."jr.`temp_start` >= '".date('Y-m-d H:i:s')."' AND (jr.`job_status` = '".$status."' OR jr.`job_status` = 'confirmed' OR jr.`job_status` = 'rejected') ORDER BY jr.temp_start ASC LIMIT 50"
    );
  }elseif($status == 'missed')
  {
   $result = DB::select(
    "SELECT
    jr.*,
    j.`id`,
    j.`booking_id`,
    j.`customer_id`,
    j.`contractor_id`,
    j.`state`,
    j.`stateType`,
    j.`address`,
    j.`site_name`,
    j.`site_description`,
    j.`break`,
    j.`payable`,
    j.`chargeable`,
    cust.`name` AS customer_name,
    c.`name` AS contractor_name,
    g.`guard_type`,
    g.`phone` AS guard_phone,
    g.`id` AS guard_id,
    g.`email` AS guard_email,
    g.`address` AS guard_address,
    g.`profile_image` AS guard_image,
    g.`name` AS guard_name,
    jsa.`signin_time`,
    j.`details`,
    j.`level`,
    jsa.`signout_time`,
    gpi.`payroll_id` AS guard_payroll_id,
    jsa.`auto_signout`,
    ad.`name` AS admin_name
    FROM job_new_roster AS jr
    LEFT JOIN jobs AS j ON j.`id` = jr.`site_id`
    LEFT JOIN job_roster_activities AS jsa ON jsa.`job_roster_id` = jr.`roster_id`
    LEFT JOIN `guards` AS g ON g.`id` = jr.`guard_id`
    LEFT JOIN `guard_payroll_ids` AS gpi ON g.`id` = gpi.`guard_id`

    LEFT JOIN customers AS cust ON j.`customer_id` = cust.`id`
    LEFT JOIN `contractors` AS c ON j.`contractor_id`= c.`id`
    LEFT JOIN `administrators` AS ad ON jr.`status_change_by` = ad.`id`
    WHERE ".$extra_query."jr.`temp_start` <='".date('Y-m-d H:i:s')."' AND jr.`signin_status` = 0 AND (jr.`job_status` = 'pending' OR jr.`job_status` = 'confirmed' OR jr.`job_status` = 'rejected') ORDER BY jr.temp_start ASC"
  );
          // AND jr.`temp_end` >= '".date('Y-m-d H:i:s', time())."'
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

function jobs_status($status,$results)
{
  if($status=="missed")
  {
                // jr.`temp_start` <='".date('Y-m-d H:i:s')."' AND jr.`temp_end` >= '".date('Y-m-d H:i:s', time())."' AND (jr.`job_status` = 'pending' OR jr.`job_status` = 'confirmed') "


        // ->where('job_new_roster.temp_start' , ' <=', date('Y-m-d H:i:s'))
        // ->where('job_new_roster.temp_end' , ' <=', date('Y-m-d H:i:s', time()))
   $results = $results->where(function($query) {
     $query->where('job_new_roster.job_status' , "pending")
     ->orWhere('job_new_roster.job_status' , "confirmed")
     ->orWhere('job_new_roster.job_status' , "rejected");
   });

 }
 if($status == "inprogress"){


        // ->where('job_new_roster.temp_start' , ' <=', date('Y-m-d H:i:s'))
  $results=$results->where('job_new_roster.job_status' , "confirmed");

}
if($status == "confirmed" || $status == 'completed'){
  $results = $results->where(function($query) {
   $query->where('job_new_roster.job_status' , "completed")
   ->orWhere('job_new_roster.job_status' , "confirmed")
   ->orWhere('job_new_roster.job_status' , "pending")
   ->orWhere('job_new_roster.status_change_by' , '>', 0);
          // ->orWhere('job_new_roster.job_status' , "rejected");
 });
        // $results=$results->where('job_new_roster.job_status' , "confirmed")
        // ->orWhere('job_new_roster.job_status' , "completed");

}
if($status == "pending"){
  $results = $results->where(function($query) {
   $query->where('job_new_roster.job_status' , "pending")
   ->orWhere('job_new_roster.job_status' , "rejected");
 });
        // $results=$results->where('job_new_roster.job_status' ,"pending");

}
                    // $result=$results->take(50)->get();
return $results;

}

}
