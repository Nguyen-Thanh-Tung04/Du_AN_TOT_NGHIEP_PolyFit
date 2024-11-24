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
                                        <input type="text" name="firstname" placeholder="Nhập họ của bạn" value="{{ old('firstname') }}"  />
                                        @error('firstname')
                                            <div class="text-danger error-message">
                                                <strong>* {{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </span>

                                    <!-- Last Name Field -->
                                    <span class="ec-contact-wrap">
                                        <label>Tên</label>
                                        <input type="text" name="lastname" placeholder="Nhập tên của bạn" value="{{ old('lastname') }}"  />
                                        @error('lastname')
                                            <div class="text-danger error-message">
                                                <strong>* {{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </span>

                                    <!-- Email Field -->
                                    <span class="ec-contact-wrap">
                                        <label>Email</label>
                                        <input type="email" name="email" placeholder="Nhập địa chỉ email của bạn" value="{{ old('email') }}"  />
                                        @error('email')
                                            <div class="text-danger error-message">
                                                <strong>* {{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </span>

                                    <!-- Phone Number Field -->
                                    <span class="ec-contact-wrap">
                                        <label>Số Điện Thoại</label>
                                        <input type="text" name="phonenumber" placeholder="Nhập số điện thoại của bạn" value="{{ old('phonenumber') }}"  />
                                        @error('phonenumber')
                                        <div class="text-danger error-message">
                                            <strong>* {{ $message }}</strong>
                                        </div>
                                    @enderror
                                    </span>

                                    <!-- Address/Comment Field -->
                                    <span class="ec-contact-wrap">
                                        <label>Nhận xét/Câu hỏi</label>
                                        <textarea name="address" placeholder="Hãy để lại ý kiến của bạn tại đây.." >{{ old('address') }}</textarea>
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
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.8639306974364!2d105.74726180000002!3d21.03812979999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313455e940879933%3A0xcf10b34e9f1a03df!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1sen!2sus!4v1732448839439!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                <a href="https://sites.google.com/view/maps-api-v2/mapv2"></a>
                            </div>
                        </div>
                        <div class="ec_contact_info p-3" style="width: 100%; max-width: 1200px; margin: 0 auto; background: #fff;">
                            <h1 class="ec_contact_info_head" style="text-align: center; font-size: 24px; margin-bottom: 20px;">Liên hệ với chúng tôi</h1>
                            <ul class="align-items-center" style="list-style: none; padding: 0; font-size: 18px;">
                                <li class="ec-contact-item" style="margin-bottom: 15px; display: flex; align-items: center;">
                                    <i class="ecicon eci-map-marker" aria-hidden="true" style="font-size: 20px; margin-right: 10px; color: #007bff;"></i>
                                    <span style="font-weight: bold;">Địa chỉ :</span>
                                    <span style="margin-left: 5px;">Số 3 Phương Canh, Nam Từ Liêm, Hà Nội</span>
                                </li>
                                <li class="ec-contact-item" style="margin-bottom: 15px; display: flex; align-items: center;">
                                    <i class="ecicon eci-phone" aria-hidden="true" style="font-size: 20px; margin-right: 10px; color: #007bff;"></i>
                                    <span style="font-weight: bold;">Gọi cho chúng tôi :</span>
                                    <a href="tel:+440123456789" style="margin-left: 5px; color: #333; text-decoration: none;">+44 0123 456 789</a>
                                </li>
                                <li class="ec-contact-item" style="margin-bottom: 15px; display: flex; align-items: center;">
                                    <i class="ecicon eci-envelope" aria-hidden="true" style="font-size: 20px; margin-right: 10px; color: #007bff;"></i>
                                    <span style="font-weight: bold;">Email :</span>
                                    <a href="mailto:thanhtung123@gmail.com" style="margin-left: 5px; color: #333; text-decoration: none;">thanhtung123@gmail.com</a>
                                </li>
                            </ul>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
