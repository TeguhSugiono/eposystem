<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_delivery extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }     
        //$this->db_tpsonline = $this->load->database('db_tpsonline', TRUE);  
        //$this->ptmsagate = $this->load->database('ptmsagate', TRUE);     
        $this->tribltps = $this->load->database('tribltps', TRUE); 
    }

        
    function index(){

        $menu_active = $this->m_model->menu_active();

        $startdate = date('m-Y') ;
        $enddate = date('d-m-Y') ;

        $arraydata = array('' => 'ALL','T6'=> 'Koordinator', 'T7' => 'Tally','T8' => 'YC');
        $kode_trans = ComboNonDb($arraydata, 'kode_trans', '', 'form-control form-control-sm');

        $arraydata = $this->tribltps->query("SELECT DISTINCT bl_no 'bl_no',bl_no 'bl_no1'  FROM whs_t_out_check_detail a 
            inner join whs_t_out_check b ON a.kode_trans = b.kode_trans AND a.no_trans = b.no_trans 
            WHERE a.rec_id = '0'  AND tgl_out >= '".date('Y-m')."-01' AND tgl_out <= '".date('Y-m-d')."' ORDER BY bl_no ")->result_array();
        array_push($arraydata, array('bl_no' => '' , 'bl_no1' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'bl_no', 'class' => 'selectpicker'),
        );
        $bl_no = ComboDb($createcombo);

        $arraydata = $this->tribltps->query(" SELECT DISTINCT a.shipper_id,shipper_name  FROM whs_t_out_check a 
            INNER JOIN whs_m_shipper b ON a.shipper_id = b.shipper_id  
            WHERE a.rec_id = '0' AND tgl_out >= '".date('Y-m')."-01' AND tgl_out <= '".date('Y-m-d')."' ORDER BY shipper_name  ")->result_array();
        array_push($arraydata, array('shipper_id' => '' , 'shipper_name' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'shipper_id', 'class' => 'selectpicker'),
        );
        $shipper_id = ComboDb($createcombo);

        $arraydata = $this->tribltps->query(" SELECT DISTINCT a.consignee_id,consignee_name
             FROM whs_t_out_check_detail a 
             INNER JOIN whs_m_consignee b ON a.consignee_id = b.consignee_id  
             INNER JOIN whs_t_out_check c ON a.kode_trans = c.kode_trans AND a.no_trans = c.no_trans 
             WHERE c.rec_id = '0' AND a.rec_id = '0' AND tgl_out >= '".date('Y-m')."-01' AND tgl_out <= '".date('Y-m-d')."' ORDER BY consignee_name ")->result_array();
        array_push($arraydata, array('consignee_id' => '' , 'consignee_name' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'consignee_id', 'class' => 'selectpicker'),
        );
        $consignee_id = ComboDb($createcombo);        

         
        $arraydata = $this->tribltps->query(" SELECT DISTINCT destination,destination 'destination1'  FROM whs_t_out_check 
            WHERE rec_id = '0' AND tgl_out >= '".date('Y-m')."-01' AND tgl_out <= '".date('Y-m-d')."' ORDER BY destination ")->result_array();
        array_push($arraydata, array('destination' => '' , 'destination1' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'destination', 'class' => 'selectpicker'),
        );
        $destination = ComboDb($createcombo);  

         
        $arraydata = $this->tribltps->query(" SELECT DISTINCT vehicle_no,vehicle_no 'vehicle_no1'  FROM whs_t_out_check 
        WHERE rec_id = '0' AND tgl_out >= '".date('Y-m')."-01' AND tgl_out <= '".date('Y-m-d')."' ORDER BY vehicle_no ")->result_array();
        array_push($arraydata, array('vehicle_no' => '' , 'vehicle_no1' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'vehicle_no', 'class' => 'selectpicker'),
        );
        $vehicle_no = ComboDb($createcombo);  

        
        $arraydata = $this->tribltps->query(" SELECT vessel_id,vessel_name 'Nama Vessel',vessel_voyage 'Voyage'  FROM whs_m_vessel WHERE rec_id = '0'  ")->result_array();
        array_push($arraydata, array('vessel_id' => '' , 'vessel_name' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'vessel_id', 'class' => 'selectpicker'),
        );
        $vessel_id = ComboDb($createcombo);


        
        $arraydata = $this->tribltps->query(" SELECT DISTINCT do_no,do_no 'do_no1'  FROM whs_t_out_check 
            WHERE rec_id = '0' AND tgl_out >= '".date('Y-m')."-01' AND tgl_out <= '".date('Y-m-d')."' ")->result_array();
        array_push($arraydata, array('do_no' => '' , 'do_no1' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'do_no', 'class' => 'selectpicker'),
        );
        $do_no = ComboDb($createcombo);

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'startdate' => "01-$startdate" ,
            'enddate' => $enddate,
            'kode_trans' => $kode_trans,
            'bl_no' => $bl_no,
            'shipper_id' => $shipper_id,
            'consignee_id' => $consignee_id,
            'destination' => $destination,
            'vehicle_no' => $vehicle_no,
            'vessel_id' => $vessel_id,
            'do_no' => $do_no,
        );
        $this->load->view('dashboard/index', $data);

    }

    function c_refresh_combo(){
        $tgl_out = date_db($this->input->post('tgl_out')) ;
        $tgl_out_end = date_db($this->input->post('tgl_out_end')) ;

        $data_bl = $this->tribltps->query("SELECT DISTINCT bl_no 'id',bl_no 'name'  FROM whs_t_out_check_detail a 
            inner join whs_t_out_check b ON a.kode_trans = b.kode_trans AND a.no_trans = b.no_trans 
            WHERE a.rec_id = '0'  AND tgl_out >= '".$tgl_out."' AND tgl_out <= '".$tgl_out_end."' ORDER BY bl_no ")->result_array();
        array_push($data_bl, array('id' => '' , 'name' => 'ALL'));


        $data_shipper = $this->tribltps->query(" SELECT DISTINCT a.shipper_id,shipper_name  FROM whs_t_out_check a 
            INNER JOIN whs_m_shipper b ON a.shipper_id = b.shipper_id  
            WHERE a.rec_id = '0' AND tgl_out >= '".$tgl_out."' AND tgl_out <= '".$tgl_out_end."' ORDER BY shipper_name  ")->result_array();
        array_push($data_shipper, array('shipper_id' => '' , 'shipper_name' => 'ALL'));


        $data_consignee = $this->tribltps->query(" SELECT DISTINCT a.consignee_id,consignee_name
             FROM whs_t_out_check_detail a 
             INNER JOIN whs_m_consignee b ON a.consignee_id = b.consignee_id  
             INNER JOIN whs_t_out_check c ON a.kode_trans = c.kode_trans AND a.no_trans = c.no_trans 
             WHERE c.rec_id = '0' AND a.rec_id = '0' AND tgl_out >= '".$tgl_out."' AND tgl_out <= '".$tgl_out_end."' ORDER BY consignee_name ")->result_array();
        array_push($data_consignee, array('consignee_id' => '' , 'consignee_name' => 'ALL'));


        $data_destination = $this->tribltps->query(" SELECT DISTINCT destination,destination 'destination1'  FROM whs_t_out_check 
            WHERE rec_id = '0' AND tgl_out >= '".$tgl_out."' AND tgl_out <= '".$tgl_out_end."' ORDER BY destination ")->result_array();
        array_push($data_destination, array('destination' => '' , 'destination1' => 'ALL'));


        $data_vehicle = $this->tribltps->query(" SELECT DISTINCT vehicle_no,vehicle_no 'vehicle_no1'  FROM whs_t_out_check 
        WHERE rec_id = '0' AND tgl_out >= '".$tgl_out."' AND tgl_out <= '".$tgl_out_end."' ORDER BY vehicle_no ")->result_array();
        array_push($data_vehicle, array('vehicle_no' => '' , 'vehicle_no1' => 'ALL'));


        $data_do = $this->tribltps->query(" SELECT DISTINCT do_no,do_no 'do_no1'  FROM whs_t_out_check 
            WHERE rec_id = '0' AND tgl_out >= '".$tgl_out."' AND tgl_out <= '".$tgl_out_end."' ")->result_array();
        array_push($data_do, array('do_no' => '' , 'do_no1' => 'ALL'));


        $comp = array(
            'bl_no' => $this->m_model->array_tag_on_index(array_reverse($data_bl,false)),
            'shipper_id' => $this->m_model->array_tag_on_index(array_reverse($data_shipper,false)),
            'consignee_id' => $this->m_model->array_tag_on_index(array_reverse($data_consignee,false)),
            'destination' => $this->m_model->array_tag_on_index(array_reverse($data_destination,false)),
            'vehicle_no' => $this->m_model->array_tag_on_index(array_reverse($data_vehicle,false)),
            'do_no' => $this->m_model->array_tag_on_index(array_reverse($data_do,false)),
        );        
        echo json_encode($comp);
    }

    function tbl_whsout_delivery(){
        
        $tgl_out = date_db($this->input->post('tgl_out')) ;
        $tgl_out_end = date_db($this->input->post('tgl_out_end')) ;
        $bl_no = $this->input->post('bl_no') ;
        $shipper_id = $this->input->post('shipper_id') ;
        $consignee_id = $this->input->post('consignee_id') ;
        $destination = $this->input->post('destination') ;
        $vehicle_no = $this->input->post('vehicle_no') ;
        $vessel_id = $this->input->post('vessel_id') ;
        $do_no = $this->input->post('do_no') ;
        $kode_trans = $this->input->post('kode_trans') ;


        $query= " SELECT DISTINCT a.kode_trans,a.no_trans " ;
        $query.= " ,do_no,DATE_FORMAT(tgl_out,'%d-%m-%Y') 'tgl_out',DATE_FORMAT(time_out,'%H:%i') 'jamkeluar', vessel_name   " ;
        $query.= " ,shipper_Name,vehicle_no,destination  "  ;
        $query.= " ,CONVERT(CONCAT(cont_no,' ',tipe,' ',ukuran) USING UTF8) 'cont',  seal_no  " ;
        $query.= " ,DATE_FORMAT(start_unloading,'%d-%m-%Y %H:%i') 'start_unloading',ifnull(DATE_FORMAT(finish_unloading,'%d-%m-%Y %H:%i'),'') 'finish_unloading', a.remarks " ;
        $query.= " From whs_t_out_check a  "  ;
        $query.= " INNER JOIN whs_m_vessel b ON a.vessel_id = b.vessel_id " ;
        $query.= " INNER JOIN whs_m_shipper c ON a.shipper_id = c.shipper_id " ;
        $query.= " INNER JOIN whs_t_out_check_detail d ON a.kode_trans = d.kode_trans AND a.no_trans = d.no_trans  " ;
        $query.= " WHERE a.rec_id = '0'  AND tgl_out >= '".$tgl_out."' AND tgl_out <= '".$tgl_out_end."' " ;

        if($bl_no != ""){
            $query.= " and d.bl_no='".$bl_no."' " ;
        }

        if($shipper_id != ""){
            $query.= " and a.shipper_id='".$shipper_id."' " ;
        }

        if($consignee_id != ""){
            $query.= " and consignee_id='".$consignee_id."' " ;
        }

        if($destination != ""){
            $query.= " and destination='".$destination."' " ;
        }

        if($vehicle_no != ""){
            $query.= " and vehicle_no='".$vehicle_no."' " ;
        }

        if($vessel_id != ""){
            $query.= " and a.vessel_id='".$vessel_id."' " ;
        }

        if($do_no != ""){
            $query.= " and a.do_no='".$do_no."' " ;
        }

        if($kode_trans != ""){
            $query.= " and a.kode_trans='".$kode_trans."' " ;
        }

        $query.= " ORDER BY a.kode_trans,do_no,vehicle_no " ;
        $data = $this->tribltps->query($query);

        $comp = array(
            'jml' => $data->num_rows(),
            'isidata' => $this->m_model->array_tag_on_index($data->result_array()),
            'query' => $query
        );        
        echo json_encode($comp);
    }

    function c_detail_bl(){
        $kode_trans = $this->input->post('kode_trans') ;
        $no_trans = $this->input->post('no_trans') ;

        $sql= " SELECT bl_no 'No. BL',a.consignee_id, consignee_name 'Nama Consignee', " ;
        $sql.= " seq_no,ex_blno 'Ex BL', a.category_id, category_name 'Category',  " ;
        $sql.= " item_desc 'Deskripsi Item' ,item_code 'Code Item',a.location_id,IFNULL(location_name,'') 'Lokasi', " ;
        $sql.= " good_unit 'Good', good_gross_weight 'Good GW', good_volume 'Good Volume', " ;
        $sql.= " damage_unit 'Damage', damage_gross_weight 'Damage GW', damage_volume 'Damage Volume' , " ;
        $sql.= " palet_id 'Palet ID', IFNULL(remarks,'') 'Remarks',t_stock_id,jenis_doc as 'Jenis Document' " ;
        $sql.= " FROM whs_t_out_check_detail a  " ;
        $sql.= " INNER JOIN whs_m_category b ON  a.category_id = b.category_id   " ;
        $sql.= " INNER JOIN whs_m_consignee c ON a.consignee_id = c.consignee_id  " ;
        $sql.= " LEFT JOIN whs_m_location d ON a.location_id = d.location_id  " ;
        $sql.= " WHERE a.rec_id = '0' AND kode_trans = '".$kode_trans."' AND no_trans = '".$no_trans."' " ;
        $data_detail = $this->tribltps->query($sql)->result_array();

        $comp = array(
            'kode_trans' => $kode_trans,
            'no_trans' => $no_trans,
            'isidata' => $this->m_model->array_tag_on_index($data_detail),
        );        
        echo json_encode($comp);
    }


    function c_formadd(){


        $arrayOperator = array('T6'=> 'Koordinator', 'T7' => 'Tally','T8' => 'YC');
        $arraydata = $this->tribltps->query(" SELECT a.bl_no,a.bl_no 'bl_no1' 
            from whs_t_stock_detail a 
            INNER JOIN whs_t_in_detail dd on a.batch_in = dd.batch_in  
            and a.rec_no = dd.rec_no and a.bl_no = dd.bl_no
            INNER JOIN whs_m_category b on a.category_id = b.category_id
            INNER JOIN whs_m_consignee c on c.consignee_id = a.consignee_id
            WHERE a.rec_id = '0' 
            GROUP BY a.bl_no,a.consignee_id ")->result_array();
        array_push($arraydata, array('bl_no' => '' , 'bl_no1' => 'Cari Bl..'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'txtNoDo', 'class' => 'selectpicker'),
        );
        $txtNoDo = ComboDb($createcombo);


        $data['kode_trans'] = $this->input->post('kode_trans');
        $data['operator'] = $arrayOperator[$this->input->post('kode_trans')];
        $data['txtNoDo'] = $txtNoDo;


        $arraydata = $this->tribltps->query(" SELECT vessel_id,concat(vessel_name,' ~ ',vessel_voyage) 'vessel_name' FROM whs_m_vessel WHERE rec_id = '0'  ")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'txtVessel', 'class' => 'selectpicker'),
        );
        $txtVessel = ComboDb($createcombo);
        $data['txtVessel'] = $txtVessel;

 
        $arraydata = $this->tribltps->query(" select DISTINCT a.shipper_id,d.shipper_name from whs_t_in a
            INNER JOIN whs_t_in_detail b on a.batch_in=b.batch_in
            INNER JOIN whs_t_stock_detail c on b.batch_in=c.batch_in
            INNER JOIN whs_m_shipper d on a.shipper_id=d.shipper_id
            where a.rec_id=0 and b.rec_id=0 and c.rec_id=0 ")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'txtShipper', 'class' => 'selectpicker'),
        );
        $txtShipper = ComboDb($createcombo);
        $data['txtShipper'] = $txtShipper;


        //print_r($data);

        $this->load->view('add',$data);
    }


    function c_load_data_bl(){
        $txtNoDo = $this->input->post('txtNoDo') ;
        $flaginsert = $this->input->post('flaginsert');
        $sql= "" ;
        $sql.= " SELECT DISTINCT a.bl_no,a.consignee_id,c.consignee_name ,a.category_id,b.category_name,dd.item_desc,a.item_code, " ;
        $sql.= " a.location_id,'',SUM(a.good_unit) 'good',SUM(a.good_unit)*a.good_gross_weight 'ggw', " ;
        $sql.= " SUM(a.good_unit)*a.good_volume 'gv',SUM(a.damage_unit) 'damage', " ;
        $sql.= " SUM(a.damage_unit)*a.damage_gross_weight 'dgw',SUM(a.damage_unit)*a.damage_volume 'dv','','',a.t_stock_id,'',e.location_name " ;
        $sql.= " from whs_t_stock_detail a " ;
        $sql.= " INNER JOIN whs_t_in_detail dd on a.batch_in = dd.batch_in  " ;
        $sql.= " and a.rec_no = dd.rec_no and a.bl_no = dd.bl_no " ;
        $sql.= " INNER JOIN whs_m_category b on a.category_id = b.category_id " ;
        $sql.= " INNER JOIN whs_m_consignee c on c.consignee_id = a.consignee_id " ;
        $sql.= " INNER JOIN whs_m_location e on a.location_id=e.location_id " ;
        $sql.= " WHERE a.rec_id <> '9' AND a.bl_no  = '".$txtNoDo."'  " ;
        $sql.= " GROUP BY a.bl_no,a.consignee_id " ;

        // if($flaginsert == "new"){
        //     $sql= " SELECT DISTINCT a.bl_no,a.consignee_id,c.consignee_name ,a.category_id,b.category_name,dd.item_desc,a.item_code, " ;
        //     $sql.= " a.location_id,'',SUM(a.good_unit) 'good',SUM(a.good_unit)*a.good_gross_weight 'ggw', " ;
        //     $sql.= " SUM(a.good_unit)*a.good_volume 'gv',SUM(a.damage_unit) 'damage', " ;
        //     $sql.= " SUM(a.damage_unit)*a.damage_gross_weight 'dgw',SUM(a.damage_unit)*a.damage_volume 'dv','','',a.t_stock_id,'',e.location_name " ;
        //     $sql.= " from whs_t_stock_detail a " ;
        //     $sql.= " INNER JOIN whs_t_in_detail dd on a.batch_in = dd.batch_in  " ;
        //     $sql.= " and a.rec_no = dd.rec_no and a.bl_no = dd.bl_no " ;
        //     $sql.= " INNER JOIN whs_m_category b on a.category_id = b.category_id " ;
        //     $sql.= " INNER JOIN whs_m_consignee c on c.consignee_id = a.consignee_id " ;
        //     $sql.= " INNER JOIN whs_m_location e on a.location_id=e.location_id " ;
        //     $sql.= " WHERE a.rec_id <> '9' AND a.bl_no  = '".$txtNoDo."'  " ;
        //     $sql.= " GROUP BY a.bl_no,a.consignee_id " ;
        // }else{
        //     $sql= " SELECT DISTINCT a.bl_no,a.consignee_id,c.consignee_name ,a.category_id,b.category_name,dd.item_desc,a.item_code, " ;
        //     $sql.= " a.location_id,'',SUM(h.good_unit) 'good',SUM(h.good_unit)*h.good_gross_weight 'ggw', " ;
        //     $sql.= " SUM(h.good_unit)*h.good_volume 'gv',SUM(h.damage_unit) 'damage', " ;
        //     $sql.= " SUM(h.damage_unit)*h.damage_gross_weight 'dgw',SUM(h.damage_unit)*h.damage_volume 'dv','','',a.t_stock_id,'',e.location_name " ;
        //     $sql.= " from whs_t_stock_detail a " ;
        //     $sql.= " INNER JOIN whs_t_in_detail dd on a.batch_in = dd.batch_in  " ;
        //     $sql.= " and a.rec_no = dd.rec_no and a.bl_no = dd.bl_no " ;
        //     $sql.= " INNER JOIN whs_m_category b on a.category_id = b.category_id " ;
        //     $sql.= " INNER JOIN whs_m_consignee c on c.consignee_id = a.consignee_id " ;
        //     $sql.= " INNER JOIN whs_m_location e on a.location_id=e.location_id " ;        
        //     $sql.= " INNER JOIN whs_t_invoice_party f on a.bl_no = f.bl_no " ;
        //     $sql.= " INNER JOIN whs_t_invoice_head g on f.invoice_no=g.invoice_no and g.trans_code='DELIVERY' " ;
        //     $sql.= " INNER JOIN whs_t_out_check_detail h on a.t_stock_id = h.t_stock_id and h.rec_id = 0 " ;
        //     $sql.= " WHERE a.rec_id <> '9' AND a.bl_no  = '".$txtNoDo."'  " ;
        //     $sql.= " GROUP BY a.bl_no,a.consignee_id " ;
        //     $sql.= " union all " ;
        //     $sql.= " SELECT DISTINCT a.bl_no,a.consignee_id,c.consignee_name ,a.category_id,b.category_name,dd.item_desc,a.item_code, " ;
        //     $sql.= " a.location_id,'',SUM(h.good_unit) 'good',SUM(h.good_unit)*h.good_gross_weight 'ggw', " ;
        //     $sql.= " SUM(h.good_unit)*h.good_volume 'gv',SUM(h.damage_unit) 'damage', " ;
        //     $sql.= " SUM(h.damage_unit)*h.damage_gross_weight 'dgw',SUM(h.damage_unit)*h.damage_volume 'dv','','',a.t_stock_id,'',e.location_name " ;
        //     $sql.= " from whs_t_stock_detail a " ;
        //     $sql.= " INNER JOIN whs_t_in_detail dd on a.batch_in = dd.batch_in  " ;
        //     $sql.= " and a.rec_no = dd.rec_no and a.bl_no = dd.bl_no " ;
        //     $sql.= " INNER JOIN whs_m_category b on a.category_id = b.category_id " ;
        //     $sql.= " INNER JOIN whs_m_consignee c on c.consignee_id = a.consignee_id " ;
        //     $sql.= " INNER JOIN whs_m_location e on a.location_id=e.location_id " ;        
        //     $sql.= " INNER JOIN whs_t_out_check_detail h on a.t_stock_id = h.t_stock_id and h.rec_id = 0 " ;
        //     $sql.= " WHERE a.rec_id <> '9' AND a.bl_no  = '".$txtNoDo."'  " ;
        //     $sql.= " GROUP BY a.bl_no,a.consignee_id " ;
        // }
        

        $loadsql = $sql ;

        $data_detail = $this->tribltps->query($sql)->result_array();

        $sql= " " ;
        $sql.= " SELECT DISTINCT a.vessel_id,a.shipper_id,a.seal_no from whs_t_in_check a  " ;
        $sql.= " INNER JOIN whs_t_in_check_detail b  " ;
        $sql.= " on a.kode_trans=b.kode_trans and a.no_trans=b.no_trans " ;
        $sql.= " where a.rec_id=0 and b.rec_id=0 and b.bl_no='".$txtNoDo."' " ;
        $data_header = $this->tribltps->query($sql)->result_array();

        $vessel_id = "" ;
        $shipper_id = "" ;
        $seal_no = "" ;
        foreach($data_header as $datahead){
            $vessel_id = $datahead['vessel_id'] ;
            $shipper_id = $datahead['shipper_id'] ;
            $seal_no = $datahead['seal_no'] ;
        }


        $comp = array(
            'txtNoDo' => $txtNoDo,
            'isidata' => $this->m_model->array_tag_on_index($data_detail),
            'isidataheader' => $this->m_model->array_tag_on_index($data_detail),
            'sql' => $sql,
            'vessel_id' => $vessel_id,
            'shipper_id' => $shipper_id,
            'seal_no' => $seal_no,
            'tgl_load' => date('d-m-Y'),
            'jam_load' => date('H:i'),
            'loadsql' => $loadsql
        );        
        echo json_encode($comp);
    }

    function c_save(){
        $kode_trans = $this->input->post('kode_trans');
        $do_no = $this->input->post('txtNoDo');

        //cek no bl save ke table whs_t_out_check
        $query = " SELECT * from whs_t_out_check a 
            INNER JOIN whs_t_out_check_detail b on a.kode_trans=a.kode_trans and a.no_trans=b.no_trans
            where a.rec_id<>9 and b.rec_id=0 and b.bl_no = '".$do_no."' " ;
        if($this->tribltps->query($query)->num_rows() > 0){
            $comp = array(
                'msg' => 'Tidak',
                'pesan' => 'No Bl Ini Sudah Diinput ..!!'
            );
            echo json_encode($comp);
            die;
        }

        // $getuser_random = " SELECT user_name FROM whs_m_users where user_name<>'".$this->session->userdata('autogate_username')."' and user_name<>'teguh' ORDER BY RAND() " ;
        // if($this->tribltps->query($getuser_random)->num_rows() == 0){
        //     $comp = array(
        //         'msg' => 'Tidak',
        //         'pesan' => 'Error Table whs_m_users ..!!'
        //     );
        //     echo json_encode($comp);
        //     die;
        // }

        $getuser_random = $this->session->userdata('autogate_username') ;


        $tgl_out = date_db($this->input->post('dtpOut'));
        $time_out = $this->input->post('txtTimeOut');
        $vessel_id = $this->input->post('txtVessel');
        $shipper_id = $this->input->post('txtShipper');
        $vehicle_no = $this->input->post('txtNoMobil');
        $destination = $this->input->post('txtDestination');
        $seal_no = $this->input->post('txtSealNo');
        $remarks = $this->input->post('txtRemarks');

        //cari no trans
        //CONVERT(LPAD(number,6,'0') USING UTF8)
        $select = " number " ;
        $where = array(
            'run_code' => $kode_trans,
            'run_year' => date('Y'),
        );

        $no_trans = $this->m_model->global_run_number('tribltps', 'whs_run_number',$select, $where);
        if($no_trans == ''){
            $comp = array(
                'msg' => 'Tidak',
                'pesan' => 'Error Running Number ..!!'
            );
            echo json_encode($comp);
            die;
        }

        $no_trans = date('Y')."".date('m')."".str_pad($no_trans, 6, "0", STR_PAD_LEFT) ;


        $whs_t_out_check = array(
            'kode_trans' => $kode_trans,
            'no_trans' => $no_trans,
            'do_no' => $do_no,
            'tgl_out' => $tgl_out,
            'time_out' => $time_out,
            'vessel_id' => $vessel_id,
            'shipper_id' => $shipper_id,
            'vehicle_no' => $vehicle_no,
            'destination' => $destination,
            'cont_no' => '-',
            'tipe' => '-',
            'ukuran' => '-',
            'seal_no' => $seal_no,
            'remarks' => $remarks,
            'created_on' => tanggal_sekarang(),
            'created_by' => $this->session->userdata('autogate_username') ,
            'start_unloading' => tanggal_sekarang(),
            'finish_unloading' => tanggal_sekarang(),
        );

        

        //data detail
        $bl_no = $this->input->post('bl_no_input') ;
        $consignee_id = explode('   idtabel : ', $this->input->post('consignee_name_input'))[1] ;
        $ex_blno = $this->input->post('ex_blno_input') ;
        $category_id  = explode('   idtabel : ', $this->input->post('category_name_input'))[1] ;
        $item_desc = $this->input->post('item_desc_input') ;
        $item_code = $this->input->post('item_code_input') ;
        $location_id = explode('   idtabel : ', $this->input->post('location_name_input'))[1] ;
        $good_unit = $this->input->post('good_unit_input') ;
        $good_gross_weight = $this->input->post('good_gross_weight_input') ;
        $good_volume = $this->input->post('good_volume_input') ;
        $damage_unit = $this->input->post('damage_unit_input') ;
        $damage_gross_weight = $this->input->post('damage_gross_weight_input') ;
        $damage_volume = $this->input->post('damage_volume_input') ;
        $t_stock_id = $this->input->post('t_stock_id') ;

        $this->tribltps->select('batch_in');
        $batch_in = $this->tribltps->get_where('whs_t_stock_detail',array('t_stock_id' => $t_stock_id))->row()->batch_in;

        if($batch_in == ''){
            $comp = array(
                'msg' => 'Tidak',
                'pesan' => 'Error Batch In Stock Id ..!!'
            );
            echo json_encode($comp);
            die;
        }

        $whs_t_out_check_detail = array(
            'kode_trans' => $kode_trans,
            'no_trans' => $no_trans,
            'bl_no' => $bl_no,
            'consignee_id' => $consignee_id,
            'seq_no' => 1,
            'ex_blno' => $ex_blno,
            'category_id' => $category_id,
            'item_desc' => $item_desc,
            'item_code' => $item_code,
            'location_id' => $location_id,
            'good_unit' => $good_unit,
            'good_gross_weight' => $good_gross_weight,
            'good_volume' => $good_volume,
            'damage_unit' => $damage_unit,
            'damage_gross_weight' => $damage_gross_weight,
            'damage_volume' => $damage_volume,
            'palet_id' => '',
            'remarks' => '',
            'jenis_doc' => '',
            't_stock_id' => $t_stock_id,
            'created_on' => tanggal_sekarang(),
            'created_by' => $this->session->userdata('autogate_username') ,
            'batch_in' => $batch_in,
            
        );

        //save data T6 Koordinator
        $last_min = date('Y-m-d H:i:s', strtotime('+20 minutes'));
        $saveheader = $this->m_model->savedata('tribltps', 'whs_t_out_check', $whs_t_out_check);
        $this->tribltps->update('whs_t_out_check',
            array('created_by' => $this->session->userdata('autogate_username'),'finish_unloading' => $last_min),
            array('no_trans' => $no_trans,'kode_trans' => $kode_trans)
        );

        if (!$saveheader >= 1) {
            $comp = array(
                'msg' => 'Tidak',
                'pesan' => 'Error Insert Data whs_t_out_check ..!!'
            );
            echo json_encode($comp);
            die;
        }

        $savedetail = $this->m_model->savedata('tribltps', 'whs_t_out_check_detail', $whs_t_out_check_detail);
        $this->tribltps->update('whs_t_out_check_detail',
            array('created_by' => $this->session->userdata('autogate_username')),array('no_trans' => $no_trans,'kode_trans' => $kode_trans));

        if (!$savedetail >= 1) {
            $comp = array(
                'msg' => 'Tidak',
                'pesan' => 'Error Insert Data whs_t_out_check_detail ..!!'
            );
            echo json_encode($comp);
            die;
        }

        //end save data T6 Koordinator



        //Inject data T7 dan T8
        $arraykodetrans = array('T7','T8');
        for($a=0 ; $a<count($arraykodetrans) ; $a++){

            //$user_random = $this->tribltps->query($getuser_random)->row()->user_name ;
            $user_random = $this->session->userdata('autogate_username') ;
            
            $whs_t_out_check['created_by'] = $user_random ;
            $whs_t_out_check['kode_trans'] = $arraykodetrans[$a] ;

            $no_trans = $this->m_model->global_run_number('tribltps', 'whs_run_number',$select, array('run_code' => $arraykodetrans[$a],'run_year' => date('Y')));
            if($no_trans == ''){
                $comp = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Error Running Number '.$arraykodetrans[$a].' ..!!'
                );
                echo json_encode($comp);
                die;
            }

            $no_trans = date('Y')."".date('m')."".str_pad($no_trans, 6, "0", STR_PAD_LEFT) ;

            $whs_t_out_check['no_trans'] = $no_trans ;
            $whs_t_out_check['start_unloading'] = tanggal_sekarang() ;
            $whs_t_out_check['finish_unloading'] = tanggal_sekarang() ;

            $last_min = date('Y-m-d H:i:s', strtotime('+20 minutes'));
            $saveheader = $this->m_model->savedata('tribltps', 'whs_t_out_check', $whs_t_out_check);
            $this->tribltps->update('whs_t_out_check',
                array('finish_unloading' => $last_min),
                array('no_trans' => $no_trans,'kode_trans' => $arraykodetrans[$a]));


            $this->tribltps->update('whs_t_out_check',
                array('created_by' => $user_random),array('no_trans' => $no_trans,'kode_trans' => $arraykodetrans[$a]));

            if (!$saveheader >= 1) {
                $comp = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Error Insert Data whs_t_out_check '.$arraykodetrans[$a].' ..!!'
                );
                echo json_encode($comp);
                die;
            }


            $whs_t_out_check_detail['created_by'] = $user_random ;
            $whs_t_out_check_detail['kode_trans'] = $arraykodetrans[$a] ;
            $whs_t_out_check_detail['no_trans'] = $no_trans ;

            $savedetail = $this->m_model->savedata('tribltps', 'whs_t_out_check_detail', $whs_t_out_check_detail);
            $this->tribltps->update('whs_t_out_check_detail',
            array('created_by' => $user_random),array('no_trans' => $no_trans,'kode_trans' => $arraykodetrans[$a]));

            if (!$savedetail >= 1) {
                $comp = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Error Insert Data whs_t_out_check_detail '.$arraykodetrans[$a].' ..!!'
                );
                echo json_encode($comp);
                die;
            }
        }
        //END Inject data T7 dan T8




        $comp = array(
            'msg' => 'Ya',
            'whs_t_out_check' => $whs_t_out_check,
            'whs_t_out_check_detail' => $whs_t_out_check_detail,
            'pesan' => 'Simpan Data Sukses ..!!'
        );

        echo json_encode($comp);
    }

    function c_formedit(){

        $kode_trans = $this->input->post('kode_trans');
        $no_trans = $this->input->post('no_trans');

        $arrayOperator = array('T6'=> 'Koordinator', 'T7' => 'Tally','T8' => 'YC');

        $data['kode_trans'] = $kode_trans;
        $data['no_trans'] = $no_trans;
        $data['operator'] = $arrayOperator[$kode_trans];

        $do_no = $this->input->post('do_no');
        // $query = " SELECT DISTINCT b.bl_no,b.bl_no 'bl_no1' from whs_t_out_check a 
        //     INNER JOIN whs_t_out_check_detail b on a.kode_trans=b.kode_trans and a.no_trans=b.no_trans
        //     WHERE a.rec_id=0 and b.rec_id=0 and a.no_trans='".$no_trans."' and a.kode_trans='".$kode_trans."' " ;
        // $databl = $this->tribltps->query($query)->result_array();    
        // $createcombo = array(
        //     'data' => $databl,
        //     'set_data' => array('set_id' => ''),
        //     'attribute' => array('idname' => 'txtNoDo', 'class' => ''),
        // );
        // $txtNoDo = ComboDb($createcombo);
        $arraydata = array($do_no => $do_no);
        $databl = ComboNonDb($arraydata, 'txtNoDo', $do_no, 'form-control selectpicker');
        $data['txtNoDo'] = $databl;

        $query = " SELECT  *,a.remarks as 'remarks_head' from whs_t_out_check a 
        INNER JOIN whs_t_out_check_detail b on a.kode_trans=b.kode_trans and a.no_trans=b.no_trans
        WHERE a.rec_id=0 and b.rec_id=0 and a.no_trans='".$no_trans."' and a.kode_trans='".$kode_trans."' " ;
        $data_out_check = $this->tribltps->query($query)->result_array();  

        $vessel_id = "" ;
        $shipper_id = "" ;
        foreach($data_out_check as $out_check){
            $vessel_id = $out_check['vessel_id'] ;
            $shipper_id = $out_check['shipper_id'] ;
        }



        $arraydata = $this->tribltps->query(" SELECT vessel_id,concat(vessel_name,' ~ ',vessel_voyage) 'vessel_name' FROM whs_m_vessel WHERE rec_id = '0'  ")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => $vessel_id),
            'attribute' => array('idname' => 'txtVessel', 'class' => 'selectpicker'),
        );
        $txtVessel = ComboDb($createcombo);
        $data['txtVessel'] = $txtVessel;

 
        $arraydata = $this->tribltps->query(" select DISTINCT a.shipper_id,d.shipper_name from whs_t_in a
            INNER JOIN whs_t_in_detail b on a.batch_in=b.batch_in
            INNER JOIN whs_t_stock_detail c on b.batch_in=c.batch_in
            INNER JOIN whs_m_shipper d on a.shipper_id=d.shipper_id
            where a.rec_id=0 and b.rec_id=0 and c.rec_id=0 ")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => $shipper_id),
            'attribute' => array('idname' => 'txtShipper', 'class' => 'selectpicker'),
        );
        $txtShipper = ComboDb($createcombo);
        $data['txtShipper'] = $txtShipper;

        $data['txtNoMobil'] = $this->input->post('txtNoMobil');
        $data['dtpOut'] = $this->input->post('dtpOut');
        $data['txtTimeOut'] = $this->input->post('txtTimeOut');
        $data['txtSealNo'] = $this->input->post('txtSealNo');
        $data['txtDestination'] = $this->input->post('txtDestination');
        $data['txtRemarks'] = $this->input->post('txtRemarks');

        $data['bl_no_input'] = $this->input->post('bl_no_input');
        $data['consignee_name_input'] = $this->input->post('consignee_name_input');
        $data['ex_blno_input'] = $this->input->post('ex_blno_input');
        $data['category_name_input'] = $this->input->post('category_name_input');
        $data['item_desc_input'] = $this->input->post('item_desc_input');
        $data['item_code_input'] = $this->input->post('item_code_input');
        $data['good_unit_input'] = $this->input->post('good_unit_input');
        $data['good_gross_weight_input'] = $this->input->post('good_gross_weight_input');
        $data['good_volume_input'] = $this->input->post('good_volume_input');
        $data['damage_unit_input'] = $this->input->post('damage_unit_input');
        $data['damage_gross_weight_input'] = $this->input->post('damage_gross_weight_input');
        $data['damage_volume_input'] = $this->input->post('damage_volume_input');
        $data['location_name_input'] = $this->input->post('location_name_input');
        // $data[''] = $this->input->post('');

        $this->tribltps->select('t_stock_id');
        $this->tribltps->limit(1);
        $data['t_stock_id'] = $this->tribltps->get_where('whs_t_stock_detail',array('bl_no' => $this->input->post('bl_no_input')))->row()->t_stock_id ;

        $this->load->view('edit',$data);
    }


    function c_update(){
        $kode_trans = $this->input->post('kode_trans');
        $no_trans = $this->input->post('no_trans');
        $do_no = $this->input->post('txtNoDo');

        $tgl_out = date_db($this->input->post('dtpOut'));
        $time_out = $this->input->post('txtTimeOut');
        $vessel_id = $this->input->post('txtVessel');
        $shipper_id = $this->input->post('txtShipper');
        $vehicle_no = $this->input->post('txtNoMobil');
        $destination = $this->input->post('txtDestination');
        $seal_no = $this->input->post('txtSealNo');
        $remarks = $this->input->post('txtRemarks');


        $query = " SELECT * from whs_t_out a 
            INNER JOIN whs_t_out_detail b on a.batch_out=a.batch_out 
            where a.rec_id=0 and b.rec_id=0 and a.do_no = '".$do_no."' " ;
        if($this->tribltps->query($query)->num_rows() > 0){
            $comp = array(
                'msg' => 'Tidak',
                'pesan' => 'No Bl Ini Sudah Keluar Stock ..!!'
            );
            echo json_encode($comp);
            die;
        }

        //save header

        $whs_t_out_check = array(
            'tgl_out' => $tgl_out,
            'time_out' => $time_out,
            'vessel_id' => $vessel_id,
            'shipper_id' => $shipper_id,
            'vehicle_no' => $vehicle_no,
            'destination' => $destination,
            'seal_no' => $seal_no,
            'remarks' => $remarks,
            'edited_on' => tanggal_sekarang(),
            'edited_by' => $this->session->userdata('autogate_username') ,
        );
        $where = array(
            'kode_trans' => $kode_trans,
            'no_trans' => $no_trans,
            'do_no' => $do_no
        );

        $update_header = $this->m_model->updatedata('tribltps','whs_t_out_check',$whs_t_out_check,$where) ;
        //$this->tribltps->update('whs_t_out_check',array('created_by' => $this->session->userdata('autogate_username')),array('no_trans' => $no_trans,'kode_trans' => $kode_trans));
        if (!$update_header >= 1) {
            $comp = array(
                'msg' => 'Tidak',
                'pesan' => 'Error Update Data whs_t_out_check ..!!'
            );
            echo json_encode($comp);
            die;
        }
        //end save header



        //data detail
        $bl_no = $this->input->post('bl_no_input') ;
        
        //$consignee_id = $this->input->post('consignee_name_input');
        $this->tribltps->select('consignee_id');
        $consignee_id = $this->tribltps->get_where('whs_m_consignee',array('consignee_name' => $this->input->post('consignee_name_input'),'rec_id' => 0))->row()->consignee_id;


        $ex_blno = $this->input->post('ex_blno_input') ;
        
        //$category_id  = $this->input->post('category_name_input') ;
        $this->tribltps->select('category_id');
        $category_id = $this->tribltps->get_where('whs_m_category',array('category_name' => $this->input->post('category_name_input'),'rec_id' => 0))->row()->category_id;

        $item_desc = $this->input->post('item_desc_input') ;
        $item_code = $this->input->post('item_code_input') ;
        
        //$location_id = $this->input->post('location_name_input') ;
        $this->tribltps->select('location_id');
        $location_id = $this->tribltps->get_where('whs_m_location',array('location_name' => $this->input->post('location_name_input'),'rec_id' => 0))->row()->location_id;

        $good_unit = $this->input->post('good_unit_input') ;
        $good_gross_weight = $this->input->post('good_gross_weight_input') ;
        $good_volume = $this->input->post('good_volume_input') ;
        $damage_unit = $this->input->post('damage_unit_input') ;
        $damage_gross_weight = $this->input->post('damage_gross_weight_input') ;
        $damage_volume = $this->input->post('damage_volume_input') ;
        $t_stock_id = $this->input->post('t_stock_id') ;

        $this->tribltps->select('batch_in');
        $batch_in = $this->tribltps->get_where('whs_t_stock_detail',array('t_stock_id' => $t_stock_id))->row()->batch_in;

        if($batch_in == ''){
            $comp = array(
                'msg' => 'Tidak',
                'pesan' => 'Error Batch In Stock Id ..!!'
            );
            echo json_encode($comp);
            die;
        }

        $this->tribltps->delete('whs_t_out_check_detail',array('kode_trans' => $kode_trans,'no_trans' => $no_trans,'bl_no' => $bl_no));

        $whs_t_out_check_detail = array(
            'kode_trans' => $kode_trans,
            'no_trans' => $no_trans,
            'bl_no' => $bl_no,
            'consignee_id' => $consignee_id,
            'seq_no' => 1,
            'ex_blno' => $ex_blno,
            'category_id' => $category_id,
            'item_desc' => $item_desc,
            'item_code' => $item_code,
            'location_id' => $location_id,
            'good_unit' => $good_unit,
            'good_gross_weight' => $good_gross_weight,
            'good_volume' => $good_volume,
            'damage_unit' => $damage_unit,
            'damage_gross_weight' => $damage_gross_weight,
            'damage_volume' => $damage_volume,
            't_stock_id' => $t_stock_id,
            'created_on' => tanggal_sekarang(),
            'created_by' => $this->session->userdata('autogate_username') ,
            'edited_on' => tanggal_sekarang(),
            'edited_by' => $this->session->userdata('autogate_username') ,
            'batch_in' => $batch_in,
            
        );

        //save data T6 Koordinator

        $savedetail = $this->m_model->savedata('tribltps', 'whs_t_out_check_detail', $whs_t_out_check_detail);

        if (!$savedetail >= 1) {
            $comp = array(
                'msg' => 'Tidak',
                'pesan' => 'Error Insert Data whs_t_out_check_detail ..!!'
            );
            echo json_encode($comp);
            die;
        }

        //end save data T6 Koordinator


        $comp = array(
            'msg' => 'Ya',
            'whs_t_out_check' => $whs_t_out_check,
            'whs_t_out_check_detail' => $whs_t_out_check_detail,
            'pesan' => 'Update Data Sukses ..!!'
        );

        echo json_encode($comp);
    }

    function c_delete(){
        $kode_trans = $this->input->post('kode_trans');
        $no_trans = $this->input->post('no_trans');
        $do_no = $this->input->post('do_no');

        $this->tribltps->select('vehicle_no');
        $vehicle_no = $this->tribltps->get_where('whs_t_out_check',
            array('kode_trans' => $kode_trans,'no_trans' => $no_trans , 'do_no' => $do_no ,'rec_id' => 0))->row()->vehicle_no;

        $this->tribltps->select('tgl_out');
        $tgl_out = $this->tribltps->get_where('whs_t_out_check',
            array('kode_trans' => $kode_trans,'no_trans' => $no_trans , 'do_no' => $do_no ,'rec_id' => 0))->row()->tgl_out;

        //ceking data sudah out dari stock
        $this->tribltps->where(array('do_no' => $do_no,'vehicle_no' => $vehicle_no,'tgl_out' => $tgl_out));
        $count_delete = $this->tribltps->get('whs_t_out')->num_rows();
        if($count_delete > 0){
            $comp = array(
                'msg' => 'Tidak',
                'pesan' => 'Data Tidak Bisa Dihapus Karena Sudah Keluar Dari Stock ..!!'
            );
            echo json_encode($comp);
            die;
        }
        //ceking data sudah out dari stock        

        $where = array(
            'kode_trans' => $kode_trans,
            'no_trans' => $no_trans
        );

        $dataupdate = array(
            'rec_id' => 9,
            'edited_on' => tanggal_sekarang(),
            'edited_by' => $this->session->userdata('autogate_username') ,
        );

        $update_header = $this->m_model->updatedata('tribltps','whs_t_out_check',$dataupdate,$where) ;

        if (!$update_header >= 1) {
            $comp = array(
                'msg' => 'Tidak',
                'pesan' => 'Error Delete Data whs_t_out_check ..!!'
            );
            echo json_encode($comp);
            die;
        }

        $update_detail = $this->m_model->updatedata('tribltps','whs_t_out_check_detail',$dataupdate,$where) ;

        if (!$update_detail >= 1) {
            $comp = array(
                'msg' => 'Tidak',
                'pesan' => 'Error Delete Data whs_t_out_check ..!!'
            );
            echo json_encode($comp);
            die;
        }


        $comp = array(
            'msg' => 'Ya',
            'pesan' => 'Hapus Data Sukses ..!!'
        );

        echo json_encode($comp);

    }

}