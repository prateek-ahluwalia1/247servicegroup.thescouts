<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Reports;
use Carbon\Carbon;

class AwardReport extends Controller
{
    public $report;
      public function __construct(Reports $report)
  {
    $this->report = $report;
  }
    function award_data($request)
    {
        if (isset($request['search']) && $request['search'] != '') {
            $date = $request['search'];
            $date = explode('-', $date);
            $from = strtotime(trim($this->report->date_convert($date[0])));
            $to = strtotime(trim($this->report->date_convert($date[1])));
        }else{
        $to = time();
        $from = time() - (60*60*24*14);
        }
        $startDate = date('Y-m-d', $from);
        $endDate = date('Y-m-d', $to);
        $extra_query = '(jr.`job_status` = "completed" OR jr.`job_status` = "pending" OR jr.`job_status` = "confirmed" OR jr.`status_change_by` > 0) AND ';
        

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

        $query = DB::select($sql);
        $results = $query;
        foreach ($results as $result) {
            // $pay_rate = $result->flat_metro_week_day;
            $tempStart = date("H:i", strtotime($result->temp_start));
            $tempEnd = date("H:i", strtotime($result->temp_end));
            // $total = $this->getTimeDiff($result->temp_start, $result->temp_end);
            $total = $result->hours;
            if ($result->continuation == 0 && $total < 4) {
                $end = strtotime($result->temp_end);
                $remaining = 4 - $total;
                $end = $end + (60*60*$remaining);
                $job_hours = $this->report->getShiftHours($result->temp_start,date('Y-m-d H:i', $end), $result->site_id, $result->public_holiday, $result->ph_duration);
                }else{
                $job_hours = $this->report->getShiftHours($result->temp_start,$result->temp_end, $result->site_id, $result->public_holiday, $result->ph_duration);
            }

            $job_hours['morning'] = $this->report->convertIntoWhole($job_hours['morning']);
            $job_hours['night'] = $this->report->convertIntoWhole($job_hours['night']);
            $job_hours['saturday_morning'] = $this->report->convertIntoWhole($job_hours['saturday_morning']);
            $job_hours['saturday_night'] = $this->report->convertIntoWhole($job_hours['saturday_night']);
            $job_hours['sunday_morning'] = $this->report->convertIntoWhole($job_hours['sunday_morning']);
            $job_hours['sunday_night'] = $this->report->convertIntoWhole($job_hours['sunday_night']);
            $job_hours['ph_morning'] = $this->report->convertIntoWhole($job_hours['ph_morning']);
            $job_hours['ph_night'] = $this->report->convertIntoWhole($job_hours['ph_night']);
            $total = $job_hours['morning'] + $job_hours['night'] + $job_hours['saturday_morning'] + $job_hours['saturday_night'] + $job_hours['sunday_morning'] + $job_hours['sunday_night'] + $job_hours['ph_morning'] + $job_hours['ph_night'];
            
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

            
                   
            $guard_rates = $payrates = DB::table('award_payrates')->where('id', $result->award_id)->first();
                   
            $day = Carbon::parse($result->temp_start)->format('l');
            if (!empty($payrates)) {
            if (!isset($payrates->ot_base_rate)) {
                $payrates->ot_base_rate = 22.84;
            }
            
                if(config('custom.own_payrates') == 1)
      {
        $payrates->ot_base_rate = 22.84;
        // dd($payrates);
        // Code Change for GSA
                    // Guard payrate here
                        $pay_rate = $payrates->pf_day;
                        $day_rate = $payrates->pf_day;
                        $night_rate = $payrates->pf_night;

                        $sunday_day_rate = $payrates->pf_sun;
                        $sunday_night_rate = $payrates->pf_sun;
                        $saturday_day_rate = $payrates->pf_sat;
                        $saturday_night_rate = $payrates->pf_sat;
                        $ph_day_rate = $payrates->pf_ph;
                        $ph_night_rate = $payrates->pf_ph;
                    

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
                  $breakCal = $this->report->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.25 && $payable_and_chargeable_time <= 0.5) {
                     $breakCal = $this->report->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0.25);
                    $job_hours['morning'] = $breakCal[0];
                    $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.5 && $payable_and_chargeable_time <= 0.75) {
                     $breakCal = $this->report->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.25);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.75 && $payable_and_chargeable_time <= 1) {
                     $breakCal = $this->report->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.5);
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
                  $breakCal = $this->report->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.25 && $payable_and_chargeable_time <= 0.5) {
                     $breakCal = $this->report->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.25, 0.25);
                    $job_hours['morning'] = $breakCal[0];
                    $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.5 && $payable_and_chargeable_time <= 0.75) {
                     $breakCal = $this->report->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.25);
                  $job_hours['morning'] = $breakCal[0];
                  $job_hours['night'] = $breakCal[1];
                }elseif ($payable_and_chargeable_time > 0.75 && $payable_and_chargeable_time <= 1) {
                     $breakCal = $this->report->calculateBreakTiming($job_hours['morning'], $job_hours['night'], 0.5, 0.5);
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
                'ot_base_rate' => $ot_base_rate
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
            array_push( $data, $item);
        }
        return $data;

    }
}
