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

        $arraydata = array(
            'all' => 'All Data',
            'yes' => 'Sudah Proses',
            'no' => 'Belum Proses'
        );
        $prosesPO = ComboNonDbOld($arraydata, 'prosesPO', 'no', 'form-control form-control-sm');


        $comp = array(
            'content' => 'view',
            'prosesPO' => $prosesPO
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

        $prosesPO = $this->input->post('prosesPO');

        // $ArrayJoin = array(
        //     array('transpesan_head b', 'a.id_pesan=b.id_pesan', 'inner'),
        //     array('tbl_request_approval c', 'a.id_status_approval=c.id_status_approval', 'inner')
        // );

        // $ParamArray = array(
        //     'Table' => 'tbl_request_po a',
        //     'WhereData' => array('b.status !=' => 'V', 'a.kode_divisi' => $PO_kodedivisi, 'a.flag_request !=' => '9', 'a.flag_email_manager' => '1'),
        //     'OrderBy' => 'FIELD(a.id_status_approval, 4, 3,2, 1),b.nopo ASC,a.time_acc_manager desc,a.time_request',
        //     'ArrayJoin' => $ArrayJoin,
        //     'Field' => 'a.*,b.*,status_approval,hitung_grandtotal(subtotalharga, ppn_param_date(tglpesan), ppn, id_category, discount_total ) AS grandtotal,ppn_param_date(b.tglpesan) AS ppn_used,
        //                 (SELECT nama_dept FROM masterdivisi where kode_divisi=a.kode_divisi) dept'
        // );


        // $GetData = $this->m_function->value_result_array($ParamArray);

        $query = "
                    SELECT * FROM (

                    SELECT a.id_request,a.id_pesan,a.time_request,a.user_request,a.reason,a.id_status_approval,a.acc_manager,
                    a.time_acc_manager,a.acc_name_manager,a.acc_director,a.time_acc_director,a.acc_name_director,
                    a.kode_divisi,a.flag_request,a.flag_email_manager,a.flag_email_director,a.seqno_revisi,
                    b.no,b.tglpesan,b.nopo,b.kodesupplier,b.noreff,b.nomr,b.dateedited,b.useredited,b.tglkrm,
                    b.tgltempo,b.matauang,b.pembayaran,b.status,b.subtotalharga,b.ppn,b.keterangan,b.id_bank,b.discount_total,b.ttd,
                    b.no_invoice,b.faktur_pajak,b.tgl_invoice,b.rec_id,b.lain,b.id_category,b.nilai_lain,b.created_on,b.created_by,
                    b.flag_finish,b.flag_id_request,b.flag_revisi
                    ,status_approval,hitung_grandtotal(subtotalharga, ppn_param_date(tglpesan), ppn, 
                    id_category, discount_total ) AS grandtotal,ppn_param_date(b.tglpesan) AS ppn_used,
                    (SELECT nama_dept FROM masterdivisi where kode_divisi=a.kode_divisi) dept
                    FROM tbl_request_po a
                    INNER JOIN `transpesan_head` `b` ON `a`.`id_pesan`=`b`.`id_pesan`
                    INNER JOIN `tbl_request_approval` `c` ON `a`.`id_status_approval`=`c`.`id_status_approval`
                    where a.id_request not in (SELECT id_request from transpesan_head_old)
                    and b.status != 'V' and a.flag_request != '9' and a.flag_email_manager = '1' 
                    and a.kode_divisi = '" . $PO_kodedivisi . "' ";

        if ($prosesPO == "yes") {
            $query .= " and ifnull(a.acc_manager,'') <> '' ";
        } else if ($prosesPO == "no") {
            $query .= " and ifnull(a.acc_manager,'') = '' ";
        }

        $query .= "       UNION ALL

                    SELECT 
                    a.id_request,a.id_pesan,a.time_request,a.user_request,a.reason,a.id_status_approval,a.acc_manager,
                    a.time_acc_manager,a.acc_name_manager,a.acc_director,a.time_acc_director,a.acc_name_director,
                    a.kode_divisi,a.flag_request,a.flag_email_manager,a.flag_email_director,a.seqno_revisi,
                    b.no,b.tglpesan,b.nopo,b.kodesupplier,b.noreff,b.nomr,b.dateedited,b.useredited,b.tglkrm,
                    b.tgltempo,b.matauang,b.pembayaran,b.status,b.subtotalharga,b.ppn,b.keterangan,b.id_bank,b.discount_total,b.ttd,
                    b.no_invoice,b.faktur_pajak,b.tgl_invoice,b.rec_id,b.lain,b.id_category,b.nilai_lain,b.created_on,b.created_by,
                    b.flag_finish,b.flag_id_request,b.flag_revisi
                    ,status_approval,hitung_grandtotal(subtotalharga, ppn_param_date(tglpesan), ppn, 
                    id_category, discount_total ) AS grandtotal,ppn_param_date(b.tglpesan) AS ppn_used,
                    (SELECT nama_dept FROM masterdivisi where kode_divisi=a.kode_divisi) dept
                    FROM tbl_request_po a
                    INNER JOIN `transpesan_head_old` `b` ON `a`.`id_request`=`b`.`id_request`
                    INNER JOIN `tbl_request_approval` `c` ON `a`.`id_status_approval`=`c`.`id_status_approval`
                    and b.status != 'V' and a.flag_request != '9' and a.flag_email_manager = '1' 
                    and a.kode_divisi = '" . $PO_kodedivisi . "' ";

        if ($prosesPO == "yes") {
            $query .= " and ifnull(a.acc_manager,'') <> '' ";
        } else if ($prosesPO == "no") {
            $query .= " and ifnull(a.acc_manager,'') = '' ";
        }

        $query .= "            ) x
                    ORDER BY  FIELD(id_status_approval, 4, 3,2, 1),time_acc_director desc,time_request ";
        //ORDER BY  id_request ASC,nopo ASC ";



        $GetData =  $this->db->query($query)->result_array();

        echo json_encode($GetData);
    }

    function c_proses_po()
    {
        $id_pesan = $this->input->post('post_id_pesan');
        $id_request = $this->input->post('post_id_request');

        //cek dulu ke old data jika ada pakai data yg old

        $ckdta = $this->db->get_where('transpesan_head_old', array('id_pesan' => $id_pesan, 'id_request' => $id_request));

        //$hehehe = "";

        if ($ckdta->num_rows() == 0) {
            //$hehehe = 1;
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


            $ParamArray = array(
                'Table' => 'mastersupplier',
                'WhereData' => array('kodesupplier' => $GetDataHeader[0]['kodesupplier']),
                'Field' => '*,kodesupplier as suppl_code,namasupplier as suppl_name',
            );
            $GetDataSupplier = $this->m_function->value_result_array($ParamArray);
        } else {

            $ParamArray = array(
                'Table' => 'transpesan_head_old v',
                'WhereData' => array('id_pesan' => $id_pesan, 'id_request' => $id_request),
                'Field' => '*,(SELECT xx.nama_dept FROM masterdivisi xx where xx.kode_divisi=v.kode_divisi) dept,get_company(nopo) as comp,
                            concat(address1," ",address2," ",address3) as alamat'
            );
            $GetDataHeader = $this->m_function->value_result_array($ParamArray);

            //$hehehe =  $GetDataHeader;

            $GetDataSupplier = $this->m_function->value_result_array($ParamArray);

            $ParamArray = array(
                'Table' => 'transpesan_det_old',
                'WhereData' => array('id_pesan' => $id_pesan, 'id_old' => $GetDataHeader[0]['id_old']),
            );
            $GetDataDetail = $this->m_function->value_result_array($ParamArray);
        }




        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereData' => array('id_request' => $id_request)
        );
        $GetDataRequest = $this->m_function->value_result_array($ParamArray);

        $GetDataHeaderOld = array();
        $GetDataDetailOld = array();

        if ($GetDataRequest[0]['id_status_approval'] == '3') {
            $ParamArray = array(
                'Table' => 'transpesan_head_old v',
                'WhereData' => array('id_pesan' => $id_pesan),
                'Field' => '*,(SELECT xx.nama_dept FROM masterdivisi xx where xx.kode_divisi=v.kode_divisi) dept,get_company(nopo) as comp,
                            concat(address1," ",address2," ",address3) alamat,ppn_param_date(v.tglpesan) AS ppn_used,
                            hitung_grandtotal(subtotalharga, ppn_param_date(tglpesan), ppn, 
                            id_category, discount_total ) AS grandtotal'
            );
            $GetDataHeaderOld = $this->m_function->value_result_array($ParamArray);

            $ParamArray = array(
                'Table' => 'transpesan_det_old',
                'WhereData' => array('id_pesan' => $id_pesan),
            );
            $GetDataDetailOld = $this->m_function->value_result_array($ParamArray);
        }

        $comp = array(
            'id_pesan' => $id_pesan,
            'id_request' => $id_request,
            'GetDataHeader' => $GetDataHeader,
            'GetDataDetail' => $GetDataDetail,
            'GetDataSupplier' => $GetDataSupplier,
            'GetDataRequest' => $GetDataRequest,
            'GetDataHeaderOld' => $GetDataHeaderOld,
            'GetDataDetailOld' => $GetDataDetailOld,
            //'hehehe' => $hehehe
        );

        $this->load->view('proses_po', $comp);
    }




    function c_fetch_table_detail()
    {
        //$PO_kodedivisi = $this->session->userdata('PO_kodedivisi');
        $id_pesan =  $this->input->post('id_pesan');
        $id_request =  $this->input->post('id_request');

        $ckdta = $this->db->get_where('transpesan_head_old', array('id_pesan' => $id_pesan, 'id_request' => $id_request));

        //$hehehe = "";

        if ($ckdta->num_rows() == 0) {
            $ArrayJoin = array(
                array('masterbarang b', 'a.kodebarang=b.kodebarang', 'left'),
                array('masterproyek c', 'a.kodeproyek=c.kodeproyek', 'left'),
            );

            $ParamArray = array(
                'Table' => 'transpesan_det a',
                'WhereData' => array('a.id_pesan' => $id_pesan),
                'OrderBy' => 'a.no asc',
                'ArrayJoin' => $ArrayJoin,
            );

            if ($id_pesan == "") {
                unset($ParamArray['WhereData']['a.id_pesan']);
                $ParamArray['WhereData']['a.id_pesan'] = null;
            }

            $GetData = $this->m_function->value_result_array($ParamArray);
        } else {

            $dataOld = $ckdta->result_array();

            $ArrayJoin = array(
                // array('masterbarang b', 'a.kodebarang=b.kodebarang', 'left'),
                array('masterproyek c', 'a.kodeproyek=c.kodeproyek', 'left'),
            );

            $ParamArray = array(
                'Table' => 'transpesan_det_old a',
                'WhereData' => array('a.id_pesan' => $id_pesan, 'id_old' => $dataOld[0]['id_old']),
                'OrderBy' => 'a.no asc',
                'ArrayJoin' => $ArrayJoin,
            );

            if ($id_pesan == "") {
                unset($ParamArray['WhereData']['a.id_pesan']);
                unset($ParamArray['WhereData']['id_old']);
                $ParamArray['WhereData']['a.id_pesan'] = null;
                $ParamArray['WhereData']['id_old'] = null;
            }

            $GetData = $this->m_function->value_result_array($ParamArray);
        }



        if ($this->m_function->check_row($ParamArray) > 0) {
            echo json_encode($GetData);
        } else {
            echo json_encode(array());
        }
    }











    function c_proses_hold_manager()
    {
        $id_pesan_det = $this->input->post('id_pesan_det');
        $id_request_det =  $this->input->post('id_request_det');

        $DataUpdate = array(
            //'id_status_approval' => 4, //kode 4 adalah hold po
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

    // function c_proses_reject_managerOld()
    // {
    //     $id_pesan_det = $this->input->post('id_pesan_det');
    //     $id_request_det =  $this->input->post('id_request_det');

    //     //update ke transpesan_head
    //     $DataUpdate = array(
    //         'flag_finish' => 0,
    //         'flag_id_request' => 0,
    //     );


    //     $ParamUpdate = array(
    //         'Table' => 'transpesan_head',
    //         'DataUpdate' => $DataUpdate,
    //         'WhereData' => array('id_pesan' => $id_pesan_det)
    //     );

    //     if (!$this->m_function->update_data($ParamUpdate) >= 1) {
    //         $pesan_data = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'Update ke table transpesan_head gagal...!!!  😢',
    //         );
    //         echo json_encode($pesan_data);
    //         die;
    //     }


    //     $DataUpdate = array(
    //         //'id_status_approval' => 1,
    //         'acc_manager' => 'R',
    //         'time_acc_manager' => tanggal_sekarang(),
    //         'acc_name_manager' => $this->session->userdata('PO_username'),
    //         'flag_request' => 0,
    //         'flag_email_manager' => 0
    //     );

    //     $ParamUpdate = array(
    //         'Table' => 'tbl_request_po',
    //         'DataUpdate' => $DataUpdate,
    //         'WhereData' => array('id_request' => $id_request_det)
    //     );

    //     if (!$this->m_function->update_data($ParamUpdate) >= 1) {
    //         $pesan_data = array(
    //             'msg' => 'Tidak',
    //             'pesan' => 'Update ke table tbl_request_po gagal...!!!  😢',
    //         );
    //         echo json_encode($pesan_data);
    //         die;
    //     }

    //     $pesan_data = array(
    //         'msg' => 'Ya',
    //         'pesan' => 'Data Po Di Reject...'
    //     );

    //     echo json_encode($pesan_data);
    // }

    function c_proses_reject_manager()
    {
        $id_pesan_det = $this->input->post('id_pesan_det');
        $id_request_det =  $this->input->post('id_request_det');


        $DataUpdate = array(
            'acc_manager' => 'R',
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
                //'id_status_approval' => 1,
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
