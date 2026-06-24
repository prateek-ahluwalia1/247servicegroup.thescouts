<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Contractor as contractor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Contractor_payrate as contractor_payrate;
use App\Models\Contractor_contact as contractor_contact;
use Codedge\Fpdf\Fpdf\Fpdf;
use \PDF;
use Illuminate\Support\Facades\View;
use App\Models\charged_rate as charged_rate;
use Illuminate\Support\Facades\Session;
use App\Models\ProfileLogs;


class Contractors extends Controller
{
    public  $profileLogs;
    public function __construct(Request $request, ProfileLogs $profileLogs) {
        $this->profileLogs = $profileLogs;
    }
    //
    // public function contractors(){
    //     $contractors = contractor::get();
    //     return view('admin/contractor', ['contractors' => $contractors]);

    // }

public function contractor_pdf(Request $request){
    // $role_id = $request->role;
     $contractors = DB::table('contractors')->where('status', 'active')->get();

     View::make('admin/contractor/contractor_pdf', ['contractors' => $contractors]);
    // exit();
     $pdf = PDF::loadView('admin/contractor/contractor_pdf', ['contractors' => $contractors]);
     // return view('admin/contractor/contractor_pdf', ['contractors' => $contractors]);
     
     return $pdf->download('contractors-list.pdf');
}

public function do_login(Request $request)
{

    $apikey = base64_encode(Str::random(64).time());
    $contractor = DB::table('contractors')->where(['email' => $request->input('email')])->first();
    if (Hash::check($request->input('password'), $contractor->password)) {
        DB::table('contractors')->where('id', $contractor->id)->update(['auth_token' => $apikey]);
        session([
            'userId' => $contractor->id,
            'userType' => 'contractor', 
            'image' => $contractor->image,  
            'userName' => $contractor->name,  
            'authToken' => $apikey]);
            return    redirect('contractor_profile'. '/' .$contractor->id);

    }else{
         return view('admin/contractor/login');
       exit();
    }
}




public function contractor(){
    if (!session()->has('userType')) {
        return view('admin/contractor/login');
    }else{
        return redirect('contractor_profile'. '/' .session::get('userId'));
        //  view('admin/contractor/login');
     
    }

}

public function getcontractors(Request $request)
{
    $contractors = DB::table('contractors')->where('status', 'active')->orderBy('name', 'ASC')->get();
    return $contractors;
}

public function contractors(){
        if (!session()->has('userType')) {
            return view('admin/login');
        }else{
            // $admins = admin::get();
            $contractors = DB::table('contractors')->where('status', 'active')->orderBy('name', 'ASC')->get();

            return view('admin/contractors', ['contractors' => $contractors]);
        }

    }


     public function insertContractor(Request $request){

        $password = Hash::make('1234568');

        $name=  $_POST['name'];
                $address1=  $_POST['address1'];

        // $address2=  $_POST['address2'];

        $city=  $_POST['city'];

        $state=  $_POST['state'];
        // $country=  $_POST['country'];

                $email=  $_POST['email'];
                $postcode =$_POST['postcode'];
                $contractor_id_range =$_POST['contractor_id_range'];


        // print_r($access);
        // exit();
 $query =DB::table('contractors')->insert([
    'email' => $email,
    'name' => $name,
    'password' => $password,
    'auth_token' => '',
    'phone' => '',
    'business_abn_can_number' => '',
    'business_abn_can_expiration' => '',
    'business_abn_can_file' => '',
    'security_license_number' => '',
    'security_license_expiration' => '',
    'security_license_file' => '',
    'labour_hire_number' => '',
    'labour_hire_expiration' => '',
    'labour_hire_file' => '',
    'public_liability_number' => '',
    'public_liability_expiration' => '',
    'public_liability_file' => '',
    'acis_certificate' => '',
    'notification_token' => '',
    'timestamp_joined' => time(),
    'timestamp_activity' =>time(),
    'state' => $state,
    'address' => $address1,
    'city' => $city,
    'postal_code'=> $postcode,
    'contractor_id_range'=> $contractor_id_range
    
]);
if($query==true)
{
                return redirect('/contractors')->with('msg', 'Record Added');

       // $res= admin::insert($name,$email);
}else{

                    return redirect('404');

}
    }


    public function getContractor($id){

        $contractors = DB::table('contractors')->where('id', $id)->first();
        return response()->json($contractors);


    }

    public function editContractor($id){
                
        $name=  $_POST['name'];
                $address1=  $_POST['address1'];

        // $address2=  $_POST['address2'];

        $city=  $_POST['city'];

        $state=  $_POST['state'];
        // $country=  $_POST['country'];
                $email=  $_POST['email'];
                $postcode =$_POST['postcode'];

                // $access =$_POST['user_role'];


          $query=  DB::table('contractors')->where('id', $id)->update(['name' => $name,'email' => $email,'address'=> $address1 , 'city'=> $city , 'state' => $state ,'postal_code'=> $postcode]);
          if($query){
                            return redirect('/contractors')->with('msg', 'Record Updated');

          }

       

    }

     



public function deleteContractor($id){
         $query=  DB::table('contractors')->where('id', $id)->update(['status' => "deleted"]);
          if($query){
                            return redirect('/contractors')->with('msg', 'Record Deleted');

          }
     }


