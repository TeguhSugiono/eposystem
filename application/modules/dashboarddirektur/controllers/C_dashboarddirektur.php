<?php

defined('BASEPATH') or exit('No direct script access allowed');

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

class C_dashboarddirektur extends CI_Controller
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

        $ParamArray = array(
            'Table' => 'mastercompany_po',
            'WhereData' => array('kode_company' => $ArrayData[4])
        );

        $dataTblTransaksi =  $this->m_function->value_result_row($ParamArray);


        if ($data_password == $password_hash_dari_db) {
            $data = array(
                'PO_logged' => TRUE,
                'PO_username' => $dataLogin->username,
                'PO_kodedivisi' => $dataLogin->kode_divisi,
                'PO_hakakses' => $dataLogin->hak_akses,
                'PO_email' => $dataLogin->email,
                'PO_kode_company' => $ArrayData[4],
                'PO_name_tbl_header' => $dataTblTransaksi->name_tbl_header,
                'PO_name_tbl_detail' => $dataTblTransaksi->name_tbl_detail,
                'PO_name_tbl_keterangan' => $dataTblTransaksi->name_tbl_keterangan,
                'PO_name_tbl_request' => $dataTblTransaksi->name_tbl_request,
                'PO_name_tbl_qrcode' => $dataTblTransaksi->name_tbl_qrcode
            );
            $this->m_function->string_array_toSession($data);

            echo 'login berhasil';
            //die;
            redirect(site_url("dashboarddirektur"));
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
        //     'WhereData' => array('b.status !=' => 'V', 'a.kode_divisi' => $PO_kodedivisi, 'a.flag_request !=' => '9', 'a.flag_email_manager' => '1', 'a.flag_email_director' => '1', 'acc_manager' => 'Y'),
        //     'OrderBy' => 'FIELD(a.id_status_approval, 4, 3,2, 1),b.nopo ASC,a.time_acc_director desc,a.time_request',
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
                    FROM " . $this->session->userdata('PO_name_tbl_request') . " a
                    INNER JOIN " . $this->session->userdata('PO_name_tbl_header') . " b ON `a`.`id_pesan`=`b`.`id_pesan`
                    INNER JOIN `tbl_request_approval` `c` ON `a`.`id_status_approval`=`c`.`id_status_approval`
                    where a.id_request not in (SELECT id_request from transpesan_head_old)
                    and b.status != 'V' and a.flag_request != '9' and a.flag_email_manager = '1' 
                    and a.flag_email_director = '1' and (a.acc_manager = 'Y' or a.acc_manager = 'C')  ";


        if ($prosesPO == "yes") {
            // $query .= " and ifnull(a.acc_director,'') <> '' ";
            // $query .= " and ifnull(a.acc_director,'') <> 'H' ";
            $query .= " and ifnull(a.acc_director,'') not in ('','H') ";
        } else if ($prosesPO == "no") {
            $query .= " and (ifnull(a.acc_director,'') = '' or ifnull(a.acc_director,'') = 'H') ";
        }

        $query .= "             UNION ALL

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
                    FROM " . $this->session->userdata('PO_name_tbl_request') . " a
                    INNER JOIN `transpesan_head_old` `b` ON `a`.`id_request`=`b`.`id_request`
                    INNER JOIN `tbl_request_approval` `c` ON `a`.`id_status_approval`=`c`.`id_status_approval`
                    and b.status != 'V' and a.flag_request != '9' and a.flag_email_manager = '1' 
                    and a.flag_email_director = '1' and a.acc_manager = 'Y' ";


        if ($prosesPO == "yes") {
            $query .= " and ifnull(a.acc_director,'') <> '' ";
            $query .= " and ifnull(a.acc_director,'') <> 'H' ";
        } else if ($prosesPO == "no") {
            $query .= " and (ifnull(a.acc_director,'') = '' or ifnull(a.acc_director,'') = 'H') ";
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

        $ckdta = $this->db->get_where('transpesan_head_old', array('id_pesan' => $id_pesan, 'id_request' => $id_request));

        if ($ckdta->num_rows() == 0) {
            $ParamArray = array(
                'Table' => $this->session->userdata('PO_name_tbl_header') . ' v',
                'WhereData' => array('id_pesan' => $id_pesan),
                'Field' => '*,(SELECT xx.nama_dept FROM masterdivisi xx where xx.kode_divisi=v.kode_divisi) dept,get_company(nopo) as comp'
            );
            $GetDataHeader = $this->m_function->value_result_array($ParamArray);

            $ParamArray = array(
                'Table' => $this->session->userdata('PO_name_tbl_detail'),
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
            'Table' => $this->session->userdata('PO_name_tbl_request'),
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
            'GetDataDetailOld' => $GetDataDetailOld
        );

        $this->load->view('proses_po', $comp);
    }

    function c_proses_hold_direktur()
    {
        $id_pesan_det = $this->input->post('id_pesan_det');
        $id_request_det =  $this->input->post('id_request_det');


        $ParamArray = array(
            'Table' => $this->session->userdata('PO_name_tbl_request'),
            'WhereData' => array('id_pesan' => $id_pesan_det, 'id_request' => $id_request_det),
            'Field' => 'id_status_approval',
        );
        $RequestDataPO = $this->m_function->value_result_array($ParamArray);

        $id_status_approval_set = "";
        foreach ($RequestDataPO as $RequestPO) {
            $id_status_approval_set = $RequestPO['id_status_approval'];
        }



        $DataUpdate = array(
            //'id_status_approval' => 4, //kode 4 adalah hold po
            'acc_director' => 'H',
            'time_acc_director' => tanggal_sekarang(),
            'acc_name_director' => $this->session->userdata('PO_username')
        );

        if ($id_status_approval_set == 3 || $id_status_approval_set == 2) {
            unset($DataUpdate['id_status_approval']);
        }

        // $pesan_data = array(
        //     'msg' => 'Tidak',
        //     'pesan' => 'Update ke table tbl_request_po gagal...!!!  😢',
        //     'id_status_approval_set' => $id_status_approval_set,
        //     'DataUpdate' => $DataUpdate
        // );
        // echo json_encode($pesan_data);
        // die;

        $ParamUpdate = array(
            'Table' => $this->session->userdata('PO_name_tbl_request'),
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

    function c_proses_reject_direktur()
    {
        $id_pesan_det = $this->input->post('id_pesan_det');
        $id_request_det =  $this->input->post('id_request_det');


        $DataUpdate = array(
            //'id_status_approval' => 1,
            'acc_director' => 'R',
            'time_acc_director' => tanggal_sekarang(),
            'acc_name_director' => $this->session->userdata('PO_username'),
        );

        $ParamUpdate = array(
            'Table' => $this->session->userdata('PO_name_tbl_request'),
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

    function c_proses_accept_direktur()
    {
        $id_pesan_det = $this->input->post('id_pesan_det');
        $id_request_det =  $this->input->post('id_request_det');

        // //disini ambil case tipe requestnya
        $ParamArray = [
            'Table' => $this->session->userdata('PO_name_tbl_request'),
            'Field' => 'id_status_approval',
            'WhereData' => array('id_request' => $id_request_det),
        ];
        $id_status = $this->m_function->check_value($ParamArray);


        //buat qrcode 
        if ($id_status == 2) { //Cancel PO

            $LogData = $this->m_function->GoToHistoriData($id_pesan_det, $id_request_det);

            if ($LogData['msg'] != "Ya") {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => $LogData['pesan'],
                );
                echo json_encode($pesan_data);
                die;
            }
        } else {

            $keycode = generateUUID();

            $ArraySave = array(
                'keycode' => $keycode,
                'id_request' => $id_request_det,
                'id_pesan' => $id_pesan_det,
                'url' => site_url('scanqrcode/' . $keycode),
                'path' => base_url('img_qrcode/' . $keycode . '.png')
            );

            $ParamSave = array(
                'Table' => $this->session->userdata('PO_name_tbl_qrcode'),
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




            //proses update flagtrans master barang
            //supaya tidak bisa di delete

            $detailBrg = $this->db->get_where($this->session->userdata('PO_name_tbl_detail'), array('id_pesan' => $id_pesan_det))->result_array();

            foreach ($detailBrg as $DataDetail) {
                $data = array('flagtrans' => 1);
                //'edited_on' => tanggal_sekarang(), 'edited_by' => $this->session->userdata('PO_username') . '_byApproved'
                $where = array('kodebarang' => $DataDetail['kodebarang']);
                $this->db->update('masterbarang', $data, $where);
            }
        }


        //end buat qrcode
        $DataUpdate = array(
            'acc_director' => 'Y',
            'time_acc_director' => tanggal_sekarang(),
            'acc_name_director' => $this->session->userdata('PO_username'),
        );

        if ($id_status == 2) { //Cancel PO

            $ParamArray = [
                'Table' => $this->session->userdata('PO_name_tbl_request'),
                'Field' => 'ifnull(MAX(seqno_revisi),0) + 1 as seqno_revisi',
                'WhereData' => array('id_pesan' => $id_pesan_det),
            ];
            $seqno_revisi = $this->m_function->check_value($ParamArray);

            $DataUpdate['id_status_approval'] = '3'; //Revisi PO
            $DataUpdate['seqno_revisi'] = $seqno_revisi; //Revisi KEBERAPA

            $DataUpdate['acc_director'] = '';
            $DataUpdate['time_acc_director'] = Null;
            $DataUpdate['acc_name_director'] = '';

            $DataUpdate['acc_manager'] = '';
            $DataUpdate['time_acc_manager'] = Null;
            $DataUpdate['acc_name_manager'] = '';

            $DataUpdate['flag_request'] = '0';
            $DataUpdate['flag_email_manager'] = '0';
            $DataUpdate['flag_email_director'] = '0';

            $ParamUpdate = array(
                'Table' => $this->session->userdata('PO_name_tbl_header'),
                'DataUpdate' => array('flag_revisi' => '1'),
                'WhereData' => array('id_pesan' => $id_pesan_det)
            );
            $this->m_function->update_data($ParamUpdate);
        }

        if ($id_status == 4) {
            $DataUpdate['id_status_approval'] = '1';
        }

        $ParamUpdate = array(
            'Table' => $this->session->userdata('PO_name_tbl_request'),
            'DataUpdate' => $DataUpdate,
            'WhereData' => array('id_request' => $id_request_det)
        );

        $ParamUpdateTTD = array(
            'Table' => $this->session->userdata('PO_name_tbl_header'),
            'DataUpdate' => array('ttd' => 'helmi'),
            'WhereData' => array('id_pesan' => $id_pesan_det)
        );

        $this->m_function->update_data($ParamUpdateTTD);

        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update ke table tbl_request_po gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        } else {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => "Data Po Berhasil Di Approve"
            );

            echo json_encode($pesan_data);
        }
    }

    function c_proses_cancel_direktur()
    {

        $id_pesan_det = $this->input->post('id_pesan_det');
        $id_request_det =  $this->input->post('id_request_det');

        $DataUpdate = array(
            'acc_director' => 'C',
            'acc_manager' => 'C',
            'time_acc_director' => tanggal_sekarang(),
            'acc_name_director' => $this->session->userdata('PO_username'),
        );

        $ParamUpdate = array(
            'Table' => $this->session->userdata('PO_name_tbl_request'),
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
        } else {
            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => "Data Po Berhasil Di Cancel"
            );

            echo json_encode($pesan_data);
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
            'Table' => $this->session->userdata('PO_name_tbl_request'),
            'WhereData' => array('id_request' => $id_request_det, 'id_pesan' => $id_pesan_det),
            'Field' => '*,(select nopo from ' . $this->session->userdata('PO_name_tbl_header') . '  
            where ' . $this->session->userdata('PO_name_tbl_header') . '.id_pesan=' . $this->session->userdata('PO_name_tbl_request') . '.id_pesan) nopo',
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

        $MessageWa = "No PO ini sudah di Approve Oleh Pak Helmi\n\n" . $GetPO;

        $data = [
            'target' => $phone,
            'message' => $MessageWa,
            'countryCode' => '62',
        ];

        $ParamArray = [
            'Table' => 'tbl_rule_approval',
            'WhereData' => ['kode_divisi' => $arrayPoRequest[0]['kode_divisi']]
        ];
        $GetReceivedWA = $this->m_function->value_result_array($ParamArray);

        // $data_sendto_manager = [
        //     'target' => $GetReceivedWA[0]['phone_acc1'],
        //     'message' => $MessageWa,
        //     'countryCode' => '62',
        // ];

        // Kirim via bayar
        $Respon = $this->fonnte_guzzle->send($data, $TokenBayar);
        $StatusBayar = (int)($Respon['status'] ?? 0);

        $PesanNotfikasi = array();

        //$ResponMGR = $this->fonnte_guzzle->send($data_sendto_manager, $TokenBayar);


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

        //$RespongratisMGR = $this->fonnte_guzzle->send($data_sendto_manager, $Tokengratis);

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

    function  c_send_back_notifikasi_reject()
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
            'Table' => $this->session->userdata('PO_name_tbl_request'),
            'WhereData' => array('id_request' => $id_request_det, 'id_pesan' => $id_pesan_det),
            'Field' => '*,(select nopo from ' . $this->session->userdata('PO_name_tbl_header') . '  
            where ' . $this->session->userdata('PO_name_tbl_header') . '.id_pesan=' . $this->session->userdata('PO_name_tbl_request') . '.id_pesan) nopo',
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

        $MessageWa = "No PO ini sudah di Reject Oleh Pak Helmi\n\n" . $GetPO;

        $data = [
            'target' => $phone,
            'message' => $MessageWa,
            'countryCode' => '62',
        ];

        $ParamArray = [
            'Table' => 'tbl_rule_approval',
            'WhereData' => ['kode_divisi' => $arrayPoRequest[0]['kode_divisi']]
        ];
        $GetReceivedWA = $this->m_function->value_result_array($ParamArray);

        // $data_sendto_manager = [
        //     'target' => $GetReceivedWA[0]['phone_acc1'],
        //     'message' => $MessageWa,
        //     'countryCode' => '62',
        // ];

        // Kirim via bayar
        $Respon = $this->fonnte_guzzle->send($data, $TokenBayar);
        $StatusBayar = (int)($Respon['status'] ?? 0);

        $PesanNotfikasi = array();

        //$ResponMGR = $this->fonnte_guzzle->send($data_sendto_manager, $TokenBayar);


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

        //$RespongratisMGR = $this->fonnte_guzzle->send($data_sendto_manager, $Tokengratis);

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


    function  c_send_notifikasi($id_request, $id_pesan)
    {
        $this->load->library('Fonnte_guzzle');

        $ParamArray = array(
            'Table' => $this->session->userdata('PO_name_tbl_request'),
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
            'Table' => $this->session->userdata('PO_name_tbl_request'),
            'WhereData' => array('flag_request' => 1, 'flag_email_manager' => 1, 'id_request' => $id_request, 'flag_email_director' => 1),
            'Field' => '*,
                        (select nopo from ' . $this->session->userdata('PO_name_tbl_header') . '  
                        where ' . $this->session->userdata('PO_name_tbl_header') . '.id_pesan=' . $this->session->userdata('PO_name_tbl_request') . '.id_pesan) nopo,
                        (SELECT nama_dept FROM masterdivisi where kode_divisi=' . $this->session->userdata('PO_name_tbl_request') . '.kode_divisi) nama_dept,
                        (SELECT format(hitung_grandtotal(subtotalharga,ppn_param_date(tglpesan),ppn,id_category,discount_total),2) FROM ' . $this->session->userdata('PO_name_tbl_header') . ' where id_pesan = ' . $this->session->userdata('PO_name_tbl_request') . '.id_pesan) grandtotal'
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
                    'Table' => $this->session->userdata('PO_name_tbl_request'),
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
}
