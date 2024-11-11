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
        <h2>Quản lý đơn hàng</h2>
        <ol class="breadcrumb" style="margin-bottom: 10px;">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li class="active"><strong>Danh sách đơn hàng</strong></li>
        </ol>
    </div>
</div>

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="row mt-20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Danh sách đơn hàng</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="#" class="changeStatusAll" data-field="publish" data-model="Category" data-value="1">Active toàn bộ</a>
                        </li>
                        <li>
                            <a href="#" class="changeStatusAll" data-field="publish" data-model="Category" data-value="2">UnActive toàn bộ</a>
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
                                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm kiếm</button>
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
                                <th>Mã đơn hàng</th>
                                <th>Tên Khách Hàng</th>
                                <th>Địa Chỉ</th>
                                <th>Điện Thoại</th>
                                <th>Tổng Tiền</th>
                                <th>Trạng Thái</th>
                                <th>Ngày Tạo</th>
                                <th class="text-center">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listOrder as $order)
                                <tr>
                                    <td>{{ $order->code }}</td>
                                    <td>{{ $order->full_name }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>{{ $order->phone }}</td>
                                    <td>{{ number_format($order->total_price, 2) }} VNĐ</td>
                                    <td>
                                        <form action="{{ route('orders.update', $order->id) }}" method="POST" class="form-status">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select w-75 setupSelect2"
                                                data-default-value="{{ $order->status }}" onchange="confirmSubmit(this)">
                                                @foreach ($orderStatuses as $key => $value)
                                                    <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }} {{ $key == $cancelledOrder ? 'disabled' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</td>
                                    <td class="text-center d-flex justify-content-center">
                                        <a href="{{ route('orders.show', $order->id) }}" class="me-2">
                                            <i class="mdi mdi-eye text-muted fs-18 rounded-2 border p-1" style="font-size: 20px"></i>
                                        </a>
                                        @if ($order->status == $cancelledOrder)
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có đồng ý xóa không?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Nút xác nhận hủy đơn hàng -->
                                        @if ($order->status == 'Chờ xác nhận hủy') <!-- Thay thế 'CHỜ_XÁC_NHẬN' bằng hằng số thực tế -->
                                            <form action="{{ route('orders.confirm-cancellation', $order->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-warning" onclick="return confirm('Bạn có chắc chắn muốn xác nhận hủy đơn hàng này không?')">
                                                    Xác nhận hủy
                                                </button>
                                            </form>
                                        @endif
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
@endsection

@section('js')
<script src="admin/js/plugins/switchery/switchery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    function confirmSubmit(selectElement) {
        var form = selectElement.form;
        var selectedOption = selectElement.options[selectElement.selectedIndex].text;
        var defaultValue = selectElement.getAttribute('data-default-value');

        if (confirm('Bạn có chắc chắn thay đổi trạng thái đơn hàng thành "' + selectedOption + '" không?')) {
            form.submit();
        } else {
            selectElement.value = defaultValue; // Đặt lại giá trị về mặc định nếu người dùng không xác nhận
        }
    }
    
    $(document).ready(function() {
        $('.setupSelect2').select2({
            placeholder: "Chọn trạng thái",
            allowClear: true,
            width: '100%', // Chiều rộng thẻ
        });
    });
</script>
@endsection
