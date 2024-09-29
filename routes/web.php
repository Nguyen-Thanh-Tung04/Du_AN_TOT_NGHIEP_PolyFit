<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserCatalogueController;

use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Ajax\LocationController;
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

Route::get('/', function () {
    return view('welcome');
});
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
    return view('client.page.product-detail');
});
Route::get('/contact', function () {
    return view('client.page.contact');
});
Route::get('/account', function () {
    return view('client.page.profile');
});
Route::get('/cart', function () {
    return view('client.page.cart');
})->name('cart');
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
Route::get('login', [AuthController::class, 'index'])
    ->name('auth.login');

Route::post('logined', [AuthController::class, 'logined'])
    ->name('auth.logined');

Route::get('register', [AuthController::class, 'showFormRegister']);
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

// Products
Route::prefix('product')->name('product.')->middleware('checkLogin')->group(function () {
    Route::get('index', [ProductController::class, 'index'])
    ->name('index');
    Route::get('create', [ProductController::class, 'create'])
        ->name('create');
    Route::post('store', [ProductController::class, 'store'])
        ->name('store');
    Route::get('{id}/edit', [ProductController::class, 'edit'])
        ->name('edit');
    Route::get('{id}/edit', [ProductController::class, 'edit'])
        ->name('edit');
    Route::post('{id}/update', [ProductController::class, 'update'])
        ->name('update');
    Route::get('{id}/delete', [ProductController::class, 'delete'])
        ->name('delete');
    Route::delete('{id}/destroy', [ProductController::class, 'destroy'])
        ->name('destroy');
});