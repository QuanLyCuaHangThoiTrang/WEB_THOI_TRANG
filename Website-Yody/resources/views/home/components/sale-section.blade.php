@php
    $commonData = [
        'title' => 'TITLE',
        'buttonText' => 'MUA NGAY',
    ];
@endphp

<script>
    let days = 2;
    let hours = 5;
    let minutes = 10;
    let seconds = 24;

    const countdownElement = document.querySelector('.countdown');

    const timer = setInterval(() => {
        if (seconds === 0) {
            if (minutes === 0) {
                if (hours === 0) {
                    if (days === 0) {
                        clearInterval(timer);
                        countdownElement.innerHTML = "Time's up!";
                        return;
                    }
                    days--;
                    hours = 23;
                    minutes = 59;
                    seconds = 59;
                } else {
                    minutes--;
                    seconds = 59;
                }
            } else {
                minutes--;
                seconds = 59;
            }
        } else {
            seconds--;
        }

        // Cập nhật hiển thị
        document.getElementById('days').innerText = String(days).padStart(2, '0');
        document.getElementById('hours').innerText = String(hours).padStart(2, '0');
        document.getElementById('minutes').innerText = String(minutes).padStart(2, '0');
        document.getElementById('seconds').innerText = String(seconds).padStart(2, '0');
    }, 1000);
</script>

<div class="text-center p-16 mt-4 mb-4 px-8 lg:px-24">
    <div class="mb-4">
        <div class="bg-black p-3 rounded-t-lg">
            <div class="countdown text-2xl sm:text-3xl lg:text-4xl text-white">
                <div class="flex justify-center space-x-2 sm:space-x-4">
                    <span class="flex flex-col items-center">
                        <span id="days">00</span>
                        <span class="text-xs sm:text-sm mt-1">Days</span>
                    </span>
                    <span class="flex items-center">:</span>
                    <span class="flex flex-col items-center">
                        <span id="hours">00</span>
                        <span class="text-xs sm:text-sm mt-1">Hours</span>
                    </span>
                    <span class="flex items-center">:</span>
                    <span class="flex flex-col items-center">
                        <span id="minutes">10</span>
                        <span class="text-xs sm:text-sm mt-1">Minutes</span>
                    </span>
                    <span class="flex items-center">:</span>
                    <span class="flex flex-col items-center">
                        <span id="seconds">24</span>
                        <span class="text-xs sm:text-sm mt-1">Seconds</span>
                    </span>
                </div>
            </div>
        </div>
        <div class="space-y-3 p-3 shadow-lg">
            <div class="flex flex-col mt-2 pb-4 items-center lg:flex-row lg:space-x-5 justify-center">
                <h3 class="text-lg sm:text-2xl lg:text-4xl uppercase font-bold">{{ $commonData['title'] }}</h3>
                <a href="/products"
                    class="bg-blue-900 text-white px-3 py-2 mt-3 lg:mt-0 rounded-full shadow-md hover:bg-blue-800 transition duration-200 text-sm sm:text-base">{{ $commonData['buttonText'] }}</a>
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
                @foreach ($chiTietSanPhams as $chiTietSanPham)
                    <swiper-slide class="swiper-slide rounded cursor-pointer duration-150 flex flex-col"
                        style="transition: opacity 0.5s, transform 0.5s;">
                        <div class="container">
                            <div class="flex flex-col pb-2">
                                <!-- Hình ảnh sản phẩm -->
                                <img src="{{ asset('images/products/' . $chiTietSanPham->HinhAnh) }}" alt=""
                                    class="object-cover w-full max-w-screen">
                                <div class="flex flex-col text-left mt-2">
                                    <!-- Tên sản phẩm -->
                                    <h4 class="text-sm sm:text-base md:text-lg lg:text-xl font-semibold truncate">
                                        {{ $chiTietSanPham->SanPham->TenSP }}
                                    </h4>
                                    <div class="flex mt-2 justify-between items-center">
                                        <!-- Giá sản phẩm -->
                                        <p class="text-sm lg:text-lg truncate whitespace-nowrap font-medium">
                                            {{ number_format($chiTietSanPham->SanPham->GiaBan, 0, ',', '.') }} VND
                                        </p>
                                        <!-- Khuyến mãi -->
                                        <p
                                            class="text-white font-medium text-xs sm:text-sm border rounded-3xl bg-red-500 hover:bg-red-600 hover:text-white px-2 py-1 transition duration-150">
                                            -10%
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                @endforeach
            </swiper-container>


        </div>
    </div>

</div>
