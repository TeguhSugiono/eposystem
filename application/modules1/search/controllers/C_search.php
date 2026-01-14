<?php

class C_search extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->jobpjt = $this->load->database('jobpjt', TRUE);
        $this->mbatps = $this->load->database('mbatps', TRUE);
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);
        $this->ptmsadbo = $this->load->database('ptmsadbo', TRUE);
        $this->tpsonline = $this->load->database('tpsonline', TRUE);
    }

    function index() {

        $param_form = $this->input->post('param_form');
        $database = $this->input->post('param_db');
        $param_data = ($this->input->post('param_data') == '' ? '' : $this->input->post('param_data')) ;
        
        $array_data = $this->judul_table($param_form) ;
        $judul_table = $this->m_model->custome_to_array1($array_data);

        $dataku = array(
            'param_form' => $param_form,
            'param_db'    => $database,
            'judul_table'   => $judul_table,
            'param_data' => $param_data,
        );

        $this->load->view('view', $dataku);
    }

    function judul_table($param_form = '') {
        if ($param_form == 'search_nmimportir') {
            $field = ['Id','Nama Importir'];
        }else if($param_form == 'search_container_tpsonline'){
            $field = ['Id','Container No'];
        }else if($param_form == 'search_no_transaksi'){
            $field = ['Id','No Container','No Transaksi'];
        }else if($param_form == 'search_container_stock'){
            $field = ['Id','No Container'];
        }
        return json_encode($field);
    }

    function c_table_search() {
        $param_form = $this->input->post('param_form');
        $database = $this->input->post('param_db');        
        $param_data = $this->input->post('param_data');    
        
        if ($param_form == 'search_nmimportir') {

            $select = 'nojob,nmimportir';
            $form = 'pjt_check_container';
            $join = array();
            $where = array('aktif' => 0,'nmimportir !=' => NULL);

            $where_term = array(
                'nojob', 'nmimportir'
            );
            $column_order = array(
                'nojob', 'nmimportir'
            );
            $order = array(
                'nojob' => 'desc'
            );

            $group = array('nmimportir');

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

                $row[] = $field->nojob;
                $row[] = $field->nmimportir;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->m_model->count_all($database, $array_table),
                "recordsFiltered" => $this->m_model->count_filtered($database, $array_table),
                "data" => $data,
            );

            echo json_encode($output);
            
        }else if($param_form == 'search_container_tpsonline'){

            $select = "pid,NO_CONT";
            $form = 'TRAN_OB';
            $join = array();
            $where = array('FLAG_SINKRON' => 0);

            $where_term = array(
                'pid', "(SUBSTRING(NO_CONT,1,4)+' '+SUBSTRING(NO_CONT,5,7))"
            );
            $column_order = array(
                'pid', 'NO_CONT'
            );
            $order = array(
                'pid' => 'desc'
            );

            $group = '';

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

                $row[] = $field->pid;
                $row[] = $field->NO_CONT;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->m_model->count_all($database, $array_table),
                "recordsFiltered" => $this->m_model->count_filtered($database, $array_table),
                "data" => $data,
            );

            echo json_encode($output);

        }else if($param_form == 'search_no_transaksi'){

            $reff_code = $this->ptmsagate->query("SELECT reff_code FROM t_t_entry_do_cont_out where rec_id=0 and id_entry_do='".$param_data."' ")->row()->reff_code;
            $do_number = $this->ptmsagate->query("SELECT do_number FROM t_t_entry_do_cont_out where rec_id=0 and id_entry_do='".$param_data."' ")->row()->do_number;


            $cont_number = $this->ptmsagate->query("select cont_number from t_t_entry_cont_out 
                where do_number='".$do_number."' and reff_code='".$reff_code."' and rec_id=0 ")->result_array();

            $cont_number = $this->m_model->array_one_rows($cont_number,'cont_number');

            $select = 'Do_Number,Cont_Number,No_Transaksi';
            $form = 'tps_t_plp_do as a';
            $join = array(
                array('tps_t_plp_detail as b','a.T_In_Detail_ID=b.T_In_Detail_ID','inner')
            );
            $where = array('FLAG_SINKRON' => 1,'Do_Number' => $do_number,'KdCtr' => $reff_code);

            $where_not_in = array();
            if(count((array) $cont_number) > 0){                
                //$where_not_in = array('field' => array('Cont_Number','No_Transaksi'), 'value' => array($cont_number,array('20001'))) ;
                $where_not_in = array('field' => array('Cont_Number'), 'value' => array($cont_number)) ;                
            }

            $where_term = array(
                'Do_Number', 'Cont_Number','No_Transaksi'
            );
            $column_order = array(
                'Do_Number', 'Cont_Number','No_Transaksi'
            );
            $order = array(
                'Do_Number' => 'desc'
            );

            $group = array('Cont_Number');

            $array_table = array(
                'select' => $select,
                'form' => $form,
                'join' => $join,
                'where' => $where,
                'where_like' => array(),
                'where_in' => array(),
                'where_not_in' => $where_not_in,
                'where_term' => $where_term,
                'column_order' => $column_order,
                'group' => $group,
                'order' => $order,
            );

            // print_r($array_table);
            // die;

            $list = $this->m_model->get_datatables($database, $array_table);
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $field) {
                $no++;
                $row = array();

                $row[] = $field->Do_Number;
                $row[] = $field->Cont_Number;
                $row[] = $field->No_Transaksi;
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->m_model->count_all($database, $array_table),
                "recordsFiltered" => $this->m_model->count_filtered($database, $array_table),
                "data" => $data,
            );

            echo json_encode($output);

        }else if($param_form == 'search_container_stock'){

            $reff_code = $this->ptmsagate->query("SELECT reff_code FROM t_t_entry_do_cont_out where rec_id=0 and id_entry_do='".$param_data."' ")->row()->reff_code;
            //$do_number = $this->ptmsagate->query("SELECT do_number FROM t_t_entry_do_cont_out where rec_id=0 and id_entry_do='".$param_data."' ")->row()->do_number;

            $select = 'id_cont_in,cont_number';
            $form = 't_t_stock';
            $join = array();
            $where = array('rec_id' => 0,'reff_code' => $reff_code);//'Do_Number' => $param_data

            $where_term = array(
                'id_cont_in', 'cont_number'
            );
            $column_order = array(
                'id_cont_in', 'cont_number'
            );
            $order = array(
                'cont_number' => 'asc'
            );

            $group = array('Cont_Number');

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

                $row[] = $field->id_cont_in;
                $row[] = $field->cont_number;
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

    }
    
    function c_getdata(){        
        $param_form = $this->input->post('param_form');
        $param_db = $this->input->post('param_db');      
        
        if($param_form == 'search_container_tpsonline'){

            $pid = $this->input->post('pid');
            
            $array_data = $this->m_model->table_tostring($param_db, '', 'TRAN_OB', '', array('pid' => $pid), '');
            
            if($array_data['GUDANG_TUJUAN'] == "CMBA"){
                $code_principal = 'TPS' ;              
            }else if($array_data['GUDANG_TUJUAN'] == "GMBA" && $array_data['JNS_CONT'] == "F"){
                $code_principal = 'PJT' ;
            }else if($array_data['GUDANG_TUJUAN'] == "GMBA" && $array_data['JNS_CONT'] == ""){
                $code_principal = 'LCL' ;
            }else{
                $code_principal = 'TPS' ;   
            }
            $name_principal = getvalue($this->ptmsagate->query('select name_principal from t_m_principal where rec_id=0 and  code_principal="'.$code_principal.'" ')->result_array()[0]);
            
            $array_data = array_merge($array_data,array('code_principal' => $code_principal));
            $array_data = array_merge($array_data,array('name_principal' => $name_principal));
            
            $pesan_data = array(
                'msg' => 'Ya',
                'array_data' => $array_data,
            );
            echo json_encode($pesan_data);

        }else if($param_form == 'search_no_transaksi'){

            $cont_number = $this->input->post('cont_number');
            $Do_Number = $this->input->post('Do_Number');
            $No_Transaksi = $this->input->post('No_Transaksi');

            $this->mbatps->limit(1);
            $this->mbatps->select('Inv_Number');
            $Inv_Number = $this->mbatps->get_where('tps_t_plp_do',array('Do_Number' => $Do_Number))->row()->Inv_Number;

            if (strpos($Inv_Number, 'TPP') !== false) {
                //TPP
                $query = "  SELECT * from ptmsa_dbo.tpp_t_bap_detail a 
                INNER JOIN mba_tps.tps_t_plp_do b on a.T_In_Detail_ID=b.T_In_Detail_ID 
                where a.RecID<>9 and No_Transaksi='".$No_Transaksi."' " ;


                $datakontainer = $this->ptmsadbo->query($query)->result_array();      
                $cont_date_in = '' ;
                $cont_number = '' ;
                $array_data = array();
                $loc_row = '' ;
                $loc_col = '' ;
                $loc_stack = '' ;
                $shipper = '' ;

                foreach($datakontainer as $row){
                    $cont_date_in = date_db($row['TglMasuk']);
                    $cont_number = substr($row['NoKontainer'], 0,4)." ".substr($row['NoKontainer'], 4) ;

                    $array_data = $this->m_model->table_tostring($param_db,'*,DATE_FORMAT(cont_date_in,"%d-%m-%Y") as "cont_date_in2"','t_t_stock','',array('cont_number'=>$cont_number,'cont_date_in'=>$cont_date_in,'rec_id'=>0),'');


                    $loc_row = explode(' ',$array_data['location'])[0];
                    $loc_col = explode(' ',$array_data['location'])[1];
                    $loc_stack = explode(' ',$array_data['location'])[2];

                    $shipper = $this->ptmsagate->query("select shipper from t_t_entry_cont_in where id_cont_in='".$array_data['id_cont_in']."' ")->row()->shipper;

                }       

                if($cont_number == ""){
                    $pesan_data = array(
                        'msg' => 'Tidak',
                        'array_data' => $array_data,
                        // 'r_party' => $r_party+1,
                        // 'party' => $party,
                        'query' => $query,
                        'loc_row' => $loc_row,
                        'loc_col' => $loc_col,
                        'loc_stack' => $loc_stack,
                        'shipper' => $shipper,
                    );
                    echo json_encode($pesan_data);die;
                }else{
                    $pesan_data = array(
                        'msg' => 'Ya',
                        'array_data' => $array_data,
                        // 'r_party' => $r_party+1,
                        // 'party' => $party,
                        'query' => $query,
                        'loc_row' => $loc_row,
                        'loc_col' => $loc_col,
                        'loc_stack' => $loc_stack,
                        'shipper' => $shipper,
                    );
                    echo json_encode($pesan_data);
                }

            } else {
                
                //TPS
                $query = "  SELECT * from mba_tps.tps_t_plp_detail a 
                INNER JOIN mba_tps.tps_t_plp_do b on a.T_In_Detail_ID=b.T_In_Detail_ID 
                where a.RecID<>9 and No_Transaksi='".$No_Transaksi."' " ;


                $datakontainer = $this->mbatps->query($query)->result_array();      
                $cont_date_in = '' ;
                $cont_number = '' ;
                $array_data = array();
                $loc_row = '' ;
                $loc_col = '' ;
                $loc_stack = '' ;
                $shipper = '' ;

                foreach($datakontainer as $row){
                    $cont_date_in = date_db($row['TglMasuk']);
                    $cont_number = $row['NoKontainer'];

                    $array_data = $this->m_model->table_tostring($param_db,'*,DATE_FORMAT(cont_date_in,"%d-%m-%Y") as "cont_date_in2"','t_t_stock','',array('cont_number'=>$cont_number,'cont_date_in'=>$cont_date_in,'rec_id'=>0),'');


                    $loc_row = explode(' ',$array_data['location'])[0];
                    $loc_col = explode(' ',$array_data['location'])[1];
                    $loc_stack = explode(' ',$array_data['location'])[2];

                    $shipper = $this->ptmsagate->query("select shipper from t_t_entry_cont_in where id_cont_in='".$array_data['id_cont_in']."' ")->row()->shipper;

                }       

                if($cont_number == ""){
                    $pesan_data = array(
                        'msg' => 'Tidak',
                        'array_data' => $array_data,
                        // 'r_party' => $r_party+1,
                        // 'party' => $party,
                        'query' => $query,
                        'loc_row' => $loc_row,
                        'loc_col' => $loc_col,
                        'loc_stack' => $loc_stack,
                        'shipper' => $shipper,
                    );
                    echo json_encode($pesan_data);die;
                }else{
                    $pesan_data = array(
                        'msg' => 'Ya',
                        'array_data' => $array_data,
                        // 'r_party' => $r_party+1,
                        // 'party' => $party,
                        'query' => $query,
                        'loc_row' => $loc_row,
                        'loc_col' => $loc_col,
                        'loc_stack' => $loc_stack,
                        'shipper' => $shipper,
                    );
                    echo json_encode($pesan_data);
                }
            }


            


        }else if($param_form == 'search_container_stock'){

            $cont_number = $this->input->post('cont_number');
            $Do_Number = $this->input->post('Do_Number');
            $id_cont_in = $this->input->post('id_cont_in');

            // $r_party = $this->ptmsagate->query("select COUNT(*) 'r_party' from t_t_entry_cont_out where do_number='".$Do_Number."' and  rec_id=0 ")->row()->r_party;
            // $party = $this->ptmsagate->query("SELECT party FROM t_t_entry_do_cont_out where rec_id=0 and do_number='".$Do_Number."' ")->row()->party;

            $array_data = $this->m_model->table_tostring($param_db,'*,DATE_FORMAT(cont_date_in,"%d-%m-%Y") as "cont_date_in2"','t_t_stock','',array('id_cont_in'=>$id_cont_in,'rec_id'=>0),'');


            $loc_row = explode(' ',$array_data['location'])[0];
            $loc_col = explode(' ',$array_data['location'])[1];
            $loc_stack = explode(' ',$array_data['location'])[2];

            $shipper = $this->ptmsagate->query("select shipper from t_t_entry_cont_in where id_cont_in='".$array_data['id_cont_in']."' ")->row()->shipper;



            $pesan_data = array(
                'msg' => 'Ya',
                'array_data' => $array_data,
                // 'r_party' => $r_party+1,
                // 'party' => $party,
                'loc_row' => $loc_row,
                'loc_col' => $loc_col,
                'loc_stack' => $loc_stack,
                'shipper' => $shipper,
            );
            echo json_encode($pesan_data);



        }
        
        
        
    }


    function c_cek_lock_gate(){
        $cont_number = $this->input->post('cont_number');
        $code_principal = $this->input->post('code_principal');
        $cont_date_in = $this->input->post('cont_date_in');
        $a=0;
        //KONTAINER TPP
        if($code_principal == "TPP"){

            $data = $this->ptmsadbo->query("select FlagStatus from tpp_t_bap_detail_gate_status where  
                NoKontainer='".$cont_number."' and TglMasuk='".$cont_date_in."' ")->result_array();

            $query[$a++] = $this->ptmsadbo->last_query();

            $FlagStatus = "" ;
            foreach($data as $row){
                $FlagStatus = $row['FlagStatus'] ;
            }

            if($FlagStatus == "1" || $FlagStatus == 1){
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Stop System Gate...!!' ,
                    'query' => $query,
                );
            }else{
                $pesan_data = array(
                    'msg' => 'Ya',
                    'pesan' => '' ,
                    'query' => $query,
                );
            }

            
            echo json_encode($pesan_data);


        //KONTAINER TPS,PJT    
        }else{

            $data = $this->mbatps->query("select FlagStatus from tps_t_plp_detail_gate_status where  
                NoKontainer='".$cont_number."' and TglMasuk='".$cont_date_in."' ")->result_array();
            $query[$a++] = $this->mbatps->last_query();

            $FlagStatus = "" ;
            foreach($data as $row){
                $FlagStatus = $row['FlagStatus'] ;
            }

            if($FlagStatus == "1" || $FlagStatus == 1){
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Stop System Gate...!!' ,
                    'query' => $query,
                );
            }else{
                $pesan_data = array(
                    'msg' => 'Ya',
                    'pesan' => '' ,
                    'query' => $query,
                );
            }

            
            echo json_encode($pesan_data);

        }
    }

    function c_cek_lock_segel(){
        $cont_number = $this->input->post('cont_number');
        $code_principal = $this->input->post('code_principal');
        $cont_date_in = $this->input->post('cont_date_in');
        $a=0;
        //KONTAINER TPP
        if($code_principal == "TPP"){

            $data = $this->ptmsadbo->query("select FlagStatus from tpp_t_bap_detail_status where  
                NoKontainer='".$cont_number."' and TglMasuk='".$cont_date_in."' ORDER BY Created_On desc limit 1 ")->result_array();
            $query[$a++] = $this->ptmsadbo->last_query();
            $FlagStatus = "" ;
            foreach($data as $row){
                $FlagStatus = $row['FlagStatus'] ;
            }

            if($FlagStatus == "1" || $FlagStatus == 1){
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Stop System Segel By Custom...!!' ,
                    'query' => $query,
                );
            }else{
                $pesan_data = array(
                    'msg' => 'Ya',
                    'pesan' => '' ,
                    'query' => $query,
                );
            }

            
            echo json_encode($pesan_data);


        //KONTAINER TPS,PJT    
        }else{

            $data = $this->mbatps->query("select FlagStatus from tps_t_plp_detail_status where  
                NoKontainer='".$cont_number."' and TglMasuk='".$cont_date_in."' ORDER BY Created_On desc limit 1  ")->result_array();
            $query[$a++] = $this->mbatps->last_query();
            $FlagStatus = "" ;
            foreach($data as $row){
                $FlagStatus = $row['FlagStatus'] ;
            }

            if($FlagStatus == "1" || $FlagStatus == 1){
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Stop System Segel By Custom...!!' ,
                    'query' => $query,
                );
            }else{
                $pesan_data = array(
                    'msg' => 'Ya',
                    'pesan' => '' ,
                    'query' => $query,
                );
            }

            
            echo json_encode($pesan_data);

        }
    }
    
}
