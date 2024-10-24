@extends('client.layouts.master')

@section('content')

<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Đặt lại mật khẩu</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Đặt lại mật khẩu</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->

<!-- Start Register -->
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">Đặt lại mật khẩu</h2>
                    <h2 class="ec-title">Đặt lại mật khẩu</h2>
                    <p class="sub-title mb-3">Để trải nghiệm tốt nhất.</p>
                </div>
            </div>
            <div class="ec-register-wrapper col-md-6">
                <div class="ec-register-container">
                    <div class="ec-register-form">
                        <form action="{{ route('postGetPass')}}" method="post">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="expires" value="{{ $expires }}">
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
                                <button class="btn btn-primary" type="submit">Đặt lại mật khẩu</button>
                            </span>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Register -->
@endsection
