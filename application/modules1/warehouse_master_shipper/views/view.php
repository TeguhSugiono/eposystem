<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Warehouse</li>
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item active">..::: Consignee :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12" >

            <div class="card">
                <div class="card-body boxshadow">

                    <div class="row gutters">                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12" >
                            <div class="form-group">
                                <label for="inputName">Cari Data</label>
                                <input type="text" class="form-control" id="search"  name="search">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12" >
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
                                </div>
                            </div>
                            
                            <table id="tbl_shipper" class="table m-0 dataTable no-footer nowrap" style="width: 100%"> 
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>shipper_id</th>
                                        <th>Shipper Name</th>
                                        <th>Address1</th> 
                                        <th>Address2</th> 
                                        <th>Address3</th>                                        
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
    var tbl_shipper ;
    var shipper_id = "" ;
    var selectbaris = 0 ;
    
    $('#search').on('keyup',function () {
        tbl_shipper.search(this.value).draw();
    });
    
    $("#display").change(function() {
        tbl_shipper.page.len(this.value).draw();
    });

    $(document).ready(function() {
        tbl_shipper = $('#tbl_shipper').DataTable({
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
            "ajax": {
                "url": "<?php echo site_url('warehouse_master/shipper/tbl_shipper') ?>",
                "type": "POST",
                "beforeSend": function() {
                        $("#loading-wrapper").show();
                    },
                "data": function(data) {
                    
                },
                "complete": function() {
                        $("#loading-wrapper").hide();
                        tbl_shipper.$('tr.selected').removeClass('selected');
                        tbl_shipper.row(selectbaris).nodes().to$().toggleClass( 'selected' );
                        
                        var data = tbl_shipper.row(selectbaris).data();
                        shipper_id = data[1];
                        
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

        
        

        $('#tbl_shipper tbody').on('click', 'tr', function() {
            var data = tbl_shipper.row(this).data();

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                shipper_id = '' ;
                selectbaris = 0 ;
            } else {
                tbl_shipper.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                shipper_id = data[1];
                selectbaris = tbl_shipper.row(this)[0];  
            }
        });

        
    });
    
    
    
    $(document).on('click', '.btnadd', function(e) {
        $.post('<?php echo site_url() ?>warehouse_master/shipper/formadd', {},
        function(xx) {
            $('#div_popup_form').html(xx);
            $("#modal_add").modal({
                show: true,
                backdrop: 'static',
            });
            $('.modal-title').text('Add Shipper');
        });
    });


    $(document).on('click', '.btnedit', function(e) {
        if(shipper_id == ''){
            alert('belum ada data yang dipilih..!!');
            return false;
        }

        $.post('<?php echo site_url() ?>warehouse_master/shipper/formedit', {shipper_id:shipper_id},
        function(xx) {
            $('#div_popup_form').html(xx);
            $("#modal_edit").modal({
                show: true,
                backdrop: 'static',
            });
            $('.modal-title').text('Edit Shipper');
        });
    });

    $(document).on('click', '.btndelete', function(e) {
        if(shipper_id == ''){
            alert('belum ada data yang dipilih..!!');
            return false;
        }

        var jawab = confirm('Anda yakin ingin menghapus data ini ?');

        if (jawab === true) { 
            url = '<?php echo site_url('warehouse_master/shipper/delete') ?>';
            data = {shipper_id: shipper_id};
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
        shipper_id = '';
        selectbaris = 0 ;
        tbl_shipper.ajax.reload(null, false);
    });

   

    
</script>