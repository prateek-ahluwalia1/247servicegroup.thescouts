<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Job as job;
use App\Models\Contractor as contractor;
use App\Models\Customer as customer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Administrator as administrator;


class Jobs extends Controller
{

    public  $administrator;
   
    public function __construct(administrator $administrator) {
        $this->administrator = $administrator;
    }
    public function get_customers_jobs(Request $request)
    {
    	// ->join('customers', 'customers.id', '=', 'jobs.customer_id')
    	$jobs = job::select('jobs.id as jobId', 'jobs.address', 'jobs.site_name', 'jobs.site_description')->where(['customer_id' => $request->customerId])->where('status', 'active')->get();
        return response()->json($jobs);
    }

    function get_customers_jobs_list(Request $request){
    	$status = null;
    	$specific_sites_id = array();
      // if ($user_type != null && $user_type == 'contractor') {
        // $this->db->select('contractors.id as customerId,jobs.id as jobId, jobs.address as address, jobs.booking_id as bookingId, jobs.site_name, jobs.site_description');
        // $this->db->from('jobs');
        // $this->db->join('customers', 'customers.id = jobs.customer_id');
        // $this->db->join('contractors', 'contractors.id =  jobs.contractor_id');
        // $this->db->where('contractors.id', $customerId);
        // $this->db->where('jobs.status', 'active');
        // $data = $this->db->get()->result();
      // }else{
        // $this->db->select('customers.id as customerId,jobs.id as jobId, jobs.address as address, jobs.booking_id as bookingId, jobs.site_name, jobs.site_description');
        // $this->db->from('jobs');
        // $this->db->join('customers', 'customers.id =  jobs.customer_id');
        // $this->db->where('customers.id', $customerId);
        // $this->db->where('jobs.status', 'active');
        // if ($state != null) {
        //   $this->db->where('jobs.state', $state);
        // }
        // $data = $this->db->get()->result();

        $data = DB::table('jobs')->join('customers', 'customers.id', '=', 'jobs.customer_id')
        ->where('customers.id', $request->customerId)
        ->where('jobs.status', 'active')
        ->select('customers.id as customerId','jobs.id as jobId', 'jobs.address as address', 'jobs.booking_id as bookingId', 'jobs.site_name', 'jobs.site_description')->get();


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

    function add_site_from(Request $request)
    {
        if (session()->get('userType') == 'customer') {
          $customers = customer::where('status','active')->where('id', session()->get('userId'))->get();
        }else{
        $customers = customer::where('status','active')->get();
        }
        $contractors = contractor::where('status', 'active')->get();
        $payrate = array();
        $charge_rate = array();
        $config_recods = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id'  , config('custom.domain_id'))->where('type' , 'job_roster_navigation_bar')->first();
        $settings = !empty($config_recods) ? json_decode($config_recods->records_business_navbar, true) : array();
        $payrates = array();

        $html = view('admin/modals/add_site_from', ['customers' => $customers, 'contractors' => $contractors, 'payrate' => $payrate, 'charge_rate' => $charge_rate, 'add' => true, 'settings' => $settings, 'payrates' => $payrates])->render();
        return response()->json($html);

    }

    function edit_site_form(Request $request)
    {
      // dd($request->all());
      if (session()->get('userType') == 'customer') {
          $customers = customer::where('status','active')->where('id', session()->get('userId'))->get();
        }else{
        $customers = customer::where('status', 'active')->get();
      }
        $contractors = contractor::where('status', 'active')->get();
        $site_data = job::where('id', $request->site_id)->first();
        $config_recods = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id'  , config('custom.domain_id'))->where('type' , 'job_roster_navigation_bar')->first();
        $settings = !empty($config_recods) ? json_decode($config_recods->records_business_navbar, true) : array();
        $site_data->custom_rate = json_decode($site_data->custom_rate, true);
        $site_data->custom_charge_rate = json_decode($site_data->custom_charge_rate, true);
        // print_r($site_data->custom_rate);
        // exit();
        if ($site_data->site_payrate_type != '') {
            if ($site_data->site_payrate_type == 'award') {
                 $payrates = DB::table('award_payrates')->select('id', 'title')->get();
            }else{
                 $payrates = DB::table('payrates')->where('payrate_type', $site_data->site_payrate_type)->select('id', 'title')->get();
            }
        }else{
            $payrates = array();
        }
        $html = view('admin/modals/add_site_from', ['customers' => $customers, 'contractors' => $contractors, 'site_data' => $site_data, 'settings' => $settings, 'payrates' => $payrates])->render();
        return response()->json($html);

    }

    function add_guard_from(Request $request)
    {
        $customers = customer::where('status', 'active')->get();
        $html = view('admin/modals/add_guard_from', ['customers' => $customers])->render();
        return response()->json($html);

    }
    function get_site_detail(Request $request, $id)
    {
      $query =  DB::table('jobs')->where('id', $id)->first();
      return response()->json(['success' => true, 'data' => $query]);
    }

    function get_site_data(Request $request)
    {
        $site = job::find($request->siteId);
        return response()->json(['site_data' => $site]);

    }

    function add_site(Request $request)
    {
      $data=array();
      $data['booking_id'] = substr(uniqid(), 0, 4).'-'.substr(uniqid(), 5, 4);
      $data['customer_id'] = $request->site_customer_id;
      if ($request->has('customer_id') && $request->customer_id > 0) {
        $data['customer_id'] = $request->customer_id;
      }
      $data['site_employer'] = $request->site_employer;
      $data['site_tasks'] = json_encode((!empty($request->site_tasks) && $request->site_tasks !=null) ? $request->site_tasks : [] ,true) ;
      $data['level'] = $request->site_level;
      $data['payrol'] = ($request->payrol != null) ? $request->payrol : '';
      $data['state'] = $request->site_state;
      $data['stateType'] = $request->stateType;
      $data['trained'] = ($request->has('site_trained') ? $request->site_trained : 'no' );
      // $data['green_call'] = $request->site_employer;
      $data['green_call'] = 'yes';
      $data['welfare_call'] = $request->welfare_call;
      $data['welfare_timing'] = $request->welfare_timing;
      $data['details'] = ($request->instrcutions == null || $request->instrcutions == '') ? '' : $request->instrcutions;
      $data['sos_phone'] = ($request->sos_phone == null || $request->sos_phone == '') ? '' : $request->sos_phone;
      $data['start'] =  ($request->site_start_date == null || $request->site_start_date == '') ? '' : $request->site_start_date;
      $data['end'] = ($request->site_end_date == null || $request->site_end_date == '') ? '' : $request->site_end_date;
      $data['address'] = $request->address;
      $data['coordinates'] = $request->coordinates;
      $data['site_name'] = $request->site_name;
      $data['site_description'] = ($request->site_description == null || $request->site_description == '') ? '' : $request->site_description;
      $data['signin_radius'] = ($request->signin_radius == null || $request->signin_radius == '') ? 0 : $request->signin_radius;
      $data['alert_radius'] = ($request->radius_alert == null || $request->radius_alert == '') ? 0 : $request->radius_alert;
      $data['site_payrate'] = ($request->site_payrate == null || $request->site_payrate == '') ? 0 : $request->site_payrate;
      $data['apply_date'] = ($request->apply_date == null || $request->apply_date == '') ? '' : $request->apply_date;
      $data['apply_to_date'] = ($request->apply_to_date == null || $request->apply_to_date == '') ? '' : $request->apply_to_date;
      $data['charge_apply_date'] = ($request->charge_apply_date == null || $request->charge_apply_date == '') ? '' : $request->charge_apply_date;

      $data['site_charge_rate'] = ($request->site_charge_rate == null || $request->site_charge_rate == '') ? 0 : $request->site_charge_rate;
      $data['site_payrate_level'] = ($request->site_payrate_level == null || $request->site_payrate_level == '') ? 0 : $request->site_payrate_level;
      $data['site_chargerate_level'] = ($request->site_chargerate_level == null || $request->site_chargerate_level == '') ? 0 : $request->site_chargerate_level;
      $data['break'] = ($request->site_break != null) ? $request->site_break : 'no';
      $data['site_hours'] = $request->site_hours;
      $data['payable_and_chargeable_time'] = $request->payable_and_chargeable_time;
      $data['break_deduction_chargeable'] = $request->break_deduction_chargeable;
      $data['chargeable'] = $request->has('chargeable') ? $request->chargeable : 'no';
      $data['payable'] = $request->has('payable') ? $request->payable : 'no';
      $data['guards_count'] = 0;
      $data['date_added'] = time();
      $data['week_schedule'] = '[]';
      $data['site_type'] = ($request->site_type != null) ? $request->site_type : 'direct';
      $data['unpublished_site'] = ($request->unpublished_site != null) ? $request->unpublished_site : '';
      $data['custom_payrate'] = ($request->custom_payrate != null) ? $request->custom_payrate : 0;
      $data['custom_chargerate'] = ($request->custom_chargerate != null) ? $request->custom_chargerate : 0;
      $data['pw_order'] = ($request->pw_order != null) ? $request->pw_order : '';
      if (config('custom.own_payrates') == 1) {
      $data['site_payrate_type'] = ($request->payrate_type != null) ? $request->payrate_type : '';
      $data['site_payrate'] = ($request->payrate_id != null) ? $request->payrate_id : '';
        
      }

      $custom_rate = [
        'flat_metro_week_day_day' => $request->flat_metro_week_day_day,
        'flat_regional_week_day_day' => $request->flat_regional_week_day_day,
        'flat_metro_week_day_night' => $request->flat_metro_week_day_night,
        'flat_regional_week_day_night' => $request->flat_regional_week_day_night,
        'flat_metro_friday' => $request->flat_metro_friday,
        'flat_regional_friday' => $request->flat_regional_friday,
        'flat_metro_saturday' => $request->flat_metro_saturday,
        'flat_regional_saturday' => $request->flat_regional_saturday,
        // 'flat_metro_saturday_night' => $request->flat_metro_saturday_night,
        'flat_metro_saturday_night' => $request->flat_metro_saturday,
        // 'flat_regional_saturday_night' => $request->flat_regional_saturday_night,
        'flat_regional_saturday_night' => $request->flat_regional_saturday,
        'flat_metro_sunday' => $request->flat_metro_sunday,
        'flat_regional_sunday' => $request->flat_regional_sunday,
        // 'flat_metro_sunday_night' => $request->flat_metro_sunday_night,
        'flat_metro_sunday_night' => $request->flat_metro_sunday,
        // 'flat_regional_sunday_night' => $request->flat_regional_sunday_night,
        'flat_regional_sunday_night' => $request->flat_regional_sunday,
        'flat_metro_public_holiday' => $request->flat_metro_public_holiday,
        'flat_regional_public_holiday' => $request->flat_regional_public_holiday,
        // 'flat_metro_public_holiday_night' => $request->flat_metro_public_holiday_night,
        'flat_metro_public_holiday_night' => $request->flat_metro_public_holiday,
        // 'flat_regional_public_holiday_night' => $request->flat_regional_public_holiday_night,
        'flat_regional_public_holiday_night' => $request->flat_regional_public_holiday,

        'eba_metro_weekday_day' => $request->flat_metro_week_day_day,
        'eba_regional_weekday_day' => $request->flat_regional_week_day_day,
        'eba_metro_weekday_night' => $request->flat_metro_week_day_night,
        'eba_regional_weekday_night' => $request->flat_regional_week_day_night,
        'eba_metro_saturday_day' => $request->eba_metro_saturday_day,
        'eba_regional_saturday_day' => $request->eba_regional_saturday_day,
        'eba_metro_saturday_night' => $request->eba_metro_saturday_night,
        'eba_regional_saturday_night' => $request->eba_regional_saturday_night,
        'eba_metro_sunday_day' => $request->eba_metro_sunday_day,
        'eba_regional_sunday_day' => $request->eba_regional_sunday_day,
        'eba_metro_sunday_night' => $request->eba_metro_sunday_night,
        'eba_regional_sunday_night' => $request->eba_regional_sunday_night,
        'eba_metro_public_holiday' => $request->eba_metro_public_holiday,
        'eba_regional_public_holiday' => $request->eba_regional_public_holiday,
        'eba_metro_public_holiday_night' => $request->eba_metro_public_holiday_night,
        'eba_regional_public_holiday_night' => $request->eba_regional_public_holiday_night,

        'award_metro_weekday_day' => $request->flat_metro_week_day_day,
        'award_regional_weekday_day' => $request->flat_regional_week_day_day,
        'award_metro_weekday_night' => $request->flat_metro_week_day_night,
        'award_regional_weekday_night' => $request->flat_regional_week_day_night,
        'award_metro_saturday_day' => $request->award_metro_saturday_day,
        'award_regional_saturday_day' => $request->award_regional_saturday_day,
        'award_metro_saturday_night' => $request->award_metro_saturday_night,
        'award_regional_saturday_night' => $request->award_regional_saturday_night,
        'award_metro_sunday_day' => $request->award_metro_sunday_day,
        'award_regional_sunday_day' => $request->award_regional_sunday_day,
        'award_metro_sunday_night' => $request->award_metro_sunday_night,
        'award_regional_sunday_night' => $request->award_regional_sunday_night,
        'award_metro_public_holiday' => $request->award_metro_public_holiday,
        'award_regional_public_holiday' => $request->award_regional_public_holiday,
        'award_metro_public_holiday_night' => $request->award_metro_public_holiday_night,
        'award_regional_public_holiday_night' => $request->award_regional_public_holiday_night,

      ];
      $data['custom_rate'] = json_encode($custom_rate);

      $custom_charge_rate = [
        'flat_metro_week_day_day' => $request->charge_rate_flat_metro_week_day_day,
        'flat_regional_week_day_day' => $request->charge_rate_flat_regional_week_day_day,
        'flat_metro_week_day_night' => $request->charge_rate_flat_metro_week_day_night,
        'flat_regional_week_day_night' => $request->charge_rate_flat_regional_week_day_night,
        'flat_metro_friday' => $request->charge_rate_flat_metro_friday,
        'flat_regional_friday' => $request->charge_rate_flat_regional_friday,
        'flat_metro_saturday' => $request->charge_rate_flat_metro_saturday,
        'flat_regional_saturday' => $request->charge_rate_flat_regional_saturday,
        // 'flat_metro_saturday_night' => $request->charge_rate_flat_metro_saturday_night,
        'flat_metro_saturday_night' => $request->charge_rate_flat_metro_saturday,
        // 'flat_regional_saturday_night' => $request->charge_rate_flat_regional_saturday_night,
        'flat_regional_saturday_night' => $request->charge_rate_flat_regional_saturday,
        'flat_metro_sunday' => $request->charge_rate_flat_metro_sunday,
        'flat_regional_sunday' => $request->charge_rate_flat_regional_sunday,
        // 'flat_metro_sunday_night' => $request->charge_rate_flat_metro_sunday_night,
        'flat_metro_sunday_night' => $request->charge_rate_flat_metro_sunday,
        // 'flat_regional_sunday_night' => $request->charge_rate_flat_regional_sunday_night,
        'flat_regional_sunday_night' => $request->charge_rate_flat_regional_sunday,
        'flat_metro_public_holiday' => $request->charge_rate_flat_metro_public_holiday,
        'flat_regional_public_holiday' => $request->charge_rate_flat_regional_public_holiday,
        // 'flat_metro_public_holiday_night' => $request->charge_rate_flat_metro_public_holiday_night,
        'flat_metro_public_holiday_night' => $request->charge_rate_flat_metro_public_holiday,
        // 'flat_regional_public_holiday_night' => $request->charge_rate_flat_regional_public_holiday_night,
        'flat_regional_public_holiday_night' => $request->charge_rate_flat_regional_public_holiday,

        'eba_metro_weekday_day' => 0,
        'eba_regional_weekday_day' => 0,
        'eba_metro_weekday_night' => 0,
        'eba_regional_weekday_night' => 0,
        'eba_metro_saturday_day' => 0,
        'eba_regional_saturday_day' => 0,
        'eba_metro_saturday_night' => 0,
        'eba_regional_saturday_night' => 0,
        'eba_metro_sunday_day' => 0,
        'eba_regional_sunday_day' => 0,
        'eba_metro_sunday_night' => 0,
        'eba_regional_sunday_night' => 0,
        'eba_metro_public_holiday' => 0,
        'eba_regional_public_holiday' => 0,
        'eba_metro_public_holiday_night' => 0,
        'eba_regional_public_holiday_night' => 0,

        'award_metro_weekday_day' => 0,
        'award_regional_weekday_day' => 0,
        'award_metro_weekday_night' => 0,
        'award_regional_weekday_night' => 0,
        'award_metro_saturday_day' => 0,
        'award_regional_saturday_day' => 0,
        'award_metro_saturday_night' => 0,
        'award_regional_saturday_night' => 0,
        'award_metro_sunday_day' => 0,
        'award_regional_sunday_day' => 0,
        'award_metro_sunday_night' => 0,
        'award_regional_sunday_night' => 0,
        'award_metro_public_holiday' => 0,
        'award_regional_public_holiday' => 0,
        'award_metro_public_holiday_night' => 0,
        'award_regional_public_holiday_night' => 0,

      ];
      $data['custom_charge_rate'] = json_encode($custom_charge_rate);
       if($request->file('job_instruction_file')){
            $public_path = public_path();
            $public_path = str_replace('portal/public', '', $public_path);
            $public_path = str_replace('apis/public', '', $public_path);
            $path = $public_path.'asset_uploads/';
            $file= $request->file('job_instruction_file');
            $filename= time().$file->getClientOriginalName();
            $file-> move($path, $filename);
            $data['job_instruction_file']= $filename;
        }

      $previous_payrate_id = 0;
      $previous_charge_id = 0;
      if ($request->has('admin_id') && $request->admin_id != '') {
        session([
            'userId' => $request->admin_id,
        ]);
    }
      if ($request->has('site_id')) {
        $id = $request->site_id;
        $data1=DB::table('jobs')->where('id',$id)->first();
        $previous_payrate_id = $data1->site_payrate;
        $previous_charge_id = $data1->site_charge_rate;
        $action='site_update';
        $this->administrator->log_user_activity($action,$data1);
        job::where('id', $id)->update($data);
        $message = 'Site update successfuly.';
      }else{
      $message = 'Site added successfuly.';
      
      $id = job::insertGetId($data);
      $data=DB::table('jobs')->where('id',$id)->first();
      $action='site_add';
      $this->administrator->log_user_activity($action,$data);

      }
      if ($id != '') {

       if ($request->has('payrate_change') && $request->payrate_change == 1) {
         $this->logSitePayrate($id, $request->site_payrate, $previous_payrate_id, $request->apply_date, $request->apply_to_date);
         if (strtotime($request->apply_date) < strtotime(date('m/d/Y'))) {
           $this->updateOldShiftsPayRate($id, $request->site_payrate, $request->apply_date, $request->apply_date);
         }
       }
       if ($action == 'site_add' && $request->site_payrate > 0) {
         $this->logSitePayrate($id, $request->site_payrate, 0, date('m/d/Y'));
       }
       if ($request->has('charge_change') && $request->charge_change == 1) {
         $this->logSiteChargerate($id, $request->site_charge_rate, $previous_charge_id, $request->charge_apply_date);
         if (strtotime($request->charge_apply_date) < strtotime(date('m/d/Y'))) {
           $this->updateOldShiftsChargeRate($id, $request->site_charge_rate, $request->charge_apply_date);
         }
       }
      return response()->json(['success' => true, 'message' => $message]);
      }else{
      return response()->json(['success' => false, 'message' => 'Fail to add site.']);
      }
    }

  function updateOldShiftsPayRate($site_id, $payrate_id, $apply_date, $apply_to_date = null)
  {
    $payrate = DB::table('payrates')->where('id', $payrate_id)->where('archive', 0)->first();
    if ($apply_to_date == null || $apply_to_date == '') {
      $apply_to_date = date('m/d/Y H:i:s');
    }
    DB::table('job_new_roster')
    ->where('temp_start', '>=', date('Y-m-d 00:00:00', strtotime($apply_date)))
    ->where('temp_start', '<=', date('Y-m-d 00:00:00', strtotime($apply_to_date)))->where('site_id', $site_id)->where('custom_rates', 'no')->update(['payrate_applied' => json_encode($payrate)]);
  }

  function updateOldShiftsChargeRate($site_id, $chargerate_id, $apply_date)
  {
    $chargerate = DB::table('charged_rates')->where('archive', 0)->where('id', $chargerate_id)->first();
    DB::table('job_new_roster')->where('temp_start', '>=', date('Y-m-d 00:00:00', strtotime($apply_date)))->where('site_id', $site_id)->where('custom_rates', 'no')->update(['chargerate_applied' => json_encode($chargerate)]);
  }

    function logSiteChargerate($site_id, $current_chargerate_id, $previous_chargerate_id, $apply_date)
    {
      if ($previous_chargerate_id == 0) {
        DB::table('site_chargerate_history')->insert([
          'site_id' => $site_id,
          'chargerate_id' => $current_chargerate_id,
          'apply_date' => strtotime($apply_date),
          'changed_by' => session()->get('userId')
        ]);
      }else{
        if ($current_chargerate_id == $previous_chargerate_id) {
          DB::table('site_chargerate_history')->where([
          'site_id' => $site_id,
          'chargerate_id' => $current_chargerate_id,
          'changed_by' => session()->get('userId')
        ])->update(['apply_date' => strtotime($apply_date)]);
        }else{
          DB::table('site_chargerate_history')->insert([
          'site_id' => $site_id,
          'chargerate_id' => $current_chargerate_id,
          'apply_date' => strtotime($apply_date),
          'changed_by' => session()->get('userId')
        ]);
        }
      }
    }
    
    function logSitePayrate($site_id, $current_payrate_id, $previous_payrate_id, $apply_date, $apply_to_date = null)
    {
      if ($previous_payrate_id == 0) {
        DB::table('site_payrate_history')->insert([
          'site_id' => $site_id,
          'payrate_id' => $current_payrate_id,
          'apply_date' => strtotime($apply_date),
          'apply_to_date' => ($apply_to_date != null && $apply_to_date != '') ? strtotime($apply_to_date) : '',
          'changed_by' => session()->get('userId')
        ]);
      }else{
        if ($current_payrate_id == $previous_payrate_id) {
          DB::table('site_payrate_history')->where([
          'site_id' => $site_id,
          'payrate_id' => $current_payrate_id,
          'changed_by' => session()->get('userId')
        ])->update(['apply_date' => strtotime($apply_date)]);
          if($apply_to_date != null && $apply_to_date != ''){
          DB::table('site_payrate_history')->where([
          'site_id' => $site_id,
          'payrate_id' => $current_payrate_id,
          'changed_by' => session()->get('userId')
        ])->update(['apply_to_date' => strtotime($apply_to_date)]);
        }

        }else{
          DB::table('site_payrate_history')->insert([
          'site_id' => $site_id,
          'payrate_id' => $current_payrate_id,
          'apply_date' => strtotime($apply_date),
          'apply_to_date' => ($apply_to_date != null && $apply_to_date != '') ? strtotime($apply_to_date) : '',
          'changed_by' => session()->get('userId')
        ]);
        }
      }
    }


    function deleteSite(Request $request)
    {
        $data = job::where('id', $request->siteId)->first();
        $action = 'site_delete';
        $this->administrator->log_user_activity($action,$data);
      job::where('id', $request->siteId)->delete();
      return response()->json(['success' => true, 'message' => 'Site deleted successfuly']);
    }


    function pay_charge_history(Request $request)
    {
      if ($request->type == 'chargerate') {
        $history = DB::table('site_chargerate_history')
        ->join('administrators', 'administrators.id', '=', 'site_chargerate_history.changed_by')
        ->join('charged_rates', 'charged_rates.id', '=', 'site_chargerate_history.chargerate_id')
        ->where('site_chargerate_history.site_id', $request->id)
        ->orderBy('site_chargerate_history.id', 'desc')
        ->select('charged_rates.title', 'administrators.name', 'site_chargerate_history.id', 'site_chargerate_history.apply_date', 'site_chargerate_history.updated_at')
        ->get();
      }else{
        $history = DB::table('site_payrate_history')
        ->join('administrators', 'administrators.id', '=', 'site_payrate_history.changed_by')
        ->join('payrates', 'payrates.id', '=', 'site_payrate_history.payrate_id')
        ->where('site_payrate_history.site_id', $request->id)
        ->orderBy('site_payrate_history.id', 'desc')
        ->select('payrates.title', 'administrators.name', 'site_payrate_history.id', 'site_payrate_history.apply_date', 'site_payrate_history.apply_to_date', 'site_payrate_history.updated_at')
        ->get();
      }
      if (count($history) > 0) {
        foreach ($history as $key => $h) {
          // $h->data = json_decode($h->data, true);
        }
        $html = view('admin/modals/pay_charge_history', ['history' => $history])->render();
        return response()->json(['success' => true, 'message' => 'History Found.', 'html' => $html]);
      }else{
        return response()->json(['success' => false, 'message' => 'No History']);
      }
    }
    function getWeekList(Request $request)
    {
      $start = explode(' ', $request->start);
      $start = strtotime($start[0]);

      $html = view('admin.modals.getWeekList', ['start' => $start])->render();
      return response()->json($html);
    }
    public function get_site_list(Request $request)
    {
      $customerIds = $request->customers_id;
      $query =  DB::table('jobs')
        ->where(function ($query) use($customerIds){
            $i = 0;
            foreach ($customerIds as $key => $customerId) {
                if ($i = 0) {
                    $query->where('customer_id', $customerId);
                }else{
                    $query->orWhere('customer_id', $customerId);
                }
                $i++;
            }

        })
        ->select('jobs.*', 'site_name', 'site_description', 'customer_id')->where('status', 'active');
      if ($request->sort_by == 'active') {
            $query->join('job_new_roster', 'job_new_roster.site_id' ,'=', 'jobs.id')
            ->where('job_new_roster.temp_start', '>=', date('Y-m-d', strtotime('monday this week')))
            ->where('job_new_roster.temp_start', '<=', date('Y-m-d', strtotime('monday next week')))
            ->groupBy('job_new_roster.site_id');
        }
        $data = $query->orderBy('site_name', 'ASC')->get();
        if (count($data) > 0) {
          return response()->json(['success' => true, 'data' => $data, 'permissions'=>json_decode(session()->get('permissions'), true)]);
          
        }else{
          return response()->json(['success' => false, 'data' => $data]);
        }
    }

    public function site_list()
    {
      $customers = DB::table('customers')->where('status', 'active')->get(); 
      return view('admin/site_list', ['customers' => $customers]);
    }
    public function site_list_detail(Request $request){
      $site_detail =  DB::table('jobs')->where('id' , $request->site)->first();
      if($site_detail->site_charge_rate > 0)
      {
        $charged_rate = DB::table('charged_rates')->where('archive', 0)->where('id', $site_detail->site_charge_rate)->value('title');
        $site_detail->site_charge_rate = $charged_rate;
      }else{
        $site_detail->site_charge_rate = 'N/A';
      }
      if($site_detail->site_payrate > 0)
      {
        $charged_rate = DB::table('payrates')->where('id', $site_detail->site_payrate)->where('archive', 0)->value('title');
        $site_detail->site_payrate = $charged_rate;
      }else{
        $site_detail->site_payrate = 'N/A';
      }
      return view('admin/site_list_detail', ['value' => $site_detail, 'customer_id' => $request->customer_id, 'site_id' => $request->site]);
    }

    function getDayList(Request $request)
    {
      $start = explode(' ', $request->start);
      $start = strtotime($start[0]);
      $monthStart = date('m/01/Y', $start);
      $monthEnd = date('m/t/Y', $start);
      $days = date('t', $start);
      $event_id = $request->event_id;
      $month = date('m', $start);
      $html = view('admin.modals.getDayList', ['monthStart' => strtotime($monthStart), 'monthEnd' => $monthEnd, 'days' => $days, 'event_id' => $event_id, 'month' => $month])->render();
      return response()->json($html);
    }
    function restore_site($id)
    {
      $deleted = DB::table('log_user_activities')->where('id', $id)->first();
      if (!empty($deleted)) {
        $data = json_decode($deleted->data, true);
        DB::table('jobs')->insert($data);
        return response()->json(['message' => 'Site Restore']);
      }
    }
}
