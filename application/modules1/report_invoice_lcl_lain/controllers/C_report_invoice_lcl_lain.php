<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class C_report_invoice_lcl_lain extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        //$this->ptmsagate = $this->load->database('ptmsagate', TRUE);        
        $this->tribltps = $this->load->database('tribltps', TRUE);     
    }

    function index(){
        $this->m_model->drop_temporary();

        $menu_active = $this->m_model->menu_active();

        $arraydata = $this->tribltps->query("SELECT cust_code,cust_name from whs_vw_customer where active_status='Y' 
            and cust_category='Non TPP' order by cust_name  ")->result_array();
        array_push($arraydata, array('cust_code' => '' , 'cust_name' => 'All'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'cust_name', 'class' => 'selectpicker'),
        );

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'cust_name' => ComboDb($createcombo),
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
        $cust_name = $data[2] ;

 

        $query = "" ;
        $query.= " SELECT distinct 'nomor' as 'No',a.invoice_no 'Nomor Invoice',date_format(a.invoice_date,'%d-%m-%Y') 'Tgl Invoice', " ;
        $query.= " b.cust_name 'Customer' ,a.total - (a.potongan + a.biaya_dimuka) 'Subtotal', " ;
        $query.= " a.jumlah_ppn 'PPN',a.administrasi 'Administrasi',a.biaya_lain 'Lain-lain',a.grand_total 'Total' " ;
        $query.= " FROM whs_t_invoice_header a  " ;
        $query.= " INNER JOIN whs_vw_customer b  ON a.cust_code=b.cust_code  " ;
        $query.= " INNER JOIN whs_m_jenis_pendapatan c ON a.ar_type_code=c.ar_type_code  " ;
        $query.= " INNER JOIN whs_t_invoice_detail d ON a.invoice_no = d.invoice_no   " ;
        $query.= " LEFT JOIN whs_t_tax_invoice e ON a.invoice_no = e.invoice_no  " ;
        $query.= " WHERE (a.invoice_date >= '".date_db($startdate)."' AND a.invoice_date <= '".date_db($enddate)."')  " ;

        if($cust_name != ""){$query.= " and b.cust_code = '".$cust_name."' " ;}


        $query.= "  AND a.status <> 'V'  ORDER BY a.invoice_no asc " ;

        $data = $this->tribltps->query($query)->result_array();

        if(count($data) == 0){
            echo 'Data Tidak Ditemukan' ;die;
        }

        //Setting Sheet Excel
        $nama_excel = "Report_InvLain_Lcl_".tanggal_sekarang() ;

        $nama_sheet = array(
            '0' => 'List Invoice Lainlain LCL',
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