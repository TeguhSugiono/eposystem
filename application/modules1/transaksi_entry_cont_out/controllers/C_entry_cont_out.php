<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");

class C_entry_cont_out extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);
        $this->mbatps = $this->load->database('mbatps', TRUE);
        $this->ptmsadbo = $this->load->database('ptmsadbo', TRUE);
        $this->db_tpsonline = $this->load->database('db_tpsonline', TRUE);  
    }

    function index() {

        // $array_awal = array(
        //     'test' => 123456,
        //     'test2' => 234567,
        // );

        // $array_awal['hehe'] = 56454 ;       
        // // print_r($array_awal);
        // // unset($array_awal['test2']);
        // print_r($array_awal);

        // die;

        // $do_number = 'YMLUI216407042' ;
        // $reff_code = '2DS' ;
        // $r_party = '2' ;

        // $cari_r_party = $this->ptmsagate->query("select count(*) as 'data_r_party' 
        //     from t_t_entry_cont_out where do_number='".$do_number."' and reff_code='".$reff_code."' and r_party>=".$r_party." and rec_id=0 ");
        // echo $this->ptmsagate->last_query();
        // die;



        // $cont_number = $this->ptmsagate->query("select cont_number from t_t_entry_cont_out where do_number='YMLUI216407042' and rec_id=0 ")->result_array();
        //     $cont_number = $this->m_model->array_one_rows($cont_number,'cont_number');


        //     $where_not_in = array();
        //     if(count($cont_number) > 0){
        //         $where_not_in = array('field' => 'Cont_Number', 'value' => $cont_number);
        //     }
        //     print_r($where_not_in);
        //     die;


        // $r_party = $this->ptmsagate->query("select r_party from t_t_entry_cont_out where rec_id=0 and 
        //                         do_number='8090939' and reff_code='2DH' order by r_party asc ")->result_array();


        // $data_r_party = $this->m_model->array_one_rows($r_party,'r_party');

        // print("<pre>".print_r($data_r_party,true)."</pre>"); die;


        // $r_party = $this->ptmsagate->query("select r_party from t_t_entry_cont_out where rec_id=0 and 
        //                         do_number='8090939' and reff_code='2DH' order by r_party asc ")->result_array();


        // $data_r_party = $this->m_model->array_one_rows($r_party,'r_party');
        // $no = 1 ;
        // $r_party = 0 ;
        // for( $a=0; $a<count((array) $data_r_party); $a++ ){
        //     $r_party = $data_r_party[$a];

        //     if($no != $r_party){
        //         echo $no;
        //         break;
        //     }

        //     $no++;
        // }

        // die;


        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_tbl_do_cont_out() {
        $database = "ptmsagate";

        $select = ' a.id_entry_do,a.do_date,a.do_number,a.reff_code,a.code_principal,a.vessel,a.shipper,a.seal_number,a.destination,a.notes,
        a.party,a.cont_out ';
        $form = 't_t_entry_do_cont_out as a';
        $join = array();
        $where = array('a.rec_id' => 0);

        $where_term = array(
            'a.id_entry_do','a.do_date', 'a.do_number', 'a.reff_code','a.code_principal', 'a.vessel', 'a.shipper', 'a.seal_number', 'a.destination', 'a.notes',
            'a.party', 'a.cont_out'
        );
        $column_order = array(
            null,'a.id_entry_do', 'a.do_date', 'a.do_number', 'a.reff_code','a.code_principal', 'a.vessel', 'a.shipper', 'a.seal_number', 'a.destination', 'a.notes',
            'a.party', 'a.cont_out'
        );
        $order = array(
            'a.id_entry_do' => 'desc'
        );

        $group = array();

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

        $list = $this->m_model->get_datatables($database, $array_table);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $field->id_entry_do;
            $row[] = showdate_dmy($field->do_date);
            $row[] = $field->do_number;
            $row[] = $field->reff_code;
            $row[] = $field->code_principal;
            $row[] = $field->vessel;
            $row[] = $field->shipper;
            $row[] = $field->seal_number;
            $row[] = $field->destination;
            $row[] = $field->notes;            
            $row[] = $field->party;
            $row[] = $field->cont_out;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_model->count_all($database, $array_table),
            "recordsFiltered" => $this->m_model->count_filtered($database, $array_table),
            "data" => $data,
        );

        echo json_encode($output);
    }

    function c_get_do_contout() {



        $query = "  SELECT a.Date_DO_Print as 'do_date',a.DO_Number as 'do_number',principal,vessel,
        c.shipper,b.sealnumber,'Belum Ada' as 'destination',b.KdCtr 
        from tps_t_plp_do a
        INNER JOIN tps_t_plp_detail b on a.T_In_Detail_ID=b.T_In_Detail_ID and a.Cont_Number=b.NoKontainer
        INNER JOIN tps_t_plp c on b.t_in_id = c.t_in_id
        where b.RecID<> 9 and c.recid<>9 and FLAG_SINKRON=0
        GROUP BY a.Do_Number,b.KdCtr
        ORDER BY No_Transaksi asc ";

        //Kontainer TPS
        if($this->mbatps->query($query)->num_rows() > 0 ){

            $pesan_data = array('msg' => 'Tidak', 'pesan' => 'Tidak Ada Data Yang Di Download...');
            echo json_encode($pesan_data);

            // $pesan_data = array(
            //     'msg' => 'Tidak',
            //     'pesan' => 'TPS',
            // );
            // echo json_encode($pesan_data);
            // die;

            $data = $this->mbatps->query($query)->result_array();

            $a = 0;
            foreach ($data as $row) {

                $name_principal = getvalueb($this->ptmsagate->query("select name_principal from t_m_principal where rec_id=0 and  code_principal='" . $row['principal'] . "'")->result_array()[0]);

                $get_party = $this->mbatps->query(" SELECT COUNT(*) as party from tps_t_plp_do a
                    INNER JOIN tps_t_plp_detail b on a.T_In_Detail_ID=b.T_In_Detail_ID
                    where b.RecID=0 and b.KdCtr='" . $row['KdCtr'] . "'  and Do_Number='" . $row['do_number'] . "'");
                $party = 0;
                foreach ($get_party->result_array() as $rowparty) {
                    $party = $rowparty['party'];
                }

                $data = array(
                    'do_number' => $row['do_number'],
                    'code_principal' => $row['principal'],
                    'name_principal' => $name_principal,
                    'vessel' => $row['vessel'],
                    'shipper' => $row['shipper'],
                    'seal_number' => $row['sealnumber'],
                    'destination' => $row['destination'],
                    'do_date' => $row['do_date'],
                    'reff_code' => $row['KdCtr'],
                    'party' => $party,
                    'cont_out' => 0,
                    'created_by' => $this->session->userdata('autogate_username'),
                    'created_on' => tanggal_sekarang(),
                    'rec_id' => 0,
                );

                $hasil = $this->ptmsagate->insert('t_t_entry_do_cont_out', $data);
                $queryku[$a++] = $this->ptmsagate->last_query();

                if ($hasil >= 1) {
                    $pesan_data = array(
                        'msg' => 'Ya',
                        'pesan' => 'Download Data Sukses..',
                        'data' => $data,
                        'queryku' => $queryku,
                    );

                    $query = "Update tps_t_plp_do set  FLAG_SINKRON=1 where FLAG_SINKRON=0 and Do_Number='" . $row['do_number'] . "'";
                    $result = $this->mbatps->query($query);
                    //$queryupdate[$b++] = $this->mbatps->last_query();
                } else {
                    $pesan_data = array(
                        'msg' => 'Tidak',
                        'pesan' => 'Download DO ke Tabel t_t_entry_do_cont_out Error....!!!!',
                        'data' => $data,
                        'queryku' => $queryku,
                    );
                    echo json_encode($pesan_data);
                    die;
                }
            }
            
            echo json_encode($pesan_data);

        }else{

            $query = "  SELECT a.Date_DO_Print as 'do_date',a.DO_Number as 'do_number','TPP' as 'principal',vessel,
            '' as 'shipper',b.no_seal,'Belum Ada' as 'destination',b.KdCtr 
            from mba_tps.tps_t_plp_do a
            INNER JOIN ptmsa_dbo.tpp_t_bap_detail b on a.T_In_Detail_ID=b.T_In_Detail_ID 
            and REPLACE(a.Cont_Number,' ','')=REPLACE(b.NoKontainer,' ','')
            INNER JOIN ptmsa_dbo.tpp_t_bap c on b.t_in_id = c.t_in_id
            where b.RecID<> 9 and c.recid<>9 and FLAG_SINKRON=0
            GROUP BY a.Do_Number,b.KdCtr
            ORDER BY No_Transaksi asc ";

            //Kontainer TPP
            if($this->ptmsadbo->query($query)->num_rows() > 0 ){

                $data = $this->ptmsadbo->query($query)->result_array();
                
                $a = 0;
                foreach ($data as $row) {




                    $name_principal = getvalueb($this->ptmsagate->query("select name_principal from t_m_principal where rec_id=0 and  code_principal='" . $row['principal'] . "'")->result_array()[0]);

                    $get_party = $this->mbatps->query(" SELECT COUNT(*) as party from tps_t_plp_do a
                        INNER JOIN ptmsa_dbo.tpp_t_bap_detail b on a.T_In_Detail_ID=b.T_In_Detail_ID
                        where b.RecID<>9 and b.KdCtr='" . $row['KdCtr'] . "'  and Do_Number='" . $row['do_number'] . "'");
                    $party = 0;
                    foreach ($get_party->result_array() as $rowparty) {
                        $party = $rowparty['party'];
                    }

                    // $pesan_data = array(
                    //     'msg' => 'Tidak',
                    //     'pesan' => 'TPP',
                    //     'query' => $this->ptmsadbo->last_query(),
                    //     'name_principal' => $name_principal,
                    //     'party' => $party,
                    //     'get_party' => $get_party
                    // );
                    // echo json_encode($pesan_data);
                    // die;

                    $data = array(
                        'do_number' => $row['do_number'],
                        'code_principal' => $row['principal'],
                        'name_principal' => $name_principal,
                        'vessel' => $row['vessel'],
                        'shipper' => $row['shipper'],
                        'seal_number' => $row['sealnumber'],
                        'destination' => $row['destination'],
                        'do_date' => $row['do_date'],
                        'reff_code' => $row['KdCtr'],
                        'party' => $party,
                        'cont_out' => 0,
                        'created_by' => $this->session->userdata('autogate_username'),
                        'created_on' => tanggal_sekarang(),
                        'rec_id' => 0,
                    );

                    $hasil = $this->ptmsagate->insert('t_t_entry_do_cont_out', $data);
                    $queryku[$a++] = $this->ptmsagate->last_query();

                    if ($hasil >= 1) {
                        $pesan_data = array(
                            'msg' => 'Ya',
                            'pesan' => 'Download Data Sukses..',
                            'data' => $data,
                            'queryku' => $queryku,
                        );

                        $query = "Update tps_t_plp_do set  FLAG_SINKRON=1 where FLAG_SINKRON=0 and Do_Number='" . $row['do_number'] . "'";
                        $result = $this->mbatps->query($query);

                    } else {
                        $pesan_data = array(
                            'msg' => 'Tidak',
                            'pesan' => 'Download DO ke Tabel t_t_entry_do_cont_out Error....!!!!',
                            'data' => $data,
                            'queryku' => $queryku,
                        );
                        echo json_encode($pesan_data);
                        die;
                    }
                }

                echo json_encode($pesan_data);
            }

            $pesan_data = array('msg' => 'Tidak', 'pesan' => 'Tidak Ada Data Yang Di Download...');
            echo json_encode($pesan_data);

        }


    }

    function c_formadd_do() {

        $arraydata = $this->ptmsagate->query("SELECT code_principal,name_principal FROM t_m_principal where rec_id=0")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'code_principal', 'class' => 'selectpicker'),
        );
        $data['code_principal'] = ComboDb($createcombo);


        $arraydata = $this->ptmsagate->query("SELECT reff_code,reff_code as reff_code2 FROM t_m_refference where rec_id=0")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'reff_code', 'class' => 'selectpicker'),
        );
        $data['reff_code'] = ComboDb($createcombo);

        $this->load->view('add_do', $data);
    }

    function c_formedit_do() {
        $database = 'ptmsagate' ;
        $id_entry_do = $this->input->post('id_entry_do');
        
        $data['id_entry_do'] = $id_entry_do ;
        
        $array_data = $this->m_model->table_tostring($database, '', 't_t_entry_do_cont_out', '', array('id_entry_do' => $id_entry_do), '');
        $data['array_data'] = $array_data;

        $arrayselect = $this->ptmsagate->query("SELECT code_principal,name_principal FROM t_m_principal where rec_id=0")->result_array();
        $createcombo = array(
            'data' => $arrayselect,
            'set_data' => array('set_id' => $array_data['code_principal']),
            'attribute' => array('idname' => 'code_principal', 'class' => ''),
        );
        $data['code_principal'] = ComboDb($createcombo);


        $arrayselect = $this->ptmsagate->query("SELECT reff_code,reff_code as reff_code2 FROM t_m_refference where rec_id=0")->result_array();
        $createcombo = array(
            'data' => $arrayselect,
            'set_data' => array('set_id' => $array_data['reff_code']),
            'attribute' => array('idname' => 'reff_code', 'class' => ''),
        );
        $data['reff_code'] = ComboDb($createcombo);

        $this->load->view('edit_do', $data);
    }
    
    function c_save_do() {
        $do_date = $this->input->post('do_date');
        $do_number = strtoupper($this->input->post('do_number'));
        $code_principal = strtoupper($this->input->post('code_principal'));
        $name_principal = strtoupper(getvalueb($this->ptmsagate->query("select name_principal from t_m_principal where rec_id=0 and  code_principal='" . $code_principal . "'")->result_array()[0]));
        $vessel = $this->input->post('vessel');
        $shipper = $this->input->post('shipper');
        $seal_number = $this->input->post('seal_number');
        $destination = $this->input->post('destination');
        $notes = $this->input->post('notes');
        $reff_code = strtoupper($this->input->post('reff_code'));
        $party = $this->input->post('party');

        $data = array(
            'do_number' => $do_number,
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'vessel' => $vessel,
            'shipper' => $shipper,
            'seal_number' => $seal_number,
            'destination' => $destination,
            'notes' => $notes,
            'do_date' => date_db($do_date),
            'reff_code' => $reff_code,
            'party' => $party,
            'cont_out' => 0,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
            'rec_id' => 0,
        );

        $hasil = $this->ptmsagate->insert('t_t_entry_do_cont_out', $data);
        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Save Data Sukses..',
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Save Data ke Tabel t_t_entry_do_cont_out Error....!!!!',
            );
            echo json_encode($pesan_data);
            die;
        }
        
        echo json_encode($pesan_data);
    }
    
    function c_update_do(){
        $id_entry_do = $this->input->post('id_entry_do');
        
        //$do_date = $this->input->post('do_date');
        //$do_number = $this->input->post('do_number');
        //$code_principal = $this->input->post('code_principal');
        //$name_principal = getvalueb($this->ptmsagate->query("select name_principal from t_m_principal where rec_id=0 and  code_principal='" . $code_principal . "'")->result_array()[0]);
        $vessel = $this->input->post('vessel');
        $shipper = $this->input->post('shipper');
        $seal_number = $this->input->post('seal_number');
        $destination = $this->input->post('destination');
        $notes = $this->input->post('notes');
        $reff_code = strtoupper($this->input->post('reff_codex'));
        $party = $this->input->post('party');

        $data = array(
            'vessel' => $vessel,
            'shipper' => $shipper,
            'seal_number' => $seal_number,
            'destination' => $destination,
            'notes' => $notes,
            'reff_code' => $reff_code,
            'party' => $party,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        
        $where = array('id_entry_do' => $id_entry_do);

        $hasil = $this->ptmsagate->update('t_t_entry_do_cont_out', $data, $where);
//        echo $this->ptmsagate->last_query();die;
        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Save Data Sukses..',
                'query' => $this->ptmsagate->last_query(),
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update Data ke Tabel t_t_entry_do_cont_out Error....!!!!',
                'query' => $this->ptmsagate->last_query(),
            );
            echo json_encode($pesan_data);
            die;
        }

        $cont_out = $this->input->post('cont_out');
        $do_number = $this->input->post('do_number');
        if($cont_out > 0){
            $this->ptmsagate->query(" update t_t_entry_cont_out set party=".$party." where do_number='".$do_number."' and reff_code='".$reff_code."' ");
        }
        
        echo json_encode($pesan_data);
    }
    
    function c_delete_do(){
        $id_entry_do = $this->input->post('id_entry_do');

        $do_number = $this->ptmsagate->query('select do_number from t_t_entry_do_cont_out where id_entry_do="'.$id_entry_do.'" and rec_id=0')->row()->do_number;
        $reff_code = $this->ptmsagate->query('select reff_code from t_t_entry_do_cont_out where id_entry_do="'.$id_entry_do.'" and rec_id=0')->row()->reff_code;


        $getdata = $this->ptmsagate->query("   select * from t_t_entry_do_cont_out a 
            INNER JOIN t_t_entry_cont_out b 
            on a.do_number=b.do_number and a.reff_code=b.reff_code
            and a.code_principal=b.code_principal
            where a.rec_id=0 and b.rec_id=0 and a.do_number='".$do_number."' and  a.reff_code='".$reff_code."' ")->num_rows();


        if($getdata > 0){
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Tidak Bisa Hapus Data Do, Karena Sudah Dipakai Di Data Kontainer Keluar..!!','getdata' => $getdata,'query' => $this->ptmsagate->last_query()); 
            echo json_encode($pesan_data); die;
        }else{

            $data_delete = array(
                'edited_by' => $this->session->userdata('autogate_username'),
                'edited_on' => tanggal_sekarang(),
                'rec_id' => 9
            );

            $deletedata = $this->m_model->updatedata('ptmsagate','t_t_entry_do_cont_out',$data_delete,array('id_entry_do' => $id_entry_do));

            if ($deletedata >= 1) {
                $pesan_data = array('msg' => 'Ya','pesan' => 'Hapus DO suksess..!!','query' => $this->ptmsagate->last_query()); 
                echo json_encode($pesan_data); 
            }else{
                $pesan_data = array('msg' => 'Tidak','pesan' => 'Delete Do Error..!!','query' => $this->ptmsagate->last_query()); 
                echo json_encode($pesan_data); die;
            }            
        }

    }
    
    function c_tbl_entry_cont_out() {
        $database = "ptmsagate";

        $id_entry_do = $this->input->post('id_entry_do') == "" ? "" : $this->input->post('id_entry_do') ;
        $reff_code = "" ;
        if($id_entry_do != ""){
            $reff_code = $this->ptmsagate->query("SELECT reff_code FROM t_t_entry_do_cont_out where rec_id=0 and id_entry_do='".$id_entry_do."' ")->row()->reff_code;
        }


        $select = ' id_cont_out,eir_number,bon_muat_number,No_Transaksi,do_number,code_principal,cont_number,cont_date_out,cont_time_out,reff_code,
        vessel,truck_number,driver_name,block_loc,location,cont_status,cont_condition,rec_id';
        $form = 't_t_entry_cont_out';
        $join = array();
        $where = array('rec_id !=' => 9);
        
        if($this->input->post('do_number') != ""){
            $tambah_where = array('do_number' => $this->input->post('do_number'),'reff_code' => $reff_code);
            $where = array_merge($where, $tambah_where);
        }

        $where_term = array(
            'id_cont_out', 'eir_number', 'bon_muat_number','No_Transaksi','do_number', 'code_principal', 'cont_number', 'cont_date_out', 'cont_time_out', 'reff_code',
            'vessel', 'truck_number', 'driver_name', 'block_loc', 'location', 'cont_status', 'cont_condition', 'rec_id'
        );
        $column_order = array(
            null, 'id_cont_out', 'eir_number', 'bon_muat_number','No_Transaksi','do_number', 'code_principal', 'cont_number', 'cont_date_out', 'cont_time_out', 'reff_code',
            'vessel', 'truck_number', 'driver_name', 'block_loc', 'location', 'cont_status', 'cont_condition', 'rec_id'
        );
        $order = array(
            'id_cont_out' => 'desc'
        );

        $group = array();

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

        $list = $this->m_model->get_datatables($database, $array_table);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $field) {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $field->id_cont_out;
            $row[] = $field->eir_number;
            $row[] = $field->bon_muat_number;
            $row[] = $field->No_Transaksi;
            $row[] = $field->do_number;            
            $row[] = $field->code_principal;
            $row[] = $field->cont_number;
            $row[] = showdate_dmy($field->cont_date_out);
            $row[] = jam($field->cont_time_out);
            $row[] = $field->reff_code;
            $row[] = $field->vessel;
            $row[] = $field->truck_number;
            $row[] = $field->driver_name;
            $row[] = $field->block_loc;
            $row[] = $field->location;
            $row[] = $field->cont_status;
            $row[] = $field->cont_condition;
            $row[] = $field->rec_id;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_model->count_all($database, $array_table),
            "recordsFiltered" => $this->m_model->count_filtered($database, $array_table),
            "data" => $data,
        );

        echo json_encode($output);
    }

    function cek_urut_r_party($party,$do_number,$reff_code){
        $r_party = $this->ptmsagate->query("select r_party from t_t_entry_cont_out where rec_id=0 and 
            do_number='".$do_number."' and reff_code='".$reff_code."' order by r_party asc ")->result_array();


        $data_r_party = $this->m_model->array_one_rows($r_party,'r_party');
        $no = 1;


        for($a=0;$a<$party;$a++){

            $str_data_r_party = isset($data_r_party[$a]) ? $data_r_party[$a] : "";

            if($no != $str_data_r_party){
                return $no;
            }
            $no++;
        }   


    }

    function c_formadd(){

        $id_entry_do = $this->input->post('id_entry_do');
        $do_number = $this->input->post('do_number') ;

        $reff_code = $this->ptmsagate->query("SELECT reff_code FROM t_t_entry_do_cont_out where rec_id=0 and id_entry_do='".$id_entry_do."' ")->row()->reff_code;
        $party = $this->ptmsagate->query("SELECT party FROM t_t_entry_do_cont_out where rec_id=0 and id_entry_do='".$id_entry_do."' ")->row()->party;
        $data['party'] = $party ;
        
        $r_party = $this->ptmsagate->query("select COUNT(*) 'r_party' from t_t_entry_cont_out 
            where do_number='".$do_number."' and reff_code='".$reff_code."' and  rec_id=0 ")->row()->r_party;

        if($r_party == 0){
            $data['r_party'] = $r_party + 1 ;
        }else{
            $r_party = $this->cek_urut_r_party($party,$do_number,$reff_code);
            $data['r_party'] = $r_party ;
        }


        $data['id_entry_do'] = $id_entry_do ;
        $data['do_number'] = $do_number;
        $data['destination'] = $this->input->post('destination');


        $arraydata = array('AV' => 'AV (Available)', 'DM' => 'DM (Damage)');
        $cont_condition = ComboNonDb($arraydata, 'cont_condition', 'AV', 'form-control form-control-sm');
        $data['cont_condition'] = $cont_condition;

        $arraydata = array('Full' => 'Full', 'Empty' => 'Empty');
        $cont_status = ComboNonDb($arraydata, 'cont_status', 'Full', 'form-control form-control-sm');
        $data['cont_status'] = $cont_status;


        $data['bon_muat_number'] = $this->m_model->bon_muat_number();

        $this->load->view('add',$data);
    }

    function c_save(){

        $do_number = $this->input->post('do_number');
        $No_Transaksi = $this->input->post('No_Transaksi');
        $cont_number = strtoupper($this->input->post('cont_number'));
        $bon_muat_number = $this->input->post('bon_muat_number');
        $code_principal = strtoupper($this->input->post('code_principal'));
        $name_principal = strtoupper($this->input->post('name_principal'));
        $reff_code = strtoupper($this->input->post('reff_code'));
        $reff_description = $this->input->post('reff_description');
        $cont_date_in = $this->input->post('cont_date_in');


        $get_id_cont_in = $this->ptmsagate->query("select id_cont_in from t_t_stock 
            where rec_id=0 and cont_date_in='".date_db($cont_date_in)."' and cont_number='".$cont_number."' and reff_code='".$reff_code ."' ")->result_array();

        $id_cont_in = "" ;
        foreach($get_id_cont_in as $row){
            $id_cont_in = $row['id_cont_in'];
        }

        if($id_cont_in == ""){
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Data Kontainer Gate IN tidak ditemukan....!!!!',
            );
            echo json_encode($pesan_data);
            die;
        }

        $get_principal_code = $this->ptmsagate->query("select code_principal from t_t_entry_do_cont_out 
            where rec_id=0 and do_number='".$do_number."' and reff_code='".$reff_code ."' and code_principal='".$code_principal."' ")->result_array();

        $code_principal_do = "" ;
        foreach($get_principal_code as $row){
            $code_principal_do = $row['code_principal'];
        }

        if($code_principal_do == ""){
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Data Principal Di Do tidak Sama Dengan Data Principal Pada Saat Kontainer Keluar..!!',
            );
            echo json_encode($pesan_data);
            die;
        }

        $cont_date_out = $this->input->post('cont_date_out');
        $cont_time_out = $this->input->post('cont_time_out');
        $vessel = $this->input->post('vessel');
        $seal_number = $this->input->post('seal_number');
        $truck_number = $this->input->post('truck_number');
        $driver_name = $this->input->post('driver_name');
        $r_party = $this->input->post('r_party');
        $party = $this->input->post('party');
        $shipper = $this->input->post('shipper');
        $destination = $this->input->post('destination');
        $cont_condition = $this->input->post('cont_condition');
        $cont_status = $this->input->post('cont_status');

        $loc_block = $this->input->post('loc_block');
        $loc_row = $this->input->post('loc_row');
        $loc_col = $this->input->post('loc_col');
        $loc_stack = $this->input->post('loc_stack');
        $location = $loc_row . ' ' . $loc_col . ' ' . $loc_stack;
        $location_gabung = $loc_block.' '.$loc_row . ' ' . $loc_col . ' ' . $loc_stack;
        $location_gabung1 = $loc_block.''.$loc_row . '' . $loc_col . '' . $loc_stack;

        $ship_line_code = $this->input->post('ship_line_code');
        $ship_line_name = $this->input->post('ship_line_name');
        $notes = $this->input->post('notes');

        $bon_bongkar_number = $this->ptmsagate->query("select bon_bongkar_number from t_t_entry_cont_in 
            where rec_id=0 and cont_date_in='".date_db($cont_date_in)."' and cont_number='".$cont_number."' ")->row()->bon_bongkar_number;

        

        $eir_r_number = $this->m_model->eir_r_number_out();
        $eir_number = $eir_r_number ;
        // $eir_number = $this->ptmsagate->query("select eir_in from t_t_entry_cont_in 
        //     where rec_id=0 and cont_date_in='".date_db($cont_date_in)."' and cont_number='".$cont_number."' ")->row()->eir_in;

        $dangers_goods = $this->ptmsagate->query("select dangers_goods from t_t_entry_cont_in 
            where rec_id=0 and cont_date_in='".date_db($cont_date_in)."' and cont_number='".$cont_number."' ")->row()->dangers_goods;

        $invoice_in = $this->ptmsagate->query("select invoice_in from t_t_entry_cont_in 
            where rec_id=0 and cont_date_in='".date_db($cont_date_in)."' and cont_number='".$cont_number."' ")->row()->invoice_in;

        $bc_code = $this->ptmsagate->query("select bc_code from t_t_entry_cont_in 
            where rec_id=0 and cont_date_in='".date_db($cont_date_in)."' and cont_number='".$cont_number."' ")->row()->bc_code;

        
        $data = array(
            'do_number' => $do_number,
            'No_Transaksi' => $No_Transaksi,
            'cont_number' => $cont_number,
            'bon_muat_number' => $bon_muat_number,
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'cont_date_in' => date_db($cont_date_in),
            'cont_date_out' => date_db($cont_date_out),
            'cont_time_out' => $cont_time_out,
            'vessel' => $vessel,
            'seal_number' => $seal_number,
            'truck_number' => $truck_number,
            'driver_name' => $driver_name,
            'r_party' => $r_party,
            'party' => $party,
            'shipper' => $shipper,
            'cont_condition' => $cont_condition,
            'cont_status' => $cont_status,
            'block_loc' => $loc_block,
            'location' => $location,
            'ship_line_code' => $ship_line_code,
            'ship_line_name' => $ship_line_name,
            'notes' => $notes,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
            'rec_id' => 0,
            'bon_bongkar_number' => $bon_bongkar_number,
            'eir_number' => $eir_number,
            'destination' => $destination,
            'dangers_goods' => $dangers_goods,
            'invoice_in' => $invoice_in,
            'bc_code' => $bc_code,
        );

        $hasil = $this->ptmsagate->insert('t_t_entry_cont_out', $data);
        $a=0;
        $queryku[$a++] = $this->ptmsagate->last_query();

        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Save Data Sukses..',
                'data' => $data,
                'queryku' => $queryku,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Save Data Ke Table t_t_entry_cont_out Error....!!!!',
                'data' => $data,
                'queryku' => $queryku,
            );
            echo json_encode($pesan_data);
            die;
        }

        $data = array(
            'cont_date_out' => date_db($cont_date_out),
            'cont_time_out' => $cont_time_out,
            'do_number' => $do_number,
            'bon_muat_number' => $bon_muat_number,
            'notes' => $notes,
            'cont_condition' => $cont_condition,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
            'rec_id' => 1,
            'No_Transaksi' => $No_Transaksi,            
        );

        $where = array(
            'cont_number' => $cont_number,
            'rec_id' => 0,
        );

        $hasil = $this->ptmsagate->update('t_t_stock', $data, $where);
        $queryku[$a++] = $this->ptmsagate->last_query();

        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya', 'pesan' => 'Update Data Sukses..', 'queryku' => $queryku,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_t_stock Error....!!!!', 'queryku' => $queryku,
            );
            echo json_encode($pesan_data);
            die;
        }

        // $eir_r_number = $this->m_model->eir_r_number_out();
        $data = array(
            'bon_muat_number' => $bon_muat_number,
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'cont_number' => $cont_number,
            'do_number' => $do_number,
            'vessel' => $vessel,
            'shipper'=>$shipper,
            'truck_number' => $truck_number,
            'driver_name'=> $driver_name,
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'cont_condition' => $cont_condition,
            'cont_status' => $cont_status,
            'cont_date_in' => date_db($cont_date_in),
            'cont_date_out' => date_db($cont_date_out),
            'cont_time_out' => $cont_time_out,
            'destination' => $destination,
            'seal_number'=>$seal_number,
            'block_loc' => $loc_block,
            'location' => $location,
            'notes' => $notes,
            'eir_type' => 'O',
            'eir_number' => $eir_r_number,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
            'rec_id' => 0,
            'No_Transaksi' => $No_Transaksi,
        );
        
        $hasil = $this->ptmsagate->insert('t_eir', $data);
        $queryku[$a++] = $this->ptmsagate->last_query();

        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Save Data Sukses..',
                'data' => $data,
                'queryku' => $queryku,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Save Data Ke Table t_eir Error....!!!!',
                'data' => $data,
                'queryku' => $queryku,
            );
            echo json_encode($pesan_data);
            die;
        }

        $hasil = $this->ptmsagate->update('t_t_entry_cont_in', array('new_cont_condition' => $cont_condition), array('id_cont_in' => $id_cont_in));
        $queryku[$a++] = $this->ptmsagate->last_query();

        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Update Data Sukses..',
                'queryku' => $queryku,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Update Data Ke Table t_t_entry_cont_in Error....!!!!',
                'queryku' => $queryku,
            );
            echo json_encode($pesan_data);
            die;
        }


        

        $where = array(
            'do_number' => $do_number,
            'reff_code' => $reff_code,
            'rec_id' => 0,
        );

        $cari_r_party = $this->ptmsagate->query("select count(*) as 'data_r_party' 
            from t_t_entry_cont_out where do_number='".$do_number."' and reff_code='".$reff_code."' and r_party>".$r_party." and rec_id=0 ")->row()->data_r_party;
        if($cari_r_party == 0){
            $data = array(
                'cont_out' => $r_party,
                'edited_by' => $this->session->userdata('autogate_username'),
                'edited_on' => tanggal_sekarang(),           
            );
        }else{
            $data = array(
                'edited_by' => $this->session->userdata('autogate_username'),
                'edited_on' => tanggal_sekarang(),           
            );
        }


        $hasil = $this->ptmsagate->update('t_t_entry_do_cont_out', $data, $where);
        $queryku[$a++] = $this->ptmsagate->last_query();

        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya', 'pesan' => 'Update Data Sukses..', 'queryku' => $queryku,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_t_entry_do_cont_out Error....!!!!', 'queryku' => $queryku,
            );
            echo json_encode($pesan_data);
            die;
        }

        $update_no_eir_in = $this->m_model->update_eir_r_number_out();



        if($code_principal == "TPS" || $code_principal == "PJT"){

            $cek_kontainer_tps = $this->mbatps->query("select * from tps_t_plp a inner join tps_t_plp_detail b on a.T_In_ID=b.T_In_ID 
                where a.RecID = 0 and b.RecID = 0 and b.NoKontainer='".$cont_number."' and date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' ");
            $queryku[$a++] = $this->mbatps->last_query();


            if($cek_kontainer_tps->num_rows() > 0){

                $T_In_Detail_ID = $cek_kontainer_tps->row()->T_In_Detail_ID ;

                $this->mbatps->query(" update  tps_t_plp_detail set TglKeluar='".date_db($cont_date_out)."' , JamKeluar ='".$cont_time_out."',
                    Location='".$location_gabung."' , RecID=1 where T_In_Detail_ID='".$T_In_Detail_ID."' ");
                $queryku[$a++] = $this->mbatps->last_query();

                //if($No_Transaksi != ""){
                $this->mbatps->query(" update tps_t_plp_do set Cont_Date_Out='".date_db($cont_date_out)."',Cont_time_out='".$cont_time_out."',
                    Truck_Number_Out='".$truck_number."' where T_In_Detail_ID='".$T_In_Detail_ID."' ");
                $queryku[$a++] = $this->mbatps->last_query();
                //}
                
                $cek_lock_gate = $this->mbatps->query("select * from tps_t_plp_detail_gate_status where NoKontainer='".$cont_number."' and 
                    date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' and FlagStatus<>9 ");    
                $queryku[$a++] = $this->mbatps->last_query();

                if($cek_lock_gate->num_rows() > 0){
                    $this->mbatps->query(" update  tps_t_plp_detail_gate_status set FlagStatus=9 where NoKontainer='".$cont_number."' and 
                        date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' and FlagStatus<>9 ");
                    $queryku[$a++] = $this->mbatps->last_query();
                }


                $pesan_data = array(
                    'msg' => 'Ya',
                    'pesan' => 'Save Data Sukses..',
                    'data' => $data,
                    'queryku' => $queryku,
                    'T_In_Detail_ID' => $cek_kontainer_tps->row()->T_In_Detail_ID,
                );

            }



            //integrate to out tpsonline
            //$get_id_cont_in
            
            //=========================================================================================================================================

            $get_reff_number_in = $this->db_tpsonline->get_where('tbl_respon_plp_petikemas_detail',array('ID_CONT_IN' => $id_cont_in))->result_array();
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
                    'KD_TIMBUN' => $location_gabung1,  //ini di input pada saat gate out
                    'KD_DOK_INOUT' => 1,
                    'NO_DOK_INOUT' => $str_NoSPPB,
                    'TGL_DOK_INOUT' => $str_TglSPPB,
                    'WK_INOUT' => date_db($cont_date_out).' '.$cont_time_out,
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
                if ($hasil >= 1) {
                }else{
                    $pesan_data = array(
                        'msg' => 'Tidak', 'pesan' => 'Transaction to tbl_request_plp_out_container Error ....!!!!', 'queryku' => $queryku,
                    );
                    echo json_encode($pesan_data);
                    die;
                }
            }


            // $pesan_data = array(
            //     'msg' => 'Ya',
            //     'pesan' => 'Save Data Sukses..',
            //     'data' => $data,
            //     //'queryku' => $queryku,
            //     //'T_In_Detail_ID' => $cek_kontainer_tps->row()->T_In_Detail_ID,
            // );
            // echo json_encode($pesan_data);die;



            //=========================================================================================================================================




        }else if($code_principal == "TPP"){

            $cek_kontainer_tps = $this->ptmsadbo->query("select * from tpp_t_bap a inner join tpp_t_bap_detail b on a.T_In_ID=b.T_In_ID 
                where a.RecID = 0 and b.RecID = 0 and b.NoKontainer='".$cont_number."' and date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' ");
            $queryku[$a++] = $this->ptmsadbo->last_query();


            if($cek_kontainer_tps->num_rows() > 0){

                $T_In_Detail_ID = $cek_kontainer_tps->row()->T_In_Detail_ID ;

                $this->ptmsadbo->query(" update  tpp_t_bap_detail set TglKeluar='".date_db($cont_date_out)."' , JamKeluar ='".$cont_time_out."',
                    Location='".$location_gabung."' , RecID=1 where T_In_Detail_ID='".$T_In_Detail_ID."' ");
                $queryku[$a++] = $this->ptmsadbo->last_query();

                //if($No_Transaksi != ""){
                $this->mbatps->query(" update tps_t_plp_do set Cont_Date_Out='".date_db($cont_date_out)."',Cont_time_out='".$cont_time_out."',
                    Truck_Number_Out='".$truck_number."' where T_In_Detail_ID='".$T_In_Detail_ID."' ");
                $queryku[$a++] = $this->mbatps->last_query();
                //}
                
                $cek_lock_gate = $this->ptmsadbo->query("select * from tpp_t_bap_detail_gate_status where NoKontainer='".$cont_number."' and 
                    date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' and FlagStatus<>9 ");    
                $queryku[$a++] = $this->ptmsadbo->last_query();

                if($cek_lock_gate->num_rows() > 0){
                    $this->ptmsadbo->query(" update  tpp_t_bap_detail_gate_status set FlagStatus=9 where NoKontainer='".$cont_number."' and 
                        date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' and FlagStatus<>9 ");
                    $queryku[$a++] = $this->mbatps->last_query();
                }


                $pesan_data = array(
                    'msg' => 'Ya',
                    'pesan' => 'Save Data Sukses..',
                    'data' => $data,
                    'queryku' => $queryku,
                    'T_In_Detail_ID' => $cek_kontainer_tps->row()->T_In_Detail_ID,
                );

            }

        }elseif($code_principal == "LCL"){

            $cek_kontainer_lcl = $this->mbatps->query("select * from tps_t_plp a inner join tps_t_plp_detail b on a.T_In_ID=b.T_In_ID 
                where a.RecID = 0 and b.RecID = 0 and b.NoKontainer='".$cont_number."' and date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' ");
            $queryku[$a++] = $this->mbatps->last_query();


            if($cek_kontainer_lcl->num_rows() > 0){

                $T_In_Detail_ID = $cek_kontainer_lcl->row()->T_In_Detail_ID ;

                $this->mbatps->query(" update  tps_t_plp_detail set TglKeluar='".date_db($cont_date_out)."' , JamKeluar ='".$cont_time_out."',
                    Location='".$location_gabung."' , RecID=1 where T_In_Detail_ID='".$T_In_Detail_ID."' ");
                $queryku[$a++] = $this->mbatps->last_query();

                // //if($No_Transaksi != ""){
                //     $this->mbatps->query(" update tps_t_plp_do set Cont_Date_Out='".date_db($cont_date_out)."',Cont_time_out='".$cont_time_out."',
                //     Truck_Number_Out='".$truck_number."' where T_In_Detail_ID='".$T_In_Detail_ID."' ");
                //     $queryku[$a++] = $this->mbatps->last_query();
                // //}
                
                $cek_lock_gate = $this->mbatps->query("select * from tps_t_plp_detail_gate_status where NoKontainer='".$cont_number."' and 
                    date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' and FlagStatus<>9 ");    
                $queryku[$a++] = $this->mbatps->last_query();

                if($cek_lock_gate->num_rows() > 0){
                    $this->mbatps->query(" update  tps_t_plp_detail_gate_status set FlagStatus=9 where NoKontainer='".$cont_number."' and 
                        date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' and FlagStatus<>9 ");
                    $queryku[$a++] = $this->mbatps->last_query();
                }


                $pesan_data = array(
                    'msg' => 'Ya',
                    'pesan' => 'Save Data Sukses..',
                    'data' => $data,
                    'queryku' => $queryku,
                    'T_In_Detail_ID' => $cek_kontainer_lcl->row()->T_In_Detail_ID,
                );

            }


        }


        



        echo json_encode($pesan_data);
    }


    function c_search() {
        $nm_table = $this->input->post('nm_table');
        $param_field = $this->input->post('param_field');
        $param_value = $this->input->post('param_value');
        $search_data = $this->input->post('search_data');

        $array_param_field = explode(',',$param_field);
        $array_param_value = explode(',',$param_value);

        $query = " select ";
        $query.= "$search_data";
        $query.= " from ";
        $query.= "$nm_table";
        $query.= " where ";
        $query.= " rec_id = 0 ";

        for($a=0;$a<count($array_param_field);$a++){
            $param_field =  $array_param_field[$a] ;
            $param_value =  $array_param_value[$a] ;
            $query.= " and " ;
            $query.= "$param_field" . "=" . "'$param_value'";
        }

        $getvalue = getvalueb($this->ptmsagate->query($query)->result_array()[0]);

        $pesan_data = array(
            'query' => $query,
            'getvalue' => $getvalue,
        );
        echo json_encode($pesan_data);
    }

    function c_formedit(){

        $id_cont_out = $this->input->post('id_cont_out');
        $data['id_cont_out'] = $id_cont_out;

        $array_search = $this->m_model->table_tostring('ptmsagate', '', 't_t_entry_cont_out', '', array('id_cont_out' => $id_cont_out), '');
        $data['array_search'] = $array_search;

        $arraydata = array('AV' => 'AV (Available)', 'DM' => 'DM (Damage)');
        $cont_condition = ComboNonDb($arraydata, 'cont_condition', $array_search['cont_condition'], 'form-control form-control-sm');
        $data['cont_condition'] = $cont_condition;

        $arraydata = array('Full' => 'Full', 'Empty' => 'Empty');
        $cont_status = ComboNonDb($arraydata, 'cont_status', $array_search['cont_status'], 'form-control form-control-sm');
        $data['cont_status'] = $cont_status;

        $this->load->view('edit',$data);
    }

    function c_update(){

        $id_cont_out = $this->input->post('id_cont_out');
        $cont_date_out = date_db($this->input->post('cont_date_out'));
        $cont_time_out = $this->input->post('cont_time_out');
        $vessel = $this->input->post('vessel');
        $seal_number = $this->input->post('seal_number');
        $truck_number = $this->input->post('truck_number');
        $driver_name = $this->input->post('driver_name');
        $destination = $this->input->post('destination');
        $shipper = $this->input->post('shipper');
        $cont_condition = $this->input->post('cont_condition');
        $cont_status = $this->input->post('cont_status');

        $loc_block = $this->input->post('loc_block');
        $loc_row = $this->input->post('loc_row');
        $loc_col = $this->input->post('loc_col');
        $loc_stack = $this->input->post('loc_stack');
        $location = $loc_row . ' ' . $loc_col . ' ' . $loc_stack;

        $notes = $this->input->post('notes');

        $cont_date_in = $this->input->post('cont_date_in');
        $cont_number = strtoupper($this->input->post('cont_number'));
        $reff_code = strtoupper($this->input->post('reff_code'));
        $get_id_cont_in = $this->ptmsagate->query("select id_cont_in from t_t_stock 
            where rec_id=1 and cont_date_in='".date_db($cont_date_in)."' and cont_number='".$cont_number."' and reff_code='".$reff_code ."' ")->result_array();


        $id_cont_in = "" ;
        foreach($get_id_cont_in as $row){
            $id_cont_in = $row['id_cont_in'];
        }

        if($id_cont_in == ""){
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Data Kontainer Gate IN tidak ditemukan....!!!!',
                'query' => $this->ptmsagate->last_query(),
            );
            echo json_encode($pesan_data);
            die;
        }

        $where = array('id_cont_out' => $id_cont_out,'rec_id' => 0);

        $data_out = array(
            'cont_date_out' => $cont_date_out,
            'cont_time_out' => $cont_time_out,
            'vessel' => $vessel,
            'seal_number' => $seal_number,
            'truck_number' => $truck_number,
            'driver_name' => $driver_name,
            'destination' => $destination,
            'shipper' => $shipper,
            'cont_condition' => $cont_condition,
            'cont_status' => $cont_status,
            'block_loc' => $loc_block,
            'location' => $location,
            'notes' => $notes,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );

        $hasil = $this->ptmsagate->update('t_t_entry_cont_out', $data_out, $where);
        $a=0;
        $query[$a++] = $this->ptmsagate->last_query();

        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Update Data Sukses..',
                'query' => $query,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update Data ke Tabel t_t_entry_cont_out Error....!!!!',
                'query' => $query,
            );
            echo json_encode($pesan_data);
            die;
        }

        $do_number = $this->input->post('do_number');
        $reff_code = $this->input->post('reff_code');
        $cont_number = $this->input->post('cont_number');
        $code_principal = $this->input->post('code_principal');
        $bon_muat_number = $this->input->post('bon_muat_number');

        $where = array('do_number' => $do_number,'reff_code' => $reff_code,'cont_number' => $cont_number,
            'code_principal' => $code_principal,'rec_id' => 1,'bon_muat_number' => $bon_muat_number);

        //unset array with key
        unset($data_out['truck_number']);
        unset($data_out['driver_name']);
        unset($data_out['destination']);
        unset($data_out['shipper']);

        $hasil = $this->ptmsagate->update('t_t_stock', $data_out, $where);
        $query[$a++] = $this->ptmsagate->last_query();

        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Update Data Sukses..',
                'query' => $query,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update Data ke Tabel t_t_stock Error....!!!!',
                'query' => $query,
            );
            echo json_encode($pesan_data);
            die;
        }

        $data_out['truck_number'] = $truck_number ;
        $data_out['driver_name'] = $driver_name ;
        $data_out['destination'] = $destination ;
        $data_out['shipper'] = $shipper ;

        //unset($where['rec_id']);
        $where['rec_id'] = 0;

        $hasil = $this->ptmsagate->update('t_eir', $data_out, $where);
        $query[$a++] = $this->ptmsagate->last_query();

        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Update Data Sukses..',
                'query' => $query,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update Data ke Tabel t_eir Error....!!!!',
                'query' => $query,
            );
            echo json_encode($pesan_data);
            die;
        }


        $hasil = $this->ptmsagate->update('t_t_entry_cont_in', array('new_cont_condition' => $cont_condition), array('id_cont_in' => $id_cont_in));
        $query[$a++] = $this->ptmsagate->last_query();

        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Update Data Sukses..',
                'query' => $query,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Update Data Ke Table t_t_entry_cont_in Error....!!!!',
                'query' => $query,
            );
            echo json_encode($pesan_data);
            die;
        }

        if($code_principal == "TPS" || $code_principal == "PJT"){

            $cek_kontainer_tps = $this->mbatps->query("select * from tps_t_plp a 
                inner join tps_t_plp_detail b on a.T_In_ID=b.T_In_ID 
                where a.RecID = 0 and b.RecID = 1 and b.NoKontainer='".$cont_number."' 
                and date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' ");
            $query[$a++] = $this->mbatps->last_query();


            if($cek_kontainer_tps->num_rows() > 0){
                $T_In_Detail_ID = $cek_kontainer_tps->row()->T_In_Detail_ID ;

                $this->mbatps->query(" update  tps_t_plp_detail 
                    set TglKeluar='".date_db($cont_date_out)."' , JamKeluar ='".$cont_time_out."' 
                    where T_In_Detail_ID='".$T_In_Detail_ID."' ");
                $query[$a++] = $this->mbatps->last_query();

                $this->mbatps->query(" update tps_t_plp_do 
                    set Cont_Date_Out='".date_db($cont_date_out)."',Cont_time_out='".$cont_time_out."',
                    Truck_Number_Out='".$truck_number."' where T_In_Detail_ID='".$T_In_Detail_ID."' ");
                $query[$a++] = $this->mbatps->last_query();   
            }

            $get_reff_number_in = $this->db_tpsonline->get_where('tbl_respon_plp_petikemas_detail',array('ID_CONT_IN' => $id_cont_in))->result_array();
            $str_reff_number_in = "" ;
            $str_T_IN_ID = "" ;
            
            foreach($get_reff_number_in as $row){
                $str_reff_number_in = $row['REF_NUMBER_FCL_IN'];
                $str_T_IN_ID  = $row['T_IN_ID'];
            }


            if($str_reff_number_in != ""){
                $WK_INOUT = date_db($cont_date_out).' '.$cont_time_out ;

                $this->db_tpsonline->query(" update tbl_request_plp_out_container 
                    set WK_INOUT='".$WK_INOUT."'
                    where REF_NUMBER_IN='".$str_reff_number_in."' ");
                $query[$a++] = $this->db_tpsonline->last_query(); 
            }  


        }elseif($code_principal == "LCL"){

            $cek_kontainer_tps = $this->mbatps->query("select * from tps_t_plp a 
                inner join tps_t_plp_detail b on a.T_In_ID=b.T_In_ID 
                where a.RecID = 0 and b.RecID = 1 and b.NoKontainer='".$cont_number."' 
                and date_format(TglMasuk,'%Y-%m-%d')='".date_db($cont_date_in)."' ");
            $query[$a++] = $this->mbatps->last_query();

            if($cek_kontainer_tps->num_rows() > 0){
                $T_In_Detail_ID = $cek_kontainer_tps->row()->T_In_Detail_ID ;

                $this->mbatps->query(" update  tps_t_plp_detail 
                    set TglKeluar='".date_db($cont_date_out)."' , JamKeluar ='".$cont_time_out."' , RecID = '1' 
                    where T_In_Detail_ID='".$T_In_Detail_ID."' ");
                $query[$a++] = $this->mbatps->last_query();

            }


        }
        
        
        echo json_encode($pesan_data);

    }

    function c_delete(){
        $id_cont_out = $this->input->post('id_cont_out');

        $do_number = $this->ptmsagate->query('select do_number from t_t_entry_cont_out where id_cont_out="'.$id_cont_out.'" and rec_id=0')->row()->do_number;
        $reff_code = $this->ptmsagate->query('select reff_code from t_t_entry_cont_out where id_cont_out="'.$id_cont_out.'" and rec_id=0')->row()->reff_code;
        $cont_number = $this->ptmsagate->query('select cont_number from t_t_entry_cont_out where id_cont_out="'.$id_cont_out.'" and rec_id=0')->row()->cont_number;
        $code_principal = $this->ptmsagate->query('select code_principal from t_t_entry_cont_out where id_cont_out="'.$id_cont_out.'" and rec_id=0')->row()->code_principal;


        $data_delete = array(
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
            'rec_id' => 9
        );

        $a=0;
        $deletedata = $this->ptmsagate->update('t_t_entry_cont_out', $data_delete, array('id_cont_out' => $id_cont_out));
        $query[$a++] = $this->ptmsagate->last_query();

        if ($deletedata >= 1) {
            $pesan_data = array('msg' => 'Ya','pesan' => 'Delete Data suksess..!!','query' => $query); 
        }else{
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Delete t_t_entry_cont_out Error..!!','query' => $query); 
            echo json_encode($pesan_data); die;
        }   

        $where = array(
            'do_number' => $do_number,
            'reff_code' => $reff_code,
            'cont_number' => $cont_number,
            'code_principal' => $code_principal,
        );

        $deletedata = $this->ptmsagate->update('t_eir', $data_delete, $where);
        $query[$a++] = $this->ptmsagate->last_query();

        if ($deletedata >= 1) {
            $pesan_data = array('msg' => 'Ya','pesan' => 'Delete Data suksess..!!','query' => $query); 
        }else{
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Delete t_eir Error..!!','query' => $query); 
            echo json_encode($pesan_data); die;
        }  


        $deletedata = $this->ptmsagate->update('t_t_stock', array('rec_id' => 0), $where);
        $query[$a++] = $this->ptmsagate->last_query();

        if ($deletedata >= 1) {
            $pesan_data = array('msg' => 'Ya','pesan' => 'Delete Data suksess..!!','query' => $query); 
        }else{
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Update t_t_stock Error..!!','query' => $query); 
            echo json_encode($pesan_data); die;
        }  

        echo json_encode($pesan_data);

    }

    function c_print() {

        // $data = base64_decode($_GET['data']);
        // $data = explode(',', $data);
        // print_r($data[0]);
        // die;

        include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");
        
        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);

        $eir_out = $data[0];
        $bon_muat_number = $data[1];
        $No_Transaksi = $data[2] ;

        if($No_Transaksi != ""){
            $dataprint = $this->ptmsagate->get_where('t_eir',array('No_Transaksi' => $No_Transaksi,'rec_id' => 0))->result_array();
            foreach($dataprint as $prnt){
                $eir_out = $prnt['eir_number'] ;
                $bon_muat_number = $prnt['bon_muat_number'] ;
            }
        }


        
        $PHPJasperXML = new PHPJasperXML("en","TCPDF"); //if export excel, can use PHPJasperXML("en","XLS OR XLSX"); 
//        $PHPJasperXML->debugsql=true; 
        $PHPJasperXML->arrayParameter = array('eir'=>"'O'",'bonprint'=>$eir_out,'bon_muat_number' => $bon_muat_number);
//        $PHPJasperXML->debugsql=true; 
        $path = APPPATH . 'modules/report_jasper/report_entry_cont_out.jrxml';
        
        $PHPJasperXML->load_xml_file($path); //if xml content is string, then $PHPJasperXML->load_xml_string($templatestr);

        //$PHPJasperXML->sql = $sql;  //if you wish to overwrite sql inside jrxml
        $dbdriver="mysql";//natively is 'mysql', 'psql', or 'sqlsrv'. the rest will use PDO driver. for oracle, use 'oci'
        //$PHPJasperXML->transferDBtoArray($DBSERVER,$DBUSER,$DBPASS,$DBNAME,$dbdriver);
        $version="1.1";
        
        $PHPJasperXML->transferDBtoArray($this->ptmsagate->hostname,$this->ptmsagate->username,$this->ptmsagate->password,$this->ptmsagate->database,$dbdriver);
        $PHPJasperXML->outpage('I');  //$PHPJasperXML->outpage('I=render in browser/D=Download/F=save as server side filename according 2nd parameter','filename.pdf or filename.xls or filename.xls depends on constructor');

//        echo $this->ptmsagate->hostname;
//        echo $this->ptmsagate->username;
//        echo $this->ptmsagate->password;
//        echo $this->ptmsagate->database;
//        die;
        
        
//        $bon_bongkar_number = $_GET['bon_bongkar_number'];
//        
//        $data = array(
//            'bon_bongkar_number' => $bon_bongkar_number,
//        );
//        
//        $html = $this->load->view('print', $data, true);
//        print_r($html);
    }


}
