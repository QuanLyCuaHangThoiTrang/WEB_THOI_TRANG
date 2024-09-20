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
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:khachhang,Username',
            'phone_number' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:khachhang,Email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Generate a unique MaKH (Primary Key)
        $MaKH = 'KH' . Str::random(4); // Adjust this as needed

        // Create a new customer record
        Customer::create([
            'MaKH' => $MaKH,
            'HoTen' => $request->full_name,
            'Email' => $request->email,
            'SDT' => $request->phone_number,
            'LoaiKH' => 'Thành viên', // Set a default value or get it from the form
            'Username' => $request->username,
            'Password' => Hash::make($request->password),
        ]);

        // Redirect to a desired page, such as the login page or customer dashboard
        return redirect()->route('login')->with('success', 'Registration successful.');
    }
}

