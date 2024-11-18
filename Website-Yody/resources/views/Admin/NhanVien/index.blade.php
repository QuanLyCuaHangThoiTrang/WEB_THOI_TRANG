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
             <a href="{{ route('nhanvien.create') }}" style ='margin:10px' class="btn btn-primary">Thêm Nhân Viên</a>
            <h4 class="card-title">Danh Sách Nhân Viên</h4>
            <div class="table-responsive">
            <table class="table table-hover">
            <thead>
            <tr>
                <th>Mã NV</th>
                <th>Họ Tên</th>
                <th>Email</th>
                <th>SDT</th>
                <th>Vai Trò</th>
                <th>Hành Động</th>
            </tr>
        </thead>
            <tbody>
                @foreach ($nhanViens as $nhanVien)
                    <tr>
                        <td>{{ $nhanVien->MaNV }}</td>
                        <td>{{ $nhanVien->HoTen }}</td>
                        <td>{{ $nhanVien->Email }}</td>
                        <td>{{ $nhanVien->SDT }}</td>
                        <td>{{ $nhanVien->VaiTro }}</td>
                        <td><a href="{{ route('nhanvien.edit', $nhanVien->MaNV) }}" class="btn btn-dark btn-sm btn-icon-text">
                        <i class="ti-file btn-icon-append"></i>
                          Sửa
                                                    
                        </a>
                        <form action="{{ route('nhanvien.destroy', $nhanVien->MaNV) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-icon-text" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
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


            
         
            
            
        </div>
        
    </div>
        
    </div>
  
@endsection
