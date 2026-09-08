<?php
// index.php

// Sesuaikan path sesuai dengan struktur direktori Anda
require_once __DIR__ . '/../vendor/autoload.php';

use Mpdf\Mpdf;

class Generate_pdf extends CI_Controller
{
    public function pdf() {
    
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML('<h1>Hello world!</h1>');
    $mpdf->Output();
    }
}

// CodeIgniter akan berjalan seperti biasa 
?>