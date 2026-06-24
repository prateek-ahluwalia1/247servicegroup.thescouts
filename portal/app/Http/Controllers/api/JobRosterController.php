<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job_new_roster as job_new_roster;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Job\JobRosterCollection;
use App\Http\Resources\Job\JobRosterResource;

class JobRosterController extends ApiController
{
    protected $timezone = array(
      'Victoria' => 'Australia/Melbourne',
      'New South Whales' => 'Australia/Sydney',
      'Queensland' => 'Australia/Brisbane',
      'Tasmania' => 'Australia/Hobart',
      'Western Australia' => 'Australia/Perth',
      'South Australia' => 'Australia/Adelaide',
      'ACT' => 'Australia/Canberra'
  );

    function adminSpecificPermissions($admin_id)
    {
        $admin = DB::table('administrators')->where('id', $admin_id)->select('specific_customer', 'specific_sites')->first();
        if ($admin->specific_customer != '') {
         $admin->specific_customer = json_decode($admin->specific_customer, true);
     } 
     if ($admin->specific_sites != '') {
         $admin->specific_sites = json_decode($admin->specific_sites, true);
     }   
     return $admin;
 }
 public function getSingleGuard($guardId){

    $data = DB::table('guards')->where(['id' => $guardId])->first();
    return $data;

}
public function getJobRoster(Request $request)
{
        // config(['app.timezone' => 'Australia/Melbourne']);
        // date_default_timezone_set('Australia/Melbourne');
    if (!$request->has('customerId') || empty($request->customerId)) {
        $this->response = ['status' => false, 'error' => 'Please select customer first!'];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
    $ps = DB::table('portal_settings')->where('permission_name', 'portal_colors')->where('permission', 1)->select('users_emails')->first();
    if (!empty($ps)) {
        $colors = json_decode($ps->users_emails, true);
    }else{
        $colors = array();
    }
    $admin_id = 0;
    if ($request->has('admin_id')) {
        $admin_id = $request->admin_id;
    }
    $rosterData = $this->getCalenderData($request->customerId, $request->start, $request->end, $request->search_value, $admin_id);
    $siteId = $request->search_value ?? null;
    if (count($rosterData) > 0) {
        $rosterD = array();
        foreach ($rosterData as $key => $roster) {
            //     $guardName = $this->getSingleGuard($roster->guard_id);
            // if (!empty($guardName) && $roster->guard_id > 0 && $guardName->state != '') {
            //     config(['app.timezone' => $this->timezone[$guardName->state]]);
            //     date_default_timezone_set($this->timezone[$guardName->state]);
            // }else{
            //     config(['app.timezone' => $this->timezone['Victoria']]);
            //     date_default_timezone_set($this->timezone['Victoria']);
            // }
            $missed = false;
            $className = 'custom-color-blue';
            $color = '#ffff00';
            $eventBorderColor = '#84b3cd40';
            if($roster->job_status == "pending"){
                $color = !empty($colors) ? $colors['pending_shifts'] : "#ffff00";
                $eventBorderColor = '#84b3cd40';
            }
            if($roster->job_status == 'rejected'){
                $className = 'custom-color-yellow';
                $textColor = "#000";
                $color = !empty($colors) ? $colors['rejected_shifts'] : "#ffff00";
            }elseif($roster->guard_id == '' || $roster->guard_id == 0) {
                $color = "#ffff00";
                $className = 'custom-color-yellow';
            }elseif ($roster->publish_status == 1) {
                $className = 'custom-colors-publish';
                
            }elseif($roster->publish_status == 0){
                $className = 'custom-colors-unpublish';
            }else{
                $className = 'custom-color-dark-khaki';
            }

            if($roster->job_status == "confirmed"){
                $color = !empty($colors) ? $colors['publish_shifts'] : "#92D050";
            }elseif($roster->job_status == "completed"){
                $color = !empty($colors) ? $colors['publish_shifts'] : "#92D050";
            }
            $message = 'No '.config('custom.guard').'<br>accepted the job<br> yet';
            if ($roster->post_status == '0') {
                $message = 'Uncovered Shift';

            }
            $title = ($roster->guard_id != '' && $roster->guard_id > 0) ? $roster->name : $message;
            if($roster->job_status == "completed"){
                $title = $title .' (C)';
            }
            if (($roster->guard_id == null || $roster->guard_id == 0) && $roster->moke_guard != '') {
                $title = $roster->moke_guard;
                $color = !empty($colors) ? $colors['mock_shifts'] : '#C4D79B';
                $className = 'custom-color-mock-guard';

            }
            $current_time = date('Y-m-d H:i');
            if ($roster->temp_start < date('Y-m-d H:i') && $roster->job_status != 'rejected' && $roster->publish_status == 1) {
                $activity = DB::table('job_roster_activities')->where(['job_roster_id' => $roster->roster_id])->first();
                if (empty($activity)) {
                    if ($roster->guard_id != '') {
                        $className = 'custom-color-red-orange';
                    }
                    $textColor = '#000';
                // $data['color'] = "#FFFF00";
                    if ($roster->job_start < time()) {
                        $title = $title .' (M)';
                        $missed = true;
                    }
                }elseif($activity->status == 1){
                    $title = $title .' (S)';
                }elseif($activity->status == 0){
                // $title = $title .' (C)';
                }

            }
            $same = false;
            if (date('Y-m-d' , strtotime($roster->temp_start)) ==  date('Y-m-d' , strtotime($roster->temp_end))) {
                $same = true;
            }
            if ($same == false) {
            // $title .= ' (Shift End: '.date('H:i', strtotime($roster->temp_end)).')';
            }
            if ($roster->job_status == 'rejected') {
                if ($roster->rejected_by > 0) {
                    $message = 'Shift denied by '. $roster->rejected_by_name;
                }else{
                    $message = 'Shift denied';
                }
                $title = $message;
            }

            $d = [
                'id' => $roster->event_id,
                'roster_id' => $roster->roster_id,
                'customer_name' =>  $roster->customer_name,
                'className' => $className. ' custom-roster-'.$roster->roster_id,
                'color' => $color,
                'eventBorderColor' => $eventBorderColor,
                'title' => $title,
                'current_time' => $current_time,
                'training' =>  $roster->training,
                'start_time' =>  $roster->temp_start,
                'site_name' =>  $roster->site_name,
                'site_description' =>  $roster->site_description,
                'site_address' =>  $roster->site_address,
                'tooltip' =>  ($roster->operators_notes == null) ? '' : $roster->operators_notes,
                'description' =>  ($roster->operators_notes == null) ? '' : $roster->operators_notes,
                'job_start' =>  date('Y-m-d H:i:s', strtotime($roster->temp_start)),
                'job_end' =>  date('Y-m-d H:i:s', strtotime($roster->temp_end)),
                'end_time' =>  $roster->temp_end,
                'start' => ($same == true) ? $roster->temp_start : $roster->temp_start,
                'end' => ($same == true) ? $roster->temp_end : $roster->temp_end,
                'guardId' => $roster->guard_id,
                'guard_phone' => ($roster->guard_id > 0) ? $roster->phone : '',
                'missed' => $missed,
                'site_id' => $roster->site_id,
                'location' => 'N/A',
                'post_status' => $roster->post_status,
                'same' => $same,
                'day' => date('D', strtotime($roster->temp_start)),
                'moke_guard' => $roster->moke_guard

            ];
            $rosterD[$roster->site_id][] = $d;
        }
        $newRoster = array();
        $siteIds = array();
        foreach ($rosterD as $key => $value) {
            $newRoster[] = ['site'=> $value[0]['site_name'], 'site_id' => $value[0]['site_id'], 'data' => $value];
            $siteIds[] = $value[0]['site_id'];
        }
        $customerId =  $request->customerId;
        if($request->site == 'active'){
            $sites = DB::table('jobs')->whereIn('id', $siteIds)
            ->when($siteId, function ($query, $siteId) {
                return $query->where('id', $siteId);
            })
                ->where(function($que) use ($customerId){
                    foreach ($customerId as $key => $cId) {
                        $que->orWhere('customer_id', $cId);
                    }  
                  })->where(function($que) use ($rosterD){
                    foreach ($rosterD as $key => $vl) {
                      $que->where('id', '!=', $vl[0]['site_id']);
                  }  
              })
            ->select('jobs.id as site_id', 'site_name as name')->get();
        }else if($request->site == 'inactive'){
            $sites = DB::table('jobs')
                ->when($siteId, function ($query, $siteId) {
                    return $query->where('id', $siteId);
                })
                ->where(function($que) use ($customerId){
                    foreach ($customerId as $key => $cId) {
                        $que->orWhere('customer_id', $cId);
                    }  
                  })->where(function($que) use ($rosterD){
                    foreach ($rosterD as $key => $vl) {
                      $que->where('id', '!=', $vl[0]['site_id']);
                  }  
              })
              ->whereNotIn('id', $siteIds)
            ->select('jobs.id as site_id', 'site_name as name')->get();
            $newRoster = array();
        }else if($request->site == 'all'){
            $sites = DB::table('jobs')
                ->when($siteId, function ($query, $siteId) {
                    return $query->whereIn('id', $siteId);
                })
                ->where(function($que) use ($customerId){
                    foreach ($customerId as $key => $cId) {
                        $que->orWhere('customer_id', $cId);
                    }  
                  })->where(function($que) use ($rosterD){
                    foreach ($rosterD as $key => $vl) {
                      $que->where('id', '!=', $vl[0]['site_id']);
                  }  
              })
            ->select('jobs.id as site_id', 'site_name as name')->get();
            
        }
      foreach ($sites as $s) {
        $newRoster[] = ['site'=> $s->name, 'site_id' => $s->site_id, 'data' => []];
    }
    return response()->json(['data' => $newRoster, 'status' => 'OK', 'code' => 200]);
            // return $newRoster;
            // return new JobRosterCollection(JobRosterResource::collection($rosterData));
}else{
    $newRoster = array();
    $customerId =  $request->customerId; 
    $sites = DB::table('jobs')
    ->when($siteId, function ($query, $siteId) {
                    return $query->whereIn('id', $siteId);
                })
    ->where(function($que) use ($customerId){
        foreach ($customerId as $key => $cId) {
          $que->orWhere('customer_id', $cId);
      }  
  })->select('jobs.id as site_id', 'site_name as name')->get();
    foreach ($sites as $s) {
        $newRoster[] = ['site'=> $s->name, 'site_id' => $s->site_id, 'data' => []];
    }
    return response()->json(['data' => $newRoster, 'status' => 'OK', 'code' => 200]);
}
$this->response = ['status' => false, 'error' => 'No roster Found!'];
$this->statusCode = self::STATUS_CODE_200;
return $this->sendResponse();

}

public function getCalenderData($customerId, $start = null, $end = null, $search_value = null, $admin_id = 0){
    $specific_customer  = array();
    $specific_sites  = array();
    if ($admin_id > 0) {
        $admin = $this->adminSpecificPermissions($admin_id);
        $specific_customers = $admin->specific_customer;
        $specific_sites = $admin->specific_sites;
    }

    // $data = job_new_roster::where(['add_status' => 1, 'site_id' => $jobId])->get();
    $query = job_new_roster::join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
    ->join('customers', 'customers.id', '=', 'jobs.customer_id')
    ->leftJoin('guards', 'guards.id', '=', 'job_new_roster.guard_id')
    // ->leftJoin('job_roster_activities', 'job_roster_activities.job_roster_id', '=', 'job_new_roster.roster_id')
    // ->leftJoin('guards as rejected_guard', 'rejected_guard.id', '=', 'job_new_roster.rejected_by')
    ->where(['job_new_roster.add_status' => 1]);
    if (!empty($customerId)) {
        $query->where(function($query1)  use ($customerId){
           foreach ($customerId as $key => $cid) {
              if ($key == 0) {
                 $query1->where('jobs.customer_id', $cid );
             }else{
                 $query1->orWhere('jobs.customer_id', $cid );
             }
         }
     });
    }elseif (is_array($specific_customers) && !empty($specific_customers)) {
        $query->where(function($q) use ($specific_customers){
            foreach ($specific_customers as $key => $id) {
                if ($key == 0) {
                    $q->where('jobs.customer_id', $id);
                }else{
                    $q->orWhere('jobs.customer_id', $id);
                }
            }
        });
    } 
    if (is_array($specific_sites) && !empty($specific_sites)) {
        $query->where(function($q) use ($specific_sites){
            foreach ($specific_sites as $key => $id) {
                if ($key == 0) {
                    $q->where('jobs.id', $id);
                }else{
                    $q->orWhere('jobs.id', $id);
                }
            }
        });
    }     
    $query->select('job_new_roster.*', 'jobs.site_name', 'jobs.site_description', 'jobs.address as site_address', 'customers.name as customer_name', 'guards.id as guard_id', 'guards.phone', 'guards.name');
    // $query->select('job_new_roster.*', 'jobs.site_name', 'jobs.site_description', 'jobs.address as site_address', 'customers.name as customer_name', 'guards.id as guard_id', 'guards.phone', 'guards.name', 'job_roster_activities.id as activity_id', 'job_roster_activities.status as activity_status', 'rejected_guard.name as rejected_by_name');
    if ($start != null) {
        $start = explode('T', $start);
        $start = $start[0];
        $query->where('job_new_roster.temp_start', '>=', $start);
    }
    if ($end != null) {
        $end = explode('T', $end);
        $end = $end[0];
        $end = strtotime($end) + 60*60*24;
        $end = date('Y-m-d', $end);
        $query->where('job_new_roster.temp_start', '<=', $end);
    }
    if ($search_value != null && $search_value != '') {
        // $search_value = explode(',', $search_value);
        $query->where(function ($query1) use ($search_value){
            $i = 0;
            foreach ($search_value as $key => $index) {
                if ($i == 0) {
                    $query1->where('job_new_roster.site_id', $index);
                }else{
                    $query1->orWhere('job_new_roster.site_id', $index);
                }
                $i++;
            }
        });

    }
    $query->orderBy('job_start', 'DESC');
    $data = $query->get();
    return $data;

}
}
