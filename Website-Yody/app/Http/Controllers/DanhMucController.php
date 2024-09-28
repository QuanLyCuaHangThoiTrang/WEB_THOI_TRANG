<?php

namespace App\Http\Controllers;
use App\Models\DanhMuc;
use Illuminate\Http\Request;

class DanhMucController extends Controller
{
    public function LoadDM()
    {
        $danhmucs = DanhMuc::all();
        return view('danhmuc.index', compact('danhmucs'));
    }
}
