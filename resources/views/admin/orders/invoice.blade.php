<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn</title>
    <style>
        body {
            font-family: 'DejaVu Sans, sans-serif';
            line-height: 1.3;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .invoice-container {
            max-width: 850px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo img {
            max-width: 120px;
            margin-bottom: 10px;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #f7941d;
            margin-top: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            background: #f9f9f9;
        }

        .info-box {
            width: 100%;
        }

        .info-box h2 {
            font-size: 18px;
            color: #f7941d;
            border-bottom: 2px solid #f7941d;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .info-box p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 12px;
            font-size: 12px;
            text-align: center;
        }

        table th {
            background-color: #f7941d;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td img {
            max-width: 40px;
            border-radius: 5px;
        }

        .invoice-footer {
            text-align: center;
            font-size: 15px;
            color: #555;
            margin-top: 30px;
        }

        .highlight {
            color: #d32f2f;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <header class="invoice-header">
            <div class="logo">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('theme/client/assets/images/logo/logo1.png'))) }}" alt="Logo Công Ty">
            </div>
            <h1 class="invoice-title">HÓA ĐƠN ĐIỆN TỬ POLYFIT</h1><span>Cảm ơn bạn đã tin tưởng PolyFit!</span>
        </header>
        <!-- Thông tin người gửi và người nhận -->
        <div class="info-section">
            <div class="info-box">
                <h2>Thông tin gửi</h2>
                <p><strong>Người gửi:</strong> Công Ty XYZ</p>
                <p><strong>Địa chỉ gửi:</strong> 123 Đường ABC, Quận DEF, TP HCM</p>
                <p><strong>Số điện thoại:</strong> 0909123456</p>
            </div>
            <div class="info-box">
                <h2>Thông tin người nhận</h2>
                <p><strong>Tên người nhận:</strong> <b>{{ $order->full_name }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                <p><strong>Trạng thái:</strong> {{ $orderStatus[$order->status] ?? 'Trạng thái không xác định' }}</p>
                <p><strong>Phương thức thanh toán:</strong>{{ $orderPayment[$order->payment_method] ?? 'Phương thức không xác định' }}</p>
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <section>
            <h2 style="text-align: center; color: #f7941d; margin-bottom: 20px;">Sản phẩm của đơn hàng</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Ảnh sản phẩm</th>
                        <th>Biến thể</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('userfiles/image/Trắng.jpg'))) }}" width="100px" alt="Logo Công Ty">
                        </td>
                        <td>(Màu: {{ $item->color }}, Kích thước: {{ $item->size }})</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <!-- Tổng tiền -->
        <section style="text-align: right; margin-top: 50px;">
            <p><strong>Tiền ship:</strong> {{ number_format($order->shipping_cost, 0, '', '.') }} đ</p>
            <p><strong>Gía giá:</strong> {{ number_format($order->discount_amount, 0, '', '.') }} đ</p>
            <p><strong>Tổng tiền:</strong> <span class="highlight">{{ number_format($order->total_price, 0, '', '.') }} đ</span></p>
        </section>

        <!-- Footer -->
        <footer class="invoice-footer">
            <p>Cảm ơn quý khách đã mua hàng! Hẹn gặp lại.</p>
        </footer>
    </div>
</body>

</html>