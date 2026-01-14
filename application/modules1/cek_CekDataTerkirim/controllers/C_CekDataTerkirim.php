<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\XmlMiddleware;

class C_CekDataTerkirim extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }     
        $this->db_tpsonline = $this->load->database('db_tpsonline', TRUE);     
    }

    function index(){


        // $nama_function = $this->uri->segment(2) ;

        // $Username = 'MBA0' ;
        // $Password = 'MBA1234560' ;
        // $startdate = '28-06-2022' ;
        // $enddate = '28-06-2022' ;

        // $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => $nama_function));
        // $xml_param = str_replace("<UserName>string</UserName>","<UserName>".$Username."</UserName>",$format_xml);
        // $xml_param = str_replace("<Password>string</Password>","<Password>".$Password."</Password>",$xml_param);
        // $xml_param = str_replace("<Tgl_Awal>string</Tgl_Awal>","<Tgl_Awal>".$startdate."</Tgl_Awal>",$xml_param);
        // $xml_param = str_replace("<Tgl_Akhir>string</Tgl_Akhir>","<Tgl_Akhir>".$enddate."</Tgl_Akhir>>",$xml_param);

        // $options = [
        //     'headers' => [
        //         'Content-Type' => 'text/xml; charset=UTF8',
        //     ],
        //     'body' => $xml_param,
        // ];            

        // $client = new client();        
        // $responsebody = '';
        // $response = $client->request('POST', 'https://tpsonline.beacukai.go.id/tps/service.asmx', $options);
        // $responsebody = $response->getBody()->getContents();

        // $str_respon= str_replace(['&lt;','&gt;'],['<','>'], $responsebody);
        // preg_match_all("#<RESPON>(.+?)</RESPON>#", $str_respon, $matchesx);
        // $dataku = '' ;
        // foreach($matchesx[0] as $value) {
        //   $dataku = $value ;
        // }
        // $xml = simplexml_load_string($dataku);
        // $json  = json_encode($xml);
        // $xmlArr = json_decode($json, true);

        // $pesan = "" ;

        // $data_validasi = isset($xmlArr[0]) ? $xmlArr[0] : 'Error Tidak Dapat Teridentifikasi...(Error Server Portal Bea Cukai)' ;
        // $data_container = isset($xmlArr['CoarriCodeco_Container']) ? $xmlArr['CoarriCodeco_Container'] : array();
        // $data_kemasan = isset($xmlArr['CoarriCodeco_Kemasan']) ? $xmlArr['CoarriCodeco_Kemasan'] : array();

        // if(count ((array)$data_container) > 0 || count ((array)$data_kemasan) > 0){
        //     echo 'Data Ditemukan' ;
        // }else{
        //     echo $data_validasi ;
        // }

        // die;

        $menu_active = $this->m_model->menu_active();

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
        );
        $this->load->view('dashboard/index', $data);
    }


    function c_download(){

        $nama_function = $this->uri->segment(2) ;

        $Username = $this->input->post('Username') ;
        $Password = $this->input->post('Password') ;
        $startdate = $this->input->post('startdate') ;
        $enddate = $this->input->post('enddate') ;

        $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => $nama_function));

        //replace_xml_condition($Tag,$TagString,$Value,$DataMentah)
        $xml_param = replace_xml_condition('UserName','string',$Username,$format_xml);
        $xml_param = replace_xml_condition('Password','string',$Password,$xml_param);
        $xml_param = replace_xml_condition('Tgl_Awal','string',$startdate,$xml_param);
        $xml_param = replace_xml_condition('Tgl_Akhir','string',$enddate,$xml_param);

        $options = [
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ],
            'body' => $xml_param,
        ];            

        $client = new client();        
        $responsebody = '';
        $response = $client->request('POST', 'https://tpsonline.beacukai.go.id/tps/service.asmx', $options);
        $responsebody = $response->getBody()->getContents();

        $str_respon= str_replace(['&lt;','&gt;'],['<','>'], $responsebody);
        preg_match_all("#<RESPON>(.+?)</RESPON>#", $str_respon, $matchesx);
        $dataku = '' ;
        foreach($matchesx[0] as $value) {
          $dataku = $value ;
        }
        $xml = simplexml_load_string($dataku);
        $json  = json_encode($xml);
        $xmlArr = json_decode($json, true);

        $data_validasi = isset($xmlArr[0]) ? $xmlArr[0] : '' ;
        $data_container = isset($xmlArr['CoarriCodeco_Container']) ? $xmlArr['CoarriCodeco_Container'] : array();
        $data_kemasan = isset($xmlArr['CoarriCodeco_Kemasan']) ? $xmlArr['CoarriCodeco_Kemasan'] : array();

        $jml_data_container = count ((array)$data_container) ;
        $jml_data_kemasan = count ((array)$data_kemasan) ;

        $msg = "Tidak" ;
        $pesan = "Error Tidak Dapat Teridentifikasi...(Error Server Portal Bea Cukai)" ;
        if($data_validasi == ""){
            $msg = "Ya" ;
            $pesan = "Proses Cek Data Finish..." ;
        }else{
            $msg = "Tidak" ;
            $pesan = $data_validasi ;
        }

        $pesan_data = array(
            'msg' => $msg,
            'pesan' => $pesan,
            'data_container' => $data_container,
            'jml_data_container' => $jml_data_container, 
            'data_kemasan' => $data_kemasan,
            'jml_data_kemasan' => $jml_data_kemasan
        );
        echo json_encode($pesan_data);
    }

    function c_sinkron_to_gateinfcl(){
        $data_container = $this->input->post('data_container');

        $pesan_data = array(
            'data_container'  =>  $data_container
        );


        // echo json_encode($pesan_data);
        // die;

        $tempquery = "" ;

        $this->db_tpsonline->where_in('REF_NUMBER',$data_container);
        //$this->db_tpsonline->where(array('VALIDATE' => 'N'));
        $hasil = $this->db_tpsonline->update('tbl_request_plp_in_container', 
            array('VALIDATE' => 'Y','SENDING' => 'Y'));

        $tempquery = $this->db_tpsonline->last_query() ;

        $this->db_tpsonline->where_in('REF_NUMBER',$data_container);
        //$this->db_tpsonline->where(array('VALIDATE' => 'N'));
        $hasil1 = $this->db_tpsonline->update('tbl_request_plp_out_container', 
            array('VALIDATE' => 'Y','SENDING' => 'Y'));

        $tempquery = $tempquery ." <<<>>> ".$this->db_tpsonline->last_query() ;


        $pesan_data = array(
            'data_container'  =>  $data_container,
            'query' => $tempquery
        );


        echo json_encode($pesan_data);
    }

    function c_sinkron_to_gateinlcl(){
        $data_kemasan = $this->input->post('data_kemasan');

        $tempquery = "" ;

        $this->db_tpsonline->where_in('REF_NUMBER',$data_kemasan);
        //$this->db_tpsonline->where(array('VALIDATE' => 'N'));
        $hasil = $this->db_tpsonline->update('tbl_request_plp_in_kemasan', 
            array('VALIDATE' => 'Y','SENDING' => 'Y'));
        
        $tempquery = $this->db_tpsonline->last_query() ;

        $this->db_tpsonline->where_in('REF_NUMBER',$data_kemasan);
        //$this->db_tpsonline->where(array('VALIDATE' => 'N'));
        $hasil1 = $this->db_tpsonline->update('tbl_request_plp_out_kemasan', 
            array('VALIDATE' => 'Y','SENDING' => 'Y'));

        $tempquery = $tempquery ." <<<>>> ".$this->db_tpsonline->last_query() ;

        $pesan_data = array(
            'data_kemasan'  =>  $data_kemasan,
            'query' => $tempquery
        );


        echo json_encode($pesan_data);
    }

    
}