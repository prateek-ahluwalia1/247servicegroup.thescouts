<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Customer as customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer_payrate as customer_payrate;
use App\Models\Customer_contact as customer_contact;
use Codedge\Fpdf\Fpdf\Fpdf;
use \PDF;
use Illuminate\Support\Facades\View;
use App\Models\Charged_rate as charged_rate;
use App\Models\Guard;
use Illuminate\Support\Facades\Session;
use App\Models\ProfileLogs;


class Customers extends Controller
{
    public  $profileLogs;
    public function __construct(Request $request, ProfileLogs $profileLogs) {
        $this->profileLogs = $profileLogs;
    }
    //

    // public function customers(){
    //     $customers = customer::get();
    //     return view('admin/customers', ['customers' => $customers]);

    // }

public function customer_pdf(Request $request){
    // $role_id = $request->role;
     $customers = DB::table('customers')->where('status', 'active')->get();

     View::make('admin/customer/customer_pdf', ['customers' => $customers]);
    // exit();
     $pdf = PDF::loadView('admin/customer/customer_pdf', ['customers' => $customers]);
     return $pdf->download('customers-list.pdf');
}


public function do_login(Request $request)
{
    $apikey = base64_encode(Str::random(64).time());
    $customer = DB::table('customers')->where(['email' => $request->input('email')])->first();
     $colors = '';
    $colr = DB::table('portal_settings')->where('permission_name', 'portal_colors')->first();
    if (!empty($colr)) {
      $colors = $colr->users_emails;
    }
    if (!empty($customer) && Hash::check($request->input('password'), $customer->password)) {
        DB::table('customers')->where('id', $customer->id)->update(['auth_token' => $apikey]);
        session([
            'userId' => $customer->id,
            'userType' => 'customer', 
            'image' => $customer->image,  
            'userName' => $customer->name,  
            'authToken' => $apikey,
            'isAdmin' => 0,
            'state' =>  $customer->state,
      'colors' => $colors

        ]);
            return    redirect('dashboard');
            // return    redirect('customer_profile'. '/' .$customer->id);

    }else{
         return view('admin/customer/login');
       exit();
    }
}




public function customer(){
    if (!session()->has('userType')) {
        return view('admin/customer/login');
    }else{
        return redirect('customer_profile'. '/' .session::get('userId'));
        //  view('admin/customer/login');
     
    }

}




public function customers(){
        if (!session()->has('userType')) {
            return view('admin/login');
        }else{
            // $admins = admin::get();
            $customers = DB::table('customers')->whereIn('status', ['active','inactive'])->orderBy('name', 'ASC')->get();

            return view('admin/customers', ['customers' => $customers]);
        }

    }


     public function insertCustomer(Request $request){

        $password = Hash::make('1234568');

        $name=  $_POST['name'];
                $address1=  $_POST['address1'];

        // $address2=  $_POST['address2'];

        $city=  $_POST['city'];

        $state=  $_POST['state'];
        // $country=  $_POST['country'];

                $email=  $_POST['email'];
                $postcode =$_POST['postcode'];

        // print_r($access);
        // exit();
 $query =DB::table('customers')->insert([
    'email' => $email,
    'name' => $name,
    'password' => $password,
    'auth_token' => '',
    'phone' => '',
    'notification_token' => '',
    'timestamp_joined' => time(),
    'timestamp_activity' =>time(),
    'state' => $state,
    'address' => $address1,
    'city' => $city,
    'postal_code'=> $postcode
]);
if($query==true)
{
                return redirect('/customers')->with('msg', 'Record Added');

       // $res= admin::insert($name,$email);
}else{

                    return redirect('404');

}
    }


    public function getCustomer($id){

        $customers = DB::table('customers')->where('id', $id)->first();
        return response()->json($customers);


    }

