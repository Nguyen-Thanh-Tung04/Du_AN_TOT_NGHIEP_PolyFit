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

<section class="section ec-about-sec section-space-p mt-4">
    <div class="container">
        <div class="row">
            <div class="section-title d-none">
                <h2 class="ec-title">Giới thiệu</h2>
            </div>
            <div class="col-lg-6">
                <div class="ec-about">
                    <img src="{{ asset('theme/client/assets/images/bg/black-friday-8.jpg') }}" alt="about-image">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ec-about-detail">
                    <h4 class="text-upper" style="font-weight: 700;">Phong cách nổi bật, đẳng cấp sang trọng nhất.</h4>
                    <h5>Khám phá những mẫu quần áo thời trang phù hợp với xu hướng mới nhất.</h5>
                    <p>Chúng tôi cung cấp những thiết kế độc đáo, chất lượng cao dành cho bạn. Từng sản phẩm đều được chọn lọc kỹ càng để mang lại sự thoải mái và tự tin trong mọi hoạt động.</p>
                    <p>Đừng bỏ lỡ cơ hội sở hữu những bộ trang phục hiện đại, giúp bạn thể hiện cá tính và gu thẩm mỹ của mình.</p>
                    <a class="btn btn-lg btn-primary" href="{{ route('home.shop') }}">Mua ngay</a>

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

@if ($productsFlashSale->isNotEmpty())
<section class="section ec-catalog-multi-vendor margin-bottom-30 bg-white">
    <div class="container">
        <div class="time-sale">
            <svg viewBox="0 0 108 21" height="21" width="108" class="flash-sale-logo flash-sale-logo--white">
                <g fill="currentColor" fill-rule="evenodd">
                    <path d="M0 16.195h3.402v-5.233h4.237V8H3.402V5.037h5.112V2.075H0zm29.784 0l-.855-2.962h-4.335l-.836 2.962H20.26l4.723-14.12h3.576l4.724 14.12zM26.791 5.294h-.04s-.31 1.54-.563 2.43l-.797 2.744h2.74l-.777-2.745c-.252-.889-.563-2.43-.563-2.43zm7.017 9.124s1.807 2.014 5.073 2.014c3.13 0 4.898-2.034 4.898-4.384 0-4.463-6.259-4.147-6.259-5.925 0-.79.778-1.106 1.477-1.106 1.672 0 3.071 1.245 3.071 1.245l1.439-2.824s-1.477-1.6-4.47-1.6c-2.76 0-4.918 1.718-4.918 4.325 0 4.345 6.258 4.285 6.258 5.964 0 .85-.758 1.126-1.457 1.126-1.75 0-3.324-1.462-3.324-1.462zm12.303 1.777h3.402v-5.53h5.054v5.53h3.401V2.075h-3.401v5.648h-5.054V2.075h-3.402zm18.64-1.678s1.692 1.915 4.763 1.915c2.877 0 4.548-1.876 4.548-4.107 0-4.483-6.492-3.871-6.492-6.36 0-.987.914-1.678 2.08-1.678 1.73 0 3.052 1.224 3.052 1.224l1.088-2.073s-1.4-1.501-4.12-1.501c-2.644 0-4.627 1.738-4.627 4.068 0 4.305 6.512 3.87 6.512 6.379 0 1.145-.952 1.698-2.002 1.698-1.944 0-3.44-1.48-3.44-1.48zm19.846 1.678l-1.166-3.594h-4.84l-1.166 3.594H74.84L79.7 2.174h2.623l4.86 14.021zM81.04 4.603h-.039s-.31 1.382-.583 2.172l-1.224 3.752h3.615l-1.224-3.752c-.253-.79-.545-2.172-.545-2.172zm7.911 11.592h8.475v-2.192H91.46V2.173H88.95zm10.477 0H108v-2.192h-6.064v-3.772h4.645V8.04h-4.645V4.366h5.753V2.174h-8.26zM14.255.808l6.142.163-3.391 5.698 3.87 1.086-8.028 12.437.642-8.42-3.613-1.025z"></path>
                </g>
            </svg>
            <svg height="20" viewBox="0 0 20 20" width="20" class="shop-svg-icon _17VGnS ">
                <g fill="none" fill-rule="evenodd" stroke="#fff" stroke-width="1.8" transform="translate(1 1)">
                    <circle cx="9" cy="9" r="9"></circle>
                    <path d="m11.5639648 5.05283203v4.71571528l-2.72832027 1.57129639" stroke-linecap="round" stroke-linejoin="round" transform="matrix(-1 0 0 1 20.39961 0)"></path>
                </g>
            </svg>
            {{-- <div class="end-text">Kết thúc trong</div> --}}
            <div class="flash-sale-countdown" id="the-24h-countdown">
                <p></p>
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

                                        <!-- Progress Bar -->
                                        <span class="textLeft mt-2">
                                            @if ($product->variants->sum('quantity') === 0)
                                            🔥 Cháy hết hàng
                                            @elseif ($product->progress > 80)
                                            🔥 Sắp cháy hàng
                                            @else
                                            🔥 Đang bán chạy
                                            {{-- ({{ round($product->progress, 2) }}%) --}}
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
                                <span class="ec-banner-btn"><a href="{{ route('home.shop') }}">Đặt hàng ngay</a></span>
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
                                <span class="ec-banner-btn"><a href="{{ route('home.shop') }}">Đặt hàng ngay</a></span>
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
                                        {{-- <div class="ec-link-btn">
                                            <a class=" ec-add-to-cart" href="{{ route('client.product.show', $product->id) }}">Mua ngay</a>
                                    </div> --}}
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