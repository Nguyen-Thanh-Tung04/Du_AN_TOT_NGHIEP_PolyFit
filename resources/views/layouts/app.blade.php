<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chat') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js">
    </script>
    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.11.1/dist/sweetalert2.min.css
    " rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <!-- css Icon Font -->
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/vendor/ecicons.min.css')}}" />
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Include jQuery (cần thiết cho Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Main Style -->
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/demo1.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/responsive.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/custom.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/chatbox.css')}}" />

</head>

<body>

    <div id="app">
    @include('client.layouts.header')
        <main class="py-4">
            @yield('content')
        </main>
     <!-- Footer Start -->
 <footer class="ec-footer section-space-mt">
     <div class="footer-container">
         <div class="footer-offer">
             <div class="container">
                 <div class="row">
                     <div class="text-center footer-off-msg">
                         <span>Thời trang chất liệu tạo nên uy tín hàng đâu !</span><a href="#" target="_blank">Cửa hàng</a>
                     </div>
                 </div>
             </div>
         </div>
         <div class="footer-top section-space-footer-p">
             <div class="container">
                 <div class="row">
                     <div class="col-sm-12 col-lg-3 ec-footer-contact">
                         <div class="ec-footer-widget">
                             <div class="ec-footer-logo"><a href="#"><img src="{{ asset('theme/client/assets/images/logo/footer-logo.png') }}"
                                         alt=""><img class="dark-footer-logo" src="{{ asset('theme/client/assets/images/logo/dark-logo.png') }}"
                                         alt="Site Logo" style="display: none;" /></a></div>
                             <h4 class="ec-footer-heading">Liên hệ với chúng tôi</h4>
                             <div class="ec-footer-links">
                                 <ul class="align-items-center">
                                     <li class="ec-footer-link">Số 3 Phương canh , Nam Từ Niêm Hà Nội</li>
                                     <li class="ec-footer-link"><span>Gọi cho chúng tôi:</span><a href="tel:+440123456789">+44
                                             0123 456 789</a></li>
                                     <li class="ec-footer-link"><span>Email:</span><a
                                             href="mailto:example@ec-email.com">+thanhtung123@gmail.com</a></li>
                                 </ul>
                             </div>
                         </div>
                     </div>
                     <div class="col-sm-12 col-lg-2 ec-footer-info">
                         <div class="ec-footer-widget">
                             <h4 class="ec-footer-heading">Thông tin</h4>
                             <div class="ec-footer-links">
                                 <ul class="align-items-center">
                                     <li class="ec-footer-link"><a href="about-us.html">Giới thiệu về chúng tôi</a></li>
                                     <li class="ec-footer-link"><a href="faq.html">Câu hỏi thường gặp</a></li>
                                     <li class="ec-footer-link"><a href="track-order.html">Thông tin giao hàng</a>
                                     </li>
                                     <li class="ec-footer-link"><a href="contact-us.html">Liên hệ với chúng tôi</a></li>
                                 </ul>
                             </div>
                         </div>
                     </div>
                     <div class="col-sm-12 col-lg-2 ec-footer-account">
                         <div class="ec-footer-widget">
                             <h4 class="ec-footer-heading">Tài khoản</h4>
                             <div class="ec-footer-links">
                                 <ul class="align-items-center">
                                     <li class="ec-footer-link"><a href="user-profile.html">Tài khoản của tôi</a></li>
                                     <li class="ec-footer-link"><a href="track-order.html">Lịch sử đơn hàng</a></li>
                                     <li class="ec-footer-link"><a href="wishlist.html">Danh sách mong muốn</a></li>
                                     <li class="ec-footer-link"><a href="offer.html">Khuyến mãi</a></li>
                                 </ul>
                             </div>
                         </div>
                     </div>
                     <div class="col-sm-12 col-lg-2 ec-footer-service">
                         <div class="ec-footer-widget">
                             <h4 class="ec-footer-heading">Dịch vụ</h4>
                             <div class="ec-footer-links">
                                 <ul class="align-items-center">
                                     <li class="ec-footer-link"><a href="track-order.html">Trả hàng giảm giá</a></li>
                                     <li class="ec-footer-link"><a href="privacy-policy.html">Chính sách & chính sách </a>
                                     </li>
                                     <li class="ec-footer-link"><a href="terms-condition.html">Dịch vụ khách hàng</a>
                                     </li>
                                     <li class="ec-footer-link"><a href="terms-condition.html">Điều khoản & điều kiện</a>
                                     </li>
                                 </ul>
                             </div>
                         </div>
                     </div>
                     <div class="col-sm-12 col-lg-3 ec-footer-news">
                         <div class="ec-footer-widget">
                             <h4 class="ec-footer-heading">Bản tin</h4>
                             <div class="ec-footer-links">
                                 <ul class="align-items-center">
                                     <li class="ec-footer-link">Nhận thông tin cập nhật ngay lập tức về các sản phẩm mới và
                                         chương trình khuyến mại đặc biệt của chúng tôi!</li>
                                 </ul>
                                 <div class="ec-subscribe-form">
                                     <form id="ec-newsletter-form" name="ec-newsletter-form" method="post"
                                         action="#">
                                         <div id="ec_news_signup" class="ec-form">
                                             <input class="ec-email" type="email" required=""
                                                 placeholder="Nhập email của bạn tại đây..." name="ec-email" value="" />
                                             <button id="ec-news-btn" class="button btn-primary" type="submit"
                                                 name="subscribe" value=""><i class="ecicon eci-paper-plane-o"
                                                     aria-hidden="true"></i></button>
                                         </div>
                                     </form>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="footer-bottom">
             <div class="container">
                 <div class="row align-items-center">
                     <!-- Footer social Start -->
                     <div class="col text-left footer-bottom-left">
                         <div class="footer-bottom-social">
                             <span class="social-text text-upper">Theo dõi chúng tôi:</span>
                             <ul class="mb-0">
                                 <li class="list-inline-item"><a class="hdr-facebook" href="#"><i
                                             class="ecicon eci-facebook"></i></a></li>
                                 <li class="list-inline-item"><a class="hdr-twitter" href="#"><i
                                             class="ecicon eci-twitter"></i></a></li>
                                 <li class="list-inline-item"><a class="hdr-instagram" href="#"><i
                                             class="ecicon eci-instagram"></i></a></li>
                                 <li class="list-inline-item"><a class="hdr-linkedin" href="#"><i
                                             class="ecicon eci-linkedin"></i></a></li>
                             </ul>
                         </div>
                     </div>
                     <!-- Footer social End -->
                     <!-- Footer Copyright Start -->
                     <div class="col text-center footer-copy">
                         <div class="footer-bottom-copy ">
                             <div class="ec-copy">Copyright © <span id="copyright_year"></span> <a class="site-name text-upper"
                                     href="#">PolyFit<span>.</span></a>. All Rights Reserved</div>
                         </div>
                     </div>
                     <!-- Footer Copyright End -->
                     <!-- Footer payment -->
                     <div class="col footer-bottom-right">
                         <div class="footer-bottom-payment d-flex justify-content-end">
                             <div class="payment-link">
                                 <img src="{{ asset('theme/client/assets/images/icons/payment.png')}}" alt="">
                                
                             </div>

                         </div>
                     </div>
                     <!-- Footer payment -->
                 </div>
             </div>
         </div>
     </div>
 </footer>
 <!-- Footer Area End -->


 {{-- <!-- Newsletter Modal Start -->
<div id="ec-popnews-bg"></div>
<div id="ec-popnews-box">
    <div id="ec-popnews-close"><i class="ecicon eci-close"></i></div>
    <div class="row">
        <div class="col-md-6 disp-no-767">
            <img src="theme/client/assets/images/banner/newsletter.png" alt="newsletter">
        </div>
        <div class="col-md-6">
            <div id="ec-popnews-box-content">
                <h2>Subscribe Newsletter</h2>
                <p>Subscribe the ekka ecommerce to get in touch and get the future update. </p>
                <form id="ec-popnews-form" action="#" method="post">
                    <input type="email" name="newsemail" placeholder="Email Address" required />
                    <button type="button" class="btn btn-primary" name="subscribe">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Newsletter Modal end --> --}}


 <!-- Recent Purchase Popup  -->
    <div class="recent-purchase-container">
        <!-- Recent Purchase Popup sẽ được chèn vào đây -->
    </div>
{{-- <div class="recent-purchase">
    <img src="{{asset('theme/client/assets/images/product-image/1.jpg')}}" alt="payment image">
    <div class="detail">
        <p>Có người mới mua</p>
        <h6>{{ $product_name }}</h6>
        <p>{{ $time_ago }}</p>
    </div>
    <a href="javascript:void(0)" class="icon-btn recent-close">×</a>
</div> --}}


 {{-- <div class="recent-purchase">
     <img src="{{asset('theme/client/assets/images/product-image/1.jpg')}}" alt="payment image">
     <div class="detail">
         <p>Có người mới mua</p>
         <h6>giày trẻ em thời trang</h6>
         <p>10 phút trước</p>
     </div>
     <a href="javascript:void(0)" class="icon-btn recent-close">×</a>
 </div> --}}
 <!-- Recent Purchase Popup end -->

 <!-- Cart Floating Button -->
 <div class="ec-cart-float">
     <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
         <div class="header-icon"><i class="fi-rr-shopping-basket"></i>
         </div>
         <span class="ec-cart-count cart-count-lable">3</span>
     </a>
 </div>

    </div>
    <script src="{{asset('theme/client/library/library.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/vendor/popper.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/vendor/bootstrap.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/vendor/jquery-migrate-3.3.0.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/vendor/modernizr-3.11.2.min.js')}}"></script>

    <!--Plugins JS-->
    <script src="{{asset('theme/client/assets/js/plugins/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/countdownTimer.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/scrollup.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/jquery.zoom.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/slick.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/infiniteslidev2.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/vendor/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/jquery.sticky-sidebar.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/sweetalert2.js')}}"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
        })

        function updateCartCount() {
            $.ajax({
                url: '{{ route("cart.count") }}',
                type: 'GET',
                success: function(data) {

                    if (data.count > 0) {
                        $('.cart-count-lable').text(data.count).show();
                    } else {
                        $('.cart-count-lable').hide();
                    }
                }
            });
        }
        var isLoggedIn = "{{ auth()->check() ? 'true' : 'false' }}";
        if (isLoggedIn == 'true') {
            updateCartCount();
        }
    </script>


    <!-- Main Js -->
    <script src="{{asset('theme/client/assets/js/vendor/index.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/main.js')}}"></script>
    <script src="{{ asset('theme/client/library/library.js') }}"></script>
    <script src="{{asset('theme/client/assets/js/review.js')}}"></script>
    @yield('script')
</body>

</html>
