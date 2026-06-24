<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Task_report extends Model
{
    protected $table = 'job_roster_tasks';
    use HasFactory;
    // ->orderBy('job_new_roster.roster_id', 'desc')->take(50)->get();

    public function get_customers(){
        // orderBy('TIMESTAMP_INSERTED', 'desc')->take(50)->
       $temp1 = DB::table('customers')->where('status', 'active')->select('id','name')
       ->orderBy('name','ASC');
       if (session()->has('specific_customer') && session()->get('specific_customer') != '') {
                $specific_customer = json_decode(session()->get('specific_customer'));
                $temp1->where(function($query)  use($specific_customer){
                    foreach ($specific_customer as $key => $id) {
                        if ($key == 0) {
                            $query->where('id', $id);
                        }else{
                            $query->orWhere('id', $id);
                        }
                    }
                });
            }
       $results = $temp1->get();
       return $results;
    }


    function get_customers_jobs_list($customer_id){
    	$status = null;
    	$specific_sites_id = array();
        $temp1 = DB::table('jobs')->join('customers', 'customers.id', '=', 'jobs.customer_id');
        if (is_array($customer_id)) {
        $temp1->whereIn('customers.id', $customer_id);
            
        }else{
        $temp1->where('customers.id', $customer_id);
        }
        $temp1->where('jobs.status', 'active')
        ->where('jobs.status', 'active')
        ->select('customers.id as customerId','jobs.id as jobId', 'jobs.address as address', 'jobs.booking_id as bookingId', 'jobs.site_name', 'jobs.site_description');
        if (empty($customer_id) && session()->has('specific_sites') && session()->get('specific_sites') != '') {
                $specific_sites = json_decode(session()->get('specific_sites'));
                $temp1->where(function($query)  use($specific_sites){
                    foreach ($specific_sites as $key => $id) {
                        if ($key == 0) {
                            $query->where('jobs.id', $id);
                        }else{
                            $query->orWhere('jobs.id', $id);
                        }
                    }
                });
            }
        $data = $temp1->orderBy('jobs.site_name','ASC')
        ->get();
        if ($status != null) {
          $active = array();
          foreach ($data as $d) {
          // $end = strtotime('monday next week');
          $start = strtotime('monday this week');
          $this->db->where('temp_start >=', date('Y-m-d H:i:s', $start));
          // $this->db->where('temp_start <=', date('Y-m-d H:i:s', $end));
          $active_jobs = $this->db->get_where('job_new_roster', array('site_id' => $d->jobId))->result_array();
          if ($specific_sites_id != null && !empty($specific_sites_id)) {
            foreach ($specific_sites_id as $key => $value) {
            if ($d->jobId == $value) {
          if ($status == 'active') {
            if (!empty($active_jobs)) {
            $active[] = $d;
          }
          }
          if ($status == 'inactive') {
            if (empty($active_jobs)) {
            $active[] = $d;
          }
          }
          }
        }
        }else{
          if ($status == 'active') {
            if (!empty($active_jobs)) {
            $active[] = $d;
          }
          }
          if ($status == 'inactive') {
            if (empty($active_jobs)) {
            $active[] = $d;
          }
          }
        }


          }
          $data = $active;
        }else{
          if ($specific_sites_id != null && !empty($specific_sites_id)) {
            $specific = array();
          foreach ($data as $d) {
            foreach ($specific_sites_id as $key => $value) {
              if ($d->jobId == $value) {
                $specific[] = $d;
              }
            }
          }
          $data = $specific;

          }
        }
      // }
        return response()->json($data);
        exit;
    }
    public function task_report_onchange($customer_id){
       // DB::raw('count(*) as total_count'),
        $temp1 = DB::table('job_new_roster')
        ->join('job_roster_tasks', 'job_roster_tasks.roster_id', '=', 'job_new_roster.roster_id')
        ->join('guards', 'guards.id', '=', 'job_roster_tasks.guard_id')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->join('customers', 'customers.id', '=', 'jobs.customer_id')
        ->where('jobs.status', 'active')
        ->where('jobs.customer_id', $customer_id)
        ->groupBy('job_new_roster.guard_id')
        ->select('guards.id as guardId');
        // ->select('customers.id as customerId','guards.id as guardId',
        // 'guards.name as guard_name','jobs.id as jobId', 'jobs.address as address', 
        // 'jobs.booking_id as bookingId', 'jobs.site_name', 'jobs.site_description',
        // 'job_roster_tasks.task_name','job_new_roster.temp_date as job_added',
        // 'job_new_roster.temp_start as job_start','job_new_roster.temp_end as job_end',
        // 'guards.specific_customers_id as specific_customers_id',
        // 'job_new_roster.roster_id as roster_id',
        // 'job_roster_tasks.id as task_id', 'job_roster_tasks.start_time', 'job_roster_tasks.end_time', 'job_roster_tasks.end_location');
        if (session()->has('specific_sites') && session()->get('specific_sites') != '') {
                $specific_sites = json_decode(session()->get('specific_sites'));
                $temp1->where(function($query)  use($specific_sites){
                    foreach ($specific_sites as $key => $id) {
                        if ($key == 0) {
                            $query->where('jobs.id', $id);
                        }else{
                            $query->orWhere('jobs.id', $id);
                        }
                    }
                });
            }
        $data = $temp1->get();
        return $data;
    }
    public function task_report_search($customer_id){
      // $data = DB::table('job_new_roster')
      // ->join('job_roster_tasks', 'job_roster_tasks.roster_id', '=', 'job_new_roster.roster_id')
      // ->join('guards', 'guards.id', '=', 'job_roster_tasks.guard_id')
      // ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
      // ->join('customers', 'customers.id', '=', 'jobs.customer_id')
      // ->where('jobs.status', 'active')
      // ->where('jobs.customer_id', $customer_id)
      // ->groupBy('jobs.id')
      // ->select(
      // DB::raw('count(*) as total_count'),
      // 'customers.id as customerId','guards.id as guardId',
      // 'guards.name as guard_name','jobs.id as jobId', 'jobs.address as address', 
      // 'jobs.booking_id as bookingId', 'jobs.site_name', 'jobs.site_description',
      // 'job_roster_tasks.task_name','job_new_roster.temp_date as job_added',
      // 'job_new_roster.temp_start as job_start','job_new_roster.temp_end as job_end',
      // 'guards.specific_customers_id as specific_customers_id',
      // 'job_new_roster.roster_id as roster_id',
      // 'job_roster_tasks.id as task_id', 'job_roster_tasks.start_time', 'job_roster_tasks.end_time', 'job_roster_tasks.end_location');
      //   return $data;
      $data = DB::table('job_new_roster')
        ->join('job_roster_tasks', 'job_roster_tasks.roster_id', '=', 'job_new_roster.roster_id')
        ->join('guards', 'guards.id', '=', 'job_roster_tasks.guard_id')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->join('customers', 'customers.id', '=', 'jobs.customer_id')
        ->where('jobs.status', 'active')
        ->where('jobs.customer_id', $customer_id)
        ->groupBy('job_new_roster.roster_id')
        ->select('customers.id as customerId','guards.id as guardId',
        'guards.name as guard_name','jobs.id as jobId', 'jobs.address as address', 
        'jobs.booking_id as bookingId', 'jobs.site_name', 'jobs.site_description',
        'job_roster_tasks.task_name','job_new_roster.temp_date as job_added',
        'job_new_roster.temp_start as job_start','job_new_roster.temp_end as job_end',
        'guards.specific_customers_id as specific_customers_id',
        'job_new_roster.roster_id as roster_id',
        'job_roster_tasks.id as task_id', 'job_roster_tasks.start_time', 'job_roster_tasks.end_time', 'job_roster_tasks.end_location');
        return $data;
    }
    

}
