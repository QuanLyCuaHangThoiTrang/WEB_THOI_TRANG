<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Sử dụng lớp này để hỗ trợ xác thực
use Illuminate\Notifications\Notifiable;

class KhachHang extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'khachhang'; // Tên bảng
    protected $primaryKey = 'MaKH'; // Khóa chính
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['MaKH', 'HoTen', 'Email', 'SDT', 'LoaiKH','Username','Password', 'Provider', 'Provider_ID', 'Provider_Token','DiemTichLuy','SoVoucher'];
    protected $casts = [ 
        'MaKH' => 'string',
    ];

    protected $hidden = [
        'Password', // Ẩn mật khẩu khi trả về dữ liệu
    ];

    // Quan hệ với GioHang
    public function gioHang()
    {
        return $this->hasMany(GioHang::class, 'MaKH', 'MaKH');
    }
    public function getAuthPassword()
    {
        return $this->Password; // Trả về trường Password từ bảng khachhang
    }
    public function donHang()
    {
        return $this->hasMany(DonHang::class, 'MaKH', 'MaKH');
    }
}