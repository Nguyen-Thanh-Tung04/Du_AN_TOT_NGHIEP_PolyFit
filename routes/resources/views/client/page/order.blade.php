@extends('client.layouts.master')

@section('content')
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Theo dõi đơn hàng</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="ec-breadcrumb-item active">Theo dõi đơn hàng</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <section class="section section-xl bg-default text-md-left">
        <div class="container">
            <div
                style="background-image: repeating-linear-gradient(45deg, #6fa6d6, #6fa6d6 33px, transparent 0, transparent 41px, #f18d9b 0, #f18d9b 74px, transparent 0, transparent 82px); background-position-x: -1.875rem; background-size: 7.25rem .1875rem; height: .1875rem; width: 100%;">
            </div>
            <div class="ec-trackorder-inner mb-50">
                <div class="ec-trackorder-top">
                    <h2 class="ec-order-id">Mã Đơn Hàng {{ $order->code }}</h2>
                    <div class="ec-order-detail">
                        @if ($order->status === \App\Models\Order::STATUS_HUY_DON_HANG)
                            <div class="alert alert-danger">
                                Đơn hàng đã bị hủy.
                            </div>
                       
                        @endif
                    </div>
                </div>

                @if ($order->status !== \App\Models\Order::STATUS_HUY_DON_HANG)
                <div class="ec-trackorder-bottom">
                    <div class="ec-progress-track">
                        <ul id="ec-progressbar">
                            <li class="step0 {{ $order->status >= 1 ? 'active' : '' }}">
                                <span class="ec-track-icon">
                                    <img src="{{ asset('theme/client/assetss/images/icons/track_1.png') }}" alt="track_order">
                                </span>
                                <span class="ec-progressbar-track"></span>
                                <span class="ec-track-title">Chờ xác nhận</span>
                            </li>
                            <li class="step0 {{ $order->status >= 2 ? 'active' : '' }}">
                                <span class="ec-track-icon">
                                    <img src="{{ asset('theme/client/assetss/images/icons/track_2.png') }}" alt="track_order">
                                </span>
                                <span class="ec-progressbar-track"></span>
                                <span class="ec-track-title">Đã xác nhận</span>
                            </li>
                            <li class="step0 {{ $order->status >= 3 ? 'active' : '' }}">
                                <span class="ec-track-icon">
                                    <img src="{{ asset('theme/client/assetss/images/icons/track_3.png') }}" alt="track_order">
                                </span>
                                <span class="ec-progressbar-track"></span>
                                <span class="ec-track-title">Đang chuẩn bị</span>
                            </li>
                            <li class="step0 {{ $order->status >= 4 ? 'active' : '' }}">
                                <span class="ec-track-icon">
                                    <img src="{{ asset('theme/client/assetss/images/icons/track_4.png') }}" alt="track_order">
                                </span>
                                <span class="ec-progressbar-track"></span>
                                <span class="ec-track-title">Đang vận chuyển <br></span>
                            </li>
                            <li class="step0 {{ $order->status >= 5 ? 'active' : '' }}">
                                <span class="ec-track-icon">
                                    <img src="{{ asset('theme/client/assetss/images/icons/track_5.png') }}" alt="track_order">
                                </span>
                                <span class="ec-progressbar-track"></span>
                                <span class="ec-track-title">Giao hàng thành công</span>
                            </li>
                            <li class="step0 {{ $order->status >= 6 ? 'active' : '' }}">
                                <span class="ec-track-icon">
                                    <img src="{{ asset('theme/client/assetss/images/icons/track06.png') }}"  alt="track_order">
                                </span>
                                <span class="ec-progressbar-track"></span>
                                <span class="ec-track-title">Hoàn thành</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="text-right mt-5">
                    <form id="cancelOrderForm" action="{{ route('order.history.update', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        @if ($order->status === \App\Models\Order::STATUS_CHO_XAC_NHAN)
                            <input type="hidden" name="huy_don_hang" value="1">
                            <button type="button" id="cancelOrderButton" class="custom-btn danger-btn">
                                <i class="fas fa-times-circle"></i> Hủy đơn hàng
                            </button>
                            @elseif ($order->status === \App\Models\Order::STATUS_GIAO_HANG_THANH_CONG)
                            <input type="hidden" name="giao_hang_thanh_cong" value="1">
                            <button type="button" id="confirmReceivedButton" class="custom-btn success-btn">
                                <i class="fas fa-check-circle"></i> Đã nhận hàng
                            </button>
                        @endif
                    </form>
                </div>
                
                
                
                
                @endif
            </div>

            <!-- Canceled Order Section -->
            @if ($order->status === \App\Models\Order::STATUS_HUY_DON_HANG)
            <div class="alert alert-warning mt-4">
                Đơn hàng này đã bị hủy. Nếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ với dịch vụ khách hàng.
            </div>
            @endif
                @php
                $totalPrice = 0;
                @endphp
            @foreach ($order->orderItems as $orderItem)
            @php
            $totalPrice += $orderItem->price * $orderItem->quantity;
            @endphp
            <div class="ec-trackorder-inner">
                <div class="row align-items-center p-3">
                    <div class="col-1">
                        <img src="{{ $orderItem->image ?? '' }}">
                    </div>
                    <div class="col-8">
                        <h6>{{ $orderItem->name }}</h6>
                        <div class="text-muted">Phân loại hàng: <span>{{ $orderItem->color }}, {{ $orderItem->size }}</span></div>
                        <div class="text-muted">x{{ $orderItem->quantity }}</div>
                    </div>
                    <div class="col-3 text-right">
                        <span class="fs-6 fw-bold">{{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}đ</span>
                    </div>                    
                </div>
                </a>
            </div>
            @endforeach

    
            <div class="row">
                
                <div class="col-12">
                    <form class="sc-shipping-address" id="form-order" role="form" method="POST"
                        action="https://demo.s-cart.org/order-add">
                        <input type="hidden" name="_token" value="iVEYxp5y3lPVUVDFyMO3aJvIsN7llsz8GfbGpEy7">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 mt-3">
                                <h3 class="control-label"><i class="fa fa-truck" aria-hidden="true"></i>
                                    Địa chỉ giao hàng:<br></h3>
                                <table class="table box table-bordered" id="showTotal">
                                    <tr>
                                        <th>Tên:</td>
                                        <td>{{ $order->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Điện thoại:</td>
                                        <td>{{ $order->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Địa chỉ:</td>
                                        <td>{{ $order->address }}, {{ optional($order->ward)->name }},
                                            {{ optional($order->district)->name }},{{ optional($order->province)->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ghi chú:</td>
                                        <td>{{ $order->note }}</td>
                                    </tr>
                                </table>
                               
                            </div>
                            <div class="col-12 col-sm-12 col-md-6">
                                <h3 class="control-label"><br></h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table box table-bordered" id="showTotal">
                                            <tr class="showTotal">
                                                <th>Phương thức thanh toán :</th>
                                                <td style="text-align: right" id="subtotal">
                                                    <div>
                                                        @if ($order->payment_method == 1)
                                                            Thanh toán COD
                                                        @elseif ($order->payment_method == 2)
                                                            Thanh toán VnPay
                                                        @elseif ($order->payment_method == 3)
                                                            Thanh toán MoMo
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="showTotal">
                                                <th>Tổng tiền hàng</th>
                                                <td style="text-align: right" id="subtotal">
                                                    {{ number_format($totalPrice, 0, ',', '.') }}₫
                                                </td>
                                            </tr>
                                            <tr class="showTotal">
                                                <th>Phí vận chuyển</th>
                                                <td style="text-align: right" id="subtotal">
                                                    {{ number_format($order->shipping_cost, 0, ',', '.') }}₫
                                                </td>
                                            </tr>
                                            <tr class="showTotal">
                                                <th>Voucher giảm giá</th>
                                                <td style="text-align: right" id="tax">
                                                    -{{ number_format($order->discount_amount, 0, ',', '.') }}₫
                                                </td>
                                            </tr>
                                            <tr class="showTotal" style="background:#f5f3f3;font-weight: bold;">
                                                <th>Tổng tiền</th>
                                                <td style="text-align: right" id="total" class="text-danger fw-bold">
                                                    {{ number_format($order->total_price, 0, ',', '.') }}₫
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-12 mr-a">
                    <button onClick="location.href='{{ route('cart.index') ?? url('/history') }}'" class="btn btn-primary btn-lg" type="button">
                        <i class="fa fa-arrow-left"></i> Trở lại giỏ hàng
                    </button>
                </div>
            </div>
        </div>
        <!-- Track Order Content end -->
    </div>
</section>
@section('scripts')
<script>
     document.getElementById('cancelOrderButton').addEventListener('click', function() {
        Swal.fire({
            title: 'Lý do hủy đơn hàng',
            input: 'select',
            inputOptions: {
                'Thay đổi địa chỉ giao hàng': 'Muốn thay đổi địa chỉ giao hàng',
                'Thay đổi mã voucher': 'Muốn nhập/thay đổi mã Voucher',
                'Thay đổi sản phẩm': 'Muốn thay đổi sản phẩm trong đơn hàng (size, màu sắc, số lượng...)',
                'Thanh toán rắc rối': 'Thủ tục thanh toán quá rắc rối',
                'Tìm giá rẻ hơn': 'Tìm thấy giá rẻ hơn ở chỗ khác',
                'Không muốn mua nữa': 'Đổi ý, không muốn mua nữa'
            },
            inputPlaceholder: 'Chọn lý do...',
            showCancelButton: true,
            confirmButtonText: 'Gửi',
            cancelButtonText: 'Hủy',
            preConfirm: (selectedReason) => {
                if (!selectedReason) {
                    Swal.showValidationMessage('Vui lòng chọn lý do');
                } else {
                    // Gửi lý do hủy vào form
                    const form = document.getElementById('cancelOrderForm');
                    const reasonInput = document.createElement('input');
                    reasonInput.type = 'hidden';
                    reasonInput.name = 'cancel_reason';
                    reasonInput.value = selectedReason;
                    form.appendChild(reasonInput);
                    form.submit();
                }
            }
        });
    });
</script>
<script>
      document.getElementById('confirmReceivedButton').addEventListener('click', function () {
        Swal.fire({
            title: 'Xác nhận nhận hàng',
            text: "Bạn có chắc chắn đã nhận hàng?",
            icon: 'question',  // Icon hỏi
            showCancelButton: true,
            confirmButtonText: 'Có',
            cancelButtonText: 'Không',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Hiển thị thông báo thành công với dấu kiểm (chữ "V")
                Swal.fire({
                    icon: 'success',  // Dấu kiểm (V)
                    title: 'Đã nhận hàng!',
                    text: 'Cảm ơn bạn đã xác nhận.',
                    confirmButtonText: 'Đóng'
                }).then(() => {
                    document.getElementById('cancelOrderForm').submit();  // Submit form sau khi xác nhận
                });
            }
        });
    });
</script>



@endsection
@endsection
