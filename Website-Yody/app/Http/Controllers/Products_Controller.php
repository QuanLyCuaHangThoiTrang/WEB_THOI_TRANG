<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Products_Controller extends Controller
{
    public function products()
    {
        return view('products.products');
    }
}

