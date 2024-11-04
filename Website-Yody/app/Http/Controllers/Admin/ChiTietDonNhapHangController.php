<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChiTietDonNhapHang;
use App\Models\DonNhapHang;
use App\Models\ChiTietSanPham;
use App\Models\ChiTietSanPhamNhap;

use Illuminate\Support\Facades\Auth;

class ChiTietDonNhapHangController extends Controller
{
    public function store(Request $request, $maNH)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $request->validate([
            'donnhaphang_id' => 'required|string',
            'products' => 'required|array',
            'products.*' => 'string',
        ]);

        $donnhaphangId = $request->input('donnhaphang_id');
        $products = $request->input('products');

        foreach ($products as $productId) {
            $existingRecord = ChiTietDonNhapHang::where('MaNH', $donnhaphangId)
                ->where('MaSP', $productId)
                ->first();

            if (!$existingRecord) {
                ChiTietDonNhapHang::create([
                    'MaNH' => $donnhaphangId,
                    'MaSP' => $productId,
                    'TongSoLuong' => 1, // Bạn có thể thay đổi giá trị này nếu cần
                    'GiaNhap' => 0, // Bạn có thể thay đổi giá trị này nếu cần
                    'ThanhTien' => 0 // Bạn có thể thay đổi giá trị này nếu cần
                ]);
            }
        }
      

        return redirect()->back()->with('success', 'Sản phẩm đã được lưu thành công.');
    }
    
    private function updateTongGiaTri($donnhaphangId)
    {
        // Tính tổng ThanhTien từ bảng ChiTietDonNhapHang
        $tongGiaTri = ChiTietDonNhapHang::where('MaNH', $donnhaphangId)
            ->sum('ThanhTien');
    
        // Cập nhật tổng giá trị vào bảng donnhaphang
        DonNhapHang::where('MaNH', $donnhaphangId)
            ->update(['TongGiaTri' => $tongGiaTri]);
    }
        public function update(Request $request, $maNH)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $validated = $request->validate([
            'MaSP' => 'required|string',
            'TongSoLuong' => 'required|integer',
            'GiaNhap' => 'required|numeric',
        ]);

        $chitiet = ChiTietDonNhapHang::where('MaNH', $maNH)
            ->where('MaSP', $request->MaSP)
            ->first();

        if ($chitiet) {
            $chitiet->TongSoLuong = $request->TongSoLuong;
            $chitiet->GiaNhap = $request->GiaNhap;
            $chitiet->ThanhTien = $request->TongSoLuong * $request->GiaNhap;
            $chitiet->save();
            $this->updateTongGiaTri($maNH);

            return response()->json([
                'success' => true,
                'new_total_price' => number_format($chitiet->ThanhTien)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm'
            ]);
        }
        
    }

    public function destroy($maNH, $maCTSP)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $chiTiet = ChiTietDonNhapHang::where('MaNH', $maNH)
            ->where('MaSP', $maCTSP)
            ->firstOrFail();

        $chiTiet->delete();
        ChiTietSanPhamNhap::where('MaNH', $maNH)
            ->where('MaSP', $maCTSP)
            ->delete();
        return redirect()->route('donnhaphang.show', $maNH)->with('success', 'Chi tiết đơn nhập hàng đã được xóa!');
    }


    // public function getMaCTSPOptions($maSP)
    // {
    //     if (!Auth::guard('admin')->check()) {
    //         return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    //     }
    //     $chitietsanphams = ChiTietSanPham::where('MaSP', $maSP)->get();

    //     $options = $chitietsanphams->map(function ($item) {
    //         return [
    //             'MaCTSP' => $item->MaCTSP,
    //             'MaMau' => $item->MaMau,
    //             'MaSize' => $item->MaSize,
    //         ];
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'maCTSPOptions' => $options
    //     ]);
    // }
    public function getMaCTSPOptions($maSP)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
    
        // Lấy danh sách chi tiết sản phẩm
        $chitietsanphams = ChiTietSanPham::where('MaSP', $maSP)->get();
    
        $options = $chitietsanphams->map(function ($item) {
            // Kiểm tra xem có dữ liệu trong bảng chitietsanphamnhap không
            $soLuongNhap = ChiTietSanPhamNhap::where('MaCTSP', $item->MaCTSP)->value('SoLuongNhap') ?? 0;
    
            return [
                'MaCTSP' => $item->MaCTSP,
                'MaMau' => $item->MaMau,
                'MaSize' => $item->MaSize,
                'SoLuongNhap' => $soLuongNhap // Lấy SoLuongNhap từ bảng chitietsanphamnhap, mặc định là 0 nếu không có
            ];
        });
    
        return response()->json([
            'success' => true,
            'maCTSPOptions' => $options
        ]);
    }

    public function store_CTSP(Request $request, $donnhaphang)
{
    if (!Auth::guard('admin')->check()) {
        return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    }
    
    $maSP = $request->input('maSP');
   $data = $request->except('maSP'); // Loại bỏ maSP từ dữ liệu để dễ xử lý
    
    foreach ($data['soLuongNhap'] as $maCTSP => $soLuongNhap) {
        if ($soLuongNhap >= 0) { // Cho phép số lượng nhập bằng 0 để có thể xóa bản ghi

            // Kiểm tra xem bản ghi đã tồn tại chưa
            $existingRecord = ChiTietSanPhamNhap::where('MaNH', $donnhaphang)
                                                 ->where('MaSP', $maSP)
                                                 ->where('MaCTSP', $maCTSP)
                                                 ->first();

            if ($existingRecord) { // Nếu bản ghi đã tồn tại, cập nhật
                if ($soLuongNhap > 0) {
                    $existingRecord->update(['SoLuongNhap' => $soLuongNhap]);
                } 
            } else { // Nếu chưa có bản ghi, tạo mới
                if ($soLuongNhap > 0) {
                    ChiTietSanPhamNhap::create([
                        'MaNH' => $donnhaphang,
                        'MaSP' => $maSP,
                        'MaCTSP' => $maCTSP,
                        'SoLuongNhap' => $soLuongNhap,
                    ]);
                }
            }
        }
    }
    
    // Cập nhật tổng số lượng trong bảng chitietdonnhaphang
    $this->updateTotalQuantity($donnhaphang, $maSP);

    return response()->json(['success' => true]);
}

private function updateTotalQuantity($donnhaphang, $maSP)
{
    // Tính tổng số lượng từ bảng ChiTietSanPhamNhap
    $totalQuantity = ChiTietSanPhamNhap::where('MaNH', $donnhaphang)
                                        ->where('MaSP', $maSP)
                                        ->sum('SoLuongNhap');

    // Cập nhật tổng số lượng trong bảng chitietdonnhaphang
    ChiTietDonNhapHang::where('MaNH', $donnhaphang)
                       ->where('MaSP', $maSP)
                       ->update(['TongSoLuong' => $totalQuantity]);
}
  
    }
