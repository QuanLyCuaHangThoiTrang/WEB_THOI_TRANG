<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\ChiTietDonHang;
use App\Models\KhachHang;
use App\Models\DonHang;
use App\Models\GioHang;
use Illuminate\Support\Facades\Auth;
use App\Models\SanPham;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $latestOrders = DonHang::orderBy('NgayDatHang', 'desc') // Sắp xếp theo ngày đặt hàng mới nhất
                                ->take(5) // Lấy 5 đơn hàng mới nhất
                                ->get();
        // Tính tổng doanh thu trong tháng hiện tại
        $totalRevenue = DonHang::whereMonth('NgayDatHang', $currentMonth)
                            ->whereYear('NgayDatHang', $currentYear)
                            ->where('TrangThai','Giao Thành Công')
                            ->sum('TongGiaTri');
        $totalOrder = DonHang::count();
        $number_product = ChiTietDonHang::select('MaCTSP')
                                        ->groupBy('MaCTSP')
                                        ->get()
                                        ->count();
        $number_customer = KhachHang::count();   
        $products = SanPham::with(['chitietsanphams.chiTietDonHangs'])->get();

        $bestSellingProducts = $products->map(function ($product) {
            $totalSold = 0;

            // Duyệt qua từng chi tiết sản phẩm và tính tổng số lượng bán
            foreach ($product->chitietsanphams as $chiTietSanPham) {
                foreach ($chiTietSanPham->chiTietDonHangs as $chiTietDonHang) {
                    $totalSold += $chiTietDonHang->SoLuong;
                }
            }

            // Trả về dữ liệu với thông tin tổng số lượng bán
            return [
                'MaSP' => $product->MaSP,
                'TenSP' => $product->TenSP,
                'SoLuongBan' => $totalSold
            ];
        });

        // Sắp xếp các sản phẩm theo số lượng bán
        $bestSellingProducts = $bestSellingProducts->sortByDesc('SoLuongBan')->take(5);

        return view('Admin.dashboard',compact('totalRevenue','totalOrder','number_product','number_customer','latestOrders','bestSellingProducts'));
        }
        else
        {
            return redirect('/login');
        }
    }
    public function getOrdersForCurrentMonth()
    {
        // Lấy tháng và năm hiện tại
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
    
        // Truy vấn để lấy các đơn hàng trong tháng hiện tại, nhóm theo ngày
        $ordersData = DonHang::whereMonth('NgayDatHang', $currentMonth)
                            ->whereYear('NgayDatHang', $currentYear)
                            ->selectRaw('DATE(NgayDatHang) as period, SUM(TongGiaTri) as `order`')
                            ->groupBy('period') // Sử dụng 'period' cho phù hợp với dữ liệu
                            ->orderBy('period', 'ASC')
                            ->get();
    
        // Chuẩn bị dữ liệu để trả về cho biểu đồ
        $chart_data = [];
        foreach ($ordersData as $order) {
            $chart_data[] = [
                'period' => $order->period, // Đổi từ 'date' thành 'period' để phù hợp với xkey
                'order' => $order->order // Đổi từ 'total_orders' thành 'order' để phù hợp với ykeys
            ];
        }
    
        // Trả về dữ liệu dưới dạng JSON để JavaScript xử lý
        return response()->json($chart_data);
    }
    

}