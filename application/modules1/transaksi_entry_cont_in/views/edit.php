<div id="modal_edit" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl boxshadow">
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

                                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-12 col-12">
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Bon Bongkar No</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="bon_bongkar_number" name="bon_bongkar_number"  value="<?= $array_search['bon_bongkar_number']; ?>" readonly>
                                                        <input type="hidden" class="form-control form-control-sm" id="eir_r_number" name="eir_r_number"  value="<?= $array_search['eir_in']; ?>" readonly>
                                                        <input type="hidden" class="form-control form-control-sm" id="id_cont_in" name="id_cont_in"  value="<?= $array_search['id_cont_in']; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>     
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Container No</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm hrufbesar" id="cont_number" name="cont_number" value="<?= $array_search['cont_number']; ?>">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary form-control-sm" type="button" id="btncontainer" name="btncontainer"><span class="icon-search"></span></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Principal Code</label>
                                                    <div class="col-sm-2">
                                                        <input onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm hrufbesar" id="code_principal" name="code_principal" value="<?= $array_search['code_principal']; ?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-sm" id="name_principal" name="name_principal" value="<?= $array_search['name_principal']; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>                                         
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Size/Type</label>
                                                    <div class="col-sm-2">
                                                        <input onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm hrufbesar" id="reff_code" name="reff_code" value="<?= $array_search['reff_code']; ?>" >
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-sm" id="reff_description" name="reff_description" value="<?= $array_search['reff_description']; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Date In</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="cont_date_in" name="cont_date_in" value="<?= showdate_dmy($array_search['cont_date_in']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Time In</label>
                                                    <div class="col-sm-8">
                                                        <input type="time" class="form-control form-control-sm" id="cont_time_in" name="cont_time_in" value="<?= date('H:i',strtotime($array_search['cont_time_in'])); ?>" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Vessel/Voyage</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="vessel" name="vessel" value="<?= $array_search['vessel']; ?>" >
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Truck No</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="truck_number" name="truck_number" value="<?= $array_search['truck_number']; ?>" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Driver Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="driver_name" name="driver_name" value="<?= $array_search['driver_name']; ?>" >
                                                    </div>
                                                </div>
                                            </div>
                                               
                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Seal Number</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="seal_number" name="seal_number" value="<?= $array_search['seal_number']; ?>" >
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Bruto</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="bruto" name="bruto" value="<?= str_replace('.00','', $array_search['bruto']); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">No EIR</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="no_eir" name="no_eir" value="<?= $array_search['no_eir']; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Date EIR</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="tgl_eir" name="tgl_eir" value="<?= showdate_dmy($array_search['tgl_eir']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-12 col-12">
                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Shipper</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="shipper" name="shipper" value="<?= $array_search['shipper']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Condition</label>
                                                    <div class="col-sm-8">
                                                        <?= $cont_condition; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Status</label>
                                                    <div class="col-sm-8">
                                                        <?= $cont_status; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Stock Location</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" title="Block" class="form-control form-control-sm" id="loc_block" name="loc_block" placeholder="Block" value="<?= $array_search['block_loc']; ?>">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" title="Row" class="form-control form-control-sm" id="loc_row" name="loc_row" placeholder="Row" value="<?= explode(' ',$array_search['location'])[0]; ?>" >
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" title="Col" class="form-control form-control-sm" id="loc_col" name="loc_col" placeholder="Col" value="<?= explode(' ',$array_search['location'])[1]; ?>" >
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" title="Stack" class="form-control form-control-sm" id="loc_stack" name="loc_stack" placeholder="Stack" value="<?= explode(' ',$array_search['location'])[2]; ?>">
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Shipping Lines</label>
                                                    <div class="col-sm-2">
                                                        <input onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm hrufbesar" id="ship_line_code" name="ship_line_code" value="<?= $array_search['ship_line_code']; ?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-sm" id="ship_line_name" name="ship_line_name" 
                                                        value="<?= $array_search['ship_line_name']; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Invoice In</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="invoice_in" name="invoice_in" value="<?= $array_search['invoice_in']; ?>" >
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">CSC Plate</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="plate" name="plate" value="<?= $array_search['plate']; ?>" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Clean Type</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="clean_type" name="clean_type" value="<?= $array_search['clean_type']; ?>" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Clean Date</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" value="<?= showdate_dmy($array_search['clean_date']); ?>" class="form-control form-control-sm datepicker-dropdowns" id="clean_date" name="clean_date" >
                                                    </div>
                                                </div>
                                            </div>

                                            

                                            

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">BC Code</label>
                                                    <div class="col-sm-2">
                                                        <input onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm hrufbesar" id="bc_code" name="bc_code" value="<?= $array_search['bc_code']; ?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" value="<?= $array_search['bc_name']; ?>" class="form-control form-control-sm" id="bc_name" name="bc_name" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Dangers</label>
                                                    <div class="col-sm-8">
                                                        <?= $dangers_goods; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Notes</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" id="notes" name="notes" maxlength="140" rows="3"><?= $array_search['notes']; ?></textarea>
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

<div id='div_popup_search'></div>

<script type="text/javascript">    
    
    $('.datepicker-dropdowns').pickadate({
        selectYears: true,
        selectMonths: true,
        format: 'dd-mm-yyyy'
    });
    
    $('#modal_add').on('shown.bs.modal', function () {
        $('#cont_number').focus();
    });

    
    function KeyPressEnter(event, IdElement) {
        if (event.keyCode == 13) {
            
            if (IdElement == "code_principal") {
                url = '<?php echo site_url('transaksi/entry_cont_in/search') ?>';
                data = {
                    nm_table:'t_m_principal',
                    param_field:'code_principal',
                    param_value:$('#code_principal').val(),
                    search_data:'name_principal',
                };
                pesan = 'JavaScript Search Error...';
                dataok = multi_ajax_proses(url, data, pesan);
                
                $('#name_principal').val(dataok.getvalue);
            }
            
            if (IdElement == "reff_code") {
                url = '<?php echo site_url('transaksi/entry_cont_in/search') ?>';
                data = {
                    nm_table:'t_m_refference',
                    param_field:'reff_code',
                    param_value:$('#reff_code').val(),
                    search_data:'reff_description',
                };
                pesan = 'JavaScript Search Error...';
                dataok = multi_ajax_proses(url, data, pesan);
                
                $('#reff_description').val(dataok.getvalue);
            }
            
            if (IdElement == "ship_line_code") {
                url = '<?php echo site_url('transaksi/entry_cont_in/search') ?>';
                data = {
                    nm_table:'t_m_shipping_lines',
                    param_field:'ship_line_code',
                    param_value:$('#ship_line_code').val(),
                    search_data:'ship_line_name',
                };
                pesan = 'JavaScript Search Error...';
                dataok = multi_ajax_proses(url, data, pesan);
                
                $('#ship_line_name').val(dataok.getvalue);
            }
            
            if (IdElement == "bc_code") {
                url = '<?php echo site_url('transaksi/entry_cont_in/search') ?>';
                data = {
                    nm_table:'t_m_beacukaicode',
                    param_field:'bc_code',
                    param_value:$('#bc_code').val(),
                    search_data:'bc_name',
                };
                pesan = 'JavaScript Search Error...';
                dataok = multi_ajax_proses(url, data, pesan);
                
                $('#bc_name').val(dataok.getvalue);
            }
            
        }
    }
    
    
    $('#btncontainer').click(function() {
        $.post('<?php echo site_url() ?>search', {
            param_db: 'db',
            param_form: 'search_container_tpsonline',
        },
        function(xx) {
            $('#div_popup_search').html(xx);
            $("#modal_formsearch").modal({
                show: true,
                backdrop: 'static',
            });
            $('.modal-title_general').text('Form Search Container TPSOnline');
        });
    });
    
    $('#btnsave').click(function() {
        var cek_container = cek_data(false);

        if (cek_container == false) {
            return false;
        }

        url = '<?php echo site_url('transaksi/entry_cont_in/update') ?>';
        data = $('#formedit').serialize();
        pesan = 'JavaScript Update Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        console.log(dataok);
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);
        tbl_entry_cont_in.ajax.reload(null, false);
        $('#modal_edit').modal('hide');
    });    
    
    function cek_data(booleandata) {
        var cdata = new Boolean(true);
        if ($("#cont_number").val() == '') {
            alert("Nomor Container belum diisi");
            $("#cont_number").focus();
            return false;
        } else {
            var cek_nocont = validasi_container(false);
            if (cek_nocont == false) {
                $("#cont_number").focus();
                return false;
            }
        }
        if($("#code_principal").val() == "" || $("#name_principal").val() == ""){
            alert('Principal Belum Lengkap..!!');
            $("#code_principal").focus();
            return false;
        }
        
        if($("#truck_number").val() == "" ){
            alert('Truck Number Belum Lengkap..!!');
            $("#truck_number").focus();
            return false;
        }

        if($("#driver_name").val() == "" ){
            alert('Nama Driver Belum Lengkap..!!');
            $("#driver_name").focus();
            return false;
        }
        
        $cont_number_old = '<?=$array_search['cont_number'];?>' ;
        if($cont_number_old != $('#cont_number').val()){
            url = '<?php echo site_url('transaksi/entry_cont_in/search') ?>';
            data = {
                nm_table:'t_t_stock',
                param_field:'cont_number',
                param_value:$('#cont_number').val(),
                search_data:'cont_number',
            };
            pesan = 'JavaScript Search Error...';
            dataok = multi_ajax_proses(url, data, pesan);

            console.log(dataok.getvalue);

            if(dataok.getvalue !== undefined){
                if(dataok.getvalue != ""){
                    alert('Container Sudah Ada Dalam Stock..!!');
                    $("#cont_number").focus();
                    return false;
                }
            }
        }
            
        
        return cdata;
    }
    
    function validasi_container(booleandata) {
        var cdata = new Boolean(true);
        var cont = $("#cont_number").val();
        if (cont.length != 12) {
            alert('Panjang Karakter Nomor Container Tidak Sesuai');
            return false;
        }
        if (cont.substr(4, 1) != ' ') {
            alert('Format Nomor Container Tidak Sesuai');
            return false;
        }
        if (!cekhuruf(cont.substr(0, 5))) {
            alert('Format huruf 4 digit depan nomor Container Tidak Sesuai');
            return false;
        }
        if (!cekangka(cont.substr(5, 7))) {
            alert('Format angka 7 digit belakang nomor Container Tidak Sesuai');
            return false;
        }        
        return cdata;
    }

    function cekhuruf(huruf) {
        re = /^[A-Za-z ]{1,}$/;
        return re.test(huruf);
    }

    function cekangka(angka) {
        var regex = /^[0-9]+$/;
        var filter = new RegExp(regex, 'g');
        var found = filter.test(angka);
        if (!found) {
            return false;
        } else {
            return true;
        }
    }
    
</script>