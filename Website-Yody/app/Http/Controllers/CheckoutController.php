<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GioHang; // Giả sử bạn có model GioHang
use App\Models\ChiTietGioHang; // Model chi tiết giỏ hàng
use App\Models\DonHang; // Model đơn hàng
use App\Models\KhachHang;
use App\Models\ChiTietDonHang; // Model chi tiết đơn hàng
use Illuminate\Support\Facades\Auth;
class CheckoutController extends Controller
{
    public function index()
    {
        $chiTietGioHang = [];
        $tongTien = 0;
        $giamGia = 0; // Ví dụ, bạn có thể tính giảm giá từ thông tin giỏ hàng hoặc session

        // Nếu người dùng đã đăng nhập, lấy giỏ hàng từ database
        if (Auth::check()) {
            $user = Auth::user();
            $gioHang = GioHang::where('MaKH', $user->MaKH)->first();
            if ($gioHang) {
                $chiTietGioHang = $gioHang->chiTietGioHang;
                $tongTien = $gioHang->TongGiaTri;  
            }
        } else {
            // Nếu người dùng chưa đăng nhập, lấy giỏ hàng từ session
            $gioHangSession = session()->get('gioHang', []);
            $chiTietGioHang = $gioHangSession;
            $tongTien = array_sum(array_column($gioHangSession, 'ThanhTien'));
        }

        // Trả về view với chi tiết giỏ hàng và tổng tiền
        return view('checkout.checkout', compact('chiTietGioHang', 'tongTien', 'giamGia'));
    }
    
    /*
    public function processCheckout(Request $request)
    {
       // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
          
            $gioHang = GioHang::where('MaKH', $user->MaKH)->first();
            if ($gioHang && $gioHang->TongGiaTri > 0) {
                // Giỏ hàng có sản phẩm -> tiếp tục xử lý thanh toán
                return redirect()->route('checkout.index')->with('success', 'Đơn hàng của bạn đã được xử lý.');
            } else {
                // Giỏ hàng rỗng -> quay lại giỏ hàng và thông báo
                return redirect()->route('cart.index')->withErrors('Giỏ hàng của bạn trống.');
            }
        } else {
            // Xử lý với giỏ hàng trong session
            $gioHangSession = session()->get('gioHang', []);
            
            if (count($gioHangSession) > 0) {
                // Giỏ hàng session có sản phẩm -> tiếp tục xử lý thanh toán
                return redirect()->route('checkout.index')->with('success', 'Đơn hàng của bạn đã được xử lý.');
            } else {
                // Giỏ hàng rỗng -> quay lại giỏ hàng và thông báo
                return redirect()->route('cart.index')->withErrors('Giỏ hàng của bạn trống.');
            }
        }
        
    }
    */
    
