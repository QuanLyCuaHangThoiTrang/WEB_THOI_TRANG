<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KhuyenMai;
use App\Models\SanPham;
use App\Models\SanPhamKhuyenMai;
use Illuminate\Support\Facades\Auth;
class KhuyenMaiController extends Controller
{

    private function generateUniqueMaKM()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        do {
            // Tạo số ngẫu nhiên sau tiền tố SP
            $number = rand(1000, 9999); // Bạn có thể thay đổi phạm vi số nếu cần
            $MaKM = 'KM' . $number;
        } while (KhuyenMai::where('MaKM', $MaKM)->exists());

        return $MaKM;
    }
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $khuyenMais = KhuyenMai::all();
        $sanphams = SanPham::all();
        return view('Admin.KhuyenMai.index', compact('khuyenMais','sanphams'));
    }

    public function create()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        return view('Admin.KhuyenMai.create');
    }

    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $data = $request->validate([
            'TenKM' => 'required|string|max:255',
            'MoTa' => 'nullable|string',
            'PhanTramGiamGia' => 'required|numeric|min:0|max:100', // Bắt buộc nhập phần trăm giảm giá
            'NgayBatDau' => 'required|date', // Bắt buộc nhập ngày bắt đầu
            'NgayKetThuc' => 'required|date|after:NgayBatDau', // Bắt buộc nhập và phải sau ngày bắt đầu
        ], [
            'TenKM.required' => 'Tên khuyến mãi là bắt buộc.',
            'PhanTramGiamGia.min' => 'Phần trăm giảm giá phải từ 0 đến 100.',
            'PhanTramGiamGia.max' => 'Phần trăm giảm giá không được vượt quá 100.',
            'PhanTramGiamGia.required' => 'Phần trăm giảm giá là bắt buộc.',
            'NgayBatDau.required' => 'Ngày bắt đầu là bắt buộc.',
            'NgayKetThuc.required' => 'Ngày kết thúc là bắt buộc.',
            'NgayKetThuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]); 
        $data['MaKM'] = $this->generateUniqueMaKM();
        KhuyenMai::create([
            'MaKM' => $data['MaKM'],
            'TenKM' => $data['TenKM'],
            'MoTa' => $data['MoTa'],
            'PhanTramGiamGia' => $data['PhanTramGiamGia'],
            'NgayBatDau' => $data['NgayBatDau'],
            'NgayKetThuc' => $data['NgayKetThuc'],
        ]);
        return redirect()->route('khuyenmai.index')->with('success', 'Khuyến mãi đã được tạo thành công!');
    }

    public function edit($MaKM)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $khuyenMai = KhuyenMai::findOrFail($MaKM);
        return view('Admin.KhuyenMai.edit', compact('khuyenMai'));
    }

    public function update(Request $request, $MaKM)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $data = $request->validate([
            'TenKM' => 'required|string|max:255',
            'MoTa' => 'nullable|string',
            'PhanTramGiamGia' => 'required|numeric|min:0|max:100', // Bắt buộc nhập phần trăm giảm giá
            'NgayBatDau' => 'required|date', // Bắt buộc nhập ngày bắt đầu
            'NgayKetThuc' => 'required|date|after:NgayBatDau', // Bắt buộc nhập và phải sau ngày bắt đầu
        ], [
            'TenKM.required' => 'Tên khuyến mãi là bắt buộc.',
            'PhanTramGiamGia.min' => 'Phần trăm giảm giá phải từ 0 đến 100.',
            'PhanTramGiamGia.max' => 'Phần trăm giảm giá không được vượt quá 100.',
            'PhanTramGiamGia.required' => 'Phần trăm giảm giá là bắt buộc.',
            'NgayBatDau.required' => 'Ngày bắt đầu là bắt buộc.',
            'NgayKetThuc.required' => 'Ngày kết thúc là bắt buộc.',
            'NgayKetThuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]); 

        $khuyenMai = KhuyenMai::findOrFail($MaKM);
        $khuyenMai->update($request->all());
        return redirect()->route('khuyenmai.index')->with('success', 'Khuyến mãi đã được cập nhật thành công!');
    }

    public function destroy($MaKM)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $khuyenMai = KhuyenMai::findOrFail($MaKM);
        SanPhamKhuyenMai::where('MaKM', $MaKM)->delete();
        $khuyenMai->delete();
        return redirect()->route('khuyenmai.index')->with('success', 'Khuyến mãi đã được xóa thành công!');
    }
    public function show($MaKM)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }   
        $khuyenMai = KhuyenMai::with('sanPhamKhuyenMais.sanPham')->findOrFail($MaKM);
        $products = SanPham::all();
    
        // Lấy danh sách các sản phẩm đã thuộc khuyến mãi
        $sanPhamKhuyenMaiIds = $khuyenMai->sanPhamKhuyenMais->pluck('MaSP')->toArray();
    
        return view('Admin.khuyenmai.show', compact('khuyenMai', 'products', 'sanPhamKhuyenMaiIds'));
    }

    //SanPhamKhuyenMai
    public function create_SPKM($maKM)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        // Lấy thông tin đơn nhập hàng và danh sách sản phẩm
        $khuyenMai = KhuyenMai::findOrFail($maKM);
        $chiTietSanPhams = SanPham::all(); // Lấy tất cả sản phẩm hoặc tùy chỉnh theo nhu cầu

        // Trả về view với dữ liệu cần thiết
        return view('Admin.SanPhamKhuyenMai.create', compact('khuyenMai', 'chiTietSanPhams'));
    }
    public function store_SPKM(Request $request,$khuyenMaiId)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $selectedProductIds = $request->input('products', []);

        // Lưu lại các sản phẩm đã được chọn
        foreach ($selectedProductIds as $productId) {
            // Kiểm tra xem sản phẩm đã có trong khuyến mãi chưa
            if (!SanPhamKhuyenMai::where('MaKM', $khuyenMaiId)->where('MaSP', $productId)->exists()) {
                SanPhamKhuyenMai::create([
                    'MaKM' => $khuyenMaiId,
                    'MaSP' => $productId,
                ]);
            }
        }

        // Xóa các sản phẩm đã có mà không được chọn nữa
        SanPhamKhuyenMai::where('MaKM', $khuyenMaiId)
            ->whereNotIn('MaSP', $selectedProductIds)
            ->delete();

        return redirect()->route('khuyenmai.show', $khuyenMaiId)->with('success', 'Cập nhật sản phẩm khuyến mãi thành công!');
    }

 
        public function destroy_SPKM($maKM, $maSP)
        {
            if (!Auth::guard('admin')->check()) {
                return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
            }
            $chiTiet = SanPhamKhuyenMai::where('MaKM', $maKM)
                ->where('MaSP', $maSP)
                ->firstOrFail();
            
            $chiTiet->delete();

            return redirect()->route('khuyenmai.show', $maKM)->with('success', 'Sản phẩm đã được xóa!');
        }
}
