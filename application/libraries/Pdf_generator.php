<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;

class Pdf_generator {

    public function generate_pdf($html, $filename = '', $orientation = 'portrait') {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', $orientation);
        $dompdf->render();

        if ($filename != '') {
            $dompdf->stream($filename . '.pdf', array('Attachment' => 0));
        } else {
            return $dompdf->output();
        }
    }
}
?>
