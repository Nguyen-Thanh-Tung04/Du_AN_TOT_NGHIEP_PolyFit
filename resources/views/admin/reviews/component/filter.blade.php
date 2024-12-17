<form action="{{ route('reviews.index') }}">
    <div class="filter-wraper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            {{-- @php
                $perpage = request('perpage') ?: old('perpage');
            @endphp
            <div class="perpage">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <select name="perpage" class="form-control input-control input-sm perpage filter mr-10">
                        @for($i = 20; $i <= 200; $i+=20)
                            <option {{ ($perpage == $i) ? 'selected' : '' }} value="{{ $i }}">{{ $i }} bản ghi</option>
                        @endfor
                    </select>
                </div>
            </div> --}}
            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    <select name="trashed" class="form-control mr-10 setupSelect2">
                        <option value="0"  {{ (request('repluy') == 0) ? 'selected' : '' }}>Tất cả đánh giá</option>
                        <option value="1" {{ request('trashed') == 1 ? 'selected' : '' }}>Đánh giá đã bị xóa</option>
                        <option value="2" {{ request('trashed') === '0' ? 'selected' : '' }}>Đánh giá chưa bị xóa</option>
                    </select>
                     <!-- Thêm bộ lọc theo điểm số đánh giá (score) -->
                     <select name="score" class="form-control mr-10 setupSelect2">
                        <option value="">Tất cả điểm số</option>
                        @for($i = 1; $i <= 5; $i++) <!-- Lọc từ 1 đến 5 sao -->
                            <option {{ request('score') == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }} sao</option>
                        @endfor
                    </select>

                    <select name="repluy" class="form-control mr-10 setupSelect2">
                        <option value="0" {{ (request('repluy') == 0) ? 'selected' : '' }}>Tất cả đánh giá</option>
                        <option value="1" {{ (request('repluy') == 1) ? 'selected' : '' }}>Đánh giá đã trả lời</option>
                        <option value="2" {{ (request('repluy') == 2) ? 'selected' : '' }}>Đánh giá chưa trả lời</option>
                    </select>
                    
                    
                    @php
                    // Lấy giá trị từ request hoặc giá trị cũ, nếu không có thì mặc định là ''
                    $status = request('status') ?: old('status', '');
                     @endphp
                
                    <select name="status" class="form-control mr-10 setupSelect2">
                    @foreach (config('apps.general.status') ?? [] as $key => $val)
                        <option {{ ($status === (string)$key) ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                    </select>
                
                    <div class="uk-search uk-flex uk-flex-middle mr-10 ml-10">
                        <div class="input-group">
                            <input type="text"
                                   name="keyword"
                                   value="{{ request('keyword') ?: old('keyword') }}"
                                   placeholder="Nhập Từ Khóa bạn muốn tìm kiếm..."
                                   class="form-control">
                            <span class="input-group-btn">
                                <button type="submit" name="search" value="search"
                                    class="btn btn-success mb0 btn-sm">Tìm kiếm</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
</form>