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
                        <h2 class="ec-breadcrumb-title">Register</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="ec-breadcrumb-item active">Register</li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->

<!-- Start Register -->
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">Register</h2>
                    <h2 class="ec-title">Register</h2>
                    <p class="sub-title mb-3">Best place to buy and sell digital products</p>
                </div>
            </div>
            <div class="ec-register-wrapper">
                <div class="ec-register-container">
                    <div class="ec-register-form">
                        <form action="#" method="post">
                            <span class="ec-register-wrap ec-register-half">
                                <label>First Name*</label>
                                <input type="text" name="firstname" placeholder="Enter your first name" required />
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>Last Name*</label>
                                <input type="text" name="lastname" placeholder="Enter your last name" required />
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>Email*</label>
                                <input type="email" name="email" placeholder="Enter your email add..." required />
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>Phone Number*</label>
                                <input type="text" name="phonenumber" placeholder="Enter your phone number"
                                    required />
                            </span>
                            <span class="ec-register-wrap">
                                <label>Address</label>
                                <input type="text" name="address" placeholder="Address Line 1" />
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>City *</label>
                                <span class="ec-rg-select-inner">
                                    <select name="ec_select_city" id="ec-select-city" class="ec-register-select">
                                        <option selected disabled>City</option>
                                        <option value="1">City 1</option>
                                        <option value="2">City 2</option>
                                        <option value="3">City 3</option>
                                        <option value="4">City 4</option>
                                        <option value="5">City 5</option>
                                    </select>
                                </span>
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>Post Code</label>
                                <input type="text" name="postalcode" placeholder="Post Code" />
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>Country *</label>
                                <span class="ec-rg-select-inner">
                                    <select name="ec_select_country" id="ec-select-country"
                                        class="ec-register-select">
                                        <option selected disabled>Country</option>
                                        <option value="1">Country 1</option>
                                        <option value="2">Country 2</option>
                                        <option value="3">Country 3</option>
                                        <option value="4">Country 4</option>
                                        <option value="5">Country 5</option>
                                    </select>
                                </span>
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>Region State</label>
                                <span class="ec-rg-select-inner">
                                    <select name="ec_select_state" id="ec-select-state" class="ec-register-select">
                                        <option selected disabled>Region/State</option>
                                        <option value="1">Region/State 1</option>
                                        <option value="2">Region/State 2</option>
                                        <option value="3">Region/State 3</option>
                                        <option value="4">Region/State 4</option>
                                        <option value="5">Region/State 5</option>
                                    </select>
                                </span>
                            </span>
                            <span class="ec-register-wrap ec-recaptcha">
                                <span class="g-recaptcha" data-sitekey="6LfKURIUAAAAAO50vlwWZkyK_G2ywqE52NU7YO0S"
                                    data-callback="verifyRecaptchaCallback"
                                    data-expired-callback="expiredRecaptchaCallback"></span>
                                <input class="form-control d-none" data-recaptcha="true" required
                                    data-error="Please complete the Captcha">
                                <span class="help-block with-errors"></span>
                            </span>
                            <span class="ec-register-wrap ec-register-btn">
                                <button class="btn btn-primary" type="submit">Register</button>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Register -->
@endsection
