// Global Variables
let currentPage = 'dashboard';
let modalStack = [];
let datatableData = [];
let currentDatatablePage = 1;
let datatableSearchTerm = '';

// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

// Initialize Application
function initializeApp() {
    initializeMenu();
    initializeMobileMenu();
    initializeBrandLink();
    loadPage('dashboard');
    initializeModals();
    initializeTabs();
    initializeCustomSelects();
    initializeDatatable();
}

// Brand Link System
function initializeBrandLink() {
    const brandLinks = document.querySelectorAll('.brand-link[data-page="dashboard"]');
    
    brandLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Load dashboard page
            loadPage('dashboard');
            
            // Update active states
            document.querySelectorAll('.nav-link, .dropdown-link').forEach(navLink => {
                navLink.classList.remove('active');
            });
            
            // Update breadcrumb
            updateBreadcrumb('Dashboard');
            
            // Close mobile menu if open
            closeMobileMenu();
            
            console.log('Navigated to dashboard via brand link');
        });
    });
}

// Horizontal Menu System
function initializeMenu() {
    const menuItems = document.querySelectorAll('.nav-link[data-page]');
    const dropdownTriggers = document.querySelectorAll('.nav-item.has-dropdown');
    
    // Handle page navigation
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.getAttribute('data-page');
            loadPage(page);
            
            // Update active states
            document.querySelectorAll('.nav-link, .dropdown-link').forEach(link => {
                link.classList.remove('active');
            });
            this.classList.add('active');
            
            // Update breadcrumb
            updateBreadcrumb(this.textContent.trim());
        });
    });
    
    // Handle dropdown menus
    dropdownTriggers.forEach(trigger => {
        const dropdown = trigger.querySelector('.dropdown-menu');
        
        // Add hover effect for desktop
        trigger.addEventListener('mouseenter', function() {
            if (window.innerWidth > 768) {
                // Dropdown already shows on hover via CSS
            }
        });
        
        // Handle mobile touch
        trigger.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                e.stopPropagation();
                
                // Close other dropdowns
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    if (menu !== dropdown) {
                        menu.style.display = 'none';
                    }
                });
                
                // Toggle current dropdown
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            }
        });
    });
    
    // Handle dropdown links
    const dropdownLinks = document.querySelectorAll('.dropdown-link[data-page]');
    dropdownLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const page = this.getAttribute('data-page');
            loadPage(page);
            
            // Update active states
            document.querySelectorAll('.nav-link, .dropdown-link').forEach(l => {
                l.classList.remove('active');
            });
            this.classList.add('active');
            
            // Find and activate parent nav item
            const parentNavItem = this.closest('.nav-item');
            if (parentNavItem) {
                const parentNavLink = parentNavItem.querySelector('.nav-link');
                if (parentNavLink) {
                    parentNavLink.classList.add('active');
                }
            }
            
            // Update breadcrumb with hierarchy
            const parentText = parentNavItem.querySelector('.nav-link span').textContent;
            const currentText = this.textContent.trim();
            updateBreadcrumb(`${parentText} > ${currentText}`);
            
            // Close mobile menu
            closeMobileMenu();
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-item')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (window.innerWidth <= 768) {
                    menu.style.display = 'none';
                }
            });
        }
    });
}

