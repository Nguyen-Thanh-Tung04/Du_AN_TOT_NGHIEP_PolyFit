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
<form action="{{route('banner.store')}}" method="post" class="box">
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
                                    <label class="control-label text-left">Tiêu đề
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="title"
                                        value="{{ old('code') }}"
                                        class="form-control"
                                        placeholder="Nhập tiêu đề"
                                    >
                                    @error('title')
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
                                        placeholder="Nhập tên voucher"
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
                                    <label class="control-label text-left">Hiện thị
                                        <span class="text-danger">(*)</span></label>
                                    </label>
                                    <input
                                        type="checkbox"
                                        name="active"
                                        value="{{ old('active') }}"
                                        class="form-control"
                                    >
                                    @error('active')
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
