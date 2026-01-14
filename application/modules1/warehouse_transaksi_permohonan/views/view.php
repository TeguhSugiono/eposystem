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
        <li class="breadcrumb-item active">..::: Permohonan :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">
        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">

            <div class="card">
                <div class="card-body boxshadow">

                    <div class="row gutters">

                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">

                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-5% !important">
                                    <div class="form-group">
                                        <label for="inputName">Tgl Eta</label>
                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="tgl_eta"  name="tgl_eta" value=<?=$startdate;?> >
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-5% !important">
                                    <div class="form-group">
                                        <label for="inputName">s/d</label>
                                        <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="tgl_eta_end"  name="tgl_eta_end" value=<?=$enddate;?> >
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-5% !important">
                                    <div class="form-group">
                                        <label for="inputName">Master BL</label>
                                        <?=$no_mbl;?>
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-5% !important">
                                    <div class="form-group">
                                        <label for="inputName">PBM</label>
                                        <?=$shipper_id;?>
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:-5% !important">
                                    <div class="form-group">
                                        <label for="inputName">Container</label>
                                        <?=$cont_no;?>
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
                

                <!-- <div class="card" style="margin-bottom: -1%">
                    <div class="note" style="font-weight: 900;color: black;font-size: 15px;text-align: center;margin-bottom: 1.2%;">Data Surat</div>
                </div> -->

           
                <div class="card">

                    <div class="card-body form-group row gutters" style="margin-top:1.5%">

                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12" style="margin-top:-0.5%">
                            <div class="custom-btn-group">                                
                                <button type="button" class="btn btn-primary" id="btnAdd"><span class="icon-control_point"></span>&nbsp;Add</button>
                                <button type="button" class="btn btn-primary" id="btnEdit"><span class="icon-edit"></span>&nbsp;Edit</button>
                                <button type="button" class="btn btn-primary" id="btnDel"><span class="icon-x-circle"></span>&nbsp;Delete</button>
                                <button type="button" class="btn btn-primary" id="btnPrint"><span class="icon-print"></span>&nbsp;Print</button>
                            </div>
                        </div>

                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">

                            <div class="row gutters">
                            <!-- <div class="form-group row gutters"> -->

                                <div class="table-container" style="width:100%;margin-bottom: -2.5%;">

                                    <table id="tbl_whs_permohonan" class="table m-0 dataTable no-footer nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Id</th> 
                                                <th>Tgl Eta</th>
                                                <th>No MB/L</th>
                                                <th>Tgl MB/L</th>
                                                <th>shipper_id</th>
                                                <th>PBM</th>
                                                <th>Vessel</th>
                                                <th>Voyage</th>
                                                <th>TPS</th>
                                                <th>Pos</th>
                                                <th>Qty</th>
                                                <th>GW</th>
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

        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">

            <div class="boxshadow">

                <div class="card">

                    <div class="card-body form-group row gutters" style="margin-top:6%">

                        <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-primary" id="btnPrint"><span class="icon-print"></span>&nbsp;Print</button>
                            </div>
                        </div> -->

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                            <div class="form-group row gutters">

                                <div class="table-container" style="width:100%;margin-bottom: -2.5%;">

                                    <table id="tbl_whs_permohonan_detail" class="table m-0 dataTable no-footer nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Id</th> 
                                                <th>No Kontainer</th>
                                                <th>Size</th>                                                
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

    var tbl_whs_permohonan ;
    var tbl_whs_permohonan_detail ;
    var id ="" ;
    var shipper_id = "" ;

    $(document).ready(function(){
        load_table();

        $("#tgl_eta").change(function() {
            load_table();
        });
        $("#tgl_eta_end").change(function() {
            load_table();
        });
        $("#no_mbl").change(function() {
            load_table();
        });
        $("#shipper_id").change(function() {
            load_table();
        });
        $("#cont_no").change(function() {
            load_table();
        });
    });

    function load_table(){

        $("#loading-wrapper").show();

        url = '<?php echo site_url('warehouse_transaksi/permohonan/tbl_whs_permohonan') ?>';
        data = {
            tgl_eta:$('#tgl_eta').val(),
            tgl_eta_end:$('#tgl_eta_end').val(),
            no_mbl:$('#no_mbl').val(),
            shipper_id:$('#shipper_id').val(),
            cont_no:$('#cont_no').val()
        }; 
        pesan = 'JavaScript Create tbl_whs_permohonan Error ...';
        dataok = multi_ajax_proses(url, data, pesan);

        //console.log(dataok);

        tbl_data_container('tbl_whs_permohonan',dataok.isidata,dataok.jml); 
    }

    
    

    function datatable(IdDatatable){
        tbl_whs_permohonan = $('#tbl_whs_permohonan').DataTable({
            "searching": true,
            // "paging":true,
            "info":true,
            "ordering": true,
            "scrollX" : true,
            "scrollY": "300px",
            "lengthMenu": [10,100,1000],
            "pageLength": 10,
            "pagingType": "full",
            "columnDefs": [{
                            "targets": [0],
                            "orderable": false
                        }
                        ,
                        {
                            "targets": [1,5],
                            "visible": false
                        }
                        ]
        });

        $("#loading-wrapper").hide();
    }

    function getdetail(id){
        $("#loading-wrapper").show();

        url = '<?php echo site_url('warehouse_transaksi/permohonan/tbl_whs_permohonan_detail') ?>';
        data = {id:id}; 
        pesan = 'JavaScript Create tbl_whs_permohonan_detail Error ...';
        dataok = multi_ajax_proses(url, data, pesan);

        //console.log(dataok);

        tbl_data_container_detail('tbl_whs_permohonan_detail',dataok.isidata,dataok.jml); 
    }
   

    function tbl_data_container(IdDatatable,data,jml){

        $('#tbl_whs_permohonan').DataTable().destroy();
        $('#tbl_whs_permohonan tbody').empty();


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

            $('#tbl_whs_permohonan').append(html);        
            datatable(IdDatatable);
            $('#tbl_whs_permohonan').DataTable().draw();  

            tbl_whs_permohonan.$('tr.selected').removeClass('selected');
            tbl_whs_permohonan.row(0).nodes().to$().toggleClass( 'selected' );
            
            var data = tbl_whs_permohonan.row(0).data();
            id = data[1] ;
            shipper_id = data[5] ;

            getdetail(id);    


        }else{
            datatable(IdDatatable);
            $('#tbl_whs_permohonan').DataTable().draw();  
        }
    }

    $('#tbl_whs_permohonan tbody').on('click', 'tr', function() {

        var data = tbl_whs_permohonan.row(this).data();
        array_row_data_table = data ;

        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            id = "" ;
            shipper_id = "" ;
            getdetail(id); 
        } else {
            tbl_whs_permohonan.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            id = data[1] ;
            shipper_id = data[5] ;
            getdetail(id);    
        }
    });

    function tbl_data_container_detail(IdDatatable,data,jml){

        $('#tbl_whs_permohonan_detail').DataTable().destroy();
        $('#tbl_whs_permohonan_detail tbody').empty();


        var html = "" ;
        let no = 1 ;

        if(jml > 0){

            for(let a = 0 ; a < jml ; a++){
                html = html+'<tr>' ;
                    // html = html+'<td>' ;
                    //     html = html+no;
                    // html = html+'</td>' ;

                    for(let c = 0 ; c < data[a].length ; c++){
                        html = html+'<td>' ;
                            html = html+data[a][c];
                        html = html+'</td>' ;
                    }

                html = html+'</tr>' ;
                no++;
            }

            $('#tbl_whs_permohonan_detail').append(html);        
            //datatable(IdDatatable);
            tbl_whs_permohonan_detail = $('#tbl_whs_permohonan_detail').DataTable({
                "searching": true,
                "paging":false,
                "info":true,
                "ordering": true,
                "scrollX" : true,
                "scrollY": "150px",
                "lengthMenu": [10,100,1000],
                "pageLength": 10,
                "pagingType": "full",
                "columnDefs": [
                            // {
                            //     "targets": [0],
                            //     "orderable": false
                            // }
                            // ,
                            {
                                "targets": [0],
                                "visible": false
                            }
                            ]
            });
            $("#loading-wrapper").hide();


            $('#tbl_whs_permohonan_detail').DataTable().draw();  



        }else{
            //datatable(IdDatatable);
            tbl_whs_permohonan_detail = $('#tbl_whs_permohonan_detail').DataTable({
                "searching": true,
                "paging":false,
                "info":true,
                "ordering": true,
                "scrollX" : true,
                "scrollY": "50px",
                "lengthMenu": [10,100,1000],
                "pageLength": 10,
                "pagingType": "full",
                "columnDefs": [
                            // {
                            //     "targets": [0],
                            //     "orderable": false
                            // }
                            // ,
                            {
                                "targets": [0],
                                "visible": false
                            }
                            ]
            });
            $("#loading-wrapper").hide();
            $('#tbl_whs_permohonan_detail').DataTable().draw();  
        }

    }


    $(document).on('click', '#btnAdd', function(e) {
        url = "<?php echo site_url('warehouse_transaksi/permohonan/formadd') ?>";
        data = "" ;
        divform = "#div_popup_form" ;
        idmodal = "#modal_add" ;        
        createmodal(url,data,divform,idmodal); 
    });

</script>