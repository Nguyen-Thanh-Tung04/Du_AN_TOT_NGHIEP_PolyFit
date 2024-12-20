<form action="{{ route('flashsale.index') }}">
    <div class="filter-wraper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">

            <div class="perpage">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
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
                </div>
            </div>
            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    <a href="{{ route('flashsale.create') }}" class="btn btn-danger"><i class="fa fa-plus mr-5"></i>Thêm mới flash sale</a>
                </div>
            </div>
        </div>
    </div>

</form>