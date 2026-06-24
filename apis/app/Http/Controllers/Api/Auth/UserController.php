<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\CustomerResource;
use App\Models\User;
use App\Models\Customer;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class UserController extends ApiController
{
    public $userActivityRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserActivity $userActivity) {
        $this->userActivityRepo = $userActivity;
    }
    private function encryptPassword($password) {

        return password_hash($password, CRYPT_SHA512);

    }
    public function register(Request $request) {

        if ($request->has('userType') && $request->input('userType') == 'customer') {
            return $this->customer_register($request);
            exit();
        }

        $this->request = $request;
        $this->setValidationRules(['firstName' => 'required', 'lastName' => 'required', 'email' => 'required|email|unique:guards', 'password' => 'required', 'phone' => 'required']);
        if ($this->isValidRequest()) {
            $this->response = ['success' => false, 'error' => $this->getErrors()];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }

        $user = new User();

        $already = User::where('email', $request->input('email'))->first();
        if($already) {
            $this->response = ['status' => false, 'error' => 'User with this email is already registered.'];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }
        // $undefined = undefined;
        if (!$request->has('middleName') || $request->middleName == 'undefined') {
            $user->middle_name = '';
            $user->name =  $request->input('firstName').' '.$request->input('lastName');
        }else{
            $user->middle_name = $request->input('middleName');
            $user->name =  $request->input('firstName').' '. $request->input('middleName').' '.$request->input('lastName');
            $user->middleName = str_replace('undefined', '', $user->middleName);
            $user->name = str_replace('undefined', '', $user->name);
        }
        $user->first_name = $request->input('firstName');
        $user->last_name = $request->input('lastName');
        // $user->middle_name = $request->input('middleName');
        
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->phone = $request->input('phone');
        $user->status = User::INACTIVE_STATUS;
        $activationCode = md5($this->encryptPassword(md5($request->input('email').md5(time()))));
        $user->activation_code = $activationCode;
        $user->auth_token = $activationCode;
        $plainPassword = '******';

        if($user->save()){
            $this->sendMail(array('name' => $request->input('firstName').' '. $request->input('middleName').' '.$request->input('lastName'), 'email' => $request->input('email')), $activationCode, $plainPassword);
            $this->statusCode = 201;
            $this->response = [
                'success' => true,
                'message' => 'Your account has been created succesfully! Please verify your email address first to login.'
            ];
            return $this->sendResponse();
        }
        $this->statusCode = 200;
        $this->response = ['success' => false, 'error' => 'Your account has not been created.'];
        return $this->sendResponse();
    }

    public function customer_register($request)
    {
        $this->request = $request;
        $this->setValidationRules(['firstName' => 'required', 'lastName' => 'required', 'email' => 'required|email|unique:customers', 'password' => 'required', 'phone' => 'required']);
        if ($this->isValidRequest()) {
            $this->response = ['success' => false, 'error' => $this->getErrors()];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }

        $customer = new Customer();

        $already = Customer::where('email', $request->input('email'))->first();
        if($already) {
            $this->response = ['status' => false, 'error' => 'Customer with this email is already registered.'];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }

        $customer->name =  $request->input('firstName').' '.$request->input('lastName');
        $customer->email = $request->input('email');
        $customer->password = Hash::make($request->input('password'));
        $customer->phone = $request->input('phone');
        $customer->address = '';
        $customer->city = '';
        $customer->state = '';
        $customer->postal_code = '';
        $customer->auth_token = '0';
        $customer->notification_token = '';
        $customer->timestamp_joined = time();
        $customer->timestamp_activity = time();
        
        $customer->status = 'active';
        $plainPassword = '******';

        if($customer->save()){
            $this->sendMail(array('name' => $request->input('firstName').' '.$request->input('lastName'), 'email' => $request->input('email')), '', $plainPassword);
            $this->statusCode = 201;
            $this->response = [
                'success' => true,
                'message' => 'Your account has been created succesfully!'
            ];
            return $this->sendResponse();
        }
        $this->statusCode = 200;
        $this->response = ['success' => false, 'error' => 'Your account has not been created.'];
        return $this->sendResponse();

    }

    public function login(Request $request) {

        if ($request->has('userType') && $request->input('userType') == 'customer') {
            return $this->customer_login($request);
            exit();
        }

        $this->request = $request;
        $this->setValidationRules(['email' => 'required|email', 'password' => 'required']);
        if ($this->isValidRequest()) {
            $this->response = ['success' => false, 'error' => $this->getErrors()];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }

        $user = User::where('email', $request->input('email'))->first();
        // if($user && $user->status !== User::ACTIVE_STATUS) {
        if($user && ($user->status !== 'active' || $user->admin_approved !== 1)) {
            $this->response = ['status' => false, 'error' => 'Your account is inactive please contact your Administrator.'];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }

        if($user && Hash::check($request->input('password'), $user->password)){

            $apikey = base64_encode(Str::random(64).time());
            $coordinates = ($request->input('coordinates') != null) ? $request->input('coordinates') : '';
            // comment by mohsin so user token will not update on each login request. 21/08/2021
            // User::where('email', $request->input('email'))->update(['auth_token' => "$apikey"]);
            $user = User::where('email', $request->input('email'))->first();
            // if ($user->auth_token == '') {
            User::where('email', $request->input('email'))->update(['auth_token' => "$apikey"]);
            $user->auth_token = $apikey;
            // }
            // UserActivity::where('guard_id', $user->id)->update(['status' => 0]);
            // $this->userActivityRepo->insert([
            //     'guard_id' => $user->id,
            //     'signin_time' => $this->request->input('signin_time'),
            //     'location'=> $this->request->input('location'),
            //     'status'=> 1,
            // ]);
            $this->userActivityRepo->insert([
                'guard_id' => $user->id,
                'location' => $coordinates,
                'action' => 'signin',
                'status' => 1 
            ]);
            $root= $_SERVER['HTTP_HOST'];
            $root = explode('.', $root);
            $postfix = 'staffingsolution';
            if($root[0] != 'wwww'){
                $postfix = $root[0];
            }else{
                $postfix = $root[1];
            }
            $config_data = DB::connection('mysql2')->table('business_data')->where('hide', 0)->where('domain', '=', $postfix)->first();
            if (!empty($config_data) && $config_data->business_type == 'demo') {
                $user->switch_account = true;
                $switch_businesses = DB::connection('mysql2')->table('business_data')->where('domain', '!=', $postfix)->where('hide', 0)->where('business_type', 'demo')->get();
                foreach ($switch_businesses as $key => $b) {
                    Config::set("database.connections.mysql2", [
                        "host" => env('DB_HOST'),
                        "database" => env('DB_DATABASE', 'staffingsolution_'.$b->domain),
                        "username" => env('DB_USERNAME'),
                        "password" => env('DB_PASSWORD'),
                        'driver' => 'mysql',
                        "port" => '3306',
                        'charset'   => 'utf8mb4',
                        'collation' => 'utf8mb4_unicode_ci',
                        'prefix'    => '',
                        'strict'    => true,
                    ]);
                    DB::purge('mysql2');
                    DB::setDefaultConnection('mysql2');
                    $is_in = DB::connection('mysql2')->table('guards')->where('email', $request->input('email'))->first();
                    if (empty($is_in)) {
                        unset($switch_businesses[$key]);
                    }
                }
                
                $user->businesses = $switch_businesses;
            }else{
                $user->switch_account = false;
                $user->businesses = [];
            }
            return new UserResource($user);
        }
        $this->response = ['status' => false, 'error' => 'Username or Password invalid.'];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }

    public function customer_login(Request $request) {

        $this->request = $request;
        $this->setValidationRules(['email' => 'required|email', 'password' => 'required']);
        if ($this->isValidRequest()) {
            $this->response = ['success' => false, 'error' => $this->getErrors()];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }

        $user = Customer::where('email', $request->input('email'))->first();
        if($user && $user->status !== User::ACTIVE_STATUS) {
            $this->response = ['status' => false, 'error' => 'Your account is inactive please contact your Administrator.'];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }

        if($user && Hash::check($request->input('password'), $user->password)){
            $apikey = base64_encode(Str::random(64).time());
            // comment by mohsin so user token will not update on each login request. 21/08/2021
            // Customer::where('email', $request->input('email'))->update(['auth_token' => "$apikey"]);
            $user = Customer::where('email', $request->input('email'))->first();
            if ($user->auth_token == '') {
                Customer::where('email', $request->input('email'))->update(['auth_token' => "$apikey"]);
                $user->auth_token = $apikey;
            }
            return new CustomerResource($user);
        }
        $this->response = ['status' => false, 'error' => 'Username or Password invalid.'];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }

    function rand_string( $length ) {
        $str = "";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $size = strlen( $chars );
        for( $i = 0; $i < $length; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }

        return $str;
    }
