@extends('admin.layout')

@section('css')
<link href="admin/css/plugins/switchery/switchery.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="admin/css/customize.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Material Design Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
@endsection

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>Quản lý Voucher</h2>
            <ol class="breadcrumb" style="margin-bottom: 10px;">
                <li>
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="active"><strong>Danh sách voucher</strong></li>
            </ol>
        </div>
    </div>

    <div class="row mt-20">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách voucher</h5>
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
                                data-field="publish"
                                data-model="Category"
                                data-value="1"
                                >Active toàn bộ</a>
                            </li>
                            <li>
                                <a href="#" 
                                class="changeStatusAll" 
                                data-field="publish"
                                data-model="Category"
                                data-value="2"
                                >UnActive toàn bộ</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>                

                </div>
                <div class="ibox-content">
                    <form action="">
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
                                                        class="btn btn-primary mb0 btn-sm">Tìm kiếm</button>
                                                </span>
                                            </div>
                                        </div>
                                        <a href="{{ route('vouchers.create') }}" class="btn btn-danger"><i class="fa fa-plus mr-5"></i>Thêm mới Voucher</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" value="" id="checkAll" class="input-checkbox">
                                    </th>
                                    <th>Mã Voucher</th>
                                    <th>Tên Voucher</th>
                                    <th>Giá Trị</th>
                                    <th>Giá Trị Giảm Tối Đa</th>
                                    <th>Giá Trị Đơn Hàng Tối Thiểu</th>
                                    <th>Giá Trị Đơn Hàng Tối Đa</th>
                                    <th>Loại Giảm Giá</th>
                                    <th>Số Lượng</th>
                                    <th>Ngày Bắt Đầu</th>
                                    <th>Ngày Kết Thúc</th>
                                    <th class="text-center">Tình Trạng</th>
                                    <th class="text-center">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vouchers as $voucher)
                                    <tr>
                                        <td>
                                            <input type="checkbox" value="{{ $voucher->id }}" class="input-checkbox checkBoxItem">
                                        </td>
                                        <td>{{ $voucher->code }}</td>
                                        <td>{{ $voucher->name }}</td>
                                        <td>{{ $voucher->value }}</td>
                                        <td>{{ $voucher->max_discount_value }}</td>
                                        <td>{{ $voucher->min_order_value}}</td>
                                        <td>{{ $voucher->max_order_value}}</td>
                                        <td>{{ $voucher->discount_type == 'fixed' ? 'Giảm giá cố định' : 'Giảm giá theo tỷ lệ' }}</td>
                                        <td>{{ number_format($voucher->quantity, 2, '.', ',') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($voucher->start_time)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($voucher->end_time)->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <input type="checkbox" value="{{ $voucher->status }}" 
                                                   class="js-switch status" 
                                                   data-field="status" 
                                                   data-model="Voucher"
                                                   data-modelId="{{ $voucher->id }}"
                                                   {{ $voucher->status ? 'checked' : '' }} />
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('vouchers.edit', $voucher->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST" style="display: inline-block;"   >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $vouchers->links('pagination::bootstrap-5') }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    
@endsection
@section('js')
    <script src="admin/js/plugins/switchery/switchery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection