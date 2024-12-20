<div class="ec-t-review-wrapper" id="reviewList">
    @if($reviews->count() > 0)
    @foreach($reviews as $rv)
    <div class="ec-t-review-item">
        <div class="ec-t-review-avtar">
            @if($rv->user && $rv->user->image)
            @php
                $checkUrlImg = \Illuminate\Support\Str::contains($rv->user->image, '/userfiles/') 
                    ? $rv->user->image 
                    : ($rv->user->image ? Storage::url($rv->user->image) : null);
            @endphp

            @if ($checkUrlImg)
                <!-- Nếu user có ảnh đại diện -->
                <img 
                    src="{{ $checkUrlImg }}" 
                    alt="User Avatar" 
                    class="img-profile rounded-circle border shadow"
                    style="height: 70px; width: 70px; object-fit: cover;" />
            @else
                <!-- Nếu user không có ảnh đại diện -->
                <img 
                    src="{{ asset('userfiles/thumb/Images/avata_null.jpg') }}" 
                    alt="Default Avatar" 
                    class="img-profile rounded-circle border shadow"
                    style="height: 70px; width: 70px; object-fit: cover;" />
            @endif
        @else
            <!-- Nếu không có user -->
            <img 
                src="{{ asset('userfiles/thumb/Images/avata_null.jpg') }}" 
                alt="Default Avatar" 
                class="img-profile rounded-circle border shadow"
                style="height: 70px; width: 70px; object-fit: cover;" />
        @endif


        </div>
        <div class="ec-t-review-content">
            <div class="ec-t-review-top">
                <div class="ec-t-review-name">{{ $rv->user->name ?? 'Khách hàng' }}</div>
                {{-- <div class="text-5 small">Phân loại :
                     {{ $rv->order->orderItems->color }}  
                    / {{ $rv->order->orderItems->size }}  
                </div> --}}
                <div class="ec-t-review-rating">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <=$rv->score)
                        <i class="ecicon eci-star text-warning"></i>
                        @else
                        <i class="ecicon eci-star-o"></i>
                        @endif
                        @endfor
                </div>
            </div>
            <div class="ec-t-review-bottom">
                <p>{{ $rv->content }}</p>
            </div>
            @if($rv->image)
            <img src="{{ asset(Storage::url($rv->image)) }}" style="height:90px; width:90px" alt="Review Image" />
            @endif
            <div class="ec-t-review-bottom">
                <p>{{ $rv->created_at->format('Y-m-d') }}</p>
            </div>
            {{-- Trả lời đánh giá  --}}
            @foreach($rv->replies as $reply)
            <div class="ec-t-review-item mt-2">
                <div class="ec-t-review-avtar">
                    <img src="{{ asset('theme/client/assets/images/logo/logo1.png') }}" class="rounded-circle border" style="width: 69px; height: 70px;" alt="" />
                </div>
                <div class="ec-t-review-content border bg-light p-3" style="width:45rem">
                    <div class="ec-t-review-top">
                        <div class="ec-t-review-name">PolyFit </div>
                        <div class="ec-t-review-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <=$rv->score)
                                <i class="ecicon eci-star text-warning"></i>
                                @else
                                <i class="ecicon eci-star-o"></i>
                                @endif
                                @endfor
                        </div>
                    </div>
                    <div class="ec-t-review-bottom">
                        <p> {{ $reply->content }}</p>
                    </div>
                    <div class="ec-t-review-bottom">
                        <p>{{ $reply->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
    <!-- Hiển thị phân trang -->
    {{-- <div class="mt-4">
        {{ $reviews->links('pagination::bootstrap-4') }}
    </div> --}}
    @else
    <p>Chưa có đánh giá nào cho sản phẩm này.</p>
    @endif
</div>