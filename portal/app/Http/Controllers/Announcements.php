<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Announcement as induction;
use App\Models\Guard as guard;
use App\Models\Notifications as notification;
use App\Models\Induction as Inductions;

class Announcements extends Controller
{
  public $induction_model;
  public $guard_model;
  public $notification_model;

  public function __construct(Request $request, induction $induction_model, guard $guard_model, notification $notification_model) {
    $this->induction_model = $induction_model;
    $this->guard_model = $guard_model;
    $this->notification_model = $notification_model;
  }
  function getAnnouncements()
  {
    return $this->index('api');
  }

  public function index($call_from = null){
    $results=$this->induction_model->inductions();
    foreach($results as $r){
      $r->updated_at=date('d-m-y',strtotime($r->updated_at));
      $r->selected_guards = json_decode($r->selected_guards, true);
    }
    if ($call_from == 'api') {
      if (count($results) > 0) {
        return response()->json(['status' => true, 'message' => 'Data found', 'data' => $results]);
      }else{
        return response()->json(['status' => false, 'message' => 'No data found!']);
      }
    }else{
      return view('admin/announcements/index',['results'=>$results]);
    }
  }

  public function induction($id){
    $results=DB::table('tutorials')->select('id','title','html_body','TIMESTAMP_LAST_UPDATED as updated_at')->where('id',$id)->get();

    foreach($results as $r){
      $r->updated_at=date('d-m-y',strtotime($r->updated_at));
    }
        // return $result;
        // exit
    return view('admin/announcements/announcement',['results'=>$results]);
  }   
  public function get_guard_list(Request $request){
    $results=$this->induction_model->get_guard_list($request->send_by,$request->send_by_list_id);
    return $results;
  }
  public function get_send_by_list(Request $request){
    // return response()->json([]);
    // exit();
    $send_by=$request->send_by;
    $results=$this->induction_model->get_send_by_list($send_by);
    return response()->json($results);
  }

