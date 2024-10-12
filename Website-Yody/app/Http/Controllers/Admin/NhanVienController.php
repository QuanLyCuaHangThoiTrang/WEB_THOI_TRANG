<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NhanVien;
use Illuminate\Support\Facades\Auth;
class NhanVienController extends Controller
{
    private function generateUniqueMaNV()
    {       
        do {
            // Tạo số ngẫu nhiên sau tiền tố SP
            $number = rand(1000, 9999); // Bạn có thể thay đổi phạm vi số nếu cần
            $maNV = 'NV' . $number;
        } while (NhanVien::where('MaNV', $maNV)->exists());

        return $maNV;
    }
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $nhanViens = NhanVien::all();
        return view('Admin.NhanVien.index', compact('nhanViens'));
    }

    // Hiển thị form thêm nhân viên
    public function create()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        return view('Admin.NhanVien.create');
    }

    // Lưu nhân viên mới
    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $validatedData = $request->validate([
            'HoTen' => 'required|string|max:255',
            'Email' => 'required|nullable|email|max:255',
            'SDT' => ['required', 'regex:/^(03|05|07|08|09)[0-9]{8}$/'], // Đầu số hợp lệ và có 10 chữ số
            'Username' => 'required|nullable|string|max:200',
            'Password' => ['required', 'string', 'min:6', 'regex:/[A-Z]/', 'regex:/[@$!%*#?&]/'], // Ít nhất 6 ký tự, có chữ hoa và ký tự đặc biệt
            'VaiTro' => 'required|nullable|string|max:50',
        ], [
            'HoTen.required' => 'Họ tên là bắt buộc.',
            'Email.required' => 'Email là bắt buộc.',
            'Username.required' => 'Username là bắt buộc.',
            'VaiTro.required' => 'Vai trò là bắt buộc.',
            'Password.required' => 'Mật khẩu là bắt buộc.',
            'Password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'Password.regex' => 'Mật khẩu phải có ít nhất một ký tự hoa và một ký tự đặc biệt (@$!%*#?&).',
            'Email.email' => 'Email không hợp lệ.',
            'SDT.required' => 'Số điện thoại là bắt buộc.',
            'SDT.regex' => 'Số điện thoại phải có 10 số và phải đúng quy định',
            'Username.max' => 'Tên đăng nhập không được vượt quá 200 ký tự.',
        ]);
    
        try {
            // Tạo mã nhân viên ngẫu nhiên
            $maNV = $this->generateUniqueMaNV();
    
            // Tạo nhân viên mới
            NhanVien::create([
                'MaNV' => $maNV,
                'HoTen' => $validatedData['HoTen'],
                'Email' => $validatedData['Email'],
                'SDT' => $validatedData['SDT'],
                'Username' => $validatedData['Username'],
                'Password' => bcrypt($validatedData['Password']), // Mã hóa mật khẩu trước khi lưu
                'VaiTro' => $validatedData['VaiTro'],
            ]);
    
            return redirect()->route('nhanvien.index')->with('success', 'Nhân viên đã được thêm thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra trong quá trình thêm nhân viên: ' . $e->getMessage()]);
        }
    }
    

    // Hiển thị form sửa nhân viên
    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $nhanvien = NhanVien::findOrFail($id);
        return view('Admin.NhanVien.edit', compact('nhanvien'));
    }

    // Cập nhật thông tin nhân viên
    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $validatedData = $request->validate([
            'HoTen' => 'required|string|max:255',
            'Email' => 'required|email|max:255',
            'SDT' => ['required', 'regex:/^(03|05|07|08|09)[0-9]{8}$/'], // Đầu số hợp lệ và có 10 chữ số
            'Username' => 'required|string|max:200',
            'Password' => ['nullable', 'string', 'min:6', 'regex:/[A-Z]/', 'regex:/[@$!%*#?&]/'], // Mật khẩu có thể trống nếu không thay đổi
            'VaiTro' => 'required|string|max:50',
        ], [
            'HoTen.required' => 'Họ tên là bắt buộc.',
            'Email.required' => 'Email là bắt buộc.',
            'Username.required' => 'Username là bắt buộc.',
            'VaiTro.required' => 'Vai trò là bắt buộc.',
            'SDT.required' => 'Số điện thoại là bắt buộc.',
            'Password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'Password.regex' => 'Mật khẩu phải có ít nhất một ký tự hoa và một ký tự đặc biệt (@$!%*#?&).',
            'Email.email' => 'Email không hợp lệ.',
            'SDT.regex' => 'Số điện thoại phải có 10 số và theo đúng quy định của nhà mạng Việt Nam (03, 05, 07, 08, 09).',
            'Username.max' => 'Tên đăng nhập không được vượt quá 200 ký tự.',
        ]);

        $nhanVien = NhanVien::findOrFail($id);

        // Nếu có thay đổi mật khẩu thì mã hóa mật khẩu trước khi lưu
        if (!empty($validatedData['Password'])) {
            $validatedData['Password'] = bcrypt($validatedData['Password']);
        } else {
            // Xóa mật khẩu khỏi dữ liệu nếu không có thay đổi để tránh ghi đè lên mật khẩu cũ
            unset($validatedData['Password']);
        }

        // Cập nhật thông tin nhân viên
        $nhanVien->update($validatedData);

        return redirect()->route('nhanvien.index')->with('success', 'Nhân viên đã được cập nhật thành công.');
    }


    // Xóa nhân viên
    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $nhanVien = NhanVien::findOrFail($id);
        $nhanVien->delete();

        return redirect()->route('nhanvien.index')->with('success', 'Nhân viên đã được xóa thành công.');
    }
}
