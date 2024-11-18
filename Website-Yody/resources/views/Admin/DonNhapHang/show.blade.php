@extends('Admin.welcome')

@section('title', 'Chi tiết Đơn Nhập Hàng')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Chi Tiết Đơn Nhập Hàng: {{ $donnhaphang->MaNH }}</h2>
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productModal">
                Chọn sản phẩm
            </button>
            <a href="{{ route('donnhaphang.print', $donnhaphang->MaNH) }}" class="btn btn-dark">
            <i class="ti-file"></i> In Đơn Nhập Hàng
        </a>
        </div>
       
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kproductModalLabel">Chọn sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    <form id="productForm" action="{{ route('chitietdonnhaphang.store', $donnhaphang->MaNH) }}" method="POST">
                        @csrf
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>Tên sản phẩm</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($sanphams as $sanpham)
                                <tr>
                                <td>
                                    <input type="checkbox" class="product-checkbox" name="products[]"
                                        value="{{ $sanpham->MaSP }}"
                                        {{ in_array($sanpham->MaSP, $existingProductIds) ? 'checked' : '' }}>
                                </td>
                                    <td>{{ $sanpham->TenSP }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                        <input type="hidden" name="donnhaphang_id" value="{{ $donnhaphang->MaNH }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="productForm">Lưu</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal chọn CTSP -->
    <div class="modal fade" id="ctspModal" tabindex="-1" aria-labelledby="ctspModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ctspModalLabel">Chọn CTSP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ctspForm" action="{{ route('chitietsanphamnhap.store_CTSP', $donnhaphang->MaNH) }}" method="POST">
                        @csrf
                        <input type="hidden" name="maSP" value="">
                        <div id="ctsp-options-container"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title text-info">Thông Tin Đơn Nhập Hàng</h4>
            <p><strong>Mã Đơn Nhập Hàng:</strong> {{ $donnhaphang->MaNH }}</p>
            <p><strong>Nhà Cung Cấp:</strong> {{ $donnhaphang->nhacungcap->TenNCC }}</p>
            <p><strong>Ngày Đặt Hàng:</strong> {{ $donnhaphang->NgayDatHang }}</p>
            <p><strong>Tổng Giá Trị:</strong> <span class="text-danger">{{ number_format($donnhaphang->TongGiaTri, 0, ',', '.') }} đ</span></p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-info">Chi Tiết Đơn Nhập Hàng</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Tên Sản Phẩm</th>
                            <th>Số Lượng</th>
                            <th>Giá Nhập</th>
                            <th>Thành Tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donnhaphang->chitietdonnhaphangs as $chitiet)
                        <tr data-id="{{ $chitiet->MaSP }}">
                            <td>{{ $chitiet->sanPham->TenSP }}</td>
                            <td>
                                <input type="number" name="TongSoLuong" min="1" value="{{ $chitiet->TongSoLuong }}" class="form-control quantity">
                            </td>
                            <td>
                                <input type="number" name="GiaNhap" min="0" value="{{ $chitiet->GiaNhap }}" class="form-control price">
                            </td>
                            <td class="total-price">{{ number_format($chitiet->ThanhTien, 0, ',', '.') }} đ</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm btn-icon-text save-btn">
                                    <i class="ti-save btn-icon-append"></i> Lưu
                                </button>
                                <button type="button" class="btn btn-dark btn-sm btn-icon-text add-ctsp-btn">
                                    <i class="ti-plus btn-icon-append"></i> Thêm Chi Tiết
                                </button>
                                <form action="{{ route('chitietdonnhaphang.destroy',[$donnhaphang->MaNH, $chitiet->MaSP]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">
                                        <i class="ti-trash btn-icon-append"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top:10px">
              <a href="{{ route('donnhaphang.index') }}" class="btn btn-primary">Quay lại danh sách</a>

            </div>
        </div>
    </div>
