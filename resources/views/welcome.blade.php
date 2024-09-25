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
                                    <a href="{{ url('/product_detail')}}" class="btn btn-lg btn-secondary">Đặt hàng ngay</a>
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
                                    <h1 class="ec-slide-title">Bộ tai nghe thuyền</h1>
                                    <h2 class="ec-slide-stitle">Khuyến mại</h2>
                                    <p>Chúng tôi hi vọng sẽ giúp thỏa mãn mong muốn mua sắm của quý khách !</p>
                                    <a href="{{ url('/product_detail')}}" class="btn btn-lg btn-secondary">Đặt hàng ngay</a>
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
	
    <!-- Product tab Area Start -->
    <section class="section ec-product-tab section-space-p" id="collection">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">PolyFit</h2>
                        <h2 class="ec-title">PolyFit</h2>
                        <p class="sub-title">PolyFit - Sự Lựa Chọn Hoàn Hảo Cho Bạn</p>
                    </div>
                </div>

                <!-- Tab Start -->
                <div class="col-md-12 text-center">
                    <ul class="ec-pro-tab-nav nav justify-content-center">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="{{ url('/product_detail')}}tab-pro-for-all">Tất cả sản phẩm</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="{{ url('/product_detail')}}tab-pro-for-men">Sản phẩm mới nhất</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="{{ url('/product_detail')}}tab-pro-for-women">Sản phẩm giảm giá</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="{{ url('/product_detail')}}tab-pro-for-child">Sản phẩm xả hàng</a></li>
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
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <!-- START single card -->
                                    <div class="ec-product-ds">
                                        <div class="ec-product-image">
                                            <a href="{{ url('/product_detail')}}" class="image">
                                                <img class="pic-1" src="{{asset('theme/client/assets/images/product-image/18_1.jpg')}}" alt="" />
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
                                            <h3 class="ec-title"><a href="{{ url('/product_detail')}}">Boaty air pods s8</a></h3>
                                            <div class="ec-price"><span>$90.00</span> $66.00</div>
                                            <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">add to cart</a>
                                        </div>
                                    </div>
                                    <!--/END single card -->
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <!-- START single card -->
                                    <div class="ec-product-ds">
                                        <div class="ec-product-image">
                                            <a href="{{ url('/product_detail')}}" class="image">
                                                <img class="pic-1" src="{{asset('theme/client/assets/images/product-image/6_1.jpg')}}" alt="" />
                                            </a>
                                        </div>
                                        <div class="ec-product-body">
                                            <ul class="ec-rating">
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star"></li>
                                            </ul>
                                            <h3 class="ec-title"><a href="{{ url('/product_detail')}}">Long slive t-shirt</a></h3>
                                            <div class="ec-price">$79.90</div>
                                            <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">add to cart</a>
                                        </div>
                                    </div>
                                    <!--/END single card -->
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <!-- START single card -->
                                    <div class="ec-product-ds">
                                        <div class="ec-product-image">
                                            <a href="{{ url('/product_detail')}}" class="image">
                                                <img class="pic-1" src="{{asset('theme/client/assets/images/product-image/3_1.jpg')}}" alt="" />
                                            </a>
                                            
                                        </div>
                                        <div class="ec-product-body">
                                            <ul class="ec-rating">
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star"></li>
                                            </ul>
                                            <h3 class="ec-title"><a href="{{ url('/product_detail')}}">Leather purse for women</a></h3>
                                            <div class="ec-price">$56.90</div>
                                            <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">add to cart</a>
                                        </div>
                                    </div>
                                    <!--/END single card -->
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <!-- START single card -->
                                    <div class="ec-product-ds">
                                        <div class="ec-product-image">
                                            <a href="{{ url('/product_detail')}}" class="image">
                                                <img class="pic-1" src="{{asset('theme/client/assets/images/product-image/4_1.jpg')}}" alt="" />
                                            </a>
                                            
                                        </div>
                                        <div class="ec-product-body">
                                            <ul class="ec-rating">
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star"></li>
                                            </ul>
                                            <h3 class="ec-title"><a href="{{ url('/product_detail')}}">Hool hat for men</a></h3>
                                            <div class="ec-price">$79.90</div>
                                            <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">add to cart</a>
                                        </div>
                                    </div>
                                    <!--/END single card -->
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <!-- START single card -->
                                    <div class="ec-product-ds">
                                        <div class="ec-product-image">
                                            <a href="{{ url('/product_detail')}}" class="image">
                                                <img class="pic-1" src="{{asset('theme/client/assets/images/product-image/18_1.jpg')}}" alt="" />
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
                                            <h3 class="ec-title"><a href="{{ url('/product_detail')}}">Boaty air pods s8</a></h3>
                                            <div class="ec-price"><span>$90.00</span> $66.00</div>
                                            <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">add to cart</a>
                                        </div>
                                    </div>
                                    <!--/END single card -->
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <!-- START single card -->
                                    <div class="ec-product-ds">
                                        <div class="ec-product-image">
                                            <a href="{{ url('/product_detail')}}" class="image">
                                                <img class="pic-1" src="{{asset('theme/client/assets/images/product-image/6_1.jpg')}}" alt="" />
                                            </a>
                                            
                                        </div>
                                        <div class="ec-product-body">
                                            <ul class="ec-rating">
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star"></li>
                                            </ul>
                                            <h3 class="ec-title"><a href="{{ url('/product_detail')}}">Long slive t-shirt</a></h3>
                                            <div class="ec-price">$79.90</div>
                                            <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">add to cart</a>
                                        </div>
                                    </div>
                                    <!--/END single card -->
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <!-- START single card -->
                                    <div class="ec-product-ds">
                                        <div class="ec-product-image">
                                            <a href="{{ url('/product_detail')}}" class="image">
                                                <img class="pic-1" src="{{asset('theme/client/assets/images/product-image/3_1.jpg')}}" alt="" />
                                            </a>
                                            
                                        </div>
                                        <div class="ec-product-body">
                                            <ul class="ec-rating">
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star"></li>
                                            </ul>
                                            <h3 class="ec-title"><a href="{{ url('/product_detail')}}">Leather purse for women</a></h3>
                                            <div class="ec-price">$56.90</div>
                                            <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">add to cart</a>
                                        </div>
                                    </div>
                                    <!--/END single card -->
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <!-- START single card -->
                                    <div class="ec-product-ds">
                                        <div class="ec-product-image">
                                            <a href="{{ url('/product_detail')}}" class="image">
                                                <img class="pic-1" src="{{asset('theme/client/assets/images/product-image/4_1.jpg')}}" alt="" />
                                            </a>
                                            
                                        </div>
                                        <div class="ec-product-body">
                                            <ul class="ec-rating">
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star fill"></li>
                                                <li class="ecicon eci-star"></li>
                                            </ul>
                                            <h3 class="ec-title"><a href="{{ url('/product_detail')}}">Hool hat for men</a></h3>
                                            <div class="ec-price">$79.90</div>
                                            <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">add to cart</a>
                                        </div>
                                    </div>
                                    <!--/END single card -->
                                </div>
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
        </div>
    </section>
    <!-- ec Product tab Area End -->

    <!--  Category Section Start -->
    <section class="section ec-category-section section-space-p" id="categories">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Top Danh mục</h2>
                        <h2 class="ec-title">Top Danh mục</h2>
                        <p class="sub-title">PolyFit - Sự Lựa Chọn Hoàn Hảo Cho Bạn</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <!--Category Nav Start -->
                <div class="col-lg-3">
                    <ul class="ec-cat-tab-nav nav">
                        <li class="cat-item"><a class="cat-link active" data-bs-toggle="tab" href="{{ url('/product_detail')}}tab-cat-1">
                                <div class="cat-icons"><img class="cat-icon" src="{{asset('theme/client/assets/images/icons/cat_1.png')}}"
                                        alt="cat-icon"><img class="cat-icon-hover" src="{{asset('theme/client/assets/images/icons/cat_1_1.png')}}"
                                        alt="cat-icon"></div>
                                <div class="cat-desc"><span>Clothes</span><span>440 Products</span></div>
                            </a></li>
                        <li class="cat-item"><a class="cat-link" data-bs-toggle="tab" href="{{ url('/product_detail')}}tab-cat-2">
                                <div class="cat-icons"><img class="cat-icon" src="{{asset('theme/client/assets/images/icons/cat_2.png')}}"
                                        alt="cat-icon"><img class="cat-icon-hover" src="{{asset('theme/client/assets/images/icons/cat_2_1.png')}}"
                                        alt="cat-icon"></div>
                                <div class="cat-desc"><span>Watches</span><span>510 Products</span></div>
                            </a></li>
                        <li class="cat-item"><a class="cat-link" data-bs-toggle="tab" href="{{ url('/product_detail')}}tab-cat-3">
                                <div class="cat-icons"><img class="cat-icon" src="{{asset('theme/client/assets/images/icons/cat_3.png')}}"
                                        alt="cat-icon"><img class="cat-icon-hover" src="{{asset('theme/client/assets/images/icons/cat_3_1.png')}}"
                                        alt="cat-icon"></div>
                                <div class="cat-desc"><span>Bags</span><span>620 Products</span></div>
                            </a></li>
                        <li class="cat-item"><a class="cat-link" data-bs-toggle="tab" href="{{ url('/product_detail')}}tab-cat-4">
                                <div class="cat-icons"><img class="cat-icon" src="{{asset('theme/client/assets/images/icons/cat_4.png')}}"
                                        alt="cat-icon"><img class="cat-icon-hover" src="{{asset('theme/client/assets/images/icons/cat_4_1.png')}}"
                                        alt="cat-icon"></div>
                                <div class="cat-desc"><span>Shoes</span><span>320 Products</span></div>
                            </a></li>
                    </ul>

                </div>
                <!-- Category Nav End -->
                <!--Category Tab Start -->
                <div class="col-lg-9">
                    <div class="tab-content">
                        <!-- 1st Category tab end -->
                        <div class="tab-pane fade show active" id="tab-cat-1">
                            <div class="row">
                                <img src="{{asset('theme/client/assets/images/cat-banner/1.jpg')}}" alt="" />
                                </div>
                            <span class="panel-overlay">
                                <a href="shop-left-sidebar-col-3.html" class="btn btn-primary">View All</a>
                            </span>
                        </div>
                        <!-- 1st Category tab end -->
                        <div class="tab-pane fade" id="tab-cat-2">
                            <div class="row">
                                <img src="{{asset('theme/client/assets/images/cat-banner/2.jpg')}}" alt="" />
                            </div>
                            <span class="panel-overlay">
                                <a href="shop-left-sidebar-col-3.html" class="btn btn-primary">View All</a>
                            </span>
                        </div>
                        <!-- 2nd Category tab end -->
                        <!-- 3rd Category tab start -->
                        <div class="tab-pane fade" id="tab-cat-3">
                            <div class="row">
                                <img src="{{asset('theme/client/assets/images/cat-banner/3.jpg')}}" alt="" />
                            </div>
                            <span class="panel-overlay">
                                <a href="shop-left-sidebar-col-3.html" class="btn btn-primary">View All</a>
                            </span>
                        </div>
                        <!-- 3rd Category tab end -->
                        <!-- 4th Category tab start -->
                        <div class="tab-pane fade" id="tab-cat-4">
                            <div class="row">
                                <img src="{{asset('theme/client/assets/images/cat-banner/4.jpg')}}" alt="" />
                            </div>
                            <span class="panel-overlay">
                                <a href="shop-left-sidebar-col-3.html" class="btn btn-primary">View All</a>
                            </span>
                        </div>
                        <!-- 4th Category tab end -->
                    </div>
                    <!-- Category Tab End -->
                </div>
            </div>
        </div>
    </section>
    <!-- Category Section End -->
     <!--  Top Vendor Section Start -->
     <section class="section section-space-p" id="vendors">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Top Brand</h2>
                        <h2 class="ec-title">Top Brand</h2>
                        <p class="sub-title">PolyFit - Sự Lựa Chọn Hoàn Hảo Cho Bạn <a href="catalog-multi-vendor.html">All
                                Vendors.</a></p>
                    </div>
                </div>
            </div>
            <div class="row margin-minus-t-15 margin-minus-b-15">
                <div class="col-sm-12 col-md-6 col-lg-3 ec_ven_content" data-animation="zoomIn">
                    <div class="ec-vendor-card">
                        <div class="ec-vendor-detail">
                            <div class="ec-vendor-avtar">
                                <img src="{{asset('theme/client/assets/images/vendor/2.jpg')}}" alt="vendor img">
                            </div>
                            <div class="ec-vendor-info">
                                <a href="catalog-single-vendor.html" class="name">Marvelus</a>
                                <p class="prod-count">154 Products</p>
                                <div class="ec-pro-rating">
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star"></i>
                                </div>
                                <div class="ec-sale">
                                    <p title="Weekly sales">Sales 954</p>
                                </div>
                            </div>
                        </div>
                        <div class="ec-vendor-prod">
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/1_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/2_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/3_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/4_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 ec_ven_content" data-animation="zoomIn">
                    <div class="ec-vendor-card">
                        <div class="ec-vendor-detail">
                            <div class="ec-vendor-avtar">
                                <img src="{{asset('theme/client/assets/images/vendor/3.jpg')}}" alt="vendor img">
                            </div>
                            <div class="ec-vendor-info">
                                <a href="catalog-single-vendor.html" class="name">Oreva Fashion</a>
                                <p class="prod-count">546 Products</p>
                                <div class="ec-pro-rating">
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star fill"></i>
                                </div>
                                <div class="ec-sale">
                                    <p title="Weekly sales">Sales 785</p>
                                </div>
                            </div>
                        </div>
                        <div class="ec-vendor-prod">
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/5_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/6_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/7_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/8_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 ec_ven_content" data-animation="zoomIn">
                    <div class="ec-vendor-card">
                        <div class="ec-vendor-detail">
                            <div class="ec-vendor-avtar">
                                <img src="{{asset('theme/client/assets/images/vendor/4.jpg')}}" alt="vendor img">
                            </div>
                            <div class="ec-vendor-info">
                                <a href="catalog-single-vendor.html" class="name">Cenva Art</a>
                                <p class="prod-count">854 Products</p>
                                <div class="ec-pro-rating">
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star"></i>
                                    <i class="ecicon eci-star"></i>
                                </div>
                                <div class="ec-sale">
                                    <p title="Weekly sales">Sales 587</p>
                                </div>
                            </div>
                        </div>
                        <div class="ec-vendor-prod">
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/9_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/10_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/11_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/12_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 ec_ven_content" data-animation="zoomIn">
                    <div class="ec-vendor-card">
                        <div class="ec-vendor-detail">
                            <div class="ec-vendor-avtar">
                                <img src="{{asset('theme/client/assets/images/vendor/5.jpg" alt="ven')}}dor img">
                            </div>
                            <div class="ec-vendor-info">
                                <a href="catalog-single-vendor.html" class="name">Neon Fashion</a>
                                <p class="prod-count">154 Products</p>
                                <div class="ec-pro-rating">
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star fill"></i>
                                    <i class="ecicon eci-star fill"></i>
                                </div>
                                <div class="ec-sale">
                                    <p title="Weekly sales">Sales 354</p>
                                </div>
                            </div>
                        </div>
                        <div class="ec-vendor-prod">
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/13_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/14_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/15_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                            <div class="ec-prod-img">
                                <a href="{{ url('/product_detail')}}"><img src="{{asset('theme/client/assets/images/product-image/16_1.jpg')}}"
                                        alt="vendor img"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  Top Vendor Section End -->

    <section class="section ec-services-section section-space-p" id="services">
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
    </section>
    <!--services Section End -->

    <!--  offer Section Start -->
    <section class="section ec-offer-section section-space-p section-space-m">
        <h2 class="d-none">Offer</h2>
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center ec-offer-content">
                    <h2 class="ec-offer-title">Sunglasses</h2>
                    <h3 class="ec-offer-stitle" data-animation="slideInDown">Super Offer</h3>
                    <span class="ec-offer-img" data-animation="zoomIn"><img src="assets/images/offer-image/1.png"
                            alt="offer image" /></span>
                    <span class="ec-offer-desc">Acetate Frame Sunglasses</span>
                    <span class="ec-offer-price">$40.00 Only</span>
                    <a class="btn btn-primary" href="shop-left-sidebar-col-3.html" data-animation="zoomIn">Shop Now</a>
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
            <div class="col-lg-3 col-md-6 col-sm-6">
                <!-- START single card -->
                <div class="ec-product-ds">
                    <div class="ec-product-image">
                        <a href="{{ url('/product_detail')}}" class="image">
                            <img class="pic-1" src="{{asset('theme/client/assets/images/product-image/18_1.jpg')}}" alt="" />
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
                        <h3 class="ec-title"><a href="{{ url('/product_detail')}}">Boaty air pods s8</a></h3>
                        <div class="ec-price"><span>$90.00</span> $66.00</div>
                        <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">add to cart</a>
                    </div>
                </div>
                <!--/END single card -->
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <!-- START single card -->
                <div class="ec-product-ds">
                    <div class="ec-product-image">
                        <a href="{{ url('/product_detail')}}" class="image">
                            <img class="pic-1" src="{{asset('theme/client/assets/images/product-image/6_1.jpg')}}" alt="" />
                        </a>
                    </div>
                    <div class="ec-product-body">
                        <ul class="ec-rating">
                            <li class="ecicon eci-star fill"></li>
                            <li class="ecicon eci-star fill"></li>
                            <li class="ecicon eci-star fill"></li>
                            <li class="ecicon eci-star fill"></li>
                            <li class="ecicon eci-star"></li>
                        </ul>
                        <h3 class="ec-title"><a href="{{ url('/product_detail')}}">Long slive t-shirt</a></h3>
                        <div class="ec-price">$79.90</div>
                        <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">add to cart</a>
                    </div>
                </div>
                <!--/END single card -->
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <!-- START single card -->
                <div class="ec-product-ds">
                    <div class="ec-product-image">
                        <a href="{{ url('/product_detail')}}" class="image">
                            <img class="pic-1" src="{{asset('theme/client/assets/images/product-image/3_1.jpg')}}" alt="" />
                        </a>
                        
                    </div>
                    <div class="ec-product-body">
                        <ul class="ec-rating">
                            <li class="ecicon eci-star fill"></li>
                            <li class="ecicon eci-star fill"></li>
                            <li class="ecicon eci-star fill"></li>
                            <li class="ecicon eci-star fill"></li>
                            <li class="ecicon eci-star"></li>
                        </ul>
                        <h3 class="ec-title"><a href="{{ url('/product_detail')}}">Leather purse for women</a></h3>
                        <div class="ec-price">$56.90</div>
                        <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">add to cart</a>
                    </div>
                </div>
                <!--/END single card -->
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <!-- START single card -->
                <div class="ec-product-ds">
                    <div class="ec-product-image">
                        <a href="{{ url('/product_detail')}}" class="image">
                            <img class="pic-1" src="{{asset('theme/client/assets/images/product-image/4_1.jpg')}}" alt="" />
                        </a>
                        
                    </div>
                    <div class="ec-product-body">
                        <ul class="ec-rating">
                            <li class="ecicon eci-star fill"></li>
                            <li class="ecicon eci-star fill"></li>
                            <li class="ecicon eci-star fill"></li>
                            <li class="ecicon eci-star fill"></li>
                            <li class="ecicon eci-star"></li>
                        </ul>
                        <h3 class="ec-title"><a href="{{ url('/product_detail')}}">Hool hat for men</a></h3>
                        <div class="ec-price">$79.90</div>
                        <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">add to cart</a>
                    </div>
                </div>
                <!--/END single card -->
            </div>
        </div>
    </div>
