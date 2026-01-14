<style>        
    .dataout {background-color: yellow !important;}
    .margin-input{margin-bottom: -2.5% !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Report</li>
        <li class="breadcrumb-item active">Invoice PJT / ..::: Out & Bahandle :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12" >

            <div class="card">
                <div class="card-body boxshadow">

                    <div class="row gutters border" style="padding-top:0.6%;margin-bottom: -0%;">

                        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">

                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input" style="margin-top: 2%;">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Tipe Invoice</label>
                                    <div class="col-sm-8">
                                        <?=$tipe_invoice;?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Start Date</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control datepicker-dropdowns" id="startdate"  name="startdate" value=<?php echo date('d-m-Y') ?> >
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">End Date</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control datepicker-dropdowns" id="enddate"  name="enddate" value=<?php echo date('d-m-Y') ?> >
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Cosingnee</label>
                                    <div class="col-sm-8">
                                        <?=$consignee;?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div style="float: right !important;margin-top: 2% !important;margin-bottom: 2% !important;">
                                    <button class="btn btn-primary" id="btnproses" id="btnproses"><b><span class="icon-download"></span>Proses</b></button>
                                    <button class="btn btn-primary" id="btnexport" id="btnexport"><b><span class="icon-download"></span>Export</b></button>
                                </div>                                    
                            </div>

                        </div>
                        


                    </div>


                </div>
            </div>

        </div>



    </div>
</div>



<script src="<?= site_url(); ?>assets/js/jquery.min.js"></script>


<script type="text/javascript">
    var proses = '' ;

    $('#btnproses').click(function() {
        prosesdata();
    });

    function prosesdata(){

        $.ajax({
            url: "<?php echo site_url('report/invoice_pjt_out/proses') ?>",
            type: "POST",
            data: {
                startdate:$('#startdate').val(),
                enddate:$('#enddate').val(),
                tipe_invoice:$('#tipe_invoice').val(),
                consignee:$('#consignee').val(),
            },
            dataType: "JSON",
            cache: false,
            "beforeSend": function() {
                $("#loading-wrapper").show();
            },
            success: function(data){
                console.log(data);
                if(data.msg != "Ya"){
                    alert(data.pesan);
                    return ;
                }
                alert(data.pesan);
                proses = 'ok' ;
            },
            complete: function(){
                $("#loading-wrapper").hide();
            }
        }); 
    }


    $('#btnexport').click(function() {
        if(proses == ''){alert('Klik Button Proses...!!!'); return ;}

        var startdate       = $('#startdate').val();
        var enddate         = $('#enddate').val();
        var tipe_invoice    = $('#tipe_invoice').val();
        var consignee     = $('#consignee').val() ;

        var data = [];
        data[0] = startdate ;
        data[1] = enddate ;
        data[2] = tipe_invoice ;
        data[3] = consignee ;

        var page = "<?php echo base_url(); ?>report/invoice_pjt_out/export?data="+btoa(data) ;
        window.open(page);

    });


</script>