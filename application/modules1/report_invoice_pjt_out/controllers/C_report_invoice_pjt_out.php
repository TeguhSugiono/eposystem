<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class C_report_invoice_pjt_out extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        //$this->ptmsagate = $this->load->database('ptmsagate', TRUE);        
        $this->mbatps = $this->load->database('mbatps', TRUE);     
    }

    function index(){
        $this->m_model->drop_temporary();

        $menu_active = $this->m_model->menu_active();

        $arraydata = $this->mbatps->query("SELECT DISTINCT Consignee,Consignee 'Consignee2' from pjt_t_inv_header where rec_id=0 order by Consignee")->result_array();
        array_push($arraydata, array('Consignee' => '' , 'Consignee2' => 'All'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'consignee', 'class' => 'selectpicker'),
        );
        $arraydata = array('' => 'All','Ditebus' => 'Ditebus','Cacah/Bahandle' => 'Cacah/Bahandle');
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

        $nama_table_1 = "inv_pjt_out_".$username ;
        $query = "";
        $query.= "DROP TABLE IF EXISTS test.".$nama_table_1;
        $excute = $this->mbatps->query($query);
        $queryku[$a++] = $this->mbatps->last_query();

        $query = "" ;
        $query.= " CREATE TABLE test.".$nama_table_1." AS " ;
        $query.= " SELECT a.Inv_Number,a.Tgl_Inv,a.Consignee,a.Address,a.DO,Voyage,a.Party,a.Tiba,a.Masuk,a.Stripping,a.Keluar,  a.JnsCargo,a.T_In_ID, " ;
        $query.= " IFNULL(a.BiayaTerminal,0) AS Biaya_TPS,(BiayaLainTPP*-1) as 'Discount',  (SELECT SUM(Jumlah)  " ;
        $query.= " from pjt_t_inv_biaya b  where b.Inv_Number=a.Inv_Number and Rec_ID=0) AS Biaya_TPP, " ;
        $query.= " IFNULL(a.PPN,0) AS PPN, IFNULL(a.BiayaAdm,0) AS Biaya_Admin, IFNULL(a.BiayaLainTerminal,0) AS Biaya_Lain,  " ;
        $query.= " (IFNULL(a.BiayaTerminal,0) + IFNULL(a.Surcharge,0) +  (SELECT SUM(Jumlah)  " ;
        $query.= " from pjt_t_inv_biaya b  where b.Inv_Number=a.Inv_Number and Rec_ID=0) + IFNULL(a.PPN,0)  " ;
        $query.= " + IFNULL(a.BiayaAdm,0) +  IFNULL(a.BiayaLainTerminal,0)+IFNULL(a.BiayaLainMBA,0)) + BiayaLainTPP AS Jumlah, a.KdOut,a.biayalainmba " ;
        $query.= " FROM pjt_t_inv_header AS a    " ;
        $query.= " WHERE date_format(a.Tgl_Inv,'%Y-%m-%d') >= '".$startdate."' and date_format(a.Tgl_Inv,'%Y-%m-%d') <= '".$enddate."'  AND a.Rec_ID = '0' " ;
        if($consignee != ""){$query.= " and a.consignee = '".$consignee."' " ;}
        if($tipe_invoice == "Ditebus"){
            $query.= " and a.KdOut in ('D') " ;
        }else if($tipe_invoice == "Cacah/Bahandle"){
            $query.= " and a.KdOut in ('C') " ;
        }else{
            $query.= " and a.KdOut in ('D','C') " ;
        }
        $query.= " ORDER BY a.Inv_Number asc " ;



        $excute = $this->mbatps->query($query);
        $queryku[$a++] = $this->mbatps->last_query();
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

        $nama_table_1 = "test.inv_pjt_out_".$username ;

        $data = $this->mbatps->query("SELECT 'nomor' as 'No', inv_number 'Nomor Invoice',date_format(tgl_inv,'%d-%m-%Y') 'Tgl Invoice',consignee 'Consignee',(Biaya_TPS+Biaya_TPP) 'Subtotal',Discount,
            ppn 'PPN',biaya_admin 'Administrasi',biaya_lain 'Lain-lain',biayalainmba 'Lain-lain2',jumlah 'Total' FROM ".$nama_table_1." ")->result_array();

        if(count($data) == 0){
            echo 'Data Tidak Ditemukan' ;die;
        }

        //Setting Sheet Excel
        $nama_excel = "Report_InvOut_Pjt_".tanggal_sekarang() ;

        $nama_sheet = array(
            '0' => 'List Invoice Out (Bahandle) PJT',
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
        $this->m_model->generator_xls_invtpp($setting_xls);

    }
}