<div class="order-history mt-4">
    @if ($orders->isEmpty())
        <div class="empty-order text-center">
            <img src="{{ asset('theme/client/assets/images/icons/nothing.png') }}" alt="" class="img-fluid" width="80px" />
            <p class="mt-3">Bạn chưa có đơn hàng nào</p>
        </div>
    @else
        @foreach($orders as $order)
            <div class="order-card mb-4 border rounded p-3">
                <div class="order-header d-flex justify-content-between align-items-center">
                    <div>
                        <span class="order-code">Mã đơn hàng: <strong>{{ $order->code }}</strong></span><br />
                        <span class="order-date text-muted">Ngày đặt: {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</span>
                    </div>
                    <div class="order-status">
                        <span class="badge 
                            @if($order->status_name == 'Hoàn thành') badge-success
                            @else badge-info @endif
                        ">
                            {{ $order->status_name }}
                        </span>
                    </div>
                </div>
                <hr />

                <div class="order-items">
                    @foreach ($order->orderItems as $item)
                    @php
                        $gallery = json_decode($item->product->gallery);
                    @endphp
                        <div class="item-row d-flex align-items-center mb-3">
                            <img src="{{ (!empty($gallery)) ? $gallery[0] : '' }}" width="100px" class="rounded">
                            <div class="item-details ms-3">
                                <div>{{ $item->variant->product->name }}</div>
                                <div class="text-muted">Màu: {{ $item->color }}, Size: {{ $item->size }}</div>
                            </div>
                            <div class="ms-auto">
                                <span class="item-price">{{ number_format($item->price, 0, ',', '.') }} đ</span> x {{ $item->quantity }}
                            </div>
                        </div>

                        <!-- Đường ngăn cách -->
                        @if (!$loop->last) <!-- Không thêm đường ngăn cách ở sản phẩm cuối cùng -->
                            <hr class="product-separator" />
                        @endif
                    @endforeach
                </div>

                <div class="order-footer d-flex justify-content-between align-items-center mt-3">
                    <div class="total-amount">
                        Tổng tiền: <strong class="text-danger">{{ number_format($order->orderItems->sum(function($item) {
                            return $item->price * $item->quantity;
                        }), 0, ',', '.') }} đ</strong>
                    </div>
                    <div class="order-actions">
                        <a href="{{ route('order.history.show', $order->id) }}" class="text-danger">Xem chi tiết</a>
                        @if($order->status_name == 'Hoàn thành' && !$order->has_review)
                            <button type="button" class="btn btn-primary btn-sm open-review-modal"
                                data-order-id="{{ $order->id }}" 
                                data-products="{{ json_encode($order->orderItems->map(function($item) {
                                    return [
                                        'id' => $item->variant->product->id,
                                        'name' => $item->variant->product->name,
                                        'image' => $item->image,
                                        'color' => $item->color,
                                        'size' => $item->size,
                                    ];
                                })) }}">

                                Viết đánh giá
                            </button>
                        @elseif($order->status_name == 'Hoàn thành' && $order->has_review)
                            <button type="button" class="btn btn-secondary btn-sm open-view-review-modal"
                                data-order-id="{{ $order->id }}">
                                Xem đánh giá
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