// Mobile Menu System
function initializeMobileMenu() {
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const mobileClose = document.getElementById('mobileMenuClose');
    const mobileOverlay = document.getElementById('mobileMenuOverlay');
    
    // Clone menu items to mobile menu
    const mobileNav = document.querySelector('.mobile-nav');
    const originalMenu = document.querySelector('.nav-menu');
    
    if (mobileNav && originalMenu) {
        // Create mobile menu HTML with proper structure
        let mobileMenuHTML = '';
        const navItems = originalMenu.querySelectorAll('.nav-item');
        
        navItems.forEach(item => {
            const navLink = item.querySelector('.nav-link');
            const dropdown = item.querySelector('.dropdown-menu');
            
            if (navLink) {
                const hasDataPage = navLink.hasAttribute('data-page');
                const hasDropdown = dropdown;
                
                if (hasDataPage && !hasDropdown) {
                    // Simple menu item
                    mobileMenuHTML += `
                        <div class="mobile-menu-item">
                            <a href="#" class="mobile-menu-link" data-page="${navLink.getAttribute('data-page')}">
                                <i class="${navLink.querySelector('i').className}"></i>
                                <span>${navLink.querySelector('span').textContent}</span>
                            </a>
                        </div>
                    `;
                } else if (hasDropdown) {
                    // Menu with dropdown
                    mobileMenuHTML += `
                        <div class="mobile-menu-item has-mobile-dropdown">
                            <a href="#" class="mobile-menu-link mobile-dropdown-toggle">
                                <i class="${navLink.querySelector('i').className}"></i>
                                <span>${navLink.querySelector('span').textContent}</span>
                                <i class="fas fa-chevron-down mobile-dropdown-arrow"></i>
                            </a>
                            <div class="mobile-dropdown-menu">
                    `;
                    
                    // Add dropdown items
                    const dropdownItems = dropdown.querySelectorAll('.dropdown-item');
                    dropdownItems.forEach(dropdownItem => {
                        const dropdownLink = dropdownItem.querySelector('.dropdown-link');
                        const submenu = dropdownItem.querySelector('.submenu-level-2');
                        
                        if (dropdownLink) {
                            const hasDataPage = dropdownLink.hasAttribute('data-page');
                            const hasSubmenu = submenu;
                            
                            if (hasDataPage && !hasSubmenu) {
                                // Simple dropdown item
                                mobileMenuHTML += `
                                    <div class="mobile-menu-item mobile-sub-item">
                                        <a href="#" class="mobile-menu-link" data-page="${dropdownLink.getAttribute('data-page')}">
                                            <i class="${dropdownLink.querySelector('i').className}"></i>
                                            <span>${dropdownLink.textContent.trim()}</span>
                                        </a>
                                    </div>
                                `;
                            } else if (hasSubmenu) {
                                // Dropdown item with submenu
                                mobileMenuHTML += `
                                    <div class="mobile-menu-item mobile-sub-item has-mobile-dropdown">
                                        <a href="#" class="mobile-menu-link mobile-dropdown-toggle">
                                            <i class="${dropdownLink.querySelector('i').className}"></i>
                                            <span>${dropdownLink.textContent.trim()}</span>
                                            <i class="fas fa-chevron-right mobile-dropdown-arrow"></i>
                                        </a>
                                        <div class="mobile-dropdown-menu mobile-submenu">
                                `;
                                
                                // Add submenu items
                                const submenuItems = submenu.querySelectorAll('.dropdown-item');
                                submenuItems.forEach(submenuItem => {
                                    const submenuLink = submenuItem.querySelector('.dropdown-link');
                                    if (submenuLink && submenuLink.hasAttribute('data-page')) {
                                        mobileMenuHTML += `
                                            <div class="mobile-menu-item mobile-sub-item">
                                                <a href="#" class="mobile-menu-link" data-page="${submenuLink.getAttribute('data-page')}">
                                                    <i class="${submenuLink.querySelector('i').className}"></i>
                                                    <span>${submenuLink.textContent.trim()}</span>
                                                </a>
                                            </div>
                                        `;
                                    }
                                });
                                
                                mobileMenuHTML += `
                                        </div>
                                    </div>
                                `;
                            }
                        }
                    });
                    
                    mobileMenuHTML += `
                            </div>
                        </div>
                    `;
                }
            }
        });
        
        mobileNav.innerHTML = mobileMenuHTML;
        
        // Add click handlers to mobile menu items
        const mobileLinks = mobileNav.querySelectorAll('.mobile-menu-link');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const hasDataPage = this.hasAttribute('data-page');
                const isDropdownToggle = this.classList.contains('mobile-dropdown-toggle');
                
                if (hasDataPage && !isDropdownToggle) {
                    e.preventDefault();
                    const page = this.getAttribute('data-page');
                    loadPage(page);
                    closeMobileMenu();
                } else if (isDropdownToggle) {
                    e.preventDefault();
                    const parentItem = this.parentElement;
                    const dropdown = parentItem.querySelector('.mobile-dropdown-menu');
                    
                    if (dropdown) {
                        // Toggle current dropdown
                        parentItem.classList.toggle('open');
                        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                        
                        // Rotate arrow
                        const arrow = this.querySelector('.mobile-dropdown-arrow');
                        if (arrow) {
                            arrow.style.transform = parentItem.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0)';
                        }
                    }
                }
            });
        });
    }
    
    // Mobile menu toggle
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const isActive = mobileOverlay.classList.contains('active');
            console.log('Hamburger clicked, active:', isActive); // Debug log
            if (isActive) {
                closeMobileMenu();
            } else {
                mobileOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    }
    
    if (mobileClose) {
        mobileClose.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Close button clicked'); // Debug log
            closeMobileMenu();
        });
    }
    
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', function(e) {
            if (e.target === mobileOverlay) {
                console.log('Overlay clicked'); // Debug log
                closeMobileMenu();
            }
        });
    }
}

