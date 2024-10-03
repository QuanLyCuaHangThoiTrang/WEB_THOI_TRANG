<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login_Controller extends Controller
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
        if (Auth::attempt(['Username' => $request->taikhoan, 'password' => $request->matkhau])) {
            // Đăng nhập thành công
            //$user = Auth::user();
            //session(['user' => $user]);     
            return redirect('home');
        }

        // Đăng nhập thất bại
        return redirect('login_register');
    }
    // Xử lý đăng nhập
    
    // Đăng xuất
    public function logout()
    {
        Auth::logout();
        session()->forget('isLoggedIn');
        return redirect()->route('login')->with('success', 'Đăng xuất thành công.');
    }
}