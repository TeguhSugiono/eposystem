<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

if (! function_exists('generateUUID')) {
    function generateUUID()
    {
        return bin2hex(random_bytes(16)); // 32 char
    }
}


if (! function_exists('terbilang')) {

    function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "Minus " . trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }
        return $hasil;
    }

    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }
}


if (!function_exists('format_dolar')) {

    function format_dolar($number)
    {
        return number_format($number, 2, '.', ',');
    }
}

if (!function_exists('quotStr')) {
    function quotStr($string)
    {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('hakakses')) {
    function hakakses($array)
    {
        $CI = &get_instance();

        if ($CI->session->userdata('PO_hakakses') == 'Owner') {
            unset($array['WhereData']['kode_divisi']);
        }

        return $array;
    }
}

if (!function_exists('showdate_inv2')) {

    function showdate_inv2($tgl)
    {

        // Pastikan variabel tidak kosong
        if (empty($tgl)) return "-";

        try {
            // Langsung masukkan string ke constructor DateTime
            $date = new DateTime($tgl);
        } catch (Exception $e) {
            return "Invalid date format!";
        }

        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $day = $date->format('d');
        $monthNumber = $date->format('m');
        $year = $date->format('Y');

        return $day . ' ' . $bulan[$monthNumber] . ' ' . $year;
    }
}


if (!function_exists('showdate_dmy')) {
    function showdate_dmy($tgl)
    {
        //return date('d-m-Y', strtotime($tgl));
        if ($tgl == '' || $tgl == NULL || $tgl == '0000:00:00' || $tgl == '0000:00:00 00:00:00') {
            return '';
        } else {
            return date('d-m-Y', strtotime($tgl));
        }
    }
}


if (!function_exists('showdate_dmy_request')) {
    function showdate_dmy_request($tgl)
    {
        //return date('d-m-Y', strtotime($tgl));
        if ($tgl == '' || $tgl == NULL || $tgl == '0000:00:00' || $tgl == '0000:00:00 00:00:00') {
            return '';
        } else {
            return date('dmY', strtotime($tgl));
        }
    }
}

if (!function_exists('showdate_dmyhis')) {
    function showdate_dmyhis($tgl)
    {
        //return date('d-m-Y', strtotime($tgl));
        if ($tgl == '' || $tgl == NULL || $tgl == '0000:00:00' || $tgl == '0000:00:00 00:00:00') {
            return '';
        } else {
            return date('d-m-Y H:i:s', strtotime($tgl));
        }
    }
}

if (!function_exists('showdate_dmybc')) {
    function showdate_dmybc($tgl)
    {
        //return date('d-m-Y', strtotime($tgl));
        if ($tgl == '' || $tgl == NULL || $tgl == '0000:00:00' || $tgl == '0000:00:00 00:00:00') {
            return '';
        } else {
            return date('d/m/Y', strtotime($tgl));
        }
    }
}
if (!function_exists('date_ymd')) {
    function date_ymd($tgl)
    {
        if ($tgl == '' || $tgl == NULL || $tgl == '0000:00:00' || $tgl == '0000:00:00 00:00:00') {
            return '';
        } else {
            return date("Ymd", strtotime($tgl));
        }
    }
}

if (!function_exists('date_ymdhis')) {
    function date_ymdhis($tgl)
    {
        if ($tgl == '' || $tgl == NULL || $tgl == '0000:00:00' || $tgl == '0000:00:00 00:00:00') {
            return '';
        } else {
            return date("YmdHis", strtotime($tgl));
        }
    }
}

if (!function_exists('date_ymdhis1')) {
    function date_ymdhis1($tgl)
    {
        if ($tgl == '' || $tgl == NULL || $tgl == '0000:00:00' || $tgl == '0000:00:00 00:00:00') {
            return '';
        } else {
            return date("Y-m-d H:i:s", strtotime($tgl));
        }
    }
}

if (!function_exists('tanggal_sekarang')) {
    function tanggal_sekarang()
    {
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('jam_sekarang')) {
    function jam_sekarang()
    {
        return date('H:m:i');
    }
}

if (!function_exists('jam')) {
    function jam($jam)
    {
        return date('H:i A', strtotime($jam));
    }
}

if (!function_exists('tanggal_sekarang_with_nol')) {
    function tanggal_sekarang_with_nol()
    {
        return date('Y-m-d 00:00:00');
    }
}

if (!function_exists('date_db')) {
    function date_db($tgl)
    {
        if ($tgl == '' || $tgl == NULL || $tgl == '0000:00:00' || $tgl == '0000:00:00 00:00:00') {
            return NULL;
        } else {
            return date('Y-m-d', strtotime($tgl));
        }
    }
}

if (!function_exists('date_db_new')) {
    function date_db_new($tgl, $formatter)
    {
        if ($tgl == '' || $tgl == NULL || $tgl == '0000:00:00' || $tgl == '0000:00:00 00:00:00') {
            return NULL;
        } else {
            return DateTime::createFromFormat($formatter, $tgl)->format('Y-m-d');
        }
    }
}

if (!function_exists('date_format_with_nol')) {
    function date_format_with_nol($tgl)
    {
        return date('Y-m-d 00:00:00', strtotime($tgl));
    }
}

if (!function_exists('selisih_tanggal')) {
    function selisih_tanggal($tgl1, $tgl2)
    {
        $date1 = date_create($tgl1);
        $date2 = date_create($tgl2);
        $diff = date_diff($date1, $date2)->format("%a");
        return $diff;
    }
}

if (!function_exists('getvalueb')) {
    function getvalueb($arraydata)
    {
        $array = json_decode(json_encode($arraydata), true);
        return array_values($array)[0];
    }
}

if (!function_exists('ComboNonDbOld')) {
    function ComboNonDbOld($arraydata, $namecbo, $setname, $setclass)
    {
        $data['$namecbo'] = form_dropdown($namecbo, $arraydata, $setname, 'id="' . $namecbo . '" class="form-control ' . $setclass . '" style="width: 100%"');
        return $data['$namecbo'];
    }
}

if (!function_exists('ComboNonDb')) {
    function ComboNonDb($arraydata, $namecbo, $setname = '', $setclass = '', $placeholder = '~Pilih Data~')
    {
        // Tambah opsi kosong biar placeholder keliatan
        $arraydata = ['' => $placeholder] + $arraydata;

        // Build atribut HTML (tambah data-placeholder + live search)
        $attributes = 'id="' . $namecbo . '" ';
        $attributes .= 'class="form-control ' . $setclass . '" ';
        $attributes .= 'style="width: 100%;" ';
        $attributes .= 'data-placeholder="' . $placeholder . '" ';
        //$attributes .= 'data-live-search="true"';

        // Return dropdown (pakai $data biar sesuai gaya lama kamu)
        $data['combo'] = form_dropdown($namecbo, $arraydata, $setname, $attributes);
        return $data['combo'];
    }
}




// if (!function_exists('ComboDb')) {
//     function ComboDb($createcombo)
//     {
//         foreach ($createcombo['data'] as $row) {
//             $arraydata[array_values($row)[0]] = array_values($row)[1];
//         }
//         $combo = form_dropdown($createcombo['attribute']['idname'], $arraydata, $createcombo['set_data']['set_id'], 'id="' . $createcombo['attribute']['idname'] . '" class="form-control ' . $createcombo['attribute']['class'] . '" style="width: 100%;" data-live-search="true"');
//         return $combo;
//     }
// }

if (!function_exists('ComboDb')) {
    function ComboDb($createcombo)
    {
        $arraydata = [];

        foreach ($createcombo['data'] as $row) {
            $arraydata[array_values($row)[0]] = array_values($row)[1];
        }

        // Ambil placeholder (jika ada)
        // $placeholder = isset($createcombo['attribute']['placeholder'])
        //     ? $createcombo['attribute']['placeholder']
        //     : '';

        // Build attribute HTML
        $attr  = 'id="' . $createcombo['attribute']['idname'] . '" ';
        $attr .= 'class="form-control ' . $createcombo['attribute']['class'] . '" ';
        $attr .= 'style="width: 100%;" ';
        $attr .= 'data-placeholder="' . $createcombo['attribute']['placeholder'] . '" ';
        $attr .= 'data-live-search="true"';

        return form_dropdown(
            $createcombo['attribute']['idname'],
            $arraydata,
            $createcombo['set_data']['set_id'],
            $attr
        );
    }
}


if (!function_exists('ComboDbx')) {
    function ComboDbx($createcombo)
    {
        foreach ($createcombo['data'] as $row) {
            $arraydata[array_values($row)[0]] = array_values($row)[1];
        }
        $combo = form_dropdown($createcombo['attribute']['idname'], $arraydata, $createcombo['set_data']['set_id'], 'id="' . $createcombo['attribute']['idname'] . '" class="form-control ' . $createcombo['attribute']['class'] . '" style="width: 100%;" ');
        return $combo;
    }
}

if (!function_exists('cbodisplay')) {
    function cbodisplay()
    {
        $data = array('10' => '10 Data Per Halaman', '25' => '25 Data Per Halaman', '50' => '50 Data Per Halaman', '100' => '100 Data Per Halaman', '1000' => '1000 Data Per Halaman');
        $createselect = ComboNonDb($data, 'display', '10', 'form-control');
        return $createselect;
    }
}

if (!function_exists('cbodisplay_on_modal')) {
    function cbodisplay_on_modal()
    {
        $data = array('10' => '10 Data Per Halaman', '25' => '25 Data Per Halaman', '50' => '50 Data Per Halaman', '100' => '100 Data Per Halaman', '1000' => '1000 Data Per Halaman');
        $createselect = ComboNonDb($data, 'cbodisplay_on_modal', '10', 'form-control');
        return $createselect;
    }
}

if (!function_exists('cbodisplay_out')) {
    function cbodisplay_out()
    {
        $data = array('10' => '10 Data Per Halaman', '25' => '25 Data Per Halaman', '50' => '50 Data Per Halaman', '100' => '100 Data Per Halaman', '1000' => '1000 Data Per Halaman');
        $createselect = ComboNonDb($data, 'display_out', '10', 'form-control');
        return $createselect;
    }
}

if (!function_exists('cbodisplay_do')) {
    function cbodisplay_do()
    {
        $data = array('10' => '10 Data Per Halaman', '25' => '25 Data Per Halaman', '50' => '50 Data Per Halaman', '100' => '100 Data Per Halaman', '1000' => '1000 Data Per Halaman');
        $createselect = ComboNonDb($data, 'display_do', '10', 'form-control');
        return $createselect;
    }
}


if (!function_exists('tambah_spasi')) {
    function tambah_spasi($field, $field_name)
    {
        $batas_value_per_field = 20;

        $jml_string_awal = strlen($field);
        $sisa_karakter = $batas_value_per_field - $jml_string_awal;

        // if($field == "45DS"){
        //     $sisa_karakter = $sisa_karakter - 1 ;
        // }

        // if($field_name == "masuk"){
        //     if($jml_string_awal == 2){

        //     }
        // }

        //tambahkan spasi berdasarkan $sisa_karakter
        $spasi = "";
        for ($a = 1; $a <= $sisa_karakter; $a++) {
            $spasi .= " ";
        }

        $field = $field . $spasi;
        return $field;
    }

    if (!function_exists('replace_xml_condition')) {
        function replace_xml_condition($Tag, $TagString, $Value, $DataMentah)
        {
            return str_replace("<" . $Tag . ">" . $TagString . "</" . $Tag . ">", "<" . $Tag . ">" . $Value . "</" . $Tag . ">", $DataMentah);
        }
    }
}

if (!function_exists('ArrayToString')) {
    function ArrayToString($array)
    {
        $SqlID = "";
        if (count((array) $array) > 0) {
            if (count((array) $array) == 1) {
                $SqlID = $array[0];
            } else {
                for ($a = 0; $a < count((array) $array); $a++) {
                    if ($a == 0) {
                        $SqlID = $array[$a];
                    } else {
                        $SqlID = $SqlID . "," . $array[$a];
                    }
                }
            }
        }

        //$SqlID = "(" . $SqlID . ")";

        return $SqlID;
    }
}

if (!function_exists('ArrayToInSql')) {
    function ArrayToInSql($array)
    {
        $SqlID = "";
        if (count((array) $array) > 0) {
            if (count((array) $array) == 1) {
                $SqlID = "'" . $array[0] . "'";
            } else {
                for ($a = 0; $a < count((array) $array); $a++) {
                    if ($a == 0) {
                        $SqlID = "'" . $array[$a] . "'";
                    } else {
                        $SqlID = $SqlID . ",'" . $array[$a] . "'";
                    }
                }
            }
        }

        $SqlID = "(" . $SqlID . ")";

        return $SqlID;
    }
}

if (!function_exists('Search_Str_To_Str')) {
    function Search_Str_To_Str($data, $search)
    {
        $ok = 0;
        if (preg_match("/$search/i", $data)) {
            //echo 'Kata <b>'.$dicari.'</b> ditemukan.';
            $ok = 1;
        } else {
            //echo 'Kata <b>'.$dicari.'</b> tidak ditemukan.';
            $ok = 0;
        }
        return $ok;
    }
}


if (!function_exists('count_strsearch_to_strparam')) {
    function count_strsearch_to_strparam($strsearch, $strparam)
    {
        $str = str_replace($strsearch, "", $strparam, $count);
        return $count;
    }
}


//contoh penggunaan                       
//$dapatdata = $this->SearchNameFromArray(386,$data_shipper,'vessel_id','vessel_name');
function SearchNameFromArray($id, $array, $tag_from_search, $tag_from_value)
{
    foreach ($array as $key => $val) {
        if ($val[$tag_from_search] == $id) {
            return $val[$tag_from_value];
        }
    }
    return null;
}
