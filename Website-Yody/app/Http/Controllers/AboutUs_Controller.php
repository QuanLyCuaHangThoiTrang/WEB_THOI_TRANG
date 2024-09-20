<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutUs_Controller extends Controller
{
    public function about()
    {
        return view('about.about-us');
    }
}

