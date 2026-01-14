<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");

class C_entry_cont_in extends CI_Controller {

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
        
        
//        echo $this->ptmsagate->hostname;
//        echo $this->ptmsagate->username;
//        echo $this->ptmsagate->password;
//        echo $this->ptmsagate->database;
//        die;
        
//        $path = site_url('transaksi_entry_cont_in/t_t_entry_cont_in.jrxml');
//        echo $path;
//        die;
        
//        $ruta = APPPATH . 'modules/transaksi_entry_cont_in/report/report_entry_cont_in.jrxml';
//        echo $ruta;
//        die;
//        $array_search = $this->m_model->table_tostring('ptmsagate', '', 't_t_entry_cont_in', '', array('id_cont_in' => 48462), '');
//        print_r($array_search['cont_condition']);
//        die;

//        $array_data = $this->m_model->table_tostring('db', '', 'TRAN_OB', '', array('pid' => 50742), '');
//        $array_data = array_merge($array_data,array('test' => 'test1111'));
//        print_r($array_data);
//        die;
//        $this->db->select("pid,(SUBSTRING(NO_CONT, 1, 4)+' '+SUBSTRING(NO_CONT, 5, 12))");
//        $this->db->limit(100, 200);
//        $this->db->order_by('pid', 'ASC');        
//        $query = $this->db->get('TRAN_OB');
//        print_r( $this->db->last_query());
//        die;

        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_tbl_entry_cont_in() {
        $database = "ptmsagate";

        $select = ' a.id_cont_in,a.eir_in,a.bon_bongkar_number,a.code_principal,a.cont_number,a.cont_date_in,a.cont_time_in,a.reff_code,
        a.vessel,a.truck_number,a.driver_name,a.block_loc,a.location,a.cont_status,a.cont_condition,b.rec_id';
        $form = 't_t_entry_cont_in as a';
        $join = array(
            array('t_t_stock as b', 'a.id_cont_in=b.id_cont_in 
                and a.code_principal=b.code_principal and a.bon_bongkar_number=b.bon_bongkar_number
                and a.cont_date_in=b.cont_date_in and a.cont_number=b.cont_number', 'inner'),
        );
        $where = array('a.rec_id' => 0, 'b.rec_id !=' => 9);

        $where_term = array(
            'a.id_cont_in', 'a.eir_in', 'a.bon_bongkar_number', 'a.code_principal', 'a.cont_number', 'a.cont_date_in', 'a.cont_time_in', 'a.reff_code',
            'a.vessel', 'a.truck_number', 'a.driver_name', 'a.block_loc', 'a.location', 'a.cont_status', 'a.cont_condition', 'b.rec_id'
        );
        $column_order = array(
            null, 'a.id_cont_in', 'a.eir_in', 'a.bon_bongkar_number', 'a.code_principal', 'a.cont_number', 'a.cont_date_in', 'a.cont_time_in', 'a.reff_code',
            'a.vessel', 'a.truck_number', 'a.driver_name', 'a.block_loc', 'a.location', 'a.cont_status', 'a.cont_condition', 'b.rec_id'
        );
        $order = array(
            'a.id_cont_in' => 'desc'
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
            $row[] = $field->id_cont_in;
            $row[] = $field->eir_in;
            $row[] = $field->bon_bongkar_number;
            $row[] = $field->code_principal;
            $row[] = $field->cont_number;
            $row[] = showdate_dmy($field->cont_date_in);
            $row[] = jam($field->cont_time_in);
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

    function c_formadd() {

        $arraydata = array('AV' => 'AV (Available)', 'DM' => 'DM (Damage)');
        $cont_condition = ComboNonDb($arraydata, 'cont_condition', 'AV', 'form-control form-control-sm');
        $data['cont_condition'] = $cont_condition;

        $arraydata = array('Full' => 'Full', 'Empty' => 'Empty');
        $cont_status = ComboNonDb($arraydata, 'cont_status', 'Full', 'form-control form-control-sm');
        $data['cont_status'] = $cont_status;

        $arraydata = array('No' => 'No', 'DS' => 'DS', 'DL' => 'DL');
        $dangers_goods = ComboNonDb($arraydata, 'dangers_goods', 'No', 'form-control form-control-sm');
        $data['dangers_goods'] = $dangers_goods;

        $data['bon_bongkar_number'] = $this->m_model->bon_bongkar_number();
        $data['eir_r_number'] = $this->m_model->eir_r_number();
        $data['id_cont_in'] = $this->m_model->id_in();

        $this->load->view('add', $data);
    }

    function c_search() {
        $nm_table = $this->input->post('nm_table');
        $param_field = $this->input->post('param_field');
        $param_value = $this->input->post('param_value');
        $search_data = $this->input->post('search_data');

        $query = " select ";
        $query.= "$search_data";
        $query.= " from ";
        $query.= "$nm_table";
        $query.= " where ";
        $query.= "$param_field" . "=" . "'$param_value'";
        $query.= " and rec_id = 0 ";

        $getvalue = getvalueb($this->ptmsagate->query($query)->result_array()[0]);

        $pesan_data = array(
            'query' => $query,
            'getvalue' => $getvalue,
        );
        echo json_encode($pesan_data);
    }

    function c_save() {
        $database = 'ptmsagate';

        $bon_bongkar_number = $this->input->post('bon_bongkar_number');
        $eir_r_number = $this->input->post('eir_r_number');
        $id_cont_in = $this->input->post('id_cont_in');
        $cont_number = strtoupper($this->input->post('cont_number'));

        $cont_number_replace = str_replace(" ", "", $cont_number) ;

        $code_principal = strtoupper($this->input->post('code_principal'));
        $name_principal = strtoupper($this->input->post('name_principal'));
        $reff_code = strtoupper($this->input->post('reff_code'));
        $reff_description = $this->input->post('reff_description');
        $cont_date_in = $this->input->post('cont_date_in');
        $cont_time_in = $this->input->post('cont_time_in');
        $vessel = $this->input->post('vessel');
        $shipper = $this->input->post('shipper');
        $truck_number = $this->input->post('truck_number');
        $driver_name = $this->input->post('driver_name');
        $cont_condition = $this->input->post('cont_condition');
        $cont_status = $this->input->post('cont_status');

        $loc_block = $this->input->post('loc_block');
        $loc_row = $this->input->post('loc_row');
        $loc_col = $this->input->post('loc_col');
        $loc_stack = $this->input->post('loc_stack');
        $location = $loc_row . ' ' . $loc_col . ' ' . $loc_stack;
        $location_gabung = $loc_block.' '.$location ;

        $ship_line_code = $this->input->post('ship_line_code');
        $ship_line_name = $this->input->post('ship_line_name');
        $invoice_in = $this->input->post('invoice_in');
        $plate = $this->input->post('plate');
        $clean_type = $this->input->post('clean_type');
        $clean_date = $this->input->post('clean_date');
        $seal_number = $this->input->post('seal_number');
        $bruto = $this->input->post('bruto');
        $no_eir = $this->input->post('no_eir');
        $tgl_eir = $this->input->post('tgl_eir');
        $bc_code = $this->input->post('bc_code');
        $bc_name = $this->input->post('bc_name');
        $dangers_goods = $this->input->post('dangers_goods');
        $notes = $this->input->post('notes');


        $a = 0;
        $data = array(
            'id_cont_in' => $id_cont_in,
            'bon_bongkar_number' => $bon_bongkar_number,
            'eir_in' => $eir_r_number,
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'cont_number' => $cont_number,
            'dangers_goods' => $dangers_goods,
            'vessel' => $vessel,
            'shipper' => $shipper,
            'truck_number' => $truck_number,
            'driver_name' => $driver_name,
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'cont_condition' => $cont_condition,
            'new_cont_condition' => $cont_condition,
            'cont_status' => $cont_status,
            'new_cont_status' => $cont_status,
            'cont_date_in' => date_db($cont_date_in),
            'cont_time_in' => $cont_time_in,
            'block_loc' => $loc_block,
            'location' => $location,
            'ship_line_code' => $ship_line_code,
            'ship_line_name' => $ship_line_name,
            'bc_code' => $bc_code,
            'bc_name' => $bc_name,
            'invoice_in' => $invoice_in,
            'plate' => $plate,
            'clean_type' => $clean_type,
            'clean_date' => $clean_date,
            'notes' => $notes,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
            'rec_id' => 0,
            'bruto' => $bruto,
            'notes' => $notes,
            'seal_number' => $seal_number,
            'no_eir' => $no_eir,
            'tgl_eir' => date_db($tgl_eir),
        );

        $hasil = $this->ptmsagate->insert('t_t_entry_cont_in', $data);
        
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
                'pesan' => 'Function Save Data Ke Table t_t_entry_cont_in Error....!!!!',
                'data' => $data,
                'queryku' => $queryku,
            );
            echo json_encode($pesan_data);
            die;
        }

        $data = array(
            'id_cont_in' => $id_cont_in,
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'cont_number' => $cont_number,
            'dangers_goods' => $dangers_goods,
            'vessel' => $vessel,
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'cont_condition' => $cont_condition,
            'cont_status' => $cont_status,
            'cont_date_in' => date_db($cont_date_in),
            'cont_time_in' => $cont_time_in,
            'bon_bongkar_number' => $bon_bongkar_number,
            'block_loc' => $loc_block,
            'location' => $location,
            'ship_line_code' => $ship_line_code,
            'ship_line_name' => $ship_line_name,
            'bc_code' => $bc_code,
            'notes' => $notes,
            'invoice_in' => $invoice_in,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
            'rec_id' => 0,
            'seal_number' => $seal_number,
            'no_eir' => $no_eir,
            'tgl_eir' => date_db($tgl_eir),
            'bruto' => $bruto,
        );

        $hasil = $this->ptmsagate->insert('t_t_stock', $data);
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
                'pesan' => 'Function Save Data Ke Table t_t_stock Error....!!!!',
                'data' => $data,
                'queryku' => $queryku,
            );
            echo json_encode($pesan_data);
            die;
        }

