<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once 'dompdf/autoload.inc.php';

/* use Dompdf\Dompdf;

class Pdf extends Dompdf
{
	public function __construct()
	{
		 parent::__construct();
	} 
} 
 */
use Dompdf\Dompdf;
class Pdf extends Dompdf{

    public $filename;
    public function __construct(){
        parent::__construct();
        $this->filename = "laporan.pdf";
    }
    
    protected function ci()
    {
        return get_instance();
    }
   
    public function load_view($view, $data = array()){
        $html = $this->ci()->load->view($view, $data, TRUE);
        $this->load_html($html);

        $this->render();
  
               $this->stream($this->filename, array("Attachment" => false));

 }
}

/* class pdf {

    function __construct() {
        include_once APPPATH . '/third_party/fpdf/fpdf.php';
    }
}
 */
?>