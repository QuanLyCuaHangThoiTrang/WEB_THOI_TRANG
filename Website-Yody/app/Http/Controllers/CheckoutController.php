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
use App\Models\DiaChiKhachHang;
use Illuminate\Support\Facades\Session;
use App\Models\ChiTietSanPham;

class CheckoutController extends Controller
{
    public function index()
    {
        $chiTietGioHang = [];
        $tongTien = 0;
        $giamGia = 0; 
        $PhanTramGiamGia = 0;
        $tongGiaTri = 0;
        $PhiShip = 20000;

        //Kiểm tra đã áp dụng Voucher chưa
        if(session()->get('MaVC'))
        {
            $PhanTramGiamGia =  session()->get('PhanTramGiamGia');
        }
        else
        {
            $PhanTramGiamGia = 0;
        }
   
        if (Auth::check()) {
            $user = Auth::user();
            $gioHang = GioHang::where('MaKH', $user->MaKH)->first();
            $diaChiFulls = DiaChiKhachHang::where('MaKH',$user->MaKH)->get();
            if ($gioHang) {
                $chiTietGioHang = $gioHang->chiTietGioHang;
                $giamGia = $PhanTramGiamGia;
                $tongGiaTri = $gioHang->TongGiaTri ;
                $tongTien = $gioHang->TongGiaTri-$giamGia + $PhiShip;  
                if($tongTien > 500000){
                    $PhiShip = 0;
                    $tongTien = $gioHang->TongGiaTri-$giamGia + $PhiShip; 
                }
            }
        } else {
            // Nếu người dùng chưa đăng nhập, lấy giỏ hàng từ session
            $gioHangSession = session()->get('gioHang', []);
            $chiTietGioHang = $gioHangSession;
            $tongGiaTri = array_sum(array_column($gioHangSession, 'ThanhTien'));
            $giamGia = $PhanTramGiamGia;
            $tongTien = array_sum(array_column($gioHangSession, 'ThanhTien')) - $giamGia + $PhiShip;
            if($tongTien > 500000){
                $PhiShip = 0;
                $tongTien = array_sum(array_column($gioHangSession, 'ThanhTien')) - $giamGia + $PhiShip;
            }
        }

        // Trả về view với chi tiết giỏ hàng và tổng tiền
        if (Auth::check())
        {
            return view('checkout.checkout', compact('tongGiaTri','chiTietGioHang', 'tongTien', 'giamGia','diaChiFulls','PhiShip'));
        }
        else
        {
            return view('checkout.checkout', compact('tongGiaTri','chiTietGioHang', 'tongTien', 'giamGia','PhiShip'));
        }
    }
    public function processCheckoutDH(Request $request)
    {
        if (Auth::check()) {
            $kt = true;
            $user = Auth::user();          
            $gioHang = GioHang::where('MaKH', $user->MaKH)->first();
            if ($gioHang && $gioHang->TongGiaTri > 0) {
                $chiTietGioHang = ChiTietGioHang::where('MaGH', $gioHang->MaGH)->get();
                foreach($chiTietGioHang as $item)
                {
                    if($item->ChiTietSanPham->SoLuongTonKho == 0 || $item->SoLuong > $item->ChiTietSanPham->SoLuongTonKho){
                        return redirect()->route(route: 'cart')->withErrors('Sản phẩm bạn mua đã hết hàng');
                    }
                }
                return $this->storeOrder($request);
            }         
            else 
            {
                return redirect()->route(route: 'cart')->withErrors('Giỏ hàng của bạn trống.');
            }
        } 
        else 
        {
            $gioHangSession = Session::get('gioHang', []); 
            foreach($gioHangSession as $item)
            {
                $ChiTietSanPham = $this->TimChiTietSanPham($item['MaSP'],$item['MaMau'],$item['MaSize']);        
                if($ChiTietSanPham && ($item['SoLuongTonKho'] == 0 || $item['SoLuong'] > $ChiTietSanPham->SoLuongTonKho))
                {              
                    return redirect()->route(route: 'cart')->withErrors('Sản phẩm bạn mua đã hết hàng');
                }
            }
            return $this->storeOrder($request);   
        }
    }

