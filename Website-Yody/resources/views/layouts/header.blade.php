<header class=" font-meidum z-50 bg-white border-b border-gray-300 w-full fixed">
    <div class="w-full p-3 bg-transparent bg-opacity-100">
        <div class="mx-auto flex items-center h-full justify-between px-3 lg:px-5 relative flex-wrap">
            <div class="flex items-center gap-10 flex-grow">
                <div>
                    <button id="menu-toggle" class="block lg:hidden">
                        <x-icons.icon name="menu-toggle" />
                    </button>
                </div>
                <div class="logo w-[90px] md:w-[100px]">
                    <a href="{{ url('/') }}">
                        <img class="max-w-full h-auto" src="{{ asset('/icons/logo.webp') }}" alt="logo">
                    </a>
                </div>
                <div class="bg-white rounded-full px-6 mx-auto hidden lg:flex">
                    <ul class="menu flex text-blue-950 font-semibold text-xl text-center relative flex-grow">
                        <li>
                            <a href="{{ url('/') }}" class="inline-block px-3 py-4">TRANG CHỦ</a>
                        </li>
                        <li class="relative flex">
                            <a href="{{ url('/products') }}" id="product-menu-toggle" class="inline-block px-3 py-4">SẢN
                                PHẨM</a>
                        </li>
                        <li>
                            <a href="{{ url('/contact-us') }}" class="inline-block px-3 py-4">LIÊN HỆ</a>
                        </li>
                        <li>
                            <a href="{{ url('/about-us') }}" class="inline-block px-3 py-4">VỀ CHÚNG TÔI</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex items-center  justify-center gap-3 ml-auto">
                <button id="search-toggle">
                    <x-icons.icon name="search-toggle" />
                </button>
                <button id="cart-toggle" class="relative">
                    <a href="{{ url('/cart') }}">
                        <x-icons.icon name="cart" />
                    </a>
                    <span id="cart-quantity"
                        class="absolute top-[-15px] right-[-10px] bg-red-500 text-white text-xs font-bold rounded-full px-1.5 py-0.5">
                        @if (Auth::check())
                            @php
                                $totalQuantity = 0;
                                $gioHang = App\Models\GioHang::where('MaKH', Auth::user()->MaKH)->first();
                                if ($gioHang) {
                                    $ChiTietGioHang = App\Models\ChiTietGioHang::where('MaGH', $gioHang->MaGH)->get();
                                    foreach ($ChiTietGioHang as $item) {
                                        $totalQuantity = $totalQuantity + 1;
                                    }
                                } else {
                                    $totalQuantity = 0;
                                }
                            @endphp
                            {{ $totalQuantity }}
                        @else
                            @php
                                $totalQuantity = 0;
                                foreach (session('gioHang', []) as $item) {
                                    $totalQuantity = $totalQuantity + 1;
                                }
                            @endphp
                            {{ $totalQuantity }}
                        @endif
                    </span>
                </button>

                @auth
                    @php
                        $customer = Auth::user();
                    @endphp
                    <a href="{{ url('account/' . $customer->MaKH) }}" id="profile-toggle" class="flex items-center">
                        <x-icons.icon name="profile" />
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="flex items-center">
                        @csrf
                        <button type="submit" class="flex items-center">
                            <x-icons.icon name="logout" />
                        </button>
                    </form>
                @else
                    <a href="{{ url('/login') }}" id="profile-toggle" class="flex items-center">
                        <x-icons.icon name="profile" />
                    </a>
                @endauth
            </div>
        </div>
        <div id="product-mega-menu" class="absolute left-0 top-full w-full bg-white shadow-lg hidden z-50 rounded-lg">
            <div class="p-8 px-16 pb-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8">
                @foreach ($danhmucs as $danhmuc)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">
                            {{ $danhmuc->TenDanhMuc }}</h3>
                        <ul class="space-y-2">
                            @foreach ($danhmuc->ChiTietDanhMuc as $ChiTietDM)
                                <li>
                                    <a href="{{ url('/productsDM/' . $ChiTietDM->MaCTDM) }}"
                                        class="block text-sm text-gray-800 hover:text-blue-950 hover:bg-gray-100 py-1 rounded  duration-300 hover:rounded-r-full transition-all ease-in-out">
                                        {{ $ChiTietDM->TenCTDM }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
                <img src="https://m.yodycdn.com/fit-in/filters:format(webp)/products/media/categories/menu_woman.webp"
                    alt="Image for column 6" class="w-full h-full object-cover rounded-lg shadow-lg">
            </div>
        </div>

    </div>

    @include('components.searchbar')
    @include('layouts.offcanvas')
</header>
<script>
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
</script>
