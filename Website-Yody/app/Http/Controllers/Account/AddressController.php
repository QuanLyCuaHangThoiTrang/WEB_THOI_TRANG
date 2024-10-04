<?php

namespace App\Http\Controllers\Account;
use App\Models\KhachHang;
use App\Models\DiaChiKhachHang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function showAddresses($MaKH)
    {
        $addresses = DiaChiKhachHang::where('MaKH', $MaKH)->get(); // Lấy địa chỉ của khách hàng
        $khachhang = KhachHang::find($MaKH); // Lấy thông tin khách hàng
    
        // Kiểm tra xem khách hàng có tồn tại không
        if (!$khachhang) {
            return redirect()->back()->withErrors(['error' => 'Khách hàng không tồn tại']);
        }
    
        return view('account.settings.addresses', compact('addresses', 'MaKH', 'khachhang')); // Truyền biến $khachhang vào view
    }
    public function createAddress(Request $request)
    {
        $request->validate([
            'MaKH' => 'required|exists:khach_hang,MaKH', // Kiểm tra MaKH có tồn tại không
            'Duong' => 'required|string|max:255',
            'Phuong' => 'nullable|string|max:200',
            'Huyen' => 'nullable|string|max:200',
            'Tinh' => 'nullable|string|max:200',
        ]);

        $address = new DiaChiKhachHang();
        $address->MaKH = $request->input('MaKH');
        $address->Duong = $request->input('Duong');
        $address->Phuong = $request->input('Phuong');
        $address->Huyen = $request->input('Huyen');
        $address->Tinh = $request->input('Tinh');
        $address->save();

        return back()->with('success', 'Địa chỉ đã được thêm thành công.');
    }

    public function deleteAddress($MaDC)
    {
        $address = DiaChiKhachHang::findOrFail($MaDC);
        $address->delete();

        return back()->with('success', 'Địa chỉ đã được xóa thành công.');
    }
    
}