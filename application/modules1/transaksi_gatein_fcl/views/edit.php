<style type="text/css">
    .fontfcl{
        font-size: 13px;
    }
</style>


<!-- <div id="modal_edit" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl boxshadow"> -->
<div id="modal_edit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg boxshadow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Edit Gate In FCL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        <form id="formedit" class="form-horizontal" method="post" action="#">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row gutters">

                                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-12 col-12">
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">REF_NUMBER</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="REF_NUMBER" name="REF_NUMBER" 
                                                        value="<?= $array_search['REF_NUMBER']; ?>"  readonly>
                                                    </div>
                                                </div>
                                            </div>     

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">NO_CONT</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="NO_CONT" name="NO_CONT" 
                                                        value="<?=$array_search['NO_CONT'];?>" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">KD_DOK</label>
                                                    <div class="col-sm-8">
                                                        <?=$jenis_export_import;?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">JNS_CONT</label>
                                                    <div class="col-sm-8">
                                                        <?= $JNS_CONT; ?>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">KD_DOK_INOUT</label>
                                                    <div class="col-sm-8">
                                                        <?= $jenis_document; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                        </div>

                                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-12 col-12">
                                            
                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">STATUS</label>
                                                    <div class="col-sm-8">
                                                        <?= $FL_CONT_KOSONG; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">BRUTO</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="BRUTO" name="BRUTO" 
                                                        value="<?=$array_search['BRUTO'];?>" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">ID_CONSIGNEE</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="ID_CONSIGNEE" name="ID_CONSIGNEE" 
                                                        value="<?=$array_search['ID_CONSIGNEE'];?>" >
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">CONSIGNEE</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="CONSIGNEE" name="CONSIGNEE" 
                                                        value="<?=$array_search['CONSIGNEE'];?>" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">NO_POS_BC11</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="NO_POS_BC11" name="NO_POS_BC11" 
                                                        value="<?=$array_search['NO_POS_BC11'];?>" >
                                                    </div>
                                                </div>
                                            </div>

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
    
    $('#btnsave').click(function() {
        url = '<?php echo site_url('transaksi/gatein_fcl/update') ?>';
        data = $('#formedit').serialize();
        pesan = 'JavaScript Update Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        tbl_gatein_fcl.ajax.reload(null, false);
        $('#modal_edit').modal('hide');
    }); 
    
</script>