<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultisheetExport implements WithMultipleSheets
{
    use Exportable;

    // protected $year;
    
    // public function __construct(int $year)
    // {
    //     $this->year = $year;
    // }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new MultiCompletePaysheet();
        $sheets[] = new MultiInvoiceSheet();
        $sheets[] = new MultiHourSheet();
        $sheets[] = new MultiDivisionConsolidationSheet();
        $sheets[] = new MultiSigninOutSheet();
        return $sheets;
    }
}
