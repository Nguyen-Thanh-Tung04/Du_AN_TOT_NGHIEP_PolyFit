@extends('client.layouts.master')

@section('content')
<div class="ec-side-cart-overlay"></div>
<!-- Main Slider Start -->
<div class="sticky-header-next-sec ec-main-slider section section-space-pb bg-white">
    <div class="ec-slider swiper-container main-slider-nav main-slider-dot">
        <!-- Main slider -->
        <div class="swiper-wrapper">
            @foreach ($banners as $banner )
            <div class="ec-slide-item swiper-slide d-flex ec-slide-1" style="background-image: url('{{ asset('storage/' . $banner->image) }}')">
                <div class="container align-self-center">
                    <div class="row">
                        <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center">
                            <div class="ec-slide-content slider-animation">
                                <h1 class="ec-slide-title">{{$banner->title_main}}</h1>
                                <h2 class="ec-slide-stitle">{{$banner->title_sub}}</h2>
                                <p>{{$banner->content}}</p>
                                <a href="{{$banner->link}}" class="btn btn-lg btn-secondary">Đặt hàng
                                    ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination swiper-pagination-white"></div>
        <div class="swiper-buttons">
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>

<section class="section ec-product-tab section-space-p .bg-white" id="collection">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">Sản phẩm bán chạy</h2>
                    <h2 class="ec-title">Sản phẩm bán chạy</h2>
                    <!-- <p class="sub-title">Browse The Collection of Top Products</p> -->
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col">
                <div class="tab-content">
                    <!-- 1st Product tab start -->
                    <div class="tab-pane fade show active" id="tab-pro-for-all">
                        <div class="row">
                            @foreach ($bestSellingProducts as $index => $product) <!-- Dùng $index để tính toán sự thay đổi width -->
                            @php
                                $gallery = json_decode($product->gallery);
                                // Tính tổng số lượng và số lượng còn lại
                                $progressWidth = $product->progress; // Sử dụng giá trị progress đã tính từ controller

                            @endphp
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                                <!-- START single card -->
                                <div class="ec-product-tp">
                                    <div class="ec-product-image">
                                        <a href="{{ route('client.product.show', $product->id) }}">
                                            <img src="{{ !empty($gallery) ? $gallery[0] : '' }}" class="img-center" alt="">
                                            @if($product->variants->sum('quantity') === 0)
                                            <div class="out-of-stock-label">Hết hàng</div>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="ec-product-body">
                                        <h3 class="ec-title"><a href="{{ route('client.product.show', $product->id) }}">{{ $product->name }}</a></h3>
                                        
                                        <ul class="ec-rating">
                                            @php
                                            $averageScore = $product->averageScore();
                                            @endphp
                        
                                            @if ($averageScore)
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $averageScore)
                                                <li class="ecicon eci-star fill"></li> <!-- Sao đầy -->
                                                @else
                                                <li class="ecicon eci-star"></li> <!-- Sao rỗng -->
                                                @endif
                                            @endfor
                                            @else
                                            @for ($i = 1; $i <= 5; $i++)
                                                <li class="ecicon eci-star"></li> <!-- Sao rỗng -->
                                            @endfor
                                            @endif
                                        </ul>
                        
                                        <div class="ec-price">
                                            @if ($product->min_price)
                                            <span>{{ number_format($product->listed_price, 0) }}₫</span> {{ number_format($product->min_price, 0) }}₫
                                            @else
                                            {{ number_format($product->listed_price, 0) }}₫
                                            @endif
                                        </div>
                        
                                        <div class="ec-link-btn">
                                            <a class="ec-add-to-cart" href="{{ route('client.product.show', $product->id) }}">Mua ngay</a>
                                        </div>
                        
                                        <!-- Progress Bar -->
                                        <span class="textLeft mt-2">
                                            @if ($product->variants->sum('quantity') === 0)
                                                🔥 Cháy hết hàng
                                            @elseif ($product->progress > 80)
                                                🔥 Sắp cháy hàng 
                                            @else
                                                🔥 Đang bán chạy 
                                                {{-- ({{ round($product->progress, 2) }}%)  --}}
                                            @endif
                                        </span>
                                        
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                                 id="progressBar" 
                                                 role="progressbar" 
                                                 style="width: {{ $product->variants->sum('quantity') === 0 ? '100%' : $progressWidth . '%' }}" 
                                                 aria-valuenow="{{ $product->variants->sum('quantity') === 0 ? 100 : $progressWidth }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <!-- END single card -->
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section ec-about-sec section-space-p mt-4">
    <div class="container">
        <div class="row">
            <div class="section-title d-none">
                <h2 class="ec-title">About</h2>
            </div>
            <div class="col-lg-6">
                <div class="ec-about">
                    <img src="{{ asset('theme/client/assets/images/bg/banner.jpg') }}" alt="about-image">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ec-about-detail">
                    <h4 class="text-upper">Phong cách nổi bật, đẳng cấp sang trọng nhất.</h4>
                    <h5>Khám phá những mẫu quần áo thời trang phù hợp với xu hướng mới nhất.</h5>
                    <p>Chúng tôi cung cấp những thiết kế độc đáo, chất lượng cao dành cho bạn. Từng sản phẩm đều được chọn lọc kỹ càng để mang lại sự thoải mái và tự tin trong mọi hoạt động.</p>
                    <p>Đừng bỏ lỡ cơ hội sở hữu những bộ trang phục hiện đại, giúp bạn thể hiện cá tính và gu thẩm mỹ của mình.</p>
                    <a class="btn btn-lg btn-primary" href="shop-banner-left-sidebar-col-3.html">Mua ngay</a>

                </div>
            </div>
        </div>
    </div>
