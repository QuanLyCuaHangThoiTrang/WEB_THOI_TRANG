<?php

namespace App\Mail;

use App\Models\KhachHang; // Ensure you import the model
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $khachHang;

    public function __construct(KhachHang $khachHang)
    {
        $this->khachHang = $khachHang;
    }

    public function build()
    {
        return $this->from('duybadao05@gmail.com', 'Yody') // Đặt địa chỉ và tên người gửi
                    ->subject('Chào mừng đến với Yody')
                    ->view('emails.welcome') // Chỉ định view cho nội dung email
                    ->with([
                        'name' => $this->khachHang->HoTen, // Truyền tên
                        'MaKH' => $this->khachHang->MaKH // Truyền mã khách hàng
                    ]); 
    }
}