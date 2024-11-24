@extends('client.layouts.master')

@section('content')

    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Liên hệ với chúng tôi</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="index.html">
                                    Trang chủ</a></li>
                                <li class="ec-breadcrumb-item active">Liên hệ với chúng tôi</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- Ec Contact Us page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-common-wrapper">
                    <div class="ec-contact-leftside">
                        <div class="ec-contact-container">
                            <!-- Hiển thị thông báo thành công -->
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif


                            <div class="ec-contact-form">
                                <form action="{{ route('sendMail') }}" method="post">
                                    @csrf

                                    <!-- First Name Field -->
                                    <span class="ec-contact-wrap">
                                        <label>Họ</label>
                                        <input type="text" name="firstname" placeholder="Nhập họ của bạn" value="{{ old('firstname') }}" required />
                                        @error('firstname')
                                            <div class="text-danger error-message">
                                                <strong>* {{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </span>

                                    <!-- Last Name Field -->
                                    <span class="ec-contact-wrap">
                                        <label>Tên</label>
                                        <input type="text" name="lastname" placeholder="Nhập tên của bạn" value="{{ old('lastname') }}" required />
                                        @error('lastname')
                                            <div class="text-danger error-message">
                                                <strong>* {{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </span>

                                    <!-- Email Field -->
                                    <span class="ec-contact-wrap">
                                        <label>Email</label>
                                        <input type="email" name="email" placeholder="Nhập địa chỉ email của bạn" value="{{ old('email') }}" required />
                                        @error('email')
                                            <div class="text-danger error-message">
                                                <strong>* {{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </span>

                                    <!-- Phone Number Field -->
                                    <span class="ec-contact-wrap">
                                        <label>Số Điện Thoại</label>
                                        <input type="text" name="phonenumber" placeholder="Nhập số điện thoại của bạn" value="{{ old('phonenumber') }}" required />
                                        @error('phonenumber')
                                        <div class="text-danger error-message">
                                            <strong>* {{ $message }}</strong>
                                        </div>
                                    @enderror
                                    </span>

                                    <!-- Address/Comment Field -->
                                    <span class="ec-contact-wrap">
                                        <label>Nhận xét/Câu hỏi</label>
                                        <textarea name="address" placeholder="Hãy để lại ý kiến của bạn tại đây.." required>{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="text-danger error-message">
                                                <strong>* {{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </span>

                                    <!-- Submit Button -->
                                    <span class="ec-contact-wrap ec-contact-btn">
                                        <button class="btn btn-primary" type="submit">Gửi</button>
                                    </span>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="ec-contact-rightside">
                        <div class="ec_contact_map">
                            <div class="ec_map_canvas">
                                <iframe id="ec_map_canvas"
                                    src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d71263.65594328841!2d144.93151478652146!3d-37.8734290780509!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1615963387757!5m2!1sen!2sus"></iframe>
                                <a href="https://sites.google.com/view/maps-api-v2/mapv2"></a>
                            </div>
                        </div>
                        <div class="ec_contact_info">
                            <h1 class="ec_contact_info_head">Liên hệ với chúng tôi</h1>
                            <ul class="align-items-center">
                                <li class="ec-contact-item"><i class="ecicon eci-map-marker"
                                        aria-hidden="true"></i><span>Địa chỉ :</span>Số 3 Phương canh , Nam Từ Niêm Hà Nội</li>
                                <li class="ec-contact-item align-items-center"><i class="ecicon eci-phone"
                                        aria-hidden="true"></i><span>Gọi cho chúng tôi :</span><a href="tel:+440123456789">+44 0123
                                        456 789</a></li>
                                <li class="ec-contact-item align-items-center"><i class="ecicon eci-envelope"
                                        aria-hidden="true"></i><span>Email :</span><a
                                        href="mailto:example@ec-email.com">+thanhtung123@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
