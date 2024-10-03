@extends('client.layouts.master')

@section('content')

<div class="ec-side-cart-overlay"></div>
<!-- Main Slider Start -->
<div class="sticky-header-next-sec ec-main-slider section section-space-pb">
    <div class="ec-slider swiper-container main-slider-nav main-slider-dot">
        <!-- Main slider -->
        <div class="swiper-wrapper">
            <div class="ec-slide-item swiper-slide d-flex ec-slide-1">
                <div class="container align-self-center">
                    <div class="row">
                        <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center">
                            <div class="ec-slide-content slider-animation">
                                <h1 class="ec-slide-title">Bộ sưu tập thời trang mới</h1>
                                <h2 class="ec-slide-stitle">Khuyến mại</h2>
                                <p>PolyFit chúng tôi hân hạnh chào đón bạn !</p>
                                <a href="{{ url('/product_detail') }}" class="btn btn-lg btn-secondary">Đặt hàng
                                    ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ec-slide-item swiper-slide d-flex ec-slide-2">
                <div class="container align-self-center">
                    <div class="row">
                        <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center">
                            <div class="ec-slide-content slider-animation">
                            <h1 class="ec-slide-title">Bộ thời trang sang trọng quý phái</h1>
                                <h2 class="ec-slide-stitle">Khuyến mại</h2>
                                <p>Chúng tôi hi vọng sẽ giúp thỏa mãn mong muốn mua sắm của quý khách !</p>
                                <a href="{{ url('/product_detail') }}" class="btn btn-lg btn-secondary">Đặt hàng
                                    ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination swiper-pagination-white"></div>
        <div class="swiper-buttons">
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>
<!-- Main Slider End -->
</section>
<!-- ec Product tab Area End -->

<!--category Section End -->
<!--  category Section Start -->
<section class="section ec-category-section ec-category-wrapper-1 section-space-p py-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-title fs-1">Danh mục</h2>
                </div>
            </div>
        </div>
        <div class="row margin-minus-tb-15">
            <a href="#">
                <div class="ec_cat_slider">
                    @foreach ($category as $category)
                    <div class="ec_cat_content">
                        <div class="ec_cat_inner text-center p-5">
                            <!-- Thêm lớp "img-circle" hoặc một lớp tùy chỉnh để bo tròn -->
                            <img src="{{ asset(Storage::url($category->image)) }}" alt="slider category img" class="img-circle img-fluid border border-dark" style="border-radius: 50%; /* Làm hình tròn */
                            width: 150px; /* Tuỳ chỉnh kích thước của hình ảnh */
                            height: 150px; /* Tuỳ chỉnh kích thước của hình ảnh */
                            object-fit: cover; /* Đảm bảo hình ảnh giữ tỉ lệ */"
                            />
                        </div>
                    </div>
                    @endforeach
                </div>
            </a>
        </div>
        
    </div>
