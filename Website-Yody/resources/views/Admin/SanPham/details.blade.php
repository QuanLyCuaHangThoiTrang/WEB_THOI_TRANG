<!-- resources/views/SanPham/details.blade.php -->
@extends('Admin.welcome')

@section('title', 'Chi tiết sản phẩm')

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
    <div class="card">
        <div class="card-body">
            <div style="margin-bottom:10px"> 
            <a href="{{route('product.variants.create', $product->MaSP)}}" class="btn btn-primary btn-icon-text">Create Detail</a>
            </div>
      
            <h4 class="card-title" style="font-weight:bold; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Chi Tiết Sản Phẩm: {{$product->TenSP}}</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã Chi Tiết</th>
                            <th>Image</th>
                            <th>Mã Màu</th>
                            <th>Mã Size</th>
                            <th>Quantity</th>
                            <th>SKU</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productDetails as $detail)
                            <tr>
                                <td>{{$detail->MaCTSP}}</td>
                                <td>
                                @if($detail->HinhAnh)
                                    <img src="{{ asset('images/' . $detail->HinhAnh) }}" alt="{{ $product->TenSP }}" style="width: 60px; height: auto;">
                                @else
                                    <img src="{{ asset('images/default_img.jpg') }}" alt="No Image Available" style="width: 60px; height: auto;">
                                @endif
                                <td>{{$detail->MaMau}}</td>
                                <td>{{$detail->MaSize}}</td>
                                <td>{{$detail->SoLuongTonKho}}</td>
                                <td>{{$detail->SKU}}</td>
                                <!-- <td>{{number_format($detail->GiaBan, 0, ',', '.')}}đ</td> -->
                                <td><a href="{{ route('chitietsanpham.edit', $detail->MaCTSP) }}" class="btn btn-dark btn-sm btn-icon-text">
                                Edit
                                <i class="ti-file btn-icon-append"></i>                          
                                </a>
                                <form action="{{ route('chitietsanpham.destroy', $detail->MaCTSP) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa biến thể này?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon-text">
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
        </div>
    </div>
@endsection
