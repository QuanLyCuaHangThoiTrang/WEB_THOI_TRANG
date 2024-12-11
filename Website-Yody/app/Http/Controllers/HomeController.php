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
                ->from('SanPhamKhuyenMai');
        })->get();
         // Lấy khuyến mãi, nếu không có thì trả về null
        $khuyenMaiHomes = KhuyenMai::where('NgayKetThuc', '>', now())->first();

        $SanPhamUaChuongs = ChiTietDonHang::selectRaw(
            'SanPham.MaSP,
                        SanPham.TenSP,
                        SanPham.GiaGiam,
                        SanPham.GiaBan, 
                        SUM(ChiTietDonHang.SoLuong) as total_sold,
                        (SELECT ChiTietSanPham.HinhAnh 
                        FROM ChiTietSanPham 
                        WHERE ChiTietSanPham.MaSP = SanPham.MaSP 
                        ORDER BY ChiTietSanPham.MaCTSP ASC 
                        LIMIT 1
                        ) as HinhAnh'
        )
        ->join('ChiTietSanPham', 'ChiTietDonHang.MaCTSP', '=', 'ChiTietSanPham.MaCTSP') // Kết nối bảng ChiTietSanPham
        ->join('SanPham', 'ChiTietSanPham.MaSP', '=', 'SanPham.MaSP') // Kết nối bảng SanPham
        ->groupBy('SanPham.MaSP', 'SanPham.TenSP','SanPham.GiaGiam','SanPham.GiaBan') // Nhóm theo MaSP và TenSP
        ->orderBy('total_sold', 'desc') // Sắp xếp giảm dần theo số lượng bán
        ->take(5) // Lấy 5 sản phẩm được mua nhiều nhất
        ->get();

        // Truyền dữ liệu vào view
        return view('home.home', [
            'chiTietSanPhams' => $chiTietSanPhams,
            'SanPhamKhuyenMai' => $SanPhamKhuyenMai,
            'khuyenMai' => $khuyenMaiHomes,
            'SanPhamUaChuongs' => $SanPhamUaChuongs
        ]);
    }
}