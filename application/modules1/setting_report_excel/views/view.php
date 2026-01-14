<style>        
    .dataout {background-color: yellow !important;}
    .margin-input{margin-bottom: -2.5% !important;}
    .table > thead > tr > th {vertical-align: middle;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Transaction</li>
        <li class="breadcrumb-item active">..::: Setting Report Excel :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >

            <div class="card">
                <div class="card-body boxshadow">

                    <!-- <div class="row gutters border" style="padding-top:0.6%;margin-bottom: -0%;">

                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:2%">
                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-12 col-form-label text-left hrufbesar" style="font-size: 20px;font-weight: 400;">Search Data...</label>
                                </div>
                            </div>
                        </div>

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

                        </div>

                    </div>

                    <div style="border-top: 5px double black; margin-top: 1em; padding-top: 1em;"> </div> -->

                    

                        <div class="row gutters">
                            <div class="table-container" style="width:100%"> 
                                <div class="table-responsive" style="margin-top: 1%;">

                                    <div class="btn-group" style="margin-bottom:0.3%">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" id="showaksi">
                                            <a class="dropdown-item btnupload"><span class="icon-upload"></span>&nbsp;Upload</a>
                                            <a class="dropdown-item btnexport"><span class="icon-download"></span>&nbsp;Export</a>
                                        </div>
                                    </div>

                                    <table id="tbl_excel_configuration" class="table m-0 dataTable no-footer" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>id_excel</th>
                                                <th>Sheet Ke</th>
                                                <th>Title File</th>
                                                <th>Name Sheet</th>
                                                <th>Setting Template</th>
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
    var tbl_excel_configuration ;
    var id_excel;

    $(document).ready(function(){
        refresh_table();
    });

    function refresh_table(){
        
        $('#tbl_excel_configuration').DataTable().destroy();
        $("#tbl_excel_configuration tbody").empty();
        
        var html = "" ;
        let no = 1 ;
        $.ajax({
            url: "<?php echo site_url('setting/report_excel/tbl_excel_configuration') ?>",
            type: "POST",
            data: "",
            dataType: "JSON",
            cache: false,
            "beforeSend": function() {
                $("#loading-wrapper").show();
            },
            success: function(data){

                console.log(data);
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
                $('#tbl_excel_configuration').append(html);        
                datatable();
                $('#tbl_excel_configuration').DataTable().draw();  
            }
        });
              
    }

    function datatable(){
        tbl_excel_configuration = $('#tbl_excel_configuration').DataTable({
            "searching": true,
            "paging":true,
            "info":true,
            "ordering": true,
            "scrollX": true,
            "scrollCollapse": true,
            "lengthMenu": [[10, 25, 50,100, 1000], [10, 25, 50,100, 1000]],
            "pageLength": 10,
            "columnDefs": [
            {
                "targets": [0],
                "orderable": false
            }
            // ,
            // {
            //     "targets": [1],
            //     "visible": false
            // }
            ]
        });

    }

    $('#tbl_excel_configuration tbody').on('click', 'tr', function() {
        var data = tbl_excel_configuration.row(this).data();

        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            id_excel = '' ;
        } else {
            tbl_excel_configuration.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');

            id_excel = data[1];         
        }
    });
    
    $(document).on('click', '.btnupload', function(e) {
        
        $.post('<?php echo site_url() ?>setting/report_excel/frmupload', {
            //param_form: 'search_nmimportir',
        },
        function(xx) {
            $('#div_popup_form').html(xx);
            $("#modal_upload").modal({
                show: true,
                backdrop: 'static',
            });
            $('.modal-title').text('Upload Data Xls');
        });
    });

    $(document).on('click', '.btnexport', function(e) {
        alert('btnexport');
    });


</script>