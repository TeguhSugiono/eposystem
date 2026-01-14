<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");

class C_shifting_overview extends CI_Controller {

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

        $query = " select *,DATE_FORMAT(cont_date_in,'%d-%m-%Y') as 'cont_date_in2'  from t_t_entry_cont_in where cont_number='".$cont_number."' " ;
        if($code_principal != ""){
            $query.= " and code_principal='".$code_principal."' " ;
        }
        $query.= " order by id_cont_in desc limit 1  " ;

        $excute = $this->ptmsagate->query($query);

        if($excute->num_rows() == 0){
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Data Kontainer Yang Dicari Tidak Ada..!!','query' => $query);
            echo json_encode($pesan_data);die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'array_search' => $excute->result_array(),
            'query' => $query
        );
        echo json_encode($pesan_data);
    }

    function c_tbl_cont_shifting_overview(){
        $cont_number = $this->input->post('cont_number');
        $code_principal = $this->input->post('code_principal');
        $reff_code = $this->input->post('reff_code');
        $cont_date_in = date_db($this->input->post('cont_date_in'));

        $query = "SELECT cont_number,date_shifting,date_stripping,date_stuffing, " ;
        $query.= " new_cont_status,cont_condition,new_location " ;
        $query.= " FROM t_t_cont_shifting " ;
        $query.= " where cont_number='".$cont_number."' " ;
        $query.= " and code_principal='".$code_principal."' " ;
        $query.= " and reff_code='".$reff_code."' " ;
        $query.= " and cont_date_in='".$cont_date_in."' " ;
        $query.= " and rec_id=0 " ;
        

        $data = $this->ptmsagate->query($query)->result();
        $hasil = "" ;
        $no=0;
        foreach($data as $row){
            $no++;

            $hasil.= '<tr>';
            $hasil.= '<td>' . $no . '</td>';
            $hasil.= '<td>' . $row->cont_number . '</td>';
            $hasil.= '<td>' . $row->date_shifting . '</td>';
            $hasil.= '<td>' . $row->date_stripping . '</td>';
            $hasil.= '<td>' . $row->date_stuffing . '</td>';
            $hasil.= '<td>' . $row->new_cont_status . '</td>';
            $hasil.= '<td>' . $row->cont_condition . '</td>';
            $hasil.= '<td>' . $row->new_location . '</td>';
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
        
        $cont_number = $data[0] ;
        $code_principal = $data[1] ;
        $reff_code = $data[2] ;
        $cont_date_in = date_db($data[3]) ;

        $query = "SELECT 
                        code_principal, name_principal, cont_number, reff_code, cont_condition, cont_status,
                        cont_date_in, cont_time_in, old_location, new_location, new_cont_status, DATE_FORMAT(date_shifting,'%d-%m-%Y') as 'date_shifting',
                        change_description,
                        case 
                        when dangers_goods = 'No' then ('')         
                        else ('B') end as dangers                     
                    FROM 
                        t_t_cont_shifting
                    WHERE 
                        code_principal = '".$code_principal."' and cont_date_in = '".$cont_date_in."' and cont_number = '".$cont_number."' and rec_id <> '9'
                    ORDER BY
                          DATE_FORMAT(date_shifting,'%Y-%m-%d') asc,reff_code asc, cont_status asc" ; 

        $data = $this->ptmsagate->query($query)->result_array();                  

        $PHPJasperXML = new PHPJasperXML();
        //$PHPJasperXML->debugsql=true;
        $PHPJasperXML->arrayParameter=array(
            "parameter1"=>1,
            "tanggal_masuk" => showdate_dmy($cont_date_in),
            "tanggal_sekarang" => showdate_dmy(tanggal_sekarang()),
            "jam_sekarang" => jam_sekarang(),
            "username" => $this->session->userdata('autogate_username')
        );
        $path = APPPATH . 'modules/report_jasper/report_Inq_shift_Overview.jrxml'; 
        $PHPJasperXML->load_xml_file($path);
        $dbdriver="mysql";
        $PHPJasperXML->transferDBtoArray($this->ptmsagate->hostname,$this->ptmsagate->username,$this->ptmsagate->password,$this->ptmsagate->database,$dbdriver);
        // echo '<pre>'.print_r($PHPJasperXML->arraysqltable,true).'</pre>';
        // $PHPJasperXML->setData($data);
        $PHPJasperXML->arraysqltable=$data;

        $PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file                  

        /*                  
        $PHPJasperXML = new PHPJasperXML("en","TCPDF");
        $PHPJasperXML->arrayParameter = array('principal'=>"'$code_principal'",'datein'=>"'$cont_date_in'",'cont' => "'$cont_number'");
        $path = APPPATH . 'modules/report_jasper/report_Inq_shift_Overview.jrxml';        
        $PHPJasperXML->load_xml_file($path);
        $dbdriver="mysql";
        $version="1.1";        
        $PHPJasperXML->transferDBtoArray($this->ptmsagate->hostname,$this->ptmsagate->username,$this->ptmsagate->password,$this->ptmsagate->database,$dbdriver);
        $PHPJasperXML->outpage('I');  */
    }


}