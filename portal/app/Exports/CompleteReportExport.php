<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Http\Request;

class CompleteReportExport implements FromView
{

public function view(): View
    {
    	$request = request()->all();
    	$data = app('App\Http\Controllers\Reports')->getCompleteReportData($request);
        // print_r('<pre>');
        // print_r($data);
        // exit();
        return view('exports.'.config('custom.paysheet_style'), [
            'data' => $data
        ]);
    }

    public function headings(): array
    {
        return [
            '#',
            'User',
            'Date',
        ];
    }
    public function columnFormats(): array
{
    return [
        'K' => FORMAT::NUMBER,
        'L' => FORMAT::NUMBER,
        'M' => FORMAT::NUMBER,
        'N' => FORMAT::NUMBER,
        'O' => FORMAT::NUMBER,
        'P' => FORMAT::NUMBER,
        'Q' => FORMAT::NUMBER,
        'R' => FORMAT::NUMBER,
        'S' => FORMAT::NUMBER,
        'T' => FORMAT::NUMBER,
        'U' => FORMAT::NUMBER,
        'V' => FORMAT::NUMBER,
        'W' => FORMAT::NUMBER,
        'X' => FORMAT::NUMBER,
        'Y' => FORMAT::NUMBER,
        'Z' => FORMAT::NUMBER,
        'AA' => FORMAT::NUMBER,
        'AB' => FORMAT::NUMBER,
        'AD' => FORMAT::NUMBER,
        'AE' => FORMAT::NUMBER,
        'AF' => FORMAT::NUMBER,
        'AG' => FORMAT::NUMBER,
    ];
}

}
