<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;
    protected $table = 'sanpham';
    public $timestamps = false;
    protected $primaryKey = 'MaSP';
    protected $fillable = ['TenSP','TrangThai','GiaBan'];
    // Thiết lập mối quan hệ với ChiTietSanPham
    public function chiTietSanPham()
    {
        return $this->hasOne(ChiTietSanPham::class, 'MaSP', 'MaSP')
        ->orderBy('MaCTSP'); // Sắp xếp để lấy chi tiết đầu tiên
    }
}
