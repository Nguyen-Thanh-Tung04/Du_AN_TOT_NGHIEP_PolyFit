@extends('client.layouts.master')

@section('content')

<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Theo dõi đơn hàng</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Theo dõi đơn hàng</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->

<section class="ec-page-content section-space-p">
    <div class="container">
        <!-- Track Order Content Start -->
        <div class="ec-trackorder-content col-md-12">
            <div class="ec-trackorder-inner">
                <div class="ec-trackorder-top">
                    <h2 class="ec-order-id">Mã Đơn Hàng #{{ $order->id }}</h2>
                    <div class="ec-order-detail">
                        <div>Dự kiến giao đến bạn ngày {{ $order->estimated_delivery_date }}</div>
                    </div>
                </div>
                <div class="ec-trackorder-bottom">
                    <div class="ec-progress-track">
                        <ul id="ec-progressbar">
                            <li class="step0 {{ $order->status >= 1 ? 'active' : '' }}"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_1.png') }}" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đơn hàng đã đặt</span></li>
                            <li class="step0"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_2.png') }}" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đã xác nhận thông tin thanh toán</span></li>
                            <li class="step0"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_3.png') }}" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đã giao cho ĐVVC</span></li>
                            <li class="step0"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_4.png') }}" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đang giao tới bạn <br> </span></li>
                            <li class="step0"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_5.png') }}" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đã nhận được hàng</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div style="background-image: repeating-linear-gradient(45deg, #6fa6d6, #6fa6d6 33px, transparent 0, transparent 41px, #f18d9b 0, #f18d9b 74px, transparent 0, transparent 82px); background-position-x: -1.875rem; background-size: 7.25rem .1875rem; height: .1875rem; width: 100%;"></div>
            <div class="ec-trackorder-inner" style="background: none;">
                <h4>Địa chỉ nhận hàng</h4>
                <div class="d-flex justify-content-between">
                    <div class="pt-2 pb-2">
                        <div class="fw-semibold">{{ $order->full_name }}</div>
                        <div>{{ $order->phone }}</div>
                        <div>
                            {{ $order->address }}, {{ optional($order->ward)->name}}, {{ optional($order->district)->name}},{{ optional($order->province)->name ?? '' }}
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary">Hủy đơn hàng</button>
                    </div>
                </div>
            </div>
            <div class="ec-trackorder-inner ">
                <div class="col-12">
                    @foreach($order->orderItems as $item)
                        <a href="link-den-san-pham.html" class="product-link">
                            <div class="row align-items-center p-3">
                                <div class="col-1">
                                    <img src="{{ $item->image }}" alt="Áo" class="img-fluid">
                                </div>

                                <div class="col-8">
                                    <h6>{{ $item->variant->product->name }}</h6>
                                    <div class="text-muted">Phân loại hàng: <span>{{ $item->color }}, {{ $item->size }}</span></div>
                                    <div class="text-muted">x{{ $item->quantity }}</div>
                                </div>
                                <div class="col-3 text-right">
                                    <span class="fs-6 fw-medium text-primary">₫{{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    <div class="row border-bottom border-top">
                        <div class="col-8 text-end border-end p-2">Phí vận chuyển</div>
                        <div class="col-4 text-end p-2">₫{{ number_format($order->shipping_cost, 0, ',', '.') }}</div>
                    </div>

                    <div class="row border-bottom">
                        <div class="col-8 text-end border-end p-2">Voucher từ Shop</div>
                        <div class="col-4 text-end p-2">-₫{{ number_format($order->discount_amount, 0, ',', '.') }}</div>
                    </div>

                    <div class="row border-bottom">
                        <div class="col-8 text-end fw-bold border-end p-2">Thành tiền</div>
                        <div class="col-4 text-end text-primary fw-bold p-2">₫{{ number_format($order->total_price, 0, ',', '.') }}</div>
                    </div>

                    <div class="row">
                        <div class="col-8 text-end border-end p-2">Phương thức thanh toán</div>
                        <div class="col-4 text-end p-2">Thanh toán khi nhận hàng</div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Track Order Content end -->
    </div>
</section>
@endsection