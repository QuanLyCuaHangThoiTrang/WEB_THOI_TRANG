@if ((Auth::check() && $tongGiaTri > 0) || (!Auth::check() && count($gioHangSession) > 0))
    <div class="w-full lg:w-[500px] bg-white mt-4 p-6 xl:p-10 max-w-3xl xl:max-w-lg mx-auto py-4">
        <h2 class="font-semibold text-2xl leading-10 border-b border-gray-300 pb-2">Chi tiết đơn hàng</h2>
        <div class="mt-2 text-base">
            <div class="flex items-center justify-between pb-2">
                <p class="leading-8 text-gray-600">Tổng giá trị sản phẩm</p>
                <p id="tongGiaTri" class="leading-8 text-gray-600">{{ number_format($tongGiaTri, 0, ',', '.') }} đ</p>
            </div>
            <div class="flex items-center justify-between pb-2">
                <p class="leading-8 text-gray-600">Giảm giá:</p>
                <p id="giamGia" class="leading-8 text-red-600">{{ number_format(0, 0, ',', '.') }} đ</p>
            </div>
            <div class="flex items-center justify-between pb-2">
                <p class="leading-8 text-gray-600">Vận chuyển:</p>
                <p class="leading-8 text-gray-600">{{ number_format(20000, 0, ',', '.') }} đ</p>
            </div>
           


            <div class="flex font-semibold items-center border-t border-gray-200 justify-between py-4">

                <p class="text-xl leading-8">Tổng giá trị:</p>
                <p id="tongGiaTriSauGiamGia" class="text-xl leading-8">{{ number_format($tongGiaTri, 0, ',', '.') }} đ</p>
            </div>

            @csrf
            @if ((Auth::check() && $tongGiaTri > 0 && $canCheckout == false) || (!Auth::check() && count($gioHangSession) > 0 && $canCheckout1))
                <a href="{{ url('/checkout') }}">
                    <div id="checkout-btn-{{ $index }}" type="button"
                        class="w-full bg-yellow-500 rounded-xl py-3 px-6 font-semibold text-lg text-white transition-all duration-500 hover:bg-yellow-400 shadow-sm border-b-2 border-b-yellow-700 shadow-yellow-600 text-center">
                        Hoàn tất kiểm tra</div>
                </a>
            @else
                <div id="checkout-btn-{{ $index }}" type="button"
                        class="w-full bg-yellow-500 rounded-xl py-3 px-6 font-semibold text-lg text-white transition-all duration-500 hover:bg-yellow-400 shadow-sm border-b-2 border-b-yellow-700 shadow-yellow-600 text-center">
                        Số lượng sản phẩm vượt quá số lượng sản phẩm trong kho vui lòng cập nhật lại</div>
            @endif

            <div class="p-4 text-center mt-4">
                <div class="flex gap-2 items-center justify-center mb-3">
                    @foreach (['zalopay', 'visa-card', 'master-card', 'vnpay-qr', 'momo'] as $icon)
                        <img alt="{{ $icon }}" class="h-[1.5rem] object-contain"
                            src="https://yody.vn/icons/{{ $icon }}.png">
                    @endforeach
                </div>
                <div class="font-medium text-gray-600">Đảm bảo thanh toán an toàn và bảo mật</div>
            </div>
        </div>
    </div>
@else
    @include('cart.components.cart-empty')
@endif
