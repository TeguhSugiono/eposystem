<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">PJT</li>
        <li class="breadcrumb-item active">..::: List Antrian PJT :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >

            <div class="card">
                <div class="card-body boxshadow">

                    <div class="">
                        <div class="table-responsive">
                            <table id="tbl_chkpjt" class="table m-0 dataTable no-footer nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Job</th>
                                        <th>Tgl Job</th>
                                        <th>PIBK</th>
                                        <th>Tgl PIBK</th>
                                        <th>Nama Importir</th>
                                        <th>No Container</th>
                                        <th>Size</th>
                                        <th>Asal Barang</th>
                                        <th>Status</th>
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
    var tbl_chkpjt ;

    $(document).ready(function() {
        setInterval(function(){
            tbl_chkpjt.ajax.reload(null, false);
        }, 15000); /* time in milliseconds (ie 25 seconds)*/

        setInterval(function(){
            location.reload();
        }, 150000); /* time in milliseconds (ie 25 seconds)*/

        tbl_chkpjt = $('#tbl_chkpjt').DataTable({
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
            "lengthMenu": [50,100,500],
            "pageLength": 50,
            "bLengthChange": true,
            //"dom": 'l<"toolbar">frtip',


            "ajax": {
                "url": "<?php echo site_url('pjt/tbl_chkpjt') ?>",
                "type": "POST",
                "beforeSend": function() {
                        $("#loading-wrapper").show();
                    },
                "data": function(data) {
                    //var param_form = document.getElementById('param_form').value;
                    //data.param_form = param_form;
                },
                "complete": function() {
                        $("#loading-wrapper").hide();
                    }

            },
            "columnDefs": [{
                    "targets": [0],
                    "orderable": false
                }]
        });


    });


</script>