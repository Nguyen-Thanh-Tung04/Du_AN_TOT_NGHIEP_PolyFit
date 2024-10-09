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
                        <span class="sort-by">Sắp xếp</span>
                        <div class="ec-select-inner">
                            <select name="ec-select" id="ec-select">
                                <option selected disabled>Vị trí</option>
                                <option value="1">Liên quan</option>
                                <option value="2">Tên, A to Z</option>
                                <option value="3">Tên, Z to A</option>
                                <option value="4">Giá, thấp đến cao</option>
                                <option value="5">Price, cao đến thấp</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Shop Top End -->

                <!-- Shop content Start -->
                <div class="shop-pro-content">
                    <div class="shop-pro-inner">
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
                                                     alt="" style="height: 200px"  />
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
                    <!-- Ec Pagination Start -->
                    <div class="ec-pro-pagination">
                        <span>Hiện thị {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} item(s)</span>
                        <ul class="ec-pro-pagination-inner">
                            {{-- Laravel sẽ tự động tạo các liên kết phân trang với định dạng phù hợp --}}
                            <li>{{ $products->links('pagination::bootstrap-4') }}</li>
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
                        <h1>Lọc sản phẩm</h1>
                    </div>
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Category Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Danh mục</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <ul>
                                    @foreach($categories as $categorie)
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" /> <a href="#">{{ $categorie->name }}</a><span
                                                    class="checked"></span>
                                            </div>
                                        </li>
                                    @endforeach
                                    <li>
                                        <div class="ec-sidebar-block-item ec-more-toggle">
                                            <span class="checked"></span><span id="ec-more-toggle">
                                                Xem thêm</span>
                                        </div>
                                    </li>
                                    <li id="ec-more-toggle-content" style="padding: 0; display: none;">
                                        <ul>
                                            @foreach($categories as $categorie)
                                                <li>
                                                    <div class="ec-sidebar-block-item">
                                                        <input type="checkbox" /> <a href="#">{{ $categorie->name }}</a><span
                                                            class="checked"></span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar Size Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Kích thước</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <ul>
                                    @foreach($variants as $variant)
                                        @if($variant->size) <!-- Kiểm tra nếu biến thể có màu sắc -->
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" value="{{ $variant->size->id }}" />
                                                <a href="#">{{ $variant->size->name }}</a><span class="checked"></span>
                                            </div>
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Màu sắc</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <ul>
                                    @foreach($variants as $variant)
                                        @if($variant->color) <!-- Kiểm tra nếu biến thể có màu sắc -->
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" value="{{ $variant->color->id }}" />
                                                <a href="#">{{ $variant->color->name }}</a><span class="checked"></span>
                                            </div>
                                        </li>
                                        @endif
                                    @endforeach
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
