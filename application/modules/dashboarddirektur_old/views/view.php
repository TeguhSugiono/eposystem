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

            <!-- MOBILE ONLY -->
            <label class="chk-mobile-only">
                <input type="checkbox" id="chkAll_Mobile">
                <span>Check All</span>
            </label>

            <button class="btn btn-primary btn-sm" onclick="approve()">
                <i class="fa fa-check-square"></i> Approve
            </button>

            <button class="btn btn-danger btn-sm" onclick="reject()">
                <i class="fa fa-times-circle"></i> Reject
            </button>

        </div>
    </div>

    <div class="card-body">


        <div class="datatable-container">

            <div class="datatable-wrapper">
                <table class="table table-bordered table-striped table-hover display nowrap" id="tblrequestpo" style="width: 100%">
                    <thead>
                        <tr>
                            <th>
                                <div style="text-align: center;"><input type='checkbox' id='chkAll' name='chkAll' /></div>
                            </th>
                            <th>No</th>
                            <th>id_request</th>
                            <th>id_pesan</th>
                            <th>No PO</th>
                            <th>Total</th>
                            <th>PPN %</th>
                            <th>Nilai Lain</th>
                            <th>PPN</th>
                            <th>Grand Total</th>
                            <th>User Request</th>
                            <th>Time Request</th>
                            <th>Reason</th>
                            <th>ID Status Approve</th>
                            <th>Request Type</th>
                            <th>Acc Manager</th>
                            <th>Acc Direktur</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

                </table>
            </div>

        </div>


        <div id="notes_po" style="margin-top: 2% !important;">
        </div>


        <div class="datatable-container" style="margin-top: 2% !important;">

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

        </div>

    </div>
</div>

<div id="divmodal"></div>

<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>jquery.dataTables.min.css">
<script src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>jquery-3.7.1.min.js"></script>


