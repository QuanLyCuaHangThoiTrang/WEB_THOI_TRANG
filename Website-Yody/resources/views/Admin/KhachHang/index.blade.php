@extends('Admin.welcome')

@section('title', 'Danh sách khách hàng')

@section('content')
    <div>
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>
    <div>
        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Danh Sách Khách Hàng</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã KH</th>
                            <th>Họ Tên</th>
                            <th>Email</th>
                            <th>SDT</th>
                            <th>Loại KH</th>
                            <th>Điểm Tích Lũy</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($khachHangs as $khachHang)
                            <tr style="{{ $khachHang->SoVoucher >= 5 ? 'background-color:#7ED4AD;' : '' }}">
                                <td>
                                    @if ($khachHang->SoVoucher >= 5)
                                        <span class="text-warning">⭐</span>
                                    @endif
                                    {{ $khachHang->MaKH }}
                                </td>
                                <td>{{ $khachHang->HoTen }}</td>
                                <td>{{ $khachHang->Email }}</td>
                                <td>{{ $khachHang->SDT }}</td>
                                <td>{{ $khachHang->LoaiKH }}</td>
                                <td>{{ $khachHang->DiemTichLuy }}</td>
                                <td>
                                    <!-- Xóa khách hàng -->
                                    <form action="{{ route('khachhang.destroy', $khachHang->MaKH) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-icon-text"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này không?');">
                                            <i class="ti-alert btn-icon-prepend"></i>
                                            Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top:10px" class="pagination-container d-flex justify-content-center">
                {{ $khachHangs->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
