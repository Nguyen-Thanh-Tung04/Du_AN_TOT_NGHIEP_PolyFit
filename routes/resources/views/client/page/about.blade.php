@extends('client.layouts.master')

@section('content')

    <!-- ekka Cart Start -->
    <div class="ec-side-cart-overlay"></div>
    <div id="ec-side-cart" class="ec-side-cart">
        <div class="ec-cart-inner">
            <div class="ec-cart-top">
                <div class="ec-cart-title">
                    <span class="cart_title">My Cart</span>
                    <button class="ec-close">×</button>
                </div>
                <ul class="eccart-pro-items">
                    <li>
                        <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                src="{{asset('theme/client/assets/images/product-image/6_1.jpg')}}" alt="product"></a>
                        <div class="ec-pro-content">
                            <a href="product-left-sidebar.html" class="cart_pro_title">T-shirt For Women</a>
                            <span class="cart-price"><span>$76.00</span> x 1</span>
                            <div class="qty-plus-minus">
                                <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                            </div>
                            <a href="javascript:void(0)" class="remove">×</a>
                        </div>
                    </li>
                    <li>
                        <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                src="{{asset('theme/client/assets/images/product-image/12_1.jpg')}}" alt="product"></a>
                        <div class="ec-pro-content">
                            <a href="product-left-sidebar.html" class="cart_pro_title">Women Leather Shoes</a>
                            <span class="cart-price"><span>$64.00</span> x 1</span>
                            <div class="qty-plus-minus">
                                <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                            </div>
                            <a href="javascript:void(0)" class="remove">×</a>
                        </div>
                    </li>
                    <li>
                        <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                src="{{asset('theme/client/assets/images/product-image/3_1.jpg')}}" alt="product"></a>
                        <div class="ec-pro-content">
                            <a href="product-left-sidebar.html" class="cart_pro_title">Girls Nylon Purse</a>
                            <span class="cart-price"><span>$59.00</span> x 1</span>
                            <div class="qty-plus-minus">
                                <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                            </div>
                            <a href="javascript:void(0)" class="remove">×</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="ec-cart-bottom">
                <div class="cart-sub-total">
                    <table class="table cart-table">
                        <tbody>
                            <tr>
                                <td class="text-left">Sub-Total :</td>
                                <td class="text-right">$300.00</td>
                            </tr>
                            <tr>
                                <td class="text-left">VAT (20%) :</td>
                                <td class="text-right">$60.00</td>
                            </tr>
                            <tr>
                                <td class="text-left">Total :</td>
                                <td class="text-right primary-color">$360.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="cart_btn">
                    <a href="cart.html" class="btn btn-primary">View Cart</a>
                    <a href="checkout.html" class="btn btn-secondary">Checkout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ekka Cart End -->

    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Giới thiệu</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                                <li class="ec-breadcrumb-item active">Giới thiệu</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- Ec About Us page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Giới thiệu về chúng tôi</h2>
                        <h2 class="ec-title">Giới thiệu về chúng tôi</h2>
                        <p class="sub-title mb-3">Về công ty kinh doanh của chúng tôi</p>
                    </div>
                </div>
                <div class="ec-common-wrapper">
                    <div class="row">
                        <div class="col-md-6 ec-cms-block ec-abcms-block text-center">
                            <div class="ec-cms-block-inner">
                            <img class="a-img" src="{{asset('theme/client/assets/images/offer-image/1.jpg')}}" alt="about">
                            </div>
                        </div>
                        <div class="col-md-6 ec-cms-block ec-abcms-block text-center">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Bạn biết gì về PolyFit ?</h3>
                                <p>SỨ MỆNH
                                    Không ngừng sáng tạo và tỉ mỉ từ công đoạn sản xuất đến 
                                    các khâu dịch vụ, nhằm mang đến cho Quý Khách Hàng những 
                                    trải nghiệm mua sắm đặc biệt nhất: sản phẩm chất lượng - dịch 
                                    vụ hoàn hảo - xu hướng thời trang mới mẻ và tinh tế. Thông qua các 
                                    sản phẩm thời trang, PolyFit luôn mong muốn truyền tải đến bạn những thông
                                     điệp tốt đẹp cùng với nguồn cảm hứng trẻ trung và tích cực.</p>
                                <p>TẦM NHÌN
                                    Với mục tiêu xây dựng và phát triển những giá trị bền vững,
                                     trong 10 năm tới, PolyFit sẽ trở thành thương hiệu dẫn đầu về
                                      thời trang phái mạnh trên thị trường Việt Nam.</p>
                                <p>THÔNG ĐIỆP PolyFit GỬI ĐẾN BẠN

                                    PolyFit muốn truyền cảm hứng tích cực đến các chàng trai:
                                     Việc mặc đẹp rất quan trọng, nó thể hiện được cá tính,
                                      sự tự tin và cả một phần lối sống, cách suy nghĩ của bản thân. 
                                      Mặc thanh lịch, sống thanh lịch.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ec testmonial Start -->
    <section class="section ec-test-section section-space-ptb-100 section-space-m" id="reviews">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title mb-0">
                        <h2 class="ec-bg-title">Testimonial</h2>
                        <h2 class="ec-title">Đánh giá của khách hàng</h2>
                        <p class="sub-title mb-3">Khách hàng nói gì về chúng tôi</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="ec-test-outer">
                    <ul id="ec-testimonial-slider">
                        <li class="ec-test-item">
                            <i class="fi-rr-quote-right top"></i>
                            <div class="ec-test-inner">
                                <div class="ec-test-img"><img alt="testimonial" title="testimonial"
                                        src="{{asset('theme/client/assets/images/testimonial/1.jpg')}}" /></div>
                                <div class="ec-test-content">
                                    <div class="ec-test-desc">Lúc đầu mình không kỳ vọng nhiều vì mua online. Nhưng khi nhận rất ok nha chất vải và mẫu đẹp so với giá tiền. Phần eo có cách điệu nên che khuyết điểm vòng 2 to tốt, tôn dáng. Ship giao hành nhanh và thân thiện.</div>
                                    <div class="ec-test-name">Thanh Tùng</div>
                                    <div class="ec-test-designation">Tổng giám đốc</div>
                                    <div class="ec-test-rating">
                                        <i class="ecicon eci-star fill"></i>
                                        <i class="ecicon eci-star fill"></i>
                                        <i class="ecicon eci-star fill"></i>
                                        <i class="ecicon eci-star fill"></i>
                                        <i class="ecicon eci-star fill"></i>
                                    </div>
                                </div>
                            </div>
                            <i class="fi-rr-quote-right bottom"></i>
                        </li>
                        <li class="ec-test-item ">
                            <i class="fi-rr-quote-right top"></i>
                            <div class="ec-test-inner">
                                <div class="ec-test-img"><img alt="testimonial" title="testimonial"
                                        src="{{asset('theme/client/assets/images/testimonial/2.jpg')}}" /></div>
                                <div class="ec-test-content">
                                    <div class="ec-test-desc">Em áo ba lỗ này form đẹp, tôn dáng lắm ạ. Em 46kg mặc size M thoải mái. Vải  mát, co giãn phù hợp để đi tập thể dục, mặc cùng áo vest đi làm được luôn ấy. Đóng gói cẩn thận, còn tặng thêm buộc tóc dễ thương, giao hàng nhanh. Với mức giá này là ok, mọi người nên mua nhé.</div>
                                    <div class="ec-test-name">Quang Toản</div>
                                    <div class="ec-test-designation">Phó giám đốc</div>
                                    <div class="ec-test-rating">
                                        <i class="ecicon eci-star fill"></i>
                                        <i class="ecicon eci-star fill"></i>
                                        <i class="ecicon eci-star fill"></i>
                                        <i class="ecicon eci-star fill"></i>
                                        <i class="ecicon eci-star fill"></i>
                                    </div>
                                </div>
                            </div>
                            <i class="fi-rr-quote-right bottom"></i>
                        </li>
                        <li class="ec-test-item">
                            <i class="fi-rr-quote-right top"></i>
                            <div class="ec-test-inner">
                                <div class="ec-test-img"><img alt="testimonial" title="testimonial"
                                        src="{{asset('theme/client/assets/images/testimonial/3.jpg')}}" /></div>
                                <div class="ec-test-content">
                                    <div class="ec-test-desc">Mua đúng đợt sale nên em váy yếm jean này chỉ có hơn 200k. 
                                        Chất jean co giãn xịn sò, dễ phối đồ, mặc được 4 mùa. Quá ưng luôn.</div>
                                    <div class="ec-test-name">Văn Dương</div>
                                    <div class="ec-test-designation">Thư kí</div>
                                    <div class="ec-test-rating">
                                        <i class="ecicon eci-star fill"></i>
                                        <i class="ecicon eci-star fill"></i>
                                        <i class="ecicon eci-star fill"></i>
                                        <i class="ecicon eci-star fill"></i>
                                        <i class="ecicon eci-star fill"></i>
                                    </div>
                                </div>
                            </div>
                            <i class="fi-rr-quote-right bottom"></i>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- ec testmonial end -->

    <!--  services Section Start -->
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

    <!-- Ec Instagram Start -->
    <section class="section ec-instagram-section module section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Nguồn cấp dữ liệu Instagram</h2>
<h2 class="ec-title">Nguồn cấp dữ liệu Instagram</h2>
<p class="sub-title">Chia sẻ cửa hàng của bạn với chúng tôi</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="ec-insta-wrapper">
            <div class="ec-insta-outer">
                <div class="container">
                    <div class="insta-auto">
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img src="{{asset('theme/client/assets/images/instragram-image/1.jpg')}}"
                                        alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img src="{{asset('theme/client/assets/images/instragram-image/2.jpg')}}"
                                        alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img src="{{asset('theme/client/assets/images/instragram-image/3.jpg')}}"
                                        alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img src="{{asset('theme/client/assets/images/instragram-image/4.')}}"
                                        alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img src="{{asset('theme/client/assets/images/instragram-image/5.jpg')}}"
                                        alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img src="{{asset('theme/client/assets/images/instragram-image/6.jpg')}}"
                                        alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img src="{{asset('theme/client/assets/images/instragram-image/7.jpg')}}"
                                        alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Ec Instagram End -->
@endsection