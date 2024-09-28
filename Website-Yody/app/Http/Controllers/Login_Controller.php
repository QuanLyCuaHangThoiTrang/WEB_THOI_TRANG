<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login_Controller extends Controller
{
    public function showLoginForm()
    {
        return view('login.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'taikhoan' => ['required'], // Tên field Username từ form
            'matkhau' => ['required'],  // Tên field Password từ form
        ]);

        if (Auth::attempt(['Username' => $request->taikhoan, 'Password' => $request->matkhau])) {
            return redirect('home')->with('success', 'Đăng nhập thành công.'); // Thông báo thành công
        }

        return redirect('login_register')->withErrors(['error' => 'Tên tài khoản hoặc mật khẩu không đúng.']); // Thông báo lỗi
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Đăng xuất thành công.');
    }
}