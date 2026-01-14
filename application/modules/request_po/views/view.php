<style>
    .cardwith {
        width: 100% !important;
    }

    @media (max-width: 768px) {
        .cardwith {
            width: 100% !important;
        }
    }

    .table tr.selected td {
        background: #09bc45;
        color: white;
    }
</style>

<div class="card cardwith">
    <div class="card-header">
        <h5 class="card-title">Request PO</h5>
        <button class="btn btn-primary" onclick="addData()">
            <i class="fa fa-plus"></i> Add Request PO
        </button>
    </div>
    <div class="card-body">


        <div class="datatable-container">

            <div class="datatable-wrapper">
                <table class="table table-bordered table-striped table-hover display nowrap" id="tblrequestpo" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>Send PO</th>
                            <th>No</th>
                            <th>id_request</th>
                            <th>id_pesan</th>
                            <th>No PO</th>
                            <th>Grand Total</th>
                            <th>User Request</th>
                            <th>Time Request</th>
                            <th>Reason</th>
                            <th>ID Status Approve</th>
                            <th>Request Type</th>
                            <th>Approve Mgr</th>
                            <th>Time Approve Mgr</th>
                            <th>Name Mgr</th>
                            <th>Approve Direktur</th>
                            <th>Time Approve Direktur</th>
                            <th>Name Direktur</th>
                            <th>Total</th>
                            <th>PPN %</th>
                            <th>Nilai Lain</th>
                            <th>PPN</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

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
    let modalStack = [];

    $(document).ready(function() {
        tblrequestpo = $('#tblrequestpo').DataTable({
            "ajax": {
                "url": "<?php echo site_url('request_po/fetch_table'); ?>",
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
                    "render": function(data, type, row) {

                        var nopo = escapeHtml(row.nopo);

                        return `
                        

                        <a href="javascript:void(0)" onclick="editData('${row.id_request}')" 
                        class="btn btn-sm btn-primary" title="Edit">
                        <i class="fa fa-edit"></i>
                        </a>
                        <button type="button" onclick="hapusData('${row.id_request}', '${nopo}')" 
                        class="btn btn-sm btn-primary" title="Hapus">
                        <i class="fa fa-trash"></i>
                        </button>
                        `;

                        // <button type="button" onclick="printData(this,'${row.id_pesan}', '${nopo}')"
                        // class="btn btn-sm btn-primary" title="Cetak" > <i class="fa fa-print" ></i> </button>
                    }
                },
                {
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "className": "dt-center",
                    "render": function(data, type, row) {

                        var nopo = escapeHtml(row.nopo);



                        if (row.flag_request != 0) {
                            return `
                                <i class="fa fa-check"></i>
                                `;
                        } else {
                            return `
                                <button type="button" onclick="SendData('${row.id_request}', '${nopo}')" 
                                class="btn btn-sm btn-primary" title="Send PO">
                                <i class="fa fa-paper-plane"></i>
                                </button>
                                `;
                        }


                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },

                // {
                //     "data": null,
                //     "orderable": false,
                //     "searchable": false,
                //     "className": "dt-center",
                //     "defaultContent": ""
                // },


                {
                    "data": "id_request"
                },
                {
                    "data": "id_pesan"
                },
                {
                    "data": "nopo"
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
                    //"data": "acc_manager"
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


                        if (type === 'display' || type === 'filter') {
                            return tglIndoJam(row.time_acc_manager);
                        }

                        return row.time_acc_manager;
                    }

                },
                {
                    "data": "acc_name_manager"
                },
                {
                    //"data": "acc_director"
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
                },
                {
                    "data": null,
                    "className": "text-center",
                    "render": function(data, type, row) {

                        if (type === 'display' || type === 'filter') {
                            return tglIndoJam(row.time_acc_director);
                        }

                        return row.time_acc_director;
                    }

                },
                {
                    "data": "acc_name_director"
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
                },
                {
                    "data": null, //PPN

                    "className": "text-right",
                    "render": function(data, type, row) {
                        if (type === 'display') {
                            return formatNumberSeparator(FuncHitungPPN(row.id_category, row.ppn_used, row.subtotalharga).ppn);
                        }

                        return FuncHitungPPN(row.id_category, row.ppn_used, row.subtotalharga).ppn;

                    }
                }

            ],
            "pageLength": 10,
            "order": [],
            "ordering": true,
            "scrollX": true,
            "scrollY": "380px",
            "scrollCollapse": true,
            "searching": true,
            "bLengthChange": true,
            "pagingType": "full",
            "columnDefs": [{
                "targets": [0, 1],
                "orderable": false
            }, {
                "targets": [3, 4, 10],
                "visible": false
            }]
        });

    });


    function printData(el, id_pesan, nopo) {
        var row = $(el).closest('tr');
        var rowData = tblrequestpo.row(row).data();

        // console.log(rowData);
        // console.log(rowData['subtotalharga']);

        var PPN = FuncHitungPPN(rowData['id_category'], rowData['ppn_used'], rowData['subtotalharga']).ppn;
        var grandtotal = (parseFloat(rowData['subtotalharga']) - parseFloat(rowData['discount_total'])) + parseFloat(FuncHitungPPN(rowData['id_category'], rowData['ppn_used'], (rowData['subtotalharga'] - rowData['discount_total'])).ppn);

        var data = [];
        data[0] = id_pesan;
        data[1] = nopo;
        data[2] = rowData['subtotalharga'];
        data[3] = rowData['nilai_lain'];
        data[4] = PPN;
        data[5] = grandtotal;

        var page = "<?php echo base_url(); ?>trans_purchaseorder/cetakPO?data=" + btoa(data);
        window.open(page);
    }


    $('#tblrequestpo').on('click', 'tr', function() {
        var data = tblrequestpo.row(this).data();

        if ($(this).hasClass('selected')) {

            $(this).removeClass('selected');
        } else {

            tblrequestpo.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }

    });

    function addData() {
        $.post('<?= site_url("request_po/add_request") ?>', {}, function(html) {
            $('#divmodal').html(html);

            const modal = document.getElementById('id_modal_add');
            if (modal) {
                modal.classList.add('active');
                modalStack = modalStack || [];
                modalStack.push('id_modal_add');

            }
        });
    }

    function editData(id_request) {

        $.post('<?= site_url("request_po/edit_data") ?>/' + id_request, {}, function(html) {
            $('#divmodal').html(html);

            const modal = document.getElementById('id_modal_edit');
            if (modal) {
                modal.classList.add('active');
                modalStack = modalStack || [];
                modalStack.push('id_modal_edit');

            }
        });
    }

    function SendData(id_request, nopo) {

        var Informasi = "Peringatan Data Yang Sudah Dikirim Untuk Proses Persetujuan " + "\n" +
            "Data No Po Tersebut Sudah Tidak Akan Bisa Di edit " + "\n" +
            "Pastikan Data Yang Akan dikirim Sudah Benar";

        alert(Informasi);


        var jawab = confirm(
            "Minta Approve DATA INI?\n\n" +
            "Kode Request : " + id_request + "\n" +
            "No PO  : " + nopo + "\n\n" +
            "😊 Klik Ok Untuk Meminta Approve!"
        );

        var dataok;

        if (jawab === true) {
            url = '<?php echo site_url('request_po/send_approve') ?>';
            data = {
                id_request: id_request,
                nopo: nopo
            };
            pesan = 'function send_approve data gagal... 😢';
            dataok = multi_ajax_proses(url, data, pesan);

            if (dataok.msg != 'Ya') {
                alert(dataok.pesan);
                return false;
            }

            url = '<?php echo site_url('dashboard/sendEmail') ?>';
            data = {
                id_request: id_request
            };
            pesan = 'function sendEmail gagal... 😢';
            dataok1 = multi_ajax_proses(url, data, pesan);

        } else {
            return false;
        }

        alert(dataok.pesan);
        tblrequestpo.ajax.reload(null, false);
    }

    function hapusData(id_request, nopo) {
        var jawab = confirm(
            "YAKIN MAU HAPUS DATA INI?\n\n" +
            "Kode Request : " + id_request + "\n" +
            "No PO  : " + nopo + "\n\n" +
            "😢 Klik Ok untuk hapus data!"
        );

        var dataok;

        if (jawab === true) {
            url = '<?php echo site_url('request_po/delete_data') ?>';
            data = {
                id_request: id_request
            };
            pesan = 'function delete data gagal... 😢';
            dataok = multi_ajax_proses(url, data, pesan);

            if (dataok.msg != 'Ya') {
                alert(dataok.pesan);
                return false;
            }

        } else {
            return false;
        }

        alert(dataok.pesan);
        tblrequestpo.ajax.reload(null, false);
    }
</script>