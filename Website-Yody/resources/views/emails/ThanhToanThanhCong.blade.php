<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xác nhận thanh toán</title>
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
        h1, h2 {
            color: #2d3748;
            margin-bottom: 20px;
        }
        p {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #e2e8f0;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #3182ce;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .order-summary {
            background-color: #e6fffa;
            border: 1px solid #81e6d9;
            padding: 10px;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Xin chào {{ $khachHang->HoTen }}</h1>
    <p>Cảm ơn bạn đã thanh toán thành công.</p>
    <p>Chúng tôi đã nhận được đơn hàng của bạn với mã khách hàng: <strong>{{ $khachHang->MaKH }}</strong>.</p>
    <p>Mã đơn hàng: <strong>{{ $donHang->MaDH }}</strong></p>
    <p class="order-summary">Tổng giá trị đơn hàng: <strong>{{ number_format($donHang->TongGiaTri*100/100, 0, ',', '.') }} đ</strong></p>

    <h2>Chi tiết đơn hàng:</h2>
    <table>
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Màu sắc</th>
                <th>Kích thước</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chiTietDonHang as $item)
            <tr>
                <td>{{ $item->SanPham->TenSP }}</td>
                <td style="text-align: center;"><div style="width: 20px; height: 20px; background-color: {{ strtolower($item->ChiTietSanPham->MauSac->TenMau) }}; border: 1px solid #ccc; display: inline-block;"></div>             
                </td>
                <td style="text-align: center;">{{ $item->ChiTietSanPham->KichThuoc->TenSize }}</td>
                <td style="text-align: center;">{{ $item->SoLuong }}</td>
                <td style="text-align: center;">{{ number_format($item->DonGia * 100/100, 0, ',', '.') }} đ</td>
                <td style="text-align: center;">{{ number_format($item->ThanhTien * 100/100, 0, ',', '.') }} đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
