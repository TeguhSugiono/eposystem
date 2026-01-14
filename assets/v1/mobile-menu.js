// //INI SUDAH OKE
// document.addEventListener('DOMContentLoaded', function () {
//     const overlay   = document.getElementById('mobileMenuOverlay');
//     const toggleBtn = document.getElementById('mobileMenuToggle');
//     const closeBtn  = document.getElementById('mobileMenuClose');

//     // Tutup menu
//     // function closeMobileMenu() {
//     //     overlay.classList.remove('active');
//     //     document.body.style.overflow = '';
        
//     //     // Reset semua dropdown
//     //     document.querySelectorAll('.has-mobile-dropdown.open').forEach(item => {
//     //         item.classList.remove('open');
//     //         item.querySelector('.mobile-dropdown-menu').style.display = 'none';
//     //         const arrow = item.querySelector('.mobile-dropdown-arrow');
//     //         if (arrow.classList.contains('fa-chevron-down')) {
//     //             arrow.style.transform = 'rotate(0deg)';
//     //         } else if (arrow.classList.contains('fa-chevron-right')) {
//     //             arrow.style.transform = 'rotate(0deg)';
//     //         }
//     //     });
//     // }

//     // Buka/Tutup menu
//     // toggleBtn?.addEventListener('click', (e) => {
//     //     e.preventDefault();
//     //     if (overlay.classList.contains('active')) {
//     //         closeMobileMenu();
//     //         //console.log('closeMobileMenu');
//     //     } else {
//     //         overlay.classList.add('active');
//     //         document.body.style.overflow = 'hidden';
//     //         //console.log('AddMenu');
//     //     }
//     // });

//     function closeMobileMenu() {
//         overlay.classList.remove('active');
//         document.body.style.overflow = '';
//         // HAPUS SEMUA BARIS INI:
//         // document.querySelectorAll('.has-mobile-dropdown').forEach(...)
//         // JANGAN RESET APA-APA! Biarkan dropdown tetap ingat state!
//     }

//     toggleBtn?.addEventListener('click', (e) => {
//         e.preventDefault();
//         e.stopPropagation();

//         if (overlay.classList.contains('active')) {
//             closeMobileMenu();
//         } else {
//             overlay.classList.add('active');
//             document.body.style.overflow = 'hidden';
//             // Otomatis buka dropdown aktif
//             autoOpenActiveMenu();
//         }
//     });

//     function autoOpenActiveMenu() {
//         const currentPath = window.location.pathname;

//         document.querySelectorAll('.mobile-menu-item a[href]').forEach(link => {
//             const href = link.getAttribute('href');
//             if (href && (currentPath.includes(href) || currentPath.startsWith(href + '/'))) {
//                 link.classList.add('active');

//                 let parent = link.closest('.has-mobile-dropdown');
//                 while (parent) {
//                     parent.classList.add('open');
                    
//                     const submenu = parent.querySelector('.mobile-dropdown-menu');
//                     if (submenu) {
//                         submenu.classList.add('show');
//                         // PAKSA DISPLAY BIAR LANGSUNG KELIATAN!
//                         submenu.style.display = 'block';
//                         void submenu.offsetWidth; // trigger reflow
//                     }

//                     const arrow = parent.querySelector('.mobile-dropdown-arrow');
//                     if (arrow) {
//                         arrow.style.transform = arrow.classList.contains('fa-chevron-down')
//                             ? 'rotate(180deg)'
//                             : 'rotate(90deg)';
//                     }

//                     parent = parent.parentElement?.closest('.has-mobile-dropdown');
//                 }
//             }
//         });
//     }

//     closeBtn?.addEventListener('click', closeMobileMenu);
//     overlay?.addEventListener('click', (e) => {
//         if (e.target === overlay) closeMobileMenu();
//     });

//     // Dropdown toggle (level 1 & 2)
//     document.querySelectorAll('.mobile-dropdown-toggle').forEach(toggle => {
//         toggle.addEventListener('click', function (e) {
//             e.preventDefault();
//             const parent   = this.closest('.has-mobile-dropdown');
//             const dropdown = parent.querySelector('.mobile-dropdown-menu');
//             const arrow    = this.querySelector('.mobile-dropdown-arrow');
//             const isOpen   = parent.classList.contains('open');

