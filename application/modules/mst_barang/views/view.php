<style>
    /* .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6 !important;
    } */
</style>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Master Barang</h5>
        <button class="btn btn-primary" onclick="addData()">
            <i class="fa fa-plus"></i> Add Barang
        </button>
    </div>
    <div class="card-body">

        <div class="datatable-container">

            <div class="datatable-wrapper">

                <!-- <table class="table table-bordered display nowrap" id="tblmstbarang" style="width: 100%"> -->
                <table class="table table-bordered table-striped table-hover display nowrap" id="tblmstbarang" style="width: 100%">
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

<div id="divmodal"></div>

<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>jquery.dataTables.min.css">
<script src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>jquery-3.7.1.min.js"></script>


<script type="text/javascript">
    var tblmstbarang;
    let modalStack = [];

    $(document).ready(function() {
        tblmstbarang = $('#tblmstbarang').DataTable({
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
                    "targets": [2],
                    "visible": false
                }
            ],
            "rowCallback": function(row, data, index) {
                // Hitung nomor urut berdasarkan urutan di hasil filtered + pagination
                var info = tblmstbarang.page.info();
                var page = info.page; // halaman saat ini (0-based)
                var pageLength = info.length; // berapa baris per halaman
                var rowNumber = page * pageLength + index + 1;

                $('td:eq(1)', row).html(rowNumber); // eq(1) = kolom nomor urut (indeks ke-1)
            }
        });

    });



    $('#tblmstbarang').on('click', 'tr', function() {
        var data = tblmstbarang.row(this).data();

        if ($(this).hasClass('selected')) {

            $(this).removeClass('selected');
        } else {

            tblmstbarang.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }

    });

    function addData() {
        $.post('<?= site_url("mst_barang/add_data") ?>', {}, function(html) {
            $('#divmodal').html(html);

            const modal = document.getElementById('id_modal_add');
            if (modal) {
                modal.classList.add('active');
                modalStack = modalStack || [];
                modalStack.push('id_modal_add');

            }
        });
    }

    function editData(kodebarang) {

        $.post('<?= site_url("mst_barang/edit_data") ?>/' + kodebarang, {}, function(html) {
            $('#divmodal').html(html);

            const modal = document.getElementById('id_modal_edit');
            if (modal) {
                modal.classList.add('active');
                modalStack = modalStack || [];
                modalStack.push('id_modal_edit');

            }
        });
    }

    function hapusData(kodebarang, itembarang) {
        var jawab = confirm(
            "YAKIN MAU HAPUS DATA INI?\n\n" +
            "Kode Barang : " + kodebarang + "\n" +
            "Item Barang  : " + itembarang + "\n\n" +
            "😢 Klik Ok untuk hapus data!"
        );

        var dataok;

        if (jawab === true) {
            url = '<?php echo site_url('mst_barang/delete_data') ?>';
            data = {
                kodebarang: kodebarang
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
        tblmstbarang.ajax.reload(null, false);
    }
</script>