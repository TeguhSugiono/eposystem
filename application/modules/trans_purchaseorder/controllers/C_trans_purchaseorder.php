<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'third_party/fpdf/fpdf.php');
require_once(APPPATH . 'third_party/fpdi/src/autoload.php');

class C_trans_purchaseorder extends CI_Controller
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





        // $data = array();

        // // print_r($data);die;

        // $this->load->library('pdfgenerator');

        // $file_pdf = tanggal_sekarang();
        // $paper = 'A4';
        // $orientation = "portrait";

        // $html = $this->load->view('cetakPO', $data, true);

        // //print_r($html);die;
        // // run dompdf
        // $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);

        // die;


        $comp = array(
            'content' => 'view'
        );


        $this->load->view('dashboard/index', $comp);
    }

    function c_cetakPO()
    {

        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);




        $id_pesan = $data[0];
        $nopo = $data[1];
        $subtotalharga = $data[2];
        $nilai_lain  = $data[3];
        $PPN = $data[4];
        $grandtotal = $data[5];

        //Get Header PO
        $ParamArray = array(
            'Table' => 'transpesan_head',
            'WhereData' => array('id_pesan' => $id_pesan),
            'Field' => '*,get_company(nopo) as comp'
        );
        $GetHeaderPO = $this->m_function->value_result_array($ParamArray);
        //End GetHeader PO

        //Get Supplier
        if ($GetHeaderPO[0]['comp'] == "MSA") {
            $ConectDB = "dbAcct";
        } else if ($GetHeaderPO[0]['comp']) {
            $ConectDB = "dbAcctBal";
        } else {
            $ConectDB = "dbAcct";
        }

        $ParamArray = array(
            'ConectDB' =>  $ConectDB,
            'Table' => 'fin_ap_m_supplier',
            'WhereData' => array('suppl_code' => $GetHeaderPO[0]['kodesupplier']),
        );
        $GetSupplier = $this->m_function->value_result_array($ParamArray);

        // print_r($GetSupplier);
        // die;
        //End Get Supplier

        //Get TTD
        $ParamArray = array(
            'Table' => 'masteruser',
            'WhereData' => array('username' => $GetHeaderPO[0]['ttd']),
        );
        $GetTTD = $this->m_function->value_result_array($ParamArray);
        //End TTD

        //Get BANK
        $ParamArray = array(
            'ConectDB' =>  $ConectDB,
            'Table' => 'fin_ap_m_supplier_bank',
            'WhereData' => array('id_bank' => $GetHeaderPO[0]['id_bank']),
        );
        $GetBank = $this->m_function->value_result_array($ParamArray);
        //End BANK



        //GET DETAIL BARANG
        $ParamArray = array(
            'Table' => 'transpesan_det',
            'WhereData' => array('id_pesan' => $GetHeaderPO[0]['id_pesan']),
            'OrderBy' => 'no asc'
        );
        $GetDetailPO = $this->m_function->value_result_array($ParamArray);


        //hitung data detail dan keterangan barang
        $ParamArray = array(
            'Table' => 'transpesan_det',
            'WhereData' => array('id_pesan' => $GetHeaderPO[0]['id_pesan']),
            'Field' => 'no'
        );
        $datadetail = $this->m_function->value_result_array($ParamArray);
        $JumlahDetail = 0;
        // $ArrayInKet = array();
        foreach ($datadetail as $dtdetail) {
            $JumlahDetail = $JumlahDetail + 1;
            // array_push($ArrayInKet, $dtdetail['no']);
        }
        //echo $JumlahDetail;

        $arrayNo = array_column($datadetail, 'no');

        $ParamArray = array(
            'Table' => 'transpesan_det_keterangan',
            'WhereIN' => array('fieldIN' => 'id_transpesan_det', 'fieldINValue' => $arrayNo)
        );
        $JumlahKet = $this->m_function->check_num_row($ParamArray);
        // echo $JumlahKet;
        // die;
        //end hitung data detail dan keterangan barang
        $batasbarisbawah = 17;
        $sisabaris = 0;
        if ($JumlahDetail + $JumlahKet <= $batasbarisbawah) {
            //patok baris detail dan keterangan
            $sisabaris = $batasbarisbawah - ($JumlahDetail + $JumlahKet);
        }

        $htmlDet = "";
        $nomor = 1;
        foreach ($GetDetailPO as $DetailPO) {

            $ParamArray = array(
                'Table' => 'masterbarang',
                'WhereData' => array('kodebarang' => $DetailPO['kodebarang']),
            );
            $GetBrg = $this->m_function->value_result_array($ParamArray);

            $NamaBarang = $GetBrg[0]['itembarang'] . ' ' . $GetBrg[0]['merk'] . ' ' . $GetBrg[0]['type'];

            $ParamArray = array(
                'Table' => 'masterproyek',
                'WhereData' => array('kodeproyek' => $DetailPO['kodeproyek']),
            );
            $GetProyek = $this->m_function->value_result_array($ParamArray);

            $hargasatuan = format_dolar($DetailPO['hargasatuan']);
            $diskon = format_dolar($DetailPO['diskon']);
            $total = format_dolar($DetailPO['total']);

            $htmlDet .= "
                <tr>
                    <td valign='top'>{$nomor}</td>
                    <td valign='top'>{$NamaBarang}</td>
                    <td nowrap='nowrap'>{$GetProyek[0]['lokasiproyek']}</td>
                    <td class='textcenter'>{$DetailPO['qtymsk']}</td>
                    <td>{$GetBrg[0]['satuan']}</td>
                    <td align='right'>{$hargasatuan}</td>
                    <td align='right'>{$diskon}</td>
                    <td align='right'>{$total}</td>
                </tr>
            ";

            $ParamArray = array(
                'Table' => 'transpesan_det_keterangan',
                'WhereData' => array('id_transpesan_det' => $DetailPO['no']),
                'OrderBy' => 'seqno asc'
            );
            $GetKeterangan = $this->m_function->value_result_array($ParamArray);

            if (count($GetKeterangan) > 0) {
                foreach ($GetKeterangan as $Keterangan) {
                    $htmlDet .= "
                        <tr>
                            <td valign='top' class='no-border-top-bottom'></td>
                            <td valign='top' class='no-border-top-bottom'>{$Keterangan['keteranganbarang']}</td>
                            <td nowrap='nowrap' class='no-border-top-bottom'></td>
                            <td class='textcenter' class='no-border-top-bottom'></td>
                            <td class='no-border-top-bottom'></td>
                            <td align='right' class='no-border-top-bottom'></td>
                            <td align='right' class='no-border-top-bottom'></td>
                            <td align='right' class='no-border-top-bottom'></td>
                        </tr>
                    ";
                }
            }


            $nomor++;
        }

        for ($a = 1; $a <= $sisabaris; $a++) {
            $htmlDet .= "
                        <tr>
                            <td valign='top' class='no-border-top-bottom' style='height:14px;'></td>
                            <td valign='top' class='no-border-top-bottom'></td>
                            <td nowrap='nowrap' class='no-border-top-bottom'></td>
                            <td class='textcenter' class='no-border-top-bottom'></td>
                            <td class='no-border-top-bottom'></td>
                            <td align='right' class='no-border-top-bottom'></td>
                            <td align='right' class='no-border-top-bottom'></td>
                            <td align='right' class='no-border-top-bottom'></td>
                        </tr>
                    ";
        }

        //END GET DETAIL BARANG


        //ambil barcode/qrcode

        $ParamArray = array(
            'Table' => 'transpesan_qrcode',
            'WhereData' => array('id_pesan' => $GetHeaderPO[0]['id_pesan'], 'id_request' => $GetHeaderPO[0]['flag_id_request']),
            'Field' => 'path'
        );
        $barcodeQr = $this->m_function->check_value($ParamArray);

        // print_r($this->db->last_query());
        // die;

        if ($barcodeQr == "") {
            $barcodeQr = base_url('img_qrcode/blank.png');
        }

        //end ambil barcode/qrcode


        $data = array(
            'GetHeaderPO' => $GetHeaderPO,
            'GetSupplier' => $GetSupplier,
            'GetTTD' => $GetTTD,
            'GetBank' => $GetBank,
            'subtotalharga' => format_dolar($subtotalharga),
            'nilai_lain' => format_dolar($nilai_lain),
            'PPN' => format_dolar($PPN),
            'grandtotal' => format_dolar($grandtotal),
            'htmlDet' => $htmlDet,
            'barcodeQr' => $barcodeQr,
        );




        $this->load->library('pdfgenerator');

        $file_pdf = tanggal_sekarang();
        $paper = 'A4';
        $orientation = "portrait";

        //$html = $this->load->view('cetakPO', $data, true);

        // echo $html;
        // exit;


        $html = $this->load->view('cetakPOPage', $data, true);

        //print_r($html);die;
        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }


    function c_fetch_table()
    {
        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $ArrayJoin = array(
            array('masterdivisi b', 'a.kode_divisi=b.kode_divisi', 'left'),
            array('mastersupplier c', 'a.kodesupplier=c.kodesupplier', 'left')
        );

        $ParamArray = array(
            'Table' => 'transpesan_head a',
            'WhereData' => array('a.kode_divisi' => $PO_kodedivisi, 'a.status !=' => 'V'),
            'OrderBy' => 'a.created_on desc,a.tglpesan desc',
            'ArrayJoin' => $ArrayJoin,
            'Field' => 'a.*,b.nama_divisi AS nama_divisi,c.namasupplier,ppn_param_date(a.tglpesan) AS ppn_used,get_company(a.nopo) as comp'
        );

        $ParamArray = hakakses($ParamArray);

        $GetData = $this->m_function->value_result_array($ParamArray);

        echo json_encode($GetData);
    }

    function c_fetch_table_detail()
    {
        //$PO_kodedivisi = $this->session->userdata('PO_kodedivisi');
        $id_pesan =  $this->input->post('id_pesan');

        $ArrayJoin = array(
            array('masterbarang b', 'a.kodebarang=b.kodebarang', 'left'),
            array('masterproyek c', 'a.kodeproyek=c.kodeproyek', 'left'),
            //array('transpesan_head d', 'a.id_pesan=d.id_pesan', 'inner')
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

        if ($this->m_function->check_row($ParamArray) > 0) {
            echo json_encode($GetData);
        } else {
            echo json_encode(array());
        }
    }

    function c_fetch_detail_keterangan()
    {

        $id_pesan =  $this->input->post('id_pesan');

        $ParamArray = array(
            //'Table' => 'transpesan_head',
            'WhereData' => array('id_pesan' => $id_pesan),
        );

        //$GetDataHeader = $this->m_function->value_result_array($ParamArray);

        //unset($ParamArray['Table']);
        $ParamArray['Table'] = 'transpesan_det a';

        $ArrayJoin = array(
            array('masterbarang b', 'a.kodebarang=b.kodebarang', 'left')
        );
        $ParamArray['ArrayJoin'] = $ArrayJoin;
        $ParamArray['OrderBy'] = 'a.no asc';

        $GetDataDetail = $this->m_function->value_result_array($ParamArray);

        $html = "";
        $html .= "<div class=\"row\">";

        $htmlDet = "";

        $a = 1;
        $sub = 1;

        foreach ($GetDataDetail as $DataDetail) {
            if ($DataDetail['Keterangan_detail'] == "") {

                $NamaBarang =  $DataDetail['itembarang'] . ' ' . $DataDetail['merk'] . ' ' . $DataDetail['type'];

                //cek ke table transpesan_det_keterangan
                $ParamArray = array(
                    'Table' => 'transpesan_det_keterangan',
                    'WhereData' => array('id_transpesan_det' => $DataDetail['no']),
                    'OrderBy' => 'seqno asc'
                );

                if ($this->m_function->check_row($ParamArray) > 0) {


                    $htmlKet = "";
                    foreach ($this->m_function->value_result_array($ParamArray) as $DataKeterangan) {
                        $htmlKet .= $DataKeterangan['keteranganbarang'] . "\n";
                    }

                    $htmlDet .= '<div class="col-md-4">
                                    <div class="form-group MarginBtm">
                                        <textarea name="textarea" rows="4" cols="30" class="form-control">' . $NamaBarang . '</textarea>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group MarginBtm">
                                        <textarea name="textarea" rows="4" cols="30" class="form-control">' . $htmlKet . '</textarea>
                                    </div>
                                </div>';
                } else {

                    $htmlDet .= '<div class="col-md-4">
                                    <div class="form-group MarginBtm">
                                        <textarea name="textarea" rows="4" cols="30" class="form-control">' . $NamaBarang . '</textarea>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group MarginBtm">
                                        <textarea name="textarea" rows="4" cols="30" class="form-control"></textarea>
                                    </div>
                                </div>';
                }
            } else {

                $NamaBarang =  $DataDetail['itembarang'] . ' ' . $DataDetail['merk'] . ' ' . $DataDetail['type'];

                //cek ke table transpesan_det_keterangan
                $ParamArray = array(
                    'Table' => 'transpesan_det_keterangan',
                    'WhereData' => array('id_transpesan_det' => $DataDetail['no']),
                    'OrderBy' => 'seqno asc'
                );

                if ($this->m_function->check_row($ParamArray) > 0) {


                    $htmlKet = $DataDetail['Keterangan_detail'] . "\n";
                    foreach ($this->m_function->value_result_array($ParamArray) as $DataKeterangan) {
                        $htmlKet .= $DataKeterangan['keteranganbarang'] . "\n";
                    }

                    $htmlDet .= '<div class="col-md-4">
                                    <div class="form-group MarginBtm">
                                        <textarea name="textarea" rows="4" cols="30" class="form-control">' . $NamaBarang . '</textarea>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group MarginBtm">
                                        <textarea name="textarea" rows="4" cols="30" class="form-control">' . $htmlKet . '</textarea>
                                    </div>
                                </div>';
                } else {

                    $htmlDet .= '<div class="col-md-4">
                                    <div class="form-group MarginBtm">
                                        <textarea name="textarea" rows="4" cols="30" class="form-control">' . $NamaBarang . '</textarea>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group MarginBtm">
                                        <textarea name="textarea" rows="4" cols="30" class="form-control">' . $DataDetail['Keterangan_detail'] . '</textarea>
                                    </div>
                                </div>';
                }
            }
        }

        $html .= $htmlDet;
        $html .= "</div>"; //tutup class row


        echo $html; // langsung kirim HTML


    }

    function c_fetch_note_po()
    {

        $id_pesan =  $this->input->post('id_pesan');

        $ParamArray = array(
            'Table' => 'transpesan_head',
            'WhereData' => array('id_pesan' => $id_pesan),
            'Field' => '*,get_company(nopo) as comp'
        );

        $GetHeaderPO = $this->m_function->value_result_array($ParamArray);

        $ConectDB = "";

        if ($GetHeaderPO[0]['comp'] == "MSA") {
            $ConectDB = "dbAcct";
        } else if ($GetHeaderPO[0]['comp'] == "BAL") {
            $ConectDB = "dbAcctBal";
        } else {
            $ConectDB = "dbAcct";
        }


        $ParamArray = array(
            'ConectDB' => $ConectDB,
            'Table' => 'fin_ap_m_supplier',
            'WhereData' => array('suppl_code' => $GetHeaderPO[0]['kodesupplier']),
        );

        $GetSupplier = $this->m_function->value_result_array($ParamArray);
        //<table class="table table-bordered table-striped table-hover display nowrap" id="tblket" style="width: 50%">

        $html = '<div class="datatable-container">
            <div class="datatable-wrapper">
                <h5 class="card-title"></h5>
                    
                    <table class="table table-bordered table-striped table-hover" id="tblket">
                        <thead>
                            <tr>
                                <th style="width:50%">Nama Supplier</th>
                                <th style="width:50%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="height:40px; line-height:40px; padding:0;">' . $GetSupplier[0]['suppl_name'] . '</td>
                                <td style="height:40px; line-height:40px; padding:0;">' . $GetHeaderPO[0]['keterangan'] . '</td>
                            </tr>
                        </tbody>
                </table>
            </div>
        </div>';


        $html = $html;
        echo $html;
    }

    function c_getnamesupplier()
    {
        $kodesupplier = $this->input->post('kodesupplier');

        $ParamArray = array(
            'ConectDB' => 'dbAcct',
            'Table' => 'fin_ap_m_supplier',
            'WhereData' => array('active_status' => 'Y', 'suppl_code' => $kodesupplier),
        );

        if ($kodesupplier == "") {
            unset($ParamArray['WhereData']['suppl_code']);
        }

        $ArraySupplier = array();
        if ($this->m_function->check_row($ParamArray) > 0) {
            //$ParamArray['Field'] = 'suppl_name';
            $ArraySupplier = $this->m_function->value_result_array($ParamArray);
        } else {
            $ArraySupplier = array(array("suppl_name" => ""));
        }

        echo json_encode($ArraySupplier);
    }


    function c_edit_data($id_pesan)
    {

        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $ParamArray = array(
            'Table' => 'transpesan_head',
            'WhereData' => array('id_pesan' => $id_pesan),
            'Field' => '*,get_company(nopo) as comp'
        );
        $ArrayPoHeader = $this->m_function->value_result_array($ParamArray);

        //set data header
        $company = "";
        $nopo = "";
        $tglpesan = "";
        $tglkrm = "";
        $noreff = "";
        $nomr = "";
        $ttd = "";
        $kodesupplier = "";
        $pembayaran = "";
        $id_bank = "";
        $keteranganH = "";
        $tgltempo = "";
        $id_category = "";
        $subtotalharga = 0;
        $nilai_lain = 0;
        $ppn = "";
        $flag_finish = 0;

        foreach ($ArrayPoHeader as $PoHeader) {
            $company = $PoHeader['comp'];
            $nopo = $PoHeader['nopo'];
            $tglpesan =  date_db($PoHeader['tglpesan']);
            $tglkrm = date_db($PoHeader['tglkrm']);
            $noreff = $PoHeader['noreff'];
            $nomr = $PoHeader['nomr'];
            $ttd = $PoHeader['ttd'];
            $kodesupplier = $PoHeader['kodesupplier'];
            $pembayaran = $PoHeader['pembayaran'];
            $id_bank = $PoHeader['id_bank'];
            $keteranganH = $PoHeader['keterangan'];
            $tgltempo = $PoHeader['tgltempo'];
            $id_category = $PoHeader['id_category'];
            $subtotalharga = $PoHeader['subtotalharga'];
            $nilai_lain = $PoHeader['nilai_lain'];
            $ppn = $PoHeader['ppn'];
            $flag_finish = $PoHeader['flag_finish'];
        }

        $ParamArray = array(
            'ConectDB' => 'dbAcct',
            'Table' => 'fin_ap_m_supplier_bank',
            'WhereData' => array('id_bank' => $id_bank),
            'Field' => 'no_rek'
        );
        $NoRek = $this->m_function->check_value($ParamArray);

        $arraydata = array(
            '' => '~Pilih TTD~',
            'helmi' => 'Helmi',
            'koen' => 'Soehono Koenarto',
            'didi' => 'Didi Agustiawan'
        );
        $ttd = ComboNonDb($arraydata, 'ttd', $ttd, 'form-control form-control-sm', '~Pilih TTD~');

        $ConectDB = "";

        if ($company == "MSA") {
            $ConectDB = "dbAcct";
        } else if ($company == "BAL") {
            $ConectDB = "dbAcctBal";
        } else {
            $ConectDB = "dbAcct";
        }

        $ParamArray = array(
            'ConectDB' => $ConectDB,
            'Table' => 'fin_ap_m_supplier',
            'Field' => 'suppl_code,suppl_name'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('suppl_code' => '', 'suppl_name' => '~Pilih Supplier~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => $kodesupplier),
            'attribute' => array('idname' => 'suppl_code', 'class' => 'select2 form-control form-control-sm', 'placeholder' => '~Pilih Supplier~'),
        );
        $suppl_code = ComboDb($createcombo);


        $arraydata = array(
            '' => '~Pilih Pembayaran~',
            'Transfer' => 'Transfer',
            'Cash' => 'Cash',
            'Giro' => 'Giro'
        );
        $pembayaran = ComboNonDb($arraydata, 'pembayaran', $pembayaran, 'form-control form-control-sm', '~Pilih Pembayaran~');


        $ParamArray = array(
            'ConectDB' => $ConectDB,
            'Table' => 'fin_ap_m_supplier_bank',
            'Field' => 'id_bank,concat(nama_bank,"~",atas_nama)'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('id_bank' => '', 'nama_bank' => '~Pilih Bank~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => $id_bank),
            'attribute' => array('idname' => 'id_bank', 'class' => 'select2 form-control form-control-sm', 'placeholder' => '~Pilih Bank~'),
        );
        $id_bank = ComboDb($createcombo);

        //end set data header


        $query = " SELECT ppn_param_date('" . $tglpesan . "') 'ppnaktif' ";
        $ParamArray = array(
            'Query' => $query,
            'Field' => 'ppnaktif'
        );
        $jml_ppn = $this->m_function->value_native_query($ParamArray);

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
        $ParamArray = array(
            'Table' => 'tbl_setting_ppn',
            'Field' => 'jml_ppn,keterangan'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('jml_ppn' => '', 'keterangan' => '~Pilih PPN~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => $jml_ppn),
            'attribute' => array('idname' => 'jml_ppn', 'class' => 'form-control form-control-sm', 'placeholder' => '~Pilih PPN~'),
        );
        $jml_ppn = ComboDb($createcombo);
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
        $ParamArray = array(
            'Table' => 'tbl_setting_ppn_category',
            'Field' => 'id_category,category_ppn'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('id_category' => '', 'category_ppn' => '~Pilih Category~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => $id_category),
            'attribute' => array('idname' => 'id_category', 'class' => 'form-control form-control-sm', 'placeholder' => '~Pilih Category~'),
        );
        $id_category = ComboDb($createcombo);
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

        $PPNChecked = "";
        if ($ppn == "Y") {
            $PPNChecked = "checked";
        }

        $ParamArray = array(
            'Table' => 'masterproyek',
            'Field' => 'kodeproyek,lokasiproyek',

        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        $dataProyek = $arraydata;



        $ParamArray = array(
            'Table' => 'masterbarang',
            'Field' => 'kodebarang,get_barang_fullname(itembarang, merk, type) "nmbrg"',
            'WhereData' => array('kode_divisi' => $PO_kodedivisi)
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        $dataBarang = $arraydata;



        $ParamArray = array(
            'Table' => 'transpesan_det',
            'WhereData' => array('id_pesan' => $id_pesan),
            'OrderBy' => 'no asc'
        );
        $ArrayPoDetail = $this->m_function->value_result_array($ParamArray);

        // Tambahin keterangan per detail
        foreach ($ArrayPoDetail as &$det) {
            // Ambil ID detail (ganti 'id' kalau nama kolomnya beda)
            $id_transpesan_det = $det['no']; // atau $det['id_det'] kalau beda nama

            // Ambil keterangan dari tabel keterangan
            $ParamKeterangan = array(
                'Table' => 'transpesan_det_keterangan', // nama tabel keterangan
                'WhereData' => array('id_transpesan_det' => $id_transpesan_det), // atau 'id_det' kalau beda
                'OrderBy' => 'seqno asc' // optional, biar urut
            );
            $keterangan = $this->m_function->value_result_array($ParamKeterangan);

            // Ubah jadi array sederhana hanya isi keterangan
            $det['keterangan'] = array_column($keterangan, 'keteranganbarang'); // kolom keterangan di tabel
        }
        unset($det); // good practice biar nggak berubah lagi

        $comp = array(
            'company' => $company,
            'nopo' => $nopo,
            'tglpesan' => $tglpesan,
            'tglkrm' => $tglkrm,
            'noreff' => $noreff,
            'nomr' => $nomr,
            'NoRek' => $NoRek,
            'keteranganH' => $keteranganH,
            'tgltempo' => date_db($tgltempo),
            'ttd' => $ttd,
            'suppl_code' => $suppl_code,
            'pembayaran' => $pembayaran,
            'PPNChecked' => $PPNChecked,
            'id_bank' => $id_bank,
            'jml_ppn' => $jml_ppn,
            'id_category' => $id_category,
            'dataProyek' => $dataProyek,
            'ArrayPoDetail' => $ArrayPoDetail,
            'dataBarang' => $dataBarang,
            'id_pesan' => $id_pesan,
            'flag_finish' => $flag_finish,
        );

        $this->load->view('edit', $comp);
    }

    function c_add_data()
    {


        $query = " SELECT ppn_param_date(date(NOW())) 'ppnaktif' ";
        $ParamArray = array(
            'Query' => $query,
            'Field' => 'ppnaktif'
        );
        $jml_ppn = $this->m_function->value_native_query($ParamArray);

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
        $ParamArray = array(
            'Table' => 'tbl_setting_ppn',
            'Field' => 'jml_ppn,keterangan'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('jml_ppn' => '', 'keterangan' => '~Pilih PPN~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => $jml_ppn),
            'attribute' => array('idname' => 'jml_ppn', 'class' => 'form-control form-control-sm', 'placeholder' => '~Pilih PPN~'),
        );
        $jml_ppn = ComboDb($createcombo);
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
        $ParamArray = array(
            'Table' => 'tbl_setting_ppn_category',
            'Field' => 'id_category,category_ppn'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('id_category' => '', 'category_ppn' => '~Pilih Category~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => 2),
            'attribute' => array('idname' => 'id_category', 'class' => 'form-control form-control-sm', 'placeholder' => '~Pilih Category~'),
        );
        $id_category = ComboDb($createcombo);
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//



        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
        $ParamArray = array(
            'Table' => 'mastercompany_po',
            'Field' => 'kode_company,nama_company'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('kode_company' => '', 'nama_company' => '~Pilih Perusahaan~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'company', 'class' => 'select-gradient', 'placeholder' => '~Pilih Perusahaan~'),
        );
        $company = ComboDb($createcombo);

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//


        $arraydata = array(
            '' => '~Pilih TTD~',
            'helmi' => 'Helmi',
            'koen' => 'Soehono Koenarto',
            'didi' => 'Didi Agustiawan'
        );
        $ttd = ComboNonDb($arraydata, 'ttd', 'helmi', 'form-control form-control-sm', '~Pilih TTD~');


        $arraydata = array(
            '' => '~Pilih Pembayaran~',
            'Transfer' => 'Transfer',
            'Cash' => 'Cash',
            'Giro' => 'Giro'
        );
        $pembayaran = ComboNonDb($arraydata, 'pembayaran', '', 'form-control form-control-sm', '~Pilih Pembayaran~');



        //combo awal tampilan 
        $ParamArray = array(
            'ConectDB' => 'dbAcct',
            'Table' => 'fin_ap_m_supplier',
            'Field' => 'suppl_code,suppl_name'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('suppl_code' => '', 'suppl_name' => '~Pilih Supplier~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'suppl_code', 'class' => 'select2 form-control form-control-sm', 'placeholder' => '~Pilih Supplier~'),
        );
        $suppl_code = ComboDb($createcombo);


        $ParamArray = array(
            'ConectDB' => "dbAcct",
            'Table' => 'fin_ap_m_supplier_bank',
            'Field' => 'id_bank,concat(nama_bank,"~",atas_nama)'
        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        array_push($arraydata, array('id_bank' => '', 'nama_bank' => '~Pilih Bank~'));

        $createcombo = array(
            'data' => array_reverse($arraydata, true),
            'set_data' => array('set_id' => ''),
            'attribute' => array('idname' => 'id_bank', 'class' => 'select2 form-control form-control-sm', 'placeholder' => '~Pilih Bank~'),
        );
        $id_bank = ComboDb($createcombo);

        //end combo awal tampilan 


        //$masa_satuan = $this->db->query(" SELECT keterangan FROM whs_m_parameter WHERE txn_code='TERM' ")->result_array();

        $ParamArray = array(
            'Table' => 'masterproyek',
            'Field' => 'kodeproyek,lokasiproyek',

        );
        $arraydata = $this->m_function->value_result_array($ParamArray);
        $dataProyek = $arraydata;

        $comp = array(
            'company' => $company,
            'ttd' => $ttd,
            'pembayaran' => $pembayaran,
            'suppl_code' => $suppl_code,
            'id_bank' => $id_bank,
            'jml_ppn' => $jml_ppn,
            'id_category' => $id_category,
            'dataProyek' => $dataProyek
        );

        $this->load->view('add', $comp);
    }

    function c_load_search_barang()
    {
        $currentRowId = $this->input->post('currentRowId');

        $comp = array(
            'currentRowId' => $currentRowId
        );
        $this->load->view('search_item', $comp);
    }

    function c_get_po_ppn()
    {
        $tglpesan = date_db($this->input->post('tglpesan'));


        $ParamArray = array(
            'Table' => 'tbl_setting_ppn',
            'Field' => 'jml_ppn,keterangan',
            'Clause' => "'$tglpesan' >= begin_periode AND '$tglpesan' <= end_periode",
            'OrderBy' => 'begin_periode DESC',
            'Limit' => 1
        );

        $arraydata = $this->m_function->value_result_array($ParamArray);


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Get No PO Berhasill : " . $tglpesan . " 😊",
            'company' => $tglpesan,
            'po_ppn' => $arraydata
        );
        echo json_encode($pesan_data);
    }

    function c_get_po_category()
    {
        $jml_ppn = $this->input->post('jml_ppn');

        $ParamArray = array();
        if ($jml_ppn == "12") {
            $ParamArray = array(
                'Table' => 'tbl_setting_ppn_category',
                'WhereIN' => array('fieldIN' => 'id_category', 'fieldINValue' => array('1', '2'))
            );
        } else {
            $ParamArray = array(
                'Table' => 'tbl_setting_ppn_category',
                'WhereIN' => array('fieldIN' => 'id_category', 'fieldINValue' => array('3'))
            );
        }

        $arraydata = $this->m_function->value_result_array($ParamArray);


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Get No PO Berhasill : " . $jml_ppn . " 😊",
            'company' => $jml_ppn,
            'po_category' => $arraydata
        );
        echo json_encode($pesan_data);
    }


    function c_get_po_supplier()
    {

        $company = $this->input->post('company');

        $CnDB = "";
        if ($company == "MSA") {
            $CnDB = 'dbAcct';
        } else if ($company == "BAL") {
            $CnDB = "dbAcctBal";
        } else {
            $CnDB = 'dbAcct';
        }

        $ParamArray = array(
            'ConectDB' => $CnDB,
            'Table' => 'fin_ap_m_supplier',
            'Field' => 'suppl_code,suppl_name'
        );

        $arraydata = $this->m_function->value_result_array($ParamArray);


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Get No PO Berhasill : " . $company . " 😊",
            'company' => $company,
            'po_supplier' => $arraydata
        );
        echo json_encode($pesan_data);
    }

    function c_get_po_bank()
    {


        $company = $this->input->post('company');
        $suppl_code = $this->input->post('suppl_code');

        $CnDB = "";
        if ($company == "MSA") {
            $CnDB = 'dbAcct';
        } else if ($company == "BAL") {
            $CnDB = "dbAcctBal";
        } else {
            $CnDB = 'dbAcct';
        }

        $ParamArray = array(
            'ConectDB' => $CnDB,
            'Table' => 'fin_ap_m_supplier_bank',
            'Field' => 'id_bank,nama_bank',
            'WhereData' => array('id_suppl' => $suppl_code)
        );

        $arraydata = $this->m_function->value_result_array($ParamArray);


        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Get No PO Berhasill : " . $company . " 😊",
            'company' => $company,
            'po_bank' => $arraydata,
        );
        echo json_encode($pesan_data);
    }

    function c_get_po_rek()
    {
        $id_bank = $this->input->post('id_bank');
        $company = $this->input->post('company');

        $CnDB = "";
        if ($company == "MSA") {
            $CnDB = 'dbAcct';
        } else if ($company == "BAL") {
            $CnDB = "dbAcctBal";
        } else {
            $CnDB = 'dbAcct';
        }

        $ParamArray = array(
            'ConectDB' => $CnDB,
            'Table' => 'fin_ap_m_supplier_bank',
            'Field' => 'no_rek',
            'WhereData' => array('id_bank' => $id_bank)
        );

        $getNo_rek = $this->m_function->check_value($ParamArray);

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Get No PO Berhasill : " . $id_bank . " 😊",
            'getNo_rek' => $getNo_rek,
        );
        echo json_encode($pesan_data);
    }




    function c_get_po_number()
    {

        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $company = $this->input->post('company');

        $tahun    = date('Y');
        $bln       = date('m');

        $ParamArray = array(
            'Table' => 'masterdivisi',
            'WhereData' => array('kode_divisi' => $PO_kodedivisi),
            'Field' => 'nama_divisi'
        );

        $GetNameDivisi = $this->m_function->check_value($ParamArray);

        $ParamArray = array(
            'Table' => 'run_number',
            'WhereData' => array('tahun' => $tahun, 'comp' => $company, 'txn_code' => $GetNameDivisi),
            'Field' => 'seq_no'
        );

        $CekSeqno = $this->m_function->check_value($ParamArray);

        $ArraySave = array();

        if ($CekSeqno == "") {

            $ArraySave = array(
                'tahun' => $tahun,
                'txn_code' => $GetNameDivisi,
                'seq_no' => 1,
                'comp' => $company
            );


            $ParamSave = array(
                'Table' => 'run_number',
                'DataInsert' => $ArraySave
            );

            if (!$this->m_function->save_data($ParamSave) >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => "Get No PO Gagal...!! 😢",
                );
                echo json_encode($pesan_data);
                die;
            }
        }

        $GetNoPO = sprintf("%04s", $this->m_function->check_value($ParamArray));

        $nopo   = "{$GetNoPO}/{$GetNameDivisi}/{$company}/{$bln}/{$tahun}";

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Get No PO Berhasill : " . $nopo . " 😊",
            // 'GetNameDivisi' => $GetNameDivisi,
            // 'ParamArray' => $ParamArray,
            // 'ArraySave' => $ArraySave,
            'nopo' => $nopo,
        );
        echo json_encode($pesan_data);
    }


    function c_save_data()
    {

        $nopo = $this->input->post('nopo');
        $tglpesan = $this->input->post('tglpesan');
        $tglkrm = $this->input->post('tglkrm');
        $noreff = $this->input->post('noreff');
        $nomr = $this->input->post('nomr');
        $ttd = $this->input->post('ttd');
        $suppl_code = $this->input->post('suppl_code');
        $pembayaran = $this->input->post('pembayaran');
        $id_bank = $this->input->post('id_bank');
        $no_rek = $this->input->post('no_rek');
        $keteranganH = $this->input->post('keteranganH');
        $tgltempo = $this->input->post('tgltempo');
        $matauang = $this->input->post('matauang');
        $id_category = $this->input->post('id_category');

        $subtotalharga = $this->input->post('subtotalharga');
        $nilai_lain = $this->input->post('nilai_lain');
        $chkppn = $this->input->post('chkppn') ? 'Y' : 'N';
        $ppn = $this->input->post('ppn');
        $lain = $this->input->post('lain');
        $grandtotal = $this->input->post('grandtotal');


        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $ParamArray = array(
            'Table' => 'transpesan_head',
            'Field' => 'max(id_pesan) as id_pesan'
        );

        $id_pesan = floatval($this->m_function->check_value($ParamArray)) + 1;

        $ArrayHeader = array(
            'id_pesan' => $id_pesan, //belum
            'tglpesan' => $tglpesan,
            'nopo' => $nopo,
            'kodesupplier' => $suppl_code,
            'noreff' => $noreff,
            'nomr' => $nomr,
            'kode_divisi' => $PO_kodedivisi,
            'dateedited' => tanggal_sekarang(),
            'useredited' => $this->session->userdata('PO_username'),
            'created_on' => tanggal_sekarang(),
            'created_by' => $this->session->userdata('PO_username'),
            'tglkrm' => $tglkrm,
            'tgltempo' => $tgltempo,
            'matauang' => $matauang,
            'pembayaran' => $pembayaran,
            'status' => 'P1',
            'keterangan' =>  $keteranganH,
            'id_bank' => $id_bank,
            'discount_total' => 0, //belum
            'ttd' => $ttd,
            'rec_id' => 1,
            'subtotalharga' => str_replace(",", "", $subtotalharga),
            'ppn' => $chkppn,
            'lain' => str_replace(",", "", $lain),
            'nilai_lain' => str_replace(",", "", $nilai_lain),
            'id_category' => $id_category
        );




        //+++++++++++++++++++++++++

        $kode_proyek = $this->input->post('kode_proyek');
        $kodebarang  = $this->input->post('kodebarang');
        $qty = $this->input->post('qty');
        $harga        = $this->input->post('harga');
        $disc       = $this->input->post('disc');
        $total       = $this->input->post('total');


        $ParamArray = array(
            'Table' => 'transpesan_det',
            'Field' => 'max(no) as no',
            'WhereData' => array('id_pesan <>' => 0),
            'OrderBy' => 'no desc'
        );

        $id_transpesan_det = floatval($this->m_function->check_value($ParamArray)) + 1;

        $ArrayDetail = array();
        $ArrayKeteranganDetail = array();

        $keterangan  = $this->input->post('keterangan');

        foreach ($kodebarang as $index => $kodebarangID) {
            if (empty($kodebarangID)) continue;

            $ArrayDetailTemp = array(
                'no' => $id_transpesan_det,
                'id_pesan' => $id_pesan,
                'kodebarang' => $kodebarang[$index],
                'qtymsk' => floatval(str_replace(",", "",  $qty[$index])),
                'hargasatuan' => floatval(str_replace(",", "", $harga[$index])),
                'diskon' => floatval(str_replace(",", "", $disc[$index])),
                'kodeproyek' => $kode_proyek[$index],
                'total' => floatval(str_replace(",", "", $total[$index]))
            );



            //array keterangan barang
            $seqno = 1;
            if (isset($keterangan[$index]) && is_array($keterangan[$index])) {
                foreach ($keterangan[$index] as $ket) {
                    if (!empty(trim($ket))) {

                        $ArrayKeteranganDetailTemp = array(
                            'id_transpesan_det' => $id_transpesan_det,
                            'seqno' => $seqno,
                            'keteranganbarang' => $ket,
                        );

                        array_push($ArrayKeteranganDetail, $ArrayKeteranganDetailTemp);

                        $seqno = $seqno + 1;
                    }
                }
            }
            //end array keterangan barang


            array_push($ArrayDetail, $ArrayDetailTemp);
            $id_transpesan_det = floatval($id_transpesan_det) + 1;
        }


        $ParamSave = array(
            'Table' => 'transpesan_head',
            'DataInsert' => $ArrayHeader
        );

        $ParamSaveDetail = array(
            'Table' => 'transpesan_det',
            'DataInsert' => $ArrayDetail
        );

        $ParamSaveDetailKeterangan = array(
            'Table' => 'transpesan_det_keterangan',
            'DataInsert' => $ArrayKeteranganDetail
        );



        if (!$this->m_function->save_data($ParamSave) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Insert ke table transpesan_head gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        if (!$this->m_function->save_data_batch($ParamSaveDetail) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Insert ke table transpesan_det gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }


        if (count($ArrayKeteranganDetail) > 0) {
            if (!$this->m_function->save_data_batch($ParamSaveDetailKeterangan) >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Insert ke table transpesan_det_keterangan gagal...!!!  😢',
                );
                echo json_encode($pesan_data);
                die;
            }
        }


        //untuk update running number 
        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $company = $this->input->post('company');

        $tahun    = date('Y');

        $ParamArray = array(
            'Table' => 'masterdivisi',
            'WhereData' => array('kode_divisi' => $PO_kodedivisi),
            'Field' => 'nama_divisi'
        );

        $GetNameDivisi = $this->m_function->check_value($ParamArray);

        $ParamUpdate = array(
            'Table' => 'run_number',
            'DataUpdate' =>   array(
                'seq_no' => array('seq_no + 1', false)
            ),
            'WhereData' => array('tahun' => $tahun, 'txn_code' => $GetNameDivisi, 'comp' => $company)
        );


        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update ke table run_number gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }




        $pesan_data = array(
            'msg' => 'Ya',
            'ArrayHeader' => $ArrayHeader,
            'ArrayDetail' => $ArrayDetail,
            'ArrayKeteranganDetail' => $ArrayKeteranganDetail,
            'pesan' => "Data PO Berhasil Disimpan : " . $nopo . " 😊",
        );
        echo json_encode($pesan_data);
    }


    function c_update_data()
    {

        $id_pesan = $this->input->post('id_pesan');
        $nopo = $this->input->post('nopo');
        $tglpesan = $this->input->post('tglpesan');
        $tglkrm = $this->input->post('tglkrm');
        $noreff = $this->input->post('noreff');
        $nomr = $this->input->post('nomr');
        $ttd = $this->input->post('ttd');
        $suppl_code = $this->input->post('suppl_code');
        $pembayaran = $this->input->post('pembayaran');
        $id_bank = $this->input->post('id_bank');
        $no_rek = $this->input->post('no_rek');
        $keteranganH = $this->input->post('keteranganH');
        $tgltempo = $this->input->post('tgltempo');
        $matauang = $this->input->post('matauang');
        $id_category = $this->input->post('id_category');

        $subtotalharga = $this->input->post('subtotalharga');
        $nilai_lain = $this->input->post('nilai_lain');
        $chkppn = $this->input->post('chkppn') ? 'Y' : 'N';

        $lain = $this->input->post('lain');
        $grandtotal = $this->input->post('grandtotal');


        $PO_kodedivisi = $this->session->userdata('PO_kodedivisi');

        $ArrayHeader = array(
            'tglpesan' => $tglpesan,
            'nopo' => $nopo,
            'kodesupplier' => $suppl_code,
            'noreff' => $noreff,
            'nomr' => $nomr,
            'kode_divisi' => $PO_kodedivisi,
            'dateedited' => tanggal_sekarang(),
            'useredited' => $this->session->userdata('PO_username'),
            'tglkrm' => $tglkrm,
            'tgltempo' => $tgltempo,
            'matauang' => $matauang,
            'pembayaran' => $pembayaran,
            'keterangan' =>  $keteranganH,
            'id_bank' => $id_bank,
            'discount_total' => 0, //belum
            'ttd' => $ttd,
            'subtotalharga' => str_replace(",", "", $subtotalharga),
            'ppn' => $chkppn,
            'lain' => str_replace(",", "", $lain),
            'nilai_lain' => str_replace(",", "", $nilai_lain),
            'id_category' => $id_category
        );




        $kode_proyek = $this->input->post('kode_proyek');
        $kodebarang  = $this->input->post('kodebarang');
        $qty = $this->input->post('qty');
        $harga        = $this->input->post('harga');
        $disc       = $this->input->post('disc');
        $total       = $this->input->post('total');

        $ParamArray = array(
            'Table' => 'transpesan_det',
            'Field' => 'max(no) as no',
            'WhereData' => array('id_pesan <>' => 0),
            'OrderBy' => 'no desc'
        );

        $id_transpesan_det = floatval($this->m_function->check_value($ParamArray)) + 1;

        $ArrayDetail = array();
        $ArrayKeteranganDetail = array();


        $keterangan  = $this->input->post('keterangan');

        foreach ($kodebarang as $index => $kodebarangID) {
            if (empty($kodebarangID)) continue;

            $ArrayDetailTemp = array(
                'no' => $id_transpesan_det,
                'id_pesan' => $id_pesan,
                'kodebarang' => $kodebarang[$index],
                'qtymsk' => floatval(str_replace(",", "",  $qty[$index])),
                'hargasatuan' => floatval(str_replace(",", "", $harga[$index])),
                'diskon' => floatval(str_replace(",", "", $disc[$index])),
                'kodeproyek' => $kode_proyek[$index],
                'total' => floatval(str_replace(",", "", $total[$index]))
            );

            //array keterangan barang
            $seqno = 1;
            if (isset($keterangan[$index]) && is_array($keterangan[$index])) {
                foreach ($keterangan[$index] as $ket) {
                    if (!empty(trim($ket))) {


                        $ArrayKeteranganDetailTemp = array(
                            'id_transpesan_det' => $id_transpesan_det,
                            'seqno' => $seqno,
                            'keteranganbarang' => $ket,
                        );

                        array_push($ArrayKeteranganDetail, $ArrayKeteranganDetailTemp);

                        $seqno = $seqno + 1;
                    }
                }
            }
            //end array keterangan barang


            array_push($ArrayDetail, $ArrayDetailTemp);
            $id_transpesan_det = floatval($id_transpesan_det) + 1;
        }



        $ParamDeleteDetail = array(
            'Table' => 'transpesan_det',
            'WhereData' => array('id_pesan' => $id_pesan),
        );

        if (!$this->m_function->delete_data($ParamDeleteDetail) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update Delete ke table transpesan_det gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }


        $ParamDeleteDetailKet = array(
            'Table' => 'transpesan_det_keterangan',
            'Native_Query' => "delete FROM transpesan_det_keterangan  where id_transpesan_det in (SELECT no FROM transpesan_det where id_pesan='" . $id_pesan . "')"
        );

        if (!$this->m_function->execute_native_query($ParamDeleteDetailKet) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update Delete ke table transpesan_det_keterangan gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }



        //update data

        $ParamUpdate = array(
            'Table' => 'transpesan_head',
            'DataUpdate' => $ArrayHeader,
            'WhereData' => array('id_pesan' => $id_pesan)
        );

        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update ke table transpesan_head gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $ParamSaveDetail = array(
            'Table' => 'transpesan_det',
            'DataInsert' => $ArrayDetail
        );

        if (!$this->m_function->save_data_batch($ParamSaveDetail) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Update ke table transpesan_det gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $ParamSaveDetailKeterangan = array(
            'Table' => 'transpesan_det_keterangan',
            'DataInsert' => $ArrayKeteranganDetail
        );

        if (count($ArrayKeteranganDetail) > 0) {
            if (!$this->m_function->save_data_batch($ParamSaveDetailKeterangan) >= 1) {
                $pesan_data = array(
                    'msg' => 'Tidak',
                    'pesan' => 'Update ke table transpesan_det_keterangan gagal...!!!  😢',
                );
                echo json_encode($pesan_data);
                die;
            }
        }

        //end update data


        $pesan_data = array(
            'msg' => 'Ya',
            'ArrayHeader' => $ArrayHeader,
            'ArrayDetail' => $ArrayDetail,
            'ArrayKeteranganDetail' => $ArrayKeteranganDetail,
            'pesan' => "Data PO Berhasil DiUpdate : " . $nopo . " 😊",
        );
        echo json_encode($pesan_data);
    }


    function c_delete_data()
    {
        $id_pesan = $this->input->post('id_pesan');

        $ArrayUpdate = array(
            'status' => 'V',
            'dateedited' => tanggal_sekarang(),
            'useredited' => $this->session->userdata('PO_username')
        );

        $ParamUpdate = array(
            'Table' => 'transpesan_head',
            'DataUpdate' => $ArrayUpdate,
            'WhereData' => array('id_pesan' => $id_pesan)
        );

        //cek po
        $ParamCek = array(
            'Table' => 'transpesan_head',
            'WhereData' => array('id_pesan' => $id_pesan),
            'Field' => 'flag_finish'
        );
        $PoFinish = $this->m_function->check_value($ParamCek);

        if ($PoFinish == "1") {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Tidak Bisa Delete PO , Status PO Sudah Selesai...  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        //end cek po

        if (!$this->m_function->update_data($ParamUpdate) >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Delete ke table PO gagal...!!!  😢',
            );
            echo json_encode($pesan_data);
            die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
            'pesan' => "Data PO Berhasil Dihapus : " . $id_pesan . " 😊",
        );
        echo json_encode($pesan_data);
    }
}
