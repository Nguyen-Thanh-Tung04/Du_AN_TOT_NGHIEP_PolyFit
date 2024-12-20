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
            @foreach ($order->orderItems as $index => $item)
            <div class="item-row  align-items-center mb-3 order-history {{ $index >= 2 ? 'd-none' : 'd-flex' }}">
                <img src="{{ $item->image ?? '' }}" width="100px" class="rounded">
                <div class="item-details ms-3">
                    <div>{{ $item->name }}</div>
                    <div class="text-muted">Màu: {{ $item->color }}, Size: {{ $item->size }}</div>
                </div>
                <div class="ms-auto">
                    <span class="item-price">{{ number_format($item->price, 0, ',', '.') }} đ</span> x {{ $item->quantity }}
                </div>
            </div>
            @endforeach

            @if (count($order->orderItems) > 2)
            <div class="text-center mt-3">
                <span id="see-more-history" class="btn btn-link">
                    Xem thêm <i style="font-size: 12px;" class="fas fa-chevron-down"></i>
                </span>
            </div>
            @endif
        </div>

        <div class="order-footer d-flex justify-content-between align-items-center mt-3">
            <div class="total-amount">
                <strong>Tổng tiền: </strong>
                <strong class="text-danger">{{ number_format($order->orderItems->sum(function($item) {
                            return $item->price * $item->quantity;
                        }), 0, ',', '.') }} đ</strong>
            </div>

            <div class="order-actions">
                @php
                $hasVariant = $order->orderItems->contains(function($item) {
                return $item->variant == null;
                });
                if ($hasVariant && $order->status_name == 'Hoàn thành'){
                $classBtn = 'btn btn-secondary btn-sm open-view-review-modal';
                }elseif(!$hasVariant && $order->status_name == 'Hoàn thành' && $order->has_review){
                $classBtn = 'btn btn-secondary btn-sm open-view-review-modal';
                }elseif(!$hasVariant && $order->status_name == 'Hoàn thành' && !$order->has_review){
                $classBtn = 'btn btn-secondary btn-sm open-review-modal';
                }
                @endphp
                @if ($order->status_name == 'Hoàn thành')
                <button type="button" class="<?= $classBtn ?>"
                    data-order-id="{{ $order->id }}"
                    data-products="{{ json_encode($order->orderItems->map(function($item) {
                                        return [
                                            'id' => $item->id,
                                            'name' => $item->name,
                                            'image' => $item->image,
                                            'color' => $item->color,
                                            'size' => $item->size,
                                        ];
                                    })) }}">
                    @if ($hasVariant && $order->status_name == 'Hoàn thành')
                    Xem đánh giá
                    @elseif(!$hasVariant && $order->status_name == 'Hoàn thành' && $order->has_review)
                    Xem đánh giá
                    @elseif(!$hasVariant && $order->status_name == 'Hoàn thành' && !$order->has_review)
                    Viết đánh giá
                    @endif
                    {{-- @if ($order->status_name == 'Hoàn thành' && !$order->has_review)
                                        Viết đánh giá
                                        @elseif ($order->status_name == 'Hoàn thành' && $order->has_review)
                                        Xem đánh giá
                                        @endif
                                    @endif --}}
                </button>
                @endif
                <a href="{{ route('order.history.show', $order->id) }}" class="btn btn-primary text-white">Xem chi tiết</a>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>