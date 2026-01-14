<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\XmlMiddleware;

class C_GetResponPLP_Tujuan extends CI_Controller {

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


        // $this->load->library('ciqrcode');

        // $params['data'] = 'This is a text to encode become QR Code';
        // $params['level'] = 'H';
        // $params['size'] = 10;
        // $params['savename'] = FCPATH.'assets/image/qrcode/tes.png';
        // $this->ciqrcode->generate($params);

        // echo '<img src="'.base_url().'assets/image/qrcode/tes.png" />';

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

        $startdate = date('d-m-Y') ;
        $enddate = date('d-m-Y') ;

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'GUDANG_TUJUAN' => $GUDANG_TUJUAN,
            'startdate' => "$startdate" ,
            'enddate' => $enddate,
        );
        $this->load->view('dashboard/index', $data);
    }

    


    function c_tbl_petikemas_header(){
        $database = "db_tpsonline";

        $GUDANG_TUJUAN = $this->input->post('GUDANG_TUJUAN');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $NO_CONT = $this->input->post('NO_CONT');

        $select = 'x.ID,x.KD_KANTOR,x.KD_TPS_ASAL,x.KD_TPS_TUJUAN,x.REF_NUMBER,x.GUDANG_ASAL,x.GUDANG_TUJUAN,x.NO_PLP,
        x.TGL_PLP,x.ALASAN_REJECT,x.CALL_SIGN,x.NM_ANGKUT,x.NO_VOY_FLIGHT,x.TGL_TIBA,x.NO_BC11,x.TGL_BC11,
        x.NO_SURAT,x.TGL_SURAT,x.FLAG_TRANSFER,y.NO_CONT,y.UK_CONT,y.JNS_CONT,y.NO_POS_BC11,y.CONSIGNEE';
        $form = 'tbl_respon_plp_petikemas x';
        

        $join = array(
            array('tbl_respon_plp_petikemas_detail as y','x.ID = y.ID','inner')
        );

        $where = array('x.ACTIVE' => 0);

        if($GUDANG_TUJUAN != ""){
            $tambah_where = array('x.GUDANG_TUJUAN' => $GUDANG_TUJUAN);
            $where = array_merge($where, $tambah_where);
        }

        if($startdate != ""){
            $tambah_where = array('date_format(x.TGL_PLP,"%Y-%m-%d") >=' => date_db($startdate));
            $where = array_merge($where, $tambah_where);
        }

        if($enddate != ""){
            $tambah_where = array('date_format(x.TGL_PLP,"%Y-%m-%d") <=' => date_db($enddate));
            $where = array_merge($where, $tambah_where);
        }

        if($NO_CONT != ""){
            $tambah_where = array('y.NO_CONT' => $NO_CONT);
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

            //$text = "" ;

            if($field->FLAG_TRANSFER == 1){
                if($field->GUDANG_TUJUAN == "CMBA"){
                    $row[] = " <a class='btn btn-primary boxshadow' title='Data Sudah Sukses di Transfer Ke Transaksi FCL ...'> 
                    <span class='icon-thumbs-up1' style='color:white'></span></a> " ;
                }else{
                    $row[] = " <a class='btn btn-primary boxshadow' title='Data Sudah Sukses di Transfer Ke Transaksi LCL ...'> 
                    <span class='icon-thumbs-up1' style='color:white'></span></a> " ;
                }
            }else{

                if($field->GUDANG_TUJUAN == "CMBA"){
                    $row[] = " <a class='btn btn-primary boxshadow' href='javascript:void(0)' title='Transfer' onclick='transfer_fcl(".'"'.$field->ID.'"'.")'> 
                    <span class='icon-share1' style='color:white'></span></a> " ;
                }else{
                    $row[] = " <a class='btn btn-primary boxshadow' href='javascript:void(0)' title='Transfer' onclick='transfer_lcl(".'"'.$field->ID.'"'.")'> 
                    <span class='icon-share1' style='color:white'></span></a> " ;
                }
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
            // $row[] = "<div align='center'><input type='checkbox' id='idreffnumber$no' class='chkreffnumber' 
            //             onclick='HandleClick(this.id,".'"'.$field->ID.'"'.");' value='".$field->ID."'></div>"; 

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
        $form = 'tbl_respon_plp_petikemas_detail';
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
        $Kd_asp = $this->input->post('Kd_asp') ;


        $id_api = $this->m_model->select_max_where('db_tpsonline', 'tbl_xml_webservice', 'id_api') ;

        $format_xml = $this->m_model->getvalue('db_tpsonline','format_xml','tbl_function_webservice',array('nama_function' => $nama_function));

        $xml_param = replace_xml_condition('UserName','string',$Username,$format_xml);
        $xml_param = replace_xml_condition('Password','string',$Password,$xml_param);
        $xml_param = replace_xml_condition('Kd_asp','string',$Kd_asp,$xml_param);



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
        
        //$id_api = 6601 ;
        $ID = $this->m_model->select_max_where('db_tpsonline','tbl_respon_plp_petikemas', 'ID');

        $hasil_response = '' ;
        //$this->db_tpsonline->select('hasil_response');
        $this->db_tpsonline->select("REPLACE(hasil_response,'\n',' ') as 'hasil_response'");
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
    preg_match_all("#<GetResponPLP_TujuanResult>(.+?)</GetResponPLP_TujuanResult>#", $str_respon, $matchesx);
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

$count_array_header = count ((array) array_keys($data_header)) ;
$count_array_detail = count ((array) array_keys($data_detail)) ;

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

$hasil = $this->db_tpsonline->insert('tbl_respon_plp_petikemas', $newarray);

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

            if($tag_value == "NO_HOST_BL"){
                $tag_value = 'NO_BL_AWB';
            }else if($tag_value == "TGL_HOST_BL"){
                $tag_value = 'TGL_BL_AWB';
            }


            $newarray = array_merge($newarray,array($tag_value => $value));
        }
        $newarray = array_merge($newarray,array('CREATED_BY' => $this->session->userdata('autogate_username'))) ;   
        $newarray = array_merge($newarray,array('CREATED_ON' => tanggal_sekarang())) ;  
        $newarray = array_merge($newarray,array('ID' => $ID)) ;  

                // print("<pre>".print_r($newarray,true)."</pre>"); 
                // die;

        array_push($savedata,$newarray);
    }

    $hasil = $this->db_tpsonline->insert_batch('tbl_respon_plp_petikemas_detail', $savedata);

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

function c_transfer_fcl(){

    $ID = $this->input->post('ID');

    $cont_date_in = date_db(tanggal_sekarang()) ;
    $cont_time_in = jam_sekarang();

    $transfer_gate_in = $this->transfer_gate_in($ID,$cont_date_in,$cont_time_in);
    if($transfer_gate_in != "Ya"){
        $pesan_data = array('msg' => 'Tidak','pesan' => 'Ada Kesalahan di function transfer_gate_in ...!');
        echo json_encode($pesan_data); die;
    }

    $transfer_ops_in = $this->transfer_ops_in($ID,$cont_date_in,$cont_time_in);
    if($transfer_ops_in != "Ya"){
        $pesan_data = array('msg' => 'Tidak','pesan' => 'Ada Kesalahan di function transfer_ops_in ...!');
        echo json_encode($pesan_data); die;
    }

    $transfer_fcl_in = $this->transfer_fcl_in($ID,$cont_date_in,$cont_time_in);
    if($transfer_fcl_in != "Ya"){
        $pesan_data = array('msg' => 'Tidak','pesan' => 'Ada Kesalahan di function transfer_fcl_in ...!');
        echo json_encode($pesan_data); die;
    }

    $this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas',array('FLAG_TRANSFER' => 1),array('ID' => $ID));

    $pesan_data = array(
        'msg' => 'Ya',
        'pesan' => 'Transfer Data Sukses ...!!',
    );
    echo json_encode($pesan_data);
}




function transfer_gate_in($ID,$cont_date_in,$cont_time_in){

    $where = array('ACTIVE' => 0,'FLAG_TRANSFER' => 0,'ID' => $ID,'GUDANG_TUJUAN' => 'CMBA');

        //print("<pre>".print_r($where,true)."</pre>"); 

    $data_header = $this->db_tpsonline->get_where('tbl_respon_plp_petikemas',$where);
    if($data_header->num_rows() == 0){ return "Data Header Respon Tidak Ditemukan...!!"; }

    $where = array('ACTIVE' => 0,'ID' => $ID);
    $this->db_tpsonline->order_by('ID,NO_POS_BC11,NO_CONT');
    $this->db_tpsonline->group_by('NO_CONT');
    $data_detail = $this->db_tpsonline->get_where('tbl_respon_plp_petikemas_detail',$where);
    if($data_detail->num_rows() == 0){ return "Data Detail Respon Tidak Ditemukan...!!"; }

    $vessel = '' ;
    $GUDANG_ASAL = "" ;
    $GUDANG_TUJUAN = "" ;
    foreach($data_header->result_array() as $header){
        $vessel = $header['NM_ANGKUT'].' '.$header['NO_VOY_FLIGHT'] ;
        $GUDANG_ASAL = $header['GUDANG_ASAL'] ;
        $GUDANG_TUJUAN = $header['GUDANG_TUJUAN'] ;
    }

    $code_principal =  "" ;
    $name_principal = "" ;
    if(trim($GUDANG_TUJUAN) == "CMBA"){
        $code_principal = "TPS" ;
        $name_principal = "T P SEMENTARA" ;
    }else if(trim($GUDANG_TUJUAN) == "GMBA" && trim($GUDANG_ASAL) == "CTPS"){
        $code_principal = "LCL" ;
        $name_principal = "TPS-LCL" ;
    }else if(trim($GUDANG_TUJUAN) == "GMBA" && trim($GUDANG_ASAL) == "CTTL"){
        $code_principal = "PJT" ;
        $name_principal = "PERUSAHAAN JASA TITIPAN" ;
    }else{
        $code_principal = "TPS" ;
        $name_principal = "T P SEMENTARA" ;
    }

        //$show_array = array();
    foreach($data_detail->result_array() as $detail){
        $ID_DET = $detail['ID_DET'] ;

        $cont_number =  substr($detail['NO_CONT'],0,4).' '.substr($detail['NO_CONT'],4,11) ;

        $reff_code = ($detail['UK_CONT'] == "20") ? '2DS' : '4DS' ;
        $reff_description = ($detail['UK_CONT'] == "20") ? '20ft D.S' : '40ft D.S' ;
            //$cont_status = ($detail['JNS_CONT'] == "F") ? 'Full' : 'Empty' ;
        $cont_status = 'Full' ;
        $id_cont_in = $this->m_model->id_in() ;

        $bon_bongkar_number = $this->m_model->bon_bongkar_number() ;
        $eir_in = $this->m_model->eir_r_number() ;


        $data = array(
            'id_cont_in' => $id_cont_in,
            'bon_bongkar_number' => $bon_bongkar_number,
            'eir_in' => $eir_in,
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'cont_number' => $cont_number,
            'dangers_goods' => 'No',
            'vessel' => $vessel,
            'shipper' => '',
            'truck_number' => '',
            'driver_name' => '',
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'cont_condition' => 'AV',
            'new_cont_condition' => 'AV',
            'cont_status' => $cont_status,
            'new_cont_status' => $cont_status,
            'cont_date_in' => $cont_date_in,
            'cont_time_in' => $cont_time_in,
            'block_loc' => '.',
            'location' => '.. .. .. ..',
            'ship_line_code' => '.',
            'ship_line_name' => '.',
            'bc_code' => '',
            'bc_name' => '',
            'invoice_in' => '.',
            'plate' => '.',
            'clean_type' => '.',
            'clean_date' => null,
            'notes' => '.',
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
            'rec_id' => 0,
            'bruto' => 0,
            'seal_number' => '',
            'no_eir' => '',
            'tgl_eir' => null,
        );

        $hasil = $this->ptmsagate->insert('t_t_entry_cont_in', $data);
        if ($hasil >= 1) {
        }else{
            return "Transaction to t_t_entry_cont_in Error" ;
            die;
        }
            //array_push($show_array,$data) ;

        $data = array(
            'id_cont_in' => $id_cont_in,
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'cont_number' => $cont_number,
            'dangers_goods' => 'No',
            'vessel' => $vessel,
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'cont_condition' => 'AV',
            'cont_status' => $cont_status,
            'cont_date_in' => $cont_date_in,
            'cont_time_in' => $cont_time_in,
            'bon_bongkar_number' => $bon_bongkar_number,
            'block_loc' => '.',
            'location' => '.. .. .. ..',
            'ship_line_code' => '.',
            'ship_line_name' => '.',
            'bc_code' => '',
            'notes' => '.',
            'invoice_in' => '.',
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
            'rec_id' => 0,
            'seal_number' => '',
            'no_eir' => '',
            'tgl_eir' => null,
            'bruto' => 0,
        );

        $hasil = $this->ptmsagate->insert('t_t_stock', $data);
        if ($hasil >= 1) {
        }else{
            return "Transaction to t_t_stock Error" ;
            die;
        }

        $data = array(
            'eir_type' => 'I',
            'eir_number' => $eir_in,
            'bon_bongkar_number' => $bon_bongkar_number,
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'cont_number' => $cont_number,
            'vessel' => $vessel,
            'shipper'=> '',
            'truck_number' => '',
            'driver_name' => '',
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'cont_condition' => 'AV',
            'cont_status' => $cont_status,
            'cont_date_in' => $cont_date_in,
            'cont_time_in' => $cont_time_in,
            'seal_number'=> '',
            'block_loc' => '.',
            'location' => '.. .. .. ..',
            'notes' => '.',
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
            'rec_id' => 0,
            'no_eir' => '',
            'tgl_eir' => null,
            'bruto' => 0,
        );
        $hasil = $this->ptmsagate->insert('t_eir', $data);

        if ($hasil >= 1) {
        }else{
            return "Transaction to t_eir Error" ;
            die;
        }

        $update_no_eir_in = $this->m_model->update_eir_r_number();

        $this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas_detail',array('ID_CONT_IN' => $id_cont_in),array('ID_DET' => $ID_DET));

    }

    return "Ya" ;

}

function transfer_ops_in($ID,$cont_date_in,$cont_time_in){

    $T_In_ID = $this->m_model->select_max_where('mbatps','tps_t_plp', 'T_In_ID');
    $T_In_Detail_ID = $this->m_model->select_max_where('mbatps','tps_t_plp_detail', 'T_In_Detail_ID');

    $where = array('a.ACTIVE' => 0,'a.FLAG_TRANSFER' => 0,'a.ID' => $ID, 'b.ACTIVE' => 0,'a.GUDANG_TUJUAN' => 'CMBA');
    $this->db_tpsonline->select('a.*,b.*');
    $this->db_tpsonline->from('tbl_respon_plp_petikemas as a');
    $this->db_tpsonline->join('tbl_respon_plp_petikemas_detail as b','a.ID = b.ID','inner');
    $this->db_tpsonline->where($where);
    $this->db_tpsonline->group_by('b.NO_CONT');
    $data_detail = $this->db_tpsonline->get();
    if($data_detail->num_rows() == 0){ return "Data Tidak Ditemukan...!!"; }

        //$show_array = array();
    $party = 0 ;
    foreach($data_detail->result_array() as $detail){
        $party++;

        $ID_DET = $detail['ID_DET'] ;
        $NoKontainer =  substr($detail['NO_CONT'],0,4).' '.substr($detail['NO_CONT'],4,11) ;
        $KdCtr = ($detail['UK_CONT'] == "20") ? '2DS' : '4DS' ;
        $TglTiba = $detail['TGL_TIBA'] ;
        $NoPLP = $detail['NO_PLP'] ;
        $TglPLP = date_db($detail['TGL_PLP']) ;
        $NoSuratPLP = $detail['NO_SURAT'] ;
        $TglSuratPLP = date_db($detail['TGL_SURAT']) ;
        $NoBL = $detail['NO_BL_AWB'] ;
        $TglBL = date_db($detail['TGL_BL_AWB']) ; 
        $consignee = $detail['CONSIGNEE'] ;

        if ($detail['KD_TPS_ASAL'] == 'TPS0') {
            $kdterminal = 8;
        } else if ($detail['KD_TPS_ASAL'] == 'TTL0') {
            $kdterminal = 9;
        } else {
            $kdterminal = 1000;
        }

        $vessel = $detail['NM_ANGKUT'].' '.$detail['NO_VOY_FLIGHT'] ;
        $nobc = $detail['NO_BC11'] ;
        $tglbc = date_db($detail['TGL_BC11']) ;
        $nopos = $detail['NO_POS_BC11'] ;
        $callsign = $detail['CALL_SIGN'] ;

        $code_principal =  "" ;
        if(trim($detail['GUDANG_TUJUAN']) == "CMBA"){
            $code_principal = "TPS" ;
        }else if(trim($detail['GUDANG_TUJUAN']) == "GMBA" && trim($detail['GUDANG_ASAL']) == "CTPS"){
            $code_principal = "LCL" ;
        }else if(trim($detail['GUDANG_TUJUAN']) == "GMBA" && trim($detail['GUDANG_ASAL']) == "CTTL"){
            $code_principal = "PJT" ;
        }else{
            $code_principal = "TPS" ;
        }


        $data_det = array(
            'T_In_Detail_ID'    => $T_In_Detail_ID,
            'T_In_ID'           => $T_In_ID,
            'NoKontainer'       => $NoKontainer,
            'KdCtr'             => $KdCtr,
            'Status'            => 'K',
            'SealNumber'        => '',
            'Tipe_Cargo'        => 'C',
            'TglTiba'           => $TglTiba,
            'TglMasuk'          => $cont_date_in,
            'JamMasuk'          => $cont_time_in,
            'Category'          => 'B',
            'Location'          => '. .. .. ..',
            'CatLoc'            => 'Y',
            'Principal'         => $code_principal,
            'NoPLP'             => $NoPLP,
            'TglPLP'            => $TglPLP,
            'NoSuratPLP'        => $NoSuratPLP,
            'TglSuratPLP'       => $TglSuratPLP,
            'flag_segel'        => 0,
            'NoSegel'           => '',
            'Keterangan'        => '-',
            'flag_segel_CEK'    => 0,
            'TglSegel_CEK'      => null,
            'Bahandle'          => '',
            'TglBahandle'       => null,
            'LocationBahandle'  => '',
            'NoJob'             => '',
            'RecID'             => 0,
        );

        $hasil = $this->mbatps->insert('tps_t_plp_detail', $data_det);
        if ($hasil >= 1) {
        }else{
            return "Transaction to tps_t_plp_detail Error" ;
            die;
        }

        $this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas_detail',array('T_IN_ID' => $T_In_ID),array('ID_DET' => $ID_DET));
        $this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas_detail',array('T_IN_DETAIL_ID' => $T_In_Detail_ID),array('ID_DET' => $ID_DET));


        $this->mbatps->query("insert into tps_t_plp_detail_gate_status (T_In_Detail_ID,
            No_pos,No_bc,NoKontainer,FlagStatus,Created_On,Created_By,TglMasuk)
            values ('".$T_In_Detail_ID."','".$nopos."','".$nobc."','".$NoKontainer."','1',
            '".tanggal_sekarang()."','".$this->session->userdata('autogate_username')."','".$cont_date_in."') ");


        $this->mbatps->query("insert into  tps_t_plp_detail_status(T_In_Detail_ID,T_In_Detail_ID_SUB,NoKontainer,FlagStatus,Created_On,Created_By) 
            values ('".$T_In_Detail_ID."','1','".$NoKontainer."','1','".tanggal_sekarang()."','AutomatedBySystem') ");




            //array_push($show_array,$data_det) ;
        $T_In_Detail_ID++;
    }

    $save_head = array(
        'T_In_ID'               => $T_In_ID,
        'NoBL'                  => $NoBL,
        'TglBL'                 => $TglBL,
        'Consignee'             => $consignee,
        'KdTerminal'            => $kdterminal,
        'Vessel'                => $vessel,
        'Shipper'               => NULL,
        'Party'                 => $party,
        'InvTerminal'           => NULL,
        'TglInvTerminal'        => NULL,
        'BiayaTerminal'         => 0,
        'BiayaLainTerminal'     => 0,
        'TotalBiayaTerminal'    => 0,
        'Sisa_Biaya_Terminal'   => 0,
        'FlagInvTerminal'       => NULL,
        'FlagBiayaTerminal'     => NULL,
        'KetInvTerminal'        => NULL,
        'CreatedOn'             => tanggal_sekarang(),
        'CreatedBy'             => $this->session->userdata('autogate_username'),
        'RecID'                 => 0,
        'NoBC1'                 => $nobc,
        'TglBC1'                => $tglbc,
        'No_Pos'                => $nopos,            
        'CallSign'              => $callsign,
        'NoBA'                  => '',
        'TglBA'                 => null,
    );

    $hasil = $this->mbatps->insert('tps_t_plp', $save_head);
    if ($hasil >= 1) {
    }else{
        return "Transaction to tps_t_plp Error" ;
        die;
    }



        //array_push($show_array,$save_head) ;

    return 'Ya' ;
        //return $show_array;
}

function transfer_fcl_in($ID,$cont_date_in,$cont_time_in){
    $where = array('a.ACTIVE' => 0,'a.FLAG_TRANSFER' => 0,'a.ID' => $ID, 'b.ACTIVE' => 0,'a.GUDANG_TUJUAN' => 'CMBA');
    $this->db_tpsonline->select('a.*,b.*');
    $this->db_tpsonline->from('tbl_respon_plp_petikemas as a');
    $this->db_tpsonline->join('tbl_respon_plp_petikemas_detail as b','a.ID = b.ID','inner');
    $this->db_tpsonline->where($where);
    $this->db_tpsonline->group_by('b.NO_CONT');
    $data_detail = $this->db_tpsonline->get();

    if($data_detail->num_rows() == 0){ return "Data Tidak Ditemukan...!!"; }



        //$show_array = array();
    foreach($data_detail->result_array() as $detail){
        $ID_DET = $detail['ID_DET'] ;
        $GetKD_TPS = $detail['KD_TPS_TUJUAN'] ;
        $this->m_model->set_run_number_tpsonline($GetKD_TPS,'FCL','tbl_run_number_tpsonline');
        $where = array('NAME' => 'FCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $detail['KD_TPS_TUJUAN']);
        $get_ref_number = $this->db_tpsonline->get_where('tbl_run_number_tpsonline',
            array('NAME' => 'FCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $detail['KD_TPS_TUJUAN']))->result_array();

        foreach($get_ref_number as $result){                
            $GetYEAR = $result['YEAR'] ;
            $GetMONTH = $result['MONTH'] ;
            $GetNUMBER = $result['NUMBER'] ;
        }

        $this->m_model->updatedata('db_tpsonline','tbl_run_number_tpsonline', array('NUMBER' => $GetNUMBER + 1), $where);
        $GetNUMBER = str_pad($GetNUMBER, 6, "200000", STR_PAD_LEFT);
        $GetDATE = date('m');
        $REF_NUMBER = $GetKD_TPS . '' . $GetYEAR . '' . $GetMONTH . '' . $GetDATE . '' . $GetNUMBER;

        $data = array(
            'KD_DOK' => 5,
            'KD_TPS' => $detail['KD_TPS_TUJUAN'],
            'NM_ANGKUT' => $detail['NM_ANGKUT'],
            'NO_VOY_FLIGHT' => $detail['NO_VOY_FLIGHT'],
            'CALL_SIGN' => $detail['CALL_SIGN'],
            'TGL_TIBA' => $detail['TGL_TIBA'],
            'KD_GUDANG' => $detail['GUDANG_TUJUAN'],
            'REF_NUMBER' => $REF_NUMBER,
            'NO_CONT' => $detail['NO_CONT'],
            'UK_CONT' => $detail['UK_CONT'],
                'NO_SEGEL' => '', //ini di input pada saat gate ini
                'JNS_CONT' => $detail['JNS_CONT'],
                'NO_BL_AWB' => $detail['NO_BL_AWB'],
                'TGL_BL_AWB' => $detail['TGL_BL_AWB'],
                'NO_MASTER_BL_AWB' => '',
                'TGL_MASTER_BL_AWB' => null,
                'ID_CONSIGNEE' => '', 
                'CONSIGNEE' => '',
                'BRUTO' => '',  //ini di input pada saat gate ini
                'NO_BC11' => $detail['NO_BC11'],
                'TGL_BC11' => $detail['TGL_BC11'],
                'NO_POS_BC11' => $detail['NO_POS_BC11'],
                'KD_TIMBUN' => '',  //ini di input pada saat gate ini
                'KD_DOK_INOUT' => 3,
                'NO_DOK_INOUT' => $detail['NO_SURAT'],
                'TGL_DOK_INOUT' => $detail['TGL_SURAT'],
                'WK_INOUT' => $cont_date_in.' '.$cont_time_in,
                'KD_SAR_ANGKUT_INOUT' => 1,
                'NO_POL' => '',  //ini di input pada saat gate ini
                'FL_CONT_KOSONG' => 2,
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
                'NO_IJIN_TPS' => '', //ini di input pada saat gate ini
                'TGL_IJIN_TPS' => null, //ini di input pada saat gate ini
            );

        $hasil = $this->db_tpsonline->insert('tbl_request_plp_in_container', $data);
        if ($hasil >= 1) {
        }else{
            return "Transaction to tbl_request_plp_in_container Error" ;
            die;
        }

        $this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas_detail',array('REF_NUMBER_FCL_IN' => $REF_NUMBER),array('ID_DET' => $ID_DET));

           //array_push($show_array,$data) ;
    }



    return 'Ya' ;
}




    //jika tujuan pjt dan lcl (GMBA)
function transfer_ops_in2($ID,$cont_date_in,$cont_time_in){

    $T_In_ID = $this->m_model->select_max_where('mbatps','tps_t_plp', 'T_In_ID');
    $T_In_Detail_ID = $this->m_model->select_max_where('mbatps','tps_t_plp_detail', 'T_In_Detail_ID');

    $where = array('a.ACTIVE' => 0,'a.FLAG_TRANSFER' => 0,'a.ID' => $ID, 'b.ACTIVE' => 0,'a.GUDANG_TUJUAN' => 'GMBA');
    $this->db_tpsonline->group_by('NO_CONT');
    $this->db_tpsonline->select('a.*,b.*');
    $this->db_tpsonline->from('tbl_respon_plp_petikemas as a');
    $this->db_tpsonline->join('tbl_respon_plp_petikemas_detail as b','a.ID = b.ID','inner');
    $this->db_tpsonline->where($where);
    $this->db_tpsonline->group_by('b.NO_CONT');
    $data_detail = $this->db_tpsonline->get();
    if($data_detail->num_rows() == 0){ return "Data Tidak Ditemukan...!!"; }

        //$show_array = array();
    $party = 0 ;
    foreach($data_detail->result_array() as $detail){
        $party++;

        $ID_DET = $detail['ID_DET'] ;
        $NoKontainer =  substr($detail['NO_CONT'],0,4).' '.substr($detail['NO_CONT'],4,11) ;
        $KdCtr = ($detail['UK_CONT'] == "20") ? '2DS' : '4DS' ;
        $TglTiba = $detail['TGL_TIBA'] ;
        $NoPLP = $detail['NO_PLP'] ;
        $TglPLP = date_db($detail['TGL_PLP']) ;
        $NoSuratPLP = $detail['NO_SURAT'] ;
        $TglSuratPLP = date_db($detail['TGL_SURAT']) ;
        $NoBL = $detail['NO_BL_AWB'] ;
        $TglBL = date_db($detail['TGL_BL_AWB']) ; 
        $consignee = $detail['CONSIGNEE'] ;

        if ($detail['KD_TPS_ASAL'] == 'TPS0') {
            $kdterminal = 8;
        } else if ($detail['KD_TPS_ASAL'] == 'TTL0') {
            $kdterminal = 9;
        } else {
            $kdterminal = 1000;
        }

        $vessel = $detail['NM_ANGKUT'].' '.$detail['NO_VOY_FLIGHT'] ;
        $nobc = $detail['NO_BC11'] ;
        $tglbc = date_db($detail['TGL_BC11']) ;
        $nopos = $detail['NO_POS_BC11'] ;
        $callsign = $detail['CALL_SIGN'] ;

        $code_principal =  "" ;
        if(trim($detail['GUDANG_TUJUAN']) == "CMBA"){
            $code_principal = "TPS" ;
        }else if(trim($detail['GUDANG_TUJUAN']) == "GMBA" && trim($detail['GUDANG_ASAL']) == "CTPS"){
            $code_principal = "LCL" ;
        }else if(trim($detail['GUDANG_TUJUAN']) == "GMBA" && trim($detail['GUDANG_ASAL']) == "CTTL"){
            $code_principal = "PJT" ;
        }else{
            $code_principal = "TPS" ;
        }


        $data_det = array(
            'T_In_Detail_ID'    => $T_In_Detail_ID,
            'T_In_ID'           => $T_In_ID,
            'NoKontainer'       => $NoKontainer,
            'KdCtr'             => $KdCtr,
            'Status'            => 'K',
            'SealNumber'        => '',
            'Tipe_Cargo'        => 'C',
            'TglTiba'           => $TglTiba,
            'TglMasuk'          => $cont_date_in,
            'JamMasuk'          => $cont_time_in,
            'Category'          => 'B',
            'Location'          => '. .. .. ..',
            'CatLoc'            => 'Y',
            'Principal'         => $code_principal,
            'NoPLP'             => $NoPLP,
            'TglPLP'            => $TglPLP,
            'NoSuratPLP'        => $NoSuratPLP,
            'TglSuratPLP'       => $TglSuratPLP,
            'flag_segel'        => 0,
            'NoSegel'           => '',
            'Keterangan'        => '-',
            'flag_segel_CEK'    => 0,
            'TglSegel_CEK'      => null,
            'Bahandle'          => '',
            'TglBahandle'       => null,
            'LocationBahandle'  => '',
            'NoJob'             => '',
            'RecID'             => 0,
        );

        $hasil = $this->mbatps->insert('tps_t_plp_detail', $data_det);
        if ($hasil >= 1) {
        }else{
            return "Transaction to tps_t_plp_detail Error" ;
            die;
        }

            //$this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas_detail',array('T_IN_ID' => $T_In_ID),array('ID_DET' => $ID_DET));
        $this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas_detail',array('T_IN_ID' => $T_In_ID),array('ID' => $ID));

            //$this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas_detail',array('T_IN_DETAIL_ID' => $T_In_Detail_ID),array('ID_DET' => $ID_DET));
        $this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas_detail',array('T_IN_DETAIL_ID' => $T_In_Detail_ID),array('ID' => $ID));

        $this->mbatps->query("insert into tps_t_plp_detail_gate_status (T_In_Detail_ID,
            No_pos,No_bc,NoKontainer,FlagStatus,Created_On,Created_By,TglMasuk)
            values ('".$T_In_Detail_ID."','".$nopos."','".$nobc."','".$NoKontainer."','1',
            '".tanggal_sekarang()."','".$this->session->userdata('autogate_username')."','".$cont_date_in."') ");


        $this->mbatps->query("insert into  tps_t_plp_detail_status(T_In_Detail_ID,T_In_Detail_ID_SUB,NoKontainer,FlagStatus,Created_On,Created_By) 
            values ('".$T_In_Detail_ID."','1','".$NoKontainer."','1','".tanggal_sekarang()."','AutomatedBySystem') ");


            //array_push($show_array,$data_det) ;
        $T_In_Detail_ID++;
    }

    $save_head = array(
        'T_In_ID'               => $T_In_ID,
        'NoBL'                  => $NoBL,
        'TglBL'                 => $TglBL,
        'Consignee'             => $consignee,
        'KdTerminal'            => $kdterminal,
        'Vessel'                => $vessel,
        'Shipper'               => NULL,
        'Party'                 => $party,
        'InvTerminal'           => NULL,
        'TglInvTerminal'        => NULL,
        'BiayaTerminal'         => 0,
        'BiayaLainTerminal'     => 0,
        'TotalBiayaTerminal'    => 0,
        'Sisa_Biaya_Terminal'   => 0,
        'FlagInvTerminal'       => NULL,
        'FlagBiayaTerminal'     => NULL,
        'KetInvTerminal'        => NULL,
        'CreatedOn'             => tanggal_sekarang(),
        'CreatedBy'             => $this->session->userdata('autogate_username'),
        'RecID'                 => 0,
        'NoBC1'                 => $nobc,
        'TglBC1'                => $tglbc,
        'No_Pos'                => $nopos,            
        'CallSign'              => $callsign,
        'NoBA'                  => '',
        'TglBA'                 => null,
    );

    $hasil = $this->mbatps->insert('tps_t_plp', $save_head);
    if ($hasil >= 1) {
    }else{
        return "Transaction to tps_t_plp Error" ;
        die;
    }



        //array_push($show_array,$save_head) ;

    return 'Ya' ;
        //return $show_array;
}

    //jika tujuan pjt dan lcl (GMBA)
function transfer_gate_in2($ID,$cont_date_in,$cont_time_in){

    $where = array('ACTIVE' => 0,'FLAG_TRANSFER' => 0,'ID' => $ID,'GUDANG_TUJUAN' => 'GMBA');

        //print("<pre>".print_r($where,true)."</pre>"); 

    $data_header = $this->db_tpsonline->get_where('tbl_respon_plp_petikemas',$where);
    if($data_header->num_rows() == 0){ return "Data Header Respon Tidak Ditemukan...!!"; }

    $where = array('ACTIVE' => 0,'ID' => $ID);
    $this->db_tpsonline->group_by('NO_CONT');
    $this->db_tpsonline->order_by('ID,NO_POS_BC11,NO_CONT');
    $data_detail = $this->db_tpsonline->get_where('tbl_respon_plp_petikemas_detail',$where);
    if($data_detail->num_rows() == 0){ return "Data Detail Respon Tidak Ditemukan...!!"; }

    $vessel = '' ;
    $GUDANG_TUJUAN = "" ;
    $GUDANG_ASAL = "" ;
    foreach($data_header->result_array() as $header){
        $vessel = $header['NM_ANGKUT'].' '.$header['NO_VOY_FLIGHT'] ;
        $GUDANG_TUJUAN = $header['GUDANG_TUJUAN'] ;
        $GUDANG_ASAL = $header['GUDANG_ASAL'] ;
    }

    $code_principal =  "" ;
    $name_principal = "" ;
    if(trim($GUDANG_TUJUAN) == "CMBA"){
        $code_principal = "TPS" ;
        $name_principal = "T P SEMENTARA" ;
    }else if(trim($GUDANG_TUJUAN) == "GMBA" && trim($GUDANG_ASAL) == "CTPS"){
        $code_principal = "LCL" ;
        $name_principal = "TPS-LCL" ;
    }else if(trim($GUDANG_TUJUAN) == "GMBA" && trim($GUDANG_ASAL) == "CTTL"){
        $code_principal = "PJT" ;
        $name_principal = "PERUSAHAAN JASA TITIPAN" ;
    }else{
        $code_principal = "TPS" ;
        $name_principal = "T P SEMENTARA" ;
    }

        //$show_array = array();
    foreach($data_detail->result_array() as $detail){
        $ID_DET = $detail['ID_DET'] ;

        $cont_number =  substr($detail['NO_CONT'],0,4).' '.substr($detail['NO_CONT'],4,11) ;

        $reff_code = ($detail['UK_CONT'] == "20") ? '2DS' : '4DS' ;
        $reff_description = ($detail['UK_CONT'] == "20") ? '20ft D.S' : '40ft D.S' ;
            $cont_status = 'Full'; //($detail['JNS_CONT'] == "F") ? 'Full' : 'Empty' ;
            $id_cont_in = $this->m_model->id_in() ;
            
            $bon_bongkar_number = $this->m_model->bon_bongkar_number() ;
            $eir_in = $this->m_model->eir_r_number() ;


            $data = array(
                'id_cont_in' => $id_cont_in,
                'bon_bongkar_number' => $bon_bongkar_number,
                'eir_in' => $eir_in,
                'code_principal' => $code_principal,
                'name_principal' => $name_principal,
                'cont_number' => $cont_number,
                'dangers_goods' => 'No',
                'vessel' => $vessel,
                'shipper' => '',
                'truck_number' => '',
                'driver_name' => '',
                'reff_code' => $reff_code,
                'reff_description' => $reff_description,
                'cont_condition' => 'AV',
                'new_cont_condition' => 'AV',
                'cont_status' => $cont_status,
                'new_cont_status' => $cont_status,
                'cont_date_in' => $cont_date_in,
                'cont_time_in' => $cont_time_in,
                'block_loc' => '.',
                'location' => '.. .. .. ..',
                'ship_line_code' => '.',
                'ship_line_name' => '.',
                'bc_code' => '',
                'bc_name' => '',
                'invoice_in' => '.',
                'plate' => '.',
                'clean_type' => '.',
                'clean_date' => null,
                'notes' => '.',
                'created_by' => $this->session->userdata('autogate_username'),
                'created_on' => tanggal_sekarang(),
                'rec_id' => 0,
                'bruto' => 0,
                'seal_number' => '',
                'no_eir' => '',
                'tgl_eir' => null,
            );
            
            $hasil = $this->ptmsagate->insert('t_t_entry_cont_in', $data);
            if ($hasil >= 1) {
            }else{
                return "Transaction to t_t_entry_cont_in Error" ;
                die;
            }
            //array_push($show_array,$data) ;

            $data = array(
                'id_cont_in' => $id_cont_in,
                'code_principal' => $code_principal,
                'name_principal' => $name_principal,
                'cont_number' => $cont_number,
                'dangers_goods' => 'No',
                'vessel' => $vessel,
                'reff_code' => $reff_code,
                'reff_description' => $reff_description,
                'cont_condition' => 'AV',
                'cont_status' => $cont_status,
                'cont_date_in' => $cont_date_in,
                'cont_time_in' => $cont_time_in,
                'bon_bongkar_number' => $bon_bongkar_number,
                'block_loc' => '.',
                'location' => '.. .. .. ..',
                'ship_line_code' => '.',
                'ship_line_name' => '.',
                'bc_code' => '',
                'notes' => '.',
                'invoice_in' => '.',
                'created_by' => $this->session->userdata('autogate_username'),
                'created_on' => tanggal_sekarang(),
                'rec_id' => 0,
                'seal_number' => '',
                'no_eir' => '',
                'tgl_eir' => null,
                'bruto' => 0,
            );

            $hasil = $this->ptmsagate->insert('t_t_stock', $data);
            if ($hasil >= 1) {
            }else{
                return "Transaction to t_t_stock Error" ;
                die;
            }

            $data = array(
                'eir_type' => 'I',
                'eir_number' => $eir_in,
                'bon_bongkar_number' => $bon_bongkar_number,
                'code_principal' => $code_principal,
                'name_principal' => $name_principal,
                'cont_number' => $cont_number,
                'vessel' => $vessel,
                'shipper'=> '',
                'truck_number' => '',
                'driver_name' => '',
                'reff_code' => $reff_code,
                'reff_description' => $reff_description,
                'cont_condition' => 'AV',
                'cont_status' => $cont_status,
                'cont_date_in' => $cont_date_in,
                'cont_time_in' => $cont_time_in,
                'seal_number'=> '',
                'block_loc' => '.',
                'location' => '.. .. .. ..',
                'notes' => '.',
                'created_by' => $this->session->userdata('autogate_username'),
                'created_on' => tanggal_sekarang(),
                'rec_id' => 0,
                'no_eir' => '',
                'tgl_eir' => null,
                'bruto' => 0,
            );
            $hasil = $this->ptmsagate->insert('t_eir', $data);

            if ($hasil >= 1) {
            }else{
                return "Transaction to t_eir Error" ;
                die;
            }
            
            $update_no_eir_in = $this->m_model->update_eir_r_number();

            //$this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas_detail',array('ID_CONT_IN' => $id_cont_in),array('ID_DET' => $ID_DET));
            $this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas_detail',array('ID_CONT_IN' => $id_cont_in),array('ID' => $ID));

        }

        return 'Ya' ;

    }


    

    //jika tujuan pjt dan lcl (GMBA)
    function transfer_fcl_in2($ID,$cont_date_in,$cont_time_in){
        $where = array('a.ACTIVE' => 0,'a.FLAG_TRANSFER' => 0,'a.ID' => $ID, 'b.ACTIVE' => 0,'a.GUDANG_TUJUAN' => 'GMBA');

        $this->db_tpsonline->group_by('NO_CONT');
        $this->db_tpsonline->select('a.*,b.*');
        $this->db_tpsonline->from('tbl_respon_plp_petikemas as a');
        $this->db_tpsonline->join('tbl_respon_plp_petikemas_detail as b','a.ID = b.ID','inner');
        $this->db_tpsonline->where($where);
        $this->db_tpsonline->group_by('b.NO_CONT');
        $data_detail = $this->db_tpsonline->get();

        if($data_detail->num_rows() == 0){ return "Data Tidak Ditemukan...!!"; }


        //$show_array = array();
        foreach($data_detail->result_array() as $detail){

            $ID_DET = $detail['ID_DET'] ;
            $GetKD_TPS = $detail['KD_TPS_TUJUAN'] ;
            $this->m_model->set_run_number_tpsonline($GetKD_TPS,'FCL','tbl_run_number_tpsonline');
            $where = array('NAME' => 'FCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $detail['KD_TPS_TUJUAN']);
            $get_ref_number = $this->db_tpsonline->get_where('tbl_run_number_tpsonline',
                array('NAME' => 'FCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $detail['KD_TPS_TUJUAN']))->result_array();
            
            foreach($get_ref_number as $result){                
                $GetYEAR = $result['YEAR'] ;
                $GetMONTH = $result['MONTH'] ;
                $GetNUMBER = $result['NUMBER'] ;
            }

            $this->m_model->updatedata('db_tpsonline','tbl_run_number_tpsonline', array('NUMBER' => $GetNUMBER + 1), $where);
            $GetNUMBER = str_pad($GetNUMBER, 6, "200000", STR_PAD_LEFT);
            $GetDATE = date('m');
            $REF_NUMBER = $GetKD_TPS . '' . $GetYEAR . '' . $GetMONTH . '' . $GetDATE . '' . $GetNUMBER;


            $data = array(
                'KD_DOK' => 5,
                'KD_TPS' => $detail['KD_TPS_TUJUAN'],
                'NM_ANGKUT' => $detail['NM_ANGKUT'],
                'NO_VOY_FLIGHT' => $detail['NO_VOY_FLIGHT'],
                'CALL_SIGN' => $detail['CALL_SIGN'],
                'TGL_TIBA' => $detail['TGL_TIBA'],
                'KD_GUDANG' => $detail['GUDANG_TUJUAN'],
                'REF_NUMBER' => $REF_NUMBER,
                'NO_CONT' => $detail['NO_CONT'],
                'UK_CONT' => $detail['UK_CONT'],
                'NO_SEGEL' => '', //ini di input pada saat gate ini
                'JNS_CONT' => 'F',
                'NO_BL_AWB' => $detail['NO_BL_AWB'],
                'TGL_BL_AWB' => $detail['TGL_BL_AWB'],
                'NO_MASTER_BL_AWB' => '',
                'TGL_MASTER_BL_AWB' => null,
                'ID_CONSIGNEE' => '', 
                'CONSIGNEE' => '',
                'BRUTO' => '',  //ini di input pada saat gate ini
                'NO_BC11' => $detail['NO_BC11'],
                'TGL_BC11' => $detail['TGL_BC11'],
                'NO_POS_BC11' => $detail['NO_POS_BC11'],
                'KD_TIMBUN' => '',  //ini di input pada saat gate ini
                'KD_DOK_INOUT' => 3,
                'NO_DOK_INOUT' => $detail['NO_SURAT'],
                'TGL_DOK_INOUT' => $detail['TGL_SURAT'],
                'WK_INOUT' => $cont_date_in.' '.$cont_time_in,
                'KD_SAR_ANGKUT_INOUT' => 1,
                'NO_POL' => '',  //ini di input pada saat gate ini
                'FL_CONT_KOSONG' => 2,
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
                'NO_IJIN_TPS' => '', //ini di input pada saat gate ini
                'TGL_IJIN_TPS' => null, //ini di input pada saat gate ini
            );

            $hasil = $this->db_tpsonline->insert('tbl_request_plp_in_container', $data);
            if ($hasil >= 1) {
            }else{
                return "Transaction to tbl_request_plp_in_container Error" ;
                die;
            }

            //$this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas_detail',array('REF_NUMBER_FCL_IN' => $REF_NUMBER),array('ID_DET' => $ID_DET));
            $this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas_detail',array('REF_NUMBER_FCL_IN' => $REF_NUMBER),array('ID' => $ID));

        }



        return 'Ya' ;
    }


    function c_transfer_lcl(){

        $ID = $this->input->post('ID');

        $cont_date_in = date_db(tanggal_sekarang()) ;
        $cont_time_in = jam_sekarang();

        $transfer_gate_in2 = $this->transfer_gate_in2($ID,$cont_date_in,$cont_time_in);


        if($transfer_gate_in2 != "Ya"){
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Ada Kesalahan di function transfer_gate_in2 ...!');
            echo json_encode($pesan_data); die;
        }



        $transfer_ops_in2 = $this->transfer_ops_in2($ID,$cont_date_in,$cont_time_in);
        if($transfer_ops_in2 != "Ya"){
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Ada Kesalahan di function transfer_ops_in2 ...!');
            echo json_encode($pesan_data); die;
        }

        $transfer_fcl_in2 = $this->transfer_fcl_in2($ID,$cont_date_in,$cont_time_in);
        if($transfer_fcl_in2 != "Ya"){
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Ada Kesalahan di function transfer_fcl_in ...!');
            echo json_encode($pesan_data); die;
        }

        $transfer_lcl_in = $this->transfer_lcl_in($ID,$cont_date_in,$cont_time_in);
        if($transfer_lcl_in != "Ya"){
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Ada Kesalahan di function transfer_lcl_in ...!');
            echo json_encode($pesan_data); die;
        }


        $this->m_model->updatedata('db_tpsonline','tbl_respon_plp_petikemas',array('FLAG_TRANSFER' => 1),array('ID' => $ID));

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => 'Transfer Data Sukses ...!!',
        );
        echo json_encode($pesan_data);
    }


    //disini ada lcl in dan out lsg tercreate
    function transfer_lcl_in($ID,$cont_date_in,$cont_time_in){
        $where = array('a.ACTIVE' => 0,'a.FLAG_TRANSFER' => 0,'a.ID' => $ID, 'b.ACTIVE' => 0,'a.GUDANG_TUJUAN' => 'GMBA');
        $this->db_tpsonline->select('a.*,b.*');
        $this->db_tpsonline->from('tbl_respon_plp_petikemas as a');
        $this->db_tpsonline->join('tbl_respon_plp_petikemas_detail as b','a.ID = b.ID','inner');
        $this->db_tpsonline->where($where);
        $data_detail = $this->db_tpsonline->get();

        if($data_detail->num_rows() == 0){ return "Data Tidak Ditemukan...!!"; }

        $array_ref_number_fcl_in = array();

        //===================== CREATE LCL IN
        foreach($data_detail->result_array() as $detail){
            $ID_DET = $detail['ID_DET'] ;
            $GetKD_TPS = $detail['KD_TPS_TUJUAN'] ;
            $this->m_model->set_run_number_tpsonline($GetKD_TPS,'LCL','tbl_run_number_tpsonline');
            $where = array('NAME' => 'LCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $detail['KD_TPS_TUJUAN']);
            $get_ref_number = $this->db_tpsonline->get_where('tbl_run_number_tpsonline',
                array('NAME' => 'LCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $detail['KD_TPS_TUJUAN']))->result_array();
            
            foreach($get_ref_number as $result){                
                $GetYEAR = $result['YEAR'] ;
                $GetMONTH = $result['MONTH'] ;
                $GetNUMBER = $result['NUMBER'] ;
            }

            $this->m_model->updatedata('db_tpsonline','tbl_run_number_tpsonline', array('NUMBER' => $GetNUMBER + 1), $where);
            $GetNUMBER = str_pad($GetNUMBER, 6, "300000", STR_PAD_LEFT);
            $GetDATE = date('m');
            $REF_NUMBER = $GetKD_TPS . '' . $GetYEAR . '' . $GetMONTH . '' . $GetDATE . '' . $GetNUMBER;

            array_push($array_ref_number_fcl_in,$REF_NUMBER);

            $data = array(
                'KD_DOK' => 5,
                'KD_TPS' => $detail['KD_TPS_TUJUAN'],
                'NM_ANGKUT' => $detail['NM_ANGKUT'],
                'NO_VOY_FLIGHT' => $detail['NO_VOY_FLIGHT'],
                'CALL_SIGN' => $detail['CALL_SIGN'],
                'TGL_TIBA' => $detail['TGL_TIBA'],
                'KD_GUDANG' => $detail['GUDANG_TUJUAN'],
                'REF_NUMBER' => $REF_NUMBER,
                'NO_BL_AWB' => $detail['NO_BL_AWB'],
                'TGL_BL_AWB' => $detail['TGL_BL_AWB'],
                'NO_MASTER_BL_AWB' => '',
                'TGL_MASTER_BL_AWB' => null,
                'ID_CONSIGNEE' => '', 
                'CONSIGNEE' => '',
                'BRUTO' => '',  //ini di input pada saat gate ini
                'NO_BC11' => $detail['NO_BC11'],
                'TGL_BC11' => $detail['TGL_BC11'],
                'NO_POS_BC11' => $detail['NO_POS_BC11'],
                'CONT_ASAL' => $detail['NO_CONT'],
                'SERI_KEMAS' => '',
                'KODE_KEMAS' => '',
                'JML_KEMAS' => '',
                'KD_TIMBUN' => '',  //ini di input pada saat gate ini
                'KD_DOK_INOUT' => 3,
                'NO_DOK_INOUT' => $detail['NO_SURAT'],
                'TGL_DOK_INOUT' => $detail['TGL_SURAT'],
                'WK_INOUT' => $cont_date_in.' '.$cont_time_in,
                'KD_SAR_ANGKUT_INOUT' => 1,
                'NO_POL' => '',  //ini di input pada saat gate ini                
                'PEL_MUAT' => '',
                'PEL_TRANSIT' => '',
                'PEL_BONGKAR' => '',
                'GUDANG_TUJUAN' => $detail['GUDANG_TUJUAN'],
                'KODE_KANTOR' => '070100',
                'NO_DAFTAR_PABEAN' => '',
                'TGL_DAFTAR_PABEAN' => null,
                'NO_SEGEL_BC' => '',
                'TGL_SEGEL_BC' => null,
                'NO_IJIN_TPS' => '', //ini di input pada saat gate ini
                'TGL_IJIN_TPS' => null, //ini di input pada saat gate ini
                'ISO_CODE' => '',
                'REF_NUMBER_FCL_IN' => $detail['REF_NUMBER_FCL_IN']
            );

            $hasil = $this->db_tpsonline->insert('tbl_request_plp_in_kemasan', $data);
            if ($hasil >= 1) {
            }else{
                return "Transaction to tbl_request_plp_in_kemasan Error" ;
                die;
            }

        }

        //===================== end CREATE LCL IN



        //===================== CREATE LCL OUT
        $indexarray = 0 ;
        foreach($data_detail->result_array() as $detail){
            // $ID_DET = $detail['ID_DET'] ;
            // $GetKD_TPS = $detail['KD_TPS_TUJUAN'] ;
            // $this->m_model->set_run_number_tpsonline($GetKD_TPS,'LCL','tbl_run_number_tpsonline');
            // $where = array('NAME' => 'FCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $detail['KD_TPS_TUJUAN']);
            // $get_ref_number = $this->db_tpsonline->get_where('tbl_run_number_tpsonline',
            //     array('NAME' => 'FCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $detail['KD_TPS_TUJUAN']))->result_array();

            // foreach($get_ref_number as $result){                
            //     $GetYEAR = $result['YEAR'] ;
            //     $GetMONTH = $result['MONTH'] ;
            //     $GetNUMBER = $result['NUMBER'] ;
            // }

            // $this->m_model->updatedata('db_tpsonline','tbl_run_number_tpsonline', array('NUMBER' => $GetNUMBER + 1), $where);
            // $GetNUMBER = str_pad($GetNUMBER, 6, "500000", STR_PAD_LEFT);
            // $GetDATE = date('m');
            // $REF_NUMBER = $GetKD_TPS . '' . $GetYEAR . '' . $GetMONTH . '' . $GetDATE . '' . $GetNUMBER;


            $this->m_model->set_run_number_tpsonline('TEMP','TEMP','tbl_run_number_tpsonline');
            $get_ref_temp = $this->db_tpsonline->get_where('tbl_run_number_tpsonline',array('NAME' => 'TEMP','KD_TPS' => 'TEMP'))->result_array();

            foreach($get_ref_temp as $result){                
                $GetNUMBER = $result['NUMBER'] ;
            }

            $GetNUMBERX = str_pad($GetNUMBER, 8, "00000000", STR_PAD_LEFT);
            $REF_NUMBER_TEMP = 'TEMP-'. $GetNUMBERX;

            $where = array('NAME' => 'TEMP','KD_TPS' => 'TEMP');
            $this->m_model->updatedata('db_tpsonline','tbl_run_number_tpsonline', array('NUMBER' => $GetNUMBER + 1), $where);


            $data = array(
                'KD_DOK' => 6,
                'KD_TPS' => $detail['KD_TPS_TUJUAN'],
                'NM_ANGKUT' => $detail['NM_ANGKUT'],
                'NO_VOY_FLIGHT' => $detail['NO_VOY_FLIGHT'],
                'CALL_SIGN' => $detail['CALL_SIGN'],
                'TGL_TIBA' => $detail['TGL_TIBA'],
                'KD_GUDANG' => $detail['GUDANG_TUJUAN'],
                'REF_NUMBER' => $REF_NUMBER_TEMP,
                'NO_BL_AWB' => $detail['NO_BL_AWB'],
                'TGL_BL_AWB' => $detail['TGL_BL_AWB'],
                'NO_MASTER_BL_AWB' => '',
                'TGL_MASTER_BL_AWB' => null,
                'ID_CONSIGNEE' => '', 
                'CONSIGNEE' => '',
                'BRUTO' => '',  //ini di input pada saat gate ini
                'NO_BC11' => $detail['NO_BC11'],
                'TGL_BC11' => $detail['TGL_BC11'],
                'NO_POS_BC11' => $detail['NO_POS_BC11'],
                'CONT_ASAL' => $detail['NO_CONT'],
                'SERI_KEMAS' => '',
                'KODE_KEMAS' => '',
                'JML_KEMAS' => '',
                'KD_TIMBUN' => '',  //ini di input pada saat gate ini
                'KD_DOK_INOUT' => 1,
                'NO_DOK_INOUT' => $detail['NO_SURAT'],
                'TGL_DOK_INOUT' => $detail['TGL_SURAT'],
                'WK_INOUT' => $cont_date_in.' '.$cont_time_in,
                'KD_SAR_ANGKUT_INOUT' => 1,
                'NO_POL' => '',  //ini di input pada saat gate ini                
                'PEL_MUAT' => '',
                'PEL_TRANSIT' => '',
                'PEL_BONGKAR' => '',
                'GUDANG_TUJUAN' => $detail['GUDANG_TUJUAN'],
                'KODE_KANTOR' => '070100',
                'NO_DAFTAR_PABEAN' => '',
                'TGL_DAFTAR_PABEAN' => null,
                'NO_SEGEL_BC' => '',
                'TGL_SEGEL_BC' => null,
                'NO_IJIN_TPS' => '', //ini di input pada saat gate ini
                'TGL_IJIN_TPS' => null, //ini di input pada saat gate ini
                'ISO_CODE' => '',
                'REF_NUMBER_FCL_IN' => $detail['REF_NUMBER_FCL_IN'],
                'REF_NUMBER_LCL_IN' => $array_ref_number_fcl_in[$indexarray]
            );

            $hasil = $this->db_tpsonline->insert('tbl_request_plp_out_kemasan', $data);
            if ($hasil >= 1) {
            }else{
                return "Transaction to tbl_request_plp_out_kemasan Error" ;
                die;
            }

            $indexarray++;

        }

        //===================== end CREATE LCL OUT


        return 'Ya' ;
    }

    function c_export(){

        $username = $this->session->userdata('autogate_username') ;

        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);


        $startdate = $data[0] ;
        $enddate = $data[1] ;
        $GUDANG_TUJUAN = $data[2] ;
        $NO_CONT = $data[3] ;


        $query1 = " SELECT 'nomor' as 'No',NO_SURAT 'NO_SURAT_PLP',DATE_FORMAT(TGL_SURAT,'%Y%m%d') 'TGL_SURAT_PLP',
        NO_PLP,DATE_FORMAT(TGL_PLP,'%Y%m%d') as 'TGL_PLP',NM_ANGKUT,
        NO_VOY_FLIGHT,CALL_SIGN,DATE_FORMAT(TGL_TIBA,'%Y%m%d') as 'TGL_TIBA',
        NO_BC11,DATE_FORMAT(TGL_BC11,'%Y%m%d') as 'TGL_BC11',
        NO_POS_BC11,CONSIGNEE,NO_CONT,UK_CONT 'UK','' as 'KET'
        from tbl_respon_plp_petikemas a 
        INNER JOIN tbl_respon_plp_petikemas_detail b on a.ID=b.ID where a.ID<>'' " ;

        


        $query2 = " SELECT 'nomor' as 'No',NO_SURAT 'Nomor Surat',NO_PLP 'No PLP',DATE_FORMAT(TGL_PLP,'%Y%m%d') as 'Tgl PLP',
        NM_ANGKUT 'Nama Kapal',NO_VOY_FLIGHT 'No. Voy'  , NO_BC11 'No. BC 1,1',
        DATE_FORMAT(TGL_BC11,'%Y%m%d') 'Tgl BC 1,1' , NO_CONT , UK_CONT 'UK'

        from tbl_respon_plp_petikemas a 
        INNER JOIN tbl_respon_plp_petikemas_detail b on a.ID=b.ID where a.ID<>'' " ;



        if($startdate != ""){
            $query1.= " and DATE_FORMAT(TGL_PLP,'%Y-%m-%d') >= '".date_db($startdate)."' " ;
            $query2.= " and DATE_FORMAT(TGL_PLP,'%Y-%m-%d') >= '".date_db($startdate)."' " ;
        }  
        if($enddate != ""){
            $query1.= " and DATE_FORMAT(TGL_PLP,'%Y-%m-%d') <= '".date_db($enddate)."' " ;
            $query2.= " and DATE_FORMAT(TGL_PLP,'%Y-%m-%d') <= '".date_db($enddate)."' " ;
        } 
        if($GUDANG_TUJUAN != ""){
            $query1.= " and GUDANG_TUJUAN = '".$GUDANG_TUJUAN."' " ;
            $query2.= " and GUDANG_TUJUAN = '".$GUDANG_TUJUAN."' " ;
        } 
        if($NO_CONT != ""){
            $query1.= " and NO_CONT = '".$NO_CONT."' " ;
            $query2.= " and NO_CONT = '".$NO_CONT."' " ;
        }   

        $query1.= " order by GUDANG_TUJUAN,NO_PLP,NO_POS_BC11 asc " ;     
        $query2.= " order by GUDANG_TUJUAN, NO_PLP,NO_POS_BC11 asc " ;   

        $data1 = $this->db_tpsonline->query($query1)->result_array();    
        $data2 = $this->db_tpsonline->query($query2)->result_array();            


        $nama_excel = "ReportDataOB_".tanggal_sekarang() ;

        $nama_sheet = array(
            '0' => 'Data Berita Acara',
            '1' => 'Data Surat Pemindahan'
        );

        $data_all_sheet = array(
            '0' => $data1,
            '1' => $data2
        );

        $setting_xls = array(
            'jumlah_sheet' => 2 ,
            'nama_excel' => $nama_excel,
            'nama_sheet' => $nama_sheet,
            'data_all_sheet' => $data_all_sheet,
        );

        //print("<pre>".print_r($setting_xls,true)."</pre>"); die;
        $this->m_model->generator_xls_ob($setting_xls);


    }


    function c_printbarcode() {

        $this->load->library('ciqrcode');

        $username = $this->session->userdata('autogate_username');

        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);

        $startdate = $data[0];
        $enddate = $data[1];
        $GUDANG_TUJUAN = $data[2];
        $NO_CONT = $data[3];



        $query1 = " SELECT b.NO_CONT,b.NO_BL_AWB,b.TGL_BL_AWB,b.CONSIGNEE,a.NM_ANGKUT,a.NO_VOY_FLIGHT,a.KD_TPS_ASAL
        from tbl_respon_plp_petikemas a 
        INNER JOIN tbl_respon_plp_petikemas_detail b on a.ID=b.ID where a.ID<>'' " ;


        if($startdate != ""){
            $query1.= " and DATE_FORMAT(TGL_PLP,'%Y-%m-%d') >= '".date_db($startdate)."' " ;
        }  
        if($enddate != ""){
            $query1.= " and DATE_FORMAT(TGL_PLP,'%Y-%m-%d') <= '".date_db($enddate)."' " ;
        } 
        if($GUDANG_TUJUAN != ""){
            $query1.= " and GUDANG_TUJUAN = '".$GUDANG_TUJUAN."' " ;
        } 
        if($NO_CONT != ""){
            $query1.= " and NO_CONT = '".$NO_CONT."' " ;
        }   

        $query1.= " group by NO_CONT order by GUDANG_TUJUAN,NO_PLP,NO_POS_BC11 asc " ;      

        $data1 = $this->db_tpsonline->query($query1)->result_array();    


        $dataBarcode = array();
        foreach($data1 as $dataContainer){
            $arraytemp = array();

            $tpsasal = "" ;
            $kode = "" ;

            if($dataContainer['KD_TPS_ASAL'] == "TPS0"){


                $tpsasal = "PT Terminal Petikemas Surabaya (TPS)" ; //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kode : TPS0"
                $kode = "TPS0" ;

            }else if($dataContainer['KD_TPS_ASAL'] == "TTL0"){

                $tpsasal = "PT Terminal Teluk Lamong" ; //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kode : TTL0"
                $kode = "TTL0" ;

            }

            $arraytemp = array(
                'NO_CONT' => $dataContainer['NO_CONT'],
                'NO_BL_AWB' => $dataContainer['NO_BL_AWB'],
                'TGL_BL_AWB' => showdate_dmy($dataContainer['TGL_BL_AWB']),
                'CONSIGNEE' => $dataContainer['CONSIGNEE'],
                'TUJUAN'    => 'PT. Multi Bintang Abadi', //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kode : MBA0
                'NM_ANGKUT' => $dataContainer['NM_ANGKUT'],
                'NO_VOY_FLIGHT' => $dataContainer['NO_VOY_FLIGHT'],
                'tpsasal' => $tpsasal,
                'kode' => $kode
            );

            //membuat barcode qrcode
            $this->load->library('ciqrcode');

            $qrcont = str_replace(' ', '', $dataContainer['NO_CONT']) ;

            $params['data'] = $qrcont ;
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = FCPATH.'assets/image/qrcode/'.$qrcont.'.png';
            $this->ciqrcode->generate($params);

            // echo '<img src="'.base_url().'assets/image/qrcode/'.$qrcont.'.png" />';
            // die;
            //end membuat barcode qrcode

            array_push($dataBarcode,$arraytemp);
        }

        // print_r($dataBarcode) ;
        // die;


        


        $this->load->library('pdfgenerator');

        $data = array(
            'title_pdf' => "Barcode In",
            'dataBarcode' => $dataBarcode
        );

        // print_r($data['dataBarcode']);
        // die;

        // Filename dari PDF ketika diunduh
        $file_pdf = 'barcode_in_' . tanggal_sekarang();
        
        // Setting ukuran kertas secara custom untuk 1/2 letter
        $paper = array(0, 0, 612, 396); // 8.5 x 5.5 inch in points
        
        // Orientasi kertas
        $orientation = "portrait";
        
        // Load view yang akan dijadikan PDF
        $html = $this->load->view("BarcodeIn", $data, true);

        // print_r($html) ;
        // die;

        // Run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }



}