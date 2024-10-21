@component('mail::message')
{{-- Logo --}}
<div style="text-align: center; margin-bottom: 20px;">
  <img src="{{asset('theme/client/assets/images/logo/logo1.png')}}" alt="Site Logo" />
</div>

# Thông tin đơn hàng!

Mã đơn hàng của bạn: **{{ $order->code }}**  
Tổng giá: **{{ number_format($order->total_price, 0, ',', '.') }} VNĐ**

---

### Thông tin người nhận:
@component('mail::panel')
- **Họ tên:** {{ $order->full_name }}  
- **Địa chỉ:** {{ $order->address }}, {{ $order->ward->name }}, {{ $order->district->name }}, {{ $order->province->name }}  
- **Điện thoại:** {{ $order->phone }}
@endcomponent

---

### Chi tiết đơn hàng:
@foreach($order->orderItems as $item)
@component('mail::table')
| Sản phẩm | Màu sắc | Kích thước | Số lượng | Giá |
|:--------:|:-------:|:----------:|:--------:|----:|
| {{ $item->variant->product->name }} | {{ $item->color }} | {{ $item->size }} | {{ $item->quantity }} | {{ number_format($item->price, 0, ',', '.') }} VNĐ |
@endcomponent
@endforeach

---

@component('mail::button', ['url' => route('order.history.show', $order->code)])
Xem chi tiết đơn hàng
@endcomponent

Cảm ơn bạn đã mua sản phẩm tại PolyFit!  
Chúc bạn một ngày tốt lành!

Trân trọng,  
{{ config('app.name') }}
@endcomponent
