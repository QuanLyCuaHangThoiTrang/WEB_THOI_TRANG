document.addEventListener('DOMContentLoaded', () => {
    const productMenuToggle = document.getElementById('product-menu-toggle');
    const productMegaMenu = document.getElementById('product-mega-menu');

    if (productMenuToggle) {
        productMenuToggle.addEventListener('mouseover', () => {
            productMegaMenu.style.display = 'block';
        });

        productMenuToggle.addEventListener('mouseleave', () => {
            productMegaMenu.style.display = 'none';
        });
    }

    // Thêm sự kiện mouseover và mouseleave cho mega menu
    productMegaMenu.addEventListener('mouseover', () => {
        productMegaMenu.style.display = 'block';
    });

    productMegaMenu.addEventListener('mouseleave', () => {
        productMegaMenu.style.display = 'none';
    });

    // Ẩn mega menu nếu chuột không ở trong cả hai phần tử
    document.addEventListener('mouseover', (event) => {
        if (!productMenuToggle.contains(event.target) && !productMegaMenu.contains(event.target)) {
            productMegaMenu.style.display = 'none';
        }
    });

    // Toggle off-canvas menu
    const menuToggle = document.getElementById('menu-toggle');
    const offcanvasMenu = document.getElementById('offcanvas-menu');
    const offcanvasMenuContainer = document.getElementById('offcanvas-menu-container');

    menuToggle.addEventListener('click', () => {
        offcanvasMenu.classList.toggle('hidden');
        offcanvasMenuContainer.classList.toggle('translate-x-0');
        offcanvasMenuContainer.classList.toggle('-translate-x-full');
    });

    const offcanvasClose = document.getElementById('offcanvas-close');
    if (offcanvasClose) {
        offcanvasClose.addEventListener('click', () => {
            offcanvasMenu.classList.add('hidden');
            offcanvasMenuContainer.classList.add('-translate-x-full');
            offcanvasMenuContainer.classList.remove('translate-x-0');
        });
    }

    document.addEventListener('click', (e) => {
        if (!offcanvasMenu.contains(e.target) && !menuToggle.contains(e.target)) {
            offcanvasMenu.classList.add('hidden');
            offcanvasMenuContainer.classList.add('-translate-x-full');
            offcanvasMenuContainer.classList.remove('translate-x-0');
        }
    });
});
