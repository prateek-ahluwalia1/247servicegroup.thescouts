<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contractor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ContractorController extends ApiController
{
    //

    function getContractors(Request $request)
    {
        $contractors = Contractor::where('status', 'active')->orderBy('name', 'ASC')->get();
        if (count($contractors) > 0) {
            foreach ($contractors as $contractor) {
                $contractor->specific_sites_id = json_decode($contractor->specific_sites_id, true);
                $contractor->multiple_states = json_decode($contractor->multiple_states, true);
                $contractor->specific_customer = json_decode($contractor->specific_customer, true);
                $contractor->specific_sites = json_decode($contractor->specific_sites, true);
                if ($contractor->image != '' || $contractor->image != null) {
                    $contractor->image = $contractor->image != '' ? 'https://'.request()->getHttpHost().'/asset_uploads/'.$contractor->image : "";
                }
                unset($contractor->password);
            }
            $this->response = ['status' => true, 'message' => 'Data found', 'contractors' => $contractors];
        }else{
            $this->response = ['status' => false, 'error' => 'Not contractor found!'];
        }
        $this->statusCode = self::STATUS_CODE_200;
        return $this->sendResponse();
    }
}
