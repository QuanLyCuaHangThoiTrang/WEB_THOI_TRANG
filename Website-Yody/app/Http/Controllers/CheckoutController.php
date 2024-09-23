<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GioHang; // Giả sử bạn có model GioHang
use App\Models\ChiTietGioHang; // Model chi tiết giỏ hàng
use App\Models\DonHang; // Model đơn hàng
use App\Models\KhachHang;
use App\Models\ChiTietDonHang; // Model chi tiết đơn hàng
use Illuminate\Support\Facades\Auth;
class CheckoutController extends Controller
{
    public function index()
    {
        $chiTietGioHang = [];
        $tongTien = 0;
        $giamGia = 0; // Ví dụ, bạn có thể tính giảm giá từ thông tin giỏ hàng hoặc session

        // Nếu người dùng đã đăng nhập, lấy giỏ hàng từ database
        if (Auth::check()) {
            $user = Auth::user();
            
            $gioHang = GioHang::where('MaKH', $user->MaKH)->first();

            if ($gioHang) {
                $chiTietGioHang = $gioHang->chiTietGioHang;
                $tongTien = $gioHang->TongGiaTri;
                
            }
        } else {
            // Nếu người dùng chưa đăng nhập, lấy giỏ hàng từ session
            $gioHangSession = session()->get('gioHang', []);
            $chiTietGioHang = $gioHangSession;
            $tongTien = array_sum(array_column($gioHangSession, 'ThanhTien'));
        }

        // Trả về view với chi tiết giỏ hàng và tổng tiền
        return view('checkout.checkout', compact('chiTietGioHang', 'tongTien', 'giamGia'));
    }
    
    /*
    public function processCheckout(Request $request)
    {
       // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
          
            $gioHang = GioHang::where('MaKH', $user->MaKH)->first();
            if ($gioHang && $gioHang->TongGiaTri > 0) {
                // Giỏ hàng có sản phẩm -> tiếp tục xử lý thanh toán
                return redirect()->route('checkout.index')->with('success', 'Đơn hàng của bạn đã được xử lý.');
            } else {
                // Giỏ hàng rỗng -> quay lại giỏ hàng và thông báo
                return redirect()->route('cart.index')->withErrors('Giỏ hàng của bạn trống.');
            }
        } else {
            // Xử lý với giỏ hàng trong session
            $gioHangSession = session()->get('gioHang', []);
            
            if (count($gioHangSession) > 0) {
                // Giỏ hàng session có sản phẩm -> tiếp tục xử lý thanh toán
                return redirect()->route('checkout.index')->with('success', 'Đơn hàng của bạn đã được xử lý.');
            } else {
                // Giỏ hàng rỗng -> quay lại giỏ hàng và thông báo
                return redirect()->route('cart.index')->withErrors('Giỏ hàng của bạn trống.');
            }
        }
        
    }
    */
    
    public function processCheckoutDH(Request $request)
    {
        // Thực hiện kiểm tra và xử lý thanh toán
        if (Auth::check()) {
            $user = Auth::user();          
            $gioHang = GioHang::where('MaKH', $user->MaKH)->first();
            if ($gioHang && $gioHang->TongGiaTri > 0) {
                // Gọi phương thức lưu đơn hàng
                return $this->storeOrder($request);
            } else {
                return redirect()->route('cart')->withErrors('Giỏ hàng của bạn trống.');
            }
        } else {
            // Xử lý với giỏ hàng trong session
            return $this->storeOrder($request);
            
        }
    }
    public function storeOrder(Request $request)
    {
        $diachinha = $request->input('diachinha');
        $xa = $request->input('hidden_phuong');
        $huyen = $request->input('hidden_quan');
        $tinh = $request->input('hidden_tinh');
        dd($tinh);
        $diachi = $diachinha . ', ' . $xa . ', ' . $huyen . ', '. $tinh;
        $email = $request->input('email');
        $sodienthoai = $request->input('phone_number');
        $hoten = $request->input('name');
        // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $gioHang = GioHang::where('MaKH', $user->MaKH)->first();

            if ($gioHang && $gioHang->TongGiaTri > 0) {
                $maDH = 'DH' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                if($request->input('payment_method') == 'Thanh toán momo')
                {
                    return redirect('https://www.momo.vn/');
                }
                // Tạo đơn hàng mới
                $donHang = DonHang::create([
                    'MaDH' => $maDH,
                    'MaKH' => $user->MaKH,
                    'DiaChiGiaoHang' => $diachi,
                    'NgayDatHang' => now(),
                    'TongGiaTri' => $gioHang->TongGiaTri,
                    'TrangThai' => 'Chưa giao', // Ví dụ trạng thái đơn hàng
                    'PhuongThucThanhToan' => $request->input('payment_method')
                ]);
                
                // Lưu chi tiết đơn hàng
                $chiTietGioHang = ChiTietGioHang::where('MaGH', $gioHang->MaGH)->get();
                foreach ($chiTietGioHang as $item) {
                    ChiTietDonHang::create([
                        'MaDH' => $donHang->MaDH,
                        'MaCTSP' => $item->MaCTSP,
                        'SoLuong' => $item->SoLuong,
                        'DonGia' => $item->DonGia,
                        'ThanhTien' => $item->ThanhTien
                    ]);
                }

                // Xóa giỏ hàng sau khi hoàn tất thanh toán
                ChiTietGioHang::where('MaGH', $gioHang->MaGH)->delete();
                $gioHang->TongGiaTri = 0;
                $gioHang->save();

                return redirect()->route('checkout.index')->with('success', 'Đơn hàng của bạn đã được tạo thành công.');
            } else {
                return redirect()->route('cart')->withErrors('Giỏ hàng của bạn trống.');
            }
        } 
        else 
        {
            $gioHangSession = session()->get('gioHang', []);
            if (count($gioHangSession) > 0) 
            {          
                $maKH = 'KHVL' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $maDH = 'DH' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                if($request->input('payment_method') == 'Thanh toán momo')
                {
                    return redirect('https://www.momo.vn/');
                }
                $khachHang = KhachHang::create([
                    'MaKH' => $maKH,
                    'HoTen' => $hoten,
                    'Email' => $email,
                    'SDT' => $sodienthoai,
                    'LoaiKH' => 'Online',
                    'Username' => '', // Ví dụ trạng thái đơn hàng
                    'Password' => '',
                ]);               
                // Tạo đơn hàng mới
                $donHang = DonHang::create([
                    'MaDH' => $maDH,
                    'MaKH' => $maKH,
                    'DiaChiGiaoHang' => $diachi,
                    'NgayDatHang' => now(),
                    'TongGiaTri' => array_sum(array_column($gioHangSession, 'ThanhTien')),
                    'TrangThai' => 'Chưa giao', // Ví dụ trạng thái đơn hàng
                    'PhuongThucThanhToan' => $request->input('payment_method')
                ]);
                
                // Lưu chi tiết đơn hàng
                foreach ($gioHangSession as $item) {
                    ChiTietDonHang::create([
                        'MaDH' => $donHang->MaDH,
                        'MaCTSP' => $item['MaCTSP'],
                        'SoLuong' => $item['SoLuong'],
                        'DonGia' => $item['DonGia'],
                        'ThanhTien' => $item['ThanhTien']
                    ]);
                }
                session()->forget('gioHang');
                return redirect()->route('checkout.index')->with('success', 'Đơn hàng của bạn đã được tạo thành công.');   
            } 
            else 
            {
                return redirect()->route('cart')->withErrors('Giỏ hàng của bạn trống.');
            }
                        
        }
    }
}
