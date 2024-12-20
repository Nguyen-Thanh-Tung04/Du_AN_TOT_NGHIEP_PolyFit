@extends('client.layouts.master')

@section('content')

<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Thủ tục thanh toán</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Thủ tục thanh toán</li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->

<section class="ec-page-content section-space-p checkout_page">
    <div class="container">

        <div class="row">
            <div class="ec-checkout-leftside col-lg-8 col-md-12 ">
                <!-- checkout content Start -->
                <div class="ec-checkout-content">

                    <div class="ec-checkout-inner">
                        <div class="ec-checkout-wrap margin-bottom-30 padding-bottom-3">
                            <div class="ec-checkout-block ec-check-bill">
                                <div class="d-flex justify-content-between">
                                    <h3 class="ec-checkout-title">Địa chỉ nhận hàng</h3>
                                    {{-- <a class="btn btn-secondary" style="" href="">Thêm địa chỉ mới</a> --}}
                                </div>
                                <div class="ec-bl-block-content">
                                    {{-- <div class="ec-check-subtitle">Tùy chọn</div>
                                    <span class="ec-bill-option">
                                        <span>
                                            <input type="radio" id="bill1" name="radio-group" checked>
                                            <label for="bill1">Tôi muốn sử dụng địa chỉ đã cài đặt</label>
                                        </span>
                                        <span>
                                            <input type="radio" id="bill2" name="radio-group">
                                            <label for="bill2">Tôi muốn địa chỉ mới</label>
                                        </span>
                                    </span> --}}
                                    <div class="ec-check-bill-form">
                                        <div class="form-flex">
                                            <form id="orderForm" action="{{ route('order.store') }}" method="POST">
                                                @csrf
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Họ và tên*</label>
                                                    <input type="text" id="fullName" name="full_name" value="{{ $user->name }}"
                                                        placeholder="" required />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Số điện thoại*</label>
                                                    <input type="text" id="phone" name="phone" value="{{ $user->phone }}"
                                                        placeholder="" required />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Tỉnh/Thành phố *</label>
                                                    <span class="ec-bl-select-inner">
                                                        <select name="province_id" id="provinceId" class="ec-bill-select province location" data-target="districts">
                                                            <option value="0">[Chọn Tỉnh/Thành Phố]</option>
                                                            @if (isset($provinces))
                                                            @foreach($provinces as $province)
                                                            <option value="{{ $province->code }}"
                                                                {{ old('province_id') == $province->code ? 'selected' : '' }}>
                                                                {{ $province->name }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </span>
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Quận/Huyện *</label>
                                                    <span class="ec-bl-select-inner">
                                                        <select name="district_id" id="districtId" class="ec-bill-select districts location" data-target="wards">
                                                            <option value="0">[Chọn Quận/Huyện]</option>
                                                        </select>
                                                    </span>
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Phường/Xã</label>
                                                    <span class="ec-bl-select-inner">
                                                        <select id="wardId" name="ward_id"
                                                            class="ec-bill-select wards">
                                                            <option value="0">[Chọn Phường/Xã]</option>
                                                        </select>
                                                    </span>
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Địa chỉ cụ thể</label>
                                                    <input type="text" id="address" name="address" value="{{ $user->address }}"
                                                        placeholder="" required />
                                                </span>
                                                <span class="ec-bill-wrap">
                                                    <label>Lưu ý khi giao hàng</label>
                                                    <textarea name="note" style="border: 1px solid #dee2e6" id="note" cols="20" rows="7" placeholder="Lưu ý"></textarea>
                                                </span>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <span class="ec-check-order-btn">
                            <button type="button" id="placeOrder" class="btn btn-primary">Đặt hàng</button>
                        </span>
                    </div>
                    </form>
                </div>
                <!--cart content End -->
            </div>
            <!-- Sidebar Area Start -->
            <div class="ec-checkout-rightside col-lg-4 col-md-12">
                <div class="ec-sidebar-wrap">
                    <!-- Sidebar Summary Block -->
                    <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Chi tiết</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <div class="ec-checkout-summary">
                                <div>
                                    <span class="text-left">Tổng tiền hàng</span>
                                    <span class="text-right" id="totalAmount">{{ number_format($total, 0, '', '.') }}đ</span>
                                </div>
                                <div>
                                    <span class="text-left">Giảm giá (Voucher)</span>
                                    <span class="text-right text-danger" id="discountAmount">- 0đ</span>
                                </div>
                                <div>
                                    <span class="text-left">Phí vận chuyển</span>
                                    <span class="text-right" id="shippingCost">20.000đ</span>
                                </div>
                                <div>
                                    <span class="text-left">Voucher</span>
                                    <span class="text-right"><a class="ec-checkout-coupan">Sử dụng Voucher</a></span>
                                </div>
                                <div class="ec-checkout-coupan-content">
                                    <form class="ec-checkout-coupan-form" name="ec-checkout-coupan-form"
                                        method="post" action="#">
                                        <input id="voucherCode" name="voucher_code" class="ec-coupan" type="text" required=""
                                            placeholder="Nhập Voucher" value="">
                                        <button class="ec-coupan-btn button btn-primary" type="button"
                                            name="subscribe" value="" id="applyVoucher">Ok</button>
                                        <button type="button" class="ec-coupan-btn button" id="removeVoucher">Hủy</button>
                                    </form>
                                    <div class="table-responsive">
                                        <div id="availableVouchers" class="mt-3">

                                            <ul id="voucherList" class="list-inline d-flex">
                                                <!-- Danh sách voucher sẽ được thêm ở đây bằng jQuery -->

                                            </ul>
                                            <span id="voucherDetail" class="" style="font-size: 12px;">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ec-checkout-summary-total">
                                    <span class="text-left">Tổng thanh toán</span>
                                    <span class="text-right" id="finalTotal">{{ number_format(($total + 20000), 0, '', '.') }}đ</span>
                                </div>
                            </div>
                            <div class="ec-checkout-pro">
                                @foreach ($productVariants as $item)
                                @php
                                $gallery = json_decode($item->product->gallery);
                                @endphp
                                <div class="col-sm-12 mb-6">
                                    <div class="ec-product-inner product-variant-item"
                                        data-product-variant-id="{{ $item->id }}"
                                        data-name="{{ $item->product->name }}"
                                        data-image="{{ (!empty($gallery)) ? $gallery[0] : '' }}"
                                        data-price="{{ $item->new_price != null ? $item->new_price : $item->normal_price }}"
                                        data-size="{{ $item->size->name }}"
                                        data-color="{{ $item->color->name }}"
                                        data-quantity="{{ $quantities[$item->id] }}">

                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="" class="image">
                                                    <img class="main-image"
                                                        src="{{ (!empty($gallery)) ? $gallery[0] : '' }}"
                                                        alt="Product" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">{{ $item->product->name }}</a></h5>
                                            {{-- <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div> --}}
                                            <span class="ec-price">
                                                @if ($item->new_price)
                                                <span id="listedPrice" class="old-price">{{ number_format($item->normal_price, 0, '', '.') }}đ </span>
                                                <span class="new-price">{{ number_format($item->new_price, 0, '', '.') }}đ</span>
                                                @else
                                                <span class="new-price">{{ number_format($item->normal_price, 0, '', '.') }}đ </span>
                                                @endif
                                            </span>

                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    Phân loại: {{ $item->size->name }}, {{ $item->color->name }}
                                                </div>
                                            </div>
                                            <div>
                                                <span>Số lượng: {{ $quantities[$item->id] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar Summary Block -->
                </div>
                {{-- <div class="ec-sidebar-wrap ec-checkout-del-wrap">
                    <!-- Sidebar Summary Block -->
                    <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Hình thức vận chuyển</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <div class="ec-checkout-del">
                                <span class="ec-del-option shipping-methods">
                                    <span>
                                        <span class="ec-del-opt-head">Giao hàng tiết kiệm</span>
                                        <input type="radio" id="del1" name="shipping_method" value="20000" checked>
                                        <label for="del1">20.000đ</label>
                                    </span>
                                </span>
                                <span class="ec-del-commemt">
                                    <span class="ec-del-opt-head">Lưu ý khi giao hàng</span>
                                    <textarea name="your-commemt" id="note" placeholder="Lưu ý"></textarea>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar Summary Block -->
                </div> --}}
                <div class="ec-sidebar-wrap ec-checkout-pay-wrap">
                    <!-- Sidebar Payment Block -->
                    <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Phương thức thanh toán</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <div class="ec-checkout-pay">
                                <div class="form-flex">
                                    <span class="">
                                        <div style="margin-bottom:10px">
                                            <input type="radio" id="pay1" name="payment_method" value="1" checked>
                                            <label for="pay1">Thanh toán COD</label>
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <input type="radio" id="pay2" name="payment_method" value="2">
                                            <label for="pay2">Thanh toán bằng VnPay</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="pay3" name="payment_method" value="3">
                                            <label for="pay3">Thanh toán bằng Momo</label>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar Payment Block -->
                </div>

            </div>
        </div>
    </div>
</section>
<script>
    var province_id = "{{ (isset($user->province_id)) ? $user->province_id : old('province_id') }}"
    var district_id = "{{ (isset($user->district_id)) ? $user->district_id : old('district_id') }}"
    var ward_id = "{{ (isset($user->ward_id)) ? $user->ward_id : old('ward_id') }}"

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('orderForm');
        const submitButton = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function(event) {
            // Vô hiệu hóa nút submit
            submitButton.disabled = true;
        });
    });
