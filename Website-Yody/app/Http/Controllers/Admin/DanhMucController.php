<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DanhMuc;
use App\Models\ChiTietDanhMuc;
use App\Models\SanPham;
use Illuminate\Support\Facades\Auth;
class DanhMucController extends Controller
{
    private function generateUniqueMaDanhMuc()
    {        
        do {
            // Tạo số ngẫu nhiên sau tiền tố SP
            $number = rand(1000, 9999); // Bạn có thể thay đổi phạm vi số nếu cần
            $maDM = 'DM' . $number;
        } while (DanhMuc::where('MaDanhMuc', $maDM)->exists());

        return $maDM;
    }
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $danhmucs = DanhMuc::all();
        return view('Admin.DanhMuc.index', compact('danhmucs'));
    }

    public function create()
    {
        return view('Admin.DanhMuc.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'TenDanhMuc' => 'required',
        ], [
            'TenDanhMuc.required' => 'Tên danh mục không được để trống.',
        ]);
        $data['MaDanhMuc'] = $this->generateUniqueMaDanhMuc();
        DanhMuc::create([
            'MaDanhMuc' => $data['MaDanhMuc'],
            'TenDanhMuc' => $data['TenDanhMuc'],
        ]);

        return redirect()->route('danhmuc.index')
                         ->with('success', 'Danh mục đã được tạo thành công.');
    }

    public function show($id)
    {
        $danhmuc = DanhMuc::find($id);
        return view('Admin.DanhMuc.show', compact('danhmuc'));
    }

    public function edit($id)
    {
        $danhmuc = DanhMuc::find($id);
        return view('Admin.DanhMuc.edit', compact('danhmuc'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'TenDanhMuc' => 'required',
        ], [
            'TenDanhMuc.required' => 'Tên danh mục không được để trống.',
        ]);
        $danhmuc = DanhMuc::find($id);
        $danhmuc->update($request->all());

        return redirect()->route('danhmuc.index')
                         ->with('success', 'Danh mục đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        // Tìm danh mục theo ID
        $danhMuc = DanhMuc::findOrFail($id);

        // Lấy danh sách MaCTDM từ bảng ChiTietDanhMuc theo MaDanhMuc
        $maCTDMList = ChiTietDanhMuc::where('MaDanhMuc', $id)->pluck('MaCTDM');

        // Kiểm tra xem có sản phẩm nào có MaCTDM thuộc danh sách trên không
        $sanPhamCount = SanPham::whereIn('MaCTDM', $maCTDMList)->count();

        if ($sanPhamCount > 0) {
            // Nếu có sản phẩm, không cho phép xóa và chuyển hướng với thông báo lỗi
            return redirect()->route('danhmuc.index')
                ->with('error', 'Không thể xóa danh mục này vì có sản phẩm liên quan.');
        }

        // Nếu không có sản phẩm, xóa các chi tiết danh mục liên quan
        ChiTietDanhMuc::whereIn('MaCTDM', $maCTDMList)->delete();

        // Xóa danh mục
        $danhMuc->delete();

        // Chuyển hướng với thông báo thành công
        return redirect()->route('danhmuc.index')
            ->with('success', 'Danh mục và các chi tiết liên quan đã được xóa thành công.');
    }

    public function getChiTiet($id)
    {
        $chitiets = ChiTietDanhMuc::where('MaDanhMuc', $id)->get();
        return response()->json($chitiets);
    }
    
    public function saveChiTiet(Request $request)
    {
        $danhmucId = $request->MaDanhMuc;
        $chiTietData = $request->chiTietData;

        try {
            foreach ($chiTietData as $chiTiet) {
                // Check if it's a new record or an update
                if (isset($chiTiet['MaCTDM'])) {
                    // Update existing record
                    ChiTietDanhMuc::updateOrCreate(
                        ['MaCTDM' => $chiTiet['MaCTDM']], // Update by MaCTDM
                        ['TenCTDM' => $chiTiet['TenCTDM'], 'MaDanhMuc' => $danhmucId]
                    );
                } else {
                    // Create new record
                    ChiTietDanhMuc::create([
                        'MaDanhMuc' => $danhmucId,
                        'TenCTDM' => $chiTiet['TenCTDM'],
                        'MaCTDM' => $this->generateRandomMaCTDM(), // Generate random MaCTDM
                    ]);
                }
            }
            return response()->json(['success' => 'Lưu thành công!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra!'], 500);
        }
    }

    public function deleteChiTiet($id)
    {
        try {
            // Kiểm tra nếu có sản phẩm liên kết với chi tiết danh mục
            $countSanPham = SanPham::where('MaCTDM', $id)->count(); // Assuming 'MaCTDM' is the foreign key in 'SanPham'

            if ($countSanPham > 0) {
                return response()->json(['error' => 'Không thể xóa chi tiết danh mục này vì có sản phẩm liên kết!'], 400);
            }

            // Xóa chi tiết danh mục nếu không có sản phẩm liên kết
            ChiTietDanhMuc::where('MaCTDM', $id)->delete();
            return response()->json(['success' => 'Xóa thành công!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra khi xóa!'], 500);
        }
    }

    private function generateRandomMaCTDM()
    {

        return 'CTDM' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

    
    }

    

        }
