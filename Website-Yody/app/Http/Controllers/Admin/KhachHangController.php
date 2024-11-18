<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\KhachHang;
use App\Models\DonHang;
use App\Models\GioHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KhachHangController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
    
        // Lấy tất cả khách hàng từ bảng khachhang, sắp xếp khách hàng thân thiết lên đầu
        $khachHangs = KhachHang::orderByDesc('SoVoucher')->paginate(5);
    
        // Trả về view và truyền danh sách khách hàng sang view
        return view('Admin.KhachHang.index', compact('khachHangs'));
    }
    

    // Phương thức xóa một khách hàng (delete)
    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $khachHang = KhachHang::findOrFail($id);

    // Kiểm tra xem khách hàng có đơn hàng nào không
        $donHangCount = DonHang::where('MaKH', $id)->count();

        // Kiểm tra xem khách hàng có giỏ hàng nào không
        $gioHangCount = GioHang::where('MaKH', $id)->count();

        // Nếu khách hàng có đơn hàng hoặc giỏ hàng
        if ($donHangCount > 0 || $gioHangCount > 0) {
            return redirect()->route('khachhang.index')
                ->with('error', 'Không thể xóa khách hàng này vì có đơn hàng hoặc giỏ hàng liên quan.');
        }

        // Nếu không có đơn hàng hoặc giỏ hàng, tiến hành xóa
        $khachHang->delete();

    
            return redirect()->route('Admin.KhachHang.index')->with('success', 'Khách hàng đã được xóa thành công.');
        }
}
