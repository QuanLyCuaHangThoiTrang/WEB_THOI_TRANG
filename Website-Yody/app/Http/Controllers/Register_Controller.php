<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class Register_Controller extends Controller
{
    public function showRegistrationForm()
    {
        return view('register.register');
    }

    public function register(Request $request)
    {

        // Validate the form data
        $request->validate([
            'full_name' => [
                'required', 
                'string', 
                'regex:/^[a-zA-Z\s]+$/', // Chỉ chứa chữ cái và khoảng trắng
                'max:255', 
                'min:3', // Ít nhất 2 ký tự để tránh nhập ký tự đơn lẻ
                'not_regex:/^\s*([a-zA-Z]\s*){1}$/', // Không cho phép chỉ nhập một ký tự
            ], 
            'username' => [
                'required',
                'string',
                'min:3', // Tên đăng nhập phải có ít nhất 5 ký tự
                'regex:/^[a-zA-Z0-9_]+$/', // Không chứa ký tự đặc biệt, chỉ cho phép chữ cái, số và dấu gạch dưới
                'unique:khachhang,Username',
            ],
            'phone_number' => 'required|string|regex:/^(0[0-9]{9,10})$/', // Kiểm tra số điện thoại 10-11 số
            'email' => 'required|string|email|max:255|unique:khachhang,Email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'full_name.required' => 'Họ tên không được để trống.',
            'full_name.regex' => 'Họ tên chỉ chứa chữ cái và khoảng trắng.',
            'username.required' => 'Tên đăng nhập không được để trống.',
            'username.unique' => 'Tên đăng nhập đã tồn tại.',
            'phone_number.required' => 'Số điện thoại không được để trống.',
            'phone_number.regex' => 'Số điện thoại phải có 10 hoặc 11 số và bắt đầu bằng số 0.',
            'email.required' => 'Email không được để trống.',
            'email.unique' => 'Email đã tồn tại trong hệ thống.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);
        

        // Generate a unique MaKH (Primary Key)
        $latestCustomer = Customer::orderBy('MaKH', 'desc')->first();
        $MaKH = 'KH' . str_pad(optional($latestCustomer)->id + 1, 4, '0', STR_PAD_LEFT); // VD: KH0001, KH0002

        // Create a new customer record
        Customer::create([
            'MaKH' => $MaKH,
            'HoTen' => $request->full_name,
            'Email' => $request->email,
            'SDT' => $request->phone_number,
            'LoaiKH' => 'Thành viên', // Default value
            'Username' => $request->username,
            'Password' => Hash::make($request->password),
        ]);

        // Redirect to a desired page, such as the login page or customer dashboard
        return redirect()->route('login')->with('success', 'Registration successful.');
    }
}

