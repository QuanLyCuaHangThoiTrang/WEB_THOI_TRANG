<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    use HasFactory;

    protected $table = 'danhgia';
    protected $primaryKey = 'MaDG';
    
    protected $casts = [
        'MaDG' => 'string',
        'NoiDung'=> 'string',
    ];

    protected $fillable = [
        'MaDG',
        'MaKH',
        'MaCTSP',
        'DiemDanhGia',
        'NoiDung',
        'NgayDanhGia',
    ];

    public $timestamps = false;
    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'MaKH', 'MaKH');
    }
}