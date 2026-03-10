<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>bootstrap-grid.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>styles.css">

<style>
    .rowX {
        margin: -1px;
    }

    .textBold {
        font-weight: bold;
        font-size: 16px !important;
    }

    .textTableDifferent {
        color: #3B82F6 !important;
    }

    /* 1	Accept PO
        2	Cancel PO
        3	Revisi PO
        4	Hold PO */
    <?php
    $classHold = "block";
    if ($GetDataRequest[0]['id_status_approval'] == "4") {
        $classHold = "none";
    }

    $classAccept = "block";
    $classReject = "block";
    if ($GetDataRequest[0]['acc_director'] == "Y" || $GetDataRequest[0]['acc_director'] == "R") {
        $classAccept = "none";
        $classReject = "none";
        $classHold = "none";
    }
    if ($GetDataRequest[0]['acc_director'] == "H") {
        $classHold = "none";
    }
    ?>
</style>

<div class="modal-overlay" id="id_modal_add">
    <div class="modal xlarge">
        <div class="modal-header">
            <h1 class="modal-title" style="color:white;font-weight: 400;"> No&nbsp;:&nbsp;<?= $GetDataHeader[0]['nopo']; ?>&nbsp;~&nbsp;Dept&nbsp;:&nbsp;<?= $GetDataHeader[0]['dept']; ?>&nbsp;</h1>
            <button class="modal-close" onclick="closeModal('id_modal_add')">×</button>
        </div>
        <div class="modal-body">

            <form id="formadd" class="form-horizontal" method="post" action="#">

                <input type="hidden" class="form-control form-control-sm textBold" id="id_pesan" name="id_pesan" value="<?= $id_pesan; ?>">
                <input type="hidden" class="form-control form-control-sm textBold" id="id_request" name="id_request" value="<?= $id_request; ?>">

                <div class="row">
                    <!-- <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">No PO</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm textBold" id="nopo" name="nopo" value="<-?= $GetDataHeader[0]['nopo']; ?>" readonly>
                            </div>
                        </div>
                    </div> -->

                    <?php
                    $addClass1 = "";
                    if (count($GetDataHeaderOld) > 0) {
                        if ($GetDataSupplier[0]['suppl_name'] != $GetDataHeaderOld[0]['suppl_name']) {
                            $addClass1 = "color: #3B82F6 !important;";
                        }
                    }
                    ?>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Nama Supplier</label>
                            <div class="col-sm-9">
                                <input type="text" style="<?= $addClass1; ?>" class="form-control form-control-sm textBold" id="suppl_name" name="suppl_name" value="<?= $GetDataSupplier[0]['suppl_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>


                    <?php
                    $addClass2 = "";
                    if (count($GetDataHeaderOld) > 0) {
                        if ($GetDataSupplier[0]['alamat'] != $GetDataHeaderOld[0]['alamat']) {
                            $addClass2 = "color: #3B82F6 !important;";
                        }
                    }
                    ?>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Alamat</label>
                            <div class="col-sm-9">
                                <textarea readonly style="<?= $addClass2; ?>" id="alamat" name="alamat" rows="3" cols="40" class="form-control textBold"><?= $GetDataSupplier[0]['alamat']; ?></textarea>
                            </div>
                        </div>
                    </div>


                    <?php
                    $addClass3 = "";
                    if (count($GetDataHeaderOld) > 0) {
                        if ($GetDataHeader[0]['keterangan'] != $GetDataHeaderOld[0]['keterangan']) {
                            $addClass3 = "color: #3B82F6 !important;";
                        }
                    }
                    ?>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea readonly id="keterangan" style="<?= $addClass3; ?>" name="keterangan" rows="3" cols="40" class="form-control textBold"><?= $GetDataHeader[0]['keterangan']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="datatable-container" style="margin-top: 2% !important;">

                    <div class="datatable-wrapper">
                        <!-- <h5 class="card-title" style="text-align:center;">Detail PO</h5> -->
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







            </form>



        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" onclick="accept()" style="display: <?= $classAccept; ?>;">Accept</button>
            <button class="btn btn-primary" onclick="hold()" style="display: <?= $classHold; ?>;">Hold</button>
            <button class="btn btn-primary" onclick="reject()" style="display: <?= $classReject; ?>;">Reject</button>
            <button class="btn btn-secondary" onclick="closeModal('id_modal_add')">Close</button>
        </div>
    </div>
