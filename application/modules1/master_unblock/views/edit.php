
<div id="modal_edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog boxshadow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <form id="formedit" class="form-horizontal" method="post" action="#">
                            <div class="card m-0">
                                <div class="card-body">
                                    
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Block Code</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="unblock_code" name="unblock_code" value="<?=$array_data['unblock_code'];?>">
                                        </div>
                                    </div>

                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Block</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="block_loc" name="block_loc" value="<?=$array_data['block_loc'];?>">
                                        </div>
                                    </div>

                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Row</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="row" name="row" value="<?=explode(" ", $array_data['location'])[0];?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Col</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="col" name="col" value="<?=explode(" ", $array_data['location'])[1];?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Stack</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="stack" name="stack" value="<?=explode(" ", $array_data['location'])[2];?>">
                                            <input type="hidden" class="form-control" id="id_unblock_location" name="id_unblock_location" value="<?=$array_data['id_unblock_location'];?>">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
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
        url = '<?php echo site_url('master/unblock/update') ?>';
        data = $('#formedit').serialize();
        pesan = 'JavaScript Update Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        tbl_unblock.ajax.reload(null, false);
        $('#modal_edit').modal('hide');
    });    
</script>