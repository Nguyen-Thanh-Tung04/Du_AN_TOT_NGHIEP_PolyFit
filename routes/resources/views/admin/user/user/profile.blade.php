@include('admin.dashboard.component.breadcrumb', ['title' => $config['seo']['profile']['title']])
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
    $url = route('user.update', $user->id);
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
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Email
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="email"
                                        value="{{ old('email', ($user->email) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Họ Tên
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name', ($user->name) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Nhân viên
                                        <span class="text-danger">(*)</span></label>
                                    <select name="user_catalogue_id" class="form-control setupSelect2">
                                        <option value="0">Chọn chức vụ</option>
                                        @foreach($userCatalogue as $item) <!-- Sử dụng $catalogue thay vì $key -->
                                        @if ($item->id == 3) 
                                            @continue; 
                                        @endif
                                        <option {{ old('user_catalogue_id', $user->user_catalogue_id) == $item->id ? 'selected' : '' }} 
                                            value="{{ $item->id }}">{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Ngày sinh</label>
                                    <input
                                        type="date"
                                        name="birthday"
                                        value="{{ old('birthday', isset($user->birthday) ? date('Y-m-d', strtotime($user->birthday)) : '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                        </div>
                        @if ($config['method'] == 'create')
                            <div class="row">
                                <div class="col-lg-6 mb-15">
                                    <div class="form-row">
                                        <label class="control-label text-left">Mật khẩu
                                            <span class="text-danger">(*)</span></label>
                                        <input
                                            type="password"
                                            name="password"
                                            value=""
                                            class="form-control"
                                            placeholder=""
                                            autocomplete="off"
                                        >
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-15">
                                    <div class="form-row">
                                        <label class="control-label text-left">Nhập lại mật khẩu
                                            <span class="text-danger">(*)</span></label>
                                        <input
                                            type="password"
                                            name="re_password"
                                            value=""
                                            class="form-control"
                                            autocomplete="off"
                                        >
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="control-label text-left">Ảnh đại diện</label>
                                    <input
                                        type="text"
                                        name="image"
                                        value="{{ old('image', ($user->image) ?? '') }}"
                                        class="form-control upload-image"
                                        data-type="Images"
                                        placeholder=""
                                        autocomplete="off"
                                        data-upload="Images"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-heading">
                    <div class="panel-title">Thông tin liên hệ</div>
                    <div class="panel-description">Nhập thông tin liên hệ của người sử dụng</div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Thành Phố</label>
                                    <select name="province_id" class="form-control setupSelect2 province location" data-target="districts">
                                        <option value="0">[Chọn Thành Phố]</option>
                                        @if (isset($provinces))
                                            @foreach($provinces as $province)
                                            <option value="{{ $province->code }}"
                                                {{ old('province_id') == $province->code ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Quận/Huyện</label>
                                    <select name="district_id" class="form-control districts setupSelect2 location" data-target="wards">
                                        <option value="0">[Chọn Quận/Huyện]</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Phường/Xã</label>
                                    <select name="ward_id" class="form-control setupSelect2 wards">
                                        <option value="0">[Chọn Phường/Xã]</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Địa chỉ</label>
                                    <input
                                        type="text"
                                        name="address"
                                        value="{{ old('address', ($user->address) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Số điện thoại</label>
                                    <input
                                        type="text"
                                        name="phone"
                                        value="{{ old('phone', ($user->phone) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Ghi Chú</label>
                                    <input
                                        type="text"
                                        name="description"
                                        value="{{ old('description', ($user->description) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
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
<script>
    var province_id = '{{ (isset($user->province_id)) ? $user->province_id : old('province_id') }}'
    var district_id = '{{ (isset($user->district_id)) ? $user->district_id : old('district_id') }}'
    var ward_id = '{{ (isset($user->ward_id)) ? $user->ward_id : old('ward_id') }}'
</script>
