@extends('Admin.welcome')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Chi Tiết Đơn Hàng: {{ $donhang->MaDH }}</h2>
        <a href="{{ route('donhang.print', $donhang->MaDH) }}" class="btn btn-dark">
            <i class="ti-file"></i> In Đơn Hàng
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title text-info">Thông Tin Khách Hàng</h5>
            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Mã Khách Hàng:</strong> {{ $donhang->MaKH }}
                </div>
                <div class="col-md-6">
                    <strong>Tên Khách Hàng:</strong> {{ $donhang->khachHang->HoTen }}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Địa Chỉ Giao Hàng:</strong> {{ $donhang->DiaChiGiaoHang }}
                </div>
                <div class="col-md-6">
                    <strong>Ngày Đặt Hàng:</strong> {{ $donhang->NgayDatHang }}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Tổng Giá Trị:</strong> <span class="text-danger">{{ number_format($donhang->TongGiaTri, 0, ',', '.') }} đ</span>
                </div>
                <div class="col-md-6">
                    <strong>Trạng Thái:</strong> <span class="badge badge-success">{{ $donhang->TrangThai }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-info">Chi Tiết Sản Phẩm</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Mã CTSP</th>
                            <th>Tên sản phẩm</th>
                            <th>Màu sắc</th>
                            <th>Size</th>
                            <th>Số Lượng</th>
                            <th>Đơn Giá</th>
                            <th>Thành Tiền</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donhang->chiTietDonHang as $chitiet)
                        <tr>
                            <td>{{ $chitiet->MaCTSP }}</td>
                            <td>{{ $chitiet->chiTietSanPham->sanPham->TenSP }}</td>
                            <td>{{ $chitiet->chiTietSanPham->mauSac->TenMau }}</td> 
                            <td>{{ $chitiet->chiTietSanPham->kichThuoc->TenSize }}</td>
                            <td>{{ $chitiet->SoLuong }}</td>
                            <td>{{ number_format($chitiet->DonGia, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($chitiet->ThanhTien, 0, ',', '.') }} đ</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
