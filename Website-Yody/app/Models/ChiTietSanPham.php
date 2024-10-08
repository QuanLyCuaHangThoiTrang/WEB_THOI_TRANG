<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietSanPham extends Model
{
    use HasFactory;
    protected $table = 'chitietsanpham';
    public $timestamps = false;
    protected $primaryKey = 'MaCTSP';
    protected $fillable = ['MaSP','MaCTSP','TenSP', 'MaSize', 'MaMau','HinhAnh','SKU', 'SoLuongTonKho'];
    protected $casts = [
        'MaCTSP' => 'string',
        'HinhAnh' => 'string',
    ];
    // Thiết lập mối quan hệ với SanPham
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'MaSP', 'MaSP');
    }
    // Liên kết với model KichThuoc
    public function kichThuoc()
    {
        return $this->belongsTo(KichThuoc::class, 'MaSize', 'MaSize');
    }

    // Liên kết với model MauSac
    public function mauSac()
    {
        return $this->belongsTo(MauSac::class, 'MaMau', 'MaMau');
    }
}
