<style>        
    .cmba {background-color: #09f979 !important;}
    .gmba {background-color: #f7ee91 !important;}
    .margin-input{margin-bottom: -2% !important;}
    .boldp{
        font-weight: 700;
    }
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Download</li>
        <li class="breadcrumb-item active">..::: Respon PLP OnDemands :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="card">
                <div class="card-body boxshadow">
                    <form id="submit" class="form-horizontal" method="post" action="#" enctype="multipart/form-data">
                        <div class="row gutters" style="padding-top:0.6%;margin-bottom: -0%;">                                            
                            <div class="col-xl-3 col-lglg-3 col-md-3 col-sm-3 col-12">
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Username</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="Username"  name="Username" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">Password</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control form-control-sm" id="Password"  name="Password" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">NO PLP</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="No_plp"  name="No_plp" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">TGL PLP</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control datepicker-dropdowns" id="Tgl_plp"  name="Tgl_plp" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">KD GUDANG</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="KdGudang"  name="KdGudang" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                    <div class="form-group row gutters">
                                        <label for="inputName" class="col-sm-4 col-form-label text-left">REF NUMBER</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="RefNumber"  name="RefNumber" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                    <div style="float: right !important;">
                                        <button type="submit" style="width:100%;" class="btn btn-primary" id="btndownload"><b><span class="icon-download1"></span>Download Data</b></button>
                                    </div>                                    
                                </div>
                            </div>

                            <div class="col-xl-2 col-lglg-2 col-md-2 col-sm-2 col-12">

                            </div>

                            <div class="col-xl-4 col-lglg-3 col-md-3 col-sm-3 col-12">

                            </div>

                        </div>
                    </form>

                    
                    <div class="row gutters" style="margin-top:1%">                        
                        <div class="col-xl-8 col-lglg-8 col-md-8 col-sm-8 col-12">
                            <div class="table-container" style="width:100%"> 

                                <div class="form-group row gutters" style="margin-top:-1%;padding: 0 0 0 5px;text-align: center;font-size: 150%;">
                                    <label for="inputName" class="col-sm-12 col-form-label boldp">Tabel Respon Header</label>
                                </div>

                                <div class="card-body" style="margin-top:-3%;margin-bottom:-3%">
                                    <div class="row gutters">        
                                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group row gutters">
                                                <label for="inputName" class="col-sm-4 col-form-label text-left">Cari Data</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="search"  name="search" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group row gutters">
                                                <label for="inputName" class="col-sm-4 col-form-label text-left">Jenis Container</label>
                                                <div class="col-sm-8">
                                                    <?=$GUDANG_TUJUAN;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="table-responsive">
                                    <table id="tbl_petikemas_header" class="table m-0 dataTable no-footer nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>ID_TRANSFER</th>
                                                <th>Transfer</th>
                                                <th>KD_KANTOR</th> 
                                                <th>KD_TPS_ASAL</th>
                                                <th>KD_TPS_TUJUAN</th>
                                                <th>REF_NUMBER</th>
                                                <th>GUDANG_ASAL</th>                                           
                                                <th>GUDANG_TUJUAN</th>
                                                <th>NO_PLP</th>
                                                <th>TGL_PLP</th>
                                                <th>ALASAN_REJECT</th>
                                                <th>CALL_SIGN</th>
                                                <th>NM_ANGKUT</th>
                                                <th>NO_VOY_FLIGHT</th>
                                                <th>TGL_TIBA</th>
                                                <th>NO_BC11</th>
                                                <th>TGL_BC11</th>
                                                <th>NO_SURAT</th>
                                                <th>TGL_SURAT</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                     
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                            <div class="table-container" style="width:100%"> 

                                <div class="form-group row gutters" style="margin-top:-1%;padding: 0 0 0 5px;text-align: center;font-size: 150%;">
                                    <label for="inputName" class="col-sm-12 col-form-label boldp">Tabel Respon Detail</label>
                                </div>

                                <div class="table-responsive" style="margin-top:-5%">
                                    <table id="tbl_petikemas_detail" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID</th>    
                                                <th>ID_DET</th> 
                                                <th>NO_CONT</th> 
                                                <th>UK_CONT</th> 
                                                <th>JNS_CONT</th>
                                                <th>NO_POS_BC11</th>   
                                                <th>CONSIGNEE</th>                                     
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
    var tbl_petikemas_header ;
    var tbl_petikemas_detail ;
    var ID = "" ;
    var url ; 
    var data ; 
    var divform ; 
    var idmodal ;

    $('#search').on('keyup',function () {
        tbl_petikemas_header.search(this.value).draw();
    });

    $("#GUDANG_TUJUAN").change(function() {
        tbl_petikemas_header.search(this.value).draw();
    });

    $(document).ready(function(){
        tbl_petikemas_header = $('#tbl_petikemas_header').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
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
            "ajax": {
                "url": "<?php echo site_url('download/GetResponPLP_onDemands/tbl_petikemas_header') ?>",
                "type": "POST",
                "beforeSend": function() {
                        $("#loading-wrapper").show();
                    },
                "data": function(data) {
                    data.GUDANG_TUJUAN = $('#GUDANG_TUJUAN').val();
                },
                "complete": function() {
                        $("#loading-wrapper").hide();
                        //tbl_petikemas_header.$('tr.selected').removeClass('selected');
                        //tbl_petikemas_header.row(selectbaris).nodes().to$().toggleClass( 'selected' );
                        
                        //var data = tbl_petikemas_header.row(selectbaris).data();
                        //id_beacukai = data[1];
                    }

            },
            "createdRow": function( row, data, dataIndex){
                // if(data[9] == 'CMBA'){
                //     $(row).addClass('cmba');
                // }
                // if(data[9] == 'GMBA'){
                //     $(row).addClass('gmba');
                // }
            },
            "columnDefs": [
                {
                    "targets": [0,1,2],
                    "orderable": false
                }
                ,
                {
                    "targets": [1,2],
                    "visible": false
                }
               // {
               //     "targets": [2],
               //     "className": "dt-body-center" //dt-body-right dt-body-center dt-body-left
               // }
            ]
        });

        $('#tbl_petikemas_header tbody').on('click', 'tr', function() {
            var data = tbl_petikemas_header.row(this).data();

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                ID = '' ;
                tbl_petikemas_detail.ajax.reload(null, false);
            } else {
                tbl_petikemas_header.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                ID = data[1];                
                tbl_petikemas_detail.ajax.reload(null, false);
            }
        });

        // $('#tbl_petikemas_header tbody').on('dblclick', 'tr', function() {
        //     var data = tbl_petikemas_header.row(this).data();
        //     ID = data[1];
        //     tbl_petikemas_detail.ajax.reload(null, false);

            // url = '<?php echo site_url('download/GetResponPLP_Tujuan/form_transfer') ?>';
            // data = {ID:ID} ;
            // divform = "#div_popup_form" ;
            // idmodal = "#modal_transfer" ;        
            // createmodal(url,data,divform,idmodal); 

            
        // });



        tbl_petikemas_detail = $('#tbl_petikemas_detail').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "searching": false,
            "ordering": true,
            "scrollX": true,
            "scrollY": "200px",
            "scrollCollapse": true,
            "info": true,
            "lengthMenu": [[10, 25, 50,100, 1000], [10, 25, 50,100, 1000]],
            "pageLength": 1000,
            "bLengthChange": true,
            "ajax": {
                "url": "<?php echo site_url('download/GetResponPLP_onDemands/tbl_petikemas_detail') ?>",
                "type": "POST",
                "beforeSend": function() {
                        $("#loading-wrapper").show();
                    },
                "data": function(data) {
                    data.ID = ID ;
                },
                "complete": function() {
                        $("#loading-wrapper").hide();
                        //tbl_petikemas_detail.$('tr.selected').removeClass('selected');
                        //tbl_petikemas_detail.row(selectbaris).nodes().to$().toggleClass( 'selected' );
                        
                        //var data = tbl_petikemas_detail.row(selectbaris).data();
                        //id_beacukai = data[1];
                    }

            },
            "createdRow": function( row, data, dataIndex){
                // if(data[2] == 0){
                //     $(row).addClass('sudahtransfer');
                // }
            },
            "columnDefs": [
                {
                    "targets": [0,1,2],
                    "orderable": false
                }
                ,
                {
                    "targets": [1,2],
                    "visible": false
                }
            ]
        });
    });
    
    $('#submit').submit(function(e){
        e.preventDefault(); 

        url = '<?php echo site_url('download/GetResponPLP_onDemands/download') ?>';
        data = new FormData(this); 
        pesan = 'JavaScript Download GetResponPLP_Tujuan Error...';
        dataok = submit_ajax_proses(url, data, pesan);
        console.log(dataok);

        if(dataok.msg != "Ya"){
            alert(dataok.pesan); 
            return;
        }

        alert(dataok.pesan);
        tbl_petikemas_header.ajax.reload(null, false);
        tbl_petikemas_detail.ajax.reload(null, false);

    });

    function transfer_plp(ID){

        var jawab = confirm('Fungsi ini Untuk Mentransfer Data Kedata PLP Utama (Persetujuan PLP) ..!!');

        if (jawab === true) { 
            url = '<?php echo site_url('download/GetResponPLP_onDemands/transfer_plp') ?>';
            data = {ID: ID};
            pesan = 'JavaScript transfer_plp Error...';
            dataok = multi_ajax_proses(url, data, pesan);
        }else{
            return false;
        }

        console.log(dataok) ;

        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }

        alert(dataok.pesan);
        tbl_petikemas_header.ajax.reload(null, false);
        tbl_petikemas_detail.ajax.reload(null, false);
    }

    

</script>