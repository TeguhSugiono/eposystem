<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
}
