<div class="w-full max-w-9xl mx-auto">

    <div class="flex mt-3 flex-col lg:flex-row gap-4">

        <!-- Product List -->
        <form action="{{ route('cart.update') }}" method="POST" class="w-full lg:w-2/3">
            @csrf
            @method('PUT')

            @if (Auth::check())

                @php
                    $canCheckout = true; // Biến kiểm tra xem có thể thanh toán hay không
                @endphp
                @foreach ($chiTietGioHang as $index => $chitiet)
                    <div class="flex flex-col md:flex-row bg-white p-3 border-b border-gray-200 gap-4 items-center">
                        <a href="{{ route('cart.remove', ['MaGH' => $chitiet->MaGH, 'MaCTSP' => $chitiet->MaCTSP]) }}"
                            class="remove-item text-red-500 hover:text-red-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 6h18M8 6V4a2 2 0 112 0v2m4-2a2 2 0 112 0v2m4 0v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6h16zM9 10v10m6-10v10" />
                            </svg>
                        </a>
                        <div class="w-full md:w-[150px]">
                            <img src="{{ asset('images/products/' . $chitiet->ChiTietSanPham->HinhAnh) }}"
                                alt="product image" class="w-full h-auto rounded-xl object-cover">
                        </div>
                        <div class="flex-1  space-y-4">
                            <h6 class="font-semibold text-lg">{{ $chitiet->chiTietSanPham->sanPham->TenSP }}</h6>
                            <p class="text-red-600 font-bold">{{ number_format($chitiet->DonGia, 0, ',', '.') }} đ</p>
                            <div class="flex items-center border bg-gray-100 rounded-3xl w-32 gap-2 mt-2">
                                <span class="w-8 h-8 border border-gray-300 rounded-full"
                                    style="background-color: {{ $chitiet->chiTietSanPham->mauSac->TenMau }}"></span>
                                <span class="font-semibold">Size:
                                    {{ $chitiet->chiTietSanPham->KichThuoc->TenSize }}</span>
                            </div>
                            @if ($chitiet->chiTietSanPham->SoLuongTonKho == 0)
                                <p class="text-red-600 font-bold">Sản phẩm đã hết hàng</p>
                            @else
                                @if ($chitiet->SoLuong > $chitiet->ChiTietSanPham->SoLuongTonKho)
                                    <p class="text-red-600 font-bold">Sản phẩm vượt quá số lượng hiện có</p>
                                @endif
                            @endif
                        </div>
                        @include('cart.components.quantity-control')
                    </div>
                    <input type="hidden" name="items[{{ $index }}][DonGia]" value="{{ $chitiet->DonGia }}">
                    <input type="hidden" name="items[{{ $index }}][MaCTSP]" value="{{ $chitiet->MaCTSP }}">
                    <input type="hidden" name="items[{{ $index }}][MaGH]" value="{{ $chitiet->MaGH }}">

                    @if ($chitiet->SoLuong > $chitiet->ChiTietSanPham->SoLuongTonKho)
                        @php $canCheckout = false; @endphp
                    @endif
                @endforeach
            @else
                @php
                    $canCheckout1 = true; // Biến kiểm tra xem có thể thanh toán hay không
                @endphp
                @foreach ($gioHangSession as $index => $item)
                    <div class="flex flex-col md:flex-row bg-white p-4 border-b border-gray-200 gap-4 items-center">
                        <a href="{{ route('cart.removeSS', ['MaCTSP' => $item['MaCTSP']]) }}"
                            class="remove-item text-red-500 hover:text-red-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 6h18M8 6V4a2 2 0 112 0v2m4-2a2 2 0 112 0v2m4 0v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6h16zM9 10v10m6-10v10" />
                            </svg>
                        </a>
                        <div class="w-full md:w-[150px]">
                            <img src="{{ asset('images/products/' . $item['HinhAnh']) }}" alt="product image"
                                class="w-full h-auto rounded-xl object-cover">
                        </div>
                        <div class="flex-1 space-y-4">
                            <h6 class="font-semibold text-lg">{{ $item['TenSP'] }}</h6>
                            <p class="text-red-600 font-bold">{{ number_format($item['DonGia'], 0, ',', '.') }} đ</p>
                            <div class="flex items-center font-bold border rounded-3xl w-32 shadow-sm gap-2 mt-2">
                                <span class="w-8 h-8 border border-gray-300 rounded-full"
                                    style="background-color: {{ $item['TenMau'] }}"></span>
                                <span class="font-semibold">Kích cỡ: {{ $item['TenSize'] }}</span>
                            </div>
                            @if ($item['SoLuongTonKho'] == 0)
                                <p class="text-red-600 font-bold">Sản phẩm đã hết hàng</p>
                            @else
                                @if ($item['SoLuong'] > $item['SoLuongTonKho'])
                                    <p class="text-red-600 font-bold">Sản phẩm vượt quá số lượng hiện có</p>
                                @endif
                            @endif
                        </div>
                        @include('cart.components.quantity-control')
                    </div>
                    <input type="hidden" name="items[{{ $index }}][DonGia]" value="{{ $item['DonGia'] }}">
                    <input type="hidden" name="items[{{ $index }}][MaCTSP]" value="{{ $item['MaCTSP'] }}">
                    <input type="hidden" name="items[{{ $index }}][MaGH]" value="">
                    @if ($item['SoLuong'] > $item['SoLuongTonKho'])
                        @php $canCheckout1 = false; @endphp
                    @endif
                @endforeach
            @endif

            <!-- Update Button -->
            @if ((Auth::check() && $tongGiaTri > 0) || (!Auth::check() && count($gioHangSession) > 0))
                <button type="submit"
                    class="w-full bg-blue-900 font-bold text-white py-2 rounded-md text-center hover:bg-blue-600 transition duration-300">CẬP
                    NHẬT</button>
            @endif
        </form>

        <!-- Order Summary -->

        <!-- Order Summary -->
        @if ((Auth::check() && $tongGiaTri > 0) || (!Auth::check() && count($gioHangSession) > 0))
            <div class="w-full lg:w-[600px] bg-white mt-4 p-6 xl:p-10 rounded-lg mx-auto py-4">
                <h3 class="text-lg font-semibold mb-4 border-b border-gray-300 pb-2">Thông tin sản phẩm:</h3>
                @if (Auth::check())
                    @foreach ($chiTietGioHang as $chitiet)
                        <div class="flex justify-between items-center border-b border-gray-200 py-2">
                            <span class="text-gray-800  ">Mã sản phẩm: <span
                                    class="font-semibold">{{ $chitiet->chiTietSanPham->sanPham->MaSP }}</span></span>
                            <div class="text-gray-600 flex items-center">
                                <span>SL: <strong>{{ $chitiet->SoLuong }}</strong></span>
                            </div>
                        </div>
                    @endforeach
                @else
                    @foreach ($gioHangSession as $item)
                        <div class="flex justify-between items-center border-b border-gray-200 py-2">
                            <span class="text-gray-800 text-base truncate">{{ $item['TenSP'] }}</span>
                            <div class="text-gray-600 flex items-center">

                                <span>SL: <strong>{{ $item['SoLuong'] }}</strong></span>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="flex font-semibold items-center border-t border-gray-200 justify-between py-4">
                    <p class="text-xl leading-8">Tổng giá trị:</p>
                    <p id="tongGiaTriSauGiamGia" class="text-xl leading-8 text-red-600">
                        {{ number_format($tongGiaTri, 0, ',', '.') }} đ</p>
                </div>
                @if (
                    (Auth::check() && $tongGiaTri > 0 && $canCheckout) ||
                        (!Auth::check() && count($gioHangSession) > 0 && $canCheckout1 && $KTSLKho))
                    <a href="{{ url('/checkout') }}">
                        <div
                            class="w-full bg-yellow-500 rounded-lg py-3 px-6 font-semibold text-lg text-white transition-all duration-300 hover:bg-yellow-400 shadow-md text-center mt-4">
                            Hoàn tất kiểm tra
                        </div>
                    </a>
                @else
                    <div
                        class="w-full bg-red-500 rounded-lg py-3 px-6 font-semibold text-lg text-white transition-all duration-300 hover:bg-red-400 shadow-md text-center mt-4">
                        Vui lòng kiểm tra lại thông tin sản phẩm
                    </div>
                @endif
            </div>
        @else
            <div class="flex justify-center items-center w-full bg-white mt-4 xl:p-10 mr-80 rounded-lg mx-auto py-4">
                <!-- Căn giữa phần giỏ hàng trống -->
                @include('cart.components.cart-empty')
            </div>
        @endif
        @include('cart.components.modal-quantity')

    </div>
</div>
