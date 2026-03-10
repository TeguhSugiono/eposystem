<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>bootstrap-grid.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>styles.css">


<div class="modal-overlay active" id="id_modal_edit"> <!--style="margin-top: -18% !important;"-->
    <div class="modal medium">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fa fa-edit"></i> Edit Supplier</h3>
            <button class="modal-close" onclick="closeModal('id_modal_edit')">×</button>
        </div>
        <div class="modal-body">

            <form id="formedit" class="form-horizontal" method="post" action="#">
                <input type="hidden" class="form-control form-control-sm" id="kodesupplier" name="kodesupplier" value="<?= $GetDataEdit->kodesupplier; ?>">

                <div class="row mb-3" style="text-align: center;margin-bottom:40px !important;font-weight: 700;">
                    <label class="col-sm-12 col-form-label text-end">
                        ID Data <<<>>>&nbsp;<?= $GetDataEdit->kodesupplier; ?>&nbsp;<<<>>>
                    </label>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Nama Supplier</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="namasupplier" name="namasupplier" value="<?= quotStr($GetDataEdit->namasupplier); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Alamat</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="alamat" name="alamat" value="<?= quotStr($GetDataEdit->alamat); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Telp</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="telp" name="telp" value="<?= quotStr($GetDataEdit->telp); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Fax</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="fax" name="fax" value="<?= quotStr($GetDataEdit->fax); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Divisi</label>
                    <div class="col-sm-8">
                        <?= $kode_divisi; ?>
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
            tblmstsupplier.ajax.reload(null, false);
            // Hapus dari DOM biar bersih (opsional)
            setTimeout(() => {
                modal.remove();
            }, 300);
        }
    }

    function save() {

        var dataPost = $('#formedit').serialize();

        url = '<?php echo site_url('mst_supplier/update_data') ?>';
        data = dataPost;
        pesan = 'function update data gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);

        if (dataok.msg != 'Ya') {
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        closeModal('id_modal_edit');
        tblmstsupplier.ajax.reload(null, false);

    }
</script>