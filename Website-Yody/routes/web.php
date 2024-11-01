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
use App\Http\Controllers\Account\OrderController;
use App\Mail\WelcomeMail;
use App\Models\KhachHang;
use Illuminate\Support\Facades\Mail;

//ADMIN
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
Route::get('/productsDM/{MaCTDM}', [ShopController::class, 'showProducts'])->name('products.showDM');


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

Route::get('/order/{MaKH}', [OrderController::class, 'showOrders'])->name('account.settings.orders');
Route::delete('/orders/cancel/{maDH}', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
Route::get('/order/{maKH}/{maDH}', [OrderController::class, 'showOrderDetail'])->name('orders.detail');
Route::post('orders/rate/{maKH}/{maCTSP}', [OrderController::class, 'rateProduct'])->name('orders.rate');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

//ADMIN
Route::get('/admin', function () {
    if (!Auth::guard('admin')->check()) {
        return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    }
    return view('Admin.welcome'); // Trả về view nếu đã đăng nhập
});
Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->group(function ()  {
    Route::get('/admin/logout', function () {
        Auth::guard('admin')->logout(); // Đăng xuất admin
        return redirect('/login'); // Chuyển hướng về trang đăng nhập
    })->name('admin.logout');
    //San pham
    Route::get('/product', [SanPhamController::class, 'index'])->name('product.index');
    Route::get('/product/create', [SanPhamController::class, 'create'])->name('product.create');
    Route::post('/product', [SanPhamController::class, 'store'])->name('product.store');
    Route::get('/product/{MaSP}/edit', [SanPhamController::class, 'edit'])->name('product.edit');
    Route::put('/product/{MaSP}', [SanPhamController::class, 'update'])->name('product.update');
    Route::delete('/product/{MaSP}', [SanPhamController::class, 'destroy'])->name('product.destroy');


    //ChiTietSanPham
    Route::get('/product/{product}/details/create', [ChiTietSanPhamController::class, 'create'])->name('product.variants.create');
    Route::post('/product/{product}/detail', [ChiTietSanPhamController::class, 'store'])->name('product.variants.store');
    Route::get('/product/{MaSP}/details', [ChiTietSanPhamController::class, 'show'])->name('product.details');
    Route::get('chitietsanpham/{MaCTSP}/edit', [ChiTietSanPhamController::class, 'edit'])->name('chitietsanpham.edit');
    Route::put('chitietsanpham/{MaCTSP}', [ChiTietSanPhamController::class, 'update'])->name('chitietsanpham.update');
    Route::delete('chitietsanpham/{MaCTSP}', [ChiTietSanPhamController::class, 'destroy'])->name('chitietsanpham.destroy');

    //DanhMuc
    Route::resource('danhmuc', DanhMucController::class);
    Route::get('danhmuc/{id}/chitiet', [DanhMucController::class, 'getChiTiet']);
    Route::post('danhmuc/chitiet/save', 'DanhMucController@saveChitiet')->name('danhmuc.chitiet.save');
    Route::delete('danhmuc/chitiet/{id}/delete', [DanhMucController::class, 'deleteChiTiet']);

    //KhuyenMai
    Route::resource('khuyenmai', KhuyenMaiController::class);
    // Route::resource('sanphamkhuyenmai', SanPhamKhuyenMaiController::class);

    //SanPhamKhuyenMai
    Route::get('khuyenmai/{maKM}/sanpham/create', [KhuyenMaiController::class, 'create_SPKM'])->name('sanphamkhuyenmai.create');
    Route::post('khuyenmai/{maKM}/sanpham', [KhuyenMaiController::class, 'store_SPKM'])->name('sanphamkhuyenmai.store');
    Route::delete('khuyenmai/{maKM}/chitiet/{MaCTSP}', [KhuyenMaiController::class, 'destroy_SPKM'])->name('sanphamkhuyenmai.destroy');
   
    //DonHang
    Route::resource('donhang', DonHangController::class);
    Route::get('/thongke', [DonHangController::class, 'showDashboard'])->name('donhang.dashboard');
    Route::get('donhang/{id}/pdf', [DonHangController::class, 'print'])->name('donhang.print');
    Route::post('/donhang/updateStatus', [DonHangController::class, 'updateStatus'])->name('donhang.updateStatus');

    //DonNhapHang
    Route::resource('donnhaphang', DonNhapHangController::class);
    // Route::get('donnhaphang/{maNH}/chitiet/create', [ChiTietDonNhapHangController::class, 'create'])->name('chitietdonnhaphang.create');
    Route::post('donnhaphang/{maNH}/chitiet', [ChiTietDonNhapHangController::class, 'store'])->name('chitietdonnhaphang.store');
    // Route::get('donnhaphang/{maNH}/chitiet/{MaCTSP}/edit', [ChiTietDonNhapHangController::class, 'edit'])->name('chitietdonnhaphang.edit');
    Route::post('donnhaphang/{maNH}/chitietsp', [ChiTietDonNhapHangController::class, 'update'])->name('chitietdonnhaphang.update');
    Route::delete('donnhaphang/{maNH}/chitiet/{MaCTSP}', [ChiTietDonNhapHangController::class, 'destroy'])->name('chitietdonnhaphang.destroy');
    Route::get('donnhaphang/{maNH}/pdf', [DonNhapHangController::class, 'print'])->name('donnhaphang.print');
   
    //ChiTietSanPhamNhap
    Route::get('chitietsanphamnhap/{maSP}', [ChiTietDonNhapHangController::class, 'getMaCTSPOptions']);
    Route::post('/chitietsanphamnhap/{donnhaphang}', [ChiTietDonNhapHangController::class, 'store_CTSP'])->name('chitietsanphamnhap.store_CTSP');


    Route::get('/filter-by-date', [DonHangController::class, 'filterByDate']);
    //Khach Hang
    Route::get('/khachhang', [KhachHangController::class, 'index'])->name('khachhang.index');
    Route::delete('/khachhang/{id}', [KhachHangController::class, 'destroy'])->name('khachhang.destroy');
   
  
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/voucher', [VoucherController::class, 'index'])->name('voucher.index');
    Route::get('/orders-current-month', [DashboardController::class, 'getOrdersForCurrentMonth']);
    Route::resource('nhanvien', NhanVienController::class);

   

});
