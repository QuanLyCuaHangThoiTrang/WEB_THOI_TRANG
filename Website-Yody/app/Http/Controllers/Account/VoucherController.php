<?php

namespace App\Http\Controllers\Account;

use App\Models\Voucher;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::all();
        return view('Admin.Voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'MaVoucher' => 'required|unique:vouchers,MaVoucher|max:100',
            'TenVoucher' => 'required|max:200',
            'PhanTramGiamGia' => 'required|integer',
            'Active' => 'required|integer',
            'NgayBD' => 'nullable|date',
            'NgayKT' => 'nullable|date',
        ]);

        Voucher::create($request->all());
        return redirect()->route('vouchers.index')->with('success', 'Voucher created successfully.');
    }

    public function show(Voucher $voucher)
    {
        return view('vouchers.show', compact('voucher'));
    }

    public function edit(Voucher $voucher)
    {
        return view('vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'TenVoucher' => 'required|max:200',
            'PhanTramGiamGia' => 'required|integer',
            'Active' => 'required|integer',
            'NgayBD' => 'nullable|date',
            'NgayKT' => 'nullable|date',
        ]);

        $voucher->update($request->all());
        return redirect()->route('vouchers.index')->with('success', 'Voucher updated successfully.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('vouchers.index')->with('success', 'Voucher deleted successfully.');
    }
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
        $vouchers = Voucher::where('MaKH', $MaKH)->where('Active', '1');
    
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
    
        // Lấy dữ liệu với phân trang
        $vouchers = $vouchers->paginate(5);
    
        // Trả về view với danh sách voucher của khách hàng
        return view('account.settings.vouchers', compact('vouchers', 'khachhang'));
    }
}