@extends('Admin.welcome')

@section('title', 'Chỉnh Sửa Chi Tiết')

@section('content')

<div class="col-md-6 grid-margin stretch-card">
    <div class="card-body">
        <h3 class="text-black fw-bold" style="color:black; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Chỉnh Sửa Chi Tiết Sản Phẩm</h3>

        <form action="{{ route('chitietsanpham.update', ['MaCTSP' => $detail->MaCTSP]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="size">Size:</label>
                <input type="text" class="form-select" value="{{ $detail->kichThuoc->TenSize }}" disabled>
            </div>

            <div class="form-group">
                <label for="color">Màu sắc:</label>
                <input type="text" class="form-select" value="{{ $detail->mauSac->TenMau }}" disabled>
            </div>

            <div class="form-group">
                <label for="stockQuantity">Số lượng tồn kho:</label>
                <input type="number" name="SoLuongTonKho" class="form-control @error('SoLuongTonKho') is-invalid @enderror" value="{{ $detail->SoLuongTonKho }}" required>
                @error('SoLuongTonKho')
                <span class="invalid-feedback">{{ $message }}</span>
                 @enderror
            </div>

            <div class="form-group">
                <label for="sku">SKU:</label>
                <input type="text" name="SKU" class="form-control @error('SKU') is-invalid @enderror" value="{{ $detail->SKU }}">
                @error('SKU')
                <span class="invalid-feedback">{{ $message }}</span>
                 @enderror
            </div>
            <div class="form-group">
            <label for="img">Hình ảnh hiện tại:</label>
            <div class="current-images">
               
            <div class="image-item">
                <img src="{{ asset('images/products/' . $detail->HinhAnh) }}" alt="Image" width="150">

                <!-- <button type="button" class="btn btn-danger btn-sm remove-image" data-id="{{ $detail->MaCTSP}}">X</button> -->
            </div>
                
            </div>
        </div>

        <div class="form-group">
            <label for="img">Cập nhật hình ảnh khác:</label>
            <input type="file" id="imgInput" name="img" class="form-control @error('img') is-invalid @enderror" multiple>
            @error('img')
                <span class="invalid-feedback">{{ $message }}</span>
                 @enderror
            <div id="newImagesPreview"></div>
        </div>
            <button type="submit" class="btn btn-success">Cập Nhật</button>
            <a href="{{ route('product.details', ['MaSP' => $detail->MaSP]) }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>
@endsection
