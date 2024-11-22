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
                                <li><a class="dropdown-item" href="{{ url('/history') }}">History</a></li>
                                <li><a class="dropdown-item" href="login.html">Login</a></li>
                            </ul>
                        </div>
                        <a href="{{route('cart.index')}}" class="ec-header-btn">
                            <div class="header-icon"><i class="fi-rr-shopping-bag"></i></div>
                            @auth
                            <span class="ec-header-count cart-count-lable" style="display: none;">0</span>
                            @endauth
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
                            <a href="{{ url('/') }}"><img src="{{asset('theme/client/assets/images/logo/logo1.png')}}" alt="Site Logo" /><img
                                    class="dark-logo" src="{{asset('theme/client/assets/images/logo/logo1.png')}}" alt="Site Logo"
                                    style="display: none;" /></a>
                        </div>
                    </div>
                    <!-- Ec Header Logo End -->

                    <!-- Ec Header Search Start -->
                    <div class="align-self-center">
                        <div class="header-search">
                            <form class="ec-btn-group-form" action="{{ route('search') }}" method="GET">
                                <input class="form-control ec-search-bar" name="search" placeholder="Tìm kiếm sản phẩm..." type="text">
                                <button class="submit" type="submit" aria-label="Search"><i class="fi-rr-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <!-- Ec Header Search End -->

                    <!-- Ec Header Button Start -->
                    <div class="align-self-center">
                        <div class="ec-header-bottons">

                            <!-- Header User Start -->
                            <div class="ec-header-user dropdown">
                                <button class="dropdown-toggle" data-bs-toggle="dropdown">
                                    @if(Auth::check())
                                    @php
                                    $checkUrlImg = Auth::user()->image && \Illuminate\Support\Str::contains(Auth::user()->image, '/userfiles/')
                                    ? Auth::user()->image
                                    : (Auth::user()->image ? Storage::url(Auth::user()->image) : null);
                                    @endphp

                                    @if ($checkUrlImg)
                                    <!-- Nếu user có ảnh đại diện -->
                                    <img
                                        src="{{ $checkUrlImg }}"
                                        alt="User Avatar"
                                        class="img-profile rounded-circle border shadow"
                                        style="height: 40px; width: 40px; object-fit: cover;">
                                    @else
                                    <!-- Nếu không có ảnh đại diện -->
                                    <img
                                        style="height: 40px; width: 40px;"
                                        class="img-profile rounded-circle"
                                        src="{{ asset('userfiles/image/avata_null.jpg') }}"
                                        alt="Default Avatar">
                                    @endif
                                    @else
                                    <!-- Nếu chưa đăng nhập -->
                                    <i class="fi-rr-user"></i>
                                    @endif

                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <!-- Kiểm tra nếu người dùng đã đăng nhập -->
                                    @auth
                                    <li><a class="dropdown-item" href="{{ url('/account') }}">Tài khoản</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/history') }}">Đơn hàng</a></li>
                                    <li><a class="dropdown-item" href="{{ route('auth.logout') }}">Đăng xuất</a></li>
                                    @else
                                    <!-- Hiển thị Đăng nhập và Đăng ký nếu chưa đăng nhập -->
                                    <li><a class="dropdown-item" href="{{ url('/login') }}">Đăng nhập</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/register') }}">Đăng ký</a></li>
                                    @endauth
                                </ul>

                            </div>
                            <!-- Header User End -->

                            <!-- Header Cart Start -->
                            <a href="{{route('cart.index')}}" class="ec-header-btn">
                                <div class="header-icon"><i class="fi-rr-shopping-bag"></i></div>
                                @auth
                                <span class="ec-header-count cart-count-lable" style="display: none;">0</span>
                                @endauth
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
    <div class=" ec-header-bottom d-lg-none">
        <div class="container position-relative">
            <div class="row ">

                <!-- Ec Header Logo Start -->
                <div class="col">
                    <div class="header-logo">
                        <a href="index.html"><img src="{{asset('theme/client/assets/images/logo/logo1.png')}}" alt="Site Logo" /><img
                                class="dark-logo" src="{{asset('theme/client/assets/images/logo/logo1.png')}}" alt="Site Logo"
                                style="display: none;" /></a>
                    </div>
                </div>
                <!-- Ec Header Logo End -->
                <!-- Ec Header Search Start -->
                <div class="col">
                    <div class="header-search">
                        <form class="ec-btn-group-form" action="#">
                            <input class="form-control ec-search-bar" placeholder="Tìm kiếm sản phẩm..." type="text">
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
                            {{-- <li class="dropdown position-static"><a href="javascript:void(0)">Danh mục</a>
                                <ul class="mega-menu d-block">
                                    <li class="d-flex">
                                        <ul class="d-block">
                                            <li class="menu_title"><a href="javascript:void(0)">Classic
                                                    Variation</a></li>
                                            <li><a href="shop-left-sidebar-col-3.html">Left sidebar 3 column</a>
                                            </li>
                                            <li><a href="shop-left-sidebar-col-4.html">Left sidebar 4 column</a>
                                            </li>
                                            <li><a href="shop-right-sidebar-col-3.html">Right sidebar 3 column</a>
                                            </li>
                                            <li><a href="shop-right-sidebar-col-4.html">Right sidebar 4 column</a>
                                            </li>
                                            <li><a href="shop-full-width.html">Full width 4 column</a></li>
                                        </ul>
                                        <ul class="d-block">
                                            <li class="menu_title"><a href="javascript:void(0)">Classic
                                                    Variation</a></li>
                                            <li><a href="shop-banner-left-sidebar-col-3.html">Banner left sidebar 3
                                                    column</a></li>
                                            <li><a href="shop-banner-left-sidebar-col-4.html">Banner left sidebar 4
                                                    column</a></li>
                                            <li><a href="shop-banner-right-sidebar-col-3.html">Banner right sidebar
                                                    3 column</a></li>
                                            <li><a href="shop-banner-right-sidebar-col-4.html">Banner right sidebar
                                                    4 column</a></li>
                                            <li><a href="shop-banner-full-width.html">Banner Full width 4 column</a>
                                            </li>
                                        </ul>
                                        <ul class="d-block">
                                            <li class="menu_title"><a href="javascript:void(0)">Columns
                                                    Variation</a></li>
                                            <li><a href="shop-full-width-col-3.html">3 Columns full width</a></li>
                                            <li><a href="shop-full-width-col-4.html">4 Columns full width</a></li>
                                            <li><a href="shop-full-width-col-5.html">5 Columns full width</a></li>
                                            <li><a href="shop-full-width-col-6.html">6 Columns full width</a></li>
                                            <li><a href="shop-banner-full-width-col-3.html">Banner 3 Columns</a>
                                            </li>
                                        </ul>
                                        <ul class="d-block">
                                            <li class="menu_title"><a href="javascript:void(0)">List Variation</a>
                                            </li>
                                            <li><a href="shop-list-left-sidebar.html">Shop left sidebar</a></li>
                                            <li><a href="shop-list-right-sidebar.html">Shop right sidebar</a></li>
                                            <li><a href="shop-list-banner-left-sidebar.html">Banner left sidebar</a>
                                            </li>
                                            <li><a href="shop-list-banner-right-sidebar.html">Banner right
                                                    sidebar</a></li>
                                            <li><a href="shop-list-full-col-2.html">Full width 2 columns</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="ec-main-banner w-100">
                                            <li><a class="p-0" href="shop-left-sidebar-col-3.html"><img class="img-responsive" src="assets/images/menu-banner/1.jpg" alt=""></a></li>
                                            <li><a class="p-0" href="shop-left-sidebar-col-4.html"><img class="img-responsive" src="assets/images/menu-banner/2.jpg" alt=""></a></li>
                                            <li><a class="p-0" href="shop-right-sidebar-col-3.html"><img class="img-responsive" src="assets/images/menu-banner/3.jpg" alt=""></a></li>
                                            <li><a class="p-0" href="shop-right-sidebar-col-4.html"><img class="img-responsive" src="assets/images/menu-banner/4.jpg" alt=""></a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li> --}}
                            <li><a href="{{ url('/about') }}">Giới thiệu</a></li>
                            <li><a href="{{ url('/shop') }}">Cửa hàng</a></li>
                            <li><a href="{{ url('/flash-sale') }}">Flash Sale</a></li>
                            <li><a href="{{ url('/contact') }}">Liên hệ</a></li>
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