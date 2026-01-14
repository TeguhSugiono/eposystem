<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ePO System - Dashboard</title>
    <link rel="icon" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>logoPO.png" type="images/png" />
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>styles.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>select2.min.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/fontawesome_600/css/'); ?>fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>mobile-menu.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>csstable.css">

    <style type="text/css">
        /* table.dataTable td.text-center,
        table.dataTable td.dt-center {
            text-align: center !important;
            vertical-align: middle !important;
        } */

        /* FixedColumns + scrollX safe CSS */
        /* table.dataTable thead th {
            text-align: center !important;
            vertical-align: middle !important;
            background-color: #f8f9fa !important;
        }

        table.dataTable tbody td.text-right {
            text-align: right !important;
        }

        table.dataTable tbody td.text-center,
        table.dataTable tbody td.dt-center {
            text-align: center !important;
        }

        table.dataTable tbody td.text-left {
            text-align: left !important;
        }

        table.dataTable.fixedHeader-floating thead th {
            background-color: #f8f9fa !important;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6 !important;
        } */
    </style>

</head>

<body>
    <div class="app-container">

        <header class="top-nav">
            <div class="nav-brand">
                <a href="<?= site_url(); ?>" class="brand-link" style="font-weight: 700;color: #ecf0f1;">
                    <i class="fa fa-store"></i>
                    <span>ePO System</span>
                </a>
            </div>

            <?php
            // Ambil nama halaman dari URL
            $pgname = $this->uri->segment(1);

            // --- 1. DEFINISIKAN MENU DALAM BENTUK ARRAY ---
            $menu_items = [
                [
                    'title' => 'Dashboard',
                    'url'   => '',
                    'icon'  => 'fa fa-home'
                ],
                [
                    'title'    => 'Master',
                    'icon'     => 'fa fa-wrench',
                    'children' => [
                        // ['title' => 'Customer', 'url' => 'mst_customer', 'icon' => 'fa fa-list'],
                        ['title' => 'Category',   'url' => 'mst_category',   'icon' => 'fa fa-list'],
                        ['title' => 'Satuan',   'url' => 'mst_satuan',   'icon' => 'fa fa-list'],
                        ['title' => 'Barang',   'url' => 'mst_barang',   'icon' => 'fa fa-list'],
                        ['title' => 'Supplier', 'url' => 'mst_supplier', 'icon' => 'fa fa-list'],
                        ['title' => 'Bank', 'url' => 'mst_bank', 'icon' => 'fa fa-list'],
                        ['title' => 'Proyek',   'url' => 'mst_proyek',   'icon' => 'fa fa-list']
                    ]
                ],
                [
                    'title'    => 'Transaksi',
                    'icon'     => 'fa fa-cart-arrow-down',
                    'children' => [
                        ['title' => 'Purchase Order',   'url' => 'trans_purchaseorder',   'icon' => 'fa fa-file-invoice'],
                        ['title' => 'Terima Barang',   'url' => 'trans_receipt',   'icon' => 'fa fa-file-invoice'],
                    ]
                ],
                [
                    'title' => 'Request PO',
                    'url'   => 'request_po',
                    'icon'  => 'fa fa-paper-plane'
                ]
                // ,
                // [
                //     'title'    => 'Manajemen User',
                //     'icon'     => 'fa fa-users',
                //     'children' => [
                //         ['title' => 'TEST1', 'url' => 'test1', 'icon' => 'fa fa-list'],
                //         [
                //             'title'    => 'Sub Test',
                //             'icon'     => 'fa fa-user-plus',
                //             'children' => [
                //                 ['title' => 'Admin',  'url' => 'test2', 'icon' => 'fa fa-user-shield'],
                //                 ['title' => 'Member', 'url' => 'test3', 'icon' => 'fa fa-user']
                //             ]
                //         ]
                //     ]
                // ]
            ];

            // --- 2. FUNGSI UNTUK MEMBANGUN HTML MENU (SUDAH DIPERBAIKI) ---
            function build_menu_html($items, $pgname, $level = 0)
            {
                $html = '';
                foreach ($items as $item) {
                    $has_children = isset($item['children']) && !empty($item['children']);
                    $is_active = isset($item['url']) && $pgname == $item['url'];
                    $is_open = false;

                    // Cek apakah salah satu anak menu aktif untuk membuka dropdown induk
                    if ($has_children) {
                        foreach ($item['children'] as $child) {
                            if (is_item_active($child, $pgname)) {
                                $is_open = true;
                                break;
                            }
                        }
                    }

                    // Tentukan class untuk <li>
                    $li_class = ($level == 0) ? 'nav-item' : 'dropdown-item';
                    if ($has_children) $li_class .= ($level == 0) ? ' has-dropdown' : ' has-submenu';
                    if ($is_active || $is_open) $li_class .= ' active';
                    if ($is_open) $li_class .= ' open';

                    // Tentukan class untuk <a>
                    $a_class = ($level == 0) ? 'nav-link' : 'dropdown-link';
                    if ($is_active || $is_open) $a_class .= ' active';

                    // Mulai build <li>
                    // --- PERUBAHAN: Menggunakan html_escape() ---
                    $html .= '<li class="' . html_escape(trim($li_class)) . '">';

                    // Build <a>
                    $url = $has_children ? '#' : site_url($item['url']);
                    // --- PERUBAHAN: Menggunakan html_escape() ---
                    $html .= '<a href="' . $url . '" class="' . html_escape(trim($a_class)) . '">';

                    // Tambahkan ikon jika ada
                    if (isset($item['icon'])) {
                        // --- PERUBAHAN: Menggunakan html_escape() ---
                        $html .= '<i class="' . html_escape($item['icon']) . '"></i>';
                    }

                    // Tambahkan judul
                    // --- PERUBAHAN: Menggunakan html_escape() ---
                    $html .= '<span>' . html_escape($item['title']) . '</span>';

                    // Tambahkan panah dropdown jika ada anak
                    if ($has_children) {
                        $arrow_class = ($level == 0) ? 'fa fa-chevron-down dropdown-arrow' : 'fa fa-chevron-right submenu-arrow';
                        // --- PERUBAHAN: Menggunakan html_escape() ---
                        $html .= '<i class="' . html_escape($arrow_class) . '"></i>';
                    }

                    $html .= '</a>';

                    // Jika ada anak, proses secara rekursif
                    if ($has_children) {
                        $ul_class = 'dropdown-menu';
                        if ($level > 0) {
                            $ul_class .= ' submenu-level-' . ($level + 1);
                        }
                        $html .= '<ul class="' . $ul_class . '">';
                        $html .= build_menu_html($item['children'], $pgname, $level + 1);
                        $html .= '</ul>';
                    }

                    $html .= '</li>';
                }
                return $html;
            }

            // Fungsi pembantu untuk mengecek status aktif secara rekursif
            function is_item_active($item, $pgname)
            {
                if (isset($item['url']) && $pgname == $item['url']) {
                    return true;
                }
                if (isset($item['children'])) {
                    foreach ($item['children'] as $child) {
                        if (is_item_active($child, $pgname)) {
                            return true;
                        }
                    }
                }
                return false;
            }
            ?>

            <!-- --- 3. TAMPILKAN MENU --- -->
            <nav class="horizontal-nav">
                <ul class="nav-menu">
                    <?php echo build_menu_html($menu_items, $pgname); ?>
                </ul>
            </nav>

            <!-- Action Buttons -->
            <div class="nav-actions">
                User : <?= $this->session->userdata('PO_username'); ?>
                <!-- <button class="btn btn-primary" onclick="openModal('modal1')">
                    <i class="fa fa-plus"></i> Modal Demo
                </button>
                <button class="btn btn-secondary" onclick="openModal('modalNested')">
                    <i class="fa fa-layer-group"></i> Nested Modal
                </button> -->
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <!-- <div class="content-header">
                <h1 id="pageTitle">Dashboard</h1>
                <div class="breadcrumb">
                    <span id="breadcrumbPath">Dashboard</span>
                </div>
            </div> -->



            <div class="content-area" id="contentArea">
                <?php $this->load->view($content); ?>
            </div>
        </main>

        <!-- Footer -->
        <footer class="app-footer">
            <div class="footer-content">
                <p class="footer-text">
                    <span class="footer-brand">ePO System</span> -
                    <span class="footer-description">Electronic Purchasing Order System</span>
                </p>
                <div class="footer-divider"></div>
                <p class="footer-copyright">
                    © 2025 ePO System. All rights reserved.
                </p>
            </div>
        </footer>
    </div>



    <?php
    // --- AWAL DEBUGGING (HAPUS KODE INI SETELAH SELESAI) ---
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    // --- AKHIR DEBUGGING ---

    // Ambil URI string untuk pengecekan yang lebih akurat
    $current_uri = $this->uri->uri_string();

    // --- 1. DEFINISIKAN MENU DALAM BENTUK ARRAY (LENGKAP) ---
    $menu_items = [
        [
            'title' => 'Dashboard',
            'url'   => '',
            'icon'  => 'fa fa-home'
        ],
        [
            'title'    => 'Master',
            'icon'     => 'fa fa-wrench',
            'children' => [
                // ['title' => 'Customer', 'url' => 'mst_customer', 'icon' => 'fa fa-list'],
                ['title' => 'Category',   'url' => 'mst_category',   'icon' => 'fa fa-list'],
                ['title' => 'Satuan',   'url' => 'mst_satuan',   'icon' => 'fa fa-list'],
                ['title' => 'Barang',   'url' => 'mst_barang',   'icon' => 'fa fa-list'],
                ['title' => 'Supplier', 'url' => 'mst_supplier', 'icon' => 'fa fa-list'],
                ['title' => 'Bank', 'url' => 'mst_bank', 'icon' => 'fa fa-list'],
                ['title' => 'Proyek',   'url' => 'mst_proyek',   'icon' => 'fa fa-list']
                // Tambahkan menu master lainnya di sini
                // ['title' => 'Barang', 'url' => 'mst_barang', 'icon' => 'fa fa-list'],
            ]
        ],
        [
            'title'    => 'Transaksi',
            'icon'     => 'fa fa-cart-arrow-down',
            'children' => [
                ['title' => 'Purchase Order',   'url' => 'trans_purchaseorder',   'icon' => 'fa fa-file-invoice'],
                ['title' => 'Terima Barang',   'url' => 'trans_receipt',   'icon' => 'fa fa-file-invoice'],
            ]
        ],
        [
            'title' => 'Request PO',
            'url'   => 'request_po',
            'icon'  => 'fa fa-paper-plane'
        ]
        // ,
        // [
        //     'title'    => 'Manajemen User',
        //     'icon'     => 'fa fa-users',
        //     'children' => [
        //         ['title' => 'Daftar User', 'url' => 'user', 'icon' => 'fa fa-list'],
        //         ['title' => 'Tambah Admin', 'url' => 'user/create/admin', 'icon' => 'fa fa-user-shield'],
        //         ['title' => 'Tambah Member', 'url' => 'user/create/member', 'icon' => 'fa fa-user'],
        //         ['title' => 'Role & Permission', 'url' => 'role', 'icon' => 'fa fa-user-tag'],
        //     ]
        // ],
        // [
        //     'title'    => 'Laporan',
        //     'icon'     => 'fa fa-chart-bar',
        //     'children' => [
        //         ['title' => 'Laporan Penjualan', 'url' => 'laporan/penjualan', 'icon' => 'fa fa-shopping-cart'],
        //         [
        //             'title'    => 'Keuangan',
        //             'icon'     => 'fa fa-file-invoice',
        //             'children' => [
        //                 ['title' => 'Pemasukan', 'url' => 'keuangan/pemasukan', 'icon' => 'fa fa-arrow-up'],
        //                 ['title' => 'Pengeluaran', 'url' => 'keuangan/pengeluaran', 'icon' => 'fa fa-arrow-down'],
        //             ]
        //         ]
        //     ]
        // ],
        // [
        //     'title' => 'Pengaturan',
        //     'url'   => 'pengaturan',
        //     'icon'  => 'fa fa-cog'
        // ]
    ];

    // --- 2. FUNGSI-FUNGSI PEMBANTU (SUDAH DIPERBAIKI) ---

    // Fungsi untuk mengecek apakah link menu aktif
    function is_active_menu($item_url, $current_uri)
    {
        if ($item_url === '' && $current_uri === '') {
            return true;
        }
        if ($item_url !== '' && strpos($current_uri, $item_url) === 0) {
            return true;
        }
        return false;
    }

    // Fungsi rekursif untuk mengecek apakah ada anak menu yang aktif
    function is_item_active_or_child($item, $current_uri)
    {
        // PERBAIKAN: Cek dulu apakah 'url' ada sebelum memanggil is_active_menu
        if (isset($item['url']) && is_active_menu($item['url'], $current_uri)) {
            return true;
        }
        if (isset($item['children'])) {
            foreach ($item['children'] as $child) {
                if (is_item_active_or_child($child, $current_uri)) {
                    return true;
                }
            }
        }
        return false;
    }

    // --- 3. FUNGSI UTAMA UNTUK MEMBANGUN HTML MENU MOBILE (SUDAH DIPERBAIKI) ---
    function build_mobile_menu_html($items, $current_uri, $level = 0)
    {
        $html = '';
        foreach ($items as $item) {
            $has_children = isset($item['children']) && !empty($item['children']);
            $is_open = $has_children && is_item_active_or_child($item, $current_uri);

            // Tentukan class untuk <div>
            $div_class = 'mobile-menu-item';
            if ($level > 0) $div_class .= ' mobile-sub-item';
            if ($has_children) $div_class .= ' has-mobile-dropdown';
            if ($is_open) $div_class .= ' open';

            // Tentukan class untuk <a>
            $a_class = 'mobile-menu-link';
            if ($has_children) $a_class .= ' mobile-dropdown-toggle';

            // PERBAIKAN: Cek dulu apakah 'url' ada sebelum memanggil is_active_menu
            if (isset($item['url']) && is_active_menu($item['url'], $current_uri)) {
                $a_class .= ' active';
            }

            // Mulai build <div>
            $html .= '<div class="' . html_escape(trim($div_class)) . '">';

            // Build <a>
            $url = $has_children ? '#' : site_url($item['url']);
            $html .= '<a href="' . $url . '" class="' . html_escape(trim($a_class)) . '">';

            // Tambahkan ikon dan judul
            if (isset($item['icon'])) {
                $html .= '<i class="' . html_escape($item['icon']) . '"></i>';
            }
            $html .= '<span>' . html_escape($item['title']) . '</span>';

            // Tambahkan panah dropdown
            if ($has_children) {
                $arrow_icon = ($level === 0) ? 'fa-chevron-down' : 'fa-chevron-right';
                $html .= '<i class="fa ' . $arrow_icon . ' mobile-dropdown-arrow"></i>';
            }

            $html .= '</a>';

            // Jika ada anak, proses secara rekursif
            if ($has_children) {
                $dropdown_class = 'mobile-dropdown-menu';
                if ($level > 0) {
                    $dropdown_class .= ' mobile-submenu';
                }
                $display_style = $is_open ? 'display:block;' : 'display:none;';
                $html .= '<div class="' . $dropdown_class . '" style="' . $display_style . '">';
                $html .= build_mobile_menu_html($item['children'], $current_uri, $level + 1);
                $html .= '</div>';
            }

            $html .= '</div>';
        }
        return $html;
    }
    ?>

    <!-- --- 4. TAMPILKAN MENU MOBILE --- -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay">
        <div class="mobile-menu">
            <div class="mobile-menu-header">
                <a href="<?= site_url() ?>" class="brand-link">
                    <i class="fa fa-store"></i>
                    <span>Dashboard</span>
                </a>
                <button class="mobile-menu-close" id="mobileMenuClose">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <nav class="mobile-nav">
                <?php echo build_mobile_menu_html($menu_items, $current_uri); ?>
            </nav>
        </div>
    </div>


    <!-- Modal Templates -->
    <!-- <div id="modalContainer"></div> -->

    <script src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>jquery-3.7.1.min.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>bootstrap.bundle.min.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>select2.min.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>mobile-menu.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>jquery.dataTables.min.js"></script>
    <script src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>function.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // url = '<-?php echo site_url('dashboard/sendEmail') ?>';
            // data = "";
            // pesan = 'function sendEmail gagal... 😢';
            // dataok = multi_ajax_proses(url, data, pesan);

            // console.log(dataok);

            // setInterval(function(){
            //     //SinKronDO();
            // send_otomatis();
            // }, 180000); // 180.000 milidetik (3 menit)

        });




        //initSelect2();

        // $('.select2').select2({
        //     placeholder: "Pilih salah satu",
        //     allowClear: true,
        //     width: '100%',
        //     // dropdownParent: $('#id_modal_add'),
        //     //minimumResultsForSearch: -1 // SEARCH BOX SELALU MUNCUL, BERAPA PUN OPTION!
        // });

        // function initChosen() {
        //     // Hapus Chosen lama kalau ada (biar nggak double)
        //     $(".chosen-select").chosen("destroy").removeClass("chosen-done");

        //     // Init ulang
        //     $(".chosen-select").chosen({
        //         width: "100%",
        //         no_results_text: "Tidak ditemukan: ",
        //         placeholder_text_single: "Pilih salah satu...",
        //         search_contains: true,
        //         allow_single_deselect: true
        //     });

        //     // FIX HP & DESKTOP: BISA KETIK + 1X KLIK BUKA (TANPA ERROR!)
        //     $(document)
        //         .off('mousedown touchstart click', '.chosen-single')
        //         .on('mousedown touchstart click', '.chosen-single', function(e) {
        //             var $this = $(this);
        //             if (e.type === 'touchstart') e.preventDefault();
        //             if ($this.parent().hasClass('chosen-with-drop')) {
        //                 $this.trigger('mouseup'); // tutup
        //             } else {
        //                 $this.trigger('mousedown'); // buka
        //             }
        //         });

        //     // BISA KETIK CARI DI HP & DESKTOP
        //     $(document).off('focus', '.chosen-search-input').on('focus', '.chosen-search-input', function() {
        //         this.readOnly = false;
        //         this.focus();
        //     });
        // }
    </script>

</body>

</html>