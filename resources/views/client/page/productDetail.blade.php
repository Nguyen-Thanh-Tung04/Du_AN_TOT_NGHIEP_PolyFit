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
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star-o"></i>
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
                                            <span id="purchase-price" class="fw-semibold" style="text-decoration: line-through;">{{ number_format($minPurchasePrice) }} ₫</span>
                                            <span id="sale-price" class="new-price">{{ number_format($minSalePrice) }} ₫</span>
                                            @else
                                            <span id="purchase-price" class="new-price">{{ number_format($minPurchasePrice) }} ₫</span>
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
                                        <h4 class="mb-2">4.5 trên 5</h4>
                                        <div class="ec-t-review-rating">
                                            <i class="ecicon eci-star text-warning"></i>
                                            <i class="ecicon eci-star text-warning"></i>
                                            <i class="ecicon eci-star text-warning"></i>
                                            <i class="ecicon eci-star text-warning"></i>
                                            <i class="ecicon eci-star-o"></i>
                                        </div>
                                    </div>
                                    @if(Auth::check())
                                    <button type="button" class="btn btn-primary rounded-pill btn-jittery" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Viết đánh giá</button>                               
                                    @else
                                    <div class="alert alert-danger" id="loginBtn" role="alert">
                                        Đăng nhập để có thể đánh giá sản phẩm
                                    </div>
                                    {{-- <button>Đăng nhập để được viết đánh giá !</button> --}}
                                    @endif
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
                                                                    @if($i <= $rv->score)
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
                                                                <img src="{{ asset('theme/client/assets/images/review-image/1.jpg') }}" class="rounded-circle" alt="" />
                                                            </div>
                                                            <div class="ec-t-review-content border bg-light p-3" style="width:45rem">
                                                                <div class="ec-t-review-top">
                                                                    <div class="ec-t-review-name">{{ $reply->user->name }}</div>
                                                                    <div class="ec-t-review-rating">
                                                                        @for($i = 1; $i <= 5; $i++)
                                                                            @if($i <= $rv->score)
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
                                    
                                    
                                  <!-- Modal -->
                                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLabel">Viết đánh giá</h3>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                
                                            <div class="modal-body">
                                                <!-- Product Image -->
                                                <div class="row mb-4">
                                                    <div class="col-12 text-center">
                                                        @foreach($galleryImages as $key => $image)
                                                            @if($key === 0)
                                                                <div class="single-slide">
                                                                    <img class="img-fluid rounded" src="{{ $image }}" alt="{{ $product->name }}" style="max-width: 200px;">
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                                
                                                <!-- Review Form -->
                                                <form id="review-form" enctype="multipart/form-data">
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                     <!-- Rating Section -->
                                                <div class="row mb-3 justify-content-center">
                                                    <div class="col-auto">
                                                        <div class="rate">
                                                            <input type="radio" id="star5" name="rate" value="5" />
                                                            <label for="star5" title="Rất hài lòng">5 stars</label>
                                                            <input type="radio" id="star4" name="rate" value="4" />
                                                            <label for="star4" title="Hài lòng">4 stars</label>
                                                            <input type="radio" id="star3" name="rate" value="3" />
                                                            <label for="star3" title="Bình thường">3 stars</label>
                                                            <input type="radio" id="star2" name="rate" value="2" />
                                                            <label for="star2" title="Tạm được">2 stars</label>
                                                            <input type="radio" id="star1" name="rate" value="1" />
                                                            <label for="star1" title="Không thích">1 star</label>
                                                        </div>
                                                        <div class="rate-text text-center uk-hidden">
                                                            Rất hài lòng
                                                        </div>
                                                    </div>
                                                </div>
                                                    <div class="mb-4">
                                                        <textarea class="form-control" id="message-text" name="review_text" rows="4" placeholder="Mời bạn chia sẻ thêm cảm nhận ..."></textarea>
                                                    </div>
                                                    
                                                    <div class="mb-3 text-center">
                                                        <label for="file-upload" class="form-label">Hình ảnh trải nghiệm sản phẩm (nếu có)</label>
                                                        <div class="container-xl">
                                                            <div class="box-input-1"></div>
                                                            <label for="imgUpload_2" class="custom-file-2">
                                                                <i class="fas fa-cloud-upload-alt"></i>
                                                            </label>
                                                            <span id="filesel_2">Choose a file...</span>
                                                            <input type="file" id="imgUpload_2" class="uk-hidden" name="review_image" accept="image/*" multiple>
                                                            
                                                            <!-- Container for displaying selected images -->
                                                            <div id="image-preview-container" class="mt-3"></div>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                </form>
                                                
                                            </div>
                                
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Thoát</button>
                                                <button type="button" class="btn btn-primary rounded-pill" id="submit-review">Gửi đánh giá</button>
                                            </div>
                                        </div>
                                    </div>
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
<section class="section ec-releted-product section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">Related products</h2>
                    <h2 class="ec-title">Related products</h2>
                    <p class="sub-title">Browse The Collection of Top Products</p>
                </div>
            </div>
        </div>
        <div class="row margin-minus-b-30">
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
    <div id="product-variants" data-variants="{{ json_encode($product->variants) }}">
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
                            timer: 3000
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
            $('.size-btn').removeClass('active');
            $(this).addClass('active');
            updateColorOptions();
            updateVariantDetails();
        });

        $('.color-btn').on('click', function() {
            selectedColorId = $(this).data('id');
            $('.color-btn').removeClass('active');
            $(this).addClass('active');
            updateSizeOptions();
            updateVariantDetails();
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
                            let purchasePrice = response.data.purchase_price;
                            let salePrice = response.data.sale_price;

                            if (salePrice) {
                                $('#purchase-price').text(new Intl.NumberFormat().format(purchasePrice) + ' ₫');
                                $('#sale-price').text(new Intl.NumberFormat().format(salePrice) + ' ₫');
                            } else {
                                $('#purchase-price').text(new Intl.NumberFormat().format(purchasePrice) + ' ₫');
                                $('#sale-price').text('');
                            }

                            // .. $('#variant-quantity').text(response.data.quantity);
                        } else {
                            // $('#variant-quantity').text('Out of stock');
                        }
                    }
                });
            } else {
                $('#variant-quantity').text('Please select size and color');
            }
        }
    });

    // Phần sao reviews
    $(document).ready(function() {
    // Đối tượng chứa mô tả tương ứng với từng ngôi sao
    var starDescriptions = {
        1: "Không thích",
        2: "Tạm được",
        3: "Bình thường",
        4: "Hài lòng",
        5: "Rất hài lòng"
    };

    // Khi người dùng chọn sao
    $('.rate input').on('change', function() {
        // Lấy giá trị của sao đã chọn
        var starValue = $(this).val();

        // Cập nhật nội dung mô tả dựa trên giá trị sao
        $('.rate-text').text(starDescriptions[starValue]);

        // Hiển thị lại phần mô tả nếu nó đang bị ẩn
        if ($('.rate-text').hasClass('uk-hidden')) {
            $('.rate-text').removeClass('uk-hidden');
        }
    });
});

