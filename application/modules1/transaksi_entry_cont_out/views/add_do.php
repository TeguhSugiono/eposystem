


<div id="modal_add_do" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog boxshadow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add DO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <form id="formadd" class="form-horizontal" method="post" action="#">
                            <div class="card m-0">
                                <div class="card-body">
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">DO Date</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="do_date" name="do_date" >
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">DO Number</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="do_number" name="do_number" >
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
                                            <input type="text" class="form-control form-control-sm" id="vessel" name="vessel" >
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Shipper</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="shipper" name="shipper" >
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Seal Number</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="seal_number" name="seal_number" >
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Destination</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="destination" name="destination" >
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Notes</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="notes" name="notes" >
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
                                            <input type="number" class="form-control form-control-sm" id="party" name="party" >
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row gutters margin-input">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Cont Out</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="cont_out" name="cont_out" readonly>
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
    $('.selectpicker').selectpicker();
    
    $('.datepicker-dropdowns').pickadate({
        selectYears: true,
        selectMonths: true,
        format: 'dd-mm-yyyy'
    });
    
    $('#btnsave').click(function() {
        url = '<?php echo site_url('transaksi/entry_cont_out/save_do') ?>';
        data = $('#formadd').serialize();
        pesan = 'JavaScript Save Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        selectbaris_do = 0 ;        
        tbl_do_cont_out.page('first').draw(false);
        tbl_do_cont_out.ajax.reload(null, false);
        $('#modal_add_do').modal('hide');
        
    });    
</script>