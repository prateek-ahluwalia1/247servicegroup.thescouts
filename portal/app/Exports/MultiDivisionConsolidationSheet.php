<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Guard as Invoice;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class MultiDivisionConsolidationSheet implements FromView, WithTitle
{
    
    public function view(): View
    {
        $request = request()->all();
        $request['date'] = $request['search'];
        $data['data'] = app('App\Http\Controllers\Reports')->exportDivisionDataNew($request);
        return view('exports.DivisionConsolidationNew', [
            'data' => $data['data'],
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Division Consolidation';
    }
}