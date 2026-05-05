<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        // $this->jobpjt = $this->load->database('jobpjt', TRUE);
    }


    function index($error = NULL)
    {


        $this->m_function->string_toSession('pathtemplate', 'v1');

        // $this->session->unset_userdata('pathtemplate');
        // $datasession = array('pathtemplate' => 'v1');
        // $this->session->set_userdata($datasession);


        $ParamArray = array(
            'Table' => 'mastercompany_po',
            'Field' => 'id_company,nama_company',
            'OrderBy' => 'id_company desc'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('id_company' => '', 'nama_company' => '~Pilih Perusahaan~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'id_company', 'class' => 'select2 form-control form-control-sm', 'placeholder' => '~Pilih Perusahaan~'),
        );
        $id_company = ComboDb($createcombo);

        $comp = array(
            'status_loginku' => $error,
            'id_company' => $id_company,
        );

        $this->load->view('view', $comp);
    }



    function auth()
    {
        $email = $this->input->post('email');
        $password_input = $this->input->post('password');

        $CI = &get_instance();
        $pepper_key = $CI->config->item('encryption_key');


        $ParamArray = array(
            'Table' => 'masteruser',
            'WhereData' => array('email' => $email)
        );

        if ($this->m_function->check_row($ParamArray) > 0) {

            $dataLogin =  $this->m_function->value_result_row($ParamArray);

            $password_hash_dari_db = $dataLogin->password_hash;

            $string_to_verify = $password_input . $pepper_key;

            if (password_verify($string_to_verify, $password_hash_dari_db)) {

                // $Query = "CREATE TABLE IF NOT EXISTS `tbl_configurasi_master`  (
                //     `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                //     `kode_divisi` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                //     `run_number` int NULL DEFAULT NULL,                    
                //     `example_format` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
                // ) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic ";

                // $ParamArray = array(
                //     'Native_Query' => $Query
                // );
                // $this->m_function->execute_native_query($ParamArray);


                // $Query = "CREATE TABLE IF NOT EXISTS `transpesan_det_keterangan`  (
                //     `id_transpesan_det` bigint NULL DEFAULT NULL,
                //     `id_ket_detail` bigint NOT NULL AUTO_INCREMENT,
                //     `seqno` int NULL DEFAULT NULL,
                //     `keteranganbarang` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
                //     PRIMARY KEY (`id_ket_detail`) USING BTREE
                // ) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic ";

                // $ParamArray = array(
                //     'Native_Query' => $Query
                // );
                // $this->m_function->execute_native_query($ParamArray);


                // $Query = " CREATE TABLE IF NOT EXISTS `tbl_request_po`  (
                //     `id_request` bigint NOT NULL AUTO_INCREMENT,
                //     `id_pesan` bigint NULL DEFAULT NULL,
                //     `date_request` date NULL DEFAULT NULL,
                //     `time_request` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                //     `user_request` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                //     `id_status_approval` int NULL DEFAULT NULL,
                //     `acc_manager` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                //     `date_acc_manager` date NULL DEFAULT NULL,
                //     `time_acc_manager` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                //     `acc_director` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                //     `date_acc_director` date NULL DEFAULT NULL,
                //     `time_acc_director` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                //     `flag_request` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
                //     PRIMARY KEY (`id_request`) USING BTREE
                // ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic ";

                // $ParamArray = array(
                //     'Native_Query' => $Query
                // );
                // $this->m_function->execute_native_query($ParamArray);

                $name_tbl_header = "";
                $name_tbl_detail = "";
                $name_tbl_keterangan = "";
                $name_tbl_request = "";
                $name_tbl_qrcode = "";
                $kode_company = "";

                $ParamArray = array(
                    'Table' => 'mastercompany_po',
                    'WhereData' => array('id_company' => $this->input->post('id_company'))
                );
                $arraydata = $this->m_function->value_result_array($ParamArray);

                foreach ($arraydata as $tblTransaksi) {
                    $name_tbl_header = $tblTransaksi['name_tbl_header'];
                    $name_tbl_detail = $tblTransaksi['name_tbl_detail'];
                    $name_tbl_keterangan = $tblTransaksi['name_tbl_keterangan'];
                    $name_tbl_request = $tblTransaksi['name_tbl_request'];
                    $name_tbl_qrcode = $tblTransaksi['name_tbl_qrcode'];
                    $kode_company = $tblTransaksi['kode_company'];
                }


                $data = array(
                    'PO_logged' => TRUE,
                    'PO_username' => $dataLogin->username,
                    'PO_kodedivisi' => $dataLogin->kode_divisi,
                    'PO_hakakses' => $dataLogin->hak_akses,
                    'PO_email' => $dataLogin->email,
                    'PO_name_tbl_header'  => $name_tbl_header,
                    'PO_name_tbl_detail'  => $name_tbl_detail,
                    'PO_name_tbl_keterangan'  => $name_tbl_keterangan,
                    'PO_name_tbl_request'  => $name_tbl_request,
                    'PO_name_tbl_qrcode'  => $name_tbl_qrcode,
                    'PO_kode_company'  => $kode_company,
                );
                $this->m_function->string_array_toSession($data);

                redirect(site_url("dashboard"));
            } else {
                // Password tidak cocok
                $error = 'Email / Password salah... 🤣';
                $this->index($error);
            }
        } else {
            // Email tidak ditemukan
            $error = 'Email / Password salah... 🤣';
            $this->index($error);
        }
    }

    function logout()
    {
        $this->session->unset_userdata('PO_logged');
        $this->session->unset_userdata('PO_username');
        $this->session->unset_userdata('PO_kodedivisi');
        $this->session->unset_userdata('PO_hakakses');
        $this->session->unset_userdata('PO_email');
        $this->session->unset_userdata('PO_name_tbl_header');
        $this->session->unset_userdata('PO_name_tbl_detail');
        $this->session->unset_userdata('PO_name_tbl_keterangan');
        $this->session->unset_userdata('PO_name_tbl_request');
        $this->session->unset_userdata('PO_name_tbl_qrcode');
        $this->session->unset_userdata('PO_kode_company');
        redirect(site_url());
    }

    // function auth()
    // {

    //     $email = $this->input->post('email');
    //     $password = $this->input->post('password');

    //     $CI = &get_instance();
    //     $pepper_key = $CI->config->item('encryption_key');
    //     $string_to_hash = $password . $pepper_key;
    //     $password_hash = password_hash($string_to_hash, PASSWORD_BCRYPT);

    //     $this->db->where(array('email' => $email, 'password_hash' => $password_hash));
    //     $cekLogin = $this->db->get('masteruser');

    //     if ($cekLogin->num_rows() == 1) {

    //         $dataLogin = $cekLogin->row();

    //         $data = array(
    //             'PO_logged' => TRUE,
    //             'PO_username' => $dataLogin->username
    //         );

    //         redirect(site_url("dashboard"));
    //     } else {
    //         $error = 'Email / Password salah 😂' . $password_hash;
    //         $this->index($error);
    //     }
    // }



}
