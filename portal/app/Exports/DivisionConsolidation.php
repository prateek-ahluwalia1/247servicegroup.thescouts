<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Http\Request;

class DivisionConsolidation implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
    	$request = request()->all();
        // $data = app('App\Http\Controllers\Reports')->getDivisionConsolidationData($request);
    	$data['data'] = app('App\Http\Controllers\Reports')->exportDivisionDataNew($request);
        return view('exports.DivisionConsolidationNew', [
            'data' => $data['data'],
        ]); 
    }
}
