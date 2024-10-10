<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF; // Pastikan Anda menambahkan ini

class PDFController extends Controller
{
    public function generatePDF()
    {
        $data = ['title' => 'Welcome to Laravel PDF!'];
        $pdf = PDF::loadView('pdf_view', $data);
        return $pdf->download('laravel_pdf.pdf');
    }
}
