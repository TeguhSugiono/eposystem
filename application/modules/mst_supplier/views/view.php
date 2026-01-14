<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>bootstrap-grid.min.css">
<style>
    #selectperusahaan {
        padding: 6px 2px !important;
    }
</style>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Master Supplier</h5>

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
        </div>

        <div class="datatable-container" style="margin-top: 2% !important;">

            <div class="datatable-wrapper">

                <table class="table table-bordered table-striped table-hover display nowrap" id="tblmstsupplier" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>No</th>
                            <th>Kode Supplier</th>
                            <th>Nama Supplier</th>
                            <th>Alamat</th>
                            <th>Telp</th>
                            <th>Fax</th>
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
    var tblmstsupplier;
    let modalStack = [];

    $(document).on('change', '#selectperusahaan', function() {
        tblmstsupplier.ajax.reload(null, false);
    });

    $(document).ready(function() {
        tblmstsupplier = $('#tblmstsupplier').DataTable({
            "ajax": {
                "url": "<?php echo site_url('mst_supplier/fetch_table'); ?>",
                "type": "POST",
                "data": function(d) {
                    d.selectperusahaan = $('#selectperusahaan').val()
                },
                "dataSrc": ""
            },
            "columns": [{
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "className": "dt-center",
                    "render": function(data, type, row) {

                        var suppl_name = escapeHtml(row.suppl_name);

                        return `
                            <a href="javascript:void(0)" onclick="editData('${row.suppl_code}')" 
                                class="btn btn-sm btn-primary" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" onclick="hapusData('${row.suppl_code}', '${suppl_name}')" 
                                class="btn btn-sm btn-primary" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </button>

                        `;
                    }
                },
                // {
                //     "data": null,
                //     "render": function(data, type, row, meta) {
                //         return meta.row + 1;
                //     }
                // },

                {
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "className": "dt-center",
                    "defaultContent": ""
                },

                {
                    "data": "suppl_code"
                },
                {
                    "data": "suppl_name"
                },
                {
                    "data": "alamat"
                },
                {
                    "data": "phone"
                },
                {
                    "data": "fax"
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
                },
                {
                    "targets": [0, 2],
                    "visible": false
                }
            ],
            "rowCallback": function(row, data, index) {
                // Hitung nomor urut berdasarkan urutan di hasil filtered + pagination
                var info = tblmstsupplier.page.info();
                var page = info.page; // halaman saat ini (0-based)
                var pageLength = info.length; // berapa baris per halaman
                var rowNumber = page * pageLength + index + 1;

                $('td:eq(0)', row).html(rowNumber); // eq(1) = kolom nomor urut (indeks ke-1)
            }
        });

    });



    $('#tblmstsupplier').on('click', 'tr', function() {
        var data = tblmstsupplier.row(this).data();

        if ($(this).hasClass('selected')) {

            $(this).removeClass('selected');
        } else {

            tblmstsupplier.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }

    });

    function addData() {
        $.post('<?= site_url("mst_supplier/add_data") ?>', {}, function(html) {
            $('#divmodal').html(html);

            const modal = document.getElementById('id_modal_add');
            if (modal) {
                modal.classList.add('active');
                modalStack = modalStack || [];
                modalStack.push('id_modal_add');

            }
        });
    }

    function editData(kodesupplier) {

        $.post('<?= site_url("mst_supplier/edit_data") ?>/' + kodesupplier, {}, function(html) {
            $('#divmodal').html(html);

            const modal = document.getElementById('id_modal_edit');
            if (modal) {
                modal.classList.add('active');
                modalStack = modalStack || [];
                modalStack.push('id_modal_edit');

            }
        });
    }

    function hapusData(kodesupplier, namasupplier) {
        var jawab = confirm(
            "YAKIN MAU HAPUS DATA INI?\n\n" +
            "Kode Supplier : " + kodesupplier + "\n" +
            "Nama Supplier  : " + namasupplier + "\n\n" +
            "😢 Klik Ok untuk hapus data!"
        );

        var dataok;

        if (jawab === true) {
            url = '<?php echo site_url('mst_supplier/delete_data') ?>';
            data = {
                kodesupplier: kodesupplier
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
        tblmstsupplier.ajax.reload(null, false);
    }
</script>