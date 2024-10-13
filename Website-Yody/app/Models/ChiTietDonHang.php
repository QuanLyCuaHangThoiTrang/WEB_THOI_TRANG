<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    use HasFactory;
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'chitietdonhang';
    
    // Tắt timestamps nếu không sử dụng
    public $timestamps = false;
    
    // Khóa chính
    protected $primaryKey = ['MaDH','MaCTSP'];
    
    // Chỉ định khóa chính không tự động tăng
    public $incrementing = false;
    
    // Khai báo các thuộc tính có thể gán
    protected $fillable = ['MaDH', 'MaCTSP', 'SoLuong', 'DonGia', 'ThanhTien','DaDanhGia'];
    
    // Định dạng thuộc tính kiểu dữ liệu
    protected $casts = [
        'MaDH' => 'string',
        'MaCTSP' => 'string',
        'SoLuong' => 'integer',
        'DonGia' => 'decimal:2',  // Số thập phân với 2 chữ số sau dấu phẩy
        'ThanhTien' => 'decimal:2',
        'DaDanhGia' => 'integer',
    ];
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'MaDH', 'MaDH');
    }
    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'MaKH', 'MaKH');
    }
    public function chiTietSanPham()
    {
        return $this->belongsTo(ChiTietSanPham::class, 'MaCTSP', 'MaCTSP');
    }
    public function sanPham()
    {
        return $this->hasOneThrough(SanPham::class, ChiTietSanPham::class, 'MaCTSP', 'MaSP', 'MaCTSP', 'MaSP');
    }
}