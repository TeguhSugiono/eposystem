<style>        
    .dataout {background-color: yellow !important;}
    .margin-input{margin-bottom: -2.5% !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Transaction</li>
        <li class="breadcrumb-item active">..::: Data In Out Container :::..</li>
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
                                    <label for="inputName" class="col-sm-5 col-form-label text-left">Container Number</label>
                                    <div class="col-sm-7">
                                        <input type="text" onkeypress="KeyPressEnter(event,this.id)" class="form-control form-control-sm hrufbesar" id="cont_number" name="cont_number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-5 col-form-label text-left">Principal Code</label>
                                    <div class="col-sm-2">
                                        <input type="text" onkeypress="KeyPressEnter(event,this.id)" class="form-control form-control-sm hrufbesar" id="code_principal" name="code_principal">
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control form-control-sm hrufbesar" id="name_principal" name="name_principal">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-5 col-form-label text-left">Tahun Masuk</label>
                                    <div class="col-sm-7">
                                        <?=$cont_date_in;?>
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

                                    <table id="tbl_in_out_container" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bon Bongkar</th>
                                                <th>Principal</th>
                                                <th>Container</th>
                                                <th>Size</th>
                                                <th>Condition</th>
                                                <th>Status</th>                                       
                                                <th>Date In</th>
                                                <th>Time In</th>
                                                <th>Date Out</th>
                                                <th>Time Out</th>
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
    var tbl_in_out_container;

    $(document).ready(function(){
        refresh_table();
    });

    $('#cont_date_in').change(function () {          
        refresh_table();
    });

    function refresh_table(){
        var code_principal = $('#code_principal').val();
        var cont_number = $('#cont_number').val();
        var cont_date_in = $('#cont_date_in').val();

        
        $('#tbl_in_out_container').DataTable().destroy();
        $("#tbl_in_out_container tbody").empty();

        var html = "" ;
        let no = 1 ;

        //$("#loading-wrapper").show();
        $.ajax({
            url: "<?php echo site_url('transaksi/in_out_container/tbl_in_out_container') ?>",
            type: "POST",
            data: {code_principal:code_principal,cont_number:cont_number,cont_date_in:cont_date_in},
            dataType: "JSON",
            cache: false,
            "beforeSend": function() {
                $("#loading-wrapper").show();
            },
            success: function(data){
                for(let a=0;a<data.table_data.length;a++){
                    html = html+'<tr>' ;

                    html = html+'<td>' ;
                    html = html+no;
                    html = html+'</td>' ;

                    for (var key in data.table_data[a]) {
                        html = html+'<td>' ;
                        html = html+data.table_data[a][key] ;
                        html = html+'</td>' ;
                    }

                    html = html+'</tr>' ;
                    no++;
                }             
            },
            complete: function(){
                $("#loading-wrapper").hide();
                $('#tbl_in_out_container').append(html);        
                datatable();
                $('#tbl_in_out_container').DataTable().draw();  
            }
        }); 
              
    }

    function datatable(){
        tbl_in_out_container = $('#tbl_in_out_container').DataTable({
            "searching": true,
            "paging":true,
            "info":true,
            "ordering": true,
            "lengthMenu": [10,100,1000],
            "pageLength": 10,
        });
        

    }
    
    function KeyPressEnter(event, IdElement) {
        if (event.keyCode == 13) { 

            if (IdElement == "cont_number") {
                url = '<?php echo site_url('transaksi/in_out_container/search') ?>';
                data = {cont_number:$('#cont_number').val(),cont_date_in:$('#cont_date_in').val()};
                pesan = 'JavaScript Search Error...';
                dataok = multi_ajax_proses(url, data, pesan);
                //console.log(dataok);
                
                if(dataok.msg != "Ya"){
                    alert(dataok.pesan);
                    return false;
                }

                $('#code_principal').focus();
                refresh_table();
            }

            if (IdElement == "code_principal") {
                url = '<?php echo site_url('transaksi/in_out_container/search') ?>';
                data = {code_principal:$('#code_principal').val(),cont_date_in:$('#cont_date_in').val()};
                pesan = 'JavaScript Search Error...';
                dataok = multi_ajax_proses(url, data, pesan);
                //console.log(dataok);
                
                if(dataok.msg != "Ya"){
                    alert(dataok.pesan);
                    return false;
                }
                $('#name_principal').val(dataok['array_search'][0]['name_principal']);
                $('#cont_number').focus();
                refresh_table();
            }

        }
    }
    


</script>