@extends('client.layouts.master')
@section('content')
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="ec-shop-rightside col-lg-9 col-md-12 order-lg-last order-md-first margin-b-30">
                <!-- Shop Top Start -->
                <div class="ec-pro-list-top d-flex">
                    <div class="col-md-6 ec-grid-list">
                        <div class="ec-gl-btn">
                            <button class="btn btn-grid active"><i class="fi-rr-apps"></i></button>
                            <button class="btn btn-list"><i class="fi-rr-list"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6 ec-sort-select">
                        <span class="sort-by">Sort by</span>
                        <div class="ec-select-inner">
                            <select name="ec-select" id="ec-select">
                                <option selected disabled>Position</option>
                                <option value="1">Relevance</option>
                                <option value="2">Name, A to Z</option>
                                <option value="3">Name, Z to A</option>
                                <option value="4">Price, low to high</option>
                                <option value="5">Price, high to low</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Shop Top End -->

                <!-- Shop content Start -->
                <div class="shop-pro-content">
                    <div class="shop-pro-inner">
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
                    <!-- Ec Pagination Start -->
                    <div class="ec-pro-pagination">
                        <span>Showing 1-12 of 21 item(s)</span>
                        <ul class="ec-pro-pagination-inner">
                            <li><a class="active" href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a class="next" href="#">Next <i class="ecicon eci-angle-right"></i></a></li>
                        </ul>
                    </div>
                    <!-- Ec Pagination End -->
                </div>
                <!--Shop content End -->
            </div>
            <!-- Sidebar Area Start -->
            <div class="ec-shop-leftside col-lg-3 col-md-12 order-lg-first order-md-last">
                <div id="shop_sidebar">
                    <div class="ec-sidebar-heading">
                        <h1>Filter Products By</h1>
                    </div>
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Category Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Category</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <ul>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" checked /> <a href="#">clothes</a><span
                                                class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" /> <a href="#">Bags</a><span
                                                class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" /> <a href="#">Shoes</a><span
                                                class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" /> <a href="#">cosmetics</a><span
                                                class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" /> <a href="#">electrics</a><span
                                                class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" /> <a href="#">phone</a><span
                                                class="checked"></span>
                                        </div>
                                    </li>
                                    <li id="ec-more-toggle-content" style="padding: 0; display: none;">
                                        <ul>
                                            <li>
                                                <div class="ec-sidebar-block-item">
                                                    <input type="checkbox" /> <a href="#">Watch</a><span
                                                        class="checked"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="ec-sidebar-block-item">
                                                    <input type="checkbox" /> <a href="#">Cap</a><span
                                                        class="checked"></span>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item ec-more-toggle">
                                            <span class="checked"></span><span id="ec-more-toggle">More
                                                Categories</span>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar Size Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Size</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <ul>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" value="" checked /><a href="#">S</a><span
                                                class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" value="" /><a href="#">M</a><span
                                                class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" value="" /> <a href="#">L</a><span
                                                class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" value="" /><a href="#">XL</a><span
                                                class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" value="" /><a href="#">XXL</a><span
                                                class="checked"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar Color item -->
                        <div class="ec-sidebar-block ec-sidebar-block-clr">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Color</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <ul>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span
                                                style="background-color:#c4d6f9;"></span></div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span
                                                style="background-color:#ff748b;"></span></div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span
                                                style="background-color:#000000;"></span></div>
                                    </li>
                                    <li class="active">
                                        <div class="ec-sidebar-block-item"><span
                                                style="background-color:#2bff4a;"></span></div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span
                                                style="background-color:#ff7c5e;"></span></div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span
                                                style="background-color:#f155ff;"></span></div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span
                                                style="background-color:#ffef00;"></span></div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span
                                                style="background-color:#c89fff;"></span></div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span
                                                style="background-color:#7bfffa;"></span></div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span
                                                style="background-color:#56ffc1;"></span></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar Price Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Price</h3>
                            </div>
                            <div class="ec-sb-block-content es-price-slider">
                                <div class="ec-price-filter">
                                    <div id="ec-sliderPrice" class="filter__slider-price" data-min="0"
                                        data-max="250" data-step="10"></div>
                                    <div class="ec-price-input">
                                        <label class="filter__label"><input type="text"
                                                class="filter__input"></label>
                                        <span class="ec-price-divider"></span>
                                        <label class="filter__label"><input type="text"
                                                class="filter__input"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection