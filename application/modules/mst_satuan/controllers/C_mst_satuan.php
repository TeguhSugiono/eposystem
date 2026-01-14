<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_mst_satuan extends CI_Controller
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
            'Table' => 'satuanbarang',
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


        $namasatuan = $this->input->post('namasatuan');

        $ArraySave = array(
            'namasatuan' => $namasatuan,
            'created_on' => tanggal_sekarang(),
            'created_by' => $this->session->userdata('PO_username')
        );


        $ParamSave = array(
            'Table' => 'satuanbarang',
            'DataInsert' => $ArraySave
        );

        if (!$this->m_function->save_data($ParamSave) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Insert ke table satuanbarang gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Satuan Berhasil Disimpan : " . $namasatuan . " 😊",
        );
        echo json_encode($pesan_data);
    }


    function c_edit_data($no)
    {

        $ParamArray = array(
            'Table' => 'satuanbarang',
            'WhereData' => array('no' => $no)
        );

        $GetDataEdit = $this->m_function->value_result_row($ParamArray);

        $comp = array(
            'GetDataEdit' => $GetDataEdit
        );
        $this->load->view('edit', $comp);
    }

    function c_update_data()
    {

        $no = $this->input->post('no');
        $namasatuan = $this->input->post('namasatuan');



        $ArrayUpdate = array(
            'namasatuan' => $namasatuan,
            'edited_on' => tanggal_sekarang(),
            'edited_by' => $this->session->userdata('PO_username')
        );

        $ParamUpdate = array(
            'Table' => 'satuanbarang',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('no' => $no)
        );


        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update ke table satuanbarang gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data satuanbarang Berhasil DiUpdate : " . $namasatuan . " 😊",
        );
        echo json_encode($pesan_data);
    }

    function c_delete_data()
    {
        $kodesatuan = $this->input->post('kodesatuan');
        $namasatuan = $this->input->post('namasatuan');


        $ArrayUpdate = array(
            'flagdelete' => 9,
            'edited_on' => tanggal_sekarang(),
            'edited_by' => $this->session->userdata('PO_username')
        );


        $ParamUpdate = array(
            'Table' => 'satuanbarang',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('no' => $kodesatuan)
        );

        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Delete ke table satuanbarang gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data satuanbarang Berhasil Dihapus : " . $namasatuan . " 😊",
        );
        echo json_encode($pesan_data);
    }
}
