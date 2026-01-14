/**
 * Fungsi utilitas untuk melakukan request AJAX POST secara sinkron (async: false).
 * @param {string} url - URL tujuan request AJAX.
 * @param {object} data - Data yang akan dikirim (key/value pair).
 * @param {string} pesan - Pesan error kustom untuk dikembalikan saat terjadi kegagalan.
 * @returns {object} Hasil dari server (jika sukses) atau objek error kustom.
 */



function multi_ajax_proses(url, data, pesan) {
    var result = "";
    // Pastikan jQuery ($.ajax) sudah dimuat sebelum fungsi ini dipanggil
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "JSON",
        // PENTING: async: false membuat request menjadi sinkron. 
        // Ini akan memblokir eksekusi thread utama browser.
        // Sebaiknya pertimbangkan untuk menggunakan promise/async-await (asinkron) jika memungkinkan.
        async: false, 
        success: function (data) {
            result = data;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Log error untuk debugging
            console.error("AJAX Error:", textStatus, errorThrown, jqXHR); 
            var dataError = {
                // Gunakan pesan kustom yang diberikan
                pesan: pesan, 
                status: textStatus 
            };
            result = dataError;
        }
    });

    return result;
}

function initSelect2(modalId = null) {
    // Kalau tidak dikasi ID, cari modal yang sedang active
    let $parent = null;

    if (modalId) {
        $parent = $('#' + modalId);
    } else {
        // Cari modal yang punya class 'active' atau 'show'
        $parent = $('.modal.active, .modal.show, .modal-overlay.active').first();
        if ($parent.length === 0) {
            $parent = $('body'); // fallback ke body
        }
    }

    // Destroy dulu semua Select2 lama
    $('.select2').each(function() {
        if ($(this).data('select2')) {
            $(this).select2('destroy');
        }
    });

    // Init ulang — dropdownParent otomatis ikut modal aktif!
    $('.select2').select2({
        allowClear: true,
        width: '100%',
        dropdownParent: $parent
    });
}

function OnlyNumber(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode

    if(charCode == 46){ //code char 46 = titik .
        return true;
    }else if(charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
    }else{  
        return true;    
    }
    
}

function formatNumberSeparator(num) {
    if (num === null || num === undefined) {
        return '0';
    }
    num = num.toString();
    var angkadesimal = num.split('.')[1] ;
    if(angkadesimal === undefined ){
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'.00' ;
    }else{
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') ;
    }
}

function UnFormatNumber(str) {
    if (!str || typeof str !== 'string') return str;

    // Hapus semua spasi dan karakter selain angka, titik, koma
    let cleaned = str.replace(/[^\d.,]/g, '').trim();

    // CASE 1: Format Rupiah → ada TITIK sebagai ribuan + KOMA sebagai desimal
    // Contoh: 1.234.567,89  → harus jadi 1234567.89
    if (cleaned.includes(',') && cleaned.includes('.') && cleaned.lastIndexOf('.') < cleaned.lastIndexOf(',')) {
        // Titik di depan koma = ribuan, koma terakhir = desimal
        cleaned = cleaned.replace(/\./g, '');        // hapus semua titik (ribuan)
        cleaned = cleaned.replace(',', '.');         // koma jadi titik desimal
    }
    // CASE 2: Format Dollar → ada KOMA sebagai ribuan, TITIK sebagai desimal
    // Contoh: 1,234,567.89 → jadi 1234567.89
    else if (cleaned.includes(',') && cleaned.includes('.')) {
        // Koma sebelum titik = ribuan
        cleaned = cleaned.replace(/,/g, '');         // hapus semua koma
    }
    // CASE 3: Hanya koma sebagai ribuan (tanpa desimal) → 1,234,567
    else if (cleaned.includes(',') && !cleaned.includes('.')) {
        cleaned = cleaned.replace(/,/g, '');
    }
    // CASE 4: Hanya titik sebagai desimal → 1234567.89 (jarang, tapi aman)

    return cleaned;
}

