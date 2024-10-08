<div id="search-modal" class="fixed inset-0 z-50 hidden bg-white transition-opacity duration-300 ease-in-out opacity-0">
    <button id="close-search-modal" class="absolute top-4 right-4 p-2 text-gray-600 hover:text-gray-900">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div class="p-4">

        <input type="search" name="query"
            class="w-full px-4 py-2 mb-4 text-sm border border-gray-300 rounded-3xl focus:outline-none focus:ring-blue-500"
            placeholder="Tìm kiếm sản phẩm..." />

        <div>
            <section aria-labelledby="products-heading" class="pb-24 pt-6">

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Filters -->
                    <div class="col-span-3">          
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6 overflow-y-auto max-h-[600px]">
                            @foreach ($sanPhamTKs as $sanPham)
                                <div style="display: none" class="group relative cursor-pointer product-item1"
                                    data-colors="{{ implode(',', $sanPham->chiTietSanPham->pluck('mauSac.TenMau')->toArray()) }}"
                                    data-sizes="{{ implode(',', $sanPham->chiTietSanPham->pluck('kichThuoc.TenSize')->toArray()) }}">
                                    <a href="{{ url('/product_detail/' . $sanPham->MaSP) }}">
                                        <div
                                            class="aspect-h-1 aspect-w-1 w-full overflow-hidden bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                                            <img src="{{ asset('images/products/' . $sanPham->chiTietSanPham->first()->HinhAnh) }}"
                                                alt="Product Image"
                                                class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                                        </div>
                                        <div class="mt-4 pb-3">
                                            <h3 class="text-base">{{ $sanPham->TenSP }}</h3>
                                            <div class="flex space-x-2">
                                                @php
                                                    $mauSacUnique = [];
                                                @endphp
    
                                                @foreach ($sanPham->chiTietSanPham as $chiTiet)
                                                    @if (isset($chiTiet->mauSac) && !in_array($chiTiet->mauSac->TenMau, $mauSacUnique))
                                                        <span
                                                            class="font-semibold rounded-full w-5 h-5 border border-gray-300 flex items-center justify-center cursor-pointer transition duration-200 ease-in-out transform hover:scale-110"
                                                            style="background-color: {{ $chiTiet->mauSac->TenMau }}"></span>
                                                        @php
                                                            $mauSacUnique[] = $chiTiet->mauSac->TenMau; // Lưu màu đã hiển thị
                                                        @endphp
                                                    @endif
                                                @endforeach
    
                                            </div>
                                            @php
                                                $kichThuocUnique = [];
                                            @endphp
                                            <div class="flex space-x-2" style="display:none;">
                                                @foreach ($sanPham->chiTietSanPham as $chiTiet)
                                                    @if (isset($chiTiet->kichThuoc) && !in_array($chiTiet->kichThuoc->TenSize, $kichThuocUnique))
                                                        <span style=""
                                                            class="font-semibold">{{ $chiTiet->kichThuoc->TenSize }}</span>
                                                        @php
                                                            $kichThuocUnique[] = $chiTiet->kichThuoc->TenSize; // Lưu kích thước đã hiển thị
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </div>                                    
                                            <div class="flex justify-between items-center mt-2">                                         
                                                @if ($sanPham->GiaGiam == 0 || $sanPham->GiaGiam == null)
                                                    <h3 class="font-semibold">{{ number_format($sanPham->GiaBan, 0, ',', '.') }} đ</h3> 
                                                @else
                                                <h3 class="font-semibold line-through text-gray-500">{{ number_format($sanPham->GiaBan, 0, ',', '.') }} đ</h3> 
                                                <h3 class="font-semibold">{{ number_format($sanPham->GiaGiam, 0, ',', '.') }} đ</h3> 
                                                @endif                   
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>                  
                    </div>
            </section>
        </div>
    </div>
</div>

<script>
    // JavaScript để mở và đóng modal tìm kiếm trên thiết bị nhỏ
    document.getElementById('search-toggle').addEventListener('click', () => {
        const modal = document.getElementById('search-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
        }, 10); // Thời gian nhỏ để đảm bảo lớp opacity-0 được áp dụng trước khi bắt đầu transition
    });

    document.getElementById('close-search-modal').addEventListener('click', () => {
        const modal = document.getElementById('search-modal');
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // Thời gian trùng khớp với thời gian transition opacity
    });
    const searchInput = document.querySelector('input[name="query"]');
    const productItems = document.querySelectorAll('.product-item1');
    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();
        if (searchTerm === '') {
        // Nếu ô tìm kiếm trống, ẩn tất cả sản phẩm
        productItems.forEach(item => {
            item.style.display = 'none';
        });
    } else {
        productItems.forEach(item => {
            const productName = item.querySelector('h3').textContent.toLowerCase();
            if (productName.includes(searchTerm)) {
                item.style.display = 'block'; // Hiển thị sản phẩm
            } else {
                item.style.display = 'none'; // Ẩn sản phẩm
            }
        });
    }
    });
</script>
