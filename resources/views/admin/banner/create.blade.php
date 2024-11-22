@extends('admin.layout')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Quản lý Voucher</h2>
        <ol class="breadcrumb" style="margin-bottom: 10px;">
            <li>
                <a href="">Dashboard</a>
            </li>
            <li class="active"><strong>Thêm Banner</strong></li>
        </ol>
    </div>
</div>
<form action="{{route('banner.store')}}" method="post" class="box" enctype="multipart/form-data">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-heading">
                    <div class="panel-title">Thông tin Banner</div>
                    <div class="panel-description">
                        <p>- Nhập thông tin chi tiết của banner</p>
                        <p>- Lưu ý: Những trường đánh dấu <span class="text-danger">(*) </span>là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Tiêu đề chính
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="title_main"
                                        value="{{ old('code') }}"
                                        class="form-control"
                                        placeholder="Nhập tiêu đề"
                                    >
                                    @error('title_main')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Tiêu đề phụ
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="title_sub"
                                        value="{{ old('code') }}"
                                        class="form-control"
                                        placeholder="Nhập tiêu đề"
                                    >
                                    @error('title_sub')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Nội dung
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="content"
                                        value="{{ old('code') }}"
                                        class="form-control"
                                        placeholder="Nhập tiêu đề"
                                    >
                                    @error('content')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Hình ảnh
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="file"
                                        name="image"
                                        value="{{ old('image') }}"
                                        class="form-control"
                                        placeholder=""
                                    >
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Liên kết
                                        <span class="text-danger"></span></label>
                                    <input
                                        type="url"
                                        name="link"
                                        value="{{ old('link') }}"
                                        class="form-control"
                                        placeholder="Nhập link liên kết(Không bắt buộc)"
                                    >
                                    @error('value')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Trạng thái
                                        <select class="form-control" id="is_active" name="is_active">
                                            <option value="1" selected>Kích hoạt</option>
                                            <option value="0">Ẩn</option>
                                        </select>

                                    @error('value')
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
            <button type="submit" class="btn btn-primary">Thêm banner</button>
        </div>
    </div>
</form>
@endsection
