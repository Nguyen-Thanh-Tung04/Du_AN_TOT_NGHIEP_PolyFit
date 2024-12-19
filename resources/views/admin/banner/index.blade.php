@extends('admin.layout')

@section('css')
    <link href="admin/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="admin/css/customize.css" rel="stylesheet">
@endsection

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>Quản lý Banner</h2>
            <ol class="breadcrumb" style="margin-bottom: 10px;">
                <li>
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="active"><strong>Danh sách Banner</strong></li>
            </ol>
        </div>
    </div>

    <div class="row mt-20">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách Banner</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="#"
                                   class="changeStatusAll"
                                   data-field="is_active"
                                   data-model="Category"
                                   data-value="1"
                                >Active toàn bộ</a>
                            </li>
                            <li>
                                <a href="#"
                                   class="changeStatusAll"
                                   data-field="is_active"
                                   data-model="Category"
                                   data-value="0"
                                >UnActive toàn bộ</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="{{ route('banner.index') }}" method="GET">
                        <div class="filter-wraper">
                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                @php
                                    $perpage = request('perpage') ?: old('perpage');
                                    $publish = request('publish') ?: old('publish');
                                    $keyword = request('keyword') ?: old('keyword');
                                @endphp
                                <div class="perpage">
                                    <select name="perpage" class="form-control input-control input-sm perpage filter mr-10">
                                        @for($i = 20; $i <= 200; $i+=20)
                                            <option {{ ($perpage == $i) ? 'selected' : '' }} value="{{ $i }}">{{ $i }} bản ghi</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="action">
                                    <div class="uk-flex uk-flex-middle">
                                        <!-- Lọc theo trạng thái -->
                                        <select name="publish" class="form-control mr-10 setupSelect2">
                                            <option value="">-- Chọn trạng thái --</option>
                                            <option value="1" {{ $publish == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $publish == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        
                                        <!-- Tìm kiếm theo tên -->
                                        <div class="uk-search uk-flex uk-flex-middle mr-10 ml-10">
                                            <div class="input-group">
                                                <input type="text"
                                                       name="keyword"
                                                       value="{{ $keyword }}"
                                                       placeholder="Nhập Từ Khóa bạn muốn tìm kiếm..."
                                                       class="form-control">
                                                <span class="input-group-btn">
                                                    <button type="submit" name="search" value="search"
                                                            class="btn btn-success mb0 btn-sm">Tìm kiếm</button>
                                                </span>
                                            </div>
                                        </div>

                                        <a href="{{ route('banner.create') }}" class="btn btn-danger">
                                            <i class="fa fa-plus mr-5"></i>Thêm mới Banner
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">STT</th>
                    <th>Tiêu đề chính</th>
                    <th>Tiêu đề phụ</th>
                    <th>Nội dung</th>
                    <th>Hình Ảnh</th>
                    <th>Liên kết</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banners as $key => $banner)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>{{ $banner->title_main }}</td>
                        <td>{{ $banner->title_sub }}</td>
                        <td>{{ $banner->content }}</td>
                        <td><img src="{{ asset('storage/' . $banner->image) }}" width="100"></td>
                        <td>{{ $banner->link }}</td>
                        <td class="text-center js-switch-{{ $banner->id }}">
                            <input type="checkbox" value="{{ $banner->is_active }}" 
                            class="js-switch is_active " 
                            data-field="is_active" 
                            data-model="Banner"
                            data-modelId="{{ $banner->id }}"
                            {{ ($banner->is_active == 1) ? 'checked' : '' }} />
                        </td> 
                        <td class="text-center">
                            <a href="{{ route('banner.edit', $banner->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('banner.delete', $banner->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="pagination-container">
            {{ $banners->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection

@section('js')
    <script src="admin/js/plugins/switchery/switchery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
