<?php

namespace App\Http\Controllers\Account;
use App\Models\Voucher;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class VoucherController extends Controller
{
    // Hiển thị danh sách voucher của khách hàng
    public function showCustomerVouchers($MaKH)
    {
        // Lấy thông tin khách hàng
        $khachhang = KhachHang::find($MaKH);
    
        // Kiểm tra nếu khách hàng không tồn tại
        if (!$khachhang) {
            return back()->withErrors(['error' => 'Khách hàng không tồn tại']);
        }
    
        // Lấy danh sách voucher của khách hàng dựa trên MaKH
        $vouchers = Voucher::with('khachhang')->where('MaKH', $MaKH)->get();
    
        // Trả về view với danh sách voucher của khách hàng
        return view('account.settings.vouchers', compact('vouchers', 'khachhang'));
    }
    
}