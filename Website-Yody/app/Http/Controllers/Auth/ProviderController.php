<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\KhachHang;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $user = Socialite::driver($provider)->user();

        // Tìm kiếm người dùng trong bảng KhachHang dựa trên email
        $existingUser = KhachHang::where('Email', $user->getEmail())->first();

        if ($existingUser) {
            Auth::login($existingUser);
            return redirect()->to('/'); // Điều hướng về trang chính
        } else {
            // Nếu người dùng chưa tồn tại, tạo mới người dùng
            $khachHang = new KhachHang();
            $khachHang->MaKH = 'KH' . str_pad(KhachHang::count() + 1, 4, '0', STR_PAD_LEFT); // Có thể cải thiện cách tạo mã
            $khachHang->HoTen = $user->getName();
            $khachHang->Email = $user->getEmail();
            $khachHang->SDT = ''; // Có thể lấy từ thông tin người dùng
            $khachHang->LoaiKH = 'Thành viên';
            $khachHang->Provider = 'google';
            $khachHang->Provider_ID = $user->getId();
            $khachHang->Username = $user->getNickname();

            $khachHang->save(); // Lưu vào cơ sở dữ liệu
            Auth::login($khachHang); // Đăng nhập người dùng
            return redirect()->to('/'); // Điều hướng về trang chính
        }
    }
}