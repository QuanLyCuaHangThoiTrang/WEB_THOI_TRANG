@php
    // Define translations for both Vietnamese and English
    $translations = [
        'en' => [
            'service_title' => 'ENJOY OUR SERVICES',
            'service_description' =>
                'We are always listening, understanding, and innovating. We continuously improve to bring real value to our customers, build sustainable relationships, and create differentiation. We are committed to providing creative and effective solutions to help you overcome challenges and achieve long-term success.',
            'easy_payment' => 'Easy Payment',
            'easy_payment_description' => 'We offer flexible payment methods.',
            'fast_delivery' => 'Fast Delivery',
            'fast_delivery_description' =>
                'We aim to provide customers with the fastest possible delivery of products.',
            'support_24_7' => '24/7 Support',
            'support_24_7_description' => 'We are always available to assist customers with any questions about Yody.',
            'warranty_return' => 'Warranty & Return',
            'warranty_return_description' => 'We handle any product defects to improve the customer experience.',
        ],
        'vi' => [
            'service_title' => 'TẬN HƯỞNG DỊCH VỤ',
            'service_description' =>
                'Chúng tôi luôn lắng nghe, thấu hiểu, đổi mới. Từng bước cải tiến để mang lại giá trị đích thực cho khách hàng, xây dựng mối quan hệ bền vững và tạo nên sự khác biệt. Chúng tôi cam kết cung cấp những giải pháp sáng tạo và hiệu quả, giúp bạn vượt qua mọi thử thách và đạt được thành công lâu dài.',
            'easy_payment' => 'Thanh toán dễ dàng',
            'easy_payment_description' =>
                'Chúng tôi linh hoạt trong việc cung cấp nhiều phương thức thanh toán khác nhau.',
            'fast_delivery' => 'Giao Nay Mai Nhận',
            'fast_delivery_description' =>
                'Chúng tôi luôn muốn khách hàng có thể mau chóng trải nghiệm sản phẩm một cách nhanh nhất có thể.',
            'support_24_7' => 'Hỗ Trợ 24/7',
            'support_24_7_description' => 'Luôn luôn hỗ trợ những thắc mắc của khách hàng về Yody.',
            'warranty_return' => 'Bảo Hành Đổi Trả',
            'warranty_return_description' =>
                'Chúng tôi luôn xử lý bất cứ sai sót của sản phẩm để tăng trải nghiệm của khách hàng.',
        ],
    ];

    // Get the selected language (default to 'vi')
    $locale = request()->segment(1, 'vi');
    $selectedTranslations = $translations[$locale] ?? $translations['vi'];
@endphp

