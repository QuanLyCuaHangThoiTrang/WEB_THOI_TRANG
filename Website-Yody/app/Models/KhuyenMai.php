<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhuyenMai extends Model
{
    use HasFactory;
    protected $table = 'khuyenmai';
    protected $primaryKey = 'MaKM';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'MaKM',
        'TenKM',
        'MoTa',
        'PhanTramGiamGia',
        'NgayBatDau',
        'NgayKetThuc'
    ];
    public $timestamps = false;
    public function sanPhamKhuyenMais()
    {
        return $this->hasMany(SanPhamKhuyenMai::class, 'MaKM', 'MaKM');
    }
    public function sanPhams()
    {
        return $this->hasManyThrough(SanPham::class, SanPhamKhuyenMai::class, 'MaKM', 'MaSP', 'MaKM', 'MaSP');
    }
}
