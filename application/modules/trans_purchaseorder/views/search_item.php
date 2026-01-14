<div class="modal-overlay" id="modal_search_item">
    <div class="modal large">
        <div class="modal-header">
            <h3 class="modal-title">List Barang</h3>
            <button class="modal-close" onclick="closeModal()">×</button>
        </div>
        <div class="modal-body">
            <div class="row rowA">
                <div class="card-body">
                    <div class="datatable-container">
                        <div class="datatable-wrapper">

                            <!-- <input type="text" class="form-control form-control-sm" id="currentRowId" name="currentRowId" value="<-?= $currentRowId; ?>"> -->

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover display nowrap" id="tabelItemBarang" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Aksi</th>
                                            <th>No</th>
                                            <th>Kode Barang</th>
                                            <th>Kategori</th>
                                            <th>Item Barang</th>
                                            <th>Merk</th>
                                            <th>Type</th>
                                            <th>Satuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal()">Tutup</button>
            <button class="btn btn-primary">Simpan</button>
        </div>
    </div>
</div>


<script type="text/javascript">
    var tabelItemBarang;

    $(document).ready(function() {

        tabelItemBarang = $('#tabelItemBarang').DataTable({
            "ajax": {
                "url": "<?php echo site_url('mst_barang/fetch_table'); ?>",
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

                        var namabarang = escapeHtml(row.itembarang);

                        return `
                            <a href="javascript:void(0)" onclick="editData('${row.kodebarang}')" 
                            class="btn btn-sm btn-primary" title="Edit">
                            <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" onclick="hapusData('${row.kodebarang}', '${namabarang}')" 
                            class="btn btn-sm btn-primary" title="Hapus">
                            <i class="fa fa-trash"></i>
                            </button>

                            `;
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "kodebarang"
                },
                {
                    "data": "category"
                },
                {
                    "data": "itembarang"
                },
                {
                    "data": "merk"
                },
                {
                    "data": "type"
                },
                {
                    "data": "satuan"
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
                    "targets": [0],
                    "visible": false
                }
            ]
        });

    });

    $('#tabelItemBarang').on('dblclick', 'tr', function() {
        var data = tabelItemBarang.row(this).data();
        //console.log(data);

        if ($(this).hasClass('selected')) {

            $(this).removeClass('selected');
        } else {

            $(`#item_barang_${currentRowId}`).val(data.itembarang + " " + data.merk + " " + data.type);
            $(`#kodebarang_${currentRowId}`).val(data.kodebarang);

            tabelItemBarang.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');

            closeModal('modal_search_item');
        }

    });

    function closeModal(modalId = 'modal_search_item') {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');

            setTimeout(() => {
                // Hapus isi modal (bukan modalnya) — biar pas buka lagi fresh
                $('#divmodalSecond').empty();

                // Bersihin Select2
                //$('.select2-container').remove();
                //$('select.select2').select2('destroy');

                // Reset counter
                //if (typeof counter !== 'undefined') counter = 0;

                // Reload tabel utama kalau ada
                // if (typeof tblmstbarang !== 'undefined') {
                //     tblmstbarang.ajax.reload(null, false);
                // }
            }, 300);
        }
    }
</script>