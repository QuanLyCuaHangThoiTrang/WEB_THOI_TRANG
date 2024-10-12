<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KichThuoc extends Model
{
    use HasFactory;
    protected $table = 'kichthuoc';
    public $timestamps = false;
    protected $primaryKey = 'MaSize';

    // Khai báo các thuộc tính có thể gán
    protected $fillable = ['MaSize','TenSize'];
    protected $casts = [
        'MaSize' => 'string',
    ];
    public function chiTietSanPhams()
    {
        return $this->hasMany(ChiTietSanPham::class, 'MaSize', 'MaSize');
    }
}
