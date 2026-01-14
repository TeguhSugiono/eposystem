<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_mst_barang extends CI_Controller
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
        // $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        // $arraydata = $this->db->query("SELECT no,nama FROM categorybarang")->result_array();

        // $ParamArray = array(
        //     'Table' => 'categorybarang',
        //     'Field' => 'no,nama'
        // );

        // $GetData = $this->m_function->value_result_array($ParamArray);

        // print_r($GetData);
        // die;

        $comp = array(
            'content' => 'view'
        );


        $this->load->view('dashboard/index', $comp);
    }


    function c_fetch_table()
    {
        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $ParamArray = array(
            'Table' => 'masterbarang',
            'WhereData' => array('kode_divisi' => $PO_kodedivisi, 'flagdelete' => 0),
            'OrderBy' => 'created_on desc'
        );

        $ParamArray = hakakses($ParamArray);

        $GetData = $this->m_function->value_result_array($ParamArray);

        echo json_encode($GetData);
    }

    function c_add_data()
    {

        $ParamArray = array(
            'Table' => 'categorybarang',
            'Field' => 'nama as "code",nama'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('no' => '', 'nama' => '~Pilih Category~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'category', 'class' => 'select2', 'placeholder' => '~Pilih Category~'),
        );
        $category = ComboDb($createcombo);

        $ParamArray = array(
            'Table' => 'satuanbarang',
            'Field' => 'namasatuan as "code",namasatuan'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('no' => '', 'namasatuan' => '~Pilih Satuan~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'satuan', 'class' => 'select2', 'placeholder' => '~Pilih Satuan~'),
        );
        $satuan = ComboDb($createcombo);

        $comp = array(
            'category' => $category,
            'satuan' => $satuan,
        );
        $this->load->view('add', $comp);
    }


    function c_save_data()
    {

        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $ParamArray = array(
            'Table' => 'tbl_configurasi_master',
            'WhereData' => array('code' => 'BRG', 'kode_divisi' => $PO_kodedivisi)
        );


        $kodebarang = "";

        if ($this->m_function->check_row($ParamArray) > 0) {

            $ParamArray['Field'] = 'run_number';

            if ($this->m_function->check_value($ParamArray) == 0 || $this->m_function->check_value($ParamArray) == "") {

                $kodebarang = 'BRG-' . $PO_kodedivisi . '-' . str_pad(1, 7, '0', STR_PAD_LEFT);

                $SettingNumber = array(
                    'run_number' => 1,
                    'example_format' => $kodebarang,
                );

                $ParamUpdate = array(
                    'Table' => 'tbl_configurasi_master',
                    'DataUpdate' => $SettingNumber,
                    'WhereData' => array('code' => 'BRG', 'kode_divisi' => $PO_kodedivisi)
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
                $kodebarang = 'BRG-' . $PO_kodedivisi . '-' . str_pad($nomor, 7, '0', STR_PAD_LEFT);

                $SettingNumber = array(
                    'run_number' =>  $GetNo,
                    'example_format' => $kodebarang
                );


                $ParamUpdate = array(
                    'Table' => 'tbl_configurasi_master',
                    'DataUpdate' => $SettingNumber,
                    'WhereData' => array('code' => 'BRG', 'kode_divisi' => $PO_kodedivisi)
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

            $kodebarang = 'BRG-' . $PO_kodedivisi . '-' . str_pad(1, 7, '0', STR_PAD_LEFT);

            $SettingNumber = array(
                'code' => 'BRG',
                'kode_divisi' => $PO_kodedivisi,
                'run_number' => 1,
                'example_format' => $kodebarang
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

        $category = $this->input->post('category');
        $itembarang = $this->input->post('itembarang');
        $merk = $this->input->post('merk');
        $type = $this->input->post('type');
        $satuan = $this->input->post('satuan');

        $ArraySave = array(
            'kodebarang' => $kodebarang,
            'category' => $category,
            'itembarang' => $itembarang,
            'merk' => $merk,
            'type' => $type,
            'satuan' => $satuan,
            'kode_divisi' => $PO_kodedivisi,
            'created_on' => tanggal_sekarang(),
            'created_by' => $this->session->userdata('PO_username')
        );


        $ParamSave = array(
            'Table' => 'masterbarang',
            'DataInsert' => $ArraySave
        );

        if (!$this->m_function->save_data($ParamSave) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Insert ke table masterbarang gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Barang Berhasil Disimpan : " . $kodebarang . " 😊",
        );
        echo json_encode($pesan_data);
    }


    function c_edit_data($kodebarang)
    {

        $ParamArray = array(
            'Table' => 'masterbarang',
            'WhereData' => array('kodebarang' => $kodebarang)
        );

        $GetDataEdit = $this->m_function->value_result_row($ParamArray);

        $ParamArray = array(
            'Table' => 'categorybarang',
            'Field' => 'nama as "code",nama'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('no' => '', 'nama' => '~Pilih Category~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => $GetDataEdit->category),
            'attribute' => array('idname' => 'category', 'class' => 'select2', 'placeholder' => '~Pilih Category~'),
        );
        $category = ComboDb($createcombo);

        $ParamArray = array(
            'Table' => 'satuanbarang',
            'Field' => 'namasatuan as "code",namasatuan'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('no' => '', 'namasatuan' => '~Pilih Satuan~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => $GetDataEdit->satuan),
            'attribute' => array('idname' => 'satuan', 'class' => 'select2', 'placeholder' => '~Pilih Satuan~'),
        );
        $satuan = ComboDb($createcombo);

        $comp = array(
            'category' => $category,
            'satuan' => $satuan,
            'GetDataEdit' => $GetDataEdit
        );
        $this->load->view('edit', $comp);
    }

    function c_update_data()
    {


        // $kodebarang = 'BRG-' . $PO_kodedivisi . '-0000000001';

        // $SettingNumber = array(
        //     'run_number' => 1,
        //     'example_format' => $kodebarang,
        // );



        $kodebarang = $this->input->post('kodebarang');
        $category = $this->input->post('category');
        $itembarang = $this->input->post('itembarang');
        $merk = $this->input->post('merk');
        $type = $this->input->post('type');
        $satuan = $this->input->post('satuan');

        $ArrayUpdate = array(
            'category' => $category,
            'itembarang' => $itembarang,
            'merk' => $merk,
            'type' => $type,
            'satuan' => $satuan,
            'edited_on' => tanggal_sekarang(),
            'edited_by' => $this->session->userdata('PO_username')
        );

        $ParamUpdate = array(
            'Table' => 'masterbarang',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('kodebarang' => $kodebarang)
        );


        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update ke table masterbarang gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Barang Berhasil DiUpdate : " . $kodebarang . " 😊",
        );
        echo json_encode($pesan_data);
    }

    function c_delete_data()
    {
        $kodebarang = $this->input->post('kodebarang');

        $ArrayUpdate = array(
            'flagdelete' => 9,
            'edited_on' => tanggal_sekarang(),
            'edited_by' => $this->session->userdata('PO_username')
        );

        $ParamUpdate = array(
            'Table' => 'masterbarang',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('kodebarang' => $kodebarang)
        );

        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Delete ke table masterbarang gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Barang Berhasil Dihapus : " . $kodebarang . " 😊",
        );
        echo json_encode($pesan_data);
    }
}
