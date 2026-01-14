
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
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Shipping Line Code</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="ship_line_code" name="ship_line_code" value="<?=$array_data['ship_line_code'];?>" >
                                        </div>
                                    </div>

                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Shipping Line Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="ship_line_name" name="ship_line_name" value="<?=$array_data['ship_line_name'];?>" >
                                        </div>
                                    </div>

                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Address 1</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="address_1" name="address_1" value="<?=$array_data['address_1'];?>" >
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Address 2</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="address_2" name="address_2" value="<?=$array_data['address_2'];?>" >
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Phone Number</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?=$array_data['no_telp'];?>" >
                                        </div>
                                    </div>

                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Faxcimile Number</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="no_fax" name="no_fax" value="<?=$array_data['no_fax'];?>" >
                                            <input type="hidden" class="form-control" id="id_ship_line" name="id_ship_line"  value="<?=$array_data['id_ship_line'];?>" >
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
        url = '<?php echo site_url('master/shipping/update') ?>';
        data = $('#formedit').serialize();
        pesan = 'JavaScript Update Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        tbl_shipping.ajax.reload(null, false);
        $('#modal_edit').modal('hide');
    });    
</script>