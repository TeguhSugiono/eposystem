<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\XmlMiddleware;

class C_gatein_lcl extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }     
        $this->db_tpsonline = $this->load->database('db_tpsonline', TRUE);  
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);     
        $this->tribltps = $this->load->database('tribltps', TRUE); 
    }

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
        // $COCOKMS = "" ;
        // for($a=0 ;$a<count($arrREF_NUMBER);$a++){
        //     $STR_REF_NUMBER = $arrREF_NUMBER[$a];

        //     //BUAT HEADER
        //     $this->db_tpsonline->select('KD_DOK,KD_TPS,NM_ANGKUT,NO_VOY_FLIGHT,CALL_SIGN,TGL_TIBA,KD_GUDANG,REF_NUMBER');
        //     $this->db_tpsonline->where(array('REF_NUMBER' => $STR_REF_NUMBER));
        //     $sql = $this->db_tpsonline->get('tbl_request_plp_in_kemasan');
        //     $sql = $this->db_tpsonline->last_query();
        //     $query_data = $this->db_tpsonline->query($sql)->result_array();
        //     $query_tagname = $this->db_tpsonline->query($sql)->list_fields();
        //     $COCOKMS.= "<COCOKMS>" ;
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
        //     $COCOKMS.= $header ;
        //     //END BUAT HEADER

        //     //BUAT DETAIL
        //     $this->db_tpsonline->select('NO_CONT,UK_CONT,NO_SEGEL,JNS_CONT,NO_BL_AWB,TGL_BL_AWB,NO_MASTER_BL_AWB,TGL_MASTER_BL_AWB,
        //                             ID_CONSIGNEE,CONSIGNEE,BRUTO,NO_BC11,TGL_BC11,NO_POS_BC11,KD_TIMBUN,KD_DOK_INOUT,NO_DOK_INOUT,
        //                             TGL_DOK_INOUT,WK_INOUT,KD_SAR_ANGKUT_INOUT,NO_POL,FL_CONT_KOSONG,ISO_CODE,PEL_MUAT,
        //                             PEL_TRANSIT,PEL_BONGKAR,GUDANG_TUJUAN,KODE_KANTOR,NO_DAFTAR_PABEAN,TGL_DAFTAR_PABEAN,
        //                             NO_SEGEL_BC,TGL_SEGEL_BC,NO_IJIN_TPS,TGL_IJIN_TPS');
        //     $this->db_tpsonline->where(array('REF_NUMBER' => $STR_REF_NUMBER));
        //     $sql = $this->db_tpsonline->get('tbl_request_plp_in_kemasan');
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
        //     $COCOKMS.= $detil ;
        //     //END BUAT DETAIL

        //     $COCOKMS.= "</COCOKMS>" ;
            

            
        // }

        // $xml_data = '<fStream><![CDATA[<?xml version="1.0" encoding="utf-8"--?==>
        //             <DOCUMENT xmlns="COCOKMS.xsd">
        //                 '.$COCOKMS.'
        //             </DOCUMENT>]]></fStream>';

        // $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => 'COCOKMS_Tes'));
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

        $arraydata = array('' => 'ALL','Y'=> 'SUDAH SINKRON', 'N' => 'BELUM SINKRON');
        $FLAG_WHS = ComboNonDb($arraydata, 'FLAG_WHS', '', 'form-control form-control-sm');

        $arraydata = array('' => 'ALL','Y'=> 'SUDAH KIRIM', 'N' => 'BELUM KIRIM');
        $SENDING = ComboNonDb($arraydata, 'SENDING', '', 'form-control form-control-sm');

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'startdate' => "01-$startdate" ,
            'enddate' => $enddate,
            'FLAG_WHS' => $FLAG_WHS,
            'SENDING' => $SENDING
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_tbl_gatein_lcl(){
        $database = "db_tpsonline";

        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $NO_CONT = $this->input->post('NO_CONT');
        $NO_POS_BC11 = $this->input->post('NO_POS_BC11');
        $NO_DOK_INOUT = $this->input->post('NO_DOK_INOUT');
        $FLAG_WHS = $this->input->post('FLAG_WHS');
        $NO_BL_AWB = $this->input->post('NO_BL_AWB');
        $SENDING = $this->input->post('SENDING');

        $select = ' a.REF_NUMBER,a.KD_DOK,b.jenis_export_import,a.KD_TPS,a.NM_ANGKUT,a.NO_VOY_FLIGHT,a.CALL_SIGN,a.TGL_TIBA,a.KD_GUDANG,
                    a.NO_BL_AWB,a.TGL_BL_AWB,a.NO_MASTER_BL_AWB,a.TGL_MASTER_BL_AWB,a.ID_CONSIGNEE,a.CONSIGNEE,
                    a.BRUTO,a.NO_BC11,a.TGL_BC11,a.NO_POS_BC11,a.CONT_ASAL,a.SERI_KEMAS,a.KODE_KEMAS,a.JML_KEMAS,
                    a.KD_TIMBUN,a.KD_DOK_INOUT,c.jenis_document,a.NO_DOK_INOUT,a.TGL_DOK_INOUT,a.WK_INOUT,a.KD_SAR_ANGKUT_INOUT,d.jenis_angkutan,
                    a.NO_POL,a.PEL_MUAT,a.PEL_TRANSIT,a.PEL_BONGKAR,a.GUDANG_TUJUAN,a.KODE_KANTOR,a.NO_DAFTAR_PABEAN,
                    a.TGL_DAFTAR_PABEAN,a.NO_SEGEL_BC,a.TGL_SEGEL_BC,a.NO_IJIN_TPS,a.TGL_IJIN_TPS,a.ISO_CODE,
                    a.REF_NUMBER_OLD,a.SENDING,a.VALIDATE,a.FLAG_WHS,a.REF_NUMBER_FCL_IN ' ;
        $form = 'tbl_request_plp_in_kemasan a';
        $join = array(
            array('tbl_m_tps_export_import as b' ,'a.KD_DOK = b.id','inner'),
            array('tbl_m_tps_dok_inout as c' ,'a.KD_DOK_INOUT = c.id','inner'),
            array('tbl_m_tps_angkutan as d','a.KD_SAR_ANGKUT_INOUT = d.id','inner'),
            //array('tbl_m_tps_sts_container as e','a.FL_CONT_KOSONG = e.id','inner')
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

        if($FLAG_WHS != ""){
            $tambah_where = array('a.FLAG_WHS' => $FLAG_WHS);
            $where = array_merge($where, $tambah_where);
        }

        if($SENDING != ""){
            $tambah_where = array('a.SENDING' => $SENDING);
            $where = array_merge($where, $tambah_where);
        }

        if($NO_BL_AWB != ""){
            $tambah_where = array('a.NO_BL_AWB' => $NO_BL_AWB);
            $where = array_merge($where, $tambah_where);
        }

        $where_like_and = array();
        if($NO_CONT != ""){
            $tambah_where = array(
                array('field' => 'CONT_ASAL', 'value' => $NO_CONT),
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
            'a.SENDING','a.REF_NUMBER','a.KD_DOK','b.jenis_export_import','a.KD_TPS','a.NM_ANGKUT','a.NO_VOY_FLIGHT','a.CALL_SIGN','a.TGL_TIBA','a.KD_GUDANG',
            'a.NO_BL_AWB','a.TGL_BL_AWB','a.NO_MASTER_BL_AWB','a.TGL_MASTER_BL_AWB','a.ID_CONSIGNEE','a.CONSIGNEE',
            'a.BRUTO','a.NO_BC11','a.TGL_BC11','a.NO_POS_BC11','a.CONT_ASAL','a.SERI_KEMAS','a.KODE_KEMAS','a.JML_KEMAS',
            'a.KD_TIMBUN','a.KD_DOK_INOUT','c.jenis_document','a.NO_DOK_INOUT','a.TGL_DOK_INOUT','a.WK_INOUT','a.KD_SAR_ANGKUT_INOUT','d.jenis_angkutan',
            'a.NO_POL','a.PEL_MUAT','a.PEL_TRANSIT','a.PEL_BONGKAR','a.GUDANG_TUJUAN','a.KODE_KANTOR','a.NO_DAFTAR_PABEAN',
            'a.TGL_DAFTAR_PABEAN','a.NO_SEGEL_BC','a.TGL_SEGEL_BC','a.NO_IJIN_TPS','a.TGL_IJIN_TPS','a.ISO_CODE',
            'a.REF_NUMBER_OLD','a.SENDING','a.VALIDATE','a.FLAG_WHS','a.REF_NUMBER_FCL_IN'
        );
        $column_order = array(
            null, 'a.SENDING','a.REF_NUMBER','a.KD_DOK','b.jenis_export_import','a.KD_TPS','a.NM_ANGKUT','a.NO_VOY_FLIGHT','a.CALL_SIGN','a.TGL_TIBA','a.KD_GUDANG',
            'a.NO_BL_AWB','a.TGL_BL_AWB','a.NO_MASTER_BL_AWB','a.TGL_MASTER_BL_AWB','a.ID_CONSIGNEE','a.CONSIGNEE',
            'a.BRUTO','a.NO_BC11','a.TGL_BC11','a.NO_POS_BC11','a.CONT_ASAL','a.SERI_KEMAS','a.KODE_KEMAS','a.JML_KEMAS',
            'a.KD_TIMBUN','a.KD_DOK_INOUT','c.jenis_document','a.NO_DOK_INOUT','a.TGL_DOK_INOUT','a.WK_INOUT','a.KD_SAR_ANGKUT_INOUT','d.jenis_angkutan',
            'a.NO_POL','a.PEL_MUAT','a.PEL_TRANSIT','a.PEL_BONGKAR','a.GUDANG_TUJUAN','a.KODE_KANTOR','a.NO_DAFTAR_PABEAN',
            'a.TGL_DAFTAR_PABEAN','a.NO_SEGEL_BC','a.TGL_SEGEL_BC','a.NO_IJIN_TPS','a.TGL_IJIN_TPS','a.ISO_CODE',
            'a.REF_NUMBER_OLD','a.SENDING','a.VALIDATE','a.FLAG_WHS','a.REF_NUMBER_FCL_IN'
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

            $row[] = $field->REF_NUMBER ;
            $row[] = $field->KD_DOK ;
            $row[] = $field->jenis_export_import;
            $row[] = $field->KD_TPS ;            
            $row[] = $field->NM_ANGKUT ;
            $row[] = $field->NO_VOY_FLIGHT ;
            $row[] = $field->CALL_SIGN ;
            $row[] = showdate_dmy($field->TGL_TIBA) ;
            $row[] = $field->KD_GUDANG ;
            $row[] = $field->NO_BL_AWB ;
            $row[] = showdate_dmy($field->TGL_BL_AWB) ;
            $row[] = $field->NO_MASTER_BL_AWB ;
            $row[] = showdate_dmy($field->TGL_MASTER_BL_AWB) ;
            $row[] = $field->ID_CONSIGNEE ;
            $row[] = $field->CONSIGNEE ;
            $row[] = $field->BRUTO ;
            $row[] = $field->NO_BC11 ;
            $row[] = showdate_dmy($field->TGL_BC11) ;
            $row[] = $field->NO_POS_BC11 ;
            $row[] = $field->CONT_ASAL ;
            $row[] = $field->SERI_KEMAS ;
            $row[] = $field->KODE_KEMAS ;
            $row[] = $field->JML_KEMAS ;
            $row[] = $field->KD_TIMBUN ;
            $row[] = $field->KD_DOK_INOUT ;
            $row[] = $field->jenis_document ;
            $row[] = $field->NO_DOK_INOUT ;
            $row[] = showdate_dmy($field->TGL_DOK_INOUT) ;
            $row[] = showdate_dmyhis($field->WK_INOUT) ;
            $row[] = $field->KD_SAR_ANGKUT_INOUT ;
            $row[] = $field->jenis_angkutan ;
            $row[] = $field->NO_POL ;
            $row[] = $field->PEL_MUAT ;
            $row[] = $field->PEL_TRANSIT ;
            $row[] = $field->PEL_BONGKAR ;
            $row[] = $field->GUDANG_TUJUAN ;
            $row[] = $field->KODE_KANTOR ;
            $row[] = $field->NO_DAFTAR_PABEAN ;
            $row[] = showdate_dmy($field->TGL_DAFTAR_PABEAN) ;
            $row[] = $field->NO_SEGEL_BC ;
            $row[] = showdate_dmy($field->TGL_SEGEL_BC) ;
            $row[] = $field->NO_IJIN_TPS ;
            $row[] = showdate_dmy($field->TGL_IJIN_TPS) ;
            $row[] = $field->ISO_CODE ;
            $row[] = $field->REF_NUMBER_OLD ;
            $row[] = $field->SENDING ;
            $row[] = $field->VALIDATE ;
            $row[] = $field->FLAG_WHS ;
            $row[] = $field->REF_NUMBER_FCL_IN ;

            
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

        $array_search = $this->m_model->table_tostring('db_tpsonline', '', 'tbl_request_plp_in_kemasan', '', array('REF_NUMBER' => $REF_NUMBER), '');
        $data['array_search'] = $array_search;

        $arraydata = $this->db_tpsonline->query("SELECT id,concat(id,' ~ ',jenis_export_import) 'jenis_export_import' FROM tbl_m_tps_export_import where rec_id=0")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => $array_search['KD_DOK']),
            'attribute' => array('idname' => 'jenis_export_import', 'class' => 'form-control-sm'),
        );
        $data['jenis_export_import'] = ComboDb($createcombo);


        // $arraydata = array('F'=> 'FCL', 'L' => 'LCL');
        // $JNS_CONT = ComboNonDb($arraydata, 'JNS_CONT', $array_search['JNS_CONT'], 'form-control form-control-sm');
        // $data['JNS_CONT'] = $JNS_CONT;


        $arraydata = $this->db_tpsonline->query("SELECT id,concat(id,' ~ ',jenis_document) 'jenis_document' FROM tbl_m_tps_dok_inout where rec_id=0")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => $array_search['KD_DOK_INOUT']),
            'attribute' => array('idname' => 'jenis_document', 'class' => 'form-control-sm'),
        );
        $data['jenis_document'] = ComboDb($createcombo);

        //$arraydata = array('1'=> 'Kosong', '2' => 'Isi');
        //$FL_CONT_KOSONG = ComboNonDb($arraydata, 'FL_CONT_KOSONG', $array_search['FL_CONT_KOSONG'], 'form-control form-control-sm');
        //$data['FL_CONT_KOSONG'] = $FL_CONT_KOSONG;

        $this->load->view('edit',$data);
    }

    function c_update(){
        $database = 'db_tpsonline' ;
        
        $REF_NUMBER = $this->input->post('REF_NUMBER');
        $jenis_export_import = $this->input->post('jenis_export_import');
        //$JNS_CONT = $this->input->post('JNS_CONT');
        $jenis_document = $this->input->post('jenis_document');
        $bruto = $this->input->post('BRUTO');
        $kode_kemas = $this->input->post('KODE_KEMAS');
        $NO_BL_AWB = $this->input->post('NO_BL_AWB');
        $WK_INOUT_DATE = date_db($this->input->post('WK_INOUT_DATE'));
        $WK_INOUT_TIME = $this->input->post('WK_INOUT_TIME');
        $WK_INOUT = $WK_INOUT_DATE." ".$WK_INOUT_TIME ;
        $NO_POS_BC11 = $this->input->post('NO_POS_BC11_EDIT') ;
        $CALL_SIGN = $this->input->post('CALL_SIGN') ;
        $NO_BC11 = $this->input->post('NO_BC11') ;
        $TGL_BC11 = date_db($this->input->post('TGL_BC11')) ;
        $NO_DOK_INOUT = $this->input->post('NO_DOK_INOUT_EDIT') ;


        $where = array(
            'REF_NUMBER' => $REF_NUMBER
        );
  
        $data = array(
            'KD_DOK' => $jenis_export_import,
            //'JNS_CONT' => $JNS_CONT,
            'KD_DOK_INOUT' => $jenis_document,
            'BRUTO' => $bruto,
            'KODE_KEMAS' => $kode_kemas,
            'NO_BL_AWB' => $NO_BL_AWB,
            'WK_INOUT' => $WK_INOUT,
            'NO_POS_BC11' => $NO_POS_BC11,
            'CALL_SIGN' => $CALL_SIGN,
            'NO_BC11' => $NO_BC11,
            'TGL_BC11' => $TGL_BC11,
            'NO_DOK_INOUT' => $NO_DOK_INOUT
        );
        $hasil = $this->m_model->updatedata($database, 'tbl_request_plp_in_kemasan', $data, $where);
        
        if ($hasil >= 1) {
            
            $dataLCLout = array(
                'NO_POS_BC11' => $NO_POS_BC11,
                'CALL_SIGN' => $CALL_SIGN,
                'NO_BC11' => $NO_BC11,
                'TGL_BC11' => $TGL_BC11,
                // 'NO_DOK_INOUT' => $NO_DOK_INOUT
            );

            $WhereOut = array(
                'REF_NUMBER_LCL_IN' => $REF_NUMBER,
                'REF_NUMBER_FCL_IN' => 'INJECTMANUALLCL'
            );

            $hasil2 = $this->m_model->updatedata($database, 'tbl_request_plp_out_kemasan', $dataLCLout, $WhereOut);

            if ($hasil2 >= 1) {
                $pesan_data = array(
                    'msg' => 'Ya',
                    'pesan' => 'Update Data Sukses..',
                    'data' => $data,
                );
            }else{
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Error Update LCL OUT....!!!!',
                    'data' => $data,
                );
                echo json_encode($pesan_data);
                die;
            }



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


        $COCOKMS = "" ;
        for($a=0 ;$a<count($arrREF_NUMBER);$a++){
            $STR_REF_NUMBER = $arrREF_NUMBER[$a];

            //BUAT HEADER
            $this->db_tpsonline->select('KD_DOK,KD_TPS,NM_ANGKUT,NO_VOY_FLIGHT,CALL_SIGN,TGL_TIBA,KD_GUDANG,REF_NUMBER');
            $this->db_tpsonline->where(array('REF_NUMBER' => $STR_REF_NUMBER));
            $sql = $this->db_tpsonline->get('tbl_request_plp_in_kemasan');
            $sql = $this->db_tpsonline->last_query();
            $query_data = $this->db_tpsonline->query($sql)->result_array();
            $query_tagname = $this->db_tpsonline->query($sql)->list_fields();
            $COCOKMS.= "<COCOKMS>" ;
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
            $COCOKMS.= $header ;
            //END BUAT HEADER

            //BUAT DETAIL
            $this->db_tpsonline->select('NO_BL_AWB,TGL_BL_AWB,NO_MASTER_BL_AWB,TGL_MASTER_BL_AWB,ID_CONSIGNEE,CONSIGNEE,
                            BRUTO,NO_BC11,TGL_BC11,NO_POS_BC11,CONT_ASAL,SERI_KEMAS,KODE_KEMAS,JML_KEMAS,
                            KD_TIMBUN,KD_DOK_INOUT,NO_DOK_INOUT,TGL_DOK_INOUT,WK_INOUT,KD_SAR_ANGKUT_INOUT,
                            NO_POL,PEL_MUAT,PEL_TRANSIT,PEL_BONGKAR,GUDANG_TUJUAN,KODE_KANTOR,NO_DAFTAR_PABEAN,
                            TGL_DAFTAR_PABEAN,NO_SEGEL_BC,TGL_SEGEL_BC,NO_IJIN_TPS,TGL_IJIN_TPS');
            $this->db_tpsonline->where(array('REF_NUMBER' => $STR_REF_NUMBER));
            $sql = $this->db_tpsonline->get('tbl_request_plp_in_kemasan');
            $sql = $this->db_tpsonline->last_query();
            $query_data = $this->db_tpsonline->query($sql)->result_array();
            $query_tagname = $this->db_tpsonline->query($sql)->list_fields();
            $detil = "<DETIL><KMS>";
            foreach ($query_data as $row) {
                foreach ($query_tagname as $field) {                        
                    if ($field == "TGL_BL_AWB" || $field == "TGL_MASTER_BL_AWB" || $field == "TGL_BC11" || $field == "TGL_DOK_INOUT" || $field == "TGL_DAFTAR_PABEAN" || $field == "TGL_SEGEL_BC" || $field == "TGL_IJIN_TPS") {
                        $detil.= '<' . $field . '>' . date_ymd($row[$field]) . '</' . $field . '>';
                    } elseif ($field == "WK_INOUT") {
                        $detil.='<' . $field . '>' . date_ymdhis($row[$field]) . '</' . $field . '>';
                    } elseif($field == "KODE_KEMAS"){
                        $detil = $detil . '<KD_KEMAS>' . $row[$field] . '</KD_KEMAS>'; 
                    } else {
                        $detil.= '<' . $field . '>' . $row[$field] . '</' . $field . '>';
                    }
                }
            }
            $detil.= "</KMS></DETIL>";
            $COCOKMS.= $detil ;
            //END BUAT DETAIL

            $COCOKMS.= "</COCOKMS>" ;
            

            
        }

        $xml_data = '<fStream><![CDATA[<?xml version="1.0" encoding="utf-8"?>
                    <DOCUMENT xmlns="cocokms.xsd">
                        '.$COCOKMS.'
                    </DOCUMENT>]]></fStream>';

        if($proses == "live"){
            //LIVE
            $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => 'CoarriCodeco_Kemasan')); 
        }else{
            //TEST SERVICE          
            $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => 'CoCoKms_Tes'));
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
            preg_match_all("#<CoarriCodeco_KemasanResult>(.+?)</CoarriCodeco_KemasanResult>#", $responsebody, $matches);
        }else{
            //TEST SERVICE      
            preg_match_all("#<CoCoKms_TesResult>(.+?)</CoCoKms_TesResult>#", $responsebody, $matches);
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
            $this->m_model->save_response('CoarriCodeco_Kemasan',$xml_param,$responsebody);
        }else{
            $this->m_model->save_response('CoCoKms_TesResult',$xml_param,$responsebody);
        } 


        $pesan_data = array(
            'pesan' => $xmlArr[0],
        );
        echo json_encode($pesan_data);


    }



    function c_sinkron_to_gateinlcl(){
        $array_response = explode(';',$this->input->post('datarespon'));
        $queryku = array();
        for($a=0;$a<count((array) $array_response);$a++){

            $str_trim_data = trim($array_response[$a]) ;

            //dapat data no referensi
            $str_replace_data = str_replace('Proses Berhasil ','',$str_trim_data) ;

            $cek_reff_number = Search_Str_To_Str($str_trim_data,$str_replace_data) ;
            $cek_proses = Search_Str_To_Str($str_trim_data,"Proses Berhasil ") ;

            if($cek_reff_number == 1 &&  $cek_proses == 1){
                $hasil = $this->db_tpsonline->update('tbl_request_plp_in_kemasan',array('SENDING' => 'Y'),array('REF_NUMBER' => explode(' ',$str_replace_data)[1]));
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

        $dataku = $this->db_tpsonline->get_where('tbl_request_plp_in_kemasan',array('REF_NUMBER' => $REF_NUMBER));

        $REF_NUMBER_NEW = "" ;
        $a = 0 ;

        foreach($dataku->result_array() as $detail){
            $GetKD_TPS = $detail['KD_TPS'] ;
            $this->m_model->set_run_number_tpsonline($GetKD_TPS,'LCL','tbl_run_number_tpsonline');
            $where = array('NAME' => 'LCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $GetKD_TPS);

            $get_ref_number = $this->db_tpsonline->get_where('tbl_run_number_tpsonline',
                array('NAME' => 'LCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $GetKD_TPS))->result_array();

            foreach($get_ref_number as $result){                
                $GetYEAR = $result['YEAR'] ;
                $GetMONTH = $result['MONTH'] ;
                $GetNUMBER = $result['NUMBER'] ;
            }

            $this->m_model->updatedata('db_tpsonline','tbl_run_number_tpsonline', array('NUMBER' => $GetNUMBER + 1), $where);
            $GetNUMBER = str_pad($GetNUMBER, 6, "300000", STR_PAD_LEFT);
            $GetDATE = date('m');
            $REF_NUMBER_NEW = $GetKD_TPS . '' . $GetYEAR . '' . $GetMONTH . '' . $GetDATE . '' . $GetNUMBER;

        }
        

        $hasil = $this->db_tpsonline->update('tbl_request_plp_in_kemasan',
                        array('REF_NUMBER' => $REF_NUMBER_NEW,'REF_NUMBER_OLD' => $REF_NUMBER,'VALIDATE' => 'N' ,'SENDING' => 'N'), 
                        array('REF_NUMBER' => $REF_NUMBER) ) ;

        $queryku[$a] = $this->db_tpsonline->last_query();

        if ($hasil >= 1) {
        }else{
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Ganti No REF_NUMBER Gagal...',
                'queryku' => $queryku
            );
            echo json_encode($pesan_data);die;
        }


        $hasil = $this->db_tpsonline->update('tbl_request_plp_out_kemasan',
                        array('REF_NUMBER_LCL_IN' => $REF_NUMBER_NEW), 
                        array('REF_NUMBER_LCL_IN' => $REF_NUMBER) ) ;

        $queryku[$a++] = $this->db_tpsonline->last_query();

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

    }

    function c_sinkron_data(){
        $arrREF_NUMBER = $this->input->post('arrREF_NUMBER');

        $this->db_tpsonline->where_in('REF_NUMBER',$arrREF_NUMBER);
        $this->db_tpsonline->where(array('FLAG_WHS' => 'N','SENDING' => 'N'));
        $getdata = $this->db_tpsonline->get('tbl_request_plp_in_kemasan');

        if($getdata->num_rows() == 0){
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Data Tidak Ditemukan ...!!',
                'arrREF_NUMBER' => $arrREF_NUMBER,
                'query' => $this->db_tpsonline->last_query()
            );
            echo json_encode($pesan_data);
            die;
        }


        foreach($getdata->result_array() as $adata){
            $NO_BL_AWB = $adata['NO_BL_AWB'] ;
            $CONT_ASAL = $adata['CONT_ASAL'] ;




            $query_in_data = " SELECT * from whs_t_in a 
                               INNER JOIN whs_t_in_detail b on a.batch_in=b.batch_in
                               where a.rec_id=0 and b.rec_id=0 and b.bl_no='".$NO_BL_AWB."' and a.cont_no='".$CONT_ASAL."' " ;

            $excute_data = $this->tribltps->query($query_in_data);   


            //jika data sudah ada di input mas budi receiving in
            if($excute_data->num_rows() > 0 ){

                foreach($excute_data->result_array() as $in_whs){
                    $NO_MASTER_BL_AWB = $in_whs['do_no'] ;

                    $TGL_MASTER_BL_AWB = null ;
                    $query_permohonan = " SELECT tgl_master_mbl FROM whs_t_permohonan_head where no_mbl='".$in_whs['do_no']."' " ;
                    $excute_data_permohonan = $this->tribltps->query($query_permohonan);  
                    if($excute_data_permohonan->num_rows() > 0 ){
                        foreach($excute_data_permohonan->result_array() as $inpermohonan){
                            $TGL_MASTER_BL_AWB = $inpermohonan['tgl_master_mbl'] ;
                        }                            
                    }


                    $ID_CONSIGNEE = '-' ;
                    $CONSIGNEE = 'GET CONSIGNEE ERROR' ;
                    $query_consignee = " SELECT consignee_name from whs_m_consignee where consignee_id='".$in_whs['consignee_id']."' and rec_id=0 " ;
                    $excute_data_consignee = $this->tribltps->query($query_consignee);  
                    if($excute_data_consignee->num_rows() > 0 ){
                        foreach($excute_data_consignee->result_array() as $inconsignee){
                            $CONSIGNEE = $inconsignee['consignee_name'] ;
                        } 
                    }


                    $KODE_KEMAS = '' ;
                    $query_category = " SELECT category_kode FROM whs_m_category where rec_id=0 and category_id='".$in_whs['category_id']."' " ;
                    $excute_data_category = $this->tribltps->query($query_category);  
                    if($excute_data_category->num_rows() > 0 ){
                        foreach($excute_data_category->result_array() as $incategory){
                            $KODE_KEMAS = $incategory['category_kode'] ;
                        } 
                    }

                    
                    $KD_TIMBUN = '' ;
                    $query_location = " SELECT location_name from whs_m_location where rec_id=0 and location_id='".$in_whs['location_id']."'  " ;
                    $excute_data_location = $this->tribltps->query($query_location);  
                    if($excute_data_location->num_rows() > 0 ){
                        foreach($excute_data_location->result_array() as $inlocation){
                            $KD_TIMBUN = $inlocation['location_name'] ;
                        } 
                    }

                    $WK_INOUT = date_ymdhis1($in_whs['start_loading']) ;    


                    $NO_POL = '' ;
                    $NO_IJIN_TPS = '' ;
                    $TGL_IJIN_TPS = null ;
                    $query_fcl_in = " SELECT NO_POL,NO_IJIN_TPS,TGL_IJIN_TPS 
                                      from tbl_request_plp_in_container where REF_NUMBER='".$adata['REF_NUMBER_FCL_IN']."' " ;
                    $excute_data_fclin = $this->db_tpsonline->query($query_fcl_in);  
                    if($excute_data_fclin->num_rows() > 0 ){
                        foreach($excute_data_fclin->result_array() as $infcl){
                            $NO_POL = $infcl['NO_POL'] ;
                            $NO_IJIN_TPS = $infcl['NO_IJIN_TPS'] ;
                            $TGL_IJIN_TPS = $infcl['TGL_IJIN_TPS'] ;
                        } 
                    }                  

 

                    $array_update = array(
                        'NO_MASTER_BL_AWB' => $NO_MASTER_BL_AWB,
                        'TGL_MASTER_BL_AWB' => $TGL_MASTER_BL_AWB,
                        'ID_CONSIGNEE' => $ID_CONSIGNEE,
                        'CONSIGNEE' =>  $CONSIGNEE,
                        'BRUTO' => 0,
                        'SERI_KEMAS' => 1,
                        'KODE_KEMAS' => $KODE_KEMAS,
                        'KD_TIMBUN' => $KD_TIMBUN,
                        'WK_INOUT' => $WK_INOUT,
                        'NO_POL' => $NO_POL,
                        'NO_IJIN_TPS' => $NO_IJIN_TPS,
                        'TGL_IJIN_TPS' => $TGL_IJIN_TPS,
                        'FLAG_WHS' => 'Y',
                        'JML_KEMAS' => $in_whs['good_unit'],
                    );




                    $excute_update = $this->m_model->updatedata('db_tpsonline','tbl_request_plp_in_kemasan', $array_update, array('REF_NUMBER' => $adata['REF_NUMBER']));


                    if ($excute_update >= 1) {
                    }else{
                        $pesan_data = array(
                            'msg' => 'Tidak',
                            'pesan' => 'Sinkron Data No REF_NUMBER ini gagal => '.$adata['REF_NUMBER'],
                            'queryku' => $queryku
                        );
                        echo json_encode($pesan_data);die;
                    }

                }


            }else{

                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Data Belum Ada Di Stock Segera Hubungi Bagian Penginputan LCL Gudang...!!',
                    //'arrREF_NUMBER' => $arrREF_NUMBER,
                    //'query' => $this->db_tpsonline->last_query()
                );
                echo json_encode($pesan_data);
                die;
                

            }

        }


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => 'Sinkron Data Berhasil ...',
            'arrREF_NUMBER' => $arrREF_NUMBER,
            'query' => $array_update,
            'excute_update' => $this->db_tpsonline->last_query()
        );
        echo json_encode($pesan_data);
    }

    function c_unsinkron_data(){
        $arrREF_NUMBER = $this->input->post('arrREF_NUMBER');

        $this->db_tpsonline->where_in('REF_NUMBER',$arrREF_NUMBER);
        $this->db_tpsonline->where(array('FLAG_WHS' => 'Y','SENDING' => 'N'));
        $getdata = $this->db_tpsonline->get('tbl_request_plp_in_kemasan');

        if($getdata->num_rows() == 0){
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Data Tidak Ditemukan ...!!',
                'arrREF_NUMBER' => $arrREF_NUMBER,
                'query' => $this->db_tpsonline->last_query()
            );
            echo json_encode($pesan_data);
            die;
        }

        foreach($getdata->result_array() as $adata){
            $excute_update = $this->m_model->updatedata('db_tpsonline','tbl_request_plp_in_kemasan', array('FLAG_WHS' => 'N'), array('REF_NUMBER' => $adata['REF_NUMBER']));

            if ($excute_update >= 1) {
            }else{
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'UnSinkron Data No REF_NUMBER ini gagal => '.$adata['REF_NUMBER'],
                    'queryku' => $queryku
                );
                echo json_encode($pesan_data);die;
            }
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => 'UnSinkron Data Berhasil ...',
            'arrREF_NUMBER' => $arrREF_NUMBER,
            //'query' => $array_update,
            'excute_update' => $this->db_tpsonline->last_query()
        );
        echo json_encode($pesan_data);
    }


    function c_delete_reff_number(){
        $arrREF_NUMBER = $this->input->post('arrREF_NUMBER');

        for($a=0 ;$a<count($arrREF_NUMBER);$a++){
            $STR_REF_NUMBER = $arrREF_NUMBER[$a];

            $hasil = $this->db_tpsonline->update('tbl_request_plp_in_kemasan',
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


    function c_import_gate_in_lcl(){
        $this->load->view('import_gate_in_lcl');
    }


    function c_table_data_in(){

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

        $select = " a.cont_no,a.batch_in,b.bl_no ";
        $form = ' whs_t_in as a';
        $join = array(
            array('whs_t_in_detail as b','a.batch_in=b.batch_in','inner'),
        );
        $where = array('a.rec_id' => 0,'b.rec_id' => 0);

        $where_like = array();        
        $tambah_where = array(
            array('field' => 'a.cont_no', 'value' => $this->input->post('search_on_modal')),
        );
        $where_like = array_merge($where_like, $tambah_where);
        

        $where_term = array();
        $column_order = array(
            'a.cont_no','a.batch_in','b.bl_no'
        );
        $order = array(
            'a.cont_no' => 'asc',
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

        $list = $this->m_model->get_datatables('tribltps', $array_table);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = $field->cont_no;
            $row[] = $field->batch_in;    
            $row[] = $field->bl_no;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_model->count_all('tribltps', $array_table),
            "recordsFiltered" => $this->m_model->count_filtered('tribltps', $array_table),
            "data" => $data,
        );

        echo json_encode($output);
    }

    function c_proses_import_lcl_in(){
        $batch_in = $this->input->post('batch_in');
        $nokontainer = $this->input->post('nokontainer');

        $nokontainer =  substr($nokontainer,0,4).' '.substr($nokontainer,4,11) ;
        

        //ambil data di gate
        $queryGate = " SELECT * from t_t_entry_cont_in where cont_number='".$nokontainer."' ORDER BY cont_date_in desc " ;
        $dataGate = $this->ptmsagate->query($queryGate);

        $NO_POL = "" ;
        $NO_IJIN_TPS = "" ;
        $TGL_IJIN_TPS = "" ;


        if($dataGate->num_rows() == 0){
            $NO_POL = "" ;
        }else{
            foreach($dataGate->result_array() as $dataInGate){
                $NO_POL = $dataInGate['truck_number'] ;
                $NO_IJIN_TPS = $dataInGate['no_eir'] ;
                $TGL_IJIN_TPS = $dataInGate['tgl_eir'] ;
            }
        }
        

        // $arraynya = array(
        //     'dsd' => $nokontainer,
        //     'NO_POL' => $NO_POL,
        //     'NO_IJIN_TPS' => $NO_IJIN_TPS,
        //     'TGL_IJIN_TPS' => $TGL_IJIN_TPS
        // );
        // echo json_encode($arraynya) ;
        // die;

        //end ambil data digate



        $query = " SELECT 5 as 'KD_DOK','MBA0' as 'KD_TPS', c.vessel_name as 'NM_ANGKUT',c.vessel_voyage as 'NO_VOY_FLIGHT', '' as 'CALL_SIGN',  " ;
        $query.= " a.tgl_tiba as 'TGL_TIBA' , 'GMBA' as 'KD_GUDANG', '' as 'REF_NUMBER', b.bl_no as 'NO_BL_AWB', " ;
        $query.= " b.tgl_bl as 'TGL_BL_AWB', a.do_no as 'NO_MASTER_BL_AWB' , NULL as 'TGL_MASTER_BL_AWB', " ;
        $query.= " '' as 'ID_CONSIGNEE' , '' as 'CONSIGNEE' , 0 as 'BRUTO' , '000000' as 'NO_BC11' , " ;
        $query.= " NULL as 'TGL_BC11' , '000000000000' as 'NO_POS_BC11' , cont_no as 'CONT_ASAL', 1 as 'SERI_KEMAS', " ;
        $query.= " d.category_kode as 'KODE_KEMAS', b.good_unit as 'JML_KEMAS', e.location_name as 'KD_TIMBUN',  " ;
        $query.= " 3 as 'KD_DOK_INOUT', '' as 'NO_DOK_INOUT', tgl_in as 'TGL_DOK_INOUT' , " ;
        $query.= " CONCAT(tgl_in,' ',time_in) as 'WK_INOUT' , 1 as 'KD_SAR_ANGKUT_INOUT', " ;
        $query.= " vehicle_no as 'NO_POL' , '' as 'PEL_MUAT' , '' as 'PEL_TRANSIT' , '' as 'PEL_BONGKAR' , " ;
        $query.= " 'GMBA' as 'GUDANG_TUJUAN' , '070100' as 'KODE_KANTOR' , '' as 'NO_DAFTAR_PABEAN' , NULL as 'TGL_DAFTAR_PABEAN' , " ;
        $query.= " '' as 'NO_SEGEL_BC' , NULL as 'TGL_SEGEL_BC' ,'' as 'NO_IJIN_TPS' , NULL as 'TGL_IJIN_TPS' ,'' as 'ISO_CODE' ,'' as 'REF_NUMBER_OLD' , " ;
        $query.= " 'N' as 'SENDING' ,'N' as 'VALIDATE' ,'Y' as 'FLAG_WHS' ,'INJECTMANUALLCL' as 'REF_NUMBER_FCL_IN'  " ;
        $query.= " from whs_t_in a " ;
        $query.= " INNER JOIN whs_t_in_detail b on a.batch_in = b.batch_in " ;
        $query.= " INNER JOIN whs_m_vessel c on a.vessel_id=c.vessel_id " ;
        $query.= " INNER JOIN whs_m_category d on b.category_id=b.category_id " ;
        $query.= " INNER JOIN whs_m_location e on b.location_id=e.location_id " ;
        $query.= " where a.rec_id=0 and b.rec_id=0 and c.rec_id=0 and d.rec_id=0   " ;
        $query.= " and a.batch_in='".$batch_in."' GROUP BY b.bl_no " ;

        $lopdata = $this->tribltps->query($query)->result_array();

        $ArrayGabung = array();
        $ArrayGabungOut = array();

        foreach($lopdata as $dataInLcl){

            //REF NUMBER IN
            $get_ref_number = $this->db_tpsonline->get_where('tbl_run_number_tpsonline',
                array('NAME' => 'LCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $dataInLcl['KD_TPS']))->result_array();
            
            foreach($get_ref_number as $result){                
                $GetYEAR = $result['YEAR'] ;
                $GetMONTH = $result['MONTH'] ;
                $GetNUMBER = $result['NUMBER'] ;
            }

            
            $where = array('NAME' => 'LCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $dataInLcl['KD_TPS']);
            $this->m_model->updatedata('db_tpsonline','tbl_run_number_tpsonline', array('NUMBER' => $GetNUMBER + 1), $where);
            $GetNUMBER = str_pad($GetNUMBER, 6, "300000", STR_PAD_LEFT);
            $GetDATE = date('m');
            $REF_NUMBER = $dataInLcl['KD_TPS'] . '' . $GetYEAR . '' . $GetMONTH . '' . $GetDATE . '' . $GetNUMBER;
            //===========================================================

            //TEMP REF NUMBER OUT
            $this->m_model->set_run_number_tpsonline('TEMP','TEMP','tbl_run_number_tpsonline');
            $get_ref_temp = $this->db_tpsonline->get_where('tbl_run_number_tpsonline',array('NAME' => 'TEMP','KD_TPS' => 'TEMP'))->result_array();

            foreach($get_ref_temp as $result){                
                $GetNUMBERc = $result['NUMBER'] ;
            }

            $GetNUMBERX = str_pad($GetNUMBERc, 8, "00000000", STR_PAD_LEFT);
            $REF_NUMBER_TEMP = 'TEMP-'. $GetNUMBERX;

            $wherec = array('NAME' => 'TEMP','KD_TPS' => 'TEMP');
            $this->m_model->updatedata('db_tpsonline','tbl_run_number_tpsonline', array('NUMBER' => $GetNUMBERc + 1), $wherec);
            //===========================================================




            // $pesan_data = array(
            //     'GetYEAR'   => $GetYEAR,
            //     'GetMONTH'  => $GetMONTH,
            //     'GetNUMBER' => $GetNUMBER,
            //     'REF_NUMBER' => $REF_NUMBER,
            //     'REF_NUMBER_TEMP' => $REF_NUMBER_TEMP
            // );

            // echo json_encode($pesan_data);die;




            $ArrayInsert = array();
            $ArrayInsertOut = array();

            $ArrayInsert = array(
                'KD_DOK'                => $dataInLcl['KD_DOK'],
                'KD_TPS'                => $dataInLcl['KD_TPS'],
                'NM_ANGKUT'             => $dataInLcl['NM_ANGKUT'],
                'NO_VOY_FLIGHT'         => $dataInLcl['NO_VOY_FLIGHT'],
                'CALL_SIGN'             => $dataInLcl['CALL_SIGN'],
                'TGL_TIBA'              => $dataInLcl['TGL_TIBA'],
                'KD_GUDANG'             => $dataInLcl['KD_GUDANG'],
                'REF_NUMBER'            => $REF_NUMBER,
                'NO_BL_AWB'             => $dataInLcl['NO_BL_AWB'],
                'TGL_BL_AWB'            => $dataInLcl['TGL_BL_AWB'],
                'NO_MASTER_BL_AWB'      => $dataInLcl['NO_MASTER_BL_AWB'],
                'TGL_MASTER_BL_AWB'     => $dataInLcl['TGL_MASTER_BL_AWB'],
                'ID_CONSIGNEE'          => $dataInLcl['ID_CONSIGNEE'],
                'CONSIGNEE'             => $dataInLcl['CONSIGNEE'],
                'BRUTO'                 => $dataInLcl['BRUTO'],
                'NO_BC11'               => $dataInLcl['NO_BC11'],
                'TGL_BC11'              => $dataInLcl['TGL_BC11'],
                'NO_POS_BC11'           => $dataInLcl['NO_POS_BC11'],
                'CONT_ASAL'             => $dataInLcl['CONT_ASAL'],
                'SERI_KEMAS'            => $dataInLcl['SERI_KEMAS'],
                'KODE_KEMAS'            => $dataInLcl['KODE_KEMAS'],
                'JML_KEMAS'             => $dataInLcl['JML_KEMAS'],
                'KD_TIMBUN'             => $dataInLcl['KD_TIMBUN'],
                'KD_DOK_INOUT'          => $dataInLcl['KD_DOK_INOUT'],
                'NO_DOK_INOUT'          => $dataInLcl['NO_DOK_INOUT'],
                'TGL_DOK_INOUT'         => $dataInLcl['TGL_DOK_INOUT'],
                'WK_INOUT'              => $dataInLcl['WK_INOUT'],
                'KD_SAR_ANGKUT_INOUT'   => $dataInLcl['KD_SAR_ANGKUT_INOUT'],
                'NO_POL'                => $NO_POL,
                'PEL_MUAT'              => $dataInLcl['PEL_MUAT'],
                'PEL_TRANSIT'           => $dataInLcl['PEL_TRANSIT'],
                'PEL_BONGKAR'           => $dataInLcl['PEL_BONGKAR'],
                'GUDANG_TUJUAN'         => $dataInLcl['GUDANG_TUJUAN'],
                'KODE_KANTOR'           => $dataInLcl['KODE_KANTOR'],
                'NO_DAFTAR_PABEAN'      => $dataInLcl['NO_DAFTAR_PABEAN'],
                'TGL_DAFTAR_PABEAN'     => $dataInLcl['TGL_DAFTAR_PABEAN'],
                'NO_SEGEL_BC'           => $dataInLcl['NO_SEGEL_BC'],
                'TGL_SEGEL_BC'          => $dataInLcl['TGL_SEGEL_BC'],
                'NO_IJIN_TPS'           => $NO_IJIN_TPS,
                'TGL_IJIN_TPS'          => $TGL_IJIN_TPS,
                'ISO_CODE'              => $dataInLcl['ISO_CODE'],
                'REF_NUMBER_OLD'        => $dataInLcl['REF_NUMBER_OLD'],
                'SENDING'               => $dataInLcl['SENDING'],
                'VALIDATE'              => $dataInLcl['VALIDATE'],
                'FLAG_WHS'              => $dataInLcl['FLAG_WHS'],
                'REF_NUMBER_FCL_IN'     => $dataInLcl['REF_NUMBER_FCL_IN'],
            );

            // array_push($ArrayGabung, $ArrayInsert) ;

            // $ArrayInsertOut = $ArrayInsert;
            // $ArrayInsertOut['KD_DOK'] = 6 ;
            // $ArrayInsertOut['KD_DOK_INOUT'] = 1 ;
            // $ArrayInsertOut['REF_NUMBER_FCL_IN'] = 'INJECTMANUALLCL' ;
            // $ArrayInsertOut['REF_NUMBER_LCL_IN'] = $REF_NUMBER ;
            // $ArrayInsertOut['FLAG_WHS'] = 'Y' ;
            // $ArrayInsertOut['REF_NUMBER'] = $REF_NUMBER_TEMP ;

            // array_push($ArrayGabungOut, $ArrayInsertOut) ;


            $cekInLCL = $this->db_tpsonline->get_where('tbl_request_plp_in_kemasan',array('NO_BL_AWB' => $dataInLcl['NO_BL_AWB'],'SENDING !=' => 'D'))->num_rows() ;

            if($cekInLCL == 0){
                array_push($ArrayGabung, $ArrayInsert) ;
            }


            $cekOutLCL = $this->db_tpsonline->get_where('tbl_request_plp_out_kemasan',array('NO_BL_AWB' => $dataInLcl['NO_BL_AWB'],'SENDING !=' => 'D'))->num_rows() ;

            if($cekOutLCL == 0){

                

                $ArrayInsertOut = $ArrayInsert;
                $ArrayInsertOut['KD_DOK'] = 6 ;
                $ArrayInsertOut['KD_DOK_INOUT'] = 1 ;
                $ArrayInsertOut['REF_NUMBER_FCL_IN'] = 'INJECTMANUALLCL' ;
                $ArrayInsertOut['REF_NUMBER_LCL_IN'] = $REF_NUMBER ;
                $ArrayInsertOut['FLAG_WHS'] = 'Y' ;
                $ArrayInsertOut['REF_NUMBER'] = $REF_NUMBER_TEMP ;

                array_push($ArrayGabungOut, $ArrayInsertOut) ;

            }
            
        }


        // $pesan_data = array(
        //     'ArrayGabung' => $ArrayGabung,
        //     'ArrayGabungOut' => $ArrayGabungOut,
        // );

        // echo json_encode($pesan_data);


        

        $hasil = $this->db_tpsonline->insert_batch('tbl_request_plp_in_kemasan', $ArrayGabung);

        if ($hasil >= 1) {

            $hasil2 = $this->db_tpsonline->insert_batch('tbl_request_plp_out_kemasan', $ArrayGabungOut);

            if($hasil2 >= 1){
                $pesan_data = array(
                    'sqlquery' => $this->tribltps->last_query(),
                    'sqlqueryinject' => $this->db_tpsonline->last_query(),
                    'lopdata' => $lopdata,
                    'ArrayGabung' => $ArrayGabung,
                    'ArrayGabungOut' => $ArrayGabungOut,
                    'msg' => 'Ya',
                    'pesan' => 'Import Data Berhasil...'
                );

                echo json_encode($pesan_data);
            }else{
                $pesan_data = array('msg' => 'Tidak','pesan' => 'Import Data Gagal di LCL Out TPSONLINE ....!!!!','query' => $this->db_tpsonline->last_query());
                echo json_encode($pesan_data);die;
            }

                

        } else {
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Import Data Gagal ....!!!!','query' => $this->db_tpsonline->last_query());
            echo json_encode($pesan_data);die;
        }

            


    }


    function c_exportxls() {

        
        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);

        $startdate = $data[0] ;
        $enddate = $data[1] ;
        $NO_POS_BC11 = $data[2] ;
        $NO_CONT = $data[3] ;
        $NO_DOK_INOUT = $data[4] ;
        $SENDING = $data[5] ;
        $NO_BL_AWB = $data[6] ;
        $FLAG_WHS = $data[7] ;

        $nm = "" ;
        if($SENDING == ""){
            $nm = "All" ;
        }else if($SENDING == "Y"){
            $nm = "Sudah_Kirim" ;
        }else{
            $nm = "Belum_Kirim" ;
        }
        
        $nama_excel = "GateInLCL_".$nm."_".tanggal_sekarang() ;


        $query = " SELECT a.REF_NUMBER, a.KD_DOK, b.jenis_export_import, a.KD_TPS, a.NM_ANGKUT, " ;
        $query.= " a.NO_VOY_FLIGHT, a.CALL_SIGN, date_format(a.TGL_TIBA,'%d-%m-%Y') 'TGL_TIBA', a.KD_GUDANG, a.NO_BL_AWB, date_format(a.TGL_BL_AWB,'%d-%m-%Y') 'TGL_BL_AWB', " ;
        $query.= " a.NO_MASTER_BL_AWB, date_format(a.TGL_MASTER_BL_AWB,'%d-%m-%Y') 'TGL_MASTER_BL_AWB', a.ID_CONSIGNEE, a.CONSIGNEE, a.BRUTO, " ;
        $query.= " a.NO_BC11, date_format(a.TGL_BC11,'%d-%m-%Y') 'TGL_BC11', a.NO_POS_BC11, a.CONT_ASAL, a.SERI_KEMAS, a.KODE_KEMAS, " ;
        $query.= " a.JML_KEMAS, a.KD_TIMBUN, a.KD_DOK_INOUT, c.jenis_document, a.NO_DOK_INOUT, " ;
        $query.= " date_format(a.TGL_DOK_INOUT,'%d-%m-%Y') 'TGL_DOK_INOUT',date_format(a.WK_INOUT,'%d-%m-%Y %H:%i') 'WK_INOUT', a.KD_SAR_ANGKUT_INOUT, d.jenis_angkutan, " ;
        $query.= " a.NO_POL, a.PEL_MUAT, a.PEL_TRANSIT, a.PEL_BONGKAR, a.GUDANG_TUJUAN, " ;
        $query.= " a.KODE_KANTOR, a.NO_DAFTAR_PABEAN, date_format(a.TGL_DAFTAR_PABEAN,'%d-%m-%Y') 'TGL_DAFTAR_PABEAN', a.NO_SEGEL_BC, " ;
        $query.= " date_format(a.TGL_SEGEL_BC,'%d-%m-%Y') 'TGL_SEGEL_BC', a.NO_IJIN_TPS, date_format(a.TGL_IJIN_TPS,'%d-%m-%Y') 'TGL_IJIN_TPS', a.ISO_CODE, a.REF_NUMBER_OLD, " ;
        $query.= " a.SENDING, a.VALIDATE, a.FLAG_WHS, a.REF_NUMBER_FCL_IN " ;
        $query.= " FROM tbl_request_plp_in_kemasan a " ;
        $query.= " INNER JOIN tbl_m_tps_export_import as b ON a.KD_DOK = b.id " ;
        $query.= " INNER JOIN tbl_m_tps_dok_inout as c ON a.KD_DOK_INOUT = c.id " ;
        $query.= " INNER JOIN tbl_m_tps_angkutan as d ON a.KD_SAR_ANGKUT_INOUT = d.id " ;
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

        if($NO_BL_AWB != ""){
            $query.= " and a.NO_BL_AWB like'%".$NO_BL_AWB."%' " ;
        }

        if($FLAG_WHS == ""){
            $query.= " AND a.FLAG_WHS IN('Y', 'N') " ;
        }else{            
            $query.= " and a.FLAG_WHS ='".$FLAG_WHS."' " ;
        }

        
        $query.= " ORDER BY a.REF_NUMBER ASC " ; 

        $data1 = $this->db_tpsonline->query($query)->result_array();
        

        


        //Setting Sheet Excel
        $nama_sheet = array(
            '0' => 'LCL Gate In',
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


}


