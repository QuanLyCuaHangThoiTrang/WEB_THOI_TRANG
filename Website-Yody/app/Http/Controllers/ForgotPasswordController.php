<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // Hiển thị form nhập email để reset mật khẩu
    public function showForgotPasswordForm()
    {
        return view('login.forgot-password');
    }

}
