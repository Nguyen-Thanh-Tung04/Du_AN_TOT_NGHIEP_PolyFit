@extends('client.layouts.master')

@section('content')

<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Checkout</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Checkout</li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->

<section class="ec-page-content section-space-p checkout_page">
    <div class="container">
        <div class="row">
            <div class="ec-checkout-leftside col-lg-8 col-md-12 ">
                <!-- checkout content Start -->
                <div class="ec-checkout-content">
                    <div class="ec-checkout-inner">
                        <div class="ec-checkout-wrap margin-bottom-30 padding-bottom-3">
                            <div class="ec-checkout-block ec-check-bill">
                                <h3 class="ec-checkout-title">Địa chỉ nhận hàng</h3>
                                <div class="ec-bl-block-content">
                                    <div class="ec-check-subtitle">Checkout Options</div>
                                    <span class="ec-bill-option">
                                        <span>
                                            <input type="radio" id="bill1" name="radio-group">
                                            <label for="bill1">Tôi muốn sử dụng địa chỉ đã cài đặt</label>
                                        </span>
                                        <span>
                                            <input type="radio" id="bill2" name="radio-group" checked>
                                            <label for="bill2">Tôi muốn địa chỉ mới</label>
                                        </span>
                                    </span>
                                    <div class="ec-check-bill-form">
                                        <form action="#" method="post">
                                            <span class="ec-bill-wrap ec-bill-half">
                                                <label>Họ và tên*</label>
                                                <input type="text" name="firstname"
                                                    placeholder="" required />
                                            </span>
                                            <span class="ec-bill-wrap ec-bill-half">
                                                <label>Số điện thoại*</label>
                                                <input type="text" name="firstname"
                                                    placeholder="" required />
                                            </span>
                                            <span class="ec-bill-wrap ec-bill-half">
                                                <label>Tỉnh/Thành phố *</label>
                                                <span class="ec-bl-select-inner">
                                                    <select name="ec_select_city" id="ec-select-city"
                                                        class="ec-bill-select">
                                                        <option selected disabled></option>
                                                        <option value="1">City 1</option>
                                                        <option value="2">City 2</option>
                                                        <option value="3">City 3</option>
                                                        <option value="4">City 4</option>
                                                        <option value="5">City 5</option>
                                                    </select>
                                                </span>
                                            </span>
                                            <span class="ec-bill-wrap ec-bill-half">
                                                <label>Quận/Huyện *</label>
                                                <span class="ec-bl-select-inner">
                                                    <select name="ec_select_country" id="ec-select-country"
                                                        class="ec-bill-select">
                                                        <option selected disabled></option>
                                                        <option value="1">Country 1</option>
                                                        <option value="2">Country 2</option>
                                                        <option value="3">Country 3</option>
                                                        <option value="4">Country 4</option>
                                                        <option value="5">Country 5</option>
                                                    </select>
                                                </span>
                                            </span>
                                            <span class="ec-bill-wrap ec-bill-half">
                                                <label>Phường/Xã</label>
                                                <span class="ec-bl-select-inner">
                                                    <select name="ec_select_state" id="ec-select-state"
                                                        class="ec-bill-select">
                                                        <option selected disabled></option>
                                                        <option value="1">Region/State 1</option>
                                                        <option value="2">Region/State 2</option>
                                                        <option value="3">Region/State 3</option>
                                                        <option value="4">Region/State 4</option>
                                                        <option value="5">Region/State 5</option>
                                                    </select>
                                                </span>
                                            </span>
                                            <span class="ec-bill-wrap">
                                                <label>Địa chỉ cụ thể</label>
                                                <input type="text" name="address" placeholder="" />
                                            </span>

                                        </form>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <span class="ec-check-order-btn">
                            <a class="btn btn-primary" href="{{route('order')}}">Đặt hàng</a>
                        </span>
                    </div>
                </div>
                <!--cart content End -->
            </div>
            <!-- Sidebar Area Start -->
            <div class="ec-checkout-rightside col-lg-4 col-md-12">
                <div class="ec-sidebar-wrap">
                    <!-- Sidebar Summary Block -->
                    <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Chi tiết</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <div class="ec-checkout-summary">
                                <div>
                                    <span class="text-left">Tổng tiền hàng</span>
                                    <span class="text-right">₫80.000</span>
                                </div>
                                <div>
                                    <span class="text-left">Phí vận chuyển</span>
                                    <span class="text-right">₫80.000</span>
                                </div>
                                <div>
                                    <span class="text-left">Voucher</span>
                                    <span class="text-right"><a class="ec-checkout-coupan">Sử dụng Voucher</a></span>
                                </div>
                                <div class="ec-checkout-coupan-content">
                                    <form class="ec-checkout-coupan-form" name="ec-checkout-coupan-form"
                                        method="post" action="#">
                                        <input class="ec-coupan" type="text" required=""
                                            placeholder="Nhập Voucher" name="ec-coupan" value="">
                                        <button class="ec-coupan-btn button btn-primary" type="submit"
                                            name="subscribe" value="">Ok</button>
                                    </form>
                                </div>
                                <div class="ec-checkout-summary-total">
                                    <span class="text-left">Tổng thanh toán</span>
                                    <span class="text-right">₫80.000</span>
                                </div>
                            </div>
                            <div class="ec-checkout-pro">
                                <div class="col-sm-12 mb-6">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image"
                                                        src="theme/client/assets/images/product-image/6_1.jpg"
                                                        alt="Product" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Baby toy teddy bear</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">₫95.000</span>
                                                <span class="new-price">₫79.000</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    Phân loại: Xanh, XL
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-0">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image"
                                                        src="theme/client/assets/images/product-image/7_1.jpg"
                                                        alt="Product" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Smart I watch 2GB</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">₫58.000</span>
                                                <span class="new-price">₫45.000</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    Phân loại: Xanh, XL
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar Summary Block -->
                </div>
                <div class="ec-sidebar-wrap ec-checkout-del-wrap">
                    <!-- Sidebar Summary Block -->
                    <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Delivery Method</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <div class="ec-checkout-del">
                                <div class="ec-del-desc">Please select the preferred shipping method to use on this
                                    order.</div>
                                <form action="#">
                                    <span class="ec-del-option">
                                        <span>
                                            <span class="ec-del-opt-head">Free Shipping</span>
                                            <input type="radio" id="del1" name="radio-group" checked>
                                            <label for="del1">Rate - ₫0 .000</label>
                                        </span>
                                        <span>
                                            <span class="ec-del-opt-head">Flat Rate</span>
                                            <input type="radio" id="del2" name="radio-group">
                                            <label for="del2">Rate - ₫5.00<0 /label>
                                        </span>
                                    </span>
                                    <span class="ec-del-commemt">
                                        <span class="ec-del-opt-head">Add Comments About Your Order</span>
                                        <textarea name="your-commemt" placeholder="Comments"></textarea>
                                    </span>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar Summary Block -->
                </div>
                <div class="ec-sidebar-wrap ec-checkout-pay-wrap">
                    <!-- Sidebar Payment Block -->
                    <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Payment Method</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <div class="ec-checkout-pay">
                                <div class="ec-pay-desc">Please select the preferred payment method to use on this
                                    order.</div>
                                <form action="#">
                                    <span class="ec-pay-option">
                                        <span>
                                            <input type="radio" id="pay1" name="radio-group" checked>
                                            <label for="pay1">Cash On Delivery</label>
                                        </span>
                                    </span>
                                    <span class="ec-pay-commemt">
                                        <span class="ec-pay-opt-head">Add Comments About Your Order</span>
                                        <textarea name="your-commemt" placeholder="Comments"></textarea>
                                    </span>
                                    <span class="ec-pay-agree"><input type="checkbox" value=""><a href="#">I have
                                            read and agree to the <span>Terms & Conditions</span></a><span
                                            class="checked"></span></span>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar Payment Block -->
                </div>
                <div class="ec-sidebar-wrap ec-check-pay-img-wrap">
                    <!-- Sidebar Payment Block -->
                    <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Payment Method</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <div class="ec-check-pay-img-inner">
                                <div class="ec-check-pay-img">
                                    <img src="theme/client/assets/images/icons/payment1.png" alt="">
                                </div>
                                <div class="ec-check-pay-img">
                                    <img src="theme/client/assets/images/icons/payment2.png" alt="">
                                </div>
                                <div class="ec-check-pay-img">
                                    <img src="theme/client/assets/images/icons/payment3.png" alt="">
                                </div>
                                <div class="ec-check-pay-img">
                                    <img src="theme/client/assets/images/icons/payment4.png" alt="">
                                </div>
                                <div class="ec-check-pay-img">
                                    <img src="theme/client/assets/images/icons/payment5.png" alt="">
                                </div>
                                <div class="ec-check-pay-img">
                                    <img src="theme/client/assets/images/icons/payment6.png" alt="">
                                </div>
                                <div class="ec-check-pay-img">
                                    <img src="theme/client/assets/images/icons/payment7.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar Payment Block -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection