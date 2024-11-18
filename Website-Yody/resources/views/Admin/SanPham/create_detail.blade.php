@extends('Admin.welcome')

@section('title', 'Thêm Chi Tiết Cho Sản Phẩm')

@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
<div class="col-md-7 grid-margin stretch-card">
    <div class="card-body">
        <h3 class="text-black fw-bold" style="color:black; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
          {{ $product->TenSP }}
        </h3>

        <form action="{{ route('product.variants.store', ['product' => $product->MaSP]) }}" class="forms-sample" method="POST" id="variantsForm" enctype="multipart/form-data">
            @csrf
            <div id="variantsContainer">
                <!-- Các dòng biến thể sẽ được thêm vào đây -->
                <div class="variant-row">
                    <div class="form-group row">
                        <label for="size">Size:</label>
                        <select name="variants[0][size]" class="form-select" required>
                            @foreach($sizes as $size)
                                <option value="{{ $size->MaSize }}">{{ $size->TenSize }}</option>
                            @endforeach
                        </select>
                        @error('variants.0.size')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="color">Màu sắc:</label>
                        <select name="variants[0][color]" class="form-select" required>
                            @foreach($colors as $color)
                                <option value="{{ $color->MaMau }}">{{ $color->TenMau }}</option>
                            @endforeach
                        </select>
                        @error('variants.0.color')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="stockQuantity">Số lượng tồn kho:</label>
                        <input type="number" name="variants[0][stockQuantity]" class="form-control @error('variants.0.stockQuantity') is-invalid @enderror" required>
                        @error('variants.0.stockQuantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="sku">SKU:</label>
                        <input type="text" name="variants[0][sku]" class="form-control @error('variants.0.sku') is-invalid @enderror">
                        @error('variants.0.sku')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>File upload</label>
                        <input type="file" name="variants[0][img]" class="file-upload-default" multiple>
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info @error('variants.0.img') is-invalid @enderror" disabled placeholder="Upload Image">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                            @error('variants.0.img')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="removeVariant(this)">Xóa</button>
                    <hr>
                </div>
            </div>

            <button type="button" onclick="addVariant()" class="btn btn-primary">Thêm</button>
            <button type="submit" class="btn btn-success">Lưu Tất Cả</button>
        </form>
    </div>
</div>

<script>
    let variantIndex = 1;

    function addVariant() {
        const variantsContainer = document.getElementById('variantsContainer');
        
        const variantRow = document.createElement('div');
        variantRow.className = 'variant-row';
        variantRow.innerHTML = `
            <div class="form-group row">
                <label for="size">Size:</label>
                <select name="variants[${variantIndex}][size]" class="form-select" required>
                    @foreach($sizes as $size)
                        <option value="{{ $size->MaSize }}">{{ $size->TenSize }}</option>
                    @endforeach
                </select>
                @error('variants.${variantIndex}.size')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group row">
                <label for="color">Màu sắc:</label>
                <select name="variants[${variantIndex}][color]" class="form-select" required>
                    @foreach($colors as $color)
                        <option value="{{ $color->MaMau }}">{{ $color->TenMau }}</option>
                    @endforeach
                </select>
                @error('variants.${variantIndex}.color')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group row">
                <label for="stockQuantity">Số lượng tồn kho:</label>
                <input type="number" name="variants[${variantIndex}][stockQuantity]" class="form-control" required>
                @error('variants.${variantIndex}.stockQuantity')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group row">
                <label for="sku">SKU:</label>
                <input type="text" name="variants[${variantIndex}][sku]" class="form-control">
                @error('variants.${variantIndex}.sku')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>File upload</label>

                <input type="file" name="variants[${variantIndex}][img]" class="file-upload-default">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button" onclick="document.getElementsByName('variants[${variantIndex}][img]')[0].click();">Upload</button>
                    </span>
                </div>
                @error('variants.${variantIndex}.img')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="button" class="btn btn-danger" onclick="removeVariant(this)">Delete</button>
            <hr>
        `;
        
        variantsContainer.appendChild(variantRow);
        variantIndex++;
    }

    function removeVariant(button) {
        const variantRows = document.querySelectorAll('.variant-row');
        if (variantRows.length > 1) {
            const variantRow = button.parentNode;
            variantRow.parentNode.removeChild(variantRow);
        } else {
            alert("Không thể xóa, ít nhất phải có một biến thể.");
        }
    }
</script>

@endsection
