<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Customer_report as customer_report;
use App\Models\Contractor_report as contractor_report;
// use App\Models\Complete_report as complete_report;
use App\Models\Green_report as green_report;
use App\Models\Guard_detail_report as guard_detail_report;
use App\Models\Task_report as task_report;
use App\Models\Report as report;
use Codedge\Fpdf\Fpdf\Fpdf;
use \PDF;
use Illuminate\Support\Facades\View;
use  Maatwebsite\Excel\Facades\Excel;
use  Maatwebsite\Excel\Concerns\FromCollection;
use  Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;
use App\Exports\CompleteReportExport;
use App\Exports\InvoiceReport;
use App\Exports\DivisionConsolidation;
use App\Exports\RosterReportExport;
use App\Exports\SignInOutExport;
use App\Exports\MultisheetExport;
use App\Exports\AwardExport;
use App\Jobs\Job;
use App\Models\Customer;
use App\Models\Guard;
use App\Models\JobNewRoster;

// use Maatwebsite\Excel\Facades\Excel;


class Reports extends Controller
{
    //
    //public $currentUser;
    public $customer_report;
    public $contractor_report;
    public $complete_report;
    public $task_report;
    public $green_report;
    public $report_model;

    public $guard_detail_report;

    public function __construct(Request $request, customer_report $customer_report_model, contractor_report $contractor_report_model, guard_detail_report $guard_detail_report_model, green_report $green_report_model,task_report $task_report_model, report $report_model) {
        $this->customer_report_model = $customer_report_model;
        $this->contractor_report_model = $contractor_report_model;
        $this->guard_detail_report_model = $guard_detail_report_model;
        $this->green_report_model = $green_report_model;
        $this->task_report_model = $task_report_model;
        $this->report_model = $report_model;

    }
  

    public function customer_report()
    {
        if (!session()->has('userType')) {
            return view('admin/login');
        }else{
            $customers = DB::table('customers')->where('status','!=','deleted')->select('name','id')->orderBy('name','ASC')->get();
            $states = DB::table('jobs')->select('state')->groupBy('state')->get();
            $address = DB::table('jobs')->select('address')->groupBy('address')->get();
            $guards = DB::table('guards')->select('guard_type','name','id')->where('status','!=','deleted')->orderBy('name','ASC')->get();
            return view('/admin/report/customer_report',['customers'=> $customers,'states'=> $states,'address'=> $address,'guards'=> $guards]);
        }
    }


