<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_unblock extends CI_Controller {

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
    
    function c_tbl_unblock() {
        $database = "ptmsagate";

        $select = 'id_unblock_location,unblock_code,block_loc,location';
        $form = 't_m_unblock_location';
        $join = array();
        $where = array('rec_id' => 0);

        $where_term = array(
            'id_unblock_location','unblock_code','block_loc','location'
        );
        $column_order = array(
            null, 'id_unblock_location','unblock_code','block_loc','location'
        );
        $order = array(
            'id_unblock_location' => 'desc'
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
            $row[] = $field->id_unblock_location;
            $row[] = $field->unblock_code;
            $row[] = $field->block_loc;
            $row[] = $field->location;
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
        $database = 'ptmsagate' ;

        $unblock_code = $this->input->post('unblock_code');
        $block_loc = $this->input->post('block_loc');
        $row = $this->input->post('row');
        $col = $this->input->post('col');
        $stack = $this->input->post('stack');
        $location = $row.' '.$col.' '.$stack ;
        
        $data = array(
            'unblock_code' => $unblock_code,
            'block_loc' => $block_loc,
            'location' => $location,
            'rec_id' => 0,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
        );
        
        
        $hasil = $this->m_model->savedata($database, 't_m_unblock_location', $data);
        
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
        $database = 'ptmsagate' ;
        
        $id_unblock = $this->input->post('id_unblock');
        
        $array_data = $this->m_model->table_tostring($database, '', 't_m_unblock_location', '', array('id_unblock_location' => $id_unblock), '');
        $data = array(
            'array_data' => $array_data,
        );
        
        $this->load->view('edit',$data);
    }
    
    function c_update(){
        $database = 'ptmsagate' ;
        
        $id_unblock = $this->input->post('id_unblock_location');
        $unblock_code = $this->input->post('unblock_code');
        $block_loc = $this->input->post('block_loc');
        $row = $this->input->post('row');
        $col = $this->input->post('col');
        $stack = $this->input->post('stack');
        $location = $row.' '.$col.' '.$stack ;
        
        $data = array(
            'unblock_code' => $unblock_code,
            'block_loc' => $block_loc,
            'location' => $location,
            'rec_id' => 0,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        
        $where = array(
            'id_unblock_location' => $id_unblock
        );
        
        $hasil = $this->m_model->updatedata($database, 't_m_unblock_location', $data, $where);
        
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
        $database = 'ptmsagate' ;
        
        $id_unblock = $this->input->post('id_unblock');
        
        $where = array(
            'id_unblock_location' => $id_unblock
        );
  
        $data = array(
            'rec_id' => 9,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->updatedata($database, 't_m_unblock_location', $data, $where);

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