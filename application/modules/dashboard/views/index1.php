<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>styles.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/fontawesome_600/css/'); ?>fontawesome.min.css">

</head>

<body>
    <div class="app-container">
        <!-- Top Navigation Bar -->
        <header class="top-nav">
            <div class="nav-brand">
                <a href="#" class="brand-link" data-page="dashboard">
                    <i class="fa fa-cube"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Horizontal Menu -->
            <nav class="horizontal-nav">
                <ul class="nav-menu">
                    <!-- Menu Level 1 -->
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-page="dashboard">
                            <i class="fa fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Menu Level 1 dengan Submenu -->
                    <li class="nav-item has-dropdown">
                        <a href="#" class="nav-link">
                            <i class="fa fa-users"></i>
                            <span>Manajemen User</span>
                            <i class="fa fa-chevron-down dropdown-arrow"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item">
                                <a href="#" class="dropdown-link" data-page="user-list">
                                    <i class="fa fa-list"></i>
                                    <span>Daftar User</span>
                                </a>
                            </li>
                            <li class="dropdown-item has-submenu">
                                <a href="#" class="dropdown-link">
                                    <i class="fa fa-user-plus"></i>
                                    <span>Tambah User</span>
                                    <i class="fa fa-chevron-right submenu-arrow"></i>
                                </a>
                                <ul class="dropdown-menu submenu-level-2">
                                    <li class="dropdown-item">
                                        <a href="#" class="dropdown-link" data-page="add-admin">
                                            <i class="fa fa-user-shield"></i>
                                            <span>Admin</span>
                                        </a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="#" class="dropdown-link" data-page="add-member">
                                            <i class="fa fa-user"></i>
                                            <span>Member</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-item">
                                <a href="#" class="dropdown-link" data-page="user-roles">
                                    <i class="fa fa-user-tag"></i>
                                    <span>Role & Permission</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Menu Level 1 dengan Submenu Lain -->
                    <li class="nav-item has-dropdown">
                        <a href="#" class="nav-link">
                            <i class="fa fa-chart-bar"></i>
                            <span>Laporan</span>
                            <i class="fa fa-chevron-down dropdown-arrow"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item">
                                <a href="#" class="dropdown-link" data-page="sales-report">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>Laporan Penjualan</span>
                                </a>
                            </li>
                            <li class="dropdown-item has-submenu">
                                <a href="#" class="dropdown-link">
                                    <i class="fa fa-file-invoice"></i>
                                    <span>Keuangan</span>
                                    <i class="fa fa-chevron-right submenu-arrow"></i>
                                </a>
                                <ul class="dropdown-menu submenu-level-2">
                                    <li class="dropdown-item">
                                        <a href="#" class="dropdown-link" data-page="income">
                                            <i class="fa fa-arrow-up"></i>
                                            <span>Pemasukan</span>
                                        </a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="#" class="dropdown-link" data-page="expense">
                                            <i class="fa fa-arrow-down"></i>
                                            <span>Pengeluaran</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <!-- Menu Level 1 Lain -->
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-page="settings">
                            <i class="fa fa-cog"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link" data-page="settings">
                            <i class="fa fa-cog"></i>
                            <span>test1</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link" data-page="settings">
                            <i class="fa fa-cog"></i>
                            <span>test2</span>
                        </a>
                    </li>

                </ul>
            </nav>

            <!-- Action Buttons -->
            <div class="nav-actions">
                <button class="btn btn-primary" onclick="openModal('modal1')">
                    <i class="fa fa-plus"></i> Modal Demo
                </button>
                <button class="btn btn-secondary" onclick="openModal('modalNested')">
                    <i class="fasfa-layer-group"></i> Nested Modal
                </button>
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <h1 id="pageTitle">Dashboard</h1>
                <div class="breadcrumb">
                    <span id="breadcrumbPath">Dashboard</span>
                </div>
            </div>

            <div class="content-area" id="contentArea">
                <!-- Dynamic content will be loaded here -->
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
                    © 2024 ePO System. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay">
        <div class="mobile-menu">
            <div class="mobile-menu-header">
                <a href="#" class="brand-link" data-page="dashboard">
                    <i class="fa fa-cube"></i>
                    <span>Dashboard</span>
                </a>
                <button class="mobile-menu-close" id="mobileMenuClose">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <nav class="mobile-nav">
                <!-- Mobile menu items will be cloned here -->
            </nav>
        </div>
    </div>

    <!-- Modal Templates -->
    <div id="modalContainer"></div>

    <!-- Scripts -->
    <script src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>script_old.js"></script>
