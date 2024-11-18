<!-- resources/views/admin/dashboard.blade.php -->
@extends('Admin.welcome') <!-- Hoặc file layout bạn đang sử dụng -->

@section('content')
    <div class="container">
        <h3>Thống Kê Doanh Số</h3>
        <div class="row">
            <div class="col-md-4">
                <input type="date" id="from_date" class="form-control">
            </div>
            <div class="col-md-4">
                <input type="date" id="to_date" class="form-control">
            </div>
            <div class="col-md-4">
                <button type="button" id="btn-dashboard-filter" class="btn btn-primary">Lọc kết quả</button>
            </div>
        </div>
        <div style="height:300px">
            <div id="myfirstchart" style="height: 250px;"></div>
        </div>
       
        
       
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Include Raphael.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>

<!-- Include Morris.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Hàm gọi AJAX để lấy dữ liệu và cập nhật biểu đồ
        function chartByDate(from_date = '', to_date = '') {
            $.ajax({
                url: "{{ url('/admin/filter-by-date') }}",
                method: "GET",
                data: {
                    from_date: from_date,
                    to_date: to_date
                },
                dataType: "json",
                success: function(data) {
                    if (data.length > 0) {
                        chart.setData(data);
                    } else {
                        // Thông báo nếu không có đơn hàng nào
                        alert('Không có đơn hàng nào trong khoảng thời gian này.');
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
            data: [],
            xkey: 'period',
            ykeys: ['order'],
            labels: ['Doanh số'],
            hideHover: 'auto',
            resize: true
        });

        // Hàm để lấy ngày đầu và ngày cuối của tháng hiện tại
        function getCurrentMonthRange() {
            var now = new Date();
            var start = new Date(now.getFullYear(), now.getMonth(), 1);
            var end = new Date(now.getFullYear(), now.getMonth() + 1, 0);
            return {
                start: start.toISOString().split('T')[0],
                end: end.toISOString().split('T')[0]
            };
        }

        // Lấy ngày đầu và ngày cuối của tháng hiện tại
        var monthRange = getCurrentMonthRange();

        // Gọi hàm hiển thị biểu đồ với dữ liệu của tháng hiện tại
        chartByDate(monthRange.start, monthRange.end);

        // Sự kiện khi người dùng bấm vào nút lọc
        $('#btn-dashboard-filter').click(function() {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if(from_date != '' && to_date != '') {
                chartByDate(from_date, to_date);
            } else {
                alert('Vui lòng chọn khoảng thời gian');
            }
        });
    });
</script>

@endsection
