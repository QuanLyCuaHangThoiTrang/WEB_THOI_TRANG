<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Cart_Controller extends Controller
{
    public function cart()
    {
        return view('cart.cart');
    }
}

