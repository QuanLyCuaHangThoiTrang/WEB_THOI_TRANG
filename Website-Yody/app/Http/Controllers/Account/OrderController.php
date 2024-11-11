<?php

namespace App\Http\Controllers\Account;
use Illuminate\Support\Str;
use App\Models\KhachHang;
use App\Models\ChiTietDonHang;
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
                    $query->where('TrangThai', 'Chờ xác nhận');
                    break;
                case 'da_xac_nhan':
                    $query->where('TrangThai', 'Đã xác nhận');
                    break;
                case 'chua_giao':
                    $query->where('TrangThai', 'Đang giao');
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
        if ($donHang->TrangThai === 'Chờ xác nhận') {
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
    
        // Kiểm tra xem tất cả sản phẩm đã được đánh giá hay chưa
        $allRated = $order->chiTietDonHang->every(function ($chiTiet) {
            return $chiTiet->DaDanhGia; // Kiểm tra xem tất cả đã đánh giá hay chưa
        });
        
        // Truyền biến $canRate và $allRated đến view
        return view('account.settings.order-detail', compact('order', 'khachhang', 'canRate', 'allRated'));
    }
    

public function rateProduct(Request $request, $maKH)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'DiemDanhGia' => 'required|integer|between:1,5',
        'NoiDung' => 'nullable|string',
        'MaCTSP' => 'required|string' // Thêm xác thực cho mã sản phẩm
    ]);

    // Tạo mã đánh giá duy nhất
    do {
        $randomString = Str::random(6);
        $MaDG = 'DG' . $randomString;
    } while (DanhGia::where('MaDG', $MaDG)->exists());

    // Lưu đánh giá vào bảng DanhGia
    $danhGia = new DanhGia();
    $danhGia->MaDG = $MaDG;
    $danhGia->MaKH = $maKH;
    $danhGia->MaCTSP = $request->MaCTSP; // Sử dụng mã sản phẩm từ request
    $danhGia->DiemDanhGia = $request->DiemDanhGia;
    $danhGia->NoiDung = $request->NoiDung;
    $danhGia->NgayDanhGia = now();
    $danhGia->save();

    // Cập nhật trạng thái "DaDanhGia" cho sản phẩm đã được đánh giá
    ChiTietDonHang::where('MaCTSP', $request->MaCTSP)
                  ->whereHas('donHang', function ($query) use ($maKH) {
                      $query->where('MaKH', $maKH);
                  })
                  ->update(['DaDanhGia' => true]);

    // Chuyển hướng về trang đánh giá hoặc hiển thị thông báo
    return redirect()->back()->with('success', 'Đánh giá đã được ghi nhận!');
}

}