//             // Tutup semua dropdown di level yang sama (biar rapi)
//             const siblings = parent.parentElement.querySelectorAll('.has-mobile-dropdown');
//             siblings.forEach(sib => {
//                 if (sib !== parent) {
//                     sib.classList.remove('open');
//                     sib.querySelector('.mobile-dropdown-menu').style.display = 'none';
//                     const sibArrow = sib.querySelector('.mobile-dropdown-arrow');
//                     if (sibArrow) sibArrow.style.transform = 'rotate(0deg)';
//                 }
//             });

//             // Toggle current
//             if (isOpen) {
//                 parent.classList.remove('open');
//                 dropdown.style.display = 'none';
//                 arrow.style.transform = 'rotate(0deg)';
//             } else {
//                 parent.classList.add('open');
//                 dropdown.style.display = 'block';
//                 if (arrow.classList.contains('fa-chevron-down')) {
//                     arrow.style.transform = 'rotate(180deg)';
//                 } else {
//                     arrow.style.transform = 'rotate(90deg)';
//                 }
//             }
//         });
//     });
// });
// //END INI SUDAH OKE

document.addEventListener('DOMContentLoaded', function () {
    const overlay   = document.getElementById('mobileMenuOverlay');
    const toggleBtn = document.getElementById('mobileMenuToggle');
    const closeBtn  = document.getElementById('mobileMenuClose');

    // Tutup menu — TANPA RESET DROPDOWN!
    function closeMobileMenu() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Buka menu + otomatis buka dropdown aktif
    function openMobileMenu() {
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        autoOpenActiveMenu();
    }

    // Toggle hamburger
    toggleBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        if (overlay.classList.contains('active')) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    });

    closeBtn?.addEventListener('click', closeMobileMenu);
    overlay?.addEventListener('click', (e) => {
        if (e.target === overlay) closeMobileMenu();
    });

    // Dropdown toggle manual
    document.querySelectorAll('.mobile-dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const parent   = this.closest('.has-mobile-dropdown');
            const dropdown = parent.querySelector('.mobile-dropdown-menu');
            const arrow    = this.querySelector('.mobile-dropdown-arrow');
            const isOpen   = parent.classList.contains('open');

            // Tutup semua sibling
            parent.parentElement.querySelectorAll('.has-mobile-dropdown').forEach(sib => {
                if (sib !== parent) {
                    sib.classList.remove('open');
                    sib.querySelector('.mobile-dropdown-menu').style.display = 'none';
                    const sibArrow = sib.querySelector('.mobile-dropdown-arrow');
                    if (sibArrow) sibArrow.style.transform = 'rotate(0deg)';
                }
            });

            // Toggle current
            if (isOpen) {
                parent.classList.remove('open');
                dropdown.style.display = 'none';
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            } else {
                parent.classList.add('open');
                dropdown.style.display = 'block';
                if (arrow) {
                    arrow.style.transform = arrow.classList.contains('fa-chevron-down')
                        ? 'rotate(180deg)'
                        : 'rotate(90deg)';
                }
            }
        });
    });

    // AUTO OPEN SESUAI HALAMAN AKTIF — PAKAI CSS KAMU 100%!
    function autoOpenActiveMenu() {
        const currentPath = window.location.pathname;

        document.querySelectorAll('.mobile-menu-item a[href]').forEach(link => {
            const href = link.getAttribute('href');
            if (href && (currentPath.includes(href) || currentPath.startsWith(href + '/'))) {
                link.classList.add('active');

                let parent = link.closest('.has-mobile-dropdown');
                while (parent) {
                    parent.classList.add('open'); // cukup .open → CSS kamu langsung kerja!

                    const arrow = parent.querySelector('.mobile-dropdown-arrow');
                    if (arrow) {
                        arrow.style.transform = arrow.classList.contains('fa-chevron-down')
                            ? 'rotate(180deg)'
                            : 'rotate(90deg)';
                    }

                    parent = parent.parentElement?.closest('.has-mobile-dropdown');
                }
            }
        });
    }

    // Jalankan saat halaman load
    autoOpenActiveMenu();
});