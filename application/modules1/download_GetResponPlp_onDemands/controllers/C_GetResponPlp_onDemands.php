<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\XmlMiddleware;

class C_GetResponPlp_onDemands extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }     
        $this->db_tpsonline = $this->load->database('db_tpsonline', TRUE);  
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);     
        $this->mbatps = $this->load->database('mbatps', TRUE); 
    }

    

    function index(){

        // $data = $this->db_tpsonline->get_where('tbl_respon_plp_petikemas_detail_ondemands',array('ID' => 1))->result_array() ;
        // print("<pre>".print_r($data,true)."</pre>"); 

        // echo '<br><br>' ;

        // $array_dataku = array_map(function ($a) {
        //     unset($a['ID']);
        //     unset($a['ID_DET']);
        //     unset($a['ACTIVE']);
        //     unset($a['CREATED_BY']);
        //     unset($a['CREATED_ON']);
        //     unset($a['EDITED_BY']);
        //     unset($a['EDITED_ON']);
        //     return $a;
        // }, $data);


        // print("<pre>".print_r($array_dataku,true)."</pre>"); 
        // die;

        //$array = array(1, "hello", 1, "world", "hello");
        //print("<pre>".print_r(array_count_values($array)[1],true)."</pre>"); die;

        // echo count_strsearch_to_strparam('tetangga','anak ibu makan dua kali sehari sedangkan anak tetangga makan 3kali sehari makan');
        // die;

        // $nama_function = $this->uri->segment(2) ;

        // $Username = 'MBA0' ;
        // $Password = 'MBA1234560' ;
        // $Kd_asp = 'MBA0' ;

        // $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => $nama_function));

        // $xml_param = replace_xml_condition('UserName','string',$Username,$format_xml);
        // $xml_param = replace_xml_condition('Password','string',$Password,$xml_param);
        // $xml_param = replace_xml_condition('Kd_asp','string',$Kd_asp,$xml_param);

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

        // print("<pre>".print_r($responsebody,true)."</pre>"); 
        // die;
        

        $menu_active = $this->m_model->menu_active();

        $arraydata = array('' => 'All','CMBA' => 'TPS', 'GMBA' => 'LCL & PJT');
        $GUDANG_TUJUAN = ComboNonDb($arraydata, 'GUDANG_TUJUAN', '', 'form-control form-control-sm');

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'GUDANG_TUJUAN' => $GUDANG_TUJUAN
        );
        $this->load->view('dashboard/index', $data);
    }

    


    function c_tbl_petikemas_header(){
        $database = "db_tpsonline";

        $GUDANG_TUJUAN = $this->input->post('GUDANG_TUJUAN');

        $select = 'x.ID,x.KD_KANTOR,x.KD_TPS_ASAL,x.KD_TPS_TUJUAN,x.REF_NUMBER,x.GUDANG_ASAL,x.GUDANG_TUJUAN,x.NO_PLP,
                    x.TGL_PLP,x.ALASAN_REJECT,x.CALL_SIGN,x.NM_ANGKUT,x.NO_VOY_FLIGHT,x.TGL_TIBA,x.NO_BC11,x.TGL_BC11,
                    x.NO_SURAT,x.TGL_SURAT,x.FLAG_TRANSFER,y.NO_CONT,y.UK_CONT,y.JNS_CONT,y.NO_POS_BC11,y.CONSIGNEE';
        $form = 'tbl_respon_plp_petikemas_ondemands x';
        

        $join = array(
            array('tbl_respon_plp_petikemas_detail_ondemands as y','x.ID = y.ID','inner')
        );

        $where = array('x.ACTIVE' => 0);

        if($GUDANG_TUJUAN != ""){
            $tambah_where = array('x.GUDANG_TUJUAN' => $GUDANG_TUJUAN);
            $where = array_merge($where, $tambah_where);
        }

        $where_term = array(
            'x.ID','x.FLAG_TRANSFER','x.FLAG_TRANSFER','x.KD_KANTOR','x.KD_TPS_ASAL','x.KD_TPS_TUJUAN','x.REF_NUMBER','x.GUDANG_ASAL','x.GUDANG_TUJUAN','x.NO_PLP',
            'x.TGL_PLP','x.ALASAN_REJECT','x.CALL_SIGN','x.NM_ANGKUT','x.NO_VOY_FLIGHT','x.TGL_TIBA','x.NO_BC11','x.TGL_BC11',
            'x.NO_SURAT','x.TGL_SURAT','y.NO_CONT','y.UK_CONT','y.JNS_CONT','y.NO_POS_BC11','y.CONSIGNEE'
        );
        $column_order = array(
            null, 'x.ID','x.FLAG_TRANSFER','x.FLAG_TRANSFER','x.KD_KANTOR','x.KD_TPS_ASAL','x.KD_TPS_TUJUAN','x.REF_NUMBER','x.GUDANG_ASAL','x.GUDANG_TUJUAN','x.NO_PLP',
            'x.TGL_PLP','x.ALASAN_REJECT','x.CALL_SIGN','x.NM_ANGKUT','x.NO_VOY_FLIGHT','x.TGL_TIBA','x.NO_BC11','x.TGL_BC11',
            'x.NO_SURAT','x.TGL_SURAT','y.NO_CONT','y.UK_CONT','y.JNS_CONT','y.NO_POS_BC11','y.CONSIGNEE'
        );
        $order = array(
            'x.ID' => 'desc'
        );

        $group = array('x.ID');

        $array_table = array(
            'select' => $select,
            'form' => $form,
            'join' => $join,
            'where' => $where,
            'where_like' => array(),
            'where_in' => array(),
            'where_not_in' => array(),
            'where_term' => $where_term,
            'column_order' => $column_order,
            'group' => $group,
            'order' => $order,
        );

        $list = $this->m_model->get_datatables($database, $array_table);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $field->ID;
            $row[] = $field->FLAG_TRANSFER;

            if($field->FLAG_TRANSFER == 1){
                $row[] = " <a class='btn btn-primary boxshadow' title='Data Sudah Sukses di Transfer Ke Repson Persetujuan PLP ...'> 
                <span class='icon-thumbs-up1' style='color:white'></span></a> " ;
            }else{
                $row[] = " <a class='btn btn-primary boxshadow' href='javascript:void(0)' title='Transfer' onclick='transfer_plp(".'"'.$field->ID.'"'.")'> 
                <span class='icon-share1' style='color:white'></span></a> " ;
            }


            $row[] = $field->KD_KANTOR;
            $row[] = $field->KD_TPS_ASAL;
            $row[] = $field->KD_TPS_TUJUAN;
            $row[] = $field->REF_NUMBER;
            $row[] = $field->GUDANG_ASAL;
            $row[] = $field->GUDANG_TUJUAN;
            $row[] = $field->NO_PLP;
            $row[] = showdate_dmy($field->TGL_PLP);
            $row[] = $field->ALASAN_REJECT;
            $row[] = $field->CALL_SIGN;
            $row[] = $field->NM_ANGKUT;
            $row[] = $field->NO_VOY_FLIGHT;
            $row[] = showdate_dmy($field->TGL_TIBA);
            $row[] = $field->NO_BC11;
            $row[] = showdate_dmy($field->TGL_BC11);
            $row[] = $field->NO_SURAT;
            $row[] = showdate_dmy($field->TGL_SURAT);

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_model->count_all($database, $array_table),
            "recordsFiltered" => $this->m_model->count_filtered($database, $array_table),
            "data" => $data,
        );

        echo json_encode($output);
    }


    function c_tbl_petikemas_detail(){
        $database = "db_tpsonline";
        
        $ID = $this->input->post('ID');

        $select = 'ID,ID_DET,NO_CONT,UK_CONT,JNS_CONT,NO_POS_BC11,CONSIGNEE';
        $form = 'tbl_respon_plp_petikemas_detail_ondemands ';
        $join = array();
        $where = array('ACTIVE' => 0);

        if ($ID != '') {
            $tambah_where = array('ID' => $ID);
            $where = array_merge($where, $tambah_where);
        }

        $where_term = array(
            'ID','ID_DET','NO_CONT','UK_CONT','JNS_CONT','NO_POS_BC11','CONSIGNEE'
        );
        $column_order = array(
            null, 'ID','ID_DET','NO_CONT','UK_CONT','JNS_CONT','NO_POS_BC11','CONSIGNEE'
        );
        $order = array(
            'NO_POS_BC11' => 'asc'
        );

        $group = array();

        $array_table = array(
            'select' => $select,
            'form' => $form,
            'join' => $join,
            'where' => $where,
            'where_like' => array(),
            'where_in' => array(),
            'where_not_in' => array(),
            'where_term' => $where_term,
            'column_order' => $column_order,
            'group' => $group,
            'order' => $order,
        );

        $list = $this->m_model->get_datatables($database, $array_table);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $field->ID;
            $row[] = $field->ID_DET;
            $row[] = $field->NO_CONT;
            $row[] = $field->UK_CONT;
            $row[] = $field->JNS_CONT;
            $row[] = $field->NO_POS_BC11;
            $row[] = $field->CONSIGNEE;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_model->count_all($database, $array_table),
            "recordsFiltered" => $this->m_model->count_filtered($database, $array_table),
            "data" => $data,
        );

        echo json_encode($output);
    }

    function c_download(){

        

        $nama_function = $this->uri->segment(2) ;

        $Username = $this->input->post('Username') ;
        $Password = $this->input->post('Password') ;
        $No_plp = $this->input->post('No_plp') ;
        $Tgl_plp = showdate_dmy_request($this->input->post('Tgl_plp')) ;
        $KdGudang = $this->input->post('KdGudang') ;
        $RefNumber = $this->input->post('RefNumber') ;

        $id_api = $this->m_model->select_max_where('db_tpsonline', 'tbl_xml_webservice', 'id_api') ;


        $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => $nama_function));

        $xml_param = replace_xml_condition('UserName','string',$Username,$format_xml);
        $xml_param = replace_xml_condition('Password','string',$Password,$xml_param);
        $xml_param = replace_xml_condition('No_plp','string',$No_plp,$xml_param);
        $xml_param = replace_xml_condition('Tgl_plp','string',$Tgl_plp,$xml_param);
        $xml_param = replace_xml_condition('KdGudang','string',$KdGudang,$xml_param);
        $xml_param = replace_xml_condition('RefNumber','string',$RefNumber,$xml_param);



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
            'nama_function' => $nama_function,
            'params_function' => $xml_param,
            'hasil_response' => $responsebody,
            'tgl_request' => tanggal_sekarang(),
        );
        $this->db_tpsonline->insert('tbl_xml_webservice',$save_conf);
        
        //$id_api = 682;
        $ID = $this->m_model->select_max_where('db_tpsonline','tbl_respon_plp_petikemas_ondemands', 'ID');

        $hasil_response = '' ;
        $this->db_tpsonline->select('hasil_response');
        $this->db_tpsonline->where('id_transfer is NULL', NULL, FALSE);
        $this->db_tpsonline->where(array('nama_function' => $nama_function));
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

        $count_detail_data = 0 ;

        $dataku = '' ;
        if(Search_Str_To_Str($str_respon,'<RESPONPLP>') == 1){
            //Ada respon data
            preg_match_all("#<RESPONPLP>(.+?)</RESPONPLP>#", $str_respon, $matchesx);
            foreach($matchesx[0] as $value) {
              $dataku = $value ;
            }

            if($dataku == ""){
                preg_match_all("#<RESPONPLP>(.+?)</RESPONPLP>#s", $str_respon, $matchesx);
                foreach($matchesx[0] as $value) {
                    $dataku = $value ;
                }
            }

    //               $pesan_data = array(
    //     'msg' => 'Tidak',
    //     'pesan' => 'Data Di Tabel Respon(tbl_xml_webservice) Tidak Ditemukan..!!',
    //     'dataku' => $dataku,
    //     'str_respon' => $str_respon
    // );
    //   echo json_encode($pesan_data);die;

            $xml = simplexml_load_string($dataku);
            $json  = json_encode($xml);
            $xmlArr = json_decode($json, true);

            $count_detail_data = count_strsearch_to_strparam('<CONT>',$dataku);

            $data_validasi = isset($xmlArr[0]) ? $xmlArr[0] : '' ;

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

            $msg = "Tidak" ;
            $pesan = $data_validasi ;
            $pesan_data = array('msg' => $msg,'pesan' => $pesan);
            echo json_encode($pesan_data); die;

        }else{
            //data tidak dtemukan
            preg_match_all("#<GetResponPlp_onDemandsResult>(.+?)</GetResponPlp_onDemandsResult>#", $str_respon, $matchesx);
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


        $data_header = isset($xmlArr['HEADER']) ? $xmlArr['HEADER'] : array();
        $data_detail = isset($xmlArr['DETIL']['CONT']) ? $xmlArr['DETIL']['CONT'] : array() ;

        if($count_detail_data == 1){
            $data_detail= array($data_detail) ;
        }
        //print("<pre>".print_r($data_detail,true)."</pre>"); die;

        $count_array_header = count ((array) array_keys($data_header)) ;
        $count_array_detail = count ((array) array_keys($data_detail)) ;

        //print("<pre>".print_r($count_array_detail,true)."</pre>"); die;

        
        $newarray = array();
        for($a=0 ; $a<count ((array) array_keys($data_header)) ; $a++ ){
            $tag_value = array_keys($data_header)[$a] ;
            $value = isset($data_header[array_keys($data_header)[$a]]) ? $data_header[array_keys($data_header)[$a]] : '' ;
            if(count ((array) $value) == 0){
                $value = "" ;
            }
            $newarray =array_merge($newarray,array($tag_value => $value )) ;
        }

        $newarray = array_merge($newarray,array('CREATED_BY' => $this->session->userdata('autogate_username'))) ;   
        $newarray = array_merge($newarray,array('CREATED_ON' => tanggal_sekarang())) ;
        $newarray = array_merge($newarray,array('ID' => $ID)) ;     

        $hasil = $this->db_tpsonline->insert('tbl_respon_plp_petikemas_ondemands', $newarray);
        
        if ($hasil >= 1) {
        } else {
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Function Save Header Respon Error....!!!!','query' => $this->db_tpsonline->last_query());
            echo json_encode($pesan_data);die;
        }

        if($count_array_detail > 0){
            $savedata = array();
            for($baris = 0 ; $baris < $count_array_detail ; $baris++){
                $newarray = array();
                for($col = 0 ; $col < 8 ; $col++){
                    $tag_value = array_keys($data_detail[0])[$col] ;
                    $value = isset($data_detail[$baris][$tag_value]) ? $data_detail[$baris][$tag_value] : '' ;
                    if(count ((array) $value) == 0){
                        $value = "" ;
                    }
                    $newarray = array_merge($newarray,array($tag_value => $value));
                }
                $newarray = array_merge($newarray,array('CREATED_BY' => $this->session->userdata('autogate_username'))) ;   
                $newarray = array_merge($newarray,array('CREATED_ON' => tanggal_sekarang())) ;  
                $newarray = array_merge($newarray,array('ID' => $ID)) ;  
                array_push($savedata,$newarray);
            }

            $hasil = $this->db_tpsonline->insert_batch('tbl_respon_plp_petikemas_detail_ondemands', $savedata);

            if ($hasil >= 1) {
            } else {
                $pesan_data = array('msg' => 'Tidak','pesan' => 'Function Save Detail Respon Error....!!!!','query' => $this->db_tpsonline->last_query());
                echo json_encode($pesan_data);die;
            }
        }
            

        $this->m_model->updatedata('db_tpsonline','tbl_xml_webservice',array('id_transfer' => 1),array('id_api' => $id_api));

        $pesan_data = array(
            'msg' => $msg,
            'pesan' => $pesan,
            'data_header' => $data_header,
            'data_detail' => $data_detail,
            'query' => $this->db_tpsonline->last_query()
        );
        echo json_encode($pesan_data);

    }


    function c_transfer_plp(){
        $ID = $this->input->post('ID');

        $IDRun = $this->m_model->select_max_where('db_tpsonline','tbl_respon_plp_petikemas', 'ID');

        $dataheader = $this->db_tpsonline->get_where('tbl_respon_plp_petikemas_ondemands',array('ID' => $ID))->result_array() ;

        $this->db_tpsonline->select('REF_NUMBER');
        $REF_NUMBER = $this->db_tpsonline->get_where('tbl_respon_plp_petikemas_ondemands',array('ID' => $ID))->row()->REF_NUMBER ;

        $GET_REF_NUMBER = $this->db_tpsonline->get_where('tbl_respon_plp_petikemas',array('REF_NUMBER' => $REF_NUMBER)) ;
        if($GET_REF_NUMBER->num_rows() > 0){
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Data REF_NUMBER sudah ada ..!!',
                'GET_REF_NUMBER' => $GET_REF_NUMBER,
                //'query' => $queryku
            );
            echo json_encode($pesan_data);die;
        }

        $c = 0;

        $array_dataku = array_map(function ($a) {
            unset($a['ID']);
            unset($a['ACTIVE']);
            unset($a['FLAG_TRANSFER']);
            unset($a['CREATED_BY']);
            unset($a['CREATED_ON']);
            unset($a['EDITED_BY']);
            unset($a['EDITED_ON']);
            return $a;
        }, $dataheader);

        $array_dataku[0] = array_merge($array_dataku[0],array('ID' => $IDRun)) ; 

        $hasil = $this->db_tpsonline->insert_batch('tbl_respon_plp_petikemas', $array_dataku);
        $queryku[$c++] = $this->db_tpsonline->last_query();

        $msg = "Ya" ;
        $pesan = "Data Berhasil Di Transfer ..." ;
        if ($hasil >= 1) {
        } else {
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Function Save Header Respon Error....!!!!','query' => $this->db_tpsonline->last_query());
            echo json_encode($pesan_data);die;
        }

        $datadetail = $this->db_tpsonline->get_where('tbl_respon_plp_petikemas_detail_ondemands',array('ID' => $ID)) ;

        if($datadetail->num_rows() > 0){

            $datadetail = $datadetail->result_array();

            $array_dataku = array_map(function ($a) {
                unset($a['ID']);
                unset($a['ID_DET']);
                unset($a['ACTIVE']);
                unset($a['CREATED_BY']);
                unset($a['CREATED_ON']);
                unset($a['EDITED_BY']);
                unset($a['EDITED_ON']);
                return $a;
            }, $datadetail);

            for($aa = 0 ; $aa < count($datadetail) ; $aa++){
                $array_dataku[$aa] = array_merge($array_dataku[$aa],array('ID' => $IDRun)) ; 
            }

            $hasil = $this->db_tpsonline->insert_batch('tbl_respon_plp_petikemas_detail', $array_dataku);
            $queryku[$c++] = $this->db_tpsonline->last_query();

            if ($hasil >= 1) {
            } else {
                $pesan_data = array('msg' => 'Tidak','pesan' => 'Function Save Detail Respon Error....!!!!','query' => $this->db_tpsonline->last_query());
                echo json_encode($pesan_data);die;
            }
        }


        $this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas_ondemands',array('FLAG_TRANSFER' => 1),array('ID' => $ID));

        $pesan_data = array(
            'msg' => $msg,
            'pesan' => $pesan,
            'array_dataku' => $array_dataku,
            'query' => $queryku
        );
        echo json_encode($pesan_data);


    }

    

}