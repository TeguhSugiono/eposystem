<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_mst_customer extends CI_Controller
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
        $comp = array(
            'content' => 'view'
        );

        $this->load->view('dashboard/index', $comp);
    }


    function c_fetch_table()
    {
        $ParamArray = array(
            'ConectDB' => 'dbAcct',
            'Table' => 'fin_ar_m_customer',
            'WhereData' => array('active_status' => 'Y'),
            'OrderBy' => 'created_on desc',
            'Field' => '*,concat(address1," ",address2," ",address3) "address"'
        );

        $GetData = $this->m_function->value_result_array($ParamArray);

        echo json_encode($GetData);
    }
}
