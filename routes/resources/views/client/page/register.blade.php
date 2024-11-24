@extends('client.layouts.master')

@section('content')

<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Đăng ký</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Đăng ký</li>
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
        <div class="row align-items-center">
            <!-- Phần bên trái -->
            <div class="col-md-7 d-flex justify-content-center align-items-center position-relative">
                <div class="login-image-wrapper">
                    <img src="{{ asset('theme/client/assets/images/bg/banner.jpg') }}" alt="Login Image" class="img-fluid-ac login-image" />
                    <div class="image-text">
                        <h4 >Chào mừng bạn!</h4>
                        <p>Đăng nhập ngay để khám phá thế giới sản phẩm tuyệt vời.</p>
                    </div>
                </div>
            </div>

            <!-- Phần bên phải -->
            <div class="col-md-5 d-flex align-items-center">
                <div class="ec-login-wrapper">
                    <div class="ec-login-container">
                        <div class="section-titlen text-center">
                            <h2 class="ec-title">Đăng Ký </h2>
                        </div>
                        <div class="ec-login-form">
                        <form action="{{ route('auth.register') }}" method="post">
                            @csrf
                            <span class="ec-register-wrap">
                                <label>Họ tên*</label>
                                <input type="text" name="name" placeholder="Nhập họ tên" value="{{ old('name') }}" style="margin-bottom: 10px"/>
                                @error('name')
                                    <p class="text-danger mb-2">* {{ $message }}</p>
                                @enderror
                            </span>

                            <span class="ec-register-wrap">
                                <label>Email*</label>
                                <input type="email" name="email" placeholder="Nhập email..." value="{{ old('email') }}" style="margin-bottom: 10px"/>
                                @error('email')
                                    <span class="text-danger mb-2">* {{ $message }}</span>
                                @enderror
                            </span>

                            <span class="ec-register-wrap">
                                <label>Mật khẩu*</label>
                                <input type="password" name="password" placeholder="Nhập mật khẩu" style="margin-bottom: 10px"/>
                                @error('password')
                                    <span class="text-danger mb-2">* {{ $message }}</span>
                                @enderror
                            </span>

                            <span class="ec-register-wrap">
                                <label>Nhập lại mật khẩu*</label>
                                <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" style="margin-bottom: 10px"/>
                                @error('password_confirmation')
                                    <span class="text-danger mb-2">* {{ $message }}</span>
                                @enderror
                            </span>

                            <span class="ec-register-wrap ec-register-btn">
                                <button class="btn btn-primary" type="submit">Đăng ký</button>
                            </span>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
