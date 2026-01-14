<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>bootstrap-grid.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>styles.css">


<style>
    .rowX {
        margin: -1px;
    }

    @media (max-width: 768px) {
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0px;
        }
    }

    #tabelItem tbody td {
        vertical-align: top !important;
        padding-top: 11px !important;
    }

    /* FIX TOMBO × NEMPLAK DI KANAN (RAPIII BANGET) */
    #bodyItem .input-group {
        display: flex !important;
        align-items: center;
    }

    #bodyItem .input-group .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    #bodyItem .input-group .form-control {
        border-right: none;
    }

    #bodyItem .input-group .input-group-text {
        border-right: none;
    }

    .text-center {
        text-align: center !important;
    }

    .tambah-ket {
        width: 15% !important;
        height: 30px !important;
    }

    .browse_barang {
        width: 7% !important;
        height: 30px !important;
    }

    /* === RESPONSIVE MOBILE — KHUSUS HP (< 768px) === */

    @media (max-width: 767px) {



        /* Table jadi kartu vertikal */
        #tabelItem thead {
            display: none;
        }

        #tabelItem,
        #tabelItem tbody,
        #tabelItem tr,
        #tabelItem td {
            display: block;
            width: 100%;
        }

        #tabelItem tr {
            border: 1px solid #ddd;
            border-radius: 12px;
            margin-bottom: 16px;
            padding: 12px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        #tabelItem td {
            border: none;
            position: relative;
            padding: 8px 0 8px 50% !important;
            text-align: right;
        }

        #tabelItem td::before {
            content: attr(data-label);
            position: absolute;
            left: 12px;
            width: 45%;
            font-weight: bold;
            text-align: left;
            color: #444;
        }

        /* Kolom khusus */
        #tabelItem td:nth-child(1)::before {
            content: "No";
        }

        #tabelItem td:nth-child(2)::before {
            content: "Kode Proyek";
        }

        #tabelItem td:nth-child(3)::before {
            content: "Item Barang";
        }

        #tabelItem td:nth-child(4)::before {
            content: "Qty";
        }

        #tabelItem td:nth-child(5)::before {
            content: "Harga";
        }

        #tabelItem td:nth-child(6)::before {
            content: "Disc (%)";
        }

        #tabelItem td:nth-child(7)::before {
            content: "Total";
        }

        #tabelItem td:nth-child(8)::before {
            content: "Aksi";
        }

        /* Keterangan tetap rapi */
        .keterangan-container {
            padding-left: 0 !important;
            margin-top: 8px;
        }

        .keterangan-container .input-group {
            margin-bottom: 8px;
        }

        /* Tombol +Ket dan Hapus di mobile */
        .tambah-ket,
        .hapus-item,
        .hapus-ket {
            font-size: 0.8rem !important;

        }

        .tambah-ket {
            width: 30% !important;
            height: 30px !important;
        }

        .browse_barang {
            width: 30% !important;
            height: 30px !important;
        }
    }
</style>

