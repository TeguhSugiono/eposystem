<style type="text/css">
    .margin-input{margin-bottom: -2% !important;}
</style>

<div id="modal_edit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg boxshadow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Modal Title</h5>
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

                                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Cont Number</label>
                                                    <div class="col-sm-8">
                                                        <input type="hidden" class="form-control form-control-sm" id="id_cont_shifting" name="id_cont_shifting" 
                                                        value="<?=$id_cont_shifting;?>" readonly>
                                                        <input type="hidden" class="form-control form-control-sm" id="id_cont_in" name="id_cont_in" 
                                                        value="<?=$array_search[0]['id_cont_in'];?>" readonly>
                                                        <input type="text" class="form-control form-control-sm" id="cont_number" name="cont_number" 
                                                        value="<?=$array_search[0]['cont_number'];?>" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Principal Code</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm hrufbesar" id="code_principal" name="code_principal" 
                                                        value="<?=$array_search[0]['code_principal'];?>" readonly>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-sm" id="name_principal" name="name_principal" 
                                                        value="<?=$array_search[0]['name_principal'];?>" readonly>
                                                    </div>
                                                </div>
                                            </div>   

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Size/Type</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm hrufbesar" id="reff_code" name="reff_code" 
                                                        value="<?=$array_search[0]['reff_code'];?>" readonly>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-sm" id="reff_description" name="reff_description" 
                                                        value="<?=$array_search[0]['reff_description'];?>" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Date Transfer Loc</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="date_shifting" name="date_shifting" 
                                                        value="<?php echo date('d-m-Y') ?>" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Date Stripping</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="date_stripping" name="date_stripping">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Date Stuffing</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="date_stuffing" name="date_stuffing">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">New Cont Status</label>
                                                    <div class="col-sm-8">
                                                        <?=$cont_status;?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Proses</label>
                                                    <div class="col-sm-8">
                                                        <?=$change_description;?>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Old Location</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm" id="loc_block_old" name="loc_block_old" placeholder="Block" 
                                                        value="<?= $array_search[0]['block_loc']; ?>" readonly>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm" id="loc_row_old" name="loc_row_old" placeholder="Row" 
                                                        value="<?= explode(' ',$array_search[0]['location'])[0]; ?>" readonly>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm" id="loc_col_old" name="loc_col_old" placeholder="Col" 
                                                        value="<?= explode(' ',$array_search[0]['location'])[1]; ?>" readonly>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm" id="loc_stack_old" name="loc_stack_old" placeholder="Stack" 
                                                        value="<?= explode(' ',$array_search[0]['location'])[2]; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">New Location</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm" id="loc_block" name="loc_block" placeholder="Block">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm" id="loc_row" name="loc_row" placeholder="Row">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm" id="loc_col" name="loc_col" placeholder="Col">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control form-control-sm" id="loc_stack" name="loc_stack" placeholder="Stack">
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Old Seal Number</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="old_seal_number" name="old_seal_number" value="<?=$array_search[0]['old_seal_number'];?>" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">New Seal Number</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="seal_number" name="seal_number" value="<?=$array_search[0]['seal_number'];?>">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        

                                        <input type="hidden" class="form-control form-control-sm" id="xseal_number" name="xseal_number" value="<?=$array_search[0]['seal_number'];?>">
                                        
                                        
                                        
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

<div id='div_popup_search'></div>

<script type="text/javascript">  
    //$('#id_cont_shifting').prop('disabled', true);  
    $('#cont_status').prop('title', 'SilahKan Enter Untuk Merubah Status Proses..!!');

    $('.selectpicker').selectpicker();
    $('.datepicker-dropdowns').pickadate({
        selectYears: true,
        selectMonths: true,
        format: 'dd-mm-yyyy'
    });

    $("#id_cont_in").change(function() {
        //alert(this.value);
        url = '<?php echo site_url('transaksi/cont_shifting/search') ?>';
        data = {id_cont_in:this.value};
        pesan = 'JavaScript search Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        //console.log(dataok);

        $('#code_principal').val(dataok[0]['code_principal']);
        $('#name_principal').val(dataok[0]['name_principal']);
        $('#reff_code').val(dataok[0]['reff_code']);
        $('#reff_description').val(dataok[0]['reff_description']);

        $('#loc_block_old').val(dataok[0]['block_loc']);


        const myArray = dataok[0]['location'].split(" ");
        $('#loc_row_old').val(myArray[0]);
        $('#loc_col_old').val(myArray[1]);
        $('#loc_stack_old').val(myArray[2]);


    });
    
    $('#modal_edit').on('shown.bs.modal', function () {
        //$('#cont_number').focus();
    });

    $('#cont_status').on('keypress', function(e) {
        var p = e.which;
        if (p == 13) {
            $('#loc_block').focus();

            if(this.value == "Full"){
                $('#change_description').val('Stuffing');
            }else if(this.value == "Empty"){
                $('#change_description').val('Stripping');
            }else{
                $('#change_description').val('Shifting');
            }

            e.preventDefault();
        }
    });

    $('#btnsave').click(function() {

        if($('#loc_block').val() == "" || $('#loc_row').val()=="" || $('#loc_col').val()=="" || $('#loc_stack').val()==""){
            alert('Lokasi Belum Lengkap...');            
            return false;
        }

        url = '<?php echo site_url('transaksi/cont_shifting/update') ?>';
        data = $('#formedit').serialize();
        pesan = 'JavaScript update Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        console.log(dataok);
        
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);

        tbl_cont_shifting.ajax.reload(null, false);
        $('#modal_edit').modal('hide');
        
    });
    
</script>