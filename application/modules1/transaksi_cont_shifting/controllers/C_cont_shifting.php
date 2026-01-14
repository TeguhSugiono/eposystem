<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");

class C_cont_shifting extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);           
    }

    function index() {


        // $id_cont_in = 61995 ;
        // $array_search_stock = $this->ptmsagate->query("select * from t_t_stock where id_cont_in='".$id_cont_in."' ")->result_array();
        // $array_search_in = $this->ptmsagate->query("select * from t_t_entry_cont_in where id_cont_in='".$id_cont_in."' ")->result_array();
        // echo '<pre>' ;
        // print_r($array_search_stock) ;
        // print_r($array_search_in) ;
        // echo '</pre>' ;
        // die;
        //echo json_encode($array_search);

        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_tbl_cont_shifting() {
        $database = "ptmsagate";

        $select = ' a.id_cont_shifting,a.cont_number,a.cont_date_in,a.cont_time_in,a.old_location,a.new_location, a.code_principal,a.name_principal,a.vessel,
        a.reff_code,a.reff_description,a.cont_condition,a.cont_status,a.date_shifting ';
        $form = 't_t_cont_shifting as a';
        //INNER JOIN (SELECT MAX(z.id_cont_shifting) id_cont_shifting FROM t_t_cont_shifting as z GROUP BY z.cont_number) as Y
        //on a.id_cont_shifting = Y.id_cont_shifting

        $join = array(
            array('(SELECT MAX(z.id_cont_shifting) id_cont_shifting FROM t_t_cont_shifting as z GROUP BY z.cont_number) as Y','a.id_cont_shifting = Y.id_cont_shifting','inner')
        );
        $where = array('a.rec_id' => 0);

        $where_term = array(
            'a.id_cont_shifting','a.cont_number','a.cont_date_in','a.cont_time_in','a.old_location','a.new_location','a.code_principal','a.name_principal','a.vessel',
            'a.reff_code','a.reff_description','a.cont_condition','a.cont_status','a.date_shifting'
        );
        $column_order = array(
            null, 'a.id_cont_shifting','a.cont_number','a.cont_date_in','a.cont_time_in','a.old_location','a.new_location','a.code_principal','a.name_principal','a.vessel',
            'a.reff_code','a.reff_description','a.cont_condition','a.cont_status','a.date_shifting'
        );
        $order = array(
            'a.id_cont_shifting' => 'desc'
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
            $row[] = $field->id_cont_shifting;
            $row[] = $field->cont_number;
            $row[] = $field->cont_date_in;
            $row[] = $field->cont_time_in;
            $row[] = $field->old_location;
            $row[] = $field->new_location;
            $row[] = $field->code_principal;
            $row[] = $field->name_principal;
            $row[] = $field->vessel;
            $row[] = $field->reff_code;
            $row[] = $field->reff_description;
            $row[] = $field->cont_condition;
            $row[] = $field->cont_status;            
            $row[] = $field->date_shifting;
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


        $arraydata = array('Full' => 'Full', 'Empty' => 'Empty');
        $cont_status = ComboNonDb($arraydata, 'cont_status', 'Full', 'form-control form-control-sm');
        $data['cont_status'] = $cont_status;


        $arraydata = array('Shifting' => 'Shifting', 'Stripping' => 'Stripping','Stuffing' => 'Stuffing');
        $change_description = ComboNonDb($arraydata, 'change_description', 'Shifting', 'form-control form-control-sm');
        $data['change_description'] = $change_description;

        $arraydata = $this->ptmsagate->query("SELECT id_cont_in,cont_number FROM t_t_stock where rec_id=0 order by cont_number desc ")->result_array();
        array_push($arraydata, array('id_cont_in' => '' , 'cont_number' => 'Pilih Container'));
        $createcombo = array(
            'data' => array_reverse($arraydata),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'id_cont_in', 'class' => 'selectpicker'),
        );
        $data['id_cont_in'] = ComboDb($createcombo);


        $this->load->view('add',$data);
    }

    
    function c_save() {
        $database = 'ptmsagate';

        $id_cont_in = $this->input->post('id_cont_in');
        $date_shifting = $this->input->post('date_shifting');
        $date_stripping = $this->input->post('date_stripping');
        $date_stuffing = $this->input->post('date_stuffing');
        $cont_status = $this->input->post('cont_status');
        $change_description = $this->input->post('change_description');

        $seal_number = $this->input->post('seal_number'); 
        $old_seal_number = $this->input->post('old_seal_number'); 


        if($date_stripping != ""){
            $date_change = $date_stripping ;
        }else if($date_stuffing != ""){
            $date_change = $date_stuffing ;
        }else{
            $date_change = $date_shifting ;
        }

        $loc_block_old = $this->input->post('loc_block_old');
        $loc_row_old = $this->input->post('loc_row_old');
        $loc_col_old = $this->input->post('loc_col_old');
        $loc_stack_old = $this->input->post('loc_stack_old');
        //$location_old = $loc_row_old . ' ' . $loc_col_old . ' ' . $loc_stack_old;
        $location_gabung_old = $loc_block_old.' '.$loc_row_old . ' ' . $loc_col_old . ' ' . $loc_stack_old ;

        $loc_block = $this->input->post('loc_block');
        $loc_row = $this->input->post('loc_row');
        $loc_col = $this->input->post('loc_col');
        $loc_stack = $this->input->post('loc_stack');
        $location_gabung = $loc_block.' '.$loc_row . ' ' . $loc_col . ' ' . $loc_stack ;

        $array_search = $this->$database->query("select * from t_t_stock where id_cont_in='".$id_cont_in."' ")->result_array();

        $no=0;
        $data = array(
            'id_cont_in'=>  $id_cont_in  ,
            'code_principal'=>  $array_search[0]['code_principal'] ,
            'name_principal'=>  $array_search[0]['name_principal']  ,
            'cont_number'=>  $array_search[0]['cont_number'] ,
            'vessel'=>  $array_search[0]['vessel']  ,
            'dangers_goods'=>   $array_search[0]['dangers_goods']  ,
            'reff_code'=>   $array_search[0]['reff_code']  ,
            'reff_description'=>    $array_search[0]['reff_description']  ,
            'cont_condition'=>  $array_search[0]['cont_condition']  ,
            'cont_status'=> $array_search[0]['cont_status']  ,
            'cont_date_in'=> $array_search[0]['cont_date_in']  ,
            'cont_time_in'=>  $array_search[0]['cont_time_in']  ,
            'old_location'=>  $location_gabung_old ,
            'date_shifting'=> date_db($date_shifting) ,
            'new_cont_status'=> $cont_status  ,
            'change_description'=>  $change_description  ,
            'date_change'=> date_db($date_change)  ,
            'date_stripping'=>  date_db($date_stripping)  ,
            'date_stuffing'=>   date_db($date_stuffing)  ,
            'new_location'=>    $location_gabung  ,
            'first_shift_loc'=> $location_gabung  ,
            'bc_code'=> $array_search[0]['bc_code']  ,
            'bon_bongkar_number'=>  $array_search[0]['bon_bongkar_number']  ,
            'created_by'=> $this->session->userdata('autogate_username')  ,
            'created_on'=>  tanggal_sekarang()  ,
            'rec_id'=>  0  ,
            'seal_number' => $seal_number,
            'old_seal_number' => $old_seal_number,
        );
        $hasil = $this->ptmsagate->insert('t_t_cont_shifting', $data);
        $query[$no++] = $this->ptmsagate->last_query(); 

        if ($hasil >= 1) {
        }else{
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Save Data Ke Table t_t_cont_shifting Error....!!!!',
                'query' => $query,
            );
            echo json_encode($pesan_data);die;
        }


        $dataupdate = array(
            'date_shifting' => date_db($date_shifting),
            'cont_status' => $cont_status,
            'date_stripping' => date_db($date_stripping),
            'date_stuffing' => date_db($date_stuffing) ,
            'block_loc' => $loc_block,
            'location' => $loc_row.' '.$loc_col.' '.$loc_stack,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
            'seal_number' => $seal_number,
            'old_seal_number' => $old_seal_number,
        );
        $where = array(
            'id_cont_in' => $id_cont_in
        );

        $hasil = $this->ptmsagate->update('t_t_stock', $dataupdate, $where);
        $query[$no++] = $this->ptmsagate->last_query();
        if ($hasil >= 1) {
        }else{
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Update Data Ke Table t_t_stock Error....!!!!',
                'query' => $query,
            );
            echo json_encode($pesan_data);die;
        }


        $dataupdate = array(
            'new_cont_status' => $cont_status,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
            'seal_number' => $seal_number,
            'old_seal_number' => $old_seal_number,
        );
        $hasil = $this->ptmsagate->update('t_t_entry_cont_in', $dataupdate, $where);
        $query[$no++] = $this->ptmsagate->last_query();
        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Simpan Data Sukses...',
                'query' => $query,
            );
        }else{
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Update Data Ke Table t_t_entry_cont_in Error....!!!!',
                'query' => $query,
            );
            echo json_encode($pesan_data);die;
        }


        echo json_encode($pesan_data);

    }

    function c_search() {
        $id_cont_in = $this->input->post('id_cont_in');
        $array_search = $this->ptmsagate->query("select * from t_t_stock where id_cont_in='".$id_cont_in."' ")->result_array();
        echo json_encode($array_search);
    }


    function c_formedit() {

        $id_cont_shifting = $this->input->post('id_cont_shifting');
        $data['id_cont_shifting'] = $id_cont_shifting ;
        $id_cont_in = $this->ptmsagate->query("select id_cont_in from t_t_cont_shifting where id_cont_shifting='".$id_cont_shifting."' ")->row()->id_cont_in;
        $data['array_search'] = $this->ptmsagate->query("select * from t_t_stock where id_cont_in='".$id_cont_in."' ")->result_array();


        $arraydata = array('Full' => 'Full', 'Empty' => 'Empty');
        $cont_status = ComboNonDb($arraydata, 'cont_status', $data['array_search']['0']['cont_status'], 'form-control form-control-sm');
        $data['cont_status'] = $cont_status;

        $change_description = $this->ptmsagate->query("select change_description from t_t_cont_shifting where id_cont_shifting='".$id_cont_shifting."' ")->row()->change_description;
        $arraydata = array('Shifting' => 'Shifting', 'Stripping' => 'Stripping','Stuffing' => 'Stuffing');
        $change_description = ComboNonDb($arraydata, 'change_description', $change_description, 'form-control form-control-sm');
        $data['change_description'] = $change_description;




        $this->load->view('edit',$data);
    }


    function c_update(){
        $database = 'ptmsagate';

        $id_cont_shifting = $this->input->post('id_cont_shifting');
        $id_cont_in = $this->input->post('id_cont_in');       
        $change_description = $this->input->post('change_description');
        $cont_status = $this->input->post('cont_status');
        $date_shifting = $this->input->post('date_shifting');
        $date_stripping = $this->input->post('date_stripping');
        $date_stuffing = $this->input->post('date_stuffing');

        $seal_number = $this->input->post('seal_number'); 
        $xseal_number = $this->input->post('xseal_number');
        $old_seal_number = $this->input->post('old_seal_number'); 

        if($seal_number != $xseal_number){
            $old_seal_number = $xseal_number ;
        }

        if($date_stripping != ""){
            $date_change = $date_stripping ;
        }else if($date_stuffing != ""){
            $date_change = $date_stuffing ;
        }else{
            $date_change = $date_shifting ;
        }

        $loc_block_old = $this->input->post('loc_block_old');
        $loc_row_old = $this->input->post('loc_row_old');
        $loc_col_old = $this->input->post('loc_col_old');
        $loc_stack_old = $this->input->post('loc_stack_old');
        $location_gabung_old = $loc_block_old.' '.$loc_row_old . ' ' . $loc_col_old . ' ' . $loc_stack_old ;

        $loc_block = $this->input->post('loc_block');
        $loc_row = $this->input->post('loc_row');
        $loc_col = $this->input->post('loc_col');
        $loc_stack = $this->input->post('loc_stack');
        $location_gabung = $loc_block.' '.$loc_row . ' ' . $loc_col . ' ' . $loc_stack ;

        $array_search = $this->$database->query("select * from t_t_stock where id_cont_in='".$id_cont_in."' ")->result_array();

        $first_shift_loc = $this->$database->query("select first_shift_loc from t_t_cont_shifting where id_cont_shifting='".$id_cont_shifting."' ")->row()->first_shift_loc;

        $no=0;
        $data = array(
            'cont_status' => $array_search[0]['cont_status'],
            'old_location' => $location_gabung_old,
            'date_shifting' => date_db($date_shifting),
            'new_cont_status' => $cont_status,
            'new_location' => $location_gabung,
            'first_shift_loc' => $first_shift_loc,
            'change_description' => $change_description,
            'date_change' => date_db($date_change),
            'date_stripping' => date_db($date_stripping),
            'date_stuffing' => date_db($date_stuffing),
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
            'seal_number' => $seal_number,
            'old_seal_number' => $old_seal_number,
        );

        $where = array(
            'id_cont_shifting' => $id_cont_shifting
        );

        $hasil = $this->ptmsagate->update('t_t_cont_shifting', $data, $where);
        $query[$no++] = $this->ptmsagate->last_query();
        if ($hasil >= 1) {
        }else{
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Update Data Ke Table t_t_cont_shifting Error....!!!!',
                'query' => $query,
            );
            echo json_encode($pesan_data);die;
        }

        $dataupdate = array(
            'date_shifting' => date_db($date_shifting),
            'cont_status' => $cont_status,
            'date_stripping' => date_db($date_stripping),
            'date_stuffing' => date_db($date_stuffing) ,
            'block_loc' => $loc_block,
            'location' => $loc_row.' '.$loc_col.' '.$loc_stack,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
            'seal_number' => $seal_number,
            'old_seal_number' => $old_seal_number,
        );
        $where = array(
            'id_cont_in' => $id_cont_in
        );

        $hasil = $this->ptmsagate->update('t_t_stock', $dataupdate, $where);
        $query[$no++] = $this->ptmsagate->last_query();
        if ($hasil >= 1) {
        }else{
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Update Data Ke Table t_t_stock Error....!!!!',
                'query' => $query,
            );
            echo json_encode($pesan_data);die;
        }


        $dataupdate = array(
            'new_cont_status' => $cont_status,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
            'seal_number' => $seal_number,
            'old_seal_number' => $old_seal_number,
        );
        $hasil = $this->ptmsagate->update('t_t_entry_cont_in', $dataupdate, $where);
        $query[$no++] = $this->ptmsagate->last_query();
        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Simpan Data Sukses...',
                'query' => $query,
            );
        }else{
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Update Data Ke Table t_t_entry_cont_in Error....!!!!',
                'query' => $query,
            );
            echo json_encode($pesan_data);die;
        }


        echo json_encode($pesan_data);

    }


    function c_delete(){
        $database = 'ptmsagate';

        $id_cont_shifting = $this->input->post('id_cont_shifting');
        $id_cont_in = $this->ptmsagate->query("SELECT id_cont_in FROM t_t_cont_shifting where id_cont_shifting='".$id_cont_shifting."' ")->row()->id_cont_in;

        $cekdata = $this->ptmsagate->query("select id_cont_in from t_t_stock where id_cont_in='".$id_cont_in."' and rec_id=1 ")->row()->id_cont_in;
        if($cekdata != ""){
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Tidak Bisa Hapus, Container Ini Sudah Keluar....!!!!');
            echo json_encode($pesan_data);die;
        }


        $no = 0;
        $where = array(
            'id_cont_shifting' => $id_cont_shifting
        );

        $data = array(
            'rec_id' => 9,
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->ptmsagate->update('t_t_cont_shifting', $data, $where);
        $queryku[$no++] = $this->ptmsagate->last_query();  

        if ($hasil >= 1) {
        } else {
            $pesan_data = array('msg' => 'Tidak','pesan' => 'Function Delete Data Ke Table t_t_cont_shifting Error....!!!!','queryku' => $queryku);
            echo json_encode($pesan_data);die;
        }


        
        $id_cont_shifting_before = $this->ptmsagate->query("SELECT id_cont_shifting FROM t_t_cont_shifting where id_cont_in='".$id_cont_in."' 
            and rec_id=0 order by id_cont_shifting desc limit 1 ")->row()->id_cont_shifting;
        $array_search = $this->ptmsagate->query("select * from t_t_cont_shifting where id_cont_shifting='".$id_cont_shifting_before."' ")->result_array();
        //value="<?= explode(' ',$array_search['location'])[0]; 
        
        $dataupdate = array(
            'date_shifting' => date_db($array_search[0]['date_shifting']),
            'cont_status' => $array_search[0]['cont_status'],
            'date_stripping' => date_db($array_search[0]['date_stripping']),
            'date_stuffing' => date_db($array_search[0]['date_stuffing']),
            'block_loc' => explode(' ',$array_search[0]['new_location'])[0],
            'location' => explode(' ',$array_search[0]['new_location'])[1].' '.explode(' ',$array_search[0]['new_location'])[2].' '.explode(' ',$array_search[0]['new_location'])[3],
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $where = array(
            'id_cont_in' => $id_cont_in
        );
        
        $hasil = $this->ptmsagate->update('t_t_stock', $dataupdate, $where);
        $query[$no++] = $this->ptmsagate->last_query();
        if ($hasil >= 1) {
        }else{
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Update Data Ke Table t_t_stock Error....!!!!',
                'query' => $query,
            );
            echo json_encode($pesan_data);die;
        }


        $dataupdate = array(
            'new_cont_status' => $array_search[0]['cont_status'],
            'edited_by' => $this->session->userdata('autogate_username'),
            'edited_on' => tanggal_sekarang(),
        );
        $hasil = $this->ptmsagate->update('t_t_entry_cont_in', $dataupdate, $where);
        $query[$no++] = $this->ptmsagate->last_query();
        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Simpan Data Sukses...',
                'query' => $query,
            );
        }else{
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Update Data Ke Table t_t_entry_cont_in Error....!!!!',
                'query' => $query,
            );
            echo json_encode($pesan_data);die;
        }

        echo json_encode($dataupdate);

    }

}

