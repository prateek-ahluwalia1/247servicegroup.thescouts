<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Administrator as admin;
use App\Models\Guard as guard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Query\JoinClause;
use Codedge\Fpdf\Fpdf\Fpdf;
use \PDF;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use File;
use PragmaRX\Google2FAQRCode\Google2FA;

class Administrator extends Controller
{
  public $currentUser;
  private $fpdf;
  public $guard_model;
  protected $timezone = array(
    'Victoria' => 'Australia/Melbourne',
    'New South Whales' => 'Australia/Sydney',
    'Queensland' => 'Australia/Brisbane',
    'Tasmania' => 'Australia/Hobart',
    'Western Australia' => 'Australia/Perth',
    'South Australia' => 'Australia/Adelaide',
    'ACT' => 'Australia/Canberra'
  );
  public function __construct(guard $guard_model)
  {
    $this->guard_model = $guard_model;
  }

  public function showImage($slug)
  {
    $public_path = public_path();
    $public_path = str_replace('portal/public', '', $public_path);
    $public_path = str_replace('apis/public', '', $public_path);
    $destinationPath = $public_path.'asset_uploads/';
    $image = File::get($destinationPath . $slug);
    return response()->make($image, 200, ['content-type' => 'image/jpg']);
  }

  public function dashboard(){

    return view('admin/dashboard');


  }
  public function export() 
  {
    return Excel::download(new UsersExport, 'users.xlsx');
  }

  public function update_admin_email_permissions(Request $request)
  {
    $permissions = ['document_expiry', 'job_rejection', 'green_call_miss', 'admin_update_shift'];
    foreach ($permissions as $key => $permission) {
      $emails = '';
      if ($request->input($permission.'_admin_emails') != '') {
        $emails = $request->input($permission.'_admin_emails');
        $emails = str_replace('[{', '', $emails);
        $emails = str_replace('}]', '', $emails);
        $emails = str_replace('"', '', $emails);
        $emails = str_replace('value:', '', $emails);
        $emails = str_replace('{', '', $emails);
        $emails = str_replace('},', ', ', $emails);
        $emails = str_replace('}', ', ', $emails);
      }
      if ($request->has($permission)) {
        $already = DB::table('portal_settings')->where('permission_name', $permission)->first();
        if (empty($already)) {
          $save = DB::table('portal_settings')->insert(['permission_name' => $permission,'permission' => 1, 'users_emails' => $emails]);
        }else{
          $save = DB::table('portal_settings')->where('permission_name', $permission)->update(['permission' => 1, 'users_emails' => $emails]);
        }
      }else{
        $save = DB::table('portal_settings')->where('permission_name', $permission)->update(['permission' => 0]);
      }
    }
    return response()->json(['success' => true]);
  }

  public function update_guard_email_permissions(Request $request)
  {
    $permissions = ['signup', 'profile_update', 'incident_report', 'publish_shift', 'update_shift', 'delete_shift'];
    foreach ($permissions as $key => $permission) {
      $emails = '';

      if ($request->has($permission)) {
        $already = DB::table('portal_settings')->where('permission_name', $permission)->first();
        if (empty($already)) {
          $save = DB::table('portal_settings')->insert(['permission_name' => $permission,'permission' => 1, 'users_emails' => $emails]);
        }else{
          $save = DB::table('portal_settings')->where('permission_name', $permission)->update(['permission' => 1, 'users_emails' => $emails]);
        }
      }else{
        $save = DB::table('portal_settings')->where('permission_name', $permission)->update(['permission' => 0]);
      }
    }
    return response()->json(['success' => true]);
  }

  public function createPDF()
  {
    $this->fpdf = new Fpdf;
    $this->fpdf->AddPage("L", ['100', '100']);
    $this->fpdf->Text(10, 10, "Hello FPDF");       

    $this->fpdf->Output();
    exit;
  }

  public function downloadpdf()
  {
        // $pdf = PDF::loadView('admin/sample');
        // return $pdf->download('admin/sample.pdf');
  }


  public function admin_pdf(Request $request){
    $role_id = $request->role;
    if($role_id == "all"){
     $admins = DB::table('administrators')->where('status', 'active')->get();
   }else{
     $admins = DB::table('administrators')->where('access_level_id', $role_id)->get();
   }
   View::make('admin/admin/admin_pdf', ['admins' => $admins]);
    // exit();
   $pdf = PDF::loadView('admin/admin/admin_pdf', ['admins' => $admins]);
   return $pdf->download('admins-list.pdf');
 }
 public function index()
 {
  if (!session()->has('userType') || session::get('userType') != 'admin') {
    return view('admin/login');
  }else{
    return redirect('/dashboard');
  }
}
private function encryptPassword($password) {

  return password_hash($password, CRYPT_SHA512);
}

public function do_login(Request $request)
{
  $google2fa = new Google2FA();
        // $password = $this->encryptPassword($request->input('password'));
  if (!$request->has('password') || !$request->has('email')) {
    return redirect('/')->with('msg', 'Invalid Login Details');
  }
  if ($request->password == '' || $request->email == '') {
    return redirect('/')->with('msg', 'Invalid Login Details');
  }
  if(config('custom.authenticator') == 1){
  $qr = DB::table('google2fa_secret')->first();
  if (!$google2fa->verify($request->input('otp'), $qr->google2fa_secret)) {
    return redirect('/')->with('msg', 'Invalid OTP!');
  }
  }


  $apikey = base64_encode(Str::random(64).time());
  $admin = admin::leftJoin('acces_level_defination', 'acces_level_defination.id', '=', 'administrators.access_level_id')
  ->where(['email' => $request->input('email')])->select('administrators.*', 'acces_level_defination.permissions')
  ->first();
  if (empty($admin)) {
    return redirect('/')->with('msg', 'Invalid Login Details');
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
    Session::forget('config_arr');
    $config_arr = [];
    foreach($config_recods as $data){
      $value = json_decode($data->records_business_navbar);
      array_push($config_arr , $value);
    }
    session([
      'userId' => $admin->id,
      'userType' => 'admin', 
      'config_recods' => $config_arr, 
      'image' => $admin->image,  
      'userName' => $admin->name,
      'userEmail' => $admin->email,  
      'authToken' => $apikey,
      'isAdmin' => $admin->is_super_admin,
      'state' => $admin->state, 
      'multiple_states' => $admin->multiple_states, 
      'permissions' =>  json_encode($admin->permissions), 
      'specific_customer' => $admin->specific_customer,
      'specific_sites' => $admin->specific_sites,
      'colors' => $colors
    ]);
      // dd($config_arr);
    return redirect('/')->with('msg', 'Invalid Login Details');

  }else{
    return redirect('/')->with('msg', 'Invalid Login Details');
  }

        // dd($request->session());
}
public function access()
{

 if (!session()->has('userType')) {
  return view('admin/login');


}else{

  $roles = DB::table('acces_level_defination')->get();
  $customers = DB::table('customers')->where('status' , 'active')->get();
            // print_r($roles[0]->title);
  return view('admin/access',['roles' => $roles, 'customers' => $customers]);
}


}
public function change_password(Request $request){

  $password=$request->password;
  $confirm=$request->confirm_password;
  if($password==$confirm)
  {
    $apikey = base64_encode(Str::random(64).time());

    $password= Hash::make($request->password);
    $id=$request->id;
    $apikey = base64_encode(Str::random(64).time());
    $res= DB::table('administrators')->where(['id' => $id])->update(['password'=>$password,'auth_token'=>$apikey]);
    return response()->json(array('success' => true,'message'=>'Password Changed Succesfully'));

  }
  else{
    return response()->json(array('success' => false,'message'=>'Password Not Matched'));

  }


}
public function administrators(){
  if (!session()->has('userType')) {
    return view('admin/login');
  }else{
            // $admins = admin::get();
    $admins = DB::table('administrators')
    ->join('acces_level_defination','acces_level_defination.id','=','administrators.access_level_id')
    ->select('administrators.*','acces_level_defination.id as access_id','acces_level_defination.title as role_name')
    ->where('status','!=' ,'deleted')
    ->where('hide_status','=' ,'0')
    ->orderBy('administrators.name', 'ASC')->get();

    $roles= DB::table('acces_level_defination')->select('id','title')->get();
    $customers = DB::table('customers')->where('status' , 'active')->get();
    return view('admin/administrators', ['admins' => $admins, 'roles' => $roles, 'customers' => $customers]);
  }
}

function changeAdminStatus(Request $request)
{
  $status = $request->check;
  $id = $request->id;
  DB::table('administrators')->where('id', $id)->update(['status' => $status]);
  return response()->json(['success' => true]);
}

public function insert(Request $request){
  $filename='';
  if($request->file('avatar')!='' && $request->file('avatar')!=null){

    $image = $request->file('avatar');

    $filename = time().'.'.$image->getClientOriginalExtension();
        // $destinationPath = '../../asset_uploads/';
    $public_path = public_path();
    $public_path = str_replace('portal/public', '', $public_path);
    $public_path = str_replace('apis/public', '', $public_path);
    $destinationPath = $public_path.'asset_uploads/';
    $save= $image->move($destinationPath, $filename);

  }   
  $password = Hash::make('1234568');

  $name=  $_POST['user_name'];
  $email=  $_POST['user_email'];
                // $access =$_POST['user_role'];
  $access_id = isset($_POST['user_role']) && $_POST['user_role'] != '' ? $_POST['user_role'] : '';
  $multiple_states = [];
  if($request->has('multiple_states')){
    $multiple_states = $request->multiple_states;
  }
  $state=$request->state;
  $already = DB::table('administrators')->where('email', $email)->first();
  if (!empty($already)) {
    return redirect('/administrators')->with('msg', 'Admin with this email already exists!');
  }

  $query =DB::table('administrators')->insert([
    'email' => $email,
    'name' => $name,
    'password' => $password,
    'multiple_states' => json_encode($multiple_states),
    'state' => $state,
     // 'access_level' => $access,
    'access_level_id' => $access_id,
    'image'=> $filename,
    'status'=> $request->status,

  ]);

  if($query==true)
  {
    return redirect('/administrators')->with('msg', 'Record Added');

       // $res= admin::insert($name,$email);
  }else{

    return redirect('404');

  }
}

public function insertAccess(Request $request){
  $role_name=$_POST['role_name'];
  $specific_customer = $request->customer_selection;
  if (is_array($specific_customer) && !empty($specific_customer)) {
    $specific_customer = json_encode($specific_customer);
  }else{
    $specific_customer = json_encode(array());
  }
    // if ($request->has('sites') && !empty($request->sites)) {
    //   $sites = json_encode($request->sites);
    // }else{
    //   $sites = json_encode(array());
    // }
    //not completed

  $data['dashboard'] =  true;
  $data['job_roster'] = (isset($_POST['job_roster']) && $_POST['job_roster'] == 'on') ? true : false;
  $data['add_site'] = (isset($_POST['add_site']) && $_POST['add_site'] == 'on') ? true : false;
  $data['adhoc_shift'] = (isset($_POST['adhoc_shift']) && $_POST['adhoc_shift'] == 'on') ? true : false;
  $data['roster_report'] = (isset($_POST['roster_report']) && $_POST['roster_report'] == 'on') ? true : false;
  $data['roster_action'] = (isset($_POST['roster_action']) && $_POST['roster_action'] == 'on') ? true : false;
  $data['view_by_guard'] = (isset($_POST['view_by_guard']) && $_POST['view_by_guard'] == 'on') ? true : false;
  $data['roster_shifts'] = (isset($_POST['roster_shifts']) && $_POST['roster_shifts'] == 'on') ? true : false;
  $data['site_edit'] = (isset($_POST['site_edit']) && $_POST['site_edit'] == 'on') ? true : false;
  $data['site_delete'] = (isset($_POST['site_delete']) && $_POST['site_delete'] == 'on') ? true : false;

  $data['timesheet'] = (isset($_POST['timesheet']) && $_POST['timesheet'] == 'on') ? true : false;
  $data['leave_management'] = (isset($_POST['leave_management']) && $_POST['leave_management'] == 'on') ? true : false;
  $data['time_clock'] = (isset($_POST['time_clock']) && $_POST['time_clock'] == 'on') ? true : false;
  $data['job_tracker'] = (isset($_POST['job_tracker']) && $_POST['job_tracker'] == 'on') ? true : false;
  $data['job_tracker_approval'] = (isset($_POST['job_tracker_approval']) && $_POST['job_tracker_approval'] == 'on') ? true : false;
  $data['administrator'] = (isset($_POST['administrator']) && $_POST['administrator'] == 'on') ? true : false;
  $data['guard'] = (isset($_POST['guard']) && $_POST['guard'] == 'on') ? true : false;
  $data['customer'] = (isset($_POST['customer']) && $_POST['customer'] == 'on') ? true : false;
  $data['contractor'] = (isset($_POST['contractor']) && $_POST['contractor'] == 'on') ? true : false;
  $data['reports'] = (isset($_POST['reports']) && $_POST['reports'] == 'on') ? true : false;
  $data['guard_report'] = (isset($_POST['guard_report']) && $_POST['guard_report'] == 'on') ? true : false;
  $data['customer_report'] = (isset($_POST['customer_report']) && $_POST['customer_report'] == 'on') ? true : false;
  $data['contractor_report'] = (isset($_POST['contractor_report']) && $_POST['contractor_report'] == 'on') ? true : false;
  $data['green_and_welfare_report'] = (isset($_POST['green_and_welfare_report']) && $_POST['green_and_welfare_report'] == 'on') ? true : false;
  $data['task_report'] = (isset($_POST['task_report']) && $_POST['task_report'] == 'on') ? true : false;
  $data['paysheet_report'] = (isset($_POST['paysheet_report']) && $_POST['paysheet_report'] == 'on') ? true : false;
  $data['incident_report'] = (isset($_POST['incident_report']) && $_POST['incident_report'] == 'on') ? true : false;
  $data['invoice_report'] = (isset($_POST['invoice_report']) && $_POST['invoice_report'] == 'on') ? true : false;
  $data['hour_report'] = (isset($_POST['hour_report']) && $_POST['hour_report'] == 'on') ? true : false;
  $data['complete_report'] = (isset($_POST['complete_report']) && $_POST['complete_report'] == 'on') ? true : false;
  $data['staff_audit'] = (isset($_POST['staff_audit']) && $_POST['staff_audit'] == 'on') ? true : false;
  $data['communication'] = (isset($_POST['communication']) && $_POST['communication'] == 'on') ? true : false;
  $data['tutorial'] = (isset($_POST['tutorial']) && $_POST['tutorial'] == 'on') ? true : false;
  $data['announcements'] = (isset($_POST['announcements']) && $_POST['announcements'] == 'on') ? true : false;
  $data['rosterControl'] = (isset($_POST['rosterControl']) && $_POST['rosterControl'] == 'on') ? true : false;
  $data['charge_rates'] = (isset($_POST['charge_rates']) && $_POST['charge_rates'] == 'on') ? true : false;
  $data['pay_rates'] = (isset($_POST['pay_rates']) && $_POST['pay_rates'] == 'on') ? true : false;
  $data['app_settings'] = (isset($_POST['app_settings']) && $_POST['app_settings'] == 'on') ? true : false;
  $data['break_bypass'] = (isset($_POST['break_bypass']) && $_POST['break_bypass'] == 'on') ? true : false;
  $data['lock_roster'] = (isset($_POST['lock_roster']) && $_POST['lock_roster'] == 'on') ? true : false;
  $data['16_hour_limit'] = (isset($_POST['16_hour_limit']) && $_POST['16_hour_limit'] == 'on') ? true : false;
  $data['mock_guard'] = (isset($_POST['mock_guard']) && $_POST['mock_guard'] == 'on') ? true : false;
  $data['division_consolidation'] = (isset($_POST['division_consolidation']) && $_POST['division_consolidation'] == 'on') ? true : false;
  $data['about_us'] = (isset($_POST['about_us']) && $_POST['about_us'] == 'on') ? true : false;
  $data['audit_report'] = (isset($_POST['audit_report']) && $_POST['audit_report'] == 'on') ? true : false;

    // $data['sites'] = $sites;
  foreach ($data as $key => $value) {
   if ($value == '') {
    $data[$key] = false;
  }else{
    $data[$key] = true;

  }
}
foreach ($data as $key => $value) {
 $data[$key.'_full_access'] = isset($_POST[$key.'_full_access']) ? $_POST[$key.'_full_access'] : 'view_only' ;
}
$dat['permissions'] = json_encode($data);
          $created_by=Session::get('userId');             // Get session variable
// Get session variable


     //json_encode($data);

     // $dat['title'] = $_POST('access_level_title');
     // $dat['created_by'] = $this->session->userdata('userId');

   //  $isEdit = $_POST('is_edit');
     // if ($isEdit == true) {
     //  $result = $this->db->update('acces_level_defination', $dat, array('id' => $_POST('id')));

     //  }
    //   else{
    //  $result = $this->db->insert('acces_level_defination', $dat);
    // }
          // print_r('<pre>'); 
     // print_r($_POST['dashboard']);
     // exit();
// 'sites' => $sites
          $result = DB::table('acces_level_defination')->insertGetId(['title'=> $role_name, 'specific_customer' =>  $specific_customer , 'permissions' =>$dat['permissions'], 'created_by' => $created_by]);
          if ($result) {
            $data = DB::table('acces_level_defination')->where('id', $result)->first();
            $action = 'access_added';
            $this->log_user_activity($action,$data);
            return redirect('/access')->with('msg', 'Record Added');
          }else{
              // echo json_encode(array('success' => false));

            return redirect('/access')->with('msg', 'Something went wrong');

          }


        }




