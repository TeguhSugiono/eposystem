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
            background-image: url('<?php echo base_url('assets/' . $this->session->userdata('pathtemplate') . '/POBlank.jpg'); ?>');
            background-repeat: no-repeat;
            background-size: cover;
            z-index: -1;
        }

        .content {
            position: relative;
            z-index: 2;
            padding: 40px 45px 30px 35px;
            box-sizing: border-box;
        }

        .Header1 {
            height: 98px;
            width: 730px !important;
            margin-top: 110px !important;
            margin-left: -0.4% !important;
            margin-bottom: -1% !important;
        }

        .DetailBarang {
            height: 450px;
            width: 730px !important;
            /* background-color: #96afc4; */
        }

        .DetailFooter1 {
            height: 20px;
            width: 730px !important;
            margin-top: 6px !important;
            margin-left: -0.4% !important;
            /* background-color: #6294bd; */
        }

        .DetailFooter2 {
            height: 360px;
            width: 730px !important;
            /* background-color: #8cc3f0; */
            margin-top: 6px !important;
            margin-left: -0.4% !important;
        }

        .textcenter {
            text-align: center;
        }

        .fontSupplier1 {
            font-size: 14px !important;
            font-weight: bold;
        }

        .fontSupplier2 {
            font-size: 11px !important;
        }

        .fontTitleDet {
            font-size: 11px !important;
        }

        .fontTerbilang {
            font-size: 12px !important;
            font-weight: bold;
        }

        .borderAll {
            border: 1px solid black;
        }

        .no-border-top-bottom {
            border-top: none !important;
            border-bottom: none !important;
        }

        table {
            background: transparent;
        }

        td,
        th {
            background: transparent;
        }
    </style>
</head>

