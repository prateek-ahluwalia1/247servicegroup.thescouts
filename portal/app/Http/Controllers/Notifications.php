<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Administrator as admin;
use App\Models\Guard as guard;

class Notifications extends Controller
{
    public function green_call(){
        $today = time();
        $time = $today - (60*60*24*3);
        $result=DB::table('green_call')
        ->join('guards', 'guards.id', '=', 'green_call.guard_id')
        ->join('job_new_roster', 'job_new_roster.roster_id', '=', 'green_call.job_id')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->where('green_call.created_at', '>=', date('Y-m-d H:i', $time))
        ->select('green_call.*', 'jobs.site_name', 'guards.name')->orderBy('created_at', 'desc')->get();


        // $count=DB::table('portal_notifications')->where('status','unseen')->where('type','green_call')->order_by('send_time', 'desc')->get();
        // DB::table('portal_notifications')->where('type','green_call')->update(['api_seen_status' => 'seen']);
        return response()->json(['result' => $result,'count' => count($result)]);

    }
    public function welfare_call(){
        $today = time();
        $time = $today - (60*60*24*3);
        $result=DB::table('welfare_call_data')
        ->join('guards', 'guards.id', '=', 'welfare_call_data.guard_id')
        ->join('job_new_roster', 'job_new_roster.roster_id', '=', 'welfare_call_data.job_roster_id')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->where('welfare_call_data.created_at', '>=', date('Y-m-d H:i', $time))
        ->select('welfare_call_data.*', 'jobs.site_name', 'guards.name')->orderBy('created_at', 'desc')->get();

        $result_count = DB::table('welfare_call_data')
        ->join('guards', 'guards.id', '=', 'welfare_call_data.guard_id')
        ->join('job_new_roster', 'job_new_roster.roster_id', '=', 'welfare_call_data.job_roster_id')
        ->join('jobs', 'jobs.id', '=', 'job_new_roster.site_id')
        ->where('welfare_call_data.created_at', '>=', date('Y-m-d H:i', $time))
        ->where('welfare_call_data.seen_status', '=', 'unseen')
        ->select('welfare_call_data.*', 'jobs.site_name', 'guards.name')->orderBy('created_at', 'desc')->get();

        DB::table('welfare_call_data')
        ->where('welfare_call_data.seen_status', '=', 'unseen')->update(['seen_status' => 'seen']);


        // DB::table('portal_notifications')->where('type','welfare_call')->update(['api_seen_status' => 'seen']);

        return response()->json(['result' => $result,'count' => count($result_count)]);
    }
    public function guard_leave_location(){
        $result=DB::table('portal_notifications')->where('type','leave_location')->where('send_time', '>=', (time()- 60*60*24))->orderBy('send_time', 'desc')->get();

        $result_count = DB::table('portal_notifications')->where('type','leave_location')->where('send_time', '>=', (time()- 60*60*24))->where('status', 'unseen')->orderBy('send_time', 'desc')->get();
        // 
        DB::table('portal_notifications')->where('type','leave_location')->update(['api_seen_status' => 'seen']);
        return response()->json(['result' => $result,'count' => count($result_count)]);
    }

     public function guard_incident_report(){
        $result=DB::table('portal_notifications')
        ->where('type','incident_report')
        ->where('send_time', '>=', (time()- 60*60*24))
        ->orderBy('send_time', 'desc')->get();

        $result_count = DB::table('portal_notifications')->where('type','incident_report')->where('send_time', '>=', (time()- 60*60*24))->where('status', 'unseen')->orderBy('send_time', 'desc')->get();
        // 
        DB::table('portal_notifications')->where('type','incident_report')->update(['api_seen_status' => 'seen']);
        return response()->json(['result' => $result,'count' => count($result_count)]);
    }

