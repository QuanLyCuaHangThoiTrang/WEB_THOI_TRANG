<?php
namespace App\Http\Controllers\Login;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('login.login');
    }
    public function postLogin(Request $request)
    {
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
            return redirect('home');
        }
    
        // Đăng nhập thất bại
        return redirect()->back()->withErrors(['credentials' => 'Thông tin đăng nhập không chính xác.']);
    }
    
    // Đăng xuất
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Đăng xuất thành công.');
    }
}