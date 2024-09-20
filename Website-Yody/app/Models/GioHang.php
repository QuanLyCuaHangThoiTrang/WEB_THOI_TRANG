<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    use HasFactory;

    protected $table = 'giohang'; // Đặt tên bảng đúng
    protected $primaryKey = 'MaGH'; // Khóa chính là MaGH
    public $timestamps = false;
    protected $casts = [
        'MaGH' => 'string',
        'NgayTao' => 'datetime',
        'TongGiaTri' => 'decimal:2',
    ];
    protected $fillable = ['MaGH','MaKH', 'NgayTao', 'TongGiaTri'];

    // Quan hệ với ChiTietGioHang
    public function chiTietGioHang()
    {
        return $this->hasMany(ChiTietGioHang::class, 'MaGH', 'MaGH');
    }

    // Quan hệ với KhachHang
    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'MaKH', 'MaKH');
    }
}