</section>
<!-- New Product end -->
    <!-- Ec Brand Section Start -->
    <section class="section ec-brand-area section-space-p">
        <h2 class="d-none">Brand</h2>
        <div class="container">
            <div class="row">
                <div class="ec-brand-outer">
                    <ul id="ec-brand-slider">
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail')}}"><img alt="brand" title="brand"
                                        src="{{asset('theme/client/assets/images/brand-image/1.png')}}" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail')}}"><img alt="brand" title="brand"
                                        src="{{asset('theme/client/assets/images/brand-image/2.png')}}" /></a></div>
                        </li>
                       
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail')}}"><img alt="brand" title="brand"
                                        src="{{asset('theme/client/assets/images/brand-image/4.png')}}" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail')}}"><img alt="brand" title="brand"
                                        src="{{asset('theme/client/assets/images/brand-image/5.png')}}" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail')}}"><img alt="brand" title="brand"
                                        src="{{asset('theme/client/assets/images/brand-image/6.png')}}" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail')}}"><img alt="brand" title="brand"
                                        src="{{asset('theme/client/assets/images/brand-image/7.png')}}" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="{{ url('/product_detail')}}"><img alt="brand" title="brand"
                                        src="{{asset('theme/client/assets/images/brand-image/8.png')}}" /></a></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Ec Brand Section End -->
    

@endsection