function closeMobileMenu() {
    const mobileOverlay = document.getElementById('mobileMenuOverlay');
    if (mobileOverlay) {
        mobileOverlay.classList.remove('active');
        document.body.style.overflow = '';
        
        // Close all dropdowns
        const openDropdowns = mobileOverlay.querySelectorAll('.mobile-dropdown-menu');
        openDropdowns.forEach(dropdown => {
            dropdown.style.display = 'none';
        });
        
        // Reset arrow rotations
        const arrows = mobileOverlay.querySelectorAll('.mobile-dropdown-arrow');
        arrows.forEach(arrow => {
            arrow.style.transform = 'rotate(0)';
        });
        
        // Remove open classes
        const openItems = mobileOverlay.querySelectorAll('.mobile-menu-item.open');
        openItems.forEach(item => {
            item.classList.remove('open');
        });
        
        console.log('Mobile menu closed'); // Debug log
    }
}

// Breadcrumb Update
function updateBreadcrumb(path) {
    const breadcrumbPath = document.getElementById('breadcrumbPath');
    if (breadcrumbPath) {
        breadcrumbPath.textContent = path || 'Dashboard';
    }
}

// Page Loading System
function loadPage(page) {
    currentPage = page;
    const contentArea = document.getElementById('contentArea');
    const pageTitle = document.getElementById('pageTitle');
    
    // Update page title
    const titles = {
        'dashboard': 'Dashboard',
        'user-list': 'Daftar User',
        'add-admin': 'Tambah Admin',
        'add-member': 'Tambah Member',
        'user-roles': 'Role & Permission',
        'sales-report': 'Laporan Penjualan',
        'income': 'Pemasukan',
        'expense': 'Pengeluaran',
        'settings': 'Pengaturan'
    };
    
    pageTitle.textContent = titles[page] || 'Dashboard';
    
    // Load page content
    switch(page) {
        case 'dashboard':
            contentArea.innerHTML = getDashboardContent();
            break;
        case 'user-list':
            contentArea.innerHTML = getUserListContent();
            break;
        case 'add-admin':
        case 'add-member':
            contentArea.innerHTML = getAddUserContent(page);
            break;
        case 'user-roles':
            contentArea.innerHTML = getUserRolesContent();
            break;
        case 'sales-report':
        case 'income':
        case 'expense':
            contentArea.innerHTML = getReportContent(page);
            break;
        case 'settings':
            contentArea.innerHTML = getSettingsContent();
            break;
        default:
            contentArea.innerHTML = getDashboardContent();
    }
    
    // Reinitialize components for new content
    initializeTabs();
    initializeCustomSelects();
    initializeDatatable();
}

