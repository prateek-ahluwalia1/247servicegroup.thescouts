<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Charged_rate as charged_rate;
use App\Models\Customer as customer;



class Charged_rates extends Controller
{
  
  function changeStatusChargeRate(Request $request)
  {
    if ($request->check == 'unchecked') {
      $status = 0;
    }else{
      $status = 1;
    }
    charged_rate::where('id', $request->id)->update(['archive' => $status]);
    return response()->json(['success' => true]);
  }

  public function charged_rates(Request $request)
  {
    $rate_type = 'Active';
    if ($request->has('type') && $request->type == 'archive') {
      $rate_type = 'Archive';
    $charged_rates = charged_rate::groupBy('title','state')->where('archive', 1)->orderBy('title', 'ASC')->get();
    }else{
    $charged_rates = charged_rate::groupBy('title','state')->where('archive', 0)->orderBy('title', 'ASC')->get();
    }
    $customers = customer::where('status', 'active')->get();
    $divisions = DB::table('division_consolidation')->get();
    foreach ($charged_rates as $charge_rate) {
      $charge_rate->groupData = charged_rate::where('title', $charge_rate->title)->where('archive', 0)->select('state', 'level')->orderBy('title', 'ASC')->get();
    }
    return view('admin/charged_rate/charged_rates', [ 'charged_rates' => $charged_rates , 'customers' => $customers, 'divisions' => $divisions, 'rate_type' => $rate_type]);
  }
  public function create_charged_rate( Request $request){
    $charged_rate=[
      'title'=>$request->title,
      'state'=>$request->charged_rates_state,

      'effective_date'=>$request->effective_date,
      'level'=>$request->job_level,
      'customer_id'=>$request->customer_id,
      'position'=>$request->position,
      'flat_metro_flat_metro_week_day' => $request->flat_metro_week_day,
      'flat_metro_weekend' => $request->flat_metro_weekend,
      'flat_metro_public_holiday' => $request->flat_metro_public_holiday,
      'flat_regional_week_day' => $request->flat_regional_week_day,
      'flat_regional_weekend' => $request->flat_regional_weekend,
      'flat_regional_public_holiday' => $request->flat_regional_public_holiday,
      'eba_metro_weekday_day' => $request->eba_metro_weekday_day,
      'eba_metro_weekday_afternoon' => $request->eba_metro_weekday_afternoon,
      'eba_metro_weekday_night' => $request->eba_metro_weekday_night,
      'eba_metro_weekend' => $request->eba_metro_weekend,
      'eba_metro_public_holiday' => $request->eba_metro_public_holiday,
      'eba_regional_weekday_day' => $request->eba_regional_weekday_day,
      'eba_regional_weekday_afternoon' => $request->eba_regional_weekday_afternoon,
      'eba_regional_weekday_night' => $request->eba_regional_weekday_night,
      'eba_regional_weekend' => $request->eba_regional_weekend,
      'eba_regional_weekend_sun' => $request->eba_regional_weekend_sun,
      'eba_metro_weekend_sun' => $request->eba_metro_weekend_sun,
      'eba_regional_public_holiday' => $request->eba_regional_public_holiday,
      'flat_metro_week_day_day' => $request->flat_metro_week_day_day,
      'flat_regional_week_day_day' => $request->flat_regional_week_day_day,
      'flat_metro_week_day_night' => $request->flat_metro_week_day_night,
      'flat_regional_week_day_night' => $request->flat_regional_week_day_night,
      'flat_metro_friday' => $request->flat_metro_friday,
      'flat_regional_friday' => $request->flat_regional_friday,
      'flat_metro_saturday' => $request->flat_metro_saturday,
      'flat_regional_saturday' => $request->flat_regional_saturday,
      'flat_metro_sunday' => $request->flat_metro_sunday,
      'flat_regional_sunday' => $request->flat_regional_sunday,
      'flat_regional_sunday_night' => $request->flat_regional_sunday_night,
      'flat_metro_sunday_night' => $request->flat_metro_sunday_night,
      'flat_metro_saturday_night' => $request->flat_metro_saturday_night,
      'flat_regional_saturday_night' => $request->flat_regional_saturday_night,
      'flat_metro_public_holiday_night' => $request->flat_metro_public_holiday_night,
      'flat_regional_public_holiday_night' => $request->flat_regional_public_holiday_night,
      'eba_metro_saturday_day' => $request->eba_metro_saturday_day,
      'eba_regional_saturday_day' => $request->eba_regional_saturday_day,
      'eba_metro_saturday_night' => $request->eba_metro_saturday_night,
      'eba_regional_saturday_night' => $request->eba_regional_saturday_night,
      'eba_metro_sunday_day' => $request->eba_metro_sunday_day,
      'eba_regional_sunday_day' => $request->eba_regional_sunday_day,
      'eba_metro_sunday_night' => $request->eba_metro_sunday_night,
      'eba_regional_sunday_night' => $request->eba_regional_sunday_night,
      'eba_metro_public_holiday_night' => $request->eba_metro_public_holiday_night,
      'eba_regional_public_holiday_night' => $request->eba_regional_public_holiday_night,

                    // 'normal_rate' => $request->normal_rate,
                    // 'eba_rate' => $request->eba_rate,
    ];
    $normal_divions = array();
    $eba_divions = array();
    for ($i=0; $i < $request->division_count; $i++) { 
      $normal_divions[$i]['id'] = $request->input('division_normal_id_'.$i);
      $normal_divions[$i]['rate'] = $request->input('division_normal_rate_'.$i);
      $eba_divions[$i]['id'] = $request->input('division_eba_id_'.$i);
      $eba_divions[$i]['rate'] = $request->input('division_eba_rate_'.$i);
    }
    $charged_rate['normal_rate'] = json_encode($normal_divions);
    $charged_rate['eba_rate'] = json_encode($eba_divions);
          // print_r('<pre>');
          // print_r($charged_rate);
          // exit();
    $res= charged_rate::insert($charged_rate);
    if($res){
      return response()->json(array('success' => true));

    }else{
      return response()->json(array('success' => false));

    }
  }

