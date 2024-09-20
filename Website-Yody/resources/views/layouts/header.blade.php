<header class="top-0 sticky z-20 w-full bg-white">
    <div class="w-full p-4 md:p-4 bg-white shadow-md bg-opacity-80 backdrop-blur-2xl">
        <div class="container mx-auto flex items-center h-full justify-between px-3 lg:px-5 relative">
            <div class="flex items-center gap-7 flex-grow">
                <div>
                    <button id="menu-toggle" class="block lg:hidden">
                        <x-icons.icon name="menu-toggle"/>
                    </button>
                </div>
                <div class="logo md:w-[95px] w-[70px]">
                    <a href="{{ url('/') }}">
                        <span class="cursor-pointer">
                            <img class="w-full h-auto max-w-full" src="{{ asset('/icons/logo.webp') }}" alt="logo">
                        </span>
                    </a>
                </div>
                <ul class="menu hidden lg:flex md:hidden text-sky-900 relative">
                    <li>
                        <a href="{{ url('/') }}" class="inline-block px-3 py-4 text-base md:text-xl lg:text-xl font-bold">SALE OFF 50%</a>
                    </li>
                    <li>
                        <a href="" class="inline-block px-3 py-4 text-lg font-semibold">TRANG CHỦ</a>
                    </li>
                    <li class="relative flex">
                        <a href="{{ url('/products') }}" id="product-menu-toggle" class="px-3 py-4 text-lg font-semibold flex items-center">
                            SẢN PHẨM
                            <x-icons.icon name="chevron-down"/>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/contact-us') }}" class="inline-block px-3 py-4 text-lg font-semibold">LIÊN HỆ</a>
                    </li>
                </ul>
            </div>

            <div class="searchbar-container relative w-full md:w-auto items-center hidden md:flex">
                <form action="{{ url('/search') }}" method="GET" class="flex items-center w-full">
                    <input 
                        type="search" 
                        name="query" 
                        class="w-full md:w-58 px-7 py-2 text-sm border border-gray-300 rounded-3xl focus:outline-none focus:ring-blue-500" 
                        placeholder="Tìm kiếm sản phẩm..."
                    />
                </form>
            </div>
            <div class="flex items-center justify-center gap-5">
                <button id="search-toggle" class="md:hidden ml-10">
                   <x-icons.icon name="search-toggle"/>
                </button>
                <button id="cart-toggle" class="ml-1">
                    <a href="{{ url('/cart') }}">
                        <x-icons.icon name="cart"/>
                    </a>
                </button>

                @auth
                    @php
                        $customer = Auth::user();
                        
                    @endphp
                    <a href="{{ url('account/' . $customer->MaKH) }}" id="profile-toggle" class="flex items-center">
                        <x-icons.icon name="profile"/>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="ml-1 flex items-center">
                        @csrf
                        <button type="submit" class="flex items-center">
                            <x-icons.icon name="logout"/>
                        </button>
                    </form>
                @else
                    <a href="{{ url('/login') }}" id="profile-toggle" class="flex items-center">
                        <x-icons.icon name="profile"/>
                    </a>
                @endauth


            </div>
        </div>
        <div id="product-mega-menu" class="absolute left-0 top-full w-full bg-white shadow-xl hidden">
            <div class="p-6 px-32 pb-10 flex gap-10">
                <!-- Column 1 -->
                <div class="w-1/4 border-r-2">
                    <h3 class="text-lg font-semibold mb-4">Áo</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Áo polo</a></li>
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Áo khoác</a></li>
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Áo thun</a></li>
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Áo sơ mi</a></li>
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Áo hoodie</a></li>
                    </ul>
                </div>
                <!-- Column 2 -->
                <div class="w-1/4 border-r-2">
                    <h3 class="text-lg font-semibold mb-4">Quần</h3>
                    <ul class="space-y-2 ">
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Quần Jean</a></li>
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Quần kaki</a></li>
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Quần dài</a></li>
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Quần short</a></li>
                    </ul>
                </div>
                <div class="w-1/4 border-r-2">
                    <h3 class="text-lg font-semibold mb-4">Đồ bộ</h3>
                    <ul class="space-y-2 ">
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Sub-item 1</a></li>
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Sub-item 2</a></li>
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Sub-item 3</a></li>
                    </ul>
                </div>
                <!-- Column 3 -->
                <div class="w-1/4 border-r-2">
                    <h3 class="text-lg font-semibold mb-4">Đồ thể thao</h3>
                    <ul class="space-y-2 ">
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Sub-item 1</a></li>
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Sub-item 2</a></li>
                        <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Sub-item 3</a></li>
                    </ul>
                </div>
                <!-- Column 4 (e.g., Image) -->
                <div class="w-1/4">
                    <img src="https://yody.vn/images/menu-desktop/menu_man.png" alt="Featured" class="w-full h-auto rounded-lg shadow-md">
                </div>
            </div>
        </div>
    </div>

    @include('components.searchbar')
    <!-- Off-canvas menu -->
    @include('layouts.offcanvas')
</header>
<script src="{{ asset('js/header.js') }}"></script>
