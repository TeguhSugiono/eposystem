<?php

defined('BASEPATH') or exit('No direct script access allowed');


$route['default_controller'] = 'dashboard/c_dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;




$route['login'] = 'login/c_login';
$route['auth'] = 'login/c_login/auth';
$route['logout'] = 'login/c_login/logout';

$route['dashboard'] = 'dashboard/c_dashboard';
$route['dashboard/sendEmail'] = 'dashboard/c_dashboard/c_sendEmail';
$route['CreateLinkManager'] = 'dashboard/c_dashboard/CreateLinkManager';
$route['CreateLinkDirektur'] = 'dashboard/c_dashboard/CreateLinkDirektur';
$route['CreatePasswordHash'] = 'dashboard/c_dashboard/CreatePasswordHash';
// $route['dashboard/sendEmailAccMgr'] = 'dashboard/c_dashboard/c_sendEmailAccMgr';
// $route['dashboard/proses_approve_manager'] = 'dashboard/c_dashboard/c_proses_approve_manager';
// $route['dashboard/proses_approve_direktur'] = 'dashboard/c_dashboard/c_proses_approve_direktur';
// $route['dashboard/proses_reject_manager'] = 'dashboard/c_dashboard/c_proses_reject_manager';
// $route['dashboard/proses_reject_direktur'] = 'dashboard/c_dashboard/c_proses_reject_direktur';





$route['mst_customer'] = 'mst_customer/c_mst_customer';
$route['mst_customer/fetch_table'] = 'mst_customer/c_mst_customer/c_fetch_table';


$route['mst_barang'] = 'mst_barang/c_mst_barang';
$route['mst_barang/fetch_table'] = 'mst_barang/c_mst_barang/c_fetch_table';
$route['mst_barang/add_data'] = 'mst_barang/c_mst_barang/c_add_data';
$route['mst_barang/save_data'] = 'mst_barang/c_mst_barang/c_save_data';
$route['mst_barang/edit_data/(:any)'] = 'mst_barang/c_mst_barang/c_edit_data/$1';
$route['mst_barang/update_data'] = 'mst_barang/c_mst_barang/c_update_data';
$route['mst_barang/delete_data'] = 'mst_barang/c_mst_barang/c_delete_data';


// $route['mst_supplier'] = 'mst_supplier/c_mst_supplier';
// $route['mst_supplier/fetch_table'] = 'mst_supplier/c_mst_supplier/c_fetch_table';
// $route['mst_supplier/add_data'] = 'mst_supplier/c_mst_supplier/c_add_data';
// $route['mst_supplier/save_data'] = 'mst_supplier/c_mst_supplier/c_save_data';
// $route['mst_supplier/edit_data/(:any)'] = 'mst_supplier/c_mst_supplier/c_edit_data/$1';
// $route['mst_supplier/update_data'] = 'mst_supplier/c_mst_supplier/c_update_data';
// $route['mst_supplier/delete_data'] = 'mst_supplier/c_mst_supplier/c_delete_data';

$route['mst_supplier_po'] = 'mst_supplier_po/c_mst_supplier_po';
$route['mst_supplier_po/fetch_table'] = 'mst_supplier_po/c_mst_supplier_po/c_fetch_table';
$route['mst_supplier_po/add_data'] = 'mst_supplier_po/c_mst_supplier_po/c_add_data';
$route['mst_supplier_po/save_data'] = 'mst_supplier_po/c_mst_supplier_po/c_save_data';
$route['mst_supplier_po/edit_data/(:any)'] = 'mst_supplier_po/c_mst_supplier_po/c_edit_data/$1';
$route['mst_supplier_po/update_data'] = 'mst_supplier_po/c_mst_supplier_po/c_update_data';
$route['mst_supplier_po/delete_data'] = 'mst_supplier_po/c_mst_supplier_po/c_delete_data';

$route['mst_customer'] = 'mst_customer/c_mst_customer';
$route['mst_customer/fetch_table'] = 'mst_customer/c_mst_customer/c_fetch_table';

$route['mst_satuan'] = 'mst_satuan/c_mst_satuan';
$route['mst_satuan/fetch_table'] = 'mst_satuan/c_mst_satuan/c_fetch_table';
$route['mst_satuan/add_data'] = 'mst_satuan/c_mst_satuan/c_add_data';
$route['mst_satuan/save_data'] = 'mst_satuan/c_mst_satuan/c_save_data';
$route['mst_satuan/edit_data/(:any)'] = 'mst_satuan/c_mst_satuan/c_edit_data/$1';
$route['mst_satuan/update_data'] = 'mst_satuan/c_mst_satuan/c_update_data';
$route['mst_satuan/delete_data'] = 'mst_satuan/c_mst_satuan/c_delete_data';

