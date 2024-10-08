@extends('client.layouts.master')

@section('content')

<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Thủ tục thanh toán</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Thủ tục thanh toán</li>
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
                                <div class="d-flex justify-content-between">
                                    <h3 class="ec-checkout-title">Địa chỉ nhận hàng</h3>
                                    <a class="btn btn-secondary" style="" href="{{route('order')}}">Thêm địa chỉ mới</a>
                                </div>
                                <div class="ec-bl-block-content">
                                    <div class="ec-check-subtitle">Tùy chọn</div>
                                    <span class="ec-bill-option">
                                        <span>
                                            <input type="radio" id="bill1" name="radio-group" checked>
                                            <label for="bill1">Tôi muốn sử dụng địa chỉ đã cài đặt</label>
                                        </span>
                                        <span>
                                            <input type="radio" id="bill2" name="radio-group">
                                            <label for="bill2">Tôi muốn địa chỉ mới</label>
                                        </span>
                                    </span>
                                    <div class="ec-check-bill-form">
                                        <form action="#" method="post">
                                            <span class="ec-bill-wrap ec-bill-half">
                                                <label>Họ và tên*</label>
                                                <input type="text" name="full_name" value="{{ $user->name }}"
                                                    placeholder="" required />
                                            </span>
                                            <span class="ec-bill-wrap ec-bill-half">
                                                <label>Số điện thoại*</label>
                                                <input type="text" name="phone" value="{{ $user->phone }}"
                                                    placeholder="" required />
                                            </span>
                                            <span class="ec-bill-wrap ec-bill-half">
                                                <label>Tỉnh/Thành phố *</label>
                                                <span class="ec-bl-select-inner">
                                                    <select name="province_id" class="ec-bill-select province location" data-target="districts">
                                                        <option value="0">[Chọn Tỉnh/Thành Phố]</option>
                                                        @if (isset($provinces))
                                                            @foreach($provinces as $province)
                                                            <option value="{{ $province->code }}"
                                                                {{ old('province_id') == $province->code ? 'selected' : '' }}>
                                                                {{ $province->name }}
                                                            </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </span>
                                            </span>
                                            <span class="ec-bill-wrap ec-bill-half">
                                                <label>Quận/Huyện *</label>
                                                <span class="ec-bl-select-inner">
                                                    <select name="district_id" class="ec-bill-select districts location" data-target="wards">
                                                        <option value="0">[Chọn Quận/Huyện]</option>
                                                    </select>
                                                </span>
                                            </span>
                                            <span class="ec-bill-wrap ec-bill-half">
                                                <label>Phường/Xã</label>
                                                <span class="ec-bl-select-inner">
                                                    <select name="ward_id"
                                                        class="ec-bill-select wards">
                                                        <option value="0">[Chọn Phường/Xã]</option>
                                                    </select>
                                                </span>
                                            </span>
                                            <span class="ec-bill-wrap">
                                                <label>Địa chỉ cụ thể</label>
                                                <input type="text" name="address" value="{{ $user->address }}" placeholder="" />
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
                            <h3 class="ec-sidebar-title">Hình thức vận chuyển</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <div class="ec-checkout-del">
                                <form action="#">
                                    <span class="ec-del-option">
                                        <span>
                                            <span class="ec-del-opt-head">Giao hàng nhanh</span>
                                            <input type="radio" id="del1" name="radio-group" checked>
                                            <label for="del1">40.000đ</label>
                                        </span>
                                        <span>
                                            <span class="ec-del-opt-head">Giao hàng tiết kiệm</span>
                                            <input type="radio" id="del2" name="radio-group">
                                            <label for="del2">30.000đ</label>
                                        </span>
                                    </span>
                                    <span class="ec-del-commemt">
                                        <span class="ec-del-opt-head">Lưu ý khi giao hàng</span>
                                        <textarea name="your-commemt" placeholder="Lưu ý"></textarea>
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
                            <h3 class="ec-sidebar-title">Phương thức thanh toán</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <div class="ec-checkout-pay">
                                <form action="#">
                                    <span class="">
                                        <div style="margin-bottom:10px">
                                            <input type="radio" id="pay1" name="radio-group" checked>
                                            <label for="pay1">Thanh toán khi nhận hàng</label>
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <input type="radio" id="pay2" name="radio-group">
                                            <label for="pay2">Thanh toán bằng VnPay</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="pay3" name="radio-group">
                                            <label for="pay3">Thanh toán bằng Momo</label>
                                        </div>
                                    </span>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar Payment Block -->
                </div>
                
            </div>
        </div>
    </div>
</section>
<script>
    var province_id = '{{ (isset($user->province_id)) ? $user->province_id : old('province_id') }}'
    var district_id = '{{ (isset($user->district_id)) ? $user->district_id : old('district_id') }}'
    var ward_id = '{{ (isset($user->ward_id)) ? $user->ward_id : old('ward_id') }}'
</script>
@endsection