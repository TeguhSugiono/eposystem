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
                <h5 class="modal-title" id="myLargeModalLabel">Edit Gate Out LCL</h5>
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
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">BRUTO</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="BRUTO" name="BRUTO" readonly
                                                        value="<?=$array_search['BRUTO'];?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">KODE_KEMAS</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="KODE_KEMAS" name="KODE_KEMAS"  readonly
                                                        value="<?=$array_search['KODE_KEMAS'];?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-12 col-12">
                                            
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
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">CONSIGNEE</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="CONSIGNEE" name="CONSIGNEE" 
                                                        value="<?=$array_search['CONSIGNEE'];?>" >
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
        url = '<?php echo site_url('transaksi/gateout_lcl/update') ?>';
        data = $('#formedit').serialize();
        pesan = 'JavaScript Update Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        tbl_gateout_lcl.ajax.reload(null, false);
        $('#modal_edit').modal('hide');
    }); 
    
</script>