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
                            <select id="sort-options" class="">
                                <option selected disabled>Sắp xếp theo</option>
                                <option value="name_asc" {{ request()->sort == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                                <option value="name_desc" {{ request()->sort == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                                <option value="price_asc" {{ request()->sort == 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                                <option value="price_desc" {{ request()->sort == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Product grid/list view -->
                <div class="shop-pro-content">
                    <div class="shop-pro-inner">
                        @if(isset($products) && $products->isEmpty())
                        <div class="empty-results d-flex justify-content-center align-items-center">
                            <div class="text-center">
                                <img src="{{ asset('theme/client/assetss/images/icons/emty.webp') }}" alt="No Results" class="img-fluid mb-3">
                                <p>Không tìm thấy kết quả.</p>
                            </div>
                        </div>
                        @endif


                        <div class="row">
                            @foreach ($products as $product)
                            @php
                            $gallery = json_decode($product->gallery);
                            @endphp
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                                <!-- START single card -->
                                <div class="ec-product-tp">
                                    <div class="ec-product-image">
                                        <a href="{{ route('client.product.show', $product->id) }}">
                                            <img src="{{ !empty($gallery) ? $gallery[0] : '' }}" class="img-center" alt="">
                                            @if($product->variants->sum('quantity') === 0)
                                            <div class="out-of-stock-label">Hết hàng</div>
                                            @endif
                                        </a>

                                    </div>
                                    <div class="ec-product-body">
                                        <h3 class="ec-title"><a href="{{ route('client.product.show', $product->id) }}">{{ $product->name }}</a></h3>

                                        <ul class="ec-rating">
                                            @php
                                            $averageScore = $product->averageScore();
                                            @endphp

                                            @if ($averageScore)
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <=$averageScore)
                                                <li class="ecicon eci-star fill">
                                                </li> <!-- Sao đầy -->
                                                @else
                                                <li class="ecicon eci-star"></li> <!-- Sao rỗng -->
                                                @endif
                                                @endfor
                                                @else
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <=5)
                                                    <li class="ecicon eci-star fill">
                                                    </li> <!-- Sao đầy -->
                                                    @else
                                                    <li class="ecicon eci-star"></li> <!-- Sao rỗng -->
                                                    @endif
                                                    @endfor
                                                    @endif
                                        </ul>
                                        <div class="ec-price">
                                            @if ($product->min_sale_price)

                                            <span>{{ number_format($product->min_listed_price, 0) }}₫</span> {{ number_format($product->min_sale_price, 0) }}₫
                                            @else

                                            {{ number_format($product->min_listed_price, 0) }}₫
                                            @endif

                                        </div>
                                        {{-- <div class="ec-link-btn">
                                            <a class=" ec-add-to-cart" href="{{ route('client.product.show', $product->id) }}">Mua ngay</a>
                                    </div> --}}
                                </div>

                            </div>
                            <!-- START single card -->
                        </div>
                        @endforeach

                        <div class="pagination justify-content-center align-items-center mt-5">
                            {{ $products->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
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
                            <ul>
                                @foreach ($categories as $category)
                                <li>
                                    <div class="ec-sidebar-block-item">
                                        <input type="checkbox" class="filter-category" value="{{ $category->id }}"
                                            {{ request()->category && in_array($category->id, explode(',', request()->category)) ? 'checked' : '' }}>
                                        <a href="#"> {{ $category->name }}</a><span class="checked"></span>

                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Filter by Size -->
                    <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Kích thước</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <ul>
                                @foreach ($sizes as $size)
                                <li>
                                    <div class="ec-sidebar-block-item">
                                        <input type="checkbox" class="filter-size" value="{{ $size->id }}"
                                            {{ request()->size && in_array($size->id, explode(',', request()->size)) ? 'checked' : '' }}>
                                        <a href="#">{{ $size->name }}</a><span class="checked"></span>
                                    </div>
                                </li>
                                @endforeach


                            </ul>
                        </div>
                    </div>

                    <!-- Filter by Color -->
                    <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Màu sắc</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <ul>
                                @foreach ($colors as $color)
                                <li>
                                    <div class="ec-sidebar-block-item">
                                        <input type="checkbox" class="filter-color" value="{{ $color->id }}"
                                            {{ request()->color && in_array($color->id, explode(',', request()->color)) ? 'checked' : '' }}>

                                        <a href="#"> {{ $color->name }}</a><span class="checked"></span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Filter by Price -->
                    <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Khoảng giá</h3>
                        </div>
                        <div class="">
                            <div class="d-flex gap-1">
                                <input class="form-control px-1" type="text" id="min_price" placeholder="Giá tối thiểu" value="{{ request()->min_price ? number_format(request()->min_price) : '' }}">
                                <input class="form-control px-1" type="text" id="max_price" placeholder="Giá tối đa" value="{{ request()->max_price ? number_format(request()->max_price) : '' }}">
                            </div>
                            <div class="d-grid gap-2">

                                <button id="apply-price-filter" class="btn btn-primary mt-2">Áp dụng</button>
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

@section('scripts')
<script>
    $(document).ready(function() {
        function parseNumber(num) {
            return parseFloat(num.replace(/,/g, ''));
        }

        function updateURL() {
            let params = new URLSearchParams();

            let categories = [];
            $('.filter-category:checked').each(function() {
                categories.push($(this).val());
            });
            if (categories.length > 0) {
                params.set('category', categories.join(','));
            }

            let colors = [];
            $('.filter-color:checked').each(function() {
                colors.push($(this).val());
            });
            if (colors.length > 0) {
                params.set('color', colors.join(','));
            }

            let sizes = [];
            $('.filter-size:checked').each(function() {
                sizes.push($(this).val());
            });
            if (sizes.length > 0) {
                params.set('size', sizes.join(','));
            }

            let sortOption = $('#sort-options').val();
            if (sortOption) {
                params.set('sort', sortOption);
            }

            if (params.toString()) {
                window.location.search = params.toString();
            } else {
                window.location.search = '';
            }
        }

        function applyPriceFilter() {
            let params = new URLSearchParams(window.location.search);

            let minPrice = parseNumber($('#min_price').val());
            let maxPrice = parseNumber($('#max_price').val());

            if (minPrice) params.set('min_price', minPrice);
            else params.delete('min_price');

            if (maxPrice) params.set('max_price', maxPrice);
            else params.delete('max_price');

            window.location.search = params.toString();
        }


        $('.filter-category, .filter-color, .filter-size').on('change', updateURL);

        $('#sort-options').on('change', updateURL);

        $('#apply-price-filter').on('click', applyPriceFilter);

        function formatNumber(num) {
            num = num.replace(/[^0-9]/g, '');
            return num.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        $('#min_price, #max_price').on('input', function() {
            let input = $(this);
            let value = input.val();

            input.val(formatNumber(value));
        });
    });
</script>
@endsection