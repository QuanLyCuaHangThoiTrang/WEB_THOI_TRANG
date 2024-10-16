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
        $sanPhams = SanPham::with(['chiTietSanPham.mauSac', 'chiTietSanPham.kichThuoc'])
        ->where('TrangThai', 1) // Thêm điều kiện lấy trạng thái là 1
        ->has('chiTietSanPham')
        ->paginate(12);
        $mauSac = MauSac::all();
        $size = KichThuoc::all();
        return view('products.products', ['sanPhams' => $sanPhams,'MauSacs' => $mauSac,'KichThuocs' => $size]);
    }  
    public function showProducts($MaCTDM)
    {
        $sanPhams = SanPham::with(['chiTietSanPham.mauSac', 'chiTietSanPham.kichThuoc'])
        ->where('MaCTDM',$MaCTDM)
        ->where('TrangThai', 1) // Thêm điều kiện lấy trạng thái là 1
        ->has('chiTietSanPham')
        ->paginate(perPage: 12);;
        $mauSac = MauSac::all();
        $size = KichThuoc::all();
        return view('products.products', ['sanPhams' => $sanPhams,'MauSacs' => $mauSac,'KichThuocs' => $size]);
    }
}