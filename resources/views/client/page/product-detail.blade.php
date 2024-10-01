@extends('client.layouts.master')

@section('content')
  <!-- Ec breadcrumb start -->
  <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Chi tiết sản phẩm</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Sản phẩm</li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->

<!-- Sart Single product -->
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="ec-pro-rightside ec-common-rightside col-lg-12 col-md-12">

                <!-- Single product content Start -->
                <div class="single-pro-block">
                    <div class="single-pro-inner">
                        <div class="row">
                            <div class="single-pro-img single-pro-img-no-sidebar">
                                <div class="single-product-scroll">
                                    <div class="single-product-cover">
                                        <div class="single-slide zoom-image-hover">
                                            <img class="img-responsive" src="{{asset('theme/client/assets/images/product-360/1_1.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="single-slide zoom-image-hover">
                                            <img class="img-responsive" src="{{asset('theme/client/assets/images/product-360/1_2.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="single-slide zoom-image-hover">
                                            <img class="img-responsive" src="{{asset('theme/client/assets/images/product-360/1_3.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="single-slide zoom-image-hover">
                                            <img class="img-responsive" src="{{asset('theme/client/assets/images/product-360/1_4.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="single-slide zoom-image-hover">
                                            <img class="img-responsive" src="{{asset('theme/client/assets/images/product-360/1_5.jpg')}}"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="single-nav-thumb">
                                        <div class="single-slide">
                                            <img class="img-responsive" src="{{asset('theme/client/assets/images/product-360/1_1.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="single-slide">
                                            <img class="img-responsive" src="{{asset('theme/client/assets/images/product-360/1_2.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="single-slide">
                                            <img class="img-responsive" src="{{asset('theme/client/assets/images/product-360/1_3.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="single-slide">
                                            <img class="img-responsive" src="{{asset('theme/client/assets/images/product-360/1_4.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="single-slide">
                                            <img class="img-responsive" src="{{asset('theme/client/assets/images/product-360/1_5.jpg')}}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="single-pro-desc single-pro-desc-no-sidebar">
                                <div class="single-pro-content">
                                    <h5 class="ec-single-title">Women Leather Heels Sandal</h5>
                                    <div class="ec-single-rating-wrap">
                                        <div class="ec-single-rating">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star-o"></i>
                                        </div>
                                        <span class="ec-read-review"><a href="#ec-spt-nav-review">Hãy là người đầu tiên
                                            đánh giá sản phẩm này</a></span>
                                    </div>
                                    <div class="ec-single-desc">Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                        text ever since the 1990</div>

                                    <div class="ec-single-sales">
                                        <div class="ec-single-sales-inner">
                                            <div class="ec-single-sales-title">máy tăng tốc bán hàng</div>
                                            <div class="ec-single-sales-visitor">
                                                thời gian thực <span>24</span> khách truy cập ngay bây giờ!</div>
                                            <div class="ec-single-sales-progress">
                                                <span class="ec-single-progress-desc">Nhanh lên! Còn 29 phút nữa</span>
                                                <span class="ec-single-progressbar"></span>
                                            </div>
                                            <div class="ec-single-sales-countdown">
                                                <div class="ec-single-countdown"><span
                                                        id="ec-single-countdown"></span></div>
                                                <div class="ec-single-count-desc">Thời gian sắp hết!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ec-single-price-stoke">
                                        <div class="ec-single-price">
                                            <span class="ec-single-ps-title">THẤP NHẤT</span>
                                            <span class="new-price">$68.00</span>
                                        </div>
                                        <div class="ec-single-stoke">
                                            <span class="ec-single-ps-title">TRONG KHO</span>
                                            <span class="ec-single-sku">Mã Hàng: WH12</span>
                                        </div>
                                    </div>
                                    <div class="ec-pro-variation">
                                        <div class="ec-pro-variation-inner ec-pro-variation-size">
                                            <span>KÍCH cỡ</span>
                                            <div class="ec-pro-variation-content">
                                                <ul>
                                                    <li class="active"><span>7</span></li>
                                                    <li><span>8</span></li>
                                                    <li><span>9</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="ec-pro-variation-inner ec-pro-variation-color">
                                            <span>Màu sắc</span>
                                            <div class="ec-pro-variation-content">
                                                <ul>
                                                    <li class="active"><span
                                                            style="background-color:#23839c;"></span></li>
                                                    <li><span style="background-color:#000;"></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ec-single-qty">
                                        <div class="qty-plus-minus">
                                            <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                                        </div>
                                        <div class="ec-single-cart ">
                                            <button class="btn btn-primary">Thêm giỏ hàng</button>
                                        </div>
                                        <div class="ec-single-wishlist">
                                            <a class="ec-btn-group wishlist" title="Wishlist"><i class="fi-rr-heart"></i></a>
                                        </div>
                                        <div class="ec-single-quickview">
                                            <a href="#" class="ec-btn-group quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                        </div>
                                    </div>
                                    <div class="ec-single-social">
                                        <ul class="mb-0">
                                            <li class="list-inline-item facebook"><a href="#"><i
                                                        class="ecicon eci-facebook"></i></a></li>
                                            <li class="list-inline-item twitter"><a href="#"><i
                                                        class="ecicon eci-twitter"></i></a></li>
                                            <li class="list-inline-item instagram"><a href="#"><i
                                                        class="ecicon eci-instagram"></i></a></li>
                                            <li class="list-inline-item youtube-play"><a href="#"><i
                                                        class="ecicon eci-youtube-play"></i></a></li>
                                            <li class="list-inline-item behance"><a href="#"><i
                                                        class="ecicon eci-behance"></i></a></li>
                                            <li class="list-inline-item whatsapp"><a href="#"><i
                                                        class="ecicon eci-whatsapp"></i></a></li>
                                            <li class="list-inline-item plus"><a href="#"><i
                                                        class="ecicon eci-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Single product content End -->
                <!-- Single product tab start -->
                <div class="ec-single-pro-tab">
                    <div class="ec-single-pro-tab-wrapper">
                        <div class="ec-single-pro-tab-nav">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#ec-spt-nav-details" role="tab" aria-controls="ec-spt-nav-details" aria-selected="true">Chi tiết</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#ec-spt-nav-info"
                                         role="tab" aria-controls="ec-spt-nav-info" aria-selected="false">Thêm thông tin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#ec-spt-nav-review"
                                         role="tab" aria-controls="ec-spt-nav-review" aria-selected="false">Đánh giá</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content  ec-single-pro-tab-content">
                            <div id="ec-spt-nav-details" class="tab-pane fade show active">
                                <div class="ec-single-pro-tab-desc">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                        Lorem Ipsum has been the industry's standard dummy text ever since the
                                        1500s, when an unknown printer took a galley of type and scrambled it to
                                        make a type specimen book. It has survived not only five centuries, but also
                                        the leap into electronic typesetting, remaining essentially unchanged.
                                    </p>
                                    <ul>
                                        <li>Any Product types that You want - Simple, Configurable</li>
                                        <li>Downloadable/Digital Products, Virtual Products</li>
                                        <li>Inventory Management with Backordered items</li>
                                        <li>Flatlock seams throughout.</li>
                                    </ul>
                                </div>
                            </div>
                            <div id="ec-spt-nav-info" class="tab-pane fade">
                                <div class="ec-single-pro-tab-moreinfo">
                                    <ul>
                                        <li><span>Cân nặng</span> 1000 g</li>
                                        <li><span>Kích thước</span> 35 × 30 × 7 cm</li>
                                        <li><span>Màu sắc</span> Đen, Hồng, Đỏ, Trắng</li>
                                    </ul>
                                </div>
                            </div>

                            <div id="ec-spt-nav-review" class="tab-pane fade">
                                <div class="row">
                                    <div class="ec-t-review-wrapper">
                                        <div class="ec-t-review-item">
                                            <div class="ec-t-review-avtar">
                                                <img src="{{asset('theme/client/assets/images/review-image/1.jpg')}}" alt="" />
                                            </div>
                                            <div class="ec-t-review-content">
                                                <div class="ec-t-review-top">
                                                    <div class="ec-t-review-name">Jeny Doe</div>
                                                    <div class="ec-t-review-rating">
                                                        <i class="ecicon eci-star fill"></i>
                                                        <i class="ecicon eci-star fill"></i>
                                                        <i class="ecicon eci-star fill"></i>
                                                        <i class="ecicon eci-star fill"></i>
                                                        <i class="ecicon eci-star-o"></i>
                                                    </div>
                                                </div>
                                                <div class="ec-t-review-bottom">
                                                    <p>Lorem Ipsum is simply dummy text of the printing and
                                                        typesetting industry. Lorem Ipsum has been the industry's
                                                        standard dummy text ever since the 1500s, when an unknown
                                                        printer took a galley of type and scrambled it to make a
                                                        type specimen.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-t-review-item">
                                            <div class="ec-t-review-avtar">
                                                <img src="{{asset('theme/client/assets/images/review-image/2.jpg')}}" alt="" />
                                            </div>
                                            <div class="ec-t-review-content">
                                                <div class="ec-t-review-top">
                                                    <div class="ec-t-review-name">Linda Morgus</div>
                                                    <div class="ec-t-review-rating">
                                                        <i class="ecicon eci-star fill"></i>
                                                        <i class="ecicon eci-star fill"></i>
                                                        <i class="ecicon eci-star fill"></i>
                                                        <i class="ecicon eci-star-o"></i>
                                                        <i class="ecicon eci-star-o"></i>
                                                    </div>
                                                </div>
                                                <div class="ec-t-review-bottom">
                                                    <p>Lorem Ipsum is simply dummy text of the printing and
                                                        typesetting industry. Lorem Ipsum has been the industry's
                                                        standard dummy text ever since the 1500s, when an unknown
                                                        printer took a galley of type and scrambled it to make a
                                                        type specimen.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="ec-ratting-content">
                                        <h3>Thêm một đánh giá</h3>
                                        <div class="ec-ratting-form">
                                            <form action="#">
                                                <div class="ec-ratting-star">
                                                    <span>Đánh giá của bạn:</span>
                                                    <div class="ec-t-review-rating">
                                                        <i class="ecicon eci-star fill"></i>
                                                        <i class="ecicon eci-star fill"></i>
                                                        <i class="ecicon eci-star-o"></i>
                                                        <i class="ecicon eci-star-o"></i>
                                                        <i class="ecicon eci-star-o"></i>
                                                    </div>
                                                </div>
                                                <div class="ec-ratting-input">
                                                    <input name="your-name" placeholder="Tên*" type="text" />
                                                </div>
                                                <div class="ec-ratting-input">
                                                    <input name="your-email" placeholder="Email*" type="email"
                                                        required />
                                                </div>
                                                <div class="ec-ratting-input form-submit">
                                                    <textarea name="your-commemt"
                                                        placeholder="Nhập bình luận của bạn"></textarea>
                                                    <button class="btn btn-primary" type="submit"
                                                        value="Submit">Gửi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- product details description area end -->
            </div>

        </div>
    </div>
</section>
<!-- End Single product -->

<!-- Related Product Start -->
<section class="section ec-releted-product section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">Sản phẩm liên quan</h2>
                    <h2 class="ec-title">Sản phẩm liên quan</h2>
                    <p class="sub-title">Duyệt qua Bộ sưu tập các sản phẩm hàng đầu</p>
                </div>
            </div>
        </div>
        <div class="row margin-minus-b-30">
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
                        <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">Thêm giỏ hàng</a>
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
                        <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">Thêm giỏ hàng</a>
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
                        <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">Thêm giỏ hàng</a>
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
                        <a class=" ec-add-to-cart" href="{{ url('/product_detail')}}">Thêm giỏ hàng</a>
                    </div>
                </div>
                <!--/END single card -->
            </div>
        </div>
    </div>
</section>
<!-- Related Product end -->

@endsection
