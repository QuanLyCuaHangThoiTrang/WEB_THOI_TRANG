<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Home\AboutUsController;
use App\Http\Controllers\Home\ContactUsController;


use App\Http\Controllers\Registration\RegisterController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\AddressController;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Account\VoucherController;
use App\Mail\WelcomeMail;
use App\Models\KhachHang;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
 
Route::get('/auth/{provider}/redirect', [ProviderController::class,'redirect']);
 
Route::get('/auth/{provider}/callback', [ProviderController::class,'callback']);

// Trang chủ
Route::get('/', function () {
    return view('layouts.app');
});

// Trang chính
Route::get('/', function () {return view('home.home');});
Route::get('/', [HomeController::class, 'home'])->name('home');


Route::resource('/products', ShopController::class);

Route::get('/about-us', [AboutUsController::class, 'about'])->name('about');
Route::get('/contact-us', [ContactUsController::class, 'contact'])->name('contact');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/remove/{MaGH}/{MaCTSP}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/remove/{MaCTSP}', [CartController::class, 'removeFromCartSS'])->name('cart.removeSS');
Route::get('/cart/removeall', [CartController::class, 'removeAllart'])->name('cart.removeAll');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');


Route::get('/home', [HomeController::class, 'home'])->name(name: 'home');

// Sản phẩm
Route::get('/products', [ShopController::class, 'index'])->name('products.index');
Route::get('/products/{MaCTDM}', [ShopController::class, 'showProducts'])->name('products.show');


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class,'postLogin'])->name('login.postLogin');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::post('/checkoutDH', [CheckoutController::class, 'processCheckoutDH'])->name('checkout.processDH');


Route::get('/product_detail', [ProductDetailController::class,'index']);
Route::get('/product_detail/{MaSP}', [ProductDetailController::class, 'index']);
Route::get('/test_endpoint/{MaMau}', [ProductDetailController::class, 'getProductDetails']);
Route::get('/get-sizes-by-color/{MaMau}/{MaSP}', [ProductDetailController::class, 'getSizesByColor']);
Route::get('/test_endpointa/{MaSP}/{MaSize}/{MaMau}', [ProductDetailController::class, 'getProductDetails1']);
Route::get('/get-image', [ProductDetailController::class, 'getImageByMaSPAndMaMau']);



// Các route giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/remove/{MaGH}/{MaCTSP}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/remove/{MaCTSP}', [CartController::class, 'removeFromCartSS'])->name('cart.removeSS');
Route::get('/cart/removeall', [CartController::class, 'removeAllart'])->name('cart.removeAll');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');


// Các route thanh toán
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkoutDH', [CheckoutController::class, 'processCheckoutDH'])->name('checkout.processDH');
Route::post('/Voucher', [CheckoutController::class, 'applyVoucher'])->name('checkout.applyVoucher');
Route::post('/voucher/cancel', [CheckoutController::class, 'cancelVoucher'])->name('voucher.cancel');

// Route đăng xuất
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Thanh toán momo
Route::get('/momo/response', [CheckoutController::class, 'handleMomoResponse'])->name('momo.response');
Route::get('/ThanhToanThanhCong', [CheckoutController::class, 'ThanhToanThanhCong'])->name('thanhtoan.ThanhCong');

Route::get('account/{MaKH}', [AccountController::class, 'showAccountForm'])->middleware('auth');
Route::put('/account/{MaKH}/password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');
Route::put('/account/{MaKH}/update-account', [AccountController::class, 'updateAccount'])->name('account.updateAccount');
Route::delete('/account/delete/{MaKH}', [AccountController::class, 'deleteAccount'])->name('account.delete');



// Route for displaying addresses
Route::middleware(['auth'])->group(function () {
    Route::get('/addresses/{MaKH}', [AddressController::class, 'showAddresses'])->name('account.settings.addresses');
    Route::post('/addresses', [AddressController::class, 'createAddress'])->name('addresses.create');
    Route::delete('/addresses/{MaKH}', [AddressController::class, 'deleteAddress'])->name('addresses.delete');
    Route::get('/vouchers/{MaKH}', [VoucherController::class, 'showCustomerVouchers'])->name('account.settings.vouchers');

});



Route::get('password/forgot', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.reset');


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');