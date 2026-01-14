<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_jenis_document extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->db_tpsonline = $this->load->database('db_tpsonline', TRUE);
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
    
    function c_tbl_jenis_document() {
        $database = "db_tpsonline";

        $select = 'id,jenis_document';
        $form = 'tbl_m_tps_dok_inout';
        $join = array();
        $where = array('rec_id' => 0);

        $where_term = array(
            'id', 'jenis_document'
        );
        $column_order = array(
            null, 'id', 'jenis_document'
        );
        $order = array(
            'id' => 'asc'
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
            $row[] = $field->id;
            $row[] = $field->jenis_document;
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
        $database = 'db_tpsonline' ;
        $jenis_document = $this->input->post('jenis_document');
        $id = $this->input->post('id');

        if($this->$database->get_where('tbl_m_tps_dok_inout',array('id' => $id))->num_rows() > 0){
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Kode Document Sudah Ada..!!!!',
                'data' => $data,
            );
            echo json_encode($pesan_data);
            die;
        }


        $data = array(
            'jenis_document' => $jenis_document,
            'rec_id' => 0,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
            'id' => $id,
        );
        $hasil = $this->m_model->savedata($database, 'tbl_m_tps_dok_inout', $data);
        
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
        $database = 'db_tpsonline' ;
        
        $id = $this->input->post('id');
        
        $array_data = $this->m_model->table_tostring($database, '', 'tbl_m_tps_dok_inout', '', array('id' => $id), '');
        $data = array(
            'array_data' => $array_data,
        );
        
        $this->load->view('edit',$data);
    }
    
    function c_update(){
        $database = 'db_tpsonline' ;
        
        $jenis_document = $this->input->post('jenis_document');
        $id = $this->input->post('id');
        $idold = $this->input->post('idold');

        if($id != $idold){
            if($this->$database->get_where('tbl_m_tps_dok_inout',array('id' => $id))->num_rows() > 0){
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Kode Document Sudah Ada..!!!!',
                );
                echo json_encode($pesan_data);
                die;
            } 
        }


            
        
        
        $where = array(
            'id' => $id
        );
  
        $data = array(
            'jenis_document' => $jenis_document,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
            'id' => $id
        );
        $hasil = $this->m_model->updatedata($database, 'tbl_m_tps_dok_inout', $data, $where);
        
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
        $database = 'db_tpsonline' ;

        $id = $this->input->post('id');
        
        $where = array(
            'id' => $id
        );
  
        $data = array(
            'rec_id' => 9,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->updatedata($database, 'tbl_m_tps_dok_inout', $data, $where);
        
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