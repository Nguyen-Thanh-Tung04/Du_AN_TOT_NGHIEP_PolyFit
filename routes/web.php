<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\UserCatalogueController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ClientProductController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\Client\ProductCatalogueController;
use App\Http\Controllers\admin\ReviewController;
use App\Http\Controllers\Client\OrderHistoryController;
use App\Http\Controllers\User\LienheController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Client\SaleController;
use App\Models\Cart;
use App\Models\Category;

use Illuminate\Support\Facades\Route;









/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//gửi mail
Route::get('send', [LienheController::class, 'create'])->name('create');
Route::post('send', [LienheController::class, 'sendMail'])->name('sendMail');


Route::get('/forget-pass', [HomeController::class, 'forgetPass'])->name('forget');
Route::post('/forget-pass', [HomeController::class, 'postForgetPass']);
Route::get('/get-pass', [HomeController::class, 'getPass'])->name('getPass');
Route::post('/get-pass', [HomeController::class, 'postGetPass'])->name('postGetPass');


Route::get('/', [HomeController::class, 'welcome'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
// Route::get('/about', function () {
//     return view('client.page.about');
// });
Route::get('/about', [App\Http\Controllers\client\ReviewController::class, 'about_reviews_list'])->name('about');
// Lọc client
Route::get('/reviews_filter/{product_id}', [ClientProductController::class, 'filterReviews'])->name('reviews.filter');
// Route mới để xử lý phân trang đánh giá
// Route::get('/reviews/{product_id}', [ClientProductController::class, 'fetchReviews'])->name('reviews.fetch');


Route::get('/shop', [ProductCatalogueController::class, 'index'])->name('home.shop');
Route::get('/flash-sale', [SaleController::class, 'index'])->name('flash-sale');


Route::get('/history', function () {
    return view('client.page.history');
});
Route::get('/product_detail', function () {
    return view('client.page.productDetail');
});
Route::get('/contact', function () {
    return view('client.page.contact');
});

Route::get('/account', [ProfileController::class, 'listProfile'])->name('listProfile');
Route::put('/updateAccount/{idUser}', [ProfileController::class, 'updateProfile'])->name('updateProfile');
Route::get('/account', [ProfileController::class, 'listProfile'])->name('listProfile');
Route::put('/updateAccount/{idUser}', [ProfileController::class, 'updateProfile'])->name('updateProfile');
// Route::get('/changePassword/{iduser}',[ProfileController::class,'changePassword'])->name('changePassword');
// Route::patch('/updatePassword/{idUser}', [UserController::class, 'updatePassword'])->name('updatePassword');
Route::get('/changePassword', [ProfileController::class, 'changePassword'])->name('changePassword');
Route::patch('/updatePassword', [ProfileController::class, 'updatePassword'])->name('updatePassword');



Route::get('/cart', function () {
    return view('client.page.cart');
})->name('cart');
Route::get('/order', function () {
    return view('client.page.order');
})->name('order');

// Route::get('/cart', function () {
//     return view('client.page.cart');
// })->name('cart');
Route::post('/checkout', [CheckoutController::class, 'showFormCheckout'])
    ->middleware('checkLoginClient')
    ->name('checkout.show');
Route::get('/checkout', [CheckoutController::class, 'checkoutProcess'])
    ->middleware('checkLoginClient')
    ->name('checkout.process');
Route::post('/checkout/apply-voucher', [CheckoutController::class, 'applyVoucher'])
    ->middleware('checkLoginClient')
    ->name('checkout.applyVoucher');
Route::post('/checkout/available-vouchers', [CheckoutController::class, 'getAvailableVouchers'])
    ->middleware('checkLoginClient')
    ->name('checkout.availableVouchers');
Route::post('/order/store', [CheckoutController::class, 'orderStore'])
    ->middleware('checkLoginClient')
    ->name('order.store');
Route::get('/order/{id}', [CheckoutController::class, 'orderShow'])
    ->middleware('checkLoginClient')
    ->name('order.show');
Route::post('/vnpay-payment', [CheckoutController::class, 'vnpayPayment'])
    ->middleware('checkLoginClient')
    ->name('vnpay.payment');
Route::get('/vnpay/return', [CheckoutController::class, 'vnpayReturn'])->name('vnpay.return');
Route::post('/momo-payment', [CheckoutController::class, 'momoPayment'])
    ->middleware('checkLoginClient')
    ->name('momo.payment');
Route::get('/momo/return', [CheckoutController::class, 'momoReturn'])->name('momo.return');

// Chat Realtime
Route::middleware('checkLoginClient')->group(function () {
    Route::get('/list-chat', [ChatController::class, 'index'])->name('list-chat');
    Route::post('/chat-private-admin/search', [ChatController::class, 'search']);
    Route::get('/chat-private/{idUser}', [ChatController::class, 'chatPrivate'])->name('chat-private');
    Route::get('/chat-private-admin/{idUser}', [ChatController::class, 'chatPrivateAdmin'])->name('chat-private-admin');
    Route::post('/message-private', [ChatController::class, 'messagePrivate']);
    Route::post('/user-inactive', [ChatController::class, 'userInactive']);
    Route::get('/fetch-new-messages', [ChatController::class, 'fetchNewMessages'])->name('fetch.new.messages');
    Route::get('/get-unread-messages-count', [ChatController::class, 'getUnreadMessagesCount']);
});
Route::get('huongdev', function () {
    return view('admin.chat.index');
});

// BACKEND ROUTES
Route::get('dashboard/index', [DashboardController::class, 'index'])
    ->name('dashboard.index')
    ->middleware('logined');
Route::post('dashboard/index', [DashboardController::class, 'statistical_sale'])
    ->name('dashboard.post')
    ->middleware('logined');
// USER
Route::prefix('user/')->name('user.')->middleware('checkLogin')->group(function () {
    Route::get('index', [UserController::class, 'index'])
        ->name('index')
        ->middleware('checkModulePermission:user.index');
    Route::get('create', [UserController::class, 'create'])
        ->name('create')
        ->middleware('checkModulePermission:user.create');
    Route::post('store', [UserController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [UserController::class, 'edit'])
        ->name('edit')
        ->middleware('checkModulePermission:user.edit');
    Route::post('{id}/update', [UserController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [UserController::class, 'delete'])
        ->name('delete')
        ->middleware('checkModulePermission:user.delete');
    Route::delete('{id}/destroy', [UserController::class, 'destroy'])
        ->name('destroy');
});
Route::prefix('member/')->name('member.')->middleware('checkLogin')->group(function () {
    Route::get('index', [MemberController::class, 'index'])
        ->name('index')
        ->middleware('checkModulePermission:guest.index');
    Route::get('create', [MemberController::class, 'create'])
        ->name('create');
    Route::post('store', [MemberController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [MemberController::class, 'edit'])
        ->name('edit');
    Route::post('{id}/update', [MemberController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [MemberController::class, 'delete'])
        ->name('delete')
        ->middleware('checkModulePermission:guest.delete');
    Route::delete('{id}/destroy', [MemberController::class, 'destroy'])
        ->name('destroy');
    Route::get('/exportMember', [MemberController::class, 'exportMember'])->name('exportMember');
});

// USER
Route::prefix('permission/')->name('permission.')->middleware('checkLogin')->group(function () {
    Route::get('index', [PermissionController::class, 'index'])
        ->name('index')
        ->middleware('checkModulePermission:permission.index');
    Route::get('create', [PermissionController::class, 'create'])
        ->name('create')
        ->middleware('checkModulePermission:permission.create');
    Route::post('store', [PermissionController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [PermissionController::class, 'edit'])
        ->name('edit')
        ->middleware('checkModulePermission:permission.edit');
    Route::post('{id}/update', [PermissionController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [PermissionController::class, 'delete'])
        ->name('delete')
        ->middleware('checkModulePermission:permission.delete');
    Route::delete('{id}/destroy', [PermissionController::class, 'destroy'])
        ->name('destroy');
});

Route::prefix('category/')->name('category.')->middleware('checkLogin')->group(function () {
    Route::get('index', [CategoryController::class, 'index'])
        ->name('index');
    Route::get('create', [CategoryController::class, 'create'])
        ->name('create');
    Route::post('store', [CategoryController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [CategoryController::class, 'edit'])
        ->name('edit');
    Route::post('{id}/update', [CategoryController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [CategoryController::class, 'delete'])
        ->name('delete');
    Route::delete('{id}/destroy', [CategoryController::class, 'destroy'])
        ->name('destroy');
});

Route::prefix('flashsale/')->name('flashsale.')->middleware('checkLogin')->group(function () {
    Route::get('index', [FlashSaleController::class, 'index'])
        ->name('index')
        ->middleware('checkModulePermission:flashsale.index');
    Route::get('create', [FlashSaleController::class, 'create'])
        ->name('create')
        ->middleware('checkModulePermission:flashsale.create');
    Route::post('store', [FlashSaleController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [FlashSaleController::class, 'edit'])
        ->name('edit')
        ->middleware('checkModulePermission:flashsale.edit');
    Route::get('{id}/show', [FlashSaleController::class, 'show'])
        ->name('show')
        ->middleware('checkModulePermission:flashsale.detail');
    Route::put('{id}/update', [FlashSaleController::class, 'update'])
        ->name('update');
    Route::delete('{id}/destroy', [FlashSaleController::class, 'destroy'])
        ->name('destroy')
        ->middleware('checkModulePermission:flashsale.delete');
    Route::patch('/{id}/status', [FlashSaleController::class, 'updateStatus'])->name('updateStatus');
    Route::get('/get-selected-products', [ProductCatalogueController::class, 'getSelectedProducts'])->name('getSelectedProducts');
    Route::get('/get-occupied-time-slots', [FlashSaleController::class, 'getOccupiedTimeSlots'])->name('getOccupiedTimeSlots');
});

Route::prefix('flashsale')->name('flashsale.')->middleware('checkLogin')->group(function () {});

// AUTH
// Login client
Route::get('login', [AuthController::class, 'login'])
    ->name('auth.client-login');
Route::post('login-client', [AuthController::class, 'loginclient'])
    ->name('auth.login-client');

// Login admin
Route::get('admin-login', [AuthController::class, 'index'])
    ->name('auth.login');

Route::post('logined', [AuthController::class, 'logined'])
    ->name('auth.logined');
// Quên mật khẩu
Route::get('forget-password', [AuthController::class, 'forget'])->name('auth.forgot');
Route::post('forget-password', [AuthController::class, 'postForgetPass']);

// Nhập lại mật khẩu
Route::get('get-password/{customer}/{token}', [AuthController::class, 'getPass'])->name('auth.forgot');
Route::post('get-password/{customer}/{token}', [AuthController::class, 'postPass']);

Route::get('register', [AuthController::class, 'showFormRegister'])->name('auth.client.register');
Route::post('register', [AuthController::class, 'register'])->name('auth.register');

Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');


// AJAX
Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])
    ->name('ajax.location.index')
    ->middleware('checkLogin');
Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])
    ->name('ajax.dashboard.changeStatus')
    ->middleware('checkLogin');
Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, 'changeStatusAll'])
    ->name('ajax.dashboard.changeStatusAll')
    ->middleware('checkLogin');

// USER CATALOGUE
Route::prefix('user/catalogue/')->name('user.catalogue.')->middleware('checkLogin')->group(function () {
    Route::get('index', [UserCatalogueController::class, 'index'])
        ->name('index')
        ->middleware('checkModulePermission:user.catalogue.index');
    Route::get('create', [UserCatalogueController::class, 'create'])
        ->name('create')
        ->middleware('checkModulePermission:user.catalogue.create');
    Route::post('store', [UserCatalogueController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [UserCatalogueController::class, 'edit'])
        ->name('edit')
        ->middleware('checkModulePermission:user.catalogue.edit');
    Route::post('{id}/update', [UserCatalogueController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [UserCatalogueController::class, 'delete'])
        ->name('delete')
        ->middleware('checkModulePermission:user.catalogue.delete');
    Route::delete('{id}/destroy', [UserCatalogueController::class, 'destroy'])
        ->name('destroy');
    Route::get('permission', [UserCatalogueController::class, 'permission'])
        ->name('permission')
        ->middleware('checkModulePermission:user.catalogue.permission');
    Route::post('updatePermission', [UserCatalogueController::class, 'updatePermission'])
        ->name('updatePermission');
});

// Category
Route::prefix('categories')->name('category.')->middleware('checkLogin')->group(function () {
    Route::get('index', [CategoryController::class, 'index'])->name('index')
        ->middleware('checkModulePermission:category.index');
    Route::get('create', [CategoryController::class, 'create'])
        ->name('create')
        ->middleware('checkModulePermission:category.create');
    Route::post('store', [CategoryController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [CategoryController::class, 'edit'])
        ->name('edit')
        ->middleware('checkModulePermission:category.edit');
    Route::post('{id}/update', [CategoryController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [CategoryController::class, 'delete'])
        ->name('delete')
        ->middleware('checkModulePermission:category.delete');
    Route::delete('{id}/destroy', [CategoryController::class, 'destroy'])
        ->name('destroy');
});
// reviews
Route::prefix('reviews')->name('reviews.')->middleware('checkLogin')->group(function () {
    Route::get('index', [ReviewController::class, 'index'])->name('index')->middleware('checkModulePermission:review.index');
    Route::get('history', [ReviewController::class, 'history'])->name("history")->middleware('checkModulePermission:review.history');
    Route::get('history_detail/{reviewId}', [ReviewController::class, 'showReviewHistory'])->name('history_detail')->middleware('checkModulePermission:review.detail');

    Route::get('{id}/edit', [ReviewController::class, 'edit'])
        ->name('edit')->middleware('checkModulePermission:review.edit');
    Route::post('{id}/update', [ReviewController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [ReviewController::class, 'delete'])
        ->name('delete');
    Route::delete('{id}/destroy', [ReviewController::class, 'destroy'])
        ->name('destroy')->middleware('checkModulePermission:review.delete');
});
// Review reply
Route::post('reviews/{review}/reply', [ReviewController::class, 'storeReply'])->name('reviews.reply');

// voucher
Route::prefix('vouchers')->name('vouchers.')->middleware('checkLogin')->group(function () {
    Route::get('index', [VoucherController::class, 'index'])->name('index')->middleware('checkModulePermission:voucher.index');
    Route::get('create', [VoucherController::class, 'create'])->name('create')->middleware('checkModulePermission:voucher.create');
    Route::post('store', [VoucherController::class, 'store'])->name('store');
    Route::get('{voucher}/edit', [VoucherController::class, 'edit'])->name('edit')->middleware('checkModulePermission:voucher.edit');
    Route::put('{voucher}/update', [VoucherController::class, 'update'])->name('update');
    Route::get('{voucher}/delete', [VoucherController::class, 'delete'])->name('delete');
    Route::delete('{voucher}/destroy', [VoucherController::class, 'destroy'])->name('destroy')->middleware('checkModulePermission:voucher.delete');
});
// banner
Route::prefix('banners')->name('banner.')->middleware('checkLogin')->group(function () {
    Route::get('index', [BannerController::class, 'index'])->name('index')->middleware('checkModulePermission:banner.index');
    Route::get('create', [BannerController::class, 'create'])->name('create')->middleware('checkModulePermission:banner.create');
    Route::post('store', [BannerController::class, 'store'])->name('store');
    Route::get('edit/{id}', [BannerController::class, 'edit'])->name('edit')->middleware('checkModulePermission:banner.edit');
    Route::put('update/{id}', [BannerController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [BannerController::class, 'delete'])->name('delete')->middleware('checkModulePermission:banner.delete');
});
Route::prefix('orders')->name('orders.')->middleware('checkLogin')->group(function () {
    Route::get('index',                 [OrderController::class, 'index'])->name('index')->middleware('checkModulePermission:order.index');
    Route::get('/show/{id}',        [OrderController::class, 'show'])->name('show')->middleware('checkModulePermission:order.detail');
    Route::put('{id}/update',       [OrderController::class, 'update'])->name('update')->middleware('checkModulePermission:order.edit');
    Route::delete('{id}/destroy',   [OrderController::class, 'destroy'])->name('destroy')->middleware('checkModulePermission:order.delete');
    Route::get('/export', [OrderController::class, 'exportOrders'])->name('export')->middleware('checkModulePermission:order.export');
    Route::get('/exportPDF/{id}', [OrderController::class, 'exportPDF'])->name('exportPDF');
    
});
Route::middleware(['checkLoginClient'])->group(function () {
    Route::get('/history', [OrderHistoryController::class, 'index'])->name('order.history');
    Route::get('/history/{id}', [OrderHistoryController::class, 'show'])->name('order.history.show');
    Route::put('/history/{id}', [OrderHistoryController::class, 'update'])->name('order.history.update');
});


// Products
Route::prefix('product')->name('product.')->middleware('checkLogin')->group(function () {
    Route::get('index', [ProductController::class, 'index'])
        ->name('index')
        ->middleware('checkModulePermission:product.index');
    Route::get('{id}/detail', [ProductController::class, 'detail'])
        ->name('detail')
        ->middleware('checkModulePermission:product.detail');
    Route::get('create', [ProductController::class, 'create'])
        ->name('create')
        ->middleware('checkModulePermission:product.create');
    Route::post('store', [ProductController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [ProductController::class, 'edit'])
        ->name('edit')
        ->middleware('checkModulePermission:product.edit');
    Route::post('{id}/update', [ProductController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [ProductController::class, 'delete'])
        ->name('delete')
        ->middleware('checkModulePermission:product.delete');
    Route::delete('{id}/destroy', [ProductController::class, 'destroy'])
        ->name('destroy');
    Route::delete('{id}/destroyVariant', [ProductController::class, 'destroyVariantDetail'])
        ->name('destroyVariant');

    Route::prefix('size')->name('size.')->group(function () {
        Route::get('index', [ProductSizeController::class, 'index'])
            ->name('index')
            ->middleware('checkModulePermission:size.index');
        Route::get('create', [ProductSizeController::class, 'create'])
            ->name('create')
            ->middleware('checkModulePermission:size.create');
        Route::post('store', [ProductSizeController::class, 'store'])
            ->name('store');
        Route::get('{id}/edit', [ProductSizeController::class, 'edit'])
            ->name('edit')
            ->middleware('checkModulePermission:size.edit');
        Route::post('{id}/update', [ProductSizeController::class, 'update'])
            ->name('update');
        Route::get('{id}/delete', [ProductSizeController::class, 'delete'])
            ->name('delete')
            ->middleware('checkModulePermission:size.delete');
        Route::delete('{id}/destroy', [ProductSizeController::class, 'destroy'])
            ->name('destroy');
    });

    Route::prefix('color')->name('color.')->group(function () {
        Route::get('index', [ProductColorController::class, 'index'])
            ->name('index')
            ->middleware('checkModulePermission:color.index');
        Route::get('create', [ProductColorController::class, 'create'])
            ->name('create')
            ->middleware('checkModulePermission:color.create');
        Route::post('store', [ProductColorController::class, 'store'])
            ->name('store');
        Route::get('{id}/edit', [ProductColorController::class, 'edit'])
            ->name('edit')
            ->middleware('checkModulePermission:color.edit');
        Route::post('{id}/update', [ProductColorController::class, 'update'])
            ->name('update');
        Route::get('{id}/delete', [ProductColorController::class, 'delete'])
            ->name('delete')
            ->middleware('checkModulePermission:color.delete');
        Route::delete('{id}/destroy', [ProductColorController::class, 'destroy'])
            ->name('destroy');
    });
});

Route::get('/product/variant-details', [ClientProductController::class, 'getVariantDetails'])->name('client.product.variant');
Route::get('/product/{id}', [ClientProductController::class, 'show'])->name('client.product.show');

Route::prefix('cart')->name('cart.')->middleware('checkLoginClient')->group(function () {
    Route::get('', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'addToCart'])->name('add');
    Route::put('/update', [CartController::class, 'updateCart'])->name('update');
    Route::delete('/delete', [CartController::class, 'deleteCartItem'])->name('delete');
    Route::get('/calculate', [CartController::class, 'calculateTotal'])->name('calculate');
    Route::post('/save-selected', [CartController::class, 'saveSelectedItems'])->name('selected');
    Route::get('/count', [CartController::class, 'countCartItems'])->name('count');
});


//Reviews
Route::post('/submit-review', [App\Http\Controllers\client\ReviewController::class, 'store']);

// Route để xem đánh giá cho một đơn hàng cụ thể
Route::get('/reviews/{orderId}', [App\Http\Controllers\client\ReviewController::class, 'getReviews']);