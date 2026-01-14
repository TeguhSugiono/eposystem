<style>        
    .validate {background-color: white !important;}
    .notvalidate {background-color: #e5e7eb !important;}
    .margin-input{margin-bottom: -2% !important;}
    .boldp{font-weight: 700;}
    
/*    .dataTables_filter{display: block !important;}
    .dataTables_length{display: block !important;}*/
    
    .card .card-header {padding: 1rem 1.25rem 0rem 1.25rem;}
    .card .card-body {padding: 0.3rem 1.25rem;}
    .font-size-control{font-size: 11px !important;}

    .bootstrap-select > .dropdown-toggle{
      height: 29px;
      line-height: 16px;
    }

    .card1{
        margin-bottom: -4%;
    }
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Warehouse</li>
        <li class="breadcrumb-item">Transaction</li>
        <li class="breadcrumb-item active">..::: Receiving :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">
        
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">

            <div class="card">
                <div class="card-body boxshadow">

                    <div class="row gutters">

                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:2%">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-primary" id="btnExportData"><span class="icon-download"></span>&nbsp;Export</button>
                                <button type="button" class="btn btn-primary" id="btnExportBahandle"><span class="icon-download"></span>&nbsp;Bahandle</button>
                                <button type="button" class="btn btn-primary" id="btnExportTally"><span class="icon-download"></span>&nbsp;Tally</button>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-5% !important">
                                    <div class="form-group">
                                        <label for="inputName">Tgl Masuk</label>
                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="tgl_in"  name="tgl_in" value=<?=$startdate;?> >
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-5% !important">
                                    <div class="form-group">
                                        <label for="inputName">s/d</label>
                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="tgl_in_end"  name="tgl_in_end" value=<?=$enddate;?> >
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-5% !important">
                                    <div class="form-group">
                                        <label for="inputName">BL No</label>
                                        <?=$bl_no;?>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-7% !important">
                                    <div class="form-group">
                                        <label for="inputName">PBM/Forwarder</label>
                                        <?=$shipper_id;?>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="inputName">Consignee Name</label>
                                        <?=$consignee_id;?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-6% !important">
                                    <div class="form-group">
                                        <label for="inputName">Container</label>
                                        <?=$cont_no;?>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-7% !important">
                                    <div class="form-group">
                                        <label for="inputName">Master BL</label>
                                        <?=$do_no;?>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-5% !important">
                                    <div class="form-group">
                                        <label for="inputName">Vessel Name</label>
                                        <?=$vessel_id;?>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-5% !important">
                                    <div class="form-group">
                                        <label for="inputName">No Trans</label>
                                        <?=$no_transaksi;?>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="inputName">Stripping</label>
                                        <?=$stripping;?>
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
                
            

                <div class="card" style="margin-bottom: -1%">
                    <div class="note" style="font-weight: 900;color: black;font-size: 15px;text-align: center;margin-bottom: 1.2%;">Data Header</div>
                </div>

            
           
                <div class="card">

                    <div class="card-body form-group row gutters">

                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12" style="margin-top:-0.5%">
                            <div style="text-align: center;margin-top:2%;margin-bottom: 5%;font-weight: 900;">Operator</div>
                            <div style="margin-bottom: 5%"><?=$kode_trans;?></div>
                            <div class="custom-btn-group">                                
                                <button type="button" class="btn btn-primary" id="btnAdd"><span class="icon-control_point"></span>&nbsp;Add</button>
                                <button type="button" class="btn btn-primary" id="btnEdit"><span class="icon-edit"></span>&nbsp;Edit</button>
                                <button type="button" class="btn btn-primary" id="btnDel"><span class="icon-x-circle"></span>&nbsp;Delete</button>
                            </div>
                        </div>

                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">

                            <div class="row gutters">

                                <div class="table-container" style="width:100%;margin-bottom: -2.5%;">

                                    <table id="tbl_whsin_receiving" class="table m-0 dataTable no-footer nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Nomor</th>
                                                <th>No DO</th>
                                                <th>Tgl Tiba</th>
                                                <th>Tgl Masuk</th>                                             
                                                <th>Jam Masuk</th>
                                                <th>Nama Vessel</th>
                                                <th>Nama Shipper</th>
                                                <th>No Mobil</th>
                                                <th>Destination</th>
                                                <th>No Cont</th>
                                                <th>Seal Number</th>
                                                <th>Start Loading</th>
                                                <th>Finish Loading</th>
                                                <th>Remarks</th>
                                                <th>Tgl Master BL</th>
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



                <div class="card" style="margin-bottom: -1%">
                    <div class="note" style="font-weight: 900;color: black;font-size: 15px;text-align: center;margin-bottom: 1.2%;">Data Detail</div>
                </div>

                <div class="card">

                    <div class="card-body form-group row gutters">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                            <div class="row gutters">

                                <div class="table-container" style="width:100%;margin-bottom: -2.5%;">

                                    <table id="tbl_whsin_receiving_detail" class="table m-0 dataTable no-footer nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NO BL</th>
                                                <th>Tgl BL</th>
                                                <th>consignee_id</th>                                                
                                                <th>Nama Consignee</th>
                                                <th>seqno</th>
                                                <th>category_id</th>
                                                <th>BL Mark</th>
                                                <th>Deskripsi Item</th>
                                                <th>location_id</th>
                                                <th>Category</th>
                                                <th>Good</th>
                                                <th>Good GW</th>
                                                <th>Good Volume</th>
                                                <th>Damage</th>
                                                <th>Damage GW</th>
                                                <th>Damage Volume</th>
                                                <th>Pallet Id</th>
                                                <th>Code Item</th>
                                                <th>Lokasi</th>
                                                <th>id_charge</th>
                                                <th>Surcharge</th>
                                                <th>Remarks</th>
                                                <th>User</th>
                                                <th>Create On</th>
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

    var tbl_whsin_receiving ;
    var tbl_whsin_receiving_detail ;
    var kode_trans = "" ;
    var no_trans = "" ;
    var do_no = "" ;
    var array_row_data_table = [] ;



    $(document).ready(function(){

        tbl_whsin_receiving_detail = $('#tbl_whsin_receiving_detail').DataTable({
            "searching": true,
            // "paging":true,
            "info":true,
            "ordering": false,
            "scrollX" : true,
            "scrollY": "120px",
            "lengthMenu": [10,100,1000],
            "pageLength": 10,
            "pagingType": "full",
            "columnDefs": [
                        {
                            "targets": [0],
                            "orderable": false
                        }
                        ,
                        {
                            "targets": [3,5,6,9,20],
                            "visible": false
                        }
                        ]
        });

        $('#tbl_whsin_receiving_detail').DataTable().draw();

        $("#tgl_in").change(function() {
            refresh_combo();
        });

        $("#tgl_in_end").change(function() {
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

        $("#cont_no").change(function() {
            load_table();
        });

        $("#do_no").change(function() {
            load_table();
        });

        $("#vessel_id").change(function() {
            load_table();
        });

        $("#no_transaksi").change(function() {
            load_table();
        });

        $("#stripping").change(function() {
            load_table();
        });

        $("#kode_trans").change(function() {
            load_table();
        });

        load_table();

        tbl_whsin_receiving.$('tr.selected').removeClass('selected');
        tbl_whsin_receiving.row(0).nodes().to$().toggleClass( 'selected' );
        var data = tbl_whsin_receiving.row(0).data();
        array_row_data_table = data ;
        kode_trans = data[1] ;
        no_trans = data[2] ; 
        do_no = data[3] ;
        getdetail(kode_trans,no_trans); 


    

    });

    $('#tbl_whsin_receiving tbody').on('click', 'tr', function() {

        var data = tbl_whsin_receiving.row(this).data();
        array_row_data_table = data ;

        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            kode_trans = "" ;
            no_trans = "" ;
            do_no = "" ;  

            getdetail(kode_trans,no_trans); 

        } else {
            tbl_whsin_receiving.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            kode_trans = data[1] ;
            no_trans = data[2] ;   
            do_no = data[3] ;   

            getdetail(kode_trans,no_trans);    
        }
    });

    function getdetail(kode_trans,no_trans){
        $("#loading-wrapper").show();

        url = '<?php echo site_url('warehouse_transaksi/receiving/tbl_whsin_receiving_detail') ?>';
        data = {
            kode_trans:kode_trans,
            no_trans:no_trans,            
        }; 
        pesan = 'JavaScript Detail BL Error ...';
        dataok = multi_ajax_proses(url, data, pesan);

        console.log(dataok) ;


        $('#tbl_whsin_receiving_detail').DataTable().destroy();
        $('#tbl_whsin_receiving_detail tbody').empty();


        var html = "" ;
        let no = 1 ;

        if(dataok.jml > 0){

            for(let a = 0 ; a < dataok.jml ; a++){
                html = html+'<tr>' ;
                    html = html+'<td>' ;
                        html = html+no;
                    html = html+'</td>' ;

                    for(let c = 0 ; c < dataok.isidata[a].length ; c++){
                        html = html+'<td>' ;
                            html = html+dataok.isidata[a][c];
                        html = html+'</td>' ;
                    }

                html = html+'</tr>' ;
                no++;
            }

            $('#tbl_whsin_receiving_detail').append(html);        

            tbl_whsin_receiving_detail = $('#tbl_whsin_receiving_detail').DataTable({
                "searching": true,
                // "paging":true,
                "info":true,
                "ordering": false,
                "scrollX" : true,
                "scrollY": "120px",
                "lengthMenu": [10,100,1000],
                "pageLength": 10,
                "pagingType": "full",
                "columnDefs": [
                            {
                                "targets": [0],
                                "orderable": false
                            }
                            ,
                            {
                                "targets": [3,5,6,9,20],
                                "visible": false
                            }
                            ]
            });


            $('#tbl_whsin_receiving_detail').DataTable().draw();  

            $("#loading-wrapper").hide();


        }else{
            tbl_whsin_receiving_detail = $('#tbl_whsin_receiving_detail').DataTable({
                "searching": true,
                // "paging":true,
                "info":true,
                "ordering": false,
                "scrollX" : true,
                "scrollY": "120px",
                "lengthMenu": [10,100,1000],
                "pageLength": 10,
                "pagingType": "full",
                "columnDefs": [
                            {
                                "targets": [0],
                                "orderable": false
                            }
                            ,
                            {
                                "targets": [3,5,6,9,20],
                                "visible": false
                            }
                            ]
            });

            $('#tbl_whsin_receiving_detail').DataTable().draw();  

            $("#loading-wrapper").hide();
        }


    }


    function refresh_combo(){

        url = '<?php echo site_url('warehouse_transaksi/receiving/refresh_combo') ?>';
        data = {
            tgl_in:$('#tgl_in').val(),
            tgl_in_end:$('#tgl_in_end').val(),            
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

        if(dataok.cont_no.length > 0){
            for(let a=0 ; a < dataok.cont_no.length ; a++){
                html = html + "<option id='"+dataok.cont_no[a][0]+"' value='"+dataok.cont_no[a][0]+"'>"+dataok.cont_no[a][1]+"</option>" ;
            }

            $('#cont_no')
                .find('option')
                .remove()
                .end()
                .append(html).val("");

            $('#cont_no').selectpicker('refresh');
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

        html = "" ;

        if(dataok.vessel_id.length > 0){
            for(let a=0 ; a < dataok.vessel_id.length ; a++){
                html = html + "<option id='"+dataok.vessel_id[a][0]+"' value='"+dataok.vessel_id[a][0]+"'>"+dataok.vessel_id[a][1]+"</option>" ;
            }

            $('#vessel_id')
                .find('option')
                .remove()
                .end()
                .append(html).val("");

            $('#vessel_id').selectpicker('refresh');
        }   


        html = "" ;

        if(dataok.no_transaksi.length > 0){
            for(let a=0 ; a < dataok.no_transaksi.length ; a++){
                html = html + "<option id='"+dataok.no_transaksi[a][0]+"' value='"+dataok.no_transaksi[a][0]+"'>"+dataok.no_transaksi[a][1]+"</option>" ;
            }

            $('#no_transaksi')
                .find('option')
                .remove()
                .end()
                .append(html).val("");

            $('#no_transaksi').selectpicker('refresh');
        }   

        load_table();
    }

    function load_table(){
        //kosong_getdetail();

        $("#loading-wrapper").show();

        url = '<?php echo site_url('warehouse_transaksi/receiving/tbl_whsin_receiving') ?>';
        data = {
            tgl_in:$('#tgl_in').val(),
            tgl_in_end:$('#tgl_in_end').val(),
            bl_no:$('#bl_no').val(),
            shipper_id:$('#shipper_id').val(),
            consignee_id:$('#consignee_id').val(),
            cont_no:$('#cont_no').val(),
            do_no:$('#do_no').val(),
            vessel_id:$('#vessel_id').val(),
            no_transaksi:$('#no_transaksi').val(),
            stripping:$('#stripping').val(),
            kode_trans:$('#kode_trans').val()
        }; 
        pesan = 'JavaScript Create tbl_whsin_receiving Error ...';
        dataok = multi_ajax_proses(url, data, pesan);

        console.log(dataok);

        tbl_data_container('tbl_whsin_receiving',dataok.isidata,dataok.jml); 
    }

    function tbl_data_container(IdDatatable,data,jml){

        $('#tbl_whsin_receiving').DataTable().destroy();
        $('#tbl_whsin_receiving tbody').empty();


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

            $('#tbl_whsin_receiving').append(html);        
            datatable(IdDatatable);
            $('#tbl_whsin_receiving').DataTable().draw();  

            tbl_whsin_receiving.$('tr.selected').removeClass('selected');
            tbl_whsin_receiving.row(0).nodes().to$().toggleClass( 'selected' );
            
            var data = tbl_whsin_receiving.row(0).data();
            kode_trans = data[1] ;
            no_trans = data[2] ;   
            do_no = data[3] ;   

            getdetail(kode_trans,no_trans);    


        }else{
            datatable(IdDatatable);
            $('#tbl_whsin_receiving').DataTable().draw();  
        }
    }

    function datatable(IdDatatable){
        tbl_whsin_receiving = $('#tbl_whsin_receiving').DataTable({
            "searching": true,
            // "paging":true,
            "info":true,
            "ordering": true,
            "scrollX" : true,
            "scrollY": "120px",
            "lengthMenu": [10,100,1000],
            "pageLength": 10,
            "pagingType": "full",
            "columnDefs": [{
                        "targets": [0],
                        "orderable": false
                        }]
        });



        $("#loading-wrapper").hide();

    }


    $(document).on('click', '#btnExportData', function(e) {

        var data = [];
        data[0] = $('#tgl_in').val() ;
        data[1] = $('#tgl_in_end').val() ;

        var page = "<?php echo base_url(); ?>warehouse_transaksi/receiving/exportdata?data="+btoa(data) ;
        window.open(page);

    });

    $(document).on('click', '#btnExportBahandle', function(e) {
        var data = [];
        data[0] = $('#tgl_in').val() ;
        data[1] = $('#tgl_in_end').val() ;

        var page = "<?php echo base_url(); ?>warehouse_transaksi/receiving/exportbahandle?data="+btoa(data) ;
        window.open(page);

    });

    $(document).on('click', '#btnExportTally', function(e) {

        if($('#cont_no').val() == ""){
            alert('No Kontainer Tidak Boleh Kosong ..!!');
            return;
        }


        var data = [];
        data[0] = $('#tgl_in').val() ;
        data[1] = $('#tgl_in_end').val() ;
        data[2] = $('#cont_no').val() ;

        var page = "<?php echo base_url(); ?>warehouse_transaksi/receiving/exporttally?data="+btoa(data) ;
        window.open(page);

    });

    
    $(document).on('click', '#btnAdd', function(e) {

        if($('#kode_trans').val() == ''){
            alert('Pilih Operator terlebih dahulu ..!!');
            return false;
        }

        if($('#kode_trans').val() != "T1"){
            alert('Add Data Hanya Berfungsi Untuk Inputan Koordinator..!!');
            return false;
        }

        url = "<?php echo site_url('warehouse_transaksi/receiving/formadd') ?>";
        data = {kode_trans:$('#kode_trans').val()} ;
        divform = "#div_popup_form" ;
        idmodal = "#modal_add" ;        
        createmodal(url,data,divform,idmodal); 
    });

    

    $(document).on('click', '#btnEdit', function(e) {

    });

    $(document).on('click', '#btnDel', function(e) {

    });

    // $(document).on('click', '.btnedit', function(e) {

    //     console.log(array_row_data_table) ;

    //     if(kode_trans == '' && no_trans == ''){
    //         alert('belum ada data yang dipilih ..!!');
    //         return false;
    //     }

    //     url = '<?php echo site_url('warehouse_transaksi/receiving/formedit') ?>';
    //     data = {
    //         do_no:do_no,
    //         kode_trans:kode_trans,
    //         no_trans:no_trans,
    //         txtNoMobil:array_row_data_table[8],
    //         dtpOut:array_row_data_table[4],
    //         txtTimeOut:array_row_data_table[5],
    //         txtSealNo:array_row_data_table[11],
    //         txtDestination:array_row_data_table[9],
    //         txtRemarks:array_row_data_table[14],
    //         bl_no_input:$('#bl_no1').val(),
    //         //bl_no_input:do_no,
    //         consignee_name_input:$('#consignee_name').val(),
    //         ex_blno_input:$('#ex_blno').val(),
    //         category_name_input:$('#category_name').val(),
    //         item_desc_input:$('#item_desc').val(),
    //         item_code_input:$('#item_code').val(),
    //         location_name_input:$('#location_name').val(),
    //         good_unit_input:$('#good_unit').val(),
    //         good_gross_weight_input:$('#good_gross_weight').val(),
    //         good_volume_input:$('#good_volume').val(),
    //         damage_unit_input:$('#damage_unit').val(),
    //         damage_gross_weight_input:$('#damage_gross_weight').val(),
    //         damage_volume_input:$('#damage_volume').val(),
    //     } ;
    //     divform = "#div_popup_form" ;
    //     idmodal = "#modal_edit" ;        
    //     createmodal(url,data,divform,idmodal); 

    // });

    // $(document).on('click', '.btndelete', function(e) {
        
    //     if(kode_trans == '' && no_trans == ''){
    //         alert('belum ada data yang dipilih ..!!');
    //         return false;
    //     }

    //     var jawab = confirm('Anda yakin ingin menghapus data ini ?');

    //     if (jawab === true) { 
    //         url = '<?php echo site_url('warehouse_transaksi/receiving/delete') ?>';
    //         data = {kode_trans:kode_trans,no_trans:no_trans,do_no:do_no};
    //         pesan = 'JavaScript Delete Error...';
    //         dataok = multi_ajax_proses(url, data, pesan);
    //     }else{
    //         return false;
    //     }

    //     if(dataok.msg != 'Ya'){
    //         alert(dataok.pesan);
    //         return false;
    //     }

    //     alert(dataok.pesan);
    //     kode_trans = "" ;
    //     no_trans = "" ;
    //     do_no = "" ;
    //     load_table();
    // });


   


</script>