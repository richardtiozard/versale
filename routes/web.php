<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\SellerRatingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::post('/register/check', [RegisterController::class, 'check']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/feedbacks/create', [FeedbackController::class, 'create'])->name('feedbacks.create');
    Route::post('/feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');

});

Route::group(['middleware' => ['auth','buyer','user.active']], function () {
    Route::get('/buyer/profile', [BuyerController::class, 'index'])->name('buyer.index');
    Route::put('/buyer/profile/update', [BuyerController::class, 'update'])->name('buyer.update');
    Route::post('/buyer/profile/uploadimage', [BuyerController::class, 'uploadImage'])->name('buyer.uploadImage');

    Route::get('/requests', [RequestController::class, 'index'])->name('request.index');
    Route::get('/requests/create', [RequestController::class, 'createIndex'])->name('request.createindex');
    Route::post('/requests/create', [RequestController::class, 'create'])->name('request.create');
    Route::delete('/requests', [RequestController::class, 'destroy'])->name('request.destroy');
    
    Route::get('/requests/offers/{id}', [OfferController::class, 'show'])->name('offer.show');

    Route::get('/checkout/{id}', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment', [PaymentController::class, 'create'])->name('payment.create');

    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');

    Route::post('/sellerratings', [SellerRatingController::class, 'create'])->name('sellerrating.create');
});

Route::group(['middleware' => ['auth','seller','user.active']], function () {
    Route::get('/seller/profile', [SellerController::class, 'index'])->name('seller.index');
    Route::put('/seller/profile/update', [SellerController::class, 'update'])->name('seller.update');
    Route::post('/seller/profile/uploadimage', [SellerController::class, 'uploadImage'])->name('seller.uploadImage');

    Route::get('/seller/dashboard', [SellerController::class, 'overview'])->name('seller.overview');

    Route::get('/seller/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/seller/products/create', [ProductController::class, 'createIndex'])->name('product.createindex');
    Route::post('/seller/products/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/seller/products/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/seller/products', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/seller/requests', [RequestController::class, 'sellerIndex'])->name('seller.request.index');
    Route::get('/seller/requests/{id}', [RequestController::class, 'sellerShow'])->name('seller.request.show');
    
    Route::get('/seller/offers', [OfferController::class, 'index'])->name('offer.index');
    Route::post('/seller/offers', [OfferController::class, 'create'])->name('offer.create');
    Route::delete('/seller/offers', [OfferController::class, 'destroy'])->name('offer.destroy');

    Route::get('/seller/orders', [OrderController::class, 'sellerIndex'])->name('seller.order.index');
    Route::put('/seller/orders', [OrderController::class, 'update'])->name('seller.order.update');

});

Route::group(['middleware' => ['auth','admin','user.active']], function () {
    Route::get('/admin/profile', [AdminController::class, 'index'])->name('admin.index');
    Route::put('/admin/profile/update', [AdminController::class, 'update'])->name('admin.update');
    Route::post('/admin/profile/uploadimage', [AdminController::class, 'uploadImage'])->name('admin.uploadImage');

    Route::get('/admin/dashboard', [AdminController::class, 'overview'])->name('admin.overview');

    Route::get('/admin/users', [AdminController::class, 'userIndex'])->name('admin.user.index');
    Route::put('/admin/users', [AdminController::class, 'userUpdate'])->name('admin.user.update');
    Route::get('/admin/users/register', [AdminController::class, 'userCreateIndex'])->name('admin.user.createIndex');
    Route::post('/admin/users/register', [AdminController::class, 'userCheck'])->name('admin.user.check');
    Route::post('/admin/users/create', [AdminController::class, 'userCreate'])->name('admin.user.create');

    Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::put('/feedbacks', [FeedbackController::class, 'update'])->name('feedbacks.update');
});



