<style>
    .cardwith {
        width: 100% !important;
    }

    #tblket {
        width: 50%;
    }

    #tblket td {
        padding: 6px 8px;
        vertical-align: top;
    }

    .po-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .po-action-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chk-mobile-only {
        display: none;
    }


    .table-striped>tbody>tr:nth-child(odd)>td {
        background-color: #e5f3f5ff !important;
    }


    .table-hover tbody tr:hover td {
        background-color: #0e7166 !important;
        color: white !important;
    }


    #tblrequestpo tbody tr.selected td {
        background-color: #053c42 !important;
        box-shadow: inset 0 0 0 9999px #053c42 !important;
        color: #ffffff !important;
        font-weight: bold !important;
    }

    /* DETAIL */

    #tbltransdet tbody tr.selected td {
        background-color: #053c42 !important;
        box-shadow: inset 0 0 0 9999px #053c42 !important;
        color: #ffffff !important;
        font-weight: bold !important;
    }

    /* END DETAIL */
</style>


<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>css_approve_manager.css">


<div class="card cardwith">


    <div class="card-header po-header">
        <h5 class="card-title mb-0">List PO</h5>

        <div class="po-action-group">
        </div>
    </div>







    <div class="card-body">


        <div class="datatable-container">

            <div class="datatable-wrapper">
                <table class="table table-bordered table-striped table-hover display nowrap" id="tblrequestpo" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>id_request</th>
                            <th>id_pesan</th>
                            <th>Request Type</th>
                            <th>No PO</th>
                            <th>Dept</th>
                            <th>Total</th>
                            <th>PPN %</th>
                            <th>Nilai Lain</th>
                            <th>PPN</th>
                            <th>Grand Total</th>
                            <th>User Request</th>
                            <th>Time Request</th>
                            <th>Reason</th>
                            <th>ID Status Approve</th>
                            <th>Acc Manager</th>
                            <th>Name Manager</th>
                            <th>Acc Direktur</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

                </table>
            </div>

        </div>

        <!-- <div id="notes_po" style="margin-top: 2% !important;display:none">
        </div>


        <div class="datatable-container" style="margin-top: 2% !important;;display:none">

            <div class="datatable-wrapper">
                <h5 class="card-title" style="text-align:center;">Detail PO</h5>
                <table class="table table-bordered table-striped table-hover display nowrap" id="tbltransdet" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Discount</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div> -->


    </div>
</div>

<div id="divmodal"></div>

<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>jquery.dataTables.min.css">
<script src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>jquery-3.7.1.min.js"></script>





