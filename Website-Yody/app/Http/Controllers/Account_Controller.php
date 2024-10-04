<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Account_Controller extends Controller
{
    public function showAccountForm($MaKH)
    {
        $khachhang = KhachHang::where('MaKH', $MaKH)->firstOrFail();
        
        // Xác định xem người dùng có phải là tài khoản Google không
        $isGoogleAccount = $khachhang->Provider === 'google';

        // Truyền biến khachhang và isGoogleAccount vào view
        return view('account.accountpage', compact('khachhang', 'isGoogleAccount'));
    }

    public function updatePassword(Request $request, $MaKH)
    {
        $khachhang = KhachHang::where('MaKH', $MaKH)->firstOrFail();

        // Xác định xem người dùng có phải là tài khoản Google không
        $isGoogleAccount = $khachhang->Provider === 'google';

        // Nếu là tài khoản Google, không cho phép thay đổi mật khẩu
        if ($isGoogleAccount) {
            return back()->with('error', 'Tài khoản Google không thể thay đổi mật khẩu.');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $khachhang->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không đúng.');
        }

        // Cập nhật mật khẩu
        $khachhang->password = Hash::make($request->new_password);
        $khachhang->save();

        return back()->with('success', 'Mật khẩu đã được cập nhật thành công.');
    }

    public function updateAccount(Request $request, $MaKH)
{
    $khachhang = KhachHang::where('MaKH', $MaKH)->firstOrFail();

    // Xác thực dữ liệu đầu vào
    $request->validate([
        'full_name' => 'required|string|max:255',
        // Thêm các trường khác nếu cần
    ], [
        'full_name.required' => 'Vui lòng nhập họ và tên.',
    ]);

    // Cập nhật thông tin tài khoản
    $khachhang->HoTen = $request->full_name;
    $khachhang->Username = $request->taikhoan;

    $khachhang->save();
    dd($request->all());
    return back()->with('success', 'Thông tin tài khoản đã được cập nhật thành công.');
}
public function deleteAccount(Request $request, $MaKH)
{
    $khachhang = KhachHang::where('MaKH', $MaKH)->firstOrFail();

    // Xóa tài khoản
    $khachhang->delete();

    return back()->with('success', 'Tài khoản đã được xóa thành công.');
}

}