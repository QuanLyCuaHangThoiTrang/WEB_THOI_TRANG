<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaChiKhachHang extends Model
{
    use HasFactory;

    protected $table = 'diachikhachhang'; // Specify the table name if it doesn't follow Laravel's conventions

    protected $primaryKey = 'MaDC'; // Specify the primary key
    
    protected $casts = [
      
        'MaDC' => 'string',
      
    ];

    protected $fillable = [
        'MaDC',
        'MaKH',
        'Duong',
        'Phuong',
        'Huyen',
        'Tinh',
    ];
    public $timestamps = false; 
    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'MaKH', 'MaKH');
    }
}