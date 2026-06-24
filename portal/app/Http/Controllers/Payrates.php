<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Customer as customer;
use App\Models\Payrate as payrate;


class Payrates extends Controller
{


  function changeStatusPayRate(Request $request)
  {
    if ($request->check == 'unchecked') {
      $status = 0;
    }else{
      $status = 1;
    }
    payrate::where('id', $request->id)->update(['archive' => $status]);
    return response()->json(['success' => true]);
  }

  public function payrates(Request $request)
  {
    $rate_type = 'Active';
    if ($request->has('type') && $request->type == 'archive') {
      $rate_type = 'Archive';
      $payrates = payrate::groupBy('title','state')->where('archive', 1)->orderBy('title', 'ASC')->get();
    }else{
      $payrates = payrate::groupBy('title','state')->where('archive', 0)->orderBy('title', 'ASC')->get();
    }
    $customers = customer::where('status', 'active')->get();
    foreach ($payrates as $key => $payrate) {
      $payrate->groupData = payrate::where('title', $payrate->title)->where('archive', 0)->orderBy('title', 'ASC')->select('state', 'level')->get();
    }
    if (config('custom.categorized_payrates') == 1) {
      return view('admin/payrate/categorized_payrates', [ 'payrates' => $payrates, 'customers' => $customers, 'rate_type' => $rate_type]);
    }else{
      return view('admin/payrate/payrates', [ 'payrates' => $payrates, 'customers' => $customers, 'rate_type' => $rate_type]);
    }
  }

  public function create_payrate( Request $request){
    if($request->has('payrate_id') && $request->payrate_id!=null ){
      return redirect('update_payrates/'.$request->payrate_id);
        // $this->update_payrates($request->payrate_id,$request);
        // exit();
    }else{

      $payrate=[
        'title'=>$request->title,
            // 'effective_date'=>$request->effective_date,
        'state'=>$request->payrates_state,
        'position' => $request->position,
        'customer_id' => $request->customer_id,
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
        'ot_base_rate' => $request->ot_base_rate,

      ];
      $check = payrate::where(['level' => $request->job_level, 'state'=>$request->payrates_state, 'title' => $request->title])->where('archive', 0)->first();
      if (!empty($check)) {
        $res = payrate::where('id', $check->id)->update($payrate);
      }else{
        $res= payrate::insert($payrate);
      }
      if($res){
        return response()->json(array('success' => true));

      }else{
        return response()->json(array('success' => false));

      }
    }
  }

  public function get_payrates($id,Request $request)
  {
    // $payrate = payrate::where(['id' => $id])->first();
    // if (!empty($payrate)) {
    //     return response()->json(['success' => true, 'message' => "Payrates retrieve", 'payrates' => $payrate]);
    // }else{
    //     return response()->json(['success' => false, 'message' => "Payrates fail"]);
    // }
    $archive = 0;
    if ($request->has('rate_type') && $request->rate_type == 'Archive') {
      $archive = 1;
    }
    if ($id != 0) {
      $payrate = payrate::where(['id' => $id])->where('archive', $archive)->first();
    }else{
      $query = payrate::where(['level' => $request->level, 'state' => $request->state, 'position' => $request->position])->where('archive', $archive)->orderBy('title', 'ASC');
      if ($request->has('name') && $request->name != '') {
        $query->where('title', $request->name);
      }
      $payrate  = $query->first();

    }
    if (!empty($payrate)) {
      $payrate->effective_date = date('Y-m-d', time());

      return response()->json(['success' => true, 'message' => "payrate retrieve", 'payrates' => $payrate]);
    }else{
      return response()->json(['success' => false, 'message' => "payrate fail"]);
    }

  }


  public function update_payrates($id,Request $request)
  {

    $payrate_id=$id;
    $payrate=[
      'title'=>$request->title,
      // 'effective_date'=>$request->effective_date,
      'state'=>$request->payrates_state,
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
      'ot_base_rate' => $request->ot_base_rate,
    ];
            //      $res= payrate::where('id',$payrate_id)->update($payrate);
            //      if($res){
            //   return response()->json(array('success' => true));

            // }else{
            //   return response()->json(array('success' => false));

            // }

    $payrate_check = payrate::where(['level' => $request->job_level, 'state'=>$request->payrates_state, 'title' => $request->title])->where('archive', 0)->first();
    if (!empty($payrate_check)) {
      $res= payrate::where('id',$payrate_check->id)->update($payrate);
      if ($res) {
        $this->logPayRate($payrate_check, $payrate_check->id, time());
      }
    }else{
      $res= payrate::insert($payrate);
    }
    if($res){
      return response()->json(array('success' => true));

    }else{
      return response()->json(array('success' => false));
    }
  }

