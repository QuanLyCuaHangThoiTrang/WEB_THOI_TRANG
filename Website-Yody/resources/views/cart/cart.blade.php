@extends('layouts.app')

@section('content')

{{-- <div class="bg-gray-100 px-10 pb-10">
    <section class="container mx-auto py-2 lg:py-4 bg-gray-100">
        <div class="bg-white py-4 px-6 lg:px-7">
            <h1 class="text-xl font-semibold lg:text-3xl">Shopping Cart</h1>
        </div>
        <div class="w-full max-w-7xl mx-auto relative z-10">
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Product List -->
                <form action="{{ route('cart.update') }}" method="POST" class="updateCart" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <div class="flex-1 lg:pr-8 pb-8 lg:py-4 w-full max-xl:max-w-3xl max-xl:mx-auto">
                        @if(Auth::check())                                                     
                            @foreach ($chiTietGioHang as $index => $chitiet)
                                <div class="flex bg-white px-4 py-6 border-b border-gray-200 gap-4 md:gap-8 items-center">
                                    <a href="{{ route('cart.remove', ['MaGH' => $chitiet->MaGH, 'MaCTSP' => $chitiet->MaCTSP]) }}" class="remove-item text-red-500 hover:text-red-700 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a2 2 0 112 0v2m4-2a2 2 0 112 0v2m4 0v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6h16zM9 10v10m6-10v10" />
                                        </svg>                                
                                    </a>   
                                    <div class="w-full md:max-w-[150px]">
                                        <img src="{{ asset('images/products/' . $chitiet->ChiTietSanPham->HinhAnh) }}" alt="product image" class="w-full h-auto rounded-xl object-cover">
                                    </div>
                                    <div class="flex-1 md:flex md:items-center">
                                        <div class="flex flex-col gap-2">
                                            <h6 class="font-semibold text-base leading-7">{{ $chitiet->chiTietSanPham->sanPham->TenSP }}</h6>
                                            <h6 class="font-medium text-base leading-7 text-gray-600">{{ $chitiet->DonGia }}</h6>
                                            <button class="btn bg-gray-100 flex p-1 w-fit rounded-lg">
                                                <span class="font-semibold">{{ $chitiet->chiTietSanPham->mauSac->TenMau }}, {{ $chitiet->chiTietSanPham->KichThuoc->TenSize }}</span>
                                                <span class="inline-block pl-2 pt-1">
                                                    <x-icons.icon name="chevron-down"/>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="relative flex items-center max-w-[8rem] border rounded-2xl">
                                            <button type="button" class="decrement rounded-s-lg p-2 h-11 focus:outline-none" data-index="{{ $index }}">
                                                <x-icons.icon name="decrement"/>
                                            </button>
                                            <input type="text" id="quantity-input-{{ $index }}" class="h-10 w-12 text-center text-sm py-2.5 text-black" name="items[{{ $index }}][SoLuong]" value="{{ $chitiet->SoLuong }}" required />
                                            <button type="button" class="increment rounded-e-lg p-2 h-11 focus:outline-none" data-index="{{ $index }}">
                                                <x-icons.icon name="increment"/>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="items[{{ $index }}][DonGia]" value="{{ $chitiet->DonGia }}">
                                <input type="hidden" name="items[{{ $index }}][MaCTSP]" value="{{ $chitiet->MaCTSP }}">
                                <input type="hidden" name="items[{{ $index }}][MaGH]" value="{{ $chitiet->MaGH }}">
                            @endforeach                                       
                        @else
                            @foreach($gioHangSession as $index => $item)
                                <div class="flex bg-white px-4 py-6 border-b border-gray-200 gap-4 md:gap-8 items-center">
                                    <a href="{{ route('cart.removeSS', ['MaCTSP' => $item['MaCTSP']]) }}" class="remove-item text-red-500 hover:text-red-700 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a2 2 0 112 0v2m4-2a2 2 0 112 0v2m4 0v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6h16zM9 10v10m6-10v10" />
                                        </svg>                                
                                    </a>                   
                                    <div class="w-full md:max-w-[150px]">
                                        <img src="{{ asset('images/products/' . $item['HinhAnh']) }}">
                                    </div>
                                    <div class="flex-1 md:flex md:items-center">
                                        <div class="flex flex-col gap-2">
                                            <h6 class="font-semibold text-base leading-7">{{ $item['TenSP'] }}</h6>
                                            <h6 class="font-medium text-base leading-7 text-red-600">{{ $item['DonGia'] }}</h6>
                                           
                                            <span class="font-semibold w-10 h-10 border border-gray-300 flex items-center justify-center cursor-pointer transition duration-200 ease-in-out transform hover:scale-105" style="background-color: {{ $item['TenMau'] }}"></span>
                                                <span class="font-semibold">Size: {{ $item['TenSize'] }}</span>
                                        </div>
                                        <div class="flex items-center ml-auto mt-4 md:mt-0">                                       
                                            <div class="relative flex items-center max-w-[8rem] border rounded-2xl">
                                                <button type="button" class="decrement rounded-s-lg p-2 h-11 focus:outline-none" data-index="{{ $index }}">
                                                    <x-icons.icon name="decrement"/>
                                                </button>
                                                <input type="text" id="quantity-input-{{ $index }}" class="h-10 w-12 text-center text-sm py-2.5 text-black" value="{{ $item['SoLuong'] }}" name="items[{{ $index }}][SoLuong]" required />
                                                <button type="button" class="increment rounded-e-lg p-2 h-11 focus:outline-none" data-index="{{ $index }}">
                                                    <x-icons.icon name="increment"/>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="items[{{ $index }}][DonGia]" value="{{ $item['DonGia'] }}">
                                <input type="hidden" name="items[{{ $index }}][MaCTSP]" value="{{ $item['MaCTSP'] }}">
                                <input type="hidden" name="items[{{ $index }}][MaGH]" value="">
                            @endforeach
                        @endif
                        @if((Auth::check() && $tongGiaTri > 0) || (!Auth::check() && count($gioHangSession) > 0))
                            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md text-center hover:bg-blue-600 transition duration-300">UPDATE</button>
                        @else
                            
                        @endif
                        
                    </div>                    
                </form>   

                  <!-- Remove all ở dưới phần này nè -->
                       
                <!-- Order Summary -->
                @if((Auth::check() && $tongGiaTri > 0) || (!Auth::check() && count($gioHangSession) > 0))
                    <div class="w-full lg:w-[500px] bg-white mt-4 p-6 xl:p-10 max-w-3xl xl:max-w-lg mx-auto py-4">
                        <h2 class="font-semibold text-2xl leading-10 border-b border-gray-300 pb-2">Chi tiết đơn hàng</h2>
                        <div class="mt-2 text-base">
                            <div class="flex items-center justify-between pb-2">
                                <p class="leading-8 text-gray-600">Tổng giá trị sản phẩm</p>
                                <p class="leading-8 text-gray-600">{{ $tongGiaTri }}</p>
                            </div>
                            <div class="flex items-center justify-between pb-2">
                                <p class="leading-8 text-gray-600">Giảm giá:</p>
                                <p class="leading-8 text-red-600">0</p>
                            </div>
                            <div class="flex items-center justify-between pb-2">
                                <p class="leading-8 text-gray-600">Vận chuyển:</p>
                                <p class="leading-8 text-gray-600">20</p>
                            </div>                     
                            <div class="flex items-center justify-between border-t border-gray-200 py-4">
                                <h3 class="text-lg font-bold text-gray-800">Promo code</h3>
                                <div class="flex border overflow-hidden max-w-sm rounded-md">
                                <input type="email" placeholder="Promo code"
                                    class="w-full outline-none bg-white text-gray-600 uppercase text-sm px-2 py-2.5" />
                                    <button type='button' class="flex items-center justify-center bg-blue-800 px-5 text-sm text-white">
                                        Apply
                                    </button>
                                </div>
                            </div>
                            
                           
                                <div class="flex font-semibold items-center border-t border-gray-200 justify-between py-4">
                                
                                    <p class="text-xl leading-8">Tổng giá trị:</p>
                                    <p class="text-xl leading-8">{{ $tongGiaTri }}</p>
                                </div>
                             
                                    @csrf
                                    @if((Auth::check() && $tongGiaTri > 0) || (!Auth::check() && count($gioHangSession) > 0))
                                        <a href="{{ url('/checkout') }}">
                                            <button type="button" class="w-full bg-yellow-500 rounded-xl py-3 px-6 font-semibold text-lg text-white transition-all duration-500 hover:bg-yellow-400 shadow-sm border-b-2 border-b-yellow-700 shadow-yellow-600">Hoàn tất kiểm tra</button>
                                        </a>
                                    @else
                                        
                                    @endif
                           
                            <div class="p-4 text-center mt-4">
                                <div class="flex gap-2 items-center justify-center mb-3">
                                    @foreach(['zalopay', 'visa-card', 'master-card', 'vnpay-qr', 'momo'] as $icon)
                                        <img alt="{{ $icon }}" class="h-[1.5rem] object-contain" src="https://yody.vn/icons/{{ $icon }}.png">
                                    @endforeach
                                </div>
                                <div class="font-medium text-gray-600">Đảm bảo thanh toán an toàn và bảo mật</div>
                            </div>
                        </div>
                    </div>   
                @else
                <div class="w-full lg:w-[500px] bg-white mt-4 p-6 xl:p-10 max-w-3xl xl:max-w-lg mx-auto py-4 text-center">
                    <h1 class="font-bold">GIỎ HÀNG TRỐNG</h1>
                </div>
                @endif
                
            </div>
        </div> --}}

<div class="bg-gray-100 px-10 pb-10 min-h-screen">
    <section class="container mt-20 mx-auto py-2 lg:py-4 bg-gray-100">
       @include('cart.components.cart-list')

    </section>
</div>
    @section('scripts')
    <script>
        document.querySelectorAll('.increment').forEach(button => {
            button.addEventListener('click', () => {
                const index = button.dataset.index;
                const input = document.getElementById(`quantity-input-${index}`);
                let value = parseInt(input.value);
                if (!isNaN(value)) {
                    value++;
                    input.value = value;
                }
            });
        });

        document.querySelectorAll('.decrement').forEach(button => {
            button.addEventListener('click', () => {
                const index = button.dataset.index;
                const input = document.getElementById(`quantity-input-${index}`);
                let value = parseInt(input.value);
                if (!isNaN(value) && value > 1) {
                    value--;
                    input.value = value;
                }
            });
        });
    </script>
    @endsection
@endsection
