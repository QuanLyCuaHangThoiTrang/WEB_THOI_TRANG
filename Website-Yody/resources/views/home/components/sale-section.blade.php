@php
    $commonData = [
        'title' => 'TITLE',
        'buttonText' => 'MUA NGAY',
    ];
@endphp

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Kiểm tra nếu khuyenMai và NgayKetThuc tồn tại
        @if (isset($khuyenMai) && $khuyenMai->NgayKetThuc)
            // Lấy Ngày kết thúc từ controller và chuyển thành định dạng JavaScript
            let endDateSTR = document.querySelector('.NgayKT').textContent.trim();

            let endDate = new Date(endDateSTR);
            let countdownElement = document.querySelector('.countdown');
            let saleSection = document.querySelector('.NdKhuyenMai');
            const timer = setInterval(() => {
                let now = new Date().getTime();
                let timeLeft =endDate - now;

                
                // Tính toán ngày, giờ, phút, giây còn lại
                let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                // Cập nhật hiển thị
                document.getElementById('days').innerText = String(days).padStart(2, '0');
                document.getElementById('hours').innerText = String(hours).padStart(2, '0');
                document.getElementById('minutes').innerText = String(minutes).padStart(2, '0');
                document.getElementById('seconds').innerText = String(seconds).padStart(2, '0');
            }, 1000);
        @else
            // Hiển thị thông báo nếu không có khuyến mãi
            document.querySelector('.countdown').innerHTML = "<span class='text-red-500'>Không có khuyến mãi hiện tại!</span>";
        @endif
    });
</script>


<div class="text-center fade-item p-16 mt-4 mb-4 px-8 lg:px-24">
    <div class="mb-4">
        <div class="bg-black p-3 rounded-t-lg">
            <div class="bg-black p-3 rounded-t-lg">
                <div class="countdown text-2xl sm:text-3xl lg:text-4xl text-white">
                    <div class="flex justify-center space-x-2 sm:space-x-4">
                        <span class="flex flex-col items-center">
                            <span id="days">00</span>
                            <span class="text-xs sm:text-sm mt-1">Ngày</span>
                        </span>
                        <span class="flex items-center">:</span>
                        <span class="flex flex-col items-center">
                            <span id="hours">00</span>
                            <span class="text-xs sm:text-sm mt-1">Giờ</span>
                        </span>
                        <span class="flex items-center">:</span>
                        <span class="flex flex-col items-center">
                            <span id="minutes">00</span>
                            <span class="text-xs sm:text-sm mt-1">Phút</span>
                        </span>
                        <span class="flex items-center">:</span>
                        <span class="flex flex-col items-center">
                            <span id="seconds">00</span>
                            <span class="text-xs sm:text-sm mt-1">Giây</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-y-3 p-3 shadow-lg NdKhuyenMai">
            <div class="flex flex-col items-center lg:flex-row lg:space-x-5 justify-center mt-2 pb-4">
                @foreach ($KhuyenMais as $KhuyenMai)
                    <div class="flex flex-col items-center text-center">
                        <h3 class="text-lg sm:text-2xl lg:text-4xl uppercase font-bold">{{ $KhuyenMai->TenKM }}</h3>
                        <div class="text-gray-500 text-center px-3 py-2 mt-2 text-sm sm:text-base">
                            {{ $KhuyenMai->MoTa }}
                        </div>
                        <div style="display: none" class="text-gray-500 text-center px-3 py-2 mt-2 text-sm sm:text-base NgayKT">
                            {{ $KhuyenMai->NgayKetThuc }}
                        </div>
                    </div>
                @endforeach
            </div>


            <!-- Swiper Container -->
            <swiper-container class="saleSwiper" loop="true" autoplay-delay="1500" effect="slide" speed="1500"
                autoplay-disable-on-interaction="true" centered-slides="true" space-between="20"
                breakpoints='{
                "320": {
                    "slidesPerView": 2,
                    "spaceBetween": 10
                },
                "480": {
                    "slidesPerView": 2,
                    "spaceBetween": 10
                },
                "768": {
                    "slidesPerView": 3,
                    "spaceBetween": 15
                },
                "1024": {
                    "slidesPerView": 4,
                    "spaceBetween": 20
                },
                "1280": {
                    "slidesPerView": 5,
                    "spaceBetween": 20
                }
            }'>

                @foreach ($KhuyenMais as $KhuyenMai)    
                    @foreach ($KhuyenMai->sanPhams as $SanPham)         
                        <swiper-slide class="swiper-slide rounded cursor-pointer duration-150 flex flex-col"
                            style="transition: opacity 0.5s, transform 0.5s;">
                            <div class="container">
                                <a href="{{ url('/product_detail/' . $SanPham->MaSP) }}">
                                    <div class="flex flex-col pb-2">
                                        <div
                                            class="text-white absolute top-0 font-medium text-sm lg:text-lg bg-red-600 hover:text-white px-2 py-4 transition duration-150">
                                            <span
                                                class="text-xs sm:text-sm font-medium">{{ -round((($SanPham->GiaBan - $SanPham->GiaGiam) / $SanPham->GiaBan) * 100) }}%</span>
                                        </div>
                                        <img src="{{ asset('images/products/' . $SanPham->ChiTietSanPham->first()->HinhAnh) }}"
                                            alt="" class="object-cover w-full max-w-screen">

                                        <div class="flex flex-col text-left mt-2">
                                            <!-- Tên sản phẩm -->
                                            <h4 class="text-sm sm:text-base md:text-lg lg:text-xl font-semibold truncate">
                                                {{ $SanPham->TenSP }}</h4>
                                            <div class="flex mt-2 justify-between items-center">
                                                <!-- Giá sản phẩm ban đầu -->
                                                <p
                                                    class="text-sm lg:text-2xl text-red-600 truncate whitespace-nowrap font-medium">
                                                    {{ number_format($SanPham->GiaGiam, 0, ',', '.') }} đ
                                                </p>
                                                <p
                                                    class="text-sm lg:text-lg text-gray-400 line-through truncate whitespace-nowrap font-normal">
                                                    {{ number_format($SanPham->GiaBan, 0, ',', '.') }} đ
                                                </p>

                                                <!-- Giá giảm và phần trăm giảm giá -->

                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        </swiper-slide>
                    @endforeach
                @endforeach
            </swiper-container>


        </div>
    </div>

</div>