</body>

</html>

<!-- <nav class="horizontal-nav">
                <ul class="nav-menu">
       
                    <li class="nav-item">
                        <a href="dashboard.html" class="nav-link">
                            <i class="fa fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

              
                    <li class="nav-item has-dropdown">
                        <a href="#" class="nav-link">
                            <i class="fa fa-users"></i>
                            <span>Manajemen User</span>
                            <i class="fa fa-chevron-down dropdown-arrow"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item">
                                <a href="user-list.html" class="dropdown-link">
                                    <i class="fa fa-list"></i>
                                    <span>Daftar User</span>
                                </a>
                            </li>
                            <li class="dropdown-item has-submenu">
                                <a href="#" class="dropdown-link">
                                    <i class="fa fa-user-plus"></i>
                                    <span>Tambah User</span>
                                    <i class="fa fa-chevron-right submenu-arrow"></i>
                                </a>
                                <ul class="dropdown-menu submenu-level-2">
                                    <li class="dropdown-item">
                                        <a href="user-add-admin.html" class="dropdown-link">
                                            <i class="fa fa-user-shield"></i>
                                            <span>Admin</span>
                                        </a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="user-add-member.html" class="dropdown-link">
                                            <i class="fa fa-user"></i>
                                            <span>Member</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-item">
                                <a href="user-roles.html" class="dropdown-link">
                                    <i class="fa fa-user-tag"></i>
                                    <span>Role & Permission</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    
                    <li class="nav-item has-dropdown">
                        <a href="#" class="nav-link">
                            <i class="fa fa-chart-bar"></i>
                            <span>Laporan</span>
                            <i class="fa fa-chevron-down dropdown-arrow"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item">
                                <a href="report-sales.html" class="dropdown-link">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>Laporan Penjualan</span>
                                </a>
                            </li>
                            <li class="dropdown-item has-submenu">
                                <a href="#" class="dropdown-link">
                                    <i class="fa fa-file-invoice"></i>
                                    <span>Keuangan</span>
                                    <i class="fa fa-chevron-right submenu-arrow"></i>
                                </a>
                                <ul class="dropdown-menu submenu-level-2">
                                    <li class="dropdown-item">
                                        <a href="report-income.html" class="dropdown-link">
                                            <i class="fa fa-arrow-up"></i>
                                            <span>Pemasukan</span>
                                        </a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="report-expense.html" class="dropdown-link">
                                            <i class="fa fa-arrow-down"></i>
                                            <span>Pengeluaran</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

           
                    <li class="nav-item">
                        <a href="settings.html" class="nav-link">
                            <i class="fa fa-cog"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </nav> -->

<!-- Mobile Menu Overlay -->
<!-- <div class="mobile-menu-overlay" id="mobileMenuOverlay">
        <div class="mobile-menu">
            <div class="mobile-menu-header">
                <a href="<-?= site_url(); ?>" class="brand-link">
                    <i class="fa fa-cube"></i>
                    <span>ePO System</span>
                </a>
                <button class="mobile-menu-close" id="mobileMenuClose">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <nav class="mobile-nav">
            </nav>
        </div>
    </div> -->

