<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Đơn Nhập Hàng {{$donnhaphang->MaNH}}</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: 'DejaVu Sans';
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }
    </style>
</head>
<body>

    <table class="order-details">
        <thead>
            <tr>
                <th width="50%" colspan="2">
                    <h2 class="text-start">YODY</h2>
                </th>
                <th width="50%" colspan="2" class="text-end company-data">
                    <span>Ma Nhap Hang: {{ $donnhaphang->MaNH }}</span> <br>
                    <span>Nha Cung Cap: {{ $donnhaphang->nhaCungCap->TenNCC }}</span> <br>
                    <span>Ngay Nhap: {{ $donnhaphang->NgayDatHang }}</span> <br>
                    <span>Tong Gia Tri: {{ number_format($donnhaphang->TongGiaTri) }} VND</span> <br>
                </th>
            </tr>
       
        </thead>
      
           
       
    </table>

    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                  Danh Sach San Pham Nhap
                </th>
            </tr>
            <tr class="bg-blue">
                <th>Ma SP</th>
                <th>Chi Tiet San Pham</th>
                <th>Tong So Luong</th>
                <th>Gia Nhap</th>
                <th>Thanh Tien</th>
            </tr>
        </thead>
        <tbody>
        
        @foreach($donnhaphang->chitietdonnhaphangs as $chitiet)
                <tr>
                    <td width="20%">{{ $chitiet->sanPham->TenSP }}</td>
                    <td>
                    @if($chitiet->chitietSanPhamNhap->isNotEmpty())
                        @foreach($chitiet->chitietSanPhamNhap as $chiTietSanPham)
                            <div>
                                SKU: {{ $chiTietSanPham->chiTietSanPham->SKU }} -  Số lượng: {{ $chiTietSanPham->SoLuongNhap }}
                            </div>
                        @endforeach
                    @else
                        <div>Không có chi tiết sản phẩm nào.</div>
                    @endif
                    </td>
                    <td width="10%">{{ $chitiet->TongSoLuong }}</td>
                    <td width="20%">{{ number_format( $chitiet->GiaNhap, 0, ',', '.') }} VND</td>

                  
                    <td>{{ number_format( $chitiet->ThanhTien, 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <p class="text-center">
        Thank your for shopping with YODY of Web IT
    </p>

</body>
</html>