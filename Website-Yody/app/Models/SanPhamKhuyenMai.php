<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPhamKhuyenMai extends Model
{
    use HasFactory;
    protected $table = 'sanphamkhuyenmai';
    protected $primaryKey = ['MaKM', 'MaSP'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'MaKM',
        'MaSP'
    ];
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
    public $timestamps = false;
    public function khuyenMai()
    {
        return $this->belongsTo(KhuyenMai::class, 'MaKM', 'MaKM');
    }
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'MaSP', 'MaSP');
    }
}
