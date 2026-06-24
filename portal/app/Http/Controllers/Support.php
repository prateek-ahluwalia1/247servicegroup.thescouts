<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrator as admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Support extends Controller
{
 public function login(){
    if (!session()->has('userType')) {
        return view('admin/support/login');
    }else{
        // return redirect('customer_profile'. '/' .session::get('userId'));
    }
}

public function support_login(Request $request)
{
    if (!$request->has('password') || !$request->has('email') || !$request->has('otp')) {
      return redirect('/support')->withErrors('Invalid Login Details');
  }
  if ($request->password == '' || $request->email == '' || $request->otp == '') {
      return redirect('/support')->withErrors('Invalid Login Details');
  }
  if ($request->email != 'moiz@gmail.com') {
       return redirect('/support')->withErrors('Invalid Login Details');
  }
  $apikey = base64_encode(Str::random(64).time());
  $admin = admin::leftJoin('acces_level_defination', 'acces_level_defination.id', '=', 'administrators.access_level_id')
  ->where(['email' => $request->input('email')])->select('administrators.*', 'acces_level_defination.permissions')
  ->first();
  $authentication_code = DB::table('authentication_code')->where('authentication_code', $request->otp)->first();
  if (empty($authentication_code)) {
      return redirect('/support')->withErrors('Invalid Login Details');
  }
  if (empty($admin)) {
      return redirect('/support')->withErrors('Invalid Login Details');
  }
  if (Hash::check($request->input('password'), $admin->password) && $admin->status == 'active') {
      if ($admin->permissions != '') {
        $admin->permissions = json_decode($admin->permissions, true);
    }else{
        $admin->permissions = array();
    }
    $colors = '';
    $colr = DB::table('portal_settings')->where('permission_name', 'portal_colors')->first();
    if (!empty($colr)) {
        $colors = $colr->users_emails;
    }
    admin::where('id', $admin->id)->update(['auth_token' => $apikey,'last_login'=>date("Y-m-d H:i:s")]);
    $config_recods = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id'  , config('custom.domain_id'))->where('type' , 'navigation_bar')->get();
       // dd($config_recods);

    $config_arr = [];
    foreach($config_recods as $data){
       $value = json_decode($data->records_business_navbar);
       array_push($config_arr , $value);
   }
   session([
    'userId' => $admin->id,
    'userType' => 'admin', 
    'image' => $admin->image,
    'config_recods' => $config_arr,   
    'userName' => $admin->name,  
    'userEmail' => $admin->email,  
    'authToken' => $apikey,
    'isAdmin' => $admin->is_super_admin,
    'state' => $admin->state, 
    'multiple_states' => $admin->multiple_states, 
    'permissions' =>  json_encode($admin->permissions), 
    'specific_customer' => $admin->specific_customer,
    'specific_sites' => $admin->specific_sites,
    'colors' => $colors,
    'is_support' => $admin->name
]);
   return redirect('/')->withErrors('Invalid Login Details');

}else{
    return redirect('/support')->withErrors('Invalid Login Details');
}

}

}
