<?php
namespace App\Http\Controllers\Login;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App; 

class LoginController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('login.login');
    }
    public function postLogin(Request $request,$locale)
    {
        App::setLocale($locale); 
        // Xác thực với Username và Password
        $credentials = $request->validate([
            'taikhoan' => ['required'], // Tên field Username từ form
            'matkhau' => ['required'],  // Tên field Password từ form
        ]);
        
        // Sử dụng Username và Password để xác thực
        $remember = $request->has('remember'); // Kiểm tra nếu người dùng chọn "Nhớ tôi"
        
        if (Auth::guard('admin')->attempt(['Username' => $request->taikhoan, 'password' => $request->matkhau], $remember)) {
            return redirect()->intended(default: '/admin/dashboard');
        }
        if (Auth::attempt(['Username' => $request->taikhoan, 'password' => $request->matkhau], $remember)) {
            // Đăng nhập thành công
            $locale = app()->getLocale(); // Lấy ngôn ngữ hiện tại
            return redirect()->route('home', ['locale' => app()->getLocale()]);
        }
    
        // Đăng nhập thất bại
        return redirect()->back()->withErrors(['credentials' => 'Thông tin đăng nhập không chính xác.']);
    }
    
    // Đăng xuất
    public function logout($locale)
    {
        App::setLocale($locale); 
        Auth::logout();
        return redirect()->route('login',['locale' => app()->getLocale()])->with('success', 'Đăng xuất thành công.');
    }
}