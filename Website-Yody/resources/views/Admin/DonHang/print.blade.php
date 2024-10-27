<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Invoice {{$donhang->MaDH}}</title>

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
                    <span>Invoice Id:  {{$donhang->MaDH}}</span> <br>
                    <span>Date:  {{$donhang->NgayDatHang}}</span> <br>
                    <span>Address:  {{$donhang->DiaChiGiaoHang}}</span> <br>
                </th>
            </tr>
            <tr class="bg-blue">
                <th width="50%" colspan="2">Order Details</th>
                <th width="50%" colspan="2">User Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Order Id:</td>
                <td> {{$donhang->MaDH}}</td>

                <td>Full Name:</td>
                <td> {{$donhang->khachHang->HoTen}}</td>
            </tr>
            <tr>
               

                <td>Email Id:</td>
                <td> {{$donhang->khachHang->Email}}</td>
            </tr>
            <tr>
                <td>Ordered Date:</td>
                <td>{{$donhang->NgayDatHang}}</td>

                <td>Phone:</td>
                <td>{{$donhang->khachHang->SDT}}</td>
            </tr>
            <tr>
                <td>Payment Mode:</td>
                <td>{{$donhang->PhuongThucThanhToan}}</td>

                <td>Address:</td>
                <td>{{$donhang->DiaChiGiaoHang}}</td>
            </tr>
            <tr>
                <td>Order Status:</td>
                <td>{{$donhang->TrangThai}}</td>

                
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                    Order Items
                </th>
            </tr>
            <tr class="bg-blue">
                <th>ID</th>
                <td>Name</td>
                <td>Color</td>
                <td>Size</td>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        
            @foreach($donhang->chiTietDonHang as $chitiet)
                <tr>
                    <td width="10%">{{ $chitiet->MaCTSP }}</td>
                    <td width="30%">{{ $chitiet->chiTietSanPham->sanPham->TenSP }}</td>
                    <td width="10%">{{ $chitiet->chiTietSanPham->mauSac->TenMau }}</td> 
                    <td width="10%">{{ $chitiet->chiTietSanPham->kichThuoc->TenSize }}</td>
                    <td width="10%">{{ $chitiet->SoLuong }}</td>
                    <td width="10%">{{ $chitiet->DonGia }} VND</td>
                    <td width="15%">{{ number_format($chitiet->ThanhTien, 0, ',', '.')}} đ</td>
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