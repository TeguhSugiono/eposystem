<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .page-break {
            page-break-after: always;
        }
        #tblatas .fontatas{
            font-size: 14px !important;
        }
        #tblbawah .fontatas{
            font-size: 15px !important;
        }
        .bordertop{
          border-top: 1px solid black;
      }
      .borderbottom{
          border-bottom: 1px solid black;
      }
      .borderleft{
          border-left: 1px solid black;
      }
      .borderright{
          border-right: 1px solid black;
      }

  </style>
</head>
<body>

    <?php foreach($dataBarcode as $barcode): ?>
        <div style="margin-top: 4% !important;margin-left: -2.5% !important;">

            <table style="width: 100% !important;margin-top: -5% !important;" id="tblatas">
             <tr>
                <td style="width:25% !important;background-color: white;"></td>
                <td style="width:5% !important;background-color: white;vertical-align: top !important">
                    <img src="<?= site_url('assets/image/logo_PTMBA.png') ?>" style="height: 10%;width: 111%"/>
                </td>
                <td style="width:50% !important;background-color: white;vertical-align: top">
                    PT. Multi Bintang Abadi<br><div style="font-size: 12px;">Jl. Kalianak No. 65, Surabaya<br>Phone: (62-31) 7492739 Fax: (62-31) 7483841</div>
                </td>
                <td style="width:20 !important;background-color: white"></td>
            </tr>

        </table>

        <table style="width: 100% !important;margin-top: 4% !important;" id="tblatas">
            <tr class="fontatas">
                <td style="width:13% !important">Nama Kapal</td>
                <td style="width:1% !important">:</td>
                <td style="width:33% !important"><?=$barcode['NM_ANGKUT'];?></td>
                <td style="width:12% !important"></td>
                <td style="width:11% !important"></td>
                <td style="width:1% !important"></td>
                <td style="width:29% !important"></td>
            </tr>

            <tr class="fontatas">
                <td>No. Voyage</td>
                <td>:</td>
                <td><?=$barcode['NO_VOY_FLIGHT'];?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr class="fontatas">
                <td>TPS Asal</td>
                <td>:</td>
                <td><?=$barcode['tpsasal'];?></td>
                <td></td>
                <td>TPS Tujuan</td>
                <td>:</td>
                <td><?=$barcode['TUJUAN'];?></td>
            </tr>

            <tr class="fontatas">
                <td>Kode</td>
                <td>:</td>
                <td><?=$barcode['kode'];?></td>
                <td></td>
                <td>Kode</td>
                <td>:</td>
                <td>MBA0</td>
            </tr>
        </table>
        
        <table style="width: 100% !important;margin-top: 2%;border-collapse: collapse !important;" id="tblbawah">
            <thead>
                <tr class="fontatas">
                    <th class="bordertop borderbottom borderleft" style="width:17% !important">NO CONTAINER</th>
                    <th class="bordertop borderbottom borderleft" style="width:17% !important">NO BL AWB</th>
                    <th class="bordertop borderbottom borderleft" style="width:17% !important">TGL BL AWB</th>
                    <th class="bordertop borderbottom borderleft" style="width:17% !important">CONSIGNEE</th>
                    <th class="bordertop borderbottom borderleft borderright" style="width:32% !important">BARCODE</th>
                </tr>
            </thead>
            <tbody>
                <tr class="fontatas">
                    <td class="borderleft borderbottom" style="height:30% !important;text-align:center;"><?=$barcode['NO_CONT'];?></td>
                    <td class="borderleft borderbottom" style="height:30% !important;text-align:center;"><?=$barcode['NO_BL_AWB'];?></td>
                    <td class="borderleft borderbottom" style="height:30% !important;text-align:center;"><?=$barcode['TGL_BL_AWB'];?></td>
                    <td class="borderleft borderbottom" style="height:30% !important;text-align:center;"><?=$barcode['CONSIGNEE'];?></td>
                    <td class="borderleft borderbottom borderright" style="height:30%; text-align: center;">
                        <img src="<?= site_url('assets/image/qrcode/'.str_replace(' ', '', $barcode['NO_CONT']).'.png') ?>" 
                        style="height: 30%; width: 80%;" />
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
    <?php if ($barcode !== end($dataBarcode)): ?>
        <div class="page-break"></div>
    <?php endif; ?>
<?php endforeach; ?>

</body>
</html>
