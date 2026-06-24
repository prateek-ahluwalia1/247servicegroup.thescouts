<?php

namespace App\Http\Resources\Guard;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\HttpStatus;

class GuardResource extends JsonResource
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'profile_image' => $this->profile_image != '' ? 'https://'.request()->getHttpHost().'/asset_uploads/'.$this->profile_image : "",
            'phone' => $this->phone,
            'state' => $this->state,
            'status' => $this->status,
            'admin_approved' => $this->admin_approved,
            'is_approved' => $this->is_approved,
            'address' => $this->address,
            'profile_completion' => $this->profile_completion,
            'security_license_file' => $this->security_license_file != '' ? 'https://'.request()->getHttpHost().'/asset_uploads/'.$this->security_license_file : "",
            'security_license_number' => $this->security_license_number,
            'security_license_expiration' => $this->security_license_expiration,
            'specific_customers_id' => json_decode($this->specific_customers_id, true),
            // 'addresss' => $this->addresss,
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
