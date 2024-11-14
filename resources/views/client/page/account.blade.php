@extends('client.layouts.master')

@section('content')
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
                                        <li><a href="user-history.html">Lịch sử</a></li>
                                        <li><a href="wishlist.html">Danh sách yêu thích</a></li>
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
                                                <a href="#" class="btn btn-lg btn-primary"
                                                    data-link-action="editmodal" title="Edit Detail" data-bs-toggle="modal"
                                                    data-bs-target="#edit_modal">Chỉnh sửa chi tiết</a>
                                            </div>
                                            <div class="ec-vendor-block-detail">
                                                <img class="v-img" src="assets/images/user/1.jpg" alt="vendor image">
                                                <h5 class="name">Hùng</h5>
                                                <p>( doanh nhân )</p>
                                            </div>
                                            <p>Xin chào <span>Hùng!</span></p>
                                            <p>Từ tài khoản của bạn, bạn có thể dễ dàng xem và theo dõi đơn hàng. Bạn có thể
                                                quản lý và thay đổi thông tin tài khoản của mình như địa chỉ, thông tin liên
                                                hệ và lịch sử đơn hàng.</p>
                                        </div>
                                        <h5>Thông tin tài khoản</h5>

                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="ec-vendor-detail-block ec-vendor-block-email space-bottom-30">
                                                    <h6>Địa chỉ email <a href="javasript:void(0)"
                                                            data-link-action="editmodal" title="Edit Detail"
                                                            data-bs-toggle="modal" data-bs-target="#edit_modal"><i
                                                                class="fi-rr-edit"></i></a></h6>
                                                    <ul>
                                                        <li><strong>Email 1 : </strong>support1@exapmle.com</li>
                                                        <li><strong>Email 2 : </strong>support2@exapmle.com</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="ec-vendor-detail-block ec-vendor-block-contact space-bottom-30">
                                                    <h6>Số điện thoại<a href="javasript:void(0)"
                                                            data-link-action="editmodal" title="Edit Detail"
                                                            data-bs-toggle="modal" data-bs-target="#edit_modal"><i
                                                                class="fi-rr-edit"></i></a></h6>
                                                    <ul>
                                                        <li><strong>Số điện thoại 1 : </strong>(84) 123 456 7890</li>
                                                        <li><strong>Số điện thoại 2 : </strong>(84) 123 456 7890</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="ec-vendor-detail-block ec-vendor-block-address mar-b-30">
                                                    <h6>Địa chỉ<a href="javasript:void(0)" data-link-action="editmodal"
                                                            title="Edit Detail" data-bs-toggle="modal"
                                                            data-bs-target="#edit_modal"><i class="fi-rr-edit"></i></a></h6>
                                                    <ul>
                                                        <li><strong>Trang chủ : </strong>Số 3 Phương canh , Nam Từ Niêm Hà Nội</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="ec-vendor-detail-block ec-vendor-block-address">
                                                    <h6>Địa chỉ giao hàng<a href="javasript:void(0)"
                                                            data-link-action="editmodal" title="Edit Detail"
                                                            data-bs-toggle="modal" data-bs-target="#edit_modal"><i
                                                                class="fi-rr-edit"></i></a></h6>
                                                    <ul>
                                                        <li><strong>Văn phòng : </strong>Số 3 Phương canh , Nam Từ Niêm Hà Nội</li>
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
        </div>
    </section>
@endsection