function FuncHitungPPN(id_category, jml_ppn, total) {
    // Memastikan input adalah angka, meskipun fungsi dipanggil dengan string
    const setvalctg = String(id_category); // Mengubah menjadi string untuk perbandingan '1' atau '2'
    const setvalppn = parseFloat(jml_ppn);
    const total_float = parseFloat(total);

    // Deklarasi objek (bukan Array) untuk menyimpan hasil (return value)
    let ArrayReturn = {
        ppn: 0,
        nilai_lain: 0
    };

    // Pastikan total adalah angka yang valid
    if (isNaN(total_float)) {
        console.error("Input 'total' tidak valid.");
        return ArrayReturn;
    }

    // Variabel untuk PPN yang akan dihitung
    let RetrunPPN = 0;

    // Logika perhitungan PPN
    if (setvalppn === 12) {
        if (setvalctg === "2") { // Kategori 2: Barang Non Mewah (PPN Dihitung dari DPP)
            // Asumsi: DPP (Dasar Pengenaan Pajak) adalah 11/12 dari total.
            // PPN dihitung 12% dari DPP tersebut.
            
            // Mencari DPP (nilai_lain)
            const nilai_11_per_12 = total_float * 11 / 12;
            ArrayReturn.nilai_lain = Math.round(nilai_11_per_12); // DPP
            
            // Menghitung PPN 12% dari DPP
            RetrunPPN = nilai_11_per_12 * (setvalppn / 100);
            ArrayReturn.ppn = Math.round(RetrunPPN);

        } else if (setvalctg === "1") { // Kategori 1: Barang Mewah (PPN Dihitung dari Total)
            
            // DPP dianggap sama dengan Total (Nilai Lain 0)
            ArrayReturn.nilai_lain = 0; 
            
            // Menghitung PPN 12% dari Total
            RetrunPPN = total_float * (setvalppn / 100);
            ArrayReturn.ppn = Math.round(RetrunPPN);
        } else {
            // Jika kategori tidak 1 atau 2, hitung PPN dari Total (sebagai default)
            RetrunPPN = total_float * (setvalppn / 100);
            ArrayReturn.nilai_lain = 0; 
            ArrayReturn.ppn = Math.round(RetrunPPN);
        }
    } else {
        // Jika PPN bukan 12% (misalnya 11%, 10%, dll.)
        
        // PPN selalu dihitung berdasarkan persentase dari Total
        RetrunPPN = total_float * (setvalppn / 100); 
        
        ArrayReturn.nilai_lain = 0; // Tidak ada Nilai Lain/DPP Khusus
        ArrayReturn.ppn = Math.round(RetrunPPN);
    }

    // Mengembalikan objek hasil
    return ArrayReturn;
}

function tglIndo(tanggal) {
    if (!tanggal) return '-';
    const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                   'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    const t = new Date(tanggal);
    return t.getDate() + ' ' + bulan[t.getMonth()] + ' ' + t.getFullYear();
}

function tglIndoJam(tanggal) {
    if (!tanggal) return '-';

    const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                   'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];

    const t = new Date(tanggal);

    const dd = t.getDate();
    const mm = bulan[t.getMonth()];
    const yyyy = t.getFullYear();

    const hh = String(t.getHours()).padStart(2, '0');
    const ii = String(t.getMinutes()).padStart(2, '0');
    const ss = String(t.getSeconds()).padStart(2, '0');

    return `${dd} ${mm} ${yyyy} || ${hh}:${ii}:${ss}`;
}


