@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl p-24 mt-14">
    <h1 class="text-4xl font-bold mb-6 text-gray-800">Chi tiết đơn hàng #{{ $order->MaDH }}</h1>

    <div class="bg-white mx-auto shadow-lg border rounded-lg p-8">
        <h2 class="text-2xl font-semibold mb-4 border-b pb-2">Thông tin đơn hàng</h2>
        
        <div class="grid grid-cols-2 gap-6">
            <div class="space-y-3 text-lg">
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

        <h2 class="text-2xl font-semibold mt-6 mb-4 border-b pb-2">Danh sách sản phẩm</h2>
        <ul>
            @if($order->chiTietDonHang && $order->chiTietDonHang->isNotEmpty())
                @foreach($order->chiTietDonHang as $chiTiet)
                    <li class="flex justify-between items-center text-lg py-4 border-b border-gray-200">
                        @if($chiTiet->chiTietSanPham)
                            <div class="flex items-center flex-grow">
                                <img src="{{ asset('images/products/' . $chiTiet->chiTietSanPham->HinhAnh) }}" alt="{{ $chiTiet->chiTietSanPham->TenSP }}" class="w-20 h-20 rounded-lg object-cover mr-4 shadow">
                                <span class="font-bold text-gray-800">{{ $chiTiet->chiTietSanPham->sanPham->TenSP }}</span>
                            </div>
                            <div class="flex-shrink-0 text-right"> 
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
            <a href="{{ url('/order/' . $khachhang->MaKH) }}" class="inline-block bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-500 transition duration-200 shadow-md">Trở về danh sách đơn hàng</a>
        </div>
    </div>
</div>
@endsection
