<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Responsive Bootstrap4 Dashboard Template">
        <meta name="author" content="ParkerThemes">
        <link rel="shortcut icon" href="<?php echo site_url('assets/image/'); ?>warehouse.png" />
        <title style="font-family:roboto !important;">XGate LOGIN</title>
        <link rel="stylesheet" href="<?php echo site_url('assets/design-option-4/'); ?>css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo site_url('assets/design-option-4/'); ?>css/main.css" />

        <style>
            .login-screen {
                opacity: 0.8 !important;
            }

            body { 
                font-family: "Monospace", Courier New, monospace;
            }
        </style>
    </head>

    <body class="authentication">

        <div class="container">
            <form action="<?= $action_btnlogin; ?>" method="post">
                <div class="row justify-content-md-center">
                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                        <div class="login-screen">
                            <div class="login-box">
                                <a href="#" class="login-logo">
                                    <div style="font-family:roboto !important;">XGate</div>
                                </a>

                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Username" id="username" name="username" />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" />
                                </div>
                                <div class="actions">

                                    <button class="btn btn-info" id="btnlogin">Login</button>
                                </div>

                                <div class="text-center text-error" style="color:red">
                                    <?php echo $status_loginku;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>


    </body>



</html>