    public function editCustomer($id){
                
        $name=  $_POST['name'];
                $address1=  $_POST['address1'];

        // $address2=  $_POST['address2'];

        $city=  $_POST['city'];

        $state=  $_POST['state'];
        // $country=  $_POST['country'];

                $email=  $_POST['email'];
                $postcode =$_POST['postcode'];

                // $access =$_POST['user_role'];


          $query=  DB::table('customers')->where('id', $id)->update(['name' => $name,'email' => $email,'address'=> $address1 , 'city'=> $city , 'state' => $state ,'postal_code'=> $postcode]);
          if($query){
                            return redirect('/customers')->with('msg', 'Record Updated');

          }

       

    }

     



public function deleteCustomer($id){
         $query=  DB::table('customers')->where('id', $id)->update(['status' => "deleted"]);
          if($query){
                            return redirect('/customers')->with('msg', 'Record Deleted');

          }
     }
public function inactiveCustomer($id){
         $query=  DB::table('customers')->where('id', $id)->update(['status' => "inactive"]);
          if($query){
                            return redirect('/customers')->with('msg', 'Record Inactivated');

          }
     }
public function activeCustomer($id){
         $query=  DB::table('customers')->where('id', $id)->update(['status' => "active"]);
          if($query){
                            return redirect('/customers')->with('msg', 'Record Activated');

          }
     }

     
     public function Customerprofile($id){
  
        $customer_id = $id;
        $customers = DB::table('customers')->where('id', $id)->get();
        $charged_rates = DB::table('customers')->where('id', $id)->select('charged_rates_id')->first();
        $charged_rates_id = $charged_rates->charged_rates_id;
        $contacts = customer_contact::where(['customer_id' => $customer_id])->get();
        return view('admin/customer/profile', ['customers' => $customers,'customer_id' => $customer_id,'charged_rates_id' => $charged_rates_id, 'contacts' => $contacts]);

   }


   function personal_data(Request $request)
{
    $customer = customer::where(['id' => $request->customer_id])->first();
    if (!empty($customer)) {
        // $guard->specific_customers_id = json_decode($guard->specific_customers_id, true);
        return response()->json(['success' => true, 'message' => "Personal Data", 'customer' => $customer]);
    }else{
        return response()->json(['success' => false, 'message' => "Payrates retrieve"]);
    }
}