        public function editAccess($id,Request $request){
          $role_name = $_POST['role_name'];
          $specific_customer = $request->customer_selection;
          if (is_array($specific_customer) && !empty($specific_customer)) {
            $specific_customer = json_encode($specific_customer);
          }else{
            $specific_customer = json_encode(array());
          }
    // if ($request->has('sites') && !empty($request->sites)) {
    //   $sites = json_encode($request->sites);
    // }else{
    //   $sites = json_encode(array());
    // }
    //not completed

          $data['dashboard'] = true;
          $data['job_roster'] = (isset($_POST['job_roster']) && $_POST['job_roster'] == 'on') ? true : false;
          $data['add_site'] = (isset($_POST['add_site']) && $_POST['add_site'] == 'on') ? true : false;
          $data['adhoc_shift'] = (isset($_POST['adhoc_shift']) && $_POST['adhoc_shift'] == 'on') ? true : false;
          $data['roster_report'] = (isset($_POST['roster_report']) && $_POST['roster_report'] == 'on') ? true : false;
          $data['roster_action'] = (isset($_POST['roster_action']) && $_POST['roster_action'] == 'on') ? true : false;
          $data['view_by_guard'] = (isset($_POST['view_by_guard']) && $_POST['view_by_guard'] == 'on') ? true : false;
          $data['roster_shifts'] = (isset($_POST['roster_shifts']) && $_POST['roster_shifts'] == 'on') ? true : false;
          $data['site_edit'] = (isset($_POST['site_edit']) && $_POST['site_edit'] == 'on') ? true : false;
          $data['site_delete'] = (isset($_POST['site_delete']) && $_POST['site_delete'] == 'on') ? true : false;

          $data['timesheet'] = (isset($_POST['timesheet']) && $_POST['timesheet'] == 'on') ? true : false;
          $data['leave_management'] = (isset($_POST['leave_management']) && $_POST['leave_management'] == 'on') ? true : false;
          $data['time_clock'] = (isset($_POST['time_clock']) && $_POST['time_clock'] == 'on') ? true : false;
          $data['job_tracker'] = (isset($_POST['job_tracker']) && $_POST['job_tracker'] == 'on') ? true : false;
          $data['job_tracker_approval'] = (isset($_POST['job_tracker_approval']) && $_POST['job_tracker_approval'] == 'on') ? true : false;
          $data['administrator'] = (isset($_POST['administrator']) && $_POST['administrator'] == 'on') ? true : false;
          $data['guard'] = (isset($_POST['guard']) && $_POST['guard'] == 'on') ? true : false;
          $data['customer'] = (isset($_POST['customer']) && $_POST['customer'] == 'on') ? true : false;
          $data['contractor'] = (isset($_POST['contractor']) && $_POST['contractor'] == 'on') ? true : false;
          $data['reports'] = (isset($_POST['reports']) && $_POST['reports'] == 'on') ? true : false;
          $data['guard_report'] = (isset($_POST['guard_report']) && $_POST['guard_report'] == 'on') ? true : false;
          $data['customer_report'] = (isset($_POST['customer_report']) && $_POST['customer_report'] == 'on') ? true : false;
          $data['contractor_report'] = (isset($_POST['contractor_report']) && $_POST['contractor_report'] == 'on') ? true : false;
          $data['green_and_welfare_report'] = (isset($_POST['green_and_welfare_report']) && $_POST['green_and_welfare_report'] == 'on') ? true : false;
          $data['task_report'] = (isset($_POST['task_report']) && $_POST['task_report'] == 'on') ? true : false;
          $data['paysheet_report'] = (isset($_POST['paysheet_report']) && $_POST['paysheet_report'] == 'on') ? true : false;
          $data['incident_report'] = (isset($_POST['incident_report']) && $_POST['incident_report'] == 'on') ? true : false;
          $data['invoice_report'] = (isset($_POST['invoice_report']) && $_POST['invoice_report'] == 'on') ? true : false;
          $data['hour_report'] = (isset($_POST['hour_report']) && $_POST['hour_report'] == 'on') ? true : false;
          $data['complete_report'] = (isset($_POST['complete_report']) && $_POST['complete_report'] == 'on') ? true : false;
          $data['staff_audit'] = (isset($_POST['staff_audit']) && $_POST['staff_audit'] == 'on') ? true : false;
          $data['communication'] = (isset($_POST['communication']) && $_POST['communication'] == 'on') ? true : false;
          $data['tutorial'] = (isset($_POST['tutorial']) && $_POST['tutorial'] == 'on') ? true : false;
          $data['announcements'] = (isset($_POST['announcements']) && $_POST['announcements'] == 'on') ? true : false;
          $data['rosterControl'] = (isset($_POST['rosterControl']) && $_POST['rosterControl'] == 'on') ? true : false;
          $data['charge_rates'] = (isset($_POST['charge_rates']) && $_POST['charge_rates'] == 'on') ? true : false;
          $data['pay_rates'] = (isset($_POST['pay_rates']) && $_POST['pay_rates'] == 'on') ? true : false;
          $data['app_settings'] = (isset($_POST['app_settings']) && $_POST['app_settings'] == 'on') ? true : false;
          $data['break_bypass'] = (isset($_POST['break_bypass']) && $_POST['break_bypass'] == 'on') ? true : false;
          $data['lock_roster'] = (isset($_POST['lock_roster']) && $_POST['lock_roster'] == 'on') ? true : false;
          $data['16_hour_limit'] = (isset($_POST['16_hour_limit']) && $_POST['16_hour_limit'] == 'on') ? true : false;
          $data['mock_guard'] = (isset($_POST['mock_guard']) && $_POST['mock_guard'] == 'on') ? true : false;
          $data['portal_settings'] = (isset($_POST['portal_settings']) && $_POST['portal_settings'] == 'on') ? true : false;
          $data['division_consolidation'] = (isset($_POST['division_consolidation']) && $_POST['division_consolidation'] == 'on') ? true : false;
          $data['about_us'] = (isset($_POST['about_us']) && $_POST['about_us'] == 'on') ? true : false;
          $data['audit_report'] = (isset($_POST['audit_report']) && $_POST['audit_report'] == 'on') ? true : false;
        // $data['sites'] = $sites;

          foreach ($data as $key => $value) {
           if ($value == '') {
            $data[$key] = false;
          }else{
            $data[$key] = true;

          }
        }
        foreach ($data as $key => $value) {
         $data[$key.'_full_access'] = isset($_POST[$key.'_full_access']) ? $_POST[$key.'_full_access'] : 'view_only';
       }
       $dat['permissions'] = json_encode($data);
          $created_by=Session::get('userId');             // Get session variable
// Get session variable


     //json_encode($data);

     // $dat['title'] = $_POST('access_level_title');
     // $dat['created_by'] = $this->session->userdata('userId');

   //  $isEdit = $_POST('is_edit');
     // if ($isEdit == true) {
     //  $result = $this->db->update('acces_level_defination', $dat, array('id' => $_POST('id')));

     //  }
    //   else{
    //  $result = $this->db->insert('acces_level_defination', $dat);
    // }
          $data1 = DB::table('acces_level_defination')->where('id', $id)->first();
          $result = DB::table('acces_level_defination')->where('id', $id)->update(['title'=> $role_name , 'permissions' =>$dat['permissions'], 'specific_customer' => $specific_customer ,'created_by' => $created_by]);
          if ($result) {

            $action = 'access_updated';
            $this->log_user_activity($action,$data1);
              // echo json_encode(array('success' => true));
            return redirect('/access')->with('msg', 'Record Added');
          }else{
              // echo json_encode(array('success' => false));

            return redirect('/access')->with('msg', 'Something went wrong');

          }


        }




        public function getUser(Request $request){
          $id = $request->input('id');
          $access_id = $request->input('access_level_id');





          $admins=DB::table('administrators')->join('acces_level_defination', function($join) use ($access_id ,$id)
          {
            $join->on('acces_level_defination.id', '=', DB::raw($access_id))->where('administrators.id' , DB::raw($id));
          })->select('administrators.*', 'acces_level_defination.id as access_id', 'acces_level_defination.title')->first();
          $admins->specific_customer = json_decode($admins->specific_customer, true);
          $admins->specific_sites = json_decode($admins->specific_sites, true);
          if (empty($admins->specific_sites)) {
            $admins->specific_sites = '';
          }
        // $admins->multiple_states = json_decode($admins->multiple_states, true);




      // $admins=  DB::table('administrators')->join('acces_level_defination', function ($join) {
      //   $join->on('administrators.access_level_id', '=', 'acces_level_defination.id')->where('administrators.id', $id);
      //   })
      //   ->get();

        // $admins = DB::table('administrators')
        //     ->join('acces_level_defination', $access_id, '=', 'acces_level_defination.id')->get();


      //  $users = DB::table('administrators')->where('id', $id)->first();
          return response()->json($admins);


        }

        public function getAccess($id){

          $access = DB::table('acces_level_defination')->where('id', $id)->first();
          $access->specific_customer =  json_decode($access->specific_customer, true);
          $access->sites =  json_decode($access->sites, true);
          return response()->json($access);


        }

        public function editUser($id, Request $request){
          $image = $request->file('avatar');
          if($image){

            $filename = time().'.'.$image->getClientOriginalExtension();
        // $destinationPath = '../../asset_uploads/';
            $public_path = public_path();
            $public_path = str_replace('portal/public', '', $public_path);
            $public_path = str_replace('apis/public', '', $public_path);
            $destinationPath = $public_path.'asset_uploads/';
            $save= $image->move($destinationPath, $filename);

          }else{
            $filename = DB::table('administrators')->where('id', $id)->value('image');;


          }
          if ($request->has('customer_selection') && !empty($request->customer_selection)) {
            $specific_customer = json_encode($request->customer_selection);
          }else{
            $specific_customer = json_encode(array());
          }
          if ($request->has('sites') && !empty($request->sites)) {
            $specific_sites = json_encode($request->sites);
          }else{
            $specific_sites = json_encode(array());
          }
    // print_r($request->status);
    // exit(); 


          $name=  $_POST['user_name'];

          $access = $_POST['user_role'];


          $email = $_POST['user_email'];
          $access = $_POST['user_role'];

          $multiple_states=[];
          if($request->has('multiple_states')){
            $multiple_states=json_encode($request->multiple_states);
          }
          $state=$request->state;


          $query=  DB::table('administrators')->where('id', $id)->update(['name' => $name,'email' => $email,'image' =>$filename ,'access_level_id' => $access, 'state' => $state, 'specific_customer' => $specific_customer, 'specific_sites' => $specific_sites ,'multiple_states' => $multiple_states, 'status' => $request->status ]);
          if($query){
                            // return redirect('/')->with('msg', 'Record Updated');
            header("Refresh:0");


          }
          return redirect('/administrators')->with('msg', 'Something went wrong');


        // $users = DB::table('administrators')->where('id', $id)->first();
        // return response()->json($users);


        }





