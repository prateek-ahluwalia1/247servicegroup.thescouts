<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Guard\GuardCollection;
use App\Http\Resources\Guard\GuardResource;
use App\Http\Controllers\Administrator as administrator;
use App\Models\ProfileLogs;

class GuardController extends ApiController
{
    protected $timezone = array(
      'Victoria' => 'Australia/Melbourne',
      'New South Whales' => 'Australia/Sydney',
      'NSW' => 'Australia/Sydney',
      'Queensland' => 'Australia/Brisbane',
      'Tasmania' => 'Australia/Hobart',
      'Western Australia' => 'Australia/Perth',
      'South Australia' => 'Australia/Adelaide',
      'ACT' => 'Australia/Canberra'
  );
    public  $administrator;

    public function __construct(Request $request, administrator $administrator, ProfileLogs $profileLogs)
    {
        $this->administrator = $administrator;
        $this->profileLogs = $profileLogs;
    }

    public function getGuards(Request $request, $type)
    {
    	$this->request = $request;
        $query = Guard::orderBy('name', 'ASC');
        if ($type == 'active') {
        	// $query->where('status', 'active');
        	// $query->where('admin_approved', 1);
        	// $query->where('is_approved', 'yes');
            $query->where('status', 'active')
            ->where('admin_approved',1)
            ->where('is_approved', 'yes')
            ->where('address','!=','')
            ->where('phone','!=','')
            ->where('name','!=','')
            ->where('name','!=',null)
            ->where('email','!=','')
            ->where('email','!=',null)
            ->where('security_license_number','!=','')
            ->where('security_license_file','!=','');
        }
        if ($type == 'deleted') {
        	$query->where('status', 'deleted');
        }
        if ($type == 'inactive') {
        	$query->where('status', 'inactive')
            ->where('admin_approved',1)
            ->where('is_approved', 'yes')
            ->where('address','!=','')
            ->where('phone','!=','')
            ->where('name','!=','')
            ->where('name','!=',null)
            ->where('security_license_number','!=','')
            ->where('security_license_file','!=','');
        }
        if($type == 'pending'){
            $query->where('status', 'inactive')
            ->where('is_approved', 'yes')
            ->where('admin_approved', 0)
            ->where('address', '!=', '')
            ->where('phone', '!=', '')
            ->where('name', '!=', '')
            ->where('name', '!=', null)
            ->where('email', '!=', '')
            ->where('email', '!=', null)
            ->where('security_license_number', '!=', '')
            ->where('security_license_number', '!=', 'null')
            ->where('security_license_number', '!=', null)
            ->where('security_license_file', '!=', '')
            ->where('security_license_file', '!=', 'null')
            ->where('security_license_file', '!=', null);
        }
        if($type == 'new'){
            $query->where('status','=', 'inactive')
            ->where('is_approved','=', 'no')
            ->where('status','!=', 'deleted')
            ->where(function ($query1){
                $query1->where('status','!=', 'deleted')
                ->orWhere('address','')
                ->orWhere('address',null)
                ->orWhere('address','null')
                ->orWhere('security_license_number','')
                ->orWhere('security_license_number','null')
                ->orWhere('security_license_number',null)
                ->orWhere('security_license_file','')
                ->orWhere('security_license_file','null')
                ->orWhere('security_license_file',null);
            });
        }
        $gaurds = $query->get();
        if (count($gaurds) > 0) {
            return new GuardCollection(GuardResource::collection($gaurds));
        }
        $this->response = ['status' => false, 'error' => 'No guard found!'];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }

    function getActiveGuards(Request $request, $siteId)
    {
        $job = DB::table('jobs')->where('id', $siteId)->select('state')->first();
        if (!empty($job) && $job->state != '')  {
        config(['app.timezone' => $this->timezone[$job->state]]);
        date_default_timezone_set($this->timezone[$job->state]);
        }

        $guards = Guard::join('job_new_roster', 'job_new_roster.guard_id', '=', 'guards.id')
        ->where('job_new_roster.temp_start', '<=', date('Y-m-d H:i', time()))
        ->where('job_new_roster.temp_end', '>=', date('Y-m-d H:i', time()))
        ->where('job_new_roster.site_id', $siteId)
        ->select('guards.*')
        ->get();
        if (count($guards) > 0) {
            return new GuardCollection(GuardResource::collection($guards));
        }
        $this->response = ['status' => false, 'error' => 'No guard found!'];
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();   
    }

    function save_personal_form(Request $request)
    {
        $guard_data = [];
        if ($request->specific_customers_id  != null && $request->specific_customers_id  != '') {
            $guard_data['specific_customers_id'] = json_encode($request->specific_customers_id);
        }
        if ($request->has('guard_id')) {
            $data = DB::table('guards')->where('id', $request->guard_id)->get();
            $result = Guard::where(['id' => $request->guard_id])->update($guard_data);
            $action = 'guard_update';
            $this->profileLogs->guardProfileLogs($request, $data[0]);
            $this->administrator->log_user_activity($action, $data);
            if ($result) {
                $this->response = ['status' => true, 'message' => 'Guard update successfully.'];
                $this->statusCode = self::STATUS_CODE_200;
                return $this->sendResponse();
            }else{
                $this->response = ['status' => false, 'error' => 'Fail to update guard!'];
                $this->statusCode = self::STATUS_CODE_200;
                return $this->sendResponse();
            }
        }else{
            $this->response = ['status' => false, 'error' => 'No guard found!'];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }
    }

    function restsoreDeletedGuard(Request $request, $id)
    {
        $result = Guard::where(['id' => $id])->update(['status' => 'inactive', 'admin_approved' => 0]);
        if ($result) {
            $this->response = ['status' => true, 'message' => 'Guard update successfully.'];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }else{
            $this->response = ['status' => false, 'error' => 'Fail to update guard!'];
            $this->statusCode = self::STATUS_CODE_200;
            return $this->sendResponse();
        }
    }
}
