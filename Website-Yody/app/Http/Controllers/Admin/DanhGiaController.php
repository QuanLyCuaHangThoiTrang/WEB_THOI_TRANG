<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DanhGia;
use App\Models\ChiTietDanhMuc;
use App\Models\SanPham;
use Illuminate\Support\Facades\Auth;
class DanhGiaController extends Controller
{
    public function index(Request $request)
    {
        $maCTSP = $request->input('MaCTSP');
        $danhGiaQuery = DanhGia::query();
        if ($maCTSP) {
            $danhGiaQuery->where('MaCTSP', $maCTSP);
        }

        $danhGia = $danhGiaQuery->with('khachHang')->get();
        $soSaoTrungBinh = $maCTSP
            ? DanhGia::where('MaCTSP', $maCTSP)->avg('DiemDanhGia')
            : null;

        return view('Admin.DanhGia.index', compact('danhGia', 'soSaoTrungBinh', 'maCTSP'));
    }
    public function destroy($id)
{
    try {
        $danhGia = DanhGia::findOrFail($id);
        $danhGia->delete();

        return redirect()->route('danhgia.index')->with('success', 'Đánh giá đã được xóa.');
    } catch (\Exception $e) {
        return redirect()->route('danhgia.index')->with('error', 'Xóa đánh giá thất bại.');
    }
}
}