<section class="relative mt-12 fade-item shadow-3xl p-6 lg:p-24 bg-cover bg-center"
    style="background-image: url('images/slides/img-bg-1.png');">
    <div class="absolute inset-0 bg-black opacity-80"></div>
    <div class="relative z-10">
        <div
            class="mb-10 lg:mb-16 flex justify-center items-center flex-col gap-x-0 gap-y-6 lg:gap-y-0 lg:flex-row lg:justify-between max-md:max-w-lg max-md:mx-auto">
            <div class="relative w-full text-center lg:text-left lg:w-2/4">
                <h2
                    class="text-4xl sm:text-5xl md:text-6xl lg:text-8xl font-extrabold text-white leading-[4rem] sm:leading-[5rem] lg:leading-[7rem] mx-auto max-w-max lg:max-w-md lg:mx-0 text-shadow-white">
                    {{ $selectedTranslations['service_title'] }}
                </h2>
            </div>

            <div class="relative w-full text-center lg:text-left lg:w-2/4">
                <p class="text-sm sm:text-base md:text-lg font-medium leading-relaxed text-gray-200 mb-5">
                    {{ $selectedTranslations['service_description'] }}
                </p>
            </div>
        </div>
        <div
            class="flex justify-center items-center gap-x-5 gap-y-8 lg:gap-y-0 flex-wrap md:flex-wrap lg:flex-nowrap lg:flex-row lg:justify-between lg:gap-x-8">
            <div
                class="group relative w-full cursor-pointer bg-gray-50 rounded-2xl p-4 transition-all duration-500 max-md:max-w-md max-md:mx-auto md:w-2/5 md:h-64 xl:p-7 xl:w-1/4 hover:bg-blue-800">
                <div class="bg-white rounded-full flex justify-center items-center mb-5 w-14 h-14 ">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M24.7222 11.6667V7.22225C24.7222 5.99495 23.7273 5 22.5 5H4.72222C3.49492 5 2.5 5.99492 2.5 7.22222V22.7778C2.5 24.0051 3.49492 25 4.72222 25H22.5C23.7273 25 24.7222 24.005 24.7222 22.7777V17.7778M20.8333 17.7778H25.2778C26.5051 17.7778 27.5 16.7829 27.5 15.5556V13.8889C27.5 12.6616 26.5051 11.6667 25.2778 11.6667H20.8333C19.606 11.6667 18.6111 12.6616 18.6111 13.8889V15.5556C18.6111 16.7829 19.606 17.7778 20.8333 17.7778Z"
                            stroke="#2044ac" stroke-width="2"></path>
                    </svg>
                </div>
                <h4
                    class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 capitalize transition-all duration-500 group-hover:text-white">
                    {{ $selectedTranslations['easy_payment'] }}
                </h4>
                <p
                    class="text-xs sm:text-sm font-normal text-gray-500 transition-all duration-500 leading-5 group-hover:text-white">
                    {{ $selectedTranslations['easy_payment_description'] }}
                </p>
            </div>
            <div
                class="group relative w-full cursor-pointer bg-gray-50 rounded-2xl p-4 transition-all duration-500 max-md:max-w-md max-md:mx-auto md:w-2/5 md:h-64 xl:p-7 xl:w-1/4 hover:bg-blue-800">
                <div class="bg-white rounded-full flex justify-center items-center mb-5 w-14 h-14 ">
                    <svg width="35" height="35" viewBox="0 0 22 25" fill="none">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"
                            stroke="#2044ac" stroke-width="2" />
                    </svg>
                </div>
                <h4
                    class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 capitalize transition-all duration-500 group-hover:text-white">
                    {{ $selectedTranslations['fast_delivery'] }}
                </h4>
                <p
                    class="text-xs sm:text-sm font-normal text-gray-500 transition-all duration-500 leading-5 group-hover:text-white">
                    {{ $selectedTranslations['fast_delivery_description'] }}
                </p>
            </div>
            <div
                class="group relative w-full cursor-pointer bg-gray-50 rounded-2xl p-4 transition-all duration-500 max-md:max-w-md max-md:mx-auto md:w-2/5 md:h-64 xl:p-7 xl:w-1/4 hover:bg-blue-800">
                <div class="bg-white rounded-full flex justify-center items-center mb-5 w-14 h-14 ">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.0067 10V15.6652C15.0067 16.0358 15.1712 16.3873 15.4556 16.6248L18.75 19.375M15 27.5C8.09644 27.5 2.5 21.9036 2.5 15C2.5 8.09644 8.09644 2.5 15 2.5C21.9036 2.5 27.5 8.09644 27.5 15C27.5 21.9036 21.9036 27.5 15 27.5Z"
                            stroke="#2044ac" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <h4
                    class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 capitalize transition-all duration-500 group-hover:text-white">
                    {{ $selectedTranslations['support_24_7'] }}
                </h4>
                <p
                    class="text-xs sm:text-sm font-normal text-gray-500 transition-all duration-500 leading-5 group-hover:text-white">
                    {{ $selectedTranslations['support_24_7_description'] }}
                </p>
            </div>
            <div
                class="group relative w-full cursor-pointer bg-gray-50 rounded-2xl p-4 transition-all duration-500 max-md:max-w-md max-md:mx-auto md:w-2/5 md:h-64 xl:p-7 xl:w-1/4 hover:bg-blue-800">
                <div class="bg-white rounded-full flex justify-center items-center mb-5 w-14 h-14 ">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 14.7875L13.0959 17.8834C13.3399 18.1274 13.7353 18.1275 13.9794 17.8838L20.625 11.25M15 27.5C8.09644 27.5 2.5 21.9036 2.5 15C2.5 8.09644 8.09644 2.5 15 2.5C21.9036 2.5 27.5 8.09644 27.5 15C27.5 21.9036 21.9036 27.5 15 27.5Z"
                            stroke="#4F46E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <h4
                    class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 capitalize transition-all duration-500 group-hover:text-white">
                    {{ $selectedTranslations['warranty_return'] }}
                </h4>
                <p
                    class="text-xs sm:text-sm font-normal text-gray-500 transition-all duration-500 leading-5 group-hover:text-white">
                    {{ $selectedTranslations['warranty_return_description'] }}
                </p>
            </div>
        </div>
    </div>
</section>
