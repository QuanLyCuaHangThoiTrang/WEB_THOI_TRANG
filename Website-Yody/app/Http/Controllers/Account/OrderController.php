<?php

namespace App\Http\Controllers\Account;

use App\Models\KhachHang;
use App\Models\DonHang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng của khách hàng
    public function showOrders(Request $request, $maKH)
    {
        // Lấy thông tin khách hàng
        $khachhang = KhachHang::find($maKH);

        // Kiểm tra xem khách hàng có tồn tại không
        if (!$khachhang) {
            return redirect()->back()->withErrors(['error' => 'Khách hàng không tồn tại']);
        }

        // Lấy danh sách đơn hàng của khách hàng
        $query = DonHang::where('MaKH', $maKH);

        // Tìm kiếm đơn hàng theo mã đơn hàng
        if ($request->has('search') && $request->search !== '') {
            $query->where(function($q) use ($request) {
                $q->where('MaDH', 'like', '%' . $request->search . '%')
                  ->orWhere('TongGiaTri', 'like', '%' . $request->search . '%');
            });
        }

        // Sắp xếp theo trạng thái đơn hàng
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
               
            }
        }

        // Phân trang đơn hàng
        $orders = $query->paginate(10);

        return view('account.settings.orders', compact('orders', 'khachhang'));
    }

    // Hủy đơn hàng
    public function cancelOrder($maDH)
    {
        // Tìm đơn hàng theo mã đơn hàng
        $donHang = DonHang::find($maDH);

        // Kiểm tra xem đơn hàng có tồn tại không và trạng thái đơn hàng
        if (!$donHang) {
            return redirect()->back()->withErrors(['error' => 'Đơn hàng không tồn tại']);
        }

        // Kiểm tra trạng thái đơn hàng
        if ($donHang->TrangThai === 'Chưa xác nhận') {
            // Cập nhật trạng thái đơn hàng thành 'Đã hủy'
            $donHang->TrangThai = 'Đã hủy';
            $donHang->save();

            return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công');
        }

        return redirect()->back()->withErrors(['error' => 'Đơn hàng không thể hủy vì đã xác nhận']);
    }
    public function showOrderDetail($maKH, $maDH)
{
    // Lấy thông tin khách hàng
    $khachhang = KhachHang::find($maKH);

    // Kiểm tra xem khách hàng có tồn tại không
    if (!$khachhang) {
        return redirect()->back()->withErrors(['error' => 'Khách hàng không tồn tại']);
    }
    
    // Lấy thông tin chi tiết đơn hàng bao gồm sản phẩm
    $order = DonHang::with(['chiTietDonHang.chiTietSanPham.sanPham'])->find($maDH);

    // Kiểm tra xem đơn hàng có tồn tại không
    if (!$order) {
        return redirect()->back()->withErrors(['error' => 'Đơn hàng không tồn tại']);
    }

    return view('account.settings.order-detail', compact('order', 'khachhang'));
}


}