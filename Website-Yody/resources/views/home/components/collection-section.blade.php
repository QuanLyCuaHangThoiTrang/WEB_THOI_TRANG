@php
    // Define the translations for each language
    $commonData = [
        'en' => [
            'newProductsTitle' => 'NEW PRODUCTS',
            'viewMore' => 'See More',
        ],
        'vi' => [
            'newProductsTitle' => 'SẢN PHẨM ƯA CHUỘNG',
            'viewMore' => 'Xem thêm',
        ],
    ];

    // Get the language code from the URL
    $locale = request()->segment(1, 'vi'); // Default to 'vi' if no language code in URL

    // Get the translation data for the selected language
    $selectedData = $commonData[$locale] ?? $commonData['vi']; // Fall back to 'vi' if not found
@endphp

<div class="space-y-2 px-8 lg:px-24">
    <div class="mt-4">
        <p class="font-bold text-4xl text-center py-10">{{ $selectedData['newProductsTitle'] }}</p>
    </div>
    <div class="grid gap-3 grid-cols-2 md:grid-cols-2 lg:grid-cols-5">
        @foreach ($SanPhamUaChuongs as $SanPhamUaChuong)         
            <a href="{{ url("{$locale}/product_detail/" . $SanPhamUaChuong->MaSP) }}">
                <div class="rounded cursor-pointer duration-150 flex flex-col fade-item opacity-0 transition-opacity">
                    <div>
                        <img src="{{ asset('images/products/' . $SanPhamUaChuong->HinhAnh) }}" alt=""
                            class="w-full h-full min-w-screen">
                    </div>

                    <h4 class="font-medium flex-grow mt-3 truncate">{{ $SanPhamUaChuong->TenSP }}</h4>

                    <div class="flex justify-between items-center mt-4">
                        @if ($SanPhamUaChuong->GiaGiam == 0 ||$SanPhamUaChuong->GiaGiam == null)
                            <h3 class="gia font-semibold lg:text-lg text-xs sm:text-sm whitespace-nowrap">
                                {{ number_format($SanPhamUaChuong->GiaBan, 0, ',', '.') }} đ</h3>
                        @else
                            <h3 class="font-semibold lg:text-lg text-xs sm:text-sm line-through text-red-500 truncate">
                                {{ number_format($SanPhamUaChuong->GiaBan, 0, ',', '.') }} đ</h3>
                            <h3 class="gia font-semibold lg:text-lg text-xs sm:text-sm truncate">
                                {{ number_format($SanPhamUaChuong->GiaGiam, 0, ',', '.') }} đ</h3>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <div class="flex items-center justify-center mt-10">
        <a href="{{ url("{$locale}/products") }}">
            <p
                class="text-center font-bold border mt-10 w-72 rounded-xl border-black p-3 cursor-pointer hover:bg-gray-100 transition duration-150">
                {{ $selectedData['viewMore'] }}</p>
        </a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Chọn tất cả các phần tử cần fade-in
        const productItems = document.querySelectorAll('.fade-item');

        // Khởi tạo IntersectionObserver
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100'); // Thêm lớp opacity để hiển thị
                    observer.unobserve(entry
                        .target); // Ngừng quan sát phần tử này sau khi nó đã xuất hiện
                }
            });
        }, {
            root: null, // Quan sát từ cửa sổ trình duyệt
            rootMargin: '0px',
            threshold: 0.1 // Phần tử sẽ bắt đầu fade-in khi 10% của nó xuất hiện trong viewport
        });

        // Quan sát các phần tử
        productItems.forEach(item => {
            observer.observe(item);
        });
    });
</script>