        public function deleteUser($id){
         $query=  DB::table('administrators')->where('id', $id)->update(['status' => "deleted"]);
         if($query){
          return response()->json(['success' => true,'msg'=>"deleted Successfully"]);

        }
      }


      public function deleteAccess($id){
        $data1 = DB::table('acces_level_defination')->where('id', $id)->first();
        $query=  DB::table('acces_level_defination')->where('id', $id)->delete();
        if($query){
          $action = 'access_deleted';
          $this->log_user_activity($action,$data1);
          return response()->json(['success' => true, 'msg' => "deleted Successfully"]);

        }
      }

//Session::get('userId')
      public function profile($id){
    // $query=  DB::table('administrators')->where('id', $id)->delete();
    //       if($query){
    //             return view('');

    //       }

       $admins = DB::table('administrators')->where('id', $id)->get();
       $admin_role_id= DB::table('administrators')->select('access_level_id')->where('id',$id)->first();
       $access_id=$admin_role_id->access_level_id;


       $access_role = DB::table('acces_level_defination')->where('id', $access_id)->get();


       $roles= DB::table('acces_level_defination')->select('id','title')->get();
       return view('admin/admin/profile', ['admins' => $admins, 'roles' => $roles,'access_role' =>$access_role]);



     }
     function job_roster(Request $request)
     {
      Session::forget('config_arr_job_roster');
      Session::forget('site');
      Session::forget('customer_id');
  // dd('here');
      $admin_id = session()->get('userId');
      $config_job_roster = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id'  , config('custom.domain_id'))->where('type' , 'job_roster_navigation_bar')->get();
  // dd($config_job_roster);
      $config_arr_job_roster = [];
      foreach($config_job_roster as $job_roster){
        $val = json_decode($job_roster->records_business_navbar);
        array_push($config_arr_job_roster , $val);
      }
      Session()->put('config_arr_job_roster' , $config_arr_job_roster);
      if (!session()->has('userType')) {
        return view('admin/login');
      }else{
        if($request->site && $request->customer_id){
        // dd('here');
          Session()->put('site' , $request->site);
          Session()->put('customer_id' , $request->customer_id);
          $customer_id_url = $request->has('customer_id') ? $request->customer_id : '';
          $site_id_url = $request->has('site') ? $request->site : '';
          return view('admin/job_roster', ['customer_id_url' => $customer_id_url, 'site_id_url' => $site_id_url]);
        }else{
          $customer_id_url = $request->has('customer_id') ? $request->customer_id : '';
          $site_id_url = $request->has('site_id') ? $request->site_id : '';
          return view('admin/job_roster', ['customer_id_url' => $customer_id_url, 'site_id_url' => $site_id_url]);
        }
      }
    }


    function job_roster_new()
    {

      return view('admin/job_roster_new');
    }


    function do_logout(Request $request)
    {
      $request->session()->flush();
      return redirect('/');
    }

    function do_logout_guard(Request $request)
    {
      $request->session()->flush();
      return redirect('/guard');
    }
    function do_logout_customer(Request $request)
    {
      $request->session()->flush();
      return redirect('/customer');
    }
    function do_logout_contractor(Request $request)
    {
      $request->session()->flush();
      return redirect('/contractor');
    }
    function getRosterData($customerId, $start, $end, $search = null)
    {
      $query = DB::table('job_new_roster')
      ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
      ->where('jobs.customer_id',$customerId)
      ->where('job_new_roster.job_start', '>=', strtotime($start))    
      ->where('job_new_roster.job_start', '<=', strtotime($end));
      if ($search != null && !empty($search)) {
        $query->where(function ($query1) use ($search){
          $i = 0;
          foreach ($search as $key => $index) {
            if ($i = 0) {
              $query1->where('jobs.id', $index);
            }else{
              $query1->orWhere('jobs.id', $index);
            }
            $i++;
          }
        });
      }
    // if ($search != null && $search != '') {
    //   $query->where('jobs.site_name','LIKE','%'.$search.'%');
    //   $query->orWhere('jobs.site_description','LIKE','%'.$search.'%');
    // }
      $rosterData = $query->select('job_new_roster.roster_id')
      ->get();
      return $rosterData;    
    }

    function changeRoster($customerId, $start, $end, $prams, $search = null, $selectedRosterId = null, $action = null)
    {
      if (!empty($selectedRosterId)) {
        $rosterData = DB::table('job_new_roster');
        if ($selectedRosterId != null && !empty($selectedRosterId)) {
          $rosterData->where(function ($query1) use ($selectedRosterId){
            $i = 0;
            foreach ($selectedRosterId as $key => $index) {
              if ($i = 0) {
                $query1->where('job_new_roster.roster_id', $index);
              }else{
                $query1->orWhere('job_new_roster.roster_id', $index);
              }
              $i++;
            }
          });
        }
      }else{
        $rosterData = DB::table('job_new_roster')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->where('jobs.customer_id',$customerId)
        ->where('job_new_roster.job_start', '>=', strtotime($start))    
        ->where('job_new_roster.job_start', '<=', strtotime($end));
        if ($search != null && !empty($search)) {
          $rosterData->where(function ($query1) use ($search){
            $i = 0;
            foreach ($search as $key => $index) {
              if ($i = 0) {
                $query1->where('jobs.id', $index);
              }else{
                $query1->orWhere('jobs.id', $index);
              }
              $i++;
            }
          });
        }
      }
      if ($action != '') {
        $deletedRoster =  $rosterData;
        $deletedRosterIds = $deletedRoster->get();
        foreach ($deletedRosterIds as $key => $roster) {
         $guard_data = DB::table('guards')->where('id', $roster->guard_id)->select('guards.*')->first();
         if(!empty($guard_data) && $roster->publish_status == 1){
          $notification_data['guards'][0] = array(
            'guard_id' => $guard_data->id,
            'notification_token' => $guard_data->notification_token );
          $notification_data['title'] = 'Shift removed';
          $notification_data['message'] = 'Shift Remove - One of your shift is removed';
          $notification_data['page'] = 'homepage';
          $res = $this->guard_model->send_push_notification($notification_data);
        }
      }
    }

    $rosterData->update($prams);
  }

