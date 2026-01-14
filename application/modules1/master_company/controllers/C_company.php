<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_company extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);
    }
    
    function index() {
        $database = "ptmsagate";
        $field_Search = 'id_company,company_name,branch_name,branch_code,address,region,city,no_telp,no_fax';
        $table_name = 't_m_company';
        $where = array(
            'rec_id' => 0,
        );
        $array_data = $this->m_model->table_tostring($database, $field_Search, $table_name, '', $where, '');
        $data['array_data'] = $array_data ;
        
        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'array_data' => $array_data
        );
        $this->load->view('dashboard/index', $data);
    }
    
    function c_save(){
        $database = "ptmsagate";
        
        $pesan_data = array(
            'msg' => 'Tidak',
            'pesan' => 'Function Update Data Error....!!!!',
        );
        
        if($this->input->post('id_company') != ""){

            $where = array('id_company' => $this->input->post('id_company'));

            $data = array(                
                'company_name' => $this->input->post('company_name'),
                'branch_name' => $this->input->post('branch_name'),
                'branch_code' => $this->input->post('branch_code'),
                'address' => $this->input->post('address'),
                'region' => $this->input->post('region'),
                'city' => $this->input->post('city'),
                'no_telp' => $this->input->post('city'),
                'no_fax' => $this->input->post('no_fax'),
                'rec_id' => 0,
                'edited_by' => $this->session->userdata('autogate_username'),
                'edited_on' => tanggal_sekarang(),
            );

            $hasil = $this->m_model->updatedata($database, 't_m_company', $data, $where);

            if ($hasil >= 1) {
                $pesan_data = array(
                    'msg' => 'Ya',
                    'pesan' => 'Update Data Sukses..',
                );
            }else{
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Function Update Data Error....!!!!',
                );echo json_encode($pesan_data); die;
            }
            
        }else{
            $id_company = $this->m_model->select_max_where($database, 't_m_company', 'id_company','') ;
            
            $data = array(
                'id_company' => $id_company,
                'company_name' => $this->input->post('company_name'),
                'branch_name' => $this->input->post('branch_name'),
                'branch_code' => $this->input->post('branch_code'),
                'address' => $this->input->post('address'),
                'region' => $this->input->post('region'),
                'city' => $this->input->post('city'),
                'no_telp' => $this->input->post('city'),
                'no_fax' => $this->input->post('no_fax'),
                'rec_id' => 0,                
                'created_by' => $this->session->userdata('autogate_username'),
                'created_on' => tanggal_sekarang(),
            );
            
            $hasil = $this->m_model->savedata($database, 't_m_company', $data);
            
            if ($hasil >= 1) {
                $pesan_data = array(
                    'msg' => 'Ya',
                    'pesan' => 'Simpan Data Sukses..',
                    'id_company' => $id_company,
                );
            }else{
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Function Save Data Error....!!!!',
                    'id_company' => $id_company,
                );echo json_encode($pesan_data); die;
            }
            
        }
        
            
        
        echo json_encode($pesan_data);
        
    }
    
}
