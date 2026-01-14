<style>        
    .dataout {background-color: yellow !important;}
    .margin-input{margin-bottom: -2.5% !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Transaction</li>
        <li class="breadcrumb-item active">..::: Shifting Overview :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >

            <div class="card">
                <div class="card-body boxshadow">

                    <div class="row gutters border" style="padding-top:0.6%;margin-bottom: -0%;">

                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                            
                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Cont Number</label>
                                    <div class="col-sm-8">
                                        <input type="text" onkeypress="KeyPressEnter(event,this.id)" class="form-control form-control-sm hrufbesar" id="cont_number" name="cont_number">
                                    </div>
                                </div>
                            </div> 
                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Principal Code</label>
                                    <div class="col-sm-8">
                                        <input type="text" onkeypress="KeyPressEnter(event,this.id)" class="form-control form-control-sm hrufbesar" id="code_principal" name="code_principal">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Type/Size</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control form-control-sm hrufbesar" id="reff_code" name="reff_code">
                                    </div>
                                </div>
                            </div> 
                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Date In</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control form-control-sm hrufbesar" id="cont_date_in" name="cont_date_in">
                                    </div>
                                </div>
                            </div>
                        </div>


                        

                    </div>

                    <!-- <div style="border-top: 5px double black; margin-top: 1em; padding-top: 1em;"> </div> -->
                    <!--
                        dotted : Putus-putus kecil /burik dengan tebal garis 2px
                        solid : Garis padat dengan tebal garis 2px
                        double : Garis ganda dengan tebal garis 6px
                        groove : Alur dengan tebal garis 6px
                        ridge : punggungan dengan tebal garis 6px
                    -->
                    
                        <div class="row gutters">
                            <div class="table-container"> 
                                <div class="table-responsive" style="margin-top: 1%">
                                    <div class="btn-group" style="margin-bottom:0.3%">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" id="showaksi">
                                            <a class="dropdown-item btndelete"><span class="icon-x-circle"></span>&nbsp;Clear</a>
                                            <a class="dropdown-item btnprint"><span class="icon-print"></span>&nbsp;Print</a>
                                        </div>
                                    </div>

                                    <table id="tbl_cont_shifting_overview" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Container Number</th>
                                                <th>Date Transfer</th>
                                                <th>Date Stripping</th>
                                                <th>Date Stuffing</th>
                                                <th>Status</th>
                                                <th>Condition</th>
                                                <th>New Location</th>
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



<script src="<?= site_url(); ?>assets/js/jquery.min.js"></script>


<script type="text/javascript">
    var tbl_cont_shifting_overview;

    $(document).ready(function(){
        refresh_table();
    });

    function refresh_table(){
        var cont_number = $('#cont_number').val();
        var code_principal = $('#code_principal').val();
        var reff_code = $('#reff_code').val();
        var cont_date_in = $('#cont_date_in').val();
        
        $('#tbl_cont_shifting_overview').DataTable().destroy();
        $("#tbl_cont_shifting_overview tbody").empty();
        
        url = '<?php echo site_url('transaksi/shifting_overview/tbl_cont_shifting_overview') ?>';
        data = {
            cont_number:cont_number,
            code_principal:code_principal,
            reff_code:reff_code,
            cont_date_in:cont_date_in
        };
        pesan = 'function tbl_cont_shifting_overview gagal';
        dataok = multi_ajax_proses(url, data, pesan);
        console.log(dataok.table_data);
        
        $('#tbl_cont_shifting_overview').append(dataok.table_data);
        
        datatable();
        $('#tbl_cont_shifting_overview').DataTable().draw();        
    }

    function datatable(){
        tbl_cont_shifting_overview = $('#tbl_cont_shifting_overview').DataTable({
            "searching": false,
            "paging":false,
            "info":false,
            "ordering": false,
            "lengthMenu": [50,100,1000],
            "pageLength": 50,
            //"dom": '<"toolbardetail">frtip',
            "createdRow": function( row, data, dataIndex){
                // console.log(data);
                // if( data[0] == 'satu'){
                //     $(row).addClass('warnasatu');
                // }else{
                //     $(row).addClass('warnadua');
                // }
            }
            ,   
            "columnDefs": [
                // {
                //     "targets": [0],
                //     "visible": false
                // }
                // ,
                // {
                //     "targets": [4,5,6],
                //     "className": "text-center" //dt-body-right dt-body-center dt-body-left
                // }                
            ]
        });
        
        // var toolbardetail = '<div class="float-sm-left float-md-left float-lg-left float-xl-left">\n\
        //                     <button type="button" class="btn btn-sm btn-raised gradient-crystal-clear white shadow-big-navbar mr-1 buttonku btnexport" style="margin-bottom: -0.5% !important">\n\
        //                         <i class="fa fa-download"></i> Export</button>\n\
        //                     </div>';

        // $("div.toolbardetail").html(toolbardetail);
    }
    
    function KeyPressEnter(event, IdElement) {
        if (event.keyCode == 13) { 
            if (IdElement == "cont_number") {
                $('#reff_code').val('');
                $('#cont_date_in').val('');
                $('#code_principal').val('');


                url = '<?php echo site_url('transaksi/shifting_overview/search') ?>';
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
                $('#reff_code').val('');
                $('#cont_date_in').val('');

                url = '<?php echo site_url('transaksi/shifting_overview/search') ?>';
                data = {cont_number:$('#cont_number').val(),code_principal:$('#code_principal').val()};
                pesan = 'JavaScript Search Error...';
                dataok = multi_ajax_proses(url, data, pesan);
                console.log(dataok);
                
                if(dataok.msg != "Ya"){
                    alert(dataok.pesan);
                    return false;
                }

                $('#reff_code').val(dataok['array_search'][0]['reff_code']);
                $('#cont_date_in').val(dataok['array_search'][0]['cont_date_in2']);
                
                refresh_table();
            }
        }
    }

    $(document).on('click', '.btndelete', function(e) {
        $('#cont_number').val('');
        $('#code_principal').val('');
        $('#reff_code').val('');
        $('#cont_date_in').val('');
        refresh_table();
    });
    
    $(document).on('click', '.btnprint', function(e) {
        if($('#cont_number').val()=="" || $('#code_principal').val()=="" || $('#reff_code').val() == "" || $('#cont_date_in').val()=="" ){
            alert('Parameter Harap Terisi Semua...!!');
            return false;
        }

        var data = [];
        data[0] = $('#cont_number').val()
        data[1] = $('#code_principal').val()
        data[2] = $('#reff_code').val()
        data[3] = $('#cont_date_in').val()

        var page = "<?php echo base_url(); ?>transaksi/shifting_overview/print?data="+btoa(data) ;
        window.open(page);

    });


</script>