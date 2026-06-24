<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Http\Request;

class SignInOutExport implements FromView
{
    public function view(): View
    {
        $request = request()->all();
        $data = app('App\Http\Controllers\Reports')->getSigninOutReportData($request);
        // print_r('<pre>');
        // print_r($data);
        // exit();
        return view('exports.Signinout_report', [
            'data' => $data
        ]);
    }

}
