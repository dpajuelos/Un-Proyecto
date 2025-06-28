<?php

namespace App;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGenerator
{
    protected $dompdf;

    public function __construct()
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $this->dompdf = new Dompdf($options);
    }

    public function createPdf($data)
    {
        // Load the HTML content from the Blade view
        $html = view('organigrama', ['data' => $data])->render();

        // Load the HTML into Dompdf
        $this->dompdf->loadHtml($html);

        // Set paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $this->dompdf->render();

        // Output the generated PDF to Browser
        $this->dompdf->stream('organigrama.pdf', ['Attachment' => false]);
    }
}