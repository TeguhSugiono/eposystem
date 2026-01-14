<style type="text/css">
    .searchmodal {
        margin-top: 1% !important;
    }
</style>

<div id="modal_add_formcheckpjt" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg boxshadow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="margin-bottom: -3%">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="formcheckpjt" class="form-horizontal" method="post" action="#">
                                <div class="row gutters">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="inputName">Tgl. Job</label>
                                            <input type="text" class="form-control" id="tgljob"  name="tgljob" value=<?php echo date('d-m-Y') ?> readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="inputName">No. JOB</label>
                                            <input type="text" class="form-control" id="nojob" name="nojob" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="inputName">No. PIBK</label>
                                            <input type="text" class="form-control" id="pibk" name="pibk"  autofocus>
                                        </div>
                                    </div>                                                                       
                                </div>

                                <div class="row gutters">    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="inputName">Tgl. PIBK</label>
                                            <input class="form-control datepicker-dropdowns" id="tglpibk" name="tglpibk" type="text" >
                                        </div>
                                    </div> 

                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                        <div class="form-group">
                                            <label for="inputName">Importir</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="nmimportir" name="nmimportir" >
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="btnimportir" name="btnimportir"><span class="icon-search"></span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                                                       
                                </div>
                                
                                <div class="row gutters">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="inputName">No Container</label>
                                            <input type="text" id="nocontainer" name="nocontainer" class="form-control" >
                                        </div>
                                    </div> 
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="inputName">Size</label>
                                            <?php echo $cbosize; ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="inputName">Asal Barang</label>
                                            <input type="text" id="asalbarang" name="asalbarang" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                                
                            </form>

                        </div>
                    </div>
                </div>

            </div>
            
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnsave" id="btnsave"><b><span class="icon-save2"></span>Save</b></button>
                <button class="btn btn-primary" id="btncancel" id="btncancel" data-dismiss="modal"><b><span class="icon-cancel"></span>Cancel</b></button>
            </div>
        </div>
    </div>
</div>

<div id='div_popup_search'></div>


<script type="text/javascript">
    $('.datepicker-dropdowns').pickadate({
        selectYears: true,
        selectMonths: true,
        format: 'dd-mm-yyyy'
    });
    
    $('#btnsave').click(function() {

        if($("#pibk").val()==''){alert("Nomor PIBK belum diisi"); document.getElementById("pibk").focus(); return false;}
        if($("#tglpibk").val()==''){alert("Tanggal PIBK belum diisi"); document.getElementById("tglpibk").focus(); return false;}
        if($("#nmimportir").val()==''){alert("Nama Importir belum diisi"); document.getElementById("nmimportir").focus(); return false;}
        if($("#nocontainer").val()==''){alert("Nomor Conatainer belum diisi"); document.getElementById("nocontainer").focus(); return false;}
        if($("#asalbarang").val()==''){alert("Negara Asal Barang belum diisi"); document.getElementById("asalbarang").focus(); return false;}

        
        url = '<?php echo site_url('pjt/entry/save') ?>';
        data = $('#formcheckpjt').serialize();
        pesan = 'JavaScript Save Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        //console.log(dataok);
        if(dataok.msg != 'Ya'){
            alert(dataok.pesan);
            return false;
        }

        alert(dataok.pesan);
        selectbaris = 0 ;        
        tbl_chkpjt.page('first').draw(false);
        tbl_chkpjt.ajax.reload(null, false);        
        $('#modal_add_formcheckpjt').modal('hide');
    });

    $('#modal_add_formcheckpjt').on('hidden.bs.modal', function() {
        //tbl_chkpjt.ajax.reload(null, false);
    });

//    function KeyPressEnter(event,IdElement){
//        //115 adalah keyascii untuk tekan f4 pada keyboard
//        if(event.keyCode == 115 && IdElement == "nmimportir"){
//            $.post('<?php echo site_url() ?>search', {
//                param_db: 'jobpjt',
//                param_form: 'search_nmimportir',
//            },
//            function(xx) {
//                $('#div_popup_search').html(xx);
//                $("#modal_formsearch").modal({
//                    show: true,
//                    backdrop: 'static',
//                });
//                $('.modal-title_general').text('Form Search Importir');
//            });
//        }
//    }
    
    $('#btnimportir').click(function() {
        $.post('<?php echo site_url() ?>search', {
            param_db: 'jobpjt',
            param_form: 'search_nmimportir',
        },
        function(xx) {
            $('#div_popup_search').html(xx);
            $("#modal_formsearch").modal({
                show: true,
                backdrop: 'static',
            });
            $('.modal-title_general').text('Form Search Importir');
        });
    });

</script>