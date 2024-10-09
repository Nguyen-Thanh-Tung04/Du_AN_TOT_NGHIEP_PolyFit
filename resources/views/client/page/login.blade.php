@extends('client.layouts.master')

@section('content')

<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Đăng Nhập</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Đăng nhập</li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->

<!-- Ec login page -->
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">Đăng Nhập</h2>
                    <h2 class="ec-title">Đăng Nhập</h2>
                    <p class="sub-title mb-3">Nơi tốt nhất để mua sản phẩm.</p>
                </div>
            </div>
            <div class="ec-login-wrapper">
                <div class="ec-login-container">
                    <div class="ec-login-form">
                        <form action="{{ route('auth.login-client') }}" method="post">
                            @csrf
                            <span class="ec-login-wrap">
                                <label>Email*</label>
                                <input type="text" name="email" placeholder="Nhập email..." value="{{ old('email') }}" style="margin-bottom: 10px"/>
                                @error('email')
                                    <p class="text-danger mb-2">* {{ $message }}</p>
                                @enderror
                            </span>
                            <span class="ec-login-wrap">
                                <label>Password*</label>
                                <input type="password" name="password" placeholder="Nhập mật khẩu" style="margin-bottom: 10px"/>
                                @error('password')
                                    <p class="text-danger mb-2">* {{ $message }}</p>
                                @enderror
                            </span>
                            <span class="ec-login-wrap ec-login-fp">
                                <label><a href="{{ route('password.request')}}">Quên mật khẩu?</a></label>
                            </span>
                            <span class="ec-login-wrap ec-login-btn">
                                <button class="btn btn-primary" type="submit">Đăng nhập</button>
                                <a href="{{ route('auth.client.register') }}" class="btn btn-secondary">Đăng ký</a>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
