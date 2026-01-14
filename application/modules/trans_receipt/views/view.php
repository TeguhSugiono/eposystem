<style>
    /* @media (max-width: 768px) {


        #tbltranshead thead,
        .dataTables_scrollHead {
            display: none !important;
        }


        #tbltranshead,
        #tbltranshead tbody,
        #tbltranshead tr,
        #tbltranshead td {
            display: block;
            width: 100%;
        }

        #tbltranshead tr {
            margin-bottom: 12px;
            border: 1px solid #ddd;
            background: #fff;
            padding: 8px;
        }

        #tbltranshead td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 8px;
            border: none;
            border-bottom: 1px solid #eee;
            text-align: left !important;
        }

        #tbltranshead td::before {
            content: attr(data-label);
            font-weight: 600;
            width: 45%;
            color: #444;
        }

        #tbltranshead td:last-child {
            border-bottom: none;
        }
    }


    @media (max-width: 768px) {

        td[data-label="Aksi"] {
            justify-content: center;
            gap: 6px;
        }

    } */
</style>


<style>
    /* .MarginBtm {
        margin-bottom: -10px !important;
    }

    @media (max-width: 768px) {
        .MarginBtm {
            margin-bottom: 8px !important;
        }
    } */
</style>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Terima Barang</h5>
        <!-- <button class="btn btn-primary" onclick="addData()">
            <i class="fa fa-plus"></i> Add Purchase Order
        </button> -->
    </div>

    <div class="card-body">

        <div class="datatable-container">

            <div class="datatable-wrapper">

                <table class="table table-bordered table-striped table-hover display nowrap" id="tbltranshead" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>No</th>
                            <th>ID</th>
                            <th>No PO</th>
                            <th>Divisi</th>
                            <th>Tgl pesan</th>
                            <th>Supplier</th>
                            <th>Total</th>
                            <th>PPN %</th>
                            <th>Nilai Lain</th>
                            <th>PPN</th>
                            <th>Grand Total</th>
                            <th>No Penawaran</th>
                            <th>No MR</th>
                            <th>Keterangan</th>
                            <th>Company</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

<div class="card-container">

    <!-- CARD KIRI -->
    <div class="card card-left" data-width="100%">
        <div class="card-header">
            <h5 class="card-title">Detail Barang</h5>
        </div>
        <div class="card-body">
            <div class="datatable-container">
                <div class="datatable-wrapper">
                    <table class="table table-bordered table-striped table-hover display nowrap" id="tbltransdet" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Serial Number</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- CARD KANAN -->
    <!-- <div class="card card-right" data-width="45%">
        <div class="card-header">
            <h5 class="card-title">Keterangan Barang</h5>
        </div>
        <div class="card-body">
            <div style="text-align:center; font-weight:700;margin-bottom:5px;font-size:24px" id="div_nopo"></div>
            <div style="text-align:center; font-weight:700;margin-bottom:20px;font-size:24px" id="div_grandtotal"></div>
            <div id="content_text_area"></div>

        </div>
    </div> -->

</div>




<div id="divmodal"></div>
<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>jquery.dataTables.min.css">
<script src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>jquery-3.7.1.min.js"></script>

