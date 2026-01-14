<?php

defined('BASEPATH') or exit('No direct script access allowed');

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

class C_dashboardmanager extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        // if ($this->session->userdata('PO_logged') <> 1) {
        //     redirect(site_url('login'));
        // }

        // require APPPATH . 'libraries/phpmailer/src/Exception.php';
        // require APPPATH . 'libraries/phpmailer/src/PHPMailer.php';
        // require APPPATH . 'libraries/phpmailer/src/SMTP.php';
    }

    function index()
    {
        if ($this->session->userdata('PO_logged') <> 1) {
            redirect(site_url('login'));
        }

        $comp = array(
            'content' => 'view',
        );


        $this->load->view('dashboard/index', $comp);
    }

    function c_authentikasi($encrypted = null)
    {

        $this->load->library('custom_encrypt');

        $this->m_function->string_toSession('pathtemplate', 'v1');

        $dekripsi = $this->custom_encrypt->decode($encrypted);

        $ArrayData = explode("::", $dekripsi);

        $data_email = $ArrayData[0];
        $data_password = $ArrayData[2];
        $data_date = $ArrayData[3];

        // waktu awal
        $startDate = new DateTime($data_date);

        // waktu expired (+2 hari)
        $expiredDate = clone $startDate;
        $expiredDate->modify('+2 days');

        // waktu sekarang
        $now = new DateTime();

        if ($now > $expiredDate) {
            echo "LINK SUDAH EXPIRED";
            die;
        }

        $CI = &get_instance();
        $pepper_key = $CI->config->item('encryption_key');

        $ParamArray = array(
            'Table' => 'masteruser',
            'WhereData' => array('email' => $data_email)
        );

        $dataLogin =  $this->m_function->value_result_row($ParamArray);

        $password_hash_dari_db = $dataLogin->password_hash;


        if ($data_password == $password_hash_dari_db) {
            $data = array(
                'PO_logged' => TRUE,
                'PO_username' => $dataLogin->username,
                'PO_kodedivisi' => $dataLogin->kode_divisi,
                'PO_hakakses' => $dataLogin->hak_akses,
                'PO_email' => $dataLogin->email
            );
            $this->m_function->string_array_toSession($data);

            echo 'login berhasil';
            //die;
            redirect(site_url("dashboardmanager"));
        } else {
            echo 'login gagal/link tidak valid!!!';
            die;
        }
    }

    function c_fetch_table()
    {

        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $ArrayJoin = array(
            array('transpesan_head b', 'a.id_pesan=b.id_pesan', 'inner'),
            array('tbl_request_approval c', 'a.id_status_approval=c.id_status_approval', 'inner')
        );

        $ParamArray = array(
            'Table' => 'tbl_request_po a',
            'WhereData' => array('b.status !=' => 'V', 'a.kode_divisi' => $PO_kodedivisi, 'a.flag_request !=' => '9', 'a.flag_email_manager' => '1'),
            'OrderBy' => 'id_request desc',
            'ArrayJoin' => $ArrayJoin,
            'Field' => 'a.*,b.*,status_approval,hitung_grandtotal(subtotalharga, ppn_param_date(tglpesan), ppn, id_category, discount_total ) AS grandtotal,ppn_param_date(b.tglpesan) AS ppn_used'
            //ppn_param_date(a.tglpesan) AS ppn_used,
        );


        $GetData = $this->m_function->value_result_array($ParamArray);

        echo json_encode($GetData);
    }
}
