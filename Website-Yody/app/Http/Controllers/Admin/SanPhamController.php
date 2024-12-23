<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Models\ChiTietSanPham;
use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\HinhAnhSanPham;
use App\Models\DanhMuc;
use App\Models\chitietdanhmuc;
use Illuminate\Support\Facades\Auth;
use App\Models\MauSac;
use App\Models\KichThuoc;
use App\Models\ChiTietDonHang;
use App\Models\ChiTietSanPhamNhap;

use App\Models\SanPhamKhuyenMai;

use App\Models\ChiTietGioHang;

use App\Http\Controllers\Controller;
class SanPhamController extends Controller
{
    private function generateUniqueMaSP()
    {
        do {
            // Tạo số ngẫu nhiên sau tiền tố SP
            $number = rand(1000, 9999); // Bạn có thể thay đổi phạm vi số nếu cần
            $maSP = 'SP' . $number;
        } while (SanPham::where('MaSP', $maSP)->exists());

        return $maSP;
    }
    public function index(Request $request)
    { 
        if (!Auth::guard('admin')->check()) {
        return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    }
        $query = SanPham::query();

        // Search by product name
        if ($request->has('search') && $request->search != '') {
            $query->where('TenSP', 'like', '%' . $request->search . '%');
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('GiaBan', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('GiaBan', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('TenSP', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('TenSP', 'desc');
                    break;
            }
        } 

        // Paginate results
        $products = $query->paginate(10);

        return view('Admin.SanPham.index', compact('products'));
    }
    public function create(){
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $danhMucs = chitietdanhmuc::all();
        return view('Admin.SanPham.create', compact('danhMucs'));
    }

    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
    
        // Validate the request data
        $data = $request->validate([
            'TenSP' => 'required|string|max:255|unique:sanpham,TenSP',
            'MaCTDM' => 'required|string|max:255',
            'MoTa' => 'required|string',
            'TrangThai' => 'required|boolean',
            'GiaBan' => 'nullable|numeric|min:0',
            'img.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'TenSP.required' => 'Tên sản phẩm không được để trống.',
            'TenSP.unique' => 'Tên sản phẩm đã tồn tại, vui lòng chọn tên khác.',
            'MaCTDM.required' => 'Mã danh mục không được để trống.',
            'MoTa.required' => 'Mô tả không được để trống.',
            'TrangThai.required' => 'Trạng thái không được để trống.',
            //'GiaBan.required' => 'Giá bán không được để trống.',
            'GiaBan.numeric' => 'Giá bán phải là một số.',
            'GiaBan.min' => 'Giá bán phải lớn hơn hoặc bằng 0.',
        ]);
    
        // Generate a unique MaSP
        $data['MaSP'] = $this->generateUniqueMaSP();
    
        // Clean up MoTa
        $moTa = strip_tags($request->input('MoTa'));
        $data['GiaBan'] = $data['GiaBan'] ?? 0;
        // Create a new product
        $newProduct = SanPham::create([
            'MaSP' => $data['MaSP'],
            'TenSP' => $data['TenSP'],
            'MaCTDM' => $data['MaCTDM'],
            'TrangThai' => $data['TrangThai'],
            'MoTa' => $moTa,
            'GiaBan' => $data['GiaBan'], // Thêm trường giá bán
        ]);
    
        return redirect()->route('product.variants.create', ['product' => $data['MaSP']]);
    }
    
    public function destroy($MaSP)
{
    if (!Auth::guard('admin')->check()) {
        return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    }
    
    // Tìm sản phẩm theo MaSP
    $product = SanPham::where('MaSP', $MaSP)->firstOrFail();
    
    // Lấy danh sách MaCTSP của sản phẩm này
    $chiTietSanPhamIds = ChiTietSanPham::where('MaSP', $MaSP)->pluck('MaCTSP');

    // Kiểm tra xem có chi tiết sản phẩm nào trong ChiTietDonHang không
    $hasOrderDetails = ChiTietDonHang::whereIn('MaCTSP', $chiTietSanPhamIds)->exists();

    // Kiểm tra xem có chi tiết sản phẩm nào trong ChiTietDonNhapHang không
    $hasPurchaseDetails = ChiTietSanPhamNhap::whereIn('MaCTSP', $chiTietSanPhamIds)->exists();

    // Kiểm tra xem có sản phẩm nào trong SanPhamKhuyenMai không
    $hasPromotionDetails = SanPhamKhuyenMai::where('MaSP', $MaSP)->exists();

    // Kiểm tra xem có chi tiết sản phẩm nào trong Giỏ hàng không
    $hasCartDetails = ChiTietGioHang::whereIn('MaCTSP', $chiTietSanPhamIds)->exists();

    // Nếu có chi tiết đơn hàng, chi tiết nhập hàng, sản phẩm khuyến mãi, hoặc giỏ hàng liên quan, không cho phép xóa
    if ($hasOrderDetails || $hasPurchaseDetails || $hasPromotionDetails || $hasCartDetails) {
        return redirect()->route('product.index')->with('error', 'Không thể xóa sản phẩm này vì có liên quan đến đơn hàng, nhập hàng, khuyến mãi hoặc giỏ hàng.');
    }
    
    // Xóa các chi tiết sản phẩm
    ChiTietSanPham::where('MaSP', $MaSP)->delete();
    
    // Xóa sản phẩm
    $product->delete();

    return redirect()->route('product.index')->with('success', 'Sản phẩm đã được xóa.');
}


    public function edit($MaSP)
    {
        $product = SanPham::where('MaSP', $MaSP)->firstOrFail();
        $danhMucs = chitietdanhmuc::all();
     //   $images = HinhAnhSanPham::where('MaSP', $MaSP)->get();

        return view('Admin.SanPham.edit', compact('product', 'danhMucs'));
    }

    public function update(Request $request, $MaSP)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
    
        // Xác thực dữ liệu yêu cầu
        $data = $request->validate([
            'TenSP' => 'required|string|max:255',
            'MaCTDM' => 'required|string|max:255',
            'MoTa' => 'nullable|string',
            'TrangThai' => 'required|boolean',
            'GiaBan' => 'required|numeric|min:0', // Thêm xác thực cho giá bán
        ], [
            'TenSP.required' => 'Tên sản phẩm không được để trống.',
            'MaCTDM.required' => 'Mã danh mục không được để trống.',
            'TrangThai.required' => 'Trạng thái không được để trống.',
            'GiaBan.required' => 'Giá bán không được để trống.',
            'GiaBan.numeric' => 'Giá bán phải là một số.',
            'GiaBan.min' => 'Giá bán phải lớn hơn hoặc bằng 0.',
        ]);
    
        // Tìm sản phẩm theo MaSP
        $product = SanPham::where('MaSP', $MaSP)->firstOrFail();
    
        // Xử lý mô tả
        $moTa = strip_tags($request->input('MoTa'));
    
        // Cập nhật thông tin sản phẩm
        $product->update([
            'TenSP' => $data['TenSP'],
            'MaCTDM' => $data['MaCTDM'],
            'TrangThai' => $data['TrangThai'],
            'MoTa' => $moTa,
            'GiaBan' => $data['GiaBan'], // Cập nhật giá bán
        ]);
    
        return redirect()->route('product.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }
    
    
}
    



