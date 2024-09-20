// header.js
document.addEventListener('DOMContentLoaded', function() {
        const productMenuToggle = document.getElementById('product-menu-toggle');
        const productMegaMenu = document.getElementById('product-mega-menu');
        
        // Show mega menu on hover
        productMenuToggle.addEventListener('mouseover', function() {
            productMegaMenu.style.display = 'block';
        });
        
        // Hide mega menu when not hovering
        document.addEventListener('mouseover', function(event) {
            if (!productMenuToggle.contains(event.target) && !productMegaMenu.contains(event.target)) {
                productMegaMenu.style.display = 'none';
            }
        });

    // Mobile dropdown menu toggle
    const productMobileMenuToggle = document.getElementById('product-mobile-menu-toggle');
    const productMobileDropdownMenu = document.getElementById('product-mobile-dropdown-menu');

    if (productMobileMenuToggle) {
        productMobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            productMobileDropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(e) {
            if (!productMobileDropdownMenu.contains(e.target) && !productMobileMenuToggle.contains(e.target)) {
                productMobileDropdownMenu.classList.add('hidden');
            }
        });
    }

    // Toggle off-canvas menu
    const menuToggle = document.getElementById('menu-toggle');
    const offcanvasMenu = document.getElementById('offcanvas-menu');
    const offcanvasClose = document.getElementById('offcanvas-close');
    const offcanvasMenuContainer = document.getElementById('offcanvas-menu-container');

    menuToggle.addEventListener('click', function() {
        offcanvasMenu.classList.toggle('hidden');
        offcanvasMenuContainer.classList.toggle('translate-x-0');
        offcanvasMenuContainer.classList.toggle('-translate-x-full');
    });

    offcanvasClose.addEventListener('click', function() {
        offcanvasMenu.classList.add('hidden');
        offcanvasMenuContainer.classList.add('-translate-x-full');
        offcanvasMenuContainer.classList.remove('translate-x-0');
    });

    document.addEventListener('click', function(e) {
        if (!offcanvasMenu.contains(e.target) && !menuToggle.contains(e.target)) {
            offcanvasMenu.classList.add('hidden');
            offcanvasMenuContainer.classList.add('-translate-x-full');
            offcanvasMenuContainer.classList.remove('translate-x-0');
        }
    });
});
