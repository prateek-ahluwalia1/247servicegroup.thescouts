<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Induction extends Model
{
    use HasFactory;
    protected $table='inductions';

    public function inductions(){
        $results=DB::table('inductions')->select('id','title','html_body','TIMESTAMP_LAST_UPDATED as updated_at', 'send_to', 'send_by', 'send_by_list', 'selected_guards')->where('status','!=','deleted')->get();
        return $results;

    }
    public function get_guard_list($send_by,$send_by_list_id){
        if ($send_by == 'customer') {
            $send_by_list_id = '"'.$send_by_list_id.'"';
            // ->join('jobs_guards', 'jobs_guards.guard_id', '=', 'guards.id')
            // ->join('jobs', 'jobs.id', '=', 'jobs_guards.job_id')
            $results = DB::table('guards')
            ->where('guards.specific_customers_id', 'like', '%'.$send_by_list_id.'%')
            ->where('guards.status', 'active')
            ->where('guards.is_approved', 'yes')
            ->where('guards.admin_approved', 1)
            ->select('guards.*')
            // ->groupBy('guards.id')
            ->orderBy('guards.name','ASC')
            ->get();
            // $results=DB::table('jobs')
            // ->join('job_new_roster', 'job_new_roster.site_id', '=', 'jobs.id')
            // ->join('guards', 'guards.id', '=', 'job_new_roster.guard_id')
          }
          elseif($send_by == 'contractor'){
            $results=DB::table('guards')->where('status', 'active')->where('guards.is_approved', 'yes')->where('guards.admin_approved', 1)->where('contractor_id', $send_by_list_id)->orderBy('name','ASC')->get();
          }else{
            // ->where('guard_type','Direct')
              $results=DB::table('guards')->where('status', 'active')->where('guards.admin_approved', 1)->where('guards.is_approved', 'yes')->select('name','id')->orderBy('name','ASC')->get();
          }
                return $results;
        }

        public function get_send_by_list($send_by){
            if ($send_by == 'customer') {
              $results=  DB::table('customers')->select('id', 'name')->orderBy('name','ASC')->get();
              }
              if($send_by == 'contractor'){
              $results=  DB::table('contractors')->select('id', 'name')->orderBy('name','ASC')->get();
              }
              return $results;
        
        }
        public function add_induction($title,$send_to,$send_by,$htmlBody,$send_by_list,$send_to_guards){
            $results=DB::table('inductions')->insert([
                'title' => $title,
                'send_to'=>$send_to,
                'send_by'=>$send_by,
                'html_Body'=>$htmlBody,
                'send_by_list'=>$send_by_list,
                'TIMESTAMP_INSERTED' => '',
                'selected_guards' => json_encode($send_to_guards)
            ]
            );
            return $results;
        }

        public function edit_induction($title,$send_to,$send_by,$htmlBody,$send_by_list,$send_to_guards,$inductionId){
            $results=DB::table('inductions')->where('id',$inductionId)->update([
                'title' => $title,
                'send_to'=>$send_to,
                'send_by'=>$send_by,
                'html_Body'=>$htmlBody,
                'send_by_list'=>$send_by_list,
                'selected_guards'=> json_encode($send_to_guards)
            ]
            );
            return $results;
        }
}
