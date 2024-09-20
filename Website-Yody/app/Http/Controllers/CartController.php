<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GioHang; // Giả sử bạn có model GioHang
use App\Models\ChiTietGioHang; // Model chi tiết giỏ hàng
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ChiTietSanPham;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // Người dùng đã đăng nhập
            $userId = Auth::user()->MaKH;
            $gioHang = GioHang::where('MaKH', $userId)->first();
            if ($gioHang) {
                $chiTietGioHang = ChiTietGioHang::where('MaGH', $gioHang->MaGH)->get();
                $tongGiaTri = $chiTietGioHang->sum('ThanhTien');
            } else {
                $chiTietGioHang = [];
                $tongGiaTri = 0;
            }

            return view('cart.cart', compact('chiTietGioHang', 'tongGiaTri'));
        } else {
            // Người dùng chưa đăng nhập
            $gioHangSession = Session::get('gioHang', []); // Lấy giỏ hàng từ session
            // Tính tổng giá trị giỏ hàng từ session
            $tongGiaTri = array_sum(array_column($gioHangSession, 'ThanhTien'));
            return view('cart.cart', compact('gioHangSession', 'tongGiaTri'));
        }
    }
    public function addToCart(Request $request)
    {
       
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'selected_color' => 'nullable|exists:mausac,MaMau',
            'selected_size' => 'nullable|exists:kichthuoc,MaSize',
            'MaSP' => 'nullable|exists:chitietsanpham,MaSP',
            'SoLuong' => 'nullable|integer|min:1',
        ]);
        if(Auth::check())
        {
            $maKH = Auth::user()->MaKH;        
            // Tìm giỏ hàng hiện có của khách hàng
            $gioHang = GioHang::where('MaKH', $maKH)->first();
        
            // Nếu không có giỏ hàng, tạo giỏ hàng mới với MaGH ngẫu nhiên
            if (!$gioHang) {
                $maGH = 'GH' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
                $gioHang = GioHang::create([
                    'MaGH' => $maGH,
                    'MaKH' => $maKH,
                    'NgayTao' => now(),
                    'TongGiaTri' => 0
                ]);
            } else {
                $maGH = $gioHang->MaGH; // Đảm bảo sử dụng MaGH của giỏ hàng hiện tại
            }

            // Tìm chi tiết sản phẩm
            $chiTietSanPham = ChiTietSanPham::where([
                ['MaSP', '=', $validated['MaSP']],
                ['MaMau', '=', $validated['selected_color']],
                ['MaSize', '=', $validated['selected_size']],
            ])->first();
           
            if (!$chiTietSanPham) {
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại');
            }
            // Tìm chi tiết giỏ hàng
            $chiTietGioHang = ChiTietGioHang::where([
                ['MaGH', '=', $maGH],
                ['MaCTSP', '=', $chiTietSanPham->MaCTSP]
            ])->first();            
            if ($chiTietGioHang) {
                // Nếu đã có trong giỏ hàng, cập nhật số lượng và thành tiền
                $chiTietGioHang->SoLuong += $validated['SoLuong'];
                $chiTietGioHang->ThanhTien = $chiTietGioHang->SoLuong * $chiTietGioHang->DonGia; 
                ChiTietGioHang::where([
                    ['MaGH', '=', $gioHang->MaGH],
                    ['MaCTSP', '=', $chiTietSanPham->MaCTSP]
                ])->update([
                    'SoLuong' => $chiTietGioHang->SoLuong,
                    'ThanhTien' => $chiTietGioHang->ThanhTien
                ]);
            } else {
                // Nếu chưa có, tạo mới chi tiết giỏ hàng
                ChiTietGioHang::create([
                    'MaGH' => $maGH,
                    'MaCTSP' => $chiTietSanPham->MaCTSP,
                    'SoLuong' => $validated['SoLuong'],
                    'DonGia' => $chiTietSanPham->SanPham->GiaBan,
                    'ThanhTien' => $validated['SoLuong'] * $chiTietSanPham->SanPham->GiaBan
                ]);
            }
            
            // Cập nhật tổng giá trị của giỏ hàng
            $tongGiaTri = ChiTietGioHang::where('MaGH', $maGH)->sum('ThanhTien'); 
            $gioHang->where('MaGH',$maGH)->update([
                'TongGiaTri' => $tongGiaTri
            ]);          
        }
        else
        {
            $gioHang = Session::get('gioHang', []);
            $chiTietSanPham = ChiTietSanPham::where([
                ['MaSP', '=', $validated['MaSP']],
                ['MaMau', '=', $validated['selected_color']],
                ['MaSize', '=', $validated['selected_size']],
            ])->first();

            if (!$chiTietSanPham) {
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại');
            }

            $donGia = $chiTietSanPham->SanPham->GiaBan;
            $thanhTien = $validated['SoLuong'] * $donGia;
            $maCTSP = $chiTietSanPham->MaCTSP;

            // Cập nhật giỏ hàng trong session
            if (isset($gioHang[$maCTSP])) {
                // Cập nhật số lượng và thành tiền nếu sản phẩm đã có trong giỏ hàng
                $gioHang[$maCTSP]['SoLuong'] += $validated['SoLuong'];
                $gioHang[$maCTSP]['ThanhTien'] = $gioHang[$maCTSP]['SoLuong'] * $donGia;
            } else {
                // Thêm mới sản phẩm vào giỏ hàng trong session
                $gioHang[$maCTSP] = [
                    'MaSP' => $validated['MaSP'],
                    'MaMau' => $validated['selected_color'],
                    'MaSize' => $validated['selected_size'],
                    'SoLuong' => $validated['SoLuong'],
                    'DonGia' => $donGia,
                    'ThanhTien' => $thanhTien,
                    'TenSP' => $chiTietSanPham->SanPham->TenSP, // Thêm tên sản phẩm
                    'TenMau' => $chiTietSanPham->MauSac->TenMau, // Thêm tên màu
                    'TenSize' => $chiTietSanPham->KichThuoc->TenSize, // Thêm tên kích thước
                    'MaCTSP' => $chiTietSanPham->MaCTSP,
                ];
            }
            // Cập nhật giỏ hàng trong session
            Session::put('gioHang', $gioHang);
        }
        return redirect()->route('cart')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng'); 
        
    }
    public function removeFromCart($MaGH,$MaCTSP)
    {
        $chiTietGioHang = ChiTietGioHang::where('MaGH', $MaGH)->where('MaCTSP', $MaCTSP)->delete();
        return redirect()->back()->with('success', 'Cart cleared successfully');
    }
    public function removeFromCartSS($MaCTSP)
    {
        // Lấy giỏ hàng từ session
        $gioHangSession = session()->get('gioHang', []);

        // Xóa sản phẩm khỏi giỏ hàng nếu tồn tại
        if (isset($gioHangSession[$MaCTSP])) {
            unset($gioHangSession[$MaCTSP]);
        }

        // Lưu lại giỏ hàng đã cập nhật vào session
        session()->put('gioHang', $gioHangSession);

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
    }
    public function update(Request $request)
    {
      
        if (Auth::check()) {
            // Người dùng đã đăng nhập
            // Lấy mảng các sản phẩm cần cập nhật từ request
            $items = $request->items;
    
            foreach ($items as $item) {
                // Cập nhật số lượng và thành tiền cho từng sản phẩm
                ChiTietGioHang::where([
                    'MaGH' => $item['MaGH'],
                    'MaCTSP' => $item['MaCTSP'],
                ])->update([
                    'SoLuong' => $item['SoLuong'],
                    'ThanhTien' => $item['SoLuong'] * $item['DonGia']
                ]);
            }
    
            // Cập nhật tổng giá trị của giỏ hàng
            $tongGiaTri = ChiTietGioHang::where('MaGH', $items[0]['MaGH'])->sum('ThanhTien');
            GioHang::where('MaGH', $items[0]['MaGH'])->update(['TongGiaTri' => $tongGiaTri]);
    
            return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật');
        } else {
            // Người dùng chưa đăng nhập
            // Lấy mảng các sản phẩm cần cập nhật từ request
            $items = $request->items;
    
            // Lấy giỏ hàng từ session
            $gioHangSession = session()->get('gioHang', []);
    
            foreach ($items as $item) {
                // Cập nhật số lượng và thành tiền cho từng sản phẩm
                if (isset($gioHangSession[$item['MaCTSP']])) {
                    $gioHangSession[$item['MaCTSP']]['SoLuong'] = $item['SoLuong'];
                    $gioHangSession[$item['MaCTSP']]['ThanhTien'] = $item['SoLuong'] * $item['DonGia'];
                }
            }
    
            // Cập nhật tổng giá trị của giỏ hàng
            $tongGiaTri = array_sum(array_column($gioHangSession, 'ThanhTien'));
            session()->put('gioHang', $gioHangSession);
    
            return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật');
        }
    }

    public function removeAllart()
    {
        if (Auth::check()) {
            // Người dùng đã đăng nhập
            $user = Auth::user();
            $maKH = $user->MaKH;
    
            // Tìm MaGH dựa trên MaKH
            $gioHang = GioHang::where('MaKH', $maKH)->first();
    
            if (!$gioHang) {
                return redirect()->back()->withErrors('Không tìm thấy giỏ hàng của bạn.');
            }
    
            $maGH = $gioHang->MaGH;
    
            // Xóa tất cả chi tiết giỏ hàng của giỏ hàng được chỉ định
            ChiTietGioHang::where('MaGH', $maGH)->delete();
    
            // Cập nhật tổng giá trị của giỏ hàng
            $gioHang->TongGiaTri = 0;
            $gioHang->save();
    
            return redirect()->back()->with('success', 'Giỏ hàng đã được xóa thành công');
        } else {
            // Người dùng chưa đăng nhập
            // Xóa toàn bộ giỏ hàng trong session
            session()->forget('gioHang');
    
            return redirect()->back()->with('success', 'Giỏ hàng đã được xóa thành công');
        }
    }

    
}
