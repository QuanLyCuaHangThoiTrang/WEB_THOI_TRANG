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
        $vouchers = Voucher::paginate(5);
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

    public function destroy($MaVoucher)
    {
        $voucher = Voucher::findOrFail($MaVoucher);
        $voucher->delete();
        return redirect()->route('vouchers.index')->with('success', 'Voucher đã được xóa thành công');
    }
    // Hiển thị danh sách voucher của khách hàng
    public function showCustomerVouchers(Request $request, $locale, $MaKH)
    {
        // Get the customer information
        $khachhang = KhachHang::find($MaKH);
    
        // Check if the customer exists
        if (!$khachhang) {
            return back()->withErrors(['error' => 'Khách hàng không tồn tại']);
        }
    
        // Fetch the vouchers for the customer
        $vouchers = Voucher::where('MaKH', $MaKH)->where('Active', 1);
    
        // Apply search if available
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $vouchers = $vouchers->where(function ($query) use ($searchTerm) {
                $query->where('TenVoucher', 'like', '%' . $searchTerm . '%')
                      ->orWhere('MaVoucher', 'like', '%' . $searchTerm . '%');
            });
        }
    
        // Apply sorting if available
        $validSorts = ['percent_asc', 'percent_desc', 'date_asc', 'date_desc'];
        if ($request->has('sort') && in_array($request->sort, $validSorts)) {
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
    
        // Paginate the vouchers
        $vouchers = $vouchers->paginate(5);
    
        // Return the view with the data
        return view('account.settings.vouchers', compact('vouchers', 'khachhang', 'locale'));
    }
    

}