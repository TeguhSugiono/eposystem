<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");

class C_in_out_container extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);        
        $this->mbatps = $this->load->database('mbatps', TRUE);     
    }

    function index() {

        $arraydata = $this->ptmsagate->query("SELECT DATE_FORMAT(cont_date_in,'%Y') 'cont_date_in' ,DATE_FORMAT(cont_date_in,'%Y') 'cont_date_in2' 
            from t_t_stock where rec_id<>9 GROUP BY DATE_FORMAT(cont_date_in,'%Y')")->result_array();

        array_push($arraydata, array('cont_date_in' => '' , 'cont_date_in2' => 'All'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'cont_date_in', 'class' => ''),
        );
        

        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'cont_date_in' => ComboDb($createcombo),
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_search(){

        $code_principal = $this->input->post('code_principal');
        $cont_number = $this->input->post('cont_number');
        $cont_date_in = $this->input->post('cont_date_in');

        $query = " SELECT * FROM t_t_stock where rec_id<>9   " ;

        if($code_principal != ""){
            $query.= " and code_principal='".$code_principal."' " ;
        }

        if($cont_number != ""){
            $query.= " and cont_number='".$cont_number."' " ;
        }

        if($cont_date_in != ""){
            $query.= " and date_format(cont_date_in,'%Y')='".$cont_date_in."' " ;
        }

        $query.= " group by code_principal  " ; 

        $excute = $this->ptmsagate->query($query);

        if($excute->num_rows() == 0){
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Data Yang Dicari Tidak Ada..!!','query' => $query);
            echo json_encode($pesan_data);die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'array_search' => $excute->result_array(),
            'query' => $query
        );
        echo json_encode($pesan_data);
    }

    function c_tbl_in_out_container(){
        $code_principal = $this->input->post('code_principal');
        $cont_number = $this->input->post('cont_number');
        $cont_date_in = $this->input->post('cont_date_in');

        $query = " SELECT bon_bongkar_number,code_principal,cont_number,reff_code,cont_condition, " ;
        $query.= " cont_status,date_format(cont_date_in,'%d-%m-%Y') 'cont_date_in',cont_time_in,date_format(cont_date_out,'%d-%m-%Y') 'cont_date_out',cont_time_out " ;
        $query.= " FROM t_t_stock " ;
        $query.= " where rec_id<>9 " ;

        if($code_principal == "" && $cont_number == "" && $cont_date_in==""){
            $query.= " and code_principal = '' " ;
            $query.= " and cont_number = '' " ;
        }else{
            if($code_principal  != ""){
                $query.= " and code_principal = '".$code_principal."' " ;
            }
            if($cont_number  != ""){
                $query.= " and cont_number = '".$cont_number."' " ;
            }
            if($cont_date_in != ""){
                $query.= " and date_format(cont_date_in,'%Y')='".$cont_date_in."' " ;
            }
        }
        
        $query.= " order by cont_number,cont_date_in desc " ;        

        $data = $this->ptmsagate->query($query)->result();
        $comp = array(
            'table_data' => $data
        );        
        echo json_encode($comp);
    }

    // function c_tbl_in_out_containerxx(){
    //     $code_principal = $this->input->post('code_principal');
    //     $cont_number = $this->input->post('cont_number');

    //     $query = " SELECT bon_bongkar_number,code_principal,cont_number,reff_code,cont_condition, " ;
    //     $query.= " cont_status,cont_date_in,cont_time_in,cont_date_out,cont_time_out " ;
    //     $query.= " FROM t_t_stock " ;
    //     $query.= " where rec_id<>9 " ;

    //     if($code_principal == "" && $cont_number == ""){
    //         $query.= " and code_principal = '' " ;
    //         $query.= " and cont_number = '' " ;
    //     }else{
    //         if($code_principal  != ""){
    //             $query.= " and code_principal = '".$code_principal."' " ;
    //         }
    //         if($cont_number  != ""){
    //             $query.= " and cont_number = '".$cont_number."' " ;
    //         }
    //     }

        
    //     $query.= " order by cont_number,cont_date_in desc " ;
        

    //     $data = $this->ptmsagate->query($query)->result();
    //     $hasil = "" ;
    //     $no=0;
    //     foreach($data as $row){
    //         $no++;

    //         $hasil.= '<tr>';
    //         $hasil.= '<td>' . $no . '</td>';
    //         $hasil.= '<td>' . $row->bon_bongkar_number . '</td>';
    //         $hasil.= '<td>' . $row->code_principal . '</td>';
    //         $hasil.= '<td>' . $row->cont_number . '</td>';
    //         $hasil.= '<td>' . $row->reff_code . '</td>';
    //         $hasil.= '<td>' . $row->cont_condition . '</td>';
    //         $hasil.= '<td>' . $row->cont_status . '</td>';
    //         $hasil.= '<td>' . showdate_dmy($row->cont_date_in) . '</td>';
    //         $hasil.= '<td>' . $row->cont_time_in . '</td>';
    //         $hasil.= '<td>' . showdate_dmy($row->cont_date_out) . '</td>';
    //         $hasil.= '<td>' . $row->cont_time_out . '</td>';            
    //         $hasil.= '</tr>';

    //     }

    //     $comp = array(
    //         'table_data' => $hasil
    //     );        
    //     echo json_encode($comp);
    // }

}