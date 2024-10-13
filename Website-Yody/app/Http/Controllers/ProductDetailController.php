<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChiTietSanPham;
use App\Models\KichThuoc;
use App\Models\DanhGia;
use App\Models\SanPham;
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
        $hinhAnhList = ChiTietSanPham::where('MaSP', $MaSP)
        ->groupBy('MaMau') // Nhóm theo mã màu
        ->selectRaw('MaMau, MIN(HinhAnh) as HinhAnh') // Sử dụng MIN hoặc MAX để lấy hình ảnh đầu tiên hoặc cuối cùng
        ->get();
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
        $danhGias = $this->getDanhGiaByMaSP($MaSP);   
            // Tính tổng số lượng đánh giá
        $tongSoDanhGia = $danhGias->count(); 
        // Truyền dữ liệu vào view
        return view('product_detail.index', [
            'chiTietSanPham' => $chiTietSanPham,
            'MauSac' => $MauSac,
            'KichThuoc' => $KichThuoc,
            'chiTietSanPhamList' => $chiTietSanPhamList,
            'SoLuongTonKho' => $chiTietSanPham->SoLuongTonKho,
            'selectedColor' => $chiTietSanPham->MaMau,
            'selectedSize' => $chiTietSanPham->MaSize,
            'hinhAnhList' => $hinhAnhList,
            'danhGias' => $danhGias,
            'tongSoDanhGia' => $tongSoDanhGia,  // Truyền tổng số đánh giá vào view
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
    public function getImageByMaSPAndMaMau(Request $request)
    {
        $maSP = $request->query('maSP');
        $maMau = $request->query('maMau');
        $chiTietSanPham = ChiTietSanPham::where('MaSP', $maSP)
            ->where('MaMau', $maMau)
            ->first(['HinhAnh']);
        
        if ($chiTietSanPham) {
            return response()->json([
                'HinhAnh' => asset('images/products/' . $chiTietSanPham->HinhAnh),
            ]);
        } else {
            return response()->json(['error' => 'Hình ảnh không tồn tại.'], 404);
        }
    }
    public function getDanhGiaByMaSP($MaSP)
    {
        $sanPham = SanPham::with(['chiTietSanPhams.danhGias'])
                    ->where('MaSP', $MaSP)
                    ->first();
                 
        $danhGias = collect();
        if ($sanPham) {
            foreach ($sanPham->chiTietSanPhams as $chiTiet) {
                $danhGias = $danhGias->merge($chiTiet->danhGias);              
            }
        }
        return $danhGias;
    }
}