<div class="modal-overlay" id="id_modal_add"> <!--style="margin-top: -18% !important;"-->
    <div class="modal xlarge">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fa fa-plus"></i> Add Purchase Order</h3>
            <button class="modal-close" onclick="closeModal('id_modal_add')">×</button>
        </div>
        <div class="modal-body">

            <form id="formadd" class="form-horizontal" method="post" action="#">


                <input type="hidden" class="form-control form-control-sm" id="matauang" name="matauang" value="IDR">

                <div class="row" style="margin-bottom:20px;">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                        <div class="form-group row rowX" style="font-weight:bold">
                            <label class="col-sm-2 col-form-label text-end">Perusahaan</label>
                            <div class="col-sm-10">
                                <?= $company; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">No PO</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="nopo" name="nopo" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Tgl Pesan</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control form-control-sm" id="tglpesan" name="tglpesan">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Tgl Kirim</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control form-control-sm" id="tglkrm" name="tglkrm">
                            </div>
                        </div>
                    </div>

                </div>




                <div class="row rowA">
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">No Penawaran</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="noreff" name="noreff">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">No MR</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="nomr" name="nomr">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Tanda Tangan</label>
                            <div class="col-sm-9">
                                <?= $ttd; ?>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="row rowA">
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Supplier</label>
                            <div class="col-sm-9">
                                <?= $suppl_code; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Pembayaran</label>
                            <div class="col-sm-9">
                                <?= $pembayaran; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Subtotal</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm text-right" id="subtotalharga" name="subtotalharga" value="0.00" readonly>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="row rowA">
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Nama Bank</label>
                            <div class="col-sm-9">
                                <?= $id_bank; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">No Rekening</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="no_rek" name="no_rek" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Nilai Lain</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm text-right" id="nilai_lain" name="nilai_lain" value="0.00" readonly>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="row rowA">
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Keterangan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="keteranganH" name="keteranganH" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Jatuh Tempo</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control form-control-sm" id="tgltempo" name="tgltempo">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">PPN</label>
                            <div class="col-sm-9 d-flex align-items-center">
                                <input type="checkbox" id="chkppn" name="chkppn" checked style="margin-right:8px;">
                                <input type="text" class="form-control form-control-sm text-right" id="ppn" name="ppn" value="0.00" readonly>
                            </div>
                        </div>
                    </div>

                </div>




                <div class="row rowA">
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Besar PPN</label>
                            <div class="col-sm-9">
                                <?= $jml_ppn; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Category</label>
                            <div class="col-sm-9">
                                <?= $id_category; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Biaya Lain</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm text-right" id="lain" name="lain" value="0.00" onkeypress="return OnlyNumber(event)">
                            </div>
                        </div>
                    </div>
                </div>




                <div class="row rowA">
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Grand Total</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm text-right" id="grandtotal" name="grandtotal" value="0.00" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row rowA">
                    <div class="card-body">
                        <div class="datatable-container">
                            <div class="datatable-wrapper">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0" id="tabelItem">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="12%">Kode Proyek</th>
                                                <th width="33%">Item Barang</th>
                                                <th width="8%">Qty</th>
                                                <th width="12%">Harga</th>
                                                <th width="8%">Disc (%)</th>
                                                <th width="12%">Total</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyItem">
                                            <!-- Baris di-generate JS -->
                                        </tbody>
                                    </table>
                                </div>

                                <div class="p-3 bg-light">
                                    <button type="button" class="btn btn-primary btn-sm" id="tambahItem">
                                        + Tambah Item
                                    </button>
                                </div>




                            </div>
                        </div>
                    </div>
                </div>


            </form>



        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('id_modal_add')">Batal</button>
            <button class="btn btn-primary" onclick="save()">Save</button>
        </div>
    </div>
</div>

<div id="divmodalSecond"></div>

