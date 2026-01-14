<style>        
    .dataout {background-color: yellow !important;}
    .margin-input{margin-bottom: -2% !important;}
    .formscan{height: 30px !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Transaction</li>
        <li class="breadcrumb-item active">..::: Scan Container In :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">

            <div class="card">
                <div class="card-body boxshadow">

                    <div class="row gutters">


                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                            <div class="row gutters">

                                
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-top: -2% !important;">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">No Container</label>
                                        <div class="col-sm-8">
                                            <input onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm" name="cont_number" id="cont_number" autofocus autocomplete="off" placeholder="Scan Disini atau Input Manual">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-top: -5% !important;">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Truck Number</label>
                                        <div class="col-sm-8">
                                            <input onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm" name="truck_number" id="truck_number" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-top: -5% !important;">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Driver Name</label>
                                        <div class="col-sm-8">
                                            <input onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm" name="driver_name" id="driver_name" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-top: -5% !important;">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">No Segel</label>
                                        <div class="col-sm-8">
                                            <input onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm" name="seal_number" id="seal_number" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-top: -5% !important;">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">No EIR</label>
                                        <div class="col-sm-8">
                                            <input onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm" name="no_eir" id="no_eir" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-top: -5% !important;">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Date EIR</label>
                                        <div class="col-sm-8">
                                            <input onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm datepicker-dropdowns" name="tgl_eir" id="tgl_eir" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-top: -5% !important;">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Principal</label>
                                        <div class="col-sm-8">
                                            <?=$code_principal;?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-top: 2% !important;">
                                    <div class="form-group row gutters">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-primary col-sm-12" id="btnSave"><span class="icon-save2"></span>&nbsp;Save</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-top: -2% !important;">
                                    <div class="form-group row gutters">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-primary col-sm-12" id="btnPrint"><span class="icon-print"></span>&nbsp;Print</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-top: -2% !important;">
                                    <div class="form-group row gutters">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-primary col-sm-12" id="btnRefresh"><span class="icon-refresh-ccw"></span>&nbsp;Refresh</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        

                    </div>

                </div>
            </div>

        </div>

        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">

           <div class="boxshadow">

                <div class="card">

                    <div class="card-body form-group row gutters">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                            <div class="row gutters">

                                <div class="table-container" style="width:100%;margin-bottom: -2.5%;">

                                    <table id="tbl_entry_cont_in" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>id_cont_in</th>
                                                <th>Eir In</th>
                                                <th>Bon Bongkar No</th>                                        
                                                <th>Principal</th>
                                                <th>Container Number</th>        
                                                <th>Date In</th> 
                                                <th>Time In</th> 
                                                <th>Size</th>
                                                <th>Vessel/Voyage</th>
                                                <th>Truck Number</th>
                                                <th>Driver Name</th>
                                                <th>Block</th>
                                                <th>Location</th>
                                                <th>Cont Status</th>
                                                <th>Cont Condition</th>
                                                <th>Seal Number</th>
                                                <th>Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                     
                                        </tbody>
                                    </table>
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
    var tbl_entry_cont_in ;



    $('#cont_number').on('keyup',function () {
         tbl_entry_cont_in.ajax.reload();
    });

    function KeyPressEnter(event, IdElement) {
        if (event.keyCode == 13) {
            
            if (IdElement == "cont_number") {

                var jmldata = $('#tbl_entry_cont_in').DataTable().rows().count();
                if(jmldata == 0){
                    alert("Data Container Tidak Ditemukan..!! \nMohon Input Manual Dari Halaman Entry Cont In");
                    $('#cont_number').focus();
                    return ;
                }else{
                    $('#truck_number').focus();
                }
            }
            
            if (IdElement == "truck_number") {
                $('#driver_name').focus();
            }

            if (IdElement == "driver_name") {
                $('#seal_number').focus();
            }

            if (IdElement == "seal_number") {
                $('#no_eir').focus();
            }

            if (IdElement == "no_eir") {
                $('#tgl_eir').focus();
            }

            if (IdElement == "tgl_eir") {
                $('#btnSave').focus();
            }
        }
    }

    

    $('#btnRefresh').click(function() {
        clearText();
        $('#cont_number').val("");
        tbl_entry_cont_in.ajax.reload();
    });

    $('#btnPrint').click(function() {
        var page = "<?php echo base_url(); ?>transaksi/entry_cont_in/print?data="+readTableData('tbl_entry_cont_in')[0]['eir_in'] ;
        window.open(page);
    });

    $('#btnSave').click(function() {


        if($('#cont_number').val() == "" || $('#truck_number').val() == "" || $('#driver_name').val() == "" || $('#seal_number').val() == "" || $('#no_eir').val() == "" || $('#tgl_eir').val() == "" || $('#code_principal').val() == "" ){

            alert("Data Belum Lengkap..!!");
            return ;

        }

        var jmldata = $('#tbl_entry_cont_in').DataTable().rows().count();
        if(jmldata == 0){
            alert("Data Container Tidak Ditemukan..!! \nMohon Input Manual Dari Halaman Entry Cont In");
            return ;
        }

        if(jmldata > 1){
            alert("Data Container Terdeteksi Double..!!");
            return ;
        }

        
        var str = $('#code_principal').val();

        const splitStr = str.split("###");
        var code_principal = splitStr[0] ;
        var name_principal = splitStr[1] ;

        // console.log(code_principal);
        // console.log(name_principal);

        url = '<?php echo site_url('transaksi/scan_cont_in/savedata') ?>';
        data = {
            cont_number:$('#cont_number').val(),
            truck_number:$('#truck_number').val(),
            driver_name:$('#driver_name').val(),
            seal_number:$('#seal_number').val(),
            id_cont_in:readTableData('tbl_entry_cont_in')[0]['id_cont_in'],
            no_eir:$('#no_eir').val(),
            tgl_eir:$('#tgl_eir').val(),
            code_principal:code_principal,
            name_principal:name_principal,
        };
        pesan = 'JavaScript Save Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            //alert(dataok.sql);
            return false;
        }
        alert(dataok.pesan);
        tbl_entry_cont_in.ajax.reload();

    });   

    function clearText(){
        $('#truck_number').val("") ;
        $('#driver_name').val("") ;
        $('#seal_number').val("") ;
        $('#no_eir').val("") ;
        $('#tgl_eir').val("") ;
        $('#code_principal').val("") ;
    }

    $(document).ready(function() {

        tbl_entry_cont_in = $('#tbl_entry_cont_in').DataTable({
            "ajax": {
                "url": "<?php echo site_url('transaksi/scan_cont_in/fetch_table'); ?>",
                "type": "POST",
                "beforeSend": function() {
                    $("#loading-wrapper").show();
                },
                "data": function(d) {
                    d.cont_number   = $('#cont_number').val();
                },  
                "complete": function(){
                    $("#loading-wrapper").hide();

                    tbl_entry_cont_in.$('tr.selected').removeClass('selected');
                    tbl_entry_cont_in.row(0).nodes().to$().toggleClass( 'selected' );
                    
                },
                "dataSrc": ""
            },
            "columns": [
                { "data": null, 
                    "render": function (data, type, row, meta) {
                    // Menggunakan meta.row untuk mengambil nomor urut
                    return meta.row + 1;
                    } 
                },
                { "data": "id_cont_in" },
                { "data": "eir_in" },
                { "data": "bon_bongkar_number" },
                { "data": "code_principal" },
                { "data": "cont_number" },
                { "data": "cont_date_in","className": "text-center" },
                { "data": "cont_time_in","className": "text-center" },
                { "data": "reff_code" },
                { "data": "vessel" },
                { "data": "truck_number" },
                { "data": "driver_name" },
                { "data": "block_loc" },
                { "data": "location" },
                { "data": "cont_status" },
                { "data": "cont_condition" },
                { "data": "seal_number" },
                { "data": "rec_id" }
            ],
            "pagingType": "simple",
            "pageLength": 15,
            "order": [[0, "desc"]],
            "order": [],
            "ordering": true,
            "scrollX": true,
            "scrollY": "231px",
            "scrollCollapse": true,
            "searching"     : false,
            "bLengthChange" : false,
            "columnDefs": [
                { 
                    "targets": [1,17],
                    "visible": false
                }
            ],
        });

        

    });

    
</script>