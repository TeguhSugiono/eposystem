
<script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/bs-select/bs-select.min.js"></script>
<div class="modal fade" id="modal_add_template" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
    <div class="modal-dialog boxshadow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalTwoLabel">Setting Template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formaddT" class="form-horizontal" method="post" action="#">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nama Template:</label>
                        <?=$thema_name;?>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnsave" id="btnsave"><b><span class="icon-save2"></span>Save</b></button>
                <button class="btn btn-primary" id="btncancel" id="btncancel" data-dismiss="modal"><b><span class="icon-cancel"></span>Cancel</b></button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">    
    $('#btnsave').click(function() {
        url = '<?php echo site_url('dashboard/update') ?>';
        data = $('#formaddT').serialize();
        pesan = 'JavaScript Save Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        $('#modal_add_template').modal('hide');
        location.reload();
    });    
</script>