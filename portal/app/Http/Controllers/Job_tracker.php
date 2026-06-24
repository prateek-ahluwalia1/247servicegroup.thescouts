<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Job_trackers as job_trackers;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use PDO;

class Job_tracker extends Controller
{
    //
    //public $currentUser;
  public $job_tracker_model;
  public function __construct(Request $request, job_trackers $job_tracker_model) {
    $this->job_tracker_model = $job_tracker_model;
    date_default_timezone_set('Australia/Melbourne');
  }

  public function job_tracker()
  {
        // $this->middleware('auth');
        // $user = Auth::user();
        // json_encode($user);
        // exit();

        // if (!session()->has('userType')) {
        //     return view('admin/login');
        // }else{
    

    if(session()->get('userType') == 'contractor'){
      $contractor_id = session()->get('userId');
      $guards = Guard::where('contractor_id', $contractor_id)->get();
      $guardsIds = Guard::where('contractor_id', $contractor_id)->pluck('id');
      $rosters = DB::table('job_new_roster')->whereIn('guard_id', $guardsIds)->groupBy('site_id')->pluck('site_id');
      $jobs = DB::table('jobs')->whereIn('id', $rosters)->groupBy('customer_id')->pluck('customer_id');
      $customers = DB::table('customers')->whereIn('id', $jobs)->where('status', 'active')->get();
    }else{
      $temp1 = DB::table('customers')->where('status','!=','deleted');
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
      $customers = $temp1->select('name','id')->where('status','=','active')->orderBy('name','ASC')->get();
    }
    $data=$this->get_tracker_data();
    if(session()->get('userType') == 'contractor'){
      $guards = $guards;
    }else{
      $guards= $data['guards'];
    }
    $states= $data['states'];
    $address = DB::table('jobs')->select('address')->groupBy('address')->get();

    return view('/admin/job_tracker/job_tracker',['customers'=> $customers,'states'=> $states,'address'=> $address,'guards'=> $guards]);
  }
    // }
  
