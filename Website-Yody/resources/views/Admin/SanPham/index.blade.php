@extends('Admin.welcome')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div>
    @if(session()->has('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif
</div>
<div>
    @if(session()->has('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{route('product.create')}}" class="btn btn-primary btn-icon-text">Tạo Sản Phẩm</a>
        </div>

        <div class="row">
    <div class="col-md-6">
        <!-- Form tìm kiếm nằm bên trái -->
        <form method="GET" action="{{ route('product.index') }}" class="form-inline">
            <input type="text" name="search" class="form-control mr-2 w-40" placeholder="Tìm kiếm theo tên sản phẩm" value="{{ request('search') }}" style="width:300px; margin-bottom:10px">
            <button type="submit" class="btn btn-outline-primary">Tìm Kiếm</button>
        </form>
    </div>
    <div class="col-md-6 d-flex justify-content-end">
        <!-- Form sắp xếp nằm bên phải -->
        <form method="GET" action="{{ route('product.index') }}" class="form-inline">
            <select name="sort" class="form-control mr-2" onchange="this.form.submit()" style="width: 150px;">
                <option value="">Sắp xếp</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá : Thấp - Cao</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá : Cao - Thấp</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên: A - Z</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên: Z - A</option>
            </select>
        </form>
    </div>
</div>


        <!-- Bảng sản phẩm -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã SP</th>
                        <th>Hình Ảnh</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Mã Danh Mục</th>
                        <th>Tổng SL</th>
                        <th>Giá Bán</th>
                        <th>Trạng Thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->MaSP }}</td>
                        <td>
                            @if($product->chitietsanphams->isNotEmpty())
                                <img src="{{ asset('images/products/' . $product->chitietsanphams->first()->HinhAnh) }}" alt="{{ $product->TenSP }}" style="width: 60px; height: auto;">
                            @else
                                <img src="{{ asset('images/products/default_img.jpg') }}" alt="No Image Available" style="width: 60px; height: auto;">
                            @endif
                        </td>
                        <td>{{ $product->TenSP }}</td>
                        <td><label class="badge badge-danger">{{ $product->MaCTDM }}</label></td>
                        <td>{{ $product->TongSL }}</td>
                        <td>{{ number_format($product->GiaBan, 0, ',', '.') }}đ</td>
                        <td>
                            <span class="status-toggle" data-id="{{ $product->MaSP }}" style="cursor:pointer; display: flex; justify-content: center; align-items: center">
                                @if($product->TrangThai == 1)
                                    <i class="mdi mdi-check-circle" style="color:green; font-size: 24px;"></i>
                                @else
                                    <i class="mdi mdi-close-circle" style="color:red; font-size: 24px;"></i>
                                @endif
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('product.edit', $product->MaSP) }}" class="btn btn-dark btn-sm btn-icon-text">
                                <i class="ti-file btn-icon-append"></i> Sửa
                            </a>
                            <form action="{{ route('product.destroy', $product->MaSP) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-icon-text" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                                    <i class="ti-alert btn-icon-prepend"></i> Xóa
                                </button>
                            </form>
                            <a href="{{ route('product.details', $product->MaSP) }}" class="btn btn-primary btn-sm btn-icon-text">
                                <i class="mdi mdi-library-books"></i> Chi Tiết
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div style="margin-top:10px" class="pagination-container d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
