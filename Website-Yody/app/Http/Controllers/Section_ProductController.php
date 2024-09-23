<?php

namespace App\Http\Controllers;

use App\Models\ChiTietSanPham;
use Illuminate\Http\Request;

class Section_ProductController extends Controller
{
    public function showProducts()
    {
        $chiTietSanPhams = ChiTietSanPham::with(['sanPham', 'kichThuoc', 'mauSac'])
            ->whereHas('sanPham', function($query) {
                $query->where('TrangThai', 1); // Chỉ lấy sản phẩm có trạng thái là 1
            })
            ->whereIn('MaCTSP', function($query) {
                // Lấy MaCTSP đầu tiên cho mỗi MaSP
                $query->selectRaw('MIN(MaCTSP)')
                    ->from('chitietsanpham')
                    ->groupBy('MaSP');
            })
            ->paginate(3); // Phân trang với 12 sản phẩm

        return view('home.components.section-product', ['chiTietSanPhams' => $chiTietSanPhams]);
    }
}
