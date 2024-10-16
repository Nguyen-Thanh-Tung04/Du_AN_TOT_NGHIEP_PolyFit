<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" value="" id="checkAll" class="input-checkbox">
                </th>
                <th class="text-center">Mã đơn hàng</th> <!-- Changed from product code -->
                <th class="text-center">Email</th>
                <th class="text-center">Nội dung</th>
                <th class="text-center">Số sao</th>
                <th class="text-center">Ngày đánh giá</th>
                <th class="text-center">Tình Trạng</th>
                <th class="text-center">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($reviews) && is_object($reviews))
             @php
             $lastOrderId = null; // Biến để theo dõi ID đơn hàng được hiển thị lần cuối
             @endphp
    @foreach($reviews as $review)
        @if ($review->order->id !== $lastOrderId)  <!-- Kiểm tra xem ID đơn hàng hiện tại có khác không -->
            <tr class="{{ stripos($review->content, 'đểu') !== false ? 'bg-danger text-white' : '' }}">
                <td>
                    <input type="checkbox" value="{{ $review->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td class="text-center">{{ $review->order->id }}</td> 
                <td class="text-center">{{ $review->email }}</td>
                <td class="text-center">{{ $review->content }}</td>
                <td class="text-center">{{ $review->score }}</td>
                <td class="text-center">{{ $review->created_at->format('Y-m-d') }}</td>
                <td class="text-center js-switch-{{ $review->id }}">
                    <input type="checkbox" value="{{ $review->status }}" 
                    class="js-switch status" 
                    data-field="status" 
                    data-model="Review"
                    data-modelId="{{ $review->id }}" 
                    {{ ($review->status == 1) ? 'checked' : '' }} />
                </td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-success me-2">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                       
                    </div>
                </td>
                
                
            </tr>
            @php $lastOrderId = $review->order->id; // Update lastOrderId to current one @endphp
        @endif
    @endforeach
@endif

        </tbody>
    </table>
</div>
