<?php

namespace App\Http\Resources\Job;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\HttpStatus;

class JobRosterResource extends JsonResource
{
   /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private $count;
    private $message;
    private $statusCode = HttpStatus::STATUS_OK;

    public function __construct($resource) {
        parent::__construct($resource);
        $this->count = 1;
        if ($this->count == 0) {
            $this->message = 'No leave request found.';
            $this->statusCode = HttpStatus::STATUS_NO_CONTENT;
        }else{
            $this->message = 'Data Received.';
        }
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $missed = false;
        $className = 'custom-color-blue';
        $color = '#ffff00';
        $eventBorderColor = '#84b3cd40';
         if($this->job_status == "pending"){
                $color = "#ffff00";
                $eventBorderColor = '#84b3cd40';
            }
            if($this->job_status == 'rejected'){
            $className = 'custom-color-yellow';
            $textColor = "#000";
            $color = "#ffff00";
            }elseif($this->guard_id == '' || $this->guard_id == 0) {
                $color = "#ffff00";
            $className = 'custom-color-yellow';
            }elseif ($this->publish_status == 1) {
            $className = 'custom-colors-publish';
                
            }elseif($this->publish_status == 0){
            $className = 'custom-colors-unpublish';
            }else{
            $className = 'custom-color-dark-khaki';
            }

            if($this->job_status == "confirmed"){
                    $color = "#92D050";
            }elseif($this->job_status == "completed"){
                $color = "#92D050";
            }
            $message = 'No '.config('custom.guard').'<br>accepted the job<br> yet';
            if ($this->post_status == '0') {
                $message = 'Uncovered Shift';

            }
            $title = ($this->guard_id != '' && $this->guard_id > 0) ? $this->name : $message;
            if($this->job_status == "completed"){

                $title = $title .' (C)';

            }
            $current_time = date('Y-m-d H:i');
            if ($this->temp_start < date('Y-m-d H:i') && $this->job_status != 'rejected' && $this->publish_status == 1) {
                if ($this->activity_id != null) {
                if ($this->guard_id != '') {
                $className = 'custom-color-red-orange';
                }
                $textColor = '#000';
                // $data['color'] = "#FFFF00";
                if ($this->job_start < time()) {
                $title = $title .' (M)';
                $missed = true;
                }
                }elseif($this->activity_status == 1){
                $title = $title .' (S)';
                }elseif($this->activity_status == 0){
                // $title = $title .' (C)';
                }

            }
            $same = false;
            if (date('Y-m-d' , strtotime($this->temp_start)) ==  date('Y-m-d' , strtotime($this->temp_end))) {
                $same = true;
            }
            if ($same == false) {
            // $title .= ' (Shift End: '.date('H:i', strtotime($this->temp_end)).')';
            }
            if ($this->job_status == 'rejected') {
                if ($this->rejected_by > 0) {
                    $message = 'Shift denied by '. $this->rejected_by_name;
                }else{
                    $message = 'Shift denied';
                }
                
                $title = $message;
            }

        return [
            'id' => $this->event_id,
            'customer_name' =>  $this->customer_name,
            'className' => $className. ' custom-roster-'.$this->roster_id,
            'color' => $color,
            'eventBorderColor' => $eventBorderColor,
            'title' => $title,
            'current_time' => $current_time,
            'training' =>  $this->training,
            'start_time' =>  $this->temp_start,
            'site_name' =>  $this->site_name,
            'site_description' =>  $this->site_description,
            'site_address' =>  $this->site_address,
            'tooltip' =>  ($this->operators_notes == null) ? '' : $this->operators_notes,
            'description' =>  ($this->operators_notes == null) ? '' : $this->operators_notes,
            'job_start' =>  date('Y-m-d H:i:s', $this->job_start),
            'job_end' =>  date('Y-m-d H:i:s', $this->job_end),
            'end_time' =>  $this->temp_end,
            'start' => ($same == true) ? $this->temp_start : $this->temp_start,
            'end' => ($same == true) ? $this->temp_end : $this->temp_end,
            'guardId' => $this->guard_id,
            'guard_phone' => ($this->guard_id > 0) ? $this->phone : '',
            'missed' => $missed,
            'site_id' => $this->site_id,
            'location' => 'N/A',
            'post_status' => $this->post_status,
            'same' => $same,
            'day' => date('D', $this->job_start)

        ];
    }

    public function with($request) {
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
