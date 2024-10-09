<div class="w-full max-w-7xl mx-auto relative z-10">
    <div class="flex flex-col lg:flex-row gap-4 justify-center ">
        <!-- Product List -->
        <form action="{{ route('cart.update') }}" method="POST" class="updateCart" style="display:inline;">
            @csrf
            @method('PUT')         
            <div class="flex-1 lg:pr-8 pb-8 lg:py-4 w-full max-xl:max-w-3xl max-xl:mx-auto">
                @if (Auth::check())
                    @php
                        $canCheckout = true; // Biến kiểm tra xem có thể thanh toán hay không
                    @endphp               
                    @foreach ($chiTietGioHang as $index => $chitiet)
                        <div class="flex bg-white px-4 py-6 border-b border-gray-200 gap-4 md:gap-8 items-center">                       
                            <div class="w-full md:max-w-[150px]">
                                <img src="{{ asset('images/products/' . $chitiet->ChiTietSanPham->HinhAnh) }}"
                                    alt="product image" class="w-full h-auto rounded-xl object-cover">
                            </div>
                            <div class="flex-1 md:flex md:items-center">
                                <div class="flex flex-col gap-2">
                                    <h6 class="font-semibold text-base leading-7">
                                        {{ $chitiet->chiTietSanPham->sanPham->TenSP }}</h6>
                                        <h6 class="font-semibold text-base leading-7">
                                            {{ $chitiet->chiTietSanPham->SoLuongTonKho }}</h6>
                                    <h6 class="font-medium text-base leading-7 text-gray-600">
                                        {{ number_format($chitiet->DonGia, 0, ',', '.') }} đ</h6>
                                    <span
                                        class="font-semibold w-10 h-10 border border-gray-300 flex items-center justify-center cursor-pointer transition duration-200 ease-in-out transform hover:scale-105"
                                        style="background-color: {{ $chitiet->chiTietSanPham->mauSac->TenMau }}"></span>
                                    <span class="font-semibold">Size:
                                        {{ $chitiet->chiTietSanPham->KichThuoc->TenSize }}</span>
                                </div>
                                @include('cart.components.quantity-control')
                            </div>
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
                        <div class="flex bg-white px-4 py-6 border-b border-gray-200 gap-4 md:gap-8 items-center">
                            <div class="w-full md:max-w-[150px]">
                                <img src="{{ asset('images/products/' . $item['HinhAnh']) }}" alt="product image"
                                    class="w-full h-auto rounded-xl object-cover">
                            </div>
                            <div class="flex-1 md:flex md:items-center">
                                <div class="flex flex-col gap-2">
                                    <h6 class="font-semibold text-base leading-7">{{ $item['TenSP'] }}</h6>
                                    <span id="SoLuongKho-{{ $index }}-SoLuongTonKho" class="font-semibold text-base leading-7">{{ $item['SoLuongTonKho'] }}</span>
                                    <h6 class="font-medium text-base leading-7 text-red-600">
                                        {{ number_format($item['DonGia'], 0, ',', '.') }} đ</h6>
                                    <span
                                        class="font-semibold w-10 h-10 rounded-full hover:border-blue-700  border border-gray-300 flex items-center justify-center cursor-pointer transition duration-200 ease-in-out transform hover:scale-105"
                                        style="background-color: {{ $item['TenMau'] }}"></span>
                                    <span class="font-semibold">Size: {{ $item['TenSize'] }}</span>
                                </div>
                                @include('cart.components.quantity-control')                         
                            </div>
                        </div>                      
                        <input type="hidden" name="items[{{ $index }}][DonGia]" value="{{ $item['DonGia'] }}">
                        <input type="hidden" name="items[{{ $index }}][MaCTSP]" value="{{ $item['MaCTSP'] }}">
                        <input type="hidden" name="items[{{ $index }}][MaGH]" value="">
                        @if ($item['SoLuong'] > $item['SoLuongTonKho'])
                            @php $canCheckout1 = false; @endphp
                        @endif
                    @endforeach
                @endif
                @if ((Auth::check() && $tongGiaTri > 0) || (!Auth::check() && count($gioHangSession) > 0))
                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-2 px-4 rounded-md text-center hover:bg-blue-600 transition duration-300">UPDATE</button>
                @else
                @endif

            </div>
        </form>

        <!-- check all ở dưới phần này nè -->

        <!-- Order Summary -->
        @include('cart.components.cart-summary')
        @include('cart.components.modal-quantity')

    </div>
</div>
