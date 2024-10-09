@extends('client.layouts.master')

@section('content')
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-shop-rightside col-lg-9 col-md-12 order-lg-last order-md-first margin-b-30">
                    <div class="ec-pro-list-top d-flex">
                        <div class="col-md-6 ec-grid-list">
                            <div class="ec-gl-btn">
                                <a href="{{ route('home.shop') }}">
                                    <button class="btn btn-grid active"><i class="fi-rr-apps"></i></button>
                                </a>
                                <button class="btn btn-list"><i class="fi-rr-list"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6 ec-sort-select">
                            <span class="sort-by">Sắp xếp</span>
                            <div class="ec-select-inner">
                                <select name="ec-select" id="ec-select">
                                    <option selected disabled>Vị trí</option>
                                    <option value="name_asc">Tên, A to Z</option>
                                    <option value="name_desc">Tên, Z to A</option>
                                    <option value="price_asc">Giá, thấp đến cao</option>
                                    <option value="price_desc">Giá, cao đến thấp</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="shop-pro-content">
                        <div class="shop-pro-inner">
                            <div class="row">
                                @foreach ($products as $product)
                                    @php
                                        $gallery = json_decode($product->gallery);
                                    @endphp
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <div class="ec-product-ds">
                                            <div class="ec-product-image">
                                                <a href="{{ route('client.product.show', $product->id) }}" class="image">
                                                    <img class="pic-1" src="{{ (!empty($gallery)) ? $gallery[0] : '' }}" alt="" style="height: 200px"  />
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
                                                    <span>{{ number_format($product->listed_price, 0) }} VNĐ</span>
                                                    {{ number_format($product->min_price, 0) }} VNĐ
                                                </div>
                                                <a class="ec-add-to-cart" href="{{ route('client.product.show', $product->id) }}">Thêm giỏ hàng</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Uncomment if you need pagination --}}
                        {{-- <div class="ec-pro-pagination"> --}}
                        {{--     <span>Hiện thị {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} item(s)</span> --}}
                        {{--     <ul class="ec-pro-pagination-inner"> --}}
                        {{--         <li>{{ $products->links('pagination::bootstrap-4') }}</li> --}}
                        {{--     </ul> --}}
                        {{-- </div> --}}
                    </div>
                </div>

                <div class="ec-shop-leftside col-lg-3 col-md-12 order-lg-first order-md-last">
                    <div id="shop_sidebar">
                        <div class="ec-sidebar-heading">
                            <h1>Lọc sản phẩm</h1>
                        </div>
                        <div class="ec-sidebar-wrap">
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Danh mục</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <ul>
                                        @foreach($categories as $categorie)
                                            <li>
                                                <div class="ec-sidebar-block-item">
                                                    <input type="checkbox" />
                                                    <a href="{{ route('shop.show', $categorie->id) }}">{{ $categorie->name }}</a><span class="checked"></span>
                                                </div>
                                            </li>
                                        @endforeach
                                        <li>
                                            <div class="ec-sidebar-block-item ec-more-toggle">
                                                <span class="checked"></span><span id="ec-more-toggle">Xem thêm</span>
                                            </div>
                                        </li>
                                        <li id="ec-more-toggle-content" style="padding: 0; display: none;">
                                            <ul>
                                                @foreach($categories as $categorie)
                                                    <li>
                                                        <div class="ec-sidebar-block-item">
                                                            <input type="checkbox" /> <a href="#">{{ $categorie->name }}</a><span class="checked"></span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Kích thước</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <ul>
                                        @foreach($variants as $variant)
                                            @if($variant->size)
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
                                            @if($variant->color)
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

                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Lọc theo giá</h3>
                                </div>
                                <div class="ec-sb-block-content es-price-slider">
                                    <div class="ec-price-filter">
                                        <div id="ec-sliderPrice" class="filter__slider-price" data-min="0"
                                             data-max="250" data-step="10"></div>
                                        <div class="ec-price-input">
                                            <input type="text" class="filter__input w-50" placeholder="0đ">
                                            <span class="ec-price-divider"></span>
                                            <input type="text" class="filter__input" placeholder="10đ">
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

    <script>
        document.getElementById('ec-select').addEventListener('change', function () {
            const selectedValue = this.value;
            window.location.href = `?sort=${selectedValue}`;
        });
    </script>
@endsection
