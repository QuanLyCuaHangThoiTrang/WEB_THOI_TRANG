<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào mừng đến với YODY</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2c3e50;
        }
        p {
            line-height: 1.6;
            color: #555;
        }
        .highlight {
            color: goldenrod;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Chào mừng, {{ $khachHang->HoTen }}!</h1>
        <p>Chúc mừng bạn đã trở thành một phần của <h2 class="highlight">YODY!</h2></p>
        <p>Chúng tôi rất vui mừng được chào đón bạn đến với cộng đồng của chúng tôi. Để tìm hiểu thêm về chúng tôi, hãy xem thông tin chi tiết <a href="{{ url('about-us') }}">tại đây</a>.</p>
        <p>Nếu bạn có bất kỳ câu hỏi nào, đừng ngần ngại liên hệ với chúng tôi. Chúng tôi luôn sẵn sàng hỗ trợ bạn.</p>
        <p class="footer">© 2024 YODY. Mọi quyền được bảo lưu.</p>
    </div>
</body>
</html>
