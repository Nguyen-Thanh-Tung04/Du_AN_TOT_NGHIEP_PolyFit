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
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Chi tiết đơn hàng</h2>
        <ol class="breadcrumb" style="margin-bottom: 10px;">
            <li>
                <a href="{{ route('dashboard.index') }}">Trang chủ</a>
            </li>
            <li class="active"><strong>Chi tiết đơn hàng</strong></li>
        </ol>
    </div>
    <div class="col-lg-4">
        <div class="title-action">
            <a href="{{ route('orders.exportPDF', ['id' => $donHang->id]) }}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> In hóa đơn </a>
        </div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <table class="table table-sm table-striped table-bordered">
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
                                        <li>Trạng thái thanh toán: <b>{{ $donHang->paymentStatusName == 1 ? 'Đã thanh toán' : 'Chưa thanh toán' }}</b></li>

                                        <li>Tiền ship: <b>{{ number_format($donHang->shipping_cost, 0, '', '.') }} đ</b></li>
                                        <li>Giảm giá: <b>{{ number_format($donHang->discount_amount, 0, '', '.') }} đ</b></li>
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
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h5 class="card-title mb-0">Sản phẩm của đơn hàng</h5>
                    <table class="table table-sm table-striped table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Biến thể</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donHang->orderItems as $index => $item)
                        
                            <tr>
                                <td>{{$index+1}}</td> 
                                <td>{{ $item->name }}</td>
                                <td><img src="{{ $item->image ?? '' }}" width="100px"></td>

                                <td>(Màu: {{ $item->color }}, Kích thước: {{ $item->size }})</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h5 class="card-title mb-0">Lịch sử trạng thái</h5>
                    <table class="table table-sm table-striped table-bordered">
                        <tr>
                            <th>STT</th>
                            <th>Trạng thái trước</th>
                            <th>Trạng thái mới</th>
                            <th>Ghi chú</th>
                            <th>Người thay đổi</th>
                            <th>Thời gian thay đổi</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($donHang->statusHistories as $index => $history)
                            <tr>
                                <td>{{ count($donHang->statusHistories) - $index }}</td>
                                <td>{{ $trangThaiDonHang[$history->previous_status] ?? 'Không xác định' }}</td>
                                <td>{{ $trangThaiDonHang[$history->new_status] ?? 'Không xác định' }}</td>
                                <td>{{ $history->cancel_reason ?? '-' }}</td>
                                <td>{{ $history->user->name ?? 'Hệ thống' }}</td>
                                <td>{{ \Carbon\Carbon::parse($history->created_at)->format('H:i:s d-m-Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>

@endsection