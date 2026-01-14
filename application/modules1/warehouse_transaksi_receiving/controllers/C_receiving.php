<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_receiving extends CI_Controller {

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

        // echo FCPATH.'/assets/image/logo_PTMBA.png';
        // die;

        $menu_active = $this->m_model->menu_active();

        $startdate = date('m-Y') ;
        $enddate = date('d-m-Y') ;

        $arraydata = array('' => 'ALL','T1'=> 'Koordinator', 'T2' => 'Tally','T3' => 'YC');
        $kode_trans = ComboNonDb($arraydata, 'kode_trans', '', 'form-control form-control-sm');

        $arraydata = $this->tribltps->query("SELECT DISTINCT bl_no 'bl_no',bl_no 'bl_no1'  FROM whs_t_in_check_detail a 
            inner join whs_t_in_check b ON a.kode_trans = b.kode_trans AND a.no_trans = b.no_trans 
            WHERE a.rec_id = '0'  AND tgl_in >= '".date('Y-m')."-01' AND tgl_in <= '".date('Y-m-d')."' ORDER BY bl_no ")->result_array();
        array_push($arraydata, array('bl_no' => '' , 'bl_no1' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'bl_no', 'class' => 'selectpicker'),
        );
        $bl_no = ComboDb($createcombo);

        $arraydata = $this->tribltps->query(" SELECT DISTINCT a.shipper_id,shipper_name  FROM whs_t_in_check a 
            INNER JOIN whs_m_shipper b ON a.shipper_id = b.shipper_id  
            WHERE a.rec_id = '0' AND tgl_in >= '".date('Y-m')."-01' AND tgl_in <= '".date('Y-m-d')."' ORDER BY shipper_name  ")->result_array();
        array_push($arraydata, array('shipper_id' => '' , 'shipper_name' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'shipper_id', 'class' => 'selectpicker'),
        );
        $shipper_id = ComboDb($createcombo);

        $arraydata = $this->tribltps->query(" SELECT DISTINCT a.consignee_id,consignee_name
             FROM whs_t_in_check_detail a 
             INNER JOIN whs_m_consignee b ON a.consignee_id = b.consignee_id  
             INNER JOIN whs_t_in_check c ON a.kode_trans = c.kode_trans AND a.no_trans = c.no_trans 
             WHERE c.rec_id = '0' AND a.rec_id = '0' AND tgl_in >= '".date('Y-m')."-01' AND tgl_in <= '".date('Y-m-d')."' ORDER BY consignee_name ")->result_array();
        array_push($arraydata, array('consignee_id' => '' , 'consignee_name' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'consignee_id', 'class' => 'selectpicker'),
        );
        $consignee_id = ComboDb($createcombo);      


        $arraydata = $this->tribltps->query(" SELECT DISTINCT cont_no,cont_no 'Container' FROM whs_t_in_check
             WHERE rec_id = '0' AND tgl_in >= '".date('Y-m')."-01' AND tgl_in <= '".date('Y-m-d')."' ORDER BY cont_no ")->result_array();
        array_push($arraydata, array('cont_no' => '' , 'Container' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'cont_no', 'class' => 'selectpicker'),
        );
        $cont_no = ComboDb($createcombo);   


        $arraydata = $this->tribltps->query(" SELECT DISTINCT do_no,do_no 'do_no1' FROM whs_t_in_check
             WHERE rec_id = '0' AND tgl_in >= '".date('Y-m')."-01' AND tgl_in <= '".date('Y-m-d')."' ORDER BY do_no ")->result_array();
        array_push($arraydata, array('do_no' => '' , 'do_no1' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'do_no', 'class' => 'selectpicker'),
        );
        $do_no = ComboDb($createcombo);  

        
        $query = " SELECT DISTINCT a.vessel_id,concat(a.vessel_name,' ',a.vessel_voyage) 'vessel_name'  
            FROM whs_m_vessel a
            INNER JOIN whs_t_in_check b on a.vessel_id=b.vessel_id
            WHERE a.rec_id = '0' and b.rec_id = '0' AND b.tgl_in >= '".date('Y-m')."-01' AND b.tgl_in <= '".date('Y-m-d')."' ORDER BY a.vessel_name " ;

        $arraydata = $this->tribltps->query($query)->result_array();
        array_push($arraydata, array('vessel_id' => '' , 'vessel_name' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'vessel_id', 'class' => 'selectpicker'),
        );
        $vessel_id = ComboDb($createcombo);

        $arraydata = array('Ya' => 'Ya', 'No' => 'No');
        $stripping = ComboNonDb($arraydata, 'stripping', 'No', 'form-control form-control-sm');


        $query = " SELECT DISTINCT CONCAT(a.kode_trans,a.no_trans) 'kode',
            CONCAT(a.kode_trans,a.no_trans) 'kode1' from whs_t_in_check a 
            INNER JOIN whs_t_in_check_detail b 
            on a.kode_trans=b.kode_trans and a.no_trans=b.no_trans
            where a.rec_id=0 and b.rec_id=0 AND a.tgl_in >= '".date('Y-m')."-01' AND a.tgl_in <= '".date('Y-m-d')."' " ;
        $arraydata = $this->tribltps->query($query)->result_array();
        array_push($arraydata, array('kode' => '' , 'kode1' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'no_transaksi', 'class' => 'selectpicker'),
        );
        $no_transaksi = ComboDb($createcombo);    

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'startdate' => "01-$startdate" ,
            'enddate' => $enddate,
            'no_transaksi' => $no_transaksi,
            'bl_no' => $bl_no,
            'shipper_id' => $shipper_id,
            'consignee_id' => $consignee_id,
            'cont_no' => $cont_no,
            'do_no' => $do_no,
            'kode_trans' => $kode_trans,
            // 'vehicle_no' => $vehicle_no,
            'vessel_id' => $vessel_id,
            // 'do_no' => $do_no,
            'stripping' => $stripping
        );
        $this->load->view('dashboard/index', $data);

    }

    function c_refresh_combo(){
        $tgl_in = date_db($this->input->post('tgl_in')) ;
        $tgl_in_end = date_db($this->input->post('tgl_in_end')) ;

        

        $data_bl = $this->tribltps->query("SELECT DISTINCT bl_no 'id',bl_no 'name'  FROM whs_t_in_check_detail a 
            inner join whs_t_in_check b ON a.kode_trans = b.kode_trans AND a.no_trans = b.no_trans 
            WHERE a.rec_id = '0'  AND tgl_in >= '".$tgl_in."' AND tgl_in <= '".$tgl_in_end."' ORDER BY bl_no ")->result_array();
        array_push($data_bl, array('id' => '' , 'name' => 'ALL'));


        $data_shipper = $this->tribltps->query(" SELECT DISTINCT a.shipper_id,shipper_name  FROM whs_t_in_check a 
            INNER JOIN whs_m_shipper b ON a.shipper_id = b.shipper_id  
            WHERE a.rec_id = '0' AND tgl_in >= '".$tgl_in."' AND tgl_in <= '".$tgl_in_end."' ORDER BY shipper_name  ")->result_array();
        array_push($data_shipper, array('shipper_id' => '' , 'shipper_name' => 'ALL'));


        $data_consignee = $this->tribltps->query(" SELECT DISTINCT a.consignee_id,consignee_name
             FROM whs_t_in_check_detail a 
             INNER JOIN whs_m_consignee b ON a.consignee_id = b.consignee_id  
             INNER JOIN whs_t_in_check c ON a.kode_trans = c.kode_trans AND a.no_trans = c.no_trans 
             WHERE c.rec_id = '0' AND a.rec_id = '0' AND tgl_in >= '".$tgl_in."' AND tgl_in <= '".$tgl_in_end."' ORDER BY consignee_name ")->result_array();
        array_push($data_consignee, array('consignee_id' => '' , 'consignee_name' => 'ALL'));

        $data_contno = $this->tribltps->query(" SELECT DISTINCT cont_no,cont_no 'Container' FROM whs_t_in_check
            WHERE rec_id = '0' AND tgl_in >= '".$tgl_in."' AND tgl_in <= '".$tgl_in_end."' ORDER BY cont_no ")->result_array();
        array_push($data_contno, array('cont_no' => '' , 'Container' => 'ALL'));

        $data_do_no = $this->tribltps->query(" SELECT DISTINCT do_no,do_no 'do_no1' FROM whs_t_in_check
            WHERE rec_id = '0' AND tgl_in >= '".$tgl_in."' AND tgl_in <= '".$tgl_in_end."' ORDER BY do_no ")->result_array();
        array_push($data_do_no, array('do_no' => '' , 'do_no1' => 'ALL'));


        $query = " SELECT DISTINCT a.vessel_id,concat(a.vessel_name,' ',a.vessel_voyage) 'vessel_name'  
            FROM whs_m_vessel a
            INNER JOIN whs_t_in_check b on a.vessel_id=b.vessel_id
            WHERE a.rec_id = '0' and b.rec_id = '0' AND b.tgl_in >= '".$tgl_in."' AND b.tgl_in <= '".$tgl_in_end."' ORDER BY a.vessel_name " ;
        $data_vessel = $this->tribltps->query($query)->result_array();
        array_push($data_vessel, array('vessel_id' => '' , 'vessel_name' => 'ALL'));


        $query = " SELECT DISTINCT CONCAT(a.kode_trans,a.no_trans) 'kode',
            CONCAT(a.kode_trans,a.no_trans) 'kode1' from whs_t_in_check a 
            INNER JOIN whs_t_in_check_detail b 
            on a.kode_trans=b.kode_trans and a.no_trans=b.no_trans
            where a.rec_id=0 and b.rec_id=0 AND a.tgl_in >= '".$tgl_in."' AND a.tgl_in <= '".$tgl_in_end."'  " ;
        $data_no_transaksi = $this->tribltps->query($query)->result_array();
        array_push($data_no_transaksi, array('kode' => '' , 'kode1' => 'ALL'));

        $comp = array(
            'bl_no' => $this->m_model->array_tag_on_index(array_reverse($data_bl,false)),
            'shipper_id' => $this->m_model->array_tag_on_index(array_reverse($data_shipper,false)),
            'consignee_id' => $this->m_model->array_tag_on_index(array_reverse($data_consignee,false)),
            'cont_no' => $this->m_model->array_tag_on_index(array_reverse($data_contno,false)),
            'do_no' => $this->m_model->array_tag_on_index(array_reverse($data_do_no,false)),
            'no_transaksi' => $this->m_model->array_tag_on_index(array_reverse($data_no_transaksi,false)),
            'vessel_id' => $this->m_model->array_tag_on_index(array_reverse($data_vessel,false)),
        );        
        echo json_encode($comp);
    }

    function tbl_whsin_receiving(){
        
        $tgl_in = date_db($this->input->post('tgl_in')) ;
        $tgl_in_end = date_db($this->input->post('tgl_in_end')) ;
        $bl_no = $this->input->post('bl_no') ;
        $shipper_id = $this->input->post('shipper_id') ;
        $consignee_id = $this->input->post('consignee_id') ;
        $cont_no = $this->input->post('cont_no') ;
        $vessel_id = $this->input->post('vessel_id') ;
        $do_no = $this->input->post('do_no') ;
        $no_transaksi = $this->input->post('no_transaksi') ;
        $stripping = $this->input->post('stripping') ;
        $kode_trans = $this->input->post('kode_trans') ;
 

        $query= " " ;
        $query.= " SELECT DISTINCT a.kode_trans 'Kode',a.no_trans 'Nomor', " ;
        $query.= " do_no 'No. DO',DATE_FORMAT(tgl_tiba,'%d-%m-%Y') as 'Tanggal Tiba', " ;
        $query.= " DATE_FORMAT(tgl_in,'%d-%m-%Y') as  'Tanggal Masuk', " ;
        $query.= " date_format(time_in,'%H:%i') 'Jam Masuk',vessel_name 'Nama Vessel', " ;
        $query.= " shipper_Name 'Nama Shipper',vehicle_no 'No. Mobill',Destination, " ;
        $query.= " CONVERT(CONCAT(cont_no,' ',tipe,' ',ukuran) USING UTF8) 'No. Cont', " ;
        $query.= " seal_no 'Seal Number',DATE_FORMAT(start_loading,'%d-%m-%Y %H:%i')  'start_loading', " ;
        $query.= " ifnull(DATE_FORMAT(finish_loading,'%d-%m-%Y %H:%i'),'') 'finish_loading', " ;
        $query.= " a.Remarks,ifnull(DATE_FORMAT(tgl_master_mbl,'%d-%m-%Y'),'') 'Tgl. M B/L' " ;
        $query.= " From whs_t_in_check a " ;
        $query.= " INNER JOIN whs_m_vessel b ON a.vessel_id = b.vessel_id " ;
        $query.= " INNER JOIN whs_m_shipper c ON a.shipper_id = c.shipper_id " ;
        $query.= " LEFT JOIN whs_t_in_check_detail d ON a.kode_trans = d.kode_trans  AND a.no_trans = d.no_trans " ;
        $query.= " WHERE a.rec_id = '0'  AND tgl_in >= '".$tgl_in."' AND tgl_in <= '".$tgl_in_end."' " ;
        
        if($kode_trans != ""){
            $query.= " and a.kode_trans='".$kode_trans."' " ;
        }

        if($bl_no != ""){
            $query.= " and d.bl_no='".$bl_no."' " ;
        }

        if($shipper_id != ""){
            $query.= " and a.shipper_id='".$shipper_id."' " ;
        }

        if($consignee_id != ""){
            $query.= " and d.consignee_id='".$consignee_id."' " ;
        }

        if($cont_no != ""){
            $query.= " and a.cont_no='".$cont_no."' " ;
        }

        if($vessel_id != ""){
            $query.= " and a.vessel_id='".$vessel_id."' " ;
        }

        if($do_no != ""){
            $query.= " and a.do_no='".$do_no."' " ;
        }

        if($no_transaksi != ""){
            $query.= " and CONCAT(a.kode_trans,a.no_trans)='".$no_transaksi."' " ;
        }

        if($stripping == "Ya"){
            $query.= " NOT EXISTS( SELECT * FROM whs_t_in_check WHERE kode_trans = 'T3' AND cont_no = a.cont_no AND do_no = a.do_no ) AND a.kode_trans <> '' " ;
        }

        $query.= " ORDER BY do_no,cont_no,a.kode_trans " ;
        $data = $this->tribltps->query($query);

        $comp = array(
            'jml' => $data->num_rows(),
            'isidata' => $this->m_model->array_tag_on_index($data->result_array()),
            'query' => $query
        );        
        echo json_encode($comp);
    }

    function tbl_whsin_receiving_detail(){
        $kode_trans = $this->input->post('kode_trans') ;
        $no_trans = $this->input->post('no_trans') ;
 

        $query= " " ;
        $query.= " SELECT bl_no 'No. BL',DATE_FORMAT(tgl_bl,'%d-%m-%Y') as 'Tgl BL',a.consignee_id, " ;
        $query.= " consignee_name 'Nama Consignee',  seq_no, a.category_id, mark as 'BL Mark', " ;
        $query.= " item_desc 'Deskripsi Item' ,a.location_id,category_name 'Category', good_unit 'Good', " ;
        $query.= " good_gross_weight 'Good GW', good_volume 'Good Volume',  damage_unit 'Damage', " ;
        $query.= " damage_gross_weight 'Damage GW', damage_volume 'Damage Volume' , " ;
        $query.= " palet_id 'Palet ID',item_code 'Code Item', IFNULL(location_name,'') 'Lokasi', " ;
        $query.= " a.id_charge,nm_charge 'Surcharge', IFNULL(remarks,'') 'Remarks',a.created_by 'User', " ;
        $query.= " CONVERT(a.created_on USING UTF8) 'created_on'  " ;
        $query.= " FROM whs_t_in_check_detail a  " ;
        $query.= " INNER JOIN whs_m_category b ON  a.category_id = b.category_id " ;
        $query.= " INNER JOIN whs_m_consignee c ON a.consignee_id = c.consignee_id " ;
        $query.= " LEFT JOIN whs_m_location d ON a.location_id = d.location_id  " ;
        $query.= " LEFT JOIN whs_m_surcharge e ON a.id_charge = e.id_charge  " ;
        $query.= " WHERE a.rec_id = '0' AND kode_trans = '".$kode_trans."' " ;
        $query.= " AND no_trans = '".$no_trans."'  " ;
        $query.= " order by seq_no " ;


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
        $sql.= " FROM whs_t_in_check_detail a  " ;
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


    function c_export_data(){
        
        

        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);
        $tgl_in = date_db($data[0]) ;
        $tgl_in_end = date_db($data[1]) ;

        $query = " SELECT tgl_in,shipper_name,cont_no,CONCAT(ukuran,' ',tipe) 'Tipe',do_no,  " ;
        $query.= " (SELECT COUNT(*) FROM whs_t_in_check_detail " ;
        $query.= " WHERE kode_trans = a.kode_trans AND no_trans = a.no_trans) 'QTY B/L',  " ;
        $query.= " (SELECT IFNULL(CREATED_BY,'') " ;
        $query.= " FROM whs_t_in_check WHERE rec_id = '0' AND do_no = a.do_no " ;
        $query.= " AND cont_no = a.cont_no and kode_trans = 'T2' LIMIT 0,1) 'Taly',  " ;
        $query.= " (SELECT IFNULL(CREATED_BY,'') " ;
        $query.= " FROM whs_t_in_check WHERE rec_id = '0' AND do_no = a.do_no " ;
        $query.= " AND cont_no = a.cont_no and kode_trans = 'T3' LIMIT 0,1) 'YC',  " ;
        $query.= " CASE WHEN (SELECT COUNT(DISTINCT bl_no) " ;
        $query.= " FROM whs_t_in_detail x " ;
        $query.= " INNER JOIN whs_t_in y ON x.batch_in = y.batch_in  " ;
        $query.= " WHERE do_no = a.do_no AND cont_no = a.cont_no) = (SELECT COUNT(*) " ;
        $query.= " FROM whs_t_in_check_detail WHERE kode_trans = a.kode_trans AND no_trans = a.no_trans) " ;
        $query.= " THEN  'Sudah Diprint' ELSE 'Belum Diprint' END AS 'Printed'  " ;
        $query.= " FROM whs_t_in_check a " ;
        $query.= " INNER JOIN whs_m_shipper b ON a.shipper_id = b.shipper_id  " ;
        $query.= " where tgl_in >= '".$tgl_in."' AND tgl_in <= '".$tgl_in_end."' " ;
        $query.= " and kode_trans = 'T1' and a.rec_id = '0' ORDER BY shipper_name " ;
        $query.= " ,CONCAT(ukuran,' ',tipe),cont_no, CASE WHEN (SELECT COUNT(DISTINCT bl_no) " ;
        $query.= " FROM whs_t_in_detail x " ;
        $query.= " INNER JOIN whs_t_in y ON x.batch_in = y.batch_in  " ;
        $query.= " WHERE do_no = a.do_no AND cont_no = a.cont_no) = (SELECT COUNT(*) " ;
        $query.= " FROM whs_t_in_check_detail " ;
        $query.= " WHERE kode_trans = a.kode_trans AND no_trans = a.no_trans) THEN  'Sudah Diprint' " ;
        $query.= " ELSE 'Belum Diprint' END Desc " ;

        $dataExcute = $this->tribltps->query($query);

        if($dataExcute->num_rows() == 0){
            echo "Data Tidak Ada ..!!" ;die;
        }

        $spreadsheet = new Spreadsheet();

        $writer = new Xlsx($spreadsheet);

        $spreadsheet->createSheet();

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle("Receiving");
        $sheet = $spreadsheet->getActiveSheet();

        $baris = 1 ;
        $sheet->setCellValueByColumnAndRow(1, $baris, "Receiving");
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle("A1")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A1")->getFont()->setSize(18);

        $baris++;
        $sheet->setCellValueByColumnAndRow(1, $baris, "Tanggal ".showdate_dmy_excel($data[0])." s/d ".showdate_dmy_excel($data[1]));
        $sheet->mergeCells('A2:J2');
        $sheet->getStyle("A2")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setSize(16);

        $baris = $baris + 2;
        $kolom = 1 ;
        $kolom_number = array('A','B','C','D','E','F','G','H','I','J');
        $kolom_judul = array("No","Tanggal","Forwarder / PBM","No Kontainer","Tipe","M B/L","Qty B/L","Tally","YC","Print Out");
        for($a=0 ; $a<count($kolom_judul) ; $a++){
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $kolom_judul[$a]);
            //$sheet->getStyle($kolom_number[$a] . $baris)->applyFromArray($this->m_model->styleHeader()) ;

            $sheet->getStyle($kolom_number[$a].$baris)->applyFromArray($this->m_model->styleHeader());

            $sheet->getStyle($kolom_number[$a].$baris)->getFont()->setBold(true);

            $sheet->getStyle($kolom_number[$a].$baris)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1e366c');

            $sheet->getStyle($kolom_number[$a].$baris)->getFont()
            ->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

            $kolom++;
        }

        $baris++;        
        $nomor = 1 ;        
        $first_position = "" ;
        $last_position = "" ;
        foreach($dataExcute->result_array() as $isiexcel){

            $kolom = 1 ; $index = 0 ;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, (string)$nomor);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;
            

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, showdate_dmybc($isiexcel['tgl_in']));
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleDate()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['shipper_name']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['cont_no']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['Tipe']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['do_no']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['QTY B/L']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['Taly']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['YC']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['Printed']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $baris++; $nomor++;
        }

        $kolom = 1 ;
        for($c = 0 ; $c < count($kolom_number) ; $c++ ){
            $sheet->getColumnDimensionByColumn($kolom)->setAutoSize(true);
            $kolom++;
        }




        $nama_excel = "Receiving_" ;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $nama_excel.date_ymdhis(date("Y-m-d H:i:s")). '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');




    }

    function c_export_bahandle(){

        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);
        $tgl_in = date_db($data[0]) ;
        $tgl_in_end = date_db($data[1]) ;


        $query = " SELECT DISTINCT CONVERT(CONCAT(LEFT(b.cont_no,4),' ',RIGHT(b.cont_no,7)) USING UTF8) 'Cont' , " ;
        $query.= " CONVERT(CASE b.ukuran when '20' then '1' else '' end USING UTF8) '20feet' ,  " ;
        $query.= " CONVERT(CASE b.ukuran when '40' then '1' else '' end USING UTF8) '40feet' ,  " ;
        $query.= " consignee_name,a.bl_no,CONVERT(CONCAT(e.good_unit,' ',category_kode) USING UTF8) 'colly', " ;
        $query.= " CONVERT(DATE_FORMAT(bahandle_on,'%d/%m/%Y') USING UTF8) 'tglbahandle', " ;
        $query.= " CONVERT(IFNULL(tgl_out,'') USING UTF8) 'tglout','' " ;
        $query.= " FROM whs_vw_bahandle a " ;
        $query.= " INNER JOIN whs_t_in b ON a.batch_in = b.batch_in " ;
        $query.= " INNER JOIN whs_m_consignee c ON a.consignee_id = c.consignee_id " ;
        $query.= " INNER JOIN whs_m_category d ON a.category_id = d.category_id " ;
        $query.= " INNER JOIN whs_t_in_check_detail e ON a.item_code = e.item_code " ;
        $query.= " LEFT JOIN ( whs_t_out_detail f " ;
        $query.= " INNER JOIN whs_t_out g ON f.batch_out = g.batch_out) ON a.item_code = f.item_code " ;
        $query.= " WHERE flag_bahandle = 'Y' " ;
        $query.= " AND bahandle_on BETWEEN '".$tgl_in."' AND '".$tgl_in_end."' " ;
        $query.= " AND e.kode_trans = 'T1' AND e.rec_id = '0'" ;


        $dataExcute = $this->tribltps->query($query);

        if($dataExcute->num_rows() == 0){
            echo "Data Tidak Ada ..!!" ;die;
        }

        $spreadsheet = new Spreadsheet();

        $writer = new Xlsx($spreadsheet);

        $spreadsheet->createSheet();

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle("Bahandle");
        $sheet = $spreadsheet->getActiveSheet();

        $baris = 1 ;
        $sheet->setCellValueByColumnAndRow(1, $baris, "LAPORAN BAHANDEL PT.MULTI BINTANG ABADI");        
        // $sheet->getStyle("A1")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
        $sheet->getStyle("A1:J2")->getFont()->setBold(true);
        $sheet->getStyle("A1:J2")->getFont()->setSize(14);
        $sheet->mergeCells('A1:J2');
        $sheet->getStyle('A1:J2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:J2')->getAlignment()->setVertical('center');

        // $baris++;
        // $sheet->setCellValueByColumnAndRow(1, $baris, "Tanggal ".showdate_dmy_excel($data[0])." s/d ".showdate_dmy_excel($data[1]));
        // $sheet->mergeCells('A2:J2');
        // $sheet->getStyle("A2")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
        // $sheet->getStyle("A2")->getFont()->setBold(true);
        // $sheet->getStyle("A2")->getFont()->setSize(16);

        $baris = $baris + 2;
        $kolom = 1 ;
        $kolom_number = array('A','B','C','D','E','F','G','H','I','J');
        $kolom_judul = array("No","EX CONTAINER","","","CONSIGNEE","NO. BL","COLLY","TANGGAL","","KETERANGAN");
        for($a=0 ; $a<count($kolom_judul) ; $a++){
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $kolom_judul[$a]);
            //$sheet->getStyle($kolom_number[$a] . $baris)->applyFromArray($this->m_model->styleHeader()) ;

            $sheet->getStyle($kolom_number[$a].$baris)->applyFromArray($this->m_model->styleHeader());

            $sheet->getStyle($kolom_number[$a].$baris)->getFont()->setBold(true);

            $sheet->getStyle($kolom_number[$a].$baris)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');

            $kolom++;
        }

        $baris++;
        $kolom = 1 ;
        $kolom_judul = array("","NO","20","40","","","","BAHANDEL","KELUAR","");
        for($a=0 ; $a<count($kolom_judul) ; $a++){
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $kolom_judul[$a]);
            //$sheet->getStyle($kolom_number[$a] . $baris)->applyFromArray($this->m_model->styleHeader()) ;

            $sheet->getStyle($kolom_number[$a].$baris)->applyFromArray($this->m_model->styleHeader());

            $sheet->getStyle($kolom_number[$a].$baris)->getFont()->setBold(true);

            $sheet->getStyle($kolom_number[$a].$baris)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');

            $kolom++;
        }

        $sheet->mergeCells('B3:D3'); //EX KONTAINER
        $sheet->mergeCells('E3:E4'); //CONSIGNEE
        $sheet->mergeCells('F3:F4'); //NO BL
        $sheet->mergeCells('G3:G4'); //COLLY
        $sheet->mergeCells('H3:I3'); //TANGGAL
        $sheet->mergeCells('J3:J4'); //TANGGAL
        $sheet->mergeCells('A3:A4'); //NOMOR



        $baris = $baris+2 ;        
        $nomor = 1 ;        
        $first_position = "" ;
        $last_position = "" ;
        foreach($dataExcute->result_array() as $isiexcel){

            $kolom = 1 ; $index = 0 ;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, (string)$nomor);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;
            

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['Cont']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['20feet']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['40feet']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['consignee_name']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['bl_no']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['colly']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, showdate_dmybc($isiexcel['tglbahandle']));
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleDate()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, showdate_dmybc($isiexcel['tglout']));
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleDate()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, "");
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $baris++; $nomor++;
        }

        $kolom = 1 ;
        for($c = 0 ; $c < count($kolom_number) ; $c++ ){
            $sheet->getColumnDimensionByColumn($kolom)->setAutoSize(true);
            $kolom++;
        }




        $nama_excel = "Bahandle_" ;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $nama_excel.date_ymdhis(date("Y-m-d H:i:s")). '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    function c_export_tally(){
        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);
        $tgl_in = date_db($data[0]) ;
        $tgl_in_end = date_db($data[1]) ;
        $cont_no = $data[2] ;
 

        $query = " SELECT a.cont_no 'nocontainer',c.shipper_name,b.vessel_name,b.vessel_voyage,'' as 'call_sign',date_format(a.tgl_tiba,'%d-%m-%Y') as 'tgl_tiba', " ;
        $query.= " do_no,date_format(tgl_master_mbl,'%d-%m-%Y') as 'tgl_master_mbl','' as 'nobc11' , '' as 'tglbc11', " ;
        $query.= " concat(a.cont_no,'/',a.ukuran) as 'nocont','' as 'noplp', '' as 'tglplp',date_format(tgl_in,'%d-%m-%Y') as 'date_loading',  " ;
        $query.= " date_format(start_loading,'%d-%m-%Y %h:%i:%s') as 'start_loading',  date_format(finish_loading,'%d-%m-%Y %h:%i:%s') as 'finish_loading' " ;
        $query.= " from whs_t_in_check a " ;
        $query.= " INNER JOIN whs_m_vessel b on a.vessel_id=b.vessel_id  " ;
        $query.= " INNER JOIN whs_m_shipper c on a.shipper_id=c.shipper_id " ;
        $query.= " INNER JOIN whs_t_in_check_detail d on a.kode_trans=d.kode_trans and a.no_trans=d.no_trans " ;
        $query.= " INNER JOIN whs_m_category e on d.category_id=e.category_id " ;
        $query.= " INNER JOIN whs_m_consignee f on d.consignee_id=f.consignee_id " ;
        $query.= " INNER JOIN whs_m_location g on d.location_id=g.location_id " ;
        $query.= " where a.rec_id=0 and d.rec_id=0  " ;
        $query.= " and a.tgl_in >='".$tgl_in."' and a.tgl_in<='".$tgl_in_end."' " ;
        $query.= " and a.cont_no ='".$cont_no."' and a.kode_trans='T3' " ;
        $query.= " ORDER BY d.seq_no " ;


        $dataHead = $this->tribltps->query($query);

        if($dataHead->num_rows() == 0){
            echo "Data Tidak Ada ..!!" ;die;
        }

        $header = $this->m_model->query_to_tag($query,'tribltps');
    
        $querymbl = " SELECT DISTINCT a.tgl_master_mbl from whs_t_permohonan_head a 
            INNER JOIN whs_t_permohonan_det b on a.id=b.id
            where a.no_mbl='".$header['do_no']."' and b.cont_no='".$header['nocontainer']."' " ;
        $headermbl = $this->m_model->query_to_tag($querymbl,'tribltps');
        // print_r($querymbl);
        // die;
         

        $query = " SELECT d.item_code,'' as 'posbc11',d.bl_no,date_format(d.tgl_bl,'%d-%m-%Y') as 'tgl_bl', " ;
        $query.= " f.consignee_name,d.item_desc, d.good_unit as 'party',h.category_kode,d.good_volume,d.good_gross_weight, " ; 
        $query.= " a.start_loading,a.finish_loading,'' as 'good','' as 'damage',g.location_name,d.remarks " ;
        $query.= " from whs_t_in_check a " ;
        $query.= " INNER JOIN whs_m_vessel b on a.vessel_id=b.vessel_id " ;       
        $query.= " INNER JOIN whs_m_shipper c on a.shipper_id=c.shipper_id " ;
        $query.= " INNER JOIN whs_t_in_check_detail d on a.kode_trans=d.kode_trans and a.no_trans=d.no_trans " ;
        $query.= " INNER JOIN whs_m_category e on d.category_id=e.category_id " ;
        $query.= " INNER JOIN whs_m_consignee f on d.consignee_id=f.consignee_id " ;
        $query.= " INNER JOIN whs_m_location g on d.location_id=g.location_id " ;
        $query.= " INNER JOIN whs_m_category h on d.category_id = h.category_id " ;
        $query.= " where a.rec_id=0 and d.rec_id=0  and a.cont_no ='".$cont_no."' " ;
        $query.= " and a.tgl_in >='".$tgl_in."' and a.tgl_in<='".$tgl_in_end."' " ;
        $query.= " ORDER BY d.seq_no " ;
        $dataExcute = $this->tribltps->query($query);

        $spreadsheet = new Spreadsheet();

        $writer = new Xlsx($spreadsheet);

        $spreadsheet->createSheet();

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle("Tally");
        $sheet = $spreadsheet->getActiveSheet();

        
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $image = FCPATH.'/assets/image/logo_PTMBA.png' ;
        $drawing->setPath($image); 
        $drawing->setCoordinates('A1');
        $drawing->setHeight(60);
        $drawing->setOffsetX(40);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());
        $sheet->mergeCells('A1:B3');

        $baris = 1 ;
        $sheet->setCellValueByColumnAndRow(3, $baris, "PT.MULTI BINTANG ABADI"); 
        $sheet->mergeCells('C1:E3');       
        $sheet->getStyle("C1:E3")->getFont()->setBold(true);
        $sheet->getStyle("C1:E3")->getFont()->setSize(12);        
        // $sheet->getStyle('C1:E3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('C1:E3')->getAlignment()->setVertical('center');


        $sheet->setCellValueByColumnAndRow(6, $baris+1, "RECEIVING FORM"); 
        $sheet->mergeCells('F2:I4');       
        $sheet->getStyle("F2:I4")->getFont()->setBold(true);
        $sheet->getStyle("F2:I4")->getFont()->setSize(12);        
        $sheet->getStyle('F2:I4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F2:I4')->getAlignment()->setVertical('center');


        $baris = $baris + 5 ;
        $sheet->setCellValueByColumnAndRow(1, $baris, "Nomor"); 
        $sheet->setCellValueByColumnAndRow(2, $baris, ": "); 

        $sheet->setCellValueByColumnAndRow(6, $baris, "NO.MASTER BL"); 
        $sheet->setCellValueByColumnAndRow(7, $baris, ": ".$header['do_no']); 

        $sheet->setCellValueByColumnAndRow(11, $baris, "DATE LOADING"); 
        $sheet->setCellValueByColumnAndRow(12, $baris, ": ".showdate_dmybc($header['date_loading'])); 

        //===========================================================================
        $baris++;
        $sheet->setCellValueByColumnAndRow(1, $baris, "FORWARDER"); 
        $sheet->setCellValueByColumnAndRow(2, $baris, ": ".$header['shipper_name']); 

        $sheet->setCellValueByColumnAndRow(6, $baris, "TGL MASTER BL"); 
        $sheet->setCellValueByColumnAndRow(7, $baris, ": ".showdate_dmybc($headermbl['tgl_master_mbl'])); 
        //============================================================================
        $baris++;
        $sheet->setCellValueByColumnAndRow(1, $baris, "VESSEL"); 
        $sheet->setCellValueByColumnAndRow(2, $baris, ": ".$header['vessel_name']); 

        $sheet->setCellValueByColumnAndRow(6, $baris, "NO.BC 1.1"); 
        $sheet->setCellValueByColumnAndRow(7, $baris, ": "); 

        $sheet->setCellValueByColumnAndRow(11, $baris, "START LOADING"); 
        $sheet->setCellValueByColumnAndRow(12, $baris, ": ".showdate_dmyhis($header['start_loading'])); 
        //============================================================================
        $baris++;
        $sheet->setCellValueByColumnAndRow(1, $baris, "VOYAGE"); 
        $sheet->setCellValueByColumnAndRow(2, $baris, ": ".$header['vessel_voyage']); 

        $sheet->setCellValueByColumnAndRow(6, $baris, "TGL BC 1.1"); 
        $sheet->setCellValueByColumnAndRow(7, $baris, ": "); 
        //============================================================================
        $baris++;
        $sheet->setCellValueByColumnAndRow(1, $baris, "CALL SIGN"); 
        $sheet->setCellValueByColumnAndRow(2, $baris, ": "); 

        $sheet->setCellValueByColumnAndRow(6, $baris, "NO CONT/SIZE"); 
        $sheet->setCellValueByColumnAndRow(7, $baris, ": ".$header['nocont']); 

        $sheet->setCellValueByColumnAndRow(11, $baris, "FINISH LOADING"); 
        $sheet->setCellValueByColumnAndRow(12, $baris, ": ".showdate_dmyhis($header['finish_loading'])); 
        //============================================================================
        $baris++;
        $sheet->setCellValueByColumnAndRow(1, $baris, "TGL TIBA"); 
        $sheet->setCellValueByColumnAndRow(2, $baris, ": ".showdate_dmybc($header['tgl_tiba'])); 

        $sheet->setCellValueByColumnAndRow(6, $baris, "NO PLP"); 
        $sheet->setCellValueByColumnAndRow(7, $baris, ": "); 
        //============================================================================
        $baris++;
        $sheet->setCellValueByColumnAndRow(6, $baris, "TGL PLP"); 
        $sheet->setCellValueByColumnAndRow(7, $baris, ": "); 
        //============================================================================

        $baris = $baris + 2 ;
        $kolom = 1 ;
        $kolom_number = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q');
        $kolom_judul = array("No","CODE ITEM","POS BC1.1","B/L No","TGL B/L","CONSIGNEE","DESCRIPTION OF GOODS","PARTY","PACKING","VOL(M3)",
            "GROSS WEIGHT (TON)","TALLY","","","","","REMARK");
        for($a=0 ; $a<count($kolom_judul) ; $a++){
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $kolom_judul[$a]);
            //$sheet->getStyle($kolom_number[$a] . $baris)->applyFromArray($this->m_model->styleHeader()) ;

            $sheet->getStyle($kolom_number[$a].$baris)->applyFromArray($this->m_model->styleHeader());

            $sheet->getStyle($kolom_number[$a].$baris)->getFont()->setBold(true);

            $sheet->getStyle($kolom_number[$a].$baris)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('b9b9bf');

            $kolom++;
        }



        $baris++;
        $kolom = 1 ;
        $kolom_judul = array("","","","","","","","","","","","Time","","Condition","","Loc","");
        for($a=0 ; $a<count($kolom_judul) ; $a++){
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $kolom_judul[$a]);

            $sheet->getStyle($kolom_number[$a].$baris)->applyFromArray($this->m_model->styleHeader());

            $sheet->getStyle($kolom_number[$a].$baris)->getFont()->setBold(true);

            $sheet->getStyle($kolom_number[$a].$baris)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('b9b9bf');

            $kolom++;
        }

        $baris++;
        $kolom = 1 ;
        $kolom_judul = array("","","","","","","","","","","","Start","Finish","G","D","","");
        for($a=0 ; $a<count($kolom_judul) ; $a++){
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $kolom_judul[$a]);

            $sheet->getStyle($kolom_number[$a].$baris)->applyFromArray($this->m_model->styleHeader());

            $sheet->getStyle($kolom_number[$a].$baris)->getFont()->setBold(true);

            $sheet->getStyle($kolom_number[$a].$baris)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('b9b9bf');

            $kolom++;
        }

        $sheet->mergeCells('A14:A16'); 
        $sheet->mergeCells('B14:B16'); 
        $sheet->mergeCells('C14:C16'); 
        $sheet->mergeCells('D14:D16'); 
        $sheet->mergeCells('E14:E16'); 
        $sheet->mergeCells('F14:F16'); 
        $sheet->mergeCells('G14:G16'); 
        $sheet->mergeCells('H14:H16'); 
        $sheet->mergeCells('I14:I16'); 
        $sheet->mergeCells('J14:J16'); 
        $sheet->mergeCells('K14:K16'); 
        $sheet->mergeCells('L14:P14'); 
        $sheet->mergeCells('Q14:Q16'); 
        $sheet->mergeCells('L15:M15'); 
        $sheet->mergeCells('N15:O15'); 
        $sheet->mergeCells('P15:P16'); 

        $baris++;        
        $nomor = 1 ;        
        $first_position = "" ;
        $last_position = "" ;
        foreach($dataExcute->result_array() as $isiexcel){

            $kolom = 1 ; $index = 0 ;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, "  ".(string)$nomor);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;
            

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['item_code']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, "");
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['bl_no']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, showdate_dmybc($isiexcel['tgl_bl']));
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleDate()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['consignee_name']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['item_desc']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['party']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['category_kode']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['good_volume']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['good_gross_weight']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, showdate_dmyhis($isiexcel['start_loading']));
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleDate()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, showdate_dmyhis($isiexcel['finish_loading']));
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleDate()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['good']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['damage']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['location_name']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $kolom++; $index++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['remarks']);
            $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

            $baris++; $nomor++;
        }

        $kolom = 1 ;
        for($c = 0 ; $c < count($kolom_number) ; $c++ ){
            $sheet->getColumnDimensionByColumn($kolom)->setAutoSize(true);
            $kolom++;
        }




        $nama_excel = "Tally_" ;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $nama_excel.date_ymdhis(date("Y-m-d H:i:s")). '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    function c_formadd(){


        $arrayOperator = array('T1'=> 'Koordinator', 'T2' => 'Tally','T3' => 'YC');
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


    // function c_load_data_bl(){
    //     $txtNoDo = $this->input->post('txtNoDo') ;
    //     $flaginsert = $this->input->post('flaginsert');
    //     $sql= "" ;
    //     $sql.= " SELECT DISTINCT a.bl_no,a.consignee_id,c.consignee_name ,a.category_id,b.category_name,dd.item_desc,a.item_code, " ;
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
        

    //     $loadsql = $sql ;

    //     $data_detail = $this->tribltps->query($sql)->result_array();

    //     $sql= " " ;
    //     $sql.= " SELECT DISTINCT a.vessel_id,a.shipper_id,a.seal_no from whs_t_in_check a  " ;
    //     $sql.= " INNER JOIN whs_t_in_check_detail b  " ;
    //     $sql.= " on a.kode_trans=b.kode_trans and a.no_trans=b.no_trans " ;
    //     $sql.= " where a.rec_id=0 and b.rec_id=0 and b.bl_no='".$txtNoDo."' " ;
    //     $data_header = $this->tribltps->query($sql)->result_array();

    //     $vessel_id = "" ;
    //     $shipper_id = "" ;
    //     $seal_no = "" ;
    //     foreach($data_header as $datahead){
    //         $vessel_id = $datahead['vessel_id'] ;
    //         $shipper_id = $datahead['shipper_id'] ;
    //         $seal_no = $datahead['seal_no'] ;
    //     }


    //     $comp = array(
    //         'txtNoDo' => $txtNoDo,
    //         'isidata' => $this->m_model->array_tag_on_index($data_detail),
    //         'isidataheader' => $this->m_model->array_tag_on_index($data_detail),
    //         'sql' => $sql,
    //         'vessel_id' => $vessel_id,
    //         'shipper_id' => $shipper_id,
    //         'seal_no' => $seal_no,
    //         'tgl_load' => date('d-m-Y'),
    //         'jam_load' => date('H:i'),
    //         'loadsql' => $loadsql
    //     );        
    //     echo json_encode($comp);
    // }

    // function c_save(){
    //     $kode_trans = $this->input->post('kode_trans');
    //     $do_no = $this->input->post('txtNoDo');

    //     //cek no bl save ke table whs_t_in_check
    //     $query = " SELECT * from whs_t_in_check a 
    //         INNER JOIN whs_t_in_check_detail b on a.kode_trans=a.kode_trans and a.no_trans=b.no_trans
    //         where a.rec_id<>9 and b.rec_id=0 and b.bl_no = '".$do_no."' " ;
    //     if($this->tribltps->query($query)->num_rows() > 0){
    //         $comp = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'No Bl Ini Sudah Diinput ..!!'
    //         );
    //         echo json_encode($comp);
    //         die;
    //     }

    //     $getuser_random = " SELECT user_name FROM whs_m_users where user_name<>'".$this->session->userdata('autogate_username')."' and user_name<>'teguh' ORDER BY RAND() " ;
    //     if($this->tribltps->query($getuser_random)->num_rows() == 0){
    //         $comp = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'Error Table whs_m_users ..!!'
    //         );
    //         echo json_encode($comp);
    //         die;
    //     }


    //     $tgl_in = date_db($this->input->post('dtpOut'));
    //     $time_out = $this->input->post('txtTimeOut');
    //     $vessel_id = $this->input->post('txtVessel');
    //     $shipper_id = $this->input->post('txtShipper');
    //     $vehicle_no = $this->input->post('txtNoMobil');
    //     $destination = $this->input->post('txtDestination');
    //     $seal_no = $this->input->post('txtSealNo');
    //     $remarks = $this->input->post('txtRemarks');

    //     //cari no trans
    //     //CONVERT(LPAD(number,6,'0') USING UTF8)
    //     $select = " number " ;
    //     $where = array(
    //         'run_code' => $kode_trans,
    //         'run_year' => date('Y'),
    //     );

    //     $no_trans = $this->m_model->global_run_number('tribltps', 'whs_run_number',$select, $where);
    //     if($no_trans == ''){
    //         $comp = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'Error Running Number ..!!'
    //         );
    //         echo json_encode($comp);
    //         die;
    //     }

    //     $no_trans = date('Y')."".date('m')."".str_pad($no_trans, 6, "0", STR_PAD_LEFT) ;


    //     $whs_t_in_check = array(
    //         'kode_trans' => $kode_trans,
    //         'no_trans' => $no_trans,
    //         'do_no' => $do_no,
    //         'tgl_in' => $tgl_in,
    //         'time_out' => $time_out,
    //         'vessel_id' => $vessel_id,
    //         'shipper_id' => $shipper_id,
    //         'vehicle_no' => $vehicle_no,
    //         'destination' => $destination,
    //         'cont_no' => '-',
    //         'tipe' => '-',
    //         'ukuran' => '-',
    //         'seal_no' => $seal_no,
    //         'remarks' => $remarks,
    //         'created_on' => tanggal_sekarang(),
    //         'created_by' => $this->session->userdata('autogate_username') ,
    //         'start_unloading' => tanggal_sekarang(),
    //         'finish_unloading' => tanggal_sekarang(),
    //     );

        

    //     //data detail
    //     $bl_no = $this->input->post('bl_no_input') ;
    //     $consignee_id = explode('   idtabel : ', $this->input->post('consignee_name_input'))[1] ;
    //     $ex_blno = $this->input->post('ex_blno_input') ;
    //     $category_id  = explode('   idtabel : ', $this->input->post('category_name_input'))[1] ;
    //     $item_desc = $this->input->post('item_desc_input') ;
    //     $item_code = $this->input->post('item_code_input') ;
    //     $location_id = explode('   idtabel : ', $this->input->post('location_name_input'))[1] ;
    //     $good_unit = $this->input->post('good_unit_input') ;
    //     $good_gross_weight = $this->input->post('good_gross_weight_input') ;
    //     $good_volume = $this->input->post('good_volume_input') ;
    //     $damage_unit = $this->input->post('damage_unit_input') ;
    //     $damage_gross_weight = $this->input->post('damage_gross_weight_input') ;
    //     $damage_volume = $this->input->post('damage_volume_input') ;
    //     $t_stock_id = $this->input->post('t_stock_id') ;

    //     $this->tribltps->select('batch_in');
    //     $batch_in = $this->tribltps->get_where('whs_t_stock_detail',array('t_stock_id' => $t_stock_id))->row()->batch_in;

    //     if($batch_in == ''){
    //         $comp = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'Error Batch In Stock Id ..!!'
    //         );
    //         echo json_encode($comp);
    //         die;
    //     }

    //     $whs_t_in_check_detail = array(
    //         'kode_trans' => $kode_trans,
    //         'no_trans' => $no_trans,
    //         'bl_no' => $bl_no,
    //         'consignee_id' => $consignee_id,
    //         'seq_no' => 1,
    //         'ex_blno' => $ex_blno,
    //         'category_id' => $category_id,
    //         'item_desc' => $item_desc,
    //         'item_code' => $item_code,
    //         'location_id' => $location_id,
    //         'good_unit' => $good_unit,
    //         'good_gross_weight' => $good_gross_weight,
    //         'good_volume' => $good_volume,
    //         'damage_unit' => $damage_unit,
    //         'damage_gross_weight' => $damage_gross_weight,
    //         'damage_volume' => $damage_volume,
    //         'palet_id' => '',
    //         'remarks' => '',
    //         'jenis_doc' => '',
    //         't_stock_id' => $t_stock_id,
    //         'created_on' => tanggal_sekarang(),
    //         'created_by' => $this->session->userdata('autogate_username') ,
    //         'batch_in' => $batch_in,
            
    //     );

    //     //save data T6 Koordinator
    //     $last_min = date('Y-m-d H:i:s', strtotime('+20 minutes'));
    //     $saveheader = $this->m_model->savedata('tribltps', 'whs_t_in_check', $whs_t_in_check);
    //     $this->tribltps->update('whs_t_in_check',
    //         array('created_by' => $this->session->userdata('autogate_username'),'finish_unloading' => $last_min),
    //         array('no_trans' => $no_trans,'kode_trans' => $kode_trans)
    //     );

    //     if (!$saveheader >= 1) {
    //         $comp = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'Error Insert Data whs_t_in_check ..!!'
    //         );
    //         echo json_encode($comp);
    //         die;
    //     }

    //     $savedetail = $this->m_model->savedata('tribltps', 'whs_t_in_check_detail', $whs_t_in_check_detail);
    //     $this->tribltps->update('whs_t_in_check_detail',
    //         array('created_by' => $this->session->userdata('autogate_username')),array('no_trans' => $no_trans,'kode_trans' => $kode_trans));

    //     if (!$savedetail >= 1) {
    //         $comp = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'Error Insert Data whs_t_in_check_detail ..!!'
    //         );
    //         echo json_encode($comp);
    //         die;
    //     }

    //     //end save data T6 Koordinator



    //     //Inject data T7 dan T8
    //     $arraykodetrans = array('T7','T8');
    //     for($a=0 ; $a<count($arraykodetrans) ; $a++){

    //         $user_random = $this->tribltps->query($getuser_random)->row()->user_name ;

            
    //         $whs_t_in_check['created_by'] = $user_random ;
    //         $whs_t_in_check['kode_trans'] = $arraykodetrans[$a] ;

    //         $no_trans = $this->m_model->global_run_number('tribltps', 'whs_run_number',$select, array('run_code' => $arraykodetrans[$a],'run_year' => date('Y')));
    //         if($no_trans == ''){
    //             $comp = array(
    //                 'msg' => 'Tidak',
    //                 'pesan' => 'Error Running Number '.$arraykodetrans[$a].' ..!!'
    //             );
    //             echo json_encode($comp);
    //             die;
    //         }

    //         $no_trans = date('Y')."".date('m')."".str_pad($no_trans, 6, "0", STR_PAD_LEFT) ;

    //         $whs_t_in_check['no_trans'] = $no_trans ;
    //         $whs_t_in_check['start_unloading'] = tanggal_sekarang() ;
    //         $whs_t_in_check['finish_unloading'] = tanggal_sekarang() ;

    //         $last_min = date('Y-m-d H:i:s', strtotime('+20 minutes'));
    //         $saveheader = $this->m_model->savedata('tribltps', 'whs_t_in_check', $whs_t_in_check);
    //         $this->tribltps->update('whs_t_in_check',
    //             array('finish_unloading' => $last_min),
    //             array('no_trans' => $no_trans,'kode_trans' => $arraykodetrans[$a]));


    //         $this->tribltps->update('whs_t_in_check',
    //             array('created_by' => $user_random),array('no_trans' => $no_trans,'kode_trans' => $arraykodetrans[$a]));

    //         if (!$saveheader >= 1) {
    //             $comp = array(
    //                 'msg' => 'Tidak',
    //                 'pesan' => 'Error Insert Data whs_t_in_check '.$arraykodetrans[$a].' ..!!'
    //             );
    //             echo json_encode($comp);
    //             die;
    //         }


    //         $whs_t_in_check_detail['created_by'] = $user_random ;
    //         $whs_t_in_check_detail['kode_trans'] = $arraykodetrans[$a] ;
    //         $whs_t_in_check_detail['no_trans'] = $no_trans ;

    //         $savedetail = $this->m_model->savedata('tribltps', 'whs_t_in_check_detail', $whs_t_in_check_detail);
    //         $this->tribltps->update('whs_t_in_check_detail',
    //         array('created_by' => $user_random),array('no_trans' => $no_trans,'kode_trans' => $arraykodetrans[$a]));

    //         if (!$savedetail >= 1) {
    //             $comp = array(
    //                 'msg' => 'Tidak',
    //                 'pesan' => 'Error Insert Data whs_t_in_check_detail '.$arraykodetrans[$a].' ..!!'
    //             );
    //             echo json_encode($comp);
    //             die;
    //         }
    //     }
    //     //END Inject data T7 dan T8




    //     $comp = array(
    //         'msg' => 'Ya',
    //         'whs_t_in_check' => $whs_t_in_check,
    //         'whs_t_in_check_detail' => $whs_t_in_check_detail,
    //         'pesan' => 'Simpan Data Sukses ..!!'
    //     );

    //     echo json_encode($comp);
    // }

    // function c_formedit(){

    //     $kode_trans = $this->input->post('kode_trans');
    //     $no_trans = $this->input->post('no_trans');

    //     $arrayOperator = array('T6'=> 'Koordinator', 'T7' => 'Tally','T8' => 'YC');

    //     $data['kode_trans'] = $kode_trans;
    //     $data['no_trans'] = $no_trans;
    //     $data['operator'] = $arrayOperator[$kode_trans];

    //     $do_no = $this->input->post('do_no');
    //     // $query = " SELECT DISTINCT b.bl_no,b.bl_no 'bl_no1' from whs_t_in_check a 
    //     //     INNER JOIN whs_t_in_check_detail b on a.kode_trans=b.kode_trans and a.no_trans=b.no_trans
    //     //     WHERE a.rec_id=0 and b.rec_id=0 and a.no_trans='".$no_trans."' and a.kode_trans='".$kode_trans."' " ;
    //     // $databl = $this->tribltps->query($query)->result_array();    
    //     // $createcombo = array(
    //     //     'data' => $databl,
    //     //     'set_data' => array('set_id' => ''),
    //     //     'attribute' => array('idname' => 'txtNoDo', 'class' => ''),
    //     // );
    //     // $txtNoDo = ComboDb($createcombo);
    //     $arraydata = array($do_no => $do_no);
    //     $databl = ComboNonDb($arraydata, 'txtNoDo', $do_no, 'form-control selectpicker');
    //     $data['txtNoDo'] = $databl;

    //     $query = " SELECT  *,a.remarks as 'remarks_head' from whs_t_in_check a 
    //     INNER JOIN whs_t_in_check_detail b on a.kode_trans=b.kode_trans and a.no_trans=b.no_trans
    //     WHERE a.rec_id=0 and b.rec_id=0 and a.no_trans='".$no_trans."' and a.kode_trans='".$kode_trans."' " ;
    //     $data_out_check = $this->tribltps->query($query)->result_array();  

    //     $vessel_id = "" ;
    //     $shipper_id = "" ;
    //     foreach($data_out_check as $out_check){
    //         $vessel_id = $out_check['vessel_id'] ;
    //         $shipper_id = $out_check['shipper_id'] ;
    //     }



    //     $arraydata = $this->tribltps->query(" SELECT vessel_id,concat(vessel_name,' ~ ',vessel_voyage) 'vessel_name' FROM whs_m_vessel WHERE rec_id = '0'  ")->result_array();
    //     $createcombo = array(
    //         'data' => $arraydata,
    //         'set_data' => array('set_id' => $vessel_id),
    //         'attribute' => array('idname' => 'txtVessel', 'class' => 'selectpicker'),
    //     );
    //     $txtVessel = ComboDb($createcombo);
    //     $data['txtVessel'] = $txtVessel;

 
    //     $arraydata = $this->tribltps->query(" select DISTINCT a.shipper_id,d.shipper_name from whs_t_in a
    //         INNER JOIN whs_t_in_detail b on a.batch_in=b.batch_in
    //         INNER JOIN whs_t_stock_detail c on b.batch_in=c.batch_in
    //         INNER JOIN whs_m_shipper d on a.shipper_id=d.shipper_id
    //         where a.rec_id=0 and b.rec_id=0 and c.rec_id=0 ")->result_array();
    //     $createcombo = array(
    //         'data' => $arraydata,
    //         'set_data' => array('set_id' => $shipper_id),
    //         'attribute' => array('idname' => 'txtShipper', 'class' => 'selectpicker'),
    //     );
    //     $txtShipper = ComboDb($createcombo);
    //     $data['txtShipper'] = $txtShipper;

    //     $data['txtNoMobil'] = $this->input->post('txtNoMobil');
    //     $data['dtpOut'] = $this->input->post('dtpOut');
    //     $data['txtTimeOut'] = $this->input->post('txtTimeOut');
    //     $data['txtSealNo'] = $this->input->post('txtSealNo');
    //     $data['txtDestination'] = $this->input->post('txtDestination');
    //     $data['txtRemarks'] = $this->input->post('txtRemarks');

    //     $data['bl_no_input'] = $this->input->post('bl_no_input');
    //     $data['consignee_name_input'] = $this->input->post('consignee_name_input');
    //     $data['ex_blno_input'] = $this->input->post('ex_blno_input');
    //     $data['category_name_input'] = $this->input->post('category_name_input');
    //     $data['item_desc_input'] = $this->input->post('item_desc_input');
    //     $data['item_code_input'] = $this->input->post('item_code_input');
    //     $data['good_unit_input'] = $this->input->post('good_unit_input');
    //     $data['good_gross_weight_input'] = $this->input->post('good_gross_weight_input');
    //     $data['good_volume_input'] = $this->input->post('good_volume_input');
    //     $data['damage_unit_input'] = $this->input->post('damage_unit_input');
    //     $data['damage_gross_weight_input'] = $this->input->post('damage_gross_weight_input');
    //     $data['damage_volume_input'] = $this->input->post('damage_volume_input');
    //     $data['location_name_input'] = $this->input->post('location_name_input');
    //     // $data[''] = $this->input->post('');

    //     $this->tribltps->select('t_stock_id');
    //     $this->tribltps->limit(1);
    //     $data['t_stock_id'] = $this->tribltps->get_where('whs_t_stock_detail',array('bl_no' => $this->input->post('bl_no_input')))->row()->t_stock_id ;

    //     $this->load->view('edit',$data);
    // }


    // function c_update(){
    //     $kode_trans = $this->input->post('kode_trans');
    //     $no_trans = $this->input->post('no_trans');
    //     $do_no = $this->input->post('txtNoDo');

    //     $tgl_in = date_db($this->input->post('dtpOut'));
    //     $time_out = $this->input->post('txtTimeOut');
    //     $vessel_id = $this->input->post('txtVessel');
    //     $shipper_id = $this->input->post('txtShipper');
    //     $vehicle_no = $this->input->post('txtNoMobil');
    //     $destination = $this->input->post('txtDestination');
    //     $seal_no = $this->input->post('txtSealNo');
    //     $remarks = $this->input->post('txtRemarks');


    //     $query = " SELECT * from whs_t_out a 
    //         INNER JOIN whs_t_out_detail b on a.batch_out=a.batch_out 
    //         where a.rec_id=0 and b.rec_id=0 and a.do_no = '".$do_no."' " ;
    //     if($this->tribltps->query($query)->num_rows() > 0){
    //         $comp = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'No Bl Ini Sudah Keluar Stock ..!!'
    //         );
    //         echo json_encode($comp);
    //         die;
    //     }

    //     //save header

    //     $whs_t_in_check = array(
    //         'tgl_in' => $tgl_in,
    //         'time_out' => $time_out,
    //         'vessel_id' => $vessel_id,
    //         'shipper_id' => $shipper_id,
    //         'vehicle_no' => $vehicle_no,
    //         'destination' => $destination,
    //         'seal_no' => $seal_no,
    //         'remarks' => $remarks,
    //         'edited_on' => tanggal_sekarang(),
    //         'edited_by' => $this->session->userdata('autogate_username') ,
    //     );
    //     $where = array(
    //         'kode_trans' => $kode_trans,
    //         'no_trans' => $no_trans,
    //         'do_no' => $do_no
    //     );

    //     $update_header = $this->m_model->updatedata('tribltps','whs_t_in_check',$whs_t_in_check,$where) ;
    //     //$this->tribltps->update('whs_t_in_check',array('created_by' => $this->session->userdata('autogate_username')),array('no_trans' => $no_trans,'kode_trans' => $kode_trans));
    //     if (!$update_header >= 1) {
    //         $comp = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'Error Update Data whs_t_in_check ..!!'
    //         );
    //         echo json_encode($comp);
    //         die;
    //     }
    //     //end save header



    //     //data detail
    //     $bl_no = $this->input->post('bl_no_input') ;
        
    //     //$consignee_id = $this->input->post('consignee_name_input');
    //     $this->tribltps->select('consignee_id');
    //     $consignee_id = $this->tribltps->get_where('whs_m_consignee',array('consignee_name' => $this->input->post('consignee_name_input'),'rec_id' => 0))->row()->consignee_id;


    //     $ex_blno = $this->input->post('ex_blno_input') ;
        
    //     //$category_id  = $this->input->post('category_name_input') ;
    //     $this->tribltps->select('category_id');
    //     $category_id = $this->tribltps->get_where('whs_m_category',array('category_name' => $this->input->post('category_name_input'),'rec_id' => 0))->row()->category_id;

    //     $item_desc = $this->input->post('item_desc_input') ;
    //     $item_code = $this->input->post('item_code_input') ;
        
    //     //$location_id = $this->input->post('location_name_input') ;
    //     $this->tribltps->select('location_id');
    //     $location_id = $this->tribltps->get_where('whs_m_location',array('location_name' => $this->input->post('location_name_input'),'rec_id' => 0))->row()->location_id;

    //     $good_unit = $this->input->post('good_unit_input') ;
    //     $good_gross_weight = $this->input->post('good_gross_weight_input') ;
    //     $good_volume = $this->input->post('good_volume_input') ;
    //     $damage_unit = $this->input->post('damage_unit_input') ;
    //     $damage_gross_weight = $this->input->post('damage_gross_weight_input') ;
    //     $damage_volume = $this->input->post('damage_volume_input') ;
    //     $t_stock_id = $this->input->post('t_stock_id') ;

    //     $this->tribltps->select('batch_in');
    //     $batch_in = $this->tribltps->get_where('whs_t_stock_detail',array('t_stock_id' => $t_stock_id))->row()->batch_in;

    //     if($batch_in == ''){
    //         $comp = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'Error Batch In Stock Id ..!!'
    //         );
    //         echo json_encode($comp);
    //         die;
    //     }

    //     $this->tribltps->delete('whs_t_in_check_detail',array('kode_trans' => $kode_trans,'no_trans' => $no_trans,'bl_no' => $bl_no));

    //     $whs_t_in_check_detail = array(
    //         'kode_trans' => $kode_trans,
    //         'no_trans' => $no_trans,
    //         'bl_no' => $bl_no,
    //         'consignee_id' => $consignee_id,
    //         'seq_no' => 1,
    //         'ex_blno' => $ex_blno,
    //         'category_id' => $category_id,
    //         'item_desc' => $item_desc,
    //         'item_code' => $item_code,
    //         'location_id' => $location_id,
    //         'good_unit' => $good_unit,
    //         'good_gross_weight' => $good_gross_weight,
    //         'good_volume' => $good_volume,
    //         'damage_unit' => $damage_unit,
    //         'damage_gross_weight' => $damage_gross_weight,
    //         'damage_volume' => $damage_volume,
    //         't_stock_id' => $t_stock_id,
    //         'created_on' => tanggal_sekarang(),
    //         'created_by' => $this->session->userdata('autogate_username') ,
    //         'edited_on' => tanggal_sekarang(),
    //         'edited_by' => $this->session->userdata('autogate_username') ,
    //         'batch_in' => $batch_in,
            
    //     );

    //     //save data T6 Koordinator

    //     $savedetail = $this->m_model->savedata('tribltps', 'whs_t_in_check_detail', $whs_t_in_check_detail);

    //     if (!$savedetail >= 1) {
    //         $comp = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'Error Insert Data whs_t_in_check_detail ..!!'
    //         );
    //         echo json_encode($comp);
    //         die;
    //     }

    //     //end save data T6 Koordinator


    //     $comp = array(
    //         'msg' => 'Ya',
    //         'whs_t_in_check' => $whs_t_in_check,
    //         'whs_t_in_check_detail' => $whs_t_in_check_detail,
    //         'pesan' => 'Update Data Sukses ..!!'
    //     );

    //     echo json_encode($comp);
    // }

    // function c_delete(){
    //     $kode_trans = $this->input->post('kode_trans');
    //     $no_trans = $this->input->post('no_trans');
    //     $do_no = $this->input->post('do_no');

    //     $this->tribltps->select('vehicle_no');
    //     $vehicle_no = $this->tribltps->get_where('whs_t_in_check',
    //         array('kode_trans' => $kode_trans,'no_trans' => $no_trans , 'do_no' => $do_no ,'rec_id' => 0))->row()->vehicle_no;

    //     $this->tribltps->select('tgl_in');
    //     $tgl_in = $this->tribltps->get_where('whs_t_in_check',
    //         array('kode_trans' => $kode_trans,'no_trans' => $no_trans , 'do_no' => $do_no ,'rec_id' => 0))->row()->tgl_in;

    //     //ceking data sudah out dari stock
    //     $this->tribltps->where(array('do_no' => $do_no,'vehicle_no' => $vehicle_no,'tgl_in' => $tgl_in));
    //     $count_delete = $this->tribltps->get('whs_t_out')->num_rows();
    //     if($count_delete > 0){
    //         $comp = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'Data Tidak Bisa Dihapus Karena Sudah Keluar Dari Stock ..!!'
    //         );
    //         echo json_encode($comp);
    //         die;
    //     }
    //     //ceking data sudah out dari stock        

    //     $where = array(
    //         'kode_trans' => $kode_trans,
    //         'no_trans' => $no_trans
    //     );

    //     $dataupdate = array(
    //         'rec_id' => 9,
    //         'edited_on' => tanggal_sekarang(),
    //         'edited_by' => $this->session->userdata('autogate_username') ,
    //     );

    //     $update_header = $this->m_model->updatedata('tribltps','whs_t_in_check',$dataupdate,$where) ;

    //     if (!$update_header >= 1) {
    //         $comp = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'Error Delete Data whs_t_in_check ..!!'
    //         );
    //         echo json_encode($comp);
    //         die;
    //     }

    //     $update_detail = $this->m_model->updatedata('tribltps','whs_t_in_check_detail',$dataupdate,$where) ;

    //     if (!$update_detail >= 1) {
    //         $comp = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'Error Delete Data whs_t_in_check ..!!'
    //         );
    //         echo json_encode($comp);
    //         die;
    //     }


    //     $comp = array(
    //         'msg' => 'Ya',
    //         'pesan' => 'Hapus Data Sukses ..!!'
    //     );

    //     echo json_encode($comp);

    // }

}