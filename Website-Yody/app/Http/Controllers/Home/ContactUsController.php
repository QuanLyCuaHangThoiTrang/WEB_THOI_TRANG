<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function contact()
    {
        return view('contact.contact-us');
    }
}