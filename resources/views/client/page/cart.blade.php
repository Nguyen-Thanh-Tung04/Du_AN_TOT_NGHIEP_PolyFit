@extends('client.layouts.master')

@section('content')

<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Giỏ hàng</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Giỏ hàng</li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->

<!-- Ec About Us page -->
<section class="ec-page-content section-space-p">
    <div class="container">
        <form id="checkoutForm" action="{{ route('checkout.show') }}" method="POST">
            @csrf
            <div class="row">
                <div class="ec-cart-leftside col-lg-12 col-md-12 ">
                    <!-- cart content Start -->
                    <div class="ec-cart-content">
                        <div class="ec-cart-inner">
                            <div class="row">
                                <div class="table-content cart-table-content">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="selectAll" class="product-checkbox">
                                                </th>
                                                <th>
                                                </th>
                                                <th>
                                                    Sản phẩm
                                                </th>
                                                <th>Phân loại</th>
                                                <th>Đơn giá</th>
                                                <th style="text-align: center;">Số lượng</th>
                                                <th>Số tiền</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cartItems as $item)
                                            @php
                                            $gallery = json_decode($item->variant->product->gallery);
                                            @endphp
                                            <tr id="cart-item-{{ $item->id }}">
                                                <td>
                                                    <input type="checkbox"
                                                    class="product-checkbox select-item"
                                                    data-id="{{ $item->id }}"
                                                    name="product_variant_ids[]" 
                                                    value="{{ $item->variant->id }}">
                                                </td>
                                                <td>
                                                    <img
                                                        class=" ec-cart-pro-img mr-4"
                                                        src="{{ (!empty($gallery)) ? $gallery[0] : '' }}" alt="" />
                                                </td>
                                                <td data-label=" Sản phẩm" class="ec-cart-pro-name">
                                                    <a class="fw-semibold fs-6" href="{{ route('client.product.show', $item->variant->product->id)}}">
                                                        {{ $item->variant->product->name }}
                                                    </a>
                                                </td>
                                                <td data-label="Phân loại" class="ec-cart-pro-price">
                                                    <span>{{ $item->variant->size->name }},</span>
                                                    <span>{{ $item->variant->color->name }}</span>
                                                </td>
                                                <td data-label="Đơn giá" class="ec-cart-pro-price">
                                                    <span class="amount">
                                                        @if($item->variant->sale_price)
                                                        <span class="text-decoration-line-through purchase_price">{{ number_format($item->variant->purchase_price) }}₫</span>
                                                        <span class="sale_price"> {{ number_format($item->variant->sale_price) }}₫</span>
                                                        @else
                                                        <span class="purchase_price">{{ number_format($item->variant->purchase_price) }}₫</span>
                                                        @endif

                                                    </span>
                                                </td>
                                                <td data-label="Số lượng" class="ec-cart-pro-qty"
                                                    style="text-align: center;">
                                                    <div class="cart-qty-plus-minus">
                                                        <input class="cart-plus-minus quantity-input" name="quantities[{{ $item->variant->id }}]" data-id="{{ $item->id }}" data-old-value="{{ $item->quantity }}" data-min="1" data-max=" {{$item->variant->quantity }}" type="text" value="{{ $item->quantity }}"/>
                                                    </div>
                                                </td>
                                                <td data-label="Số tiền" class="ec-cart-pro-subtotal">
                                                    {{ number_format(($item->variant->sale_price ?? $item->variant->purchase_price) * $item->quantity) }}₫
                                                </td>
                                                <td data-label="Xóa" class="ec-cart-pro-remove">
                                                    <button class="delete-item fs-5" data-cart-id="{{ $item->id }}"><i class="ecicon eci-trash-o"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--cart content End -->
                </div>
                <!-- Sidebar Area Start -->
                <div class="ec-cart-rightside col-lg-12 col-md-12 mt-5">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Summary Block -->
                        <div class="ec-sidebar-block">

                            <div class="ec-sb-block-content">
                                <div class="ec-cart-summary-bottom">
                                    <div class="ec-cart-summary">
                                        {{-- <div>
                                            <span class="text-left">Voucher</span>
                                            <span class="text-right"><a class="ec-cart-coupan">Nhập mã</a></span>
                                        </div>
                                        <div class="ec-cart-coupan-content">
                                            <form class="ec-cart-coupan-form" name="ec-cart-coupan-form"
                                                action="#">
                                                <input class="ec-coupan" type="text" required=""
                                                    placeholder="Nhập mã giảm giá" name="ec-coupan" value="">
                                                <button class="ec-coupan-btn button btn-primary" type="submit"
                                                    name="subscribe" value="">OK</button>
                                            </form>
                                        </div> --}}
                                        <div class="border-top pt-3">
                                            <span class="text-left">Tổng tiền hàng</span>
                                            <span id="subtotal" class="text-right">0₫</span>
                                        </div>
                                        <div class="pt-3">
                                            <span class="text-left">Voucher giảm giá</span>
                                            <span class="text-right">0₫</span>
                                        </div>
                                        <div class="pt-3">
                                            <span class="text-left">Giảm giá sản phẩm</span>
                                            <span id="discount" class="text-right">0₫</span>
                                        </div>
                                        <div class="fw-bolder pt-3 border-top">
                                            <span class="text-left">Tổng số tiền</span>
                                            <span id="total" class="text-right">0₫</span>
                                        </div>

                                        <div class="ec-cart-summary-total border-top">
                                            <span class="text-left"></span>
                                            <button type="submit" class="btn btn-primary">Mua hàng</button>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Summary Block -->
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- New Product Start -->
<section class="section ec-new-product section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">New Arrivals</h2>
                    <h2 class="ec-title">New Arrivals</h2>
                    <p class="sub-title">Browse The Collection of Top Products</p>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- New Product Content -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content">
                <div class="ec-product-inner">
                    <div class="ec-pro-image-outer">
                        <div class="ec-pro-image">
                            <a href="product-left-sidebar.html" class="image">
                                <img class="main-image" src="theme/client/assets/images/product-image/6_1.jpg" alt="Product" />
                                <img class="hover-image" src="theme/client/assets/images/product-image/6_2.jpg" alt="Product" />
                            </a>
                            <span class="percentage">20%</span>
                            <a href="#" class="quickview" data-link-action="quickview" title="Quick view"
                                data-bs-toggle="modal" data-bs-target="#ec_quickview_modal"><i
                                    class="fi-rr-eye"></i></a>
                            <div class="ec-pro-actions">
                                <a href="compare.html" class="ec-btn-group compare" title="Compare"><i
                                        class="fi fi-rr-arrows-repeat"></i></a>
                                <button title="Add To Cart" class="add-to-cart"><i
                                        class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                <a class="ec-btn-group wishlist" title="Wishlist"><i class="fi-rr-heart"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="ec-pro-content">
                        <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Round Neck T-Shirt</a></h5>
                        <div class="ec-pro-rating">
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star"></i>
                        </div>
                        <div class="ec-pro-list-desc">Lorem Ipsum is simply dummy text of the printing and
                            typesetting industry. Lorem Ipsum is simply dutmmy text ever since the 1500s, when an
                            unknown printer took a galley.</div>
                        <span class="ec-price">
                            <span class="old-price">$27.00</span>
                            <span class="new-price">$22.00</span>
                        </span>
                        <div class="ec-pro-option">
                            <div class="ec-pro-color">
                                <span class="ec-pro-opt-label">Color</span>
                                <ul class="ec-opt-swatch ec-change-img">
                                    <li class="active"><a href="#" class="ec-opt-clr-img"
                                            data-src="theme/client/assets/images/product-image/6_1.jpg"
                                            data-src-hover="theme/client/assets/images/product-image/6_1.jpg"
                                            data-tooltip="Gray"><span style="background-color:#e8c2ff;"></span></a>
                                    </li>
                                    <li><a href="#" class="ec-opt-clr-img"
                                            data-src="theme/client/assets/images/product-image/6_2.jpg"
                                            data-src-hover="theme/client/assets/images/product-image/6_2.jpg"
                                            data-tooltip="Orange"><span
                                                style="background-color:#9cfdd5;"></span></a></li>
                                </ul>
                            </div>
                            <div class="ec-pro-size">
                                <span class="ec-pro-opt-label">Size</span>
                                <ul class="ec-opt-size">
                                    <li class="active"><a href="#" class="ec-opt-sz" data-old="$25.00"
                                            data-new="$20.00" data-tooltip="Small">S</a></li>
                                    <li><a href="#" class="ec-opt-sz" data-old="$27.00" data-new="$22.00"
                                            data-tooltip="Medium">M</a></li>
                                    <li><a href="#" class="ec-opt-sz" data-old="$35.00" data-new="$30.00"
                                            data-tooltip="Extra Large">XL</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content">
                <div class="ec-product-inner">
                    <div class="ec-pro-image-outer">
                        <div class="ec-pro-image">
                            <a href="product-left-sidebar.html" class="image">
                                <img class="main-image" src="theme/client/assets/images/product-image/7_1.jpg" alt="Product" />
                                <img class="hover-image" src="theme/client/assets/images/product-image/7_2.jpg" alt="Product" />
                            </a>
                            <span class="percentage">20%</span>
                            <span class="flags">
                                <span class="sale">Sale</span>
                            </span>
                            <a href="#" class="quickview" data-link-action="quickview" title="Quick view"
                                data-bs-toggle="modal" data-bs-target="#ec_quickview_modal"><i
                                    class="fi-rr-eye"></i></a>
                            <div class="ec-pro-actions">
                                <a href="compare.html" class="ec-btn-group compare" title="Compare"><i
                                        class="fi fi-rr-arrows-repeat"></i></a>
                                <button title="Add To Cart" class="add-to-cart"><i
                                        class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                <a class="ec-btn-group wishlist" title="Wishlist"><i class="fi-rr-heart"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="ec-pro-content">
                        <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Full Sleeve Shirt</a></h5>
                        <div class="ec-pro-rating">
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star"></i>
                        </div>
                        <div class="ec-pro-list-desc">Lorem Ipsum is simply dummy text of the printing and
                            typesetting industry. Lorem Ipsum is simply dutmmy text ever since the 1500s, when an
                            unknown printer took a galley.</div>
                        <span class="ec-price">
                            <span class="old-price">$12.00</span>
                            <span class="new-price">$10.00</span>
                        </span>
                        <div class="ec-pro-option">
                            <div class="ec-pro-color">
                                <span class="ec-pro-opt-label">Color</span>
                                <ul class="ec-opt-swatch ec-change-img">
                                    <li class="active"><a href="#" class="ec-opt-clr-img"
                                            data-src="theme/client/assets/images/product-image/7_1.jpg"
                                            data-src-hover="theme/client/assets/images/product-image/7_1.jpg"
                                            data-tooltip="Gray"><span style="background-color:#01f1f1;"></span></a>
                                    </li>
                                    <li><a href="#" class="ec-opt-clr-img"
                                            data-src="theme/client/assets/images/product-image/7_2.jpg"
                                            data-src-hover="theme/client/assets/images/product-image/7_2.jpg"
                                            data-tooltip="Orange"><span
                                                style="background-color:#b89df8;"></span></a></li>
                                </ul>
                            </div>
                            <div class="ec-pro-size">
                                <span class="ec-pro-opt-label">Size</span>
                                <ul class="ec-opt-size">
                                    <li class="active"><a href="#" class="ec-opt-sz" data-old="$12.00"
                                            data-new="$10.00" data-tooltip="Small">S</a></li>
                                    <li><a href="#" class="ec-opt-sz" data-old="$15.00" data-new="$12.00"
                                            data-tooltip="Medium">M</a></li>
                                    <li><a href="#" class="ec-opt-sz" data-old="$20.00" data-new="$17.00"
                                            data-tooltip="Extra Large">XL</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content">
                <div class="ec-product-inner">
                    <div class="ec-pro-image-outer">
                        <div class="ec-pro-image">
                            <a href="product-left-sidebar.html" class="image">
                                <img class="main-image" src="theme/client/assets/images/product-image/1_1.jpg" alt="Product" />
                                <img class="hover-image" src="theme/client/assets/images/product-image/1_2.jpg" alt="Product" />
                            </a>
                            <span class="percentage">20%</span>
                            <span class="flags">
                                <span class="sale">Sale</span>
                            </span>
                            <a href="#" class="quickview" data-link-action="quickview" title="Quick view"
                                data-bs-toggle="modal" data-bs-target="#ec_quickview_modal"><i
                                    class="fi-rr-eye"></i></a>
                            <div class="ec-pro-actions">
                                <a href="compare.html" class="ec-btn-group compare" title="Compare"><i
                                        class="fi fi-rr-arrows-repeat"></i></a>
                                <button title="Add To Cart" class="add-to-cart"><i
                                        class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                <a class="ec-btn-group wishlist" title="Wishlist"><i class="fi-rr-heart"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="ec-pro-content">
                        <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Cute Baby Toy's</a></h5>
                        <div class="ec-pro-rating">
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star"></i>
                        </div>
                        <div class="ec-pro-list-desc">Lorem Ipsum is simply dummy text of the printing and
                            typesetting industry. Lorem Ipsum is simply dutmmy text ever since the 1500s, when an
                            unknown printer took a galley.</div>
                        <span class="ec-price">
                            <span class="old-price">$40.00</span>
                            <span class="new-price">$30.00</span>
                        </span>
                        <div class="ec-pro-option">
                            <div class="ec-pro-color">
                                <span class="ec-pro-opt-label">Color</span>
                                <ul class="ec-opt-swatch ec-change-img">
                                    <li class="active"><a href="#" class="ec-opt-clr-img"
                                            data-src="theme/client/assets/images/product-image/1_1.jpg"
                                            data-src-hover="theme/client/assets/images/product-image/1_1.jpg"
                                            data-tooltip="Gray"><span style="background-color:#90cdf7;"></span></a>
                                    </li>
                                    <li><a href="#" class="ec-opt-clr-img"
                                            data-src="theme/client/assets/images/product-image/1_2.jpg"
                                            data-src-hover="theme/client/assets/images/product-image/1_2.jpg"
                                            data-tooltip="Orange"><span
                                                style="background-color:#ff3b66;"></span></a></li>
                                    <li><a href="#" class="ec-opt-clr-img"
                                            data-src="theme/client/assets/images/product-image/1_3.jpg"
                                            data-src-hover="theme/client/assets/images/product-image/1_3.jpg"
                                            data-tooltip="Green"><span style="background-color:#ffc476;"></span></a>
                                    </li>
                                    <li><a href="#" class="ec-opt-clr-img"
                                            data-src="theme/client/assets/images/product-image/1_4.jpg"
                                            data-src-hover="theme/client/assets/images/product-image/1_4.jpg"
                                            data-tooltip="Sky Blue"><span
                                                style="background-color:#1af0ba;"></span></a></li>
                                </ul>
                            </div>
                            <div class="ec-pro-size">
                                <span class="ec-pro-opt-label">Size</span>
                                <ul class="ec-opt-size">
                                    <li class="active"><a href="#" class="ec-opt-sz" data-old="$40.00"
                                            data-new="$30.00" data-tooltip="Small">S</a></li>
                                    <li><a href="#" class="ec-opt-sz" data-old="$50.00" data-new="$40.00"
                                            data-tooltip="Medium">M</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content">
                <div class="ec-product-inner">
                    <div class="ec-pro-image-outer">
                        <div class="ec-pro-image">
                            <a href="product-left-sidebar.html" class="image">
                                <img class="main-image" src="theme/client/assets/images/product-image/2_1.jpg" alt="Product" />
                                <img class="hover-image" src="theme/client/assets/images/product-image/2_2.jpg" alt="Product" />
                            </a>
                            <span class="percentage">20%</span>
                            <span class="flags">
                                <span class="new">New</span>
                            </span>
                            <a href="#" class="quickview" data-link-action="quickview" title="Quick view"
                                data-bs-toggle="modal" data-bs-target="#ec_quickview_modal"><i
                                    class="fi-rr-eye"></i></a>
                            <div class="ec-pro-actions">
                                <a href="compare.html" class="ec-btn-group compare" title="Compare"><i
                                        class="fi fi-rr-arrows-repeat"></i></a>
                                <button title="Add To Cart" class="add-to-cart"><i
                                        class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                <a class="ec-btn-group wishlist" title="Wishlist"><i class="fi-rr-heart"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="ec-pro-content">
                        <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Jumbo Carry Bag</a></h5>
                        <div class="ec-pro-rating">
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star fill"></i>
                            <i class="ecicon eci-star"></i>
                        </div>
                        <div class="ec-pro-list-desc">Lorem Ipsum is simply dummy text of the printing and
                            typesetting industry. Lorem Ipsum is simply dutmmy text ever since the 1500s, when an
                            unknown printer took a galley.</div>
                        <span class="ec-price">
                            <span class="old-price">$50.00</span>
                            <span class="new-price">$40.00</span>
                        </span>
                        <div class="ec-pro-option">
                            <div class="ec-pro-color">
                                <span class="ec-pro-opt-label">Color</span>
                                <ul class="ec-opt-swatch ec-change-img">
                                    <li class="active"><a href="#" class="ec-opt-clr-img"
                                            data-src="theme/client/assets/images/product-image/2_1.jpg"
                                            data-src-hover="theme/client/assets/images/product-image/2_2.jpg"
                                            data-tooltip="Gray"><span style="background-color:#fdbf04;"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 shop-all-btn"><a href="#">Shop All Collection</a></div>
        </div>
    </div>