   function upload_files(Request $request)
    {
        $image = $this->upload_img($request->image);
    if ($image != '') {
        return response()->json(array('success' => true, 'path' => $image));
    }else{
        return response()->json(array('success' => false, 'path' => ''));

    }
}
    function upload_img($key)
{

    $name = '';

    // $path = '../../asset_uploads/';
    $public_path = public_path();
    $public_path = str_replace('portal/public', '', $public_path);
    $public_path = str_replace('apis/public', '', $public_path);
    $path = $public_path.'asset_uploads/';

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





function save_personal_form(Request $request)
{
     // $validated = $request->validate([);
     $apikey = base64_encode(Str::random(64).time());
      $validator = Validator::make($request->all(), ['email' => 'bail|required', 'name' => 'required']);
     // $this->setValidationRules(['email' => 'required', 'password' => 'required', 'first_name' => 'required']);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => "Please enter required data!"]);
        }
    $customer_data = [
        'name' => ($request->name != null) ? $request->name : '',
        'email' => $request->email,
        'phone' => $request->phone != null ? $request->phone : '',
        'address' => $request->address,
        'city' => $request->city,
        'state' => $request->state,
        'postal_code' => $request->postalCode,
        // 'image' => $request->image,
        'url' => $request->url,
        'auth_token' => $apikey,
        'timestamp_joined' => time(),
        'timestamp_activity' => time()
    ];

    

    if ($request->image  != null && $request->image  != '') {
        $customer_data['image'] = $request->image;
    }
    if ($request->password != null && $request->password != '') {
        $customer_data['password'] = Hash::make($request->password);
    }
    if ($request->has('customer_id')) {
        $data = customer::where(['id' => $request->customer_id])->first();
        customer::where(['id' => $request->customer_id])->update($customer_data);
        $this->profileLogs->customerProfileLogs($request, $data);
       return response()->json(['success' => true, 'message' => "Details save successfully"]);
    }
    // else{
    // $check = customer::where(['email' => $customer_data['email']])->first();
    // // if (empty($check)) {
    // //     $customer_id = customer::insertGetId($customer_data);
    // //     return response()->json(['success' => true, 'message' => "Details save successfully", 'customer_id' => $customer_id]);
    // // }else{
    // //     return response()->json(['success' => false, 'error' => "User with this email:". $customer_data['email'].' already exists.']);
    // // }
    // }

}




function save_customer_payrates(Request $request)
{
    $data = [
        'flat_metro_week_day' => $request->flat_metro_week_day,
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
    ];

    $already_check = customer_payrate::where(['customer_id' => $request->customer_id, 'state' => $request->payrates_state, 'job_level' => $request->job_level])->first();
            if (empty($already_check)) {


                $data['state'] = $request->payrates_state;
                $data['job_level'] = $request->job_level;
                $data['customer_id'] = $request->customer_id;
                customer_payrate::insert($data);  
            }else{
                customer_payrate::where(['customer_id' => $request->customer_id, 'state' => $request->payrates_state, 'job_level' => $request->job_level])->update($data);  
            }
        return response()->json(['success' => true, 'message' => "Payrate data save successfully."]);
}



function get_customer_payrates(Request $request)
{
    

    $customer_payrate = customer_payrate::where(['customer_id' => $request->customer_id, 'state' => $request->state, 'job_level' => $request->job_level])->first();
    if (!empty($customer_payrate)) {
        return response()->json(['success' => true, 'message' => "Payrates retrieve", 'payrates' => $customer_payrate]);
    }else{
        return response()->json(['success' => false, 'message' => "Payrates retrieve"]);
    }
}



function save_documents_form(Request $request)
{
       $data = [
        'business_abn_can_number'  =>  $request->business_abn_can_number,
        'business_abn_can_expiration' => $request->business_abn_can_expiration,
        // '' => $guard->subselect,
        'business_abn_can_file' => $request->business_abn_can_file,
        'security_license_number' => $request->security_license_number,
        'security_license_expiration' => $request->security_license_expiration,
        'security_license_file' => $request->security_license_file,

        'public_liability_number' => $request->public_liability_number,

        'public_liability_expiration' => $request->public_liability_expiration,

        'public_liability_file' => $request->public_liability_file,

        'labour_hire_number' => $request->labour_hire_number,
        'labour_hire_expiration' => $request->labour_hire_expiration,
        'labour_hire_file' => $request->labour_hire_file

        

        

        
    ];

    if ($request->business_abn_can_file != null && $request->business_abn_can_file != '') {
        $data['business_abn_can_file'] = $request->business_abn_can_file;
    }
    if ($request->security_license_file != null && $request->security_license_file != '') {
        $data['security_license_file'] = $request->security_license_file;
    }
    if ($request->labour_hire_file != null && $request->labour_hire_file != '') {
        $data['labour_hire_file'] = $request->labour_hire_file;
    }
     if ($request->public_liability_file != null && $request->public_liability_file != '') {
        $data['public_liability_file'] = $request->public_liability_file;
    }
    
    customer::where(['id' => $request->customer_id])->update($data);
    return response()->json(['success' => true, 'message' => "Data save successfully."]);
}


function get_documents_data(Request $request)
{
    

    $documnets = customer::where(['id' => $request->customer_id])->first();
    if (!empty($documnets)) {
        return response()->json(['success' => true, 'message' => "documnets retrieve", 'documnets' => $documnets]);
    }else{
        return response()->json(['success' => false, 'message' => "documnets retrieve false"]);
    }
}





function customer_documents(Request $request)
{
    $customer = customer::where(['id' => $request->customer_id])->first();
    $documnets = [
        'business_abn_can_number'  =>  $request->business_abn_can_number,
        'business_abn_can_expiration' => $request->business_abn_can_expiration,
        // '' => $guard->subselect,
        'business_abn_can_file' => $request->business_abn_can_file,
        'security_license_number' => $request->security_license_number,
        'security_license_expiration' => $request->security_license_expiration,
        'security_license_file' => $request->security_license_file,
        'labour_hire_number' => $request->labour_hire_number,
        'labour_hire_expiration' => $request->labour_hire_expiration,
        'labour_hire_file' => $request->labour_hire_file
    ];
    return response()->json(['success' => true, 'message' => "Data retrieve successfully.", 'documnets' => $documnets]);

}




function save_contacts(Request $request)
{
    $count=$request->index_counter;
    $contacts=DB::table('customer_contacts')->where('customer_id',$request->customer_id)->get();
    // return $request->cid;
    // exit();
    $sub=0;
    if(!empty($contacts)){
        foreach($contacts as $contact){
            $sub++;
            
        for($i=0;$i<$count;$i++){
            if($request->cid[$i] !='' && $request->cid[$i] !=null && $request->cid[$i] !='null' ){
            if($request->cid[$i] == $contact->id){
                DB::table('customer_contacts')->where('id',$request->cid[$i])->update([
                    'name' => $request->contact_name[$i],
                    'phone' => $request->contact_phone[$i],
                    'email' => $request->contact_email[$i],
                    'notes' => $request->contact_notes[$i],

                ]);
            }
        }

            
        }
        }
        $rem=$count-$sub;
        // return $sub;
        // exit();
    }
    if($rem>0){
        for($i=$sub;$i<$count;$i++){
        if($request->contact_email[$i]!='' && $request->contact_email[$i]!=null && $request->contact_email[$i]!='null' ){
            $contact=  DB::table('customer_contacts')->insert([
                'customer_id' => $request->customer_id,
                'email' => $request->contact_email[$i],
                'name' => $request->contact_name[$i],
                'phone' => $request->contact_phone[$i],
                'notes' => $request->contact_notes[$i]
        ]);
        }
    }
    }

         return response()->json(['success' => true, 'message' => "Contacts data save successfully."]);


}
function get_contacts(Request $request)
{
    
    $contacts = customer_contact::where(['customer_id' => $request->customer_id])->get();
    
    if (!empty($contacts)) {
    $ids = $contacts->count();
    return response()->json(['success' => true, 'message' => "contacts found", 'indexs' => $ids,'contacts' => $contacts]);
    }
  else{
        return response()->json(['success' => false, 'error' => "No contacts."]);
    }
   
}

function contacts_form(Request $request)
{
    // $contacts =$g_contacts;
    $ids_html =  view('admin/customer/edit-customer/contact_form', ['indexs' => $request->index])->render();
    return response()->json($ids_html);
    
}

function get_customers(Request $request){

        $flag = false;
        $message = 'Data received';
        $data = array();
        $specific_sites_id = array();
        $user_type = session()->get('userType');

        
        if($user_type == 'customer'){
            // $this->db->where('id =', $current_login_customer);
            $customers = customer::where('status', 'active')->where('id', session()->get('userId'))->get();
        }elseif(session()->get('userType') == 'contractor'){
            $contractor_id = session()->get('userId');
            $guards = Guard::where('contractor_id', $contractor_id)->get();
            $guardsIds = Guard::where('contractor_id', $contractor_id)->pluck('id');
            $rosters = DB::table('job_new_roster')->whereIn('guard_id', $guardsIds)->groupBy('site_id')->pluck('site_id');
            $jobs = DB::table('jobs')->whereIn('id', $rosters)->groupBy('customer_id')->pluck('customer_id');
            $customers = DB::table('customers')->whereIn('id', $jobs)->where('status', 'active')->get();
        }
        else{
            $cust_query = customer::where('status', 'active');
            if (session()->has('specific_customer') && session()->get('specific_customer') != '') {
                $specific_customer = json_decode(session()->get('specific_customer'));
                $cust_query->where(function($query)  use($specific_customer){
                    foreach ($specific_customer as $key => $id) {
                        if ($key == 0) {
                            $query->where('id', $id);
                        }else{
                            $query->orWhere('id', $id);
                        }
                    }
                });
            }
            $customers = $cust_query->get();
        }

        // if ($user_type == 'guard') {
        //     $this->db->select('customers.*');
        //     $this->db->from('customers');
        //     $this->db->join('jobs', 'jobs.customer_id = customers.id');
        //     $this->db->join('job_new_roster', 'jobs.id = job_new_roster.site_id');
        
        //     $this->db->where('job_new_roster.guard_id', $current_login_customer);
        //     $this->db->where('customers.state !=', 'deleted');           

        // if ($state != null && $state !='' && !$superAdmin) {
        //     // $this->db->where('customers.state', $state);           
        // }
        //     $this->db->group_by('jobs.customer_id');
        //     $customers = $this->db->get_where()->result_array();
        // }
        $already_customer = array();
        foreach($customers as $customer){
            if ($specific_sites_id != null && !empty($specific_sites_id)) {
            //     foreach ($specific_sites_id as $key => $value) {
            //     $job = $this->db->get_where('jobs', array('customer_id' => $customer['id'], 'id' => $value), 1, 0)->row_array();
            //         if (!empty($job) && !in_array($customer['id'], $already_customer)) {
            //             $already_customer[] =$customer['id'];
            //             $unread =  $this->count_unread_messages($customer['id'],$current_login_customer,$user_type);
            // $data[] = array('unread' => $unread ,'id' => $customer['id'], 'name' => $customer['name'], 'email' => $customer['email'], 'phone' => $customer['phone'], 'status' => $customer['status'], 'state' => $customer['state'],'user_type' => $user_type, 'current_login_customer'=> $current_login_customer,'last_query'=> $this->db->last_query());
            //         }
            //     }
            }else{
            // $unread =  $this->count_unread_messages($customer['id'],$current_login_customer,$user_type);
            $unread =  0;
            $data[] = array('unread' => $unread ,'id' => $customer->id, 'name' => $customer->name, 'email' => $customer->email, 'phone' => $customer->phone, 'status' => $customer->status, 'state' => $customer->state,'user_type' => $user_type);
            }
        }

        $rsp = array(
            'success' => $flag,
            'message' => $message,
            'data' => $data
        );
        return response()->json($rsp);

      
    }


