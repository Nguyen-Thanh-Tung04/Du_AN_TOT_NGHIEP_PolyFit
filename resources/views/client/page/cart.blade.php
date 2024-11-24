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
                @if(count($cartItems) > 0)
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
                                                        @if($item->flash_sale_price)
                                                        <span class="text-decoration-line-through listed_price">{{ number_format($item->listed_price) }}₫</span>
                                                        <span class="sale_price"> {{ number_format($item->flash_sale_price) }}₫</span>
                                                        @else
                                                        @if($item->normal_price < $item->listed_price)
                                                            <span class="text-decoration-line-through listed_price">{{ number_format($item->listed_price) }}₫</span>
                                                            <span class="sale_price">{{ number_format($item->normal_price) }}₫</span>
                                                            @else
                                                            <span class="listed_price">{{ number_format($item->listed_price) }}₫</span>
                                                            @endif
                                                            @endif

                                                    </span>
                                                </td>
                                                <td data-label="Số lượng" class="ec-cart-pro-qty"
                                                    style="text-align: center;">
                                                    <div class="cart-qty-plus-minus">
                                                        <input class="cart-plus-minus quantity-input"
                                                            name="quantities[{{ $item->variant->id }}]"
                                                            data-id="{{ $item->id }}"
                                                            data-old-value="{{ $item->quantity }}"
                                                            data-min="1"
                                                            data-max=" {{$item->variant->quantity }}" type="text"
                                                            value="{{ number_format($item->quantity) }}" />
                                                    </div>
                                                </td>
                                                <td data-label="Số tiền" class="ec-cart-pro-subtotal total-price">
                                                    @if($item->flash_sale_price)
                                                    {{ number_format(($item->flash_sale_price * $item->flash_sale_qty) + ($item->normal_price * $item->normal_qty)) }}₫
                                                    @else
                                                    {{ number_format($item->normal_price * $item->quantity) }}₫
                                                    @endif
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
                                        <div class="border-top pt-3">
                                            <span class="text-left">Tổng tiền hàng</span>
                                            <span id="subtotal" class="text-right">0₫</span>
                                        </div>
                                        <div class="pt-3">
                                            <span class="text-left">Giảm giá sản phẩm</span>
                                            <span id="discount" class="text-right">0₫</span>
                                        </div>
                                        <div class="fw-bolder pt-3 border-top">
                                            <span class="text-left">Tổng số tiền</span>
                                            <span id="total" class="text-right fw-bold fs-4 text-danger">0₫</span>
                                        </div>


                                        <div class="ec-cart-summary-total border-top">
                                            <span class="text-left"></span>
                                            <button type="submit" id="checkout-btn" class="btn btn-primary">Mua hàng</button>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Summary Block -->
                    </div>
                </div>
                @else
                <div class="ec-cart-leftside col-lg-12 col-md-12 ">
                    <div class="d-flex justify-content-center flex-column align-items-center">
                        <img src="{{ asset('theme/client/assets/images/icons/nothing.png') }}" alt="" class="img-fluid" width="80px" />
                        <h4 class="text-center">Giỏ hàng của bạn đang trống!</h4>
                        <div>
                            <a href="{{ route('home')}}" class="btn btn-primary text-center">Mua ngay</a>
                        </div>
                    </div>

                </div>
                @endif
            </div>
        </form>
    </div>
</section>

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
            checkInput(input);
        });

        function checkInput(input) {
            let quantity = input.val();

            let min = parseInt(input.attr('data-min'));
            let max = parseInt(input.attr('data-max'));

            if (quantity.match(/[^0-9]/g)) {
                quantity = quantity.replace(/[^0-9]/g, '');
                input.val(quantity);
            }

            if (quantity < min) {
                input.val(min);
                return false;
            }

            if (quantity > max) {
                input.val(max);
                return false;
            }

            return true;
        }

        $('.quantity-input').on('change', function() {
            let input = $(this);
            let itemId = input.data('id');
            let quantity = input.val();
            if (!checkInput(input)) return;

            updateCartQuantity(itemId, quantity, input);
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
                        var row = $('#cart-item-' + itemId);

                        row.find('.total-price').text(response.data.total_price + '₫');
                        if (response.data.flash_sale_exceeded) {
                            toastr.warning(response.message);
                        }
                    } else {
                        toastr.warning(response.message);
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
                    toastr.error("Đã có lỗi xảy ra");
                    // Toast.fire({
                    //     icon: 'error',
                    //     title: "Có lỗi xảy ra!",
                    // })
                }
            });
        }

        $('.delete-item').on('click', function(e) {
            e.preventDefault();
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
                        if ($('.select-item').length === 0) {
                            location.reload();
                        }
                        if ($('.select-item').length > 0 && $('.select-item:checked').length === $('.select-item').length) {
                            $('#selectAll').prop('checked', true);
                        } else {
                            $('#selectAll').prop('checked', false);
                        }
                        calculateTotal();
                        updateCartCount();
                    } else {
                        toastr.warning(response.message);
                        // Toast.fire({
                        //     icon: 'error',
                        //     title: response.message,
                        // })
                    }
                },
                error: function() {
                    toastr.error("Đã có lỗi xảy ra");
                    // Toast.fire({
                    //     icon: 'error',
                    //     title: 'Xảy ra lỗi',
                    // })
                }
            });
        });



    });
</script>
<script src="{{ asset('theme/client/library/library.js') }}"></script>
@endsection