</div>



<script type="text/javascript">
    var tbltransdet;
    var id_pesan_det = "<?= $id_pesan; ?>";
    var id_request_det = "<?= $id_request; ?>";

    //alert(id_pesan_det);


    //initSelect2('id_modal_add');

    function closeModal(modalId = 'id_modal_add') {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');

            setTimeout(() => {
                // Hapus isi modal (bukan modalnya) — biar pas buka lagi fresh
                $('#divmodal').empty();

                // Bersihin Select2
                $('.select2-container').remove();
                $('select.select2').select2('destroy');

                // Reset counter
                if (typeof counter !== 'undefined') counter = 0;

                // Reload tabel utama kalau ada
                // if (typeof tblmstbarang !== 'undefined') {
                //     tblmstbarang.ajax.reload(null, false);
                // }
                if (typeof tblrequestpo !== 'undefined') {
                    //tblmstbarang.ajax.reload(null, false);
                    tblrequestpo.ajax.reload(null, false);
                }
            }, 300);
        }
    }

    $(document).ready(function() {


        var GetDataDetailOld = <?= json_encode(!empty($GetDataDetailOld) ? $GetDataDetailOld : []); ?>;
        var GetDataHeaderOld = <?= json_encode(!empty($GetDataHeaderOld) ? $GetDataHeaderOld : []); ?>;

        var HeadSubtotalOld = 0;
        var HeadNilaiLainOld = 0;
        var HeadNPPNOld = 0;
        var HeadPPNUseOld = 0;
        var HeadGrandTotalOld = 0;
        var HeadCategoryOld = "";

        if (GetDataHeaderOld && GetDataHeaderOld.length > 0) {
            var old = GetDataHeaderOld[0];

            HeadSubtotalOld = old['subtotalharga'];
            HeadNilaiLainOld = old['nilai_lain'];
            HeadNPPNOld = old['ppn'];
            HeadPPNUseOld = old['ppn_used'];
            HeadGrandTotalOld = old['grandtotal'];
            HeadCategoryOld = old['id_category'];
        }

        tbltransdet = $('#tbltransdet').DataTable({
            "ajax": {
                "url": "<?php echo site_url('dashboardmanager/fetch_table_detail'); ?>",
                "type": "POST",
                "data": function(d) {
                    d.id_pesan = id_pesan_det;
                    d.id_request = id_request_det;
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


                if (GetDataDetailOld && GetDataDetailOld.length > 0) {

                    var namabarangOld = GetDataDetailOld[dataIndex]['itembarang'] + " " + GetDataDetailOld[dataIndex]['merk'] + " " + GetDataDetailOld[dataIndex]['type'];
                    var namabarangNew = data['itembarang'] + " " + data['merk'] + " " + data['type'];

                    if (namabarangOld != namabarangNew) {
                        $('td', row).eq(1).addClass('textTableDifferent');
                    }

                    var qtyold = GetDataDetailOld[dataIndex]['qtymsk'];
                    var qtynew = data['qtymsk'];

                    if (qtyold != qtynew) {
                        $('td', row).eq(2).addClass('textTableDifferent');
                    }

                    var hargaold = GetDataDetailOld[dataIndex]['hargasatuan'];
                    var harganew = data['hargasatuan'];

                    if (hargaold != harganew) {
                        $('td', row).eq(3).addClass('textTableDifferent');
                    }

                    var diskonold = GetDataDetailOld[dataIndex]['diskon'];
                    var diskonnew = data['diskon'];

                    if (diskonold != diskonnew) {
                        $('td', row).eq(4).addClass('textTableDifferent');
                    }

                    var totalold = GetDataDetailOld[dataIndex]['total'];
                    var totalnew = data['total'];

                    if (totalold != totalnew) {
                        $('td', row).eq(5).addClass('textTableDifferent');
                    }

                }

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

                var addclass1 = "";
                if (GetDataHeaderOld && GetDataHeaderOld.length > 0) {
                    if (HeadSubtotal != HeadSubtotalOld) {
                        addclass1 = "color: #3B82F6 !important;";
                    }
                }

                var subtotalRow = `
                    <tr class="subtotal-row">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><strong>Subtotal</strong></td>
                        <td class="text-right" style="${addclass1}"><strong>${formatNumberSeparator(parseFloat(HeadSubtotal))}</strong></td>
                    </tr>`;

                $('#tbltransdet tbody').append(subtotalRow);


                var addclass2 = "";
                if (GetDataHeaderOld && GetDataHeaderOld.length > 0) {
                    if (HeadNilaiLain != HeadNilaiLainOld) {
                        addclass2 = "color: #3B82F6 !important;";
                    }
                }

                subtotalRow = `
                    <tr class="subtotal-row">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><strong>Nilai Lain</strong></td>
                        <td class="text-right" style="${addclass2}"><strong>${formatNumberSeparator(parseFloat(HeadNilaiLain))}</strong></td>
                    </tr>`;

                $('#tbltransdet tbody').append(subtotalRow);



                //HeadCategory
                var hitungppn = FuncHitungPPN(HeadCategory, HeadPPNUse, HeadSubtotal).ppn;
                var hitungppnOld = FuncHitungPPN(HeadCategoryOld, HeadPPNUseOld, HeadSubtotalOld).ppn;

                var addclass3 = "";
                if (GetDataHeaderOld && GetDataHeaderOld.length > 0) {
                    if (hitungppn != hitungppnOld) {
                        addclass3 = "color: #3B82F6 !important;";
                    }
                }

                subtotalRow = `
                    <tr class="subtotal-row">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><strong>PPN</strong></td>
                        <td class="text-right" style="${addclass3}"><strong>${formatNumberSeparator(parseFloat(hitungppn))}</strong></td>
                    </tr>`;

                $('#tbltransdet tbody').append(subtotalRow);

                var addclass4 = "";
                if (GetDataHeaderOld && GetDataHeaderOld.length > 0) {
                    if (HeadGrandTotal != HeadGrandTotalOld) {
                        addclass4 = "color: #3B82F6 !important;";
                    }
                }

                subtotalRow = `
                    <tr class="subtotal-row">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><strong>Grand Total</strong></td>
                        <td class="text-right" style="${addclass4}"><strong>${formatNumberSeparator(parseFloat(HeadGrandTotal))}</strong></td>
                    </tr>`;

                $('#tbltransdet tbody').append(subtotalRow);

            }
        });

    });

    function hold() {
        url = '<?php echo site_url('dashboarddirektur/proses_hold_direktur') ?>';
        data = {
            id_pesan_det: id_pesan_det,
            id_request_det: id_request_det
        };
        pesan = 'function proses_hold_direktur gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);

        if (dataok.msg != 'Ya') {
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        closeModal('id_modal_add');
        tblrequestpo.ajax.reload(null, false);
    }

    function accept() {

        //send back notifikasi
        url = '<?php echo site_url('dashboarddirektur/send_back_notifikasi') ?>';
        data = {
            id_pesan_det: id_pesan_det,
            id_request_det: id_request_det
        };
        pesan = 'function send_back_notifikasi gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);

        //console.log(dataok);


        if (dataok.msg != "Ya") {
            alert(dataok.pesan);
            return false;
        }
        //end send back notifikasi


        url = '<?php echo site_url('dashboarddirektur/proses_accept_direktur') ?>';
        data = {
            id_pesan_det: id_pesan_det,
            id_request_det: id_request_det
        };
        pesan = 'function proses_accept_direktur gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);

        //console.log(dataok);

        if (dataok.msg != 'Ya') {
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);

        closeModal('id_modal_add');
        tblrequestpo.ajax.reload(null, false);
    }

    function reject() {

        url = '<?php echo site_url('dashboarddirektur/send_back_notifikasi_reject') ?>';
        data = {
            id_pesan_det: id_pesan_det,
            id_request_det: id_request_det
        };
        pesan = 'function send_back_notifikasi gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);

        //console.log(dataok);


        if (dataok.msg != "Ya") {
            alert(dataok.pesan);
            return false;
        }


        url = '<?php echo site_url('dashboarddirektur/proses_reject_direktur') ?>';
        data = {
            id_pesan_det: id_pesan_det,
            id_request_det: id_request_det
        };
        pesan = 'function proses_reject_direktur gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);

        if (dataok.msg != 'Ya') {
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        closeModal('id_modal_add');
        tblrequestpo.ajax.reload(null, false);
    }
</script>