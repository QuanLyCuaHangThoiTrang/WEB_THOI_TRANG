<?php
namespace App\Http\Controllers\Registration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
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
                'max:255', 
                'min:3',
                'not_regex:/^\s*([a-zA-Z]\s*){1}$/',
            ], 
            'username' => [
                'required',
                'string',
                'min:3',
                'regex:/^[a-zA-Z0-9_]+$/',
                'unique:khachhang,Username',
            ],
            'phone_number' => 'required|string|regex:/^(0[0-9]{9,10})$/',
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
    
        // Generate a unique MaKH
        do {
            $randomString = Str::random(6);
            $MaKH = 'KH' . $randomString;
        } while (Customer::where('MaKH', $MaKH)->exists());
    
        // Create a new customer
        Customer::create([
            'MaKH' => $MaKH,
            'HoTen' => $request->full_name,
            'Email' => $request->email,
            'SDT' => $request->phone_number,
            'LoaiKH' => 'Thành viên',
            'Username' => $request->username,
            'Password' => Hash::make($request->password),
        ]);
    
        // Get the current locale and redirect to the login page with the locale parameter
        $locale = app()->getLocale();
        return redirect()->route('login', ['locale' => $locale])->with('success', 'Registration successful.');
    }
    
}