<script type="text/javascript">
    var tblrequestpo;
    var tbltransdet;
    let modalStack = [];
    var ArrayIdRequest = [];
    var ArrayNoPO = [];
    var ArrayIdPesan = [];
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
            "columns": [{
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "className": "dt-center",
                    "render": function(data, type, row, meta) {

                        var nopo = escapeHtml(row.nopo);
                        var no = meta.row + 1;
                        var idRequest = row.id_request;

                        //console.log(row.acc_director);

                        if (row.acc_director == "" || row.acc_director == null) {
                            return `
                                <div style="text-align:center;">
                                    <input type="checkbox"
                                        id="idchkdata${no}"
                                        class="chkdata"
                                        data-nopo="${nopo}"
                                        data-idpesan="${row.id_pesan}"
                                        onclick="HandleClick(this.id, '${idRequest}')"
                                        value="${idRequest}">
                                </div>
                            `;

                        } else if (row.acc_director == "Y") {
                            return '<i class="fa fa-thumbs-up"></i>&nbsp;Approve';

                        } else {
                            return '<i class="fa fa-window-close"></i>&nbsp;Reject';

                        }



                    }
                },
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
                    "data": "nopo"
                }




                ,
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
                    "data": "ppn_used" //PPN %
                }

                ,
                {
                    "data": null, //NILAI LAIN

                    "className": "text-right",
                    "render": function(data, type, row) {
                        //console.log(row.id_category);
                        //return formatNumberSeparator(row.nilai_lain);


                        if (type === 'display') {
                            return formatNumberSeparator(FuncHitungPPN(row.id_category, row.ppn_used, row.subtotalharga).nilai_lain);
                        }

                        return FuncHitungPPN(row.id_category, row.ppn_used, row.subtotalharga).nilai_lain;

                    }
                }

                ,
                {
                    "data": null, //PPN

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
                    "data": "status_approval"
                },
                {
                    "data": null,
                    "className": "text-center",
                    "render": function(data, type, row) {

                        if (row.acc_manager == "Y") {
                            return ` <i class="fa fa-check"></i>`;
                        } else if (row.acc_manager == "N") {
                            return '<i class="fa fa-window-close"></i>';
                        }

                        return row.acc_manager;

                    }
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
                $('td:eq(0)', row).attr('data-label', 'Check');
                $('td:eq(1)', row).attr('data-label', 'No');
                $('td:eq(2)', row).attr('data-label', 'No PO');
                $('td:eq(3)', row).attr('data-label', 'Grand Total');
                $('td:eq(4)', row).attr('data-label', 'User Request');
                $('td:eq(5)', row).attr('data-label', 'Time Request');
                $('td:eq(6)', row).attr('data-label', 'Reason');
                $('td:eq(7)', row).attr('data-label', 'Request Type');
                $('td:eq(8)', row).attr('data-label', 'Acc Manager');
                $('td:eq(9)', row).attr('data-label', 'Acc Direktur');
            },



            "pageLength": 10,
            "order": [],
            "ordering": true,

            // "scrollX": window.innerWidth > 768,
            // "scrollY": window.innerWidth > 768 ? "150px" : false,

            "scrollX": isDesktop,
            "scrollY": isDesktop ? "150px" : "390px",

            //"scrollX": true,
            //"scrollY": "100px",
            "scrollCollapse": true,
            "searching": false,
            "bLengthChange": true,
            "pagingType": "full",
            "paging": false,
            "info": false,
            "columnDefs": [{
                    "targets": [0, 1],
                    "orderable": false
                },
                {
                    "targets": [2, 3, 5, 6, 7, 8, 13],
                    "visible": false
                }
            ]
        });

        // tblrequestpo = $('#tblrequestpo').DataTable({
        //     "ajax": {
        //         "url": "<-?php echo site_url('dashboarddirektur/fetch_table'); ?>",
        //         "type": "POST",
        //         "data": function(d) {

        //         },
        //         "dataSrc": ""
        //     },
        //     "columns": [{
        //             "data": null,
        //             "orderable": false,
        //             "searchable": false,
        //             "className": "dt-center",
        //             "render": function(data, type, row, meta) {

        // var nopo = escapeHtml(row.nopo);
        // var no = meta.row + 1;
        // var idRequest = row.id_request;

        // //console.log(row.acc_director);

        // if (row.acc_director == "" || row.acc_director == null) {
        //     return `
        //         <div style="text-align:center;">
        //             <input type="checkbox"
        //                 id="idchkdata${no}"
        //                 class="chkdata"
        //                 data-nopo="${nopo}"
        //                 data-idpesan="${row.id_pesan}"
        //                 onclick="HandleClick(this.id, '${idRequest}')"
        //                 value="${idRequest}">
        //         </div>
        //     `;
        // } else {
        //     return '<i class="fa fa-thumbs-up"></i>&nbsp;Approve';

        // }




        //             }
        //         },
        //         {
        //             "data": null,
        //             "render": function(data, type, row, meta) {
        //                 return meta.row + 1;
        //             }
        //         },
        //         {
        //             "data": "id_request"
        //         },
        //         {
        //             "data": "id_pesan"
        //         },
        //         {
        //             "data": "nopo"
        //         }




        //         ,
        //         {
        //             "data": null, //TOTAL

        //             "className": "text-right",
        //             "render": function(data, type, row) {

        //                 if (type === 'display') {
        //                     return formatNumberSeparator(row.subtotalharga);
        //                 }

        //                 return row.subtotalharga;
        //             }
        //         }

        //         ,
        //         {
        //             "data": "ppn_used" //PPN %
        //         }

        //         ,
        //         {
        //             "data": null, //NILAI LAIN

        //             "className": "text-right",
        //             "render": function(data, type, row) {
        //                 //console.log(row.id_category);
        //                 //return formatNumberSeparator(row.nilai_lain);


        //                 if (type === 'display') {
        //                     return formatNumberSeparator(FuncHitungPPN(row.id_category, row.ppn_used, row.subtotalharga).nilai_lain);
        //                 }

        //                 return FuncHitungPPN(row.id_category, row.ppn_used, row.subtotalharga).nilai_lain;

        //             }
        //         }

        //         ,
        //         {
        //             "data": null, //PPN

        //             "className": "text-right",
        //             "render": function(data, type, row) {
        //                 if (type === 'display') {
        //                     return formatNumberSeparator(FuncHitungPPN(row.id_category, row.ppn_used, row.subtotalharga).ppn);
        //                 }

        //                 return FuncHitungPPN(row.id_category, row.ppn_used, row.subtotalharga).ppn;

        //             }
        //         },







        //         {
        //             "data": null,

        //             "className": "text-right",
        //             "render": function(data, type, row) {

        //                 if (type === 'display') {
        //                     return formatNumberSeparator(row.grandtotal);
        //                 }

        //                 return row.grandtotal;
        //             }
        //         },
        //         {
        //             "data": "user_request"
        //         },
        //         {
        //             "data": null,
        //             "className": "text-center",
        //             "render": function(data, type, row) {

        //                 if (type === 'display' || type === 'filter') {
        //                     return tglIndoJam(row.time_request);
        //                 }

        //                 return row.time_request;
        //             }

        //         },
        //         {
        //             "data": "reason"
        //         },
        //         {
        //             "data": "id_status_approval"
        //         },
        //         {
        //             "data": "status_approval"
        //         },
        //         {
        //             "data": null,
        //             "className": "text-center",
        //             "render": function(data, type, row) {

        //                 if (row.acc_manager == "Y") {
        //                     return `
        //                         <i class="fa fa-check"></i>
        //                         `;
        //                 }

        //                 return row.acc_manager;

        //             }
        //         },
        //         {
        //             "data": null,
        //             "className": "text-center",
        //             "render": function(data, type, row) {

        //                 if (row.acc_director == "Y") {
        //                     return `
        //                         <i class="fa fa-check"></i>
        //                         `;
        //                 }

        //                 return row.acc_director;

        //             }
        //         }


        //     ],
        //     "pageLength": 10,
        //     "order": [],
        //     "ordering": true,
        //     "scrollX": true,
        //     "scrollY": "100px",
        //     "scrollCollapse": true,
        //     "searching": false,
        //     "bLengthChange": true,
        //     "pagingType": "full",
        //     "paging": false,
        //     "info": false,
        //     "columnDefs": [{
        //             "targets": [0, 1],
        //             "orderable": false
        //         },
        //         {
        //             "targets": [2, 3, 5, 6, 7, 8, 13],
        //             "visible": false
        //         }
        //     ]
        // });


        $('#tblrequestpo tbody').on('click', 'input[type="checkbox"]', function(e) {
            e.stopPropagation();
        });


        tbltransdet = $('#tbltransdet').DataTable({
            "ajax": {
                "url": "<?php echo site_url('trans_purchaseorder/fetch_table_detail'); ?>",
                "type": "POST",
                "data": function(d) {
                    d.id_pesan = id_pesan;
                },
                "dataSrc": ""
            },
            "columns": [{
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {

                        return row.itembarang + " " + row.merk + " " + row.type;
                    }
                },
                {
                    "data": "qtymsk",
                    "className": "text-right"
                },
                {
                    "data": null,
                    "className": "text-right",
                    "render": function(data, type, row) {

                        if (type === 'display') {
                            return formatNumberSeparator(row.hargasatuan);
                        }
                        return row.hargasatuan;

                    }
                },
                {
                    "data": null,
                    "className": "text-right",
                    "render": function(data, type, row) {

                        if (type === 'display') {
                            return formatNumberSeparator(row.diskon);
                        }
                        return row.diskon;

                    }
                },
                {
                    "data": null,
                    "className": "text-right",
                    "render": function(data, type, row) {

                        if (type === 'display') {
                            return formatNumberSeparator(row.total);
                        }
                        return row.total;

                    }
                }

            ],

            "createdRow": function(row, data, dataIndex) {
                $('td', row).each(function(index) {
                    var header = $('#tbltransdet thead th').eq(index).text();
                    $(this).attr('data-label', header);
                });
            },

            "pageLength": 10,
            "order": [],
            "ordering": false,
            "scrollX": true,
            "scrollY": "380px",
            "scrollCollapse": true,
            "searching": false,
            "bLengthChange": false,
            "pagingType": "full",
            "paging": false,
            "info": false,
            "drawCallback": function(settings) {
                $('#tbltransdet tbody tr.subtotal-row').remove();




                var subtotalRow = `
                    <tr class="subtotal-row">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><strong>Subtotal</strong></td>
                        <td class="text-right"><strong>${formatNumberSeparator(parseFloat(HeadSubtotal))}</strong></td>
                    </tr>`;

                $('#tbltransdet tbody').append(subtotalRow);

                subtotalRow = `
                    <tr class="subtotal-row">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><strong>Nilai Lain</strong></td>
                        <td class="text-right"><strong>${formatNumberSeparator(parseFloat(HeadNilaiLain))}</strong></td>
                    </tr>`;

                $('#tbltransdet tbody').append(subtotalRow);

                HeadCategory
                var hitungppn = FuncHitungPPN(HeadCategory, HeadPPNUse, HeadSubtotal).ppn;

                subtotalRow = `
                    <tr class="subtotal-row">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><strong>PPN</strong></td>
                        <td class="text-right"><strong>${formatNumberSeparator(parseFloat(hitungppn))}</strong></td>
                    </tr>`;

                $('#tbltransdet tbody').append(subtotalRow);


                subtotalRow = `
                    <tr class="subtotal-row">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><strong>Grand Total</strong></td>
                        <td class="text-right"><strong>${formatNumberSeparator(parseFloat(HeadGrandTotal))}</strong></td>
                    </tr>`;

                $('#tbltransdet tbody').append(subtotalRow);

            }
        });


    });

    function HandleClick(Chk, param) { // param di sini adalah idRequest
        var checkbox = document.getElementById(Chk);
        var chkAll = document.getElementById('chkAll');
        var allCheckboxes = document.querySelectorAll('.chkdata');
        var total = allCheckboxes.length;
        var checkedCount = 0;

        var chkAll_Mobile = document.getElementById('chkAll_Mobile');

        allCheckboxes.forEach(function(cb) {
            if (cb.checked) checkedCount++;
        });

        if (checkedCount === total && total > 0) {
            chkAll.checked = true;
            chkAll_Mobile.checked = true;
        } else {
            chkAll.checked = false;
            chkAll_Mobile.checked = false;
        }

        // Ambil nilai NoPO dari attribute data-nopo
        var nopo = checkbox.getAttribute('data-nopo');
        var idpesan = checkbox.getAttribute('data-idpesan');

        if (checkbox.checked) {
            // Jika belum ada di array, tambahkan
            if (!ArrayIdRequest.includes(param)) {
                ArrayIdRequest.push(param);
                ArrayNoPO.push(nopo);
                ArrayIdPesan.push(idpesan);
            }
        } else {
            // Hapus dari kedua array berdasarkan index yang sama
            var index = ArrayIdRequest.indexOf(param);
            if (index !== -1) {
                ArrayIdRequest.splice(index, 1);
                ArrayNoPO.splice(index, 1);
                ArrayIdPesan.splice(index, 1);
            }
        }

        // console.log("ArrayIdRequest:", ArrayIdRequest);
        // console.log("ArrayNoPO:", ArrayNoPO);
        // console.log("ArrayIdPesan:", ArrayIdPesan);
    }

    document.getElementById('chkAll_Mobile').addEventListener('click', function() {
        var isChecked = this.checked; // true jika dicentang, false jika tidak
        var allCheckboxes = document.querySelectorAll('.chkdata'); // semua checkbox data


        ArrayIdRequest = [];
        ArrayNoPO = [];
        ArrayIdPesan = [];

        allCheckboxes.forEach(function(cb) {
            cb.checked = isChecked; // set checked sesuai chkAll_Mobile

            if (isChecked) {
                var idReq = cb.value; // idRequest
                var noPo = cb.getAttribute('data-nopo'); // NoPO
                var idpesan = cb.getAttribute('data-idpesan');

                ArrayIdRequest.push(idReq);
                ArrayNoPO.push(noPo);
                ArrayIdPesan.push(idpesan);
            }

            // Jalankan HandleClick untuk simulasi klik (update array, UI, dll)
            HandleClick(cb.id, cb.value);
        });
    });

    document.getElementById('chkAll').addEventListener('click', function() {
        var isChecked = this.checked;
        var allCheckboxes = document.querySelectorAll('.chkdata');

        // Kosongkan dulu kedua array
        ArrayIdRequest = [];
        ArrayNoPO = [];
        ArrayIdPesan = [];

        allCheckboxes.forEach(function(cb) {
            cb.checked = isChecked;

            if (isChecked) {
                var idReq = cb.value; // idRequest
                var noPo = cb.getAttribute('data-nopo'); // NoPO
                var idpesan = cb.getAttribute('data-idpesan');

                ArrayIdRequest.push(idReq);
                ArrayNoPO.push(noPo);
                ArrayIdPesan.push(idpesan);
            }

            // Panggil HandleClick biar status checkbox all tetap sinkron
            HandleClick(cb.id, idReq);
        });
    });


    // var dataTerpilih = ArrayIdRequest.map((id, index) => {
    //     return {
    //         idRequest: id,
    //         noPO: ArrayNoPO[index]
    //     };
    // });

    // document.getElementById('chkAll').addEventListener('click', function() {
    //     var isChecked = this.checked;
    //     var allCheckboxes = document.querySelectorAll('.chkdata');

    //     ArrayIdRequest = [];
    //     ArrayNoPO = [];

    //     allCheckboxes.forEach(function(cb) {
    //         cb.checked = isChecked;
    //         HandleClick(cb.id, cb.value);
    //     });
    // });

    // function HandleClick(Chk, param) {
    //     var checkbox = document.getElementById(Chk);
    //     var chkAll = document.getElementById('chkAll');
    //     var allCheckboxes = document.querySelectorAll('.chkdata');
    //     var total = allCheckboxes.length;
    //     var checkedCount = 0;

    //     allCheckboxes.forEach(function(cb) {
    //         if (cb.checked) {
    //             checkedCount++;
    //         }
    //     });

    //     if (checkedCount === total && total > 0) {
    //         chkAll.checked = true;
    //     } else {
    //         chkAll.checked = false;
    //     }

    //     if (checkbox.checked) {
    //         ArrayIdRequest.push(param);
    //     } else {
    //         hapus_isi_array(ArrayIdRequest, param);
    //     }

    // }




    $('#tblrequestpo').on('click', 'tr', function() {
        var data = tblrequestpo.row(this).data();




        if ($(this).hasClass('selected')) {
            id_pesan = "";

            HeadSubtotal = 0;
            HeadNilaiLain = 0;
            HeadNPPN = 'N';
            HeadPPNUse = 0;
            HeadGrandTotal = 0;
            HeadCategory = '';

            $("#notes_po").html("");
            tbltransdet.ajax.reload(null, false);
            $(this).removeClass('selected');
        } else {
            id_pesan = data.id_pesan;

            $.ajax({
                url: "<?php echo site_url('trans_purchaseorder/fetch_note_po'); ?>",
                type: "POST",
                data: {
                    id_pesan: id_pesan
                },
                success: function(res) {
                    $("#notes_po").html(res);
                },
                error: function() {
                    alert("Gagal mengambil desain notes_po");
                }
            });


            HeadSubtotal = data.subtotalharga;
            HeadNilaiLain = data.nilai_lain;
            HeadNPPN = data.ppn;
            HeadPPNUse = data.ppn_used;
            HeadGrandTotal = data.grandtotal;
            HeadCategory = data.id_category;

            tbltransdet.ajax.reload(null, false);
            tblrequestpo.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }

    });

    $('#tbltransdet').on('click', 'tr', function() {


        if ($(this).hasClass('subtotal-row')) {
            return; // abaikan klik
        }

        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {

            tbltransdet.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }

    });

    function approve() {

        if (ArrayIdRequest.length == 0) {
            alert('Belum ada Data Yang dipilih...!!');
            return;
        }

        url = '<?php echo site_url('dashboard/proses_approve_direktur') ?>';
        data = {
            ArrayIdRequest: ArrayIdRequest,
            ArrayNoPO: ArrayNoPO,
            ArrayIdPesan: ArrayIdPesan,
            proses_request: 'direktur'
        };
        pesan = 'function proses_approve gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);

        console.log(dataok);

        if (dataok.msg != 'Ya') {
            alert(dataok.pesan);
            return false;
        }

        alert(dataok.pesan);


        // url1 = '<-?php echo site_url('dashboard/sendEmailAccMgr') ?>';
        // data1 = {
        //     GetPO: dataok.GetPO,
        //     proses_request: 'manager'
        // };
        // pesan1 = 'function proses_approve gagal... 😢';
        // dataok1 = multi_ajax_proses(url1, data1, pesan1);

        // console.log(dataok1);

        tblrequestpo.ajax.reload(null, false);
        document.getElementById('chkAll').checked = false;
        ArrayIdRequest = [];
    }


    function reject() {
        if (ArrayIdRequest.length == 0) {
            alert('Belum ada Data Yang dipilih...!!');
            return;
        }

        url = '<?php echo site_url('dashboard/proses_reject_direktur') ?>';
        data = {
            ArrayIdRequest: ArrayIdRequest,
            proses_request: 'direktur'
        };
        pesan = 'function proses_approve gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);


        if (dataok.msg != 'Ya') {
            alert(dataok.pesan);
            return false;
        }

        alert(dataok.pesan);


        tblrequestpo.ajax.reload(null, false);
        document.getElementById('chkAll').checked = false;
        ArrayIdRequest = [];
    }
</script>