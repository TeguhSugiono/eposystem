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
		'mst_customer': 'Master Customer',
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
    
    // Since you're using PHP, just update the breadcrumb
    updateBreadcrumb(titles[page] || 'Dashboard');
    
    console.log('Page loaded:', page);
}

// Modal System
function initializeModals() {
    // Modal templates will be added as needed
}

function openModal(modalId) {
    console.log('Opening modal:', modalId);
    // Modal functionality can be added here
}

function closeModal(modalId) {
    console.log('Closing modal:', modalId);
    // Modal functionality can be added here
}

// Tab System
function initializeTabs() {
    // Tab functionality can be added here
}

// Custom Select System
function initializeCustomSelects() {
    // Custom select functionality can be added here
}

// DataTable Functions
function initializeDatatable() {
    // DataTable functionality can be added here
}

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

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // ESC to close mobile menu
    if (e.key === 'Escape') {
        closeMobileMenu();
    }
});