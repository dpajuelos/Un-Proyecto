<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrganigramaController extends Controller
{
    public function pdf()
    {
        $data = []; // Aquí puedes pasar datos del organigrama
        $pdf = Pdf::loadView('organigrama.pdf', $data);
        return $pdf->download('organigrama.pdf');
    }
}