</section>
<!--category Section End -->
<!-- Product tab Area Start -->
<section class="section ec-product-tab section-space-p" id="collection">

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title fs-1">Sản phẩm của chúng tôi</h2>
                    <h2 class="ec-title fs-1">Sản phẩm của chúng tôi</h2>
                    <p class="sub-title">PolyFit - Sự Lựa Chọn Hoàn Hảo Cho Bạn</p>
                </div>
            </div>

            <!-- Tab Start -->
            <div class="col-md-12 text-center">
                <ul class="ec-pro-tab-nav nav justify-content-center">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                            href="{{ url('/product_detail') }}tab-pro-for-all">Tất cả sản phẩm</a></li>
                    {{-- <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                            href="{{ url('/product_detail') }}tab-pro-for-men">Sản phẩm mới nhất</a></li> --}}
                </ul>
            </div>
            <!-- Tab End -->
        </div>
        <div class="row">
            <div class="col">
                <div class="tab-content">
                    <!-- 1st Product tab start -->
                    <div class="tab-pane fade show active" id="tab-pro-for-all">
                        <div class="row">
                            @foreach ($products as $product)
                            @php
                            $gallery = json_decode($product->gallery);
                            @endphp
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <!-- START single card -->
                                <div class="ec-product-ds">
                                    <div class="ec-product-image">
                                        <a href="{{ route('client.product.show', $product->id) }}" class="image">
                                            <img class="pic-1" src="{{ (!empty($gallery)) ? $gallery[0] : '' }}"
                                                alt="" style="height: 300px"  />
                                        </a>
                                        <span class="ec-product-discount-label">-33%</span>
                                    </div>
                                    <div class="ec-product-body">
                                        <ul class="ec-rating">
                                            <li class="ecicon eci-star fill"></li>
                                            <li class="ecicon eci-star fill"></li>
                                            <li class="ecicon eci-star fill"></li>
                                            <li class="ecicon eci-star fill"></li>
                                            <li class="ecicon eci-star"></li>
                                        </ul>
                                        <h3 class="ec-title"><a href="{{ route('client.product.show', $product->id) }}">{{ $product->name }}</a></h3>
                                        <div class="ec-price">
                                            <span>{{ number_format($product->listed_price, 0) }}VNĐ </span>
                                            {{ number_format($product->min_price, 0) }} VNĐ
                                            {{-- - {{ number_format($product->max_price, 0) }} VNĐ --}}
                                        </div>
                                        <a class="ec-add-to-cart" href="{{ route('client.product.show', $product->id) }}">Thêm giỏ hàng</a>
                                    </div>
                                </div>
                                <!--/END single card -->
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <!-- ec 1st Product tab end -->
                <!-- ec 2nd Product tab start -->
                <div class="tab-pane fade" id="tab-pro-for-men">

                </div>
                <!-- ec 2nd Product tab end -->

            </div>

        </div>
    </div>
    </div>

    {{-- <section class="section ec-services-section section-space-p" id="services">
        <h2 class="d-none">Dịch vụ</h2>
        <div class="container">
            <div class="row">
                <div class="ec_ser_content ec_ser_content_1 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        <div class="ec-service-image">
                            <i class="fi fi-ts-truck-moving"></i>
                        </div>
                        <div class="ec-service-desc">
                            <h2>Miễn phí vận chuyển</h2>
                            <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Hoa Kỳ hoặc đơn hàng trên 200 đô la</p>
                        </div>
                    </div>
                </div>
                <div class="ec_ser_content ec_ser_content_2 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        <div class="ec-service-image">
                            <i class="fi fi-ts-hand-holding-seeding"></i>
                        </div>
                        <div class="ec-service-desc">
                            <h2>Hỗ trợ 24X7</h2>
                            <p>Liên hệ với chúng tôi 24 giờ một ngày, 7 ngày một tuần</p>
                        </div>
                    </div>
                </div>
                <div class="ec_ser_content ec_ser_content_3 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        <div class="ec-service-image">
                            <i class="fi fi-ts-badge-percent"></i>
                        </div>
                        <div class="ec-service-desc">
                            <h2>Trả hàng trong vòng 30 ngày</h2>
                            <p>Chỉ cần trả lại trong vòng 30 ngày để đổi hàng</p>
                        </div>
                    </div>
                </div>
                <div class="ec_ser_content ec_ser_content_4 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        <div class="ec-service-image">
                            <i class="fi fi-ts-donate"></i>
                        </div>
                        <div class="ec-service-desc">
                            <h2>Thanh toán an toàn</h2>
                            <p>Liên hệ với chúng tôi 24 giờ một ngày, 7 ngày một tuần</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!--services Section End -->

    <!--  offer Section Start -->
    <section class="section ec-offer-section section-space-p section-space-m">
        <h2 class="d-none">Lời đề nghị</h2>
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center ec-offer-content">
                    <h2 class="ec-offer-title">Mũ</h2>
                    <h3 class="ec-offer-stitle" data-animation="slideInDown">Siêu ưu đãi</h3>
                    <span class="ec-offer-img" data-animation="zoomIn"><img src="{{ asset(Storage::url($category->image)) }}" width="200px"
                            alt="offer image" /></span>
                    <span class="ec-offer-desc">Mũ</span>
                    <span class="ec-offer-price">{{ number_format($product->listed_price, 0) }} VNĐ</span>
                    <a class="btn btn-primary" href="shop-left-sidebar-col-3.html" data-animation="zoomIn">Mua ngay</a>
                </div>
            </div>
        </div>
    </section>
    <!-- offer Section End -->
    <!-- New Product Start -->
    <section class="section ec-new-product section-space-p" id="arrivals">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Sản phẩm giảm giá</h2>
                        <h2 class="ec-title">Sản phẩm giảm giá</h2>
                        <p class="sub-title">PolyFit - Sự Lựa Chọn Hoàn Hảo Cho Bạn</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="tab-content">
                        <!-- 1st Product tab start -->
                        <div class="tab-pane fade show active" id="tab-pro-for-all">
                            <div class="row">
                                @foreach ($products as $product)
                                @php
                                $gallery = json_decode($product->gallery);
                                @endphp
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <!-- START single card -->
                                    <div class="ec-product-ds">
                                        <div class="ec-product-image">
                                            <a href="{{ route('client.product.show', $product->id) }}" class="image">
                                                <img class="pic-1" src="{{ (!empty($gallery)) ? $gallery[0] : '' }}"
                                                    alt="" style="height: 300px" />
                                            </a>
                                            <span class="ec-product-discount-label">-33%</span>
                                        </div>
                                        <div class="ec-product-body">
                                            <ul class="ec-rating">
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star"></li>
                                            </ul>
                                            <h3 class="ec-title"><a href="{{ route('client.product.show', $product->id) }}">{{ $product->name }}</a></h3>
                                            <div class="ec-price">
                                                <span>{{ number_format($product->listed_price, 0) }}VNĐ </span>
                                                {{ number_format($product->min_price, 0) }} VNĐ
                                                {{-- - {{ number_format($product->max_price, 0) }} VNĐ --}}
                                            </div>
                                            <a class="ec-add-to-cart" href="{{ route('client.product.show', $product->id) }}">Thêm giỏ hàng</a>
                                        </div>
                                    </div>
                                    <!--/END single card -->
                                </div>
                                @endforeach
    
                            </div>
                        </div>
                    </div>
                    <!-- ec 1st Product tab end -->
                    <!-- ec 2nd Product tab start -->
                    <div class="tab-pane fade" id="tab-pro-for-men">

                    </div>
                    <!-- ec 2nd Product tab end -->
                    <!-- ec 3rd Product tab start -->
                    <div class="tab-pane fade" id="tab-pro-for-women">

                    </div>
                    <!-- ec 3rd Product tab end -->
                    <!-- ec 4th Product tab start -->
                    <div class="tab-pane fade" id="tab-pro-for-child">

                    </div>
                    <!-- ec 4th Product tab end -->
                </div>

            </div>
        </div>
    </section>
    <!-- New Product end -->
    <!-- Ec Brand Section Start -->
    <section class="section ec-brand-area section-space-p">
        <h2 class="d-none">Thương hiệu</h2>
        <div class="container">
            <div class="row">
                <div class="ec-brand-outer">
                    <ul id="ec-brand-slider">
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail') }}"><img alt="brand"
                                        title="brand"
                                        src="{{ asset('theme/client/assets/images/brand-image/1.png') }}" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail') }}"><img alt="brand"
                                        title="brand"
                                        src="{{ asset('theme/client/assets/images/brand-image/2.png') }}" /></a></div>
                        </li>

                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail') }}"><img alt="brand"
                                        title="brand"
                                        src="{{ asset('theme/client/assets/images/brand-image/4.png') }}" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail') }}"><img alt="brand"
                                        title="brand"
                                        src="{{ asset('theme/client/assets/images/brand-image/5.png') }}" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail') }}"><img alt="brand"
                                        title="brand"
                                        src="{{ asset('theme/client/assets/images/brand-image/6.png') }}" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail') }}"><img alt="brand"
                                        title="brand"
                                        src="{{ asset('theme/client/assets/images/brand-image/7.png') }}" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail') }}"><img alt="brand"
                                        title="brand"
                                        src="{{ asset('theme/client/assets/images/brand-image/8.png') }}" /></a></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Ec Brand Section End -->

    @endsection