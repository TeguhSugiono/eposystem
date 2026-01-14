<style>        
    .dataout {background-color: yellow !important;}
    .margin-input{margin-bottom: -2.5% !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Transaction</li>
        <li class="breadcrumb-item active">..::: Stock By Principal :::..</li>
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
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Principal Code</label>
                                    <div class="col-sm-2">
                                        <input type="text" onkeypress="KeyPressEnter(event,this.id)" class="form-control form-control-sm hrufbesar" id="code_principal" name="code_principal">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-sm hrufbesar" id="name_principal" name="name_principal">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Container Status</label>
                                    <div class="col-sm-8">
                                        <?=$cont_status;?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Total Container</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm hrufbesar" id="total_container" name="total_container" value="0" readonly>
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

                                    <table id="tbl_stock_by_principal" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Container Number</th>
                                                <th>Size/Type</th>
                                                <th>Status</th>
                                                <th>Condition</th>
                                                <th>Date In</th>
                                                <th>Location</th>
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
    var tbl_stock_by_principal;

    $(document).ready(function(){
        refresh_table();
    });

    $("#cont_status").change(function() {
        refresh_table();
        $('#total_container').val(tbl_stock_by_principal.page.info().recordsTotal);
    });

    function refresh_table(){
        var code_principal = $('#code_principal').val();
        var cont_status = $('#cont_status').val();

        
        $('#tbl_stock_by_principal').DataTable().destroy();
        $("#tbl_stock_by_principal tbody").empty();
        
        url = '<?php echo site_url('transaksi/stock_by_principal/tbl_stock_by_principal') ?>';
        data = {
            code_principal:code_principal,
            cont_status:cont_status
        };
        pesan = 'function tbl_stock_by_principal gagal';
        dataok = multi_ajax_proses(url, data, pesan);
        console.log(dataok.table_data);
        
        $('#tbl_stock_by_principal').append(dataok.table_data);
        
        datatable();
        $('#tbl_stock_by_principal').DataTable().draw();        
    }

    function datatable(){
        tbl_stock_by_principal = $('#tbl_stock_by_principal').DataTable({
            "searching": false,
            "paging":false,
            "info":false,
            "ordering": false,
            "lengthMenu": [50,100,1000],
            "pageLength": 50
        });
        

    }
    
    function KeyPressEnter(event, IdElement) {
        if (event.keyCode == 13) { 


            if (IdElement == "code_principal") {

                url = '<?php echo site_url('transaksi/stock_by_principal/search') ?>';
                data = {code_principal:$('#code_principal').val()};
                pesan = 'JavaScript Search Error...';
                dataok = multi_ajax_proses(url, data, pesan);
                console.log(dataok);
                
                if(dataok.msg != "Ya"){
                    alert(dataok.pesan);
                    return false;
                }
                $('#name_principal').val(dataok['array_search'][0]['name_principal']);

                
                refresh_table();
                $('#total_container').val(tbl_stock_by_principal.page.info().recordsTotal);
            }
        }
    }

    $(document).on('click', '.btndelete', function(e) {

        $('#code_principal').val('');
        refresh_table();
    });
    


</script>