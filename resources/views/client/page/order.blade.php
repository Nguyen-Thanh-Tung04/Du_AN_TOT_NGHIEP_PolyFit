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
                        @if ($order->status === \App\Models\Order::STATUS_HUY_DON_HANG)
                            <div class="alert alert-danger">
                                Đơn hàng đã bị hủy.
                            </div>
                        @else
                            <div>Dự kiến giao đến bạn ngày {{ $order->estimated_delivery_date }}</div>
                        @endif
                    </div>
                </div>

                @if ($order->status !== \App\Models\Order::STATUS_HUY_DON_HANG)
                <div class="ec-trackorder-bottom">
                    <div class="ec-progress-track">
                        <ul id="ec-progressbar">
                            <li class="step0 {{ $order->status >= 1 ? 'active' : '' }}"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_1.png') }}" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Chờ xác nhận</span></li>
                            <li class="step0 {{ $order->status >= 2 ? 'active' : '' }}"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_2.png') }}" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đã xác nhận</span></li>
                            <li class="step0 {{ $order->status >= 3 ? 'active' : '' }}"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_3.png') }}" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đang chuẩn bị</span></li>
                            <li class="step0 {{ $order->status >= 4 ? 'active' : '' }}"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_4.png') }}" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đang vận chuyển <br> </span></li>
                            <li class="step0 {{ $order->status >= 5 ? 'active' : '' }}"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_5.png') }}" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đã nhận được hàng</span></li>
                        </ul>
                    </div>
                </div>
                <div class="text-right mt-5">
                    <form action="{{ route('order.history.update', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        @if ($order->status === \App\Models\Order::STATUS_CHO_XAC_NHAN) 
                            <input type="hidden" name="huy_don_hang" value="1">
                            <button type="submit" class="custom-btn danger-btn"
                                onclick="return confirm('Bạn có xác nhận hủy đơn hàng không?')">
                                <i class="fas fa-times-circle"></i> Hủy đơn hàng
                            </button>
                        @elseif ($order->status === \App\Models\Order::STATUS_DANG_VAN_CHUYEN) 
                            <input type="hidden" name="da_giao_hang" value="1">
                            <button type="submit" class="custom-btn success-btn"
                                onclick="return confirm('Xác nhận đã nhận hàng?')">
                                <i class="fas fa-check-circle"></i> Đã nhận hàng
                            </button>
                        @endif
                    </form>
                </div>
                
                
                @endif
            </div>

            <!-- Canceled Order Section -->
            @if ($order->status === \App\Models\Order::STATUS_HUY_DON_HANG)
            <div class="alert alert-warning mt-4">
                Đơn hàng này đã bị hủy. Nếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ với dịch vụ khách hàng.
            </div>
            @endif

            @foreach ($order->orderItems as $orderItem)
            @php
            $gallery = json_decode($orderItem->product->gallery);
            @endphp
            <div class="ec-trackorder-inner">
                <div class="row align-items-center p-3">
                    <div class="col-1">
                        <img src="{{ (!empty($gallery)) ? $gallery[0] : '' }}">
                    </div>
                    <div class="col-8">
                        <h6>{{ $orderItem->variant->product->name }}</h6>
                        <div class="text-muted">Phân loại hàng: <span>{{ $orderItem->color }}, {{ $orderItem->size }}</span></div>
                        <div class="text-muted">x{{ $orderItem->quantity }}</div>
                    </div>
                    <div class="col-3 text-right">
                        <del class="fs-6 fw-light text-dark">₫{{ number_format($orderItem->price, 0, ',', '.') }}</del>
                        <span class="fs-6 fw-medium text-primary">₫{{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}</span>
                    </div>
                </div>
                </a>
            </div>
            @endforeach

            <div class="row border-bottom border-top">
                <div class="col-8 text-end border-end p-2">Tổng tiền hàng</div>
                <div class="col-4 text-end p-2">
                    @php
                        $totalItemPrice = 0;
                        foreach ($order->orderItems as $orderItem) {
                            $totalItemPrice += $orderItem->price * $orderItem->quantity;
                        }
                    @endphp
                    ₫{{ number_format($totalItemPrice, 0, ',', '.') }}
                </div>
            </div>
            <div class="row border-bottom">
                <div class="col-8 text-end border-end p-2">Phí vận chuyển</div>
                <div class="col-4 text-end p-2">₫{{ number_format($order->shipping_cost, 0, ',', '.') }}</div>
            </div>
            <div class="row border-bottom">
                <div class="col-8 text-end border-end p-2">Voucher từ Shop</div>
                <div class="col-4 text-end p-2">-₫{{ number_format($order->discount_amount, 0, ',', '.') }}</div>
            </div>
            <div class="row border-bottom">
                <div class="col-8 text-end fw-bold border-end p-2">Thành tiền</div>
                <div class="col-4 text-end text-primary fw-bold p-2">₫{{ number_format($order->total_price - $order->discount_amount + $order->shipping_cost, 0, ',', '.') }}</div>
            </div>
            <div class="row">
                <div class="col-8 text-end border-end p-2">Phương thức thanh toán</div>
                <div class="col-4 text-end p-2">{{ $order->paymentMethodName }}</div>
            </div>

        </div>
        <!-- Track Order Content end -->
    </div>
</section>
@endsection
