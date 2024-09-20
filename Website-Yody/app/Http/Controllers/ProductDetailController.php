<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChiTietSanPham;
use App\Models\KichThuoc;
use App\Models\MauSac;

class ProductDetailController extends Controller
{
    public function index($MaSP)
    {
        // Lấy chi tiết sản phẩm đầu tiên theo MaSP
        $chiTietSanPham = ChiTietSanPham::where('MaSP', $MaSP)->first();

        if (!$chiTietSanPham) {
            return abort(404, 'Chi tiết sản phẩm không tồn tại.');
        }

        // Lấy danh sách các mã màu sắc liên quan đến sản phẩm
        $mauSacIds = ChiTietSanPham::where('MaSP', $MaSP)->pluck('MaMau');
        $MauSac = MauSac::whereIn('MaMau', $mauSacIds)->get();

        // Lấy danh sách các mã kích thước liên quan đến sản phẩm
        $KichThuocIds = ChiTietSanPham::where('MaSP', $MaSP)->pluck('MaSize');
        $KichThuoc = KichThuoc::whereIn('MaSize', $KichThuocIds)->get();

        // Lấy chi tiết sản phẩm cho từng mã màu và mã kích thước
        $chiTietSanPhamList = ChiTietSanPham::where('MaSP', $MaSP)->get()->keyBy(function ($item) {
            return $item->MaMau . '-' . $item->MaSize; // Tạo key với mã màu và mã kích thước
        });

        // Truyền dữ liệu vào view
        return view('product_detail.index', [
            'chiTietSanPham' => $chiTietSanPham,
            'MauSac' => $MauSac,
            'KichThuoc' => $KichThuoc,
            'chiTietSanPhamList' => $chiTietSanPhamList,
            'SoLuongTonKho' => $chiTietSanPham->SoLuongTonKho,
            'selectedColor' => $chiTietSanPham->MaMau,
            'selectedSize' => $chiTietSanPham->MaSize,
        ]);
    }

    public function getSizesByColor($MaMau,$MaSP)
    {
        $kichThuocIds = ChiTietSanPham::where('MaMau', $MaMau)
        ->where('MaSP', $MaSP)
        ->distinct() // Chỉ lấy các kích thước khác nhau
        ->pluck('MaSize');

$KichThuoc = KichThuoc::whereIn('MaSize', $kichThuocIds)->get();

return response()->json($KichThuoc);
    }
    public function getProductDetails($maMau)
    {
        $chiTietSanPham = ChiTietSanPham::where('MaMau', $maMau)
                                        ->first(['SoLuongTonKho']);

        if ($chiTietSanPham) {
            return response()->json([
                'SoLuongTonKho' => $chiTietSanPham->SoLuongTonKho,
                
            ]);
        } else {
            return response()->json(['error' => 'Chi tiết sản phẩm không tồn tại.'], 404);
        }
    }
    
}
