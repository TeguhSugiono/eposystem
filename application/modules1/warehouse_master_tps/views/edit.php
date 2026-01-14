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
                        <label for="recipient-name" class="col-form-label">TPS Name:</label>
                        <input type="text" class="form-control" id="tps_name" name="tps_name" value="<?=$array_data['tps_name'];?>">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Address1:</label>
                        <input type="text" class="form-control" id="tps_address1" name="tps_address1" value="<?=$array_data['tps_address1'];?>">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Address2:</label>
                        <input type="text" class="form-control" id="tps_address2" name="tps_address2" value="<?=$array_data['tps_address2'];?>">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Address3:</label>
                        <input type="text" class="form-control" id="tps_address3" name="tps_address3" value="<?=$array_data['tps_address3'];?>">
                        <input type="hidden" class="form-control" id="tps_id" name="tps_id" value="<?=$array_data['tps_id'];?>">
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
        url = '<?php echo site_url('warehouse_master/tps/update') ?>';
        data = $('#formedit').serialize();
        pesan = 'JavaScript Update Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        tbl_tps.ajax.reload(null, false);
        $('#modal_edit').modal('hide');
    });    
</script>