<body>
    <div class="kop-bg"></div>

    <div class="content">
        <div class="Header1">

            <table border='0' style="width:100% !important;" class="fontSupplier2">
                <tr>
                    <td width="46%">
                        <table width="100%" style="border:1px solid black;">
                            <tr>
                                <td style="padding: 0px 2px 0px 2px !important;">Kepada Yth.(Attention)</td>
                            </tr>
                            <tr>
                                <td style="padding: 0px 2px 0px 2px !important;" class="fontSupplier1"><?= strtoupper($GetSupplier[0]['namasupplier']); ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 0px 2px 0px 2px !important;"><?= $GetSupplier[0]['alamat']; ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 0px 2px 0px 2px !important;"><?= $GetSupplier[0]['telp']; ?> </td>
                            </tr>
                            <tr>
                                <td style="padding: 0px 2px 0px 2px !important;"><?= $GetSupplier[0]['fax']; ?> </td>
                            </tr>
                        </table>
                    </td>
                    <td width="8%"></td>
                    <td width="46%" style="vertical-align: top;">
                        <table width="100%" style="border:1px solid black;">
                            <tr>
                                <td valign='top' class="textcenter fontSupplier1"><b>PURCHASE ORDER </b></td>
                            </tr>
                        </table>
                        <table width="100%">
                            <tr>
                                <td style="width: 15% !important;">No</td>
                                <td style="width: 4% !important;">:</td>
                                <td style="width: 81% !important;"> <?= $GetHeaderPO[0]['nopo']; ?> </td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td><?= showdate_inv2($GetHeaderPO[0]['tglpesan']); ?></td>
                            </tr>
                            <tr>
                                <td><i>(Date)</i></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


        </div>
        <div class="DetailBarang">

            <table border='1' style="width:100% !important;border-collapse:collapse;border:1px solid black;" class="fontTitleDet">
                <tr>
                    <td class="textcenter ">No.</td>
                    <td class="textcenter ">Keterangan Barang </br> <i>(Item Description)</i></td>
                    <td class="textcenter ">Proyek </br> <i> (project) </i></td>
                    <td class="textcenter ">Jumlah </br> <i>(Quantity)</i></td>
                    <td class="textcenter ">Satuan </br> <i>(Unit)</i></td>
                    <td class="textcenter " nowrap='nowrap'>Harga Satuan </br> <i>(Unit Price)</i></td>
                    <td class="textcenter ">Diskon </br> <i>(Discount)</i></td>
                    <td class="textcenter " nowrap='nowrap'>Total Harga </br> <i>(Total Amount)</i></td>
                </tr>
                <?= $htmlDet; ?>
                <tr height='5'>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan='7' align='right'><b> Sub Total </b> <i>(Sub Total)</i> </td>
                    <td align='right'> <b> <?= $subtotalharga; ?> </b> </td>
                </tr>
                <tr>
                    <td colspan='7' align='right'><b> Nilai Lain </b> <i>(Nilai Lain)</i> </td>
                    <td align='right'> <b> <?= $nilai_lain; ?> </b> </td>
                </tr>
                <tr>
                    <td colspan='7' align='right'><b> PPN </b> <i>(PPN)</i> </td>
                    <td align='right'> <b> <?= $PPN; ?> </b> </td>
                </tr>
                <tr>
                    <td colspan='7' align='right'><b> Total Seluruh </b> <i>(Grand Total)</i> </td>
                    <td align='right'> <b> <?= $grandtotal; ?> </b> </td>
                </tr>
            </table>

        </div>

        <div class="DetailFooter1">
            <table border='1' style="border-collapse:collapse;width:100%;margin-left: 0.3% !important;" class="fontTerbilang">
                <tr>
                    <td>Terbilang <i>(Said)</i> : # <?= terbilang(str_replace(',', '', $grandtotal)); ?> Rupiah #</td>
                </tr>
            </table>
        </div>

        <div class="DetailFooter2">
            <table border='0' style="width:100%;margin-left: 0.3% !important;" class="fontTitleDet">
                <tr>
                    <td width="45%" valign='top'>
                        <table border="0" width="100%">
                            <tr>
                                <td width="50% !important">Mata Uang <i>(Currency)</i></td>
                                <td width="4% !important">:</td>
                                <td width="46% !important" style="border:1px solid black !important" class="textcenter"><?= $GetHeaderPO[0]['matauang']; ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td> </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="50%">Cara Pembayaran </td>
                                <td>:</td>
                                <td style="border:1px solid black !important" class="textcenter"><?= $GetHeaderPO[0]['pembayaran']; ?></td>
                            </tr>
                            <tr>
                                <td><i>(Payment Method)</i> </td>
                                <td> </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="50%">Untuk dikirim pd tgl. </td>
                                <td>:</td>
                                <td style="border:1px solid black !important" class="textcenter"><?= showdate_inv2($GetHeaderPO[0]['tglkrm']); ?></td>
                            </tr>
                            <tr>
                                <td><i>(Delivery date)</i> </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                    <td width="10%" valign='top'></td>
                    <td width="45%" valign='top'>
                        <table border="0" style="width: 100% !important;">
                            <tr>
                                <td colspan="3" width="45% !important">Jatuh tempo Tanggal </td>
                                <td width="4% !important">:</td>
                                <td width="61% !important" style="border:1px solid black !important" class="textcenter"><?= showdate_inv2($GetHeaderPO[0]['tgltempo']); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3"><i>(Due Date)</i></td>
                                <td> </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3">Keterangan (Remark)</td>
                                <td>:</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td rowspan='3' height='40' colspan="5" valign='top' style="border:1px solid black !important"><?= $GetHeaderPO[0]['keterangan']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table style="width:100%;margin-top:0%;margin-left: 0.3% !important;margin-bottom:0%;" class="fontTitleDet">
                <tr>
                    <td> Hormat Kami <i> (Sincerely Yours),</i></td>
                </tr>
                <tr>
                    <td width="25%">
                        <table width="100%">
                            <tr>
                                <td rowspan='4' height="100" style="border:1px solid black" class="textcenter">
                                    <img src="<?= $barcodeQr; ?>" style="height: 40%;width: 80%" />
                                </td>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr>
                                <?php
                                $ttd = "";
                                if ($GetTTD) {
                                    $ttd = ucwords(strtolower($GetTTD[0]['username']));
                                }
                                ?>
                                <td style="border:1px solid black" class="textcenter"><b><?= $ttd; ?></b></br>
                                    <i>(General Manager )</i>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="3%"></td>
                    <td width="55%" valign='bottom'>
                        <table height="55">
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                        <table width="95%" style="border:1px solid black">
                            <tr>
                                <td style="width: 30% !important;">Atas Nama</td>
                                <td style="width: 5% !important;">:</td>
                                <td style="width: 65% !important;"><?= !empty($GetBank[0]['atasnama']) ? $GetBank[0]['atasnama'] : ''; ?></td>
                            </tr>
                            <tr>
                                <td> Nama Bank</td>
                                <td>:</td>
                                <td><?= !empty($GetBank[0]['namabank']) ? $GetBank[0]['namabank'] : ''; ?></td>
                            </tr>
                            <tr>
                                <td>Nomer Rekening</td>
                                <td>:</td>
                                <td><?= !empty($GetBank[0]['norek']) ? $GetBank[0]['norek'] : ''; ?></td>
                            </tr>
                            <tr>
                                <td>Alamat cabang</td>
                                <td>:</td>
                                <td><?= !empty($GetBank[0]['alamat']) ? $GetBank[0]['alamat'] : ''; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td width="17%" valign='bottom'>
                        <img src="<?= $barcodeQr; ?>" style="height: 40%;width: 100%" />
                    </td>
                </tr>
            </table>
        </div>


    </div>


</body>

</html>