//and call the function this way:
    public function forgot_password(Request $request) {
        $this->request = $request;
        $this->setValidationRules(['email' => 'required|email']);
        if ($this->isValidRequest()) {
            $this->response = ['success' => false, 'error' => $this->getErrors()];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }

        $user = User::where('email', $request->input('email'))->first();
        if(empty($user) || $user->status !== User::ACTIVE_STATUS) {
            $this->response = ['status' => false, 'error' => 'Email does not exists or invalid.'];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }else{
                    // $mypass = $this->rand_string(10);
                    //     $password = Hash::make($mypass);
                    //     $result=DB::table('guards')->where('email', $request->input('email'))->update(['password'=>$password]);
            $apikey = base64_encode(Str::random(64).time());
            $result =DB::table('guards')->where('email', $request->input('email'))->update(['auth_token'=>"$apikey"]);
            $user->auth_token = $apikey;
            $email_result = $this->sendMail_forgot($user,$apikey);

            $this->response = ['status' => true, 'message' => 'Please check your inbox for the password reset instructions.', 'email_result' => $email_result];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }


        $this->response = ['status' => false, 'error' => 'Email invalid.'];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }

    public function logout(Request $request) {

        if ($request->has('userType') && $request->input('userType') == 'customer') {
            return $this->customer_logout($request);
            exit();
        }
        $user = User::where('auth_token', $request->header('Authorization'))->first();
        if ($user) {
            User::where('id', $user->id)->update(['auth_token' => '', 'notification_token' => '']);
            /*UserActivity::where(['guard_id' => $user->id, 'status' => 1])->update([
                    'signout_time' => $request->input('signout_time'),
                    'status'=> 0,
                ]);*/
                $coordinates = ($request->has('coordinates') && $request->input('coordinates') != null) ? $request->input('coordinates') : '';
                $this->userActivityRepo->insert([
                    'guard_id' => $user->id,
                    'location' => $coordinates,
                    'action' => 'signout',
                    'status' => 1 
                ]);
                $this->response = [
                    'success' => true,
                    'message' => 'You are logout successfully.'
                ];
                $this->statusCode = self::STATUS_CODE_200;
                return $this->sendResponse();
            }

            $this->statusCode = self::STATUS_CODE_200;
            $this->response = ['success' => true, 'message' => 'You are logout successfully.'];
            return $this->sendResponse();
        }

        public function customer_logout(Request $request) {

            $user = Customer::where('auth_token', $request->header('Authorization'))->first();
            if ($user) {
                Customer::where('id', $user->id)->update(['auth_token' => '', 'notification_token' => '']);
            /*UserActivity::where(['guard_id' => $user->id, 'status' => 1])->update([
                    'signout_time' => $request->input('signout_time'),
                    'status'=> 0,
                ]);*/
                // $coordinates = ($request->input('coordinates') != null) ? $request->input('coordinates') : '';
                // $this->userActivityRepo->insert([
                //     'guard_id' => $user->id,
                //     'location' => $coordinates,
                //     'action' => 'signout',
                //     'status' => 1 
                // ]);
                $this->response = [
                    'success' => true,
                    'message' => 'You are logout successfully.'
                ];
                $this->statusCode = self::STATUS_CODE_200;
                return $this->sendResponse();
            }

            $this->statusCode = self::STATUS_CODE_200;
            $this->response = ['success' => true, 'message' => 'You are logout successfully.'];
            return $this->sendResponse();
        }

        public function update_security_license(Request $request, $id)
        {
            $this->request = $request;
            $update_flag = false;
            if ($this->request->input('security_license') != '' && $this->request->input('security_license') != null) {
                $data['security_license_file'] = $this->uploader_base64($this->request->input('security_license'));
                $update_flag = true;
            }
            if ($this->request->input('security_license_back') != '' && $this->request->input('security_license_back') != null) {
                $data['security_license_file_back'] = $this->uploader_base64($this->request->input('security_license_back'));
                $update_flag = true;
            }
            if ($this->request->input('security_license_number') != '' && $this->request->input('security_license_number') != null) {
                $data['security_license_number'] = $this->request->input('security_license_number');
                $update_flag = true;
            }
            if ($this->request->input('security_license_expiration') != '' && $this->request->input('security_license_expiration') != null) {
                $data['security_license_expiration'] = $this->request->input('security_license_expiration');
                $update_flag = true;
            }
            if($update_flag){
                DB::table('guards')->where('id', $id)->update($data);    

                $this->statusCode = self::STATUS_CODE_200;
                $this->response = [
                    'success' => true,
                    'message' => 'Security License updated successfully!'
                ];
                return $this->sendResponse();
            }
            $this->statusCode = self::STATUS_CODE_200;
            $this->response = [
                'success' => true,
                'message' => 'Nothing to update.'
            ];
            return $this->sendResponse();


        }

        public function update_profile(Request $request, $id) {
            $this->request = $request;
            $data = array();

            $update_flag = false;

            if ($request->has('userType') && $request->input('userType') == 'customer') {
                if($this->request->input('password') != 'default' && $this->request->input('password') != ''){
                    $data['password'] = Hash::make($this->request->input('password'));
                    $update_flag = true;
                    if($update_flag){
                        DB::table('customers')->where('id', $id)->update($data);    

                        $this->statusCode = self::STATUS_CODE_200;
                        $this->response = [
                            'success' => true,
                            'message' => 'Profile updated successfully!'
                        ];
                        return $this->sendResponse();
                    }
                }

            }else{

                $destinationPath =  rtrim(app()->basePath('public/assets_uploads/'), '');



                $myfile = fopen($destinationPath . "request_log-".time().".txt", "w") or die("Unable to open file!");
                $txt = json_encode($request);
                fwrite($myfile, $txt);
                fclose($myfile);







                if($this->request->input('password') != 'default' && $this->request->input('password') != ''){
                    $data['password'] = Hash::make($this->request->input('password'));
                    $update_flag = true;
                }


                if ($this->request->input('profile_image') != '' && $this->request->input('profile_image') != null) {
                    $data['profile_image'] = $this->uploader_base64($this->request->input('profile_image'));
                    $update_flag = true;
                }


                if ($this->request->input('security_license') != '' && $this->request->input('security_license') != null) {
                    $data['security_license_file'] = $this->uploader_base64($this->request->input('security_license'));
                    $update_flag = true;
                }


                if ($this->request->input('driver_license') != '' && $this->request->input('driver_license') != null) {
                    $data['driver_license_file'] = $this->uploader_base64($this->request->input('driver_license'));
                    $update_flag = true;
                }


                if ($this->request->input('visa') != '' && $this->request->input('visa') != null) {
                    $data['visa_file'] = $this->uploader_base64($this->request->input('visa'));
                    $update_flag = true;
                }
                if ($this->request->input('passport') != '' && $this->request->input('passport') != null) {
                    $data['passport_file'] = $this->uploader_base64($this->request->input('passport'));
                    $update_flag = true;
                }


                if($update_flag){
                    DB::table('guards')->where('id', $id)->update($data);    

                    $this->statusCode = self::STATUS_CODE_200;
                    $this->response = [
                        'success' => true,
                        'message' => 'Profile updated successfully!'
                    ];
                    return $this->sendResponse();
                }
            }



            $this->statusCode = self::STATUS_CODE_200;
            $this->response = [
                'success' => true,
                'message' => 'Nothing to update.'
            ];
            return $this->sendResponse();

        }



        public function update_notification_token(Request $request, $id) {




            $this->request = $request;


            $data = array('notification_token' => $this->request->input('notification_token'));


            DB::table('guards')->where('id', $id)->update($data);    

            $this->statusCode = self::STATUS_CODE_200;
            $this->response = [
                'success' => true,
                'message' => 'Token updated successfully!'
            ];
            return $this->sendResponse();


        }


        private function uploader_base64($file) {
            try {
            // $destinationPath =  rtrim(app()->basePath('public/assets_uploads/'), '');
            // $destinationPath =  rtrim('../../assets_uploads/');
                $public_path = public_path();
                $public_path = str_replace('portal/public', '', $public_path);
                $public_path = str_replace('apis/public', '', $public_path);
                $destinationPath = $public_path.'assets_uploads/';

                $newName = Str::random(25);

                $fileName = $newName . '.jpg';


                $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
                file_put_contents($destinationPath.$fileName, $file);

                return $fileName;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }



        public function get_profile_info(Request $request, $id) {
            if ($request->has('userType') && $request->input('userType') == 'customer') {
                $user = Customer::where('id', $id)->first();
                if($user){
                    return new CustomerResource($user);
                }
            }

            $user = User::where('id', $id)->first();

            if($user){
                return new UserResource($user);
            }

            $this->statusCode = self::STATUS_CODE_200;
            $this->response = ['success' => false, 'error' => ''];
            return $this->sendResponse();
        }

        function sendMail($user, $activationCode, $plainPassword) {

            $root= $_SERVER['HTTP_HOST'];
            $root = explode('.', $root);
            $postfix = 'staffingsolution';
            if($root[0] != 'wwww'){
                $postfix = $root[0];
            }else{
                $postfix = $root[1];
            }
            $config_data = DB::connection('mysql2')->table('business_data')->where('hide', 0)->where('domain', '=', $postfix)->first();

            $to = $user['email'];

            $subject = 'Account Activation '.$config_data->title;

          // $from = 'no-reply@'.$_SERVER['HTTP_HOST'];
            $from = $postfix.'@247staffingsolution.com.au';
            if ($config_data->package == 'ci') {
                $link = 'https://'.$_SERVER['HTTP_HOST'] . '/portal/index.php/guard/activation/'.$activationCode;
            }else{
                $link = 'https://'.$_SERVER['HTTP_HOST'] . '/portal/guard_activation/'.$activationCode;
            }

            $link = str_replace('api', 'portal', $link);

            $logo1 = 'https://'.$_SERVER['HTTP_HOST'] . '/portal/'. $config_data->logo;

            $logo2 = 'https://'.$_SERVER['HTTP_HOST']."/portal/files/email-template/ASIAL-Member-Logo-11.png";

            $logo3 = 'https://'.$_SERVER['HTTP_HOST']."/portal/files/email-template/labour-hire-authority-post-banner-1.jpg";



  // To send HTML mail, the Content-type header must be set

            $headers  = 'MIME-Version: 1.0' . "\r\n";

            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



  // Create email headers

            $headers .= 'From: '.$from."\r\n".

            'Reply-To: '.$from."\r\n" .

            'X-Mailer: PHP/' . phpversion();



          // Compose a simple HTML email message

            $message = 'Hello '. $user['name'] . ',<br><br>';

            $message .= 'Thanks for registering with '.$config_data->title.'. Below, please see your username & temporary password. Click on the below-given link to complete your registration. Please fill & upload all required field & documents.<br><br>';



            $message .= 'Username: '. $user['email'] .'<br>';

            $message .= 'Password: '. $plainPassword .'<br><br>';

            $message .= 'Activate your account from following link:<br><br>';

            $message .= '<a href="'.$link.'">'. $link .'</a><br><br><br>';

            $message .= '<span style="color:blue;">Kind Regards,</span><br><br>';

            $message .= '<span style="color:blue;">Admin<span><br><br>';

            $message .= '<span style="font-size:large;font-weight:bold;color:black;">'.$config_data->title.' Pty Ltd<span><br>';

            $message .= '<span style="font-size:small;font-weight:bold;">A: '.$config_data->address.'<span><br>';

            $message .= '<span style="font-weight:bold;">W: https://'.$_SERVER['HTTP_HOST'] . '/portal<span><br>';
            // echo $message;
            // exit(); 

            // $message .= '<img src="'.$logo1.'" style="width:33%;float:left;"/>';

            // $message .= '<img src="'.$logo2.'" style="width:33%;float:left;"/>';

            // $message .= '<img src="'.$logo3.'" style="width:33%;float:left;padding-top:2.5rem;"/>';



  // Sending email
            try{
              mail($to, $subject, $message, $headers);
          }catch(Exception $e)
          {

          }
      }



      function sendMail_forgot($user,$apikey ) {

        $root= $_SERVER['HTTP_HOST'];
        $root = explode('.', $root);
        $postfix = 'staffingsolution';
        if($root[0] != 'wwww'){
            $postfix = $root[0];
        }else{
            $postfix = $root[1];
        }
        $config_data = DB::connection('mysql2')->table('business_data')->where('domain', '=', $postfix)->where('hide', 0)->first();

        $to = $user->email;

        $subject = 'Forgot Password '.$config_data->title;

          // $from = 'no-reply@'.$_SERVER['HTTP_HOST'];
        $from = $postfix . '@247staffingsolution.com.au';
        if ($config_data->package == 'ci') {
          $link = 'https://'.$_SERVER['HTTP_HOST'] . '/portal/index.php/administrator/user/forgot_password?token='.$apikey.'&userid='.$user['id'];
      }else{
          $link = 'https://'.$_SERVER['HTTP_HOST'] . '/portal/reset_gaurd_password/'.$apikey;
      }

      $link = str_replace('api', 'portal', $link);

      $logo1 = 'https://'.$_SERVER['HTTP_HOST'] . '/uploads/'. $config_data->logo;

      $logo2 = 'https://'.$_SERVER['HTTP_HOST']."/portal/files/email-template/ASIAL-Member-Logo-11.png";

      $logo3 = 'https://'.$_SERVER['HTTP_HOST']."/portal/files/email-template/labour-hire-authority-post-banner-1.jpg";



  // To send HTML mail, the Content-type header must be set

      $headers  = 'MIME-Version: 1.0' . "\r\n";

      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



        // Create email headers

      $headers .= 'From: ' . $from . "\r\n" .

      'Reply-To: ' . $from . "\r\n" .

      'X-Mailer: PHP/' . phpversion();



          // Compose a simple HTML email message

      $message = 'Hello '. $user->name . ',<br><br>';

      $message .= 'Someone requested to change the password for the following account.';

      $message .='<br> Click on the below-given link to reset your password. <br><br>';



      $message .='.<br><br>';

      $message .= '<a href="'.$link.'">'. $link .'</a><br><br><br>';

      $message .= '<span style="color:blue;">Kind Regards,</span><br><br>';

      $message .= '<span style="color:blue;">Admin<span><br><br>';

      $message .= '<span style="font-size:large;font-weight:bold;color:black;">'.$config_data->title.' Pty Ltd<span><br>';

      $message .= '<span style="font-size:small;font-weight:bold;">A:'. $config_data->address.'<span><br>';

      $message .= '<span style="font-weight:bold;">W: https://'.$_SERVER['HTTP_HOST'] . '/portal</span><br>';
    //   $message .= '<img src="'.$logo1.'" style="width:33%;float:left;"/>';

    //   $message .= '<img src="'.$logo2.'" style="width:33%;float:left;"/>';

    //   $message .= '<img src="'.$logo3.'" style="width:33%;float:left;padding-top:2.5rem;"/>';

  // Sending email
      try{
          mail($to, $subject, $message, $headers);
        //   echo "I am on";
        //   exit();
          return true;
      }catch(Exception $e)
      {
        return false;
    }
}

function verifyGuardDocument(Request $request)
{
    $url = "https://www.lars.police.vic.gov.au/LARS/LARS.asp?File=/Components/Screens/PSINFP03/PSINFP03.asp?Process=SEARCH";
    $input_xml = "<XML><HEADER><PROCESS>SEARCH</PROCESS><TIMESTAMP>20211020043340</TIMESTAMP><SECURITYTOKEN>02A42A1B-588D-4EE8-8760-2A81E6221A9A</SECURITYTOKEN></HEADER><PAYLOAD><GNDTLE01 id='idSearchPane'><CONTROL name='dropdownlist'>%</CONTROL><CONTROL name='searchtext'></CONTROL><CONTROL name='SearchCriteriadropdownlist'>X</CONTROL><CONTROL name='SearchAuthNb'>".$request->license_number."</CONTROL><CONTROL name='Index'></CONTROL><CONTROL name='Page'>1</CONTROL></GNDTLE01></PAYLOAD></XML>";

        // new here
    $headers = array(
        "Content-type: text/xml",
        "Content-length: " . strlen($input_xml),
        "Connection: close",
    );

    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $data = curl_exec($ch); 
    curl_close($ch);

    if (strpos($data, 'No Results Found')) {
        return response()->json(['success' => false, 'message' => 'Sorry! Your license is not valid according to LRD Victoria Database.']);
    }else{
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
        // return response()->json(['success' => true, 'message' => 'Congrats! Your License is valid and verified from the LRD Victoria Database.', 'expiry' => $data[4]]); 
                $this->response = ['status' => true, 'message' => 'Congrats! Your License is valid and verified from the LRD Victoria Database.', 'expiry' => $data[4]];
                $this->statusCode = self::STATUS_CODE_200;
                return $this->sendResponse(); 
            }else{
                $this->response = ['status' => false, 'message' => 'Sorry! Your license is not valid according to LRD Victoria Database.'];
                $this->statusCode = self::STATUS_CODE_200;
                return $this->sendResponse(); 
    // return response()->json(['success' => false, 'message' => 'Sorry! Your license is not valid according to LRD Victoria Database.']);
            }

        }else
        {
            $this->response = ['status' => false, 'message' => 'Sorry! Your license is not valid according to LRD Victoria Database.'];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse(); 
// return response()->json(['success' => false, 'message' => 'Sorry! Your license is not valid according to LRD Victoria Database.']);
        }


    }

}
public function deleteUser(Request $request) 
{
    $this->request = $request;
    $this->setValidationRules(['id' => 'required']);
    if ($this->isValidRequest()) {
        $this->response = ['success' => false, 'error' => $this->getErrors()];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
    if ($request->has('userType') && $request->input('userType') == 'customer') {
        $user =Customer::where('id', $request->input('id'))->update(['status' => 'deleted']);
    }else{
        $user = User::where('id', $request->input('id'))->update(['status' => 'deleted']);
    }

    if($user) {
        $this->response = ['status' => true, 'message' => 'Your account is deleted successfully.'];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
    $this->response = ['status' => false, 'error' => 'Fail to delete your account!'];
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}

public function switchAccount(Request $request) {

    $this->request = $request;
    $this->setValidationRules(['email' => 'required|email']);
    if ($this->isValidRequest()) {
        $this->response = ['success' => false, 'error' => $this->getErrors()];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }

    $user = User::where('email', $request->input('email'))->first();
    if($user && $user->status !== User::ACTIVE_STATUS) {
        $this->response = ['status' => false, 'error' => 'Your account is inactive please contact your Administrator.'];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }

    if($user){

        $apikey = base64_encode(Str::random(64).time());
        $coordinates = ($request->input('coordinates') != null) ? $request->input('coordinates') : '';
            // comment by mohsin so user token will not update on each login request. 21/08/2021
            // User::where('email', $request->input('email'))->update(['auth_token' => "$apikey"]);
        $user = User::where('email', $request->input('email'))->first();
            // if ($user->auth_token == '') {
        User::where('email', $request->input('email'))->update(['auth_token' => "$apikey"]);
        $user->auth_token = $apikey;
            // }
            // UserActivity::where('guard_id', $user->id)->update(['status' => 0]);
            // $this->userActivityRepo->insert([
            //     'guard_id' => $user->id,
            //     'signin_time' => $this->request->input('signin_time'),
            //     'location'=> $this->request->input('location'),
            //     'status'=> 1,
            // ]);
        $this->userActivityRepo->insert([
            'guard_id' => $user->id,
            'location' => $coordinates,
            'action' => 'signin',
            'status' => 1 
        ]);
        $root= $_SERVER['HTTP_HOST'];
        $root = explode('.', $root);
        $postfix = 'staffingsolution';
        if($root[0] != 'wwww'){
            $postfix = $root[0];
        }else{
            $postfix = $root[1];
        }
        $config_data = DB::connection('mysql2')->table('business_data')->where('hide', 0)->where('domain', '=', $postfix)->first();
        if (!empty($config_data) && $config_data->business_type == 'demo') {
            $user->switch_account = true;
            $switch_businesses = DB::connection('mysql2')->table('business_data')->where('hide', 0)->where('domain', '!=', $postfix)->where('business_type', 'demo')->get();
            foreach ($switch_businesses as $key => $b) {
                Config::set("database.connections.mysql2", [
                    "host" => env('DB_HOST'),
                    "database" => env('DB_DATABASE', 'staffingsolution_'.$b->domain),
                    "username" => env('DB_USERNAME'),
                    "password" => env('DB_PASSWORD'),
                    'driver' => 'mysql',
                    "port" => '3306',
                    'charset'   => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix'    => '',
                    'strict'    => true,
                ]);
                DB::purge('mysql2');
                DB::setDefaultConnection('mysql2');
                $is_in = DB::connection('mysql2')->table('guards')->where('email', $request->input('email'))->first();
                if (empty($is_in)) {
                    unset($switch_businesses[$key]);
                }
            }
            $user->businesses = $switch_businesses;
        }else{
            $user->switch_account = false;
            $user->businesses = [];
        }
        return new UserResource($user);
    }
    $this->response = ['status' => false, 'error' => 'Username invalid.'];
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}



}
