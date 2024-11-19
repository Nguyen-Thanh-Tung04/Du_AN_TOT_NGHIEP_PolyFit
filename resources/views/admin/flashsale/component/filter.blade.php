<form action="{{ route('flashsale.index') }}">
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
                    // Lấy giá trị từ request hoặc giá trị cũ, nếu không có thì mặc định là ''
                    $is_active = request('is_active') ?: old('is_active', '');
                    @endphp

                    <select name="status" class="form-control mr-10 setupSelect2" onchange="this.form.submit()">
                        <option value="">Tất cả</option>
                        <option value="Sắp diễn ra" {{ request('status') == 'Sắp diễn ra' ? 'selected' : '' }}>Sắp diễn ra</option>
                        <option value="Đang diễn ra" {{ request('status') == 'Đang diễn ra' ? 'selected' : '' }}>Đang diễn ra</option>
                        <option value="Đã diễn ra" {{ request('status') == 'Đã diễn ra' ? 'selected' : '' }}>Đã diễn ra</option>
                    </select>


                    <a href="{{ route('flashsale.create') }}" class="btn btn-danger"><i class="fa fa-plus mr-5"></i>Thêm mới flash sale</a>
                </div>
            </div>
        </div>
    </div>

</form>