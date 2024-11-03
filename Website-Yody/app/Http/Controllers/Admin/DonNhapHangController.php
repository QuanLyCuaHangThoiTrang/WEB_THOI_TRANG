<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ChiTietDonNhapHang;
use App\Models\ChiTietSanPham;
use App\Models\DonNhapHang;
use App\Models\NhaCungCap;
use App\Models\SanPham;
use App\Models\ChiTietSanPhamNhap;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DonNhapHangController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $donnhaphangs = DonNhapHang::all();
        return view('Admin.DonNhapHang.index', compact('donnhaphangs'));
    }

    public function create()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $nhacungcaps = NhaCungCap::all();
        return view('Admin.DonNhapHang.create', compact('nhacungcaps'));
    }

    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        // Validate dữ liệu đầu vào
        $data = $request->validate([
            'MaNCC' => 'required',
            'NgayDatHang' => 'nullable|date|required',
            'TongGiaTri' => 'nullable|numeric|min:0.01',
        ], [
            'NgayDatHang.required' => 'Ngày đặt hàng không được để trống.',
            'TongGiaTri.numeric' => 'Tổng giá trị phải là số',
            'TongGiaTri.min' => 'Tổng giá trị phải lớn hơn 0',
        ]
    );

        // Tạo mã đơn nhập hàng duy nhất
        $data['MaNH'] = $this->generateUniqueMaNH();

        // Lưu đơn nhập hàng vào cơ sở dữ liệu
        DonNhapHang::create($data);

        // Chuyển hướng về trang danh sách và thông báo thành công
        return redirect()->route('donnhaphang.index')->with('success', 'Đơn nhập hàng đã được tạo thành công!');
    }

    // Phương thức tạo mã đơn nhập hàng duy nhất
    private function generateUniqueMaNH()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        do {
            // Tạo số ngẫu nhiên sau tiền tố NH
            $number = rand(1000, 9999); // Bạn có thể thay đổi phạm vi số nếu cần
            $maNH = 'NH' . $number;
        } while (DonNhapHang::where('MaNH', $maNH)->exists());

        return $maNH;
    }

    public function show($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $donnhaphang = DonNhapHang::with('nhacungcap', 'chitietdonnhaphangs')->findOrFail($id);
        $sanphams = SanPham::all();
        $chitietsanphams = ChiTietSanPham::all();
    
        // Lấy danh sách sản phẩm đã có trong ChiTietDonNhapHang
        $existingProductIds = $donnhaphang->chitietdonnhaphangs->pluck('MaSP')->toArray();
    
        return view('Admin.DonNhapHang.show', compact('donnhaphang', 'sanphams', 'chitietsanphams', 'existingProductIds'));
    }

    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $donnhaphang = DonNhapHang::findOrFail($id);
        $nhacungcaps = NhaCungCap::all(); // Lấy tất cả nhà cung cấp để chọn

        return view('Admin.DonNhapHang.edit', compact('donnhaphang', 'nhacungcaps'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $request->validate([
            'MaNCC' => 'required',
            'NgayDatHang' => 'required|date', // Ngày Đặt Hàng is required and must be a valid date
            'TongGiaTri' => 'nullable|numeric|min:0.01',
        ], [
            'NgayDatHang.required' => 'Ngày đặt hàng không được để trống.',
            'TongGiaTri.numeric' => 'Tổng giá trị phải là số',
            'TongGiaTri.min' => 'Tổng giá trị phải lớn hơn 0',
        ]
    
    
         );

        $donnhaphang = DonNhapHang::findOrFail($id);
        $donnhaphang->update($request->all());

        return redirect()->route('donnhaphang.index')
                         ->with('success', 'Đơn nhập hàng được cập nhật thành công.');
    }

    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $donnhaphang = DonNhapHang::findOrFail($id);
        ChiTietDonNhapHang::where('MaNH', $id)->delete();

    // Xóa tất cả các chi tiết sản phẩm nhập trong bảng chitietsanphamnhap
        ChiTietSanPhamNhap::where('MaNH', $id)->delete();

        $donnhaphang->delete();

        return redirect()->route('donnhaphang.index')
                         ->with('success', 'Đơn nhập hàng được xóa thành công.');
    }
    public function print($MaNH)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
    
        // Lấy thông tin đơn nhập hàng cùng với chi tiết và số lượng của sản phẩm
        $donnhaphang = DonNhapHang::with('chitietdonnhaphangs.chitietSanPhamNhap')->findOrFail($MaNH);

        // Lọc chi tiết sản phẩm nhập theo MaSP
        foreach ($donnhaphang->chitietdonnhaphangs as $chitiet) {
            $chitiet->chitietSanPhamNhap = $chitiet->chitietSanPhamNhap->where('MaSP', $chitiet->MaSP);
        }
        $pdf = PDF::loadView('Admin.DonNhapHang.print', compact('donnhaphang'));
      
        // Return the generated PDF to the browser
        return $pdf->stream('don_nhap_hang_' . $donnhaphang->MaNH . '.pdf');
    }
}
