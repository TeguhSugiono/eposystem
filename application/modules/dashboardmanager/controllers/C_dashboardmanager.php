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
        $expiredDate->modify('+7 days');

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
            'OrderBy' => 'FIELD(a.id_status_approval, 4, 3, 1),a.time_acc_manager desc,a.time_request',
            'ArrayJoin' => $ArrayJoin,
            'Field' => 'a.*,b.*,status_approval,hitung_grandtotal(subtotalharga, ppn_param_date(tglpesan), ppn, id_category, discount_total ) AS grandtotal,ppn_param_date(b.tglpesan) AS ppn_used,
                        (SELECT nama_dept FROM masterdivisi where kode_divisi=a.kode_divisi) dept'
            //ppn_param_date(a.tglpesan) AS ppn_used,
        );


        $GetData = $this->m_function->value_result_array($ParamArray);

        echo json_encode($GetData);
    }

    function c_proses_po()
    {
        $id_pesan = $this->input->post('post_id_pesan');
        $id_request = $this->input->post('post_id_request');

        $ParamArray = array(
            'Table' => 'transpesan_head v',
            'WhereData' => array('id_pesan' => $id_pesan),
            'Field' => '*,(SELECT xx.nama_dept FROM masterdivisi xx where xx.kode_divisi=v.kode_divisi) dept,get_company(nopo) as comp'
        );
        $GetDataHeader = $this->m_function->value_result_array($ParamArray);

        $ParamArray = array(
            'Table' => 'transpesan_det',
            'WhereData' => array('id_pesan' => $id_pesan),
        );
        $GetDataDetail = $this->m_function->value_result_array($ParamArray);

        if ($GetDataHeader[0]['comp'] == "MSA") {
            $ConectDB = "dbAcct";
        } else if ($GetDataHeader[0]['comp'] == "BAL") {
            $ConectDB = "dbAcctBal";
        } else {
            $ConectDB = "dbAcct";
        }

        $ParamArray = array(
            'ConectDB' => $ConectDB,
            'Table' => 'fin_ap_m_supplier',
            'WhereData' => array('suppl_code' => $GetDataHeader[0]['kodesupplier']),
            'Field' => '*,concat(address1," ",address2," ",address3) alamat',
        );
        $GetDataSupplier = $this->m_function->value_result_array($ParamArray);


        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereData' => array('id_request' => $id_request)
        );
        $GetDataRequest = $this->m_function->value_result_array($ParamArray);

        $comp = array(
            'id_pesan' => $id_pesan,
            'id_request' => $id_request,
            'GetDataHeader' => $GetDataHeader,
            'GetDataDetail' => $GetDataDetail,
            'GetDataSupplier' => $GetDataSupplier,
            'GetDataRequest' => $GetDataRequest
        );

        $this->load->view('proses_po', $comp);
    }

    function c_proses_hold_manager()
    {
        $id_pesan_det = $this->input->post('id_pesan_det');
        $id_request_det =  $this->input->post('id_request_det');

        $DataUpdate = array(
            'id_status_approval' => 4, //kode 4 adalah hold po
            'acc_manager' => 'H',
            'time_acc_manager' => tanggal_sekarang(),
            'acc_name_manager' => $this->session->userdata('PO_username')
        );

        $ParamUpdate = array(
            'Table' => 'tbl_request_po',
            'DataUpdate' => $DataUpdate,
            'WhereData' => array('id_request' => $id_request_det)
        );


        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update ke table tbl_request_po gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }


        $pesan_data = array(
            'id_pesan_det' => $id_pesan_det,
            'id_request_det' => $id_request_det,
            'msg' => 'Ya',
            'pesan' => 'Data Po Di Hold...'
        );

        echo json_encode($pesan_data);
    }

    function c_proses_reject_manager()
    {
        $id_pesan_det = $this->input->post('id_pesan_det');
        $id_request_det =  $this->input->post('id_request_det');

        //update ke transpesan_head
        $DataUpdate = array(
            'flag_finish' => 0,
            'flag_id_request' => 0,
        );

        $ParamUpdate = array(
            'Table' => 'transpesan_head',
            'DataUpdate' => $DataUpdate,
            'WhereData' => array('id_pesan' => $id_pesan_det)
        );

        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update ke table transpesan_head gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }


        $DataUpdate = array(
            'id_status_approval' => 1,
            'acc_manager' => 'R',
            'time_acc_manager' => tanggal_sekarang(),
            'acc_name_manager' => $this->session->userdata('PO_username'),
            'flag_request' => 0,
            'flag_email_manager' => 0
        );

        $ParamUpdate = array(
            'Table' => 'tbl_request_po',
            'DataUpdate' => $DataUpdate,
            'WhereData' => array('id_request' => $id_request_det)
        );

        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update ke table tbl_request_po gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => 'Data Po Di Reject...'
        );

        echo json_encode($pesan_data);
    }

    function c_proses_accept_manager()
    {
        $id_pesan_det = $this->input->post('id_pesan_det');
        $id_request_det =  $this->input->post('id_request_det');

        $notifikasi = $this->c_send_notifikasi($id_request_det, $id_pesan_det);
        // echo json_encode($notifikasi);
        // die;

        if ($notifikasi['msg'] == "Ya") {

            $DataUpdate = array(
                'id_status_approval' => 1,
                'acc_manager' => 'Y',
                'time_acc_manager' => tanggal_sekarang(),
                'acc_name_manager' => $this->session->userdata('PO_username'),
            );

            $ParamUpdate = array(
                'Table' => 'tbl_request_po',
                'DataUpdate' => $DataUpdate,
                'WhereData' => array('id_request' => $id_request_det)
            );

            if (!$this->m_function->update_data($ParamUpdate) >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Update ke table tbl_request_po gagal...!!!  😢',
                );
                echo json_encode($pesan_data);
                die;
            }

            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => "Data Po Berhasil Di Approve "
            );

            echo json_encode($pesan_data);
        } else {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => $notifikasi['Respon']['reason'],
            );
            echo json_encode($pesan_data);
        }
    }




    function  c_send_notifikasi($id_request, $id_pesan)
    {
        $this->load->library('Fonnte_guzzle');

        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereData' => array('id_request' => $id_request),
            'Field' => 'kode_divisi'
        );
        $kode_divisi = $this->m_function->check_value($ParamArray);

        // Ambil semua target penerima
        $ParamArray = [
            'Table' => 'tbl_rule_approval',
            'WhereData' => ['kode_divisi' => $kode_divisi]
        ];
        $GetReceivedWA = $this->m_function->value_result_array($ParamArray);

        // Ambil token bayar
        $ParamArray = [
            'Table' => 'tbl_akses_token',
            'WhereData' => ['version' => 'bayar'],
            'Field' => 'token'
        ];
        $TokenBayar = $this->m_function->check_value($ParamArray);

        // Ambil token gratis
        $ParamArray = [
            'Table' => 'tbl_akses_token',
            'WhereData' => ['version' => 'gratis'],
            'Field' => 'token'
        ];
        $Tokengratis = $this->m_function->check_value($ParamArray);


        //isi value wa eposystem
        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereData' => array('flag_request' => 1, 'flag_email_manager' => 1, 'id_request' => $id_request),
            'Clause' => "(flag_email_director=0)",
            'Field' => '*,get_nopo(id_pesan) nopo,(SELECT nama_dept FROM masterdivisi where kode_divisi=tbl_request_po.kode_divisi) nama_dept,
                        (SELECT format(hitung_grandtotal(subtotalharga,ppn_param_date(tglpesan),ppn,id_category,discount_total),2) FROM transpesan_head where id_pesan = tbl_request_po.id_pesan) grandtotal'
        );
        $arrayPoRequest = $this->m_function->value_result_array($ParamArray);


        foreach ($arrayPoRequest as $PoRequest) {

            $flag_email_director = $PoRequest['flag_email_director'];
            $kode_divisi = $PoRequest['kode_divisi'];
            $user_request = ucfirst(strtolower($PoRequest['user_request']));
            $nopo = $PoRequest['nopo'];
            $nama_dept =  $PoRequest['nama_dept'];
            $grandtotal =  format_dolar_nol($PoRequest['grandtotal']);

            $ParamArray = array(
                'Table' => 'tbl_rule_approval',
                'WhereData' => array('kode_divisi' => $kode_divisi)
            );
            $arrayRuler = $this->m_function->value_result_array($ParamArray);

            $email_direktur = $arrayRuler[0]['email_acc2'];
            $email_direktur_name = $arrayRuler[0]['name_acc2'];
            $LinkHash = "";


            if ($flag_email_director == 0) {

                $LinkHash = $this->m_function->CreateLinkManager($email_direktur);

                $ParamUpdate = array(
                    'Table' => 'tbl_request_po',
                    'DataUpdate' => array('flag_email_director' => 1, 'acc_director' => '', 'time_acc_director' => NULL, 'acc_name_director' => ''),
                    'WhereData' => array('id_request' => $PoRequest['id_request'])
                );

                $this->m_function->update_data($ParamUpdate);
            }
        }


        //end isi value wa eposystem


        $longLink = site_url("dashboarddirektur/authentikasi/" . $LinkHash);

        $MessageWa = "*Permohonan Approval Purchase Order (PO)*\n\n" .
            "Dear Pak {$email_direktur_name}\n" .
            "Mohon bantuan untuk melakukan *approval Purchase Order (PO)* dengan detail berikut :\n\n" .
            "No PO : {$nopo}\n" .
            "Grand Total : {$grandtotal}\n" .
            "Diajukan oleh : {$user_request}\n" .
            "Departemen : {$nama_dept}\n\n" .
            "Klik di sini:\n" .
            $longLink . "\n\n" .
            "Terima kasih atas bantuannya...\n\n" .
            "Regards,\nEpoSystem";


        foreach ($GetReceivedWA as $GetReceived) {

            $data = [
                'target' => $GetReceived['phone_acc2'],
                'message' => $MessageWa,
                'countryCode' => '62',
            ];

            // Kirim via bayar
            $Respon = $this->fonnte_guzzle->send($data, $TokenBayar);
            $StatusBayar = (int)($Respon['status'] ?? 0);

            $PesanNotfikasi = array();

            if ($StatusBayar === 1) {
                // echo "✔ Berhasil kirim ke {$data['target']} via BAYAR<br>";
                // continue;
                $PesanNotfikasi = array(
                    'msg' => 'Ya',
                    'pesan' => "✔ Berhasil kirim ke {$data['target']} via BAYAR<br>",
                    'Respon' => $Respon
                );
                return $PesanNotfikasi;
                die;
            } else {
                $PesanNotfikasi = array(
                    'msg' => 'Tidak',
                    'pesan' => "❌ Gagal kirim ke {$data['target']} via BAYAR<br>",
                    'Respon' => $Respon
                );
                // return $PesanNotfikasi;
            }

            // Jika gagal → retry via gratis
            $Respongratis = $this->fonnte_guzzle->send($data, $Tokengratis);
            $Statusgratis = (int)($Respongratis['status'] ?? 0);

            if ($Statusgratis === 1) {
                //echo "✔ Berhasil kirim ke {$data['target']} via gratis<br>";
                $PesanNotfikasi = array(
                    'msg' => 'Ya',
                    'pesan' => "✔ Berhasil kirim ke {$data['target']} via gratis<br>",
                    'Respon' => $Respongratis
                );
                return $PesanNotfikasi;
                die;
            } else {
                //echo "✖ Gagal kirim ke {$data['target']} via BAYAR & gratis<br>";
                $PesanNotfikasi = array(
                    'msg' => 'Tidak',
                    'pesan' => "❌ Gagal kirim ke {$data['target']} via BAYAR & gratis<br>",
                    'Respon' => $Respongratis
                );
                return $PesanNotfikasi;
                die;
            }
        }
    }


    function  c_send_back_notifikasi()
    {
        $this->load->library('Fonnte_guzzle');

        $id_pesan_det = $this->input->post('id_pesan_det');
        $id_request_det = $this->input->post('id_request_det');

        $ParamArray = [
            'Table' => 'tbl_akses_token',
            'WhereData' => ['version' => 'bayar'],
            'Field' => 'token'
        ];
        $TokenBayar = $this->m_function->check_value($ParamArray);

        // Ambil token gratis
        $ParamArray = [
            'Table' => 'tbl_akses_token',
            'WhereData' => ['version' => 'gratis'],
            'Field' => 'token'
        ];
        $Tokengratis = $this->m_function->check_value($ParamArray);

        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereData' => array('id_request' => $id_request_det, 'id_pesan' => $id_pesan_det),
            'Field' => '*,get_nopo(id_pesan) nopo'
        );
        $arrayPoRequest = $this->m_function->value_result_array($ParamArray);

        $ParamArray = array(
            'Table' => 'masteruser',
            'WhereData' => array('username' =>  $arrayPoRequest[0]['user_request']),
            'Field' => 'phone'
        );
        $phone = $this->m_function->check_value($ParamArray);

        $GetPO = "";
        foreach ($arrayPoRequest as $arrayPo) {
            $GetPO = "*" . $arrayPo['nopo'] . "*" . "\n";
        }


        $ParamArray = [
            'Table' => 'tbl_rule_approval',
            'WhereData' => ['kode_divisi' => $arrayPoRequest[0]['kode_divisi']]
        ];
        $GetReceivedWA = $this->m_function->value_result_array($ParamArray);


        $MessageWa = "No PO ini sudah di Approve Oleh Pak {$GetReceivedWA[0]['name_acc1']}\n\n" . $GetPO;

        $data = [
            'target' => $phone,
            'message' => $MessageWa,
            'countryCode' => '62',
        ];



        // Kirim via bayar
        $Respon = $this->fonnte_guzzle->send($data, $TokenBayar);
        $StatusBayar = (int)($Respon['status'] ?? 0);

        $PesanNotfikasi = array();




        if ($StatusBayar === 1) {
            // echo "✔ Berhasil kirim ke {$data['target']} via BAYAR<br>";
            // continue;
            $PesanNotfikasi = array(
                'msg' => 'Ya',
                'pesan' => "Data Po Berhasil Di Approve",
                'Respon' => $Respon
            );
            echo json_encode($PesanNotfikasi);
            die;
        } else {
            $PesanNotfikasi = array(
                'msg' => 'Tidak',
                'pesan' => $Respon['reason'],
                'Respon' => $Respon
            );
            // return $PesanNotfikasi;
        }


        // Jika gagal → retry via gratis
        $Respongratis = $this->fonnte_guzzle->send($data, $Tokengratis);
        $Statusgratis = (int)($Respongratis['status'] ?? 0);

        if ($Statusgratis === 1) {
            //echo "✔ Berhasil kirim ke {$data['target']} via gratis<br>";
            $PesanNotfikasi = array(
                'msg' => 'Ya',
                'pesan' => "Data Po Berhasil Di Approve",
                'Respon' => $Respongratis
            );
            echo json_encode($PesanNotfikasi);
            die;
        } else {
            //echo "✖ Gagal kirim ke {$data['target']} via BAYAR & gratis<br>";
            $PesanNotfikasi = array(
                'msg' => 'Tidak',
                'pesan' => $Respongratis['reason'],
                'Respon' => $Respongratis
            );
            echo json_encode($PesanNotfikasi);
            die;
        }
    }
}
