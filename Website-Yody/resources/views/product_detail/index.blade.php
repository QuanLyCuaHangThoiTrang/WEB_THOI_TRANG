@extends('layouts.app')
@section('content')
    <div class="mt-24">
        <div class="  pt-10 pb-24 px-8 sm:px-16 md:px-32 mx-auto">
            <form action="{{ route('cart.add') }}" method="POST">

                <div class="grid items-start grid-cols-1 lg:grid-cols-2 gap-4 max-lg:gap-12">
                    <div class="w-full lg:sticky top-0 sm:flex gap-4">
                        <div class="hidden sm:space-y-3 sm:block max-sm:hidden max-sm:mb-4">
                            @foreach ($hinhAnhList as $hinhAnh)
                                <img src="{{ asset('images/products/' . $hinhAnh->HinhAnh) }}" alt="Product1"
                                    class="w-full cursor-pointer mx-auto rounded-md hover:scale-110 duration-200 hover:shadow-sm product-thumbnail"
                                    data-image-src="{{ asset('images/products/' . $hinhAnh->HinhAnh) }}" />
                            @endforeach
                        </div>
                        <img src="{{ asset('images/products/' . $chiTietSanPham->HinhAnh) }}" alt="Product"
                            class="main-product-image w-4/5 rounded-md object-cover mx-auto" />
                        <hr class="border w-[200px] justify-center items-center mx-auto mt-2">
                    </div>
                    <!-- 3 hình căn giữa chỉ trên thiết bị di động -->

                    <div>
                        <h2 class="text-xl font-medium text-black">{{ $chiTietSanPham->SanPham->TenSP }}</h2>


                        <div class="flex flex-wrap gap-4 mt-4 items-center">
    @if ($chiTietSanPham->SanPham->GiaGiam != 0 && $chiTietSanPham->SanPham->GiaGiam < $chiTietSanPham->SanPham->GiaBan)
        <p class="text-red-500 text-2xl font-bold">
            {{ number_format($chiTietSanPham->SanPham->GiaGiam, 0, ',', '.') }} đ
        </p>
        <h3 class="font-normal text-gray-400 line-through text-xl">
            {{ number_format($chiTietSanPham->SanPham->GiaBan, 0, ',', '.') }} đ
        </h3>
    @else
        <p class="text-red-500 text-2xl font-bold">
            {{ number_format($chiTietSanPham->SanPham->GiaBan, 0, ',', '.') }} đ
        </p>
    @endif

    <div class="flex justify-center items-center">
        @if ($chiTietSanPham->SanPham->GiaGiam != 0 && $chiTietSanPham->SanPham->GiaGiam < $chiTietSanPham->SanPham->GiaBan)
            <div class="text-red-500 font-medium text-sm lg:text-lg bg-red-100 rounded-2xl px-3 transition duration-150">
                <span class="text-xs sm:text-sm font-medium">
                    {{ -round((($chiTietSanPham->SanPham->GiaBan - $chiTietSanPham->SanPham->GiaGiam) / $chiTietSanPham->SanPham->GiaBan) * 100) }}%
                </span>
            </div>
        @endif
    </div>
