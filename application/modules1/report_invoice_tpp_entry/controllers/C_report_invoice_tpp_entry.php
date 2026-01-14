<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class C_report_invoice_tpp_entry extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        //$this->ptmsagate = $this->load->database('ptmsagate', TRUE);        
        $this->ptmsadbo = $this->load->database('ptmsadbo', TRUE);     
    }

    function index(){
        $this->m_model->drop_temporary();

        $menu_active = $this->m_model->menu_active();

        $arraydata = $this->ptmsadbo->query("SELECT DISTINCT Consignee,Consignee 'Consignee2' 
            from tpp_t_manual_invoice_head where status not in ('D','V') order by Consignee")->result_array();
        array_push($arraydata, array('Consignee' => '' , 'Consignee2' => 'All'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'consignee', 'class' => 'selectpicker'),
        );
        $arraydata = array('' => 'All','Empty' => 'Empty','Ext Empty' => 'Ext Empty','Ext Full' => 'Ext Full' ,'BM' => 'BM','Ext Cargo' => 'Ext Cargo');
        $txn_code = ComboNonDb($arraydata, 'txn_code', '', 'form-control');

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'consignee' => ComboDb($createcombo),
            'txn_code' => $txn_code,
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_export(){
        $username = $this->session->userdata('autogate_username') ;
        $nama_table_1 = "" ;
        $nama_table_2 = "" ;
        $path = "" ;
        $path_subreport = "" ;
        
        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);

        $startdate = date_db($data[0]) ;
        $enddate = date_db($data[1]) ;
        $txn_code = $data[2] ;
        $consignee = $data[3] ;


        $query = "" ;
        $query.= "  SELECT  'nomor' as 'No',a.invoice_no 'Nomor Invoice',date_format(a.invoice_date,'%d-%m-%Y') 'Tgl Invoice', " ;
        $query.= "  a.consignee 'Consignee', a.total - (a.potongan + a.biaya_dimuka) 'Subtotal' , " ;
        $query.= "  a.jumlah_ppn 'PPN',a.administrasi 'Administrasi',a.biaya_lain 'Lain-lain',a.grand_total 'Total' " ;
        $query.= "  FROM tpp_t_manual_invoice_head a " ;
        $query.= "  INNER JOIN whs_vw_customer b  ON a.cust_code=b.cust_code " ;
        $query.= "  INNER JOIN whs_m_jenis_pendapatan c ON a.ar_type_code=c.ar_type_code  " ;
        $query.= "  WHERE a.invoice_date >= '".$startdate."' AND a.invoice_date <= '".$enddate."'  " ;
        if($consignee != ""){$query.= " and a.consignee = '".$consignee."' " ;}
        if($txn_code != ""){$query.= " and a.txn_code = '".$txn_code."' " ;}

        $query.= "  AND a.status not in('V','D')  ORDER BY a.invoice_no asc " ;

        $data = $this->ptmsadbo->query($query)->result_array();

        if(count($data) == 0){
            echo 'Data Tidak Ditemukan' ;die;
        }

        //Setting Sheet Excel
        $nama_excel = "Report_InvEntry_Tpp_".tanggal_sekarang() ;

        $nama_sheet = array(
            '0' => 'List Invoice Entry TPP',
        );

        $data_all_sheet = array(
            '0' => $data,
        );

        $setting_xls = array(
            'jumlah_sheet' => 1 ,
            'nama_excel' => $nama_excel,
            'nama_sheet' => $nama_sheet,
            'data_all_sheet' => $data_all_sheet,
        );

        //print("<pre>".print_r($setting_xls,true)."</pre>"); die;
        $this->m_model->generator_xls_invtppA($setting_xls);

    }
}