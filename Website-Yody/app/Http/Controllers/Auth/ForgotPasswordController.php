<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\KhachHang; // Đảm bảo rằng bạn đã import model KhachHang
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password'); // Đường dẫn tới view bạn sẽ tạo
    }

    public function sendResetLink(Request $request)
    {
        // Xác thực email
        $request->validate(['email' => 'required|email|exists:khachhang,email']);
    
        // Tìm khách hàng theo email
        $khachHang = KhachHang::where('email', $request->email)->first();
    
        // Tạo token
        $token = Str::random(6); // Tạo một token ngẫu nhiên
    
        // Cập nhật token vào cột Provider_token
        $khachHang->update(['Provider_token' => $token]);
    
        // Gửi email đặt lại mật khẩu
        Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));
    
        return back()->with(['status' => 'Chúng tôi đã gửi liên kết đặt lại mật khẩu đến email của bạn.']);
    }
}