<style>        
    .dataout {background-color: yellow !important;}
    .margin-input{margin-bottom: -2% !important;}
    .formscan{height: 30px !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Transaction</li>
        <li class="breadcrumb-item active">..::: Scan Container Out :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">

            <div class="card boxshadow">
                <div class="card-body">

                    <div class="row gutters">

                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                            <div class="row gutters">

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-top: -2% !important;">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">No Transaksi</label>
                                        <div class="col-sm-8">
                                            <input onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm" name="No_Transaksi" id="No_Transaksi" autocomplete="off" placeholder="Scan Disini atau Input Manual" autofocus>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-top: -5% !important;">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">No Container</label>
                                        <div class="col-sm-8">
                                            <input readonly type="text" class="form-control form-control-sm" name="Cont_Number" id="Cont_Number">
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
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Tujuan</label>
                                        <div class="col-sm-8">
                                            <input onkeypress="KeyPressEnter(event,this.id)" type="text" class="form-control form-control-sm" name="destination" id="destination" autocomplete="off">
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

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">


                <div class="card boxshadow">

                    <div class="card-body form-group row gutters">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                            <div class="row gutters">

                                <div class="table-container" style="width:100%;margin-bottom: -2.5%;">

                                    <div class="card" style="margin-bottom: -0%">
                                        <div class="note" style="font-weight: 900;color: black;font-size: 15px;text-align: center;margin-bottom: 1%;margin-top: 1%;">Data DO (Delivery Order)</div>
                                    </div>

                                    <table id="tbl_do_cont_out" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>id_entry_do</th>
                                                <th>DO Date</th>
                                                <th>DO/Number</th>
                                                <th>Size/Type</th>
                                                <th>Principal</th>
                                                <th>Vessel/Voyage</th>
                                                <th>Shipper</th>
                                                <th>Seal Number</th>
                                                <th>Destination</th>
                                                <th>Notes</th>                                        
                                                <th>Party</th>
                                                <th>Cont Out</th>
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

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">

                <div class="card boxshadow">

                    <div class="card-body form-group row gutters">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                            <div class="row gutters">

                                <div class="table-container" style="width:100%;margin-bottom: -2.5%;">

                                    <div class="card" style="margin-bottom: -0%">
                                        <div class="note" style="font-weight: 900;color: black;font-size: 15px;text-align: center;margin-bottom: 1%;margin-top: 1%;">Data Container</div>
                                    </div>

                                    <table id="tbl_entry_cont_out" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No_Transaksi</th>
                                                <th>Inv_Number</th>
                                                <th>Do_Number</th>
                                                <th>Cont_Number</th>    
                                                <th>TglMasuk</th>                                                
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

<div id='div_popup_form'></div>

<script src="<?= site_url(); ?>assets/js/jquery.min.js"></script>


<script type="text/javascript">

    var tbl_do_cont_out ;
    var tbl_entry_cont_out ;
    var donumber = "" ;
    var selectbaris = 0 ;
    var notrans = "" ;

    $('#No_Transaksi').on('keyup',function () {
         //tbl_do_cont_out.ajax.reload();
    });


    function KeyPressEnter(event, IdElement) {
        if (event.keyCode == 13) {
            
            if (IdElement == "No_Transaksi") {


                url = '<?php echo site_url('transaksi/scan_cont_out/getnotrans') ?>';
                data = {
                    notrans:$('#No_Transaksi').val()
                };
                pesan = 'JavaScript getnotrans Error...';
                dataok = multi_ajax_proses(url, data, pesan);

                console.log(dataok['dataArray']) ;

                $('#Cont_Number').val(dataok['dataArray'][0]['Cont_Number']);
                donumber = dataok['dataArray'][0]['Do_Number'] ;

                tbl_do_cont_out.ajax.reload();

                setTimeout(function() {
                    var jmldata = $('#tbl_entry_cont_out').DataTable().rows().count();
                    var jmldata1 = $('#tbl_do_cont_out').DataTable().rows().count();
                    if(jmldata == 0 || jmldata1 == 0){
                        alert("Data Container Tidak Ditemukan..!! \nMohon Input Manual Dari Halaman Entry Cont Out");
                        $('#No_Transaksi').focus();
                        return ;
                    }else{
                        $('#truck_number').focus();
                    }
                }, 1000); // 1000 milidetik = 1 detik


            }
            
            
        }
    }

    $('#tbl_do_cont_out tbody').on('click', 'tr', function() {

        var data = tbl_do_cont_out.row(this).data();

        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');

            donumber = "" ;
            tbl_entry_cont_out.ajax.reload();

        } else {
            tbl_do_cont_out.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            //selectbaris = tbl_do_cont_out.row(this).index();
            donumber = data['do_number'] ;
            tbl_entry_cont_out.ajax.reload();

        }
    });

    $('#btnPrint').click(function() {

        var data = [];
        data[0] = "";
        data[1] = "";
        data[2] = readTableData('tbl_entry_cont_out')[0]['No_Transaksi'];

        var page = "<?php echo base_url(); ?>transaksi/entry_cont_out/print?data="+btoa(data) ;
        window.open(page);
    });

    
    $('#btnSave').click(function() {

        var a1 = $('#No_Transaksi').val();
        var a2 = $('#Cont_Number').val();
        var a3 = $('#truck_number').val();
        var a4 = $('#driver_name').val();
        var a5 = $('#destination').val();

        if(a1 == "" || a2 == "" || a3 == "" || a4 == "" || a5 == ""){
            alert("Data Belum Lengkap..!!");
            return ;
        }


        url = '<?php echo site_url('transaksi/scan_cont_out/savedata') ?>';
        data = {
            No_Transaksi:$('#No_Transaksi').val(),
            Cont_Number:$('#Cont_Number').val(),
            truck_number:$('#truck_number').val(),
            driver_name:$('#driver_name').val(),
            destination:$('#destination').val(),
            do_number:readTableData('tbl_do_cont_out')[0]['do_number'],
            code_principal:readTableData('tbl_do_cont_out')[0]['code_principal'],
            reff_code:readTableData('tbl_do_cont_out')[0]['reff_code'],
            cont_date_in:readTableData('tbl_entry_cont_out')[0]['TglMasuk'],
            vessel:readTableData('tbl_do_cont_out')[0]['vessel'],
            seal_number:readTableData('tbl_do_cont_out')[0]['seal_number'],
            do_date:readTableData('tbl_do_cont_out')[0]['do_date'],
        };
        pesan = 'JavaScript Save Error...';
        dataok = multi_ajax_proses(url, data, pesan);

        if(dataok.msg != "Ya"){
            alert(dataok.pesan);
            alert(dataok.sql);
            return;
        }

        console.log(dataok) ;

        clearText();
        alert(dataok.pesan);
        tbl_do_cont_out.ajax.reload();

    });

    $(document).ready(function() {
        
        tbl_do_cont_out = $('#tbl_do_cont_out').DataTable({
            "ajax": {
                "url": "<?php echo site_url('transaksi/scan_cont_out/fetch_table_do'); ?>",
                "type": "POST",
                "beforeSend": function() {
                    $("#loading-wrapper").show();
                },
                "data": function(d) {
                    d.donumber   = donumber ;
                },  
                "complete": function(){
                    $("#loading-wrapper").hide();
                    tbl_do_cont_out.$('tr.selected').removeClass('selected');
                    tbl_do_cont_out.row(selectbaris).nodes().to$().toggleClass( 'selected' );
                    
                    var data = tbl_do_cont_out.row(selectbaris).data();
                    donumber = data['do_number'];

                    tbl_entry_cont_out.ajax.reload();

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
                { "data": "id_entry_do" },
                { "data": "do_date" },
                { "data": "do_number" },
                { "data": "reff_code" },
                { "data": "code_principal" },
                { "data": "vessel" },
                { "data": "shipper" },
                { "data": "seal_number" },
                { "data": "destination" },
                { "data": "notes" },
                { "data": "party" },
                { "data": "cont_out" }
                
            ],
            "pagingType": "simple",
            "pageLength": 100,
            "order": [[0, "desc"]],
            "order": [],
            "ordering": true,
            "scrollX": true,
            "scrollY": "250px",
            "scrollCollapse": true,
            "searching"     : false,
            "bLengthChange" : false,
            "columnDefs": [
                { 
                    "targets": [1],
                    "visible": false
                }
            ],
        });

        tbl_entry_cont_out = $('#tbl_entry_cont_out').DataTable({
            "ajax": {
                "url": "<?php echo site_url('transaksi/scan_cont_out/fetch_table'); ?>",
                "type": "POST",
                "beforeSend": function() {
                    $("#loading-wrapper").show();
                },
                "data": function(d) {
                    d.donumber   = donumber ;
                    d.numbercontainer = $('#Cont_Number').val() ;
                },  
                "complete": function(){
                    $("#loading-wrapper").hide();
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
                { "data": "No_Transaksi" },
                { "data": "Inv_Number" },
                { "data": "Do_Number" },
                { "data": "Cont_Number" },
                { "data": "TglMasuk" }
            ],
            "pagingType": "simple",
            "pageLength": 100,
            "order": [[0, "desc"]],
            "order": [],
            "ordering": true,
            "scrollX": true,
            "scrollY": "250px",
            "scrollCollapse": true,
            "searching"     : false,
            "bLengthChange" : false,
        });

    });


    function clearText(){
        $('#truck_number').val("") ;
        $('#driver_name').val("") ;
        $('#destination').val("") ;
    }    

    
</script>