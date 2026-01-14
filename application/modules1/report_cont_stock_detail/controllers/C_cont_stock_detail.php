<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class C_cont_stock_detail extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);        
        $this->mbatps = $this->load->database('mbatps', TRUE);     
    }

    function index(){
        $this->m_model->drop_temporary();

        $menu_active = $this->m_model->menu_active();

        $arraydata = $this->ptmsagate->query("SELECT code_principal,CONCAT(code_principal,' - ',name_principal) as 'name_principal' FROM t_m_principal where rec_id=0")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'code_principal', 'class' => 'selectpicker'),
        );

        $arraydata = array('Full' => 'Full','Empty' => 'Empty');
        $cont_status = ComboNonDb($arraydata, 'cont_status', 'AV', 'form-control form-control-sm');

        $arraydata = array('C' => 'Container','D' => 'Day');
        $cbosort = ComboNonDb($arraydata, 'cbosort', 'C', 'form-control form-control-sm');

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'code_principal' => ComboDb($createcombo),
            'cont_status' => $cont_status,
            'cbosort' => $cbosort
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_proses(){
        $this->m_model->drop_temporary();

        $username = $this->session->userdata('autogate_username') ;
        $startdate = date_db($this->input->post('startdate'));
        $enddate = date_db($this->input->post('enddate'));
        $code_principal = $this->input->post('code_principal');
        $cont_status = $this->input->post('cont_status');
        $cbosort = $this->input->post('cbosort');
        //$name_principal = $this->input->post('name_principal');

        $a=0;

        $pesan_data = array(
            'msg'   => 'Tidak',
            'pesan' => 'Proses data gagal...'
        );

        if($cont_status == "Empty" && $cbosort == "C"){

            $nama_table_1 = "vw_gate_date_storage_stock_detail_storage_day_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_1;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_1." AS ";
            $query.= " SELECT code_principal, cont_status, cont_number, id_stock, cont_date_in, cont_date_out, " ;
            $query.= " case when cont_date_out is null" ;
            $query.= " then(To_days(now()) - TO_DAYS(cont_date_in) + 1) else (To_days(cont_date_out) - TO_DAYS(cont_date_in) + 1) end as storage_day " ;
            $query.= " FROM t_t_stock WHERE code_principal = '".$code_principal."'  " ;
            $query.= " and (((cont_date_in <= '".$enddate."' and rec_id = '0') or cont_date_out >= '".$enddate."')  " ;
            $query.= " or cont_date_in = '".$enddate."') and cont_status = '".$cont_status."' " ;
            $query.= " ORDER BY cont_number " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_1);


            $nama_table_2 = "vw_gate_date_storage_stock_detail_storage_dt_stripping_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_2;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_2." AS ";
            $query.= " SELECT STR_TO_DATE(date_stripping, '%d-%m-%Y') as dt_stripping, date_stripping, id_stock, " ;
            $query.= " code_principal, cont_status, cont_number, cont_date_in, cont_date_out " ;
            $query.= " FROM t_t_stock WHERE code_principal = '".$code_principal."' " ;
            $query.= " and (((cont_date_in <= '".$enddate."' and rec_id = '0') or cont_date_out >= '".$enddate."') " ;
            $query.= " or cont_date_in = '".$enddate."') and cont_status = '".$cont_status."' ORDER BY cont_number " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_2);

 

            $nama_table_3 = "vw_gate_date_storage_stock_detail_storage_stripping_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_3;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_3." AS ";
            $query.= " SELECT a.code_principal, a.cont_status, a.cont_number, a.id_stock, a.cont_date_in, a.cont_date_out, " ;
            $query.= " a.date_stripping, b.dt_stripping, ifnull(case when a.cont_date_out is null and a.date_stripping is not null " ;
            $query.= " then (To_days(now()) - TO_DAYS(b.dt_stripping) + 1) when a.date_stripping is null " ;
            $query.= " and a.cont_date_out is null  then (To_days(now()) - TO_DAYS(a.cont_date_in) + 1) " ;
            $query.= " else (To_days(a.cont_date_out) - TO_DAYS(b.dt_stripping) + 1) end, 0) as storage_stripping " ;
            $query.= " FROM t_t_stock as a left join test.".$nama_table_2." as b on a.id_stock=b.id_stock " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and (((a.cont_date_in <= '".$enddate."' and a.rec_id = '0') " ;
            $query.= " or a.cont_date_out >= '".$enddate."') or a.cont_date_in = '".$enddate."') and a.cont_status = '".$cont_status."' " ;
            $query.= " ORDER BY a.cont_number " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_3);




            $nama_table_4 = "vw_gate_date_storage_stock_detail_storage_dt_stuffing_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_4;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_4." AS ";
            $query.= " SELECT STR_TO_DATE(date_stuffing, '%d-%m-%Y') as dt_stuffing, date_stuffing, id_stock, " ;
            $query.= " code_principal, cont_status, cont_number, cont_date_in, cont_date_out " ;
            $query.= " FROM t_t_stock WHERE code_principal = '".$code_principal."' " ;
            $query.= " and (((cont_date_in <= '".$enddate."' and rec_id = '0') or cont_date_out >= '".$enddate."') " ;
            $query.= " or cont_date_in = '".$enddate."') and cont_status = '".$cont_status."' " ;
            $query.= " ORDER BY cont_number " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_4);


            $nama_table_5 = "vw_gate_date_storage_stock_detail_storage_stuffing_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_5;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();



            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_5." AS ";
            $query.= " SELECT a.code_principal, a.cont_status, a.cont_number, a.id_stock, a.cont_date_in, a.cont_date_out, a.date_stuffing, b.dt_stuffing, " ;
            $query.= " ifnull(case when a.cont_date_out is null and a.date_stuffing is not null " ;
            $query.= " then (To_days(now()) - TO_DAYS(b.dt_stuffing) + 1) when a.date_stuffing is null " ;
            $query.= " and a.cont_date_out is null  then (To_days(now()) - TO_DAYS(a.cont_date_in) + 1) " ;
            $query.= " else (To_days(a.cont_date_out) - TO_DAYS(b.dt_stuffing) + 1) end, 0) as storage_stuffing " ;
            $query.= " FROM t_t_stock as a left join test.".$nama_table_4." as b on a.id_stock=b.id_stock " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and (((a.cont_date_in <= '".$enddate."' and a.rec_id = '0') " ;
            $query.= " or a.cont_date_out >= '".$enddate."') or a.cont_date_in = '".$enddate."') and a.cont_status = '".$cont_status."' " ;
            $query.= " ORDER BY a.cont_number " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_5);

 


            $nama_table_6 = "view_cont_stock_detail_sort_by_cont_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_6;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_6." AS ";
            $query.= " SELECT a.code_principal, a.name_principal, a.cont_number, a.reff_code, a.cont_condition, " ;
            $query.= " a.vessel, a.cont_date_in, a.cont_date_out, a.date_shifting, a.date_stripping, a.date_stuffing, a.block_loc, " ;
            $query.= " a.location, a.ship_line_code, a.bc_code, a.cont_status, ifnull(b.storage_day, 0) as  storage_day, " ;
            $query.= " ifnull(c.storage_stripping, 0) as storage_stripping, ifnull(d.storage_stuffing, 0) as storage_stuffing, " ;
            $query.= " a.dangers_goods, case when a.dangers_goods = 'No' then ('') when a.dangers_goods = 'DS' then ('DS') " ;
            $query.= " when a.dangers_goods = 'DL' then ('DL') else ('B') end as dangers " ;
            $query.= " FROM t_t_stock As a left join test.".$nama_table_1." As b on a.id_stock=b.id_stock " ;
            $query.= " left join test.".$nama_table_3." As c on a.id_stock=c.id_stock " ;
            $query.= " left join test.".$nama_table_5." As d on a.id_stock=d.id_stock " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and (((a.cont_date_in <= '".$enddate."' and a.rec_id = '0') " ;
            $query.= " or a.cont_date_out >= '".$enddate."') or a.cont_date_in = '".$enddate."') " ;
            $query.= " and a.cont_status = '".$cont_status."' " ;
            $query.= " ORDER BY a.cont_number " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_6);



            $nama_table_7 = "view_cont_stock_detail_beg_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_7;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_7." AS ";
            $query.= " SELECT distinct a.code_principal, a.name_principal, b.cont_number, b.cont_condition, b.reff_code, " ;
            $query.= " b.cont_status, count(b.reff_code) as beg  " ;
            $query.= " FROM t_m_principal as a left join t_t_stock as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and (((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') " ;
            $query.= " or b.cont_date_out >= '".$enddate."') or b.cont_date_in = '".$enddate."') " ;
            $query.= " and b.cont_status = '".$cont_status."' and a.rec_id = '0' " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_7);




            $nama_table_8 = "view_cont_stock_detail_in_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_8;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_8." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_number, b.cont_condition, " ;
            $query.= " b.reff_code, b.new_cont_status, count(b.reff_code) as masuk " ;
            $query.= " FROM t_m_principal as a left join t_t_entry_cont_in as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and b.cont_date_in = '".$enddate."' and b.cont_status = '".$cont_status."' " ;
            $query.= " and a.rec_id = '0' and b.rec_id = '0' " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_8);



            $nama_table_9 = "view_cont_stock_detail_out_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_9;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_9." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_number, b.cont_condition, b.reff_code, " ;
            $query.= " b.cont_status, count(b.reff_code) as keluar " ;
            $query.= " FROM t_m_principal as a left join t_t_entry_cont_out as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and b.cont_date_out = '".$enddate."' and b.cont_status = '".$cont_status."' " ;
            $query.= " and a.rec_id = '0' and b.rec_id = '0' " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_9);

             

            $nama_table_10 = "view_cont_stock_detail_detail_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_10;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_10." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_condition, b.reff_code, b.cont_status, " ;
            $query.= " ifnull(b.beg, 0) as beg, ifnull(c.masuk, 0) as masuk, ifnull(d.keluar, 0) as keluar " ;
            $query.= " FROM t_m_principal as a left join test.".$nama_table_7." as b on a.code_principal=b.code_principal " ;
            $query.= " left join test.".$nama_table_8." as c on a.code_principal=c.code_principal and b.reff_code=c.reff_code " ;
            $query.= " left join test.".$nama_table_9." as d on a.code_principal=d.code_principal and b.reff_code=d.reff_code " ;
            $query.= " WHERE (b.cont_status=c.new_cont_status and((b.cont_number=c.cont_number) " ;
            $query.= " or (b.cont_number=d.cont_number))) or a.code_principal=b.code_principal " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_10);



            $nama_table_11 = "view_cont_stock_detail_detail_stock_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_11;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_11." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_condition, b.reff_code, b.cont_status, " ;
            $query.= " ifnull(b.beg - b.masuk, 0) as beg, ifnull(b.masuk, 0) as masuk, ifnull(b.keluar, 0) as keluar " ;
            $query.= " FROM t_m_principal as a left join test.".$nama_table_10." as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a. rec_id = '0' and b.reff_code is not null " ;
            $query.= " Group by a.code_principal, b.reff_code, b.cont_status, b.cont_condition " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_11);



            $nama_table_12 = "view_cont_stock_detail_detail_stock_final_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_12;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();



            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_12." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_condition, b.reff_code, b.cont_status, " ;
            $query.= " ifnull(b.beg, 0) as beg, ifnull(b.masuk, 0) as masuk, ifnull(b.keluar, 0) as keluar, ifnull((b.beg + b.masuk) - b.keluar, 0) as total " ;
            $query.= " FROM t_m_principal as a left join test.".$nama_table_11." as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a. rec_id = '0' and b.reff_code is not null " ;
            $query.= " Group by a.code_principal, b.reff_code, b.cont_status, b.cont_condition " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_12);


            $pesan_data = array(
                'msg'   => 'Ya',
                'pesan' => 'Proses data berhasil...'
            );

        }else if($cont_status == "Empty" && $cbosort == "D"){

            $nama_table_1 = "vw_gate_date_storage_stock_detail_storage_day_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_1;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_1." AS ";
            $query.= " SELECT code_principal, cont_status, cont_number, id_stock, cont_date_in, cont_date_out, date_shifting, " ;
            $query.= " case when cont_date_out is null then(To_days(now()) - TO_DAYS(cont_date_in) + 1) " ;
            $query.= " else (To_days(cont_date_out) - TO_DAYS(cont_date_in) + 1) end as storage_day " ;
            $query.= " FROM t_t_stock WHERE code_principal = '".$code_principal."' " ;
            $query.= " and (((cont_date_in <= '".$enddate."' and rec_id = '0') or cont_date_out >= '".$enddate."') " ;
            $query.= " or cont_date_in = '".$enddate."') and cont_status = '".$cont_status."' " ;
            $query.= " ORDER BY date_shifting Desc " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_1);



            $nama_table_2 = "vw_gate_date_storage_stock_detail_storage_dt_stripping_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_2;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_2." AS ";
            $query.= " SELECT STR_TO_DATE(date_stripping, '%d-%m-%Y') as dt_stripping, date_stripping, id_stock, " ;
            $query.= " code_principal, cont_status, cont_number, cont_date_in, cont_date_out " ;
            $query.= " FROM t_t_stock WHERE code_principal = '".$code_principal."' " ;
            $query.= " and (((cont_date_in <= '".$enddate."' and rec_id = '0') or cont_date_out >= '".$enddate."') " ;
            $query.= " or cont_date_in = '".$enddate."') and cont_status = '".$cont_status."' " ;
            $query.= " ORDER BY date_stripping Asc " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_2);



            $nama_table_3 = "vw_gate_date_storage_stock_detail_storage_stripping_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_3;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_3." AS ";
            $query.= " SELECT a.code_principal, a.cont_status, a.cont_number, a.id_stock, a.cont_date_in, a.cont_date_out, " ;
            $query.= " a.date_stripping, b.dt_stripping, ifnull(case when a.cont_date_out is null and a.date_stripping is not null " ;
            $query.= " then (To_days(now()) - TO_DAYS(b.dt_stripping) + 1) when a.date_stripping is null and a.cont_date_out is null  " ;
            $query.= " then (To_days(now()) - TO_DAYS(a.cont_date_in) + 1) " ;
            $query.= " else (To_days(a.cont_date_out) - TO_DAYS(b.dt_stripping) + 1) end, 0) as storage_stripping " ;
            $query.= " FROM t_t_stock as a left join test.".$nama_table_2." as b on a.id_stock=b.id_stock " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and (((a.cont_date_in <= '".$enddate."' and a.rec_id = '0') " ;
            $query.= " or a.cont_date_out >= '".$enddate."') or a.cont_date_in = '".$enddate."') " ;
            $query.= " and a.cont_status = '".$cont_status."' " ;
            $query.= " ORDER BY a.date_stripping Asc " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_3);



            $nama_table_4 = "vw_gate_date_storage_stock_detail_storage_dt_stuffing_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_4;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_4." AS ";
            $query.= " SELECT STR_TO_DATE(date_stuffing, '%d-%m-%Y') as dt_stuffing, date_stuffing, id_stock, code_principal, cont_status, " ;
            $query.= " cont_number, cont_date_in, cont_date_out FROM t_t_stock WHERE code_principal = '".$code_principal."' " ;
            $query.= " and (((cont_date_in <= '".$enddate."' and rec_id = '0') or cont_date_out >= '".$enddate."') " ;
            $query.= " or cont_date_in = '".$enddate."') and cont_status = '".$cont_status."' " ;
            $query.= " ORDER BY date_stuffing Asc " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_4);



            $nama_table_5 = "vw_gate_date_storage_stock_detail_storage_stuffing_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_5;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_5." AS ";
            $query.= " SELECT a.code_principal, a.cont_status, a.cont_number, a.id_stock, a.cont_date_in, a.cont_date_out, " ;
            $query.= " a.date_stuffing, b.dt_stuffing, ifnull(case when a.cont_date_out is null and a.date_stuffing is not null " ;
            $query.= " then (To_days(now()) - TO_DAYS(b.dt_stuffing) + 1) when a.date_stuffing is null and a.cont_date_out is null  " ;
            $query.= " then (To_days(now()) - TO_DAYS(a.cont_date_in) + 1) " ;
            $query.= " else (To_days(a.cont_date_out) - TO_DAYS(b.dt_stuffing) + 1) end, 0) as storage_stuffing " ;
            $query.= " FROM t_t_stock as a left join test.".$nama_table_4." as b on a.id_stock=b.id_stock " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and (((a.cont_date_in <= '".$enddate."' and a.rec_id = '0') " ;
            $query.= " or a.cont_date_out >= '".$enddate."') or a.cont_date_in = '".$enddate."') and a.cont_status = '".$cont_status."' " ;
            $query.= " ORDER BY a.date_stuffing Asc " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_5);



            $nama_table_6 = "view_cont_stock_detail_sort_by_date_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_6;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_6." AS ";
            $query.= " SELECT a.code_principal, a.name_principal, a.cont_number, a.reff_code, a.cont_condition, a.vessel, " ;
            $query.= " a.cont_date_in, a.cont_date_out, a.date_shifting, a.date_stripping, a.date_stuffing, a.block_loc, " ;
            $query.= " a.location, a.ship_line_code, a.bc_code, a.cont_status, ifnull(b.storage_day, 0) as storage_day, " ;
            $query.= " ifnull(c.storage_stripping, 0) as storage_stripping, ifnull(d.storage_stuffing, 0) as storage_stuffing, " ;
            $query.= " a.dangers_goods, case when a.dangers_goods = 'No' then ('') when a.dangers_goods = 'DS' then ('DS') " ;
            $query.= " when a.dangers_goods = 'DL' then ('DL') else ('B') end as dangers " ;
            $query.= " FROM t_t_stock As a left join test.".$nama_table_1." As b on a.id_stock=b.id_stock " ;
            $query.= " left join test.".$nama_table_3." As c on a.id_stock=c.id_stock " ;
            $query.= " left join test.".$nama_table_5." As d on a.id_stock=d.id_stock " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and (((a.cont_date_in <= '".$enddate."' and a.rec_id = '0') " ;
            $query.= " or a.cont_date_out >= '".$enddate."') or a.cont_date_in = '".$enddate."') " ;
            $query.= " and a.cont_status = '".$cont_status."' " ;
            $query.= " ORDER BY a.date_stripping Desc " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_6);



            $nama_table_7 = "view_cont_stock_detail_beg_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_7;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_7." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_number, b.cont_condition, b.reff_code, " ;
            $query.= " b.cont_status, count(b.reff_code) as beg " ;
            $query.= " FROM t_m_principal as a left join t_t_stock as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and (((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') " ;
            $query.= " or b.cont_date_out >= '".$enddate."') or b.cont_date_in = '".$enddate."') and b.cont_status = '".$cont_status."' and a.rec_id = '0' " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_7);




            $nama_table_8 = "view_cont_stock_detail_in_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_8;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_8." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_number, b.cont_condition, b.reff_code, " ;
            $query.= " b.new_cont_status, count(b.reff_code) as masuk  " ;
            $query.= " FROM t_m_principal as a left join t_t_entry_cont_in as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and b.cont_date_in = '".$enddate."' and b.cont_status = '".$cont_status."'  " ;
            $query.= " and a.rec_id = '0' and b.rec_id = '0' " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_8);



            $nama_table_9 = "view_cont_stock_detail_out_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_9;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_9." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_number, b.cont_condition, " ;
            $query.= " b.reff_code, b.cont_status, count(b.reff_code) as keluar " ;
            $query.= " FROM t_m_principal as a left join t_t_entry_cont_out as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and b.cont_date_out = '".$enddate."' " ;
            $query.= " and b.cont_status = '".$cont_status."' and a.rec_id = '0' and b.rec_id = '0' " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_9);



            $nama_table_10 = "view_cont_stock_detail_detail_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_10;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();



            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_10." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_condition, b.reff_code, " ;
            $query.= " b.cont_status, ifnull(b.beg, 0) as beg, ifnull(c.masuk, 0) as masuk, ifnull(d.keluar, 0) as keluar " ;
            $query.= " FROM t_m_principal as a " ;
            $query.= " left join test.".$nama_table_7."  as b on a.code_principal=b.code_principal " ;
            $query.= " left join test.".$nama_table_8." as c on a.code_principal=c.code_principal and b.reff_code=c.reff_code " ;
            $query.= " left join test.".$nama_table_9." as d on a.code_principal=d.code_principal and b.reff_code=d.reff_code " ;
            $query.= " WHERE (b.cont_status=c.new_cont_status and((b.cont_number=c.cont_number) " ;
            $query.= " or (b.cont_number=d.cont_number))) or a.code_principal=b.code_principal " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal" ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_10);



            $nama_table_11 = "view_cont_stock_detail_detail_stock_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_11;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();


            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_11." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_condition, b.reff_code, b.cont_status, " ;
            $query.= " ifnull(b.beg - b.masuk, 0) as beg, ifnull(b.masuk, 0) as masuk, ifnull(b.keluar, 0) as keluar " ;
            $query.= " FROM t_m_principal as a " ;
            $query.= " left join test.".$nama_table_10." as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a. rec_id = '0' and b.reff_code is not null " ;
            $query.= " Group by a.code_principal, b.reff_code, b.cont_status, b.cont_condition " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_11);



            $nama_table_12 = "view_cont_stock_detail_detail_stock_final_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_12;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_12." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_condition, b.reff_code, " ;
            $query.= " b.cont_status, ifnull(b.beg, 0) as beg, ifnull(b.masuk, 0) as masuk, ifnull(b.keluar, 0) as keluar, " ;
            $query.= " ifnull((b.beg + b.masuk) - b.keluar, 0) as total " ;
            $query.= " FROM t_m_principal as a " ;
            $query.= " left join test.".$nama_table_11." as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a. rec_id = '0' and b.reff_code is not null " ;
            $query.= " Group by a.code_principal, b.reff_code, b.cont_status, b.cont_condition " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_12);

            $pesan_data = array(
                'msg'   => 'Ya',
                'pesan' => 'Proses data berhasil...'
            );

        }else if($cont_status == "Full" && $cbosort == "C"){


            $nama_table_1 = "vw_gate_date_storage_stock_detail_storage_day_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_1;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_1." AS ";
            $query.= " SELECT code_principal, cont_status, cont_number, id_stock, cont_date_in, cont_date_out, " ;
            $query.= " case when cont_date_out is null then(To_days(now()) - TO_DAYS(cont_date_in) + 1) " ;
            $query.= " else (To_days(cont_date_out) - TO_DAYS(cont_date_in) + 1) end as storage_day " ;
            $query.= " FROM t_t_stock  " ;
            $query.= " where ((DATE_FORMAT(cont_date_in,'%Y-%m-%d') <= ('".$enddate."'-INTERVAL 1 DAY)  AND rec_id = '0')  " ;
            $query.= " or (DATE_FORMAT(cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  " ;
            $query.= " and DATE_FORMAT(cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND rec_id <> '9')) " ;
            $query.= " and code_principal='".$code_principal."' and cont_status='".$cont_status."'  " ;
            $query.= " ORDER BY cont_number " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_1);



            $nama_table_2 = "vw_gate_date_storage_stock_detail_storage_dt_stripping_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_2;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_2." AS ";
            $query.= " SELECT STR_TO_DATE(date_stripping, '%d-%m-%Y') as dt_stripping, date_stripping, id_stock, " ;
            $query.= " code_principal, cont_status, cont_number, cont_date_in, cont_date_out " ;
            $query.= " FROM t_t_stock  " ;
            $query.= " where ((DATE_FORMAT(cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  AND rec_id = '0')  " ;
            $query.= " or (DATE_FORMAT(cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  " ;
            $query.= " and DATE_FORMAT(cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND rec_id <> '9')) " ;
            $query.= " and code_principal='".$code_principal."' and cont_status='".$cont_status."' " ;
            $query.= " ORDER BY cont_number " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_2);


        

            $nama_table_3 = "vw_gate_date_storage_stock_detail_storage_stripping_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_3;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_3." AS ";
            $query.= " SELECT a.code_principal, a.cont_status, a.cont_number, a.id_stock, a.cont_date_in, a.cont_date_out, " ;
            $query.= " a.date_stripping, b.dt_stripping, ifnull(case when a.cont_date_out is null " ;
            $query.= " and a.date_stripping is not null then (To_days(now()) - TO_DAYS(b.dt_stripping) + 1) when a.date_stripping is null " ;
            $query.= " and a.cont_date_out is null  then (To_days(now()) - TO_DAYS(a.cont_date_in) + 1) " ;
            $query.= " else (To_days(a.cont_date_out) - TO_DAYS(b.dt_stripping) + 1) end, 0) as storage_stripping " ;
            $query.= " FROM t_t_stock as a left join test.".$nama_table_2." as b on a.id_stock=b.id_stock  " ;
            $query.= " where ((DATE_FORMAT(a.cont_date_in,'%Y-%m-%d') <= ('".$enddate."'-INTERVAL 1 DAY)  AND a.rec_id = '0') " ;
            $query.= " or (DATE_FORMAT(a.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  " ;
            $query.= " and DATE_FORMAT(a.cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND a.rec_id <> '9')) ";
            $query.= " and a.code_principal='".$code_principal."' and a.cont_status='".$cont_status."' ";
            $query.= " ORDER BY a.cont_number ";
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_3);



            $nama_table_4 = "vw_gate_date_storage_stock_detail_storage_dt_stuffing_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_4;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
      
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_4." AS ";
            $query.= " SELECT STR_TO_DATE(date_stuffing, '%d-%m-%Y') as dt_stuffing, date_stuffing, id_stock, code_principal, cont_status, " ;
            $query.= " cont_number, cont_date_in, cont_date_out FROM t_t_stock " ;
            $query.= " where ((DATE_FORMAT(cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  AND rec_id = '0') " ;
            $query.= " or (DATE_FORMAT(cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY) " ;
            $query.= " and DATE_FORMAT(cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND rec_id <> '9')) " ;
            $query.= " and code_principal='".$code_principal."' and cont_status='".$cont_status."' " ;
            $query.= " ORDER BY cont_number " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_4);


    


            $nama_table_5 = "vw_gate_date_storage_stock_detail_storage_stuffing_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_5;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_5." AS ";
            $query.= " SELECT a.code_principal, a.cont_status, a.cont_number, a.id_stock, a.cont_date_in, a.cont_date_out, " ;
            $query.= " a.date_stuffing, b.dt_stuffing, ifnull(case when a.cont_date_out is null and a.date_stuffing is not null " ;
            $query.= " then (To_days(now()) - TO_DAYS(b.dt_stuffing) + 1) when a.date_stuffing is null and a.cont_date_out is null  " ;
            $query.= " then (To_days(now()) - TO_DAYS(a.cont_date_in) + 1) " ;
            $query.= " else (To_days(a.cont_date_out) - TO_DAYS(b.dt_stuffing) + 1) end, 0) as storage_stuffing " ;
            $query.= " FROM t_t_stock as a left join test.".$nama_table_4." as b on a.id_stock=b.id_stock  " ;
            $query.= " where ((DATE_FORMAT(a.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  AND a.rec_id = '0') " ;
            $query.= " or (DATE_FORMAT(a.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY) " ;
            $query.= " and DATE_FORMAT(a.cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND a.rec_id <> '9')) " ;
            $query.= " and a.code_principal='".$code_principal."' and a.cont_status='".$cont_status."' " ;
            $query.= " ORDER BY a.cont_number " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_5);

    

            $nama_table_6 = "view_cont_stock_detail_sort_by_cont_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_6;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_6." AS ";
            $query.= " SELECT a.code_principal, a.name_principal, a.cont_number, a.reff_code, a.cont_condition, a.vessel, " ;
            $query.= " a.cont_date_in, a.cont_date_out, a.date_shifting, a.date_stripping, a.date_stuffing, a.block_loc, a.location, " ;
            $query.= " a.ship_line_code, a.bc_code, a.cont_status, ifnull(b.storage_day, 0) as  storage_day, " ;
            $query.= " ifnull(c.storage_stripping, 0) as storage_stripping, ifnull(d.storage_stuffing, 0) as storage_stuffing, a.dangers_goods, " ;
            $query.= " case when a.dangers_goods = 'No' then ('') when a.dangers_goods = 'DS' then ('DS') " ;
            $query.= " when a.dangers_goods = 'DL' then ('DL') else ('B') end as dangers " ;
            $query.= " FROM t_t_stock As a " ;
            $query.= " left join test.".$nama_table_1." As b on a.id_stock=b.id_stock " ;
            $query.= " left join test.".$nama_table_3." As c on a.id_stock=c.id_stock " ;
            $query.= " left join test.".$nama_table_5." As d on a.id_stock=d.id_stock " ;
            $query.= " where ((DATE_FORMAT(a.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  AND a.rec_id = '0') " ;
            $query.= " or (DATE_FORMAT(a.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  " ;
            $query.= " and DATE_FORMAT(a.cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND a.rec_id <> '9')) " ;
            $query.= " and a.code_principal='".$code_principal."' and a.cont_status='".$cont_status."'   " ;
            $query.= " ORDER BY a.cont_number " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_6);



            $nama_table_7 = "view_cont_stock_detail_beg_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_7;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_7." AS ";
            $query.= " SELECT distinct a.code_principal, a.name_principal,b.cont_number,b.cont_condition,b.reff_code,b.cont_status,count(b.reff_code) as beg " ;
            $query.= " FROM t_m_principal as a " ;
            $query.= " left join t_t_stock as b on a.code_principal=b.code_principal  " ;
            $query.= " where ((DATE_FORMAT(b.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  AND b.rec_id = '0') " ;
            $query.= " or (DATE_FORMAT(b.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY) " ;
            $query.= " and DATE_FORMAT(b.cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND b.rec_id <> '9')) " ;
            $query.= " and b.code_principal='".$code_principal."' and b.cont_status='".$cont_status."' " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_7);




            $nama_table_8 = "view_cont_stock_detail_in_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_8;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_8." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_number, b.cont_condition, " ;
            $query.= " b.reff_code, b.new_cont_status, count(b.reff_code) as masuk " ;
            $query.= " FROM t_m_principal as a left join t_t_entry_cont_in as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and b.cont_date_in = '".$enddate."' and b.cont_status = '".$cont_status."' " ;
            $query.= " and a.rec_id = '0' and b.rec_id = '0' " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_8);




            $nama_table_9 = "view_cont_stock_detail_out_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_9;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_9." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_number, b.cont_condition, b.reff_code, " ;
            $query.= " b.cont_status, count(b.reff_code) as keluar " ;
            $query.= " FROM t_m_principal as a " ;
            $query.= " left join t_t_entry_cont_out as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and b.cont_date_out = '".$enddate."' and b.cont_status = '".$cont_status."' " ;
            $query.= " and a.rec_id = '0' and b.rec_id = '0' " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_9);




            $nama_table_10 = "final_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_10;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_10." ";
            $query.= " (code_principal varchar(200),name_principal varchar(200),  cont_condition varchar(200), " ;
            $query.= " reff_code varchar(200),cont_status varchar(200),  beg int, masuk int,keluar int)  " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_10);


            
            $query = ""; 
            $query.= " SELECT * from test.".$nama_table_7." " ;
            $excute = $this->ptmsagate->query($query)->result_array();
            $queryku[$a++] = $this->ptmsagate->last_query();

            foreach($excute as $row){
                $this->ptmsagate->query("
                        insert into test.".$nama_table_10." values
                        ('".$row['code_principal']."','".$row['name_principal']."','".$row['cont_condition']."','".$row['reff_code']."',
                        '".$row['cont_status']."','".$row['beg']."',0,0)
                    ");
                $queryku[$a++] = $this->ptmsagate->last_query();
            }


            $query = ""; 
            $query.= " SELECT * from test.".$nama_table_8." " ;
            $excute = $this->ptmsagate->query($query)->result_array();
            $queryku[$a++] = $this->ptmsagate->last_query();

            foreach($excute as $row){
                
                $where = array(
                    'code_principal'    => $row['code_principal'],
                    'name_principal'    => $row['name_principal'],
                    'cont_condition'    => $row['cont_condition'],
                    'reff_code'         => $row['reff_code'],
                    'cont_status'       => $row['new_cont_status'],
                );

                $cek = $this->ptmsagate->get_where("test.".$nama_table_10,$where)->num_rows();
                $queryku[$a++] = $this->ptmsagate->last_query();


                if($cek == 0){
                    
                    //jika belum ada
                    $this->ptmsagate->query("
                        insert into test.".$nama_table_10." values
                        ('".$row['code_principal']."','".$row['name_principal']."','".$row['cont_condition']."',
                        '".$row['reff_code']."','".$row['new_cont_status']."',0,'".$row['masuk']."',0)
                    ");
                    $queryku[$a++] = $this->ptmsagate->last_query();

                }else{
                    
                    //jika sudah ada
                    $this->ptmsagate->update("test.".$nama_table_10, array('masuk' => $row['masuk']), $where);
                    $queryku[$a++] = $this->ptmsagate->last_query();

                }

            }


            $query = ""; 
            $query.= " SELECT * from test.".$nama_table_9." " ;
            $excute = $this->ptmsagate->query($query)->result_array();
            $queryku[$a++] = $this->ptmsagate->last_query();

            foreach($excute as $row){

                $where = array(
                    'code_principal'    => $row['code_principal'],
                    'name_principal'    => $row['name_principal'],
                    'cont_condition'    => $row['cont_condition'],
                    'reff_code'         => $row['reff_code'],
                    'cont_status'       => $row['cont_status'],
                );

                $cek = $this->ptmsagate->get_where('test.'.$nama_table_10,$where)->num_rows();
                $queryku[$a++] = $this->ptmsagate->last_query();

                if($cek == 0){
                    
                    //jika belum ada
                    $this->ptmsagate->query("
                        insert into test.".$nama_table_10." values
                        ('".$row['code_principal']."','".$row['name_principal']."','".$row['cont_condition']."',
                        '".$row['reff_code']."','".$row['cont_status']."',0,0,'".$row['keluar']."')
                    ");
                    $queryku[$a++] = $this->ptmsagate->last_query();

                }else{
                    
                    //jika sudah ada
                    $this->ptmsagate->update('test.'.$nama_table_10, array('keluar' => $row['keluar']), $where);
                    $queryku[$a++] = $this->ptmsagate->last_query();

                }

            }


            $nama_table_11 = "view_cont_stock_detail_detail_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_11;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_11." as ";
            $query.= " SELECT * from test.".$nama_table_10." " ;
            $query.= " Group by code_principal, reff_code " ;
            $query.= " Order by code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_11);



            $nama_table_12 = "view_cont_stock_detail_detail_stock_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_12;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_12." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_condition, b.reff_code, " ;
            $query.= " b.cont_status, ifnull(b.beg, 0) as beg, ifnull(b.masuk, 0) as masuk, ifnull(b.keluar, 0) as keluar " ;
            $query.= " FROM t_m_principal as a " ;
            $query.= " left join test.".$nama_table_11." as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a. rec_id = '0' and b.reff_code is not null " ;
            $query.= " Group by a.code_principal, b.reff_code, b.cont_status, b.cont_condition " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_12);



            $nama_table_13 = "view_cont_stock_detail_detail_stock_final_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_13;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_13." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_condition, b.reff_code, b.cont_status, " ;
            $query.= " ifnull(b.beg, 0) as beg, ifnull(b.masuk, 0) as masuk, ifnull(b.keluar, 0) as keluar, " ;
            $query.= " ifnull((b.beg + b.masuk) - b.keluar, 0) as total " ;
            $query.= " FROM t_m_principal as a " ;
            $query.= " left join test.".$nama_table_12." as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a. rec_id = '0' and b.reff_code is not null " ;
            $query.= " Group by a.code_principal, b.reff_code, b.cont_status, b.cont_condition " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_13);


            $pesan_data = array(
                'msg'   => 'Ya',
                'pesan' => 'Proses data berhasil...'
            );

        }else if($cont_status == "Full" && $cbosort == "D"){


            $nama_table_1 = "vw_gate_date_storage_stock_detail_storage_day_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_1;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_1." AS ";
            $query.= " SELECT code_principal, cont_status, cont_number, id_stock, cont_date_in, cont_date_out,date_shifting, " ;
            $query.= " case when cont_date_out is null then(To_days(now()) - TO_DAYS(cont_date_in) + 1) " ;
            $query.= " else (To_days(cont_date_out) - TO_DAYS(cont_date_in) + 1) end as storage_day " ;
            $query.= " FROM t_t_stock  " ;
            $query.= " where ((DATE_FORMAT(cont_date_in,'%Y-%m-%d') <= ('".$enddate."'-INTERVAL 1 DAY)  AND rec_id = '0')  " ;
            $query.= " or (DATE_FORMAT(cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  " ;
            $query.= " and DATE_FORMAT(cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND rec_id <> '9')) " ;
            $query.= " and code_principal='".$code_principal."' and cont_status='".$cont_status."'  " ;
            $query.= " ORDER BY date_shifting desc " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_1);



            $nama_table_2 = "vw_gate_date_storage_stock_detail_storage_dt_stripping_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_2;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_2." AS ";
            $query.= " SELECT STR_TO_DATE(date_stripping, '%d-%m-%Y') as dt_stripping, date_stripping, id_stock, " ;
            $query.= " code_principal, cont_status, cont_number, cont_date_in, cont_date_out " ;
            $query.= " FROM t_t_stock  " ;
            $query.= " where ((DATE_FORMAT(cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  AND rec_id = '0')  " ;
            $query.= " or (DATE_FORMAT(cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  " ;
            $query.= " and DATE_FORMAT(cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND rec_id <> '9')) " ;
            $query.= " and code_principal='".$code_principal."' and cont_status='".$cont_status."' " ;
            $query.= " ORDER BY date_stripping asc " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_2);


        

            $nama_table_3 = "vw_gate_date_storage_stock_detail_storage_stripping_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_3;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_3." AS ";
            $query.= " SELECT a.code_principal, a.cont_status, a.cont_number, a.id_stock, a.cont_date_in, a.cont_date_out, " ;
            $query.= " a.date_stripping, b.dt_stripping, ifnull(case when a.cont_date_out is null " ;
            $query.= " and a.date_stripping is not null then (To_days(now()) - TO_DAYS(b.dt_stripping) + 1) when a.date_stripping is null " ;
            $query.= " and a.cont_date_out is null  then (To_days(now()) - TO_DAYS(a.cont_date_in) + 1) " ;
            $query.= " else (To_days(a.cont_date_out) - TO_DAYS(b.dt_stripping) + 1) end, 0) as storage_stripping " ;
            $query.= " FROM t_t_stock as a left join test.".$nama_table_2." as b on a.id_stock=b.id_stock  " ;
            $query.= " where ((DATE_FORMAT(a.cont_date_in,'%Y-%m-%d') <= ('".$enddate."'-INTERVAL 1 DAY)  AND a.rec_id = '0') " ;
            $query.= " or (DATE_FORMAT(a.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  " ;
            $query.= " and DATE_FORMAT(a.cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND a.rec_id <> '9')) ";
            $query.= " and a.code_principal='".$code_principal."' and a.cont_status='".$cont_status."' ";
            $query.= " ORDER BY a.date_stripping asc ";
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_3);



            $nama_table_4 = "vw_gate_date_storage_stock_detail_storage_dt_stuffing_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_4;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
      
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_4." AS ";
            $query.= " SELECT STR_TO_DATE(date_stuffing, '%d-%m-%Y') as dt_stuffing, date_stuffing, id_stock, code_principal, cont_status, " ;
            $query.= " cont_number, cont_date_in, cont_date_out FROM t_t_stock " ;
            $query.= " where ((DATE_FORMAT(cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  AND rec_id = '0') " ;
            $query.= " or (DATE_FORMAT(cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY) " ;
            $query.= " and DATE_FORMAT(cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND rec_id <> '9')) " ;
            $query.= " and code_principal='".$code_principal."' and cont_status='".$cont_status."' " ;
            $query.= " ORDER BY date_stuffing asc " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_4);


    


            $nama_table_5 = "vw_gate_date_storage_stock_detail_storage_stuffing_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_5;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_5." AS ";
            $query.= " SELECT a.code_principal, a.cont_status, a.cont_number, a.id_stock, a.cont_date_in, a.cont_date_out, " ;
            $query.= " a.date_stuffing, b.dt_stuffing, ifnull(case when a.cont_date_out is null and a.date_stuffing is not null " ;
            $query.= " then (To_days(now()) - TO_DAYS(b.dt_stuffing) + 1) when a.date_stuffing is null and a.cont_date_out is null  " ;
            $query.= " then (To_days(now()) - TO_DAYS(a.cont_date_in) + 1) " ;
            $query.= " else (To_days(a.cont_date_out) - TO_DAYS(b.dt_stuffing) + 1) end, 0) as storage_stuffing " ;
            $query.= " FROM t_t_stock as a left join test.".$nama_table_4." as b on a.id_stock=b.id_stock  " ;
            $query.= " where ((DATE_FORMAT(a.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  AND a.rec_id = '0') " ;
            $query.= " or (DATE_FORMAT(a.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY) " ;
            $query.= " and DATE_FORMAT(a.cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND a.rec_id <> '9')) " ;
            $query.= " and a.code_principal='".$code_principal."' and a.cont_status='".$cont_status."' " ;
            $query.= " ORDER BY a.date_stuffing asc " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_5);

    

            $nama_table_6 = "view_cont_stock_detail_sort_by_date_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_6;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_6." AS ";
            $query.= " SELECT a.code_principal, a.name_principal, a.cont_number, a.reff_code, a.cont_condition, a.vessel, " ;
            $query.= " a.cont_date_in, a.cont_date_out, a.date_shifting, a.date_stripping, a.date_stuffing, a.block_loc, a.location, " ;
            $query.= " a.ship_line_code, a.bc_code, a.cont_status, ifnull(b.storage_day, 0) as  storage_day, " ;
            $query.= " ifnull(c.storage_stripping, 0) as storage_stripping, ifnull(d.storage_stuffing, 0) as storage_stuffing, a.dangers_goods, " ;
            $query.= " case when a.dangers_goods = 'No' then ('') when a.dangers_goods = 'DS' then ('DS') " ;
            $query.= " when a.dangers_goods = 'DL' then ('DL') else ('B') end as dangers " ;
            $query.= " FROM t_t_stock As a " ;
            $query.= " left join test.".$nama_table_1." As b on a.id_stock=b.id_stock " ;
            $query.= " left join test.".$nama_table_3." As c on a.id_stock=c.id_stock " ;
            $query.= " left join test.".$nama_table_5." As d on a.id_stock=d.id_stock " ;
            $query.= " where ((DATE_FORMAT(a.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  AND a.rec_id = '0') " ;
            $query.= " or (DATE_FORMAT(a.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  " ;
            $query.= " and DATE_FORMAT(a.cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND a.rec_id <> '9')) " ;
            $query.= " and a.code_principal='".$code_principal."' and a.cont_status='".$cont_status."'   " ;
            $query.= " ORDER BY a.date_stuffing " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_6);



            $nama_table_7 = "view_cont_stock_detail_beg_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_7;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_7." AS ";
            $query.= " SELECT distinct a.code_principal, a.name_principal,b.cont_number,b.cont_condition,b.reff_code,b.cont_status,count(b.reff_code) as beg " ;
            $query.= " FROM t_m_principal as a " ;
            $query.= " left join t_t_stock as b on a.code_principal=b.code_principal  " ;
            $query.= " where ((DATE_FORMAT(b.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY)  AND b.rec_id = '0') " ;
            $query.= " or (DATE_FORMAT(b.cont_date_in,'%Y-%m-%d')<= ('".$enddate."'-INTERVAL 1 DAY) " ;
            $query.= " and DATE_FORMAT(b.cont_date_out,'%Y-%m-%d') > ('".$enddate."'-INTERVAL 1 DAY)  AND b.rec_id <> '9')) " ;
            $query.= " and b.code_principal='".$code_principal."' and b.cont_status='".$cont_status."' " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_7);




            $nama_table_8 = "view_cont_stock_detail_in_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_8;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_8." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_number, b.cont_condition, " ;
            $query.= " b.reff_code, b.new_cont_status, count(b.reff_code) as masuk " ;
            $query.= " FROM t_m_principal as a left join t_t_entry_cont_in as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and b.cont_date_in = '".$enddate."' and b.cont_status = '".$cont_status."' " ;
            $query.= " and a.rec_id = '0' and b.rec_id = '0' " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_8);




            $nama_table_9 = "view_cont_stock_detail_out_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_9;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_9." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_number, b.cont_condition, b.reff_code, " ;
            $query.= " b.cont_status, count(b.reff_code) as keluar " ;
            $query.= " FROM t_m_principal as a " ;
            $query.= " left join t_t_entry_cont_out as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a.code_principal = '".$code_principal."' and b.cont_date_out = '".$enddate."' and b.cont_status = '".$cont_status."' " ;
            $query.= " and a.rec_id = '0' and b.rec_id = '0' " ;
            $query.= " Group by a.code_principal, b.reff_code " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_9);




            $nama_table_10 = "final_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_10;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_10." ";
            $query.= " (code_principal varchar(200),name_principal varchar(200),  cont_condition varchar(200), " ;
            $query.= " reff_code varchar(200),cont_status varchar(200),  beg int, masuk int,keluar int)  " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_10);


            
            $query = ""; 
            $query.= " SELECT * from test.".$nama_table_7." " ;
            $excute = $this->ptmsagate->query($query)->result_array();
            $queryku[$a++] = $this->ptmsagate->last_query();

            foreach($excute as $row){
                $this->ptmsagate->query("
                        insert into test.".$nama_table_10." values
                        ('".$row['code_principal']."','".$row['name_principal']."','".$row['cont_condition']."','".$row['reff_code']."',
                        '".$row['cont_status']."','".$row['beg']."',0,0)
                    ");
                $queryku[$a++] = $this->ptmsagate->last_query();
            }


            $query = ""; 
            $query.= " SELECT * from test.".$nama_table_8." " ;
            $excute = $this->ptmsagate->query($query)->result_array();
            $queryku[$a++] = $this->ptmsagate->last_query();

            foreach($excute as $row){
                
                $where = array(
                    'code_principal'    => $row['code_principal'],
                    'name_principal'    => $row['name_principal'],
                    'cont_condition'    => $row['cont_condition'],
                    'reff_code'         => $row['reff_code'],
                    'cont_status'       => $row['new_cont_status'],
                );

                $cek = $this->ptmsagate->get_where('test.'.$nama_table_10,$where)->num_rows();
                $queryku[$a++] = $this->ptmsagate->last_query();


                if($cek == 0){
                    
                    //jika belum ada
                    $this->ptmsagate->query("
                        insert into test.".$nama_table_10." values
                        ('".$row['code_principal']."','".$row['name_principal']."','".$row['cont_condition']."',
                        '".$row['reff_code']."','".$row['new_cont_status']."',0,'".$row['masuk']."',0)
                    ");
                    $queryku[$a++] = $this->ptmsagate->last_query();

                }else{
                    
                    //jika sudah ada
                    $this->ptmsagate->update('test.'.$nama_table_10, array('masuk' => $row['masuk']), $where);
                    $queryku[$a++] = $this->ptmsagate->last_query();

                }

            }


            $query = ""; 
            $query.= " SELECT * from test.".$nama_table_9." " ;
            $excute = $this->ptmsagate->query($query)->result_array();
            $queryku[$a++] = $this->ptmsagate->last_query();

            foreach($excute as $row){

                $where = array(
                    'code_principal'    => $row['code_principal'],
                    'name_principal'    => $row['name_principal'],
                    'cont_condition'    => $row['cont_condition'],
                    'reff_code'         => $row['reff_code'],
                    'cont_status'       => $row['cont_status'],
                );

                $cek = $this->ptmsagate->get_where('test.'.$nama_table_10,$where)->num_rows();
                $queryku[$a++] = $this->ptmsagate->last_query();

                if($cek == 0){
                    
                    //jika belum ada
                    $this->ptmsagate->query("
                        insert into test.".$nama_table_10." values
                        ('".$row['code_principal']."','".$row['name_principal']."','".$row['cont_condition']."',
                        '".$row['reff_code']."','".$row['cont_status']."',0,0,'".$row['keluar']."')
                    ");
                    $queryku[$a++] = $this->ptmsagate->last_query();

                }else{
                    
                    //jika sudah ada
                    $this->ptmsagate->update('test.'.$nama_table_10, array('keluar' => $row['keluar']), $where);
                    $queryku[$a++] = $this->ptmsagate->last_query();

                }

            }

            $nama_table_11 = "view_cont_stock_detail_detail_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_11;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_11." as ";
            $query.= " SELECT * from test.".$nama_table_10." " ;
            $query.= " Group by code_principal, reff_code " ;
            $query.= " Order by code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_11);



            $nama_table_12 = "view_cont_stock_detail_detail_stock_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_12;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_12." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_condition, b.reff_code, " ;
            $query.= " b.cont_status, ifnull(b.beg, 0) as beg, ifnull(b.masuk, 0) as masuk, ifnull(b.keluar, 0) as keluar " ;
            $query.= " FROM t_m_principal as a " ;
            $query.= " left join test.".$nama_table_11." as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a. rec_id = '0' and b.reff_code is not null " ;
            $query.= " Group by a.code_principal, b.reff_code, b.cont_status, b.cont_condition " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_12);



            $nama_table_13 = "view_cont_stock_detail_detail_stock_final_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_13;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_13." AS ";
            $query.= " SELECT DISTINCT a.code_principal, a.name_principal, b.cont_condition, b.reff_code, b.cont_status, " ;
            $query.= " ifnull(b.beg, 0) as beg, ifnull(b.masuk, 0) as masuk, ifnull(b.keluar, 0) as keluar, " ;
            $query.= " ifnull((b.beg + b.masuk) - b.keluar, 0) as total " ;
            $query.= " FROM t_m_principal as a " ;
            $query.= " left join test.".$nama_table_12." as b on a.code_principal=b.code_principal " ;
            $query.= " WHERE a. rec_id = '0' and b.reff_code is not null " ;
            $query.= " Group by a.code_principal, b.reff_code, b.cont_status, b.cont_condition " ;
            $query.= " Order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_13);


            $pesan_data = array(
                'msg'   => 'Ya',
                'pesan' => 'Proses data berhasil...'
            );

        }


            
            
           
        echo json_encode($pesan_data);
    }




    function c_print(){
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
        $cont_status = $data[3] ;
        $cbosort = $data[4] ;

        

        if($cont_status == "Empty" && $cbosort == "C"){

            $path = APPPATH . 'modules/report_jasper/report_cont_stock_detail_sort_by_container_empty.jrxml'; 
            $path_subreport = "" ;
            $nama_table_1 = "test.view_cont_stock_detail_sort_by_cont_".$username ;

            $data_1 = $this->ptmsagate->query(" SELECT *
                    ,DATE_FORMAT(cont_date_in,'%d-%m-%Y') as 'cont_date_in2'
                    ,DATE_FORMAT(cont_date_out,'%d-%m-%Y') as 'cont_date_out2'
                    ,DATE_FORMAT(date_stripping,'%d-%m-%Y') as 'date_stripping2'
                    FROM ".$nama_table_1." ")->result_array() ;

            $path_subreport =  APPPATH . 'modules/report_jasper/'; 

            $nama_table_2 = "test.view_cont_stock_detail_detail_stock_final_".$username ;

        }else if($cont_status == "Empty" && $cbosort == "D"){
            $path = APPPATH . 'modules/report_jasper/report_cont_stock_detail_sort_by_container_empty.jrxml'; 
            $path_subreport = "" ;
            $nama_table_1 = "test.view_cont_stock_detail_sort_by_date_".$username ;

            $data_1 = $this->ptmsagate->query(" SELECT *
                    ,DATE_FORMAT(cont_date_in,'%d-%m-%Y') as 'cont_date_in2'
                    ,DATE_FORMAT(cont_date_out,'%d-%m-%Y') as 'cont_date_out2'
                    ,DATE_FORMAT(date_stripping,'%d-%m-%Y') as 'date_stripping2'
                    FROM ".$nama_table_1." ")->result_array() ;

            $path_subreport =  APPPATH . 'modules/report_jasper/'; 

            $nama_table_2 = "test.view_cont_stock_detail_detail_stock_final_".$username ;

        }else if($cont_status == "Full" && $cbosort == "C"){
            
            $path = APPPATH . 'modules/report_jasper/new/report_cont_stock_detail_sort_by_container_full.jrxml'; 
            $path_subreport = "" ;
            $nama_table_1 = "test.view_cont_stock_detail_sort_by_cont_".$username ;

            $data_1 = $this->ptmsagate->query(" SELECT *
                    ,DATE_FORMAT(cont_date_in,'%d-%m-%Y') as 'cont_date_in2'
                    ,DATE_FORMAT(cont_date_out,'%d-%m-%Y') as 'cont_date_out2'
                    ,DATE_FORMAT(date_stuffing,'%d-%m-%Y') as 'date_stuffing2'
                    FROM ".$nama_table_1." ")->result_array() ;

            $path_subreport =  APPPATH . 'modules/report_jasper/'; 

            $nama_table_2 = "test.view_cont_stock_detail_detail_stock_final_".$username ;

        }else if($cont_status == "Full" && $cbosort == "D"){
            
            $path = APPPATH . 'modules/report_jasper/new/report_cont_stock_detail_sort_by_container_full.jrxml'; 
            $path_subreport = "" ;
            $nama_table_1 = "test.view_cont_stock_detail_sort_by_date_".$username ;

            $data_1 = $this->ptmsagate->query(" SELECT *
                    ,DATE_FORMAT(cont_date_in,'%d-%m-%Y') as 'cont_date_in2'
                    ,DATE_FORMAT(cont_date_out,'%d-%m-%Y') as 'cont_date_out2'
                    ,DATE_FORMAT(date_stuffing,'%d-%m-%Y') as 'date_stuffing2'
                    FROM ".$nama_table_1." ")->result_array() ;

            $path_subreport =  APPPATH . 'modules/report_jasper/'; 

            $nama_table_2 = "test.view_cont_stock_detail_detail_stock_final_".$username ;

        }


        
        $PHPJasperXML = new PHPJasperXML("en","TCPDF"); 

        

        $data_2 = $this->ptmsagate->query("SELECT * FROM ".$nama_table_2." ")->result_array();

        $subreport_status = "" ;
        $subreport_size = "" ;
        $subreport_condition = "" ;
        $subreport_beg = "" ;
        $subreport_masuk = "" ;
        $subreport_out = "" ;
        $subreport_total = "" ;
        $garis="" ;
        $garisbawah="" ;
        $jarak = "" ;

        $subreport_begT = 0;
        $subreport_masukT = 0;
        $subreport_outT = 0;
        $subreport_totalT = 0;

        foreach($data_2 as $row){
            $subreport_status.= $row['cont_status']."\n" ;
            $subreport_size.= $row['reff_code']."\n" ;
            $subreport_condition.= $row['cont_condition']."\n" ;
            $subreport_beg.= $row['beg']."\n" ;
            $subreport_masuk.= $row['masuk']."\n" ;
            $subreport_out.= $row['keluar']."\n" ;
            $subreport_total.= $row['total']."\n" ;
            $garis.="\n" ;
            $garisbawah.="\n";
            $jarak.="\n";
            $subreport_begT = $subreport_begT + $row['beg'];
            $subreport_masukT = $subreport_masukT + $row['masuk'] ;
            $subreport_outT = $subreport_outT + $row['keluar'] ;
            $subreport_totalT = $subreport_totalT + $row['total'] ;

        }
        $garis.="=========================================================================";

        
        $subreport_begT = "\n".$jarak.$subreport_begT ;
        $subreport_masukT = "\n".$jarak.$subreport_masukT ;
        $subreport_outT = "\n".$jarak.$subreport_outT ;
        $subreport_totalT = "\n".$jarak.$subreport_totalT ;

        $grandtotal = "\n".$jarak."GRAND TOTAL" ;

        $garisbawah.="\n\n"."=========================================================================";

        $PHPJasperXML->arrayParameter = array(
            "username" => $username,
            "startdate" => $startdate,
            "enddate" => $enddate,
            "jam_sekarang" => jam_sekarang(),
            "tanggal_sekarang" => showdate_dmy(tanggal_sekarang()),
            "principal" => strtoupper($code_principal),
            "status" => $cont_status,
            "subreport_status" => $subreport_status,
            "subreport_size" => $subreport_size,
            "subreport_condition" => $subreport_condition,
            "subreport_beg" => $subreport_beg,
            "subreport_masuk" => $subreport_masuk,
            "subreport_out" => $subreport_out,
            "subreport_total" => $subreport_total,
            "garis" => $garis,
            "SUBREPORT_DIR" => $path_subreport,
            "subreport_begT" => $subreport_begT,
            "subreport_masukT" => $subreport_masukT,
            "subreport_outT" => $subreport_outT,
            "subreport_totalT" => $subreport_totalT,
            "grandtotal"    => $grandtotal,
            "garisbawah" => $garisbawah
        );

        
        //$PHPJasperXML->debugsql=true;   
        $PHPJasperXML->load_xml_file($path);
        $dbdriver="mysql";
        $version="1.1";
        $PHPJasperXML->transferDBtoArray($this->ptmsagate->hostname,$this->ptmsagate->username,$this->ptmsagate->password,$this->ptmsagate->database,$dbdriver);
        $PHPJasperXML->arraysqltable=$data_1;
        $PHPJasperXML->outpage('I');  
    }


    function c_export(){
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
        $cont_status = $data[3] ;
        $cbosort = $data[4] ;

        if($cont_status == "Empty" && $cbosort == "C"){
            $nama_table_1 = "test.view_cont_stock_detail_sort_by_cont_".$username ;
            $nama_table_2 = "test.view_cont_stock_detail_detail_stock_final_".$username ;
            $data1 = $this->ptmsagate->query(" SELECT 'nomor' as 'No',cont_number 'Container No',reff_code 'Size',
                    cont_condition 'Cd',vessel 'Vessel',
                    DATE_FORMAT(cont_date_in,'%d-%m-%Y') as 'Date In',
                    DATE_FORMAT(cont_date_out,'%d-%m-%Y') as 'Date Out',
                    DATE_FORMAT(date_stripping,'%d-%m-%Y') as 'Dt Stripp',
                    CONCAT(block_loc,' ',location) 'Location',
                    storage_day 'Ttl.Day',storage_stripping 'Day.Str',
                    ship_line_code 'SLine',bc_code 'BC'
                    FROM ".$nama_table_1." ")->result_array() ;
        }else if($cont_status == "Empty" && $cbosort == "D"){
            $nama_table_1 = "test.view_cont_stock_detail_sort_by_date_".$username ;
            $nama_table_2 = "test.view_cont_stock_detail_detail_stock_final_".$username ;
            $data1 = $this->ptmsagate->query(" SELECT 'nomor' as 'No',cont_number 'Container No',reff_code 'Size',
                    cont_condition 'Cd',vessel 'Vessel',
                    DATE_FORMAT(cont_date_in,'%d-%m-%Y') as 'Date In',
                    DATE_FORMAT(cont_date_out,'%d-%m-%Y') as 'Date Out',
                    DATE_FORMAT(date_stripping,'%d-%m-%Y') as 'Dt Stripp',
                    CONCAT(block_loc,' ',location) 'Location',
                    storage_day 'Ttl.Day',storage_stripping 'Day.Str',
                    ship_line_code 'SLine',bc_code 'BC'
                    FROM ".$nama_table_1." ")->result_array() ;
        }else if($cont_status == "Full" && $cbosort == "C"){
            $nama_table_1 = "test.view_cont_stock_detail_sort_by_cont_".$username ;
            $nama_table_2 = "test.view_cont_stock_detail_detail_stock_final_".$username ;
            $data1 = $this->ptmsagate->query(" SELECT 'nomor' as 'No',cont_number 'Container No',reff_code 'Size',
                    cont_condition 'Cd',vessel 'Vessel',
                    DATE_FORMAT(cont_date_in,'%d-%m-%Y') as 'Date In',
                    DATE_FORMAT(cont_date_out,'%d-%m-%Y') as 'Date Out',
                    DATE_FORMAT(date_stuffing,'%d-%m-%Y') as 'Dt Stuff',
                    CONCAT(block_loc,' ',location) 'Location',
                    storage_day 'Ttl.Day',storage_stuffing 'Day.Stf',
                    ship_line_code 'SLine',bc_code 'BC'
                    FROM ".$nama_table_1." ")->result_array() ;
        }else if($cont_status == "Full" && $cbosort == "D"){
            $nama_table_1 = "test.view_cont_stock_detail_sort_by_date_".$username ;
            $nama_table_2 = "test.view_cont_stock_detail_detail_stock_final_".$username ;
            $data1 = $this->ptmsagate->query(" SELECT 'nomor' as 'No',cont_number 'Container No',reff_code 'Size',
                    cont_condition 'Cd',vessel 'Vessel',
                    DATE_FORMAT(cont_date_in,'%d-%m-%Y') as 'Date In',
                    DATE_FORMAT(cont_date_out,'%d-%m-%Y') as 'Date Out',
                    DATE_FORMAT(date_stuffing,'%d-%m-%Y') as 'Dt Stuff',
                    CONCAT(block_loc,' ',location) 'Location',
                    storage_day 'Ttl.Day',storage_stuffing 'Day.Stf',
                    ship_line_code 'SLine',bc_code 'BC'
                    FROM ".$nama_table_1." ")->result_array() ;
        }

        $data2 = $this->ptmsagate->query("select cont_status 'Status',reff_code 'Size',
                                    cont_condition 'Condition',beg 'Beg',masuk 'Masuk',
                                    keluar 'Keluar',total 'Total' from ".$nama_table_2."")->result_array();

        //Setting Sheet Excel
        $nama_excel = "Report_Cont_Stock_Detail_".tanggal_sekarang() ;

        $nama_sheet = array(
            '0' => 'Report Cont Stock Detail',
            '1' => 'Rekap Container'
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