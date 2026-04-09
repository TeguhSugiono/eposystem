<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class M_function extends CI_Model
{

    function __construct()
    { // untuk awalan membuat class atau lawan kata nya index
        parent::__construct();
        $this->dbAcct = $this->load->database('dbAcct', TRUE);
        $this->dbAcctBal = $this->load->database('dbAcctBal', TRUE);
    }


    function string_toSession($NameSession, $ValueSession)
    {
        $this->session->unset_userdata($NameSession);
        $datasession = array($NameSession => $ValueSession);
        $this->session->set_userdata($datasession);
    }

    function string_array_toSession($StringArray)
    {
        foreach ($StringArray as $key => $value) {
            $this->string_toSession($key, $value);
        }
    }

    // $ParamArray = array(
    //     'ConectDB' => 'db',
    //     'Table' => '',
    //     'WhereData' => '',
    //     'WhereInData' => '',
    // );

    //untuk cek baris data sudah ada atau belum
    function check_row($ParamArray)
    {
        $Database = isset($ParamArray['ConectDB']) ? $ParamArray['ConectDB'] : 'db';
        $Table = $ParamArray['Table'];
        $WhereData = isset($ParamArray['WhereData']) ? $ParamArray['WhereData'] : array();

        if (count((array) $WhereData) > 0) {
            $this->$Database->where($WhereData);
        }
        $ckdata = $this->$Database->get($Table);

        if ($ckdata->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function check_num_row($ParamArray)
    {
        $Database = isset($ParamArray['ConectDB']) ? $ParamArray['ConectDB'] : 'db';
        $Table = $ParamArray['Table'];
        $WhereData = isset($ParamArray['WhereData']) ? $ParamArray['WhereData'] : array();
        $Clause = isset($ParamArray['Clause']) ? $ParamArray['Clause'] : array();
        $WhereIN = isset($ParamArray['WhereIN']) ? $ParamArray['WhereIN'] : array();
        $OrderBy = isset($ParamArray['OrderBy']) ? $ParamArray['OrderBy'] : '';
        $Limit = isset($ParamArray['Limit']) ? $ParamArray['Limit'] : '';

        if (count((array) $WhereIN) > 0) {
            $this->$Database->where_in($WhereIN['fieldIN'], $WhereIN['fieldINValue']);
        }

        if (count((array) $Clause) > 0) {
            $this->$Database->where($Clause, null, false);
        }

        if (count((array) $WhereData) > 0) {
            $this->$Database->where($WhereData);
        }

        if ($OrderBy != '') {
            $this->$Database->order_by($OrderBy);
        }

        if ($Limit != "") {
            $this->$Database->limit($Limit);
        }

        $ckdata = $this->$Database->get($Table);


        return $ckdata->num_rows();
    }

    //untuk cek value field data sudah ada atau belum
    // function check_value($ParamArray)
    // {
    //     $Database = isset($ParamArray['ConectDB']) ? $ParamArray['ConectDB'] : 'db';
    //     $Table = $ParamArray['Table'];
    //     $WhereData = isset($ParamArray['WhereData']) ? $ParamArray['WhereData'] : array();
    //     $Field = isset($ParamArray['Field']) ? $ParamArray['Field'] : '';

    //     if ($Field != "") {
    //         $this->$Database->select($Field);
    //     }
    //     if (count((array) $WhereData) > 0) {
    //         $this->$Database->where($WhereData);
    //     }
    //     $ckdata = $this->$Database->get($Table)->result_array();

    //     echo $this->$Database->last_query();

    //     $GetVal = "";
    //     foreach ($ckdata as $data) {
    //         $GetVal = $data[$Field];
    //     }

    //     return $GetVal;
    // }

    function check_value($ParamArray)
    {
        $Database   = isset($ParamArray['ConectDB']) ? $ParamArray['ConectDB'] : 'db';
        $Table      = $ParamArray['Table'];
        $WhereData  = isset($ParamArray['WhereData']) ? $ParamArray['WhereData'] : array();
        $Field      = isset($ParamArray['Field']) ? $ParamArray['Field'] : '';
        $OrderBy = isset($ParamArray['OrderBy']) ? $ParamArray['OrderBy'] : '';
        $Limit = isset($ParamArray['Limit']) ? $ParamArray['Limit'] : '';



        // Jika field pakai alias ("as"), ambil nama alias
        $Alias = $Field;
        if (stripos($Field, ' as ') !== false) {
            $exp   = preg_split('/\sas\s/i', $Field);
            $Alias = trim($exp[1]);
        }

        if ($Field != "") {
            $this->$Database->select($Field);
        }
        if (count((array) $WhereData) > 0) {
            $this->$Database->where($WhereData);
        }

        if ($OrderBy != '') {
            $this->$Database->order_by($OrderBy);
        }

        if ($Limit != "") {
            $this->$Database->limit($Limit);
        }

        $ckdata = $this->$Database->get($Table)->result_array();
        //echo $this->$Database->last_query();

        $GetVal = "";
        foreach ($ckdata as $data) {
            $GetVal = isset($data[$Alias]) ? $data[$Alias] : "";
        }

        return $GetVal;
    }


    //hasil data row format 1 baris hanya 1 array baris
    function value_result_row($ParamArray)
    {
        $Database = isset($ParamArray['ConectDB']) ? $ParamArray['ConectDB'] : 'db';
        $Table = $ParamArray['Table'];
        $WhereData = isset($ParamArray['WhereData']) ? $ParamArray['WhereData'] : array();
        $Field = isset($ParamArray['Field']) ? $ParamArray['Field'] : '';

        if ($Field != "") {
            $this->$Database->select($Field);
        }

        if (count((array) $WhereData) > 0) {
            $this->$Database->where($WhereData);
        }
        $arraydata = $this->$Database->get($Table)->row();

        return $arraydata;
    }



    //hasil data berupa multiple array dengan bentuk result_array
    function value_result_array($ParamArray)
    {
        $Database = isset($ParamArray['ConectDB']) ? $ParamArray['ConectDB'] : 'db';
        $Table = $ParamArray['Table'];
        $WhereData = isset($ParamArray['WhereData']) ? $ParamArray['WhereData'] : array();
        $Field = isset($ParamArray['Field']) ? $ParamArray['Field'] : '';
        $OrderBy = isset($ParamArray['OrderBy']) ? $ParamArray['OrderBy'] : '';
        $ArrayJoin = isset($ParamArray['ArrayJoin']) ? $ParamArray['ArrayJoin'] : array();
        $Limit = isset($ParamArray['Limit']) ? $ParamArray['Limit'] : '';
        $Clause = isset($ParamArray['Clause']) ? $ParamArray['Clause'] : array();
        $WhereIN = isset($ParamArray['WhereIN']) ? $ParamArray['WhereIN'] : array();
        $GroupBy = isset($ParamArray['GroupBy']) ? $ParamArray['GroupBy'] : '';


        if ($Field != "") {
            $this->$Database->select($Field);
        }

        if (count((array) $WhereData) > 0) {
            $this->$Database->where($WhereData);
        }

        if (count((array) $WhereIN) > 0) {
            $this->$Database->where_in($WhereIN['fieldIN'], $WhereIN['fieldINValue']);
        }

        if (count((array) $Clause) > 0) {
            $this->$Database->where($Clause, null, false);
        }

        if ($GroupBy != "") {
            $this->$Database->group_by($GroupBy);
        }

        if ($OrderBy != '') {
            $this->$Database->order_by($OrderBy);
        }

        if ($Limit != "") {
            $this->$Database->limit($Limit);
        }

        if (count((array) $ArrayJoin) > 0) {
            for ($a = 0; $a < count($ArrayJoin); $a++) {
                $this->$Database->join($ArrayJoin[$a][0], $ArrayJoin[$a][1], $ArrayJoin[$a][2]);
            }
        }

        $arraydata = $this->$Database->get($Table)->result_array();

        //echo $this->$Database->last_query();

        return $arraydata;
    }

    //untuk proses executin native query
    function execute_native_query($ParamArray)
    {
        $Database = isset($ParamArray['ConectDB']) ? $ParamArray['ConectDB'] : 'db';
        $Native_Query = $ParamArray['Native_Query'];

        $ExecuteNativeQuery = $this->$Database->query($Native_Query);

        if (!$ExecuteNativeQuery >= 1) {
            return 0;
        } else {
            return 1;
        }
    }

    function value_native_query($ParamArray)
    {


        $Database = isset($ParamArray['ConectDB']) ? $ParamArray['ConectDB'] : 'db';
        $Query = $ParamArray['Query'];
        $Field = isset($ParamArray['Field']) ? $ParamArray['Field'] : '';


        $ckdata = $this->$Database->query($Query)->result_array();


        $GetVal = "";
        foreach ($ckdata as $data) {
            $GetVal = $data[$Field];
        }

        return $GetVal;
    }

    function save_data($ParamArray)
    {
        $Database = isset($ParamArray['ConectDB']) ? $ParamArray['ConectDB'] : 'db';
        $Table = $ParamArray['Table'];
        $DataInsert = $ParamArray['DataInsert'];

        $data = $this->$Database->insert($Table, $DataInsert);
        return $data;
    }

    function save_data_batch($ParamArray)
    {
        $Database = isset($ParamArray['ConectDB']) ? $ParamArray['ConectDB'] : 'db';
        $Table    = $ParamArray['Table'];
        $DataInsert = $ParamArray['DataInsert'] ?? [];

        if (count($DataInsert) === 1) {
            return $this->$Database->insert($Table, $DataInsert[0]);
        }

        if (count($DataInsert) > 1) {
            return $this->$Database->insert_batch($Table, $DataInsert);
        }

        return false;
    }

    // function update_data($ParamArray)
    // {
    //     $Database = isset($ParamArray['ConectDB']) ? $ParamArray['ConectDB'] : 'db';
    //     $Table = $ParamArray['Table'];
    //     $DataUpdate = $ParamArray['DataUpdate'];
    //     $WhereData = $ParamArray['WhereData'];


    //     $data = $this->$Database->update($Table, $DataUpdate, $WhereData);
    //     return $data;
    // }

    function update_data($ParamArray)
    {
        $Database = isset($ParamArray['ConectDB']) ? $ParamArray['ConectDB'] : 'db';
        $Table      = $ParamArray['Table'];
        $DataUpdate = $ParamArray['DataUpdate'] ?? [];
        $WhereData  = $ParamArray['WhereData'] ?? [];
        $WhereIN = isset($ParamArray['WhereIN']) ? $ParamArray['WhereIN'] : array();

        // Handle raw expression (seq_no + 1)
        foreach ($DataUpdate as $field => $value) {
            if (is_array($value) && isset($value[1]) && $value[1] === false) {
                // Raw expression
                $this->$Database->set($field, $value[0], FALSE);
            } else {
                $this->$Database->set($field, $value);
            }
        }

        if (!empty($WhereData)) {
            $this->$Database->where($WhereData);
        }




        if (count((array) $WhereIN) > 0) {
            $this->$Database->where_in($WhereIN['fieldIN'], $WhereIN['fieldINValue']);
        }

        return $this->$Database->update($Table);
    }


    function delete_data($ParamArray)
    {
        $Database = isset($ParamArray['ConectDB']) ? $ParamArray['ConectDB'] : 'db';
        $Table      = $ParamArray['Table'];
        $WhereData  = $ParamArray['WhereData'] ?? [];
        $WhereIN = isset($ParamArray['WhereIN']) ? $ParamArray['WhereIN'] : array();


        if (count((array) $WhereIN) > 0) {
            $this->$Database->where_in($WhereIN['fieldIN'], $WhereIN['fieldINValue']);
        }


        if (!empty($WhereData)) {
            $this->$Database->where($WhereData);
        }

        return $this->$Database->delete($Table);
    }


    function GoToHistoriData($id_pesan_det, $id_request_det)
    {

        //disini kita cari nopo atau id po yang ada sebelumnya pada saat request
        $query = " SELECT id_request, id_pesan
                    FROM (
                        SELECT
                            id_request,
                            id_pesan,
                            ROW_NUMBER() OVER (
                                PARTITION BY id_pesan
                                ORDER BY id_request DESC
                            ) AS rn
                        FROM tbl_request_po
                        WHERE id_pesan = '" . $id_pesan_det . "'
                    ) t
                    WHERE rn = 2 ";

        $dataBefore = $this->db->query($query)->result_array();

        foreach ($dataBefore as $resdataBefore) {
            $id_pesan_det = $resdataBefore['id_pesan'];
            $id_request_det = $resdataBefore['id_request'];
        }



        $ParamArray = array(
            'Table' => 'transpesan_head',
            'WhereData' => array('id_pesan' => $id_pesan_det),
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



        $ParamArray = [
            'Table' => 'transpesan_head_old',
            'Field' => 'ifnull(MAX(id_old),0) + 1 as nomor'
        ];
        $runNumber = $this->m_function->check_value($ParamArray);

        //insert ke transpesan_head_old
        $Query1 = " insert into transpesan_head_old (no,id_pesan,tglpesan,nopo,kodesupplier,noreff,nomr,kode_divisi,dateedited,useredited,
                    tglkrm,tgltempo,matauang,pembayaran,status,subtotalharga,ppn,keterangan,id_bank,discount_total,
                    ttd,no_invoice,faktur_pajak,tgl_invoice,rec_id,lain,id_category,nilai_lain,created_on,created_by,
                    flag_finish,flag_id_request,flag_revisi,tipedata,id_old,id_request,suppl_name,address1,address2,address3,phone,fax,contact_person) ";
        $Query1 .= " select *," . $runNumber . "," . $id_request_det . ",'" . $GetSupplier[0]['suppl_name'] . "', 
                    '" . $GetSupplier[0]['address1'] . "' ,'" . $GetSupplier[0]['address2'] . "' ,
                    '" . $GetSupplier[0]['address3'] . "' ,'" . $GetSupplier[0]['phone'] . "' ,
                    '" . $GetSupplier[0]['fax'] . "' ,'" . $GetSupplier[0]['contact_person'] . "' 
                    from  transpesan_head where id_pesan='" . $id_pesan_det . "' ";
        $hasil1 = $this->db->query($Query1);

        if (!$hasil1 >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Simpan Log transpesan_head  Gagal...!!!  😢',
            );
            return $pesan_data;
            die;
        }

        //insert ke transpesan_det_old
        $Query2 = " insert into transpesan_det_old (no,id_pesan,kodebarang,qtymsk,hargasatuan,diskon,kodeproyek,
                    Keterangan_detail,total,sn,id_old,itembarang,merk,type,category,satuan) ";
        $Query2 .= " select a.*," . $runNumber . ",b.itembarang,b.merk,b.type,b.category,b.satuan 
                        from  transpesan_det a  INNER JOIN masterbarang b on a.kodebarang=b.kodebarang where a.id_pesan='" . $id_pesan_det . "' ";
        $hasil2 = $this->db->query($Query2);

        if (!$hasil2 >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Simpan Log transpesan_det  Gagal...!!!  😢',
            );
            return $pesan_data;
            die;
        }



        //insert ke transpesan_det_keterangan_old
        $Query3 = " insert into transpesan_det_keterangan_old (id_transpesan_det,id_ket_detail,seqno,keteranganbarang,id_old) ";
        $Query3 .= " SELECT a.*," . $runNumber . " FROM transpesan_det_keterangan a INNER JOIN transpesan_det b 
                        on a.id_transpesan_det=b.no 
                        where b.id_pesan='" . $id_pesan_det . "' ";
        $hasil3 = $this->db->query($Query3);

        if (!$hasil3 >= 1) {
            $pesan_data = array(
                'msg' => 'Tidak',
                'pesan' => 'Simpan Log transpesan_det_keterangan  Gagal...!!!  😢',
            );
            return $pesan_data;
            die;
        }

        $pesan_data = array(
            'msg' => 'Ya',
        );
        return $pesan_data;
    }

    function CreateLinkManager($email_manager)
    {
        $this->load->library('custom_encrypt');

        $ParamArray = array(
            'Table' => 'masteruser',
            'WhereData' => array('email' => $email_manager),
            'Field' => 'password_hash',
        );

        $password_hash = $this->check_value($ParamArray);

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

    function generator_xls($setting_xls)
    {

        $jumlah_sheet = $setting_xls['jumlah_sheet'];
        $nama_sheet = $setting_xls['nama_sheet'];
        $data_all_sheet = $setting_xls['data_all_sheet'];
        $nama_excel = $setting_xls['nama_excel'];

        $spreadsheet = new Spreadsheet();
        for ($a = 0; $a < $jumlah_sheet; $a++) {

            $baris = 1;
            $kolom = 1;

            $spreadsheet->createSheet();

            $spreadsheet->setActiveSheetIndex($a);
            $spreadsheet->getActiveSheet()->setTitle($nama_sheet[$a]);
            $sheet = $spreadsheet->getActiveSheet();

            //JUDUL TABLE
            foreach ($setting_xls['data_all_sheet'][$a][0] as $key => $value) {
                $sheet->setCellValueByColumnAndRow($kolom, $baris, $key);
                $kolom++;
            }

            $baris++;
            $nomor = 1;
            //ISI TABLE TABLE
            for ($v = 0; $v < count($setting_xls['data_all_sheet'][$a]); $v++) {
                $array_value = array_values($setting_xls['data_all_sheet'][$a][$v]);


                $kolom = 1;
                for ($b = 0; $b < count($array_value); $b++) {

                    $nilai = $array_value[$b];


                    if ($b == 0 && $array_value[$b] == "nomor") {
                        $sheet->setCellValueByColumnAndRow($kolom, $baris, $nomor);
                    } else {
                        //$sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[$b]));
                        //$this->setCellValueSmart($sheet, $kolom, $baris, $nilai);

                        $value = trim($array_value[$b]);

                        // cek apakah angka format 750,000.00
                        if (is_numeric(str_replace(',', '', $value))) {

                            $angka = str_replace(',', '', $value);

                            $sheet->setCellValueByColumnAndRow($kolom, $baris, $angka);

                            // set format number excel
                            $sheet->getStyleByColumnAndRow($kolom, $baris)
                                ->getNumberFormat()
                                ->setFormatCode('#,##0.00');
                        } else {

                            $sheet->setCellValueByColumnAndRow($kolom, $baris, $value);
                        }
                    }
                    $kolom++;
                }
                $baris++;
                $nomor++;
            }

            $kolom = 1;
            foreach ($setting_xls['data_all_sheet'][0][0] as $key => $value) {
                $sheet->getColumnDimensionByColumn($kolom)->setAutoSize(true);
                $kolom++;
            }
        }


        $spreadsheet->setActiveSheetIndex(0);
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $nama_excel . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    function setCellValueSmart($sheet, $kolom, $baris, $nilai)
    {
        $nilai = trim($nilai ?? '');  // aman kalau null

        // Coba bersihkan format angka Indonesia/Internasional yang umum
        $clean = str_replace(['.', ','], ['', '.'], $nilai);  // ganti titik ribuan → kosong, koma desimal → titik
        $clean = preg_replace('/[^0-9.-]/', '', $clean);     // buang semua selain angka, minus, titik

        if (is_numeric($clean) && $clean !== '') {
            $number = (float)$clean;

            $sheet->setCellValueByColumnAndRow($kolom, $baris, $number);

            // Format: ribuan pakai koma + 2 desimal (sesuai contoh 750,000.00)
            $sheet->getStyleByColumnAndRow($kolom, $baris)
                ->getNumberFormat()
                ->setFormatCode('#,##0.00');

            // Optional: rata kanan (default number sudah begitu, tapi bisa ditegaskan)
            $sheet->getStyleByColumnAndRow($kolom, $baris)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        } else {
            // Bukan angka → simpan sebagai string biasa
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $nilai);
        }
    }


    // function shortenUrl($longUrl)
    // {
    //     $apiUrl = 'https://is.gd/create.php?format=simple&url=' . urlencode($longUrl);

    //     $client = new Client(['timeout' => 10]);

    //     try {
    //         $response = $client->get($apiUrl);
    //         if ($response->getStatusCode() === 200) {
    //             $shortUrl = trim((string) $response->getBody());
    //             if (filter_var($shortUrl, FILTER_VALIDATE_URL)) {
    //                 return $shortUrl;
    //             }
    //         }
    //     } catch (Exception $e) {
    //         // fallback
    //     }

    //     return $longUrl;
    // }
}
