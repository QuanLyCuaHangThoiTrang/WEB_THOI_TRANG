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

Route::get('/', function () {
    return view('layouts.app');
});

Route::get('/', function () {
    return view('home.home');
});



Route::get('/', [HomeController::class, 'home'])->name('home');


Route::resource('/products', ShopController::class);

Route::get('/about-us', [AboutUs_Controller::class, 'about'])->name('about');
Route::get('/contact-us', [ContactUs_Controller::class, 'contact'])->name('contact');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/remove/{MaGH}/{MaCTSP}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/remove/{MaCTSP}', [CartController::class, 'removeFromCartSS'])->name('cart.removeSS');
Route::get('/cart/removeall', [CartController::class, 'removeAllart'])->name('cart.removeAll');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');


Route::get('/home', [HomeController::class, 'home'])->name(name: 'home');


Route::get('login', [Login_Controller::class, 'showLoginForm'])->name('login');
Route::post('/login', [Login_Controller::class,'postLogin'])->name('login.postLogin');

Route::get('/register', [Register_Controller::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [Register_Controller::class, 'register'])->name('register');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::post('/checkoutDH', [CheckoutController::class, 'processCheckoutDH'])->name('checkout.processDH');

Route::get('/product_detail', [ProductDetailController::class,'index']);
Route::get('/product_detail/{MaSP}', [ProductDetailController::class, 'index']);
Route::get('/test_endpoint/{MaMau}', [ProductDetailController::class, 'getProductDetails']);
Route::get('/get-sizes-by-color/{MaMau}/{MaSP}', [ProductDetailController::class, 'getSizesByColor']);
Route::get('/test_endpointa/{MaSP}/{MaSize}/{MaMau}', [ProductDetailController::class, 'getProductDetails1']);
Route::get('/get-image', [ProductDetailController::class, 'getImageByMaSPAndMaMau']);

Route::get('account/{MaKH}', [Account_Controller::class, 'showAccountForm'])->middleware('auth');
Route::put('/account/{MaKH}/update-password', [Account_Controller::class, 'updatePassword'])->name('account.updatePassword');
Route::put('/account/{MaKH}/update-account', [Account_Controller::class, 'updateAccount'])->name('account.updateAccount');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');