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
                                        @foreach($galleryImages as $image)
                                        <div class="single-slide zoom-image-hover">
                                            <img class="img-responsive" src="{{ $image }}"
                                                alt="{{ $product->name }}">
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="single-nav-thumb">
                                        @foreach($galleryImages as $image)
                                        <div class="single-slide">
                                            <img class="img-responsive" src="{{ $image }}"
                                                alt="{{ $product->name }}">
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="single-pro-desc single-pro-desc-no-sidebar">
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
                                    <div class="ec-single-price-stoke">
                                        <div class="ec-single-price">
                                            @if($minSalePrice)
                                            <span id="listed-price" class="fw-semibold" style="text-decoration: line-through;">{{ number_format($minListedPrice) }} ₫</span>
                                            <span id="sale-price" class="new-price">{{ number_format($minSalePrice) }} ₫</span>
                                            @else
                                            <span id="listed-price" class="new-price">{{ number_format($minListedPrice) }} ₫</span>
                                            @endif
                                        </div>
                                        <div class="ec-single-stoke">
                                            <span class="ec-single-sku">SKU#: {{ $product->code }}</span>
                                        </div>
                                    </div>
                                    <div class="ec-pro-variation">
                                        <div class="ec-pro-variation-inner ec-pro-variation-size">
                                            <span>SIZE</span>
                                            <div class="">
                                                @foreach($product->variants->unique('size_id') as $variant)
                                                <button class="product-option size-btn" data-id="{{ $variant->size_id }}">{{ $variant->size->name }}</button>

                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="ec-pro-variation-inner ec-pro-variation-color">
                                            <span>Color</span>
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
                                            <button id="addToCartButton" class="btn btn-primary">Thêm giỏ hàng</button>
                                        </div>
                                        <div class="ec-single-wishlist">
                                            <a class="ec-btn-group wishlist" title="Wishlist"><i class="fi-rr-heart"></i></a>
                                        </div>
                                        <div class="ec-single-quickview">
                                            <a href="#" class="ec-btn-group quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal"
                                                data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
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
                                    {!! nl2br(e($product->description)) !!}
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
                                </div>

                                <div class="row">
                                    <div class="ec-t-review-wrapper" id="reviewList">
                                        @if($reviews->count() > 0)
                                        @foreach($reviews as $rv)
                                        <div class="ec-t-review-item">
                                            <div class="ec-t-review-avtar">
                                                <img src="{{ asset('theme/client/assets/images/review-image/1.jpg') }}" class="rounded-circle" alt="" />
                                            </div>
                                            <div class="ec-t-review-content">
                                                <div class="ec-t-review-top">
                                                    <div class="ec-t-review-name">{{ $rv->user->name ?? 'Khách hàng' }}</div>
                                                    <div class="ec-t-review-rating">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <=$rv->score)
                                                            <i class="ecicon eci-star text-warning"></i>
                                                            @else
                                                            <i class="ecicon eci-star-o"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="ec-t-review-bottom">
                                                    <p>{{ $rv->content }}</p>
                                                </div>
                                                @if($rv->image)
                                                <img src="{{ asset(Storage::url($rv->image)) }}" style="height:90px; width:90px" alt="Review Image" />
                                                @endif
                                                <div class="ec-t-review-bottom">
                                                    <p>{{ $rv->created_at->format('Y-m-d') }}</p>
                                                </div>
                                                {{-- Trả lời đánh giá  --}}
                                                @foreach($rv->replies as $reply)
                                                <div class="ec-t-review-item mt-2">
                                                    <div class="ec-t-review-avtar">
                                                        <img src="{{ asset('theme/client/assets/images/logo/logo1.png') }}" class="rounded-circle border" style="width: 90px; height: 90px;" alt="" />
                                                    </div>
                                                    <div class="ec-t-review-content border bg-light p-3" style="width:45rem">
                                                        <div class="ec-t-review-top">
                                                            <div class="ec-t-review-name">PolyFit </div>
                                                            <div class="ec-t-review-rating">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    @if($i <=$rv->score)
                                                                    <i class="ecicon eci-star text-warning"></i>
                                                                    @else
                                                                    <i class="ecicon eci-star-o"></i>
                                                                    @endif
                                                                    @endfor
                                                            </div>
                                                        </div>
                                                        <div class="ec-t-review-bottom">
                                                            <p> {{ $reply->content }}</p>
                                                        </div>
                                                        <div class="ec-t-review-bottom">
                                                            <p>{{ $reply->created_at->format('Y-m-d') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                                        @endif
                                    </div>
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
                    <h2 class="ec-title">Sản phẩm cùng danh mục</h2>
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
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <!-- START single card -->
                                <div class="ec-product-ds">
                                    <div class="ec-product-image">
                                        <a href="{{ route('client.product.show', $product->id) }}" class="image">
                                            <img class="pic-1" src="{{ (!empty($gallery)) ? $gallery[0] : '' }}"
                                                alt="" style="height: 300px" />
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

        $('#addToCartButton').click(function(e) {
            e.preventDefault();

            var productId = $('#productId').val();
            var quantity = $('#quantity').val();
            var selectedSize = $('.size-btn.active').data('id');
            var selectedColor = $('.color-btn.active').data('id');

            if (!selectedSize || !selectedColor) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Vui lòng chọn thuộc tính sản phẩm',
                })
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
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message,
                        })
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Đã xảy ra lỗi',
                        })
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

                            if (salePrice) {
                                $('#listed-price').text(new Intl.NumberFormat().format(listedPrice) + ' ₫');
                                $('#sale-price').text(new Intl.NumberFormat().format(salePrice) + ' ₫');
                            } else {
                                $('#listed-price').text(new Intl.NumberFormat().format(listedPrice) + ' ₫');
                                $('#sale-price').text('');
                            }
                        }
                    }
                });
            }
        }
    });
</script>
@endsection