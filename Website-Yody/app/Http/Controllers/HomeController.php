<?php

namespace App\Http\Controllers;

use App\Models\ChiTietSanPham;
use App\Models\KhuyenMai;
use App\Models\SanPham;
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
                ->from('SanPhamKhuyenMai');
        })->get();
        // Lấy khuyến mãi, nếu không có thì trả về null
        $khuyenMai = KhuyenMai::first();

        $SanPhamMoiNhat = ChiTietSanPham::orderBy('NgayThem', 'desc') // Sắp xếp theo cột NgayThem giảm dần
        ->limit(10) // Giới hạn số lượng sản phẩm trả về là 10
        ->get();

        // Truyền dữ liệu vào view
        return view('home.home', [
            'chiTietSanPhams' => $chiTietSanPhams,
            'SanPhamKhuyenMai' => $SanPhamKhuyenMai,
            'khuyenMai' => $khuyenMai,
            'SanPhamMoiNhat' => $SanPhamMoiNhat,
        ]);
    }
}