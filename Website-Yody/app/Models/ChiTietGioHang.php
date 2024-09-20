<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietGioHang extends Model
{
     use HasFactory;

    protected $table = 'chitietgiohang'; // Tên bảng trong cơ sở dữ liệu
    public $timestamps = false; // Không sử dụng các trường timestamps (created_at, updated_at)
    public $incrementing = false; // Không tự động tăng
    protected $primaryKey = ['MaGH','MaCTSP'];
    // Cấu hình các thuộc tính có thể được gán
    protected $fillable = ['MaGH','MaCTSP','SoLuong', 'DonGia', 'ThanhTien'];

    // Cấu hình kiểu dữ liệu của các thuộc tính
    protected $casts = [
        'MaGH' => 'string',
        'MaCTSP' => 'string',
        'SoLuong' => 'integer',
        'DonGia' => 'decimal:2',
        'ThanhTien' => 'decimal:2',
    ];

    // Thiết lập mối quan hệ với bảng GioHang
    public function gioHang()
    {
        return $this->belongsTo(GioHang::class, 'MaGH', 'MaGH');
    }

    // Thiết lập mối quan hệ với bảng ChiTietSanPham
    public function chiTietSanPham()
    {
        return $this->belongsTo(ChiTietSanPham::class, 'MaCTSP', 'MaCTSP');
    }
    public function sanPham()
    {
        return $this->hasOneThrough(SanPham::class, ChiTietSanPham::class, 'MaCTSP', 'MaSP', 'MaCTSP', 'MaSP');
    }
}
