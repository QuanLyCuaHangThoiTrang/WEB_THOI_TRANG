@extends('Admin.welcome')

@section('title', 'Tạo danh mục')

@section('content')
    <div class="card">
                <div class="card-body">
                <h2 style="color:black; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;margin:10px">Tạo danh mục mới</h2>

    <form method="post" action="{{route('danhmuc.store')}}" class="forms-sample" enctype="multipart/form-data">
        @csrf 
        @method('post')

        <div class="form-group row">
            <label for="TenSP">Tên Danh Mục</label>
            <div class="col-sm-9">
            <input type="text" class="form-control @error('TenDanhMuc') is-invalid @enderror" name="TenDanhMuc" id="TenDanhMuc" placeholder="Tên Danh Mục">
            @error('TenDanhMuc')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            </div>
        </div>
        
        <div>
            <input type="submit" value="Lưu" class="btn btn-primary me-2" />
        </div>
    </form>
    </div> 
    </div> 
@endsection