@extends('client.layouts.master')

@section('content')

<!-- ekka Cart Start -->
<div class="ec-side-cart-overlay"></div>
<div id="ec-side-cart" class="ec-side-cart">
    <div class="ec-cart-inner">
        <div class="ec-cart-top">
            <div class="ec-cart-title">
                <span class="cart_title">My Cart</span>
                <button class="ec-close">×</button>
            </div>
            <ul class="eccart-pro-items">
                <li>
                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                            src="assets/images/product-image/6_1.jpg" alt="product"></a>
                    <div class="ec-pro-content">
                        <a href="product-left-sidebar.html" class="cart_pro_title">T-shirt For Women</a>
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
                        <a href="product-left-sidebar.html" class="cart_pro_title">Women Leather Shoes</a>
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
                        <a href="product-left-sidebar.html" class="cart_pro_title">Girls Nylon Purse</a>
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
                            <td class="text-left">Sub-Total :</td>
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
                <a href="cart.html" class="btn btn-primary">View Cart</a>
                <a href="checkout.html" class="btn btn-secondary">Checkout</a>
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
                        <h2 class="ec-breadcrumb-title">User Profile</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="ec-breadcrumb-item active">Profile</li>
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
                                    <li><a href="user-profile.html">User Profile</a></li>
                                    <li><a href="user-history.html">History</a></li>
                                    <li><a href="wishlist.html">Wishlist</a></li>
                                    <li><a href="cart.html">Cart</a></li>
                                    <li><a href="checkout.html">Checkout</a></li>
                                    <li><a href="track-order.html">Track Order</a></li>
                                    <li><a href="user-invoice.html">Invoice</a></li>
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
                                @foreach ($profile as $profile )
                                <div class="ec-vendor-block-profile">
                                    <div class="ec-vendor-block-img space-bottom-30">
                                        <div class="ec-vendor-block-bg">
                                            <a href="#" class="btn btn-lg btn-primary"
                                                data-link-action="editmodal" title="Edit Detail"
                                                data-bs-toggle="modal" data-bs-target="#edit_modal">Chỉnh sửa</a>
                                        </div>
                                        <div class="ec-vendor-block-detail">
                                            <img class="v-img" src="assets/images/user/1.jpg" alt="vendor image">
                                            <h5 class="name">{{$profile->name}}</h5>

                                        </div>
                                        <p>Xin Chào<span> {{$profile->name}}</span></p>
                                        <p>Từ tài khoản của bạn, bạn có thể dễ dàng xem và theo dõi đơn hàng. Bạn có thể quản lý và thay đổi thông tin tài khoản của mình như địa chỉ, thông tin liên hệ và lịch sử đơn hàng.</p>
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
                                                <h6>Địa chỉ: {{$profile->ward_id}}, {{$profile->district_id}}, {{$profile->province_id}}<a href="javasript:void(0)" data-link-action="editmodal" title="Edit Detail" data-bs-toggle="modal" data-bs-target="#edit_modal"></a></h6>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            @endforeach
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
                                            src="{{asset('theme/client/assets/images/banner/8.jpg')}}" alt="edit" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ec-vendor-block-detail">
                            <div class="thumb-upload">
                                <div class="thumb-edit">
                                    <input type='file' id="thumbUpload02" class="ec-image-upload"
                                        accept=".png, .jpg, .jpeg" />
                                    <label><i class="fi-rr-edit"></i></label>
                                </div>
                                <div class="thumb-preview ec-preview">
                                    <div class="image-thumb-preview">
                                        <img class="image-thumb-preview ec-image-preview v-img"
                                            src="assets/images/user/1.jpg" alt="edit" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ec-vendor-upload-detail">
                            <form class="row g-3" action="{{route('updateProfile',$profile->id)}}" method="post" enctype="multipart/form-data">
                                @method('patch')
                                @csrf
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label">Tên</label>
                                    <input type="text" name="name" class="form-control" value="{{$profile->name}}">
                                </div>
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control" value="{{$profile->email}}">
                                </div>
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label">Mật khẩu</label>
                                    <input type="password" disabled class="form-control">
                                </div>
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="number" name="phone" class="form-control" value="{{$profile->phone}}">
                                </div>
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label">Ngày sinh</label>
                                    <input type="text" name="birthday" class="form-control" value="{{$profile->birthday}}">
                                </div>
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control" value="{{$profile->ward_id}}, {{$profile->district_id}}, {{$profile->province_id}}">
                                </div>
                                <div class="col-md-6 space-t-15">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    <a href="#" class="btn btn-lg btn-secondary qty_close" data-bs-dismiss="modal"
                                        aria-label="Close">Đóng</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->
@endsection
