@include('admin.dashboard.component.breadcrumb', ['title' => $config['seo']['index']['title']])
<div class="row mt-20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{ $config['seo']['index']['table'] }}</h5>
                @include('admin.dashboard.component.toolbox', ['model' => 'review'])

            </div>
            <div class="ibox-content">
                <form action="{{ route('reviews.history') }}">
                    <div class="filter-wraper">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                            @php
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
                            </div>                
                            <div class="action">
                                <div class="uk-flex uk-flex-middle">
                                    <select name="score" class="form-control mr-10 setupSelect2">
                                        <option value="">Tất cả điểm số</option>
                                        @for($i = 1; $i <= 5; $i++) 
                                            <option {{ request('score') == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }} sao</option>
                                        @endfor
                                    </select>
{{--                 
                                    <select name="repluy" class="form-control mr-10 setupSelect2">
                                        <option value="0" {{ (request('repluy') == 0) ? 'selected' : '' }}>Tất cả đánh giá</option>
                                        <option value="1" {{ (request('repluy') == 1) ? 'selected' : '' }}>Đánh giá đã trả lời</option>
                                        <option value="2" {{ (request('repluy') == 2) ? 'selected' : '' }}>Đánh giá chưa trả lời</option>
                                    </select> --}}
                                    
                                    {{-- @php
                                    $status = request('status') ?: old('status', '');
                                    @endphp
                                
                                    <select name="status" class="form-control mr-10 setupSelect2">
                                        @foreach (config('apps.general.status') ?? [] as $key => $val)
                                            <option {{ ($status === (string)$key) ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select> --}}
                
                                    <!-- Thêm bộ lọc đánh giá đã bị xóa mềm -->
                                    <select name="trashed" class="form-control mr-10 setupSelect2">
                                        <option value="">Tất cả đánh giá</option>
                                        <option value="1" {{ request('trashed') == 1 ? 'selected' : '' }}>Đánh giá đã bị xóa</option>
                                        <option value="0" {{ request('trashed') === '0' ? 'selected' : '' }}>Đánh giá chưa bị xóa</option>
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
                                                    class="btn btn-primary mb0 btn-sm">Tìm kiếm</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>                
                        </div>
                    </div>
                </form>
                
                 <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Mã đơn hàng</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Nội dung</th>
                                {{-- <th class="text-center">Nội dung cũ</th>
                                <th class="text-center">Nội dung mới</th> --}}
                                <th class="text-center">Số sao</th>
                                {{-- <th class="text-center">Số sao mới</th> --}}
                                <th class="text-center">Ngày thay đổi</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviewHistories as $history)
                                    <tr>
                                        <td class="text-center">{{ $history->code }}</td> 
                                        <td class="text-center">{{ $history->email }}</td>
                                        <td class="text-center">{{ $history->content }}</td>
                                        <td class="text-center">{{ $history->score }}</td>
                                        <td class="text-center">{{ $history->created_at->format('Y-m-d') }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('reviews.history_detail', $history->review_id) }}" class="btn btn-success me-2">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                            @endforeach
                       
                    </tbody>
                    </table>
                </div>                
            </div>
        </div>
    </div>
</div>
