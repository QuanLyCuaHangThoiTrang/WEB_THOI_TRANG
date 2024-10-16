<!-- resources/views/SanPham/index.blade.php -->
@extends('Admin.welcome')

@section('title', 'Danh sách sản phẩm')

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
            <div>
            <a href="{{route('product.create')}}" class="btn btn-primary btn-icon-text">Create a Product</a>
            </div>
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                <th>Mã SP</th>
                <th>Hình Ảnh</th>
                <th>Tên Sản Phẩm</th>
                <!-- <th>Mô Tả</th> -->
                <th>Mã Danh Mục</th>
                <th>Tổng SL</th>
                <th>Giá Bán</th>
                <th>Trạng Thái</th>
                <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product )
                <tr>
                    <td>{{$product->MaSP}}</td>
                    <td>
                    @if($product->chitietsanphams->isNotEmpty())
                        <img src="{{ asset('images/' . $product->chitietsanphams->first()->HinhAnh) }}" alt="{{ $product->TenSP }}" style="width: 60px; height: auto;">
                    @else
                        <img src="{{ asset('images/default_img.jpg') }}" alt="No Image Available" style="width: 60px; height: auto;">
                    @endif
                    <td>{{$product->TenSP}}</td>
                    <!-- <td class="text-danger">{!! Str::limit($product->MoTa, 50) !!}</td> -->
                    <td><label class="badge badge-danger">{{$product->MaCTDM}}</label></td>
                    <td>{{$product->TongSL}}</td>
                    <td>{{$product->GiaBan}}</td>
                    <td>
                    <span class="status-toggle" data-id="{{ $product->MaSP }}" style="cursor:pointer; display: flex; justify-content: center; align-items: center">
                        @if($product->TrangThai == 1)
                            <i class="mdi mdi-check-circle" style="color:green; font-size: 24px;"></i>
                        @else
                            <i class="mdi mdi-close-circle" style="color:red;font-size: 24px;"></i>
                        @endif
                    </span>
                        </td>
                    <td><a href="{{ route('product.edit', $product->MaSP) }}" class="btn btn-dark btn-sm btn-icon-text">
                        <i class="ti-file btn-icon-append"></i>
                          Edit
                                                    
                        </a>
                        <form action="{{ route('product.destroy', $product->MaSP) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-icon-text" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                                <i class="ti-alert btn-icon-prepend"></i>                                                    
                                    Delete
                            </button>
                        </form>
                       
                        <a href="{{ route('product.details', $product->MaSP) }}" class="btn btn-primary btn-sm btn-icon-text">
                        <i class="mdi mdi-library-books"></i>                                                    
                        Detail
                    </a> 
                        
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            <div style="margin-top:10px" class="pagination-container d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>


            
            
            
            
        </div>
        
    </div>
        
    </div>

@endsection
