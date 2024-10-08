<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" value="" id="checkAll" class="input-checkbox">
                </th>
                <th class="text-center">Mã sản phẩm</th>
                <th class="text-center">Email</th>
                <th class="text-center">Nội dung</th>
                {{-- <th class="text-center">Ảnh trải nghiệm</th> --}}
                <th class="text-center">Số sao</th>
                <th class="text-center">Ngày đánh giá</th>
                <th class="text-center">Tình Trạng</th>
                <th class="text-center">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($reviews) && is_object($reviews))
                @foreach($reviews as $reviews)
                @php
                         // Định nghĩa một danh sách các từ không lành mạnh (có thể mở rộng)
                         $unhealthyWords = ['đểu', 'vc', 'rách'];

                         // Kiểm tra xem nội dung có chứa từ không lành mạnh hay không
                         $isUnhealthy = false;
                         foreach ($unhealthyWords as $word) {
                             if (stripos($reviews->content, $word) !== false) {
                                 $isUnhealthy = true;
                                 break;
                             }
                         }
                        @endphp
                    <tr class=" {{ $isUnhealthy ? 'bg-danger text-white' : '' }}">
                        <td>
                            <input type="checkbox" value="{{ $reviews->id }}" class="input-checkbox checkBoxItem">
                        </td>
                        <td class="text-center">{{ $reviews->product_code }}</td>
                        <td class="text-center">{{ $reviews->email }}</td>
                        

                        <!-- Áp dụng class dựa trên $isUnhealthy -->
                        <td class="text-center">                       
                            {{ $reviews->content }}
                        </td>
                        {{-- <td class="text-center">
                            <img width="100px" src="{{ asset(Storage::url($reviews->image)) }}" alt="">
                        </td> --}}
                        <td class="text-center">{{ $reviews->score }}</td>
                        <td class="text-center">{{ $reviews->created_at->format('Y-m-d') }}</td>

                        <td class="text-center js-switch-{{ $reviews->id }}">
                            <input type="checkbox" value="{{ $reviews->status }}" 
                            class="js-switch status " 
                            data-field="status" 
                            data-model="Review"
                            data-modelId="{{ $reviews->id }}"
                            {{ ($reviews->status == 1) ? 'checked' : '' }} />
                        </td>   
                        <td class="text-center">
                            <a href="{{ route('reviews.edit', $reviews->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
    
                            <a href="{{ route('reviews.delete', $reviews->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{-- {{ $categories->links('pagination::bootstrap-5') }} --}}
</div>