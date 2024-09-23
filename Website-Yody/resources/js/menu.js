document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('menu-toggle');
    const offcanvasMenu = document.getElementById('offcanvas-menu');
    const offcanvasClose = document.getElementById('offcanvas-close');
    const productMenuToggle = document.getElementById('product-menu-toggle');
    const productDropdownMenu = document.getElementById('product-dropdown-menu');

    if (menuToggle && offcanvasMenu && offcanvasClose) {
        menuToggle.addEventListener('click', () => {
            offcanvasMenu.classList.toggle('hidden');
        });

        offcanvasClose.addEventListener('click', () => {
            offcanvasMenu.classList.add('hidden');
        });
    }

    if (productMenuToggle && productDropdownMenu) {
        productMenuToggle.addEventListener('click', (e) => {
            e.preventDefault();
            productDropdownMenu.classList.toggle('hidden');
        });
    }

    // Hide dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (productDropdownMenu && !productMenuToggle.contains(e.target) && !productDropdownMenu.contains(e.target)) {
            productDropdownMenu.classList.add('hidden');
        }
    });
});
