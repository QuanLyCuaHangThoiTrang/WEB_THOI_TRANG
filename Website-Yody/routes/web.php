<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Account_Controller;
use App\Http\Controllers\Register_Controller;
use App\Http\Controllers\Login_Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactUs_Controller;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AboutUs_Controller;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\ProviderController;

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
Route::get('/home', [HomeController::class, 'home'])->name(name: 'home');

// Sản phẩm
Route::get('/products', [ShopController::class, 'index'])->name('products.index');
Route::get('/products/{MaCTDM}', [ShopController::class, 'showProducts'])->name('products.show');

// Chi tiết sản phẩm
Route::get('/product_detail', [ProductDetailController::class,'index']);
Route::get('/product_detail/{MaSP}', [ProductDetailController::class, 'index']);
Route::get('/test_endpoint/{MaMau}', [ProductDetailController::class, 'getProductDetails']);
Route::get('/get-sizes-by-color/{MaMau}/{MaSP}', [ProductDetailController::class, 'getSizesByColor']);
Route::get('/test_endpointa/{MaSP}/{MaSize}/{MaMau}', [ProductDetailController::class, 'getProductDetails1']);
Route::get('/get-image', [ProductDetailController::class, 'getImageByMaSPAndMaMau']);

// Các route liên hệ và giới thiệu
Route::get('/about-us', [AboutUs_Controller::class, 'about'])->name('about');
Route::get('/contact-us', [ContactUs_Controller::class, 'contact'])->name('contact');

// Các route giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/remove/{MaGH}/{MaCTSP}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/remove/{MaCTSP}', [CartController::class, 'removeFromCartSS'])->name('cart.removeSS');
Route::get('/cart/removeall', [CartController::class, 'removeAllart'])->name('cart.removeAll');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');

// Các route đăng nhập
Route::get('login', [Login_Controller::class, 'showLoginForm'])->name('login');
Route::post('/login', [Login_Controller::class,'postLogin'])->name('login.postLogin');
Route::get('account/{MaKH}', [Account_Controller::class, 'showAccountForm'])->middleware('auth');

// Các route đăng ký
Route::get('/register', [Register_Controller::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [Register_Controller::class, 'register'])->name('register');


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
