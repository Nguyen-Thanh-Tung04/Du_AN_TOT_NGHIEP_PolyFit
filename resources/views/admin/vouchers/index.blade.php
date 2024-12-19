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
                                    $publish = request('publish') ?: old('publish');
                                    $discount_type = request('discount_type') ?: old('discount_type');
                                @endphp
                                <!-- Bộ lọc số lượng bản ghi hiển thị -->
                                <div class="perpage">
                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                        <select name="perpage" class="form-control input-control input-sm perpage filter mr-10">
                                            @for($i = 20; $i <= 200; $i+=20)
                                                <option {{ ($perpage == $i) ? 'selected' : '' }} value="{{ $i }}">{{ $i }} bản ghi</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                    
                                <!-- Bộ lọc trạng thái -->
                                <div class="action">
                                    <div class="uk-flex uk-flex-middle">
                                        <select name="publish" class="form-control mr-10 setupSelect2">
                                            @foreach (config('apps.general.publish') as $key => $val)
                                                <option {{ ($publish == $key) ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                                            @endforeach
                                        </select>
                    
                                        <!-- Bộ lọc loại giảm giá -->
                                        <select name="discount_type" class="form-control mr-10">
                                            <option value="">-- Chọn loại giảm giá --</option>
                                            <option value="fixed" {{ $discount_type == 'fixed' ? 'selected' : '' }}>Giảm giá cố định</option>
                                            <option value="percentage" {{ $discount_type == 'percentage' ? 'selected' : '' }}>Giảm giá theo tỷ lệ</option>
                                        </select>
                    
                                        <!-- Tìm kiếm từ khóa -->
                                        <div class="uk-search uk-flex uk-flex-middle mr-10 ml-10">
                                            <div class="input-group">
                                                <input type="text"
                                                    name="keyword"
                                                    value="{{ request('keyword') ?: old('keyword') }}"
                                                    placeholder="Nhập từ khóa bạn muốn tìm kiếm..."
                                                    class="form-control">
                                                <span class="input-group-btn">
                                                    <button type="submit" name="search" value="search" class="btn btn-success mb0 btn-sm">
                                                        Tìm kiếm
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                    
                                        <!-- Thêm mới voucher -->
                                        <a href="{{ route('vouchers.create') }}" class="btn btn-danger">
                                            <i class="fa fa-plus mr-5"></i>Thêm mới Voucher
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        STT
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
                                @foreach($vouchers as $key => $voucher)
                                    <tr>
                                        <td class="text-center">
                                            {{ $key + 1 }}
                                        </td>
                                        <td>{{ $voucher->code }}</td>
                                        <td>{{ $voucher->name }}</td>
                                        <td>
                                            {{ $voucher->value == floor($voucher->value) ? number_format($voucher->value, 0) : number_format($voucher->value, 2) }}
                                            @if($voucher->discount_type == 'percentage')%
                                            @endif
                                        </td>
                                        <td>
                                                {{ $voucher->discount_type == 'fixed' ? 0 : ($voucher->max_discount_value == floor($voucher->max_discount_value) ? number_format($voucher->max_discount_value, 0) : number_format($voucher->max_discount_value, 2)) }}
                                                                           
                                        </td>
                                        <td>
                                            {{ $voucher->min_order_value == floor($voucher->min_order_value) ? number_format($voucher->min_order_value, 0) : number_format($voucher->min_order_value, 2) }}
                                        </td>
                                        <td>
                                            {{ $voucher->max_order_value == floor($voucher->max_order_value) ? number_format($voucher->max_order_value, 0) : number_format($voucher->max_order_value, 2) }}
                                        </td>
                                        <td>{{ $voucher->discount_type == 'fixed' ? 'Giảm giá cố định' : 'Giảm giá theo tỷ lệ' }}</td>
                                        <td>{{ number_format($voucher->quantity) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($voucher->start_time)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($voucher->end_time)->format('d/m/Y') }}</td>
                                        <td class="text-center js-switch-{{ $voucher->id }}">
                                            <input type="checkbox" value="{{ $voucher->status }}" 
                                            class="js-switch status " 
                                            data-field="status" 
                                            data-model="Voucher"
                                            data-modelId="{{ $voucher->id }}"
                                            {{ ($voucher->status == 1) ? 'checked' : '' }} />
                                        </td> 
                                        <td class="text-center">
                                            <a href="{{ route('vouchers.edit', $voucher->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST" style="display: inline-block;">
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