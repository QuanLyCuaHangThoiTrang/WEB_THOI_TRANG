<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietSanPhamNhap extends Model
{
    use HasFactory;

    // Đặt tên bảng
    protected $table = 'chitietsanphamnhap';

    // Các thuộc tính có thể gán hàng loạt
    protected $fillable = [
        'MaNH',
        'MaSP',
        'MaCTSP',
        'SoLuongNhap',
    ];

    // Nếu bảng không có trường timestamps
    public $timestamps = false;

    // Đặt khóa chính là một mảng của các cột
    protected $primaryKey = ['MaNH', 'MaSP', 'MaCTSP'];

    // Khóa chính không tự tăng
    public $incrementing = false;

    // Đặt kiểu khóa chính là string
    protected $keyType = 'string';
    public function chiTietSanPham()
    {
        return $this->belongsTo(ChiTietSanPham::class, 'MaCTSP', 'MaCTSP');
    }
}
