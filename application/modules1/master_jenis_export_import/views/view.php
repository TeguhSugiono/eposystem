<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item active">..::: Master Jenis Expor/Import :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12" >

            <div class="card">
                <div class="card-body boxshadow">

                    <div class="row gutters">                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="inputName">Cari Data</label>
                                <input type="text" class="form-control" id="search"  name="search">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="inputName">Tampilkan</label>
                                <?=cbodisplay();?>
                            </div>
                        </div>
                    </div>


                    <div class="table-container">                        
                        <div class="table-responsive" style="margin-top: 1%">
                            <div class="btn-group" style="margin-bottom:0.3%;display: none;">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" id="showaksi">
                                    <a class="dropdown-item btnadd"><span class="icon-control_point"></span>&nbsp;Add</a>
                                    <a class="dropdown-item btnedit"><span class="icon-edit"></span>&nbsp;Edit</a>
                                    <a class="dropdown-item btndelete"><span class="icon-x-circle"></span>&nbsp;Delete</a>
                                </div>
                            </div>
                            <table id="tbl_jenis_export_import" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>id</th>
                                        <th>Jenis Export/Import</th>    
                                        <th>Keterangan</th>                                   
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
    var tbl_jenis_export_import ;
    var id = "" ;
    var selectbaris = 0 ;
    var url ; 
    var data ; 
    var divform ; 
    var idmodal ;
    
    $('#search').on('keyup',function () {
        tbl_jenis_export_import.search(this.value).draw();
    });
    
    $("#display").change(function() {
        tbl_jenis_export_import.page.len(this.value).draw();
    });

    $(document).ready(function() {
        tbl_jenis_export_import = $('#tbl_jenis_export_import').DataTable({
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
            "pageLength": 10,
            "bLengthChange": true,
//            "dom": 'l<"toolbar">frtip',
            "ajax": {
                "url": "<?php echo site_url('master/jenis_export_import/tbl_jenis_export_import') ?>",
                "type": "POST",
                "beforeSend": function() {
                        $("#loading-wrapper").show();
                    },
                "data": function(data) {

                },
                "complete": function() {
                        $("#loading-wrapper").hide();
                        tbl_jenis_export_import.$('tr.selected').removeClass('selected');
                        tbl_jenis_export_import.row(selectbaris).nodes().to$().toggleClass( 'selected' );
                        
                        var data = tbl_jenis_export_import.row(selectbaris).data();
                        id = data[1];
                    }

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


        $('#tbl_jenis_export_import tbody').on('click', 'tr', function() {
            var data = tbl_jenis_export_import.row(this).data();

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                id = '' ;
                selectbaris = 0 ;
            } else {
                tbl_jenis_export_import.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                id = data[1];
                selectbaris = tbl_jenis_export_import.row(this)[0];  
            }
        });

        
    });
    
    
    $(document).on('click', '.btnadd', function(e) {
        url = '<?php echo site_url('master/jenis_export_import/formadd') ?>';
        data = "" ;
        divform = "#div_popup_form" ;
        idmodal = "#modal_add" ;        
        createmodal(url,data,divform,idmodal); 
    });


    $(document).on('click', '.btnedit', function(e) {
        if(id == ''){
            alert('belum ada data yang dipilih..!!');
            return false;
        }

        url = '<?php echo site_url('master/jenis_export_import/formedit') ?>';
        data = {id:id} ;
        divform = "#div_popup_form" ;
        idmodal = "#modal_edit" ;        
        createmodal(url,data,divform,idmodal); 

    });

    $(document).on('click', '.btndelete', function(e) {
        if(id == ''){
            alert('belum ada data yang dipilih..!!');
            return false;
        }

        var jawab = confirm('Anda yakin ingin menghapus data ini ?');

        if (jawab === true) { 
            url = '<?php echo site_url('master/jenis_export_import/delete') ?>';
            data = {id: id};
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
        id = '';
        selectbaris = 0 ;
        tbl_jenis_export_import.ajax.reload(null, false);
    });

   

    
</script>