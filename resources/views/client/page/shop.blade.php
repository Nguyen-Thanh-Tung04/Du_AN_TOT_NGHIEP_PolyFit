@extends('client.layouts.master')

@section('content')
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-shop-rightside col-lg-9 col-md-12 order-lg-last order-md-first margin-b-30">
                    <!-- Grid/List view options -->
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

                    <!-- Product grid/list view -->
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
                                                    <img class="pic-1" src="{{ (!empty($gallery)) ? $gallery[0] : '' }}" alt="" style="height: 200px" />
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
                        {{--     <span>Hiển thị {{ $products->firstItem() }}-{{ $products->lastItem() }} trong tổng số {{ $products->total() }} sản phẩm</span> --}}
                        {{--     <ul class="ec-pro-pagination-inner"> --}}
                        {{--         <li>{{ $products->links('pagination::bootstrap-4') }}</li> --}}
                        {{--     </ul> --}}
                        {{-- </div> --}}
                    </div>
                </div>

                <!-- Sidebar filters for category, size, color -->
                <div class="ec-shop-leftside col-lg-3 col-md-12 order-lg-first order-md-last">
                    <div id="shop_sidebar">
                        <div class="ec-sidebar-heading">
                            <h1>Lọc sản phẩm</h1>
                        </div>
                        <div class="ec-sidebar-wrap">

                            <!-- Filter by Category -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Danh mục</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <form action="{{ route('products.filter') }}" method="GET" id="category-filter-form">
                                        <ul>
                                            @foreach($categories as $categorie)
                                                <li>
                                                    <div class="ec-sidebar-block-item">
                                                        <input type="radio" name="categories[]"
                                                               value="{{ $categorie->id }}"
                                                               onchange="document.getElementById('category-filter-form').submit();"
                                                            {{ in_array($categorie->id, request()->get('categories', [])) ? 'checked' : '' }} />
                                                        <a href="#">{{ $categorie->name }}</a><span class="checked"></span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </form>
                                </div>
                            </div>

                            <!-- Filter by Size -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Kích thước</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <form action="{{ route('products.filter') }}" method="GET" id="size-filter-form">
                                        <ul>
                                            @php
                                                $uniqueSizes = $variants->pluck('size')->unique('id');
                                                $selectedSizes = request()->input('sizes', []); // Lấy các size đã chọn từ request
                                            @endphp

                                            @foreach($uniqueSizes as $size)
                                                @if($size)
                                                    <li>
                                                        <div class="ec-sidebar-block-item">
                                                            <input type="radio" class="filter-size" name="sizes[]" value="{{ $size->id }}"
                                                                   {{ in_array($size->id, $selectedSizes) ? 'checked' : '' }}
                                                                   onchange="document.getElementById('size-filter-form').submit();" />
                                                            <a href="#">{{ $size->name }}</a><span class="checked"></span>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </form>
                                </div>
                            </div>

                            <!-- Filter by Color -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Màu sắc</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <form action="{{ route('products.filter') }}" method="GET" id="color-filter-form">
                                        <ul>
                                            @php
                                                $uniqueColors = $variants->pluck('color')->unique('id');
                                                $selectedColors = request()->input('colors', []); // Lấy các màu đã chọn từ request
                                            @endphp

                                            @foreach($uniqueColors as $color)
                                                @if($color)
                                                    <li>
                                                        <div class="ec-sidebar-block-item">
                                                            <input type="radio" class="filter-color" name="colors[]" value="{{ $color->id }}"
                                                                   {{ in_array($color->id, $selectedColors) ? 'checked' : '' }}
                                                                   onchange="document.getElementById('color-filter-form').submit();" />
                                                            <a href="#">{{ $color->name }}</a><span class="checked"></span>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </form>
                                </div>
                            </div>

                            <!-- Filter by Price -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Lọc theo giá</h3>
                                </div>
                                <div class="ec-sb-block-content es-price-slider">
                                    <div class="ec-price-filter">
                                        <!-- Slider cho khoảng giá -->
                                        <div id="ec-sliderPrice" class="filter__slider-price" data-min="0" data-max="250" data-step="10"></div>
                                        <div class="ec-price-input">
                                            <!-- Hiển thị giá trị min và max từ slider -->
                                            <input type="text" id="price-min" class="filter__input w-50" readonly>
                                            <span class="ec-price-divider"></span>
                                            <input type="text" id="price-max" class="filter__input" readonly>
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
        // Script để hiện/ẩn danh mục "Xem thêm"
        document.getElementById('ec-more-toggle').addEventListener('click', function() {
            const content = document.getElementById('ec-more-toggle-content');
            if (content.style.display === 'none') {
                content.style.display = 'block';
            } else {
                content.style.display = 'none';
            }
        });
    </script>
    <script>

        document.getElementById('ec-select').addEventListener('change', function () {
            const selectedValue = this.value;
            window.location.href = `?sort=${selectedValue}`;
        });
    </script>
    <script>
        // Khởi tạo thanh trượt với noUiSlider
        var slider = document.getElementById('ec-sliderPrice');

        noUiSlider.create(slider, {
            start: [0, 10000000],  // Giá trị khởi tạo của slider
            connect: true,  // Hiển thị màu nối giữa 2 nút
            step: 10,  // Bước nhảy của slider
            range: {
                'min': 0,
                'max': 10000000
            },
            format: {
                to: function (value) {
                    return Math.round(value) + 'đ';  // Thêm đơn vị "đ" cho giá
                },
                from: function (value) {
                    return Number(value.replace('đ', ''));  // Loại bỏ "đ" khi lấy giá trị
                }
            }
        });

        // Cập nhật giá trị min và max vào input khi thay đổi
        var minPriceInput = document.getElementById('price-min');
        var maxPriceInput = document.getElementById('price-max');

        slider.noUiSlider.on('update', function (values, handle) {
            if (handle === 0) {
                minPriceInput.value = values[0];  // Cập nhật giá trị min
            } else {
                maxPriceInput.value = values[1];  // Cập nhật giá trị max
            }
        });

        // Gửi giá trị min và max về server để lọc khi người dùng thay đổi slider
        slider.noUiSlider.on('change', function (values) {
            var minPrice = values[0].replace('đ', '');  // Loại bỏ "đ" và lấy giá trị số
            var maxPrice = values[1].replace('đ', '');

            // Gửi request để lọc sản phẩm theo giá trị đã chọn
            window.location.href = `{{ route('products.show') }}?min_price=${minPrice}&max_price=${maxPrice}`;
        });
    </script>

@endsection
