@extends('Admin.welcome')

@section('title', 'Tạo sản phẩm')

@section('content')
    <!-- <div>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
    </div> -->
    <div class="card">
                <div class="card-body">
    <form method="post" action="{{route('product.store')}}" class="forms-sample" enctype="multipart/form-data">
        @csrf 
        @method('post')
        <div class="form-group row">
            <label for="TenSP">Tên Sản Phẩm</label>
            <div class="col-sm-9">
            <input type="text" class="form-control @error('TenSP') is-invalid @enderror" name="TenSP" id="TenSP" placeholder="Tên Sản Phẩm">
            @error('TenSP')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="MaCTDM">Mã Danh Mục</label>
            <div class="col-sm-9">
                <select name="MaCTDM" id="MaCTDM" class="form-select @error('MaCTDM') is-invalid @enderror">
                    @foreach($danhMucs as $danhMuc)
                        <option value="{{ $danhMuc->MaCTDM }}">{{ $danhMuc->TenCTDM }}</option>
                    @endforeach
                </select>
                @error('MaCTDM')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="MoTa">Mô Tả</label>
            <div class="col-sm-9">
            <textarea name="MoTa" id="MoTa" placeholder="Mô Tả" class="form-control @error('MoTa') is-invalid @enderror"></textarea>
            @error('MoTa')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            </div>
        </div>
      
        <div class="form-group row">
            <label for="TrangThai">Trạng Thái</label>
            <div class="col-sm-9">
                <select name="TrangThai" id="TrangThai" class="form-select @error('TrangThai') is-invalid @enderror">
                    <option value="1">Hiện</option>
                    <option value="0">Ẩn</option>
                </select>
                @error('TrangThai')
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