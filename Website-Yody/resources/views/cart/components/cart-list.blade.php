<div class="w-full max-w-8xl mx-auto p-4">
    <div class="flex flex-col lg:flex-row gap-4">
        <!-- Product List -->
        <form action="{{ route('cart.update') }}" method="POST" class="w-full lg:w-2/3">
            @csrf
            @method('PUT')
            
            @if(Auth::check())
                @foreach ($chiTietGioHang as $index => $chitiet)
                    <div class="flex flex-col md:flex-row bg-white p-4 border-b border-gray-200 gap-4 items-center">
                        <div class="w-full md:w-[150px]">
                            <img src="{{ asset('images/products/' . $chitiet->ChiTietSanPham->HinhAnh) }}" alt="product image" class="w-full h-auto rounded-xl object-cover">
                        </div>
                        <div class="flex-1">
                            <h6 class="font-semibold text-lg">{{ $chitiet->chiTietSanPham->sanPham->TenSP }}</h6>
                            <p class="text-gray-600">{{ number_format($chitiet->DonGia, 0, ',', '.') }} đ</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="w-8 h-8 border border-gray-300 rounded-full" style="background-color: {{ $chitiet->chiTietSanPham->mauSac->TenMau }}"></span>
                                <span>Size: {{ $chitiet->chiTietSanPham->KichThuoc->TenSize }}</span>
                            </div>
                        </div>
                        @include('cart.components.quantity-control')
                    </div>
                    <input type="hidden" name="items[{{ $index }}][DonGia]" value="{{ $chitiet->DonGia }}">
                    <input type="hidden" name="items[{{ $index }}][MaCTSP]" value="{{ $chitiet->MaCTSP }}">
                    <input type="hidden" name="items[{{ $index }}][MaGH]" value="{{ $chitiet->MaGH }}">
                @endforeach
            @else
                @foreach($gioHangSession as $index => $item)
                    <div class="flex flex-col md:flex-row bg-white p-4 border-b border-gray-200 gap-4 items-center">
                        <div class="w-full md:w-[150px]">
                            <img src="{{ asset('images/products/' . $item['HinhAnh']) }}" alt="product image" class="w-full h-auto rounded-xl object-cover">
                        </div>
                        <div class="flex-1">
                            <h6 class="font-semibold text-lg">{{ $item['TenSP'] }}</h6>
                            <p class="text-red-600">{{ number_format($item['DonGia'], 0, ',', '.') }} đ</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="w-8 h-8 border border-gray-300 rounded-full" style="background-color: {{ $item['TenMau'] }}"></span>
                                <span>Size: {{ $item['TenSize'] }}</span>
                            </div>
                        </div>
                        @include('cart.components.quantity-control')
                    </div>
                    <input type="hidden" name="items[{{ $index }}][DonGia]" value="{{ $item['DonGia'] }}">
                    <input type="hidden" name="items[{{ $index }}][MaCTSP]" value="{{ $item['MaCTSP'] }}">
                    <input type="hidden" name="items[{{ $index }}][MaGH]" value="">
                @endforeach
            @endif

            <!-- Update Button -->
            @if((Auth::check() && $tongGiaTri > 0) || (!Auth::check() && count($gioHangSession) > 0))
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md text-center hover:bg-blue-600 transition duration-300">CẬP NHẬT</button>
            @endif
        </form>

        <!-- Order Summary -->
<!-- Order Summary -->
@if ((Auth::check() && $tongGiaTri > 0) || (!Auth::check() && count($gioHangSession) > 0))
<div class="w-full lg:w-[600px] bg-white mt-4 p-6 xl:p-10 rounded-lg mx-auto py-4">
    <h3 class="text-lg font-semibold mb-4 border-b border-gray-300 pb-2">Thông tin sản phẩm:</h3>
    @if(Auth::check())
        @foreach ($chiTietGioHang as $chitiet)
            <div class="flex justify-between items-center border-b border-gray-200 py-2">
                <span class="text-gray-800 font-semibold">{{ $chitiet->chiTietSanPham->sanPham->TenSP }}</span>
                <div class="text-gray-600 flex items-center">
                   
                    <span>SL: <strong>{{ $chitiet->SoLuong }}</strong></span>
                </div>
            </div>
        @endforeach
    @else
        @foreach($gioHangSession as $item)
            <div class="flex justify-between items-center border-b border-gray-200 py-2">
                <span class="text-gray-800 font-semibold">{{ $item['TenSP'] }}</span>
                <div class="text-gray-600 flex items-center">
                   
                    <span>SL: <strong>{{ $item['SoLuong'] }}</strong></span>
                </div>
            </div>
        @endforeach
    @endif

    <div class="flex font-semibold items-center border-t border-gray-200 justify-between py-4">
        <p class="text-xl leading-8">Tổng giá trị:</p>
        <p id="tongGiaTriSauGiamGia" class="text-xl leading-8 text-red-600">{{ number_format($tongGiaTri, 0, ',', '.') }} đ</p>
    </div>

    <a href="{{ url('/checkout') }}">
        <div class="w-full bg-yellow-500 rounded-lg py-3 px-6 font-semibold text-lg text-white transition-all duration-300 hover:bg-yellow-400 shadow-md text-center mt-4">
            Hoàn tất kiểm tra
        </div>
    </a>
</div>
@else
@include('cart.components.cart-empty')
@endif



        @include('cart.components.modal-quantity')
    </div>
</div>
