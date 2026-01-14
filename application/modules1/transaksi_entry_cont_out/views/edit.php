<style type="text/css">
    .margin-input{margin-bottom: -2% !important;}
</style>

<div id="modal_edit" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl boxshadow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Edit Entry Container Out</h5>
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
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">DO Number</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="do_number" name="do_number" value="<?= $array_search['do_number']; ?>" readonly>                                                        
                                                    </div>
                                                </div>
                                            </div>    
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">No Transaksi</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <input readonly type="text" class="form-control form-control-sm" title="Ketik No Transaksi Kemudian Enter!! atau cari melalui tombol disamping" id="No_Transaksi" name="No_Transaksi" value="<?= $array_search['No_Transaksi']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Container No</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <input readonly type="text" title="Ketik No Container Kemudian Enter!! atau cari melalui tombol disamping" class="form-control form-control-sm hrufbesar" id="cont_number" name="cont_number" 
                                                            value="<?= $array_search['cont_number']; ?>" >

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Bon Muat</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" value="<?= $array_search['bon_muat_number']; ?>" id="bon_muat_number" name="bon_muat_number" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Principal Code</label>
                                                    <div class="col-sm-2">
                                                        <input readonly onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm hrufbesar" id="code_principal" name="code_principal" value="<?= $array_search['code_principal']; ?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-sm" value="<?= $array_search['name_principal']; ?>" id="name_principal" name="name_principal" readonly>
                                                    </div>
                                                </div>
                                            </div>   

                                                                                 
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Size/Type</label>
                                                    <div class="col-sm-2">
                                                        <input readonly value="<?= $array_search['reff_code']; ?>" onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm hrufbesar" id="reff_code" name="reff_code" >
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input value="<?= $array_search['reff_description']; ?>" type="text" class="form-control form-control-sm" id="reff_description" name="reff_description" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Date In</label>
                                                    <div class="col-sm-8">
                                                        <input value="<?= showdate_dmy($array_search['cont_date_in']); ?>" type="text" readonly class="form-control form-control-sm" id="cont_date_in" name="cont_date_in">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Date Out</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="cont_date_out" 
                                                        name="cont_date_out" value="<?= showdate_dmy($array_search['cont_date_out']); ?>" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Time Out</label>
                                                    <div class="col-sm-8">
                                                        <input type="time" class="form-control form-control-sm" id="cont_time_out" name="cont_time_out" 
                                                         value="<?= date('H:i',strtotime($array_search['cont_time_out'])); ?>" >
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
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Seal Number</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="seal_number" name="seal_number" 
                                                        value="<?= $array_search['seal_number']; ?>" >
                                                    </div>
                                                </div>
                                            </div>                                           
                                            
                                        </div>

                                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-12 col-12">

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Truck No</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="truck_number" name="truck_number" 
                                                        value="<?= $array_search['truck_number']; ?>" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Driver Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="driver_name" name="driver_name" 
                                                        value="<?= $array_search['driver_name']; ?>" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Party</label>
                                                    <div class="col-sm-3">
                                                        <div class="input-group">
                                                            <input type="text" value="<?= $array_search['r_party']; ?>" class="form-control form-control-sm" id="r_party" 
                                                            name="r_party"  readonly>
                                                            <label for="inputName" class="col-form-label">&nbsp;/&nbsp;</label>
                                                            <input type="text" value="<?= $array_search['party']; ?>" class="form-control form-control-sm" id="party" 
                                                            name="party" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Destination</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="destination" name="destination" 
                                                        value="<?= $array_search['destination']; ?>" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Shipper</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="shipper" name="shipper" 
                                                        value="<?= $array_search['shipper']; ?>" >
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
                                                        <input type="text" title="Block" class="form-control form-control-sm" id="loc_block" name="loc_block" placeholder="Block" 
                                                        value="<?= $array_search['block_loc']; ?>" >
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" title="Row" class="form-control form-control-sm" id="loc_row" name="loc_row" placeholder="Row" 
                                                        value="<?= explode(' ',$array_search['location'])[0]; ?>" >
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" title="Col" class="form-control form-control-sm" id="loc_col" name="loc_col" placeholder="Col" 
                                                        value="<?= explode(' ',$array_search['location'])[1]; ?>" >
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" title="Stack" class="form-control form-control-sm" id="loc_stack" name="loc_stack" placeholder="Stack" 
                                                        value="<?= explode(' ',$array_search['location'])[2]; ?>" >
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Shipping Lines</label>
                                                    <div class="col-sm-2">
                                                        <input readonly type="text" class="form-control form-control-sm hrufbesar" id="ship_line_code" name="ship_line_code" 
                                                        value="<?= $array_search['ship_line_code']; ?>" >
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-sm" id="ship_line_name" name="ship_line_name" 
                                                        value="<?= $array_search['ship_line_name']; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                                                                       

                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Notes</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" id="notes" name="notes" 
                                                        maxlength="140" rows="3"><?= $array_search['notes'];?></textarea>
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

<div id='div_popup_search'></div>

<script type="text/javascript">    

    var id_cont_out = "<?=$id_cont_out;?>" ;
    
    $('.datepicker-dropdowns').pickadate({
        selectYears: true,
        selectMonths: true,
        format: 'dd-mm-yyyy'
    });
    
    $('#modal_edit').on('shown.bs.modal', function () {
        $('#code_principal').focus();
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
            
        }
    }

    
    $('#btnsave').click(function() {
        var cek_container = cek_data(false);

        if (cek_container == false) {
            return false;
        }

        
        url = '<?php echo site_url('transaksi/entry_cont_out/update') ?>';
        data = $('#formedit').serialize()+'&id_cont_out=' + id_cont_out;
        pesan = 'JavaScript Save Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        console.log(dataok);
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }
        alert(dataok.pesan);

        tbl_entry_cont_out.ajax.reload(null, false);
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


        /**********************************/
        var datein = $('#cont_date_in').val() ;
        var dayfield = datein.split("-")[0] ;
        var monthfield = datein.split("-")[1] ; 
        var yearfield = datein.split("-")[2] ;
        var dateout_ymd = yearfield+"-"+monthfield+"-"+dayfield ;
        if($("#code_principal").val() == "TPP" || $("#code_principal").val() == "PJT" || $("#code_principal").val() =="TPS"){
            url = '<?php echo site_url('search/cek_lock_gate') ?>';
            data = {cont_number:$("#cont_number").val(),code_principal:$("#code_principal").val(),cont_date_in:dateout_ymd};
            pesan = 'JavaScript cek_lock_gate Error...';
            dataok1 = multi_ajax_proses(url, data, pesan);

            console.log(dataok1);             

            if(dataok1.msg != "Ya"){
                alert(dataok1.pesan);
                return false;
            }

            url = '<?php echo site_url('search/cek_lock_segel') ?>';
            data = {cont_number:$("#cont_number").val(),code_principal:$("#code_principal").val(),cont_date_in:dateout_ymd};
            pesan = 'JavaScript cek_lock_segel Error...';
            dataok2 = multi_ajax_proses(url, data, pesan);

            console.log(dataok2);             

            if(dataok2.msg != "Ya"){
                alert(dataok2.pesan);
                return false;
            }
        }
        /**********************************/
        
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