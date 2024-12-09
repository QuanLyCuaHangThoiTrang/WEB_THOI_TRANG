<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\KhachHang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // Import Mail facade
use App\Mail\WelcomeMail; // Import the WelcomeMail class

class ProviderController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
{
    // Lấy thông tin người dùng từ provider
    $user = Socialite::driver($provider)->user();

    // Lấy locale hiện tại
    $locale = app()->getLocale(); // Lấy locale hiện tại (ví dụ: 'vi', 'en')

    // Tìm kiếm người dùng trong bảng KhachHang dựa trên email và Provider_ID
    $existingUser = KhachHang::where('Email', $user->getEmail())
        ->orWhere('Provider_ID', $user->getId())
        ->first();

    if ($existingUser) {
        if ($existingUser->Provider === $provider) {
            Auth::login($existingUser); // Đăng nhập nếu Provider trùng khớp
            return redirect()->to("/$locale"); // Điều hướng về route có locale
        } else {
            return redirect()->to("/$locale/login")->withErrors(['error' => 'Email này đã được đăng ký trong hệ thống']);
        }
    } else {
        // Nếu người dùng chưa tồn tại, tạo mới người dùng
        $khachHang = new KhachHang();

        // Tạo mã khách hàng duy nhất
        do {
            $randomString = Str::random(6);
            $MaKH = 'KH' . $randomString;
        } while (KhachHang::where('MaKH', $MaKH)->exists());

        $khachHang->MaKH = $MaKH;
        $khachHang->HoTen = $user->getName();
        $khachHang->Email = $user->getEmail();
        $khachHang->SDT = '';
        $khachHang->LoaiKH = 'Thành viên';
        $khachHang->Provider = $provider;
        $khachHang->Provider_ID = $user->getId();
        $khachHang->Username = $user->getNickname();

        // Lưu vào cơ sở dữ liệu
        $khachHang->save();

        // Gửi email chào mừng
        try {
            Mail::to($khachHang->Email)->send(new WelcomeMail($khachHang));
        } catch (\Exception $e) {
            Log::error('Mail sending failed: ' . $e->getMessage());
        }

        Auth::login($khachHang); // Đăng nhập người dùng mới
        return redirect()->to("/$locale"); // Điều hướng về route có locale
    }
}

    
}