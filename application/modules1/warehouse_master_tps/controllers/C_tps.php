<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_tps extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
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
    
    function c_tbl_tps() {
        $database = "tribltps";

        $select = 'tps_id,tps_name,tps_address1,tps_address2,tps_address3';
        $form = 'whs_m_tps';
        $join = array();
        $where = array('rec_id' => 0);

        $where_term = array(
            'tps_id', 'tps_name', 'tps_address1','tps_address2','tps_address3'
        );
        $column_order = array(
            null, 'tps_id', 'tps_name', 'tps_address1','tps_address2','tps_address3'
        );
        $order = array(
            'tps_id' => 'desc'
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
            $row[] = $field->tps_id;
            $row[] = $field->tps_name;
            $row[] = $field->tps_address1;
            $row[] = $field->tps_address2;
            $row[] = $field->tps_address3;
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
    
    function c_formadd(){
        $this->load->view('add');
    }
    
    function c_save(){
        $database = 'tribltps' ;
        $tps_name = $this->input->post('tps_name');
        $tps_address1 = $this->input->post('tps_address1');
        $tps_address2 = $this->input->post('tps_address2');
        $tps_address3 = $this->input->post('tps_address3');
        $data = array(
            'tps_name' => $tps_name,
            'tps_address1' => $tps_address1,
            'tps_address2' => $tps_address2,
            'tps_address3' => $tps_address3,
            'rec_id' => 0,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->savedata($database, 'whs_m_tps', $data);
        
        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Save Data Sukses..',
                'data' => $data,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Save Data Error....!!!!',
                'data' => $data,
            );
            echo json_encode($pesan_data);
            die;
        }
        
        echo json_encode($pesan_data);
        
    }
    
    function c_formedit(){
        $database = 'tribltps' ;
        
        $tps_id = $this->input->post('tps_id');
        
        $array_data = $this->m_model->table_tostring($database, 'tps_id,tps_name,tps_address1,tps_address2,tps_address3', 
            'whs_m_tps', '', array('tps_id' => $tps_id), '');
        $data = array(
            'array_data' => $array_data,
        );
        
        $this->load->view('edit',$data);
    }
    
    function c_update(){
        $database = 'tribltps' ;
        
        $tps_name = $this->input->post('tps_name');
        $tps_address1 = $this->input->post('tps_address1');
        $tps_address2 = $this->input->post('tps_address2');
        $tps_address3 = $this->input->post('tps_address3');
        $tps_id = $this->input->post('tps_id');
        
        $where = array(
            'tps_id' => $tps_id
        );
  
        $data = array(
            'tps_name' => $tps_name,
            'tps_address1' => $tps_address1,
            'tps_address2' => $tps_address2,
            'tps_address3' => $tps_address3,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->updatedata($database, 'whs_m_tps', $data, $where);
        
        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Update Data Sukses..',
                'data' => $data,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Update Data Error....!!!!',
                'data' => $data,
            );
            echo json_encode($pesan_data);
            die;
        }
        
        
        echo json_encode($pesan_data);
        
    }
    
    function c_delete(){
        $database = 'tribltps' ;

        $tps_id = $this->input->post('tps_id');
        
        $where = array(
            'tps_id' => $tps_id
        );
  
        $data = array(
            'rec_id' => 9,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->updatedata($database, 'whs_m_tps', $data, $where);
        
        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Delete Data Sukses..',
                'data' => $data,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Delete Data Error....!!!!',
                'data' => $data,
            );
            echo json_encode($pesan_data);
            die;
        }
        
        
        echo json_encode($pesan_data);
    }
    
}