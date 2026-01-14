<style type="text/css">
    .searchmodal {
        margin-top: 1% !important;
    }
    .btn-secondary{
        background-color: grey !important;
    }
</style>

<div id="modal_upload" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog boxshadow">
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
                            <form id="submit" class="form-horizontal" method="post" action="#" enctype="multipart/form-data">    
<!--                                 <div class="row gutters"> -->

                                    <!-- <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span><button type="submit" class="btn btn-primary" id="btnsave" id="btnsave"><b><span class="icon-arrow-up-circle"></span>Upload</b></button></span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="fileexcel" name="fileexcel" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-primary" type="button" id="button-addon1">Button</button>
                                                </div>
                                                <input type="file" name="file" class="form-control" aria-describedby="button-addon1">
                                            </div>
                                        </div>
                                    </div> -->

<!--                                 </div> -->

                                <div class="row gutters" style="padding-top:0.6%;margin-bottom: -0%;">


                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="inputName">Title Excel</label>
                                            <input type="text" class="form-control" id="title_file_excel"  name="title_file_excel">
                                        </div>
                                    </div>


                                    <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
                                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                            <div class="form-group row gutters">
                                                <div class="col-sm-9">
                                                    <input type="file" name="fileexcel" id="fileexcel" class="btn btn-secondary text-left">
                                                </div>                                                
                                                <div class="col-sm-3">
                                                    <button type="submit" class="btn btn-primary" id="btnsave" id="btnsave" style="height: 100%;"><b><span class="icon-arrow-up-circle"></span>Upload</b></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
 
                            </form>

                        </div>
                    </div>
                </div>

            </div>
            
           <!--  <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btnsave" id="btnsave"><b><span class="icon-save2"></span>Save</b></button>
                <button class="btn btn-primary" id="btncancel" id="btncancel" data-dismiss="modal"><b><span class="icon-cancel"></span>Cancel</b></button>
            </div> -->
        </div>
    </div>
</div>

<div id='div_popup_search'></div>


<script type="text/javascript">
    
    $('#submit').submit(function(e){
        e.preventDefault();           

        if($('#title_file_excel').val() == ""){
            alert('Title File Excel Tidak Boleh Kosong...!!');
            $('#title_file_excel').focus();
            return false;
        }


        url = '<?php echo site_url('setting/report_excel/upload') ?>';
        data = new FormData(this);
        pesan = 'JavaScript upload Error...';
        dataok = submit_ajax_proses(url, data, pesan);
        console.log(dataok);
        var tampung = "" ;
        for(let a=0;a<dataok.dataexcel.length;a++){
            if(a==0){
                tampung = btoa(dataok.dataexcel[a]);
            }else{
                tampung = tampung +","+ btoa(dataok.dataexcel[a]);
            }
        }
        console.log(tampung);

        //Simpan Data Configuration
        url = '<?php echo site_url('setting/report_excel/simpan_upload') ?>';
        data = {dataexcel:tampung,name_sheet_excel:dataok.name_sheet_excel,title_file_excel:$('#title_file_excel').val()};
        pesan = 'JavaScript simpan_upload Error...';
        dataok = multi_ajax_proses(url, data, pesan);

        if(dataok.msg != "Ya"){
            alert(dataok.pesan);
            return false;
        }

        alert(dataok.pesan);
        $('#modal_upload').modal('hide');

        // url = '<?php echo site_url('setting/report_excel/test') ?>';
        // data = {dataexcel:tampung};
        // pesan = 'JavaScript test Error...';
        // dataok1 = multi_ajax_proses(url, data, pesan);//multi_ajax_proses
        // console.log(dataok1);


        
      
    });

</script>