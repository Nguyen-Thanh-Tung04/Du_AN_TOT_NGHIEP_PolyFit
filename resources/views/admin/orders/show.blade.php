@extends('admin.layout')

@section('css')
    <link href="admin/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="admin/css/customize.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <!-- Latest compiled and minified CSS -->
    

@endsection

@section('content')
<div class="content">
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0 text-primary">Quản lý đơn hàng</h4> <!-- Chỉnh sửa màu sắc -->
            </div>
        </div>
    
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4"> <!-- Thêm margin dưới card -->
                    <div class="card-header">
                        <h5 class="card-title mb-0">Thông tin chi tiết đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Thông tin tài khoản đặt hàng</th>
                                    <th>Thông tin người nhận hàng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul>
                                            <li>Tên tài khoản: <b>{{ $donHang->user->name ?? 'N/A' }}</b></li>
                                            <li>Email: <b>{{ $donHang->user->email ?? 'N/A' }}</b></li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Tên người nhận: <b>{{ $donHang->full_name }}</b></li>
                                            <li>Số điện thoại: <b>{{ $donHang->phone }}</b></li>
                                            <li>Địa chỉ: <b>{{ $donHang->address }}</b></li>
                                            <li>Ghi chú: <b>{{ $donHang->note }}</b></li>
                                            <li>Trạng thái: <b>{{ $trangThaiDonHang[$donHang->status] ?? 'Trạng thái không xác định' }}</b></li>
                                            <li>Phương thức thanh toán: <b>{{ $trangThaiThanhToan[$donHang->payment_method] ?? 'Phương thức không xác định' }}</b></li>
                                            <li>Tiền ship: <b>{{ number_format($donHang->shipping_cost, 0, '', '.') }} đ</b></li>
                                            <li>Tổng tiền: <b class="fs-5 text-danger">{{ number_format($donHang->total_price, 0, '', '.') }} đ</b></li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Sản phẩm của đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Anh sản phẩm</th>
                                    <th>Biến thể</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($donHang->orderItems as $item)
                                @php
                                    $gallery = json_decode($item->product->gallery);
                                @endphp
                                <tr>
                                    <td>{{ $item->product->code }}</td>
                                    <td>{{ $item->variant->product->name }}</td>
                                    <td><img src="{{ (!empty($gallery)) ? $gallery[0] : '' }}" width="100px"></td>

                                    <td>(Màu: {{ $item->color }}, Kích thước: {{ $item->size }})</td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <h3>Lịch sử trạng thái</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Trạng thái trước</th>
                        <th>Trạng thái mới</th>
                        <th>Lý do hủy</th>
                        <th>Người thay đổi</th>
                        <th>Thời gian thay đổi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($donHang->statusHistories as $history)
                    <tr>
                        <td>{{ $trangThaiDonHang[$history->previous_status] ?? 'Không xác định' }}</td>
                        <td>{{ $trangThaiDonHang[$history->new_status] ?? 'Không xác định' }}</td>
                        <td>{{ $history->cancel_reason ?? '-' }}</td>
                        <td>{{ $history->user->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($history->created_at)->format('d-m-Y H:i:s') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</div>
@endsection
