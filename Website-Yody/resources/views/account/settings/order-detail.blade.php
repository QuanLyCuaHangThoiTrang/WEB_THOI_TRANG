@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl p-6 lg:p-24 mt-14">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

        {{-- Cột bên trái: Chi tiết đơn hàng --}}
        <div class="bg-white shadow-lg border rounded-lg p-6 lg:p-8">
            <h1 class="text-2xl lg:text-4xl font-bold mb-6 text-gray-800">Chi tiết đơn hàng #{{ $order->MaDH }}</h1>
            
            {{-- Hiển thị thông báo thành công --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            <h2 class="text-xl lg:text-2xl font-semibold mb-4 border-b pb-2">Thông tin đơn hàng</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                <div class="space-y-3 text-base lg:text-lg">
                    <p><strong>Ngày đặt hàng:</strong> {{ \Carbon\Carbon::parse($order->NgayDatHang)->format('d/m/Y') }}</p>
                    <p><strong>Tổng giá trị:</strong> <span class="font-semibold">{{ number_format($order->TongGiaTri, 0, ',', '.') }} VND</span></p>
                    <p><strong>Trạng thái:</strong> 
                        <span class="{{ $order->TrangThai == 'Giao thành công' ? 'text-green-600' : ($order->TrangThai == 'Đã hủy' ? 'text-red-600' : 'text-gray-900') }}">
                            {{ $order->TrangThai }}
                        </span>
                    </p>
                    <p><strong>Phương thức thanh toán:</strong> {{ $order->PhuongThucThanhToan }}</p>
                </div>
            </div>

            <h2 class="text-xl lg:text-2xl font-semibold mt-6 mb-4 border-b pb-2">Danh sách sản phẩm</h2>
            <ul>
                @if($order->chiTietDonHang && $order->chiTietDonHang->isNotEmpty())
                    @foreach($order->chiTietDonHang as $chiTiet)
                        <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-base lg:text-lg py-4 border-b border-gray-200">
                            @if($chiTiet->chiTietSanPham)
                                <div class="flex items-start sm:items-center flex-grow">
                                    <img src="{{ asset('images/products/' . $chiTiet->chiTietSanPham->HinhAnh) }}" alt="{{ $chiTiet->chiTietSanPham->TenSP }}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg object-cover mr-4 shadow">
                                    <span class="font-bold text-gray-800">{{ $chiTiet->chiTietSanPham->sanPham->TenSP }}</span>
                                </div>
                                <div class="flex-shrink-0 text-right mt-2 sm:mt-0"> 
                                    <span class="block text-gray-600">{{ number_format($chiTiet->ThanhTien, 0, ',', '.') }} VND x {{ $chiTiet->SoLuong }}</span>
                                </div>
                            @else
                                <span class="font-bold">{{ $chiTiet->MaCTSP }}</span>
                                <span>{{ number_format($chiTiet->ThanhTien, 0, ',', '.') }} VND x {{ $chiTiet->SoLuong }}</span>
                            @endif
                        </li>
                    @endforeach
                @else
                    <p class="text-gray-600">Không có sản phẩm nào trong đơn hàng này.</p>
                @endif
            </ul>
            
            <div class="mt-6 flex justify-end">
                <a href="{{ url('/order/' . $khachhang->MaKH) }}" class="inline-block bg-blue-600 text-white py-2 px-4 lg:px-6 rounded-lg hover:bg-blue-500 transition duration-200 shadow-md">Trở về danh sách đơn hàng</a>
            </div>
        </div>

        {{-- Cột bên phải: Đánh giá sản phẩm --}}
        <div>
            @if($canRate && !session('rated')) <!-- Kiểm tra xem đã gửi đánh giá hay chưa -->
            <div class="bg-white p-4 lg:p-5 rounded-lg border shadow-lg">
                <div class="bg-blue-900">
                    <h3 class="text-2xl lg:text-3xl text-center font-semibold text-white py-3 uppercase mb-4">Đánh giá sản phẩm</h3>
                </div>
                <form action="{{ route('orders.rate', ['maKH' => $khachhang->MaKH, 'maCTSP' => $order->chiTietDonHang->first()->chiTietSanPham->MaCTSP]) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-lg lg:text-xl font-medium text-gray-700 mb-2">Điểm đánh giá:</label>
                        <div class="flex items-center justify-center space-x-1" id="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" id="star{{ $i }}" name="DiemDanhGia" value="{{ $i }}" class="hidden peer" required>
                                <label for="star{{ $i }}" class="cursor-pointer text-gray-400 transition duration-300 ease-in-out hover:text-yellow-400" onmouseover="highlightStars({{ $i }})" onmouseleave="resetStars()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-8 h-8 sm:w-10 sm:h-10">
                                        <path d="M12 .587l3.668 7.568 8.332 1.215-6.003 5.854 1.42 8.288L12 18.897l-7.417 3.897 1.42-8.288-6.003-5.854 8.332-1.215z"/>
                                    </svg>
                                </label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="NoiDung" class="block text-base lg:text-lg font-medium text-gray-700 mb-2">Nội dung:</label>
                        <textarea name="NoiDung" class="mt-1 h-40 lg:h-[400px] block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2" rows="4" placeholder="Nhập nội dung đánh giá"></textarea>
                    </div>
                    <div class="justify-center text-center">
                        <button type="submit" class="bg-blue-700 text-white py-2 lg:py-3 px-4 rounded-md hover:bg-blue-600 transition duration-300 font-bold shadow-md transform hover:scale-105">Gửi đánh giá</button>
                    </div>
                </form>
            </div>
            @endif
        </div>

    </div>
</div>

<script>
    function highlightStars(rating) {
        const stars = document.querySelectorAll('#rating-stars label');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('text-yellow-400');
                star.classList.remove('text-gray-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-400');
            }
        });
    }

    function resetStars() {
        const stars = document.querySelectorAll('#rating-stars label');
        stars.forEach(star => {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-400');
        });
        const checkedStar = document.querySelector('#rating-stars input:checked + label');
        if (checkedStar) {
            checkedStar.classList.add('text-yellow-400');
            checkedStar.classList.remove('text-gray-400');
            const index = Array.from(stars).indexOf(checkedStar);
            for (let i = 0; i < index; i++) {
                stars[i].classList.add('text-yellow-400');
                stars[i].classList.remove('text-gray-400');
            }
        }
    }
</script>

@endsection
