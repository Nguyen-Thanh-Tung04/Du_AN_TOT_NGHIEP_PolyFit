<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
            <tr>
                <th class="text-center">
                    STT
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
            @foreach($reviews as $key => $review)
            @if ($review->order->id !== $lastOrderId) <!-- Kiểm tra xem ID đơn hàng hiện tại có khác không -->
            <tr class="{{ stripos($review->content, 'deo') !== false ? 'bg-danger text-white' : '' }}">
                <td class="text-center">
                    {{ $key + 1}}
                </td>
                <td class="text-center">{{ $review->order->code }}</td>
                <td class="text-center">{{ $review->email }}</td>
                <td class="text-center">{{ Str::limit($review->content, 60, '...') }}</td>
                <td class="text-center">{{ $review->score }}</td>
                <td class="text-center">{{ $review->created_at->format('d-m-Y') }}</td>
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
                        @if(!$review->trashed()) <!-- Kiểm tra nếu bản ghi chưa bị xóa mềm -->
                        <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-success me-2">
                            <i class="fa fa-edit"></i>
                        </a>

                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="m-0" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @endif

                        <!-- Hiển thị nút "Xem lại" nếu bị xóa mềm -->
                        @if($review->trashed())
                        <a href="{{ route('reviews.history_detail', $review->id) }}" class="btn btn-warning">
                            <i class="fa fa-eye"></i>
                        </a>
                        @endif
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