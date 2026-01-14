<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_list extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {            
            redirect(site_url('login'));
        }
        $this->jobpjt = $this->load->database('jobpjt', TRUE);    
    }
    
    function index(){
        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
        );
        $this->load->view('dashboard/index', $data);
        
    }
    
    function c_tbl_chkpjt(){
        $database = "jobpjt" ;
        
        $select = 'nojob,tgljob,pibk,tglpibk,nmimportir,nocontainer,size,asalbarang,status' ;
        $form = 'pjt_check_container' ;        
        $join = array();        
        $where = array('aktif' => 0, 'status' => 'OnProgress');
        
        $where_term = array(
                                        'nojob', 'tgljob', 'pibk', 'tglpibk', 'nmimportir', 'nocontainer', 'size', 'asalbarang', 'status'
                                    );
        $column_order = array(
                                        null, 'nojob', 'tgljob', 'pibk', 'tglpibk', 'nmimportir', 'nocontainer', 'size', 'asalbarang', 'status'
                                    );
        $order = array(
            'nojob' => 'asc'
        );
        
        $group = array() ;
        
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
        
        $list = $this->m_model->get_datatables($database,$array_table);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no;
            $row[] = $field->nojob;
            $row[] = showdate_dmy($field->tgljob);
            $row[] = $field->pibk;
            $row[] = showdate_dmy($field->tglpibk);
            $row[] = $field->nmimportir;
            $row[] = $field->nocontainer;
            $row[] = $field->size;
            $row[] = $field->asalbarang;
            $row[] = $field->status;            
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_model->count_all($database,$array_table),
            "recordsFiltered" => $this->m_model->count_filtered($database,$array_table),
            "data" => $data,
        );

        echo json_encode($output);
    }
    
}