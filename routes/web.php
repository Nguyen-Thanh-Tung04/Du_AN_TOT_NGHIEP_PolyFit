<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\ProductColorController;
use App\Http\Controllers\Admin\UserCatalogueController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ClientProductController;
use App\Http\Controllers\admin\ReviewController;

use App\Models\Cart;
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

Route::get('/', [HomeController::class, 'welcome'])->name('home');
Route::get('/about', function () {
    return view('client.page.about');
});
Route::get('/shop', function () {
    return view('client.page.shop');
});
Route::get('/history', function () {
    return view('client.page.history');
});
Route::get('/product_detail', function () {
    return view('client.page.productDetail');
});
Route::get('/contact', function () {
    return view('client.page.contact');
});
Route::get('/account', function () {
    return view('client.page.profile');
});
// Route::get('/cart', function () {
//     return view('client.page.cart');
// })->name('cart');
Route::get('/checkout', function () {
    return view('client.page.checkout');
})->name('checkout');
Route::get('/order', function () {
    return view('client.page.order');
})->name('order');

// BACKEND ROUTES
Route::get('dashboard/index', [DashboardController::class, 'index'])
    ->name('dashboard.index')
    ->middleware('checkLogin');

// USER
Route::prefix('user/')->name('user.')->middleware('checkLogin')->group(function () {
    Route::get('index', [UserController::class, 'index'])
        ->name('index');
    Route::get('create', [UserController::class, 'create'])
        ->name('create');
    Route::post('store', [UserController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [UserController::class, 'edit'])
        ->name('edit');
    Route::get('{id}/edit', [UserController::class, 'edit'])
        ->name('edit');
    Route::post('{id}/update', [UserController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [UserController::class, 'delete'])
        ->name('delete');
    Route::delete('{id}/destroy', [UserController::class, 'destroy'])
        ->name('destroy');
});
Route::prefix('member/')->name('member.')->middleware('checkLogin')->group(function () {
    Route::get('index', [MemberController::class, 'index'])
        ->name('index');
    Route::get('create', [MemberController::class, 'create'])
        ->name('create');
    Route::post('store', [MemberController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [MemberController::class, 'edit'])
        ->name('edit');
    Route::get('{id}/edit', [MemberController::class, 'edit'])
        ->name('edit');
    Route::post('{id}/update', [MemberController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [MemberController::class, 'delete'])
        ->name('delete');
    Route::delete('{id}/destroy', [MemberController::class, 'destroy'])
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
        ->name('index');
    Route::get('create', [UserCatalogueController::class, 'create'])
        ->name('create');
    Route::post('store', [UserCatalogueController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [UserCatalogueController::class, 'edit'])
        ->name('edit');
    Route::get('{id}/edit', [UserCatalogueController::class, 'edit'])
        ->name('edit');
    Route::post('{id}/update', [UserCatalogueController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [UserCatalogueController::class, 'delete'])
        ->name('delete');
    Route::delete('{id}/destroy', [UserCatalogueController::class, 'destroy'])
        ->name('destroy');
});

// Category
Route::prefix('categories')->name('category.')->middleware('checkLogin')->group(function () {
    Route::get('index', [CategoryController::class, 'index'])->name('index');
    Route::get('create', [CategoryController::class, 'create'])
        ->name('create');
    Route::post('store', [CategoryController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [CategoryController::class, 'edit'])
        ->name('edit');
    Route::get('{id}/edit', [CategoryController::class, 'edit'])
        ->name('edit');
    Route::post('{id}/update', [CategoryController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [CategoryController::class, 'delete'])
        ->name('delete');
    Route::delete('{id}/destroy', [CategoryController::class, 'destroy'])
        ->name('destroy');
});
// reviews
Route::prefix('reviews')->name('reviews.')->middleware('checkLogin')->group(function () {
    Route::get('index', [ReviewController::class, 'index'])->name('index');
    
    Route::get('{id}/edit', [ReviewController::class, 'edit'])
        ->name('edit');
    Route::post('{id}/update', [ReviewController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [ReviewController::class, 'delete'])
        ->name('delete');
    Route::delete('{id}/destroy', [ReviewController::class, 'destroy'])
        ->name('destroy');
});
// Review reply
Route::post('reviews/{review}/reply', [ReviewController::class, 'storeReply'])->name('reviews.reply');

// voucher
Route::prefix('vouchers')->name('vouchers.')->middleware('checkLogin')->group(function () {
    Route::get('index', [VoucherController::class, 'index'])->name('index');
    Route::get('create', [VoucherController::class, 'create'])->name('create');
    Route::post('store', [VoucherController::class, 'store'])->name('store');
    Route::get('{voucher}/edit', [VoucherController::class, 'edit'])->name('edit');
    Route::put('{voucher}/update', [VoucherController::class, 'update'])->name('update');
    Route::get('{voucher}/delete', [VoucherController::class, 'delete'])->name('delete');
    Route::delete('{voucher}/destroy', [VoucherController::class, 'destroy'])->name('destroy');
});




// Products
Route::prefix('product')->name('product.')->middleware('checkLogin')->group(function () {
    Route::get('index', [ProductController::class, 'index'])
        ->name('index');
    Route::get('{id}/detail', [ProductController::class, 'detail'])
        ->name('detail');
    Route::get('create', [ProductController::class, 'create'])
        ->name('create');
    Route::post('store', [ProductController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [ProductController::class, 'edit'])
        ->name('edit');
    Route::post('{id}/update', [ProductController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [ProductController::class, 'delete'])
        ->name('delete');
    Route::delete('{id}/destroy', [ProductController::class, 'destroy'])
        ->name('destroy');
    Route::delete('{id}/destroyVariant', [ProductController::class, 'destroyVariantDetail'])
        ->name('destroyVariant');

    Route::prefix('size')->name('size.')->group(function () {
        Route::get('index', [ProductSizeController::class, 'index'])
            ->name('index');
        Route::get('create', [ProductSizeController::class, 'create'])
            ->name('create');
        Route::post('store', [ProductSizeController::class, 'store'])
            ->name('store');
        Route::get('{id}/edit', [ProductSizeController::class, 'edit'])
            ->name('edit');
        Route::post('{id}/update', [ProductSizeController::class, 'update'])
            ->name('update');
        Route::get('{id}/delete', [ProductSizeController::class, 'delete'])
            ->name('delete');
        Route::delete('{id}/destroy', [ProductSizeController::class, 'destroy'])
            ->name('destroy');
    });

    Route::prefix('color')->name('color.')->group(function () {
        Route::get('index', [ProductColorController::class, 'index'])
            ->name('index');
        Route::get('create', [ProductColorController::class, 'create'])
            ->name('create');
        Route::post('store', [ProductColorController::class, 'store'])
            ->name('store');
        Route::get('{id}/edit', [ProductColorController::class, 'edit'])
            ->name('edit');
        Route::post('{id}/update', [ProductColorController::class, 'update'])
            ->name('update');
        Route::get('{id}/delete', [ProductColorController::class, 'delete'])
            ->name('delete');
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
});

//Reviews
Route::post('/submit-review', [App\Http\Controllers\ReviewController::class, 'store']);