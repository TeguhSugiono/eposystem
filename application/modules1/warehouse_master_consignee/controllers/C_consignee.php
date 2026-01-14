<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_consignee extends CI_Controller {

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
    
    function c_tbl_consignee() {
        $database = "tribltps";

        $select = 'consignee_id,consignee_name,consignee_address1,consignee_address2,consignee_address3';
        $form = 'whs_m_consignee';
        $join = array();
        $where = array('rec_id' => 0);

        $where_term = array(
            'consignee_id', 'consignee_name', 'consignee_address1','consignee_address2','consignee_address3'
        );
        $column_order = array(
            null, 'consignee_id', 'consignee_name', 'consignee_address1','consignee_address2','consignee_address3'
        );
        $order = array(
            'consignee_id' => 'desc'
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
            $row[] = $field->consignee_id;
            $row[] = $field->consignee_name;
            $row[] = $field->consignee_address1;
            $row[] = $field->consignee_address2;
            $row[] = $field->consignee_address3;
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
        $consignee_name = $this->input->post('consignee_name');
        $consignee_address1 = $this->input->post('consignee_address1');
        $consignee_address2 = $this->input->post('consignee_address2');
        $consignee_address3 = $this->input->post('consignee_address3');
        $data = array(
            'consignee_name' => $consignee_name,
            'consignee_address1' => $consignee_address1,
            'consignee_address2' => $consignee_address2,
            'consignee_address3' => $consignee_address3,
            'rec_id' => 0,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->savedata($database, 'whs_m_consignee', $data);
        
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
        
        $consignee_id = $this->input->post('consignee_id');
        
        $array_data = $this->m_model->table_tostring($database, 'consignee_id,consignee_name,consignee_address1,consignee_address2,consignee_address3', 
            'whs_m_consignee', '', array('consignee_id' => $consignee_id), '');
        $data = array(
            'array_data' => $array_data,
        );
        
        $this->load->view('edit',$data);
    }
    
    function c_update(){
        $database = 'tribltps' ;
        
        $consignee_name = $this->input->post('consignee_name');
        $consignee_address1 = $this->input->post('consignee_address1');
        $consignee_address2 = $this->input->post('consignee_address2');
        $consignee_address3 = $this->input->post('consignee_address3');
        $consignee_id = $this->input->post('consignee_id');
        
        $where = array(
            'consignee_id' => $consignee_id
        );
  
        $data = array(
            'consignee_name' => $consignee_name,
            'consignee_address1' => $consignee_address1,
            'consignee_address2' => $consignee_address2,
            'consignee_address3' => $consignee_address3,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->updatedata($database, 'whs_m_consignee', $data, $where);
        
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

        $consignee_id = $this->input->post('consignee_id');
        
        $where = array(
            'consignee_id' => $consignee_id
        );
  
        $data = array(
            'rec_id' => 9,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->updatedata($database, 'whs_m_consignee', $data, $where);
        
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