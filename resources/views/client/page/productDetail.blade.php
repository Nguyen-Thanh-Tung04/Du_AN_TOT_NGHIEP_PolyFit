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
    <div id="product-variants" data-variants="{{ json_encode($product->variants) }}">
    </div>
    <input type="hidden" id="productId" value="{{ $product->id }}">
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
                                        @if (!empty($galleryImages))
                                        @foreach($galleryImages as $image)
                                        <div class="single-slide zoom-image-hover">
                                            <img class="img-responsive {{ $product->variants->sum('quantity') === 0 ? 'out-of-stock' : '' }}" src="{{ $image }}" alt="{{ $product->name }}">
                                            @if($product->variants->sum('quantity') === 0)
                                            <!-- Hiển thị nhãn 'Hết hàng' nếu sản phẩm hết số lượng -->
                                            <div class="out-of-stock-label">Hết hàng</div>
                                            @endif
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <div class="single-nav-thumb">
                                        @if (!empty($galleryImages))
                                        @foreach($galleryImages as $image)
                                        <div class="single-slide zoom-image-hover">
                                            <img class="img-responsive" src="{{ $image }}" alt="{{ $product->name }}">
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="single-pro-desc single-pro-desc-no-sidebar p-4">
                                <div class="single-pro-content">
                                    <h5 class="ec-single-title">{{ $product->name }}</h5>
                                    <div class="ec-single-rating-wrap">
                                        <div class="ec-single-rating">
                                            @if ($averageScore)
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <=$averageScore)
                                                <i class="ecicon eci-star text-warning"></i>
                                                @else
                                                <i class="ecicon eci-star-o"></i>
                                                @endif
                                                @endfor
                                                @else
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <=5)
                                                    <i class="ecicon eci-star text-warning"></i>
                                                    @else
                                                    <i class="ecicon eci-star-o"></i>
                                                    @endif
                                                    @endfor
                                                    @endif
                                        </div>
                                    </div>
                                    <div class="ec-single-stoke d-flex  justify-content-between">
                                        <span><span class="quantity-detail">{{ $product->total_quantity }}</span> sản phẩm có sẵn</span>
                                        <span class="ec-single-sku">SKU#: {{ $product->code }}</span>
                                    </div>

                                    <!-- <div class="ec-single-sales">
                                        <div class="ec-single-sales-inner">
                                            <div class="ec-single-sales-title">sales accelerators</div>
                                            <div class="ec-single-sales-visitor">real time <span>24</span> visitor
                                                right now!</div>
                                            <div class="ec-single-sales-progress">
                                                <span class="ec-single-progress-desc">Hurry up!left 29 in
                                                    stock</span>
                                                <span class="ec-single-progressbar"></span>
                                            </div>
                                            <div class="ec-single-sales-countdown">
                                                <div class="ec-single-countdown"><span
                                                        id="ec-single-countdown"></span></div>
                                                <div class="ec-single-count-desc">Time is Running Out!</div>
                                            </div>
                                        </div>
                                    </div> -->



                                    <div class="">
                                        <div id="flash-sale-container" class="{{ $product->is_in_flash_sale ? '' : 'd-none' }}">
                                            <div class="flash-sale">
                                                <div class="time-sale">
                                                    <svg viewBox="0 0 108 21" height="21" width="108" class="flash-sale-logo flash-sale-logo--white">
                                                        <g fill="currentColor" fill-rule="evenodd">
                                                            <path d="M0 16.195h3.402v-5.233h4.237V8H3.402V5.037h5.112V2.075H0zm29.784 0l-.855-2.962h-4.335l-.836 2.962H20.26l4.723-14.12h3.576l4.724 14.12zM26.791 5.294h-.04s-.31 1.54-.563 2.43l-.797 2.744h2.74l-.777-2.745c-.252-.889-.563-2.43-.563-2.43zm7.017 9.124s1.807 2.014 5.073 2.014c3.13 0 4.898-2.034 4.898-4.384 0-4.463-6.259-4.147-6.259-5.925 0-.79.778-1.106 1.477-1.106 1.672 0 3.071 1.245 3.071 1.245l1.439-2.824s-1.477-1.6-4.47-1.6c-2.76 0-4.918 1.718-4.918 4.325 0 4.345 6.258 4.285 6.258 5.964 0 .85-.758 1.126-1.457 1.126-1.75 0-3.324-1.462-3.324-1.462zm12.303 1.777h3.402v-5.53h5.054v5.53h3.401V2.075h-3.401v5.648h-5.054V2.075h-3.402zm18.64-1.678s1.692 1.915 4.763 1.915c2.877 0 4.548-1.876 4.548-4.107 0-4.483-6.492-3.871-6.492-6.36 0-.987.914-1.678 2.08-1.678 1.73 0 3.052 1.224 3.052 1.224l1.088-2.073s-1.4-1.501-4.12-1.501c-2.644 0-4.627 1.738-4.627 4.068 0 4.305 6.512 3.87 6.512 6.379 0 1.145-.952 1.698-2.002 1.698-1.944 0-3.44-1.48-3.44-1.48zm19.846 1.678l-1.166-3.594h-4.84l-1.166 3.594H74.84L79.7 2.174h2.623l4.86 14.021zM81.04 4.603h-.039s-.31 1.382-.583 2.172l-1.224 3.752h3.615l-1.224-3.752c-.253-.79-.545-2.172-.545-2.172zm7.911 11.592h8.475v-2.192H91.46V2.173H88.95zm10.477 0H108v-2.192h-6.064v-3.772h4.645V8.04h-4.645V4.366h5.753V2.174h-8.26zM14.255.808l6.142.163-3.391 5.698 3.87 1.086-8.028 12.437.642-8.42-3.613-1.025z"></path>
                                                        </g>
                                                    </svg>
                                                    <svg height="20" viewBox="0 0 20 20" width="20" class="shop-svg-icon _17VGnS ">
                                                        <g fill="none" fill-rule="evenodd" stroke="#fff" stroke-width="1.8" transform="translate(1 1)">
                                                            <circle cx="9" cy="9" r="9"></circle>
                                                            <path d="m11.5639648 5.05283203v4.71571528l-2.72832027 1.57129639" stroke-linecap="round" stroke-linejoin="round" transform="matrix(-1 0 0 1 20.39961 0)"></path>
                                                        </g>
                                                    </svg>
                                                    <div class="end-text">Kết thúc trong</div>
                                                    <div class="flash-sale-countdown" id="the-24h-countdown">
                                                        <p></p>
                                                    </div>
                                                </div>
                                                <div class="flex flex-column">
                                                    <div class="flex flex-column p-15">
                                                        <div class="flex items-center">
                                                            <div class="flex items-center">
                                                                <div class="listed-price old-price">{{ number_format($minListedPrice) }}₫</div>
                                                                <div class="flex items-center">
                                                                    <div class="sale-price">{{ number_format($minSalePrice) }}₫</div>
                                                                    <div class="discount-percentage box-sale">{{ number_format($discountPercentage) }}%</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="non-flash-sale-container" class="ec-single-price {{ $product->is_in_flash_sale ? 'd-none' : '' }}">
                                            @if($minSalePrice)
                                            <div class="flex flex-column">
                                                <div class="flex flex-column p-15">
                                                    <div class="flex items-center">
                                                        <div class="flex items-center">
                                                            <div class="listed-price old-price">{{ number_format($minListedPrice) }}₫</div>
                                                            <div class="flex items-center">
                                                                <div class="sale-price">{{ number_format($minSalePrice) }}₫</div>
                                                                <div class="discount-percentage box-sale">{{ number_format($discountPercentage) }}%</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="flex flex-column">
                                                <div class="flex flex-column p-15">
                                                    <div class="flex items-center">
                                                        <div class="flex items-center">
                                                            <div class="listed-price old-price">{{ number_format($minListedPrice) }}₫</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ec-pro-variation">
                                        <div class="ec-pro-variation-inner ec-pro-variation-size">
                                            <span>Kích thước</span>
                                            <div class="">
                                                @foreach($product->variants->unique('size_id') as $variant)
                                                <button class="product-option size-btn" data-id="{{ $variant->size_id }}">{{ $variant->size->name }}</button>

                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="ec-pro-variation-inner ec-pro-variation-color">
                                            <span>Màu sắc</span>
                                            <div class="">
                                                @foreach($product->variants->unique('color_id') as $variant)
                                                <button class="product-option color-btn" data-id="{{ $variant->color_id }}">{{ $variant->color->name }}</button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ec-single-qty">
                                        <div class="qty-plus-minus">
                                            <input class="qty-input" id="quantity" type="text" name="ec_qtybtn" value="1" />
                                        </div>
                                        <div class="ec-single-cart ">
                                            <button id="addToCartButton" class="btn btn-primary btn-cart">Thêm giỏ hàng</button>

                                        </div>
                                        <div class="ec-single-cart ">
                                            <button id="buyNow" class="btn" style="background-color: #007bff; color: white; border: 1px solid #007bff; padding: 10px 20px; font-size: 16px; ">Mua ngay</button>
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
                                        data-bs-target="#ec-spt-nav-details" role="tab" aria-controls="ec-spt-nav-details" aria-selected="true">Chi tiết sản phẩm</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#ec-spt-nav-info"
                                        role="tab" aria-controls="ec-spt-nav-info" aria-selected="false">More Information</a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#ec-spt-nav-review"
                                        role="tab" aria-controls="ec-spt-nav-review" aria-selected="false">Đánh giá sản phẩm</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content  ec-single-pro-tab-content">
                            <div id="ec-spt-nav-details" class="tab-pane fade show active">
                                <div class="ec-single-pro-tab-desc">
                                    {!! $product->description !!}
                                </div>
                            </div>
                            <div id="ec-spt-nav-info" class="tab-pane fade">
                                <div class="ec-single-pro-tab-moreinfo">
                                    <ul>
                                        <li><span>Weight</span> 1000 g</li>
                                        <li><span>Dimensions</span> 35 × 30 × 7 cm</li>
                                        <li><span>Color</span> Black, Pink, Red, White</li>
                                    </ul>
                                </div>
                            </div>

                            <div id="ec-spt-nav-review" class="tab-pane fade">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="ec-t-review-top d-flex flex-column">
                                        @if ($averageScore)
                                        <h4 class="mb-2"> {{ number_format($averageScore, 1) }} trên 5</h4>
                                        @else
                                        Chưa có đánh giá
                                        @endif

                                        <div class="ec-t-review-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <=$averageScore)
                                                <i class="ecicon eci-star text-warning"></i>
                                                @else
                                                <i class="ecicon eci-star-o"></i>
                                                @endif
                                                @endfor
                                        </div>
                                    </div>
                                    <div class="rating-buttons" style="display: flex; justify-content: center; gap: 10px; margin: 20px 0;">
                                        <button data-star="" class="rating-button active" style="padding: 5px 10px; font-size: 14px; ">Tất cả (<span>{{ array_sum($reviewCounts->toArray()) }}</span>)</button>
                                        <button data-star="5" class="rating-button" style="padding: 5px 10px; font-size: 14px; ">5 sao (<span>{{ $reviewCounts[5] ?? 0 }}</span>)</button>
                                        <button data-star="4" class="rating-button" style="padding: 5px 10px; font-size: 14px; ">4 sao (<span>{{ $reviewCounts[4] ?? 0 }}</span>)</button>
                                        <button data-star="3" class="rating-button" style="padding: 5px 10px; font-size: 14px; ">3 sao (<span>{{ $reviewCounts[3] ?? 0 }}</span>)</button>
                                        <button data-star="2" class="rating-button" style="padding: 5px 10px; font-size: 14px; ">2 sao (<span>{{ $reviewCounts[2] ?? 0 }}</span>)</button>
                                        <button data-star="1" class="rating-button" style="padding: 5px 10px; font-size: 14px; ">1 sao (<span>{{ $reviewCounts[1] ?? 0 }}</span>)</button>
                                    </div>
                                    
                                    
                                </div>

                                <div class="row">
                                    @include('client.page.partials',['reviews' => $reviews])
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
<section class="section ec-new-product section-space-p" id="arrivals">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">Sản phẩm cùng hạng mục</h2>
                    <h2 class="ec-title">Sản phẩm cùng danh mục </h2>
                    <p class="sub-title">PolyFit - Sự Lựa Chọn Hoàn Hảo Cho Bạn</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="tab-content">
                    <!-- 1st Product tab start -->
                    <div class="tab-pane fade show active" id="tab-pro-for-all">
                        <div class="row">
                            @foreach ($similar_products as $product)
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
                                            @if ($product->min_price)

                                            <span>{{ number_format($product->listed_price, 0) }}₫</span> {{ number_format($product->min_price, 0) }}₫
                                            @else

                                            {{ number_format($product->listed_price, 0) }}₫
                                            @endif

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!-- START single card -->
                            @endforeach
                        </div>

                    </div>
                </div>
                <!-- ec 1st Product tab end -->
                <!-- ec 2nd Product tab start -->
                <div class="tab-pane fade" id="tab-pro-for-men">

                </div>
                <!-- ec 2nd Product tab end -->
                <!-- ec 3rd Product tab start -->
                <div class="tab-pane fade" id="tab-pro-for-women">

                </div>
                <!-- ec 3rd Product tab end -->
                <!-- ec 4th Product tab start -->
                <div class="tab-pane fade" id="tab-pro-for-child">

                </div>
                <!-- ec 4th Product tab end -->
            </div>

        </div>
    </div>

