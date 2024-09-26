<!--========================================================= 
    Item Name: Ekka - Ecommerce HTML Template + Admin Dashboard.
    Author: ashishmaraviya
    Version: 3.7
    Copyright 2024
	Author URI: https://themeforest.net/user/ashishmaraviya
 ============================================================-->
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from maraviyainfotech.com/projects/ekka/ekka-v37/ekka-html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 14 Jul 2024 11:50:03 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>PolyFit</title>
    <meta name="keywords"
        content="apparel, catalog, clean, ecommerce, ecommerce HTML, electronics, fashion, html eCommerce, html store, minimal, multipurpose, multipurpose ecommerce, online store, responsive ecommerce template, shops" />
    <meta name="description" content="Best ecommerce html template for single and multi vendor store.">
    <meta name="author" content="ashishmaraviya">

    <!-- site Favicon -->
    <link rel="icon" href="{{asset('theme/client/assets/images/logo/logo1.png')}}" sizes="32x32" />
    <link rel="apple-touch-icon" href="{{asset('theme/client/assets/images/logo/logo1.png')}}" />
    <meta name="msapplication-TileImage" content="{{asset('theme/client/assets/images/logo/logo1.png')}}" />

    <!-- css Icon Font -->
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/vendor/ecicons.min.css')}}" />

    <!-- css All Plugins Files -->
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/plugins/animate.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/plugins/swiper-bundle.min.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/plugins/jquery-ui.min.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/plugins/countdownTimer.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/plugins/slick.min.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/plugins/bootstrap.css')}}" />

    <!-- Main Style -->
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/demo1.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/responsive.css')}}" />

    <!-- Background css -->
    <link rel="stylesheet" id="bg-switcher-css" href="{{asset('theme/client/assets/css/backgrounds/bg-4.css')}}">
</head>