    public function guard_other_notifications(){
        $type = '';
        $result=DB::table('portal_notifications')
        ->where(function ($query) use($type){
            $query->where('type', 'job_signout')->orWhere('type', 'job_confirm')->orWhere('type', 'job_signin');
             })
        ->where('send_time', '>=', (time()- 60*60*24))
        ->orderBy('send_time', 'desc')->get();

        $result_count = DB::table('portal_notifications')
        ->where(function ($query) use($type){
            $query->where('type', 'job_signout')->orWhere('type', 'job_confirm')->orWhere('type', 'job_signin')->orWhere('type', 'job_reject')->orWhere('type', 'job_accept');
             })
        ->where('send_time', '>=', (time()- 60*60*24))
        ->where('status', 'unseen')
        ->orderBy('send_time', 'desc')->get();
        // 
        DB::table('portal_notifications')->where(function ($query) use($type){
            $query->where('type', 'job_signout')->orWhere('type', 'job_confirm')->orWhere('type', 'job_signin')->orWhere('type', 'job_accept')->orWhere('type', 'job_reject');
             })->update(['api_seen_status' => 'seen']);
        return response()->json(['result' => $result,'count' => count($result_count)]);
    }
    
    public function seen_green_call(){
       $result= DB::table('portal_notifications')->where('type','green_call')->update(['api_seen_status' => 'seen','status' => 'seen']);
        return $result;

    }
    public function seen_welfare_call(){
        $result= DB::table('portal_notifications')->where('type','welfare_call')->update(['api_seen_status' => 'seen','status' => 'seen']);
         return $result;
 
     }  public function seen_leave_location(){
        $result= DB::table('portal_notifications')->where('type','leave_location')->update(['api_seen_status' => 'seen','status' => 'seen']);
         return $result;
 
     }
    public function seen_all_notifications()
    {
        DB::table('portal_notifications')
         ->where(function ($query){
            $query->where('type', 'job_signout')
            ->orWhere('type', 'job_confirm')
            ->orWhere('type', 'leave_location')
            ->orWhere('type', 'incident_report')
            ->orWhere('type', 'job_signin')
            ->orWhere('type', 'job_accept')
            ->orWhere('type', 'green_call')
            ->orWhere('type', 'sos_call')
            ->orWhere('type', 'welfare_call')
            ->orWhere('type', 'leave');
             })->update(['status' => 'seen']);
        return response()->json(['success' => true]);
    }
    public function unseen_all_notifications()
    {
        $unseen = DB::table('portal_notifications')
         ->where(function ($query){
            $query->where('type', 'job_signout')
            ->orWhere('type', 'job_confirm')
            ->orWhere('type', 'leave_location')
            ->orWhere('type', 'incident_report')
            ->orWhere('type', 'job_reject')
            ->orWhere('type', 'job_signin')
            ->orWhere('type', 'leave')
            ->orWhere('type', 'green_call')
            ->orWhere('type', 'welfare_call')
            ->orWhere('type', 'sos_call')
            ->orWhere('type', 'job_accept');
            })->where('api_seen_status', 'unseen')->first();
         if (!empty($unseen)) {
             DB::table('portal_notifications')->where('id', $unseen->id)->update(['api_seen_status' => 'seen']);
         }
        return response()->json(['success' => true, 'unseen' => $unseen]);
        // return response()->json(['success' => false, 'unseen' => null]);
    }
    function unread_messages(Request $request)
    {
        $user_type = $request->session()->get('userType');
        $user_id = $request->session()->get('userId');
        if ($user_type == 'admin') {
            $user_type = 'administrator';
        }
        $unread_messages = DB::table('inbox')->where('receiver_id', $user_id)->where('receiver', $user_type)->where('timestamp_seen', 0)->get();
        foreach ($unread_messages as $key => $messages) {
            if ($messages->sender == 'administrator') {
                $sender = admin::where('id', '=',$messages->sender_id)->select('id', 'name', 'image')->first();
            }elseif($messages->sender == 'guard'){
                $sender = guard::where('id', '=',$messages->sender_id)->select('id', 'name', 'profile_image as image')->first();
            }else{
                $sender = admin::where('id', '=',$messages->sender_id)->select('id', 'name', 'image')->first();
            }
            $img = asset('media/avatars/150-13.jpg');
            if ($sender->image != '') {
              $img = config('custom.asset_url').$sender->image;
            }
            $messages->profile_image = $img;
            $messages->sender_name = $sender->name;
            $messages->send_time =  date('d/m/Y H:i', $messages->timestamp_sent);
        }

        return response()->json(['success' => true, 'unseen' => $unread_messages, 'count' => count($unread_messages)]);

    }
   }