<script type="text/javascript">
    initSelect2('id_modal_add');


    var counter = 0;
    var ArrayProyek = [];
    var valueField = "";
    var textField = "";
    var placeholder = [];
    var currentRowId = null;

    function tambahBarisUtama() {

        counter++;

        ArrayProyek = <?= json_encode($dataProyek) ?>;
        //console.log(ArrayProyek);

        const selectHtml = `
            <select name="kode_proyek[${counter}]" 
                    id="kodeproyek_${counter}" 
                    class="form-control form-control-sm select2"                     
                    data-placeholder="~Pilih Proyek~">
                <option value="">~Pilih Proyek~</option>
            </select>
        `;


        const row = `
        <tr data-id="${counter}">
            <td class="text-center align-middle fw-bold" data-label="No">${counter}</td>
            <td data-label="Kode Proyek">
                ${selectHtml}
            </td>
            <td data-label="Item Barang">
                <div class="input-group input-group-sm mb-1">
                    <button type="button" class="btn btn-primary btn-sm browse_barang form-control" name="browse_barang[${counter}]" data-id="${counter}">...</button>
                    <input type="text"  id="item_barang_${counter}" name="item_barang[${counter}]"class="form-control form-control-sm" placeholder="Nama barang" readonly>
                    <input type="hidden"  id="kodebarang_${counter}" name="kodebarang[${counter}]" >
                    <button type="button" class="btn btn-primary btn-sm tambah-ket form-control" data-parent="${counter}">+ Ket</button>
                </div>
                <div class="keterangan-container" id="ket-${counter}"></div>
            </td>
            <td data-label="Qty"><input type="text" onkeypress="return OnlyNumber(event)" id="qty_${counter}" name="qty[${counter}]" class="form-control form-control-sm hitung text-right" value="1.00" min="1" ></td>
            <td data-label="Harga"><input type="text" onkeypress="return OnlyNumber(event)" id="harga_${counter}" name="harga[${counter}]" class="form-control form-control-sm hitung text-right" value="0.00" ></td>
            <td data-label="Disc"><input type="text" onkeypress="return OnlyNumber(event)" id="disc_${counter}" name="disc[${counter}]" class="form-control form-control-sm hitung text-right" value="0.00" min="0" max="100"></td>
            <td data-label="Total"><input type="text" id="total_${counter}" name="total[${counter}]" class="form-control form-control-sm text-right" value="0.00" readonly></td>
            <td data-label="Aksi" class="text-center">
                <button type="button" class="btn btn-danger btn-sm hapus-item">Hapus</button>
            </td>
        </tr>`;
        $('#bodyItem').append(row);

        setTimeout(() => {
            generateCombo(
                ArrayProyek,
                'kodeproyek_' + counter,
                'kodeproyek',
                'lokasiproyek',
                ['', '~Pilih Proyek~']
            );

            $('#kodeproyek_' + counter).val('').trigger('change');
        }, 100);

    }
    // Taruh di luar semua fungsi (sekali jalan aja)
    $(document).on('focusout', 'input[name^="qty["]', function() {
        lostFocusText(this.id, this.value);
    });
    $(document).on('focusout', 'input[name^="harga["]', function() {
        lostFocusText(this.id, this.value);
    });
    $(document).on('focusout', 'input[name^="disc["]', function() {
        lostFocusText(this.id, this.value);
    });
    $(document).on('focusout', '#lain', function() {
        lostFocusText(this.id, this.value);
        hitungSubTotal();
    });

    function lostFocusText(element, value) {
        $('#' + element).val(formatNumberSeparator(UnFormatNumber(value)));
    }

    $(document).ready(function() {
        if ($('#id_modal_add').length && $('#bodyItem tr').length === 0) {
            tambahBarisUtama();
        }
        loadParamPPN(getToday());
    });


    //$(document).on('click', '#tambahItem', tambahBarisUtama);
    $('#tambahItem').off('click').on('click', function() {
        tambahBarisUtama();
    });


    function tambahKeterangan(parentId) {
        const container = $('#ket-' + parentId);
        const idx = container.children().length + 1;

        container.append(`
        <div class="input-group input-group-sm mb-2">
            <span class="input-group-text text-success fw-bold">→</span>
            <input type="text" name="keterangan[${parentId}][]" maxlength="65" class="form-control form-control-sm" placeholder="Keterangan ${idx}">
            <button type="button" class="btn btn-danger btn-sm hapus-ket">×</button>
        </div>
    `);
    }

    // $(document).on('click', '.tambah-ket', function() {
    //     tambahKeterangan($(this).data('parent'));
    // });
    $('#id_modal_add').off('click', '.tambah-ket')
        .on('click', '.tambah-ket', function() {
            tambahKeterangan($(this).data('parent'));
        });

    $(document).on('click', '.hapus-ket', function() {
        $(this).closest('.input-group').remove();
    });


    $(document).on('click', '.hapus-item', function() {

        // Hitung jumlah baris saat ini
        const totalBaris = $('#bodyItem tr').length;

        // KALAU TINGGAL 1 BARIS → NGGAK BOLEH HAPUS!
        if (totalBaris <= 1) {
            return false; // stop eksekusi
        }

        $(this).closest('tr').remove();
        $('#bodyItem tr').each(function(i) {
            $(this).find('td:first').text(i + 1);
        });
        counter = $('#bodyItem tr').length;

        hitungSubTotal();
    });

    $(document).on('input', '.hitung', function() {
        hitungSubTotal();
    });

    $('#chkppn').on('click', function() {
        hitungSubTotal();
    });

    function hitungSubTotal() {
        let subtotal = 0;

        $('#bodyItem tr').each(function() {
            const tr = $(this);

            const qty = parseFloat(UnFormatNumber(tr.find('input[name^="qty"]').val())) || 0;
            const harga = parseFloat(UnFormatNumber(tr.find('input[name^="harga"]').val())) || 0;
            const disc = parseFloat(UnFormatNumber(tr.find('input[name^="disc"]').val())) || 0;

            const totalBaris = qty * harga - disc;

            tr.find('input[name^="total"]').val(formatNumberSeparator(totalBaris));

            subtotal += totalBaris;
        });

        $('#subtotalharga').val(formatNumberSeparator(subtotal.toFixed(0)));

        hitungGrandTotal();
    }

    function hitungGrandTotal() {
        const subtotal = UnFormatNumber($(`#subtotalharga`).val());
        const biayalain = UnFormatNumber($(`#lain`).val());

        var setppn = 0;
        if ($('#chkppn').is(":checked")) {
            setppn = hitungPPN(subtotal);
        } else {
            $(`#nilai_lain`).val(0);
            $(`#ppn`).val(0);
        }

        var grandtotal = parseFloat(subtotal) + parseFloat(setppn) + parseFloat(biayalain);


        $(`#grandtotal`).val(formatNumberSeparator(grandtotal));
    }

    function hitungPPN(grand) {

        var setvalctg = $('#id_category').val();
        var setvalppn = $('#jml_ppn').val();

        var RetrunPPN = 0;

        if (setvalppn == "12") {

            if (setvalctg == "2") { //Barang Non Mewah 11/12

                var nilai_11_per_12 = parseFloat(grand) * 11 / 12;
                $(`#nilai_lain`).val(formatNumberSeparator(Math.round(nilai_11_per_12)));
                RetrunPPN = Math.round(parseFloat(nilai_11_per_12) * (parseFloat(setvalppn) / 100));
                $(`#ppn`).val(formatNumberSeparator(RetrunPPN));

            } else if (setvalctg == "1") { //Barang Mewah

                $(`#nilai_lain`).val(0);

                RetrunPPN = Math.round(parseFloat(grand) * (parseFloat(setvalppn) / 100));
                $(`#ppn`).val(formatNumberSeparator(RetrunPPN));

            }

        } else {
            $(`#nilai_lain`).val(0);

            RetrunPPN = Math.round(parseFloat(grand) * (parseFloat(setvalppn) / 100));
            $(`#ppn`).val(formatNumberSeparator(RetrunPPN));
        }

        return RetrunPPN;
    }

    function closeModal(modalId = 'id_modal_add') {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');

            setTimeout(() => {
                // Hapus isi modal (bukan modalnya) — biar pas buka lagi fresh
                $('#divmodal').empty();

                // Bersihin Select2
                $('.select2-container').remove();
                $('select.select2').select2('destroy');

                // Reset counter
                if (typeof counter !== 'undefined') counter = 0;

                // Reload tabel utama kalau ada
                if (typeof tblmstbarang !== 'undefined') {
                    tblmstbarang.ajax.reload(null, false);
                }
            }, 300);
        }
    }



    $(document).on('change', '#company', function() {
        var company = $(this).val();

        url = '<?php echo site_url('trans_purchaseorder/get_po_number') ?>';
        data = {
            company: company
        };
        pesan = 'function get_po_number gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);

        //console.log(dataok);

        if (dataok.msg != "Ya") {
            alert(dataok.pesan);
            return;
        }

        $('#nopo').val(dataok.nopo);
        $('#tglpesan').focus();


        url = '<?php echo site_url('trans_purchaseorder/get_po_supplier ') ?>';
        data = {
            company: company
        };
        pesan = 'function get_po_supplier gagal... 😢';
        dataCombo = multi_ajax_proses(url, data, pesan);



        valueField = "suppl_code";
        textField = "suppl_name";
        placeholder = ['', '~Pilih Supplier~'];
        generateCombo(dataCombo.po_supplier, 'suppl_code', valueField, textField, placeholder);



    });

    $(document).on('change', '#suppl_code', function() {

        var company = $('#company').val();

        url = '<?php echo site_url('trans_purchaseorder/get_po_bank') ?>';
        data = {
            company: company,
            suppl_code: $('#suppl_code').val()
        };
        pesan = 'function get_po_bank gagal... 😢';
        dataCombo = multi_ajax_proses(url, data, pesan);

        //console.log(dataCombo);

        valueField = "id_bank";
        textField = "nama_bank";
        placeholder = ['', '~Pilih Bank~'];
        generateCombo(dataCombo.po_bank, 'id_bank', valueField, textField, placeholder);

        //$('#pembayaran').focus();
    });

    $(document).on('change', '#tglpesan', function() {
        $('#tglkrm').focus();

        var tglpesan = $('#tglpesan').val();

        loadParamPPN(tglpesan);

        hitungSubTotal();
        $('#tgltempo').val(SetJatuhTempo(tglpesan, 2));

    });

    function loadParamPPN(tglpesan) {


        url = '<?php echo site_url('trans_purchaseorder/get_po_ppn') ?>';
        data = {
            tglpesan: tglpesan
        };
        pesan = 'function get_po_ppn gagal... 😢';
        dataCombo = multi_ajax_proses(url, data, pesan);
        //console.log(dataCombo);
        valueField = "jml_ppn";
        textField = "keterangan";
        placeholder = [dataCombo['po_ppn'][0].jml_ppn, dataCombo['po_ppn'][0].keterangan];
        generateComboNoSelect(dataCombo.po_ppn, 'jml_ppn', valueField, textField, placeholder);

        var dataComboPPN = dataCombo;

        url = '<?php echo site_url('trans_purchaseorder/get_po_category') ?>';
        data = {
            jml_ppn: dataCombo['po_ppn'][0].jml_ppn
        };
        pesan = 'function get_po_category gagal... 😢';
        dataCombo = multi_ajax_proses(url, data, pesan);

        //console.log(dataCombo);

        var defaultValue;
        if (dataComboPPN['po_ppn'][0].jml_ppn == 10 || dataComboPPN['po_ppn'][0].jml_ppn == 11) {
            defaultValue = [dataCombo['po_category'][0].id_category, dataCombo['po_category'][0].category_ppn]
        } else if (dataComboPPN['po_ppn'][0].jml_ppn == 12) {
            defaultValue = [dataCombo['po_category'][1].id_category, dataCombo['po_category'][1].category_ppn]
        }

        valueField = "id_category";
        textField = "category_ppn";
        placeholder = defaultValue;
        generateComboNoSelect(dataCombo.po_category, 'id_category', valueField, textField, placeholder);
    }


    $(document).on('change', '#tglkrm', function() {
        $('#noreff').focus();
    });

    $(document).on('select2:select', '#suppl_code', function() {
        $('#pembayaran').focus();
    });

    $(document).on('change', '#pembayaran', function() {
        if ($(this).val()) {
            // Buka Select2 + langsung fokus ke search box
            $('#id_bank').select2('open');
            setTimeout(() => $('.select2-search__field').focus(), 150);
        }
    });

    $(document).on('select2:select', '#id_bank', function() {

        var company = $('#company').val();

        url = '<?php echo site_url('trans_purchaseorder/get_po_rek') ?>';
        data = {
            id_bank: $(this).val(),
            company: company
        };
        pesan = 'function get_po_rek gagal... 😢';
        dataCombo = multi_ajax_proses(url, data, pesan);

        //console.log(dataCombo);


        $('#keteranganH').focus();
        $('#no_rek').val(dataCombo.getNo_rek);


    });



    //untuk modal ke 2
    $(document).on('click', '.browse_barang', function() {
        currentRowId = $(this).data('id'); // simpan id baris
        // console.log(currentRowId);
        // alert('hehehe');


        $.post('<?= site_url("trans_purchaseorder/load_search_barang") ?>', {
            currentRowId: currentRowId
        }, function(html) {
            $('#divmodalSecond').html(html);

            const modal = document.getElementById('modal_search_item');
            if (modal) {
                modal.classList.add('active');
                modalStack = modalStack || [];
                modalStack.push('modal_search_item');
            }
        });

    });


    function save() {

        if ($('#nopo').val() == "") {
            alert('Perusahaan Belum Dipilih...');
            return;
        }

        if ($('#tglpesan').val() == "") {
            alert('Tgl Pesan Tidak Boleh Kosong...');
            return;
        }

        if ($('#tglkrm').val() == "") {
            alert('Tgl Kirim Tidak Boleh Kosong...');
            return;
        }

        if ($('#pembayaran').val() == "") {
            alert('Jenis Pembayaran Belum Dipilih...');
            return;
        }

        if ($('#tgltempo').val() == "") {
            alert('Tgl Jatuh Temp Tidak Boleh Kosong...');
            return;
        }

        if ($('#suppl_code').val() == "") {
            alert('Supplier Belum Dipilih...');
            return;
        }

        if ($('#subtotalharga').val() == 0) {
            alert('Detail Barang Tidak Boleh Kosong...');
            return;
        }

        if (!validasiDetail()) {
            alert('Detail Barang Tidak Boleh Kosong...');
            return;
        }

        var dataPost = $('#formadd').serialize();


        url = '<?php echo site_url('trans_purchaseorder/save_data') ?>';
        data = dataPost;
        pesan = 'function save_data gagal... 😢';
        dataok = multi_ajax_proses(url, data, pesan);

        //console.log(dataok);
        if (dataok.msg != "Ya") {
            alert(dataok.pesan);
            return;
        }

        alert(dataok.pesan);
        closeModal('id_modal_add');

        tbltranshead.ajax.reload(null, false);
        tbltransdet.ajax.reload(null, false);
        $("#content_text_area").html("");
    }


    function validasiDetail() {
        let isValid = true;

        $('#bodyItem tr').each(function() {
            const counter = $(this).data('id');

            // Cek Kode Proyek
            const kodeProyek = $(`#kodeproyek_${counter}`).val();
            if (!kodeProyek || kodeProyek.trim() === '') {
                isValid = false;
            }

            // Cek Item Barang
            const itemBarang = $(`#item_barang_${counter}`).val();
            if (!itemBarang || itemBarang.trim() === '') {
                isValid = false;
            }
        });

        return isValid; // true = lolos, false = ada yang kosong
    }
</script>