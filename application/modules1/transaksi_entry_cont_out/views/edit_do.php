


<div id="modal_edit_do" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog boxshadow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Edit DO</h5>
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
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">DO Date</label>
                                        <div class="col-sm-8">
                                            <input readonly type="text" class="form-control form-control-sm" id="do_date" name="do_date" value="<?= showdate_dmy($array_data['do_date']); ?>" >
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">DO Number</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="do_number" name="do_number" value="<?= $array_data['do_number']; ?>" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters" style="margin-bottom: 1.5%">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Principal Code</label>
                                        <div class="col-sm-8">
                                            <?=$code_principal;?>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Vessel/Voyage</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="vessel" name="vessel" value="<?= $array_data['vessel']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Shipper</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="shipper" name="shipper" value="<?= $array_data['shipper']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Seal Number</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="seal_number" name="seal_number" value="<?= $array_data['seal_number']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Destination</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="destination" name="destination" value="<?= $array_data['destination']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Notes</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="notes" name="notes" value="<?= $array_data['notes']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters" style="margin-bottom: 1.5%">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Size</label>
                                        <div class="col-sm-8">
                                            <?=$reff_code;?>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Amount</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control form-control-sm" id="party" name="party" value="<?= $array_data['party']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Cont Out</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="cont_out" name="cont_out" value="<?= $array_data['cont_out']; ?>" readonly>
                                            <input type="hidden" class="form-control form-control-sm" id="id_entry_do" name="id_entry_do" value="<?= $array_data['id_entry_do']; ?>" readonly>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnsave" id="btnsave"><b><span class="icon-save2"></span>Update</b></button>
                <button class="btn btn-primary" id="btncancel" id="btncancel" data-dismiss="modal"><b><span class="icon-cancel"></span>Cancel</b></button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">    
    
    $('.selectpicker').selectpicker();    
    $('#code_principal').prop('disabled', true);
    $('#reff_code').prop('disabled', true);
    
    $('#btnsave').click(function() {        
        
        // alert($('#reff_code').val());
        // return false;

        url = '<?php echo site_url('transaksi/entry_cont_out/update_do') ?>';
        data = $('#formedit').serialize()+'&reff_codex=' + $("#reff_code").val();
        console.log(data);
        pesan = 'JavaScript Update Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        console.log(dataok);
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        tbl_do_cont_out.ajax.reload(null, false);
        $('#modal_edit_do').modal('hide');
        
    });    
</script>