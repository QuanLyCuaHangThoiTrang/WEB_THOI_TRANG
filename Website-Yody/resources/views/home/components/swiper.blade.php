    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    @php
        $commonData = [
            'title' => 'YODY',
            'subtitle' => 'LOOK GOOD - FEEL GOOD',
            'link' => 'https://www.youtube.com/watch?v=Mcknd4H2pLw',
            'buttonText' => 'Shop Now',
            'watchText' => 'Watch Trending',
        ];

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
                    <!-- Thêm lớp fade-in cho title -->
                    <h2 class="text-3xl z-50 sm:text-xl md:text-2xl lg:text-4xl font-medium fade-in">
                        {{ $commonData['title'] }}</h2>
                    <!-- Thêm lớp fade-in cho subtitle -->
                    <p
                        class="text-[25px] z-50 text-pretty sm:text-[40px] md:text-[40px] lg:text-[100px] font-bold fade-in">
                        {{ $commonData['subtitle'] }}
                    </p>
                </div>
            </swiper-slide>
        @endforeach
    </swiper-container>
