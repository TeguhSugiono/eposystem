<style type="text/css">
    .margin-input{margin-bottom: -2% !important;}
    .margin-input1{margin-bottom: -0% !important;}
    .alamat{background-color: #fcf9f9 !important;}
</style>



<div id="modal_add" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl boxshadow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Input Permohonan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        <form id="formadd" class="form-horizontal" method="post" action="#">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row gutters">

                                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">No Surat</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm" id="no_surat" name="no_surat" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Tgl Eta</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="tgl_eta" name="tgl_eta">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Tgl Prm</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="tgl_prm" name="tgl_prm">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">PBM</label>
                                                    <div class="col-sm-8">                                                        
                                                        <?=$shipper_id;?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Bagian</label>
                                                    <div class="col-sm-8">                                                        
                                                        <?=$position;?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Nama PT</label>
                                                    <div class="col-sm-8">                                                        
                                                        <?=$namept;?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Alamat 1</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm alamat" id="address1" name="address1" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Alamat 2</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm alamat" id="address2" name="address2" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Alamat 3</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm alamat" id="address3" name="address3" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Alamat 4</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm alamat" id="address4" name="address4" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Lapangan</label>
                                                    <div class="col-sm-8">                                                        
                                                        <?=$lapangan;?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Sor (8064)</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm" id="sor" name="sor" onkeypress="return hanyaAngka(event)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Stock</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm" id="stock" name="stock" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Consignee</label>
                                                    <div class="col-sm-8">                                                        
                                                        <?=$othername;?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">PBM Lain</label>
                                                    <div class="col-sm-8">                                                        
                                                        <?=$otherpbm;?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Vessel</label>
                                                    <div class="col-sm-8">                                                        
                                                        <?=$vessel;?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Voyage</label>
                                                    <div class="col-sm-8">                                                        
                                                        <?=$voyage;?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Master BL</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm" id="no_mbl" name="no_mbl">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Tgl Master BL</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="tgl_master_mbl" name="tgl_master_mbl">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Jumlah Pos</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm" id="jmlpos" name="jmlpos" onkeypress="return hanyaAngka(event)">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">   
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Qty</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm" id="qty" name="qty" onkeypress="return hanyaAngka(event)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Gross Weight</label>
                                                    <div class="col-sm-8">                                                        
                                                        <input type="text" class="form-control form-control-sm" id="gross_weight" name="gross_weight" onkeypress="return hanyaAngka(event)">
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

    $("#namept").change(function() {
        url = '<?php echo site_url('warehouse_transaksi/permohonan/loadalamat') ?>';
        data = {
            namept:$('#namept').val()     
        }; 
        pesan = 'JavaScript Load Data Alamat Error ...';
        dataok = multi_ajax_proses(url, data, pesan);

        $('#address1').val(dataok.alamat[0][0]);
        $('#address2').val(dataok.alamat[0][1]);
        $('#address3').val(dataok.alamat[0][2]);
        $('#address4').val(dataok.alamat[0][3]);

        $('#lapangan').focus();


        //console.log(dataok);
    });

    $("#lapangan").change(function() {
        $('#sor').focus();
    });

    $("#sor").keyup(function() {
        //8064
        sor = this.value ;
        if(sor == ""){
            sor = 0 ;
        }

        $('#stock').val((sor*8064)/100);

    });

    // $("#txtNoDo").change(function() {

    //     url = '<?php echo site_url('warehouse_transaksi/delivery/load_data_bl') ?>';
    //     data = {
    //         txtNoDo:$('#txtNoDo').val(),
    //         flaginsert:'new'        
    //     }; 
    //     pesan = 'JavaScript Load Data BL Error ...';
    //     dataok = multi_ajax_proses(url, data, pesan);

    //     console.log(dataok);

    //     //== selectpicker
    //     $('#txtVessel').val(dataok.vessel_id);
    //     $('#txtVessel').selectpicker('refresh').trigger('change');

    //     $('#txtShipper').val(dataok.shipper_id);
    //     $('#txtShipper').selectpicker('refresh').trigger('change');
    //     //==end selectpicker

    //     $('#txtSealNo').val(dataok.seal_no);
    //     $('#dtpOut').val(dataok.tgl_load);
    //     $('#txtTimeOut').val(dataok.jam_load);
    //     $('#txtDestination').val(dataok.isidata[0][2]);

    //     $('#bl_no_input').val(dataok.isidata[0][0]);
    //     $('#consignee_name_input').val(dataok.isidata[0][2]+"   idtabel : "+dataok.isidata[0][1]);
    //     $('#ex_blno_input').val(dataok.isidata[0][0]);
    //     $('#category_name_input').val(dataok.isidata[0][4]+"   idtabel : "+dataok.isidata[0][3]);
    //     $('#item_desc_input').val(dataok.isidata[0][5]);
    //     $('#item_code_input').val(dataok.isidata[0][6]);
    //     $('#location_name_input').val(dataok.isidata[0][16]+"   idtabel : "+dataok.isidata[0][7]);
    //     $('#good_unit_input').val(dataok.isidata[0][9]);
    //     $('#good_gross_weight_input').val(dataok.isidata[0][10]);
    //     $('#good_volume_input').val(dataok.isidata[0][11]);
    //     $('#damage_unit_input').val(dataok.isidata[0][12]);
    //     $('#damage_gross_weight_input').val(dataok.isidata[0][13]);
    //     $('#damage_volume_input').val(dataok.isidata[0][14]);
    //     $('#t_stock_id').val(dataok.isidata[0][15]);

    //     $('#txtNoMobil').focus();

    //     // $('#palet_id_input').val(dataok.isidata[0][17]);
    //     // $('#remarks_input').val(dataok.isidata[0][18]);
    //     // $('#jenis_doc_input').val(dataok.isidata[0][20]);
    // });

    // $('#btnsave').click(function() {
    //     url = '<?php echo site_url('warehouse_transaksi/delivery/save') ?>';
    //     data = $('#formadd').serialize();
    //     pesan = 'JavaScript Save Error...';
    //     dataok = multi_ajax_proses(url, data, pesan);

    //     console.log(dataok);
        
    //     if(dataok.msg != 'Ya'){
    //         alert(dataok.pesan);
    //         return false;
    //     }
    //     alert(dataok.pesan);
    //     refresh_combo();
    //     $('#modal_add').modal('hide');
    // });
    
    
</script>