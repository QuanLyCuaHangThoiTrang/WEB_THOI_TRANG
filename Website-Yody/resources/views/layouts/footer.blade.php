@php
    // Define the translations for each language
    $commonData = [
        'en' => [
            'about_us' => 'About Us',
            'contact_us' => 'Contact Us',
            'careers' => 'Careers',
            'news' => 'News',
            'store_system' => 'Store System',
            'address' => 'Address',
            'loyalty_policy' => 'Loyalty Policy',
            'return_policy' => 'Return Policy',
            'privacy_policy' => 'Privacy Policy',
            'cookie_policy' => 'Cookie Policy',
            'payment_policy' => 'Payment and Delivery Policy',
            'order_contact' => 'Order Contact: 024 999 86 999',
            'email_contact' => 'Email: chamsockhachhang@yody.vn',
            'terms' => 'Terms',
            'privacy' => 'Privacy',
            'status' => 'Status',
            'brand' => 'Brand',
            'contact' => 'Contact',
            'services' => 'Services',
        ],
        'vi' => [
            'about_us' => 'Giới thiệu',
            'contact_us' => 'Liên hệ',
            'careers' => 'Tuyển dụng',
            'news' => 'Tin tức',
            'store_system' => 'Hệ thống cửa hàng',
            'address' => 'Địa chỉ',
            'loyalty_policy' => 'Chính sách khách hàng thân thiết',
            'return_policy' => 'Chính sách đổi trả',
            'privacy_policy' => 'Chính sách bảo mật',
            'cookie_policy' => 'Chính sách sử dụng Cookies',
            'payment_policy' => 'Chính sách thanh toán, giao nhận',
            'order_contact' => 'Liên hệ đặt hàng: 024 999 86 999',
            'email_contact' => 'Email: chamsockhachhang@yody.vn',
            'terms' => 'Điều khoản',
            'privacy' => 'Chính sách bảo mật',
            'status' => 'Trạng thái',
            'brand' => 'Thương hiệu',
            'contact' => 'Liên hệ',
            'services' => 'Dịch vụ',
        ],
    ];

    // Get the language code from the URL
    $locale = request()->segment(1, 'vi'); // Default to 'vi' if no language code in URL

    // Get the translation data for the selected language
    $selectedData = $commonData[$locale] ?? $commonData['vi']; // Fall back to 'vi' if not found
@endphp

<footer class="mt-auto sticky w-full bg-gray-900 py-10 px-4 sm:px-6 lg:px-8">
    <!-- Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
        <div class="hidden lg:block lg:col-span-1">
            <div class="logo w-[100px] md:w-[200px]">
                <a href="{{ url("/{$locale}") }}" class="block">
                    <img class="w-full h-auto max-w-full shadow-white" src="{{ asset('/icons/logo.webp') }}"
                        alt="logo">
                </a>
            </div>
            <p class="mt-3 text-xs sm:text-sm text-gray-800 dark:text-neutral-400">© Yody.</p>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-gray-900 uppercase dark:text-neutral-100">
                {{ $selectedData['about_us'] }}</h4>
            <div class="mt-3 space-y-3 text-sm">
                <p><a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                        href="{{ url('/about-us') }}">{{ $selectedData['about_us'] }}</a></p>
                <p><a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                        href="{{ url('/contact-us') }}">{{ $selectedData['contact_us'] }}</a></p>
                <p><a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                        href="#">{{ $selectedData['careers'] }}</a></p>
                <p><a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                        href="#">{{ $selectedData['news'] }}</a></p>
                <p><a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                        href="#">{{ $selectedData['store_system'] }}</a></p>
                <p><a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                        href="#">{{ $selectedData['address'] }}</a></p>
            </div>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-gray-900 uppercase dark:text-neutral-100">
                {{ $selectedData['services'] }}</h4>
            <div class="mt-3 space-y-3 text-sm">
                <p><a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                        href="#">{{ $selectedData['loyalty_policy'] }}</a></p>
                <p><a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                        href="#">{{ $selectedData['return_policy'] }}</a></p>
                <p><a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                        href="#">{{ $selectedData['privacy_policy'] }}</a></p>
                <p><a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                        href="#">{{ $selectedData['cookie_policy'] }}</a></p>
                <p><a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                        href="#">{{ $selectedData['payment_policy'] }}</a></p>
            </div>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-gray-900 uppercase dark:text-neutral-100">
                {{ $selectedData['contact'] }}</h4>
            <div class="mt-3 space-y-3 text-sm">
                <p><a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                        href="#">{{ $selectedData['order_contact'] }}</a></p>
                <p><a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                        href="#">{{ $selectedData['email_contact'] }}</a></p>
            </div>
        </div>
    </div>
    <!-- End Grid -->

    <div class="pt-5 mt-5 border-t border-gray-200 dark:border-neutral-700">
        <div class="sm:flex sm:justify-between sm:items-center">
            <div class="flex flex-wrap items-center gap-3 text-sm">
                <a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                    href="#">{{ $selectedData['terms'] }}</a>
                <a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                    href="#">{{ $selectedData['privacy'] }}</a>
                <a class="text-gray-600 hover:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200"
                    href="#">{{ $selectedData['status'] }}</a>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div class="mt-3 sm:hidden">
                    <a class="font-semibold text-xl text-black dark:text-white" href="#"
                        aria-label="Brand">{{ $selectedData['brand'] }}</a>
                    <p class="mt-1 text-xs sm:text-sm text-gray-600 dark:text-neutral-400">© 2022 Preline.</p>
                </div>
                <div class="flex space-x-4">
                    <a class="text-gray-500 hover:text-gray-800 dark:text-neutral-500 dark:hover:text-neutral-200"
                        href="#">
                        <!-- Social Icons -->
                        <!-- Add your social media icons here -->
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
