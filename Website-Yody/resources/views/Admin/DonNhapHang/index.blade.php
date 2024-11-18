<!-- resources/views/SanPham/index.blade.php -->
@extends('Admin.welcome')

@section('title', 'Danh sách Đơn nhập hàng')

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
            <h4 class="card-title">Danh Sách Đơn Nhập Hàng</h4>
            <div>
            <a href="{{route('donnhaphang.create')}}" class="btn btn-primary btn-icon-text">Tạo Đơn Nhập Hàng</a>
            </div>
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                <th>Mã NH</th>
                <th>Mã NCC</th>
                <th>Ngày Nhập Hàng</th>
                <th>Tổng Giá trị</th>
                <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach($donnhaphangs as $donnhaphang )
                <tr>
                    <td>{{$donnhaphang->MaNH}}</td>
                    <td>{{$donnhaphang->MaNCC}}</td>
                    <td>{{$donnhaphang->NgayDatHang}}</td>
                    <td>{{ number_format($donnhaphang->TongGiaTri, 0, ',', '.')}}đ</td>
                  
                    <td><a href="{{ route('donnhaphang.edit', $donnhaphang->MaNH) }}" class="btn btn-dark btn-sm btn-icon-text">
                        <i class="ti-file btn-icon-append"></i>
                          Sửa
                                                    
                        </a>
                        <form action="{{ route('donnhaphang.destroy', $donnhaphang->MaNH) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-icon-text" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                                <i class="ti-alert btn-icon-prepend"></i>                                                    
                                    Xóa
                            </button>
                        </form>
                       
                        <a href="{{ route('donnhaphang.show', $donnhaphang->MaNH) }}" class="btn btn-primary btn-sm btn-icon-text">
                        <i class="mdi mdi-library-books"></i>                                                    
                        Chi Tiết
                    </a> 
                        
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
