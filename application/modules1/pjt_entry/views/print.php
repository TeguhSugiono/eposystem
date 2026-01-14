<html>
    <head>
        <style type="text/css">

            @page {
                /*margin: 0px; */
            }

            body { 
                /*margin: 0.5%;*/ 
                font-family: "Monospace", Courier New, monospace;
                margin-right: 0.5% !important;
                margin-left: 0% !important;
                margin-top: 0% !important;
                margin-bottom: 0% !important;
            }

            /*th { font-size: 12px; }*/
            td { font-size: 18px; }

        </style>
    </head>
    <body>

        <table style="width: 100%;margin-top: -0%" border="0">
            <tr>
                <td>

                    <table style="width: 100%;font-weight: bold;" border="0">
                        <tr>
                            <td>PT. MULTI BINTANG ABADI</td>
                        </tr>
                        <tr>
                            <td>JL. KALIANAK BARAT NO.65 ASEMROWO SURABAYA</td>
                        </tr>
                    </table>
                    <table style="width: 100%;font-weight: bold;" border="0">
                        <tr>
                            <td style="text-align: right;width: 85%">NO. URUT JOB</td>
                            <td style="width: 1%">:</td>
                            <td style="width: 14%"><?=$nojob;?></td>
                        </tr> 
                    </table>

                    <table style="width: 100%;text-align: center;margin-top: 3%;border-collapse: collapse;" border="1">
                        <tr>
                            <td>
                                <table style="width: 100%;text-align: center;font-weight: bold;" border="0">
                                    <tr>
                                        <td>JOB PEMERIKSAAN PJT</td>
                                    </tr>                      
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <table style="width: 100%;text-align: center;font-weight: bold;" border="0">
                                    <tr>
                                        <td>TPS MBA ( PJT )</td>
                                    </tr>                      
                                </table>
                            </td>
                        </tr>   

                        <tr>
                            <td>
                                <table style="width: 100%;text-align: left;margin-top: 3%" border="0">
                                    <tr>
                                        <td>
                                            <table style="width: 100%;text-align: left;" border="0">
                                                <tr>
                                                    <td style="width: 40%">NO PIBK</td>
                                                    <td style="width: 1%">:</td>
                                                    <td style="width: 59%"><?=$pibk;?></td>
                                                </tr>   
                                                <tr>
                                                    <td>TANGGAL / JAM PIBK</td>
                                                    <td>:</td>
                                                    <td><?=$tglpibk;?></td>
                                                </tr> 
                                                <tr>
                                                    <td>NAMA IMPORTIR</td>
                                                    <td>:</td>
                                                    <td><?=$nmimportir;?></td>
                                                </tr>        
                                                <tr>
                                                    <td>NOMER KONTAINER / UK'</td>
                                                    <td>:</td>
                                                    <td><?=$nocontainer;?>/<?=$size;?>'</td>
                                                </tr> 
                                                <tr>
                                                    <td>NEGARA ASAL BARANG</td>
                                                    <td>:</td>
                                                    <td><?=$asalbarang;?></td>
                                                </tr>      
                                                <tr>
                                                    <td>JOB BERLAKU ( MAX 3HARI )</td>
                                                    <td>:</td>
                                                    <td>sd <?=$tglberlaku;?></td>
                                                </tr>       
                                            </table>
                                        </td>
                                    </tr>                      
                                </table>
                            </td>
                        </tr>     

                        <tr>
                            <td>
                                <table style="width: 100%;" border="0">
                                    <tr>
                                        <td>SURABAYA, <?=$tgljob;?></td>
                                    </tr>                      
                                </table>
                                <table style="width: 100%;" border="0">
                                    <tr>
                                        <td>Jam : <?php echo date('H:i') ?></td>
                                    </tr>                      
                                </table>
                                <table style="width: 100%;" border="0">
                                    <tr>
                                        <td>PT. MULTI BINTANG ABADI</td>
                                    </tr>                      
                                </table>
                            </td>
                        </tr> 

                    </table>



                    <table style="width: 100%;margin-top: 3%;text-align: right;margin-right: -2%">
                        <tr>
                            <td>Kep. Gudang</td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
	
	<script>
		window.print();
	</script>
	
    </body>
</html>
