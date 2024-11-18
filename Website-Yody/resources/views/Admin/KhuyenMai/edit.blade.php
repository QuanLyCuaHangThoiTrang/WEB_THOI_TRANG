@extends('Admin.welcome')

@section('content')
<div class="container" style="margin:10px">
    <h2>Chỉnh sửa khuyến mãi</h2>

    <form id="khuyenMaiForm" action="{{ route('khuyenmai.update', $khuyenMai->MaKM) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group row">
            <label for="TenKM">Tên Khuyến Mãi</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('TenKM') is-invalid @enderror" name="TenKM" id="TenKM" placeholder="Tên Khuyến Mãi" value="{{ old('TenKM', $khuyenMai->TenKM) }}">
                @error('TenKM')
                    <span class="invalid-feedback" role="alert">
                        <p>{{ $message }}</p>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="MoTa">Mô Tả</label>
            <div class="col-sm-9">
                <textarea name="MoTa" id="MoTa" class="form-control @error('MoTa') is-invalid @enderror" placeholder="Mô Tả">{{ old('MoTa', $khuyenMai->MoTa) }}</textarea>
                @error('MoTa')
                    <span class="invalid-feedback" role="alert">
                        <p>{{ $message }}</p>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="PhanTramKhuyenMai">Phần Trăm Khuyến Mãi</label>
            <div class="col-sm-9">
                <input type="number" class="form-control @error('PhanTramGiamGia') is-invalid @enderror" name="PhanTramGiamGia" id="PhanTramGiamGia" placeholder="Phần trăm" value="{{ old('PhanTramGiamGia', $khuyenMai->PhanTramGiamGia) }}">
                @error('PhanTramGiamGia')
                    <span class="invalid-feedback" role="alert">
                        <p>{{ $message }}</p>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="NgayBatDau">Ngày Bắt Đầu</label>
            <div class="col-sm-9">
                <input type="date" class="form-control @error('NgayBatDau') is-invalid @enderror" name="NgayBatDau" id="NgayBatDau" placeholder="Ngày Bắt Đầu" value="{{ old('NgayBatDau', $khuyenMai->NgayBatDau) }}">
                @error('NgayBatDau')
                    <span class="invalid-feedback" role="alert">
                        <p>{{ $message }}</p>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="NgayKetThuc">Ngày Kết Thúc</label>
            <div class="col-sm-9">
                <input type="date" class="form-control @error('NgayKetThuc') is-invalid @enderror" name="NgayKetThuc" id="NgayKetThuc" placeholder="Ngày Kết Thúc" value="{{ old('NgayKetThuc', $khuyenMai->NgayKetThuc) }}">
                @error('NgayKetThuc')
                    <span class="invalid-feedback" role="alert">
                        <p>{{ $message }}</p>
                    </span>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật</button>
    </form>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#MoTa'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
