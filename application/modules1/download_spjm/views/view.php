<style>        
    .margin-input{margin-bottom: -2% !important;}
    .boldp{
        font-weight: 700;
    }
    /*.dataTables_length{display: block !important;}*/
    .dataTables_filter{display: block !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Download</li>
        <li class="breadcrumb-item active">..::: Data SPJM :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="card">
                <div class="card-body boxshadow">
                    <form id="submit" class="form-horizontal" method="post" action="#" enctype="multipart/form-data">
                        <div class="row gutters" style="padding-top:0.6%;margin-bottom: -0%;">        
                            


                            <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Type</label>
                                        <div class="col-sm-8">
                                            <?=$nmservice;?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Username</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="Username"  name="Username" 
                                            autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Password</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control form-control-sm" id="Password"  name="Password"
                                            autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input per_tps">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Kd TPS</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="Kd_Tps"  name="Kd_Tps"
                                            autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input per_spjm">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">No PIB</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="noPib"  name="noPib"
                                            autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input per_spjm">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Tgl PIB</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="tglPib"  name="tglPib" value="<?php echo date('d-m-Y') ?>" >
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                    <div style="float: right !important;">
                                        <button type="submit" style="width:100%;" class="btn btn-primary" id="btndownload" id="btndownload"><b><span class="icon-download1"></span> Download Data</b></button>
                                    </div>                                    
                                </div>
                            </div>

                        </div>
                    </form>

                    
                    <div class="row gutters" style="margin-top: 1%;">                        
                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-container boxshadow" style="width:100%;padding: 5px 5px 5px 5px"> 

                                <div class="form-group row gutters" style="margin-top:-0.5%;padding: 0 0 0 5px;text-align: center;font-size: 110%;">
                                    <label for="inputName" class="col-sm-12 col-form-label boldp">SPJM HEADER</label>
                                </div>

                                <div class="table-responsive" style="margin-top: -1%;">
                                    <table id="tbl_respon_spjm" class="table m-0 dataTable no-footer nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>CAR</th>
                                                <th>KD_KANTOR</th>
                                                <th>NO_PIB</th>
                                                <th>TGL_PIB</th>
                                                <th>NPWP_IMP</th>
                                                <th>NAMA_IMP</th>
                                                <th>NPWP_PPJK</th>
                                                <th>NAMA_PPJK</th>
                                                <th>GUDANG</th>
                                                <th>JML_CONT</th>
                                                <th>NO_BC11</th>
                                                <th>TGL_BC11</th>
                                                <th>NO_POS_BC11</th>
                                                <th>FL_KARANTINA</th>     
                                                <th>NM_ANGKUT</th>
                                                <th>NO_VOY_FLIGHT</th>  
                                                <th>TGL_SPJM</th>                                     
                                            </tr>
                                        </thead>
                                        <tbody>                                     
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div style="margin-top: 5%;">
                        </div>    

                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                            <div class="table-container boxshadow" style="width:100%;padding: 5px 5px 5px 5px"> 

                                <div class="form-group row gutters" style="margin-top:-0.2%;padding: 0 0 0 5px;text-align: center;font-size: 110%;">
                                    <label for="inputName" class="col-sm-12 col-form-label boldp">SPJM DOCUMENT</label>
                                </div>

                                <div class="table-responsive" style="margin-top: -3%;">
                                    <table id="tbl_respon_spjm_document" class="table m-0 dataTable no-footer nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>ID_DET</th>
                                                <th>CAR</th>
                                                <th>JNS_DOK</th>
                                                <th>NO_DOK</th>       
                                                <th>TGL_DOK</th>               
                                            </tr>
                                        </thead>
                                        <tbody>                                     
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                            <div class="table-container boxshadow" style="width:100%;padding: 5px 5px 5px 5px"> 

                                <div class="form-group row gutters" style="margin-top:-0.2%;padding: 0 0 0 5px;text-align: center;font-size: 110%;">
                                    <label for="inputName" class="col-sm-12 col-form-label boldp">SPJM CONTAINER</label>
                                </div>

                                <div class="table-responsive" style="margin-top: -3%;">
                                    <table id="tbl_respon_spjm_container" class="table m-0 dataTable no-footer nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>ID_DET</th>
                                                <th>CAR</th>
                                                <th>NO_CONT</th>
                                                <th>SIZE</th> 
                                                <th>FL_PERIKSA</th>                     
                                            </tr>
                                        </thead>
                                        <tbody>                                     
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>


                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-12 col-12">
                            <div class="table-container boxshadow" style="width:100%;padding: 5px 5px 5px 5px"> 

                                <div class="form-group row gutters" style="margin-top:-0.2%;padding: 0 0 0 5px;text-align: center;font-size: 110%;">
                                    <label for="inputName" class="col-sm-12 col-form-label boldp">SPJM KEMASAN</label>
                                </div>

                                <div class="table-responsive" style="margin-top: -3%;">
                                    <table id="tbl_respon_spjm_kms" class="table m-0 dataTable no-footer nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>ID_DET</th>
                                                <th>CAR</th>
                                                <th>JNS_KMS</th>
                                                <th>MERK_KMS</th>   
                                                <th>JML_KMS</th>                      
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



<script src="<?= site_url(); ?>assets/js/jquery.min.js"></script>


<script type="text/javascript">

    var tbl_respon_spjm ;
    var tbl_respon_spjm_container ;
    var tbl_respon_spjm_document ;
    var tbl_respon_spjm_kms ;
    var param_alert = "" ;
    var ID = "" ;

    $(document).ready(function(){
        show_pertps();        
        get_spjm();

    });

    


    function get_spjm(){
        url = '<?php echo site_url('download/spjm/load_data') ?>';
        data = {ID:ID} ; 
        pesan = 'JavaScript load_data Error...';
        dataok = multi_ajax_proses(url, data, pesan);

        //console.log(dataok.data_spjm_cont) ;

        tbl_data_containerM('tbl_respon_spjm',dataok.data_spjm,dataok.jml_data_spjm);


        tbl_data_container('tbl_respon_spjm_container',dataok.data_spjm_cont,dataok.jml_data_spjm_cont);
        tbl_data_container('tbl_respon_spjm_document',dataok.data_spjm_doc,dataok.jml_data_spjm_doc);
        tbl_data_container('tbl_respon_spjm_kms',dataok.data_spjm_kms,dataok.jml_data_spjm_kms);
    }


    function show_pertps(){
        $('.per_tps').css('display','block');
        $('.per_spjm').css('display','none');
        param_alert = "per_tps" ;
    }

    function show_perspjm(){
        $('.per_tps').css('display','none');
        $('.per_spjm').css('display','block');
        param_alert = "per_spjm" ;
    }

    $("#nmservice").change(function() {
        if(this.value == "GetSPJM"){
            show_pertps();
        }else{
            show_perspjm();
        }
    });

    $('#submit').submit(function(e){
        e.preventDefault();
        
        if($('#Username').val() == ""){
            alert('UserName Harus Diisi..');
            $('#Username').focus();
            return;
        }

        if($('#Password').val() == ""){
            alert('Password Harus Diisi..');
            $('#Password').focus();
            return;
        }

        if(param_alert == "per_spjm"){
            if($('#noPib').val() == ""){
                alert('noPib Harus Diisi..');
                $('#noPib').focus();
                return;
            }
            if($('#tglPib').val() == ""){
                alert('tglPib Harus Diisi..');
                $('#tglPib').focus();
                return;
            }
        }else{
            if($('#Kd_Tps').val() == ""){
                alert('Kd_Tps Harus Diisi..');
                $('#Kd_Tps').focus();
                return;
            }
        }

        url = '<?php echo site_url('download/spjm/download') ?>';
        data = new FormData(this); 
        pesan = 'JavaScript download Error...';
        dataok = submit_ajax_proses(url, data, pesan);

        //console.log(dataok);

        if(dataok.msg != "Ya"){
            alert(dataok.pesan);
            return false;
        }

        alert(dataok.pesan);

        //console.log(dataok);
        get_spjm();
    });


    function tbl_data_container(IdDatatable,data,jml){
        $('#' + IdDatatable).DataTable().destroy();
        $('#' + IdDatatable + ' tbody').empty();

        var html = "" ;
        let no = 1 ;

        if(jml > 0){
            for(let a = 0 ; a < jml ; a++){
                html = html+'<tr>' ;
                    html = html+'<td>' ;
                        html = html+no;
                    html = html+'</td>' ;

                    for(let b = 0 ;b < data[a].length ; b++){
                        html = html+'<td>' ;
                            html = html+data[a][b];
                        html = html+'</td>' ;
                    }
                        

                html = html+'</tr>' ;
                no++;
            }

            $('#' + IdDatatable).append(html);        
            create_datatable(IdDatatable);
            $('#' + IdDatatable).DataTable().draw();  
        }else{
            create_datatable(IdDatatable);
            $('#' + IdDatatable).DataTable().draw();  
        }
    }

    function create_datatable(IdDatatable){
        tbl_data_respon = $('#' + IdDatatable).DataTable({
            "order": [],
            "searching": false,
            "ordering": true,
            "scrollX": true,
            "scrollY": "200px",
            "scrollCollapse": true,
            "info": true,
            "lengthMenu": [[10, 25, 50,100, 1000], [10, 25, 50,100, 1000]],
            "pageLength": 25,
            "bLengthChange": false,
            "columnDefs": [{
                        "targets": [0],
                        "orderable": false
                        }
                        ,
                        {
                            "targets": [1,2],
                            "visible": false
                        }]
        });
    }

    function tbl_data_containerM(IdDatatable,data,jml){
        $('#' + IdDatatable).DataTable().destroy();
        $('#' + IdDatatable + ' tbody').empty();

        var html = "" ;
        let no = 1 ;

        if(jml > 0){
            for(let a = 0 ; a < jml ; a++){
                html = html+'<tr>' ;
                    html = html+'<td>' ;
                        html = html+no;
                    html = html+'</td>' ;

                    for(let b = 0 ;b < data[a].length ; b++){
                        html = html+'<td>' ;
                            html = html+data[a][b];
                        html = html+'</td>' ;
                    }
                        

                html = html+'</tr>' ;
                no++;
            }

            $('#' + IdDatatable).append(html);        
            create_datatableM();
            $('#' + IdDatatable).DataTable().draw();  
        }else{
            create_datatableM();
            $('#' + IdDatatable).DataTable().draw();  
        }
    }

    

    function create_datatableM(){
        tbl_respon_spjm = $('#tbl_respon_spjm').DataTable({
            "order": [],
            "searching": true,
            "ordering": true,
            "scrollX": true,
            "scrollY": "200px",
            "scrollCollapse": true,
            "info": true,
            "lengthMenu": [[10, 25, 50,100, 1000], [10, 25, 50,100, 1000]],
            "pageLength": 25,
            "bLengthChange": true,
            "columnDefs": [{
                        "targets": [0],
                        "orderable": false
                        }
                        ,
                        {
                            "targets": [1],
                            "visible": false
                        }
                        ]
        });

    }

    $('#tbl_respon_spjm').on('click', 'tr', function () {
       var data = tbl_respon_spjm.row(this).data();
       if ($(this).hasClass('selected')) {
            ID = '';
            $(this).removeClass('selected');
        } else {
            ID = data[1];
            tbl_respon_spjm.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');            
        }

        url = '<?php echo site_url('download/spjm/load_data') ?>';
        data = {ID:ID} ; 
        pesan = 'JavaScript load_data Error...';
        dataok = multi_ajax_proses(url, data, pesan);

        tbl_data_container('tbl_respon_spjm_container',dataok.data_spjm_cont,dataok.jml_data_spjm_cont);
        tbl_data_container('tbl_respon_spjm_document',dataok.data_spjm_doc,dataok.jml_data_spjm_doc);
        tbl_data_container('tbl_respon_spjm_kms',dataok.data_spjm_kms,dataok.jml_data_spjm_kms);

    });

</script>