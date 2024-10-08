<?php

namespace App\Mail;

use App\Models\KhachHang;
use App\Models\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VoucherMail extends Mailable
{
    use Queueable, SerializesModels;

    public $khachHang;
    public $voucher;

    public function __construct(KhachHang $kh, Voucher $voucher)
    {
        $this->khachHang = $kh;
        $this->voucher = $voucher;
    }

    public function build()
    {
        return $this->view('emails.VoucherMail') // Tạo view cho voucher
            ->subject('Nhận voucher ưu đãi từ chúng tôi')
            ->with([
                'khachHang' => $this->khachHang,
                'voucher' => $this->voucher,
            ]);
    }
}
