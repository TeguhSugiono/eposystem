<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>bootstrap-grid.min.css">

<style>
    .cardwith {
        width: 100% !important;
    }

    @media (max-width: 768px) {
        .cardwith {
            width: 100% !important;
        }
    }

    #selectperusahaan {
        padding: 6px 2px !important;
    }
</style>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Master Bank</h5>
        <button class="btn btn-primary" onclick="addData()">
            <i class="fa fa-plus"></i> Add Bank
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
        </div>

        <div class="datatable-container" style="margin-top: 2% !important;">

            <div class="datatable-wrapper">
                <table class="table table-bordered table-striped table-hover display nowrap" id="tblbank" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>No</th>
                            <th>id_bank</th>
                            <th>id_suppl</th>
                            <th>Nama Supplier</th>
                            <th>a/n Bank</th>
                            <th>Nama Bank</th>
                            <th>No Rekening</th>
                            <th>Alamat/Cabang</th>
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
    var tblbank;
    let modalStack = [];

    $(document).on('change', '#selectperusahaan', function() {
        tblbank.ajax.reload(null, false);
    });

    $(document).ready(function() {
        tblbank = $('#tblbank').DataTable({
            "ajax": {
                "url": "<?php echo site_url('mst_bank/fetch_table'); ?>",
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

                        //var namasatuan = escapeHtml(row.namasatuan);

                        return `
                            <a href="javascript:void(0)" onclick="editData('${row.id_bank}','${row.id_suppl}')" 
                                class="btn btn-sm btn-primary" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                        `;
                        /*
                        <button type="button" onclick="hapusData('${row.no}', '${namasatuan}')" 
                                class="btn btn-sm btn-primary" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </button>
                        */
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
                    "data": "id_bank"
                },
                {
                    "data": "id_suppl"
                },
                {
                    "data": "suppl_name"
                },
                {
                    "data": "atas_nama"
                },
                {
                    "data": "nama_bank"
                },
                {
                    "data": "no_rek"
                },
                {
                    "data": "alamat"
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
                    "targets": [2, 3],
                    "visible": false
                }
            ],
            "rowCallback": function(row, data, index) {
                // Hitung nomor urut berdasarkan urutan di hasil filtered + pagination
                var info = tblbank.page.info();
                var page = info.page; // halaman saat ini (0-based)
                var pageLength = info.length; // berapa baris per halaman
                var rowNumber = page * pageLength + index + 1;

                $('td:eq(1)', row).html(rowNumber); // eq(1) = kolom nomor urut (indeks ke-1)
            }
        });

    });



    $('#tblbank').on('click', 'tr', function() {
        var data = tblbank.row(this).data();

        if ($(this).hasClass('selected')) {

            $(this).removeClass('selected');
        } else {

            tblbank.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }

    });

    function addData() {
        $.post('<?= site_url("mst_bank/add_data") ?>', {
            perusahaan: $('#selectperusahaan').val()
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

    function editData(id_bank, id_suppl) {
        var perusahaan = $('#selectperusahaan').val();

        $.post('<?= site_url("mst_bank/edit_data") ?>/' + id_bank + '/' + perusahaan + '/' + id_suppl, {}, function(html) {
            $('#divmodal').html(html);

            const modal = document.getElementById('id_modal_edit');
            if (modal) {
                modal.classList.add('active');
                modalStack = modalStack || [];
                modalStack.push('id_modal_edit');

            }
        });
    }

    // function hapusData(kodesatuan, namasatuan) {
    //     var jawab = confirm(
    //         "YAKIN MAU HAPUS DATA INI?\n\n" +
    //         "Kode satuan : " + kodesatuan + "\n" +
    //         "Nama satuan  : " + namasatuan + "\n\n" +
    //         "😢 Klik Ok untuk hapus data!"
    //     );

    //     var dataok;

    //     if (jawab === true) {
    //         url = '<?php echo site_url('mst_satuan/delete_data') ?>';
    //         data = {
    //             kodesatuan: kodesatuan,
    //             namasatuan: namasatuan
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
    //     tblbank.ajax.reload(null, false);
    // }
</script>