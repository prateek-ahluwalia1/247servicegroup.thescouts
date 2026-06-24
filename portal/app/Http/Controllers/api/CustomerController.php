<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Job;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Customer\CustomerCollection;
use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Customer\JobCollection;
use App\Http\Resources\Customer\JobResource;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Administrator as administrator;

class CustomerController extends ApiController
{

public  $administrator;

    public function __construct(Request $request, administrator $administrator)
    {
        $this->administrator = $administrator;
    }

    function adminSpecificPermissions($admin_id)
    {
        $admin = DB::table('administrators')->where('id', $admin_id)->select('specific_customer', 'specific_sites', 'is_super_admin')->first();
        if($admin->is_super_admin == 0){
            if ($admin->specific_customer != '') {
                $admin->specific_customer = json_decode($admin->specific_customer, true);
            } 
            if ($admin->specific_sites != '') {
                $admin->specific_sites = json_decode($admin->specific_sites, true);
            }   

        }
        return $admin;
 }

 public function getCustomers(Request $request)
 {   
    // $admin = $this->adminSpecificPermissions($request->admin_id);
    $admin = DB::table('administrators')->where(['id' => $request->admin_id, 'status'=>'active'])->select('specific_customer', 'specific_sites', 'is_super_admin')->first();
    if($admin){
        if($admin->is_super_admin == 0){
            if ($admin->specific_customer != '') {
                $specific_customers = json_decode($admin->specific_customer, true);
            } 
            // if ($admin->specific_sites != '') {
            //     $specific_sites = json_decode($admin->specific_sites, true);
            // }   
            $customers = [];
            $sites = [];
            if (!empty($specific_customers) && $specific_customers != null) {
                foreach ($specific_customers as $key => $id) {
                    $customer = Customer::find($id);
                    if($customer){
                        $customers[] = $customer;
                    }
                }
            }else{
                $customers = Customer::where('status', 'active')->get();
            }
            // if (!empty($specific_sites) && $specific_customers != null) {
            //     foreach ($specific_sites as $key => $id) {
            //         $job = Job::find($id);
            //         if($job){
            //             $sites[] = $job;
            //         }
            //     }
            // }
            return response()->json([
                'status' => 'OK',
                'customers' => CustomerResource::collection($customers),
                // 'sites' => JobResource::collection($sites)
            ]);
        }else{
            $customers = Customer::where('status', 'active')->get();
            $sites = Job::get();
            return response()->json([
                'status' => 'OK',
                'customers' => CustomerResource::collection($customers),
                // 'sites' => JobResource::collection($sites)
            ]);
        }
    }else{
        return response()->json([
            'status' => 'OK',
            'success' => 'false',
            'message' => 'Data not found',
        ]);
    }
    // $query = Customer::where('status', 'active');
    // if ($request->has('admin_id') && $request->admin_id != '') {
    //     $admin = $this->adminSpecificPermissions($request->admin_id);
    //     $specific_customers = $admin->specific_customer;
    //     if (is_array($specific_customers) && !empty($specific_customers)) {
    //         $query->where(function($q) use ($specific_customers){
    //             foreach ($specific_customers as $key => $id) {
    //                 if ($key == 0) {
    //                     $q->where('id', $id);
    //                 }else{
    //                     $q->orWhere('id', $id);
    //                 }
    //             }
    //         });
    //     }
    // }
    // $customers  = $query->get();
    // if (count($customers) > 0) {
    //     return new CustomerCollection(CustomerResource::collection($customers));
    // }
    // $this->response = ['status' => false, 'error' => 'No Customer Found!'];
    // $this->statusCode = self::STATUS_CODE_200;
    // return $this->sendResponse();
}

public function getCustomerSites(Request $request){
    $admin = DB::table('administrators')->where(['id' => $request->admin_id, 'status'=>'active'])->select('specific_customer', 'specific_sites', 'is_super_admin')->first();
    $start = strtotime($request->start);
    $end = strtotime($request->end) + 60*60*24;
    if($admin){
        // if($admin->is_super_admin == 0){
        //     if ($admin->specific_sites != '') {
        //         $specific_sites = json_decode($admin->specific_sites, true);
        //     }   
        //     $sites = [];
        //     if (!empty($specific_sites) && $specific_sites != null) {
        //         foreach ($specific_sites as $key => $id) {
        //             $job = Job::find($id);
        //             if($job){
        //                 $sites[] = $job;
        //             }
        //         }
        //     }else{
        //         $sites = Job::where('status', 'active')->get();
        //     }
        //     $active_sites = array();
        //     foreach ($sites as $key => $site) {
        //         // return $site->;
        //             $shift = DB::table('job_new_roster')
        //             ->where('site_id', $site['id'])
        //             ->where('temp_start', '>=', date('Y-m-d H:i', $start))
        //             ->where('temp_end', '<=', date('Y-m-d H:i', $end))
        //             ->first();
        //             if (!empty($shift)) {
        //                 $active_sites[] = $site;
        //             }
        //     }
        //     return response()->json([
        //         'status' => 'OK',
        //         'data' => JobResource::collection($active_sites)
        //     ],200);
        // }else{
            $customerId = $request->customerId;
            $query = Job::where(function ($query) use ($customerId){
            foreach ($customerId as $key => $cid) {
                if ($key == 0) {
                    $query->where('customer_id', $cid);
                }else{
                    $query->orWhere('customer_id', $cid);
                }
            }
            });
            $active_sites = $query->where('status', 'active');
            if (!empty($request->state)) {
                $active_sites->where('state', $request->state);
            }
            $active_sites = $active_sites->get();
            // $active_sites = array();
            // foreach ($sites as $key => $site) {
            //         $shift = DB::table('job_new_roster')
            //         ->where('site_id', $site->id)
            //         ->where('temp_start', '>=', date('Y-m-d H:i', $start))
            //         ->where('temp_end', '<=', date('Y-m-d H:i', $end))
            //         ->first();
            //         if (!empty($shift)) {
            //             $active_sites[] = $site;
            //         }
            // }
            return response()->json([
                'status' => 'OK',
                'data' => JobResource::collection($active_sites)
            ], 200);
        // }
    }else{
        return response()->json([
            'status' => 'OK',
            'success' => 'false',
            'message' => 'Data not found',
        ]);
    }
}
// public function getCustomerSites(Request $request)
// {
//    $this->request = $request;
// //    $this->setValidationRules(['customerId' => 'required']);
// //    if ($this->isValidRequest()) {
// //     $this->response = ['success' => false, 'error' => $this->getErrors()];
// //     $this->statusCode = self::STATUS_CODE_200;
// //     return $this->sendResponse();
// // }
// $customerId = $request->customerId;
// $start = strtotime($request->start);
// $end = strtotime($request->end) + 60*60*24;
// $query = Job::where(function ($query) use ($customerId){
//    foreach ($customerId as $key => $cid) {
//       if ($key == 0) {
//          $query->where('customer_id', $cid);
//      }else{
//          $query->orWhere('customer_id', $cid);
//      }
//  }
// });
// // 
// // if ($request->has('admin_id') && $request->admin_id != '') {
// //     $admin = $this->adminSpecificPermissions($request->admin_id);
// //     $specific_sites = $admin->specific_sites;
// //     if (is_array($specific_sites) && !empty($specific_sites)) {
// //         $query->where(function($q) use ($specific_sites){
// //             foreach ($specific_sites as $key => $id) {
// //                 if ($key == 0) {
// //                     $q->where('id', $id);
// //                 }else{
// //                     $q->orWhere('id', $id);
// //                 }
// //             }
// //         });
// //     }
// // }
// $sites = $query->where('status', 'active')
//         // ->where('state', $request->state)
// ->get();
// $active_sites = array();
// foreach ($sites as $key => $site) {
//             // $shift = DB::table('job_new_roster')
//             // ->where('site_id', $site->id)
//             // ->where('temp_start', '>=', date('Y-m-d H:i', $start))
//             // ->where('temp_end', '<=', date('Y-m-d H:i', $end))
//             // ->first();
//             // if (!empty($shift)) {
//     $active_sites[] = $site;
//             // }
// }
// if (count($active_sites) > 0) {
//     return new JobCollection(JobResource::collection($active_sites));
// }else{
//     return new JobCollection(JobResource::collection(Job::where('status', 'active')->get()));
// }
// $this->response = ['status' => false, 'error' => 'No site Found!'];
// $this->statusCode = self::STATUS_CODE_200;
// return $this->sendResponse();
// }
public function editUser($id, Request $request)
{
    if ($request->has('admin_id') && $request->admin_id != '') {
        session([
            'userId' => $request->admin_id,
        ]);
    }
    if ($request->has('admin_id') && $request->admin_id != '') {

        session([
          'userId' => $request->admin_id,
      ]);
    }
    // $data=  DB::table('customers')->where('id', $id)->first();
    $data = [];
    if($request->hasFile('image')){
        $image = $request->file('image');
        $filename = time().'.'.$image->getClientOriginalExtension();
        $public_path = public_path();
        $public_path = str_replace('portal/public', '', $public_path);
        $public_path = str_replace('apis/public', '', $public_path);
        $destinationPath = $public_path.'asset_uploads/';
        $save = $image->move($destinationPath, $filename);
    }else{
        $filename = DB::table('customers')->where('id', $id)->value('image');
    }
    $data['image'] = $filename;
    if($request->has('name')){
        $data['name'] = $request->name;
    }
    if($request->has('phone')){
        $data['phone'] = $request->phone;
    }
    if($request->has('state')){
        $data['state'] = $request->state;
    }
    if($request->has('address')){
        $data['address'] = $request->address;
    }
    if($request->has('city')){
        $data['city'] = $request->city;
    }
    if($request->has('postal_code')){
        $data['postal_code'] = $request->postal_code;
    }
    // $data['status'] = $request->status;
    $query=  DB::table('customers')
    ->where('id', $id)
    ->update($data);
    if($query){
        $action = 'customer_update';
        $this->administrator->log_user_activity($action, $data);
        $this->response = ['status' => true, 'message' => 'Profile update successfully.'];
    }else{
        $this->response = ['status' => false, 'error' => 'Fail to update profile!'];
    }
    $this->statusCode = self::STATUS_CODE_200;
    return $this->sendResponse();
}

public function deleteUser($id, Request $request){
    if ($request->has('admin_id') && $request->admin_id != '') {
        session([
            'userId' => $request->admin_id,
        ]);
    }
 $data=  DB::table('customers')->where('id', $id)->first();
 $query=  DB::table('customers')->where('id', $id)->update(['status' => "deleted"]);
 if($query){
    $action = 'customer_delete';
    $this->administrator->log_user_activity($action, $data);
    $this->response = ['status' => true, 'message' => 'Profile deleted successfully.'];
}else{
    $this->response = ['status' => false, 'error' => 'Fail to delete profile!'];
}
$this->statusCode = self::STATUS_CODE_200;
return $this->sendResponse();
}
}
