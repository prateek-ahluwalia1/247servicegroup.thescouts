<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Guard as Invoice;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class MultiCompletePaysheet implements FromView, WithTitle
{
    // private $month;
    // private $year;

    // public function __construct(int $year, int $month)
    // {
    //     $this->month = $month;
    //     $this->year  = $year;
    // }

    /**
     * @return Builder
     */
    // public function query()
    // {
    //     return Invoice
            // ::query()
            // ->whereYear('created_at', $this->year)
            // ->whereMonth('created_at', $this->month);
    // }
    public function view(): View
    {
        $request = request()->all();
        $data = app('App\Http\Controllers\Reports')->getCompleteReportData($request);
        return view('exports.'.config('custom.paysheet_style'), [
            'data' => $data
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Complete Paysheet';
    }
}