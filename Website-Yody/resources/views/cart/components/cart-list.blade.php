<div class="w-full max-w-7xl mx-auto relative z-10">
            <div class="flex flex-col lg:flex-row gap-4 justify-center ">
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
                                    @include('cart.components.quantity-control')
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
                                        <img src="https://m.yodycdn.com/fit-in/filters:format(webp)/products/ao-polo-nu-yody-APN7136-XAH-3%20(1).JPG" alt="product image" class="w-full h-auto rounded-xl object-cover">
                                    </div>
                                    <div class="flex-1 md:flex md:items-center">
                                        <div class="flex flex-col gap-2">
                                            <h6 class="font-semibold text-base leading-7">{{ $item['TenSP'] }}</h6>
                                            <h6 class="font-medium text-base leading-7 text-red-600">{{ $item['DonGia'] }}</h6>
                                            <button class="btn bg-gray-100 flex p-1 w-fit rounded-lg">
                                                <span class="font-semibold">{{ $item['TenMau'] }}, {{ $item['TenSize'] }}</span>
                                                <span class="inline-block pl-2 pt-1">
                                                    <x-icons.icon name="chevron-down"/>
                                                </span>
                                            </button>
                                        </div>
                                        @include('cart.components.quantity-control')
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

                  <!-- check all ở dưới phần này nè -->
                       
                <!-- Order Summary -->
                @include('cart.components.cart-summary')
                @include('cart.components.modal-quantity')
                
            </div>
        </div>