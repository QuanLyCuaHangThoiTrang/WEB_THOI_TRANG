    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    @php
        $commonData = [
            'title' => 'YODY',
            'subtitle' => 'LOOK GOOD - FEEL GOOD',
            'link' => 'https://www.youtube.com/watch?v=Mcknd4H2pLw',
            'buttonText' => 'Shop Now',
            'watchText' => 'Watch Trending'
        ];

        $slides = [
            ['img' => '/images/slides/img-slide-1.png'],
            ['img' => '/images/slides/img-slide-2.png'],
            ['img' => '/images/slides/img-slide-3.png'],
            ['img' => '/images/slides/img-slide-4.png']
        ];
    @endphp

    <swiper-container 
        class="mySwiper" 
        pagination="true" 
        pagination-clickable="true" 
        navigation="false" 
        space-between="30" 
        centered-slides="true" 
        autoplay-delay="4000" 
        effect="fade"
        speed="2000"
        autoplay-disable-on-interaction="true">
        @foreach ($slides as $slide)
            <swiper-slide class="swiper-slide relative">
                <img src="{{ $slide['img'] }}" alt="" class="w-full h-[80vh] lg:h-[100vh] object-cover animate-scale animate-bg">
                <div class="absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center text-white">
                    <h2 class="text-lg sm:text-xl md:text-2xl lg:text-4xl font-medium">{{ $commonData['title'] }}</h2>
                    <p class="text-[25px] text-pretty sm:text-[40px] md:text-[40px] lg:text-[70px] font-bold">{{ $commonData['subtitle'] }}</p>
                    <div class="flex items-center gap-3 sm:gap-5 md:gap-7">
                        <button class="bg-primary text-white px-2 py-1 sm:px-3 sm:py-2 md:px-4 md:py-2 rounded">{{ $commonData['buttonText'] }}</button>
                        <button class="flex items-center gap-1 border-2 border-white hover:border-4 duration-150 bg-transparent text-white px-2 py-1 sm:px-3 sm:py-2 md:px-4 md:py-2 rounded">
                            <a href="{{ $commonData['link'] }}" target="_blank">{{ $commonData['watchText'] }}</a>
                        </button>
                    </div>
                </div>
            </swiper-slide>
        @endforeach
    </swiper-container>
