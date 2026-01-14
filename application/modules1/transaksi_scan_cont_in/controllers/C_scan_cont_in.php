<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");

class C_scan_cont_in extends CI_Controller {

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

        $arraydata = array('' => ' Pilih Principal ','TPS###T P SEMENTARA' => 'TPS (T P SEMENTARA)','LCL###TPS-LCL' => 'LCL (TPS-LCL)','PJT###PERUSAHAAN JASA TITIPAN' => 'PJT (PERUSAHAAN JASA TITIPAN)');
        $code_principal = ComboNonDb($arraydata, 'code_principal', '', 'form-control form-control-sm');

        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'code_principal' => $code_principal,
        );
        $this->load->view('dashboard/index', $data);

    }

    function c_fetch_table(){

        $cont_number = str_replace(' ', '', $this->input->post('cont_number')) ;

        $strSQL = " SELECT a.id_cont_in, a.eir_in, a.bon_bongkar_number, a.code_principal, " ;
        $strSQL.= " a.cont_number, DATE_FORMAT(a.cont_date_in,'%d-%m-%Y') 'cont_date_in', a.cont_time_in, a.reff_code, a.vessel, " ;
        $strSQL.= " a.truck_number, a.driver_name, a.block_loc, a.location, a.cont_status, a.cont_condition,a.seal_number, b.rec_id " ;
        $strSQL.= " FROM t_t_entry_cont_in as a " ;
        $strSQL.= " INNER JOIN t_t_stock as b ON a.id_cont_in=b.id_cont_in " ;
        $strSQL.= " and a.code_principal=b.code_principal " ;
        $strSQL.= " and a.bon_bongkar_number=b.bon_bongkar_number " ;
        $strSQL.= " and a.cont_date_in=b.cont_date_in " ;
        $strSQL.= " and a.cont_number=b.cont_number  and a.code_principal in('PJT','LCL','TPS') " ;
        $strSQL.= " WHERE a.rec_id = 0 " ;
        $strSQL.= " AND b.rec_id != 9 " ;
        $strSQL.= " AND a.cont_date_in BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() " ;

        if($cont_number != ""){
            $strSQL.= " AND REPLACE(a.cont_number,' ','') = '".$cont_number."' ";
        }

        $strSQL.= " ORDER BY a.cont_date_in DESC " ;



        echo json_encode($this->ptmsagate->query($strSQL)->result_array());
    }

    function c_savedata(){
        $cont_number = $this->input->post('cont_number');
        $truck_number = $this->input->post('truck_number');
        $driver_name = $this->input->post('driver_name');
        $seal_number = $this->input->post('seal_number');
        $id_cont_in = $this->input->post('id_cont_in');
        $no_eir = $this->input->post('no_eir');
        $tgl_eir = date_db($this->input->post('tgl_eir'));
        $code_principal = $this->input->post('code_principal');
        $name_principal = $this->input->post('name_principal');

        $a = 0 ;

        $bon_bongkar_number = '' ;
        $reff_code = '' ;
        $cont_status = '' ;

        if($this->ptmsagate->get_where('t_t_entry_cont_in_scan',array('id_cont_in' => $id_cont_in))->num_rows() > 0){
            $pesan_data = array(
                'msg' => 'Tidak', 'pesan' => 'Data Container Ini '.$cont_number.' Sudah Pernah Di Scan/Input....!!!!','sql' => $this->ptmsagate->last_query()
            );
            echo json_encode($pesan_data);
            die;
        }

        $dataCompInContainer = $this->ptmsagate->get_where('t_t_entry_cont_in',array('id_cont_in' => $id_cont_in))->result_array();

        foreach($dataCompInContainer as $InData){
            $cont_number = $InData['cont_number'] ;
            $bon_bongkar_number = $InData['bon_bongkar_number'] ;
            $reff_code  = $InData['reff_code'] ;
            $cont_status = $InData['cont_status'] ;
        }


        $data = array(
            'truck_number'  => $truck_number,
            'driver_name'  => $driver_name,
            'seal_number'  => $seal_number,
            'no_eir' => $no_eir,
            'tgl_eir' => $tgl_eir,
            'cont_date_in' => tanggal_sekarang(),
            'cont_time_in' => jam_sekarang(),
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
        );

        $where = array(
            'id_cont_in' => $id_cont_in,      
            'bon_bongkar_number' => $bon_bongkar_number,      
        );

        $updateIn = $this->ptmsagate->update('t_t_entry_cont_in', $data, $where);
        $sql[$a] = $this->ptmsagate->last_query();

        if (!$updateIn >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_t_entry_cont_in Error....!!!!','sql' => $this->ptmsagate->last_query()
            );
            echo json_encode($pesan_data);
            die;
        }

        // Daftar kunci yang akan dihapus
        $keys_to_remove = ['truck_number', 'driver_name'];
        // Buat array baru tanpa kunci tersebut
        $new_data = array_diff_key($data, array_flip($keys_to_remove));
        // $pesan_data = array(
        //     'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_t_stock Error....!!!!','sql' => $sql,'data' => $new_data
        // );
        // echo json_encode($pesan_data);
        // die;

        $updateStock = $this->ptmsagate->update('t_t_stock', $new_data, $where);
        $sql[$a++] = $this->ptmsagate->last_query();
        if (!$updateStock >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_t_stock Error....!!!!','sql' => $this->ptmsagate->last_query()
            );
            echo json_encode($pesan_data);
            die;
        }


        $updateEir = $this->ptmsagate->update('t_eir', $data, array('bon_bongkar_number' => $bon_bongkar_number));
        $sql[$a++] = $this->ptmsagate->last_query();
        if (!$updateEir >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_eir Error....!!!!','sql' => $this->ptmsagate->last_query()
            );
            echo json_encode($pesan_data);
            die;
        }

        $scan = array(
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
            'id_cont_in' => $id_cont_in
        );
        $insertscan = $this->ptmsagate->insert('t_t_entry_cont_in_scan', $scan);
        $sql[$a++] = $this->ptmsagate->last_query();
        if (!$insertscan >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak', 'pesan' => 'Function Insert Data Ke Table t_t_entry_cont_in_scan Error....!!!!','sql' => $this->ptmsagate->last_query()
            );
            echo json_encode($pesan_data);
            die;
        }

        if($code_principal == "TPS" || $code_principal == "PJT" || $code_principal == "LCL"){
            $cek_kontainer_tps = $this->mbatps->query("select * from tps_t_plp a inner join tps_t_plp_detail b on a.T_In_ID=b.T_In_ID 
                where a.RecID = 0 and b.RecID = 0 and b.NoKontainer='".$cont_number."' ");


            if($cek_kontainer_tps->num_rows() > 0){
                $update = $this->mbatps->query("update  tps_t_plp_detail set TglMasuk='".tanggal_sekarang()."',JamMasuk='".jam_sekarang()."',
                    SealNumber='".$seal_number."' ,Principal='".$code_principal."' where RecID=0 and NoKontainer='".$cont_number."'  ");
                // $sql[$a++] = $this->mbatps->last_query();

                // if (!$update >= 1) {
                //     $pesan_data = array(
                //         'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_eir Error....!!!!','sql' => $this->mbatps->last_query()
                //     );
                //     echo json_encode($pesan_data);
                //     die;
                // }


                $update = $this->mbatps->query("update  tps_t_plp_detail_gate_status set TglMasuk='".tanggal_sekarang()."',Created_On='".tanggal_sekarang()."' 
                    where NoKontainer='".$cont_number."' and FlagStatus <> 9  ");

                $update = $this->mbatps->query("update  tps_t_plp_detail_status set TglMasuk='".tanggal_sekarang()."',Created_On='".tanggal_sekarang()."' 
                    where NoKontainer='".$cont_number."' and FlagStatus <> 9  ");

                
                // $sql[$a++] = $this->mbatps->last_query();
                // if (!$update >= 1) {
                //     $pesan_data = array(
                //         'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_eir Error....!!!!','sql' => $this->mbatps->last_query()
                //     );
                //     echo json_encode($pesan_data);
                //     die;
                // }

            }else{
                $GateNomor = '' ;
                $r_number = $this->ptmsagate->query('select r_number from r_lock_gate')->row()->r_number;
                $GateNomor = 'Gate'.$r_number ;
                $r_number = $r_number+1;

                $r_lock_gate = "update r_lock_gate set r_number='".$r_number."' " ;
                $update = $this->ptmsagate->query($r_lock_gate);
                // $sql[$a++] = $this->ptmsagate->last_query();
                // if (!$update >= 1) {
                //     $pesan_data = array(
                //         'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_eir Error....!!!!','sql' => $this->ptmsagate->last_query()
                //     );
                //     echo json_encode($pesan_data);
                //     die;
                // }

                $data = array(
                    'T_In_Detail_ID' => $GateNomor,
                    'NoKontainer' => $cont_number,
                    'FlagStatus' => 1,
                    'Created_on' => tanggal_sekarang(),
                    'Created_by' => $this->session->userdata('autogate_username'),
                    'TglMasuk' => tanggal_sekarang(),
                    'No_pos' => '',
                    'No_bc' => '',
                );

                // $update = $this->mbatps->insert('tps_t_plp_detail_gate_status', $data);
                // $sql[$a++] = $this->mbatps->last_query();
                // if (!$update >= 1) {
                //     $pesan_data = array(
                //         'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_eir Error....!!!!','sql' => $this->mbatps->last_query()
                //     );
                //     echo json_encode($pesan_data);
                //     die;
                // }

            }



            //disini kita update data db_tpsonline yang baru
            //DISINI AMBIL ID JEMBATAN penghubungnya
            $REF_NUMBER_FCL_IN = $this->m_model->getvalue('db_tpsonline','REF_NUMBER_FCL_IN', 'tbl_respon_plp_petikemas_detail', array('ID_CONT_IN' => $id_cont_in)) ;
            //UPDATE tbl_request_plp_in_container
            if($REF_NUMBER_FCL_IN != ""){
                $uk_cont = "20" ;
                if(substr($reff_code,0,1) == "4"){
                    $uk_cont = "40" ;
                }

                $isiKontainer = "2" ; //2 = isi, 1 = kosong
                if($cont_status == "Empty"){
                    $isiKontainer = "1" ;
                }

                
                $dataupdate = array(
                    'WK_INOUT' => tanggal_sekarang(),
                    'NO_SEGEL' => $seal_number,
                    'NO_POL' => $truck_number,
                    'FL_CONT_KOSONG' => $isiKontainer,
                    'NO_IJIN_TPS' => $no_eir,
                    'TGL_IJIN_TPS' => $tgl_eir,
                );


                $update = $this->db_tpsonline->update('tbl_request_plp_in_container', $dataupdate, array('REF_NUMBER' => $REF_NUMBER_FCL_IN));
                // $sql[$a++] = $this->db_tpsonline->last_query();

                // if (!$update >= 1) {
                //     $pesan_data = array(
                //         'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_eir Error....!!!!','sql' => $this->db_tpsonline->last_query()
                //     );
                //     echo json_encode($pesan_data);
                //     die;
                // }

            }



            $T_IN_ID = $this->m_model->getvalue('db_tpsonline','T_IN_ID', 'tbl_respon_plp_petikemas_detail', array('ID_CONT_IN' => $id_cont_in)) ;
            $T_IN_DETAIL_ID = $this->m_model->getvalue('db_tpsonline','T_IN_DETAIL_ID', 'tbl_respon_plp_petikemas_detail', array('ID_CONT_IN' => $id_cont_in)) ;

            if($T_IN_ID != "" && $T_IN_DETAIL_ID != ""){
                $dataupdate = array(
                    'TglMasuk' => tanggal_sekarang(),
                    'JamMasuk' => jam_sekarang(),
                    'SealNumber' => $seal_number,
                    'principal' => $code_principal,
                    'KdCtr' => $reff_code,
                );


                $update = $this->mbatps->update('tps_t_plp_detail', $dataupdate, array('T_IN_ID' => $T_IN_ID,'T_IN_DETAIL_ID' => $T_IN_DETAIL_ID));
                // $sql[$a++] = $this->mbatps->last_query();

                // if (!$update >= 1) {
                //     $pesan_data = array(
                //         'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_eir Error....!!!!','sql' => $this->mbatps->last_query()
                //     );
                //     echo json_encode($pesan_data);
                //     die;
                // }
            }








        }


        $pesandaata = array(
            'msg' => 'Ya',
            'pesan' => 'Update Data Sukses..!!',
            'sql' => $sql
        );

        echo json_encode($pesandaata);


    }

    
}