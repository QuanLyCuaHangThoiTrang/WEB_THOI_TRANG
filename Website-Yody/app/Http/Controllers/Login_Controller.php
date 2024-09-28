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
        // Validate the form data
        $request->validate([
            'taikhoan' => ['required', 'string'], // Tên field Username từ form
            'matkhau' => ['required', 'string'],   // Tên field Password từ form
        ], [
            'taikhoan.required' => 'Tên đăng nhập không được để trống.',
            'taikhoan.string' => 'Tên đăng nhập phải là một chuỗi.',
            'matkhau.required' => 'Mật khẩu không được để trống.',
            'matkhau.string' => 'Mật khẩu phải là một chuỗi.',
        ]);

        // Sử dụng Username và Password để xác thực
        if (Auth::attempt(['Username' => $request->taikhoan, 'password' => $request->matkhau])) {
            // Đăng nhập thành công
            return redirect('home')->with('success', 'Đăng nhập thành công.');
        }

        // Đăng nhập thất bại
        return back()->withErrors([
            'taikhoan' => 'Tên đăng nhập hoặc mật khẩu không đúng.',
        ])->withInput($request->only('taikhoan'));
    }

    // Đăng xuất
    public function logout()
    {
        Auth::logout();
        session()->forget('isLoggedIn');
        return redirect()->route('login')->with('success', 'Đăng xuất thành công.');
    }
}
