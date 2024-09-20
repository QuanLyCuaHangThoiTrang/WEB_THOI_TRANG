document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('menu-toggle');
    const offcanvasMenu = document.getElementById('offcanvas-menu');
    const offcanvasClose = document.getElementById('offcanvas-close');
    const productMenuToggle = document.getElementById('product-menu-toggle');
    const productDropdownMenu = document.getElementById('product-dropdown-menu');

    menuToggle.addEventListener('click', () => {
        offcanvasMenu.classList.toggle('hidden');
    });

    offcanvasClose.addEventListener('click', () => {
        offcanvasMenu.classList.add('hidden');
    });

    productMenuToggle.addEventListener('click', (e) => {
        e.preventDefault();
        productDropdownMenu.classList.toggle('hidden');
    });
});
