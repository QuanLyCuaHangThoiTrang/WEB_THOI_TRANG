<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    use HasFactory;
    protected $table = 'nhacungcap';
    protected $primaryKey = 'MaNCC';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [
        'MaNCC', 'TenNCC', 'SDT', 'Email', 'DiaChi'
    ];
}
