<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="Responsive Bootstrap4 Dashboard Template">
    <meta name="author" content="ParkerThemes">
    <link rel="shortcut icon" href="<?php echo site_url('assets/image/'); ?>warehouse.png" />
    <title>XGate</title>
    <link rel="stylesheet" href="<?php echo site_url('assets/css/'); ?>poppins.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>fonts/style.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>css/main.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/datatables/dataTables.bs4.css" />
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/datatables/dataTables.bs4-custom.css" />    
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/datepicker/css/classic.css" />
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/datepicker/css/classic.date.css" />
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/bs-select/bs-select.css" />
    
    <style type="text/css">
        body{font-family: 'Poppins', sans-serif;}
        .modal-backdrop{opacity:0.5 !important;}
        .modal-content{margin-top: -5% !important;}
        .toolbar {float:left;}
        .table tr.selected td {background: #09bc45 ;color: white;}   
        .boxshadow{box-shadow: 3px 3px 10px rgba(0,0,0,0.6) !important;}
        .dataTables_length{display: none !important;}
        .dataTables_filter{display: none !important;}
        .hrufbesar{text-transform: uppercase;}
        input:focus {background-color: #f0fafa !important;}
        select:focus {background-color: #f0fafa !important;}
        .modal.fade {overflow-y:scroll;}
        .picker__select--month, .picker__select--year {height: 3em;padding: .1em;}
        .bootstrap-select .dropdown-item.active {color: #000000;}
        .dropdown-menu {width: 15rem;}

    </style>
    
</head>

<body>
    <div id="loading-wrapper">
        <div class='spinner-wrapper'>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
        </div>

        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <header class="header" style="margin-bottom: -0%">
        <div class="container-fluid">


            <div class="row gutters">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                    <a href="<?php echo site_url('dashboard'); ?>" class="logo">XGate<span> (App Gate, Warehouse & TPSOnline)</span></a>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8">


                    <ul class="header-actions">
                        <li class="dropdown">
                            <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                                <span class="user-name"><?php echo strtoupper($this->session->userdata('autogate_username')); ?></span>
                                <span class="avatar"><img src="<?php echo site_url('assets/image/'); ?>patrick.png" alt="Avatar" class="avatar"/></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                                <div class="header-profile-actions">
                                    <div class="header-user-profile">
                                        <div class="header-user">
                                            <img src="<?php echo site_url('assets/image/'); ?>patrick.png" alt="Royal Hospitals Admin" />
                                        </div>
                                        <h5><?php echo strtoupper($this->session->userdata('autogate_username')); ?></h5>
                                    </div>
                                    <a id="template"><i class="icon-image"></i> Change Theme</a>
                                    <a href="<?php echo site_url('logout') ?>"><i class="icon-log-out1"></i> Sign Out</a>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>

            

        </div>
    </header>

    <div class="container-fluid p-0">

        <nav class="navbar navbar-expand-lg custom-navbar">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#royalHospitalsNavbar" aria-controls="royalHospitalsNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                    <i></i>
                    <i></i>
                    <i></i>
                </span>
            </button>

            

            <div class="collapse navbar-collapse" id="royalHospitalsNavbar">
                <?php print_r($menu_dinamis); ?>
            </div>
            
            
        </nav>

        <!--icon-local_shipping-->


        <div class="main-container">
            <?php $this->load->view($content); ?>
        </div>
        <div id='div_popup_form_template'></div>

        <!-- <footer class="main-footer">© PT. Multi Bintang Abadi</footer> -->
        <footer class="main-footer">Copyright &copy; Teguh - Template Royal Hospital - Bootstrap Admin Template by <a href="https://themeforest.net/" style="color:white;">Themeforest For PT. Multi Bintang Abadi</a></footer>

    </div>

    

    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>js/jquery.min.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>js/moment.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/apex/apexcharts.min.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/apex/examples/mixed/hospital-line-column-graph.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/apex/examples/mixed/hospital-line-area-graph.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/apex/examples/bar/hospital-patients-by-age.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/rating/raty.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/rating/raty-custom.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/datepicker/js/picker.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/datepicker/js/picker.date.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>js/main.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/datatables/dataTables.min.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('autogate_thema') . '/'); ?>vendor/bs-select/bs-select.min.js"></script>



    <script type="text/javascript">
        var url = '' ; var data = '' ; var pesan = '' ; var dataok = '' ;

        setInterval(function(){
                //SinKronDO();
            send_otomatis();
            }, 180000); // 180.000 milidetik (3 menit)
        
            //SinKronDO();
        send_otomatis();

            // function SinKronDO(){
            //     url = '<?php echo site_url('transaksi/entry_cont_out/get_do_contout') ?>';
            //     data = "";
            //     pesan = 'Javascript get_do_contout Error..!!';
            //     dataok = multi_ajax_proses(url, data, pesan);
            // }

        function send_otomatis(){
            url = '<?php echo site_url('transaksi/gatein_fcl/get_ready_reffnumber') ?>';
            data = "";
            pesan = 'Javascript get_ready_reffnumber Error..!!';
            dataok = multi_ajax_proses(url, data, pesan);


            if(dataok.arrREF_NUMBER != ""){

                    //console.log(dataok) ;

                url = '<?php echo site_url('transaksi/gatein_fcl/kirimdata') ?>';
                data = {
                    arrREF_NUMBER: dataok.arrREF_NUMBER,
                    proses:"live",
                    UserName:'MBA0',
                    Password:'MBA1234560',
                };
                pesan = 'JavaScript kirimdata Error...';
                dataok = multi_ajax_proses(url, data, pesan);
                

                var strrespon = dataok.pesan ;
                let jmlchar = strrespon.length ;

                    datarespon = strrespon.substring(0, jmlchar-2) + '' + strrespon.substring(jmlchar-1); //fungsi mengahapus tanda di akhir karakter 
                    
                    //alert(datarespon);


                    url = '<?php echo site_url('transaksi/gatein_fcl/sinkron_to_gateinfcl') ?>';
                    data = {
                        datarespon: datarespon
                    };
                    pesan = 'JavaScript sinkron_to_gateinfcl Error...';
                    dataok = multi_ajax_proses(url, data, pesan);
                    //console.log(dataok);
                }else{
                    console.log("tidak ada proses kirim data fcl in container");
                }

                url = '<?php echo site_url('transaksi/gateout_fcl/get_ready_reffnumber') ?>';
                data = "";
                pesan = 'Javascript get_ready_reffnumber Error..!!';
                dataok = multi_ajax_proses(url, data, pesan);

                if(dataok.arrREF_NUMBER != ""){

                    url = '<?php echo site_url('transaksi/gateout_fcl/kirimdata') ?>';
                    data = {
                        arrREF_NUMBER: dataok.arrREF_NUMBER,
                        proses:"live",
                        UserName:'MBA0',
                        Password:'MBA1234560',
                    };
                    pesan = 'JavaScript kirimdata Error...';
                    dataok = multi_ajax_proses(url, data, pesan);

                    var strrespon = dataok.pesan ;
                    let jmlchar = strrespon.length ;

                    datarespon = strrespon.substring(0, jmlchar-2) + '' + strrespon.substring(jmlchar-1); //fungsi mengahapus tanda koma karakter terakhir di akhir string
                    

                    url = '<?php echo site_url('transaksi/gateout_fcl/sinkron_to_gateoutfcl') ?>';
                    data = {
                        datarespon: datarespon
                    };
                    pesan = 'JavaScript sinkron_to_gateoutfcl Error...';
                    dataok = multi_ajax_proses(url, data, pesan);

                    
                }else{
                    console.log("tidak ada proses kirim data fcl out container");
                }

            }
            
            $('.datepicker-dropdowns').pickadate({
                selectYears: true,
                selectMonths: true,
                format: 'dd-mm-yyyy'
            });
            
            function multi_ajax_proses(url, data, pesan) {
                var result = "";
                $.ajax({
                    url: url,
                    type: "POST",
                    data: data,
                    dataType: "JSON",
                    async: false,
                    success: function (data) {
                        result = data;
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        var dataError = {
                            pesan: pesan
                        };
                        result = dataError;
                    }
                });

                return result;
            }
            
            function submit_ajax_proses(url, data, pesan) {
                var result = "";
                $.ajax({
                    url: url,
                    type: "POST",
                    data: data,
                    dataType: "JSON",
                    async: false,                    
                    processData:false,
                    contentType:false,
                    cache:false,                   
                    success: function (data) {
                        result = data;
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        var dataError = {
                            pesan: pesan
                        };
                        result = dataError;
                    }
                });

                return result;
            }

            
            function createmodal(url,data,divform,idmodal){
                $.post(url,data,
                    function (xx) {
                        $(divform).html(xx);
                        $(idmodal).modal({show: true, backdrop: 'static'});
                    }); 
            }

            $('#template').click(function() {
                url = '<?php echo site_url('dashboard/settingtemplate') ?>';
                data = "" ;
                divform = "#div_popup_form_template" ;
                idmodal = "#modal_add_template" ;        
                createmodal(url,data,divform,idmodal); 
            });

            function hapus_isi_array(array, value) {
                var index = array.indexOf(value);
                if (index >= 0) {
                    array.splice(index, 1);
                    urutkan_array(array);
                }
            }
            function urutkan_array(array) {
                var result = [];
                for (var key in array) {
                    result.push(array[key]);
                }
                return result;
            }

            function hanyaAngka(evt) {

                var charCode = (evt.which) ? evt.which : event.keyCode ;
                //alert(charCode); 
                if (charCode > 31 && (charCode < 48 || charCode > 57)){
                    if(charCode == 46){ //46 adalah code titik
                        return true;
                    }
                    return false;
                }else{
                    return true;
                }
                
            }
            
			//removeArray(array_temp,arrREF_NUMBER);
            function removeArray(array_temp, arrayOfArrays) {
                return arrayOfArrays.filter(item => JSON.stringify(item) !== JSON.stringify(array_temp));
            }

            function readTableData(tableId) {
                var table = $('#' + tableId).DataTable();
                var data = [];

                table.rows().every(function() {
                    data.push(this.data());
                });

                return data;
            }

        </script>

    </body>

    </html>