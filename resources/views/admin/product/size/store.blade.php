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
    $url = route('product.size.store');
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-heading">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p>- Nhập thông tin chung của người sử dụng</p>
                        <p>- Lưu ý: Những trường đánh dấu <span class="text-danger">(*) </span>là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <div style="margin: 10px 0 20px 0;">
                                <a href="http://127.0.0.1:8000/product/create" class="btn btn-danger" id="addVariant">
                                    <i class="fa fa-plus mr-5"></i>
                                    Thêm kích cỡ</a>
                            </div>
                            <table class="table table-sm table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Tên kích cỡ<span class="text-danger"> (*)</span></th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="variant-tbody">
                                        <tr class="variant-row">
                                            <td class="text-center">
                                                <input type="text" name="name[]" value="{{ old('name.0') }}" placeholder="Tên kích cỡ" class="form-control">
                                            </td>
                                            <td class="text-center">
                                                <a href="" class="btn btn-danger remove-variant"><i class="fa fa-trash "></i></a>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb-15">
            <button type="submit" class="btn btn-primary" name="send" value="send">Lưu thay đổi</button>
        </div>
    </div>
</form>

