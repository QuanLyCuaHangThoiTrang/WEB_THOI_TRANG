<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thông Báo Voucher</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fb;
            color: #333;
            margin: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }
        h1 {
            color: #2d3748;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.6;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin: 10px 0;
            font-size: 16px;
            color: #2d3748;
        }
        strong {
            color: #3182ce;
        }
        .voucher-info {
            background-color: #edf2f7;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #cbd5e0;
            margin-top: 20px;
        }
        .voucher-info li {
            margin: 8px 0;
        }
        a {
            color: #3182ce;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Xin chào {{ $khachHang->HoTen }},</h1>

    <p>Chúc mừng! Bạn đã nhận được một voucher giảm giá từ chúng tôi:</p>

    <div class="voucher-info">
        <ul>
            <li><strong>Mã voucher:</strong> {{ $voucher->MaVoucher }}</li>
            <li><strong>Tên voucher:</strong> {{ $voucher->TenVoucher }}</li>
            <li><strong>Giá trị giảm:</strong> {{ number_format($voucher->PhanTramGiamGia, 0, ',', '.') }}đ</li>
            <li><strong>Ngày bắt đầu:</strong> {{ $voucher->NgayBD->format('d-m-Y') }}</li>
            <li><strong>Ngày kết thúc:</strong> {{ $voucher->NgayKT->format('d-m-Y') }}</li>
        </ul>
    </div>

    <p>Sử dụng voucher này để nhận ưu đãi trong lần mua hàng tiếp theo!</p>

    <p>Cảm ơn bạn đã đồng hành cùng chúng tôi.</p>

    <p><a href="#">Xem chi tiết đơn hàng của bạn</a></p>
</body>
</html>
