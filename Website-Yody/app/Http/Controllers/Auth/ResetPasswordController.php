<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\KhachHang; // Đảm bảo bạn đã import model này
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
{
    return view('auth.reset_password', ['token' => $token, 'email' => $request->email]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
    ]);

    // Tìm khách hàng theo email
    $khachHang = KhachHang::where('email', $request->email)->first();

    // Nếu không tìm thấy khách hàng, có thể xử lý lỗi tại đây
    if (!$khachHang) {
        return back()->withErrors(['email' => 'Email không hợp lệ.']);
    }

    // Cập nhật mật khẩu
    $khachHang->password = Hash::make($request->password);
    $khachHang->Provider_token = null; // Xóa token sau khi đã sử dụng (nếu có)
    $khachHang->save();

    return redirect()->route('login')->with('status', 'Mật khẩu đã được đặt lại thành công.');
}


}