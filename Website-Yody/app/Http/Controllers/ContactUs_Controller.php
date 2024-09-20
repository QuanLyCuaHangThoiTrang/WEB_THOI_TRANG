<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactUs_Controller extends Controller
{
    public function contact()
    {
        return view('contact.contact-us');
    }
}