    function save_charged_rates(Request $request)
{
    $charged_rates_id = $request->charged_rates_id;
    $previous_chargerate_id = customer::where(['id' => $request->customer_id ])->first()->charged_rates_id;

    customer::where(['id' => $request->customer_id ])->update(['charged_rates_id' => $charged_rates_id, 'apply_date' => $request->apply_date]);
    if ($request->has('chargerate_changed') && $request->chargerate_changed == 1) {
        $this->logCustomerChargeRate($request->customer_id, $charged_rates_id, $previous_chargerate_id, $request->apply_date);
    }  
    return response()->json(['success' => true, 'message' => "Charged Rate save successfully."]);
}

function logCustomerChargeRate($customer_id, $current_chargerate_id, $previous_chargerate_id, $apply_date)
    {
      if ($previous_chargerate_id == 0) {
        DB::table('customer_chargerate_history')->insert([
          'customer_id' => $customer_id,
          'chargerate_id' => $current_chargerate_id,
          'apply_date' => strtotime($apply_date)
        ]);
      }else{
        if ($current_chargerate_id == $previous_chargerate_id) {
            $already = DB::table('customer_chargerate_history')->where('customer_id', $customer_id)->where('chargerate_id', $current_chargerate_id)->first();
            if (!empty($already)) {
          DB::table('customer_chargerate_history')->where([
          'customer_id' => $customer_id,
          'chargerate_id' => $current_chargerate_id,
        ])->update(['apply_date' => strtotime($apply_date)]);
      }else{
        DB::table('customer_chargerate_history')->insert([
          'customer_id' => $customer_id,
          'chargerate_id' => $current_chargerate_id,
          'apply_date' => strtotime($apply_date)
        ]);
      }
        }else{
          DB::table('customer_chargerate_history')->insert([
          'customer_id' => $customer_id,
          'chargerate_id' => $current_chargerate_id,
          'apply_date' => strtotime($apply_date)
        ]);
        }
      }
    }

function reload_charged_rates(Request $request)
{
    $guard_payrate = DB::table('charged_rates')->where('archive', 0)->where(['id' => $request->charged_rates_id])->first();
    if (!empty($guard_payrate)) {
        return response()->json(['success' => true, 'message' => "ChargedRates retrieve", 'payrates' => $guard_payrate]);
    }else{
        return response()->json(['success' => false, 'message' => "ChargedRates retrieve"]);
    }
}

function get_charged_rates(Request $request)
{
    $guard_payrate = DB::table('charged_rates')->where('archive', 0)->where('state',$request->state)->where('level',$request->job_level)->orderBy('title', 'ASC')->get();
    if (!empty($guard_payrate)) {
        return response()->json(['success' => true, 'message' => "ChargedRates retrieve", 'chargerates' => $guard_payrate]);
    }else{
        return response()->json(['success' => false, 'message' => "ChargedRates not retrieve"]);
    }
}

function customer_total_sites(Request $request){
    $res=DB::table('jobs')->where('customer_id',$request->id)->get();
    $count=$res->count();
    return $count;
}
function customer_total_shifts(Request $request){
    $res=DB::table('job_new_roster')->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')->where('jobs.customer_id',$request->id)->get();
    $count=$res->count();
    return $count;
}

    }
     


