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
    ];

    protected $fillable = [

        'MaKH',
        'MaCTSP',
        'DiemDanhGia',
        'NoiDung',
        'NgayDanhGia',
    ];

    public $timestamps = false;
}