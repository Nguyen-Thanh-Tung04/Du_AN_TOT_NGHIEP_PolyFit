<form action="{{ route('product.size.index') }}">
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
                    <a href="{{ route('product.size.create') }}" class="btn btn-danger"><i class="fa fa-plus mr-5"></i>Thêm mới màu sắc</a>
                </div>
            </div>
        </div>
    </div>
    
</form>