</section>
<!-- New Product end -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        $('#selectAll').change(function() {
            $('.select-item').prop('checked', $(this).is(':checked'));
            calculateTotal();
        });

        $('.select-item').on('change', function() {
            if ($('.select-item:checked').length === $('.select-item').length) {
                $('#selectAll').prop('checked', true);
            } else {
                $('#selectAll').prop('checked', false);
            }
            calculateTotal();
        });

        $('.quantity-input').on('input', function() {
            let input = $(this);
            let min = parseInt(input.attr('data-min'));
            let max = parseInt(input.attr('data-max'));
            let value = input.val();

            if (value.match(/[^0-9]/g)) {
                value = value.replace(/[^0-9]/g, '');
                input.val(value);
            }

            if (value < min) {
                input.val(min);
            }

            if (value > max) {
                input.val(max);
            }
        });

        $('.quantity-input').on('change', function() {
            let itemId = $(this).data('id');
            let quantity = parseInt($(this).val());
            let maxQuantity = parseInt($(this).attr('max'));

            updateCartQuantity(itemId, quantity, $(this));
        });


        function updateCartQuantity(itemId, quantity, input) {
            input.prop('disabled', true).addClass('disabled-input');
            $.ajax({
                url: '{{route("cart.update")}}',
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    cart_id: itemId,
                    quantity: quantity
                },
                success: function(response) {
                    input.prop('disabled', false).removeClass('disabled-input');
                    if (response.status) {
                        calculateTotal();
                    }
                },
                error: function() {
                    input.prop('disabled', false).removeClass('disabled-input');
                }
            });
        }

        $('.quantity-input').on('keydown', function(e) {
            if ((e.which < 48 || e.which > 57) && e.which !== 8 && e.which !== 37 && e.which !== 39) {
                e.preventDefault();
            }
        });

        function calculateTotal() {
            let selectedItems = [];

            $('.select-item:checked').each(function() {
                let itemId = $(this).data('id');

                selectedItems.push({
                    id: itemId
                });
            });

            if (selectedItems.length === 0) {
                $('#subtotal').text('0₫');
                $('#discount').text('0₫');
                $('#total').text('0₫');
                return;
            }

            $.ajax({
                url: '{{route("cart.calculate")}}',
                method: 'GET',
                data: {
                    items: selectedItems,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {

                    $('#subtotal').text(new Intl.NumberFormat().format(response.subtotal) + '₫');
                    $('#discount').text(new Intl.NumberFormat().format(response.discount) + '₫');
                    $('#total').text(new Intl.NumberFormat().format(response.total) + '₫');
                },
                error: function(xhr) {
                    Toast.fire({
                        icon: 'error',
                        title: "Có lỗi xảy ra!",
                    })
                }
            });
        }

        $('.delete-item').on('click', function() {
            const cartId = $(this).data('cart-id');
            const rowId = "#cart-item-" + cartId;
            $.ajax({
                url: '{{ route("cart.delete")}}',
                method: 'DELETE',
                data: {
                    cart_id: cartId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status) {
                        $(rowId).remove();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message,
                        })
                    }
                },
                error: function() {
                    Toast.fire({
                        icon: 'error',
                        title: 'Xảy ra lỗi',
                    })
                }
            });
        });

    });
</script>
<script src="{{ asset('theme/client/library/library.js') }}"></script>
@endsection