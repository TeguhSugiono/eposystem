<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\XmlMiddleware;

class C_spjm extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }     
        $this->db_tpsonline = $this->load->database('db_tpsonline', TRUE);     
    }

    function index(){

        // $id_api = 7 ;

        // $ID = $this->m_model->select_max_where('db_tpsonline','tbl_respon_spjm', 'ID');

        // $hasil_response = '' ;
        // $this->db_tpsonline->select('hasil_response');
        // $this->db_tpsonline->where('id_transfer is NULL', NULL, FALSE);
        // $this->db_tpsonline->where(array('nama_function' => 'GetSPJM'));
        // $get_hasil_response = $this->db_tpsonline->get_where('tbl_xml_webservice',array('id_api' => $id_api));   

        // if($get_hasil_response->num_rows() > 0){
        //     foreach($get_hasil_response->result_array() as $result){
        //         $hasil_response = $result['hasil_response'] ;
        //     }
        // }else{
        //     $pesan_data = array(
        //         'msg' => 'Tidak',
        //         'pesan' => 'Data Di Tabel Respon(tbl_xml_webservice) Tidak Ditemukan..!!',
        //     );
        //     echo json_encode($pesan_data);die;
        // }

        // $str_respon= str_replace(['&lt;','&gt;'],['<','>'], $hasil_response);
        



        // $dataku = '' ;
        // if(Search_Str_To_Str($str_respon,'<DOCUMENT>') == 1){

        //     preg_match_all("#<DOCUMENT>(.+?)</DOCUMENT>#", $str_respon, $matchesx);
        //     foreach($matchesx[0] as $value) {
        //       $dataku = $value ;
        //     }

        //     $xml = simplexml_load_string($dataku);
        //     $json  = json_encode($xml);
        //     $xmlArr = json_decode($json, true);

        //     //print("<pre>".print_r($xmlArr,true)."</pre>"); die;

        //     $data_validasi = isset($xmlArr['SPJM']) ? $xmlArr['SPJM'] : '' ;


        //     //print("<pre>".print_r($data_validasi,true)."</pre>"); die;

        //     $msg = "Ya" ;
        //     $pesan = "Proses Download Data Finish..." ;

        // }else if(Search_Str_To_Str($str_respon,'<RESPON>') == 1){
        //     // tidak berhak mengambil data
        //     preg_match_all("#<RESPON>(.+?)</RESPON>#", $str_respon, $matchesx);
        //     foreach($matchesx[0] as $value) {
        //       $dataku = $value ;
        //     }

        //     $xml = simplexml_load_string($dataku);
        //     $json  = json_encode($xml);
        //     $xmlArr = json_decode($json, true);

        //     $data_validasi = isset($xmlArr[0]) ? $xmlArr[0] : '' ;

        //     //print("<pre>".print_r($data_validasi,true)."</pre>"); die;

        //     $msg = "Tidak" ;
        //     $pesan = $data_validasi ;
        //     $pesan_data = array('msg' => $msg,'pesan' => $pesan);
        //     echo json_encode($pesan_data); die;

        // }else{

        //     preg_match_all("#<GetSPJMResult>(.+?)</GetSPJMResult>#", $str_respon, $matchesx);
        //     foreach($matchesx[0] as $value) {
        //       $dataku = $value ;
        //     }

        //     $xml = simplexml_load_string($dataku);
        //     $json  = json_encode($xml);
        //     $xmlArr = json_decode($json, true);

        //     $data_validasi = isset($xmlArr[0]) ? $xmlArr[0] : '' ;

        //     $msg = "Tidak" ;
        //     $pesan = $data_validasi ;
        //     $pesan_data = array('msg' => $msg,'pesan' => $pesan);
        //     echo json_encode($pesan_data); die;
        // }

        // //print("<pre>".print_r($data_validasi[0],true)."</pre>");

        // $save_spjm = array();
        // $save_spjm_cont = array();
        // $save_spjm_kms = array();
        // $save_spjm_doc = array();

        // for($n = 0 ; $n < count($data_validasi) ; $n++ ){

        //     //HEADER========================================
        //     $data_spjm = isset($data_validasi[$n]['HEADER']) ? $data_validasi[$n]['HEADER'] : array() ;
        //     //print("<pre>".print_r($data_spjm,true)."</pre>");
        //     //die;


        //     $newarray = array();
        //     for($col = 0 ; $col < count($data_spjm) ; $col++){
        //         $tag_value = array_keys($data_spjm)[$col] ;
        //         //echo $tag_value;  die;
        //         $value = isset($data_spjm[$tag_value]) ? $data_spjm[$tag_value] : '' ;
        //         if(count ((array) $value) == 0){
        //             $value = "" ;
        //         }
                    

        //         if($col == 3 || $col == 11){
        //             $newarray = array_merge($newarray,array($tag_value => date_db_new($value,'d/m/Y')));
        //         }elseif($col == 16){
        //             $newarray = array_merge($newarray,array($tag_value => date_db(substr($value, 0, 8))));
        //             //die;
        //         }else{
        //             $newarray = array_merge($newarray,array($tag_value => $value));
        //         }

        //     }
        //     $newarray = array_merge($newarray,array('ID' => $ID)) ;  
        //     array_push($save_spjm,$newarray);

            
        //     //HEADER=========================================



        //     //container====================================================
        //     $data_spjm_cont = isset($data_validasi[$n]['DETIL']['CONT']) ? $data_validasi[$n]['DETIL']['CONT'] : array() ;
        //     //print("<pre>".print_r($data_spjm_cont,true)."</pre>"); die;

        //     if(count($data_spjm_cont) > 0){                    
        //         if(isset($data_spjm_cont[0])){
        //             //jika data terdeteksi lebih dari 1  
        //             //print("<pre>".print_r(count($data_spjm_cont),true)."</pre>"); die;

        //             for($j = 0 ; $j < count($data_spjm_cont) ; $j++){
        //                 $newarray = array();                        

        //                 for($k = 0 ; $k < count($data_spjm_cont[$j]) ; $k++){
        //                     $tag_value = array_keys($data_spjm_cont[0])[$k] ;



        //                     $value = isset($data_spjm_cont[$j][$tag_value]) ? $data_spjm_cont[$j][$tag_value] : '' ;
        //                     if(count ((array) $value) == 0){
        //                         $value = "" ;
        //                     }

        //                     $newarray = array_merge($newarray,array($tag_value => $value));
                            
        //                 }

        //                 $newarray = array_merge($newarray,array('ID' => $ID)) ;  
        //                 array_push($save_spjm_cont,$newarray);

        //             }

        //             //print("<pre>".print_r($save_spjm_cont,true)."</pre>"); die;

        //         }else{
        //             //terdeteksi cuma 1 data
        //             //echo 'kemari ssss' ;
        //             $newarray = array(); 
        //             for($j = 0 ; $j < count($data_spjm_cont) ; $j++){
        //                 $tag_value = array_keys($data_spjm_cont)[$j] ;
        //                 $value = isset($data_spjm_cont[$tag_value]) ? $data_spjm_cont[$tag_value] : '' ;
        //                 if(count ((array) $value) == 0){
        //                     $value = "" ;
        //                 }
        //                 $newarray = array_merge($newarray,array($tag_value => $value));
        //             }

        //             $newarray = array_merge($newarray,array('ID' => $ID)) ;  
        //             array_push($save_spjm_cont,$newarray);

        //         }
        //     }
        //     //container====================================================
        //     //die;

        //     //print("<pre>".print_r($save_spjm_cont,true)."</pre>"); die;

        //     //kms====================================================
        //     $data_spjm_kms= isset($data_validasi[$n]['DETIL']['KMS']) ? $data_validasi[$n]['DETIL']['KMS'] : array() ;
        //     //print("<pre>".print_r($data_spjm_cont,true)."</pre>"); die;

        //     if(count($data_spjm_kms) > 0){                    
        //         if(isset($data_spjm_kms[0])){
        //             //jika data terdeteksi lebih dari 1  

        //             for($j = 0 ; $j < count($data_spjm_kms) ; $j++){
        //                 $newarray = array();                        

        //                 for($k = 0 ; $k < count($data_spjm_kms[$j]) ; $k++){
        //                     $tag_value = array_keys($data_spjm_kms[0])[$k] ;



        //                     $value = isset($data_spjm_kms[$j][$tag_value]) ? $data_spjm_kms[$j][$tag_value] : '' ;
        //                     if(count ((array) $value) == 0){
        //                         $value = "" ;
        //                     }

        //                     $newarray = array_merge($newarray,array($tag_value => $value));
                            
        //                 }

        //                 $newarray = array_merge($newarray,array('ID' => $ID)) ;  
        //                 array_push($save_spjm_kms,$newarray);

        //             }


        //         }else{
        //             //terdeteksi cuma 1 data
        //             $newarray = array(); 
        //             for($j = 0 ; $j < count($data_spjm_kms) ; $j++){
        //                 $tag_value = array_keys($data_spjm_kms)[$j] ;
        //                 $value = isset($data_spjm_kms[$tag_value]) ? $data_spjm_kms[$tag_value] : '' ;
        //                 if(count ((array) $value) == 0){
        //                     $value = "" ;
        //                 }
        //                 $newarray = array_merge($newarray,array($tag_value => $value));
        //             }

        //             $newarray = array_merge($newarray,array('ID' => $ID)) ;  
        //             array_push($save_spjm_kms,$newarray);

        //         }
        //     }
        //     //kms====================================================

        //     //doc====================================================
        //     $data_spjm_doc= isset($data_validasi[$n]['DETIL']['DOK']) ? $data_validasi[$n]['DETIL']['DOK'] : array() ;
        //     //print("<pre>".print_r($data_spjm_cont,true)."</pre>"); die;

        //     if(count($data_spjm_doc) > 0){                    
        //         if(isset($data_spjm_doc[0])){
        //             //jika data terdeteksi lebih dari 1  

        //             for($j = 0 ; $j < count($data_spjm_doc) ; $j++){
        //                 $newarray = array();                        

        //                 for($k = 0 ; $k < count($data_spjm_doc[$j]) ; $k++){
        //                     $tag_value = array_keys($data_spjm_doc[0])[$k] ;



        //                     $value = isset($data_spjm_doc[$j][$tag_value]) ? $data_spjm_doc[$j][$tag_value] : '' ;
        //                     if(count ((array) $value) == 0){
        //                         $value = "" ;
        //                     }

        //                     if($k == 3){
        //                         $newarray = array_merge($newarray,array($tag_value => date_db_new($value,'d/m/Y')));
        //                     }else{
        //                         $newarray = array_merge($newarray,array($tag_value => $value));
        //                     }
                            
        //                 }

        //                 $newarray = array_merge($newarray,array('ID' => $ID)) ;  
        //                 array_push($save_spjm_doc,$newarray);

        //             }


        //         }else{
        //             //terdeteksi cuma 1 data
        //             $newarray = array(); 
        //             for($j = 0 ; $j < count($data_spjm_doc) ; $j++){
        //                 $tag_value = array_keys($data_spjm_doc)[$j] ;
        //                 $value = isset($data_spjm_doc[$tag_value]) ? $data_spjm_doc[$tag_value] : '' ;
        //                 if(count ((array) $value) == 0){
        //                     $value = "" ;
        //                 }

        //                 if($j == 3){
        //                     $newarray = array_merge($newarray,array($tag_value => date_db_new($value,'d/m/Y')));
        //                 }else{
        //                     $newarray = array_merge($newarray,array($tag_value => $value));
        //                 }

        //             }

        //             $newarray = array_merge($newarray,array('ID' => $ID)) ;  
        //             array_push($save_spjm_doc,$newarray);

        //         }
        //     }
        //     //doc====================================================
            



        //     $ID++;
        // }

        // $hasil = $this->db_tpsonline->insert_batch('tbl_respon_spjm', $save_spjm);
        // if ($hasil >= 1) {
        //     echo 'simpan berhasil tbl_respon_spjm' ;
        // } else {
        //     echo 'simpan gagal tbl_respon_spjm' ;
        //     die;
        // }

        // echo '<br>' ;
        // $hasil = $this->db_tpsonline->insert_batch('tbl_respon_spjm_container', $save_spjm_cont);
        // if ($hasil >= 1) {
        //     echo 'simpan berhasil tbl_respon_spjm_container' ;
        // } else {
        //     echo 'simpan gagal tbl_respon_spjm_container' ;
        //     die;
        // }

        // echo '<br>' ;

        // $hasil = $this->db_tpsonline->insert_batch('tbl_respon_spjm_kms', $save_spjm_kms);
        // if ($hasil >= 1) {
        //     echo 'simpan berhasil tbl_respon_spjm_kms' ;
        // } else {
        //     echo 'simpan gagal tbl_respon_spjm_kms' ;
        //     die;
        // }

        // echo '<br>' ;

        // $hasil = $this->db_tpsonline->insert_batch('tbl_respon_spjm_document', $save_spjm_doc);
        // if ($hasil >= 1) {
        //     echo 'simpan berhasil tbl_respon_spjm_document' ;
        // } else {
        //     echo 'simpan gagal tbl_respon_spjm_document' ;
        //     die;
        // }
        //die;

        //$hasil = $this->db_tpsonline->insert_batch('tbl_respon_spjm', $save_spjm);
        //print("<pre>".print_r($save_spjm,true)."</pre>"); die;

        //print("<pre>".print_r($data_validasi[0]['DETIL']['CONT'],true)."</pre>"); die;

        // $count_array_header = count ((array) array_keys($data_validasi)) ;

        // $savedata = array();
        // $savedatacont = array();
        // $savedatadoc = array();
        // for($baris = 0 ; $baris < $count_array_header ; $baris++){
        //     $newarray = array();
        //     for($col = 0 ; $col < 16 ; $col++){
        //         $tag_value = array_keys($data_validasi[0]['HEADER'])[$col] ;
        //         $value = isset($data_validasi[$baris]['HEADER'][$tag_value]) ? $data_validasi[$baris]['HEADER'][$tag_value] : '' ;
        //         if(count ((array) $value) == 0){
        //             $value = "" ;
        //         }
                    

        //         if($col == 3 || $col == 11 || $col == 16){
        //             $newarray = array_merge($newarray,array($tag_value => date_db_new($value,'d/m/Y')));
        //         }else{
        //             $newarray = array_merge($newarray,array($tag_value => $value));
        //         }

        //     }
        //     $newarray = array_merge($newarray,array('ID' => $ID)) ;  
        //     array_push($savedata,$newarray);
        //     //print("<pre>".print_r($savedata,true)."</pre>"); 

        //     //==============================================================================================
        //     //print("<pre>".print_r($data_validasi[$baris]['DETIL'],true)."</pre>"); die;

        //     $baris = 2 ;
        //     $newarray = array();
        //     $array_data_cont = isset($data_validasi[$baris]['DETIL']['CONT']) ? $data_validasi[$baris]['DETIL']['CONT'] : array();
        //     $count_array_data_cont = count ((array) array_keys($array_data_cont)) ;
        //     //print("<pre>".print_r($array_data_cont,true)."</pre>"); die;

        //     if($count_array_data_cont > 0){
        //         for($baris_cont = 0 ; $baris_cont < $count_array_data_cont ; $baris_cont++){

        //             for($col = 0 ; $col < 4 ; $col++){
        //                 $tag_value = array_keys($data_validasi[0]['DETIL']['CONT'])[$col] ;

        //                 $value = isset($data_validasi[$baris_cont]['DETIL']['CONT'][$tag_value]) ? $data_validasi[$baris_cont]['DETIL']['CONT'][$tag_value] : '' ;
        //                 if(count ((array) $value) == 0){
        //                     $value = "" ;
        //                 }
                            
        //                 $newarray = array_merge($newarray,array($tag_value => $value));
        //             }

        //             $newarray = array_merge($newarray,array('ID' => $ID)) ;  
        //             array_push($savedatacont,$newarray);
        //             //print("<pre>".print_r($newarray,true)."</pre>"); 
        //         }
        //     } 
        //     print("<pre>".print_r($savedatacont,true)."</pre>");   
        //     die; 
        //     //==============================================================================================


        //     //==============================================================================================
        //     //print("<pre>".print_r($data_validasi[$baris]['DETIL'],true)."</pre>"); die;

        //     $newarray = array();
        //     $array_data_doc = isset($data_validasi[$baris]['DETIL']['DOK']) ? $data_validasi[$baris]['DETIL']['DOK'] : array();
        //     $count_array_data_doc = count ((array) array_keys($array_data_doc)) ;
        //     //print("<pre>".print_r($array_data_cont,true)."</pre>"); die;

        //     if($count_array_data_doc > 0){
        //         for($col = 0 ; $col < 4 ; $col++){
        //             $tag_value = array_keys($data_validasi[0]['DETIL']['DOK'])[$col] ;

        //             $value = isset($data_validasi[$baris]['DETIL']['DOK'][$tag_value]) ? $data_validasi[$baris]['DETIL']['DOK'][$tag_value] : '' ;
        //             if(count ((array) $value) == 0){
        //                 $value = "" ;
        //             }
                        

                    // if($col == 3){
                    //     $newarray = array_merge($newarray,array($tag_value => date_db_new($value,'d/m/Y')));
                    // }else{
                    //     $newarray = array_merge($newarray,array($tag_value => $value));
                    // }
        //         }

        //         $newarray = array_merge($newarray,array('ID' => $ID)) ;  
        //         array_push($savedatadoc,$newarray);
        //         // print("<pre>".print_r($savedatadoc,true)."</pre>"); 
        //         // die;
        //     }    
        //     //==============================================================================================

        //     $ID++;
        // }

        

        

        $menu_active = $this->m_model->menu_active();

        $arraydata = array('GetSPJM' => 'Per Kode TPS','GetSPJM_onDemand' => 'Per Nomor SPJM');
        $nmservice = ComboNonDb($arraydata, 'nmservice', '', 'form-control form-control-sm');

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'nmservice' => $nmservice,
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_load_data(){
        
        $ID = $this->input->post('ID') ;

        $this->db_tpsonline->select("   ID,CAR,KD_KANTOR,NO_PIB,DATE_FORMAT(TGL_PIB,'%d-%m-%Y') 'TGL_PIB',NPWP_IMP,NAMA_IMP,NPWP_PPJK,NAMA_PPJK,
                                        GUDANG,JML_CONT,NO_BC11,DATE_FORMAT(TGL_BC11,'%d-%m-%Y') 'TGL_BC11',NO_POS_BC11,FL_KARANTINA,NM_ANGKUT,
                                        NO_VOY_FLIGHT,IFNULL(DATE_FORMAT(TGL_SPJM,'%d-%m-%Y'),'') 'TGL_SPJM' ") ;
        $this->db_tpsonline->order_by('ID desc');
        $data_spjm = $this->db_tpsonline->get('tbl_respon_spjm');

        $data_spjm_cont = $this->db_tpsonline->get_where('tbl_respon_spjm_container',array('ID' => $ID));

        $this->db_tpsonline->select(" ID,ID_DET,CAR,JNS_DOK,NO_DOK,DATE_FORMAT(TGL_DOK,'%d-%m-%Y') 'TGL_DOK' ") ;
        $data_spjm_doc = $this->db_tpsonline->get_where('tbl_respon_spjm_document',array('ID' => $ID));

        $data_spjm_kms = $this->db_tpsonline->get_where('tbl_respon_spjm_kms',array('ID' => $ID));

        $data = array(
            'data_spjm' => $this->m_model->array_tag_on_index($data_spjm->result_array()),
            'data_spjm_cont' => $this->m_model->array_tag_on_index($data_spjm_cont->result_array()),
            'data_spjm_doc' => $this->m_model->array_tag_on_index($data_spjm_doc->result_array()),
            'data_spjm_kms' => $this->m_model->array_tag_on_index($data_spjm_kms->result_array()),
            'jml_data_spjm' => $data_spjm->num_rows(),
            'jml_data_spjm_cont' => $data_spjm_cont->num_rows(),
            'jml_data_spjm_doc' => $data_spjm_doc->num_rows(),
            'jml_data_spjm_kms' => $data_spjm_kms->num_rows(),
        );
        echo json_encode($data);
    }

    function c_download(){
        $Username = $this->input->post('Username') ;
        $Password = $this->input->post('Password') ;
        $Kd_Tps = $this->input->post('Kd_Tps') ;
        $noPib = $this->input->post('noPib') ;
        $tglPib = $this->input->post('tglPib') ;
        $Kd_Tps = $this->input->post('Kd_Tps') ;
        $nmservice = $this->input->post('nmservice') ;

        $id_api = $this->m_model->select_max_where('db_tpsonline', 'tbl_xml_webservice', 'id_api') ;

        $a = 0 ;
        $query = array();

        //=============== TEST

        $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => $nmservice));

        $xml_param = replace_xml_condition('UserName','string',$Username,$format_xml);
        $xml_param = replace_xml_condition('Password','string',$Password,$xml_param);
        $xml_param = replace_xml_condition('Kd_Tps','string',$Kd_Tps,$xml_param);
        $xml_param = replace_xml_condition('noPib','string',$noPib,$xml_param);
        $xml_param = replace_xml_condition('tglPib','string',$tglPib,$xml_param);

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

        //$id_api = 19 ;

        $ID = $this->m_model->select_max_where('db_tpsonline','tbl_respon_spjm', 'ID');

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

            $data_validasi = isset($xmlArr['SPJM']) ? $xmlArr['SPJM'] : '' ;


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

            preg_match_all("#<GetSPJMResult>(.+?)</GetSPJMResult>#", $str_respon, $matchesx);
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




        $save_spjm = array();
        $save_spjm_cont = array();
        $save_spjm_kms = array();
        $save_spjm_doc = array();

        for($n = 0 ; $n < count($data_validasi) ; $n++ ){

            //HEADER========================================
            $data_spjm = isset($data_validasi[$n]['HEADER']) ? $data_validasi[$n]['HEADER'] : array() ;

            $newarray = array();
            for($col = 0 ; $col < count($data_spjm) ; $col++){
                $tag_value = array_keys($data_spjm)[$col] ;
                        //echo $tag_value;  die;
                $value = isset($data_spjm[$tag_value]) ? $data_spjm[$tag_value] : '' ;
                if(count ((array) $value) == 0){
                    $value = "" ;
                }


                if($col == 3 || $col == 11){
                    $newarray = array_merge($newarray,array($tag_value => date_db_new($value,'d/m/Y')));
                }elseif($col == 16){
                    $newarray = array_merge($newarray,array($tag_value => date_db(substr($value, 0, 8))));
                            //die;
                }else{
                    $newarray = array_merge($newarray,array($tag_value => $value));
                }

            }

            $newarray = array_merge($newarray,array('ID' => $ID)) ;  
            array_push($save_spjm,$newarray);
            //HEADER=========================================



            //container====================================================
            $data_spjm_cont = isset($data_validasi[$n]['DETIL']['CONT']) ? $data_validasi[$n]['DETIL']['CONT'] : array() ;

            if(count($data_spjm_cont) > 0){                    
                if(isset($data_spjm_cont[0])){
                    //jika data terdeteksi lebih dari 1  
                    for($j = 0 ; $j < count($data_spjm_cont) ; $j++){
                        $newarray = array();                        

                        for($k = 0 ; $k < count($data_spjm_cont[$j]) ; $k++){
                            $tag_value = array_keys($data_spjm_cont[0])[$k] ;



                            $value = isset($data_spjm_cont[$j][$tag_value]) ? $data_spjm_cont[$j][$tag_value] : '' ;
                            if(count ((array) $value) == 0){
                                $value = "" ;
                            }

                            $newarray = array_merge($newarray,array($tag_value => $value));

                        }

                        $newarray = array_merge($newarray,array('ID' => $ID)) ;  
                        array_push($save_spjm_cont,$newarray);

                    }

                }else{
                    //terdeteksi cuma 1 data
                    $newarray = array(); 
                    for($j = 0 ; $j < count($data_spjm_cont) ; $j++){
                        $tag_value = array_keys($data_spjm_cont)[$j] ;
                        $value = isset($data_spjm_cont[$tag_value]) ? $data_spjm_cont[$tag_value] : '' ;
                        if(count ((array) $value) == 0){
                            $value = "" ;
                        }
                        $newarray = array_merge($newarray,array($tag_value => $value));
                    }

                    $newarray = array_merge($newarray,array('ID' => $ID)) ;  
                    array_push($save_spjm_cont,$newarray);

                }
            }
            //container====================================================


            //kms====================================================
            $data_spjm_kms= isset($data_validasi[$n]['DETIL']['KMS']) ? $data_validasi[$n]['DETIL']['KMS'] : array() ;


            if(count($data_spjm_kms) > 0){                    
                if(isset($data_spjm_kms[0])){
                    //jika data terdeteksi lebih dari 1  
                    for($j = 0 ; $j < count($data_spjm_kms) ; $j++){
                        $newarray = array();                        

                        for($k = 0 ; $k < count($data_spjm_kms[$j]) ; $k++){
                            $tag_value = array_keys($data_spjm_kms[0])[$k] ;

                            $value = isset($data_spjm_kms[$j][$tag_value]) ? $data_spjm_kms[$j][$tag_value] : '' ;
                            if(count ((array) $value) == 0){
                                $value = "" ;
                            }

                            $newarray = array_merge($newarray,array($tag_value => $value));

                        }

                        $newarray = array_merge($newarray,array('ID' => $ID)) ;  
                        array_push($save_spjm_kms,$newarray);

                    }

                }else{
                    //terdeteksi cuma 1 data
                    $newarray = array(); 
                    for($j = 0 ; $j < count($data_spjm_kms) ; $j++){
                        $tag_value = array_keys($data_spjm_kms)[$j] ;
                        $value = isset($data_spjm_kms[$tag_value]) ? $data_spjm_kms[$tag_value] : '' ;
                        if(count ((array) $value) == 0){
                            $value = "" ;
                        }
                        $newarray = array_merge($newarray,array($tag_value => $value));
                    }

                    $newarray = array_merge($newarray,array('ID' => $ID)) ;  
                    array_push($save_spjm_kms,$newarray);

                }
            }
            //kms====================================================


            //doc====================================================
            $data_spjm_doc= isset($data_validasi[$n]['DETIL']['DOK']) ? $data_validasi[$n]['DETIL']['DOK'] : array() ;

            if(count($data_spjm_doc) > 0){                    
                if(isset($data_spjm_doc[0])){
                    //jika data terdeteksi lebih dari 1  

                    for($j = 0 ; $j < count($data_spjm_doc) ; $j++){
                        $newarray = array();                        

                        for($k = 0 ; $k < count($data_spjm_doc[$j]) ; $k++){
                            $tag_value = array_keys($data_spjm_doc[0])[$k] ;

                            $value = isset($data_spjm_doc[$j][$tag_value]) ? $data_spjm_doc[$j][$tag_value] : '' ;
                            if(count ((array) $value) == 0){
                                $value = "" ;
                            }

                            if($k == 3){
                                $newarray = array_merge($newarray,array($tag_value => date_db_new($value,'d/m/Y')));
                            }else{
                                $newarray = array_merge($newarray,array($tag_value => $value));
                            }

                        }

                        $newarray = array_merge($newarray,array('ID' => $ID)) ;  
                        array_push($save_spjm_doc,$newarray);

                    }

                }else{
                    //terdeteksi cuma 1 data
                    $newarray = array(); 
                    for($j = 0 ; $j < count($data_spjm_doc) ; $j++){
                        $tag_value = array_keys($data_spjm_doc)[$j] ;
                        $value = isset($data_spjm_doc[$tag_value]) ? $data_spjm_doc[$tag_value] : '' ;
                        if(count ((array) $value) == 0){
                            $value = "" ;
                        }

                        if($j == 3){
                            $newarray = array_merge($newarray,array($tag_value => date_db_new($value,'d/m/Y')));
                        }else{
                            $newarray = array_merge($newarray,array($tag_value => $value));
                        }

                    }

                    $newarray = array_merge($newarray,array('ID' => $ID)) ;  
                    array_push($save_spjm_doc,$newarray);

                }
            }
            //doc====================================================

            $ID++;
        }


        if(count($save_spjm) > 0){
            $pesan = "" ;
            $hasil = $this->db_tpsonline->insert_batch('tbl_respon_spjm', $save_spjm);
            $query[$a++] = $this->db_tpsonline->last_query();
            if ($hasil >= 1) {
                $pesan = "Simpan Data Berhasil..." ;
            } else {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Function Save tbl_respon_spjm Error....!!!!',
                    'query' => $query,
                );
                echo json_encode($pesan_data);die;
            }
        }

        //print("<pre>".print_r($save_spjm_cont,true)."</pre>"); die;

        if(count($save_spjm_cont) > 0){
            $hasil = $this->db_tpsonline->insert_batch('tbl_respon_spjm_container', $save_spjm_cont);
            $query[$a++] = $this->db_tpsonline->last_query();
            if ($hasil >= 1) {
                $pesan = "Simpan Data Berhasil..." ;
            } else {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Function Save tbl_respon_spjm_container Error....!!!!',
                    'query' => $query,
                );
                echo json_encode($pesan_data);die;
            }
        }


        if(count($save_spjm_kms) > 0){
            $hasil = $this->db_tpsonline->insert_batch('tbl_respon_spjm_kms', $save_spjm_kms);
            $query[$a++] = $this->db_tpsonline->last_query();

            if ($hasil >= 1) {
                $pesan = "Simpan Data Berhasil..." ;
            } else {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Function Save tbl_respon_spjm_kms Error....!!!!',
                    'query' => $query,
                );
                echo json_encode($pesan_data);die;
            }
        }


        if(count($save_spjm_doc) > 0){
            $hasil = $this->db_tpsonline->insert_batch('tbl_respon_spjm_document', $save_spjm_doc);
            $query[$a++] = $this->db_tpsonline->last_query();
            if ($hasil >= 1) {
                $pesan = "Simpan Data Berhasil..." ;
            } else {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Function Save tbl_respon_spjm_document Error....!!!!',
                    'query' => $query,
                );
                echo json_encode($pesan_data);die;
            }
        }

        $this->m_model->updatedata('db_tpsonline', 'tbl_xml_webservice', array('id_transfer' => 1), array('id_api' => $id_api)) ;

        $data = array(
            'Username' => $Username,
            'Password' => $Password,
            'Kd_Tps' => $Kd_Tps,
            'noPib' => $noPib,
            'tglPib' => $tglPib,
            'Kd_Tps' => $Kd_Tps,
            'nmservice' => $nmservice,
            'msg' => 'Ya',
            'query' => $query,
            'pesan' => $pesan
        );

        echo json_encode($data);
    }




}