<script type="text/javascript">
    var tblrequestpo;
    //var tbltransdet;
    let modalStack = [];
    var ArrayIdRequest = [];
    var id_pesan = "";
    var HeadSubtotal = 0;
    var HeadNilaiLain = 0;
    var HeadNPPN = 'N';
    var HeadGrandTotal = 0;
    var HeadPPNUse = 0;
    var HeadCategory = '';



    $(document).ready(function() {

        var isDesktop = window.innerWidth > 768;


        tblrequestpo = $('#tblrequestpo').DataTable({
            "ajax": {
                "url": "<?php echo site_url('dashboarddirektur/fetch_table'); ?>",
                "type": "POST",
                "data": function(d) {

                },
                "dataSrc": ""
            },
            "columns": [

                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },



                {
                    "data": "id_request"
                },
                {
                    "data": "id_pesan"
                },
                {
                    "data": "status_approval"
                },
                {
                    "data": "nopo"
                },
                {
                    "data": "dept"
                },
                {
                    "data": null, //TOTAL

                    "className": "text-right",
                    "render": function(data, type, row) {

                        if (type === 'display') {
                            return formatNumberSeparator(row.subtotalharga);
                        }

                        return row.subtotalharga;
                    }
                }

                ,
                {
                    "data": "ppn_used"
                }

                ,
                {
                    "data": null,

                    "className": "text-right",
                    "render": function(data, type, row) {


                        if (type === 'display') {
                            return formatNumberSeparator(FuncHitungPPN(row.id_category, row.ppn_used, row.subtotalharga).nilai_lain);
                        }

                        return FuncHitungPPN(row.id_category, row.ppn_used, row.subtotalharga).nilai_lain;

                    }
                }

                ,
                {
                    "data": null,

                    "className": "text-right",
                    "render": function(data, type, row) {
                        if (type === 'display') {
                            return formatNumberSeparator(FuncHitungPPN(row.id_category, row.ppn_used, row.subtotalharga).ppn);
                        }

                        return FuncHitungPPN(row.id_category, row.ppn_used, row.subtotalharga).ppn;

                    }
                },





                {
                    "data": null,

                    "className": "text-right",
                    "render": function(data, type, row) {

                        if (type === 'display') {
                            return formatNumberSeparator(row.grandtotal);
                        }

                        return row.grandtotal;
                    }
                },
                {
                    "data": "user_request"
                },
                {
                    "data": null,
                    "className": "text-center",
                    "render": function(data, type, row) {

                        if (type === 'display' || type === 'filter') {
                            return tglIndoJam(row.time_request);
                        }

                        return row.time_request;
                    }

                },
                {
                    "data": "reason"
                },
                {
                    "data": "id_status_approval"
                },

                {
                    "data": null,
                    "className": "text-center",
                    "render": function(data, type, row) {

                        if (row.acc_manager == "Y") {
                            return ` <i class="fa fa-check" title="Accept"></i>`;
                        } else if (row.acc_manager == "R") {
                            return '<i class="fa fa-window-close" title="Reject"></i>';
                        } else if (row.acc_manager == "H") {
                            return '<i class="fa fa-hand-paper" title="Hold"></i>';
                        }

                        return row.acc_manager;

                    }
                },
                {
                    "data": "acc_name_manager"
                },
                {
                    "data": null,
                    "className": "text-center",
                    "render": function(data, type, row) {

                        if (row.acc_director == "Y") {
                            return ` <i class="fa fa-check"></i>`;
                        } else if (row.acc_director == "N") {
                            return '<i class="fa fa-window-close"></i>';
                        }

                        return row.acc_director;

                    }
                }


            ],

            "createdRow": function(row, data, dataIndex) {
                $('td:eq(0)', row).attr('data-label', 'No');
                $('td:eq(1)', row).attr('data-label', 'Request Type');
                $('td:eq(2)', row).attr('data-label', 'No PO');
                $('td:eq(3)', row).attr('data-label', 'Dept');
                $('td:eq(4)', row).attr('data-label', 'Grand Total');
                $('td:eq(5)', row).attr('data-label', 'User Request');
                $('td:eq(6)', row).attr('data-label', 'Time Request');
                $('td:eq(7)', row).attr('data-label', 'Reason');
                $('td:eq(8)', row).attr('data-label', 'Acc Manager');
                $('td:eq(9)', row).attr('data-label', 'Acc Direktur');
            },






            "pageLength": 10,
            "order": [],
            "ordering": true,

            // "scrollX": window.innerWidth > 768,
            // "scrollY": window.innerWidth > 768 ? "150px" : false,

            "scrollX": isDesktop,
            "scrollY": isDesktop ? "500px" : "390px",

            //"scrollX": true,
            //"scrollY": "100px",
            "scrollCollapse": true,
            "searching": false,
            "bLengthChange": true,
            "pagingType": "full",
            "paging": false,
            "info": false,
            "columnDefs": [{
                    "targets": [0],
                    "orderable": false
                },
                {
                    "targets": [1, 2, 6, 7, 8, 9, 14],
                    "visible": false
                }
            ]



        });


    });

    let pressTimer;
    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);


    // DESKTOP: double click
    if (!isMobile) {
        $('#tblrequestpo').on('dblclick', 'tr', function() {
            selectRow(this);
            handleRowAction(this);
        });
    }

    // MOBILE: tap
    $('#tblrequestpo').on('click', 'tr', function() {
        if (isMobile) {
            selectRow(this);
            handleRowAction(this);
        }
    });

    // MOBILE: long press
    $('#tblrequestpo').on('touchstart', 'tr', function() {
        const row = this;
        pressTimer = setTimeout(function() {
            selectRow(row);
            handleRowAction(row);
        }, 600);
    }).on('touchend touchmove', function() {
        clearTimeout(pressTimer);
    });

    // Fungsi select row
    function selectRow(row) {
        tblrequestpo.$('tr.selected').removeClass('selected');
        $(row).addClass('selected');
    }

    // Fungsi utama aksi
    function handleRowAction(row) {
        const rowData = tblrequestpo.row(row).data();
        HeadSubtotal = rowData.subtotalharga;
        HeadNilaiLain = rowData.nilai_lain;
        HeadNPPN = rowData.ppn;
        HeadPPNUse = rowData.ppn_used;
        HeadGrandTotal = rowData.grandtotal;
        HeadCategory = rowData.id_category;

        $.post('<?= site_url("dashboarddirektur/proses_po") ?>', {
            post_id_pesan: rowData.id_pesan,
            post_id_request: rowData.id_request,
            // post_HeadSubtotal: HeadSubtotal,
            // post_HeadNilaiLain: HeadNilaiLain,
            // post_HeadNPPN: HeadNPPN,
            // post_HeadPPNUse: HeadPPNUse,
            // post_HeadGrandTotal: HeadGrandTotal,
            // post_HeadCategory: HeadCategory
        }, function(html) {
            $('#divmodal').html(html);

            const modal = document.getElementById('id_modal_add');
            if (modal) {
                modal.classList.add('active');
                modalStack = modalStack || [];
                modalStack.push('id_modal_add');

            }
        });
    }
</script>