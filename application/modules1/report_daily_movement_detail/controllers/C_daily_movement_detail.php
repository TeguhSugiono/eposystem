<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_daily_movement_detail extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);        
        $this->mbatps = $this->load->database('mbatps', TRUE);     
    }

    function index() {

        $this->m_model->drop_temporary();

        $arraydata = array('Full' => 'Full','Empty' => 'Empty');
        $cont_status = ComboNonDb($arraydata, 'cont_status', 'AV', 'form-control form-control-sm');

        $arraydata = $this->ptmsagate->query("SELECT bc_code,bc_code 'bc_code2' FROM t_m_beacukaicode where rec_id=0 ORDER BY id_bc_code desc")->result_array();
        array_push($arraydata, array('bc_code' => '' , 'bc_code2' => 'All'));

        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'bc_code', 'class' => ''),
        );
        $bc_code = ComboDb($createcombo);

        $arraydata = array('In All' => 'In All','Out All' => 'Out All');
        $cont_movement = ComboNonDb($arraydata, 'cont_movement', 'In All', 'form-control form-control-sm');

        $arraydata = array('AV' => 'AV (Available)', 'DM' => 'DM (Damage)');
        $cont_condition = ComboNonDb($arraydata, 'cont_condition', 'AV', 'form-control form-control-sm');


        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'cont_status' => $cont_status,
            'bc_code' => $bc_code,
            'cont_movement' => $cont_movement,
            'cont_condition' => $cont_condition
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
    
    function c_create_title_thead(){
        $bc_code = $this->input->post('bc_code');
        $cont_movement = $this->input->post('cont_movement');

        if($bc_code == "" && $cont_movement == "In All"){
            $data = array('No','Container','Danger','Size/Type','Seal No','Bruto','Location','Date In','Time In','Truck No','Eir No','Date Eir');
        }else if($bc_code == "" && $cont_movement == "Out All"){
            $data = array('No','Container','Danger','Size/Type','Condition','Vessel/Voyage','Truck No','D/O No','Destination','Date In','Date Out','Time Out','Day Storage');
        }else if($bc_code != "" && $cont_movement == "In"){
            $data = array('No','Container','Danger','Size/Type','Condition','Vessel/Voyage','Shipper','Truck No','Location','Date In','Time In');
        }else if($bc_code != "" && $cont_movement == "Out"){
            $data = array('No','Container','Danger','Size/Type','Condition','Vessel/Voyage','Shipper','Truck No','D/O No','Seal No','Destination','Date In','Date Out','Day Storage');
        }

        

        $comp = array(
            'judul' => $data
        );        
        echo json_encode($comp);
    }


    function c_tbl_daily_movement_detail(){
        $a=0;
        $username = $this->session->userdata('autogate_username') ;
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $code_principal = $this->input->post('code_principal');
        $bc_code = $this->input->post('bc_code');
        $cont_movement = $this->input->post('cont_movement');
        $cont_condition = $this->input->post('cont_condition');
        $cont_status = $this->input->post('cont_status');

        if($bc_code == "" && $cont_movement == "In All"){

            $nama_table_1 = "view_cont_daily_movement_in_".$username ;

            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_1;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_1." AS ";
            $query.= " SELECT date_format(cont_date_in,'%d-%m-%Y') 'cont_date_in', cont_time_in, code_principal, cont_status, cont_number, reff_code, ";
            $query.= " cont_condition, vessel, shipper, invoice_in, plate, clean_type, ";
            $query.= " truck_number, bc_code, block_loc, location, dangers_goods , ";
            $query.= " case ";
            $query.= " when dangers_goods = 'No' then('') ";
            $query.= " when dangers_goods = 'DS' then('DS') ";
            $query.= " when dangers_goods = 'DL' then('DL') ";
            $query.= " else ('B') end as dangers,seal_number,no_eir,tgl_eir,bruto ";        
            $query.= " FROM t_t_entry_cont_in ";
            
            $query.= " WHERE cont_date_in >= '".date_db($startdate)."' and cont_date_in <='".date_db($enddate)."' ";
            $query.= " and code_principal = '".$code_principal."' and cont_status = '".$cont_status."' ";
            $query.= " and cont_condition = '".$cont_condition."' and rec_id ='0' ";

            $query.= " Order By bc_code, reff_code, cont_number ";
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $this->m_model->goto_temporary($nama_table_1);


            $nama_table_2 = "view_cont_daily_movement_in_detail_".$username ;

            $query = "";
            $query.= " DROP TABLE IF EXISTS test.".$nama_table_2;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_2." AS ";
            $query.= " SELECT code_principal, cont_status, reff_code, cont_condition, count(reff_code) As masuk ";
            
            $query.= " FROM t_t_entry_cont_in ";
            
            $query.= " WHERE cont_date_in >= '".date_db($startdate)."' and cont_date_in <='".date_db($enddate)."' ";
            $query.= " and code_principal = '".$code_principal."' and cont_status = '".$cont_status."' ";
            $query.= " and cont_condition = '".$cont_condition."' and rec_id = '0' ";
            $query.= " Group By reff_code ";
            $query.= " Order By cont_status, reff_code";
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_2);


            $query = " SELECT cont_number,dangers,reff_code,seal_number,bruto,location,cont_date_in,cont_time_in,truck_number,no_eir,tgl_eir from test.".$nama_table_1 ;

            $data = $this->ptmsagate->query($query)->result();
            $queryku[$a++] = $this->ptmsagate->last_query();

        }else if($bc_code == "" && $cont_movement == "Out All"){

            $nama_table_1 = "vw_gate_date_storage_daily_move_out_".$username ;

            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_1;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_1." AS ";
            $query.= " SELECT code_principal, cont_status, cont_condition, id_cont_out, " ;
            $query.= " date_format(cont_date_in,'%d-%m-%Y') 'cont_date_in', date_format(cont_date_out,'%d-%m-%Y') 'cont_date_out', cont_time_out, " ;
            $query.= " (To_days(cont_date_out) - TO_DAYS(cont_date_in) + 1) as storage " ;
            $query.= " FROM t_t_entry_cont_out " ;
            $query.= " WHERE cont_date_out >= '".date_db($startdate)."' and cont_date_out <= '".date_db($enddate)."' " ;
            $query.= " and code_principal = '".$code_principal."' and cont_status = '".$cont_status."' " ;
            $query.= " and cont_condition = '".$cont_condition."' and rec_id = '0' " ;
            $query.= " Order By cont_status " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $this->m_model->goto_temporary($nama_table_1);


            $nama_table_2 = "view_cont_daily_movement_out_".$username ;

            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_2;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_2." AS ";
            $query.= " SELECT date_format(a.cont_date_out,'%d-%m-%Y') 'cont_date_out', a.cont_time_out, date_format(a.cont_date_in,'%d-%m-%Y') 'cont_date_in', " ;
            $query.= " b.cont_time_in, a.code_principal, a.cont_status, a.cont_number, " ;
            $query.= " a.reff_code, a.cont_condition, a.vessel, a.shipper, a.invoice_in, a.truck_number, a.do_number, " ;
            $query.= " a.seal_number, a.destination, b.bc_code, b.bc_name, b.plate, b.clean_type, c.storage, a.dangers_goods, " ;
            $query.= " case " ;
            $query.= " when a.dangers_goods = 'No' then ('') " ;
            $query.= " when a.dangers_goods = 'DS' then ('DS') " ;
            $query.= " when a.dangers_goods = 'DL' then ('DL') " ;
            $query.= " else ('B') end as dangers " ;
            $query.= " FROM t_t_entry_cont_out As a " ;
            $query.= " left join t_t_entry_cont_in As b " ;
            $query.= " on a.bon_bongkar_number=b.bon_bongkar_number and a.cont_number=b.cont_number " ;
            $query.= " left join test.".$nama_table_1." As c " ;
            $query.= " on a.id_cont_out=c.id_cont_out " ;
            $query.= " WHERE a.cont_date_out >= '".date_db($startdate)."' and a.cont_date_out <='".date_db($enddate)."' " ;
            $query.= " and a.code_principal = '".$code_principal."' and a.cont_status = '".$cont_status."' " ;
            $query.= " and a.cont_condition = '".$cont_condition."' and a.rec_id = '0' and b.rec_id = '0' " ;
            $query.= " Order By b.bc_code, a.reff_code, a.cont_number " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_2);


            $nama_table_3 = "view_cont_daily_movement_out_all_detail_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_3;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();


            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_3." AS ";
            $query.= " SELECT code_principal, cont_status, reff_code, cont_condition, count(reff_code) As keluar " ;
            $query.= " FROM t_t_entry_cont_out " ;
            $query.= " WHERE cont_date_out >= '".date_db($startdate)."' and cont_date_out <='".date_db($enddate)."' " ;
            $query.= " and code_principal = '".$code_principal."' and cont_status = '".$cont_status."' " ;
            $query.= " and cont_condition = '".$cont_condition."' and rec_id = '0' " ;
            $query.= " Group By reff_code " ;
            $query.= " Order By cont_status, reff_code " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_3);

            $query = "";
            $query.= " SELECT cont_number,dangers,reff_code,cont_condition,vessel,truck_number, " ;
            $query.= " do_number,destination,cont_date_in,cont_date_out,cont_time_out,storage " ;
            $query.= " from test.".$nama_table_2  ;
            $data = $this->ptmsagate->query($query)->result();
            $queryku[$a++] = $this->ptmsagate->last_query();


        }else if($bc_code != "" && $cont_movement == "In"){

            $nama_table_1 = "view_cont_daily_movement_in_".$username ;

            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_1;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_1." AS ";
            $query.= " SELECT date_format(cont_date_in,'%d-%m-%Y') 'cont_date_in', cont_time_in, code_principal, cont_status, cont_number, reff_code, ";
            $query.= " cont_condition, vessel, shipper, invoice_in, plate, clean_type, ";
            $query.= " truck_number, bc_code, block_loc, location, dangers_goods , ";
            $query.= " case ";
            $query.= " when dangers_goods = 'No' then('') ";
            $query.= " when dangers_goods = 'DS' then('DS') ";
            $query.= " when dangers_goods = 'DL' then('DL') ";
            $query.= " else ('B') end as dangers,seal_number,no_eir,tgl_eir,bruto ";        
            $query.= " FROM t_t_entry_cont_in ";
            
            $query.= " WHERE cont_date_in >= '".date_db($startdate)."' and cont_date_in <='".date_db($enddate)."' ";
            $query.= " and code_principal = '".$code_principal."' and cont_status = '".$cont_status."' ";
            $query.= " and cont_condition = '".$cont_condition."' and bc_code='".$bc_code."' and rec_id ='0' ";


            $query.= " Order By bc_code, reff_code, cont_number ";
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $this->m_model->goto_temporary($nama_table_1);


            $nama_table_2 = "view_cont_daily_movement_in_detail_".$username ;

            $query = "";
            $query.= " DROP TABLE IF EXISTS test.".$nama_table_2;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_2." AS ";
            $query.= " SELECT code_principal, cont_status, reff_code, cont_condition, count(reff_code) As masuk ";
            
            $query.= " FROM t_t_entry_cont_in ";
            
            $query.= " WHERE cont_date_in >= '".date_db($startdate)."' and cont_date_in <='".date_db($enddate)."' ";
            $query.= " and code_principal = '".$code_principal."' and cont_status = '".$cont_status."' ";
            $query.= " and cont_condition = '".$cont_condition."' and bc_code='".$bc_code."' and rec_id = '0' ";
            $query.= " Group By reff_code ";
            $query.= " Order By cont_status, reff_code";
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_2);


            $query = " SELECT cont_number,dangers,reff_code,cont_condition,vessel,shipper,truck_number,location,cont_date_in,cont_time_in from test.".$nama_table_1 ;

            $data = $this->ptmsagate->query($query)->result();
            $queryku[$a++] = $this->ptmsagate->last_query();

        }else if($bc_code != "" && $cont_movement == "Out"){

            $nama_table_1 = "vw_gate_date_storage_daily_move_out_".$username ;

            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_1;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_1." AS ";
            $query.= " SELECT code_principal, cont_status, cont_condition, id_cont_out, " ;
            $query.= " date_format(cont_date_in,'%d-%m-%Y') 'cont_date_in', date_format(cont_date_out,'%d-%m-%Y') 'cont_date_out', cont_time_out, " ;
            $query.= " (To_days(cont_date_out) - TO_DAYS(cont_date_in) + 1) as storage " ;
            $query.= " FROM t_t_entry_cont_out " ;
            $query.= " WHERE cont_date_out >= '".date_db($startdate)."' and cont_date_out <= '".date_db($enddate)."' " ;
            $query.= " and code_principal = '".$code_principal."' and cont_status = '".$cont_status."' " ;
            $query.= " and cont_condition = '".$cont_condition."' and bc_code='".$bc_code."' and rec_id = '0' " ;
            $query.= " Order By cont_status " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $this->m_model->goto_temporary($nama_table_1);


            $nama_table_2 = "view_cont_daily_movement_out_".$username ;

            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_2;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_2." AS ";
            $query.= " SELECT date_format(a.cont_date_out,'%d-%m-%Y') 'cont_date_out', a.cont_time_out, date_format(a.cont_date_in,'%d-%m-%Y') 'cont_date_in', " ;
            $query.= " b.cont_time_in, a.code_principal, a.cont_status, a.cont_number, " ;
            $query.= " a.reff_code, a.cont_condition, a.vessel, a.shipper, a.invoice_in, a.truck_number, a.do_number, " ;
            $query.= " a.seal_number, a.destination, b.bc_code, b.bc_name, b.plate, b.clean_type, c.storage, a.dangers_goods, " ;
            $query.= " case " ;
            $query.= " when a.dangers_goods = 'No' then ('') " ;
            $query.= " when a.dangers_goods = 'DS' then ('DS') " ;
            $query.= " when a.dangers_goods = 'DL' then ('DL') " ;
            $query.= " else ('B') end as dangers " ;
            $query.= " FROM t_t_entry_cont_out As a " ;
            $query.= " left join t_t_entry_cont_in As b " ;
            $query.= " on a.bon_bongkar_number=b.bon_bongkar_number and a.cont_number=b.cont_number " ;
            $query.= " left join test.".$nama_table_1." As c " ;
            $query.= " on a.id_cont_out=c.id_cont_out " ;
            $query.= " WHERE a.cont_date_out >= '".date_db($startdate)."' and a.cont_date_out <='".date_db($enddate)."' " ;
            $query.= " and a.code_principal = '".$code_principal."' and a.cont_status = '".$cont_status."' " ;
            $query.= " and a.cont_condition = '".$cont_condition."' and a.bc_code='".$bc_code."' and a.rec_id = '0' and b.rec_id = '0' " ;
            $query.= " Order By b.bc_code, a.reff_code, a.cont_number " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_2);


            $nama_table_3 = "view_cont_daily_movement_out_all_detail_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_3;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();


            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_3." AS ";
            $query.= " SELECT code_principal, cont_status, reff_code, cont_condition, count(reff_code) As keluar " ;
            $query.= " FROM t_t_entry_cont_out " ;
            $query.= " WHERE cont_date_out >= '".date_db($startdate)."' and cont_date_out <='".date_db($enddate)."' " ;
            $query.= " and code_principal = '".$code_principal."' and cont_status = '".$cont_status."' " ;
            $query.= " and cont_condition = '".$cont_condition."' and bc_code='".$bc_code."' and rec_id = '0' " ;
            $query.= " Group By reff_code " ;
            $query.= " Order By cont_status, reff_code " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_3);

            $query = "";
            $query.= " SELECT cont_number,dangers,reff_code,cont_condition,vessel,truck_number, " ;
            $query.= " do_number,destination,cont_date_in,cont_date_out,cont_time_out,storage " ;
            $query.= " from test.".$nama_table_2  ;
            $data = $this->ptmsagate->query($query)->result();
            $queryku[$a++] = $this->ptmsagate->last_query();

        }

        $comp = array(
            'queryku' => $queryku,
            'table_data' => $data
        );        
        echo json_encode($comp);
    }

    function c_print() {
        //keterangan "\n" untuk pindah baris baru
        include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");

        $username = $this->session->userdata('autogate_username') ;
        $nama_table_1 = "" ;
        $nama_table_2 = "" ;
        $path = "" ;
        $path_subreport = "" ;
        
        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);

        $startdate = $data[0] ;
        $enddate = $data[1] ;
        $code_principal = $data[2] ;
        $bc_code = $data[3] ;
        $cont_movement = $data[4] ;
        $cont_condition = $data[5] ;
        $cont_status = $data[6] ;

        $masuk = '' ;
        if($bc_code == "" && $cont_movement == "In All"){

            $nama_table_1 = "test.view_cont_daily_movement_in_".$username ;
            $nama_table_2 = "test.view_cont_daily_movement_in_detail_".$username ;
            $path = APPPATH . 'modules/report_jasper/report_daily_movement_in_all.jrxml'; 
            $path_subreport =  APPPATH . 'modules/report_jasper/'; 
            $masuk = 'masuk' ;

        }else if($bc_code == "" && $cont_movement == "Out All"){

            $nama_table_1 = "test.view_cont_daily_movement_out_".$username ;
            $nama_table_2 = "test.view_cont_daily_movement_out_all_detail_".$username ;
            $path = APPPATH . 'modules/report_jasper/report_daily_movement_out_all.jrxml';
            $path_subreport =  APPPATH . 'modules/report_jasper/'; 
            $masuk = 'keluar' ;

        }else if($bc_code != "" && $cont_movement == "In"){

            $nama_table_1 = "test.view_cont_daily_movement_in_".$username ;
            $nama_table_2 = "test.view_cont_daily_movement_in_detail_".$username ;
            $path = APPPATH . 'modules/report_jasper/report_daily_movement_in.jrxml'; 
            $path_subreport =  APPPATH . 'modules/report_jasper/'; 
            $masuk = 'masuk' ;
            
        }else if($bc_code != "" && $cont_movement == "Out"){

            $nama_table_1 = "test.view_cont_daily_movement_out_".$username ;
            $nama_table_2 = "test.view_cont_daily_movement_out_all_detail_".$username ;
            $path = APPPATH . 'modules/report_jasper/report_daily_movement_out.jrxml';
            $path_subreport =  APPPATH . 'modules/report_jasper/'; 
            $masuk = 'keluar' ;
            
        }



        $data_1 = $this->ptmsagate->query(" SELECT * FROM ".$nama_table_1." ")->result_array() ;
        
        $PHPJasperXML = new PHPJasperXML("en","TCPDF"); 

        

        $data_2 = $this->ptmsagate->query("SELECT * FROM ".$nama_table_2." ")->result_array();

        $subreport_status = "" ;
        $subreport_size = "" ;
        $subreport_condition = "" ;
        $subreport_masuk = "" ;
        $garis="" ;
        foreach($data_2 as $row){
            $subreport_status.= $row['cont_status']."\n" ;
            $subreport_size.= $row['reff_code']."\n" ;
            $subreport_condition.= $row['cont_condition']."\n" ;
            $subreport_masuk.= $row[$masuk]."\n" ;
            $garis.="\n" ;
        }
        $garis.="===============================================";

        $PHPJasperXML->arrayParameter = array(
            "principal" => strtoupper($code_principal),
            "condition" => strtoupper($cont_condition),
            "username" => $this->session->userdata('autogate_username'),
            "dateawal" => $startdate,
            "dateakhir" => $enddate,
            "status" => $cont_status,
            "subreport_status" => $subreport_status,
            "subreport_size" => $subreport_size,
            "subreport_condition" => $subreport_condition,
            "subreport_masuk" => $subreport_masuk,
            "garis" => $garis,
            "jam_sekarang" => jam_sekarang(),
            "tanggal_sekarang" => showdate_dmy(tanggal_sekarang()),
            "SUBREPORT_DIR" => $path_subreport,
        );

        
        //$PHPJasperXML->debugsql=true;   
        $PHPJasperXML->load_xml_file($path);
        $dbdriver="mysql";
        $version="1.1";
        $PHPJasperXML->transferDBtoArray($this->ptmsagate->hostname,$this->ptmsagate->username,$this->ptmsagate->password,$this->ptmsagate->database,$dbdriver);
        $PHPJasperXML->arraysqltable=$data_1;
        $PHPJasperXML->outpage('I');  


    }


    function c_export() {
        $username = $this->session->userdata('autogate_username') ;
        $nama_table_1 = "" ;
        $nama_table_2 = "" ;
        $path = "" ;
        $path_subreport = "" ;
        
        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);

        $startdate = $data[0] ;
        $enddate = $data[1] ;
        $code_principal = $data[2] ;
        $bc_code = $data[3] ;
        $cont_movement = $data[4] ;
        $cont_condition = $data[5] ;
        $cont_status = $data[6] ;
        
        $nama_excel = "" ;
        

        if($bc_code == "" && $cont_movement == "In All"){

            $nama_table_1 = "test.view_cont_daily_movement_in_".$username ;
            $nama_table_2 = "test.view_cont_daily_movement_in_detail_".$username ;

            $nama_excel = "Report_Daily_Movement_In_All_".tanggal_sekarang() ;

            $query = "  select 'nomor' as 'No',cont_number 'Container No' ,dangers 'Dangers', reff_code 'Size' , seal_number 'Condition', bruto 'Bruto' ,
                        concat(block_loc,' ',location) 'Location' , cont_date_in 'Date In', cont_time_in 'Time In', truck_number 'Truck No', 
                        no_eir 'EIR No', tgl_eir 'Date EIR' from ".$nama_table_1." " ;
            $data1 = $this->ptmsagate->query($query)->result_array();

            $query = "  select cont_status 'STATUS',reff_code 'SIZE',cont_condition 'CONDITION',masuk 'TOTAL' from ".$nama_table_2." " ;
            $data2 = $this->ptmsagate->query($query)->result_array();

        }else if($bc_code == "" && $cont_movement == "Out All"){

            $nama_table_1 = "test.view_cont_daily_movement_out_".$username ;
            $nama_table_2 = "test.view_cont_daily_movement_out_all_detail_".$username ;

            $nama_excel = "Report_Daily_Movement_Out_All_".tanggal_sekarang() ;

            $query = "  SELECT 'nomor' as 'No',cont_number 'Container No',dangers 'Dangers' , reff_code 'Size',
                        cont_condition 'Condition', vessel 'Vessel/Voyage', truck_number 'Truck No',
                        do_number 'D/O No', destination 'Destination', cont_date_in 'Date In',
                        cont_date_out 'Date Out', cont_time_out 'Time Out', storage 'Day' from ".$nama_table_1." " ;
            $data1 = $this->ptmsagate->query($query)->result_array();

            $query = "  select cont_status 'STATUS',reff_code 'SIZE',cont_condition 'CONDITION',keluar 'TOTAL' from ".$nama_table_2." " ;
            $data2 = $this->ptmsagate->query($query)->result_array();

        }else if($bc_code != "" && $cont_movement == "In"){

            $nama_table_1 = "test.view_cont_daily_movement_in_".$username ;
            $nama_table_2 = "test.view_cont_daily_movement_in_detail_".$username ;

            $nama_excel = "Report_Daily_Movement_In_bccode_".tanggal_sekarang() ;
            
            $query = "  select 'nomor' as 'No',cont_number 'Container No',dangers 'Dangers' , reff_code 'Size',
                        cont_condition 'Condition', vessel 'Vessel/Voyage', shipper 'Shipper', truck_number 'Truck No',
                        concat(block_loc,' ',location) 'Location',cont_date_in 'Date In' ,cont_time_in 'Time In' from ".$nama_table_1." " ;
            $data1 = $this->ptmsagate->query($query)->result_array();

            $query = "  select cont_status 'STATUS',reff_code 'SIZE',cont_condition 'CONDITION',masuk 'TOTAL' from ".$nama_table_2." " ;
            $data2 = $this->ptmsagate->query($query)->result_array();

        }else if($bc_code != "" && $cont_movement == "Out"){

            $nama_table_1 = "test.view_cont_daily_movement_out_".$username ;
            $nama_table_2 = "test.view_cont_daily_movement_out_all_detail_".$username ;

            $nama_excel = "Report_Daily_Movement_Out_bccode_".tanggal_sekarang() ;

            $query = "  SELECT 'nomor' as 'No',cont_number'Container No',dangers 'Dangers' , reff_code 'Size',
                        cont_condition 'Condition', vessel 'Vessel/Voyage', shipper 'Shipper',
                        truck_number 'Truck No',do_number 'D/O No', seal_number 'Seal No',
                        destination 'Destination', cont_date_in 'Date In',
                        cont_date_out 'Date Out', storage 'Day'  from ".$nama_table_1." " ;
            $data1 = $this->ptmsagate->query($query)->result_array();

            $query = "  select cont_status 'STATUS',reff_code 'SIZE',cont_condition 'CONDITION',keluar 'TOTAL' from ".$nama_table_2." " ;
            $data2 = $this->ptmsagate->query($query)->result_array();
            
        }


        //Setting Sheet Excel
        $nama_sheet = array(
            '0' => 'Daily Movement Report',
            '1' => 'Movement Recapitulation'
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
        $this->m_model->generator_xls($setting_xls);

        

    }
    
}