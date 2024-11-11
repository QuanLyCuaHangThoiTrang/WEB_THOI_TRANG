<!-- resources/views/homepage.blade.php -->
@extends('layouts.app')
@section('content')
<div id="canvas-filter" class="fixed inset-0 z-50 lg:hidden hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"></div>
    <div class="fixed inset-0 z-50 flex">
        <div class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
            <div class="flex items-center justify-between px-4">
                <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                <button class="focus:outline-none" id="close-filter">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form class="mt-4 border-t border-gray-200">
                <!-- Categories Section -->

                <!-- Color Filter Section -->
                <div class="border-b border-gray-200 py-6">
                    <h3 class="-my-3 flow-root">
                        <button type="button"
                            class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
                            aria-controls="filter-section-0" aria-expanded="true">
                            <span class="font-medium text-xl text-gray-900">Màu sắc</span>
                            <span class="ml-6 flex items-center">
                                <span class="text-xl hidden" id="expand-icon-0">+</span>
                                <span class="text-xl" id="collapse-icon-0">-</span>
                            </span>
                        </button>
                    </h3>
                    <!-- Display the color filter section by default -->
                    <div class="pt-6" id="filter-section-0">
                        <div class="grid grid-cols-4 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4">
                            @foreach ($MauSacs as $item)
                                <div class="flex items-center justify-center">
                                    <!-- Hidden checkbox but still captures value when clicked -->
                                    <input id="filter-color-{{ $loop->index }}" name="color[]" value="{{ $item->TenMau }}"
                                        type="checkbox" class="hidden custom-checkbox1">

                                    <!-- Color box user can click on -->
                                    <label for="filter-color-{{ $loop->index }}"
                                        class="ml-3 text-sm text-gray-600 flex flex-col items-center cursor-pointer">
                                        <span class="inline-block hover:scale-110 duration-200 h-14 w-14 rounded-full mb-2 border border-gray-300"
                                            style="background-color: {{ $item->TenMau }};"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Size Filter Section -->
                <div class="border-b border-gray-200 py-6">
                    <h3 class="-my-3 flow-root">
                        <button type="button"
                            class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
                            aria-controls="filter-section-2" aria-expanded="true">
                            <span class="font-medium text-xl text-gray-900">Kích cỡ</span>
                            <span class="ml-6 flex items-center">
                                <span class="text-xl hidden" id="expand-icon-2">+</span>
                                <span class="text-xl" id="collapse-icon-2">-</span>
                            </span>
                        </button>
                    </h3>
                    <!-- Display the size filter section by default -->
                    <div class="pt-6" id="filter-section-2">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach ($KichThuocs as $item)
                                <div class="flex items-center">
                                    <label for="filter-size-{{ $loop->index }}" class="flex items-center cursor-pointer space-x-2">
                                        <input id="filter-size-{{ $loop->index }}" name="size[]" value="{{ $item->TenSize }}"
                                            type="checkbox" class="hidden custom-checkbox">
                                        <span class="inline-flex items-center justify-center w-16 gap-4 space-x-4 space-y-4 h-10 border hover:scale-110 duration-200 rounded-xl text-lg cursor-pointer">
                                            {{ $item->TenSize }}
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Apply Filters Button -->
                <div class="border-t border-gray-200 px-4 py-6">
                    <button type="submit" class="w-full bg-gray-900 py-2 text-white hover:bg-gray-700">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <main class="mx-auto mt-14 px-4 lg:px-24">
        <div class="flex items-baseline justify-between border-b border-gray-200 pt-12">
            <h1 class="text-4xl text-balance font-bold tracking-tight text-gray-900">DANH SÁCH SẢN PHẨM</h1>
            <div class="flex items-center p-6">
                <div class="relative inline-block text-left">
                    <div>
                        <button type="button"
                            class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                            id="menu-button" aria-expanded="false" aria-haspopup="true">
                            Sắp xếp
                            <svg class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <div class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
                        id="dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="menu-button"
                        tabindex="-1">
                        <div class="py-1" role="none">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-500" role="menuitem"
                                tabindex="-1" id="menu-item-2" data-sort="asc">Giá: Tăng dần</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-500" role="menuitem"
                                tabindex="-1" id="menu-item-3" data-sort="desc">Giá: Giảm dần</a>
                        </div>
                    </div>
                </div>
                <button id="filter-button" class="ml-4 lg:hidden text-gray-700 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                    </svg>
                </button>
            </div>
        </div>

        <section aria-labelledby="products-heading" class="pb-24 pt-6">
            <div class="grid grid-cols-1 gap-x-10 gap-y-10 lg:grid-cols-4">
                <!-- Filters -->
                @include('products.filter')
                <div class="col-span-3">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sanphams">
                        @foreach ($sanPhams as $sanPham)
                            <div class="group relative cursor-pointer product-item"
                                data-colors="{{ implode(',', $sanPham->chiTietSanPham->pluck('mauSac.TenMau')->toArray()) }}"
                                data-sizes="{{ implode(',', $sanPham->chiTietSanPham->pluck('kichThuoc.TenSize')->toArray()) }}">
                                <a href="{{ url('/product_detail/' . $sanPham->MaSP) }}">
                                    <div
                                        class="w-full overflow-hidden bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-96">
                                        <img src="{{ asset('images/products/' . $sanPham->chiTietSanPham->first()->HinhAnh) }}"
                                            alt="{{ $sanPham->TenSP }}" class="object-cover w-full h-full">
                                    </div>
                                    <div class="mt-4 pb-3">
                                        <h3 class="text-base font-medium truncate">{{ $sanPham->TenSP }}</h3>
                                        <div class="flex space-x-2 mt-2">
                                            @php
                                                $mauSacUnique = [];
                                            @endphp
                                            @foreach ($sanPham->chiTietSanPham as $chiTiet)
                                                @if (isset($chiTiet->mauSac) && !in_array($chiTiet->mauSac->TenMau, $mauSacUnique))
                                                    <span
                                                        class="w-5 h-5 rounded-full border border-gray-300 flex items-center justify-center cursor-pointer transition duration-200 ease-in-out transform hover:scale-110"
                                                        style="background-color: {{ $chiTiet->mauSac->TenMau }}"></span>
                                                    @php
                                                        $mauSacUnique[] = $chiTiet->mauSac->TenMau;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="flex justify-between items-center mt-4">
                                            @if ($sanPham->GiaGiam == 0 || $sanPham->GiaGiam == null)
                                                <h3 class="gia font-semibold text-lg">
                                                    {{ number_format($sanPham->GiaBan, 0, ',', '.') }} đ</h3>
                                            @else
                                                <h3 class="font-semibold text-lg line-through text-red-500">
                                                    {{ number_format($sanPham->GiaBan, 0, ',', '.') }} đ</h3>
                                                <h3 class="gia font-semibold text-lg">
                                                    {{ number_format($sanPham->GiaGiam, 0, ',', '.') }} đ</h3>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <!-- Thêm các liên kết phân trang ở đây -->
                    <div class="mt-6">
                        {{ $sanPhams->links() }}
                    </div>
                </div>
            </div>
        </section>
    </main>


    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Lắng nghe sự kiện khi chọn màu
            const colorInputs = document.querySelectorAll('input[name="color[]"]');
            const sizeInputs = document.querySelectorAll('input[name="size[]"]');
            const products = document.querySelectorAll('.product-item');

            const filterProducts = () => {
                const selectedColors = Array.from(colorInputs)
                    .filter(i => i.checked)
                    .map(i => i.value);

                const selectedSizes = Array.from(sizeInputs)
                    .filter(i => i.checked)
                    .map(i => i.value);

                products.forEach(product => {
                    const productColors = product.getAttribute('data-colors').split(
                        ','); // Lấy danh sách màu từ thuộc tính data-colors
                    const productSizes = product.getAttribute('data-sizes').split(
                        ','); // Lấy danh sách kích thước từ thuộc tính data-sizes

                    // Kiểm tra nếu sản phẩm có màu và kích thước trong danh sách đã chọn
                    const colorMatch = selectedColors.length === 0 || selectedColors.some(color =>
                        productColors.includes(color));
                    const sizeMatch = selectedSizes.length === 0 || selectedSizes.some(size =>
                        productSizes.includes(size));

                    if (colorMatch && sizeMatch) {
                        product.style.display = ''; // Hiển thị sản phẩm
                    } else {
                        product.style.display = 'none'; // Ẩn sản phẩm
                    }
                });
            };

            // Lắng nghe sự kiện thay đổi màu
            colorInputs.forEach(input => {
                input.addEventListener('change', filterProducts);
            });

            // Lắng nghe sự kiện thay đổi kích thước
            sizeInputs.forEach(input => {
                input.addEventListener('change', filterProducts);
            });
            //Sắp xếp 
            const sortItems = document.querySelectorAll('#dropdown-menu a');
            sortItems.forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

                    const sortOrder = item.getAttribute('data-sort');
                    sortProducts(sortOrder);
                });
            });
            // Hàm sắp xếp sản phẩm
            function sortProducts(order) {
                const productsArray = Array.from(products);

                productsArray.sort((a, b) => {
                    const priceA = parseFloat(a.querySelector('.gia').innerText.replace('.', '')
                        .replace(' đ', ''));
                    const priceB = parseFloat(b.querySelector('.gia').innerText.replace('.', '')
                        .replace(' đ', ''));

                    return order === 'asc' ? priceA - priceB : priceB - priceA;
                });

                const productContainer = document.querySelector(
                    '.sanphams');
                productContainer.innerHTML = ''; // Xóa tất cả sản phẩm hiện có

                productsArray.forEach(product => {
                    productContainer.appendChild(product); // Thêm sản phẩm đã sắp xếp vào container
                });

            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('button[aria-expanded]');

            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    const expanded = button.getAttribute('aria-expanded') === 'true';
                    const sectionId = button.getAttribute('aria-controls');
                    const section = document.getElementById(sectionId);
                    const expandIcon = button.querySelector('[id^="expand-icon-"]');
                    const collapseIcon = button.querySelector('[id^="collapse-icon-"]');

                    button.setAttribute('aria-expanded', !expanded);
                    section.classList.toggle('hidden');
                    if (expandIcon) expandIcon.classList.toggle('hidden', !expanded);
                    if (collapseIcon) collapseIcon.classList.toggle('hidden', expanded);
                });
            });

            // Dropdown menu functionality
            const menuButton = document.getElementById('menu-button');
            const dropdownMenu = document.getElementById('dropdown-menu');

            if (menuButton && dropdownMenu) {
                menuButton.addEventListener('click', () => {
                    dropdownMenu.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside of it
                document.addEventListener('click', (event) => {
                    if (!menuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            }

            // Show/hide canvas filter
            const filterButton = document.getElementById('filter-button');
            const canvasFilter = document.getElementById('canvas-filter');

            filterButton.addEventListener('click', () => {
                canvasFilter.classList.toggle('hidden');
            });

            // Close canvas filter when clicking outside
            document.getElementById('close-filter').addEventListener('click', () => {
                canvasFilter.classList.add('hidden');
            });
        });
    </script>
@endsection
