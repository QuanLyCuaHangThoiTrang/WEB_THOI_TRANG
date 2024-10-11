<?php

namespace App\Http\Controllers\Account;

use App\Models\KhachHang;
use App\Models\DanhGia;
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
    
        // Kiểm tra xem khách hàng có thể đánh giá hay không
        $canRate = $order->TrangThai === 'Giao thành công';
    
        // Truyền biến $canRate đến view
        return view('account.settings.order-detail', compact('order', 'khachhang', 'canRate'));
    }
    
public function rateProduct(Request $request, $maKH, $maCTSP)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'DiemDanhGia' => 'required|integer|between:1,5',
            'NoiDung' => 'nullable|string',
        ]);

        // Lưu đánh giá
        $danhGia = new DanhGia();
        $danhGia->MaKH = $maKH;
        $danhGia->MaCTSP = $maCTSP;
        $danhGia->DiemDanhGia = $request->DiemDanhGia;
        $danhGia->NoiDung = $request->NoiDung;
        $danhGia->NgayDanhGia = now(); // Ghi lại ngày đánh giá
        $danhGia->save();

        
        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!')->with('rated', true);

    }
    


}