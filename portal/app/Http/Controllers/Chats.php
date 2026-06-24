<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Administrator as admin;
use App\Models\Guard as guard;
use Carbon;
class Chats extends Controller
{
    public $guard_model;
    // public $induction_model;
    // public function __construct(Request $request, induction $induction_model) {
    //     $this->induction_model = $induction_model;
    // }
    public function __construct(Request $request, guard $guard_model) {
        $this->guard_model = $guard_model;
    }
  public function chat(Request $request){
   
    try{

     if($request->session()->get('userType')=='admin'){
      // $admins =      admin::all();
      $admins=DB::table('administrators')->where('status','!=','deleted')->orderBy('name','ASC')->get();
     
      $guards =  DB::table('guards')
      ->where('status', 'active')
      ->where('admin_approved',1)
      ->where('is_approved', 'yes')
      // ->where('address','!=','')
      // ->where('gender','!=','')
      // ->where('phone','!=','')
      // ->where('name','!=','')
      // ->where('name','!=',null)
      // ->where('email','!=','')
      // ->where('email','!=',null)
      // ->where('emergency_contact_phone','!=','')
      // ->where('security_license_number','!=','')
      // ->where('security_license_file','!=','')
      // ->where('payroll_bank_account_number','!=','')
      // ->where('payroll_bank_name','!=','')
      ->orderBy('name', 'ASC')->get();

      // $guards =      guard::all();
      return view('admin/chat/chat',compact('admins','guards'));
      
    }
  }
  catch(\Exception $e)
  {
    dd($e->getMessage());
  }
  
}

public function load_user_into_chat(Request $request)
{
 $data = array();
 $user=null;
 if ($request->session()->get('userType') == 'admin') {
   $sender_data = admin::where('id', '=',$request->session()->get('userId'))->select('id', 'name', 'image')->first();
 }else{
   $sender_data = guard::where('id', '=',$request->session()->get('userId'))->select('id', 'name', 'profile_image as image')->first();
 }


 try{
   
  if($request->user_type=='admin' || $request->user_type=='administrator'){
    $user = admin::where('id', '=',$request->user_id)->select('id', 'name')->get();
    $receiver_data = admin::where('id', $request->user_id)->select('id', 'name', 'image')->first();
    $user[0]->type = 'administrator';
  }
  else if($request->user_type=='guard')
  {
    $user = guard::where('id', '=',$request->user_id)->select('id', 'name')->get();
    $receiver_data = guard::where('id', '=',$request->user_id)->select('id', 'name', 'profile_image as image')->first();
    $user[0]->type = 'guard';
  }

  $current_user_type = $request->session()->get('userType');

  if ($request->user_type == 'admin') {
    $request->user_type = 'administrator';
  }
  if ($current_user_type == 'admin') {
    $current_user_type = 'administrator';
  }

  $sender_messages = DB::table('inbox')
  ->where('receiver_id', $request->user_id)
  ->where('receiver', $request->user_type)
  ->where('sender_id', $request->session()->get('userId'))
  ->where('sender', $current_user_type)
  ->where('status', 'active')->get();
  

  $receiver_messages = DB::table('inbox')
  ->where('receiver_id', $request->session()->get('userId'))
  ->where('receiver',  $current_user_type)
  ->where('sender_id', $request->user_id)
  ->where('sender', $request->user_type)
  ->where('status', 'active')->get();


  foreach ($receiver_messages as $k => $receive_message) {
    $align = 'left';
    $sender = 1;
    $sent = $receive_message->timestamp_sent;
    $send_time = $receive_message->TIMESTAMP_INSERTED;
    $send_time = date('d/m/Y H:i', $receive_message->timestamp_sent);
    $receive_message->timestamp_sent = 'sent '.date('H:i', $receive_message->timestamp_sent);
    if($receive_message->timestamp_seen != 0){
      $receive_message->timestamp_seen = 'seen '.date('H:i', $receive_message->timestamp_seen);
      $read = $receive_message->timestamp_seen; 
    }else{
      $receive_message->timestamp_seen = '';
      $read = false;
    }
    $img = asset('media/avatars/150-13.jpg');
    if ($receiver_data->image != '') {
      $img = config('custom.asset_url').$receiver_data->image;
    }
    if($receive_message->type == 'file'){
      $receive_message->message = '<a target="_blank"><i class="bi bi-download fs-3"></i></a>';
    }
    $data[] = array('id' => $receive_message->id, 'message' => $receive_message->message, 'attachment' => $receive_message->attachment, 'attachment_name' => $receive_message->attachment_name, 'sent' => $receive_message->timestamp_sent, 'seen' => $receive_message->timestamp_seen, 'align' => $align, 'send_time' => $send_time, 'image' => $img, 'timestamp' => $sent);
    
    $current_time = time();
    if($receive_message->timestamp_seen == 0){
      DB::table('inbox')->where('id', $receive_message->id)->update(['timestamp_seen' => $current_time]) ; 
    }
                // $this->db->update('inbox', array('timestamp_seen' => time()), array('id' => $receive_message->id));
    DB::table('inbox')->where('id', $receive_message->id)->update(['timestamp_seen' => time(), 'seen' => 1]);
  }

  foreach ($sender_messages as $k => $sender_message) {
    $align = 'right';
    $sender = 0;
    $sent = $sender_message->timestamp_sent;
    $send_time = $sender_message->TIMESTAMP_INSERTED;
    $send_time = date('d/m/Y H:i', $sender_message->timestamp_sent);
    $sender_message->timestamp_sent = 'sent '.date('H:i', $sender_message->timestamp_sent);
    if($sender_message->timestamp_seen != 0){
      $sender_message->timestamp_seen = 'seen '.date('H:i', $sender_message->timestamp_seen);
      $read = $sender_message->timestamp_seen; 
    }else{
      $sender_message->timestamp_seen = '';
      $read = false;
    }
    
    if($sender_message->type == 'file'){
      $sender_message->message = '<a href="'.config('custom.asset_url').$sender_message->attachment_name.'" target="_blank"><i class="bi bi-download fs-3"></i></a>';
    }
    $img = asset('media/avatars/150-13.jpg');
    if ($sender_data->image != '') {
      $img = config('custom.asset_url').$sender_data->image;
    }
    $data[] = array('id' => $sender_message->id,'message' => $sender_message->message, 'attachment' => $sender_message->attachment, 'attachment_name' => $sender_message->attachment_name, 'sent' => $sender_message->timestamp_sent, 'seen' => $sender_message->timestamp_seen, 'align' => $align, 'send_time' => $send_time, 'image' => $img, 'timestamp' => $sent);
  }
  
  if(!empty($data)){
    $sorting = array_column($data, 'timestamp');
    array_multisort($sorting, SORT_ASC, $data);
    krsort($data);
  }
  
  
  if ($data!=null) {
    
   echo json_encode(['response'=>true,'messages'=>$data,'user'=>$user]);
   
 } else {
  echo json_encode(['response'=>false,'message' => 'No message Found...','user'=>$user]);
}
           // echo json_encode($result);


}
catch(\Exception $e){
  dd($e->getMessage());
}
}


public function insert_chat_msg(Request $request){
  $insert = 0;
        // dd($request->message);
 $nowtime = Carbon\Carbon::now();
 $nowtime->toDateTimeString();
 
 if($request->session()->get('userType')=='admin'){
  $user='administrator';
}

// try{
  $current_user_type = $request->session()->get('userType');
  if ($current_user_type == 'admin') {
    $current_user_type = 'administrator';
  }
  // if ($request->hasFile('comment_attachment') && $request->file('comment_attachment')!=null && file_exists($_FILES['comment_attachment']['tmp_name'])) {
  //   $uploadedFile = $request->file('comment_attachment'); 
  //   if ($uploadedFile->isValid()) {
  //   $path = $request->file('comment_attachment')->store('');
  //    $insert = DB::table('inbox')->INSERT([
  //   'sender_id'     => $request->session()->get('userId'),
  //   'receiver_id'   => $request->receiver_id,
  //   'type' => 'file',
  //   'attachment_name' => $path,
  //   // 'attachment' => $request->file('comment_attachment')->extension(),
  //   'TIMESTAMP_INSERTED' => $nowtime,
  //   'sender'=>$current_user_type,
  //   'receiver' => $request->receiver_type,
  //   'timestamp_sent' => Carbon\Carbon::now()->timestamp
  // ]);
  //  }
  // }else{
    if ($request->message != '') {
  $insert = DB::table('inbox')->INSERT([
    'sender_id'     => $request->session()->get('userId'),
    'receiver_id'   => $request->receiver_id,
    'message'       => $request->message,
    'TIMESTAMP_INSERTED' => $nowtime,
    'sender'=>$current_user_type,
    'receiver' => $request->receiver_type,
    'timestamp_sent' => Carbon\Carbon::now()->timestamp
  ]);
}
if ($request->receiver_type == 'guard') {
  $sender = 'administrator';
    if ($current_user_type == 'customer'){
      $user =  DB::table('customers')->where('id', $request->session()->get('userId'))->first();
    }
    if ($current_user_type == 'contractor'){
      $user =  DB::table('contractors')->where('id', $request->session()->get('userId'))->first();

    }
    if ($current_user_type == 'guard'){
      $user = DB::table('guards')->where('id', $request->session()->get('userId'))->first();
    }
    if($current_user_type == 'administrator'){
      $user =  DB::table('administrators')->where('id', $request->session()->get('userId'))->first();
    }
      $guard = DB::table('guards')->where('id', $request->receiver_id)->first();
      if ($guard->notification_token != '') {
      $notification_data['guards'][0] = array(
                            'guard_id' => $guard->id,
                            'notification_token' => $guard->notification_token );
        $notification_data['title'] = 'New Message';
        $notification_data['message'] = $user->name. ' send you a message.';
        $notification_data['page'] = 'chat';
        $this->guard_model->send_push_notification($notification_data);
    }
    }
  // }
  
  if($insert)
  {
   return response()->json(['response'=>true]);
 }
 else{
  return response()->json(['response'=>false]);
}
// }
// catch(\Exception $e){
//     return response()->json('hello');

//             // dd($e->getMessage());
// }
}

public function get_chat(Request $request)
{
 try{
  $UnseenMsgs = DB::table('inbox')
  ->where('sender_id',$request->receiver_id)
  ->where('receiver_id',$request->session()->get('userId'))
  ->where('seen',0)
  ->get();

  if(count($UnseenMsgs)){
    echo json_encode(['response'=>true,'messages'=>$UnseenMsgs]);
    
    $update_seen = DB::table('inbox')
            //  ->orderBy('TIMESTAMP_INSERTED','DESC')
    ->where('sender_id','=',$request->receiver_id)
    ->where('receiver_id', '=',$request->session()->get('userId'))
    ->UPDATE(['seen'=>1]);
           // dd($update_seen);
  }
  else{
   echo json_encode(['response'=>false]);
 }
}
catch(\Exception $e)
{
  // dd($e->getMessage());
}

          //dd($messages);

}
}
