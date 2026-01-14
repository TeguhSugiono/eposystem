<style type="text/css">
    .margin-input{margin-bottom: -2% !important;}
    .margin-input1{margin-bottom: -0% !important;}
</style>



<div id="modal_edit" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl boxshadow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Edit Delivery ( <?=$kode_trans;?> => <?=$operator;?> ) </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        <form id="formedit" class="form-horizontal" method="post" action="#">

                            <input type="hidden" name="kode_trans" value="<?=$kode_trans;?>"> 
                            <input type="hidden" name="no_trans" value="<?=$no_trans;?>">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row gutters">

                                        <!--- GARIS -->

                                        <div class="col-xl-5 col-lglg-5 col-md-5 col-sm-12 col-12">

                                        </div>

                                        <div class="col-xl-2 col-lglg-2 col-md-2 col-sm-12 col-12">
                                            <div class="form-group row gutters">
                                            <!-- <marquee width="100%" direction="right" height="20px" behavior='alternate'> -->
                                                <div class="note" style="font-weight: 400;color: red;font-size: 15px;text-align: center;">Data Header</div>
                                            <!-- </marquee> -->
                                            </div>                                        
                                        </div>

                                        <div class="col-xl-5 col-lglg-5 col-md-5 col-sm-12 col-12">

                                        </div>

                                        <!--- END GARIS -->


                                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">BL No</label>
                                                    <div class="col-sm-8">
                                                        <?= $txtNoDo; ?>                                                          
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-2%">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Ex Vessel</label>
                                                    <div class="col-sm-8">
                                                        <?=$txtVessel;?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:2.2%">
                                                <div class="form-group row gutters margin-input1">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">PBM</label>
                                                    <div class="col-sm-8">
                                                        <?=$txtShipper;?>
                                                    </div>
                                                </div>
                                            </div>
                                                     
                                                                         
                                            
                                        </div>


                                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                                           
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters margin-input1">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">No Mobil</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" 
                                                        id="txtNoMobil" name="txtNoMobil" value="<?=$txtNoMobil;?>" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters margin-input1">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Tgl Keluar</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" 
                                                        id="dtpOut" name="dtpOut" value="<?=showdate_dmy($dtpOut);?>" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters margin-input1">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Jam Keluar</label>
                                                    <div class="col-sm-8">
                                                        <input type="time" class="form-control form-control-sm" 
                                                        id="txtTimeOut" name="txtTimeOut" value="<?=$txtTimeOut;?>" >
                                                    </div>
                                                </div>
                                            </div>

                                            

                                        </div>

                                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters margin-input1">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Ex Seal</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" 
                                                        id="txtSealNo" name="txtSealNo" value="<?=$txtSealNo;?>" >
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters margin-input1">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Destination</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" 
                                                        id="txtDestination" name="txtDestination" value="<?=$txtDestination;?>" >
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters margin-input1">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Remarks</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" 
                                                        id="txtRemarks" name="txtRemarks" value="<?=$txtRemarks;?>" >
                                                    </div>
                                                </div>
                                            </div>                                            

                                        </div>

                                        <!--- GARIS -->
                                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                            <div class="table-container" style="width:100%"> 
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-5 col-lglg-5 col-md-5 col-sm-12 col-12">

                                        </div>

                                        <div class="col-xl-2 col-lglg-2 col-md-2 col-sm-12 col-12">
                                            <div class="form-group row gutters">
                                                <!-- <marquee width="100%" direction="right" height="20px" behavior='alternate'> -->
                                                    <div class="note" style="font-weight: 400;color: red;font-size: 15px;text-align: center;">Data Detail</div>
                                                <!-- </marquee> -->
                                            </div>                                        
                                        </div>

                                        <div class="col-xl-5 col-lglg-5 col-md-5 col-sm-12 col-12">

                                        </div>

                                        <!--- END GARIS -->

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-1.2% !important">
                                            <div class="row gutters">
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">BL No</label>
                                                        <input type="text" class="form-control" id="bl_no_input"  name="bl_no_input" value="<?=$bl_no_input;?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Consignee</label>
                                                        <input type="text" class="form-control" id="consignee_name_input" name="consignee_name_input" value="<?=$consignee_name_input;?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Ex BL</label>
                                                        <input type="text" class="form-control" id="ex_blno_input" name="ex_blno_input" value="<?=$ex_blno_input;?>" readonly>
                                                    </div>
                                                </div> 
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Category</label>
                                                        <input type="text" class="form-control" id="category_name_input" name="category_name_input" value="<?=$category_name_input;?>" readonly>
                                                    </div>
                                                </div> 
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Desc Item</label>
                                                        <input type="text" class="form-control" id="item_desc_input" name="item_desc_input" value="<?=$item_desc_input;?>" readonly>
                                                    </div>
                                                </div> 
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Code Item</label>
                                                        <input type="text" class="form-control" id="item_code_input" name="item_code_input" value="<?=$item_code_input;?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-1.2% !important">
                                            <div class="row gutters">
                                                
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Good</label>
                                                        <input type="text" class="form-control" id="good_unit_input"  name="good_unit_input" value="<?=$good_unit_input;?>" >
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Good GW</label>
                                                        <input readonly type="text" class="form-control" id="good_gross_weight_input" value="<?=$good_gross_weight_input;?>"  name="good_gross_weight_input">
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Good Volume</label>
                                                        <input readonly type="text" class="form-control" id="good_volume_input" value="<?=$good_volume_input;?>"  name="good_volume_input">
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Damage</label>
                                                        <input readonly type="text" class="form-control" id="damage_unit_input" value="<?=$damage_unit_input;?>" name="damage_unit_input">
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Damage GW</label>
                                                        <input readonly type="text" class="form-control" id="damage_gross_weight_input" value="<?=$damage_gross_weight_input;?>" name="damage_gross_weight_input">
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Damage Volume</label>
                                                        <input readonly type="text" class="form-control" id="damage_volume_input" value="<?=$damage_volume_input;?>"  name="damage_volume_input">
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>



                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row gutters">                                                
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Lokasi</label>
                                                        <input type="text" class="form-control" id="location_name_input"  
                                                        name="location_name_input" value="<?=$location_name_input?>" readonly>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Pallet ID</label>
                                                        <input type="text" class="form-control" id="palet_id_input"  name="palet_id_input" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Remarks</label>
                                                        <input type="text" class="form-control" id="remarks_input"  name="remarks_input" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <div class="form-group">
                                                        <label for="inputName">Jenis Doc</label>
                                                        <input type="text" class="form-control" id="jenis_doc_input"  name="jenis_doc_input" readonly>
                                                    </div>
                                                </div>      -->                                           
                                            </div>
                                        </div>

                                        <input type="hidden" class="form-control" id="t_stock_id"  name="t_stock_id" value="<?=$t_stock_id;?>">
                                                                                
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

    $(document).ready(function(){
        //load_edit_data();
    });

    $('.selectpicker').selectpicker();

    $('.datepicker-dropdowns').pickadate({
        selectYears: true,
        selectMonths: true,
        format: 'dd-mm-yyyy'
    });

    function load_edit_data(){
        //alert($('#txtNoDo').val()) ;

        // url = '<?php echo site_url('warehouse_transaksi/delivery/load_data_bl') ?>';
        // data = {
        //     txtNoDo:$('#txtNoDo').val(),
        //     flaginsert:'edit'            
        // }; 
        // pesan = 'JavaScript Load Data BL Error ...';
        // dataok = multi_ajax_proses(url, data, pesan);

        // console.log(dataok);

        // $('#txtSealNo').val(dataok.seal_no);
        // $('#dtpOut').val(dataok.tgl_load);
        // $('#txtTimeOut').val(dataok.jam_load);
        // $('#txtDestination').val(dataok.isidata[0][2]);

        // $('#bl_no_input').val(dataok.isidata[0][0]);
        // $('#consignee_name_input').val(dataok.isidata[0][2]+"   idtabel : "+dataok.isidata[0][1]);
        // $('#ex_blno_input').val(dataok.isidata[0][0]);
        // $('#category_name_input').val(dataok.isidata[0][4]+"   idtabel : "+dataok.isidata[0][3]);
        // $('#item_desc_input').val(dataok.isidata[0][5]);
        // $('#item_code_input').val(dataok.isidata[0][6]);
        // $('#location_name_input').val(dataok.isidata[0][16]+"   idtabel : "+dataok.isidata[0][7]);
        // $('#good_unit_input').val(dataok.isidata[0][9]);
        // $('#good_gross_weight_input').val(dataok.isidata[0][10]);
        // $('#good_volume_input').val(dataok.isidata[0][11]);
        // $('#damage_unit_input').val(dataok.isidata[0][12]);
        // $('#damage_gross_weight_input').val(dataok.isidata[0][13]);
        // $('#damage_volume_input').val(dataok.isidata[0][14]);
        // $('#t_stock_id').val(dataok.isidata[0][15]);


    }

    $("#txtNoDo").change(function() {

        

    });

    $('#btnsave').click(function() {
        url = '<?php echo site_url('warehouse_transaksi/delivery/update') ?>';
        data = $('#formedit').serialize();
        pesan = 'JavaScript Update Error...';
        dataok = multi_ajax_proses(url, data, pesan);

        console.log(dataok);
        
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        refresh_combo();
        $('#modal_edit').modal('hide');
    });
    
    
</script>