</div>

                        <div class="mt-4 space-y-4">
                            <p class="text-black text-medium  mt-2">
                                Còn lại: <span id="stock-quantity" data-quantity = "{{ $SoLuongTonKho }}"
                                    class="text-red-600 font-extrabold">{{ $SoLuongTonKho }}</span> sản phẩm
                            </p>
                            <div class="w-full bg-gray-200 rounded-full h-1" id="stock-progress-container">
                                <div class="bg-green-500 h-1 rounded-full" id="stock-progress" style="width: 0%;"></div>
                            </div>

                        </div>



                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-gray-800">Màu sắc:</h3>
                            <ul class="flex gap-4 mt-4">
                                @foreach ($MauSac as $mauSac)
                                    <li class="flex flex-col items-center">
                                        <input type="radio" id="color_{{ $mauSac->MaMau }}" name="selected_color"
                                            value="{{ $mauSac->MaMau }}" class="hidden color-radio"
                                            data-ma-mau="{{ $mauSac->MaMau }}">
                                        <label for="color_{{ $mauSac->MaMau }}"
                                            style="background-color: {{ $mauSac->TenMau }};"
                                            class="w-14 h-14 rounded-full border border-gray-300 flex items-center justify-center cursor-pointer transition duration-200 ease-in-out transform hover:scale-105"
                                            title="{{ $mauSac->TenMau }}">
                                            <span class="hidden">{{ $mauSac->TenMau }}</span>
                                        </label>

                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-gray-800">Kích thước:</h3>
                            <div class="flex flex-wrap gap-4 mt-4 font-semibold text-sm">
                                <div class="flex gap-4 mt-4 mb-10">
                                    <ul class="flex space-x-4">
                                        @foreach ($KichThuoc as $kt)
                                            <li class="flex flex-col items-center">
                                                <input type="radio" id="size_{{ $kt->MaSize }}" name="selected_size"
                                                    value="{{ $kt->MaSize }}" class="hidden peer size-radio ">
                                                <label for="size_{{ $kt->MaSize }}"
                                                    class="peer-checked:border-black  peer-checked:text-black  border rounded-lg px-5 py-3 text-gray-800 cursor-pointer transition duration-300 hover:bg-gray-200 hover:text-white">
                                                    {{ $kt->TenSize }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-start mt-4 mb-3 space-x-4">
                            <!-- Chọn số lượng -->
                            <div class="flex border rounded-2xl items-center space-x-2 w-full sm:w-auto">
                                <button type="button"
                                    class="decrement p-2 h-11 hover:scale-125 rounded-l-lg focus:outline-none transition duration-200"
                                    onclick="updateQuantity(-1)">
                                    <x-icons.icon name="decrement" />
                                </button>
                                <input id="quantity"
                                    class="w-16 sm:w-24 text-center rounded-md text-gray-800 font-semibold" name="SoLuong"
                                    value="1" readonly>
                                <button type="button"
                                    class="increment p-2 h-11 hover:scale-125 rounded-r-lg focus:outline-none transition duration-200"
                                    onclick="updateQuantity(1)">
                                    <x-icons.icon name="increment" />
                                </button>
                                @csrf
                                <input type="hidden" name="MaSP" value="{{ $chiTietSanPham->SanPham->MaSP }}">
                                <input type="hidden" name="DonGia" value="{{ $chiTietSanPham->SanPham->GiaBan }}">
                                <input type="hidden" name="MaKH" value="KH001">
                                <input type="hidden" name="MaSize" value="">
                                <input type="hidden" name="MaMau" value="">
                            </div>

                            <!-- Nút Thêm vào giỏ hàng -->
                            <button id="add-to-cart-btn" type="submit"
                                class="w-full sm:w-auto lg:w-[300px] min-w-[200px] bg-yellow-400 rounded-xl h-11 px-10 font-bold text-md text-gray-800 transition-all duration-500 hover:bg-yellow-500 shadow-sm border-b-2 border-b-yellow-500 shadow-yellow-300 whitespace-nowrap">
                                Thêm vào giỏ hàng
                            </button>

                        </div>

                        <div id="error-message" class="bg-red-500 text-white p-4 rounded-md text-center"
                            style="display: none;">
                            {{ session('error') }} <span id="countdown" class="font-bold"></span>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-gray-800">Chi tiết sản phẩm</h3>
                            <ul class="space-y-3 list-disc mt-4  text-sm text-gray-800">
                                <p class="text-justify">{{ $chiTietSanPham->SanPham->MoTa }}
                                </p>
                            </ul>
                        </div>
                        @include('product_detail.review.review-section')
                    </div>
                </div>
        </div>
        </form>

    </div>
    </form>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorMessage = document.getElementById('error-message');
            const countdownDisplay = document.getElementById('countdown');
            const countdownTime = 8; // Thời gian đếm ngược là 5 giây
            let timeLeft = countdownTime;

            if (errorMessage.textContent.trim() !== '') {
                // Hiển thị thông báo
                errorMessage.style.display = 'block';
                countdownDisplay.textContent = ` (${timeLeft})`; // Hiển thị thời gian còn lại

                // Đếm ngược
                const countdownInterval = setInterval(() => {
                    timeLeft--;
                    countdownDisplay.textContent = ` (${timeLeft})`; // Cập nhật thời gian còn lại

                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval); // Dừng bộ đếm
                        errorMessage.style.display = 'none'; // Ẩn thông báo
                    }
                }, 1000); // Cập nhật mỗi giây
            }
        });
        // Kiểm tra số lượng không được quá số lượng tồn kho
        function updateQuantity(change) {
            const quantityInput = document.getElementById('quantity');
            const stockQuantity = parseInt(document.getElementById('stock-quantity').textContent.trim());
            console.log(stockQuantity);
            let currentValue = parseInt(quantityInput.value);
            console.log(currentValue);
            currentValue += change;
            // Đảm bảo số lượng không âm
            if (currentValue < 1) {
                currentValue = 1;
            }
            if (currentValue > stockQuantity) {
                currentValue = stockQuantity;
            }
            quantityInput.value = currentValue;

        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.querySelectorAll('.color-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedColor = this.dataset.maMau;
                document.querySelector('input[name="MaMau"]').value = selectedColor;
            });
        });

        $(document).ready(function() {
            $('.color-radio').on('change', function() {
                var maMau = this.dataset.maMau; // Lấy mã màu từ thuộc tính data-ma-mau
                var maSP =
                    '{{ $chiTietSanPham->SanPham->MaSP }}'; // Lấy mã sản phẩm từ blade (hoặc điều chỉnh nếu cần)
                updateProductImage(maSP, maMau);
            });

            function updateProductImage(maSP, maMau) {
                $.ajax({
                    url: '/get-image', // Đường dẫn đến hàm getImageByMaSPAndMaMau
                    type: 'GET',
                    data: {
                        maSP: maSP,
                        maMau: maMau
                    },
                    success: function(response) {
                        if (response.HinhAnh) {
                            // Cập nhật src của thẻ <img> với đường dẫn hình ảnh mới
                            $('.main-product-image').attr('src', response.HinhAnh);
                        } else {
                            console.error('Không tìm thấy hình ảnh.');
                        }
                    },
                    error: function() {
                        console.error('Lỗi khi lấy hình ảnh.');
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const colorRadios = document.querySelectorAll('.color-radio');
            const sizeRadios = document.querySelectorAll('.size-radio');
            const stockQuantitySpan = document.getElementById('stock-quantity');
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            const mainProductImage = document.querySelector('.main-product-image');
            // Lấy tất cả các ảnh thu nhỏ (thumbnail)
            const thumbnails = document.querySelectorAll('.product-thumbnail');
            const stockProgressBar = document.getElementById('stock-progress');
            let lastSelectedSize = null; // Biến để lưu kích thước đã chọn trước đó
            const maxStock = 100;
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    // Thay đổi src của ảnh chính bằng giá trị của thuộc tính data-image-src
                    mainProductImage.src = this.dataset.imageSrc;
                });
            });

            function updateStockAndProgress() {
                // Lấy số lượng tồn kho từ thuộc tính `data-quantity`
                const stockQuantity = parseInt(stockQuantitySpan.dataset.quantity);
                const stockPercentage = (stockQuantity / maxStock) * 100;

                // Cập nhật thanh progress bar
                stockProgressBar.style.width = `${stockPercentage}%`;
                stockProgressBar.classList.remove('bg-red-500', 'bg-yellow-500', 'bg-green-500');

                if (stockPercentage <= 20) {
                    stockProgressBar.classList.add('bg-red-500');
                } else if (stockPercentage <= 40) {
                    stockProgressBar.classList.add('bg-yellow-500');
                } else {
                    stockProgressBar.classList.add('bg-green-500');
                }
            }

            function updateStockAndSizes() {
                const selectedColor = document.querySelector('input[name="selected_color"]:checked');
                const selectedSize = document.querySelector('input[name="selected_size"]:checked');
                if (selectedColor) {
                    const colorCode = selectedColor.value;
                    const sizeCode = selectedSize ? selectedSize.value : lastSelectedSize;

                    // Lấy thông tin chi tiết của sản phẩm với màu và kích thước đã chọn
                    const productDetails = @json($chiTietSanPhamList);
                    let key = sizeCode ? `${colorCode}-${sizeCode}` : colorCode;
                    const selectedDetails = productDetails[key];

                    if (selectedDetails) {
                        // Cập nhật số lượng tồn kho
                        stockQuantitySpan.textContent = `${selectedDetails.SoLuongTonKho}`;
                        stockQuantitySpan.dataset.quantity = selectedDetails.SoLuongTonKho;
                        // Hiển thị nút "Thêm vào giỏ hàng"
                        addToCartBtn.style.display = selectedDetails.SoLuongTonKho > 0 ? 'inline' : 'none';

                        // Giữ lại kích thước đã chọn
                        if (sizeCode) {
                            lastSelectedSize = sizeCode;
                        }
                    } else {
                        // Nếu không có thông tin cho sự kết hợp màu và kích thước này
                        if (sizeCode) {
                            // Thông báo khi không có kích thước cho màu đã chọn

                            stockQuantitySpan.textContent = '(0)';

                            // Ẩn nút "Thêm vào giỏ hàng"
                            addToCartBtn.style.display = 'none';
                        } else {
                            // Cập nhật số lượng tồn kho cho màu nếu không có kích thước cụ thể
                            const colorDetails = Object.values(productDetails).find(details => details.MaMau ===
                                colorCode);
                            stockQuantitySpan.textContent = colorDetails ? `(${colorDetails.SoLuongTonKho})` :
                                '(0)';

                            // Hiển thị hoặc ẩn nút "Thêm vào giỏ hàng" dựa trên số lượng tồn kho
                            addToCartBtn.style.display = colorDetails && colorDetails.SoLuongTonKho > 0 ? 'inline' :
                                'none';
                        }
                    }
                    updateStockAndProgress();
                }
            }

            function updateSizeVisibility(colorCode) {
                // Hiện/ẩn kích thước dựa trên màu sắc đã chọn
                sizeRadios.forEach(radio => {
                    const sizeCode = radio.value;
                    const key = `${colorCode}-${sizeCode}`;
                    const sizeAvailable = Object.keys(@json($chiTietSanPhamList)).includes(key);

                    if (sizeAvailable) {
                        radio.parentElement.style.display = 'inline'; // Hiển thị kích thước
                    } else {
                        radio.parentElement.style.display = 'none'; // Ẩn kích thước
                    }
                });
            }

            function selectDefaultSizeForColor(colorCode) {
                // Cập nhật kích thước dựa trên màu sắc đã chọn
                updateSizeVisibility(colorCode);

                // Tìm kích thước đầu tiên có sẵn cho màu sắc mới
                const availableSizes = Array.from(sizeRadios).filter(radio => {
                    const sizeCode = radio.value;
                    const key = `${colorCode}-${sizeCode}`;
                    return Object.keys(@json($chiTietSanPhamList)).includes(key);
                });

                if (availableSizes.length > 0) {
                    availableSizes[0].checked = true;
                    lastSelectedSize = availableSizes[0].value;
                    updateStockAndSizes();
                } else {
                    lastSelectedSize = null;
                    updateStockAndSizes();
                }
            }

            colorRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    updateStockAndSizes();
                    selectDefaultSizeForColor(radio.value);
                });
            });

            sizeRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    lastSelectedSize = radio.value; // Cập nhật kích thước đã chọn
                    updateStockAndSizes();
                });
            });

            // Khởi tạo với màu sắc đầu tiên nếu có
            if (colorRadios.length > 0) {
                colorRadios[0].checked = true;
                selectDefaultSizeForColor(colorRadios[0].value);
            }
        });
    </script>
@endsection
