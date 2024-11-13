<div id="offcanvas-menu" class="fixed inset-0 z-40 hidden lg:hidden">
    <div class="relative w-full h-full bg-white shadow-md transform -translate-x-full transition-transform duration-300 ease-in-out"
        id="offcanvas-menu-container">
        <div class="p-5 flex justify-between items-center">
            <span class="text-xl font-bold">Menu</span>
            <button id="offcanvas-close" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <ul class="menu p-5 space-y-2 text-sky-900">
            <li>
                <a href="" class="inline-block px-3 py-4 text-lg md:text-xl lg:text-xl font-bold">SALE OFF
                    50%</a>
            </li>
            <li>
                <a href="" class="inline-block px-3 py-4 text-base font-semibold">TRANG CHỦ</a>
            </li>
            <li class="relative flex items-center">
                <a href="#" id="product-mobile-menu-toggle"
                    class="px-3 py-4 text-base font-semibold flex items-center">
                    SẢN PHẨM
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="ml-2 w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </a>

            </li>
            <ul id="product-mobile-dropdown-menu" class=" bg-white shadow-lg rounded-lg hidden space-y-2 text-sky-900">
                <li><a href="#" class="block px-4 py-2 text-base font-semibold hover:bg-gray-100">Sub-item 1</a>
                </li>
                <li><a href="#" class="block px-4 py-2 text-base font-semibold hover:bg-gray-100">Sub-item 2</a>
                </li>
                <li><a href="#" class="block px-4 py-2 text-base font-semibold hover:bg-gray-100">Sub-item 3</a>
                </li>
            </ul>
            <li>
                <a href="" class="inline-block px-3 py-4 text-base font-semibold">LIÊN HỆ</a>
            </li>
        </ul>
    </div>
</div>
