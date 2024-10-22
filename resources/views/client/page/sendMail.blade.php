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
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 100%;
            height: auto;
        }
        h1 {
            color: #333;
        }
        h3 {
            color: #666;
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
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #dddddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        @media (max-width: 600px) {
            .container {
                width: 100%;
                padding: 10px;
            }
            .button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('theme/client/assets/images/logo/logo1.png') }}" alt="Site Logo" />
        </div>

        <h1>Thông tin đơn hàng!</h1>
        <p>Mã đơn hàng của bạn: <strong>{{ $order->code }}</strong></p>
        <p>Tổng giá: <strong>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</strong></p>

        <h3>Thông tin người nhận:</h3>
        <div class="panel">
            <p><strong>Họ tên:</strong> {{ $order->full_name }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address }}, {{ $order->ward->name }}, {{ $order->district->name }}, {{ $order->province->name }}</p>
            <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
        </div>

        <h3>Chi tiết đơn hàng:</h3>
        <table>
            <tr>
                <th>Sản phẩm</th>
                <th>Màu sắc</th>
                <th>Kích thước</th>
                <th>Số lượng</th>
                <th>Giá</th>
            </tr>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->variant->product->name }}</td>
                <td>{{ $item->color }}</td>
                <td>{{ $item->size }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
            </tr>
            @endforeach
        </table>

        <a href="{{ route('order.history.show', $order->code) }}" class="button">Xem chi tiết đơn hàng</a>

        <p>Cảm ơn bạn đã mua sản phẩm tại PolyFit!</p>
        <p>Chúc bạn một ngày tốt lành!</p>

        <div class="footer">
            <p>Trân trọng,</p>
            <p>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