  public function delete_payrate($id){
    $res= payrate::where('id',$id)->delete();
    if($res){
      return response()->json(array('success' => true));
    }else{
      return response()->json(array('success' => false));
    } 
  }

  function logPayRate($pay_rate, $pay_rate_id, $effective_date_to)

  {
    DB::table('payrates_history')->insert([
      'payrate_id' => $pay_rate_id,
      'data' => json_encode($pay_rate),
      'changed_by' => session()->get('userId'),
      'effective_from' => $pay_rate->effective_date,
      'effective_to' => $effective_date_to,
    ]);
  }

  function save_guard_own_payrates(Request $request)
  {
    $data = request()->all();
    unset($data['_token']);
    unset($data['guard_id']);
    if ($request->has('pay_by') && $request->pay_by == 'award') {
      $is = DB::table('guards')->where('id', $request->guard_id)->update([
        'pay_by' => $request->pay_by,
        'award_rate_level' => $request->award_rate_level,
        'award_rate_apply_from' => $request->award_rate_apply_from,
        'award_rate_apply_to' => $request->award_rate_apply_to
      ]);
      if ($is) {
        return response()->json(['success' => true, 'message' => 'Payrate save successfully.']);
      }
      return response()->json(['success' => false, 'message' => 'Fail to save payrate!']);
    }else{
      $is_already_have_payrate = DB::table('guard_payrates')->where('guard_id', $request->guard_id)->first();
      $is = DB::table('guards')->where('id', $request->guard_id)->update([
        'pay_by' => $request->pay_by,
      ]);

      if (!empty($is_already_have_payrate)) {
        $is = DB::table('guard_payrates')->where('guard_id', $request->guard_id)->update([
          'payrate' => json_encode($data)]);
      }else{
       $is = DB::table('guard_payrates')->insert([
        'payrate' => json_encode($data),
        'guard_id' => $request->guard_id
      ]);
     }
     if ($is) {
      return response()->json(['success' => true, 'message' => 'Payrate save successfully.']);
    }
    return response()->json(['success' => false, 'message' => 'Fail to save payrate!']);
  }
}

function save_guard_own_payrates_new(Request $request)
  {
      $is = DB::table('guards')->where('id', $request->guard_id)->update([
        'pay_by' => $request->pay_by,
        'abn_id' => $request->abn_id,
        'eba_id' => $request->eba_id,
        'award_id' => $request->award_id
      ]);
      if ($is) {
        return response()->json(['success' => true, 'message' => 'Payrate save successfully.']);
      }
      return response()->json(['success' => false, 'message' => 'Fail to save payrate!']);
    
}

public function create_payrate_customized( Request $request){
  if($request->has('payrate_id') && $request->payrate_id!=null ){
    return redirect('update_payrates/'.$request->payrate_id);
        // $this->update_payrates($request->payrate_id,$request);
        // exit();
  }else{

    $payrate=[
      'title'=>$request->title,
      'state'=>$request->payrates_state,
      'position' => $request->position,
      'customer_id' => $request->customer_id,
      'level'=>$request->job_level,
      'payrate_type' => $request->has('payrate_type') ? $request->payrate_type : 'default',
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

      'flat_regional_sunday_night' => $request->flat_regional_sunday,
      'flat_metro_sunday_night' => $request->flat_metro_sunday,
      'flat_metro_saturday_night' => $request->flat_metro_saturday,
      'flat_regional_saturday_night' => $request->flat_regional_saturday,
      'flat_metro_public_holiday_night' => $request->flat_metro_public_holiday,
      'flat_regional_public_holiday_night' => $request->flat_regional_public_holiday,

      'eba_metro_saturday_day' => $request->eba_metro_saturday_day,
      'eba_regional_saturday_day' => $request->eba_regional_saturday_day,
      'eba_metro_saturday_night' => $request->eba_metro_saturday_day,
      'eba_regional_saturday_night' => $request->eba_regional_saturday_day,
      'eba_metro_sunday_day' => $request->eba_metro_sunday_day,
      'eba_regional_sunday_day' => $request->eba_regional_sunday_day,
      'eba_metro_sunday_night' => $request->eba_metro_sunday_day,
      'eba_regional_sunday_night' => $request->eba_regional_sunday_day,
      'eba_metro_public_holiday_night' => $request->eba_metro_public_holiday,
      'eba_regional_public_holiday_night' => $request->eba_regional_public_holiday,
      'ot_base_rate' => $request->ot_base_rate,

    ];
    $check = payrate::where(['level' => $request->job_level, 'state'=>$request->payrates_state, 'title' => $request->title])->where('archive', 0)->first();
    if (!empty($check)) {
      $res = payrate::where('id', $check->id)->update($payrate);
    }else{
      $res= payrate::insert($payrate);
    }
    if($res){
      return response()->json(array('success' => true));

    }else{
      return response()->json(array('success' => false));

    }
  }
}

public function payrates_new(Request $request)
  {
    $payrates = payrate::groupBy('title','state')->where('payrate_type', $request->type)->orderBy('title', 'ASC')->get();
    $customers = customer::where('status', 'active')->get();
    foreach ($payrates as $key => $payrate) {
      $payrate->groupData = payrate::where('title', $payrate->title)->where('payrate_type', $request->type)->orderBy('title', 'ASC')->select('state', 'level')->get();
    }
      return view('admin/payrate/payrates_new', [ 'payrates' => $payrates, 'customers' => $customers, 'rate_type' => $request->type]);
  }

