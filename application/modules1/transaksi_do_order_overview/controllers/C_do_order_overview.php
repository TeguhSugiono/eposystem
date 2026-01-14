<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");

class C_do_order_overview extends CI_Controller {

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
        $do_number = $this->input->post('do_number');
        $code_principal = $this->input->post('code_principal');

        $query = " SELECT * FROM t_t_entry_do_cont_out where rec_id=0  and do_number='".$do_number."' " ;
        if($code_principal != ""){
            $query.= " and code_principal='".$code_principal."' " ;
        }

        $excute = $this->ptmsagate->query($query);

        if($excute->num_rows() == 0){
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Data DO Number Yang Dicari Tidak Ada..!!','query' => $query);
            echo json_encode($pesan_data);die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'array_search' => $excute->result_array(),
            'query' => $query
        );
        echo json_encode($pesan_data);
    }

    function c_tbl_do_order_overview(){
        $do_number = $this->input->post('do_number');
        $code_principal = $this->input->post('code_principal');

        $query = "SELECT cont_number,reff_code,cont_status,cont_condition,cont_date_out " ;
        $query.= " FROM t_t_entry_cont_out " ;
        $query.= " where do_number='".$do_number."' " ;
        $query.= " and code_principal='".$code_principal."' " ;
        $query.= " and rec_id=0 " ;
        

        $data = $this->ptmsagate->query($query)->result();
        $hasil = "" ;
        $no=0;
        foreach($data as $row){
            $no++;

            $hasil.= '<tr>';
            $hasil.= '<td>' . $no . '</td>';
            $hasil.= '<td>' . $row->cont_number . '</td>';
            $hasil.= '<td>' . $row->reff_code . '</td>';
            $hasil.= '<td>' . $row->cont_status . '</td>';
            $hasil.= '<td>' . $row->cont_condition . '</td>';
            $hasil.= '<td>' . showdate_dmy($row->cont_date_out) . '</td>';
            $hasil.= '</tr>';

        }

        $comp = array(
            'table_data' => $hasil
        );        
        echo json_encode($comp);
    }

}