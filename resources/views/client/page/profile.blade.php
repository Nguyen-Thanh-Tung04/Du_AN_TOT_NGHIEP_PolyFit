@extends('client.layouts.master')

@section('content')

<!-- ekka Cart Start -->
<div class="ec-side-cart-overlay"></div>
<div id="ec-side-cart" class="ec-side-cart">
    <div class="ec-cart-inner">
        <div class="ec-cart-top">
            <div class="ec-cart-title">
                <span class="cart_title">Giỏ hàng của tôi</span>
                <button class="ec-close">×</button>
            </div>
            <ul class="eccart-pro-items">
                <li>
                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                            src="assets/images/product-image/6_1.jpg" alt="product"></a>
                    <div class="ec-pro-content">
                        <a href="product-left-sidebar.html" class="cart_pro_title">Áo thun nữ</a>
                        <span class="cart-price"><span>$76.00</span> x 1</span>
                        <div class="qty-plus-minus">
                            <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                        </div>
                        <a href="javascript:void(0)" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                            src="assets/images/product-image/12_1.jpg" alt="product"></a>
                    <div class="ec-pro-content">
                        <a href="product-left-sidebar.html" class="cart_pro_title">Giày da nữ</a>
                        <span class="cart-price"><span>$64.00</span> x 1</span>
                        <div class="qty-plus-minus">
                            <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                        </div>
                        <a href="javascript:void(0)" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                            src="assets/images/product-image/3_1.jpg" alt="product"></a>
                    <div class="ec-pro-content">
                        <a href="product-left-sidebar.html" class="cart_pro_title">Ví Nylon cho bé gái</a>
                        <span class="cart-price"><span>$59.00</span> x 1</span>
                        <div class="qty-plus-minus">
                            <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                        </div>
                        <a href="javascript:void(0)" class="remove">×</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="ec-cart-bottom">
            <div class="cart-sub-total">
                <table class="table cart-table">
                    <tbody>
                        <tr>
                            <td class="text-left">Tổng phụ :</td>
                            <td class="text-right">$300.00</td>
                        </tr>
                        <tr>
                            <td class="text-left">VAT (20%) :</td>
                            <td class="text-right">$60.00</td>
                        </tr>
                        <tr>
                            <td class="text-left">Total :</td>
                            <td class="text-right primary-color">$360.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="cart_btn">
                <a href="cart.html" class="btn btn-primary">Xem giỏ hàng</a>
                <a href="checkout.html" class="btn btn-secondary">Thanh toán</a>
            </div>
        </div>
    </div>
</div>
<!-- ekka Cart End -->

<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Hồ sơ người dùng</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Hồ sơ</li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->

<!-- User profile section -->
<section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
    <div class="container">
        <div class="row">
            <!-- Sidebar Area Start -->
            <div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
                <div class="ec-sidebar-wrap ec-border-box">
                    <!-- Sidebar Category Block -->
                    <div class="ec-sidebar-block">
                        <div class="ec-vendor-block">
                            <!-- <div class="ec-vendor-block-bg"></div>
                            <div class="ec-vendor-block-detail">
                                <img class="v-img" src="assets/images/user/1.jpg" alt="vendor image">
                                <h5>Mariana Johns</h5>
                            </div> -->
                            <div class="ec-vendor-block-items">
                                <ul>
                                    <li><a href="user-profile.html">Hồ sơ người dùng</a></li>
                                    <li><a href="{{route('changePassword')}}">Thay đổi mật khẩu</a></li>
                                    <li><a href="user-history.html">Lịch sử</a></li>
                                    <li><a href="wishlist.html">Danh sách mong muốn</a></li>
                                    <li><a href="cart.html">Giỏ hàng</a></li>
                                    <li><a href="checkout.html">Thanh toán</a></li>
                                    <li><a href="track-order.html">Theo dõi đơn hàng</a></li>
                                    <li><a href="user-invoice.html">Hóa đơn</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ec-shop-rightside col-lg-9 col-md-12">
                <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
                    <div class="ec-vendor-card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="ec-vendor-block-profile">
                                    <div class="ec-vendor-block-img space-bottom-30">
                                        <div class="ec-vendor-block-bg">
                                            <a href="{{route('updateProfile',$profile->id)}}" class="btn btn-lg btn-primary "
                                                data-link-action="editmodal" title="Edit Detail"
                                                data-bs-toggle="modal" data-bs-target="#edit_modal">Chỉnh sửa thông tin</a>
                                        </div>
                                        <div class="ec-vendor-block-detail">
                                            <img class="v-img" src="{{Storage::url($profile->image)}}" alt="vendor image">
                                            <h5 class="name">{{$profile->name}}</h5>
                                        </div>
                                        <p>Xin chào<span> {{$profile->name}}</span></p>
                                        <p>Từ tài khoản của bạn, bạn có thể dễ dàng xem . Bạn có thể quản lý và thay đổi thông tin tài khoản của mình như địa chỉ, thông tin liên hệ.</p>
                                    </div>
                                    <h5>Thông tin tài khoản</h5>

                                    <div class="row">

                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-email space-bottom-30">
                                                <h6>Tên: {{$profile->name}}<a href="javasript:void(0)" data-link-action="editmodal" title="Edit Detail" data-bs-toggle="modal" data-bs-target="#edit_modal"></a></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-email space-bottom-30">
                                                <h6>Email: {{$profile->email}}<a href="javasript:void(0)" data-link-action="editmodal" title="Edit Detail" data-bs-toggle="modal" data-bs-target="#edit_modal"></a></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-email space-bottom-30">
                                                <h6>Mật khẩu: ********<a href="javasript:void(0)" data-link-action="editmodal" title="Edit Detail" data-bs-toggle="modal" data-bs-target="#edit_modal"></a></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-contact space-bottom-30">
                                                <h6>Số điện thoại:{{$profile->phone}}<a href="javasript:void(0)" data-link-action="editmodal" title="Edit Detail" data-bs-toggle="modal" data-bs-target="#edit_modal"></a></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-address mar-b-30">
                                                <h6>Ngày sinh: {{$profile->birthday}}<a href="javasript:void(0)" data-link-action="editmodal" title="Edit Detail" data-bs-toggle="modal" data-bs-target="#edit_modal"></a></h6>

                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-address">
                                                <h6>Tỉnh/Thành phố:
                                                    @foreach($provinces as $province)
                                                        {{ $profile->province_id == $province->code ? $province->name : ''}}
                                                    @endforeach
                                                    <a href="javasript:void(0)" data-link-action="editmodal" title="Edit Detail" data-bs-toggle="modal" data-bs-target="#edit_modal"></a></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-address">
                                                <h6>Quận/Huyện:
                                                    @foreach($districts as $district)
                                                    {{ $profile->district_id == $district->code ? $district->name : ''}}
                                                @endforeach <a href="javasript:void(0)" data-link-action="editmodal" title="Edit Detail" data-bs-toggle="modal" data-bs-target="#edit_modal"></a></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-address">
                                                <h6>Phường/Xã:
                                                @foreach($wards as $ward)
                                                    {{ $profile->ward_id == $ward->code ? $ward->name : ''}}
                                                @endforeach <a href="javasript:void(0)" data-link-action="editmodal" title="Edit Detail" data-bs-toggle="modal" data-bs-target="#edit_modal"></a></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-address">
                                                <h6>Địa chỉ cụ thể: {{$profile->address}}<a href="javasript:void(0)" data-link-action="editmodal" title="Edit Detail" data-bs-toggle="modal" data-bs-target="#edit_modal"></a></h6>
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
    </div>
