<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>bootstrap-grid.min.css">
<style>
    /* #selectperusahaan {
        padding: 6px 2px !important;
    }

    #id_status_approval {
        padding: 6px 2px !important;
    } */

    .SettDisplayReport {
        padding: 6px 2px !important;
    }
</style>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Report</h5>
        <button class="btn btn-primary" onclick="Export()">
            <i class="fa fa-file-alt"></i> Export Excel
        </button>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-end">Pilih Perusahaan</label>
                    <div class="col-sm-9">
                        <?= $selectperusahaan; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-end">Type Request</label>
                    <div class="col-sm-9">
                        <?= $id_status_approval; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-end">Status</label>
                    <div class="col-sm-9">
                        <?= $typeApprove; ?>
                    </div>
                </div>
            </div>

        </div>


        <div class="row" style="margin-top: 1% !important;">
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-end">Tgl PO</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control form-control-sm SettDisplayReport" id="tglpesan1" name="tglpesan1" value="<?= date('Y-m-01'); ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-end">s/d Tgl PO</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control form-control-sm SettDisplayReport" id="tglpesan2" name="tglpesan2" value="<?= date('Y-m-d'); ?>">
                    </div>
                </div>
            </div>



        </div>

        <div class="datatable-container" style="margin-top: 2% !important;">

            <div class="datatable-wrapper">

                <table class="table table-bordered table-striped table-hover display nowrap" id="tblreportdirektur" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl PO</th>
                            <th>No PO</th>
                            <th>Dept</th>
                            <th>Total</th>
                            <th>PPN %</th>
                            <th>Nilai Lain</th>
                            <th>PPN</th>
                            <th>Grand Total</th>
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
    var tblreportdirektur;
    let modalStack = [];

    $(document).on('change', '#selectperusahaan', function() {
        tblreportdirektur.ajax.reload(null, false);
    });

    $(document).on('change', '#id_status_approval', function() {
        tblreportdirektur.ajax.reload(null, false);
    });

    $(document).on('change', '#typeApprove', function() {
        tblreportdirektur.ajax.reload(null, false);
    });

    $(document).on('change', '#tglpesan1', function() {
        tblreportdirektur.ajax.reload(null, false);
    });

    $(document).on('change', '#tglpesan2', function() {
        tblreportdirektur.ajax.reload(null, false);
    });

    $(document).ready(function() {
        tblreportdirektur = $('#tblreportdirektur').DataTable({
            "ajax": {
                "url": "<?php echo site_url('report_direktur/fetch_table'); ?>",
                "type": "POST",
                "data": function(d) {
                    d.selectperusahaan = $('#selectperusahaan').val();
                    d.id_status_approval = $('#id_status_approval').val();
                    d.typeApprove = $('#typeApprove').val();
                    d.tglpesan1 = $('#tglpesan1').val();
                    d.tglpesan2 = $('#tglpesan2').val();
                },
                "dataSrc": ""
            },
            "columns": [{
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "className": "dt-center",
                    "defaultContent": ""
                },

                {

                    "data": null,
                    "className": "text-center",
                    "render": function(data, type, row) {

                        if (type === 'display' || type === 'filter') {
                            return tglIndo(row.tglpesan);
                        }

                        return row.tglpesan;
                    }
                },
                {
                    "data": "nopo"
                },
                {
                    "data": "nama_divisi"
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
                },
                {
                    "data": "ppn_used" //PPN %
                }

                ,
                {
                    "data": null, //NILAI LAIN

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

                ,
                {
                    "data": null, //GRAND TOTAL

                    "className": "text-right",
                    "render": function(data, type, row) {

                        var grandtotal = (parseFloat(row.subtotalharga) - parseFloat(row.discount_total)) + parseFloat(FuncHitungPPN(row.id_category, row.ppn_used, (row.subtotalharga - row.discount_total)).ppn);

                        if (type === 'display') {
                            return formatNumberSeparator(grandtotal);
                        }

                        return grandtotal;

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
            // "columnDefs": [{
            //         "targets": [0, 1],
            //         "orderable": false
            //     },
            //     {
            //         "targets": [0, 2],
            //         "visible": false
            //     }
            // ],
            "rowCallback": function(row, data, index) {
                // Hitung nomor urut berdasarkan urutan di hasil filtered + pagination
                var info = tblreportdirektur.page.info();
                var page = info.page; // halaman saat ini (0-based)
                var pageLength = info.length; // berapa baris per halaman
                var rowNumber = page * pageLength + index + 1;

                $('td:eq(0)', row).html(rowNumber); // eq(1) = kolom nomor urut (indeks ke-1)
            }
        });

    });



    $('#tblreportdirektur').on('click', 'tr', function() {
        var data = tblreportdirektur.row(this).data();

        if ($(this).hasClass('selected')) {

            $(this).removeClass('selected');
        } else {

            tblreportdirektur.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }

    });

    function Export() {
        var selectperusahaan = $('#selectperusahaan').val();
        var id_status_approval = $('#id_status_approval').val();
        var typeApprove = $('#typeApprove').val();
        var tglpesan1 = $('#tglpesan1').val();
        var tglpesan2 = $('#tglpesan2').val();

        var data = [];
        data[0] = selectperusahaan;
        data[1] = id_status_approval;
        data[2] = typeApprove;
        data[3] = tglpesan1;
        data[4] = tglpesan2;

        var page = "<?php echo base_url(); ?>report_direktur/export?data=" + btoa(data);
        window.open(page);
    }
</script>