// Page Content Templates
function getDashboardContent() {
    return `
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3><i class="fas fa-users text-primary"></i> 1,234</h3>
                        <p>Total Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3><i class="fas fa-shopping-cart text-success"></i> 567</h3>
                        <p>Total Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3><i class="fas fa-dollar-sign text-warning"></i> $12,345</h3>
                        <p>Total Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3><i class="fas fa-chart-line text-info"></i> 89%</h3>
                        <p>Growth Rate</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Recent Activities</h5>
                    </div>
                    <div class="card-body">
                        ${getDatatableHTML('activities')}
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-primary mb-2" style="width: 100%;" onclick="openModal('modal1')">
                            <i class="fas fa-plus"></i> Add New User
                        </button>
                        <button class="btn btn-secondary mb-2" style="width: 100%;" onclick="openModal('modalNested')">
                            <i class="fas fa-file-alt"></i> Generate Report
                        </button>
                        <button class="btn btn-info" style="width: 100%;">
                            <i class="fas fa-cog"></i> Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function getUserListContent() {
    return `
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Daftar User</h5>
                <button class="btn btn-primary" onclick="openModal('modal1')">
                    <i class="fas fa-plus"></i> Tambah User
                </button>
            </div>
            <div class="card-body">
                ${getDatatableHTML('users')}
            </div>
        </div>
    `;
}

function getAddUserContent(page) {
    const userType = page === 'add-admin' ? 'Admin' : 'Member';
    return `
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tambah ${userType}</h5>
            </div>
            <div class="card-body">
                <form id="addUserForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="fullname" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="birthdate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Departemen</label>
                                <div class="custom-select" data-name="department">
                                    <div class="custom-select-trigger">
                                        <span>Pilih Departemen</span>
                                    </div>
                                    <div class="custom-options">
                                        <div class="custom-option" data-value="it">IT</div>
                                        <div class="custom-option" data-value="hr">HR</div>
                                        <div class="custom-option" data-value="finance">Finance</div>
                                        <div class="custom-option" data-value="marketing">Marketing</div>
                                        <div class="custom-option" data-value="operations">Operations</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Permissions</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="read" name="permissions" value="read">
                                <label for="read">Read Access</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="write" name="permissions" value="write">
                                <label for="write">Write Access</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="delete" name="permissions" value="delete">
                                <label for="delete">Delete Access</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="admin" name="permissions" value="admin">
                                <label for="admin">Admin Access</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="loadPage('user-list')">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
}

function getUserRolesContent() {
    return `
        ${getTabHTML('roles')}
    `;
}

function getReportContent(page) {
    return `
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Laporan ${page.charAt(0).toUpperCase() + page.slice(1)}</h5>
                <div class="d-flex gap-2">
                    <input type="date" class="form-control" style="width: auto;">
                    <input type="date" class="form-control" style="width: auto;">
                    <button class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
            <div class="card-body">
                ${getDatatableHTML(page)}
            </div>
        </div>
    `;
}

function getSettingsContent() {
    return `
        ${getTabHTML('settings')}
    `;
}

// Tab System
function getTabHTML(type) {
    let tabsHTML = '';
    let contentHTML = '';
    
    if (type === 'roles') {
        tabsHTML = `
            <button class="tab-button active" data-tab="roles-list">Daftar Role</button>
            <button class="tab-button" data-tab="permissions">Permissions</button>
            <button class="tab-button" data-tab="assign">Assign Role</button>
        `;
        contentHTML = `
            <div class="tab-pane active" id="roles-list">
                ${getDatatableHTML('roles')}
            </div>
            <div class="tab-pane" id="permissions">
                <div class="form-group">
                    <label class="form-label">Module Permissions</label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="user_mgmt" name="modules" value="user_mgmt">
                            <label for="user_mgmt">User Management</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="report_mgmt" name="modules" value="report_mgmt">
                            <label for="report_mgmt">Report Management</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="settings_mgmt" name="modules" value="settings_mgmt">
                            <label for="settings_mgmt">Settings Management</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="assign">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Select User</label>
                                <div class="custom-select" data-name="user">
                                    <div class="custom-select-trigger">
                                        <span>Pilih User</span>
                                    </div>
                                    <div class="custom-options">
                                        <div class="custom-option" data-value="1">John Doe</div>
                                        <div class="custom-option" data-value="2">Jane Smith</div>
                                        <div class="custom-option" data-value="3">Bob Johnson</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Select Role</label>
                                <div class="custom-select" data-name="role">
                                    <div class="custom-select-trigger">
                                        <span>Pilih Role</span>
                                    </div>
                                    <div class="custom-options">
                                        <div class="custom-option" data-value="admin">Admin</div>
                                        <div class="custom-option" data-value="manager">Manager</div>
                                        <div class="custom-option" data-value="user">User</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Assign Role</button>
                </form>
            </div>
        `;
    } else if (type === 'settings') {
        tabsHTML = `
            <button class="tab-button active" data-tab="general">General</button>
            <button class="tab-button" data-tab="security">Security</button>
            <button class="tab-button" data-tab="notifications">Notifications</button>
        `;
        contentHTML = `
            <div class="tab-pane active" id="general">
                <form>
                    <div class="form-group">
                        <label class="form-label">Application Name</label>
                        <input type="text" class="form-control" value="Dashboard System">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Default Language</label>
                        <div class="custom-select" data-name="language">
                            <div class="custom-select-trigger">
                                <span>Indonesian</span>
                            </div>
                            <div class="custom-options">
                                <div class="custom-option" data-value="id">Indonesian</div>
                                <div class="custom-option" data-value="en">English</div>
                                <div class="custom-option" data-value="zh">Chinese</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
            <div class="tab-pane" id="security">
                <form>
                    <div class="form-group">
                        <label class="form-label">Session Timeout (minutes)</label>
                        <input type="number" class="form-control" value="30">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password Policy</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="uppercase" checked>
                                <label for="uppercase">Require Uppercase</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="numbers" checked>
                                <label for="numbers">Require Numbers</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="symbols" checked>
                                <label for="symbols">Require Symbols</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Security</button>
                </form>
            </div>
            <div class="tab-pane" id="notifications">
                <form>
                    <div class="form-group">
                        <label class="form-label">Email Notifications</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="email_login" checked>
                                <label for="email_login">Login Alerts</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="email_updates" checked>
                                <label for="email_updates">System Updates</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Preferences</button>
                </form>
            </div>
        `;
    }
    
    return `
        <div class="tab-container">
            <div class="tab-header">
                ${tabsHTML}
            </div>
            <div class="tab-content">
                ${contentHTML}
            </div>
        </div>
    `;
}

