<?php

// Account_Controller.php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class CheckOut_Controller extends Controller
{
    public function showCheckOutForm()
    {
        return view('cart.checkout.checkout');
    }
}