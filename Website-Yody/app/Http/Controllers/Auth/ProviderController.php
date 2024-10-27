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
    
        // Tìm kiếm người dùng trong bảng KhachHang dựa trên email và Provider_ID
        $existingUser = KhachHang::where('Email', $user->getEmail())
            ->orWhere('Provider_ID', $user->getId())
            ->first();
    
        if ($existingUser) {
            // Kiểm tra xem tài khoản có Provider là 'google' không
            if ($existingUser->Provider === $provider) {
                Auth::login($existingUser); // Đăng nhập nếu Provider là 'google'
                return redirect()->to('home'); // Điều hướng về trang chính
            } else {
                // Nếu email đã tồn tại nhưng không có Provider là 'google'
                return redirect()->to('/login')->withErrors(['error' => 'Email này đã được đăng ký trong hệ thống']);
            }
        } else {
            // Nếu người dùng chưa tồn tại, tạo mới người dùng
            $khachHang = new KhachHang();
    
            // Tạo mã khách hàng duy nhất
            do {
                $randomString = Str::random(6); // Tạo chuỗi ngẫu nhiên có độ dài 6
                $MaKH = 'KH' . $randomString; // Kết hợp với tiền tố 'KH'
            } while (KhachHang::where('MaKH', $MaKH)->exists());
            // Thiết lập thông tin người dùng mới
         
            $khachHang->MaKH = $MaKH;      
            $khachHang->HoTen = $user->getName();
            $khachHang->Email = $user->getEmail();
            $khachHang->SDT = ''; // Có thể lấy từ thông tin người dùng nếu có
            $khachHang->LoaiKH = 'Thành viên';
            $khachHang->Provider = $provider; // Đặt provider thành 'google'
            $khachHang->Provider_ID = $user->getId();
            $khachHang->Username = $user->getNickname();
            
            // Lưu vào cơ sở dữ liệu
          
            // Gửi email chào mừng
            try {
                Mail::to($khachHang->Email)->send(new WelcomeMail($khachHang)); // Send the welcome email
            } catch (\Exception $e) {
                Log::error('Mail sending failed: ' . $e->getMessage());
            }
           
            Auth::login($khachHang); 
            $khachHang->save();// Đăng nhập người dùng mới        
            return redirect()->to('home'); // Điều hướng về trang chính
        }
    }
    
}