// DataTable System
function getDatatableHTML(type) {
    const headers = getDatatableHeaders(type);
    const data = generateDatatableData(type);
    
    return `
        <div class="datatable-container">
            <div class="datatable-header">
                <div class="datatable-search">
                    <i class="fas fa-search"></i>
                    <input type="text" class="search-input" placeholder="Search..." id="datatableSearch">
                </div>
                <div>
                    <button class="btn btn-secondary" onclick="exportData('${type}')">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>
            <div class="datatable-wrapper">
                <table class="datatable-table">
                    <thead>
                        <tr>
                            ${headers.map(header => `<th>${header}</th>`).join('')}
                        </tr>
                    </thead>
                    <tbody id="datatableBody">
                        ${data.map(row => `
                            <tr>
                                ${row.map(cell => `<td>${cell}</td>`).join('')}
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
            <div class="datatable-footer">
                <div class="datatable-info">
                    Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalRecords">${data.length}</span> entries
                </div>
                <div class="pagination" id="pagination">
                    <button onclick="changePage('prev')" id="prevBtn"><i class="fas fa-chevron-left"></i></button>
                    <button class="active" onclick="goToPage(1)">1</button>
                    <button onclick="goToPage(2)">2</button>
                    <button onclick="goToPage(3)">3</button>
                    <button onclick="changePage('next')" id="nextBtn"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    `;
}

function getDatatableHeaders(type) {
    const headers = {
        'users': ['ID', 'Name', 'Email', 'Role', 'Status', 'Actions'],
        'activities': ['Time', 'User', 'Activity', 'IP Address', 'Status'],
        'roles': ['ID', 'Role Name', 'Description', 'Users Count', 'Actions'],
        'sales-report': ['Date', 'Order ID', 'Customer', 'Amount', 'Status'],
        'income': ['Date', 'Description', 'Category', 'Amount', 'Method'],
        'expense': ['Date', 'Description', 'Category', 'Amount', 'Approved By']
    };
    
    return headers[type] || ['ID', 'Name', 'Description', 'Status'];
}

function generateDatatableData(type) {
    const data = {
        'users': [
            [1, 'John Doe', 'john@example.com', 'Admin', '<span class="badge badge-success">Active</span>', '<button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>'],
            [2, 'Jane Smith', 'jane@example.com', 'Manager', '<span class="badge badge-success">Active</span>', '<button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>'],
            [3, 'Bob Johnson', 'bob@example.com', 'User', '<span class="badge badge-warning">Inactive</span>', '<button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>']
        ],
        'activities': [
            ['2024-01-15 09:30', 'John Doe', 'Login to system', '192.168.1.1', '<i class="fas fa-check text-success"></i>'],
            ['2024-01-15 09:25', 'Jane Smith', 'Updated profile', '192.168.1.2', '<i class="fas fa-check text-success"></i>'],
            ['2024-01-15 09:20', 'Bob Johnson', 'Failed login attempt', '192.168.1.3', '<i class="fas fa-times text-danger"></i>']
        ],
        'roles': [
            [1, 'Super Admin', 'Full system access', 2, '<button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>'],
            [2, 'Manager', 'Department management', 5, '<button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>'],
            [3, 'User', 'Basic access', 25, '<button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>']
        ]
    };
    
    return data[type] || [[1, 'Sample Data', 'Description', 'Active']];
}

// Modal System
function initializeModals() {
    // Create modal templates
    const modalTemplates = `
        <div class="modal-overlay" id="modal1">
            <div class="modal">
                <div class="modal-header">
                    <h3 class="modal-title">Basic Modal</h3>
                    <button class="modal-close" onclick="closeModal('modal1')">×</button>
                </div>
                <div class="modal-body">
                    <p>Ini adalah contoh modal dasar. Anda bisa menambahkan konten apapun di sini.</p>
                    <div class="form-group">
                        <label class="form-label">Contoh Input</label>
                        <input type="text" class="form-control" placeholder="Ketik sesuatu...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contoh Select</label>
                        <div class="custom-select" data-name="modalSelect">
                            <div class="custom-select-trigger">
                                <span>Pilih Opsi</span>
                            </div>
                            <div class="custom-options">
                                <div class="custom-option" data-value="option1">Opsi 1</div>
                                <div class="custom-option" data-value="option2">Opsi 2</div>
                                <div class="custom-option" data-value="option3">Opsi 3</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" onclick="closeModal('modal1')">Tutup</button>
                    <button class="btn btn-primary" onclick="openNestedModal()">Buka Nested Modal</button>
                </div>
            </div>
        </div>
        
        <div class="modal-overlay" id="modalNested">
            <div class="modal nested">
                <div class="modal-header">
                    <h3 class="modal-title">Nested Modal</h3>
                    <button class="modal-close" onclick="closeModal('modalNested')">×</button>
                </div>
                <div class="modal-body">
                    <p>Ini adalah nested modal yang dibuka dari modal lain.</p>
                    <div class="form-group">
                        <label class="form-label">Nested Input</label>
                        <input type="text" class="form-control" placeholder="Input di nested modal...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Checkbox di Nested Modal</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="nested1">
                                <label for="nested1">Option 1</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="nested2">
                                <label for="nested2">Option 2</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" onclick="closeModal('modalNested')">Tutup</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('modalContainer').innerHTML = modalTemplates;
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        modalStack.push(modalId);
        
        // Reinitialize custom selects in modal
        initializeCustomSelects();
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        modalStack = modalStack.filter(id => id !== modalId);
    }
}

