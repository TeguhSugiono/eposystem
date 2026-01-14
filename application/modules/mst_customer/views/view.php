<div class="card">
    <div class="card-header">
        <h5 class="card-title">Master Customer</h5>
        <!-- <button class="btn btn-primary" onclick="addData()">
            <i class="fa fa-plus"></i> Add Customer
        </button> -->
    </div>
    <div class="card-body">

        <div class="datatable-container">

            <div class="datatable-wrapper">

                <table class="table table-bordered table-striped table-hover display nowrap" id="tblmstcustomer" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Customer</th>
                            <th>Nama Customer</th>
                            <th>Alamat</th>
                            <th>Telp</th>
                            <th>Fax</th>
                            <th>Contact Person</th>
                            <th>NPWP</th>
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
    var tblmstcustomer;
    //let modalStack = [];

    $(document).ready(function() {
        tblmstcustomer = $('#tblmstcustomer').DataTable({
            "ajax": {
                "url": "<?php echo site_url('mst_customer/fetch_table'); ?>",
                "type": "POST",
                "data": function(d) {

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
                    "data": "cust_code"
                },
                {
                    "data": "cust_name"
                },
                {
                    "data": "address"
                },
                {
                    "data": "phone"
                },
                {
                    "data": "fax"
                },
                {
                    "data": "contact_person"
                },
                {
                    "data": "npwp"
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
                "targets": [0],
                "orderable": false
            }]
        });

    });



    // $('#tblmstcustomer').on('click', 'tr', function() {
    //     var data = tblmstcustomer.row(this).data();

    //     if ($(this).hasClass('selected')) {

    //         $(this).removeClass('selected');
    //     } else {

    //         tblmstcustomer.$('tr.selected').removeClass('selected');
    //         $(this).addClass('selected');
    //     }

    // });

    // function addData() {
    //     $.post('<?= site_url("mst_supplier/add_data") ?>', {}, function(html) {
    //         $('#divmodal').html(html);

    //         const modal = document.getElementById('id_modal_add');
    //         if (modal) {
    //             modal.classList.add('active');
    //             modalStack = modalStack || [];
    //             modalStack.push('id_modal_add');

    //         }
    //     });
    // }

    // function editData(kodesupplier) {

    //     $.post('<?= site_url("mst_supplier/edit_data") ?>/' + kodesupplier, {}, function(html) {
    //         $('#divmodal').html(html);

    //         const modal = document.getElementById('id_modal_edit');
    //         if (modal) {
    //             modal.classList.add('active');
    //             modalStack = modalStack || [];
    //             modalStack.push('id_modal_edit');

    //         }
    //     });
    // }

    // function hapusData(kodesupplier, namasupplier) {
    //     var jawab = confirm(
    //         "YAKIN MAU HAPUS DATA INI?\n\n" +
    //         "Kode Supplier : " + kodesupplier + "\n" +
    //         "Nama Supplier  : " + namasupplier + "\n\n" +
    //         "😢 Klik Ok untuk hapus data!"
    //     );

    //     var dataok;

    //     if (jawab === true) {
    //         url = '<?php echo site_url('mst_supplier/delete_data') ?>';
    //         data = {
    //             kodesupplier: kodesupplier
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
    //     tblmstcustomer.ajax.reload(null, false);
    // }
</script>