<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\XmlMiddleware;

class C_GetRejectData extends CI_Controller {

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
        $Kd_Tps = $this->input->post('Kd_Tps') ;

        $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => $nama_function));
        $xml_param = str_replace("<UserName>string</UserName>","<UserName>".$Username."</UserName>",$format_xml);
        $xml_param = str_replace("<Password>string</Password>","<Password>".$Password."</Password>",$xml_param);
        $xml_param = str_replace("<Kd_Tps>string</Kd_Tps>","<Kd_Tps>".$startdate."</Kd_Tps>",$xml_param);

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
        $data_reject_terkirim = array() ;
        $jml_data_reject_terkirim = 0 ;

        $msg = "Tidak" ;
        $pesan = "Error Tidak Dapat Teridentifikasi...(Error Server Portal Bea Cukai)" ;
        if($data_validasi == ""){
            $msg = "Ya" ;
            $pesan = "Proses Cek Data Finish..." ;
            $data_reject_terkirim = isset($xmlArr['REF_NO']) ? $xmlArr['REF_NO']['RN'] : array();
            
            // $data_reject_terkirim =  array_filter($data_reject_terkirim, fn($value) => !is_null($value) && $value !== '' && $value !== []) ;

            // //fungsi dibawah ini untuk mengurutkan array yang index nya ngaco karena ada penghapusan array di index yang random
            // $arrays = $data_reject_terkirim;
            // $data_reject_terkirim = array();
            // $i = 0;
            // foreach ($arrays as $k => $item) {
            //     $data_reject_terkirim[$i] = $item;
            //     unset($arrays[$k]);
            //     $i++;
            // }

            $jml_data_reject_terkirim = count ((array) $data_reject_terkirim) ;
            
        }else{
            $msg = "Tidak" ;
            $pesan = $data_validasi ;
        }

        $pesan_data = array(
            'msg' => $msg,
            'pesan' => $pesan,
            'xmlArr' => $xmlArr,
            'data_reject_terkirim' => $data_reject_terkirim,
            'jml_data_reject_terkirim' => $jml_data_reject_terkirim
        );
        echo json_encode($pesan_data);
    }


}