    public function processCheckoutDH(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();          
            $gioHang = GioHang::where('MaKH', $user->MaKH)->first();
            if ($gioHang && $gioHang->TongGiaTri > 0) {
                return $this->storeOrder($request);
            } 
            else 
            {
                return redirect()->route(route: 'cart')->withErrors('Giỏ hàng của bạn trống.');
            }
        } 
        else 
        {
            return $this->storeOrder($request);   
        }
    }
    public function storeOrder(Request $request)
    {
        $diachinha = $request->input('diachinha');
        $xa = $request->input('hidden_phuong');
        $huyen = $request->input('hidden_quan');
        $tinh = $request->input('hidden_tinh');
        $diachi = $diachinha . ', ' . $xa . ', ' . $huyen . ', '. $tinh;
        $email = $request->input('email');
        $sodienthoai = $request->input('phone_number');
        $hoten = $request->input('name');
        // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            return $this->saveOrderWithAuth($request,$diachi);
        } 
        else 
        {
            return $this->saveOrderNoAuth($request,$diachi,$email,$sodienthoai,$hoten);                
        }
    }
    public function saveOrderWithAuth($request, $diachi)
    {
        $user = Auth::user();
        $gioHang = GioHang::where('MaKH', $user->MaKH)->first();

        if ($gioHang && $gioHang->TongGiaTri > 0) {
            $maDH = 'DH' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            if($request->input('payment_method') == 'Thanh toán momo')
            {
                $tongTien = (int) ($gioHang->TongGiaTri * 100);;
                
                return $this->ThanhToanMomo($tongTien);
            }
            else
            {
                // Tạo đơn hàng mới
                $donHang = DonHang::create([
                    'MaDH' => $maDH,
                    'MaKH' => $user->MaKH,
                    'DiaChiGiaoHang' => $diachi,
                    'NgayDatHang' => now(),
                    'TongGiaTri' => $gioHang->TongGiaTri,
                    'TrangThai' => 'Chưa giao', // Ví dụ trạng thái đơn hàng
                    'PhuongThucThanhToan' => $request->input('payment_method')
                ]);
                
                // Lưu chi tiết đơn hàng
                $chiTietGioHang = ChiTietGioHang::where('MaGH', $gioHang->MaGH)->get();
                foreach ($chiTietGioHang as $item) {
                    ChiTietDonHang::create([
                        'MaDH' => $donHang->MaDH,
                        'MaCTSP' => $item->MaCTSP,
                        'SoLuong' => $item->SoLuong,
                        'DonGia' => $item->DonGia,
                        'ThanhTien' => $item->ThanhTien
                    ]);
                }

                // Xóa giỏ hàng sau khi hoàn tất thanh toán
                ChiTietGioHang::where('MaGH', $gioHang->MaGH)->delete();
                $gioHang->TongGiaTri = 0;
                $gioHang->save();

                return redirect()->route('checkout.index')->with('success', 'Đơn hàng của bạn đã được tạo thành công.');
            }
        } else {
            return redirect()->route('cart')->withErrors('Giỏ hàng của bạn trống.');
        }
    }
    public function saveOrderNoAuth($request, $diachi,$email,$sodienthoai,$hoten)
    {
        $gioHangSession = session()->get('gioHang', []);
        if (count($gioHangSession) > 0) 
        {          
            $maKH = 'KHVL' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $maDH = 'DH' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            if($request->input('payment_method') == 'Thanh toán momo')
            {                
                $thanhtien = array_sum(array_column($gioHangSession, 'ThanhTien'));
                return $this->ThanhToanMomo($thanhtien);
            }
            KhachHang::create([
                'MaKH' => $maKH,
                'HoTen' => $hoten,
                'Email' => $email,
                'SDT' => $sodienthoai,
                'LoaiKH' => 'Online',
                'Username' => '', // Ví dụ trạng thái đơn hàng
                'Password' => '',
            ]);               
            // Tạo đơn hàng mới
            $donHang = DonHang::create([
                'MaDH' => $maDH,
                'MaKH' => $maKH,
                'DiaChiGiaoHang' => $diachi,
                'NgayDatHang' => now(),
                'TongGiaTri' => array_sum(array_column($gioHangSession, 'ThanhTien')),
                'TrangThai' => 'Chưa giao', // Ví dụ trạng thái đơn hàng
                'PhuongThucThanhToan' => $request->input('payment_method')
            ]);
            
            // Lưu chi tiết đơn hàng
            foreach ($gioHangSession as $item) {
                ChiTietDonHang::create([
                    'MaDH' => $donHang->MaDH,
                    'MaCTSP' => $item['MaCTSP'],
                    'SoLuong' => $item['SoLuong'],
                    'DonGia' => $item['DonGia'],
                    'ThanhTien' => $item['ThanhTien']
                ]);
            }
            session()->forget('gioHang');
            return redirect()->route('checkout.index')->with('success', 'Đơn hàng của bạn đã được tạo thành công.');   
        } 
        else 
        {
            return redirect()->route('cart')->withErrors('Giỏ hàng của bạn trống.');
        }
    }
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    public function ThanhToanMomo($TongTien)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529'; // Thay bằng mã của bạn khi dùng live
        $accessKey = 'klm05TvNBzhg7h7j'; // Access key
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa'; // Secret key
        $orderInfo = "Thanh toán qua MoMo"; 
        $amount = $TongTien; // Lấy số tiền từ request hoặc từ giỏ hàng
        $orderId = time() .""; // Mã đơn hàng tự sinh
        $redirectUrl = "http://127.0.0.1:8000/checkout"; // URL redirect sau khi thanh toán thành công
        $ipnUrl = "http://127.0.0.1:8000/checkout"; // IPN URL để nhận kết quả thanh toán từ Momo
        $extraData = ""; // Dữ liệu bổ sung nếu có

        $requestId = time() . "";
        $requestType = "payWithATM"; // Có thể chọn phương thức khác nếu cần
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;

        // Tạo signature để xác thực yêu cầu
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        // Chuẩn bị dữ liệu gửi đi
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        // Gửi yêu cầu tới Momo
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);
        // Chuyển hướng người dùng tới URL thanh toán của Momo
        if (isset($jsonResult['payUrl'])) {
            // Chuyển hướng người dùng tới URL thanh toán của MoMo
            return redirect()->to($jsonResult['payUrl']);
        } 
         else {
            // Thanh toán thất bại
            return redirect()->route('checkout.index')->withErrors('Lỗi khi tạo thanh toán.');
        }
    }
}
