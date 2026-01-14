<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>bootstrap-grid.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>styles.css">

<style>
    .rowX {
        margin: 2px;
    }

    @media (max-width: 768px) {
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0px;
        }
    }
</style>


<div class="modal-overlay active" id="id_modal_edit"> <!--style="margin-top: -18% !important;"-->
    <div class="modal large">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fa fa-edit"></i> Edit Terima Barang</h3>
            <button class="modal-close" onclick="closeModal('id_modal_edit')">×</button>
        </div>
        <div class="modal-body">

            <form id="formadd" class="form-horizontal" method="post" action="#">

                <!-- <input type="hidden" class="form-control form-control-sm" id="id_pesan_old" name="id_pesan_old" value="<-?= $GetDataRequest[0]['id_pesan']; ?>">
                <input type="hidden" class="form-control form-control-sm" id="id_request" name="id_request" value="<-?= $GetDataRequest[0]['id_request']; ?>"> -->

                <div class="row rowA">
                    <div class="col-md-6">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Tgl Invoice</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control form-control-sm" id="tgl_invoice" name="tgl_invoice">
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row rowA">

                    <div class="col-md-6">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">No Invoice</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="no_invoice" name="no_invoice">
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row rowA">


                    <div class="col-md-6">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">No Faktur</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="faktur_pajak" name="faktur_pajak">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row rowA">

                    <div class="card-body">
                        <div class="datatable-container">
                            <div class="datatable-wrapper">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover display nowrap" id="tblItemBarang" style="width: 100%">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Qty</th>
                                                <th>ID</th>
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


            </form>

        </div>
        <!-- <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('id_modal_edit')">Batal</button>
            <button class="btn btn-primary" onclick="save()">Save</button>

        </div> -->
    </div>
</div>


<script type="text/javascript">
    initSelect2('id_modal_edit');

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');
            tblrequestpo.ajax.reload(null, false);
            // Hapus dari DOM biar bersih (opsional)
            setTimeout(() => {
                modal.remove();
            }, 300);
        }
    }

    // function save() {

    //     if ($('#id_pesan').val() == "") {
    //         alert('No PO Masih Kosong..!!');
    //         return;
    //     }

    //     if ($('#id_status_approval').val() == "") {
    //         alert('Type Request Masih Kosong..!!');
    //         return;
    //     }

    //     var dataPost = $('#formadd').serialize();


    //     url = '<?php echo site_url('request_po/update_data') ?>';
    //     data = dataPost;
    //     pesan = 'function update data gagal... 😢';
    //     dataok = multi_ajax_proses(url, data, pesan);

    //     if (dataok.msg != 'Ya') {
    //         alert(dataok.pesan);
    //         return false;
    //     }
    //     alert(dataok.pesan);
    //     closeModal('id_modal_edit');
    //     tblrequestpo.ajax.reload(null, false);

    // }
</script>