</div>
    <script>
        
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        // Gán thuộc tính data-checked cho các checkbox đã được chọn
        if (checkbox.checked) {
            checkbox.setAttribute('data-checked', 'true');
        } else {
            checkbox.removeAttribute('data-checked');
        }

        // Ngăn không cho bỏ tick cho checkbox đã được chọn
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                // Nếu checkbox được tick, cập nhật thuộc tính data-checked
                this.setAttribute('data-checked', 'true');
            } else {
                // Nếu checkbox được bỏ tick
                if (this.hasAttribute('data-checked')) {
                    this.checked = true; // Đặt lại trạng thái tick
                }
            }
        });
    });

        document.querySelectorAll('.add-ctsp-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const maSP = row.getAttribute('data-id');
            document.querySelector('#ctspForm input[name="maSP"]').value = maSP;
            // Hiển thị modal
            $('#ctspModal').modal('show');
            
            // Tải dữ liệu CTSP
            fetch(`/admin/chitietsanphamnhap/${maSP}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const container = document.getElementById('ctsp-options-container');
                        container.innerHTML = ''; // Xóa các tùy chọn hiện tại
                        
                        data.maCTSPOptions.forEach(option => {
                            const div = document.createElement('div');
                            div.classList.add('mb-2');
                            div.innerHTML = `
                                <label for="ctsp-${option.MaCTSP}">${option.MaCTSP} (${option.MaMau}, ${option.MaSize})</label>
                                <input type="number" name="soLuongNhap[${option.MaCTSP}]" class="form-control" id="ctsp-${option.MaCTSP}" placeholder="Nhập số lượng" value="${option.SoLuongNhap || 0}">
                            `;
                            container.appendChild(div);
                        });
                    } else {
                        console.error('Failed to load MaCTSP options');
                    }
                })
                .catch(error => console.error('Error fetching MaCTSP options:', error));
        });
    });
        document.getElementById('ctspForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Ngăn chặn gửi form theo cách mặc định

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Thực hiện các hành động sau khi lưu thành công, chẳng hạn như đóng modal và làm mới trang
                $('#ctspModal').modal('hide');
                location.reload(); // Tải lại trang hoặc làm mới dữ liệu trên trang hiện tại
            } else {
                console.error('Failed to save data');
            }
        })
        .catch(error => console.error('Error saving data:', error));
    });    
        //
        const selectAllCheckbox = document.getElementById('select-all');
        const productCheckboxes = document.querySelectorAll('.product-checkbox');

        // Chọn hoặc bỏ chọn tất cả sản phẩm khi checkbox "Select All" được thay đổi
        selectAllCheckbox.addEventListener('change', function() {
            productCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Lưu thông tin khi nhấn nút "Save"
        const saveButtons = document.querySelectorAll('.save-btn');
        saveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const row = button.closest('tr');
                const maSP = row.getAttribute('data-id');
                const quantity = row.querySelector('.quantity').value;
                const price = row.querySelector('.price').value;
                const productName = row.querySelector('td:nth-child(2)').textContent.trim(); // Lấy tên sản phẩm
                if (!quantity || isNaN(quantity) || quantity <= 0) {
                    alert('Số lượng phải là số và lớn hơn 0!');
                    return; // Dừng lại không lưu
                }
                
                if (!price || isNaN(price) || price < 0) {
                    alert('Giá nhập phải là số và không được âm!');
                    return; // Dừng lại không lưu
                }
                fetch("{{ route('chitietdonnhaphang.update', [$donnhaphang->MaNH]) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        MaSP: maSP,
                        TongSoLuong: quantity,
                        GiaNhap: price,
                        TenSP: productName // Gửi tên sản phẩm
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update total price
                        row.querySelector('.total-price').textContent = data.new_total_price + ' VNĐ';
                        alert('Cập nhật thành công!');
                    } else {
                        alert('Có lỗi xảy ra khi cập nhật: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra: ' + error.message);
                });
            });
        });
    });
</script>

@endsection
