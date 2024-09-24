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
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Theo dõi đơn hàng</li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
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
                    <h2 class="ec-order-id">order #6152</h2>
                    <div class="ec-order-detail">
                        <div>Expected arrival 14-02-2021-2022</div>
                        <div>Grasshoppers <span>v534hb</span></div>
                    </div>
                </div>
                <div class="ec-trackorder-bottom">
                    <div class="ec-progress-track">
                        <ul id="ec-progressbar">
                            <li class="step0 active"><span class="ec-track-icon"> <img
                                        src="theme/client/assets/images/icons/track_1.png" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đơn hàng đã đặt</span></li>
                            <li class="step0"><span class="ec-track-icon"> <img
                                        src="theme/client/assets/images/icons/track_2.png" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đã xác nhận thông tin thanh toán</span></li>
                            <li class="step0"><span class="ec-track-icon"> <img
                                        src="theme/client/assets/images/icons/track_3.png" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đã giao cho ĐVVC</span></li>
                            <li class="step0"><span class="ec-track-icon"> <img
                                        src="theme/client/assets/images/icons/track_4.png" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đang giao tới bạn <br> </span></li>
                            <li class="step0"><span class="ec-track-icon"> <img
                                        src="theme/client/assets/images/icons/track_5.png" alt="track_order"></span><span
                                    class="ec-progressbar-track"></span><span class="ec-track-title">Đã nhận được hàng</span></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Track Order Content end -->
    </div>
</section>
@endsection