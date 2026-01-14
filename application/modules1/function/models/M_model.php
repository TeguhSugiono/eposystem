<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class M_model extends CI_Model {

    function __construct() { // untuk awalan membuat class atau lawan kata nya index
        parent::__construct();
        $this->jobpjt = $this->load->database('jobpjt', TRUE);
        $this->mbatps = $this->load->database('mbatps', TRUE);
        $this->ptmsagate = $this->load->database('ptmsagate', TRUE);
        $this->ptmsadbo = $this->load->database('ptmsadbo', TRUE);
        $this->tpsonline = $this->load->database('tpsonline', TRUE);
        $this->db_tpsonline = $this->load->database('db_tpsonline', TRUE);
        $this->tribltps = $this->load->database('tribltps', TRUE);
    }

    function menu_dinamis($menu_active) {
        $id_menu = $menu_active['id_menu'];
        $link_id_menu = $menu_active['link_id_menu'];

        // echo $id_menu;
        // echo '<br>' ;
        // echo $link_id_menu;
        // die;

        $autogate_userid = $this->session->userdata('autogate_userid');

        $this->jobpjt->select('b.id_menu,b.judul_menu,b.link_route,b.link_menu,b.icon_menu,b.link_id_menu ');
        $this->jobpjt->from('tbl_menu_setting as a');
        $this->jobpjt->join('tbl_menu_app as b', 'a.id_menu=b.id_menu', 'inner');
        $this->jobpjt->join('tbl_menu_group as c', 'a.id_akses=c.id_akses', 'inner');
        $this->jobpjt->join('tbl_user as d', 'c.id_group=d.id_group', 'inner');
        $where = array(
            'd.id_user' => $autogate_userid,
            'b.link_id_menu' => 0,
        );
        $this->jobpjt->where($where);
        $this->jobpjt->order_by('b.id_menu asc');
        $data_menu1 = $this->jobpjt->get()->result_array();

        //echo "</br>" . $this->jobpjt->last_query(); die;

        $menuku = '';
        $no = 1;
        
        $menuku = '<ul class="navbar-nav">';
        foreach ($data_menu1 as $menu1) {
            
            $data_menu2 = $this->cek_sub_menu($autogate_userid, $menu1['id_menu']);
            //echo "</br>" . $this->jobpjt->last_query(); die;

            if ($data_menu2->num_rows() > 0) {

                $menuku .= '<li class="nav-item dropdown">';

                // echo "</br>" . $this->jobpjt->last_query();
                // echo $id_menu;
                // echo '<br>' ;
                // echo $menu1['id_menu'].'=>'.$menu1['judul_menu'];
                // echo '<br>' ;


                if ($id_menu == $menu1['id_menu']) {
                    $menuku .= '<a class="nav-link dropdown-toggle active-page" href="' . $menu1['link_route'] . '" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                } else {
                    // $menuku .= '<a class="nav-link dropdown-toggle" href="' . $menu1['link_route'] . '" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';        

                    
                    // echo $this->jobpjt->last_query();
                    // echo '<br>' ;
                    // echo $id_menu;
                    // echo '<br>' ;
                    // echo $menu1['id_menu'].'=>'.$menu1['judul_menu'];
                    // echo '<br>' ; 

                    $link_id_menux = $this->jobpjt->query("select link_id_menu from tbl_menu_app where id_menu='".$id_menu."' ")->row()->link_id_menu;
                    //echo $link_id_menux;
                    //echo '<br>' ; 
                    //echo $this->jobpjt->last_query();
                    //echo $link_id_menux;
                    //echo '<br>' ; 

                    if ($link_id_menux == $menu1['id_menu']) {
                        $menuku .= '<a class="nav-link dropdown-toggle active-page" href="' . $menu1['link_route'] . '" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    }else{
                        $menuku .= '<a class="nav-link dropdown-toggle" href="' . $menu1['link_route'] . '" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';  
                    }

                }

                $menuku .= $menu1['icon_menu'];
                $menuku .= $menu1['judul_menu'];
                $menuku .= '</a>';

                $menuku .= '<ul class="dropdown-menu" aria-labelledby="formsDropdown">';
                foreach ($data_menu2->result_array() as $menu2) {
                    $data_menu3 = $this->cek_sub_menu($autogate_userid, $menu2['id_menu']);

                    if ($data_menu3->num_rows() > 0) {
                        $menuku .= '<li>';
                        $menuku .= '<a class="dropdown-toggle sub-nav-link" href="' . $menu2['link_route'] . '" id="customDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                        $menuku .= $menu2['judul_menu'];
                        $menuku .= '</a>';
                        $menuku .= '<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown">';
                        foreach ($data_menu3->result_array() as $menu3) {
                            $menuku .= '<li>';

                            if ($link_id_menu == $menu3['id_menu']) {
                                $menuku .= '<a class="dropdown-item active-page" href="' . site_url() . $menu3['link_route'] . '">' . $menu3['judul_menu'] . '</a>';
                            } else {
                                $menuku .= '<a class="dropdown-item" href="' . site_url() . $menu3['link_route'] . '">' . $menu3['judul_menu'] . '</a>';
                            }

                            $menuku .= '</li>';
                        }
                        $menuku .= '</ul>';
                        $menuku .= '</li>';

                        // print_r($data_menu3->num_rows());
                        // die;

                    } else {
                        $menuku .= '<li>';

                        if ($link_id_menu == $menu2['id_menu']) {
                            $menuku .= '<a class="dropdown-item active-page" href="' . site_url() . $menu2['link_route'] . '">' . $menu2['judul_menu'] . '</a>';
                        } else {
                            $menuku .= '<a class="dropdown-item" href="' . site_url() . $menu2['link_route'] . '">' . $menu2['judul_menu'] . '</a>';
                        }

                        $menuku .= '</li>';
                    }
                }
                $menuku .= '</ul>';

                $menuku .= '</li>';
            } else {
                $menuku .= '<li class="nav-item">';

                if ($id_menu == 0 && $link_id_menu == $menu1['id_menu']) {
                    $menuku .= '<a class="nav-link active-page" href="' . site_url() . $menu1['link_route'] . '"> ';
                } else {
                    $menuku .= '<a class="nav-link" href="' . site_url() . $menu1['link_route'] . '"> ';
                }

                $menuku .= $menu1['icon_menu'];
                $menuku .= $menu1['judul_menu'];
                $menuku .= '</a>';
                $menuku .= '</li>';
            }

            $no++;
        }

        //echo $this->uri->segment(2);die;
        // $segment1 = $this->uri->segment(1); 
        // $segment2 = $this->uri->segment(2); 


        // if($segment1.'/'.$segment2 == "setting/report_excel"){
        //     $menuku .= '<li class="nav-item dropdown">
        //             <a class="nav-link dropdown-toggle active-page" href="#" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        //                 <i class="icon-settings nav-icon"></i>
        //                 Setting
        //             </a>
        //             <ul class="dropdown-menu" aria-labelledby="formsDropdown">
        //                 <li>
        //                     <a class="dropdown-item active-page" href="'.site_url('setting/report_excel').'">Export Excel</a>
        //                 </li>
        //             </ul>
        //         </li>';
        // }else{
        //     $menuku .= '<li class="nav-item dropdown">
        //             <a class="nav-link dropdown-toggle" href="#" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        //                 <i class="icon-settings nav-icon"></i>
        //                 Setting
        //             </a>
        //             <ul class="dropdown-menu" aria-labelledby="formsDropdown">
        //                 <li>
        //                     <a class="dropdown-item" href="'.site_url('setting/report_excel').'">Export Excel</a>
        //                 </li>
        //             </ul>
        //         </li>';
        // }


        



        $menuku .= '</ul>';

        //die;

        return $menuku;
    }

    function cek_sub_menu($autogate_userid, $link_id_menu) {

        $this->jobpjt->select('b.id_menu,b.judul_menu,b.link_route,b.link_menu,b.icon_menu,b.link_id_menu');
        $this->jobpjt->from('tbl_menu_setting as a');
        $this->jobpjt->join('tbl_menu_app as b', 'a.id_menu=b.id_menu', 'inner');
        $this->jobpjt->join('tbl_menu_group as c', 'a.id_akses=c.id_akses', 'inner');
        $this->jobpjt->join('tbl_user as d', 'c.id_group=d.id_group', 'inner');
        $where = array(
            'd.id_user' => $autogate_userid,
            'b.link_id_menu' => $link_id_menu,
        );
        $this->jobpjt->where($where);
        $this->jobpjt->order_by('b.id_menu asc');
        //$this->db->limit(1);
        $data_menu2 = $this->jobpjt->get();
        
        //echo "</br>" . $this->jobpjt->last_query(); die;

        return $data_menu2;
    }

    function menu_active() {
        $segment1 = @$this->uri->segment(1);
        $segment2 = @$this->uri->segment(2);
        $segment3 = @$this->uri->segment(3);
        $gabung = '';
        if ($segment1 != '' && $segment2 == '' && $segment3 == '') {
            $gabung = $segment1;
        } else if ($segment1 != '' && $segment2 != '' && $segment3 == '') {
            $gabung = $segment1 . '/' . $segment2;
        } else if ($segment1 != '' && $segment2 != '' && $segment3 != '') {
            $gabung = $segment1 . '/' . $segment2 . '/' . $segment3;
        }

        // $segment1 = str_replace(' ', '_', $segment1) ;
        // $segment2 = str_replace(' ', '_', $segment2) ;
        // $segment3 = str_replace(' ', '_', $segment3) ;
        // $data = array(
        //     'segment1'  => $segment1,
        //     'segment2'  => $segment2,
        //     'segment3'  => $segment3,
        // );

        $this->jobpjt->from('tbl_menu_app');
        $where = array(
            'link_route' => $gabung
        );
        $this->jobpjt->where($where);
        $data = $this->jobpjt->get()->result_array();

        $id_menu = '';
        $link_id_menu = '';
        foreach ($data as $row) {
            $id_menu = $row['link_id_menu'];
            $link_id_menu = $row['id_menu'];
        }

        $data = array(
            'id_menu' => $id_menu,
            'link_id_menu' => $link_id_menu,
        );

        return $data;
    }

    function get_datatables($database, $array_table) {
        $term = $_REQUEST['search']['value'];
        $this->_get_datatables_query($term, $database, $array_table);
        if ($_REQUEST['length'] != -1)
            $this->$database->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->$database->get();
        return $query->result();
    }

    function _get_datatables_query($term = '', $database, $array_table) {
        $select = isset($array_table['select']) ? $array_table['select'] : '';
        $form = isset($array_table['form']) ? $array_table['form'] : '';
        $join = isset($array_table['join']) ? $array_table['join'] : array();
        $where = isset($array_table['where']) ? $array_table['where'] : array();
        $where_like = isset($array_table['where_like']) ? $array_table['where_like'] : array();
        $where_in = isset($array_table['where_in']) ? $array_table['where_in'] : array();
        $where_not_in = isset($array_table['where_not_in']) ? $array_table['where_not_in'] : array();
        $where_term = isset($array_table['where_term']) ? $array_table['where_term'] : array();
        $column_order = isset($array_table['column_order']) ? $array_table['column_order'] : array();
        $group = isset($array_table['group']) ? $array_table['group'] : '';
        $order = isset($array_table['order']) ? $array_table['order'] : array();
        $where_like_and = isset($array_table['where_like_and']) ? $array_table['where_like_and'] : array();

        if ($select != '') {
            $this->$database->select($select);
        }

        if ($form != '') {
            $this->$database->from($form);
        }

        if (count((array) $join) > 0) {
            for ($a = 0; $a < count($join); $a++) {
                $this->$database->join($join[$a][0], $join[$a][1], $join[$a][2]);
            }
        }

        if (count((array) $where) > 0) {
            $this->$database->where($where);
        }


        // contoh penggunaan like
        // $where_like = array(array('field' => 'NO_CONT', 'value' => $NO_CONT));
        if (count((array) $where_like) > 0) {
            if (count((array) $where_like) == 1) {
                // print_r($where_like);
                // die;
                $this->$database->like($where_like[0]['field'], $where_like[0]['value']);
            } else {
                $this->$database->group_start();
                for ($a = 0; $a < count((array) $where_like); $a++) {
                    if ($a == 0) {
                        $this->$database->like($where_like[$a]['field'], $where_like[$a]['value']);
                    } else {
                        $this->$database->or_like($where_like[$a]['field'], $where_like[$a]['value']);
                    }
                }
                $this->$database->group_end();
            }
        }

        //print("<pre>".print_r($where_like_and,true)."</pre>");  die;

        if (count((array) $where_like_and) > 0) {
            for ($a = 0; $a < count((array) $where_like_and); $a++) {
                $this->$database->like($where_like_and[$a]['field'], $where_like_and[$a]['value']);
            }
        }

        if (count((array) $where_in) > 0) {
            //if (count((array) $where_in) == 1) {
            $this->$database->where_in($where_in['field'][0], $where_in['value']);
            // } else {
            //     $this->$database->group_start();
            //     for ($a = 0; $a < count((array) $where_in); $a++) {
            //         if ($a == 0) {
            //             $this->$database->where_in($where_in[$a]['field'], $where_in[$a]['value']);
            //         } else {
            //             $this->$database->or_where_in($where_in[$a]['field'], $where_in[$a]['value']);
            //         }
            //     }
            //     $this->$database->group_end();
            // }
        }

        // print("<pre>".print_r($where_not_in['field'],true)."</pre>");
        // print("<pre>".print_r($where_not_in['value'],true)."</pre>");  die;

        //$where_not_in = array('field' => array('Cont_Number','No_Transaksi'), 'value' => array($cont_number,array('20001'))) ;
        if (count((array) $where_not_in) > 0) {
            for ($a = 0; $a < count((array) $where_not_in['field']); $a++) {
                $this->$database->where_not_in($where_not_in['field'][$a], $where_not_in['value'][$a]);
            }
        }

        // if (count((array) $where_not_in) > 0) {
        //     if (count((array) $where_not_in) == 1) {
        //         $this->$database->where_not_in($where_not_in['field'], $where_not_in[0]['value']);
        //     } else {
        //         $this->$database->group_start();
        //         for ($a = 0; $a < count((array) $where_not_in); $a++) {
        //             if ($a == 0) {
        //                 $this->$database->where_not_in($where_not_in['field'], $where_not_in[$a]['value']);
        //             } else {
        //                 $this->$database->or_where_not_in($where_not_in['field'], $where_not_in[$a]['value']);
        //             }
        //         }
        //         $this->$database->group_end();
        //     }
        // }

        if ($term != "") {
            if (count((array) $where_term) == 1) {
                $this->$database->like($where_term[0], $term);
            } else {

                $this->$database->group_start();

                for ($a = 0; $a < count((array) $where_term); $a++) {
                    if ($a == 0) {
                        $this->$database->like($where_term[$a], $term);
                    } else {
                        $this->$database->or_like($where_term[$a], $term);
                    }
                }

                $this->$database->group_end();
            }
        }

        if ($group != '') {
            $this->$database->group_by($group);
        }

        if (isset($_POST['order'])) {
            $this->$database->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->$database->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered($database, $array_table) {
        $term = $_REQUEST['search']['value'];
        $this->_get_datatables_query($term, $database, $array_table);
        $query = $this->$database->get();
        return $query->num_rows();
    }

    function count_all($database, $array_table) {
        $select = isset($array_table['select']) ? $array_table['select'] : '';
        $form = isset($array_table['form']) ? $array_table['form'] : '';
        $join = isset($array_table['join']) ? $array_table['join'] : array();
        $where = isset($array_table['where']) ? $array_table['where'] : array();
        $where_like = isset($array_table['where_like']) ? $array_table['where_like'] : array();
        $where_in = isset($array_table['where_in']) ? $array_table['where_in'] : array();
        $where_not_in = isset($array_table['where_not_in']) ? $array_table['where_not_in'] : array();
        $where_term = isset($array_table['where_term']) ? $array_table['where_term'] : array();
        $column_order = isset($array_table['column_order']) ? $array_table['column_order'] : array();
        $group = isset($array_table['group']) ? $array_table['group'] : '';
        $order = isset($array_table['order']) ? $array_table['order'] : array();
        $where_like_and = isset($array_table['where_like_and']) ? $array_table['where_like_and'] : array();

        if ($select != '') {
            $this->$database->select($select);
        }

        if ($form != '') {
            $this->$database->from($form);
        }

        if (count((array) $join) > 0) {
            for ($a = 0; $a < count($join); $a++) {
                $this->$database->join($join[$a][0], $join[$a][1], $join[$a][2]);
            }
        }

        if (count((array) $where) > 0) {
            $this->$database->where($where);
        }

        if (count((array) $where_like) > 0) {
            if (count((array) $where_like) == 1) {
                $this->$database->like($where_like[0]['field'], $where_like[0]['value']);
            } else {
                $this->$database->group_start();
                for ($a = 0; $a < count((array) $where_like); $a++) {
                    if ($a == 0) {
                        $this->$database->like($where_like[$a]['field'], $where_like[$a]['value']);
                    } else {
                        $this->$database->or_like($where_like[$a]['field'], $where_like[$a]['value']);
                    }
                }
                $this->$database->group_end();
            }
        }


        if (count((array) $where_like_and) > 0) {
            for ($a = 0; $a < count((array) $where_like_and); $a++) {
                $this->$database->like($where_like_and[$a]['field'], $where_like_and[$a]['value']);
            }
        }
        
        if (count((array) $where_in) > 0) {
            //if (count((array) $where_in) == 1) {
                //$this->$database->where_in($where_in[0]['field'], $where_in[0]['value']);
            $this->$database->where_in($where_in['field'][0], $where_in['value']);
            // } else {
            //     $this->$database->group_start();
            //     for ($a = 0; $a < count((array) $where_in); $a++) {
            //         if ($a == 0) {
            //             $this->$database->where_in($where_in[$a]['field'], $where_in[$a]['value']);
            //         } else {
            //             $this->$database->or_where_in($where_in[$a]['field'], $where_in[$a]['value']);
            //         }
            //     }
            //     $this->$database->group_end();
            // }
        }

        //$where_not_in = array('field' => array('Cont_Number','No_Transaksi'), 'value' => array($cont_number,array('20001'))) ;
        if (count((array) $where_not_in) > 0) {
            for ($a = 0; $a < count((array) $where_not_in['field']); $a++) {
                $this->$database->where_not_in($where_not_in['field'][$a], $where_not_in['value'][$a]);
            }
        }

        // if (count((array) $where_not_in) > 0) {
        //     if (count((array) $where_not_in) == 1) {
        //         $this->$database->where_not_in($where_not_in['field'], $where_not_in[0]['value']);
        //     } else {
        //         $this->$database->group_start();
        //         for ($a = 0; $a < count((array) $where_not_in); $a++) {
        //             if ($a == 0) {
        //                 $this->$database->where_not_in($where_not_in[$a]['field'], $where_not_in[$a]['value']);
        //             } else {
        //                 $this->$database->or_where_not_in($where_not_in[$a]['field'], $where_not_in[$a]['value']);
        //             }
        //         }
        //         $this->$database->group_end();
        //     }
        // }

        if ($group != '') {
            $this->$database->group_by($group);
        }

        return $this->$database->count_all_results();
    }

    function savedata($database, $table, $data) {
        $data = $this->$database->insert($table, $data);
//         echo $this->$database->last_query();
//         die;
        return $data;
    }

    function updatedata($database, $table, $data, $where) {
        $res = $this->$database->update($table, $data, $where);
//         echo $this->$database->last_query();
//         die;
        return $res;
    }

    function select_run_number($database, $table, $max, $where) {
        $this->$database->select("ifnull(MAX($max),0) AS $max");
        $this->$database->from($table);
        if ($where != '') {
            $this->$database->where($where);
        }
        $data = $this->$database->get()->result();
        //        echo $this->$database->last_query(); die;
        foreach ($data as $row) {
            $id = $row->$max;
        }
        return $id;
    }

    function select_max_where($database, $table, $max, $where = array()) {
        $this->$database->select("ifnull(MAX($max),0) AS $max");
        $this->$database->from($table);
        if ($where != '') {
            $this->$database->where($where);
        }
        $data = $this->$database->get()->result();
        //echo $this->$database->last_query(); 
        //die;
        foreach ($data as $row) {
            $id = $row->$max;
        }
        return $id + 1;
    }


    function global_run_number($database,$table,$select,$where = array()){
        $this->$database->select($select);
        $cekdata = $this->$database->get_where($table,$where);

        if($cekdata->num_rows() == 0){
            $data = $where ;
            $data['number'] = 0 ;
            $hasil = $this->savedata($database, $table, $data);
            if ($hasil >= 1) {
            }else{
                return "" ;
                die;
            }
        }

        $this->$database->select($select);
        $getnumber = $this->array_tag_on_index($this->$database->get_where($table,$where)->result_array());
        $this->updatedata($database, $table, array('number' => intval($getnumber[0][0]) + 1), $where) ;
        return intval($getnumber[0][0]) + 1 ;
    }


    function custome_to_array1($data_string) {
        //$data_string = stringku();
        //echo $data_string;
        //echo '<br>';
        $data_string = str_replace('[', '', $data_string);
        $data_string = str_replace(']', '', $data_string);
        $data_string = str_replace('"', '', $data_string);
        $data_string = str_replace("'", "", $data_string);
        $data_string = str_replace('\/', ' ', $data_string);
        //echo $data_string;

        $string_to_array = explode(",", $data_string);
        //print_r($string_to_array);
        return $string_to_array;
    }

    function table_tostring($database, $field_Search = "", $table_name = "", $orderby = "", $where = "", $limit = "") {
        //$this->$database->select($field_Search);
        
        if ($field_Search != "") {
            $this->$database->select($field_Search);
        }
        
        if ($where != "") {
            $this->$database->where($where);
        }

        $this->$database->from($table_name);

        if ($orderby != "") {
            $this->$database->order_by($orderby);
        }


        if ($limit != "") {
            $this->$database->limit($limit);
        }


        $sql = $this->$database->get();
        $jumlahdata = $sql->num_rows();
        $sql = $this->$database->last_query();
        $query_data = $this->$database->query($sql)->result_array();
        $query_tagname = $this->$database->query($sql)->list_fields();

        $data = array();
        if ($jumlahdata > 0) {
            foreach ($query_data as $row) {
                foreach ($query_tagname as $field) {
                    "$" . $field = $field;
                    $tagname = $field;
                    $data[$tagname] = $row[$tagname];
                }
            }
        } else {
            foreach ($query_tagname as $field) {
                "$" . $field = $field;
                $tagname = $field;
                $data[$tagname] = '';
            }
        }



        return $data;
    }

    function bon_bongkar_number(){
        $query = "SELECT bon_bongkar_number FROM t_t_entry_cont_in WHERE rec_id = '0' ORDER BY bon_bongkar_number desc limit 1";
        $data = $this->ptmsagate->query($query);
        if($data->num_rows() > 0){
            foreach ($data->result() as $row) {
                $dpt = $row->bon_bongkar_number;
                $intdpt = (int)$dpt ;
                $intdpt++;
            }
        }else{
            $intdpt = 1 ;
        }
        return str_pad($intdpt, 5, "0", STR_PAD_LEFT) ;
    }


    function bon_muat_number(){
        $query = "SELECT bon_muat_number FROM t_t_entry_cont_out WHERE rec_id = '0' ORDER BY bon_muat_number desc limit 1";
        $data = $this->ptmsagate->query($query);
        if($data->num_rows() > 0){
            foreach ($data->result() as $row) {
                $dpt = $row->bon_muat_number;
                $intdpt = (int)$dpt ;
                $intdpt++;
            }
        }else{
            $intdpt = 1 ;
        }
        return str_pad($intdpt, 5, "0", STR_PAD_LEFT) ;
    }
    
    function eir_r_number(){
        $query = "SELECT r_eir_in as no FROM r_number";
        $data = $this->ptmsagate->query($query);
        $dpt = $data->row()->no;        
        if($dpt == 0 || $dpt == ""){
            $dpt = 1 ;
        }else{
            $intdpt = (int)$dpt ;
            $intdpt++;
        }    
        $intdpt = (int)$intdpt ;        
        return str_pad($intdpt, 5, "0", STR_PAD_LEFT) ;
    }
    
    function update_eir_r_number(){
        $query = "update r_number set r_eir_in = r_eir_in + 1";
        $data = $this->ptmsagate->query($query);
        return $data ;
    }

    function eir_r_number_out(){
        $query = "SELECT r_eir_out as no FROM r_number";
        $data = $this->ptmsagate->query($query);
        $dpt = $data->row()->no;        
        if($dpt == 0 || $dpt == ""){
            $dpt = 1 ;
        }else{
            $intdpt = (int)$dpt ;
            $intdpt++;
        }    
        $intdpt = (int)$intdpt ;        
        return str_pad($intdpt, 5, "0", STR_PAD_LEFT) ;
    }
    
    function update_eir_r_number_out(){
        $query = "update r_number set r_eir_out = r_eir_out + 1";
        $data = $this->ptmsagate->query($query);
        return $data ;
    }
    
    function id_in(){
        $query = "SELECT max(id_cont_in) as id_cont_in FROM t_t_entry_cont_in";
        $data = $this->ptmsagate->query($query);
        if($data->num_rows() > 0){
            foreach ($data->result() as $row) {
                $dpt = $row->id_cont_in;
                $intdpt = (int)$dpt ;
                $intdpt++;
            }
        }else{
            $intdpt = 1 ;
        }
        //return str_pad($intdpt, 5, "0", STR_PAD_LEFT) ;
        return $intdpt ;
    }

    //object yang dilempar result_array()
    function array_one_rows($array_data,$field){
        $array_one_rows = array();
        for($a=0;$a<count($array_data);$a++){
            array_push($array_one_rows,$array_data[$a][$field]);
        }

        //array_push($array_one_rows,count($array_data));

        //print("<pre>".print_r($array_one_rows,true)."</pre>"); 
        //die;
        return $array_one_rows;
    }

    function array_tag_on_index($array_data){
        $array_index = array();
        for($a=0;$a<count($array_data);$a++){

            $array_temp = array();
            $array_rows = array_values($array_data[$a]) ;

            for($b=0;$b<count($array_rows);$b++){
                $array_temp[$b] = $array_rows[$b] ;
            }
            
            array_push($array_index,$array_temp);
        }


        //print("<pre>".print_r($array_index,true)."</pre>"); 
        //die;
        return $array_index;
    }


    function goto_temporary($table_name){
        $query = " insert into test.temporary_table(table_name) values ('".$table_name."') " ;
        $this->ptmsagate->query($query);      
    }

    function drop_temporary(){

        $this->ptmsagate->query('CREATE DATABASE IF NOT EXISTS test');

        $create_table = " CREATE TABLE IF NOT EXISTS test.temporary_table (
          id int(11) NOT NULL AUTO_INCREMENT,
          table_name varchar(200) DEFAULT NULL,
          PRIMARY KEY (id)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1" ;
        $this->ptmsagate->query($create_table);                


        $user = $this->session->userdata('autogate_username') ;

        $this->ptmsagate->like('table_name', $user);
        $this->ptmsagate->group_by('table_name');
        $data = $this->ptmsagate->get('test.temporary_table');
        //echo $this->ptmsagate->last_query();
        //die;
        foreach($data->result() as $row){
            $table_name = $row->table_name;            
            $this->ptmsagate->query('DROP TABLE IF EXISTS test.'.$table_name);
            //echo $this->ptmsagate->last_query();
            //die;
        }

        $query = "delete from  test.temporary_table where table_name like'%".$user."%' " ;
        $this->ptmsagate->query($query);
    }

    function convert_date($date_string){
        $date = DateTime::createFromFormat('Y-m-d', $date_string);
        return $date;
    }

    function generator_xls($setting_xls){

        $jumlah_sheet = $setting_xls['jumlah_sheet'] ;
        $nama_sheet = $setting_xls['nama_sheet'] ;
        $data_all_sheet = $setting_xls['data_all_sheet'] ;
        $nama_excel = $setting_xls['nama_excel'] ; 

        $spreadsheet = new Spreadsheet();
        for($a=0;$a<$jumlah_sheet;$a++){

            $baris = 1 ;
            $kolom = 1 ;

            $spreadsheet->createSheet();

            $spreadsheet->setActiveSheetIndex($a);
            $spreadsheet->getActiveSheet()->setTitle($nama_sheet[$a]);
            $sheet = $spreadsheet->getActiveSheet();

            //JUDUL TABLE
            foreach($setting_xls['data_all_sheet'][$a][0] as $key=>$value){
                $sheet->setCellValueByColumnAndRow($kolom, $baris, $key);
                $kolom++;
            }

            $baris++;
            $nomor = 1;
            //ISI TABLE TABLE
            for($v=0;$v<count($setting_xls['data_all_sheet'][$a]);$v++){
                $array_value = array_values($setting_xls['data_all_sheet'][$a][$v]);

                
                $kolom = 1 ;
                for($b=0;$b<count($array_value);$b++){                    
                    if($b==0 && $array_value[$b] == "nomor"){
                        $sheet->setCellValueByColumnAndRow($kolom, $baris, $nomor);
                    }else{
                        $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[$b]));
                    }
                    $kolom++;
                }
                $baris++;
                $nomor++;
            }

            $kolom = 1 ;
            foreach($setting_xls['data_all_sheet'][0][0] as $key=>$value){
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


    function generator_xls_ob($setting_xls){

        $jumlah_sheet = $setting_xls['jumlah_sheet'] ;
        $nama_sheet = $setting_xls['nama_sheet'] ;
        $data_all_sheet = $setting_xls['data_all_sheet'] ;
        $nama_excel = $setting_xls['nama_excel'] ; 

        $spreadsheet = new Spreadsheet();


        $baris = 1 ;
        $kolom = 1 ;

        $spreadsheet->createSheet();

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle($nama_sheet[0]);
        $sheet = $spreadsheet->getActiveSheet();

        //JUDUL TABLE
        foreach($setting_xls['data_all_sheet'][0][0] as $key=>$value){
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $key);
            $kolom++;
        }

        $baris++;
        $nomor = 1;
        $NO_POS_BC11 = "" ;
        //ISI TABLE TABLE
        for($v=0;$v<count($setting_xls['data_all_sheet'][0]);$v++){
            $array_value = array_values($setting_xls['data_all_sheet'][0][$v]);

            
            if($v == 0){
                $NO_POS_BC11 = trim($array_value[3]);
            }else{

                if($NO_POS_BC11 != trim($array_value[3])){
                    $NO_POS_BC11 = trim($array_value[3]);
                    $baris++;
                }

            }



            $kolom = 1 ;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $nomor);

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[1]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[2]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[3]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[4]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[5]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[6]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[7]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[8]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[9]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[10]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[11]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[12]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[13]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[14]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[15]));


            $baris++;
            $nomor++;



        }

        $kolom = 1 ;
        foreach($setting_xls['data_all_sheet'][0][0] as $key=>$value){
            $sheet->getColumnDimensionByColumn($kolom)->setAutoSize(true);
            $kolom++;
        }


        $baris = 1 ;
        $kolom = 1 ;

        $spreadsheet->createSheet();

        $spreadsheet->setActiveSheetIndex(1);
        $spreadsheet->getActiveSheet()->setTitle($nama_sheet[1]);
        $sheet = $spreadsheet->getActiveSheet();

        foreach($setting_xls['data_all_sheet'][1][0] as $key=>$value){
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $key);
            $kolom++;
        }

        $baris++;
        $nomor = 1;

        for($v=0;$v<count($setting_xls['data_all_sheet'][1]);$v++){
            $array_value = array_values($setting_xls['data_all_sheet'][1][$v]);


            $kolom = 1 ;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, $nomor);

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[1]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[2]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[3]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[4]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[5]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[6]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[7]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[8]));

            $kolom++;
            $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[9]));


            $baris++;
            $nomor++;



        }

        $kolom = 1 ;
        foreach($setting_xls['data_all_sheet'][1][0] as $key=>$value){
            $sheet->getColumnDimensionByColumn($kolom)->setAutoSize(true);
            $kolom++;
        }
        


        $spreadsheet->setActiveSheetIndex(0);        
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $nama_excel . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    function text_border(){
        $text_border = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        return $text_border;
    }
    
    function text_center(){
        $text_center = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        return $text_center;
    }
    
    function text_left(){
        $text_left = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT ,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        return $text_left;
    }
    
    function text_right(){
        $text_right = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT  ,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        return $text_right;
    }
    
    function text_background(){
        $text_background = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '43f2e6'),
            ),
        );
        return $text_background;
    }
    
    function text_bold(){
        $text_bold = array(
            'font' => array(
                'bold' => true,
            ),
        );
        return $text_bold;
    }
    
    

    public function set_run_number_tpsonline($tps,$jeniscontainer,$table){
        //$tps = 'MBA0';
        $year = date('y');
        $month = date('m');

        $where = array(
            'YEAR'      => $year,
            'MONTH'     => $month,
            'NAME'      => $jeniscontainer,
            'KD_TPS'    => $tps
        );

        $this->db_tpsonline->select('NUMBER');
        $this->db_tpsonline->where($where);
        $data = $this->db_tpsonline->get($table);

        //echo $this->db->last_query();

        if($data->num_rows() == 0){
            $table = $table ;
            $data = array(
                'KD_TPS'    => $tps,
                'YEAR'      => $year,
                'MONTH'     => $month,
                'NUMBER'    => 1,
                'NAME'      => $jeniscontainer
            );
            $this->savedata('db_tpsonline', $table, $data)  ;
        }



    }

    function getvalue($database,$select = '', $form = '', $where = array(), $limit = '', $orderby = '') {
        $this->$database->select($select);
        $this->$database->from($form);
        $this->$database->where($where);

        if ($orderby != '') {
            $this->$database->order_by($orderby);
        }

        if ($limit != '') {
            $this->$database->limit($limit);
        }

        $data = $this->$database->get();
        // echo $this->db->last_query();
        // die;
        $dpt = '';
        foreach ($data->result() as $row) {
            $dpt = $row->$select;
        }
        return $dpt;
    }


    function save_response($nama_function, $params_function, $hasil_response) {

        $tgl_request = tanggal_sekarang();

        $data = array(
            'nama_function' => $nama_function,
            'params_function' => $params_function,
            'hasil_response' => $hasil_response,
            'tgl_request' => $tgl_request,
        );
        
        $hasil = $this->savedata('db_tpsonline', 'tbl_xml_webservice', $data) ;
        // $hasil_simpan = '';
        // if ($hasil >= 1) {
        //     $hasil_simpan = 'oke';
        // } else {
        //     $hasil_simpan = 'gagal';
        // }

        // return $hasil_simpan;
    }

    function styleNumber(){
        $styleNumber = [

            'alignment' => [

                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,

                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,

            ],

            'borders' => [

                'top' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

                'right' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

                'bottom' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

                'left' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

            ],

        ];

        return $styleNumber ;
    }

    function styleDate(){
        $styleDate = [

            'alignment' => [

                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,

                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,

            ],
            'borders' => [

                'top' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

                'right' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

                'bottom' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

                'left' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

            ]

        ];
        return $styleDate ;
    }

    function styleHeader(){
        $styleHeader = [

            'font' => [

                'bold' => true,

            ],

            'alignment' => [

                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,

                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,

            ],

            'borders' => [

                'top' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

                'right' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

                'bottom' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

                'left' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

            ],

            'fill' => [

                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,

                'color' => [

                    'rgb' => 'AEF6F7',

                ],

            ],

        ];
        return $styleHeader ;
    }

    function styleText(){
        $styleText = [

            'alignment' => [

                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,

                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,

            ],

            'borders' => [

                'top' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

                'right' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

                'bottom' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

                'left' => [

                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,

                ],

            ],

        ];

        return $styleText ;
    }

    function generator_xls_invtppA($setting_xls){

        

        $jumlah_sheet = $setting_xls['jumlah_sheet'] ;
        $nama_sheet = $setting_xls['nama_sheet'] ;
        $data_all_sheet = $setting_xls['data_all_sheet'] ;
        $nama_excel = $setting_xls['nama_excel'] ; 

        $spreadsheet = new Spreadsheet();
        for($a=0;$a<$jumlah_sheet;$a++){

            $baris = 1 ;
            $kolom = 1 ;

            $spreadsheet->createSheet();

            $spreadsheet->setActiveSheetIndex($a);
            $spreadsheet->getActiveSheet()->setTitle($nama_sheet[$a]);
            $sheet = $spreadsheet->getActiveSheet();

            //JUDUL TABLE
            $kolom_number = array('A','B','C','D','E','F','G','H','I');
            $index = 0 ;
            foreach($setting_xls['data_all_sheet'][$a][0] as $key=>$value){
                $sheet->setCellValueByColumnAndRow($kolom, $baris, $key);
                $sheet->getStyle($kolom_number[$index] . $baris)->applyFromArray($this->styleHeader()) ;
                $kolom++;
                $index++;
            }

            $baris++;
            $nomor = 1;
            //untuk format number
             //yg kepake dari kolom E

            for($v=0;$v<count($setting_xls['data_all_sheet'][$a]);$v++){
                $array_value = array_values($setting_xls['data_all_sheet'][$a][$v]);

                
                $kolom = 1 ;
                for($b=0;$b<count($array_value);$b++){                    
                    if($b==0 && $array_value[$b] == "nomor"){
                        $sheet->setCellValueByColumnAndRow($kolom, $baris, $nomor);
                        $sheet->getStyle($kolom_number[$b] . $baris)->applyFromArray($this->styleText())
                        ->getNumberFormat() ;
                    }elseif($b==4 || $b==5 || $b==6 || $b==7 || $b==8){
                        $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[$b]));
                        $sheet->getStyle($kolom_number[$b] . $baris)->applyFromArray($this->styleNumber())
                        ->getNumberFormat()
                        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                    }else{
                        $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[$b]));
                        $sheet->getStyle($kolom_number[$b] . $baris)->applyFromArray($this->styleText())
                        ->getNumberFormat() ;
                    }
                    $kolom++;
                }
                $baris++;
                $nomor++;
            }

            $kolom = 1 ;
            foreach($setting_xls['data_all_sheet'][0][0] as $key=>$value){
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

    function generator_xls_invtpp($setting_xls){

        

        $jumlah_sheet = $setting_xls['jumlah_sheet'] ;
        $nama_sheet = $setting_xls['nama_sheet'] ;
        $data_all_sheet = $setting_xls['data_all_sheet'] ;
        $nama_excel = $setting_xls['nama_excel'] ; 

        $spreadsheet = new Spreadsheet();
        for($a=0;$a<$jumlah_sheet;$a++){

            $baris = 1 ;
            $kolom = 1 ;

            $spreadsheet->createSheet();

            $spreadsheet->setActiveSheetIndex($a);
            $spreadsheet->getActiveSheet()->setTitle($nama_sheet[$a]);
            $sheet = $spreadsheet->getActiveSheet();

            //JUDUL TABLE
            $kolom_number = array('A','B','C','D','E','F','G','H','I','J');
            $index = 0 ;
            foreach($setting_xls['data_all_sheet'][$a][0] as $key=>$value){
                $sheet->setCellValueByColumnAndRow($kolom, $baris, $key);
                $sheet->getStyle($kolom_number[$index] . $baris)->applyFromArray($this->styleHeader()) ;
                $kolom++;
                $index++;
            }

            $baris++;
            $nomor = 1;
            //untuk format number
             //yg kepake dari kolom E

            for($v=0;$v<count($setting_xls['data_all_sheet'][$a]);$v++){
                $array_value = array_values($setting_xls['data_all_sheet'][$a][$v]);

                
                $kolom = 1 ;
                for($b=0;$b<count($array_value);$b++){                    
                    if($b==0 && $array_value[$b] == "nomor"){
                        $sheet->setCellValueByColumnAndRow($kolom, $baris, $nomor);
                        $sheet->getStyle($kolom_number[$b] . $baris)->applyFromArray($this->styleText())
                        ->getNumberFormat() ;
                    }elseif($b==4 || $b==5 || $b==6 || $b==7 || $b==8 || $b==9){
                        $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[$b]));
                        $sheet->getStyle($kolom_number[$b] . $baris)->applyFromArray($this->styleNumber())
                        ->getNumberFormat()
                        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                    }else{
                        $sheet->setCellValueByColumnAndRow($kolom, $baris, trim($array_value[$b]));
                        $sheet->getStyle($kolom_number[$b] . $baris)->applyFromArray($this->styleText())
                        ->getNumberFormat() ;
                    }
                    $kolom++;
                }
                $baris++;
                $nomor++;
            }

            $kolom = 1 ;
            foreach($setting_xls['data_all_sheet'][0][0] as $key=>$value){
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

    function query_to_tag($query,$database)
    {
        $sql            = $this->$database->query($query);
        $sql            = $this->$database->last_query();
        $query_data     = $this->$database->query($sql)->result_array();
        $query_tagname     = $this->$database->query($sql)->list_fields();

        $data = array();
        foreach ($query_data as $row) {

            foreach ($query_tagname as $field) {
                "$" . $field = $field;
                $tagname = $field;
                $data[$tagname] = $row[$tagname];
            }
        }

        return $data;
    }
}