<body>
    {{--
     loadding
     <div id="ec-overlay">
         <div class="ec-ellipsis">
             <div></div>
             <div></div>
             <div></div>
             <div></div>
         </div>
     </div> --}}
    <!-- Header start  -->
    <header class="ec-header">
        <!--Ec Header Top Start -->
        <div class="header-top">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Header Top social Start -->
                    <div class="col-2 text-left header-top-left d-none d-lg-block">
                        <div class="header-top-social">
                            <span class="social-text text-upper">Follow us on:</span>
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
                    <!-- Header Top social End -->
                    <!-- Header Top Message Start -->
                    <div class="col-8 header-right">
                        <marquee behavior="scroll" class="fw-bold" direction="left">🚛Nguyễn Thanh Tùng đẹp zai phải không mọi người!</marquee>
                     </div>
                    
                     <!-- Header Top responsive Action -->
                     <div class="col d-lg-none ">
                         <div class="ec-header-bottons">
                             <!-- Header User Start -->
                             <div class="ec-header-user dropdown">
                                 <button class="dropdown-toggle" data-bs-toggle="dropdown"><i
                                         class="fi-rr-user"></i></button>
                                 <ul class="dropdown-menu dropdown-menu-right">
                                     <li><a class="dropdown-item" href="register.html">Register</a></li>
                                     <li><a class="dropdown-item" href="checkout.html">Checkout</a></li>
                                     <li><a class="dropdown-item" href="login.html">Login</a></li>
                                 </ul>
                             </div>
                             <!-- Header User End -->
                             <!-- Header Cart Start -->
                             <a href="wishlist.html" class="ec-header-btn ec-header-wishlist">
                                 <div class="header-icon"><i class="fi-rr-heart"></i></div>
                                 <span class="ec-header-count">4</span>
                             </a>
                             <!-- Header Cart End -->
                             <!-- Header Cart Start -->
                             <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
                                 <div class="header-icon"><i class="fi-rr-shopping-bag"></i></div>
                                 <span class="ec-header-count cart-count-lable">3</span>
                             </a>
                             <!-- Header Cart End -->
                             <a href="javascript:void(0)" class="ec-header-btn ec-sidebar-toggle">
                                 <i class="fi fi-rr-apps"></i>
                             </a>
                             <!-- Header menu Start -->
                             <a href="#ec-mobile-menu" class="ec-header-btn ec-side-toggle d-lg-none">
                                 <i class="fi fi-rr-menu-burger"></i>
                             </a>
                             <!-- Header menu End -->
                         </div>
                     </div>
                     <!-- Header Top responsive Action -->
                 </div>
             </div>
         </div>
         <!-- Ec Header Top  End -->
         <!-- Ec Header Bottom  Start -->
         <div class="ec-header-bottom d-none d-lg-block">
             <div class="container position-relative">
                 <div class="row">
                     <div class="ec-flex">
                         <!-- Ec Header Logo Start -->
                         <div class="align-self-center">
                             <div class="header-logo">
                                 <a href="index.html"><img src="{{asset('theme/client/assets/images/logo/logo1.png')}}" alt="Site Logo" /><img
                                         class="dark-logo" src="{{asset('theme/client/assets/images/logo/logo1.png')}}" alt="Site Logo"
                                         style="display: none;" /></a>
                             </div>
                         </div>
                         <!-- Ec Header Logo End -->
 
                         <!-- Ec Header Search Start -->
                         <div class="align-self-center">
                             <div class="header-search">
                                 <form class="ec-btn-group-form" action="#">
                                     <input class="form-control ec-search-bar" placeholder="Search products..."
                                         type="text">
                                     <button class="submit" type="submit"><i class="fi-rr-search"></i></button>
                                 </form>
                             </div>
                         </div>
                         <!-- Ec Header Search End -->
 
                         <!-- Ec Header Button Start -->
                         <div class="align-self-center">
                             <div class="ec-header-bottons">
 
                                 <!-- Header User Start -->
                                 <div class="ec-header-user dropdown">
                                     <button class="dropdown-toggle" data-bs-toggle="dropdown"><i
                                             class="fi-rr-user"></i></button>
                                     <ul class="dropdown-menu dropdown-menu-right">
                                         <li><a class="dropdown-item" href="register.html">Register</a></li>
                                         <li><a class="dropdown-item" href="checkout.html">Checkout</a></li>
                                         <li><a class="dropdown-item" href="login.html">Login</a></li>
                                     </ul>
                                 </div>
                                 <!-- Header User End -->
                                 <!-- Header wishlist Start -->
                                 <a href="wishlist.html" class="ec-header-btn ec-header-wishlist">
                                     <div class="header-icon"><i class="fi-rr-heart"></i></div>
                                     <span class="ec-header-count">4</span>
                                 </a>
                                 <!-- Header wishlist End -->
                                 <!-- Header Cart Start -->
                                 <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
                                     <div class="header-icon"><i class="fi-rr-shopping-bag"></i></div>
                                     <span class="ec-header-count cart-count-lable">3</span>
                                 </a>
                                 <!-- Header Cart End -->
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- Ec Header Button End -->
         <!-- Header responsive Bottom  Start -->
         <div class="ec-header-bottom d-lg-none">
             <div class="container position-relative">
                 <div class="row ">
 
                     <!-- Ec Header Logo Start -->
                     <div class="col">
                         <div class="header-logo">
                             <a href="index.html"><img src="assets/images/logo/logo.png" alt="Site Logo" /><img
                                     class="dark-logo" src="assets/images/logo/dark-logo.png" alt="Site Logo"
                                     style="display: none;" /></a>
                         </div>
                     </div>
                     <!-- Ec Header Logo End -->
                     <!-- Ec Header Search Start -->
                     <div class="col">
                         <div class="header-search">
                             <form class="ec-btn-group-form" action="#">
                                 <input class="form-control ec-search-bar" placeholder="Search products..." type="text">
                                 <button class="submit" type="submit"><i class="fi-rr-search"></i></button>
                             </form>
                         </div>
                     </div>
                     <!-- Ec Header Search End -->
                 </div>
             </div>
         </div>
         <!-- Header responsive Bottom  End -->
           <!-- EC Main Menu Start -->
        <div id="ec-main-menu-desk" class="d-none d-lg-block sticky-nav">
            <div class="container position-relative">
                <div class="row">
                    <div class="col-md-12 align-self-center">
                        <div class="ec-main-menu">
                            <ul>
                                <li><a href="{{ url('/') }}">Trang chủ</a></li>
                                <li><a href="{{ url('/about') }}">Giới thiệu</a></li>
                                <li><a href="{{ url('/shop') }}">Cửa hàng</a></li>
                                <li><a href="index.html">Liên hệ</a></li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ec Main Menu End -->
        <!-- ekka Mobile Menu Start -->
        <div id="ec-mobile-menu" class="ec-side-cart ec-mobile-menu">
            <div class="ec-menu-title">
                <span class="menu_title">My Menu</span>
                <button class="ec-close">×</button>
            </div>
            <div class="ec-menu-inner">
                <div class="ec-menu-content">
                    <ul>
                        <li><a href="index.html">Trang chủ</a></li>
                        <li><a href="index.html">Giới thiệu</a></li>
                        <li><a href="index.html">Cửa hàng</a></li>
                        <li><a href="index.html">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="header-res-lan-curr">
                    <div class="header-top-lan-curr">
                        <!-- Language Start -->
                        <div class="header-top-lan dropdown">
                            <button class="dropdown-toggle text-upper" data-bs-toggle="dropdown">Language <i
                                    class="ecicon eci-caret-down" aria-hidden="true"></i></button>
                            <ul class="dropdown-menu">
                                <li class="active"><a class="dropdown-item" href="#">English</a></li>
                                <li><a class="dropdown-item" href="#">Italiano</a></li>
                            </ul>
                        </div>
                        <!-- Language End -->
                        <!-- Currency Start -->
                        <div class="header-top-curr dropdown">
                            <button class="dropdown-toggle text-upper" data-bs-toggle="dropdown">Currency <i
                                    class="ecicon eci-caret-down" aria-hidden="true"></i></button>
                            <ul class="dropdown-menu">
                                <li class="active"><a class="dropdown-item" href="#">USD $</a></li>
                                <li><a class="dropdown-item" href="#">EUR €</a></li>
                            </ul>
                        </div>
                        <!-- Currency End -->
                    </div>
                    <!-- Social Start -->
                    <div class="header-res-social">
                        <div class="header-top-social">
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
                    <!-- Social End -->
                </div>
            </div>
        </div>
        <!-- ekka mobile Menu End -->
    </header>
    <!-- Header End  -->