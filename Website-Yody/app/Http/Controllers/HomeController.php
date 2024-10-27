<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;
use App\Models\ChiTietSanPham;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    
    public function home()
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
        ->paginate(12); // Phân trang với 10 mục trên mỗi trang

    // Truyền dữ liệu vào view
    return view('home.home', ['chiTietSanPhams' => $chiTietSanPhams]);
    }  
    
}