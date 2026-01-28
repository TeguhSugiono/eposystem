<?php

defined('BASEPATH') or exit('No direct script access allowed');

// use GuzzleHttp\Client;
// use GuzzleHttp\Exception\RequestException;

class C_request_po extends CI_Controller
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


        // $ParamArray = array(
        //     'Table' => 'tbl_request_po',
        //     'WhereData' => array('id_pesan' => '1590'),
        //     'OrderBy' => 'id_request desc',
        //     'Limit' => '1'
        // );
        // print_r($this->m_function->value_result_array($ParamArray));

        // $ParamArray = array(
        //     'Table' => 'tbl_request_po',
        //     'WhereData' => array('id_pesan' => '1590', 'flag_request !=' => '9'),
        //     'OrderBy' => 'id_request desc',
        //     'Limit' => '1',
        //     'Field' => 'id_status_approval'
        // );
        // print_r($this->m_function->check_value($ParamArray));
        // die;



        // die;

        // $ParamArray = array(
        //     'Table' => 'tbl_request_po',
        //     'WhereData' => array('id_request' => 1)
        // );

        // $GetDataRequest = $this->m_function->value_result_array($ParamArray);

        // print_r($GetDataRequest);
        // die;

        $comp = array(
            'content' => 'view'
        );

        $this->load->view('dashboard/index', $comp);
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
            'WhereData' => array('b.status !=' => 'V', 'a.kode_divisi' => $PO_kodedivisi, 'a.flag_request !=' => '9'),
            'OrderBy' => 'id_request desc',
            'ArrayJoin' => $ArrayJoin,
            'Field' => 'a.*,b.*,status_approval,hitung_grandtotal(subtotalharga, ppn_param_date(tglpesan), ppn, id_category, discount_total ) AS grandtotal,ppn_param_date(b.tglpesan) AS ppn_used'
        );


        $GetData = $this->m_function->value_result_array($ParamArray);

        echo json_encode($GetData);
    }


    function c_add_request()
    {

        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $ParamArray = array(
            'Table' => 'transpesan_head',
            'Field' => 'id_pesan,nopo',
            'WhereData' => array('status !=' => 'V', 'kode_divisi' => $PO_kodedivisi, 'flag_finish' => 0)
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('id_pesan' => '', 'nopo' => '~Pilih PO~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'id_pesan', 'class' => 'select2', 'placeholder' => '~Pilih PO~'),
        );
        $id_pesan = ComboDb($createcombo);


        $ParamArray = array(
            'Table' => 'tbl_request_approval',
            'Field' => 'id_status_approval,status_approval',
            'WhereIN' => array('fieldIN' => 'id_status_approval', 'fieldINValue' => array('1', '2'))
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('id_status_approval' => '', 'status_approval' => '~Pilih Type~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => '1'),
            'attribute' => array('idname' => 'id_status_approval', 'class' => '', 'placeholder' => '~Pilih Type~'),
        );
        $id_status_approval = ComboDb($createcombo);

        $comp = array(
            'id_pesan' => $id_pesan,
            'id_status_approval' => $id_status_approval
        );

        $this->load->view('add_request', $comp);
    }



    function c_save_data()
    {
        $id_pesan = $this->input->post('id_pesan');
        $id_status_approval = $this->input->post('id_status_approval');
        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');
        $reason = $this->input->post('reason');


        //cek dulu
        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereData' => array('flag_request' => 0, 'id_pesan' => $id_pesan)
        );
        if ($this->m_function->check_row($ParamArray) > 0) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Po Sudah Masuk Di List Daftar Request...!!! 😢',
            );
            echo json_encode($pesan_data);
            die;
        }
        //end cek dulu

        //cek dulu
        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereData' => array('id_pesan' => $id_pesan, 'flag_request !=' => '9'),
            'OrderBy' => 'id_request desc',
            'Limit' => '1',
            'Field' => 'id_status_approval'
        );
        $CaseRequestBefore = $this->m_function->check_value($ParamArray);

        if ($CaseRequestBefore == $id_status_approval) {

            $ParamArray = array(
                'Table' => 'tbl_request_po',
                'WhereData' => array('id_pesan' => $id_pesan, 'flag_request !=' => '9'),
                'OrderBy' => 'id_request desc',
                'Limit' => '1',
                'Field' => 'id_status_approval',
                'Clause' => "(acc_manager = 'N' or acc_director = 'N')"
            );

            if ($this->m_function->check_value($ParamArray) == "") {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'No Po Sudah Pernah di Request dengan tujuan yang sama harap ganti type request pengajuan',
                );
                echo json_encode($pesan_data);
                die;
            }
        }
        //end cek dulu

        $ArraySave = array(
            'id_pesan' => $id_pesan,
            'id_status_approval' => $id_status_approval,
            'kode_divisi' => $PO_kodedivisi,
            'reason' => $reason,
        );


        $ParamSave = array(
            'Table' => 'tbl_request_po',
            'DataInsert' => $ArraySave
        );

        if (!$this->m_function->save_data($ParamSave) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Insert ke table tbl_request_po gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Request Berhasil Disimpan  😊",
        );
        echo json_encode($pesan_data);
    }


    function c_edit_data($id_request)
    {


        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereData' => array('id_request' => $id_request)
        );

        $GetDataRequest = $this->m_function->value_result_array($ParamArray);


        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $ParamArray = array(
            'Table' => 'transpesan_head',
            'Field' => 'id_pesan,nopo',
            'WhereData' => array('status !=' => 'V', 'kode_divisi' => $PO_kodedivisi)
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);

        array_push($arraydata, array('id_pesan' => '', 'nopo' => '~Pilih PO~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => $GetDataRequest[0]['id_pesan']),
            'attribute' => array('idname' => 'id_pesan', 'class' => 'select2', 'placeholder' => '~Pilih PO~'),
        );
        $id_pesan = ComboDb($createcombo);

        $ParamArray = array(
            'Table' => 'tbl_request_approval',
            'Field' => 'id_status_approval,status_approval'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('id_status_approval' => '', 'status_approval' => '~Pilih Type~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => $GetDataRequest[0]['id_status_approval']),
            'attribute' => array('idname' => 'id_status_approval', 'class' => '', 'placeholder' => '~Pilih Type~'),
        );
        $id_status_approval = ComboDb($createcombo);


        $comp = array(
            'GetDataRequest' => $GetDataRequest,
            'id_pesan' => $id_pesan,
            'id_status_approval' => $id_status_approval
        );

        $this->load->view('edit_request', $comp);
    }


    function c_update_data()
    {
        $id_pesan = $this->input->post('id_pesan');
        $id_status_approval = $this->input->post('id_status_approval');
        $id_request = $this->input->post('id_request');
        $reason = $this->input->post('reason');
        $id_pesan_old = $this->input->post('id_pesan_old');


        if ($id_pesan_old == $id_pesan) {

            $ArrayUpdate = array(
                'id_status_approval' => $id_status_approval,
                'reason' => $reason,
            );

            $ParamUpdate = array(
                'Table' => 'tbl_request_po',
                'DataUpdate' => $ArrayUpdate,
                'WhereData' => array('id_request' => $id_request)
            );


            if (!$this->m_function->update_data($ParamUpdate) >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Update ke table tbl_request_po gagal...!!!  😢',
                );
                echo json_encode($pesan_data);
                die;
            }
        } else {

            //cek dulu
            $ParamArray = array(
                'Table' => 'tbl_request_po',
                'WhereData' => array('flag_request' => 0, 'id_pesan' => $id_pesan)
            );
            if ($this->m_function->check_row($ParamArray) > 0) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Po Sudah Masuk Di List Daftar Request...!!! 😢',
                );
                echo json_encode($pesan_data);
                die;
            }
            //end cek dulu



            $ArrayUpdate = array(
                'id_status_approval' => $id_status_approval,
                'reason' => $reason,
                'id_pesan' => $id_pesan
            );

            $ParamUpdate = array(
                'Table' => 'tbl_request_po',
                'DataUpdate' => $ArrayUpdate,
                'WhereData' => array('id_request' => $id_request)
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


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Request Berhasil DiUpdate 😊",
        );
        echo json_encode($pesan_data);
    }

    function c_test_wa()
    {
        $this->load->library('Fonnte_guzzle');

        $kode_divisi = "001"; // sesuaikan dengan input POST jika ada

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

        foreach ($GetReceivedWA as $GetReceived) {

            $data = [
                'target' => $GetReceived['phone_acc1'],
                'message' => 'Test Send Wa with Guzzle CI3',
                'countryCode' => '62',
            ];

            // Kirim via bayar
            $Respon = $this->fonnte_guzzle->send($data, $TokenBayar);
            $StatusBayar = (int)($Respon['status'] ?? 0);

            if ($StatusBayar === 1) {
                echo "✔ Berhasil kirim ke {$data['target']} via BAYAR<br>";
                continue;
            }

            // Jika gagal → retry via gratis
            $Respongratis = $this->fonnte_guzzle->send($data, $Tokengratis);
            $Statusgratis = (int)($Respongratis['status'] ?? 0);

            if ($Statusgratis === 1) {
                echo "✔ Berhasil kirim ke {$data['target']} via gratis<br>";
            } else {
                echo "✖ Gagal kirim ke {$data['target']} via BAYAR & gratis<br>";
            }
        }
    }


    function c_send_approve()
    {
        $id_request = $this->input->post('id_request');
        $nopo = $this->input->post('nopo');

        $notifikasi = $this->c_send_notifikasi($id_request);
        // echo json_encode($notifikasi);
        // die;

        if ($notifikasi['msg'] == "Ya") {

            $ArrayUpdate = array(
                'user_request' => $this->session->userdata('PO_username'),
                'time_request' => tanggal_sekarang(),
                'flag_request' => 1
            );

            $ParamUpdate = array(
                'Table' => 'tbl_request_po',
                'DataUpdate' => $ArrayUpdate,
                'WhereData' => array('id_request' => $id_request)
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
                'flag_finish' => '1',
                'flag_id_request' => $id_request
            );

            $ParamUpdate = array(
                'Table' => 'transpesan_head',
                'DataUpdate' => $ArrayUpdate,
                'WhereData' => array('nopo' => $nopo)
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

            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => "Data PO Berhasil Di Request 😊",
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

    function  c_send_notifikasi($id_request)
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
            'WhereData' => array('flag_request' => 0, 'id_request' => $id_request),
            'Clause' => "(flag_email_manager = 0 or flag_email_director=0)",
            'Field' => '*,get_nopo(id_pesan) nopo,(SELECT nama_dept FROM masterdivisi where kode_divisi=tbl_request_po.kode_divisi) nama_dept,
                        (SELECT format(hitung_grandtotal(subtotalharga,ppn_param_date(tglpesan),ppn,id_category,discount_total),2) FROM transpesan_head where id_pesan = tbl_request_po.id_pesan) grandtotal'
        );
        $arrayPoRequest = $this->m_function->value_result_array($ParamArray);


        foreach ($arrayPoRequest as $PoRequest) {

            $flag_email_manager = $PoRequest['flag_email_manager'];
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

            $email_manager = $arrayRuler[0]['email_acc1'];
            $email_manager_name = $arrayRuler[0]['name_acc1'];
            $LinkHash = "";


            if ($flag_email_manager == 0) {

                $LinkHash = $this->m_function->CreateLinkManager($email_manager);

                $ParamUpdate = array(
                    'Table' => 'tbl_request_po',
                    'DataUpdate' => array('flag_email_manager' => 1, 'acc_manager' => '', 'time_acc_manager' => NULL, 'acc_name_manager' => ''),
                    'WhereData' => array('id_request' => $PoRequest['id_request'])
                );

                $this->m_function->update_data($ParamUpdate);
            }
        }


        //end isi value wa eposystem


        $longLink = site_url("dashboardmanager/authentikasi/" . $LinkHash);

        $MessageWa = "*Permohonan Approval Purchase Order (PO)*\n\n" .
            "Dear Pak {$email_manager_name}\n" .
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
                'target' => $GetReceived['phone_acc1'],
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
                    'Respon' => $Respon
                );
                return $PesanNotfikasi;
                die;
            } else {
                //echo "✖ Gagal kirim ke {$data['target']} via BAYAR & gratis<br>";
                $PesanNotfikasi = array(
                    'msg' => 'Tidak',
                    'pesan' => "❌ Gagal kirim ke {$data['target']} via BAYAR & gratis<br>",
                    'Respon' => $Respon
                );
                return $PesanNotfikasi;
                die;
            }
        }
    }

    function c_send_approveOld()
    {


        $id_request = $this->input->post('id_request');
        $nopo = $this->input->post('nopo');


        $ArrayUpdate = array(
            'user_request' => $this->session->userdata('PO_username'),
            'time_request' => tanggal_sekarang(),
            'flag_request' => 1
        );

        $ParamUpdate = array(
            'Table' => 'tbl_request_po',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('id_request' => $id_request)
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
            'flag_finish' => '1',
            'flag_id_request' => $id_request
        );

        $ParamUpdate = array(
            'Table' => 'transpesan_head',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('nopo' => $nopo)
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

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data PO Berhasil Di Request 😊",
        );
        echo json_encode($pesan_data);
    }


    function c_request_batal()
    {
        $id_request = $this->input->post('id_request');
        $nopo = $this->input->post('nopo');

        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereData' => array('id_request' => $id_request),
            'Field' => 'id_status_approval'
        );
        $id_status_approval = $this->m_function->check_value($ParamArray);


        if ($id_status_approval == "4") {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Tidak Bisa Dibatalkan , Data PO Sudah Di Hold...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $ArrayUpdate = array(
            'flag_request' => 0,
            'flag_email_manager' => 0,
            'flag_email_director' => 0,
            'acc_manager' => '',
            'time_acc_manager' => Null,
            'acc_name_manager' => '',
        );

        $ParamUpdate = array(
            'Table' => 'tbl_request_po',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('id_request' => $id_request)
        );

        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Delete ke table tbl_request_po gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        } else {

            $ArrayUpdate = array(
                'flag_id_request' => 0,
                'flag_finish' => 0
            );

            $ParamUpdate = array(
                'Table' => 'transpesan_head',
                'DataUpdate' => $ArrayUpdate,
                'WhereData' => array('nopo' => $nopo, 'flag_id_request' => $id_request)
            );

            $this->m_function->update_data($ParamUpdate);

            $pesan_data = array(
                'msg' => 'Ya',
                'pesan' => "Data Request Berhasil Dibatalkan 😊",
            );
            echo json_encode($pesan_data);
        }
    }

    function c_delete_data()
    {
        $id_request = $this->input->post('id_request');


        //cek dulu
        $ParamArray = array(
            'Table' => 'tbl_request_po',
            'WhereData' => array('flag_request !=' => 0, 'id_request' => $id_request)
        );
        if ($this->m_function->check_row($ParamArray) > 0) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Po Sudah di Request ...!!! 😢',
            );
            echo json_encode($pesan_data);
            die;
        }
        //end cek dulu

        $ArrayUpdate = array(
            'flag_request' => 9
        );

        $ParamUpdate = array(
            'Table' => 'tbl_request_po',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('id_request' => $id_request)
        );

        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Delete ke table tbl_request_po gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data Request Berhasil Dihapus 😊",
        );
        echo json_encode($pesan_data);
    }
}
