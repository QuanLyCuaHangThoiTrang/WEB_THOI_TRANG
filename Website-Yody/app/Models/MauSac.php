<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MauSac extends Model
{
    use HasFactory;
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'mausac';
    
    // Tắt timestamps nếu không sử dụng
    public $timestamps = false;
    
    // Khóa chính
    protected $primaryKey = 'MaMau';
    
    // Chỉ định khóa chính không tự động tăng
    public $incrementing = false;
    
    // Khai báo các thuộc tính có thể gán
    protected $fillable = ['MaMau', 'TenMau'];
    
    // Định dạng thuộc tính kiểu dữ liệu
    protected $casts = [
        'MaMau' => 'string',
    ];
    public function chiTietSanPhams()
    {
        return $this->hasMany(ChiTietSanPham::class, 'MaMau', 'MaMau');
    }
}
