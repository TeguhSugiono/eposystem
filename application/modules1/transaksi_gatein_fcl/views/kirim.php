<style type="text/css">
    .fontfcl{
        font-size: 13px;
    }
</style>


<!-- <div id="modal_edit" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl boxshadow"> -->
<div id="modal_kirim" class="modal fade bd-example-modal-xs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xs boxshadow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Send Gate In FCL <?=$proses;?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        <form id="formkirim" class="form-horizontal" method="post" action="#">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row gutters">

                                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">UserName</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="UserName" name="UserName" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>     
                                            
                                        </div>

                                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontfcl">Password</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" class="form-control form-control-sm" id="Password" name="Password">
                                                    </div>
                                                </div>
                                            </div>     
                                            
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnkirim" id="btnkirim"><b><span class="icon-save2"></span>Kirim Data</b></button>
                <button class="btn btn-primary" id="btncancel" id="btncancel" data-dismiss="modal"><b><span class="icon-cancel"></span>Cancel</b></button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">    

    
    $('#btnkirim').click(function() {

        //alert('Fungsi Kirim Sedang dalam perbaikan...');

        if($('#UserName').val() == ""){
            alert('UserName Belum Diisi...');
            $('#UserName').focus();
            return;
        }

        if($('#Password').val() == ""){
            alert('Password Belum Diisi...');
            $('#Password').focus();
            return;
        }


        arrREF_NUMBER = "<?=$arrREF_NUMBER;?>" ;

        url = '<?php echo site_url('transaksi/gatein_fcl/kirimdata') ?>';
        data = {
            arrREF_NUMBER: arrREF_NUMBER,
            proses:"<?=$proses;?>",
            UserName:$('#UserName').val(),
            Password:$('#Password').val(),
        };
        pesan = 'JavaScript kirimdata Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        //console.log(dataok);
        var strrespon = dataok.pesan ;
        let jmlchar = strrespon.length ;

        datarespon = strrespon.substring(0, jmlchar-2) + '' + strrespon.substring(jmlchar-1); //fungsi mengahapus tanda di akhir karakter 
        

        alert(datarespon);

        if("<?=$proses;?>" == "live"){
            url = '<?php echo site_url('transaksi/gatein_fcl/sinkron_to_gateinfcl') ?>';
            data = {
                datarespon: datarespon
            };
            pesan = 'JavaScript sinkron_to_gateinfcl Error...';
            dataok = multi_ajax_proses(url, data, pesan);
            console.log(dataok);
        }

        tbl_gatein_fcl.ajax.reload(null, false);
        arrREF_NUMBER = [] ; 
        $('#modal_kirim').modal('hide');
    }); 

    $('#modal_kirim').on('hidden.bs.modal', function() {
        // tbl_gatein_fcl.ajax.reload(null, false);
        // arrREF_NUMBER = [] ; 
        // $('#modal_kirim').modal('hide');
    });

    
</script>