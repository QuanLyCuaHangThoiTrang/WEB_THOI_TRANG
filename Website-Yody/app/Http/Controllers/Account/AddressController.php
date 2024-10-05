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
            'MaKH' => 'required|exists:khachhang,MaKH',
            'Duong' => 'required|string|max:255',
            'Phuong' => 'nullable|string|max:200',
            'Huyen' => 'nullable|string|max:200',
            'Tinh' => 'nullable|string|max:200',
        ]);
    
        $address = new DiaChiKhachHang();
        $address->MaDC = uniqid(); // Tạo mã ngẫu nhiên cho MaDC nếu không dùng AUTO_INCREMENT
        $address->MaKH = $request->input('MaKH');
        $address->Duong = $request->Duong;
        $address->Tinh = $request->hidden_tinh; // Lưu tên tỉnh
        $address->Huyen = $request->hidden_quan; // Lưu tên quận
        $address->Phuong = $request->hidden_phuong; // Lưu tên phường
        $address->save();
    
        return back()->with('success', 'Địa chỉ đã được thêm thành công.');
    }
    // ALTER TABLE diachikhachhang MODIFY COLUMN MaDC VARCHAR(20);
    public function deleteAddress($MaDC)
{   
    $address = DiaChiKhachHang::find($MaDC);

    if (!$address) {
        return back()->withErrors(['error' => 'Địa chỉ không tồn tại']);
    }
    
    $address->delete();
    return back()->with('success', 'Địa chỉ đã được xoá thành công.');
}

}