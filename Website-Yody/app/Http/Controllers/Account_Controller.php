<?php

// Account_Controller.php
namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Account_Controller extends Controller
{
    public function showAccountForm($MaKH)
    {
        $khachhang = KhachHang::where('MaKH', $MaKH)->firstOrFail();
        return view('account.account', compact('khachhang'));
    }
    
}
