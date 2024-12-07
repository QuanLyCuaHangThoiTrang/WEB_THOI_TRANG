<?php
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
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
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Account\VoucherController;
use App\Http\Controllers\Account\OrderController;
use App\Mail\WelcomeMail;
use App\Models\KhachHang;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\ChiTietSanPhamController;
use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\Admin\KhuyenMaiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonHangController;
use App\Http\Controllers\Admin\DonNhapHangController;
use App\Http\Controllers\Admin\ChiTietDonNhapHangController;
use App\Http\Controllers\Admin\KhachHangController;
use App\Http\Controllers\Admin\NhanVienController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/vi');
});
Route::get('/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'vi'])) {
        abort(400);
    }

    // Lưu locale vào session
    App::setLocale($locale);
    Session::put('locale', $locale);

    // Quay lại trang trước
    return redirect()->back();
});
// Guest Routes (Home, About, Contact)
Route::get('/{locale}', [HomeController::class, 'home'])->name('home');
Route::get('/{locale}/about-us', [AboutUsController::class, 'about'])->name('about');
Route::get('/{locale}/contact-us', [ContactUsController::class, 'contact'])->name('contact');


// Authentication Routes
Route::get('/auth/{provider}/redirect', [ProviderController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [ProviderController::class, 'callback']);


// Cart Routes
Route::prefix('{locale}/cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart');
    Route::post('/', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('remove/{MaGH}/{MaCTSP}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('remove/{MaCTSP}', [CartController::class, 'removeFromCartSS'])->name('cart.removeSS');
    Route::get('removeall', [CartController::class, 'removeAllart'])->name('cart.removeAll');
    
    // Include {locale} in the update route
    Route::put('update', [CartController::class, 'update'])->name('cart.update');
});


// Shop Routes
Route::resource('/{locale}/products', ShopController::class);
Route::get('/{locale}/productsDM/{MaCTDM}', [ShopController::class, 'showProducts'])->name('products.showDM');


Route::prefix('{locale}')->group(function () {
    Route::get('/product_detail/{MaSP}', [ProductDetailController::class, 'index'])->name('product_detail');
});
// Product Detail Routes

Route::get('/{locale}/test_endpoint/{MaMau}', [ProductDetailController::class, 'getProductDetails']);
Route::get('/{locale}/get-sizes-by-color/{MaMau}/{MaSP}', [ProductDetailController::class, 'getSizesByColor']);
Route::get('/{locale}/test_endpointa/{MaSP}/{MaSize}/{MaMau}', [ProductDetailController::class, 'getProductDetails1']);
Route::get('/{locale}/get-image', [ProductDetailController::class, 'getImageByMaSPAndMaMau']);

// Checkout Routes
Route::get('/{locale}/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/{locale}/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::post('/{locale}/checkoutDH', [CheckoutController::class, 'processCheckoutDH'])->name('checkout.processDH');
Route::post('/{locale}/Voucher', [CheckoutController::class, 'applyVoucher'])->name('checkout.applyVoucher');
Route::post('/{locale}/voucher/cancel', [CheckoutController::class, 'cancelVoucher'])->name('voucher.cancel');

// Login and Registration Routes
Route::get('/{locale}/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/{locale}/login', [LoginController::class, 'postLogin'])->name('login.postLogin');
Route::get('/{locale}/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/{locale}/register', [RegisterController::class, 'register'])->name('register');

// Password Reset Routes
Route::get('/{locale}/password/forgot', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/{locale}/password/email', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/{locale}/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/{locale}/password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.reset');

Route::prefix('{locale}')->where(['locale' => 'en|vi'])->group(function () {
    Route::get('/vouchers/{MaKH}', [VoucherController::class, 'showCustomerVouchers'])->name('account.settings.vouchers');
});




// Account and Order Routes (Requires Authentication)
Route::get('/{locale}/account/{MaKH}', [AccountController::class, 'showAccountForm'])
    ->name('account') // This assigns the 'account' name to this route
    ->middleware('auth');
Route::put('/account/{MaKH}/password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');
Route::put('/account/{MaKH}/update-account', [AccountController::class, 'updateAccount'])->name('account.updateAccount');
Route::delete('/account/delete/{MaKH}', [AccountController::class, 'deleteAccount'])->name('account.delete');


Route::get('/{locale}/order/{MaKH}', [OrderController::class, 'showOrders'])->name('account.settings.orders');
Route::delete('/orders/cancel/{maDH}', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
Route::get('/order/{maKH}/{maDH}', [OrderController::class, 'showOrderDetail'])->name('orders.detail');
Route::post('/orders/rate/{maKH}/{maCTSP}', [OrderController::class, 'rateProduct'])->name('orders.rate');


Route::prefix('{locale}')->where(['locale' => 'en|vi'])->group(function () {
    Route::get('/addresses/{MaKH}', [AddressController::class, 'showAddresses'])->name('account.settings.addresses');
    Route::post('/addresses', [AddressController::class, 'createAddress'])->name('addresses.create');
    Route::delete('/addresses/{MaKH}/{MaDC}', [AddressController::class, 'deleteAddress'])->name('addresses.delete');
});



    //payment
    Route::get('/momo/response', [CheckoutController::class, 'handleMomoResponse'])->name('momo.response');
    Route::get('/{locale}/ThanhToanThanhCong', [CheckoutController::class, 'ThanhToanThanhCong'])->name('thanhtoan.ThanhCong');
// Logout Route
Route::post('/{locale}/logout', function () {
    Auth::logout();
    return redirect('/' . app()->getLocale());  // Redirect to the homepage with the correct locale
})->name('logout');


// Admin Routes
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/logout', function () {
        Auth::guard('admin')->logout();
        return redirect('/login');
    })->name('admin.logout');
    
    // Product Routes
    Route::resource('product', SanPhamController::class);
    Route::get('/product/{product}/details/create', [ChiTietSanPhamController::class, 'create'])->name('product.variants.create');
    Route::post('/product/{product}/detail', [ChiTietSanPhamController::class, 'store'])->name('product.variants.store');
    
    // Category Routes
    Route::resource('danhmuc', DanhMucController::class);
    
    // Promotion Routes
    Route::resource('khuyenmai', KhuyenMaiController::class);
    
    // Order Management Routes
    Route::resource('donhang', DonHangController::class);
    Route::get('/donhang/{id}/pdf', [DonHangController::class, 'print'])->name('donhang.print');
    Route::post('/donhang/updateStatus', [DonHangController::class, 'updateStatus'])->name('donhang.updateStatus');
    
    // Employee Routes
    Route::resource('nhanvien', NhanVienController::class);
    
    // Customer Management Routes
    Route::get('/khachhang', [KhachHangController::class, 'index'])->name('khachhang.index');
    Route::delete('/khachhang/{id}', [KhachHangController::class, 'destroy'])->name('khachhang.destroy');
    
    // Dashboard and Reports
    Route::get('/thongke', [DonHangController::class, 'showDashboard'])->name('donhang.dashboard');
    Route::get('/orders-current-month', [DashboardController::class, 'getOrdersForCurrentMonth']);
    
    
    
    
});