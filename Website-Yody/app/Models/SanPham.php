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
    protected $casts = [
        'MaSP' => 'string',
        'MaCTDM' => 'string',
    ];
    protected $fillable = ['TenSP','MaCTDM','TrangThai','GiaBan'];
    // Thiết lập mối quan hệ với ChiTietSanPham
    public function chiTietSanPham()
    {
        return $this->hasMany(ChiTietSanPham::class, 'MaSP', 'MaSP');
    }
}
