<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class C_cont_movement_recapitulation extends CI_Controller {

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
        array_push($arraydata, array('code_principal' => 'All' , 'name_principal' => 'All Data'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'code_principal', 'class' => 'selectpicker'),
        );

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'code_principal' => ComboDb($createcombo)
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_proses(){
        $this->m_model->drop_temporary();

        $username = $this->session->userdata('autogate_username') ;
        $startdate = date_db($this->input->post('startdate'));
        $enddate = date_db($this->input->post('enddate'));
        $code_principal = $this->input->post('code_principal');

        $a=0;

        $pesan_data = array(
            'msg'   => 'Tidak',
            'pesan' => 'Proses data gagal...'
        );

        if($code_principal == 'All'){

            //_______________________ Stock __________________________________________//

            $nama_table_1 = "view_stock_20E_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_1;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_1." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `20EG`, " ;
            $query.= " b.cont_status, b.cont_condition from t_m_principal a, t_t_stock as b where b.reff_code like '2%' " ;
            $query.= " and b.cont_status = 'Empty' and b.cont_condition = 'AV' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') or b.cont_date_out >= '".$enddate."') group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_1);



            $nama_table_2 = "view_stock_20E_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_2;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_2." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `20ED`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.reff_code like '2%' and b.cont_status = 'Empty' " ;
            $query.= " and b.cont_condition = 'DM' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') or b.cont_date_out >= '".$enddate."') group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_2);



            $nama_table_3 = "view_stock_20F_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_3;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_3." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `20FG`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.reff_code like '2%' and b.cont_status = 'Full' " ;
            $query.= " and b.cont_condition = 'AV' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') or b.cont_date_out >= '".$enddate."') group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_3);

                  
               

            $nama_table_4 = "view_stock_20F_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_4;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_4." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `20FD`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.reff_code like '2%' and b.cont_status = 'Full' " ;
            $query.= " and b.cont_condition = 'DM' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') or b.cont_date_out >= '".$enddate."') group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_4);




            $nama_table_5 = "view_stock_40E_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_5;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_5." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `40EG`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.reff_code like '4%' and b.cont_status = 'Empty' and b.cont_condition = 'AV' " ;
            $query.= " and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') or b.cont_date_out >= '".$enddate."') group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_5);




            $nama_table_6 = "view_stock_40E_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_6;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_6." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `40ED`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.reff_code like '4%' and b.cont_status = 'Empty' " ;
            $query.= " and b.cont_condition = 'DM' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') or b.cont_date_out >= '".$enddate."') group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_6);




            $nama_table_7 = "view_stock_40F_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_7;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_7." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `40FG`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.reff_code like '4%' and b.cont_status = 'Full' " ;
            $query.= " and b.cont_condition = 'AV' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') or b.cont_date_out >= '".$enddate."') group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_7);


            $nama_table_8 = "view_stock_40F_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_8;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_8." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `40FD`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.reff_code like '4%' and b.cont_status = 'Full' " ;
            $query.= " and b.cont_condition = 'DM' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') or b.cont_date_out >= '".$enddate."') group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_8);
               


            $nama_table_9 = "view_stock_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_9;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_9." AS ";
            $query.= " select a.code_principal, ifnull(b.20EG, 0) as 20EG, ifnull(c.20ED, 0) as 20ED, ifnull(d.20FG, 0) as 20FG, " ;
            $query.= " ifnull(e.20FD, 0) as 20FD, ifnull(f.40EG, 0) as 40EG, ifnull(g.40ED, 0) as 40ED, ifnull(h.40FG, 0) as 40FG, " ;
            $query.= " ifnull(i.40FD, 0) as 40FD from t_m_principal as a " ;
            $query.= " left outer join test.".$nama_table_1." as b on a.code_principal=b.code_principal " ;
            $query.= " left outer join test.".$nama_table_2." as c on a.code_principal=c.code_principal " ;
            $query.= " left outer join test.".$nama_table_3." as d on a.code_principal = d.code_principal " ;
            $query.= " left outer join test.".$nama_table_4." as e on a.code_principal = e.code_principal " ;
            $query.= " left outer join test.".$nama_table_5." as f on a.code_principal = f.code_principal " ;
            $query.= " left outer join test.".$nama_table_6." as g on a.code_principal = g.code_principal " ;
            $query.= " left outer join test.".$nama_table_7." as h on a.code_principal = h.code_principal " ;
            $query.= " left outer join test.".$nama_table_8." as i on a.code_principal = i.code_principal " ;
            $query.= " where a.rec_id = '0' order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_9);   

            //_______________________ End Stock __________________________________________//
                     
                          

            //_______________________ In Data __________________________________________//     
            $nama_table_10 = "view_in_20E_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_10;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_10." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20EIG`, b.new_cont_condition, b.new_cont_status " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.reff_code like '2%' and b.new_cont_status = 'Empty' " ;
            $query.= " and b.new_cont_condition = 'AV' and b.rec_id = '0' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and b.cont_date_in = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_10);



            $nama_table_11 = "view_in_20E_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_11;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_11." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20EID`, b.new_cont_condition,b.new_cont_status " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.reff_code like '2%' and b.new_cont_status = 'Empty' " ;
            $query.= " and b.new_cont_condition = 'DM' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_in = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_11);


            $nama_table_12 = "view_in_20F_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_12;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_12." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20FIG`, b.new_cont_condition, b.new_cont_status " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.reff_code like '2%' and b.new_cont_status = 'Full'  " ;
            $query.= " and b.new_cont_condition = 'AV' and b.rec_id = '0' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and b.cont_date_in = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_12);


            $nama_table_13 = "view_in_20F_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_13;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_13." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20FID`, b.new_cont_condition, b.new_cont_status " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.reff_code like '2%' and b.new_cont_status = 'Full' " ;
            $query.= " and b.new_cont_condition = 'DM' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_in = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_13);
                   
            

            $nama_table_14 = "view_in_40E_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_14;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_14." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40EIG`, b.new_cont_condition, b.new_cont_status " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.reff_code like '4%' and b.new_cont_status = 'Empty' " ;
            $query.= " and b.new_cont_condition = 'AV' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_in = '".$enddate."' group by a.code_principal  " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_14);      


            
            $nama_table_15 = "view_in_40E_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_15;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_15." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40EID`, b.new_cont_condition, b.new_cont_status " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.reff_code like '4%' and b.new_cont_status = 'Empty' " ;
            $query.= " and b.new_cont_condition = 'DM' and b.rec_id = '0' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and b.cont_date_in = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_15);       




            $nama_table_16 = "view_in_40F_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_16;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_16." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40FIG`, b.new_cont_condition, b.new_cont_status " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.reff_code like '4%' and b.new_cont_status = 'Full' " ;
            $query.= " and b.new_cont_condition = 'AV' and b.rec_id = '0' and a.rec_id = '0' and " ;
            $query.= " a.code_principal = b.code_principal and b.cont_date_in = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_16);  



            $nama_table_17 = "view_in_40F_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_17;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_17." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40FID`, b.new_cont_condition, b.new_cont_status " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.reff_code like '4%' " ;
            $query.= " and b.new_cont_status = 'Full' and b.new_cont_condition = 'DM' and b.rec_id = '0' " ;
            $query.= " and a.rec_id = '0' and a.code_principal = b.code_principal and b.cont_date_in = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_17);  
    


            $nama_table_18 = "view_in_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_18;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_18." AS ";
            $query.= " select a.code_principal, ifnull(j.20EIG, 0) as 20EIG, ifnull(k.20EID, 0) as 20EID, ifnull(l.20FIG, 0) as 20FIG, " ;
            $query.= " ifnull(m.20FID, 0) as 20FID, ifnull(n.40EIG, 0) as 40EIG, ifnull(o.40EID, 0) as 40EID, ifnull(p.40FIG, 0) as 40FIG, " ;
            $query.= " ifnull(q.40FID, 0) as 40FID  " ;
            $query.= " from t_m_principal as a " ;
            $query.= " left outer join test.".$nama_table_10." as j on a.code_principal=j.code_principal " ;
            $query.= " left outer join test.".$nama_table_11." as k on a.code_principal=k.code_principal " ;
            $query.= " left outer join test.".$nama_table_12." as l on a.code_principal = l.code_principal " ;
            $query.= " left outer join test.".$nama_table_13." as m on a.code_principal = m.code_principal " ;
            $query.= " left outer join test.".$nama_table_14." as n on a.code_principal = n.code_principal " ;
            $query.= " left outer join test.".$nama_table_15." as o on a.code_principal = o.code_principal " ;
            $query.= " left outer join test.".$nama_table_16." as p on a.code_principal = p.code_principal " ;
            $query.= " left outer join test.".$nama_table_17." as q on a.code_principal = q.code_principal " ;
            $query.= " where a.rec_id = '0' order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_18);  

            //_______________________ End In Data __________________________________________//   
  


            //_______________________ Out Data __________________________________________// 

            $nama_table_19 = "view_out_20E_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_19;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_19." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20EOG`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.reff_code like '2%' and b.cont_status = 'Empty' " ;
            $query.= " and b.cont_condition = 'AV' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_19);  

  

            $nama_table_20 = "view_out_20E_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_20;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_20." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20EOD`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.reff_code like '2%' " ;
            $query.= " and b.cont_status = 'Empty' and b.cont_condition = 'DM' and b.rec_id = '0' " ;
            $query.= " and a.rec_id = '0' and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_20);  

  

            $nama_table_21 = "view_out_20F_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_21;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_21." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20FOG`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.reff_code like '2%' and b.cont_status = 'Full' " ;
            $query.= " and b.cont_condition = 'AV' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_21);  

  

            $nama_table_22 = "view_out_20F_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_22;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_22." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20FOD`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.reff_code like '2%' and b.cont_status = 'Full' " ;
            $query.= " and b.cont_condition = 'DM' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_22);  

  

            $nama_table_23 = "view_out_40E_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_23;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_23." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40EOG`, b.cont_status, b.cont_condition  " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.reff_code like '4%' and b.cont_status = 'Empty' " ;
            $query.= " and b.cont_condition = 'AV' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_23);  

  

            $nama_table_24 = "view_out_40E_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_24;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_24." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40EOD`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.reff_code like '4%' " ;
            $query.= " and b.cont_status = 'Empty' and b.cont_condition = 'DM' and b.rec_id = '0' " ;
            $query.= " and a.rec_id = '0' and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."'  " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_24);  

 


            $nama_table_25 = "view_out_40F_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_25;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_25." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40FOG`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.reff_code like '4%' and b.cont_status = 'Full' " ;
            $query.= " and b.cont_condition = 'AV' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_25);  


   

            $nama_table_26 = "view_out_40F_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_26;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_26." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40FOD`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.reff_code like '4%' and b.cont_status = 'Full' " ;
            $query.= " and b.cont_condition = 'DM' and b.rec_id = '0' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and b.cont_date_out = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_26);  


        


            $nama_table_27 = "view_out_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_27;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_27." AS ";
            $query.= " select a.code_principal, ifnull(r.20EOG, 0) as 20EOG, ifnull(s.20EOD, 0) as 20EOD, ifnull(t.20FOG, 0) as 20FOG, " ;
            $query.= " ifnull(u.20FOD, 0) as 20FOD, ifnull(v.40EOG, 0) as 40EOG, ifnull(w.40EOD, 0) as 40EOD, " ;
            $query.= " ifnull(x.40FOG, 0) as 40FOG, ifnull(y.40FOD, 0) as 40FOD " ;
            $query.= " from t_m_principal as a " ;
            $query.= " left outer join test.".$nama_table_19." as r on a.code_principal = r.code_principal " ;
            $query.= " left outer join test.".$nama_table_20." as s on a.code_principal = s.code_principal " ;
            $query.= " left outer join test.".$nama_table_21." as t on a.code_principal = t.code_principal " ;
            $query.= " left outer join test.".$nama_table_22." as u on a.code_principal = u.code_principal " ;
            $query.= " left outer join test.".$nama_table_23." as v on a.code_principal = v.code_principal " ;
            $query.= " left outer join test.".$nama_table_24." as w on a.code_principal = w.code_principal " ;
            $query.= " left outer join test.".$nama_table_25." as x on a.code_principal = x.code_principal " ;
            $query.= " left outer join test.".$nama_table_26." as y on a.code_principal = y.code_principal " ;
            $query.= " where a.rec_id = '0' order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_27); 

            //_______________________ End Out Data __________________________________________// 

      

            //_______________________ BEGINNING STOCK __________________________________________// 
            $nama_table_28 = "view_beginning_stock_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_28;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_28." AS ";
            $query.= " select a.code_principal, ((a.20EG + a.20ED) - (b.20EIG + b.20EID)) as Beg_20EB, " ;
            $query.= " ((a.20FG + a.20FD) - (b.20FIG + b.20FID)) as Beg_20FB, " ;
            $query.= " ((a.40EG + a.40ED) - (b.40EIG + b.40EID)) as Beg_40EB, " ;
            $query.= " ((a.40FG + a.40FD) - (b.40FIG + b.40FID)) as Beg_40FB " ;
            $query.= " from test.".$nama_table_9." as a " ;
            $query.= " left join test.".$nama_table_18." as b on a.code_principal=b.code_principal " ;
            $query.= " order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_28);



            $nama_table_29 = "view_move_in_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_29;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_29." AS ";
            $query.= " select code_principal, (20EIG + 20EID) as In_20EI, (20FIG + 20FID) as In_20FI, " ;
            $query.= " (40EIG + 40EID) as In_40EI, (40FIG + 40FID) as In_40FI " ;
            $query.= " from test.".$nama_table_18." order by code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_29);

                
            $nama_table_30 = "view_move_out_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_30;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_30." AS ";
            $query.= " select code_principal, (20EOG + 20EOD) as Out_20EO, (20FOG + 20FOD) as Out_20FO, " ;
            $query.= " (40EOG + 40EOD) as Out_40EO, (40FOG + 40FOD) as Out_40FO " ;
            $query.= " from test.".$nama_table_27." order by code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_30);

    

            $nama_table_31 = "view_actual_stock_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_31;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_31." AS ";
            $query.= " select a.code_principal, ((a.20EG - b.20EIG) + (b.20EIG) - (c.20EOG)) as Act_20EA, " ;
            $query.= " ((a.20FG - b.20FIG) + (b.20FIG) - (c.20FOG)) as Act_20FA, " ;
            $query.= " ((a.40EG - b.40EIG) + (b.40EIG) - (c.40EOG)) as Act_40EA, " ;
            $query.= " ((a.40FG - b.40FIG) + (b.40FIG) - (c.40FOG)) as Act_40FA " ;
            $query.= " from test.".$nama_table_9." a  " ;
            $query.= " inner join test.".$nama_table_18." b on a.code_principal=b.code_principal  " ;
            $query.= " left join test.".$nama_table_27." c on a.code_principal=c.code_principal " ;
            $query.= " where a.code_principal=b.code_principal  and a.code_principal=c.code_principal " ;
            $query.= " order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_31);

               

            $nama_table_32 = "view_damage_stock_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_32;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_32." AS ";
            $query.= " select a.code_principal, ((a.20ED - b.20EID) + (b.20EID) - (c.20EOD)) as Dmg_20ED, " ;
            $query.= " ((a.20FD - b.20FID) + (b.20FID) - (c.20FOD)) as Dmg_20FD, ((a.40ED - b.40EID) + (b.40EID) - (c.40EOD)) as Dmg_40ED, " ;
            $query.= " ((a.40FD - b.40FID) + (b.40FID) - (c.40FOD)) as Dmg_40FD " ;
            $query.= " from test.".$nama_table_9." a " ;
            $query.= " inner join test.".$nama_table_18." b on a.code_principal=b.code_principal " ;
            $query.= " left join test.".$nama_table_27." c on a.code_principal=c.code_principal " ;
            $query.= " where a.code_principal=b.code_principal  and a.code_principal=c.code_principal " ;
            $query.= " order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_32);


           


            $nama_table_33 = "view_cont_move_recapitulation_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_33;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_33." AS ";
            $query.= " select a.code_principal, a.name_principal, ifnull(b.Beg_20EB, 0) as Beg_20EB, " ;
            $query.= " ifnull(b.Beg_20FB, 0) as Beg_20FB, ifnull(b.Beg_40EB, 0) as Beg_40EB, ifnull(b.Beg_40FB, 0) as Beg_40FB, " ;
            $query.= " ifnull(c.In_20EI, 0) as In_20EI, ifnull(c.In_20FI, 0) as In_20FI, ifnull(c.In_40EI, 0) as In_40EI, " ;
            $query.= " ifnull(c.In_40FI, 0) as In_40FI, ifnull(d.Out_20EO, 0) as Out_20EO, ifnull(d.Out_20FO, 0) as Out_20FO, " ;
            $query.= " ifnull(d.Out_40EO, 0) as Out_40EO, ifnull(d.Out_40FO, 0) as Out_40FO, ifnull(e.Act_20EA, 0) as Act_20EA, " ;
            $query.= " ifnull(e.Act_20FA, 0) as Act_20FA, ifnull(e.Act_40EA, 0) as Act_40EA, ifnull(e.Act_40FA, 0) as Act_40FA, " ;
            $query.= " ifnull(f.Dmg_20ED, 0) as Dmg_20ED, ifnull(f.Dmg_20FD, 0) as Dmg_20FD, ifnull(f.Dmg_40ED, 0) as Dmg_40ED, " ;
            $query.= " ifnull(f.Dmg_40FD, 0) as Dmg_40FD from t_m_principal as a " ;
            $query.= " left outer join test.".$nama_table_28." as b on a.code_principal=b.code_principal " ;
            $query.= " left outer join test.".$nama_table_29." as c on a.code_principal=c.code_principal " ;
            $query.= " left outer join test.".$nama_table_30." as d on a.code_principal=d.code_principal " ;
            $query.= " left outer join test.".$nama_table_31." as e on a.code_principal = e.code_principal " ;
            $query.= " left outer join test.".$nama_table_32." as f on a.code_principal = f.code_principal " ;
            $query.= " where a.rec_id = '0' and ((b.Beg_20EB <> '0' or b.Beg_20FB <> '0' or b.Beg_40EB <> '0' " ;
            $query.= " or b.Beg_40FB <> '0') or (c.In_20EI <> '0' or c.In_20FI <> '0' or c.In_40EI <> '0' or c.In_40FI <> '0') " ;
            $query.= " or (d.Out_20EO <> '0' or d.Out_20FO <> '0' or d.Out_40EO <> '0' or d.Out_40FO <> '0') " ;
            $query.= " or (e.Act_20EA <> '0' or e.Act_20FA <> '0' or e.Act_40EA <> '0' or e.Act_40FA <> '0')  " ;
            $query.= " or (f.Dmg_20ED <> '0' or f.Dmg_20FD <> '0' or f.Dmg_40ED <> '0' or f.Dmg_40FD <> '0'))  " ;
            $query.= " order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_33);


            $pesan_data = array(
                'msg'   => 'Ya',
                'pesan' => 'Proses data berhasil...'
            );

            //_______________________ End BEGINNING STOCK __________________________________________// 

             

        }else{

            //------------------------------- stock --------------------------//

            $nama_table_1 = "view_stock_20E_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_1;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_1." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `20EG`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.code_principal = '".$code_principal."' and b.reff_code like '2%' " ;
            $query.= " and b.cont_status = 'Empty' and b.cont_condition = 'AV' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') " ;
            $query.= " or b.cont_date_out >= '".$enddate."') " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_1);

  

            $nama_table_2 = "view_stock_20E_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_2;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_2." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `20ED`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.code_principal = '".$code_principal."' and b.reff_code like '2%' " ;
            $query.= " and b.cont_status = 'Empty' and b.cont_condition = 'DM' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') " ;
            $query.= " or b.cont_date_out >= '".$enddate."') " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_2);


 

            $nama_table_3 = "view_stock_20F_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_3;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_3." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `20FG`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.code_principal = '".$code_principal."' " ;
            $query.= " and b.reff_code like '2%' and b.cont_status = 'Full' and b.cont_condition = 'AV' " ;
            $query.= " and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') " ;
            $query.= " or b.cont_date_out >= '".$enddate."') " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_3);

     

            $nama_table_4 = "view_stock_20F_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_4;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_4." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `20FD`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.code_principal = '".$code_principal."' and b.reff_code like '2%' " ;
            $query.= " and b.cont_status = 'Full' and b.cont_condition = 'DM' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') " ;
            $query.= " or b.cont_date_out >= '".$enddate."') " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_4);




            $nama_table_5 = "view_stock_40E_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_5;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_5." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `40EG`, b.cont_status, b.cont_condition  " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.code_principal = '".$code_principal."' " ;
            $query.= " and b.reff_code like '4%' and b.cont_status = 'Empty' and b.cont_condition = 'AV' " ;
            $query.= " and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') " ;
            $query.= " or b.cont_date_out >= '".$enddate."') " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_5);


  

            $nama_table_6 = "view_stock_40E_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_6;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_6." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `40ED`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.code_principal = '".$code_principal."' and b.reff_code like '4%' " ;
            $query.= " and b.cont_status = 'Empty' and b.cont_condition = 'DM' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') " ;
            $query.= " or b.cont_date_out >= '".$enddate."') " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_6);


  

            $nama_table_7 = "view_stock_40F_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_7;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_7." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `40FG`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.code_principal = '".$code_principal."' and b.reff_code like '4%' " ;
            $query.= " and b.cont_status = 'Full' and b.cont_condition = 'AV' " ;
            $query.= " and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '2022-03-31' and b.rec_id = '0')  " ;
            $query.= " or b.cont_date_out >= '2022-03-31') " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_7);


 

            $nama_table_8 = "view_stock_40F_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_8;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_8." AS ";
            $query.= " select distinct a.code_principal, count(b.reff_code) as `40FD`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_stock as b where b.code_principal = '".$code_principal."' " ;
            $query.= " and b.reff_code like '4%' and b.cont_status = 'Full' and b.cont_condition = 'DM' " ;
            $query.= " and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and ((b.cont_date_in <= '".$enddate."' and b.rec_id = '0') " ;
            $query.= " or b.cont_date_out >= '".$enddate."') " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_8);



            $nama_table_9 = "view_stock_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_9;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_9." AS ";
            $query.= " select a.code_principal, ifnull(b.20EG, 0) as 20EG, ifnull(c.20ED, 0) as 20ED, ifnull(d.20FG, 0) as 20FG, " ;
            $query.= " ifnull(e.20FD, 0) as 20FD, ifnull(f.40EG, 0) as 40EG, ifnull(g.40ED, 0) as 40ED, " ;
            $query.= " ifnull(h.40FG, 0) as 40FG, ifnull(i.40FD, 0) as 40FD " ;
            $query.= " from t_m_principal as a " ;
            $query.= " left join test.".$nama_table_1." as b on a.code_principal=b.code_principal " ;
            $query.= " left join test.".$nama_table_2." as c on a.code_principal=c.code_principal " ;
            $query.= " left join test.".$nama_table_3." as d on a.code_principal = d.code_principal " ;
            $query.= " left join test.".$nama_table_4." as e on a.code_principal = e.code_principal " ;
            $query.= " left join test.".$nama_table_5." as f on a.code_principal = f.code_principal " ;
            $query.= " left join test.".$nama_table_6." as g on a.code_principal = g.code_principal " ;
            $query.= " left join test.".$nama_table_7." as h on a.code_principal = h.code_principal " ;
            $query.= " left join test.".$nama_table_8." as i on a.code_principal = i.code_principal " ;
            $query.= " where a.rec_id = '0' " ;
            $query.= " order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_9);

            //------------------------------- end stock --------------------------//

            //------------------------------- Data In --------------------------//


            $nama_table_10 = "view_in_20E_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_10;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_10." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20EIG`, b.new_cont_condition, b.new_cont_status " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.code_principal = '".$code_principal."' " ;
            $query.= " and b.reff_code like '2%' and b.new_cont_status = 'Empty' " ;
            $query.= " and b.new_cont_condition = 'AV' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_in = '".$enddate."' " ;
            $query.= " group by a.code_principal  " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_10);



            $nama_table_11 = "view_in_20E_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_11;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_11." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20EID`, b.new_cont_condition, b.new_cont_status " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b " ;
            $query.= " where b.code_principal = '".$code_principal."' and b.reff_code like '2%' " ;
            $query.= " and b.new_cont_status = 'Empty' and b.new_cont_condition = 'DM' " ;
            $query.= " and b.rec_id = '0' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and b.cont_date_in = '".$enddate."' " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_11);




            $nama_table_12 = "view_in_20F_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_12;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_12." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20FIG`, b.new_cont_condition, b.new_cont_status " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.code_principal = '".$code_principal."' " ;
            $query.= " and b.reff_code like '2%' and b.new_cont_status = 'Full' and b.new_cont_condition = 'AV' " ;
            $query.= " and b.rec_id = '0' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and b.cont_date_in = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_12);

 

            $nama_table_13 = "view_in_20F_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_13;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_13." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20FID`, b.new_cont_condition, b.new_cont_status  " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.code_principal = '".$code_principal."' " ;
            $query.= " and b.reff_code like '2%' and b.new_cont_status = 'Full' and b.new_cont_condition = 'DM' " ;
            $query.= " and b.rec_id = '0' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and b.cont_date_in = '".$enddate."' " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_13);

 

            $nama_table_14 = "view_in_40E_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_14;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_14." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40EIG`, b.new_cont_condition, b.new_cont_status  " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b " ;
            $query.= " where b.code_principal = '".$code_principal."' and b.reff_code like '4%' and b.new_cont_status = 'Empty' " ;
            $query.= " and b.new_cont_condition = 'AV' and b.rec_id = '0' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and b.cont_date_in = '".$enddate."' group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_14);



            $nama_table_15 = "view_in_40E_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_15;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_15." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40EID`, b.new_cont_condition, b.new_cont_status " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.code_principal = '".$code_principal."' " ;
            $query.= " and b.reff_code like '4%' and b.new_cont_status = 'Empty' " ;
            $query.= " and b.new_cont_condition = 'DM' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_in = '".$enddate."' " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_15);




            $nama_table_16 = "view_in_40F_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_16;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_16." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40FIG`, b.new_cont_condition, b.new_cont_status  " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.code_principal = '".$code_principal."' " ;
            $query.= " and b.reff_code like '4%' and b.new_cont_status = 'Full' and b.new_cont_condition = 'AV' " ;
            $query.= " and b.rec_id = '0' and a.rec_id = '0' and a.code_principal = b.code_principal and b.cont_date_in = '".$enddate."' " ;
            $query.= " group by a.code_principal" ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_16);



            $nama_table_17 = "view_in_40F_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_17;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_17." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40FID`, b.new_cont_condition, b.new_cont_status " ;
            $query.= " from t_m_principal a, t_t_entry_cont_in as b where b.code_principal = '".$code_principal."' " ;
            $query.= " and b.reff_code like '4%' and b.new_cont_status = 'Full' and b.new_cont_condition = 'DM' " ;
            $query.= " and b.rec_id = '0' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and b.cont_date_in = '".$enddate."' " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_17);


            $nama_table_18 = "view_in_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_18;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
 
            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_18." AS ";
            $query.= " select a.code_principal, ifnull(j.20EIG, 0) as 20EIG, ifnull(k.20EID, 0) as 20EID, ifnull(l.20FIG, 0) as 20FIG, " ;
            $query.= " ifnull(m.20FID, 0) as 20FID, ifnull(n.40EIG, 0) as 40EIG, ifnull(o.40EID, 0) as 40EID, " ;
            $query.= " ifnull(p.40FIG, 0) as 40FIG, ifnull(q.40FID, 0) as 40FID " ;
            $query.= " from t_m_principal as a " ;
            $query.= " left join test.".$nama_table_10." as j on a.code_principal=j.code_principal " ;
            $query.= " left join test.".$nama_table_11." as k on a.code_principal=k.code_principal " ;
            $query.= " left join test.".$nama_table_12." as l on a.code_principal = l.code_principal " ;
            $query.= " left join test.".$nama_table_13." as m on a.code_principal = m.code_principal " ;
            $query.= " left join test.".$nama_table_14." as n on a.code_principal = n.code_principal " ;
            $query.= " left join test.".$nama_table_15." as o on a.code_principal = o.code_principal " ;
            $query.= " left join test.".$nama_table_16." as p on a.code_principal = p.code_principal " ;
            $query.= " left join test.".$nama_table_17." as q on a.code_principal = q.code_principal " ;
            $query.= " where a.rec_id = '0' " ;
            $query.= " order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_18);

            //------------------------------- End Data In --------------------------//


            //------------------------------- Data Out --------------------------//
  

            $nama_table_19 = "view_out_20E_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_19;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_19." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20EOG`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.code_principal = '".$code_principal."' and b.reff_code like '2%' " ;
            $query.= " and b.cont_status = 'Empty' and b.cont_condition = 'AV' and b.rec_id = '0' " ;
            $query.= " and a.rec_id = '0' and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."' " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_19);



            $nama_table_20 = "view_out_20E_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_20;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_20." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20EOD`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.code_principal = '".$code_principal."' and b.reff_code like '2%' " ;
            $query.= " and b.cont_status = 'Empty' and b.cont_condition = 'DM' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."' " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_20);



            $nama_table_21 = "view_out_20F_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_21;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_21." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20FOG`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.code_principal = '".$code_principal."' and b.reff_code like '2%' " ;
            $query.= " and b.cont_status = 'Full' and b.cont_condition = 'AV' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."' " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_21);



            $nama_table_22 = "view_out_20F_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_22;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_22." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `20FOD`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.code_principal = '".$code_principal."' and b.reff_code like '2%' " ;
            $query.= " and b.cont_status = 'Full' and b.cont_condition = 'DM' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."' " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_22);



            $nama_table_23 = "view_out_40E_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_23;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_23." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40EOG`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.code_principal = '".$code_principal."' and b.reff_code like '4%' " ;
            $query.= " and b.cont_status = 'Empty' and b.cont_condition = 'AV' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."' " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_23);



            $nama_table_24 = "view_out_40E_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_24;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_24." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40EOD`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.code_principal = '".$code_principal."' " ;
            $query.= " and b.reff_code like '4%' and b.cont_status = 'Empty' and b.cont_condition = 'DM' " ;
            $query.= " and b.rec_id = '0' and a.rec_id = '0' and a.code_principal = b.code_principal " ;
            $query.= " and b.cont_date_out = '".$enddate."' " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_24);



            $nama_table_25 = "view_out_40F_Good_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_25;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_25." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40FOG`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.code_principal = '".$code_principal."' and b.reff_code like '4%' " ;
            $query.= " and b.cont_status = 'Full' and b.cont_condition = 'AV' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."' " ;
            $query.= " group by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_25);


            $nama_table_26 = "view_out_40F_DM_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_26;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_26." AS ";
            $query.= " select distinct a.code_principal,count(b.reff_code) as `40FOD`, b.cont_status, b.cont_condition " ;
            $query.= " from t_m_principal a, t_t_entry_cont_out as b where b.code_principal = '".$code_principal."' and b.reff_code like '4%' " ;
            $query.= " and b.cont_status = 'Full' and b.cont_condition = 'DM' and b.rec_id = '0' and a.rec_id = '0' " ;
            $query.= " and a.code_principal = b.code_principal and b.cont_date_out = '".$enddate."' " ;
            $query.= " group by a.code_principal" ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_26);




            $nama_table_27 = "view_out_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_27;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_27." AS ";
            $query.= " select a.code_principal, ifnull(r.20EOG, 0) as 20EOG, ifnull(s.20EOD, 0) as 20EOD, ifnull(t.20FOG, 0) as 20FOG, " ;
            $query.= " ifnull(u.20FOD, 0) as 20FOD, ifnull(v.40EOG, 0) as 40EOG, ifnull(w.40EOD, 0) as 40EOD, ifnull(x.40FOG, 0) as 40FOG, " ;
            $query.= " ifnull(y.40FOD, 0) as 40FOD " ;
            $query.= " from t_m_principal as a " ;
            $query.= " left join test.".$nama_table_19." as r on a.code_principal=r.code_principal " ;
            $query.= " left join test.".$nama_table_20." as s on a.code_principal=s.code_principal " ;
            $query.= " left join test.".$nama_table_21." as t on a.code_principal = t.code_principal " ;
            $query.= " left join test.".$nama_table_22." as u on a.code_principal = u.code_principal " ;
            $query.= " left join test.".$nama_table_23." as v on a.code_principal = v.code_principal " ;
            $query.= " left join test.".$nama_table_24." as w on a.code_principal = w.code_principal " ;
            $query.= " left join test.".$nama_table_25." as x on a.code_principal = x.code_principal " ;
            $query.= " left join test.".$nama_table_26." as y on a.code_principal = y.code_principal " ;
            $query.= " where a.rec_id = '0' " ;
            $query.= " order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_27);

            //------------------------------- End Data Out --------------------------//


            //------------------------------- BEGINNING STOCK --------------------------//



            $nama_table_28 = "view_beginning_stock_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_28;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_28." AS ";
            $query.= " select a.code_principal, ((a.20EG + a.20ED) - (b.20EIG + b.20EID)) as Beg_20EB, " ;
            $query.= " ((a.20FG + a.20FD) - (b.20FIG + b.20FID)) as Beg_20FB, " ;
            $query.= " ((a.40EG + a.40ED) - (b.40EIG + b.40EID)) as Beg_40EB, " ;
            $query.= " ((a.40FG + a.40FD) - (b.40FIG + b.40FID)) as Beg_40FB " ;
            $query.= " from test.".$nama_table_9." as a " ;
            $query.= " left join test.".$nama_table_18." as b on a.code_principal=b.code_principal " ;
            $query.= " order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_28);


            //------------------------------- MOVE - IN  --------------------------//


            $nama_table_29 = "view_move_in_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_29;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_29." AS ";
            $query.= " select code_principal, (20EIG + 20EID) as In_20EI, (20FIG + 20FID) as In_20FI, " ;
            $query.= " (40EIG + 40EID) as In_40EI, (40FIG + 40FID) as In_40FI " ;
            $query.= " from test.".$nama_table_18." " ;
            $query.= " order by code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_29);


            //------------------------------- MOVE - OUT  --------------------------//

            $nama_table_30 = "view_move_out_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_30;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_30." AS ";
            $query.= " select code_principal, (20EOG + 20EOD) as Out_20EO, (20FOG + 20FOD) as Out_20FO, " ;
            $query.= " (40EOG + 40EOD) as Out_40EO, (40FOG + 40FOD) as Out_40FO " ;
            $query.= " from test.".$nama_table_27." " ;
            $query.= " order by code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_30);




            //------------------------------- Actual Stock  --------------------------//
            $nama_table_31 = "view_actual_stock_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_31;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_31." AS ";
            $query.= " select a.code_principal, ((a.20EG - b.20EIG) + (b.20EIG) - (c.20EOG)) as Act_20EA, " ;
            $query.= " ((a.20FG - b.20FIG) + (b.20FIG) - (c.20FOG)) as Act_20FA, " ;
            $query.= " ((a.40EG - b.40EIG) + (b.40EIG) - (c.40EOG)) as Act_40EA, " ;
            $query.= " ((a.40FG - b.40FIG) + (b.40FIG) - (c.40FOG)) as Act_40FA " ;
            $query.= " from test.".$nama_table_9." as a " ;
            $query.= " left join test.".$nama_table_18." as b on a.code_principal=b.code_principal " ;
            $query.= " left join test.".$nama_table_27." as c on a.code_principal=c.code_principal " ;
            $query.= " where a.code_principal=b.code_principal " ;
            $query.= " and a.code_principal=c.code_principal " ;
            $query.= " order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_31);


            //------------------------------- Damage Stock  --------------------------//

 


            $nama_table_32 = "view_damage_stock_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_32;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_32." AS ";
            $query.= " select a.code_principal, ((a.20ED - b.20EID) + (b.20EID) - (c.20EOD)) as Dmg_20ED, " ;
            $query.= " ((a.20FD - b.20FID) + (b.20FID) - (c.20FOD)) as Dmg_20FD, " ;
            $query.= " ((a.40ED - b.40EID) + (b.40EID) - (c.40EOD)) as Dmg_40ED, " ;
            $query.= " ((a.40FD - b.40FID) + (b.40FID) - (c.40FOD)) as Dmg_40FD " ;
            $query.= " from test.".$nama_table_9." as a " ;
            $query.= " left join test.".$nama_table_18." as b on a.code_principal=b.code_principal " ;
            $query.= " left join test.".$nama_table_27." as c on a.code_principal=c.code_principal " ;
            $query.= " where a.code_principal=b.code_principal  " ;
            $query.= " and a.code_principal=c.code_principal " ;
            $query.= " order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_32);



            //------------------------------- CONTAINER MOVEMENT RECAPITULATION  --------------------------//

            $nama_table_33 = "view_cont_move_recapitulation_".$username ;
            $query = "";
            $query.= "DROP TABLE IF EXISTS test.".$nama_table_33;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();

            $query = "";
            $query.= " CREATE TABLE test.".$nama_table_33." AS ";
            $query.= " select a.code_principal, a.name_principal, ifnull(b.Beg_20EB, 0) as Beg_20EB, " ;
            $query.= " ifnull(b.Beg_20FB, 0) as Beg_20FB, ifnull(b.Beg_40EB, 0) as Beg_40EB, " ;
            $query.= " ifnull(b.Beg_40FB, 0) as Beg_40FB, ifnull(c.In_20EI, 0) as In_20EI, " ;
            $query.= " ifnull(c.In_20FI, 0) as In_20FI, ifnull(c.In_40EI, 0) as In_40EI, ifnull(c.In_40FI, 0) as In_40FI, " ;
            $query.= " ifnull(d.Out_20EO, 0) as Out_20EO, ifnull(d.Out_20FO, 0) as Out_20FO, ifnull(d.Out_40EO, 0) as Out_40EO, " ;
            $query.= " ifnull(d.Out_40FO, 0) as Out_40FO, ifnull(e.Act_20EA, 0) as Act_20EA, ifnull(e.Act_20FA, 0) as Act_20FA, " ;
            $query.= " ifnull(e.Act_40EA, 0) as Act_40EA, ifnull(e.Act_40FA, 0) as Act_40FA, ifnull(f.Dmg_20ED, 0) as Dmg_20ED, " ;
            $query.= " ifnull(f.Dmg_20FD, 0) as Dmg_20FD, ifnull(f.Dmg_40ED, 0) as Dmg_40ED, ifnull(f.Dmg_40FD, 0) as Dmg_40FD " ;
            $query.= " from t_m_principal as a " ;
            $query.= " left join test.".$nama_table_28." as b on a.code_principal=b.code_principal " ;
            $query.= " left join test.".$nama_table_29." as c on a.code_principal=c.code_principal " ;
            $query.= " left join test.".$nama_table_30." as d on a.code_principal=d.code_principal " ;
            $query.= " left join test.".$nama_table_31." as e on a.code_principal = e.code_principal " ;
            $query.= " left join test.".$nama_table_32." as f on a.code_principal = f.code_principal " ;
            $query.= " where a.rec_id = '0' and a.code_principal='".$code_principal."' order by a.code_principal " ;
            $excute = $this->ptmsagate->query($query);
            $queryku[$a++] = $this->ptmsagate->last_query();
            $this->m_model->goto_temporary($nama_table_33);

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
        $path = "" ;
        
        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);

        $startdate = $data[0] ;
        $enddate = $data[1] ;
        $code_principal = $data[2] ;

        $nama_table_1 = "test.view_cont_move_recapitulation_".$username ;

        if($code_principal == 'All'){
            $path = APPPATH . 'modules/report_jasper/report_cont_movement_recapitulation_all.jrxml'; 
        }else{
            $path = APPPATH . 'modules/report_jasper/report_cont_movement_recapitulation.jrxml'; 
        }

        $data_1 = $this->ptmsagate->query(" SELECT * FROM ".$nama_table_1." ")->result_array() ;


        
        $PHPJasperXML = new PHPJasperXML("en","TCPDF"); 

        

        // $data_2 = $this->ptmsagate->query("SELECT * FROM ".$nama_table_2." ")->result_array();

        // $subreport_status = "" ;
        // $subreport_size = "" ;
        // $subreport_condition = "" ;
        // $subreport_masuk = "" ;
        // $garis="" ;
        // foreach($data_2 as $row){
        //     $subreport_status.= $row['cont_status']."\n" ;
        //     $subreport_size.= $row['reff_code']."\n" ;
        //     $subreport_condition.= $row['cont_condition']."\n" ;
        //     $subreport_masuk.= $row[$masuk]."\n" ;
        //     $garis.="\n" ;
        // }
        // $garis.="===============================================";

        $PHPJasperXML->arrayParameter = array(
            "username" => $this->session->userdata('autogate_username'),
            "startdate" => $startdate,
            "enddate" => $enddate,
            "jam_sekarang" => jam_sekarang(),
            "tanggal_sekarang" => showdate_dmy(tanggal_sekarang()),
        );

        
        //$PHPJasperXML->debugsql=true;   
        $PHPJasperXML->load_xml_file($path);
        $dbdriver="mysql";
        $version="1.1";
        $PHPJasperXML->transferDBtoArray($this->ptmsagate->hostname,$this->ptmsagate->username,$this->ptmsagate->password,$this->ptmsagate->database,$dbdriver);
        $PHPJasperXML->arraysqltable=$data_1;
        $PHPJasperXML->outpage('I');  
    }

}