    public function customer_report_search(Request $request)
    {
        $customer_id=$request->customer_name;
        $state=$request->state;
        $status=$request->status;
        $address=$request->address;
        $date=$request->from_to;
        $guard_id=$request->guard_name;
        // $guard_type=$request->guard_type;


        $results =   $this->customer_report_model->get_search_record();

        if ($customer_id != null) {
            $count=1;
            foreach($customer_id as $cc_id)
            {
                if($count==1){
                    $results->where('jobs.customer_id', $cc_id);


                }else{
                    $results->orWhere(function($query) use ($cc_id)  {
                        $query->where('jobs.customer_id', $cc_id);

                    });
                }
                $count++;
            }
        }
        if ($state != null ) {
            $count=1;
            foreach($state as $cc_id)
            {
                if($count==1){
                    $results->where('jobs.state',$cc_id);


                }else{
                    $results->orWhere(function($query) use ($cc_id)  {
                        $query->where('jobs.state',$cc_id);

                    });
                }
                $count++;
            }
        }
        if ($address != null ) {
            $count=1;
            foreach($address as $cc_id)
            {
                if($count==1){
                    $results->where('jobs.address',$cc_id);


                }else{
                    $results->orWhere(function($query) use ($cc_id)  {
                        $query->where('jobs.address',$cc_id);

                    });
                }
                $count++;
            }
        }

        if ($status != "all" ) {
            if($status=="completed"){
              $results->where('job_new_roster.job_status',"completed");

          }else{
           $results->where('job_new_roster.job_status',$status);

       }
   }
   if ($guard_id != null ) {
    $count=1;
    foreach($guard_id as $cc_id)
    {
        if($count==1){
            $results->where('job_new_roster.guard_id',$cc_id);
            
            
        }else{
            $results->orWhere(function($query) use ($cc_id)  {
                $query->where('job_new_roster.guard_id',$cc_id);

            });
        }
        $count++;
    }
}

if ($date != null ) {

    $date = explode('-', $date);
    $from = strtotime(trim($date[0]));
    $to = strtotime(trim($date[1])) + 60*60*24;
    $results->where('job_new_roster.temp_start', '>=', date('Y-m-d', $from))
    	->where('job_new_roster.temp_start', '<=',date('Y-m-d', $to));
    // $results->whereBetween('job_new_roster.temp_date', [$from, $to]);
                                // print_r($results);
                                // exit();

}

$results= $results->get();
foreach($results as $result)
{   
$rate = 0;
        if ($result->chargerate_id != null && $result->chargerate_id > 0) {
            $charge_rate = DB::table('charged_rates')->where('id', $result->chargerate_id)->first();
        }elseif($result->customer_charge_rate_id !=null && $result->customer_charge_rate_id > 0){
            $charge_rate = DB::table('charged_rates')->where('id', $result->customer_charge_rate_id)->first();
        }else{
            $charge_rate = DB::table('charged_rates')->where('level', $result->level)->where('state', $result->state)->first();
        }

        if (!empty($charge_rate)) {
                if ($result->payrol == 'Default Rates') {
                    if ($result->stateType == 'metropolitan') {
                        $rate = $charge_rate->flat_metro_flat_metro_week_day;
                    }else{
                        $rate = $charge_rate->flat_regional_week_day;
                    }
                }else{
                    if ($result->stateType == 'metropolitan') {
                        $rate = $charge_rate->eba_metro_weekday_day;
                    }else{
                        $rate = $charge_rate->eba_regional_weekday_day;
                    }
                }
            }

        $result->rate = $rate;
        $result->total_charged = $result->hours * $rate;
    $hours = $this->getTimeDiff($result->temp_start, $result->temp_end);
    $result->hours = $hours['hours'];
    $job_hours = $this->getShiftHours(date('m/d/Y H:i', strtotime($result->temp_start)), date('m/d/Y H:i', strtotime($result->temp_end)));
    $result->hours = $job_hours['morning'] + $job_hours['night'] + $job_hours['saturday_morning'] + $job_hours['saturday_night'] + $job_hours['sunday_morning'] + $job_hours['sunday_night'] + $job_hours['ph_morning'] + $job_hours['ph_night'];
    $result->hours_dis = $job_hours;
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
    $result->temp_date=Date("d/m/Y",strtotime($result->temp_date));

    $result->temp_start=Date("H:i",strtotime($result->temp_start));
    $result->temp_end=Date("H:i",strtotime($result->temp_end));

}

return ['results'=> $results];


}


public function customer_report_record(Request $request)

{

    $results=   $this->customer_report_model->get_records($request->status);
    foreach($results as $index => $result)
    {

        $hours = $this->getTimeDiff($result->temp_start, $result->temp_end);
        $result->hours=$hours['hours'];
    $result->temp_date=Date("d/m/Y",strtotime($result->temp_date));

        $result->temp_start=Date("H:i",strtotime($result->temp_start));
        $result->temp_end=Date("H:i",strtotime($result->temp_end));
        $rate = 0;
        if ($result->chargerate_id != null && $result->chargerate_id > 0) {
            $charge_rate = DB::table('charged_rates')->where('id', $result->chargerate_id)->first();
        }elseif($result->customer_charge_rate_id !=null && $result->customer_charge_rate_id > 0){
            $charge_rate = DB::table('charged_rates')->where('id', $result->customer_charge_rate_id)->first();
        }else{
            $charge_rate = DB::table('charged_rates')->where('level', $result->level)->where('state', $result->state)->first();
        }

        if (!empty($charge_rate)) {
                if ($result->payrol == 'Default Rates') {
                    if ($result->stateType == 'metropolitan') {
                        $rate = $charge_rate->flat_metro_flat_metro_week_day;
                    }else{
                        $rate = $charge_rate->flat_regional_week_day;
                    }
                }else{
                    if ($result->stateType == 'metropolitan') {
                        $rate = $charge_rate->eba_metro_weekday_day;
                    }else{
                        $rate = $charge_rate->eba_regional_weekday_day;
                    }
                }
            }

        $result->rate = $rate;
        $result->total_charged = $result->hours * $rate;
    }
    return ['results'=> $results];



}  

//contractor


public function contractor_report()
{
    if (!session()->has('userType')) {
        return view('admin/login');
    }else{
        $contractors = DB::table('contractors')->select('name','id')->orderBy('name','ASC')->get();
        $states = DB::table('jobs')->select('state')->groupBy('state')->get();
        $address = DB::table('jobs')->select('address')->groupBy('address')->get();
        $guards = DB::table('guards')->select('guard_type','name','id')->orderBy('name','ASC')->get();
        return view('/admin/report/contractor_report',['contractors'=> $contractors,'states'=> $states,'address'=> $address,'guards'=> $guards]);
    }
}


public function contractor_report_search(Request $request)
{
    $contractor_id=$request->contractor_name;
    $state=$request->state;
    $status=$request->status;
    $address=$request->address;
    $date=$request->from_to;
    $guard_id=$request->guard_name;
        // $guard_type=$request->guard_type;


    $results =   $this->contractor_report_model->get_search_record();
       // print_r($results);
       // exit();
    if ($contractor_id != null) {
        $count=1;
        foreach($contractor_id as $cc_id)
        {
            if($count==1){
                $results->where('jobs.contractor_id', $cc_id);


            }else{
                $results->orWhere(function($query) use ($cc_id)  {
                    $query->where('jobs.contractor_id', $cc_id);

                });
            }
            $count++;
        }
    }
    if ($state != null ) {
        $count=1;
        foreach($state as $cc_id)
        {
            if($count==1){
                $results->where('jobs.state',$cc_id);


            }else{
                $results->orWhere(function($query) use ($cc_id)  {
                    $query->where('jobs.state',$cc_id);

                });
            }
            $count++;
        }
    }
    if ($address != null ) {
        $count=1;
        foreach($address as $cc_id)
        {
            if($count==1){
                $results->where('jobs.address',$cc_id);


            }else{
                $results->orWhere(function($query) use ($cc_id)  {
                    $query->where('jobs.address',$cc_id);

                });
            }
            $count++;
        }
    }

    if ($status != "all" ) {
        if($status=="completed"){
          $results->where('job_new_roster.job_status',"completed");

      }else{
       $results->where('job_new_roster.job_status',$status);

   }
}
if ($guard_id != null ) {
    $count=1;
    foreach($guard_id as $cc_id)
    {
        if($count==1){
            $results->where('job_new_roster.guard_id',$cc_id);


        }else{
            $results->orWhere(function($query) use ($cc_id)  {
                $query->where('job_new_roster.guard_id',$cc_id);

            });
        }
        $count++;
    }
}

if ($date != null ) {

    $from_to = explode("-", $date);
    $from= $from_to[0];
    $to= $from_to[1];
    $timestamp = strtotime($from);
    $timestamp_to = strtotime($to);
    $from = date("Y-m-d", $timestamp);
    $to = date("Y-m-d", $timestamp_to);

    $results->whereBetween('job_new_roster.temp_date', [$from, $to]);


}

$results= $results->get();
foreach($results as $result)
{

    $hours = $this->getTimeDiff($result->temp_start, $result->temp_end);
    $result->hours=$hours['hours'];
    $result->temp_date=Date("d/m/Y",strtotime($result->temp_date));

    $result->temp_start=Date("H:i",strtotime($result->temp_start));
    $result->temp_end=Date("H:i",strtotime($result->temp_end));


}
return ['results'=> $results];


}


public function contractor_report_record(Request $request)

{

    $results=   $this->contractor_report_model->get_records($request->status);
    foreach($results as $result)
    {

        $hours = $this->getTimeDiff($result->temp_start, $result->temp_end);
        $result->hours=$hours['hours'];
    $result->temp_date=Date("d/m/Y",strtotime($result->temp_date));

        $result->temp_start=Date("H:i",strtotime($result->temp_start));
        $result->temp_end=Date("H:i",strtotime($result->temp_end));
        $rate = 0;
        if ($result->chargerate_id != null && $result->chargerate_id > 0) {
            $charge_rate = DB::table('charged_rates')->where('id', $result->chargerate_id)->first();
        }elseif($result->contractor_charge_rate_id !=null && $result->contractor_charge_rate_id > 0){
            $charge_rate = DB::table('charged_rates')->where('id', $result->contractor_charge_rate_id)->first();
        }else{
            $charge_rate = DB::table('charged_rates')->where('level', $result->level)->where('state', $result->state)->first();
        }

        if (!empty($charge_rate)) {
                if ($result->payrol == 'Default Rates') {
                    if ($result->stateType == 'metropolitan') {
                        $rate = $charge_rate->flat_metro_flat_metro_week_day;
                    }else{
                        $rate = $charge_rate->flat_regional_week_day;
                    }
                }else{
                    if ($result->stateType == 'metropolitan') {
                        $rate = $charge_rate->eba_metro_weekday_day;
                    }else{
                        $rate = $charge_rate->eba_regional_weekday_day;
                    }
                }
            }

        $result->rate = $rate;
        $result->total_charged = $result->hours * $rate;


    }
    return ['results'=> $results];



}  



// guard_detail_report_model



public function guard_detail_report(){

   if (!session()->has('userType')) {
    return view('admin/login');
}else{
    $customers = DB::table('customers')->where('status','!=','deleted')->select('name','id')->orderBy('name','ASC')->get();
    $states = DB::table('jobs')->select('state')->groupBy('state')->where('state', '!=', 'Select')->get();
    $address = DB::table('jobs')->select('address')->groupBy('address')->get();
    $active_guards =  DB::table('guards')
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
        
    $inactive_guards =  DB::table('guards')
    ->where('status', 'active')
    ->where('admin_approved',0)
    ->where('is_approved', 'yes')
    ->where('address','!=','')
    // ->where('gender','!=','')
    ->where('phone','!=','')
    ->where('name','!=','')
    ->where('name','!=',null)
    ->where('email','!=','')
    ->where('email','!=',null)
    ->where('emergency_contact_phone','!=','')
    ->where('security_license_number','!=','')
    ->where('security_license_file','!=','')
    ->where('payroll_bank_account_number','!=','')
    ->where('payroll_bank_name','!=','')->orderBy('name', 'ASC')->get();
   
    return view('/admin/report/guard_detail_report',['customers'=> $customers,'states'=> $states,'address'=> $address,'active_guards'=> $active_guards,'inactive_guards'=> $inactive_guards]);
}

}


public function guard_detail_report_record(Request $request)
{
    $results=  $this->guard_detail_report_model->get_records();
    $results= $results->get();
    foreach($results as $index => $result)
    {
       $results[$index]->specific_customer_name = '';
       $specific_customers_id =json_decode($result->specific_customers_id,true);
       foreach($specific_customers_id as $key => $value)
       {
        $res = DB::table('customers')->select('name')->where('id',$value)->first();
        $results[$index]->specific_customer_name.= $res->name.',';
    }
}
return ['results'=> $results];
} 

public function guard_detail_report_search(Request $request){
 $customer_id=$request->customer_name;
 $state=$request->state;
 $status=$request->status;
 $address=$request->address;
        // $date=$request->from_to;
 $guard_id=$request->guard_name;
 $inactive_guard_id=$request->inactive_guard_name;
        // $cc_id= "\"$customer_id\"";

        // echo $cc_id;
        // exit();
 $results =   $this->guard_detail_report_model->get_records();
 if($guard_id == null){

     if ($customer_id != null) {

                //   foreach($customer_id as $cc_id)
                //   {

                //     $cc_id="\"$cc_id\"";

                //     $results->orWhere('specific_customers_id', 'like', '1%');

                //         }
        $count=1;
                        // foreach($customer_id as $cc_id)
                        //     {
        if($count==1){
            $results->whereJsonContains('specific_customers_id', $customer_id);

        }
                            //     else{
                            //         $results->orWhere(function($query) use ($cc_id)  {
                            //             $query->where('jobs.contractor_id', $cc_id);

                            //         });
                            //     }
                            //     $count++;
                            // }



    }


    if ($state != null ) {
        $count=1;
        foreach($state as $cc_id)
        {
            if($count==1){
                $results->where('state',$cc_id);


            }else{
                $results->orWhere(function($query) use ($cc_id)  {
                    $query->where('state',$cc_id);


                });
            }
            $count++;
        }
    }

    if ($address != null ) {
        $count=1;
        foreach($address as $cc_id)
        {
            if($count==1){
                $results->where('address',$cc_id);


            }else{
                $results->orWhere(function($query) use ($cc_id)  {
                    $query->where('address',$cc_id);


                });
            }
            $count++;
        }

    }

    if($status=="active"){
       $results->where('status',"active");

   }
   if($status=="inactive"){
       $results->where('status',"inactive");

   }
   if($status=="deleted"){
       $results->where('status',"deleted");

   }
}

if ($inactive_guard_id != null ) {
    $count=1;
    foreach($guard_id as $cc_id)
    {
        if($count==1){
            $results->where('id' , $cc_id);
        }else{
            $results->orWhere(function($query) use ($cc_id)  {
                $query->where('id' , $cc_id);
            });
        }
        $count++;
    }

}

if ($guard_id != null ) {
    $count=1;
    foreach($guard_id as $cc_id)
    {
        if($count==1){
            $results->where('id' , $cc_id);
        }else{
            $results->orWhere(function($query) use ($cc_id)  {
                $query->where('id' , $cc_id);
            });
        }
        $count++;
    }

}

$results= $results->get();

foreach($results as $index => $result)
{
   $results[$index]->specific_customer_name = '';
   $specific_customers_id =json_decode($result->specific_customers_id,true);

   foreach($specific_customers_id as $key=>$value)
   {

    $res=DB::table('customers')->select('name')->where('id',$value)->first();
    if (!empty($res)) {
    $results[$index]->specific_customer_name.= $res->name.',';
    }



}
}   return ['results'=> $results];



}


// task report

public function task_report()
{
    $customers = $this->task_report_model->get_customers();
    $states='';
    $address='';
    $guards='';
    $tasks = $this->task_report_model->get_customers();
    return view('/admin/report/task_report',['tasks'=> $tasks,'customers'=> $customers,'states'=> $states,'address'=> $address,'guards'=> $guards]);
}

public function get_customers_jobs_list(Request $request)
{

    return $this->task_report_model->get_customers_jobs_list($request->customerId);


} 
public function task_report_onchange(Request $request)
{
 $guards=array();
 $results= $this->task_report_model->task_report_onchange($request->customerId);
 foreach($results as $result)
 {
   // $result->job_added=date("d-m-Y",strtotime($result->job_added));
   // $total_task = DB::table('job_roster_tasks')->where('roster_id', $result->roster_id)->where('guard_id', $result->guardId)->select('id')->get();
   // $result->total_count = count($total_task);
    array_push($guards,$result->guardId);
}
    $job_guard=array();
   $job_guard= DB::table('guards')->where(function ($query) use ($guards){
    foreach ($guards as $key => $guard_id) {
        if ($key == 0) {
            $query->where('id', $guard_id);
        }else{
            $query->orWhere('id', $guard_id);
        }
    }
   })->select('name','id')->get();
if($request->has('isEdit') && $request->isEdit=="yes"){
    return ['results'=>$results];
}else{
    return ['results'=>$results,'guards'=>$job_guard];
}
} 

public function task_report_search(Request $request){
    $state=$request->state;
    $address=$request->address;
    $guard_id=$request->guard_name;
    $date= $request->from_to;
    $results =   $this->task_report_model->task_report_search($request->customer_name);
    if($guard_id == null){
        if ($state != null ) {
            $count=1;
            foreach($state as $cc_id)
            {
                if($count==1){
                    $results->where('jobs.state',$cc_id);

                }else{
                    $results->orWhere(function($query) use ($cc_id)  {
                        $query->where('jobs.state',$cc_id);
                    });
                }
                $count++;
            }
        }
        if ($address != null ) {
            $count=1;
            foreach($address as $cc_id)
            {
                if($count==1){
                    $results->where('jobs.site_name',$cc_id);

                }else{
                    $results->orWhere(function($query) use ($cc_id)  {
                        $query->where('jobs.site_name',$cc_id);
                    });
                }
                $count++;
            }
        }

        if ($date != null ) {

            $from_to = explode("-", $date);
            $from= $from_to[0];
            $to= $from_to[1];
            $timestamp = strtotime($from);
            $timestamp_to = strtotime($to);
            $from = date("Y-m-d", $timestamp);
            $to = date("Y-m-d", $timestamp_to);
            $results->whereBetween('job_new_roster.temp_date', [$from, $to]);
        }
    }
    if ($guard_id != null ) {
        $count=1;
        foreach($guard_id as $cc_id)
        {
            if($count==1){
                $results->where('job_roster_tasks.guard_id' , $cc_id);

            }else{
                $results->orWhere(function($query) use ($cc_id)  {
                    $query->where('job_roster_tasks.guard_id', $cc_id);
                });
            }
            $count++;
        }
    }
    $results= $results->get();
    foreach($results as $result)
 {
   $result->job_added=date("d-m-Y",strtotime($result->job_added));
   $total_task = DB::table('job_roster_tasks')->where('roster_id', $result->roster_id)->where('guard_id', $result->guardId)->select('id')->get();
   $result->total_count = count($total_task);
}
    return ['results'=> $results];
}

public function export_table(Request $request){
    $task_id = $request->roster_id;
    $customer_id=$request->customer_id;
    $tasks = DB::table('job_roster_tasks')
    ->join('job_new_roster', 'job_new_roster.roster_id', '=', 'job_roster_tasks.roster_id')
    ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
    ->where('job_roster_tasks.roster_id',$task_id)
    ->select( 'jobs.address as address', 
        'jobs.site_name as site_name', 'jobs.site_description as site_description',
        'job_roster_tasks.task_name','job_new_roster.temp_date as job_added',
        'job_roster_tasks.id as task_id'  ,
        'job_roster_tasks.status as task_status',
        'job_roster_tasks.task_name as task_name',
        'job_roster_tasks.start_time as task_assigned_task_time',
        'job_roster_tasks.end_time as task_completed_time',
        'job_roster_tasks.end_location as task_location'
    )->get();
    $site_name = $tasks->pluck('site_name')->first();
    // $site_name=$site_name;
    foreach($tasks as $task){
       $task->task_location = $this->coordinates_to_address($task->task_location);
       $task->task_completed_time = Date("H:i",strtotime($task->task_completed_time));
    }
   return ['tasks'=>$tasks,'site_name'=>$site_name];
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

function coordinates_to_address($coordinates){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$coordinates.'&key=AIzaSyCS-DB39Kk-Z25C5GWymVGshXIALbjXPGY');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    
    $result = curl_exec($ch);
    curl_close($ch);
    
    $address = json_decode($result, 1);
    return isset($address['results'][0]['formatted_address']) ? $address['results'][0]['formatted_address'] : $coordinates;
}
function generate_complete_activity_report_api(Request $request, $roster_id)
{
    return $this->generate_complete_activity_report($request, $roster_id, 'api');
}
public function generate_complete_activity_report(Request $request, $roster_id, $call_from = null)
{
    $activity = DB::table('roster_complete_activity')->where('roster_id', $roster_id)->orderBy('activity_time' ,'Desc')->get();
    $details = DB::table('job_new_roster')
    ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
    ->join('guards', 'guards.id', '=', 'job_new_roster.guard_id')
    ->where('job_new_roster.roster_id', $roster_id)
    ->select('job_new_roster.job_start', 'job_new_roster.job_end', 'guards.name', 'guards.phone', 'jobs.site_name', 'jobs.site_description', 'jobs.address', 'job_new_roster.temp_start', 'job_new_roster.temp_end')
    ->first();

        // $html = view('reports/roster_activity_pdf', ['data' => $activity, 'details' => $details])->render();
        // $logo = $this->image_to_base64(config('custom.logo'));
    $logo = '';
    if ($call_from == 'api') {
        if (count($activity) > 0) {
            $details->temp_start = date('d/m/Y H:i', strtotime($details->temp_start));
            $details->temp_end = date('d/m/Y H:i', strtotime($details->temp_end));
            return response()->json(['status' => true, 'message' => 'Data found', 'data' => $activity, 'details' => $details], 200);
        }else{
            return response()->json(['status' => false, 'message' => 'No data found', 'data' => $activity], 200);
        }
        }else{
    $pdf = PDF::loadView('reports/roster_activity_pdf', ['data' => $activity,'logo' => $logo, 'details' => $details]);
    return $pdf->download(date('d/m/Y').'_roster_acticity_report.pdf');
    }
        // return redirect('/administrators');
}

function image_to_base64($image)
{
    $img = file_get_contents($image);

        // Encode the image string data into base64
    $data = base64_encode($img);
        // Display the output
    return $data;
}

function generateRosterReport(Request $request)
    {
        return Excel::download(new RosterReportExport, 'roster_report.xlsx');  
    }
function generateRosterReportExcel($request)
{
    ini_set('memory_limit', '-1');
    $start_str = strtotime($request['start']);
    $end_str = strtotime($request['end']);
    $logo = '';
    // echo $request['start'];
    // exit(); 
    // $logo = config('custom.logo');
    // <img class="navbar-brand-logo" src="'.$logo.'" title="247 staffing solution" height="50">
    $customers = explode(',', $request['customers']);
    $pdf = '';
    foreach ($customers as $key => $cust) {
        $customer = DB::table('customers')->where('id', $cust)->select('name')->first();
            $data = DB::table('jobs')->where('customer_id', $cust)->select('id');
            if (isset($request['search_value']) && $request['search_value'] != 'undefined' && !empty($request['search_value'])) {
                $search_value = json_decode($request['search_value'], true);
                $data->where(function ($query1) use ($search_value){
                    $i = 0;
                foreach($search_value as $index) {
                    if ($i == 0) {
                        $query1->where('id', $index);
                    }else{
                    $query1->orWhere('id', $index);
                    }
                $i++;
                }
                });
        }  
           $sites= $data->get();
        $pdf .= '
  <table style="width:100%;">
  <thead>
  <tr>
  <th>
  
  </th>
  <th style="text-align: center; font-size:22px; font-weight:bold;">
  <div >Roster Report</div>
  <div style="text-align: center; font-size:18px;">'.$customer->name.' - Week starting '.date('D, M d, Y H:i', $start_str).' (Planned)</div>
  </th>
  </tr>
  </thead>
  </table>
  <table style="width:100%;">
  <thead>
  <tr>
  <th style="border:1px solid #000000;width: 20px;font-size:15px;">
  Name
  </th>';

  for ($i=$start_str; $i < $end_str;) { 
      $pdf .= '<th style="border:1px solid #000000;width: 20px;font-size:15px;">'.date('D M d', $i).'</th>';
      $i = $i + (60*60 *24);
  }


  $pdf .='<th style="border:1px solid #000000;width: 20px; font-size:15px;">
  Total Hrs | Wages
  </th>
  </tr></thead>
<tbody>';
  $datediff = $end_str - $start_str;
  $counter = 0;
  $guards_array = array();
  $diff = round($datediff / (60 * 60 * 24));
  $total_hours[0] = array(
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0
);
  foreach ($sites as $key => $site_id) {
      $day_start = $start_str-1;
      $day_end = $start_str + (60*60*24)-1;
      $days_td = array();
      $max_shifts_in_day = 0;
      $site = DB::table('jobs')->where('id', $site_id->id)->select('site_name', 'site_description')->first();

      for ($i=0; $i < $diff; $i++) { 
          $days_td[$i] = array(); 
            if ($request['report'] == 'divide') {

        // check if any shift ends in this time
          $shifts_ends_in_this_day = DB::table('job_new_roster')->where('site_id', $site_id->id)->where('temp_start', '<', date('Y-m-d 00:00:00', $day_start))->where('temp_end','>', date('Y-m-d 00:00:00', $day_start))->orderBy('job_start', 'ASC')->get();

          $shifts_start_in_this_day = DB::table('job_new_roster')->where('site_id', $site_id->id)->where('temp_start', '>=', date('Y-m-d 00:00:00', $day_start))->where('temp_start', '<=', date('Y-m-d 00:00:00', $day_end))->orderBy('job_start', 'ASC')->get();

          $all_shifts = $shifts_ends_in_this_day->merge($shifts_start_in_this_day);
      }else{
        $all_shifts = DB::table('job_new_roster')->where('site_id', $site_id->id)->where('temp_start', '>=', date('Y-m-d 00:00:00', $day_start))->where('temp_start', '<=', date('Y-m-d 00:00:00', $day_end))->orderBy('job_start', 'ASC')->get();
      }

          foreach ($all_shifts as $all_shift) 
          {
              $guard = DB::table('guards')->where('id', $all_shift->guard_id)->first();
              if (!empty($guard) && !isset($guards_array[$guard->id])) {
                $guards_array[$guard->id] = array(
                  'name' => $guard->name, 
                  'id' => $guard->id,
                  'phone' => $guard->phone,
                  'suburb' => $guard->suburb,
                  'security_license_expiration' => $guard->security_license_expiration,
                  'security_license_number' => $guard->security_license_number,
              );
            }
            $all_shift->temp_start = strtotime($all_shift->temp_start); 
            $all_shift->temp_end = strtotime($all_shift->temp_end);
            if ($request['report'] == 'divide') {
            if ($all_shift->temp_start < $day_start && $all_shift->temp_end > $day_start) {
                $all_shift->temp_start = $day_start + 100;
            }
            elseif ($all_shift->temp_start > $day_start && $all_shift->temp_end > $day_end) {
                $all_shift->temp_end = $day_end;
            }
            }
          // if ($all_shift['temp_start'] < $day_start) {
          //   $all_shift['temp_start'] = $day_start + 100;
          // }

          // if ($all_shift['temp_end'] < $day_end && $all_shift['temp_start'] < $day_start) {
          //   $all_shift['temp_end'] = $day_end;
          // }
            $diff_hour = $all_shift->temp_end - $all_shift->temp_start;
            $hours = $diff_hour / ( 60 * 60 );
            $total_hours_count = explode('.', $hours);
            if (sizeof($total_hours_count) > 1 ) {
              $partial = '.'.$total_hours_count[1];
              if ($partial < 0.1) {
                $hours = $total_hours_count[0];
            }
            if ($partial < 0.27 && $partial > 0.1) {
                $hours = $total_hours_count[0].'.25';
            }
            if ($partial > 0.27 && $partial < 0.52) {
                $hours = $total_hours_count[0].'.5';
            }
            if ($partial > 0.52 && $partial < 0.77) {
                $hours = $total_hours_count[0].'.75';
            }
            if ($partial > 0.77 && $partial < 1) {
                $hours = $total_hours_count[0]+ 1;
            }
        }

        $days_td[$i][] = array(
            'guard_name' => !empty($guard) ? $guard->name : $all_shift->moke_guard,
            'start' => date('H:i a', $all_shift->temp_start),
            'end' => date('H:i a', $all_shift->temp_end),
            'day_start' => date('m/d/Y H:i a', $day_start),
            'day_end' => date('m/d/Y H:i a', $day_end),
            'hours' => $hours,
            'training' => $all_shift->training
        );
    }
    $day_start = $day_end + 1;
    $day_end = $day_end + (60*60*24);
    if (count($days_td[$i]) > $max_shifts_in_day) {
      $max_shifts_in_day = count($days_td[$i]);
  }

}

// print_r('<pre>');
// print_r($days_td);
// exit();
$total_hours[$site_id->id] = array(
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0
);
for ($i=0; $i < $max_shifts_in_day; $i++) { 
  $pdf .= '<tr>';
  $pdf .= '<td style="border:1px solid #000000; background-color:#EDEDED;">'.$site->site_name.' - '. htmlspecialchars($site->site_description).'</td>';
  $pdf .= '<td style="border:1px solid #000000;">'.((isset($days_td[0][$i])) ? $days_td[0][$i]['guard_name'].' '.$days_td[0][$i]['start']. ' - '. $days_td[0][$i]['end'].'('.$days_td[0][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[0][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;">'.((isset($days_td[1][$i])) ? $days_td[1][$i]['guard_name'].' '.$days_td[1][$i]['start']. ' - '. $days_td[1][$i]['end'].'('.$days_td[1][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[1][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;">'.((isset($days_td[2][$i])) ? $days_td[2][$i]['guard_name'].' '.$days_td[2][$i]['start']. ' - '. $days_td[2][$i]['end'].'('.$days_td[2][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[2][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;">'.((isset($days_td[3][$i])) ? $days_td[3][$i]['guard_name'].' '.$days_td[3][$i]['start']. ' - '. $days_td[3][$i]['end'].'('.$days_td[3][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[3][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;">'.((isset($days_td[4][$i])) ? $days_td[4][$i]['guard_name'].' '.$days_td[4][$i]['start']. ' - '. $days_td[4][$i]['end'].'('.$days_td[4][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[4][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;">'.((isset($days_td[5][$i])) ? $days_td[5][$i]['guard_name'].' '.$days_td[5][$i]['start']. ' - '. $days_td[5][$i]['end'].'('.$days_td[5][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[5][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;">'.((isset($days_td[6][$i])) ? $days_td[6][$i]['guard_name'].' '.$days_td[6][$i]['start']. ' - '. $days_td[6][$i]['end'].'('.$days_td[6][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[6][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;"></td>';
  $total_hours[$site_id->id][0] = $total_hours[$site_id->id][0] + (isset($days_td[0][$i]) ? $days_td[0][$i]['hours'] : 0);
  $total_hours[$site_id->id][1] = $total_hours[$site_id->id][1] + (isset($days_td[1][$i]) ? $days_td[1][$i]['hours'] : 0); 
  $total_hours[$site_id->id][2] = $total_hours[$site_id->id][2] + (isset($days_td[2][$i]) ? $days_td[2][$i]['hours'] : 0); 
  $total_hours[$site_id->id][3] = $total_hours[$site_id->id][3] + (isset($days_td[3][$i]) ? $days_td[3][$i]['hours'] : 0); 
  $total_hours[$site_id->id][4] = $total_hours[$site_id->id][4] + (isset($days_td[4][$i]) ? $days_td[4][$i]['hours'] : 0); 
  $total_hours[$site_id->id][5] = $total_hours[$site_id->id][5] + (isset($days_td[5][$i]) ? $days_td[5][$i]['hours'] : 0); 
  $total_hours[$site_id->id][6] = $total_hours[$site_id->id][6] + (isset($days_td[6][$i]) ? $days_td[6][$i]['hours'] : 0); 

  $pdf .= '</tr>';
}
if (($total_hours[$site_id->id][0] + $total_hours[$site_id->id][1] + $total_hours[$site_id->id][2]+ $total_hours[$site_id->id][3]+ $total_hours[$site_id->id][4]+ $total_hours[$site_id->id][5]+ $total_hours[$site_id->id][6]) > 0) {
   $pdf .= '<tr>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">Sub Total Hrs | Wages</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][0].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][1].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][2].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][3].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][4].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][5].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][6].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.($total_hours[$site_id->id][0] + $total_hours[$site_id->id][1] + $total_hours[$site_id->id][2]+ $total_hours[$site_id->id][3]+ $total_hours[$site_id->id][4]+ $total_hours[$site_id->id][5]+ $total_hours[$site_id->id][6]).'</td>';
   $pdf .= '</tr>';
   $total_hours[0] = array(
    0 => $total_hours[0][0] + $total_hours[$site_id->id][0],
    1 => $total_hours[0][1] + $total_hours[$site_id->id][1],
    2 => $total_hours[0][2] + $total_hours[$site_id->id][2],
    3 => $total_hours[0][3] + $total_hours[$site_id->id][3],
    4 => $total_hours[0][4] + $total_hours[$site_id->id][4],
    5 => $total_hours[0][5] + $total_hours[$site_id->id][5],
    6 => $total_hours[0][6] + $total_hours[$site_id->id][6],
    7 => $total_hours[0][7] + ($total_hours[$site_id->id][0] + $total_hours[$site_id->id][1] + $total_hours[$site_id->id][2]+ $total_hours[$site_id->id][3]+ $total_hours[$site_id->id][4]+ $total_hours[$site_id->id][5]+ $total_hours[$site_id->id][6])
);
}

if (count($sites) > 1 && ($total_hours[$site_id->id][0] + $total_hours[$site_id->id][1] + $total_hours[$site_id->id][2]+ $total_hours[$site_id->id][3]+ $total_hours[$site_id->id][4]+ $total_hours[$site_id->id][5]+ $total_hours[$site_id->id][6]) > 0) {

  $pdf .= '<tr>';
  $pdf .= '<td style="border:1px solid #000000;height:25px;background-color:#EDEDED;"></td>';
  $pdf .= '<td style="border:1px solid #000000;height:25px;background-color:#EDEDED;"></td>';
  $pdf .= '<td style="border:1px solid #000000;height:25px;background-color:#EDEDED;"></td>';
  $pdf .= '<td style="border:1px solid #000000;height:25px;background-color:#EDEDED;"></td>';
  $pdf .= '<td style="border:1px solid #000000;height:25px;background-color:#EDEDED;"></td>';
  $pdf .= '<td style="border:1px solid #000000;height:25px;background-color:#EDEDED;"></td>';
  $pdf .= '<td style="border:1px solid #000000;height:25px;background-color:#EDEDED;"></td>';
  $pdf .= '<td style="border:1px solid #000000;height:25px;background-color:#EDEDED;"></td>';
  $pdf .= '<td style="border:1px solid #000000;height:25px;background-color:#EDEDED;"></td>';
  $pdf .= '</tr>';
  $counter++;
}

}
// if (count($sites) == 1) {
//   $pdf .= '<tr>';
//   $pdf .= '<td style="border:1px solid #000000;"></td>';
//   $pdf .= '<td style="border:1px solid #000000;"></td>';
//   $pdf .= '<td style="border:1px solid #000000;"></td>';
//   $pdf .= '<td style="border:1px solid #000000;"></td>';
//   $pdf .= '<td style="border:1px solid #000000;"></td>';
//   $pdf .= '<td style="border:1px solid #000000;"></td>';
//   $pdf .= '<td style="border:1px solid #000000;"></td>';
//   $pdf .= '<td style="border:1px solid #000000;"></td>';
//   $pdf .= '<td style="border:1px solid #000000;"></td>';
//   $pdf .= '</tr>';
// }

$pdf .= '<tr>';
$pdf .= '<td style="border:1px solid #000000;">Total Hrs | Wages</td>';
$pdf .= '<td style="border:1px solid #000000;">'.$total_hours[0][0].'</td>';
$pdf .= '<td style="border:1px solid #000000;">'.$total_hours[0][1].'</td>';
$pdf .= '<td style="border:1px solid #000000;">'.$total_hours[0][2].'</td>';
$pdf .= '<td style="border:1px solid #000000;">'.$total_hours[0][3].'</td>';
$pdf .= '<td style="border:1px solid #000000;">'.$total_hours[0][4].'</td>';
$pdf .= '<td style="border:1px solid #000000;">'.$total_hours[0][5].'</td>';
$pdf .= '<td style="border:1px solid #000000;">'.$total_hours[0][6].'</td>';
$pdf .= '<td style="border:1px solid #000000;">'.$total_hours[0][7].'</td>';
$pdf .= '</tr>';
$pdf .= '<tr>';
$pdf .= '<td style="border:1px solid #000000;"></td>';
$pdf .= '<td style="border:1px solid #000000;"></td>';
$pdf .= '<td style="border:1px solid #000000;"></td>';
$pdf .= '<td style="border:1px solid #000000;"></td>';
$pdf .= '<td style="border:1px solid #000000;"></td>';
$pdf .= '<td style="border:1px solid #000000;"></td>';
$pdf .= '<td style="border:1px solid #000000;"></td>';
$pdf .= '<td style="border:1px solid #000000;"></td>';
$pdf .= '<td style="border:1px solid #000000;"></td>';
$pdf .= '</tr>';

$pdf .='</tbody></table>';

$pdf .='<table style="width:100%;"><tbody>
<tr>
<td style="border:1px solid #000000;">
<div style="text-align: center;" class="title">Guard Details</div>
</td>
</tr></tbody></table>
<table style="width:100%;">
<tr>
<th style="border:1px solid #000000;">
Guard name
</th>
<th style="border:1px solid #000000;">
Guard Mob
</th>
<th style="border:1px solid #000000;">
Suburb
</th>
<th style="border:1px solid #000000;">
Security License
</th>
<th style="border:1px solid #000000;">
Security License Expiry
</th>
</tr><tbody>
';
foreach ($guards_array as $key => $guard) {
   $pdf .='<tr>
   <td style="border:1px solid #000000;">'.$guard['name'].'</td>
   <td style="border:1px solid #000000;">'.$guard['phone'].'</td>
   <td style="border:1px solid #000000;">'.$guard['suburb'].'</td>
   <td style="border:1px solid #000000;">'.$guard['security_license_number'].'</td>
   <td style="border:1px solid #000000;">'.$guard['security_license_expiration'].'</td>
   </tr>';
}
$pdf .= '</tbody></table>';
// if ($key <= count($customers)) {
//     $pdf .= '<div class="page-break"></div>';
// }
}
// $pdf .= '</div>
// </div></body></html>';
// $pdf_data = $pdf;
// return View('admin/report/excel',compact('pdf_data'));
// echo $pdf;
// exit();
return $pdf;
}
function generateRosterReport_old(Request $request)
{
    ini_set('memory_limit', '-1');
    $start_str = strtotime($request->start);
    $end_str = strtotime($request->end);
    $logo = config('custom.logo');

    $customers = explode(',', $request->customers);
    $pdf = '<!DOCTYPE html>
        <html><head>
        <style>
        .bod{
          font-size: 14px;
          line-height: 1.42857143;
          color: #333;
          background-color: #fbfbfb;
      }
      .container-fluid{
          padding-right: 15px;
          padding-left: 15px;
          margin-right: auto;
          margin-left: auto;
      }
      .title{
          font-size: 22px;
          color:#000;
      }
      .title1{
          font-size: 25px;
          font-weight:bold;
          color:#000;
      }
      td{
          padding: 5px 0px;
      }
      strong{
        font-size: 16px;
    }
    th{
      text-align:left:
  }
  .bod-1{
      border:1px solid #000000;
  }
  .bodl-1{
      border-left:1px solid #000000;
  }
  .bodr-1{
      border-right:1px solid #000000;
  }
  .bodt-1{
      border-top:1px solid #000000;
  }
  .bodb-1{
      border-bottom:1px solid #000000;
  }
  .bg-g{
      background-color:#eeeeee;
      padding:10px;
  }
  .bg-gr{
      background-color:#eeeeee;
  }
  .bg-y{
      background-color:#e8e8b6;
  }
  .page-break {
    page-break-after: always;
    }
 
  </style>
  </head><body class="bod"><div class="container-fluid">
  <div class="row">';
    foreach ($customers as $key => $cust) {
        $customer = DB::table('customers')->where('id', $cust)->select('name')->first();
            $data = DB::table('jobs')->where('customer_id', $cust)->select('id');
            if ($request->has('search_value') && $request->search_value != 'undefined' && !empty($request->search_value)) {
                $search_value = json_decode($request->search_value, true);
                $data->where(function ($query1) use ($search_value){
                    $i = 0;
                foreach($search_value as $index) {
                    if ($i == 0) {
                        $query1->where('id', $index);
                    }else{
                    $query1->orWhere('id', $index);
                    }
                $i++;
                }
                });
            // $data->where(function ($query1) use($search_value){
            //     $query1->where('site_name','LIKE','%'.$search_value.'%');
            //     $query1->orWhere('site_description','LIKE','%'.$search_value.'%');
            // });
        }  
           $sites= $data->get();
        $pdf .= '
  <table style="width:100%;">
  <tr>
  <td>
  <div style="text-align: center;"><img class="navbar-brand-logo" src="'.$logo.'" title="247 staffing solution" height="50"></div>
  </td>
  </tr>
  <tr>
  <td>
  <div style="text-align: center;" class="title1">Roster Report</div>
  </td>
  </tr>
  <tr>
  <td>
  <div style="text-align: center;" class="title">'.$customer->name.' - Week starting '.date('D, M d, Y', $start_str).' (Planned)</div>
  </td>
  
  </tr>
  <tr>
  <table style="width:100%;">
  <tr>
  <th class="bod-1 ">
  Name
  </th>';

  for ($i=$start_str; $i < $end_str;) { 
      $pdf .= '<th class="bod-1">'.date('D M d', $i).'</th>';
      $i = $i + (60*60 *24);
  }


  $pdf .='<th class="bod-1">
  Total Hrs | Wages
  </th>
  </tr>';
  $datediff = $end_str - $start_str;
  $counter = 0;
  $guards_array = array();
  $diff = round($datediff / (60 * 60 * 24));
  $total_hours[0] = array(
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0
);
  foreach ($sites as $key => $site_id) {
      $day_start = $start_str-1;
      $day_end = $start_str + (60*60*24)-1;
      $days_td = array();
      $max_shifts_in_day = 0;
      $site = DB::table('jobs')->where('id', $site_id->id)->select('site_name', 'site_description')->first();

      for ($i=0; $i < $diff; $i++) { 
          $days_td[$i] = array(); 
            if ($request->report == 'divide') {

        // check if any shift ends in this time
          $shifts_ends_in_this_day = DB::table('job_new_roster')->where('site_id', $site_id->id)->where('temp_start', '<', date('Y-m-d H:i', $day_start))->where('temp_end','>', date('Y-m-d H:i', $day_start))->orderBy('job_start', 'ASC')->get();

          $shifts_start_in_this_day = DB::table('job_new_roster')->where('site_id', $site_id->id)->where('temp_start', '>=', date('Y-m-d H:i', $day_start))->where('temp_start', '<=', date('Y-m-d H:i', $day_end))->orderBy('job_start', 'ASC')->get();

          $all_shifts = $shifts_ends_in_this_day->merge($shifts_start_in_this_day);
      }else{
        $all_shifts = DB::table('job_new_roster')->where('site_id', $site_id->id)->where('temp_start', '>=', date('Y-m-d H:i', $day_start))->where('temp_start', '<=', date('Y-m-d H:i', $day_end))->orderBy('job_start', 'ASC')->get();
      }

          foreach ($all_shifts as $all_shift) 
          {
              $guard = DB::table('guards')->where('id', $all_shift->guard_id)->first();
              if (!empty($guard) && !isset($guards_array[$guard->id])) {
                $guards_array[$guard->id] = array(
                  'name' => $guard->name, 
                  'id' => $guard->id,
                  'phone' => $guard->phone,
                  'suburb' => $guard->suburb,
                  'security_license_expiration' => $guard->security_license_expiration,
                  'security_license_number' => $guard->security_license_number,
              );
            }
            $all_shift->temp_start = strtotime($all_shift->temp_start); 
            $all_shift->temp_end = strtotime($all_shift->temp_end);
            if ($request->report == 'divide') {
            if ($all_shift->temp_start < $day_start && $all_shift->temp_end > $day_start) {
                $all_shift->temp_start = $day_start + 100;
            }
            elseif ($all_shift->temp_start > $day_start && $all_shift->temp_end > $day_end) {
                $all_shift->temp_end = $day_end;
            }
            }
          // if ($all_shift['temp_start'] < $day_start) {
          //   $all_shift['temp_start'] = $day_start + 100;
          // }

          // if ($all_shift['temp_end'] < $day_end && $all_shift['temp_start'] < $day_start) {
          //   $all_shift['temp_end'] = $day_end;
          // }
            $diff_hour = $all_shift->temp_end - $all_shift->temp_start;
            $hours = $diff_hour / ( 60 * 60 );
            $total_hours_count = explode('.', $hours);
            if (sizeof($total_hours_count) > 1 ) {
              $partial = '.'.$total_hours_count[1];
              if ($partial < 0.1) {
                $hours = $total_hours_count[0];
            }
            if ($partial < 0.27 && $partial > 0.1) {
                $hours = $total_hours_count[0].'.25';
            }
            if ($partial > 0.27 && $partial < 0.52) {
                $hours = $total_hours_count[0].'.5';
            }
            if ($partial > 0.52 && $partial < 0.77) {
                $hours = $total_hours_count[0].'.75';
            }
            if ($partial > 0.77 && $partial < 1) {
                $hours = $total_hours_count[0]+ 1;
            }
        }

        $days_td[$i][] = array(
            'guard_name' => !empty($guard) ? $guard->name : $all_shift->moke_guard,
            'start' => date('H:i a', $all_shift->temp_start),
            'end' => date('H:i a', $all_shift->temp_end),
            'day_start' => date('m/d/Y H:i a', $day_start),
            'day_end' => date('m/d/Y H:i a', $day_end),
            'hours' => $hours,
            'training' => $all_shift->training
        );
    }
    $day_start = $day_end + 1;
    $day_end = $day_end + (60*60*24);
    if (count($days_td[$i]) > $max_shifts_in_day) {
      $max_shifts_in_day = count($days_td[$i]);
  }

}

// print_r('<pre>');
// print_r($days_td);
// exit();
$total_hours[$site_id->id] = array(
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0
);
for ($i=0; $i < $max_shifts_in_day; $i++) { 
  $pdf .= '<tr>';
  $pdf .= '<td class="bod-1 bg-gr">'.$site->site_name.' - '.$site->site_description.'</td>';
  $pdf .= '<td class="bod-1">'.((isset($days_td[0][$i])) ? $days_td[0][$i]['guard_name'].' '.$days_td[0][$i]['start']. ' - '. $days_td[0][$i]['end'].'('.$days_td[0][$i]['hours'].'h)'.(($request->report == 'normal' && $days_td[0][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td class="bod-1">'.((isset($days_td[1][$i])) ? $days_td[1][$i]['guard_name'].' '.$days_td[1][$i]['start']. ' - '. $days_td[1][$i]['end'].'('.$days_td[1][$i]['hours'].'h)'.(($request->report == 'normal' && $days_td[1][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td class="bod-1">'.((isset($days_td[2][$i])) ? $days_td[2][$i]['guard_name'].' '.$days_td[2][$i]['start']. ' - '. $days_td[2][$i]['end'].'('.$days_td[2][$i]['hours'].'h)'.(($request->report == 'normal' && $days_td[2][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td class="bod-1">'.((isset($days_td[3][$i])) ? $days_td[3][$i]['guard_name'].' '.$days_td[3][$i]['start']. ' - '. $days_td[3][$i]['end'].'('.$days_td[3][$i]['hours'].'h)'.(($request->report == 'normal' && $days_td[3][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td class="bod-1">'.((isset($days_td[4][$i])) ? $days_td[4][$i]['guard_name'].' '.$days_td[4][$i]['start']. ' - '. $days_td[4][$i]['end'].'('.$days_td[4][$i]['hours'].'h)'.(($request->report == 'normal' && $days_td[4][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td class="bod-1">'.((isset($days_td[5][$i])) ? $days_td[5][$i]['guard_name'].' '.$days_td[5][$i]['start']. ' - '. $days_td[5][$i]['end'].'('.$days_td[5][$i]['hours'].'h)'.(($request->report == 'normal' && $days_td[5][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td class="bod-1">'.((isset($days_td[6][$i])) ? $days_td[6][$i]['guard_name'].' '.$days_td[6][$i]['start']. ' - '. $days_td[6][$i]['end'].'('.$days_td[6][$i]['hours'].'h)'.(($request->report == 'normal' && $days_td[6][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td class="bod-1"></td>';
  $total_hours[$site_id->id][0] = $total_hours[$site_id->id][0] + (isset($days_td[0][$i]) ? $days_td[0][$i]['hours'] : 0);
  $total_hours[$site_id->id][1] = $total_hours[$site_id->id][1] + (isset($days_td[1][$i]) ? $days_td[1][$i]['hours'] : 0); 
  $total_hours[$site_id->id][2] = $total_hours[$site_id->id][2] + (isset($days_td[2][$i]) ? $days_td[2][$i]['hours'] : 0); 
  $total_hours[$site_id->id][3] = $total_hours[$site_id->id][3] + (isset($days_td[3][$i]) ? $days_td[3][$i]['hours'] : 0); 
  $total_hours[$site_id->id][4] = $total_hours[$site_id->id][4] + (isset($days_td[4][$i]) ? $days_td[4][$i]['hours'] : 0); 
  $total_hours[$site_id->id][5] = $total_hours[$site_id->id][5] + (isset($days_td[5][$i]) ? $days_td[5][$i]['hours'] : 0); 
  $total_hours[$site_id->id][6] = $total_hours[$site_id->id][6] + (isset($days_td[6][$i]) ? $days_td[6][$i]['hours'] : 0); 

  $pdf .= '</tr>';
}
if (($total_hours[$site_id->id][0] + $total_hours[$site_id->id][1] + $total_hours[$site_id->id][2]+ $total_hours[$site_id->id][3]+ $total_hours[$site_id->id][4]+ $total_hours[$site_id->id][5]+ $total_hours[$site_id->id][6]) > 0) {
   $pdf .= '<tr>';
   $pdf .= '<td class="bod-1 bg-y">Sub Total Hrs | Wages</td>';
   $pdf .= '<td class="bod-1 bg-y">'.$total_hours[$site_id->id][0].'</td>';
   $pdf .= '<td class="bod-1 bg-y">'.$total_hours[$site_id->id][1].'</td>';
   $pdf .= '<td class="bod-1 bg-y">'.$total_hours[$site_id->id][2].'</td>';
   $pdf .= '<td class="bod-1 bg-y">'.$total_hours[$site_id->id][3].'</td>';
   $pdf .= '<td class="bod-1 bg-y">'.$total_hours[$site_id->id][4].'</td>';
   $pdf .= '<td class="bod-1 bg-y">'.$total_hours[$site_id->id][5].'</td>';
   $pdf .= '<td class="bod-1 bg-y">'.$total_hours[$site_id->id][6].'</td>';
   $pdf .= '<td class="bod-1 bg-y">'.($total_hours[$site_id->id][0] + $total_hours[$site_id->id][1] + $total_hours[$site_id->id][2]+ $total_hours[$site_id->id][3]+ $total_hours[$site_id->id][4]+ $total_hours[$site_id->id][5]+ $total_hours[$site_id->id][6]).'</td>';
   $pdf .= '</tr>';
   $total_hours[0] = array(
    0 => $total_hours[0][0] + $total_hours[$site_id->id][0],
    1 => $total_hours[0][1] + $total_hours[$site_id->id][1],
    2 => $total_hours[0][2] + $total_hours[$site_id->id][2],
    3 => $total_hours[0][3] + $total_hours[$site_id->id][3],
    4 => $total_hours[0][4] + $total_hours[$site_id->id][4],
    5 => $total_hours[0][5] + $total_hours[$site_id->id][5],
    6 => $total_hours[0][6] + $total_hours[$site_id->id][6],
    7 => $total_hours[0][7] + ($total_hours[$site_id->id][0] + $total_hours[$site_id->id][1] + $total_hours[$site_id->id][2]+ $total_hours[$site_id->id][3]+ $total_hours[$site_id->id][4]+ $total_hours[$site_id->id][5]+ $total_hours[$site_id->id][6])
);
}

if (count($sites) > 1 && ($total_hours[$site_id->id][0] + $total_hours[$site_id->id][1] + $total_hours[$site_id->id][2]+ $total_hours[$site_id->id][3]+ $total_hours[$site_id->id][4]+ $total_hours[$site_id->id][5]+ $total_hours[$site_id->id][6]) > 0) {

  $pdf .= '<tr>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '</tr>';
  $counter++;
}

}
if (count($sites) == 1) {
  $pdf .= '<tr>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '<td class="bod-1 bg-g"></td>';
  $pdf .= '</tr>';
}

$pdf .= '<tr>';
$pdf .= '<td class="bod-1">Total Hrs | Wages</td>';
$pdf .= '<td class="bod-1">'.$total_hours[0][0].'</td>';
$pdf .= '<td class="bod-1">'.$total_hours[0][1].'</td>';
$pdf .= '<td class="bod-1">'.$total_hours[0][2].'</td>';
$pdf .= '<td class="bod-1">'.$total_hours[0][3].'</td>';
$pdf .= '<td class="bod-1">'.$total_hours[0][4].'</td>';
$pdf .= '<td class="bod-1">'.$total_hours[0][5].'</td>';
$pdf .= '<td class="bod-1">'.$total_hours[0][6].'</td>';
$pdf .= '<td class="bod-1">'.$total_hours[0][7].'</td>';
$pdf .= '</tr>';
$pdf .= '<tr>';
$pdf .= '<td class="bod-1 bg-g"></td>';
$pdf .= '<td class="bod-1 bg-g"></td>';
$pdf .= '<td class="bod-1 bg-g"></td>';
$pdf .= '<td class="bod-1 bg-g"></td>';
$pdf .= '<td class="bod-1 bg-g"></td>';
$pdf .= '<td class="bod-1 bg-g"></td>';
$pdf .= '<td class="bod-1 bg-g"></td>';
$pdf .= '<td class="bod-1 bg-g"></td>';
$pdf .= '<td class="bod-1 bg-g"></td>';
$pdf .= '</tr>';

$pdf .='</table></tr>';

$pdf .='</table>';
// $pdf .='<div class="page-break"></div><table style="width:100%;">
// <tr>
// <td>
// <div style="text-align: center;" class="title">Guard Details</div>
// </td>
// </tr></table>
// <table style="width:100%;">
// <tr>
// <th class="bod-1">
// Guard name
// </th>
// <th class="bod-1">
// Guard Mob
// </th>
// <th class="bod-1">
// Suburb
// </th>
// <th class="bod-1">
// Security License
// </th>
// <th class="bod-1">
// Security License Expiry
// </th>
// </tr>
// ';
// foreach ($guards_array as $key => $guard) {
//    $pdf .='<tr>
//    <td class="bod-1">'.$guard['name'].'</td>
//    <td class="bod-1">'.$guard['phone'].'</td>
//    <td class="bod-1">'.$guard['suburb'].'</td>
//    <td class="bod-1">'.$guard['security_license_number'].'</td>
//    <td class="bod-1">'.$guard['security_license_expiration'].'</td>
//    </tr>';
// }
$pdf .= '</table>';
if ($key <= count($customers)) {
    $pdf .= '<div class="page-break"></div>';
}
}
$pdf .= '</div>
</div></body></html>';
$pdf_data = $pdf;
// return View('admin/report/excel',compact('pdf_data'));
echo $pdf;
exit();
$pdf_data = PDF::loadView('reports/rosterReport', ['data' => $pdf]);
$pdf_data->setPaper('A4', 'landscape');
return $pdf_data->stream(date('d/m/Y').'_roster_acticity_report.pdf');
// echo $pdf;
}
public function generate_audit_report_pdf($id){
    $data = DB::table('audit_form')
    ->join('jobs', 'jobs.id','=','audit_form.site_id')
    ->join('administrators', 'administrators.id','=','audit_form.admin_id')
    ->where('audit_form.id', $id)
    ->select('audit_form.*', 'jobs.address', 'jobs.site_name', 'jobs.site_description', 'administrators.name as audit_by')->first();
    $pdf_data = PDF::loadView('reports/auditReport', ['data' => $data]);
    return $pdf_data->stream($data->guard_name.'audit_report.pdf');


}

function generate_incident_report_pdf_new(Request $request, $id)
  {
    $report = DB::table('incident_reports')
    ->join('guards', 'guards.id', '=', 'incident_reports.guard_id')
    ->join('jobs', 'jobs.id','=','incident_reports.job_id')
    ->join('customers', 'customers.id','=','jobs.customer_id')
    ->join('job_new_roster', 'job_new_roster.roster_id', '=', 'incident_reports.roster_id')
    ->where('incident_reports.id', $id)->select('customers.name as customers_name','incident_reports.*', 'guards.name as guard_name', 'guards.phone', 'jobs.address', 'jobs.site_name', 'jobs.site_description', 'job_new_roster.job_start', 'job_new_roster.job_end')->first();

    $pdf_data = '<!DOCTYPE html>
    <html><head>
    <style>
    .bod{
      font-size: 14px;
      line-height: 1.42857143;
      color: #333;
      background-color: #fbfbfb;
    }
    .container-fluid{
      padding-right: 15px;
      padding-left: 15px;
      margin-right: auto;
      margin-left: auto;
    }
    .title{
      font-size: 25px;
      color:#000;
    }
    td{
      padding: 5px 0px;
    }
    strong{
    font-size: 16px;
    }
    th{
      text-align:left;
    }
    .bod-1{
      border:1px solid #000;
      text-align:left;

    }
    </style>
    </head><body class="bod">
    <div class="container-fluid">
    <div class="row">
    <table style="width:100%;">
    <tr>
    <td>
    <div>
    <div style="text-align: center;" class="title">'.$report->customers_name.' Foot Patrol Report</div>
    <div style="text-align: center;" class="title">'.$report->site_name.' Foot Patrol Report</div>
    </div>
    </td>
    </tr>
    </table>
    <table style="width:100%;">
    <tr>
    <td>
    <div>
    <strong>Foot Patrol Date:</strong> '.date('d-m-Y', strtotime($report->incident_date)).'
    </div>
    </td>
    <td>
    <div>
    <strong>Selected Time of Foot Patrol:</strong> '.date('H:i:s', strtotime($report->incident_time)).'
    </div>
    </td>
    </tr>
    </table>';
    if($report->site_name != '')
    {
      $report->site_name = $report->site_name;
    }

    if($report->site_description != '')
    {
      $report->site_name .= ' ('. $report->site_description. ')';
    }
    $pdf_data .= '<table style="width:100%;">
    <tr>
    <td>
    <div>
    <strong>Site Name:</strong> '.$report->site_name.'
    </div>
    </td>
    <td>
    <div>
    <strong>Location of Incident:</strong> '.$report->address.'
    </div>
    </td>
    </tr>
    </table>
    <table style="width:100%;">
    <tr>
    <td>
    <div>
    <strong>Name of Guard:</strong> '.$report->guard_name.'
    </div>
    </td>
    <td>
    <div>
    <strong>Job Start:</strong> '.date('d-m-Y H:i', $report->job_start).'
    </div>
    </td>
    <td>
    <div>
    <strong>Job End:</strong> '.date('d-m-Y H:i', $report->job_end).'
    </div>
    </td>
    </tr>
    <tr>
    <td>
    <div>
    <strong>Patrol Start Time :</strong> '.$report->incident_time.'
    </div>
    </td>
    <td>
    <div>
    <strong>Patrol End Time:</strong> '.\Carbon\Carbon::parse($report->created_at)->format('H:i').'
    </div>
    </td>
    </tr>
    <tr>
    <td>
    <div>
    <strong>Submission Time</strong> '.\Carbon\Carbon::parse($report->created_at)->format('H:i').'
    </div>
    </td>
    <td>
    <div>
    <strong>Incident Type:</strong> '.$report->injury_type.'
    </div>
    </td>
    <tr>
    <td>
    </td>
    </tr>
    </table>
    <table style="width:100%;">
    <tr>
    <td style="width:20%;">
    <div>
    <strong>Contact Details:</strong> '.$report->phone.'
    </div>
    </td>
    </tr>
    </table>
    <table style="width:100%;">
    <tr>
    <td style="width:20%;">
    <div>
    <strong>Incident Details:</strong> '.$report->injury_detail.'
    </div>
    </td>
    </tr>
    </table>';
    $people_involved = json_decode($report->people_involved, true);
   
   $pdf_data .='<table style="width:100%;">
    <tr>
    <td style="width:20%;">
    <div>
    <strong>People Involved : '.(!empty($people_involved) ? '' : "N/A").'</strong>
    </div>
    </td>
    </tr>
    </table>';
    if (!empty($people_involved)) {
      $pdf_data .='<table style="width:100%;">
    <tr>
    <th class="bod-1">Name</th>
    <th class="bod-1">Phone</th>
    <th class="bod-1">Body Type</th>
    <th class="bod-1">Gender</th>
    <th class="bod-1">Hair</th>
    <th class="bod-1">Height</th>
    <th class="bod-1">Weight</th>
    <th class="bod-1">Marks</th>
    <th class="bod-1">Tattoos</th>
    </tr>
    ';
       foreach ($people_involved as $pi) {
        $pdf_data .= '<tr>
          <td class="bod-1">'.$pi['name'].'</td>
          <td class="bod-1">'.$pi['phone'].'</td>
          <td class="bod-1">'.$pi['bodyType'].'</td>
          <td class="bod-1">'.$pi['gender'].'</td>
          <td class="bod-1">'.$pi['hair'].'</td>
          <td class="bod-1">'.$pi['height'].'</td>
          <td class="bod-1">'.$pi['weight'].'</td>
          <td class="bod-1">'.$pi['marks'].'</td>
          <td class="bod-1">'.$pi['tattoos'].'</td>
          </tr>';
    }
    $pdf_data .= '</table>';
    }


  $vehicle = json_decode($report->vehicle, true);
   
   $pdf_data .='<table style="width:100%;">
    <tr>
    <td style="width:20%;">
    <div>
    <strong>Vehicle : '.(!empty($vehicle) ? '' : "N/A").'</strong>
    </div>
    </td>
    </tr>
    </table>';
    if (!empty($vehicle)) {
      $pdf_data .='<table style="width:100%;">
    <tr>
    <th class="bod-1">Make</th>
    <th class="bod-1">Model</th>
    <th class="bod-1">Vehicle Type</th>
    <th class="bod-1">Reg. number</th>
    </tr>
    ';
       foreach ($vehicle as $v) {
        $pdf_data .= '<tr>
          <td class="bod-1">'.$v['make'].'</td>
          <td class="bod-1">'.$v['model'].'</td>
          <td class="bod-1">'.$v['vehicle_type'].'</td>
          <td class="bod-1">'.$v['rego_number'].'</td>
          </tr>';
    }
    $pdf_data .= '</table>';
    }

    $emergency_services = json_decode($report->emergency_services, true);
   
   $pdf_data .='<table style="width:100%;">
    <tr>
    <td style="width:20%;">
    <div>
    <strong>Emergency Services : '.(!empty($emergency_services) ? '' : "N/A").'</strong>
    </div>
    </td>
    </tr>
    </table>';
    if (!empty($emergency_services)) {
      $pdf_data .='<table style="width:100%;">
    <tr>
    <th class="bod-1">Details</th>
    </tr>
    ';
       foreach ($emergency_services as $es) {
        $pdf_data .= '<tr>
          <td class="bod-1">'.(isset($es['emergency_detail']) ? $es['emergency_detail'] : '--').'</td>
          </tr>';
    }
    $pdf_data .= '</table>';
    }

  $wittness = json_decode($report->wittness, true);
   
   $pdf_data .='<table style="width:100%;">
    <tr>
    <td style="width:20%;">
    <div>
    <strong>Witness : '.(!empty($wittness) ? '' : "N/A").'</strong>
    </div>
    </td>
    </tr>
    </table>';
    if (!empty($wittness)) {
      $pdf_data .='<table style="width:100%;">
    <tr>
    <th class="bod-1">Witness</th>
    <th class="bod-1">Witness details</th>
    <th class="bod-1">Witness name</th>
    <th class="bod-1">Witness address</th>
    <th class="bod-1">Witness email</th>
    <th class="bod-1">Witness phone</th>
    <th class="bod-1">More details</th>
    </tr>
    ';
       foreach ($wittness as $w) {
        $pdf_data .= '<tr>
          <td class="bod-1">'.$w['wittness'].'</td>
          <td class="bod-1">'.$w['wittness_detail'].'</td>
          <td class="bod-1">'.$w['wittness_name'].'</td>
          <td class="bod-1">'.$w['wittness_address'].'</td>
          <td class="bod-1">'.$w['wittness_email'].'</td>
          <td class="bod-1">'.$w['wittness_phone'].'</td>
          <td class="bod-1">'.$w['more_info'].'</td>
          </tr>';
    }
    $pdf_data .= '</table>';
    }

  

    $pdf_data .=' <table style="width:100%;">
    <tr>
    <td>
    <div>
    <strong>Guard Name:</strong> '.$report->guard_name.'
    </div>
    <div>
    <strong>Signature:</strong>';
    if($report->signature != ''){
    $pdf_data .= '<img class="navbar-brand-logo" src="'.config('custom.asset_url').$report->signature.'" title="247 staffing solution" height="50">';
    }

    $pdf_data .='</div>
    </td>
    </tr>
    </table>
    <table style="width:100%;">
    <tr><td>
    <div style="text-align: center;">';

    if($report->photo != ''){
      $images = json_decode($report->photo , true);
      if (is_array($images)) {
        foreach ($images as $key => $value) {
          $pdf_data .= '<img class="navbar-brand-logo" src="'.config('custom.asset_url').$value.'" title="247 staffing solution" height="300">';
        }
      }else{
        $pdf_data .= '<img class="navbar-brand-logo" src="'.config('custom.asset_url').$report->image.'" title="247 staffing solution" height="300">';
      }
      
      }

      $pdf_data .='</div>
    </td></tr></table></div>
    </div>
    </body></html>';
    // echo $pdf_data;
    // exit();
    $pdf_data = PDF::loadView('reports/rosterReport', ['data' => $pdf_data]);
    // $pdf_data->setPaper('A4', 'landscape');
    return $pdf_data->stream(date('d/m/Y').'_incident_report.pdf');
    
  }
  function generate_foot_patrol_report_pdf_new(Request $request, $id)
  {
    $report = DB::table('foot_patrol_reports')
    ->join('guards', 'guards.id', '=', 'foot_patrol_reports.guard_id')
    ->join('jobs', 'jobs.id','=','foot_patrol_reports.job_id')
    ->join('customers', 'customers.id','=','jobs.customer_id')
    ->join('job_new_roster', 'job_new_roster.roster_id', '=', 'foot_patrol_reports.roster_id')
    ->where('foot_patrol_reports.id', $id)->select('customers.name as customers_name','foot_patrol_reports.*', 'guards.name as guard_name', 'guards.phone', 'jobs.address', 'jobs.site_name', 'jobs.site_description', 'job_new_roster.job_start', 'job_new_roster.job_end')->first();

    $pdf_data = '<!DOCTYPE html>
    <html><head>
    <style>
    .bod{
      font-size: 14px;
      line-height: 1.42857143;
      color: #333;
      background-color: #fbfbfb;
    }
    .container-fluid{
      padding-right: 15px;
      padding-left: 15px;
      margin-right: auto;
      margin-left: auto;
    }
    .title{
      font-size: 25px;
      color:#000;
    }
    td{
      padding: 5px 0px;
    }
    strong{
    font-size: 16px;
    }
    th{
      text-align:left;
    }
    .bod-1{
      border:1px solid #000;
      text-align:left;

    }
    </style>
    </head><body class="bod">
    <div class="container-fluid">
    <div class="row">
    <table style="width:100%;">
    <tr>
    <td>
    <div>
    <div style="text-align: center;" class="title">'.$report->customers_name.' Foot Patrol Report</div>
    <div style="text-align: center;" class="title">'.$report->site_name.' Foot Patrol Report</div>
    </div>
    </td>
    </tr>
    </table>
    <table style="width:100%;">
    <tr>
    <td>
    <div>
    <strong>Foot Patrol Date:</strong> '.date('d-m-Y', strtotime($report->created_at)).'
    </div>
    </td>
    <td>
    <div>
    <strong>Selected Time of Foot Patrol:</strong> '.date('H:i', strtotime($report->created_at)).'
    </div>
    </td>
    </tr>
    </table>';
    if($report->site_name != '')
    {
      $report->site_name = $report->site_name;
    }

    if($report->site_description != '')
    {
      $report->site_name .= ' ('. $report->site_description. ')';
    }
    $pdf_data .= '<table style="width:100%;">
    <tr>
    <td>
    <div>
    <strong>Site Name:</strong> '.$report->site_name.'
    </div>
    </td>
    <td>
    <div>
    <strong>Location:</strong> '.$report->address.'
    </div>
    </td>
    </tr>
    </table>
    <table style="width:100%;">
    <tr>
    <td>
    <div>
    <strong>Name of Guard:</strong> '.$report->guard_name.'
    </div>
    </td>
    <td>
    <div>
    <strong>Job Start:</strong> '.date('d-m-Y H:i', $report->job_start).'
    </div>
    </td>
    <td>
    <div>
    <strong>Job End:</strong> '.date('d-m-Y H:i', $report->job_end).'
    </div>
    </td>
    </tr>
    <tr>
    <td>
    <div>
    <strong>Patrol Start Time :</strong> '.\Carbon\Carbon::parse($report->clicked_at)->format('H:i').'
    </div>
    </td>
    <td>
    <div>
    <strong>Patrol End Time:</strong> '.\Carbon\Carbon::parse($report->created_at)->format('H:i').'
    </div>
    </td>
    </tr>
    <tr>
    <td>
    <div>
    <strong>Submission Time</strong> '.\Carbon\Carbon::parse($report->created_at)->format('H:i').'
    </div>
    </td>
    <tr>
    <td>
    </td>
    </tr>
    </table>
    <table style="width:100%;">
    <tr>
    <td style="width:20%;">
    <div>
    <strong>Contact Details:</strong> '.$report->phone.'
    </div>
    </td>
    </tr>
    </table>
    <table style="width:100%;">
    <tr>
    <td style="width:20%;">
    <div>
    <strong>Patrol Details:</strong> '.$report->patrolling_detail.'
    </div>
    </td>
    </tr>
    </table>';

  

    $pdf_data .=' <table style="width:100%;">
    <tr>
    <td>
    <div>
    <strong>Guard Name:</strong> '.$report->guard_name.'
    </div>
    <div>
    <strong>Signature:</strong>';
    if($report->signature != ''){
    $pdf_data .= '<img class="navbar-brand-logo" style="margin-top:50px" src="'.config('custom.asset_url').$report->signature.'" title="247 staffing solution" height="50">';
    }

    $pdf_data .='</div>
    </td>
    </tr>
    </table>
    <table style="width:100%;">
    <tr><td>
    <div style="text-align: center;">';

    if($report->photo != ''){
      $images = json_decode($report->photo , true);
      if (is_array($images)) {
        foreach ($images as $key => $value) {
          $pdf_data .= '<img class="navbar-brand-logo" src="'.config('custom.asset_url').$value['imgPath'].'" title="247 staffing solution" height="300">';
        }
      }else{
        $pdf_data .= '<img class="navbar-brand-logo" src="'.config('custom.asset_url').$report->image.'" title="247 staffing solution" height="300">';
      }
      
      }

      $pdf_data .='</div>
    </td></tr></table></div>
    </div>
    </body></html>';
    // echo $pdf_data;
    // exit();
    $pdf_data = PDF::loadView('reports/rosterReport', ['data' => $pdf_data]);
    // $pdf_data->setPaper('A4', 'landscape');
    return $pdf_data->stream(date('d/m/Y').'_foot_patrol_report.pdf');
    
  }
  function calculateBreakTiming($morning, $night, $breakTime1, $breakTime2)
  {
    if ($morning == 0 || $night == 0) {
        if ($morning == 0) {
            return array(
                0 => 0,
                1 => $night - $breakTime1 - $breakTime2
            ); 
        }else{
            return array(
                0 => $morning - $breakTime1 - $breakTime2,
                1 => 0
            );
        }
    }else{
        if ($morning > $night) {
            return array(
                0 => $morning - $breakTime1,
                1 => $night - $breakTime2,
            );
        }elseif ($morning < $night) {
            return array(
                0 => $night - $breakTime1,
                1 => $morning - $breakTime2,
            );
        }else {
            return array(
                0 => $morning - $breakTime1,
                1 => $night - $breakTime2,
            );
        }
    }
  }

  function guard_paysheet_report(Request $request)
  {
    if ($request->has('search') && $request->search != '') {
        $date = $request->search;
        $date = explode('-', $date);
        $from = strtotime(trim($date[0]));
        $to = strtotime(trim($date[1]));
    }else{
    $to = time();
    $from = time() - (60*60*24*14);
    }
    $roster_guards = DB::table('job_new_roster')
    ->join('guards', 'guards.id' , '=', 'job_new_roster.guard_id')
    ->where('job_new_roster.temp_date', '>=', date('Y-m-d', $from))
    ->where('job_new_roster.temp_date', '<=', date('Y-m-d', $to))
    // ->where('job_status', 'completed')
    ->where(function($query) {
            $query->where('job_status', 'completed');
            // $query->orWhere('job_status', 'pending');
            // $query->orWhere('job_status', 'confirmed');
            $query->orWhere('status_change_by', '>', 0);
        })
    ->orderBy('guards.name', 'ASC')
    ->select('job_new_roster.guard_id')->groupBy('guard_id')->get();

    $guard_paysheet = array();
    foreach ($roster_guards as $key => $guard) {
        $temp1 = DB::table('job_new_roster')
        ->join('guards', 'guards.id' , '=', 'job_new_roster.guard_id')
        ->leftJoin('guard_payroll_ids', 'guard_payroll_ids.guard_id', '=', 'guards.id')
        ->join('jobs', 'jobs.id' , '=', 'job_new_roster.site_id')
        ->where('job_new_roster.temp_date', '>=', date('Y-m-d', $from))
        ->where('job_new_roster.temp_date', '<=', date('Y-m-d', $to))
        ->where('job_new_roster.guard_id', '>', 0)
        // ->where('job_new_roster.job_status', 'completed')
        ->where('job_new_roster.guard_id', $guard->guard_id);
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
// 
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

        $guard_roster = $temp1->select('job_new_roster.payrate_applied', 'job_new_roster.hours','job_new_roster.overtime_value', 'guard_payroll_ids.payroll_id AS guard_payroll_id', 'job_new_roster.payrate_id', 'job_new_roster.site_id','job_new_roster.job_start', 'job_new_roster.job_end', 'guards.payrates_id as guard_payrate_id', 'jobs.level', 'jobs.stateType', 'jobs.payrol', 'guards.name','guards.phone', 'guards.bsb', 'guards.payroll_bank_account_number', 'guards.payroll_tfn_number', 'jobs.site_payrate', 'jobs.state', 'job_new_roster.roster_id', 'job_new_roster.temp_start', 'job_new_roster.temp_end', 'guards.payroll_abn_number', 'jobs.payrol', 'jobs.payable', 'jobs.payable_and_chargeable_time', 'jobs.apply_date', 'job_new_roster.temp_date', 'job_new_roster.temp_start', 'job_new_roster.site_id', 'job_new_roster.custom_payrate')
        ->where(function($query) {
            $query->where('job_new_roster.job_status', 'completed');
            // $query->orWhere('job_new_roster.job_status', 'pending');
            // $query->orWhere('job_new_roster.job_status', 'confirmed');
            $query->orWhere('status_change_by', '>', 0);
        })
        ->orderBY('job_new_roster.temp_start', 'ASC')
        ->get();
        foreach ($guard_roster as $key => $roster) {
            $job_hours = $this->getShiftHours(date('m/d/Y H:i', strtotime($roster->temp_start)), date('m/d/Y H:i', strtotime($roster->temp_end)));
            $job_hours['morning'] = $this->convertIntoWhole($job_hours['morning']);
            $job_hours['night'] = $this->convertIntoWhole($job_hours['night']);
            $job_hours['saturday_morning'] = $this->convertIntoWhole($job_hours['saturday_morning']);
            $job_hours['saturday_night'] = $this->convertIntoWhole($job_hours['saturday_night']);
            $job_hours['sunday_morning'] = $this->convertIntoWhole($job_hours['sunday_morning']);
            $job_hours['sunday_night'] = $this->convertIntoWhole($job_hours['sunday_night']);
            $job_hours['ph_morning'] = $this->convertIntoWhole($job_hours['ph_morning']);
            $job_hours['ph_night'] = $this->convertIntoWhole($job_hours['ph_night']);
            $roster->hours = $job_hours['morning'] + $job_hours['night'] + $job_hours['saturday_morning'] + $job_hours['saturday_night'] + $job_hours['sunday_morning'] + $job_hours['sunday_night'] + $job_hours['ph_morning'] + $job_hours['ph_night'];
            // $job_hours['shift_start'] = $roster->temp_start;
            // $job_hours['shift_end'] = $roster->temp_end;
            $roster->day_night = $job_hours;
            $rate = 0;
            $day_rate = 0;
            $night_rate = 0;
            $saturday_day_rate = 0;
            $saturday_night_rate = 0;
            $sunday_day_rate = 0;
            $sunday_night_rate = 0;
            $ph_day_rate = 0;
            $ph_night_rate = 0;
if (config('custom.own_payrates') == 0) {
    if ($roster->payrate_id > 0 && $roster->payrate_id != null) {
                $pay_rate = DB::table('payrates')->where('id', $roster->payrate_id)->where('archive', 0)->first();
            }elseif($roster->site_payrate > 0){

               $pay_rate = DB::table('payrates')->where('archive', 0)->where('id', $roster->site_payrate)->first();
               if ($roster->apply_date != '') {
            if (strtotime($roster->apply_date) <= strtotime($roster->temp_start)) {
              $pay_rate = DB::table('payrates')->where('archive', 0)->where('id', $roster->site_payrate)->first();
            } else {
              $old_payrate = DB::table('site_payrate_history')
              ->where('site_id', $roster->site_id)
              ->where('apply_date', '<=', strtotime($roster->temp_start))
              ->where('apply_to_date', '>=', strtotime($roster->temp_start))
              ->orderBy('apply_date', 'desc')->first();
              if (!empty($old_payrate)) {
                $pay_rate = DB::table('payrates')->where('archive', 0)->where('id', $old_payrate->payrate_id)->first();
              }
            }
          } else {
            $pay_rate = DB::table('payrates')->where('archive', 0)->where('id', $roster->site_payrate)->first();
          }
            }elseif($roster->guard_payrate_id > 0){
                $pay_rate = DB::table('payrates')->where('archive', 0)->where('id', $roster->guard_payrate_id)->first();
            }else{
                // $pay_rate = DB::table('payrates')->where('archive', 0)->where('id', $roster->site_payrate)->first();
               $pay_rate = array();
            }
            // if ($roster->payrate_applied != '') {
            //     $pay_rate = json_decode($roster->payrate_applied);
            // }else{
            // if ($roster->payrate_id > 0) {
            //     $pay_rate = DB::table('payrates')->where('archive', 0)->where('id', $roster->payrate_id)->first();
            // }elseif($roster->site_payrate > 0){
            //     $pay_rate = DB::table('payrates')->where('archive', 0)->where('id', $roster->site_payrate)->first();
            // }elseif($roster->guard_payrate_id > 0){
            //     $pay_rate = DB::table('payrates')->where('archive', 0)->where('id', $roster->guard_payrate_id)->first();
            // }else{
            //     // $pay_rate = DB::table('payrates')->where('archive', 0)->where('id', $roster->site_payrate)->first();
            //     $pay_rate = array();
            // }
            // }
        }else{
            if(config('custom.own_payrates') == 1 && $roster->own_payrate == 'custom')
      {
        $pay_rate = json_decode($roster->custom_payrate);
        $pay_rate->ot_base_rate = 22.84;
      }else{
                $guard_payrate = DB::table('guard_payrates')->where('guard_id', $roster->guard_id)->first();
              if (!empty($guard_payrate)) {
                $pay_rate = json_decode($guard_payrate->payrate);
                $pay_rate->ot_base_rate = 22.84;
              }else{
                $pay_rate = array();
              }
            }
        }

            if (!empty($pay_rate)) {
                if ($roster->payrol == 'Default Rates') {
                    if ($roster->stateType == 'metropolitan') {
                        $rate= $pay_rate->flat_metro_week_day_day;
                        $day_rate = $pay_rate->flat_metro_week_day_day;
                        $night_rate = $pay_rate->flat_metro_week_day_night;

                        $sunday_day_rate = $pay_rate->flat_metro_sunday;
                        $sunday_night_rate = $pay_rate->flat_metro_sunday_night;
                        $saturday_day_rate = $pay_rate->flat_metro_saturday;
                        $saturday_night_rate = $pay_rate->flat_metro_saturday_night;
                        $ph_day_rate = $pay_rate->flat_metro_public_holiday;
                        $ph_night_rate = $pay_rate->flat_metro_public_holiday_night;
                    }else{
                        $rate= $pay_rate->flat_regional_week_day_day;
                        $day_rate = $pay_rate->flat_regional_week_day_day;
                        $night_rate = $pay_rate->flat_regional_week_day_night;

                        $sunday_day_rate = $pay_rate->flat_regional_sunday;
                        $sunday_night_rate = $pay_rate->flat_regional_sunday_night;
                        $saturday_day_rate = $pay_rate->flat_regional_saturday;
                        $saturday_night_rate = $pay_rate->flat_regional_saturday_night;
                        $ph_day_rate = $pay_rate->flat_regional_public_holiday;
                        $ph_night_rate = $pay_rate->flat_regional_public_holiday_night;
                    }
                }else{
                    if ($roster->stateType == 'metropolitan') {
                        $rate= $pay_rate->eba_metro_weekday_day;
                        $day_rate = $pay_rate->eba_metro_weekday_day;
                        $night_rate = $pay_rate->eba_metro_weekday_night;

                        $sunday_day_rate = $pay_rate->eba_metro_sunday_day;
                        $sunday_night_rate = $pay_rate->eba_metro_sunday_day;
                        $saturday_day_rate = $pay_rate->eba_metro_saturday_day;
                        $saturday_night_rate = $pay_rate->eba_metro_saturday_night;
                        $ph_day_rate = $pay_rate->eba_metro_public_holiday;
                        $ph_night_rate = $pay_rate->eba_metro_public_holiday_night;
                    }else{
                        $rate= $pay_rate->eba_regional_weekday_day;
                        $day_rate = $pay_rate->eba_regional_weekday_day;
                        $night_rate = $pay_rate->eba_regional_weekday_night;

                        $sunday_day_rate = $pay_rate->eba_regional_sunday_day;
                        $sunday_night_rate = $pay_rate->eba_regional_sunday_night;
                        $saturday_day_rate = $pay_rate->eba_regional_saturday_day;
                        $saturday_night_rate = $pay_rate->eba_regional_saturday_night;
                        $ph_day_rate = $pay_rate->eba_regional_public_holiday;
                        $ph_night_rate = $pay_rate->eba_regional_public_holiday_night;
                    }
                }
            }
            $rate = $roster->overtime_value * $rate;
            $day_rate = $roster->overtime_value * $day_rate;
            $night_rate = $roster->overtime_value * $night_rate;
            $sunday_day_rate = $roster->overtime_value * $sunday_day_rate;
            $sunday_night_rate = $roster->overtime_value * $sunday_night_rate;
            $saturday_day_rate = $roster->overtime_value * $saturday_day_rate;
            $saturday_night_rate = $roster->overtime_value * $saturday_night_rate;
            $ph_day_rate = $roster->overtime_value * $ph_day_rate;
            $ph_night_rate = $roster->overtime_value * $ph_night_rate;

            $break_deduction_time = 0;
            $break_deduction_amount = 0;
            if ($roster->payable == 'no') {
                $break_deduction_time = $roster->payable_and_chargeable_time / 60;
                // $break_deduction_amount = $break_deduction_amount * $rate;
                if ($break_deduction_time > 0 && $break_deduction_time <= 0.25) {
                  $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[0];
                }elseif ($break_deduction_time > 0.25 && $break_deduction_time <= 0.5) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0.25);
                    $job_hours['morning'] = $breakCal[0];
                    $job_hours['night'] = $breakCal[0];
                }elseif ($break_deduction_time > 0.5 && $break_deduction_time <= 0.75) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.25);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[0];
                }elseif ($break_deduction_time > 0.75 && $break_deduction_time <= 1) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.5);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[0];
                }
                // if ($job_hours['morning'] > $break_deduction_time) {
                //     $job_hours['morning'] = $job_hours['morning'] - $break_deduction_time;
                // }else{
                //     $job_hours['night'] = $job_hours['night'] - $break_deduction_time;
                // }
            }
            if (!isset($guard_paysheet[$guard->guard_id])) {
                $guard_paysheet[$guard->guard_id] = array(
                    'guard_id' => $guard->guard_id, 
                    'name' => $roster->name,
                    'break_deduction_amount' => $break_deduction_amount,
                    'phone' => $roster->phone, 
                    'tfn' => $roster->payroll_tfn_number, 
                    // 'pay' =>  $roster->hours * $rate,
                    'pay' =>  ($job_hours['morning'] * $day_rate) + ($job_hours['night'] * $night_rate) + ($job_hours['saturday_morning'] * $saturday_day_rate) + ($job_hours['saturday_night'] * $saturday_night_rate) + ($job_hours['sunday_morning'] * $sunday_day_rate) + ($job_hours['sunday_night'] * $sunday_night_rate) + ($job_hours['ph_morning'] * $ph_day_rate) + ($job_hours['ph_night'] * $ph_night_rate) - $break_deduction_amount,
                    // 'day_pay' => $job_hours['morning'] * $day_rate,
                    'night_pay' => $job_hours['night'] * $night_rate,
                    'bsb' => $roster->bsb != '' ? $roster->bsb : 'N/A',
                    'bank' => $roster->payroll_bank_account_number != '' ? $roster->payroll_bank_account_number : 'N/A',
                    'day' => $job_hours['morning'],
                    'day_pay' => $job_hours['morning'] * $day_rate,
                    'night' => $job_hours['night'],
                    'night_pay' => $job_hours['night'] * $night_rate,
                    'total_hours' => $roster->hours - $break_deduction_time,
                    // 'total_hours' => $job_hours['morning'] + $job_hours['night'],
                    'rate' => $rate,
                    'saturday' => $job_hours['saturday_morning'] + $job_hours['saturday_night'],
                    'saturday_pay' => $job_hours['saturday_morning'] * $saturday_day_rate + $job_hours['saturday_night'] * $saturday_night_rate,
                    'sunday' => $job_hours['sunday_morning'] + $job_hours['sunday_night'],
                    'sunday_pay' => $job_hours['sunday_morning'] * $sunday_day_rate + $job_hours['sunday_night'] * $sunday_night_rate,
                    'ph' => $job_hours['ph_morning'] + $job_hours['ph_night'],
                    'ph_pay' => $job_hours['ph_morning'] * $ph_day_rate + $job_hours['ph_night'] * $ph_night_rate,
                    'guard_payroll_id'=>$roster->guard_payroll_id,
                    'from' => date('Y-m-d H:i', $from),
                    'to' => date('Y-m-d H:i', $to),
                    'payroll_abn_number' => $roster->payroll_abn_number != '' ? $roster->payroll_abn_number : "N/A", 
                    // 'pay_rate' => $pay_rate
                );
                 $guard_paysheet[$guard->guard_id]['hours'][] = $job_hours; 
            }else{
                 // $guard_paysheet[$guard->guard_id]['pay'] = $guard_paysheet[$guard->guard_id]['pay'] + $roster->hours * $rate;
                 // $guard_paysheet[$guard->guard_id]['pay'] = $guard_paysheet[$guard->guard_id]['pay'] + (($job_hours['morning'] * $day_rate) + ($job_hours['night'] * $night_rate)) - $break_deduction_amount;
                $guard_paysheet[$guard->guard_id]['break_deduction_amount'] = $guard_paysheet[$guard->guard_id]['break_deduction_amount'] + $break_deduction_amount;
                $guard_paysheet[$guard->guard_id]['pay'] = $guard_paysheet[$guard->guard_id]['pay'] + ($job_hours['morning'] * $day_rate) + ($job_hours['night'] * $night_rate) + ($job_hours['saturday_morning'] * $saturday_day_rate) + ($job_hours['saturday_night'] * $saturday_night_rate) + ($job_hours['sunday_morning'] * $sunday_day_rate) + ($job_hours['sunday_night'] * $sunday_night_rate) + ($job_hours['ph_morning'] * $ph_day_rate) + ($job_hours['ph_night'] * $ph_night_rate) - $break_deduction_amount;
                 $guard_paysheet[$guard->guard_id]['day_pay'] = $guard_paysheet[$guard->guard_id]['day_pay'] + ($job_hours['morning'] * $day_rate);
                 $guard_paysheet[$guard->guard_id]['night_pay'] = $guard_paysheet[$guard->guard_id]['night_pay'] + ($job_hours['night'] * $night_rate);
                 $guard_paysheet[$guard->guard_id]['day'] = $guard_paysheet[$guard->guard_id]['day'] + $job_hours['morning'];
                 $guard_paysheet[$guard->guard_id]['night'] = $guard_paysheet[$guard->guard_id]['night'] + $job_hours['night'];
                 // $guard_paysheet[$guard->guard_id]['night_pay'] = $guard_paysheet[$guard->guard_id]['night_pay'] + $job_hours['night'] * $night_rate;

                 $guard_paysheet[$guard->guard_id]['saturday'] = $guard_paysheet[$guard->guard_id]['saturday'] + $job_hours['saturday_morning'] + $job_hours['saturday_night'];
                 $guard_paysheet[$guard->guard_id]['saturday_pay'] = $guard_paysheet[$guard->guard_id]['saturday_pay'] + $job_hours['saturday_morning'] * $saturday_day_rate + $job_hours['saturday_night'] * $saturday_night_rate;
                 $guard_paysheet[$guard->guard_id]['sunday'] = $guard_paysheet[$guard->guard_id]['sunday'] + $job_hours['sunday_morning'] + $job_hours['sunday_night'];
                $guard_paysheet[$guard->guard_id]['sunday_pay'] = $guard_paysheet[$guard->guard_id]['sunday_pay'] +  $job_hours['sunday_morning'] * $sunday_day_rate + $job_hours['sunday_night'] * $sunday_night_rate;
                 $guard_paysheet[$guard->guard_id]['ph'] = $guard_paysheet[$guard->guard_id]['ph'] + $job_hours['ph_morning'] + $job_hours['ph_night'];
                 $guard_paysheet[$guard->guard_id]['ph_pay'] = $guard_paysheet[$guard->guard_id]['ph_pay'] + $job_hours['ph_morning'] * $ph_day_rate + $job_hours['ph_night'] * $ph_night_rate;

                 // $guard_paysheet[$guard->guard_id]['total_hours'] = $guard_paysheet[$guard->guard_id]['total_hours'] +$job_hours['morning'] + $job_hours['night'];
                 $guard_paysheet[$guard->guard_id]['total_hours'] = $guard_paysheet[$guard->guard_id]['total_hours'] + $roster->hours - $break_deduction_time;
                 $guard_paysheet[$guard->guard_id]['hours'][] = $job_hours; 

            }
            // $guard_paysheet[$guard->guard_id]['roster'] = $guard_roster;
        }
        $temp1 = DB::table('guard_annual_leaves')
        ->join('job_new_roster', 'job_new_roster.roster_id' , '=', 'guard_annual_leaves.roster_id')
        ->join('guards', 'guards.id' , '=', 'job_new_roster.guard_id')
        ->join('jobs', 'jobs.id' , '=', 'job_new_roster.site_id')
        ->where('job_new_roster.temp_date', '>=', date('Y-m-d', $from))
        ->where('job_new_roster.temp_date', '<=', date('Y-m-d', $to))
        ->where('job_new_roster.job_status', 'completed');
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
// 
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
        $guard_roster = $temp1->where('guard_annual_leaves.guard_id', $guard->guard_id)
        ->select('guard_annual_leaves.paid_hour as hours', 'job_new_roster.payrate_id','job_new_roster.temp_start', 'job_new_roster.temp_end',  'job_new_roster.site_id', 'guards.payrates_id as guard_payrate_id', 'jobs.level', 'jobs.stateType', 'jobs.payrol', 'guards.name', 'guards.bsb', 'guards.payroll_bank_account_number',  'guards.payroll_tfn_number', 'guards.payroll_abn_number', 'jobs.payable', 'jobs.payable_and_chargeable_time')->get();
        foreach ($guard_roster as $key => $roster) {
            $job_hours = $this->getShiftHours($roster->temp_start, $roster->temp_end);
            $rate = 0;
            $day_rate = 0;
            $night_rate = 0;
            if ($roster->payrate_id > 0) {
                $pay_rate = DB::table('payrates')->where('archive', 0)->where('id', $roster->payrate_id)->first();
            }else{
                $pay_rate = DB::table('payrates')->where('archive', 0)->where('id', $roster->guard_payrate_id)->first();
            }
            if (!empty($pay_rate)) {
                if ($roster->payrol == 'Default Rates') {
                    if ($roster->stateType == 'metropolitan') {
                        $rate = $pay_rate->flat_metro_week_day_day;
                        $day_rate = $pay_rate->flat_metro_week_day_day;
                        $night_rate = $pay_rate->flat_metro_week_day_night;
                    }else{
                        $rate = $pay_rate->flat_regional_week_day_day;
                        $day_rate = $pay_rate->flat_regional_week_day_day;
                        $night_rate = $pay_rate->flat_regional_week_day_night;
                    }
                }else{
                    if ($roster->stateType == 'metropolitan') {
                        $rate = $pay_rate->eba_metro_weekday_day;
                        $day_rate = $pay_rate->eba_metro_weekday_day;
                        $night_rate = $pay_rate->eba_metro_weekday_night;
                    }else{
                        $rate = $pay_rate->eba_regional_weekday_day;
                        $day_rate = $pay_rate->eba_regional_weekday_day;
                        $night_rate = $pay_rate->eba_regional_weekday_night;
                    }
                }
            }
            $break_deduction_time = 0;
            $break_deduction_amount = 0;
            if ($roster->payable == 'no') {
                $break_deduction_time = $roster->payable_and_chargeable_time / 60;
                // $break_deduction_amount = $break_deduction_amount * $rate;
                // if ($job_hours['morning'] > $break_deduction_time) {
                //     $job_hours['morning'] = $job_hours['morning'] - $break_deduction_time;
                // }else{
                //     $job_hours['night'] = $job_hours['night'] - $break_deduction_time;
                // }
                if ($break_deduction_time > 0 && $break_deduction_time <= 0.25) {
                  $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[0];
                }elseif ($break_deduction_time > 0.25 && $break_deduction_time <= 0.5) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0.25);
                    $job_hours['morning'] = $breakCal[0];
                    $job_hours['night'] = $breakCal[0];
                }elseif ($break_deduction_time > 0.5 && $break_deduction_time <= 0.75) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.25);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[0];
                }elseif ($break_deduction_time > 0.75 && $break_deduction_time <= 1) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.5);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[0];
                }
            }
            if (!isset($guard_paysheet[$guard->guard_id])) {
                $guard_paysheet[$guard->guard_id] = array(
                    'guard_id' => $guard->guard_id, 
                    'name' => $roster->name,
                    'phone' => $roster->phone, 
                    'pay' => ($job_hours['morning'] * $day_rate) + ($job_hours['night'] * $night_rate),
                    'day_pay' => $job_hours['morning'] * $day_rate,
                    'night_pay' => $job_hours['night'] * $night_rate,
                    'tfn' => $roster->payroll_tfn_number, 
                    'bsb' => $roster->bsb != '' ? $roster->bsb : 'N/A',
                    'bank' => $roster->payroll_bank_account_number != '' ? $roster->payroll_bank_account_number : 'N/A',
                    'day' => $job_hours['morning'],
                    'night' => $job_hours['night'],
                    'total_hours' => $roster->hours - $break_deduction_time,
                    'rate' => $rate,
                    'saturday' => 0,
                    'sunday' => 0,
                    'ph' => $job_hours['ph_day'] + $job_hours['ph_night'],
                    'payroll_abn_number' => $roster->payroll_abn_number != '' ? $roster->payroll_abn_number : 'N/A'
                );
            }else{
                 $guard_paysheet[$guard->guard_id]['pay'] = $guard_paysheet[$guard->guard_id]['pay'] + (($job_hours['morning'] * $day_rate) + ($job_hours['night'] * $night_rate));
                 $guard_paysheet[$guard->guard_id]['day_pay'] = $guard_paysheet[$guard->guard_id]['day_pay'] + ($job_hours['morning'] * $day_rate);
                 $guard_paysheet[$guard->guard_id]['night_pay'] = $guard_paysheet[$guard->guard_id]['night_pay'] + ($job_hours['night'] * $night_rate);
                 $guard_paysheet[$guard->guard_id]['day'] = $guard_paysheet[$guard->guard_id]['day'] + $job_hours['morning'];
                 $guard_paysheet[$guard->guard_id]['night'] = $guard_paysheet[$guard->guard_id]['night'] + $job_hours['night'];
                 $guard_paysheet[$guard->guard_id]['ph'] = $guard_paysheet[$guard->guard_id]['ph'] + $job_hours['ph_day'] + $job_hours['ph_night'];

                 $guard_paysheet[$guard->guard_id]['total_hours'] = $guard_paysheet[$guard->guard_id]['total_hours'] + $roster->hours - $break_deduction_time;
            }
        }
    }
    $new_data = array();
    foreach ($guard_paysheet as $key => $paysheet) {
        $paysheet['pay'] = '$'.$paysheet['pay'];
        $paysheet['day'] = number_format($paysheet['day'], 2, '.', '');
        $paysheet['night'] = number_format($paysheet['night'], 2, '.', '');
        $new_data[] = $paysheet;
    }
  //   array_multisort(array_map(function($element) {
  //     return $element['name'];
  // }, $new_data), SORT_ASC, $new_data);

    // usort($new_data, "cmp");
    $guard_paysheet = $new_data;
    if($request->check=="pdf"){
        return $guard_paysheet;
        
    }else{
        return response()->json(['success' => true, 'data' => $guard_paysheet]);    
    }
  }
  function cmp($a, $b)
{
        return strcmp($a["name"], $b["name"]);
}

  function generate_paysheet_pdf(Request $request){
    $from1='';
    $to1='';
    if ($request->has('search') && $request->search != '' ) {
        $date = $request->search;
        $date = explode('-', $date);
        $from1 = strtotime(trim($date[0]));
        $to1 = strtotime(trim($date[1]));
    }else{
    $to1 = time();
    $from1 = time() - (60*60*24*14);
    }
      $request->check="pdf";
      
    $report=$this->guard_paysheet_report($request);
    $pdf_data='';
   

    $pdf_data = '<!DOCTYPE html>
    <html><head>
    <style>
    .bod{
      font-size: 14px;
      line-height: 1.42857143;
      color: #333;
      background-color: #fbfbfb;
    }
    .container-fluid{
      padding-right: 15px;
      padding-left: 15px;
      margin-right: auto;
      margin-left: auto;
    }
    .title{
      font-size: 25px;
      color:#000;
    }
    td{
      padding: 5px 0px;
    }
    strong{
    font-size: 16px;
    }
    th{
      text-align:left;
    }
    .bod-1{
      border:1px solid #000;
      text-align:left;

    }
    .t1-head{
        background-color: #CC66FF;
    }
    .t2-head{
        background-color:#22FAFE;
    }
    .t3-head{
        background-color:#9FFF9D;

    }
    .gray-row{
        background-color:#8b8989;
    }
    </style>';
    if($request->type=="excel"){
        if (!empty($report)) {
    
            $pdf_data.= $this->excel_preview_paysheet($report);
        }
         }else{
    $pdf_data.='</head><body class="bod">
    <div class="container-fluid">
    <div class="row">
    <table style="width:100%;">
    <tr>
    <td>
    <div>
    <div style="text-align: center;"><img class="navbar-brand-logo" src="'.config('custom.logo').'" title="'.config('custom.title').'" height="50"></div>
    <div style="text-align: center;" class="title">'.strtoupper(config('custom.title')).' Paysheet Report</div>
    </div>
    </td>
    </tr>
    </table>
    <table style="width:100%;">
    <tr style="width:100%;" >
    <td>
    <div>
    <strong>Date :</strong>'.date('d-m-Y', $from1).' to '.date('d-m-Y',$to1).'
    </div>
    </td>
    </tr>
    <tr>
    <td style="width:100%;">
    <div style="text-align: center;">
    <strong >Detail View</strong>
    </div>
    </td>
    </tr>
    
    </table>';
 
    if (!empty($report)) {
       foreach ($report as $pi) {
           
     $pdf_data .='<table style="width:100%;">
     <tr>
     <td class="bod-1 t1-head">
     <div>
     <strong>Name</strong>
     </div>
     </td>
     <td  class="bod-1 t1-head">
     <div>
     <strong>BSB</strong>
     </div>
     </td>
     <td  class="bod-1 t1-head" >
     <div>
     <strong>A/C</strong>
     </div>
     </td>
     <td  class="bod-1 t1-head" >
     <div>
     <strong>Tax File - ABN</strong>
     </div>
     </td>
     
     </tr>
     <tr>
   <td class="bod-1 t2-head">'.$pi['name'].'</td>
   <td class="bod-1 t2-head">'.$pi['bsb'].'</td>
   <td class="bod-1 t2-head">'.$pi['bank'].'</td>
   <td class="bod-1 t2-head">'.$pi['tfn'].' - '.$pi['payroll_abn_number'].'</td>
   </tr>
   <tr>
   <th class="bod-1 t3-head">Mobile: '.$pi['phone'].'</th>
   <th class="bod-1"> </th>
   <th class="bod-1 t3-head">Hours</th>
   <th class="bod-1 t3-head">Amount</th>
   </tr>
   
   ';

        $pdf_data .= '<tr>
        <td ></td>
        <td class="bod-1">Day</td>
          <td class="bod-1">'.$pi['day'].'</td>
          <td class="bod-1">$'.$pi['day_pay'].'</td>
          </tr>';
          $pdf_data .= '<tr>
          <td ></td>
          <td class="bod-1">Night</td>
          <td class="bod-1">'.$pi['night'].'</td>
          <td class="bod-1">$'.$pi['night_pay'].'</td>
          </tr>';
          $pdf_data .= '<tr>
          <td ></td>
          <td class="bod-1">Saturday</td>
          <td class="bod-1">'.$pi['saturday'].'</td>
          <td class="bod-1">$'.$pi['saturday_pay'].'</td>
          </tr>';
          $pdf_data .= '<tr>
          <td ></td>
          <td class="bod-1">Sunday</td>
          <td class="bod-1">'.$pi['sunday'].'</td>
          <td class="bod-1">$'.$pi['sunday_pay'].'</td>
          </tr>';
          $pdf_data .= '<tr>
          <td ></td>
          <td class="bod-1">Public Holiday</td>
          <td class="bod-1">'.$pi['ph'].'</td>
          <td class="bod-1">$'.$pi['ph_pay'].'</td>
          </tr>';
          $pdf_data .= '<tr>
          <td ></td>
          <td class="bod-1">Total</td>
          <td class="bod-1">'.$pi['total_hours' ].'</td>
          <td class="bod-1">'.$pi['pay'].'</td>
          </tr>';
          $pdf_data .= '<tr>
          <td class="gray-row"></td>
          <td class="gray-row"></td>
          <td class="gray-row"></td>
          <td class="gray-row"></td>
          </tr></table>';

    }
}

   
    }
      $pdf_data .='</div>
    </td></tr></table></div>
    </div>
    </body></html>';

    // $pdf_data = PDF::loadView('reports/rosterReport', ['data' => $pdf_data]);
    // $pdf_data->setPaper('A4', 'landscape');
    // echo $pdf_data;
    // exit();


 
        if($request->type =="excel"){
            return View('admin/report/excel',compact('pdf_data'));
        }else{
            $pdf_data = PDF::loadView('reports/rosterReport', ['data' => $pdf_data]);
          return  $pdf_data->stream(date('d/m/Y').'_paysheet_report.pdf');
        }

  }
  function excel_preview_paysheet($report){
    $pdf_data='';
        foreach ($report as $pi) {
                   
     $pdf_data .='<table style="width:100%;">
     <tr>
     <td class="bod-1" style="background-color:#CC66FF;">
     <div>
     <strong>Name</strong>
     </div>
     </td>
     <td  class="bod-1" style="background-color:#CC66FF;">
     <div>
     <strong>BSB</strong>
     </div>
     </td>
     <td  class="bod-1" style="background-color:#CC66FF;" >
     <div>
     <strong>A/C</strong>
     </div>
     </td>
     <td  class="bod-1" style="background-color:#CC66FF;" >
     <div>
     <strong>Tax File - ABN</strong>
     </div>
     </td>
     </tr>
     <tr>
   <td class="bod-1" style="background-color:#22F4FE;">'.$pi['name'].'</td>
   <td class="bod-1" style="background-color:#22F4FE;">'.$pi['bsb'].'</td>
   <td class="bod-1" style="background-color:#22F4FE;">'.$pi['bank'].'</td>
   <td class="bod-1" style="background-color:#22F4FE;">'.$pi['tfn'].' - '.$pi['payroll_abn_number'].'</td>
   </tr>
   <tr>
   <th class="bod-1" style="background-color:#9FFF9D;">Mobile: '.$pi['phone'].'</th>
   <th class="bod-1"> </th>
   <th class="bod-1" style="background-color:#9FFF9D;">Hours</th>
   <th class="bod-1" style="background-color:#9FFF9D;">Amount</th>
   </tr>
   
   ';

        $pdf_data .= '<tr>
        <td ></td>
        <td class="bod-1">Day</td>
          <td class="bod-1">'.$pi['day'].'</td>
          <td class="bod-1">$'.$pi['day'] * $pi['rate'].'</td>
          </tr>';
          $pdf_data .= '<tr>
          <td ></td>
          <td class="bod-1">Night</td>
          <td class="bod-1">'.$pi['night'].'</td>
          <td class="bod-1">$'.$pi['night'] * $pi['rate'].'</td>
          </tr>';
          $pdf_data .= '<tr>
          <td ></td>
          <td class="bod-1">Saturday</td>
          <td class="bod-1">'.$pi['saturday'].'</td>
          <td class="bod-1">$'.$pi['saturday'] * $pi['rate'].'</td>
          </tr>';
          $pdf_data .= '<tr>
          <td ></td>
          <td class="bod-1">Sunday</td>
          <td class="bod-1">'.$pi['sunday'].'</td>
          <td class="bod-1">$'.$pi['sunday'] * $pi['rate'].'</td>
          </tr>';
          $pdf_data .= '<tr>
          <td ></td>
          <td class="bod-1">Public Holiday</td>
          <td class="bod-1">'.$pi['ph'].'</td>
          <td class="bod-1">$'.$pi['ph'] * $pi['rate'].'</td>
          </tr>';
          $pdf_data .= '<tr>
          <td ></td>
          <td class="bod-1">Total</td>
          <td class="bod-1">'.$pi['total_hours' ].'</td>
          <td class="bod-1">$'.$pi['total_hours' ] * $pi['rate'].'</td>
          </tr>';
          $pdf_data .= '<tr>
          <td class="gray-row"></td>
          <td class="gray-row"></td>
          <td class="gray-row"></td>
          <td class="gray-row"></td>
          </tr></table>';

     }
     return $pdf_data;
  }

  function ExcelWriter($file="")
  {
      return $this->open($file);
  }
  
  /*
  * @Params : $file  : file name of excel file to be created.
  * 			if you are using file name with directory i.e. test/myFile.xls
  * 			then the directory must be existed on the system and have permissioned properly
  * 			to write the file.
  * @Return : On Success Valid File Pointer to file
  * 			On Failure return false	 
  */
  function open($file)
  {
      if($this->state!="CLOSED")
      {
          $this->error="Error : Another file is opend .Close it to save the file";
          return false;
      }	
      
      if(!empty($file))
      {
          $this->fp=@fopen($file,"w+");
      }
      else
      {
          $this->error="Usage : New ExcelWriter('fileName')";
          return false;
      }	
      if($this->fp==false)
      {
          $this->error="Error: Unable to open/create File.You may not have permmsion to write the file.";
          return false;
      }
      $this->state="OPENED";
      fwrite($this->fp,$this->GetHeader());
      return $this->fp;
  }
  
  function close()
  {
      if($this->state!="OPENED")
      {
          $this->error="Error : Please open the file.";
          return false;
      }	
      if($this->newRow)
      {
          fwrite($this->fp,"</tr>");
          $this->newRow=false;
      }
      
      fwrite($this->fp,$this->GetFooter());
      fclose($this->fp);
      $this->state="CLOSED";
      return ;
  }
  /* @Params : Void
  *  @return : Void
  * This function write the header of Excel file.
  */
                               
  function GetHeader()
  {
      $header = <<<EOH
          <html xmlns:o="urn:schemas-microsoft-com:office:office"
          xmlns:x="urn:schemas-microsoft-com:office:excel"
          xmlns="http://www.w3.org/TR/REC-html40">

          <head>
          <meta http-equiv=Content-Type content="text/html; charset=us-ascii">
          <meta name=ProgId content=Excel.Sheet>
          <!--[if gte mso 9]><xml>
           <o:DocumentProperties>
            <o:LastAuthor>TASH</o:LastAuthor>
            <o:LastSaved>2005-01-02T07:46:23Z</o:LastSaved>
            <o:Version>10.2625</o:Version>
           </o:DocumentProperties>
           <o:OfficeDocumentSettings>
            <o:DownloadComponents/>
           </o:OfficeDocumentSettings>
          </xml><![endif]-->
          <style>
          <!--table
              {mso-displayed-decimal-separator:"\.";
              mso-displayed-thousand-separator:"\,";}
          @page
              {margin:1.0in .75in 1.0in .75in;
              mso-header-margin:.5in;
              mso-footer-margin:.5in;}
          tr
              {mso-height-source:auto;}
          col
              {mso-width-source:auto;}
          br
              {mso-data-placement:same-cell;}
          .style0
              {mso-number-format:General;
              text-align:general;
              vertical-align:bottom;
              white-space:nowrap;
              mso-rotate:0;
              mso-background-source:auto;
              mso-pattern:auto;
              color:windowtext;
              font-size:10.0pt;
              font-weight:400;
              font-style:normal;
              text-decoration:none;
              font-family:Arial;
              mso-generic-font-family:auto;
              mso-font-charset:0;
              border:none;
              mso-protection:locked visible;
              mso-style-name:Normal;
              mso-style-id:0;}
          td
              {mso-style-parent:style0;
              padding-top:1px;
              padding-right:1px;
              padding-left:1px;
              mso-ignore:padding;
              color:windowtext;
              font-size:10.0pt;
              font-weight:400;
              font-style:normal;
              text-decoration:none;
              font-family:Arial;
              mso-generic-font-family:auto;
              mso-font-charset:0;
              mso-number-format:General;
              text-align:general;
              vertical-align:bottom;
              border:none;
              mso-background-source:auto;
              mso-pattern:auto;
              mso-protection:locked visible;
              white-space:nowrap;
              mso-rotate:0;}
          .xl24
              {mso-style-parent:style0;
              white-space:normal;}
          -->
          </style>
          <!--[if gte mso 9]><xml>
           <x:ExcelWorkbook>
            <x:ExcelWorksheets>
             <x:ExcelWorksheet>
              <x:Name>TASH</x:Name>
              <x:WorksheetOptions>
               <x:Selected/>
               <x:ProtectContents>False</x:ProtectContents>
               <x:ProtectObjects>False</x:ProtectObjects>
               <x:ProtectScenarios>False</x:ProtectScenarios>
              </x:WorksheetOptions>
             </x:ExcelWorksheet>
            </x:ExcelWorksheets>
            <x:WindowHeight>10005</x:WindowHeight>
            <x:WindowWidth>10005</x:WindowWidth>
            <x:WindowTopX>120</x:WindowTopX>
            <x:WindowTopY>135</x:WindowTopY>
            <x:ProtectStructure>False</x:ProtectStructure>
            <x:ProtectWindows>False</x:ProtectWindows>
           </x:ExcelWorkbook>
          </xml><![endif]-->
          </head>

          <body link=blue vlink=purple>
          <table x:str border=0 cellpadding=0 cellspacing=0 style='border-collapse: collapse;table-layout:fixed;'>
EOH;
      return $header;
  }

  function GetFooter()
  {
      return "</table></body></html>";
  }
  
  /*
  * @Params : $line_arr: An valid array 
  * @Params : $css: optional : An array of css properties
  * @Return : Void
  */
   
  function writeLine($line_arr, $css = NULL)
  {
      if($this->state!="OPENED")
      {
          $this->error="Error : Please open the file.";
          return false;
      }	
      if(!is_array($line_arr))
      {
          $this->error="Error : Argument is not valid. Supply an valid Array.";
          return false;
      }
      
      if($css!=NULL)
      {
          $cssStr = $this->getCssString($css);
      }
      else
      {
          $cssStr = "";
      }
      fwrite($this->fp,"<tr>");
      foreach($line_arr as $col)
          fwrite($this->fp,"<td class=xl24 width=64 $cssStr>$col</td>");
      fwrite($this->fp,"</tr>");
  }
  
  function getCssString($css)
  {
      $returnVal = "style='";
      foreach($css as $key => $val)
      {
          $returnVal.= $key.':'.$val.';';
      }
      $returnVal.= "'";
      return $returnVal;
  }

  /*
  * @Params : Void
  * @Return : Void
  */
  function writeRow()
  {
      if($this->state!="OPENED")
      {
          $this->error="Error : Please open the file.";
          return false;
      }	
      if($this->newRow==false)
          fwrite($this->fp,"<tr>");
      else
          fwrite($this->fp,"</tr><tr>");
      $this->newRow=true;	
  }

  /*
  * @Params : $value : Column Value
  * @Params : $css: optional : An array of css properties
  * @Return : Void
  */
  function writeCol($value,$css = NULL)
  {
      if($this->state!="OPENED")
      {
          $this->error="Error : Please open the file.";
          return false;
      }	
      if($css!=NULL)
      {
          $cssStr = $this->getCssString($css);
      }else{
          $cssStr = '';
          }
      
      fwrite($this->fp,"<td class=xl24 width=64 $cssStr>$value</td>");
  }

  function guard_paysheet(){
    return view('/admin/report/guard_paysheet_report');
  }


public function timesheet_by_guard($guard_id, $from , $to)

{
    
 $results= $this->timesheet_by_guard_record($guard_id, $from , $to);
             foreach($results as $result)
            {

                    $hours = $this->getTimeDiff($result->temp_start, $result->temp_end);
                    // $result->hours=$hours['hours'] + $result->travel_time;
                    $result->temp_date=Date("d-m-Y",strtotime($result->temp_start));
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
         
            return $results;
} 
public function timesheet_by_guard_record($guard_id, $from, $to){
       $results= DB::table('job_new_roster')
            ->join('jobs', 'job_new_roster.site_id', '=', 'jobs.id')
            ->leftJoin('job_roster_activities', 'job_new_roster.roster_id', '=', 'job_roster_activities.job_roster_id')
            ->leftJoin('guards', 'job_new_roster.guard_id', '=', 'guards.id')
            ->leftJoin('guard_payroll_ids', 'guards.id', '=', 'guard_payroll_ids.guard_id')
            ->join('customers', 'jobs.customer_id', '=', 'customers.id')
            ->leftJoin('contractors', 'jobs.contractor_id', '=', 'contractors.id')
            // ->join('guard_ids', 'customers.id', '=', 'guard_ids.customer_id')
            ->select('job_new_roster.*', 'jobs.id AS job_id', 'jobs.booking_id',
                 'jobs.customer_id',
            'jobs.contractor_id',
            'jobs.state',
            'jobs.site_name',
            'jobs.site_description',
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
            'job_roster_activities.signout_time',
            'guard_payroll_ids.payroll_id AS guard_payroll_id' 

        )
        ->where(function($que){
            $que->where('job_new_roster.job_status' ,'completed');
            $que->orWhere('job_new_roster.status_change_by', '>' , 0);
        })
        ->where('job_new_roster.guard_id' ,$guard_id)
        ->where('job_new_roster.temp_start', '>=', date('Y-m-d 00:00:00', $from))
        ->where('job_new_roster.temp_start', '<=', date('Y-m-d 23:59:59', $to))->orderBy('job_new_roster.roster_id', 'desc')->take(50)->get();
            return $results;

    } 
    function guard_timesheet_api(Request $request)
    {
        return $this->guard_timesheet($request, 'api');
    }

    function convertIntoWhole($hours)
    {
        $total_hours = explode('.', $hours);
            if (sizeof($total_hours) > 1 ) {
              $partial = '.'.$total_hours[1];
              if ($partial < 0.1) {
                $hours = $total_hours[0];
              }
              if ($partial < 0.27 && $partial > 0.1) {
                $hours = $total_hours[0].'.25';
              }
              if ($partial > 0.27 && $partial < 0.52) {
                $hours = $total_hours[0].'.5';
              }
              if ($partial > 0.52 && $partial < 0.77) {
                $hours = $total_hours[0].'.75';
              }
              if ($partial > 0.77 && $partial < 1) {
                $hours = $total_hours[0]+ 1;
              }
            }
            return $hours;
    }
function adminSpecificPermissions($admin_id)
{
    $admin = DB::table('administrators')->where('id', $admin_id)->first();
    $admin->specific_customer = json_decode($admin->specific_customer);
    $admin->specific_sites = json_decode($admin->specific_sites);
    return $admin;
}
  function guard_timesheet(Request $request, $call_from = null)
  {
    // return session()->get('userType');
    $search_=false;
    if ($request->has('search') ) {
        if ($request->search != '') {
            $date = $request->search;
        $date = explode('-', $date);
        $from = strtotime(trim($date[0]));
        $to = strtotime(trim($date[1]));
        if ($from == $to) {
            $to = $to + 60*60*24;
        }
        }else{
             $to = time();
            $from = time() - (60*60*24*14);
        }
        
         $search_=true;

    }else{
    $to = time();
    $from = time() - (60*60*24*14);
    $search_ = false;

    }
    if ($call_from == 'api') {
        $search_ = true;
    }
    if ($request->has('admin_id') && $request->admin_id > 0) {
            $admin = $this->adminSpecificPermissions($request->admin_id);
            $specific_customers = $admin->specific_customer;
            $specific_sites = $admin->specific_sites;

        $temp1 = DB::table('job_new_roster')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->where('temp_date', '>=', date('Y-m-d', $from))
        ->where('temp_date', '<=', date('Y-m-d', $to))
        ->where('guard_id', '>', 0)
        ->where(function($query){
                $query->where('job_new_roster.job_status', 'completed');
                // $query->orWhere('job_new_roster.job_status', 'confirmed');
                // $query->orWhere('job_new_roster.job_status', 'pending');
                $query->orWhere('job_new_roster.status_change_by', '>', 0);
            });
        if (is_array($specific_sites) && !empty($specific_sites)) {
            $temp1->where(function($query)  use($specific_sites){
                    foreach ($specific_sites as $key => $id) {
                        if ($key == 0) {
                            $query->where('job_new_roster.site_id', $id);
                        }else{
                            $query->orWhere('job_new_roster.site_id', $id);
                        }
                    }
                });
        }
        if (is_array($specific_customers) && !empty($specific_customers)) {
        $temp1->where(function($query)  use($specific_customers){
                    foreach ($specific_customer as $key => $id) {
                        if ($key == 0) {
                            $query->where('jobs.customer_id', $id);
                        }else{
                            $query->orWhere('jobs.customer_id', $id);
                        }
                    }
                });
        }
        $roster_guards = $temp1->select('guard_id')->groupBy('guard_id')->get();

        }elseif (session()->has('specific_sites') && session()->get('specific_sites') != '') {
        $specific_sites = json_decode(session()->get('specific_sites'));
        $temp1 = DB::table('job_new_roster')
        ->where('temp_date', '>=', date('Y-m-d', $from))
        ->where('temp_date', '<=', date('Y-m-d', $to))
        ->where('guard_id', '>', 0)
        ->where(function($query){
                $query->where('job_new_roster.job_status', 'completed');
                // $query->orWhere('job_new_roster.job_status', 'confirmed');
                // $query->orWhere('job_new_roster.job_status', 'pending');
                $query->orWhere('job_new_roster.status_change_by', '>', 0);
            });
            $temp1->where(function($query)  use($specific_sites){
                    foreach ($specific_sites as $key => $id) {
                        if ($key == 0) {
                            $query->where('job_new_roster.site_id', $id);
                        }else{
                            $query->orWhere('job_new_roster.site_id', $id);
                        }
                    }
                });
        $roster_guards = $temp1->select('guard_id')->groupBy('guard_id')->get();
                
            }elseif (session()->has('specific_customer') && session()->get('specific_customer') != '') {
                $specific_customer = json_decode(session()->get('specific_customer'));
                $temp1 = DB::table('job_new_roster')
                ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
                ->where('job_new_roster.temp_date', '>=', date('Y-m-d', $from))
                ->where('job_new_roster.temp_date', '<=', date('Y-m-d', $to))
                ->where('job_new_roster.guard_id', '>', 0)
                ->where(function($query){
                $query->where('job_new_roster.job_status', 'completed');
                // $query->orWhere('job_new_roster.job_status', 'confirmed');
                // $query->orWhere('job_new_roster.job_status', 'pending');
                $query->orWhere('job_new_roster.status_change_by', '>', 0);
            });
                $temp1->where(function($query)  use($specific_customer){
                    foreach ($specific_customer as $key => $id) {
                        if ($key == 0) {
                            $query->where('jobs.customer_id', $id);
                        }else{
                            $query->orWhere('jobs.customer_id', $id);
                        }
                    }
                });
            $roster_guards = $temp1->select('job_new_roster.guard_id')->groupBy('job_new_roster.guard_id')->get();
            }else{
        $roster_guards = DB::table('job_new_roster')->where('temp_start', '>=', date('Y-m-d 00:00:00', $from))->where('temp_start', '<=', date('Y-m-d 23:59:59', $to))
        ->where('guard_id', '>', 0)
        ->where(function($query){
                $query->where('job_new_roster.job_status', 'completed');
                // $query->orWhere('job_new_roster.job_status', 'confirmed');
                // $query->orWhere('job_new_roster.job_status', 'pending');
                $query->orWhere('job_new_roster.status_change_by', '>', 0);
            })
        ->select('guard_id')->groupBy('guard_id')->get();
    }
    if(session()->get('userType') == 'contractor'){
        foreach ($roster_guards as $key => $guard) {
            $getGuardsOfContractor = Guard::where(['id'=>$guard->guard_id, 'contractor_id'=>session()->get('userId')])->first();
            if(!$getGuardsOfContractor){
                unset($roster_guards[$key]);
            }
        }
    }
    $guard_timesheet = array();
    foreach ($roster_guards as $key => $guard) {
        $guard_roster = DB::table('job_new_roster')
        ->join('guards', 'guards.id' , '=', 'job_new_roster.guard_id')
        ->join('jobs', 'jobs.id' , '=', 'job_new_roster.site_id')
        ->where('job_new_roster.temp_start', '>=', date('Y-m-d 00:00:00', $from))
        ->where('job_new_roster.temp_start', '<=', date('Y-m-d 23:59:59', $to))
        // ->where('job_new_roster.job_status', 'completed')
        ->where(function($query){
            $query->where('job_new_roster.job_status', 'completed');
            // $query->orWhere('job_new_roster.job_status', 'confirmed');
            // $query->orWhere('job_new_roster.job_status', 'pending');
            $query->orWhere('job_new_roster.status_change_by', '>', 0);
        })
        ->where('job_new_roster.guard_id', $guard->guard_id)
        ->select('job_new_roster.hours', 'job_new_roster.temp_start', 'job_new_roster.temp_end', 'guards.name', 'jobs.payable', 'jobs.payable_and_chargeable_time')->get();
        $roster_data = $this->timesheet_by_guard($guard->guard_id, $from, $to);
        foreach ($guard_roster as $key => $roster) {
            $tempStart = date("m/d/Y H:i", strtotime($roster->temp_start));
            $tempEnd = date("m/d/Y H:i", strtotime($roster->temp_end));
            $hours = $this->getShiftHours($tempStart,$tempEnd);
            $hours['morning'] = $this->convertIntoWhole($hours['morning']);
            $hours['night'] = $this->convertIntoWhole($hours['night']);
            $hours['saturday_morning'] = $this->convertIntoWhole($hours['saturday_morning']);
            $hours['saturday_night'] = $this->convertIntoWhole($hours['saturday_night']);
            $hours['sunday_morning'] = $this->convertIntoWhole($hours['sunday_morning']);
            $hours['sunday_night'] = $this->convertIntoWhole($hours['sunday_night']);
            $hours['ph_morning'] = $this->convertIntoWhole($hours['ph_morning']);
            $hours['ph_night'] = $this->convertIntoWhole($hours['ph_night']);
            if ($roster->payable == 'no') {
                $break_deduction_time = $roster->payable_and_chargeable_time / 60;
                if ($break_deduction_time > 0 && $break_deduction_time <= 0.25) {
                  $breakCal = $this->calculateBreakTiming($hours['morning'], $hours['night'], 0.25, 0);
                  $hours['morning'] = $breakCal[0];
                  $hours['night'] = $breakCal[1];
                }elseif ($break_deduction_time > 0.25 && $break_deduction_time <= 0.5) {
                     $breakCal = $this->calculateBreakTiming($hours['morning'], $hours['night'], 0.25, 0.25);
                    $hours['morning'] = $breakCal[0];
                    $hours['night'] = $breakCal[1];
                }elseif ($break_deduction_time > 0.5 && $break_deduction_time <= 0.75) {
                     $breakCal = $this->calculateBreakTiming($hours['morning'], $hours['night'], 0.5, 0.25);
                  $hours['morning'] = $breakCal[0];
                  $hours['night'] = $breakCal[1];
                }elseif ($break_deduction_time > 0.75 && $break_deduction_time <= 1) {
                     $breakCal = $this->calculateBreakTiming($hours['morning'], $hours['night'], 0.5, 0.5);
                  $hours['morning'] = $breakCal[0];
                  $hours['night'] = $breakCal[1];
                }
                $roster->break = $breakCal;
            }
            $roster->hours_di = $hours;
            if (!isset($guard_timesheet[$guard->guard_id])) {
                $guard_timesheet[$guard->guard_id] = array(
                    'guard_id' => $guard->guard_id, 
                    'name' => $roster->name,
                    'day' => $hours['morning'],
                    'night' => $hours['night'],
                    'total' => $hours['night'] + $hours['morning'] + $hours['saturday_morning'] + $hours['saturday_night'] + $hours['sunday_morning'] + $hours['sunday_night'] + $hours['ph_morning'] + $hours['ph_night'],
                    'saturday' => $hours['saturday_morning'] + $hours['saturday_night'],
                    'sunday' => $hours['sunday_morning'] + $hours['sunday_night'],
                    'ph' => $hours['ph_morning'] + $hours['ph_night']
                );
            }else{
                 $guard_timesheet[$guard->guard_id]['day'] = $guard_timesheet[$guard->guard_id]['day'] + $hours['morning'];
                 $guard_timesheet[$guard->guard_id]['night'] = $guard_timesheet[$guard->guard_id]['night'] + $hours['night'];
                $guard_timesheet[$guard->guard_id]['total'] = $guard_timesheet[$guard->guard_id]['total'] + $hours['night'] + $hours['morning'] + $hours['saturday_morning'] + $hours['saturday_night'] + $hours['sunday_morning'] + $hours['sunday_night'] + $hours['ph_morning'] + $hours['ph_night'];
                // $guard_timesheet[$guard->guard_id]['saturday']=0;
                // $guard_timesheet[$guard->guard_id]['sunday']=0;
                $guard_timesheet[$guard->guard_id]['sunday'] = $guard_timesheet[$guard->guard_id]['sunday'] + $hours['sunday_morning'] + $hours['sunday_night'];
                $guard_timesheet[$guard->guard_id]['saturday'] =  $guard_timesheet[$guard->guard_id]['saturday'] + $hours['saturday_morning'] + $hours['saturday_night'];
                $guard_timesheet[$guard->guard_id]['ph'] =  $guard_timesheet[$guard->guard_id]['ph'] + $hours['ph_morning'] + $hours['ph_night'];

                
            }
            // $day = Carbon::parse($roster->temp_start)->format('l');
            // if($day == 'Sunday' || $day == 'sunday'){
            //     $guard_timesheet[$guard->guard_id]['sunday'] = $guard_timesheet[$guard->guard_id]['sunday'] + $hours['sunday_morning'] + $hours['sunday_night'];
            //     $guard_timesheet[$guard->guard_id]['day'] = $guard_timesheet[$guard->guard_id]['day'] - $hours['morning'];
            //      $guard_timesheet[$guard->guard_id]['night'] = $guard_timesheet[$guard->guard_id]['night'] - $hours['night'];
            //     // $guard_timesheet[$guard->guard_id]['night']=0;
            //     // $guard_timesheet[$guard->guard_id]['day']=0;
            // }elseif($day == 'Saturday' || $day == 'saturday'){
            //     $guard_timesheet[$guard->guard_id]['saturday'] =  $guard_timesheet[$guard->guard_id]['saturday'] + $hours['saturday_morning'] + $hours['saturday_night'];
            //     $guard_timesheet[$guard->guard_id]['day'] = $guard_timesheet[$guard->guard_id]['day'] - $hours['morning'];
            //     $guard_timesheet[$guard->guard_id]['night'] = $guard_timesheet[$guard->guard_id]['night'] - $hours['night'];
            //     // $guard_timesheet[$guard->guard_id]['night']=0;
            //     // $guard_timesheet[$guard->guard_id]['day']=0;
            // }
            // else{
            //     $guard_timesheet[$guard->guard_id]['saturday']=0;
            //     $guard_timesheet[$guard->guard_id]['sunday']=0;
            // }

            $guard_timesheet[$guard->guard_id]['total'] = number_format($guard_timesheet[$guard->guard_id]['total'], 2);
            // $guard_timesheet[$guard->guard_id]['total']= number_format($guard_timesheet[$guard->guard_id]['total'], 2);
            // $guard_timesheet[$guard->guard_id]['total']= number_format($guard_timesheet[$guard->guard_id]['total'], 2);

        }
        $guard_timesheet[$guard->guard_id]['rosters'] = $roster_data;
        $guard_timesheet[$guard->guard_id]['rosters_guard'] = $guard_roster;
    }
     array_multisort(array_column($guard_timesheet, 'name'), SORT_ASC, $guard_timesheet);

    if($search_==true){
        foreach ($guard_timesheet as $key => $value) {
            $guard_timesheet[$key]['day'] = number_format($value['day'], 2);
            $guard_timesheet[$key]['night'] = number_format($value['night'], 2);
            $guard_timesheet[$key]['total'] = number_format($value['total'], 2);
            $guard_timesheet[$key]['saturday'] = number_format($value['saturday'], 2);
            $guard_timesheet[$key]['sunday'] = number_format($value['sunday'], 2);
            $guard_timesheet[$key]['ph'] = number_format($value['ph'], 2);
            $guard_timesheet[$key]['day'] = number_format($value['day'], 2);
        }
        if ($call_from == 'api') {
            return response()->json(['status' => true, 'message' => 'Data found', 'data' => $guard_timesheet], 200);
        }else{
        return $guard_timesheet;
        }
    }else{
        if ($call_from == 'api') {
            return response()->json(['status' => false, 'error' => 'No record Found!'], 200);
        }else{
        return view('/admin/report/guard_timesheet_report',['data'=> array()]);
    }
}
// print_r('<pre>');
    // print_r($guard_timesheet);
    
  }
  function calculate_hours()
  {
    print_r('<pre>');
    print_r($this->getShiftHours(date('m/d/Y H:i', strtotime('2023-05-10 14:10:00')), date('m/d/Y H:i', strtotime('2023-05-10 18:15:00'))));
  }
  function convert_into_fraction($time)
  {
        return date('H', $time) + (date('i', $time) / 60);
  }
public function getShiftHours ($start, $end, $siteID = null, $public_holiday = null, $ph_duration = null) {
        $day_start = Carbon::parse($start)->format('l');
        $day_end = Carbon::parse($end)->format('l');

        $start = strtotime($start);
        $end = strtotime($end);

        $diff = $end - $start;
        $hours = round($diff / ( 60 * 60 ), 2);
        $morning_start = 6;
        $morning_end = 18;

        /*$afternoon_start = strtotime("15:00");
        $afternoon_end = strtotime("23:00");*/

        $night_start = 18;
        $night_end = 6;

        $shift_start = $this->convert_into_fraction($start);
        $shift_end = $this->convert_into_fraction($end);
        if ($shift_end < $shift_start) {
            $diff_new = $shift_end + 24 - $shift_start;
            if ($diff > $diff_new) {
                   $hours = $diff_new;
               }   
        }
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
        if($siteID != null){
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
        $state = $site_state->state != '' ? $states_array[$site_state->state] : 'vic';
    }else{
        $state = 'vic';
    }   
        $public_holiday_start = DB::table('public_holidays')->where('date', date('Ymd', $start))->where('state', $state)->first();
        if ($public_holiday != null && $public_holiday == 1) {
            $start_in_public_holiday = true;
        }elseif (!empty($public_holiday_start)) {
            $start_in_public_holiday = true;
        }

        $public_holiday_end = DB::table('public_holidays')->where('date', date('Ymd', $end))->where('state', $state)->first();
        if (!empty($public_holiday_end)) {
            $end_in_public_holiday = true;
        }elseif($public_holiday != null && $public_holiday == 1 && $ph_duration == 1){
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

        }elseif($public_holiday_start && !$end_in_public_holiday)
        {
            $ph_end = strtotime(date('m/d/Y 23:59:59', $start));
            $diff = $ph_end - $start;
            $total_ph_hours = round($diff / ( 60 * 60 ), 2);
            $ph_start = $this->convert_into_fraction($start);
            $ph_end = $this->convert_into_fraction($ph_end);
            $start = strtotime($public_holiday_start->date) + (60*60*24);
            $day_start = Carbon::parse(date('m/d/Y', $end))->format('l');
            $hours = $hours - $total_ph_hours;
            $shift_start = 0;
            // echo 'Start in PH - '.$day_start;
        }elseif(!$start_in_public_holiday && $end_in_public_holiday){
            $ph_start_ts = strtotime(date('m/d/Y 00:00:00', $end));
$diff = $end - $ph_start_ts;
$total_ph_hours = round($diff / 3600, 2);
$ph_start = $this->convert_into_fraction($ph_start_ts);
$ph_end = $this->convert_into_fraction($end);
$end = $ph_start_ts;

$shift_end = $this->convert_into_fraction($end);
$hours = $hours - $total_ph_hours;


            // echo $hours;
        }
        // $day_start = Carbon::parse($start)->format('l');
        // $day_end = Carbon::parse($end)->format('l');
        // print_r(expression)
        // print_r(date('m/d/Y H:i', $end));
        // print('<br>-');
        // print_r($end_in_public_holiday);
        // print('<br>total sat: ');   
        // print_r($total_saturday_hours);
        // print('<br>start: ');   
        // print_r($shift_start);
        // print('<br>end:     ');   
        // print_r($shift_end);
        // print('<br>hours : ');   
        // print_r($hours);
        // exit();
        // print('<br>');
        // print_r($night_end);
        // exit();

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
            // $diff = $end - $sun_start;
            // $total_sunday_hours = round($diff / ( 60 * 60 ), 2);
            $sunday_start = $this->convert_into_fraction($sun_start);
            $sunday_end = $this->convert_into_fraction($end);
            $total_sunday_hours = $sunday_end - $sunday_start;
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


   
        // print('<br>total sat: ');   
        // print_r($total_saturday_hours);
        // print('<br>start: ');   
        
        // print('<br>hours : ');   
        // print_r($hours);
        // exit();
        // print_r($shift_end);
        // print('<br>');

        // exit();
        if ($shift_end < $shift_start && $shift_end < 6 && $shift_end >= 1) {
            $shift_end += 24; 
        }

        // print_r($morning_start);
        // print('<br>');
        // print_r($morning_end);
        // print('<br>');
        // print_r($shift_start);
        // print('<br>end:     ');   
        // print_r($shift_end);
        $morning = round($this->calculateHoursMorning($shift_start, $shift_end, $morning_start, $morning_end), 2);
        // echo $morning;

        $saturday_morning = round($this->calculateHoursMorning($saturday_start, $saturday_end, $morning_start, $morning_end), 2);

        $sunday_morning = round($this->calculateHoursMorning($sunday_start, $sunday_end, $morning_start, $morning_end), 2);

        $ph_morning = round($this->calculateHoursMorning($ph_start, $ph_end, $morning_start, $morning_end), 2);

        // echo $ph_end;
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
  private function getShiftHours_backup ($start, $end) {
        $day_start = Carbon::parse($start)->format('l');
        $day_end = Carbon::parse($end)->format('l');

        $start = strtotime($start);
        $end = strtotime($end);

        $diff = $end - $start;
        $hours = round($diff / ( 60 * 60 ), 2);
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

            $shift_end = 0;
            $hours = $hours-$total_saturday_hours;
        }elseif($day_start != 'Saturday' && $day_end == 'Saturday')
        {
            $sat_start = strtotime(date('m/d/Y 00:00:00', $end));
            $diff = $end - $sat_start;
            $total_saturday_hours = round($diff / ( 60 * 60 ), 2);
            $saturday_start = $this->convert_into_fraction($sat_start);
            $saturday_end = $shift_end;
            $shift_end = 0;
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

            $shift_end = 0;
            $hours = $hours-$total_sunday_hours;
        }elseif($day_start != 'Sunday' && $day_end == 'Sunday')
        {
            $sun_start = strtotime(date('m/d/Y 00:00:00', $end));
            $diff = $end - $sun_start;
            $total_sunday_hours = round($diff / ( 60 * 60 ), 2);
            $sunday_start = $this->convert_into_fraction($sun_start);
            $sunday_end = $this->convert_into_fraction($end);
            $shift_end = 0;
            $hours = $hours - $total_sunday_hours;
        }



        
        // print_r($morning_start);
        // print('<br>');
        // print_r($sunday_end);
        // print('<br>total sat: ');   
        // print_r($total_saturday_hours);
        // print('<br>start: ');   
        // print_r($shift_start);
        // print('<br>end:     ');   
        // print_r($shift_end);
        // print('<br>hours : ');   
        // print_r($hours);
        // exit();
        // print('<br>');
        // print_r($night_end);
        // exit();

        $morning = round($this->calculateHoursMorning($shift_start, $shift_end, $morning_start, $morning_end), 2);
        $saturday_morning = round($this->calculateHoursMorning($saturday_start, $saturday_end, $morning_start, $morning_end), 2);

        $sunday_morning = round($this->calculateHoursMorning($sunday_start, $sunday_end, $morning_start, $morning_end), 2);
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
        return [
            // 'morning' => $this->intersection( $start1, $end, $morning_start, $morning_end ) / 3600,
            'morning' =>  $morning,
            'night' => round(((($hours - $morning) < 0) ? 0 : ($hours - $morning)), 2),
            'saturday_morning' => $saturday_morning,
            'saturday_night' => round(((($total_saturday_hours - $saturday_morning) < 0) ? 0 : ($total_saturday_hours - $saturday_morning)), 2),
            'sunday_morning' => $sunday_morning,
            'sunday_night' => round(((($total_sunday_hours - $sunday_morning) < 0) ? 0 : ($total_sunday_hours - $sunday_morning)), 2),

            // 'night' => $this->calculateHoursNight($shift_start, $shift_end, $night_start, $night_end ),
        ];
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
        } 
        elseif($shift_start >= $end && $shift_end > $start && $shift_end < $end)
        {
        // shift start in night in gone into day
        // echo 'Here';
            return $shift_end - $start;
        }elseif ($shift_start < $start && $shift_end > $end) {
            return $end - $start;
        } 
        elseif($shift_start > $start && $shift_end < $end){
            // if ($shift_start >= $start && $shift_end <= $end) {
            //     return 0;
            // }
            return $end - $shift_start;
        } 
        else {
            return 0;
        }
           
    }

    // function calculateHoursNight($shift_start, $shift_end, $start, $end)
    // {
    //     if ($shift_end >= 0 && $shift_end < 12) {
    //         $shift_end += 24;
    //     }
    //        if ($shift_start > $start) {

    //        }else{
    //         // $shift_start = $start;
    //        }
    //        return abs($shift_end - $shift_start);
    // }

  private function getShiftHours_old ($start, $end) {
        $start = strtotime($start);
        $end = strtotime($end);
        // $end = strtotime("05:30") + 3600*24; // the work ended at 05:30 morning of the next day

        $morning_start = strtotime("06:00");
        $morning_end = strtotime("18:00");

        /*$afternoon_start = strtotime("15:00");
        $afternoon_end = strtotime("23:00");*/

        $night_start = strtotime("18:00");
        $night_end = strtotime("06:00") + 3600*24; // 07:00 of next day, add 3600*24 seconds
        $end_hour = date('H', $end) * 1;
        $start_hour = date('H', $start) * 1;
        if ($start_hour == 0) {
            $start_hour = 24;
        }
        $end1 = $end;
        if($start_hour > 18){
            if($end_hour < 18){
                $end1 = $end1 + 3600*24;
            }
        }
        $start1 = $start;
        if($start_hour > 18){
            if($end_hour < 18 && $end_hour > 6){
                $end = $end;
                $start1 = strtotime("06:00");
            }
        }
        // print_r($start_hour);
        // print('<br>');
        // print_r($end1);
        // print('<br>');
        // print_r($night_start);
        // print('<br>');
        // print_r($night_end);

        // exit();
        return [
            // 'morning' => $this->intersection( $start1, $end, $morning_start, $morning_end ) / 3600,
            'morning' => $this->intersection( $start1, $end, $morning_start, $morning_end ) ,
            // 'night' => $this->intersection( $start, $end1, $night_start, $night_end ) / 3600,
            'night' => $this->intersection( $start, $end1, $night_start, $night_end ),
        ];
    }
    private function convert_time_into_fraction($time)
    {
        $hour_ = date('H', $time);
        $mints_ = date('i', $time);
        $mints_ = round(($mints_/60),2);
        $total = $hour_+$mints_;
        return $total;
    }
    private function intersection($s1, $e1, $s2, $e2) {
        $s1 = $this->convert_time_into_fraction($s1);
        $s2 = $this->convert_time_into_fraction($s2);
        $e1 = $this->convert_time_into_fraction($e1);
        $e2 = $this->convert_time_into_fraction($e2);
        if ($e1 <= 6) {
            $e1 = $e1 + 24;
        }
        if ($s1 <= 6) {
            $s1 = $s1 + 24;
        }
        if ($e2 <= 6) {
            $e2 = $e2 + 24;
        }
        // echo $s1;
        // echo '<br>';
        // echo $e1;
        // echo '<br>';
        // echo $s2;
        // echo '<br>';
        // echo $e2;
        // echo '<br>';
        // echo '<br>';

        if ($s1 >= $s2) {
            if ($s1 > $e2) {
                $s1 = 0;
                $e1 = 0;
            }elseif($e1 > $e2){
                $e1 = $e2;
            }
        }else{
            if ($e1 > $s2 && $e1 < $e2) {
                $s1 = $s2;
            }elseif($e1 < $s2){
                $s1 = 0;
                $e1 = 0;
            }
        }
        // echo $s1;
        // echo '<br>';
        // echo $e1;
        // echo '<br>';
        // echo $s2;
        // echo '<br>';
        // echo $e2;
        // exit();

        // if ($s1 < $s2 && $e1 >= $s2 && $e1 <=$e2) {
        //   $s1 = $s2;
        // }
        // if ($s1 < $s2 && $e1 >= $e2 && $e1 <=$s2) {
        //   $e1 = $e2;
        // }
        // if ($s1 > $s2 && $e1 > $e2) {
        //     return 0;
        // }
        // elseif ($s1 < $s2 && $e1  $e2) {
        //     return 0;
        // }
        
        return abs($e1 - $s1);
    }
    function getCompleteReportData($request)
    {
        if (isset($request['search']) && $request['search'] != '') {
        $date = $request['search'];
        $date = explode('-', $date);
        $from = strtotime(trim($this->date_convert($date[0])));
        $to = strtotime(trim($this->date_convert($date[1])));
        $to = $to;
        }else{
        $to = time();
        $from = time() - (60*60*24*7);
        }
        if (isset($request['sites']) && $request['sites'] != '') {
            $sites = explode(',', $request['sites']);
        }else{
            $sites = array();
        }
        if (isset($request['customer_name']) && $request['customer_name'] != '') {
            $customer_name = $request['customer_name'];
        }else{
            $customer_name = null;
        }
        if (isset($request['state']) && $request['state'] != '') {
            $state = $request['state'];
        }else{
            $state = null;
        }

        return $this->getReports(date('Y-m-d', $from),date('Y-m-d', $to), null, $sites, null, $customer_name, $state);
    }
    function export_guard_complete_report(Request $request)
    {
        return Excel::download(new CompleteReportExport, 'complete_report.xlsx');  
    }
    public function guard_complete_report(Request $request)
    {
        if ($request->has('search')) {
        $date = $request->search;
        $date = explode('-', $date);
        $from = strtotime(trim($date[0]));
        $to = strtotime(trim($date[1]));
        $to = $to;
        }else{
        $to = time();
        $from = time() - (60*60*24*7);
        }

        if(session()->get('userType') == 'contractor'){
            $contractor_id = session()->get('userId');
            $guards = Guard::where('contractor_id', $contractor_id)->pluck('id');
            $rosters = DB::table('job_new_roster')->whereIn('guard_id', $guards)->groupBy('site_id')->pluck('site_id');
            $jobs = DB::table('jobs')->whereIn('id', $rosters)->groupBy('customer_id')->pluck('customer_id');
            $customers = DB::table('customers')->whereIn('id', $jobs)->where('status', 'active')->get();
        }else{

            $customers = DB::table('customers')->where('status', 'active')->get();
        }
        // $data = $this->getReports(date('Y-m-d', $from),date('Y-m-d', $to), null, $request->sites, null, $request->customer_name);
        // print_r('<pre>');
        // print_r($data);
        if ($request->has('customer_name') && !empty($request->customer_name)) {
        }else{
            $request->customer_name = array();
        }
        $data = array();
        // exit();
        return view('/admin/report/guard_complete_report',['data'=> $data, 'search' => $request->search, 'customers' => $customers, 'active_customers' => $request->customer_name]);
    }
    function dbFormateDateTime($formate)
    {
     $formate = str_replace('-', '/', $formate);
     $usfromat = date("Y-m-d H:i", strtotime(($formate)));
     return $usfromat;
    }

    public function getReports($startDate, $endDate, $jobStatus = 'completed', $specific_sites_id = null, $multiple_states = null, $customer_id = null, $state = null) {
        
      $extra_query = '(jr.`job_status` = "completed" OR jr.`job_status` = "pending" OR jr.`job_status` = "confirmed" OR jr.`status_change_by` > 0) AND ';
      if ($multiple_states != null && !empty($multiple_states)) {
        $extra_query = "(";
        $i = 0;
          foreach ($multiple_states as $key => $value) {
          $extra_query .= "j.`state` = '".$value."'";
          if ($i < sizeof($multiple_states) -1) {
            $extra_query .= " OR ";
          }
          $i++;
          }
          $extra_query .= ") AND ";
        }
        
  //       if (session()->has('specific_sites') && session()->get('specific_sites') != '') {
  //   $specific_sites = json_decode(session()->get('specific_sites'));
  //   $extra_query = "(";
  //   $i = 0;
  //   foreach ($specific_sites as $key => $id) {
  //     $extra_query .= "jr.`site_id` = '".$id."'";
  //         if ($i < sizeof($specific_sites) -1) {
  //           $extra_query .= " OR ";
  //         }
  //         $i++;
  //   }
  //   $extra_query .= ") AND ";
  // }
  
if ($specific_sites_id != null && $specific_sites_id != '') {
    if (!is_array($specific_sites_id)) {
        $specific_sites_id = explode(',', $specific_sites_id);
    }else{
        $specific_sites_id = $specific_sites_id;
    }
    $extra_query .= "(";
     $i = 0;
     // print_r($specific_sites_id);
     // exit();
    foreach ($specific_sites_id as $key => $id) {
      $extra_query .= "jr.`site_id` = '".$id."'";
          if ($i < sizeof($specific_sites_id) -1) {
            $extra_query .= " OR ";
          }
          $i++;
    }
    $extra_query .= ") AND ";
  }

  if ($customer_id != null && $customer_id != '') {
    if (!is_array($customer_id)) {
        $specific_customer = explode(',', $customer_id);
    }else{
        $specific_customer = $customer_id;
    }
    $extra_query .= "(";
     $i = 0;
    foreach ($specific_customer as $key => $id) {
      $extra_query .= "j.`customer_id` = '".$id."'";
          if ($i < sizeof($specific_customer) -1) {
            $extra_query .= " OR ";
          }
          $i++;
    }
    $extra_query .= ") AND ";
  }elseif (session()->has('specific_customer') && session()->get('specific_customer') != '') {
    $specific_customer = json_decode(session()->get('specific_customer'));
    if (!empty($specific_customer)) {
    $extra_query .= "(";
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
if ($state != null && $state != '') {
          $extra_query .= "j.`state` = '".$state."' AND ";

        }
  // if ($customer_id != null && $customer_id > 0) {
     // $extra_query .= "jr.`roster_id` = 8737 AND ";
  // }
        $data = [];
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
            j.`site_payrate_type`,
            j.`payable` as break_payable,
            j.`break`,
            j.`payable_and_chargeable_time`,
            j.`other_metro_weekday_day`,
            j.`apply_date`,
            j.`custom_rate`,
            j.`custom_payrate`,
            cust.`name` AS customer_name,
            c.`name` AS contractor_name,
            g.`phone`,
            g.`guard_type`,
            g.`pay_by`,
            g.`abn_id`,
            g.`eba_id`,
            g.`award_id`,
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
            g.`pay_by` AS pay_by,
            g.`award_rate_level` AS award_rate_level,
            g.`award_rate_apply_from` AS award_rate_apply_from,
            g.`award_rate_apply_to` AS award_rate_apply_to,
            g.`position` AS position,
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
            WHERE ".$extra_query."jr.`payable` = 'yes' AND jr.`temp_date` BETWEEN '".$startDate."' AND '".$endDate."' ORDER BY g.name ASC, jr.moke_guard, jr.temp_start";
            // WHERE ".$extra_query."jr.`temp_date` BETWEEN '".$startDate."' AND '".$endDate."' AND j.`payable`='yes'";

            // WHERE jr.`job_status` = '".$jobStatus."' AND jr.temp_date BETWEEN '".$startDate."' AND '".$endDate."'";
            // INNER JOIN `guards` AS g ON g.`id` = jr.`guard_id`
            // echo $sql;
        // exit;
        $query = DB::select($sql);
        $results = $query;
        // dd($results);
        foreach ($results as $result) {
            // $pay_rate = $result->flat_metro_week_day;
            // $tempStart = date("H:i", strtotime($result->temp_start));
            // $tempEnd = date("H:i", strtotime($result->temp_end));
            // $total = $this->getTimeDiff($result->temp_start, $result->temp_end);
            // $total = $result->hours;
            $tempStart = date("H:i", strtotime($result->temp_start));
            $tempEnd = date("H:i", strtotime($result->temp_end));
            # calculate DST
            $timestamp_start = Carbon::parse($result->temp_start);
            $timestamp_start_dst = Carbon::parse($result->temp_start)->isDST();
            $timestamp_end = Carbon::parse($result->temp_end);
            $timestamp_end_dst = Carbon::parse($result->temp_end)->isDST();
            //$dst_hours = $total;
            if ($timestamp_start_dst && $timestamp_end_dst) {
                    // DST status is the same at both start and end timestamps
                    $dst_hours = $timestamp_start->floatDiffInHours($timestamp_end);
                }
            // if ($timestamp_start_dst && !$timestamp_end_dst) {
            //     // DST is active at the start but not at the end
            //     $dst_hours = $timestamp_start->floatDiffInHours($timestamp_end) - 1;
            //     $result->temp_end = $timestamp_end->subHour()->format('Y-m-d H:i');
            // } 
            //elseif (!$timestamp_start_dst && $timestamp_end_dst) {
            //     // DST is active at the end but not at the start
            //     $dst_hours = $timestamp_start->floatDiffInHours($timestamp_end) + 1;
            //     $result->temp_end = $timestamp_end->addHour()->format('Y-m-d H:i');
            // } else {
            //     // DST status is the same at both start and end timestamps
            //     $dst_hours = $timestamp_start->floatDiffInHours($timestamp_end);
            // }
            $total = $result->hours;
            //$total = $dst_hours;
            if ($result->continuation == 0 && $total < 4) {
                $end = strtotime($result->temp_end);
                $remaining = 4 - $total;
                $end = $end + (60*60*$remaining);
                $job_hours = $this->getShiftHours($result->temp_start,date('Y-m-d H:i', $end), $result->site_id, $result->public_holiday, $result->ph_duration);
                }else{
                    // $start_time = Carbon::createFromFormat("m-d-Y H:i", $request->start);
                    // if($result->temp_start){
                    //     // $start_time = Carbon::createFromFormat("Y-m-d H:i", trim($result->temp_start));
                    //     try {
                    //         $start_time = Carbon::createFromFormat("Y-m-d H:i:s", trim($result->temp_start));
                    //     } catch (\Exception $e) {
                    //         $start_time = Carbon::createFromFormat("Y-m-d H:i", trim($result->temp_start));
                    //     }
                    //     $start_time_hours_minutes = $start_time->format('H:i');
                    //     if($start_time_hours_minutes === '23:59'){
                    //         $start_time->addMinutes(1);
                    //         $modified_time_str = $start_time->format("m-d-Y H:i");
                    //     }else{
                    //         $modified_time_str = $result->temp_start;
                    //     }
                    // }
                    // if($result->temp_end){
                    //     try {
                    //         $end_time = Carbon::createFromFormat("Y-m-d H:i", trim($result->temp_end));
                    //     } catch (\Exception $e) {
                    //         $end_time = Carbon::createFromFormat("Y-m-d H:i:s", trim($result->temp_end));
                    //     }
                    //     // $end_time = Carbon::createFromFormat("Y-m-d H:i:s", trim($result->temp_end));
                    //     $end_time_hours_minutes = $end_time->format('H:i');
                    //     if($end_time_hours_minutes === '23:59'){
                    //         $end_time->addMinutes(1);
                    //         $modified_time_end = $end_time->format("m-d-Y H:i");
                    //     }else{
                    //         $modified_time_end = $result->temp_end;
                    //     }
                    // }
                $job_hours = $this->getShiftHours($result->temp_start, $result->temp_end, $result->site_id, $result->public_holiday, $result->ph_duration);
            }

            $job_hours['morning'] = $this->convertIntoWhole($job_hours['morning']);
            $job_hours['night'] = $this->convertIntoWhole($job_hours['night']);
            $job_hours['saturday_morning'] = $this->convertIntoWhole($job_hours['saturday_morning']);
            $job_hours['saturday_night'] = $this->convertIntoWhole($job_hours['saturday_night']);
            $job_hours['sunday_morning'] = $this->convertIntoWhole($job_hours['sunday_morning']);
            $job_hours['sunday_night'] = $this->convertIntoWhole($job_hours['sunday_night']);
            // $job_hours['ph_morning'] = $this->convertIntoWhole($job_hours['ph_morning']);
            if($job_hours['ph_morning'] < 0){
                $job_hours['ph_morning'] = $this->convertIntoWhole(abs($job_hours['ph_morning'])) * -1;
            }else{
                $job_hours['ph_morning'] = $this->convertIntoWhole($job_hours['ph_morning']);
            }
            if($job_hours['ph_morning'] < 0){
                $job_hours['ph_night'] = $this->convertIntoWhole($job_hours['ph_night']) - abs($job_hours['ph_morning']);
                $job_hours['ph_morning'] = 0;
                
            }else{
                $job_hours['ph_night'] = $this->convertIntoWhole($job_hours['ph_night']);
            }
            $total = $job_hours['morning'] + $job_hours['night'] + $job_hours['saturday_morning'] + $job_hours['saturday_night'] + $job_hours['sunday_morning'] + $job_hours['sunday_night'] + $job_hours['ph_morning'] + $job_hours['ph_night'];
            // print_r('<pre>');
            // exit;
            // if($result->payrol == 'other'){
            //   $pay_rate = $result->other_metro_weekday_day;
            // }
            // if($result->payrol == 'Default Rates'){
            //   $guard_rates = DB::table('guard_pay_rates')->where('state', $result->state)->where('guard_id', $result->guard_id)->where('job_level', $result->level)->first();
            //   if(!empty($guard_rates)){
            //     $pay_rate = $guard_rates->flat_metro_flat_metro_week_day;
            //   }
            // }

            // if($result->payrol == 'EMA Rates' || $result->payrol == 'EBA/Award Rates'){
            //   $guard_rates = DB::table('guard_pay_rates')->where('state', $result->state)->where('guard_id', $result->guard_id)->where('job_level', $result->level)->first();
            //   if(!empty($guard_rates)){
            //     $pay_rate = $guard_rates->eba_metro_weekday_day;
            //   }
            // }
            // $customer_rates = DB::table('guard_pay_rates')->where('guard_id', $result->guard_id)->where('job_level', $result->level)->first();
            // if(!empty($customer_rates)){
            //   $pay_rate = $customer_rates->eba_metro_weekday_day;
            // }
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
            $result->shift_level = 'N/A';
            // if (is_array(json_decode($result->payrate_applied, true)) && $result->payrate_applied != '' && !empty(json_decode($result->payrate_applied, true))) {
            //     $guard_rates = $payrates = json_decode($result->payrate_applied);
            // }else{
                if (config('custom.own_payrates') == 0) {
		if($result->manual_custom_payrate == 1){
                	$guard_rates = $payrates = json_decode($result->manual_custom_payrates);

            	}
		elseif($result->payrate_id > 0 && $result->payrate_id != null) {
                $guard_rates = $payrates = DB::table('payrates')->where('id', $result->payrate_id)->first();
                if (!empty($payrates)) {
                    // $result->level = $payrates->level;
                    $result->shift_level = $payrates->level;
                }
            }elseif($result->site_payrate > 0){

               $guard_rates = $payrates = DB::table('payrates')->where('id', $result->site_payrate)->first();
               if ($result->apply_date != '') {
            if (strtotime($result->apply_date) <= strtotime($result->temp_start)) {
              $guard_rates = $payrates = DB::table('payrates')->where('id', $result->site_payrate)->first();
            } else {

              $old_payrate = DB::table('site_payrate_history')
              ->where('site_id', $result->site_id)
              ->where('payrate_id', '!=', 0)
              ->where('apply_date', '<=', strtotime($result->temp_start))
              // ->where('apply_to_date', '>=', strtotime($result->temp_start))
              ->orderBy('apply_date', 'desc')->first();
               // dd($old_payrate);
              if (!empty($old_payrate)) {
                $guard_rates = $payrates = DB::table('payrates')->where('id', $old_payrate->payrate_id)->first();
              }
            }

          } else {
            $guard_rates = $payrates = DB::table('payrates')->where('id', $result->site_payrate)->first();
          }
          if (!empty($payrates)) {
                    $result->level = $payrates->level;
                }
            }
            elseif($result->custom_payrate == 1){
                $guard_rates = $payrates = json_decode($result->custom_rate);

            }
            elseif($result->manual_custom_payrate == 1){
                $guard_rates = $payrates = json_decode($result->manual_custom_payrates);

            }
            elseif($result->guard_payrate_id > 0){
                $guard_rates = $payrates = DB::table('payrates')->where('id', $result->guard_payrate_id)->first();
                if (!empty($payrates)) {
                    $result->level = $payrates->level;
                }
            }else{
                // $pay_rate = DB::table('payrates')->where('archive', 0)->where('archive', 0)->where('archive', 0)->where('id', $roster->site_payrate)->first();
               $guard_rates = $payrates = array();
            }

            }else{
                // New Code here for GSa Update
                if ($result->own_payrate != null && $result->payrate_id > 0) {
                    // Shift Rates here
                    if ($result->own_payrate == 'award') {
                        $guard_rates = $payrates = DB::table('award_payrates')->where('id', $result->payrate_id)->first();
                    }else{
                        $guard_rates = $payrates = DB::table('payrates')->where('id', $result->payrate_id)->first();
                    }
                }elseif($result->site_payrate_type != null && $result->site_payrate > 0)
                {
                    // Site payrate here
                     if ($result->site_payrate_type == 'award') {
                        $guard_rates = $payrates = DB::table('award_payrates')->where('id', $result->site_payrate)->first();
                    }else{
                        $guard_rates = $payrates = DB::table('payrates')->where('id', $result->site_payrate)->first();
                    }
                }elseif($result->pay_by != null)
                {
                    // Guard payrate here
                    if ($result->pay_by == 'award') {
                        $guard_rates = $payrates = DB::table('award_payrates')->where('id', $result->award_id)->first();
                    }elseif($result->pay_by == 'eba')
                    {
                        $guard_rates = $payrates = DB::table('payrates')->where('id', $result->eba_id)->first();

                    }elseif($result->pay_by == 'abn')
                    {
                        $guard_rates = $payrates = DB::table('award_payrates')->where('id', $result->abn)->first();
                    }else{
                    $guard_rates = $payrates = array();
                    }
                }else{
                    $guard_rates = $payrates = array();
                }
        }
            // }
            $day = Carbon::parse($result->temp_start)->format('l');
            if (!empty($payrates)) {
            if (!isset($payrates->ot_base_rate)) {
                $payrates->ot_base_rate = 22.84;
            }
            $ot_base_rate = $payrates->ot_base_rate;
            if (config('custom.own_payrates') == 1) {
                  if ($result->own_payrate == 'default') {
                    $result->payrol = 'Default Rates';
                  }
                  if ($result->own_payrate == 'award') {
                    $result->payrol = 'Award Rates';
                  }
                }
                if(config('custom.own_payrates') == 1)
      {
        $payrates->ot_base_rate = 22.84;
        // dd($payrates);
        // Code Change for GSA
        if ($result->own_payrate != null && $result->payrate_id > 0) {
                    // Shift Rates here
                    if ($result->own_payrate == 'award') {
                     $pay_rate = $payrates->pf_day;
                        $day_rate = $payrates->pf_day;
                        $night_rate = $payrates->pf_night;

                        $sunday_day_rate = $payrates->pf_sun;
                        $sunday_night_rate = $payrates->pf_sun;
                        $saturday_day_rate = $payrates->pf_sat;
                        $saturday_night_rate = $payrates->pf_sat;
                        $ph_day_rate = $payrates->pf_ph;
                        $ph_night_rate = $payrates->pf_ph;
                    }else{
    if ($result->stateType == 'metropolitan') {
           $pay_rate = $payrates->flat_metro_week_day_day;
                        $day_rate = $payrates->flat_metro_week_day_day;
                        $night_rate = $payrates->flat_metro_week_day_night;

                        $sunday_day_rate = $payrates->flat_metro_sunday;
                        $sunday_night_rate = $payrates->flat_metro_sunday;
                        $saturday_day_rate = $payrates->flat_metro_saturday;
                        $saturday_night_rate = $payrates->flat_metro_saturday;
                        $ph_day_rate = $payrates->flat_metro_public_holiday;
                        $ph_night_rate = $payrates->flat_metro_public_holiday;             
    }else{
        $pay_rate = $payrates->flat_regional_week_day_day;
                        $day_rate = $payrates->flat_regional_week_day_day;
                        $night_rate = $payrates->flat_regional_week_day_night;

                        $sunday_day_rate = $payrates->flat_regional_sunday;
                        $sunday_night_rate = $payrates->flat_regional_sunday;
                        $saturday_day_rate = $payrates->flat_regional_saturday;
                        $saturday_night_rate = $payrates->flat_regional_saturday;
                        $ph_day_rate = $payrates->flat_regional_public_holiday;
                        $ph_night_rate = $payrates->flat_regional_public_holiday;
    }
                    }
                }elseif($result->site_payrate_type != null && $result->site_payrate > 0)
                {
                    // Site payrate here
                     if ($result->site_payrate_type == 'award') {
                        $pay_rate = $payrates->pf_day;
                        $day_rate = $payrates->pf_day;
                        $night_rate = $payrates->pf_night;

                        $sunday_day_rate = $payrates->pf_sun;
                        $sunday_night_rate = $payrates->pf_sun;
                        $saturday_day_rate = $payrates->pf_sat;
                        $saturday_night_rate = $payrates->pf_sat;
                        $ph_day_rate = $payrates->pf_ph;
                        $ph_night_rate = $payrates->pf_ph;
                    }else{
                        if ($result->stateType == 'metropolitan') {
           $pay_rate = $payrates->flat_metro_week_day_day;
                        $day_rate = $payrates->flat_metro_week_day_day;
                        $night_rate = $payrates->flat_metro_week_day_night;

                        $sunday_day_rate = $payrates->flat_metro_sunday;
                        $sunday_night_rate = $payrates->flat_metro_sunday;
                        $saturday_day_rate = $payrates->flat_metro_saturday;
                        $saturday_night_rate = $payrates->flat_metro_saturday;
                        $ph_day_rate = $payrates->flat_metro_public_holiday;
                        $ph_night_rate = $payrates->flat_metro_public_holiday;             
    }else{
        $pay_rate = $payrates->flat_regional_week_day_day;
                        $day_rate = $payrates->flat_regional_week_day_day;
                        $night_rate = $payrates->flat_regional_week_day_night;

                        $sunday_day_rate = $payrates->flat_regional_sunday;
                        $sunday_night_rate = $payrates->flat_regional_sunday;
                        $saturday_day_rate = $payrates->flat_regional_saturday;
                        $saturday_night_rate = $payrates->flat_regional_saturday;
                        $ph_day_rate = $payrates->flat_regional_public_holiday;
                        $ph_night_rate = $payrates->flat_regional_public_holiday;
    }
                    }
                }
                elseif($result->custom_payrate == 1)
                {
                    // Site payrate here
                        if ($result->stateType == 'metropolitan') {
                $pay_rate = $payrates->flat_metro_week_day_day;
                        $day_rate = $payrates->flat_metro_week_day_day;
                        $night_rate = $payrates->flat_metro_week_day_night;

                        $sunday_day_rate = $payrates->flat_metro_sunday;
                        $sunday_night_rate = $payrates->flat_metro_sunday;
                        $saturday_day_rate = $payrates->flat_metro_saturday;
                        $saturday_night_rate = $payrates->flat_metro_saturday;
                        $ph_day_rate = $payrates->flat_metro_public_holiday;
                        $ph_night_rate = $payrates->flat_metro_public_holiday;             
    }else{
        $pay_rate = $payrates->flat_regional_week_day_day;
                        $day_rate = $payrates->flat_regional_week_day_day;
                        $night_rate = $payrates->flat_regional_week_day_night;

                        $sunday_day_rate = $payrates->flat_regional_sunday;
                        $sunday_night_rate = $payrates->flat_regional_sunday;
                        $saturday_day_rate = $payrates->flat_regional_saturday;
                        $saturday_night_rate = $payrates->flat_regional_saturday;
                        $ph_day_rate = $payrates->flat_regional_public_holiday;
                        $ph_night_rate = $payrates->flat_regional_public_holiday;
    }
                }
                elseif($result->pay_by != null)
                {
                    // Guard payrate here
                    if ($result->pay_by == 'award') {
                        $pay_rate = $payrates->pf_day;
                        $day_rate = $payrates->pf_day;
                        $night_rate = $payrates->pf_night;

                        $sunday_day_rate = $payrates->pf_sun;
                        $sunday_night_rate = $payrates->pf_sun;
                        $saturday_day_rate = $payrates->pf_sat;
                        $saturday_night_rate = $payrates->pf_sat;
                        $ph_day_rate = $payrates->pf_ph;
                        $ph_night_rate = $payrates->pf_ph;
                    }elseif($result->pay_by == 'eba' || $result->pay_by == 'abn')
                    {
                        if ($result->stateType == 'metropolitan') {
           $pay_rate = $payrates->flat_metro_week_day_day;
                        $day_rate = $payrates->flat_metro_week_day_day;
                        $night_rate = $payrates->flat_metro_week_day_night;

                        $sunday_day_rate = $payrates->flat_metro_sunday;
                        $sunday_night_rate = $payrates->flat_metro_sunday;
                        $saturday_day_rate = $payrates->flat_metro_saturday;
                        $saturday_night_rate = $payrates->flat_metro_saturday;
                        $ph_day_rate = $payrates->flat_metro_public_holiday;
                        $ph_night_rate = $payrates->flat_metro_public_holiday;             
    }else{
        $pay_rate = $payrates->flat_regional_week_day_day;
                        $day_rate = $payrates->flat_regional_week_day_day;
                        $night_rate = $payrates->flat_regional_week_day_night;

                        $sunday_day_rate = $payrates->flat_regional_sunday;
                        $sunday_night_rate = $payrates->flat_regional_sunday;
                        $saturday_day_rate = $payrates->flat_regional_saturday;
                        $saturday_night_rate = $payrates->flat_regional_saturday;
                        $ph_day_rate = $payrates->flat_regional_public_holiday;
                        $ph_night_rate = $payrates->flat_regional_public_holiday;
    }

                    }
                }

      }
      elseif ($result->payrol == 'Default Rates') {
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

                    }else{
                        // print('<pre>');
                        // print_r($result);
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

                    // if($day == 'Sunday' || $day == 'sunday'){
                    //      if ($result->stateType == 'metropolitan') {
                    //     $pay_rate = $payrates->flat_metro_sunday;
                    //     $day_rate = $payrates->flat_metro_sunday;
                    //     $night_rate = $payrates->flat_metro_sunday_night;
                    //     }else{
                    //     $pay_rate = $payrates->flat_regional_sunday;
                    //     $day_rate = $payrates->flat_regional_sunday;
                    //     $night_rate = $payrates->flat_regional_sunday_night;
                    //     }
                    // }elseif($day == 'Saturday' || $day == 'saturday'){
                    //     if ($result->stateType == 'metropolitan') {
                    //     $pay_rate = $payrates->flat_metro_saturday;
                    //     $day_rate = $payrates->flat_metro_saturday;
                    //     $night_rate = $payrates->flat_metro_saturday_night;
                    //     }else{
                    //     $pay_rate = $payrates->flat_regional_saturday;
                    //     $day_rate = $payrates->flat_regional_saturday;
                    //     $night_rate = $payrates->flat_regional_saturday_night;
                    //     }
                    // }
                }elseif ($result->payrol == 'Award Rates') { 
                    // start eba rates
                    if ($result->stateType == 'metropolitan') {
                        if(isset($payrates->award_metro_weekday_day)){
                        $pay_rate = $payrates->award_metro_weekday_day;
                        $day_rate = $payrates->award_metro_weekday_day;
                        $night_rate = $payrates->award_metro_weekday_night;

                        $sunday_day_rate = $payrates->award_metro_sunday_day;
                        $sunday_night_rate = $payrates->award_metro_sunday_day;
                        $saturday_day_rate = $payrates->award_metro_saturday_day;
                        $saturday_night_rate = $payrates->award_metro_saturday_night;
                        $ph_day_rate = $payrates->award_metro_public_holiday;
                        $ph_night_rate = $payrates->award_metro_public_holiday_night;
                        }else{
                            $pay_rate = $payrates->eba_metro_weekday_day;
                        $day_rate = $payrates->eba_metro_weekday_day;
                        $night_rate = $payrates->eba_metro_weekday_night;

                        $sunday_day_rate = $payrates->eba_metro_sunday_day;
                        $sunday_night_rate = $payrates->eba_metro_sunday_day;
                        $saturday_day_rate = $payrates->eba_metro_saturday_day;
                        $saturday_night_rate = $payrates->eba_metro_saturday_night;
                        $ph_day_rate = $payrates->eba_metro_public_holiday;
                        $ph_night_rate = $payrates->eba_metro_public_holiday_night;
                        }

                    }else{
                        if(isset($payrates->award_regional_weekday_day)){
                        $pay_rate = $payrates->award_regional_weekday_day;
                        $day_rate = $payrates->award_regional_weekday_day;
                        $night_rate = $payrates->award_regional_weekday_night;

                        $sunday_day_rate = $payrates->award_regional_sunday_day;
                        $sunday_night_rate = $payrates->award_regional_sunday_night;
                        $saturday_day_rate = $payrates->award_regional_saturday_day;
                        $saturday_night_rate = $payrates->award_regional_saturday_night;
                        $ph_day_rate = $payrates->award_regional_public_holiday;
                        $ph_night_rate = $payrates->award_regional_public_holiday_night;
                        }else{
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
                else{ 
                    if (!empty($payrates)) {
                        // dd($payrates);
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

                    }else{
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
                    // if($day == 'Sunday' || $day == 'sunday'){
                    //      if ($result->stateType == 'metropolitan') {
                    //     $pay_rate = $payrates->eba_metro_weekend_sun;
                    //     $day_rate = $payrates->eba_metro_weekend_sun;
                    //     $night_rate = $payrates->eba_metro_weekend_sun;
                    //     }else{
                    //     $pay_rate = $payrates->eba_regional_weekend_sun;
                    //     $day_rate = $payrates->eba_regional_weekend_sun;
                    //     $night_rate = $payrates->eba_regional_weekend_sun;
                    //     }
                    // }elseif($day == 'Saturday' || $day == 'saturday'){
                    //     if ($result->stateType == 'metropolitan') {
                    //     $pay_rate = $payrates->eba_metro_weekend;
                    //     $day_rate = $payrates->eba_metro_weekend;
                    //     $night_rate = $payrates->eba_metro_weekend;
                    //     }else{
                    //     $pay_rate = $payrates->eba_regional_weekend;
                    //     $day_rate = $payrates->eba_regional_weekend;
                    //     $night_rate = $payrates->eba_regional_weekend;
                    //     }
                    // }
                }
            }
            
            if ($ph_day_rate == '') {
                $ph_day_rate = 0;
            }
            if ($ph_night_rate == '') {
                $ph_night_rate = 0;
            }
            $pay_rate = $result->overtime_value * $pay_rate;
            $day_rate = $result->overtime_value * $day_rate;
            $night_rate = $result->overtime_value * $night_rate;
            $sunday_day_rate = $result->overtime_value * $sunday_day_rate;
            $sunday_night_rate = $result->overtime_value * $sunday_night_rate;
            $saturday_day_rate = $result->overtime_value * $saturday_day_rate;
            $saturday_night_rate = $result->overtime_value * $saturday_night_rate;
            // echo $result->overtime_value.'-';
            // echo $ph_day_rate.'<br>';
            $ph_day_rate = $result->overtime_value * $ph_day_rate * 1;
            $ph_night_rate = $result->overtime_value * $ph_night_rate * 1;
            
            $activity = DB::table('job_roster_activities')->where('guard_id', $result->guard_id)->where('job_roster_id', $result->roster_id)->first();
            // $activity = $break->result_array();

            if(empty($activity)){
              $activity = array();
            }
            $break = DB::table('job_breaks')->where('roster_id', $result->roster_id)->where('guard_id', $result->guard_id)->get();
            $break_time = $break;
            if(empty($break_time)){
              $break_time = array();
            }
           
            $number_of_breaks= count($break);
            if ($result->travel_time_payable == 'no') {
                $result->travel_time = 0;
            }
            // $query_break->row_array();
            // if(!empty($query_break)){
            //   // $pay_rate = $customer_rates['eba_metro_weekday_day'];
            // }
            $payable_and_chargeable_time = 0;
            if ($result->break_payable == 'no' && $result->break == 1) {
                // $total = $total - $result->payable_and_chargeable_time/60;
                $payable_and_chargeable_time = $result->payable_and_chargeable_time/60;
                // if ($job_hours['morning'] > $payable_and_chargeable_time) {
                //     $job_hours['morning'] = $job_hours['morning'] - $payable_and_chargeable_time;
                // }else{
                //     $job_hours['night'] = $job_hours['night'] - $payable_and_chargeable_time;
                // }
                if ($payable_and_chargeable_time > 0 && $payable_and_chargeable_time <= 0.25) {
                  $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.25 && $payable_and_chargeable_time <= 0.5) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0.25);
                    $job_hours['morning'] = $breakCal[0];
                    $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.5 && $payable_and_chargeable_time <= 0.75) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.25);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.75 && $payable_and_chargeable_time <= 1) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.5);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[1];
                }
            }else{
                $result->payable_and_chargeable_time = 0;
                $result->break_payable = '-';
            }

            if ($result->break_enabled == 1 && $result->break_deduction_time > 0) {
                // $total = $total - $result->payable_and_chargeable_time/60;
                $payable_and_chargeable_time -= $result->break_deduction_time/60;
                // if ($job_hours['morning'] > $payable_and_chargeable_time) {
                //     $job_hours['morning'] = $job_hours['morning'] - $payable_and_chargeable_time;
                // }else{
                //     $job_hours['night'] = $job_hours['night'] - $payable_and_chargeable_time;
                // }
                if ($payable_and_chargeable_time > 0 && $payable_and_chargeable_time <= 0.25) {
                  $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.25 && $payable_and_chargeable_time <= 0.5) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0.25);
                    $job_hours['morning'] = $breakCal[0];
                    $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.5 && $payable_and_chargeable_time <= 0.75) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.25);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.75 && $payable_and_chargeable_time <= 1) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.5);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[1];
                }
            }
            $result->payable = $result->break_payable;
            if ($result->travel_time_amount == '' || $result->travel_time_amount ==  null) {
                $result->travel_time_amount = 0;
            }
            $item = [
                'roster_id' => $result->roster_id,
                'event_id' => $result->event_id,
                'pw_order' => $result->pw_order,
                'guard_id' => $result->guard_id,
                'site_id' => $result->site_id,
                'start' => $result->start,
                'end' => $result->end,
                'temp_date' => date('d-m-Y', strtotime($result->temp_date)),
                'temp_start' =>  $tempStart,
                'temp_end' => $tempEnd,
                'total_hours' => $total,
                'publish_status' => $result->publish_status,
                'add_status' => $result->add_status,
                'job_status' => $result->job_status,
                'job_id' => $result->id,
                'booking_id' => $result->booking_id,
                'customer_id' => $result->customer_id,
                'contractor_id' => $result->contractor_id,
                'state' => $result->state,
                'level' => $result->level,
                'stateType' => $result->stateType,
                'address' => $result->address,
                'site_name' => $result->site_name,
                'site_description' => $result->site_description,
                'customer_name' => $result->customer_name,
                'contractor_name' => $result->contractor_name,
                'guard_type' => $result->guard_type,
                'guard_name' => $result->guard_name,
                'guard_image' => $result->guard_image,
                'guard_id' => $result->guard_id,
                'guard_email' => $result->guard_email,
                'guard_address' => $result->guard_address,
                'guard_phone' => $result->guard_phone,
                
                'guard_suburb' => $result->guard_suburb,
                'guard_city' => $result->guard_city,
                'guard_state' => $result->guard_state,
                'guard_coordinates' => $result->guard_coordinates,
                'guard_postal_code' => $result->guard_postal_code,
                'guard_dob' => $result->guard_dob,
                'guard_gender' => $result->guard_gender,
                'emergency_contact_name' => $result->emergency_contact_name,
   
                'emergency_contact_phone' => $result->emergency_contact_phone,
                'registration_type' => $result->registration_type,
                'residential_status' => $result->residential_status,
                'passport_number' => $result->passport_number,
                'passport_expiration' => $result->passport_expiration,
                'visa_number' => $result->visa_number,
                'visa_expiration' => $result->visa_expiration,
                'security_license_number' => $result->security_license_number,
                   
                'security_license_expiration' => $result->security_license_expiration,
                'driver_license_number' => $result->driver_license_number,
                'driver_license_expiration' => $result->driver_license_expiration,
                'is_approved' => $result->is_approved,
                'bsb' => $result->bsb,
                'payroll_bank_name' => $result->payroll_bank_name,
                'payroll_bank_account_number' => $result->payroll_bank_account_number,
                'covid' => $result->covid,

                'fortnightly_working_hours' => $result->fortnightly_working_hours,
                'payroll_tfn_number' => $result->payroll_tfn_number,
                'payroll_abn_number' => $result->payroll_abn_number,
                'payroll_superannutation' => $result->payroll_superannutation,
                'payroll_bank_name' => $result->payroll_bank_name,
                'payroll_bank_account_number' => $result->payroll_bank_account_number,
                // 'guard_rates' => $guard_rates,
                'break_time' => $break_time,
                'number_of_breaks' => $number_of_breaks,
                'activity'=> $activity,
                'job_hours' => $job_hours,
                'phone' => $result->phone,
                'description' => strip_tags($result->details),
                'level' => 'Level '.$result->level,
                'day_hours' => $job_hours['morning'] + $result->travel_time,
                'night_hours' => $job_hours['night'],
                'external_id' => $result->external_id,
                'payroll_id' => $result->payroll_id,
                'internal_id' => $result->internal_id,
                'total_amount' => ((($job_hours['morning'] + $result->travel_time) * $day_rate) + ($job_hours['night'] * $night_rate) + ($job_hours['sunday_morning'] * $sunday_day_rate) + ($job_hours['sunday_night'] * $sunday_night_rate) + ($job_hours['saturday_morning'] * $saturday_day_rate) + ($job_hours['saturday_night'] * $saturday_night_rate) + ($job_hours['ph_morning'] * $ph_day_rate) + ($job_hours['ph_night'] * $ph_night_rate) + $result->travel_time_amount),
                'total_calculates_hours' => (($job_hours['morning'] + $result->travel_time) + $job_hours['night'] + $job_hours['sunday_morning']  + $job_hours['sunday_night']  + $job_hours['saturday_morning']  + $job_hours['saturday_night']  + $job_hours['ph_morning']  + $job_hours['ph_night'] + $result->travel_time_amount),
                'pay_rate' => $pay_rate,
                'day_rate' => $day_rate,
                'night_rate' => $night_rate,
                'hours' => $total,
                'operators_notes' => $result->operators_notes,
                'payable' => $result->payable,
                'payable_and_chargeable_time' => $result->payable_and_chargeable_time,
                'travel_time' => $result->travel_time,
                'travel_time_pay' => $day_rate * $result->travel_time + $result->travel_time_amount,
                'saturday_day_rate' => $saturday_day_rate,
                'saturday_night_rate' => $saturday_night_rate,
                'sunday_day_rate' => $sunday_day_rate,
                'sunday_night_rate' => $sunday_night_rate,
                'sunday_day_hours' => $job_hours['sunday_morning'],
                'sunday_night_hours' => $job_hours['sunday_night'],
                'saturday_day_hours' => $job_hours['saturday_morning'],
                'saturday_night_hours' => $job_hours['saturday_night'],
                'ph_day_hours' => $job_hours['ph_morning'],
                'ph_night_hours' => $job_hours['ph_night'],
                'ph_day_rate' => $ph_day_rate,
                'ph_night_rate' => $ph_night_rate,
                'ot' => $result->overtime_value,
                'ot_base_rate' => $ot_base_rate,
                'shift_level' => $result->shift_level,
                'training' => $result->training == 1 ? 'yes' : 'no',
                'payrates' => $payrates
            ];
            if (($result->guard_id == 0 || $result->guard_id == null) && $result->moke_guard != '') {
                $item['guard_name'] = $result->moke_guard;
            }
                    // if($day == 'Sunday' || $day == 'sunday'){
                        // $item['sunday_day_hours'] =  $job_hours['morning'];
                        // $item['sunday_night_hours'] = $job_hours['night'];
                        // $item['sunday_day_rate'] = $day_rate;
                        // $item['sunday_night_rate'] = $night_rate;
                        // $item['saturday_day_hours'] = 0;
                        // $item['saturday_night_hours'] = 0;
                        // $item['day_hours'] = 0;
                        // $item['night_hours'] = 0;
                    // }elseif($day == 'Saturday' || $day == 'saturday'){
                        // $item['saturday_day_hours'] =  $job_hours['morning'];
                        // $item['saturday_night_hours'] = $job_hours['night'];
                        // $item['saturday_day_rate'] = $day_rate;
                        // $item['saturday_night_rate'] = $night_rate;
                        // $item['sunday_day_hours'] =  0;
                        // $item['sunday_night_hours'] = 0;
                        // $item['day_hours'] = 0;
                        // $item['night_hours'] = 0;
                    // }
                

            $user_activity = DB::table('job_roster_activities')->where('job_roster_id', $result->roster_id)->first();
            if (!empty($user_activity)) {
              $item['signin_notes'] = $user_activity->signin_notes;
              $item['signout_notes'] = $user_activity->signout_notes;
            }else{
              $item['signin_notes'] = 'N/A';
              $item['signout_notes'] = 'N/A';
            }
            $total_hours = explode('.', $item['total_hours']);
            if (sizeof($total_hours) > 1 ) {
              $partial = '.'.$total_hours[1];
              if ($partial < 0.1) {
                $item['total_hours'] = $total_hours[0];
              }
              if ($partial < 0.27 && $partial > 0.1) {
                $item['total_hours'] = $total_hours[0].'.25';
              }
              if ($partial > 0.27 && $partial <= 0.52) {
                $item['total_hours'] = $total_hours[0].'.5';
              }
              if ($partial > 0.52 && $partial <= 0.77) {
                $item['total_hours'] = $total_hours[0].'.75';
              }
              if ($partial > 0.77 && $partial < 1) {
                $item['total_hours'] = $total_hours[0]+ 1;
              }
            }
            if ($result->continuation == 0) {
            if ($item['total_hours'] < 4) {
              $item['total_hours'] = 4;
            }
            }
            $total_hours = explode('.', $item['hours']);
            if (sizeof($total_hours) > 1 ) {
              $partial = '.'.$total_hours[1];
              if ($partial < 0.1) {
                $item['hours'] = $total_hours[0];
              }
              if ($partial < 0.27 && $partial > 0.1) {
                $item['hours'] = $total_hours[0].'.25';
              }
              if ($partial > 0.27 && $partial <= 0.52) {
                $item['hours'] = $total_hours[0].'.5';
              }
              if ($partial > 0.52 && $partial <= 0.77) {
                $item['hours'] = $total_hours[0].'.75';
              }
              if ($partial > 0.77 && $partial < 1) {
                $item['hours'] = $total_hours[0]+ 1;
              }
            }
            if ($result->continuation == 0) {
            if ($item['hours'] < 4) {
              $item['hours'] = 4;
            }
            }
            if($result->job_status == 'completed'){
              $item['status'] = 'Approved';
            }else{
              $item['status'] = 'Unapproved';
            }

            if ($specific_sites_id != null && !empty($specific_sites_id)) {
              foreach ($specific_sites_id as $key => $value) {
                if ($result->site_id == $value) {
                array_push( $data, $item);
                }
              }
            }else{
            array_push( $data, $item);
            }
        }
        return $data;
    }

    // function customer_detail_report(Request $request){
    //   $query=  $this->contractor_report_model->get_search_record();
    //   $customer=$query->where('customers.id',$request->id)->get();
    //   return $customer;
    // }

    function geneateCustomerReport($request)
    {
        
        if ($request->has('date') && $request->date != '' ) {
        $date = $request->date;
        $date = explode('-', $date);
        $from = strtotime(trim($date[0]));
        $to = strtotime(trim($date[1]));
        }else{
        $to = time();
        $from = time() - (60*60*24*7);
        }
        $customerSites = $this->report_model->customerSites($request->customer_id);
        $all_data = array();
        $specific_customer = DB::table('customers')->where('id',$request->customer_id)->first();
        $all_data['customer']['name']=$specific_customer->name;
        $all_data['customer']['total_site'] = 0;
        $all_data['customer']['total_hours'] = 0;
        $all_data['customer']['total_amount'] = 0;
        $all_data['customer']['state'] = $specific_customer->state;
        foreach ($customerSites as $key => $sites) {
            $rate = 0;
            if ($sites->charged_rates_id != null && $sites->charged_rates_id > 0) {
                $charge_rate = DB::table('charged_rates')->where('id', $sites->charged_rates_id)->first();
            }else{
                $charge_rate = DB::table('charged_rates')->where('level', $sites->level)->where('state', $sites->state)->first();
            }

        if (!empty($charge_rate)) {
                if ($sites->payrol == 'Default Rates') {
                    if ($sites->stateType == 'metropolitan') {
                        $rate = $charge_rate->flat_metro_flat_metro_week_day;
                    }else{
                        $rate = $charge_rate->flat_regional_week_day;
                    }
                }else{
                    if ($sites->stateType == 'metropolitan') {
                        $rate = $charge_rate->eba_metro_weekday_day;
                    }else{
                        $rate = $charge_rate->eba_regional_weekday_day;
                    }
                }
            }
          
            
            $data_by_site = $this->report_model->dataBySite($sites->siteId, $from, $to);
            $siteData = array();
            $siteData['site_name'] = $sites->site_name;
            $siteData['total_shifts'] = count($data_by_site);
            $siteData['total_hours'] = 0;
            $siteData['total_guards'] = 0;
            $siteData['rate'] = $rate;
            $siteData['amount'] = 0;
            $siteData['shifts'] = array();
            $siteData['shifts_by_day'] = array();
            $guards = array();

            foreach ($data_by_site as $key => $roster) {
                $hours = $this->getTimeDiff($roster->temp_start, $roster->temp_end);
                $siteData['total_hours'] = $siteData['total_hours'] + $hours['hours'] + ($hours['minutes']/60);
                if ($roster->guard_id > 0 && !isset($guards[$roster->guard_id])) {
                    $siteData['total_guards']++;
                    $guards[$roster->guard_id] = $roster->guard_id;
                }
                $siteData['shifts'][] = array(
                    'roster_id' => $roster->roster_id,
                    'start' => date('H:i', strtotime($roster->temp_start)),
                    'end' => date('H:i', strtotime($roster->temp_end)),
                    'hours' => $hours['hours'] + ($hours['minutes']/60),
                    'guard_name' => $roster->guard_name != '' ? $roster->guard_name : 'N/A'
                );
                if (!isset($siteData['shifts_by_day'][date('D', strtotime($roster->temp_start))])) {
                    $siteData['shifts_by_day'][date('D', strtotime($roster->temp_start))][] = array(
                    'roster_id' => $roster->roster_id,
                    'start' => date('H:i', strtotime($roster->temp_start)),
                    'end' => date('H:i', strtotime($roster->temp_end)),
                    'hours' => $hours['hours'] + ($hours['minutes']/60),
                    'guard_name' => $roster->guard_name != '' ? $roster->guard_name : 'N/A',
                    // 'day12' => date('d-m-y', strtotime($roster->temp_start)),
                );
                }
                else{
                    $siteData['shifts_by_day'][date('D', strtotime($roster->temp_start))][] = array(
                    'roster_id' => $roster->roster_id,
                    'start' => date('H:i', strtotime($roster->temp_start)),
                    'end' => date('H:i', strtotime($roster->temp_end)),
                    'hours' => $hours['hours'] + ($hours['minutes']/60),
                    'guard_name' => $roster->guard_name != '' ? $roster->guard_name : 'N/A',    
                    // 'day32' => date('d-m-y', strtotime($roster->temp_start)),

                );
                }
            }
            $siteData['amount'] = $siteData['total_hours'] * $siteData['rate'];
            $all_data['customer']['total_amount'] = $all_data['customer']['total_amount'] + $siteData['amount'];
            $all_data['customer']['total_hours'] = $all_data['customer']['total_hours'] + $siteData['total_hours'];
            if (count($data_by_site) > 0) { 
            $all_data['by_site'][] = $siteData;
            $all_data['customer']['total_site']++;
        }
        }
        // print_r('<pre>');
        // print_r($customerSites);
        // print_r($all_data);
        return $all_data;

    }
    function geneateCustomerReport_Excel_PDF(Request $request){
        $from1='';
        $to1='';
        if ($request->has('date') && $request->date != '' ) {
            $date = $request->date;
            $date = explode('-', $date);
            $from1 = strtotime(trim($date[0]));
            $to1 = strtotime(trim($date[1]));
        }else{
        $to1 = time();
        $from1 = time() - (60*60*24*14);
        }
        $report=$this->geneateCustomerReport($request);
        // echo $request;q          
    
    //   return $report;
    //     exit();
        $site = isset($report['by_site'])? $report['by_site'] : [] ;
        
        $customer=$report['customer'];
        $pdf_data = '<!DOCTYPE html>
        <html><head>
        <style>
        .bod{
          font-size: 14px;
          line-height: 1.42857143;
          color: #333;
          background-color: #fbfbfb;
        }
        .container-fluid{
          padding-right: 15px;
          padding-left: 15px;
          margin-right: auto;
          margin-left: auto;
        }
        .title{
          font-size: 25px;
          color:#000;
        }
        td{
          padding: 5px 0px;
        text-align: center !important;

        }
        .head1{
            background-color:#F4AF86
        }
        
        .head2{
            background-color:#FFFF00
        }
        
        .head3{
            background-color:#8FA9DB
        }
        
        .head4{
            background-color:#A9D08F
        }
        .head5{
            background-color:#A6A6A6
        }
        .head6{
            background-color:#D9D9D9
        }
        .head6_excel{
            background-color:#D9D9D9
        }
        .head6_excel > td{
            border:1px solid #000;
            text-align:left;
        }
        strong{
        font-size: 16px;

        }
        th{
          text-align:left;
        }
      
        .bod-1{
          border:1px solid #000;
          text-align:left;
    
        }
        </style></head>';
        // return $site;
        // exit();
        if($request->format=="excel"){
            if (!empty($site)) {
                $pdf_data.= $this->excel_preview_customer($customer,$site);
            }
            else{
                $pdf_data.='<table  style="width:100%;"> <tr class="head1">
                <td  class="bod-1">
                <div>
                <strong>Name</strong>
                </div>
                </td>
                <td  class="bod-1">
                <div>
                <strong>State</strong>
                </div>
                </td>
                <td  class="bod-1" >
                <div>
                <strong>Total Site</strong>
                </div>
                </td>
                <td  class="bod-1" >
                <div>
                <strong>Total Site Hours</strong>
                </div>
                </td>
                <td  class="bod-1" >
                <div>
                <strong>Gross Revenue</strong>
                </div>
                </td>
                </tr>';
                
                $pdf_data.=' <tr class="head2">
                <td  class="bod-1">
                <div>
                <strong>'.$customer['name'].'</strong>
                </div>
                </td>
                <td  class="bod-1">
                <div>
                <strong>'.$customer['state'].'</strong>
                </div>
                </td>
                <td  class="bod-1" >
                <div>
                <strong>'.$customer['total_site'].'</strong>
                </div>
                </td>
                <td  class="bod-1" >
                <div>
                <strong>'.number_format($customer['total_hours'], 2).'</strong>
                </div>
                </td>
                <td  class="bod-1" >
                <div>
                <strong>'.number_format($customer['total_amount'], 2).'</strong>
                </div>
                </td>
                </tr>';
        
                      
                $pdf_data.='<tr class="head3">
                <td  class="bod-1">
                <div>
                <strong>Site Name</strong>
                </div>
                </td>
                <td  class="bod-1">
                <div>
                <strong>Total Shift</strong>
                </div>
                </td>
                <td  class="bod-1" >
                <div>
                <strong>Total Shift Hours</strong>
                </div>
                </td>
                <td  class="bod-1" >
                <div>
                <strong>No. Of '.config('custom.guard').'</strong>
                </div>
                </td>
                <td  class="bod-1" >
                <div>
                <strong>Gross Revenue</strong>
                </div>
                </td>
                </tr></table>';
            }
            
            // echo $pdf_data;
            // exit();
             }else{
                
        $pdf_data.='<body class="bod">
        <div class="container-fluid">
        <div class="row">
        <table style="width:100%;">
        <tr>
        <td>
        <div>
        <div style="text-align: center;"><img class="navbar-brand-logo" src="'.config('custom.logo').'" title="'.config('custom.title').'" height="50"></div>
        <div style="text-align: center;" class="title">'.strtoupper(config('custom.title')).' Customer Report</div>
        </div>
        </td>
        </tr>
        </table>
        <table style="width:100%;">
        <tr style="width:100%;" >
        <th >
        <div>
        <strong>Date :</strong>'.date('d-m-Y', $from1).' to '.date('d-m-Y',$to1).'
        </div>
        </th>
        </tr>
        <tr>
        <th style="width:100%;">
        <div style="text-align: center;margin-top:-23px">
        <strong >Detail View</strong>
        </div>
        </th>
        </tr>
        
        </table></div>';
       
     
        if (!empty($site)) {
                    $pdf_data.= $this->excel_preview_customer($customer,$site);
                }else{
                    $pdf_data.='<table  style="width:100%;"> <tr class="head1">
                    <td  class="bod-1">
                    <div>
                    <strong>Name</strong>
                    </div>
                    </td>
                    <td  class="bod-1">
                    <div>
                    <strong>State</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Total Site</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Total Site Hours</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Gross Revenue</strong>
                    </div>
                    </td>
                    </tr>';
                    
                    $pdf_data.=' <tr class="head2">
                    <td  class="bod-1">
                    <div>
                    <strong>'.$customer['name'].'</strong>
                    </div>
                    </td>
                    <td  class="bod-1">
                    <div>
                    <strong>'.$customer['state'].'</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>'.$customer['total_site'].'</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>'.number_format($customer['total_hours'], 2).'</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>'.number_format($customer['total_amount'], 2).'</strong>
                    </div>
                    </td>
                    </tr>';
            
                          
                    $pdf_data.=' <tr class="head3">
                    <td  class="bod-1">
                    <div>
                    <strong>Site Name</strong>
                    </div>
                    </td>
                    <td  class="bod-1">
                    <div>
                    <strong>Total Shift</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Total Shift Hours</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>No. Of '.config('custom.guard').'</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Gross Revenue</strong>
                    </div>
                    </td>
                    </tr></table>';
                }
        }
     
        //   $pdf_data .='</div>
        // </td></tr></table></div>
        // </div>
        // </body></html>';
        $pdf_data .='</div></body></html>';

            // return $pdf_data;
            // exit();
            if($request->format == "excel"){
                return View('admin/report/excel', compact('pdf_data'));
            }else{
                $pdf_data = PDF::loadView('reports/rosterReport', ['data' => $pdf_data]);
                $pdf_data->setPaper('legal', 'landscape');

              return  $pdf_data->stream(date('d/m/Y').'_paysheet_report.pdf');
            }
    
    }

    function excel_preview_customer($customer,$site){
        // print_r('<pre>');
        // print_r($site);
        // exit();

        $pdf_data='<table  style="width:100%;"><tr><td><tr class="head1">
        <td  class="bod-1">
        <strong>Name</strong>
        </td>
        <td  class="bod-1">
        <strong>State</strong>
        </td>
        <td  class="bod-1" >
        <strong>Total Site</strong>
        </td>
        <td  class="bod-1" >
        <strong>Total Site Hours</strong>
        </td>
        <td  class="bod-1" >
        <strong>Gross Revenue</strong>
        </td>
        </tr>';
        $pdf_data.=' <tr class="head2">
        <td  class="bod-1">
        <strong>'.$customer['name'].'</strong>
        </td>
        <td  class="bod-1">
        <strong>'.$customer['state'].'</strong>
        </td>
        <td  class="bod-1" >
        <strong>'.$customer['total_site'].'</strong>
        </td>
        <td  class="bod-1" >
        <strong>'.number_format($customer['total_hours'], 2).'</strong>
        </td>
        <td  class="bod-1" >
        <strong>'.number_format($customer['total_amount'], 2).'</strong>
        </td>
        </tr>';
        $pdf_data.='</td></tr>';
        $pdf_data.='</table>';
        foreach ($site as $pi) {
     $pdf_data .='<table><tr></tr></table><table style="width:100%;"><tr class="head3">
     <td  class="bod-1">
     <strong>Site Name</strong>
     </td>
     <td  class="bod-1">
     <strong>Total Shift</strong>
     </td>
     <td  class="bod-1" >
     <strong>Total Shift Hours</strong>
     </td>
     <td  class="bod-1" >
     <strong>No. Of '.config('custom.guard').'</strong>
     </td>
     <td  class="bod-1" >
     <strong>Gross Revenue</strong>
     </td>
     </tr>
     <tr class="head4">
   <td class="bod-1">'.$pi['site_name'].'</td>
   <td class="bod-1">'.$pi['total_shifts'].'</td>
   <td class="bod-1">'.round($pi['total_hours']).'</td>
   <td class="bod-1">'.$pi['total_guards'].'</td>
   <td class="bod-1">'.round($pi['amount']).'</td>
   </tr>';
   $pdf_data .='<table style="width:100%;">
     
   <tr class="head5">
   <td class="bod-1"><strong>Monday</strong></td>
   <td class="bod-1"><strong>Tuesday</strong></td>
   <td class="bod-1"><strong>Wednesday</strong></td>
   <td class="bod-1"><strong>Thursday</strong></td>
   <td class="bod-1"><strong>Friday</strong></td>
   <td class="bod-1"><strong>Saturday</strong></td>
   <td class="bod-1"><strong>Sunday</strong></td>
 </tr>';
 // $pdf_data.='<tr class="head6">';
   $mon_data = '';
   $tue_data = '';
   $wed_data = '';
   $thu_data = '';
   $fri_data = '';
   $sat_data = '';
   $sun_data = '';
   $max_shifts_in_day = 0;
   foreach ($pi['shifts_by_day'] as $key => $shifts) {
       if (count($shifts) > $max_shifts_in_day) {
           $max_shifts_in_day = count($shifts);
       }
   }

   // echo $max_shifts_in_day;
   // exit();
   // foreach($pi['shifts_by_day'] as $key => $pp){
   for ($i=0; $i < $max_shifts_in_day ; $i++) { 
    $pdf_data.='<tr class="head6_excel">';
   
   if (isset($pi['shifts_by_day']['Mon']) && isset($pi['shifts_by_day']['Mon'][$i])){
           $pdf_data .= '<td  class="bod-1">'.$pi['shifts_by_day']['Mon'][$i]['start'].'-'.$pi['shifts_by_day']['Mon'][$i]['end'].'='.number_format($pi['shifts_by_day']['Mon'][$i]['hours'],2).'hrs'.'   '.'<br>'.$pi['shifts_by_day']['Mon'][$i]['guard_name'].'</td>';
    }else{
        $pdf_data .= '<td  class="bod-1"></td>';
    }
    if (isset($pi['shifts_by_day']['Tue']) && isset($pi['shifts_by_day']['Tue'][$i])){
           $pdf_data .= '<td  class="bod-1">'.$pi['shifts_by_day']['Tue'][$i]['start'].'-'.$pi['shifts_by_day']['Tue'][$i]['end'].'='.number_format($pi['shifts_by_day']['Tue'][$i]['hours'],2).'hrs'.'   '.'<br>'.$pi['shifts_by_day']['Tue'][$i]['guard_name'].'</td>';
    }else{
        $pdf_data .= '<td  class="bod-1"></td>';
    }
    if (isset($pi['shifts_by_day']['Wed']) && isset($pi['shifts_by_day']['Wed'][$i])){
           $pdf_data .= '<td  class="bod-1">'.$pi['shifts_by_day']['Wed'][$i]['start'].'-'.$pi['shifts_by_day']['Wed'][$i]['end'].'='.number_format($pi['shifts_by_day']['Wed'][$i]['hours'],2).'hrs'.'   '.'<br>'.$pi['shifts_by_day']['Wed'][$i]['guard_name'].'</td>';
    }else{
        $pdf_data .= '<td  class="bod-1"></td>';
    }
    if (isset($pi['shifts_by_day']['Thu']) && isset($pi['shifts_by_day']['Thu'][$i])){
           $pdf_data .= '<td  class="bod-1">'.$pi['shifts_by_day']['Thu'][$i]['start'].'-'.$pi['shifts_by_day']['Thu'][$i]['end'].'='.number_format($pi['shifts_by_day']['Thu'][$i]['hours'],2).'hrs'.'   '.'<br>'.$pi['shifts_by_day']['Thu'][$i]['guard_name'].'</td>';
    }else{
        $pdf_data .= '<td  class="bod-1"></td>';
    }
    if (isset($pi['shifts_by_day']['Fri']) && isset($pi['shifts_by_day']['Fri'][$i])){
           $pdf_data .= '<td  class="bod-1" >'.$pi['shifts_by_day']['Fri'][$i]['start'].'-'.$pi['shifts_by_day']['Fri'][$i]['end'].'='.number_format($pi['shifts_by_day']['Fri'][$i]['hours'],2).'hrs'.'   '.'<br>'.$pi['shifts_by_day']['Fri'][$i]['guard_name'].'</td>';
    }else{
        $pdf_data .= '<td  class="bod-1"></td>';
    }
    if (isset($pi['shifts_by_day']['Sat']) && isset($pi['shifts_by_day']['Sat'][$i])){
           $pdf_data .= '<td  class="bod-1">'.$pi['shifts_by_day']['Sat'][$i]['start'].'-'.$pi['shifts_by_day']['Sat'][$i]['end'].'='.number_format($pi['shifts_by_day']['Sat'][$i]['hours'],2).'hrs'.'   '.'<br>'.$pi['shifts_by_day']['Sat'][$i]['guard_name'].'</td>';
    }else{
        $pdf_data .= '<td  class="bod-1"></td>';
    }
    if (isset($pi['shifts_by_day']['Sun']) && isset($pi['shifts_by_day']['Sun'][$i])){
           $pdf_data .= '<td  class="bod-1">'.$pi['shifts_by_day']['Sun'][$i]['start'].'-'.$pi['shifts_by_day']['Sun'][$i]['end'].'='.number_format($pi['shifts_by_day']['Sun'][$i]['hours'],2).'hrs'.'   '.'<br>'.$pi['shifts_by_day']['Sun'][$i]['guard_name'].'</td>';
    }else{
        $pdf_data .= '<td  class="bod-1"></td>';
    }
    
   $pdf_data.='</tr>';

        }

   //      $pdf_data.='<td class="bod-1"><h5 style="text-align:center" >'.$mon_data.'</h5></td>';
   //      $pdf_data.='<td class="bod-1"><h5 style="text-align:center" >'.$tue_data.'</h5></td>';
   //      $pdf_data.='<td class="bod-1"><h5 style="text-align:center" >'.$wed_data.'</h5></td>';
   //      $pdf_data.='<td class="bod-1"><h5 style="text-align:center" >'.$thu_data.'</h5></td>';
   //      $pdf_data.='<td class="bod-1"><h5 style="text-align:center" >'.$fri_data.'</h5></td>';
   //      $pdf_data.='<td class="bod-1"><h5 style="text-align:center" >'.$sat_data.'</h5></td>';
   //      $pdf_data.='<td class="bod-1"><h5 style="text-align:center" >'.$sun_data.'</h5></td>';
   // $pdf_data.='</tr>';

    }
        $pdf_data.='</table>';
     return $pdf_data;
        
    }
    public function incident_report_page(){
        $customers=DB::table('customers')->where('status','!=','deleted')->orderBy('name','ASC')->get();
        return view('admin/report/incident_report',['customers' =>$customers]);
    }
    public function audit_report_page(){
        $customers=DB::table('customers')->where('status','!=','deleted')->orderBy('name','ASC')->get();
        return view('admin/report/audit_report',['customers' =>$customers]);
    }
    public function get_audit_report(Request $request){
        if (isset($request->date) && $request->date != '') {
            $date = $request->date;
            $date = explode('-', $date);
            $startDate = $this->DateFormater($date[0]);
            $endDate = $this->DateFormater($date[1]);
            return $data = DB::table('audit_form')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->where('guard_name', '!=', null)
            ->get();
        }
    }
    protected function DateFormater($rawDate){
        $rawDate = str_replace('/', '-', $rawDate);
        list($month, $day, $year) = explode('-',$rawDate);
        $date = "$year-$day-$month";
        return str_replace(' ', '', $date);
    }
    function get_incident_report(Request $request){
        
        $report = DB::table('incident_reports')
        ->join('guards', 'guards.id', '=', 'incident_reports.guard_id')
        ->join('jobs', 'jobs.id','=','incident_reports.job_id')
        ->join('job_new_roster', 'job_new_roster.roster_id', '=', 'incident_reports.roster_id')
        ->select('guards.name AS Guard_name',
        'incident_reports.id AS incident_id'
        ,'incident_reports.incident_date','incident_reports.photo AS incident_image','incident_reports.incident_time AS incident_time')
        ->where('incident_reports.job_id',$request->site_id)
        ->orderBy('incident_reports.created_at', 'desc')
        ->get();
        foreach($report as $r){
            $r->incident_time = date("H:i",strtotime($r->incident_time));
            $r->incident_date = date("d-m-y",strtotime($r->incident_date));
        }
        return $report;
    }
    function date_convert($date_format)
    {
        $date_split = explode('/', $date_format);
        if (sizeof($date_split) > 0) {
            list($date, $month, $year) = sscanf($date_format, '%d/%d/%d');
            if ($month < 9) {
                $month = '0' . $month;
            }
            return $month . '/' . $date . '/' . $year;
        } else {
            return $date_format;
        }
    }

    function invoice_report_data_new($request)
    {
        if (isset($request['date']) && $request['date'] != '') {
            $date = $request['date'];
            $date = explode('-', $date);
            $from = strtotime(trim($this->date_convert($date[0])));
            $to = strtotime(trim($this->date_convert($date[1])));
        }else{
        $to = time();
        $from = time() - (60*60*24*14);
        }
        $startDate = date('Y-m-d', $from);
        $endDate = date('Y-m-d', $to);
        $extra_query = '(jr.`job_status` = "completed" OR jr.`job_status` = "pending" OR jr.`job_status` = "confirmed" OR jr.`status_change_by` > 0) AND ';
        // $extra_query .= "j.`customer_id` = '".$request['customer_id']."' AND ";
        if (isset($request['customer_id']) && $request['customer_id'] != '' && $request['customer_id'] != 'undefined') {
        $customer_id = explode(',', $request['customer_id']);
        if (!empty($customer_id)) {
        $extra_query = "(";
        $i = 0;
        foreach ($customer_id as $key => $id) {
          $extra_query .= "j.`customer_id` = '".$id."'";
          if ($i < sizeof($customer_id) -1) {
            $extra_query .= " OR ";
        }
        $i++;
    }
    $extra_query .= ") AND ";
}
}
 if (isset($request['sites']) && $request['sites'] != '' && $request['sites'] != 'undefined') {
        $sites = explode(',', $request['sites']);
        if (!empty($sites)) {
        $extra_query .= "(";
        $i = 0;
        foreach ($sites as $key => $id) {
          $extra_query .= "jr.`site_id` = '".$id."'";
          if ($i < sizeof($sites) -1) {
            $extra_query .= " OR ";
        }
        $i++;
    }
    $extra_query .= ") AND ";
}
}
if (isset($request['guards']) && $request['guards'] != '' && $request['guards'] != 'undefined') {
        $guards = explode(',', $request['guards']);
        if (!empty($guards)) {
        $extra_query .= "(";
        $i = 0;
        foreach ($guards as $key => $id) {
          $extra_query .= "jr.`guard_id` = '".$id."'";
          if ($i < sizeof($guards) -1) {
            $extra_query .= " OR ";
        }
        $i++;
    }
    $extra_query .= ") AND ";
}
}
if (isset($request['state']) && $request['state'] != '') {
        $state = explode(',', $request['state']);
        if (!empty($state)) {
        $extra_query .= "(";

        foreach ($state as $key => $s) {
        $extra_query .= "j.`state` = '".$s."'";
        if ($key < sizeof($state) -1) {
            $extra_query .= " OR ";
        }
    }
    $extra_query .= ") AND ";

}
}
        $data = [];
        $sql = "SELECT
            jr.*,
            jr.`chargerate_id` AS shift_chargerate_id,
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
            j.`payable` AS break_payable,
            j.`break`,
            j.`payable_and_chargeable_time`,
            j.`other_metro_weekday_day`,
            j.`site_charge_rate` AS site_chargerate_id,
            j.`charge_apply_date`,
            j.`pw_order` AS site_pw_order,
            cust.`name` AS customer_name,
            cust.`charged_rates_id` as customer_chargerate_id,
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
            WHERE ".$extra_query."jr.`chargeable` = 'yes' AND jr.`temp_date` BETWEEN '".$startDate."' AND '".$endDate."' ORDER BY j.site_name ASC, jr.temp_start";
            // WHERE ".$extra_query."jr.`temp_date` BETWEEN '".$startDate."' AND '".$endDate."' AND j.`payable`='yes'";

            // WHERE jr.`job_status` = '".$jobStatus."' AND jr.temp_date BETWEEN '".$startDate."' AND '".$endDate."'";
            // INNER JOIN `guards` AS g ON g.`id` = jr.`guard_id`

            // echo $sql;exit();
        $query = DB::select($sql);
        $results = $query;
        // print_r('<pre>');
        // print_r(json_decode(json_encode($results), true));
        // exit();
        foreach ($results as $result) {
            $result->shift_level = 'N/A';
            $tempStart = date("H:i", strtotime($result->temp_start));
            $tempEnd = date("H:i", strtotime($result->temp_end));
            # calculate DST
            $timestamp_start = Carbon::parse($result->temp_start);
            $timestamp_start_dst = Carbon::parse($result->temp_start)->isDST();
            $timestamp_end = Carbon::parse($result->temp_end);
            $timestamp_end_dst = Carbon::parse($result->temp_end)->isDST();
            if ($timestamp_start_dst && !$timestamp_end_dst) {
                // DST is active at the start but not at the end
                $dst_hours = $timestamp_start->floatDiffInHours($timestamp_end) - 1;
            } elseif (!$timestamp_start_dst && $timestamp_end_dst) {
                // DST is active at the end but not at the start
                $dst_hours = $timestamp_start->floatDiffInHours($timestamp_end) + 1;
            } else {
                // DST status is the same at both start and end timestamps
                $dst_hours = $timestamp_start->floatDiffInHours($timestamp_end);
            }
            // $total = $result->hours;
            $total = $dst_hours;
            if ($result->continuation == 0 && $total < 4) {
                $end = strtotime($result->temp_end);
                $remaining = 4 - $total;
                $end = $end + (60*60*$remaining);
                $job_hours = $this->getShiftHours($result->temp_start,date('Y-m-d H:i', $end), $result->site_id, $result->public_holiday, $result->ph_duration);
                }else{
                $job_hours = $this->getShiftHours($result->temp_start,$result->temp_end, $result->site_id, $result->public_holiday, $result->ph_duration);
            }
            $job_hours['morning'] = $this->convertIntoWhole($job_hours['morning']);
            $job_hours['night'] = $this->convertIntoWhole($job_hours['night']);
            $job_hours['saturday_morning'] = $this->convertIntoWhole($job_hours['saturday_morning']);
            $job_hours['saturday_night'] = $this->convertIntoWhole($job_hours['saturday_night']);
            $job_hours['sunday_morning'] = $this->convertIntoWhole($job_hours['sunday_morning']);
            $job_hours['sunday_night'] = $this->convertIntoWhole($job_hours['sunday_night']);
            $job_hours['ph_morning'] = $this->convertIntoWhole($job_hours['ph_morning']);
            $job_hours['ph_night'] = $this->convertIntoWhole($job_hours['ph_night']);

            $charge_rate = 0;
            $day_rate = 0;
            $night_rate = 0;
            $saturday_day_rate = 0;
            $saturday_night_rate = 0;
            $sunday_day_rate = 0;
            $sunday_night_rate = 0;
            $ph_day_rate = 0;
            $ph_night_rate = 0;
            // if (is_array(json_decode($result->chargerate_applied, true)) && $result->chargerate_applied != '' && !empty(json_decode($result->chargerate_applied, true))) {
            //     $charged_rates = json_decode($result->chargerate_applied);
                // $charge_rate = DB::table('charged_rates')->where('id', $result->chargerate_id)->first();
            // }else{
            if ($result->shift_chargerate_id > 0 && $result->custom_rates == 'yes') {
                    $charged_rates = DB::table('charged_rates')->where('id', $result->shift_chargerate_id)->first();
                    if (!empty($charged_rates)) {
                    // $result->level = $payrates->level;
                    $result->shift_level = $charged_rates->level;
                }
                }elseif($result->site_chargerate_id > 0){
                    $charged_rates = DB::table('charged_rates')->where('id', $result->site_chargerate_id)->first();
                    if ($result->charge_apply_date != '') {
                        if (strtotime($result->charge_apply_date) > strtotime($result->temp_start)) {
                            $history = DB::table('site_chargerate_history')
                            ->where('site_id', $result->site_id)
                            ->where('apply_date', '>=', strtotime($result->temp_start))
                            ->orderBy('apply_date', 'desc')->first();
                            // dd([$result, $charged_rates, $history]);
                            if (!empty($history)) {
                                $charged_rates = DB::table('charged_rates')->where('id', $history->chargerate_id)->first();
                            }
                        }
                    }
                }elseif($result->customer_chargerate_id > 0){
                    $charged_rates = DB::table('charged_rates')->where('id', $result->customer_chargerate_id)->first();
                    if (isset($charged_rates) && $charged_rates->effective_date != '') {
                        if (strtotime($charged_rates->effective_date) > strtotime($result->temp_start)) {
                            $history = DB::table('site_chargerate_history')
                            ->where('site_id', $result->site_id)
                            ->where('apply_date', '<=', strtotime($result->temp_start))
                            ->orderBy('apply_date', 'desc')->first();
                            if (!empty($history)) {
                                $charged_rates = DB::table('charged_rates')->where('id', $history->chargerate_id)->first();
                            }
                        }
                    }
                }else{
                    // $pay_rate = DB::table('charged_rates')->where('id', $roster->site_payrate)->first();
                    $charged_rates = array();
                }
            // }
            $day = Carbon::parse($result->temp_start)->format('l');
            if (!empty($charged_rates)) {
            if ($result->payrol == 'Default Rates') {
                    if ($result->stateType == 'metropolitan') {
                        $charge_rate = $charged_rates->flat_metro_week_day_day;
                        $day_rate = $charged_rates->flat_metro_week_day_day;
                        $night_rate = $charged_rates->flat_metro_week_day_night;

                        $sunday_day_rate = $charged_rates->flat_metro_sunday;
                        $sunday_night_rate = $charged_rates->flat_metro_sunday_night;
                        $saturday_day_rate = $charged_rates->flat_metro_saturday;
                        $saturday_night_rate = $charged_rates->flat_metro_saturday_night;
                        $ph_day_rate =  $charged_rates->flat_metro_public_holiday;
                        $ph_night_rate = $charged_rates->flat_metro_public_holiday_night;

                    }else{
                        $charge_rate = $charged_rates->flat_regional_week_day_day;
                        $day_rate = $charged_rates->flat_regional_week_day_day;
                        $night_rate = $charged_rates->flat_regional_week_day_night;

                        $sunday_day_rate = $charged_rates->flat_regional_sunday;
                        $sunday_night_rate = $charged_rates->flat_regional_sunday_night;
                        $saturday_day_rate = $charged_rates->flat_regional_saturday;
                        $saturday_night_rate = $charged_rates->flat_regional_saturday_night;
                        $ph_day_rate =  $charged_rates->flat_regional_public_holiday;
                        $ph_night_rate = $charged_rates->flat_regional_public_holiday_night;
                    }
                }else{
                    // start eba rates
                    if ($result->stateType == 'metropolitan') {
                        $charge_rate = $charged_rates->eba_metro_weekday_day;
                        $day_rate = $charged_rates->eba_metro_weekday_day;
                        $night_rate = $charged_rates->eba_metro_weekday_night;

                        $sunday_day_rate = $charged_rates->eba_metro_sunday_day;
                        $sunday_night_rate = $charged_rates->eba_metro_sunday_night;
                        $saturday_day_rate = $charged_rates->eba_metro_saturday_day;
                        $saturday_night_rate = $charged_rates->eba_metro_saturday_night;
                        $ph_day_rate =  $charged_rates->eba_metro_public_holiday;
                        $ph_night_rate = $charged_rates->eba_metro_public_holiday_night;

                    }else{
                        $charge_rate = $charged_rates->eba_regional_weekday_day;
                        $day_rate = $charged_rates->eba_regional_weekday_day;
                        $night_rate = $charged_rates->eba_regional_weekday_night;

                        $sunday_day_rate = $charged_rates->eba_regional_sunday_day;
                        $sunday_night_rate = $charged_rates->eba_regional_sunday_night;
                        $saturday_day_rate = $charged_rates->eba_regional_saturday_day;
                        $saturday_night_rate = $charged_rates->eba_regional_saturday_night;
                        $ph_day_rate =  $charged_rates->eba_regional_public_holiday;
                        $ph_night_rate = $charged_rates->eba_regional_public_holiday_night;
                    }
                }
            }

             $activity = DB::table('job_roster_activities')->where('guard_id', $result->guard_id)->where('job_roster_id', $result->roster_id)->first();
            // $activity = $break->result_array();

            if(empty($activity)){
              $activity = array();
            }
            $break = DB::table('job_breaks')->where('roster_id', $result->roster_id)->where('guard_id', $result->guard_id)->get();
            $break_time = $break;
            if(empty($break_time)){
              $break_time = array();
            }
           
            $number_of_breaks= count($break);
            if ($result->travel_time_chargeable == 'no') {
                $result->travel_time = 0;
            }
            // $query_break->row_array();
            // if(!empty($query_break)){
            //   // $pay_rate = $customer_rates['eba_metro_weekday_day'];
            // }

            if ($result->break_payable == 'no' && $result->break == 1) {
                // $total = $total - $result->payable_and_chargeable_time/60;
                $payable_and_chargeable_time = $result->payable_and_chargeable_time/60;
                // if ($job_hours['morning'] > $payable_and_chargeable_time) {
                //     $job_hours['morning'] = $job_hours['morning'] - $payable_and_chargeable_time;
                // }else{
                //     $job_hours['night'] = $job_hours['night'] - $payable_and_chargeable_time;
                // }
                if ($payable_and_chargeable_time > 0 && $payable_and_chargeable_time <= 0.25) {
                  $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.25 && $payable_and_chargeable_time <= 0.5) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0.25);
                    $job_hours['morning'] = $breakCal[0];
                    $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.5 && $payable_and_chargeable_time <= 0.75) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.25);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.75 && $payable_and_chargeable_time <= 1) {
                     $breakCal = $this->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.5);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[1];
                }
            }else{
                $result->payable_and_chargeable_time = 0;
                $result->break_payable = '-';
            }
            $result->payable = $result->break_payable;
            $item = [
                'roster_id' => $result->roster_id,
                'event_id' => $result->event_id,
                'guard_id' => $result->guard_id,
                'site_id' => $result->site_id,
                'pw_order' => $result->pw_order,
                'site_pw_order' => $result->site_pw_order,
                'start' => $result->start,
                'end' => $result->end,
                'temp_date' => date('d-m-Y', strtotime($result->temp_date)),
                'temp_start' =>  $tempStart,
                'temp_end' => $tempEnd,
                'total_hours' => $total,
                'publish_status' => $result->publish_status,
                'add_status' => $result->add_status,
                'job_status' => $result->job_status,
                'job_id' => $result->id,
                'booking_id' => $result->booking_id,
                'customer_id' => $result->customer_id,
                'contractor_id' => $result->contractor_id,
                'state' => $result->state,
                'stateType' => $result->stateType,
                'address' => $result->address,
                'site_name' => $result->site_name,
                'site_description' => $result->site_description,
                'customer_name' => $result->customer_name,
                'contractor_name' => $result->contractor_name,
                'guard_type' => $result->guard_type,
                'guard_name' => $result->guard_name,
                'guard_image' => $result->guard_image,
                'guard_id' => $result->guard_id,
                'guard_email' => $result->guard_email,
                'guard_address' => $result->guard_address,
                'guard_phone' => $result->guard_phone,
                
                'guard_suburb' => $result->guard_suburb,
                'guard_city' => $result->guard_city,
                'guard_state' => $result->guard_state,
                'guard_coordinates' => $result->guard_coordinates,
                'guard_postal_code' => $result->guard_postal_code,
                'guard_dob' => $result->guard_dob,
                'guard_gender' => $result->guard_gender,
                'emergency_contact_name' => $result->emergency_contact_name,
   
                'emergency_contact_phone' => $result->emergency_contact_phone,
                'registration_type' => $result->registration_type,
                'residential_status' => $result->residential_status,
                'passport_number' => $result->passport_number,
                'passport_expiration' => $result->passport_expiration,
                'visa_number' => $result->visa_number,
                'visa_expiration' => $result->visa_expiration,
                'security_license_number' => $result->security_license_number,
                   
                'security_license_expiration' => $result->security_license_expiration,
                'driver_license_number' => $result->driver_license_number,
                'driver_license_expiration' => $result->driver_license_expiration,
                'is_approved' => $result->is_approved,
                'bsb' => $result->bsb,
                'payroll_bank_name' => $result->payroll_bank_name,
                'payroll_bank_account_number' => $result->payroll_bank_account_number,
                'covid' => $result->covid,

                'fortnightly_working_hours' => $result->fortnightly_working_hours,
                'payroll_tfn_number' => $result->payroll_tfn_number,
                'payroll_abn_number' => $result->payroll_abn_number,
                'payroll_superannutation' => $result->payroll_superannutation,
                'payroll_bank_name' => $result->payroll_bank_name,
                'payroll_bank_account_number' => $result->payroll_bank_account_number,
                // 'guard_rates' => $charged_rates,
                'break_time' => $break_time,
                'number_of_breaks' => $number_of_breaks,
                'activity'=> $activity,


                'phone' => $result->phone,
                'description' => strip_tags($result->details),
                'level' => 'Level '.$result->level,
                'day_hours' => $job_hours['morning'] + $result->travel_time,
                'night_hours' => $job_hours['night'],
                'external_id' => $result->external_id,
                'payroll_id' => $result->payroll_id,
                'internal_id' => $result->internal_id,
                'total_amount' => ((($job_hours['morning'] + $result->travel_time) * $day_rate) + ($job_hours['night'] * $night_rate) + ($job_hours['sunday_morning'] * $sunday_day_rate) + ($job_hours['sunday_night'] * $sunday_night_rate) + ($job_hours['saturday_morning'] * $saturday_day_rate) + ($job_hours['saturday_night'] * $saturday_night_rate) + ($job_hours['ph_morning'] * $ph_day_rate) + ($job_hours['ph_night'] * $ph_night_rate)),
                'total_calculates_hours' => (($job_hours['morning'] + $result->travel_time)  + $job_hours['night'] + $job_hours['sunday_morning'] + $job_hours['sunday_night'] + $job_hours['saturday_morning'] + $job_hours['saturday_night']  + $job_hours['ph_morning']  + $job_hours['ph_night'] ),
                'pay_rate' => $charge_rate,
                'day_rate' => $day_rate,
                'night_rate' => $night_rate,
                'hours' => $total,
                'operators_notes' => $result->operators_notes,
                'payable' => $result->payable,
                'payable_and_chargeable_time' => $result->payable_and_chargeable_time,
                'travel_time' => $result->travel_time,
                'travel_time_pay' => $day_rate * $result->travel_time,
                'saturday_day_rate' => $saturday_day_rate,
                'saturday_night_rate' => $saturday_night_rate,
                'sunday_day_rate' => $sunday_day_rate,
                'sunday_night_rate' => $sunday_night_rate,
                'sunday_day_hours' => $job_hours['sunday_morning'],
                'sunday_night_hours' => $job_hours['sunday_night'],
                'saturday_day_hours' => $job_hours['saturday_morning'],
                'saturday_night_hours' => $job_hours['saturday_night'],
                'ph_day_hours' => $job_hours['ph_morning'],
                'ph_night_hours' => $job_hours['ph_night'],
                'ph_day_rate' => $ph_day_rate,
                'ph_night_rate' => $ph_night_rate,
                'ch' => json_encode($charged_rates),
                'shift_level' => $result->shift_level,
                'training' => $result->training == 1 ? 'yes' : 'no'
            ];
            if ($item['guard_id'] == null || $item['guard_id'] == 0) {
                $item['guard_name'] = $result->moke_guard;
            }
            $user_activity = DB::table('job_roster_activities')->where('job_roster_id', $result->roster_id)->first();
            if (!empty($user_activity)) {
              $item['signin_notes'] = $user_activity->signin_notes;
              $item['signout_notes'] = $user_activity->signout_notes;
            }else{
              $item['signin_notes'] = 'N/A';
              $item['signout_notes'] = 'N/A';
            }
            $total_hours = explode('.', $item['total_hours']);
            if (sizeof($total_hours) > 1 ) {
              $partial = '.'.$total_hours[1];
              if ($partial < 0.1) {
                $item['total_hours'] = $total_hours[0];
              }
              if ($partial < 0.27 && $partial > 0.1) {
                $item['total_hours'] = $total_hours[0].'.25';
              }
              if ($partial > 0.27 && $partial <= 0.52) {
                $item['total_hours'] = $total_hours[0].'.5';
              }
              if ($partial > 0.52 && $partial <= 0.77) {
                $item['total_hours'] = $total_hours[0].'.75';
              }
              if ($partial > 0.77 && $partial < 1) {
                $item['total_hours'] = $total_hours[0]+ 1;
              }
            }
            if ($result->continuation == 0) {
            if ($item['total_hours'] < 4) {
              $item['total_hours'] = 4;
            }
            }
            $total_hours = explode('.', $item['hours']);
            if (sizeof($total_hours) > 1 ) {
              $partial = '.'.$total_hours[1];
              if ($partial < 0.1) {
                $item['hours'] = $total_hours[0];
              }
              if ($partial < 0.27 && $partial > 0.1) {
                $item['hours'] = $total_hours[0].'.25';
              }
              if ($partial > 0.27 && $partial <= 0.52) {
                $item['hours'] = $total_hours[0].'.5';
              }
              if ($partial > 0.52 && $partial <= 0.77) {
                $item['hours'] = $total_hours[0].'.75';
              }
              if ($partial > 0.77 && $partial < 1) {
                $item['hours'] = $total_hours[0]+ 1;
              }
            }
            if ($result->continuation == 0) {
            if ($item['hours'] < 4) {
              $item['hours'] = 4;
            }
            }
            if($result->job_status == 'completed'){
              $item['status'] = 'Approved';
            }else{
              $item['status'] = 'Unapproved';
            }

            
            array_push( $data, $item);

            // end of foreach
        }
        return $data;

    }

    public function invoice_report_data(Request $request)
    {
        if ($request->has('date') && $request->date != '') {
            $date = $request->date;
            $date = explode('-', $date);
            $from = strtotime(trim($date[0]));
            $to = strtotime(trim($date[1]));
        }else{
        $to = time();
        $from = time() - (60*60*24*14);
        }
        // echo date('d-m-Y', $from);
        // exit();
        if ($request->has('sites') && $request->sites != 'undefined' && !empty($request->sites)) {
            $sites=$request->sites;
        }else{
            $sites=[];
        }
        $roster_guards = DB::table('job_new_roster')
        ->join('jobs', 'jobs.id' , '=', 'job_new_roster.site_id')
        // ->rightJoin('job_breaks', 'job_breaks.roster_id' , '=', 'job_new_roster.roster_id')
        ->join('guards', 'guards.id' , '=', 'job_new_roster.guard_id')
        ->join('customers', 'customers.id' , '=', 'jobs.customer_id')
        // ->rightJoin('guard_payroll_ids', 'guard_payroll_ids.guard_id', '=', 'guards.id')
        ->where('jobs.customer_id',$request->customer_id)
        ->where(function ($query1) use ($sites){
                $i = 0;
            foreach ($sites as $key => $index) {
                if ($i == 0) {
                    $query1->where('jobs.id', $index);
                }else{
                $query1->orWhere('jobs.id', $index);
                }
            $i++;
            }
            })
            ->where('job_new_roster.temp_date', '>=', date('Y-m-d', $from))
            ->where('job_new_roster.temp_date', '<=', date('Y-m-d', $to))
            ->where('job_new_roster.job_status', 'completed')
            ->select('job_new_roster.*', 'job_new_roster.hours', 'job_new_roster.payrate_id', 'job_new_roster.site_id','job_new_roster.job_start', 'job_new_roster.job_end', 'guards.payrates_id as guard_payrate_id', 'jobs.level','jobs.site_payrate','jobs.state','jobs.site_name','jobs.site_description', 'jobs.stateType', 'jobs.payrol', 'guards.name','guards.phone', 'guards.bsb', 'guards.payroll_bank_account_number', 'guards.payroll_tfn_number','job_new_roster.guard_id','job_new_roster.temp_start','job_new_roster.temp_end','job_new_roster.roster_id', 'job_new_roster.chargerate_id as shift_chargerate_id', 'jobs.site_charge_rate as site_chargerate_id', 'customers.charged_rates_id as customer_chargerate_id')
            ->get();
            // return $roster_guards;
            // exit();
      
        $guard_paysheet = array();
        $guard_paysheet_new = array();
            foreach ($roster_guards as $key => $roster) {
                $breaks=DB::table('job_breaks')->where('roster_id',$roster->roster_id)->get();
                if(!empty($break)){
                    $break_hours=0;
                foreach($breaks as $break){
                $break_hours += (($break->break_end_time -  $break->break_start_time)/ 60);
                }
                $roster->break = $break_hours;
                }else{
                    $roster->break=0;
                }
                // $job_hours = $this->getShiftHours(date('m/d/Y H:i', $roster->job_start), date('m/d/Y H:i', $roster->job_end));
                $job_hours = $this->getShiftHours($roster->temp_start,$roster->temp_end);
                $job_hours['morning'] = $this->convertIntoWhole($job_hours['morning']);
                $job_hours['night'] = $this->convertIntoWhole($job_hours['night']);
                $job_hours['saturday_morning'] = $this->convertIntoWhole($job_hours['saturday_morning']);
                $job_hours['saturday_night'] = $this->convertIntoWhole($job_hours['saturday_night']);
                $job_hours['sunday_morning'] = $this->convertIntoWhole($job_hours['sunday_morning']);
                $job_hours['sunday_night'] = $this->convertIntoWhole($job_hours['sunday_night']);
                $rate = $charge_rate = 0;
                $day_rate = 0;
                $night_rate = 0;
                $saturday_day_rate = 0;
                $saturday_night_rate = 0;
                $sunday_day_rate = 0;
                $sunday_night_rate = 0;
                $ph_day_rate = 0;
                $ph_night_rate = 0;
                
                if ($roster->shift_chargerate_id > 0) {
                    $charged_rates = DB::table('charged_rates')->where('id', $roster->shift_chargerate_id)->first();
                }elseif($roster->site_chargerate_id > 0){
                    $charged_rates = DB::table('charged_rates')->where('id', $roster->site_chargerate_id)->first();
                }elseif($roster->customer_chargerate_id > 0){
                    $charged_rates = DB::table('charged_rates')->where('id', $roster->customer_chargerate_id)->first();
                }else{
                    // $pay_rate = DB::table('charged_rates')->where('id', $roster->site_payrate)->first();
                    $charged_rates = array();
                }
                // return $charged_rates;
                // exit();
                // if (!empty($pay_rate)) {
                //     if ($roster->payrol == 'Default Rates') {
                //         if ($roster->stateType == 'metropolitan') {
                //             $rate = $pay_rate->flat_metro_flat_metro_week_day;
                //         }else{
                //             $rate = $pay_rate->flat_regional_week_day;
                //         }
                //     }else{
                //         if ($roster->stateType == 'metropolitan') {
                //             $rate = $pay_rate->eba_metro_weekday_day;
                //         }else{
                //             $rate = $pay_rate->eba_regional_weekday_day;
                //         }
                //     }
                // }
                $day = Carbon::parse($roster->temp_start)->format('l');
            if (!empty($charged_rates)) {
            if ($roster->payrol == 'Default Rates') {
                    if ($roster->stateType == 'metropolitan') {
                        $charge_rate = $charged_rates->flat_metro_week_day_day;
                        $day_rate = $charged_rates->flat_metro_week_day_day;
                        $night_rate = $charged_rates->flat_metro_week_day_night;

                        $sunday_day_rate = $charged_rates->flat_metro_sunday;
                        $sunday_night_rate = $charged_rates->flat_metro_sunday_night;
                        $saturday_day_rate = $charged_rates->flat_metro_saturday;
                        $saturday_night_rate = $charged_rates->flat_metro_saturday_night;
                        $ph_day_rate =  $charged_rates->flat_metro_public_holiday;
                        $ph_night_rate = $charged_rates->flat_metro_public_holiday_night;

                    }else{
                        $charge_rate = $charged_rates->flat_regional_week_day_day;
                        $day_rate = $charged_rates->flat_regional_week_day_day;
                        $night_rate = $charged_rates->flat_regional_week_day_night;

                        $sunday_day_rate = $charged_rates->flat_regional_sunday;
                        $sunday_night_rate = $charged_rates->flat_regional_sunday_night;
                        $saturday_day_rate = $charged_rates->flat_regional_saturday;
                        $saturday_night_rate = $charged_rates->flat_regional_saturday_night;
                        $ph_day_rate =  $charged_rates->flat_regional_public_holiday;
                        $ph_night_rate = $charged_rates->flat_regional_public_holiday_night;
                    }

                    // if($day == 'Sunday' || $day == 'sunday'){
                    //      if ($roster->stateType == 'metropolitan') {
                    //     $charge_rate = $charged_rates->flat_metro_sunday;
                    //     $day_rate = $charged_rates->flat_metro_sunday;
                    //     $night_rate = $charged_rates->flat_metro_sunday_night;
                    //     }else{
                    //     $charge_rate = $charged_rates->flat_regional_sunday;
                    //     $day_rate = $charged_rates->flat_regional_sunday;
                    //     $night_rate = $charged_rates->flat_regional_sunday_night;
                    //     }
                    // }elseif($day == 'Saturday' || $day == 'saturday'){
                    //     if ($roster->stateType == 'metropolitan') {
                    //     $charge_rate = $charged_rates->flat_metro_saturday;
                    //     $day_rate = $charged_rates->flat_metro_saturday;
                    //     $night_rate = $charged_rates->flat_metro_saturday_night;
                    //     }else{
                    //     $charge_rate = $charged_rates->flat_regional_saturday;
                    //     $day_rate = $charged_rates->flat_regional_saturday;
                    //     $night_rate = $charged_rates->flat_regional_saturday_night;
                    //     }
                    // }
                }else{
                    // start eba rates
                    if ($roster->stateType == 'metropolitan') {
                        $charge_rate = $charged_rates->eba_metro_weekday_day;
                        $day_rate = $charged_rates->eba_metro_weekday_day;
                        $night_rate = $charged_rates->eba_metro_weekday_night;

                        $sunday_day_rate = $charged_rates->eba_metro_sunday_day;
                        $sunday_night_rate = $charged_rates->eba_metro_sunday_night;
                        $saturday_day_rate = $charged_rates->eba_metro_saturday_day;
                        $saturday_night_rate = $charged_rates->eba_metro_saturday_night;
                        $ph_day_rate =  $charged_rates->eba_metro_public_holiday;
                        $ph_night_rate = $charged_rates->eba_metro_public_holiday_night;

                    }else{
                        $charge_rate = $charged_rates->eba_regional_weekday_day;
                        $day_rate = $charged_rates->eba_regional_weekday_day;
                        $night_rate = $charged_rates->eba_regional_weekday_night;

                        $sunday_day_rate = $charged_rates->eba_regional_sunday_day;
                        $sunday_night_rate = $charged_rates->eba_regional_sunday_night;
                        $saturday_day_rate = $charged_rates->eba_regional_saturday_day;
                        $saturday_night_rate = $charged_rates->eba_regional_saturday_night;
                        $ph_day_rate =  $charged_rates->eba_regional_public_holiday;
                        $ph_night_rate = $charged_rates->eba_regional_public_holiday_night;
                    }
                    // if($day == 'Sunday' || $day == 'sunday'){
                    //      if ($roster->stateType == 'metropolitan') {
                    //     $charge_rate = $charged_rates->eba_metro_weekend_sun;
                    //     $day_rate = $charged_rates->eba_metro_weekend_sun;
                    //     $night_rate = $charged_rates->eba_metro_weekend_sun;
                    //     }else{
                    //     $charge_rate = $charged_rates->eba_regional_weekend_sun;
                    //     $day_rate = $charged_rates->eba_regional_weekend_sun;
                    //     $night_rate = $charged_rates->eba_regional_weekend_sun;
                    //     }
                    // }elseif($day == 'Saturday' || $day == 'saturday'){
                    //     if ($roster->stateType == 'metropolitan') {
                    //     $charge_rate = $charged_rates->eba_metro_weekend;
                    //     $day_rate = $charged_rates->eba_metro_weekend;
                    //     $night_rate = $charged_rates->eba_metro_weekend;
                    //     }else{
                    //     $charge_rate = $charged_rates->eba_regional_weekend;
                    //     $day_rate = $charged_rates->eba_regional_weekend;
                    //     $night_rate = $charged_rates->eba_regional_weekend;
                    //     }
                    // }
                }
            }
              
                    $guard_paysheet = array(
                        'roster_id' => $roster->roster_id,
                        'event_id' => $roster->event_id,
                        'guard_id' => $roster->guard_id, 
                        'site_id' => $roster->site_id,

                        'site_name' => $roster->site_name.'('.$roster->site_description.')', 
                        'name' => $roster->name,
                        'phone' => $roster->phone, 
                        'tfn' => $roster->payroll_tfn_number, 
                        // 'pay' => $roster->hours * $rate,
                        'pay' => $job_hours['morning'] * $day_rate + $job_hours['night'] * $night_rate + $job_hours['saturday_morning'] * $saturday_day_rate + $job_hours['saturday_night'] * $saturday_night_rate + $job_hours['sunday_morning'] * $sunday_day_rate + $job_hours['sunday_night'] * $sunday_night_rate,
                        'sunday' => $job_hours['sunday_morning'] + $job_hours['sunday_night'],
                        // 'pay' => $roster->hours * $rate,
                        'bsb' => $roster->bsb,
                        'bank' => $roster->payroll_bank_account_number,
                        'day' => $job_hours['morning'],
                        'night' => $job_hours['night'],
                        'total_hours' => $roster->hours,
                        'rate' => $charge_rate,
                        'saturday' => $job_hours['saturday_morning'] + $job_hours['saturday_night'],
                        'sunday' => $job_hours['sunday_morning'] + $job_hours['sunday_night'],
                        'date'=>$roster->temp_start,
                        'start'=>$roster->temp_start,
                        'end'=>$roster->temp_end,
                        'break'=>$roster->break,
                        'job_hours' => $job_hours,
                        // 'charged_rates ' => $charged_rates,
                        'day_rate' => $day_rate,
                        'night_rate' => $night_rate,
                        'saturday_day_rate' => $saturday_day_rate,
                        'saturday_night_rate' =>$saturday_night_rate,
                        'total_sunday_rate' => $sunday_day_rate,
                        'sunday_night_rate' => $sunday_night_rate,
                        'ph_day_rate' => $ph_day_rate,
                        'ph_night_rate' => $ph_night_rate,  
                    );
                    // $day = Carbon::parse($roster->temp_start)->format('l');
                    // if($day == 'Sunday' || $day == 'sunday'){
                    //     $guard_paysheet['saturday'] =  $job_hours['morning'];
                    //     $guard_paysheet['day']=0;
                    //     $guard_paysheet['night']=0;
                    // }elseif($day == 'Saturday' || $day == 'saturday'){
                    //     $guard_paysheet['saturday'] =  $job_hours['morning'];
                    //     $guard_paysheet['day']=0;
                    //     $guard_paysheet['night']=0;
                    // }
                  array_push($guard_paysheet_new,$guard_paysheet);
        }
            return $guard_paysheet_new;
    }

    public function invoice_report(Request $request)
    {
        if(session()->get('userType') == 'contractor'){
            $contractor_id = session()->get('userId');
            $guards = Guard::where('contractor_id', $contractor_id)->get();
            $guardsIds = Guard::where('contractor_id', $contractor_id)->pluck('id');
            $rosters = DB::table('job_new_roster')->whereIn('guard_id', $guardsIds)->groupBy('site_id')->pluck('site_id');
            $jobs = DB::table('jobs')->whereIn('id', $rosters)->groupBy('customer_id')->pluck('customer_id');
            $customers = DB::table('customers')->whereIn('id', $jobs)->where('status', 'active')->get();
        }else{
            $customers=DB::table('customers')->where('status','!=','deleted')->orderBy('name','ASC')->get();
        }
        $type = $request->has('type') ? $request->type : 'Invoice';
        return view('admin/report/invoice_report',['customers'=>$customers, 'report_type' => $type]);
    }

    public function customer_sites(Request $request)
    {
        if ($request->has('date') && $request->date != '' ) {
            $date = $request->date;
            $date = explode('-', $date);
            $from1 = strtotime(trim($date[0]));
            $to1 = strtotime(trim($date[1]));
        }
        // echo $from1;
        // exit();
        if($request->customer_id !=null && $request->has('customer_id')){
         $que =  DB::table('jobs')
         ->join('job_new_roster', 'jobs.id', '=', 'job_new_roster.site_id');
         if (is_array($request->customer_id)) {
            $customers = $request->customer_id;
         $que->where(function($q) use ($customers){
            foreach ($customers as $key => $c) {
                $q->orWhere('jobs.customer_id', $c);
            }
         });
             
         }else{
         $que->where('jobs.customer_id', $request->customer_id);
         }
         $que->where('jobs.status', 'active');
        if ($request->has('date') && $request->date != '' ) {
         $que->whereBetween('job_new_roster.temp_start',[date('Y-m-d', $from1), date('Y-m-d', $to1)]);
        }
         $site = $que->select('jobs.id AS job_id','jobs.site_name','jobs.site_description')
         ->groupBy('job_id')
         ->get();
            return $site;
        }
}

public function site_guards(Request $request)
    {
        
        if($request->sites !=null && $request->has('sites')){
         $que =  DB::table('guards')
         ->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id');
         if (is_array($request->sites)) {
            $sites = $request->sites;
         $que->where(function($q) use ($sites){
            foreach ($sites as $key => $s) {
                $q->orWhere('jobs_guards.job_id', $s);
            }
         });
             
         }else{
         // $que->where('jobs.customer_id', $request->customer_id);
         }
         $que->where('guards.status', 'active');
        
         $sites = $que->select('guards.id','guards.name')
         ->get();
            return $sites;
        }else{
            return [];
        }
}
    function generate_invoice_report(Request $request)
    {
        if ($request->type == 'excel') {
        if ($request->report_type == 'hour') {
            return Excel::download(new InvoiceReport, 'hour_report.xlsx'); 
        }else{
        return Excel::download(new InvoiceReport, 'invoice_report.xlsx'); 
        }
        }else{
            $pdf_data = $this->invoice_report_data_new($request);
            $pdf_data = PDF::loadView('exports.invoice_report', ['data' => $pdf_data]);
            $pdf_data->setPaper('legal', 'landscape');
            return  $pdf_data->stream(date('d/m/Y').'_invoice_report.pdf');
        // return Excel::download(new InvoiceReport, 'complete_report.xlsx'); 

        }
    }
    public function generate_invoice_report_old(Request $request)
    {
        $from1='';
        $to1='';
        if ($request->has('search') && $request->search != '' ) {
            $date = $request->search;
            $date = explode('-', $date);
            $from1 = strtotime(trim($date[0]));
            $to1 = strtotime(trim($date[1]));
        }else{
        $to1 = time();
        $from1 = time() - (60*60*24*14);
        }
                        $total_day=0;
                        $total_saturday=0;
                        $total_sunday=0;
                        $total_night=0;
                        $total_day_rate=0;
                        $total_saturday_rate=0;
                        $total_sunday_rate=0;
                        $total_night_rate=0;
                        $total_rate=0;
                        $gst=0;
                        $total_gross=0;
                        $net=0;

        $report = $this->invoice_report_data($request);
        // return $report;
        // exit();
        $pdf_data = '<!DOCTYPE html>
        <html><head>
        <style>
        .bod{
          font-size: 14px;
          line-height: 1.42857143;
          color: #333;
          background-color: #fbfbfb;
        }
        .container-fluid{
          padding-right: 15px;
          padding-left: 15px;
          margin-right: auto;
          margin-left: auto;
        }
        .title{
          font-size: 25px;
          color:#000;
        }
        td{
          padding: 5px 0px;
        text-align: center !important;

        }
        .head1{
            background-color:#FFFF00
        }
        
        .head2{
            background-color:
        }
        
        .head3{
            background-color:#8FA9DB
        }
        
        .head4{
            background-color:#A9D08F
        }
        .head5{
            background-color:#A6A6A6
        }
        .head6{
            background-color:#D9D9D9
        }
        .footer1 > .bod-1{
            background-color:#FFEB9C;
        }
        .footer2 > .bod-1{
            background-color:#A5A5A5;
        }
        .footer3 > .bod-1{
            background-color:#C6EFCE;
        }
        .footer4 > .bod-1{
            background-color:#8EA9DB;
        }
        .footer5 > .bod-1{
            background-color:#F4B084;
        }
        .footer6 > .bod-1{
            background-color:#70AD47;
        }
        
        strong{
        font-size: 16px;

        }
        th{
          text-align:left;
        }
      
        .bod-1{
          border:1px solid #000;
          text-align:left;
    
        }
        </style></head>';
        // return $site;
        // exit();
        if($request->type_of_export == "excel"){
                // $pdf_data.= $this->excel_preview_invoice($report);
        }else{
        $pdf_data.='<body class="bod">
        <div class="container-fluid">
        <div class="row">
        <table style="width:100%;">
        <tr>
        <td>
        <div>
        <div style="text-align: center;"><img class="navbar-brand-logo" src="'.config('custom.logo').'" title="'.config('custom.title').'" height="50"></div>
        <div style="text-align: center;" class="title">'.strtoupper(config('custom.title')).' Invoice Report</div>
        </div>
        </td>
        </tr>
        </table>
        <table style="width:100%;">
        <tr style="width:100%;" >
        <th >
        <div>
        <strong>Date :</strong>'.date('d-m-Y', $from1).' to '.date('d-m-Y',$to1).'
        </div>
        </th>
        </tr>
        <tr>
        <th style="width:100%;">
        <div style="text-align: center;margin-top:-23px">
        <strong ></strong>
        </div>
        </th>
        </tr>
        
        </table></div>';
        }
                    $pdf_data.='<table  style="width:100%;"><tr class="head1">
                    <td  class="bod-1">
                    <div>
                    <strong>Site </strong>
                    </div>
                    </td>
                    <td  class="bod-1">
                    <div>
                    <strong>Guard </strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Date</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Start Time</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Finish Time</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Breaks</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Total Hours</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Day</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Night</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Sat</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>Sun</strong>
                    </div>
                    </td>
                    </tr>';
                    // return $report;
                    // exit();
                    if(!empty($report))
                    {
                        
                       

                    foreach($report as $r){

                    $pdf_data.=' <tr class="">
                    <td  class="bod-1">
                    <div>
                    <strong>'.$r['site_name'].'</strong>
                    </div>
                    </td>
                    <td  class="bod-1">
                    <div>
                    <strong>'.$r['name'].'</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>'.date("d-m-y",strtotime($r['date'])).'</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>'.date("H:i",strtotime($r['date'])).'</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>'.date("H:i",strtotime($r['end'])).'</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>'.$r['break'].'</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>'.number_format($r['total_hours'], 2).'</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>'.$r['day'].'</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>'.$r['night'].'</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>'.$r['saturday'].'</strong>
                    </div>
                    </td>
                    <td  class="bod-1" >
                    <div>
                    <strong>'.$r['sunday'].'</strong>
                    </div>
                    </td>
                    </tr>';
                    $total_day+=$r['day'];
                    $total_night+=$r['night'];
                    $total_saturday+=$r['saturday'];
                    $total_sunday+=$r['sunday'];
                    $total_rate+=$r['rate'];
                }
                $total_day_rate=$total_day * $total_rate;
                $total_night_rate=$total_night * $total_rate;
                $total_saturday_rate=$total_saturday * $total_rate;
                $total_sunday_rate=$total_sunday * $total_rate;
                $total_gross=$total_day_rate + $total_night_rate + $total_saturday_rate + $total_sunday_rate;
                $gst=$total_gross/10;
                $net=$total_gross + $gst;
                }else{
                
                }
            $pdf_data.='<tr class="">
            <td  >
            <div>
            </div>
            </td>
            <td  >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            </tr>';

            
            $pdf_data.='<tr class="">
            <td  >
            <div>
            </div>
            </td>
            <td  >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            </tr>';

            $pdf_data.='<tr class="footer1">
            <td  >
            <div>
            </div>
            </td>
            <td  >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>Hours</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>'.number_format($total_day, 2).'</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>'.number_format($total_night, 2).'</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>'.number_format($total_saturday, 2).'</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>'.number_format($total_sunday, 2).'</strong>
            </div>
            </td>
            </tr>';

            $pdf_data.='<tr class="footer2">
            <td  >
            <div>
            </div>
            </td>
            <td  >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>Rate</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>$'.number_format($total_rate, 2).'</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>$'.number_format($total_rate, 2).'</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>$'.number_format($total_rate, 2).'</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>$'.number_format($total_rate, 2).'</strong>
            </div>
            </td>
            </tr>';


            
            $pdf_data.='<tr class="footer3">
            <td  >
            <div>
            </div>
            </td>
            <td  >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>Total</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>$'.number_format($total_day_rate, 2).'</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>$'.number_format($total_night_rate, 2).'</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>$'.number_format($total_saturday_rate, 2).'</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>$'.number_format($total_sunday_rate, 2).'</strong>
            </div>
            </td>
            </tr>';


            
            
            $pdf_data.='<tr class="footer4">
            <td  >
            <div>
            </div>
            </td>
            <td  >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>Gross Total</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>$'.number_format($total_gross, 2).'</strong>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            </tr>';
            
            $pdf_data.='<tr class="footer5">
            <td  >
            <div>
            </div>
            </td>
            <td  >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>GST</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>$'.number_format($gst, 2).'</strong>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            </tr>';

            $pdf_data.='<tr class="footer6">
            <td  >
            <div>
            </div>
            </td>
            <td  >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>Net Total</strong>
            </div>
            </td>
            <td  class="bod-1" >
            <div>
            <strong>$'.number_format($net, 2).'</strong>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            <td   >
            <div>
            </div>
            </td>
            </tr>';
          $pdf_data .='</div>
        </td></tr></table></div>';
        $pdf_data .='</div></body></html>';

            // return $pdf_data;
            // exit();
            if($request->type_of_export =="excel"){
                return View('admin/report/excel',compact('pdf_data'));
            }else{
                $pdf_data = PDF::loadView('reports/rosterReport', ['data' => $pdf_data]);
                $pdf_data->setPaper('legal', 'landscape');

              return  $pdf_data->stream(date('d/m/Y').'_invoice_report.pdf');
            }
    }

    function division_consolidation()
    {
        $customers = DB::table('customers')->where('status', 'active')->get();
        $data = DB::table('division_consolidation')->get();
        return view('/admin/report/division_consolidation', ['customers' => $customers, 'data' => $data]);
    }

    function add_division_consolidation(Request $request)
    {
        $data['name'] = $request->name;
        $division_id = DB::table('division_consolidation')->insertGetId($data);
        $data1['rate'] = $request->rate;
        // $data['rate'] = $request->rate;
        $data1['customers'] = array();
        $data1['sites'] = array();
        if (!empty($request->customer_name)) {
            $data1['customers'] = $request->customer_name;
        }
        $data1['customers'] = json_encode($data1['customers']);
        if (!empty($request->sites)) {
            $data1['sites'] = $request->sites;
        }
        $data1['sites'] = json_encode($data1['sites']);
        $data1['division_id'] = $division_id;
        DB::table('division_consolidation_rates')->insertGetId($data1);
        return redirect('/division_consolidation');
    }

    function add_division_consolidation_rates(Request $request)
    {
        $data1['rate'] = $request->rate;
        // $data['rate'] = $request->rate;
        $data1['customers'] = array();
        $data1['sites'] = array();
        if (!empty($request->customer_name)) {
            $data1['customers'] = $request->customer_name;
        }
        $data1['customers'] = json_encode($data1['customers']);
        if (!empty($request->sites)) {
            $data1['sites'] = $request->sites;
        }
        $data1['sites'] = json_encode($data1['sites']);
        $data1['division_id'] = $request->division_id;
        DB::table('division_consolidation_rates')->insertGetId($data1);
        return redirect('/division_consolidation');
    }
    function export_division_consolidation_report(Request $request)
    {
        // $html = new DivisionConsolidation;
        // echo $html;
        // exit();
        return Excel::download(new DivisionConsolidation, 'DivisionConsolidation.xlsx');  
    }
    function getDivisionConsolidationData($request)
    {
        // return $request;
        $ids = explode(',', $request['id']);
        $data = array();
        foreach ($ids as $key => $id) {
        $division = DB::table('division_consolidation')->where('id', $id)->first();

        $date = $request['date'];
        $date = explode('-', $date);
        $from = strtotime(trim($date[0]));
        $to = strtotime(trim($date[1])) + 60*60*24;
        $to = $to;
        $customers = json_decode($division->customers, true);
        $query = DB::table('job_new_roster')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->join('customers', 'customers.id', '=', 'jobs.customer_id')
        ->leftJoin('charged_rates', 'jobs.site_charge_rate' , '=', 'charged_rates.id');
        $query->where(function($que) use ($customers){
            foreach ($customers as $key => $c) {
                if ($key == 0) {
                    $que->where('jobs.customer_id', $c);
                }else{
                    $que->orWhere('jobs.customer_id', $c);
                }
            }
        });
        $sites = json_decode($division->sites, true);
        if (!empty($sites)) {
            $query->where(function($que) use ($sites){
            foreach ($sites as $key => $c) {
                if ($key == 0) {
                    $que->where('jobs.id', $c);
                }else{
                    $que->orWhere('jobs.id', $c);
                }
            }
        });
        }

        $query->whereBetween('temp_start', [date('Y-m-d', $from), date('Y-m-d', $to)]);
        $query->select(DB::raw('SUM(job_new_roster.hours) AS total_hours'), 'jobs.site_name', 'customers.name', 'charged_rates.normal_rate', 'charged_rates.eba_rate', 'jobs.stateType', 'jobs.payrol', 'jobs.site_charge_rate', 'customers.charged_rates_id');
        $query->groupBy('job_new_roster.site_id');
        $query->orderBy('customers.name', 'ASC');
        $query->orderBy('jobs.site_name', 'ASC');
        $all_data = $query->get();
        foreach ($all_data as $key => $al) {
            if ($al->site_charge_rate > 0) {
                $charged_rate = DB::table('charged_rates')->where('id', $al->site_charge_rate)->first();
            }elseif($al->charged_rates_id > 0){
                $charged_rate = DB::table('charged_rates')->where('id', $al->charged_rates_id)->first();
            }else{
                $charged_rate = array();
            }
            if (!empty($charged_rate)) {
                $al->normal_rate = json_decode($charged_rate->normal_rate, true);
                $al->eba_rate = json_decode($charged_rate->eba_rate, true);
            }else{
                $al->normal_rate = array();
                $al->eba_rate = array();
            }
        }
        $data[] = array(
            'data' => $all_data,
            'division' => $division);
        }
        return ['data' => $data];
        // return $division;

    }
    public function deleteDivision($id){
   $query = DB::table('division_consolidation')->where('id', $id)->delete();
   if($query){
    return response()->json(['success' => true,'msg'=>"deleted Successfully"]);

}
}

function division_consolidation_report()
    {
        $customers = DB::table('customers')->where('status', 'active')->get();
        $list = DB::table('division_consolidation')->get();
        return view('/admin/report/division_consolidation_report', ['customers' => $customers, 'list' => $list]);
    }

    function getCustomerPieChart(Request $request)
    {

        $query = DB::table('job_new_roster')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->join('customers', 'customers.id', '=', 'jobs.customer_id');
        if ($request->has('date') && $request->date != '') {
            $date = explode('-', $request->date);
            if (strtotime($date[0]) == strtotime($date[1])) {
                $query->whereMonth('job_new_roster.temp_start', date('m'))
                ->whereYear('job_new_roster.temp_start', date('Y'));
            }else{
                $query->where('job_new_roster.temp_start', '>=', date('Y-m-d 00:00:00', strtotime($date[0])));
                $query->where('job_new_roster.temp_start', '<=', date('Y-m-d 00:00:00', strtotime($date[1])));
            }
        }else{
        $query->whereMonth('job_new_roster.temp_start', date('m'))
        ->whereYear('job_new_roster.temp_start', date('Y'));
        }
        if ($request->has('customer_id') && !empty($request->customer_id)) {
            $customer_id = $request->customer_id;
            $query->where(function($que) use ($customer_id){
            foreach ($customer_id as $key => $cId) {
                if ($key == 0) {
                    $que->where('jobs.customer_id', $cId);
                }else{
                    $que->orWhere('jobs.customer_id', $cId);
                }
            }
            });
        }

        if ($request->has('sites') && !empty($request->sites)) {
            $sites = $request->sites;
            $query->where(function($que) use ($sites){
            foreach ($sites as $key => $id) {
                if ($key == 0) {
                    $que->where('jobs.id', $id);
                }else{
                    $que->orWhere('jobs.id', $id);
                }
            }
            });
        }
        $report_data = $query->select('customers.name as country', DB::raw('COUNT(job_new_roster.roster_id) as value'))
        ->groupBy('jobs.customer_id')
        ->get();
        return response()->json($report_data);
    }
    function monthDiff($date1, $date2)
    {
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);
        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);
        return ((($year2 - $year1) * 12) + ($month2 - $month1));
    }

    function getCutsomerProfitLoss(Request $request)
    {
        $months = array();
        $pay = array();
        $charge = array();
        $profit = array();
        $expense = array();
        $div = DB::table('division_consolidation')
        ->join('division_consolidation_rates', 'division_consolidation_rates.division_id', '=', 'division_consolidation.id')
        ->select('division_consolidation.id', 'division_consolidation.name', 'division_consolidation_rates.customers', 'division_consolidation_rates.sites', 'division_consolidation_rates.rate')->get();
        $date = explode('-', $request->date);

        if ($request->has('date') && $request->date != '' && strtotime($date[0]) != strtotime($date[1])) {
        // $noOfMonths = $this->monthDiff($date[0], $date[1]);
        // for ($i = $noOfMonths; $i >= 0; $i--) 
        // { 
            // $month = strtotime('- '.$i.' month');
            $query = DB::table('job_new_roster')
            ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
            ->join('customers', 'customers.id', '=', 'jobs.customer_id');
            if ($request->has('date') && $request->date != '') {
            // $date = explode('-', $request->date);
            if (strtotime($date[0]) == strtotime($date[1])) {
                $query->whereMonth('job_new_roster.temp_start', date('m'))
                ->whereYear('job_new_roster.temp_start', date('Y'));
            }else{
                $query->where('job_new_roster.temp_start', '>=', date('Y-m-d 00:00:00', strtotime($date[0])));
                $query->where('job_new_roster.temp_start', '<=', date('Y-m-d 00:00:00', strtotime($date[1])));
            }
        }
            // $query->whereMonth('job_new_roster.temp_start', date('m', $month))
            // ->whereYear('job_new_roster.temp_start', date('Y', $month));
            if ($request->has('customer_id') && !empty($request->customer_id)) {
                $customer_id = $request->customer_id;
                $query->where(function($que) use ($customer_id){
                foreach ($customer_id as $key => $cId) {
                    if ($key == 0) {
                        $que->where('jobs.customer_id', $cId);
                    }else{
                        $que->orWhere('jobs.customer_id', $cId);
                    }
                }
                });
            }
            if ($request->has('sites') && !empty($request->sites)) {
            $sites = $request->sites;
            $query->where(function($que) use ($sites){
            foreach ($sites as $key => $id) {
                if ($key == 0) {
                    $que->where('jobs.id', $id);
                }else{
                    $que->orWhere('jobs.id', $id);
                }
            }
            });
        }
            // ->groupBy('jobs.customer_id')
            $dat = $query->select(DB::raw('SUM(job_new_roster.pay) as pay'),
             DB::raw('SUM(job_new_roster.charge) as charge')
            )->first();

            $months[] = date('M', strtotime($date[0]));
            $pay[] = $dat->pay > 0 ? round($dat->pay, 2) : 0;
            $charge[] = $dat->charge > 0 ? round($dat->charge, 2) : 0;
            // $expense[] = $dat->total_hours > 0 ? round(($dat->total_hours ), 2) : 0;
            $exp = 0;
            foreach ($div as $key => $d) {
            $customers = json_decode($d->customers);
            // $month = strtotime('- '.$i.' month');
            $query = DB::table('job_new_roster')
            ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
            ->join('customers', 'customers.id', '=', 'jobs.customer_id');
            // ->whereMonth('job_new_roster.temp_start', date('m', $month))
            // ->whereYear('job_new_roster.temp_start', date('Y', $month))
            if ($request->has('date') && $request->date != '') {
            $date = explode('-', $request->date);
            if (strtotime($date[0]) == strtotime($date[1])) {
                $query->whereMonth('job_new_roster.temp_start', date('m'))
                ->whereYear('job_new_roster.temp_start', date('Y'));
            }else{
                $query->where('job_new_roster.temp_start', '>=', date('Y-m-d 00:00:00', strtotime($date[0])));
                $query->where('job_new_roster.temp_start', '<=', date('Y-m-d 00:00:00', strtotime($date[1])));
            }
        }
        if ($request->has('sites') && !empty($request->sites)) {
            $sites = $request->sites;
            $query->where(function($que) use ($sites){
            foreach ($sites as $key => $id) {
                if ($key == 0) {
                    $que->where('jobs.id', $id);
                }else{
                    $que->orWhere('jobs.id', $id);
                }
            }
            });
        }
            $query->where(function ($que)  use ($customers){
                foreach ($customers as $key => $c) {
                    if ($key == 0) {
                        $que->where('jobs.customer_id', $c);
                    }else{
                        $que->orWhere('jobs.customer_id', $c);
                    }
                }
            })
            ->select(
             DB::raw('SUM(job_new_roster.hours) as total_hours')
            );
            // ->groupBy('jobs.customer_id')
            $res = $query->first();
            $exp = $exp +  ($res->total_hours > 0 ? $res->total_hours : 0);
            
            }
            $expense[] = $exp * $d->rate;
            $profit[] = $dat->charge > 0 ? round(($dat->charge - $dat->pay - ($exp * $d->rate)), 2) : 0;

        // }

    }else{
        for ($i = 12; $i >= 0; $i--) 
        { 
            $month = strtotime('- '.$i.' month');
            $dat = DB::table('job_new_roster')
            ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
            ->join('customers', 'customers.id', '=', 'jobs.customer_id')
            ->whereMonth('job_new_roster.temp_start', date('m', $month))
            ->whereYear('job_new_roster.temp_start', date('Y', $month))
            ->select(DB::raw('SUM(job_new_roster.pay) as pay'),
             DB::raw('SUM(job_new_roster.charge) as charge')
         )
            // ->groupBy('jobs.customer_id')
            ->first();
            $months[] = date('M', strtotime('- '.$i.' month'));
            $pay[] = $dat->pay > 0 ? round($dat->pay, 2) : 0;
            $charge[] = $dat->charge > 0 ? round($dat->charge, 2) : 0;
            // $expense[] = $dat->total_hours > 0 ? round(($dat->total_hours ), 2) : 0;
            $exp = 0;
            foreach ($div as $key => $d) {
            $customers = json_decode($d->customers);
            $month = strtotime('- '.$i.' month');
            $query = DB::table('job_new_roster')
            ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
            ->join('customers', 'customers.id', '=', 'jobs.customer_id')
            ->whereMonth('job_new_roster.temp_start', date('m', $month))
            ->whereYear('job_new_roster.temp_start', date('Y', $month))
            ->where(function ($que)  use ($customers){
                foreach ($customers as $key => $c) {
                    if ($key == 0) {
                        $que->where('jobs.customer_id', $c);
                    }else{
                        $que->orWhere('jobs.customer_id', $c);
                    }
                }
            })
            ->select(
             DB::raw('SUM(job_new_roster.hours) as total_hours')
            );
            // ->groupBy('jobs.customer_id')
            $res = $query->first();
            $exp = $exp +  ($res->total_hours > 0 ? $res->total_hours : 0);
            
            }
            $expense[] = $exp * $d->rate;
            $profit[] = $dat->charge > 0 ? round(($dat->charge - $dat->pay - ($exp * $d->rate)), 2) : 0;

        }
    }
        return response()->json(['months' => $months, 'pay' => $pay, 'charge' => $charge, 'max' => max($charge), 'profit' => $profit, 'expense' => $expense]);
    }
    function get_division_consolidation(Request $request)
    {
        $div = DB::table('division_consolidation')
        ->join('division_consolidation_rates', 'division_consolidation_rates.division_id', '=', 'division_consolidation.id')
        ->select('division_consolidation.id', 'division_consolidation.name', 'division_consolidation_rates.customers', 'division_consolidation_rates.sites', 'division_consolidation_rates.rate')->get();
        $consolidation = array();
        foreach ($div as $key => $d) {
            $customers = json_decode($d->customers);
            $query = DB::table('job_new_roster')
            ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
            ->join('customers', 'customers.id', '=', 'jobs.customer_id');
if ($request->has('date') && $request->date != '') {
            $date = explode('-', $request->date);
            if (strtotime($date[0]) == strtotime($date[1])) {
                $query->whereMonth('job_new_roster.temp_start', date('m'))
                ->whereYear('job_new_roster.temp_start', date('Y'));
            }else{
                $query->where('job_new_roster.temp_start', '>=', date('Y-m-d 00:00:00', strtotime($date[0])));
                $query->where('job_new_roster.temp_start', '<=', date('Y-m-d 00:00:00', strtotime($date[1])));
            }
        }else{
            $query->whereMonth('job_new_roster.temp_start', date('m'))
            ->whereYear('job_new_roster.temp_start', date('Y'));
        }
            if ($request->has('customer_id') && !empty($request->customer_id)) {
            $customer_id = $request->customer_id;
           
            $query->where(function ($que)  use ($customers, $customer_id){
                foreach ($customers as $key => $c) {
                    if (in_array($c, $customer_id)) {
                    if ($key == 0) {
                        $que->where('jobs.customer_id', $c);
                    }else{
                        $que->orWhere('jobs.customer_id', $c);
                    }
                    }
                }
            });
            }else{
            $query->where(function ($que)  use ($customers){
                foreach ($customers as $key => $c) {
                    if ($key == 0) {
                        $que->where('jobs.customer_id', $c);
                    }else{
                        $que->orWhere('jobs.customer_id', $c);
                    }
                }
            });
            }
            $query->select(
             DB::raw('SUM(job_new_roster.hours) as total_hours')
            );
            // ->groupBy('jobs.customer_id')
            $res = $query->first();
            $consolidation[] = array(
                'id' => $d->id,
                'name' => $d->name,
                'rate' => $d->rate,
                'share' => ($res->total_hours > 0 ? $res->total_hours : 0) * $d->rate,
                'action' => '<a type="button" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="" onclick="editDivision('.$d->id.')"><i class="fa fa-edit"></i></a> || <a type="button" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="" onclick="deleteDivision('.$d->id.')"> <i class="fa fa-trash"></i> </a>'
            );
            // $exp = $exp +  ($res->total_hours > 0 ? $res->total_hours : 0);
            
            }
        return response()->json(['success' => true, 'data' => $consolidation, 'draw' => $request->draw, 'recordsTotal' => count($consolidation),
    'recordsFiltered' => count($consolidation)]);
    }

    function exportDivisionData($request)
    {
        $date = explode('-', $request['date']);

        $query = DB::table('job_new_roster')
            ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
            ->join('customers', 'customers.id', '=', 'jobs.customer_id');
            if (isset($request['date']) && $request['date'] != '') {
            // $date = explode('-', $request->date);
            if (strtotime($date[0]) == strtotime($date[1])) {
                $query->whereMonth('job_new_roster.temp_start', date('m'))
                ->whereYear('job_new_roster.temp_start', date('Y'));
            }else{
                $query->where('job_new_roster.temp_start', '>=', date('Y-m-d 00:00:00', strtotime($date[0])));
                $query->where('job_new_roster.temp_start', '<=', date('Y-m-d 00:00:00', strtotime($date[1])));
            }
        }
            // $query->whereMonth('job_new_roster.temp_start', date('m', $month))
            // ->whereYear('job_new_roster.temp_start', date('Y', $month));
            if (isset($request['customer_id']) && !empty($request['customer_id'])) {
                $customer_id = explode(',', $request['customer_id']);
                $query->where(function($que) use ($customer_id){
                foreach ($customer_id as $key => $cId) {
                    if ($key == 0) {
                        $que->where('jobs.customer_id', $cId);
                    }else{
                        $que->orWhere('jobs.customer_id', $cId);
                    }
                }
                });
            }
            if (isset($request['sites']) && !empty($request['sites'])) {
            $sites = explode(',', $request['sites']);
            $query->where(function($que) use ($sites){
            foreach ($sites as $key => $id) {
                if ($key == 0) {
                    $que->where('jobs.id', $id);
                }else{
                    $que->orWhere('jobs.id', $id);
                }
            }
            });
        }
            $query->groupBy('jobs.id');
            $query->orderBy('customers.name', 'ASC');
            $dat = $query->select(DB::raw('SUM(job_new_roster.hours) as total_hours')
                ,DB::raw('SUM(job_new_roster.pay) as pay'),
             DB::raw('SUM(job_new_roster.charge) as charge'), 'jobs.site_name', 'jobs.site_description', 'customers.name')->get();
            return $dat;

            // print_r('<pre>');
            // print_r($dat);
    }

    function exportDivisionDataNew($request)
    {
        $all_data = array();
        $customer_ids = isset($request['customer_id']) && $request['customer_id'] != '' ? explode(',', $request['customer_id'], true) : array();
        $sites = isset($request['sites']) && $request['sites'] != '' ? explode(',', $request['sites'], true) : array();
        $all_customer = array();
        $all_sites = array();
        $query = DB::table('division_consolidation')
        ->join('division_consolidation_rates', 'division_consolidation_rates.division_id', '=', 'division_consolidation.id')
        ->select('division_consolidation.id', 'division_consolidation.name', 'division_consolidation_rates.customers', 'division_consolidation_rates.sites', 'division_consolidation_rates.rate');
        if (isset($request['division_id']) && $request['division_id'] != '') {
        $query->where('division_consolidation.id', $request['division_id']);
        }
        if (isset($request['customer_id']) && $request['customer_id'] != '') {
        $query->where(function ($que) use ($customer_ids){
            foreach ($customer_ids as $key => $cID) {
                $que->orWhereJsonContains('division_consolidation_rates.customers', $cID);
            }
        });
        }
        if (isset($request['sites']) && $request['sites'] != '') {
        $query->where(function ($que) use ($sites){
            foreach ($sites as $key => $sID) {
                $que->orWhereJsonContains('division_consolidation_rates.sites', $sID);
            }
        });
        }
        $divisions = $query->get();
        
        foreach ($divisions as $key => $d) {
            $cust = json_decode($d->customers, true);
            $all_customer = array_unique(array_merge($all_customer,$cust), SORT_REGULAR);
            $sit = json_decode($d->sites, true);
            if (empty($sit)) {
            foreach ($cust as $key2 => $cId) {
            $jobs = DB::table('jobs')->where('customer_id', $cId)->where('status', 'active')->select('id')->get();
            foreach ($jobs as $key3 => $s) {
                $sit[] = $s->id;
            }
            }
        }
            $all_sites = array_unique(array_merge($all_sites,$sit), SORT_REGULAR);
        }
        if (!empty($customer_ids)) {
            $all_customer = array_intersect($all_customer, $customer_ids);
        }
        if (!empty($sites)) {
            $all_sites = array_intersect($all_sites, $sites);
        }
        foreach ($all_customer as $key => $cID) {
            $customer_sites = DB::table('jobs')
            ->join('customers', 'customers.id', '=', 'jobs.customer_id')
            ->where('jobs.customer_id', $cID)
            ->where('jobs.status', 'active')
            ->select('jobs.id', 'jobs.site_name', 'jobs.site_description', 'customers.name')->get();
            foreach ($customer_sites as $key2 => $sID) {
                if (empty($sites) || (in_array($sID->id, $sites) && in_array($sID->id, $all_sites))) {
                    $total_hours = 0;
                    $total_amount = 0;
                    $total_hours_pay = 0;
                    $total_amount_pay = 0;
                    $all_charge_data = $this->invoice_report_data_new(array(
                            'customer_id' => $cID,
                            'sites' => $sID->id,
                            'date' => $request['date']
                        ));
                    // $all_pay_data = $this->getCompleteReportData(array(
                    //         'customer_id' => $cID,
                    //         'sites' => $sID->id,
                    //         'search' => $request->date
                    //     ));
                    foreach ($all_charge_data as $key3 => $acd) {
                        $total_amount = $total_amount + $acd['total_amount'];
                        $total_hours = $total_hours + $acd['total_calculates_hours'];
                    }

                    
                    $all_data[$sID->id] = array(
                        'site_id' => $sID->id,
                        'c_id' => $cID,
                        'customer_name' => $sID->name,
                        'site_name' => $sID->site_name,
                        'site_description' => $sID->site_description,
                        'hours_charge' => $total_hours,
                        'total_amount_charge' => $total_amount,
                        'hours_pay' => $total_hours_pay,
                        'total_amount_pay' => $total_amount_pay,
                        'expense' => 0

                    );
                }
            }
        }
        $all_pay_data = $this->getCompleteReportData(array(
                            'customer_name' => $all_customer,
                            'sites' => isset($request['sites']) ? $request['sites'] : '',
                            'search' => $request['date']
                        ));
        foreach ($all_pay_data as $key3 => $apd) {

            if (isset($all_data[$apd['site_id']])) {
                $all_data[$apd['site_id']]['total_amount_pay'] = $all_data[$apd['site_id']]['total_amount_pay'] + $apd['total_amount'];
                $all_data[$apd['site_id']]['hours_pay'] = $all_data[$apd['site_id']]['hours_pay'] + $apd['total_calculates_hours'];
            }
                        
    }

    foreach ($divisions as $key => $d) {
        $cust = json_decode($d->customers, true);
        $sit = json_decode($d->sites, true);
        if (empty($sit)) {
            foreach ($cust as $key2 => $cId) {
            $jobs = DB::table('jobs')->where('customer_id', $cId)->where('status', 'active')->select('id')->get();
            foreach ($jobs as $key3 => $s) {
                if (isset($all_data[$s->id]['hours_pay'])) {
                if (!isset($all_data[$s->id]) && !isset($all_data[$s->id]['expense'])) {
                    $all_data[$s->id]['expense'] = $all_data[$s->id]['hours_pay'] * $d->rate;
                }else{
                    $all_data[$s->id]['expense'] = $all_data[$s->id]['expense'] + $all_data[$s->id]['hours_pay'] * $d->rate;
                }
            }
        }
        }
        }else{
            foreach ($sit as $key4 => $s) {
                if (!isset($all_data[$s]['expense'])) {
                       $all_data[$s]['expense'] = $all_data[$s]['hours_pay'] * $d->rate;
                }else{
                    $all_data[$s]['expense'] = $all_data[$s]['expense'] + $all_data[$s]['hours_pay'] * $d->rate;
                }   
            }
        }
    }
        // print_r('<pre>');
        // print_r($all_data);
    return $all_data;

    }

    function getDivisionFrom(Request $request)
    {
        $customers = DB::table('customers')->where('status', 'active')->get();
        $list = DB::table('division_consolidation')->get();
        $html = view('admin.report.getDivisionFrom', ['customers' => $customers, 'list' => $list, 'type' => $request->type] )->render();
        return response()->json($html);
    }
    public function signin_out_report()
{
    $customers = DB::table('customers')->where('status', 'active')->get();
    $states='';
    $address='';
    $guards='';
    $tasks = $this->task_report_model->get_customers();
    return view('/admin/report/signin_out_report',['tasks'=> $tasks,'customers'=> $customers,'states'=> $states,'address'=> $address,'guards'=> $guards]);
}
function export_signin_out_report(Request $request)
    {
        return Excel::download(new SignInOutExport, 'signinout_report.xlsx');  
    }
    public function getSigninOutReportData($request)
    {
        if (isset($request['search']) && $request['search'] != '') {
            $date = $request['search'];
            $date = explode('-', $date);
            $from = strtotime(trim($date[0]));
            $to = strtotime(trim($date[1])) + (60*60*24);
        }else{
            $to = time();
            $from = time() - (60*60*24*7);
        }
        $startDate = date('Y-m-d', $from);
        $endDate = date('Y-m-d', $to);
        $extra_query = '(jr.`job_status` = "completed" OR jr.`job_status` = "pending" OR jr.`job_status` = "confirmed" OR jr.`status_change_by` > 0) AND ';
        if (isset($request['sites']) && $request['sites'] != '') {
            $specific_sites_id = $request['sites'];
            if (!is_array($specific_sites_id)) {
                $specific_sites_id = explode(',', $specific_sites_id);
            }else{
                $specific_sites_id = $specific_sites_id;
            }
            $extra_query .= "(";
            $i = 0;
            foreach ($specific_sites_id as $key => $id) {
              $extra_query .= "jr.`site_id` = '".$id."'";
              if ($i < sizeof($specific_sites_id) -1) {
                $extra_query .= " OR ";
            }
            $i++;
        }
        $extra_query .= ") AND ";
    }
    if (isset($request['customer_name']) && $request['customer_name'] != '') {
        $customer_id = $request['customer_name'];
        if (!is_array($customer_id)) {
            $specific_customer = explode(',', $customer_id);
        }else{
            $specific_customer = $customer_id;
        }
        $extra_query .= "(";
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
    if (isset($request['guard_name']) && $request['guard_name'] != '') {
        $guard_name = $request['guard_name'];
        if (!is_array($guard_name)) {
            $guard_name = explode(',', $guard_name);
        }else{
            $guard_name = $guard_name;
        }
        $extra_query .= "(";
        $i = 0;
        foreach ($guard_name as $key => $id) {
          $extra_query .= "jr.`guard_id` = '".$id."'";
          if ($i < sizeof($guard_name) -1) {
            $extra_query .= " OR ";
        }
        $i++;
    }
    $extra_query .= ") AND ";
    }
    $sql = "SELECT
    jr.`roster_id`,
    jr.`temp_start`,
    jr.`temp_end`,
    j.`id`,
    j.`site_name`,
    j.`site_description`,
    cust.`name` AS customer_name,
    g.`phone`,
    g.`guard_type`,
    g.`phone` AS guard_phone,
    g.`id` AS guard_id,
    g.`email` AS guard_email,
    g.`profile_image` AS guard_image,
    g.`name` AS guard_name,
    jra.`signin_time`,
    jra.`signout_time`,
    jr.`roster_id` As roster_id
    FROM job_new_roster AS jr
    INNER JOIN jobs AS j ON j.`id` = jr.`site_id`
    LEFT JOIN `guards` AS g ON g.`id` = jr.`guard_id`
    LEFT JOIN customers AS cust ON j.`customer_id` = cust.`id`
    LEFT JOIN `contractors` AS c ON j.`contractor_id`= c.`id`
    LEFT JOIN `job_roster_activities` AS jra ON jra.`job_roster_id` =  jr.`roster_id`
    WHERE ".$extra_query." jr.`payable` = 'yes' AND jr.`temp_date` BETWEEN '".$startDate."' AND '".$endDate."' ORDER BY g.name ASC, jr.moke_guard, jr.temp_start";
      // echo $sql;
    $results = DB::select($sql);
    foreach ($results as $key => $r) {
        if ($r->signin_time != null && $r->signin_time != '') {
                if ($r->signin_time != null && $r->signin_time != '') {
                    if(strpos($r->signin_time,'GMT') !== false){
                        $r->$r->signin_time   = explode(" ",$r->signin_time);
                        $r->signin_time = $r->$r->signin_time [ 3].'-'. date('m',strtotime($r->signin_time_2[1])).'-'.$r->signin_time_2[2].' '.$r->signin_time_2[4];
                    }
                    else{
                        if(strpos($r->signin_time,'M')!==false||strpos($r->signin_time,'T')!==false||strpos($r->signin_time,'W')!==false||strpos($r->signin_time,'F')!==false ||strpos($r->signin_time,'S')!==false)
                        {
                          $r->signin_time = str_replace('T', ' ', $r->signin_time);
                          $r->signin_time = str_replace('+', ' ', $r->signin_time);
                          $r->signin_time_2= explode(" ",$r->signin_time);
                          if (count($r->signin_time_2) > 3) {
                            $r->signin_time_2=$r->signin_time_2[3].'-'. date('m',strtotime($r->signin_time_2[1])).'-'.$r->signin_time_2[2].' '.$r->signin_time_2[4];
                        }else{

                          if (count($r->signin_time_2) > 2) {
                            $r->signin_time_2 = $r->signin_time_2[0].' '.$r->signin_time_2[1];
                        }else{
                            $r->signin_time_2 = $r->signin_time_2[0].' '.$r->signin_time_2[1];
                        }
                    }
                }
                else{
                    $r->signin_time = $r->signin_time;
                }
            }
        }else{
            $r->signin_time = 'N/A';
        }
    }else{
        $r->signin_time = 'N/A';
    }
    if ($r->signout_time != null && $r->signout_time != '') {
                if ($r->signout_time != null && $r->signout_time != '') {
                    if(strpos($r->signout_time,'GMT') !== false){
                        $r->$r->signout_time   = explode(" ",$r->signout_time);
                        $r->signout_time = $r->$r->signout_time [ 3].'-'. date('m',strtotime($r->signout_time_2[1])).'-'.$r->signout_time_2[2].' '.$r->signout_time_2[4];
                    }
                    else{
                        if(strpos($r->signout_time,'M')!==false||strpos($r->signout_time,'T')!==false||strpos($r->signout_time,'W')!==false||strpos($r->signout_time,'F')!==false ||strpos($r->signout_time,'S')!==false)
                        {
                          $r->signout_time = str_replace('T', ' ', $r->signout_time);
                          $r->signout_time = str_replace('+', ' ', $r->signout_time);
                          $r->signout_time_2= explode(" ",$r->signout_time);
                          if (count($r->signout_time_2) > 3) {
                            $r->signout_time_2=$r->signout_time_2[3].'-'. date('m',strtotime($r->signout_time_2[1])).'-'.$r->signout_time_2[2].' '.$r->signout_time_2[4];
                        }else{
                          if (count($r->signout_time_2) > 2) {
                            $r->signout_time_2 = $r->signout_time_2[0].' '.$r->signout_time_2[1];
                        }else{
                            $r->signout_time_2 = $r->signout_time_2[0].' '.$r->signout_time_2[1];
                        }
                    }
                }
                else{
                    $r->signout_time = $r->signout_time;
                }
            }
        }else{
            $r->signout_time = 'N/A';
        }
    }else{
        $r->signout_time = 'N/A';
    }

    }
    return $results;
    }
    public function combine_report(Request $request)
    {
        if ($request->has('search')) {
        $date = $request->search;
        $date = explode('-', $date);
        $from = strtotime(trim($date[0]));
        $to = strtotime(trim($date[1]));
        $to = $to;
        }else{
        $to = time();
        $from = time() - (60*60*24*7);
        }
       
        $data = array();
        // exit();
        return view('/admin/report/combine_report',['search' => $request->search]);
    }

    function generateMultiReport()
    {
        ini_set('max_execution_time', 0);
        // set_time_limit(1800);
        return Excel::download(new MultisheetExport(), 'AllReport.xlsx');
        // return (new MultisheetExport(2023))->download('invoices.xlsx');
    }
    public function award_report(Request $request)
    {
        if ($request->has('search')) {
        $date = $request->search;
        $date = explode('-', $date);
        $from = strtotime(trim($date[0]));
        $to = strtotime(trim($date[1]));
        $to = $to;
        }else{
        $to = time();
        $from = time() - (60*60*24*7);
        }
       
        $data = array();
        // exit();
        return view('/admin/report/award_report',['search' => $request->search]);
    }

    function generateAwardReport()
    {
        return Excel::download(new AwardExport(), 'AwardReport.xlsx');
    }

    function generateRosterReportExcelNew($request)
{
    ini_set('memory_limit', '-1');
    $start_str = strtotime($request['start']);
    $end_str = strtotime($request['end']);
    $logo = '';
    // echo $request['start'];
    // exit(); 
    // $logo = config('custom.logo');
    // <img class="navbar-brand-logo" src="'.$logo.'" title="247 staffing solution" height="50">
    $customers = explode(',', $request['customers']);
    $pdf = '';
    foreach ($customers as $key => $cust) {
        $customer = DB::table('customers')->where('id', $cust)->select('name')->first();
            $data = DB::table('jobs')->where('customer_id', $cust)->select('id');
            if (isset($request['search_value']) && $request['search_value'] != 'undefined' && !empty($request['search_value'])) {
                $search_value = json_decode($request['search_value'], true);
                $data->where(function ($query1) use ($search_value){
                    $i = 0;
                foreach($search_value as $index) {
                    if ($i == 0) {
                        $query1->where('id', $index);
                    }else{
                    $query1->orWhere('id', $index);
                    }
                $i++;
                }
                });
        }  
           $sites= $data->get();
        $pdf .= '
  <table style="width:100%;">
  <thead>
  <tr>
  <th style="width:200px;background-color:yellow;border:1px solid black;"></th>
  <th style="width:200px;background-color:yellow;border:1px solid black;"></th>
  <th style="width:200px;background-color:yellow;border:1px solid black;"></th>
  <th style="text-align: center; font-size:22px; font-weight:bold; border:1px solid black; background-color:yellow;border:1px solid black;">
  <div style="text-align: center; font-size:18px;">Roster Report '.$customer->name.' - Week starting '.date('D, M d, Y H:i', $start_str).' (Planned)</div>
  </th>
  <th style="width:200px;background-color:yellow;border:1px solid black;"></th>
  <th style="width:200px;background-color:yellow;border:1px solid black;"></th>
  <th style="width:200px;background-color:yellow;border:1px solid black;"></th>
  <th style="width:200px;background-color:yellow;border:1px solid black;"></th>
  <th style="width:200px;background-color:yellow;border:1px solid black;"></th>
  </tr>
  </thead>
  </table>';
  

  


  
  $datediff = $end_str - $start_str;
  $counter = 0;
  $guards_array = array();
  $diff = round($datediff / (60 * 60 * 24));
  $total_hours[0] = array(
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0
);
  foreach ($sites as $key => $site_id) {
      $day_start = $start_str-1;
      $day_end = $start_str + (60*60*24)-1;
      $days_td = array();
      $max_shifts_in_day = 0;
      $site = DB::table('jobs')->where('id', $site_id->id)->select('site_name', 'site_description')->first();
        $unique_guards = DB::table('job_new_roster')->where('site_id', $site_id->id)->where('temp_start', '>=', date('Y-m-d 00:00:00', $day_start))->where('temp_start', '<=', date('Y-m-d 00:00:00', ($day_start + strtotime('+7 days'))))->orderBy('job_start', 'ASC')->select('guard_id')->groupBy('guard_id')->get();
        // dd($site_id);
    foreach($unique_guards as $ug){
        if($ug->guard_id == null || $ug->guard_id == '')
        {
            $ug->guard_id = 0;
        }
      for ($i=0; $i < $diff; $i++) { 
          $days_td[$ug->guard_id][$i] = array(); 
            if ($request['report'] == 'divide') {

        // check if any shift ends in this time
          $shifts_ends_in_this_day = DB::table('job_new_roster')->where('site_id', $site_id->id)->where('temp_start', '<', date('Y-m-d 00:00:00', $day_start))->where('temp_end','>', date('Y-m-d 00:00:00', $day_start))->where('guard_id', $ug->guard_id)->orderBy('job_start', 'ASC')->get();

          $shifts_start_in_this_day = DB::table('job_new_roster')->where('site_id', $site_id->id)->where('temp_start', '>=', date('Y-m-d 00:00:00', $day_start))->where('temp_start', '<=', date('Y-m-d 00:00:00', $day_end))->where('guard_id', $ug->guard_id)->orderBy('job_start', 'ASC')->get();

          $all_shifts = $shifts_ends_in_this_day->merge($shifts_start_in_this_day);
      }else{
        $all_shifts = DB::table('job_new_roster')->where('site_id', $site_id->id)->where('temp_start', '>=', date('Y-m-d 00:00:00', $day_start))->where('temp_start', '<=', date('Y-m-d 00:00:00', $day_end))->orderBy('job_start', 'ASC')->where('guard_id', $ug->guard_id)->get();
      }

          foreach ($all_shifts as $all_shift) 
          {
              $guard = DB::table('guards')->where('id', $all_shift->guard_id)->first();
              if (!empty($guard) && !isset($guards_array[$guard->id])) {
                $guards_array[$guard->id] = array(
                  'name' => $guard->name, 
                  'id' => $guard->id,
                  'phone' => $guard->phone,
                  'suburb' => $guard->suburb,
                  'security_license_expiration' => $guard->security_license_expiration,
                  'security_license_number' => $guard->security_license_number,
              );
            }
            $all_shift->temp_start = strtotime($all_shift->temp_start); 
            $all_shift->temp_end = strtotime($all_shift->temp_end);
            if ($request['report'] == 'divide') {
            if ($all_shift->temp_start < $day_start && $all_shift->temp_end > $day_start) {
                $all_shift->temp_start = $day_start + 100;
            }
            elseif ($all_shift->temp_start > $day_start && $all_shift->temp_end > $day_end) {
                $all_shift->temp_end = $day_end;
            }
            }
            $diff_hour = $all_shift->temp_end - $all_shift->temp_start;
            $hours = $diff_hour / ( 60 * 60 );
            $total_hours_count = explode('.', $hours);
            if (sizeof($total_hours_count) > 1 ) {
              $partial = '.'.$total_hours_count[1];
              if ($partial < 0.1) {
                $hours = $total_hours_count[0];
            }
            if ($partial < 0.27 && $partial > 0.1) {
                $hours = $total_hours_count[0].'.25';
            }
            if ($partial > 0.27 && $partial < 0.52) {
                $hours = $total_hours_count[0].'.5';
            }
            if ($partial > 0.52 && $partial < 0.77) {
                $hours = $total_hours_count[0].'.75';
            }
            if ($partial > 0.77 && $partial < 1) {
                $hours = $total_hours_count[0]+ 1;
            }
        }

        $days_td[$ug->guard_id][$i][] = array(
            'guard_name' => !empty($guard) ? $guard->name : $all_shift->moke_guard,
            'start' => date('H:i a', $all_shift->temp_start),
            'end' => date('H:i a', $all_shift->temp_end),
            'day_start' => date('m/d/Y H:i a', $day_start),
            'day_end' => date('m/d/Y H:i a', $day_end),
            'hours' => $hours,
            'training' => $all_shift->training
        );
    }
    $day_start = $day_end + 1;
    $day_end = $day_end + (60*60*24);
    if (count($days_td[$ug->guard_id][$i]) > $max_shifts_in_day) {
      $max_shifts_in_day = count($days_td[$ug->guard_id][$i]);
  }

}
$day_start = $start_str-1;
$day_end = $start_str + (60*60*24)-1;
}

// print_r('<pre>');
// print_r($days_td);
// exit();
$total_hours[$site_id->id] = array(
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0
);
if (!empty($days_td) && count($days_td) > 0 && $max_shifts_in_day > 0) {
    $site_name = $site->site_name;
    if($site->site_description != '')
    {
        $site_name .= ' - '. htmlspecialchars($site->site_description);
    }
$pdf .= '
  <table style="width:100%;background-color:#CCC0DA;">
  <thead>
  <tr>
  <th style="width:170px;background-color:#CCC0DA;border:1px solid black;"></th>
  <th style="width:170px;background-color:#CCC0DA;border:1px solid black;"></th>
  <th style="width:170px;background-color:#CCC0DA;border:1px solid black;"></th>

  <th style="text-align: center; font-size:22px; font-weight:bold; border:1px solid black; background-color:#CCC0DA;">
  <div style="text-align: center; font-size:18px;">'.$site_name.'</div>
  </th>
  <th style="width:170px;background-color:#CCC0DA;border:1px solid black;"></th>
  <th style="width:170px;background-color:#CCC0DA;border:1px solid black;"></th>
  <th style="width:170px;background-color:#CCC0DA;border:1px solid black;"></th>
  <th style="width:170px;background-color:#CCC0DA;border:1px solid black;"></th>
  <th style="width:170px;background-color:#CCC0DA;border:1px solid black;"></th>

  </tr>
  </thead>
  </table>';
$pdf .='<table style="width:100%;">
  <thead>
  <tr>
  <th style="border:1px solid #000000;width: 20px;font-size:15px;background-color:#F2DCDB;">Guard\'s
  Name
  </th>';
  for ($i=$start_str; $i < $end_str;) { 
      $pdf .= '<th style="border:1px solid #000000;width: 20px;font-size:15px;background-color:#F2DCDB;">'.date('D M d', $i).'</th>';
      $i = $i + (60*60 *24);
  }
  $pdf .='<th style="border:1px solid #000000;width: 20px; font-size:15px; background-color:#F2DCDB;">
  Total Hrs | Wages
  </th>
  </tr></thead>
<tbody>';
}
$c = 0;
foreach($days_td as $key => $value){
    $background_color = '#DCE6F1';
    if ($c % 2 == 0) {
        $background_color = '';
    }
    if ($max_shifts_in_day > 1) {
        $max_shifts_in_day = 1;
    }
// for ($i=0; $i < $max_shifts_in_day; $i++) { 
for ($i=0; $i < $max_shifts_in_day; $i++) { 
if (isset($guards_array[$key]['name'])) {
  $pdf .= '<tr>';
  $pdf .= '<td style="border:1px solid #000000; background-color:'.$background_color.'; width:170px;">'.(isset($guards_array[$key]['name']) ? $guards_array[$key]['name'] : 'N/A').'</td>';
  $pdf .= '<td style="border:1px solid #000000;width:170px;background-color:'.$background_color.';">'.((isset($days_td[$key][0][$i])) ? $days_td[$key][0][$i]['start']. ' - '. $days_td[$key][0][$i]['end'].'('.$days_td[$key][0][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[$key][0][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;width:170px;background-color:'.$background_color.';">'.((isset($days_td[$key][1][$i])) ? $days_td[$key][1][$i]['start']. ' - '. $days_td[$key][1][$i]['end'].'('.$days_td[$key][1][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[$key][1][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;width:170px;background-color:'.$background_color.';">'.((isset($days_td[$key][2][$i])) ? $days_td[$key][2][$i]['start']. ' - '. $days_td[$key][2][$i]['end'].'('.$days_td[$key][2][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[$key][2][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;width:170px;background-color:'.$background_color.';">'.((isset($days_td[$key][3][$i])) ? $days_td[$key][3][$i]['start']. ' - '. $days_td[$key][3][$i]['end'].'('.$days_td[$key][3][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[$key][3][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;width:170px;background-color:'.$background_color.';">'.((isset($days_td[$key][4][$i])) ? $days_td[$key][4][$i]['start']. ' - '. $days_td[$key][4][$i]['end'].'('.$days_td[$key][4][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[$key][4][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;width:170px;background-color:'.$background_color.';">'.((isset($days_td[$key][5][$i])) ? $days_td[$key][5][$i]['start']. ' - '. $days_td[$key][5][$i]['end'].'('.$days_td[$key][5][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[$key][5][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;width:170px;background-color:'.$background_color.';">'.((isset($days_td[$key][6][$i])) ? $days_td[$key][6][$i]['start']. ' - '. $days_td[$key][6][$i]['end'].'('.$days_td[$key][6][$i]['hours'].'h)'.(($request['report'] == 'normal' && $days_td[$key][6][$i]['training'] == 1) ? ' (T)' : '') : '').'</td>';
  $pdf .= '<td style="border:1px solid #000000;width:170px;background-color:'.$background_color.';"></td>';
  $total_hours[$site_id->id][0] = $total_hours[$site_id->id][0] + (isset($days_td[$key][0][$i]) ? $days_td[$key][0][$i]['hours'] : 0);
  $total_hours[$site_id->id][1] = $total_hours[$site_id->id][1] + (isset($days_td[$key][1][$i]) ? $days_td[$key][1][$i]['hours'] : 0); 
  $total_hours[$site_id->id][2] = $total_hours[$site_id->id][2] + (isset($days_td[$key][2][$i]) ? $days_td[$key][2][$i]['hours'] : 0); 
  $total_hours[$site_id->id][3] = $total_hours[$site_id->id][3] + (isset($days_td[$key][3][$i]) ? $days_td[$key][3][$i]['hours'] : 0); 
  $total_hours[$site_id->id][4] = $total_hours[$site_id->id][4] + (isset($days_td[$key][4][$i]) ? $days_td[$key][4][$i]['hours'] : 0); 
  $total_hours[$site_id->id][5] = $total_hours[$site_id->id][5] + (isset($days_td[$key][5][$i]) ? $days_td[$key][5][$i]['hours'] : 0); 
  $total_hours[$site_id->id][6] = $total_hours[$site_id->id][6] + (isset($days_td[$key][6][$i]) ? $days_td[$key][6][$i]['hours'] : 0); 

  $pdf .= '</tr>';
}
}
$c++;
}
if (($total_hours[$site_id->id][0] + $total_hours[$site_id->id][1] + $total_hours[$site_id->id][2]+ $total_hours[$site_id->id][3]+ $total_hours[$site_id->id][4]+ $total_hours[$site_id->id][5]+ $total_hours[$site_id->id][6]) > 0) {
   $pdf .= '<tr>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">Sub Total Hrs | Wages</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][0].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][1].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][2].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][3].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][4].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][5].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.$total_hours[$site_id->id][6].'</td>';
   $pdf .= '<td style="border:1px solid #000000;background-color:#E8E8B6;">'.($total_hours[$site_id->id][0] + $total_hours[$site_id->id][1] + $total_hours[$site_id->id][2]+ $total_hours[$site_id->id][3]+ $total_hours[$site_id->id][4]+ $total_hours[$site_id->id][5]+ $total_hours[$site_id->id][6]).'</td>';
   $pdf .= '</tr>';

   $total_hours[0] = array(
    0 => $total_hours[0][0] + $total_hours[$site_id->id][0],
    1 => $total_hours[0][1] + $total_hours[$site_id->id][1],
    2 => $total_hours[0][2] + $total_hours[$site_id->id][2],
    3 => $total_hours[0][3] + $total_hours[$site_id->id][3],
    4 => $total_hours[0][4] + $total_hours[$site_id->id][4],
    5 => $total_hours[0][5] + $total_hours[$site_id->id][5],
    6 => $total_hours[0][6] + $total_hours[$site_id->id][6],
    7 => $total_hours[0][7] + ($total_hours[$site_id->id][0] + $total_hours[$site_id->id][1] + $total_hours[$site_id->id][2]+ $total_hours[$site_id->id][3]+ $total_hours[$site_id->id][4]+ $total_hours[$site_id->id][5]+ $total_hours[$site_id->id][6])
);
}
if (!empty($days_td) && count($days_td) > 0  && $max_shifts_in_day > 0) {
$pdf .='</tbody></table>';
}
}


if (!empty($guards_array)) {

$pdf .='<table style="width:100%;"><tbody>
<tr>
<td style="border:1px solid #000000; background-color:#D8E4BC;">
<div style="text-align: center;" class="title">Guard Details</div>
</td>
</tr></tbody></table>
<table style="width:100%;">
<thead>
<tr>
<th style="border:1px solid #000000;background-color:#C5D9F1;">
Guard name
</th>
<th style="border:1px solid #000000;background-color:#C5D9F1;">
Guard Mob
</th>
<th style="border:1px solid #000000;background-color:#C5D9F1;">
Suburb
</th>
<th style="border:1px solid #000000;background-color:#C5D9F1;">
Security License
</th>
<th style="border:1px solid #000000;background-color:#C5D9F1;">
Security License Expiry
</th>
</tr></thead><tbody>
';
$c = 0;
foreach ($guards_array as $key => $guard) {
    $background_color = '#DCE6F1';
    if ($c % 2 == 0) {
        $background_color = '';
    }
   $pdf .='<tr>
   <td style="border:1px solid #000000;background-color:'.$background_color.';">'.$guard['name'].'</td>
   <td style="border:1px solid #000000;background-color:'.$background_color.';">'.$guard['phone'].'</td>
   <td style="border:1px solid #000000;background-color:'.$background_color.';">'.$guard['suburb'].'</td>
   <td style="border:1px solid #000000;background-color:'.$background_color.';">'.$guard['security_license_number'].'</td>
   <td style="border:1px solid #000000;background-color:'.$background_color.';">'.$guard['security_license_expiration'].'</td>
   </tr>';
   $c++;
}
$pdf .= '</tbody></table>';
}
}
// $pdf .= '</div>
// </div></body></html>';
// $pdf_data = $pdf;
// return View('admin/report/excel',compact('pdf_data'));
// echo $pdf;
// exit();
return $pdf;
}
}