  function deleteRosterShifts($customerId, $start, $end, $search = null, $selectedRosterId = null)
  {

    if (!empty($selectedRosterId)) {
      $rosterData = DB::table('job_new_roster');
      if ($selectedRosterId != null && !empty($selectedRosterId)) {
        $rosterData->where(function ($query1) use ($selectedRosterId){
          $i = 0;
          foreach ($selectedRosterId as $key => $index) {
            if ($i = 0) {
              $query1->where('job_new_roster.roster_id', $index);
            }else{
              $query1->orWhere('job_new_roster.roster_id', $index);
            }
            $i++;
          }
        });
      }
    // $deletedRosterIds =  $rosterData;
    }else{
      $rosterData = DB::table('job_new_roster')
      ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
      ->where('jobs.customer_id',$customerId)
      // ->where('job_new_roster.job_start', '>=', strtotime($start))    
      ->where('job_new_roster.temp_start', '>=', $start)    
      // ->where('job_new_roster.job_start', '<=', strtotime($end));
      ->where('job_new_roster.temp_start', '<=',$end);
      if ($search != null && !empty($search)) {
        $rosterData->where(function ($query1) use ($search){
          $i = 0;
          foreach ($search as $key => $index) {
            if ($i = 0) {
              $query1->where('jobs.id', $index);
            }else{
              $query1->orWhere('jobs.id', $index);
            }
            $i++;
          }
        });
      }
    }
    $deletedRoster =  $rosterData;
    $deletedRosterIds = $deletedRoster->get();
    foreach ($deletedRosterIds as $key => $roster) {
     $guard_data = DB::table('guards')->where('id', $roster->guard_id)->select('guards.*')->first();
     if(!empty($guard_data) && $roster->publish_status == 1){
      $notification_data['guards'][0] = array(
        'guard_id' => $guard_data->id,
        'notification_token' => $guard_data->notification_token );
      $notification_data['title'] = 'Shift delete';
      $notification_data['message'] = 'Shift Remove - One of your shift is removed';
      $notification_data['page'] = 'homepage';
      $res = $this->guard_model->send_push_notification($notification_data);
    }
  }
  $rosterData->delete();
}

function copyRosterSift($roster_id, $copy_to, $view)
{
  config(['app.timezone' => $this->timezone['Victoria']]);
  date_default_timezone_set($this->timezone['Victoria']);
  $conflict = 0;
  $roster = DB::table('job_new_roster')->where('roster_id', $roster_id)->first();
  $days = ['mon' => 'monday', 'tue' => 'tuesday', 'wed' => 'wednesday', 'thu' => 'thursday', 'fri' => 'friday', 'sat' => 'saturday' , 'sun' => 'sunday'];
  // $last_roster = DB::table('job_new_roster')->orderBy('event_id', 'DESC')->first();
  // $event_id = 1;
  // if (!empty($last_roster)) {
  //   $event_id = $last_roster->event_id + 1;
  // }

  DB::transaction(function () use (&$event_id) {
    $last = DB::table('job_new_roster')
        ->lockForUpdate()
        ->max('event_id');

    $event_id = $last ? $last + 1 : 1;
  });
  while (
      DB::table('job_new_roster')
          ->where('event_id', $event_id)
          ->exists()
  ) {
      $event_id++;
  }
  $start = time();
  $end = time();
  $roster->job_start = strtotime($roster->temp_start);
  $roster->job_end = strtotime($roster->temp_end);
  $last_shift_day_start = strtolower(date('D', $roster->job_start));
  $last_shift_day_end = strtolower(date('D', $roster->job_end));
  $shift_day = $days[$last_shift_day_start];
  $shift_day_end = $days[$last_shift_day_end];
  $start_time = date('H:i', $roster->job_start);
  $end_time = date('H:i', $roster->job_end);
  if ($view == 'week') {
    if ($copy_to == 'current') {
      $roster->job_start = date('Y-m-d', strtotime($shift_day .' this week')) . ' '. $start_time ;
      if ($last_shift_day_end == 'mon') {
        $roster->job_end = date('Y-m-d', strtotime($shift_day_end .' next week')) . ' '.$end_time;
      }else{
        $roster->job_end = date('Y-m-d', strtotime($shift_day_end .' this week')) . ' '.$end_time;
      } 
    }else{
      $roster->job_start = date('Y-m-d', strtotime($shift_day .' next week')) . ' '. $start_time;
      $roster->job_end = date('Y-m-d', strtotime($shift_day_end .' next week')) . ' '.$end_time;
      if ($last_shift_day_end == 'mon' && $last_shift_day_start == 'sun') {
        // $roster->job_end = strtotime($roster->job_end) + (60*60*24*7);
        $roster->job_end = strtotime($roster->temp_end) + strtotime('+1 week');
        $roster->job_end = date('Y-m-d H:i', $roster->job_end);
              // print_r($roster->job_end);
              // exit();
      }
    }
    $roster->job_start = strtotime($roster->job_start);
    $roster->job_end = strtotime($roster->job_end);

  }else{

    if ($copy_to == 'current') {
      $roster->job_start = date('Y-m-'). date('d', $roster->job_start) . ' '. $start_time ;
      $roster->job_end = date('Y-m-'). date('d', $roster->job_end) . ' '.$end_time;
    }else{
      $roster->job_start = date('Y-m-', strtotime('+1 month')). date('d', $roster->job_start) . ' '. $start_time ;
      $roster->job_end = date('Y-m-', strtotime('+1 month')). date('d', $roster->job_end) . ' '.$end_time;
    }
    $roster->job_start = strtotime($roster->job_start);
    $roster->job_end = strtotime($roster->job_end);
  }
  $next_roster = array(
    'event_id' => $event_id,
    'guard_id' => $roster->guard_id,
    'site_id' => $roster->site_id,
    'temp_date' => date('Y-m-d', $roster->job_start),
    'temp_start' => date('Y-m-d H:i:s', $roster->job_start),
    'temp_end' => date('Y-m-d H:i:s', $roster->job_end),
    'start' => str_replace(' ', 'T', date('Y-m-d H:i:s', $roster->job_start)),
    'end' => str_replace(' ', 'T', date('Y-m-d H:i:s', $roster->job_end)),
        // 'publish_status' => $roster->publish_status,
    'publish_status' => 0,
    'add_status' => $roster->add_status,
    'job_status' => 'pending',
    'post_status' => 0,
    'green_call_notification' => 'no',
    'roll_over' => 1,
    'update_status' => 1,
    'job_start' => $roster->job_start,
    'job_end' => $roster->job_end,
    'operators_notes' => $roster->operators_notes
  );
    // print_r($next_roster);
  $next_roster['hours'] = round(abs($next_roster['job_end'] - $next_roster['job_start']) / 3600,2);

  if ($next_roster['guard_id'] != '' && $next_roster['guard_id'] != null && $next_roster['guard_id'] > 0) {

    $already = DB::table('job_new_roster')->where('guard_id', $next_roster['guard_id'])->where('temp_start','<=', $next_roster['start'])->where('temp_end','>=', $next_roster['start'])->first();
    if (empty($already)) {
      $already = DB::table('job_new_roster')->where('guard_id', $next_roster['guard_id'])->where('temp_start','<=', $next_roster['end'])->where('temp_end','>=', $next_roster['end'])->first();
    }
    $guardData = DB::table('guards')->where('id', $next_roster['guard_id'])->first();
    $status = $this->checkGuardDocuments($guardData, $next_roster['temp_date']);
    if (!empty($already)) {
      $next_roster['guard_id'] = 0;
      $conflict = 1;
    }elseif($status != "Active"){
      $next_roster['guard_id'] = 0;
      $conflict = 1;
    }
  }
  $inserted_id = DB::table('job_new_roster')->insertGetId($next_roster);
  $this->guard_model->logPayChargeRate($inserted_id);

  $tasks = DB::table('job_roster_tasks')->where('roster_id', $roster_id)->get();
  foreach ($tasks as $key => $task) {
    DB::table('job_roster_tasks')->insert([
      'roster_id' => $inserted_id,
      'guard_id' => $next_roster['guard_id'],
      'task_name' =>  $task->task_name,
      'task_time' => $task->task_time
    ]);
  }

  return $conflict;
}

function doCallAction(Request $request)
{
  $conflicts = 0;
  foreach ($request->customerIds as $key => $customerId) {

    if ($request->action == 'copy') {
      $rosterData = $this->getRosterData($customerId, $request->start, $request->end, $request->search);
        // return response()->json(['success' => true, 'message' => $message, 'data' => $rosterData]);
        // exit();
      foreach ($rosterData as $roster) {
        $conflicts += $this->copyRosterSift($roster->roster_id, $request->copy_to, $request->view);
      }
      $action = 'shift_roll_over';
      $this->log_user_activity($action, array('message' => 'Rollover week from '.date('Y-m-d', strtotime($request->start)).' to '.date('Y-m-d', (strtotime($request->end) - (60*60*24))), 'request' => request()->all()));
    }elseif($request->action == 'unpublish'){
      $prams = array('publish_status' => 0);
      $this->changeRoster($customerId, $request->start, $request->end, $prams, $request->search, $request->selectedRosterId);
    }elseif($request->action == 'unassign'){
      $prams = array('guard_id' => 0);
      $this->changeRoster($customerId, $request->start, $request->end, $prams, $request->search, $request->selectedRosterId, 'unassign');
    }elseif($request->action == 'clear'){
     $this->deleteRosterShifts($customerId, $request->start, $request->end, $request->search, $request->selectedRosterId);
   }
 }

 if($conflicts > 0) {
  $message = 'There is conflict in '. $conflicts. ' shifts. So, they are copy as unassigned shifts!';  
}else{
  $message = 'Roster update successfully!';
}
return response()->json(['success' => true, 'message' => $message]);



}


public function basic_setting(){
  $setting=DB::table('app_basic_settings')->first();
  $admins=DB::table('administrators')->get();
  return view('admin/setting/app_basic_setting',['settings'=>$setting,'admins' => $admins]);
}
public function portal_email_settings(){
  $permissions = ['document_expiry', 'job_rejection', 'green_call_miss','signup', 'profile_update', 'incident_report', 'publish_shift', 'update_shift', 'delete_shift', 'admin_update_shift'];
  $permission_array = [];
  foreach ($permissions as $key => $permission) {
    $permission_array[$permission] = DB::table('portal_settings')->where('permission_name', $permission)->first();
  }
    // $setting=DB::table('app_basic_settings')->get();
    // $admins=DB::table('administrators')->get();
  return view('admin/setting/portal_email_settings', $permission_array);
}
public function notification_setting(){
  $setting=DB::table('app_notifications_settings')->get();

  return view('admin/setting/app_notification_setting',['setting'=>$setting]);
}

public function ph_settings()
{
  return view('admin/setting/ph_setting');
}
public function color_settings()
{
  $colors = DB::table('portal_settings')->where('permission_name', 'portal_colors')->first();
  if (!empty($colors)) {
    $colors = json_decode($colors->users_emails, true);
  }else{
    $colors = array();
  }
  // print_r($colors);
  // exit();
  return view('admin/setting/portal_color_settings', ['colors' => $colors]);
}
public function fetch_setting_basic(Request $request){
  $setting=DB::table('app_basic_settings')->get();
  return $setting;
}

public function fetch_setting_notifications(Request $request){
  $setting=DB::table('app_notifications_settings')->get();
  return $setting;
}

public function fetch_setting_features(Request $request){
  $setting=DB::table('app_features_settings')->get();
  return $setting;
}
public function feature_setting(){
  $setting=DB::table('app_features_settings')->get();

  return view('admin/setting/app_feature_setting',['setting'=>$setting]);

}

public function update_feature_selection(Request $request){
  $setting=  DB::table('app_features_settings')->update([
    'tasks'=>$request->tasks,
    'break'=>$request->break,
    'geo_fencing'=>$request->geo_fencing,
    'asap_job'=>$request->asap_job,
    'announcemnet'=>$request->announcemnet,
    'induction'=>$request->induction,
    'chat'=>$request->chat,
    'leave'=>$request->leave
  ]);
  if($setting){
    return response()->json(['success' => true, 'message' => "Form Save Successfully", 'setting' => $setting]);

  }



}

public function update_feature_setting(Request $request){
  $setting= DB::table('app_features_settings')->update([
    'clock_in_selfie'=>$request->clock_in_selfie,
    'clock_in_note'=>$request->clock_in_note,
    'clock_out_selfie'=>$request->clock_out_selfie,
    'clock_out_note'=>$request->clock_out_note,
    'clock_in_auto'=>$request->clock_in_auto,
    'clock_out_auto'=>$request->clock_out_auto,
    'clock_in_allow'=>$request->clock_in_allow

  ]);
  if($setting){
    return response()->json(['success' => true, 'message' => "Form Save Successfully", 'setting' => $setting]);

  }
}

public function update_notification_selection(Request $request){
  $setting=  DB::table('app_notifications_settings')->update([
    'new_roster'=>$request->new_roster,
    'profile_udpate'=>$request->profile_udpate,
    'tasks_add'=>$request->tasks_add,
    'tasks_reminder'=>$request->tasks_reminder,
    'shift_update'=>$request->shift_update,
    'shift_delete'=>$request->shift_delete,
    'asap_job'=>$request->asap_job,
    'announcemnet'=>$request->announcemnet,
    'induction'=>$request->induction,
    'chat'=>$request->chat,
    'leave_approval'=>$request->leave_approval
  ]);
  if($setting){
    return response()->json(['success' => true, 'message' => "Form Save Successfully", 'setting' => $setting]);

  }
}

public function update_basic_communication(Request $request){
  $settings = DB::table('app_basic_settings')->first();
  if (!empty($settings)) {
    $setting = DB::table('app_basic_settings')->update([
      'operations_user' => $request->operations_user,
      'admin_user' => $request->admin_user,
      'hr_user' => $request->hr_user,
      'payroll_user' => $request->payroll_user

    ]);
    return response()->json(['success' => true, 'message' => "Form Save Successfully", 'setting' => $setting]);

  }else{
    DB::table('app_basic_settings')->insert([
      'operations_user' => $request->operations_user,
      'admin_user' => $request->admin_user,
      'hr_user' => $request->hr_user,
      'payroll_user' => $request->payroll_user

    ]);
    return response()->json(['success' => true, 'message' => "Form Save Successfully", 'setting' => true]);

  }
}

function upload_img($key)
{

  $name = '';

  $path = '../../asset_uploads/';

  $file_name = time() .'.jpg';

  $this->base64_to_jpeg($key, $path . $file_name);

  $name = $file_name;

  return $name;

}


function base64_to_jpeg($data, $output_file)

{

  $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
  file_put_contents($output_file, $data);

}

public function update_basic_display(Request $request){
  $image=$this->upload_img($request->cover);
  $setting=  DB::table('app_basic_settings')->update([
    'primary_color'=>$request->primary_color,
    'secondary_color'=>$request->secondary_color,
    'cover'=>$image

  ]);
  if($setting){
    return response()->json(['success' => true, 'message' => "Form Save Successfully", 'setting' => $setting]);

  }
}

public function update_basic_green_call(Request $request){
  $setting=    DB::table('app_basic_settings')->update([
    'first_green_call'=>$request->first_green_call,
    'second_green_call'=>$request->second_green_call
  ]);
  if($setting){
    return response()->json(['success' => true, 'message' => "Form Save Successfully", 'setting' => $setting]);
  }
}

public function update_basic_job(Request $request){
  $setting= DB::table('app_basic_settings')->update([
    'shift_decline_button'=>$request->shift_decline_button,
    'asap_decline_button'=>$request->asap_decline_button
  ]);
  if($setting){
    return response()->json(['success' => true, 'message' => "Form Save Successfully", 'setting' => $setting]);

  }
}
function date_convert($date_format)
{
  if (count(explode('-', $date_format)) > 0) {
    return $date_format;
  }else{
    list($date, $month , $year) = sscanf($date_format, '%d/%d/%d');
    if ($month < 9) {
      $month = '0'.$month;
    }
    return $month.'/'.$date.'/'.$year;
  }
}
public function checkGuardDocuments($guard, $today)
{
        // $today = date("Y-m-d");
  $today_time = strtotime($today);
  $passport_expiration = strtotime($this->date_convert($guard->passport_expiration));
  $visa_expiration = strtotime($this->date_convert($guard->visa_expiration));
  $security_license_expiration = strtotime($this->date_convert($guard->security_license_expiration));
  $driver_license_expiration = strtotime($this->date_convert($guard->driver_license_expiration));
  $firstaid_license_expiration = strtotime($this->date_convert($guard->firstaid_license_expiration));
  $firearm_license_expiration = strtotime($this->date_convert($guard->firearm_license_expiration));

  if ($passport_expiration && ($passport_expiration < $today_time)) {
    $status = "Passport Expired";
  } elseif ($visa_expiration && ($visa_expiration < $today_time)) {
    $status = "Visa Expired";
  } elseif ($security_license_expiration && ($security_license_expiration < $today_time)) {
    $status = "Security License Expired";
  } elseif ($driver_license_expiration && ($driver_license_expiration < $today_time)) {
    $status = "Driver License Expired";
  } elseif ($firstaid_license_expiration && ($firstaid_license_expiration < $today_time)) {
    $status = "Firstaid License Expired";
  } elseif ($firearm_license_expiration && ($firearm_license_expiration < $today_time)) {
    $status = "Firearm License Expired";
  } else {
    $status = 'Active';
  }

  return $status;
}

function get_log_activities()
{
  $flag = true;
  $message = 'Data received';
  $data = DB::table('log_user_activities')->join('administrators', 'administrators.id', '=', 'log_user_activities.user_id')->orderBy('log_user_activities.id', 'DESC')->select('log_user_activities.*','administrators.name')->get();
  return response()->json(['success' => $flag, 'message' => $message, 'data' => $data]);
}
function bussiness_management(){
  if (!session()->has('bussiness_userType')) {
    return view('bussiness_do_login');
  }else{
    $root = $_SERVER['HTTP_HOST'];
    $root = explode('.', $root);
    $sub_domain = 'staffingsolution';
    if($root[0] != 'wwww'){
      $sub_domain = $root[0];
    }else{
      $sub_domain = $root[1];
    }
    $config_data = DB::connection('mysql2')->table('business_data')->get();
    return view('bussiness_management',['bussinesss'=>$config_data]) ;
  }
}
function bussiness_management_config($id){
  Session::forget('config_recods');
  Session::forget('config_recods1');
  Session::forget('config_recods2');
  // dd($config_data);
  $config_arr = [];
  $config_recods = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id'  , $id)->where('type' , 'navigation_bar')->get();
  if(count($config_recods) > 0){
    foreach($config_recods as $data){
      $value = json_decode($data->records_business_navbar);
      array_push($config_arr , $value);
    }
  }else{
    $val = json_encode(array(
      'administrator' => 1,
      'dashboard' => 1,
      'announcements_induction' => 1,
      'basics' => 1,
      'chat' => 1,
      'color_settings' => 1,
      'complete_paysheet' => 1,
      'contractor' => 1,
      'contractor_report' => 1,
      'customer' => 1,
      'message_icon' => 1,
      'guards_login' => 1,
      'customer_login' => 1,
      'contractor_login' => 1,
      'notification_icon' => 1,
      'division_consolidation' => 1,
      'email' => 1,
      'features' => 1,
      'guards' => 1,
      'incident_report_page' => 1,
      'invoice_report' => 1,
      'hour_report' => 0,
      'job_roster' => 1,
      'job_tracker' => 1,
      'leave_management' => 1,
      'log_user_activities' => 1,
      'notifications' => 1,
      'pay_rates' => 1,
      'permissions' => 1,
      'ph_settings' => 1,
      'quick_Paysheet' => 1,
      'report' => 1,
      'tasks_report' => 1,
      'time_clock' => 1,
      'guard_license' => 1,
      'site_list' => 1,
      'time_sheet' => 1,
      'charge_rates' => 1,

    ));
    $value = json_decode($val);
    array_push($config_arr , $value);
  }
  Session()->put('config_recods' , $config_arr);

  $config_arr1 = [];
  $config_recods1 = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id'  , $id)->where('type' , 'job_roster_navigation_bar')->get();
  if(count($config_recods1) > 0){
    foreach($config_recods1 as $data){
      $value1 = json_decode($data->records_business_navbar);
      array_push($config_arr1 , $value1);
    }
  }else{
    $val1 = json_encode(array(
      'select_state' => 1,
      'select_customer' => 1,
      'select_sites' => 1,
      'action' => 1,
      'publish' =>1,
      'add_site' => 1,
      'ad_shift' => 1,
      'report' => 1,
      'add_guards' => 1,
      'job_roster_filter' => 1,
      'un_publish_site' => 1,
      'payroll' => 1,
      'job_instrcution_file' => 1,
      'coordinates' => 1,
      'copy_current_week' => 1,
      'copy_shifts' => 1,
      'clear_week' => 1,
      'unpublish_week' => 1,
      'unassign_week' => 1,
      'add_multiple_shifts' => 1,
      'rollover_this_week' => 1,
      'create_shift_button' => 1,
      'sign_in_detail' => 1,
      'sign_out_detail' => 1,
      'break_detail' => 1,
      'gree_call' => 1,
      'welfare_call' => 1,
      'tracker' => 1,
      'incident_report' => 1,
      'shift_task' => 1,
      'shift_activity' => 1,
      'operation_notes' => 1,
      'shift_colors' => 1,
      'site_type' => 1,
      'site_trained' => 1,
      'start_end_date' => 1,
      'breaks' => 1,
      'welfare_calls' => 1,
      'site_hours' => 1,
      'charge_rates_and_level' => 1,
      'charge_rates_level' => 1,
      'charge_rates' => 1,
      'signin_radius' => 1,
      'radius_alert' => 1,
      'job_instrcutions' => 1,
      'sos_phone' => 1,
      'tasks' => 1,
      'start_date' => 1,
      'end_date' => 1,
      'three_dots_shifts' => 1,
      'view_guards' => 1,
      'shift_site_name' => 1,
      'shift_guard_name' => 1,
      'shift_available_guard' => 1,
      'shift_paybale' => 1,
      'paid_by' => 1,
      'shift_start_time' => 1,
      'shift_end_time' => 1,
      'travel_time' => 1,
      'sms' => 0,
      'email' => 1,


    ));
    $value1 = json_decode($val1);
    array_push($config_arr1 , $value1);
  }

  Session()->put('config_recods1' , $config_arr1);

      // guards_navigation_bar start

  $config_arr2 = [];
  $config_recods2 = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id'  , $id)->where('type' , 'guards_navigation_bar')->get();
  if(count($config_recods2) > 0){
    foreach($config_recods2 as $data){
      $value2 = json_decode($data->records_business_navbar);
      array_push($config_arr2 , $value2);
    }
  }else{
    $val2 = json_encode(array(
      'active_guards' => 1,
      'inactive_guards' => 1,
      'new_guards' => 1,
      'pending_guards' => 1,
      'deleted_guards' => 1,
      'add_guards' => 1,
      'site_trained' => 1,
      'guard_uniform' => 1,
      'guard_work_limitation' => 1,
      'leave_management' => 1,
      'select_customer' => 1,
      'gender' => 1,
      'dob' => 1,
      'postal_code' => 1,
      'state' => 1,
      'city' => 1,
      'suburb' => 1,
      'address' => 1,
      'guard_type' => 1,
      'password' => 1,
      'email' => 1,
      'profile_image' => 1,
      'coordinates' => 1,
      'emergency_contact_name' => 1,
      'emergency_contact_phone' => 1,

    ));
    $value2 = json_decode($val2);
    array_push($config_arr2 , $value2);
  }

  Session()->put('config_recods2' , $config_arr2);
      //guards_navigation_bar end
  $config_data = DB::connection('mysql2')->table('business_data')->where('id',$id)->get();
  return view('bussiness_management_config',['bussinesss'=>$config_data]);
}
function bussiness_management_config_check(Request $request){
  // dd($request->all());
  if($request->navigation_bar === 'navigation_bar'){
    $config_rows = ['business_data_id' => $request->business_data_id,
    'type' => $request->navigation_bar,
    'records_business_navbar' => json_encode(array(
      'dashboard' => $request->dashboard ? '1' : '0',
      'message_icon' => $request->message_icon ? '1' : '0',
      'guards_login' => $request->guards_login ? '1' : '0',
      'customer_login' => $request->customer_login ? '1' : '0',
      'contractor_login' => $request->contractor_login ? '1' : '0',
      'notification_icon' => $request->notification_icon ? '1' : '0',
      'job_roster' => $request->job_roster ? '1' : '0',
      'time_sheet' => $request->time_sheet ? '1' : '0',
      'job_tracker' => $request->job_tracker ? '1' : '0',
      'leave_management' => $request->leave_management ? '1' : '0',
      'time_clock' => $request->time_clock ? '1' : '0',
      'guard_license' => $request->guard_license ? '1' : '0',
      'site_list' => $request->site_list ? '1' : '0',
      'log_user_activities' => $request->log_user_activities ? '1' : '0',
      'administrator' => $request->administrator ? '1' : '0',
      'customer' => $request->customer ? '1' : '0',
      'contractor' => $request->contractor ? '1' : '0',
      'guards' => $request->guards ? '1' : '0',
      'permissions' => $request->permissions ? '1' : '0',
      'chat' => $request->chat ? '1' : '0',
      'announcements_induction' => $request->announcements_induction ? '1' : '0',
      'tasks_report' => $request->tasks_report ? '1' : '0',
      'contractor_report' => $request->contractor_report ? '1' : '0',
      'report' => $request->report ? '1' : '0',
      'invoice_report' => $request->invoice_report ? '1' : '0',
      'hour_report' => $request->hour_report ? '1' : '0',
      'quick_Paysheet' => $request->quick_Paysheet ? '1' : '0',
      'incident_report_page' => $request->incident_report_page ? '1' : '0',
      'complete_paysheet' => $request->complete_paysheet ? '1' : '0',
      'division_consolidation' => $request->division_consolidation ? '1' : '0',
      'charge_rates' => $request->charge_rates ? '1' : '0',
      'pay_rates' => $request->pay_rates ? '1' : '0',
      'email' => $request->email ? '1' : '0',
      'ph_settings' => $request->ph_settings ? '1' : '0',
      'color_settings' => $request->color_settings ? '1' : '0',
      'basics' => $request->basics ? '1' : '0',
      'features' => $request->features ? '1' : '0',
      'notifications' => $request->notifications ? '1' : '0',
      'own_payrates' => $request->own_payrates ? '1' : '0',
      'categorized_payrates' => $request->categorized_payrates ? '1' : '0',
      'signin_out_report' => $request->signin_out_report ? '1' : '0',
      'audit_report' => $request->audit_report ? '1' : '0',
    ))];
  }
  elseif($request->navigation_bar === 'guards_navigation_bar'){
    // dd($request->all());
    $config_rows = ['business_data_id' => $request->business_data_id,
    'type' => $request->navigation_bar,
    'records_business_navbar' => json_encode(array(
      'active_guards' => $request->active_guards ? '1' : '0',
      'inactive_guards' => $request->inactive_guards ? '1' : '0',
      'new_guards' => $request->new_guards ? '1' : '0',
      'pending_guards' => $request->pending_guards ? '1' : '0',
      'deleted_guards' => $request->deleted_guards ? '1' : '0',
      'add_guards' => $request->add_guards ? '1' : '0',
      'site_trained' => $request->site_trained ? '1' : '0',
      'guard_uniform' => $request->guard_uniform ? '1' : '0',
      'guard_work_limitation' => $request->guard_work_limitation ? '1' : '0',
      'leave_management' => $request->leave_management ? '1' : '0',
      'select_customer' => $request->select_customer ? '1' : '0',
      'gender' => $request->gender ? '1' : '0',
      'dob' => $request->dob ? '1' : '0',
      'postal_code' => $request->postal_code ? '1' : '0',
      'state' => $request->state ? '1' : '0',
      'city' => $request->city ? '1' : '0',
      'suburb' => $request->suburb ? '1' : '0',
      'address' => $request->address ? '1' : '0',
      'guard_type' => $request->guard_type ? '1' : '0',
      'password' => $request->password ? '1' : '0',
      'email' => $request->email ? '1' : '0',
      'profile_image' => $request->profile_image ? '1' : '0',
      'coordinates' => $request->coordinates ? '1' : '0',
      'emergency_contact_name' => $request->emergency_contact_name ? '1' : '0',
      'emergency_contact_phone' => $request->emergency_contact_phone ? '1' : '0',
      'casual_guards' => $request->casual_guards ? '1' : '0',
      
    ))];
  } else{
    $config_rows = ['business_data_id' => $request->business_data_id,
    'type' => $request->navigation_bar,
    'records_business_navbar' => json_encode(array(
      'select_state' => $request->select_state ? '1' : '0',
      'select_customer' => $request->select_customer ? '1' : '0',
      'select_sites' => $request->select_sites ? '1' : '0',
      'action' => $request->action ? '1' : '0',
      'publish' => $request->publish ? '1' : '0',
      'add_site' => $request->add_site ? '1' : '0',
      'ad_shift' => $request->ad_shift ? '1' : '0',
      'report' => $request->report ? '1' : '0',
      'add_guards' => $request->add_guards ? '1' : '0',
      'job_roster_filter' => $request->job_roster_filter ? '1' : '0',

      'un_publish_site' => $request->un_publish_site ? '1' : '0',
      'payroll' => $request->payroll ? '1' : '0',
      'job_instrcution_file' => $request->job_instrcution_file ? '1' : '0',
      'coordinates' => $request->coordinates ? '1' : '0',
      'copy_current_week' => $request->copy_current_week ? '1' : '0',
      'copy_shifts' => $request->copy_shifts ? '1' : '0',
      'clear_week' => $request->clear_week ? '1' : '0',
      'unpublish_week' => $request->unpublish_week ? '1' : '0',
      'unassign_week' => $request->unassign_week ? '1' : '0',
      'add_multiple_shifts' => $request->add_multiple_shifts ? '1' : '0',

      'rollover_this_week' => $request->rollover_this_week ? '1' : '0',
      'create_shift_button' => $request->create_shift_button ? '1' : '0',
      'sign_in_detail' => $request->sign_in_detail ? '1' : '0',
      'sign_out_detail' => $request->sign_out_detail ? '1' : '0',
      'break_detail' => $request->break_detail ? '1' : '0',
      'gree_call' => $request->gree_call ? '1' : '0',
      'welfare_call' => $request->welfare_call ? '1' : '0',
      'tracker' => $request->tracker ? '1' : '0',
      'incident_report' => $request->incident_report ? '1' : '0',
      'shift_task' => $request->shift_task ? '1' : '0',
      'shift_activity' => $request->shift_activity ? '1' : '0',
      'operation_notes' => $request->operation_notes ? '1' : '0',
      'shift_colors' => $request->shift_colors ? '1' : '0',
      'site_type' => $request->site_type ? '1' : '0',
      'site_trained' => $request->site_trained ? '1' : '0',
      'breaks' => $request->breaks ? '1' : '0',
      'welfare_calls' => $request->welfare_calls ? '1' : '0',
      'site_hours' => $request->site_hours ? '1' : '0',
      'charge_rates_and_level' => $request->charge_rates_and_level ? '1' : '0',
      'charge_rates_level' => $request->charge_rates_level ? '1' : '0',
      'charge_rates' => $request->charge_rates ? '1' : '0',
      'signin_radius' => $request->signin_radius ? '1' : '0',
      'radius_alert' => $request->radius_alert ? '1' : '0',
      'job_instrcutions' => $request->job_instrcutions ? '1' : '0',
      'sos_phone' => $request->sos_phone ? '1' : '0',
      'start_end_date' => $request->start_end_date ? '1' : '0',
      'tasks' => $request->tasks ? '1' : '0',
      'start_date' => $request->start_date ? '1' : '0',
      'end_date' => $request->end_date ? '1' : '0',
      'three_dots_shifts' => $request->three_dots_shifts ? '1' : '0',
      'view_guards' => $request->view_guards ? '1' : '0',
      'shift_site_name' => $request->shift_site_name ? '1' : '0',
      'shift_guard_name' => $request->shift_guard_name ? '1' : '0',
      'shift_available_guard' => $request->shift_available_guard ? '1' : '0',
      'shift_paybale' => $request->shift_paybale ? '1' : '0',
      'paid_by' => $request->paid_by ? '1' : '0',
      'shift_start_time' => $request->shift_start_time ? '1' : '0',
      'shift_end_time' => $request->shift_end_time ? '1' : '0',
      'travel_time' => $request->travel_time ? '1' : '0',
      'sms' => $request->sms ? '1' : '0',
      'shift_instruction_color' => $request->sms ? '1' : '0',
      'email' => $request->email ? '1' : '0',
      'shift_status' => $request->shift_status ? '1' : '0',
      'continuation' => $request->continuation ? '1' : '0',
      'break_management' => $request->break_management ? '1' : '0',
      'operational_notes' => $request->operational_notes ? '1' : '0',
      'covid_marshal' => $request->covid_marshal ? '1' : '0',
      'custom_payrates' => $request->custom_payrates ? '1' : '0',
      'documents_bypass' => $request->documents_bypass ? '1' : '0',
    ))];
}

  // print_r($config_rows);
  // exit();


$config_data = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id'  , $request->business_data_id)->where('type' , $request->navigation_bar)->get();
if(count($config_data) > 0){
    // dd('navigation_bar');
  if($request->navigation_bar === 'navigation_bar'){
      // dd('navigation_bar');
    DB::connection('mysql2')->table('bussiness_config')
    ->where('business_data_id' , $request->business_data_id)
    ->where('type' , 'navigation_bar')
    ->update($config_rows);
  }
  elseif($request->navigation_bar === 'guards_navigation_bar'){
    DB::connection('mysql2')->table('bussiness_config')
    ->where('business_data_id' , $request->business_data_id)
    ->where('type' , 'guards_navigation_bar')
    ->update($config_rows);
  }
  elseif($request->navigation_bar === 'job_roster_navigation_bar'){
    DB::connection('mysql2')->table('bussiness_config')
    ->where('business_data_id' , $request->business_data_id)
    ->where('type' , 'job_roster_navigation_bar')
    ->update($config_rows);
  }else{
    DB::connection('mysql2')->table('bussiness_config')
    ->insert($config_rows);
  }
}else{
  DB::connection('mysql2')->table('bussiness_config')
  ->insert($config_rows);
}



$config_arr = [];
$config_recods = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id'  , $request->business_data_id)->where('type' , 'navigation_bar')->get();
if(count($config_recods) > 0){
  foreach($config_recods as $data){
    $value = json_decode($data->records_business_navbar);
    array_push($config_arr , $value);
  }
}else{
  $val = json_encode(array(
    'administrator' => 1,
    'dashboard' => 1,
    'announcements_induction' => 1,
    'basics' => 1,
    'chat' => 1,
    'color_settings' => 1,
    'complete_paysheet' => 1,
    'contractor' => 1,
    'contractor_report' => 1,
    'customer' => 1,
    'message_icon' => 1,
    'guards_login' => 1,
    'customer_login' => 1,
    'contractor_login' => 1,
    'notification_icon' => 1,
    'division_consolidation' => 1,
    'email' => 1,
    'features' => 1,
    'guards' => 1,
    'incident_report_page' => 1,
    'invoice_report' => 1,
    'hour_report' => 0,
    'job_roster' => 1,
    'job_tracker' => 1,
    'leave_management' => 1,
    'log_user_activities' => 1,
    'notifications' => 1,
    'pay_rates' => 1,
    'permissions' => 1,
    'ph_settings' => 1,
    'quick_Paysheet' => 1,
    'report' => 1,
    'tasks_report' => 1,
    'time_clock' => 1,
    'site_list' => 1,
    'guard_license' => 1,
    'time_sheet' => 1,
    'charge_rates' => 1,
    'own_payrates' => 0,
    'categorized_payrates' => 0,
    'signin_out_report' => 0,
    'audit_report' => 0

  ));
  $value = json_decode($val);
  array_push($config_arr , $value);
}
Session()->put('config_recods' , $config_arr);

$config_arr1 = [];
$config_recods1 = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id'  , $request->business_data_id)->where('type' , 'job_roster_navigation_bar')->get();
if(count($config_recods1) > 0){
  foreach($config_recods1 as $data){
    $value1 = json_decode($data->records_business_navbar);
    array_push($config_arr1 , $value1);
  }
}else{
  $val1 = json_encode(array(
    'select_state' => 1,
    'select_customer' => 1,
    'select_sites' => 1,
    'action' => 1,
    'publish' =>1,
    'add_site' => 1,
    'ad_shift' => 1,
    'report' => 1,
    'add_guards' => 1,
    'job_roster_filter' => 1,
    'un_publish_site' => 1,
    'payroll' => 1,
    'job_instrcution_file' => 1,
    'coordinates' => 1,
    'copy_current_week' => 1,
    'copy_shifts' => 1,
    'clear_week' => 1,
    'unpublish_week' => 1,
    'unassign_week' => 1,
    'add_multiple_shifts' => 1,
    'rollover_this_week' => 1,
    'create_shift_button' => 1,
    'sign_in_detail' => 1,
    'sign_out_detail' => 1,
    'break_detail' => 1,
    'gree_call' => 1,
    'welfare_call' => 1,
    'tracker' => 1,
    'incident_report' => 1,
    'shift_task' => 1,
    'shift_activity' => 1,
    'operation_notes' => 1,
    'shift_colors' => 1,
    'site_type' => 1,
    'site_trained' => 1,
    'breaks' => 1,
    'welfare_calls' => 1,
    'site_hours' => 1,
    'charge_rates_and_level' => 1,
    'charge_rates_level' => 1,
    'charge_rates' => 1,
    'signin_radius' => 1,
    'radius_alert' => 1,
    'job_instrcutions' => 1,
    'sos_phone' => 1,
    'start_end_date' => 1,
    'tasks' => 1,
    'start_date' => 1,
    'end_date' => 1,
    'three_dots_shifts' => 1,
    'view_guards' => 1,
    'shift_site_name' => 1,
    'shift_guard_name' => 1,
    'shift_available_guard' => 1,
    'shift_paybale' => 1,
    'paid_by' => 1,
    'shift_start_time' => 1,
    'shift_end_time' => 1,
    'travel_time' => 1,
    'covid_marshal' => 1,
    'custom_payrates' => 0,
    'documents_bypass' => 0,
    

  ));
  $value1 = json_decode($val1);
  array_push($config_arr1 , $value1);
}

Session()->put('config_recods1' , $config_arr1);

      // guards_navigation_bar start

$config_arr2 = [];
$config_recods2 = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id'  , $request->business_data_id)->where('type' , 'guards_navigation_bar')->get();
if(count($config_recods2) > 0){
  foreach($config_recods2 as $data){
    $value2 = json_decode($data->records_business_navbar);
    array_push($config_arr2 , $value2);
  }
}else{
  $val2 = json_encode(array(
    'active_guards' => 1,
    'inactive_guards' => 1,
    'new_guards' => 1,
    'pending_guards' => 1,
    'deleted_guards' => 1,
    'add_guards' => 1,
    'site_trained' => 1,
    'guard_uniform' => 1,
    'guard_work_limitation' => 1,
    'leave_management' => 1,
    'select_customer' => 1,
    'gender' => 1,
    'dob' => 1,
    'postal_code' => 1,
    'state' => 1,
    'city' => 1,
    'suburb' => 1,
    'address' => 1,
    'guard_type' => 1,
    'password' => 1,
    'email' => 1,
    'profile_image' => 1,
    'coordinates' => 1,
    'emergency_contact_name' => 1,
    'emergency_contact_phone' => 1,


  ));
  $value2 = json_decode($val2);
  array_push($config_arr2 , $value2);
}

Session()->put('config_recods2' , $config_arr2);
      //guards_navigation_bar end
return back()->with('message', 'IT WORKS update!');
}
function get_bussiness(Request $request){
  $root = $_SERVER['HTTP_HOST'];
  $root = explode('.', $root);
  $sub_domain = 'staffingsolution';
  if($root[0] != 'wwww'){
    $sub_domain = $root[0];
  }else{
    $sub_domain = $root[1];
  }
  $config_data = DB::connection('mysql2')->table('business_data')->where('id',$request->id)->first();
  return response()->json(['result' =>  $config_data]);

}

function update_about_us(Request $request)
{
  if ($request->hasfile('about_files')) {
    $public_path = public_path();
    $public_path = str_replace('portal/public', '', $public_path);
    $public_path = str_replace('apis/public', '', $public_path);
    $path = $public_path . 'asset_uploads/';
    foreach ($request->file('about_files') as $file) {
      $name = $file->getClientOriginalName();
      $file->move($path, $name);
      $config_data['about_us_files'][] = $name;
    }
    $config_data['about_us_files'] = json_encode($config_data['about_us_files']);
  }

  $config_data['about_us'] = $request->about_us;
  $bussiness_data = DB::connection('mysql2')->table('business_data')->where('id', config('custom.domain_id'))->update($config_data);
  return response()->json(['success' => true]);

}

function delete_bussiness(Request $request){
  $root = $_SERVER['HTTP_HOST'];
  $root = explode('.', $root);
  $sub_domain = 'staffingsolution';
  if($root[0] != 'wwww'){
    $sub_domain = $root[0];
  }else{
    $sub_domain = $root[1];
  }
  $config_data = DB::connection('mysql2')->table('business_data')->where('id',$request->id)->delete();
  return response()->json(['success' => true, 'message' => "Bussiness Deleted successfully"]);
}


function update_bussiness(Request $request){
  $root = $_SERVER['HTTP_HOST'];
  $root = explode('.', $root);
  $sub_domain = 'staffingsolution';
  if($root[0] != 'wwww'){
    $sub_domain = $root[0];
  }else{
    $sub_domain = $root[1];
  }
  $config_data = [
    'email' => $request->email,
    'domain' => $request->domain,
    'title' => $request->title,
    'address' => $request->address,
    'business_type' => $request->business_type,
    'server_key' => $request->server_key,
    'app_id' => $request->app_id,
    'guard' => $request->guard,
    'about_us' => $request->about_us,
  ];
  if ($request->hasfile('about_files')) {
    $public_path = public_path();
    $public_path = str_replace('portal/public', '', $public_path);
    $public_path = str_replace('apis/public', '', $public_path);
    $path = $public_path . 'asset_uploads/';
    foreach ($request->file('about_files') as $file) {
      $name = $file->getClientOriginalName();
      $file->move($path, $name);
      $config_data['about_us_files'][] = $name;
    }
    $config_data['about_us_files'] = json_encode($config_data['about_us_files']);
  }
  if($request->logoUploaded  != null && $request->logoUploaded  != '') {
    $config_data['logo'] = $request->logoUploaded;
  }
  if ($request->bussiness_id!=null && $request->bussiness_id!='') {
    //   return  "yes";
    //     exit();
    $bussiness_data = DB::connection('mysql2')->table('business_data')->where('id',$request->bussiness_id)->update($config_data);
    return response()->json(['success' => true, 'message' => "Details update successfully"]);
  }else{
    $unique_id=rand ( 1000 , 9999 );
    $config_data['unique_id'] = $unique_id;
        // return config_data;
        // exit();
    $bussiness_data = DB::connection('mysql2')->table('business_data')->insert($config_data);

    return response()->json(['success' => true, 'message' => "Details Add successfully"]);
  }
}
public function bussiness_do_login(Request $request)
{
  $apikey = base64_encode(Str::random(64).time());
  $admin = DB::connection('mysql2')->table('administrators')->where(['email' => $request->email])->first();
    // return $request->email;
    // exit();
  if (Hash::check($request->input('password'), $admin->password)) {
    DB::connection('mysql2')->table('administrators')
    ->where('id', $admin->id)
    ->update(['auth_token' => $apikey,'last_login'=>date("Y-m-d H:i:s")]);
    session([
      'bussiness_userId' => $admin->id,
      'bussiness_userType' => 'admin', 
      'bussiness_image' => $admin->image,  
      'bussiness_userName' => $admin->name,  
      'bussiness_authToken' => $apikey,
      'bussiness_isAdmin' => $admin->is_super_admin,
      'bussiness_state' => $admin->state,
        // 'specific_sites' => $admin->specific_sites,
        // 'specific_customer' => $admin->specific_customer,

    ]);
    return  redirect('/bussiness_management');

  }else{
    return redirect('/login_bussiness');
  }

        // dd($request->session());
}
public function login_bussiness()
{
 if (!session()->has('bussiness_userType') || session::get('bussiness_userType') != 'admin') {
   return view('bussiness_do_login');
 }else{
   return redirect('/bussiness_management');
 }
}

function bussiness_do_logout(Request $request)
{
  $request->session()->flush();
  return redirect('login_bussiness');
}
public function approve_bussiness(Request $request)
{
  $root = $_SERVER['HTTP_HOST'];
  $root = explode('.', $root);
  $sub_domain = 'staffingsolution';
  if($root[0] != 'wwww'){
    $sub_domain = $root[0];
  }else{
    $sub_domain = $root[1];
  }
  $config_data = DB::connection('mysql2')->table('business_data')->where('id', $request->id)->update(['approve'=>1]);
  $bussiness_data = DB::connection('mysql2')->table('business_data')->where('id',$request->id)->first();
    // $bussiness_data = DB::connection('mysql2')->table('business_data')->where('id',8)->first();
    // print_r($request->id);
    // exit();
  $html='<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
  <head>
  <!--[if gte mso 9]>
  <xml>
  <o:OfficeDocumentSettings>
  <o:AllowPNG/>
  <o:PixelsPerInch>96</o:PixelsPerInch>
  </o:OfficeDocumentSettings>
  </xml>
  <![endif]-->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="x-apple-disable-message-reformatting">
  <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
  <title></title>

  <style type="text/css">
  table, td { color: #ffffff !important; } a { color: #0000ee; text-decoration: underline; } @media (max-width: 480px) { #u_content_image_2 .v-src-width { width: 432px !important; } #u_content_image_2 .v-src-max-width { max-width: 40% !important; } #u_content_image_5 .v-src-width { width: 100px !important; } #u_content_image_5 .v-src-max-width { max-width: 30% !important; } #u_content_image_6 .v-src-width { width: 100px !important; } #u_content_image_6 .v-src-max-width { max-width: 30% !important; } #u_content_image_4 .v-src-width { width: 100px !important; } #u_content_image_4 .v-src-max-width { max-width: 30% !important; } #u_content_image_9 .v-text-align { text-align: center !important; } #u_content_image_10 .v-text-align { text-align: center !important; } }
  @media only screen and (min-width: 620px) {
    .u-row {
      width: 600px !important;
    }
    .u-row .u-col {
      vertical-align: top;
    }
    
    .u-row .u-col-33p33 {
      width: 199.98px !important;
    }
    
    .u-row .u-col-50 {
      width: 300px !important;
    }
    
    .u-row .u-col-100 {
      width: 600px !important;
    }
    
  }

  @media (max-width: 620px) {
    .u-row-container {
      max-width: 100% !important;
      padding-left: 0px !important;
      padding-right: 0px !important;
    }
    .u-row .u-col {
      min-width: 320px !important;
      max-width: 100% !important;
      display: block !important;
    }
    .u-row {
      width: calc(100% - 40px) !important;
    }
    .u-col {
      width: 100% !important;
    }
    .u-col > div {
      margin: 0 auto;
    }
  }
  body {
    margin: 0;
    padding: 0;
  }

  table,
  tr,
  td {
    vertical-align: top;
    border-collapse: collapse;
  }

  p {
    margin: 0;
  }

  .ie-container table,
  .mso-container table {
    table-layout: fixed;
  }

    * {
  line-height: inherit;
}
a[x-apple-data-detectors="true"] {
  color: inherit !important;
  text-decoration: none !important;
}

@media (max-width: 480px) {
  .hide-mobile {
    max-height: 0px;
    overflow: hidden;
    display: none !important;
  }

}
</style>



</head>

<body class="clean-body u_body" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #ffffff;color: #000000">
<!--[if IE]><div class="ie-container"><![endif]-->
<!--[if mso]><div class="mso-container"><![endif]-->
<table style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #ffffff;width:100%" cellpadding="0" cellspacing="0">
<tbody>
<tr style="vertical-align: top">
<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color: #ffffff;"><![endif]-->


<div class="u-row-container" style="padding: 0px;background-color: transparent">
<div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #cea869;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: #cea869;"><![endif]-->

<!--[if (mso)|(IE)]><td align="center" width="600" style="width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<table height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #cea869;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
<tbody>
<tr style="vertical-align: top">
<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
<span>&#160;</span>
</td>
</tr>
</tbody>
</table>

</td>
</tr>
</tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>



<div class="u-row-container" style="padding: 0px;background-color: transparent">
<div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #000000;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: #cea869;"><![endif]-->

<!--[if (mso)|(IE)]><td align="center" width="300" style="width: 300px;padding: 0px 0px 0px 10px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-50" style="max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px 0px 0px 10px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->

<table id="u_content_image_2" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td class="v-text-align" style="padding-right: 0px;padding-left: 0px;" align="center">

<img align="center" border="0" src="http://247staffingsolutions.com.au/assets/images/logo/logo.png" alt="Logo" title="Logo" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 45%;max-width: 126px;" width="126" class="v-src-width v-src-max-width"/>

</td>
</tr>
</table>

</td>
</tr>
</tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>

</tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="300" style="width: 300px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-50" style="max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td class="v-text-align" style="padding-right: 0px;padding-left: 0px;" align="center">

<h1 class="v-text-align" style="margin: 0px; color: #black; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: arial black,avant garde,arial; font-size: 26px; margin-right:5px">
Welcome to 247 Staffing Solutions!
</h1>

</td>
</tr>
<tr>
<td style="width:100%">
<h4><b>Hi '.$bussiness_data->name.'</b>,
Your Trial is all set up and ready to use ! Click below to get started</h4>
</td>
</tr>
<tr>
<td style="width:100%">
<b>Username: admin@admin.com</b>
</td>
</tr>
<tr>
<td style="width:100%">
<b>Password: 123456</b>
</td>
</tr>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<br>
<a href="https://'.$bussiness_data->domain.'.247staffingsolutions.com.au/portal/"><img align="center" border="0" src="https://icon-library.com/images/free-trial-icon/free-trial-icon-4.jpg" alt="App Screen" title="App Screen" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 58%;max-width: 162.4px;" width="162.4" class="v-src-width v-src-max-width"/>
</a>
</td>
</tr>
</table>


</td>

</tr>
</tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>



<div class="u-row-container" style="padding: 0px;background-color: transparent; display: none !important;">
<div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: transparent;"><![endif]-->

<!--[if (mso)|(IE)]><td align="center" width="600" style="width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:0px;font-family:arial,helvetica,sans-serif;" align="left">

<table width="100%" cellpadding="0" cellspacing="0" border="0">

<tr>
<td class="v-text-align" style="padding-right: 0px;padding-left: 0px;" align="center">

<img align="center" border="0" src="images/image-10.jpeg" alt="line" title="line" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 600px;" width="600" class="v-src-width v-src-max-width"/>

</td>
</tr>
</table>

</td>
</tr>
</tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>



<div class="u-row-container" style="padding: 0px;background-color: transparent">
<div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #2d2d2d;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: black;"><![endif]-->

<!--[if (mso)|(IE)]><td align="center" width="200" style="width: 200px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-33p33" style="max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->

<table id="u_content_image_5" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td class="v-text-align" style="padding-right: 0px;padding-left: 0px;" align="center">

<img align="center" border="0" src="https://247staffingsolutions.com.au/assets/images/how/how1.png" alt="Powerful Feature" title="Powerful Feature" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 40%;max-width: 72px;" width="72" class="v-src-width v-src-max-width"/>

</td>
</tr>
</table>

</td>
</tr>
</tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:0px 10px;font-family:arial,helvetica,sans-serif;" align="left">

<h2 class="v-text-align" style="margin: 0px; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: arial,helvetica,sans-serif; font-size: 20px;color:white">
<strong>Download App</strong>
</h2>

</td>
</tr>
</tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<div class="v-text-align" style="line-height: 140%; text-align: center; word-wrap: break-word;">

</div>

</td>
</tr>
</tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="200" style="width: 200px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-33p33" style="max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->

<table id="u_content_image_6" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td class="v-text-align" style="padding-right: 0px;padding-left: 0px;" align="center">

<img align="center" border="0" src="https://247staffingsolutions.com.au/assets/images/how/how2.png" alt="Awesome Design" title="Awesome Design" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 40%;max-width: 72px;" width="72" class="v-src-width v-src-max-width"/>

</td>
</tr>
</table>

</td>
</tr>
</tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:0px 10px;font-family:arial,helvetica,sans-serif;" align="left">

<h2 class="v-text-align" style="margin: 0px; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: arial,helvetica,sans-serif; font-size: 20px;color:white">
<strong>Create Account</strong>
</h2>

</td>
</tr>
</tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<div class="v-text-align" style="line-height: 140%; text-align: center; word-wrap: break-word;">

</div>

</td>
</tr>
</tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="200" style="width: 200px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-33p33" style="max-width: 320px;min-width: 200px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->

<table id="u_content_image_4" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td class="v-text-align" style="padding-right: 0px;padding-left: 0px;" align="center">

<img align="center" border="0" src="https://247staffingsolutions.com.au/assets/images/how/how3.png" alt="Unlimited Support" title="Unlimited Support" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 40%;max-width: 72px;" width="72" class="v-src-width v-src-max-width"/>

</td>
</tr>
</table>

</td>
</tr>
</tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:0px 10px;font-family:arial,helvetica,sans-serif;" align="left">

<h2 class="v-text-align" style="margin: 0px; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: arial,helvetica,sans-serif; font-size: 20px;color:white">
<strong>Enjoy An App</strong>
</h2>

</td>
</tr>
</tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<div class="v-text-align" style="line-height: 140%; text-align: center; word-wrap: break-word;">

</div>

</td>
</tr>
</tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>



<div class="u-row-container" style="padding: 0px;background-color: transparent">
<div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #2d2d2d;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: black;"><![endif]-->

<!--[if (mso)|(IE)]><td align="center" width="600" style="width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->



<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<h1 class="v-text-align" style="margin: 0px; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: arial black,avant garde,arial; font-size: 20px;color:white">
Now Available At
</h1>

</td>
</tr>
</tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px 30px;font-family:arial,helvetica,sans-serif;" align="left">

<div class="v-text-align" style="line-height: 140%; text-align: center; word-wrap: break-word;">
<p style="font-size: 14px; line-height: 140%;"></p>
</div>

</td>
</tr>
</tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>



<div class="u-row-container" style="padding: 0px;background-color: transparent">
<div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #2d2d2d;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: black;"><![endif]-->

<!--[if (mso)|(IE)]><td align="center" width="300" style="width: 300px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-50" style="max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->

<table id="u_content_image_9" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td class="v-text-align" style="padding-right: 0px;padding-left: 0px;" align="right">
<a href="https://play.google.com/store/apps/details?id=au.com.securitygroup.app" target="_blank">
<img align="right" border="0" src="http://assets.stickpng.com/images/5a902dbf7f96951c82922875.png" alt="Google Play" title="Google Play" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 60%;max-width: 168px;" width="168" class="v-src-width v-src-max-width"/>
</a>
</td>
</tr>
</table>

</td>
</tr>
</tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="300" style="width: 300px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-50" style="max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->

<table id="u_content_image_10" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td class="v-text-align" style="padding-right: 0px;padding-left: 0px;" align="left">
<a href="https://apps.apple.com/pk/app/247-staffing-solutions/id1576478790" target="_blank">
<img align="left" border="0" src="https://www.familybankonline.com/wp-content/uploads/2017/07/apple-app-store-badge.png" alt="App Store" title="App Store" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 60%;max-width: 168px;" width="168" class="v-src-width v-src-max-width"/>
</a>
</td>
</tr>
</table>

</td>
</tr>
</tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>



<div class="u-row-container 1" style="padding: 0px;background-color: transparent">
<div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #2d2d2d;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: black;"><![endif]-->

<!--[if (mso)|(IE)]><td align="center" width="600" style="width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->



<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>



<div class="u-row-container" style="padding: 0px;background-color: transparent; display: none !important;">
<div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #41a186;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: #41a186;"><![endif]-->

<!--[if (mso)|(IE)]><td align="center" width="600" style="width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:0px;font-family:arial,helvetica,sans-serif;" align="left">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td class="v-text-align" style="padding-right: 0px;padding-left: 0px;" align="center">

<img align="center" border="0" src="images/image-14.jpeg" alt="line" title="line" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 600px;" width="600" class="v-src-width v-src-max-width"/>

</td>
</tr>
</table>

</td>
</tr>
</tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<h1 class="v-text-align" style="margin: 0px; color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: arial black,avant garde,arial; font-size: 22px;">
App Screens
</h1>

</td>
</tr>
</tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td class="v-text-align" style="padding-right: 0px;padding-left: 0px;" align="center">

<img align="center" border="0" src="images/image-15.png" alt="App Screens" title="App Screens" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 90%;max-width: 522px;" width="522" class="v-src-width v-src-max-width"/>

</td>
</tr>
</table>

</td>
</tr>
</tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:20px 10px;font-family:arial,helvetica,sans-serif;" align="left">

<table height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #41a186;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
<tbody>
<tr style="vertical-align: top">
<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
<span>&#160;</span>
</td>
</tr>
</tbody>
</table>

</td>
</tr>
</tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>



<div class="u-row-container" style="padding: 0px;background-color: transparent">
<div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #2d2d2d;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: black;"><![endif]-->

<!--[if (mso)|(IE)]><td align="center" width="300" style="width: 300px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-50" style="max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->



<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<div align="center">
<div style="display: table; max-width:194px;">
<!--[if (mso)|(IE)]><table width="194" cellpadding="0" cellspacing="0" border="0"><tr><td style="border-collapse:collapse;" align="center"><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace: 0pt;mso-table-rspace: 0pt; width:194px;"><tr><![endif]-->


<!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 7px;" valign="top"><![endif]-->
<!--[if (mso)|(IE)]></td><![endif]-->

<!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 7px;" valign="top"><![endif]-->
<!--[if (mso)|(IE)]></td><![endif]-->

<!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 7px;" valign="top"><![endif]-->
<!--[if (mso)|(IE)]></td><![endif]-->

<!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 7px;" valign="top"><![endif]-->
<!--[if (mso)|(IE)]></td><![endif]-->

<!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 0px;" valign="top"><![endif]-->
<!--[if (mso)|(IE)]></td><![endif]-->


<!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
</div>
</div>

</td>
</tr>
</tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:0px 10px 10px;font-family:arial,helvetica,sans-serif;" align="left">

<div class="v-text-align" style="color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word;">
<p style="font-size: 14px; line-height: 140%;">Call: 1300 550 401</p>
<p style="font-size: 14px; line-height: 140%;">Email: <b>info@247staffingsolutions.com.au</b></p>
</div>

</td>
</tr>
</tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]><td align="center" width="300" style="width: 300px;padding: 0px;border-top: 0px solid <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>



<div class="u-row-container" style="padding: 0px;background-color: transparent">
<div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: black;">
<div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: black;"><![endif]-->

<!--[if (mso)|(IE)]><td align="center" width="600" style="width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
<div style="width: 100% !important;">
<!--[if (!mso)&(!IE)]><!--><div style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr>
<td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">

<div class="v-text-align" style="color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word;">
</div>
</td>
</tr>
</tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>


<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<!--[if mso]></div><![endif]-->
<!--[if IE]></div><![endif]-->
</body>

</html>
';
    // echo $html;
    // exit();
$subject='Welcome to 247 Staffing Solutions';
$this->sendGuardMail($bussiness_data, $subject, $html);
    // exit();
return response()->json(['success' => true, 'message' => "Bussiness Approved Successfully"]);
}


function sendGuardMail($user, $subject, $email_message) {

  $root= $_SERVER['HTTP_HOST'];
  $root = explode('.', $root);
  $postfix = 'staffingsolution';
  if($root[0] != 'wwww'){
    $postfix = $root[0];
  }else{
    $postfix = $root[1];
  }
    // $otherdb =DB::connection('otherDB', TRUE);
    // $config_data = $otherdb->get_where('business_data', array('domain' => $postfix), 1, 0)->row_array();
  $config_title = config('custom.title');   

  $to = $user->email;
      // $to="moiz@247staffingsolutions.com.au";

  $subject = $subject;

      // $from = 'no-reply@'.$_SERVER['HTTP_HOST'];
  $from = $postfix.'@247staffingsolution.com.au';

    //   $logo1 = config('custom.logo');
  $logo1=''.config('custom.logo').'';
    //   $logo2 = base_url("files/email-template/ASIAL-Member-Logo-11.png");

    //   $logo3 = base_url("files/email-template/labour-hire-authority-post-banner-1.jpg");



// To send HTML mail, the Content-type header must be set

  $headers  = 'MIME-Version: 1.0' . "\r\n";

  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



// Create email headers

  $headers .= 'From: '.$from."\r\n".

  'Reply-To: '.$from."\r\n" .

  'X-Mailer: PHP/' . phpversion();

      // $message = 'Hello '. $user->name . ',<br><br>';

  $message = $email_message.'<br><br>';


  try{
    mail($to, $subject, $message, $headers);
  }catch(Exception $e)
  {

  }


}

public function log_user_activity($action,$data, $admin_id = 0)
{
    # code...
  DB::table('log_user_activities')->insert([
    'action' => $action,
    'user_id' => $admin_id != 0 ? $admin_id : (session()->has('userId') ? session()->get('userId') : 0),
    'user_type' => session()->has('userType') ? session()->get('userType') : 'admin',
    'data' => json_encode($data)
  ]);
  return true;
}

public function fetch_log_user_activity(Request $request)
{
  if(session()->get('isAdmin') == 1){
   $log= DB::table('log_user_activities')->join('administrators','log_user_activities.user_id','=','administrators.id')->select(
     'administrators.name AS user',
     'log_user_activities.created_at',
     'log_user_activities.action' 
   );
 }else{
   $log= DB::table('log_user_activities')->join('administrators','log_user_activities.user_id','=','administrators.id')->select(
    'administrators.name AS user',
    'log_user_activities.created_at',
    'log_user_activities.action' 
  )->where('log_user_activities.user_id',session()->get('userId'));
 }
 if($request->has('search')){
  $date=$request->search;
  $from_to = explode("-", $date);
  $from= $from_to[0];
  $to= $from_to[1];
  $timestamp = strtotime($from);
  $timestamp_to = strtotime($to);
  $from = date("Y-m-d H:i", $timestamp);
  $to = date("Y-m-d H:i", $timestamp_to);
  $log=$log->whereBetween('log_user_activities.created_at',[$from, $to])->get();
  foreach($log as $l){
    $l->created_at=date("d-m-y H:i",strtotime($l->created_at));
  }
  return $log;
}else{
  $log=$log->where('log_user_activities.created_at', '>=', Carbon::today())->get();
  return view('admin/log_user_activities',['logs' => $log]);
}

}

public function getAdminsList()
{
  $admin = DB::table('administrators')->where('id', '!=', session()->get('userId'))->select('id', 'name')->get();
  return response()->json(['admins' => $admin]);
}
public function GetActivityLog(Request $request)
{
  return $this->activity_log($request, 'api');
}
public function user_activity_log(Request $request, $call_from = null)
{
  $admin = DB::table('administrators')->where('id', session()->get('userId'))->first();
  $admins = DB::table('administrators')->where('id', '!=', session()->get('userId'))->where('status', 'active')->select('id', 'name')->get();

  return view('admin/user_activity_log', compact('admin', 'admins'));
}
public function activity_log(Request $request, $call_from = null)
{
  $activity = $this->fetch_activity_log($request);
  foreach ($activity as $key => $act) {
    // $act->current_data = array();
    $data = json_decode($act->data, true);
    if ($act->action == 'shift_add' || $act->action == 'shift_change' || $act->action == 'shift_delete' || $act->action == 'shift_drag_copy') {
      $guard_id = !empty($data) ? (isset($data[0]) ? $data[0]['guard_id'] : $data['guard_id']) : 0;
      $site_id = !empty($data) ? (isset($data[0]) ? $data[0]['site_id'] : $data['site_id']) : 0;
      $roster_id = !empty($data) ? (isset($data[0]) ? $data[0]['roster_id'] : $data['roster_id']) : 0;
      $site = DB::table('jobs')->where('id', $site_id)->select('site_name','site_description')->first();
      $guard = DB::table('guards')->where('id', $guard_id)->select('name')->first();
      if (empty($guard)) {
        $act->guard_name = 'N/A';
      }else{
        $act->guard_name = $guard->name;
      }
      if (empty($site)) {
        $act->site = 'N/A';
      }else{
        $act->site = $site->site_name.' ('.$site->site_description.')';
      }
      if ($act->action == 'shift_add' || $act->action == 'shift_change' ){
        $act->current_data = DB::table('job_new_roster')->where('roster_id', $roster_id)->first();
      }
    }
    $dat = isset($data[0]) ? $data[0] : $data;
    $act->act_data = $dat;
  }
  $admin_id = $request->has('admin_id') ? ((is_array($request->admin_id)) ? $request->admin_id : explode(',',$request->admin_id)) : array();
  $date = $request->has('search') ? $request->search : '';
  $search = $request->has('search') ? $request->search : '';
  $admin = DB::table('administrators')->where('id', session()->get('userId'))->first();
  $admins = DB::table('administrators')->where('id', '!=', session()->get('userId'))->where('status', 'active')->select('id', 'name')->get();
  if ($call_from == 'api') {
      // if (count($results) > 0) {
    return response()->json(['status' => true, 'message' => 'Data found', 'data' => compact('admin', 'activity', 'admins', 'admin_id', 'search', 'date')]);
      // }else{
        // return response()->json(['status' => false, 'message' => 'No data found!']);
      // }
  }else{
    // return view('admin/activity_log', compact('admin', 'activity', 'admins', 'admin_id', 'search', 'date'));
    $html =  view('admin/activity_log', compact('admin', 'activity', 'admins', 'admin_id', 'search', 'date'))->render();
    return response()->json(['status' => true, 'message' => 'Data found', 'data' => $html]);
  }
}
public function fetch_activity_log(Request $request)
{
  if ($request->has('admin_id') && $request->admin_id != '') {
    if (is_array($request->admin_id)) {
      $admin_id = $request->admin_id; 
    }else{
      $admin_id = explode(',', $request->admin_id);
    }
    $log= DB::table('log_user_activities')->join('administrators','log_user_activities.user_id','=','administrators.id')->select(
      'administrators.name AS user',
      'log_user_activities.created_at',
      'log_user_activities.data',
      'log_user_activities.action' 
    )->where(function($query) use ($admin_id){
      foreach ($admin_id as $key => $id) {
        if ($key == 0) {
          $query->where('log_user_activities.user_id',$id);
        }else{
          $query->orWhere('log_user_activities.user_id',$id);
        }
      }
    });
  }elseif(session()->has('is_admin') && session()->get('isAdmin') == 1){
   $log= DB::table('log_user_activities')->join('administrators','log_user_activities.user_id','=','administrators.id')->select(
     'administrators.name AS user',
     'log_user_activities.created_at',
     'log_user_activities.data',
     'log_user_activities.action' 
   );
 }else{
   $temp1 = DB::table('log_user_activities')->join('administrators','log_user_activities.user_id','=','administrators.id')->select(
    'administrators.name AS user',
    'log_user_activities.created_at',
    'log_user_activities.data',
    'log_user_activities.action' 
  );
   if(session()->has('userId')) {
    $temp1->where('log_user_activities.user_id', session()->get('userId'));
  }
  $log = $temp1->orderBy('created_at', 'desc');
}
if ($request->has('sort_by') && !empty($request->sort_by)) {
  $sort_by = $request->sort_by;
  $log->where(function($query) use ($sort_by){
    foreach ($sort_by as $key => $sb) {
      if ($key == 0) {
        $query->where('log_user_activities.action',$sb);
      }else{
        $query->orWhere('log_user_activities.action',$sb);
      }
    }
  });
}
if($request->has('search')){
  $date=$request->search;
  $from_to = explode("-", $date);
  $from= $from_to[0];
  $to= $from_to[1];

  $timestamp = strtotime($from);
  $timestamp_to = strtotime($to);
  if ($to == $from) {
            // $timestamp_to = $timestamp_to + 60*60*24;
  }
  $from = date("Y-m-d H:i", $timestamp);
  $to = date("Y-m-d 23:59:59", $timestamp_to);
  $log = $log
  ->whereBetween('log_user_activities.created_at',[$from, $to])
  ->orderBy('created_at', 'desc')->get();
  foreach($log as $l){
    $l->created_at=date("d-m-y H:i",strtotime($l->created_at));
  }
  return $log;
}else{
  $log = $log->where('log_user_activities.created_at', '>=', Carbon::today())->orderBy('created_at', 'desc')->get();
  foreach($log as $l){
    $l->created_at=date("d-m-y H:i",strtotime($l->created_at));
  }
  return $log;
}

}
function ph(Request $request)
{
  $availability = array();
  $start = explode('T', $request->start);
  $end = explode('T', $request->end);
  $start = strtotime($start[0]);
  $end = strtotime($end[0]);
  $states_array = array(
    'Victoria' => 'vic',
    'NSW' => 'nsw',
    'Queensland' => 'qld',
    'Tasmania' => 'tas',
    'Western Australia' => 'wa',
    'South Australia' => 'sa',
    'ACT' => 'act'
  );
if(isset($request->state)){
    $request->state = ($request->state == 'Victoria') ? 'vic' : 
    (($request->state == 'New South Wales') ? 'nsw' : 
    (($request->state == 'Queensland') ? 'qld' : 
    (($request->state == 'Tasmania') ? 'tas' : 
    (($request->state == 'Western Australia') ? 'wa' : 
    (($request->state == 'South Australia') ? 'sa' : 
    (($request->state == 'ACT') ? 'act' : $request->state))))));
  }
//   $state_value = strtolower($request->state);
// $flipped_states_array = array_flip($states_array);
$state = $request->state;

  $result = DB::table('public_holidays')
  ->where('state', $state)
  ->where('date', '>=', date('Ymd', $start))
  ->where('date', '<=', date('Ymd', $end))
  ->get();
  foreach ($result as $key => $value) {
    $value->date = date('Y-m-d', strtotime($value->date));
    $data['id'] = $value->id;
    $data['color'] = "#92D050";
    $data['className'] = 'custom-color-red-orange';
    $data['textColor'] = "#000";
    $data['color'] = "#FF7F7F";
    $data['title'] = $value->holiday_name;
    $data['start_time'] = $value->date;
    $data['tooltip'] = $value->information;
            // $data['className'] = $data['className'] . ' custom-roster-'.$value->roster_id;
    $data['description'] = $value->information;
    $data['start'] = $value->date;
    $data['end'] = $value->date;
    array_push($availability, $data);

  }
  return response()->json($availability);
}
function geteditPHForm(Request $request)
{
  $data['ph'] = DB::table('public_holidays')->where('id', $request->event_id)->first();
  $formHtml = view('admin/modals/editPHForm', $data)->render();
  return response()->json($formHtml);
}

function updatePH(Request $request)
{
  $data = array(
    'holiday_name' => $request->holiday_name,
    'date' => date('Ymd', strtotime($request->date)),
    'information' => $request->holiday_information
  );
  $updated = DB::table('public_holidays')->where('id', $request->id)->update($data);
  if ($updated) {
    return response()->json(['success' => true, 'message' => 'Public Holiday update successfully.']);
  }else{
    return response()->json(['success' => false, 'message' => 'Fail to update Public Holiday!']);
  }
}
function getaddPHForm(Request $request)
{
  $data['start'] = $request->start;
  $data['state'] = $request->state;
  $formHtml = view('admin/modals/addPHForm', $data)->render();
  return response()->json($formHtml);
}
function addPH(Request $request)
{
  $states_array = array(
    'Victoria' => 'vic',
    'NSW' => 'nsw',
    'Queensland' => 'qld',
    'Tasmania' => 'tas',
    'Western Australia' => 'wa',
    'South Australia' => 'sa',
    'ACT' => 'act'
  );
if(isset($request->state)){
    $request->state = ($request->state == 'Victoria') ? 'vic' : 
    (($request->state == 'New South Wales') ? 'nsw' : 
    (($request->state == 'Queensland') ? 'qld' : 
    (($request->state == 'Tasmania') ? 'tas' : 
    (($request->state == 'Western Australia') ? 'wa' : 
    (($request->state == 'South Australia') ? 'sa' : 
    (($request->state == 'ACT') ? 'act' : $request->state))))));
  }

// $state_value = strtolower($request->state);
// $flipped_states_array = array_flip($states_array);
    // $state = $flipped_states_array[$state_value];
    $state = $request->state;

  $data = array(
    'holiday_name' => $request->holiday_name,
    'date' => date('Ymd', strtotime($request->date)),
    'information' => $request->holiday_information,
    'state' => $state
  );

  $updated = DB::table('public_holidays')->insert($data);
  if ($updated) {
    return response()->json(['success' => true, 'message' => 'Public Holiday add successfully.']);
  }else{
    return response()->json(['success' => false, 'message' => 'Fail to add Public Holiday!']);
  }
}

function deletePH(Request $request)
{

  $updated = DB::table('public_holidays')->where('id', $request->id)->delete();
  if ($updated) {
    return response()->json(['success' => true, 'message' => 'Public Holiday delete successfully.']);
  }else{
    return response()->json(['success' => false, 'message' => 'Fail to delete Public Holiday!']);
  }
}
public function update_portal_colors(Request $request)
{
  $colors = array(
    'primary_background' => $request->primary_background,
    'primary_color' => $request->primary_color,
    'secondary_background' => $request->secondary_background,
    'pending_shifts' => $request->pending_shifts,
    'rejected_shifts' => $request->rejected_shifts,
    'publish_shifts' => $request->publish_shifts,
    'unpublish_shifts' => $request->unpublish_shifts,
    'mock_shifts' => $request->mock_shifts,
    'missed_shifts' => $request->missed_shifts,
    'uncoverd_shifts' => $request->uncoverd_shifts,
    'operational_notes_shifts' => $request->has('operational_notes_shifts') ?  $request->operational_notes_shifts : '',
    'UnPub_fea_color' => $request->has('UnPub_fea_color') ?  $request->UnPub_fea_color : '',
  );
  $data['users_emails'] = json_encode($colors);
  $check = DB::table('portal_settings')->where('permission_name', 'portal_colors')->first();
  if (empty($check)) {
    $data['permission_name'] = 'portal_colors';
    $data['permission'] = 1;
    DB::table('portal_settings')->insert($data);
  }else{
    DB::table('portal_settings')->where('permission_name', 'portal_colors')->update($data);
  }
  return response()->json(['success' => true, 'message' => 'Data save successfully.']);
}

public function about_us()
{
  $about_us = DB::connection('mysql2')->table('business_data')->where('id'  , config('custom.domain_id'))->select('about_us', 'about_us_files')->first();
  $about_us_files = DB::connection('mysql2')->table('about_us_files')->where('domain_id'  , config('custom.domain_id'))->get();
  $about_us->about_us_files = $about_us->about_us_files != '' ? json_decode($about_us->about_us_files, true) : array();
  return view('about_us',['about_us' =>  $about_us, 'files' => $about_us_files]);
}
public function getMoreInputs()
{
  $html = view('moreInput')->render();
  return response()->json($html);
}

function add_about_us_file(Request $request)
{
  $data['file_name'] = $request->file_name;
  $data['expiry'] = $request->file_expiry;
  $data['domain_id'] = config('custom.domain_id');
  $data['admin_id'] = session()->has('userId') ? session()->get('userId') : 0;
  if ($request->hasfile('file')) {
    $public_path = public_path();
    $public_path = str_replace('portal/public', '', $public_path);
    $public_path = str_replace('apis/public', '', $public_path);
    $path = $public_path . 'asset_uploads/';
    $file = $request->file('file');
    $filename = time() . $file->getClientOriginalName();
    $file->move($path, $filename);
    $data['file'] = $filename;
  }
  $bussiness_data = DB::connection('mysql2')->table('about_us_files')->insert($data);
  return response()->json(['success' => true]);

}
public function deleteAboutFile($id)
{
   DB::connection('mysql2')->table('about_us_files')->where('id', $id)->update(['file' => '']);
  return response()->json(['success' => true]);
  
}
public function deleteAboutFilePer($id)
{
   DB::connection('mysql2')->table('about_us_files')->where('id', $id)->delete();
  return response()->json(['success' => true]);
}
public function update_about_us_file(Request $request)
{
    $public_path = public_path();
    $public_path = str_replace('portal/public', '', $public_path);
    $public_path = str_replace('apis/public', '', $public_path);
    $path = $public_path . 'asset_uploads/';
    $file = $request->file('file');
    $filename = time() . $file->getClientOriginalName();
    $file->move($path, $filename);
   DB::connection('mysql2')->table('about_us_files')->where('id', $request->file_id)->update(['file' => $filename]);
  return response()->json(['success' => true]);
}

}