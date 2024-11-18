<!-- resources/views/SanPham/index.blade.php -->
@extends('Admin.welcome')

@section('title', 'Danh sách danh mục')

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
            <h4 class="card-title">Danh Sách Khuyến Mãi</h4>
            <div>
            <a href="{{route('khuyenmai.create')}}" class="btn btn-primary btn-icon-text">Tạo Khuyến Mãi</a>
            </div>
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                <th>Mã KM</th>
                <th>Tên Khuyến Mãi</th>
                <th>Mô Tả</th>
                <th>Phần Trăm</th>
                <th>Bắt Đầu</th>
                <th>Kết Thúc</th>
                <th>Hành Động</th>
                </tr>
                </thead>
                <tbody>
                @foreach($khuyenMais as $khuyenMai )
                <tr>
                    <td>{{$khuyenMai->MaKM}}</td>
                    <td>{{$khuyenMai->TenKM}}</td>
                    <td>{!!$khuyenMai->MoTa!!}</td>
                    <td>{{$khuyenMai->PhanTramGiamGia}}</td>
                    <td>{{$khuyenMai->NgayBatDau}}</td>
                    <td>{{$khuyenMai->NgayKetThuc}}</td>
                    <td><a href="{{ route('khuyenmai.edit', $khuyenMai->MaKM) }}" class="btn btn-dark btn-sm btn-icon-text">
                        <i class="ti-file btn-icon-append"></i>
                          Sửa
                                                    
                        </a>
                        <form action="{{ route('khuyenmai.destroy', $khuyenMai->MaKM) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-icon-text" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?');">
                                <i class="ti-alert btn-icon-prepend"></i>                                                    
                                    Xóa
                            </button>
                        </form>
                       
                        <a href="{{ route('khuyenmai.show', $khuyenMai->MaKM) }}" class="btn btn-primary btn-sm btn-icon-text">
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
