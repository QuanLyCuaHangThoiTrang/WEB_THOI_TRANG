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
        'Phuong' => 'required|string|max:200',
        'Huyen' => 'required|string|max:200',
        'Tinh' => 'required|string|max:200',
    ], [
        'Duong.required' => 'Địa chỉ là bắt buộc.',
        'Duong.string' => 'Địa chỉ phải là một chuỗi ký tự.',
        'Duong.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
        'Tinh.required' => 'Tỉnh là bắt buộc.',
        'Huyen.required' => 'Quận/Huyện là bắt buộc.',
        'Phuong.required' => 'Phường/Xã là bắt buộc.',
    ]);

    
    // Kiểm tra giá trị của các trường ẩn
    if (empty($request->hidden_tinh) || empty($request->hidden_quan) || empty($request->hidden_phuong)) {
        return back()->withErrors(['error' => 'Vui lòng chọn đầy đủ thông tin về tỉnh, quận và phường.']);
    }

    $address = new DiaChiKhachHang();
    $address->MaDC = uniqid(); // Tạo mã ngẫu nhiên cho MaDC nếu không dùng AUTO_INCREMENT
    $address->MaKH = $request->input('MaKH');
    $address->Duong = $request->Duong;
    $address->Tinh = $request->hidden_tinh; // Lưu tên tỉnh
    $address->Huyen = $request->hidden_quan; // Lưu tên quận
    $address->Phuong = $request->hidden_phuong; // Lưu tên phường
    $address->save();

    return back()->with('success', 'Địa chỉ đã được thêm thành công');
}


    public function deleteAddress($MaDC)
    {   
        $address = DiaChiKhachHang::find($MaDC);

        if (!$address) {
            return back()->withErrors(['error' => 'Địa chỉ không tồn tại']);
        }
        
        $address->delete();
        return back()->with('success', 'Địa chỉ đã được xoá thành công');
    }
}