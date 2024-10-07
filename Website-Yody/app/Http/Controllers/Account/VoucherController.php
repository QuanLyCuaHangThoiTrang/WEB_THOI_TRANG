<?php

namespace App\Http\Controllers\Account;
use App\Models\Voucher;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class VoucherController extends Controller
{
    // Hiển thị danh sách voucher của khách hàng
    public function showCustomerVouchers(Request $request, $MaKH)
    {
        // Lấy thông tin khách hàng
        $khachhang = KhachHang::find($MaKH);
    
        // Kiểm tra nếu khách hàng không tồn tại
        if (!$khachhang) {
            return back()->withErrors(['error' => 'Khách hàng không tồn tại']);
        }
    
        // Lấy danh sách voucher của khách hàng
        $vouchers = Voucher::where('MaKH', $MaKH);
    
        // Tìm kiếm theo tên hoặc mã voucher
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $vouchers = $vouchers->where(function ($query) use ($searchTerm) {
                $query->where('TenVoucher', 'like', '%' . $searchTerm . '%')
                      ->orWhere('MaVoucher', 'like', '%' . $searchTerm . '%');
            });
        }
    
        // Phân loại
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'percent_asc':
                    $vouchers = $vouchers->orderBy('PhanTramGiamGia', 'asc');
                    break;
                case 'percent_desc':
                    $vouchers = $vouchers->orderBy('PhanTramGiamGia', 'desc');
                    break;
                case 'date_asc':
                    $vouchers = $vouchers->orderBy('NgayKT', 'asc');
                    break;
                case 'date_desc':
                    $vouchers = $vouchers->orderBy('NgayKT', 'desc');
                    break;
            }
        }
    
        // Lấy dữ liệu
        $vouchers = $vouchers->get();
    
        // Trả về view với danh sách voucher của khách hàng
        return view('account.settings.vouchers', compact('vouchers', 'khachhang'));
    }
    

}