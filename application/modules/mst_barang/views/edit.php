<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>bootstrap-grid.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>styles.css">


<div class="modal-overlay active" id="id_modal_edit"> <!--style="margin-top: -18% !important;"-->
    <div class="modal medium">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fa fa-edit"></i> Edit Barang</h3>
            <button class="modal-close" onclick="closeModal('id_modal_edit')">×</button>
        </div>
        <div class="modal-body">

            <form id="formedit" class="form-horizontal" method="post" action="#">
                <input type="hidden" class="form-control form-control-sm" id="kodebarang" name="kodebarang" value="<?= $GetDataEdit->kodebarang; ?>">

                <div class="row mb-3" style="text-align: center;margin-bottom:40px !important;font-weight: 700;">
                    <label class="col-sm-12 col-form-label text-end">
                        ID Data <<<>>>&nbsp;<?= $GetDataEdit->kodebarang; ?>&nbsp;<<<>>>
                    </label>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Category</label>
                    <div class="col-sm-8">
                        <?= $category; ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Item Barang</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="itembarang" name="itembarang" value="<?= quotStr($GetDataEdit->itembarang); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Merk</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="merk" name="merk" value="<?= quotStr($GetDataEdit->merk); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Type</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="type" name="type" value="<?= quotStr($GetDataEdit->type); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Satuan</label>
                    <div class="col-sm-8">
                        <?= $satuan; ?>
                    </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('id_modal_edit')">Batal</button>
            <button class="btn btn-primary" onclick="save()">Save</button>
        </div>
    </div>
</div>


<script type="text/javascript">
    initSelect2('id_modal_edit');

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');
            tblmstbarang.ajax.reload(null, false);
            // Hapus dari DOM biar bersih (opsional)
            setTimeout(() => {
                modal.remove();
            }, 300);
        }
    }

    function save() {

        var dataPost = $('#formedit').serialize();

        url = '<?php echo site_url('mst_barang/update_data') ?>';
        data = dataPost;
        pesan = 'function update data gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);

        if (dataok.msg != 'Ya') {
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        closeModal('id_modal_edit');
        tblmstbarang.ajax.reload(null, false);

    }
</script>