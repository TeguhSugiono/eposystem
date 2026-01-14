<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order</title>
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>dataTables.bootstrap5.min.css">
    <style>
        .textcenter {
            text-align: center;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0px !important;
        }

        .logo {
            min-height: 120px;
        }

        .header {
            min-height: 85px;
            margin: 0px !important;
        }

        .content {
            min-height: 570px;
            margin: 0px !important;
        }

        .footer {
            min-height: 250px;
            margin: 0px !important;
        }

        .font1 {
            font-size: 11px;
            color: black;
        }

        .font2 {
            font-size: 11px;
            color: black;
        }

        .font3 {
            font-size: 10px;
            color: black;
        }

        @media print {
            .page-break {
                page-break-before: always;
            }

            .no-break {
                page-break-inside: avoid;
            }

            .logo {
                display: none;
            }
        }
    </style>
</head>

<body>

    <?php
    // === DUMMY DATA ===
    $total_dummy_items = 100; // Ganti sesuai jumlah item nanti
    $per_page = 45;
    $pages = ceil($total_dummy_items / $per_page);
    ?>

    <!-- HEADER SELALU DI AWAL & DIULANG PER HALAMAN -->
    <div class="no-break">
        <div class="logo"></div>
        <div class="header">
            <table border='0' style="width:100% !important;" class="font1">
                <tr>
                    <td width="45%">
                        <table border="0" width="100%" style="border:1px solid black;">
                            <tr>
                                <td>Kepada Yth.(Attention) </br>
                                    <b> <?= $GetSupplier[0]['suppl_name']; ?> </b> </br>
                                    <?= $GetSupplier[0]['address1'] . ' ' . $GetSupplier[0]['address2'] . ' ' . $GetSupplier[0]['address3']; ?> </br>
                                    <?= $GetSupplier[0]['phone']; ?> </br>
                                    <?= $GetSupplier[0]['fax']; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="10%"></td>
                    <td width="45%">
                        <table border="0" width="100%" style="border:1px solid black;">
                            <tr>
                                <td valign='top' class="textcenter"><b>PURCHASE ORDER </b></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td>No</td>
                                <td>:</td>
                                <td> <?= $GetHeaderPO[0]['nopo']; ?> </td>
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
    </div>

    <!-- CONTENT: LOOPING ITEM DENGAN PAGINASI -->
    <div class="content no-break">

        <?php for ($page = 1; $page <= $pages; $page++): ?>
            <?php
            $start = ($page - 1) * $per_page + 1;
            $end   = min($page * $per_page, $total_dummy_items);
            ?>

            <table border='1' style="border-collapse:collapse;border:1px solid black;margin-left:0.3% !important;" width="100%" class="font2">
                <tr>
                    <td class="textcenter">No.</td>
                    <td class="textcenter">Keterangan Barang <br><i>(Item Description)</i></td>
                    <td class="textcenter">Proyek <br><i>(project)</i></td>
                    <td class="textcenter">Jumlah <br><i>(Quantity)</i></td>
                    <td class="textcenter">Satuan <br><i>(Unit)</i></td>
                    <td class="textcenter" nowrap='nowrap'>Harga Satuan <br><i>(Unit Price)</i></td>
                    <td class="textcenter">Diskon <br><i>(Discount)</i></td>
                    <td class="textcenter" nowrap='nowrap'>Total Harga <br><i>(Total Amount)</i></td>
                </tr>

                <?php for ($a = $start; $a <= $end; $a++): ?>
                    <tr>
                        <td valign='top'><?= $a; ?></td>
                        <td valign='top'>PC AIO LENOVO NEO 30A 24 12CEA07KID </td>
                        <td valign='top' nowrap='nowrap'>Balrich Trucking</td>
                        <td valign='top'>2</td>
                        <td valign='top'>Unit</td>
                        <td align='right' valign='top'>7,600,000</td>
                        <td align='right' valign='top'>0</td>
                        <td align='right' valign='top'>15,200,000</td>
                    </tr>
                <?php endfor; ?>

                <!-- Kosongkan sisa baris (kecuali halaman terakhir) -->
                <?php if ($page < $pages): ?>
                    <?php for ($empty = $end + 1; $empty <= $page * $per_page; $empty++): ?>
                        <tr height="25">
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endfor; ?>
                <?php endif; ?>

                <!-- TOTAL HANYA DI HALAMAN TERAKHIR -->
                <?php if ($page == $pages): ?>
                    <tr height="5">
                        <td colspan="8"></td>
                    </tr>
                    <tr>
                        <td colspan='7' align='right'><b>Sub Total <i>(Sub Total)</i></b></td>
                        <td align='right'><b><?= number_format(16625000); ?></b></td>
                    </tr>
                    <tr>
                        <td colspan='7' align='right'><b>Nilai Lain <i>(Nilai Lain)</i></b></td>
                        <td align='right'><b><?= number_format(15239583); ?></b></td>
                    </tr>
                    <tr>
                        <td colspan='7' align='right'><b>PPN <i>(PPN)</i></b></td>
                        <td align='right'><b><?= number_format(1828750); ?></b></td>
                    </tr>
                    <tr>
                        <td colspan='7' align='right'><b>Total Seluruh <i>(Grand Total)</i></b></td>
                        <td align='right'><b><?= number_format(18453750); ?></b></td>
                    </tr>
                <?php endif; ?>
            </table>

            <?php if ($page < $pages): ?>
                <div class="page-break"></div>

                <!-- Ulangi header untuk halaman berikutnya -->
                <div class="no-break">
                    <div class="logo"></div>
                    <div class="header">
                        <table border='0' style="width:100% !important;" class="font1">
                            <tr>
                                <td width="45%">
                                    <table border="0" width="100%" style="border:1px solid black;">
                                        <tr>
                                            <td>Kepada Yth.(Attention) </br>
                                                <b> <?= $GetSupplier[0]['suppl_name']; ?> </b> </br>
                                                <?= $GetSupplier[0]['address1'] . ' ' . $GetSupplier[0]['address2'] . ' ' . $GetSupplier[0]['address3']; ?> </br>
                                                <?= $GetSupplier[0]['phone']; ?> </br>
                                                <?= $GetSupplier[0]['fax']; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="10%"></td>
                                <td width="45%">
                                    <table border="0" width="100%" style="border:1px solid black;">
                                        <tr>
                                            <td valign='top' class="textcenter"><b>PURCHASE ORDER </b></td>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr>
                                            <td>No</td>
                                            <td>:</td>
                                            <td> <?= $GetHeaderPO[0]['nopo']; ?> </td>
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
                </div>
            <?php endif; ?>
        <?php endfor; ?>

        <!-- TERBILANG -->
        <table border='1' style="border-collapse:collapse;width:100%;margin-top:2%;margin-left:0.3% !important;" class="font3">
            <tr>
                <td>Terbilang <i>(Said)</i> : # <?= terbilang(18453750); ?> RUPIAH #</td>
            </tr>
        </table>

        <!-- PEMBAYARAN & KETERANGAN -->
        <table border='0' style="width:100%;margin-top:2%;margin-left:0.3% !important;" class="font2">
            <tr>
                <td width="45%" valign='top'>
                    <table border="0" width="100%">
                        <tr>
                            <td width="50% !important">Mata Uang <i>(Currency)</i></td>
                            <td width="4% !important">:</td>
                            <td width="46% !important" style="border:1px solid black" class="textcenter"><?= $GetHeaderPO[0]['matauang']; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td width="50%">Cara Pembayaran </td>
                            <td>:</td>
                            <td style="border:1px solid black" class="textcenter"><?= $GetHeaderPO[0]['pembayaran']; ?></td>
                        </tr>
                        <tr>
                            <td><i>(Payment Method)</i></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td width="50%">Untuk dikirim pd tgl. </td>
                            <td>:</td>
                            <td style="border:1px solid black" class="textcenter"><?= showdate_inv2($GetHeaderPO[0]['tglkrm']); ?></td>
                        </tr>
                        <tr>
                            <td><i>(Delivery date)</i></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
                <td width="10%" valign='top'></td>
                <td width="45%" valign='top'>
                    <table border="0" width="100%">
                        <tr>
                            <td width="50% !important">Jatuh tempo Tanggal </td>
                            <td width="4% !important">:</td>
                            <td width="46% !important" style="border:1px solid black" class="textcenter"><?= showdate_inv2($GetHeaderPO[0]['tgltempo']); ?></td>
                        </tr>
                        <tr>
                            <td><i>(Due Date)</i></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td width="50%" rowspan='3' valign='top'>Keterangan </td>
                            <td rowspan='3' valign='top'>: </td>
                            <td rowspan='3' height='80' valign='top' style="border:1px solid black"><?= $GetHeaderPO[0]['keterangan']; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div>

    <!-- FOOTER -->
    <div class="footer no-break">
        <table style="width:100%;margin-top:0%;margin-left:0.3% !important;margin-bottom:0%;" class="font2">
            <tr>
                <td> Hormat Kami <i> (Sincerely Yours),</i></td>
            </tr>
            <tr>
                <td width="30%">
                    <table width="100%">
                        <tr>
                            <td rowspan='4' height="100" style="border:1px solid black"></td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr>
                            <td style="border:1px solid black" class="textcenter"><b><?= ucwords(strtolower($GetTTD[0]['username'])); ?></b></br>
                                <i>(General Manager )</i>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="3%"></td>
                <td width="50%" valign='bottom'>
                    <table height="55">
                        <tr>
                            <td></td>
                        </tr>
                    </table>
                    <table width="95%" style="border:1px solid black">
                        <tr>
                            <td>Atas Nama</td>
                            <td>:</td>
                            <td><?= $GetBank[0]['atas_nama']; ?></td>
                        </tr>
                        <tr>
                            <td> Nama Bank</td>
                            <td>:</td>
                            <td><?= $GetBank[0]['nama_bank']; ?></td>
                        </tr>
                        <tr>
                            <td>Nomer Rekening</td>
                            <td>:</td>
                            <td><?= $GetBank[0]['no_rek']; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat cabang</td>
                            <td>:</td>
                            <td><?= $GetBank[0]['alamat']; ?></td>
                        </tr>
                    </table>
                </td>
                <td width="20%"></td>
            </tr>
        </table>
    </div>

</body>

</html>