</script>
<script src="{{ asset('admin/library/location.js') }}"></script>
<script>
    (function($) {
        "use strict";

        $(document).ready(function() {

            let voucherCode = "";
            $('#applyVoucher').click(function() {
                voucherCode = $('#voucherCode').val();
            });
            $('#removeVoucher').click(function() {
                $('#voucherCode').val('');
                voucherCode = null;
            });

            $('#placeOrder').click(function(e) {
                e.preventDefault(); // Ngăn chặn form submit mặc định

                // Hiển thị thông báo xác nhận
                Swal.fire({
                    title: 'Bạn chắc chắn muốn đặt hàng?',
                    text: "Nếu bạn hủy đơn hàng này, chúng tôi sẽ không thể hoàn tiền vào ví của bạn. Bạn có thể liên hệ với chúng tôi để được hỗ trợ hoàn tiền.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy bỏ',
                }).then((result) => {
                    if (result.isConfirmed) {
                        let productVariants = [];
                        $('.product-variant-item').each(function() {
                            let productVariantId = $(this).data('product-variant-id');
                            let name = $(this).data('name');
                            let image = $(this).data('image');
                            let price = $(this).data('price');
                            let color = $(this).data('color');
                            let size = $(this).data('size');
                            let quantity = $(this).data('quantity');

                            productVariants.push({
                                product_variant_id: productVariantId,
                                name: name,
                                image: image,
                                price: price,
                                color: color,
                                size: size,
                                quantity: quantity,
                            });
                        });

                        let fullName = $('#fullName').val();
                        let note = $('#note').val();
                        let paymentMethod = $('input[name="payment_method"]:checked').val();
                        let phone = $('#phone').val();
                        let provinceId = $('#provinceId').val();
                        let districtId = $('#districtId').val();
                        let wardId = $('#wardId').val();
                        let address = $('#address').val();
                        let discountAmount = $('#discountAmount').text().replace(/^\s*-\s*/, '').replace(/đ/, '').replace(/\./g, '').trim();
                        let shippingCost = $('#shippingCost').text().replace(/đ/, '').replace(/\./g, '').trim();
                        let totalAmount = $('#totalAmount').text().replace(/đ/, '').replace(/\./g, '').trim();
                        let finalTotal = $('#finalTotal').text().replace(/đ/, '').replace(/\./g, '').trim();

                        if (paymentMethod == '1') {
                            sendAjaxRequest('{{ route("order.store") }}', 'POST', function(response) {
                                // Success callback
                                toastr.success(response.message);

                                // Thay đổi lịch sử trình duyệt để khi người dùng nhấn nút Back, họ sẽ về trang giỏ hàng
                                history.replaceState(null, null, '{{ route("cart.index") }}');

                                window.location.href = '{{ url("order") }}/' + response.order_id;
                            }, function(response) {
                                // Error callback (nếu cần thêm xử lý lỗi khác)
                                console.error('Đặt hàng không thành công:', response.message);
                            });
                        } else if (paymentMethod == '2') {
                            //lưu trạng thái hiện tại trước khi chuyển hướng
                            window.history.pushState({
                                page: 'checkout'
                            }, 'Checkout', '/checkout');
                            sendAjaxRequest('{{ route("vnpay.payment") }}', 'POST', function(response) {
                                // Khi thành công, chuyển hướng người dùng đến URL VNPAY
                                if (response.code == '00') {
                                    window.location.href = response.vnpay_url;
                                    // Xử lý sự kiện khi nhấn nút back (trở về)
                                    window.onpopstate = function(event) {
                                        if (event.state && event.state.page === 'checkout') {
                                            // Trả về trang checkout khi người dùng nhấn back
                                            window.location.href = '/checkout'; // Điều hướng về trang checkout
                                        }
                                    };
                                } else {
                                    toastr.error(response.message || 'Có lỗi xảy ra trong quá trình thanh toán.');
                                }
                            }, function(response) {
                                // Xử lý lỗi
                                console.error('Thanh toán không thành công:', response.message);
                            });
                        } else if (paymentMethod == '3') {
                            // Thanh toán qua MoMo
                            sendAjaxRequest('{{ route("momo.payment") }}', 'POST', function(response) {
                                // Khi thành công, chuyển hướng người dùng đến URL MoMo
                                if (response.success) {
                                    window.location.href = response.momo_url;
                                } else {
                                    toastr.error(response.message || 'Có lỗi xảy ra trong quá trình thanh toán.');
                                }
                            }, function(response) {
                                console.error('Thanh toán không thành công:', response.message);
                            });
                        }

                        function sendAjaxRequest(url, method, successCallback, errorCallback) {
                            $.ajax({
                                url: url,
                                type: method,
                                data: {
                                    _token: '{{ csrf_token() }}', // CSRF token
                                    shipping_cost: shippingCost,
                                    final_total: finalTotal,
                                    full_name: fullName,
                                    phone: phone,
                                    province_id: provinceId,
                                    district_id: districtId,
                                    ward_id: wardId,
                                    address: address,
                                    note: note,
                                    total_amount: totalAmount,
                                    discount_amount: discountAmount,
                                    voucher_code: voucherCode,
                                    product_variants: productVariants,
                                    payment_method: paymentMethod,
                                },
                                success: function(response) {
                                    if (response.success) {
                                        successCallback(response);
                                    } else {
                                        toastr.error(response.message || 'Có lỗi xảy ra khi đặt hàng.');
                                        if (errorCallback) {
                                            errorCallback(response);
                                        }
                                    }
                                },
                                error: function(xhr, status, error) {
                                    if (xhr.status === 400) { // Kiểm tra mã lỗi 400
                                        let message = xhr.responseJSON.message;
                                        toastr.error(message || 'Có lỗi xảy ra khi đặt hàng.');
                                    } else if (xhr.status === 422) { // Kiểm tra mã lỗi 500
                                        let errors = xhr.responseJSON.errors;
                                        for (let field in errors) {
                                            if (errors.hasOwnProperty(field)) {
                                                toastr.error(errors[field][0]); // Hiển thị lỗi đầu tiên cho mỗi trường
                                            }
                                        }
                                    } else {
                                        toastr.error('Có lỗi xảy ra: ' + error);
                                    }
                                    if (errorCallback) {
                                        errorCallback(xhr, status, error);
                                    }
                                }
                            });
                        }
                        console.log('Người dùng đã đồng ý. Tiếp tục thực hiện hành động.');

                        // Thực hiện các code tiếp theo
                    } else {
                        // Người dùng đã hủy bỏ hành động
                        console.log('Người dùng đã hủy bỏ hành động.');
                    }
                });




            });
        });


        function formatCurrency(number) {
            return 'đ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        $(document).ready(function() {
            let totalAmount = "{{ $total }}"; // Tổng tiền hàng từ server
            let discountAmount = 0;

            // Tính toán tổng cộng khi chọn hình thức vận chuyển
            $('input[name="shipping_method"]').change(function() {
                let shippingCost = parseInt($(this).val());

                // Giữ nguyên giá trị giảm giá, không lấy lại từ HTML vì có thể bị sai
                let finalTotal = Number(totalAmount) + Number(shippingCost) - Number(discountAmount);

                // Cập nhật lại các giá trị hiển thị
                $('#shippingCost').text(formatCurrency(shippingCost));
                $('#finalTotal').text(formatCurrency(finalTotal));
            });

            // Áp dụng mã voucher khi nhấn nút OK
            $('#applyVoucher').click(function() {
                let voucherCode = $('#voucherCode').val();

                $.ajax({
                    url: '{{ route("checkout.applyVoucher") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        voucher_code: voucherCode,
                        total_amount: totalAmount,
                    },
                    success: function(response) {
                        if (response.success) {
                            // Cập nhật giá trị giảm giá dựa trên mã voucher
                            discountAmount = Number(response.discount);

                            // Cập nhật lại giá trị hiển thị cho giảm giá
                            $('#discountAmount').text('-' + formatCurrency(discountAmount));

                            // Lấy lại phí vận chuyển hiện tại
                            //let shippingCost = parseInt($('input[name="shipping_method"]:checked').val()) || 0;

                            // Tính toán tổng tiền thanh toán mới (sử dụng giá trị trả về từ server)
                            let finalTotal = Number(response.final_total) + Number(20000); // Dùng final_total từ server
                            // Cập nhật lại giá trị hiển thị
                            $('#finalTotal').text(formatCurrency(finalTotal));
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Có lỗi xảy ra không thể áp dụng voucher.');
                    }
                });
            });

            $('#removeVoucher').click(function() {
                // Đặt lại giá trị giảm giá về 0
                discountAmount = 0;

                // Xóa mã voucher trong input
                $('#voucherCode').val('');

                // Cập nhật lại giảm giá và tổng tiền về ban đầu
                $('#discountAmount').text('0đ');

                // Lấy lại phí vận chuyển hiện tại
                console.log($('input[name="shipping_method"]:checked').val())
                let shippingCost = parseInt($('input[name="shipping_method"]:checked').val());

                // Tính toán lại tổng tiền
                let finalTotal = Number(totalAmount) + 20000;
                console.log('a', Number(totalAmount));
                console.log('a1', shippingCost);
                // Cập nhật lại giá trị hiển thị
                $('#finalTotal').text(formatCurrency(finalTotal));
                $('#voucherDetail').hide();
            });
        });


        $(document).ready(function() {
            // Xử lý sự kiện click vào các voucher
            $('#voucherList').on('click', '.voucher-item', function() {
                // Lấy mã voucher từ thuộc tính data-code
                var voucherCode = $(this).html();
                // Đổ mã voucher vào ô input
                $('#voucherCode').val(voucherCode);
            });
        });


        $(document).ready(function() {
            // Lấy danh sách voucher hợp lệ khi trang load
            $.ajax({
                url: '{{ route("checkout.availableVouchers") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        let vouchers = response.vouchers;
                        // Xóa các voucher cũ
                        $('#voucherList').empty();

                        // Hiển thị các voucher hợp lệ
                        vouchers.forEach(function(voucher) {
                            let discount_value = '';
                            let min_value = '';
                            let max_value = '';
                            if (voucher.discount_type == 'percentage') {
                                let valueAsNumber = parseFloat(voucher.max_discount_value);
                                let formattedValue = valueAsNumber.toLocaleString('vi-VN');
                                discount_value = `Giảm ${Number(voucher.value)}% Giảm tối đa đ${formattedValue}`;
                                let replaceMin = voucher.min_order_value.replace('.00', '');
                                min_value = 'đ' + parseFloat(replaceMin.replace(/\./g, '')).toLocaleString('vi-VN', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                                let replaceMax = voucher.max_order_value.replace('.00', '');
                                max_value = 'đ' + parseFloat(replaceMax.replace(/\./g, '')).toLocaleString('vi-VN', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                            } else {
                                let valueAsNumber = parseFloat(voucher.value);
                                let formattedValue = valueAsNumber.toLocaleString('vi-VN');
                                discount_value = `Giảm đ${formattedValue}`;
                                let replaceMin = voucher.min_order_value.replace('.00', '');
                                min_value = 'đ' + parseFloat(replaceMin.replace(/\./g, '')).toLocaleString('vi-VN', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                                let replaceMax = voucher.max_order_value.replace('.00', '');
                                max_value = 'đ' + parseFloat(replaceMax.replace(/\./g, '')).toLocaleString('vi-VN', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                            }
                            // Thêm mã voucher và thời gian hết hạn vào thuộc tính data
                            $('#voucherList').append(
                                `<li class="voucher-item" data-discount-value="${discount_value}" data-end-time="${voucher.end_time}" data-min-value="${min_value}" data-max-value="${max_value}">${voucher.code}</li>`
                            );
                        });

                        // Lắng nghe sự kiện di chuột trên từng voucher
                        $('.voucher-item').click(function() {
                            let endTime = $(this).data('end-time');
                            let discountValue = $(this).data('discount-value');
                            let minValue = $(this).data('min-value');
                            let maxValue = $(this).data('max-value');
                            let now = new Date();
                            let endDate = new Date(endTime);

                            let remainingTime = endDate - now;

                            if (remainingTime > 0) {
                                let daysLeft = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                                let hoursLeft = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

                                // Tạo thông báo
                                let message = `${daysLeft} ngày/ ${hoursLeft} giờ`;
                                $('#voucherDetail').html(`<div class="voucher">
                                    <div class="voucher-left">
                                        <span class="voucher-badge">Ưu đãi</span>
                                        <img src="https://down-vn.img.susercontent.com/file/vn-11134004-7r98o-lw5hktdso8uxb1" alt="Voucher Icon" class="voucher-icon">
                                    </div>
                                    <div class="voucher-right">
                                        <h3 class="voucher-title">${discountValue}</h3>
                                        <p class="voucher-subtitle">Đơn Tối Thiểu ${minValue}</p>
                                        <p class="voucher-details">Đơn tối đa ${maxValue}</p>
                                        <div class="voucher-footer">
                                            <span class="voucher-expiry">Hạn sử dụng: Còn ${message}</span>
                                        </div>
                                    </div>
                                </div>`).show();
                            } else {
                                // $('#voucherMessage').text('Voucher đã hết hạn.').show();
                                // $('#voucherDetail').html(`<span class="color-default">${discountType}</span>`).show();
                            }
                        })
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra khi lấy danh sách voucher.');
                }
            });
        });
    })(jQuery);
</script>

@endsection