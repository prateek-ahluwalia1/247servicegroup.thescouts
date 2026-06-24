<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Http\Request;

class AwardExport implements FromView
{
    
    public function view(): View
    {
        $request = request()->all();
        $data = app('App\Http\Controllers\report\AwardReport')->award_data($request);
        return view('exports.'.config('custom.paysheet_style'), [
            'data' => $data
        ]);
        // return view('exports.award_report', [
        //     'data' => $data
        // ]);
    }
}