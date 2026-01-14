<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {            
            redirect(site_url('login'));
        }
        $this->jobpjt = $this->load->database('jobpjt', TRUE);    
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);
    }
    
    function index(){

        /************************************************/
        /************************************************/
        /************************************************/
        /************************************************/
        /*********Untuk Benerin Tanggal            ******/
        /************************************************/
        /************************************************/
        /************************************************/
        /************************************************/
        /************************************************/


        //$this->ptmsagate->query(" ALTER TABLE t_t_entry_cont_in ADD tgl_eir2 date DEFAULT NULL ");    
        //$this->ptmsagate->query(" ALTER TABLE t_eir ADD tgl_eir2 date DEFAULT NULL ");
        // $data_in = $this->ptmsagate->query(" select id_cont_in,tgl_eir from  t_t_entry_cont_in  where tgl_eir<>'' ")->result_array();
        // foreach($data_in as $row){
        //     $tgl_eir = date_db($row['tgl_eir']) ;
        //     $id_cont_in = $row['id_cont_in'] ;
        //     $this->ptmsagate->query(" update t_t_entry_cont_in set tgl_eir2='".$tgl_eir."'  where  id_cont_in=".$id_cont_in." ");
        //     $this->ptmsagate->query(" update t_t_stock set tgl_eir2='".$tgl_eir."'  where  id_cont_in=".$id_cont_in." ");
        // }

        // echo 'finish...' ;
        // die;


        // $this->ptmsagate->query(" ALTER TABLE t_t_stock ADD tgl_eir2 date DEFAULT NULL ");
        // $data_stock = $this->ptmsagate->query(" select * from  t_t_stock  where tgl_eir<>'' ");
        // foreach($data_stock as $row){
        //     $tgl_eir = date_db($row['tgl_eir']) ;
        //     $id_cont_in = $row['id_cont_in'] ;
        //     $this->ptmsagate->query(" update t_t_stock set tgl_eir2='".$tgl_eir."'  where  id_cont_in=".$id_cont_in." ");
        // }
        // echo 'finish...' ;
        // die;




        
        // $data = $this->ptmsagate->query(" select * from  t_eir  where tgl_eir<>'' ");


        







        $folder_content = $this->get_folder();
        redirect($folder_content);
    }
    
    function get_folder(){
        $id_home = $this->session->userdata('autogate_home') ;        
        $arraydata = $this->jobpjt->query("SELECT link_route FROM tbl_menu_app where id_menu=".$id_home)->row();   
        $folder_content = getvalueb($arraydata);
        return $folder_content;
    }


    function c_settingtemplate(){
        $id_user = $this->session->userdata('autogate_userid') ; 
        $thema_name =  $this->jobpjt->query(" SELECT a.thema_name FROM tbl_menu_template a 
            INNER JOIN tbl_user b on a.thema_name = b.thema_name 
            where id_user='".$id_user."' ")->row()->thema_name ;


        $arraydata = $this->jobpjt->query("SELECT thema_name,thema_name as 'thema_name1' FROM tbl_menu_template order by id asc ")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => $thema_name),
            'attribute' => array('idname' => 'thema_name', 'class' => ''),
        );
        $data['thema_name'] = ComboDbx($createcombo);

        $this->load->view('v_template', $data);
    }

    function c_update(){
        $thema_name = $this->input->post('thema_name');

        $where = array('id_user' => $this->session->userdata('autogate_userid'));
        $data = array('thema_name' => $thema_name);

        $hasil = $this->jobpjt->update('tbl_user', $data, $where);
        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Save Data Sukses..',
                'query' => $this->jobpjt->last_query(),
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update Data ke Tabel tbl_user Error....!!!!',
                'query' => $this->jobpjt->last_query(),
            );
            echo json_encode($pesan_data);
            die;
        }

        $this->m_model->StringToSession('autogate_thema', $thema_name);

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => 'Ganti Thema Sukses..',
            'query' => $this->jobpjt->last_query(),
        );

        echo json_encode($pesan_data);

    }


    function GoToAr_tpp_t_inv_header(){

        $uniq_form = 111;

        $paramtahun = "2025-01-01" ;

        $nm_table = "test.tbl_ar_automatic_".$this->session->userdata('t_username')."_".$uniq_form ;
        $this->db->query('drop table if exists '.$nm_table) ;

        $nm_table_compare = "test.tbl_ar_automatic_".$this->session->userdata('t_username')."_".$uniq_form."_compare" ;
        $this->db->query('drop table if exists '.$nm_table_compare) ;

        $query = " SELECT
        substr(ptmsa_dbo.tpp_t_inv_header.Inv_Number, 5) AS invoice_no ,
        'tpp_t_inv_header' as 'param'
        FROM
        ptmsa_dbo.tpp_t_inv_header 
        WHERE
        date_format(ptmsa_dbo.tpp_t_inv_header.Tgl_Inv, '%Y-%m-%d') >= '$paramtahun' 
        AND date_format(ptmsa_dbo.tpp_t_inv_header.Tgl_Inv, '%Y-%m-%d') <= date_format(CURRENT_TIMESTAMP(), '%Y-%m-%d') 
        and ptmsa_dbo.tpp_t_inv_header.Rec_ID = 0  " ;


        $this->db->query('create table '.$nm_table.' as '.$query) ;

        $query = " SELECT * from ".$nm_table." where invoice_no not in
        (SELECT ptmsa_acct.fin_ar_t_invoice_head.invoice_no 
            FROM ptmsa_acct.fin_ar_t_invoice_head 
            WHERE date_format(ptmsa_acct.fin_ar_t_invoice_head.invoice_date, '%Y-%m-%d') >= '$paramtahun' 
            AND date_format(ptmsa_acct.fin_ar_t_invoice_head.invoice_date, '%Y-%m-%d') <= date_format(CURRENT_TIMESTAMP(), '%Y-%m-%d') ) " ;

        $this->db->query('create table '.$nm_table_compare.' as '.$query) ;


        $query = " SELECT * from  ".$nm_table_compare." as a 
        inner join ptmsa_dbo.tpp_t_inv_header as b on a.invoice_no = substr(b.Inv_Number, 5) 
        where b.Rec_ID = 0 " ;

        if($this->db->query($query)->num_rows() > 0){

            //$openData = $this->db->get($nm_table_compare)->result_array() ;

            $query = " SELECT * from  ".$nm_table_compare." as a 
            inner join ptmsa_dbo.tpp_t_inv_header as b on a.invoice_no = substr(b.Inv_Number, 5) 
            where b.Rec_ID = 0 " ;

            $openData = $this->db->query($query)->result_array() ;

            foreach($openData as $OpnData){

                $invoice_number = $OpnData['invoice_no'] ;
                $param =  $OpnData['param'] ;
                $Consignee =  $OpnData['Consignee'] ;
                $Tgl_Inv =  $OpnData['Tgl_Inv'] ;
                $Inv_Number =  $OpnData['Inv_Number'] ;

                $this->Integrate2AR($invoice_number,$Tgl_Inv,$Consignee,$Inv_Number,$uniq_form);
            }


        }
        

        
    }
    

    function Integrate2AR($invNo = "",$tgl_inv = "",$Consignee = "",$StrInvNumber = "",$uniq = ""){
        $tgl_inv_save   = $tgl_inv ;
        $tgl_inv        = date('Y',strtotime($tgl_inv)); 
        $Month          = date('m',strtotime($tgl_inv)); 
        
        $sCode          = $this->GetAR_APNumber("AR", $tgl_inv, $Month);

        $uniq_form = $uniq;
        $table = "testmsa.fin_vw_tpp_invoice_" . $this->session->userdata('t_username') . "_" . $uniq_form;
        
        $this->view_fin_vw_tpp_invoice($invNo,$uniq_form);

        //cari subTotal
        $cari       = "IFNULL(SUM(jumlah),0) as 'data' " ;
        $subTotal   = $this->GetFieldValue($cari,$table);
        //End cari subTotal
        
        
        //cari biayaAdm
        //biayaAdm = GetFieldValue("SELECT DISTINCT biaya_adm FROM ptmsa_acct.fin_vw_tpp_invoice WHERE inv_no = " & QuoteStr(NoInvoice))
        $cari       = "DISTINCT biaya_adm as 'data' " ;
        $biayaAdm   = $this->GetFieldValue($cari,$table);
        //end cari biayaAdm

        //cari biayaSegel
        //biayaAdm = GetFieldValue("SELECT DISTINCT biaya_segel FROM ptmsa_acct.fin_vw_tpp_invoice WHERE inv_no = " & QuoteStr(NoInvoice))
        $cari       = "DISTINCT biaya_segel as 'data' " ;
        $biayaSegel   = $this->GetFieldValue($cari,$table);
        //$biayaSegel = 0 ;
        //end cari biayaAdm
        
        //cari biayaLain
        //biayaLain = GetFieldValue("SELECT DISTINCT biaya_lain FROM ptmsa_acct.fin_vw_tpp_invoice WHERE inv_no = " & QuoteStr(NoInvoice)) ;
        $cari       = "DISTINCT biaya_lain as 'data' " ;
        $biayaLain  = $this->GetFieldValue($cari,$table);
        //end cari biayaLain
        
        //cari ppnAmount
        //ppnAmount = Format(GetFieldValue("SELECT DISTINCT ppn FROM ptmsa_acct.fin_vw_tpp_invoice WHERE inv_no = " & QuoteStr(NoInvoice)), "##,###")
        $cari       = "DISTINCT ppn as 'data' " ;
        $ppnAmount  = $this->GetFieldValue($cari,$table);
        //end cari ppnAmount  

        
        $TPPCust  = $this->GetCustomerName($Consignee);
        
        $grandTotal = $subTotal + $ppnAmount + $biayaAdm + $biayaSegel + $biayaLain ;
        
        $ppnFlag = "N" ;
        if($ppnAmount > 0){
            $ppnFlag = "Y" ;
        }
        
        $iPeriode    = date('m',strtotime($tgl_inv)); 
        $sTahun      = date('Y',strtotime($tgl_inv)); 


        $id_category = NULL ;
        $nilai_lain = NULL ;

        $Exe_12 = $this->db->get_where('tpp_t_inv_header',array('Inv_Number' => 'INV-'.$invNo))->result_array();

        foreach($Exe_12 as $getNilaiLain){
            $id_category = $getNilaiLain['id_category'] ;
            $nilai_lain = $getNilaiLain['nilai_lain'] ;
        }


        // return $id_category." --- ".$nilai_lain." --- ".$this->db->last_query() ;
        // die;

        $fin_ar_t_invoice_head = array(
            'ar_invoice_code'       => $sCode,
            'ar_type_code'          => '01',
            'cust_code'             => 'C0001',
            'invoice_no'            => $invNo,
            'invoice_date'          => $tgl_inv_save,
            'due_date'              => $tgl_inv_save,
            'kirim_date'            => $tgl_inv_save,
            'tpp_cust_name'         => $TPPCust,
            'ket'                   => '',
            'grand_total'           => $grandTotal,
            'sub_total'             => $subTotal,
            'discount_2'            => 0,
            'ppn_amount'            => $ppnAmount,
            'adm_fee'               => $biayaAdm,
            'etc_fee'               => ($biayaLain + $biayaSegel),
            'total'                 => $grandTotal,
            'ppn_flag'              => $ppnFlag,
            'disc_flag'             => 'N',
            'discount'              => 0,
            'received'              => 0,
            'not_received'          => $grandTotal,
            'actual_not_rec'        => $grandTotal,
            'retur'                 => 0,
            'periode'               => $iPeriode,
            'fiscal_year'           => $sTahun,
            'status'                => 'O',
            'status_date'           => tanggal_sekarang(),
            'posted'                => 'N',
            'posted_by'             => NULL,
            'posted_on'             => NULL,
            'created_by'            => 'GetAR_automated',
            'created_on'            => tanggal_sekarang(),
            'edited_by'             => NULL,
            'edited_on'             => NULL,
            'tuker_faktur'          => NULL,
            'id_category'           => $id_category,
            'nilai_lain'            => $nilai_lain
        );

        $this->db_acct_msa->insert('fin_ar_t_invoice_head',$fin_ar_t_invoice_head);
        
        $dataku = $this->db->query("select * from ".$table) ;
        $ii = 0 ;
        
        $ardetail = array();

        foreach ($dataku->result() as $row) {
            if($row->jumlah > 0){
                $ii++ ;
                $fin_ar_t_invoice_det = array(
                    'ar_invoice_code'   => $sCode,
                    'seq_no'            => $ii,
                    'item_desc'         => $row->ket,
                    'item_amount'       => $row->jumlah,
                    'created_by'        => 'GetAR_automated',
                    'created_on'        => tanggal_sekarang(),
                    'edited_by'         => NULL,
                    'edited_on'         => NULL,
                );


                $ardetail[$ii] = $fin_ar_t_invoice_det ;

                $this->db_acct_msa->insert('fin_ar_t_invoice_det',$fin_ar_t_invoice_det);
            }
            
        }
        
        $this->SetNumber("AR",$sTahun);        
        

        // $returndata = array(
        //     'subTotal' => $subTotal,
        //     'biayaAdm' => $biayaAdm,
        //     'biayaLain' => $biayaLain,
        //     'ppnAmount' => $ppnAmount,
        //     'TPPCust'   => $TPPCust,
        //     'grandTotal' => $grandTotal,
        //     'ppnFlag' => $ppnFlag,
        //     'iPeriode'  => $iPeriode,
        //     'sTahun' => $sTahun,
        //     'fin_ar_t_invoice_head' => $fin_ar_t_invoice_head,
        //     'ardetail' => $ardetail,
        //     'query' => $this->db->last_query(),
        // );
        
        // return $returndata ;
    }

    function GetCustomerName($Consignee = ""){
        $pCustName  = $Consignee ;
        $nCN        = str_replace(' ','', $pCustName) ;
        $LongCN     = strlen($nCN) ;
        
        $nNewCustName   = "" ;
        $mCustName      = "" ;
        $mComp          = "" ;
        
        for($i=0;$i<=$LongCN-1;$i++){
            $detect = substr($Consignee,$i,1) ;
            
            if($detect == "."){
                $nPos   = $i ;
                $mCustName = substr($pCustName, $nPos + 1, $LongCN + 2) ;
                $mCustName = trim($mCustName) ;
                
                $mComp          = substr($nCN, 0, $nPos) ;
                $nNewCustName   = $mCustName.", ".$mComp ;
                break;
            }
            
        }
        
        return $nNewCustName ;
    }

    function GetFieldValue($cari = "", $table = "" ){
        $query  = $this->db_acct_msa->query(" select ".$cari." from ".$table);
        $data   = "" ;
        foreach ($query->result() as $row) {
            $data = $row->data ;
        }
        return $data;
    }

    function SetNumber($TXNcode = "" ,$Tahun = ""){

        $sSQL = "" ;
        $sSQL = " UPDATE fin_r_number SET " ;
        $sSQL.= " seq_no = seq_no + 1, " ;
        $sSQL.= " edited_by ='".$this->session->userdata('t_username')."', " ;
        $sSQL.= " edited_on ='".tanggal_sekarang()."'  " ;
        $sSQL.= " WHERE txn_code ='".$TXNcode."'  and " ;
        $sSQL.= " fiscal_year ='".$Tahun."'  " ;
        $this->db_acct_msa->query($sSQL);
    } 
    function GetAR_APNumber($TXNcode = "",$Tahun = "",$Periode = ""){

        $sql = " SELECT * FROM fin_r_number " ;
        $sql.= " WHERE txn_code ='".$TXNcode."' " ;
        $sql.= " AND fiscal_year ='".$Tahun."' " ;
        
        $query      = $this->db_acct_msa->query($sql) ; 
        $dapat      = $query->num_rows() ;
        
        if($dapat == 0){
            $sql = "" ;
            $sql = " INSERT INTO fin_r_number VALUES "  ;
            $sql.= " ('".$Tahun."','".$TXNcode."',1,'".$this->session->userdata('t_username')."', " ;
            $sql.= " '".tanggal_sekarang()."',NULL,NULL) " ;
            $this->db_acct_msa->query($sql);
        }
        
        
        $sql = "" ;
        $sql = " SELECT MAX(seq_no) 'number' FROM fin_r_number " ;
        $sql.= " WHERE txn_code ='".$TXNcode."' "  ;
        $sql.= " AND fiscal_year ='".$Tahun."' " ;
        
        $no = 0 ;
        $query = $this->db_acct_msa->query($sql) ; 
        foreach ($query->result() as $row) {
            $no = $row->number ;
        }
        
        return $TXNcode."".str_pad($no, 5, "0", STR_PAD_LEFT)."-".$Periode.substr($Tahun, 2, 2) ;

    }

    function view_fin_vw_tpp_invoice($invNo,$uniq){

        $uniq_form = $uniq ;
        $table = "testmsa.fin_vw_tpp_invoice_" . $this->session->userdata('t_username') . "_" . $uniq_form;

        $this->m_function->goto_temporary_out("fin_vw_tpp_invoice_" . $this->session->userdata('t_username') . "_" . $uniq_form);

        $this->db->query('drop table if exists ' . $table);

        $sql = " create table " . $table . " as ";
        $sql.= " SELECT RIGHT(tpp_t_inv_header.Inv_Number,(length( tpp_t_inv_header.Inv_Number ) - 4 )) AS inv_no,
        tpp_t_inv_header.Tgl_Inv AS tgl_inv,
        _latin1 'Biaya TPS' AS ket,
        tpp_t_inv_header.BiayaTPS AS jumlah,
        tpp_t_inv_header.BiayaAdm AS biaya_adm,
        tpp_t_inv_header.BiayaSegel AS biaya_segel,
        tpp_t_inv_header.BiayaLainTPS AS biaya_lain,
        tpp_t_inv_header.PPN AS ppn 
        FROM
        tpp_t_inv_header 
        WHERE
        ((
            tpp_t_inv_header.Rec_ID <> _latin1 '9' 
            ) 
        AND ( tpp_t_inv_header.BiayaTPS <> 0 )
        AND ((RIGHT(tpp_t_inv_header.Inv_Number,(length( tpp_t_inv_header.Inv_Number ) - 4 )) ) = '$invNo') ) 
        UNION ALL 
        SELECT RIGHT(a.Inv_Number,(length( a.Inv_Number ) - 4 )) AS inv_no,
        a.Tgl_Inv AS tgl_inv,
        b.Keterangan AS ket,
        b.Jumlah AS jumlah,
        a.BiayaAdm AS biaya_adm,
        a.BiayaSegel AS biaya_segel,
        a.BiayaLainTPS AS biaya_lain,
        a.PPN AS ppn 
        FROM
        (
            tpp_t_inv_header a
            JOIN tpp_t_inv_biaya b ON ((
                a.Inv_Number = b.Inv_Number 
                ))) 
        WHERE
        ((
            a.Rec_ID <> _latin1 '9' 
            ) 
        AND ( b.Rec_Id <> _latin1 '9' )
        AND ((RIGHT(a.Inv_Number,(length( a.Inv_Number ) - 4 )) ) = '$invNo' ) ) 
        UNION ALL 
        SELECT RIGHT(a.Inv_Number,(length( a.Inv_Number ) - 4 )) AS inv_no,
        a.Tgl_Inv AS tgl_inv,
        b.Keterangan AS ket,
        b.Jumlah AS jumlah,
        a.BiayaAdm AS biaya_adm,
        a.BiayaSegel AS biaya_segel,
        a.BiayaLainTPS AS biaya_lain,
        a.PPN AS ppn 
        FROM
        (
            tpp_t_inv_header a
            JOIN tpp_t_inv_biaya_cargo b ON ((
                a.Inv_Number = b.Inv_Number 
                ))) 
        WHERE
        ((
            a.Rec_ID <> _latin1 '9' 
            ) 
        AND ( b.Rec_ID <> _latin1 '9' )
        AND ((RIGHT(a.Inv_Number,(length( a.Inv_Number ) - 4 )) ) = '$invNo' ) ) 
        UNION ALL 
        SELECT RIGHT(tpp_t_inv_header.Inv_Number,(length( tpp_t_inv_header.Inv_Number ) - 4 )) AS inv_no,
        tpp_t_inv_header.Tgl_Inv AS tgl_inv,
        _latin1 'Discount' AS ket,
        tpp_t_inv_header.BiayaLainTPP AS jumlah,
        tpp_t_inv_header.BiayaAdm AS biaya_adm,
        tpp_t_inv_header.BiayaSegel AS biaya_segel,
        tpp_t_inv_header.BiayaLainTPS AS biaya_lain,
        tpp_t_inv_header.PPN AS ppn 
        FROM
        tpp_t_inv_header 
        WHERE
        ((
            tpp_t_inv_header.Rec_ID <> _latin1 '9' 
            ) 
        AND ( tpp_t_inv_header.BiayaLainTPP < 0 )
        AND ((RIGHT(tpp_t_inv_header.Inv_Number,(length( tpp_t_inv_header.Inv_Number ) - 4 )) ) = '$invNo' ) )
        UNION ALL 
        SELECT RIGHT(tpp_t_inv_header.Inv_Number,(length( tpp_t_inv_header.Inv_Number ) - 4 )) AS inv_no,
        tpp_t_inv_header.Tgl_Inv AS tgl_inv,
        tpp_t_inv_header.KetBiayaLainTPP AS ket,
        tpp_t_inv_header.BiayaLainTPP AS jumlah,
        tpp_t_inv_header.BiayaAdm AS biaya_adm,
        tpp_t_inv_header.BiayaSegel AS biaya_segel,
        tpp_t_inv_header.BiayaLainTPS AS biaya_lain,
        tpp_t_inv_header.PPN AS ppn 
        FROM
        tpp_t_inv_header 
        WHERE
        ((
            tpp_t_inv_header.Rec_ID <> _latin1 '9' 
            ) 
        AND ( tpp_t_inv_header.BiayaLainTPP > 0 )
        AND ((RIGHT(tpp_t_inv_header.Inv_Number,(length( tpp_t_inv_header.Inv_Number ) - 4 )) ) = '$invNo' ) ) 
        UNION ALL 
        SELECT RIGHT(tpp_t_inv_header.Inv_Number,(length( tpp_t_inv_header.Inv_Number ) - 4 )) AS inv_no,
        tpp_t_inv_header.Tgl_Inv AS tgl_inv,
        _latin1 'Surcharge' AS ket,
        tpp_t_inv_header.Surcharge AS jumlah,
        tpp_t_inv_header.BiayaAdm AS biaya_adm,
        tpp_t_inv_header.BiayaSegel AS biaya_segel,
        tpp_t_inv_header.BiayaLainTPS AS biaya_lain,
        tpp_t_inv_header.PPN AS ppn 
        FROM
        tpp_t_inv_header 
        WHERE
        ((
            tpp_t_inv_header.Rec_ID <> _latin1 '9' 
            ) 
        AND ( tpp_t_inv_header.Surcharge <> 0 )
        AND ((RIGHT(tpp_t_inv_header.Inv_Number,(length( tpp_t_inv_header.Inv_Number ) - 4 )) ) = '$invNo' ) ) 
        UNION ALL 
        SELECT RIGHT(a.Inv_Number,(length( a.Inv_Number ) - 4 )) AS inv_no,
        a.Tgl_Inv AS tgl_inv,
        b.NamaBrg AS ket,
        b.Total AS jumlah,
        a.BiayaAdm AS biaya_adm,
        a.BiayaSegel AS biaya_segel,
        a.BiayaLainTPS AS biaya_lain,
        a.PPN AS ppn 
        FROM
        (
            tpp_t_inv_header a
            JOIN tpp_t_inv_biaya_lelang b ON ((
                a.Inv_Number = b.Inv_Number 
                ))) 
        WHERE
        ((
            a.Rec_ID <> _latin1 '9') AND ((RIGHT(a.Inv_Number,(length( a.Inv_Number ) - 4 )) ) = '$invNo' ) ) " ;

        $this->db->query($sql);

    }
    
}