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
                <h5 class="modal-title" id="myLargeModalLabel">Edit Gate Out FCL</h5>
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
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">TGLDOKINOUT</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="TGL_DOK_INOUT" name="TGL_DOK_INOUT" 
                                                        value="<?= showdate_dmy($array_search['TGL_DOK_INOUT']); ?>"  >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <!-- <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">NODOKINOUT</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="NO_DOK_INOUT_EDIT" name="NO_DOK_INOUT_EDIT" 
                                                        value="<?= $array_search['NO_DOK_INOUT']; ?>"  >
                                                    </div>
                                                </div> -->

                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">NODOKINOUT</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <input value="<?= $array_search['NO_DOK_INOUT']; ?>" type="text" class="form-control form-control-sm" id="NO_DOK_INOUT_EDIT" name="NO_DOK_INOUT_EDIT" >
                                                            <div class="input-group-append">
                                                                <button title="Create Surat Jalan Pengeluaran Empty Container" class="btn btn-primary form-control-sm" type="button" id="btnCreateDoc" name="btnCreateDoc"><span class="icon-border_color"></span></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-12 col-12">
                                            
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
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">NO_POS_BC11</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="NO_POS_BC11" name="NO_POS_BC11" 
                                                        value="<?= $array_search['NO_POS_BC11']; ?>"  >
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

    $('.datepicker-dropdowns').pickadate({
        selectYears: true,
        selectMonths: true,
        format: 'dd-mm-yyyy'
    });
    
    $('#btnsave').click(function() {

        var dok = $('#NO_DOK_INOUT_EDIT').val();
        var isicont = $('#FL_CONT_KOSONG').val();

        if(dok != ""){
            var sjmba = dok.split('_')[0];

            if(sjmba == "SJMBA" && isicont == 2){
                alert('Create Ini Hanya Untuk Digunakan Create Dokumen Container Empty Out..!!');
                return ;
            }

        }

        url = '<?php echo site_url('transaksi/gateout_fcl/update') ?>';
        data = $('#formedit').serialize();
        pesan = 'JavaScript Update Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        tbl_gateout_fcl.ajax.reload(null, false);
        $('#modal_edit').modal('hide');
    }); 


    $('#btnCreateDoc').click(function() {

        if($('#TGL_DOK_INOUT').val() == ""){
            alert('TGL_DOK_INOUT Harus Diisi..!!');
            return ;
        }

        if($('#FL_CONT_KOSONG').val() == "2"){
            alert('Create Ini Hanya Untuk Digunakan Create Dokumen Container Empty Out..!!');
            return ;
        }

        url = '<?php echo site_url('transaksi/gateout_fcl/create_sj') ?>';
        data = {TGL_DOK_INOUT:$('#TGL_DOK_INOUT').val()};
        pesan = 'JavaScript create_sj Error...';
        dataok = multi_ajax_proses(url, data, pesan);

        console.log(dataok) ;

        $('#NO_DOK_INOUT_EDIT').val(dataok.nomor_SJ);
    });
    
</script>