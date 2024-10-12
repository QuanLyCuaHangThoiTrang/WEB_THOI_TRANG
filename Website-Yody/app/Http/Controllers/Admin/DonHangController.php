<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonHang;
use App\Models\SanPham;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;
class DonHangController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $donhangs = DonHang::all();
        return view('Admin.DonHang.index', compact('donhangs'));
    }

    public function show($MaDH)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $donhang = DonHang::with('chiTietDonHang')->findOrFail($MaDH);
        return view('Admin.DonHang.show', compact('donhang'));
    }
    public function print($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $donhang = DonHang::with('chiTietDonHang')->findOrFail($id);

        // Pass the order data to the PDF view
        $pdf = PDF::loadView('Admin.DonHang.print', compact('donhang'));

        // Return the generated PDF to the browser
        return $pdf->stream('order_' . $donhang->MaDH . '.pdf');
    }
    public function updateStatus(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $donhang = DonHang::find($request->id);
        if ($donhang) {
            $donhang->TrangThai = $request->status;
            $donhang->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function showDashboard()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        return view('Admin.DonHang.thongke');
    }
    public function filterByDate(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $from_date = $request->from_date;
        $to_date = $request->to_date;
    
        // Khởi tạo mảng chart_data
        $chart_data = [];
    
        // Truy vấn dữ liệu từ bảng DonHang
        $get = DonHang::whereBetween('NgayDatHang', [$from_date, $to_date])
        ->selectRaw('DATE(NgayDatHang) as date, SUM(TongGiaTri) as total_sales')
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        $chart_data = [];
        foreach ($get as $val) {
            $chart_data[] = array(
                'period' => $val->date, // Hiển thị theo ngày
                'order' => $val->total_sales, // Tổng giá trị đơn hàng trong ngày
            );
        }
        // Nếu không có dữ liệu, trả về mảng rỗng
        if (empty($chart_data)) {
            return response()->json([], 200);
        }
    
        // Trả về dữ liệu JSON
        return response()->json($chart_data, 200);
    }
    


    
}