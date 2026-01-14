<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\XmlMiddleware;

class C_batal_container extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }     
        $this->db_tpsonline = $this->load->database('db_tpsonline', TRUE);     
    }


    function index(){

        $menu_active = $this->m_model->menu_active();

        $arraydata = array('' => 'ALL','Y'=> 'SUDAH KIRIM', 'N' => 'BELUM KIRIM');
        $SENDING = ComboNonDb($arraydata, 'SENDING', '', 'form-control form-control-sm');

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'SENDING' => $SENDING
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_import(){
        $this->load->view('import');
    }

    function c_table_batal(){

        $SENDING = $this->input->post('SENDING');

        $select = "NO_CONT,UK_CONT,REF_NUMBER,NO_SURAT,TGL_SURAT,NO_PLP,TGL_PLP,KD_KANTOR,TIPE_DATA,KD_TPS,ALASAN,NO_BC11,TGL_BC11,NM_PEMOHON,SENDING";
        $form = 'tbl_request_batal_container';
        $join = array();
        $where = array('SENDING <>' => 'D');

        if($SENDING != ""){
            $tambah_where = array('SENDING' => $SENDING);
            $where = array_merge($where, $tambah_where);
        }

        $where_like = array();        
        
        $where_term = array(
            'NO_CONT','UK_CONT','REF_NUMBER','NO_SURAT','TGL_SURAT','NO_PLP','TGL_PLP','KD_KANTOR','TIPE_DATA','KD_TPS','ALASAN','NO_BC11','TGL_BC11','NM_PEMOHON','SENDING'
        );
        $column_order = array(
            null,'NO_CONT','UK_CONT','REF_NUMBER','NO_SURAT','TGL_SURAT','NO_PLP','TGL_PLP','KD_KANTOR','TIPE_DATA','KD_TPS','ALASAN','NO_BC11','TGL_BC11','NM_PEMOHON','SENDING'
        );
        $order = array(
            'REF_NUMBER' => 'asc',
        );

        $group = '';

        $array_table = array(
            'select' => $select,
            'form' => $form,
            'join' => $join,
            'where' => $where,
            'where_like' => $where_like,
            'where_in' => array(),
            'where_not_in' => array(),
            'where_term' => $where_term,
            'column_order' => $column_order,
            'group' => $group,
            'order' => $order,
            'where_like_and' => array(),
        );

        $list = $this->m_model->get_datatables('db_tpsonline', $array_table);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $field->NO_CONT ;
            $row[] = $field->UK_CONT ;
            $row[] = $field->REF_NUMBER;
            $row[] = $field->NO_SURAT;
            $row[] = $field->TGL_SURAT;
            $row[] = $field->NO_PLP ;
            $row[] = $field->TGL_PLP ;
            $row[] = $field->KD_KANTOR;
            $row[] = $field->TIPE_DATA;      
            $row[] = $field->KD_TPS;            
            $row[] = $field->ALASAN ;
            $row[] = $field->NO_BC11 ;
            $row[] = $field->TGL_BC11 ;
            $row[] = $field->NM_PEMOHON ;
            $row[] = $field->SENDING ;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_model->count_all('db_tpsonline', $array_table),
            "recordsFiltered" => $this->m_model->count_filtered('db_tpsonline', $array_table),
            "data" => $data,
        );

        echo json_encode($output);
    }

    function c_import_table(){

        if(strlen($this->input->post('search_on_modal')) < 4){
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => array(),
            );
            echo json_encode($output);
            die;
        }

        $select = "NO_CONT,UK_CONT,REF_NUMBER,NO_SURAT,TGL_SURAT,NO_PLP,TGL_PLP,KD_KANTOR,TIPE_DATA,KD_TPS,ALASAN,NO_BC11,TGL_BC11,NM_PEMOHON";
        $form = 'view_data_lcl';
        $join = array();
        $where = array();

        $where_like = array();        
        $tambah_where = array(
            array('field' => 'NO_CONT', 'value' => $this->input->post('search_on_modal')),
        );
        $where_like = array_merge($where_like, $tambah_where);
        

        $where_term = array();
        $column_order = array(
            'NO_CONT','UK_CONT','REF_NUMBER','NO_SURAT','TGL_SURAT','NO_PLP','TGL_PLP','KD_KANTOR','TIPE_DATA','KD_TPS','ALASAN','NO_BC11','TGL_BC11','NM_PEMOHON'
        );
        $order = array(
            'REF_NUMBER' => 'asc',
            // 'NO_CONT' => 'desc',
        );

        $group = '';

        $array_table = array(
            'select' => $select,
            'form' => $form,
            'join' => $join,
            'where' => $where,
            'where_like' => $where_like,
            'where_in' => array(),
            'where_not_in' => array(),
            'where_term' => $where_term,
            'column_order' => $column_order,
            'group' => $group,
            'order' => $order,
            'where_like_and' => array(),
        );

        $list = $this->m_model->get_datatables('db_tpsonline', $array_table);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = $field->NO_CONT ;
            $row[] = $field->UK_CONT ;
            $row[] = $field->REF_NUMBER;
            $row[] = $field->NO_SURAT;
            $row[] = $field->TGL_SURAT;
            $row[] = $field->NO_PLP ;
            $row[] = $field->TGL_PLP ;
            $row[] = $field->KD_KANTOR;
            $row[] = $field->TIPE_DATA;      
            $row[] = $field->KD_TPS;            
            $row[] = $field->ALASAN ;
            $row[] = $field->NO_BC11 ;
            $row[] = $field->TGL_BC11 ;
            $row[] = $field->NM_PEMOHON ;
            
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_model->count_all('db_tpsonline', $array_table),
            "recordsFiltered" => $this->m_model->count_filtered('db_tpsonline', $array_table),
            "data" => $data,
        );

        echo json_encode($output);
    }

    function c_import_table_proses(){

        $dataOnTabel = $this->input->post('dataOnTabel') ;

        $KD_KANTOR = $dataOnTabel[7] ;
        $TIPE_DATA = $dataOnTabel[8] ;
        $KD_TPS = $dataOnTabel[9] ;
        $REF_NUMBER = $dataOnTabel[2] ;
        $NO_SURAT = $dataOnTabel[3] ;
        $TGL_SURAT = $dataOnTabel[4] ;
        $NO_PLP = $dataOnTabel[5] ;
        $TGL_PLP = $dataOnTabel[6] ;
        $ALASAN = $dataOnTabel[10] ;
        $NO_BC11 = $dataOnTabel[11] ;
        $TGL_BC11 = $dataOnTabel[12] ;
        $NM_PEMOHON = $dataOnTabel[13] ;
        $NO_CONT = $dataOnTabel[0] ;
        $UK_CONT = $dataOnTabel[1] ;

        //cek dulu
        if($this->db_tpsonline->get_where('tbl_request_batal_container',array('REF_NUMBER' => $REF_NUMBER,'NO_CONT' => $NO_CONT))->num_rows() > 0){
            $pesan_data = array(
                'msg' => 'Tidak', 
                'pesan' => 'Data Sudah Ada ....!!!! ', 
            );
            echo json_encode($pesan_data);
            die;
        }


        if($TGL_PLP == ""){
            $TGL_PLP = NULL ;
        }

        $datainsert = array(
            'KD_KANTOR' => $KD_KANTOR,
            'TIPE_DATA' => $TIPE_DATA,
            'KD_TPS' => $KD_TPS,
            'REF_NUMBER' => $REF_NUMBER,
            'NO_SURAT' => $NO_SURAT,
            'TGL_SURAT' => $TGL_SURAT,
            'NO_PLP' => $NO_PLP,
            'TGL_PLP' => $TGL_PLP,
            'ALASAN' => $ALASAN,
            'NO_BC11' => $NO_BC11,
            'TGL_BC11' => $TGL_BC11,
            'NM_PEMOHON' => $NM_PEMOHON,
            'NO_CONT' => $NO_CONT,
            'UK_CONT' => $UK_CONT,
        );

        $hasil = $this->db_tpsonline->insert('tbl_request_batal_container', $datainsert);
        if($hasil >= 1){
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Import Data Sukses ...',
            );

            echo json_encode($pesan_data);
        }else{
            $pesan_data = array(
                'msg' => 'Tidak', 
                'pesan' => 'Import Data Gagal ....!!!!', 
            );
            echo json_encode($pesan_data);
            die;
        }


        // $pesan = array(
        //     'dataOnTabel' => $this->input->post('dataOnTabel')
        // );
        // echo json_encode($pesan);
    }


    function c_edit(){

        $dataArrayTabel = $this->input->post('dataArrayTabel');


        $KD_KANTOR = $dataArrayTabel[8] ;
        $TIPE_DATA = $dataArrayTabel[9] ;
        $KD_TPS = $dataArrayTabel[10] ;
        $REF_NUMBER = $dataArrayTabel[3] ;
        $NO_SURAT = $dataArrayTabel[4] ;
        $TGL_SURAT = $dataArrayTabel[5] ;
        $NO_PLP = $dataArrayTabel[6] ;
        $TGL_PLP = $dataArrayTabel[7] ;
        $ALASAN = $dataArrayTabel[11] ;
        $NO_BC11 = $dataArrayTabel[12] ;
        $TGL_BC11 = $dataArrayTabel[13] ;
        $NM_PEMOHON = $dataArrayTabel[14] ;
        $NO_CONT = $dataArrayTabel[1] ;
        $UK_CONT = $dataArrayTabel[2] ;
        $SENDING = $dataArrayTabel[15] ;

        $arraydata = array(
            'KD_KANTOR' => $KD_KANTOR,
            'TIPE_DATA' => $TIPE_DATA,
            'KD_TPS' => $KD_TPS,
            'REF_NUMBER' => $REF_NUMBER,
            'NO_SURAT' => $NO_SURAT,
            'TGL_SURAT' => $TGL_SURAT,
            'NO_PLP' => $NO_PLP,
            'TGL_PLP' => $TGL_PLP,
            'ALASAN' => $ALASAN,
            'NO_BC11' => $NO_BC11,
            'TGL_BC11' => $TGL_BC11,
            'NM_PEMOHON' => $NM_PEMOHON,
            'NO_CONT' => $NO_CONT,
            'UK_CONT' => $UK_CONT,
            'SENDING' => $SENDING
        );

        $comp = array(
            'dataArrayTabel' => $arraydata
        );

        $this->load->view('edit',$comp);
    }

    function c_update(){

        $KD_KANTOR = $this->input->post('KD_KANTOR');
        $TIPE_DATA = $this->input->post('TIPE_DATA');
        $KD_TPS = $this->input->post('KD_TPS');
        $REF_NUMBER = $this->input->post('REF_NUMBER');
        $NO_SURAT = $this->input->post('NO_SURAT');
        $TGL_SURAT = $this->input->post('TGL_SURAT');
        if($TGL_SURAT == ""){
            $TGL_SURAT = NULL ;
        }
        $NO_PLP = $this->input->post('NO_PLP');
        $TGL_PLP = $this->input->post('TGL_PLP');
        if($TGL_PLP == ""){
            $TGL_PLP = NULL ;
        }
        $ALASAN = $this->input->post('ALASAN');
        $NO_BC11 = $this->input->post('NO_BC11');
        $TGL_BC11 = $this->input->post('TGL_BC11');
        if($TGL_BC11 == ""){
            $TGL_BC11 = NULL ;
        }
        $NM_PEMOHON = $this->input->post('NM_PEMOHON');
        $NO_CONT = $this->input->post('NO_CONT');
        $UK_CONT = $this->input->post('UK_CONT');
        $SENDING = $this->input->post('SENDING');


        if($SENDING == "Y"){
            $pesan_data = array(
                'msg' => 'Tidak', 
                'pesan' => 'Update Data Gagal Data Sudah Dikirim....!!!!', 
            );
            echo json_encode($pesan_data);
            die;
        }

        $arraydata = array(
            'TIPE_DATA' => $TIPE_DATA,
            'NO_SURAT' => $NO_SURAT,
            'TGL_SURAT' => $TGL_SURAT,
            'NO_PLP' => $NO_PLP,
            'TGL_PLP' => $TGL_PLP,
            'ALASAN' => $ALASAN,
            'NO_BC11' => $NO_BC11,
            'TGL_BC11' => $TGL_BC11,
            'NM_PEMOHON' => $NM_PEMOHON,
            'UK_CONT' => $UK_CONT,
        );


        $hasil = $this->m_model->updatedata('db_tpsonline', 'tbl_request_batal_container', $arraydata, array('REF_NUMBER' => $REF_NUMBER,'NO_CONT' => $NO_CONT)) ;
        if($hasil >= 1){
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Update Data Sukses ...',
            );

            echo json_encode($pesan_data);
        }else{
            $pesan_data = array(
                'msg' => 'Tidak', 
                'pesan' => 'Update Data Gagal ....!!!!', 
            );
            echo json_encode($pesan_data);
            die;
        }

    }

    function c_exportbatal(){
        $data = base64_decode($_GET['data']) ;
        $data = explode(',', $data);

        $arraydata = array();
        for($a = 0 ; $a < count($data) ; $a++ ){
            $decryptTemp = $data[$a] ;
            $decryptTemp = base64_decode($decryptTemp) ;
            $decryptTemp = explode(',', $decryptTemp);
           array_push($arraydata, $decryptTemp) ;
        }

        //select data to export
        $where_in1 = array();
        $where_in2 = array();
        for($c = 0 ; $c < count($arraydata) ; $c++ ){
            array_push($where_in1, $arraydata[$c][1]) ;
            array_push($where_in2, $arraydata[$c][3]) ;
        }

        // echo '<pre>';
        // print_r($where_in1);
        // echo '</pre>';

        $this->db_tpsonline->where_in('NO_CONT',$where_in1);
        $this->db_tpsonline->where_in('REF_NUMBER',$where_in2);
        $data = $this->db_tpsonline->get('tbl_request_batal_container')->result_array();
        //echo $this->db_tpsonline->last_query();

        $nama_excel = "Report Batal PLP_".tanggal_sekarang() ;

        //Setting Sheet Excel
        $nama_sheet = array(
            '0' => 'Batal PLP',
        );

        $data_all_sheet = array(
            '0' => $data,
        );

        $setting_xls = array(
            'jumlah_sheet' => 1 ,
            'nama_excel' => $nama_excel,
            'nama_sheet' => $nama_sheet,
            'data_all_sheet' => $data_all_sheet,
        );

        //print("<pre>".print_r($setting_xls,true)."</pre>"); die;
        $this->m_model->generator_xls($setting_xls);

        // echo '<pre>';
        // print_r($arraydata);
        // echo '</pre>';

    }


    function c_kirimdata(){
        $dataArrayTabel = $this->input->post('dataArrayTabel');


        $KD_KANTOR = $dataArrayTabel[8] ;
        $TIPE_DATA = $dataArrayTabel[9] ;
        $KD_TPS = $dataArrayTabel[10] ;
        $REF_NUMBER = $dataArrayTabel[3] ;
        $NO_SURAT = $dataArrayTabel[4] ;
        $TGL_SURAT = $dataArrayTabel[5] ;
        $NO_PLP = $dataArrayTabel[6] ;
        $TGL_PLP = $dataArrayTabel[7] ;
        $ALASAN = $dataArrayTabel[11] ;
        $NO_BC11 = $dataArrayTabel[12] ;
        $TGL_BC11 = $dataArrayTabel[13] ;
        $NM_PEMOHON = $dataArrayTabel[14] ;
        $NO_CONT = $dataArrayTabel[1] ;
        $UK_CONT = $dataArrayTabel[2] ;


        $creataXml = "<BATALPLP>" ;
        $creataXml.= "<HEADER>" ;
        $creataXml.= "<KD_KANTOR>".$KD_KANTOR."</KD_KANTOR" ;
        $creataXml.= "<TIPE_DATA>".$TIPE_DATA."</TIPE_DATA>" ;
        $creataXml.= "<KD_TPS>".$KD_TPS."</KD_TPS>" ;
        $creataXml.= "<REF_NUMBER>".$REF_NUMBER."</REF_NUMBER>" ;
        $creataXml.= "<NO_SURAT>".$NO_SURAT."</NO_SURAT>" ;
        $creataXml.= "<TGL_SURAT>".$TGL_SURAT."</TGL_SURAT>" ;
        $creataXml.= "<NO_PLP>".$NO_PLP."</NO_PLP>" ;
        $creataXml.= "<TGL_PLP>".$TGL_PLP."</TGL_PLP>" ;
        $creataXml.= "<ALASAN>".$ALASAN."</ALASAN>" ;
        $creataXml.= "<NO_BC11>".$NO_BC11."</NO_BC11>" ;
        $creataXml.= "<TGL_BC11>".$TGL_BC11."</TGL_BC11>" ;
        $creataXml.= "<NM_PEMOHON>".$NM_PEMOHON."</NM_PEMOHON>" ;
        $creataXml.= "</HEADER>" ;
        $creataXml.= "<DETIL>" ;
        $creataXml.= "<CONT>" ;
        $creataXml.= "<NO_CONT>".$NO_CONT."</NO_CONT>" ;
        $creataXml.= "<UK_CONT>".$UK_CONT."</UK_CONT>" ;
        $creataXml.= "</CONT>" ;
        $creataXml.= "</DETIL>" ;
        $creataXml.= "</BATALPLP>" ;






        $xml_data = '<fStream><![CDATA[<?xml version="1.0" encoding="utf-8"?>
                    <DOCUMENT xmlns="loadbatalplp.xsd">
                        '.$creataXml.'
                    </DOCUMENT>]]></fStream>';


        $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => 'UploadBatalPLP')); 

        $xml_param = str_replace("<fStream>string</fStream>",$xml_data,$format_xml);

        $options = [
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ],
            'body' => $xml_param,
        ];

        $responsebody = '';
        $client = new client();        
        $response = $client->request('POST', 'https://tpsonline.beacukai.go.id/tps/service.asmx', $options);
        $responsebody = $response->getBody()->getContents();

        // preg_match_all("#<CoarriCodeco_ContainerResult>(.+?)</CoarriCodeco_ContainerResult>#", $responsebody, $matches);

        // $dataku = '';
        // foreach ($matches[0] as $value) {
        //     $dataku = $value;
        // }
        
        // $xml = simplexml_load_string($dataku);
        // $json  = json_encode($xml);
        // $xmlArr = json_decode($json, true);


        
        $this->m_model->save_response('UploadBatalPLP',$xml_param,$responsebody);
        

        $pesan_data = array(
            'pesan' => $xml_param,
            'responsebody' => $responsebody,
        );
        echo json_encode($pesan_data);


    }





}