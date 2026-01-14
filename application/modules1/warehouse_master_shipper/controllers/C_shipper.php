<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_shipper extends CI_Controller {

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
    
    function c_tbl_shipper() {
        $database = "tribltps";

        $select = 'shipper_id,shipper_name,shipper_address1,shipper_address2,shipper_address3';
        $form = 'whs_m_shipper';
        $join = array();
        $where = array('rec_id' => 0);

        $where_term = array(
            'shipper_id', 'shipper_name', 'shipper_address1','shipper_address2','shipper_address3'
        );
        $column_order = array(
            null, 'shipper_id', 'shipper_name', 'shipper_address1','shipper_address2','shipper_address3'
        );
        $order = array(
            'shipper_id' => 'desc'
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
            $row[] = $field->shipper_id;
            $row[] = $field->shipper_name;
            $row[] = $field->shipper_address1;
            $row[] = $field->shipper_address2;
            $row[] = $field->shipper_address3;
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
        $shipper_name = $this->input->post('shipper_name');
        $shipper_address1 = $this->input->post('shipper_address1');
        $shipper_address2 = $this->input->post('shipper_address2');
        $shipper_address3 = $this->input->post('shipper_address3');
        $data = array(
            'shipper_name' => $shipper_name,
            'shipper_address1' => $shipper_address1,
            'shipper_address2' => $shipper_address2,
            'shipper_address3' => $shipper_address3,
            'rec_id' => 0,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->savedata($database, 'whs_m_shipper', $data);
        
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
        
        $shipper_id = $this->input->post('shipper_id');
        
        $array_data = $this->m_model->table_tostring($database, 'shipper_id,shipper_name,shipper_address1,shipper_address2,shipper_address3', 
            'whs_m_shipper', '', array('shipper_id' => $shipper_id), '');
        $data = array(
            'array_data' => $array_data,
        );
        
        $this->load->view('edit',$data);
    }
    
    function c_update(){
        $database = 'tribltps' ;
        
        $shipper_name = $this->input->post('shipper_name');
        $shipper_address1 = $this->input->post('shipper_address1');
        $shipper_address2 = $this->input->post('shipper_address2');
        $shipper_address3 = $this->input->post('shipper_address3');
        $shipper_id = $this->input->post('shipper_id');
        
        $where = array(
            'shipper_id' => $shipper_id
        );
  
        $data = array(
            'shipper_name' => $shipper_name,
            'shipper_address1' => $shipper_address1,
            'shipper_address2' => $shipper_address2,
            'shipper_address3' => $shipper_address3,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->updatedata($database, 'whs_m_shipper', $data, $where);
        
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

        $shipper_id = $this->input->post('shipper_id');
        
        $where = array(
            'shipper_id' => $shipper_id
        );
  
        $data = array(
            'rec_id' => 9,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->updatedata($database, 'whs_m_shipper', $data, $where);
        
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