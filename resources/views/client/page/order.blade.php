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

    <section class="section section-xl bg-default text-md-left">
        <div class="container">
            <div
                style="background-image: repeating-linear-gradient(45deg, #6fa6d6, #6fa6d6 33px, transparent 0, transparent 41px, #f18d9b 0, #f18d9b 74px, transparent 0, transparent 82px); background-position-x: -1.875rem; background-size: 7.25rem .1875rem; height: .1875rem; width: 100%;">
            </div>
            <div class="ec-trackorder-inner mb-50">
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
                                        src="{{ asset('theme/client/assets/images/icons/track_1.png') }}"
                                        alt="track_order"></span><span class="ec-progressbar-track"></span><span
                                    class="ec-track-title">Đơn hàng đã đặt</span></li>
                            <li class="step0"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_2.png') }}"
                                        alt="track_order"></span><span class="ec-progressbar-track"></span><span
                                    class="ec-track-title">Đã xác nhận thông tin thanh toán</span></li>
                            <li class="step0"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_3.png') }}"
                                        alt="track_order"></span><span class="ec-progressbar-track"></span><span
                                    class="ec-track-title">Đã giao cho ĐVVC</span></li>
                            <li class="step0"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_4.png') }}"
                                        alt="track_order"></span><span class="ec-progressbar-track"></span><span
                                    class="ec-track-title">Đang giao tới bạn <br> </span></li>
                            <li class="step0"><span class="ec-track-icon"> <img
                                        src="{{ asset('theme/client/assets/images/icons/track_5.png') }}"
                                        alt="track_order"></span><span class="ec-progressbar-track"></span><span
                                    class="ec-track-title">Đã nhận được hàng</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table box table-bordered">
                            <thead>
                                <tr style="background: #eaebec">
                                    <th style="width: 50px;">STT</th>
                                    <th>Tên</th>
                                    <th>Phân loại hàng</th>
                                    <th>Số lượng</th>
                                    <th>Giá sản phẩm</th>
                                    <th>Tổng cộng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPrice = 0;
                                @endphp
                                @foreach ($order->orderItems as $index => $item)
                                    @php
                                        $totalPrice += $item->price * $item->quantity;
                                    @endphp

                                    <tr class="row_cart">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            {{ $item->variant->product->name }}<br>
                                            <a href=""><img width="100" src="{{ $item->image }}" alt></a>
                                        </td>
                                        <td>
                                            <div class="product-price-wrap">
                                                <div class="product-price product-price-old">Màu: {{ $item->color }}</div>
                                                <div class="product-price">Kích cỡ: {{ $item->size }}</div>
                                            </div>
                                        </td>

                                        <td>{{ $item->quantity }}</td>
                                        <td>₫{{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td align="left">
                                            ₫{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12">
                    <form class="sc-shipping-address" id="form-order" role="form" method="POST"
                        action="https://demo.s-cart.org/order-add">
                        <input type="hidden" name="_token" value="iVEYxp5y3lPVUVDFyMO3aJvIsN7llsz8GfbGpEy7">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6">
                                <h3 class="control-label"><i class="fa fa-truck" aria-hidden="true"></i>
                                    Địa chỉ giao hàng:<br></h3>
                                <table class="table box table-bordered" id="showTotal">
                                    <tr>
                                        <th>Tên:</td>
                                        <td>{{ $order->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Điện thoại:</td>
                                        <td>{{ $order->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Địa chỉ:</td>
                                        <td>{{ $order->address }}, {{ optional($order->ward)->name }},
                                            {{ optional($order->district)->name }},{{ optional($order->province)->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ghi chú:</td>
                                        <td>{{ $order->note }}</td>
                                    </tr>
                                </table>
                                <div class="text-end">
                                    <button class="btn btn-secondary">Hủy đơn hàng</button>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6">
                                <h3 class="control-label"><br></h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table box table-bordered" id="showTotal">
                                            <tr class="showTotal">
                                                <th>Tổng tiền hàng</th>
                                                <td style="text-align: right" id="subtotal">
                                                    ₫{{ number_format($totalPrice, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr class="showTotal">
                                                <th>Phí vận chuyển</th>
                                                <td style="text-align: right" id="subtotal">
                                                    ₫{{ number_format($order->shipping_cost, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr class="showTotal">
                                                <th>Voucher giảm giá</th>
                                                <td style="text-align: right" id="tax">
                                                    -₫{{ number_format($order->discount_amount, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr class="showTotal" style="background:#f5f3f3;font-weight: bold;">
                                                <th>Tổng tiền</th>
                                                <td style="text-align: right" id="total">
                                                    ₫{{ number_format($order->total_price, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h3 class="control-label"><i class="fas fa-credit-card"></i>
                                                        Phương thức thanh toán:<br></h3>
                                                </div>
                                                <div class="form-group">
                                                    <div>
                                                        <label class="radio-inline">
                                                            <div>Thanh toán khi nhận hàng</div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-bottom: 20px;">
                                    <div class="col-md-12 text-center">
                                        <div class="pull-left">
                                            <button onClick="location.href=' https://demo.s-cart.org/cart.html '" style
                                                class=" button button-lg " type="button"><i
                                                    class="fa fa-arrow-left"></i>Trở lại giỏ hàng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
