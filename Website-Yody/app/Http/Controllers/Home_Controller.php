<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Home_Controller extends Controller
{
    public function home()
    {
        return view('home.home');
    }
}