    public function TimChiTietSanPham($MaSP,$MaMau,$MaSize)
    {
        return ChiTietSanPham::where('MaSP',$MaSP)
        ->where('MaMau',$MaMau)
        ->where('MaSize',$MaSize)->first();
    }
    public function storeOrder(Request $request)
    {
        $email = $request->input('email');
        $hoten = $request->input('name');
        $maDC = $request->input('diachifull');   
        $diaChiKH = DiaChiKhachHang::where('MaDC', $maDC)->first();
        $diachinha = $request->input('diachinha');       
        $xa = $request->input('hidden_phuong');
        $huyen = $request->input('hidden_quan');
        $tinh = $request->input('hidden_tinh');
        $sdt = $request->input('phone_number');
        $ghichu = $request->input('Message');
        //validate
        if (empty($hoten)) {
            return redirect()->back()->withErrors(['HoTen' => 'Họ tên không được để trống.']);
        }     
        if (empty($email)) {
            return redirect()->back()->withErrors('Không được để trống email');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withErrors('Định dạng email không hợp lệ');
        }        
        if(!Auth::check())
        {
            if (empty($diachinha)) {
                return redirect()->back()->withErrors('Không được để trống địa chỉ');
            }
            if (empty($xa) || empty($huyen) || empty($tinh))
            {
                return redirect()->back()->withErrors('Vui lòng chọn tỉnh, huyện, xã');
            }
        }    
        if(empty($sdt) )
        {
            return redirect()->back()->withErrors('Vui lòng nhập số điện thoại');
        }
        
        if ($diaChiKH && Auth::check()) {
            $diachinha = $diaChiKH->Duong;
            $xa = $diaChiKH->Phuong;
            $huyen = $diaChiKH->Huyen;
            $tinh = $diaChiKH->Tinh;
            if (empty($diachinha)) {
                return redirect()->back()->withErrors('Không được để trống địa chỉ');
            }
            if (empty($xa) || empty($huyen) || empty($tinh))
            {
                return redirect()->back()->withErrors('Vui lòng chọn tỉnh, huyện, xã');
            }
        }     
        // Thêm địa chỉ mới
        if ($request->has('newAddress') && !empty($request->input('newAddress'))) {
            // Tạo địa chỉ mới
            $newAddress = new DiaChiKhachHang();
            
            if (Auth::check()) {
                $user = Auth::user(); // Lấy thông tin người dùng đã xác thực
                $newAddress->MaKH = $user->MaKH; // Gán MaKH từ đối tượng người dùng
            } else {
                // Xử lý trường hợp người dùng chưa đăng nhập
                return response()->json(['error' => 'User is not authenticated'], 401);
            }
            
            $newAddress->MaDC = uniqid(); // Nếu MaDC không tự động tăng
            $newAddress->Duong = $request->input('newAddress');
            $newAddress->Phuong = $request->input('hidden_phuong');
            $newAddress->Huyen = $request->input('hidden_quan');
            $newAddress->Tinh = $request->input('hidden_tinh');
            if (empty($newAddress->Duong)) {
                return redirect()->back()->withErrors('Không được để trống địa chỉ');
            }
            if (empty($newAddress->Phuong) || empty($newAddress->Huyen) || empty($newAddress->Tinh))
            {
                return redirect()->back()->withErrors('Vui lòng chọn tỉnh, huyện, xã');
            }
    
            $newAddress->save(); // Lưu địa chỉ mới vào cơ sở dữ liệu        
    
            // Sử dụng địa chỉ mới cho đơn hàng
            $diachi = $newAddress->Duong . ', ' . $newAddress->Phuong . ', ' . $newAddress->Huyen . ', ' . $newAddress->Tinh;
        } else {
            $diachi = $diachinha . ', ' . $xa . ', ' . $huyen . ', ' . $tinh; 
        }
    
        $email = $request->input('email');
        $sodienthoai = $request->input('phone_number');
        $hoten = $request->input('name');
    
        // Handle voucher logic as before
    
        // Save order based on authentication
        if (Auth::check()) {
            return $this->saveOrderWithAuth($request, $diachi, $hoten, $email, $sodienthoai,$ghichu);
        } else {
            return $this->saveOrderNoAuth($request, $diachi, $hoten, $email, $sodienthoai,$ghichu);                
        }
    }
    
    
    
