<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonNhapHang extends Model
{
    use HasFactory;
    protected $table = 'chitietdonnhaphang';
    
    protected $primaryKey = ['MaNH', 'MaSP'];
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string'; // Có thể cần phải xem xét nếu là array
    protected $fillable = ['MaNH', 'MaSP', 'TongSoLuong', 'GiaNhap', 'ThanhTien'];
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        return $this->original[$keyName] ?? $this->getAttribute($keyName);
    }
    // Quan hệ
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'MaSP');
    }

    public function donNhapHang()
    {
        return $this->belongsTo(DonNhapHang::class, 'MaNH');
    }
    public function chitietSanPhamNhap()
    {
        return $this->hasMany(ChiTietSanPhamNhap::class, 'MaNH', 'MaNH');
    }
    
}