  public function create_payrate_new( Request $request){
  if($request->has('payrate_id') && $request->payrate_id!=null ){
    return redirect('update_payrates/'.$request->payrate_id);
        // $this->update_payrates($request->payrate_id,$request);
        // exit();
  }else{

    $payrate=[
      'title'=>$request->title,
      'state'=>$request->payrates_state,
      'position' => $request->position,
      'customer_id' => $request->customer_id,
      'level'=>$request->job_level,
      'payrate_type' => $request->has('payrate_type') ? $request->payrate_type : 'default',
      'flat_metro_flat_metro_week_day' => $request->flat_metro_week_day,
      'flat_metro_weekend' => $request->flat_metro_weekend,
      'flat_regional_week_day' => $request->flat_regional_week_day,
      'flat_regional_weekend' => $request->flat_regional_weekend,
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
      // used only
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
      'flat_metro_public_holiday' => $request->flat_metro_public_holiday,
      'flat_regional_public_holiday' => $request->flat_regional_public_holiday,
      // used only

      'flat_regional_sunday_night' => $request->flat_regional_sunday,
      'flat_metro_sunday_night' => $request->flat_metro_sunday,
      'flat_metro_saturday_night' => $request->flat_metro_saturday,
      'flat_regional_saturday_night' => $request->flat_regional_saturday,
      'flat_metro_public_holiday_night' => $request->flat_metro_public_holiday,
      'flat_regional_public_holiday_night' => $request->flat_regional_public_holiday,

      'eba_metro_saturday_day' => $request->eba_metro_saturday_day,
      'eba_regional_saturday_day' => $request->eba_regional_saturday_day,
      'eba_metro_saturday_night' => $request->eba_metro_saturday_day,
      'eba_regional_saturday_night' => $request->eba_regional_saturday_day,
      'eba_metro_sunday_day' => $request->eba_metro_sunday_day,
      'eba_regional_sunday_day' => $request->eba_regional_sunday_day,
      'eba_metro_sunday_night' => $request->eba_metro_sunday_day,
      'eba_regional_sunday_night' => $request->eba_regional_sunday_day,
      'eba_metro_public_holiday_night' => $request->eba_metro_public_holiday,
      'eba_regional_public_holiday_night' => $request->eba_regional_public_holiday,
      'ot_base_rate' => $request->ot_base_rate,

    ];
    // print_r($payrate);
    // exit;
    $check = payrate::where(['level' => $request->job_level, 'state'=>$request->payrates_state, 'title' => $request->title])->where('archive', 0)->first();
    if (!empty($check)) {
      $res = payrate::where('id', $check->id)->update($payrate);
    }else{
      $res= payrate::insert($payrate);
    }
    if($res){
      return response()->json(array('success' => true));

    }else{
      return response()->json(array('success' => false));

    }
  }
}

public function getTypePayrate(Request $request)
  {
   
      $query = payrate::where(['payrate_type' => $request->type])->orderBy('title', 'ASC');
      $payrate  = $query->get();

    if (!empty($payrate)) {
      return response()->json(['success' => true, 'message' => "payrate retrieve", 'rates' => $payrate]);
    }else{
      return response()->json(['success' => false, 'message' => "payrate fail"]);
    }

  }

}
