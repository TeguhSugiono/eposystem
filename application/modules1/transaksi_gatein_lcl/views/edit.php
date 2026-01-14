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
                <h5 class="modal-title" id="myLargeModalLabel">Edit Gate In LCL</h5>
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
                                                        <input type="text" class="form-control form-control-sm" id="CONT_ASAL" name="CONT_ASAL" 
                                                        value="<?=$array_search['CONT_ASAL'];?>" readonly>
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
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">KDDOK_INOUT</label>
                                                    <div class="col-sm-8">
                                                        <?= $jenis_document; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">NO_BL_AWB</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="NO_BL_AWB" name="NO_BL_AWB" 
                                                        value="<?=$array_search['NO_BL_AWB'];?>">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">BRUTO</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="BRUTO" name="BRUTO" 
                                                        value="<?=$array_search['BRUTO'];?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">KODE_KEMAS</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="KODE_KEMAS" name="KODE_KEMAS" 
                                                        value="<?=$array_search['KODE_KEMAS'];?>">
                                                    </div>
                                                </div>
                                            </div>


                                            

                                            
                                        </div>

                                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-12 col-12">

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">WK_IN_DATE</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="WK_INOUT_DATE" name="WK_INOUT_DATE" 
                                                        value="<?=showdate_dmy(substr($array_search['WK_INOUT'],0,10));?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">WK_IN_TIME</label>
                                                    <div class="col-sm-8">
                                                        <input type="time" class="form-control form-control-sm" id="WK_INOUT_TIME" name="WK_INOUT_TIME" 
                                                        value="<?=substr($array_search['WK_INOUT'],11,5);?>" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">NO_POS_BC11</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="NO_POS_BC11_EDIT" name="NO_POS_BC11_EDIT" 
                                                        value="<?=$array_search['NO_POS_BC11'];?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">CALL_SIGN</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="CALL_SIGN" name="CALL_SIGN" 
                                                        value="<?=$array_search['CALL_SIGN'];?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">NO_BC11</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="NO_BC11" name="NO_BC11" 
                                                        value="<?=$array_search['NO_BC11'];?>">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">TGL_BC11</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="TGL_BC11" name="TGL_BC11" 
                                                        value="<?=showdate_dmy($array_search['TGL_BC11']);?>">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">NODOK_INOUT</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="NO_DOK_INOUT_EDIT" name="NO_DOK_INOUT_EDIT" 
                                                        value="<?=$array_search['NO_DOK_INOUT'];?>">
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

        var NO_POS_BC11_EDIT = $('#NO_POS_BC11_EDIT').val() ; 
        if(NO_POS_BC11_EDIT == "" || NO_POS_BC11_EDIT.length != 12 || NO_POS_BC11_EDIT == "000000000000" ){
            alert('NO_POS_BC11 Harus Sesuai format 11 digit / Salah ...!!') ;
            $("#NO_POS_BC11_EDIT").focus();
            return ;
        }

        var CALL_SIGN = $('#CALL_SIGN').val() ; 
        if(CALL_SIGN == ""){
            alert('CALL_SIGN Tidak Boleh Kosong ...!!');
            $("#CALL_SIGN").focus();
            return ;
        }

        var NO_BC11 = $('#NO_BC11').val() ; 
        if(NO_BC11 == "" || NO_BC11 == "000000" || NO_BC11.length != 6){
            alert('NO_BC11 Tidak Boleh Kosong / Salah ...!!');
            $("#NO_BC11").focus();
            return ;
        }

        var TGL_BC11 = $('#TGL_BC11').val() ; 
        if(TGL_BC11 == "" ){
            alert('TGL_BC11 Tidak Boleh Kosong ...!!');
            $("#TGL_BC11").focus();
            return ;
        }

        var NO_DOK_INOUT = $('#NO_DOK_INOUT_EDIT').val() ; 
        if(NO_DOK_INOUT == "" ){
            alert('NO_DOK_INOUT Tidak Boleh Kosong ...!!');
            $("#NO_DOK_INOUT_EDIT").focus();
            return ;
        }


        url = '<?php echo site_url('transaksi/gatein_lcl/update') ?>';
        data = $('#formedit').serialize();
        pesan = 'JavaScript Update Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        tbl_gatein_lcl.ajax.reload(null, false);
        $('#modal_edit').modal('hide');
    }); 
    
</script>