</section>
<!-- Related Product end -->

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let product_id = $('#productId').val();
        let variants = JSON.parse(document.getElementById('product-variants').dataset.variants);
        let selectedSizeId = null;
        let selectedColorId = null;
        var flashSaleEndTime = "{{ $flashSaleEndTime }}";

        const coutDown = (hours, minutes, seconds) => {
            let countDownDate = new Date().getTime() + (hours * 60 * 60 * 1000) + (minutes * 60 * 1000) + (seconds * 1000);

            let countdownFunction = setInterval(() => {
                let now = new Date().getTime();
                let distance = countDownDate - now;

                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                if (hours < 10) hours = "0" + hours;
                if (minutes < 10) minutes = "0" + minutes;
                if (seconds < 10) seconds = "0" + seconds;

                $("#the-24h-countdown p").html(
                    "<span>" +
                    hours +
                    '</span><span class="min">' +
                    minutes +
                    '<br></span><span class="seg">' +
                    seconds +
                    "</span>"
                );

                if (distance < 0) {
                    clearInterval(countdownFunction);
                    $("#the-24h-countdown p").html("Hết giờ");
                }
            }, 1000);
        };

        if (flashSaleEndTime) {
            var countDownDate = new Date(flashSaleEndTime).getTime();
            var now = new Date().getTime();

            var distance = countDownDate - now;

            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            coutDown(hours, minutes, seconds);
            // console.log(hours+  'hours');

        }


        $('#buyNow').click(function(e) {
            e.preventDefault();

            var productId = $('#productId').val();
            var quantity = $('#quantity').val();
            var selectedSize = $('.size-btn.active').data('id');
            var selectedColor = $('.color-btn.active').data('id');

            if (!selectedSize || !selectedColor) {
                toastr.warning('Vui lòng chọn thuộc tính sản phẩm')
                return;
            }

            $.ajax({
                url: '{{route("cart.add")}}',
                method: 'POST',
                data: {
                    product_id: productId,
                    color_id: selectedColor,
                    size_id: selectedSize,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status) {
                        updateCartCount();
                        window.location.href = '{{ route("cart.index") }}';
                    } else {
                        toastr.warning(response.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        toastr.error("Đã có lỗi xảy ra");
                    }

                }
            });

        })

        $('#addToCartButton').click(function(e) {
            e.preventDefault();

            var productId = $('#productId').val();
            var quantity = $('#quantity').val();
            var selectedSize = $('.size-btn.active').data('id');
            var selectedColor = $('.color-btn.active').data('id');

            if (!selectedSize || !selectedColor) {
                toastr.warning('Vui lòng chọn thuộc tính sản phẩm')
                return;
            }

            $.ajax({
                url: '{{route("cart.add")}}',
                method: 'POST',
                data: {
                    product_id: productId,
                    color_id: selectedColor,
                    size_id: selectedSize,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Thêm giỏ hàng thành công",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        updateCartCount();
                    } else {
                        toastr.warning(response.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        toastr.error("Đã có lỗi xảy ra");
                    }

                }
            });
        });

        $('.size-btn').on('click', function() {
            selectedSizeId = $(this).data('id');

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                selectedSizeId = null;
            } else {
                $('.size-btn').removeClass('active');
                $(this).addClass('active');
            }
            if (selectedSizeId) {
                updateColorOptions();
                updateVariantDetails();
            } else {
                $('.color-btn').prop('disabled', false);
            }

        });

        $('.color-btn').on('click', function() {
            selectedColorId = $(this).data('id');

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                selectedColorId = null;
            } else {
                $('.color-btn').removeClass('active');
                $(this).addClass('active');
            }
            if (selectedColorId) {
                updateSizeOptions();
                updateVariantDetails();
            } else {
                $('.size-btn').prop('disabled', false);
            }

        });

        function updateColorOptions() {
            let sizesAvailable = variants.filter(v => v.size_id == selectedSizeId);
            let availableColors = sizesAvailable.map(v => v.color_id);

            $('.color-btn').each(function() {
                let colorId = $(this).data('id');
                if (availableColors.includes(colorId) && sizesAvailable.find(v => v.color_id == colorId).quantity > 0) {
                    $(this).prop('disabled', false);
                } else {
                    $(this).prop('disabled', true);
                }
            });
        }

        function updateSizeOptions() {
            let colorsAvailable = variants.filter(v => v.color_id == selectedColorId);
            let availableSizes = colorsAvailable.map(v => v.size_id);

            $('.size-btn').each(function() {
                let sizeId = $(this).data('id');
                if (availableSizes.includes(sizeId) && colorsAvailable.find(v => v.size_id == sizeId).quantity > 0) {
                    $(this).prop('disabled', false);
                } else {
                    $(this).prop('disabled', true);
                }
            });
        }


        function updateVariantDetails() {
            if (selectedSizeId && selectedColorId) {
                $.ajax({
                    url: '{{route("client.product.variant") }}',
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: product_id,
                        size_id: selectedSizeId,
                        color_id: selectedColorId
                    },
                    success: function(response) {
                        if (response.status) {
                            let listedPrice = response.data.listed_price;
                            let salePrice = response.data.sale_price;
                            let discountPercentage = response.data.discount_percentage;
                            let quantity = response.data.quantity;

                            if (response.data.is_in_flash_sale) {
                                // Hiển thị giá flash sale
                                $('#flash-sale-container').removeClass('d-none');
                                $('#non-flash-sale-container').addClass('d-none');
                                $('.listed-price').text(new Intl.NumberFormat().format(listedPrice) + '₫');
                                $('.sale-price').text(new Intl.NumberFormat().format(salePrice) + '₫');
                                $('.quantity-detail').text(quantity);
                                if (discountPercentage) {
                                    $('.discount-percentage').text(new Intl.NumberFormat().format(discountPercentage) + '%').show();
                                } else {
                                    $('.discount-percentage').hide();
                                }
                            } else {
                                // Hiển thị giá không flash sale
                                $('#flash-sale-container').addClass('d-none');
                                $('#non-flash-sale-container').removeClass('d-none');
                                $('.listed-price').text(new Intl.NumberFormat().format(listedPrice) + '₫');
                                $('.sale-price').text(salePrice ? new Intl.NumberFormat().format(salePrice) + '₫' : '');
                                $('.quantity-detail').text(quantity);
                                if (discountPercentage) {
                                    $('.discount-percentage').text(new Intl.NumberFormat().format(discountPercentage) + '%').show();
                                } else {
                                    $('.discount-percentage').hide();
                                }
                            }
                        }
                    }
                });
            }
        }

        $('.rating-buttons button').on('click', function() {
            const star = $(this).data('star') || null; // Lấy giá trị từ data-star

            // Hiển thị trạng thái loading
            $('#reviewList').html('<p>Đang tải đánh giá...</p>');

            // Đổi trạng thái active
            $('.rating-buttons button').removeClass('active'); // Loại bỏ trạng thái active từ các nút khác
            $(this).addClass('active'); // Thêm trạng thái active cho nút hiện tại


            // Gửi yêu cầu AJAX
            $.ajax({
                url: `/reviews_filter/${product_id}`,
                type: 'GET',
                data: {
                    star: star,
                    _token: '{{ csrf_token() }}'
                },
                headers: {  
                    'X-Requested-With': 'XMLHttpRequest' // Xác định yêu cầu AJAX
                },
                success: function(data) {
                    if (data && data.html) {
                        // Cập nhật danh sách đánh giá
                        $('#reviewList').html(data.html);

                        // Đặt nút hiện tại thành nút đang chọn (active)
                        // $('.rating-buttons button').removeClass('active');
                        // $(`[data-star="${star}"]`).addClass('active');
                    } else {
                        $('#reviewList').html('<p>Không tìm thấy đánh giá nào phù hợp.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi:', error); // Ghi lỗi ra console
                    $('#reviewList').html('<p>Đã xảy ra lỗi khi tải đánh giá. Vui lòng thử lại sau.</p>');
                }
            });
        });

        // $('.rating-buttons button').on('click', function() {
        // Lấy số sao từ nút được bấm
        
    });

  // Lắng nghe sự kiện click trên các nút phân trang
//   $(document).on('click', '.pagination a', function (e) {
//         e.preventDefault(); // Ngăn chặn tải lại trang

//         let url = $(this).attr('href'); // Lấy URL từ liên kết phân trang

//         // Hiển thị trạng thái loading
//         $('#reviewList').html('<p>Đang tải đánh giá...</p>');

//         // Gửi yêu cầu AJAX
//         $.ajax({
//             url: url,
//             type: 'GET',
//             headers: {
//                 'X-Requested-With': 'XMLHttpRequest', // Đảm bảo server nhận biết đây là yêu cầu AJAX
//             },
//             success: function (response) {
//                 if (response.html) {
//                     // Cập nhật nội dung đánh giá mới
//                     $('#reviewList').html(response.html);
//                 } else {
//                     $('#reviewList').html('<p>Không tìm thấy dữ liệu nào.</p>');
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error('Lỗi:', error);
//                 $('#reviewList').html('<p>Đã xảy ra lỗi khi tải đánh giá. Vui lòng thử lại sau.</p>');
//             }
//         });
//     });

    
</script>
@endsection