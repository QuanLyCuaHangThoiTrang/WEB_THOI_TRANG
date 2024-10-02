<?php

namespace App\Http\Controllers;

use App\Models\ChiTietSanPham;
use App\Models\KichThuoc;
use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\MauSac;

class ShopController extends Controller
{
    public function index()
    {
        $chiTietSanPhams = ChiTietSanPham::with(['sanPham', 'kichThuoc', 'mauSac'])
        ->whereHas('sanPham', function($query) {
            $query->where('TrangThai', 1); // Kiểm tra trạng thái của sản phẩm
        })
        ->whereIn('MaCTSP', function($query) {
            // Truy vấn con để lấy MaCTSP đầu tiên cho mỗi MaSP
            $query->selectRaw('MIN(MaCTSP)')
                ->from('chitietsanpham')
                ->groupBy('MaSP');
        })
        ->paginate(8); // Phân trang với 10 mục trên mỗi trang
        $mauSac = MauSac::all();
        $size = KichThuoc::all();
        return view('products.products', ['chiTietSanPhams' => $chiTietSanPhams,'MauSacs' => $mauSac,'KichThuocs' => $size]);
    }  
    public function showProducts($MaCTDM)
    {
        $chiTietSanPhams = ChiTietSanPham::with(['sanPham', 'kichThuoc', 'mauSac'])
        ->whereHas('sanPham', function($query) use ($MaCTDM) {
            $query->where('MaCTDM', $MaCTDM)
            ->where('TrangThai', 1); // Kiểm tra trạng thái của sản phẩm
        })
        ->whereIn('MaCTSP', function($query) {
            // Truy vấn con để lấy MaCTSP đầu tiên cho mỗi MaSP
            $query->selectRaw('MIN(MaCTSP)')
                ->from('chitietsanpham')
                ->groupBy('MaSP');
        })
        ->paginate(12); // Phân trang với 10 mục trên mỗi trang
        $mauSac = MauSac::all();
        $size = KichThuoc::all();
        return view('products.products', ['chiTietSanPhams' => $chiTietSanPhams,'MauSacs' => $mauSac,'KichThuocs' => $size]);
    }
}
