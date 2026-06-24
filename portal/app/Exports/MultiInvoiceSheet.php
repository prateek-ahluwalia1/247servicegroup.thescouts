<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Guard as Invoice;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class MultiInvoiceSheet implements FromView, WithTitle
{
    
    public function view(): View
    {
        $request = request()->all();
        $data = app('App\Http\Controllers\Reports')->invoice_report_data_new($request);
        return view('exports.invoice_report', [
            'data' => $data
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Invoice Report';
    }
}