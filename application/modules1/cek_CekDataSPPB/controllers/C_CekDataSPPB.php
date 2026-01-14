<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\XmlMiddleware;

class C_CekDataSPPB extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }     
        $this->db_tpsonline = $this->load->database('db_tpsonline', TRUE);     
    }

    function index(){

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
        $Tgl_SPPB = $this->input->post('Tgl_SPPB') ;

        $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => $nama_function));
        $xml_param = str_replace("<UserName>string</UserName>","<UserName>".$Username."</UserName>",$format_xml);
        $xml_param = str_replace("<Password>string</Password>","<Password>".$Password."</Password>",$xml_param);
        $xml_param = str_replace("<Tgl_SPPB>string</Tgl_SPPB>","<Tgl_SPPB>".$Tgl_SPPB."</Tgl_SPPB>",$xml_param);

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
        $data_sppb = array() ;
        $jml_data_sppb = 0 ;

        $msg = "Tidak" ;
        $pesan = "Error Tidak Dapat Teridentifikasi...(Error Server Portal Bea Cukai)" ;
        if($data_validasi == ""){
            $msg = "Ya" ;
            $pesan = "Proses Cek Data Finish..." ;
            $data_sppb = isset($xmlArr['SPPB_NO']['DT']) ? $xmlArr['SPPB_NO']['DT'] : array();

            $jml_data_sppb = count ((array) $data_sppb) ;
            
        }else{
            $msg = "Tidak" ;
            $pesan = $data_validasi ;
        }

        $pesan_data = array(
            'msg' => $msg,
            'pesan' => $pesan,
            'xmlArr' => $xmlArr,
            'data_sppb' => $data_sppb,
            'jml_data_sppb' => $jml_data_sppb
        );
        echo json_encode($pesan_data);
    }


}