</section>
<section class="section ec-category-section ec-category-wrapper-4 section-space-p">
    <div class="container">
        <div class="row cat-space-3 cat-auto margin-minus-tb-15">
            @foreach($categories as $category)
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="category-item">
                    <div class="category-image">
                        <img src="{{ asset(Storage::url($category->image)) }}" alt="Category Image" />
                    </div>
                    <div class="category-info">
                        <div class="category-title">
                            <span class="category-name">{{ $category->name }}</span>
                            <span class="category-count">{{ $category->products_count ?? 0 }}</span>
                        </div>
                        <a href="{{ route('home.shop') }}" class="category-link">Chi tiết <i class="ecicon eci-angle-double-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<section class="section ec-product-tab section-space-p .bg-white" id="collection">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">Sản phẩm mới</h2>
                    <h2 class="ec-title">Sản phẩm mới</h2>
                    <!-- <p class="sub-title">Browse The Collection of Top Products</p> -->
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col">
                <div class="tab-content">
                    <!-- 1st Product tab start -->
                    <div class="tab-pane fade show active" id="tab-pro-for-all">
                        <div class="row">
                            @foreach ($newProducts as $product)
                            @php
                            $gallery = json_decode($product->gallery);
                            @endphp
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                                <!-- START single card -->
                                <div class="ec-product-tp">
                                    <div class="ec-product-image">
                                        <a href="{{ route('client.product.show', $product->id) }}">
                                            <img src="{{ !empty($gallery) ? $gallery[0] : '' }}" class="img-center" alt="">
                                            @if($product->variants->sum('quantity') === 0)
                                            <div class="out-of-stock-label">Hết hàng</div>
                                            @endif
                                        </a>

                                    </div>
                                    <div class="ec-product-body">
                                        <h3 class="ec-title"><a href="{{ route('client.product.show', $product->id) }}">{{ $product->name }}</a></h3>

                                        <ul class="ec-rating">
                                            @php
                                            $averageScore = $product->averageScore();
                                            @endphp

                                            @if ($averageScore)
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <=$averageScore)
                                                <li class="ecicon eci-star fill">
                                                </li> <!-- Sao đầy -->
                                                @else
                                                <li class="ecicon eci-star"></li> <!-- Sao rỗng -->
                                                @endif
                                                @endfor
                                                @else
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <=5)
                                                    <li class="ecicon eci-star fill">
                                                    </li> <!-- Sao đầy -->
                                                    @else
                                                    <li class="ecicon eci-star"></li> <!-- Sao rỗng -->
                                                    @endif
                                                    @endfor
                                                    @endif
                                        </ul>
                                        <div class="ec-price">
                                            @if ($product->min_price)

                                            <span>{{ number_format($product->listed_price, 0) }}₫</span> {{ number_format($product->min_price, 0) }}₫
                                            @else

                                            {{ number_format($product->listed_price, 0) }}₫
                                            @endif

                                        </div>
                                        <div class="ec-link-btn">
                                            <a class=" ec-add-to-cart" href="{{ route('client.product.show', $product->id) }}">Mua ngay</a>
                                        </div>
                                    </div>

                                </div>
                                <!-- START single card -->
                            </div>
                            @endforeach
                            <div class="col-sm-12 shop-all-btn"><a href="{{ route('home.shop')}}">Xem tất cả sản phẩm</a></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="ec-banner section section-space-p">
    <h2 class="d-none">Banner</h2>
    <div class="container">
        <!-- ec Banners Start -->
        <div class="ec-banner-inner">
            <!-- ec Banner Start -->
            <div class="ec-banner-block ec-banner-block-2">
                <div class="row">
                    <!-- Banner 1 -->
                    <div class="banner-block col-lg-6 col-md-12 margin-b-30 slideInRight" data-animation="slideInRight" data-animated="true">
                        <div class="bnr-overlay">
                            <img src="{{ asset('theme/client/assets/images/banner/Banner QC5.png') }}" alt="Quần áo thể thao nam">
                            <!-- <div class="banner-text">
                                <span class="ec-banner-stitle">Hàng mới về</span>
                                <span class="ec-banner-title">Quần áo<br> Thể thao nam</span>
                                <span class="ec-banner-discount">Giảm giá 30%</span>
                            </div> -->
                            <div class="banner-content">
                                <span class="ec-banner-btn"><a href="#">Đặt hàng ngay</a></span>
                            </div>
                        </div>
                    </div>
                    <!-- Banner 2 -->
                    <div class="banner-block col-lg-6 col-md-12 slideInLeft" data-animation="slideInLeft" data-animated="true">
                        <div class="bnr-overlay">
                            <img src="{{ asset('theme/client/assets/images/banner/Banner QC 4.png') }}" alt="Phụ kiện thông minh">
                            <!-- <div class="banner-text">
                                <span class="ec-banner-stitle">Xu hướng mới</span>
                                <span class="ec-banner-title">Đồng hồ<br> Thông minh</span>
                                <span class="ec-banner-discount">Mua 3 sản phẩm bất kỳ &amp; nhận<br> Giảm giá 20%</span>
                            </div> -->
                            <div class="banner-content">
                                <span class="ec-banner-btn"><a href="#">Đặt hàng ngay</a></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ec Banner End -->
            </div>
            <!-- ec Banners End -->
        </div>
    </div>
