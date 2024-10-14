@extends('client.layouts.master')

@section('content')
<div class="sticky-header-next-sec ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Lịch sử mua hàng</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Lịch sử</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
    <div class="container">
        <div class="row">
            <div class="ec-shop-rightside">
                <div class="ec-vendor-dashboard-card">
                    <div class="ec-vendor-card-header">
                        <h5>Lịch sử mua hàng</h5>
                        <div class="ec-header-btn">
                            <a class="btn btn-lg btn-primary" href="{{ url('/shop') }}">Mua ngay</a>
                        </div>
                    </div>
                    <div class="ec-vendor-card-body">
                        <ul class="nav nav-tabs" id="orderTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-orders-tab" data-toggle="tab" href="#all-orders" role="tab">Tất cả</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pending-orders-tab" data-toggle="tab" href="#pending-orders" role="tab">Chờ xác nhận</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="confirmed-orders-tab" data-toggle="tab" href="#confirmed-orders" role="tab">Đã xác nhận</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="preparing-orders-tab" data-toggle="tab" href="#preparing-orders" role="tab">Đang chuẩn bị</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="shipping-orders-tab" data-toggle="tab" href="#shipping-orders" role="tab">Đang vận chuyển</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="delivered-orders-tab" data-toggle="tab" href="#delivered-orders" role="tab">Đã giao hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="cancelled-orders-tab" data-toggle="tab" href="#cancelled-orders" role="tab">Đã hủy</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="orderTabContent">
                            <div class="tab-pane fade show active" id="all-orders" role="tabpanel">
                                @include('client.page.orders_table', ['orders' => $orders])
                            </div>
                            <div class="tab-pane fade" id="pending-orders" role="tabpanel">
                                @include('client.page.orders_table', ['orders' => $pendingOrders])
                            </div>
                            <div class="tab-pane fade" id="confirmed-orders" role="tabpanel">
                                @include('client.page.orders_table', ['orders' => $confirmedOrders])
                            </div>
                            <div class="tab-pane fade" id="preparing-orders" role="tabpanel">
                                @include('client.page.orders_table', ['orders' => $preparingOrders])
                            </div>
                            <div class="tab-pane fade" id="shipping-orders" role="tabpanel">
                                @include('client.page.orders_table', ['orders' => $shippingOrders])
                            </div>
                            <div class="tab-pane fade" id="delivered-orders" role="tabpanel">
                                @include('client.page.orders_table', ['orders' => $deliveredOrders])
                            </div>
                            <div class="tab-pane fade" id="cancelled-orders" role="tabpanel">
                                @include('client.page.orders_table', ['orders' => $cancelledOrders])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