  public function add_induction(Request $request){
    $results= $this->induction_model->add_induction($request->title,$request->send_to,$request->send_by,$request->htmlBody,$request->send_by_list,json_encode($request->send_to_guards));
    if (!empty($request->send_to_guards)) {
      foreach ($request->send_to_guards as $key => $guard_id) {
        if ($guard_id > 0) {
          $guard_data = DB::table('guards')->where('id', $guard_id)->first();
          $notification_data['guards'][0] = array(
            'guard_id' => $guard_data->id,
            'notification_token' => $guard_data->notification_token );
          $notification_data['title'] = 'New Announcement';
          $notification_data['message'] = 'New Announcement - There is a new announcement.';
          $notification_data['page'] = 'homepage';
          $res = $this->guard_model->send_push_notification($notification_data);
        }
      }
    }
    if($results)
    {
     return response()->json(array('success' => true));

   }else{
     return response()->json(array('success' => false));

   }
 }


 
 public function edit_induction(Request $request){


  $results= $this->induction_model->edit_induction($request->title,$request->send_to_edit,$request->send_by_edit,$request->htmlBody_edit,$request->send_by_list_edit, json_encode($request->send_to_guards_edit),$request->inductionId);
  if (!empty($request->send_to_guards_edit)) {
    foreach ($request->send_to_guards_edit as $key => $guard_id) {
      if ($guard_id > 0) {
        $guard_data = DB::table('guards')->where('id', $guard_id)->first();
        $notification_data['guards'][0] = array(
          'guard_id' => $guard_data->id,
          'notification_token' => $guard_data->notification_token );
        $notification_data['title'] = 'Announcement Update';
        $notification_data['message'] = 'Announcement Update - There is an update in announcement';
        $notification_data['page'] = 'homepage';
        $res = $this->guard_model->send_push_notification($notification_data);
      }
    }
  }
  return response()->json(array('success' => true));

}


public function upload_image_induction(Request $request)
{
 $image = $this->upload_img($request->image);

 if ($image != '') {
   echo json_encode(array('success' => true, 'path' => config('custom.asset_url').$image));
 }else{
   echo json_encode(array('success' => false, 'path' => ''));

 }
//    config('custom.title');
}

function upload_img($key)
{

 $name = '';
 
    //  $path = '../../asset_uploads/';
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
  return file_put_contents($output_file, $data);

}

public function update_induction(Request $request){
  $results =DB::table('tutorials')->where('id',$request->id)->get();
  if ($results[0]->selected_guards == null || $results[0]->selected_guards == 'null') {
    $results[0]->selected_guards = array();
  }else{
    $results[0]->selected_guards = json_decode($results[0]->selected_guards, true);
  }
  return $results;
}

public function get_send_by_list_induction(Request $request){
  $send_by=$request->send_by;
  if ($send_by == 'customer') {
    $results=   DB::table('customers')->select('id', 'name')->get();
  }elseif($send_by == 'contractor'){
    $results=   DB::table('contractors')->select('id', 'name')->get();
  }
  return $results;
}   

public function delete_induction( Request $request){
  $results=DB::table('tutorials')->where('id',$request->id)->update([
    'status' => 'deleted',
  ]
);
  if($results){
    return redirect('/')->with('msg', 'Record Deleted');
  }
}




private function getAsset ($file) {
  $dir = explode('/', $file);
  if (count($dir) > 1) {
    return (!empty($file)) ? config('custom.asset_url').$file : '';
  }else{
    return (!empty($file)) ? config('custom.asset_url').$file : '';
  }
}


function get_induction_images(Request $request)

{
  $data='';
  $induction_id=$request->id;
  $results=DB::table('induction_image')
  ->join('guards', 'guards.id', '=', 'induction_image.guard_id')

  ->where('induction_image.induction_id', $induction_id)->orderBy('guards.name','ASC')->get();

  foreach($results as $result){
    $result->image=$this->getAsset($result->image);
  }
  return $results;
}

function induction_seen_status(Request $request){
  $result=DB::table('induction_seen_status')->join('guards', 'guards.id', '=', 'induction_seen_status.guard_id')
  ->select('guards.name')->where('induction_seen_status.induction_id',$request->id)->where('induction_seen_status.status','seen')->orderBy('guards.name','ASC')->get();
  if(!empty($result)){
    return $result;
  }
}
public function new($call_from = null){
    $results = $this->induction_model->inductions();
    foreach($results as $r){
      $r->updated_at=date('d-m-y',strtotime($r->updated_at));
      $r->selected_guards = json_decode($r->selected_guards, true);
    }

    if ($call_from == 'api') {
      if (count($results) > 0) {
        return response()->json(['status' => true, 'message' => 'Data found', 'data' => $results]);
      }else{
        return response()->json(['status' => false, 'message' => 'No data found!']);
      }
    }else{
      $inductions = Inductions::select('id','title','html_body','TIMESTAMP_LAST_UPDATED as updated_at', 'send_to', 'send_by', 'send_by_list', 'selected_guards')->where('status','!=','deleted')->orderBy('id', 'desc')->get();
      foreach($inductions as $i){
      $i->updated_at = date('d-m-y',strtotime($i->updated_at));
      $i->selected_guards = json_decode($i->selected_guards, true);
      }
      // $guards = DB::table('guards')->where('status', 'active')->where('admin_approved', 1)->orderBy('name', 'ASC')->get();
      $guards =  DB::table('guards')
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
    $customers = DB::table('customers')->where('status', 'active')->select('id', 'name')->get();
      return view('admin/announcements/new',['results' => $results, 'inductions' => $inductions, 'guards' => $guards, 'customers' => $customers]);
    }
  }
  function add_new_announcement_induction(Request $request)
  {
    if ($request->type == 'induction') {
      if ($request->has('id') && $request->id != '') {
       $ann = Inductions::where('id', $request->id)->update([
        'title' => $request->title,
        'html_body' => $request->htmlBody,
        'selected_guards' => json_encode($request->guard_selection),
        'send_to' => 'guards',
        'send_by' => 'direct'
        ]);
        $notification_data['title'] = 'Induction Update';
        $notification_data['message'] = 'Induction Update - There is an update in induction';
        
      }else{
      $ann = Inductions::insert([
        'title' => $request->title,
        'html_body' => $request->htmlBody,
        'selected_guards' => json_encode($request->guard_selection),
        'send_to' => 'guards',
        'send_by' => 'direct'
        ]);
        $notification_data['title'] = 'New Induction';
        $notification_data['message'] = 'New Induction - There is a new induction.';
      }
    }else{
      if ($request->has('id') && $request->id != '') {
        $ann = induction::where('id', $request->id)->update([
        'title' => $request->title,
        'html_body' => $request->htmlBody,
        'selected_guards' => json_encode($request->guard_selection),
        'send_to' => 'guards',
        'send_by' => 'direct'
        ]);
          $notification_data['title'] = 'Announcement Update';
          $notification_data['message'] = 'Announcement Update - There is an update in announcement.';
      }else{
      $ann = induction::insert([
        'title' => $request->title,
        'html_body' => $request->htmlBody,
        'selected_guards' => json_encode($request->guard_selection),
        'send_to' => 'guards',
        'send_by' => 'direct'
        ]);
          $notification_data['title'] = 'New Announcement';
          $notification_data['message'] = 'New Announcement - There is a new announcement.';
    }
    }
    if ($ann) {
      if (!empty($request->guard_selection)) {
      foreach ($request->guard_selection as $key => $guard_id) {
        if ($guard_id > 0) {
          $guard_data = DB::table('guards')->where('id', $guard_id)->first();
          $notification_data['guards'][0] = array(
            'guard_id' => $guard_data->id,
            'notification_token' => $guard_data->notification_token );
          $notification_data['page'] = 'homepage';
          $res = $this->guard_model->send_push_notification($notification_data);
        }
      }
    }
      return response()->json(array('success' => true, 'message' => 'Data save successfully.'));
    }else{
      return response()->json(array('success' => false, 'error' => 'Fail to save data!'));
    }
  }
  function delete_ann_data(Request $request, $id)
{
  if ($request->type == 'induction') {
      $ann = Inductions::where('id', $id)->delete();
    }else{
      $ann = induction::where('id', $id)->delete();
    }
    if ($ann) {
      return response()->json(array('success' => true, 'message' => 'Data delete successfully.'));
    }else{
      return response()->json(array('success' => false, 'error' => 'Fail to delete data!'));
    }

}
function getEditData(Request $request, $id)
{
  if ($request->type == 'induction') {
      $ann = Inductions::where('id', $id)->first();
    }else{
      $ann = induction::where('id', $id)->first();
    }
    if ($ann) {
      $ann->selected_guards = json_decode($ann->selected_guards, true);
      return response()->json(array('success' => true, 'message' => 'Data retrive successfully.', 'data' => $ann));
    }else{
      return response()->json(array('success' => false, 'error' => 'Fail to get data!'));
    }
}
}