</section>
@if ($productsFlashSale->isNotEmpty())
<section class="section ec-catalog-multi-vendor margin-bottom-30 bg-white">
    <div class="container">
        <div class="row">
            <div class="ec-multi-vendor-detail">
                <div class="ec-page-description ec-page-description-info d-flex justify-content-between align-items-center" style="background-color: ##ee4d2d;">
                    <div>

                        <img src="{{ asset('theme\client\assets\images\bg\sieugiaodich.png') }}" style="width: 70%;" alt="">
                    </div>
                    <div class="">
                        <a href="{{route('flash-sale') }}" class="text-decoration-none more fw-normal fs-5 text-dark d-flex align-items-center">Xem Thêm <i style="padding-top: 5px;" class="fi-rs-angle-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row vendor-row">
            <div class="ec-multi-vendor-slider">
                @foreach($productsFlashSale as $product)
                @php
                $gallery = json_decode($product->gallery);
                @endphp
                <div class="ec-product-inner">
                    <div class="ec-pro-image-outer">
                        <div class="ec-pro-image">
                            <a href="{{ route('client.product.show', $product->id) }}" class="image">
                                <img class="main-image" src="{{ (!empty($gallery)) ? $gallery[0] : '' }}"
                                    alt="Product" />

                            </a>
                            <span class="percentage">
                                <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-1">
                                    <path d="M9.23077 0H4.23077L0 7.82222L3.5 9.14286V16L10 5.68889L6.53846 4.62222L9.23077 0Z" fill="url(#paint0_linear_2216_10611)"></path>
                                    <defs>
                                        <linearGradient id="paint0_linear_2216_10611" x1="0" y1="0" x2="0" y2="16" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FFFF"></stop>
                                            <stop offset="1" stop-color="#FFFF"></stop>
                                        </linearGradient>
                                    </defs>
                                </svg>{{number_format($product->discount_percentage)}}%
                            </span>
                            <span class="flags">
                                <span class="sale">
                                    Sale</span>
                            </span>

                        </div>
                    </div>
                    <div class="ec-pro-content">
                        <h5 class="ec-pro-title"><a href="{{ route('client.product.show', $product->id) }}">{{ $product->name }}</a></h5>
                        <div class="ec-pri.ecicon.eci-star.fillo-rating">
                            @if ($product->averageScore())

                            @for($i = 1; $i <= 5; $i++)
                                @if($i <=round($product->averageScore()))
                                <i class="ecicon eci-star fill"></i>
                                @else
                                <i class="ecicon eci-star"></i>
                                @endif
                                @endfor
                                @else
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <=5)
                                    <i class="ecicon eci-star fill">
                                    </i>
                                    @else
                                    <i class="ecicon eci-star"></i>
                                    @endif
                                    @endfor
                                    @endif
                        </div>

                        <span class="ec-price">
                            <span class="old-price">{{ number_format($product->listed_price, 0) }}₫</span>
                            <span class="new-price"> {{ number_format($product->flash_sale_price, 0) }}₫</span>
                        </span>
                        <div class="ec-pro-option">

                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </div>
