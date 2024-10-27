<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonNhapHang extends Model
{
    use HasFactory;
    protected $table = 'donnhaphang';
    protected $primaryKey = 'MaNH';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = ['MaNH', 'MaNCC', 'NgayDatHang', 'TongGiaTri'];

    public function nhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'MaNCC');
    }

    public function chitietdonnhaphangs()
    {
        return $this->hasMany(ChiTietDonNhapHang::class, 'MaNH', 'MaNH');
    }
}
