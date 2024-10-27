<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    use HasFactory;
    protected $table = 'danhmuc';
    public $timestamps = false;
    protected $primaryKey = 'MaDanhMuc';
    protected $casts = [
        'MaDanhMuc' => 'string',
        'TenDanhMuc' => 'string',
    ];
    protected $fillable = ['MaDanhMuc','TenDanhMuc'];
    public function chiTietDanhMuc()
    {
        return $this->hasMany(ChiTietDanhMuc::class, 'MaDanhMuc', 'MaDanhMuc');
    }
}
