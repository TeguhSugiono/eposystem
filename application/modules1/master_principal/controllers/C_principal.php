<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_principal extends CI_Controller {

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
    
    function c_tbl_principal() {
        $database = "ptmsagate";

        $select = 'id_principal,code_principal,name_principal,address_1,address_2,no_telp,no_fax';
        $form = 't_m_principal';
        $join = array();
        $where = array('rec_id' => 0);

        $where_term = array(
            'id_principal','code_principal','name_principal','address_1','address_2','no_telp','no_fax'
        );
        $column_order = array(
            null, 'id_principal','code_principal','name_principal','address_1','address_2','no_telp','no_fax'
        );
        $order = array(
            'id_principal' => 'desc'
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
            $row[] = $field->id_principal;
            $row[] = $field->code_principal;
            $row[] = $field->name_principal;
            $row[] = $field->address_1;
            $row[] = $field->address_2;
            $row[] = $field->no_telp;
            $row[] = $field->no_fax;
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

        $code_principal = $this->input->post('code_principal');
        $name_principal = $this->input->post('name_principal');
        $address_1 = $this->input->post('address_1');
        $address_2 = $this->input->post('address_2');
        $no_telp = $this->input->post('no_telp');
        $no_fax = $this->input->post('no_fax');
        
        $data = array(
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'address_1' => $address_1,
            'address_2' => $address_2,
            'no_telp' => $no_telp,
            'no_fax' => $no_fax,
            'rec_id' => 0,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
        );
        
        
        $hasil = $this->m_model->savedata($database, 't_m_principal', $data);
        
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
        
        $id_principal = $this->input->post('id_principal');
        
        $array_data = $this->m_model->table_tostring($database, '', 't_m_principal', '', array('id_principal' => $id_principal), '');
        $data = array(
            'array_data' => $array_data,
        );
        
        $this->load->view('edit',$data);
    }
    
    function c_update(){
        $database = 'ptmsagate' ;
        
        $id_principal = $this->input->post('id_principal');
        $code_principal = $this->input->post('code_principal');
        $name_principal = $this->input->post('name_principal');
        $address_1 = $this->input->post('address_1');
        $address_2 = $this->input->post('address_2');
        $no_telp = $this->input->post('no_telp');
        $no_fax = $this->input->post('no_fax');
        
        $where = array(
            'id_principal' => $id_principal
        );
  
        $data = array(
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'address_1' => $address_1,
            'address_2' => $address_2,
            'no_telp' => $no_telp,
            'no_fax' => $no_fax,
            'rec_id' => 0,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        
        $hasil = $this->m_model->updatedata($database, 't_m_principal', $data, $where);
        
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
        
        $id_principal = $this->input->post('id_principal');
        
        $where = array(
            'id_principal' => $id_principal
        );
  
        $data = array(
            'rec_id' => 9,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->updatedata($database, 't_m_principal', $data, $where);

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