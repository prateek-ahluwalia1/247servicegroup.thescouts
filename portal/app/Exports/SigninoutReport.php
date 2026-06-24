<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Http\Request;

class SigninoutReport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $request = request()->all();
        $data = app('App\Http\Controllers\JobRoster')->signin_out_report($request);
            return view('exports.signin_out_report', [
            'data' => $data
        ]);
        // echo view('exports.signin_out_report', [
            // 'data' => $data
        // ])->render();
        // exit;
        // print_r('<pre>');
        // print_r($data);
        // exit();
        // if (isset($request['report_type']) == 'hour') {
        
        // }else{
        // return view('exports.invoice_report', [
        //     'data' => $data
        // ]);
        // }
    }
}
