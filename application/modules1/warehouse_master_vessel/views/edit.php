<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
    <div class="modal-dialog boxshadow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalTwoLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formedit" class="form-horizontal" method="post" action="#">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Vessel Name:</label>
                        <input type="text" class="form-control" id="vessel_name" name="vessel_name" value="<?=$array_data['vessel_name'];?>">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Vessel Voyage:</label>
                        <input type="text" class="form-control" id="vessel_voyage" name="vessel_voyage" value="<?=$array_data['vessel_voyage'];?>">
                        <input type="hidden" class="form-control" id="vessel_id" name="vessel_id" value="<?=$array_data['vessel_id'];?>">
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnsave" id="btnsave"><b><span class="icon-save2"></span>Update</b></button>
                <button class="btn btn-primary" id="btncancel" id="btncancel" data-dismiss="modal"><b><span class="icon-cancel"></span>Cancel</b></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">    
    $('#btnsave').click(function() {
        url = '<?php echo site_url('warehouse_master/vessel/update') ?>';
        data = $('#formedit').serialize();
        pesan = 'JavaScript Update Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        tbl_vessel.ajax.reload(null, false);
        $('#modal_edit').modal('hide');
    });    
</script>
