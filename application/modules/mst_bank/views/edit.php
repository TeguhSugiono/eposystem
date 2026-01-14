<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>bootstrap-grid.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>styles.css">


<div class="modal-overlay active" id="id_modal_edit"> <!--style="margin-top: -18% !important;"-->
    <div class="modal medium">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fa fa-edit"></i> Edit Bank</h3>
            <button class="modal-close" onclick="closeModal('id_modal_edit')">×</button>
        </div>
        <div class="modal-body">

            <form id="formedit" class="form-horizontal" method="post" action="#">
                <input type="hidden" class="form-control form-control-sm" id="suppl_code" name="suppl_code" value="<?= $suppl_code->suppl_code; ?>">
                <input type="hidden" class="form-control form-control-sm" id="id_bank" name="id_bank" value="<?= $GetDataEdit->id_bank; ?>">

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Nama Supplier</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="suppl_name" name="suppl_name" value="<?= $suppl_code->suppl_name; ?>" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">a/n Bank</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="atas_nama" name="atas_nama" value="<?= $GetDataEdit->atas_nama; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Nama Bank</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="nama_bank" name="nama_bank" value="<?= $GetDataEdit->nama_bank; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">No Rekening</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="no_rek" name="no_rek" value="<?= $GetDataEdit->no_rek; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Cabang/Alamat</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="alamat" name="alamat" value="<?= $GetDataEdit->alamat; ?>">
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
            tblbank.ajax.reload(null, false);
            // Hapus dari DOM biar bersih (opsional)
            setTimeout(() => {
                modal.remove();
            }, 300);
        }
    }

    function save() {

        // var dataPost = $('#formedit').serialize();

        var db = "<?= $perusahaan; ?>";
        // var codesuppl = $('#suppl_code').val();

        //  + '&codesuppl=' + codesuppl

        var dataPost = $('#formedit').serialize() + '&database=' + db;

        url = '<?php echo site_url('mst_bank/update_data') ?>';
        data = dataPost;
        pesan = 'function update data gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);

        if (dataok.msg != 'Ya') {
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        closeModal('id_modal_edit');
        tblbank.ajax.reload(null, false);

    }
</script>