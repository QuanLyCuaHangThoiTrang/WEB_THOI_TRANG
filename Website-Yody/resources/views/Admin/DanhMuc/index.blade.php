@extends('Admin.welcome')

@section('title', 'Danh sách danh mục')

@section('content')
<div >
    @if(session()->has('success'))
        <div class="alert alert-danger">{{session('success')}}</div>

    @endif
</div>
<div>
    @if(session()->has('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
    @endif
</div>

<!-- Modal for Detail -->
<div class="modal fade" id="chiTietModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chi tiết danh mục</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã CTDM</th>
                            <th>Tên Chi Tiết</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody id="chiTietBody">
                        <!-- Chi tiết sẽ được load vào đây bằng AJAX -->
                    </tbody>
                </table>
                <button id="createRowBtn" class="btn btn-primary">Tạo mới</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="saveBtn">Lưu Tất Cả</button>
            </div>
        </div>
    </div>
</div>

<div>
    <div class="card">
        <div class="card-body">
            <div>
                <a href="{{route('danhmuc.create')}}" class="btn btn-primary btn-icon-text">Tạo Danh Mục</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã Danh Mục</th>
                            <th>Tên Danh Mục</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($danhmucs as $danhmuc)
                        <tr>
                            <td>{{$danhmuc->MaDanhMuc}}</td>
                            <td>{{$danhmuc->TenDanhMuc}}</td>
                            <td>
                                <a href="{{ route('danhmuc.edit', $danhmuc->MaDanhMuc) }}" class="btn btn-dark btn-sm btn-icon-text">
                                    <i class="ti-file btn-icon-append"></i> Sửa
                                </a>
                                <form action="{{ route('danhmuc.destroy', $danhmuc->MaDanhMuc) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon-text" 
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?');">
                                        <i class="ti-alert btn-icon-prepend"></i> Xóa
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary btn-sm btn-icon-text detail-btn" data-id="{{ $danhmuc->MaDanhMuc }}">
                                    <i class="mdi mdi-library-books"></i> Chi Tiết
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>

$(document).ready(function() {
    var danhmucId; // Store the current danh mục ID
    // When "Chi tiết" button is clicked
    $('.close').on('click', function() {
        $('#chiTietModal').modal('hide');
    });
    $('.detail-btn').on('click', function() {
        danhmucId = $(this).data('id'); // Get danh mục ID
        
        // AJAX to fetch details
        $.ajax({
            url: '/admin/danhmuc/' + danhmucId + '/chitiet',
            type: 'GET',
            success: function(response) {
                $('#chiTietBody').empty(); // Clear existing details

                $.each(response, function(index, item) {
                    $('#chiTietBody').append(`
                        <tr>
                            <td>${item.MaCTDM}</td>
                            <td><input type="text" class="form-control" value="${item.TenCTDM}" /></td>
                            <td><button class="btn btn-danger btn-sm deleteRowBtn">X</button></td>
                        </tr>
                    `);
                });

                $('#chiTietModal').modal('show'); // Show modal
            }
        });
    });

    // Create new detail row
    $('#createRowBtn').on('click', function() {
        var randomMaCTDM = generateRandomMaCTDM();
        $('#chiTietBody').append(`
            <tr>
                <td>${randomMaCTDM}</td>
                <td><input type="text" class="form-control" placeholder="Nhập tên chi tiết" /></td>
                <td><button class="btn btn-danger btn-sm deleteRowBtn">X</button></td>
            </tr>
        `);
    });

    // Save all details
    $('#saveBtn').on('click', function() {
        var chiTietData = [];

        $('#chiTietBody tr').each(function() {
            var tenChiTiet = $(this).find('input').val();
            var maChiTiet = $(this).find('td:first').text(); // Get MaCTDM

            if (tenChiTiet !== '') {
                chiTietData.push({
                    MaCTDM: maChiTiet, // Use existing MaCTDM or leave blank for new
                    TenCTDM: tenChiTiet
                });
            }
        });

        // AJAX to save details
        $.ajax({
            url: '/admin/danhmuc/chitiet/save',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                MaDanhMuc: danhmucId,
                chiTietData: chiTietData
            },
            success: function(response) {
                alert(response.success);
                $('#chiTietModal').modal('hide');
            },
            error: function(response) {
                alert('Có lỗi xảy ra!');
            }
        });
    });

    // Delete detail row
    $(document).on('click', '.deleteRowBtn', function() {
    var row = $(this).closest('tr');
    var maChiTiet = row.find('td:first').text(); // Get MaCTDM

    if (confirm('Bạn có chắc chắn muốn xóa chi tiết này không?')) {
        // AJAX to delete record from database
        $.ajax({
            url: '/admin/danhmuc/chitiet/' + maChiTiet + '/delete',
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.success);
                row.remove(); // Remove row from DOM after successful deletion
            },
            error: function(response) {
                alert('Có lỗi xảy ra khi xóa!');
            }
        });
    }
});

    // Function to generate random MaCTDM (for new records)
    function generateRandomMaCTDM() {

        return 'CTDM' + Math.floor(Math.random() * 1000);

    }
});
</script>
@endsection
