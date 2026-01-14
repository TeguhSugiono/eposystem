<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_report_excel extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);        
        $this->mbatps = $this->load->database('mbatps', TRUE);     
    }


    function index(){

        // $array = array();

        // $array = array(
        //     array('ayam','duren','meja'),
        //     array('bebek','mangga','bangku')
        // );

        // print("<pre>".print_r($array,true)."</pre>"); die;
        // die;

        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_tbl_excel_configuration(){
        $query = " SELECT id_excel,index_excel,title_file_excel,name_sheet_excel,setting_template from tbl_excel_configuration " ;
        $data = $this->ptmsagate->query($query)->result();
        $comp = array(
            'table_data' => $data
        );        
        echo json_encode($comp);
    }

    function c_frmupload(){
        $this->load->view('upload');
    }

    function c_upload(){
        //$filename = 'import_data_setting_'.$this->session->userdata('username')  ;

        if(empty($_FILES['fileexcel']['tmp_name'])) {
            $pesan_data = array('pesan' => 'Tidak Ada File Yang DiUpload...');
            echo json_encode($pesan_data); die;
        }

        $file = pathinfo($_FILES['fileexcel']['name']);
 
        // ekstensi yang diijinkan
        $allowedExtension = ['xlsx', 'xls'];
        if(! in_array($file['extension'],$allowedExtension)) {
            $pesan_data = array('pesan' => 'File extension yang diijinkan .xlsx .xls ...');
            echo json_encode($pesan_data); die;
        }

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);

        // lokasi file excel dari file yang di upload
        $spreadsheet = $reader->load($_FILES['fileexcel']['tmp_name']);

        //ambil nama sheet pertama
        $sheetNames = $spreadsheet->getSheetNames()[0];
         
        //$worksheet = $spreadsheet->getActiveSheet();
        //ambil sheet by index 0 atau sheet pertama
        $worksheet = $spreadsheet->getSheet(0);
        $rows = $worksheet->toArray();
        
        // $array = array(
        //     array('ayam','duren','meja'),
        //     array('bebek','mangga','bangku')
        // );


        $dataexcel = array();        
        for($a=0;$a<count($rows);$a++){
            $array_tunggal = array();

            for($i=0;$i<count($rows[$a]);$i++){
                $strdata = str_replace("", null, $rows[$a][$i]) ;
                array_push($array_tunggal,$strdata);
            }

            array_push($dataexcel,$array_tunggal);
        }
        
        $pesan_data = array(
            'pesan' => 'Sukses...',
            //'data' => $rows,
            'dataexcel' => $dataexcel,
            'name_sheet_excel' => $sheetNames
        );
        echo json_encode($pesan_data); 
    }

    function c_simpan_upload(){
        $dataexcel = $this->input->post('dataexcel');
        $name_sheet_excel = $this->input->post('name_sheet_excel');
        $title_file_excel = $this->input->post('title_file_excel');
        $id_excel = $this->m_model->select_max_where('ptmsagate','tbl_excel_configuration','id_excel','');


        $data = array(
            'title_file_excel' => $title_file_excel,
            'name_sheet_excel' => $name_sheet_excel,
            'setting_template' => $dataexcel,
            'id_excel' => $id_excel,
            'flag_excel' => 0
        );
        
        $a = 0 ;

        $hasil = $this->ptmsagate->insert('tbl_excel_configuration', $data);        
        $queryku[$a++] = $this->ptmsagate->last_query();

        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Save Data Sukses..',
                'data' => $data,
                'queryku' => $queryku,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Simpan Upload Ke Table tbl_excel_configuration Error....!!!!',
                'data' => $data,
                'queryku' => $queryku,
            );
            echo json_encode($pesan_data);
            die;
        }

        echo json_encode($pesan_data);
    }

    function c_test(){
        $dataexcel = $this->input->post('dataexcel');
        $array_dataexcel = explode(',',$dataexcel);
        $data_asli = array();
        for($a=0;$a<count($array_dataexcel);$a++){
            array_push($data_asli,base64_decode($array_dataexcel[$a]));
        }
        $pesan_data = array(
            'data' => $data_asli,
        );
        echo json_encode($pesan_data); 
    }

}


//versi lain upload excel
// require_once 'vendor/autoload.php';
// $conn = mysqli_connect("localhost","root","","mbsgn");
 
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Reader\Csv;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
 
// if (isset($_POST['submit'])) {
 
//     $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
     
//     if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
     
//         $arr_file = explode('.', $_FILES['file']['name']);
//         $extension = end($arr_file);
     
//         if('csv' == $extension) {
//             $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
//         } else {
//             $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
//         }
 
//         $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
 
//         $sheetData = $spreadsheet->getActiveSheet()->toArray();
         
//         if (!empty($sheetData)) {
//             for ($i=1; $i<count($sheetData); $i++) {
//                 $name = $sheetData[$i][0];
//                 $email = $sheetData[$i][1];
// $sql = "INSERT INTO USERS(name, email) VALUES('$name', '$email')";

// if (mysqli_query($conn, $sql)) {
//  echo "New record created successfully";
// } else {
//  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
// }
//             }
//         }
//     }
// }