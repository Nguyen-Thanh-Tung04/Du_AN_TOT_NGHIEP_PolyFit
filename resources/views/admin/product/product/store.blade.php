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
    $url = route('user.store');
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-heading">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p>- Nhập thông tin chung của người sử dụng</p>
                        <p>- Lưu ý: Những trường đánh dấu <span class="text-danger">(*) </span>là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Mã sản phẩm
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="code"
                                        value="{{ old('code') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Tên sản phẩm
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                        </div>
                        @php
                            $userCatalogue = [
                                '[Chọn danh mục]',
                                '[Quản trị viên]',
                                '[Nhân viên]',
                            ];
                        @endphp
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Danh mục
                                        <span class="text-danger">(*)</span></label>
                                        <select name="parent_id" class="form-control setupSelect2">
                                            @foreach ($dropdown as $key => $val)
                                                <option
                                                    value="{{ $key }}"  value="{{ $key }}">{{ $val }}
                                                </option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Mô tả</label>
                                    <textarea name="description" class="form-control" name="" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="ibox" style="margin:15px;">
                                <div class="ibox-title">
                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                        <h5>Album ảnh</h5>
                                        <div class="upload-album"><a href="" class="upload-picture">
                                            Chọn hình</a></div>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    @php
                                        $album = (!empty($model->album)) ? json_decode($model->album) : [];
                                        $gallery = (isset($album) && count($album) ) ? $album : old('album');
                                    @endphp
                                    <div class="row">
                                        <div class="col-lg-12">
                                            @if(!isset($gallery) || count($gallery) == 0)
                                            <div class="click-to-upload">
                                                <div class="icon">
                                                    <a href="" class="upload-picture">
                                                        <svg style="width:80px;height:80px;fill: #d3dbe2;margin-bottom: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><path d="M80 57.6l-4-18.7v-23.9c0-1.1-.9-2-2-2h-3.5l-1.1-5.4c-.3-1.1-1.4-1.8-2.4-1.6l-32.6 7h-27.4c-1.1 0-2 .9-2 2v4.3l-3.4.7c-1.1.2-1.8 1.3-1.5 2.4l5 23.4v20.2c0 1.1.9 2 2 2h2.7l.9 4.4c.2.9 1 1.6 2 1.6h.4l27.9-6h33c1.1 0 2-.9 2-2v-5.5l2.4-.5c1.1-.2 1.8-1.3 1.6-2.4zm-75-21.5l-3-14.1 3-.6v14.7zm62.4-28.1l1.1 5h-24.5l23.4-5zm-54.8 64l-.8-4h19.6l-18.8 4zm37.7-6h-43.3v-51h67v51h-23.7zm25.7-7.5v-9.9l2 9.4-2 .5zm-52-21.5c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5zm0-8c-1.7 0-3 1.3-3 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3zm-13-10v43h59v-43h-59zm57 2v24.1l-12.8-12.8c-3-3-7.9-3-11 0l-13.3 13.2-.1-.1c-1.1-1.1-2.5-1.7-4.1-1.7-1.5 0-3 .6-4.1 1.7l-9.6 9.8v-34.2h55zm-55 39v-2l11.1-11.2c1.4-1.4 3.9-1.4 5.3 0l9.7 9.7c-5.2 1.3-9 2.4-9.4 2.5l-3.7 1h-13zm55 0h-34.2c7.1-2 23.2-5.9 33-5.9l1.2-.1v6zm-1.3-7.9c-7.2 0-17.4 2-25.3 3.9l-9.1-9.1 13.3-13.3c2.2-2.2 5.9-2.2 8.1 0l14.3 14.3v4.1l-1.3.1z"></path></svg>
                                                    </a>
                                                </div>
                                                <div class="small-text">
                                                    Sử dụng nút chọn hình hoặc click vào đây để thêm hình ảnh
                                                </div>
                                            </div>
                                            @endif
                                            
                                            <div class="upload-list {{ (isset($gallery) && count($gallery)) ? '' : 'hidden' }}">
                                                <ul id="sortable" class="clearfix data-album sortui ui-sortable">
                                                    @if(isset($gallery) && count($gallery))
                                                        @foreach($gallery as $key => $val)
                                                        <li class="ui-state-default">
                                                                <div class="thumb">
                                                                    <span class="span image img-scaledown">
                                                                        <img src="{{ $val }}" alt="{{ $val }}">
                                                                        <input type="hidden" name="album[]" value="{{ $val }}">
                                                                    </span>
                                                                    <button class="delete-image"><i class="fa fa-trash"></i></button>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12 mb-15">
                                
                                <div class="table-responsive">
                                    <div style="margin: 10px 0 20px 0;">
                                        <a href="http://127.0.0.1:8000/product/create" class="btn btn-danger"><i class="fa fa-plus mr-5"></i>Thêm mới sản phẩm</a>
                                    </div>
                                    <table class="table table-sm table-striped table-bordered">
                                        <tbody>
                                                <tr>
                                                    <td class="text-center">
                                                        <select name="" class="form-control setupSelect2" data-target="wards">
                                                            <option value="0">[Chọn màu sắc]</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <select name="" class="form-control setupSelect2" data-target="wards">
                                                            <option value="0">[Chọn kích thước]</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" value="" placeholder="Giá nhập kho" class="form-control">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" value="" placeholder="Giá bán" class="form-control">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" value="" placeholder="Giá sale" class="form-control">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" value="" placeholder="Số lượng" class="form-control">
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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


