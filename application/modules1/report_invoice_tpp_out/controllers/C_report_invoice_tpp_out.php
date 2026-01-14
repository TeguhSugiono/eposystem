<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class C_report_invoice_tpp_out extends CI_Controller {

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

        $arraydata = $this->ptmsadbo->query("SELECT DISTINCT Consignee,Consignee 'Consignee2' from tpp_t_inv_header where rec_id=0 order by Consignee")->result_array();
        array_push($arraydata, array('Consignee' => '' , 'Consignee2' => 'All'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'consignee', 'class' => 'selectpicker'),
        );
        $arraydata = array('' => 'All','Ditebus' => 'Ditebus','Lelang' => 'Lelang','Hibah' => 'Hibah' ,'Cacah/Bahandle' => 'Cacah/Bahandle');
        $tipe_invoice = ComboNonDb($arraydata, 'tipe_invoice', '', 'form-control');

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'consignee' => ComboDb($createcombo),
            'tipe_invoice' => $tipe_invoice,
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_proses(){
        $this->m_model->drop_temporary();

        $username = $this->session->userdata('autogate_username') ;
        $startdate = date_db($this->input->post('startdate'));
        $enddate = date_db($this->input->post('enddate'));
        $tipe_invoice = $this->input->post('tipe_invoice');
        $consignee = $this->input->post('consignee');

        $a=0;

        $pesan_data = array(
            'msg'   => 'Tidak',
            'pesan' => 'Proses data gagal...'
        );

        $nama_table_1 = "inv_tpp_out_".$username ;
        $query = "";
        $query.= "DROP TABLE IF EXISTS test.".$nama_table_1;
        $excute = $this->ptmsadbo->query($query);
        $queryku[$a++] = $this->ptmsadbo->last_query();

        $query = "" ;
        $query.= " CREATE TABLE test.".$nama_table_1." AS " ;
        $query.= " SELECT a.Inv_Number,a.Tgl_Inv,a.Consignee,a.Address,a.DO,Voyage,a.Party,a.Tiba,a.Masuk,a.Stripping, " ;
        $query.= " a.Keluar,a.JnsCargo,a.T_In_ID,IFNULL( a.BiayaTPS, 0 ) AS Biaya_TPS, " ;
        $query.= " (IFNULL( a.Surcharge, 0 )+ IFNULL( a.BiayaLainTPP, 0 ) + b.Jml_Container + b.Jml_Cargo + b.Jml_Lelang ) AS Biaya_TPP, " ;
        $query.= " IFNULL( a.PPN, 0 ) AS PPN,IFNULL( a.BiayaAdm, 0 ) AS Biaya_Admin, " ;
        $query.= " IFNULL( a.BiayaLainTPS, 0 ) AS Biaya_Lain, " ;
        $query.= " (IFNULL( a.BiayaTPS, 0 ) + IFNULL( a.Surcharge, 0 ) + IFNULL( a.BiayaLainTPP, 0 ) + b.Jml_Container + b.Jml_Cargo + b.Jml_Lelang + IFNULL( a.PPN, 0 ) + " ;
        $query.= " IFNULL( a.BiayaAdm, 0 ) + IFNULL( a.BiayaLainTPS, 0 )) AS Jumlah,a.KdOut  " ;
        $query.= " FROM tpp_t_inv_header AS a,(SELECT a.Inv_Number,ifnull( SUM( b.Jumlah ), 0 ) AS Jml_Container, " ;
        $query.= " ifnull( SUM( c.Jumlah ), 0 ) AS Jml_Cargo,ifnull( SUM( d.Total ), 0 ) AS Jml_Lelang  " ;
        $query.= " FROM tpp_t_inv_header a " ;
        $query.= " LEFT OUTER JOIN tpp_t_inv_biaya b ON a.Rec_ID = '0' AND a.Inv_Number = b.Inv_Number " ;
        $query.= " LEFT OUTER JOIN tpp_t_inv_biaya_cargo c ON a.Rec_ID = '0' AND a.Inv_Number = c.Inv_Number " ;
        $query.= " LEFT OUTER JOIN tpp_t_inv_biaya_lelang d ON a.Rec_ID = '0' AND a.Inv_Number = d.Inv_Number " ;
        $query.= " WHERE date_format(a.Tgl_Inv,'%Y-%m-%d') >= '".$startdate."' and date_format(a.Tgl_Inv,'%Y-%m-%d') <= '".$enddate."'  " ;
        if($consignee != ""){$query.= " and a.consignee = '".$consignee."' " ;}
        if($tipe_invoice == "Ditebus"){
            $query.= " and a.KdOut in ('D') " ;
        }else if($tipe_invoice == "Lelang"){
            $query.= " and a.KdOut in ('L') " ;
        }else if($tipe_invoice == "Hibah"){
            $query.= " and a.KdOut in ('X') " ;
        }else if($tipe_invoice == "Cacah/Bahandle"){
            $query.= " and a.KdOut in ('C') " ;
        }else{
            $query.= " and a.KdOut in ('D','L','X','C') " ;
        }
        $query.= " AND a.Rec_ID = '0' GROUP BY a.Inv_Number ) AS b  " ;
        $query.= " WHERE date_format(a.Tgl_Inv,'%Y-%m-%d') >= '".$startdate."' and date_format(a.Tgl_Inv,'%Y-%m-%d') <= '".$enddate."'  " ;
        if($consignee != ""){$query.= " and a.consignee = '".$consignee."' " ;}
        if($tipe_invoice == "Ditebus"){
            $query.= " and a.KdOut in ('D') " ;
        }else if($tipe_invoice == "Lelang"){
            $query.= " and a.KdOut in ('L') " ;
        }else if($tipe_invoice == "Hibah"){
            $query.= " and a.KdOut in ('X') " ;
        }else if($tipe_invoice == "Cacah/Bahandle"){
            $query.= " and a.KdOut in ('C') " ;
        }else{
            $query.= " and a.KdOut in ('D','L','X','C') " ;
        }
        $query.= " AND a.Rec_ID = '0' AND a.Inv_Number = b.Inv_Number " ;
        $query.= " ORDER BY a.Inv_Number asc " ;
        $excute = $this->ptmsadbo->query($query);
        $queryku[$a++] = $this->ptmsadbo->last_query();
        $this->m_model->goto_temporary($nama_table_1);


        $pesan_data = array(
            'msg'   => 'Ya',
            'pesan' => 'Proses data berhasil...',
            'queryku' => $queryku
        );

        echo json_encode($pesan_data);

    }

    

    function c_export(){
        $username = $this->session->userdata('autogate_username') ;
        $nama_table_1 = "" ;
        $nama_table_2 = "" ;
        $path = "" ;
        $path_subreport = "" ;
        
        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);

        $startdate = $data[0] ;
        $enddate = $data[1] ;
        $tipe_invoice = $data[2] ;
        $consignee = $data[3] ;

        $nama_table_1 = "test.inv_tpp_out_".$username ;

        $data = $this->ptmsadbo->query("SELECT 'nomor' as 'No', inv_number 'Nomor Invoice',date_format(tgl_inv,'%d-%m-%Y') 'Tgl Invoice',consignee 'Consignee',(Biaya_TPS+Biaya_TPP) 'Subtotal',
            ppn 'PPN',biaya_admin 'Administrasi',biaya_lain 'Lain-lain',jumlah 'Total' FROM ".$nama_table_1." ")->result_array();


        if(count($data) == 0){
            echo 'Data Tidak Ditemukan' ;die;
        }
        
        //Setting Sheet Excel
        $nama_excel = "Report_InvOut_Tpp_".tanggal_sekarang() ;

        $nama_sheet = array(
            '0' => 'List Invoice Out (Bahandle) TPP',
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