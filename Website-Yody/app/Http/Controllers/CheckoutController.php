<?php

namespace App\Http\Controllers;

use App\Mail\ThanhToanThanhCongMail;
use App\Mail\VoucherMail;
use Illuminate\Http\Request;
use App\Models\GioHang; // Giả sử bạn có model GioHang
use App\Models\ChiTietGioHang; // Model chi tiết giỏ hàng
use App\Models\DonHang; // Model đơn hàng
use App\Models\KhachHang;
use App\Models\Voucher;
use App\Models\ChiTietDonHang; // Model chi tiết đơn hàng
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // Import Mail facade
use App\Mail\WelcomeMail; // Import the WelcomeMail class
class CheckoutController extends Controller
{
    public function index()
    {
        $chiTietGioHang = [];
        $tongTien = 0;
        $giamGia = 0; // Ví dụ, bạn có thể tính giảm giá từ thông tin giỏ hàng hoặc session
        $PhanTramGiamGia = 0;
        $tongGiaTri = 0;
        if(session()->get('MaVC'))
        {
            $PhanTramGiamGia =  session()->get('PhanTramGiamGia');
        }
        else
        {
            $PhanTramGiamGia = 0;
        }
        // Nếu người dùng đã đăng nhập, lấy giỏ hàng từ database
        if (Auth::check()) {
            $user = Auth::user();
            $gioHang = GioHang::where('MaKH', $user->MaKH)->first();
            if ($gioHang) {
                $chiTietGioHang = $gioHang->chiTietGioHang;
                $giamGia = $PhanTramGiamGia;
                $tongGiaTri = $gioHang->TongGiaTri ;
                $tongTien = $gioHang->TongGiaTri-$giamGia + 20000;  
            }
        } else {
            // Nếu người dùng chưa đăng nhập, lấy giỏ hàng từ session
            $gioHangSession = session()->get('gioHang', []);
            $chiTietGioHang = $gioHangSession;
            $tongGiaTri = array_sum(array_column($gioHangSession, 'ThanhTien'));
            $giamGia = $PhanTramGiamGia;
            $tongTien = array_sum(array_column($gioHangSession, 'ThanhTien')) - $giamGia + 20000;
        }

        // Trả về view với chi tiết giỏ hàng và tổng tiền
        return view('checkout.checkout', compact('tongGiaTri','chiTietGioHang', 'tongTien', 'giamGia'));
    }
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
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'diachinha' => 'required|string|max:255',
            'hidden_phuong' => 'required|string|max:255',
            'hidden_quan' => 'required|string|max:255',
            'hidden_tinh' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15', // Thay đổi max theo nhu cầu
            'name' => 'required|string|max:255',
        ],[
            'diachinha.required' => 'Địa chỉ là bắt buộc.',
            'diachinha.string' => 'Địa chỉ phải là một chuỗi ký tự.',
            'diachinha.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'hidden_tinh.required' => 'Tỉnh là bắt buộc.',
            'hidden_quan.required' => 'Quận/Huyện là bắt buộc.',
            'hidden_phuong.required' => 'Phường/Xã là bắt buộc.',
            'email.required' => 'Vui lòng nhập Email',
            'email.email' => 'Vui lòng nhập đúng định dạng Email.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'phone_number.string' => 'Số điện thoại phải là một chuỗi',
            'name.required' => 'Vui lòng nhập Họ và tên.',
            'name.string' => 'Họ và tên phải là một chu��i ký tự.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.'
        ]);
    
        $diachinha = $request->input('diachinha');
        $xa = $request->input('hidden_phuong');
        $huyen = $request->input('hidden_quan');
        $tinh = $request->input('hidden_tinh');
        $diachi = $diachinha . ', ' . $xa . ', ' . $huyen . ', ' . $tinh;
        $email = $request->input('email');
        $sodienthoai = $request->input('phone_number');
        $hoten = $request->input('name');
    
        if (empty($request->hidden_tinh)) {
            return back()->withErrors(['error' => 'Vui lòng chọn Tỉnh']);
        }
        if (empty($request->hidden_quan)) {
            return back()->withErrors(['error' => 'Vui lòng chọn Quận/Huyện']);
        }
        if (empty($request->hidden_phuong)) {
            return back()->withErrors(['error' => 'Vui lòng chọn Phường']);
        }
        
        if(empty($request->email)){
            return back()->withErrors(['error' => 'Vui lòng nhập Email.']);
        }

        if(empty($request->phone_number)){
            return back()->withErrors(['error' => 'Vui lòng nhập số điện thoại.']);
        }

        if(empty($request->name)){
            return back()->withErrors(['error' => 'Vui lòng nhập Họ và tên.']);
        }
        $maVoucher = session()->get('MaVC');
        if ($maVoucher) {
            $voucher = Voucher::where('MaVoucher', $maVoucher)
                ->where('Active', 0)  // Kiểm tra nếu voucher đang hoạt động
                ->first();
            if ($voucher) {
                return redirect()->back()->withErrors(['voucher_code' => 'Voucher đã được sử dụng']);
            }
        }
    
        // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            return $this->saveOrderWithAuth($request, $diachi, $hoten, $email, $sodienthoai);
        } else {
            return $this->saveOrderNoAuth($request, $diachi, $hoten, $email, $sodienthoai);                
        }
    }
    public function saveOrderWithAuth($request,$diachi,$hoten,$email,$sodienthoai)
    {
        $user = Auth::user();
        $gioHang = GioHang::where('MaKH', $user->MaKH)->first();
        $PhanTramGiamGia = 0;
        $giamGia = 0;
        $phiship = 20000;
        if ($gioHang && $gioHang->TongGiaTri > 0) {
            $maDH = 'DH' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            if($request->input('payment_method') == 'Thanh toán momo')
            {
                if(session()->get('MaVC'))
                {
                    $PhanTramGiamGia =  session()->get('PhanTramGiamGia');
                }
                else
                {
                    $PhanTramGiamGia = 0;
                }
                $giamGia = $PhanTramGiamGia;
                $tongTien = (int) ($gioHang->TongGiaTri * 100/100) - $giamGia + $phiship;     
                return $this->ThanhToanMomo($tongTien,$maDH,$diachi,$hoten,$email,$sodienthoai);
            }
            else
            {
                if(session()->get('MaVC'))
                {
                    $PhanTramGiamGia =  session()->get('PhanTramGiamGia');
                }
                else
                {
                    $PhanTramGiamGia = 0;
                }
                $giamGia = (int) $PhanTramGiamGia;
                $tongTien = (int) ($gioHang->TongGiaTri * 100/100) - $giamGia + $phiship;
                // Tạo đơn hàng mới
                $donHang = DonHang::create([
                    'MaDH' => $maDH,
                    'MaKH' => $user->MaKH,
                    'DiaChiGiaoHang' => $diachi,
                    'NgayDatHang' => now(),
                    'TongGiaTri' => $tongTien ,
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
                $this->updateDiemTichLuy($user);
                // Xóa giỏ hàng sau khi hoàn tất thanh toán
                ChiTietGioHang::where('MaGH', $gioHang->MaGH)->delete();
                $gioHang->TongGiaTri = 0;
                $gioHang->save();
      
                $this->ActiveVoucher(session()->get('MaVC'));
                $voucher = $this->CreateVoucher($user);          
                if($voucher != null)
                {
                    Mail::to($user->Email)->send(new VoucherMail($user,$voucher));
                }
                Mail::to($user->Email)->send(new ThanhToanThanhCongMail($user,$donHang));
                return redirect()->route('thanhtoan.ThanhCong')->with('success', 'Đơn hàng của bạn đã được tạo thành công.');
            }
        } else {
            return redirect()->route('cart')->withErrors('Giỏ hàng của bạn trống.');
        }
    }
    public function saveOrderNoAuth($request, $diachi,$hoten,$email,$sodienthoai)
    {
        $gioHangSession = session()->get('gioHang', []);
        $PhanTramGiamGia = 0;
        $giamGia = 0;
        $phiship = 20000;
        if (count($gioHangSession) > 0) 
        {          
            $maKH = 'KHVL' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
          
            $maDH = 'DH' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            if($request->input('payment_method') == 'Thanh toán momo')
            {          
                if(session()->get('MaVC'))
                {
                    $PhanTramGiamGia =  session()->get('PhanTramGiamGia');
                }
                else
                {
                    $PhanTramGiamGia = 0;
                }
                $thanhtien = array_sum(array_column($gioHangSession, 'ThanhTien'));
                $giamGia = (int) $PhanTramGiamGia;
                $tongTien = $thanhtien - $giamGia + $phiship;      
                
                return $this->ThanhToanMomo($tongTien,$maDH,$diachi,$hoten,$email,$sodienthoai);
            }
            $khachhang = KhachHang::create([
                'MaKH' => $maKH,
                'HoTen' => $hoten,
                'Email' => null,
                'SDT' => null,
                'LoaiKH' => 'Online',
                'Username' => null, // Ví dụ trạng thái đơn hàng
                'Password' => null,          
            ]); 
            if(session()->get('MaVC'))
                {
                    $PhanTramGiamGia =  session()->get('PhanTramGiamGia');
                }
                else
                {
                    $PhanTramGiamGia = 0;
                }    
            $tongGT = array_sum(array_column($gioHangSession, 'ThanhTien'));          
            // Tạo đơn hàng mới
            $giamGia = $PhanTramGiamGia;
            $tongTien = $tongGT - $giamGia + $phiship;   
            $ghichu = $email . ', ' . $sodienthoai;        
            $donHang = $this->createDonHang($maDH,$maKH,$diachi,$tongTien,$request->input('payment_method'),$ghichu);               
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
            $this->ActiveVoucher(session()->get('MaVC'));
            Mail::to($email)->send(new ThanhToanThanhCongMail($khachhang,$donHang));
            return redirect()->route('thanhtoan.ThanhCong')->with('success', 'Đơn hàng của bạn đã được tạo thành công.');   
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
    public function ThanhToanMomo($TongTien,$maDH,$diachi,$hoten,$email,$sdt)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529'; // Thay bằng mã của bạn khi dùng live
        $accessKey = 'klm05TvNBzhg7h7j'; // Access key
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa'; // Secret key
        $orderInfo = "Thanh toán qua MoMo"; 
        $amount = $TongTien; // Lấy số tiền từ request hoặc từ giỏ hàng
        $orderId = time() .""; // Mã đơn hàng tự sinh
        $redirectUrl = route('momo.response'); // URL redirect sau khi thanh toán thành công
        $ipnUrl = route('momo.response'); // IPN URL để nhận kết quả thanh toán từ Momo
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
            session()->put('maDH_tam', $maDH);
            session()->put('diachi_tam',$diachi);
            session()->put('tongTien_tam',$TongTien);
            session()->put('HoTenTam_tam',$hoten);
            session()->put('email_tam',$email);
            session()->put('SDT_tam',$sdt);
            return redirect()->to($jsonResult['payUrl']);
        } 
         else {
            dd($jsonResult);
            // Thanh toán thất bại
            return redirect()->route('checkout.index')->withErrors('Lỗi khi tạo thanh toán.');
        }
    }
    public function handleMomoResponse(Request $request)
    {      
        $paymentStatus = $request->input('message');
        if ($paymentStatus != 'Successful.') {
            return redirect()->route('cart');
        }
    
        $maDH = session()->get('maDH_tam');
        $diachi = session()->get('diachi_tam');
        $tongGiaTri = session()->get('tongTien_tam');
    
        if (Auth::check()) {
            $user = Auth::user();
            $donHang = $this->createDonHang($maDH, $user->MaKH, $diachi, $tongGiaTri, 'Thanh toán momo',null);
            $gioHang = GioHang::where('MaKH', $user->MaKH)->first();
            $this->updateDiemTichLuy($user);
            $this->saveChiTietDonHang($donHang, $gioHang->MaGH);
            $voucher = $this->CreateVoucher($user);          
            if($voucher != null)
            {
                Mail::to($user->Email)->send(new VoucherMail($user,$voucher));
            }
            Mail::to($user->Email)->send(new ThanhToanThanhCongMail($user,$donHang));
            $this->clearGioHang($gioHang);
            $this->clearTemporarySessionData();
        } else {
            $gioHangSession = session()->get('gioHang', []);
            $maKH = 'KHVL' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $kh = $this->createKhachHang($maKH);
            $ghichu = session()->get('email_tam') . ', ' . session()->get('SDT_tam');
            $donHang = $this->createDonHang($maDH, $maKH, $diachi, $tongGiaTri, 'Thanh toán momo',$ghichu);
            $this->saveChiTietDonHangFromSession($donHang, $gioHangSession);
            Mail::to(session()->get('email_tam'))->send(new ThanhToanThanhCongMail($kh,$donHang));
            $this->clearTemporarySessionData();
            session()->forget('gioHang');
        }
        $this->ActiveVoucher(session()->get('MaVC'));
        return redirect()->route('products.index')->with('success', 'Thanh toán thành công và đơn hàng của bạn đã được lưu.');
    }
    protected function updateDiemTichLuy($user)
    {
        // Cập nhật điểm tích lũy: tăng lên 1 điểm sau mỗi lần thanh toán thành công
        $khachHang = KhachHang::where('MaKH', $user->MaKH)->first();
        $khachHang->DiemTichLuy += 1;  // Tăng 1 điểm
        $khachHang->save();
    }
    private function createDonHang($maDH, $maKH, $diachi, $tongGiaTri, $paymentMethod,$GhiChu)
    {
        return DonHang::create([
            'MaDH' => $maDH,
            'MaKH' => $maKH,
            'DiaChiGiaoHang' => $diachi,
            'NgayDatHang' => now(),
            'TongGiaTri' => $tongGiaTri,
            'TrangThai' => 'Chưa giao',
            'PhuongThucThanhToan' => $paymentMethod,
            'GhiChu' => $GhiChu
        ]);
    }
    private function saveChiTietDonHang($donHang, $maGH)
    {
        $chiTietGioHang = ChiTietGioHang::where('MaGH', $maGH)->get();
        foreach ($chiTietGioHang as $item) {
            ChiTietDonHang::create([
                'MaDH' => $donHang->MaDH,
                'MaCTSP' => $item->MaCTSP,
                'SoLuong' => $item->SoLuong,
                'DonGia' => $item->DonGia,
                'ThanhTien' => $item->ThanhTien,
            ]);
        }
    }
    private function saveChiTietDonHangFromSession($donHang, $gioHangSession)
    {
        foreach ($gioHangSession as $item) {
            ChiTietDonHang::create([
                'MaDH' => $donHang->MaDH,
                'MaCTSP' => $item['MaCTSP'],
                'SoLuong' => $item['SoLuong'],
                'DonGia' => $item['DonGia'],
                'ThanhTien' => $item['ThanhTien'],
            ]);
        }
    }
    private function clearGioHang($gioHang)
    {
        ChiTietGioHang::where('MaGH', $gioHang->MaGH)->delete();
        $gioHang->update(['TongGiaTri' => 0]);
    }
    private function clearTemporarySessionData()
    {
        session()->forget(['maDH_tam', 'diachi_tam', 'tongTien_tam', 'HoTenTam_tam', 'email_tam', 'SDT_tam']);
    }
    private function createKhachHang($maKH)
    {
        $khachHang = KhachHang::create([
            'MaKH' => $maKH,
            'HoTen' => session()->get('HoTenTam_tam'),
            'Email' => null,
            'SDT' => null,
            'LoaiKH' => 'Online',
            'Username' => null,
            'Password' => null,
        ]);
        return $khachHang;
    }
    public function ThanhToanThanhCong()
    {
        return view('checkout.ThanhToanThanhCong');
    }
    public function applyVoucher(Request $request)
    {
        // Lấy mã voucher từ request
        $maVoucher = $request->input('voucher_code');
    
        // Kiểm tra mã voucher trong database
        $voucher = Voucher::where('MaVoucher', $maVoucher)
                        ->where('Active', 1)  // Kiểm tra nếu voucher đang hoạt động
                        ->first();
        
        if (session()->get('MaVC') && session()->get('MaVC') == $maVoucher) {
            return redirect()->back()->withErrors(['voucher_code' => 'Voucher đang được sử dụng']);
        }
    
        if ($voucher) {
            session()->put('MaVC', $voucher->MaVoucher);
            session()->put('PhanTramGiamGia', $voucher->PhanTramGiamGia);
            return redirect()->back()->with('success', 'Voucher đã được áp dụng thành công.'); // Thông báo thành công
        } else {
            // Thông báo lỗi nếu voucher không hợp lệ
            return redirect()->back()->withErrors(['voucher_code' => 'Voucher không hợp lệ hoặc đã hết hạn.']);
        }
    }
    
    public function cancelVoucher(Request $request)
    {
        session()->forget(['MaVC', 'PhanTramGiamGia']);
        return redirect()->back()->with('success', 'Voucher đã được hủy thành công.');
    }
    public function ActiveVoucher($maVoucher)
    {     
        $voucher = Voucher::find($maVoucher);
        if ($voucher) {
            session()->forget('MaVC');
            session()->forget('PhanTramGiamGia');
            $voucher->Active = 0;
            $voucher->save();
        }
    }
    public function CreateVoucher($user)
    {
        $khachHang = KhachHang::find($user->MaKH);
        if($khachHang->DiemTichLuy >=5)
        {
            $maVC = 'VC' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $vc = Voucher::create([
                'MaVoucher' => $maVC,
                'TenVoucher' => 'Giảm giá 20000đ',
                'PhanTramGiamGia' => 20000,
                'Active' => 1,       
                'NgayBD' => now(),
                'NgayKT' => now()->addDays(7),
                'MaKH' => $user->MaKH
            ]);
            $khachHang->update(['DiemTichLuy' => 0]);
            return $vc;
        }
        else {
            return null;  // Trả về null nếu không đủ điều kiện tạo voucher
        }
    }
}