function openNestedModal() {
    openModal('modalNested');
}

// Close modal on overlay click
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        const modalId = e.target.id;
        closeModal(modalId);
    }
});

// Tab System
function initializeTabs() {
    const tabButtons = document.querySelectorAll('.tab-button');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            const container = this.closest('.tab-container');
            
            // Remove active class from all buttons and panes in this container
            container.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            container.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
            
            // Add active class to clicked button and corresponding pane
            this.classList.add('active');
            const pane = document.getElementById(tabId);
            if (pane) {
                pane.classList.add('active');
            }
        });
    });
}

// Custom Select System
function initializeCustomSelects() {
    const customSelects = document.querySelectorAll('.custom-select');
    
    customSelects.forEach(select => {
        const trigger = select.querySelector('.custom-select-trigger');
        const options = select.querySelectorAll('.custom-option');
        
        if (!trigger || !options.length) return;
        
        // Toggle dropdown
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Close other selects
            document.querySelectorAll('.custom-select.open').forEach(openSelect => {
                if (openSelect !== select) {
                    openSelect.classList.remove('open');
                }
            });
            
            select.classList.toggle('open');
        });
        
        // Select option
        options.forEach(option => {
            option.addEventListener('click', function(e) {
                e.stopPropagation();
                
                // Update selected state
                options.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                
                // Update trigger text
                trigger.querySelector('span').textContent = this.textContent;
                
                // Close dropdown
                select.classList.remove('open');
                
                // Store value
                const value = this.getAttribute('data-value');
                select.setAttribute('data-value', value);
            });
        });
    });
    
    // Close custom selects when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.custom-select.open').forEach(openSelect => {
            openSelect.classList.remove('open');
        });
    });
}

