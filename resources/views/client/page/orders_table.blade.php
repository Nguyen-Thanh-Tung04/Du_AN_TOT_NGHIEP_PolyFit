<table class="table ec-table mt-4">
    <thead>
        <tr>
            <th scope="col">Mã Đơn hàng</th>
            <th scope="col">Khách hàng</th>
            <th scope="col">Ngày đặt</th>
            <th scope="col">Tổng tiền</th>
            <th scope="col">Trạng thái</th>
            <th scope="col">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @if ($orders->isEmpty())
        <tr>
            <td colspan="6" class="text-center">
                <div class="empty-order">
                    <img src="{{ asset('theme/client/assets/images/icons/nothing.png') }}" alt="" class="img-fluid" width="80px"/>
                    <p class="mt-2">Chưa có đơn hàng nào</p>
                </div>
            </td>
        </tr>
        @else
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</td>
                    <td>{{ number_format($order->orderItems->sum(function($item) {
                        return $item->price * $item->quantity;
                    }), 0, ',', '.') }} VND</td>
                    <td>{{ $order->status_name }}</td>
                    <td>
                        <a href="{{ route('order.history.show', $order->id) }}" class="btn btn-info text-white">Xem</a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
