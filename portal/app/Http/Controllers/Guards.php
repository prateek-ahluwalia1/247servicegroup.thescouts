<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Guard as guard;
use App\Models\guard_files;
use App\Models\Guard_id as guard_ids;
use App\Models\Guard_payroll_id as guard_payroll_ids;
use App\Models\Guard_payrate as guard_payrate;
use App\Models\Guard_site_trained as guard_site_trained;
use App\Models\Guard_sites_blocked as guard_sites_blocked;
use App\Models\Job_new_roster as job_new_roster;
use App\Models\Job_roster_activities as job_roster_activities;
use App\Models\Customer as customer;
use App\Models\Notifications as notification;
use App\Models\Job as job;
use App\Models\ProfileLogs;
use Illuminate\Support\Facades\DB;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\Payrate as payrate;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Administrator as administrator;
use Carbon\Carbon;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\GenericMail;
use Stevebauman\Location\Facades\Location;

class Guards extends Controller
{

    public $guard_model;
    public $notification_model;
    public  $administrator;
    public  $profileLogs;
    protected $timezone = array(
        'Victoria' => 'Australia/Melbourne',
        'New South Whales' => 'Australia/Sydney',
        'New South Wales' => 'Australia/Sydney',
        'Queensland' => 'Australia/Brisbane',
        'Tasmania' => 'Australia/Hobart',
        'Western Australia' => 'Australia/Perth',
        'South Australia' => 'Australia/Adelaide',
        'ACT' => 'Australia/Canberra'
    );
    public function __construct(Request $request, guard $guard_model, notification $notification_model, administrator $administrator, ProfileLogs $profileLogs)
    {
        $this->guard_model = $guard_model;
        $this->notification_model = $notification_model;
        $this->administrator = $administrator;
        $this->profileLogs = $profileLogs;
    }


    public function login()
    {
        return view('guard/guard_login');
    }

    public function do_login(Request $request)
    {

        $apikey = base64_encode(Str::random(64) . time());
        $guard = guard::where(['email' => $request->input('email')])->first();
        if (!empty($guard) && Hash::check($request->input('password'), $guard->password)) {
            guard::where('id', $guard->id)->update(['auth_token' => $apikey]);
            // dd($guard);
            session([
                'userId' => $guard['id'],
                'userType' => 'guard',
                'image' => $guard['image'],
                'userName' => $guard['name'],
                'authToken' => $apikey
            ]);
             return redirect('/guard_profile'. '/' .session::get('userId'))->with('msg', 'Login successfully!');

            // return response()->json(['success' => true, 'guard_ID' =>  $guard['id'], 'message' => 'Login successfully']);
        } else {
            // return response()->json(['success' => false, 'message' => 'Invalid Login Details']);
            return redirect('/guard')->with('msg', 'Invalid Login Details');
        }
    }


    public function forgot_password()
    {
        return view('guard/forgot_password');
    }

    public function guard_reset_password(Request $request)
    {
        $apikey = base64_encode(Str::random(64) . time());
        $guard = guard::where('email', $request->email)->first();
        guard::where('id', $guard->id)->update(['auth_token' => $apikey]);

        $email_html = view('emails/guard/forgot_password', ['guard' => $guard, 'token' => $apikey])->render();
        // $this->notification_model->sendEmail($guard->email, 'Password Reset', $email_html);
        Mail::to($guard->email)->send(new GenericMail($guard, $email_html, 'Password Reset'));
        return redirect('guard_forgot_email_success/' . $request->email);
    }

    function guard_forgot_email_success($email)
    {
        return view('guard/after_forgot_password', ['email' => $email]);
    }

    function reset_gaurd_password($token)
    {
        $guard = guard::where('auth_token', $token)->first();
        if (!empty($guard)) {
            return view('/guard/reset_password_guard', ['guard' => $guard]);
        } else {
            // return redirect('not_found');
            return redirect('/guard');
        }
    }
    public function update_guard_password(Request $request)
    {
        $apikey = base64_encode(Str::random(64) . time());
        $password = Hash::make($request->password);
        $guard = guard::where('id', $request->guard_id)->first();
        $result = guard::where('id', $request->guard_id)->update(['auth_token' => $apikey, 'password' => $password]);
        $email_html = view('emails/guard/password_change', ['guard' => $guard])->render();
        // $this->notification_model->sendEmail($guard->email, 'Password Changed', $email_html);
        Mail::to(users: $guard->email)->send(new GenericMail($guard, $email_html, 'Password Changed'));
        return response()->json(['success' => true, 'message' => $request]);
    }

    function test_email()
    {
        $guard = guard::where('email', 'moizalig16@gmail.com')->first();
        $email_html = view('emails/guard/password_change', ['guard' => $guard])->render();
        // $result = $this->notification_model->sendEmail($guard->email, 'Password Changed', $email_html);
        Mail::to('abdulsamad.idenbrid@gmail.com')->send(new GenericMail('samad', $email_html, 'Test Mail'));

        return response()->json(['success' =>true, 'message' => 'Done']);
    }

    public function guards(Request $request)
    {

        Session::forget('guards_navigation_bar');
        Session::forget('config_arr_job_roster');
        $config_job_roster = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id', config('custom.domain_id'))->where('type', 'job_roster_navigation_bar')->get();
        // dd($config_job_roster);
        $config_arr_job_roster = [];
        foreach ($config_job_roster as $job_roster) {
            $val = json_decode($job_roster->records_business_navbar);
            array_push($config_arr_job_roster, $val);
        }
        Session()->put('config_arr_job_roster', $config_arr_job_roster);
        $config_recods = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id', config('custom.domain_id'))->where('type', 'guards_navigation_bar')->first();
        //    dd($config_recods);

        $guards_navigation_bar = [];
        $value = !empty($config_recods) ? json_decode($config_recods->records_business_navbar) : array();
        array_push($guards_navigation_bar, $value);

        Session()->put('guards_navigation_bar', $guards_navigation_bar);

        if (!session()->has('userType')) {
            return view('admin/login');
        } elseif (session()->get('userType') == 'administrator' || session()->get('userType') == 'admin') {

            if ($request->status == 'active') {
                if (isset($value->active_guards)  && $value->active_guards == 1) {
                    $active_guards =  DB::table('guards')->where('status', 'active')
                    ->orderBy('name', 'ASC')->get();
                } else {
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
                }

                foreach ($active_guards as $guard) {
                    $guard->dob = date('d-m-Y', strtotime($guard->dob));
                    $guard->last_login = date('d-m-Y H:i', strtotime($guard->last_login));
                }

                return view('admin/guard/guards', ['guards' => $active_guards]);
            } elseif ($request->status == 'inactive') {
                $inactive_guards =  DB::table('guards')
                ->where('status', 'active')
                ->where('admin_approved', 0)
                ->where('is_approved', 'yes')
                ->where('address', '!=', '')
                    // ->where('gender','!=','')
                ->where('phone', '!=', '')
                ->where('name', '!=', '')
                ->where('name', '!=', null)
                    // ->where('email','!=','')
                    // ->where('email','!=',null)
                    // ->where('emergency_contact_phone','!=','')
                ->where('security_license_number', '!=', '')
                ->where('security_license_file', '!=', '')
                    // ->where('payroll_bank_account_number','!=','')
                    // ->where('payroll_bank_name','!=','')
                ->orderBy('name', 'ASC')->get();

                foreach ($inactive_guards as $guard) {
                    $guard->dob = date('d-m-Y', strtotime($guard->dob));
                    $guard->last_login = date('d-m-Y H:i', strtotime($guard->last_login));
                }
                return view('admin/guard/guards', ['guards' => $inactive_guards]);
            } elseif ($request->status == 'pending') {
                $pending_guards =  DB::table('guards')
                ->where('status', 'inactive')
                ->where('is_approved', 'yes')
                ->where('address', '!=', '')
                ->where('phone', '!=', '')
                ->where('name', '!=', '')
                ->where('name', '!=', null)
                ->where('email', '!=', '')
                ->where('email', '!=', null)
                    // ->where('state','!=','')
                    // ->where('gender','!=','')
                    // ->where('gender','!=','null')
                    // ->where('gender','!=',null)
                    // ->where('emergency_contact_phone','!=','')
                    // ->where('emergency_contact_phone','!=', 'null')
                    // ->where('emergency_contact_phone','!=', null)
                ->where('security_license_number', '!=', '')
                ->where('security_license_number', '!=', 'null')
                ->where('security_license_number', '!=', null)
                ->where('security_license_file', '!=', '')
                ->where('security_license_file', '!=', 'null')
                ->where('security_license_file', '!=', null)
                    // ->where('payroll_bank_account_number','!=','')
                    // ->where('payroll_bank_account_number','!=','null')
                    // ->where('payroll_bank_account_number','!=', null)
                    // ->where('payroll_bank_name','!=','')
                    // ->where('payroll_bank_name','!=', 'null')
                    // ->where('payroll_bank_name','!=', null)
                ->orderBy('name', 'ASC')->get();
                foreach ($pending_guards as $guard) {
                    $guard->dob = date('d-m-Y', strtotime($guard->dob));
                    $guard->last_login = date('d-m-Y H:i', strtotime($guard->last_login));
                }
                return view('admin/guard/guards', ['guards' => $pending_guards]);
            } elseif ($request->status == 'new') {
                $new_guards =  DB::table('guards')
                ->where('status', '!=', 'deleted')
                    // ->where('admin_approved','=', 0)
                    // ->where('status','=', 'inactive')
                ->where(function ($query1) {
                    $query1->where('admin_approved', '=', 0)
                    ->orWhere('is_approved', '=', 'no')
                    ->orWhere('status', '=', 'inactive');
                })
                    // ->where('status','=', 'inactive')
                    //    ->where('admin_approved','=', 1)
                    // ->where('is_approved','=', 'no')
                ->where(function ($query) {
                        // $query->where('status','=', 'inactive')
                        // $query->where('admin_approved','=', 0)
                    $query->where('address', '')
                            // ->orWhere('is_approved','no')
                            // ->where('status','=', 'active')
                    ->orWhere('address', null)
                    ->orWhere('address', 'null')
                    ->orWhere('coordinates', 'null')
                    ->orWhere('coordinates', null)
                    ->orWhere('coordinates', '')
                    ->orWhere('is_approved', '=', 'no')
                            // ->orWhere('gender','')
                            // ->orWhere('gender','null')
                            // ->orWhere('gender',null)
                            // ->orWhere('is_approved','no')
                            // ->orWhere('emergency_contact_phone','')
                            // ->orWhere('emergency_contact_phone', null)
                            // ->orWhere('emergency_contact_phone','null')
                            // ->orWhere('state','')
                    ->orWhere('security_license_number', '')
                    ->orWhere('security_license_number', 'null')
                    ->orWhere('security_license_number', null)
                    ->orWhere('security_license_file', '')
                    ->orWhere('security_license_file', 'null')
                    ->orWhere('security_license_file', null);
                        // ->orWhere('payroll_bank_account_number','')
                        // ->orWhere('payroll_bank_account_number','null')
                        // ->orWhere('payroll_bank_account_number',null)
                        // ->orWhere('payroll_bank_name','')
                        // ->orWhere('payroll_bank_name','null')
                        // ->orWhere('payroll_bank_name',null);

                })
                    // ->orWhere('is_approved', '!=', 'yes')

                ->orderBy('name', 'ASC')->get();
                foreach ($new_guards as $guard) {
                    $guard->dob = date('d-m-Y', strtotime($guard->dob));
                    $guard->last_login = date('d-m-Y H:i', strtotime($guard->last_login));
                }
                return view('admin/guard/guards', ['guards' => $new_guards]);
            } else {
                $deleted_guards =  DB::table('guards')->where('status', 'deleted')->orderBy('name', 'ASC')->get();
                foreach ($deleted_guards as $guard) {
                    $guard->dob = date('d-m-Y', strtotime($guard->dob));
                    $guard->last_login = date('d-m-Y H:i', strtotime($guard->last_login));
                }
                return view('admin/guard/guards', ['guards' => $deleted_guards]);
            }
        } elseif (session()->get('userType') == 'customer') {
            $ids = [''.session()->get('userId').''];

            $guards = DB::table('guards')
            // ->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')
            // ->join('jobs', 'jobs.id', '=', 'jobs_guards.job_id')
            ->where('guards.status', 'active')
            // ->where('jobs.customer_id', session()->get('userId'))
            ->whereJsonContains('guards.specific_customers_id' , $ids)

            ->where('guards.admin_approved', 1)
            ->select('guards.*')->groupBy('guards.id')->orderBy('name', 'ASC')->get();

            foreach ($guards as $guard) {
                $guard->dob = date('d-m-Y', strtotime($guard->dob));
                $guard->last_login = date('d-m-Y H:i', strtotime($guard->last_login));
            }
            return view('admin/customer/customer_guards', ['guards' => $guards]);
        } elseif (session()->get('userType') == 'contractor') {
            $ids = [''.session()->get('userId').''];
            $guards = DB::table('guards')
            // ->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')
            // ->join('jobs', 'jobs.id', '=', 'jobs_guards.job_id')
            ->where('guards.status', 'active')
            ->where('guards.contractor_id', session()->get('userId'))
            // ->whereJsonContains('guards.specific_customers_id' , $ids)

            ->where('guards.admin_approved', 1)
            ->select('guards.*')->groupBy('guards.id')->orderBy('name', 'ASC')->get();

            foreach ($guards as $guard) {
                $guard->dob = date('d-m-Y', strtotime($guard->dob));
                $guard->last_login = date('d-m-Y H:i', strtotime($guard->last_login));
            }
            return view('admin/contractor/contractor_guards', ['guards' => $guards]);
        }
    }


    public function create_guard()
    {
        if (!session()->has('userType')) {
            return view('admin/login');
        } else {

            $customers = customer::get();
            // return view('admin/guard/index', [ 'customers' => $customers ]);
            return view('admin/guard/create_guard', ['customers' => $customers]);
        }
    }
    function getVisIpAddr() {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    public function edit_guard($id)
    {
        // $ip = $vis_ip = $this->getVisIPAddr();
        $abn_rate = array();
        $eba_rate = array();
        $award_rate = array();
        // $ipdat = @json_decode(file_get_contents(
        //     "http://www.geoplugin.net/json.gp?ip=" . $ip));
        // if (isset($ipdat->geoplugin_countryName)) {
        //     $country = $ipdat->geoplugin_countryName;
        // }else{
        //     $country = '';
        // }
         $ip = request()->ip();
    	if ($ip === '127.0.0.1' || $ip === '::1') {
        	$ip = '8.8.8.8'; // fallback for local testing
    	}
    	$response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,city,regionName,zip,lat,lon,query");
    	$data = json_decode($response, true);
        if($data){
            $country = $data['country'];
        }else{
            $country = "";
        }


        // $response = Http::get("https://ipapi.co/{$ip}/json/");
        // $country = $response->json()['country_name'];


        if (!session()->has('userType')) {
            return view('admin/login');
        } else {

            $customers = customer::where('status', 'active')->get();
            $data['ids'] = guard_ids::where(['guard_id' => $id])->get();
            $data['guard'] = guard::where(['id' => $id])->first();
            
            if (config('custom.own_payrates') == 0) {
                $data['guard_payrate'] = guard_payrate::where(['guard_id' => $id])->get();
            }else{
                $guard_payrates = DB::table('guard_payrates')->where(['guard_id' => $id])->first();
                if (!empty($guard_payrates)) {
                    $guard_payrates->payrate = json_decode($guard_payrates->payrate, true);
                }
                $data['guard_payrate'] = $guard_payrates;
            $abn_rate = payrate::where('payrate_type', 'abn')->select('id', 'title')->get();
            $eba_rate = payrate::where('payrate_type', 'eba')->select('id', 'title')->get();
            $award_rate = DB::table('award_payrates')->select('id', 'title')->get();
            }
            $data['guard_site_trained'] = guard_site_trained::where(['guard_id' => $id])->get();
            $data['guard_sites_blocked'] = guard_sites_blocked::where(['guard_id' => $id])->get();
            // $ids = guard::where(['id' => $id])->first();
            if ($data['guard']->manual_custom_payrates != '') {
                $data['guard']->manual_custom_payrates = json_decode($data['guard']->manual_custom_payrates, true);
            }
            $payrates_id = $data['guard']->payrates_id;
            

            // return view('admin/guard/index', [ 'customers' => $customers ]);
            return view('admin/guard/edit_guard', ['customers' => $customers, 'guard_id' => $id, 'guard_data' => $data, 'payrates_id' => $payrates_id, 'country' => $country, 'abn_rate' => $abn_rate,'eba_rate' => $eba_rate,'award_rate' => $award_rate ]);
        }
    }

    public function personal_form()
    {
        if (!session()->has('userType')) {
            return view('admin/login');
        } else {
            return true;
        }
    }
    function gaurd_site_block_form(Request $request)
    {
        $customers = customer::get();
        $html = view('admin/guard/gaurd_site_block_form', ['index' => $request->index, 'customers' => $customers])->render();
        return response()->json($html);
    }

    function guard_site_train_form(Request $request)
    {
        $customers = customer::where('status', 'active')->orderBy('name', 'ASC')->get();
        $html = view('admin/guard/guard_site_train_form', ['index' => $request->index, 'customers' => $customers])->render();
        return response()->json($html);
    }
    function upload_any_files(Request $request)
    {
        $public_path = public_path();
        $public_path = str_replace('portal/public', '', $public_path);
        $public_path = str_replace('apis/public', '', $public_path);
        $path1 = $public_path . 'uploads';
        $name = time().$request->file('file')->getClientOriginalName();
        $request->file->storeAs('', $name);
        // $path = $request->file('file')->store($path1);
        return response()->json(array('success' => true, 'path' => $name));
    }

    function upload_files(Request $request)
    {
        $image = $this->upload_img($request->image);
        if ($image != '') {
            return response()->json(array('success' => true, 'path' => $image));
        } else {
            return response()->json(array('success' => false, 'path' => ''));
        }
    }
    function upload_img($key)
    {

        $name = '';
        $public_path = public_path();
        $public_path = str_replace('portal/public', '', $public_path);
        $public_path = str_replace('apis/public', '', $public_path);
        $path = $public_path . 'asset_uploads/';

        $file_name = time() . '.jpg';

        $result = $this->base64_to_jpeg($key, $path . $file_name);

        $name = $file_name;
        if ($result) {
            return $name;
        } else {
            return '';
        }
    }

    function base64_to_jpeg($data, $output_file)

    {

        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
        file_put_contents($output_file, $data);
        return true;
    }

    function save_personal_form(Request $request)
    {
        // $validated = $request->validate([);
        $guardId = $request->guard_id;
        if ($request->guard_type == null || $request->guard_type == '') {
            $request->guard_type = 'Direct';
        }

        $validator = Validator::make($request->all(), ['email' => 'required', 'first_name' => 'required', 'phone' => 'required']);
        // $this->setValidationRules(['email' => 'required', 'password' => 'required', 'first_name' => 'required']);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => "Please enter required data!"]);
        } else {


            $guard_data = [

                'first_name' => ($request->first_name != null) ? $request->first_name : '',
                'last_name' => $request->last_name != null ? $request->last_name : '',
                'middle_name' => $request->middle_name != null ? $request->middle_name : '',
                'name' => ($request->first_name != null ? $request->first_name . ' ' : '') . ($request->middle_name != null ? $request->middle_name . ' ' : '') . ($request->last_name != null ? $request->last_name : ''),
                'email' => $request->email,
                'guard_type' => $request->guard_type,
                'contractor_id' => $request->contractor_id,
                'phone' => $request->phone != null ? $request->phone : '',
                'address' => $request->address,
                'suburb' => $request->suburb,
                'city' => $request->city,
                'state' => $request->state,
                'coordinates' => $request->coordinates,
                'postal_code' => $request->postalCode,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'emergency_contact_name' => $request->emergencyContactName,
                'emergency_contact_phone' => $request->emergencyContactPhone,
                'guard_working_type' => $request->guard_working_type,
                'position' => $request->position,

            ];
            if ($request->has('guard_level')) {
                $guard_data['guard_level'] = $request->guard_level;
            }
            //$request->has($request->specific_customers_id) &&
            if ($request->specific_customers_id  != null && $request->specific_customers_id  != '') {
                $guard_data['specific_customers_id'] = json_encode($request->specific_customers_id);
            } else {
                $guard_data['specific_customers_id'] = json_encode(array());
            }

            if ($request->profileImageUploaded  != null && $request->profileImageUploaded  != '') {
                $guard_data['profile_image'] = $request->profileImageUploaded;
            }
            $password = 'Temp1234';
            if ($request->password != null && trim($request->password) != '') {
                $guard_data['password'] = Hash::make($request->password);
                $password = $request->password;
            }
            if ($request->has('form_type') && $request->form_type == "quick") {
                $guard_data['password'] = Hash::make("Temp1234");
            }
            if (Session()->has('guards_navigation_bar')  && isset(session()->get('guards_navigation_bar')[0]->active_guards) && session()->get('guards_navigation_bar')[0]->active_guards == 1) {
                $guard_data['status'] = 'active';
                $guard_data['admin_approved'] = 1;
                $guard_data['is_approved'] = 'yes';
                $guard_data['security_license_number'] = 122314;
                $guard_data['security_license_file'] = '1.jpg';
                $guard_data['address'] = $request->address != null ? $request->address : 'temporary address';
            }

            // print_r('<pre>');
            // print_r($guard_data);
            // exit();
            if ($request->has('guard_id')) {
                $data = DB::table('guards')->where('id', $request->guard_id)->get();
                $action = 'guard_update';
                $this->profileLogs->guardProfileLogs($request, $data[0]);
                $this->administrator->log_user_activity($action, $data);
                guard::where(['id' => $request->guard_id])->update($guard_data);
                //    $this->guard_payroll_id($request->guard_id);
                $payroll = $this->guard_payroll_id($request->guard_id);
                // exit();
                return response()->json(['success' => true, 'message' => "Details update successfully"]);
            } else {
                $check = guard::where(['email' => $guard_data['email']])->first();
                if (empty($check)) {
                    $guard_data['profile_completion'] = 20;
                    $guard_id = guard::insertGetId($guard_data);
                    $data = DB::table('guards')->where('id', $guard_id)->get();
                    $action = 'guard_creation';
                    $this->administrator->log_user_activity($action, $data);
                    $payroll = $this->guard_payroll_id($guard_id);
                    // exit();

                    // return $payroll;
                    // exit();
                    $root = $_SERVER['HTTP_HOST'];
                    $root = explode('.', $root);
                    $sub_domain = 'staffingsolution';
                    if ($root[0] != 'wwww') {
                        $sub_domain = $root[0];
                    } else {
                        $sub_domain = $root[1];
                    }
                    $config_data = DB::connection('mysql2')->table('business_data')->where('domain', $sub_domain)->first();

                    $guard = DB::table('guards')->where('id', $guard_id)->first();
                    $subject = 'Welcome to ' . config('custom.title') . '! Lets Get Started';
                    $message = '<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
                    <br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
                    <tbody><tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="' . config('custom.logo') . '" rel="noopener" target="_blank"><img src="https://vcpgsystem.com.au/asset_uploads/vcpg.png" style="height: 45px" alt="logo"></a></td></tr><tr>
                    <td align="left" valign="center">
                    <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px"><!--begin:Email content--><div style="padding-bottom: 30px; font-size: 17px;"><strong>Welcome to ' . config('custom.title') . '! Lets Get Started</strong></div>';
                    $message .= '<div style="padding-bottom: 30px"><p>Your Account is created successfully against Email : <b >' . $guard_data['email'] . ' .</b> </p></br></div>';
                    $message .= '<div style="padding-bottom: 30px"><p>Your password is : <b >' . $password . ' .</b> </p></br></div>';

                    if ($config_data->business_type == 'demo') {
                        $message .= '<div style="padding-bottom: 30px"><p>Your company code is : <b >' . $config_data->unique_id . ' .</b> </p></br></div>';
                    }

                    $message .= '<div style="padding-bottom: 40px; text-align:center;"></div>';
                    $apikey = base64_encode(Str::random(64) . time());
                    DB::table('guards')->where('id', $guard_id)->update(['auth_token' => $apikey]);
                    $config_recods = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id', config('custom.domain_id'))->where('type', 'guards_navigation_bar')->first();
                    $value = !empty($config_recods) ? json_decode($config_recods->records_business_navbar) : array();
                    if (isset($value->email) && $value->email == 1) {
                        $this->sendGuardMail_save_guard($guard, $subject, $message, $apikey);
                    }
                    return response()->json(['success' => true, 'message' => "Details guard_id insert successfully", 'guard_id' => $guard_id]);
                } else {
                    return response()->json(['success' => false, 'error' => "User with this email:" . $guard_data['email'] . ' already exists.']);
                }
            }
        }
    }

    function guard_ids(Request $request)
    {
        $ids = guard_ids::where(['guard_id' => $request->guard_id])->get();
        // $guard=DB::table('guards')->where('id',$request->guard_id)->first();
        // if($guard->contractor_id!=NULL && $guard->contractor_id!=''){
        //     $contractor_check=true;
        //     }
        //     else{
        //     $contractor_check=false;
        //     }
        $customers = customer::get();
        $ids_html =  view('admin/guard/edit-guard/ids_form_input', ['index' => 0, 'customers' => $customers, 'ids' => $ids, 'isloaded' => true])->render();
        if (!empty($ids)) {
            return response()->json(['success' => true, 'message' => "ID found", 'ids' => $ids, 'ids_html' => $ids_html]);
        } else {
            return response()->json(['success' => false, 'error' => "No ID."]);
        }
    }

    function guard_payroll_ids(Request $request)
    {

        $ids = guard_payroll_ids::where(['guard_id' => $request->guard_id])->get();

        $guard = DB::table('guards')->where('id', $request->guard_id)->first();
        $type = $guard->guard_type;
        $ids_html =  view('admin/guard/edit-guard/payroll_ids_form_input', ['index' => 0, 'ids' => $ids, 'isloaded' => true])->render();
        if (count($ids) > 0) {
            $contractor_check = true;

            return response()->json(['success' => true, 'message' => "ID found", 'ids' => $ids, 'ids_html' => $ids_html, 'contractor_check' => $contractor_check, 'type' => $type]);
        } else {
            $contractor_check = false;
            return response()->json(['success' => false, 'error' => "No ID.", 'contractor_check' => $contractor_check, 'type' => $type]);
        }
    }

    function guard_ids_form(Request $request)
    {
        $customers = customer::get();
        $ids_html =  view('admin/guard/edit-guard/ids_form_input', ['index' => $request->index, 'customers' => $customers])->render();
        return response()->json($ids_html);
    }
    function guard_payroll_ids_form(Request $request)
    {
        $ids_html =  view('admin/guard/edit-guard/payroll_ids_form_input', ['index' => $request->index])->render();
        return response()->json($ids_html);
    }

    function save_ids_form(Request $request)
    {
        $already_check = guard_ids::where(['internal_id' => $request->internal_id, 'guard_id' => $request->guard_id])->first();
        if (empty($already_check)) {
            guard_ids::insert([
                'guard_id' => $request['guard_id'],
                'internal_id' => $request->internal_id
            ]);
        }
        if ($request->has('customer')) {
            $customers = $request->customer;
            foreach ($customers as $cust) {
                $already_check = guard_ids::where(['internal_id' => $request->internal_id, 'guard_id' => $request->guard_id, 'customer_id' => $cust['customer_id']])->first();
                if (empty($already_check)) {
                    guard_ids::insert([
                        'guard_id' => $request['guard_id'],
                        'internal_id' => $request->internal_id,
                        'customer_id' => $cust['customer_id'],
                        'external_id' => $cust['external_id']
                    ]);
                } else {
                    guard_ids::where(['internal_id' => $request->internal_id, 'guard_id' => $request->guard_id, 'customer_id' => $cust['customer_id']])->update([
                        'external_id' => $cust['external_id']
                    ]);
                }
            }
        }
        if ($request->has('payroll')) {
            $payrolls = $request->payroll;
            foreach ($payrolls as $payroll_id) {
                $already_check = guard_payroll_ids::where(['payroll_id' => $payroll_id['payroll_id'], 'guard_id' => $request->guard_id, 'type' => $payroll_id['payroll_id_type']])->first();
                if (empty($already_check)) {
                    guard_payroll_ids::insert([
                        'guard_id' => $request['guard_id'],
                        'payroll_id' => $payroll_id['payroll_id'],
                        'type' => $payroll_id['payroll_id_type']
                    ]);
                }
            }
        }
        return response()->json(['success' => true, 'message' => "IDs save successfully."]);
    }

    function get_guard_payrol(Request $request)
    {
        $guard = guard::where(['id' => $request->guard_id])->first();
        $guard->payroll_tfn_number = $guard->payroll_tfn_number != null ? $guard->payroll_tfn_number : '';
        $guard->payroll_abn_number = $guard->payroll_abn_number != null ? $guard->payroll_abn_number : '';
        $guard->payroll_superannutation = $guard->payroll_superannutation != null ? $guard->payroll_superannutation : '';
        $guard->payroll_superannutation_name = $guard->payroll_superannutation_name != null ? $guard->payroll_superannutation_name : '';
        $guard->payroll_bank_name = $guard->payroll_bank_name != null ? $guard->payroll_bank_name : '';
        $guard->payroll_bank_account_number = $guard->payroll_bank_account_number != null ? $guard->payroll_bank_account_number : '';
        $guard->bsb = $guard->bsb != null ? $guard->bsb : '';
        return response()->json(['success' => true, 'message' => "Payrl Data", 'guard' => $guard]);
    }
    function save_payroll_form(Request $request)
    {
        $data = [
            'payroll_tfn_number' => $request->payroll_tfn_number,
            'payroll_abn_number' => $request->payroll_abn_number,
            'payroll_superannutation' => $request->payroll_superannutation,
            'payroll_superannutation_name' => $request->payroll_superannutation_name,
            'payroll_bank_name' => $request->payroll_bank_name,
            'bsb' => $request->payroll_bsb,
            'payroll_bank_account_number' => $request->payroll_bank_account_number
        ];

        if ($request->superannutationFileUploaded != null && $request->superannutationFileUploaded != '') {
            $data['superannutation_file'] = $request->superannutationFileUploaded;
        }
        if ($request->tfnFileUploaded != null && $request->tfnFileUploaded != '') {
            $data['tfn_file'] = $request->tfnFileUploaded;
        }
        $check = DB::table('guards')->where('id', $request->guard_id)->first();
        guard::where(['id' => $request->guard_id])->update($data);
        $this->profileLogs->guardProfileLogs($request, $check);
        return response()->json(['success' => true, 'message' => "Payroll data save successfully."]);
    }
    function get_guard_payrates(Request $request)
    {
        $guard_payrate = payrate::where(['id' => $request->payrates_id])->orderBy('title', 'ASC')->first();
        if (!empty($guard_payrate)) {
            return response()->json(['success' => true, 'message' => "Payrates retrieve", 'payrates' => $guard_payrate]);
        } else {
            return response()->json(['success' => false, 'message' => "Payrates retrieve"]);
        }
    }
    function reload_payrates(Request $request)
    {
        $guard_payrate = payrate::orderBy('title', 'ASC')->get();
        $guard_payrate_id = $request->payrates_id;
        if (!empty($guard_payrate)) {
            return response()->json(['success' => true, 'message' => "Payrates retrieve", 'payrates' => $guard_payrate, 'guard_payrate_id' => $guard_payrate_id]);
        } else {
            return response()->json(['success' => false, 'message' => "Payrates retrieve"]);
        }
    }

    function get_payrates(Request $request)
    {
        if (config('custom.categorized_payrates') == 1) {
            $query = payrate::where(['state' => $request->state, 'level' => $request->job_level])->orderBy('title', 'ASC');
            if ($request->payrol == 'default') {
                $query->where('payrates.payrate_type', 'default');
            }
            if ($request->payrol == 'eba') {
                $query->where('payrates.payrate_type', 'eba');
            }
            if ($request->payrol == 'award') {
                $query->where('payrates.payrate_type', 'award');
            }
            $guard_payrate = $query->get();
        }else{
            $guard_payrate = payrate::where(['state' => $request->state, 'level' => $request->job_level])->orderBy('title', 'ASC')->get();
        }

        if (!empty($guard_payrate)) {
            return response()->json(['success' => true, 'message' => "Payrates retrieve", 'payrates' => $guard_payrate]);
        } else {
            return response()->json(['success' => false, 'message' => "Payrates not retrieve"]);
        }
    }



    function save_guard_payrates(Request $request)
    {
        $payrates['payrates_id'] = $request->payrates_id;
        if ($request->has('custom_payrate') && $request->custom_payrate == 1) {
            $payrates['manual_custom_payrate'] = 1;
            $payrates['manual_custom_payrates'] = json_encode(array(
                'flat_metro_week_day_day' => $request->flat_metro_week_day_day,
                'flat_regional_week_day_day' => $request->flat_regional_week_day_day,
                'flat_metro_week_day_night' => $request->flat_metro_week_day_night,
                'flat_regional_week_day_night' => $request->flat_regional_week_day_night,
                'flat_metro_friday' => $request->flat_metro_friday,
                'flat_regional_friday' => $request->flat_regional_friday,

                'flat_metro_saturday' => $request->flat_metro_saturday,
                'flat_regional_saturday' => $request->flat_regional_saturday,
                'flat_metro_saturday_night' => $request->flat_metro_saturday,
                'flat_regional_saturday_night' => $request->flat_regional_saturday,

                'flat_metro_sunday' => $request->flat_metro_sunday,
                'flat_regional_sunday' => $request->flat_regional_sunday,
                'flat_metro_sunday_night' => $request->flat_metro_sunday,
                'flat_regional_sunday_night' => $request->flat_regional_sunday,

                'flat_metro_public_holiday' => $request->flat_metro_public_holiday,
                'flat_regional_public_holiday' => $request->flat_regional_public_holiday,
                'flat_metro_public_holiday_night' => $request->flat_metro_public_holiday,
                'flat_regional_public_holiday_night' => $request->flat_regional_public_holiday,
            ));
        }else{
            $payrates['manual_custom_payrate'] = 0;
        }
        guard::where(['id' => $request->guard_id])->update($payrates);
        return response()->json(['success' => true, 'message' => "Payrate data save successfully."]);
    }


    // $data = [
    //     'flat_metro_flat_metro_week_day' => $request->flat_metro_week_day,
    //     'flat_metro_weekend' => $request->flat_metro_weekend,
    //     'flat_metro_public_holiday' => $request->flat_metro_public_holiday,
    //     'flat_regional_week_day' => $request->flat_regional_week_day,
    //     'flat_regional_weekend' => $request->flat_regional_weekend,
    //     'flat_regional_public_holiday' => $request->flat_regional_public_holiday,
    //     'eba_metro_weekday_day' => $request->eba_metro_weekday_day,
    //     'eba_metro_weekday_afternoon' => $request->eba_metro_weekday_afternoon,
    //     'eba_metro_weekday_night' => $request->eba_metro_weekday_night,
    //     'eba_metro_weekend' => $request->eba_metro_weekend,
    //     'eba_metro_public_holiday' => $request->eba_metro_public_holiday,
    //     'eba_regional_weekday_day' => $request->eba_regional_weekday_day,
    //     'eba_regional_weekday_afternoon' => $request->eba_regional_weekday_afternoon,
    //     'eba_regional_weekday_night' => $request->eba_regional_weekday_night,
    //     'eba_regional_weekend' => $request->eba_regional_weekend,
    //     'eba_regional_public_holiday' => $request->eba_regional_public_holiday,
    // ];


    // $already_check = guard_payrate::where(['guard_id' => $request->guard_id, 'state' => $request->payrates_state, 'job_level' => $request->job_level])->first();
    //         if (empty($already_check)) {
    //             $data['state'] = $request->payrates_state;
    //             $data['job_level'] = $request->job_level;
    //             $data['guard_id'] = $request->guard_id;
    //             guard_payrate::insert($data);  
    //         }else{
    // }
    // }

    function get_guard_site_trained(Request $request)
    {
        $guard_site_trained = guard_site_trained::where(['guard_id' => $request->guard_id])->get();
        $customers = customer::get();
        if (!empty($guard_site_trained)) {
            $trained_sites = array();
            foreach ($guard_site_trained as $trained) {
                $site = job::select('jobs.id as site_id', 'jobs.address', 'jobs.site_name', 'jobs.site_description')->where(['customer_id' => $trained->customer_id])->where('jobs.status', 'active')->get();
                $trained->sites = $site;
                $trained_sites[] = $trained;
            }
            $html = view('admin/guard/guard_site_train_form', ['index' => 0, 'customers' => $customers, 'isloaded' => true, 'site_trained' => $trained_sites])->render();

            return response()->json(['success' => true, 'message' => "Site Found", 'html' => $html]);
        } else {
            return response()->json(['success' => false, 'error' => "No trained sites"]);
        }
    }
    function save_sites_trained_form(Request $request)
    {
        $site_trained = $request->site_trained;
        foreach ($site_trained as $trained) {
            // if ($trained['site_id'] != '') {
            $data = [];
            $already_check = guard_site_trained::where(['guard_id' => $request->guard_id, 'customer_id' => $trained['customer_id'], 'site_id' => $trained['site_id']])->first();
            if (empty($already_check)) {
                $data['guard_id'] = $request->guard_id;
                $data['customer_id'] = $trained['customer_id'];
                $data['site_id'] = $trained['site_id'];
                $data['status'] = $trained['status'];
                guard_site_trained::insert($data);
            } else {
                $data['status'] = $trained['status'];
                guard_site_trained::where(['guard_id' => $request->guard_id, 'customer_id' => $trained['customer_id'], 'site_id' => $trained['site_id']])->update($data);
                // }
            }
        }
        return response()->json(['success' => true, 'message' => "Data save successfully."]);
    }

    function get_guard_site_blocked(Request $request)
    {
        $guard_sites_blocked = guard_sites_blocked::where(['guard_id' => $request->guard_id])->get();
        $customers = customer::get();
        if (!empty($guard_sites_blocked)) {
            $block_sites = array();
            foreach ($guard_sites_blocked as $trained) {
                $site = job::select('jobs.id as site_id', 'jobs.address', 'jobs.site_name', 'jobs.site_description')->where(['customer_id' => $trained->customer_id])->where('jobs.status', 'active')->get();
                $trained->sites = $site;
                $block_sites[] = $trained;
            }
            $html = view('admin/guard/gaurd_site_block_form', ['index' => 0, 'customers' => $customers, 'isloaded' => true, 'sites_blocked' => $block_sites])->render();

            return response()->json(['success' => true, 'message' => "Site Found", 'html' => $html]);
        } else {
            return response()->json(['success' => false, 'error' => "No trained sites"]);
        }
    }

    function sites_blocked_form(Request $request)
    {
        $site_blocked = $request->site_blocked;
        foreach ($site_blocked as $trained) {
            // if ($trained['site_id'] != '') {
            $data = [];
            $already_check = guard_sites_blocked::where(['guard_id' => $request->guard_id, 'customer_id' => $trained['customer_id'], 'site_id' => $trained['site_id']])->first();
            if (empty($already_check)) {
                $data['guard_id'] = $request->guard_id;
                $data['customer_id'] = $trained['customer_id'];
                $data['site_id'] = $trained['site_id'];
                $data['status'] = $trained['status'];
                guard_sites_blocked::insert($data);
            } else {
                $data['status'] = $trained['status'];
                guard_sites_blocked::where(['guard_id' => $request->guard_id, 'customer_id' => $trained['customer_id'], 'site_id' => $trained['site_id']])->update($data);
                // }
            }
        }
        return response()->json(['success' => true, 'message' => "Data save successfully."]);
    }
    function personal_data(Request $request)
    {
        $guard = guard::where(['id' => $request->guard_id])->first();
        if (!empty($guard)) {
            $guard->specific_customers_id = json_decode($guard->specific_customers_id, true);
            return response()->json(['success' => true, 'message' => "Personal Data", 'guard' => $guard]);
        } else {
            return response()->json(['success' => false, 'message' => "Payrates retrieve"]);
        }
    }

    function save_documents_form(Request $request)
    {
        $check = DB::table('guards')->where('id', $request->guard_id)->first();
        if ($check->work_limitation_status != 'active' || $check->fortnightly_working_hours == null) {

            if ($request->residentialStatus == "student" || $request->residentialStatus == "Student") {
                DB::table('guards')->where('id', $request->guard_id)->update([
                    'fortnightly_working_hours' => 20,
                    'work_limitation_status' => "active"
                ]);
            } else {
                DB::table('guards')->where('id', $request->guard_id)->update([
                    'fortnightly_working_hours' => 40,
                    'work_limitation_status' => "active"
                ]);
            }
        }
        $required_docs = [
            'vaccination_check' => ($request->has('vaccination_check') && $request->vaccination_check == 'on') ? true :false,
            'workingwithchildren_check' => ($request->has('workingwithchildren_check') && $request->workingwithchildren_check == 'on') ? true :false,
            'driver_check' => ($request->has('driver_check') && $request->driver_check == 'on') ? true :false,
            'security_check' => ($request->has('security_check') && $request->security_check == 'on') ? true :false,
            'visa_check' => ($request->has('visa_check') && $request->visa_check == 'on') ? true :false,
            'passport_check' => ($request->has('passport_check') && $request->passport_check == 'on') ? true :false,
            'firstaid_check' => ($request->has('firstaid_check') && $request->firstaid_check == 'on') ? true :false,
            'police_check' => ($request->has('police_check') && $request->police_check == 'on') ? true :false,
            'amginduction_check' => ($request->has('amginduction_check') && $request->amginduction_check == 'on') ? true :false,
            'citizenship_check' => ($request->has('citizenship_check') && $request->citizenship_check == 'on') ? true :false,
            'medicare_check' => ($request->has('medicare_check') && $request->medicare_check == 'on') ? true :false,
            'birthcertificate_check' => ($request->has('birthcertificate_check') && $request->birthcertificate_check == 'on') ? true :false,
        ];
        $customer_docs = [
            'vaccination_customer' => ($request->has('vaccination_customer') && $request->vaccination_customer == 'on') ? true :false,
            'workingwithchildren_customer' => ($request->has('workingwithchildren_customer') && $request->workingwithchildren_customer == 'on') ? true :false,
            'driverLicense_customer' => ($request->has('driverLicense_customer') && $request->driverLicense_customer == 'on') ? true :false,
            'securityLicense_customer' => ($request->has('securityLicense_customer') && $request->securityLicense_customer == 'on') ? true :false,
            'visa_customer' => ($request->has('visa_customer') && $request->visa_customer == 'on') ? true :false,
            'passport_customer' => ($request->has('passport_customer') && $request->passport_customer == 'on') ? true :false,
            'birthcertificate_customer' => ($request->has('birthcertificate_customer') && $request->birthcertificate_customer == 'on') ? true :false,
            'medicare_customer' => ($request->has('medicare_customer') && $request->medicare_customer == 'on') ? true :false,
            'firstaid_customer' => ($request->has('firstaid_customer') && $request->firstaid_customer == 'on') ? true :false,
            'policecheck_customer' => ($request->has('policecheck_customer') && $request->policecheck_customer == 'on') ? true :false,
            'amginduction_customer' => ($request->has('amginduction_customer') && $request->amginduction_customer == 'on') ? true :false,
            'firearmLicense_customer' => ($request->has('firearmLicense_customer') && $request->firearmLicense_customer == 'on') ? true :false,
            'citizenship_customer' => ($request->has('citizenship_customer') && $request->citizenship_customer == 'on') ? true :false,
        ];


        // print_r($required_docs);
        // exit();
        $data = [
            // '' => $request->position,
            'registration_type' => $request->registrationType,
            'residential_status_secondary' => $request->subselect,
            'residential_status' => $request->residentialStatus,

            // '' => $request->subselect,
            'medicare_number' => $request->medicareNumber,
            'medicare_expiration' => $request->medicareExpiration,
            'citizenship_number' => $request->citizenshipNumber,
            'citizenship_expiration' => $request->citizenshipExpiration,
            'birthcertificate_number' => $request->birthcertificateNumber,
            'birthcertificate_expiration' => $request->birthcertificateExpiration,
            'passport_number' => $request->passportNumber,
            'passport_expiration' => $request->passportExpiration,
            'visa_number' => $request->visaNumber,
            'visa_expiration' => $request->visaExpiration,
            'security_license_number' => $request->securityLicenseNumber,
            'security_license_expiration' => $request->securityLicenseExpiration,
            // 'security_license_number_back' => $request->securityLicenseNumberBack,
            // 'security_license_expiration_back' => $request->securityLicenseExpirationBack,
            'driver_license_number' => $request->driverLicenseNumber,
            'driver_license_expiration' => $request->driverLicenseExpiration,
            'firstaid_license_number' => $request->firstaidLicenseNumber,
            'firstaid_license_expiration' => $request->firstaidLicenseExpiration,
            'firearm_license_number' => $request->firearmLicenseNumber,
            'firearm_license_expiration' => $request->firearmLicenseExpiration,
            'required_docs' => json_encode($required_docs),
            'customer_docs' => json_encode($customer_docs)
            // 'vaccination_certificate' => $request->vaccination_certificate
        ];
        if ($request->vaccinationFileUploaded != null && $request->vaccinationFileUploaded != '') {
            $data['vaccination_certificate'] = $request->vaccinationFileUploaded;
        }
        if ($request->firearmLicenseFileUploaded != null && $request->firearmLicenseFileUploaded != '') {
            $data['firearm_license_file'] = $request->firearmLicenseFileUploaded;
        } else {
            $data['firearm_license_file'] = null;
        }
        if ($request->firstaidLicenseUploaded != null && $request->firstaidLicenseUploaded != '') {
            $data['firstaid_license_file'] = $request->firstaidLicenseUploaded;
        } else {
            $data['firstaid_license_file'] = null;
        }
        if ($request->driverLicenseFileBackUploaded != null && $request->driverLicenseFileBackUploaded != '') {
            $data['driver_license_file_back'] = $request->driverLicenseFileBackUploaded;
        } else {
            $data['driver_license_file_back'] = null;
        }
        if ($request->driverLicenseFileUploaded != null && $request->driverLicenseFileUploaded != '') {
            $data['driver_license_file'] = $request->driverLicenseFileUploaded;
        } else {
            $data['driver_license_file'] = null;
        }
        if ($request->visaFileUploaded != null && $request->visaFileUploaded != '') {
            $data['visa_file'] = $request->visaFileUploaded;
        } else {
            $data['visa_file'] = null;
        }
        if ($request->passportFileUploaded != null && $request->passportFileUploaded != '') {
            $data['passport_file'] = $request->passportFileUploaded;
        } else {
            $data['passport_file'] = null;
        }

        if ($request->birthcertificateFileUploaded != null && $request->birthcertificateFileUploaded != '') {
            $data['birthcertificate_file'] = $request->birthcertificateFileUploaded;
        } else {
            $data['birthcertificate_file'] = null;
        }
        if ($request->citizenshipFileUploaded != null && $request->citizenshipFileUploaded != '') {
            $data['citizenship_file'] = $request->citizenshipFileUploaded;
        } else {
            $data['citizenship_file'] = null;
        }

        if ($request->medicareFileUploaded != null && $request->medicareFileUploaded != '') {
            $data['medicare_file'] = $request->medicareFileUploaded;
        } else {
            $data['medicare_file'] = null;
        }
        if ($request->securityLicenseFileUploaded != null && $request->securityLicenseFileUploaded != '' && $request->securityLicenseFileUploaded != 'null') {
            $data['security_license_file'] = $request->securityLicenseFileUploaded;
        } else {
            $data['security_license_file'] = null;
        }
        if ($request->securityLicenseFileUploadedBack != null && $request->securityLicenseFileUploadedBack != '' && $request->securityLicenseFileUploadedBack != 'null') {
            $data['security_license_file_back'] = $request->securityLicenseFileUploadedBack;
        } else {
            $data['security_license_file_back'] = null;
        }
        guard::where(['id' => $request->guard_id])->update($data);
        $this->profileLogs->guardProfileLogs($request, $check);
        if ($request->has('guard_documents') && !empty($request->guard_documents)) {
            foreach ($request->guard_documents as $key => $documnets) {
                if (isset($documnets['file_id'])) {
                    DB::table('guard_files')->where('id', $documnets['file_id'])->update([
                        'guard_id' => $request->guard_id,
                        'file_type' => $documnets['file_type'],
                        'file_expiry' => isset($documnets['file_expiry']) && $documnets['file_expiry'] != null ? $documnets['file_expiry'] : '',
                        'file_path' => $documnets['file_name']
                    ]);
                } else {
                    DB::table('guard_files')->insert([
                        // 'file_type' => !empty($documnets['file_type']) ? $documnets['file_type'] : ,
                        'guard_id' => $request->guard_id,
                        'file_type' => $documnets['file_type'],
                        'file_expiry' => isset($documnets['file_expiry']) && $documnets['file_expiry'] != null ? $documnets['file_expiry'] : '',
                        'file_path' => $documnets['file_name']
                    ]);
                }
            }
        }
        return response()->json(['success' => true, 'message' => "Data save successfully."]);
    }
    function guard_documents(Request $request)
    {
        $guard = guard::where(['id' => $request->guard_id])->first();
        $guards_files = DB::table('guard_files')->where('guard_id', $request->guard_id)->get();
        $state = $guard->state;
        $documnets = [
            'registrationType'  =>  $guard->registration_type,
            'residentialStatus' => $guard->residential_status,
            'residential_status_secondary' => $guard->residential_status_secondary,

            // '' => $guard->subselect,
            'medicareNumber' => $guard->medicare_number,
            'medicareExpiration' => $guard->medicare_expiration,
            'citizenshipNumber' => $guard->citizenship_number,
            'citizenshipExpiration' => $guard->citizenship_expiration,
            'birthcertificateNumber' => $guard->birthcertificate_number,
            'birthcertificateExpiration' => $guard->birthcertificate_expiration,
            'passportNumber' => $guard->passport_number,
            'passportExpiration' => $guard->passport_expiration,
            'visaNumber' => $guard->visa_number,
            'visaExpiration' => $guard->visa_expiration,
            'securityLicenseNumber' => $guard->security_license_number,
            'securityLicenseExpiration' => $guard->security_license_expiration,
            // 'securityLicenseNumberBack' => $guard->security_license_number_back,
            // 'securityLicenseExpirationBack' => $guard->security_license_expiration_back,
            'driverLicenseNumber' => $guard->driver_license_number,
            'driverLicenseExpiration' => $guard->driver_license_expiration,
            'firstaidLicenseNumber' => $guard->firstaid_license_number,
            'firstaidLicenseExpiration' => $guard->firstaid_license_expiration,
            'firearmLicenseNumber' => $guard->firearm_license_number,
            'firearmLicenseExpiration' => $guard->firearm_license_expiration,
            'medicare_file' => $guard->medicare_file,
            'passport_file' => $guard->passport_file,
            'visa_file' => $guard->visa_file,
            'security_license_file' => $guard->security_license_file,
            'security_license_file_back' => $guard->security_license_file_back,
            'driver_license_file' => $guard->driver_license_file,
            'driver_license_file_back' => $guard->driver_license_file_back,
            'firstaid_license_file' => $guard->firstaid_license_file,
            'firearm_license_file' => $guard->firearm_license_file,
            'birthcertificate_file' => $guard->birthcertificate_file,
            'citizenship_file' => $guard->citizenship_file,
            'other_files' => $guards_files,
            'vaccination_certificate' => $guard->vaccination_certificate,
            'required_docs' => json_decode($guard->required_docs, true),
            'customer_docs' => json_decode($guard->customer_docs, true),

        ];
        return response()->json(['success' => true, 'message' => "Data retrieve successfully.", 'documnets' => $documnets, 'state' => $state]);
    }

    function get_gaurd_other_files(Request $request)
    {
        $guards_files = DB::table('guard_files')->where('guard_id', $request->guard_id)->get();
        $html = view('admin/guard/guard_document_form_edit', ['files' => $guards_files])->render();
        return response()->json($html);
    }
    function get_guard_document_form(Request $request)
    {
        $html = view('admin/guard/guard_document_form', ['index' => $request->index])->render();
        return response()->json($html);
    }

    function calendarData(Request $request)
    {
        $shift_status_enable = false;
        $config_recods = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id', config('custom.domain_id'))->where('type', 'job_roster_navigation_bar')->first();
        $settings = !empty($config_recods) ? json_decode($config_recods->records_business_navbar, true) : array();
        if (isset($settings['shift_status']) && $settings['shift_status'] == 1) {
            $shift_status_enable = true;
        }

        $availability = array();
        $request->customerIds = explode(',', $request->customerIds);
        foreach ($request->customerIds as $key => $customerId) {
            // $result = $this->getCalenderData($customerId);
            $user_type = 'admin';

            if (session()->get('userType') == 'guard') {
                $result = $this->getCalenderData_guard(session()->get('userId'));
                $user_type = 'guard';
                $request->resource_by = 'guard';
            } else {
                if ($request->resource_by != 'guard') {
                    $result = $this->getCalenderData($customerId, $request->start, $request->end, $request->search_value, $request->state, $request->resource_by);
                } else {
                    $result = $this->getCalenderData($customerId, $request->start, $request->end, null, $request->state, $request->resource_by);
                }
                $user_type = 'admin';
            }
            // dd($result);
            foreach ($result as $key => $value) {
                $missed = false;
                $guardName = $this->getSingleGuard($value->guard_id);
                if (!empty($guardName) && $value->guard_id > 0 && $guardName->state != '') {
                    config(['app.timezone' => $this->timezone[$guardName->state]]);
                    date_default_timezone_set($this->timezone[$guardName->state]);
                } else {
                    config(['app.timezone' => $this->timezone['Victoria']]);
                    date_default_timezone_set($this->timezone['Victoria']);
                }

                $data['id'] = $value->event_id;
                $data['roster_id'] = $value->roster_id;
                $data['customer_name'] = $value->customer_name;
                $data['className'] = 'custom-color-blue';
                // $data['backgroundColor'] = '#378006';
                // dd(session()->has('config_arr_job_roster'));
                // $num =session()->get('config_arr_job_roster')[0]->shift_colors;
                // dd($num);
                // dd(session()->get('config_arr_job_roster')[0]->shift_colors === '0');
                $color_enable = false;
                if (session()->has('config_arr_job_roster') && isset(session()->get('config_arr_job_roster')[0]->shift_colors) && session()->get('config_arr_job_roster')[0]->shift_colors != null  && session()->get('config_arr_job_roster')[0]->shift_colors == 0) {
                    $color_enable = true;
                }
                $operators_notes_enabled = false;
                if (isset($settings['operational_notes']) && $settings['operational_notes'] == 1)
                {
                    $operators_notes_enabled = true;
                }

                if ($value->job_status == "pending") {
                    $data['color'] = "#ffff00";
                    $data['eventBorderColor'] = '#84b3cd40';
                }
                if ($value->job_status == 'rejected') {
                    $data['className'] = 'custom-color-yellow';
                    $data['textColor'] = "#000";
                    $data['color'] = "#ffff00";
                } elseif ($value->guard_id == '' || $value->guard_id == 0 || $value->guard_id == null) {
                    // $data['color'] = "#FF4433";
                    $data['color'] = "#ffff00";
                    $data['textColor'] = "#000";
                    $data['className'] = 'custom-colors-uncovered';
                } elseif ($value->publish_status == 1 && $value->unpublish_shift == 0) {
                    $data['className'] = 'custom-colors-publish';
                } elseif ($value->publish_status == 0 && $value->unpublish_shift == 0) {
                    $data['className'] = 'custom-colors-unpublish';
                } elseif ($value->unpublish_shift == 1) {
                    $data['color'] = '#000';
                    // $data['textColor'] = '#6495ED';
                    $data['className'] = 'UnPub-Fea-Color';
                    $data['textColor'] = "#000";
                }else {
                    $data['className'] = 'custom-color-dark-khaki';
                }

                if ($value->job_status == "confirmed") {
                    $data['color'] = "#92D050";
                } elseif ($value->job_status == "completed") {
                    $data['color'] = "#92D050";
                }
                // $data['eventColor'] = "#92D050";
                // rendering: 'background'
                $message = 'No '.config('custom.guard').'<br>accepted the job<br> yet';
                if ($value->post_status == '0') {
                    $message = 'Uncovered Shift';
                }
                $data['title'] = $guardName ? $guardName->name : $message;

                if ($request->has('resource_by')) {
                    if ($request->resource_by == 'guard') {
                        $data['title'] = $value->site_name;
                    }
                }
                if (($value->guard_id == null || $value->guard_id == 0) && $value->moke_guard != '') {
                    $data['title'] = $value->moke_guard;
                    $data['color'] = '#C4D79B';
                    $data['className'] = 'custom-color-mock-guard';
                    $data['textColor'] = "#000";
                }
                if ($value->job_status == "completed" && $shift_status_enable == true) {

                    $data['title'] = $data['title'] . ' (C)';
                }
                $data['current_time'] = date('Y-m-d H:i');
                if ($value->temp_start < date('Y-m-d H:i') && $value->job_status != 'rejected' && $value->publish_status == 1) {
                    $activity = job_roster_activities::where(['job_roster_id' => $value->roster_id])->first();
                    if (empty($activity) ) {
                        if ($value->guard_id != '' && $value->unpublish_shift == 0 ) {
                            $data['className'] = 'custom-color-red-orange';
                        }
                        $data['textColor'] = '#000';
                        // $data['color'] = "#FFFF00";
                        if ($value->job_start < time() && $shift_status_enable == true) {
                            $data['title'] = $data['title'] . ' (M)';
                            $missed = true;
                        }
                    } elseif ($activity['status'] == 1 && $shift_status_enable == true) {
                        $data['title'] = $data['title'] . ' (S)';
                    } elseif ($activity['status'] == 0) {
                        // $data['title'] = $data['title'] .' (C)';
                    }
                }
                if ($shift_status_enable == false && $value->operators_notes != '' && $value->operators_notes != null) {
                    $data['title'] = $data['title'] . ' (N)';
                }
                $data['training'] = $value->training;
                // if ($value->roll_over == 1) {
                //  $data['className'] = 'custom-color-red-orange';
                // }
                $same = false;
                if (date('Y-m-d', strtotime($value->temp_start)) ==  date('Y-m-d', strtotime($value->temp_end))) {
                    $same = true;
                }
                if ($same == false) {
                    // $data['title'] .= ' (Shift End: '.date('H:i', strtotime($value->temp_end)).')';
                }
                $data['resource_by'] = 'guard';
                $data['resource_by_id'] = '';
                if ($request->has('resource_by')) {
                    $resourceId = '';
                    if ($request->resource_by == 'guard') {
                        if ($value->guard_id != null && $value->guard_id != 0) {
                            $resourceId = str_replace(' ', '-', $guardName->name);
                            $data['resourceId'] = $resourceId . '-' . $value->guard_id;
                            $data['resource_by_id'] = $value->guard_id;
                        } else {
                            $data['resourceId'] = 'a-0';
                        }
                    } else {
                        $resourceId = str_replace(' ', '-', $value->site_name);
                        $data['resourceId'] = $resourceId . '-' . $value->site_id;
                        $data['resource_by_id'] = $value->site_id;
                    }
                    $data['resource_by'] = $request->resource_by;
                }
                if ($value->job_status == 'rejected' && ($value->guard_id == 0 || $value->guard_id == '' || $value->guard_id == null)) {
                    $guardName1 = $this->getSingleGuard($value->rejected_by);
                    if (!empty($guardName1)) {
                        $guardName1->name = 'Shift denied by ' . $guardName1->name;
                        $message = 'Shift denied by ' . $guardName1->name;
                    } else {
                        $message = 'Shift denied';
                    }

                    $data['title'] = !empty($guardName1) ? $guardName1->name : $message;
                }
                if ($value->overtime == 1) {
                    $data['color'] = '#CCCCFF';
                    $data['textColor'] = "#000";
                    $data['className'] = 'custom-color-purple';
                }

                
                $next_hours = 0;
                // $data['className'] .= ' context-menu';
                // $hours_check = explode('+', $value->start);
                // if (sizeof($hours_check) > 1) {
                //     $next_hours = 60*60*10;
                // }
                $start = str_replace('T', ' ', $value->start);
                $start = explode('+', $start);
                $start = $start[0];

                $end = str_replace('T', ' ', $value->end);
                $end = explode('+', $end);
                $end = $end[0];

                $value->temp_start = $start;
                $value->temp_end = $end;
                $value->job_start = strtotime($start);
                $value->job_end = strtotime($end);

                $data['start_time'] = $value->temp_start;
                $data['site_name'] = $value->site_name;
                $data['site_description'] = $value->site_description;
                $data['site_address'] = $value->site_address;
                $data['notes'] = $value->operators_notes;
                $data['tooltip'] = $value->operators_notes;
                
                $data['className'] = $data['className'] . ' custom-roster-' . $value->roster_id;

                $data['description'] = ($value->operators_notes == null) ? '' : $value->operators_notes;

                $data['job_start'] = date('Y-m-d H:i:s', (strtotime($value->temp_start) + $next_hours));

                $data['job_end'] = $value->job_end != '' ? date('Y-m-d H:i:s', (strtotime($value->temp_end) + $next_hours)) : '';

                $data['end_time'] = $value->temp_end;

                $data['start'] = ($same == true) ? $value->temp_start : $value->temp_start;

                $data['end'] = ($same == true) ? $value->temp_end : $value->temp_end;

                $data['guardId'] = $value->guard_id;
                $data['guard_phone'] = ($value->guard_id > 0 && !empty($guardName)) ? $guardName->phone : '';
                $data['missed'] = $missed;
                $tasks = count($this->rosterTasks($value->roster_id));
                $tasks_temp = count($this->rosterTasks($value->roster_id));
                if ($tasks == 0) {
                    $tasks_temp = 1;
                }
                $completedTasks = count($this->rosterCompletedTasks($value->roster_id));

                $data['totalTasks'] = $tasks;
                $data['completedTasks'] = $completedTasks;
                $data['taskPercentage'] = ($data['completedTasks'] / $tasks_temp) * 100;

                $data['site_id'] = $value->site_id;
                $data['location'] = 'N/A';
                $data['post_status'] = $value->post_status;
                $data['same'] = $same;
                if (isset($color_enable) && $color_enable == true) {
                    $data['color'] =  '#ebf1dd';
                    $data['textColor'] = "#000";
                    $data['className'] = '';
                    $data['eventBorderColor'] = '';
                    $data['title'] = $data['title'];
                }
                if ($operators_notes_enabled && $value->operators_notes != '' && $value->operators_notes != null) {
                    $data['className'] = 'OperatinalNotes';
                    $data['notes_color'] = '#000000';
                }else{
                    $data['notes_color'] = '#ff0000';
                }
                
                if ($user_type == 'contractor') {
                    $contractor_id = $this->session->userdata('userId');
                    $contractor_id1 = $guardName ? $guardName[0]->contractor_id : 0;
                    // echo $contractor_id;
                    // exit();
                    if ($contractor_id == $contractor_id1) {
                        array_push($availability, $data);
                    }
                } else {

                    array_push($availability, $data);
                }
            }
        }

        return response()->json($availability);
    }

    public function getSingleGuard($guardId)
    {

        $data = guard::where(['id' => $guardId])->first();
        return $data;
    }
    public function getCalenderData($customerId, $start = null, $end = null, $search_value = null, $state = null, $resource_by = 'sites')
    {


        // $data = job_new_roster::where(['add_status' => 1, 'site_id' => $jobId])->get();
        $query = job_new_roster::join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->join('customers', 'customers.id', '=', 'jobs.customer_id')
        ->where(['job_new_roster.add_status' => 1, 'jobs.customer_id' => $customerId])->select('job_new_roster.*', 'jobs.site_name', 'jobs.site_description', 'jobs.address as site_address', 'customers.name as customer_name');
        if ($start != null) {
            $start = explode('T', $start);
            $start = $start[0];
            $query->where('job_new_roster.temp_start', '>=', $start);
        }
        if ($end != null) {
            $end = explode('T', $end);
            $end = $end[0];
            $query->where('job_new_roster.temp_start', '<=', $end);
        }
        if ($state != null) {
            $query->where('jobs.state', '=', $state);
        }
        if ($search_value != null && $search_value != '' && $search_value != 'undefined' && $search_value != 'undefined') {
            $search_value = explode(',', $search_value);
            if ($resource_by == 'sites') {
                $query->where(function ($query1) use ($search_value) {
                    $i = 0;
                    foreach ($search_value as $key => $index) {
                        if ($i == 0) {
                            $query1->where('job_new_roster.site_id', $index);
                        } else {
                            $query1->orWhere('job_new_roster.site_id', $index);
                        }
                        $i++;
                    }
                });
            } else {
                $query->where(function ($query1) use ($search_value) {
                    foreach ($search_value as $key => $index) {
                        $query1->orWhere('job_new_roster.guard_id', $index);
                    }
                });
            }
        }
        $data = $query->get();
        return $data;
    }
    public function getCalenderData_guard($guardid)
    {

        // $data = job_new_roster::where(['add_status' => 1, 'site_id' => $jobId])->get();
        $data = job_new_roster::join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')->join('customers', 'customers.id', '=', 'jobs.customer_id')->where(['job_new_roster.add_status' => 1, 'job_new_roster.guard_id' => $guard_id])->select('job_new_roster.*', 'jobs.site_name', 'jobs.site_description', 'jobs.address as site_address', 'customers.name as customer_name')->get();
        return $data;
    }

    public function getJobData($jobId)
    {

        $data = job::where(['id' => $jobId])->first();
        return $data;
    }
    public function get_site_trained_guard($guardId = '', $siteid = '')
    {
        $data = DB::table('guard_sites_trained')->where('guard_sites_trained.site_id', $siteid)->where('guard_sites_trained.guard_id', $guardId)->get();
        return $data;
    }
    public function getTrainedGuards($jobId)
    {

        $return = array();


        $data = DB::table('guards')->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')->where('jobs_guards.job_id', $jobId)->where('guards.status', 'active')->select('guards.*', 'jobs_guards.job_id as jobId')->get();

        $customer =  DB::table('jobs')->where('id', $jobId)->select('customer_id')->first();

        foreach ($data as $key => $value) {

            $res = $this->get_site_trained_guard($value->id, $jobId);
            $value->site_trained = 'no';
            if (count($res) > 0) {
                $value->site_trained = 'yes';
            }
            if ($value->specific_customers_id != '') {
                $specific_customers_id = json_decode($value->specific_customers_id, true);
                foreach ($specific_customers_id as $key1 => $value1) {
                    $blocked = DB::table('guard_sites_blocked')->where(['guard_id' => $value->id, 'site_id' => $jobId, 'status' => 'Block'])->first();
                    if (empty($blocked) && $value1 == $customer->customer_id && count($res) > 0) {
                        array_push($return, $value);
                    }
                }
            }
        }


        return $return;
    }

    public function getTrainedGuardsList($jobId)
    {

        $return = array();


        $data = DB::table('guards')->where('guards.status', 'active')->select('guards.*')->get();

        $customer =  DB::table('jobs')->where('id', $jobId)->select('customer_id')->first();

        foreach ($data as $key => $value) {

            $res = $this->get_site_trained_guard($value->id, $jobId);
            $value->site_trained = 'no';
            if (count($res) > 0) {
                $value->site_trained = 'yes';
            }
            if ($value->specific_customers_id != '') {
                $specific_customers_id = json_decode($value->specific_customers_id, true);
                foreach ($specific_customers_id as $key1 => $value1) {
                    $blocked = DB::table('guard_sites_blocked')->where(['guard_id' => $value->id, 'site_id' => $jobId, 'status' => 'Block'])->first();
                    $is_already = DB::table('jobs_guards')->where(['guard_id' => $value->id, 'job_id' => $jobId])->first();
                    if (empty($blocked) && $value1 == $customer->customer_id && count($res) > 0 && empty($is_already)) {
                        array_push($return, $value);
                    }
                }
            }
        }


        return $return;
    }

    private function getTimeDiff($start, $end)
    {
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
        $years = floor($diff / (365 * 60 * 60 * 24));


        // To get the month, subtract it with years and
        // divide the resultant date into
        // total seconds in a month (30*60*60*24)
        $months = floor(($diff - $years * 365 * 60 * 60 * 24)
            / (30 * 60 * 60 * 24));


        // To get the day, subtract it with years and
        // months and divide the resultant date into
        // total seconds in a days (60*60*24)
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
            $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


        // To get the hour, subtract it with years,
        // months & seconds and divide the resultant
        // date into total seconds in a hours (60*60)
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24
            - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
        / (60 * 60));


        // To get the minutes, subtract it with years,
        // months, seconds and hours and divide the
        // resultant date into total seconds i.e. 60
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24
            - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
            - $hours * 60 * 60) / 60);

        $hours = $hours + ($minutes / 60);

        // To get the minutes, subtract it with years,
        // months, seconds, hours and minutes
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24
            - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
            - $hours * 60 * 60 - $minutes * 60));

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

    public function getGuards($jobId)
    {

        $data = DB::table('guards')
        ->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')->where(['jobs_guards.job_id' => $jobId, 'guards.status' => 'active', 'guards.is_approved' => 'yes'])->select('guards.*', 'jobs_guards.job_id as jobId')->orderBy('name', 'ASC')->get();
        $new_data = array();
        foreach ($data as $da) {
            $roster_data = job_new_roster::where('job_start', '>=', strtotime('monday this week'))
            ->where('job_start', '<', strtotime('monday next week'))
            ->where('guard_id', '=', $da->id)
            ->where('job_status', '=', 'completed')->get();

            if (!empty($roster_data)) {
                $hours = 0;
                foreach ($roster_data as $r) {
                    $time = $this->getTimeDiff($r->temp_start, $r->temp_end);
                    $hours += $time['hours'];
                }
                $total_hours = explode('.', $hours);
                if (sizeof($total_hours) > 1) {
                    $partial = '.' . $total_hours[1];
                    if ($partial < 0.1) {
                        $hours = $total_hours[0];
                    }
                    if ($partial < 0.27 && $partial > 0.1) {
                        $hours = $total_hours[0] . '.25';
                    }
                    if ($partial > 0.27 && $partial < 0.52) {
                        $hours = $total_hours[0] . '.5';
                    }
                    if ($partial > 0.52 && $partial < 0.77) {
                        $hours = $total_hours[0] . '.75';
                    }
                    if ($partial > 0.77 && $partial < 1) {
                        $hours = $total_hours[0] + 1;
                    }
                }
                $da->total_hours = number_format($hours, 2);
            } else {
                $da->total_hours = 0;
            }
            $new_data[] = $da;
        }
        $data = $new_data;

        $customer = job::where(['id' => $jobId])->select('customer_id')->first();

        $not_blocked_guards = array();
        foreach ($data as $da) {
            if ($da->specific_customers_id != '') {
                $specific_customers_id = json_decode($da->specific_customers_id, true);
                foreach ($specific_customers_id as $key1 => $value1) {
                    // $blocked = $this->db->get_where('guard_sites_blocked', array('guard_id' => $da->id, 'site_id' => $jobId, 'status' => 'Block'), 1, 0)->row_array();
                    $blocked = guard_sites_blocked::where(['guard_id' => $da->id, 'site_id' => $jobId, 'status' => 'Block'])->first();
                    if (empty($blocked) && $value1 == $customer->customer_id) {
                        $not_blocked_guards[] = $da;
                    }
                }
            }
        }
        $data = $not_blocked_guards;
        return $data;
    }
    public function getGuardsList(Request $request)
    {
        $jobId = $request->jobId;
        $jobData = $this->getJobData($jobId);
        if (!empty($jobData->trained) || $jobData->trained != '') {
            if ($jobData->trained == "yes") {
                $data = $this->getTrainedGuards($jobId);
                echo json_encode($data);
            } else {
                $data = $this->getGuards($jobId);

                echo json_encode($data);
            }
        } else {
         $data = $this->getGuards($jobId);
         echo json_encode($data);
            // echo json_encode("");
     }
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

public function checkGuardDocuments($guard, $tempDate)
{
    $required_docs = json_decode($guard->required_docs, true);
        // $status = $this->date_convert($guard->security_license_expiration);
        // return $tempDate;
    $today = date("m/d/Y");
    $today_time = strtotime($today);
    $passport_expiration = strtotime($this->date_convert($guard->passport_expiration));
    $visa_expiration = strtotime($this->date_convert($guard->visa_expiration));
    $security_license_expiration = strtotime($this->date_convert($guard->security_license_expiration));
    $driver_license_expiration = strtotime($this->date_convert($guard->driver_license_expiration));
    $firstaid_license_expiration = strtotime($this->date_convert($guard->firstaid_license_expiration));
    $firearm_license_expiration = strtotime($this->date_convert($guard->firearm_license_expiration));
        // print_r($security_license_expiration);
        // exit();
    $passport_expiration_formated = date("Y-m-d", strtotime($this->date_convert($guard->passport_expiration)));
    $visa_expiration_formated = date("Y-m-d", strtotime($this->date_convert($guard->visa_expiration)));
    $security_license_expiration_formated = date("Y-m-d", strtotime($this->date_convert($guard->security_license_expiration)));
    // return [$passport_expiration_formated < $tempDate , $visa_expiration_formated < $tempDate, $guard->visa_expiration, $security_license_expiration_formated < $tempDate];
    if ($passport_expiration && ($passport_expiration < $today_time || $passport_expiration_formated < $tempDate) && (empty($required_docs) || $required_docs['passport_check'] == true)) {
        $status = "Passport Expired";
        return $status;
    }
    if ( $visa_expiration && ($visa_expiration < $today_time || $visa_expiration_formated < $tempDate) && (empty($required_docs) || $required_docs['visa_check'] == true)) {
        $status = "Visa Expired";
        return $status;
    }
        // print_r(date('m/d/Y', $security_license_expiration));
        // exit;
    if (($guard->security_license_file == null || $guard->security_license_file == '' || $guard->security_license_number == null || $guard->security_license_number == '' || $guard->security_license_expiration == '' || $guard->security_license_expiration == null) || ($security_license_expiration < $today_time && $guard->security_license_expiration != 'current, pending renewal' && $security_license_expiration_formated < $tempDate)) {
            // && $guard->license_bypass == 0
       $status = "Security License Expired";
       return $status;
    }
    if ($driver_license_expiration && ($driver_license_expiration < $today_time) && (empty($required_docs) || $required_docs['driver_check'] == true)) {
        $status = "Driver License Expired";
        return $status;
    }
    if ($firstaid_license_expiration && ($firstaid_license_expiration < $today_time) && (empty($required_docs) || $required_docs['firstaid_check'] == true)) {
        $status = "Firstaid License Expired";
        return $status;
    }
    if ($firearm_license_expiration && ($firearm_license_expiration < $today_time)) {
        $status = "Firearm License Expired";
        return $status;
    }
    return 'Active';
}

public function checkGuardLeaves($guard_id, $start, $end)
{
    $leaves = DB::table('guard_leave_requests')
    ->where('start', '<=', strtotime($start))
    ->where('end', '>=', strtotime($start))
    ->where('guard_id', '=', $guard_id)
    ->where('status', '=', 'approved')->first();
    if (!empty($leaves)) {
        return false;
    } else {
        $leaves = DB::table('guard_leave_requests')
        ->where('start', '<=', strtotime($end))
        ->where('end', '>=', strtotime($end))
        ->where('guard_id', '=', $guard_id)
        ->where('status', '=', 'approved')->first();
        if (!empty($leaves)) {
            return false;
        } else {
            return true;
        }
    }
}

function checkGuardLastShift($guard_id, $start, $end, $event_id = null)
{
    $today_start = strtotime(date('m/d/Y', strtotime($start)));
    $today_end = strtotime(date('m/d/Y 23:59:59', strtotime($start)));
        // check is there any shift start in last 24 hours
    $last_24_hours = strtotime($start) - (60 * 60 * 24);
    $roster = job_new_roster::where('temp_start', '>=', date('Y-m-d H:i:s', $last_24_hours))
    ->where('temp_start', '<', $start)
    ->where('guard_id', '=', $guard_id);

    if ($event_id != null && $event_id > 0) {
        $roster->where('event_id', '!=', $event_id);
    }
    $roster = $roster->orderBy('job_end', 'desc')->first();

        // if there is no shift start in last 24 hours then check if there is end of shift in last 24 hours
    if (empty($roster)) {
        $last_24_hours = strtotime($start) - (60 * 60 * 24);
        $roster1 = job_new_roster::where('temp_end', '>=', date('Y-m-d H:i:s', $last_24_hours))
        ->where('temp_end', '<', $start)
        ->where('guard_id', '=', $guard_id);

        if ($event_id != null && $event_id > 0) {
            $roster1->where('event_id', '!=', $event_id);
        }
        $roster = $roster1->orderBy('job_end', 'desc')->first();
    }
    $today_working_hours = 0;
    if (!empty($roster)) {
    if ($roster->job_start < $today_start) {
            $roster->job_start = $today_start;
        }
        if ($roster->job_end > $today_end) {
            $roster->job_end = $today_end;
        }
        $today_working_hours += (($roster->job_end - $roster->job_start) / (60 * 60));
    }

        // print_r('<pre>');
        // print_r($roster);
    $last_shift_duration = 0;
    $time_diff_between_last_shift_and_current = 10;
    if (!empty($roster)) {
        $last_shift_duration = (strtotime($roster->temp_end) - strtotime($roster->job_start)) / (60 * 60);
        $time_diff_between_last_shift_and_current = (strtotime($start) - strtotime($roster->temp_end)) / (60 * 60);
    }
        // any shift in next 24 hours
    $next_roster = job_new_roster::where('temp_start', '>', $end)
    ->where('guard_id', '=', $guard_id);
    if ($event_id != null && $event_id > 0) {
        $next_roster->where('event_id', '!=', $event_id);
    }
    $next_roster = $next_roster->orderBy('job_start', 'ASC')->first();

    $next_shift_duration = 0;
    $time_diff_between_next_shift_and_current = 10;
    if (!empty($next_roster)) {
        if ($next_roster->job_end == '' || $next_roster->job_end == null) {
            $next_roster->job_end = time();
        }
        $next_shift_duration = ($next_roster->job_end - $next_roster->job_start) / (60 * 60);
        $time_diff_between_next_shift_and_current = ($next_roster->job_start - strtotime($end)) / (60 * 60);
    }
    
    if (strtotime($end) > $today_end) {
        $current_shift_today_duration = ($today_end - strtotime($start)) / (60 * 60);
    } else {
        $current_shift_today_duration = (strtotime($end) - strtotime($start)) / (60 * 60);
    }
    $jobs_today = job_new_roster::where('temp_start', '=', Date('Y-m-d', strtotime($start)))
    ->where('guard_id', '=', $guard_id);
    if ($event_id != null && $event_id > 0) {
        $jobs_today->where('event_id', '!=', $event_id);
    }
    $jobs_today = $jobs_today->get();


    $jobs_today1 = job_new_roster::where('temp_start', '!=', Date('Y-m-d', strtotime($start)))
    ->where('temp_end', '=', Date('Y-m-d', strtotime($start)))
    ->where('guard_id', '=', $guard_id);
    if ($event_id != null && $event_id > 0) {
        $jobs_today1->where('event_id', '!=', $event_id);
    }
    $jobs_today1 = $jobs_today1->get();


    $jobs_today = $jobs_today->merge($jobs_today1);

    foreach ($jobs_today as $jt) {
        if ($jt->job_start < $today_start) {
            $jt->job_start = $today_start;
        }
        if ($jt->job_end > $today_end) {
            $jt->job_end = $today_end;
        }
        $today_working_hours += (($jt->job_end - $jt->job_start) / (60 * 60));
    }
    $total_hours_today = $today_working_hours + round($current_shift_today_duration);
    if (($time_diff_between_last_shift_and_current < 8 && $total_hours_today > 12) || ($time_diff_between_next_shift_and_current < 8  && $total_hours_today > 12) ) {
        return array('status' => false);
    } else {
        return array('status' => true);
    }
}

public function validateGuard($siteId, $guardId)
{
    $q = DB::table('jobs_guards')->where('job_id', '=', $siteId)->where('guard_id', '=', $guardId)->first();
    if (!empty($q)) {
        return true;
    } else {
        return false;
    }
}
function getStartAndEndDate($week, $year)
{
    $dto = new DateTime();
    $dto->setISODate($year, $week);
    $ret['week_start'] = $dto->format('Y-m-d');
    $dto->modify('+6 days');
    $ret['week_end'] = $dto->format('Y-m-d');
    return $ret;
}
function get_current_month_hours_guards($guardId, $start, $end)
{
    $month = date('m');
    $year = date('Y');
        // whereMonth('temp_date', $month)
        // ->whereYear('temp_date', $year)
    $data = job_new_roster::where('guard_id', $guardId)
    ->where('temp_start', '>=', date('Y-m-d H:i', strtotime($start)))
    ->where('temp_start', '<=', date('Y-m-d 23:59', strtotime($end)))
    ->where('temp_end', '>=', date('Y-m-d H:i', strtotime($start)))
    ->where('temp_end', '<=', date('Y-m-d 23:59', strtotime($end)))
            // ->whereBetween('temp_start', [$start, $end])
            // ->whereBetween('temp_end', [$start, $end])
    ->get();
        // $data = DB::statement("SELECT * FROM `job_new_roster` WHERE MONTH(temp_date) = '".$month."' AND YEAR(temp_date) = '". $year."' AND `guard_id` = ".$guardId." AND (temp_start BETWEEN '".$start."' AND '".$end."') AND (temp_end BETWEEN '".$start."' AND '".$end."')");
    return $data;
}

function checkGuardPayrollIds($guardId, $paid_by)
{
    $check = guard_payroll_ids::where('guard_id', $guardId)->where('type', $paid_by)->first();
    if (empty($check)) {
        $rsp['status'] = false;
        $rsp['message'] = 'Guard don\'t have payroll id!';
    } else {
        $rsp['status'] = true;
        $rsp['message'] = 'Guard don\'t have payroll id!';
    }
    return $rsp;
}
function checkShiftAvailability(Request $request)
{
    $response = $this->checkAvailability($request, 'api');
    if ($request->has('admin_id') && $request->admin_id != '') {
        session([
            'userId' => $request->admin_id,
        ]);
    }
    if ($response['message'] == "start") {
        return  response()->json(['status' => false, 'message' => 'You cannot add gaurd before job date.']);
    }
    if ($response['message'] == "end") {
        return response()->json(['status' => false, 'message' => 'You cannot add gaurd after job date.']);
    }
    if ($response['message'] == "added") {
        return response()->json(['status' => true, 'message' => 'Guard added successfully.']);
    }
    if ($response['message'] == "updated") {
        return response()->json(['status' => true, 'message' => 'Roster updated successfully.']);
    }
    if ($response['message'] == "already") {
        return response()->json(['status' => false, 'message' => 'These timings are contradicting with other site timings because this gaurd is already added in another site.']);
    }
    if ($response['message'] == "exceeded") {
        return response()->json(['status' => false, 'message' => 'Guard\'s hours limit exceeded']);
    }
    if ($response['type'] == "Visa Expired") {
        return response()->json(['status' => false, 'message' => 'Visa Expired']);
    }

    if ($response['type'] == "unauthorized") {
        return response()->json(['status' => false, 'message' => $response['message']]);
    }
}

function checkAvailability(Request $request, $call_from = null)
{
    if ($request->temp_start == $request->temp_end) {
        $error["type"] = "unauthorized";
        $error["message"] = 'Start and end time should be differnet!';
        $error['by_pass'] = false;
        if ($call_from == 'api') {
            return $error;
            exit();
        } else {
            return response()->json($error);
            exit;
        }
            // return response()->json($error);
    }

    $formData = $request;
    if (!$request->has('by_pass')) {
        $formData->by_pass = false;
    }
    if (session()->has('isAdmin') && session::get('isAdmin') == 1) {
        $formData->by_pass = true;
    } elseif ($request->has('admin_id') && $request->admin_id  != '') {
        $admin = DB::table('administrators')->where('id', $request->admin_id)->where('is_super_admin', 1)->first();
        if ($request->has('admin_id') && $request->admin_id != '') {
            session([
                'userId' => $request->admin_id,
            ]);
        }
        if (!empty($admin)) {
            $formData->by_pass = true;
        }
    }
    if (!$request->has('publish_status')) {
        $formData->publish_status = 0;
    }
    if (!$request->has('payable')) {
        $formData->payable = 'yes';
    }
    if (!$request->has('chargeable')) {
        $formData->chargeable = 'yes';
    }
    if (!$request->has('custom_rates')) {
        $formData->custom_rates = 'no';
    }
    if (!$request->has('payrate_id')) {
        $formData->payrate_id = 0;
    }
    if (!$request->has('chargerate_id')) {
        $formData->chargerate_id = 0;
    }
    if (!$request->has('training')) {
        $formData->training = 0;
    }
    if (!$request->has('continuation')) {
        $formData->continuation = 0;
    }
    if (!$request->has('travel_time')) {
        $formData->travel_time = 0;
    }
    if ($request->has('travel_time') && $request->travel_time == '') {
        $formData->travel_time = 0;
    }
    if (!$request->has('public_holiday')) {
        $formData->public_holiday = 0;
    }
    if (!$request->has('overtime')) {
        $formData->overtime = 0;
    }
    if (!$request->has('overtime_value')) {
        $formData->overtime_value = 1;
    }
    if ($request->has('overtime_value') && $request->overtime_value == 0) {
        $formData->overtime_value = 1;
    }
    if (!$request->has('travel_time_amount')) {
        $formData->travel_time_amount = '';
    }
    if (!$request->has('travel_time_amount_chargeable')) {
        $formData->travel_time_amount_chargeable = '';
    }
    if (!$request->has('paid_by')) {
        $formData->paid_by = '';
    }
    if (!$request->has('notify')) {
        $formData->notify = 'true';
    }

    if (!$request->has('pw_order')) {
        $formData->pw_order = '';
    }
    if ($request->has('tasks')) {
            // $formData->tasks = json_encode($formData->tasks);
        $formData->tasks = $formData->tasks;
    } else {
        $formData->tasks = json_encode(array());
    }
    if (!$request->has('operators_notes')) {
        $formData->operators_notes = null;
    }
    if (!$request->has('travel_time_payable')) {
        $formData->travel_time_payable = 'yes';
    }
    if (!$request->has('travel_time_chargeable')) {
        $formData->travel_time_chargeable = 'yes';
    }
    if (!$request->has('covid_marshal')) {
        $formData->covid_marshal = 0;
    }
    if (!$request->has('unpublish_shift')) {
        $formData->unpublish_shift = 0;
    }
    if (!$request->has('break_enabled')) {
        $formData->break_enabled = 0;
    }
    if (!$request->has('break_deduction_time')) {
        $formData->break_deduction_time = 0;
    }
    if (!$request->has('own_payrate')) {
        $formData->own_payrate = '';
    }
    if (!$request->has('ph_duration')) {
        $formData->ph_duration = '0';
    }
    if ($formData->own_payrate == 'custom') {
        $formData->custom_payrate = $formData->custom_payrate;
    }else{
        $formData->custom_payrate = json_encode([]);
    }
    if (!$request->has('manual_custom_payrate')) {
        $formData->manual_custom_payrate = 0;
    }


    if ($formData->manual_custom_payrate == 1) {
        $formData->manual_custom_payrates = $formData->manual_custom_payrates;
    }else{
        $formData->manual_custom_payrates = json_encode([]);
    }

    if (!$request->has('custom_chargerate')) {
        $formData->custom_chargerate = 0;
    }
    if ($formData->custom_chargerate == 1) {
        $formData->custom_charge_rate = $formData->custom_charge_rate;
    }else{
        $formData->custom_charge_rate = json_encode([]);
    }
        // print_r($formData->custom_payrate);
        // exit();
    if ($request->file('instructions_file')) {
        $public_path = public_path();
        $public_path = str_replace('portal/public', '', $public_path);
        $public_path = str_replace('apis/public', '', $public_path);
        $path = $public_path . 'asset_uploads/';
        $file = $request->file('instructions_file');
        $filename = time() . $file->getClientOriginalName();
        $file->move($path, $filename);
        $formData->instructions_file = $filename;
    } else {
        $formData->instructions_file = '';
    }
    if ($request->has('moke_guard') && $request->moke_guard == 'undefined') {
        $request->moke_guard = '';
    }
    if ($request->has('moke_guard') && $request->eventId > 0) {
        DB::table('job_new_roster')->where('event_id', $request->eventId)->update(['moke_guard' => $request->moke_guard]);
    } elseif ($request->has('moke_guard') && $request->moke_guard != '') {
        $formData->moke_guard = $request->moke_guard;
    } else {
        $formData->moke_guard = '';
    }
    if (session()->has('permissions')) {
        $permissions = json_decode(session()->get('permissions'), true);
    }
    if ($formData->moke_guard != '' && $formData->by_pass == false && (isset($permissions['mock_guard']) && $permissions['mock_guard'] == false)) {
        $error["type"] = "unauthorized";
        $error["message"] = '';
        $error['by_pass'] = false;
        return response()->json($error);
        exit;
    }
    $jobData = $this->getJobData($formData->siteId);
    if ($jobData->state != '') {
        config(['app.timezone' => $this->timezone[$jobData->state]]);
        date_default_timezone_set($this->timezone[$jobData->state]);
    }else{
        config(['app.timezone' => $this->timezone['Victoria']]);
        date_default_timezone_set($this->timezone['Victoria']);
    }
    $guardData = $this->getSingleGuard($formData->guardId);

        // dd($guard_a);
    if ($formData->guardId > 0 && $formData->guardId != null && isset(session()->get('config_arr_job_roster')[0]->add_guards) && session()->get('config_arr_job_roster')[0]->add_guards == 1) {
        if ($jobData->state != $guardData->state) {
            $error["type"] = "unauthorized";
            $error["message"] = 'Guard don\'t belong to ' . $jobData->state . '. Please change guard state first!';
            $error['by_pass'] = false;
            return response()->json($error);
            exit;
        }
    }
    if ($jobData->unpublished_site == 1) {
        $formData->unpublish_shift = 1;
    }
    if (!isset(session()->get('config_arr_job_roster')[0]->documents_bypass) || (isset(session()->get('config_arr_job_roster')[0]->documents_bypass) && session()->get('config_arr_job_roster')[0]->documents_bypass == 0)) {
        if ($formData->covid_marshal == 0) {
            // if ($guardData && $formData->by_pass == false) {
            if ($guardData) {
                $status = $this->checkGuardDocuments($guardData, $request->tempDate);     //Moiz changed it so that guards docs can be bypassed for GSA
            // $status = "Active";
                // print_r($status);
                if ($status != "Active") {
                    // $error["type"] = $status;
                    $error["type"] = "unauthorized";
                    $error["message"] = $status;
                    $error['by_pass'] = false;
                    if ($call_from == 'api') {
                        return $error;
                        exit();
                    } else {
                        return response()->json($error);
                        exit;
                    }
                }
            }
                // exit;

        }
    }
    $time1 = strtotime($formData->end);
    $time2 = strtotime($formData->start);
    $diff = ($time1 - $time2) / (60 * 60);
    $permissions = array();
    if (session()->has('permissions')) {
        $permissions = json_decode(session()->get('permissions'), true);
    }

    if (isset($permissions['22_hour_limit']) && session::get('isAdmin') == 0) {
        // if (isset($permissions['22_hour_limit'])) {
        if ($permissions['22_hour_limit'] == true && $diff > 22  && $diff <= 22 && $formData->by_pass == false) {
            $error["type"] = "unauthorized";
            $error["message"] = "You are not able to roster any guard for more than 22 hours shift.";
            $error['by_pass'] = true;
            $error['permission'] = $permissions;
            if ($call_from == 'api') {
                return $error;
                exit();
            } else {
                return response()->json($error);
                exit;
            }
        }
        elseif ($diff > 22) {
        $error["type"] = "unauthorized";
        $error["message"] = "You are not able to roster any guard for more than 22 hours shift!";
        $error['by_pass'] = false;
        if ($call_from == 'api') {
            return $error;
            exit();
        } else {
            return response()->json($error);
            exit;
        }
    }
    } elseif ($diff > 22 && $formData->by_pass == false) {
        $error["type"] = "unauthorized";
        $error["message"] = "You are not able to roster any guard for more than 22 hours shift!";
        $error['by_pass'] = true;
        if ($call_from == 'api') {
            return $error;
            exit();
        } else {
            return response()->json($error);
            exit;
        }
    }
    // elseif ($diff > 14) {
    //     $error["type"] = "unauthorized";
    //     $error["message"] = "You are not able to roster any guard for more than 14 hours shift!";
    //     $error['by_pass'] = false;
    //     if ($call_from == 'api') {
    //         return $error;
    //         exit();
    //     } else {
    //         return response()->json($error);
    //         exit;
    //     }
    // }
        // exit;
    if ($formData->guardId != '' && $formData->guardId != null) {
        if ($formData->paid_by != '') {
            $validate = $this->checkGuardPayrollIds($formData->guardId, $formData->paid_by);
            if (!$validate['status']) {
                $error["type"] = "unauthorized";
                $error["message"] = $validate['message'];
                $error['by_pass'] = true;
                if ($call_from == 'api') {
                    return $error;
                    exit();
                } else {
                    return response()->json($error);
                    exit;
                }
            }
        }
            // $validate = $this->checkGuardAvailabil($formData->guardId, $formData->paid_by);
            //      if (!$validate['status']) {
            //         $error["type"] = "unauthorized";
            //         $error["message"] = $validate['message'];
            //         $error['by_pass'] = true;
            //         return response()->json($error);
            //         exit;
            // }

    }

    if ($formData->guardId != '' && $formData->guardId != null ) {

        $validate = $this->checkGuardLeaves($formData->guardId, $formData->temp_start, $formData->temp_end);
        if (!$validate) {
            $error["type"] = "unauthorized";
            $error["message"] = "This guard is on leave. You cannot roster him/her.";
            $error['by_pass'] = true;
            if ($call_from == 'api') {
                return $error;
                exit();
            } else {
                return response()->json($error);
                exit;
            }
        }
        if ($formData->guardId != '' && $formData->guardId > 0 && $formData->guardId != null && $formData->by_pass == false) {
            $validate = $this->checkGuardLastShift($formData->guardId, $formData->temp_start, $formData->temp_end, $formData->eventId);
            // dd($validate);
                // print_r($validate);
            if (!$validate['status']) {
                $error["type"] = "unauthorized";
                if (isset($validate['message'])) {
                    $error['message'] = $validate['message'];
                } else {
                    $error["message"] = "This guard just completed his/her last job. The 8-hours rest time is not completed yet. You cannot roster him/her.";
                }
                if (session()->get('isAdmin') == 0) {
                    $permissions = array();
                    $is_super_admin = 0;
                    if (session()->has('permissions')) {
                        $permissions = json_decode(session()->get('permissions'), true);
                    }
                    if (isset($permissions['break_bypass']) && $permissions['break_bypass'] == true) {

                    } else {
                        $error['by_pass'] = true;
                        if ($call_from == 'api') {
                            return $error;
                            exit();
                        } else {
                            return response()->json($error);
                            exit;
                        }
                    }
                } else {
                    $error['by_pass'] = true;
                    if ($call_from == 'api') {
                        return $error;
                        exit();
                    } else {
                        return response()->json($error);
                        exit;
                    }
                }
            }
                // exit;
        }
    }

    if ($formData->eventId > 1) {
        $rosterD = DB::table('job_new_roster')->where('event_id', $formData->eventId)->first();
        if ($rosterD->job_status == 'completed' || $rosterD->signin_status == 1) {
            if ($rosterD->guard_id != $formData->guardId) {
                $error["type"] = "unauthorized";
                $error["message"] = "You can't change guard now!";
                $error['by_pass'] = false;
                if ($call_from == 'api') {
                    return $error;
                    exit();
                } else {
                    return response()->json($error);
                    exit;
                }
            }
        }
    }

        // Check if guard is assigned to the specified site or not
    if ($formData->guardId && isset(session()->get('config_arr_job_roster')[0]->add_guards) && session()->get('config_arr_job_roster')[0]->add_guards == 1) {
        $validate = $this->validateGuard($formData->siteId, $formData->guardId);
        if (!$validate) {
            $error["type"] = "unauthorized";
            $error['by_pass'] = true;
            $error["message"] = "Specified guard does not belong to the specified site.";
            if ($call_from == 'api') {
                return $error;
                exit();
            } else {
                return response()->json($error);
                exit;
            }
        }
    }
    if (!empty($jobData)) {
        $jobStart = strtotime($jobData->start);
        $start = $formData->start;
        $start = explode("T", $start);
        $start = strtotime(trim($start[0]));
        if ($start < $jobStart) {
            $error["message"] = "start";
            if ($call_from == 'api') {
                return $error;
                exit();
            } else {
                return response()->json($error);
                exit;
            }
        }

        if (!empty($jobData->end)) {
            $jobEnd = strtotime($jobData->end);

            $end = $formData->end;
            $end = explode("T", $end);
            $end = strtotime(trim($end[0]));

            if ($end > $jobEnd) {
                $error["message"] = "end";
                if ($call_from == 'api') {
                    return $error;
                    exit();
                } else {
                    return response()->json($error);
                    exit;
                }
            }
        }

        if (!empty($guardData)) {

            if ($guardData->covid == 1) {
                $error["type"] = "unauthorized";
                $error['by_pass'] = false;
                $error["message"] = "Specified guard is not available due to COVID 19.";
                if ($call_from == 'api') {
                    return $error;
                    exit();
                } else {
                    return response()->json($error);
                    exit;
                }
            }


            if (!empty($guardData->work_limitation_status)) {
                if ($guardData->work_limitation_status == "active") {

                    $totalWorkingHours = $guardData->fortnightly_working_hours;
                    $timestamp1 = strtotime($formData->temp_start);
                    $timestamp2 = strtotime($formData->temp_end);

                    if (empty($timestamp2)) {
                        $timestamp2 = strtotime($formData->temp_start);
                    }

                    $date = new DateTime($formData->temp_start);
                    $week_no = $date->format("W");
                    $week_array = $this->getStartAndEndDate($week_no, date('Y'));

                    $newCurrentHours = abs($timestamp2 - $timestamp1) / (60 * 60);

                    $currentMonthData = $this->get_current_month_hours_guards($formData->guardId, $week_array['week_start'], $week_array['week_end']);

                    $addedHours = 0;


                    $calander_start_date = new DateTime($formData->temp_start);
                    $calender_end_date = new DateTime($formData->temp_end);
                    $fortnight_start_date = new DateTime($week_array['week_start']);
                    $fortnight_end_date = new DateTime($week_array['week_end']);

                    if (!empty($currentMonthData)) {
                        foreach ($currentMonthData as $currentMonthDatas) {
                            $timestamps1 = strtotime($currentMonthDatas->temp_start);
                            $timestamps2 = strtotime($currentMonthDatas->temp_end);
                            $addedHours += abs($timestamps2 - $timestamps1) / (60 * 60);
                        }
                    }

                    $dates_periods = array();
                    $period = new DatePeriod(
                        new DateTime($fortnight_start_date->format("Y-m-d")),
                        new DateInterval('P1D'),
                        new DateTime($fortnight_end_date->format("Y-m-d"))
                    );

                    foreach ($period as $key => $value) {
                        array_push($dates_periods, $value->format('Y-m-d'));
                    }
                    array_push($dates_periods, $fortnight_end_date->format("Y-m-d"));

                    if (in_array($calander_start_date->format("Y-m-d"), $dates_periods)) {

                        if ($addedHours >= $totalWorkingHours && $formData->by_pass == false) {
                            $error['by_pass'] = true;
                            $error['alredy_done'] = $addedHours;
                            $error["message"] = "exceeded";
                            if ($call_from == 'api') {
                                return $error;
                                exit();
                            } else {
                                return response()->json($error);
                                exit;
                            }
                        }

                        if ($newCurrentHours > $totalWorkingHours && $formData->by_pass == false) {
                            $error["message"] = "exceeded";
                            $error['alredy_done'] = $addedHours;
                            $error['by_pass'] = true;
                            if ($call_from == 'api') {
                                return $error;
                                exit();
                            } else {
                                return response()->json($error);
                                exit;
                            }
                        }

                        $newAddedHours = $addedHours + $newCurrentHours;

                        if ($newAddedHours > $totalWorkingHours && $formData->by_pass == false) {
                            $error['by_pass'] = true;
                            $error["message"] = "exceeded";
                            $error['alredy_done'] = $addedHours;
                            if ($call_from == 'api') {
                                return $error;
                                exit();
                            } else {
                                return response()->json($error);
                                exit;
                            }
                        }
                    }


                    if (empty($addedHours)) {
                        if ($call_from == 'api') {
                            return $this->guard_function($formData);
                            exit();
                        } else {
                            return response()->json($this->guard_function($formData));

                            exit;
                        }
                    } else {


                        if (!empty($guardData[0]->fortnightly_working_start)) {
                            $returnStatus = $this->guard_model->checkFortnight($start, $formData->guardId);
                            if (!empty($returnStatus) && $formData['by_pass'] == false) {
                                $error["message"] = "beyond";
                                $error['by_pass'] = true;
                                if ($call_from == 'api') {
                                    return $error;
                                    exit();
                                } else {
                                    return response()->json($error);
                                    exit;
                                }
                            } else {
                                if ($call_from == 'api') {
                                    return $this->guard_function($formData);
                                    exit();
                                } else {
                                    return response()->json($this->guard_function($formData));
                                    exit;
                                }
                            }
                        } else {
                            if ($call_from == 'api') {
                                return $this->guard_function($formData);
                                exit();
                            } else {
                                return response()->json($this->guard_function($formData));
                                exit;
                            }
                        }
                    }
                } else {

                    if (!empty($formData->save)) {

                        $flag = $this->availablity($formData->temp_start, $formData->temp_end, $formData->guardId, $formData->siteId, $formData->eventId);

                        if ($flag) {
                            $error["message"] = "already";
                            if ($call_from == 'api') {
                                return $error;
                                exit();
                            } else {
                                return response()->json($error);
                                exit;
                            }
                        } else {
                            if (!empty($formData->save)) {
                                if (empty($formData->end) || $formData->end == 'Invalid date') {
                                    $formData->end = $formData->start;
                                }
                                if (empty($formData->temp_end)) {
                                    $formData->temp_end = $formData->temp_start;
                                }
                                $rosterData = $this->rosterData($formData->eventId);
                                if (!empty($rosterData)) {
                                    if (isset($formData->shifIsPressed) && $formData->shifIsPressed == 'true') {
                                        if ($formData->has('eventId') && $formData->eventId > 0) {
                                            $tasks = DB::table('job_roster_tasks')->join('job_new_roster', 'job_new_roster.roster_id', '=', 'job_roster_tasks.roster_id')->where('job_new_roster.event_id', '=', $formData->eventId)->select('job_roster_tasks.task_name as task_description', 'job_roster_tasks.task_time as task_start_time')->get();
                                            $formData->tasks = json_encode($tasks);
                                            $notes = DB::table('job_new_roster')->where('event_id', $formData->eventId)->value('operators_notes');
                                            $formData->operators_notes = $notes;
                                        }

                                            // $this->guard_model->log_user_activities_in_roster($formData->eventId, 'shift_add');
                                        $eventStatus = $this->addEvent(0, $formData->start, $formData->end, $formData->guardId, $formData->siteId, $formData->tempDate, $formData->temp_start, $formData->temp_end, 0, $formData->tasks, $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time, $formData->operators_notes, $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);
                                        if ($eventStatus) {
                                            $action = 'shift_drag_copy';
                                            $this->administrator->log_user_activity($action, $rosterData);
                                        }

                                    } else {
                                            // $this->guard_model->log_user_activities_in_roster($formData->eventId, 'shift_change');
                                        $eventStatus = $this->eventUpdateDrop($formData->eventId, $formData->start, $formData->end, $formData->tempDate, $formData->temp_start, $formData->temp_end, $formData->guardId, $formData->tasks, $formData->operators_notes, null,  $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->notify, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time, $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);
                                    }
                                    if ($eventStatus) {
                                        $statu["message"] = "updated";
                                    } else {
                                        $statu["message"] = "not_updated";
                                    }
                                    if ($call_from == 'api') {
                                        return $statu;
                                        exit();
                                    } else {
                                        return response()->json($statu);
                                        exit;
                                    }
                                } else {

                                    $eventStatus = $this->addEvent($formData->eventId, $formData->start, $formData->end, $formData->guardId, $formData->siteId, $formData->tempDate, $formData->temp_start, $formData->temp_end, 0, $formData->tasks, $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time, $formData->operators_notes, $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);
                                    if ($eventStatus) {
                                            // $this->guard_model->log_user_activities_in_roster($formData->eventId, 'shift_add');

                                        $statu["message"] = "added";
                                    } else {
                                        $statu["message"] = "not_added";
                                    }
                                    if ($call_from == 'api') {
                                        return $statu;
                                        exit();
                                    } else {
                                        return response()->json($statu);
                                        exit;
                                    }
                                }
                            } else {
                                $error["message"] = "added";
                            }
                        }
                        if ($call_from == 'api') {
                            return $error;
                            exit();
                        } else {
                            return response()->json($error);
                            exit;
                        }
                    }
                        // $error["message"] = "added";
                    $error["type"] = "unauthorized";
                    $error["message"] = "Fail to add shift";
                    $error['by_pass'] = false;
                    if ($call_from == 'api') {
                        return $error;
                        exit();
                    } else {
                        return response()->json($error);
                        exit;
                    }
                }
            } else {


                if (!empty($formData->save)) {

                    $flag = $this->availablity($formData->temp_start, $formData->temp_end, $formData->guardId, $formData->siteId, $formData->eventId);

                    if ($flag) {
                        $error["message"] = "already";
                        if ($call_from == 'api') {
                            return $error;
                            exit();
                        } else {
                            return response()->json($error);
                            exit;
                        }
                    } else {
                        if (!empty($formData->save)) {
                            if (empty($formData->end) || $formData->end == 'Invalid date') {
                                $formData->end = $formData->start;
                            }
                            if (empty($formData->temp_end)) {
                                $formData->temp_end = $formData->temp_start;
                            }
                            $rosterData = $this->rosterData($formData->eventId);
                            if (!empty($rosterData)) {
                                if (isset($formData->shifIsPressed) && $formData->shifIsPressed == 'true') {
                                    if ($formData->has('eventId') && $formData->eventId > 0) {
                                        $tasks = DB::table('job_roster_tasks')->join('job_new_roster', 'job_new_roster.roster_id', '=', 'job_roster_tasks.roster_id')->where('job_new_roster.event_id', '=', $formData->eventId)->select('job_roster_tasks.task_name as task_description', 'job_roster_tasks.task_time as task_start_time')->get();
                                        $formData->tasks = json_encode($tasks);
                                        $notes = DB::table('job_new_roster')->where('event_id', $formData->eventId)->value('operators_notes');
                                        $formData->operators_notes = $notes;
                                    }

                                        // $this->guard_model->log_user_activities_in_roster($formData->eventId, 'shift_add');
                                    $eventStatus = $this->addEvent(0, $formData->start, $formData->end, $formData->guardId, $formData->siteId, $formData->tempDate, $formData->temp_start, $formData->temp_end, 0, $formData->tasks, $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time,$formData->operators_notes, $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);
                                    if ($eventStatus) {
                                        $action = 'shift_drag_copy';
                                        $this->administrator->log_user_activity($action, $rosterData);
                                    }
                                        // exit();

                                } else {
                                        // $this->guard_model->log_user_activities_in_roster($formData->eventId, 'shift_change');
                                    $eventStatus = $this->eventUpdateDrop($formData->eventId, $formData->start, $formData->end, $formData->tempDate, $formData->temp_start, $formData->temp_end, $formData->guardId, $formData->tasks, $formData->operators_notes, null,  $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->notify, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time, $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);
                                }
                                if ($eventStatus) {
                                    $statu["message"] = "updated";
                                } else {
                                    $statu["message"] = "not_updated";
                                }
                                if ($call_from == 'api') {
                                    return $error;
                                    exit();
                                } else {
                                    return response()->json($statu);
                                    exit;
                                }
                            } else {

                                $eventStatus = $this->addEvent($formData->eventId, $formData->start, $formData->end, $formData->guardId, $formData->siteId, $formData->tempDate, $formData->temp_start, $formData->temp_end, 0, $formData->tasks, $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time, $formData->operators_notes, $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);

                                if ($eventStatus) {
                                        // $this->guard_model->log_user_activities_in_roster($formData->eventId, 'shift_add');

                                    $statu["message"] = "added";
                                } else {
                                    $statu["message"] = "not_added";
                                }
                                if ($call_from == 'api') {
                                    return $error;
                                    exit();
                                } else {
                                    return response()->json($statu);
                                    exit;
                                }
                            }
                        } else {
                            $error["message"] = "added";
                        }
                    }
                    if ($call_from == 'api') {
                        return $error;
                        exit();
                    } else {
                        return response()->json($error);
                        exit;
                    }
                }
                $error["message"] = "added";
                if ($call_from == 'api') {
                    return $error;
                    exit();
                } else {
                    return response()->json($error);
                    exit;
                }
            }
        } else {

                // If guard is not mentioned then add an entery with "No guard accepted the job"
            $rosterData = $this->rosterData($formData->eventId);
                if (!empty($rosterData)) { // Check whether the data is being updated

                    if ($formData->has('shifIsPressed') && $formData->shifIsPressed == 'true') {
                        if ($formData->has('eventId') && $formData->eventId > 0) {
                            $tasks = DB::table('job_roster_tasks')->join('job_new_roster', 'job_new_roster.roster_id', '=', 'job_roster_tasks.roster_id')->where('job_new_roster.event_id', '=', $formData->eventId)->select('job_roster_tasks.task_name as task_description', 'job_roster_tasks.task_time as task_start_time')->get();
                            $formData->tasks = json_encode($tasks);
                            $notes = DB::table('job_new_roster')->where('event_id', $formData->eventId)->value('operators_notes');
                            $formData->operators_notes = $notes;
                        }
                        // $this->guard_model->log_user_activities_in_roster($formData->eventId, 'shift_add');
                        $eventStatus = $this->addEvent(0, $formData->start, $formData->end, null, $formData->siteId, $formData->tempDate, $formData->temp_start, $formData->temp_end, 0, $formData->tasks, $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time, $formData->operators_notes, $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);
                        if ($eventStatus) {
                            $action = 'shift_drag_copy';
                            $this->administrator->log_user_activity($action, $rosterData);
                        }
                        // exit();

                    } else {
                        // $this->guard_model->log_user_activities_in_roster($formData->eventId, 'shift_change');
                        $eventStatus = $this->eventUpdateDrop($formData->eventId, $formData->start, $formData->end, $formData->tempDate, $formData->temp_start, $formData->temp_end, $formData->guardId, $formData->tasks, $formData->operators_notes, 'pending', $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->notify, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time, $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);
                    }
                    if ($eventStatus) {

                        $status["message"] = "updated";
                    } else {
                        $status["message"] = "not_updated";
                    }
                    if ($call_from == 'api') {
                        return $status;
                        exit();
                    } else {
                        return response()->json($status);
                        exit;
                    }
                } else { // If no record found then add a new record with guard id null and post_status 1
                    if (isset($formData->post_status)) {
                        $post_status = 0;
                    } else {
                        $post_status = 1;
                    }

                    // $this->guard_model->log_user_activities_in_roster($formData->eventId, 'shift_change');
                    $eventStatus = $this->addEvent($formData->eventId, $formData->start, $formData->end, null, $formData->siteId, $formData->tempDate, $formData->temp_start, $formData->temp_end, $post_status, $formData->tasks, $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time,$formData->operators_notes,  $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);
                    if ($eventStatus) {
                        $status["message"] = "added";
                    } else {
                        $status["message"] = "not_added";
                    }
                    if ($call_from == 'api') {
                        return $status;
                        exit();
                    } else {
                        return response()->json($status);
                        exit;
                    }
                }
            }
        }
    }

    public function availablity($start, $end, $guardId, $jobId, $eventId)
    {

        if (empty($end)) {

            $end = $start;
        }

        // $sqlQuery = "SELECT * FROM `job_new_roster` WHERE `event_id`!='".$eventId."' AND `guard_id` = '".$guardId."' AND (temp_start BETWEEN '".$start."' AND '".$end."')";
        $data = job_new_roster::where('event_id', '!=', $eventId)
        ->where('guard_id', '=', $guardId)
        ->whereBetween('temp_start', [$start, $end])->first();

        if (empty($data)) {


            $data = job_new_roster::where('event_id', '!=', $eventId)
            ->where('guard_id', '=', $guardId)
            ->whereBetween('temp_end', [$start, $end])->first();
        }
        if (empty($data)) {

            $data = job_new_roster::where('event_id', '!=', $eventId)
            ->where('guard_id', '=', $guardId)
            ->where('temp_start', '<=', $start)
            ->where('temp_end', '>=', $start)
            ->first();
        }
        if (empty($data)) {

            $data = job_new_roster::where('event_id', '!=', $eventId)
            ->where('guard_id', '=', $guardId)
            ->where('temp_start', '<=', $end)
            ->where('temp_end', '>=', $end)
            ->first();
        }

        if (!empty($data)) {

            $flag = 1;
        } else {

            $flag = 0;
        }

        return $flag;
    }

    public function rosterData($rosterId, $guardId = 0)
    {

        $data = job_new_roster::where('event_id', $rosterId);
        if ($guardId) {
            $data->where("guard_id", $guardId);
        }
        $data = $data->first();

        return $data;
    }

    public function rosterDataNew($rosterId, $guardId = 0)
    {

        $data = job_new_roster::where('roster_id', $rosterId);
        if ($guardId) {
            $data->where("guard_id", $guardId);
        }
        $data = $data->first();

        return $data;
    }

    public function guard_function($formData)
    {
        $flag = $this->availablity($formData->temp_start, $formData->temp_end, $formData->guardId, $formData->siteId, $formData->eventId);

        if ($flag) {
            $error["message"] = "already";
            return $error;
            exit();
        } else {
            if (!empty($formData->save)) {
                $roster = job_new_roster::where('event_id', $formData->eventId)->first();

                if (!empty($roster)) {
                    if ($roster->guard_id != $formData->guardId) {
                        job_new_roster::where('roster_id', $roster->roster_id)->update(['job_status' => 'pending']);
                    }
                }
                if (empty($formData->end) || $formData->end == 'Invalid date') {
                    $formData->end = $formData->start;
                }
                if (empty($formData->temp_end)) {
                    $formData->temp_end = $formData->temp_start;
                }
                $rosterData = $this->rosterData($formData->eventId, $formData->guardId);

                if (!empty($rosterData)) {
                    if (isset($formData->shifIsPressed) && $formData->shifIsPressed == 'true') {
                        if ($formData->has('eventId') && $formData->eventId > 0) {
                            $tasks = DB::table('job_roster_tasks')->join('job_new_roster', 'job_new_roster.roster_id', '=', 'job_roster_tasks.roster_id')->where('job_new_roster.event_id', '=', $formData->eventId)->select('job_roster_tasks.task_name as task_description', 'job_roster_tasks.task_time as task_start_time')->get();
                            $formData->tasks = json_encode($tasks);
                            $notes = DB::table('job_new_roster')->where('event_id', $formData->eventId)->value('operators_notes');
                            $formData->operators_notes = $notes;
                        }

                        $eventStatus = $this->addEvent(0, $formData->start, $formData->end, $formData->guardId, $formData->siteId, $formData->tempDate, $formData->temp_start, $formData->temp_end, 0, $formData->tasks, $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time, $formData->operators_notes, $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);
                        if ($eventStatus) {
                            $action = 'shift_drag_copy';
                            $this->administrator->log_user_activity($action, $rosterData);
                        }
                    } else {
                        // $this->guard_model->log_user_activities_in_roster($formData->eventId, 'shift_change');

                        $eventStatus = $this->eventUpdateDrop($formData->eventId, $formData->start, $formData->end, $formData->tempDate, $formData->temp_start, $formData->temp_end, $formData->guardId, $formData->tasks, $formData->operators_notes, null, $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->notify, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time, $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);
                    }
                    if ($eventStatus) {
                        $status["message"] = "updated";
                    } else {
                        $status["message"] = "not_updated";
                    }
                    return $status;
                    exit;
                } elseif ($formData->guardId != '' && $formData->eventId > 0 && !empty($roster)) {
                    if (isset($formData->shifIsPressed) && $formData->shifIsPressed == 'true') {
                        if ($formData->has('eventId') && $formData->eventId > 0) {
                            $tasks = DB::table('job_roster_tasks')->join('job_new_roster', 'job_new_roster.roster_id', '=', 'job_roster_tasks.roster_id')->where('job_new_roster.event_id', '=', $formData->eventId)->select('job_roster_tasks.task_name as task_description', 'job_roster_tasks.task_time as task_start_time')->get();
                            $formData->tasks = json_encode($tasks);
                            $notes = DB::table('job_new_roster')->where('event_id', $formData->eventId)->value('operators_notes');
                            $formData->operators_notes = $notes;
                        }

                        // $this->guard_model->log_user_activities_in_roster($formData->eventId, 'shift_add');
                        $eventStatus = $this->addEvent(0, $formData->start, $formData->end, $formData->guardId, $formData->siteId, $formData->tempDate, $formData->temp_start, $formData->temp_end, 0, $formData->tasks, $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time, $formData->operators_notes, $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);
                        if ($eventStatus) {
                            $action = 'shift_drag_copy';
                            $this->administrator->log_user_activity($action, $rosterData);
                        }
                    } else {
                        // $this->guard_model->log_user_activities_in_roster($formData->eventId, 'guard_assign');

                        $eventStatus = $this->eventUpdateGuardDrop($formData->eventId, $formData->start, $formData->end, $formData->tempDate, $formData->temp_start, $formData->temp_end, $formData->guardId, $formData->tasks, $formData->operators_notes, null, $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->notify, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time, $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);
                    }
                    if ($eventStatus) {
                        $status["message"] = "updated";
                    } else {
                        $status["message"] = "not_updated";
                    }
                    return $status;
                    exit;
                } else {

                    $eventStatus = $this->addEvent($formData->eventId, $formData->start, $formData->end, $formData->guardId, $formData->siteId, $formData->tempDate, $formData->temp_start, $formData->temp_end, 0, $formData->tasks, $formData->payable, $formData->chargeable, $formData->custom_rates, $formData->payrate_id, $formData->chargerate_id, $formData->publish_status, $formData->training, $formData->continuation, $formData->travel_time, $formData->paid_by, $formData->public_holiday, $formData->travel_time_payable, $formData->travel_time_chargeable, $formData->covid_marshal, $formData->moke_guard, $formData->travel_time_amount, $formData->overtime, $formData->overtime_value, $formData->travel_time_amount_chargeable, $formData->unpublish_shift, $formData->instructions_file, $formData->break_enabled, $formData->break_deduction_time,$formData->operators_notes, $formData->own_payrate, $formData->custom_payrate, $formData->ph_duration, $formData->manual_custom_payrate, $formData->manual_custom_payrates, $formData->pw_order, $formData->custom_chargerate, $formData->custom_charge_rate);
                    if ($eventStatus) {
                        // $this->guard_model->log_user_activities_in_roster($formData->eventId, 'shift_add');
                        $status["message"] = "added";
                    } else {
                        $status["message"] = "not_added";
                    }
                    return $status;
                    // exit;
                }
            } else {
                $error["message"] = "added";
            }
        }
        return $error;
    }

    public function eventUpdateDrop($rosterId, $start, $end, $temp_date, $temp_start, $temp_end, $guard_id = null, $tasks = null, $operators_notes = null, $status = null, $payable = 'yes', $chargeable = 'yes', $custom_rates = 'no', $payrate_id = 0, $chargerate_id = 0, $publish_status = 0, $training = 0, $continuation = 0, $travel_time = 0, $paid_by = '', $notify = 'false', $public_holiday = 0, $travel_time_payable = 'yes', $travel_time_chargeable = 'yes', $covid_marshal = 0, $moke_guard = '', $travel_time_amount = 0, $overtime = 0, $overtime_value = 1, $travel_time_amount_chargeable = 0, $unpublish_shift = 0, $instructions_file = '', $break_enabled = 0, $break_deduction_time = 0, $own_payrate = '', $custom_payrate = '', $ph_duration = 0, $manual_custom_payrate = 0, $manual_custom_payrates = '', $pw_order = '', $custom_chargerate = 0, $custom_charge_rate = '')
    {

        $rosterdata = job_new_roster::where(array('event_id' => $rosterId))->first();
        $action = 'shift_change';
        $current_guard = $guard_id;
        $this->administrator->log_user_activity($action, $rosterdata);
        $data = array(

            "start" => $start,

            "end" => $end,

            "temp_date" => $temp_date,

            "temp_start" => $temp_start,

            "temp_end" => $temp_end,

            "add_status" => 1,

            'job_start' => strtotime($temp_start),

            'job_end' => strtotime($temp_end),

            // 'record_update' => 1,
            // 'job_status' => 'pending',
            'payable' => $payable,
            // 'publish_status' => 0,
            'chargeable' => $chargeable,
            'custom_rates' => $custom_rates,
            'payrate_id' => $payrate_id,
            'chargerate_id' => $chargerate_id,
            // 'publish_status'=> $publish_status,
            'training' => $training,
            'continuation' => $continuation,
            'travel_time' => $travel_time,
            'paid_by' => $paid_by,
            'public_holiday' => $public_holiday,
            'travel_time_payable' => $travel_time_payable,
            'travel_time_chargeable' => $travel_time_chargeable,
            'covid_marshal' => $covid_marshal,
            'moke_guard' => $moke_guard,
            'overtime' => $overtime,
            'travel_time_amount_chargeable' => $travel_time_amount_chargeable,
            'travel_time_amount' => $travel_time_amount,
            'overtime_value' => $overtime_value,
            'unpublish_shift' => $unpublish_shift,
            'break_enabled' => $break_enabled,
            'break_deduction_time' => $break_deduction_time,
            'own_payrate' => $own_payrate,
            'custom_payrate' => $custom_payrate,
            'ph_duration' => 0,
            'manual_custom_payrate' => $manual_custom_payrate,
            'manual_custom_payrates' => $manual_custom_payrates,
            'pw_order' => $pw_order,
            'custom_chargerate' => $custom_chargerate,
            'custom_charge_rate' => $custom_charge_rate


        );
        if ($instructions_file != '') {
            $data['instructions_file'] = $instructions_file;
        }
        $data['hours'] = round(abs($data['job_end'] - $data['job_start']) / 3600, 2);
        if ($guard_id == 0 || $guard_id == '') {
            $data['job_status'] = 'pending';
        }
        if ($operators_notes != null && $operators_notes != '') {
            $data['operators_notes'] = $operators_notes;
        } else {
            $data['operators_notes'] = '';
        }
        // if($guard_id != null)
        // {
        $data['guard_id'] = $guard_id;
        // }
        if ($tasks != null) {
            $data['tasks'] = $tasks;
        }
        $new_guard = $rosterdata->guard_id;
        // if ($current_guard != $new_guard || $rosterdata->job_start != $data['job_start'] || $rosterdata->job_end != $data['job_end']) {
        //     $data['publish_status'] = 0;
        // }
         if ($rosterdata->signin_status == 1 || $rosterdata->job_status == 'completed') {
            $data['job_status'] = $rosterdata->job_status;
            $data['publish_status'] = $rosterdata->publish_status;
        } elseif ($notify == 'true') {
            $data['record_update'] = 1;
            // $data['job_status'] = $rosterdata->job_status;
            // $data['job_status'] = 'pending';
             if ($publish_status == 1) {
            $data['publish_status'] = 1;
                
            }else{
            $data['publish_status'] = 0;
        }
        }
        elseif ($notify == 'false') {
            // $data['record_update'] = 1;
            // $data['job_status'] = $rosterdata->job_status;
            // $data['job_status'] = 'pending';
            $data['publish_status'] = $rosterdata->publish_status;
        }
        // echo json_encode($data);
        // exit();
        if (isset($data['publish_status']) && $data['publish_status'] == 1) {
            $data['record_update'] = 0;
        }

        if ($unpublish_shift == 1) {
            $data['publish_status'] = 1;
        }
        if ($data['payrate_id'] > 0) {
            $payrates = DB::table('payrates')->where('id', $data['payrate_id'])->where('archive', 0)->first();
            $data['payrate_applied'] = json_encode($payrates);
        }
        job_new_roster::where('event_id', $rosterId)->update($data);
        $roster_id = $rosterdata->roster_id;
        $this->guard_model->logPayChargeRate($roster_id);
        $tasks = json_decode($tasks, true);
        if ($guard_id == null) {
            $guard_id = 0;
        }
        if (is_array($tasks) && !empty($tasks)) {
            foreach ($tasks as $t) {
                if (isset($t['task_id']) && $t['task_id'] != '') {
                    DB::table('job_roster_tasks')->where('id', $t['task_id'])->update(
                        array(
                            'roster_id' => $roster_id,
                            'guard_id' => $guard_id,
                            'task_name' => $t['task_description'],
                            'task_time' => $t['task_start_time'],
                            'status' => 'pending'
                        )
                    );
                } else {
                    DB::table('job_roster_tasks')->insert(
                        array(
                            'roster_id' => $roster_id,
                            'guard_id' => $guard_id,
                            'task_name' => $t['task_description'],
                            'task_time' => $t['task_start_time'],
                            'status' => 'pending'
                        )
                    );
                    if ($unpublish_shift == 0 && $guard_id > 0) {
                        $guard_data = DB::table('guards')->where('id', $guard_id)->first();
                        $notification_data['guards'][0] = array(
                            'guard_id' => $guard_data->id,
                            'notification_token' => $guard_data->notification_token
                        );
                        $notification_data['title'] = 'New task added';
                        $notification_data['message'] = 'New Task - New task is added in your task';
                        $notification_data['page'] = 'homepage';
                        $res = $this->guard_model->send_push_notification($notification_data);
                    }
                }
            }
        }
        DB::table('roster_complete_activity')->insert([
            'roster_id' => $roster_id,
            'activity' => 'Shift edited',
            'type' => 'shift_edit',
            'record_id' => $roster_id,
            'activity_time' => time(),
            'activity_by' => session('userId')
        ]);
        $this->updateHoursDistribution($temp_start, $temp_end, $rosterdata->site_id, $rosterdata->roster_id);
        return true;
    }

    public function eventUpdateGuardDrop($rosterId, $start, $end, $temp_date, $temp_start, $temp_end, $guardId, $tasks = null, $operators_notes = null, $status = null, $payable = 'yes', $chargeable = 'yes', $custom_rates = 'no', $payrate_id = 0, $chargerate_id = 0, $publish_status = 0, $training = 0, $continuation = 0, $travel_time = 0, $paid_by = '',  $notify = 'false', $public_holiday = 0, $travel_time_payable = 'yes', $travel_time_chargeable = 'yes', $covid_marshal = 0, $moke_guard = '', $travel_time_amount = 0, $overtime = 0, $overtime_value = 1, $travel_time_amount_chargeable = 0, $unpublish_shift = 0, $instructions_file = '', $break_enabled = 0, $break_deduction_time = 0,  $own_payrate = '', $custom_payrate = '', $ph_duration = 0, $manual_custom_payrate = 0, $manual_custom_payrates = '', $pw_order = '', $custom_chargerate = 0, $custom_charge_rate = '')
    {
        $rosterdata = job_new_roster::where(array('event_id' => $rosterId))->first();

        $current_guard = $guardId;

        $data = array(

            "start" => $start,

            "end" => $end,

            "temp_date" => $temp_date,

            "temp_start" => $temp_start,

            "temp_end" => $temp_end,

            "add_status" => 1,

            "guard_id" => $guardId,

            'job_start' => strtotime($temp_start),

            'job_end' => strtotime($temp_end),

            // 'record_update' => 1,
            // 'job_status' => 'pending',
            'payable' => $payable,
            // 'publish_status' => 0,
            'chargeable' => $chargeable,
            'custom_rates' => $custom_rates,
            'payrate_id' => $payrate_id,
            'chargerate_id' => $chargerate_id,
            'publish_status'=> $publish_status,
            'training' => $training,
            'continuation' => $continuation,
            'travel_time' => $travel_time,
            'paid_by' => $paid_by,
            'public_holiday' => $public_holiday,
            'travel_time_payable' => $travel_time_payable,
            'travel_time_chargeable' => $travel_time_chargeable,
            'covid_marshal' => $covid_marshal,
            'moke_guard' => $moke_guard,
            'overtime' => $overtime,
            'travel_time_amount' => $travel_time_amount,
            'travel_time_amount_chargeable' => $travel_time_amount_chargeable,
            'overtime_value' => $overtime_value,
            'unpublish_shift' => $unpublish_shift,
            'break_enabled' => $break_enabled,
            'break_deduction_time' => $break_deduction_time,
            'own_payrate' => $own_payrate,
            'custom_payrate' => $custom_payrate,
            'ph_duration' => 0,
            'manual_custom_payrate' => $manual_custom_payrate,
            'manual_custom_payrates' => $manual_custom_payrates,
            'pw_order' => $pw_order,
            'custom_chargerate' => $custom_chargerate,
            'custom_charge_rate' => $custom_charge_rate

        );
        if ($instructions_file != '') {
            $data['instructions_file'] = $instructions_file;
        }

        $data['hours'] = round(abs($data['job_end'] - $data['job_start']) / 3600, 2);

        if ($guardId == 0 || $guardId == '') {
            $data['job_status'] = 'pending';
        }
        $new_record = job_new_roster::where('event_id', $rosterId)->first();
        $new_guard = $new_record->guard_id;

        // if ($current_guard != $new_guard || $rosterdata->job_start != $data['job_start'] || $rosterdata->job_end != $data['job_end']) {
        //     $data['publish_status'] = 0;
        // }
        if ($rosterdata->signin_status == 1 || $rosterdata->job_status == 'completed') {
            $data['job_status'] = $rosterdata->job_status;
            $data['publish_status'] = $rosterdata->publish_status;
        } elseif ($notify == 'true') {
            $data['record_update'] = 1;
            // $data['job_status'] = $rosterdata->job_status;
            // $data['job_status'] = 'pending';
            if ($publish_status == 1) {
            $data['publish_status'] = 1;
                
            }else{
            $data['publish_status'] = 0;
        }
        }
        elseif ($notify == 'false') {
            // $data['record_update'] = 1;
            // $data['job_status'] = $rosterdata->job_status;
            // $data['job_status'] = 'pending';
            $data['publish_status'] = $rosterdata->publish_status;
        }
        if (isset($data['publish_status']) && $data['publish_status'] == 1) {
            $data['record_update'] = 0;
        }
        if ($unpublish_shift == 1) {
            $data['publish_status'] = 1;
        }
        $action = 'shift_change';
        $this->administrator->log_user_activity($action, $new_record);
        // $new_guard=$new_record->guard_id;

        if ($current_guard != $new_guard || $rosterdata->job_start != $data['job_start'] || $rosterdata->job_end != $data['job_end']) {
            // $data['publish_status'] = 0;


            //    $guard_added=DB::table('guards')->where('id',$new_guard)->select('id','name', 'email')->first();
            //    $guard_removed=DB::table('guards')->where('id',$current_guard)->select('id','name', 'email')->first();


            //    $message='<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
            //    <br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
            //        <tbody><tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="'.config('custom.logo').'" rel="noopener" target="_blank"><img src="'.config('custom.logo').'" style="height: 45px" alt="logo"></a></td></tr><tr>
            //        <td align="left" valign="center">
            //            <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px"><!--begin:Email content--><div style="padding-bottom: 30px; font-size: 17px;"><strong>Guard Rostered</strong></div>';
            //   $message.='<div style="padding-bottom: 30px">You are rostered on a new Shift. </div>
            //   <div style="padding-bottom: 40px; text-align:center;"></div>';

            //   $message2='<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
            //   <br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
            //       <tbody><tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="'.config('custom.logo').'" rel="noopener" target="_blank"><img src="'.config('custom.logo').'" style="height: 45px" alt="logo"></a></td></tr><tr>
            //       <td align="left" valign="center">
            //           <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px"><!--begin:Email content--><div style="padding-bottom: 30px; font-size: 17px;"><strong>Guard Removed</strong></div>';
            //  $message2.='<div style="padding-bottom: 30px">You have been removed from a Shift. </div>
            //  <div style="padding-bottom: 40px; text-align:center;"></div>';

            //   $notification_data['added'] = 'Roster Added';
            //   $notification_data['removed'] = 'Roster Remove';
            // if ($new_guard > 0 && !empty($guard_added)) {
            //   $this->sendGuardMail($guard_added,  $notification_data['added']  ,$message);
            //   }
            //   if ($current_guard > 0 && !empty($guard_removed)) {
            //    $this->sendGuardMail($guard_removed,  $notification_data['removed']  ,$message2);   
            //   }


        }
        if ($data['payrate_id'] > 0) {
            $payrates = DB::table('payrates')->where('id', $data['payrate_id'])->where('archive', 0)->first();
            $data['payrate_applied'] = json_encode($payrates);
        }
        job_new_roster::where('event_id', $rosterId)->update($data);
        $roster_id = $rosterdata->roster_id;

        $this->guard_model->logPayChargeRate($roster_id);
        DB::table('roster_complete_activity')->insert([
            'roster_id' => $roster_id,
            'activity' => 'Shift edited',
            'type' => 'shift_edit',
            'record_id' => $roster_id,
            'activity_time' => time(),
            'activity_by' => session('userId')
        ]);
        $tasks = json_decode($tasks, true);
        if (is_array($tasks) && !empty($tasks)) {
            foreach ($tasks as $t) {

                if (isset($t['task_id']) && $t['task_id'] != '') {
                    DB::table('job_roster_tasks')->where('id', $t['task_id'])->update(
                        array(
                            'roster_id' => $roster_id,
                            'guard_id' => $guardId,
                            'task_name' => $t['task_description'],
                            'task_time' => $t['task_start_time'],
                            'status' => 'pending'
                        )
                    );
                } else {
                    DB::table('job_roster_tasks')->insert(
                        array(
                            'roster_id' => $roster_id,
                            'guard_id' => $guardId,
                            'task_name' => $t['task_description'],
                            'task_time' => $t['task_start_time'],
                            'status' => 'pending'
                        )
                    );
                    if ($unpublish_shift == 0 && $guard_id > 0) {
                        $guard_data = DB::table('guards')->where('id', $guard_id)->first();
                        $notification_data['guards'][0] = array(
                            'guard_id' => $guard_data->id,
                            'notification_token' => $guard_data->notification_token
                        );
                        $notification_data['title'] = 'New task added';
                        $notification_data['message'] = 'New Task - New task is added in your task';
                        $notification_data['page'] = 'homepage';
                        $res = $this->guard_model->send_push_notification($notification_data);
                    }
                }
            }
        }
        $this->updateHoursDistribution($temp_start, $temp_end, $rosterdata->site_id, $rosterdata->roster_id);
        return true;
    }

    public function addEvent($eventId, $start, $end, $guardId = null, $jobId, $tempDate, $temp_start, $temp_end, $post_status = 0, $tasks = null, $payable = 'yes', $chargeable = 'yes', $custom_rates = 'no', $payrate_id = 0, $chargerate_id = 0, $publish_status = 0, $training = 0, $continuation = 0, $travel_time = 0, $paid_by = '', $public_holiday = 0, $travel_time_payable = 'yes', $travel_time_chargeable = 'yes', $covid_marshal = 0, $moke_guard = '', $travel_time_amount = 0, $overtime = 0, $overtime_value = 1, $travel_time_amount_chargeable = 0, $unpublish_shift = 0, $instructions_file = '', $break_enabled = 0, $break_deduction_time = 0, $operators_notes = '', $own_payrate = '', $custom_payrate = '', $ph_duration = 0, $manual_custom_payrate = 0, $manual_custom_payrates = '', $pw_order = '', $custom_chargerate = 0, $custom_charge_rate = '')
    {

        if (!$eventId) {
            $last_row = job_new_roster::select('event_id')->orderBy('event_id', 'desc')->first();
            $event_id = 0;
            if (empty($last_row)) {
                $eventId = 1;
            } else {
                $eventId = $last_row->event_id + 1;
            }
            // $publish_status = 0;
        }

        $data = array(

            'event_id' => $eventId,

            'guard_id' => $guardId,

            'site_id' => $jobId,

            'start' => $start,

            'end' => $end,

            "temp_date" => $tempDate,

            "temp_start" => $temp_start,

            "temp_end" => $temp_end,

            'publish_status' => $guardId == 0 ? 0 : $publish_status,

            'add_status' => 1,

            'post_status' => $post_status,

            'tasks' => $tasks,

            'job_start' => strtotime($temp_start),

            'job_end' => strtotime($temp_end),

            'payable' => $payable,

            'chargeable' => $chargeable,

            'last_send_welfare_call' => '',
            'custom_rates' => $custom_rates,
            'payrate_id' => $payrate_id,
            'chargerate_id' => $chargerate_id,
            'training' => $training,
            'continuation' => $continuation,
            'travel_time' => $travel_time,
            'paid_by' => $paid_by,
            'public_holiday' => $public_holiday,
            'travel_time_payable' => $travel_time_payable,
            'travel_time_chargeable' => $travel_time_chargeable,
            'covid_marshal' => $covid_marshal,
            'moke_guard' => $moke_guard,
            'overtime' => $overtime,
            'travel_time_amount' => $travel_time_amount,
            'overtime_value' => $overtime_value,
            'travel_time_amount_chargeable' => $travel_time_amount_chargeable,
            'unpublish_shift' => $unpublish_shift,
            'break_enabled' => $break_enabled,
            'break_deduction_time' => $break_deduction_time,
            'own_payrate' => $own_payrate,
            'custom_payrate' => $custom_payrate,
            // 'ph_duration' => $ph_duration,
            'ph_duration' => 0,
            'manual_custom_payrate' => $manual_custom_payrate,
            'manual_custom_payrates' => $manual_custom_payrates,
            'pw_order' => $pw_order,
            'custom_chargerate' => $custom_chargerate,
            'custom_charge_rate' => $custom_charge_rate
        );
        if ($operators_notes != '') {
            $data['operators_notes'] = $operators_notes;
        }
        if ($unpublish_shift == 1) {
            $data['publish_status'] = 1;
        }
        if ($instructions_file != '') {
            $data['instructions_file'] = $instructions_file;
        }

        // print_r($data);
        // exit();
        $data['hours'] = round(abs($data['job_end'] - $data['job_start']) / 3600, 2);

        $roster_id = job_new_roster::insertGetId($data);
        $this->guard_model->logPayChargeRate($roster_id);
        $new_record_add = DB::table('job_new_roster')->where('roster_id', $roster_id)->get();
        $rosterdata = DB::table('job_new_roster')->where('roster_id', $roster_id)->first();
        $site = DB::table('jobs')->where('id', $jobId)->first();
        $action = 'shift_add';
        $this->administrator->log_user_activity($action, $new_record_add);


        if ($unpublish_shift == 0 && $publish_status == 1 && $guardId > 0) {
            $guard_data = DB::table('guards')->join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')->where('job_new_roster.roster_id', $roster_id)->select('guards.*')->first();
            if (!empty($guard_data)) {
                $notification_data['guards'][0] = array(
                    'guard_id' => $guard_data->id,
                    'notification_token' => $guard_data->notification_token
                );
                $notification_data['title'] = 'New Shift';
                $notification_data['message'] = 'You are rostered on a new Shift.';
                $notification_data['page'] = 'homepage';
                $res = $this->guard_model->send_push_notification($notification_data);
            }
        }
        $tasks = json_decode($tasks, true);
        if ($guardId == null) {
            $guardId = 0;
        } else {
            $config_job_roster = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id', config('custom.domain_id'))->where('type', 'job_roster_navigation_bar')->first();
            $config = json_decode($config_job_roster->records_business_navbar);

            if ($unpublish_shift == 0 && isset($config->email) && $config->email == 1 && $publish_status == 1) {
                //add roster
                $guard_added = DB::table('guards')->where('id', $guardId)->select('id', 'name', 'email')->first();

                $message = '<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
                <br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
                <tbody><tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="' . config('custom.logo') . '" rel="noopener" target="_blank"><img src="https://vcpgsystem.com.au/asset_uploads/vcpg.png" style="height: 45px" alt="logo"></a></td></tr><tr>
                <td align="left" valign="center">
                <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px"><!--begin:Email content--><div style="padding-bottom: 30px; font-size: 17px;"><strong>Roster Added </strong></div>';
                $message .= '<div style="padding-bottom: 30px">You are rostered on a new Shift. </div>
                <div style="padding-bottom: 40px; text-align:center;">';

                $message .= '<br><b>Shift Details: </b>';
                $message .= '<table style="width:100%;margin-top: 6px;" border="1px"><tr style="background-color:#ececed"><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Day & Date</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Start & Finish Time</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Site</th></tr>';
                $message .= '<tr><td style="text-align:center; border:1px solid #eeeeee;">' . date('D', strtotime($data['temp_start']))  . ' ' . date('d-m-Y', strtotime($data['temp_start'])) . '</td><td style="text-align:center; border:1px solid #eeeeee;">' . date('H:i', strtotime($data['temp_start'])) . ' to ' . date('H:i', strtotime($data['temp_end'])) . '<td style="text-align:center;border:1px solid #eeeeee;">' . $site->site_name . ' (' . $site->site_description . ')</td></tr>';
                $message .= '</table></div>';

                $notification_data['title'] = 'Roster Added';
                $this->sendGuardMail($guard_added,  $notification_data['title'], $message);
            }
        }
        if (is_array($tasks) && !empty($tasks)) {
            foreach ($tasks as $t) {
                if (isset($t['task_id']) && $t['task_id'] != '') {
                    DB::table('job_roster_tasks')->where('id', $t['task_id'])->update(
                        array(
                            'roster_id' => $roster_id,
                            'guard_id' => $guardId,
                            'task_name' => $t['task_description'],
                            'task_time' => $t['task_start_time'],
                            'status' => 'pending'
                        )
                    );
                } else {
                    DB::table('job_roster_tasks')->insert(
                        array(
                            'roster_id' => $roster_id,
                            'guard_id' => $guardId,
                            'task_name' => $t['task_description'],
                            'task_time' => $t['task_start_time'],
                            'status' => 'pending'
                        )
                    );
                }
            }
        }

        if ($roster_id != '') {
            DB::table('roster_complete_activity')->insert([
                'roster_id' => $roster_id,
                'activity' => 'Shift created',
                'type' => 'shift_create',
                'record_id' => $roster_id,
                'activity_time' => time(),
                'activity_by' => session('userId')
            ]);
            $this->updateHoursDistribution($temp_start, $temp_end, $rosterdata->site_id, $rosterdata->roster_id);
            return true;
        } else {

            return false;
        }
    }
    public function checkUpdateHoursDistribution()
    {
        return $this->updateHoursDistribution('2022-03-14 14:30', '2022-03-14 22:30', 1, 359);
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
            return $end - $shift_start;
        } 
        else {
            return 0;
        }
    }

    function convert_into_fraction($time)
    {
        return date('H', $time) + (date('i', $time) / 60);
    }
    private function updateHoursDistribution($start, $end, $siteID, $rosterID)
    {
        $day_start = Carbon::parse($start)->format('l');
        $day_end = Carbon::parse($end)->format('l');

        $start = strtotime($start);
        $end = strtotime($end);

        $diff = $end - $start;
        $hours = round($diff / (60 * 60), 2);
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

        $total_ph_hours = 0;
        $ph_start = 0;
        $ph_end = 0;

        // publid holiday calculation start here
        $start_in_public_holiday = false;
        $end_in_public_holiday = false;
        $site_state = DB::table('jobs')->where('id', $siteID)->select('state')->first();
        $states_array = array(
            'Victoria' => 'vic',
            'NSW' => 'nsw',
            'New South Wales' => 'nsw',
            'Queensland' => 'qld',
            'Tasmania' => 'tas',
            'Western Australia' => 'wa',
            'South Australia' => 'sa',
            'ACT' => 'act'
        );
        $state = $states_array[$site_state->state];
        $public_holiday_start = DB::table('public_holidays')->where('date', date('Ymd', $start))->where('state', $state)->first();
        $public_holiday_end = DB::table('public_holidays')->where('date', date('Ymd', $end))->where('state', $state)->first();
        if (!empty($public_holiday_start)) {
            $start_in_public_holiday = true;
        }
        if (!empty($public_holiday_end)) {
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
        } elseif ($start_in_public_holiday && !$end_in_public_holiday) {
            $ph_end = strtotime(date('m/d/Y 23:59:59', $start));
            $diff = $ph_end - $start;
            $total_ph_hours = round($diff / (60 * 60), 2);
            $ph_start = $this->convert_into_fraction($start);
            $ph_end = $this->convert_into_fraction($ph_end);
            $start = strtotime($public_holiday_start->date) + (60 * 60 * 24);
            $day_start = Carbon::parse(date('m/d/Y', $end))->format('l');
            $hours = $hours - $total_ph_hours;
            $shift_start = 0;
            // echo 'Start in PH - ';
        } elseif (!$start_in_public_holiday && $end_in_public_holiday) {
            $ph_start = strtotime(date('m/d/Y 00:00:00', strtotime($public_holiday_end->date)));
            $diff = $end - $ph_start;
            $total_ph_hours = round($diff / (60 * 60), 2);
            $shift_end = 0;
            $end = $ph_start;
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
        } elseif ($day_start == 'Saturday' && $day_end != 'Saturday') {
            $sat_end = strtotime(date('m/d/Y 23:59:59', $start));
            $diff = $sat_end - $start;
            $total_saturday_hours = round($diff / (60 * 60), 2);
            $saturday_start = $shift_start;
            $saturday_end = $this->convert_into_fraction($sat_end);

            $shift_end = 0;
            $hours = $hours - $total_saturday_hours;
        } elseif ($day_start != 'Saturday' && $day_end == 'Saturday') {
            $sat_start = strtotime(date('m/d/Y 00:00:00', $end));
            $diff = $end - $sat_start;
            $total_saturday_hours = round($diff / (60 * 60), 2);
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
        } elseif ($day_start == 'Sunday' && $day_end != 'Sunday') {
            $sun_end = strtotime(date('m/d/Y 23:59:59', $start));
            $diff = $sun_end - $start;
            $total_sunday_hours = round($diff / (60 * 60), 2);
            $sunday_start = $shift_start;
            $sunday_end = $this->convert_into_fraction($sun_end);

            $shift_end = 0;
            $hours = $hours - $total_sunday_hours;
        } elseif ($day_start != 'Sunday' && $day_end == 'Sunday') {
            $sun_start = strtotime(date('m/d/Y 00:00:00', $end));
            $diff = $end - $sun_start;
            $total_sunday_hours = round($diff / (60 * 60), 2);
            $sunday_start = $this->convert_into_fraction($sun_start);
            $sunday_end = $this->convert_into_fraction($end);
            $shift_end = 24;
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

        $ph_morning = round($this->calculateHoursMorning($ph_start, $ph_end, $morning_start, $morning_end), 2);

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
            'ph_morning' => $ph_morning,
            'ph_night' => round(((($total_ph_hours - $ph_morning) < 0) ? 0 : ($total_ph_hours - $ph_morning)), 2),

            // 'night' => $this->calculateHoursNight($shift_start, $shift_end, $night_start, $night_end ),
        ];
    }

    function coordinates_to_address($coordinates)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $coordinates . '&key=AIzaSyCS-DB39Kk-Z25C5GWymVGshXIALbjXPGY');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $result = curl_exec($ch);
        curl_close($ch);

        $address = json_decode($result, 1);
        return isset($address['results'][0]['formatted_address']) ? $address['results'][0]['formatted_address'] : $coordinates;
    }

    public function eventStatus(Request $request)
    {
        $eventId = $request->eventId;
        $data_merge = array();
        $guard_data = array();
        $incident_report = array();
        $guard_location_at_job = array();
        $guard_details = array();
        $job_details = array();
        $break_details = array();

        $data = job_new_roster::where('event_id', $eventId)->first();

        if (!empty($data)) {
            $task = DB::table('job_roster_tasks')->where('roster_id', $data->roster_id)->select('id', 'task_name as task_description', 'task_time as task_start_time')->get();

            $data->tasks = $task;
            // return $data;
            // exit();
            $guard_id = $data->guard_id;
            $roster_id = $data->roster_id;
            $site_id = $data->site_id;
            $guard_details = guard::where('id', $guard_id)->select('name')->get();
            $job_details = job::where('id', $site_id)->select('address', 'site_name', 'site_description')->get();


            $guard_data = DB::table('job_roster_activities')->where('guard_id', $guard_id)->where('job_roster_id', $roster_id)->first();
            if (!empty($guard_data)) {
                $job_incident_report_id = $guard_data->job_incident_report_id;
                $guard_data->address = $this->coordinates_to_address($guard_data->location);

                $incident_report = DB::table('job_incident_reports')->where('guard_id', $guard_id)->where('id', $job_incident_report_id)->get();

                $guard_location_at_job = DB::table('guard_location_at_job')->where('guard_id', $guard_id)->where('roster_id', $roster_id)->get();




                //BY HHH

                $break_details = DB::table('job_breaks')->where('guard_id', $guard_id)->where('roster_id', $roster_id)->select('id', 'start_time', 'end_time', 'notes', 'inform_to')->get();

                foreach ($break_details as $key => $value) {
                    $break_details[$key]->start_time = date('d/m/Y H:i:s', $value->start_time);
                    $break_details[$key]->end_time = date('d/m/Y H:i:s', $value->end_time);
                }
            }

            $data_merge[0] = $data;
            $data_merge[1] = $guard_data;
            $data_merge[2] = $incident_report;

            $green_call[0] = DB::table('green_call')->where('before_time', '120')->where('job_id', $roster_id)->where('guard_id', $guard_id)->first();
            if (!empty($green_call[0])) {
                $green_call[0]->address = $this->coordinates_to_address($green_call[0]->coordinates);
            }

            $green_call[1] = DB::table('green_call')->where('before_time', '30')->where('job_id', $roster_id)->where('guard_id', $guard_id)->first();
            if (!empty($green_call[1])) {
                $green_call[1]->address = $this->coordinates_to_address($green_call[1]->coordinates);
            }

            $i = 0;
            foreach ($guard_location_at_job as $gl) {
                $guard_location_at_job[$i]->address = $this->coordinates_to_address($gl->coordinates);
                $i++;
            }

            $data_merge[3] = $guard_location_at_job;
            $data_merge[4] = $green_call;

            $welfare_call_data = DB::table('welfare_call_data')->where('guard_id', $guard_id)->where('job_roster_id', $roster_id)->get();

            $data_merge[5] = $welfare_call_data;
            $data_merge[6] = $guard_details;
            $data_merge[7] = $job_details;
            $data_merge[8] = $break_details;


            return response()->json($data_merge);
        }
    }


    public function guard_profile($id)
    {

        $site_blocked = [];
        $site_trained = [];
        $total_hours = 0;
        $guard_id = $id;
        $guards = DB::table('guards')->where('id', $guard_id)->get();
        foreach ($guards as $guard) {
            $guard->dob = date('d-m-Y', strtotime($guard->dob));
            $guard->customer_docs = json_decode($guard->customer_docs, true);
            $guard->medicare_expiration = date('d-m-Y', strtotime($guard->medicare_expiration));
            $guard->passport_expiration = date('d-m-Y', strtotime($guard->passport_expiration));
            $guard->visa_expiration = date('d-m-Y', strtotime($guard->visa_expiration));
            $guard->security_license_expiration = date('d-m-Y', strtotime($this->date_convert($guard->security_license_expiration)));
            $guard->driver_license_expiration = date('d-m-Y', strtotime($guard->driver_license_expiration));
            $guard->firstaid_license_expiration = date('d-m-Y', strtotime($guard->firstaid_license_expiration));
            $guard->firearm_license_expiration = date('d-m-Y', strtotime($guard->firearm_license_expiration));
            $guard->birthcertificate_expiration = date('d-m-Y', strtotime($guard->birthcertificate_expiration));
            $guard->citizenship_expiration = date('d-m-Y', strtotime($guard->citizenship_expiration));
        }
        $roster = DB::table('job_new_roster')->where('guard_id', $guard_id)->select('roster_id', 'temp_start', 'temp_end')->get();
        $shifts = $roster->count();
        foreach ($roster as $r) {
            $time = $this->getTimeDiff($r->temp_start, $r->temp_end);
            $hours = $time['hours'];
            $total_hours = $total_hours +  $hours;
        }
        if (session()->get('userType') == 'customer'){
            $internal_ids = DB::table('guard_ids')->where('guard_id', $guard_id)->where('customer_id', session()->get('userId'))->get();
            $ids = DB::table('guard_ids')->where('guard_id', $guard_id)->where('customer_id', session()->get('userId'))->first();

        }else{
            $internal_ids = DB::table('guard_ids')->where('guard_id', $guard_id)->get();
            $ids = DB::table('guard_ids')->where('guard_id', $guard_id)->first();

        }

        $customers = '';
        if (!empty($ids)) {
            $cid = $ids->customer_id;
            $customers = DB::table('customers')->where('id', $cid)->get();
        }

        // $site_blocked=DB::table('guard_sites_blocked')->where('id', $guard_id)->get();
        $block_id = DB::table('guard_sites_blocked')->where('guard_id', $guard_id)->get();

        // $site_trained=DB::table('guard_sites_trained')->where('id', $guard_id)->get();
        $trained_id = DB::table('guard_sites_trained')->where('guard_id', $guard_id)->get();
        $payrates_id = DB::table('guards')->select('payrates_id')->where('id', $guard_id)->first();
        // print_r();
        // exit();
        if ($payrates_id != '') {
            $pid = $payrates_id->payrates_id;
            if($pid){
                $payrates = DB::table('payrates')->where('id', $pid)->where('archive', 0)->get();
            }
        } else {
            $payrates = [];
        }

        $site_blocked = array();
        if (!empty($block_id)) {
            foreach ($block_id as $key => $value) {
                $job_block_id = $value->site_id;
                $site_blocked[] = DB::table('jobs')->where('id', $job_block_id)->first();
            }
        }
        $site_trained = array();
        if (!empty($trained_id)) {
            foreach ($trained_id as $key => $value) {
                $job_trained_id = $value->site_id;

                $site_trained[] = DB::table('jobs')->where('id', $job_trained_id)->first();
            }
        }

        // print_r('<pre>');
        // print_r($guards[0]->customer_docs);




        // exit();
        return view('admin/guard/guard_profile', ['guards' => $guards, 'guard_id' => $guard_id, 'internal_ids' => $internal_ids, 'customers' => $customers, 'site_blocked' => $site_blocked, 'site_trained' => $site_trained, 'payrates' => isset($payrates) ? $payrates : [] , 'shifts' => $shifts, 'total_hours' => $total_hours]);
    }


    public function change_password(Request $request)
    {

        $password = $request->password;
        $confirm = $request->confirm_password;
        if ($password == $confirm) {
            $password = Hash::make($request->password);
            $id = $request->guard_id;
            $res = guard::where(['id' => $id])->update(['password' => $password]);
            return response()->json(array('success' => true));
        } else {
            return response()->json(array('success' => false));
        }
    }

    function sendSMS($receiver, $message)
    {
        $receiver = str_replace(' ', '', $receiver);
        $receiver = str_replace('-', '', $receiver);
        $receiver = str_replace('(', '', $receiver);
        $receiver = str_replace(')', '', $receiver);
        $phone_ = str_split($receiver);
        if (sizeof($phone_) == 9) {
            $receiver = '+61' . $receiver;
        } elseif ($phone_[0] != '+' && $phone_[0] == 0) {
            $receiver = substr($receiver, 1);
            $receiver = '+61' . $receiver;
        } elseif ($phone_[0] == 0 && $phone_[0] != '+') {
            $receiver = substr($receiver, 1);
            $receiver = '+61' . $receiver;
        }
        $receiverNumber = $receiver;
        $message = $message;

        try {

            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => $message
            ]);

            return true;
        } catch (Exception $e) {
            // dd("Error: ". $e->getMessage());
            return false;
        }
    }

    function publishRoster(Request $request)
    {

        $formData = $request;
        $publishShiftcount = 0;
        foreach ($request->customerIds as $key => $customerId) {

            $customerSites = $this->guard_model->getAllCustomersSites($customerId);
            foreach ($customerSites as $customerSite) {
                $data = $this->guard_model->getAllsiteData($customerSite->siteId, $request->start, $request->end);
                $data1 = $this->guard_model->getAllsiteUpdateData($customerSite->siteId, $request->start, $request->end);
                $data2 = $this->guard_model->getAllsiteUpdateRollOverData($customerSite->siteId, $request->start, $request->end);
                // $publishShiftcount = $publishShiftcount + count($data) + count($data1) + count($data2);
                $publishShiftcount = $publishShiftcount + count($data);
                if (!empty($data1)) {
                    $guards1 = $this->guard_model->getAllSiteUpdateGuard($customerSite->siteId);
                    foreach ($guards1 as $guard) {
                        $message = '<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
                        <br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
                        <tbody><tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="' . config('custom.logo') . '" rel="noopener" target="_blank"><img src="https://vcpgsystem.com.au/asset_uploads/vcpg.png" style="height: 45px" alt="logo"></a></td></tr><tr>
                        <td align="left" valign="center">
                        <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px"><!--begin:Email content--><div style="padding-bottom: 30px; font-size: 17px;"><strong>Shift Updated</strong></div>';
                        $message .= '<div style="padding-bottom: 30px">One of your shift has been updated. Please check your roster.</div>
                        <div style="padding-bottom: 40px; text-align:center;"></div>';
                        $notification_data['title'] = 'Shift Updated';
                        $this->sendGuardMail($guard,  $notification_data['title']  ,$message);

                        $message = 'One of your shift has been updated. Please check your roster.';
                        $notification_data['guards'][0] = array(
                            'guard_id' => $guard->guard_id,
                            'notification_token' => $guard->notification_token
                        );
                        $notification_data['message'] = $message;
                        $notification_data['title'] = 'Roster Update';
                        $notification_data['page'] = 'homepage';
                        $res = $this->guard_model->send_push_notification($notification_data);
                    }
                    foreach ($data1 as $key => $value) {
                        //send mail notification
                        $this->guard_model->updatePublishStatus($value->roster_id);
                        if ($value->guard_id != null || $value->guard_id != 0) {
                            $guard = guard::where(array('id' => $value->guard_id))->first();
                            $site = job::where(array('id' => $value->site_id))->first();
                            $tasks = DB::table('job_roster_tasks')->where('roster_id', $value->guard_id)->first();
                            if (!empty($tasks)) {
                                $task_status = "Yes";
                            } else {
                                $task_status = "No";
                            }
                            $message = '<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
                            <br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
                            <tbody><tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="' . config('custom.logo') . '" rel="noopener" target="_blank"><img src="https://vcpgsystem.com.au/asset_uploads/vcpg.png" style="height: 45px" alt="logo"></a></td></tr><tr>
                            <td align="left" valign="center">
                            <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px"><!--begin:Email content--><div style="padding-bottom: 30px; font-size: 17px;"><strong>Shift Changed</strong></div>';
                            $message .= '<div style="padding-bottom: 30px">One of your shift has been updated. Please check your roster.</div>
                            <div style="padding-bottom: 40px; text-align:center;">';
                            // $message = 'One of your shift has been update. Please check roster.';
                            $req['name'] = $guard->name;
                            $req['email'] = $guard->email;
                            $req['subject'] = 'Shift Updated';
                            $message .= '<br><b  style="padding-bottom: 30px; font-size: 17px;" >Shift Details: </b><br>';
                            $message .= '<table style="width:100%;margin-top: 6px;" border="1px"><tr style="background-color:#ececed"><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Day & Date</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Start & Finish Time</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Site</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Task</th></tr>';
                            $message .= '<tr><td style="text-align:center; border:1px solid #eeeeee;">' . date('D', strtotime($value->temp_start))  . ' ' . date('d-m-Y', strtotime($value->temp_start)) . '</td><td style="text-align:center; border:1px solid #eeeeee;">' . date('H:i', strtotime($value->temp_start)) . ' to ' . date('H:i', strtotime($value->temp_end)) . '<td style="text-align:center;border:1px solid #eeeeee;">' . $site->site_name . ' (' . $site->site_description . ')</td><td style="text-align:center;border:1px solid #eeeeee;">' . $task_status . '</td></tr>';
                            $message .= '</table></div>';
                            $req['message'] = $message;
                            // $this->CURL_model->call_api($req, 'administrator/guard/send_guard_email');
                            $this->sendGuardMail($guard, $req['subject'], $message);
                        }
                    }
                }

                if (!empty($data2)) {
                    $guards2 = array();
                    // $guards2 = $this->guard_model->getAllSiteUpdateRollOverGuard($customerSite->siteId);
                    foreach ($guards2 as $guard) {
                        $message = '<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
                        <br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
                        <tbody><tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="' . config('custom.logo') . '" rel="noopener" target="_blank"><img src="https://vcpgsystem.com.au/asset_uploads/vcpg.png" style="height: 45px" alt="logo"></a></td></tr><tr>
                        <td align="left" valign="center">
                        <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px"><!--begin:Email content--><div style="padding-bottom: 30px; font-size: 17px;"><strong>Roster Updated</strong></div>';
                        $message .= '<div style="padding-bottom: 30px">Updated roster is published. Please check roster.</div>
                        <div style="padding-bottom: 40px; text-align:center;"></div>';
                        $notification_data['title'] = 'Roster Updated';

                        // $this->sendGuardMail($guard,$notification_data['title'],$message);
                        $message = 'Updated roster is published. Please check roster.';
                        $notification_data['guards'][0] = array(
                            'guard_id' => $guard->guard_id,
                            'notification_token' => $guard->notification_token
                        );
                        $notification_data['message'] = $message;
                        $notification_data['title'] = 'Roster Update';
                        $notification_data['page'] = 'homepage';
                        $res = $this->guard_model->send_push_notification($notification_data);
                        // $req['name'] = $guard['name'];
                        // $req['email'] = $guard['email'];
                        // $req['subject'] = 'Roster Update';
                        // $req['message'] = $message;
                        // $this->CURL_model->call_api($req, 'administrator/guard/send_guard_email');


                    }
                    $admins = DB::table('portal_settings')->where('permission_name', 'admin_update_shift')->where('permission', 1)->first();
                    $admin_emails = array();
                    if (!empty($admins)) {
                        $admin_emails = explode(',', $admins->users_emails);
                    }
                    foreach ($data2 as $key => $value) {
                        //send mail notification
                        $this->guard_model->updatePublishStatus($value->roster_id);
                        if ($value->guard_id != null && $value->guard_id > 0) {
                            $guard = guard::where(array('id' => $value->guard_id))->first();
                            $message = 'Updated roster is published. Please check roster.';
                            $notification_data['guards'][0] = array(
                                'guard_id' => $guard->guard_id,
                                'notification_token' => $guard->notification_token
                            );
                            $notification_data['message'] = $message;
                            $notification_data['page'] = 'homepage';
                            $notification_data['title'] = 'Roster Published';
                            $res = $this->guard_model->send_push_notification($notification_data);
                            $site = job::where(array('id' => $value->site_id))->first();
                            $tasks = DB::table('job_roster_tasks')->where('roster_id', $value->guard_id)->first();
                            if (!empty($tasks)) {
                                $task_status = "Yes";
                            } else {
                                $task_status = "No";
                            }
                            $message = '<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
                            <br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
                            <tbody><tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="' . config('custom.logo') . '" rel="noopener" target="_blank"><img src="https://vcpgsystem.com.au/asset_uploads/vcpg.png" style="height: 45px" alt="logo"></a></td></tr><tr>
                            <td align="left" valign="center">
                            <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px"><!--begin:Email content--><div style="padding-bottom: 30px; font-size: 17px;"><strong>Shift Changed</strong></div>';
                            $message .= '<div style="padding-bottom: 30px">Updated roster is published.</div>
                            <div style="padding-bottom: 40px; text-align:center;">';
                            // $message = 'Updated roster is published. Please check roster.';
                            $req['name'] = $guard->name;
                            $req['email'] = $guard->email;
                            $req['subject'] = 'Roster Updated';
                            $message .= '<br><b>Shift Details: </b>';
                            $message .= '<table style="width:100%;margin-top: 6px;" border="1px"><tr style="background-color:#ececed"><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Day & Date</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Start & Finish Time</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Site</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Task</th></tr>';
                            $message .= '<tr><td style="text-align:center; border:1px solid #eeeeee;">' . date('D', strtotime($value->temp_start))  . ' ' . date('d-m-Y', strtotime($value->temp_start)) . '</td><td style="text-align:center; border:1px solid #eeeeee;">' . date('H:i', strtotime($value->temp_start)) . ' to ' . date('H:i', strtotime($value->temp_end)) . '<td style="text-align:center;border:1px solid #eeeeee;">' . $site->site_name . ' (' . $site->site_description . ')</td><td style="text-align:center;border:1px solid #eeeeee;">' . $task_status . '</td></tr>';
                            $message .= '</table></div>';
                            $req['message'] = $message;
                            // $this->CURL_model->call_api($req, 'administrator/guard/send_guard_email');
                            if (!empty($guard)) {
                                $this->sendGuardMail($guard, $req['subject'], $message);
                            }
                            $email_data = new guard;
                            // print_r($admin_emails);
                            foreach ($admin_emails as $key => $admin_email) {
                                if (trim($admin_email) != '') {
                                    $email_data->name = '';
                                    $email_data->email = $admin_email;
                                    $this->sendGuardMail($email_data, $req['subject'], $message);
                                }
                            }
                        }
                    }
                }

                if (!empty($data)) {
                    $guards = $this->guard_model->getAllSiteGuard($customerSite->siteId, $request->start, $request->end);
                    // $res = $this->guard_model->send_push_notification_to_guard($guards);
                    foreach ($guards as $key => $g) {
                        $message = 'Schedule for week starting ' . date('d M Y', strtotime('monday this week'));
                        $notification_data['guards'][0] = array(
                            'guard_id' => $g->guard_id,
                            'notification_token' => $g->notification_token
                        );
                        $notification_data['message'] = $message;
                        $notification_data['title'] = 'New Roster Published';
                        $notification_data['page'] = 'homepage';
                        $res = $this->guard_model->send_push_notification($notification_data);
                    }
                    foreach ($data as $key => $value) {
                        //send mail notification
                        $this->guard_model->updatePublishStatus($value->roster_id);
                        if ($value->guard_id != null || $value->guard_id != 0) {
                            $guard = guard::where('id', $value->guard_id)->first();
                            $site = job::where(array('id' => $value->site_id))->first();
                            $tasks = DB::table('job_roster_tasks')->where('roster_id', $value->guard_id)->first();
                            if (!empty($tasks)) {
                                $task_status = "Yes";
                            } else {
                                $task_status = "No";
                            }
                            // $message = 'New roster is published moments ago. Please check!';
                            $message = '<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
                            <br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
                            <tbody><tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="' . config('custom.logo') . '" rel="noopener" target="_blank"><img src="https://vcpgsystem.com.au/asset_uploads/vcpg.png" style="height: 45px" alt="logo"></a></td></tr><tr>
                            <td align="left" valign="center">
                            <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px"><!--begin:Email content--><div style="padding-bottom: 30px; font-size: 17px;"><strong>New roster published</strong></div>';
                            $message .= '<div style="padding-bottom: 30px">Your new Roster from the duration of ' . date('d-m-Y', strtotime('monday this week')) . ' to ' . date('d-m-Y', strtotime('sunday this week')) . ' is below: </div>
                            <div style="padding-bottom: 40px; text-align:center;">';
                            // $message = 'Here is your roster for this week '.date('d', strtotime('monday this week')).' '. date('M'). ' '.date('d', strtotime('sunday this week'));
                            $req['name'] = $guard->name;
                            $req['email'] = $guard->email;
                            $req['subject'] = 'New roster published';
                            $req['subject'] = 'Your Schedule for week starting ' . date('d M Y', strtotime('monday this week'));
                            $message .= '<br><b>Shift Details </b><br>';
                            $message .= '<table style="width:100%;margin-top: 6px;" border="1px"><tr style="background-color:#ececed"><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Day & Date</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Start & Finish Time</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Site</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Task</th></tr>';
                            $message .= '<tr><td style="text-align:center; border:1px solid #eeeeee;">' . date('D', strtotime($value->temp_start))  . ' ' . date('d-m-Y', strtotime($value->temp_start)) . '</td><td style="text-align:center; border:1px solid #eeeeee;">' . date('H:i', strtotime($value->temp_start)) . ' to ' . date('H:i', strtotime($value->temp_end)) . '<td style="text-align:center;border:1px solid #eeeeee;">' . $site->site_name . ' (' . $site->site_description . ')</td><td style="text-align:center;border:1px solid #eeeeee;">' . $task_status . '</td></tr>';
                            $message .= '</table></div>';
                            // $message .= '<br><b>Start Date & Time: </b>'.$value->temp_start;
                            // $message .= '<br><b>End Date & Time: </b>'.$value->temp_end;
                            // $message .= '<br><b>Site: </b>'.$site['site_name']. '('.$site['site_description'].')';
                            $req['message'] = $message;
                            // $this->CURL_model->call_api($req, 'administrator/guard/send_guard_email');
                            // echo $message;
                            // exit();
                            $this->sendGuardMail($guard, $req['subject'], $message);
                        }
                    }


                    $result["message"] = "success";
                    $result["success"] = true;
                    $result['count'] =  $publishShiftcount;

                    // $result['res'] = $res;

                } else {
                    $result["success"] = false;
                    $result["message"] = "not_new";
                }
            }
        }

        return response()->json($result);
    }

    public function saveRoster(Request $request)
    {

        $formData = $request;

        $this->guard_model->saveRoster($formData->siteId);

        $result["message"] = "success";

        return response()->json($result);
    }
    function getAllGuards(Request $request)
    {
        $jobId = $request->siteId;
        // $multiple_states = $this->session->userdata('multiple_states');
        // $state = $this->session->userdata('state');
        $multiple_states = array();
        $state = '';

        $jobData = $this->getJobData($jobId);
        if (!empty($jobData->trained) || $jobData->trained != '') {

            if ($jobData->trained == "yes") {

                if (!empty($jobData->contractor_id)) {

                    $data = $this->guard_model->getContractorsGuards($jobData->contractor_id, $jobId);
                    // echo $this->db->last_query();
                    // exit();

                    return response()->json($data);

                    exit;
                } else {

                    $data = $this->getTrainedGuardsList($jobId);

                    // $data = $this->guard_model->getAllSiteGuards($jobId, $multiple_states, $state, $jobData->site_employer);
                    // echo $this->db->last_query();
                    // exit();
                    return response()->json($data);

                    exit;
                }
            } else {

                if (!empty($jobData->contractor_id)) {

                    $data = $this->guard_model->contractorsGuards($jobData->contractor_id);

                    return response()->json($data);

                    exit;
                } else {

                    $data = $this->guard_model->getAllSiteGuards($jobId, $multiple_states, $state, $jobData->site_employer);

                    return response()->json($data);

                    exit;
                }
            }
        } else {
         $data = $this->guard_model->getAllSiteGuards($jobId, $multiple_states, $state, $jobData->site_employer);
                    // echo $this->db->last_query();
                    // exit();
         return response()->json($data);
            // return response()->json("");
     }
 }
 public function saveJobGuard(Request $request)
 {

    $formData = $request;

    $data = $this->guard_model->jobGuards($formData->guardId, $formData->siteId);

    if (!empty($data)) {

        $result["message"] = "already";
    } else {

        $this->guard_model->saveJobGuards($formData->guardId, $formData->siteId);

        $result["message"] = "added";
    }

    return response()->json($result);
}
function getAllnotCustomersGuards(Request $request)
{
    $jobId = $request->siteId;
        // $multiple_states = $this->session->userdata('multiple_states');
        // $state = $this->session->userdata('state');
    $multiple_states = array();
    $state = '';

    $jobData = $this->getJobData($jobId);
    if (!empty($jobData->trained)) {

        if ($jobData->trained == "yes") {

            if (!empty($jobData->contractor_id)) {

                $data = $this->guard_model->getContractorsGuards($jobData->contractor_id, $jobId);
                    // echo $this->db->last_query();
                    // exit();

                return response()->json($data);

                exit;
            } else {

                    //$data = $this->guard_model->getTrainedGuards($jobId);

                $data = $this->guard_model->getAllNotSiteGuards($jobId, $multiple_states, $state);
                    // echo $this->db->last_query();
                    // exit();
                return response()->json($data);

                exit;
            }
        } else {

            if (!empty($jobData->contractor_id)) {

                $data = $this->guard_model->contractorsGuards($jobData->contractor_id);

                return response()->json($data);

                exit;
            } else {

                $data = $this->guard_model->getAllNotSiteGuards($jobId, $multiple_states, $state);

                return response()->json($data);

                exit;
            }
        }
    } else {

        return response()->json("");
    }
}
public function add_site_guard(Request $request)
{
    $already_check = DB::table('jobs_guards')->where(['guard_id' => $request->guard_id, 'job_id' => $request->site_id])->first();
    if (empty($already_check)) {
        DB::table('jobs_guards')->insert([
            'guard_id' => $request->guard_id,
            'job_id' => $request->site_id,
            'date_added' => time(),
            'start_time' => 0,
            'complete_time' => 0
        ]);
    } else {
        if (!$request->has('add')) {
            DB::table('jobs_guards')->where(['guard_id' => $request->guard_id, 'job_id' => $request->site_id])->delete();
        }
    }
    return response()->json(['success' => true, 'message' => 'Status changed.']);
}

public function calendarResouces(Request $request)
{
    if (session()->has('config_arr_job_roster')  && session()->get('config_arr_job_roster') != '' && isset(session()->get('config_arr_job_roster')[0]->add_guards)) {
        $allguard = (session()->get('config_arr_job_roster')[0]->add_guards);
    }
    $resources = array();
    if (session()->get('userType') != 'guard') {
        if (!is_array($request->search_value)) {
            if ($request->resource_by == 'guard') {
                $resources[] = array('id' => 'a-0', 'r_id' => 0, 'title' => '<b>Shifts without '. config('custom.guard') .'</b>');
            }
        }
    }
    if (!is_array($request->customerIds)) {
        $request->customerIds = json_decode($request->customerIds, true);
    }
    if (!is_array($request->search_value)) {
        $request->search_value = json_decode($request->search_value, true);
    }
    $start = explode('T', $request->start);
    $request->start = $start[0];
    $end = explode('T', $request->end);
    $request->end = $end[0];
    $customerIds = $request->customerIds;
    if (!is_array($customerIds)) {
        $customerIds = json_decode($customerIds, true);
    }

        // print_r($customerIds);
        // exit();
        // foreach ($request->customerIds as $index => $customerId) {

    if (session()->get('userType') == 'guard') {
        $request->resource_by = 'guard';
        $data = DB::table('guards')
        ->where('guards.id', session()->get('userId'))
        ->where('guards.state', $request->state)
        ->select('guards.id', 'guards.name', 'guards.phone')
        ->get();
    } else {

        if ($request->resource_by == 'guard') {
            if (isset($allguard) && $allguard == 0) {
                $que = DB::table('guards')
                ->where(['status' => 'active']);
                if ($request->has('search_value') && $request->search_value != 'undefined' && !empty($request->search_value)) {
                    $search_value = $request->search_value;
                    $que->where(function ($query1) use ($search_value) {
                        $i = 0;
                        foreach ($search_value as $key => $index) {
                            if ($i == 0) {
                                $query1->where('id', $index);
                            } else {
                                $query1->orWhere('id', $index);
                            }
                            $i++;
                        }
                    });
                }
                $data = $que->select('guards.id', 'guards.name', 'guards.phone', 'guards.fortnightly_working_hours')->orderBy('guards.name', 'ASC')->get();
            } else {
                $query = DB::table('job_new_roster')
                ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
                ->join('guards', 'guards.id', '=', 'job_new_roster.guard_id')
                ->where('job_new_roster.temp_start', '>=', $request->start)
                ->where('job_new_roster.temp_start', '<', $request->end);

                    // all query commented by mohsin
                    // $query = DB::table('guards')
                    //     ->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')
                    //     ->join('jobs', 'jobs.id', '=', 'jobs_guards.job_id');

                        // ->join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id');
                    // commnetd by mohsin 
                    // $query->where('jobs.customer_id', $customerId);

                $query->where(function ($query) use ($customerIds) {
                    $i = 0;
                    foreach ($customerIds as $key => $customerId) {
                        if ($i == 0) {
                            $query->where('jobs.customer_id', '=', $customerId);
                        } else {
                            $query->orWhere('jobs.customer_id', '=', $customerId);
                        }
                        $i++;
                    }
                });
                    // ->where('job_new_roster.temp_start', '>=', $request->start)
                    // ->where('job_new_roster.temp_start', '<=', $request->end);
                $query->where('jobs.status', 'active')->where('jobs.state', $request->state);
                    //    ->where('jobs.state', $request->state);
                if ($request->has('search_value') && $request->search_value != 'undefined' && !empty($request->search_value)) {
                    $search_value = $request->search_value;


                    $query->where(function ($query1) use ($search_value) {
                        $i = 0;
                        foreach ($search_value as $key => $index) {
                            if ($i == 0) {
                                    // $query1->where('jobs_guards.guard_id', $index);
                                $query1->where('guards.id', $index);
                            } else {
                                $query1->orWhere('guards.id', $index);
                            }
                            $i++;
                        }
                    });
                }
                    // if ($request->filter == 'active') {
                    //     $query->join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')
                    //         ->join('jobs as j', 'j.id', '=', 'job_new_roster.site_id')
                    //         ->where('job_new_roster.temp_start', '>=', $request->start)
                    //         ->where('job_new_roster.temp_start', '<', $request->end);
                    // }
                    // ->where('jobs.state', $request->state);
                    //    if ($request->has('search_value') && $request->search_value != 'undefined' && !empty($request->search_value)) {
                    //     $search_value = (object)$request->search_value;
                    // foreach($search_value as $search_val){
                    //          $query->where(function ($query1) use($search_val){
                    //         $query1->orwhere('jobs.id',$search_val);
                    //  });
                    // // $query1->orwhere('jobs.id',$search_val);
                    // }
                    //    }
                $data = $query->select('guards.id', 'guards.name', 'guards.phone', 'guards.fortnightly_working_hours', 'job_new_roster.temp_start', 'job_new_roster.roster_id', 'job_new_roster.site_id')
                ->orderBy('guards.name', 'ASC')
                ->groupBy('guards.id')
                ->get();
                        // dd($data);
            }
        } else {
            $query =  DB::table('jobs')
                    // commented by mohsin
                    // ->where('customer_id', $customerId)
            ->where(function ($query) use ($customerIds) {
                $i = 0;
                foreach ($customerIds as $key => $customerId) {
                    if ($i = 0) {
                        $query->where('customer_id', $customerId);
                    } else {
                        $query->orWhere('customer_id', $customerId);
                    }
                    $i++;
                }
            })
            ->select('id', 'site_name', 'site_description')
            ->where('status', 'active')
            ->where('jobs.state', $request->state);

            if ($request->has('search_value') && $request->search_value != 'undefined' && !empty($request->search_value)) {
                $search_value = $request->search_value;


                $query->where(function ($query1) use ($search_value) {
                    $i = 0;
                    foreach ($search_value as $key => $index) {
                        if ($i == 0) {
                            $query1->where('jobs.id', $index);
                        } else {
                            $query1->orWhere('jobs.id', $index);
                        }
                        $i++;
                    }
                });
                    // $search_value =(object)$request->search_value;
                    // return $search_value;
                    // exit();
                    //   foreach($search_value as $search_val){
                    // // $query->where('name','LIKE','%'.$search_val.'%');
                    //     $query->where('id',$search_val);
                    // }
                    // foreach($search_value as $search_val){
                    // $query->where(function ($query1) use($search_val){
                    // $query1->orwhere('id',$search_val);
                    // });
                    // }
                    // $query->where(function ($query1) use($search_value){
                    // $query1->where('site_name','LIKE','%'.$search_value.'%');
                    // $query1->orWhere('site_description','LIKE','%'.$search_value.'%');
                    //  });
            }elseif (session()->has('specific_sites') && session()->get('specific_sites') != '') {
                $specific_sites = json_decode(session()->get('specific_sites'));
                $query->where(function ($query1)  use ($specific_sites) {
                    foreach ($specific_sites as $key => $id) {
                        if ($key == 0) {
                            $query1->where('jobs.id', $id);
                        } else {
                            $query1->orWhere('jobs.id', $id);
                        }
                    }
                });
            }
            if ($request->filter == 'active') {

                $query->join('job_new_roster', 'job_new_roster.site_id', '=', 'jobs.id')
                ->where('job_new_roster.temp_start', '>=', $request->start)
                ->where('job_new_roster.temp_start', '<=', $request->end)
                ->groupBy('job_new_roster.site_id');
                    // ->where('job_new_roster.site_id', $value->id)
                    // ->orderBy('job_new_roster.roster_id', 'desc')
                    // ->first();
            }
            $data = $query->orderBy('site_name', 'ASC')->get();
        }
    }
    $permissions = array();
    $is_super_admin = 0;
    if (session()->has('permissions')) {
        $permissions = json_decode(session()->get('permissions'), true);
    }
    if (session()->has('isAdmin')) {
        $is_super_admin = session()->get('isAdmin');
    }
    foreach ($data as $key => $value) {
        $site_edit = '';
        $site_delete = '';
        if ($request->resource_by == 'guard' && $value->fortnightly_working_hours > 0) {
                // $value->fortnightly_working_hours = $value->fortnightly_working_hours / 2;
            $roster_data = DB::table('job_new_roster')->where('temp_start', '>=', $request->start)->where('temp_start', '<=', $request->end)->where('guard_id', $value->id)->get();
            $hours = 0;
            foreach ($roster_data as $r) {
                $time = $this->getTimeDiff($r->temp_start, $r->temp_end);
                $hours += $time['hours'];
            }
            $total_hours = explode('.', $hours);
            if (sizeof($total_hours) > 1) {
                $partial = '.' . $total_hours[1];
                if ($partial < 0.1) {
                    $hours = $total_hours[0];
                }
                if ($partial < 0.27 && $partial > 0.1) {
                    $hours = $total_hours[0] . '.25';
                }
                if ($partial > 0.27 && $partial < 0.52) {
                    $hours = $total_hours[0] . '.5';
                }
                if ($partial > 0.52 && $partial < 0.77) {
                    $hours = $total_hours[0] . '.75';
                }
                if ($partial > 0.77 && $partial < 1) {
                    $hours = $total_hours[0] + 1;
                }
            }
            $value->fortnightly_working_hours = $value->fortnightly_working_hours . '-' . $hours . ' = ' . ($value->fortnightly_working_hours - $hours);
        }
        $resourceId = '';
        if ($request->resource_by == 'guard') {
            $resourceId = str_replace(' ', '-', $value->name);
        } else {
            $resourceId = str_replace(' ', '-', $value->site_name);
        }
        $three_dot = '<span class="siteBtn" style="display: inline-block;"><div class="dropdown m-1" style="display:inline-block;" onclick="selectSite(\'' . $resourceId . '-' . $value->id . '\', ' . $value->id . ')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div></span>';
        if ($request->has('filter') && $request->filter != '' && $request->filter != 'all') {
            if ($request->filter == 'active') {
                if ($is_super_admin == 1 || (isset($permissions['site_edit']) && $permissions['site_edit'] == true)) {
                    $site_edit = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite(' . $value->id . ')"></i></span>';
                } else {
                    $site_edit = '';
                    if (session()->get('userType') == 'customer') {
                        $site_edit = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite(' . $value->id . ')"></i></span></div></span>';
                    }
                }
                if ($is_super_admin == 1 || (isset($permissions['site_delete']) && $permissions['site_delete'] == true)) {
                    $site_delete = '<span class="siteBtn" style="display: inline-block;"><i onclick="deleteSite(' . $value->id . ')" class="fas fa-trash"></i></span>';
                } else {
                    $site_delete = '';
                    if (session()->get('userType') == 'customer') {
                        $site_delete = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite(' . $value->id . ')"></i></span></div></span>';
                    }
                }
                if (isset($allguard) && $allguard == 0) {
                    $guard_btn = '';
                } else {
                    $guard_btn = ('<span class="siteBtn" style="display: inline-block;"><div class="dropdown m-1" style="display:inline-block;" onclick="selectGuard(\'' . $resourceId . '-' . $value->id . '\', ' . $value->id . ')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div></span>');
                }
                $resources[] = array(
                    'id' => $resourceId . '-' . $value->id,
                    'r_id' => $value->id,
                    'title' => ($request->resource_by == 'guard') ? $value->name . '<br>' . $value->phone . '<br>' . $value->fortnightly_working_hours . '<br>' . $guard_btn : ('<span style="display: inline-block;">' . $value->site_name . ' <br>(' . $value->site_description . ')</span>' . $three_dot . $site_edit . $site_delete)
                );
            } elseif ($request->filter == 'inactive') {
                if ($request->resource_by == 'guard') {
                    $roster_data = DB::table('job_new_roster')->where('temp_start', '>=', $request->start)->where('temp_start', '<=', $request->end)->where('guard_id', $value->id)->first();
                } else {
                    $roster_data = DB::table('job_new_roster')->where('temp_start', '>=', $request->start)->where('temp_start', '<=', $request->end)->where('site_id', $value->id)->first();
                }
                if (empty($roster_data)) {
                    if ($is_super_admin == 1 || (isset($permissions['site_edit']) && $permissions['site_edit'] == true)) {
                        $site_edit = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite(' . $value->id . ')"></i></span>';
                    } else {
                        $site_edit = '';
                        if (session()->get('userType') == 'customer') {
                            $site_edit = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite(' . $value->id . ')"></i></span></div></span>';
                        }
                    }
                    if ($is_super_admin == 1 || (isset($permissions['site_delete']) && $permissions['site_delete'] == true)) {
                        $site_delete = '<span class="siteBtn" style="display: inline-block;"><i onclick="deleteSite(' . $value->id . ')" class="fas fa-trash"></i></span>';
                    } else {
                        $site_delete = '';
                        if (session()->get('userType') == 'customer') {
                            $site_delete = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite(' . $value->id . ')"></i></span></div></span>';
                        }
                    }
                    if (isset($allguard) && $allguard == 0) {
                        $guard_btn = '';
                    } else {
                        $guard_btn = ('<span class="siteBtn" style="display: inline-block;"><div class="dropdown m-1" style="display:inline-block;" onclick="selectGuard(\'' . $resourceId . '-' . $value->id . '\', ' . $value->id . ')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div></span>');
                    }
                    $resources[] = array(
                        'id' => $resourceId . '-' . $value->id,
                        'r_id' => $value->id,
                        'title' => ($request->resource_by == 'guard') ? $value->name . '<br>' . $value->phone . '<br>' . $value->fortnightly_working_hours . '<br>' . $guard_btn : ('<span style="display: inline-block;">' . $value->site_name . ' <br>(' . $value->site_description . ')</span>' . $three_dot . $site_edit . $site_delete)
                    );
                }
            } else {
                if ($is_super_admin == 1 || (isset($permissions['site_edit']) && $permissions['site_edit'] == true)) {
                    $site_edit = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite(' . $value->id . ')"></i></span>';
                } else {
                    $site_edit = '';
                    if (session()->get('userType') == 'customer') {
                        $site_edit = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite(' . $value->id . ')"></i></span></div></span>';
                    }
                }
                if ($is_super_admin == 1 || (isset($permissions['site_delete']) && $permissions['site_delete'] == true)) {
                    $site_delete = '<span class="siteBtn" style="display: inline-block;"><i onclick="deleteSite(' . $value->id . ')" class="fas fa-trash"></i></span>';
                } else {
                    $site_delete = '';
                    if (session()->get('userType') == 'customer') {
                        $site_delete = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite(' . $value->id . ')"></i></span></div></span>';
                    }
                }
                if (isset($allguard) && $allguard == 0) {
                    $guard_btn = '';
                } else {
                    $guard_btn = ('<span class="siteBtn" style="display: inline-block;"><div class="dropdown m-1" style="display:inline-block;" onclick="selectGuard(\'' . $resourceId . '-' . $value->id . '\', ' . $value->id . ')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div></span>');
                }
                $resources[] = array(
                    'r_id' => $value->id,
                    'id' => $resourceId . '-' . $value->id,
                    'title' => ($request->resource_by == 'guard') ? $value->name . '<br>' . $value->phone . '<br>' . $value->fortnightly_working_hours . '<br>' . $guard_btn : ('<span style="display: inline-block;">' . $value->site_name . ' <br>(' . $value->site_description . ')</span>' . $three_dot . $site_edit . $site_delete)
                );
            }
        } else {
            $three_dots = '';
            if (session()->has('config_arr_job_roster')  && session()->get('config_arr_job_roster') != '' && isset(session()->get('config_arr_job_roster')[0]->three_dots_shifts)) {
                $three_dots = (session()->get('config_arr_job_roster')[0]->three_dots_shifts);
            }

            if ($is_super_admin == 1 || (isset($permissions['site_edit']) && $permissions['site_edit'] == true)) {
                    // dd(true);
                $site_edit = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite(' . $value->id . ')"></i>';
                if (isset($three_dots) && $three_dots == 1) {
                    $site_edit .= '<div id="ellipsis-none" class="dropdown m-1" style="display:inline-block;" onclick="selectSite(\'' . $resourceId . '-' . $value->id . '\', ' . $value->id . ')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div>';
                }

                $site_edit .= '</span>';
            } else {
                $site_edit = '';
                if (session()->get('userType') == 'customer') {
                    $site_edit = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite(' . $value->id . ')"></i></span></div></span>';
                }
            }
            if ($is_super_admin == 1 || (isset($permissions['site_delete']) && $permissions['site_delete'] == true)) {
                    // dd(true);
                $site_delete = '<span class="siteBtn" style="display: inline-block;"><i onclick="deleteSite(' . $value->id . ')" class="fas fa-trash"></i>';
                if (isset($three_dots) && $three_dots == 1) {
                    $site_delete .= '<div id="ellipsis-none" class="dropdown m-1" style="display:inline-block;" onclick="selectSite(\'' . $resourceId . '-' . $value->id . '\', ' . $value->id . ')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div>';
                }

                $site_delete .= '</span>';
            } else {
                $site_delete = '';
                if (session()->get('userType') == 'customer') {
                    $site_delete = '<span class="siteBtn" style="display: inline-block;"><i class="fas fa-edit m-1" onclick="editSite(' . $value->id . ')"></i></span></div></span>';
                }
            }
            if (isset($allguard) && $allguard == 0) {
                $guard_btn = '';
            } else {
                $guard_btn = ('<span class="siteBtn" style="display: inline-block;"><div class="dropdown m-1" style="display:inline-block;" onclick="selectGuard(\'' . $resourceId . '-' . $value->id . '\', ' . $value->id . ')"><span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span></div></span>');
            }
            $resources[] = array(
                'r_id' => $value->id,
                'id' => $resourceId . '-' . $value->id,
                'title' => ($request->resource_by == 'guard') ? $value->name . '<br>' . $value->phone . '<br>' . $value->fortnightly_working_hours . '<br>' . $guard_btn : ('<span style="display: inline-block;">' . $value->site_name . ' <br>(' . $value->site_description . ')</span>' . $three_dot . $site_edit . $site_delete)
            );
        }
    }
        // }

    return response()->json($resources);
}

function getPayChargeRate(Request $request)
{
    if ($request->type == 'payrate') {
        $query = DB::table('payrates')->where('payrates.archive', 0);
        if ($request->has('site_id') && $request->site_id != '') {
            $query->join('jobs', 'jobs.customer_id', '=', 'payrates.customer_id');
            $query->where('jobs.id', $request->site_id);
            if (config('custom.categorized_payrates') == 1) {
                $payrol = DB::table('jobs')->where('id', $request->site_id)->value('payrol');
                if ($payrol == 'Default Rates') {
                    $query->where('payrates.payrate_type', 'default');
                }
                if ($payrol == 'EBA Rates') {
                    $query->where('payrates.payrate_type', 'eba');
                }
                if ($payrol == 'Award Rates') {
                    $query->where('payrates.payrate_type', 'award');
                }
            }
        }
        $rates = $query->where('payrates.state', $request->state)->where('payrates.level', $request->level)->select('payrates.id', 'payrates.title')->orderBy('payrates.title', 'ASC')->get();
    } else {
        $query = DB::table('charged_rates')->where('charged_rates.archive', 0);
        if ($request->has('site_id') && $request->site_id != '') {
            $query->join('jobs', 'jobs.customer_id', '=', 'charged_rates.customer_id');
            $query->where('jobs.id', $request->site_id);
        }
        $rates = $query->where('charged_rates.state', $request->state)->where('charged_rates.level', $request->level)->select('charged_rates.id', 'charged_rates.title')->orderBy('charged_rates.title', 'ASC')->get();
    }
    return response()->json(['success' => true, 'rates' => $rates]);
}

function getSiteActiveGuards($siteID)
{
    $guards =  DB::table('guards')
    ->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')
    ->where(['jobs_guards.job_id' => $siteID, 'guards.status' => 'active'])
    ->select('guards.id', 'guards.name', 'jobs_guards.job_id as jobId')
    ->orderBy('guards.name', 'ASC')
    ->get();
    if (count($guards) > 0) {
        return response()->json(['status' => true, 'message' => 'Data found', 'data' => $guards]);
    } else {
        return response()->json(['status' => false, 'message' => 'No data found!']);
    }
}
public function getAddGuardFrom(Request $request)
{
    $allguard = '';
    $continuation = '';
    $break_management = '';
    $covid_marshal = '';

    if (session()->has('config_arr_job_roster')  && session()->get('config_arr_job_roster') != '' && isset(session()->get('config_arr_job_roster')[0]->add_guards)) {
        $allguard = (session()->get('config_arr_job_roster')[0]->add_guards);
    }

    if (session()->has('config_arr_job_roster')  && session()->get('config_arr_job_roster') != '' && isset(session()->get('config_arr_job_roster')[0]->continuation)) {
        $continuation = (session()->get('config_arr_job_roster')[0]->continuation);
    }

    if (session()->has('config_arr_job_roster')  && session()->get('config_arr_job_roster') != '' && isset(session()->get('config_arr_job_roster')[0]->break_management)) {
        $break_management = (session()->get('config_arr_job_roster')[0]->break_management);
    }
    if (session()->has('config_arr_job_roster')  && session()->get('config_arr_job_roster') != '' && isset(session()->get('config_arr_job_roster')[0]->covid_marshal)) {
        $covid_marshal = (session()->get('config_arr_job_roster')[0]->covid_marshal);
    }

    $config_recods = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id'  , config('custom.domain_id'))->where('type' , 'job_roster_navigation_bar')->first();
    $settings = !empty($config_recods) ? json_decode($config_recods->records_business_navbar, true) : array();

        // dd($covid_marshal);
        // dd(false);
    $data['gaurd'] = array();
    $data['payrates'] = array();
    $data['charged_rates'] = array();
    $data['gaurds_disabeld'] = '';
    $data['site_disabeld'] = '';
    $data['site_id'] = '';
    $data['guard_id'] = '';
    $data['guards'] = array();
    $state = 'Victoria';
    if ($request->resource != null && $request->resource != '' && $request->resource != 'a-0') {
        $resource = $request->resource;
        $resource = explode('-', $resource);
        if ($resource[0] == 'guard') {
            if (isset($allguard) && $allguard == 0) {
                $customerIds = $request->customerIds;
                $data['sites'] = DB::table('jobs')
                ->join('customers', 'customers.id', '=', 'jobs.customer_id')
                ->where(function ($query) use ($customerIds) {
                    $i = 0;
                    foreach ($customerIds as $key => $customerId) {
                        if ($i = 0) {
                            $query->where('customers.id', $customerId);
                        } else {
                            $query->orWhere('customers.id', $customerId);
                        }
                        $i++;
                    }
                })
                        // ->join('jobs_guards', 'jobs_guards.job_id', '=', 'jobs.id')
                        // ->where('customers.id', $request->customerId)
                        // ->where('jobs_guards.guard_id', $resource[1])
                ->where('jobs.status', 'active')
                ->where('jobs.state', $request->state)
                ->select('customers.id as customerId', 'jobs.id as jobId', 'jobs.site_tasks as site_tasks', 'jobs.address as address', 'jobs.booking_id as bookingId', 'jobs.site_name', 'jobs.site_description', 'jobs.state')->get();
            } else {
                $data['sites'] = DB::table('jobs')
                ->join('customers', 'customers.id', '=', 'jobs.customer_id')
                ->join('jobs_guards', 'jobs_guards.job_id', '=', 'jobs.id')
                        // ->where('customers.id', $request->customerId)
                ->where('jobs_guards.guard_id', $resource[1])
                ->where('jobs.status', 'active')
                ->where('jobs.state', $request->state)
                ->select('customers.id as customerId', 'jobs.id as jobId', 'jobs.site_tasks as site_tasks', 'jobs.address as address', 'jobs.booking_id as bookingId', 'jobs.site_name', 'jobs.site_description', 'jobs.state')->get();
            }
            $data['site_specific_tasks'] = "invalid";
            $data['gaurds_disabeld'] = 'disabled';
            $data['guard_id'] = $resource[1];
            $data['guards'] =  DB::table('guards')->where(['guards.id' => $resource[1], 'guards.status' => 'active'])->select('guards.*')->orderBy('name', 'ASC')->get();

                // $state = $data['sites'][0]->

        } elseif ($resource[0] == 'sites') {
            $data['sites'] = DB::table('jobs')
            ->join('customers', 'customers.id', '=', 'jobs.customer_id')
                    // ->where('customers.id', $request->customerId)
            ->where('jobs.id', $resource[1])
            ->where('jobs.status', 'active')
            ->where('jobs.state', $request->state)
            ->select('customers.id as customerId', 'jobs.id as jobId', 'jobs.site_tasks as site_tasks', 'jobs.address as address', 'jobs.booking_id as bookingId', 'jobs.site_name', 'jobs.site_description', 'jobs.state')->get();
            $data['site_specific_tasks'] = $data['sites']->pluck('site_tasks')->first();
            $data['site_disabeld'] = 'disabled';
            $data['site_id'] = $resource[1];
            if (isset($allguard) && $allguard == 0) {
                    // dd(true);
                $data['guards'] =  DB::table('guards')
                ->where(['status' => 'active'])->select('guards.*')->orderBy('guards.name', 'ASC')->get();
            } else {
                    // dd(false);
                $data['guards'] =  DB::table('guards')
                ->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')->where(['jobs_guards.job_id' => $resource[1], 'guards.status' => 'active', 'state' => $request->state])->select('guards.*', 'jobs_guards.job_id as jobId')->orderBy('guards.name', 'ASC')->get();
            }
        }
            // print_r($data['site_specific_tasks']);
            // exit;
    } else {
        $customerIds = $request->customerIds;
        $data['sites'] = DB::table('jobs')->join('customers', 'customers.id', '=', 'jobs.customer_id')
        ->where('jobs.state', $request->state)
        ->where(function ($query) use ($customerIds) {
            $i = 0;
            foreach ($customerIds as $key => $customerId) {
                if ($i = 0) {
                    $query->where('customers.id', $customerId);
                } else {
                    $query->orWhere('customers.id', $customerId);
                }
                $i++;
            }
        })
        ->where('jobs.status', 'active')
        ->select('customers.id as customerId', 'jobs.id as jobId', 'jobs.address as address', 'jobs.booking_id as bookingId', 'jobs.site_name', 'jobs.site_description')->get();
    }
    $data['start'] = $request->start;
    if (!isset($data['site_specific_tasks']) || empty($data['site_specific_tasks']) || $data['site_specific_tasks'] == '' || !is_array($data['site_specific_tasks'])) {
        $data['site_specific_tasks'] = 'invalid';
    }
    $date = $request->start;
    $date = explode(' ', $date);
    $date = str_replace('-', '', $date[0]);
    $data['date'] = $date;
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
    $state = $states_array[$request->state];
    $checkHoliday = DB::table('public_holidays')->where('date', $date)->where('state', $state)->first();
    if (!empty($checkHoliday)) {
        $data['holiday_name'] = $checkHoliday->holiday_name;
        $data['information'] = $checkHoliday->information;
        $data['ph'] = true;
    } else {
        $data['ph'] = false;
    }
        // dd($date);
    $data['continuation'] = $continuation;
    $data['break_management'] = $break_management;
    $data['covid_marshal'] = $covid_marshal;
    $data['settings'] = $settings;
    $formHtml = view('admin/modals/addGuardForm', $data)->render();
    return response()->json($formHtml);
}

function rosterTasks($roster_id)
{
    return DB::table('job_roster_tasks')->where('roster_id', $roster_id)->get();
}
function rosterTasksPhotos($roster_id)
{
    return DB::table('job_roster_activities')->where('job_roster_id', $roster_id)->value('tasks_photos');
}
function rosterCompletedTasks($roster_id)
{
    return DB::table('job_roster_tasks')->where('roster_id', $roster_id)->where('end_time', '!=', '')->get();
}

function rosterActivity($roster_id)
{
    $data['activity'] = DB::table('roster_complete_activity')
    ->where('roster_id', $roster_id)
    ->where(function ($query) {
        $query->where('type', 'incident_report');
        $query->orWhere('type', 'green_call');
        $query->orWhere('type', 'leave_location');
        $query->orWhere('type', 'welfare_call');
        $query->orWhere('type', 'leave_location');
        $query->orWhere('type', 'job_confirm');
        $query->orWhere('type', 'job_signin');
        $query->orWhere('type', 'job_signout');
        $query->orWhere('type', 'auto_signout');
        $query->orWhere('type', 'sos_call');
        $query->orWhere('type', 'leave_location');
        $query->orWhere('type', 'break');
        $query->orWhere('type', 'shift_edit');
        $query->orWhere('type', 'internet');
        $query->orWhere('type', 'shift_create');
    })
    ->orderBy('id', 'desc')
    ->get();

        // $data['incident_reports'] = DB::table('roster_complete_activity')
        // ->where('roster_id', $roster_id)
        // ->where('type', '=', 'incident_report')
        // ->orderBy('id', 'desc')->get();

        //  $data['welfare_call'] = DB::table('roster_complete_activity')
        // ->where('roster_id', $roster_id)
        // ->where('type', '=', 'welfare_call')
        // ->orderBy('id', 'desc')->get();

        // $data['green_call'] = DB::table('green_call')
        // ->where('green_call.job_id', $roster_id)
        // ->orderBy('green_call.id', 'desc')->get();

        // $data['leave_location'] = DB::table('roster_complete_activity')
        // ->where('roster_id', $roster_id)
        // ->where('type', '=', 'leave_location')
        // ->orderBy('id', 'desc')->get();

    return $data;
}

function rosterActivity_old($roster_id)
{
    $data['activity'] = DB::table('roster_complete_activity')
    ->where('roster_id', $roster_id)
    ->where('type', '!=', 'incident_report')
    ->where('type', '!=', 'green_call')
    ->where('type', '!=', 'welfare_call')
    ->where('type', '!=', 'leave_location')
    ->orderBy('id', 'desc')->get();

    $data['incident_reports'] = DB::table('roster_complete_activity')
    ->where('roster_id', $roster_id)
    ->where('type', '=', 'incident_report')
    ->orderBy('id', 'desc')->get();

    $data['welfare_call'] = DB::table('roster_complete_activity')
    ->where('roster_id', $roster_id)
    ->where('type', '=', 'welfare_call')
    ->orderBy('id', 'desc')->get();

    $data['green_call'] = DB::table('green_call')
    ->where('green_call.job_id', $roster_id)
    ->orderBy('green_call.id', 'desc')->get();

    $data['leave_location'] = DB::table('roster_complete_activity')
    ->where('roster_id', $roster_id)
    ->where('type', '=', 'leave_location')
    ->orderBy('id', 'desc')->get();

    return $data;
}

function loadTabData(Request $request)
{
    if ($request->tab == 'signin' || $request->tab == 'signout') {
        $data['roster_activity'] = DB::table('job_roster_activities')->where('job_roster_id', $request->roster_id)->first();
        if (!empty($data['roster_activity'])) {
            $data['roster_activity']->address = $this->coordinates_to_address($data['roster_activity']->location);
        }
        if ($request->tab == 'signout') {
            $formHtml = view('admin/tabs/signout', $data)->render();
        } else {
            $formHtml = view('admin/tabs/signin', $data)->render();
        }
    }
    if ($request->tab == 'tracker') {
        $guard_location_at_job = DB::table('guard_location_at_job')->where('guard_id', $request->guard_id)->where('roster_id', $request->roster_id)->get();
        $i = 0;
        foreach ($guard_location_at_job as $gl) {
            $gl->coordinates = str_replace('undefined', '0', $gl->coordinates);
            $guard_location_at_job[$i]->address = ($gl->coordinates == '0,0' || $gl->coordinates == '0, 0') ? 'Cannot get the location of the staff due to internet or GPs turned off reason.' : $this->coordinates_to_address($gl->coordinates);
            $gl->coordinates = '';
            $i++;
        }
        $data['guard_location_at_job'] = $guard_location_at_job;
        $formHtml = view('admin/tabs/tracker', $data)->render();
    }
    if ($request->tab == 'incident') {
        $data['incident_reports'] = DB::table('job_incident_reports')->where('roster_id', $request->roster_id)->where('guard_id', $request->guard_id)->orderBy('id', 'DESC')->get();
        $data['incident_reports_new'] = DB::table('incident_reports')->where('roster_id', $request->roster_id)->where('guard_id', $request->guard_id)->orderBy('id', 'DESC')->get();
        $formHtml = view('admin/tabs/incident', $data)->render();
    }
    if ($request->tab == 'foot_patrol_report') {
        $data['foot_patrol_report'] = DB::table('foot_patrol_reports')->where('roster_id', $request->roster_id)->where('guard_id', $request->guard_id)->orderBy('id', 'DESC')->get();
        $formHtml = view('admin/tabs/foot_patrol', $data)->render();
    }
    if ($request->tab == 'shift_activity') {
        $rosterData = $this->rosterDataNew($request->roster_id);
        $activity = $this->rosterActivity($request->roster_id);
        foreach ($activity['activity'] as $key => $act) {
            if ($act->type == 'shift_create' || $act->type == 'shift_edit') {
                $act->by = DB::table('administrators')->where('id', $act->activity_by)->value('name');
            }
        }
        $data['roster'] = $rosterData;
        $data['activity'] = $activity;

        $formHtml = view('admin/tabs/shift_activity', $data)->render();
    }
    if ($request->tab == 'green_call') {
        $data['green_calls'] = DB::table('green_call')
        ->where('green_call.job_id', $request->roster_id)
        ->orderBy('green_call.id', 'desc')->get();
        $formHtml = view('admin/tabs/green_call', $data)->render();
    }
    if ($request->tab == 'welfare_call') {
        $data['welfare_calls'] = DB::table('welfare_call_data')
        ->where('welfare_call_data.job_roster_id', $request->roster_id)
        ->orderBy('welfare_call_data.id', 'desc')->get();
        $formHtml = view('admin/tabs/welfare_call', $data)->render();
    }
    if ($request->tab == 'break_details') {
        $data['break_details'] = DB::table('job_breaks')
        ->where('job_breaks.roster_id', $request->roster_id)
        ->orderBy('job_breaks.id', 'desc')->get();
        $formHtml = view('admin/tabs/break_details', $data)->render();
    }
    return response()->json($formHtml);
}
function getShiftDetails(Request $request)
{
    return $this->geteditGuardFrom($request, 'api');
}

public function geteditGuardFrom(Request $request, $call_from = null)
{
    $allguard = '';

    if (session()->has('config_arr_job_roster')  && session()->get('config_arr_job_roster') != '' && isset(session()->get('config_arr_job_roster')[0]->add_guards)) {
        $allguard = (session()->get('config_arr_job_roster')[0]->add_guards);
    }
    $break_management = '';
    if (session()->has('config_arr_job_roster')  && session()->get('config_arr_job_roster') != '' && isset(session()->get('config_arr_job_roster')[0]->break_management)) {
        $break_management = (session()->get('config_arr_job_roster')[0]->break_management);
    }
    $covid_marshal = '';
    if (session()->has('config_arr_job_roster')  && session()->get('config_arr_job_roster') != '' && isset(session()->get('config_arr_job_roster')[0]->covid_marshal)) {
        $covid_marshal = (session()->get('config_arr_job_roster')[0]->covid_marshal);
    }
    $config_recods = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id'  , config('custom.domain_id'))->where('type' , 'job_roster_navigation_bar')->first();
    $settings = !empty($config_recods) ? json_decode($config_recods->records_business_navbar, true) : array();

    $rosterData = $this->rosterData($request->event_id);
    $rosterData->manual_custom_payrates = json_decode($rosterData->manual_custom_payrates, true);
    $rosterData->custom_charge_rate = json_decode($rosterData->custom_charge_rate, true);
    $tasks = $this->rosterTasks($rosterData->roster_id);
    $tasks_photos = $this->rosterTasksPhotos($rosterData->roster_id);
    if ($tasks_photos != null && $tasks_photos != '') {
        $tasks_photos = json_decode($tasks_photos);
    }else{
        $tasks_photos = array();
    }
    $data['payrates'] = DB::table('payrates')->where('payrates.archive', 0)
    ->join('jobs', 'jobs.customer_id', '=', 'payrates.customer_id')
    ->where('jobs.id', $rosterData->site_id)
    ->select('payrates.id', 'payrates.title', 'payrates.level')->get();
    $data['charged_rates'] = DB::table('charged_rates')->where('archive', 0)
    ->join('jobs', 'jobs.customer_id', '=', 'charged_rates.customer_id')
    ->where('jobs.id', $rosterData->site_id)
    ->select('charged_rates.id', 'charged_rates.title', 'charged_rates.level')->orderBy('title', 'ASC')->get();
    if ($rosterData->payrate_id > 0) {
        $level = DB::table('payrates')->where('id', $rosterData->payrate_id)->where('archive', 0)->value('level');
        $rosterData->payrate_level = $level;
    }else{
        $rosterData->payrate_level = '';
    }
    if ($rosterData->chargerate_id > 0) {
        $level = DB::table('charged_rates')->where('archive', 0)->where('id', $rosterData->chargerate_id)->value('level');
        $rosterData->chargedrate_level = $level;
    }else{
        $rosterData->chargedrate_level = '';
    }
    $data['gaurd'] = array();
    $data['roster'] = $rosterData;
    $data['tasks'] = $tasks;
    $data['tasks_photos'] = $tasks_photos;
    $data['gaurds_disabeld'] = '';
    $data['site_disabeld'] = '';
    $data['site_id'] = '';
    $data['guard_id'] = $rosterData->guard_id;
        // $data['guard_id'] = $rosterData->guard_id;
    $data['guards'] = array();
    $data['sites'] = DB::table('jobs')
    ->join('customers', 'customers.id', '=', 'jobs.customer_id')
            // ->where('customers.id', $request->customerId)
    ->where('jobs.id', $rosterData->site_id)
    ->where('jobs.status', 'active')
    ->select('customers.id as customerId', 'jobs.id as jobId', 'jobs.address as address', 'jobs.booking_id as bookingId', 'jobs.site_name', 'jobs.site_description')->get();
    $data['site_disabeld'] = 'disabled';
    $data['site_id'] = $rosterData->site_id;
    if (isset($allguard) && $allguard == 0) {
            // dd(true);
        $data['guards'] =  DB::table('guards')
        ->where(['status' => 'active'])->select('guards.*')->orderBy('guards.name', 'ASC')->get();
    } else {
        $data['guards'] =  DB::table('guards')
        ->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')->where(['jobs_guards.job_id' => $rosterData->site_id, 'guards.status' => 'active'])->select('guards.*', 'jobs_guards.job_id as jobId')->orderBy('guards.name', 'ASC')->get();
    }
    $data['convert_asap_status'] = $rosterData->convert_asap_status;
    if ($call_from == 'api') {
        if (count($data) > 0) {
            return response()->json(['status' => true, 'message' => 'Data found', 'data' => $data]);
        } else {
            return response()->json(['status' => false, 'message' => 'No data found!']);
        }
    } else {
        $states_array = array(
            'Victoria' => 'vic',
            'NSW' => 'nsw',
            'New South Wales' => 'nsw',
            'Queensland' => 'qld',
            'Tasmania' => 'tas',
            'Western Australia' => 'wa',
            'South Australia' => 'sa',
            'ACT' => 'act'
        );
        $date = $rosterData->temp_start;
        $date = explode(' ', $date);
        $date = str_replace('-', '', $date[0]);
        $data['date'] = $date;
        $state = $states_array[$request->state];
        $checkHoliday = DB::table('public_holidays')->where('date', $date)->where('state', $state)->first();
        if (!empty($checkHoliday)) {
            $data['holiday_name'] = $checkHoliday->holiday_name;
            $data['information'] = $checkHoliday->information;
            $data['ph'] = true;
        } else {
            $data['ph'] = false;
        }
        $data['break_management'] = $break_management;
        $data['covid_marshal'] = $covid_marshal;
        $data['settings'] = $settings;
        if ($data['roster']->guard_id == '' || $data['roster']->guard_id == null) {
            $data['roster']->guard_id = 0;
        }
        if ($rosterData->own_payrate != '' && $rosterData->own_payrate != 'undefined') {
            if ($rosterData->own_payrate == 'award') {
                 $data['payrates'] = DB::table('award_payrates')->select('id', 'title')->get();
            }else{
                 $data['payrates'] = DB::table('payrates')->where('payrate_type', $rosterData->own_payrate)->select('id', 'title')->get();
            }
        }else{
            // $data['payrates'] = array();
            $query = DB::table('payrates')->where('payrates.archive', 0);
            $query->join('jobs', 'jobs.customer_id', '=', 'payrates.customer_id');
            $query->where('jobs.id', $rosterData->site_id);
            $data['payrates'] = $query->where('payrates.level', $rosterData->payrate_level)->select('payrates.id', 'payrates.title')->orderBy('payrates.title', 'ASC')->get();
        }
        $formHtml = view('admin/modals/editGuardForm', $data)->render();
        return response()->json($formHtml);
    }
}

public function covid_status(Request $request)
{
    if ($request->check == "checked") {
        $result = DB::table('guards')->where('id', $request->id)->update(['covid' => 1]);

        return "checked";
    } else {
        $result = DB::table('guards')->where('id', $request->id)->update(['covid' => 0]);
        return "unchecked";
    }
}

public function admin_approval_status(Request $request)
{
    if ($request->check == "checked") {
        $result = DB::table('guards')->where('id', $request->id)->update(['status' => 'active']);
        $data = DB::table('guards')->where('id', $request->id)->get();
        $action = 'guard_admin_approval';
        $this->administrator->log_user_activity($action, $data);
        $message2 = '<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
        <br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
        <tbody><tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="' . config('custom.logo') . '" rel="noopener" target="_blank"><img src="https://vcpgsystem.com.au/asset_uploads/vcpg.png" style="height: 45px" alt="logo"></a></td></tr><tr>
        <td align="left" valign="center">
        <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px"><!--begin:Email content--><div style="padding-bottom: 30px; font-size: 17px;"><strong>Account Approval .</strong></div></td></tr>';
        $message2 .= '<tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="#" rel="noopener" target="_blank"><img src="' . config('custom.asset_url') . 'app_store.png" style="height: 45px" alt="logo"></a></td><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="#" rel="noopener" target="_blank"><img src="' . config('custom.asset_url') . 'play_store.png" style="height: 45px" alt="logo"></a></td></tr>';
        $message2 .= '</tbody></table>';
        $apikey = base64_encode(Str::random(64) . time());
        $guard = DB::table('guards')->where('id', $request->id)->first();
        $subject = 'Account Approval!';
        // $this->send_guard_approval_mail($guard, $subject, $message2);
        return "checked";
    } else {
        $result = DB::table('guards')->where('id', $request->id)->update(['status' => 'inactive']);
        return "no checked";
    }
}
public function guard_active_inactive_status(Request $request)
{
    if ($request->check == "checked") {
        $result = DB::table('guards')->where('id', $request->id)->update(['admin_approved' => 1]);
        return "checked";
    } else {
        $result = DB::table('guards')->where('id', $request->id)->update(['admin_approved' => 0]);
        return "no checked";
    }
}
public function deleteTask(Request $request)
{
    $task = DB::table('job_roster_tasks')->where('id', $request->task_id)->first();
    if ($task->guard_id > 0) {
        $guard_data = DB::table('guards')->where('id', $task->guard_id)->first();
        $notification_data['guards'][0] = array(
            'guard_id' => $guard_data->id,
            'notification_token' => $guard_data->notification_token
        );
        $notification_data['title'] = 'Task delete';
        $notification_data['message'] = 'Task Remove - One of your task is removed';
        $notification_data['page'] = 'homepage';
        $res = $this->guard_model->send_push_notification($notification_data);
    }
    DB::table('job_roster_tasks')->where('id', $request->task_id)->delete();

    return response()->json(['success' => true, 'message' => 'Task deleted successfully']);
}

public function guard_shift_hours_stats(Request $request)
{
    $months = [];
    $month_number = [];

    $current_month = date('m');
    for ($i = 0; $i <= 5; $i++) {
        $months[$i] = date('M', strtotime(date('M') . -$i . 'month'));
    };
    for ($i = 0; $i <= 5; $i++) {
        $month_number[$i] = $current_month - $i;
    };
    $specific_month_hours = [];
    $shifts = [];

    $month_number = array_reverse($month_number);
        //    print_r($month_number) ;
        //    exit();

    $months = array_reverse($months);
    for ($i = 0; $i <= 5; $i++) {
        $total_hours = 0;
        $roster = DB::table('job_new_roster')->where('guard_id', $request->id)->whereMonth('temp_start', $month_number[$i])->select('roster_id', 'temp_start', 'temp_end')->get();
        $shifts[$i] = $roster->count();
        foreach ($roster as $r) {
            $time = $this->getTimeDiff($r->temp_start, $r->temp_end);
            $hours = $time['hours'];
            $total_hours = $total_hours +  $hours;
        }
        $specific_month_hours[$i] = round($total_hours);
    }

    return ['months' => $months, 'shifts' => $shifts, 'specific_month_hours' => $specific_month_hours];
}




public function deleteguard($id)
{
    $data = DB::table('guards')->where('id', $id)->get();
    $action = 'guard_delete';
    $this->administrator->log_user_activity($action, $data);
    $query =  DB::table('guards')->where('id', $id)->update(['status' => "deleted"]);
    return response()->json(['success' => true, 'msg' => "deleted Successfully"]);
}

public function restoreguard($id)
{
        // echo $id;
        // exit();
    $query =  DB::table('guards')->where('id', $id)->update(['status' => "inactive"]);
    return response()->json(['success' => true, 'msg' => "Restored  Successfully"]);
}
function addMultipleShiftsForm(Request $request)
{

    $data['sites'] = DB::table('jobs')->join('customers', 'customers.id', '=', 'jobs.customer_id')
    ->where('customers.id', $request->customerId)
    ->where('jobs.status', 'active')
    ->select('customers.id as customerId', 'jobs.id as jobId', 'jobs.address as address', 'jobs.booking_id as bookingId', 'jobs.site_name', 'jobs.site_description')->get();

    $formHtml = view('admin/modals/addMultipleShiftsForm', $data)->render();
    return response()->json($formHtml);
}


private function encryptPassword($password)
{

    return password_hash($password, CRYPT_SHA512);
}

    // public function do_login_guard(Request $request)
    // {
    //     // $password = $this->encryptPassword($request->input('password'));

    //     $apikey = base64_encode(Str::random(64).time());
    //     $guard = guard::where(['email' => $request->input('email')])->first();
    //     if (Hash::check($request->input('password'), $guard->password)) {

    //         guard::where('id', $guard->id)->update(['auth_token' => $apikey,'last_login'=>date("d-m-Y H:i")]);
    //         session([
    //             'userId' => $guard['id'],
    //             'userType' => 'guard', 
    //             'image' => $guard['image'],  
    //             'userName' => $guard['name'],  
    //             'authToken' => $apikey]);
    //         return redirect('/guard_profile'.session::get('userId'))->with('msg', 'Invalid Login Details');

    //     }else{
    //         return redirect('/guard/login')->with('msg', 'Invalid Login Details');
    //     }

    //     // dd($request->session());
    // }

public function guard_login()
{
    if (!session()->has('userType') || session::get('userType') != 'guard') {
        return view('guard/guard_login');
    } else {
        return redirect('/guard_profile' . '/' . session::get('userId'));
    }
}
public function addNewShift(Request $request)
{
    $data['sites'] = DB::table('jobs')->join('customers', 'customers.id', '=', 'jobs.customer_id')
    ->where('customers.id', $request->customerId)
    ->where('jobs.status', 'active')
    ->select('customers.id as customerId', 'jobs.id as jobId', 'jobs.address as address', 'jobs.booking_id as bookingId', 'jobs.site_name', 'jobs.site_description')->get();
    $data['index'] = $request->index;
    $formHtml = view('admin/modals/addNewMultipleShiftsForm', $data)->render();
    return response()->json($formHtml);
}

public function addMultipleShifts(Request $request)
{
    $conflict = 0;
    foreach ($request->shifts as $shift) {
        $last_roster = DB::table('job_new_roster')->orderBy('event_id', 'DESC')->first();
        $event_id = 1;
        if (!empty($last_roster)) {
            $event_id = $last_roster->event_id + 1;
        }
        $shift['start'] = strtotime($shift['start']);
        $shift['end'] = strtotime($shift['end']);
        $next_roster = array(
            'event_id' => $event_id,
            'guard_id' => $shift['guard_id'],
            'site_id' => $shift['site_id'],
            'temp_date' => date('Y-m-d', $shift['start']),
            'temp_start' => date('Y-m-d H:i:s', $shift['start']),
            'temp_end' => date('Y-m-d H:i:s', $shift['end']),
            'start' => str_replace(' ', 'T', date('Y-m-d H:i:s', $shift['start'])) . '+10:00',
            'end' => str_replace(' ', 'T', date('Y-m-d H:i:s', $shift['end'])) . '+10:00',
                // 'publish_status' => $roster->publish_status,
            'publish_status' => (($shift['publish'] == false || $shift['publish'] == 'false') ? 0 : 1),
            'add_status' => 1,
            'job_status' => 'pending',
            'post_status' => 0,
            'green_call_notification' => 'no',
            'roll_over' => 0,
            'update_status' => 0,
            'job_start' => $shift['start'],
            'job_end' => $shift['end']
        );
        if ($next_roster['guard_id'] != '' && $next_roster['guard_id'] != null) {

            $already = DB::table('job_new_roster')->where('guard_id', $next_roster['guard_id'])->where('temp_start', '<=', $next_roster['start'])->where('temp_end', '>=', $next_roster['start'])->first();
            if (empty($already)) {
                $already = DB::table('job_new_roster')->where('guard_id', $next_roster['guard_id'])->where('temp_start', '<=', $next_roster['end'])->where('temp_end', '>=', $next_roster['end'])->first();
            }
            if (!empty($already)) {
                $next_roster['guard_id'] = 0;
                $conflict = 1;
            }
        }
        $time1 = $shift['end'];
        $time2 = $shift['start'];
        $diff = ($time1 - $time2) / (60 * 60);
        if ($diff > 12) {
            $error["success"] = false;
            $error["message"] = "You are not able to roster for more than 12 hours shift.";
            return response()->json($error);
            exit;
        }
        DB::table('job_new_roster')->insert($next_roster);
        if ($shift['no_of_users'] > 1) {
            for ($i = 1; $i < $shift['no_of_users']; $i++) {
                $next_roster['event_id'] = $next_roster['event_id'] + 1;
                DB::table('job_new_roster')->insert($next_roster);
            }
        }
    }
    return response()->json(['success' => true, 'conflict' => $conflict]);
}
public function getUnpublishedShiftCount(Request $request)
{
    $data = 0;
    foreach ($request->customerIds as $key => $customerId) {
        $counter = job_new_roster::join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->where(['job_new_roster.add_status' => 1, 'jobs.customer_id' => $customerId, 'publish_status' => 0, 'unpublish_shift' => 0])
        ->where('jobs.state', '=', $request->state)
        ->where('temp_start', '>=', $request->start)
        ->where('temp_start', '<=', $request->end);
        if ($request->has('selected_sites') && !empty($request->selected_sites)) {
            $selected_sites = $request->selected_sites;
            $counter->where(function ($query) use ($selected_sites) {
                $i = 0;
                foreach ($selected_sites as $key => $selected_site) {
                    if ($i = 0) {
                        $query->where('job_new_roster.site_id', $selected_site);
                    } else {
                        $query->orWhere('job_new_roster.site_id', $selected_site);
                    }
                    $i++;
                }
            });
        }

        $count = $counter->where('guard_id', '>', 0)->count();
        $data = $data + $count;
    }
    return response()->json(['success' => true, 'count' => $data]);
}
    //roster publish

function sendGuardMail($user, $subject, $email_message)
{

    // $root = $_SERVER['HTTP_HOST'];
    // $root = explode('.', $root);
    // $postfix = 'staffingsolution';
    // if ($root[0] != 'wwww') {
    //     $postfix = $root[0];
    // } else {
    //     $postfix = $root[1];
    // }
        // $otherdb =DB::connection('otherDB', TRUE);
        // $config_data = $otherdb->get_where('business_data', array('domain' => $postfix), 1, 0)->row_array();
    // $config_title = config('custom.title');

    $to = $user->email;

    $subject = $subject;

        // $from = 'no-reply@'.$_SERVER['HTTP_HOST'];
    // $from =  '@247staffingsolution.com.au';
    $fromEmail = 'no-reply@vcpgsystem.com.au';
    $fromName = 'VCPG Security';
        //   $logo1 = config('custom.logo');
    // $logo1 = '' . config('custom.logo') . '';
        //   $logo2 = base_url("files/email-template/ASIAL-Member-Logo-11.png");

        //   $logo3 = base_url("files/email-template/labour-hire-authority-post-banner-1.jpg");



        // To send HTML mail, the Content-type header must be set

    // $headers  = 'MIME-Version: 1.0' . "\r\n";

    // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



        // Create email headers

    // $headers .= 'From: ' . $from . "\r\n" .

    // 'Reply-To: ' . $from . "\r\n" .

    // 'X-Mailer: PHP/' . phpversion();



        // Compose a simple HTML email message

    $emailContent = 'Hello ' . $user->name . ',<br><br>';

    $emailContent .= $email_message . '<br><br>';

        //   $message .= '<span style="color:blue;">Kind Regards,</span><br><br>';

        //   $message .= '<span style="color:blue;">Admin<span><br><br>';

        //   $message .= '<span style="font-size:large;font-weight:bold;color:black;">'.$config_title.' Pty Ltd<span><br>';

        //   $message .= '<span style="font-size:small;font-weight:bold;">A: '.$config_data['address'].'<span><br>';

        // $message .= '<span style="font-weight:bold;">W: <a href="https://www.citywatchsecurity.com.au/">https://www.citywatchsecurity.com.au/</a><span><br><br><br>';

        //   $message .= '<img src="'.$logo1.'" style="width:50%;height:150px;float:left;"/></br>';
        //   


        // $message .= '<div style="padding-bottom: 30px;">Please acknowledge the new shift in the app.</div>';
    $emailContent .= '<div style="padding-bottom: 10px;">Kind regards,
    <br>  VCPG Security Team.
    </div>';
        // </div></td></tr><tr>';
        // $message .= '<td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
        // <p>' . config('custom.address') . '</p>
        // <p>Copyright ©';
        // <a href="" rel="noopener" target="_blank">' . $config_title . '</a>.
        // $message .= $config_title . '</p>
        // </td>';
        // $message .= '</tr></tbody>
        // </table>
        // </div>';


        // $message .= '<div style="height:100%;width:100%;">Please acknowledge the new shift by clicking';
        // $message.=' <a href="'.$_SERVER['HTTP_HOST'].'/portal/job_roster">here</a>';
        // $message.='.</div>';
        // $message .= '<img src="'.$logo3.'" style="width:33%;float:left;padding-top:2.5rem;"/>';



        // Sending email
    try {
        // Mail::send([], [], function ($message) use ($user, $subject, $emailContent, $fromEmail, $fromName) {
        //     $message->to($user->email)
        //         ->from($fromEmail, $fromName)
        //         ->subject($subject)
        //         ->setBody($emailContent, 'text/html');
        // });
        Mail::to($user->email)->send(new GenericMail($user, $emailContent, $subject));
        // mail($to, $subject, $message, $headers);
        return true;
    } catch (Exception $e) {
        return false;
    }
}
function sendGuardMail_save_guard($user, $subject, $email_message, $token)
{

    // $root = $_SERVER['HTTP_HOST'];
    // $root = explode('.', $root);
    // $postfix = 'staffingsolution';
    // if ($root[0] != 'wwww') {
    //     $postfix = $root[0];
    // } else {
    //     $postfix = $root[1];
    // }
        // $otherdb =DB::connection('otherDB', TRUE);
        // $config_data = $otherdb->get_where('business_data', array('domain' => $postfix), 1, 0)->row_array();
    $config_title = config('custom.title');

    $to = $user->email;

    $subject = $subject;

        // $from = 'no-reply@'.$_SERVER['HTTP_HOST'];
    // $from = $postfix . '@247staffingsolution.com.au';
    $fromEmail = 'no-reply@vcpgsystem.com.au';
    $fromName = 'VCPG Security';

        //   $logo1 = config('custom.logo');
    $logo1 = '' . config('custom.logo') . '';

        //   $logo2 = base_url("files/email-template/ASIAL-Member-Logo-11.png");

        //   $logo3 = base_url("files/email-template/labour-hire-authority-post-banner-1.jpg");



        // To send HTML mail, the Content-type header must be set

    // $headers  = 'MIME-Version: 1.0' . "\r\n";

    // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



    //     // Create email headers

    // $headers .= 'From: ' . $from . "\r\n" .

    // 'Reply-To: ' . $from . "\r\n" .

    // 'X-Mailer: PHP/' . phpversion();



        // Compose a simple HTML email message

    $emailContent = 'Hello ' . $user->name . ',<br><br>';

    $emailContent .= $email_message . '<br><br>';

        //   $message .= '<span style="color:blue;">Kind Regards,</span><br><br>';

        //   $message .= '<span style="color:blue;">Admin<span><br><br>';

        //   $message .= '<span style="font-size:large;font-weight:bold;color:black;">'.$config_title.' Pty Ltd<span><br>';

        //   $message .= '<span style="font-size:small;font-weight:bold;">A: '.$config_data['address'].'<span><br>';

        // $message .= '<span style="font-weight:bold;">W: <a href="https://www.citywatchsecurity.com.au/">https://www.citywatchsecurity.com.au/</a><span><br><br><br>';

        //   $message .= '<img src="'.$logo1.'" style="width:50%;height:150px;float:left;"/></br>';
        //   

    $token = $token;
    $emailContent .= ' <div style="padding-bottom: 30px">Please verify your account by clicking <a href="' . $_SERVER['HTTP_HOST'] . '/portal/guard_activation/' . $token . '" rel="noopener" target="_blank" style="text-decoration:none;color: #00B2FF">here</a>.
    <br>
    <p style="text-align:center" >OR</p>
    <p>if you have problem clicking this button you can copy below link</p>
    <br>
    <p style="color:blue">' . $_SERVER['HTTP_HOST'] . '/portal/guard_activation/' . $token . '</p>
    </div>';
    $emailContent .= '<div style="padding-bottom: 10px">Kind regards,
    <br> ' . $config_title . ' Team.
    </div></div></td></tr><tr>
    <td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
    <p>' . config('custom.address') . '</p>
    <p>Copyright ©
    <a  rel="noopener" target="_blank">' . $config_title . '</a>.</p> 
    </td>
    </tr></tbody>
    </table>
    </div>';


        // $message .= '<div style="height:100%;width:100%;">Please acknowledge the new shift by clicking';
        // $message.=' <a href="'.$_SERVER['HTTP_HOST'].'/portal/job_roster">here</a>';
        // $message.='.</div>';
        // $message .= '<img src="'.$logo3.'" style="width:33%;float:left;padding-top:2.5rem;"/>';



        // Sending email
    try {
        // mail($to, $subject, $message, $headers);
        // Mail::send([], [], function ($message) use ($user, $subject, $emailContent, $fromEmail, $fromName) {
        //     $message->to($user->email)
        //         ->from($fromEmail, $fromName)
        //         ->subject($subject)
        //         ->setBody($emailContent, 'text/html');
        // });
        Mail::to($user->email)->send(new GenericMail($user, $emailContent, $subject));
        return true;
    } catch (Exception $e) {
        return false;
    }
}

public function send_guard_approval_mail($user, $subject, $email_message)
{
    // $root = $_SERVER['HTTP_HOST'];
    // $root = explode('.', $root);
    // $postfix = 'staffingsolution';
    // if ($root[0] != 'wwww') {
    //     $postfix = $root[0];
    // } else {
    //     $postfix = $root[1];
    // }

    $config_title = config('custom.title');

    $to = $user->email;

    $subject = $subject;

        // $from = 'no-reply@'.$_SERVER['HTTP_HOST'];
    // $from = $postfix . '@247staffingsolution.com.au';
    $fromEmail = 'no-reply@vcpgsystem.com.au';
    $fromName = 'VCPG Security';
        //   $logo1 = config('custom.logo');
    $logo1 = '' . config('custom.logo') . '';


        // To send HTML mail, the Content-type header must be set

    // $headers  = 'MIME-Version: 1.0' . "\r\n";

    // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



    //     // Create email headers

    // $headers .= 'From: ' . $from . "\r\n" .

    // 'Reply-To: ' . $from . "\r\n" .

    // 'X-Mailer: PHP/' . phpversion();



        // Compose a simple HTML email message


    $emailContent = $email_message . '<br><br>';
    $emailContent .= 'Hello ' . $user->name . ',your account is approved succesfully .<br><br>';

    if (config('custom.business_type') == "demo") {
        $emailContent .= ' <div style="padding-bottom: 30px">Please acknowledge the unique id : <a type="button" style="text-decoration:none;color: #00B2FF">' . config('custom.unique_id') . '</a>.</div>';
    }
    $emailContent .= '<div style="padding-bottom: 10px">Kind regards,
    <br> ' . $config_title . ' Team.
    </div></div></td></tr><tr>
    <td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
    <p>' . config('custom.address') . '</p>
    <p>Copyright ©
    <a href="" rel="noopener" target="_blank">' . $config_title . '</a>.</p>
    </td></tr></tbody>
    </table>
    </div>';


        // $message .= '<div style="height:100%;width:100%;">Please acknowledge the new shift by clicking';
        // $message.=' <a href="'.$_SERVER['HTTP_HOST'].'/portal/job_roster">here</a>';
        // $message.='.</div>';
        // $message .= '<img src="'.$logo3.'" style="width:33%;float:left;padding-top:2.5rem;"/>';



        // Sending email

    try {
        // Mail::send([], [], function ($message) use ($user, $subject, $emailContent, $fromEmail, $fromName) {
        //     $message->to($user->email)
        //         ->from($fromEmail, $fromName)
        //         ->subject($subject)
        //         ->setBody($emailContent, 'text/html');
        // });
        Mail::to($user->email)->send(new GenericMail($user, $emailContent, $subject));
        // mail($to, $subject, $message, $headers);
    } catch (Exception $e) {
    }
}
public function guard_activation($token)
{
    $res = DB::table('guards')->where('auth_token', $token)->first();
        //   return $res;
        //   exit();
    if (!empty($res) && $res != 'null' && $res != '' && $res != null) {
        $apikey = base64_encode(Str::random(64) . time());
        $result = DB::table('guards')->where('auth_token', $token)->update(['is_approved' => 'yes', 'auth_token' => $apikey]);
            //    return "your account activated succesfully";
        return view('welcome_guard');
    } else {
        return view('fail_guard');
            // return view('guard/guard_login');
    }
}
function send_delete_shift_mail($user, $subject, $email_message)
{
    // $root = $_SERVER['HTTP_HOST'];
    // $root = explode('.', $root);
    // $postfix = 'staffingsolution';
    // if ($root[0] != 'wwww') {
    //     $postfix = $root[0];
    // } else {
    //     $postfix = $root[1];
    // }
        // $otherdb =DB::connection('otherDB', TRUE);
        // $config_data = $otherdb->get_where('business_data', array('domain' => $postfix), 1, 0)->row_array();
    $config_title = config('custom.title');

    $to = $user->email;

    $subject = $subject;
    $fromName = 'VCPG Security';
        // $from = 'no-reply@'.$_SERVER['HTTP_HOST'];
    $fromEmail = 'no-reply@vcpgsystem.com.au';
        //   $logo1 = config('custom.logo');
    $logo1 = config('custom.logo');

        //   $logo2 = base_url("files/email-template/ASIAL-Member-Logo-11.png");

        //   $logo3 = base_url("files/email-template/labour-hire-authority-post-banner-1.jpg");



        // To send HTML mail, the Content-type header must be set

    // $headers  = 'MIME-Version: 1.0' . "\r\n";

    // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



    //     // Create email headers

    // $headers .= 'From: ' . $from . "\r\n" .

    // 'Reply-To: ' . $from . "\r\n" .

    // 'X-Mailer: PHP/' . phpversion();



        // Compose a simple HTML email message

    $emailContent = 'Hello ' . $user->name . ',<br><br>';

    $emailContent .= $email_message . '<br><br>';

        //   $message .= '<span style="color:blue;">Kind Regards,</span><br><br>';

        //   $message .= '<span style="color:blue;">Admin<span><br><br>';

        //   $message .= '<span style="font-size:large;font-weight:bold;color:black;">'.$config_title.' Pty Ltd<span><br>';

        //   $message .= '<span style="font-size:small;font-weight:bold;">A: '.$config_data['address'].'<span><br>';

        // $message .= '<span style="font-weight:bold;">W: <a href="https://www.citywatchsecurity.com.au/">https://www.citywatchsecurity.com.au/</a><span><br><br><br>';

        //   $message .= '<img src="'.$logo1.'" style="width:50%;height:150px;float:left;"/></br>';
        //   

        // $token=$token;
        // $message.=' <div style="padding-bottom: 30px">Please verify your account by clicking <a href="'.$_SERVER['HTTP_HOST'].'/portal/guard_activation/'.$token.'   " rel="noopener" target="_blank" style="text-decoration:none;color: #00B2FF">here</a>.</div>';
    $emailContent .= '<div style="padding-bottom: 10px;">Kind regards,
    <br> ' . $config_title . ' Team.
    </div>';
        // </div></td></tr><tr>
        // <td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
        // <p>' . config('custom.address') . '</p>
        // <p>Copyright ©
        // <a href="" rel="noopener" target="_blank">' . $config_title . '</a>.</p>
        // </td></tr></tbody>
        // </table>
        // </div>';


        // $message .= '<div style="height:100%;width:100%;">Please acknowledge the new shift by clicking';
        // $message.=' <a href="'.$_SERVER['HTTP_HOST'].'/portal/job_roster">here</a>';
        // $message.='.</div>';
        // $message .= '<img src="'.$logo3.'" style="width:33%;float:left;padding-top:2.5rem;"/>';



        // Sending email
    try {
        // Mail::send([], [], function ($message) use ($user, $subject, $emailContent, $fromEmail, $fromName) {
        //     $message->to($user->email)
        //         ->from($fromEmail, $fromName)
        //         ->subject($subject)
        //         ->setBody($emailContent, 'text/html');
        // });
        Mail::to($user->email)->send(new GenericMail($user, $emailContent, $subject));
        // mail($to, $subject, $message, $headers);
    } catch (Exception $e) {
    }
}

function count_today_working_hours($start, $end, $guard_id)
{
    $today_start = strtotime(date('Y-m-d 00:00:00', strtotime($start)));
    $today_end = strtotime(date('Y-m-d 23:59:59', strtotime($start)));
    if (strtotime($end) > $today_end) {
        $current_shift_today_duration = ($today_end - strtotime($start)) / (60 * 60);
    } else {
        $current_shift_today_duration = (strtotime($end) - strtotime($start)) / (60 * 60);
    }
    $today_working_hours = 0;
    $jobs_today = job_new_roster::where('temp_start', '<', Date('Y-m-d H:i', $today_start))
    ->where('temp_end', '>', Date('Y-m-d H:i', $today_start))
    ->where('guard_id', '=', $guard_id);
    $jobs_today = $jobs_today->get();

    $jobs_today2 = job_new_roster::where('temp_start', '>=', Date('Y-m-d H:i', $today_start))
    ->where('temp_end', '<=', Date('Y-m-d H:i', $today_end))
    ->where('guard_id', '=', $guard_id);
    $jobs_today2 = $jobs_today2->get();


    $jobs_today1 = job_new_roster::where('temp_start', '<', Date('Y-m-d H:i', $today_end))
    ->where('temp_end', '>', Date('Y-m-d', $today_end))
    ->where('guard_id', '=', $guard_id);
    $jobs_today1 = $jobs_today1->get();


        // $jobs_today = $jobs_today->merge($jobs_today1);
        // $jobs_today = $jobs_today->merge($jobs_today2);

    foreach ($jobs_today as $jt) {
        if ($jt->job_end == '') {
            $jt->job_end = time();
        }
        if ($jt->job_start < $today_start) {
            $jt->job_start = $today_start;
        }
        if ($jt->job_end > $today_end) {
            $jt->job_end = $today_end;
        }
        $today_working_hours += (($jt->job_end - $jt->job_start) / (60 * 60));
    }
    foreach ($jobs_today2 as $jt2) {
        if ($jt2->job_end == '') {
            $jt2->job_end = time();
        }
        if ($jt2->job_start < $today_start) {
            $jt2->job_start = $today_start;
        }
        if ($jt2->job_end > $today_end) {
            $jt2->job_end = $today_end;
        }
        $today_working_hours += (($jt2->job_end - $jt2->job_start) / (60 * 60));
    }
    foreach ($jobs_today1 as $jt1) {
        if ($jt1->job_end == '') {
            $jt1->job_end = time();
        }
        if ($jt1->job_start < $today_start) {
            $jt1->job_start = $today_start;
        }
        if ($jt1->job_end > $today_end) {
            $jt1->job_end = $today_end;
        }
        $today_working_hours += (($jt1->job_end - $jt1->job_start) / (60 * 60));
    }
    return round($today_working_hours + $current_shift_today_duration);
}
public function getAavailableGuardsApi(Request $request)
{
    return $this->getAavailableGuards($request, 'api');
}
public function getAavailableGuards(Request $request, $call_from = null)
{
    $prev_shift = [];
    $next_shift = [];
    $guards = '';
    $customer = job::where('id', $request->siteId)->select('customer_id', 'trained')->first();
    $customerId = $customer->customer_id;
        // foreach ($request->customerId as $key => $customerId) {
    $customerId = '"' . $customerId . '"';
    if ($customer->trained == 'yes') {
        $guards = DB::table('guards')
        ->join('guard_sites_trained', 'guard_sites_trained.guard_id', '=', 'guards.id')
        ->where('guard_sites_trained.site_id', $request->siteId)
        ->where('guards.status', 'active')
        ->where('guards.is_approved', 'yes')
        ->where('guards.admin_approved', 1)
        ->where('guards.address', '!=', '')
        ->where('guards.phone', '!=', '')
        ->where('guards.name', '!=', '')
        ->where('guards.name', '!=', null)
        ->where('guards.email', '!=', '')
        ->where('guards.email', '!=', null)
            // ->where('emergency_contact_phone','!=','')
        ->where('guards.security_license_number', '!=', '')
        ->where('guards.security_license_file', '!=', '')
            // ->where('payroll_bank_account_number','!=','')
            // ->where('payroll_bank_name','!=','')
        ->where('guards.specific_customers_id', 'LIKE', '%' . $customerId . '%')
        ->select('guards.id', 'guards.name', 'guards.profile_image', 'guards.state', 'guards.phone')->orderBy('name', 'ASC')
        ->get();
    }else{
        $guards = DB::table('guards')
        ->where('status', 'active')
        ->where('is_approved', 'yes')
        ->where('admin_approved', 1)
        ->where('address', '!=', '')
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
        ->where('specific_customers_id', 'LIKE', '%' . $customerId . '%')
        ->select('guards.id', 'guards.name', 'guards.profile_image', 'guards.state', 'guards.phone')->orderBy('name', 'ASC')
        ->get();
    }

    $available_gaurds = array();
    foreach ($guards as $guard) {
            // if ($guard->id > 0 && $guard->state != '') {
            //         config(['app.timezone' => $this->timezone[$guard->state]]);
            //         date_default_timezone_set($this->timezone[$guard->state]);
            //     }else{
            //         config(['app.timezone' => $this->timezone['Victoria']]);
            //         date_default_timezone_set($this->timezone['Victoria']);
            //     }
        $max_hours = $this->count_today_working_hours($request->start, $request->end, $guard->id);
        $guard->working_hours = $max_hours;
            // $max_hours = 0;
        $already = DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start', '<=', $request->start)->where('temp_end', '>=', $request->start)->first();
        if (empty($already)) {
            $already = DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start', '<=', $request->end)->where('temp_end', '>=', $request->end)->first();
        }
        if (empty($already)) {
            $already = DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start', '>=', $request->start)->where('temp_end', '<=', $request->end)->first();
        }
        if (empty($already)) {
            $already = DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start', '>=', $request->start)->where('temp_start', '<=', $request->end)->first();
        }


        if (empty($already)) {
            $is_available = true;
                // $validate = $this->checkGuardLastShift($guard->id, $request->start, $request->end);
                //     if (!$validate['status']) {
                //     $is_available = false;
                //     }

            $prev_shift_res =  DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_end', '<', $request->start)->orderBy('temp_start', 'desc')->first();
            if (!empty($prev_shift_res)) {

                $site = DB::table('jobs')->where('id', $prev_shift_res->site_id)->first();
                $site_name = !empty($site) ? $site->address : 'N/A';
                    // $prev_shift='';
                $prev_shift = [
                    'guard_id' => $prev_shift_res->guard_id,
                    'temp_date' => Date("d-m-Y", strtotime($prev_shift_res->temp_date)),
                    'start' => Date("H:i", strtotime($prev_shift_res->temp_start)),
                    'end' => Date("H:i", strtotime($prev_shift_res->temp_end)),
                    'site' => $site_name,
                    'job_time_end' => ($prev_shift_res->job_end != '' && $prev_shift_res->job_end != null && $prev_shift_res->job_end > 0) ? date('Y-m-d H:i', $prev_shift_res->job_end) : date("Y-m-d H:i", strtotime($prev_shift_res->temp_end))
                ];
                    // $hours = $this->getTimeDiff(date('Y-m-d H:i', $prev_shift_res->job_end), $request->start);
                    // $hours = $this->getTimeDiff(date('m/d/Y H:i', strtotime($prev_shift_res->temp_end)), date('m/d/Y H:i', strtotime($request->start)));
                if ($prev_shift_res->job_end != '' && $prev_shift_res->job_end != null && $prev_shift_res->job_end > 0) {
                    $seconds = strtotime($request->start) - $prev_shift_res->job_end;
                } else {
                    $seconds = strtotime($request->start) - strtotime($prev_shift_res->temp_end);
                }
                $hours = $seconds / (60 * 60);
                $guard->previous_shift_diff = $hours;

                if ($hours < 8 && $max_hours > 12) {
                    $is_available = false;
                }
            } else {
                $prev_shift = [];
            }

            $next_shift_res =  DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start', '>', $request->end)->orderBy('temp_start', 'asc')->first();
            if (!empty($next_shift_res)) {

                $site = DB::table('jobs')->where('id', $next_shift_res->site_id)->first();
                $site_name = !empty($site) ? $site->address : 'N/A';
                $next_shift = [
                    'guard_id' => $next_shift_res->guard_id,
                    'temp_date' => Date("d-m-Y", strtotime($next_shift_res->temp_date)),
                    'start' => Date("H:i", strtotime($next_shift_res->temp_start)),
                    'end' => Date("H:i", strtotime($next_shift_res->temp_end)),
                    'site' => $site_name,
                ];
                    // $hours = $this->getTimeDiff(date('m/d/Y H:i', strtotime($request->end)), date('m/d/Y H:i', strtotime($next_shift_res->temp_start)));
                $seconds = $next_shift_res->job_start - strtotime($request->end);
                $hours = $seconds / (60 * 60);
                $guard->next_shift_diff = $hours;

                if ($hours < 8 && $max_hours > 12) {
                    $is_available = false;
                }
                    //   $validate = $this->checkGuardLastShift($next_shift_res->guard_id, $next_shift_res->temp_start, $next_shift_res->temp_end, $next_shift_res->event_id);
                    // if (!$validate['status']) {
                    // $is_available = false;
                    // }
            } else {
                $next_shift = [];
            }
            $guard->next_shift = $next_shift;
            $guard->prev_shift = $prev_shift;
            if ($is_available) {
                $available_gaurds[] = $guard;
            }
        }
    }
        // }
    $next_shift = '';
    $prev_shift = '';
        // if ($request->has('return') && $request->return == 'html') 
        // {

        // }else{
    if ($call_from == 'api') {
        if (count($available_gaurds) > 0) {
            return response()->json(['success' => true, 'siteId' => $request->siteId, 'guards' => $available_gaurds, 'prev_shift' => $prev_shift, 'next_shift' => $next_shift]);
        } else {
            return response()->json(['success' => false, 'siteId' => $request->siteId, 'guards' => $available_gaurds, 'prev_shift' => $prev_shift, 'next_shift' => $next_shift]);
        }
    } else {

        return response()->json(['siteId' => $request->siteId, 'guards' => $available_gaurds, 'prev_shift' => $prev_shift, 'next_shift' => $next_shift]);
    }
        // }
}

public function resend_guard_email(Request $request)
{
    $guard = DB::table('guards')->where('id', $request->id)->first();
        // return $guard;
        //  exit();

    $message2 = '<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
    <br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
    <tbody><tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="' . config('custom.logo') . '" rel="noopener" target="_blank"><img src="https://vcpgsystem.com.au/asset_uploads/vcpg.png" style="height: 45px" alt="logo"></a></td></tr><tr>
    <td align="left" valign="center">
    <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px"><!--begin:Email content--><div style="padding-bottom: 30px; font-size: 17px;"><strong>Verify Your Email</strong></div>';
        // if ($guard->auth_token != '') {
            // $apikey = $guard->auth_token;
        // } else {
    $apikey = base64_encode(Str::random(64) . time());
    DB::table('guards')->where('id', $guard->id)->update(['auth_token' => $apikey]);
        // }
    $subject = 'Please verify your email address!';

    $rsp = $this->sendGuardMail_save_guard($guard, $subject, $message2, $apikey);
    if ($rsp) {
        return response()->json(['success' => true, 'message' => 'Email Send Successfully']);
    }else{
        return response()->json(['success' => false, 'message' => 'Fail to send email!']);
    }
}

public function checkGuardLeave(Request $request)
{
    $guard_data = DB::table('guards')->where('id', $request->guard_id)->select('annual_leave_hours', 'sick_leave_hours')->first();
    $total_hours = DB::table('job_new_roster')->where('guard_id', $request->guard_id)->where('roster_id', $request->roster_id)->sum('hours');
    $roster_this_year_hours = DB::table('job_new_roster')->where('guard_id', $request->guard_id)->where('temp_date', '>=', date('Y') . '-01-01')->where('temp_date', '<=', date('Y') . '-12-31')->where('job_status', 'completed')->sum('hours');
    $this_year_leave_hours = DB::table('guard_annual_leaves')->where('guard_id', $request->guard_id)->where('created_at', '>=', date('Y') . '-01-01')->where('created_at', '<=', date('Y') . '-12-31')->sum('hours');
    if ($request->leave_option == 'annual') {
        $leave_hour = $roster_this_year_hours * 0.076;
        $leave_hour = $leave_hour + $guard_data->annual_leave_hours;
    } else {
        $leave_hour = $roster_this_year_hours * 0.038;
        $leave_hour = $leave_hour + $guard_data->sick_leave_hours;
    }

    $leave_hour = $leave_hour - $this_year_leave_hours;
    if ($leave_hour > $total_hours) {
        $paid_hour = 0;
        $nonpaid_hour = 0;
        if ($roster->hours > 7.5) {
            $paid_hour = 7.5;
            $nonpaid_hour = $roster->hours - 7.5;
        } else {
            $paid_hour = $roster->hours;
        }
        $roster = DB::table('job_new_roster')->where('guard_id', $request->guard_id)->where('roster_id', $request->roster_id)->first();
        $guard = DB::table('guards')->where('id', $request->guard_id)->first();
        DB::table('guard_annual_leaves')->insert([
            'roster_id' => $request->roster_id,
            'guard_id' => $request->guard_id,
            'start_time' => $roster->job_start,
            'end_time' => $roster->job_end,
            'hours' => $roster->hours,
            'type' => $request->leave_option,
            'paid_hour' => $paid_hour,
            'paid_hour' => $nonpaid_hour
        ]);
        DB::table('roster_complete_activity')->insert([
            'roster_id' => $request->roster_id,
            'activity' => $guard->name . ' is on its ' . $request->leave_option . ' leave.',
            'type' => 'annual_leave',
            'record_id' => $request->roster_id,
            'activity_time' => time(),
            'activity_by' => $request->guard_id
        ]);
        DB::table('job_new_roster')->where('guard_id', $request->guard_id)->where('roster_id', $request->roster_id)->update(['guard_id' => 0, 'job_status' => 'pending']);
        DB::table('guard_leave_requests')->insert([
            'guard_id' => $request->guard_id,
            'start' => strtotime(date('m/d/Y', $roster->job_start) . ' 00:00'),
            'end' => strtotime(date('m/d/Y', $roster->job_start) . ' 23:59'),
            'start_date' => date('d/m/Y', $roster->job_start) . ' 00:00',
            'end_date' => date('d/m/Y', $roster->job_start) . ' 23:59',
            'notes' => $request->leave_option,
            'date_added' => time(),
            'status' => 'approved'
        ]);
        return response()->json(['success' => true, 'message' => 'Guard successfully go on leave.']);
    } else {
        return response()->json(['success' => false, 'message' => 'This guard don\'t have enough leave.']);
    }
        // 0.076/hour annual leave addition
}
public function activeGuardLeaveManagement()
{
    $config_recods = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id', config('custom.domain_id'))->where('type', 'guards_navigation_bar')->first();
    $value = !empty($config_recods) ? json_decode($config_recods->records_business_navbar) : array();
    if (isset($value->casual_guards) && $value->casual_guards== 1) {
        $guards = guard::where(['is_approved' => 'yes', 'status' => 'active'])->where('position', '!=', 'casual')->select('id', 'name', 'email', 'phone', 'annual_leave_hours', 'sick_leave_hours')->orderBy('name', 'ASC')->get();
            // exit();
    }else{
        $guards = guard::where(['is_approved' => 'yes', 'status' => 'active'])->select('id', 'name', 'email', 'phone', 'annual_leave_hours', 'sick_leave_hours')->orderBy('name', 'ASC')->get();
    }
    $guards_data = array();
    foreach ($guards as $guard) {
        $roster_this_year_hours = DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_date', '>=', date('Y') . '-01-01')->where('temp_date', '<=', date('Y') . '-12-31')->where('job_status', 'completed')->sum('hours');
        $this_year_leave_hours_annual = DB::table('guard_annual_leaves')->where('guard_id', $guard->id)->where('created_at', '>=', date('Y') . '-01-01')->where('created_at', '<=', date('Y') . '-12-31')->where('type', 'annual')->sum('hours');
        $this_year_leave_hours_sick = DB::table('guard_annual_leaves')->where('guard_id', $guard->id)->where('created_at', '>=', date('Y') . '-01-01')->where('type', 'sick')->where('created_at', '<=', date('Y') . '-12-31')->sum('hours');
        $leave_request = DB::table('guard_leave_requests')->where('guard_id', $guard->id)->where('status', 'pending')->count();
        $guard->hours_worked = $roster_this_year_hours;
        $guard->annual_hours = $roster_this_year_hours * 0.076 + $guard->annual_leave_hours;
        $guard->sick_leave_hours = $roster_this_year_hours * 0.038;
        $guard->leave_hours_annual = $this_year_leave_hours_annual;
        $guard->leave_hours_sick = $this_year_leave_hours_sick + $guard->sick_leave_hours;
        $guard->leave_request = $leave_request;
        $guards_data[] = $guard;
    }
    return view('admin/guard/leaveManagement', ['guards' => $guards_data]);
}
function guardLicenseFind()
{
    if (!session()->has('userType') || session::get('userType') != 'admin') {
        return view('admin/login');
    }else{
        $guard = DB::table('guards')->where('status', 'active')->get();
        return view('admin/guard/guardLicenseFind', ['guard' => $guard]);
    }
}

function guardLicenseSearch(Request $request)
{
        // dd($request->all());
        // $guard = Guard::with('guard_files');
        // // dd($guard);
        // foreach($guard as $val){
        //     dd($val);
        // }
    $guard = DB::table('guards')->where('status', 'active');
    if (isset($request['vaccination'])) {
        $guard->where('guards.vaccination_certificate', '!=', null)->where('guards.vaccination_certificate', '!=', '');
    }
    if (isset($request['visa'])) {
        $guard->whereNotNull('guards.visa_number')->where('guards.visa_number', '!=', '');
    }
        //  if(isset($request['working_children'])) {
        //      $guard->whereNotNull('guard_files.file_path')->where('guard_files.file_path' ,'!=' ,'');
        //  }
    if (isset($request['passport'])) {
        $guard->whereNotNull('guards.passport_number')->where('guards.passport_number', '!=', '');
    }
    if (isset($request['citizenship'])) {
        $guard->whereNotNull('guards.citizenship_file')->where('guards.citizenship_file', '!=', '');
    }
    if (isset($request['driver_license'])) {
        $guard->whereNotNull('guards.driver_license_number')->where('guards.driver_license_number', '!=', '');
    }
    if (isset($request['firstaid'])) {
        $guard->whereNotNull('guards.firstaid_license_file')->where('guards.firstaid_license_file', '!=', '');
    }
    if (isset($request['medicare'])) {
        $guard->whereNotNull('guards.medicare_file')->where('guards.medicare_file', '!=', '');
    }
    if (isset($request['security_license'])) {
        $guard->whereNotNull('guards.security_license_file')->where('guards.security_license_file', '!=', '');
    }
    if (isset($request['birth_certificate'])) {
        $guard->whereNotNull('guards.birthcertificate_file')->where('guards.birthcertificate_file', '!=', '');
    }
    $guard_files = DB::table('guard_files')
    ->Join('guards', 'guard_files.guard_id', '=', 'guards.id')
    ->where('guards.status', 'active')
    ->whereNotNull('file_path')->where('file_path', '!=', '')->get();
    $data = $guard->get();
        //  dd($data);

    $vaccination = $request['vaccination'] ? $request['vaccination'] : 'off';
    $visa = $request['visa'] ? $request['visa'] : 'off';
    $induction = $request['induction'] ? $request['induction'] : 'off';
    $police_check = $request['police_check'] ? $request['police_check'] : 'off';
    $working_children = $request['working_children'] ? $request['working_children'] : 'off';
    $passport = $request['passport'] ? $request['passport'] : 'off';
    $citizenship = $request['citizenship'] ? $request['citizenship'] : 'off';
    $driver_license = $request['driver_license'] ? $request['driver_license'] : 'off';
    $firstaid = $request['firstaid'] ? $request['firstaid'] : 'off';
    $medicare = $request['medicare'] ? $request['medicare'] : 'off';
    $security_license = $request['security_license'] ? $request['security_license'] : 'off';
    $birth_certificate = $request['birth_certificate'] ? $request['birth_certificate'] : 'off';

    $view = view('admin.guard.guar_drender', [
        'guard' => $data,
        'vaccination' => $vaccination,
        'visa' => $visa,
        'induction' => $induction,
        'police_check' => $police_check,
        'working_children' => $working_children,
        'passport' => $passport,
        'citizenship' => $citizenship,
        'driver_license' => $driver_license,
        'firstaid' => $firstaid,
        'security_license' => $security_license,
        'birth_certificate' => $birth_certificate,
        'medicare' => $medicare,
        'guard_files' => $guard_files,
    ])->render();
    return response()->json($view);
}
function checkUpdtaeCalendarEvent(Request $request)
{
    $customerIds = $request->customerIds;
    $updated_events = DB::table('job_new_roster')
    ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
    ->where('job_new_roster.update_status', 1)
    ->where(function ($query) use ($customerIds) {
        $i = 0;
        foreach ($customerIds as $key => $customerId) {
            if ($i = 0) {
                $query->where('jobs.customer_id', $customerId);
            } else {
                $query->orWhere('jobs.customer_id', $customerId);
            }
            $i++;
        }
    })
    ->first();
    DB::table('job_new_roster')
    ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
    ->where('job_new_roster.update_status', 1)
    ->where(function ($query) use ($customerIds) {
        $i = 0;
        foreach ($customerIds as $key => $customerId) {
            if ($i = 0) {
                $query->where('jobs.customer_id', $customerId);
            } else {
                $query->orWhere('jobs.customer_id', $customerId);
            }
            $i++;
        }
    })
    ->update(['update_status' => 0]);
    if (!empty($updated_events)) {
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false]);
    }
}


public function guard_avability_weak(Request $request)
{
    $guard = DB::table('guards')->where('id', $request->guard_id)->select('guard_availability')->first();
        // $guard->guard_availability = json_decode($guard->guard_availability, true);
    return response()->json(['guard' => $guard]);
        // $guard;
}

public function update_guard_avability_weak(Request $request)
{
    $monday = array(
        0 => 0,
        1 => '',
        2 => ''
    );
    $tuesday = array(
        0 => 0,
        1 => '',
        2 => ''
    );
    $wednesday = array(
        0 => 0,
        1 => '',
        2 => ''
    );
    $thursday = array(
        0 => 0,
        1 => '',
        2 => ''
    );
    $friday = array(
        0 => 0,
        1 => '',
        2 => ''
    );
    $sat = array(
        0 => 0,
        1 => '',
        2 => ''
    );
    $sun = array(
        0 => 0,
        1 => '',
        2 => ''

    );
        //$request->monday!=null && $request->monday!=0  && $request->monday!=false  && 
    if ($request->monday == 'on') {
        $monday[0] = $request->monday_shift;
        $monday[1] = $request->monday_from;
        $monday[2] = $request->monday_to;
    }
        //$request->tuesday!=null && $request->tuesday!=0 && $request->tuesday!=false  && 
    if ($request->tuesday == 'on') {
        $tuesday[0] = $request->tuesday_shift;
        $tuesday[1] = $request->tuesday_from;
        $tuesday[2] = $request->tuesday_to;
    }
        //$request->wednesday!=null && $request->wednesday!=0 && $request->wednesday!=false  && 
    if ($request->wednesday == 'on') {
        $wednesday[0] = $request->wednesday_shift;
        $wednesday[1] = $request->wednesday_from;
        $wednesday[2] = $request->wednesday_to;
    }
        //$request->thursday!=null && $request->thursday!=0 && $request->thursday!=false &&
    if ($request->thursday == 'on') {
        $thursday[0] = $request->thursday_shift;
        $thursday[1] = $request->thursday_from;
        $thursday[2] = $request->thursday_to;
    }
        //$request->friday!=null && $request->friday!=0  && $request->friday!=false &&
    if ($request->friday == 'on') {
        $friday[0] = $request->friday_shift;
        $friday[1] = $request->friday_from;
        $friday[2] = $request->friday_to;
    }
        //$request->sat!=null && $request->sat!=0 && $request->sat!=false &&
    if ($request->sat == 'on') {
        $sat[0] = $request->sat_shift;
        $sat[1] = $request->sat_from;
        $sat[2] = $request->sat_to;
    }
        // $request->sun!=null && $request->sun!=0 && $request->sun!=false && 
    if ($request->sun == 'on') {
        $sun[0] = $request->sun_shift;
        $sun[1] = $request->sun_from;
        $sun[2] = $request->sun_to;
    }

    $week = array([
        'monday' => $monday,
        'tuesday' => $tuesday,
        'wednesday' => $wednesday,
        'thursday' => $thursday,
        'friday' => $friday,
        'sat' => $sat,
        'sun' => $sun,
    ]);
        // return $week;
        // exit();
    $guard = DB::table('guards')->where('id', $request->guard_id)->update([
        'guard_availability' => json_encode($week)
    ]);
    if (!empty($guard)) {
        return response()->json(array('success' => true));
    } else {
        return response()->json(array('success' => true));
    }
}




public function guard_work_limitation(Request $request)
{
    $guard = DB::table('guards')->where('id', $request->guard_id)->select('residential_status', 'fortnightly_working_holiday_letter', 'fortnightly_working_hours', 'work_limitation_status', 'authorized_by')->first();
    if ($guard->authorized_by != '') {
        $name = DB::table('administrators')->where('id', $guard->authorized_by)->select('name')->first();
        $guard->authorized_by = $name->name;
    } else {
        $guard->authorized_by = "N/A";
    }
    return response()->json(['guard' => $guard]);
        // $guard;
}

public function update_guard_work_limitation(Request $request)
{
    $limitation = '';

    if ($request->status == 'on') {
        $limitation = $request->limitation;
        if ($request->fortnightly_working_holiday_letterUploaded != null && $request->fortnightly_working_holiday_letterUploaded != ' ') {
            $guard = DB::table('guards')->where('id', $request->guard_id)->update([
                'fortnightly_working_hours' => $limitation,
                'work_limitation_status' => "active",
                'fortnightly_working_holiday_letter' => $request->fortnightly_working_holiday_letterUploaded,
                'authorized_by' => session()->get('userId')
            ]);
        } else {

            $guard = DB::table('guards')->where('id', $request->guard_id)->update([
                'fortnightly_working_hours' => $limitation,
                'work_limitation_status' => "active",
                'fortnightly_working_holiday_letter' => '',
                'authorized_by' => session()->get('userId')
            ]);
        }
        return response()->json(array('success' => true, 'message' => 'Active Successfully'));
    } else {
        $guard = DB::table('guards')->where('id', $request->guard_id)->update([
            'work_limitation_status' => "inactive",
            'authorized_by' => session()->get('userId')
        ]);
        return response()->json(array('success' => true, 'message' => 'Inactive Successfully'));
    }
}




public function guard_leave_management(Request $request)
{
    $guard = DB::table('guards')->where('id', $request->guard_id)->select('annual_leave_hours', 'sick_leave_hours')->first();
    return response()->json(['guard' => $guard]);
        // $guard;
}

public function update_guard_leave_management(Request $request)
{
    $annual_leave_hours = $request->annual_leave_hours;
    $sick_leave_hours = $request->sick_leave_hours;
    $guard = DB::table('guards')->where('id', $request->guard_id)->update([
        'sick_leave_hours' => $sick_leave_hours,
        'annual_leave_hours' => $annual_leave_hours
    ]);
    return response()->json(array('success' => true, 'message' => 'Save Successfully'));
}

public function get_guard_uniform(Request $request)
{
    $guard = DB::table('guards')->where('id', $request->guard_id)->select('gender', 'uniform_type')->first();
    return response()->json(['guard' => $guard]);
        // $guard;
}

public function update_guard_uniform(Request $request)
{
    $uniform_type = [];
    $uniform_arr = ['dress_shirt', 'slacks', 'security_tag', 'vest', 't_shirt', 'polo', 'scrub', 'jacket', 'tie', 'ascot'];
        // $d='dress_shirt';
        // $t="$d"."_uniform_status";
        // return $request->$t;
        // exit();
    foreach ($uniform_arr as $u) {
        $req = "$u" . "_uniform_status";
        $req_size = "$u" . "_uniform_size";
        $req_quan = "$u" . "_uniform_quantity";
        if ($request->$req == 'on') {
            $$u = array([
                $req => $request->$req,
                $req_size => $request->$req_size,
                $req_quan => $request->$req_quan,
            ]);
            array_push($uniform_type, $$u);
        }
    }
        // return $uniform_type;
        // exit();
    $guard = DB::table('guards')->where('id', $request->guard_id)->update([
        'uniform_type' => $uniform_type
    ]);
    if (!empty($guard)) {
        return response()->json(array('success' => true));
    } else {
        return response()->json(array('success' => true));
    }
}

public function deleteShift(Request $request)
{

    $config_job_roster = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id', config('custom.domain_id'))->where('type', 'job_roster_navigation_bar')->first();
    $business = DB::connection('mysql2')->table('business_data')->where('id', config('custom.domain_id'))->first();
    $config = json_decode($config_job_roster->records_business_navbar, true);
    $send_email = DB::table('portal_settings')->where('permission_name', 'delete_shift')->where('permission', 1)->first();

    $deleted_shift = DB::table('job_new_roster')->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')->where('job_new_roster.roster_id', $request->roster_id)->first();
    if ($request->has('admin_id') && $request->admin_id != '') {

        session([
            'userId' => $request->admin_id,
        ]);
    }

    if ($deleted_shift->signin_status == 1 || $deleted_shift->job_status == 'completed') {
        return response()->json(['success' => false, 'message' => 'You can\'t delete ongoing or completed job!']);
    }
    $action = 'shift_delete';
    $admin_id = 0;
    if ($request->has('admin_id') && $request->admin_id != '') {
        $admin_id = $request->admin_id;
    }
    
    $this->administrator->log_user_activity($action, $deleted_shift, $admin_id);
    $guard_data = DB::table('guards')->join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')->where('job_new_roster.roster_id', $request->roster_id)->where('job_new_roster.publish_status', 1)->select('guards.*')->first();
    if (!empty($guard_data)) {
        $notification_data['guards'][0] = array(
            'guard_id' => $guard_data->id,
            'notification_token' => $guard_data->notification_token
        );
        $notification_data['title'] = 'Shift Delete';
        $notification_data['message'] = 'Shift Remove - One of your shift is removed';
        $notification_data['page'] = 'homepage';
        $res = $this->guard_model->send_push_notification($notification_data);



        $guard = DB::table('guards')->where('id', $guard_data->id)->first();
        $subject = "Shift Delete";
            // exit();
            // $message='You are removed from following shift. </br></br><table align="center" border="1"  width="50%" height="50%"><tr><th><b>Site Name</b></th><th><b>Site Description</b></th><th><b>Date</b></th></tr><tr><td>'.$deleted_shift->site_name.'</td><td>'.$deleted_shift->site_description.'</td><td>'.date("d-m-y", strtotime($deleted_shift->temp_date)).'</td></tr></table></br>'; 
        $message = '<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
        <br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
        <tbody><tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="' . config('custom.logo') . '" rel="noopener" target="_blank"><img src="https://vcpgsystem.com.au/asset_uploads/vcpg.png" style="height: 45px" alt="logo"></a></td></tr><tr>
        <td align="left" valign="center">
        <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px"><!--begin:Email content--><div style="padding-bottom: 30px; font-size: 17px;"><strong>You are removed from following shift.</strong></div>';
        $message .= '<div style="padding-bottom: 30px"><p><table align="center" border="1"  width="100%" height="60%"><tr><th><b>Site Name</b></th><th><b>Site Description</b></th><th><b>Start Time</b></th><th><b>End Time</b></th></tr><tr><td>' . $deleted_shift->site_name . '</td><td>' . $deleted_shift->site_description . '</td><td>' . date("d-m-Y H:i", strtotime($deleted_shift->temp_start)) . '</td><td>' . date("d-m-Y H:i", strtotime($deleted_shift->temp_end)) . '</td></tr></table></br> </p></br></br><p></p></div>
        <div style="padding-bottom: 40px; text-align:center;"></div>';
        if ((isset($config->email) && $config->email == 1) || !empty($send_email)) {
            // $dd = $this->send_delete_shift_mail($guard, $subject, $message);
        }
        $smsMessage = 'Hello ' . $guard->name . ',\n Your shift for ' . date('d/m/Y', strtotime($deleted_shift->temp_start)) . ' at ' . $deleted_shift->site_name . ' from ' . date('H:i', strtotime($deleted_shift->temp_start)) . ' has been deleted or cancelled. Please refer to the ' . $business->title . ' app or call Ops Team for further details.\n Thanks, \n Team ' . $business->title;
            // $smsMessage = 'One of your shift at '. $deleted_shift->site_name.' ('.date('H:i', strtotime($deleted_shift->temp_start)).' - '.date('H:i', strtotime($deleted_shift->temp_end)).') on '.date('d/m/Y', strtotime($deleted_shift->temp_start)).' has been deleted.';
        if (isset($config['sms']) && $config['sms'] == 1) {
            $this->sendSMS($guard->phone, $smsMessage);
        }
    }
    DB::table('job_new_roster')->where('roster_id', $request->roster_id)->delete();
        // $this->sendGuardMail_save_guard($guard,$subject,$message);
    return response()->json(['success' => true]);
        // return $dd;
}

function get_specific_guard_customer(Request $request)
{
    $specific_customers_id = [''];
    $customers_array = [''];
    $customers = DB::table('guards')->where('id', $request->id)->first();
    $specific_customers_id = $customers->specific_customers_id;
    $specific_customers_id_arr = json_decode($specific_customers_id);
        // $specific_customers_id_arr=explode('" "',$specific_customers_id);
        //         return  $specific_customers_id_arr ;
        // exit();
    foreach ($specific_customers_id_arr as $cid) {
        $cust_array = [''];
        $cust = DB::table('customers')->where('id', $cid)->first();
        $cust_name = $cust->name;
        $cust_email = $cust->email;
        $cust_address = $cust->address;
        $cust_phone = $cust->phone;
        $cust_array = [$cust_name, $cust_email, $cust_address, $cust_phone];
        array_push($customers_array, $cust_array);
    }
    unset($customers_array[0]);
    return $customers_array;
}
function check_victoria_license($request)
{
    $url = "https://www.lars.police.vic.gov.au/LARS/LARS.asp?File=/Components/Screens/PSINFP03/PSINFP03.asp?Process=SEARCH";
    $input_xml = "<XML><HEADER><PROCESS>SEARCH</PROCESS><TIMESTAMP>20211020043340</TIMESTAMP><SECURITYTOKEN>02A42A1B-588D-4EE8-8760-2A81E6221A9A</SECURITYTOKEN></HEADER><PAYLOAD><GNDTLE01 id='idSearchPane'><CONTROL name='dropdownlist'>%</CONTROL><CONTROL name='searchtext'></CONTROL><CONTROL name='SearchCriteriadropdownlist'>X</CONTROL><CONTROL name='SearchAuthNb'>" . $request->license_number . "</CONTROL><CONTROL name='Index'></CONTROL><CONTROL name='Page'>1</CONTROL></GNDTLE01></PAYLOAD></XML>";

        // new here
    $headers = array(
        "Content-type: text/xml",
        "Content-length: " . strlen($input_xml),
        "Connection: close",
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $data = curl_exec($ch);
    curl_close($ch);

    if (strpos($data, 'No Results Found')) {
        return response()->json(['success' => false, 'message' => 'Sorry! Your license is not valid according to LRD Victoria Database.']);
    } else {
        $data = explode('ALT="Spacer"/></td></tr><tr valign=\'top\' RecordKey=\'', $data);
        if (isset($data[1])) {
            $data = explode('bgcolor=\'white\' row=\'1\'  onmouseover="PSINFE04_fMouseOver(this);"  onmouseout="PSINFE04_fMouseOut(this);"  ondblclick="fDetails();"  onclick="PSINFE04_fMouseClick(this);">', $data[1]);

            $data = str_replace('</tr><tr style=\'font-size:4px\'><td align=\'right\' bgcolor=\'#BDC3D6\' colspan=\'6\'>&nbsp;</td></tr></table>
                </td></tr><tr style=\'font-size:4px\'><td align=\'right\' bgcolor=\'#BDC3D6\' colspan=\'6\'>&nbsp;</td></tr></table>
                </td></tr><tr style=\'font-size:4px\'><td align=\'right\' bgcolor=\'#BDC3D6\' colspan=\'6\'>&nbsp;</td></tr></table>', '', $data[1]);
            $data = str_replace('</tr></table>', '', $data);
            $data = str_replace('</td>', '', $data);
            $data = str_replace('&nbsp;', '', $data);
            $data = explode('<td>', $data);
            if (isset($data[4])) {
                return response()->json(['success' => true, 'message' => 'Congrats! Your License is valid and verified from the LRD Victoria Database.', 'expiry' => $data[4]]);
            } else {
                return response()->json(['success' => false, 'message' => 'Sorry! Your license is not valid according to LRD Victoria Database.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Sorry! Your license is not valid according to LRD Victoria Database.']);
        }
    }
}
function check_queensland_license($request, $name)
{
    $url = "https://ftlr.fairtrading.qld.gov.au/home/search?LicenceNumber=" . $request->license_number . "&GivenName=&LastName=&CompanyName=&MasterType=";
        // new here
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, true);
    if (count($result) > 0) {
        if ($result[0]['licenceNumber'] == $request->license_number) {
            $expiry = date('d/m/Y', strtotime($result[0]['expiryDateStr']));
            return response()->json(['success' => true, 'message' => 'Congrats! Your License is valid and verified from the LRD Queensland Database.', 'expiry' => $expiry]);
        } else {
            return response()->json(['success' => false, 'message' => 'Sorry! Your license is not valid according to LRD Queensland Database.', 'name' => strtolower($name)]);
        }
    } else {
        return response()->json(['success' => false, 'message' => 'Sorry! Your license is not valid according to LRD Queensland Database.']);
    }
}


function documentsOnlineVerification(Request $request)
{
    if ($request->has('guard_id')) {
        $guard = DB::table('guards')->where('id', $request->guard_id)->select('state', 'name')->first();
        if ($guard->state == 'Queensland') {
            return $this->check_queensland_license($request, $guard->name);
        } else {
            return $this->check_victoria_license($request);
        }
    } else {
        return $this->check_victoria_license($request);
    }
}
public function assignGuardLeave(Request $request)
{
    $guard_data = DB::table('guards')->where('id', $request->guard_id)->select('annual_leave_hours', 'sick_leave_hours')->first();
    $total_hours = DB::table('job_new_roster')->where('guard_id', $request->guard_id)->where('roster_id', $request->roster_id)->sum('hours');
    $roster_this_year_hours = DB::table('job_new_roster')->where('guard_id', $request->guard_id)->where('temp_date', '>=', date('Y') . '-01-01')->where('temp_date', '<=', date('Y') . '-12-31')->where('job_status', 'completed')->sum('hours');
    $this_year_leave_hours = DB::table('guard_annual_leaves')->where('guard_id', $request->guard_id)->where('created_at', '>=', date('Y') . '-01-01')->where('created_at', '<=', date('Y') . '-12-31')->sum('hours');
    if ($request->leave_option == 'annual') {
        $leave_hour = $roster_this_year_hours * 0.076;
        $leave_hour = $leave_hour + $guard_data->annual_leave_hours;
    } else {
        $leave_hour = $roster_this_year_hours * 0.038;
        $leave_hour = $leave_hour + $guard_data->sick_leave_hours;
    }
    $roster = DB::table('job_new_roster')->where('guard_id', $request->guard_id)->where('roster_id', $request->roster_id)->first();

    $leave_hour = $leave_hour - $this_year_leave_hours;
    $paid_hour = 0;
    $nonpaid_hour = 0;
    if ($leave_hour > 0) {
        if ($leave_hour >= $roster->hours) {
            if ($roster->hours > 7.5) {
                $paid_hour = 7.5;
                $nonpaid_hour = $roster->hours - 7.5;
            } else {
                $paid_hour = $roster->hours;
            }
        } else {
            $paid_hour = $leave_hour;
            $nonpaid_hour = $roster->hours - $leave_hour;
        }
    } else {
        $nonpaid_hour = $roster->hours;
    }

    $guard = DB::table('guards')->where('id', $request->guard_id)->first();
    DB::table('guard_annual_leaves')->insert([
        'roster_id' => $request->roster_id,
        'guard_id' => $request->guard_id,
        'start_time' => $roster->job_start,
        'end_time' => $roster->job_end,
        'hours' => $roster->hours,
        'type' => 'basic',
        'paid_hour' => $paid_hour,
        'nonpaid_hour' => $nonpaid_hour,
    ]);
    DB::table('guard_leave_requests')->insert([
        'guard_id' => $request->guard_id,
        'start' => strtotime(date('m/d/Y', $roster->job_start) . ' 00:00'),
        'end' => strtotime(date('m/d/Y', $roster->job_start) . ' 23:59'),
        'start_date' => date('d/m/Y', $roster->job_start) . ' 00:00',
        'end_date' => date('d/m/Y', $roster->job_start) . ' 23:59',
        'notes' => 'basic',
        'date_added' => time(),
        'status' => 'approved'
    ]);
    DB::table('job_new_roster')->where('guard_id', $request->guard_id)->where('roster_id', $request->roster_id)->update(['guard_id' => 0, 'job_status' => 'pending']);

    return response()->json(['success' => true, 'message' => 'Guard successfully go on leave.']);
}

function leaveDetails(Request $request)
{
    $details = $this->guard_model->leaveDetails($request);
    $guard_leave_requests = $this->guard_model->guard_leave_requests($request);
    return response()->json(['success' => true, 'message' => 'Details Found,', 'data' => $details, 'guard_leaves' => $guard_leave_requests]);
}

function convert_asap(Request $request)
{
    $res = DB::table('job_new_roster')->where('roster_id', $request->roster_id)->update([
        'guard_id' => 0,
        'publish_status' => 1,
        'post_status' => 1,
        'convert_asap_status' => 1
    ]);
    return response()->json(['success' => true, 'message' => 'Converted into ASAP Succesfully,']);
}
function changeLeaveStatus(Request $request)
{
    if ($request->action == 'reject') {
        $result = $this->guard_model->changeLeaveStatus($request->leaveId, 'rejected');
    } else {
        $leave_data = DB::table('guard_leave_requests')->where('id', $request->leaveId)->first();
        $result =  $this->guard_model->changeLeaveStatus($request->leaveId, 'approved');
        $hours = $this->getTimeDiff(date('m/d/Y H:i', $leave_data->start), date('m/d/Y H:i', $leave_data->end));
        $total_hours = round($hours['hours']);
            // echo json_encode($total_hours);
            // exit();
        DB::table('guard_annual_leaves')->insert([
            'guard_id' => $leave_data->guard_id,
            'roster_id' => 0,
            'start_time' => $leave_data->start,
            'end_time' => $leave_data->end,
            'hours' => $total_hours,
            'type' => $request->leaveType,
            'paid_hour' => $total_hours,
            'nonpaid_hour' => 0
        ]);
    }

    if ($result) {
        return response()->json(['success' => true, 'message' => 'Leave ' . $request->action . ' successfully.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Fail to  ' . $request->action . ' leave request!']);
    }
}
public function findUniqueID($start, $end)
{
    $id = rand($start, $end);
    $check = guard_payroll_ids::where('payroll_id', $id)->first();
    if (!empty($check)) {
        $id = 0;
    }
    return $id;
}
    // public function guard_payroll_id(Request $request)
    // {
    //          $guard=DB::table('guards')->where('id',$request->guard_id)->first();
    //          $type=$guard->guard_type;
    //         if($guard->guard_type=='contractor' || $guard->guard_type=='Contractor'){
    //            $contractor=DB::table('contractors')->where('id',$guard->contractor_id)->first();
    //             $range=explode("-",$contractor->contractor_id_range); 
    //            $start=(int)$range[0];
    //            $end=(int)$range[1];
    //         }else{
    //             $start = 0;
    //             $end = 10000;
    //         }
    //         // $start = 6000;
    //         // $end = 10000;
    //         // echo $start,$end;
    //         // exit();
    //     do
    //     {
    //         $id = $this->findUniqueID($start, $end);
    //     }while($id < 1);
    //     return response()->json(['success' => true, 'message' => 'ID', 'id' => $id,'type'=>$type]);

    // }


public function generate_payroll_id()
{
    $guards = DB::table('guards')->get();
    foreach ($guards as $guard) {
        $type = $guard->guard_type;
        $id = 0;
        $start = 11000;
        $end = 20000;
            //    if($guard->guard_type=='contractor' || $guard->guard_type=='Contractor'){
            //       $contractor=DB::table('contractors')->where('id',$guard->contractor_id)->first();
            //        $range=explode("-",$contractor->contractor_id_range); 
            //         $start=(int)$range[0];
            //         $end=(int)$range[1];
            //    }else{
            //        $start = 0;
            //        $end = 1000;
            //    }
        $guard->guard_type = 'Contractor';
        do {
            $id = $this->findUniqueID($start, $end);
        } while ($id < 1);

        DB::table('guards')->where('id', $guard->id)->update([
            'guard_type' => 'Contractor',
            'contractor_id' => 1
        ]);
        $check = DB::table('guard_payroll_ids')->where('guard_id', $guard->id)->first();
        if (empty($check)) {
            DB::table('guard_payroll_ids')->insert([
                'guard_id' => $guard->id,
                'payroll_id' => $id,
                'type' => $guard->guard_type
            ]);
        }
    }

    return response()->json(['success' => true, 'message' => 'ID GUARDS DONE']);
}
public function guard_payroll_id($guard_id)
{
    $guard = DB::table('guards')->where('id', $guard_id)->first();

    $type = strtolower($guard->guard_type);
    $id = 0;
    if ($guard->guard_type == 'contractor' || $guard->guard_type == 'Contractor') {
        if ($guard->contractor_id > 0) {
            $contractor = DB::table('contractors')->where('id', $guard->contractor_id)->first();
            $range = explode("-", $contractor->contractor_id_range);
            $start = (int)$range[0];
            $end = (int)$range[1];
        } else {
            $start = 0;
            $end = 10000;
        }
    } else {
        $start = 0;
        $end = 10000;
    }
    do {
        $id = $this->findUniqueID($start, $end);
    } while ($id < 1);

    $check = DB::table('guard_payroll_ids')->where('guard_id', $guard_id)->first();
    if (empty($check)) {
        DB::table('guard_payroll_ids')->insert([
            'guard_id' => $guard_id,
            'payroll_id' => $id,
            'type' => $type
        ]);
    } else {
        DB::table('guard_payroll_ids')->where('guard_id', $guard_id)->update([
            'payroll_id' => $id,
            'type' => $type
        ]);
    }

    return response()->json(['success' => true, 'message' => 'ID', 'id' => $id, 'type' => $type]);
}

public function load_payrates(Request $request)
{
    $query = DB::table('payrates')->where('payrates.archive', 0);
    if ($request->has('site_id') && $request->site_id != '') {
        $query->join('jobs', 'jobs.customer_id', '=', 'payrates.customer_id');
        $query->where('jobs.id', $request->site_id);
    }elseif ($request->has('customer_id') && $request->customer_id != '') {
        $query->where('payrates.customer_id', $request->customer_id);
    }
    if (config('custom.categorized_payrates') == 1) {
        if ($request->payroll_type == 'Default Rates') {
            $query->where('payrate_type', 'default');
        }
        if ($request->payroll_type == 'EBA Rates') {
            $query->where('payrate_type', 'eba');
        }
        if ($request->payroll_type == 'Award Rates') {
            $query->where('payrate_type', 'award');
        }
    }
    $payrates = $query->where('payrates.level', $request->level)->orderBy('payrates.title', 'ASC')->select('payrates.*')->get();
    return $payrates;
}

public function load_chargerates(Request $request)
{
    $query = DB::table('charged_rates')->where('archive', 0);
    if ($request->has('site_id') && $request->site_id != '') {
        $query->join('jobs', 'jobs.customer_id', '=', 'charged_rates.customer_id');
        $query->where('jobs.id', $request->site_id);
            // exit();
    }
    $payrates = $query->where('charged_rates.level', $request->level)->orderBy('charged_rates.title', 'ASC')->select('charged_rates.*')->get();
    return $payrates;
}
public function getSelectedSitesShifts(Request $request)
{
    if ($request->has('guardId')) {
        $roster = job_new_roster::leftJoin('guards', 'guards.id', '=', 'job_new_roster.guard_id')
        ->where('temp_start', '>=', $request->start)
        ->where('temp_start', '<=', $request->end)
        ->where('guard_id', $request->guardId)
        ->select('job_new_roster.*', 'guards.name')
        ->orderBy('temp_start', 'asc')
        ->get();
    } else {
        $roster = job_new_roster::leftJoin('guards', 'guards.id', '=', 'job_new_roster.guard_id')
        ->where('temp_start', '>=', $request->start)
        ->where('temp_start', '<=', $request->end)
        ->where('site_id', $request->siteId)
        ->select('job_new_roster.*', 'guards.name')
        ->orderBy('temp_start', 'asc')
        ->get();
    }
    $data['roster'] = $roster;
    $formHtml = view('admin/modals/selectShiftForm', $data)->render();
    return response()->json($formHtml);
}
public function removeRosterIdsOfSites(Request $request)
{
    if ($request->has('guardId')) {
        $roster = job_new_roster::leftJoin('guards', 'guards.id', '=', 'job_new_roster.guard_id')
        ->where('temp_start', '>=', $request->start)
        ->where('temp_start', '<=', $request->end)
        ->where('guard_id', $request->guardId)
        ->select('job_new_roster.roster_id')
        ->orderBy('temp_start', 'asc')
        ->get();
    } else {
        $roster = job_new_roster::leftJoin('guards', 'guards.id', '=', 'job_new_roster.guard_id')
        ->where('temp_start', '>=', $request->start)
        ->where('temp_start', '<=', $request->end)
        ->where('site_id', $request->siteId)
        ->select('job_new_roster.roster_id')
        ->orderBy('temp_start', 'asc')
        ->get();
    }
    $data['roster'] = $roster;

    return response()->json($data);
}
    // public function guard_rating(){
    //     $guard_id=27;
    //     $rating_sum=DB::table('job_new_roster')->where('guard_id',$guard_id)->sum('job_rating');
    //     $job=DB::table('job_new_roster')->where('guard_id',$guard_id)->count();
    //     $rating=round($rating_sum/$job);
    //     DB::table('guards')->where('id',$guard_id)->update([
    //         'rating'=>$rating
    //     ]);
    //     return $rating;
    // }
    // public function guard_job_rating($roster_id)
    // {
    //   $rating=0;
    //   $job=DB::table('job_new_roster')->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')->join('job_roster_activities', 'job_roster_activities.job_roster_id', '=', 'job_new_roster.roster_id')->where('job_new_roster.roster_id',$roster_id)->first();
    // ///signin
    //   if((strtotime($job->temp_start) >= strtotime($this->gmt_to_date($job->signin_time))) && $job->signin_time!=null ){
    //         $diff=strtotime($job->temp_start) - strtotime($this->gmt_to_date($job->signin_time));

    //         if($diff/60 >=15){
    //                 $rating+=16.6;
    //               }
    //           else{
    //             $rating+=15;
    //           }
    //     }else{
    //       $rating+=0;
    //     }
    // //signout

    // if((strtotime($job->temp_end) <= strtotime($this->gmt_to_date($job->signout_time))) && $job->signout_time!=null ){
    //         $rating+=16.6;
    //   }else{
    //         if($job->signout_time==null || $job->signout_time=='' ){
    //         $rating+=0;
    //         }else{
    //         $rating+=15;
    //         }
    //   }
    // //   green  call 

    //   $green=DB::table('green_call')->where('job_id',$roster_id)->count();
    //         if($green==2){
    //             $rating+=33.2;
    //         }elseif($green==1){
    //             $rating+=16.6;
    //         }else{
    //             $rating+=0;
    //         }
    //         //    welfare call 

    //             $green=DB::table('welfare_call_data')->where('job_roster_id',$roster_id)->count();
    //             if($green==0){
    //                 $rating+=0;
    //             }else{
    //                 $rating+=16.6;
    //             }

    //         //status
    //         $status=DB::table('job_new_roster')->where('roster_id',$roster_id)->first();
    //         if($status->job_status=="completed" ||$status->job_status=="confirmed" ){
    //             $rating+=16.6;
    //         }else{
    //             $rating+=0;
    //         }
    //         DB::table('job_new_roster')->where('roster_id',$roster_id)->update([
    //             'job_rating'=>$rating
    //         ]);
    //         return $rating;
    // }

    // public function gmt_to_date($gmt)
    // {
    //     $result=(object)[];
    //     $result->signin_time=$gmt;
    //     if(strpos($result->signin_time,'GMT')!==false){
    //         $result->signin_time_2= explode(" ",$result->signin_time);
    //          $result->signin_time_2=$result->signin_time_2[3].'-'. date('m',strtotime($result->signin_time_2[1])).'-'.$result->signin_time_2[2].' '.$result->signin_time_2[4];
    //     }
    //     else{
    //                 if(strpos($result->signin_time,'M')!==false||strpos($result->signin_time,'T')!==false||strpos($result->signin_time,'W')!==false||strpos($result->signin_time,'F')!==false ||strpos($result->signin_time,'S')!==false)
    //             {
    //                 $result->signin_time_2= explode(" ",$result->signin_time);
    //                 $result->signin_time_2=$result->signin_time_2[3].'-'. date('m',strtotime($result->signin_time_2[1])).'-'.$result->signin_time_2[2].' '.$result->signin_time_2[4];
    //             }
    //             else{
    //                 $result->signin_time_2=$result->signin_time;
    //             }
    //     }
    //         return $result->signin_time_2;
    // }

public function bypass_job()
{
    $code = mt_rand(100000, 999999);
    $userId = session()->get('userId');
    $userType = session()->get('userType');
    $bypass_id = DB::table('admin_bypass_code')->insertGetId([
        'code' => $code,
        'requested_by' => $userId,
        'user_type' => $userType
    ]);
    // $this->send_by_pass_code_to_admin_by_email($code);
    return response()->json(['success' => true, 'message' => 'Code send to super admin, contact admin for bypass code', 'bypass_id' => $bypass_id]);
}

public function validate_passcode(Request $request)
{
    $bypass = DB::table('authentication_code')
    ->where('authentication_code', $request->code)->first();
    if (!empty($bypass)) {
            // DB::table('admin_bypass_code')->where('id', $request->bypass_id)->update([
            //     'status' => "expired"
            // ]);
        return response()->json(['success' => true, 'message' => 'Your Job Bypassed Succesfully']);
    } else {
        return response()->json(['success' => false, 'message' => 'Invalid Code']);
    }
}

public function send_by_pass_code_to_admin_by_email($code)
{
    // $root = $_SERVER['HTTP_HOST'];
    // $root = explode('.', $root);
    // $postfix = 'staffingsolution';
    // if ($root[0] != 'wwww') {
    //     $postfix = $root[0];
    // } else {
    //     $postfix = $root[1];
    // }
        // $otherdb =DB::connection('otherDB', TRUE);
        // $config_data = $otherdb->get_where('business_data', array('domain' => $postfix), 1, 0)->row_array();
    $subject = "ByPass Code of Job";
    $users = DB::table('administrators')->where('is_super_admin', 1)->get();
    foreach ($users as $key => $user) {
        $config_title = config('custom.title');
        $to = $user->email;
        $subject = $subject;
            // $from = 'no-reply@'.$_SERVER['HTTP_HOST'];
        // $from = $postfix . '@247staffingsolution.com.au';
        $fromEmail = 'no-reply@vcpgsystem.com.au';
        $fromName = 'VCPG Security';
        $logo1 = '' . config('custom.logo') . '';

            // To send HTML mail, the Content-type header must be set

        // $headers  = 'MIME-Version: 1.0' . "\r\n";

        // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



        //     // Create email headers

        // $headers .= 'From: ' . $from . "\r\n" .

        // 'Reply-To: ' . $from . "\r\n" .

        // 'X-Mailer: PHP/' . phpversion();



            // Compose a simple HTML email message

        $emailContent = 'Hello ' . $user->name . ',<br><br>';
        $emailContent .= ' <div style="padding-bottom: 30px"><h3>By Pass Code is ' . $code . '</h3></div>';
        $emailContent .= '<div style="padding-bottom: 10px">Kind regards,
        <br> ' . $config_title . ' Team.
        </div></div></td></tr><tr>
        <td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
        <p>' . config('custom.address') . '</p>
        <p>Copyright ©
        <a href="" rel="noopener" target="_blank">' . $config_title . '</a>.</p>
        </td></tr></tbody>
        </table>
        </div>';


            // $message .= '<img src="'.$logo3.'" style="width:33%;float:left;padding-top:2.5rem;"/>';



            // Sending email
        try {
            // mail($to, $subject, $message, $headers);
            // Mail::send([], [], function ($message) use ($user, $subject, $emailContent, $fromEmail, $fromName) {
            //     $message->to($user->email)
            //         ->from($fromEmail, $fromName)
            //         ->subject($subject)
            //         ->setBody($emailContent, 'text/html');
            // });
        Mail::to($user->email)->send(new GenericMail($user, $emailContent, $subject));
        } catch (Exception $e) {
        }
    }
}

function send_custom_push_notifications()
{
    $guards_ids = '154, 143, 217, 198, 227, 144, 230, 222, 151, 163, 217, 198, 227, 174, 230, 108, 198, 204, 217, 108, 16, 149';
    $title = 'Shift Delete';
    $message = 'One of your shift at Mercy Hospital Werribee (MHU Patient Watch) has been deleted.';
    $guards_ids = explode(',', $guards_ids);
    foreach ($guards_ids as $key => $guard_id) {
        $guard_data = DB::table('guards')->where('id', trim($guard_id))->first();
        $notification_data['guards'][0] = array(
            'guard_id' => $guard_data->id,
            'notification_token' => $guard_data->notification_token
        );
        $notification_data['title'] = $title;
        $notification_data['message'] = $message;
        $notification_data['page'] = 'homepage';
        $res = $this->guard_model->send_push_notification($notification_data);
    }
    return response()->json(['success' => true]);
}
function deleteOtherFile(Request $request)
{
    DB::table('guard_files')->where('id', $request->id)->delete();
    return response()->json(['status' => true]);
}
function getShiftTabDetails(Request $request)
{
    if ($request->tab == 'signin' || $request->tab == 'signout') {
        $roster_activity = DB::table('job_roster_activities')->where('job_roster_id', $request->roster_id)->first();
        if (!empty($roster_activity)) {
            $roster_activity->address = $this->coordinates_to_address($roster_activity->location);
            if ($roster_activity->signin_selfie != '') {
                $roster_activity->signin_selfie = 'https://' . request()->getHttpHost() . '/asset_uploads/' . $roster_activity->signin_selfie;
            }
            if ($roster_activity->signout_selfie != '') {
                $roster_activity->signout_selfie = 'https://' . request()->getHttpHost() . '/asset_uploads/' . $roster_activity->signout_selfie;
            }
            $response = [
                'success' => true,
                'message' => 'success',
                'data' => $roster_activity
            ];
        } else {
            $response = [
                'success' => false,
                'error' => 'No Data found!',
                'data' => $roster_activity
            ];
        }
    } elseif ($request->tab == 'tracker') {
        $guard_location_at_job = DB::table('guard_location_at_job')->where('guard_id', $request->guard_id)->where('roster_id', $request->roster_id)->get();
        $i = 0;
        foreach ($guard_location_at_job as $gl) {
            $guard_location_at_job[$i]->address = $this->coordinates_to_address($gl->coordinates);
            $i++;
        }

        if (count($guard_location_at_job)) {
            $response = [
                'success' => true,
                'message' => 'success',
                'data' => $guard_location_at_job
            ];
        } else {
            $response = [
                'success' => false,
                'error' => 'No Data found!',
                'data' => $guard_location_at_job
            ];
        }
    } elseif ($request->tab == 'incident') {
            // $data['incident_reports'] = DB::table('job_incident_reports')->where('roster_id', $request->roster_id)->where('guard_id', $request->guard_id)->orderBy('id', 'DESC')->get();
        $incident_reports_new = DB::table('incident_reports')->where('roster_id', $request->roster_id)->where('guard_id', $request->guard_id)->orderBy('id', 'DESC')->get();
        if (count($incident_reports_new)) {
            $response = [
                'success' => true,
                'message' => 'success',
                'data' => $incident_reports_new
            ];
        } else {
            $response = [
                'success' => false,
                'error' => 'No Data found!',
                'data' => $incident_reports_new
            ];
        }
    } elseif ($request->tab == 'shift_activity') {
        $activity = $this->rosterActivity($request->roster_id);
        if (count($activity)) {
            $response = [
                'success' => true,
                'message' => 'success',
                'data' => $activity['activity']
            ];
        } else {
            $response = [
                'success' => false,
                'error' => 'No Data found!',
                'data' => $activity['activity']
            ];
        }
    } elseif ($request->tab == 'green_call') {
        $green_calls = DB::table('green_call')
        ->where('green_call.job_id', $request->roster_id)
        ->orderBy('green_call.id', 'desc')->get();
        if (count($green_calls)) {
            $response = [
                'success' => true,
                'message' => 'success',
                'data' => $green_calls
            ];
        } else {
            $response = [
                'success' => false,
                'error' => 'No Data found!',
                'data' => $green_calls
            ];
        }
    } elseif ($request->tab == 'welfare_call') {
        $welfare_calls = DB::table('welfare_call_data')
        ->where('welfare_call_data.job_roster_id', $request->roster_id)
        ->orderBy('welfare_call_data.id', 'desc')->get();
        if (count($welfare_calls)) {
            $response = [
                'success' => true,
                'message' => 'success',
                'data' => $welfare_calls
            ];
        } else {
            $response = [
                'success' => false,
                'error' => 'No Data found!',
                'data' => $welfare_calls
            ];
        }
    } elseif ($request->tab == 'break_details') {
        $break_details = DB::table('job_breaks')
        ->where('job_breaks.roster_id', $request->roster_id)
        ->orderBy('job_breaks.id', 'desc')->get();
        if (count($break_details)) {
            $response = [
                'success' => true,
                'message' => 'success',
                'data' => $break_details
            ];
        } else {
            $response = [
                'success' => false,
                'error' => 'No Data found!',
                'data' => $break_details
            ];
        }
    } else {
        $response = [
            'success' => false,
            'error' => 'No Data found!',
            'data' => null
        ];
    }
    return response()->json($response);
}

function profile_tracker(Request $request)
{
    $tracker = DB::table('log_profile_changes')->where('profile_id', $request->guard_id)->where('type', 'guard')->orderBy('datetime', 'desc')->get();
    foreach ($tracker as $key => $t) {
        $t->datetime = date('d/m/Y H:i a', $t->datetime);
    }
    return response()->json(['success' => true, 'data' => $tracker]);
}


function Apply_rates()
{
    $rosters = DB::table('job_new_roster')
    ->where('charge', 0)
    ->where(function ($query) {
        $query->where('chargerate_applied', '');
        $query->orWhere('chargerate_applied', null);
        $query->orWhere('chargerate_applied', '[]');
    })
    ->select('roster_id')->get();
    foreach ($rosters as $key => $roster) {
        $this->guard_model->logPayChargeRate($roster->roster_id, false);
            // $this->guard_model->calculateChargeRate($roster->roster_id);
    }
}

function getPublishList(Request $request)
{
    $customer_ids = $request->customer_ids;
    if ($request->type == 'guard') {
        $query = guard::join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->where('job_new_roster.temp_start', '>=', date('Y-m-d 00:00:00', strtotime($request->calendarStart)))
        ->where('job_new_roster.temp_start', '<=',  date('Y-m-d 00:00:00', strtotime($request->calendarEnd)));
            // ->where('job_new_roster.publish_status', 0)
        if ($request->has('from') && $request->from == 'copy') {
        } else {
            $query->where('job_new_roster.publish_status', 0);
        }
        $query->where(function ($que) use ($customer_ids) {
            foreach ($customer_ids as $key => $cId) {
                if ($key == 0) {
                    $que->where('jobs.customer_id', $cId);
                } else {
                    $que->orWhere('jobs.customer_id', $cId);
                }
            }
        })
        ->select('guards.id', 'guards.name as title')->orderBy('guards.name', 'ASC')->groupBy('guards.id')->get();
    } else {
        $query = job::join('job_new_roster', 'job_new_roster.site_id', '=', 'jobs.id')
        ->where('job_new_roster.temp_start', '>=',  date('Y-m-d 00:00:00', strtotime($request->calendarStart)))
        ->where('job_new_roster.temp_start', '<=',  date('Y-m-d 00:00:00', strtotime($request->calendarEnd)));
        if ($request->has('from') && $request->from == 'copy') {
        } else {
            $query->where('job_new_roster.publish_status', 0);
        }
        $query->where(function ($que) use ($customer_ids) {
            foreach ($customer_ids as $key => $cId) {
                    // if ($key == 0) {
                    //     $que->where('jobs.customer_id', $cId);
                    // } else {
                $que->orWhere('jobs.customer_id', $cId);
                    // }
            }
        })
        ->select('jobs.id', 'jobs.site_name as title')->orderBy('jobs.site_name', 'ASC')->groupBy('jobs.id');
    }
    $data = $query->get();
    $from = '';
    if ($request->has('from') && $request->from == 'copy') {
        $from = 'copy_';
    }
    $list = view('admin/publish_list', ['data' => $data, 'from' => $from])->render();
    return response()->json(['success' => true, 'data' => $list]);
}

public function getSelectedListPublish(Request $request)
{
    $selected_list = $request->selected_list;
    if ($request->type == 'guard') {
        $query = guard::join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')
        ->where('job_new_roster.temp_start', '>=', date('Y-m-d 00:00:00', strtotime($request->calendarStart)))
        ->where('job_new_roster.temp_start', '<=', date('Y-m-d 00:00:00', strtotime($request->calendarEnd)))
        ->where('job_new_roster.publish_status', 0)
        ->where(function ($que) use ($selected_list) {
            foreach ($selected_list as $key => $sl) {
                if ($key == 0) {
                    $que->where('guards.id', $sl['value']);
                } else {
                    $que->orWhere('guards.id', $sl['value']);
                }
            }
        })
        ->select('guards.id', 'guards.name as title')->groupBy('guards.id')->get();
    } else {
        $query = job::join('job_new_roster', 'job_new_roster.site_id', '=', 'jobs.id')
        ->where('job_new_roster.temp_start', '>=', $request->calendarStart)
        ->where('job_new_roster.temp_start', '<=', $request->calendarEnd)
        ->where('job_new_roster.publish_status', 0)
        ->where(function ($que) use ($selected_list) {
            foreach ($selected_list as $key => $sl) {
                if ($key == 0) {
                    $que->where('jobs.id', $sl['value']);
                } else {
                    $que->orWhere('jobs.id', $sl['value']);
                }
            }
        })
        ->select('jobs.id', 'jobs.site_name as title')->groupBy('jobs.id')->get();
    }
    $data = $query;
    $list = view('admin/SelectedListPublish', ['data' => $data])->render();
    return response()->json(['success' => true, 'data' => $list]);
}
function publishRosterNew(Request $request)
{
    $email = false;
    $push = false;
    $email_rsp = [];
    $config_job_roster = DB::connection('mysql2')->table('bussiness_config')->where('business_data_id', config('custom.domain_id'))->where('type', 'job_roster_navigation_bar')->first();
    $business = DB::connection('mysql2')->table('business_data')->where('id', config('custom.domain_id'))->first();
    $config = json_decode($config_job_roster->records_business_navbar, true);

    $publishShiftcount = 0;
    $days = array('Sun' => false, 'Mon' => false, 'Tue' => false, 'Wed' => false, 'Thu' => false, 'Fri' => false, 'Sat' => false);
    if ($request->has('selected_days') && !empty($request->selected_days)) {
        foreach ($request->selected_days as $key => $n) {
            $days[$n['value']] = true;
        }
    }
    if ($request->has('notification') && !empty($request->notification)) {
        foreach ($request->notification as $key => $n) {
            if ($n['value'] == 'push') {
                $push = true;
            }
            if ($n['value'] == 'email') {
                $email = true;
            }
        }
    }
    if (isset($config->email) && $config->email == 0) {
        $email = false;
    }
        // end foreach notification
    foreach ($request->customer_ids as $key => $cId) {
        $data = $this->guard_model->getAllPublishData($request->type, $cId, $request->publish_selected_ids, $request->calendarStart, $request->calendarEnd);

        $guards = $this->guard_model->getAllPublishGuards($request->type, $cId, $request->publish_selected_ids, $request->calendarStart, $request->calendarEnd);

        $updated_guards = $this->guard_model->getAllUpdatedPublishGuards($request->type, $cId, $request->publish_selected_ids, $request->calendarStart, $request->calendarEnd);

        if ($push == true) {
            foreach ($guards as $key => $g) {
                if ($g->notification_token != '') {
                    $message = 'Schedule for week starting ' . date('d M Y', strtotime($request->calendarStart));
                    $notification_data['guards'][0] = array(
                        'guard_id' => $g->id,
                        'notification_token' => $g->notification_token
                    );
                    $notification_data['message'] = $message;
                    $notification_data['title'] = 'New Roster Published';
                    $notification_data['page'] = 'homepage';
                    $res = $this->guard_model->send_push_notification($notification_data);
                }
                $smsMessage = 'Hello ' . $g->name . ',\nYour Next Week Roster has been sent to your ' . $business->title . ' App. Please check and confirm all your shifts.\nThanks,\nTeam ' . $business->title;
                    // $smsMessage = 'Hey '.$g->name.', New roster has been published successfully. Please check your app to confirm your shifts.';
                if (isset($config['sms']) && $config['sms'] == 1) {
                        // echo $smsMessage;
                        // exit();  
                    $this->sendSMS($g->phone, $smsMessage);
                }
            }
            foreach ($updated_guards as $key => $g) {
                if ($g->notification_token != '') {
                    $message = 'Schedule for week starting ' . date('d M Y', strtotime($request->calendarStart));
                    $notification_data['guards'][0] = array(
                        'guard_id' => $g->id,
                        'notification_token' => $g->notification_token
                    );
                    $notification_data['message'] = $message;
                    $notification_data['title'] = 'Updated Roster Published';
                    $notification_data['page'] = 'homepage';
                    $res = $this->guard_model->send_push_notification($notification_data);
                }
                $smsMessage = 'Hello ' . $g->name . ',\nYour shifts for ' . date('d/m/Y', strtotime($request->calendarStart)) . ' to ' . date('d/m/Y', strtotime($request->calendarEnd)) . ' has been updated. Please refer to the ' . $business->title . ' app or call Ops Team for further details.\nThanks,\nTeam ' . $business->title;
                    // $smsMessage = 'Hey '.$g->name.', updated roster has been published successfully. Please check your app to confirm your shifts.';
                if (isset($config['sms']) && $config['sms'] == 1) {
                    $this->sendSMS($g->phone, $smsMessage);
                }
            }
        }

        foreach ($data as $key => $value) {
            $day = date('D', strtotime($value->temp_start));
            if ($days[$day] == true) {
                    //send mail notification
                $this->guard_model->updatePublishStatus($value->roster_id);

                if ($value->guard_id != null || $value->guard_id != 0 && $email == true) {
                    $guard = guard::where('id', $value->guard_id)->first();
                    $site = job::where(array('id' => $value->site_id))->first();
                    $tasks = DB::table('job_roster_tasks')->where('roster_id', $value->guard_id)->first();
                    if (!empty($tasks)) {
                        $task_status = "Yes";
                    } else {
                        $task_status = "No";
                    }
                    $message = '<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
                    <br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
                    <tbody><tr><td align="center" valign="center" style="text-align:center; padding: 40px"><a href="' . config('custom.logo') . '" rel="noopener" target="_blank"><img src="https://vcpgsystem.com.au/asset_uploads/vcpg.png" style="height: 45px" alt="logo"></a></td></tr><tr>
                    <td align="left" valign="center">
                    <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px"><!--begin:Email content--><div style="padding-bottom: 30px; font-size: 17px;"><strong>New roster published</strong></div>';
                    $message .= '<div style="padding-bottom: 30px">Your new Roster from the duration of ' . date('d-m-Y', strtotime('monday this week')) . ' to ' . date('d-m-Y', strtotime('sunday this week')) . ' is below: </div>
                    <div style="padding-bottom: 40px; text-align:center;">';
                    $req['name'] = $guard->name;
                    $req['email'] = $guard->email;
                    $req['subject'] = 'New roster published';
                    $req['subject'] = 'Your Schedule for week starting ' . date('d M Y', strtotime('monday this week'));
                    $message .= '<br><b>Shift Details </b><br>';
                    $message .= '<table style="width:100%;margin-top: 6px;" border="1px"><tr style="background-color:#ececed"><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Day & Date</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Start & Finish Time</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Site</th><th style="padding:5px;border:1px solid #eeeeee;background-color:##eeeeee;">Task</th></tr>';
                    $message .= '<tr><td style="text-align:center; border:1px solid #eeeeee;">' . date('D', strtotime($value->temp_start))  . ' ' . date('d-m-Y', strtotime($value->temp_start)) . '</td><td style="text-align:center; border:1px solid #eeeeee;">' . date('H:i', strtotime($value->temp_start)) . ' to ' . date('H:i', strtotime($value->temp_end)) . '<td style="text-align:center;border:1px solid #eeeeee;">' . $site->site_name . ' (' . $site->site_description . ')</td><td style="text-align:center;border:1px solid #eeeeee;">' . $task_status . '</td></tr>';
                    $message .= '</table></div>';
                    $req['message'] = $message;
                    $email_rsp[] = $this->sendGuardMail($guard, $req['subject'], $message);
                }
            }
        }
    }
        // end customer ids loop
    $result["message"] = "success";
    $result["success"] = true;
    $result['email_rsp'] = $email_rsp;
    $result['count'] =  $publishShiftcount;
    return response()->json($result);
}
function copyRosterNew(Request $request)
{
    config(['app.timezone' => $this->timezone['Victoria']]);
    date_default_timezone_set($this->timezone['Victoria']);
    $selected_sites = $request->site_ids;
    $copy_data = DB::table('job_new_roster')
    ->whereBetween('temp_start', [date('Y-m-d 00:00:00', strtotime($request->calendarStart)), date('Y-m-d 00:00:00', strtotime($request->calendarEnd))])
    ->where(function ($que)  use ($selected_sites) {
        foreach ($selected_sites as $key => $value) {
            if ($key == 0) {
                $que->where('site_id', $value['value']);
            } else {
                $que->orWhere('site_id', $value['value']);
            }
        }
    })
    ->get();
        // return response()->json($copy_data);    
        // exit();
    $notes = $request->notes;
    $include_rates = $request->include_rates;
    $remove_staff = $request->remove_staff;
    $days = array('Sun' => false, 'Mon' => false, 'Tue' => false, 'Wed' => false, 'Thu' => false, 'Fri' => false, 'Sat' => false);
    if ($request->has('copy_days') && !empty($request->copy_days)) {
        foreach ($request->copy_days as $key => $n) {
            $days[$n['value']] = true;
        }
    } else {
        $days = array('Sun' => true, 'Mon' => true, 'Tue' => true, 'Wed' => true, 'Thu' => true, 'Fri' => true, 'Sat' => true);
    }
    $selected_weeks = $request->selected_weeks;
    $week_days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    foreach ($selected_weeks as $key => $sw) {
        foreach ($copy_data as $key1 => $roster) {
            $shift_day = date('D', strtotime($roster->temp_start));
            if ($days[$shift_day] == true) {
                $last_roster = DB::table('job_new_roster')->orderBy('event_id', 'DESC')->first();
                $event_id = 1;
                if (!empty($last_roster)) {
                    $event_id = $last_roster->event_id + 1;
                }
                $range = explode('-', $sw['value']);
                $week_start_date = trim($range[0]);
                $week_end_date = trim($range[1]);
                $start_day  = 1;
                $shift_start_day = date('w', strtotime($roster->temp_start));
                $shift_end_day = date('w', strtotime($roster->temp_end));

                $start_time = date('H:i', strtotime($roster->temp_start));
                $end_time = date('H:i', strtotime($roster->temp_end));
                $roster->job_start = date('Y-m-d', strtotime($week_days[$shift_start_day], $week_start_date)) . ' ' . $start_time;
                $roster->job_end = date('Y-m-d', strtotime($week_days[$shift_end_day], $week_start_date)) . ' ' . $end_time;
                if ($week_days[$shift_start_day] == 'Sunday' && $week_days[$shift_end_day] == 'Monday') {
                    $roster->job_end = strtotime($roster->job_end) + (60 * 60 * 24 * 7);
                    $roster->job_end = date('Y-m-d H:i', $roster->job_end);
                }
                $roster->job_start = strtotime($roster->job_start);
                $roster->job_end = strtotime($roster->job_end);
                $next_roster = array(
                    'event_id' => $event_id,
                    'guard_id' => $roster->guard_id,
                    'site_id' => $roster->site_id,
                    'temp_date' => date('Y-m-d', $roster->job_start),
                    'temp_start' => date('Y-m-d H:i:s', $roster->job_start),
                    'temp_end' => date('Y-m-d H:i:s', $roster->job_end),
                    'start' => str_replace(' ', 'T', date('Y-m-d H:i:s', $roster->job_start)),
                    'end' => str_replace(' ', 'T', date('Y-m-d H:i:s', $roster->job_end)),
                    'publish_status' => 0,
                    'add_status' => $roster->add_status,
                    'job_status' => 'pending',
                    'post_status' => 0,
                    'green_call_notification' => 'no',
                    'roll_over' => 1,
                    'update_status' => 0,
                    'job_start' => $roster->job_start,
                    'job_end' => $roster->job_end,
                );
                    // print_r($next_roster);
                    // exit();
                if ($notes == 'true') {
                    $next_roster['operators_notes'] = $roster->operators_notes;
                }
                if ($include_rates == 'true') {
                    $next_roster['custom_rates'] = $roster->custom_rates;
                    $next_roster['payrate_id'] = $roster->payrate_id;
                    $next_roster['chargerate_id'] = $roster->chargerate_id;
                }
                if ($remove_staff == 'true') {
                    $next_roster['guard_id'] = 0;
                }
                $next_roster['hours'] = round(abs($next_roster['job_end'] - $next_roster['job_start']) / 3600, 2);
                if ($next_roster['guard_id'] != '' && $next_roster['guard_id'] != null && $next_roster['guard_id'] > 0) {

                    $already = DB::table('job_new_roster')->where('guard_id', $next_roster['guard_id'])->where('temp_start', '<=', $next_roster['start'])->where('temp_end', '>=', $next_roster['start'])->first();
                    if (empty($already)) {
                        $already = DB::table('job_new_roster')->where('guard_id', $next_roster['guard_id'])->where('temp_start', '<=', $next_roster['end'])->where('temp_end', '>=', $next_roster['end'])->first();
                    }
                    $guardData = DB::table('guards')->where('id', $next_roster['guard_id'])->first();
                    $status = $this->checkGuardDocuments($guardData, $next_roster['temp_date']);
                    if (!empty($already)) {
                        $next_roster['guard_id'] = 0;
                        $conflict = 1;
                    } elseif ($status != "Active") {
                        $next_roster['guard_id'] = 0;
                        $conflict = 1;
                    }
                }
                    // return $next_roster;
                $inserted_id = DB::table('job_new_roster')->insertGetId($next_roster);
                $this->guard_model->logPayChargeRate($inserted_id);
                    // echo $inserted_id;
            }
                // end of if
        }
    }
    $action = 'shift_bulk_copy';
    $this->administrator->log_user_activity($action, array('message' => 'Bulk copy from '.date('Y-m-d', strtotime($request->calendarStart)).' to '.date('Y-m-d', (strtotime($request->calendarEnd) - (60*60*24))), 'request' => request()->all()));
    return response()->json(['success' => true, 'message' => 'success']);
}


function del_guard_documents(Request $request)
{
    if ($request->type == 'driver') {
        DB::table('guards')
        ->where('id', $request->guard_id)
        ->update(['driver_license_number' => '', 'driver_license_expiration' => '', 'driver_license_file' => '']);
        return response()->json(['success' => true, 'type' => 'driver', 'message' => "File Deleted Successfully."]);
    }
    if ($request->type == 'driver_back') {
        DB::table('guards')
        ->where('id', $request->guard_id)
        ->update(['driver_license_file_back' => '']);
        return response()->json(['success' => true, 'type' => 'driver', 'message' => "File Deleted Successfully."]);
    }
    if ($request->type == 'visa') {
        DB::table('guards')
        ->where('id', $request->guard_id)
        ->update(['visa_number' => '', 'visa_expiration' => '', 'visa_file' => '']);
        return response()->json(['success' => true, 'type' => 'visa', 'message' => "File Deleted Successfully."]);
    }
    if ($request->type == 'passport') {
        DB::table('guards')
        ->where('id', $request->guard_id)
        ->update(['passport_number' => '', 'passport_expiration' => '', 'passport_file' => '']);
        return response()->json(['success' => true, 'type' => 'passport', 'message' => "File Deleted Successfully."]);
    }
    if ($request->type == 'vacciantion') {
        DB::table('guards')
        ->where('id', $request->guard_id)
        ->update(['vaccination_certificate' => '']);
        return response()->json(['success' => true, 'type' => 'vacciantion', 'message' => "File Deleted Successfully."]);
    }
    if ($request->type == 'birthcertificate') {
        DB::table('guards')
        ->where('id', $request->guard_id)
        ->update(['birthcertificate_number' => '', 'birthcertificate_expiration' => '', 'birthcertificate_file' => '']);
        return response()->json(['success' => true, 'type' => 'vacciantion', 'message' => "File Deleted Successfully."]);
    }
    if ($request->type == 'medicare') {
        DB::table('guards')
        ->where('id', $request->guard_id)
        ->update(['medicare_number' => '', 'medicare_expiration' => '', 'medicare_file' => '']);
        return response()->json(['success' => true, 'type' => 'medicare', 'message' => "File Deleted Successfully."]);
    }
    if ($request->type == 'citizen') {
        DB::table('guards')
        ->where('id', $request->guard_id)
        ->update(['citizenship_number' => '', 'citizenship_expiration' => '', 'citizenship_file' => '']);
        return response()->json(['success' => true, 'type' => 'citizen', 'message' => "File Deleted Successfully."]);
    }
    if ($request->type == 'firstaid') {
        DB::table('guards')
        ->where('id', $request->guard_id)
        ->update(['firstaid_license_number' => '', 'firstaid_license_expiration' => '', 'firstaid_license_file' => '']);
        return response()->json(['success' => true, 'type' => 'firstaid', 'message' => "File Deleted Successfully."]);
    }
}
function copyShiftNew(Request $request)
{
    config(['app.timezone' => $this->timezone['Victoria']]);
    date_default_timezone_set($this->timezone['Victoria']);
    $copy_data = DB::table('job_new_roster')
    ->where('event_id', $request->event_id)
    ->first();
        // print_r('<pre>');
        // print_r($copy_data);
        // exit();

    $copy_days = $request->copy_days;

    foreach ($copy_days as $key => $sw) {
        $last_roster = DB::table('job_new_roster')->orderBy('event_id', 'DESC')->first();
        $event_id = 1;
        if (!empty($last_roster)) {
            $event_id = $last_roster->event_id + 1;
        }
        $shift_start_day = date('d', strtotime($copy_data->temp_start));
        $shift_end_day = date('d', strtotime($copy_data->temp_end));
        $start_time = date('H:i', strtotime($copy_data->temp_start));
        $end_time = date('H:i', strtotime($copy_data->temp_end));
        $end_date = $sw['value'];
        if ($shift_start_day != $shift_end_day) {
            $end_date = strtotime("+1 day", $end_date);
        }
        $copy_data->job_start = date('Y-m-d', $sw['value']) . ' ' . $start_time;
        $copy_data->job_end = date('Y-m-d',  $end_date) . ' ' . $end_time;
        $copy_data->job_start = strtotime($copy_data->job_start);
        $copy_data->job_end = strtotime($copy_data->job_end);
        $next_roster = array(
            'event_id' => $event_id,
            'guard_id' => $copy_data->guard_id,
            'site_id' => $copy_data->site_id,
            'temp_date' => date('Y-m-d', $copy_data->job_start),
            'temp_start' => date('Y-m-d H:i:s', $copy_data->job_start),
            'temp_end' => date('Y-m-d H:i:s', $copy_data->job_end),
            'start' => str_replace(' ', 'T', date('Y-m-d H:i:s', $copy_data->job_start)),
            'end' => str_replace(' ', 'T', date('Y-m-d H:i:s', $copy_data->job_end)),
            'publish_status' => 0,
            'add_status' => $copy_data->add_status,
            'job_status' => 'pending',
            'post_status' => 0,
            'green_call_notification' => 'no',
            'roll_over' => 1,
            'update_status' => 0,
            'job_start' => $copy_data->job_start,
            'job_end' => $copy_data->job_end,
        );
        if ($request->has('without_guard') && $request->without_guard == 1) {
            $next_roster['guard_id'] = '';
        }
        $next_roster['operators_notes'] = $copy_data->operators_notes;
        $next_roster['custom_rates'] = $copy_data->custom_rates;
        $next_roster['payrate_id'] = $copy_data->payrate_id;
        $next_roster['chargerate_id'] = $copy_data->chargerate_id;

        $next_roster['hours'] = round(abs($next_roster['job_end'] - $next_roster['job_start']) / 3600, 2);
        if ($next_roster['guard_id'] != '' && $next_roster['guard_id'] != null && $next_roster['guard_id'] > 0) {

            $already = DB::table('job_new_roster')->where('guard_id', $next_roster['guard_id'])->where('temp_start', '<=', $next_roster['start'])->where('temp_end', '>=', $next_roster['start'])->first();
            if (empty($already)) {
                $already = DB::table('job_new_roster')->where('guard_id', $next_roster['guard_id'])->where('temp_start', '<=', $next_roster['end'])->where('temp_end', '>=', $next_roster['end'])->first();
            }
            $guardData = DB::table('guards')->where('id', $next_roster['guard_id'])->first();
            $status = $this->checkGuardDocuments($guardData, $next_roster['temp_date']);
            if (!empty($already)) {
                $next_roster['guard_id'] = 0;
                $conflict = 1;
            } 
                // elseif ($status != "Active") {
                //     $next_roster['guard_id'] = 0;
                //     $conflict = 1;
                // }
        }
            // return $next_roster;
        $inserted_id = DB::table('job_new_roster')->insertGetId($next_roster);
        $this->guard_model->logPayChargeRate($inserted_id);

            // end of if
    }
    return response()->json(['success' => true, 'message' => 'success']);
}

function applyPayRates(Request $request)
{
    $rosters = DB::table('job_new_roster')
            // ->where('pay', 0)
    ->where(function ($que) {
        $que->where('payrate_applied', 'null');
        $que->orWhereNull('payrate_applied');
        $que->orWhere('payrate_applied', '[]');
        $que->orWhere('payrate_applied', '');
    })
    ->select('roster_id')
    ->get();
    $updated = [];
    foreach ($rosters as $key => $r) {
        $this->guard_model->logPayChargeRate($r->roster_id);
        $updated[] = $r->roster_id;
    }
    return response()->json($updated);
}
function getShiftNotes(Request $request)
{
    $roster = DB::table('job_new_roster')->where('roster_id', $request->roster_id)->first();
    $html = view('admin/modals/editNotes', ['roster' => $roster])->render();
    return response()->json($html);
}

function updateNotes(Request $request)
{
    DB::table('job_new_roster')->where('event_id', $request->eventId)->update(['operators_notes' => $request->operators_notes]);
    return response()->json(['success' => true, 'message' => 'Done']);
}
function getDateForSpecificDayBetweenDates($startDate, $endDate, $day_number)
{
    $endDate = strtotime($endDate);
    $days = array('1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday');
    $date_array = [];
    if (date('D', $endDate) == 'Sun') {
        $endDate = $endDate + 60*60*24;
            // echo date('D', $endDate);
            // exit();
    }
    for ($i = strtotime($days[$day_number], strtotime($startDate)); $i < $endDate; $i = strtotime('+1 week', $i))
        $date_array[] = date('Y-m-d', $i);

    return $date_array;
}
function getCalendarHours(Request $request)
{
    $days = array('Monday' => 0, 'Tuesday' => 0, 'Wednesday' => 0, 'Thursday' => 0, 'Friday' => 0, 'Saturday' => 0, 'Sunday' => 0);
    $total_hours = 0;
    $week_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $customerId = $request->customerIds;
    $state = $request->state;
    $dates1 = array();
    $start_date = strtotime($request->start);
    foreach ($week_days as $key => $day) {
        if ($key < 7) {
            $dates = $this->getDateForSpecificDayBetweenDates($request->start, $request->end, $key + 1);
            $hours = job_new_roster::join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
            ->where(function ($query)  use ($customerId) {
                foreach ($customerId as $key => $cId) {
                    if ($key == 0) {
                        $query->where('jobs.customer_id', $cId);
                    } else {
                        $query->orWhere('jobs.customer_id', $cId);
                    }
                }
            })
                 ->where('jobs.state', $state)          //changed by moiz for hours calculations dependent on states.
                 ->where(function ($query) use ($dates) {
                    foreach ($dates as $key => $date) {
                        if ($key == 0) {
                            // $query->whereDate('job_new_roster.temp_start', '>=', date('Y-m-d 00:00:00', strtotime($date)));
                            // $query->orWhereDate('job_new_roster.temp_end', '<=', date('Y-m-d 23:59:59', strtotime($date)));
                            $query->orWhereDate('job_new_roster.temp_date',$date);
                        } else {
                            // $query->orWhereDate('job_new_roster.temp_start',  date('Y-m-d 00:00:00', strtotime($date)));
                        }
                    }
                })
                 ->sum('job_new_roster.hours');
                 $days[$day] = round($hours, 2);
                 $dates1[$day] = $dates;
                 $total_hours = $total_hours + $hours;
             }
         }
         $days['total_hours'] = round($total_hours, 2);
         return response()->json(['success' => true, 'hours' => $days, 'dates' => $dates1]);
     }
     function getAllAavailableGuards()
     {
        $guards_with_active_shifts = DB::table('job_new_roster')
        ->leftJoin('job_roster_activities', 'job_roster_activities.job_roster_id', '=', 'job_new_roster.roster_id')
        ->where('temp_start', '<=', date('Y-m-d H:i:s'))
        ->where('temp_end', '>=', date('Y-m-d H:i:s'))
        ->select('job_new_roster.guard_id as id', 'job_roster_activities.id as activity_id')
        ->groupBy('job_new_roster.guard_id')
        ->get();
    // print_r('<pre>');
    // print_r($guards_with_active_shifts);
    // exit();
        $guard_ids = [];
        foreach ($guards_with_active_shifts as $key => $id) {
            if ($id->activity_id > 0) {
                $guard_ids[] = $id->id;
            }
        }
        $available_gaurds = array();
    // get Guards who dont have any active shift right now
        $guards = DB::table('guards')
        ->join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')
        ->whereNotIn('id', $guard_ids)
        ->select('guards.id', 'guards.name', 'guards.phone', 'guards.profile_image')
        ->orderBy('name', 'ASC')
        ->groupBy('job_new_roster.guard_id')
        ->get();

        foreach ($guards as $guard) {
            $max_hours = 0;
            $guard->working_hours = $max_hours;
            $is_available = true;
            $prev_shift_res =  DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_end', '<', date('Y-m-d H:i:s'))->orderBy('temp_start', 'desc')->first();
            if (!empty($prev_shift_res)) {

                $site = DB::table('jobs')->where('id', $prev_shift_res->site_id)->first();
                $site_name = !empty($site) ? $site->site_name : 'N/A';          //changed by moiz. changed to site name instead of site address.
                    // $prev_shift='';
                $prev_shift = [
                    'guard_id' => $prev_shift_res->guard_id,
                    'temp_date' => Date("d-m-Y", strtotime($prev_shift_res->temp_date)),
                    'start' => Date("H:i", strtotime($prev_shift_res->temp_start)),
                    'end' => Date("H:i", strtotime($prev_shift_res->temp_end)),
                    'site' => $site_name,
                    'job_time_end' => ($prev_shift_res->job_end != '' && $prev_shift_res->job_end != null && $prev_shift_res->job_end > 0) ? date('Y-m-d H:i', $prev_shift_res->job_end) : date("Y-m-d H:i", strtotime($prev_shift_res->temp_end))
                ];
                if ($prev_shift_res->job_end != '' && $prev_shift_res->job_end != null && $prev_shift_res->job_end > 0) {
                    $seconds = strtotime(date('Y-m-d H:i:s')) - $prev_shift_res->job_end;
                } else {
                    $seconds = strtotime(date('Y-m-d H:i:s')) - strtotime($prev_shift_res->temp_end);
                }
                $hours = $seconds / (60 * 60);
                $guard->previous_shift_diff = $hours;

                if ($hours < 8 && $max_hours > 12) {
                    $is_available = false;
                }
            } else {
                $prev_shift = [];
            }

            $next_shift_res =  DB::table('job_new_roster')->where('guard_id', $guard->id)->where('temp_start', '>', date('Y-m-d H:i:s'))->orderBy('temp_start', 'asc')->first();
            if (!empty($next_shift_res)) {

                $site = DB::table('jobs')->where('id', $next_shift_res->site_id)->first();
                $site_name = !empty($site) ? $site->address : 'N/A';
                $next_shift = [
                    'guard_id' => $next_shift_res->guard_id,
                    'temp_date' => Date("d-m-Y", strtotime($next_shift_res->temp_date)),
                    'start' => Date("H:i", strtotime($next_shift_res->temp_start)),
                    'end' => Date("H:i", strtotime($next_shift_res->temp_end)),
                    'site' => $site_name,
                ];
                $guard->next_shift_diff = $hours;

                if ($hours < 8 && $max_hours > 12) {
                    $is_available = false;
                }
            } else {
                $next_shift = [];
            }
            $guard->next_shift = $next_shift;
            $guard->prev_shift = $prev_shift;
            if ($is_available) {
                $available_gaurds[] = $guard;
            }
        }
        

        return response()->json(['guards' => $available_gaurds]);
    }
    public function sendBirthdayMail(){
        $today = Carbon::now();
        $activeGuards = Guard::where('status', 'active')
            ->select('name', 'email', 'dob')
            ->get();
        $mainArr = [];
        for ($i=0; $i < count($activeGuards) ; $i++) {
            if (strpos($activeGuards[$i]->dob, '/') !== false) {
                $activeGuards[$i]->dob = str_replace('/', '-', $activeGuards[$i]->dob);
                $activeGuards[$i]->formated_date = date('Y-m-d', strtotime($activeGuards[$i]->dob));
            }else{
                $activeGuards[$i]->formated_date = date('d-m-Y', strtotime($activeGuards[$i]->dob));
            }
            if($today->isBirthday(Carbon::parse($activeGuards[$i]->formated_date))){
                $mainArr[] = $activeGuards[$i]; 
            }
        }
        // $root = $_SERVER['HTTP_HOST'];
        // $root = explode('.', $root);
        // $postfix = 'staffingsolution';
        // if ($root[0] != 'wwww') {
        //     $postfix = $root[0];
        // } else {
        //     $postfix = $root[1];
        // }

        // $config_title = config('custom.title');
        // $from = $postfix.'@247staffingsolution.com.au';
        $fromEmail = 'no-reply@vcpgsystem.com.au';
        $fromName = 'VCPG Security';
        // $headers  = 'MIME-Version: 1.0' . "\r\n";
        $subject = 'Happy Birthday From VCPG';
        // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        // $headers .= 'From: '.$from."\r\n".
        // 'Reply-To: '.$from."\r\n" .
        // 'X-Mailer: PHP/' . phpversion();
        $image1 = 'https://vcpgsystem.com.au/portal/media/1653986844783-bg.png';
        $image2 = 'https://vcpgsystem.com.au/portal/media/1653987052761-cake.png';
        $image3 = 'https://vcpgsystem.com.au/portal/media/vcpg.png';
        if(count($mainArr) > 0){

        foreach ($mainArr as $guard) {
            $to = $guard->email;
            $emailContent = '<body class="clean-body u_body"
            style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #e7e7e7;color: #000000">
            <table id="u_body"
                style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #e7e7e7;width:100%"
                cellpadding="0" cellspacing="0">
                <tbody>
                    <tr style="vertical-align: top">
                        <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                            <div id="u_row_1" class="u-row-container v-row-padding--vertical v-row-background-image--outer"
                                style="padding: 0px;background-image: url({{'.$image1.'}});background-repeat: no-repeat;background-position: center top;background-color: transparent">
                                <div class="v-container-padding-padding"
                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;text-align: center;">
                                    <img src="'.$image3.'" alt="Logo" title="Logo" width="150"
                                        style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;margin-top: 30px;">
                                </div>
                                <div class="u-row"
                                    style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                    <div class="v-row-background-image--inner"
                                        style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
                                          <div id="u_column_1" class="u-col u-col-100"
                                            style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                            <div style="height: 100%;width: 100% !important;">
                                                <div class="v-col-padding"
                                                    style="height: 100%; padding: 60px 0px 92px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                                                    <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                        cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px 10px 1px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <h3
                                                                        style="margin: 0px; color: #344a84; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: Montserrat,sans-serif; font-size: 18px;">
                                                                        <div>
                                                                            <div>Today is your special day!</div>
                                                                        </div>
                                                                    </h3>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
        
                                                    <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                        cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:0px 10px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <h1
                                                                        style="margin: 0px; color: #344a84; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: Montserrat,sans-serif; font-size: 33px;">
                                                                        <strong>Happy Birthday</strong>
                                                                    </h1>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
        
                                                    <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                        cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <h1
                                                                        style="margin: 0px; color: #344a84; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: Montserrat,sans-serif; font-size: 22px;">
                                                                        <div><strong>'.$guard->name.'</strong></div>
                                                                    </h1>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
        
                                                    <table id="u_content_image_1"
                                                        style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                        cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <table width="100%" cellpadding="0" cellspacing="0"
                                                                        border="0">
                                                                        <tr>
                                                                            <td style="padding-right: 0px;padding-left: 0px;"
                                                                                align="center">
        
                                                                                <img align="center" border="0"
                                                                                    src="'.$image2.'"
                                                                                    alt="Birthday Cake" title="Birthday Cake"
                                                                                    style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 46%;max-width: 266.8px;"
                                                                                    width="266.8"
                                                                                    class="v-src-width v-src-max-width">
        
                                                                            </td>
                                                                        </tr>
                                                                    </table>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
        
                                                    <table id="u_content_text_1" style="font-family:arial,helvetica,sans-serif;"
                                                        role="presentation" cellpadding="0" cellspacing="0" width="100%"
                                                        border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px 55px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <div
                                                                        style="line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                        <p
                                                                            style="font-size: 14px; line-height: 140%; text-align: center;">
                                                                            An amazing employee like you is more priceless to us
                                                                            than our everyday problems. Even more surprising is
                                                                            how you manage to build a stronger bond each day
                                                                            with every member of our team. Finally wishing that
                                                                            your every day is filled with happiness and good
                                                                            health. Happy birthday!</p>
                                                                        <p
                                                                            style="font-size: 14px; line-height: 140%; text-align: center;">
                                                                        </p>
                                                                    </div>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
        
                                                    <table id="u_content_social_1"
                                                        style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                        cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <div align="center">
                                                                        <div style="display: table; max-width:110px;">
                                                                        </div>
                                                                    </div>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
        
                                                    <table id="u_content_text_2" style="font-family:arial,helvetica,sans-serif;"
                                                        role="presentation" cellpadding="0" cellspacing="0" width="100%"
                                                        border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <div
                                                                        style="line-height: 140%; text-align: center; word-wrap: break-word;">
                                                                        <p
                                                                            style="font-size: 15px; line-height: 140%; font-weight: bold;">
                                                                            VCPG Security</p>
                                                                        
                                                                    </div>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
        
                                                    <table id="u_content_divider_1"
                                                        style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                        cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px 80px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <table height="0px" align="center" border="0"
                                                                        cellpadding="0" cellspacing="0" width="100%"
                                                                        style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                        <tbody>
                                                                            <tr style="vertical-align: top">
                                                                                <td
                                                                                    style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                                    <span>&#160;</span>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
        
                                                    <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                        cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <div
                                                                        style="line-height: 140%; text-align: center; word-wrap: break-word;">
                                                                        <p style="font-size: 14px; line-height: 140%;">&copy;
                                                                            2023 All Rights Reserved</p>
                                                                    </div>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </body>';
        // mail($to, $subject, $message, $headers);
        // Mail::send([], [], function ($message) use ($to, $subject, $emailContent, $fromEmail, $fromName) {
        //     $message->to($to)
        //         ->from($fromEmail, $fromName)
        //         ->subject($subject)
        //         ->setBody($emailContent, 'text/html');
        // });
        $user = null;
        Mail::to($to)->send(new GenericMail($user, $emailContent, $subject));
        }
        $emailContent1 = '<body class="clean-body u_body"
            style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #e7e7e7;color: #000000">
            <table id="u_body"
                style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #e7e7e7;width:100%"
                cellpadding="0" cellspacing="0">
                <tbody>
                    <tr style="vertical-align: top">
                        <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                            <div id="u_row_1" class="u-row-container v-row-padding--vertical v-row-background-image--outer"
                                style="padding: 0px;background-image: url({{'.$image1.'}});background-repeat: no-repeat;background-position: center top;background-color: transparent">
                                <div class="v-container-padding-padding"
                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;text-align: center;">
                                    <img src="'.$image3.'" alt="Logo" title="Logo" width="150"
                                        style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;margin-top: 30px;">
                                </div>
                                <div class="u-row"
                                    style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                    <div class="v-row-background-image--inner"
                                        style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
                                          <div id="u_column_1" class="u-col u-col-100"
                                            style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                            <div style="height: 100%;width: 100% !important;">
                                                <div class="v-col-padding"
                                                    style="height: 100%; padding: 60px 0px 92px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
        
                                                    <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                        cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:0px 10px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <h1
                                                                        style="margin: 0px; color: #344a84; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: Montserrat,sans-serif; font-size: 33px;">
                                                                        <strong>We Sent Birthday Email To</strong>
                                                                    </h1>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
        
                                                    <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                        cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">';
                                                                    foreach($mainArr as $guard){
                                                                        $emailContent1 = $emailContent1.'<h1 style="margin: 0px; color: #344a84; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: Montserrat,sans-serif; font-size: 22px;">
                                                                            <div><strong>'.$guard->name.'</strong></div>
                                                                        </h1>';
                                                                    }
                                                                $emailContent1 = $emailContent1.'</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
        
                                                    <table id="u_content_social_1"
                                                        style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                        cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <div align="center">
                                                                        <div style="display: table; max-width:110px;">
                                                                        </div>
                                                                    </div>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
        
                                                    <table id="u_content_text_2" style="font-family:arial,helvetica,sans-serif;"
                                                        role="presentation" cellpadding="0" cellspacing="0" width="100%"
                                                        border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <div
                                                                        style="line-height: 140%; text-align: center; word-wrap: break-word;">
                                                                        <p
                                                                            style="font-size: 15px; line-height: 140%; font-weight: bold;">
                                                                            VCPG Security</p>
                                                                        
                                                                    </div>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
        
                                                    <table id="u_content_divider_1"
                                                        style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                        cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px 80px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <table height="0px" align="center" border="0"
                                                                        cellpadding="0" cellspacing="0" width="100%"
                                                                        style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                        <tbody>
                                                                            <tr style="vertical-align: top">
                                                                                <td
                                                                                    style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                                    <span>&#160;</span>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
        
                                                    <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                        cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding"
                                                                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                                    align="left">
        
                                                                    <div
                                                                        style="line-height: 140%; text-align: center; word-wrap: break-word;">
                                                                        <p style="font-size: 14px; line-height: 140%;">&copy;
                                                                            2023 All Rights Reserved</p>
                                                                    </div>
        
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </body>'; 
        $to = 'moizalig16@gmail.com';
        // mail($to, $subject, $admin_message, $headers);
        // Mail::send([], [], function ($message) use ($to, $subject, $emailContent1, $fromEmail, $fromName) {
        //     $message->to($to)
        //         ->from($fromEmail, $fromName)
        //         ->subject($subject)
        //         ->setBody($emailContent1, 'text/html');
        // });
        $user = null;
        Mail::to($to)->send(new GenericMail($user, $emailContent1, $subject));
        }
    }

}
