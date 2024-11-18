@extends('Admin.welcome')

@section('title', 'Danh sách đơn hàng')

@section('content')
    <div>
        @if(Session::has('success'))
            <script>
                toastr.success("{{ Session::get('success') }}");
            </script>
        @endif

        @if(Session::has('error'))
            <script>
                toastr.error("{{ Session::get('error') }}");
            </script>
        @endif
    </div>

    <!-- Thanh lựa chọn hàng ngang -->
    <div class="btn-group mb-3" role="group" style="width:100%">
        <button type="button" class="btn btn-primary filter-button" data-status="all">Tất cả</button>
        <button type="button" class="btn btn-secondary filter-button" data-status="Chờ xác nhận">Chờ xác nhận</button>
        <button type="button" class="btn btn-warning filter-button" data-status="Đã xác nhận">Đã xác nhận</button>
        <button type="button" class="btn btn-info filter-button" data-status="Đang giao hàng">Đang giao hàng</button>
        <button type="button" class="btn btn-success filter-button" data-status="Giao thành công">Giao thành công</button>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Danh Sách Đơn Hàng</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Mã DH</th>
                        <th>Mã KH</th>
                        <th>Địa Chỉ Giao Hàng</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Phương Thức Thanh Toán</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($donhangs as $donhang )
                        <tr>
                            <td>{{$donhang->MaDH}}</td>
                            <td>{{$donhang->MaKH}}</td>
                            <td>{{$donhang->DiaChiGiaoHang}}</td>
                            <td>{{$donhang->NgayDatHang}}</td>
                            <td>{{ number_format($donhang->TongGiaTri, 0, ',', '.')}}đ</td>
                            <td>
                                <select class="form-control status-select" data-id="{{ $donhang->MaDH }}">
                                    <option value="Chờ xác nhận" {{ $donhang->TrangThai == 'Chờ xác nhận' ? 'selected' : '' }}>Chờ xác nhận</option>
                                    <option value="Đã xác nhận" {{ $donhang->TrangThai == 'Đã xác nhận' ? 'selected' : '' }}>Đã xác nhận</option>
                                    <option value="Đang giao hàng" {{ $donhang->TrangThai == 'Đang giao hàng' ? 'selected' : '' }}>Đang giao hàng</option>
                                    <option value="Giao thành công" {{ $donhang->TrangThai == 'Giao thành công' ? 'selected' : '' }}>Giao thành công</option>
                                </select>
                            </td>
                            <td>{{$donhang->PhuongThucThanhToan}}</td>
                            <td>
                                <a href="{{ route('donhang.show', $donhang->MaDH) }}" class="btn btn-primary btn-sm"><i class="mdi mdi-library-books"></i>Chi Tiết</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.status-select').change(function() {
            var status = $(this).val();
            var orderId = $(this).data('id');

            $.ajax({
                url: "{{ route('donhang.updateStatus') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: orderId,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        alert('Trạng thái đã được cập nhật!');
                    } else {
                        alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
        });

        // Lọc đơn hàng theo trạng thái
        $('.filter-button').click(function() {
            var status = $(this).data('status');

            if (status === 'all') {
                $('tbody tr').show();
            } else {
                $('tbody tr').hide();
                $('tbody tr').each(function() {
                    var currentStatus = $(this).find('.status-select').val();
                    if (currentStatus === status) {
                        $(this).show();
                    }
                });
            }
        });
    });
</script>
@endsection
