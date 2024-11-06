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
                <button id="cart-toggle">
                    <a href="{{ url('/cart') }}">
                        <x-icons.icon name="cart" />
                    </a>
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
        <div id="product-mega-menu" class="absolute left-0 top-full w-full bg-white shadow-xl hidden">
            <div class="p-6 px-24 pb-10 flex gap-5 flex-wrap">
                @foreach ($danhmucs as $danhmuc)
                    <div class="w-full md:w-1/5 border-r-2 mb-4">
                        <h3 class="text-lg font-semibold mb-4">{{ $danhmuc->TenDanhMuc }}</h3>
                        <ul class="space-y-2">
                            @foreach ($danhmuc->ChiTietDanhMuc as $ChiTietDM)
                                <li><a href="{{ url('/productsDM/' . $ChiTietDM->MaCTDM) }}"
                                        class="block text-base hover:bg-gray-100 py-1">{{ $ChiTietDM->TenCTDM }}</a>
                                </li>
                            @endforeach

                        </ul>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('components.searchbar')
    @include('layouts.offcanvas')
</header>
<script src="{{ asset('js/header.js') }}"></script>