<script type="text/javascript">
    var tbltranshead;
    var tbltransdet;
    let modalStack = [];
    var arraysupplier;
    var id_pesan = "";


    $(document).ready(function() {

        //console.log(formatNumberSeparator(1000000000.23));
        //console.log(UnFormatNumber(formatNumberSeparator(1000000000.23)));

        url = '<?php echo site_url('trans_purchaseorder/getnamesupplier') ?>';

        data = {
            kodesupplier: ''
        }

        ;
        pesan = 'function save data gagal... 😢';
        arraysupplier = multi_ajax_proses(url, data, pesan);


        tbltranshead = $('#tbltranshead').DataTable({
            "ajax": {

                "url": "<?php echo site_url('trans_receipt/fetch_table'); ?>",
                "type": "POST",
                "data": function(d) {}

                    ,
                "dataSrc": ""
            }

            ,
            "columns": [{

                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "className": "dt-center",
                    "render": function(data, type, row) {

                        var nopo = escapeHtml(row.nopo);

                        return ` 
                        <button type="button" onclick="printTandaTerima(this,'${row.id_pesan}', '${nopo}')"
                        class="btn btn-sm btn-primary" title="Cetak" > <i class="fa fa-print" ></i> </button>
                        <a href="javascript:void(0)" onclick="editData('${row.id_pesan}')"
                        class="btn btn-sm btn-primary" title="Edit" > <i class="fa fa-edit" ></i> </a> `;
                    }
                },

                // ,
                // {

                //     "data": null,
                //     "className": "text-left",
                //     "render": function(data, type, row, meta) {
                //         return meta.row + 1;
                //     }
                // }

                {
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "className": "dt-center",
                    "defaultContent": ""
                },


                {
                    "data": "id_pesan",
                    "className": "text-left"
                }

                ,
                {
                    "data": "nopo",
                    "className": "text-left"
                }

                ,
                {
                    "data": "nama_divisi",
                    "className": "text-left"
                }

                ,
                {

                    "data": null,
                    "className": "text-center",
                    "render": function(data, type, row) {

                        //return tglIndo(row.tglpesan);
                        if (type === 'display' || type === 'filter') {
                            return tglIndo(row.tglpesan); // ← tampilan cantik: 31 Jan 2025
                        }

                        // Kalau lagi sorting → kembalikan nilai asli biar urut bener
                        return row.tglpesan;
                    }
                }

                ,
                {

                    "data": null,
                    "className": "text-left",
                    "render": function(data, type, row) {
                        if (row.namasupplier && row.namasupplier !== '') {
                            return row.namasupplier;
                        } else {
                            var supplierName = 'Tidak Ditemukan';

                            if (row.kodesupplier && arraysupplier && arraysupplier.length > 0) {
                                var found = arraysupplier.find(function(sup) {
                                    return sup.suppl_code === row.kodesupplier;
                                });

                                if (found && found.suppl_name) {
                                    supplierName = found.suppl_name;
                                }
                            }

                            return supplierName;
                        }
                    }
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
                }

                ,
                {
                    "data": null, //GRAND TOTAL

                    "className": "text-right",
                    "render": function(data, type, row) {
                        //console.log(row.id_category);
                        //return formatNumberSeparator(row.nilai_lain);

                        // console.log(row.nopo);
                        // console.log(row.subtotalharga);
                        // console.log(row.discount_total);
                        // console.log(row.id_category);
                        // console.log(row.ppn_used);

                        // if (parseFloat(row.subtotalharga) == 0) {

                        //     if (type === 'display') {
                        //         return 0;
                        //     }
                        //     return 0;
                        // }


                        var grandtotal = (parseFloat(row.subtotalharga) - parseFloat(row.discount_total)) + parseFloat(FuncHitungPPN(row.id_category, row.ppn_used, (row.subtotalharga - row.discount_total)).ppn);

                        if (type === 'display') {
                            return formatNumberSeparator(grandtotal);
                        }

                        return grandtotal;

                    }
                }

                ,
                {
                    "data": "noreff",
                    "className": "text-left"
                }

                ,
                {
                    "data": "nomr",
                    "className": "text-left"
                }

                ,
                {
                    "data": "keterangan",
                    "className": "text-left"
                }

                ,
                {
                    "data": "comp"
                }

            ],
            createdRow: function(row, data, dataIndex) {

                var visibleHeaders = [];

                $('#tbltranshead thead th').each(function(i) {
                    if ($('#tbltranshead').DataTable().column(i).visible()) {
                        visibleHeaders.push($(this).text());
                    }
                });

                $('td', row).each(function(i) {
                    if (visibleHeaders[i]) {
                        $(this).attr('data-label', visibleHeaders[i]);
                    }
                });
            },

            "pageLength": 10,
            "order": [],
            "ordering": true,
            "scrollX": true,
            "scrollY": "250px",
            "scrollCollapse": true,
            "searching": true,
            "bLengthChange": true,
            "pagingType": "full",
            "columnDefs": [{
                    "targets": [0, 1],
                    "orderable": false
                }

                ,
                {
                    "targets": [2],
                    "visible": false
                }

                ,
                {
                    "targets": "text-right",
                    "className": "text-right"
                }

                ,
                {
                    "targets": "_all",
                    "className": "text-center"
                }

            ],
            "rowCallback": function(row, data, index) {
                // Hitung nomor urut berdasarkan urutan di hasil filtered + pagination
                var info = tbltranshead.page.info();
                var page = info.page; // halaman saat ini (0-based)
                var pageLength = info.length; // berapa baris per halaman
                var rowNumber = page * pageLength + index + 1;

                $('td:eq(1)', row).html(rowNumber); // eq(1) = kolom nomor urut (indeks ke-1)
            }

        });


        tbltransdet = $('#tbltransdet').DataTable({
            "ajax": {
                "url": "<?php echo site_url('trans_receipt/fetch_table_detail'); ?>",
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
                    "data": "category"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        //return row.category + " " + row.merk + " " + row.itembarang + " " + row.type;
                        return row.itembarang + " " + row.merk + " " + row.type;
                    }
                },
                {
                    "data": "satuan"
                },
                {
                    "data": "sn"
                }

            ],
            "pageLength": 10,
            "order": [],
            "ordering": true,
            "scrollX": true,
            "scrollY": "380px",
            "scrollCollapse": true,
            "searching": false,
            "bLengthChange": false,
            "pagingType": "full",
            "paging": false,
            "info": false
        });

    });



    $('#tbltranshead').on('click', 'tr', function() {
        var data = tbltranshead.row(this).data();

        //console.log(data);

        if ($(this).hasClass('selected')) {

            $(this).removeClass('selected');

            id_pesan = "";
            // $("#div_nopo").text("");
            // $("#div_grandtotal").text("");

            // $("#content_text_area").html("");

            tbltransdet.ajax.reload(null, false);

        } else {

            id_pesan = data.id_pesan;
            tbltransdet.ajax.reload(null, false);

            // var grandtotal = (parseFloat(data.subtotalharga) - parseFloat(data.discount_total)) + parseFloat(FuncHitungPPN(data.id_category, data.ppn_used, (data.subtotalharga - data.discount_total)).ppn);

            // $("#div_nopo").text(data.nopo);
            // $("#div_grandtotal").text('Grand Total = ' + formatNumberSeparator(grandtotal));

            // loadTextarea(id_pesan);

            tbltranshead.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }

    });


    // function loadTextarea(id_pesan) {
    //     $.ajax({
    //         url: "<-?php echo site_url('trans_purchaseorder/fetch_detail_keterangan'); ?>",
    //         type: "POST",
    //         data: {
    //             id_pesan: id_pesan
    //         },
    //         success: function(res) {
    //             $("#content_text_area").html(res); // append HTML dari controller
    //         },
    //         error: function() {
    //             alert("Gagal mengambil desain textarea");
    //         }
    //     });

    // }


    // function addData() {

    //     $.post('<-?= site_url("trans_purchaseorder/add_data") ?>', {}, function(html) {
    //         $('#divmodal').html(html);

    //         const modal = document.getElementById('id_modal_add');
    //         if (modal) {
    //             modal.classList.add('active');
    //             modalStack = modalStack || [];
    //             modalStack.push('id_modal_add');

    //             // INI YANG PENTING — INIT SEMUA FITUR SETELAH MODAL MASUK DOM!
    //             setTimeout(() => {
    //                 // 1. Tambah 1 baris pertama
    //                 if (typeof tambahBarisUtama === 'function' && $('#bodyItem tr').length === 0) {
    //                     tambahBarisUtama();
    //                 }

    //                 // 2. Init Select2 — PASTI BISA KETIK & CARI!
    //                 $('#id_modal_add select.select2').each(function() {
    //                     if ($(this).data('select2')) $(this).select2('destroy');
    //                 });
    //                 $('#id_modal_add .select2-container').remove();

    //                 $('#id_modal_add select.select2').select2({
    //                     allowClear: true,
    //                     width: '100%',
    //                     dropdownParent: $('#id_modal_add'),
    //                     placeholder: 'Ketik untuk mencari...',
    //                     minimumResultsForSearch: 0
    //                 });

    //             }, 300); // 300ms cukup buat modal muncul penuh
    //         }
    //     });

    // }

    function editData(id_pesan) {

        $.post('<?= site_url("trans_receipt/edit_data") ?>/' + id_pesan, {}, function(html) {
            $('#divmodal').html(html);

            const modal = document.getElementById('id_modal_edit');
            if (modal) {
                modal.classList.add('active');
                modalStack = modalStack || [];
                modalStack.push('id_modal_edit');

            }
        });
    }

    function printTandaTerima(el, id_pesan, nopo) {
        var row = $(el).closest('tr');
        var rowData = tbltranshead.row(row).data();

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


    // function hapusData(id_pesan, nopo) {
    //     var jawab = confirm(
    //         "YAKIN MAU HAPUS DATA INI?\n\n" +
    //         "Kode PO : " + id_pesan + "\n" +
    //         "NO PO  : " + nopo + "\n\n" +
    //         "😢 Klik Ok untuk hapus data!"
    //     );

    //     var dataok;

    //     if (jawab === true) {
    //         url = '<-?php echo site_url('trans_purchaseorder/delete_data') ?>';
    //         data = {
    //             id_pesan: id_pesan
    //         };
    //         pesan = 'function delete data gagal... 😢';
    //         dataok = multi_ajax_proses(url, data, pesan);

    //         if (dataok.msg != 'Ya') {
    //             alert(dataok.pesan);
    //             return false;
    //         }

    //     } else {
    //         return false;
    //     }

    //     alert(dataok.pesan);
    //     tbltranshead.ajax.reload(null, false);
    //     tbltransdet.ajax.reload(null, false);
    //     $("#content_text_area").html("");
    // }
</script>