// Cập nhật reviews 
$(document).ready(function() {
    $('#submit-review').on('click', function(e) {
        e.preventDefault();

        var formData = new FormData($('#review-form')[0]);
        formData.append('rate', $('input[name="rate"]:checked').val());

        // Thêm CSRF token vào form data
        formData.append('_token', $('meta[name="csrf-token"]').attr('content')); 
        
        // Console log dữ liệu trong formData (for debugging)
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            url: '/submit-review',  // Đường dẫn đến route xử lý trên server
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Xử lý thành công
                if (response.success) {
                    Swal.fire({
                    title: 'Thông báo',
                    text: 'Đánh giá thành công !',
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 6000,
                    showCloseButton: true
                });
                    $('#exampleModal').modal('hide');  // Đóng modal

                    // Append the new review dynamically
                    var newReview = `
                        <div class="ec-t-review-item">
                            <div class="ec-t-review-avtar">
                                <img src="{{ asset('theme/client/assets/images/review-image/1.jpg') }}" class="rounded-circle" alt="" />
                            </div>
                            <div class="ec-t-review-content">
                                <div class="ec-t-review-top">
                                    <div class="ec-t-review-name">${response.name}</div>
                                    <div class="ec-t-review-rating">`;

                    for (var i = 1; i <= 5; i++) {
                        newReview += `<i class="ecicon ${i <= response.score ? 'eci-star text-warning' : 'eci-star-o'}"></i>`;
                    }

                    newReview += `
                                    </div>
                                </div>
                                <div class="ec-t-review-bottom">
                                    <p>${response.content}</p>
                                </div>`;

                    if (response.image) {
                        newReview += `<img src="${response.image}" style="height:90px; width:90px" alt="Review Image" />`;
                    }

                    newReview += `</div></div>`;

                    $('#reviewList').prepend(newReview); // Assuming you have a container with ID reviewList
                } else {
                    alert(response.message || 'Có lỗi xảy ra.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    
                    // Hiển thị lỗi cho từng trường
                    if (errors.review_text) {
                        $('#message-text').after('<div class="error-message text-danger fw-bold">' + errors.review_text[0] + '</div>');
                    }
                    if (errors.rate) {
                        $('input[name="rate"]').closest('.rate-group').after('<div class="error-message text-danger">' + errors.rate[0] + '</div>');
                    }
                    if (errors.review_image) {
                        $('#imgUpload_2').after('<div class="error-message text-danger fw-bold">' + errors.review_image[0] + '</div>');
                    }
                } else {
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            }
        });
    });
});


// cập nhật ảnh ra form luôn sau khi chọn
$(document).ready(function() {
    $('#imgUpload_2').on('change', function(event) {
        // Clear previous images
        $('#image-preview-container').empty();
        
        // Get the selected files
        var files = event.target.files;

        // Loop through the selected files and create image elements
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            // Create an image element for each file
            reader.onload = (function(file) {
                return function(e) {
                    var imgElement = $('<img>', {
                        src: e.target.result,
                        class: 'img-thumbnail',
                        style: 'height: 90px; width: 90px; margin-right: 5px;'
                    });
                    $('#image-preview-container').append(imgElement);
                };
            })(file);

            // Read the file as a data URL
            reader.readAsDataURL(file);
        }
        
        // Update the label to show the number of files selected
        $('#filesel_2').text(files.length + ' file(s) selected');
    });
});

// Nút bấm đăng nhập
document.getElementById("loginBtn").addEventListener("click", function() {
    window.location.href = "{{ route('auth.client-login') }}";
});




</script>
@endsection