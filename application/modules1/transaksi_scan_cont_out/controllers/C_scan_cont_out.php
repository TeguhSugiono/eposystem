<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");

class C_scan_cont_out extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);        
        $this->mbatps = $this->load->database('mbatps', TRUE);     
        $this->db_tpsonline = $this->load->database('db_tpsonline', TRUE); 
    }

    function index() {


        // print("<pre>".print_r($this->ptmsagate->query("select r_party from t_t_entry_cont_out where rec_id=0 and 
        //                         do_number='COAU7252078010' and reff_code='4DS' order by r_party asc ")->result_array(),true)."</pre>"); die;

        // $ar = $this->ptmsagate->query("select r_party from t_t_entry_cont_out where rec_id=0 and 
        //                         do_number='COAU7252078010' and reff_code='4DS' order by r_party asc ")->result_array() ;
        // $array_one = $this->m_model->array_one_rows($ar,'r_party');

        // //print("<pre>".print_r($array_one,true)."</pre>"); 

        // $array = array(1,2,3);
        // print("<pre>".print_r($array,true)."</pre>"); 

        // die;

   

        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
        );
        $this->load->view('dashboard/index', $data);

    }

    function c_fetch_table(){

        $donumber = $this->input->post('donumber') ;        
        $numbercontainer = $this->input->post('numbercontainer') ;        

        $strSQL = " SELECT No_Transaksi,Inv_Number,Do_Number,Cont_Number,date_format(TglMasuk,'%d-%m-%Y') 'TglMasuk' " ;
        $strSQL.= " FROM tps_t_plp_do  " ;
        $strSQL.= " where FLAG_SINKRON = 1 " ;
        $strSQL.= " and Date_DO_Print BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() " ;

        if($donumber != ""){
            $strSQL.= " and Do_Number='".$donumber."' " ;
        }

        if($numbercontainer != ""){
            $strSQL.= " and Cont_Number='".$numbercontainer."' " ;
        }

        echo json_encode($this->mbatps->query($strSQL)->result_array());
    }

    function c_fetch_table_do(){

        $donumber = $this->input->post('donumber');

        $strSQL = " SELECT a.id_entry_do, date_format(a.do_date,'%d-%m-%Y') 'do_date', a.do_number, a.reff_code, " ;
        $strSQL.= " a.code_principal, a.vessel, a.shipper, a.seal_number, " ;
        $strSQL.= " a.destination, a.notes, a.party, a.cont_out " ;
        $strSQL.= " FROM t_t_entry_do_cont_out as a " ;
        $strSQL.= " WHERE a.rec_id = 0 " ;
        $strSQL.= " AND a.do_date BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() " ;

        if($donumber != ""){
            $strSQL.= " and a.do_number ='".$donumber."' " ;
        }

        $strSQL.= " ORDER BY a.do_date ASC " ;


        echo json_encode($this->ptmsagate->query($strSQL)->result_array());
    }
    
    function c_getnotrans(){

        $notrans = $this->input->post('notrans');

        $this->mbatps->select('Cont_Number,Do_Number') ;
        $this->mbatps->where('Date_DO_Print BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()', null, false);
        $Cont_Number_Data = $this->mbatps->get_where('tps_t_plp_do', array('No_Transaksi' => $notrans));

        if($Cont_Number_Data->num_rows() == 0){
            $dataArray[0] = array(
                'Cont_Number' => 'Not Found',
                'Do_Number' => 'Not Found'
            );
        }else{
            $dataArray = $Cont_Number_Data->result_array();
        }

        $comp = array(
            'dataArray' => $dataArray
        ); 

        echo json_encode($comp);


    }

    function c_savedata(){
        $No_Transaksi = $this->input->post('No_Transaksi');
        $Cont_Number = $this->input->post('Cont_Number');
        $truck_number = $this->input->post('truck_number');
        $driver_name = $this->input->post('driver_name');
        $destination = $this->input->post('destination');
        $do_number = trim($this->input->post('do_number'));
        $code_principal = trim($this->input->post('code_principal'));
        $reff_code = trim($this->input->post('reff_code'));
        $cont_date_in = $this->input->post('cont_date_in');
        $vessel = $this->input->post('vessel');
        $seal_number = trim($this->input->post('seal_number'));
        $do_date = trim($this->input->post('do_date'));

        if($this->ptmsagate->get_where("t_t_entry_cont_out",array('rec_id' => 0,'cont_number' => $Cont_Number,'cont_date_in' => date_db($cont_date_in)))->num_rows()){
            $pesan_data = array(
                'msg' => 'Tidak', 
                'pesan' => 'Data Container Ini '.$Cont_Number.' Sudah Pernah Di Scan/Input....!!!!',
                'sql' => 'Data Sudah Ada..!!'
            );
            echo json_encode($pesan_data);
            die;
        }


        //dapetin bon_muat_number
        $bon_muat_number = $this->m_model->bon_muat_number();


        //dapetin name_principal
        $name_principal = getvalueb($this->ptmsagate->query("select name_principal from t_m_principal 
            where rec_id=0 and  code_principal='" . $code_principal . "'")->result_array()[0]);

        //dapetin reff_description
        $reff_description = getvalueb($this->ptmsagate->query("select reff_description from t_m_refference 
            where rec_id=0 and  reff_code='" . $reff_code . "'")->result_array()[0]);


        //dapetin jumlah party
        $party = getvalueb($this->ptmsagate->query("SELECT party FROM t_t_entry_do_cont_out 
            where rec_id=0 and do_number='".$do_number."' order by id_entry_do desc ")->result_array()[0]) ;


        //dapetin r_party ini adalah urutan container keluar jika per do lebih dari 1 container
        $r_party = getvalueb($this->ptmsagate->query("select COUNT(*) 'r_party' from t_t_entry_cont_out 
                                            where do_number='".$do_number."' and reff_code='".$reff_code."' and  rec_id=0 ")->result_array()[0]);

        if(($r_party+1) > $party){
            $pesan_data = array(
                'msg' => 'Tidak', 'pesan' => 'Jumlah Container Out Sudah Melebihi Jumlah Kontainer Party, Yang DiInput Di DO..!!',
                'sql' => 'Jumlah Party = '.$party.' Jumlah Container dengan Yang Akan Diinput = '.($r_party+1) ,
            );
            echo json_encode($pesan_data);
            die;
        }

        $r_party = $this->ptmsagate->query("select r_party from t_t_entry_cont_out where rec_id=0 and 
                                do_number='".$do_number."' and reff_code='".$reff_code."' order by r_party asc ")->result_array();

        $data_r_party = $this->m_model->array_one_rows($r_party,'r_party');

        $r_party = $this->findMissingNumber($data_r_party);

        $datain = $this->m_model->table_tostring('ptmsagate',"shipper,cont_condition,cont_status,block_loc,location,ship_line_code,ship_line_name,
            bon_bongkar_number,dangers_goods,invoice_in,bc_code,id_cont_in","t_t_entry_cont_in","",
            array('cont_number' => $Cont_Number,'cont_date_in' => date_db($cont_date_in)),1) ;

        $eir_r_number = $this->m_model->eir_r_number_out();
        $update_no_eir_in = $this->m_model->update_eir_r_number_out();

        $a = 0 ;

        $data = array(
            'No_Transaksi' => $No_Transaksi,
            'cont_number' => $Cont_Number,
            'truck_number' => $truck_number,
            'driver_name' => $driver_name,
            'destination' => $destination,
            'do_number' => $do_number,
            'bon_muat_number' => $bon_muat_number,
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'cont_date_in' => date_db($cont_date_in),
            'cont_date_out' => tanggal_sekarang(),
            'cont_time_out' => jam_sekarang(),
            'vessel' => $vessel,
            'seal_number' => $seal_number,   
            'r_party' => $r_party,
            'party' => $party,
            'shipper' => $datain['shipper'],
            'cont_condition' =>  $datain['cont_condition'],
            'cont_status' => $datain['cont_status'],
            'block_loc' => $datain['block_loc'],
            'location' => $datain['location'],
            'ship_line_code' => $datain['ship_line_code'],
            'ship_line_name' => $datain['ship_line_name'],
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
            'rec_id' => 0,
            'bon_bongkar_number' => $datain['bon_bongkar_number'],
            'eir_number' => $eir_r_number,            
            'dangers_goods' => $datain['dangers_goods'],
            'invoice_in' => $datain['invoice_in'],
            'bc_code' => $datain['bc_code'],
        );
        
        $hasil = $this->ptmsagate->insert('t_t_entry_cont_out', $data);
        $sql[$a] = $this->ptmsagate->last_query();

        if (!$hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak', 'pesan' => 'Insert Data Ke Table t_t_entry_cont_out Error....!!!!','sql' => $this->ptmsagate->last_query()
            );
            echo json_encode($pesan_data);
            die;
        }

        $data = array(
            'cont_date_out' => tanggal_sekarang(),
            'cont_time_out' => jam_sekarang(),
            'do_number' => $do_number,
            'bon_muat_number' => $bon_muat_number,
            'cont_condition' => $datain['cont_condition'],
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
            'rec_id' => 1,
            'No_Transaksi' => $No_Transaksi,            
        );

        $where = array(
            'cont_number' => $Cont_Number,
            'rec_id' => 0,
        );

        $hasil = $this->ptmsagate->update('t_t_stock', $data, $where);
        $sql[$a++] = $this->ptmsagate->last_query();

        if (!$hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak', 'pesan' => 'Update Data Ke Table t_t_stock Error....!!!!','sql' => $this->ptmsagate->last_query()
            );
            echo json_encode($pesan_data);
            die;
        }


        $data = array(
            'bon_muat_number' => $bon_muat_number,
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'cont_number' => $Cont_Number,
            'do_number' => $do_number,
            'vessel' => $vessel,
            'shipper'=> $datain['shipper'],
            'truck_number' => $truck_number,
            'driver_name'=> $driver_name,
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'cont_condition' => $datain['cont_condition'],
            'cont_status' => $datain['cont_status'],
            'cont_date_in' => date_db($cont_date_in),
            'cont_date_out' => tanggal_sekarang(),
            'cont_time_out' => jam_sekarang(),
            'destination' => $destination,
            'seal_number'=>$seal_number,
            'block_loc' => $datain['block_loc'],
            'location' => $datain['location'],
            'eir_type' => 'O',
            'eir_number' => $eir_r_number,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
            'rec_id' => 0,
            'No_Transaksi' => $No_Transaksi,
        );
        
        $hasil = $this->ptmsagate->insert('t_eir', $data);
        $sql[$a++] = $this->ptmsagate->last_query();

        if (!$hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak', 'pesan' => 'Insert Data Ke Table t_eir Error....!!!!','sql' => $this->ptmsagate->last_query()
            );
            echo json_encode($pesan_data);
            die;
        }

        if(($r_party+1) > $party){
            $where = array(
                'do_number' => $do_number,
                'reff_code' => $reff_code,
                'rec_id' => 0,
            );
            $data = array(
                'cont_out' => ($r_party+1),
                'edited_by' => $this->session->userdata('autogate_username'),
                'edited_on' => tanggal_sekarang(),           
            );
            $hasil = $this->ptmsagate->update('t_t_entry_do_cont_out', $data, $where);
            $sql[$a++] = $this->ptmsagate->last_query();

            if (!$hasil >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak', 'pesan' => 'Update Data Ke Table t_t_entry_do_cont_out Error....!!!!','sql' => $this->ptmsagate->last_query()
                );
                echo json_encode($pesan_data);
                die;
            }
        }

        if($code_principal == "TPS" || $code_principal == "PJT" || $code_principal == "LCL"){

            $cek_kontainer_tps = $this->mbatps->query("select * from tps_t_plp a inner join tps_t_plp_detail b on a.T_In_ID=b.T_In_ID 
                where a.RecID = 0 and b.RecID = 0 and b.NoKontainer='".$Cont_Number."' and date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' ");

            if($cek_kontainer_tps->num_rows() > 0){

                $T_In_Detail_ID = $cek_kontainer_tps->row()->T_In_Detail_ID ;

                $this->mbatps->query(" update  tps_t_plp_detail set TglKeluar='".tanggal_sekarang()."' , JamKeluar ='".jam_sekarang()."',
                Location='".$datain['block_loc'].' '.$datain['location']."' , RecID=1 where T_In_Detail_ID='".$T_In_Detail_ID."' ");

                $this->mbatps->query(" update tps_t_plp_do set Cont_Date_Out='".tanggal_sekarang()."',Cont_time_out='".jam_sekarang()."',
                Truck_Number_Out='".$truck_number."' where T_In_Detail_ID='".$T_In_Detail_ID."' ");
                
                $cek_lock_gate = $this->mbatps->query("select * from tps_t_plp_detail_gate_status where NoKontainer='".$Cont_Number."' and 
                        date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' and FlagStatus<>9 ");    

                if($cek_lock_gate->num_rows() > 0){
                    $this->mbatps->query(" update  tps_t_plp_detail_gate_status set FlagStatus=9 where NoKontainer='".$Cont_Number."' and 
                        date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' and FlagStatus<>9 ");
                }


            }

            //integrate to out tpsonline
            
            //=========================================================================================================================================
        
            $get_reff_number_in = $this->db_tpsonline->get_where('tbl_respon_plp_petikemas_detail',array('ID_CONT_IN' => $datain['id_cont_in']))->result_array();
            $str_reff_number_in = "" ;
            $str_T_IN_ID = "" ;
            
            foreach($get_reff_number_in as $row){
                $str_reff_number_in = $row['REF_NUMBER_FCL_IN'];
                $str_T_IN_ID  = $row['T_IN_ID'];
            }

            //***data ops admin(popi)
            $get_data_ops_admin = $this->mbatps->get_where('tps_t_plp',array('t_in_id' => $str_T_IN_ID))->result_array();
            $str_TglBC1 = "" ;
            $str_Consignee = "" ;
            $str_NoSPPB = "" ;
            $str_TglSPPB = "" ;
            foreach($get_data_ops_admin as $row){
                $str_TglBC1 = $row['TglBC1'];
                $str_Consignee = $row['Consignee'];
                $str_NoSPPB = $row['NoSPPB'];
                $str_TglSPPB = $row['TglSPPB'];
            }
            //***end data ops admin(popi) 


            //***data invoice endah
            $this->mbatps->select("REPLACE(REPLACE(NPWP,'.',''),'-','') 'NPWP' ");
            $get_data_invoice = $this->mbatps->get_where('tps_t_inv_header',array('t_in_id' => $str_T_IN_ID))->result_array();
            $str_NPWP = "" ;
            foreach($get_data_invoice as $row){
                $str_NPWP = $row['NPWP'];
            }

            //***end data invoice endah

            $get_data_fcl_in = $this->db_tpsonline->get_where('tbl_request_plp_in_container',array('REF_NUMBER' => $str_reff_number_in))->result_array();

            foreach($get_data_fcl_in as $detail){

                $GetKD_TPS = $detail['KD_TPS'] ;
                $this->m_model->set_run_number_tpsonline($GetKD_TPS,'FCL','tbl_run_number_tpsonline');
                $where = array('NAME' => 'FCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $detail['KD_TPS']);
                $get_ref_number = $this->db_tpsonline->get_where('tbl_run_number_tpsonline',
                    array('NAME' => 'FCL','YEAR' => date('y'),'MONTH' => date('m'),'KD_TPS' => $detail['KD_TPS']))->result_array();
                
                foreach($get_ref_number as $result){                
                    $GetYEAR = $result['YEAR'] ;
                    $GetMONTH = $result['MONTH'] ;
                    $GetNUMBER = $result['NUMBER'] ;
                }

                $this->m_model->updatedata('db_tpsonline','tbl_run_number_tpsonline', array('NUMBER' => $GetNUMBER + 1), $where);
                $GetNUMBER = str_pad($GetNUMBER, 6, "400000", STR_PAD_LEFT);
                $GetDATE = date('m');
                $REF_NUMBER = $GetKD_TPS . '' . $GetYEAR . '' . $GetMONTH . '' . $GetDATE . '' . $GetNUMBER;


                $data = array(
                    'KD_DOK' => 6,
                    'KD_TPS' => $detail['KD_TPS'],
                    'NM_ANGKUT' => $detail['NM_ANGKUT'],
                    'NO_VOY_FLIGHT' => $detail['NO_VOY_FLIGHT'],
                    'CALL_SIGN' => $detail['CALL_SIGN'],
                    'TGL_TIBA' => $detail['TGL_TIBA'],
                    'KD_GUDANG' => $detail['GUDANG_TUJUAN'],
                    'REF_NUMBER' => $REF_NUMBER,
                    'NO_CONT' => $detail['NO_CONT'],
                    'UK_CONT' => $detail['UK_CONT'],
                    'NO_SEGEL' => $seal_number,  //ini di input pada saat gate out 
                    'JNS_CONT' => $detail['JNS_CONT'],
                    'NO_BL_AWB' => $do_number,                
                    'TGL_BL_AWB' => $str_TglBC1,
                    'NO_MASTER_BL_AWB' => '',
                    'TGL_MASTER_BL_AWB' => null,
                    'ID_CONSIGNEE' => $str_NPWP, 
                    'CONSIGNEE' => $str_Consignee,              
                    'BRUTO' => $detail['BRUTO'],  
                    'NO_BC11' => $detail['NO_BC11'],
                    'TGL_BC11' => $detail['TGL_BC11'],
                    'NO_POS_BC11' => $detail['NO_POS_BC11'],
                    'KD_TIMBUN' => $datain['block_loc'].' '.$datain['location'],  //ini di input pada saat gate out
                    'KD_DOK_INOUT' => 1,
                    'NO_DOK_INOUT' => $str_NoSPPB,
                    'TGL_DOK_INOUT' => $str_TglSPPB,
                    'WK_INOUT' => tanggal_sekarang(),
                    'KD_SAR_ANGKUT_INOUT' => 1,
                    'NO_POL' => $truck_number,  //ini di input pada saat gate out
                    'FL_CONT_KOSONG' => 2,
                    'ISO_CODE' => '',
                    'PEL_MUAT' => '',
                    'PEL_TRANSIT' => '',
                    'PEL_BONGKAR' => '',
                    'GUDANG_TUJUAN' => $detail['GUDANG_TUJUAN'],
                    'KODE_KANTOR' => '070100',
                    'NO_DAFTAR_PABEAN' => '',
                    'TGL_DAFTAR_PABEAN' => null,
                    'NO_SEGEL_BC' => '',
                    'TGL_SEGEL_BC' => null,
                    'NO_IJIN_TPS' => $detail['NO_IJIN_TPS'],
                    'TGL_IJIN_TPS' => $detail['TGL_IJIN_TPS'],
                    'REF_NUMBER_IN' => $str_reff_number_in
                );

                $hasil = $this->db_tpsonline->insert('tbl_request_plp_out_container', $data);

            }


        }else if($code_principal == "TPP"){

            $cek_kontainer_tps = $this->ptmsadbo->query("select * from tpp_t_bap a inner join tpp_t_bap_detail b on a.T_In_ID=b.T_In_ID 
                where a.RecID = 0 and b.RecID = 0 and b.NoKontainer='".$Cont_Number."' and date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' ");


            if($cek_kontainer_tps->num_rows() > 0){

                $T_In_Detail_ID = $cek_kontainer_tps->row()->T_In_Detail_ID ;

                $this->ptmsadbo->query(" update  tpp_t_bap_detail set TglKeluar='".tanggal_sekarang()."' , JamKeluar ='".jam_sekarang()."',
                Location='".$datain['block_loc'].' '.$datain['location']."' , RecID=1 where T_In_Detail_ID='".$T_In_Detail_ID."' ");

                
                $this->mbatps->query(" update tps_t_plp_do set Cont_Date_Out='".tanggal_sekarang()."',Cont_time_out='".jam_sekarang()."',
                    Truck_Number_Out='".$truck_number."' where T_In_Detail_ID='".$T_In_Detail_ID."' ");
                
                
                $cek_lock_gate = $this->ptmsadbo->query("select * from tpp_t_bap_detail_gate_status where NoKontainer='".$Cont_Number."' and 
                        date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' and FlagStatus<>9 ");    


                if($cek_lock_gate->num_rows() > 0){
                    $this->ptmsadbo->query(" update  tpp_t_bap_detail_gate_status set FlagStatus=9 where NoKontainer='".$Cont_Number."' and 
                        date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' and FlagStatus<>9 ");
                }


            }

        }else if($code_principal == "LCL"){


            $cek_kontainer_lcl = $this->mbatps->query("select * from tps_t_plp a inner join tps_t_plp_detail b on a.T_In_ID=b.T_In_ID 
                where a.RecID = 0 and b.RecID = 0 and b.NoKontainer='".$Cont_Number."' and date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' ");
            $queryku[$a++] = $this->mbatps->last_query();


            if($cek_kontainer_lcl->num_rows() > 0){

                $T_In_Detail_ID = $cek_kontainer_lcl->row()->T_In_Detail_ID ;

                $this->mbatps->query(" update  tps_t_plp_detail set TglKeluar='".tanggal_sekarang()."' , JamKeluar ='".jam_sekarang()."',
                Location='".$location_gabung."' , RecID=1 where T_In_Detail_ID='".$T_In_Detail_ID."' ");

                
                $cek_lock_gate = $this->mbatps->query("select * from tps_t_plp_detail_gate_status where NoKontainer='".$Cont_Number."' and 
                        date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' and FlagStatus<>9 ");    

                if($cek_lock_gate->num_rows() > 0){
                    $this->mbatps->query(" update  tps_t_plp_detail_gate_status set FlagStatus=9 where NoKontainer='".$Cont_Number."' and 
                        date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' and FlagStatus<>9 ");
                }


            }

        }



        $pesan_data = array(
            'msg' => 'Ya', 
            'pesan' => 'Simpan Data Sukses...',
        );

        echo json_encode($pesan_data);
        
    }

    function findMissingNumber($array) {

        // Jika array kosong, langsung kembalikan 1
        if (empty($array)) {
            return 1;
        }
        
        // Urutkan array terlebih dahulu
        sort($array);
        
        // Cek dari angka 1 ke atas
        for ($i = 1; $i <= count($array) + 1; $i++) {
            if (!in_array($i, $array)) {
                return $i;
            }
        }
    }


    // function cek_urut_r_party($party,$do_number,$reff_code){
        // $r_party = $this->ptmsagate->query("select r_party from t_t_entry_cont_out where rec_id=0 and 
        //                         do_number='".$do_number."' and reff_code='".$reff_code."' order by r_party asc ")->result_array();


        // $data_r_party = $this->m_model->array_one_rows($r_party,'r_party');
    //     $no = 1;


    //     for($a=0;$a<$party;$a++){
            
    //         $str_data_r_party = isset($data_r_party[$a]) ? $data_r_party[$a] : "";

    //         if($no != $str_data_r_party){
    //             return $no;
    //         }
    //         $no++;
    //     }   
 

    // }


   
    
}