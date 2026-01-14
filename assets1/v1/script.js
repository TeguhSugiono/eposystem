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
    // initializeMobileMenu();
    // initializeBrandLink();
    // loadPage('dashboard');
    // initializeModals();
    // initializeTabs();
    // initializeCustomSelects();
    // initializeDatatable();
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
            //loadPage(page);
            
            // Update active states
            document.querySelectorAll('.nav-link, .dropdown-link').forEach(link => {
                link.classList.remove('active');
            });
            this.classList.add('active');
            
            // Update breadcrumb
            //updateBreadcrumb(this.textContent.trim());
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
            //loadPage(page);
            
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
            //updateBreadcrumb(`${parentText} > ${currentText}`);
            
            // Close mobile menu
            //closeMobileMenu();
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
