<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Purchase Order</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .kop-bg {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('<?php echo base_url('assets/' . $this->session->userdata('pathtemplate') . '/kop_po.jpg'); ?>');
            background-repeat: no-repeat;
            background-size: cover;
            z-index: -1;
        }

        .content {
            position: relative;
            z-index: 2;
            padding: 40px 45px 30px 45px;
            box-sizing: border-box;
        }

        .Header1 {
            height: 200px;
            background-color: #dddedf;
            margin-top: 110px !important;
        }

        .DetailBarang {
            height: 400px;
            background-color: #c7d3df;
            margin-top: 10px !important;
        }
    </style>
</head>

<body>
    <div class="kop-bg"></div>

    <div class="content">
        <div class="Header1">
        </div>
        <div class="DetailBarang">
        </div>
    </div>


</body>

</html>