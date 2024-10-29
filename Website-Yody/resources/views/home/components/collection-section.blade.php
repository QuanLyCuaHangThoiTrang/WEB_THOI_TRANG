<div class="space-y-2 px-8 lg:px-24">
    <div>
        <p class="font-bold text-4xl text-center py-10">SẢN PHẨM ƯA CHUỘNG</p>
    </div>
    <div class="grid gap-7 grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
        @foreach ($chiTietSanPhams->take(4) as $chiTietSanPham) 
            <div class="border p-5 rounded cursor-pointer hover:border-2 duration-150 flex flex-col">
                <div>
                    <img src="{{ asset('images/products/' . $chiTietSanPham->HinhAnh) }}" alt="" class="w-full h-full min-w-screen">
                </div>
                
                <h4 class="font-bold flex-grow mt-3 truncate">{{ $chiTietSanPham->SanPham->TenSP }}</h4>
                
                <div class="flex space-x-2 mt-2">
                    @php
                        $mauSacUnique = [];
                    @endphp
                    @foreach ($chiTietSanPham->SanPham->chiTietSanPhams as $chiTiet)
                        @if (isset($chiTiet->mauSac) && !in_array($chiTiet->mauSac->TenMau, $mauSacUnique))
                            <span class="inline-block w-5 h-5 rounded-full border border-gray-300" 
                                style="background-color: {{ $chiTiet->mauSac->TenMau }}"></span>
                            @php
                                $mauSacUnique[] = $chiTiet->mauSac->TenMau;
                            @endphp
                        @endif
                    @endforeach
                </div>
                
                <div class="flex flex-col">
                    <div class="flex mt-1">
                        <p class="text-lg">{{ number_format($chiTietSanPham->SanPham->GiaBan, 0, ',', '.') }} VND</p> 
                        <p class="text-white font-medium text-sm ml-auto border rounded-3xl bg-red-500 hover:text-white px-2 py-1 transition duration-150">-10%</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="flex items-center justify-center mt-10">
        <p class="text-center font-bold border mt-10 w-72 rounded-xl border-black p-3 cursor-pointer hover:bg-gray-100 transition duration-150">Xem thêm</p>
    </div>
</div>
