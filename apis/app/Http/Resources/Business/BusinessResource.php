<?php

namespace App\Http\Resources\Business;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\HttpStatus;

class BusinessResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {

        return [
            'id' => $this->id,
            'domain' => 'https://'.$this->domain.'.staffingsolutions.com.au/apis/',
            'sub_domain' => $this->domain,
            'title' => $this->title,
            'logo' => $this->logo != '' ? 'https://'.request()->getHttpHost().'/asset_uploads/'.$this->logo : "",
        ];
    }

}
