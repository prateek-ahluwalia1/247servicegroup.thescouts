<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use \PDF;

class Payslip extends Controller
{
    function payslip(Request $request)
    {
        // return view('pdf/payslip');
        $pdf = PDF::loadView('pdf/payslip');
        return $pdf->download(date('d/m/Y').'_payslip.pdf');
    }
}