  public function get_tracker_data()
  {
    $states = DB::table('jobs')->select('state')->groupBy('state')->get();
    $address = DB::table('jobs')->select('address')->groupBy('address')->get();
    $guards = DB::table('job_new_roster')
    ->join('guards', 'job_new_roster.guard_id', '=', 'guards.id')->select('guards.guard_type','guards.name','guards.id')->groupBy('guards.id')->orderBy('guards.name','ASC')->get();
    return ['states'=>$states,'guards'=>$guards];
  }
  public function timesheet_search(Request $request, $call_from = null)
  {
    
    $customer_id=$request->customer_name;
    $state=$request->State;
    $status=$request->status;
    $address=$request->address;
    $date = $request->from_to;
    $guard_id=$request->guard_name;
    $guard_type = $request->guard_type;
        // print_r($guard_type);
        // exit();
    
    $results =   $this->job_tracker_model->get_search_record();
            // skip(0)->take(10)->get
    if ($customer_id != null && $customer_id != '') {
      $results->where(function($query) use ($customer_id)  {
        $count=1;
        foreach($customer_id as $key => $c_id)
        {
         if($count==1){
           $query->where('jobs.customer_id',$c_id);
         }else{
           $query->orWhere('jobs.customer_id',$c_id);
         }
         $count++;

       }
     });
    }elseif (session()->has('specific_customer') && session()->get('specific_customer') != '') {
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
    if ($state != null  && $state != '') {
      $results->where(function($query) use ($state)  {
        $count=1;
        foreach($state as $key => $s)
        {
         if($count==1){
           $query->where('jobs.state',$s);
         }else{
           $query->orWhere('jobs.state',$s);
         }
         $count++;

       }
     });
    }
    if ($address != null  && $address != '') {
      $results->where(function($query) use ($address)  {
        $count=1;
        foreach($address as $key => $cc_id)
        {
         if($count==1){
           $query->where('jobs.id',$cc_id);
         }else{
           $query->orWhere('jobs.id',$cc_id);
         }
         $count++;

       }
     });
    }

                  //        if ($status != "all" ) {
                  //           if($status=="completed"){
                  //                 $results->where('job_new_roster.job_status',"completed");

                  //           }else{
                  //                $results->where('job_new_roster.job_status',$status);

                  //           }
                  // }
    if ($guard_id != null  && $guard_id != '') {
      
      $results->where(function($query) use ($guard_id)  {
       $count=1;
       foreach($guard_id as $key => $cc_id)
       {
        if($count==1){
          $query->where('job_new_roster.guard_id',$cc_id);
        }else{
          $query->orWhere('job_new_roster.guard_id',$cc_id);
        }
        $count++;

      }
    });
    }
    if (is_array($guard_type) && !empty($guard_type))  {
      $results->where(function($query) use ($guard_type)  {
       $count=1;
       foreach($guard_type as $key => $type)
       {
        if($count==1){
          $query->where('guards.guard_type',$type);
        }else{
          $query->orWhere('guards.guard_type',$type);
        }
        $count++;

      }
    });
    }elseif ($guard_type != null  && $guard_type != '') {
     $results->where('guards.guard_type',$guard_type);
   }

   if ($date != null ) {

    $from_to = explode("-", $date);
    $from= $from_to[0];
    $to= $from_to[1];
    $timestamp = strtotime($from);
    $timestamp_to = strtotime($to);
    $from = date("Y-m-d 00:00:00", $timestamp);
    $to = date("Y-m-d 23:59:59", $timestamp_to);
    $results->whereBetween('job_new_roster.temp_start', [$from, $to]);
    
  }
  $data = $this->job_tracker_model->jobs_status($status,$results);
  $data->groupBy('job_new_roster.roster_id');
  $data = $data->orderBy('job_new_roster.temp_start','ASC')->get();
                    // exit();

  if(!empty($data)){

    foreach($data as $result)
    {
      if ($result->guard_id == 0 || $result->guard_id == null) {
    $result->guard_name = $result->moke_guard;
  }
      if ($result->break == 1) {
      if ($result->break_payable == 'no') {
        $result->payable_and_chargeable_time = $result->payable_and_chargeable_time / 60;
      }else{
        $result->payable_and_chargeable_time = 0;
      }
    }else{
    $result->payable_and_chargeable_time = 0;
    $result->chargeable = '-';
    $result->payable = '-';
    }
      $job_end_time = strtotime($result->temp_end);
      $job_start_time = strtotime($result->temp_start);
      if(strpos($result->signin_time,'GMT')!==false){
        $result->signin_time_2= explode(" ",$result->signin_time);
        $result->signin_time_2=$result->signin_time_2[3].'-'. date('m',strtotime($result->signin_time_2[1])).'-'.$result->signin_time_2[2].' '.$result->signin_time_2[4];
      }
      else{
        if(strpos($result->signin_time,'M')!==false||strpos($result->signin_time,'T')!==false||strpos($result->signin_time,'W')!==false||strpos($result->signin_time,'F')!==false ||strpos($result->signin_time,'S')!==false)
        {
          $result->signin_time = str_replace('T', ' ', $result->signin_time);
          $result->signin_time = str_replace('+', ' ', $result->signin_time);
          $result->signin_time_2= explode(" ",$result->signin_time);
          if (count($result->signin_time_2) > 3) {
        $result->signin_time_2=$result->signin_time_2[3].'-'. date('m',strtotime($result->signin_time_2[1])).'-'.$result->signin_time_2[2].' '.$result->signin_time_2[4];
        }else{

          // $result->signin_time_2 = str_replace('T', ' ', $result->signin_time);
          // $result->signin_time_2 = str_replace('+', ' ', $result->signin_time);
          // $result->signin_time_2 = explode(" ",$result->signin_time_2);
          if (count($result->signin_time_2) > 2) {
            $result->signin_time_2 = $result->signin_time_2[0].' '.$result->signin_time_2[1];
          }else{
            $result->signin_time_2 = $result->signin_time_2[0].' '.$result->signin_time_2[1];
          }
          
        // $result->signin_time_2 = $result->signin_time_2[0].' '.$result->signin_time_2[1];

        }
          // $result->signin_time_2=$result->signin_time_2[3].'-'. date('m',strtotime($result->signin_time_2[1])).'-'.$result->signin_time_2[2].' '.$result->signin_time_2[4];
        }
        else{
          $result->signin_time_2=$result->signin_time;
        }
      }
      if(strpos($result->signout_time,'GMT')!==false){
        $result->signout_time_2= explode(" ",$result->signout_time);
        $result->signout_time_2=$result->signout_time_2[3].'-'. date('m',strtotime($result->signout_time_2[1])).'-'.$result->signout_time_2[2].' '.$result->signout_time_2[4];
      }
      else{
        if(strpos($result->signout_time,'M')!==false||strpos($result->signout_time,'T')!==false||strpos($result->signout_time,'W')!==false||strpos($result->signout_time,'F')!==false ||strpos($result->signout_time,'S')!==false)
        {
          $result->signout_time = str_replace('T', ' ', $result->signout_time);
          $result->signout_time = str_replace('+', ' ', $result->signout_time);
          $result->signout_time_2= explode(" ",$result->signout_time);
          if (count($result->signout_time_2) > 3) {
            $result->signout_time_2=$result->signout_time_2[3].'-'. date('m',strtotime($result->signout_time_2[1])).'-'.$result->signout_time_2[2].' '.$result->signout_time_2[4];
          }else{
            // $result->signout_time_2 = $result->signout_time;
          $result->signout_time_2 = $result->signout_time_2[0].' '.$result->signout_time_2[1];
          }
        }
        else{
          $result->signout_time_2 = $result->signout_time;
        }
      }
      
      // if($result->signout_time_2!=null && $result->signin_time_2!=null ){
      // $hours = $this->getTimeDiff($result->temp_start, $result->temp_end);
      $timestamp_start = Carbon::parse($result->temp_start);
      $timestamp_start_dst = Carbon::parse($result->temp_start)->isDST();
      $timestamp_end = Carbon::parse($result->temp_end);
      $timestamp_end_dst = Carbon::parse($result->temp_end)->isDST();
      if ($timestamp_start_dst && !$timestamp_end_dst) {
        // DST is active at the start but not at the end
        $hours['hours'] = $timestamp_start->floatDiffInHours($timestamp_end) - 1;
      } elseif (!$timestamp_start_dst && $timestamp_end_dst) {
        // DST is active at the end but not at the start
        $hours['hours'] = $timestamp_start->floatDiffInHours($timestamp_end) + 1;
      } else {
        // DST status is the same at both start and end timestamps
        $hours['hours'] = $timestamp_start->floatDiffInHours($timestamp_end);
      }
    //   if ($hours['days'] > 0) {
    //     $hours['hours'] = $hours['hours'] + ($hours['days'] * 24);
    //   }
    //   if ($hours['hours'] > $result->hours) {
    //     $hours['hours'] = $result->hours;
    //   }
    //   if ($hours['hours'] < $result->hours) {
    //     $hours['hours'] = $result->hours;
    //   }
      $result->hours_data = $hours;
      $result->total_hours = $hours['hours'];

      if($hours['hours']==0){
        $temp=$hours['minutes'];
        $hours['hours'] = round($temp/60);
        $result->hours = $hours['hours'];
      }else{
        // $result->hours = $hours['hours'] + ($hours['minutes']/60);
        $result->hours = $hours['hours'];
        $total_hours = explode('.', $result->hours);
        if (sizeof($total_hours) > 1 ) {
          $partial = '.'.$total_hours[1];
          if ($partial < 0.1) {
           $result->hours = $total_hours[0];
         }
         if ($partial < 0.27 && $partial > 0.1) {
           $result->hours = $total_hours[0].'.25';
         }
         if ($partial > 0.27 && $partial <= 0.52) {
           $result->hours = $total_hours[0].'.5';
         }
         if ($partial > 0.52 && $partial <= 0.77) {
           $result->hours = $total_hours[0].'.75';
         }
         if ($partial > 0.77 && $partial < 1) {
           $result->hours = $total_hours[0]+ 1;
         }
       }
     }
     $result->total_hours = $result->hours;

            // }else{
                // $hours['hours']=0;
            // }  
                        // $result->hours=$total_hours;
                    // $result->hours = round($result->hours);
                          // $result->hours=$hours['hours'];
     $result->temp_date=Date("d/m/Y",strtotime($result->temp_date));
     $result->temp_start=Date("H:i",strtotime($result->temp_start));
     $result->temp_end=Date("H:i",strtotime($result->temp_end));
     if ($result->continuation == 0) {
      if ($result->hours < 4 && $result->hours > 0) {
        $result->hours = 4;
      }
    }
    $result->hours = $result->hours + $result->travel_time;
    $result->hours = $result->hours - $result->payable_and_chargeable_time;
    $check_in = strtotime($result->temp_start);

    $check_in_2 = strtotime($result->signin_time_2);
    if($check_in > $check_in_2){
      $result->check_in_status=true;
    }else{
      $result->check_in_status=false;
    }
    if($result->signin_time==''|| $result->signin_time==null){
      $result->check_in_status=false;
    }
    $check_out = strtotime($result->temp_end);
    $check_out_2 = strtotime($result->signin_time_2);
    if($check_in > $check_in_2){
      $result->check_out_status=true;
    }else{
      $result->check_out_status=false;
    }
    
    if($result->signout_time==''|| $result->signout_time==null){
      $result->check_out_status=false;
    }
    if ($result->signout_time_2 != null || $result->signout_time_2 != '') {
   $signout = strtotime($result->signout_time_2);
 }else{
   $signout = $job_end_time;
 }
  $result->signout_diff = round(abs($signout - $job_end_time) / 60,2);

  if ($result->signin_time_2 != null || $result->signin_time_2 != '') {
   $signin_time = strtotime($result->signin_time_2);
 }else{
   $signin_time = $job_start_time;
 }
  $result->signin_diff = round(($signin_time - $job_start_time) / 60,2);
  }
}

if ($call_from == 'api') {
  if (count($data) > 0) {
    return response()->json(['status' => true, 'message' => 'Data found', 'data' => $data]);
  }else{
    return response()->json(['status' => false, 'message' => 'No data found!']);
  }
}else{

return ['results'=> $data,'parameter_status'=>$status ];
}
            //'customer_firstname'=> $customers_firstname,'customer_firstname_id'=> $customer_id,'state_name'=> $state,'address_name'=> $request->address,'guard_firstname'=> $guard_id

}

    // public function return_month($M){
	// 	 $months = ["Jan"=>01,
    //       "Feb"=>02,
    //        "Mar"=>03, 
    //        "Apr"=>04, 
    //        "May"=>05, 
    //        "Jun"=>06,
    //        "July"=>07,
    //         "Aug"=>08,
    //        "Sep"=>09,
    //        "Oct"=>10,
    //        "Nov"=>11,"
    //        Dec"=>12];
	// 	if($M=="Jan"){
	// 		return $months.Jan;
	// 	}
	// 	if($M=="Feb"){
	// 		return $months.Feb;
	// 	}
	// 	if($M=="Mar"){
	// 		return $months.Mar;
	// 	}
	// 	if($M=="Apr"){
	// 		return $months.Apr;
	// 	}
	// 	if($M=="May"){
	// 		return $months.May;
	// 	}
	// 	if($M=="July"){
	// 		return $months.July;
	// 	}
	// 	if($M=="Aug"){
	// 		return $months.Aug;
	// 	}
	// 	if($M=="Sep"){
	// 		return $months.Sep;
	// 	}
	// 	if($M=="Oct"){
	// 		return $months.Oct;
	// 	}
	// 	if($M=="Nov"){
	// 		return $months.Nov;
	// 	}
	// 	if($M=="Dec"){
	// 		return $months.Dec;
	// 	}
	// }
function timesheet_record_api(Request $request)
{
  // return $this->timesheet_record($request, 'api');
  return $this->timesheet_search($request, 'api');
}
public function timesheet_record(Request $request, $call_from = null)

{  
 $results=   $this->job_tracker_model->get_records($request->status);
        // $date=$this->getTimeDiff("2021-03-23 23:01:11 ","Wed Mar 24 2021 01:57:10 GMT+1100 (Australian Eastern Daylight Time)");
        // return $date;
        // exit();
 foreach($results as $key => $result)
 {
  if ($result->guard_id == 0 || $result->guard_id == null) {
    $result->guard_name = $result->moke_guard;
  }
  $job_end_time = strtotime($result->temp_end);
  $job_start_time = strtotime($result->temp_start);
  $result->signout_time_2 = '';
  if($request->status == 'missed' && $result->signin_time == null){
                    // unset($results[$key]);
                  // $result->temp_date=Date("d/m/Y",strtotime($result->temp_date));
    $result->temp_start = Date("d/m/Y H:i",strtotime($result->temp_start));
    $result->temp_end = Date("d/m/Y H:i",strtotime($result->temp_end));
  }else{
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
    if(strpos($result->signout_time,'GMT')!==false){
      $result->signout_time_2= explode(" ",$result->signout_time);
      $result->signout_time_2=$result->signout_time_2[3].'-'. date('m',strtotime($result->signout_time_2[1])).'-'.$result->signout_time_2[2].' '.$result->signout_time_2[4];
    }
    else{
      if(strpos($result->signout_time,'M')!==false||strpos($result->signout_time,'T')!==false||strpos($result->signout_time,'W')!==false||strpos($result->signout_time,'F')!==false ||strpos($result->signout_time,'S')!==false)
      {
        $result->signout_time_2= explode(" ",$result->signout_time);
        $result->signout_time_2=$result->signout_time_2[3].'-'. date('m',strtotime($result->signout_time_2[1])).'-'.$result->signout_time_2[2].' '.$result->signout_time_2[4];
      }
      else{
        $result->signout_time_2=$result->signout_time;
      }
    }
    
    
    $hours = $this->getTimeDiff($result->temp_start, $result->temp_end);
    $result->hours_data = $hours;
    if($hours['hours']==0){
      $temp=$hours['minutes'];
      $hours['hours']=round($temp/60);
      $result->hours=$hours['hours'] + $result->travel_time;
    }else{
      // $result->hours=$hours['hours'] + $result->travel_time + ($hours['minutes']/60);
      $result->hours=$hours['hours'] + $result->travel_time;
      $total_hours = explode('.', $result->hours);
      if (sizeof($total_hours) > 1 ) {
        $partial = '.'.$total_hours[1];
        if ($partial < 0.1) {
         $result->hours = $total_hours[0];
       }
       if ($partial < 0.27 && $partial > 0.1) {
         $result->hours = $total_hours[0].'.25';
       }
       if ($partial > 0.27 && $partial < 0.52) {
         $result->hours = $total_hours[0].'.5';
       }
       if ($partial > 0.52 && $partial < 0.77) {
         $result->hours = $total_hours[0].'.75';
       }
       if ($partial > 0.77 && $partial < 1) {
         $result->hours = $total_hours[0]+ 1;
       }
     }
   }
   
   $result->temp_date=Date("d/m/Y",strtotime($result->temp_date));
   $result->temp_start=Date("H:i",strtotime($result->temp_start));
   $result->temp_end=Date("H:i",strtotime($result->temp_end));
   if ($result->continuation == 0) {
    if ($result->hours < 4 && $result->hours > 0) {
      $result->hours = 4;
    }
  }
  $check_in = strtotime($result->temp_start);
  $check_in_2 = strtotime($result->signin_time_2);
  if($check_in > $check_in_2){
    $result->check_in_status=true;
  }else{
    $result->check_in_status=false;
  }
  if($result->signin_time==''|| $result->signin_time==null){
    $result->check_in_status=false;
  }
  $check_out = strtotime($result->temp_end);
  $check_out_2 = strtotime($result->signin_time_2);
  if($check_in > $check_in_2){
    $result->check_out_status=true;
  }else{
    $result->check_out_status=false;
  }
  
  if($result->signout_time == ''|| $result->signout_time==null){
    $result->check_out_status=false;
  }
                    // $check_in = Carbon::createFromFormat('H:i',$result->signin_time_2)));
                    // $check_in2 = Carbon::createFromFormat('H:i',$result->temp_start));
                    // $check_in_status = $check_in2->gte($check_in);
                    // $check_out = Carbon::createFromFormat('H:i',$result->signout_time_2);
                    // $check_out_status = $check_out->gte($result->temp_end);
}
 if ($result->signout_time_2 != null || $result->signout_time_2 != '') {
   $signout = strtotime($result->signout_time_2);
 }else{
   $signout = $job_end_time;
 }
  $result->signout_diff = round(abs($signout - $job_end_time) / 60,2);
  
if (isset($result->signin_time_2) && ($result->signin_time_2 != null || $result->signin_time_2 != '')) {
   $signin_time = strtotime($result->signin_time_2);
 }else{
   $signin_time = $job_start_time;
 }
  $result->signin_diff = round(($signin_time - $job_start_time) / 60,2);
}
if ($call_from == 'api') {
  if (count($results) > 0) {
    return response()->json(['status' => true, 'message' => 'Data found', 'data' => $results]);
  }else{
    return response()->json(['status' => false, 'message' => 'No data found!']);
  }
}else{
return ['results'=> $results];
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
function tracker_approval_status(Request $request){
  if($request->check=="checked"){
    DB::table('job_new_roster')->where('roster_id',$request->id)->update([
            // 'job_status'=>'confirmed',
      'status_change_by' => session()->get('userId')
    ]);
    return "checked";
  }else{
    DB::table('job_new_roster')->where('roster_id',$request->id)->update([
            // 'job_status'=>'pending',
      'status_change_by' => null
    ]);
    return "unchecked";
  }
}

function update_signin(Request $request){
  $datetime=$request->datetime;
        // $gmt=gmdate("Y-m-d\TH:i:s\Z", $datetime);
  $check=DB::table('job_roster_activities')
  ->where('job_roster_id',$request->roster_id)->first();
  if(!empty($check)){
    $result=DB::table('job_roster_activities')
    ->where('job_roster_id',$request->roster_id)
    ->update([
      'signin_time'=>$datetime
      
    ]);
  }else{
    $result=DB::table('job_roster_activities')->insert([
      'guard_id'=>$request->guard_ID,
      'signin_time'=>$datetime,
      'job_roster_id'=>$request->roster_id
    ]);
  }
  return response()->json(array('success' => true));

}
function update_signout(Request $request){
  $datetime=$request->datetime;
        // $gmt=gmdate("Y-m-d\TH:i:s\Z", $datetime);

        // return $gmt;
  $check=DB::table('job_roster_activities')
  ->where('job_roster_id',$request->roster_id)->first();
  if(!empty($check)){
    $result=DB::table('job_roster_activities')
    ->where('job_roster_id',$request->roster_id)
    ->update([
      'signout_time'=>$datetime
      
    ]);
  }else{
    $result=DB::table('job_roster_activities')->insert([
      'guard_id'=>$request->guard_ID,
      'signout_time'=>$datetime,
      'job_roster_id'=>$request->roster_id
    ]);
  }
  return response()->json(array('success' => true));

}

function get_customers_jobs_list(Request $request)
{
  if($request->customer_id!=null){

    $customer_id=$request->customer_id;
    $inactive_jobs=[];
    $active_jobs=[];
    $inactive_temp=[];
    foreach($customer_id as $cid){
      $status = null;
      $specific_sites_id = array();
      $start = strtotime('monday this week');
      $end = strtotime('monday next week');
      // $active = DB::table('jobs')
      // ->join('job_new_roster', 'job_new_roster.site_id', '=', 'jobs.id')
      // ->where('jobs.customer_id', $cid)
      // ->where('jobs.status', 'active')
      //       // ->select('jobs.id AS job_id','jobs.site_name','jobs.site_description')
      // ->select('jobs.id AS job_id')
      // ->where('job_new_roster.temp_start','>=', date('Y-m-d H:i:s', $start))->groupBy('jobs.id')->get()->toArray();
      $active_temp = DB::table('jobs')
      ->join('job_new_roster', 'job_new_roster.site_id', '=', 'jobs.id')
      ->where('jobs.customer_id', $cid)
      ->where('jobs.status', 'active')
      ->select('jobs.id AS job_id','jobs.site_name','jobs.site_description')
      ->where('job_new_roster.temp_start','>=', date('Y-m-d H:i:s', $start))->groupBy('jobs.id')->get();
      $active_jobs = json_decode(json_encode($active_temp), true);
      
      $inactive= DB::table('jobs')
      ->where('jobs.customer_id', $cid)
      ->where('jobs.status', 'active')
      ->select('jobs.id AS job_id')
      ->get()->toArray();
      $active=Arr::pluck($active_jobs, 'job_id');
      $inactive=Arr::pluck($inactive, 'job_id');
      $inactive =array_diff((array)$inactive,(array)$active);
      foreach($inactive as $i){
        $temp= DB::table('jobs')
        ->where('jobs.id', $i)->select('jobs.id AS job_id','jobs.site_name','jobs.site_description')->get();
        array_push($inactive_temp,$temp);
      }
      // $active_jobs = array_merge($active_jobs,json_decode(json_encode($active_temp), true));
      
      $inactive_jobs= array_merge($inactive_jobs,json_decode(json_encode((object)$inactive_temp), true));
    }
    return response()->json(['active_jobs'=>(object)$active_jobs,'inactive_jobs'=>(object)$inactive_jobs]);
  }
}

function get_customers_jobs_list_filter(Request $request)
{
  (object)$customer_id=$request->customer_id;
  $start = ($request->has('start') && $request->start != '') ? $request->start : '';
  $end = ($request->has('end') && $request->end != '') ? $request->end : '';
  if(!empty($customer_id) && $request->state!=''){
    $jobs=[];
    foreach($customer_id as $cid){
      $status = null;
      $specific_sites_id = array();
                    // $start = strtotime('monday this week');
                    // $end = strtotime('monday next week');
      if($request->status == 'active' || $request->missing('status')){
      // if($request->status == 'active'){
        $temp1 = DB::table('jobs')
        ->join('job_new_roster', 'job_new_roster.site_id', '=', 'jobs.id')
        ->where('jobs.customer_id', $cid)
        ->where('jobs.state',$request->state)
        ->where('jobs.status', 'active');
        if ($start != '' && $end != '') {
          $temp1->whereBetween('job_new_roster.temp_date',[$start,$end]);
        }else{
          $temp1->whereBetween('job_new_roster.temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
        }
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
        $temp = $temp1->select('jobs.id AS job_id','jobs.site_name','jobs.site_description')
        ->groupBy('job_new_roster.site_id')
        ->orderBy('jobs.site_name','ASC')
        ->get();
        $jobs= array_merge($jobs,json_decode(json_encode($temp), true));
      }else{
        $temp_query = DB::table('jobs')
        ->where('customer_id', $cid)
        ->where('jobs.state',$request->state)
        ->where('status', 'active');
        if (session()->has('specific_sites') && session()->get('specific_sites') != '') {
                $specific_sites = json_decode(session()->get('specific_sites'));
                $temp_query->where(function($query)  use($specific_sites){
                    foreach ($specific_sites as $key => $id) {
                        if ($key == 0) {
                            $query->where('jobs.id', $id);
                        }else{
                            $query->orWhere('jobs.id', $id);
                        }
                    }
                });
            }
        $temp_query->select('id AS job_id' ,'jobs.site_name','jobs.site_description')
        ->orderBy('site_name','ASC');
        $inactive = $temp_query->get();
        if($request->status == 'inactive'){
          foreach($inactive as $key => $job){
                            // return ['key' => $inactive[$key], 'job' => $job];
                            // exit();
            $temp1 = DB::table('job_new_roster')->where('site_id',$job->job_id);
            if ($start != '' && $end != '') {
              $temp1->whereBetween('job_new_roster.temp_date',[$start,$end]);
            }else{
              $temp1->whereBetween('temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
            }

            $temp = $temp1->first();
            if(!empty($temp)){
             unset($inactive[$key]);
           }
         }
       }
       $jobs= array_merge($jobs,json_decode(json_encode($inactive), true));
     }
   }
   return response()->json(['jobs'=>$jobs]);
 }elseif($request->has('from')){

  $jobs = DB::table('jobs')
                  // ->where('jobs.customer_id', $cid)
  ->where(function($query) use ($customer_id)  {
    $count=1;
    foreach($customer_id as $cc_id)
    {
     if($count==1){
       $query->where('jobs.customer_id',$cc_id);
     }else{
       $query->orWhere('jobs.customer_id',$cc_id);
     }
     $count++;

   }
 })
  ->where('jobs.status', 'active')
  ->select('jobs.id AS job_id','jobs.site_name','jobs.site_description')
  ->orderBy('jobs.site_name','ASC')
  ->get();
  return response()->json(['jobs'=>$jobs]);
}
}

function get_customers_guards_list_filter(Request $request)
{
  if (session()->has('config_arr_job_roster')  && session()->get('config_arr_job_roster') != '' && isset(session()->get('config_arr_job_roster')[0]->add_guards)) {
            $allguard = (session()->get('config_arr_job_roster')[0]->add_guards);
        }

  (object)$customer_id=$request->customer_id;
                // return $customer_id;
                // exit();
   if (isset($allguard) && $allguard == 0) {
                    // dd(true);
    $new =  DB::table('guards')
                        ->where(['status' => 'active'])->select('guards.id AS guard_id','guards.name AS guard_name')->orderBy('guards.name', 'ASC')->get();
                }else{
  if(!empty($customer_id) && $request->state!=''){
    
    $guards=[];
    foreach($customer_id as $cid){
      $status = null;
      $specific_sites_id = array();
      
      $temp = DB::table('guards')
      ->join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')
      ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
      ->join('customers', 'customers.id', '=', 'jobs.customer_id')
      ->where('jobs.customer_id', $cid)
      ->where('guards.status','!=' ,'deleted')
      ->where('jobs.state',$request->state)
      ->where('guards.status', '!=', 'deleted');
      if($request->missing('status') || $request->status == 'active' ){
        // $temp->whereBetween('job_new_roster.temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
      }elseif($request->status == 'inactvie'){
        // $temp->whereNotBetween('job_new_roster.temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
      }
      $query= $temp->select('guards.id AS guard_id','guards.name AS guard_name')
      ->groupBy('job_new_roster.guard_id')
      ->orderBy('guards.name','ASC')
      ->get();
      $guards= array_merge($guards,json_decode(json_encode($query), true));
      
    }
    $new=[];
    $new = array_map("unserialize", array_unique(array_map("serialize", $guards)));
    }elseif(!empty($customer_id) && $request->state =='')
    {
      if(session()->get('userType') == 'contractor'){
        $guards=[];
      foreach($customer_id as $cid){
        $status = null;
        $specific_sites_id = array();
        
        $temp = DB::table('guards')
        ->join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')
        ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
        ->join('customers', 'customers.id', '=', 'jobs.customer_id')
        ->where('jobs.customer_id', $cid)
        ->where('guards.status','!=' ,'deleted')
        ->where('guards.contractor_id',session()->get('userId'))
        ->where('guards.status', '!=', 'deleted');
        if($request->missing('status') || $request->status == 'active' ){
          // $temp->whereBetween('job_new_roster.temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
        }elseif($request->status == 'inactvie'){
          // $temp->whereNotBetween('job_new_roster.temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
        }
        $query= $temp->select('guards.id AS guard_id','guards.name AS guard_name')
        ->groupBy('job_new_roster.guard_id')
        ->orderBy('guards.name','ASC')
        ->get();
        $guards= array_merge($guards,json_decode(json_encode($query), true));
        
      }
      $new=[];
      $new = array_map("unserialize", array_unique(array_map("serialize", $guards)));
      }else{
        $guards=[];
      foreach($customer_id as $cid){
        $status = null;
        $specific_sites_id = array();
        
        $temp = DB::table('guards')
        ->join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')
        ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
        ->join('customers', 'customers.id', '=', 'jobs.customer_id')
        ->where('jobs.customer_id', $cid)
        ->where('guards.status','!=' ,'deleted')
        // ->where('jobs.state',$request->state)
        ->where('guards.status', '!=', 'deleted');
        if($request->missing('status') || $request->status == 'active' ){
          // $temp->whereBetween('job_new_roster.temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
        }elseif($request->status == 'inactvie'){
          // $temp->whereNotBetween('job_new_roster.temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
        }
        $query= $temp->select('guards.id AS guard_id','guards.name AS guard_name')
        ->groupBy('job_new_roster.guard_id')
        ->orderBy('guards.name','ASC')
        ->get();
        $guards= array_merge($guards,json_decode(json_encode($query), true));
        
      }
      $new=[];
      $new = array_map("unserialize", array_unique(array_map("serialize", $guards)));

      }
  }elseif(empty($customer_id))
  {
    if(session()->get('userType') == 'contractor'){
      $guards=[];
        $status = null;
        $specific_sites_id = array();
        
        $temp = DB::table('guards')
        ->join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')
        ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
        ->join('customers', 'customers.id', '=', 'jobs.customer_id')
        // ->where('jobs.customer_id', $cid)
        ->where('guards.status','!=' ,'deleted')
        ->where('guards.contractor_id', session()->get('userId'))
        ->where('guards.status', '!=', 'deleted');
        if($request->missing('status') || $request->status == 'active' ){
          // $temp->whereBetween('job_new_roster.temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
        }elseif($request->status == 'inactvie'){
          // $temp->whereNotBetween('job_new_roster.temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
        }
        $query= $temp->select('guards.id AS guard_id','guards.name AS guard_name')
        ->groupBy('job_new_roster.guard_id')
        ->orderBy('guards.name','ASC')
        ->get();
        $guards= array_merge($guards,json_decode(json_encode($query), true));
      $new=[];
      $new = array_map("unserialize", array_unique(array_map("serialize", $guards)));
    }else{
      if(session()->get('userType') == 'contractor'){
        $guards=[];
          $status = null;
          $specific_sites_id = array();
          
          $temp = DB::table('guards')
          ->join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')
          ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
          ->join('customers', 'customers.id', '=', 'jobs.customer_id')
          // ->where('jobs.customer_id', $cid)
          ->where('guards.status','!=' ,'deleted')
          ->where('guards.contractor_id',session()->get('userId'))
          ->where('guards.status', '!=', 'deleted');
          if($request->missing('status') || $request->status == 'active' ){
            // $temp->whereBetween('job_new_roster.temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
          }elseif($request->status == 'inactvie'){
            // $temp->whereNotBetween('job_new_roster.temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
          }
          $query= $temp->select('guards.id AS guard_id','guards.name AS guard_name')
          ->groupBy('job_new_roster.guard_id')
          ->orderBy('guards.name','ASC')
          ->get();
          $guards= array_merge($guards,json_decode(json_encode($query), true));
        $new=[];
        $new = array_map("unserialize", array_unique(array_map("serialize", $guards)));
      }else{
        $guards=[];
          $status = null;
          $specific_sites_id = array();
          
          $temp = DB::table('guards')
          ->join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')
          ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
          ->join('customers', 'customers.id', '=', 'jobs.customer_id')
          // ->where('jobs.customer_id', $cid)
          ->where('guards.status','!=' ,'deleted')
          // ->where('jobs.state',$request->state)
          ->where('guards.status', '!=', 'deleted');
          if($request->missing('status') || $request->status == 'active' ){
            // $temp->whereBetween('job_new_roster.temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
          }elseif($request->status == 'inactvie'){
            // $temp->whereNotBetween('job_new_roster.temp_date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
          }
          $query= $temp->select('guards.id AS guard_id','guards.name AS guard_name')
          ->groupBy('job_new_roster.guard_id')
          ->orderBy('guards.name','ASC')
          ->get();
          $guards= array_merge($guards,json_decode(json_encode($query), true));
        $new=[];
        $new = array_map("unserialize", array_unique(array_map("serialize", $guards)));

      }

    }
  }
  }
            // array_unique($guards,SORT_REGULAR)
    
    return response()->json(['guards'=>$new]);
  
}


}
