<?php
namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class GeneralController extends ApiController
{

    public $currentUser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        

    }

    public function list_tutorials() {
            $logged_user_id = ($this->currentUser) ? $this->currentUser->id : '';
        
            $tutorials = DB::table('tutorials')->where('status', 'active')->get();
            foreach ($tutorials as $key => $tut) {
                $is_in = false;
                if ($tut->selected_guards != '') {
                    $guards = json_decode($tut->selected_guards, true);
                    if (is_array($guards)) {
                    foreach ($guards as $index => $guard_id) {
                        if ($logged_user_id == $guard_id) {
                            $is_in = true;
                        }
                    }
                    }else{
                        $is_in = true;
                    }
                }
                if ($is_in != true) {
                    unset($tutorials[$key]);
                }
            }
            $this->statusCode = self::STATUS_CODE_200;
            if (count($tutorials) == 0) {
                $this->response = [
                'success' => false,
                'message' => 'No announcements found!',
                'tutorials' => $tutorials
            ];
            }else{
                $tut = array();
                foreach ($tutorials as $key => $t) {
                    $tut[] = $t;
                }
               $this->response = [
                'success' => true,
                'message' => 'List of tutorials.',
                'tutorials' => $tut
            ]; 
            }
            return $this->sendResponse();
        
        
    }
    function get_chat_user_list()
    {
        $chat_user = DB::table('app_basic_settings')->first();
         $this->statusCode = self::STATUS_CODE_200;
            if (empty($chat_user)) {
                $this->response = [
                'success' => false,
                'message' => 'No chat user found',
                'users' => array()
            ];
            }else{
               $this->response = [
                'success' => true,
                'message' => 'List of chat user',
                'users' => array(
                    'admin_user' => DB::table('administrators')->where('id', $chat_user->admin_user)->select('id', 'name')->first(),
                    'operations_user' => DB::table('administrators')->where('id', $chat_user->operations_user)->select('id', 'name')->first(),
                    'hr_user' => DB::table('administrators')->where('id', $chat_user->hr_user)->select('id', 'name')->first(),
                    'payroll_user' => DB::table('administrators')->where('id', $chat_user->payroll_user)->select('id', 'name')->first(),
                )
            ]; 
            }
            return $this->sendResponse();
    }

    public function list_inductions() {
        
            $inductions = DB::table('inductions')->where('status', 'active')->get();
            $logged_user_id = ($this->currentUser) ? $this->currentUser->id : '';
            $new_induction = array();
            foreach ($inductions as $key => $induction) {
                $image = DB::table('induction_image')->where(['guard_id' => $logged_user_id, 'induction_id' => $induction->id])->orderBy('id', 'desc')->first();
                if (!empty($image)) {
                    $induction->image = 'https://'.request()->getHttpHost().'/asset_uploads/'.$image->image;
                }else{
                    $induction->image = '';
                }
                $is_in = false;
                if ($induction->selected_guards != '') {
                    $guards = json_decode($induction->selected_guards, true);
                    if (is_array($guards)) {
                    foreach ($guards as $index => $guard_id) {
                        if ($logged_user_id == $guard_id) {
                            $is_in = true;
                        }
                    }
                    }else{
                        if ($induction->selected_guards == $logged_user_id) {
                            $is_in = true;
                        }
                    }
                }
                if ($is_in == true) {
                $new_induction[] = $induction;
                }
            }
            
            $this->statusCode = self::STATUS_CODE_200;
            if (count($new_induction) == 0) {
                $this->response = [
                'success' => false,
                'message' => 'No inductions found!',
                'tutorials' => $new_induction
            ];
            }else{
            $this->response = [
                'success' => true,
                'message' => 'List of inductions.',
                'inductions' => $new_induction
            ];
            }
            return $this->sendResponse();
    }


    public function list_about_us() {
        
            $about_us_list = DB::table('about_company')->get();

            $this->statusCode = self::STATUS_CODE_200;
            $this->response = [
                'success' => true,
                'message' => 'List of about us.',
                'about_us_list' => $about_us_list
            ];
            return $this->sendResponse();
    }

    private function uploader_base64($file) {
        try {
            // $destinationPath =  rtrim(app()->basePath('public/asset_uploads/'), '');
    //         try{
    //         $public_path = public_path();
    //     $public_path = str_replace('portal/public', '', $public_path);
    //     $public_path = str_replace('apis/public', '', $public_path);
    //     $destinationPath = $public_path.'asset_uploads/';
    // }catch(Exception $e){
            $destinationPath =  rtrim('../../asset_uploads/');
        // }
            
            $newName = Str::random(25);
            
            $fileName = $newName . '.jpg';
            
        
            $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
            file_put_contents($destinationPath.$fileName, $file);
      
            return $fileName;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    private function publicPath()
    {
        $public_path = app()->basePath('public');
        $public_path = str_replace('portal/public', '', $public_path);
        $public_path = str_replace('apis/public', '', $public_path);
        
        return $public_path;
    }
    private function getBaseUrl()
    {
        $url = app()->make('request')->root();
        $url = str_replace('portal/public', '', $url);
        $url = str_replace('apis/public', '', $url);
    
        return $url;
    }
    public function uploadImage(Request $request){
        try {
            $base64Image = $request->file; // Assuming the base64 image is passed in 'image' parameter
            $image = $this->saveBase64Image($base64Image);

            return response()->json(['success'=>true,'url' => $image], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    private function saveBase64Image($base64Image)
    {
        $public_path = $this->publicPath();
        $destinationPath = $public_path . 'asset_uploads/';
        $newName = Str::random(25);
        $fileName = $newName . '.png';

        $fileContent = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        
        if (!$fileContent) {
            throw new \Exception('Failed to decode base64 image.');
        }

        if (!file_put_contents($destinationPath . $fileName, $fileContent)) {
            throw new \Exception('Failed to save image.');
        }

        $imageUrl = $this->getBaseUrl() . 'asset_uploads/' . $fileName;

        return $imageUrl;
    }
    public function uplaod_tutorial_image(Request $request, $id)
    {
        $field = 'image'; $media = '';
        $media = $this->uploader_base64($this->request->input($field));
        $result = DB::table('tutorial_image')->insert(array(
            'guard_id' => $id,
            'tutorial_id' => $request->input('tutorial_id'),
            'image' => $media
        ));
        if ($result) {
            $this->statusCode = self::STATUS_CODE_200;
            $this->response = [
                'success' => true,
                'message' => 'Image successfully added.'
            ];
            return $this->sendResponse();
        }
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => false,
            'message' => 'Fail to uplaod image!'
        ];
        return $this->sendResponse();
    }


    public function uplaod_induction_image(Request $request, $id)
    {
        $field = 'image'; $media = '';
        $media = $this->uploader_base64($this->request->input($field));
        $already = DB::table('induction_image')->where(['guard_id' => $id,'induction_id' => $request->input('induction_id')])->first();
        if (empty($already)) {
        $result = DB::table('induction_image')->insert(array(
            'guard_id' => $id,
            'induction_id' => $request->input('induction_id'),
            'image' => $media
        ));
        }else{
            $result = DB::table('induction_image')->where([
            'guard_id' => $id,
            'induction_id' => $request->input('induction_id')
            ])->update(['image' => $media]);
        }
        if ($result) {
            $this->statusCode = self::STATUS_CODE_200;
            $this->response = [
                'success' => true,
                'message' => 'Image successfully added.'
            ];
            return $this->sendResponse();
        }
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => false,
            'message' => 'Fail to uplaod image!'
        ];
        return $this->sendResponse();
    }

// read_induction_status

      public function read_induction_status(Request $request, $id)
    {

       $results= DB::table('induction_seen_status')->where('induction_id',$request->induction_id)->where('guard_id',$id)->where('status','seen')->first();
       if(empty($results)){
            $result = DB::table('induction_seen_status')->insert(array(
            'guard_id' => $id,
            'induction_id' => $request->input('induction_id'),
            'status' => 'seen'
        ));
          
            $this->statusCode = self::STATUS_CODE_200;
            $this->response = [
                'success' => true,
                'message' => 'Read successfully .'
            ];
            return $this->sendResponse();
       }
       else{
        $this->statusCode = self::STATUS_CODE_200;
            $this->response = [
                'success' => true,
                'message' => 'Read successfully .'
            ];
            return $this->sendResponse();
       }
        
    }



    public function get_policies(Request $request, $type)
    {
        $policy = DB::table('policies')->where('type', $type)->first();
        if ($policy) {
            $this->statusCode = self::STATUS_CODE_200;
            $this->response = [
                'success' => true,
                'message' => 'Policy Found',
                'policy' => $policy
            ];
            return $this->sendResponse();
        }
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => false,
            'message' => 'No policy found!',
            'policy' => null
        ];
        return $this->sendResponse();
    }

    public function get_demo_businesses()
    {
        $demo_businesses = DB::connection('mysql2')->table('business_data')->select('business_data.*')->get();
        // $demo_businesses = DB::connection('mysql2')->table('business_data')->where('business_type', '=', 'demo')->select('business_data.id', 'business_data.title', 'business_data.domain', 'business_data.unique_id')->get();

        if (count($demo_businesses) > 0) {
            $demo = array();
            foreach ($demo_businesses as $db) {
                $demo[] = array(
                    'title' => $db->title,
                    'subTitle' => $db->sub_title,
                    'logo' => $db->logo != '' ? 'https://'.request()->getHttpHost().'/asset_uploads/'.$db->logo : "",
                    'bundleID' => $db->bundle_id,
                    'appName' => $db->title,
                    'oneSignalAppID' => $db->app_id,
                    'oneSignalServerKey' => $db->server_key,
                    'oneSignalSenderID' => $db->one_signal_sender_id,
                    'domain'=> $db->domain,
                    'id' => $db->id,
                    'businessType' => $db->business_type,
                    // 'uniqueID' => $db->unique_id
                    'uniqueID' => $db->title
                );
            }
            $this->statusCode = self::STATUS_CODE_200;
            $this->response = [
                'success' => true,
                'message' => 'Demo business Found.',
                'data' => $demo
            ];
            return $this->sendResponse();
        }
        $this->statusCode = self::STATUS_CODE_200;
        $this->response = [
            'success' => false,
            'message' => 'No business found!',
            'data' => null
        ];
        return $this->sendResponse();
    }


}
