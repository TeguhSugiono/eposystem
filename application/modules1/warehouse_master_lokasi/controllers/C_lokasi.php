<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_lokasi extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }

        $this->tribltps = $this->load->database('tribltps', TRUE); 
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
    
    function c_tbl_lokasi() {
        $database = "tribltps";

        $select = 'a.location_id,a.location_name,a.qty_max,a.flag_bahandle,a.status,a.category_id,b.category_kode,a.uses';
        $form = 'whs_m_location as a';
        $join = array(
            array('whs_m_category as b','a.category_id=b.category_id','left')
        );
        $where = array('a.rec_id' => 0);

        $where_term = array(
            'a.location_id', 'a.location_name', 'a.qty_max','a.flag_bahandle','a.status','a.category_id','b.category_kode','a.uses'
        );
        $column_order = array(
            null, 'a.location_id', 'a.location_name', 'a.qty_max','a.flag_bahandle','a.status','a.category_id','b.category_kode','a.uses'
        );
        $order = array(
            'a.location_id' => 'desc'
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
            $row[] = $field->location_id;
            $row[] = $field->location_name;
            $row[] = $field->qty_max;
            //$row[] = $field->flag_bahandle;
            if($field->flag_bahandle == 0){
                $row[] = 'No' ;
            }else{
                $row[] = 'Yes' ;
            }
            $row[] = $field->status;
            $row[] = $field->category_id;
            $row[] = $field->category_kode;
            $row[] = $field->uses;
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
        $arraydata = $this->tribltps->query("SELECT category_id,category_name FROM whs_m_category WHERE rec_id = '0'")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'category_id', 'class' => 'selectpicker'),
        );
        $category_id = ComboDb($createcombo);

        $data['category_id'] = $category_id;

        $arraydata = array('0' => 'No', '1' => 'Yes');
        $flag_bahandle = ComboNonDb($arraydata, 'flag_bahandle', '0', 'form-control');
        $data['flag_bahandle'] = $flag_bahandle;

        $this->load->view('add',$data);
    }
    
    function c_save(){
        $database = 'tribltps' ;
        $location_name = $this->input->post('location_name');
        $qty_max = $this->input->post('qty_max');
        $flag_bahandle = $this->input->post('flag_bahandle');
        $category_id = $this->input->post('category_id');
        $data = array(
            'location_name' => $location_name,
            'qty_max' => $qty_max,
            'flag_bahandle' => $flag_bahandle,
            'category_id' => $category_id,
            'rec_id' => 0,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->savedata($database, 'whs_m_location', $data);
        
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
        
        $location_id = $this->input->post('location_id');
        
        $array_data = $this->m_model->table_tostring($database, 'location_id,location_name,qty_max,flag_bahandle,category_id', 'whs_m_location', '', array('location_id' => $location_id), '');
        $data = array(
            'array_data' => $array_data,
        );


        $arraydata = $this->tribltps->query("SELECT category_id,category_name FROM whs_m_category WHERE rec_id = '0'")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => $array_data['category_id']),
            'attribute' => array('idname' => 'category_id', 'class' => 'selectpicker'),
        );
        $category_id = ComboDb($createcombo);

        $data['category_id'] = $category_id;

        $arraydata = array('0' => 'No','1' => 'Yes');
        $flag_bahandle = ComboNonDb($arraydata, 'flag_bahandle', $array_data['flag_bahandle'], 'form-control');
        $data['flag_bahandle'] = $flag_bahandle;
        
        $this->load->view('edit',$data);
    }
    
    function c_update(){
        $database = 'tribltps' ;
        
        $location_name = $this->input->post('location_name');
        $qty_max = $this->input->post('qty_max');
        $location_id = $this->input->post('location_id');
        $flag_bahandle = $this->input->post('flag_bahandle');
        $category_id = $this->input->post('category_id');
        
        $where = array(
            'location_id' => $location_id
        );
  
        $data = array(
            'location_name' => $location_name,
            'qty_max' => $qty_max,
            'flag_bahandle' => $flag_bahandle,
            'category_id' => $category_id,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->updatedata($database, 'whs_m_location', $data, $where);
        
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

        $location_id = $this->input->post('location_id');
        
        $where = array(
            'location_id' => $location_id
        );
  
        $data = array(
            'rec_id' => 9,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->m_model->updatedata($database, 'whs_m_location', $data, $where);
        
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