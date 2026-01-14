<style>        
    .dataout {background-color: yellow !important;}
    .margin-input{margin-bottom: -2% !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Transaction</li>
        <li class="breadcrumb-item active">..::: Entry Container In :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >

            <div class="card">
                <div class="card-body boxshadow">

                    <div class="row gutters">                        
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                            <div class="form-group">
                                <label for="inputName">Cari Data</label>
                                <input type="text" class="form-control" id="search"  name="search">
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                            <div class="form-group">
                                <label for="inputName">Tampilkan</label>
                                <?=cbodisplay();?>
                            </div>
                        </div>
                    </div>


                    <div class="table-container">                        
                        <div class="table-responsive" style="margin-top: 1%">
                            <div class="btn-group" style="margin-bottom:0.1%">
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

                            <table id="tbl_entry_cont_in" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>id_cont_in</th>
                                        <th>Eir In</th>
                                        <th>Bon Bongkar No</th>                                        
                                        <th>Principal</th>
                                        <th>Container Number</th>        
                                        <th>Date In</th> 
                                        <th>Time In</th> 
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
    var tbl_entry_cont_in ;
    var id_cont_in = "" ;
    var selectbaris = 0 ;
    var stock = 0 ;
    var bon_bongkar_number = "" ;
    var eir_in = "" ;
    
    $('#search').on('keyup',function () {
        tbl_entry_cont_in.search(this.value).draw();
    });
    
    $("#display").change(function() {
        tbl_entry_cont_in.page.len(this.value).draw();
    });

    $(document).ready(function() {

        // setInterval(function(){
        //     $('#tbl_entry_cont_in').DataTable().page('last').draw('page');
        //     tbl_entry_cont_in.ajax.reload( null, false );
        // }, 15000); /* time in milliseconds (ie 25 seconds)*/

        

        tbl_entry_cont_in = $('#tbl_entry_cont_in').DataTable({
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
//            "dom": 'l<"toolbar">frtip',

            "ajax": {
                "url": "<?php echo site_url('transaksi/entry_cont_in/tbl_entry_cont_in') ?>",
                "type": "POST",
                "beforeSend": function() {
                        $("#loading-wrapper").show();
                    },
                "data": function(data) {

                },
                "complete": function() {
                        $("#loading-wrapper").hide();
                        //var counttable = tbl_entry_cont_in.rows().count() - 1 ; // ini cari posisi data terakhir table
                        tbl_entry_cont_in.$('tr.selected').removeClass('selected');
                        tbl_entry_cont_in.row(selectbaris).nodes().to$().toggleClass( 'selected' );
                        
                        var data = tbl_entry_cont_in.row(selectbaris).data();
                        id_cont_in = data[1];
                        eir_in = data[2];
                        bon_bongkar_number = data[3];
                        stock = data[16];
                        //console.log(data);

                        //tbl_entry_cont_in.page( 'last' ).draw( 'page' );
                        //$('#tbl_entry_cont_in').DataTable().page('last').draw('page');

                    }

            }
            ,
            "initComplete": function(settings, json) {
                //tbl_entry_cont_in.page('last').draw(false);
            }
            , 
            "createdRow": function( row, data, dataIndex){
                if(data[16] == '1'){
                    $(row).addClass('dataout');
                }
            },
            "columnDefs": [
                {
                    "targets": [0,1],
                    "orderable": false
                }
                ,
                {
                    "targets": [1,16],
                    "visible": false
                }
            ]
        });

//        var html1 = ' <div class="btn-group" style="margin-bottom:3%">\n\
//                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n\
//                                Action\n\
//                            </button>\n\
//                            <div class="dropdown-menu" id="showaksi">\n\
//                                <a class="dropdown-item btnadd"><span class="icon-control_point"></span>&nbsp;Add</a>\n\
//                                <a class="dropdown-item btnedit"><span class="icon-edit"></span>&nbsp;Edit</a>\n\
//                                <a class="dropdown-item btndelete"><span class="icon-x-circle"></span>&nbsp;Delete</a>\n\
//                                <a class="dropdown-item btnprint"><span class="icon-print"></span>&nbsp;Print</a>\n\
//                            </div>\n\
//                        </div>\n\
//                        ';
//
//        $("div.toolbar").html(html1);

        $('#tbl_entry_cont_in tbody').on('click', 'tr', function() {
            var data = tbl_entry_cont_in.row(this).data();

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                id_cont_in = '' ;
                eir_in = "" ;
                bon_bongkar_number = '';
                selectbaris = 0 ;
                stock = 0 ;
            } else {
                tbl_entry_cont_in.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                id_cont_in = data[1];
                eir_in = data[2] ;
                bon_bongkar_number = data[3];
                stock = data[16];
                selectbaris = tbl_entry_cont_in.row(this)[0];            
            }
        });

        
    });


    $(document).on('click', '.btnadd', function(e) {
        $.post('<?php echo site_url() ?>transaksi/entry_cont_in/formadd', {},
        function(xx) {
            $('#div_popup_form').html(xx);
            $("#modal_add").modal({
                show: true,
                backdrop: 'static',
            });
            $('.modal-title').text('Add Entry Container In');
        });
    });


    $(document).on('click', '.btnedit', function(e) {
        if(id_cont_in == ''){
            alert('Belum Ada Data Yang Dipilih..!!');
            return false;
        }
        
        if(stock == 1){
            alert('Tidak Bisa Edit, Container Sudah Terkait Dengan Data Keluar..!!');
            return false;
        }
        
        $.post('<?php echo site_url() ?>transaksi/entry_cont_in/formedit', {id_cont_in:id_cont_in},
        function(xx) {
            $('#div_popup_form').html(xx);
            $("#modal_edit").modal({
                show: true,
                backdrop: 'static',
            });
            $('.modal-title').text('Edit Entry Container In');
        });
        
    });


    $(document).on('click', '.btndelete', function(e) {
        if(bon_bongkar_number == ''){
            alert('Belum Ada Data Yang Dipilih..!!');
            return false;
        }
        
        if(stock == 1){
            alert('Tidak Bisa Hapus, Container Sudah Terkait Dengan Data Keluar..!!');
            return false;
        }

        var jawab = confirm('Anda yakin ingin menghapus data ini ?');

        if (jawab === true) { 
            url = '<?php echo site_url('transaksi/entry_cont_in/delete') ?>';
            data = {bon_bongkar_number: bon_bongkar_number};
            pesan = 'JavaScript Delete Error...';
            dataok = multi_ajax_proses(url, data, pesan);
        }else{
            return false;
        }

        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }

        alert(dataok.pesan);
        id_cont_in = '';
        bon_bongkar_number = '' ;
        tbl_entry_cont_in.ajax.reload(null, false);
    });
    
    $(document).on('click', '.btnprint', function(e) {
        if(eir_in == ''){
            alert('belum ada data yang dipilih..!!');
            return false;
        }

        var page = "<?php echo base_url(); ?>transaksi/entry_cont_in/print?data="+eir_in ;
        //var page = "<?php echo base_url(); ?>transaksi/entry_cont_in/print?data="+bon_bongkar_number+"&debugsql=1&showhtmldata=1" ;
        window.open(page);
//        window.open(page, '_Details', 'scrollbars=1, resizable=1,location=0,statusbar=0,menubar=0,width=1200,height=700,left=50,top=50,titlebar=yes',"mywindow1");

    });
    
</script>