$route['mst_category'] = 'mst_category/c_mst_category';
$route['mst_category/fetch_table'] = 'mst_category/c_mst_category/c_fetch_table';
$route['mst_category/add_data'] = 'mst_category/c_mst_category/c_add_data';
$route['mst_category/save_data'] = 'mst_category/c_mst_category/c_save_data';
$route['mst_category/edit_data/(:any)'] = 'mst_category/c_mst_category/c_edit_data/$1';
$route['mst_category/update_data'] = 'mst_category/c_mst_category/c_update_data';
$route['mst_category/delete_data'] = 'mst_category/c_mst_category/c_delete_data';


$route['mst_proyek'] = 'mst_proyek/c_mst_proyek';
$route['mst_proyek/fetch_table'] = 'mst_proyek/c_mst_proyek/c_fetch_table';
$route['mst_proyek/add_data'] = 'mst_proyek/c_mst_proyek/c_add_data';
$route['mst_proyek/save_data'] = 'mst_proyek/c_mst_proyek/c_save_data';
$route['mst_proyek/edit_data/(:any)'] = 'mst_proyek/c_mst_proyek/c_edit_data/$1';
$route['mst_proyek/update_data'] = 'mst_proyek/c_mst_proyek/c_update_data';
$route['mst_proyek/delete_data'] = 'mst_proyek/c_mst_proyek/c_delete_data';


$route['mst_bank'] = 'mst_bank/c_mst_bank';
$route['mst_bank/fetch_table'] = 'mst_bank/c_mst_bank/c_fetch_table';
$route['mst_bank/add_data'] = 'mst_bank/c_mst_bank/c_add_data';
$route['mst_bank/save_data'] = 'mst_bank/c_mst_bank/c_save_data';
//$route['mst_bank/edit_data/(:any)'] = 'mst_bank/c_mst_bank/c_edit_data/$1';
$route['mst_bank/edit_data/(:any)/(:any)/(:any)'] = 'mst_bank/c_mst_bank/c_edit_data/$1/$2/$3';
$route['mst_bank/update_data'] = 'mst_bank/c_mst_bank/c_update_data';
$route['mst_bank/delete_data'] = 'mst_bank/c_mst_bank/c_delete_data';


$route['trans_purchaseorder'] = 'trans_purchaseorder/c_trans_purchaseorder';
$route['trans_purchaseorder/fetch_table'] = 'trans_purchaseorder/c_trans_purchaseorder/c_fetch_table';
$route['trans_purchaseorder/getnamesupplier'] = 'trans_purchaseorder/c_trans_purchaseorder/c_getnamesupplier';
$route['trans_purchaseorder/fetch_table_detail'] = 'trans_purchaseorder/c_trans_purchaseorder/c_fetch_table_detail';
$route['trans_purchaseorder/fetch_detail_keterangan'] = 'trans_purchaseorder/c_trans_purchaseorder/c_fetch_detail_keterangan';
$route['trans_purchaseorder/add_data'] = 'trans_purchaseorder/c_trans_purchaseorder/c_add_data';
$route['trans_purchaseorder/get_po_number'] = 'trans_purchaseorder/c_trans_purchaseorder/c_get_po_number';
$route['trans_purchaseorder/get_po_supplier'] = 'trans_purchaseorder/c_trans_purchaseorder/c_get_po_supplier';
$route['trans_purchaseorder/get_po_bank'] = 'trans_purchaseorder/c_trans_purchaseorder/c_get_po_bank';
$route['trans_purchaseorder/get_po_rek'] = 'trans_purchaseorder/c_trans_purchaseorder/c_get_po_rek';
$route['trans_purchaseorder/get_po_ppn'] = 'trans_purchaseorder/c_trans_purchaseorder/c_get_po_ppn';
$route['trans_purchaseorder/get_po_category'] = 'trans_purchaseorder/c_trans_purchaseorder/c_get_po_category';
$route['trans_purchaseorder/load_search_barang'] = 'trans_purchaseorder/c_trans_purchaseorder/c_load_search_barang';
$route['trans_purchaseorder/save_data'] = 'trans_purchaseorder/c_trans_purchaseorder/c_save_data';
$route['trans_purchaseorder/edit_data/(:any)'] = 'trans_purchaseorder/c_trans_purchaseorder/c_edit_data/$1';
$route['trans_purchaseorder/update_data'] = 'trans_purchaseorder/c_trans_purchaseorder/c_update_data';
$route['trans_purchaseorder/delete_data'] = 'trans_purchaseorder/c_trans_purchaseorder/c_delete_data';
$route['trans_purchaseorder/cetakPO'] = 'trans_purchaseorder/c_trans_purchaseorder/c_cetakPO';
$route['trans_purchaseorder/fetch_note_po'] = 'trans_purchaseorder/c_trans_purchaseorder/c_fetch_note_po';


