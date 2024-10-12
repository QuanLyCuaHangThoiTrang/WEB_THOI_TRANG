<!-- resources/views/Admin/khuyenmai/show.blade.php -->
@extends('Admin.welcome')

@section('title', 'Chi Tiết Khuyến Mãi')

@section('content')
    <div style="margin:10px">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#khuyenMaiModal">
        Chọn sản phẩm khuyến mãi
    </button>
    </div>
        <div class="modal fade" id="khuyenMaiModal" tabindex="-1" role="dialog" aria-labelledby="khuyenMaiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="khuyenMaiModalLabel">Chọn sản phẩm</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    <form id="khuyenMaiForm" action="{{ route('sanphamkhuyenmai.store', $khuyenMai->MaKM) }}" method="POST">
                        @csrf
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>Tên sản phẩm</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="product-checkbox" name="products[]"
                                                value="{{ $product->MaSP }}"
                                                {{ in_array($product->MaSP, $sanPhamKhuyenMaiIds) ? 'checked' : '' }}>
                                        </td>
                                        <td>{{ $product->TenSP }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="hidden" name="khuyenmai_id" value="{{ $khuyenMai->MaKM }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" form="khuyenMaiForm" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title text-info">Chi Tiết Khuyến Mãi: {{ $khuyenMai->TenKM }}</h4>
            <p><strong>Mô Tả: </strong>{!! $khuyenMai->MoTa !!}</p>
            <p><strong>Phần Trăm Giảm Giá:</strong> {{ $khuyenMai->PhanTramGiamGia }}%</p>
            <p><strong>Ngày Bắt Đầu:</strong> {{ $khuyenMai->NgayBatDau }}</p>
            <p><strong>Ngày Kết Thúc:</strong> {{ $khuyenMai->NgayKetThuc }}</p>

    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-info">Sản Phẩm Thuộc Khuyến Mãi</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-light">
                    <tr>
                        <th>Mã Khuyến Mãi</th>
                        <th>Mã Sản Phẩm</th>
                        <th>Tên Sản Phẩm</th>
                        <!-- Thêm các cột khác nếu cần -->
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($khuyenMai->sanPhamKhuyenMais as $spKhuyenMai)
                            <tr>
                                <td>{{ $spKhuyenMai->MaKM }}</td>
                                <td>{{ $spKhuyenMai->MaSP }}</td>
                                <td>{{ $spKhuyenMai->sanPham->TenSP }}</td>
                                <td>
                                <form action="{{ route('sanphamkhuyenmai.destroy', [$spKhuyenMai->MaKM, $spKhuyenMai->sanPham->MaSP]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-icon-text" 
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?');">
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
    <script>
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    $(document).ready(function() {
        $('.close').on('click', function() {
            $('#khuyenMaiModal').modal('hide');
        });
    });
</script>
@endsection
