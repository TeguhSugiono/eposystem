<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Dashboard Lengkap - Horizontal Menu</title>
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/'); ?>styles.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/fontawesome_600/css/'); ?>fontawesome.min.css">
</head>

<body>
    <div class="app-container">
        <!-- Top Navigation Bar -->
        <header class="top-nav">
            <div class="nav-brand">
                <a href="<?= site_url(); ?>" class="brand-link" data-page="dashboard">
                    <i class="fa fa-cube"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <?php $pgname = $this->uri->segment(1); ?>

            <nav class="horizontal-nav">
                <ul class="nav-menu">

                    <!-- Menu 1 Level -->
                    <li class="nav-item <?= ($pgname == '' ? 'active' : '') ?>">
                        <a href="<?= site_url(); ?>" class="nav-link <?= ($pgname == '' ? 'active' : '') ?>" data-page="dashboard">
                            <i class="fa fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Menu MASTER -->
                    <?php
                    $isMaster = in_array($pgname, ['mst_customer', 'mst_barang', 'mst_supplier', 'mst_satuan']);
                    ?>
                    <li class="nav-item has-dropdown <?= ($isMaster ? 'open active' : '') ?>">
                        <a href="#" class="nav-link <?= ($isMaster ? 'active' : '') ?>">
                            <i class="fa fa-wrench"></i>
                            <span>Master</span>
                            <i class="fa fa-chevron-down dropdown-arrow"></i>
                        </a>

                        <ul class="dropdown-menu">

                            <li class="dropdown-item <?= ($pgname == 'mst_customer' ? 'active' : '') ?>">
                                <a href="<?= site_url('mst_customer'); ?>"
                                    class="dropdown-link <?= ($pgname == 'mst_customer' ? 'active' : '') ?>">
                                    <i class="fa fa-list"></i>
                                    <span>Master Customer</span>
                                </a>
                            </li>

                            <li class="dropdown-item <?= ($pgname == 'mst_barang' ? 'active' : '') ?>">
                                <a href="<?= site_url('mst_barang'); ?>"
                                    class="dropdown-link <?= ($pgname == 'mst_barang' ? 'active' : '') ?>">
                                    <i class="fa fa-list"></i>
                                    <span>Master Barang</span>
                                </a>
                            </li>

                            <li class="dropdown-item <?= ($pgname == 'mst_supplier' ? 'active' : '') ?>">
                                <a href="<?= site_url('mst_supplier'); ?>"
                                    class="dropdown-link <?= ($pgname == 'mst_supplier' ? 'active' : '') ?>">
                                    <i class="fa fa-list"></i>
                                    <span>Master Supplier</span>
                                </a>
                            </li>

                            <li class="dropdown-item <?= ($pgname == 'mst_satuan' ? 'active' : '') ?>">
                                <a href="<?= site_url('mst_satuan'); ?>"
                                    class="dropdown-link <?= ($pgname == 'mst_satuan' ? 'active' : '') ?>">
                                    <i class="fa fa-list"></i>
                                    <span>Master Satuan</span>
                                </a>
                            </li>

                        </ul>
                    </li>


                    <!-- Menu 3 Level -->
                    <?php
                    $isUser = in_array($pgname, ['test1', 'test2', 'test3']);
                    $isUserSub = in_array($pgname, ['test2', 'test3']);
                    ?>
                    <li class="nav-item has-dropdown <?= ($isUser ? 'open active' : '') ?>">
                        <a href="#" class="nav-link <?= ($isUser ? 'active' : '') ?>">
                            <i class="fa fa-users"></i>
                            <span>Manajemen User</span>
                            <i class="fa fa-chevron-down dropdown-arrow"></i>
                        </a>

                        <ul class="dropdown-menu">

                            <li class="dropdown-item <?= ($pgname == 'test1' ? 'active' : '') ?>">
                                <a href="<?= site_url('test1'); ?>"
                                    class="dropdown-link <?= ($pgname == 'test1' ? 'active' : '') ?>">
                                    <i class="fa fa-list"></i>
                                    <span>TEST1</span>
                                </a>
                            </li>

                            <li class="dropdown-item has-submenu <?= ($isUserSub ? 'open active' : '') ?>">
                                <a href="#" class="dropdown-link <?= ($isUserSub ? 'active' : '') ?>">
                                    <i class="fa fa-user-plus"></i>
                                    <span>Sub Test</span>
                                    <i class="fa fa-chevron-right submenu-arrow"></i>
                                </a>

                                <ul class="dropdown-menu submenu-level-2">

                                    <li class="dropdown-item <?= ($pgname == 'test2' ? 'active' : '') ?>">
                                        <a href="<?= site_url('test2'); ?>"
                                            class="dropdown-link <?= ($pgname == 'test2' ? 'active' : '') ?>">
                                            <i class="fa fa-user-shield"></i>
                                            <span>Admin</span>
                                        </a>
                                    </li>

                                    <li class="dropdown-item <?= ($pgname == 'test3' ? 'active' : '') ?>">
                                        <a href="<?= site_url('test3'); ?>"
                                            class="dropdown-link <?= ($pgname == 'test3' ? 'active' : '') ?>">
                                            <i class="fa fa-user"></i>
                                            <span>Member</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </li>

                </ul>
            </nav>





            <!-- Action Buttons -->
            <div class="nav-actions">
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
                <?php $this->load->view($content);
                ?>
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
    <script src="<?php echo site_url('assets/' . $this->session->userdata('pathtemplate') . '/jquery-3.7.1.min.js'); ?>"></script>

    <script type="text/javascript">

    </script>




</body>

</html>