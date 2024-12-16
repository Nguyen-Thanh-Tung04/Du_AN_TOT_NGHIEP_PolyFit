<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        h1 {
            color: #333;
            font-size: 24px;
            margin-top: 20px;
            text-align: center;
        }
        h3 {
            color: #666;
            font-size: 18px;
            margin: 20px 0 10px;
        }
        p {
            color: #333;
            font-size: 16px;
        }
        .panel {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
            padding: 10px 0;
            margin-top: 20px;
            border-top: 1px solid #dddddd;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin: 20px auto;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            text-align: left;
        }
        table, th, td {
            border: 1px solid #dddddd;
        }
        th, td {
            padding: 12px;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        td {
            color: #666;
        }
        @media (max-width: 600px) {
            .container {
                width: 100%;
                padding: 10px;
            }
            .button {
                width: 100%;
                text-align: center;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thông báo hủy đơn hàng!</h1>
        <p>Mã đơn hàng của bạn: <strong>{{ $order->code }}</strong></p>
        <p>Tổng giá trị đơn hàng: <strong>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</strong></p>

        <h3>Thông tin người nhận</h3>
        <div class="panel">
            <p><strong>Họ tên:</strong> {{ $order->full_name }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address }}, {{ $order->ward->name }}, {{ $order->district->name }}, {{ $order->province->name }}</p>
            <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
        </div>

        <h3>Chi tiết đơn hàng</h3>
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Màu sắc</th>
                    <th>Kích thước</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->variant->product->name }}</td>
                    <td>{{ $item->color }}</td>
                    <td>{{ $item->size }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p>Đơn hàng của bạn đã bị hủy bởi môt số lí do. Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>

        <div class="footer">
            <p>Trân trọng,</p>
            <p>Đội ngũ PolyFit</p>
        </div>
    </div>
</body>
</html>
