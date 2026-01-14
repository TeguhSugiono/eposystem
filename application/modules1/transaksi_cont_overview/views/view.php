<style>        
    .dataout {background-color: yellow !important;}
    .margin-input{margin-bottom: -2.5% !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Transaction</li>
        <li class="breadcrumb-item active">..::: Container Overview :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >

            <div class="card">
                <div class="card-body boxshadow">

                    <div class="row gutters border" style="padding-top:0.6%;margin-bottom: -0%;">
                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                            <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12" style="margin-bottom: -1%;">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-12 col-form-label text-left hrufbesar" style="font-size: 20px;font-weight: 400;">Search Data...</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12" style="margin-bottom: -1%;">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Cont Number</label>
                                    <div class="col-sm-8">
                                        <input type="text" onkeypress="KeyPressEnter(event,this.id)" class="form-control form-control-sm hrufbesar" id="cont_number" name="border-right">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Principal Code</label>
                                    <div class="col-sm-2">
                                        <input onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm hrufbesar" id="code_principal" name="code_principal">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-sm" id="name_principal" name="name_principal" readonly>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>

                    <div style="border-top: 5px double black; margin-top: 1em; padding-top: 1em;"> </div>
                    <!--
                        dotted : Putus-putus kecil /burik dengan tebal garis 2px
                        solid : Garis padat dengan tebal garis 2px
                        double : Garis ganda dengan tebal garis 6px
                        groove : Alur dengan tebal garis 6px
                        ridge : punggungan dengan tebal garis 6px
                    -->
                    
                        <div class="row gutters border">

                            <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12 border">
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-12 col-form-label text-center" style="font-size: 20px;font-weight: 400;">DATA IN</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Vessel</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="vessel" name="vessel" readonly>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Shipper</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="shipper" name="shipper" readonly>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Truck No</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="truck_number" name="truck_number" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Driver Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="driver_name" name="driver_name" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Size/Type</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="reff_code" name="reff_code" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Condition</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="cont_condition" name="cont_condition" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Status</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="cont_status" name="cont_status" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Date IN</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="cont_date_in" name="cont_date_in" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Cont Time IN</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="cont_time_in" name="cont_time_in" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Stock Location</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="stock_location" name="stock_location" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Invoice In</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="invoice_in" name="invoice_in" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">CSC Plate</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="plate" name="plate" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Clean Type</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="clean_type" name="clean_type" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Clean Date</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="clean_date" name="clean_date" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Shipping Lines</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="ship_line_name" name="ship_line_name" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12 border" style="padding-top: 0.1%;">
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-12 col-form-label text-center" style="font-size: 20px;font-weight: 400;">Last Shifting</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Shifting Date</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="date_shifting" name="date_shifting" readonly>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Date Stripping</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="date_stripping" name="date_stripping" readonly>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Date Stuffing</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="date_stuffing" name="date_stuffing" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Cont Status</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="new_cont_status" name="new_cont_status" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Cont Last Loc</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="new_location" name="new_location" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12 border" style="padding-top: 0.1%;">
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-12 col-form-label text-center" style="font-size: 20px;font-weight: 400;">DATA OUT</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Vessel</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="vessel_out" name="vessel_out" readonly>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Shipper</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="shipper_out" name="shipper_out" readonly>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Truck No</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="truck_number_out" name="truck_number_out" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Driver Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="driver_name_out" name="driver_name_out" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Condition</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="cont_condition_out" name="cont_condition_out" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Status</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="cont_status_out" name="cont_status_out" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Date Out</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="cont_date_out" name="cont_date_out" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Cont Time Out</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="cont_time_out" name="cont_time_out" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Delivery Order</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="do_number" name="do_number" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Destination</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="destination" name="destination" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Seal No</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="seal_number" name="seal_number" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Notes</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="notes" name="notes" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Days Storage</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-sm" id="days_storage" name="days_storage" readonly>
                                        </div>                                    
                                        <label for="inputName" class="col-sm-2 col-form-label text-left">Days</label>
                                    </div>
                                </div>                                
                            </div>

                        </div>
         

                    

                </div>
            </div>

        </div>



    </div>
</div>



<script src="<?= site_url(); ?>assets/js/jquery.min.js"></script>


<script type="text/javascript">
    
    function KeyPressEnter(event, IdElement) {
        if (event.keyCode == 13) { 
            if (IdElement == "cont_number") {
                url = '<?php echo site_url('transaksi/cont_overview/search') ?>';
                data = {cont_number:$('#cont_number').val(),code_principal:$('#code_principal').val()};
                pesan = 'JavaScript Search Error...';
                dataok = multi_ajax_proses(url, data, pesan);

                //console.log(dataok);
                if(dataok.msg != "Ya"){
                    alert(dataok.pesan);
                    return false;
                }

                $('#code_principal').focus();
            }

            if (IdElement == "code_principal") {
                url = '<?php echo site_url('transaksi/cont_overview/search') ?>';
                data = {cont_number:$('#cont_number').val(),code_principal:$('#code_principal').val()};
                pesan = 'JavaScript Search Error...';
                dataok = multi_ajax_proses(url, data, pesan);
                console.log(dataok);
                
                if(dataok.msg != "Ya"){
                    alert(dataok.pesan);
                    return false;
                }


                $('#name_principal').val(dataok['array_search'][0]['name_principal']);



                $('#vessel').val(dataok['array_search'][0]['vessel']);
                $('#shipper').val(dataok['array_search'][0]['shipper']);
                $('#truck_number').val(dataok['array_search'][0]['truck_number']);
                $('#driver_name').val(dataok['array_search'][0]['driver_name']);
                $('#reff_code').val(dataok['array_search'][0]['reff_code']);
                $('#cont_condition').val(dataok['array_search'][0]['cont_condition']);
                $('#cont_status').val(dataok['array_search'][0]['cont_status']);
                $('#cont_date_in').val(dataok['array_search'][0]['cont_date_in2']);
                $('#cont_time_in').val(dataok['array_search'][0]['cont_time_in']);
                $('#stock_location').val(dataok['array_search'][0]['block_loc']+" "+dataok['array_search'][0]['location']);
                $('#invoice_in').val(dataok['array_search'][0]['invoice_in']);
                $('#plate').val(dataok['array_search'][0]['plate']);
                $('#clean_type').val(dataok['array_search'][0]['clean_type']);
                $('#clean_date').val(dataok['array_search'][0]['clean_date']);
                $('#ship_line_name').val(dataok['array_search'][0]['ship_line_name']);

                
                $('#date_shifting').val(dataok['array_search_stock'][0]['date_shifting2']);
                $('#date_stripping').val(dataok['array_search_stock'][0]['date_stripping2']);
                $('#date_stuffing').val(dataok['array_search_stock'][0]['date_stuffing2']);
                $('#new_cont_status').val(dataok['array_search_stock'][0]['cont_status']);
                $('#new_location').val(dataok['array_search_stock'][0]['block_loc']+" "+dataok['array_search_stock'][0]['location']);


                $('#cont_date_out').val(dataok['array_search_stock'][0]['cont_date_out2']);
                $('#days_storage').val(dataok['array_search_stock'][0]['days_storage']);

                $('#vessel_out').val(dataok['array_search_out'][0]['vessel']);
                $('#shipper_out').val(dataok['array_search_out'][0]['shipper']);
                $('#truck_number_out').val(dataok['array_search_out'][0]['truck_number']);
                $('#driver_name_out').val(dataok['array_search_out'][0]['driver_name']);
                $('#cont_condition_out').val(dataok['array_search_out'][0]['cont_condition']);
                $('#cont_status_out').val(dataok['array_search_out'][0]['cont_status']);                
                $('#cont_time_out').val(dataok['array_search_out'][0]['cont_time_out']);
                $('#do_number').val(dataok['array_search_out'][0]['do_number']);
                $('#destination').val(dataok['array_search_out'][0]['destination']);
                $('#seal_number').val(dataok['array_search_out'][0]['seal_number']);
                $('#notes').val(dataok['array_search_out'][0]['notes']);
                
            }
        }
    }
    
</script>