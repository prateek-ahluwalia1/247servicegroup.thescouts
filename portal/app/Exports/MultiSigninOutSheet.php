<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Guard as Invoice;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class MultiSigninOutSheet implements FromView, WithTitle
{
    
    public function view(): View
    {
        $request = request()->all();
        $request['date'] = $request['search'];
        $data = app('App\Http\Controllers\JobRoster')->signin_out_report($request);
            return view('exports.signin_out_report', [
            'data' => $data
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'SignIn-Out';
    }
}