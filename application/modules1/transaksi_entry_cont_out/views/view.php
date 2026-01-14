<style>        
    .dataout {background-color: yellow !important;}
    .margin-input{margin-bottom: -0% !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Transaction</li>
        <li class="breadcrumb-item active">..::: Entry Container Out :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">

        
        
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 boxshadow" style="margin-top: 1%">
            <div class="card">
                <div class="card-body">

                    <div class="row gutters">                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="inputName">Cari Data</label>
                                <input type="text" class="form-control" id="search_do"  name="search_do">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="inputName">Tampilkan</label>
                                <?= cbodisplay_do(); ?>
                            </div>
                        </div>                        
                    </div>


                    <div class="table-container">
                        <h5 class="table-title text-center">..::: D/O Container Out :::..</h5>
                        <div class="table-responsive">
                            <div class="btn-group" style="margin-bottom:0.3%">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" id="showaksi">
                                    <a class="dropdown-item btnget_do"><span class="icon-download"></span>&nbsp;Get DO</a>
                                    <a class="dropdown-item btnadd_do"><span class="icon-control_point"></span>&nbsp;Add DO</a>
                                    <a class="dropdown-item btnedit_do"><span class="icon-edit"></span>&nbsp;Edit DO</a>
                                    <a class="dropdown-item btndelete_do"><span class="icon-x-circle"></span>&nbsp;Delete DO</a>
                                </div>
                            </div>
                            <table id="tbl_do_cont_out" class="table m-0 dataTable no-footer nowrap" style="width: 100%"  >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>id_entry_do</th>
                                        <th>DO Date</th>
                                        <th>DO/Number</th>
                                        <th>Size/Type</th>
                                        <th>Principal</th>
                                        <th>Vessel/Voyage</th>
                                        <th>Shipper</th>
                                        <th>Seal Number</th>
                                        <th>Destination</th>
                                        <th>Notes</th>                                        
                                        <th>Party</th>
                                        <th>Cont Out</th>
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

        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12 boxshadow" style="margin-top: 1%">
            <div class="card">
                <div class="card-body">

                    <div class="row gutters">                        
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label for="inputName">Cari Data</label>
                                <input type="text" class="form-control" id="search"  name="search">
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label for="inputName">Tampilkan</label>
                                <?= cbodisplay(); ?>
                            </div>
                        </div>
                    </div>


                    <div class="table-container">
                        <h5 class="table-title text-center">..::: Container Out :::..</h5>
                        <div class="table-responsive">
                            <div class="btn-group" style="margin-bottom:0.2%">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" id="showaksi">
                                    <a class="dropdown-item btnadd"><span class="icon-control_point"></span>&nbsp;Add</a>
                                    <a class="dropdown-item btnedit"><span class="icon-edit"></span>&nbsp;Edit</a>
                                    <a class="dropdown-item btndelete"><span class="icon-x-circle"></span>&nbsp;Delete</a>
                                    <a class="dropdown-item btnprint"><span class="icon-print"></span>&nbsp;Print</a>
                                </div>
                            </div>
                            <table id="tbl_entry_cont_out" class="table m-0 dataTable no-footer nowrap" style="width: 100%"  >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>id_cont_out</th>
                                        <th>Eir Out</th>
                                        <th>Bon Muat No</th>
                                        <th>No Transaksi</th>    
                                        <th>DO Number</th>
                                        <th>Principal</th>
                                        <th>Container Number</th>        
                                        <th>Date Out</th> 
                                        <th>Time Out</th> 
                                        <th>Size</th>
                                        <th>Vessel/Voyage</th>
                                        <th>Truck Number</th>
                                        <th>Driver Name</th>
                                        <th>Block</th>
                                        <th>Location</th>
                                        <th>Cont Status</th>
                                        <th>Cont Condition</th>
                                        <th>Stock</th>
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

<div id='div_popup_form'></div>

<script src="<?= site_url(); ?>assets/js/jquery.min.js"></script>

<script type="text/javascript">
    var tbl_entry_cont_out;
    var tbl_do_cont_out;
    var selectbaris_do = 0 ;
    var selectbaris = 0 ;
    var id_entry_do = "" ;
    var do_number = "" ;
    var destination = "" ;
    var jum_party = 0 ;
    var jum_r_party = 0 ;
    var id_cont_out = "" ;
    var eir_out = "" ;
    var bon_muat_number = "" ;
    
    $('#search_do').on('keyup',function () {
        tbl_do_cont_out.search(this.value).draw();
    });
    
    $("#display_do").change(function() {
        tbl_do_cont_out.page.len(this.value).draw();
    });
    
    $('#search').on('keyup',function () {
        do_number = "" ;
        destination = "" ;
        id_entry_do = "" ;
        tbl_entry_cont_out.search(this.value).draw();
    });
    
    $("#display").change(function() {
        do_number = "" ;
        destination = "" ;
        id_entry_do = "" ;
        tbl_entry_cont_out.page.len(this.value).draw();
    });
    
    $(document).ready(function() {

        tbl_do_cont_out = $('#tbl_do_cont_out').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "searching": true,
            "ordering": true,
            "scrollX": true,
            "scrollY": "1000px",
            "scrollCollapse": true,
            "info": false,
            "lengthMenu": [[10, 25, 50,100, 1000], [10, 25, 50,100, 1000]],
            "pageLength": 10,
            "bLengthChange": true,
            "pagingType" : "full",
//            "dom": 'l<"toolbar">frtip',

            "ajax": {
                "url": "<?php echo site_url('transaksi/entry_cont_out/tbl_do_cont_out') ?>",
                "type": "POST",
                "beforeSend": function() {
                    $("#loading-wrapper").show();
                },
                "data": function(data) {

                },
                "complete": function() {
                    $("#loading-wrapper").hide();
                    tbl_do_cont_out.$('tr.selected').removeClass('selected');
                    tbl_do_cont_out.row(selectbaris_do).nodes().to$().toggleClass( 'selected' );
                    
                    var data = tbl_do_cont_out.row(selectbaris_do).data();
                    id_entry_do = data[1];
                    do_number = data[3];
                    destination = data[8];
                    tbl_entry_cont_out.ajax.reload(null, false);
                        //console.log(tbl_do_cont_out.page.info());
                        //console.log(tbl_do_cont_out.page.info()['pages']);
                }
            }
            ,
            "columnDefs": [
            {
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
        
        
        $('#tbl_do_cont_out tbody').on('click', 'tr', function() {
            var data = tbl_do_cont_out.row(this).data();

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                id_entry_do = '' ;
                selectbaris_do = 0 ;
                do_number = "" ;
                destination = "" ;
                jum_party = "";
                jum_r_party = "";
                tbl_entry_cont_out.ajax.reload(null, false);
            } else {
                tbl_do_cont_out.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                id_entry_do = data[1];
                do_number = data[3];
                destination = data[8];
                jum_party = data[11];
                jum_r_party = data[12];
                selectbaris_do = tbl_do_cont_out.row(this)[0];  
                tbl_entry_cont_out.ajax.reload(null, false);
            }
        });
        
        tbl_entry_cont_out = $('#tbl_entry_cont_out').DataTable({
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

            "ajax": {
                "url": "<?php echo site_url('transaksi/entry_cont_out/tbl_entry_cont_out') ?>",
                "type": "POST",
                "beforeSend": function() {
                        //$("#loading-wrapper").show();
                },
                "data": function(data) {
                    data.do_number = do_number ;
                    data.id_entry_do = id_entry_do ;
                },
                "complete": function() {
                        //$("#loading-wrapper").hide();

                    tbl_entry_cont_out.$('tr.selected').removeClass('selected');
                    tbl_entry_cont_out.row(selectbaris).nodes().to$().toggleClass( 'selected' );
                    
                    var data = tbl_entry_cont_out.row(selectbaris).data();
                        //console.log(data);

                    if(data !== undefined){
                        id_cont_out = data[1];
                        eir_out = data[2];
                        bon_muat_number = data[3];
                    }

                    
                    

                        // eir_in = data[2];
                        // bon_bongkar_number = data[3];
                        // stock = data[16];

                }
            }
            ,
            "columnDefs": [
                // {
                //     "targets": [0,1],
                //     "orderable": false
                // }
                // ,
            {
                "targets": [1],
                "visible": false
            }
            ]
        });
        
        
        $('#tbl_entry_cont_out tbody').on('click', 'tr', function() {
            var data = tbl_entry_cont_out.row(this).data();

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                selectbaris = 0 ;
                id_cont_out = "" ;
                eir_out = "" ;
                bon_muat_number = "" ;
            } else {
                id_cont_out = data[1];
                eir_out = data[2] ;
                bon_muat_number = data[3];
                selectbaris = tbl_entry_cont_out.row(this)[0]; 
                tbl_entry_cont_out.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                selectbaris = tbl_entry_cont_out.row(this)[0];    
            }
        });
        
    });

$(document).on('click', '.btnadd_do', function(e) {
    url = '<?php echo site_url('transaksi/entry_cont_out/formadd_do') ?>';
    data = "" ;
    divform = "#div_popup_form" ;
    idmodal = "#modal_add_do" ;        
    createmodal(url,data,divform,idmodal); 
});

$(document).on('click', '.btnedit_do', function(e) {
    if(id_entry_do == ''){
        alert('belum ada data yang dipilih..!!');
        return false;
    }
    
    url = '<?php echo site_url('transaksi/entry_cont_out/formedit_do') ?>';
    data = {id_entry_do:id_entry_do} ;
    divform = "#div_popup_form" ;
    idmodal = "#modal_edit_do" ;        
    createmodal(url,data,divform,idmodal); 
    
});

$(document).on('click', '.btndelete_do', function(e) {
    if(id_entry_do == ''){
        alert('Belum Ada Data Yang Dipilih..!!');
        return false;
    }

    var jawab = confirm('Anda yakin ingin menghapus data ini ?');

    if (jawab === true) { 
        url = '<?php echo site_url('transaksi/entry_cont_out/delete_do') ?>';
        data = {id_entry_do: id_entry_do};
        pesan = 'JavaScript Delete DO Error...';
        dataok = multi_ajax_proses(url, data, pesan);

            //console.log(dataok);

    }else{
        return false;
    }

    if(dataok.msg != 'Ya'){
        alert(dataok.pesan);
        return false;
    }else if(dataok === undefined){
        alert(dataok.pesan);
        return false;
    }

    alert(dataok.pesan);
    id_entry_do = '';
    tbl_do_cont_out.ajax.reload(null, false);
    tbl_entry_cont_out.ajax.reload(null, false);
});

$(document).on('click', '.btnget_do', function(e) {        
    url = '<?php echo site_url('transaksi/entry_cont_out/get_do_contout') ?>';
    data = "";
    pesan = 'Javascript get_do_contout Error..!!';
    dataok = multi_ajax_proses(url, data, pesan);

    console.log(dataok) ;
    
    if(dataok.msg != "Ya"){
        alert(dataok.pesan);
    }
    selectbaris_do = 0 ;
    tbl_do_cont_out.ajax.reload(null, false);
});

$(document).on('click', '.btnadd', function(e) { 

    if(id_entry_do == ""){
        alert('Do belum Dipilih..!!');
        return false;
    }

    url = '<?php echo site_url('transaksi/entry_cont_out/formadd') ?>';
    data = {do_number:do_number,id_entry_do:id_entry_do,destination:destination} ;
    divform = "#div_popup_form" ;
    idmodal = "#modal_add" ;        
    createmodal(url,data,divform,idmodal); 
});

$(document).on('click', '.btnedit', function(e) { 

    if(id_cont_out == ""){
        alert('Container Belum Di Pilih..!!');
        return false;
    }

    url = '<?php echo site_url('transaksi/entry_cont_out/formedit') ?>';
    data = {id_cont_out:id_cont_out} ;
    divform = "#div_popup_form" ;
    idmodal = "#modal_edit" ;        
    createmodal(url,data,divform,idmodal); 
});


$(document).on('click', '.btndelete', function(e) { 

    if(id_cont_out == ""){
        alert('Container Belum Di Pilih..!!');
        return false;
    }

    var jawab = confirm('Anda yakin ingin menghapus data ini ?');

    if (jawab === true) { 
        url = '<?php echo site_url('transaksi/entry_cont_out/delete') ?>';
        data = {id_cont_out: id_cont_out};
        pesan = 'JavaScript Delete DO Error...';
        dataok = multi_ajax_proses(url, data, pesan);

            //console.log(dataok);

    }else{
        return false;
    }

    if(dataok.msg != 'Ya'){
        alert(dataok.pesan);
        return false;
    }else if(dataok === undefined){
        alert(dataok.pesan);
        return false;
    }

    alert(dataok.pesan);
    id_cont_out = '';
    eir_out = '' ;
    bon_muat_number = "" ;
    tbl_entry_cont_out.ajax.reload(null, false);
    
});

$(document).on('click', '.btnprint', function(e) {
    if(eir_out == ''){
        alert('belum ada data yang dipilih..!!');
        return false;
    }

    var data = [];
    data[0] = eir_out;
    data[1] = bon_muat_number;
    data[2] = '';

    var page = "<?php echo base_url(); ?>transaksi/entry_cont_out/print?data="+btoa(data) ;
        //var page = "<?php echo base_url(); ?>transaksi/entry_cont_in/print?data="+bon_bongkar_number+"&debugsql=1&showhtmldata=1" ;
    window.open(page);
//        window.open(page, '_Details', 'scrollbars=1, resizable=1,location=0,statusbar=0,menubar=0,width=1200,height=700,left=50,top=50,titlebar=yes',"mywindow1");

});

</script>