<form action="{{ route('user.catalogue.index') }}">
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
                    @php
                        $publish = request('publish') ?: old('publish');
                    @endphp
                    <select name="publish" class="form-control mr-10 setupSelect2">
                        @foreach (config('apps.general.publish') as $key => $val)
                            <option {{ ($publish == $key) ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
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
                    <div class="uk-flex uk-flex-middle">
                        <a href="{{ route('user.catalogue.permission') }}" class="btn btn-warning mr-10"><i class="fa fa-key mr-5"></i>Phân quyền</a>
                        <!-- <a href="{{ route('user.catalogue.create') }}" class="btn btn-danger"><i class="fa fa-plus mr-5"></i>Thêm mới chức vụ</a> -->

                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
