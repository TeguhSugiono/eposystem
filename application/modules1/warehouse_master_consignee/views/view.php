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
                            
                            <table id="tbl_consignee" class="table m-0 dataTable no-footer nowrap" style="width: 100%"> 
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>consignee_id</th>
                                        <th>Consignee Name</th>
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
    var tbl_consignee ;
    var consignee_id = "" ;
    var selectbaris = 0 ;
    
    $('#search').on('keyup',function () {
        tbl_consignee.search(this.value).draw();
    });
    
    $("#display").change(function() {
        tbl_consignee.page.len(this.value).draw();
    });

    $(document).ready(function() {
        tbl_consignee = $('#tbl_consignee').DataTable({
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
                "url": "<?php echo site_url('warehouse_master/consignee/tbl_consignee') ?>",
                "type": "POST",
                "beforeSend": function() {
                        $("#loading-wrapper").show();
                    },
                "data": function(data) {
                    
                },
                "complete": function() {
                        $("#loading-wrapper").hide();
                        tbl_consignee.$('tr.selected').removeClass('selected');
                        tbl_consignee.row(selectbaris).nodes().to$().toggleClass( 'selected' );
                        
                        var data = tbl_consignee.row(selectbaris).data();
                        consignee_id = data[1];
                        
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

        
        

        $('#tbl_consignee tbody').on('click', 'tr', function() {
            var data = tbl_consignee.row(this).data();

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                consignee_id = '' ;
                selectbaris = 0 ;
            } else {
                tbl_consignee.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                consignee_id = data[1];
                selectbaris = tbl_consignee.row(this)[0];  
            }
        });

        
    });
    
    
    
    $(document).on('click', '.btnadd', function(e) {
        $.post('<?php echo site_url() ?>warehouse_master/consignee/formadd', {},
        function(xx) {
            $('#div_popup_form').html(xx);
            $("#modal_add").modal({
                show: true,
                backdrop: 'static',
            });
            $('.modal-title').text('Add Consignee');
        });
    });


    $(document).on('click', '.btnedit', function(e) {
        if(consignee_id == ''){
            alert('belum ada data yang dipilih..!!');
            return false;
        }

        $.post('<?php echo site_url() ?>warehouse_master/consignee/formedit', {consignee_id:consignee_id},
        function(xx) {
            $('#div_popup_form').html(xx);
            $("#modal_edit").modal({
                show: true,
                backdrop: 'static',
            });
            $('.modal-title').text('Edit Consignee');
        });
    });

    $(document).on('click', '.btndelete', function(e) {
        if(consignee_id == ''){
            alert('belum ada data yang dipilih..!!');
            return false;
        }

        var jawab = confirm('Anda yakin ingin menghapus data ini ?');

        if (jawab === true) { 
            url = '<?php echo site_url('warehouse_master/consignee/delete') ?>';
            data = {consignee_id: consignee_id};
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
        consignee_id = '';
        selectbaris = 0 ;
        tbl_consignee.ajax.reload(null, false);
    });

   

    
</script>