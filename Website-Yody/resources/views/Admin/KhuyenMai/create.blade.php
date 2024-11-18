@extends('Admin.welcome')

@section('title', 'Tạo khuyến mãi')

@section('content')
    <div class="card">
                <div class="card-body">
    <form method="post" action="{{route('khuyenmai.store')}}" class="forms-sample" enctype="multipart/form-data">
        @csrf 
        @method('post')
        <div class="form-group row">
            <label for="TenKM">Tên Khuyến Mãi</label>
            <div class="col-sm-9">
            <input type="text" class="form-control @error('TenKM') is-invalid @enderror" name="TenKM" id="TenKM" placeholder="Tên Khuyến Mãi">
            @error('TenKM')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror   
        </div>
        </div>
        <div class="form-group row">
            <label for="MoTa">Mô Tả</label>
            <div class="col-sm-9">
            <textarea name="MoTa" id="MoTa" placeholder="Mô Tả"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="PhanTramKhuyenMai">Phần Trăm Khuyến Mãi</label>
            <div class="col-sm-9">
            <input type="number" class="form-control @error('PhanTramGiamGia') is-invalid @enderror" name="PhanTramGiamGia" id="PhanTramGiamGia" placeholder="Phần trăm ">
            @error('PhanTramGiamGia')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror   
        </div>
        </div>
        <div class="form-group row">
            <label for="NgayBatDau">Ngày Bắt Đầu</label>
            <div class="col-sm-9">
            <input type="date" class="form-control @error('NgayBatDau') is-invalid @enderror" name="NgayBatDau" id="NgayBatDau" placeholder="Ngày Bắt Đầu">
            @error('NgayBatDau')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror   
            </div>
        </div>
        <div class="form-group row">
            <label for="NgayKetThuc">Ngày Kết Thúc</label>
            <div class="col-sm-9">
            <input type="date" class="form-control @error('NgayKetThuc') is-invalid @enderror" name="NgayKetThuc" id="NgayKetThuc" placeholder="Ngày Kết Thúc">
            @error('NgayKetThuc')
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
    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js">
    </script>
    <script>
        ClassicEditor
        .create( document.querySelector( '#MoTa' ) )
        .catch(error =>{
            console.error( error );
        });
    </script>
@endsection