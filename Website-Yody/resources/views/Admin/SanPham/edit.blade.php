@extends('Admin.welcome')

@section('content')
<h2 style="color:black; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin:10px">Chỉnh sửa sản phẩm</h2>
<div class="col-md-7 grid-margin stretch-card">
      
        <div class="card-body">
        <form id="productForm" action="{{ route('product.update', $product->MaSP) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="TenSP">Tên sản phẩm:</label>
            <input type="text" name="TenSP" id="TenSP" class="form-control" value="{{ old('TenSP', $product->TenSP) }}" required>
        </div>

        <div class="form-group">
            <label for="MaCTDM">Danh mục:</label>
            <select name="MaCTDM" id="MaCTDM" class="form-select" required>
                @foreach($danhMucs as $danhMuc)
                    <option value="{{ $danhMuc->MaCTDM }}" {{ $danhMuc->MaCTDM == $product->MaCTDM ? 'selected' : '' }}>
                        {{ $danhMuc->TenCTDM }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="MoTa">Mô tả:</label>
            <textarea name="MoTa" id="MoTa" class="form-control">{{ old('MoTa', $product->MoTa) }}</textarea>
        </div>

        
        <div class="form-group">
            <label for="TrangThai">Trạng thái:</label>
            <select name="TrangThai" id="TrangThai" class="form-select" required>
                <option value="1" {{ $product->TrangThai == 1 ? 'selected' : '' }}>Hiện</option>
                <option value="0" {{ $product->TrangThai == 0 ? 'selected' : '' }}>Ẩn</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>

    </div>
    
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#MoTa')).catch(error => {
        console.error(error);
    });

    $(document).ready(function(){
        // Xóa hình ảnh hiện tại khi nhấn nút "X"
        $('.remove-image').click(function() {
            $(this).closest('.image-item').remove();
        });

        // Hiển thị hình ảnh mới ngay sau khi chọn
        $('#imgInput').change(function() {
            $('#newImagesPreview').empty(); // Xóa các hình ảnh đã xem trước trước đó

            var files = this.files;
            if(files) {
                $.each(files, function(index, file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var imgHtml = '<div class="image-item"><img src="' + e.target.result + '" width="150"><button type="button" class="btn btn-danger btn-sm remove-new-image">X</button></div>';
                        $('#newImagesPreview').append(imgHtml);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });

        // Xóa hình ảnh mới khi nhấn nút "X"
        $(document).on('click', '.remove-new-image', function() {
            $(this).closest('.image-item').remove();
        });

        // Trước khi gửi form, xóa tất cả các hình ảnh bị xóa khỏi input
        $('#productForm').submit(function(e) {
            $('.current-images .image-item').each(function() {
                var imageId = $(this).find('.remove-image').data('id');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'existingImages[]',
                    value: imageId
                }).appendTo('#productForm');
            });
        });
    });
</script>
@endsection