     public function Contractorprofile($id){
  
        $contractor_id=$id;

     $contractors = contractor::where('id', $id)->get();
       $charged_rates = DB::table('contractors')->where('id', $id)->select('charged_rates_id')->first();
        $charged_rates_id=$charged_rates->charged_rates_id;
        // echo $charged_rates_id;
        // exit();


            return view('admin/contractor/profile', ['contractors' => $contractors,'contractor_id' => $contractor_id,'charged_rates_id' => $charged_rates_id]);
   



}

     


   function personal_data(Request $request)
{
    $contractor = contractor::where(['id' => $request->contractor_id])->first();
    if (!empty($contractor)) {
        // $guard->specific_contractors_id = json_decode($guard->specific_contractors_id, true);
        return response()->json(['success' => true, 'message' => "Personal Data", 'contractor' => $contractor]);
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
    $path = $public_path.'/asset_uploads/';
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
    // $validated = $request->validate([);
    $apikey = base64_encode(Str::random(64).time());

      $validator = Validator::make($request->all(), ['email' => 'bail|required', 'name' => 'required']);
     // $this->setValidationRules(['email' => 'required', 'password' => 'required', 'first_name' => 'required']);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => "Please enter required data!"]);
        }
      
    $contractor_data = [
        'name' => ($request->name != null) ? $request->name : '',
        'email' => $request->email,
        'phone' => $request->phone != null ? $request->phone : '',
        'address' => $request->address,
        'city' => $request->city,
        'state' => $request->state,
        'postal_code' => $request->postalCode,
        'url' => $request->url,
        'auth_token' => $apikey
    ];

    

   
    if ($request->password != null && $request->password != '') {
        $contractor_data['password'] = Hash::make($request->password);
    }
    if ($request->has('contractor_id')) {
        $data = contractor::where(['id' => $request->contractor_id])->first();
       contractor::where(['id' => $request->contractor_id])->update($contractor_data);
        $this->profileLogs->contractorProfileLogs($request, $data);
       return response()->json(['success' => true, 'message' => "Details save successfully"]);
    }
   
}




function save_contractor_payrates(Request $request)
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

    $already_check = contractor_payrate::where(['contractor_id' => $request->contractor_id, 'state' => $request->payrates_state, 'job_level' => $request->job_level])->first();
            if (empty($already_check)) {


                $data['state'] = $request->payrates_state;
                $data['job_level'] = $request->job_level;
                $data['contractor_id'] = $request->contractor_id;
                contractor_payrate::insert($data);  
            }else{
                contractor_payrate::where(['contractor_id' => $request->contractor_id, 'state' => $request->payrates_state, 'job_level' => $request->job_level])->update($data);  
            }
        return response()->json(['success' => true, 'message' => "Payrate data save successfully."]);
}



