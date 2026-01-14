<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_mst_proyek extends CI_Controller
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
        $comp = array(
            'content' => 'view'
        );

        $this->load->view('dashboard/index', $comp);
    }


    function c_fetch_table()
    {

        $ParamArray = array(
            'Table' => 'masterproyek',
            'WhereData' => array('flagdelete' => 0),
            'OrderBy' => 'created_on desc'
        );


        $GetData = $this->m_function->value_result_array($ParamArray);

        echo json_encode($GetData);
    }

    function c_add_data()
    {

        $this->load->view('add');
    }


    function c_save_data()
    {

        //FORMAT KODE proyek SPL-001-000000001

        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        //FORMAT KODE proyek PRY-001-000000001

        $ParamArray = array(
            'Table' => 'tbl_configurasi_master',
            'WhereData' => array('code' => 'PRY')
        );


        $kodeproyek = "";

        if ($this->m_function->check_row($ParamArray) > 0) {

            $ParamArray['Field'] = 'run_number';

            if ($this->m_function->check_value($ParamArray) == 0 || $this->m_function->check_value($ParamArray) == "") {

                $kodeproyek = 'PRY-' . $PO_kodedivisi . '-' . str_pad(1, 4, '0', STR_PAD_LEFT);

                $SettingNumber = array(
                    'run_number' => 1,
                    'example_format' => $kodeproyek,
                );

                $ParamUpdate = array(
                    'Table' => 'tbl_configurasi_master',
                    'DataUpdate' => $SettingNumber,
                    'WhereData' => array('code' => 'PRY')
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
                $kodeproyek = 'PRY-' . $PO_kodedivisi . '-' . str_pad($nomor, 4, '0', STR_PAD_LEFT);

                $SettingNumber = array(
                    'run_number' =>  $GetNo,
                    'example_format' => $kodeproyek
                );


                $ParamUpdate = array(
                    'Table' => 'tbl_configurasi_master',
                    'DataUpdate' => $SettingNumber,
                    'WhereData' => array('code' => 'PRY', 'kode_divisi' => $PO_kodedivisi)
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

            $kodeproyek = 'PRY-' . $PO_kodedivisi . '-' . str_pad(1, 4, '0', STR_PAD_LEFT);

            $SettingNumber = array(
                'code' => 'PRY',
                'kode_divisi' => $PO_kodedivisi,
                'run_number' => 1,
                'example_format' => $kodeproyek
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

        $lokasiproyek = $this->input->post('lokasiproyek');

        $ArraySave = array(
            'kodeproyek' => $kodeproyek,
            'lokasiproyek' => $lokasiproyek,
            'created_on' => tanggal_sekarang(),
            'created_by' => $this->session->userdata('PO_username')
        );


        $ParamSave = array(
            'Table' => 'masterproyek',
            'DataInsert' => $ArraySave
        );

        if (!$this->m_function->save_data($ParamSave) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Insert ke table masterproyek gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Proyek Berhasil Disimpan : " . $kodeproyek . " 😊",
        );
        echo json_encode($pesan_data);
    }


    function c_edit_data($kodeproyek)
    {

        $ParamArray = array(
            'Table' => 'masterproyek',
            'WhereData' => array('kodeproyek' => $kodeproyek)
        );

        $GetDataEdit = $this->m_function->value_result_row($ParamArray);


        $comp = array(
            'GetDataEdit' => $GetDataEdit
        );
        $this->load->view('edit', $comp);
    }

    function c_update_data()
    {

        $kodeproyek = $this->input->post('kodeproyek');
        $lokasiproyek = $this->input->post('lokasiproyek');


        $ArrayUpdate = array(
            'lokasiproyek' => $lokasiproyek,
            'edited_on' => tanggal_sekarang(),
            'edited_by' => $this->session->userdata('PO_username')
        );

        $ParamUpdate = array(
            'Table' => 'masterproyek',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('kodeproyek' => $kodeproyek)
        );


        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update ke table masterproyek gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data proyek Berhasil DiUpdate : " . $kodeproyek . " 😊",
        );
        echo json_encode($pesan_data);
    }

    function c_delete_data()
    {
        $kodeproyek = $this->input->post('kodeproyek');

        $ArrayUpdate = array(
            'flagdelete' => 9,
            'edited_on' => tanggal_sekarang(),
            'edited_by' => $this->session->userdata('PO_username')
        );

        $ParamUpdate = array(
            'Table' => 'masterproyek',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('kodeproyek' => $kodeproyek)
        );

        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Delete ke table masterproyek gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data proyek Berhasil Dihapus : " . $kodeproyek . " 😊",
        );
        echo json_encode($pesan_data);
    }
}