  public function get_charged_rates($id,Request $request)
  {
    if ($id != 0) {
      $charged_rate = charged_rate::where(['id' => $id])->where('archive', 0)->first();
    }else{

      $query = charged_rate::where(['level' => $request->level, 'state' => $request->state, 'position' => $request->position])->where('archive', 0)->orderBy('title', 'ASC');
      if ($request->has('name') && $request->name != '') {
        $query->where('title', $request->name);
      }
      $charged_rate = $query->first();
    }
    if (!empty($charged_rate)) {
      $charged_rate->normal_rate = json_decode($charged_rate->normal_rate, true);
      $charged_rate->eba_rate = json_decode($charged_rate->eba_rate, true);

      $charged_rate->effective_date = date('Y-m-d', strtotime($charged_rate->effective_date));
      return response()->json(['success' => true, 'message' => "charged_rates retrieve", 'charged_rates' => $charged_rate]);
    }else{
      return response()->json(['success' => false, 'message' => "charged_rates fail"]);
    }
  }


  public function update_charged_rates($id,Request $request)
  {
    $charged_rate_id=$id;
    $charged_rate=[
      'title'=>$request->title,
      'state'=>$request->charged_rates_state,

      'effective_date'=>$request->effective_date,

      'customer_id'=>$request->customer_id,
      'position'=>$request->position,
      'level'=>$request->job_level,
      'flat_metro_flat_metro_week_day' => $request->flat_metro_week_day,
      'flat_metro_weekend' => $request->flat_metro_weekend,
      'flat_metro_public_holiday' => $request->flat_metro_public_holiday,
      'flat_regional_week_day' => $request->flat_regional_week_day,
      'flat_regional_weekend' => $request->flat_regional_weekend,
      'flat_regional_public_holiday' => $request->flat_regional_public_holiday,
      'eba_metro_weekday_day' => $request->eba_metro_weekday_day,
      'eba_metro_weekday_afternoon' => $request->eba_metro_weekday_afternoon,
      'eba_metro_weekday_night' => $request->eba_metro_weekday_night,
      'eba_metro_weekend' => $request->eba_metro_weekend,
      'eba_metro_public_holiday' => $request->eba_metro_public_holiday,
      'eba_regional_weekday_day' => $request->eba_regional_weekday_day,
      'eba_regional_weekday_afternoon' => $request->eba_regional_weekday_afternoon,
      'eba_regional_weekday_night' => $request->eba_regional_weekday_night,
      'eba_regional_weekend' => $request->eba_regional_weekend,
      'eba_regional_public_holiday' => $request->eba_regional_public_holiday,
      'eba_regional_weekend_sun' => $request->eba_regional_weekend_sun,
      'eba_metro_weekend_sun' => $request->eba_metro_weekend_sun,

      'flat_metro_week_day_day' => $request->flat_metro_week_day_day,
      'flat_regional_week_day_day' => $request->flat_regional_week_day_day,
      'flat_metro_week_day_night' => $request->flat_metro_week_day_night,
      'flat_regional_week_day_night' => $request->flat_regional_week_day_night,
      'flat_metro_friday' => $request->flat_metro_friday,
      'flat_regional_friday' => $request->flat_regional_friday,
      'flat_metro_saturday' => $request->flat_metro_saturday,
      'flat_regional_saturday' => $request->flat_regional_saturday,
      'flat_metro_sunday' => $request->flat_metro_sunday,
      'flat_regional_sunday' => $request->flat_regional_sunday,
      
      'flat_regional_sunday_night' => $request->flat_regional_sunday_night,
      'flat_metro_sunday_night' => $request->flat_metro_sunday_night,
      'flat_metro_saturday_night' => $request->flat_metro_saturday_night,
      'flat_regional_saturday_night' => $request->flat_regional_saturday_night,
      'flat_metro_public_holiday_night' => $request->flat_metro_public_holiday_night,
      'flat_regional_public_holiday_night' => $request->flat_regional_public_holiday_night,

      'eba_metro_saturday_day' => $request->eba_metro_saturday_day,
      'eba_regional_saturday_day' => $request->eba_regional_saturday_day,
      'eba_metro_saturday_night' => $request->eba_metro_saturday_night,
      'eba_regional_saturday_night' => $request->eba_regional_saturday_night,
      'eba_metro_sunday_day' => $request->eba_metro_sunday_day,
      'eba_regional_sunday_day' => $request->eba_regional_sunday_day,
      'eba_metro_sunday_night' => $request->eba_metro_sunday_night,
      'eba_regional_sunday_night' => $request->eba_regional_sunday_night,
      'eba_metro_public_holiday_night' => $request->eba_metro_public_holiday_night,
      'eba_regional_public_holiday_night' => $request->eba_regional_public_holiday_night,
                    // 'normal_rate' => $request->normal_rate,
                    // 'eba_rate' => $request->eba_rate,
    ];
    $normal_divions = array();
    $eba_divions = array();
    for ($i=0; $i < $request->division_count; $i++) { 
      $normal_divions[$i]['id'] = $request->input('division_normal_id_'.$i);
      $normal_divions[$i]['rate'] = $request->input('division_normal_rate_'.$i);
      $eba_divions[$i]['id'] = $request->input('division_eba_id_'.$i);
      $eba_divions[$i]['rate'] = $request->input('division_eba_rate_'.$i);
    }
    $charged_rate['normal_rate'] = json_encode($normal_divions);
    $charged_rate['eba_rate'] = json_encode($eba_divions);
    $charge_rate = charged_rate::where(['level' => $request->job_level, 'state'=>$request->charged_rates_state, 'title' => $request->title])->where('archive', 0)->first();
    if (!empty($charge_rate)) {
      $res= charged_rate::where('id', $charge_rate->id)->update($charged_rate);
      if ($res) {

        $this->logChargeRate($charge_rate, $charged_rate_id, $request->effective_date);
      }
    }else{
      $res= charged_rate::insert($charged_rate);
    }
    if($res){
      return response()->json(array('success' => true));

    }else{
      return response()->json(array('success' => false));
    }
  }


  function logChargeRate($charge_rate, $charged_rate_id, $effective_date_to)

  {
    DB::table('chargerate_history')->insert([
      'chargerate_id' => $charged_rate_id,
      'data' => json_encode($charge_rate),
      'changed_by' => session()->get('userId'),
      'effective_from' => $charge_rate->effective_date,
      'effective_to' => $effective_date_to,
    ]);
  }
  
  public function delete_charged_rate($id){
    $res= charged_rate::where('id',$id)->delete();
    if($res){
      return response()->json(array('success' => true));

    }else{
      return response()->json(array('success' => false));

    } 

  }





}
