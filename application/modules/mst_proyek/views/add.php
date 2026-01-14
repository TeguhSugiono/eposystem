<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>bootstrap-grid.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>styles.css">


<div class="modal-overlay active" id="id_modal_add"> <!--style="margin-top: -18% !important;"-->
    <div class="modal medium">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fa fa-plus"></i> Add Proyek</h3>
            <button class="modal-close" onclick="closeModal('id_modal_add')">×</button>
        </div>
        <div class="modal-body">

            <form id="formadd" class="form-horizontal" method="post" action="#">
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label text-end">Lokasi Proyek</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="lokasiproyek" name="lokasiproyek" required>
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
            tblmstproyek.ajax.reload(null, false);
            // Hapus dari DOM biar bersih (opsional)
            setTimeout(() => {
                modal.remove();
            }, 300);
        }
    }

    function save() {

        // var category = $("#category option:selected").text();
        // var satuan = $("#satuan option:selected").text();

        //var dataPost = $('#formadd').serialize() + '&categoryText=' + category + '&satuanText=' + satuan;
        var dataPost = $('#formadd').serialize();


        url = '<?php echo site_url('mst_proyek/save_data') ?>';
        data = dataPost;
        pesan = 'function save data gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);

        if (dataok.msg != 'Ya') {
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        closeModal('id_modal_add');
        tblmstproyek.ajax.reload(null, false);

    }
</script>