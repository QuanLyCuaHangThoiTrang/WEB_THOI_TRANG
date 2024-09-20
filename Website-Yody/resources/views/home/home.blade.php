<!-- resources/views/homepage.blade.php -->
@extends('layouts.app')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
<div class="py-5 px-14">
    <div>
        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" centered-slides="true" autoplay-delay="2000" autoplay-disable-on-interaction="false">
            <swiper-slide><img src="/images/slides/slide-1.webp" alt=""></swiper-slide>
            <swiper-slide><img src="/images/slides/slide-2.webp" alt=""></swiper-slide>
            <swiper-slide><img src="/images/slides/slide-3.webp" alt=""></swiper-slide>
        </swiper-container>
    </div>
    <div class="bg-yellow-400 px-10 mt-5">
        <div class="flex justify-between items-center py-4">
            <div>
                <h1 class="lg:text-4xl sm:text-xl font-semibold">FLASH SALE</h1>
                <p>Chốt Deal cùng Yody</p>
            </div>
            <!-- Đẩy phần tử này sang bên phải -->
            <div class="flex ml-auto text-right">
                <h1 class="lg:text-2xl sm:text-lg font-semibold">KẾT THÚC SAU</h1>
            </div>
        </div>
        <div class="mx-auto">
            <div class="max-w-screen-xl mx-auto pb-10">
                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                    @for ($i = 0; $i < 5; $i++)
                    <div class="group relative bg-gray-200 cursor-pointer">
                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-65">
                            <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg" alt="Product Image" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                        </div>
                        <div class="mt-4 flex justify-between px-3 pb-3">
                            <div>
                                <h3 class="text-xl font-semibold text-red-600">14.500đ</h3>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <img src="https://m.yodycdn.com/fit-in/filters:format(webp)/products/lyzi73e4buoc6opgwiq1920x864.png" alt="">
    </div>
    <div class="mt-5">
        <div class="text-center p-10">
            <h1 class="text-4xl text-blue-900 font-semibold">SẢN PHẨM ƯA CHUỘNG</h1>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            @for ($i = 0; $i < 15; $i++)
            <div class="group relative cursor-pointer">
                <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                    <img src="https://m.yodycdn.com/fit-in/filters:format(webp)/products/swn6004-den-sdn6314-bed-04.jpg" alt="Product Image" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                </div>
                <div class="mt-4 pb-3">
                    <h3 class="text-base">Áo gió mát mẻ mùa hè</h3>
                    <!-- Sử dụng flex để căn chỉnh giá và nút chi tiết -->
                    <div class="flex justify-between items-center mt-2">
                        <h3 class="font-semibold">800.000đ</h3>
                        <!-- Nút Xem Chi Tiết -->
                        <button class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                            Chi Tiết
                        </button>
                    </div>
                </div>
            </div>
            @endfor
        </div>

    </div>
</div>
@endsection
