<style>        
    .margin-input{margin-bottom: -2% !important;}
    .boldp{
        font-weight: 700;
    }
    .dataTables_filter{display: block !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Download</li>
        <li class="breadcrumb-item active">..::: Data SPPB BC23 :::..</li>
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
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input persppb">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">No SPPB</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="No_Sppb23"  name="No_Sppb23"
                                            autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input persppb">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Tgl SPPB</label>
                                        <div class="col-sm-8">

                                            <input type="text" class="form-control form-control-sm datepicker-dropdowns" id="Tgl_Sppb23"  name="Tgl_Sppb23" value="<?php echo date('d-m-Y') ?>" >
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input persppb">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">NPWP IMP</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="NPWP_Imp"  name="NPWP_Imp"
                                            autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input perkdgudang">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Kode Gudang</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="Kd_Gudang"  name="Kd_Gudang"
                                            autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input perkdasp">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Kode ASP</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="Kd_ASP"  name="Kd_ASP"
                                            autocomplete="off">
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
                            <div class="table-container" style="width:100%;"> 

                                <div class="form-group row gutters" style="margin-top:-0.5%;padding: 0 0 0 5px;text-align: center;font-size: 110%;">
                                    <label for="inputName" class="col-sm-12 col-form-label boldp">SPPB PIB (2.0) HEADER</label>
                                </div>

                                <div class="table-responsive" style="margin-top: -1%;">
                                    <table id="tbl_respon_sppb23" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>CAR</th>
                                                <th>NO_SPPB23</th>
                                                <th>TGL_SPPB23</th>
                                                <th>KD_KANTOR_PENGAWAS</th>
                                                <th>KD_KANTOR_BONGKAR</th>
                                                <th>NO_PIB</th>
                                                <th>TGL_PIB</th>
                                                <th>NPWP_IMP</th>
                                                <th>NAMA_IMP</th>
                                                <th>ALAMAT_IMP</th>
                                                <th>NPWP_PPJK</th>                                    
                                                <th>NAMA_PPJK</th>
                                                <th>ALAMAT_PPJK</th>
                                                <th>NM_ANGKUT</th>
                                                <th>NO_VOY_FLIGHT</th>
                                                <th>BRUTO</th>
                                                <th>NETTO</th>
                                                <th>GUDANG</th>
                                                <th>STATUS_JALUR</th>
                                                <th>JML_CONT</th>
                                                <th>NO_BC11</th>
                                                <th>TGL_BC11</th>
                                                <th>NO_POS_BC11</th>
                                                <th>NO_BL_AWB</th>
                                                <th>TG_BL_AWB</th>
                                                <th>NO_MASTER_BL_AWB</th>
                                                <th>TG_MASTER_BL_AWB</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                     
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-12 col-12">
                            <div class="table-container" style="width:100%;"> 

                                <div class="form-group row gutters" style="margin-top:-1%;padding: 0 0 0 5px;text-align: center;font-size: 110%;">
                                    <label for="inputName" class="col-sm-12 col-form-label boldp">SPPB PIB (2.0) CONTAINER</label>
                                </div>

                                <div class="table-responsive" style="margin-top: -3%;">
                                    <table id="tbl_respon_sppb23_container" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>ID_DET</th>
                                                <th>CAR</th>
                                                <th>NO_CONT</th>
                                                <th>SIZE</th> 
                                                <th>JNS_MUAT</th>                     
                                            </tr>
                                        </thead>
                                        <tbody>                                     
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>


                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-12 col-12">
                            <div class="table-container" style="width:100%;"> 

                                <div class="form-group row gutters" style="margin-top:-1%;padding: 0 0 0 5px;text-align: center;font-size: 110%;">
                                    <label for="inputName" class="col-sm-12 col-form-label boldp">SPPB PIB (2.0) KEMASAN</label>
                                </div>

                                <div class="table-responsive" style="margin-top: -3%;">
                                    <table id="tbl_respon_sppb23_kms" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>ID_DET</th>
                                                <th>CAR</th>
                                                <th>JNS_KMS</th>
                                                <!-- <th>MERK_KMS</th>    -->
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

    var tbl_respon_sppb23 ;
    var tbl_respon_sppb23_container ;
    var tbl_respon_sppb23_kms ;
    var param_alert = "" ;
    var ID = "" ;

    $(document).ready(function(){
        show_perkdgudang();        
        get_sppb23();
    });

    function show_persppb(){
        $('.persppb').css('display','block');
        $('.perkdgudang').css('display','none');
        $('.perkdasp').css('display','none');
        param_alert = "persppb" ;
    }

    function show_perkdgudang(){
        $('.persppb').css('display','none');
        $('.perkdgudang').css('display','block');
        $('.perkdasp').css('display','none');
        param_alert = "perkdgudang" ;
    }

    function show_perkdasp(){
        $('.persppb').css('display','none');
        $('.perkdgudang').css('display','none');
        $('.perkdasp').css('display','block');
        param_alert = "perkdasp" ;
    }

    $("#nmservice").change(function() {
        if(this.value == "GetSppb_Bc23"){
            show_persppb();
        }else if(this.value == "GetBC23Permit"){
            show_perkdgudang();
        }else{
            show_perkdasp();
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

        if(param_alert == "perkdgudang"){

            if($('#Kd_Gudang').val() == ""){
                alert('Kd_Gudang Harus Diisi..');
                $('#Kd_Gudang').focus();
                return;
            }

        }else if(param_alert == "persppb"){

            if($('#Tgl_Sppb23').val() == ""){
                alert('Tgl_Sppb23 Harus Diisi..');
                $('#Tgl_Sppb23').focus();
                return;
            }

            if($('#No_Sppb23').val() == ""){
                alert('No_Sppb23 Harus Diisi..');
                $('#No_Sppb23').focus();
                return;
            }

            if($('#NPWP_Imp').val() == ""){
                alert('NPWP_Imp Harus Diisi..');
                $('#NPWP_Imp').focus();
                return;
            }

        }else{

            if($('#Kd_ASP').val() == ""){
                alert('Kd_ASP Harus Diisi..');
                $('#Kd_ASP').focus();
                return;
            }


        }

        url = '<?php echo site_url('download/sppb_bc/download') ?>';
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
        get_sppb23();
    });


    function get_sppb23(){
        url = '<?php echo site_url('download/sppb_bc/load_data') ?>';
        data = {ID:ID} ; 
        pesan = 'JavaScript load_data Error...';
        dataok = multi_ajax_proses(url, data, pesan);

        //console.log(dataok.data_sppb23_cont) ;

        tbl_data_containerM('tbl_respon_sppb23',dataok.data_sppb23,dataok.jml_data_sppb23);

        tbl_data_container('tbl_respon_sppb23_container',dataok.data_sppb23_cont,dataok.jml_data_sppb23_cont);
        tbl_data_container('tbl_respon_sppb23_kms',dataok.data_sppb23_kms,dataok.jml_data_sppb23_kms);
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
        tbl_respon_sppb23 = $('#tbl_respon_sppb23').DataTable({
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

    $('#tbl_respon_sppb23').on('click', 'tr', function () {
       var data = tbl_respon_sppb23.row(this).data();
       if ($(this).hasClass('selected')) {
            ID = '';
            $(this).removeClass('selected');
        } else {
            ID = data[1];
            tbl_respon_sppb23.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');            
        }

        url = '<?php echo site_url('download/sppb_bc/load_data') ?>';
        data = {ID:ID} ; 
        pesan = 'JavaScript load_data Error...';
        dataok = multi_ajax_proses(url, data, pesan);


        tbl_data_container('tbl_respon_sppb23_container',dataok.data_sppb23_cont,dataok.jml_data_sppb23_cont);
        tbl_data_container('tbl_respon_sppb23_kms',dataok.data_sppb23_kms,dataok.jml_data_sppb23_kms);

    });

</script>