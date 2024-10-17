@extends('admin.layout')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Quản lý Voucher</h2>
        <ol class="breadcrumb" style="margin-bottom: 10px;">
            <li>
                <a href="">Dashboard</a>
            </li>
            <li class="active"><strong>Thêm Voucher</strong></li>
        </ol>
    </div>
</div>
<form action="{{ route('vouchers.store') }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-heading">
                    <div class="panel-title">Thông tin voucher</div>
                    <div class="panel-description">
                        <p>- Nhập thông tin chi tiết của voucher</p>
                        <p>- Lưu ý: Những trường đánh dấu <span class="text-danger">(*) </span>là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Mã Voucher
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="code"
                                        value="{{ old('code') }}"
                                        class="form-control"
                                        placeholder="Nhập mã voucher"
                                    >
                                    @error('code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Tên Voucher
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        class="form-control"
                                        placeholder="Nhập tên voucher"
                                    >
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Giá Trị Giảm Giá
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="number"
                                        step="0.01"
                                        name="value"
                                        value="{{ old('value') }}"
                                        class="form-control"
                                        placeholder="Nhập giá trị"
                                    >
                                    @error('value')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Giá trị tối đa
                                        <span class="text-danger">(*)</span></label>

                                    </label>
                                    <input
                                        type="number"
                                        step="0.01"
                                        name="max_discount_value"
                                        value="{{ old('max_discount_value') }}"
                                        class="form-control"
                                        placeholder="Nhập giá trị tối đa"
                                    >
                                    @error('max_discount_value')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Giá trị đơn hàng tối thiểu
                                    </label>
                                    <input
                                        type="number"
                                        step="0.01"
                                        name="min_order_value"
                                        value="{{ old('min_order_value') }}"
                                        class="form-control"
                                        placeholder="Nhập Giá trị đơn hàng tối thiểu"
                                    >
                                    @error('min_order_value')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Loại Giảm Giá
                                        <span class="text-danger">(*)</span></label>
                                    <select name="discount_type" class="form-control">
                                        <option value="" disabled selected>Chọn loại giảm giá</option>
                                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Phần trăm</option>
                                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Cố định</option>
                                    </select>
                                    @error('discount_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Số Lượng
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="number"
                                        name="quantity"
                                        value="{{ old('quantity', 1) }}"
                                        class="form-control"
                                        placeholder="Nhập số lượng"
                                        min="1"
                                    >
                                    @error('quantity')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Trạng thái
                                        </label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ old('status', true) ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="0" {{ old('status') == false ? 'selected' : '' }}>Không hoạt động</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Thời gian bắt đầu                                         <span class="text-danger">(*)</span></label>
                                    </label>

                                    </label>
                                    <input
                                        type="datetime-local"
                                        name="start_time"
                                        value="{{ old('start_time') }}"
                                        class="form-control"
                                    >
                                    @error('start_time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Thời gian kết thúc
                                        <span class="text-danger">(*)</span></label>

                                    </label>
                                    <input
                                        type="datetime-local"
                                        name="end_time"
                                        value="{{ old('end_time') }}"
                                        class="form-control"
                                    >
                                    @error('end_time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb-15">
            <button type="submit" class="btn btn-primary">Lưu Voucher</button>
        </div>
    </div>
</form>
@endsection
