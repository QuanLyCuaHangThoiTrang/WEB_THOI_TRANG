<div class="space-y-2 px-8 lg:px-24">
    <div class="mt-4">
        <p class="font-bold text-4xl text-center py-10">SẢN PHẨM ƯA CHUỘNG</p>
    </div>
    <div class="grid gap-3 grid-cols-2 md:grid-cols-2 lg:grid-cols-5">
        @foreach ($chiTietSanPhams->take(10) as $chiTietSanPham)
            <a href="{{ url('/product_detail/' . $chiTietSanPham->MaSP) }}">
                <div class="rounded cursor-pointer duration-150 flex flex-col">
                    <div>
                        <img src="{{ asset('images/products/' . $chiTietSanPham->HinhAnh) }}" alt=""
                            class="w-full h-full min-w-screen">
                    </div>

                    <h4 class="font-meidum flex-grow mt-3 truncate">{{ $chiTietSanPham->SanPham->TenSP }}</h4>

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

                    <div class="flex justify-between items-center mt-4">
                        @if ($chiTietSanPham->SanPham->GiaGiam == 0 || $chiTietSanPham->SanPham->GiaGiam == null)
                            <h3 class="gia font-semibold lg:text-lg">
                                {{ number_format($chiTietSanPham->SanPham->GiaBan, 0, ',', '.') }} đ</h3>
                        @else
                            <h3 class="font-semibold lg:text-lg line-through text-red-500">
                                {{ number_format($chiTietSanPham->SanPham->GiaBan, 0, ',', '.') }} đ</h3>
                            <h3 class="gia font-semibold lg:text-lg">
                                {{ number_format($chiTietSanPham->SanPham->GiaGiam, 0, ',', '.') }} đ</h3>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <div class="flex items-center justify-center mt-10">
        <<<<<<< HEAD <p
            class="text-center font-bold border mt-10 w-72 rounded-xl border-gray-600 p-3 cursor-pointer hover:bg-gray-100 transition duration-150">
            =======
            <a href="{{ url('/products') }}">
                <p
                    class="text-center font-bold border mt-10 w-72 rounded-xl border-black p-3 cursor-pointer hover:bg-gray-100 transition duration-150">
                    >>>>>>> f78379dc8b98e68baebbd0f56cfc57a3b2fbd9ba
                    Xem thêm</p>
            </a>

    </div>
</div>