<!-- <div class="mobile-menu-overlay active" id="mobileMenuOverlay">
        <div class="mobile-menu">
            <div class="mobile-menu-header">
                <a href="<-?= site_url(); ?>" class="brand-link">
                    <i class="fa fa-cube"></i>
                    <span>ePO System</span>
                </a>
                <button class="mobile-menu-close" id="mobileMenuClose">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <nav class="mobile-nav">
                <div class="mobile-menu-item">
                    <a href="#" class="mobile-menu-link" data-page="dashboard">
                        <i class="fa fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="mobile-menu-item has-mobile-dropdown">
                    <a href="#" class="mobile-menu-link mobile-dropdown-toggle">
                        <i class="fa fa-wrench"></i>
                        <span>Master</span>
                        <i class="fas fa-chevron-down mobile-dropdown-arrow" style="transform: rotate(0deg);"></i>
                    </a>
                    <div class="mobile-dropdown-menu" style="display: none;">

                    </div>
                </div>

                <div class="mobile-menu-item has-mobile-dropdown">
                    <a href="#" class="mobile-menu-link mobile-dropdown-toggle">
                        <i class="fa fa-users"></i>
                        <span>Manajemen User</span>
                        <i class="fas fa-chevron-down mobile-dropdown-arrow" style="transform: rotate(0deg);"></i>
                    </a>
                    <div class="mobile-dropdown-menu" style="display: none;">

                        <div class="mobile-menu-item mobile-sub-item has-mobile-dropdown">
                            <a href="#" class="mobile-menu-link mobile-dropdown-toggle">
                                <i class="fa fa-user-plus"></i>
                                <span>Sub Test</span>
                                <i class="fas fa-chevron-right mobile-dropdown-arrow" style="transform: rotate(0deg);"></i>
                            </a>
                            <div class="mobile-dropdown-menu mobile-submenu" style="display: none;">

                            </div>
                        </div>

                    </div>
                </div>
            </nav>
        </div>
    </div> -->


<!-- Menu manual web sudah ok -->

<!-- <-?php $pgname = $this->uri->segment(1); ?>

            <nav class="horizontal-nav">
                <ul class="nav-menu">


                    <li class="nav-item <-?= ($pgname == '' ? 'active' : '') ?>">
                        <a href="<-?= site_url(); ?>" class="nav-link <--?= ($pgname == '' ? 'active' : '') ?>" data-page="dashboard">
                            <i class="fa fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <-?php
                    $isMaster = in_array($pgname, ['mst_customer', 'mst_barang', 'mst_supplier', 'mst_satuan']);
                    ?>
                    <li class="nav-item has-dropdown <-?= ($isMaster ? 'open active' : '') ?>">
                        <a href="#" class="nav-link <-?= ($isMaster ? 'active' : '') ?>">
                            <i class="fa fa-wrench"></i>
                            <span>Master</span>
                            <i class="fa fa-chevron-down dropdown-arrow"></i>
                        </a>

                        <ul class="dropdown-menu">

                            <li class="dropdown-item <-?= ($pgname == 'mst_customer' ? 'active' : '') ?>">
                                <a href="<-?= site_url('mst_customer'); ?>"
                                    class="dropdown-link <-?= ($pgname == 'mst_customer' ? 'active' : '') ?>">
                                    <i class="fa fa-list"></i>
                                    <span>Customer</span>
                                </a>
                            </li>

                            <li class="dropdown-item <-?= ($pgname == 'mst_barang' ? 'active' : '') ?>">
                                <a href="<-?= site_url('mst_barang'); ?>"
                                    class="dropdown-link <-?= ($pgname == 'mst_barang' ? 'active' : '') ?>">
                                    <i class="fa fa-list"></i>
                                    <span>Barang</span>
                                </a>
                            </li>

                            <li class="dropdown-item <-?= ($pgname == 'mst_supplier' ? 'active' : '') ?>">
                                <a href="<-?= site_url('mst_supplier'); ?>"
                                    class="dropdown-link <-?= ($pgname == 'mst_supplier' ? 'active' : '') ?>">
                                    <i class="fa fa-list"></i>
                                    <span>Supplier</span>
                                </a>
                            </li>

                            <li class="dropdown-item <-?= ($pgname == 'mst_satuan' ? 'active' : '') ?>">
                                <a href="<-?= site_url('mst_satuan'); ?>"
                                    class="dropdown-link <-?= ($pgname == 'mst_satuan' ? 'active' : '') ?>">
                                    <i class="fa fa-list"></i>
                                    <span>Satuan</span>
                                </a>
                            </li>

                        </ul>
                    </li>


                    <-?php
                    $isUser = in_array($pgname, ['test1', 'test2', 'test3']);
                    $isUserSub = in_array($pgname, ['test2', 'test3']);
                    ?>
                    <li class="nav-item has-dropdown <-?= ($isUser ? 'open active' : '') ?>">
                        <a href="#" class="nav-link <-?= ($isUser ? 'active' : '') ?>">
                            <i class="fa fa-users"></i>
                            <span>Manajemen User</span>
                            <i class="fa fa-chevron-down dropdown-arrow"></i>
                        </a>

                        <ul class="dropdown-menu">

                            <li class="dropdown-item <-?= ($pgname == 'test1' ? 'active' : '') ?>">
                                <a href="<-?= site_url('test1'); ?>"
                                    class="dropdown-link <-?= ($pgname == 'test1' ? 'active' : '') ?>">
                                    <i class="fa fa-list"></i>
                                    <span>TEST1</span>
                                </a>
                            </li>

                            <li class="dropdown-item has-submenu <-?= ($isUserSub ? 'open active' : '') ?>">
                                <a href="#" class="dropdown-link <-?= ($isUserSub ? 'active' : '') ?>">
                                    <i class="fa fa-user-plus"></i>
                                    <span>Sub Test</span>
                                    <i class="fa fa-chevron-right submenu-arrow"></i>
                                </a>

                                <ul class="dropdown-menu submenu-level-2">

                                    <li class="dropdown-item <-?= ($pgname == 'test2' ? 'active' : '') ?>">
                                        <a href="<-?= site_url('test2'); ?>"
                                            class="dropdown-link <-?= ($pgname == 'test2' ? 'active' : '') ?>">
                                            <i class="fa fa-user-shield"></i>
                                            <span>Admin</span>
                                        </a>
                                    </li>

                                    <li class="dropdown-item <-?= ($pgname == 'test3' ? 'active' : '') ?>">
                                        <a href="<-?= site_url('test3'); ?>"
                                            class="dropdown-link <-?= ($pgname == 'test3' ? 'active' : '') ?>">
                                            <i class="fa fa-user"></i>
                                            <span>Member</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </li>

                </ul>
            </nav> -->


