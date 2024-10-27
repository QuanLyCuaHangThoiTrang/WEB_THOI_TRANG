@extends('Admin.welcome')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Quick Stats -->
    <div class="row">
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h3>Tổng Doanh Thu</h3>
                    <p class="mb-0">{{$totalRevenue}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h3>Tổng Đơn Hàng</h3>
                    <p class="mb-0">{{$totalOrder}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h3>Sản Phẩm Đã Bán</h3>
                    <p class="mb-0">{{$number_product}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h3>Tổng Khách Hàng</h3>
                    <p class="mb-0">{{$number_customer}}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Doanh Thu Theo Ngày</h4>
                <!-- Phần tử chứa biểu đồ với ID myfirstchart -->
                <div id="myfirstchart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>



    <!-- Latest Orders -->
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Đơn Hàng Mới Nhất</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Mã Đơn Hàng</th>
                                    <th>Tên Khách Hàng</th>
                                    <th>Tổng Giá Trị</th>
                                    <th>Ngày Đặt</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($latestOrders as $order)
                            <tr>
                                <td>{{ $order->MaDH }}</td>
                                <td>{{ $order->khachHang->HoTen}}</td>
                                <td>{{ number_format($order->TongGiaTri, 0, ',', '.') }} đ</td>
                                <td>{{ $order->NgayDatHang }}</td>
                                <td>{{ $order->TrangThai }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Selling Products -->
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Sản Phẩm Bán Chạy Nhất</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Mã Sản Phẩm</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Số Lượng Bán</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($bestSellingProducts as $product)
                                <tr>
                                <td>{{ $product['MaSP'] }}</td>
                                <td>{{ $product['TenSP'] }}</td>
                                <td>{{ $product['SoLuongBan'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Include Raphael.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>

<!-- Include Morris.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Hàm gọi AJAX để lấy dữ liệu và cập nhật biểu đồ
        function chartByCurrentMonth() {
            $.ajax({
                url: "{{ url('/admin/orders-current-month') }}", // URL mới để lấy dữ liệu cho tháng hiện tại
                method: "GET",
                dataType: "json",
                success: function(data) {
                    if (data.length > 0) {
                        chart.setData(data); // Cập nhật dữ liệu biểu đồ
                    } else {
                        // Thông báo nếu không có đơn hàng nào
                        alert('Không có đơn hàng nào trong tháng hiện tại.');
                        chart.setData([]); // Đặt lại dữ liệu biểu đồ thành rỗng
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        // Khởi tạo biểu đồ với Morris.js
        var chart = Morris.Bar({
            element: 'myfirstchart',
            data: [],  // Dữ liệu ban đầu là rỗng
            xkey: 'period',  // Hiển thị theo ngày trong tháng
            ykeys: ['order'],  // Tổng số đơn hàng
            labels: ['Số đơn hàng'],
            hideHover: 'auto',
            resize: true
        });

        // Gọi hàm hiển thị biểu đồ với dữ liệu của tháng hiện tại
        chartByCurrentMonth();
    });
</script>



@endsection