</section>
<!-- End User profile section -->
  <!-- Modal -->
  <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="ec-vendor-block-img space-bottom-30">
                        <div class="ec-vendor-block-bg cover-upload">
                            <div class="thumb-upload">
                                <div class="thumb-preview ec-preview">
                                    <div class="image-thumb-preview">
                                        <img class="image-thumb-preview ec-image-preview v-img"
                                            src="{{asset('theme/client/assets/images/banner/8.jpg')}}"alt="edit" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    <form class="row g-3" action="{{route('updateProfile',$profile->id)}}" method="post" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                        <div class="ec-vendor-block-detail">
                            <div class="thumb-upload">
                                <div class="thumb-edit">
                                    <input type='file' id="thumbUpload02" name="image" class="ec-image-upload"
                                        accept=".png, .jpg, .jpeg" />
                                    <label><i class="fi-rr-edit"></i></label>
                                </div>
                                <div class="thumb-preview ec-preview">
                                    <div class="image-thumb-preview">
                                        <img class="image-thumb-preview ec-image-preview v-img"
                                            src="{{Storage::url($profile->image)}}" alt="edit" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ec-vendor-upload-detail">
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label">Tên</label>
                                    <input type="text" name="name" class="form-control" value="{{$profile->name}}">
                                    @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control" value="{{$profile->email}}">
                                    @error('email')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="number" name="phone" class="form-control" value="{{$profile->phone}}">
                                    @error('phone')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label">Ngày sinh</label>
                                    <input type="date" name="birthday" class="form-control" value="{{$profile->birthday}}">
                                    @error('birthday')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 space-t-15">
                                <span class="ec-bill-wrap ec-bill-half">
                                    <label>Tỉnh/Thành phố </label><br>
                                    <span class="ec-bl-select-inner">
                                        <select name="province_id" id="provinceId" class="ec-bill-select province location col-md-12" data-target="districts">
                                            <option value="">[Chọn Tỉnh/Thành Phố]</option>
                                            @if (isset($provinces))
                                            @foreach($provinces as $province)
                                            <option value="{{ $province->code }}"
                                                {{ old('province_id') == $province->code ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </span>
                                </span>
                                @error('province_id')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                                </div>

                                <div class="col-md-12 space-t-15">
                                <span class="ec-bill-wrap ec-bill-half">
                                    <label>Quận/Huyện </label><br>
                                    <span class="ec-bl-select-inner">
                                        <select name="district_id" id="districtId" class="ec-bill-select districts location col-md-12" data-target="wards">
                                            <option value="">[Chọn Quận/Huyện]</option>
                                        </select><br>
                                    </span>
                                </span>
                                @error('district_id')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                                 </div>
                                <div class="col-md-12 space-t-15">
                                <span class="ec-bill-wrap ec-bill-half">
                                    <label>Phường/Xã</label><br>
                                    <span class="ec-bl-select-inner">
                                        <select id="wardId" name="ward_id"
                                            class="ec-bill-select wards col-md-12">
                                            <option value="">[Chọn Phường/Xã]</option>
                                        </select><br>
                                    </span>
                                </span>
                                @error('ward_id')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label">Địa chỉ cụ thể:</label>
                                    <input type="text" name="address" class="form-control" value="{{$profile->address}}">
                                    @error('address')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    <a href="#" class="btn btn-lg btn-secondary qty_close" data-bs-dismiss="modal"
                                        aria-label="Close">Đóng</a>
                                </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->
<script>
    var province_id = '{{ (isset($user->province_id)) ? $user->province_id : old('province_id') }}'
    var district_id = '{{ (isset($user->district_id)) ? $user->district_id : old('district_id') }}'
    var ward_id = '{{ (isset($user->ward_id)) ? $user->ward_id : old('ward_id') }}'
</script>
<script src="{{ asset('admin/library/location.js') }}"></script>
@endsection