</section>
@else
@endif

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


<!-- Ec Brand Section Start -->
<section class="section ec-services-section section-space-p" id="services">
    <h2 class="d-none">Dịch vụ</h2>
    <div class="container">
        <div class="row">
            <!-- Dịch vụ 1 -->
            <div class="ec_ser_content ec_ser_content_1 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                <div class="ec_ser_inner">
                    <div class="ec-service-image">
                        <i class="fi fi-ts-truck-moving"></i>
                    </div>
                    <div class="ec-service-desc text-center">
                        <h2>Miễn phí vận chuyển</h2>
                        <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt Nam hoặc đơn hàng trên 200.000 VNĐ</p>
                    </div>
                </div>
            </div>
            <!-- Dịch vụ 2 -->
            <div class="ec_ser_content ec_ser_content_2 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                <div class="ec_ser_inner">
                    <div class="ec-service-image">
                        <i class="fi fi-ts-hand-holding-seeding"></i>
                    </div>
                    <div class="ec-service-desc text-center">
                        <h2>Hỗ trợ 24X7</h2>
                        <p>Liên hệ với chúng tôi bất cứ lúc nào, 24 giờ mỗi ngày, 7 ngày một tuần.</p>
                    </div>
                </div>
            </div>
            <!-- Dịch vụ 3 -->
            <div class="ec_ser_content ec_ser_content_3 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                <div class="ec_ser_inner">
                    <div class="ec-service-image">
                        <i class="fi fi-ts-badge-percent"></i>
                    </div>
                    <div class="ec-service-desc text-center">
                        <h2>Trả hàng trong vòng 30 ngày</h2>
                        <p>Chỉ cần trả lại trong vòng 30 ngày để đổi hoặc hoàn tiền.</p>
                    </div>
                </div>
            </div>
            <!-- Dịch vụ 4 -->
            <div class="ec_ser_content ec_ser_content_4 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                <div class="ec_ser_inner">
                    <div class="ec-service-image">
                        <i class="fi fi-ts-donate"></i>
                    </div>
                    <div class="ec-service-desc text-center">
                        <h2>Thanh toán an toàn</h2>
                        <p>Thanh toán bảo mật với nhiều phương thức hỗ trợ.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Ec Brand Section End -->
<div class="ec-style ec-right-bottom">
    <!-- Start Floating Panel Container -->
    <div class="ec-panel" style="display: block;">
        <!-- Panel Header -->
        <div class="ec-header">
            <strong>Cần hỗ trợ?</strong>
            <p>Liên hệ với nhân viên?</p>
        </div>
        <!-- Panel Content -->
        <div class="ec-body">
            <ul>
                <!-- Start Single Contact List -->

                @foreach($users as $item)
                @php
                $checkUrlImg = \Illuminate\Support\Str::contains($item->image, '/userfiles/') ? $item->image : Storage::url($item->image);
                @endphp
                <li id="user{{ $item->id }}">
                    <a class="ec-list" href="{{ route('chat-private', $item->id) }}">
                        <div class="d-flex bd-highlight">
                            <!-- Profile Picture -->
                            <div class="ec-img-cont">
                                @if(isset($item->image))
                                <img src="{{$checkUrlImg }}" class="ec-user-img" alt="Profile image">
                                @else
                                <img src="{{ asset('theme/client/assets/images/whatsapp/admin.jpg') }}" class="ec-user-img" alt="Profile image">
                                @endif
                            </div>

                            <!-- Display Name & Last Seen -->
                            <div class="ec-user-info">
                                <span>{{ $item->name }}</span>
                                <!-- Phần tử hiển thị thời gian hoạt động -->
                                <p style="margin-top: 2px;" class="activity-time"></p>
                            </div>

                            <!-- Chat Icon -->
                            <div class="ec-chat-icon">
                                <i class="fa fa-whatsapp"></i>
                            </div>
                        </div>
                    </a>
                </li>


                @endforeach
                <!--/ End Single Contact List -->
            </ul>
        </div>
    </div>
    <!--/ End Floating Panel Container -->
    <!-- Start Right Floating Button-->
    <div class="ec-right-bottom">
        <div class="ec-box">
            <div class="ec-button rotateForward">
                <img class="whatsapp" src="{{ asset('theme/client/assets/images/common/whatsapp.png') }}" alt="whatsapp icon">
            </div>
        </div>
    </div>
    <!--/ End Right Floating Button-->

</div>
<!-- Whatsapp end -->
@endsection