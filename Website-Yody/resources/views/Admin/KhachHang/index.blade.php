<!-- resources/views/SanPham/index.blade.php -->
@extends('Admin.welcome')

@section('title', 'Danh sách khách hàng')

@section('content')
<div >
    @if(session()->has('success'))
        <div class="alert alert-danger">{{session('success')}}</div>
    @endif
</div>
<div>
    @if(session()->has('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
    @endif
</div>
    <div>
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
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($khachHangs as $khachHang)
                    <tr>
                        <td>{{ $khachHang->MaKH }}</td>
                        <td>{{ $khachHang->HoTen }}</td>
                        <td>{{ $khachHang->Email }}</td>
                        <td>{{ $khachHang->SDT }}</td>
                        <td>{{ $khachHang->LoaiKH }}</td>
                        <td>
                            <!-- Xóa khách hàng -->
                            <form action="{{ route('khachhang.destroy', $khachHang->MaKH) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-icon-text" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                                <i class="ti-alert btn-icon-prepend"></i>                                                    
                                    Delete
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
        
    </div>
  
@endsection
