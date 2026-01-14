<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item active">..::: Master Jenis Document :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-12" >

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
                            <div class="btn-group" style="margin-bottom:0.2%;display: block;">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" id="showaksi">
                                    <a class="dropdown-item btnadd"><span class="icon-control_point"></span>&nbsp;Add</a>
                                    <a class="dropdown-item btnedit"><span class="icon-edit"></span>&nbsp;Edit</a>
                                    <!-- <a class="dropdown-item btndelete"><span class="icon-x-circle"></span>&nbsp;Delete</a> -->
                                </div>
                            </div>
                            <table id="tbl_jenis_document" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Document</th>
                                        <th>Jenis Document</th>                                       
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
    var tbl_jenis_document ;
    var id = "" ;
    var selectbaris = 0 ;
    var url ; 
    var data ; 
    var divform ; 
    var idmodal ;
    
    $('#search').on('keyup',function () {
        tbl_jenis_document.search(this.value).draw();
    });
    
    $("#display").change(function() {
        tbl_jenis_document.page.len(this.value).draw();
    });

    $(document).ready(function() {
        tbl_jenis_document = $('#tbl_jenis_document').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "searching": true,
            "ordering": true,
            "scrollX": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "info": true,
            "lengthMenu": [[10, 25, 50,100, 1000], [10, 25, 50,100, 1000]],
            "pageLength": 100,
            "bLengthChange": true,
//            "dom": 'l<"toolbar">frtip',
            "ajax": {
                "url": "<?php echo site_url('master/jenis_document/tbl_jenis_document') ?>",
                "type": "POST",
                "beforeSend": function() {
                        $("#loading-wrapper").show();
                    },
                "data": function(data) {

                },
                "complete": function() {
                        $("#loading-wrapper").hide();
                        tbl_jenis_document.$('tr.selected').removeClass('selected');
                        tbl_jenis_document.row(selectbaris).nodes().to$().toggleClass( 'selected' );
                        
                        var data = tbl_jenis_document.row(selectbaris).data();
                        id = data[1];
                    }

            },
            "columnDefs": [
                {
                    "targets": [0,1],
                    "orderable": false
                }
            ]
        });


        $('#tbl_jenis_document tbody').on('click', 'tr', function() {
            var data = tbl_jenis_document.row(this).data();

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                id = '' ;
                selectbaris = 0 ;
            } else {
                tbl_jenis_document.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                id = data[1];
                selectbaris = tbl_jenis_document.row(this)[0];  
            }
        });

        
    });
    
    
    $(document).on('click', '.btnadd', function(e) {
        url = '<?php echo site_url('master/jenis_document/formadd') ?>';
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

        url = '<?php echo site_url('master/jenis_document/formedit') ?>';
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
            url = '<?php echo site_url('master/jenis_document/delete') ?>';
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
        tbl_jenis_document.ajax.reload(null, false);
    });

   

    
</script>