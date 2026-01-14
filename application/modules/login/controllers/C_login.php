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

        $comp = array(
            'status_loginku' => $error,
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

                $Query = "CREATE TABLE IF NOT EXISTS `tbl_configurasi_master`  (
                    `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                    `kode_divisi` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                    `run_number` int NULL DEFAULT NULL,                    
                    `example_format` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
                ) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic ";

                $ParamArray = array(
                    'Native_Query' => $Query
                );
                $this->m_function->execute_native_query($ParamArray);


                $Query = "CREATE TABLE IF NOT EXISTS `transpesan_det_keterangan`  (
                    `id_transpesan_det` bigint NULL DEFAULT NULL,
                    `id_ket_detail` bigint NOT NULL AUTO_INCREMENT,
                    `seqno` int NULL DEFAULT NULL,
                    `keteranganbarang` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
                    PRIMARY KEY (`id_ket_detail`) USING BTREE
                ) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic ";

                $ParamArray = array(
                    'Native_Query' => $Query
                );
                $this->m_function->execute_native_query($ParamArray);


                $Query = " CREATE TABLE IF NOT EXISTS `tbl_request_po`  (
                    `id_request` bigint NOT NULL AUTO_INCREMENT,
                    `id_pesan` bigint NULL DEFAULT NULL,
                    `date_request` date NULL DEFAULT NULL,
                    `time_request` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                    `user_request` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                    `id_status_approval` int NULL DEFAULT NULL,
                    `acc_manager` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                    `date_acc_manager` date NULL DEFAULT NULL,
                    `time_acc_manager` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                    `acc_director` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                    `date_acc_director` date NULL DEFAULT NULL,
                    `time_acc_director` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                    `flag_request` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
                    PRIMARY KEY (`id_request`) USING BTREE
                ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic ";

                $ParamArray = array(
                    'Native_Query' => $Query
                );
                $this->m_function->execute_native_query($ParamArray);


                $data = array(
                    'PO_logged' => TRUE,
                    'PO_username' => $dataLogin->username,
                    'PO_kodedivisi' => $dataLogin->kode_divisi,
                    'PO_hakakses' => $dataLogin->hak_akses,
                    'PO_email' => $dataLogin->email
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
