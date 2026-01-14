<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
use Dompdf\Options;



class Pdfgenerator {
    public function generate($html, $filename='', $paper = '', $orientation = '', $stream=TRUE)
    {   
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename.".pdf", array("Attachment" => 0));
            exit();
        } else {
            return $dompdf->output();
        }
    }
    public function generate_pdf($html, $filename='', $paper='', $orientation='', $stream=TRUE)
    {   
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        // $dompdf->stream($filename.".pdf", array("Attachment" => 0));
        if ($stream) {
            $dompdf->stream($filename.".pdf", array("Attachment" => 0));
            exit();
        } else {
            return $dompdf->output();
        }
    }

    public function generate_pdf_new($html, $filename = '', $orientation = 'portrait',$paper = '') {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();

        if ($filename != '') {
            $dompdf->stream($filename . '.pdf', array('Attachment' => 0));
        } else {
            return $dompdf->output();
        }
    }
}