<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use SnappyPDF;

class ChartController extends Controller
{
    public function pdf1()
    {
        $pdf = \SnappyPDF::loadView('admin.pdf.chart3');
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('javascript-delay', 5000);
        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('no-stop-slow-scripts', true);
        return $pdf->download('chart1.pdf');
    }
    public function pdf2(){
        $pdf = PDF::loadView('admin.pdf.chart2')->setPaper('a4', 'potrait');

        return $pdf->stream(); 
    }
}