    public function saveOrderWithAuth($request,$diachi,$hoten,$email,$sodienthoai,$ghichu)
    {
        $user = Auth::user();
        $gioHang = GioHang::where('MaKH', $user->MaKH)->first();
        $PhanTramGiamGia = 0;
        $giamGia = 0;
        $phiship = 20000;
        if ($gioHang && $gioHang->TongGiaTri > 0) {
            do {
                $maDH = 'DH' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $maDHTrung = DonHang::where('MaDH', $maDH)->exists();
            } while ($maDHTrung);
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
                if($tongTien > 500000)
                {
                    $phiship = 0;
                    $tongTien = (int) ($gioHang->TongGiaTri * 100/100) - $giamGia + $phiship;   
                }              
                return $this->ThanhToanMomo($tongTien,$maDH,$diachi,$hoten,$email,$sodienthoai,$ghichu);
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
                if($tongTien > 500000)
                {
                    $phiship = 0;
                    $tongTien = (int) ($gioHang->TongGiaTri * 100/100) - $giamGia + $phiship;   
                }     
                // Tạo đơn hàng mới
                $donHang = DonHang::create([
                    'MaDH' => $maDH,
                    'MaKH' => $user->MaKH,
                    'DiaChiGiaoHang' => $diachi,
                    'NgayDatHang' => now(),
                    'TongGiaTri' => $tongTien ,
                    'TrangThai' => 'Chờ xác nhận', // Ví dụ trạng thái đơn hàng
                    'PhuongThucThanhToan' => $request->input('payment_method'),
                    'GhiChu' => $ghichu
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
    public function saveOrderNoAuth($request, $diachi,$hoten,$email,$sodienthoai,$ghichu)
    {
        $gioHangSession = session()->get('gioHang', []);
        $PhanTramGiamGia = 0;
        $giamGia = 0;
        $phiship = 20000;
        if (count($gioHangSession) > 0) 
        {          
            do {
                $maKH = 'KHVL' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $maKHTrung = KhachHang::where('MaKH', $maKH)->exists();
            } while ($maKHTrung);
            
            // Tạo mã đơn hàng và kiểm tra trùng
            do {
                $maDH = 'DH' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $maDHTrung = DonHang::where('MaDH', $maDH)->exists();
            } while ($maDHTrung);
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
                
                return $this->ThanhToanMomo($tongTien,$maDH,$diachi,$hoten,$email,$sodienthoai,$ghichu);
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
            if($ghichu || $ghichu !='')
            {
                $ghichu = $email . ', ' . $sodienthoai . ', ' . $ghichu;       
            }else{
                $ghichu = $email . ', ' . $sodienthoai;      
            }  
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
    public function ThanhToanMomo($TongTien,$maDH,$diachi,$hoten,$email,$sdt,$ghichu)
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
            $this->SessionPut($maDH,$diachi,$TongTien,$hoten,$email,$sdt,$ghichu);
            return redirect()->to($jsonResult['payUrl']);
        } 
         else {
            dd($jsonResult);
            // Thanh toán thất bại
            return redirect()->route('checkout.index')->withErrors('Lỗi khi tạo thanh toán.');
        }
    }
    public function SessionPut($maDH,$diachi,$TongTien,$hoten,$email,$sdt,$ghichu)
    {
        session()->put('maDH_tam', $maDH);
        session()->put('diachi_tam',$diachi);
        session()->put('tongTien_tam',$TongTien);
        session()->put('HoTenTam_tam',$hoten);
        session()->put('email_tam',$email);
        session()->put('SDT_tam',$sdt);
        session()->put('ghichu_tam',$ghichu);
    }
    public function handleMomoResponse(Request $request)
    {      
        $paymentStatus = $request->input('message');
        if ($paymentStatus != 'Successful.') {
            return redirect()->route('cart');
        } 

        //get session MaDH,DiaChi...
        $maDH = session()->get('maDH_tam');
        $diachi = session()->get('diachi_tam');
        $tongGiaTri = session()->get('tongTien_tam');
        $ghichutam = session()->get('ghichu_tam');  

        // Kiểm tra đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $ghichu = $ghichutam;
            $donHang = $this->createDonHang($maDH, $user->MaKH, $diachi, $tongGiaTri, 'Thanh toán momo',$ghichu);
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
             //KT ghi chú
            if($ghichutam || $ghichutam != ''){
                $ghichutam = ', ' . $ghichutam;
            }   
            $ghichu = session()->get('email_tam') . ', ' . session()->get('SDT_tam') .$ghichutam;        
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
        $khachHang->DiemTichLuy += 2000;  // Tăng 1 điểm
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
            $this->CreateChiTietDonHang($donHang->MaDH,$item['MaCTSP'],$item['SoLuong'],$item['DonGia'],$item['ThanhTien']);
        }
    }
    public function CreateChiTietDonHang($MaDH,$MaCTSP,$SoLuong,$DonGia,$ThanhTien)
    { 
        ChiTietDonHang::create([
            'MaDH' => $MaDH,
            'MaCTSP' => $MaCTSP,
            'SoLuong' => $SoLuong,
            'DonGia' => $DonGia,
            'ThanhTien' => $ThanhTien,
        ]);
    }
    private function clearGioHang($gioHang)
    {
        ChiTietGioHang::where('MaGH', $gioHang->MaGH)->delete();
        $gioHang->update(['TongGiaTri' => 0]);
    }
    private function clearTemporarySessionData()
    {
        session()->forget(['maDH_tam', 'diachi_tam', 'tongTien_tam', 'HoTenTam_tam', 'email_tam', 'SDT_tam', 'ghichu_tam']);
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
        $maVoucher = $request->input('voucher_code');
        $voucher = $this->KTVoucherActive($maVoucher);
        
        if (session()->get('MaVC') && session()->get('MaVC') == $maVoucher) {
            return redirect()->back()->withErrors(['voucher_code' => 'Voucher đang được sử dụng']);
        }
    
        if ($voucher) {
            $this->SessionPutVoucher($voucher);
            return redirect()->back()->with('success', 'Voucher đã được áp dụng thành công.');
        } else {
            return redirect()->back()->withErrors(['voucher_code' => 'Voucher không hợp lệ hoặc đã hết hạn.']);
        }
    }
    public function SessionPutVoucher($voucher)
    {
        session()->put('MaVC', $voucher->MaVoucher);
        session()->put('PhanTramGiamGia', $voucher->PhanTramGiamGia);
    }
    public function KTVoucherActive($maVoucher)
    {
        return Voucher::where('MaVoucher', $maVoucher)
        ->where('Active', 1)  // Kiểm tra nếu voucher đang hoạt động
        ->first();
    }
    public function cancelVoucher(Request $request)
    {
        session()->forget(['MaVC', 'PhanTramGiamGia']);
        return redirect()->back()->with('success', 'Voucher đã được hủy thành công.')->with('updateInterface', true);
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
        if($khachHang->DiemTichLuy >=20000)
        {
            do {
                $maVC = 'VC' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            } while (Voucher::where('MaVoucher', $maVC)->exists());
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
            $khachHang->increment('SoVoucher', 1);
            return $vc;
        }
        else {
            return null;  // Trả về null nếu không đủ điều kiện tạo voucher
        }
    }
}