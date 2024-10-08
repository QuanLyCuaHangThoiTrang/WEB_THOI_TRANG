<?php

namespace App\Mail;

use App\Models\KhachHang;
use App\Models\DonHang; // Nhập model DonHang
use App\Models\ChiTietDonHang; // Nhập model ChiTietDonHang
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThanhToanThanhCongMail extends Mailable
{
    use Queueable, SerializesModels;

    public $khachHang; // Biến cần viết thường
    public $donHang; // Thêm biến để lưu thông tin đơn hàng
    public $chiTietDonHang; // Thêm biến để lưu thông tin chi tiết đơn hàng

    public function __construct(KhachHang $kh, DonHang $donHang)
    {
        $this->khachHang = $kh;
        $this->donHang = $donHang;
        $this->chiTietDonHang = $donHang->chiTietDonHang; // Lấy chi tiết đơn hàng
    }

    public function build()
    {
        return $this->view('emails.ThanhToanThanhCong')
            ->subject('Xác nhận thanh toán thành công')
            ->with([
                'khachHang' => $this->khachHang,
                'donHang' => $this->donHang,
                'chiTietDonHang' => $this->chiTietDonHang,
            ]);
    }
}