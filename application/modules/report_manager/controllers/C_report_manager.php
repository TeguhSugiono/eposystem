<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_report_manager extends CI_Controller
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

        // $arraydata = array(
        //     '' => 'ALL',
        //     'MSA' => 'PT.Multi Sejahtera Abadi',
        //     'BAL' => 'PT.Balrich Logistics',
        // );
        // $selectperusahaan = ComboNonDbOld($arraydata, 'selectperusahaan', '', 'form-control form-control-sm SettDisplayReport');


        // $ParamArray = array(
        //     'Table' => 'tbl_request_approval',
        //     'Field' => 'id_status_approval,status_approval',
        //     'WhereIN' => array('fieldIN' => 'id_status_approval', 'fieldINValue' => array('1', '3', '4'))
        // );
        // $arraydata = $this->m_function->value_result_array($ParamArray);
        // array_push($arraydata, array('id_status_approval' => '', 'status_approval' => 'ALL'));

        // $createcombo = array(
        //     'data' => array_reverse($arraydata, true),
        //     'set_data' => array('set_id' => ''),
        //     'attribute' => array('idname' => 'id_status_approval', 'class' => 'form-control form-control-sm SettDisplayReport', 'placeholder' => '~Pilih Type~'),
        // );
        // $id_status_approval = ComboDb($createcombo);


        $arraydata = array(
            '' => 'ALL',
            'Y' => 'Accept',
            'R' => 'Reject',
            'C' => 'Canceled By Direktur'
        );
        $typeApprove = ComboNonDbOld($arraydata, 'typeApprove', '', 'form-control form-control-sm SettDisplayReport');

        $comp = array(
            'content' => 'view',
            // 'selectperusahaan' => $selectperusahaan,
            // 'id_status_approval' => $id_status_approval,
            'typeApprove' => $typeApprove
        );

        $this->load->view('dashboard/index', $comp);
    }

    function c_export()
    {
        $data = base64_decode($_GET['data']);
        $data = explode(',', $data);

        $selectperusahaan = $data[0];
        $id_status_approval = $data[1];
        $typeApprove = $data[2];
        $tglpesan1 = $data[3];
        $tglpesan2 = $data[4];

        $query = " SELECT  'nomor' as 'No',date_format(c.tglpesan,'%d %M %Y') 'Tgl PO',c.nopo 'No Po',b.nama_divisi 'Dept',
                format(c.subtotalharga,2) 'Subtotal',
                ppn_param_date (c.tglpesan) AS 'Ppn',
                format(c.nilai_lain,2) 'Nilai Lain',
                format(c.ppn,2) 'Jml PPN',
                format(hitung_grandtotal (subtotalharga, ppn_param_date (tglpesan), c.ppn, c.id_category, c.discount_total),2) AS 'Grand Total' 
                from " . $this->session->userdata('PO_name_tbl_request') . " a 
                left JOIN masterdivisi b on a.kode_divisi=b.kode_divisi
                INNER JOIN " . $this->session->userdata('PO_name_tbl_header') . " c on a.id_pesan=c.id_pesan 
                left JOIN mastersupplier d on c.kodesupplier=d.kodesupplier 
                where a.kode_divisi <> '' ";

        // if ($selectperusahaan != "") {
        //     $query .= " and get_company(c.nopo)='" . $selectperusahaan . "' ";
        // }

        // if ($id_status_approval != "") {
        //     $query .= " and a.id_status_approval='" . $id_status_approval . "' ";
        // }

        if ($typeApprove != "") {
            $query .= " and a.acc_manager='" . $typeApprove . "' ";
        }

        if ($tglpesan1 != "") {
            $query .= " and date_format(c.tglpesan,'%Y-%m-%d') >= '" . $tglpesan1 . "' ";
        }

        if ($tglpesan2 != "") {
            $query .= " and date_format(c.tglpesan,'%Y-%m-%d') <= '" . $tglpesan2 . "' ";
        }

        $GetData = $this->db->query($query)->result_array();



        $query2 = " SELECT 'nomor' as 'No',b.nopo,concat(d.itembarang,' ',d.merk,' ',d.type) 'Nama Barang',
                    qtymsk 'Qty',format(hargasatuan,2) 'Harga',
                    format(diskon,2) 'Discount',format(total,2) 'Total'
                    from " . $this->session->userdata('PO_name_tbl_request') . " a 
                    INNER JOIN " . $this->session->userdata('PO_name_tbl_header') . " b on a.id_pesan=b.id_pesan 
                    INNER JOIN " . $this->session->userdata('PO_name_tbl_detail') . " c on b.id_pesan=c.id_pesan
                    INNER JOIN masterbarang d on c.kodebarang=d.kodebarang
                    INNER JOIN masterproyek e on c.kodeproyek=e.kodeproyek ";

        // if ($selectperusahaan != "") {
        //     $query2 .= " and get_company(b.nopo)='" . $selectperusahaan . "' ";
        // }

        // if ($id_status_approval != "") {
        //     $query2 .= " and a.id_status_approval='" . $id_status_approval . "' ";
        // }

        if ($typeApprove != "") {
            $query2 .= " and a.acc_manager='" . $typeApprove . "' ";
        }

        if ($tglpesan1 != "") {
            $query2 .= " and date_format(b.tglpesan,'%Y-%m-%d') >= '" . $tglpesan1 . "' ";
        }

        if ($tglpesan2 != "") {
            $query2 .= " and date_format(b.tglpesan,'%Y-%m-%d') <= '" . $tglpesan2 . "' ";
        }

        $GetData2 = $this->db->query($query2)->result_array();


        $arraydata = array(
            '' => 'ALL',
            'Y' => 'Accept',
            'R' => 'Reject',
            'H' => 'Hold',
            'C' => 'Cancel'
        );

        //Setting Sheet Excel
        $nama_excel = "Report_PO_" . $arraydata[$typeApprove] . '_' . tanggal_sekarang();

        $nama_sheet = array(
            '0' => 'List PO',
            '1' => 'List Barang'
        );

        $data_all_sheet = array(
            '0' => $GetData,
            '1' => $GetData2
        );

        $setting_xls = array(
            'jumlah_sheet' => 2,
            'nama_excel' => $nama_excel,
            'nama_sheet' => $nama_sheet,
            'data_all_sheet' => $data_all_sheet,
        );

        //print("<pre>".print_r($setting_xls,true)."</pre>"); die;
        $this->m_function->generator_xls($setting_xls);
    }



    function c_fetch_table()
    {

        //$selectperusahaan = @$this->input->post('selectperusahaan');
        //$id_status_approval = @$this->input->post('id_status_approval');
        $typeApprove = @$this->input->post('typeApprove');
        $tglpesan1 = @$this->input->post('tglpesan1');
        $tglpesan2 = @$this->input->post('tglpesan2');

        //$PO_kodedivisi = $this->session->userdata('PO_kodedivisi');



        $query = " SELECT *,ppn_param_date(c.tglpesan) AS ppn_used,get_company(c.nopo) as comp,b.nama_divisi AS nama_divisi
                from " . $this->session->userdata('PO_name_tbl_request') . " a 
                left JOIN masterdivisi b on a.kode_divisi=b.kode_divisi
                INNER JOIN " . $this->session->userdata('PO_name_tbl_header') . " c on a.id_pesan=c.id_pesan 
                left JOIN mastersupplier d on c.kodesupplier=d.kodesupplier 
                where a.kode_divisi <> '' ";

        // if ($selectperusahaan != "") {
        //     $query .= " and get_company(c.nopo)='" . $selectperusahaan . "' ";
        // }

        // if ($id_status_approval != "") {
        //     $query .= " and a.id_status_approval='" . $id_status_approval . "' ";
        // }

        if ($typeApprove != "") {
            $query .= " and a.acc_manager='" . $typeApprove . "' ";
        }

        if ($tglpesan1 != "") {
            $query .= " and date_format(c.tglpesan,'%Y-%m-%d') >= '" . $tglpesan1 . "' ";
        }

        if ($tglpesan2 != "") {
            $query .= " and date_format(c.tglpesan,'%Y-%m-%d') <= '" . $tglpesan2 . "' ";
        }


        $GetData = $this->db->query($query)->result_array();

        echo json_encode($GetData);
    }
}
