<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\XmlMiddleware;

class C_sppb_pib extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }     
        $this->db_tpsonline = $this->load->database('db_tpsonline', TRUE);     
    }

    function index(){

        $menu_active = $this->m_model->menu_active();

        $arraydata = array(
            'GetImpor_SPPB' => 'Per SPPB',
            'GetImporPermit' => 'Per Gudang',
            'GetImporPermit200' => 'Per Gudang (Hasil 200 row)',
            'GetImporPErmit_FASP' => 'Per Kode TPS'
        );
        $nmservice = ComboNonDb($arraydata, 'nmservice', 'GetImporPermit', 'form-control form-control-sm');

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'nmservice' => $nmservice,
        );
        $this->load->view('dashboard/index', $data);
    }


    function c_download(){
        $Username = $this->input->post('Username') ;
        $Password = $this->input->post('Password') ;
        $No_Sppb = $this->input->post('No_Sppb') ;
        $Tgl_Sppb = $this->input->post('Tgl_Sppb') ;
        $NPWP_Imp = $this->input->post('NPWP_Imp') ;
        $Kd_Gudang = $this->input->post('Kd_Gudang') ;
        $Kd_ASP = $this->input->post('Kd_ASP') ;
        $nmservice = $this->input->post('nmservice') ;


        $id_api = $this->m_model->select_max_where('db_tpsonline', 'tbl_xml_webservice', 'id_api') ;

        $a = 0 ;
        $query = array();
        $pesan = "" ;

        //=============== TEST

        $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => $nmservice));

        $xml_param = replace_xml_condition('UserName','string',$Username,$format_xml);
        $xml_param = replace_xml_condition('Password','string',$Password,$xml_param);

        if($nmservice == "GetImpor_SPPB"){

            $xml_param = replace_xml_condition('No_Sppb','string',$No_Sppb,$xml_param);
            $xml_param = replace_xml_condition('Tgl_Sppb','string',$Tgl_Sppb,$xml_param);
            $xml_param = replace_xml_condition('NPWP_Imp','string',$NPWP_Imp,$xml_param);


        }else if($nmservice == "GetImporPermit" || $nmservice == "GetImporPermit200"){

            $xml_param = replace_xml_condition('Kd_Gudang','string',$Kd_Gudang,$xml_param);

        }else{
            //GetImporPErmit_FASP
            $xml_param = replace_xml_condition('Kd_ASP','string',$Kd_ASP,$xml_param);

        }

        

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

        $save_conf = array(
            'id_api' => $id_api,
            'nama_function' => $nmservice,
            'params_function' => $xml_param,
            'hasil_response' => $responsebody,
            'tgl_request' => tanggal_sekarang(),
        );
        $this->db_tpsonline->insert('tbl_xml_webservice',$save_conf);
        $query[$a] = $this->db_tpsonline->last_query();

        //=============== TEST

        //$id_api = 2 ;

        $ID = $this->m_model->select_max_where('db_tpsonline','tbl_respon_sppb_20', 'ID');


        $hasil_response = '' ;
        $this->db_tpsonline->select('hasil_response');
        $this->db_tpsonline->where('id_transfer is NULL', NULL, FALSE);
        $this->db_tpsonline->where(array('nama_function' => $nmservice));
        $get_hasil_response = $this->db_tpsonline->get_where('tbl_xml_webservice',array('id_api' => $id_api));

        if($get_hasil_response->num_rows() > 0){
            foreach($get_hasil_response->result_array() as $result){
                $hasil_response = $result['hasil_response'] ;
            }
        }else{
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Data Di Tabel Respon(tbl_xml_webservice) Tidak Ditemukan..!!',
            );
            echo json_encode($pesan_data);die;
        }
        $str_respon= str_replace(['&lt;','&gt;'],['<','>'], $hasil_response);

        $dataku = '' ;

        if(Search_Str_To_Str($str_respon,'<DOCUMENT>') == 1){

            preg_match_all("#<DOCUMENT>(.+?)</DOCUMENT>#", $str_respon, $matchesx);
            foreach($matchesx[0] as $value) {
              $dataku = $value ;
            }

            $xml = simplexml_load_string($dataku);
            $json  = json_encode($xml);
            $xmlArr = json_decode($json, true);

            //print("<pre>".print_r($xmlArr,true)."</pre>"); die;

            $data_validasi = isset($xmlArr['SPPB']) ? $xmlArr['SPPB'] : '' ;


            //print("<pre>".print_r($data_validasi,true)."</pre>"); die;

            $msg = "Ya" ;
            $pesan = "Proses Download Data Finish..." ;

        }else if(Search_Str_To_Str($str_respon,'<RESPON>') == 1){
            // tidak berhak mengambil data
            preg_match_all("#<RESPON>(.+?)</RESPON>#", $str_respon, $matchesx);
            foreach($matchesx[0] as $value) {
                $dataku = $value ;
            }

            $xml = simplexml_load_string($dataku);
            $json  = json_encode($xml);
            $xmlArr = json_decode($json, true);

            $data_validasi = isset($xmlArr[0]) ? $xmlArr[0] : '' ;

            //print("<pre>".print_r($data_validasi,true)."</pre>"); die;

            $msg = "Tidak" ;
            $pesan = $data_validasi ;
            $pesan_data = array('msg' => $msg,'pesan' => $pesan);
            echo json_encode($pesan_data); die;

        }else{

            if($nmservice == "GetImpor_SPPB"){
                preg_match_all("#<GetImpor_SppbResult>(.+?)</GetImpor_SppbResult>#", $str_respon, $matchesx);
            }else if($nmservice == "GetImporPermit"){
                preg_match_all("#<GetImporPermitResult>(.+?)</GetImporPermitResult>#", $str_respon, $matchesx);
            }else if($nmservice == "GetImporPermit200"){
                preg_match_all("#<GetImporPermit200Result>(.+?)</GetImporPermit200Result>#", $str_respon, $matchesx);
            }else{
                preg_match_all("#<GetImporPermit_FASPResult>(.+?)</GetImporPermit_FASPResult>#", $str_respon, $matchesx);
            }

            
            foreach($matchesx[0] as $value) {
                $dataku = $value ;
            }

            $xml = simplexml_load_string($dataku);
            $json  = json_encode($xml);
            $xmlArr = json_decode($json, true);

            $data_validasi = isset($xmlArr[0]) ? $xmlArr[0] : '' ;

            $msg = "Tidak" ;
            $pesan = $data_validasi ;
            $pesan_data = array('msg' => $msg,'pesan' => $pesan);
            echo json_encode($pesan_data); die;
        }


        $save_sppb = array();
        $save_sppb_cont = array();
        $save_sppb_kms = array();

        for($n = 0 ; $n < count($data_validasi) ; $n++ ){
            //HEADER========================================
            $data_sppb = isset($data_validasi[$n]['HEADER']) ? $data_validasi[$n]['HEADER'] : array() ;

            $newarray = array();
            for($col = 0 ; $col < count($data_sppb) ; $col++){
                $tag_value = array_keys($data_sppb)[$col] ;
                        //echo $tag_value;  die;
                $value = isset($data_sppb[$tag_value]) ? $data_sppb[$tag_value] : '' ;
                if(count ((array) $value) == 0){
                    $value = "" ;
                }


                if($col == 2 || $col == 5 || $col == 20 || $col == 23 || $col == 25 ){
                    $newarray = array_merge($newarray,array($tag_value => date_db_new($value,'d/m/Y')));
                }elseif($col == 2){
                    //$newarray = array_merge($newarray,array($tag_value => date_db(substr($value, 0, 8))));
                }else{
                    $newarray = array_merge($newarray,array($tag_value => $value));
                }

            }

            $newarray = array_merge($newarray,array('ID' => $ID)) ;  
            array_push($save_sppb,$newarray);
            //HEADER=========================================


            //container====================================================
            $data_sppb_cont = isset($data_validasi[$n]['DETIL']['CONT']) ? $data_validasi[$n]['DETIL']['CONT'] : array() ;

            if(count($data_sppb_cont) > 0){                    
                if(isset($data_sppb_cont[0])){
                    //jika data terdeteksi lebih dari 1  
                    for($j = 0 ; $j < count($data_sppb_cont) ; $j++){
                        $newarray = array();                        

                        for($k = 0 ; $k < count($data_sppb_cont[$j]) ; $k++){
                            $tag_value = array_keys($data_sppb_cont[0])[$k] ;



                            $value = isset($data_sppb_cont[$j][$tag_value]) ? $data_sppb_cont[$j][$tag_value] : '' ;
                            if(count ((array) $value) == 0){
                                $value = "" ;
                            }

                            $newarray = array_merge($newarray,array($tag_value => $value));

                        }

                        $newarray = array_merge($newarray,array('ID' => $ID)) ;  
                        array_push($save_sppb_cont,$newarray);

                    }

                }else{
                    //terdeteksi cuma 1 data
                    $newarray = array(); 
                    for($j = 0 ; $j < count($data_sppb_cont) ; $j++){
                        $tag_value = array_keys($data_sppb_cont)[$j] ;
                        $value = isset($data_sppb_cont[$tag_value]) ? $data_sppb_cont[$tag_value] : '' ;
                        if(count ((array) $value) == 0){
                            $value = "" ;
                        }
                        $newarray = array_merge($newarray,array($tag_value => $value));
                    }

                    $newarray = array_merge($newarray,array('ID' => $ID)) ;  
                    array_push($save_sppb_cont,$newarray);

                }
            }
            //container====================================================


            //kms====================================================
            $data_sppb_kms= isset($data_validasi[$n]['DETIL']['KMS']) ? $data_validasi[$n]['DETIL']['KMS'] : array() ;


            if(count($data_sppb_kms) > 0){                    
                if(isset($data_sppb_kms[0])){
                    //jika data terdeteksi lebih dari 1  
                    for($j = 0 ; $j < count($data_sppb_kms) ; $j++){
                        $newarray = array();                        

                        for($k = 0 ; $k < count($data_sppb_kms[$j]) ; $k++){
                            $tag_value = array_keys($data_sppb_kms[0])[$k] ;

                            $value = isset($data_sppb_kms[$j][$tag_value]) ? $data_sppb_kms[$j][$tag_value] : '' ;
                            if(count ((array) $value) == 0){
                                $value = "" ;
                            }

                            $newarray = array_merge($newarray,array($tag_value => $value));

                        }

                        $newarray = array_merge($newarray,array('ID' => $ID)) ;  
                        array_push($save_sppb_kms,$newarray);

                    }

                }else{
                    //terdeteksi cuma 1 data
                    $newarray = array(); 
                    for($j = 0 ; $j < count($data_sppb_kms) ; $j++){
                        $tag_value = array_keys($data_sppb_kms)[$j] ;
                        $value = isset($data_sppb_kms[$tag_value]) ? $data_sppb_kms[$tag_value] : '' ;
                        if(count ((array) $value) == 0){
                            $value = "" ;
                        }
                        $newarray = array_merge($newarray,array($tag_value => $value));
                    }

                    $newarray = array_merge($newarray,array('ID' => $ID)) ;  
                    array_push($save_sppb_kms,$newarray);

                }
            }
            //kms====================================================

            $ID++;
        }

        if(count($save_sppb) > 0){
            $pesan = "" ;
            $hasil = $this->db_tpsonline->insert_batch('tbl_respon_sppb_20', $save_sppb);
            $query[$a++] = $this->db_tpsonline->last_query();
            if ($hasil >= 1) {
                $pesan = "Simpan Data Berhasil..." ;
            } else {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Function Save tbl_respon_sppb_20 Error....!!!!',
                    'query' => $query,
                );
                echo json_encode($pesan_data);die;
            }
        }

        if(count($save_sppb_cont) > 0){
            $pesan = "" ;
            $hasil = $this->db_tpsonline->insert_batch('tbl_respon_sppb_20_container', $save_sppb_cont);
            $query[$a++] = $this->db_tpsonline->last_query();
            if ($hasil >= 1) {
                $pesan = "Simpan Data Berhasil..." ;
            } else {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Function Save tbl_respon_sppb_20_container Error....!!!!',
                    'query' => $query,
                );
                echo json_encode($pesan_data);die;
            }
        }


        if(count($save_sppb_kms) > 0){
            $pesan = "" ;
            $hasil = $this->db_tpsonline->insert_batch('tbl_respon_sppb_20_kms', $save_sppb_kms);
            $query[$a++] = $this->db_tpsonline->last_query();
            if ($hasil >= 1) {
                $pesan = "Simpan Data Berhasil..." ;
            } else {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Function Save tbl_respon_sppb_20_kms Error....!!!!',
                    'query' => $query,
                );
                echo json_encode($pesan_data);die;
            }
        }

        $this->m_model->updatedata('db_tpsonline', 'tbl_xml_webservice', array('id_transfer' => 1), array('id_api' => $id_api)) ;


        $data = array(
            'Username' => $Username,
            'Password' => $Password,
            'No_Sppb' => $No_Sppb,
            'Tgl_Sppb' => $Tgl_Sppb,
            'NPWP_Imp' => $NPWP_Imp,
            'Kd_Gudang' => $Kd_Gudang,
            'Kd_ASP' => $Kd_ASP,
            'nmservice' => $nmservice,
            'msg' => 'Ya',
            'query' => $query,
            'pesan' => $pesan
            //'save_sppb_kms' => $save_sppb_kms
        );

        echo json_encode($data);

    }

    function c_load_data(){
        
        $ID = $this->input->post('ID') ;


        $this->db_tpsonline->select(" ID,CAR,NO_SPPB,DATE_FORMAT(TGL_SPPB,'%d-%m-%Y') 'TGL_SPPB',KD_KPBC,NO_PIB,DATE_FORMAT(TGL_PIB,'%d-%m-%Y') 'TGL_PIB',
            NPWP_IMP,NAMA_IMP,ALAMAT_IMP,
            NPWP_PPJK,NAMA_PPJK,ALAMAT_PPJK,NM_ANGKUT,NO_VOY_FLIGHT,BRUTO,NETTO,
            GUDANG,STATUS_JALUR,JML_CONT,NO_BC11,DATE_FORMAT(TGL_BC11,'%d-%m-%Y'),NO_POS_BC11,NO_BL_AWB,
            ifnull(DATE_FORMAT(TG_BL_AWB,'%d-%m-%Y'),'') 'TG_BL_AWB',NO_MASTER_BL_AWB,ifnull(DATE_FORMAT(TG_MASTER_BL_AWB,'%d-%m-%Y'),'') 'TG_MASTER_BL_AWB' ") ;
        $this->db_tpsonline->order_by('ID desc');
        $data_sppb = $this->db_tpsonline->get('tbl_respon_sppb_20');

        $data_sppb_cont = $this->db_tpsonline->get_where('tbl_respon_sppb_20_container',array('ID' => $ID));

        $data_sppb_kms = $this->db_tpsonline->get_where('tbl_respon_sppb_20_kms',array('ID' => $ID));

        $data = array(
            'data_sppb' => $this->m_model->array_tag_on_index($data_sppb->result_array()),
            'data_sppb_cont' => $this->m_model->array_tag_on_index($data_sppb_cont->result_array()),
            'data_sppb_kms' => $this->m_model->array_tag_on_index($data_sppb_kms->result_array()),
            'jml_data_sppb' => $data_sppb->num_rows(),
            'jml_data_sppb_cont' => $data_sppb_cont->num_rows(),
            'jml_data_sppb_kms' => $data_sppb_kms->num_rows(),
        );
        echo json_encode($data);
    }
}