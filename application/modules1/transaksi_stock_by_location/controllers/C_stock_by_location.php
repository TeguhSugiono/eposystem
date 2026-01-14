<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");

class C_stock_by_location extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);        
        $this->mbatps = $this->load->database('mbatps', TRUE);     
    }

    function index() {
        $arraydata = array('All' => 'All', 'Full' => 'Full','Empty' => 'Empty');
        $cont_status = ComboNonDb($arraydata, 'cont_status', 'AV', 'form-control form-control-sm');

        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'cont_status' => $cont_status
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_search(){

        $code_principal = $this->input->post('code_principal');

        $query = " SELECT * FROM t_t_stock where rec_id=0  and code_principal='".$code_principal."' group by code_principal " ;

        $excute = $this->ptmsagate->query($query);

        if($excute->num_rows() == 0){
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Data Principal Yang Dicari Tidak Ada..!!','query' => $query);
            echo json_encode($pesan_data);die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'array_search' => $excute->result_array(),
            'query' => $query
        );
        echo json_encode($pesan_data);
    }

    function c_tbl_stock_by_location(){
        $code_principal = $this->input->post('code_principal');
        $block_loc = $this->input->post('block_loc');

        $query = "SELECT cont_number,reff_code,cont_status,cont_condition,cont_date_in,concat(block_loc,' ',location) 'location' " ;
        $query.= " FROM t_t_stock " ;
        $query.= " where code_principal='".$code_principal."' " ;

        if($block_loc  != ""){
            $query.= " and block_loc = '".$block_loc."' " ;
        }
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
            $hasil.= '<td>' . showdate_dmy($row->cont_date_in) . '</td>';
            $hasil.= '<td>' . $row->location . '</td>';
            $hasil.= '</tr>';

        }

        $comp = array(
            'table_data' => $hasil
        );        
        echo json_encode($comp);
    }


    function c_print(){
        include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");
        
        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);
        
        $code_principal = $data[0] ;
        $block_loc = $data[1] ;

        $query = "SELECT 
                    code_principal, name_principal, cont_number, reff_code, cont_condition, cont_status,
                    DATE_FORMAT(cont_date_in,'%d-%m-%Y') as 'cont_date_in', cont_date_out, block_loc, location,   
                    case 
                    when dangers_goods = 'No' then ('')         
                    else ('B') end as dangers                 
                FROM 
                    t_t_stock
                WHERE 
                    code_principal = '".$code_principal."'         
                    and block_loc = '".$block_loc."'  
                    and rec_id = '0'

                ORDER BY
                      block_loc, location, reff_code " ;

        $data = $this->ptmsagate->query($query)->result_array();                  

        $PHPJasperXML = new PHPJasperXML();
        //$PHPJasperXML->debugsql=true;
        $PHPJasperXML->arrayParameter=array(
            "parameter1"=>1,
            "tanggal_sekarang" => showdate_dmy(tanggal_sekarang()),
            "jam_sekarang" => jam_sekarang(),
            "username" => $this->session->userdata('autogate_username')
        );
        $path = APPPATH . 'modules/report_jasper/report_stock_by_location.jrxml'; 
        $PHPJasperXML->load_xml_file($path);
        $dbdriver="mysql";
        $PHPJasperXML->transferDBtoArray($this->ptmsagate->hostname,$this->ptmsagate->username,$this->ptmsagate->password,$this->ptmsagate->database,$dbdriver);
        $PHPJasperXML->arraysqltable=$data;
        $PHPJasperXML->outpage("I");             
    }


    // function c_exportxls(){


    //     include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");
        
    //     $data = base64_decode($_GET['data']);
    //     $data = explode(',', $data);
        
    //     $code_principal = $data[0] ;
    //     $block_loc = $data[1] ;

    //     $query = "SELECT 
    //                 code_principal, name_principal, cont_number, reff_code, cont_condition, cont_status,
    //                 DATE_FORMAT(cont_date_in,'%d-%m-%Y') as 'cont_date_in', cont_date_out, block_loc, location,   
    //                 case 
    //                 when dangers_goods = 'No' then ('')         
    //                 else ('B') end as dangers                 
    //             FROM 
    //                 t_t_stock
    //             WHERE 
    //                 code_principal = '".$code_principal."'         
    //                 and block_loc = '".$block_loc."'  
    //                 and rec_id = '0'

    //             ORDER BY
    //                   block_loc, location, reff_code " ;

    //     $data = $this->ptmsagate->query($query)->result_array();                  

    //     $PHPJasperXML = new PHPJasperXML("en","XLS");
    //     //$PHPJasperXML->debugsql=true;
    //     $PHPJasperXML->arrayParameter=array(
    //         "parameter1"=>1,
    //         "tanggal_sekarang" => showdate_dmy(tanggal_sekarang()),
    //         "jam_sekarang" => jam_sekarang(),
    //         "username" => $this->session->userdata('autogate_username')
    //     );
    //     $path = APPPATH . 'modules/report_jasper/report_stock_by_location_xls.jrxml'; 
    //     $PHPJasperXML->load_xml_file($path);
    //     $dbdriver="mysql";
    //     $PHPJasperXML->transferDBtoArray($this->ptmsagate->hostname,$this->ptmsagate->username,$this->ptmsagate->password,$this->ptmsagate->database,$dbdriver);
    //     $PHPJasperXML->arraysqltable=$data;
    //     $PHPJasperXML->outpage("I","report_stock_by_location.xls");    
        
    // }

}