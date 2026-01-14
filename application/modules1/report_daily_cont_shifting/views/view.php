<style>        
    .dataout {background-color: yellow !important;}
    .margin-input{margin-bottom: -2.5% !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Report</li>
        <li class="breadcrumb-item active">..::: Daily Container Shifting :::..</li>
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
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Start Date</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control datepicker-dropdowns" id="startdate"  name="startdate" value=<?php echo date('d-m-Y') ?> >
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">End Date</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control datepicker-dropdowns" id="enddate"  name="enddate" value=<?php echo date('d-m-Y') ?> >
                                    </div>
                                </div>
                            </div>

                        </div>
                        
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
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Status</label>
                                    <div class="col-sm-8">
                                        <?=$cont_status;?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Shifting Type</label>
                                    <div class="col-sm-8">
                                        <?=$change_description;?>
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
                                            <a class="dropdown-item btnprint"><span class="icon-print"></span>&nbsp;Print</a>
                                            <!-- <a class="dropdown-item btnexport"><span class="icon-download"></span>&nbsp;Export</a> -->
                                        </div>
                                    </div>

                                    <table id="tbl_daily_cont_shifting" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Container Number</th>
                                                <th>Danger</th>
                                                <th>Size/Type</th>
                                                <th>Condition</th>
                                                <th>Status</th>                                                
                                                <th>Date In</th>
                                                <th>Old Location</th>
                                                <th>New Location</th>
                                                <th>New Status</th>
                                                <th>Trans Date</th>
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
    var tbl_daily_cont_shifting;

    $(document).ready(function(){
        refresh_table();

        $("#startdate").change(function() {
            refresh_table();
        });

        $("#enddate").change(function() {
            refresh_table();
        });
    });

    $("#change_description").change(function() {
        refresh_table();
    });

    $("#cont_status").change(function() {
        refresh_table();
    });


    function refresh_table(){
        var startdate = $('#startdate').val();
        var enddate = $('#enddate').val();
        var code_principal = $('#code_principal').val();
        var cont_status = $('#cont_status').val();
        var change_description = $('#change_description').val();

        $('#tbl_daily_cont_shifting').DataTable().destroy();
        $("#tbl_daily_cont_shifting tbody").empty();

        var html = "" ;
        let no = 1 ;

        $.ajax({
            url: "<?php echo site_url('report/daily_cont_shifting/tbl_daily_cont_shifting') ?>",
            type: "POST",
            data: {startdate:startdate,enddate:enddate,code_principal:code_principal,cont_status:cont_status,change_description:change_description},
            dataType: "JSON",
            cache: false,
            "beforeSend": function() {
                $("#loading-wrapper").show();
            },
            success: function(data){

                // console.log(data);
                // return false;


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
                $('#tbl_daily_cont_shifting').append(html);        
                datatable();
                $('#tbl_daily_cont_shifting').DataTable().draw();  
            }
        }); 
             
    }

    function datatable(){
        tbl_daily_cont_shifting = $('#tbl_daily_cont_shifting').DataTable({
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


            if (IdElement == "code_principal") {

                url = '<?php echo site_url('report/daily_cont_shifting/search') ?>';
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
            }
        }
    }


    $(document).on('click', '.btnprint', function(e) {
        if($('#startdate').val()=="" || $('#enddate').val()=="" || $('#code_principal').val()=="" ){
            alert('Parameter Harap Terisi Semua...!!');
            return false;
        }


        var startdate = $('#startdate').val();
        var enddate = $('#enddate').val();
        var code_principal = $('#code_principal').val();
        var cont_status = $('#cont_status').val();
        var change_description = $('#change_description').val();
        var code_principal = $('#code_principal').val();
        var name_principal = $('#name_principal').val();

        var data = [];
        data[0] = startdate ;
        data[1] = enddate ;
        data[2] = code_principal ;
        data[3] = cont_status ;
        data[4] = change_description ;
        data[5] = code_principal ;
        data[6] = name_principal ;

        var page = "<?php echo base_url(); ?>report/daily_cont_shifting/print?data="+btoa(data) ;
        window.open(page);

    });



</script>