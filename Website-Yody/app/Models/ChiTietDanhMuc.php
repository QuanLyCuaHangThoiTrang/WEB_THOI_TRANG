<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DanhMuc;

class ChiTietDanhMuc extends Model
{
    use HasFactory;
    protected $table = 'chitietdanhmuc';
    public $timestamps = false;
    protected $primaryKey = 'MaCTDM';
    protected $casts = [
        'MaCTDM' => 'string',
        'TenCTDM' => 'string',
        'MaDanhMuc' => 'string'
    ];
    protected $fillable = ['MaCTDM','TenCTDM','MaDanhMuc'];
    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'MaDanhMuc', 'MaDanhMuc');
    }

    // Quan hệ với bảng SanPham
    public function sanPham()
    {
        return $this->hasMany(SanPham::class, 'MaCTDM', 'MaCTDM');
    }
}