function get_contractor_payrates(Request $request)
{
    

    $contractor_payrate = contractor_payrate::where(['contractor_id' => $request->contractor_id, 'state' => $request->state, 'job_level' => $request->job_level])->first();
    if (!empty($contractor_payrate)) {
        return response()->json(['success' => true, 'message' => "Payrates retrieve", 'payrates' => $contractor_payrate]);
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
    $contractor = contractor::where(['id' => $request->contractor_id])->update($data);
    if(isset($request->heading)){
        $count = $request->doc_index_counter;
        $sub = 0;
        if(count($request->heading) > 0){
            DB::table('contractor_extra_docs')->delete();
            for($i=0;$i<$count;$i++){
                DB::table('contractor_extra_docs')->insert([
                    'contractor_id' => $request->contractor_id,
                    'header' => $request->heading[$i],
                    'number' => $request->extra_number[$i],
                    'expiration' => $request->extra_expiration[$i],
                    'file' => $request->extra_file[$i],
                ]);
            }
        }
    }
    return response()->json(['success' => true, 'message' => "Data save successfully."]);
}


function get_documents_data(Request $request)
{
    

    $documnets = contractor::where(['id' => $request->contractor_id])->with('ExtraDcs')->first();
    if (!empty($documnets)) {
        return response()->json(['success' => true, 'message' => "documnets retrieve", 'documnets' => $documnets]);
    }else{
        return response()->json(['success' => false, 'message' => "documnets retrieve false"]);
    }
}





function contractor_documents(Request $request)
{
    $contractor = contractor::where(['id' => $request->contractor_id])->first();
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
    $contacts=DB::table('contractor_contacts')->where('contractor_id',$request->contractor_id)->get();
    // return $request->cid;
    // exit();
    $sub=0;
    if(!empty($contacts)){
        foreach($contacts as $contact){
            $sub++;
            
        for($i=0;$i<$count;$i++){
            if($request->cid[$i] !='' && $request->cid[$i] !=null && $request->cid[$i] !='null' ){
            if($request->cid[$i] == $contact->id){
                DB::table('contractor_contacts')->where('id',$request->cid[$i])->update([
                    'name' => $request->contact_name[$i],
                    'phone' => $request->contact_phone[$i],
                    'email' => $request->contact_email[$i],

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
            $contact=  DB::table('contractor_contacts')->insert([
                'contractor_id' => $request->contractor_id,
                'email' => $request->contact_email[$i],
                'name' => $request->contact_name[$i],
                'phone' => $request->contact_phone[$i]
        ]);
        }
    }
    }

         return response()->json(['success' => true, 'message' => "Contacts data save successfully."]);


}
function get_contacts(Request $request)
{
    
    $contacts =DB::table('contractor_contacts')->where(['contractor_id' => $request->contractor_id])->get();
    
    if (!empty($contacts)) {
    $ids = $contacts->count();
    return response()->json(['success' => true, 'message' => "contacts found", 'indexs' => $ids,'contacts' => $contacts]);
    }
  else{
        return response()->json(['success' => false, 'error' => "No contacts."]);
    }
   
}


// function save_contacts(Request $request)
// {
//     $data = [
//         'name' => $request->contact_name,
//         'email' => $request->contact_email,
//         'phone' => $request->contact_phone
//         // 'created_at' => time(),
//         // 'updated_at' => time()        
//     ];

//     $already_check = contractor_contact::where(['contractor_id' => $request->contractor_id])->first();
//             if (empty($already_check)) {

//               $contact=  DB::table('contactor_contacts')->insert([
//                 'contractor_id' => $request->contractor_id,
                
//                 'email' => $request->contact_email,
//                 'name' => $request->contact_name,
//                 'phone' => $request->contact_phone
//         ]);
//             }else{
//             $contact= contractor_contact::where(['contractor_id' => $request->contractor_id])->update($data);  
    
//             }

//          return response()->json(['success' => true, 'message' => "Payrate data save successfully."]);


// }


// function get_contacts(Request $request)
// {
    

//     $contact = contractor_contact::where(['contractor_id' => $request->contractor_id])->first();
//     if (!empty($contact)) {
//         return response()->json(['success' => true, 'message' => "documnets retrieve", 'contact' => $contact]);
//     }else{
//         return response()->json(['success' => false, 'message' => "documnets retrieve false"]);
//     }
// }




    function save_charged_rates(Request $request)
{
    $charged_rates_id=$request->charged_rates_id;
               $query= contractor::where(['id' => $request->contractor_id ])->update(['charged_rates_id' => $charged_rates_id]);  
                 if($query)
{
return response()->json(['success' => true, 'message' => "Charged Rate save successfully."]);
}
    
    else{
        return response()->json(['success' => false, 'message' => "Charged Rate save successfully."]);
    }             
}

function reload_charged_rates(Request $request)
{
       
    $guard_payrate =  DB::table('payrates')->where(['id' => $request->charged_rates_id])->where('archive', 0)->first();
    if (!empty($guard_payrate)) {
        return response()->json(['success' => true, 'message' => "ChargedRates retrieve", 'payrates' => $guard_payrate]);
    }else{
        return response()->json(['success' => false, 'message' => "ChargedRates retrieve"]);
    }
}

function get_charged_rates(Request $request)
{
    $guard_payrate =  DB::table('payrates')->where(['state' => $request->state, 'level' => $request->job_level])->where('archive', 0)->get();
    if (!empty($guard_payrate)) {
        return response()->json(['success' => true, 'message' => "ChargedRates retrieve", 'payrates' => $guard_payrate]);
    }else{
        return response()->json(['success' => false, 'message' => "ChargedRates not retrieve"]);
    }
}

function contractor_total_sites(Request $request){
    $res=DB::table('jobs')->where('contractor_id',$request->id)->get();
    $count=$res->count();
    return $count;
}
function contractor_total_shifts(Request $request){
    $res=DB::table('job_new_roster')->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')->where('jobs.contractor_id',$request->id)->get();
    $count=$res->count();
    return $count;
}

public function fetch_contractor_id_range(Request $request)
{   
    $contractor=DB::table('contractors')->orderBy('id','desc')->first();
    if(empty($contractor)){
        $id=1;
        $prev_id=(int)$id+1;
    }else{
        $prev_id=(int)$contractor->id+1;
    }
    $contractor_id_range_from=$prev_id*10000+1000;
    $contractor_id_range_to=$prev_id*10000+10000;
    return ['contractor_id_range_to'=>$contractor_id_range_to,'contractor_id_range_from'=>$contractor_id_range_from,'contractor_id_range'=>$contractor_id_range_from.'-'.$contractor_id_range_to];
}   

    }
     



     

