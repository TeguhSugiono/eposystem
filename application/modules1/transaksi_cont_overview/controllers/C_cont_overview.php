<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");

class C_cont_overview extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);        
        $this->mbatps = $this->load->database('mbatps', TRUE);     
    }

    function index() {
        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_search(){

        $cont_number = $this->input->post('cont_number');
        $code_principal = $this->input->post('code_principal');

        $query = " SELECT *,DATE_FORMAT(cont_date_in,'%d-%m-%Y') as 'cont_date_in2' 
                    from t_t_entry_cont_in where cont_number='".$cont_number."' and rec_id<>9 " ;

        if($code_principal != ""){
            $query.= " and code_principal='".$code_principal."' " ;
        }

        $query.= " order by id_cont_in desc limit 1 " ;

        $excute = $this->ptmsagate->query($query);

        if($excute->num_rows() == 0){
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Data Kontainer Yang Dicari Tidak Ada..!!','query' => $query);
            echo json_encode($pesan_data);die;
        }

        $array_search = $excute->result_array();

        $query = " SELECT *,DATE_FORMAT(date_shifting,'%d-%m-%Y') as 'date_shifting2' ,DATE_FORMAT(date_stripping,'%d-%m-%Y') as 'date_stripping2' ,
                    DATE_FORMAT(date_stuffing,'%d-%m-%Y') as 'date_stuffing',DATE_FORMAT(cont_date_out,'%d-%m-%Y') as 'cont_date_out2',
                    DATEDIFF(if(cont_date_out is null,DATE_FORMAT(now(),'%Y-%m-%d'),cont_date_out),cont_date_in) + 1 'days_storage'
                    from t_t_stock where cont_number='".$cont_number."' and rec_id<>9 and bon_bongkar_number='".$array_search[0]['bon_bongkar_number']."' " ;

        if($code_principal != ""){
            $query.= " and code_principal='".$code_principal."' " ;
        }

        $query.= " order by id_cont_in desc limit 1" ;

        $excute_stock = $this->ptmsagate->query($query);
        $array_search_stock = $excute_stock->result_array();


        $query = " SELECT *
                    from t_t_entry_cont_out where cont_number='".$cont_number."' and rec_id<>9 
                    and bon_bongkar_number='".$array_search[0]['bon_bongkar_number']."' " ;

        if($code_principal != ""){
            $query.= " and code_principal='".$code_principal."' " ;
        }

        //$query.= " order by id_cont_out desc limit 1" ;

        $excute_out = $this->ptmsagate->query($query);
        $array_search_out = $excute_out->result_array();


        $pesan_data = array(
            'msg' => 'Ya',
            'array_search' => $array_search,
            'array_search_stock' => $array_search_stock,
            'array_search_out' => $array_search_out,
            'query' => $query
        );
        echo json_encode($pesan_data);
    }


}