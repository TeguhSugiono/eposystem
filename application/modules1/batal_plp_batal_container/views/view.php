<style>        
    .validate {background-color: white !important;}
    .notvalidate {background-color: #e5e7eb !important;}
    .margin-input{margin-bottom: -2% !important;}
    .boldp{
        font-weight: 700;
    }
    /*.dataTables_filter{display: block; !important;}*/
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Batal PLP</li>
        <li class="breadcrumb-item active">..::: Container :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="card">
                <div class="card-body boxshadow">

                    <div class="row gutters border" style="padding-top:0.6%;margin-bottom: -0%;">
                        <div class="col-xl-3 col-lglg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group row gutters">
                                <label for="inputName" class="col-sm-5 col-form-label text-left">STATUS KIRIM</label>
                                <div class="col-sm-7">
                                    <?=$SENDING;?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lglg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group row gutters">
                                <label for="inputName" class="col-sm-5 col-form-label text-left">Cari Data</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="search"  name="search">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lglg-3 col-md-3 col-sm-12 col-12">
                            <div class="form-group row gutters">
                                <label for="inputName" class="col-sm-5 col-form-label text-left">Tampilkan</label>
                                <div class="col-sm-7">
                                    <?=cbodisplay();?>
                                </div>
                            </div>
                        </div>


                    </div>

                    
                    <div class="row gutters" style="margin-top:1%">                        
                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-container" style="width:100%"> 

                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-12 col-form-label boldp"></label>
                                </div>

                                <div class="table-responsive" style="margin-top:-2%;padding: 1px 1px 40px 1px;">

                                    <button class="btn btn-primary col-sm-2" id="btnimport" id="btnimport"><b><span class="icon-control_point"></span>Import From FCL</b></button>
                                    <button class="btn btn-primary col-sm-2" id="btnedit" id="btnedit"><b><span class="icon-edit"></span>Edit</b></button>
                                    <button class="btn btn-primary col-sm-2" id="btnexport" id="btnexport"><b><span class="icon-download"></span>Export</b></button>
                                    <button class="btn btn-primary col-sm-2" id="btnsend" id="btnsend"><b><span class="icon-share1"></span>Send Data</b></button>  
                                    <div style="margin-bottom:0.4%"></div>

                                    <table id="tbl_batal_plp" class="table m-0 dataTable no-footer nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NO_CONT</th>
                                                <th>UK_CONT</th>
                                                <th>REF_NUMBER</th>
                                                <th>NO_SURAT</th>
                                                <th>TGL_SURAT</th>
                                                <th>NO_PLP</th>   
                                                <th>TGL_PLP</th>
                                                <th>KD_KANTOR</th>
                                                <th>TIPE_DATA</th>                                                
                                                <th>KD_TPS</th>      
                                                <th>ALASAN</th>
                                                <th>NO_BC11</th>
                                                <th>TGL_BC11</th>
                                                <th>NM_PEMOHON</th>  
                                                <th>SENDING</th>                                               
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
    var tbl_batal_plp ;
    var dataArrayTabel = [] ;

    $('#search').on('keyup',function () {
        tbl_batal_plp.search(this.value).draw();
    });
    
    $("#display").change(function() {
        tbl_batal_plp.page.len(this.value).draw();
    });

    $('#SENDING').on('change',function () {
        tbl_batal_plp.ajax.reload(null, false);
    });

    $(document).ready(function() {
        tbl_batal_plp = $('#tbl_batal_plp').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "searching": true,
            "ordering": true,
            "scrollX": true,
            "scrollY": "1000px",
            "scrollCollapse": true,
            "info": true,
            "lengthMenu": [[10, 25, 50,100, 1000], [10, 25, 50,100, 1000]],
            "pageLength": 10,
            "bLengthChange": true,
            "pagingType" : "full",

            "ajax": {
                "url": "<?php echo site_url('batal_plp/batal_container/table_batal') ?>",
                "type": "POST",
                "data": function(data) {
                    data.SENDING = $('#SENDING').val();
                }

            }
        });

        $('#tbl_batal_plp tbody').on('click', 'tr', function() {
            var data = tbl_batal_plp.row(this).data();
            console.log(data) ;

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');

                dataArrayTabel = [] ;
            } else {
                tbl_batal_plp.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');    

                dataArrayTabel = data ;    
            }
        });

    });


    $(document).on('click', '#btnimport', function(e) {
        url = '<?php echo site_url('batal_plp/batal_container/import') ?>';
        data = "" ;
        divform = "#div_popup_form" ;
        idmodal = "#modal_import" ;        
        createmodal(url,data,divform,idmodal); 
    });

    $(document).on('click', '#btnedit', function(e) {

        if(dataArrayTabel.length == 0){
            alert('Pilih Data di Table...');
            return;
        }

        url = '<?php echo site_url('batal_plp/batal_container/edit') ?>';
        data = {dataArrayTabel:dataArrayTabel} ;
        divform = "#div_popup_form" ;
        idmodal = "#modal_edit" ;        
        createmodal(url,data,divform,idmodal); 
    }); 

    $(document).on('click', '#btnsend', function(e) {

        if(dataArrayTabel.length == 0){
            alert('Pilih Data di Table...');
            return;
        }

        url = '<?php echo site_url('batal_plp/batal_container/kirimdata') ?>';
        data = {dataArrayTabel:dataArrayTabel}; 
        pesan = 'JavaScript Cek Data Terkirim Error...';
        dataok = multi_ajax_proses(url, data, pesan);

        console.log(dataok);
        
        alert(dataok.responsebody) ;

        

    });

    $(document).on('click', '#btnexport', function(e) {

        var tablex = $('#tbl_batal_plp').DataTable();
 
        if (!tablex.data().count() ) {
            alert('Data Yang Dicari Tidak Ada....');
            return;
        }

        var tableData = readTableData('tbl_batal_plp');

        var Compdata = [];
        for(let k = 0 ; k < tableData.length ; k++ ){
            Compdata[k] = btoa(tableData[k]) ;
        }

        // console.log(Compdata);
        //console.log(btoa(Compdata));
        
        //return;

        var page = "<?php echo base_url(); ?>batal_plp/batal_container/exportbatal?data="+btoa(Compdata) ;
        window.open(page);

        // if($('#startdate').val()=="" || $('#enddate').val()=="" || $('#code_principal').val()=="" ){
        //     alert('Parameter Harap Terisi Semua...!!');
        //     return false;
        // }


        // var startdate = $('#startdate').val();
        // var enddate = $('#enddate').val();
        // var code_principal = $('#code_principal').val();
        // var bc_code = $('#bc_code').val();
        // var cont_movement = $('#cont_movement').val();
        // var cont_condition = $('#cont_condition').val();
        // var cont_status = $('#cont_status').val();

        // var data = [];
        // data[0] = startdate ;
        // data[1] = enddate ;
        // data[2] = code_principal ;
        // data[3] = bc_code ;
        // data[4] = cont_movement ;
        // data[5] = cont_condition ;
        // data[6] = cont_status ;

        // var page = "<?php echo base_url(); ?>report/daily_movement_detail/export?data="+btoa(data) ;
        // window.open(page);

    });


    


</script>