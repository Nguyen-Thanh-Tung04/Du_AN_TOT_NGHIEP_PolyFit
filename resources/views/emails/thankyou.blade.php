<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảm ơn bạn đã góp ý!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
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

        .content {
            font-size: 16px;
            line-height: 1.5;
        }

        .content p {
            margin: 10px 0;
        }

        .footer {
            font-size: 14px;
            text-align: center;
            margin-top: 30px;
            color: #777;
        }

        .footer a {
            color: #28a745;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h2>Cảm ơn bạn đã góp ý!</h2>
        </div>

        <div class="content">
            <p>Chào <strong>{{ $firstname }}</strong>,</p>
            <p>Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ xem xét ý kiến của bạn và phản hồi sớm nhất.</p>
            <p>Trân trọng,</p>
            <p><strong>Đội ngũ hỗ trợ</strong></p>
        </div>

        <div class="footer">
            <p>Nếu bạn có thêm bất kỳ câu hỏi nào, vui lòng <a href="mailto:support@yourcompany.com">liên hệ với chúng tôi</a>.</p>
        </div>
    </div>

</body>
</html>
