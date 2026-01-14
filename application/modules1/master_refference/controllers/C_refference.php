<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_refference extends CI_Controller {

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
    
    function c_tbl_refference() {
        $database = "ptmsagate";

        $select = 'id_refference,reff_code,reff_description';
        $form = 't_m_refference';
        $join = array();
        $where = array('rec_id' => 0);

        $where_term = array(
            'id_refference', 'reff_code', 'reff_description'
        );
        $column_order = array(
            null, 'id_refference', 'reff_code', 'reff_description'
        );
        $order = array(
            'id_refference' => 'desc'
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
            $row[] = $field->id_refference;
            $row[] = $field->reff_code;
            $row[] = $field->reff_description;
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
        $reff_code = $this->input->post('reff_code');
        $reff_description = $this->input->post('reff_description');
        $data = array(
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'rec_id' => 0,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->savedata($database, 't_m_refference', $data);
        
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
        
        $id_refference = $this->input->post('id_refference');
        
        $array_data = $this->m_model->table_tostring($database, 'id_refference,reff_code,reff_description', 't_m_refference', '', array('id_refference' => $id_refference), '');
        $data = array(
            'array_data' => $array_data,
        );
        
        $this->load->view('edit',$data);
    }
    
    function c_update(){
        $database = 'ptmsagate' ;
        
        $reff_code = $this->input->post('reff_code');
        $reff_description = $this->input->post('reff_description');
        $id_refference = $this->input->post('id_refference');
        
        $where = array(
            'id_refference' => $id_refference
        );
  
        $data = array(
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->updatedata($database, 't_m_refference', $data, $where);
        
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

        $id_refference = $this->input->post('id_refference');
        
        $where = array(
            'id_refference' => $id_refference
        );
  
        $data = array(
            'rec_id' => 9,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->updatedata($database, 't_m_refference', $data, $where);
        
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