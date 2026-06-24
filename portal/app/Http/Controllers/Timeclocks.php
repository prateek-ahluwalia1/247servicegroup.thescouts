<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Timesheets as timesheets;


class Timeclocks extends Controller
{
    //
    //public $currentUser;
    public $timesheet_model;
    public function __construct(Request $request, timesheets $timesheet_model) {
        $this->timesheet_model = $timesheet_model;
    }

    
    
    public function timeclock()
    {
        // $this->middleware('auth');
        // $user = Auth::user();
        // json_encode($user);
        // exit();
        if (!session()->has('userType')) {
            return view('admin/login');
        }else{


            $customers = DB::table('customers')->select('name','id')->orderBy('name','ASC')->get();
            $states = DB::table('jobs')->select('state')->groupBy('state')->get();
            $address = DB::table('jobs')->select('address')->groupBy('address')->get();


            $guards = DB::table('guards')->select('guard_type','name','id')->orderBy('name','ASC')->get();


            return view('admin/timeclock/timeclock'
                ,['customers'=> $customers,'states'=> $states,'address'=> $address,'guards'=> $guards]);
        }
    }
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
    public function get_record($request)
    {
        config(['app.timezone' => 'Australia/Melbourne']);
        date_default_timezone_set('Australia/Melbourne');
        $specific_customers  = array();
        $specific_sites1  = array();
        if ($request->has('admin_id') & $request->admin_id > 0) {
            $admin = $this->adminSpecificPermissions($request->admin_id);
            $specific_customers = $admin->specific_customer;
            $specific_sites1 = $admin->specific_sites;
        }
        $temp1 = DB::table('job_new_roster')
        ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
        ->leftJoin('job_breaks', 'job_new_roster.roster_id', '=', 'job_breaks.roster_id')
        ->leftJoin('guards', 'job_new_roster.guard_id', '=', 'guards.id')
        ->leftJoin('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')
        ->leftJoin('customers', 'jobs.customer_id', '=', 'customers.id')
        ->leftJoin('contractors', 'jobs.contractor_id', '=', 'contractors.id')
        ->leftJoin('administrators', 'job_new_roster.status_change_by', '=', 'administrators.id')
        ->select('job_new_roster.*', 'jobs.id AS job_id', 'jobs.booking_id',
            'job_breaks.break_start_time',
            'job_breaks.break_end_time',
            'jobs.customer_id',
            'jobs.contractor_id',
            'jobs.state',
            'jobs.stateType',
            'jobs.address',
            'jobs.site_description',
            'jobs.site_name',
            'jobs.details',
            'jobs.level',
            'customers.name AS customer_name' ,
            'contractors.name  AS contractor_name',
            'guards.guard_type',
            'guards.phone',
            'guards.name  AS guard_name',
            'guards.phone  AS guard_phone',
            'guards.id  AS guard_ID',
            'customers.flat_metro_week_day',
            'job_roster_activities.signin_time AS signin_time',
            'job_roster_activities.signout_time AS signout_time',
            'job_roster_activities.signin_selfie',
            'job_roster_activities.signout_selfie',
            'job_roster_activities.signout_notes',
            'job_roster_activities.signin_notes',
            'job_roster_activities.location AS location',
            'jobs.break',
            'jobs.chargeable',
            'jobs.payable',
            'job_new_roster.job_status AS job_status',
            'administrators.name AS admin_name' 
        )
        ->whereDate('job_new_roster.temp_start',date('Y-m-d'))
        ->where('job_new_roster.job_status', '!=', 'completed')
        ->where('job_new_roster.temp_start', '<=' ,date('Y-m-d H:i:s'))
        ->where('job_new_roster.temp_end', '>=' ,date('Y-m-d H:i:s'))
        ->orderBy('job_new_roster.temp_start','DESC');
        if (session()->has('isAdmin') && session()->get('isAdmin') == 0) {
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
            if (session()->has('specific_customer') && session()->get('specific_customer') != '') {
                $specific_customer = json_decode(session()->get('specific_customer'));
                $temp1->where(function($query)  use($specific_customer){
                    foreach ($specific_customer as $key => $id) {
                        if ($key == 0) {
                            $query->where('jobs.customer_id', $id);
                        }else{
                            $query->orWhere('jobs.customer_id', $id);
                        }
                    }
                });
            }
        }
        if (is_array($specific_customers) && !empty($specific_customers)) {
                $temp1->where(function($q) use ($specific_customers){
                    foreach ($specific_customers as $key => $id) {
                        if ($key == 0) {
                            $q->where('jobs.customer_id', $id);
                        }else{
                            $q->orWhere('jobs.customer_id', $id);
                        }
                    }
                });
            } 
    if (is_array($specific_sites1) && !empty($specific_sites1)) {
                $temp1->where(function($q) use ($specific_sites1){
                    foreach ($specific_sites1 as $key => $id) {
                        if ($key == 0) {
                            $q->where('jobs.id', $id);
                        }else{
                            $q->orWhere('jobs.id', $id);
                        }
                    }
                });
            } 
        $results = $temp1->get();
        return $results;
    }
    function timeclock_record_api(Request $request)
    {
      return $this->today($request, 'api');
  }
  public function today(Request $request, $call_from = null)
  {
    config(['app.timezone' => 'Australia/Melbourne']);
    date_default_timezone_set('Australia/Melbourne');
    $results=$this->get_record($request);
        // exit();
    $locations=[];
    $map_images=[];
    foreach($results as $result){
        $job_end_time = strtotime($result->temp_end);
        $job_start_time = strtotime($result->temp_start);
        $result->break_start_time=($result->break_start_time!=null) ? date("H:i",$result->break_start_time) : "N/A";
        $result->break_end_time=($result->break_end_time!=null) ? date("H:i",$result->break_end_time) : "N/A";
        if ($call_from == 'api') {
            if ($result->signin_selfie != null) {
                $result->signin_selfie = 'https://'.request()->getHttpHost().'/asset_uploads/'.$result->signin_selfie;
            }
            if ($result->signout_selfie != null) {
                $result->signout_selfie = 'https://'.request()->getHttpHost().'/asset_uploads/'.$result->signout_selfie;
            }
        }
        $green_call=DB::table('green_call')->where('job_id',$result->roster_id)->get();
        $result->before_time_30="no";
        $result->before_time_120="no";
        $result->green_call_30="N/A";
        $result->green_call_120="N/A";
        if(!empty($green_call)){
            foreach($green_call as $call){
                if($call->before_time=='30'){
                    $result->before_time_30="yes";
                    $result->green_call_30 = date('d/m/Y H:i', strtotime($call->created_at)) ;
                }else{
                    $result->before_time_120="yes";
                    $result->green_call_120 = date('d/m/Y H:i', strtotime($call->created_at));   
                }
            }
        }
        if($result->location!=null){
            $result->location=explode(",",$result->location);
            $lat = (double)$result->location[0];
            $lng =(double)$result->location[1];
            array_push($locations,['lat'=>$lat,'lng'=>$lng]);
        }
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
                if ($result->signin_time != '') {
                    $result->signin_time_2 = date('d/m/Y H:i', strtotime($result->signin_time));
                }else{
                    $result->signin_time_2 = $result->signin_time;
                }
            }
        }
        if(strpos($result->signout_time,'GMT')!==false){
            $result->signout_time_2= explode(" ",$result->signout_time);
            $result->signout_time_2=$result->signout_time_2[2].'-'. date('m',strtotime($result->signout_time_2[1])).'-'.$result->signout_time_2[3].' '.$result->signout_time_2[4];
        }
        else{
            if(strpos($result->signout_time,'M')!==false||strpos($result->signout_time,'T')!==false||strpos($result->signout_time,'W')!==false||strpos($result->signout_time,'F')!==false ||strpos($result->signout_time,'S')!==false)
            {
                $result->signout_time_2= explode(" ",$result->signout_time);
                $result->signout_time_2=$result->signout_time_2[2].'-'. date('m',strtotime($result->signout_time_2[1])).'-'.$result->signout_time_2[3].' '.$result->signout_time_2[4];
            }
            else{
                if ($result->signout_time != '') {
                    $result->signout_time_2 = date('d/m/Y H:i', strtotime($result->signout_time));
                }else{
                    $result->signout_time_2 = $result->signout_time;
                }
            }
        }
        if ($result->signout_time_2 == '') {
                            // $result->signout_time_2 = date('d/m/Y H:i', strtotime($result->signout_time_2));
            $result->signout_time_2 = 'N/A';
        }
        $result->color='';
        if($result->job_status=='confirmed' || $result->job_status=='pending'){
            if(($result->signin_time=='' || $result->signin_time==null || $result->signin_time=='null') &&($result->signin_time=='' || $result->signin_time==null || $result->signin_time=='null') ){
                $result->color="red";
            }
            elseif($result->signout_time=='' || $result->signout_time==null || $result->signout_time=='null'){
                $result->color="blue";
            }
            elseif($result->signin_time=='' || $result->signin_time==null || $result->signin_time=='null'){
                $result->color="red";
            }
        }
        elseif($result->job_status=='completed'){
            $result->color="green";
        }
        if ($result->signout_time_2 != null && $result->signout_time_2 != 'N/A' && $result->signout_time_2 != '') {
         $signout = strtotime($result->signout_time);
         $result->signout_diff = round(abs($signout - $job_end_time) / 60,2);
     }else{
         $result->signout_diff = 0;
    }

