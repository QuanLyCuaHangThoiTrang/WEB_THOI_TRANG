<form class="hidden lg:block">
    <div>
        <ul role="list" class="space-y-4 border-gray-200 pb-6 text-xl font-medium text-gray-900">
            <li><a href="{{ url('/account/' . $khachhang->MaKH) }}">Tài khoản</a></li>
            <li><a href="{{ url('/addresses/' . $khachhang->MaKH) }}">Địa chỉ</a></li>
            <li><a href="{{ url('/vouchers/' . $khachhang->MaKH) }}">Phiếu giảm giá</a></li>
            <li><a href="{{ url('/order/' . $khachhang->MaKH) }}">Đơn hàng</a></li>
        </ul>
    </div>
</form>
