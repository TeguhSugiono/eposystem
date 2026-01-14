<style>        
    .dataout {background-color: yellow !important;}
    .margin-input{margin-bottom: -2.5% !important;}
</style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Report</li>
        <li class="breadcrumb-item active">..::: Cont Movement Recapitulation :::..</li>
    </ol>
</div>

<div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12" >

            <div class="card">
                <div class="card-body boxshadow">

                    <div class="row gutters border" style="padding-top:0.6%;margin-bottom: -0%;">

<!--                         <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12" style="margin-bottom:2%">
                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-12 col-form-label text-left hrufbesar" style="font-size: 20px;font-weight: 400;">Search Data...</label>
                                </div>
                            </div>
                        </div>
 -->
                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-12 col-12">

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

                        </div>
                        
                        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-12 col-12">
                            
                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div class="form-group row gutters">
                                    <label for="inputName" class="col-sm-4 col-form-label text-left">Principal Code</label>
                                    <div class="col-sm-8">
                                        <?=$code_principal;?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12 margin-input">
                                <div style="float: right !important;margin-top: 2% !important;margin-bottom: 2% !important;">
                                    <button class="btn btn-primary" id="btnproses" id="btnproses"><b><span class="icon-download"></span>Proses</b></button>
                                    <button class="btn btn-primary" id="btnprint" id="btnprint"><b><span class="icon-print"></span>Print</b></button>
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
            url: "<?php echo site_url('report/cont_movement_recapitulation/proses') ?>",
            type: "POST",
            data: {
                startdate:$('#startdate').val(),
                enddate:$('#enddate').val(),
                code_principal:$('#code_principal').val()
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

    $('#btnprint').click(function() {
        if(proses == ''){alert('Klik Button Proses...!!!'); return ;}

        var startdate = $('#startdate').val();
        var enddate = $('#enddate').val();
        var code_principal = $('#code_principal').val();

        var data = [];
        data[0] = startdate ;
        data[1] = enddate ;
        data[2] = code_principal ;

        var page = "<?php echo base_url(); ?>report/cont_movement_recapitulation/print?data="+btoa(data) ;
        window.open(page);

    });


</script>