@extends('Admin.welcome')

@section('content')
<div class="container">
    <h2 style="color:black; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;margin:10px">Chỉnh sửa danh mục</h2>

    <form id="danhMucForm" action="{{ route('danhmuc.update', $danhmuc->MaDanhMuc) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="TenDanhMuc">Tên Danh Mục:</label>
            <input type="text" name="TenDanhMuc" id="TenDanhMuc" class="form-control @error('TenDanhMuc') is-invalid @enderror" value="{{ old('TenDanhMuc', $danhmuc->TenDanhMuc) }}" required>
            @error('TenDanhMuc')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

       

        <button type="submit" class="btn btn-primary" style="margin:10px">Cập Nhật</button>
    </form>
</div>

@endsection
