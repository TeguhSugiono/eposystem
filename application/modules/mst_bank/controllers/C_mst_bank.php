<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_mst_bank extends CI_Controller
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
            'dbAcct' => 'PT.Multi Sejahtera Abadi',
            'dbAcctBal' => 'PT.Balrich Logistics',
        );
        $selectperusahaan = ComboNonDbOld($arraydata, 'selectperusahaan', 'dbAcct', 'form-control form-control-sm');


        $comp = array(
            'content' => 'view',
            'selectperusahaan' => $selectperusahaan,
        );

        $this->load->view('dashboard/index', $comp);
    }


    function c_fetch_table()
    {

        $selectperusahaan = @$this->input->post('selectperusahaan');

        if ($selectperusahaan === null) {
            $selectperusahaan = 'dbAcct';
        }

        $ArrayJoin = array(
            array('fin_ap_m_supplier b', 'a.id_suppl=b.suppl_code', 'inner'),
        );


        $ParamArray = array(
            'ConectDB' => $selectperusahaan,
            'ArrayJoin' => $ArrayJoin,
            'Table' => 'fin_ap_m_supplier_bank a',
            'WhereData' => array('b.active_status' => 'Y'),
            'OrderBy' => 'a.id_bank desc'
        );

        $GetData = $this->m_function->value_result_array($ParamArray);

        echo json_encode($GetData);
    }


    function c_add_data()
    {

        $perusahaan = $this->input->post('perusahaan');

        $ParamArray = array(
            'ConectDB' => $perusahaan,
            'Table' => 'fin_ap_m_supplier',
            'Field' => 'suppl_code,suppl_name'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('suppl_code' => '', 'suppl_name' => '~Pilih Supplier~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'suppl_code', 'class' => 'select2 form-control form-control-sm', 'placeholder' => '~Pilih Supplier~'),
        );
        $suppl_code = ComboDb($createcombo);


        $comp = array(
            'perusahaan' => $perusahaan,
            'suppl_code' => $suppl_code,
        );
        $this->load->view('add', $comp);
    }

    function c_save_data()
    {

        $db = $this->input->post('database');
        $suppl_code = $this->input->post('suppl_code');
        $atas_nama = $this->input->post('atas_nama');
        $nama_bank = $this->input->post('nama_bank');
        $no_rek = $this->input->post('no_rek');
        $alamat = $this->input->post('alamat');

        $ParamArray = array(
            'ConectDB' => $db,
            'Table' => 'fin_ap_m_supplier_bank',
            'Field' => 'max(id_bank) as id_bank'
        );

        $id_bank = floatval($this->m_function->check_value($ParamArray)) + 1;

        $ArraySave = array(
            'id_bank' => $id_bank,
            'id_suppl' => $suppl_code,
            'atas_nama' => $atas_nama,
            'nama_bank' => $nama_bank,
            'no_rek' => $no_rek,
            'alamat' => $alamat,
            'created_on' => tanggal_sekarang(),
            'created_by' => $this->session->userdata('PO_username')
        );


        $ParamSave = array(
            'ConectDB' => $db,
            'Table' => 'fin_ap_m_supplier_bank',
            'DataInsert' => $ArraySave
        );


        if (!$this->m_function->save_data($ParamSave) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Insert ke table fin_ap_m_supplier_bank gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Bank Berhasil Disimpan : " . $atas_nama . " 😊",
            'ParamSave' => $ParamSave,
        );
        echo json_encode($pesan_data);
    }


    function c_edit_data($id_bank, $perusahaan, $id_suppl)
    {

        // $ParamArray = array(
        //     'ConectDB' => $perusahaan,
        //     'Table' => 'fin_ap_m_supplier_bank',
        //     'WhereData' => array('id_bank' => $id_bank)
        // );

        // $GetDataEdit = $this->m_function->value_result_row($ParamArray);

        // $ParamArray = array(
        //     'Table' => 'masterdivisi',
        //     'Field' => 'kode_divisi,nama_divisi'
        // );
        // $arraydata = $this->m_function->value_result_array($ParamArray);
        // array_push($arraydata, array('kode_divisi' => '', 'nama_divisi' => '~Pilih Divisi~'));

        // $createcombo = array(
        //     'data' => array_reverse($arraydata, true),
        //     'set_data' => array('set_id' => $GetDataEdit->kode_divisi),
        //     'attribute' => array('idname' => 'kode_divisi', 'class' => 'select2', 'placeholder' => '~Pilih Divisi~'),
        // );
        // $kode_divisi = ComboDb($createcombo);

        // $comp = array(
        //     'kode_divisi' => $kode_divisi,
        //     'GetDataEdit' => $GetDataEdit
        // );


        $ParamArray = array(
            'ConectDB' => $perusahaan,
            'Table' => 'fin_ap_m_supplier_bank',
            'WhereData' => array('id_bank' => $id_bank)
        );

        $GetDataEdit = $this->m_function->value_result_row($ParamArray);

        //cari nama supplier
        // $ParamArray = array(
        //     'ConectDB' => $perusahaan,
        //     'Table' => 'fin_ap_m_supplier',
        //     'WhereData' => array('suppl_code' => $id_suppl)
        // );

        // $NamaSupplier = $this->m_function->check_value($ParamArray);
        //end nama supplier


        $ParamArray = array(
            'ConectDB' => $perusahaan,
            'Table' => 'fin_ap_m_supplier',
            'Field' => 'suppl_code,suppl_name',
            'WhereData' => array('suppl_code' => $GetDataEdit->id_suppl)
        );
        $suppl_code = $this->m_function->value_result_row($ParamArray);
        // array_push($arraydata, array('suppl_code' => '', 'suppl_name' => '~Pilih Supplier~'));

        // $createcombo = array(
        //     'data' => array_reverse($arraydata, true),
        //     'set_data' => array('set_id' => $GetDataEdit->id_suppl),
        //     'attribute' => array('idname' => 'suppl_code', 'class' => 'select2 form-control form-control-sm', 'placeholder' => '~Pilih Supplier~'),
        // );
        // $suppl_code = ComboDb($createcombo);


        $comp = array(
            'perusahaan' => $perusahaan,
            'suppl_code' => $suppl_code,
            'GetDataEdit' => $GetDataEdit
        );





        $this->load->view('edit', $comp);
    }

    function c_update_data()
    {
        $db = $this->input->post('database');
        $codesuppl = $this->input->post('codesuppl');
        $id_bank = $this->input->post('id_bank');

        $atas_nama = $this->input->post('atas_nama');
        $nama_bank = $this->input->post('nama_bank');
        $no_rek = $this->input->post('no_rek');
        $alamat = $this->input->post('alamat');

        // $ParamArray = array(
        //     'ConectDB' => $db,
        //     'Table' => 'fin_ap_m_supplier_bank',
        //     'Field' => 'max(id_bank) as id_bank'
        // );

        // $id_bank = floatval($this->m_function->check_value($ParamArray)) + 1;

        $ArrayUpdate = array(
            'atas_nama' => $atas_nama,
            'nama_bank' => $nama_bank,
            'no_rek' => $no_rek,
            'alamat' => $alamat,
            'edited_on' => tanggal_sekarang(),
            'edited_by' => $this->session->userdata('PO_username')
        );


        $ParamUpdate = array(
            'ConectDB' => $db,
            'Table' => 'fin_ap_m_supplier_bank',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('id_bank' => $id_bank)
        );


        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update ke table fin_ap_m_supplier_bank gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Bank Berhasil Diupdate : " . $atas_nama . " 😊",
            'ParamSave' => $ParamUpdate,
        );
        echo json_encode($pesan_data);
    }
}
