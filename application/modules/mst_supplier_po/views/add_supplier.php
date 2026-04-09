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
            <h3 class="modal-title"><i class="fa fa-plus"></i> Add Supplier</h3>
            <button class="modal-close" onclick="closeModal('id_modal_add')">×</button>
        </div>
        <div class="modal-body">

            <form id="formadd" class="form-horizontal" method="post" action="#">


                <!-- <input type="hidden" class="form-control form-control-sm" id="matauang" name="matauang" value="IDR">

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
                </div> -->

                <!-- <div class="row">
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

                </div> -->



                <!-- 
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
                </div> -->




                <!-- <div class="row rowA">
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
                </div> -->




                <!-- <div class="row rowA">
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
                </div> -->




                <!-- <div class="row rowA">
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

                </div> -->




                <!-- <div class="row rowA">
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
                            <label class="col-sm-3 col-form-label text-end">Jns Pajak Brg</label>
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
                </div> -->




                <div class="row rowA">
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Nama Supplier</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="namasupplier" name="namasupplier">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Alamat</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="alamat" name="alamat">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Telp</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="telp" name="telp">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row rowA">
                    <div class="col-md-4">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Fax</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="fax" name="fax">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="display: none;">
                        <div class="form-group row rowX">
                            <label class="col-sm-3 col-form-label text-end">Divisi</label>
                            <div class="col-sm-9">
                                <?= $kode_divisi; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>


                <div class="row rowA">
                    <div class="card-body" style="margin-top: 3%;">
                        <div class="datatable-container">
                            <div class="datatable-wrapper">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0" id="tabelItem">
                                        <thead class="table-dark">
                                            <tr>
                                                <td>No</td>
                                                <td>Nama Bank</td>
                                                <td>a/n Bank</td>
                                                <td>No Rekening</td>
                                                <td>Cabang/Alamat</td>
                                                <td>Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyItem">
                                            <!-- Baris di-generate JS -->
                                        </tbody>
                                    </table>
                                </div>

                                <div class="p-3 bg-light">
                                    <button type="button" class="btn btn-primary btn-sm" id="tambahItem">
                                        + Tambah Bank
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
    var counter = 0;
    var valueField = "";
    var textField = "";
    var placeholder = [];
    var currentRowId = null;


    initSelect2('id_modal_add');

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
                if (typeof tblmstsupplier !== 'undefined') {
                    tblmstsupplier.ajax.reload(null, false);
                }
            }, 300);
        }
    }

    function tambahBarisUtama() {

        counter++;




        const row = `
        <tr data-id="${counter}">
            <td class="text-center align-middle fw-bold" data-label="No">${counter}</td>
            <td data-label="a/n Bank">
                <div class="input-group input-group-sm mb-1">
                    <input type="text"  id="atasnama_${counter}" name="atasnama[${counter}]"class="form-control form-control-sm">
                </div>
            </td>
            <td data-label="Nama Bank"><input type="text" id="namabank_${counter}" name="namabank[${counter}]" class="form-control form-control-sm"></td>
            <td data-label="No Rekening"><input type="text" id="norek_${counter}" name="norek[${counter}]" class="form-control form-control-sm"></td>
            <td data-label="Alamat/Cabang"><input type="text" id="alamatbank_${counter}" name="alamatbank[${counter}]" class="form-control form-control-sm"></td>
            <td data-label="Aksi" class="text-center">
                <button type="button" class="btn btn-danger btn-sm hapus-item">Hapus</button>
            </td>
        </tr>`;
        $('#bodyItem').append(row);

    }

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

    });


    $(document).ready(function() {
        if ($('#id_modal_add').length && $('#bodyItem tr').length === 0) {
            tambahBarisUtama();
        }
    });


    $('#tambahItem').off('click').on('click', function() {
        tambahBarisUtama();
    });

    function save() {

        if ($('#namasupplier').val() == "") {
            alert('Nama Supplier Masih Kosong ...');
            return;
        }


        var dataPost = $('#formadd').serialize();


        url = '<?php echo site_url('mst_supplier_po/save_data') ?>';
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

        tblmstsupplier.ajax.reload(null, false);
    }
</script>