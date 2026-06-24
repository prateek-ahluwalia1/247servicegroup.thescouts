<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Http\Request;

class InvoiceReport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
    	$request = request()->all();
    	$data = app('App\Http\Controllers\Reports')->invoice_report_data_new($request);
        
        if (isset($request['report_type']) && $request['report_type'] == 'hour') {
            return view('exports.hour_report', [
            'data' => $data
        ]);
        }else{
        if (isset($request['data_type']) && $request['data_type'] == 'normal') {
            // exit();
            return view('exports.invoice_report', [
            'data' => $data
        ]);
        }elseif(isset($request['data_type']) && $request['data_type'] == 'divide')
        {
            return view('exports.invoice_report_divide', [
            'data' => $data
        ]);
        }else{
            return view('exports.invoice_report', [
            'data' => $data
        ]);
        }
        
        }
    }
}
