<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'donhang';
    
    // Tắt timestamps nếu không sử dụng
    public $timestamps = false;
    
    // Khóa chính
    protected $primaryKey = 'MaDH';
    
    // Chỉ định khóa chính không tự động tăng
    public $incrementing = false;
    
    // Khai báo các thuộc tính có thể gán
    protected $fillable = ['MaDH','MaKH', 'DiaChiGiaoHang', 'NgayDatHang', 'TongGiaTri', 'TrangThai', 'PhuongThucThanhToan','GhiChu'];
    
    // Định dạng thuộc tính kiểu dữ liệu
    protected $casts = [
        'MaDH' => 'string',
        'MaKH' => 'string',
        'NgayDatHang' => 'date',
        'TongGiaTri' => 'decimal:2',  // Số thập phân với 2 chữ số sau dấu phẩy
        'TrangThai' => 'string',
        'PhuongThucThanhToan' => 'string',
        'GhiChu' => 'string'
    ];
    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'MaKH', 'MaKH');
    }
    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'MaDH', 'MaDH');
    }
    public function sanPham()
    {
        return $this->belongsTo(ChiTietSanPham::class, 'MaCTSP', 'MaCTSP');
    }
}