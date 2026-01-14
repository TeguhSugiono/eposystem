<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\XmlMiddleware;

class C_CekDataGagalKirim extends CI_Controller {

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
        // $startdate = '01-03-2022' ;
        // $enddate = '31-03-2022' ;

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

        // $data_validasi = isset($xmlArr[0]) ? $xmlArr[0] : '' ;
        // $data_gagal_terkirim = array() ;

        // $msg = "Tidak" ;
        // $pesan = "Error Tidak Dapat Teridentifikasi...(Error Server Portal Bea Cukai)" ;
        // if($data_validasi == ""){
        //     $msg = "Ya" ;
        //     $pesan = "Proses Cek Data Finish..." ;
        //     $data_gagal_terkirim = isset($xmlArr['REF_NO']) ? $xmlArr['REF_NO']['RN'] : array();
            
        //     $newarray =  array_filter($data_gagal_terkirim, fn($value) => !is_null($value) && $value !== '' && $value !== []) ;

        //     print_r($newarray);

        //     // for($a = 0 ; $a < count ((array) $data_gagal_terkirim) ; $a++){
        //     //     echo $data_gagal_terkirim[$a] ;
        //     //     echo '<br>' ;
        //     // }


        //     die;
            
        // }else{
        //     $msg = "Tidak" ;
        //     $pesan = $data_validasi ;
        // }

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
        $xml_param = str_replace("<UserName>string</UserName>","<UserName>".$Username."</UserName>",$format_xml);
        $xml_param = str_replace("<Password>string</Password>","<Password>".$Password."</Password>",$xml_param);
        $xml_param = str_replace("<Tgl_Awal>string</Tgl_Awal>","<Tgl_Awal>".$startdate."</Tgl_Awal>",$xml_param);
        $xml_param = str_replace("<Tgl_Akhir>string</Tgl_Akhir>","<Tgl_Akhir>".$enddate."</Tgl_Akhir>>",$xml_param);

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
        $data_gagal_terkirim = array() ;
        $jml_data_gagal_terkirim = 0 ;

        $msg = "Tidak" ;
        $pesan = "Error Tidak Dapat Teridentifikasi...(Error Server Portal Bea Cukai)" ;
        if($data_validasi == ""){
            $msg = "Ya" ;
            $pesan = "Proses Cek Data Finish..." ;
            $data_gagal_terkirim = isset($xmlArr['REF_NO']['RN']) ? $xmlArr['REF_NO']['RN'] : array();
            
// $data_gagal_terkirim =  array_filter($data_gagal_terkirim, fn($value) => !is_null($value) && $value !== '' && $value !== []) ;

$data_gagal_terkirim = array_filter($data_gagal_terkirim, function($value){return !is_null($value) && $value !== ''; }) ;

            //fungsi dibawah ini untuk mengurutkan array yang index nya ngaco karena ada penghapusan array di index yang random
            $arrays = $data_gagal_terkirim;
            $data_gagal_terkirim = array();
            $i = 0;
            foreach ($arrays as $k => $item) {
                $data_gagal_terkirim[$i] = $item;
                unset($arrays[$k]);
                $i++;
            }

            $jml_data_gagal_terkirim = count ((array) $data_gagal_terkirim) ;
            
        }else{
            $msg = "Tidak" ;
            $pesan = $data_validasi ;
        }

        $pesan_data = array(
            'msg' => $msg,
            'pesan' => $pesan,
            'xmlArr' => $xmlArr,
            'data_gagal_terkirim' => $data_gagal_terkirim,
            'jml_data_gagal_terkirim' => $jml_data_gagal_terkirim
        );
        echo json_encode($pesan_data);
    }


}