<?php

namespace App\Http\Resources\Job;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\HttpStatus;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\DB;

class JobRosterResource extends JsonResource {

    private $count;
    private $message;
    private $statusCode = HttpStatus::STATUS_OK;
    private $isShowJob;

    public function __construct($resource, $isShowJob = true) {
        parent::__construct($resource);
        $this->isShowJob = $isShowJob;
        $this->count = 1;
        if ($this->count == 0) {
            $this->message = 'No user found.';
            $this->statusCode = HttpStatus::STATUS_NO_CONTENT;
        }else{
            $this->message = 'You are successfully login!';
        }
    } 

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        if ($this->resource) {

            if ($this->job->job_instruction_file != '') {
                $this->job->job_instruction_file = 'https://'.request()->getHttpHost().'/asset_uploads/'.$this->job->job_instruction_file;
            }
            $roster = DB::table('job_roster_activities')->where(['guard_id' => $this->guard_id, 'job_roster_id' => $this->roster_id])->get();
            $already_signin = DB::table('job_roster_activities')->where(['guard_id' => $this->guard_id, 'status' => '1'])->get();
            $tasks = DB::table('job_roster_tasks')->where(['roster_id' => $this->roster_id])->get();
            $breaks = DB::table('job_breaks')->where(['roster_id' => $this->roster_id])->get();
            $breaks_data = array();
            foreach ($breaks as $b) {
                $breaks_data[] = array(
                    'id' => $b->id,
                    'start_time' => date('d-m-Y H:i', $b->start_time),
                    'end_time' => date('d-m-Y H:i', $b->end_time),
                    'notes' => $b->notes,
                    'inform_to' => $b->inform_to,
                    'break_status' => $b->job_status
                );
            }
            $task_array = array();
            foreach ($tasks as $t) {
                $task_status = false;
                $task_start_status = false;
                $task_end_status = false;
                if($t->start_time != '' && $t->end_time == ''){
                    $task_status = true;
                    $task_start_status = true;
                }
                if($t->end_time != ''){
                    $task_end_status = true;
                    $task_start_status = true;
                }
                $task_array[] = array(
                    'task_id' => $t->id,
                    'task_description' => $t->task_name,
                    'task_start_time' => $t->task_time,
                    'status' =>  $task_status,
                    'task_status' => $t->status,
                    'start_time' => $t->start_time,
                    'start_location' => $t->start_location,
                    'end_time' => $t->end_time,
                    'end_location' => $t->end_location,
                    'task_start_status' => $task_start_status,
                    'task_end_status' => $task_end_status
                );
            }
            
            $signin_status = 0;
            $signout_time = null;
            $completed_status = 0;
            $is_already_signin = 0;

                foreach($roster as $ros)
                    {   
                            $signin_status = $ros->status;
                        
                            $signout_time = $ros->signout_time;


                            if($signout_time != null){
                                $completed_status = 1;
                            }
                
                    }

                    foreach($already_signin as $ras)
                    {   
                           $is_already_signin = 1;
                
                    }



            return [
                'id' => $this->roster_id,
                'event_id' => $this->event_id,
                'guard_id' => $this->guard_id,
                'job_id' => $this->site_id,
                'break_status' => $this->break_status,
                'break_history' => $breaks_data,
                'tasks' => $task_array,
                'start' => date('H:i', strtotime($this->temp_start)),
                'instructions_file' => $this->instructions_file != '' ? 'https://'.request()->getHttpHost().'/asset_uploads/'.$this->instructions_file : "",
                // 'start' => date('d-m-Y', strtotime($this->temp_start)),
                'job_start_day' => date('d', strtotime($this->temp_start)),
                'job_start_date' => date('D', strtotime($this->temp_start)),
                'job_start_month' => date('M', strtotime($this->temp_start)),
                'job_start_year' => date('Y', strtotime($this->temp_start)),
                // 'end' => date('d-m-Y', strtotime($this->end)),
                'end' => date('H:i', strtotime($this->temp_end)). ' at '. date('d-m-Y', strtotime($this->temp_start)),
                'job_end_day' => date('d', strtotime($this->temp_start)),
                'job_end_date' => date('D', strtotime($this->temp_start)),
                'job_end_month' => date('M', strtotime($this->temp_start)),
                'job_end_year' => date('Y', strtotime($this->temp_start)),
                'temp_date' => $this->temp_date,
                'temp_start' => date('d-m-Y H:i:s', strtotime($this->temp_start)),
                'temp_end' => date('d-m-Y H:i:s', strtotime($this->temp_end)),
                // 'temp_start' => date('d-m-Y H:i:s', strtotime($this->temp_start) + (60*60*5)),
                // 'temp_end' => $this->temp_end,
                // 'temp_end' => date('d-m-Y H:i:s', strtotime($this->temp_end) + (60*60*5)),
                'publish_status' => $this->publish_status,
                'add_status' => $this->add_status,
                'job_status' => $this->job_status,
                'signin_status' => $this->signin_status == '0' ? 0 : 1 ,
                'shift_instructions' => $this->shift_instructions != null ? $this->shift_instructions : '',
                'completed_status' => $completed_status,
                'job' => $this->job,
                'guard' => new  UserResource($this->guards),
                'is_already_signin' => $is_already_signin,
                'job_roster_activities' => $this->rosterActivity
            ];            

        }
        return [];
    }

    public function with($request) {
        parent::with($request);
        if (!$this->resource) {
            return [];
        }
        return [
            'message' => $this->message,
            'status' => HttpStatus::STATUS_OK_LABEL,
            'code'  => HttpStatus::STATUS_OK,
            'meta' => [
                'host_url' => url('/'),
                'total' => $this->count,
                'request_time' => time()
            ],
        ];
    }

    public function withResponse($request, $response) {
        $response->setStatusCode($this->statusCode);
    }
}
