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
                            <div class="btn-group" style="margin-bottom:0.3%">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" id="showaksi">
                                    <a class="dropdown-item btnadd"><span class="icon-control_point"></span>&nbsp;Add</a>
                                    <a class="dropdown-item btnedit"><span class="icon-edit"></span>&nbsp;Edit</a>
                                    <!-- <a class="dropdown-item btndelete"><span class="icon-x-circle"></span>&nbsp;Delete</a>
                                    <a class="dropdown-item btnprint"><span class="icon-print"></span>&nbsp;Print</a> -->
                                </div>
                            </div>

                            <table id="tbl_cont_shifting" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>id_cont_shifting</th>
                                        <th>Cont Number</th>
                                        <th>Date In</th>
                                        <th>Time In</th>
                                        <th>Lokasi Old</th>
                                        <th>Lokasi New</th>
                                        <th>Code</th>
                                        <th>Nama Principal</th>
                                        <th>Vessel</th>
                                        <th>Reff Code</th>
                                        <th>Reff Description</th>
                                        <th>Cont Condition</th>
                                        <th>Cont Status</th>                                        
                                        <th>Date Shifting</th>
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
    var tbl_cont_shifting ;
    var id_cont_shifting = "" ;
    var selectbaris = 0 ;
    var stock = 0 ;
    var bon_bongkar_number = "" ;
    var eir_in = "" ;
    
    $('#search').on('keyup',function () {
        tbl_cont_shifting.search(this.value).draw();
    });
    
    $("#display").change(function() {
        tbl_cont_shifting.page.len(this.value).draw();
    });

    $(document).ready(function() {    

        tbl_cont_shifting = $('#tbl_cont_shifting').DataTable({
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
                "url": "<?php echo site_url('transaksi/cont_shifting/tbl_cont_shifting') ?>",
                "type": "POST",
                "beforeSend": function() {
                        $("#loading-wrapper").show();
                    },
                "data": function(data) {
                    data.date_shifting_start = $('#date_shifting_start').val();
                    data.date_shifting_end = $('#date_shifting_end').val();
                },
                "complete": function() {
                        $("#loading-wrapper").hide();

                        tbl_cont_shifting.$('tr.selected').removeClass('selected');
                        tbl_cont_shifting.row(selectbaris).nodes().to$().toggleClass( 'selected' );
                        
                        var data = tbl_cont_shifting.row(selectbaris).data();
                        id_cont_shifting = data[1];

                    }

            }
            ,
            "initComplete": function(settings, json) {
                //tbl_cont_shifting.page('last').draw(false);
            }
            , 
            "createdRow": function( row, data, dataIndex){
                // if(data[16] == '1'){
                //     $(row).addClass('dataout');
                // }
            },
            "columnDefs": [
                {
                    "targets": [0,1],
                    "orderable": false
                }
                ,
                {
                    "targets": [1],
                    "visible": false
                }
            ]
        });


        $('#tbl_cont_shifting tbody').on('click', 'tr', function() {
            var data = tbl_cont_shifting.row(this).data();

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                id_cont_shifting = '' ;
                selectbaris = 0 ;

            } else {
                tbl_cont_shifting.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                id_cont_shifting = data[1];
                selectbaris = tbl_cont_shifting.row(this)[0];            
            }
        });

        
    });


    $(document).on('click', '.btnadd', function(e) {
        $.post('<?php echo site_url() ?>transaksi/cont_shifting/formadd', {},
        function(xx) {
            $('#div_popup_form').html(xx);
            $("#modal_add").modal({
                show: true,
                backdrop: 'static',
            });
            $('.modal-title').text('Add Shifting Container');
        });
    });


    $(document).on('click', '.btnedit', function(e) {
        if(id_cont_shifting == ''){
            alert('Belum Ada Data Yang Dipilih..!!');
            return false;
        }
        
        $.post('<?php echo site_url() ?>transaksi/cont_shifting/formedit', {id_cont_shifting:id_cont_shifting},
        function(xx) {
            $('#div_popup_form').html(xx);
            $("#modal_edit").modal({
                show: true,
                backdrop: 'static',
            });
            $('.modal-title').text('Edit Shifting Container');
        });
        
    });


    // $(document).on('click', '.btndelete', function(e) {
    //     if(id_cont_shifting == ''){
    //         alert('Belum Ada Data Yang Dipilih..!!');
    //         return false;
    //     }

    //     var jawab = confirm('Anda yakin ingin menghapus data ini ?');

    //     if (jawab === true) { 
    //         url = '<?php echo site_url('transaksi/cont_shifting/delete') ?>';
    //         data = {id_cont_shifting: id_cont_shifting};
    //         pesan = 'JavaScript Delete Error...';
    //         dataok = multi_ajax_proses(url, data, pesan);
    //         console.log(dataok);
    //     }else{
    //         return false;
    //     }

    //     if(dataok.msg != 'Ya'){
    //         alert(dataok.pesan);
    //         return false;
    //     }

    //     alert(dataok.pesan);
    //     id_cont_shifting = '';
    //     tbl_cont_shifting.ajax.reload(null, false);
    // });
    
    
</script>