<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    protected $fillable = ['TenCTDM','MaDanhMuc'];
}
