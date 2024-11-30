@extends('admin.layout')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Quản lý Voucher</h2>
        <ol class="breadcrumb" style="margin-bottom: 10px;">
            <li>
                <a href="">Dashboard</a>
            </li>
            <li class="active"><strong>Chỉnh sửa Banner</strong></li>
        </ol>
    </div>
</div>
<form action="{{ route('banner.update', $banner->id) }}" method="post" class="box" enctype="multipart/form-data">
    @method('PUT')
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
                                        <input type="text" class="form-control" id="title_main" name="title_main" value="{{ old('title_main', $banner->title_main) }}" required>
                                    @error('title_main')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Tiêu đề phụ
                                        <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control" id="title_sub" name="title_sub" value="{{ old('title_sub', $banner->title_sub) }}" required>
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
                                        <input type="text" class="form-control" id="content" name="content" value="{{ old('content', $banner->content) }}" required>
                                    @error('content')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Hình ảnh
                                        <span class="text-danger">(*)</span></label>
                                    <<input type="file" class="form-control-file" id="image" name="image">
                                    @if ($banner->image)
                                    <p>Ảnh hiện tại:</p>
                                    <img src="{{ asset('storage/' . $banner->image) }}" width="150" alt="Banner Image">
                                @endif
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
                                        <input type="url" class="form-control" id="link" name="link" value="{{ old('link', $banner->link) }}">
                                    @error('link')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Trạng thái
                                        <select class="form-control" id="is_active" name="is_active">
                                            <option value="1" {{ $banner->is_active ? 'selected' : '' }}>Kích hoạt</option>
                                            <option value="0" {{ !$banner->is_active ? 'selected' : '' }}>Ẩn</option>
                                        </select>
                                    @error('is_active')
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
            <button type="submit" class="btn btn-primary">Cập nhật banner</button>
        </div>
    </div>
</form>
@endsection
