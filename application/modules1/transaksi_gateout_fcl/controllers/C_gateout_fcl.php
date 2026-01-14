<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\XmlMiddleware;

class C_gateout_fcl extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }     
        $this->db_tpsonline = $this->load->database('db_tpsonline', TRUE);  
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);     
        // $this->mbatps = $this->load->database('mbatps', TRUE); 
    }

    // function buatcombonya(){
    //     // $arraydata = $this->ptmsagate->query("SELECT id_cont_in,cont_number FROM t_t_entry_cont_in_copy limit 10000")->result_array();
    //     // array_push($arraydata, array('id_cont_in' => 'All' , 'cont_number' => 'All Data'));
    //     // $createcombo = array(
    //     //     'data' => array_reverse($arraydata,true),
    //     //     'set_data' => array('set_id' => ''),
    //     //     'attribute' => array('idname' => 'id_cont_in', 'class' => ''),
    //     // );

    //     // $this->m_model->StringToSession('createcombo',ComboDb($createcombo));



    // }
    

    function index(){

        //$this->buatcombonya();
        // print_r($this->session->userdata('createcombo'));
        // die;
        
        // print_r(ComboDb($createcombo));
        // die;

        // $response = "Proses Berhasil MBA0220707200004, Proses Berhasil MBA0220707200003, Proses Berhasil MBA0220707200002" ;
        // $array_response = explode(',',$response) ;

        // //$newarray = array();
        // for($a=0;$a<count((array) $array_response);$a++){
        //     // echo trim(str_replace('Proses Berhasil ','',$array_response[$a]));
        //     // echo '</br>';
        //     // array_push($newarray,trim(str_replace('Proses Berhasil ','',$array_response[$a])));

        //     $strdata = trim($array_response[$a]) ;
        //     $strsearch = "Proses Berhasil " ;

        //     $cekstr = Search_Str_To_Str($strdata,$strsearch) ;
        //     echo "cek ==> ".$cekstr ;


        // }

        // //print("<pre>".print_r($newarray,true)."</pre>"); 
        // die;

        //print("<pre>".print_r($query_data,true)."</pre>"); 

        // $arrREF_NUMBER = array('MBA0220707200001','MBA0220707200002');
        // $COCOCONT = "" ;
        // for($a=0 ;$a<count($arrREF_NUMBER);$a++){
        //     $STR_REF_NUMBER = $arrREF_NUMBER[$a];

        //     //BUAT HEADER
        //     $this->db_tpsonline->select('KD_DOK,KD_TPS,NM_ANGKUT,NO_VOY_FLIGHT,CALL_SIGN,TGL_TIBA,KD_GUDANG,REF_NUMBER');
        //     $this->db_tpsonline->where(array('REF_NUMBER' => $STR_REF_NUMBER));
        //     $sql = $this->db_tpsonline->get('tbl_request_plp_out_container');
        //     $sql = $this->db_tpsonline->last_query();
        //     $query_data = $this->db_tpsonline->query($sql)->result_array();
        //     $query_tagname = $this->db_tpsonline->query($sql)->list_fields();
        //     $COCOCONT.= "<COCOCONT>" ;
        //     $header = "<HEADER>";
        //     foreach ($query_data as $row) {
        //         foreach ($query_tagname as $field) {                        
        //             if ($field == "TGL_TIBA") {
        //                 $header.= '<' . $field . '>' . date_ymd($row[$field]) . '</' . $field . '>';
        //             }else{
        //                 $header.= '<' . $field . '>' . $row[$field] . '</' . $field . '>';
        //             }
        //         }
        //     }
        //     $header.= "</HEADER>";
        //     $COCOCONT.= $header ;
        //     //END BUAT HEADER

        //     //BUAT DETAIL
        //     $this->db_tpsonline->select('NO_CONT,UK_CONT,NO_SEGEL,JNS_CONT,NO_BL_AWB,TGL_BL_AWB,NO_MASTER_BL_AWB,TGL_MASTER_BL_AWB,
        //                             ID_CONSIGNEE,CONSIGNEE,BRUTO,NO_BC11,TGL_BC11,NO_POS_BC11,KD_TIMBUN,KD_DOK_INOUT,NO_DOK_INOUT,
        //                             TGL_DOK_INOUT,WK_INOUT,KD_SAR_ANGKUT_INOUT,NO_POL,FL_CONT_KOSONG,ISO_CODE,PEL_MUAT,
        //                             PEL_TRANSIT,PEL_BONGKAR,GUDANG_TUJUAN,KODE_KANTOR,NO_DAFTAR_PABEAN,TGL_DAFTAR_PABEAN,
        //                             NO_SEGEL_BC,TGL_SEGEL_BC,NO_IJIN_TPS,TGL_IJIN_TPS');
        //     $this->db_tpsonline->where(array('REF_NUMBER' => $STR_REF_NUMBER));
        //     $sql = $this->db_tpsonline->get('tbl_request_plp_out_container');
        //     $sql = $this->db_tpsonline->last_query();
        //     $query_data = $this->db_tpsonline->query($sql)->result_array();
        //     $query_tagname = $this->db_tpsonline->query($sql)->list_fields();
        //     $detil = "<DETIL><CONT>";
        //     foreach ($query_data as $row) {
        //         foreach ($query_tagname as $field) {                        
        //             $detil.= '<' . $field . '>' . $row[$field] . '</' . $field . '>';
        //         }
        //     }
        //     $detil.= "</CONT></DETIL>";
        //     $COCOCONT.= $detil ;
        //     //END BUAT DETAIL

        //     $COCOCONT.= "</COCOCONT>" ;
            

            
        // }

        // $xml_data = '<fStream><![CDATA[<?xml version="1.0" encoding="utf-8"--?==>
        //             <DOCUMENT xmlns="cococont.xsd">
        //                 '.$COCOCONT.'
        //             </DOCUMENT>]]></fStream>';

        // $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => 'CoCoCont_Tes'));
        // $xml_param = str_replace("<fStream>string</fStream>",$xml_data,$format_xml);
        // $xml_param = replace_xml_condition('Username','string','MBA0',$xml_param);
        // $xml_param = replace_xml_condition('Password','string','MBA1234560',$xml_param);     

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
        // print_r($responsebody);
        // die;




        $menu_active = $this->m_model->menu_active();

        $startdate = date('m-Y') ;
        $enddate = date('d-m-Y') ;

        $arraydata = array('' => 'ALL','Y'=> 'SUDAH KIRIM', 'N' => 'BELUM KIRIM');
        $SENDING = ComboNonDb($arraydata, 'SENDING', '', 'form-control form-control-sm');

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'startdate' => "01-$startdate" ,
            'enddate' => $enddate,
            'SENDING' => $SENDING
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_tbl_gateout_fcl(){
        $database = "db_tpsonline";

        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $NO_CONT = $this->input->post('NO_CONT');
        $NO_POS_BC11 = $this->input->post('NO_POS_BC11');
        $NO_DOK_INOUT = $this->input->post('NO_DOK_INOUT');
        $SENDING = $this->input->post('SENDING');

        $select = 'a.REF_NUMBER,a.KD_DOK,a.KD_TPS,b.jenis_export_import,a.NM_ANGKUT,a.NO_VOY_FLIGHT,a.CALL_SIGN,a.TGL_TIBA,a.KD_GUDANG,a.NO_CONT,
                    a.UK_CONT,a.NO_SEGEL,a.JNS_CONT,a.NO_BL_AWB,a.TGL_BL_AWB,a.NO_MASTER_BL_AWB,a.TGL_MASTER_BL_AWB,
                    a.ID_CONSIGNEE,a.CONSIGNEE,a.BRUTO,a.NO_BC11,a.TGL_BC11,a.NO_POS_BC11,a.KD_TIMBUN,a.KD_DOK_INOUT,c.jenis_document,
                    a.NO_DOK_INOUT,a.TGL_DOK_INOUT,a.WK_INOUT,a.KD_SAR_ANGKUT_INOUT,d.jenis_angkutan,a.NO_POL,a.FL_CONT_KOSONG,e.keterangan,a.ISO_CODE,
                    a.PEL_MUAT,a.PEL_TRANSIT,a.PEL_BONGKAR,a.GUDANG_TUJUAN,a.KODE_KANTOR,a.NO_DAFTAR_PABEAN,
                    a.TGL_DAFTAR_PABEAN,a.NO_SEGEL_BC,a.TGL_SEGEL_BC,a.NO_IJIN_TPS,a.TGL_IJIN_TPS,a.REF_NUMBER_OLD,a.SENDING,a.VALIDATE,a.REF_NUMBER_IN' ;
        $form = 'tbl_request_plp_out_container a';
        $join = array(
            array('tbl_m_tps_export_import as b' ,'a.KD_DOK = b.id','inner'),
            array('tbl_m_tps_dok_inout as c' ,'a.KD_DOK_INOUT = c.id','inner'),
            array('tbl_m_tps_angkutan as d','a.KD_SAR_ANGKUT_INOUT = d.id','inner'),
            array('tbl_m_tps_sts_container as e','a.FL_CONT_KOSONG = e.id','inner')
        );
        $where = array(
            'a.KD_DOK !=' => '',
            'b.rec_id' => 0,
            'c.rec_id' => 0,
            'd.rec_id' => 0,
        );

        if($startdate != ""){
            $tambah_where = array('date_format(a.WK_INOUT,"%Y-%m-%d") >=' => date_db($startdate));
            $where = array_merge($where, $tambah_where);
        }

        if($enddate != ""){
            $tambah_where = array('date_format(a.WK_INOUT,"%Y-%m-%d") <=' => date_db($enddate));
            $where = array_merge($where, $tambah_where);
        }

        if($SENDING != ""){
            $tambah_where = array('a.SENDING' => $SENDING);
            $where = array_merge($where, $tambah_where);
        }

        $where_like_and = array();
        if($NO_CONT != ""){
            $tambah_where = array(
                array('field' => 'NO_CONT', 'value' => $NO_CONT),
            );
            $where_like_and = array_merge($where_like_and, $tambah_where);
        }

        if($NO_POS_BC11 != ""){
             $tambah_where = array(
                array('field' => 'NO_POS_BC11', 'value' => $NO_POS_BC11),
            );
            $where_like_and = array_merge($where_like_and, $tambah_where);
        }

        if($NO_DOK_INOUT != ""){
             $tambah_where = array(
                array('field' => 'NO_DOK_INOUT', 'value' => $NO_DOK_INOUT),
            );
            $where_like_and = array_merge($where_like_and, $tambah_where);
        }

        $where_in = array('field' => array('a.SENDING'), 'value' => array('Y','N')) ;

        $where_term = array(
            'a.SENDING','a.REF_NUMBER','a.KD_DOK','a.KD_TPS','b.jenis_export_import','a.NM_ANGKUT','a.NO_VOY_FLIGHT','a.CALL_SIGN','a.TGL_TIBA','a.KD_GUDANG','a.NO_CONT',
            'a.UK_CONT','a.NO_SEGEL','a.JNS_CONT','a.NO_BL_AWB','a.TGL_BL_AWB','a.NO_MASTER_BL_AWB','a.TGL_MASTER_BL_AWB',
            'a.ID_CONSIGNEE','a.CONSIGNEE','a.BRUTO','a.NO_BC11','a.TGL_BC11','a.NO_POS_BC11','a.KD_TIMBUN','a.KD_DOK_INOUT','c.jenis_document',
            'a.NO_DOK_INOUT','a.TGL_DOK_INOUT','a.WK_INOUT','a.KD_SAR_ANGKUT_INOUT',',d.jenis_angkutan','a.NO_POL','a.FL_CONT_KOSONG','e.keterangan','a.ISO_CODE',
            'a.PEL_MUAT','a.PEL_TRANSIT','a.PEL_BONGKAR','a.GUDANG_TUJUAN','a.KODE_KANTOR','a.NO_DAFTAR_PABEAN',
            'a.TGL_DAFTAR_PABEAN','a.NO_SEGEL_BC','a.TGL_SEGEL_BC','a.NO_IJIN_TPS','a.TGL_IJIN_TPS','a.REF_NUMBER_OLD','a.VALIDATE','a.SENDING','a.REF_NUMBER_IN'
        );
        $column_order = array(
            null, 'a.SENDING','a.REF_NUMBER','a.KD_DOK','a.KD_TPS','b.jenis_export_import','a.NM_ANGKUT','a.NO_VOY_FLIGHT',
            'a.CALL_SIGN','a.TGL_TIBA','a.KD_GUDANG','a.NO_CONT',
            'a.UK_CONT','a.NO_SEGEL','a.JNS_CONT','a.NO_BL_AWB','a.TGL_BL_AWB','a.NO_MASTER_BL_AWB','a.TGL_MASTER_BL_AWB',
            'a.ID_CONSIGNEE','a.CONSIGNEE','a.BRUTO','a.NO_BC11','a.TGL_BC11','a.NO_POS_BC11','a.KD_TIMBUN','a.KD_DOK_INOUT','c.jenis_document',
            'a.NO_DOK_INOUT','a.TGL_DOK_INOUT','a.WK_INOUT','a.KD_SAR_ANGKUT_INOUT',',d.jenis_angkutan','a.NO_POL','a.FL_CONT_KOSONG','e.keterangan','a.ISO_CODE',
            'a.PEL_MUAT','a.PEL_TRANSIT','a.PEL_BONGKAR','a.GUDANG_TUJUAN','a.KODE_KANTOR','a.NO_DAFTAR_PABEAN',
            'a.TGL_DAFTAR_PABEAN','a.NO_SEGEL_BC','a.TGL_SEGEL_BC','a.NO_IJIN_TPS','a.TGL_IJIN_TPS','a.REF_NUMBER_OLD','a.VALIDATE','a.SENDING','a.REF_NUMBER_IN'
        );
        $order = array(
            'a.REF_NUMBER' => 'asc'
        );

        $group = array();

        $array_table = array(
            'select' => $select,
            'form' => $form,
            'join' => $join,
            'where' => $where,
            'where_like' => array(),
            'where_in' => $where_in,
            'where_not_in' => array(),
            'where_term' => $where_term,
            'column_order' => $column_order,
            'group' => $group,
            'order' => $order,
            'where_like_and' => $where_like_and,
        );

        $list = $this->m_model->get_datatables($database, $array_table);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = $no;

            if($field->SENDING == "N"){
                $row[] = "<div align='center'><input type='checkbox' id='idreffnumber$no' class='chkreffnumber' 
                        onclick='HandleClick(this.id,".'"'.$field->REF_NUMBER.'"'.");' value='".$field->REF_NUMBER."'></div>";   
            }else{
                $row[] = '<a class="btn btn-primary boxshadow" title="Data Ini Sudah Terkirim ..."> 
                        <span class="icon-thumbs-up1" style="color:white"></span></a>' ;
            }            
                        
            $row[] = $field->REF_NUMBER;            
            $row[] = $field->KD_DOK;
            $row[] = $field->jenis_export_import;
            $row[] = $field->KD_TPS;            
            $row[] = $field->NM_ANGKUT;
            $row[] = $field->NO_VOY_FLIGHT;
            $row[] = $field->CALL_SIGN;
            $row[] = showdate_dmy($field->TGL_TIBA);
            $row[] = $field->KD_GUDANG;            
            $row[] = $field->NO_CONT;
            $row[] = $field->UK_CONT;
            $row[] = $field->NO_SEGEL;
            $row[] = $field->JNS_CONT;
            $row[] = $field->NO_BL_AWB;
            $row[] = showdate_dmy($field->TGL_BL_AWB);
            $row[] = $field->NO_MASTER_BL_AWB;
            $row[] = showdate_dmy($field->TGL_MASTER_BL_AWB);
            $row[] = $field->ID_CONSIGNEE;
            $row[] = $field->CONSIGNEE;
            $row[] = $field->BRUTO;
            $row[] = $field->NO_BC11;
            $row[] = showdate_dmy($field->TGL_BC11);
            $row[] = $field->NO_POS_BC11;
            $row[] = $field->KD_TIMBUN;
            $row[] = $field->KD_DOK_INOUT;
            $row[] = $field->jenis_document;
            $row[] = $field->NO_DOK_INOUT;
            $row[] = showdate_dmy($field->TGL_DOK_INOUT);
            $row[] = showdate_dmyhis($field->WK_INOUT);
            $row[] = $field->KD_SAR_ANGKUT_INOUT;
            $row[] = $field->jenis_angkutan ;
            $row[] = $field->NO_POL;
            $row[] = $field->FL_CONT_KOSONG;
            $row[] = $field->keterangan;
            $row[] = $field->ISO_CODE;
            $row[] = $field->PEL_MUAT;
            $row[] = $field->PEL_TRANSIT;
            $row[] = $field->PEL_BONGKAR;
            $row[] = $field->GUDANG_TUJUAN;
            $row[] = $field->KODE_KANTOR;
            $row[] = $field->NO_DAFTAR_PABEAN;
            $row[] = showdate_dmy($field->TGL_DAFTAR_PABEAN);
            $row[] = $field->NO_SEGEL_BC;
            $row[] = showdate_dmy($field->TGL_SEGEL_BC);
            $row[] = $field->NO_IJIN_TPS;
            $row[] = showdate_dmy($field->TGL_IJIN_TPS);
            $row[] = $field->REF_NUMBER_OLD;       
            $row[] = $field->VALIDATE;       
            $row[] = $field->SENDING;   
            $row[] = $field->REF_NUMBER_IN;   
            
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

    function c_formedit(){

        $REF_NUMBER = $this->input->post('REF_NUMBER');

        $array_search = $this->m_model->table_tostring('db_tpsonline', '', 'tbl_request_plp_out_container', '', array('REF_NUMBER' => $REF_NUMBER), '');
        $data['array_search'] = $array_search;

        $arraydata = $this->db_tpsonline->query("SELECT id,concat(id,' ~ ',jenis_export_import) 'jenis_export_import' FROM tbl_m_tps_export_import where rec_id=0")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => $array_search['KD_DOK']),
            'attribute' => array('idname' => 'jenis_export_import', 'class' => 'form-control-sm'),
        );
        $data['jenis_export_import'] = ComboDb($createcombo);


        $arraydata = array('F'=> 'FCL', 'L' => 'LCL');
        $JNS_CONT = ComboNonDb($arraydata, 'JNS_CONT', $array_search['JNS_CONT'], 'form-control form-control-sm');
        $data['JNS_CONT'] = $JNS_CONT;


        $arraydata = $this->db_tpsonline->query("SELECT id,concat(id,' ~ ',jenis_document) 'jenis_document' FROM tbl_m_tps_dok_inout where rec_id=0")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => $array_search['KD_DOK_INOUT']),
            'attribute' => array('idname' => 'jenis_document', 'class' => 'form-control-sm'),
        );
        $data['jenis_document'] = ComboDb($createcombo);

        $arraydata = array('1'=> 'Kosong', '2' => 'Isi');
        $FL_CONT_KOSONG = ComboNonDb($arraydata, 'FL_CONT_KOSONG', $array_search['FL_CONT_KOSONG'], 'form-control form-control-sm');
        $data['FL_CONT_KOSONG'] = $FL_CONT_KOSONG;

        $this->load->view('edit',$data);
    }

    function c_update(){
        $database = 'db_tpsonline' ;
        
        $REF_NUMBER = $this->input->post('REF_NUMBER');
        $jenis_export_import = $this->input->post('jenis_export_import');
        $JNS_CONT = $this->input->post('JNS_CONT');
        $jenis_document = $this->input->post('jenis_document');
        $FL_CONT_KOSONG = $this->input->post('FL_CONT_KOSONG');
        $NO_POS_BC11 = $this->input->post('NO_POS_BC11');
        $NO_DOK_INOUT = $this->input->post('NO_DOK_INOUT_EDIT');
        $TGL_DOK_INOUT = date_db($this->input->post('TGL_DOK_INOUT'));
        
        $where = array(
            'REF_NUMBER' => $REF_NUMBER
        );
  
        $data = array(
            'KD_DOK' => $jenis_export_import,
            'JNS_CONT' => $JNS_CONT,
            'KD_DOK_INOUT' => $jenis_document,
            'FL_CONT_KOSONG' => $FL_CONT_KOSONG,
            'NO_POS_BC11' => $NO_POS_BC11,
            'NO_DOK_INOUT' => $NO_DOK_INOUT,
            'TGL_DOK_INOUT' => $TGL_DOK_INOUT,
        );
        $hasil = $this->m_model->updatedata($database, 'tbl_request_plp_out_container', $data, $where);
        
        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Update Data Sukses..',
                'data' => $data,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Update Data Error....!!!!',
                'data' => $data,
            );
            echo json_encode($pesan_data);
            die;
        }
        
        
        echo json_encode($pesan_data);
    }

    function c_get_ready_reffnumber(){
        $query = " SELECT REF_NUMBER 
            FROM tbl_request_plp_out_container
            WHERE WK_INOUT >= CURDATE() - INTERVAL 7 DAY
            AND SENDING = 'N' 
            and (WK_INOUT is not null or WK_INOUT <> '')
            and (KD_TIMBUN is not null or KD_TIMBUN <> '. .. .. ..')
            and (NO_POL is not null or NO_POL <> '')
            and (NO_IJIN_TPS is not null or NO_IJIN_TPS <> '')
            and (TGL_IJIN_TPS is not null or TGL_IJIN_TPS <> '')
            and (NO_BL_AWB is not null or NO_BL_AWB <> '')
            ORDER BY WK_INOUT DESC " ;

        $data = $this->db_tpsonline->query($query) ;

        if($data->num_rows() == 0){
            $dataX = array(
                'arrREF_NUMBER' => '',
            );

            echo json_encode($dataX);
            die;
        }

        $ref_numbers = array_column($data->result_array(), 'REF_NUMBER');

        $stringref = implode(',', $ref_numbers);

        $dataX = array(
            'arrREF_NUMBER' => $stringref,
        );

        echo json_encode($dataX);
    }

    function c_formkirimdata(){
        $arrREF_NUMBER = ArrayToString($this->input->post('arrREF_NUMBER')) ;

        $proses = $this->input->post('proses');

        $data = array(
            'arrREF_NUMBER' => $arrREF_NUMBER,
            'proses' => $proses
        );

        $this->load->view('kirim',$data);

    }

    function c_kirimdata(){
        $arrREF_NUMBER = explode(',',$this->input->post('arrREF_NUMBER'));
        $proses = $this->input->post('proses');

        $UserName = $this->input->post('UserName') ;
        $Password = $this->input->post('Password') ;


        $COCOCONT = "" ;
        for($a=0 ;$a<count($arrREF_NUMBER);$a++){
            $STR_REF_NUMBER = $arrREF_NUMBER[$a];

            //BUAT HEADER
            $this->db_tpsonline->select('KD_DOK,KD_TPS,NM_ANGKUT,NO_VOY_FLIGHT,CALL_SIGN,TGL_TIBA,KD_GUDANG,REF_NUMBER');
            $this->db_tpsonline->where(array('REF_NUMBER' => $STR_REF_NUMBER));
            $sql = $this->db_tpsonline->get('tbl_request_plp_out_container');
            $sql = $this->db_tpsonline->last_query();
            $query_data = $this->db_tpsonline->query($sql)->result_array();
            $query_tagname = $this->db_tpsonline->query($sql)->list_fields();
            $COCOCONT.= "<COCOCONT>" ;
            $header = "<HEADER>";
            foreach ($query_data as $row) {
                foreach ($query_tagname as $field) {                        
                    if ($field == "TGL_TIBA") {
                        $header.= '<' . $field . '>' . date_ymd($row[$field]) . '</' . $field . '>';
                    }else{
                        $header.= '<' . $field . '>' . $row[$field] . '</' . $field . '>';
                    }
                }
            }
            $header.= "</HEADER>";
            $COCOCONT.= $header ;
            //END BUAT HEADER

            //BUAT DETAIL
            $this->db_tpsonline->select('NO_CONT,UK_CONT,NO_SEGEL,JNS_CONT,NO_BL_AWB,TGL_BL_AWB,NO_MASTER_BL_AWB,TGL_MASTER_BL_AWB,
                                    ID_CONSIGNEE,CONSIGNEE,BRUTO,NO_BC11,TGL_BC11,NO_POS_BC11,KD_TIMBUN,KD_DOK_INOUT,NO_DOK_INOUT,
                                    TGL_DOK_INOUT,WK_INOUT,KD_SAR_ANGKUT_INOUT,NO_POL,FL_CONT_KOSONG,ISO_CODE,PEL_MUAT,
                                    PEL_TRANSIT,PEL_BONGKAR,GUDANG_TUJUAN,KODE_KANTOR,NO_DAFTAR_PABEAN,TGL_DAFTAR_PABEAN,
                                    NO_SEGEL_BC,TGL_SEGEL_BC,NO_IJIN_TPS,TGL_IJIN_TPS');
            $this->db_tpsonline->where(array('REF_NUMBER' => $STR_REF_NUMBER));
            $sql = $this->db_tpsonline->get('tbl_request_plp_out_container');
            $sql = $this->db_tpsonline->last_query();
            $query_data = $this->db_tpsonline->query($sql)->result_array();
            $query_tagname = $this->db_tpsonline->query($sql)->list_fields();
            $detil = "<DETIL><CONT>";
            foreach ($query_data as $row) {
                foreach ($query_tagname as $field) {                        
                    if ($field == "TGL_BL_AWB" || $field == "TGL_MASTER_BL_AWB" || $field == "TGL_BC11" || $field == "TGL_DOK_INOUT" || $field == "TGL_DAFTAR_PABEAN" || $field == "TGL_SEGEL_BC" || $field == "TGL_IJIN_TPS") {
                        $detil.= '<' . $field . '>' . date_ymd($row[$field]) . '</' . $field . '>';
                    } elseif ($field == "WK_INOUT") {
                        $detil.='<' . $field . '>' . date_ymdhis($row[$field]) . '</' . $field . '>';
                    } else {
                        $detil.= '<' . $field . '>' . $row[$field] . '</' . $field . '>';
                    }
                }
            }
            $detil.= "</CONT></DETIL>";
            $COCOCONT.= $detil ;
            //END BUAT DETAIL

            $COCOCONT.= "</COCOCONT>" ;
            

            
        }

        $xml_data = '<fStream><![CDATA[<?xml version="1.0" encoding="utf-8"?>
                    <DOCUMENT xmlns="cococont.xsd">
                        '.$COCOCONT.'
                    </DOCUMENT>]]></fStream>';

        if($proses == "live"){
            //LIVE
            $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => 'CoarriCodeco_Container')); 
        }else{
            //TEST SERVICE          
            $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => 'CoCoCont_Tes'));
        }         
                    
        

                       
        $xml_param = str_replace("<fStream>string</fStream>",$xml_data,$format_xml);
        $xml_param = replace_xml_condition('Username','string',$UserName,$xml_param);
        $xml_param = replace_xml_condition('Password','string',$Password,$xml_param);     

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


        if($proses == "live"){
            //LIVE
            preg_match_all("#<CoarriCodeco_ContainerResult>(.+?)</CoarriCodeco_ContainerResult>#", $responsebody, $matches);
        }else{
            //TEST SERVICE      
            preg_match_all("#<CoCoCont_TesResult>(.+?)</CoCoCont_TesResult>#", $responsebody, $matches);
        }
            

        $dataku = '';
        foreach ($matches[0] as $value) {
            $dataku = $value;
        }
        
        $xml = simplexml_load_string($dataku);
        $json  = json_encode($xml);
        $xmlArr = json_decode($json, true);

        //save respons
        if($proses == "live"){
            $this->m_model->save_response('CoarriCodeco_Container',$xml_param,$responsebody);
        }else{
            $this->m_model->save_response('CoCoCont_Tes',$xml_param,$responsebody);
        } 


        $pesan_data = array(
            'pesan' => $xmlArr[0],
        );
        echo json_encode($pesan_data);


    }



    function c_sinkron_to_gateoutfcl(){
        $array_response = explode(';',$this->input->post('datarespon'));
        $queryku = array();
        for($a=0;$a<count((array) $array_response);$a++){

            $str_trim_data = trim($array_response[$a]) ;

            //dapat data no referensi
            $str_replace_data = str_replace('Proses Berhasil ','',$str_trim_data) ;

            $cek_reff_number = Search_Str_To_Str($str_trim_data,$str_replace_data) ;
            $cek_proses = Search_Str_To_Str($str_trim_data,"Proses Berhasil ") ;

            if($cek_reff_number == 1 &&  $cek_proses == 1){
                $hasil = $this->db_tpsonline->update('tbl_request_plp_out_container',array('SENDING' => 'Y'),array('REF_NUMBER' => explode(' ',$str_replace_data)[1]));
                $queryku[$a] = $this->db_tpsonline->last_query();
                if ($hasil >= 1) {
                }else{
                    $pesan_data = array(
                        'pesan' => $array_response,
                        'queryku' => $queryku
                    );
                    echo json_encode($pesan_data);die;
                }
                
            }


        }

        $pesan_data = array(
            'pesan' => $array_response,
            'queryku' => $queryku
        );
        echo json_encode($pesan_data);
    }


    function c_change_reff_number(){

        $REF_NUMBER = $this->input->post('REF_NUMBER');

        $dataku = $this->db_tpsonline->get_where('tbl_request_plp_out_container',array('REF_NUMBER' => $REF_NUMBER));

        $REF_NUMBER_NEW = "" ;
        $a = 0 ;

        foreach($dataku->result_array() as $detail){
            $GetKD_TPS = $detail['KD_TPS'] ;
            $this->m_model->set_run_number_tpsonline($GetKD_TPS,'FCL','tbl_run_number_tpsonline');
            $where = array('NAME' => 'FCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $GetKD_TPS);

            $get_ref_number = $this->db_tpsonline->get_where('tbl_run_number_tpsonline',
                array('NAME' => 'FCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $GetKD_TPS))->result_array();

            foreach($get_ref_number as $result){                
                $GetYEAR = $result['YEAR'] ;
                $GetMONTH = $result['MONTH'] ;
                $GetNUMBER = $result['NUMBER'] ;
            }

            $this->m_model->updatedata('db_tpsonline','tbl_run_number_tpsonline', array('NUMBER' => $GetNUMBER + 1), $where);
            $GetNUMBER = str_pad($GetNUMBER, 6, "400000", STR_PAD_LEFT);
            $GetDATE = date('m');
            $REF_NUMBER_NEW = $GetKD_TPS . '' . $GetYEAR . '' . $GetMONTH . '' . $GetDATE . '' . $GetNUMBER;

        }
        

        $hasil = $this->db_tpsonline->update('tbl_request_plp_out_container',
                        array('REF_NUMBER' => $REF_NUMBER_NEW,'REF_NUMBER_OLD' => $REF_NUMBER,'VALIDATE' => 'N' ,'SENDING' => 'N'), 
                        array('REF_NUMBER' => $REF_NUMBER) ) ;

        $queryku[$a] = $this->db_tpsonline->last_query();

        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Ganti No REF_NUMBER Berhasil...',
                'queryku' => $queryku
            );
            echo json_encode($pesan_data);die;
        }else{
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Ganti No REF_NUMBER Gagal...',
                'queryku' => $queryku
            );
            echo json_encode($pesan_data);die;
        }


        // $hasil = $this->db_tpsonline->update('tbl_respon_plp_petikemas_detail',
        //                 array('REF_NUMBER_FCL_IN' => $REF_NUMBER_NEW), 
        //                 array('REF_NUMBER_FCL_IN' => $REF_NUMBER) ) ;

        // $queryku[$a++] = $this->db_tpsonline->last_query();

        // if ($hasil >= 1) {
        //     $pesan_data = array(
        //         'msg' => 'Ya',
        //         'pesan' => 'Ganti No REF_NUMBER Berhasil...',
        //         'queryku' => $queryku
        //     );
        //     echo json_encode($pesan_data);die;
        // }else{
        //     $pesan_data = array(
        //         'msg' => 'Tidak',
        //         'pesan' => 'Ganti No REF_NUMBER Gagal...',
        //         'queryku' => $queryku
        //     );
        //     echo json_encode($pesan_data);die;
        // }

    }


    function c_delete_reff_number(){
        $arrREF_NUMBER = $this->input->post('arrREF_NUMBER');

        for($a=0 ;$a<count($arrREF_NUMBER);$a++){
            $STR_REF_NUMBER = $arrREF_NUMBER[$a];

            $hasil = $this->db_tpsonline->update('tbl_request_plp_out_container',
                array('SENDING' => 'D'), 
                array('REF_NUMBER' => $STR_REF_NUMBER) ) ;

            $queryku = $this->db_tpsonline->last_query();

            if ($hasil >= 1) {

            }else{
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Delete Data Gagal... ==> '.$STR_REF_NUMBER,
                    'queryku' => $queryku
                );
                echo json_encode($pesan_data);die;
            }

        }

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => 'Delete Data Berhasil...',
            'queryku' => $queryku
        );
        echo json_encode($pesan_data);die;

    }


    function c_import_gate_out(){

        // $REF_NUMBER = $this->input->post('REF_NUMBER');

        // $array_search = $this->m_model->table_tostring('db_tpsonline', '', 'tbl_request_plp_out_container', '', array('REF_NUMBER' => $REF_NUMBER), '');
        // $data['array_search'] = $array_search;

        // $arraydata = $this->db_tpsonline->query("SELECT id,concat(id,' ~ ',jenis_export_import) 'jenis_export_import' FROM tbl_m_tps_export_import where rec_id=0")->result_array();
        // $createcombo = array(
        //     'data' => $arraydata,
        //     'set_data' => array('set_id' => $array_search['KD_DOK']),
        //     'attribute' => array('idname' => 'jenis_export_import', 'class' => 'form-control-sm'),
        // );
        // $data['jenis_export_import'] = ComboDb($createcombo);


        // $arraydata = array('F'=> 'FCL', 'L' => 'LCL');
        // $JNS_CONT = ComboNonDb($arraydata, 'JNS_CONT', $array_search['JNS_CONT'], 'form-control form-control-sm');
        // $data['JNS_CONT'] = $JNS_CONT;


        // $arraydata = $this->db_tpsonline->query("SELECT id,concat(id,' ~ ',jenis_document) 'jenis_document' FROM tbl_m_tps_dok_inout where rec_id=0")->result_array();
        // $createcombo = array(
        //     'data' => $arraydata,
        //     'set_data' => array('set_id' => $array_search['KD_DOK_INOUT']),
        //     'attribute' => array('idname' => 'jenis_document', 'class' => 'form-control-sm'),
        // );
        // $data['jenis_document'] = ComboDb($createcombo);

        // $arraydata = array('1'=> 'Kosong', '2' => 'Isi');
        // $FL_CONT_KOSONG = ComboNonDb($arraydata, 'FL_CONT_KOSONG', $array_search['FL_CONT_KOSONG'], 'form-control form-control-sm');
        // $data['FL_CONT_KOSONG'] = $FL_CONT_KOSONG;

        $this->load->view('import_gate_out');
    }

    function c_table_data_out(){

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

        $select = "a.do_number,a.cont_number,a.cont_date_out,a.cont_date_in,a.id_cont_out";
        $form = 't_t_entry_cont_out as a';
        $join = array(
            array('t_t_entry_do_cont_out as b','a.do_number=b.do_number and a.code_principal=b.code_principal','inner'),
        );
        $where = array('a.rec_id' => 0,'b.rec_id' => 0);

        $where_like = array();        
        $tambah_where = array(
            array('field' => 'a.cont_number', 'value' => $this->input->post('search_on_modal')),
        );
        $where_like = array_merge($where_like, $tambah_where);
        

        $where_term = array();
        $column_order = array(
            'a.do_number','a.cont_number','a.cont_date_out','a.cont_date_in','a.id_cont_out'
        );
        $order = array(
            'a.cont_number' => 'asc',
            'a.cont_date_out' => 'desc',
        );

        $group = 'a.id_cont_out';

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

        $list = $this->m_model->get_datatables('ptmsagate', $array_table);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = $field->do_number;
            $row[] = $field->cont_number;
            $row[] = showdate_dmy($field->cont_date_out);
            $row[] = showdate_dmy($field->cont_date_in);            
            $row[] = $field->id_cont_out;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_model->count_all('ptmsagate', $array_table),
            "recordsFiltered" => $this->m_model->count_filtered('ptmsagate', $array_table),
            "data" => $data,
        );

        echo json_encode($output);
    }

    function c_proses_import_entryout(){
        $id_cont_out = $this->input->post('id_cont_out');
        $NO_CONT = $this->input->post('NO_CONT');
        $NO_CONT_REPLACE = $this->input->post('NO_CONT_REPLACE');
        $cont_date_out = date_db($this->input->post('cont_date_out'));
        $cont_date_in = date_db($this->input->post('cont_date_in'));

        if($cont_date_in < '2023-01-01'){
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Data Masuk Dibawah Tahun 2023 Tidak Masuk Criteria Import ..!!',
                'query' => $this->db_tpsonline->last_query(),
            );
            echo json_encode($pesan_data);die;
        }

        //cek data ke table tbl_request_plp_out_container
        $dataout = $this->db_tpsonline->get_where('tbl_request_plp_out_container',array('NO_CONT' => $NO_CONT_REPLACE,"date_format(WK_INOUT,'%Y-%m-%d')" => $cont_date_out));
        if($dataout->num_rows() > 0){
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Data Sudah Ada Silahkan Cari Terlebih Dahulu ..!!',
                'query' => $this->db_tpsonline->last_query(),
            );
            echo json_encode($pesan_data);die;
        }
        //End cek data ke table tbl_request_plp_out_container

        //buka data kontainer out gate
        $gate_out = $this->ptmsagate->get_where('t_t_entry_cont_out',array('id_cont_out' => $id_cont_out))->result_array();
        $seal_number = "" ;
        $location_gabung1 = "" ;
        $do_number = "" ;
        $cont_time_out = "" ;
        $truck_number = "" ;
        $cont_status = "" ;
        //$code_principal = "" ;
        foreach($gate_out as $gtout){
            $seal_number = $gtout['seal_number'] ;
            $location_gabung1 =  $gtout['block_loc'].' '.$gtout['location'] ;
            $do_number = $gtout['do_number'] ;
            $cont_time_out = $gtout['cont_time_out'] ;
            $truck_number = $gtout['truck_number'] ;
            $cont_status = $gtout['cont_status'] ;
            //$code_principal = $gtout['code_principal'] ;
        }

        $FL_CONT_KOSONG = "" ;
        if($cont_status == "Full"){
            $FL_CONT_KOSONG = 2 ;
        }else{
            $FL_CONT_KOSONG = 1 ;
        }

        // if($code_principal == "TPS"){
        //     $code_principal = "F" ;
        // }else if($code_principal == "PJT" || $code_principal == "LCL" ){
        //     $code_principal = "L" ;
        // }else{
        //     $code_principal = "X" ;
        // }

        //end buka data kontainer out gate

        //cek data ke tpsonline in kontainer
        $this->db_tpsonline->order_by('WK_INOUT','DESC');
        $this->db_tpsonline->limit(1);
        $datain = $this->db_tpsonline->get_where('tbl_request_plp_in_container',array('NO_CONT' => $NO_CONT_REPLACE));
        if($datain->num_rows() == 0){
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Data Tidak Ada Di Data FCL IN KONTAINER (data tidak lengkap) ..!!',
                'query' => $this->db_tpsonline->last_query(),
            );
            echo json_encode($pesan_data);die;
        }

        $REF_NUMBER = "" ;
        $datasave = array();

        foreach($datain->result_array() as $detail){

            $GetKD_TPS = $detail['KD_TPS'] ;
            $this->m_model->set_run_number_tpsonline($GetKD_TPS,'FCL','tbl_run_number_tpsonline');
            $where = array('NAME' => 'FCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $detail['KD_TPS']);
            $get_ref_number = $this->db_tpsonline->get_where('tbl_run_number_tpsonline',
                array('NAME' => 'FCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $detail['KD_TPS']))->result_array();
            
            foreach($get_ref_number as $result){                
                $GetYEAR = $result['YEAR'] ;
                $GetMONTH = $result['MONTH'] ;
                $GetNUMBER = $result['NUMBER'] ;
            }

            $this->m_model->updatedata('db_tpsonline','tbl_run_number_tpsonline', array('NUMBER' => $GetNUMBER + 1), $where);
            $GetNUMBER = str_pad($GetNUMBER, 6, "400000", STR_PAD_LEFT);
            $GetDATE = date('m');
            $REF_NUMBER = $GetKD_TPS . '' . $GetYEAR . '' . $GetMONTH . '' . $GetDATE . '' . $GetNUMBER;


            $datasave = array(
                'KD_DOK' => 6,
                'KD_TPS' => $detail['KD_TPS'],
                'NM_ANGKUT' => $detail['NM_ANGKUT'],
                'NO_VOY_FLIGHT' => $detail['NO_VOY_FLIGHT'],
                'CALL_SIGN' => $detail['CALL_SIGN'],
                'TGL_TIBA' => $detail['TGL_TIBA'],
                'KD_GUDANG' => $detail['GUDANG_TUJUAN'],
                'REF_NUMBER' => $REF_NUMBER,
                'NO_CONT' => $detail['NO_CONT'],
                'UK_CONT' => $detail['UK_CONT'],
                'NO_SEGEL' => $seal_number,  //ini di input pada saat gate out 
                'JNS_CONT' => $detail['JNS_CONT'],
                'NO_BL_AWB' => $do_number,                
                'TGL_BL_AWB' => $detail['TGL_BL_AWB'],
                'NO_MASTER_BL_AWB' => '',
                'TGL_MASTER_BL_AWB' => null,
                'ID_CONSIGNEE' => $detail['ID_CONSIGNEE'], 
                'CONSIGNEE' => $detail['CONSIGNEE'],              
                'BRUTO' => $detail['BRUTO'],  
                'NO_BC11' => $detail['NO_BC11'],
                'TGL_BC11' => $detail['TGL_BC11'],
                'NO_POS_BC11' => $detail['NO_POS_BC11'],
                'KD_TIMBUN' => $location_gabung1,  //ini di input pada saat gate out
                'KD_DOK_INOUT' => 1,
                'NO_DOK_INOUT' => $detail['NO_DOK_INOUT'],
                'TGL_DOK_INOUT' => $detail['TGL_DOK_INOUT'],
                'WK_INOUT' => date_db($cont_date_out).' '.$cont_time_out,
                'KD_SAR_ANGKUT_INOUT' => 1,
                'NO_POL' => $truck_number,  //ini di input pada saat gate out
                'FL_CONT_KOSONG' => $FL_CONT_KOSONG,
                'ISO_CODE' => '',
                'PEL_MUAT' => '',
                'PEL_TRANSIT' => '',
                'PEL_BONGKAR' => '',
                'GUDANG_TUJUAN' => $detail['GUDANG_TUJUAN'],
                'KODE_KANTOR' => '070100',
                'NO_DAFTAR_PABEAN' => '',
                'TGL_DAFTAR_PABEAN' => null,
                'NO_SEGEL_BC' => '',
                'TGL_SEGEL_BC' => null,
                'NO_IJIN_TPS' => $detail['NO_IJIN_TPS'],
                'TGL_IJIN_TPS' => $detail['TGL_IJIN_TPS'],
                'REF_NUMBER_IN' => $detail['REF_NUMBER'],
            );
        }


        $hasil = $this->db_tpsonline->insert('tbl_request_plp_out_container', $datasave);
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


    }

    function c_exportxls(){
        
        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);

        $startdate = $data[0] ;
        $enddate = $data[1] ;
        $NO_POS_BC11 = $data[2] ;
        $NO_CONT = $data[3] ;
        $NO_DOK_INOUT = $data[4] ;
        $SENDING = $data[5] ;

        $nm = "" ;
        if($SENDING == ""){
            $nm = "All" ;
        }else if($SENDING == "Y"){
            $nm = "Sudah_Kirim" ;
        }else{
            $nm = "Belum_Kirim" ;
        }
        
        $nama_excel = "GateOutFCL_".$nm."_".tanggal_sekarang() ;

        $query = " SELECT a.REF_NUMBER, a.KD_DOK, a.KD_TPS, b.jenis_export_import, a.NM_ANGKUT, " ;
        $query.= " a.NO_VOY_FLIGHT, a.CALL_SIGN, date_format(a.TGL_TIBA,'%d-%m-%Y') 'TGL_TIBA', a.KD_GUDANG, a.NO_CONT, a.UK_CONT,  " ;
        $query.= " a.NO_SEGEL, a.JNS_CONT, a.NO_BL_AWB, date_format(a.TGL_BL_AWB,'%d-%m-%Y') 'TGL_BL_AWB', a.NO_MASTER_BL_AWB,  " ;
        $query.= " date_format(a.TGL_MASTER_BL_AWB,'%d-%m-%Y') 'TGL_MASTER_BL_AWB', a.ID_CONSIGNEE, a.CONSIGNEE, a.BRUTO, a.NO_BC11,  " ;
        $query.= " date_format(a.TGL_BC11,'%d-%m-%Y') 'TGL_BC11', a.NO_POS_BC11, a.KD_TIMBUN, a.KD_DOK_INOUT, c.jenis_document,  " ;
        $query.= " a.NO_DOK_INOUT, date_format(a.TGL_DOK_INOUT,'%d-%m-%Y') 'TGL_DOK_INOUT', date_format(a.WK_INOUT,'%d-%m-%Y %H:%i') 'WK_INOUT', a.KD_SAR_ANGKUT_INOUT,  " ;
        $query.= " d.jenis_angkutan, a.NO_POL, a.FL_CONT_KOSONG, e.keterangan, a.ISO_CODE,  " ;
        $query.= " a.PEL_MUAT, a.PEL_TRANSIT, a.PEL_BONGKAR, a.GUDANG_TUJUAN, a.KODE_KANTOR,  " ;
        $query.= " a.NO_DAFTAR_PABEAN, date_format(a.TGL_DAFTAR_PABEAN,'%d-%m-%Y') 'TGL_DAFTAR_PABEAN', a.NO_SEGEL_BC, date_format(a.TGL_SEGEL_BC,'%d-%m-%Y') 'TGL_SEGEL_BC',  " ;
        $query.= " a.NO_IJIN_TPS, date_format(a.TGL_IJIN_TPS,'%d-%m-%Y') 'TGL_IJIN_TPS', a.REF_NUMBER_OLD, a.SENDING, a.VALIDATE " ;
        $query.= " FROM tbl_request_plp_out_container a " ;
        $query.= " INNER JOIN tbl_m_tps_export_import as b ON a.KD_DOK = b.id " ;
        $query.= " INNER JOIN tbl_m_tps_dok_inout as c ON a.KD_DOK_INOUT = c.id " ;
        $query.= " INNER JOIN tbl_m_tps_angkutan as d ON a.KD_SAR_ANGKUT_INOUT = d.id " ;
        $query.= " INNER JOIN tbl_m_tps_sts_container as e ON a.FL_CONT_KOSONG = e.id " ;
        $query.= " WHERE a.KD_DOK != '' " ;
        $query.= " AND b.rec_id = 0 " ;
        $query.= " AND c.rec_id = 0 " ;
        $query.= " AND d.rec_id = 0 " ;
        
        

        if($startdate != ""){
            $query.= " AND date_format(a.WK_INOUT,'%Y-%m-%d') >='".date_db($startdate)."' " ;
        }

        if($enddate != ""){
            $query.= " AND date_format(a.WK_INOUT,'%Y-%m-%d') <='".date_db($enddate)."' " ;
        }

        if($NO_POS_BC11 != ""){
            $query.= " and a.NO_POS_BC11 like'%".$NO_POS_BC11."%' " ;
        }

        if($NO_CONT != ""){
            $query.= " and a.NO_CONT like'%".$NO_CONT."%' " ;
        }

        if($NO_DOK_INOUT != ""){
            $query.= " and a.NO_DOK_INOUT like'%".$NO_DOK_INOUT."%' " ;
        }

        if($SENDING == ""){
            $query.= " AND a.SENDING IN('Y', 'N') " ;
        }else{            
            $query.= " and a.SENDING ='".$SENDING."' " ;
        }

        
        $query.= " ORDER BY a.REF_NUMBER ASC " ; 

        $data1 = $this->db_tpsonline->query($query)->result_array();
        

        


        //Setting Sheet Excel
        $nama_sheet = array(
            '0' => 'FCL Gate Out',
        );

        $data_all_sheet = array(
            '0' => $data1,
        );

        $setting_xls = array(
            'jumlah_sheet' => 1 ,
            'nama_excel' => $nama_excel,
            'nama_sheet' => $nama_sheet,
            'data_all_sheet' => $data_all_sheet,
        );

        //print("<pre>".print_r($setting_xls,true)."</pre>"); die;
        $this->m_model->generator_xls($setting_xls);
    }


    function c_create_sj(){

        $TGL_DOK_INOUT = $this->input->post('TGL_DOK_INOUT');

        $Date = substr($TGL_DOK_INOUT, 0,2);
        $Month = substr($TGL_DOK_INOUT, 3,2);
        $Year = substr($TGL_DOK_INOUT, 8,2);

        $nomor_SJ = "" ;

        $get_ref_number = $this->db_tpsonline->get_where('tbl_run_number_tpsonline',array('NAME' => 'SJMBA','YEAR' => $Year,'MONTH' => $Month,'KD_TPS' => 'SJMB'));

        if($get_ref_number->num_rows() == 0){

            $data = array(
                'KD_TPS'    => 'SJMB',
                'YEAR'      => $Year,
                'MONTH'     => $Month,
                'NUMBER'    => 1,
                'NAME'      => 'SJMBA'
            );
            $this->m_model->savedata('db_tpsonline','tbl_run_number_tpsonline', $data)  ;

            $nomor = str_pad(1, 3, "000", STR_PAD_LEFT) ;

            $nomor_SJ = 'SJMBA_'.$Year.$Month.$Date.$nomor ;

        }else{

            $get_ref_number = $this->db_tpsonline->get_where('tbl_run_number_tpsonline',
                array('NAME' => 'SJMBA','YEAR' => $Year,'MONTH' =>  $Month,'KD_TPS' => 'SJMB'))->result_array();

            $GetNUMBER = "" ;
            foreach($get_ref_number as $result){                
                // $GetYEAR = $result['YEAR'] ;
                // $GetMONTH = $result['MONTH'] ;
                $GetNUMBER = $result['NUMBER'] ;
            }

            $where = array('NAME' => 'SJMBA','YEAR' => $Year,'MONTH' => $Month,'KD_TPS' => 'SJMB');
            $this->m_model->updatedata('db_tpsonline','tbl_run_number_tpsonline', array('NUMBER' => $GetNUMBER + 1), $where);

            $nomor = str_pad($GetNUMBER+1, 3, "000", STR_PAD_LEFT) ;

            $nomor_SJ = 'SJMBA_'.$Year.$Month.$Date.$nomor ;
        }

        $comp = array(
            'TGL_DOK_INOUT' => $TGL_DOK_INOUT, 
            'query' => $this->db_tpsonline->last_query(),
            'nomor_SJ' => $nomor_SJ,
        );

        echo json_encode($comp);









    }

}