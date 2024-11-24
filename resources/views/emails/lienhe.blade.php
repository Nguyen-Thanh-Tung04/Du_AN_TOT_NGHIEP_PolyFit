<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin liên hệ từ người dùng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
        }

        .header h2 {
            font-size: 24px;
            color: #28a745;
        }

        .contact-info {
            font-size: 16px;
            line-height: 1.6;
            margin-top: 20px;
        }

        .contact-info b {
            color: #333;
        }

        .contact-info p {
            margin: 10px 0;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h2>Thông tin liên hệ từ người dùng</h2>
        </div>

        <div class="contact-info">
            <p><b>Họ:</b> {{ $firstname }}</p>
            <p><b>Tên:</b> {{ $lastname }}</p>
            <p><b>Email:</b> {{ $email }}</p>
            <p><b>Số điện thoại:</b> {{ $phonenumber }}</p>
            <p><b>Nội dung:</b><br>{{ $address }}</p>
        </div>
    </div>

</body>
</html>
