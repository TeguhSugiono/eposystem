<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_report_direktur extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('PO_logged') <> 1) {
            redirect(site_url('login'));
        }
    }

    function index()
    {

        $arraydata = array(
            '' => 'ALL',
            'MSA' => 'PT.Multi Sejahtera Abadi',
            'BAL' => 'PT.Balrich Logistics',
        );
        $selectperusahaan = ComboNonDbOld($arraydata, 'selectperusahaan', '', 'form-control form-control-sm SettDisplayReport');


        $ParamArray = array(
            'Table' => 'tbl_request_approval',
            'Field' => 'id_status_approval,status_approval',
            'WhereIN' => array('fieldIN' => 'id_status_approval', 'fieldINValue' => array('1', '3', '4'))
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('id_status_approval' => '', 'status_approval' => 'ALL'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'id_status_approval', 'class' => 'form-control form-control-sm SettDisplayReport', 'placeholder' => '~Pilih Type~'),
        );
        $id_status_approval = ComboDb($createcombo);


        $arraydata = array(
            '' => 'ALL',
            'Y' => 'Accept',
            'R' => 'Reject',
            'H' => 'Hold'
        );
        $typeApprove = ComboNonDbOld($arraydata, 'typeApprove', '', 'form-control form-control-sm SettDisplayReport');

        $comp = array(
            'content' => 'view',
            'selectperusahaan' => $selectperusahaan,
            'id_status_approval' => $id_status_approval,
            'typeApprove' => $typeApprove
        );

        $this->load->view('dashboard/index', $comp);
    }

    function c_export()
    {
        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);

        $selectperusahaan = $data[0];
        $id_status_approval = $data[1];
        $typeApprove = $data[2];
        $tglpesan1 = $data[3];
        $tglpesan2 = $data[4];

        $query = " SELECT  'nomor' as 'No',date_format(c.tglpesan,'%d %M %Y') 'Tgl PO',c.nopo 'No Po',b.nama_divisi 'Dept',
                format(c.subtotalharga,2) 'Subtotal',
                ppn_param_date (c.tglpesan) AS 'Ppn',
                format(c.nilai_lain,2) 'Nilai Lain',
                format(c.ppn,2) 'Jml PPN',
                format(hitung_grandtotal (subtotalharga, ppn_param_date (tglpesan), c.ppn, c.id_category, c.discount_total),2) AS 'Grand Total' 
                from tbl_request_po a 
                left JOIN masterdivisi b on a.kode_divisi=b.kode_divisi
                INNER JOIN transpesan_head c on a.id_pesan=c.id_pesan 
                left JOIN mastersupplier d on c.kodesupplier=d.kodesupplier 
                where a.kode_divisi <> '' ";

        if ($selectperusahaan != "") {
            $query .= " and get_company(c.nopo)='" . $selectperusahaan . "' ";
        }

        if ($id_status_approval != "") {
            $query .= " and a.id_status_approval='" . $id_status_approval . "' ";
        }

        if ($typeApprove != "") {
            $query .= " and a.acc_director='" . $typeApprove . "' ";
        }

        if ($tglpesan1 != "") {
            $query .= " and date_format(c.tglpesan,'%Y-%m-%d') >= '" . $tglpesan1 . "' ";
        }

        if ($tglpesan2 != "") {
            $query .= " and date_format(c.tglpesan,'%Y-%m-%d') <= '" . $tglpesan2 . "' ";
        }

        $GetData = $this->db->query($query)->result_array();



        $query2 = " SELECT 'nomor' as 'No',b.nopo,concat(d.itembarang,' ',d.merk,' ',d.type) 'Nama Barang',
                    qtymsk 'Qty',format(hargasatuan,2) 'Harga',
                    format(diskon,2) 'Discount',format(total,2) 'Total'
                    from tbl_request_po a 
                    INNER JOIN transpesan_head b on a.id_pesan=b.id_pesan 
                    INNER JOIN transpesan_det c on b.id_pesan=c.id_pesan
                    INNER JOIN masterbarang d on c.kodebarang=d.kodebarang
                    INNER JOIN masterproyek e on c.kodeproyek=e.kodeproyek ";

        if ($selectperusahaan != "") {
            $query2 .= " and get_company(b.nopo)='" . $selectperusahaan . "' ";
        }

        if ($id_status_approval != "") {
            $query2 .= " and a.id_status_approval='" . $id_status_approval . "' ";
        }

        if ($typeApprove != "") {
            $query2 .= " and a.acc_director='" . $typeApprove . "' ";
        }

        if ($tglpesan1 != "") {
            $query2 .= " and date_format(b.tglpesan,'%Y-%m-%d') >= '" . $tglpesan1 . "' ";
        }

        if ($tglpesan2 != "") {
            $query2 .= " and date_format(b.tglpesan,'%Y-%m-%d') <= '" . $tglpesan2 . "' ";
        }

        $GetData2 = $this->db->query($query2)->result_array();


        //Setting Sheet Excel
        $nama_excel = "Report_PO_" . tanggal_sekarang();

        $nama_sheet = array(
            '0' => 'List PO',
            '1' => 'List Barang'
        );

        $data_all_sheet = array(
            '0' => $GetData,
            '1' => $GetData2
        );

        $setting_xls = array(
            'jumlah_sheet' => 2,
            'nama_excel' => $nama_excel,
            'nama_sheet' => $nama_sheet,
            'data_all_sheet' => $data_all_sheet,
        );

        //print("<pre>".print_r($setting_xls,true)."</pre>"); die;
        $this->m_function->generator_xls($setting_xls);
    }



    function c_fetch_table()
    {

        $selectperusahaan = @$this->input->post('selectperusahaan');
        $id_status_approval = @$this->input->post('id_status_approval');
        $typeApprove = @$this->input->post('typeApprove');
        $tglpesan1 = @$this->input->post('tglpesan1');
        $tglpesan2 = @$this->input->post('tglpesan2');

        //$PO_kodedivisi = $this->session->userdata('PO_kodedivisi');



        $query = " SELECT *,ppn_param_date(c.tglpesan) AS ppn_used,get_company(c.nopo) as comp,b.nama_divisi AS nama_divisi
                from tbl_request_po a 
                left JOIN masterdivisi b on a.kode_divisi=b.kode_divisi
                INNER JOIN transpesan_head c on a.id_pesan=c.id_pesan 
                left JOIN mastersupplier d on c.kodesupplier=d.kodesupplier 
                where a.kode_divisi <> '' ";

        if ($selectperusahaan != "") {
            $query .= " and get_company(c.nopo)='" . $selectperusahaan . "' ";
        }

        if ($id_status_approval != "") {
            $query .= " and a.id_status_approval='" . $id_status_approval . "' ";
        }

        if ($typeApprove != "") {
            $query .= " and a.acc_director='" . $typeApprove . "' ";
        }

        if ($tglpesan1 != "") {
            $query .= " and date_format(c.tglpesan,'%Y-%m-%d') >= '" . $tglpesan1 . "' ";
        }

        if ($tglpesan2 != "") {
            $query .= " and date_format(c.tglpesan,'%Y-%m-%d') <= '" . $tglpesan2 . "' ";
        }


        $GetData = $this->db->query($query)->result_array();

        echo json_encode($GetData);
    }

    function c_add_data()
    {
        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $ParamArray = array(
            'Table' => 'masterdivisi',
            'Field' => 'kode_divisi,nama_divisi'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('kode_divisi' => '', 'nama_divisi' => '~Pilih Divisi~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => $PO_kodedivisi),
            'attribute' => array('idname' => 'kode_divisi', 'class' => 'select2', 'placeholder' => '~Pilih Divisi~'),
        );
        $kode_divisi = ComboDb($createcombo);

        $comp = array(
            'kode_divisi' => $kode_divisi
        );
        $this->load->view('add', $comp);
    }


    function c_save_data()
    {

        //FORMAT KODE Supplier SPL-001-000000001

        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $ParamArray = array(
            'Table' => 'tbl_configurasi_master',
            'WhereData' => array('code' => 'SPL', 'kode_divisi' => $PO_kodedivisi)
        );


        $kodesupplier = "";

        if ($this->m_function->check_row($ParamArray) > 0) {

            $ParamArray['Field'] = 'run_number';

            if ($this->m_function->check_value($ParamArray) == 0 || $this->m_function->check_value($ParamArray) == "") {

                $kodesupplier = 'SPL-' . $PO_kodedivisi . '-' . str_pad(1, 7, '0', STR_PAD_LEFT);

                $SettingNumber = array(
                    'run_number' => 1,
                    'example_format' => $kodesupplier,
                );

                $ParamUpdate = array(
                    'Table' => 'tbl_configurasi_master',
                    'DataUpdate' => $SettingNumber,
                    'WhereData' => array('code' => 'SPL', 'kode_divisi' => $PO_kodedivisi)
                );


                if (!$this->m_function->update_data($ParamUpdate) >= 1) {
                    $pesan_data = array(
                        'msg' => 'Tidak',
                        'pesan' => 'Update ke table tbl_configurasi_master gagal...!!!  😢',
                    );
                    echo json_encode($pesan_data);
                    die;
                }
            } else {

                $GetNo = intval($this->m_function->check_value($ParamArray)) + 1;
                $nomor = $GetNo;
                $kodesupplier = 'SPL-' . $PO_kodedivisi . '-' . str_pad($nomor, 7, '0', STR_PAD_LEFT);

                $SettingNumber = array(
                    'run_number' =>  $GetNo,
                    'example_format' => $kodesupplier
                );


                $ParamUpdate = array(
                    'Table' => 'tbl_configurasi_master',
                    'DataUpdate' => $SettingNumber,
                    'WhereData' => array('code' => 'SPL', 'kode_divisi' => $PO_kodedivisi)
                );

                if (!$this->m_function->update_data($ParamUpdate) >= 1) {
                    $pesan_data = array(
                        'msg' => 'Tidak',
                        'pesan' => 'Update ke table tbl_configurasi_master gagal...!!!  😢',
                    );
                    echo json_encode($pesan_data);
                    die;
                }
            }
        } else {

            $kodesupplier = 'SPL-' . $PO_kodedivisi . '-' . str_pad(1, 7, '0', STR_PAD_LEFT);

            $SettingNumber = array(
                'code' => 'SPL',
                'kode_divisi' => $PO_kodedivisi,
                'run_number' => 1,
                'example_format' => $kodesupplier
            );

            $ParamSave = array(
                'Table' => 'tbl_configurasi_master',
                'DataInsert' => $SettingNumber
            );

            if (!$this->m_function->save_data($ParamSave) >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Insert ke table tbl_configurasi_master gagal...!!!  😢',
                );
                echo json_encode($pesan_data);
                die;
            }
        }

        $namasupplier = $this->input->post('namasupplier');
        $alamat = $this->input->post('alamat');
        $telp = $this->input->post('telp');
        $fax = $this->input->post('fax');

        $ArraySave = array(
            'kodesupplier' => $kodesupplier,
            'namasupplier' => $namasupplier,
            'alamat' => $alamat,
            'telp' => $telp,
            'fax' => $fax,
            'kode_divisi' => $PO_kodedivisi,
            'created_on' => tanggal_sekarang(),
            'created_by' => $this->session->userdata('PO_username')
        );


        $ParamSave = array(
            'Table' => 'mastersupplier',
            'DataInsert' => $ArraySave
        );

        if (!$this->m_function->save_data($ParamSave) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Insert ke table mastersupplier gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Supplier Berhasil Disimpan : " . $kodesupplier . " 😊",
        );
        echo json_encode($pesan_data);
    }


    function c_edit_data($kodesupplier)
    {

        $ParamArray = array(
            'Table' => 'mastersupplier',
            'WhereData' => array('kodesupplier' => $kodesupplier)
        );

        $GetDataEdit = $this->m_function->value_result_row($ParamArray);

        $ParamArray = array(
            'Table' => 'masterdivisi',
            'Field' => 'kode_divisi,nama_divisi'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('kode_divisi' => '', 'nama_divisi' => '~Pilih Divisi~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => $GetDataEdit->kode_divisi),
            'attribute' => array('idname' => 'kode_divisi', 'class' => 'select2', 'placeholder' => '~Pilih Divisi~'),
        );
        $kode_divisi = ComboDb($createcombo);

        $comp = array(
            'kode_divisi' => $kode_divisi,
            'GetDataEdit' => $GetDataEdit
        );
        $this->load->view('edit', $comp);
    }

    function c_update_data()
    {

        $kodesupplier = $this->input->post('kodesupplier');
        $namasupplier = $this->input->post('namasupplier');
        $alamat = $this->input->post('alamat');
        $telp = $this->input->post('telp');
        $fax = $this->input->post('fax');
        $kode_divisi = $this->input->post('kode_divisi');


        $ArrayUpdate = array(
            'namasupplier' => $namasupplier,
            'alamat' => $alamat,
            'telp' => $telp,
            'fax' => $fax,
            'kode_divisi' => $kode_divisi,
            'edited_on' => tanggal_sekarang(),
            'edited_by' => $this->session->userdata('PO_username')
        );

        $ParamUpdate = array(
            'Table' => 'mastersupplier',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('kodesupplier' => $kodesupplier)
        );


        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update ke table mastersupplier gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Supplier Berhasil DiUpdate : " . $kodesupplier . " 😊",
        );
        echo json_encode($pesan_data);
    }

    function c_delete_data()
    {
        $kodesupplier = $this->input->post('kodesupplier');

        $ArrayUpdate = array(
            'flagdelete' => 9,
            'edited_on' => tanggal_sekarang(),
            'edited_by' => $this->session->userdata('PO_username')
        );

        $ParamUpdate = array(
            'Table' => 'mastersupplier',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('kodesupplier' => $kodesupplier)
        );

        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Delete ke table mastersupplier gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Supplier Berhasil Dihapus : " . $kodesupplier . " 😊",
        );
        echo json_encode($pesan_data);
    }
}
