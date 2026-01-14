<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class C_dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('PO_logged') <> 1) {
            redirect(site_url('login'));
        }

        require APPPATH . 'libraries/phpmailer/src/Exception.php';
        require APPPATH . 'libraries/phpmailer/src/PHPMailer.php';
        require APPPATH . 'libraries/phpmailer/src/SMTP.php';
    }

    function CreateLinkDirektur($email_manager)
    {

        $this->load->library('custom_encrypt');


        $ParamArray = array(
            'Table' => 'masteruser',
            'WhereData' => array('email' => $email_manager),
            'Field' => 'password_hash',
        );

        $password_hash = $this->m_function->check_value($ParamArray);

        $CI = &get_instance();

        $custom_id = $CI->config->item('encryption_key');
        $data_email = $email_manager;

        $data_password = $password_hash;
        $Date = tanggal_sekarang();

        $delimiter = "::";
        $combined_data = $data_email . $delimiter . $custom_id . $delimiter . $data_password . $delimiter . $Date;

        $id = $combined_data;

        $enkripsi = $this->custom_encrypt->encode($id);

        $dekripsi = $this->custom_encrypt->decode($enkripsi);

        return $enkripsi;
    }


    function CreateLinkManager($email_manager)
    {

        $this->load->library('custom_encrypt');

        $ParamArray = array(
            'Table' => 'masteruser',
            'WhereData' => array('email' => $email_manager),
            'Field' => 'password_hash',
        );

        $password_hash = $this->m_function->check_value($ParamArray);

        $CI = &get_instance();

        $custom_id = $CI->config->item('encryption_key');
        $data_email = $email_manager;
        $data_password = $password_hash;
        $Date = tanggal_sekarang();
        $delimiter = "::";
        $combined_data = $data_email . $delimiter . $custom_id . $delimiter . $data_password . $delimiter . $Date;

        $id = $combined_data;

        $enkripsi = $this->custom_encrypt->encode($id);

        $dekripsi = $this->custom_encrypt->decode($enkripsi);

        return $enkripsi;
    }

    function CreatePasswordHash()
    {
        $CI = &get_instance();

        $password = "";
        $password_plain = $password;

        $pepper_key = $CI->config->item('encryption_key');

        $string_to_hash = $password_plain . $pepper_key;
        $password_hash = password_hash($string_to_hash, PASSWORD_BCRYPT);

        echo "password ==> " . $password_hash;
    }

    function c_proses_approve_direktur()
    {
        $ArrayIdRequest = $this->input->post('ArrayIdRequest');
        $proses_request = $this->input->post('proses_request');
        $ArrayNoPO = $this->input->post('ArrayNoPO');
        $ArrayIdPesan = $this->input->post('ArrayIdPesan');


        for ($a = 0; $a < count($ArrayIdRequest); $a++) {
            $idRequest = $ArrayIdRequest[$a];

            $ArrayUpdate = array(
                'acc_director' => 'Y',
                'time_acc_director' => tanggal_sekarang(),
                'acc_name_director' => $this->session->userdata('PO_username')
            );

            $ParamUpdate = array(
                'Table' => 'tbl_request_po',
                'DataUpdate' => $ArrayUpdate,
                'WhereData' => array('id_request' => $idRequest)
            );


            if (!$this->m_function->update_data($ParamUpdate) >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Update ke table tbl_request_po gagal...!!!  😢',
                );
                echo json_encode($pesan_data);
                die;
            }

            //update ke PO

            $keycode = generateUUID();

            $ArraySave = array(
                'keycode' => $keycode,
                'id_request' => $idRequest,
                'id_pesan' => $ArrayIdPesan[$a],
                'url' => site_url('scanqrcode/' . $keycode),
                'path' => base_url('img_qrcode/' . $keycode . '.png')
            );

            $ParamSave = array(
                'Table' => 'transpesan_qrcode',
                'DataInsert' => $ArraySave
            );

            if (!$this->m_function->save_data($ParamSave) >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Insert ke table transpesan_qrcode gagal...!!!  😢',
                );
                echo json_encode($pesan_data);
                die;
            }


            $this->load->library('ciqrcode');

            $params['data'] = $keycode;
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = FCPATH . 'img_qrcode/' . $keycode . '.png';
            $this->ciqrcode->generate($params);
        }


        //email ke manager dan user
        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereData' => array('acc_manager' => 'Y', 'acc_director' => 'Y'),
            'WhereIN' => array('fieldIN' => 'id_request', 'fieldINValue' => $ArrayIdRequest),
            'Field' => '*,get_nopo(id_pesan) nopo',
            'GroupBy' => 'user_request'
        );

        $GetPO = $this->m_function->value_result_array($ParamArray);

        $htmlTbl = "";
        foreach ($GetPO as $DataPOrequest) {


            $ParamArrayG = array(
                'Table' => 'tbl_request_po',
                'WhereIN' => array('fieldIN' => 'id_request', 'fieldINValue' => $ArrayIdRequest),
                'WhereData' => array('acc_manager' => 'Y', 'acc_director' => 'Y'),
                'Field' => '*,get_nopo(id_pesan) nopo',
                'WhereData' => array('user_request' => $DataPOrequest['user_request'])
            );

            $GroupEmail = $this->m_function->value_result_array($ParamArrayG);

            $htmlTbl = "";
            $htmlTbl = "<br><br>No PO ini Sudah di Approve Oleh Pak {$this->session->userdata('PO_username')}<br><br>";
            $htmlTbl .= "<table cellpadding='4' cellspacing='0' border='0'>";
            foreach ($GroupEmail as $Email) {
                $GetNoPO = $Email['nopo'];
                $htmlTbl .= "<tr><td></td><td></td><td><b>{$GetNoPO}</b></td></tr>";
            }
            $htmlTbl .= "</table>";

            $ParamArrayEM = array(
                'Table' => 'masteruser',
                'WhereData' => array('username' => $DataPOrequest['user_request']),
            );
            $EmailUser = $this->m_function->value_result_array($ParamArrayEM);

            $respon = $this->SendEmailUser($EmailUser[0]['email'], $EmailUser[0]['username'], $htmlTbl);


            $ParamArrayEM = array(
                'Table' => 'masteruser',
                'WhereData' => array('username' => $DataPOrequest['acc_name_manager']),
            );
            $EmailUser = $this->m_function->value_result_array($ParamArrayEM);

            $respon = $this->SendEmailUser($EmailUser[0]['email'], $EmailUser[0]['username'], $htmlTbl);

            if ($respon['msg'] != "Ya") {
                echo json_encode($respon);
                die;
            }
        }


        //end email ke manager dan user




        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Po Berhasil Di Approve "
        );
        echo json_encode($pesan_data);
    }


    function c_proses_reject_manager()
    {
        $ArrayIdRequest = $this->input->post('ArrayIdRequest');
        $proses_request = $this->input->post('proses_request');



        for ($a = 0; $a < count($ArrayIdRequest); $a++) {
            $idRequest = $ArrayIdRequest[$a];

            $ArrayUpdate = array(
                'acc_manager' => 'N',
                'time_acc_manager' => tanggal_sekarang(),
                'acc_name_manager' => $this->session->userdata('PO_username')
            );

            $ParamUpdate = array(
                'Table' => 'tbl_request_po',
                'DataUpdate' => $ArrayUpdate,
                'WhereData' => array('id_request' => $idRequest)
            );


            if (!$this->m_function->update_data($ParamUpdate) >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Update ke table tbl_request_po gagal...!!!  😢',
                );
                echo json_encode($pesan_data);
                die;
            }


            //update ke PO

            $ArrayUpdate = array(
                'flag_finish' => '0',
                'flag_id_request' => '0'
            );

            $ParamUpdate = array(
                'Table' => 'transpesan_head',
                'DataUpdate' => $ArrayUpdate,
                'WhereData' => array('flag_id_request' => $idRequest)
            );


            if (!$this->m_function->update_data($ParamUpdate) >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Update ke table transpesan_head gagal...!!!  😢',
                );
                echo json_encode($pesan_data);
                die;
            }
            //end Update ke PO

        }




        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereIN' => array('fieldIN' => 'id_request', 'fieldINValue' => $ArrayIdRequest),
            'Field' => '*,get_nopo(id_pesan) nopo',
            'GroupBy' => 'user_request'
        );

        $GetPO = $this->m_function->value_result_array($ParamArray);


        $htmlTbl = "";
        foreach ($GetPO as $DataPOrequest) {


            $ParamArrayG = array(
                'Table' => 'tbl_request_po',
                'WhereIN' => array('fieldIN' => 'id_request', 'fieldINValue' => $ArrayIdRequest),
                'Field' => '*,get_nopo(id_pesan) nopo',
                'WhereData' => array('user_request' => $DataPOrequest['user_request'])
            );

            $GroupEmail = $this->m_function->value_result_array($ParamArrayG);

            $htmlTbl = "";
            $htmlTbl = "<br><br>No PO ini Sudah di Reject Oleh Pak {$this->session->userdata('PO_username')}<br><br>";
            $htmlTbl .= "<table cellpadding='4' cellspacing='0' border='0'>";
            foreach ($GroupEmail as $Email) {
                $GetNoPO = $Email['nopo'];
                $htmlTbl .= "<tr><td></td><td></td><td><b>{$GetNoPO}</b></td></tr>";
            }
            $htmlTbl .= "</table>";

            $ParamArrayEM = array(
                'Table' => 'masteruser',
                'WhereData' => array('username' => $DataPOrequest['user_request']),
            );
            $EmailUser = $this->m_function->value_result_array($ParamArrayEM);

            $respon = $this->SendEmailUser($EmailUser[0]['email'], $EmailUser[0]['username'], $htmlTbl);

            if ($respon['msg'] != "Ya") {
                echo json_encode($respon);
                die;
            }
        }


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Po Berhasil Di Reject "
        );
        echo json_encode($pesan_data);
    }

    function c_proses_reject_direktur()
    {
        $ArrayIdRequest = $this->input->post('ArrayIdRequest');
        $proses_request = $this->input->post('proses_request');



        for ($a = 0; $a < count($ArrayIdRequest); $a++) {
            $idRequest = $ArrayIdRequest[$a];

            $ArrayUpdate = array(
                'acc_director' => 'N',
                'time_acc_director' => tanggal_sekarang(),
                'acc_name_director' => $this->session->userdata('PO_username')
            );

            $ParamUpdate = array(
                'Table' => 'tbl_request_po',
                'DataUpdate' => $ArrayUpdate,
                'WhereData' => array('id_request' => $idRequest)
            );


            if (!$this->m_function->update_data($ParamUpdate) >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Update ke table tbl_request_po gagal...!!!  😢',
                );
                echo json_encode($pesan_data);
                die;
            }


            //update ke PO

            $ArrayUpdate = array(
                'flag_finish' => '0',
                'flag_id_request' => '0'
            );

            $ParamUpdate = array(
                'Table' => 'transpesan_head',
                'DataUpdate' => $ArrayUpdate,
                'WhereData' => array('flag_id_request' => $idRequest)
            );


            if (!$this->m_function->update_data($ParamUpdate) >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Update ke table transpesan_head gagal...!!!  😢',
                );
                echo json_encode($pesan_data);
                die;
            }
            //end Update ke PO

        }




        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereIN' => array('fieldIN' => 'id_request', 'fieldINValue' => $ArrayIdRequest),
            'Field' => '*,get_nopo(id_pesan) nopo',
            'GroupBy' => 'user_request'
        );

        $GetPO = $this->m_function->value_result_array($ParamArray);


        $htmlTbl = "";
        foreach ($GetPO as $DataPOrequest) {


            $ParamArrayG = array(
                'Table' => 'tbl_request_po',
                'WhereIN' => array('fieldIN' => 'id_request', 'fieldINValue' => $ArrayIdRequest),
                'Field' => '*,get_nopo(id_pesan) nopo',
                'WhereData' => array('user_request' => $DataPOrequest['user_request'])
            );

            $GroupEmail = $this->m_function->value_result_array($ParamArrayG);

            $htmlTbl = "";
            $htmlTbl = "<br><br>No PO ini Sudah di Reject Oleh Pak {$this->session->userdata('PO_username')}<br><br>";
            $htmlTbl .= "<table cellpadding='4' cellspacing='0' border='0'>";
            foreach ($GroupEmail as $Email) {
                $GetNoPO = $Email['nopo'];
                $htmlTbl .= "<tr><td></td><td></td><td><b>{$GetNoPO}</b></td></tr>";
            }
            $htmlTbl .= "</table>";

            $ParamArrayEM = array(
                'Table' => 'masteruser',
                'WhereData' => array('username' => $DataPOrequest['user_request']),
            );
            $EmailUser = $this->m_function->value_result_array($ParamArrayEM);

            $respon = $this->SendEmailUser($EmailUser[0]['email'], $EmailUser[0]['username'], $htmlTbl);

            if ($respon['msg'] != "Ya") {
                echo json_encode($respon);
                die;
            }


            //email ke manager

            $ParamArrayMgr = array(
                'Table' => 'masteruser',
                'WhereData' => array('username' => $DataPOrequest['acc_name_manager']),
            );
            $EmailManager = $this->m_function->value_result_array($ParamArrayMgr);

            $respon = $this->SendEmailUser($EmailManager[0]['email'], $EmailManager[0]['username'], $htmlTbl);

            if ($respon['msg'] != "Ya") {
                echo json_encode($respon);
                die;
            }
            //end email ke manager











        }


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Po Berhasil Di Reject "
        );
        echo json_encode($pesan_data);
    }

    function c_proses_approve_manager()
    {

        $ArrayIdRequest = $this->input->post('ArrayIdRequest');
        $proses_request = $this->input->post('proses_request');

        for ($a = 0; $a < count($ArrayIdRequest); $a++) {
            $idRequest = $ArrayIdRequest[$a];

            $ArrayUpdate = array(
                'acc_manager' => 'Y',
                'time_acc_manager' => tanggal_sekarang(),
                'acc_name_manager' => $this->session->userdata('PO_username')
            );

            $ParamUpdate = array(
                'Table' => 'tbl_request_po',
                'DataUpdate' => $ArrayUpdate,
                'WhereData' => array('id_request' => $idRequest)
            );


            if (!$this->m_function->update_data($ParamUpdate) >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Update ke table tbl_request_po gagal...!!!  😢',
                );
                echo json_encode($pesan_data);
                die;
            }
        }

        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereIN' => array('fieldIN' => 'id_request', 'fieldINValue' => $ArrayIdRequest),
            'Field' => '*,get_nopo(id_pesan) nopo',
            'GroupBy' => 'user_request'
        );

        $GetPO = $this->m_function->value_result_array($ParamArray);

        $htmlTbl = "";
        foreach ($GetPO as $DataPOrequest) {


            $ParamArrayG = array(
                'Table' => 'tbl_request_po',
                'WhereIN' => array('fieldIN' => 'id_request', 'fieldINValue' => $ArrayIdRequest),
                'Field' => '*,get_nopo(id_pesan) nopo',
                'WhereData' => array('user_request' => $DataPOrequest['user_request'])
            );

            $GroupEmail = $this->m_function->value_result_array($ParamArrayG);

            $htmlTbl = "";
            $htmlTbl = "<br><br>No PO ini Sudah di Approve Oleh Pak {$this->session->userdata('PO_username')}<br><br>";
            $htmlTbl .= "<table cellpadding='4' cellspacing='0' border='0'>";
            foreach ($GroupEmail as $Email) {
                $GetNoPO = $Email['nopo'];
                $htmlTbl .= "<tr><td></td><td></td><td><b>{$GetNoPO}</b></td></tr>";
            }
            $htmlTbl .= "</table>";

            $ParamArrayEM = array(
                'Table' => 'masteruser',
                'WhereData' => array('username' => $DataPOrequest['user_request']),
            );
            $EmailUser = $this->m_function->value_result_array($ParamArrayEM);

            $respon = $this->SendEmailUser($EmailUser[0]['email'], $EmailUser[0]['username'], $htmlTbl);

            if ($respon['msg'] != "Ya") {
                echo json_encode($respon);
                die;
            }
        }


        //Proses Untuk Kirim PO Ke Direktur

        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereData' => array('flag_request' => 1, 'acc_manager' => 'Y'),
            'WhereIN' => array('fieldIN' => 'id_request', 'fieldINValue' => $ArrayIdRequest),
            'Field' => '*,get_nopo(id_pesan) nopo,(SELECT nama_dept FROM masterdivisi where kode_divisi=tbl_request_po.kode_divisi) nama_dept,
                        (SELECT format(hitung_grandtotal(subtotalharga,ppn_param_date(tglpesan),ppn,id_category,discount_total),2) FROM transpesan_head where id_pesan = tbl_request_po.id_pesan) grandtotal'

        );

        $GetPO = $this->m_function->value_result_array($ParamArray);

        foreach ($GetPO as $DataPOrequest) {

            $ParamArrayRuler = array(
                'Table' => 'tbl_rule_approval',
                'WhereData' => array('kode_divisi' => $DataPOrequest['kode_divisi'])
            );
            $arrayRuler = $this->m_function->value_result_array($ParamArrayRuler);

            $email_direktor = $arrayRuler[0]['email_acc2'];
            $email_direktor_name = $arrayRuler[0]['name_acc2'];

            $respon = $this->SendEmailDirektur($email_direktor, $email_direktor_name, $DataPOrequest['user_request'], $DataPOrequest['nopo'], $DataPOrequest['nama_dept'], $DataPOrequest['grandtotal']);

            if ($respon['msg'] == "Ya") {
                $ParamUpdate = array(
                    'Table' => 'tbl_request_po',
                    'DataUpdate' => array('flag_email_director' => 1),
                    'WhereData' => array('id_request' => $DataPOrequest['id_request'])
                );

                $this->m_function->update_data($ParamUpdate);
            }
        }

        //End Proses Untuk Kirim PO Ke Direktur


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Po Berhasil Di Approve "
        );
        echo json_encode($pesan_data);
    }

    function SendEmailUser($EmailUser, $NamaUser, $htmlTbl)
    {

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host       = 'mailserver.ptmsa.co.id';
        $mail->SMTPAuth   = true;
        $mail->Username   = "info_po@balrich.co.id";
        $mail->Password   = "ms@.info_po@@@";
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('info_po@balrich.co.id', 'System Info PO');
        $mail->addAddress($EmailUser, $NamaUser);

        $mail->isHTML(true);
        $mail->Subject = "Permohonan Approval Purchase Order (PO)";
        $mail->Body    = $htmlTbl;

        if (!$mail->send()) {
            return array(
                'msg'   => 'Tidak',
                'pesan' => 'Email gagal dikirim: ' . $mail->ErrorInfo
            );
        } else {
            return array(
                'msg'   => 'Ya',
                'pesan' => 'Email approval berhasil dikirim'
            );
        }
    }

    function SendEmailDirektur($email_direktur, $email_direktur_name, $user_request, $nopo, $nama_dept, $grandtotal)
    {

        $LinkHash = $this->CreateLinkDirektur($email_direktur);

        // SUBJECT
        $txtsubject = "Permohonan Approval Purchase Order (PO)";

        $txtmessage  = "Dear Pak {$email_direktur_name},<br><br>";
        $txtmessage .= "Mohon bantuan untuk melakukan <b>approval Purchase Order (PO)</b> dengan detail berikut:<br><br>";
        $txtmessage .= "<table cellpadding='4' cellspacing='0' border='0'>";
        $txtmessage .= "<tr><td>No PO</td><td>:</td><td><b>{$nopo}</b></td></tr>";
        $txtmessage .= "<tr><td>Grand Total</td><td>:</td><td><b>{$grandtotal}</b></td></tr>";
        $txtmessage .= "<tr><td>Diajukan oleh</td><td>:</td><td>{$user_request}</td></tr>";
        $txtmessage .= "<tr><td>Departemen</td><td>:</td><td>{$nama_dept}</td></tr>";
        $txtmessage .= "</table><br>";
        $txtmessage .= site_url("/dashboarddirektur/authentikasi/" . "$LinkHash") . "<br><br><br>";
        $txtmessage .= "Terima kasih atas bantuannya.<br><br>";
        $txtmessage .= "Regards,<br>";
        $txtmessage .= "<b>System Info PO</b>";

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host       = 'mailserver.ptmsa.co.id';
        $mail->SMTPAuth   = true;
        $mail->Username   = "info_po@balrich.co.id";
        $mail->Password   = "ms@.info_po@@@";
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('info_po@balrich.co.id', 'System Info PO');
        $mail->addAddress($email_direktur, $email_direktur_name);

        $mail->isHTML(true);
        $mail->Subject = $txtsubject;
        $mail->Body    = $txtmessage;

        if (!$mail->send()) {
            return array(
                'msg'   => 'Tidak',
                'pesan' => 'Email gagal dikirim: ' . $mail->ErrorInfo
            );
        } else {
            return array(
                'msg'   => 'Ya',
                'pesan' => 'Email approval berhasil dikirim'
            );
        }
    }

    function SendEmailManager($email_manager, $email_manager_name, $user_request, $nopo, $nama_dept, $grandtotal)
    {

        $LinkHash = $this->CreateLinkManager($email_manager);

        // SUBJECT
        $txtsubject = "Permohonan Approval Purchase Order (PO)";

        $txtmessage  = "Dear Pak {$email_manager_name},<br><br>";
        $txtmessage .= "Mohon bantuan untuk melakukan <b>approval Purchase Order (PO)</b> dengan detail berikut:<br><br>";
        $txtmessage .= "<table cellpadding='4' cellspacing='0' border='0'>";
        $txtmessage .= "<tr><td>No PO</td><td>:</td><td><b>{$nopo}</b></td></tr>";
        $txtmessage .= "<tr><td>Grand Total</td><td>:</td><td><b>{$grandtotal}</b></td></tr>";
        $txtmessage .= "<tr><td>Diajukan oleh</td><td>:</td><td>{$user_request}</td></tr>";
        $txtmessage .= "<tr><td>Departemen</td><td>:</td><td>{$nama_dept}</td></tr>";
        $txtmessage .= "</table><br>";
        $txtmessage .= site_url("/dashboardmanager/authentikasi/" . "$LinkHash") . "<br><br><br>";
        $txtmessage .= "Terima kasih atas bantuannya.<br><br>";
        $txtmessage .= "Regards,<br>";
        $txtmessage .= "<b>System Info PO</b>";

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host       = 'mailserver.ptmsa.co.id';
        $mail->SMTPAuth   = true;
        $mail->Username   = "info_po@balrich.co.id";
        $mail->Password   = "ms@.info_po@@@";
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('info_po@balrich.co.id', 'System Info PO');
        $mail->addAddress($email_manager, $email_manager_name);

        $mail->isHTML(true);
        $mail->Subject = $txtsubject;
        $mail->Body    = $txtmessage;

        if (!$mail->send()) {
            return array(
                'msg'   => 'Tidak',
                'pesan' => 'Email gagal dikirim: ' . $mail->ErrorInfo
            );
        } else {
            return array(
                'msg'   => 'Ya',
                'pesan' => 'Email approval berhasil dikirim'
            );
        }
    }


    function c_sendEmail()
    {

        $id_request = $this->input->post('id_request');

        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereData' => array('flag_request' => 1, 'id_request' => $id_request),
            'Clause' => "(flag_email_manager = 0 or flag_email_director=0)",
            'Field' => '*,get_nopo(id_pesan) nopo,(SELECT nama_dept FROM masterdivisi where kode_divisi=tbl_request_po.kode_divisi) nama_dept,
                        (SELECT format(hitung_grandtotal(subtotalharga,ppn_param_date(tglpesan),ppn,id_category,discount_total),2) FROM transpesan_head where id_pesan = tbl_request_po.id_pesan) grandtotal'
        );
        $arrayPoRequest = $this->m_function->value_result_array($ParamArray);

        $flag_email_manager = 0;
        $flag_email_director = 0;
        $kode_divisi = "";
        $nama_dept = "";
        $nopo = "";
        $grandtotal = 0;

        $email_manager = "";
        $email_manager_name = "";

        $email_direktor = "";
        $email_direktor_name = "";

        $respon = array();

        foreach ($arrayPoRequest as $PoRequest) {
            $flag_email_manager = $PoRequest['flag_email_manager'];
            $flag_email_director = $PoRequest['flag_email_director'];
            $kode_divisi = $PoRequest['kode_divisi'];
            $user_request = $PoRequest['user_request'];
            $nopo = $PoRequest['nopo'];
            $nama_dept =  $PoRequest['nama_dept'];
            $grandtotal =  $PoRequest['grandtotal'];

            $ParamArray = array(
                'Table' => 'tbl_rule_approval',
                'WhereData' => array('kode_divisi' => $kode_divisi)
            );
            $arrayRuler = $this->m_function->value_result_array($ParamArray);

            $email_manager = $arrayRuler[0]['email_acc1'];
            $email_manager_name = $arrayRuler[0]['name_acc1'];

            $email_direktor = $arrayRuler[0]['email_acc2'];
            $email_direktor_name = $arrayRuler[0]['name_acc2'];


            if ($flag_email_manager == 0) {

                $respon = $this->SendEmailManager($email_manager, $email_manager_name, $user_request, $nopo, $nama_dept, $grandtotal);

                if ($respon['msg'] == "Ya") {
                    $ParamUpdate = array(
                        'Table' => 'tbl_request_po',
                        'DataUpdate' => array('flag_email_manager' => 1),
                        'WhereData' => array('id_request' => $PoRequest['id_request'])
                    );

                    $this->m_function->update_data($ParamUpdate);
                }
            } else {
                //$flag_email_manager == 1




            }
        }


        echo json_encode($respon);
    }

    function index()
    {


        // $ParamArray = array(
        //     'Table' => 'tbl_request_po',
        //     'WhereData' => array('flag_request' => 1),
        //     'Clause' => "(flag_email_manager = 0 or flag_email_director=0)",
        // );
        // $arrayPoRequest = $this->m_function->value_result_array($ParamArray);

        // echo $this->db->last_query();
        // die;




        $comp = array(
            'content' => 'view',
        );


        $this->load->view('dashboard/index', $comp);
    }
}
