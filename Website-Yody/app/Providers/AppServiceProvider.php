<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\DanhMuc;
use App\Models\SanPham;
use App\Models\KhuyenMai;
use App\Models\Voucher;
use Illuminate\Container\Attributes\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $danhmucs = DanhMuc::with('chiTietDanhMuc')->get();
        view()->share('danhmucs', $danhmucs);

        $sanPhamTKs = SanPham::with(['chiTietSanPham.mauSac', 'chiTietSanPham.kichThuoc'])
            ->where('TrangThai', 1) // Thêm điều kiện lấy trạng thái là 1
            ->has('chiTietSanPham')
            ->get();

        view()->share('sanPhamTKs', $sanPhamTKs);

        $KhuyenMais = KhuyenMai::where('NgayKetThuc', '>', now())->get();
        view()->share('KhuyenMais', $KhuyenMais);
    }
}