function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    var div = document.createElement('div');
    div.textContent = text;
    // Ganti kutip satu & kutip dua jadi aman di JS
    return div.innerHTML
        .replace(/'/g, "&#039;")
        .replace(/"/g, "&quot;");
}


document.addEventListener("DOMContentLoaded", function() {

    document.querySelectorAll('.card-container .card').forEach(function(card) {

        let widthValue = card.getAttribute("data-width");

        if (widthValue) {
            card.style.width = widthValue;
        }

    });

});

function getToday() {
    const today = new Date();
    const dd = String(today.getDate()).padStart(2, '0');
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Januari = 0
    const yyyy = today.getFullYear();

    return dd + '/' + mm + '/' + yyyy;
}

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

//generateCombo(dataCategory, ParamNameSelect,valueField,textField,defaultValue);
// function generateCombo(data, ParamNameSelect, valueField, textField, defaultValue = ['', '']) {
//     var $select = $('#' + ParamNameSelect);

//     if ($select.length === 0) {
//         console.error("Select dengan id " + ParamNameSelect + " tidak ditemukan!");
//         return;
//     }

//     // INI YANG PENTING: DESTROY SELECT2 DULU KALAU SUDAH ADA!
//     if ($select.data('select2')) {
//         $select.select2('destroy');
//     }

//     // Simpan value yang sedang dipilih (biar nggak ilang)
//     var prevValue = $select.val();

//     // Kosongin dulu
//     $select.empty();

//     // Tambah opsi default (placeholder)
//     if (defaultValue[1] !== "") {
//         $select.append(`<option value="${defaultValue[0]}">${defaultValue[1]}</option>`);
//     }

//     // Isi data
//     data.forEach(function(item) {
//         var option = `<option value="${item[valueField]}">${item[textField]}</option>`;
//         $select.append(option);
//     });

//     // Kembalikan nilai yang sebelumnya dipilih (kalau ada)
//     if (prevValue && data.some(item => item[valueField] == prevValue)) {
//         $select.val(prevValue);
//     }

//     // INIT ULANG SELECT2 — INI YANG BIKIN HIDUP!
//     $select.select2({
//         allowClear: true,
//         width: '100%',
//         placeholder: defaultValue[1] || 'Pilih salah satu',
//         dropdownParent: $select.closest('.modal') || $('body') // biar dropdown nggak keluar modal
//     });

//     // Trigger change biar form tau
//     $select.trigger('change');
// }

function SetJatuhTempo(tanggal, jumlahMinggu) {
    // Split dd/MM/yyyy
    const [dd, mm, yyyy] = tanggal.split("/");

    // Buat object Date (format: yyyy-mm-dd)
    const dateObj = new Date(`${yyyy}-${mm}-${dd}`);

    // Tambah minggu + 1 hari
    dateObj.setDate(dateObj.getDate() + (jumlahMinggu * 7));

    // Format hasil untuk input type="date"
    const year = dateObj.getFullYear();
    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
    const day = String(dateObj.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}

function generateComboEdt(data, ParamNameSelect, valueField, textField, defaultValue = ['', '']) {
    var $select = $('#' + ParamNameSelect);
    if ($select.length === 0) {
        console.error("Select tidak ditemukan: #" + ParamNameSelect);
        return;
    }

    // DESTROY SELECT2 KALAU SUDAH ADA
    if ($select.data('select2')) {
        $select.select2('destroy');
    }

    // KOSONGIN SELECT
    $select.empty();

    // TAMBAH PLACEHOLDER
    $select.append(`<option value="${defaultValue[0]}">${defaultValue[1]}</option>`);

    // UBAH DATA KE ARRAY
    let dataArray = Array.isArray(data) ? data : Object.values(data || {});

    // FILTER KOSONG
    dataArray = dataArray.filter(item => 
        item && 
        item[valueField] && 
        item[valueField].toString().trim() !== ''
    );

    // ISI OPTION
    dataArray.forEach(item => {
        $select.append(`<option value="${item[valueField]}">${item[textField]}</option>`);
    });

    // INI YANG BARU & PALING PENTING: CARI MODAL AKTIF SECARA DINAMIS!
    let dropdownParent = $('body'); // default ke body

    // Cari modal yang aktif (bisa .active, .show, atau .modal-overlay.active)
    const activeModal = $('.modal.active, .modal.show, .modal-overlay.active').first();
    if (activeModal.length > 0) {
        dropdownParent = activeModal;
    } else if ($select.closest('.modal, .modal-overlay').length > 0) {
        dropdownParent = $select.closest('.modal, .modal-overlay');
    }

    // INIT SELECT2 DENGAN PARENT YANG BENAR
    $select.select2({
        allowClear: true,
        width: '100%',
        dropdownParent: dropdownParent,
        placeholder: defaultValue[1],
        language: {
            noResults: () => 'Tidak ada data',
            searching: () => 'Mencari...'
        }
    });

    // PAKSA PLACEHOLDER MUNCUL
    $select.val('').trigger('change');
}

function generateCombo(data, ParamNameSelect, valueField, textField, defaultValue = ['', '']) {
    var $select = $('#' + ParamNameSelect);
    if ($select.length === 0) {
        console.error("Select tidak ditemukan: #" + ParamNameSelect);
        return;
    }

    // DESTROY SELECT2 DULU
    if ($select.data('select2')) $select.select2('destroy');
    $select.empty();

    // Tambah placeholder
    $select.append(`<option value="${defaultValue[0]}">${defaultValue[1]}</option>`);

    // INI YANG PENTING: UBAH OBJECT NUMERIK KE ARRAY + FILTER KOSONG!
    let dataArray = [];

    if (Array.isArray(data)) {
        dataArray = data;
    } else if (data && typeof data === 'object') {
        // Object numerik → ubah ke array
        dataArray = Object.keys(data)
            .map(key => data[key])
            .filter(item => item && item[valueField] && item[valueField].toString().trim() !== '');
    }

    //console.log('Data supplier yang diproses:', dataArray); // CEK DI CONSOLE!

    // Isi data
    dataArray.forEach(item => {
        $select.append(`<option value="${item[valueField]}">${item[textField]}</option>`);
    });

    // INIT SELECT2 — PASTI JALAN!
    $select.select2({
        allowClear: true,
        width: '100%',
        dropdownParent: $('#id_modal_add'),
        placeholder: defaultValue[1],
        language: {
            noResults: () => 'Tidak ada data',
            searching: () => 'Mencari...'
        }
    });
}

function generateComboNoSelect(data, ParamNameSelect, valueField, textField, defaultValue = ['', '']) {
    var $select = $('#' + ParamNameSelect);
    if ($select.length === 0) {
        console.error("Select tidak ditemukan: #" + ParamNameSelect);
        return;
    }

    // KOSONGIN DULU
    $select.empty();

    // TAMBAH PLACEHOLDER
    $select.append(`<option value="${defaultValue[0]}">${defaultValue[1]}</option>`);

    // UBAH OBJECT KE ARRAY (sama kayak sebelumnya)
    let dataArray = Array.isArray(data) ? data : Object.values(data || {});

    // FILTER YANG KOSONG
    dataArray = dataArray.filter(item => 
        item && 
        item[valueField] && 
        item[valueField].toString().trim() !== ''
    );

    // ISI DATA
    dataArray.forEach(item => {
        $select.append(`<option value="${item[valueField]}">${item[textField]}</option>`);
    });

    // NGGAK PERLU SELECT2 → LANGSUNG JALAN!
    // $select.select2(...) → HAPUS TOTAL!

    // Trigger change biar form tau ada perubahan
    $select.trigger('change');
}

// // Pakai di DataTables render:
// {
//     "data": "ftglpesan",
//     "render": function(data) {
//         return tglIndo(data);
//     }
// }

// function hitungPPN(id_category,jml_ppn,total){
//     var setvalctg = id_category ; // $('#id_category_'+uniqKey).val();
//     var setvalppn = jml_ppn ; // $('#jml_ppn_'+uniqKey).val();

//     var ArrayReturn['ppn'] = 0 ;
//     ArrayReturn['nilai_lain'] = 0 ;

//     if(setvalppn == "12"){
//         if(setvalctg == "2"){ //Barang Non Mewah 11/12
//             var nilai_11_per_12 = parseFloat(total) * 11 / 12 ;
//             ArrayReturn['nilai_lain'] = Math.round(nilai_11_per_12) ;
            
//             RetrunPPN = Math.round(parseFloat(nilai_11_per_12) * (parseFloat(setvalppn) / 100 )) ;
//             ArrayReturn['ppn'] = RetrunPPN ;

//         }else if(setvalctg == "1"){ //Barang Mewah

//             ArrayReturn['nilai_lain'] = 0 ;
//             RetrunPPN = Math.round(parseFloat(total) * (parseFloat(setvalppn) / 100 )) ;
//             ArrayReturn['ppn'] = RetrunPPN ;
//         }
//     }else{
//         RetrunPPN = Math.round(parseFloat(total) * (parseFloat(setvalppn) / 100 )) ;
//         ArrayReturn['nilai_lain'] = 0 ;
//         ArrayReturn['ppn'] = RetrunPPN ;
//     }

//     return ArrayReturn;
// }

// function initSelect2() {
//     $('.select2').each(function() {
//         if ($(this).data('select2')) {
//             $(this).select2('destroy');
//         }
//     });

//     $('.select2').select2({
//         allowClear: true,
//         width: '100%',
//         dropdownParent: $('#id_modal_add')
//     });
// }


