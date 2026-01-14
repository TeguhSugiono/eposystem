<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_trans_receipt extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('PO_logged') <> 1) {
            redirect(site_url('login'));
        }
    }

    function index()
    {


        // $ParamArray = array(
        //     'Table' => 'tbl_request_po',
        //     'WhereData' => array('id_pesan' => '1590'),
        //     'OrderBy' => 'id_request desc',
        //     'Limit' => '1'
        // );
        // print_r($this->m_function->value_result_array($ParamArray));

        // $ParamArray = array(
        //     'Table' => 'tbl_request_po',
        //     'WhereData' => array('id_pesan' => '1590', 'flag_request !=' => '9'),
        //     'OrderBy' => 'id_request desc',
        //     'Limit' => '1',
        //     'Field' => 'id_status_approval'
        // );
        // print_r($this->m_function->check_value($ParamArray));
        // die;



        // die;

        // $ParamArray = array(
        //     'Table' => 'tbl_request_po',
        //     'WhereData' => array('id_request' => 1)
        // );

        // $GetDataRequest = $this->m_function->value_result_array($ParamArray);

        // print_r($GetDataRequest);
        // die;

        $comp = array(
            'content' => 'view'
        );

        $this->load->view('dashboard/index', $comp);
    }

    function c_fetch_table()
    {
        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $ArrayJoin = array(
            array('masterdivisi b', 'a.kode_divisi=b.kode_divisi', 'left'),
            array('mastersupplier c', 'a.kodesupplier=c.kodesupplier', 'left')
        );

        $ParamArray = array(
            'Table' => 'transpesan_head a',
            'WhereData' => array('a.kode_divisi' => $PO_kodedivisi, 'a.status !=' => 'V'),
            'OrderBy' => 'a.created_on desc,a.tglpesan desc',
            'ArrayJoin' => $ArrayJoin,
            'Field' => 'a.*,b.nama_divisi AS nama_divisi,c.namasupplier,ppn_param_date(a.tglpesan) AS ppn_used,get_company(a.nopo) as comp'
        );

        $ParamArray = hakakses($ParamArray);

        $GetData = $this->m_function->value_result_array($ParamArray);

        echo json_encode($GetData);
    }

    function c_fetch_table_detail()
    {

        $id_pesan = $this->input->post('id_pesan');

        $ArrayJoin = array(
            array('masterbarang b', 'a.kode_brg=b.kodebarang', 'inner'),
        );

        $ParamArray = array(
            'Table' => 'brg_terima a',
            'WhereData' => array('a.id_terima' => $id_pesan),
            'ArrayJoin' => $ArrayJoin,
            'GroupBy' => 'sn'
        );


        $GetData = $this->m_function->value_result_array($ParamArray);

        echo json_encode($GetData);
    }

    function c_edit_data()
    {
        $comp = array(
            // 'GetDataRequest' => $GetDataRequest,
            // 'id_pesan' => $id_pesan,
            // 'id_status_approval' => $id_status_approval
        );

        $this->load->view('edit', $comp);
    }
}
