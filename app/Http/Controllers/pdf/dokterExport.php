<?php

namespace App\Http\Controllers\pdf;

use App\Http\Controllers\Controller;
use App\Models\medikaDokter;
use Illuminate\Http\Request;
use PDF;

class dokterExport extends Controller
{
    public function exportPDF()
    {
        // Fetch data you want to export
        $data = medikaDokter::all();

        // Load the view and pass the data
        $pdf = PDF::loadView('pdf.Pdf', ['data' => $data]);

        // Download the PDF file
        return $pdf->download('Dokter.pdf');
    }
}