// DataTable Functions
function initializeDatatable() {
    const searchInput = document.getElementById('datatableSearch');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            datatableSearchTerm = this.value.toLowerCase();
            filterDatatable();
        });
    }
}

function filterDatatable() {
    const tbody = document.getElementById('datatableBody');
    if (!tbody) return;
    
    const rows = tbody.querySelectorAll('tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(datatableSearchTerm) ? '' : 'none';
    });
    
    updateDatatableInfo();
}

function changePage(direction) {
    if (direction === 'prev' && currentDatatablePage > 1) {
        currentDatatablePage--;
    } else if (direction === 'next') {
        currentDatatablePage++;
    }
    
    updatePagination();
}

function goToPage(page) {
    currentDatatablePage = page;
    updatePagination();
}

function updatePagination() {
    const buttons = document.querySelectorAll('.pagination button');
    buttons.forEach((btn, index) => {
        if (index > 0 && index < buttons.length - 1) {
            btn.classList.toggle('active', index === currentDatatablePage);
        }
    });
    
    // Update prev/next buttons
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    if (prevBtn) prevBtn.disabled = currentDatatablePage === 1;
    if (nextBtn) nextBtn.disabled = currentDatatablePage === 3;
    
    updateDatatableInfo();
}

function updateDatatableInfo() {
    const showingStart = document.getElementById('showingStart');
    const showingEnd = document.getElementById('showingEnd');
    
    if (showingStart) showingStart.textContent = (currentDatatablePage - 1) * 10 + 1;
    if (showingEnd) showingEnd.textContent = currentDatatablePage * 10;
}

function exportData(type) {
    // Placeholder for export functionality
    alert(`Exporting ${type} data...`);
}

// Form handling
document.addEventListener('submit', function(e) {
    if (e.target.id === 'addUserForm') {
        e.preventDefault();
        
        // Collect form data
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);
        
        // Get custom select values
        const customSelects = e.target.querySelectorAll('.custom-select');
        customSelects.forEach(select => {
            const name = select.getAttribute('data-name');
            const value = select.getAttribute('data-value');
            if (name && value) {
                data[name] = value;
            }
        });
        
        // Get checkbox values
        const checkboxes = e.target.querySelectorAll('input[type="checkbox"]:checked');
        data.permissions = Array.from(checkboxes).map(cb => cb.value);
        
        console.log('Form data:', data);
        alert('User berhasil disimpan!');
        
        // Redirect to user list
        loadPage('user-list');
    }
});

// Utility Functions
function formatDate(date) {
    return new Date(date).toLocaleDateString('id-ID');
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(amount);
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // ESC to close modal
    if (e.key === 'Escape' && modalStack.length > 0) {
        const topModal = modalStack[modalStack.length - 1];
        closeModal(topModal);
    }
    
    // ESC to close mobile menu
    if (e.key === 'Escape') {
        closeMobileMenu();
    }
    
    // Ctrl+K for search
    if (e.ctrlKey && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.getElementById('datatableSearch');
        if (searchInput) {
            searchInput.focus();
        }
    }
});

// Responsive utilities - Handle device type changes
window.addEventListener('resize', function() {
    // Check if transitioning from mobile to desktop or vice versa
    const isMobile = window.innerWidth <= 768;
    const wasMobile = window.previousWidth <= 768;
    
    if (isMobile !== wasMobile) {
        console.log('Device type changed, reloading page...');
        // Reload page to reinitialize all event listeners properly
        setTimeout(() => {
            location.reload();
        }, 100);
    }
    
    // Store current width for next comparison
    window.previousWidth = window.innerWidth;
});

// Initialize previous width on page load
window.previousWidth = window.innerWidth;