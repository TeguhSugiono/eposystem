<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");

class C_daily_cont_shifting extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);        
        $this->mbatps = $this->load->database('mbatps', TRUE);     
    }

    function index() {
        $arraydata = array('Full' => 'Full','Empty' => 'Empty');
        $cont_status = ComboNonDb($arraydata, 'cont_status', 'AV', 'form-control form-control-sm');

        $arraydata = $this->ptmsagate->query("SELECT change_description,change_description 'change_description2' FROM t_t_cont_shifting where change_description <> '' GROUP BY change_description")->result_array();

        //array_push($arraydata, array('change_description' => '' , 'change_description2' => 'All'));
        //array_reverse($arraydata,true),

        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'change_description', 'class' => ''),
        );
        $change_description = ComboDb($createcombo);

        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'cont_status' => $cont_status,
            'change_description' => $change_description
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

    function c_tbl_daily_cont_shifting(){
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $code_principal = $this->input->post('code_principal');
        $cont_status = $this->input->post('cont_status');
        $change_description = $this->input->post('change_description');

        $query = " SELECT  cont_number,  " ;
        $query.= " case when dangers_goods = 'No' then ('')   else ('B') end as dangers, " ;
        $query.= " reff_code, cont_condition, cont_status, " ;
        $query.= " DATE_FORMAT(cont_date_in,'%d-%m-%Y') 'cont_date_in', old_location, new_location, new_cont_status,  " ;

        if($change_description == "Shifting"){

            $change_description = "date_shifting" ;
            $query.= " DATE_FORMAT(date_shifting,'%d-%m-%Y') 'transdate' " ;

        }else if($change_description == "Stripping"){

            $change_description = "date_stripping" ;
            $query.= " DATE_FORMAT(date_stripping,'%d-%m-%Y') 'transdate' " ;

        }else{

            $change_description = "date_stuffing" ;
            $query.= " DATE_FORMAT(date_stuffing,'%d-%m-%Y') 'transdate' " ;

        }


        $query.= " FROM  t_t_cont_shifting WHERE rec_id <> '9' " ;

        if($code_principal != ""){
            $query.= " and code_principal = '".$code_principal."' " ;
        }else{
            $query.= " and code_principal = 'Tidak Ada' " ;
        }

        if($cont_status != ""){
            $query.= " and cont_status = '".$cont_status."' " ;
        }

        if($change_description != ""){
            $query.= " and change_description = '".$this->input->post('change_description')."' " ;

            if($change_description == "date_shifting" ){
                if($startdate != ""){
                    $query.= " and DATE_FORMAT(".$change_description.",'%Y-%m-%d') >= '".date_db($startdate)."' " ;
                }

                if($enddate != ""){
                    $query.= " and DATE_FORMAT(".$change_description.",'%Y-%m-%d') <= '".date_db($enddate)."' " ;
                }
            }else{
                if($startdate != ""){
                    $query.= " and STR_TO_DATE(".$change_description.",'%d-%m-%Y') >= '".$startdate."' " ;
                }

                if($enddate != ""){
                    $query.= " and STR_TO_DATE(".$change_description.",'%d-%m-%Y') <= '".$enddate."' " ;
                }
            }


        }




        $query.= " ORDER BY  " ;

        if($change_description == "date_shifting"){
            $query.= " DATE_FORMAT(date_shifting,'%Y-%m-%d') asc, " ;
        }else if($change_description == "date_stripping"){
            $query.= " DATE_FORMAT(date_stripping,'%Y-%m-%d') asc, " ;
        }else{
            $query.= " DATE_FORMAT(date_stuffing,'%Y-%m-%d') asc, " ;
        }

        $query.= " reff_code, cont_status " ;


        

        $data = $this->ptmsagate->query($query)->result();


        $comp = array(
            'table_data' => $data
        );        
        echo json_encode($comp);

        
    }


    function c_print(){
        include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");
        
        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);
        

        $startdate = $data[0] ;
        $enddate = $data[1] ;
        $code_principal = $data[2] ;
        $cont_status = $data[3] ;
        $change_description = $data[4] ;
        $change_description_awal = $data[4] ;

        $code_principal = $data[5] ;
        $name_principal = $data[6] ;

        $query = " SELECT  cont_number,  " ;
        $query.= " case when dangers_goods = 'No' then ('')   else ('B') end as dangers, " ;
        $query.= " reff_code, cont_condition, cont_status, " ;
        $query.= " DATE_FORMAT(cont_date_in,'%d-%m-%Y') 'cont_date_in', old_location, new_location, new_cont_status,  " ;

        if($change_description == "Shifting"){

            $change_description = "date_shifting" ;
            $query.= " DATE_FORMAT(date_shifting,'%d-%m-%Y') 'transdate' " ;

        }else if($change_description == "Stripping"){

            $change_description = "date_stripping" ;
            $query.= " DATE_FORMAT(date_stripping,'%d-%m-%Y') 'transdate' " ;

        }else{

            $change_description = "date_stuffing" ;
            $query.= " DATE_FORMAT(date_stuffing,'%d-%m-%Y') 'transdate' " ;

        }


        $query.= " FROM  t_t_cont_shifting WHERE rec_id <> '9' " ;

        if($code_principal != ""){
            $query.= " and code_principal = '".$code_principal."' " ;
        }else{
            $query.= " and code_principal = 'Tidak Ada' " ;
        }

        if($cont_status != ""){
            $query.= " and cont_status = '".$cont_status."' " ;
        }

        if($change_description != ""){
            $query.= " and change_description = '".$data[4]."' " ;

            if($change_description == "date_shifting" ){
                if($startdate != ""){
                    $query.= " and DATE_FORMAT(".$change_description.",'%Y-%m-%d') >= '".date_db($startdate)."' " ;
                }

                if($enddate != ""){
                    $query.= " and DATE_FORMAT(".$change_description.",'%Y-%m-%d') <= '".date_db($enddate)."' " ;
                }
            }else{
                if($startdate != ""){
                    $query.= " and STR_TO_DATE(".$change_description.",'%d-%m-%Y') >= '".$startdate."' " ;
                }

                if($enddate != ""){
                    $query.= " and STR_TO_DATE(".$change_description.",'%d-%m-%Y') <= '".$enddate."' " ;
                }
            }


        }


        $query.= " ORDER BY  " ;

        if($change_description == "date_shifting"){
            $query.= " DATE_FORMAT(date_shifting,'%Y-%m-%d') asc, " ;
        }else if($change_description == "date_stripping"){
            $query.= " DATE_FORMAT(date_stripping,'%Y-%m-%d') asc, " ;
        }else{
            $query.= " DATE_FORMAT(date_stuffing,'%Y-%m-%d') asc, " ;
        }

        $query.= " reff_code, cont_status " ;

        // print_r($query);
        // die;      

        $data = $this->ptmsagate->query($query)->result_array();    



        $PHPJasperXML = new PHPJasperXML();
        //$PHPJasperXML->debugsql=true;
        $PHPJasperXML->arrayParameter=array(
            "parameter1"=>1,
            "tanggal_sekarang" => showdate_dmy(tanggal_sekarang()),
            "jam_sekarang" => jam_sekarang(),
            "username" => $this->session->userdata('autogate_username'),
            "startdate" => $startdate,
            "enddate" => $enddate,
            "code_principal" => strtoupper($code_principal),
            "name_principal" => strtoupper($name_principal),
            "change_description" => $change_description_awal
        );
        
        $path = APPPATH . 'modules/report_jasper/report_cont_shifting.jrxml'; 


        $PHPJasperXML->load_xml_file($path);
        $dbdriver="mysql";
        $PHPJasperXML->transferDBtoArray($this->ptmsagate->hostname,$this->ptmsagate->username,$this->ptmsagate->password,$this->ptmsagate->database,$dbdriver);
        $PHPJasperXML->arraysqltable=$data;
        $PHPJasperXML->outpage("I");             
    }

}