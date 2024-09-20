<?php

// Account_Controller.php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Account_Controller extends Controller
{
    public function showAccountForm($MaKH)
    {
        $customer = Customer::where('MaKH', $MaKH)->firstOrFail();
        return view('account.account', compact('customer'));
    }
}