$route['request_po'] = 'request_po/c_request_po';
$route['request_po/fetch_table'] = 'request_po/c_request_po/c_fetch_table';
$route['request_po/add_request'] = 'request_po/c_request_po/c_add_request';
$route['request_po/save_data'] = 'request_po/c_request_po/c_save_data';
$route['request_po/edit_data/(:any)'] = 'request_po/c_request_po/c_edit_data/$1';
$route['request_po/update_data'] = 'request_po/c_request_po/c_update_data';
$route['request_po/send_approve'] = 'request_po/c_request_po/c_send_approve';
$route['request_po/delete_data'] = 'request_po/c_request_po/c_delete_data';
$route['request_po/request_batal'] = 'request_po/c_request_po/c_request_batal';
$route['request_po/refresh_cbo_po'] = 'request_po/c_request_po/c_refresh_cbo_po';
$route['request_po/get_status_acc_manager'] = 'request_po/c_request_po/c_get_status_acc_manager';


//$route['request_po/test_wa'] = 'request_po/c_request_po/c_test_wa';



$route['trans_receipt'] = 'trans_receipt/c_trans_receipt';
$route['trans_receipt/fetch_table'] = 'trans_receipt/c_trans_receipt/c_fetch_table';
$route['trans_receipt/fetch_table_detail'] = 'trans_receipt/c_trans_receipt/c_fetch_table_detail';
$route['trans_receipt/edit_data/(:any)'] = 'trans_receipt/c_trans_receipt/c_edit_data/$1';




$route['dashboardmanager/authentikasi/(:any)'] = 'dashboardmanager/c_dashboardmanager/c_authentikasi/$1';
$route['dashboardmanager'] = 'dashboardmanager/c_dashboardmanager';
$route['dashboardmanager/fetch_table'] = 'dashboardmanager/c_dashboardmanager/c_fetch_table';
$route['dashboardmanager/proses_po'] = 'dashboardmanager/c_dashboardmanager/c_proses_po';
$route['dashboardmanager/proses_hold_manager'] = 'dashboardmanager/c_dashboardmanager/c_proses_hold_manager';
$route['dashboardmanager/proses_reject_manager'] = 'dashboardmanager/c_dashboardmanager/c_proses_reject_manager';
$route['dashboardmanager/proses_accept_manager'] = 'dashboardmanager/c_dashboardmanager/c_proses_accept_manager';
$route['dashboardmanager/proses_accept_manager'] = 'dashboardmanager/c_dashboardmanager/c_proses_accept_manager';
$route['dashboardmanager/send_approve'] = 'dashboardmanager/c_dashboardmanager/c_send_approve';
$route['dashboardmanager/send_back_notifikasi'] = 'dashboardmanager/c_dashboardmanager/c_send_back_notifikasi';
$route['dashboardmanager/fetch_table_detail'] = 'dashboardmanager/c_dashboardmanager/c_fetch_table_detail';



$route['dashboarddirektur/authentikasi/(:any)'] = 'dashboarddirektur/c_dashboarddirektur/c_authentikasi/$1';
$route['dashboarddirektur'] = 'dashboarddirektur/c_dashboarddirektur';
$route['dashboarddirektur/fetch_table'] = 'dashboarddirektur/c_dashboarddirektur/c_fetch_table';
$route['dashboarddirektur/proses_po'] = 'dashboarddirektur/c_dashboarddirektur/c_proses_po';
$route['dashboarddirektur/proses_hold_direktur'] = 'dashboarddirektur/c_dashboarddirektur/c_proses_hold_direktur';
$route['dashboarddirektur/proses_accept_direktur'] = 'dashboarddirektur/c_dashboarddirektur/c_proses_accept_direktur';
$route['dashboarddirektur/send_back_notifikasi'] = 'dashboarddirektur/c_dashboarddirektur/c_send_back_notifikasi';
$route['dashboarddirektur/proses_reject_direktur'] = 'dashboarddirektur/c_dashboarddirektur/c_proses_reject_direktur';
$route['dashboarddirektur/send_back_notifikasi_reject'] = 'dashboarddirektur/c_dashboarddirektur/c_send_back_notifikasi_reject';
$route['dashboarddirektur/proses_cancel_direktur'] = 'dashboarddirektur/c_dashboarddirektur/c_proses_cancel_direktur';



$route['report_direktur'] = 'report_direktur/c_report_direktur';
$route['report_direktur/getnamesupplier'] = 'report_direktur/c_report_direktur/c_getnamesupplier';
$route['report_direktur/fetch_table'] = 'report_direktur/c_report_direktur/c_fetch_table';
$route['report_direktur/export'] = 'report_direktur/c_report_direktur/c_export';


$route['report_manager'] = 'report_manager/c_report_manager';
$route['report_manager/getnamesupplier'] = 'report_manager/c_report_manager/c_getnamesupplier';
$route['report_manager/fetch_table'] = 'report_manager/c_report_manager/c_fetch_table';
$route['report_manager/export'] = 'report_manager/c_report_manager/c_export';
