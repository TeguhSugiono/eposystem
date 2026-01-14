<div class="modal fade bd-example-modal-xl" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="margin-top: 1% !important;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title_general" id="myLargeModalLabel">Edit Data PLP Batal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row justify-content-center gutters">      
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <form id="formeditbatal" class="form-horizontal" method="post" action="#">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="row gutters">
                                            <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">KD_KANTOR</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"  id="KD_KANTOR"  name="KD_KANTOR" value="<?=$dataArrayTabel['KD_KANTOR'];?>"  readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">TIPE_DATA</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"  id="TIPE_DATA"  name="TIPE_DATA" value="<?=$dataArrayTabel['TIPE_DATA'];?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">KD_TPS</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"  id="KD_TPS"  name="KD_TPS" value="<?=$dataArrayTabel['KD_TPS'];?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>        
                                                
                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">REF_NUMBER</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"  id="REF_NUMBER"  name="REF_NUMBER"  value="<?=$dataArrayTabel['REF_NUMBER'];?>" readonly>
                                                        </div>
                                                    </div>
                                                </div> 

                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">NO_SURAT</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"  id="NO_SURAT"  name="NO_SURAT" value="<?=$dataArrayTabel['NO_SURAT'];?>">
                                                        </div>
                                                    </div>
                                                </div>                     
                                            </div>


                                            <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">TGL_SURAT</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm datepicker-dropdowns"  id="TGL_SURAT"  name="TGL_SURAT" value="<?=$dataArrayTabel['TGL_SURAT'];?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">NO_PLP</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"  id="NO_PLP"  name="NO_PLP" value="<?=$dataArrayTabel['NO_PLP'];?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">TGL_PLP</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm datepicker-dropdowns"  id="TGL_PLP"  name="TGL_PLP" value="<?=$dataArrayTabel['TGL_PLP'];?>">
                                                        </div>
                                                    </div>
                                                </div>        
                                                
                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">ALASAN</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"  id="ALASAN"  name="ALASAN" value="<?=$dataArrayTabel['ALASAN'];?>">
                                                        </div>
                                                    </div>
                                                </div> 

                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">NO_BC11</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"  id="NO_BC11"  name="NO_BC11" value="<?=$dataArrayTabel['NO_BC11'];?>">
                                                        </div>
                                                    </div>
                                                </div>                     
                                            </div>


                                            <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">TGL_BC11</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm datepicker-dropdowns"  id="TGL_BC11"  name="TGL_BC11" value="<?=$dataArrayTabel['TGL_BC11'];?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">NM_PEMOHON</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"  id="NM_PEMOHON"  name="NM_PEMOHON" value="<?=$dataArrayTabel['NM_PEMOHON'];?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">NO_CONT</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"  id="NO_CONT"  name="NO_CONT" value="<?=$dataArrayTabel['NO_CONT'];?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>        
                                                
                                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom: -1%">
                                                    <div class="form-group row gutters">
                                                        <label for="inputName" class="col-sm-4 col-form-label text-left">UK_CONT</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"  id="UK_CONT"  name="UK_CONT" value="<?=$dataArrayTabel['UK_CONT'];?>">
                                                        </div>
                                                    </div>
                                                </div>                    
                                            </div>
                                        </div>

                                    </div>

                                </div>


                                <input type="hidden" id="SENDING" name="SENDING" value="<?=$dataArrayTabel['SENDING'];?>">      
                            
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
    $('.datepicker-dropdowns').pickadate({
        selectYears: true,
        selectMonths: true,
        format: 'yyyy-mm-dd'
    });

    $('#btnsave').click(function() {
        url = '<?php echo site_url('batal_plp/batal_container/update') ?>';
        data = $('#formeditbatal').serialize();
        pesan = 'JavaScript Update Error...';
        dataok = multi_ajax_proses(url, data, pesan);

        if(dataok.msg != "Ya"){
            alert(dataok.pesan);
            return;
        }

        alert(dataok.pesan);
        tbl_batal_plp.ajax.reload(null, false);
        
        $('#modal_edit').modal('hide');
    });

</script>
