<?php

namespace App\Http\Controllers;

use App\Models\ChiTietSanPham;
use App\Models\KhuyenMai;
use App\Models\SanPham;
use App\Models\ChiTietDonHang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function home()
    {
        $chiTietSanPhams = ChiTietSanPham::with(['sanPham', 'kichThuoc', 'mauSac'])
            ->whereHas('sanPham', function($query) {
                $query->where('TrangThai', 1); // Kiểm tra trạng thái của sản phẩm
            })
            ->whereIn('MaCTSP', function($query) {
                $query->selectRaw('MIN(MaCTSP)')
                    ->from('chitietsanpham')
                    ->groupBy('MaSP');
            })
            ->paginate(12); // Phân trang với 12 mục trên mỗi trang

        $SanPhamKhuyenMai = SanPham::whereIn('MaSP', function($query) {
            $query->select('MaSP')
                ->from('sanphamkhuyenmai');
        })->get();
         // Lấy khuyến mãi, nếu không có thì trả về null
        $khuyenMai = KhuyenMai::first();

        $SanPhamUaChuongs = ChiTietDonHang::selectRaw(
            'sanpham.MaSP,
             sanpham.TenSP,
             sanpham.GiaGiam,
             sanpham.GiaBan,
             SUM(chitietdonhang.SoLuong) as total_sold,
             (SELECT chitietsanpham.HinhAnh
              FROM chitietsanpham
              WHERE chitietsanpham.MaSP = sanpham.MaSP
              ORDER BY chitietsanpham.MaCTSP ASC
              LIMIT 1
             ) as HinhAnh'
        )
        ->join('chitietsanpham', 'chitietdonhang.MaCTSP', '=', 'chitietsanpham.MaCTSP')
        ->join('sanpham', 'chitietsanpham.MaSP', '=', 'sanpham.MaSP')
        ->groupBy('sanpham.MaSP', 'sanpham.TenSP', 'sanpham.GiaGiam', 'sanpham.GiaBan')
        ->orderBy('total_sold', 'desc')
        ->take(5)
        ->get();

        // Truyền dữ liệu vào view
        return view('home.home', [
            'chiTietSanPhams' => $chiTietSanPhams,
            'SanPhamKhuyenMai' => $SanPhamKhuyenMai,
            'khuyenMai' => $khuyenMai,
            'SanPhamUaChuongs' => $SanPhamUaChuongs
        ]);
    }
}