        $data = array(
            'eir_type' => 'I',
            'eir_number' => $eir_r_number,
            'bon_bongkar_number' => $bon_bongkar_number,
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'cont_number' => $cont_number,
            'vessel' => $vessel,
            'shipper'=>$shipper,
            'truck_number' => $truck_number,
            'driver_name'=> $driver_name,
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'cont_condition' => $cont_condition,
            'cont_status' => $cont_status,
            'cont_date_in' => date_db($cont_date_in),
            'cont_time_in' => $cont_time_in,
            'seal_number'=>$seal_number,
            'block_loc' => $loc_block,
            'location' => $location,
            'notes' => $notes,
            'created_by' => $this->session->userdata('autogate_username'),
            'created_on' => tanggal_sekarang(),
            'rec_id' => 0,
            'no_eir'=>$no_eir,
            'tgl_eir'=>date_db($tgl_eir),
            'bruto' => $bruto,
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

        $update_no_eir_in = $this->m_model->update_eir_r_number();

        $update_ob = "update TRAN_OB set FLAG_SINKRON=1 where NO_CONT='".$cont_number_replace."'" ;
        $this->db->query($update_ob);

        if($code_principal == "TPS" || $code_principal == "PJT"  || $code_principal == "LCL"){
            //update date ke database mba_tps table tps_t_plp_detail
            $cek_kontainer_tps = $this->mbatps->query("select * from tps_t_plp a inner join tps_t_plp_detail b on a.T_In_ID=b.T_In_ID 
                where a.RecID = 0 and b.RecID = 0 and b.NoKontainer='".$cont_number."' ");
            $queryku[$a++] = $this->mbatps->last_query();



            if($cek_kontainer_tps->num_rows() > 0){
                $this->mbatps->query("update  tps_t_plp_detail set TglMasuk='".date_db($cont_date_in)."',JamMasuk='".$cont_time_in."',
                    Location='".$location_gabung."',SealNumber='".$seal_number."',Principal='".$code_principal."' where RecID=0 and NoKontainer='".$cont_number."'  ");
                $queryku[$a++] = $this->mbatps->last_query();


                $this->mbatps->query("update  tps_t_plp_detail_gate_status set TglMasuk='".date_db($cont_date_in)."',Created_On='".tanggal_sekarang()."' 
                    where NoKontainer='".$cont_number."' and FlagStatus <> 9 ");
                $queryku[$a++] = $this->mbatps->last_query();

                $update = $this->mbatps->query("update  tps_t_plp_detail_status set TglMasuk='".date_db($cont_date_in)."',Created_On='".tanggal_sekarang()."' 
                    where NoKontainer='".$cont_number."' and FlagStatus <> 9  ");

            }else{
                $GateNomor = '' ;
                $r_number = $this->ptmsagate->query('select r_number from r_lock_gate')->row()->r_number;
                $GateNomor = 'Gate'.$r_number ;
                $r_number = $r_number+1;

                $r_lock_gate = "update r_lock_gate set r_number='".$r_number."' " ;
                $this->ptmsagate->query($r_lock_gate);
                $queryku[$a++] = $this->ptmsagate->last_query();

                $data = array(
                    'T_In_Detail_ID' => $GateNomor,
                    'NoKontainer' => $cont_number,
                    'FlagStatus' => 1,
                    'Created_on' => tanggal_sekarang(),
                    'Created_by' => $this->session->userdata('autogate_username'),
                    'TglMasuk' => date_db($cont_date_in),
                    'No_pos' => '',
                    'No_bc' => '',
                );

                $hasil = $this->mbatps->insert('tps_t_plp_detail_gate_status', $data);
                $queryku[$a++] = $this->mbatps->last_query();

            }
            
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Save Data Sukses..',
                'data' => $data,
                'queryku' => $queryku,
            );

            




        }
        

        echo json_encode($pesan_data);
    }

    function c_formedit() {
        
        $id_cont_in = $this->input->post('id_cont_in');
        
        $array_search = $this->m_model->table_tostring('ptmsagate', '', 't_t_entry_cont_in', '', array('id_cont_in' => $id_cont_in), '');
        $data['array_search'] = $array_search;

        

        $arraydata = array('AV' => 'AV (Available)', 'DM' => 'DM (Damage)');
        $cont_condition = ComboNonDb($arraydata, 'cont_condition', $array_search['cont_condition'], 'form-control form-control-sm');
        $data['cont_condition'] = $cont_condition;

        $arraydata = array('Full' => 'Full', 'Empty' => 'Empty');
        $cont_status = ComboNonDb($arraydata, 'cont_status',$array_search['cont_status'], 'form-control form-control-sm');
        $data['cont_status'] = $cont_status;

        $arraydata = array('No' => 'No', 'DS' => 'DS', 'DL' => 'DL');
        $dangers_goods = ComboNonDb($arraydata, 'dangers_goods',$array_search['dangers_goods'], 'form-control form-control-sm');
        $data['dangers_goods'] = $dangers_goods;

        $this->load->view('edit', $data);
    }

    function c_update() {
        
        $database = 'ptmsagate';

        $bon_bongkar_number = $this->input->post('bon_bongkar_number');
        $eir_r_number = $this->input->post('eir_r_number');
        $id_cont_in = $this->input->post('id_cont_in');
        $cont_number = strtoupper($this->input->post('cont_number'));
        $code_principal = strtoupper($this->input->post('code_principal'));
        $name_principal = strtoupper($this->input->post('name_principal'));
        $reff_code = strtoupper($this->input->post('reff_code'));
        $reff_description = $this->input->post('reff_description');
        $cont_date_in = $this->input->post('cont_date_in');
        $cont_time_in = $this->input->post('cont_time_in');
        $vessel = $this->input->post('vessel');
        $shipper = $this->input->post('shipper');
        $truck_number = $this->input->post('truck_number');
        $driver_name = $this->input->post('driver_name');
        $cont_condition = $this->input->post('cont_condition');
        $cont_status = $this->input->post('cont_status');

        $loc_block = $this->input->post('loc_block');
        $loc_row = $this->input->post('loc_row');
        $loc_col = $this->input->post('loc_col');
        $loc_stack = $this->input->post('loc_stack');
        $location = $loc_row . ' ' . $loc_col . ' ' . $loc_stack;

        $ship_line_code = $this->input->post('ship_line_code');
        $ship_line_name = $this->input->post('ship_line_name');
        $invoice_in = $this->input->post('invoice_in');
        $plate = $this->input->post('plate');
        $clean_type = $this->input->post('clean_type');
        $clean_date = $this->input->post('clean_date');
        $seal_number = $this->input->post('seal_number');
        $bruto = $this->input->post('bruto');
        $no_eir = $this->input->post('no_eir');
        $tgl_eir = $this->input->post('tgl_eir');
        $bc_code = $this->input->post('bc_code');
        $bc_name = $this->input->post('bc_name');
        $dangers_goods = $this->input->post('dangers_goods');
        $notes = $this->input->post('notes');
        
        $a = 0;
        $data = array(           
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'cont_number' => $cont_number,
            'dangers_goods' => $dangers_goods,
            'vessel' => $vessel,
            'shipper' => $shipper,
            'truck_number' => $truck_number,
            'driver_name' => $driver_name,
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'cont_condition' => $cont_condition,
            'new_cont_condition' => $cont_condition,
            'cont_status' => $cont_status,
            'new_cont_status' => $cont_status,
            'cont_date_in' => date_db($cont_date_in),
            'cont_time_in' => $cont_time_in,
            'block_loc' => $loc_block,
            'location' => $location,
            'ship_line_code' => $ship_line_code,
            'ship_line_name' => $ship_line_name,
            'bc_code' => $bc_code,
            'bc_name' => $bc_name,
            'invoice_in' => $invoice_in,
            'plate' => $plate,
            'clean_type' => $clean_type,
            'clean_date' => $clean_date,
            'notes' => $notes,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
            'bruto' => $bruto,
            'notes' => $notes,
            'seal_number' => $seal_number,
            'no_eir' => $no_eir,
            'tgl_eir' => date_db($tgl_eir),
        );
        
        $where = array(
            'bon_bongkar_number' => $bon_bongkar_number,
        );
        
        $hasil = $this->ptmsagate->update('t_t_entry_cont_in', $data, $where);
        $queryku[$a++] = $this->ptmsagate->last_query();
        
        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya', 'pesan' => 'Update Data Sukses..', 'queryku' => $queryku,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_t_entry_cont_in Error....!!!!', 'queryku' => $queryku,
            );
            echo json_encode($pesan_data);
            die;
        }
        
        $data = array(
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'cont_number' => $cont_number,
            'dangers_goods' => $dangers_goods,
            'vessel' => $vessel,
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'cont_condition' => $cont_condition,
            'cont_status' => $cont_status,
            'cont_date_in' => date_db($cont_date_in),
            'cont_time_in' => $cont_time_in,
            'block_loc' => $loc_block,
            'location' => $location,
            'ship_line_code' => $ship_line_code,
            'ship_line_name' => $ship_line_name,
            'bc_code' => $bc_code,
            'notes' => $notes,
            'invoice_in' => $invoice_in,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
            'seal_number' => $seal_number,
            'no_eir' => $no_eir,
            'tgl_eir' => date_db($tgl_eir),
            'bruto' => $bruto,
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
        
        $data = array(
            'code_principal' => $code_principal,
            'name_principal' => $name_principal,
            'cont_number' => $cont_number,
            'vessel' => $vessel,
            'shipper'=>$shipper,
            'truck_number' => $truck_number,
            'driver_name'=> $driver_name,
            'reff_code' => $reff_code,
            'reff_description' => $reff_description,
            'cont_condition' => $cont_condition,
            'cont_status' => $cont_status,
            'cont_date_in' => date_db($cont_date_in),
            'cont_time_in' => $cont_time_in,
            'seal_number'=>$seal_number,
            'block_loc' => $loc_block,
            'location' => $location,
            'notes' => $notes,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
            'rec_id' => 0,
            'no_eir'=>$no_eir,
            'tgl_eir'=>date_db($tgl_eir),
            'bruto' => $bruto,
        );
        $hasil = $this->ptmsagate->update('t_eir', $data, $where);
        $queryku[$a++] = $this->ptmsagate->last_query();
        
        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya', 'pesan' => 'Update Data Sukses..', 'queryku' => $queryku,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak', 'pesan' => 'Function Update Data Ke Table t_eir Error....!!!!', 'queryku' => $queryku,
            );
            echo json_encode($pesan_data);
            die;
        }

        $location_gabung = $loc_block.' '.$location ;

        if($code_principal == "TPS" || $code_principal == "PJT" || $code_principal == "LCL"){
            //update date ke database mba_tps table tps_t_plp_detail
            $cek_kontainer_tps = $this->mbatps->query("select * from tps_t_plp a inner join tps_t_plp_detail b on a.T_In_ID=b.T_In_ID 
                where a.RecID = 0 and b.RecID = 0 and b.NoKontainer='".$cont_number."' ");
            $queryku[$a++] = $this->mbatps->last_query();



            if($cek_kontainer_tps->num_rows() > 0){
                $this->mbatps->query("update  tps_t_plp_detail set TglMasuk='".date_db($cont_date_in)."',JamMasuk='".$cont_time_in."',
                    Location='".$location_gabung."',SealNumber='".$seal_number."',Principal='".$code_principal."' where RecID=0 and NoKontainer='".$cont_number."'  ");
                $queryku[$a++] = $this->mbatps->last_query();


                $this->mbatps->query("update  tps_t_plp_detail_gate_status set TglMasuk='".date_db($cont_date_in)."',Created_On='".tanggal_sekarang()."' 
                    where NoKontainer='".$cont_number."' and FlagStatus <> 9  ");
                $queryku[$a++] = $this->mbatps->last_query();

            }else{
                $GateNomor = '' ;
                $r_number = $this->ptmsagate->query('select r_number from r_lock_gate')->row()->r_number;
                $GateNomor = 'Gate'.$r_number ;
                $r_number = $r_number+1;

                $r_lock_gate = "update r_lock_gate set r_number='".$r_number."' " ;
                $this->ptmsagate->query($r_lock_gate);
                $queryku[$a++] = $this->ptmsagate->last_query();

                $data = array(
                    'T_In_Detail_ID' => $GateNomor,
                    'NoKontainer' => $cont_number,
                    'FlagStatus' => 1,
                    'Created_on' => tanggal_sekarang(),
                    'Created_by' => $this->session->userdata('autogate_username'),
                    'TglMasuk' => date_db($cont_date_in),
                    'No_pos' => '',
                    'No_bc' => '',
                );

                $hasil = $this->mbatps->insert('tps_t_plp_detail_gate_status', $data);
                $queryku[$a++] = $this->mbatps->last_query();

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
                    'WK_INOUT' => date_db($cont_date_in).' '.$cont_time_in,
                    'NO_SEGEL' => $seal_number,
                    'BRUTO' => $bruto,
                    'KD_TIMBUN' => $location_gabung,
                    'NO_POL' => $truck_number,
                    'UK_CONT' => $uk_cont,
                    'FL_CONT_KOSONG' => $isiKontainer,
                    'NO_IJIN_TPS' => $no_eir,
                    'TGL_IJIN_TPS' => date_db($tgl_eir),
                );


                $hasil = $this->db_tpsonline->update('tbl_request_plp_in_container', $dataupdate, array('REF_NUMBER' => $REF_NUMBER_FCL_IN));
                $queryku[$a++] = $this->db_tpsonline->last_query();
            }

            $T_IN_ID = $this->m_model->getvalue('db_tpsonline','T_IN_ID', 'tbl_respon_plp_petikemas_detail', array('ID_CONT_IN' => $id_cont_in)) ;
            $T_IN_DETAIL_ID = $this->m_model->getvalue('db_tpsonline','T_IN_DETAIL_ID', 'tbl_respon_plp_petikemas_detail', array('ID_CONT_IN' => $id_cont_in)) ;

            if($T_IN_ID != "" && $T_IN_DETAIL_ID != ""){
                $dataupdate = array(
                    'TglMasuk' => date_db($cont_date_in),
                    'JamMasuk' => $cont_time_in,
                    'Location' => $location_gabung,
                    'SealNumber' => $seal_number,
                    'principal' => $code_principal,
                    'KdCtr' => $reff_code,
                );


                $hasil = $this->mbatps->update('tps_t_plp_detail', $dataupdate, array('T_IN_ID' => $T_IN_ID,'T_IN_DETAIL_ID' => $T_IN_DETAIL_ID));
                $queryku[$a++] = $this->mbatps->last_query();
            }

            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Save Data Sukses..',
                'data' => $data,
                'queryku' => $queryku,
            );
            
        }

        
        echo json_encode($pesan_data);
    }

    function c_delete() {
        $database = 'ptmsagate';
        
        $bon_bongkar_number = $this->input->post('bon_bongkar_number');
        $a = 0;
        $where = array(
            'bon_bongkar_number' => $bon_bongkar_number
        );

        $data = array(
            'rec_id' => 9,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->ptmsagate->update('t_t_entry_cont_in', $data, $where);
        $queryku[$a++] = $this->ptmsagate->last_query();        
        
        if ($hasil >= 1) {
            $pesan_data = array('msg' => 'Ya','pesan' => 'Delete Data Sukses..','queryku' => $queryku);
        } else {
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Function Delete Data Ke Table t_t_entry_cont_in Error....!!!!','queryku' => $queryku);
            echo json_encode($pesan_data);die;
        }
        
        $hasil = $this->ptmsagate->update('t_t_stock', $data, $where);
        $queryku[$a++] = $this->ptmsagate->last_query();        
        
        if ($hasil >= 1) {
            $pesan_data = array('msg' => 'Ya','pesan' => 'Delete Data Sukses..','queryku' => $queryku);
        } else {
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Function Delete Data Ke Table t_t_stock Error....!!!!','queryku' => $queryku);
            echo json_encode($pesan_data);die;
        }
        
        $hasil = $this->ptmsagate->update('t_eir', $data, $where);
        $queryku[$a++] = $this->ptmsagate->last_query();        
        
        if ($hasil >= 1) {
            $pesan_data = array('msg' => 'Ya','pesan' => 'Delete Data Sukses..','queryku' => $queryku);
        } else {
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Function Delete Data Ke Table t_eir Error....!!!!','queryku' => $queryku);
            echo json_encode($pesan_data);die;
        }

        echo json_encode($pesan_data);
    }

    function c_print() {
        
        include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");
        
        $eir_in = $_GET['data'];
        
        $PHPJasperXML = new PHPJasperXML("en","TCPDF"); //if export excel, can use PHPJasperXML("en","XLS OR XLSX"); 
//        $PHPJasperXML->debugsql=true; 
        $PHPJasperXML->arrayParameter = array('eir'=>"'I'",'bonprint'=>$eir_in);
//        $PHPJasperXML->debugsql=true; 
        $path = APPPATH . 'modules/report_jasper/report_entry_cont_in.jrxml';
        
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

//$database = "jobpjt";
//
//        $html = ob_get_clean();
//
//        $nojob = $_GET['data'];
//        $field_Search = "nojob,tgljob,pibk,tglpibk,nmimportir,nocontainer,size,asalbarang,status,aktif";
//        $table_name = 'pjt_check_container';
//        $orderby = 'nojob asc';
//        $where = array(
//            'nojob' => $nojob,
//            'aktif !=' => 9,
//        );
//        $limit = 1;
//        $array_data = $this->m_model->table_tostring($database, $field_Search, $table_name, $orderby, $where, $limit);
//
//        $data = array(
//            'nojob' => $array_data['nojob'],
//            'tgljob' => showdate_dmybc($array_data['tgljob']),
//            'tglberlaku' => showdate_dmybc(date('Y-m-d', strtotime('+2 days', strtotime($array_data['tgljob'])))),
//            'pibk' => $array_data['pibk'],
//            'tglpibk' => showdate_dmybc($array_data['tglpibk']),
//            'nmimportir' => $array_data['nmimportir'],
//            'nocontainer' => $array_data['nocontainer'],
//            'size' => $array_data['size'],
//            'asalbarang' => $array_data['asalbarang'],
//        );
//
//        $html = $this->load->view('print', $data, true);
//        print_r($html);
//        
////        $this->pdf->loadHtml($html); 
////        $customPaper = array(0,0,612.00,396.00);
////        $this->pdf->set_paper($customPaper);
////        $this->pdf->render();
////        $this->pdf->stream("Print_Job.pdf", array("Attachment" => 0));
