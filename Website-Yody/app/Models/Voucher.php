<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'voucher';  // Tên bảng tương ứng
    public $timestamps = false;    // Bảng không có cột timestamps
    protected $primaryKey = 'MaVoucher';  // Khóa chính là MaVoucher
    public $incrementing = false;  // Do MaVoucher không phải là auto-increment
    protected $keyType = 'string'; // Định dạng của khóa chính là chuỗi

    protected $fillable = [
        'MaVoucher',
        'TenVoucher',
        'PhanTramGiamGia',
        'Active',
        'NgayBD',
        'NgayKT',
        'MaKH',
    ];

    // Định dạng cột ngày tháng theo kiểu date
    protected $dates = [
        'NgayBD',
        'NgayKT',
    ];

    // Cast dữ liệu để đảm bảo kiểu dữ liệu chính xác
    protected $casts = [
        'MaVoucher' => 'string',
        'TenVoucher' => 'string',
        'PhanTramGiamGia' => 'integer',
        'Active' => 'integer',
        'MaKH' => 'string',
    ];
   // Nếu cần quan hệ với bảng khachhang
    public function khachhang()
    {
        return $this->belongsTo(KhachHang::class, 'MaKH', 'MaKH');
    }
}

