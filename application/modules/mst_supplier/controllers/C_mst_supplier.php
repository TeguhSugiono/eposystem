<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_mst_supplier extends CI_Controller
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


        $ParamArray = array(
            'ConectDB' => $selectperusahaan,
            'Table' => 'fin_ap_m_supplier',
            'WhereData' => array('active_status' => 'Y'),
            'Field' => '*,concat(address1," ",address2," ",address3) alamat',
            'OrderBy' => 'suppl_name asc'
        );

        $GetData = $this->m_function->value_result_array($ParamArray);

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
