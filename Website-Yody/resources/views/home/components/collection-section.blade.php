<div class="space-y-2 px-8 lg:px-24">
    <div class="mt-4">
        <p class="font-bold text-4xl text-center py-10">SẢN PHẨM MỚI NHẤT</p>
    </div>
    <div class="grid gap-3 grid-cols-2 md:grid-cols-2 lg:grid-cols-5">
        @foreach ($SanPhamMoiNhat as $chiTietSanPham)
            <a href="{{ url('/product_detail/' . $chiTietSanPham->MaSP) }}">
                <div
                    class="rounded cursor-pointer duration-150 flex flex-col fade-item opacity-0 transition-opacity duration-700">
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

        <a href="{{ url('/products') }}">
            <p
                class="text-center font-bold border mt-10 w-72 rounded-xl border-black p-3 cursor-pointer hover:bg-gray-100 transition duration-150">
                Xem thêm</p>
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
