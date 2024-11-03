<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChiTietSanPham;
use App\Models\SanPham;
use App\Models\MauSac;
use Illuminate\Support\Facades\Auth;
use App\Models\KichThuoc;
use App\Models\ChiTietDonHang;
class ChiTietSanPhamController extends Controller
{
    public function show($MaSP)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $product = SanPham::where('MaSP', $MaSP)->first();
        $productDetails = ChiTietSanPham::where('MaSP', $MaSP)->get();
        return view('Admin.SanPham.details', compact('product', 'productDetails'));
    }
    public function create($product)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        if (empty($product)) {
            return redirect()->back()->withErrors('Product ID is missing.');
        }
        
        $product1 = SanPham::where('MaSP', $product)->firstOrFail();

        // Lấy danh sách màu sắc và kích thước từ cơ sở dữ liệu
        $colors = MauSac::all(); // Thay đổi `Color` thành tên model của bạn chứa màu sắc
        $sizes = KichThuoc::all();   // Thay đổi `Size` thành tên model của bạn chứa kích thước

        return view('Admin.SanPham.create_detail', [
            'product' => $product1,
            'colors' => $colors,
            'sizes' => $sizes
        ]);
    }


    public function store(Request $request, $productId)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $request->validate([
            'variants.*.stockQuantity' => 'required|integer|min:1', // Số lượng phải là số nguyên và lớn hơn 0
            'variants.*.sku' => 'nullable|string',
            'variants.*.img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Kiểm tra file ảnh
        ], [

            // Thông báo lỗi cho stockQuantity
            'variants.*.stockQuantity.required' => 'Số lượng tồn kho là bắt buộc.',
            'variants.*.stockQuantity.integer' => 'Số lượng tồn kho phải là một số nguyên.',
            'variants.*.stockQuantity.min' => 'Số lượng tồn kho phải lớn hơn 0.',
        
            // Thông báo lỗi cho SKU (tùy chọn, không bắt buộc)
            'variants.*.sku.string' => 'Mã SKU phải là chuỗi ký tự hợp lệ.',
        
            // Thông báo lỗi cho img
            'variants.*.img.image' => 'Tệp tải lên phải là một ảnh.',
            'variants.*.img.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, svg, hoặc webp.',
            'variants.*.img.max' => 'Dung lượng ảnh tối đa là 2MB.',
        ]);
        
        $product = SanPham::where('MaSP', $productId)->firstOrFail();

        // Lấy các biến thể từ yêu cầu
        $variants = $request->input('variants');
        $errors = [];  // Mảng lưu trữ lỗi
        $checkedVariants = [];  // Mảng lưu trữ các tổ hợp đã kiểm tra để phát hiện trùng lặp trong yêu cầu

        foreach ($variants as $index => $variant) {
            $size = $variant['size'] ?? null;
            $color = $variant['color'] ?? null;
            $stockQuantity = $variant['stockQuantity'] ?? null;
            $sku = $variant['sku'] ?? null;

            // Kiểm tra xem các giá trị cần thiết có tồn tại không
            if ($size === null || $color === null || $stockQuantity === null) {
                $errors[] = "Chi tiết sản phẩm thứ " . ($index + 1) . " thiếu thông tin cần thiết.";
                continue;
            }

            // Kiểm tra xem biến thể này có trùng lặp trong yêu cầu không
            $variantKey = $product->MaSP . '-' . $color . '-' . $size;
            if (in_array($variantKey, $checkedVariants)) {
                $errors[] = "Chi tiết sản phẩm thứ " . ($index + 1) . " bị trùng lặp với một biến thể khác trong yêu cầu.";
                continue;
            }
            $checkedVariants[] = $variantKey;

            // Kiểm tra xem biến thể này đã tồn tại trong cơ sở dữ liệu chưa
            $existingVariant = ChiTietSanPham::where('MaSP', $product->MaSP)
                ->where('MaMau', $color)
                ->where('MaSize', $size)
                ->first();

            if ($existingVariant) {
                // Nếu biến thể đã tồn tại trong cơ sở dữ liệu, thêm thông báo lỗi
                $errors[] = "Chi tiết sản phẩm thứ ". ($index + 1) ." với màu sắc và kích thước này đã tồn tại trong hệ thống.";
                continue;
            }
        }

        // Kiểm tra nếu có lỗi, chuyển hướng trở lại với thông báo lỗi
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        // Nếu không có lỗi, tiến hành lưu tất cả các biến thể
        foreach ($variants as $index => $variant) {
            $size = $variant['size'];
            $color = $variant['color'];
            $stockQuantity = $variant['stockQuantity'];
            $sku = $variant['sku'];

            // Tạo mã chi tiết sản phẩm duy nhất
            do {
                $maCTSP = 'CT' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
            } while (ChiTietSanPham::where('MaCTSP', $maCTSP)->exists());

            // Xử lý ảnh và lưu trữ
            $filename = 'default_img.jpg'; // Khởi tạo giá trị filename là null
            if ($request->hasFile("variants.{$index}.img")) {
                $file = $request->file("variants.{$index}.img");
                $filename = $file->getClientOriginalName();
                if (!file_exists(public_path('images/products/' . $filename))) {
                    // Nếu file chưa tồn tại, di chuyển file vào thư mục
                    $file->move(public_path('images/products'), $filename);

                }
            }

            // Tạo biến thể sản phẩm
            try {
                ChiTietSanPham::create([
                    'MaCTSP' => $maCTSP,
                    'MaSP' => $product->MaSP,
                    'MaSize' => $size,
                    'MaMau' => $color,
                    'HinhAnh' => $filename, // Lưu tên file ảnh vào trường HinhAnh
                    'SoLuongTonKho' => $stockQuantity,
                    'SKU' => $sku,
                ]);
            } catch (\Exception $e) {
                // Nếu có lỗi xảy ra trong quá trình lưu, thêm thông báo lỗi
                return redirect()->back()->withErrors('Có lỗi xảy ra khi lưu chi tiết sản phẩm: ' . $e->getMessage());
            }
    }

    // Nếu lưu thành công tất cả, chuyển hướng với thông báo thành công
    return redirect()->route('product.details', $productId)->with('success', 'Sản phẩm và các biến thể đã được lưu thành công!');
}


    public function edit($MaCTSP)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $detail = ChiTietSanPham::where('MaCTSP', $MaCTSP)->first();
        if (!$detail) {
            return redirect()->back()->with('error', 'Chi tiết sản phẩm không tìm thấy.');
        }
        $product = SanPham::where('MaSP', $detail->MaSP)->first(); // Get the related product
        return view('Admin.SanPham.edit_detail', compact('detail', 'product'));
    }

    // Cập nhật chi tiết sản phẩm
    public function update(Request $request, $MaCTSP)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $request->validate([
            'SoLuongTonKho' => 'required|integer|min:0',
            'SKU' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Validate image file
        ],
        [
            'SoLuongTonKho.required' => 'Số lượng tồn kho là bắt buộc.',
            'SoLuongTonKho.integer' => 'Số lượng tồn kho phải là một số nguyên.',
            'SoLuongTonKho.min' => 'Số lượng tồn kho không được nhỏ hơn 0.', // Thông báo lỗi nếu số âm
            'img.image' => 'Tệp tải lên phải là một ảnh.',
            'img.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, svg, hoặc webp.',
            'img.max' => 'Dung lượng ảnh tối đa là 2MB.',
        ]);
   
        $detail = ChiTietSanPham::where('MaCTSP', $MaCTSP)->first();

        if (!$detail) {
            return redirect()->back()->with('error', 'Chi tiết sản phẩm không tìm thấy.');
        }

        // Handle image upload if a new image is provided
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = $image->getClientOriginalName(); // Lấy tên gốc của ảnh
            
            // Kiểm tra xem file đã tồn tại trong thư mục 'images' chưa
            if (!file_exists(public_path('images/products/' . $imageName))) {
                // Nếu chưa tồn tại, di chuyển file vào thư mục 'images'
                $image->move(public_path('images/products'), $imageName);

                // Xóa ảnh cũ (nếu có) khi có ảnh mới được tải lên
                // if ($detail->HinhAnh && file_exists(public_path('images/' . $detail->HinhAnh))) {
                //     unlink(public_path('images/' . $detail->HinhAnh));
                // }
            }
    
            // Cập nhật tên ảnh mới vào cơ sở dữ liệu
            $detail->HinhAnh = $imageName;
        }

        // Update other fields
        $detail->update([
            'SoLuongTonKho' => $request->input('SoLuongTonKho'),
            'SKU' => $request->input('SKU'),
            'HinhAnh' => $detail->HinhAnh, // Update with new image name if it was uploaded
        ]);

        return redirect()->route('product.details', ['MaSP' => $detail->MaSP])->with('success', 'Chi tiết sản phẩm đã được cập nhật.');
    }

    public function destroy($MaCTSP)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $detail = ChiTietSanPham::where('MaCTSP', $MaCTSP)->first();
        $hasOrderDetails = ChiTietDonHang::where('MaCTSP', $MaCTSP)->exists();
    
        if ($hasOrderDetails) {
            // Nếu có chi tiết đơn hàng liên quan, không cho phép xóa
            return redirect()->route('product.details',['MaSP' => $detail->MaSP])->with('error', 'Không thể xóa chi tiết sản phẩm này vì có chi tiết đơn hàng liên quan.');
        }
        if (!$detail) {
            return redirect()->back()->with('error', 'Chi tiết sản phẩm không tìm thấy.');
        }

        $detail->delete();

        return redirect()->back()->with('success', 'Chi tiết sản phẩm đã được xóa.');
    }
}
