<?php

namespace App\Http\Controllers\Account;

use App\Models\KhachHang;
use App\Models\DonHang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng của khách hàng
    public function showOrders($MaKH)
    {
        // Lấy thông tin khách hàng
        $khachhang = KhachHang::find($MaKH);
        
        // Kiểm tra xem khách hàng có tồn tại không
        if (!$khachhang) {
            return redirect()->back()->withErrors(['error' => 'Khách hàng không tồn tại']);
        }

        // Lấy danh sách đơn hàng của khách hàng
        $orders = DonHang::where('MaKH', $MaKH)->get();

        return view('account.settings.orders', compact('orders', 'khachhang')); // Truyền biến vào view
    }
    public function index(Request $request, $maKH)
{
    $query = DonHang::where('MaKH', $maKH);

    if ($request->has('search')) {
        $query->where('MaDH', 'like', '%' . $request->search . '%');
    }

    if ($request->has('sort')) {
        switch ($request->sort) {
            case 'chua_xac_nhan':
                $query->where('TrangThai', 'Chưa xác nhận');
                break;
            case 'da_xac_nhan':
                $query->where('TrangThai', 'Đã xác nhận');
                break;
            case 'chua_giao':
                $query->where('TrangThai', 'Chưa giao');
                break;
            case 'giao_thanh_cong':
                $query->where('TrangThai', 'Giao thành công');
                break;
            case 'tien_mat':
                $query->where('PhuongThucThanhToan', 'Tiền mặt');
                break;
            case 'momo':
                $query->where('PhuongThucThanhToan', 'MoMo');
                break;
        }
    }

    $orders = $query->get();

    return view('account.order-history', compact('orders', 'maKH'));
}

}