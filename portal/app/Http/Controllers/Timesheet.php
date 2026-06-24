<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Timesheets as timesheets;


class Timesheet extends Controller
{
    //
    //public $currentUser;
    public $timesheet_model;
    public function __construct(Request $request, timesheets $timesheet_model) {
        $this->timesheet_model = $timesheet_model;
    }

     public function timesheet()
    {
        // $this->middleware('auth');
        // $user = Auth::user();
        // json_encode($user);
        // exit();
        if (!session()->has('userType')) {
            return view('admin/login');
        }else{
          

$customers = DB::table('customers')->where('status','!=','deleted')->select('name','id')->orderBy('name','ASC')->get();
$states = DB::table('jobs')->select('state')->groupBy('state')->get();
$address = DB::table('jobs')->select('address')->groupBy('address')->get();


$guards = DB::table('job_new_roster')
->join('guards', 'job_new_roster.guard_id', '=', 'guards.id')->select('guards.guard_type','guards.name','guards.id')->groupBy('guards.id')->orderBy('guards.name','ASC')->get();


            return view('/admin/timesheet',['customers'=> $customers,'states'=> $states,'address'=> $address,'guards'=> $guards]);
        }
    }
     
    public function timesheet2()
    {
        // $this->middleware('auth');
        // $user = Auth::user();
        // json_encode($user);
        // exit();
        if (!session()->has('userType')) {
            return view('admin/login');
        }else{
          

$customers = DB::table('customers')->where('status','!=','deleted')->select('name','id')->orderBy('name','ASC')->get();
$states = DB::table('jobs')->select('state')->groupBy('state')->get();
$address = DB::table('jobs')->select('address')->groupBy('address')->get();


$guards = DB::table('guards')->select('guard_type','name','id')->orderBy('name','ASC')->get();


            return view('admin/timesheet/timesheet'
            ,['customers'=> $customers,'states'=> $states,'address'=> $address,'guards'=> $guards]);
        }
    }
    public function timesheet_search(Request $request)
    {
        $customer_id=$request->customer_name;
        $state=$request->state;
        $status=$request->status;
        $address=$request->address;
        $date=$request->from_to;
        $guard_id=$request->guard_name;
        $guard_type=$request->guard_type;

 
       $results = $this->timesheet_model->get_search_record();
            // skip(0)->take(10)->get

            if ($customer_id != null) {
                $results->where(function($query) use ($customer_id)  {
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
           });
                  }
                     if ($state != null ) {
                $results->where(function($query) use ($state)  {
                    $count=1;
               foreach($state as $cc_id)
   {
               if($count==1){
               $query->where('jobs.state',$cc_id);
               }else{
               $query->orWhere('jobs.state',$cc_id);
                }
           $count++;

   }
           });
                  }
                        if ($address != null ) {
                            $results->where(function($query) use ($address)  {
                                $count=1;
                           foreach($address as $cc_id)
               {
                           if($count==1){
                           $query->where('jobs.address',$cc_id);
                           }else{
                           $query->orWhere('jobs.address',$cc_id);
                            }
                       $count++;

               }
                       });
                  }

                         if ($status != "all" ) {
                            if($status=="completed"){
                                  $results->where('job_new_roster.job_status',"completed");

                            }else{
                                 $results->where('job_new_roster.job_status',$status);

                            }
                  }
                        if ($guard_id != null ) {
                                        
                                                    $results->where(function($query) use ($guard_id)  {
                                                             $count=1;
                                                        foreach($guard_id as $cc_id)
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

                        if ($date != null ) {

                        $from_to = explode("-", $date);
                        $from= $from_to[0];
                            $to= $from_to[1];
                            $timestamp = strtotime($from);
                            $timestamp_to = strtotime($to);
                            
                            $from = date("Y-m-d", $timestamp);
                            $to = date("Y-m-d", $timestamp_to);
                            // return $from;
                            // exit();
                            $results->whereBetween('job_new_roster.temp_date', [$from, $to]);
                                // print_r($results);
                                // exit();
                                    
                                            }

                                            if ($guard_type != null ) {
                                                $results->where('guards.guard_type',$guard_type);
                                                 }

                                                 $data= $results->paginate(50);

                                                 foreach($data as $result)
                                                 {
                                     
                                                         $hours = $this->getTimeDiff($result->temp_start, $result->temp_end);
                                                        //  $result->hours=$hours['hours'] + $result->travel_time;
                                                        //  $result->temp_start=Date("H:i:s",strtotime($result->temp_start));
                                                        //  $result->temp_date=Date("d/m/Y",strtotime($result->temp_date));
                                                        //  $result->temp_end=Date("H:i:s",strtotime($result->temp_end));
                                                        //  if ($result->continuation == 0) {
                                                        //     if ($result->hours < 4) {
                                                        //         $result->hours = 4;
                                                        //     }
                                                        // }
                                                        // $result->hours=sprintf("%02d", $result->hours);
                                                        $result->temp_start=Date("H:i:s",strtotime($result->temp_start));
                                                        $result->temp_end=Date("H:i:s",strtotime($result->temp_end));
                                                        if($hours['hours']==0){
                                                            $temp=$hours['minutes'];
                                                            $hours['hours']=round($temp/60);
                                                            $result->hours=$hours['hours'] + $result->travel_time;
                                                         }else{
                                                            $result->hours=$hours['hours'] + $result->travel_time + ($hours['minutes']/60);
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
                                                        if ($result->continuation == 0) {
                                                            if ($result->hours < 4) {
                                                                $result->hours = 4;
                                                            }
                                                        }
                                                         
                                     
                                                 }

            return ['results'=> $data];
            //'customer_firstname'=> $customers_firstname,'customer_firstname_id'=> $customer_id,'state_name'=> $state,'address_name'=> $request->address,'guard_firstname'=> $guard_id

    }


public function timesheet_record()

{
    
 $results= $this->timesheet_model->get_records();
             foreach($results as $result)
            {

                    $hours = $this->getTimeDiff($result->temp_start, $result->temp_end);
                    // $result->hours=$hours['hours'] + $result->travel_time;
                    $result->temp_start=Date("H:i:s",strtotime($result->temp_start));
                    $result->temp_end=Date("H:i:s",strtotime($result->temp_end));
                    if($hours['hours']==0){
                        $temp=$hours['minutes'];
                        $hours['hours']=round($temp/60);
                        $result->hours=$hours['hours'] + $result->travel_time;
                     }else{
                        $result->hours=$hours['hours'] + $result->travel_time + ($hours['minutes']/60);
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
                    if ($result->continuation == 0) {
                        if ($result->hours < 4) {
                            $result->hours = 4;
                        }
                    }
                    // $result->hours=sprintf("%02d", $result->hours);
            }
         
            return ['results'=> $results];
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