     if ($result->signin_time_2 != null || $result->signin_time_2 != 'N/A') {
         $signin_time = strtotime($result->signin_time);
     }else{
         $signin_time = $job_start_time;
     }
     $result->signin_diff = round(($signin_time - $job_start_time) / 60,2);

        $result->temp_start = date('H:i', strtotime($result->temp_start));
        $result->temp_end = date('H:i', strtotime($result->temp_end));
        if ($result->hours == null || $result->hours == '') {
            $result->hours = round(abs($result->job_end - $result->job_start) / 3600,2);
        }

 }
 if ($call_from == 'api') {
  if (count($results) > 0) {
    return response()->json(['status' => true, 'message' => 'Data found', 'data' => $results]);
}else{
    return response()->json(['status' => false, 'message' => 'No data found!']);
}
}else{

    return ['data' => $results,'locations' => $locations, 'date' => date('Y-m-d H:i:s')];  
}      
}
public function timesheet(Request $request)
{
    $results= DB::table('job_new_roster')
    ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
    ->leftJoin('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')
    ->leftJoin('guards', 'job_new_roster.guard_id', '=', 'guards.id')
    ->join('customers', 'jobs.customer_id', '=', 'customers.id')
    ->leftJoin('contractors', 'jobs.contractor_id', '=', 'contractors.id')
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
     'guards.email  AS guard_email' ,
     'guards.phone  AS guard_phone' ,
     'customers.flat_metro_week_day',
     'job_roster_activities.signin_time',
     'job_roster_activities.signin_selfie',
     'job_roster_activities.signout_selfie',
     'job_roster_activities.signout_notes',
     'job_roster_activities.signin_notes',
     'job_roster_activities.signout_time'
 )->where('job_new_roster.job_status' ,'completed')->orderBy('job_new_roster.roster_id', 'desc')->take(10)->get();

    foreach($results as $result)
    {
        $hours = $this->getTimeDiff($result->temp_start, $result->temp_end);
        $result->hours=$hours['hours'] + $result->travel_time;
        $result->temp_start=Date("H:i:s",strtotime($result->temp_start));
        $result->temp_end=Date("H:i:s",strtotime($result->temp_end));
        if ($result->continuation == 0) {
            if ($result->hours < 4) {
                $result->hours = 4;
            }
        }
    }
    return $results;
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

}