<!-- Menu manual mobile sudah ok -->

<!-- <div class="mobile-menu-overlay" id="mobileMenuOverlay">
        <div class="mobile-menu">
            <div class="mobile-menu-header">
                <a href="<-?= site_url() ?>" class="brand-link">
                    <i class="fa fa-store"></i>
                    <span>Dashboard</span>
                </a>
                <button class="mobile-menu-close" id="mobileMenuClose">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <nav class="mobile-nav">


                <div class="mobile-menu-item">
                    <a href="<-?= site_url() ?>"
                        class="mobile-menu-link <-?= ($pgname == "" || $pgname == "dashboard") ? "active" : "" ?>">
                        <i class="fa fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

    
                <div class="mobile-menu-item has-mobile-dropdown 
                <-?= in_array($pgname, ['mst_customer']) ? 'active open' : '' ?>">

                    <a href="#" class="mobile-menu-link mobile-dropdown-toggle">
                        <i class="fa fa-wrench"></i>
                        <span>Master</span>
                        <i class="fa fa-chevron-down mobile-dropdown-arrow"></i>
                    </a>

                    <div class="mobile-dropdown-menu"
                        style="<-?= in_array($pgname, ['mst_customer']) ? 'display:block' : '' ?>">

                        <div class="mobile-menu-item mobile-sub-item">
                            <a href="<-?= site_url('mst_customer'); ?>"
                                class="mobile-menu-link <-?= ($pgname == 'mst_customer') ? 'active' : '' ?>">
                                <i class="fa fa-list"></i>
                                <span>Master Customer</span>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="mobile-menu-item has-mobile-dropdown 
                <-?= in_array($pgname, ['user', 'role']) ? 'active open' : '' ?>">

                    <a href="#" class="mobile-menu-link mobile-dropdown-toggle">
                        <i class="fa fa-users"></i>
                        <span>Manajemen User</span>
                        <i class="fa fa-chevron-down mobile-dropdown-arrow"></i>
                    </a>

                    <div class="mobile-dropdown-menu"
                        style="<-?= in_array($pgname, ['user', 'role']) ? 'display:block' : '' ?>">

                        <div class="mobile-menu-item mobile-sub-item">
                            <a href="<-?= base_url('user') ?>"
                                class="mobile-menu-link <-?= ($pgname == 'user') ? 'active' : '' ?>">
                                <i class="fa fa-list"></i>
                                <span>Daftar User</span>
                            </a>
                        </div>
                        <div class="mobile-menu-item mobile-sub-item">
                            <a href="<-?= base_url('user/create/admin') ?>"
                                class="mobile-menu-link <-?= ($pgname == 'user' && $this->uri->segment(2) == 'create' && $this->uri->segment(3) == 'admin') ? 'active' : '' ?>">
                                <i class="fa fa-user-shield"></i>
                                <span>Tambah Admin</span>
                            </a>
                        </div>
                        <div class="mobile-menu-item mobile-sub-item">
                            <a href="<-?= base_url('user/create/member') ?>"
                                class="mobile-menu-link <-?= ($pgname == 'user' && $this->uri->segment(3) == 'member') ? 'active' : '' ?>">
                                <i class="fa fa-user"></i>
                                <span>Tambah Member</span>
                            </a>
                        </div>
                        <div class="mobile-menu-item mobile-sub-item">
                            <a href="<-?= base_url('role') ?>"
                                class="mobile-menu-link <-?= ($pgname == 'role') ? 'active' : '' ?>">
                                <i class="fa fa-user-tag"></i>
                                <span>Role & Permission</span>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="mobile-menu-item has-mobile-dropdown 
                <-?= in_array($pgname, ['laporan', 'keuangan']) ? 'active open' : '' ?>">

                    <a href="#" class="mobile-menu-link mobile-dropdown-toggle">
                        <i class="fa fa-chart-bar"></i>
                        <span>Laporan</span>
                        <i class="fa fa-chevron-down mobile-dropdown-arrow"></i>
                    </a>

                    <div class="mobile-dropdown-menu"
                        style="<-?= in_array($pgname, ['laporan', 'keuangan']) ? 'display:block' : '' ?>">

                        <div class="mobile-menu-item mobile-sub-item">
                            <a href="<-?= base_url('laporan/penjualan') ?>"
                                class="mobile-menu-link <-?= ($pgname == 'laporan') ? 'active' : '' ?>">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Laporan Penjualan</span>
                            </a>
                        </div>


                        <div class="mobile-menu-item mobile-sub-item has-mobile-dropdown 
                        <-?= ($pgname == 'keuangan') ? 'active open' : '' ?>">

                            <a href="#" class="mobile-menu-link mobile-dropdown-toggle">
                                <i class="fa fa-file-invoice"></i>
                                <span>Keuangan</span>
                                <i class="fa fa-chevron-right mobile-dropdown-arrow"></i>
                            </a>

                            <div class="mobile-dropdown-menu mobile-submenu"
                                style="<-?= ($pgname == 'keuangan') ? 'display:block' : '' ?>">

                                <div class="mobile-menu-item mobile-sub-item">
                                    <a href="<-?= base_url('keuangan/pemasukan') ?>"
                                        class="mobile-menu-link <-?= ($this->uri->segment(2) == 'pemasukan') ? 'active' : '' ?>">
                                        <i class="fa fa-arrow-up"></i>
                                        <span>Pemasukan</span>
                                    </a>
                                </div>

                                <div class="mobile-menu-item mobile-sub-item">
                                    <a href="<-?= base_url('keuangan/pengeluaran') ?>"
                                        class="mobile-menu-link <-?= ($this->uri->segment(2) == 'pengeluaran') ? 'active' : '' ?>">
                                        <i class="fa fa-arrow-down"></i>
                                        <span>Pengeluaran</span>
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

           
                <div class="mobile-menu-item">
                    <a href="<-?= base_url('pengaturan') ?>"
                        class="mobile-menu-link <-?= ($pgname == 'pengaturan') ? 'active' : '' ?>">
                        <i class="fa fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                </div>

            </nav>
        </div>
    </div> -->