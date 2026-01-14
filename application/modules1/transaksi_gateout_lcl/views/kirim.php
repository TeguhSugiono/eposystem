<style type="text/css">
    .fontlcl{
        font-size: 13px;
    }
</style>


<!-- <div id="modal_edit" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl boxshadow"> -->
<div id="modal_kirim" class="modal fade bd-example-modal-xs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xs boxshadow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Send Gate Out LCL <?=$proses;?></h5>
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
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontlcl">UserName</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" id="UserName" name="UserName" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>     
                                            
                                        </div>

                                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                                <div class="form-group row gutters">
                                                    <label for="inputName" class="col-sm-4 col-form-label text-left fontlcl">Password</label>
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
        arrNM_ANGKUT = "<?=$arrNM_ANGKUT;?>" ;
        arrNO_VOY_FLIGHT = "<?=$arrNO_VOY_FLIGHT;?>" ;
        arrCALL_SIGN = "<?=$arrCALL_SIGN;?>" ;
        arrBL_NUMBER = "<?=$arrBL_NUMBER;?>" ;
        arrCONT_ASAL = "<?=$arrCONT_ASAL;?>" ;



        let position = arrREF_NUMBER.search("TEMP")
        if(position >= 0){
            alert('Format Ref_Number Salah ..!!');
            return false;
        }

        url = '<?php echo site_url('transaksi/gateout_lcl/kirimdata') ?>';
        data = {
            arrREF_NUMBER: arrREF_NUMBER,
            arrNM_ANGKUT:arrNM_ANGKUT,
            arrNO_VOY_FLIGHT:arrNO_VOY_FLIGHT,
            arrCALL_SIGN:arrCALL_SIGN,
            arrBL_NUMBER: arrBL_NUMBER,
            arrCONT_ASAL:arrCONT_ASAL,
            proses:"<?=$proses;?>",
            UserName:$('#UserName').val(),
            Password:$('#Password').val(),
        };

        pesan = 'JavaScript kirimdata Error...';
        dataok = multi_ajax_proses(url, data, pesan);
        console.log(dataok);
        // return;


        var strrespon = dataok.pesan.trim() ;
        let jmlchar = strrespon.length ;

        datarespon = strrespon.substring(0, jmlchar-2) + '' + strrespon.substring(jmlchar-1); 
        //fungsi mengahapus tanda koma karakter terakhir di akhir string
        
        console.log(datarespon) ;
        alert(datarespon);
        //return;


        if("<?=$proses;?>" == "live"){
            url = '<?php echo site_url('transaksi/gateout_lcl/sinkron_to_gateoutlcl') ?>';
            data = {
                datarespon: datarespon
            };
            pesan = 'JavaScript sinkron_to_gateoutlcl Error...';
            dataok = multi_ajax_proses(url, data, pesan);
            console.log(dataok);
        }

    



        tbl_gateout_lcl.ajax.reload(null, false);
        arrREF_NUMBER = [] ; 
        arrBL_NUMBER = [] ; 
        $('#modal_kirim').modal('hide');
    }); 

    $('#modal_kirim').on('hidden.bs.modal', function() {
        // tbl_gateout_lcl.ajax.reload(null, false);
        // arrREF_NUMBER = [] ; 
        // $('#modal_kirim').modal('hide');
    });

    
</script>