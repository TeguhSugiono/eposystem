<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">PJT</li>
        <li class="breadcrumb-item active">..::: Entry Data PJT :::..</li>
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
                                <label for="inputName">Start Date</label>
                                <input type="text" class="form-control datepicker-dropdowns" id="tgljobstart"  name="tgljobstart" value=<?php echo date('d-m-Y') ?> >
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                            <div class="form-group">
                                <label for="inputName">End Date</label>
                                <input type="text" class="form-control datepicker-dropdowns" id="tgljobend"  name="tgljobend" value=<?php echo date('d-m-Y') ?> >
                            </div>
                        </div>
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
    var nojob = '' ;
    var selectbaris = 0 ;
    
    $('#search').on('keyup',function () {
        tbl_chkpjt.search(this.value).draw();
    });
    
    $("#display").change(function() {
        tbl_chkpjt.page.len(this.value).draw();
    });

    $(document).ready(function() {
        tbl_chkpjt = $('#tbl_chkpjt').DataTable({
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
                "url": "<?php echo site_url('pjt/entry/tbl_chkpjt') ?>",
                "type": "POST",
                "beforeSend": function() {
                        $("#loading-wrapper").show();
                    },
                "data": function(data) {
                    data.tgljobstart = document.getElementById("tgljobstart").value;
                    data.tgljobend = document.getElementById("tgljobend").value;
                },
                "complete": function() {
                        $("#loading-wrapper").hide();
                        tbl_chkpjt.$('tr.selected').removeClass('selected');
                        tbl_chkpjt.row(selectbaris).nodes().to$().toggleClass( 'selected' );
                        
                        var data = tbl_chkpjt.row(selectbaris).data();
                        nojob = data[1];
                    }

            },
            "columnDefs": [{
                    "targets": [0],
                    "orderable": false
                }]
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

        $('#tbl_chkpjt tbody').on('click', 'tr', function() {
            var data = tbl_chkpjt.row(this).data();

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                nojob = '' ;
                selectbaris = 0 ;
            } else {
                tbl_chkpjt.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                nojob = data[1];
                selectbaris = tbl_chkpjt.row(this)[0];  
            }
        });
        

        $("#tgljobstart").change(function() {
            tbl_chkpjt.ajax.reload(null, false);
        });

        $("#tgljobend").change(function() {
            tbl_chkpjt.ajax.reload(null, false);
        });
        
    });
    
    
    
    $(document).on('click', '.btnadd', function(e) {
        $.post('<?php echo site_url() ?>pjt/entry/formadd', {
            //param_form: 'search_nmimportir',
        },
        function(xx) {
            $('#div_popup_form').html(xx);
            $("#modal_add_formcheckpjt").modal({
                show: true,
                backdrop: 'static',
            });
            $('.modal-title').text('Add Antrian PJT');
        });
    });


    $(document).on('click', '.btnedit', function(e) {
        if(nojob == ''){
            alert('belum ada data yang dipilih..!!');
            return false;
        }

        $.post('<?php echo site_url() ?>pjt/entry/formedit', {
            nojob: nojob,
        },
        function(xx) {
            $('#div_popup_form').html(xx);
            $("#modal_edit_formcheckpjt").modal({
                show: true,
                backdrop: 'static',
            });
            $('.modal-title').text('Edit Antrian PJT');
        });
    });

    $(document).on('click', '.btndelete', function(e) {
        if(nojob == ''){
            alert('belum ada data yang dipilih..!!');
            return false;
        }

        var jawab = confirm('Anda yakin ingin menghapus data ini ?');

        if (jawab === true) { 
            url = '<?php echo site_url('pjt/entry/delete') ?>';
            data = {nojob: nojob};
            pesan = 'JavaScript Delete Error...';
            dataok = multi_ajax_proses(url, data, pesan);
        }

        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }

        alert(dataok.pesan);
        nojob = '';
        selectbaris = 0 ;
        tbl_chkpjt.ajax.reload(null, false);
    });

    $(document).on('click', '.btnprint', function(e) {
        if(nojob == ''){
            alert('belum ada data yang dipilih..!!');
            return false;
        }

        var page = "<?php echo base_url(); ?>pjt/entry/print?data="+ nojob ;
        //window.open(page, '_Details', 'scrollbars=1, resizable=1,location=0,statusbar=0,menubar=0,width=1200,height=700,left=50,top=50,titlebar=yes',"mywindow1");
        window.open(page);

    });

    
</script>