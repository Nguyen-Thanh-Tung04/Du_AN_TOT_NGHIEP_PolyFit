@extends('client.layouts.master')

@section('content')

<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Lấy lại mật khẩu</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Lấy lại mật khẩu</li>
                        </ul>
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
                    <h2 class="ec-bg-title">Lấy lại mật khẩu</h2>
                    <h2 class="ec-title">Lấy lại mật khẩu</h2>
                    <p class="sub-title mb-3">Vui lòng nhập email mà bạn đã đăng ký tài khoản trong hệ thống của chúng tôi.</p>
                </div>
            </div>
            <div class="ec-login-wrapper">
                <div class="ec-login-container">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="ec-login-form">
                        <form action="{{ route('forget') }}" method="post">
                            @csrf
                            <span class="ec-login-wrap">
                                <label>Email*</label>
                                <input type="text" name="email" placeholder="Nhập email..." value="{{ old('email') }}" style="margin-bottom: 10px"/>
                                @error('email')
                                    <p class="text-danger mb-2">* {{ $message }}</p>
                                @enderror
                            </span>
                            <span class="ec-login-wrap ec-login-btn">
                                <button class="btn btn-primary" type="submit">Gửi email xác nhận</button>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
