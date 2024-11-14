<div id="search-modal"
    class="fixed inset-0 z-50 hidden bg-white transition-opacity duration-300 ease-in-out rounded-b-3xl shadow-2xl opacity-0 w-full h-[800px]">
    <button id="close-search-modal" class="absolute top-4 right-4 p-2 text-gray-600 hover:text-gray-900">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div class="p-4 max-h-[calc(100vh-100px)] overflow-y-auto">
        <input type="search" name="query"
            class="w-full px-4 py-2 mb-4 text-sm border border-gray-300 rounded-3xl focus:outline-none focus:ring focus:ring-blue-500"
            placeholder="Tìm kiếm sản phẩm..." />
        <!-- Thông báo khi chưa nhập -->
        <p id="no-search-text" class="text-center text-gray-500 mt-8">Bạn chưa nhập nội dung tìm kiếm.</p>
        <div
            class="grid grid-cols-1 md:grid-cols-3 xmd:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 mx-auto px-12 gap-8 md:gap-x-3 md:gap-y-5 md:pt-12 md:pb-[4.5rem]">
            <div class="col-span-full w-full md:col-span-2 xmd:col-span-3 lg:col-span-4 xl:col-span-5">
                <div
                    class="grid gap-x-3 gap-y-5 px-4 md:px-0 md:gap-y-10 grid-cols-2 xmd:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 mb-5 md:mb-4">        
                    @foreach ($sanPhamTKs as $sanPham)                   
                    <div class="group relative cursor-pointer items-center justify-center product-item1 hidden"
                        data-colors="{{ implode(',', $sanPham->chiTietSanPham->pluck('mauSac.TenMau')->toArray()) }}"
                        data-sizes="{{ implode(',', $sanPham->chiTietSanPham->pluck('kichThuoc.TenSize')->toArray()) }}">
                        <a href="{{ url('/product_detail/' . $sanPham->MaSP) }}">
                            <div
                                class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200 group-hover:opacity-75">
                                <img src="{{ asset('images/products/' . $sanPham->chiTietSanPham->first()->HinhAnh) }}"
                                    alt="Product Image" class="h-full w-full object-cover object-center">
                            </div>
                            <div class="mt-4">
                                <h3 class="text-base flex-grow truncate ">{{ $sanPham->TenSP }}</h3>
                                <div class="flex space-x-2 mt-2">
                                    @php
                                        $mauSacUnique = [];
                                    @endphp
                                    @foreach ($sanPham->chiTietSanPham as $chiTiet)
                                        @if (isset($chiTiet->mauSac) && !in_array($chiTiet->mauSac->TenMau, $mauSacUnique))
                                            <span class="inline-block w-5 h-5 rounded-full border border-gray-300"
                                                style="background-color: {{ $chiTiet->mauSac->TenMau }}"></span>
                                            @php
                                                $mauSacUnique[] = $chiTiet->mauSac->TenMau;
                                            @endphp
                                        @endif
                                    @endforeach
                                </div>
                                <div class="mt-2 flex justify-between items-center">
                                    @if ($sanPham->GiaGiam == 0 || $sanPham->GiaGiam == null)
                                        <span
                                            class="text-lg font-semibold">{{ number_format($sanPham->GiaBan, 0, ',', '.') }}
                                            đ</span>
                                    @else
                                        <span
                                            class="line-through text-gray-500">{{ number_format($sanPham->GiaBan, 0, ',', '.') }}
                                            đ</span>
                                        <span
                                            class="text-lg font-semibold text-red-500">{{ number_format($sanPham->GiaGiam, 0, ',', '.') }}
                                            đ</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('search-toggle').addEventListener('click', () => {
        const modal = document.getElementById('search-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
        }, 10);
    });

    document.getElementById('close-search-modal').addEventListener('click', () => {
        const modal = document.getElementById('search-modal');
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    });

    const searchInput = document.querySelector('input[name="query"]');
    const productItems = document.querySelectorAll('.product-item1');
    const noSearchText = document.getElementById('no-search-text');

    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();

        if (searchTerm === '') {
            noSearchText.style.display = 'block';
            productItems.forEach(item => {
                item.style.display = 'none';
            });
        } else {
            noSearchText.style.display = 'none';
            productItems.forEach(item => {
                const productName = item.querySelector('h3').textContent.toLowerCase();
                if (productName.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    });
</script>
