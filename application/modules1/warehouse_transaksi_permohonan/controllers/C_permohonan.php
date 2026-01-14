<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_permohonan extends CI_Controller {

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

        
        // $arraydata = $this->tribltps->query(" SELECT DISTINCT position FROM whs_t_permohonan_head ")->result_array();
        // $createcombo = array(
        //     'data' => $arraydata,
        //     'attribute' => array('idname' => 'position', 'class' => 'selectpicker'),
        // );
        // $position = combotext($createcombo);
        // echo $position;
        // die;


        $menu_active = $this->m_model->menu_active();

        $startdate = date('m-Y') ;
        $enddate = date('d-m-Y') ;


        $arraydata = $this->tribltps->query(" SELECT DISTINCT no_mbl,no_mbl 'no_mbl1' FROM whs_t_permohonan_head a 
                                              INNER JOIN whs_t_permohonan_det b on a.id=b.id ")->result_array();
        array_push($arraydata, array('no_mbl' => '' , 'no_mbl1' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'no_mbl', 'class' => 'selectpicker'),
        );
        $no_mbl = ComboDb($createcombo);

        $arraydata = $this->tribltps->query(" SELECT DISTINCT a.shipper_id,c.shipper_name FROM whs_t_permohonan_head a 
                                              INNER JOIN whs_t_permohonan_det b on a.id=b.id
                                              INNER JOIN whs_m_shipper c on a.shipper_id=c.shipper_id ")->result_array();
        array_push($arraydata, array('shipper_id' => '' , 'shipper_name' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'shipper_id', 'class' => 'selectpicker'),
        );
        $shipper_id = ComboDb($createcombo);

        $arraydata = $this->tribltps->query(" SELECT DISTINCT b.cont_no,b.cont_no 'cont_no1' FROM whs_t_permohonan_head a 
                                              INNER JOIN whs_t_permohonan_det b on a.id=b.id ")->result_array();
        array_push($arraydata, array('cont_no' => '' , 'cont_no1' => 'ALL'));
        $createcombo = array(
            'data' => array_reverse($arraydata,true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'cont_no', 'class' => 'selectpicker'),
        );
        $cont_no = ComboDb($createcombo);
 

        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
            'no_mbl' => $no_mbl,
            'shipper_id' => $shipper_id,
            'cont_no' => $cont_no,
            'startdate' => "01-$startdate" ,
            'enddate' => $enddate
        );
        $this->load->view('dashboard/index', $data);

    }

    

    function tbl_whs_permohonan(){
        
        $tgl_eta = date_db($this->input->post('tgl_eta')) ;
        $tgl_eta_end = date_db($this->input->post('tgl_eta_end')) ;
        $no_mbl = $this->input->post('no_mbl') ;
        $shipper_id = $this->input->post('shipper_id') ;
        $cont_no = $this->input->post('cont_no') ;

        $query= " " ;
        $query.= " SELECT DISTINCT a.id,a.tgl_eta,a.no_mbl,a.tgl_master_mbl,a.shipper_id,c.shipper_name, " ;
        $query.= " a.vessel,a.voyage,a.lapangan,a.jmlpos,a.qty,a.gross_weight " ;
        $query.= " from whs_t_permohonan_head a " ;
        $query.= " INNER JOIN whs_t_permohonan_det b on a.id=b.id " ;
        $query.= " INNER JOIN whs_m_shipper c on a.shipper_id=c.shipper_id ";

        $query.= " where a.id <> '' " ;

        if($tgl_eta != ""){
            $query.= " and a.tgl_eta>='".$tgl_eta."' " ;
        }
        if($tgl_eta_end != ""){
            $query.= " and a.tgl_eta<='".$tgl_eta_end."' " ;
        }
        if($no_mbl != ""){
            $query.= " and a.no_mbl='".$no_mbl."' " ;
        }
        if($shipper_id != ""){
            $query.= " and a.shipper_id='".$shipper_id."' " ;
        }
        if($cont_no != ""){
            $query.= " and b.cont_no = '".$cont_no."' " ;
        }

        $query.= " ORDER BY a.id desc " ;
        $data = $this->tribltps->query($query);

        $comp = array(
            'jml' => $data->num_rows(),
            'isidata' => $this->m_model->array_tag_on_index($data->result_array()),
            'query' => $query
        );        
        echo json_encode($comp);
    }

    function tbl_whs_permohonan_detail(){

        $id = $this->input->post('id');

        $query= " " ;
        $query.= " SELECT DISTINCT b.id,b.cont_no,b.size " ;
        $query.= " from whs_t_permohonan_head a " ;
        $query.= " INNER JOIN whs_t_permohonan_det b on a.id=b.id where a.tgl_eta <> '' " ;

        if($id != ""){
            $query.= " and a.id='".$id."' " ;
        }

        $query.= " ORDER BY b.id desc " ;
        $data = $this->tribltps->query($query);

        $comp = array(
            'jml' => $data->num_rows(),
            'isidata' => $this->m_model->array_tag_on_index($data->result_array()),
            'query' => $query
        );        
        echo json_encode($comp);
    }

    function c_formadd(){
        $arraydata = $this->tribltps->query(" SELECT shipper_id,shipper_name from whs_m_shipper WHERE rec_id = '0' ")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'shipper_id', 'class' => 'selectpicker'),
        );
        $shipper_id = ComboDb($createcombo);


        $arraydata = $this->tribltps->query(" SELECT DISTINCT position FROM whs_t_permohonan_head ")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'attribute' => array('idname' => 'position','listname' => 'listposition', 'class' => 'form-control-sm'),
        );
        $position = combotext($createcombo);

        $arraydata = $this->tribltps->query(" SELECT DISTINCT name 'namept' FROM whs_t_permohonan_head ")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'attribute' => array('idname' => 'namept','listname' => 'listnamept', 'class' => 'form-control-sm alamat'),
        );
        $namept = combotext($createcombo);

        $arraydata = $this->tribltps->query(" SELECT DISTINCT lapangan FROM whs_t_permohonan_head ")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'attribute' => array('idname' => 'lapangan','listname' => 'listlapangan', 'class' => 'form-control-sm'),
        );
        $lapangan = combotext($createcombo);


        $arraydata = $this->tribltps->query(" SELECT DISTINCT othername FROM whs_t_permohonan_head ")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'attribute' => array('idname' => 'othername','listname' => 'listothername', 'class' => 'form-control-sm'),
        );
        $othername = combotext($createcombo);


        $arraydata = $this->tribltps->query(" SELECT DISTINCT otherpbm FROM whs_t_permohonan_head ")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'attribute' => array('idname' => 'otherpbm','listname' => 'listotherpbm', 'class' => 'form-control-sm'),
        );
        $otherpbm = combotext($createcombo);

        $arraydata = $this->tribltps->query(" SELECT DISTINCT vessel FROM whs_t_permohonan_head ")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'attribute' => array('idname' => 'vessel','listname' => 'listvessel', 'class' => 'form-control-sm'),
        );
        $vessel = combotext($createcombo);

        $arraydata = $this->tribltps->query(" SELECT DISTINCT voyage FROM whs_t_permohonan_head ")->result_array();
        $createcombo = array(
            'data' => $arraydata,
            'attribute' => array('idname' => 'voyage','listname' => 'listvoyage', 'class' => 'form-control-sm'),
        );
        $voyage = combotext($createcombo);

        $comp = array(
            'shipper_id' => $shipper_id,
            'position' => $position,
            'namept' => $namept,
            'lapangan' => $lapangan,
            'othername' => $othername,
            'otherpbm' => $otherpbm,
            'vessel' => $vessel,
            'voyage' => $voyage

        );

        $this->load->view('add',$comp);
    }

    function c_loadalamat(){

        $this->tribltps->select('address1,address2,address3,address4');
        $this->tribltps->limit('1');
        $data = $this->tribltps->get_where('whs_t_permohonan_head',array('name' => $this->input->post('namept')))->result_array();

        $comp = array(
            'alamat' => $this->m_model->array_tag_on_index(array_reverse($data,false)),
            'query' => $this->tribltps->last_query()
        );

        echo json_encode($comp);
    }


    // function c_refresh_combo(){
    //     $tgl_in = date_db($this->input->post('tgl_in')) ;
    //     $tgl_in_end = date_db($this->input->post('tgl_in_end')) ;

        

    //     $data_bl = $this->tribltps->query("SELECT DISTINCT bl_no 'id',bl_no 'name'  FROM whs_t_in_check_detail a 
    //         inner join whs_t_in_check b ON a.kode_trans = b.kode_trans AND a.no_trans = b.no_trans 
    //         WHERE a.rec_id = '0'  AND tgl_in >= '".$tgl_in."' AND tgl_in <= '".$tgl_in_end."' ORDER BY bl_no ")->result_array();
    //     array_push($data_bl, array('id' => '' , 'name' => 'ALL'));


    //     $data_shipper = $this->tribltps->query(" SELECT DISTINCT a.shipper_id,shipper_name  FROM whs_t_in_check a 
    //         INNER JOIN whs_m_shipper b ON a.shipper_id = b.shipper_id  
    //         WHERE a.rec_id = '0' AND tgl_in >= '".$tgl_in."' AND tgl_in <= '".$tgl_in_end."' ORDER BY shipper_name  ")->result_array();
    //     array_push($data_shipper, array('shipper_id' => '' , 'shipper_name' => 'ALL'));


    //     $data_consignee = $this->tribltps->query(" SELECT DISTINCT a.consignee_id,consignee_name
    //          FROM whs_t_in_check_detail a 
    //          INNER JOIN whs_m_consignee b ON a.consignee_id = b.consignee_id  
    //          INNER JOIN whs_t_in_check c ON a.kode_trans = c.kode_trans AND a.no_trans = c.no_trans 
    //          WHERE c.rec_id = '0' AND a.rec_id = '0' AND tgl_in >= '".$tgl_in."' AND tgl_in <= '".$tgl_in_end."' ORDER BY consignee_name ")->result_array();
    //     array_push($data_consignee, array('consignee_id' => '' , 'consignee_name' => 'ALL'));

    //     $data_contno = $this->tribltps->query(" SELECT DISTINCT cont_no,cont_no 'Container' FROM whs_t_in_check
    //         WHERE rec_id = '0' AND tgl_in >= '".$tgl_in."' AND tgl_in <= '".$tgl_in_end."' ORDER BY cont_no ")->result_array();
    //     array_push($data_contno, array('cont_no' => '' , 'Container' => 'ALL'));

    //     $data_do_no = $this->tribltps->query(" SELECT DISTINCT do_no,do_no 'do_no1' FROM whs_t_in_check
    //         WHERE rec_id = '0' AND tgl_in >= '".$tgl_in."' AND tgl_in <= '".$tgl_in_end."' ORDER BY do_no ")->result_array();
    //     array_push($data_do_no, array('do_no' => '' , 'do_no1' => 'ALL'));


    //     $query = " SELECT DISTINCT a.vessel_id,concat(a.vessel_name,' ',a.vessel_voyage) 'vessel_name'  
    //         FROM whs_m_vessel a
    //         INNER JOIN whs_t_in_check b on a.vessel_id=b.vessel_id
    //         WHERE a.rec_id = '0' and b.rec_id = '0' AND b.tgl_in >= '".$tgl_in."' AND b.tgl_in <= '".$tgl_in_end."' ORDER BY a.vessel_name " ;
    //     $data_vessel = $this->tribltps->query($query)->result_array();
    //     array_push($data_vessel, array('vessel_id' => '' , 'vessel_name' => 'ALL'));


    //     $query = " SELECT DISTINCT CONCAT(a.kode_trans,a.no_trans) 'kode',
    //         CONCAT(a.kode_trans,a.no_trans) 'kode1' from whs_t_in_check a 
    //         INNER JOIN whs_t_in_check_detail b 
    //         on a.kode_trans=b.kode_trans and a.no_trans=b.no_trans
    //         where a.rec_id=0 and b.rec_id=0 AND a.tgl_in >= '".$tgl_in."' AND a.tgl_in <= '".$tgl_in_end."'  " ;
    //     $data_no_transaksi = $this->tribltps->query($query)->result_array();
    //     array_push($data_no_transaksi, array('kode' => '' , 'kode1' => 'ALL'));

    //     $comp = array(
    //         'bl_no' => $this->m_model->array_tag_on_index(array_reverse($data_bl,false)),
    //         'shipper_id' => $this->m_model->array_tag_on_index(array_reverse($data_shipper,false)),
    //         'consignee_id' => $this->m_model->array_tag_on_index(array_reverse($data_consignee,false)),
    //         'cont_no' => $this->m_model->array_tag_on_index(array_reverse($data_contno,false)),
    //         'do_no' => $this->m_model->array_tag_on_index(array_reverse($data_do_no,false)),
    //         'no_transaksi' => $this->m_model->array_tag_on_index(array_reverse($data_no_transaksi,false)),
    //         'vessel_id' => $this->m_model->array_tag_on_index(array_reverse($data_vessel,false)),
    //     );        
        // echo json_encode($comp);
    // }

    

    // function c_detail_bl(){
    //     $kode_trans = $this->input->post('kode_trans') ;
    //     $no_trans = $this->input->post('no_trans') ;

    //     $sql= " SELECT bl_no 'No. BL',a.consignee_id, consignee_name 'Nama Consignee', " ;
    //     $sql.= " seq_no,ex_blno 'Ex BL', a.category_id, category_name 'Category',  " ;
    //     $sql.= " item_desc 'Deskripsi Item' ,item_code 'Code Item',a.location_id,IFNULL(location_name,'') 'Lokasi', " ;
    //     $sql.= " good_unit 'Good', good_gross_weight 'Good GW', good_volume 'Good Volume', " ;
    //     $sql.= " damage_unit 'Damage', damage_gross_weight 'Damage GW', damage_volume 'Damage Volume' , " ;
    //     $sql.= " palet_id 'Palet ID', IFNULL(remarks,'') 'Remarks',t_stock_id,jenis_doc as 'Jenis Document' " ;
    //     $sql.= " FROM whs_t_in_check_detail a  " ;
    //     $sql.= " INNER JOIN whs_m_category b ON  a.category_id = b.category_id   " ;
    //     $sql.= " INNER JOIN whs_m_consignee c ON a.consignee_id = c.consignee_id  " ;
    //     $sql.= " LEFT JOIN whs_m_location d ON a.location_id = d.location_id  " ;
    //     $sql.= " WHERE a.rec_id = '0' AND kode_trans = '".$kode_trans."' AND no_trans = '".$no_trans."' " ;
    //     $data_detail = $this->tribltps->query($sql)->result_array();

    //     $comp = array(
    //         'kode_trans' => $kode_trans,
    //         'no_trans' => $no_trans,
    //         'isidata' => $this->m_model->array_tag_on_index($data_detail),
    //     );        
    //     echo json_encode($comp);
    // }


    // function c_export_data(){
        
        

    //     $data = base64_decode($_GET['data']);
    //     $data = explode(',', $data);
    //     $tgl_in = date_db($data[0]) ;
    //     $tgl_in_end = date_db($data[1]) ;

    //     $query = " SELECT tgl_in,shipper_name,cont_no,CONCAT(ukuran,' ',tipe) 'Tipe',do_no,  " ;
    //     $query.= " (SELECT COUNT(*) FROM whs_t_in_check_detail " ;
    //     $query.= " WHERE kode_trans = a.kode_trans AND no_trans = a.no_trans) 'QTY B/L',  " ;
    //     $query.= " (SELECT IFNULL(CREATED_BY,'') " ;
    //     $query.= " FROM whs_t_in_check WHERE rec_id = '0' AND do_no = a.do_no " ;
    //     $query.= " AND cont_no = a.cont_no and kode_trans = 'T2' LIMIT 0,1) 'Taly',  " ;
    //     $query.= " (SELECT IFNULL(CREATED_BY,'') " ;
    //     $query.= " FROM whs_t_in_check WHERE rec_id = '0' AND do_no = a.do_no " ;
    //     $query.= " AND cont_no = a.cont_no and kode_trans = 'T3' LIMIT 0,1) 'YC',  " ;
    //     $query.= " CASE WHEN (SELECT COUNT(DISTINCT bl_no) " ;
    //     $query.= " FROM whs_t_in_detail x " ;
    //     $query.= " INNER JOIN whs_t_in y ON x.batch_in = y.batch_in  " ;
    //     $query.= " WHERE do_no = a.do_no AND cont_no = a.cont_no) = (SELECT COUNT(*) " ;
    //     $query.= " FROM whs_t_in_check_detail WHERE kode_trans = a.kode_trans AND no_trans = a.no_trans) " ;
    //     $query.= " THEN  'Sudah Diprint' ELSE 'Belum Diprint' END AS 'Printed'  " ;
    //     $query.= " FROM whs_t_in_check a " ;
    //     $query.= " INNER JOIN whs_m_shipper b ON a.shipper_id = b.shipper_id  " ;
    //     $query.= " where tgl_in >= '".$tgl_in."' AND tgl_in <= '".$tgl_in_end."' " ;
    //     $query.= " and kode_trans = 'T1' and a.rec_id = '0' ORDER BY shipper_name " ;
    //     $query.= " ,CONCAT(ukuran,' ',tipe),cont_no, CASE WHEN (SELECT COUNT(DISTINCT bl_no) " ;
    //     $query.= " FROM whs_t_in_detail x " ;
    //     $query.= " INNER JOIN whs_t_in y ON x.batch_in = y.batch_in  " ;
    //     $query.= " WHERE do_no = a.do_no AND cont_no = a.cont_no) = (SELECT COUNT(*) " ;
    //     $query.= " FROM whs_t_in_check_detail " ;
    //     $query.= " WHERE kode_trans = a.kode_trans AND no_trans = a.no_trans) THEN  'Sudah Diprint' " ;
    //     $query.= " ELSE 'Belum Diprint' END Desc " ;

    //     $dataExcute = $this->tribltps->query($query);

    //     if($dataExcute->num_rows() == 0){
    //         echo "Data Tidak Ada ..!!" ;die;
    //     }

    //     $spreadsheet = new Spreadsheet();

    //     $writer = new Xlsx($spreadsheet);

    //     $spreadsheet->createSheet();

    //     $spreadsheet->setActiveSheetIndex(0);
    //     $spreadsheet->getActiveSheet()->setTitle("Receiving");
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $baris = 1 ;
    //     $sheet->setCellValueByColumnAndRow(1, $baris, "Receiving");
    //     $sheet->mergeCells('A1:J1');
    //     $sheet->getStyle("A1")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
    //     $sheet->getStyle("A1")->getFont()->setBold(true);
    //     $sheet->getStyle("A1")->getFont()->setSize(18);

    //     $baris++;
    //     $sheet->setCellValueByColumnAndRow(1, $baris, "Tanggal ".showdate_dmy_excel($data[0])." s/d ".showdate_dmy_excel($data[1]));
    //     $sheet->mergeCells('A2:J2');
    //     $sheet->getStyle("A2")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
    //     $sheet->getStyle("A2")->getFont()->setBold(true);
    //     $sheet->getStyle("A2")->getFont()->setSize(16);

    //     $baris = $baris + 2;
    //     $kolom = 1 ;
    //     $kolom_number = array('A','B','C','D','E','F','G','H','I','J');
    //     $kolom_judul = array("No","Tanggal","Forwarder / PBM","No Kontainer","Tipe","M B/L","Qty B/L","Tally","YC","Print Out");
    //     for($a=0 ; $a<count($kolom_judul) ; $a++){
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $kolom_judul[$a]);
    //         //$sheet->getStyle($kolom_number[$a] . $baris)->applyFromArray($this->m_model->styleHeader()) ;

    //         $sheet->getStyle($kolom_number[$a].$baris)->applyFromArray($this->m_model->styleHeader());

    //         $sheet->getStyle($kolom_number[$a].$baris)->getFont()->setBold(true);

    //         $sheet->getStyle($kolom_number[$a].$baris)->getFill()
    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1e366c');

    //         $sheet->getStyle($kolom_number[$a].$baris)->getFont()
    //         ->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

    //         $kolom++;
    //     }

    //     $baris++;        
    //     $nomor = 1 ;        
    //     $first_position = "" ;
    //     $last_position = "" ;
    //     foreach($dataExcute->result_array() as $isiexcel){

    //         $kolom = 1 ; $index = 0 ;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, (string)$nomor);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;
            

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, showdate_dmybc($isiexcel['tgl_in']));
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleDate()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['shipper_name']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['cont_no']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['Tipe']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['do_no']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['QTY B/L']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['Taly']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['YC']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['Printed']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $baris++; $nomor++;
    //     }

    //     $kolom = 1 ;
    //     for($c = 0 ; $c < count($kolom_number) ; $c++ ){
    //         $sheet->getColumnDimensionByColumn($kolom)->setAutoSize(true);
    //         $kolom++;
    //     }




    //     $nama_excel = "Receiving_" ;

    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $nama_excel.date_ymdhis(date("Y-m-d H:i:s")). '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');




    // }

    // function c_export_bahandle(){

    //     $data = base64_decode($_GET['data']);
    //     $data = explode(',', $data);
    //     $tgl_in = date_db($data[0]) ;
    //     $tgl_in_end = date_db($data[1]) ;


    //     $query = " SELECT DISTINCT CONVERT(CONCAT(LEFT(b.cont_no,4),' ',RIGHT(b.cont_no,7)) USING UTF8) 'Cont' , " ;
    //     $query.= " CONVERT(CASE b.ukuran when '20' then '1' else '' end USING UTF8) '20feet' ,  " ;
    //     $query.= " CONVERT(CASE b.ukuran when '40' then '1' else '' end USING UTF8) '40feet' ,  " ;
    //     $query.= " consignee_name,a.bl_no,CONVERT(CONCAT(e.good_unit,' ',category_kode) USING UTF8) 'colly', " ;
    //     $query.= " CONVERT(DATE_FORMAT(bahandle_on,'%d/%m/%Y') USING UTF8) 'tglbahandle', " ;
    //     $query.= " CONVERT(IFNULL(tgl_out,'') USING UTF8) 'tglout','' " ;
    //     $query.= " FROM whs_vw_bahandle a " ;
    //     $query.= " INNER JOIN whs_t_in b ON a.batch_in = b.batch_in " ;
    //     $query.= " INNER JOIN whs_m_consignee c ON a.consignee_id = c.consignee_id " ;
    //     $query.= " INNER JOIN whs_m_category d ON a.category_id = d.category_id " ;
    //     $query.= " INNER JOIN whs_t_in_check_detail e ON a.item_code = e.item_code " ;
    //     $query.= " LEFT JOIN ( whs_t_out_detail f " ;
    //     $query.= " INNER JOIN whs_t_out g ON f.batch_out = g.batch_out) ON a.item_code = f.item_code " ;
    //     $query.= " WHERE flag_bahandle = 'Y' " ;
    //     $query.= " AND bahandle_on BETWEEN '".$tgl_in."' AND '".$tgl_in_end."' " ;
    //     $query.= " AND e.kode_trans = 'T1' AND e.rec_id = '0'" ;


    //     $dataExcute = $this->tribltps->query($query);

    //     if($dataExcute->num_rows() == 0){
    //         echo "Data Tidak Ada ..!!" ;die;
    //     }

    //     $spreadsheet = new Spreadsheet();

    //     $writer = new Xlsx($spreadsheet);

    //     $spreadsheet->createSheet();

    //     $spreadsheet->setActiveSheetIndex(0);
    //     $spreadsheet->getActiveSheet()->setTitle("Bahandle");
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $baris = 1 ;
    //     $sheet->setCellValueByColumnAndRow(1, $baris, "LAPORAN BAHANDEL PT.MULTI BINTANG ABADI");        
    //     // $sheet->getStyle("A1")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
    //     $sheet->getStyle("A1:J2")->getFont()->setBold(true);
    //     $sheet->getStyle("A1:J2")->getFont()->setSize(14);
    //     $sheet->mergeCells('A1:J2');
    //     $sheet->getStyle('A1:J2')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('A1:J2')->getAlignment()->setVertical('center');

    //     // $baris++;
    //     // $sheet->setCellValueByColumnAndRow(1, $baris, "Tanggal ".showdate_dmy_excel($data[0])." s/d ".showdate_dmy_excel($data[1]));
    //     // $sheet->mergeCells('A2:J2');
    //     // $sheet->getStyle("A2")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
    //     // $sheet->getStyle("A2")->getFont()->setBold(true);
    //     // $sheet->getStyle("A2")->getFont()->setSize(16);

    //     $baris = $baris + 2;
    //     $kolom = 1 ;
    //     $kolom_number = array('A','B','C','D','E','F','G','H','I','J');
    //     $kolom_judul = array("No","EX CONTAINER","","","CONSIGNEE","NO. BL","COLLY","TANGGAL","","KETERANGAN");
    //     for($a=0 ; $a<count($kolom_judul) ; $a++){
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $kolom_judul[$a]);
    //         //$sheet->getStyle($kolom_number[$a] . $baris)->applyFromArray($this->m_model->styleHeader()) ;

    //         $sheet->getStyle($kolom_number[$a].$baris)->applyFromArray($this->m_model->styleHeader());

    //         $sheet->getStyle($kolom_number[$a].$baris)->getFont()->setBold(true);

    //         $sheet->getStyle($kolom_number[$a].$baris)->getFill()
    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');

    //         $kolom++;
    //     }

    //     $baris++;
    //     $kolom = 1 ;
    //     $kolom_judul = array("","NO","20","40","","","","BAHANDEL","KELUAR","");
    //     for($a=0 ; $a<count($kolom_judul) ; $a++){
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $kolom_judul[$a]);
    //         //$sheet->getStyle($kolom_number[$a] . $baris)->applyFromArray($this->m_model->styleHeader()) ;

    //         $sheet->getStyle($kolom_number[$a].$baris)->applyFromArray($this->m_model->styleHeader());

    //         $sheet->getStyle($kolom_number[$a].$baris)->getFont()->setBold(true);

    //         $sheet->getStyle($kolom_number[$a].$baris)->getFill()
    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');

    //         $kolom++;
    //     }

    //     $sheet->mergeCells('B3:D3'); //EX KONTAINER
    //     $sheet->mergeCells('E3:E4'); //CONSIGNEE
    //     $sheet->mergeCells('F3:F4'); //NO BL
    //     $sheet->mergeCells('G3:G4'); //COLLY
    //     $sheet->mergeCells('H3:I3'); //TANGGAL
    //     $sheet->mergeCells('J3:J4'); //TANGGAL
    //     $sheet->mergeCells('A3:A4'); //NOMOR



    //     $baris = $baris+2 ;        
    //     $nomor = 1 ;        
    //     $first_position = "" ;
    //     $last_position = "" ;
    //     foreach($dataExcute->result_array() as $isiexcel){

    //         $kolom = 1 ; $index = 0 ;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, (string)$nomor);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;
            

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['Cont']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['20feet']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['40feet']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['consignee_name']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['bl_no']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['colly']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, showdate_dmybc($isiexcel['tglbahandle']));
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleDate()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, showdate_dmybc($isiexcel['tglout']));
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleDate()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, "");
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $baris++; $nomor++;
    //     }

    //     $kolom = 1 ;
    //     for($c = 0 ; $c < count($kolom_number) ; $c++ ){
    //         $sheet->getColumnDimensionByColumn($kolom)->setAutoSize(true);
    //         $kolom++;
    //     }




    //     $nama_excel = "Bahandle_" ;

    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $nama_excel.date_ymdhis(date("Y-m-d H:i:s")). '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }

    // function c_export_tally(){
    //     $data = base64_decode($_GET['data']);
    //     $data = explode(',', $data);
    //     $tgl_in = date_db($data[0]) ;
    //     $tgl_in_end = date_db($data[1]) ;
    //     $cont_no = $data[2] ;
 

    //     $query = " SELECT a.cont_no 'nocontainer',c.shipper_name,b.vessel_name,b.vessel_voyage,'' as 'call_sign',date_format(a.tgl_tiba,'%d-%m-%Y') as 'tgl_tiba', " ;
    //     $query.= " do_no,date_format(tgl_master_mbl,'%d-%m-%Y') as 'tgl_master_mbl','' as 'nobc11' , '' as 'tglbc11', " ;
    //     $query.= " concat(a.cont_no,'/',a.ukuran) as 'nocont','' as 'noplp', '' as 'tglplp',date_format(tgl_in,'%d-%m-%Y') as 'date_loading',  " ;
    //     $query.= " date_format(start_loading,'%d-%m-%Y %h:%i:%s') as 'start_loading',  date_format(finish_loading,'%d-%m-%Y %h:%i:%s') as 'finish_loading' " ;
    //     $query.= " from whs_t_in_check a " ;
    //     $query.= " INNER JOIN whs_m_vessel b on a.vessel_id=b.vessel_id  " ;
    //     $query.= " INNER JOIN whs_m_shipper c on a.shipper_id=c.shipper_id " ;
    //     $query.= " INNER JOIN whs_t_in_check_detail d on a.kode_trans=d.kode_trans and a.no_trans=d.no_trans " ;
    //     $query.= " INNER JOIN whs_m_category e on d.category_id=e.category_id " ;
    //     $query.= " INNER JOIN whs_m_consignee f on d.consignee_id=f.consignee_id " ;
    //     $query.= " INNER JOIN whs_m_location g on d.location_id=g.location_id " ;
    //     $query.= " where a.rec_id=0 and d.rec_id=0  " ;
    //     $query.= " and a.tgl_in >='".$tgl_in."' and a.tgl_in<='".$tgl_in_end."' " ;
    //     $query.= " and a.cont_no ='".$cont_no."' and a.kode_trans='T3' " ;
    //     $query.= " ORDER BY d.seq_no " ;


    //     $dataHead = $this->tribltps->query($query);

    //     if($dataHead->num_rows() == 0){
    //         echo "Data Tidak Ada ..!!" ;die;
    //     }

    //     $header = $this->m_model->query_to_tag($query,'tribltps');
    
    //     $querymbl = " SELECT DISTINCT a.tgl_master_mbl from whs_t_permohonan_head a 
    //         INNER JOIN whs_t_permohonan_det b on a.id=b.id
    //         where a.no_mbl='".$header['do_no']."' and b.cont_no='".$header['nocontainer']."' " ;
    //     $headermbl = $this->m_model->query_to_tag($querymbl,'tribltps');
    //     // print_r($querymbl);
    //     // die;
         

    //     $query = " SELECT d.item_code,'' as 'posbc11',d.bl_no,date_format(d.tgl_bl,'%d-%m-%Y') as 'tgl_bl', " ;
    //     $query.= " f.consignee_name,d.item_desc, d.good_unit as 'party',h.category_kode,d.good_volume,d.good_gross_weight, " ; 
    //     $query.= " a.start_loading,a.finish_loading,'' as 'good','' as 'damage',g.location_name,d.remarks " ;
    //     $query.= " from whs_t_in_check a " ;
    //     $query.= " INNER JOIN whs_m_vessel b on a.vessel_id=b.vessel_id " ;       
    //     $query.= " INNER JOIN whs_m_shipper c on a.shipper_id=c.shipper_id " ;
    //     $query.= " INNER JOIN whs_t_in_check_detail d on a.kode_trans=d.kode_trans and a.no_trans=d.no_trans " ;
    //     $query.= " INNER JOIN whs_m_category e on d.category_id=e.category_id " ;
    //     $query.= " INNER JOIN whs_m_consignee f on d.consignee_id=f.consignee_id " ;
    //     $query.= " INNER JOIN whs_m_location g on d.location_id=g.location_id " ;
    //     $query.= " INNER JOIN whs_m_category h on d.category_id = h.category_id " ;
    //     $query.= " where a.rec_id=0 and d.rec_id=0  and a.cont_no ='".$cont_no."' " ;
    //     $query.= " and a.tgl_in >='".$tgl_in."' and a.tgl_in<='".$tgl_in_end."' " ;
    //     $query.= " ORDER BY d.seq_no " ;
    //     $dataExcute = $this->tribltps->query($query);

    //     $spreadsheet = new Spreadsheet();

    //     $writer = new Xlsx($spreadsheet);

    //     $spreadsheet->createSheet();

    //     $spreadsheet->setActiveSheetIndex(0);
    //     $spreadsheet->getActiveSheet()->setTitle("Tally");
    //     $sheet = $spreadsheet->getActiveSheet();

        
    //     $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    //     $image = FCPATH.'/assets/image/logo_PTMBA.png' ;
    //     $drawing->setPath($image); 
    //     $drawing->setCoordinates('A1');
    //     $drawing->setHeight(60);
    //     $drawing->setOffsetX(40);
    //     $drawing->setWorksheet($spreadsheet->getActiveSheet());
    //     $sheet->mergeCells('A1:B3');

    //     $baris = 1 ;
    //     $sheet->setCellValueByColumnAndRow(3, $baris, "PT.MULTI BINTANG ABADI"); 
    //     $sheet->mergeCells('C1:E3');       
    //     $sheet->getStyle("C1:E3")->getFont()->setBold(true);
    //     $sheet->getStyle("C1:E3")->getFont()->setSize(12);        
    //     // $sheet->getStyle('C1:E3')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('C1:E3')->getAlignment()->setVertical('center');


    //     $sheet->setCellValueByColumnAndRow(6, $baris+1, "RECEIVING FORM"); 
    //     $sheet->mergeCells('F2:I4');       
    //     $sheet->getStyle("F2:I4")->getFont()->setBold(true);
    //     $sheet->getStyle("F2:I4")->getFont()->setSize(12);        
    //     $sheet->getStyle('F2:I4')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('F2:I4')->getAlignment()->setVertical('center');


    //     $baris = $baris + 5 ;
    //     $sheet->setCellValueByColumnAndRow(1, $baris, "Nomor"); 
    //     $sheet->setCellValueByColumnAndRow(2, $baris, ": "); 

    //     $sheet->setCellValueByColumnAndRow(6, $baris, "NO.MASTER BL"); 
    //     $sheet->setCellValueByColumnAndRow(7, $baris, ": ".$header['do_no']); 

    //     $sheet->setCellValueByColumnAndRow(11, $baris, "DATE LOADING"); 
    //     $sheet->setCellValueByColumnAndRow(12, $baris, ": ".showdate_dmybc($header['date_loading'])); 

    //     //===========================================================================
    //     $baris++;
    //     $sheet->setCellValueByColumnAndRow(1, $baris, "FORWARDER"); 
    //     $sheet->setCellValueByColumnAndRow(2, $baris, ": ".$header['shipper_name']); 

    //     $sheet->setCellValueByColumnAndRow(6, $baris, "TGL MASTER BL"); 
    //     $sheet->setCellValueByColumnAndRow(7, $baris, ": ".showdate_dmybc($headermbl['tgl_master_mbl'])); 
    //     //============================================================================
    //     $baris++;
    //     $sheet->setCellValueByColumnAndRow(1, $baris, "VESSEL"); 
    //     $sheet->setCellValueByColumnAndRow(2, $baris, ": ".$header['vessel_name']); 

    //     $sheet->setCellValueByColumnAndRow(6, $baris, "NO.BC 1.1"); 
    //     $sheet->setCellValueByColumnAndRow(7, $baris, ": "); 

    //     $sheet->setCellValueByColumnAndRow(11, $baris, "START LOADING"); 
    //     $sheet->setCellValueByColumnAndRow(12, $baris, ": ".showdate_dmyhis($header['start_loading'])); 
    //     //============================================================================
    //     $baris++;
    //     $sheet->setCellValueByColumnAndRow(1, $baris, "VOYAGE"); 
    //     $sheet->setCellValueByColumnAndRow(2, $baris, ": ".$header['vessel_voyage']); 

    //     $sheet->setCellValueByColumnAndRow(6, $baris, "TGL BC 1.1"); 
    //     $sheet->setCellValueByColumnAndRow(7, $baris, ": "); 
    //     //============================================================================
    //     $baris++;
    //     $sheet->setCellValueByColumnAndRow(1, $baris, "CALL SIGN"); 
    //     $sheet->setCellValueByColumnAndRow(2, $baris, ": "); 

    //     $sheet->setCellValueByColumnAndRow(6, $baris, "NO CONT/SIZE"); 
    //     $sheet->setCellValueByColumnAndRow(7, $baris, ": ".$header['nocont']); 

    //     $sheet->setCellValueByColumnAndRow(11, $baris, "FINISH LOADING"); 
    //     $sheet->setCellValueByColumnAndRow(12, $baris, ": ".showdate_dmyhis($header['finish_loading'])); 
    //     //============================================================================
    //     $baris++;
    //     $sheet->setCellValueByColumnAndRow(1, $baris, "TGL TIBA"); 
    //     $sheet->setCellValueByColumnAndRow(2, $baris, ": ".showdate_dmybc($header['tgl_tiba'])); 

    //     $sheet->setCellValueByColumnAndRow(6, $baris, "NO PLP"); 
    //     $sheet->setCellValueByColumnAndRow(7, $baris, ": "); 
    //     //============================================================================
    //     $baris++;
    //     $sheet->setCellValueByColumnAndRow(6, $baris, "TGL PLP"); 
    //     $sheet->setCellValueByColumnAndRow(7, $baris, ": "); 
    //     //============================================================================

    //     $baris = $baris + 2 ;
    //     $kolom = 1 ;
    //     $kolom_number = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q');
    //     $kolom_judul = array("No","CODE ITEM","POS BC1.1","B/L No","TGL B/L","CONSIGNEE","DESCRIPTION OF GOODS","PARTY","PACKING","VOL(M3)",
    //         "GROSS WEIGHT (TON)","TALLY","","","","","REMARK");
    //     for($a=0 ; $a<count($kolom_judul) ; $a++){
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $kolom_judul[$a]);
    //         //$sheet->getStyle($kolom_number[$a] . $baris)->applyFromArray($this->m_model->styleHeader()) ;

    //         $sheet->getStyle($kolom_number[$a].$baris)->applyFromArray($this->m_model->styleHeader());

    //         $sheet->getStyle($kolom_number[$a].$baris)->getFont()->setBold(true);

    //         $sheet->getStyle($kolom_number[$a].$baris)->getFill()
    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('b9b9bf');

    //         $kolom++;
    //     }



    //     $baris++;
    //     $kolom = 1 ;
    //     $kolom_judul = array("","","","","","","","","","","","Time","","Condition","","Loc","");
    //     for($a=0 ; $a<count($kolom_judul) ; $a++){
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $kolom_judul[$a]);

    //         $sheet->getStyle($kolom_number[$a].$baris)->applyFromArray($this->m_model->styleHeader());

    //         $sheet->getStyle($kolom_number[$a].$baris)->getFont()->setBold(true);

    //         $sheet->getStyle($kolom_number[$a].$baris)->getFill()
    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('b9b9bf');

    //         $kolom++;
    //     }

    //     $baris++;
    //     $kolom = 1 ;
    //     $kolom_judul = array("","","","","","","","","","","","Start","Finish","G","D","","");
    //     for($a=0 ; $a<count($kolom_judul) ; $a++){
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $kolom_judul[$a]);

    //         $sheet->getStyle($kolom_number[$a].$baris)->applyFromArray($this->m_model->styleHeader());

    //         $sheet->getStyle($kolom_number[$a].$baris)->getFont()->setBold(true);

    //         $sheet->getStyle($kolom_number[$a].$baris)->getFill()
    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('b9b9bf');

    //         $kolom++;
    //     }

    //     $sheet->mergeCells('A14:A16'); 
    //     $sheet->mergeCells('B14:B16'); 
    //     $sheet->mergeCells('C14:C16'); 
    //     $sheet->mergeCells('D14:D16'); 
    //     $sheet->mergeCells('E14:E16'); 
    //     $sheet->mergeCells('F14:F16'); 
    //     $sheet->mergeCells('G14:G16'); 
    //     $sheet->mergeCells('H14:H16'); 
    //     $sheet->mergeCells('I14:I16'); 
    //     $sheet->mergeCells('J14:J16'); 
    //     $sheet->mergeCells('K14:K16'); 
    //     $sheet->mergeCells('L14:P14'); 
    //     $sheet->mergeCells('Q14:Q16'); 
    //     $sheet->mergeCells('L15:M15'); 
    //     $sheet->mergeCells('N15:O15'); 
    //     $sheet->mergeCells('P15:P16'); 

    //     $baris++;        
    //     $nomor = 1 ;        
    //     $first_position = "" ;
    //     $last_position = "" ;
    //     foreach($dataExcute->result_array() as $isiexcel){

    //         $kolom = 1 ; $index = 0 ;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, "  ".(string)$nomor);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;
            

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['item_code']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, "");
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['bl_no']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, showdate_dmybc($isiexcel['tgl_bl']));
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleDate()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['consignee_name']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['item_desc']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['party']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['category_kode']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['good_volume']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['good_gross_weight']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, showdate_dmyhis($isiexcel['start_loading']));
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleDate()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, showdate_dmyhis($isiexcel['finish_loading']));
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleDate()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['good']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['damage']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['location_name']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $kolom++; $index++;
    //         $sheet->setCellValueByColumnAndRow($kolom, $baris, $isiexcel['remarks']);
    //         $sheet->getStyle($kolom_number[$index].$baris)->applyFromArray($this->m_model->styleText()) ;

    //         $baris++; $nomor++;
    //     }

    //     $kolom = 1 ;
    //     for($c = 0 ; $c < count($kolom_number) ; $c++ ){
    //         $sheet->getColumnDimensionByColumn($kolom)->setAutoSize(true);
    //         $kolom++;
    //     }




    //     $nama_excel = "Tally_" ;

    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $nama_excel.date_ymdhis(date("Y-m-d H:i:s")). '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }


    // function c_formadd(){


    //     $arrayOperator = array('T1'=> 'Koordinator', 'T2' => 'Tally','T3' => 'YC');
    //     $arraydata = $this->tribltps->query(" SELECT a.bl_no,a.bl_no 'bl_no1' 
    //         from whs_t_stock_detail a 
    //         INNER JOIN whs_t_in_detail dd on a.batch_in = dd.batch_in  
    //         and a.rec_no = dd.rec_no and a.bl_no = dd.bl_no
    //         INNER JOIN whs_m_category b on a.category_id = b.category_id
    //         INNER JOIN whs_m_consignee c on c.consignee_id = a.consignee_id
    //         WHERE a.rec_id = '0' 
    //         GROUP BY a.bl_no,a.consignee_id ")->result_array();
    //     array_push($arraydata, array('bl_no' => '' , 'bl_no1' => 'Cari Bl..'));
    //     $createcombo = array(
    //         'data' => array_reverse($arraydata,true),
    //         'set_data' => array('set_id' => ''),
    //         'attribute' => array('idname' => 'txtNoDo', 'class' => 'selectpicker'),
    //     );
    //     $txtNoDo = ComboDb($createcombo);


    //     $data['kode_trans'] = $this->input->post('kode_trans');
    //     $data['operator'] = $arrayOperator[$this->input->post('kode_trans')];
    //     $data['txtNoDo'] = $txtNoDo;


    //     $arraydata = $this->tribltps->query(" SELECT vessel_id,concat(vessel_name,' ~ ',vessel_voyage) 'vessel_name' FROM whs_m_vessel WHERE rec_id = '0'  ")->result_array();
    //     $createcombo = array(
    //         'data' => $arraydata,
    //         'set_data' => array('set_id' => ''),
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
    //         'set_data' => array('set_id' => ''),
    //         'attribute' => array('idname' => 'txtShipper', 'class' => 'selectpicker'),
    //     );
    //     $txtShipper = ComboDb($createcombo);
    //     $data['txtShipper'] = $txtShipper;


    //     //print_r($data);

    //     $this->load->view('add',$data);
    // }


    

}