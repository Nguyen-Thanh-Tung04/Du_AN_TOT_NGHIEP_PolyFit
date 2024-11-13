@extends('client.layouts.master')

@section('content')

<!-- ekka Cart Start -->
<div class="ec-side-cart-overlay"></div>
<div id="ec-side-cart" class="ec-side-cart">
    <div class="ec-cart-inner">
        <div class="ec-cart-top">
            <div class="ec-cart-title">
                <span class="cart_title">Giỏ hàng của tôi</span>
                <button class="ec-close">×</button>
            </div>
            <ul class="eccart-pro-items">
                <li>
                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                            src="assets/images/product-image/6_1.jpg" alt="product"></a>
                    <div class="ec-pro-content">
                        <a href="product-left-sidebar.html" class="cart_pro_title">Áo thun nữ</a>
                        <span class="cart-price"><span>$76.00</span> x 1</span>
                        <div class="qty-plus-minus">
                            <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                        </div>
                        <a href="javascript:void(0)" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                            src="assets/images/product-image/12_1.jpg" alt="product"></a>
                    <div class="ec-pro-content">
                        <a href="product-left-sidebar.html" class="cart_pro_title">Giày da nữ</a>
                        <span class="cart-price"><span>$64.00</span> x 1</span>
                        <div class="qty-plus-minus">
                            <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                        </div>
                        <a href="javascript:void(0)" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                            src="assets/images/product-image/3_1.jpg" alt="product"></a>
                    <div class="ec-pro-content">
                        <a href="product-left-sidebar.html" class="cart_pro_title">Ví Nylon cho bé gái</a>
                        <span class="cart-price"><span>$59.00</span> x 1</span>
                        <div class="qty-plus-minus">
                            <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                        </div>
                        <a href="javascript:void(0)" class="remove">×</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="ec-cart-bottom">
            <div class="cart-sub-total">
                <table class="table cart-table">
                    <tbody>
                        <tr>
                            <td class="text-left">Tổng phụ :</td>
                            <td class="text-right">$300.00</td>
                        </tr>
                        <tr>
                            <td class="text-left">VAT (20%) :</td>
                            <td class="text-right">$60.00</td>
                        </tr>
                        <tr>
                            <td class="text-left">Total :</td>
                            <td class="text-right primary-color">$360.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="cart_btn">
                <a href="cart.html" class="btn btn-primary">Xem giỏ hàng</a>
                <a href="checkout.html" class="btn btn-secondary">Thanh toán</a>
            </div>
        </div>
    </div>
</div>
<!-- ekka Cart End -->

<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Thay đổi mật khẩu</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Thay đổi mật khẩu</li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->

<!-- User profile section -->
<section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
    <div class="container">
        <div class="row">
            <!-- Sidebar Area Start -->
            <div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
                <div class="ec-sidebar-wrap ec-border-box">
                    <!-- Sidebar Category Block -->
                    <div class="ec-sidebar-block">
                        <div class="ec-vendor-block">
                            <!-- <div class="ec-vendor-block-bg"></div>
                            <div class="ec-vendor-block-detail">
                                <img class="v-img" src="assets/images/user/1.jpg" alt="vendor image">
                                <h5>Mariana Johns</h5>
                            </div> -->
                            <div class="ec-vendor-block-items">
                                <ul>
                                    <li><a href="{{route('listProfile')}}">Hồ sơ người dùng </a></li>
                                    <li><a href="{{route('changePassword')}}">Thay đổi mật khẩu</a></li>
                                    <li><a href="{{ url('/history') }}">Lịch sử đặt hàng</a></li>
                                    <li><a href="{{route('cart.index')}}">Giỏ hàng</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ec-shop-rightside col-lg-9 col-md-12">
                <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
                    <div class="ec-vendor-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                    <h5>Đổi mật khẩu</h5>
                                    <form class="row g-3" action="{{ route('updatePassword')}}" method="POST">
                                        @method('patch')
                                        @csrf
                                        <div class=" col-md-12 space-t-15">
                                            <label class="form-label">Mật khẩu hiện tại</label>
                                            <input type="password" name="current_password" class="form-control">
                                            @error('current_password')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class=" col-md-12 space-t-15">
                                            <label class="form-label">Mật khẩu mới</label>
                                            <input type="password" name="new_password" class="form-control" >
                                            @error('new_password')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class=" col-md-12 space-t-15">
                                            <label class="form-label">Nhập lại mật khẩu mới</label>
                                            <input type="password" name="new_password_confirmation" class="form-control" >
                                            @error('new_password_confirmation')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class=" col-md-6 space-t-15">
                                            <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
