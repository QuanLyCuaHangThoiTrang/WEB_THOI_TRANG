{{-- @php
    // Define translations for both languages
    $commonData = [
        'en' => [
            'total_value' => 'Total value:',
            'checkout_button' => 'Complete checkout',
            'stock_error' => 'Product quantity exceeds available stock, please update your cart',
        ],
        'vi' => [
            'total_value' => 'Tổng giá trị:',
            'checkout_button' => 'Hoàn tất kiểm tra',
            'stock_error' => 'Số lượng sản phẩm vượt quá số lượng sản phẩm trong kho vui lòng cập nhật lại',
        ],
    ];
    // Get the current language code
    $locale = request()->segment(1, 'vi'); // Default to 'vi' if no language code in URL

    // Get the translation data for the selected language
    $selectedData = $commonData[$locale] ?? $commonData['vi']; // Fall back to 'vi' if not found
@endphp

@if ((Auth::check() && $tongGiaTri > 0) || (!Auth::check() && count($gioHangSession) > 0))
    <div class="w-full lg:w-[500px] bg-white mt-4 p-6 xl:p-10 max-w-3xl xl:max-w-lg mx-auto py-4">
        <div class="mt-2 text-base">

            <div class="flex font-semibold items-center border-t border-gray-200 justify-between py-4">

                <p class="text-xl leading-8">{{ $selectedData['total_value'] }}</p>
                <p id="tongGiaTriSauGiamGia" class="text-xl leading-8">{{ number_format($tongGiaTri, 0, ',', '.') }} đ</p>
            </div>

            @csrf
            @if ((Auth::check() && $tongGiaTri > 0 && $canCheckout == false) || (!Auth::check() && count($gioHangSession) > 0 && $canCheckout1))
                <a href="{{ url('/checkout') }}">
                    <div id="checkout-btn-{{ $index }}" type="button"
                        class="w-full bg-yellow-500 rounded-xl py-3 px-6 font-semibold text-lg text-white transition-all duration-500 hover:bg-yellow-400 shadow-sm border-b-2 border-b-yellow-700 shadow-yellow-600 text-center">
                        {{ $selectedData['checkout_button'] }}</div>
                </a>
            @else
                <div id="checkout-btn-{{ $index }}" type="button"
                    class="w-full bg-yellow-500 rounded-xl py-3 px-6 font-semibold text-lg text-white transition-all duration-500 hover:bg-yellow-400 shadow-sm border-b-2 border-b-yellow-700 shadow-yellow-600 text-center">
                    {{ $selectedData['stock_error'] }}</div>
            @endif
        </div>
    </div>
@else
    @include('cart.components.cart-empty')
@endif --}}
