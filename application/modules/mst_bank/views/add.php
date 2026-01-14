<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>bootstrap-grid.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>styles.css">


<div class="modal-overlay active" id="id_modal_add"> <!--style="margin-top: -18% !important;"-->
    <div class="modal medium">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fa fa-plus"></i> Add Bank</h3>
            <button class="modal-close" onclick="closeModal('id_modal_add')">×</button>
        </div>
        <div class="modal-body">

            <form id="formadd" class="form-horizontal" method="post" action="#">

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Nama Supplier</label>
                    <div class="col-sm-8">
                        <?= $suppl_code; ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">a/n Bank</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="atas_nama" name="atas_nama">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Nama Bank</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="nama_bank" name="nama_bank">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">No Rekening</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="no_rek" name="no_rek">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Cabang/Alamat</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="alamat" name="alamat">
                    </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('id_modal_add')">Batal</button>
            <button class="btn btn-primary" onclick="save()">Save</button>
        </div>
    </div>
</div>


<script type="text/javascript">
    initSelect2('id_modal_add');

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

        var db = "<?= $perusahaan; ?>";

        var dataPost = $('#formadd').serialize() + '&database=' + db;

        url = '<?php echo site_url('mst_bank/save_data') ?>';
        data = dataPost;
        pesan = 'function save data gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);


        if (dataok.msg != 'Ya') {
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        closeModal('id_modal_add');
        tblbank.ajax.reload(null, false);

    }
</script>