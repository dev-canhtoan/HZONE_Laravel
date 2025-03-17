<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CateController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OnlPaymentController;
use App\Http\Controllers\OrderController;


Route::get('home', [ProductController::class, 'getAllProductsHome'])->name('home');

Route::get('product', [ProductController::class, 'getAllProductsPage'])->name('allProductsPage');

Route::get('product-info-page/{id}', [ProductController::class, 'getProductPage'])->name('product-info-page');

Route::post('/search', [ProductController::class, 'liveSearch']);

Route::post('/search-product', [ProductController::class, 'search'])->name('search');

Route::get('signup', [UserController::class, 'showFormSignup']);

Route::post('signup', [UserController::class, 'signUp'])->name('signup');

Route::get('verify', [UserController::class, 'showVerifyForm'])->name('verify')->middleware('verify');

Route::post('verify', [UserController::class, 'verify'])->name('verify-cfm')->middleware('verify');

Route::post('resend-verify', [UserController::class, 'resendVerification'])->name('resend')->middleware('verify');

Route::get('reset-pass', [UserController::class, 'showResetForm'])->name('reset-pass');

Route::post('reset-pass', [UserController::class, 'resetPass'])->name('reset-cfm');

Route::get('login', [UserController::class, 'showFormLogin'])->name('login');

Route::post('login', [UserController::class, 'login']);

Route::get('/google-login', [UserController::class, 'redirectToGoogle'])->name('google-login');

Route::get('/google/callback', [UserController::class, 'handleGoogleCallback']);

Route::get('/facebook-login', [UserController::class, 'redirectToFacebook'])->name('fb-login');

Route::get('/facebook/callback', [UserController::class, 'handleFacebookCallback']);

Route::middleware(['auth'])->group(function () {
    Route::get('cart',  [CartController::class, 'showCart'])->name('cart');
    Route::post('/add-to-cart', [CartController::class, 'addToCart']);
    Route::post('/update-product-quantity', [CartController::class, 'updateProductQuantity']);
    Route::delete('/remove-product', [CartController::class, 'removeProduct']);
    Route::post('/buy-now', [CartController::class, 'buyNow']);
    Route::post('/cancel-buynow', [CartController::class, 'cancelBuynow']);
    Route::get('/cheackout', function () {
        return view('checkout');
    })->name('checkout')->middleware('checkoutConditions');
    Route::post('/checkout', [OrderController::class, 'confirmOrder'])->name('checkout-confirm')->middleware('checkoutConditions');
    Route::post('/vnpay_payment',  [OnlPaymentController::class, 'vnpay_payment'])->name('vnpay')->middleware('checkoutConditions');
    Route::post('/momo_payment',  [OnlPaymentController::class, 'momo_payment'])->name('momo')->middleware('checkoutConditions');
    Route::post('/zalo_payment',  [OnlPaymentController::class, 'zalo_payment'])->name('zalo')->middleware('checkoutConditions');
    Route::get('/profile', [OrderController::class, 'showPersonalOrder'])->name('profile');
    Route::post('/profile/update-user/{id}', [UserController::class, 'updateUser'])->name('update-user-profile');
    Route::prefix('admin')->group(function () {
        Route::get('getOrderDetail/{id}', [OrderController::class, 'getOrderDetail']);
    });
    Route::post('rate', [ProductController::class, 'rate'])->name('rate');
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('feedback', [HomeController::class, 'feedback'])->name('feedback');
});

Route::middleware(['checkRole:2'])->prefix('admin')->group(function () {
    Route::get('home', function () {
        return view('admin/home');
    })->name('adminHome');
    Route::get('home/getInfo', [OrderController::class, 'getDashboardDetail']);
    Route::get('/export-orders', [ExcelController::class, 'exportOrders'])->name('export-orders');

    Route::prefix('category')->group(function () {
        Route::get('/', [CateController::class, 'index'])->name('adminCate');
        Route::post('create-cate', [CateController::class, 'addCate'])->name('create-cate');
        Route::get('get-cate-info/{id}', [CateController::class, 'getCateId']);
        Route::post('update/{id}', [CateController::class, 'updateCate']);
        Route::delete('delete/{id}', [CateController::class, 'deleteCate'])->name('delete-cate');
        Route::match(['get', 'post'], 'cate-search', [CateController::class, 'adminsearch'])->name('cate-search');
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'adminPro'])->name('adminPro');
        Route::post('create-product', [ProductController::class, 'addProduct'])->name('create-product');
        Route::get('get-product-info/{id}', [ProductController::class, 'getProductInfo']);
        Route::post('update/{id}', [ProductController::class, 'updateProduct']);
        Route::delete('delete/{id}', [ProductController::class, 'deleteProduct'])->name('delete-product');
        Route::match(['get', 'post'], 'pro-search', [ProductController::class, 'adminSearch'])->name('pro-search');
    });

    Route::get('customer', [UserController::class, 'customers'])->name('adminCus');
    
    Route::get('admin', [UserController::class, 'admin'])->name('adminAdm');
    
    Route::match(['get', 'post'], 'customer/cus-search', [UserController::class, 'adminSearchCus'])->name('cus-search');

    Route::match(['get', 'post'], 'admin/adm-search', [UserController::class, 'adminSearchAdm'])->name('adm-search');

    Route::prefix('user')->group(function () {
        Route::get('get-user-info/{id}', [UserController::class, 'getUserInfo']);
        Route::post('create-user', [UserController::class, 'addUser'])->name('create-user');
        Route::post('update/{id}', [UserController::class, 'updateUser']);
        Route::delete('delete/{id}', [UserController::class, 'deleteUser'])->name('delete-user');
    });
    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class, 'getAllOrder'])->name('adminOrder');
        Route::delete('delete/{id}', [OrderController::class, 'deleteOrder'])->name('delete-order');
        Route::put('/update-order-status/{id}', [OrderController::class, 'updateStatus']);
        Route::match(['get', 'post'], 'order-search', [OrderController::class, 'adminSearch'])->name('order-search');
    });
    Route::prefix('discount')->group(function () {
        Route::get('/', [DiscountController::class, 'getAllDis'])->name('adminDis');
        Route::get('get-dis-info/{id}', [DiscountController::class, 'getDisInfo']);
        Route::post('create-dis', [DiscountController::class, 'addDisCount'])->name('create-dis');
        Route::post('update/{id}', [DiscountController::class, 'updateDis']);
        Route::delete('delete/{id}', [DiscountController::class, 'deleteDis'])->name('delete-dis');
        Route::match(['get', 'post'], 'dis-search', [DiscountController::class, 'adminSearch'])->name('dis-search');
    });
    Route::get('order/{id}/export-pdf', [OrderController::class, 'exportPDF'])->name('export-pdf');
});