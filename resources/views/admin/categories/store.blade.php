
@include('admin.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@php
    $url = ($config['method'] == 'create') ? route('category.store') : route('category.update', $categoryService->id);
@endphp
<form action="{{ $url }}" method="post" class="box" enctype="multipart/form-data">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-heading">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p>- Nhập thông tin danh mục</p>
                        <p>- Lưu ý: Những trường đánh dấu <span class="text-danger">(*) </span>là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-8 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Mã danh mục
                                        <span class="text-danger">(*)</span>
                                        </label>
                                    <input
                                        type="text"
                                        name="code"
                                        value="{{ old('code', ($userCatalogue->code) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Tên danh mục
                                        <span class="text-danger">(*)</span>
                                        </label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name', ($userCatalogue->name) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Ảnh
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="file" name="image" id="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        
        <div class="text-right mb-15">
            <button type="submit" class="btn btn-primary" name="send" value="send">Lưu thay đổi</button>
        </div>
    </div>
</form>
