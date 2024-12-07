<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>

@php
    // Define the translations for each language
    $commonData = [
        'en' => [
            'title' => 'YODY',
            'subtitle' => 'LOOK GOOD - FEEL GOOD',
            'buttonText' => 'Shop Now',
            'watchText' => 'Watch Trending',
        ],
        'vi' => [
            'title' => 'YODY',
            'subtitle' => 'MẶC ĐẸP - TỰ TIN',
            'buttonText' => 'Mua Ngay',
            'watchText' => 'Xem Xu Hướng',
        ],
    ];

    // Get the language code from the URL
    $locale = request()->segment(1, 'vi'); // Default to 'vi' if no language code in URL

    // Get the translation data for the selected language
    $selectedData = $commonData[$locale] ?? $commonData['vi']; // Fall back to 'vi' if not found

    $slides = [
        ['img' => '/images/slides/img-slide-1.png'],
        ['img' => '/images/slides/img-slide-2.png'],
        ['img' => '/images/slides/img-slide-3.png'],
        ['img' => '/images/slides/img-slide-4.png'],
    ];
@endphp

<swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="false" space-between="30"
    centered-slides="true" autoplay-delay="4000" effect="fade" speed="2000" autoplay-disable-on-interaction="true">
    @foreach ($slides as $slide)
        <swiper-slide class="swiper-slide relative">
            <div class="bg-black fixed bg-opacity-20 w-full h-full z-20"></div>
            <img src="{{ $slide['img'] }}" alt=""
                class="w-full h-[80vh] lg:h-[100vh] object-cover animate-scale animate-bg">
            <div class="absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center text-white">
                <!-- Display title dynamically based on selected language -->
                <h2 class="text-3xl z-50 sm:text-xl md:text-2xl lg:text-4xl font-medium fade-in">
                    {{ $selectedData['title'] }}</h2>
                <!-- Display subtitle dynamically based on selected language -->
                <p class="text-[25px] z-50 text-pretty sm:text-[40px] md:text-[40px] lg:text-[100px] font-bold fade-in">
                    {{ $selectedData['subtitle'] }}
                </p>
            </div>
        </swiper-slide>
    @endforeach
</swiper-container>
