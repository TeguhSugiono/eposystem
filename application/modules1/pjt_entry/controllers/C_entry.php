<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_entry extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('autogate_logged') <> 1) {
            redirect(site_url('login'));
        }
        $this->jobpjt = $this->load->database('jobpjt', TRUE);
    }

    function index() {
        
        $menu_active = $this->m_model->menu_active();
        $data = array(
            'content' => 'view',
            'themaweb' => $this->session->userdata('autogate_thema'),
            'menu_dinamis' => $this->m_model->menu_dinamis($menu_active),
        );
        $this->load->view('dashboard/index', $data);
    }

    function c_tbl_chkpjt() {
        $database = "jobpjt";

        $select = 'nojob,tgljob,pibk,tglpibk,nmimportir,nocontainer,size,asalbarang,status';
        $form = 'pjt_check_container';
        $join = array();
        $where = array('aktif' => 0);

        $tgljobstart = @$this->input->post('tgljobstart');
        if ($tgljobstart != "") {
            $tambah_where = array('DATE_FORMAT(tgljob,"%Y-%m-%d") >=' => date_db($tgljobstart));
            $where = array_merge($where, $tambah_where);
        } else {
            $tambah_where = array('DATE_FORMAT(tgljob,"%Y-%m-%d") >=' => date('Y-m-d'));
            $where = array_merge($where, $tambah_where);
        }


        $tgljobend = @$this->input->post('tgljobend');
        if ($tgljobend != "") {
            $tambah_where = array('DATE_FORMAT(tgljob,"%Y-%m-%d") <=' => date_db($tgljobend));
            $where = array_merge($where, $tambah_where);
        } else {
            $tambah_where = array('DATE_FORMAT(tgljob,"%Y-%m-%d") <=' => date('Y-m-d'));
            $where = array_merge($where, $tambah_where);
        }

        $where_term = array(
            'nojob', 'tgljob', 'pibk', 'tglpibk', 'nmimportir', 'nocontainer', 'size', 'asalbarang', 'status'
        );
        $column_order = array(
            null, 'nojob', 'tgljob', 'pibk', 'tglpibk', 'nmimportir', 'nocontainer', 'size', 'asalbarang', 'status'
        );
        $order = array(
            'nojob' => 'desc'
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
            $row[] = $field->nojob;
            $row[] = showdate_dmy($field->tgljob);
            $row[] = $field->pibk;
            $row[] = showdate_dmy($field->tglpibk);
            $row[] = $field->nmimportir;
            $row[] = $field->nocontainer;
            $row[] = $field->size;
            $row[] = $field->asalbarang;
            $row[] = $field->status;
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
        $arraydata = array('20' => '20', '40' => '40', '45' => '45');
        $cbosize = ComboNonDb($arraydata, 'cbosize', '20', 'form-control');

        $data = array(
            'cbosize' => $cbosize,
        );
        $this->load->view('add', $data);
    }

    function c_formedit() {
        $database = "jobpjt";

        $nojob = @$this->input->post('nojob');

        $field_Search = 'nojob,tgljob,pibk,tglpibk,nmimportir,nocontainer,size,asalbarang,status';
        $table_name = 'pjt_check_container';
        $where = array(
            'nojob' => $nojob,
        );
        $array_data = $this->m_model->table_tostring($database, $field_Search, $table_name, '', $where, '');

        $arraydata = array('20' => '20', '40' => '40', '45' => '45');
        $cbosize = ComboNonDb($arraydata, 'cbosize', $array_data['size'], 'form-control');

        $arraydata = array('OnProgress' => 'OnProgress', 'Finish' => 'Finish');
        $cbostatus = ComboNonDb($arraydata, 'cbostatus', $array_data['status'], 'form-control');

        $data = array(
            'cbosize' => $cbosize,
            'cbostatus' => $cbostatus,
            'array_data' => $array_data,
        );
        $this->load->view('edit', $data);
    }

    function c_save() {
        $database = "jobpjt";

        $pesan_data = array(
            'msg' => 'Tidak',
            'pesan' => 'Function Save Data Error....!!!!',
        );

        $tgljob = @$this->input->post('tgljob');
        $nojob = $this->getnojob();
        $pibk = @$this->input->post('pibk');
        $tglpibk = @$this->input->post('tglpibk');
        $nmimportir = @$this->input->post('nmimportir');
        $nocontainer = @$this->input->post('nocontainer');
        $size = @$this->input->post('cbosize');
        $asalbarang = @$this->input->post('asalbarang');
        $tgljob = @$this->input->post('tgljob');


        $cekdata = $this->jobpjt->get_where('pjt_check_container', array('nocontainer' => $nocontainer, 'pibk' => $pibk));
        if ($cekdata->num_rows() > 0) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Kontainer Sudah Pernah Di job....!!!!',
            );
            echo json_encode($pesan_data);
            die;
        } else {


            $data = array(
                'tgljob' => date_db($tgljob),
                'nojob' => date('y') . date('m') . str_pad($nojob, 3, "000", STR_PAD_LEFT),
                'pibk' => $pibk,
                'tglpibk' => date_db($tglpibk),
                'nmimportir' => $nmimportir,
                'nocontainer' => $nocontainer,
                'size' => $size,
                'asalbarang' => $asalbarang,
                'status' => 'OnProgress',
                'aktif' => 0, //jika 0 maka data masih ada, dan jika 9 maka data sudah dihapus
            );

            $hasil = $this->m_model->savedata($database, 'pjt_check_container', $data);
            if ($hasil >= 1) {
                $pesan_data = array(
                    'msg' => 'Ya',
                    'pesan' => 'Save Data Sukses..',
                    'data' => $data,
                );
            } else {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Function Save Data Error....!!!!',
                );
                echo json_encode($pesan_data);
                die;
            }
        }

        echo json_encode($pesan_data);
    }

    function c_update() {
        $database = "jobpjt";

        $pesan_data = array(
            'msg' => 'Tidak',
            'pesan' => 'Function Update Data Error....!!!!',
        );

        $tgljob = @$this->input->post('tgljob');
        $nojob = @$this->input->post('nojob');
        $pibk = @$this->input->post('pibk');
        $tglpibk = @$this->input->post('tglpibk');
        $nmimportir = @$this->input->post('nmimportir');
        $nocontainer = @$this->input->post('nocontainer');
        $size = @$this->input->post('cbosize');
        $asalbarang = @$this->input->post('asalbarang');
        $tgljob = @$this->input->post('tgljob');
        $status = @$this->input->post('cbostatus');

        $where = array(
            'tgljob' => date_db($tgljob),
            'nojob' => $nojob,
        );

        $data = array(
            //'tgljob'        => date_db($tgljob),
            //'nojob'         => date('y').date('m').str_pad($nojob,3,"000",STR_PAD_LEFT),
            'pibk' => $pibk,
            'tglpibk' => date_db($tglpibk),
            'nmimportir' => $nmimportir,
            'nocontainer' => $nocontainer,
            'size' => $size,
            'asalbarang' => $asalbarang,
            'status' => $status,
        );

        $hasil = $this->m_model->updatedata($database, 'pjt_check_container', $data, $where);

        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Update Data Sukses..',
                'where' => $where,
                'data' => $data,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Update Data Error....!!!!',
            );
            echo json_encode($pesan_data);
            die;
        }

        echo json_encode($pesan_data);
    }

    function c_delete() {
        $database = "jobpjt";

        $pesan_data = array(
            'msg' => 'Tidak',
            'pesan' => 'Function Delete Error....!!!!',
        );

        $tgljob = @$this->input->post('tgljob');
        $nojob = @$this->input->post('nojob');

        $where = array(
            'nojob' => $nojob,
        );

        $data = array(
            'aktif' => 9
        );

        $hasil = $this->m_model->updatedata($database, 'pjt_check_container', $data, $where);

        if ($hasil >= 1) {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => 'Update Data Sukses..',
                'where' => $where,
                'data' => $data,
            );
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Function Delete Error....!!!!',
            );
            echo json_encode($pesan_data);
            die;
        }

        echo json_encode($pesan_data);
    }

    function c_printx() {
        $database = "jobpjt";

        $html = ob_get_clean();

        $nojob = $_GET['data'];
        $field_Search = "nojob,tgljob,pibk,tglpibk,nmimportir,nocontainer,size,asalbarang,status,aktif";
        $table_name = 'pjt_check_container';
        $orderby = 'nojob asc';
        $where = array(
            'nojob' => $nojob,
            'aktif !=' => 9,
        );
        $limit = 1;
        $array_data = $this->m_model->table_tostring($database, $field_Search, $table_name, $orderby, $where, $limit);

        $data = array(
            'nojob' => $array_data['nojob'],
            'tgljob' => showdate_dmybc($array_data['tgljob']),
            'tglberlaku' => showdate_dmybc(date('Y-m-d', strtotime('+2 days', strtotime($array_data['tgljob'])))),
            'pibk' => $array_data['pibk'],
            'tglpibk' => showdate_dmybc($array_data['tglpibk']),
            'nmimportir' => $array_data['nmimportir'],
            'nocontainer' => $array_data['nocontainer'],
            'size' => $array_data['size'],
            'asalbarang' => $array_data['asalbarang'],
        );

        $html = $this->load->view('print', $data, true);
        print_r($html);
        
    }
    
    function c_print() {
        include_once (APPPATH . "libraries/phpjasperxml-master/PHPJasperXML.inc.php");
        
        $nojob = $_GET['data'];
        
        $PHPJasperXML = new PHPJasperXML("en","TCPDF"); //if export excel, can use PHPJasperXML("en","XLS OR XLSX"); 
//        $PHPJasperXML->debugsql=true;	
        $PHPJasperXML->arrayParameter = array('nojob'=>$nojob,'jam' => date('H:m'));
//        $PHPJasperXML->debugsql=true;	
        $path = APPPATH . 'modules/report_jasper/report_job_pjt.jrxml';
        
        $PHPJasperXML->load_xml_file($path); //if xml content is string, then $PHPJasperXML->load_xml_string($templatestr);

        //$PHPJasperXML->sql = $sql;  //if you wish to overwrite sql inside jrxml
        $dbdriver="mysql";//natively is 'mysql', 'psql', or 'sqlsrv'. the rest will use PDO driver. for oracle, use 'oci'
        //$PHPJasperXML->transferDBtoArray($DBSERVER,$DBUSER,$DBPASS,$DBNAME,$dbdriver);
        $PHPJasperXML->transferDBtoArray($this->jobpjt->hostname,$this->jobpjt->username,$this->jobpjt->password,$this->jobpjt->database,$dbdriver);
        $PHPJasperXML->outpage('I');  //$PHPJasperXML->outpage('I=render in browser/D=Download/F=save as server side filename according 2nd parameter','filename.pdf or filename.xls or filename.xls depends on constructor');

        
    }

    function getnojob() {
        $database = "jobpjt";

        $tahun = date('y');
        $bulan = date('m');
        $where = array(
            'tahun' => $tahun,
            'bulan' => $bulan,
        );

        $adadata = $this->m_model->select_run_number($database, 'pjt_run_number', 'nomor', $where);

        if ($adadata == 0) {
            //insert data ke runing number table pjt_run_number
            $data = array(
                'tahun' => $tahun,
                'bulan' => $bulan,
                'nomor' => 1,
            );

            $hasil = $this->m_model->savedata($database, 'pjt_run_number', $data);
            $nomor = 1;
        } else {
            $nomor = $this->m_model->select_max_where($database, 'pjt_run_number', 'nomor', $where);

            $data = array(
                'nomor' => $adadata + 1,
            );

            $hasil = $this->m_model->updatedata($database, 'pjt_run_number', $data, $where);
        }

        return $nomor;
    }

}
