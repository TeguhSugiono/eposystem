<style>        
    .validate {background-color: white !important;}
    .notvalidate {background-color: #e5e7eb !important;}
    .margin-input{margin-bottom: -2% !important;}
    .boldp{font-weight: 700;}
    .dataTables_filter{display: block; !important;}
    .card .card-header {padding: 1rem 1.25rem 0rem 1.25rem;}
    .card .card-body {padding: 0.3rem 1.25rem;}
    .font-size-control{font-size: 11px !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Warehouse</li>
        <li class="breadcrumb-item">Transaction</li>
        <li class="breadcrumb-item active">..::: Delivery :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="card">
                <div class="card-body boxshadow">

                    <div class="row gutters border" style="padding-top:0.6%;margin-bottom: -0%;">

                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">

                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-5 col-form-label text-left">Tanggal Keluar</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control datepicker-dropdowns" id="tgl_out"  name="tgl_out" value=<?=$startdate;?> >
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-5 col-form-label text-left">s/d</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control datepicker-dropdowns" id="tgl_out_end"  name="tgl_out_end" value=<?=$enddate;?> >
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-5 col-form-label text-left">No BL</label>
                                    <div class="col-sm-7">
                                        <?=$bl_no;?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-5 col-form-label text-left">Operator</label>
                                    <div class="col-sm-7">
                                        <?=$kode_trans;?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">


                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-5 col-form-label text-left">PBM / Forwarder</label>
                                    <div class="col-sm-7">
                                        <?=$shipper_id;?>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-5 col-form-label text-left">Consignee Name</label>
                                    <div class="col-sm-7">
                                        <?=$consignee_id;?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-5 col-form-label text-left">Destination</label>
                                    <div class="col-sm-7">
                                        <?=$destination;?>
                                    </div>
                                </div>
                            </div>

                            
                        </div>

                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-5 col-form-label text-left">NO Mobil</label>
                                    <div class="col-sm-7">
                                        <?=$vehicle_no;?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-5 col-form-label text-left">Vessel Name</label>
                                    <div class="col-sm-7">
                                        <?=$vessel_id;?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-5 col-form-label text-left">No Invoice</label>
                                    <div class="col-sm-7">
                                        <?=$do_no;?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>



                    

                    
                    <div class="row gutters" style="margin-top:1%">                        
                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
                            <div class="table-container" style="width:100%"> 

                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-12 col-form-label boldp"></label>
                                </div>

                                <div class="table-responsive" style="margin-top:-2%">

                                    <div class="btn-group" style="margin-bottom:0.2%;">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" id="showaksi">
                                            <a class="dropdown-item btnadd"><span class="icon-control_point"></span>&nbsp;Add</a>
                                            <a class="dropdown-item btnedit"><span class="icon-edit"></span>&nbsp;Edit</a>
                                            <a class="dropdown-item btndelete"><span class="icon-x-circle"></span>&nbsp;Delete</a>
                                        </div>
                                    </div>

                                    <table id="tbl_whsout_delivery" class="table m-0 dataTable no-footer nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Nomor</th>
                                                <th>No Invoice</th>
                                                <th>Tgl Keluar</th>                                             
                                                <th>Jam Keluar</th>
                                                <!-- <th>Id Vessel</th> -->
                                                <th>Nama Vessel</th>
                                                <!-- <th>Id Shipper</th> -->
                                                <th>Nama Shipper</th>
                                                <th>No Mobil</th>
                                                <th>Destination</th>
                                                <th>No Cont</th>
                                                <th>Seal Number</th>
                                                <th>Start Loading</th>
                                                <th>Finish Loading</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                     
                                        </tbody>
                                    </table>
                                    <br><br><br><br><br><br>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
                            <div class="table-container" style="width:100%"> 
                            </div>
                            <div class="card user-card font-size-control boxshadow">
                                <div class="card-header">
                                    <div class="card-title" style="font-weight:400">Detail Barang</div>
                                </div>
                                <div class="card-body">
                                    <div class="row gutters">
                                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">No BL</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="bl_no1" id="bl_no1" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Consignee</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control form-control-sm font-size-control" name="consignee_name" id="consignee_name" readonly></textarea>
                                                    </div>
                                                </div>
                                            </div>    
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Ex BL</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="ex_blno" id="ex_blno" readonly>
                                                    </div>
                                                </div>
                                            </div>      
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Category</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="category_name" id="category_name" readonly>
                                                    </div>
                                                </div>
                                            </div>     
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Desc Item</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control form-control-sm font-size-control" name="item_desc" id="item_desc" maxlength="140" readonly></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Code Item</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="item_code" id="item_code" readonly>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Lokasi</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="location_name" id="location_name" readonly>
                                                    </div>
                                                </div>
                                            </div> 
                                            
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Jenis Doc</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="jenis_doc" id="jenis_doc" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Good</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="good_unit" id="good_unit" readonly>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Good GW</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="good_gross_weight" id="good_gross_weight" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Good Volume</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="good_volume" id="good_volume" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Damage</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="damage_unit" id="damage_unit" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Damage GW</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="damage_gross_weight" id="damage_gross_weight" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Damage Volume</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="damage_volume" id="damage_volume" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Pallet ID</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="palet_id" id="palet_id" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Remarks</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm font-size-control" name="remarks" id="remarks" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                    </div>                                                                                                   
                                </div>
                            </div>
                        </div>
                        

                    </div>


                </div>
            </div>

        </div>          

    </div>

</div>


<div id='div_popup_form'></div>

<script src="<?= site_url(); ?>assets/js/jquery.min.js"></script>




<script type="text/javascript">

    var tbl_whsout_delivery ;
    var kode_trans = "" ;
    var no_trans = "" ;
    var do_no = "" ;
    var array_row_data_table = [] ;

    $(document).ready(function(){

        $("#tgl_out").change(function() {
            refresh_combo();
        });

        $("#tgl_out_end").change(function() {
            refresh_combo();
        });

        $("#bl_no").change(function() {
            load_table();
        });

        $("#shipper_id").change(function() {
            load_table();
        });

        $("#consignee_id").change(function() {
            load_table();
        });

        $("#destination").change(function() {
            load_table();
        });

        $("#vehicle_no").change(function() {
            load_table();
        });

        $("#vessel_id").change(function() {
            load_table();
        });

        $("#do_no").change(function() {
            load_table();
        });

        $("#kode_trans").change(function() {
            //alert(this.value);
            load_table();
        });

        load_table();

        tbl_whsout_delivery.$('tr.selected').removeClass('selected');
        tbl_whsout_delivery.row(0).nodes().to$().toggleClass( 'selected' );
        var data = tbl_whsout_delivery.row(0).data();
        array_row_data_table = data ;
        kode_trans = data[1] ;
        no_trans = data[2] ; 
        do_no = data[3] ;
        getdetail(kode_trans,no_trans); 


        

    });

    $('#tbl_whsout_delivery tbody').on('click', 'tr', function() {

        var data = tbl_whsout_delivery.row(this).data();
        array_row_data_table = data ;

        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            kode_trans = "" ;
            no_trans = "" ;
            do_no = "" ;

        } else {
            tbl_whsout_delivery.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            kode_trans = data[1] ;
            no_trans = data[2] ;   
            do_no = data[3] ;   

            getdetail(kode_trans,no_trans);    
        }
    });

    function getdetail(kode_trans,no_trans){
        url = '<?php echo site_url('warehouse_transaksi/delivery/detail_bl') ?>';
        data = {
            kode_trans:kode_trans,
            no_trans:no_trans,            
        }; 
        pesan = 'JavaScript Detail BL Error ...';
        dataok = multi_ajax_proses(url, data, pesan);

        //console.log(dataok);

        $('#bl_no1').val(dataok.isidata[0][0]);
        $('#consignee_name').val(dataok.isidata[0][2]);
        $('#ex_blno').val(dataok.isidata[0][4]);
        $('#category_name').val(dataok.isidata[0][6]);
        $('#item_desc').val(dataok.isidata[0][7]);
        $('#item_code').val(dataok.isidata[0][8]);
        $('#location_name').val(dataok.isidata[0][10]);
        $('#good_unit').val(dataok.isidata[0][11]);
        $('#good_gross_weight').val(dataok.isidata[0][12]);
        $('#good_volume').val(dataok.isidata[0][13]);
        $('#damage_unit').val(dataok.isidata[0][14]);
        $('#damage_gross_weight').val(dataok.isidata[0][15]);
        $('#damage_volume').val(dataok.isidata[0][16]);
        $('#palet_id').val(dataok.isidata[0][17]);
        $('#remarks').val(dataok.isidata[0][18]);
        $('#jenis_doc').val(dataok.isidata[0][20]);


    }

    function kosong_getdetail(){
        $('#bl_no1').val("");
        $('#consignee_name').val("");
        $('#ex_blno').val("");
        $('#category_name').val("");
        $('#item_desc').val("");
        $('#item_code').val("");
        $('#location_name').val("");
        $('#good_unit').val("");
        $('#good_gross_weight').val("");
        $('#good_volume').val("");
        $('#damage_unit').val("");
        $('#damage_gross_weight').val("");
        $('#damage_volume').val("");
        $('#palet_id').val("");
        $('#remarks').val("");
        $('#jenis_doc').val("");

    }

    function refresh_combo(){

        url = '<?php echo site_url('warehouse_transaksi/delivery/refresh_combo') ?>';
        data = {
            tgl_out:$('#tgl_out').val(),
            tgl_out_end:$('#tgl_out_end').val(),            
        }; 
        pesan = 'JavaScript Refresh Combo Error ...';
        dataok = multi_ajax_proses(url, data, pesan);

        console.log(dataok);

        var html = "" ;

        if(dataok.bl_no.length > 0){

            for(let a=0 ; a < dataok.bl_no.length ; a++){
                html = html + "<option id='"+dataok.bl_no[a][0]+"' value='"+dataok.bl_no[a][0]+"'>"+dataok.bl_no[a][1]+"</option>" ;
            }

            $('#bl_no')
                .find('option')
                .remove()
                .end()
                .append(html).val("");

            $('#bl_no').selectpicker('refresh');
        }

        html = "" ;

        if(dataok.shipper_id.length > 0){
            for(let a=0 ; a < dataok.shipper_id.length ; a++){
                html = html + "<option id='"+dataok.shipper_id[a][0]+"' value='"+dataok.shipper_id[a][0]+"'>"+dataok.shipper_id[a][1]+"</option>" ;
            }

            $('#shipper_id')
                .find('option')
                .remove()
                .end()
                .append(html).val("");

            $('#shipper_id').selectpicker('refresh');
        }

        html = "" ;

        if(dataok.consignee_id.length > 0){
            for(let a=0 ; a < dataok.consignee_id.length ; a++){
                html = html + "<option id='"+dataok.consignee_id[a][0]+"' value='"+dataok.consignee_id[a][0]+"'>"+dataok.consignee_id[a][1]+"</option>" ;
            }

            $('#consignee_id')
                .find('option')
                .remove()
                .end()
                .append(html).val("");

            $('#consignee_id').selectpicker('refresh');
        }
        
        html = "" ;
        
        if(dataok.destination.length > 0){
            for(let a=0 ; a < dataok.destination.length ; a++){
                html = html + "<option id='"+dataok.destination[a][0]+"' value='"+dataok.destination[a][0]+"'>"+dataok.destination[a][1]+"</option>" ;
            }

            $('#destination')
                .find('option')
                .remove()
                .end()
                .append(html).val("");

            $('#destination').selectpicker('refresh');
        }

        html = "" ;
        
        if(dataok.vehicle_no.length > 0){
            for(let a=0 ; a < dataok.vehicle_no.length ; a++){
                html = html + "<option id='"+dataok.vehicle_no[a][0]+"' value='"+dataok.vehicle_no[a][0]+"'>"+dataok.vehicle_no[a][1]+"</option>" ;
            }

            $('#vehicle_no')
                .find('option')
                .remove()
                .end()
                .append(html).val("");

            $('#vehicle_no').selectpicker('refresh');
        }

        html = "" ;
        
        if(dataok.do_no.length > 0){
            for(let a=0 ; a < dataok.do_no.length ; a++){
                html = html + "<option id='"+dataok.do_no[a][0]+"' value='"+dataok.do_no[a][0]+"'>"+dataok.do_no[a][1]+"</option>" ;
            }

            $('#do_no')
                .find('option')
                .remove()
                .end()
                .append(html).val("");

            $('#do_no').selectpicker('refresh');
        }
            

        load_table();
    }

    function load_table(){
        kosong_getdetail();

        $("#loading-wrapper").show();

        url = '<?php echo site_url('warehouse_transaksi/delivery/tbl_whsout_delivery') ?>';
        data = {
            tgl_out:$('#tgl_out').val(),
            tgl_out_end:$('#tgl_out_end').val(),
            bl_no:$('#bl_no').val(),
            shipper_id:$('#shipper_id').val(),
            consignee_id:$('#consignee_id').val(),
            destination:$('#destination').val(),
            vehicle_no:$('#vehicle_no').val(),
            vessel_id:$('#vessel_id').val(),
            do_no:$('#do_no').val(),
            kode_trans:$('#kode_trans').val()
        }; 
        pesan = 'JavaScript Create tbl_whsout_delivery Error ...';
        dataok = multi_ajax_proses(url, data, pesan);

        //console.log(dataok);

        tbl_data_container('tbl_whsout_delivery',dataok.isidata,dataok.jml); 
    }

    function tbl_data_container(IdDatatable,data,jml){

        //console.log(data[0].length);
        //return ;

        $('#tbl_whsout_delivery').DataTable().destroy();
        $('#tbl_whsout_delivery tbody').empty();

        var html = "" ;
        let no = 1 ;

        if(jml > 0){

            for(let a = 0 ; a < jml ; a++){
                html = html+'<tr>' ;
                    html = html+'<td>' ;
                        html = html+no;
                    html = html+'</td>' ;

                    for(let c = 0 ; c < data[a].length ; c++){
                        html = html+'<td>' ;
                            html = html+data[a][c];
                        html = html+'</td>' ;
                    }

                html = html+'</tr>' ;
                no++;
            }

            $('#tbl_whsout_delivery').append(html);        
            datatable(IdDatatable);
            $('#tbl_whsout_delivery').DataTable().draw();  
        }else{
            datatable(IdDatatable);
            $('#tbl_whsout_delivery').DataTable().draw();  
        }
    }

    function datatable(IdDatatable){
        tbl_whsout_delivery = $('#tbl_whsout_delivery').DataTable({
            "searching": true,
            "paging":true,
            "info":true,
            "ordering": true,
            "scrollX" : true,
            "lengthMenu": [10,100,1000],
            "pageLength": 10,
            "columnDefs": [{
                        "targets": [0],
                        "orderable": false
                        }]
        });



        $("#loading-wrapper").hide();

    }

    
    $(document).on('click', '.btnadd', function(e) {

        if($('#kode_trans').val() == ''){
            alert('Pilih Operator terlebih dahulu ..!!');
            return false;
        }

        if($('#kode_trans').val() != "T6"){
            alert('Add Data Hanya Berfungsi Untuk Inputan Koordinator..!!');
            return false;
        }

        url = "<?php echo site_url('warehouse_transaksi/delivery/formadd') ?>";
        data = {kode_trans:$('#kode_trans').val()} ;
        divform = "#div_popup_form" ;
        idmodal = "#modal_add" ;        
        createmodal(url,data,divform,idmodal); 
    });


    $(document).on('click', '.btnedit', function(e) {

        console.log(array_row_data_table) ;

        if(kode_trans == '' && no_trans == ''){
            alert('belum ada data yang dipilih ..!!');
            return false;
        }

        //alert(do_no) ;

        url = '<?php echo site_url('warehouse_transaksi/delivery/formedit') ?>';
        data = {
            do_no:do_no,
            kode_trans:kode_trans,
            no_trans:no_trans,
            txtNoMobil:array_row_data_table[8],
            dtpOut:array_row_data_table[4],
            txtTimeOut:array_row_data_table[5],
            txtSealNo:array_row_data_table[11],
            txtDestination:array_row_data_table[9],
            txtRemarks:array_row_data_table[14],
            bl_no_input:$('#bl_no1').val(),
            //bl_no_input:do_no,
            consignee_name_input:$('#consignee_name').val(),
            ex_blno_input:$('#ex_blno').val(),
            category_name_input:$('#category_name').val(),
            item_desc_input:$('#item_desc').val(),
            item_code_input:$('#item_code').val(),
            location_name_input:$('#location_name').val(),
            good_unit_input:$('#good_unit').val(),
            good_gross_weight_input:$('#good_gross_weight').val(),
            good_volume_input:$('#good_volume').val(),
            damage_unit_input:$('#damage_unit').val(),
            damage_gross_weight_input:$('#damage_gross_weight').val(),
            damage_volume_input:$('#damage_volume').val(),
        } ;
        divform = "#div_popup_form" ;
        idmodal = "#modal_edit" ;        
        createmodal(url,data,divform,idmodal); 

    });

    $(document).on('click', '.btndelete', function(e) {
        
        if(kode_trans == '' && no_trans == ''){
            alert('belum ada data yang dipilih ..!!');
            return false;
        }

        var jawab = confirm('Anda yakin ingin menghapus data ini ?');

        if (jawab === true) { 
            url = '<?php echo site_url('warehouse_transaksi/delivery/delete') ?>';
            data = {kode_trans:kode_trans,no_trans:no_trans,do_no:do_no};
            pesan = 'JavaScript Delete Error...';
            dataok = multi_ajax_proses(url, data, pesan);
        }else{
            return false;
        }

        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }

        alert(dataok.pesan);
        kode_trans = "" ;
        no_trans = "" ;
        do_no = "" ;
        load_table();
    });


   


</script>