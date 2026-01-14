<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->jobpjt = $this->load->database('jobpjt', TRUE);
    }

    function index($error = NULL) {

        $comp = array(
            'action_btnlogin' => site_url("auth"),
            'status_loginku' => $error,
        );

        $this->load->view('view', $comp);
    }

    function auth() {

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        
        $query = "  SELECT a.id_user,a.username,a.id_group,a.id_home,a.thema_name  FROM tbl_user a 
                        INNER JOIN tbl_menu_group b on a.id_group=b.id_group 
                        where a.username='".$username."' and  password ='".$password."' " ;
        $ceklogin = $this->jobpjt->query($query);

        if ($ceklogin->num_rows() == 1) {
            $data_login = $ceklogin->row();
            $data = array(
                'autogate_logged' => TRUE,
                'autogate_username' => $data_login->username,
                'autogate_userid' => $data_login->id_user,
                'autogate_group' => $data_login->id_group,
                'autogate_home' => $data_login->id_home,
                'autogate_thema' => $data_login->thema_name,
            );

            $this->session->set_userdata($data);

            $this->m_model->drop_temporary();
            
            redirect(site_url("dashboard"));
        } else {
            $error = 'Username / Password salah';
            $this->index($error);
        }
    }

    function logout() {
        $this->session->unset_userdata('autogate_logged');
        $this->session->unset_userdata('autogate_username');
        $this->session->unset_userdata('autogate_userid');
        $this->session->unset_userdata('autogate_group');
        $this->session->unset_userdata('autogate_home');
        $this->session->unset_userdata('autogate_thema');
        redirect(site_url());
    }

}
