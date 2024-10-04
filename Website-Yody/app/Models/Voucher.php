<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'voucher';
    public $timestamps = false;
    protected $primaryKey = 'MaVoucher';
    protected $casts = [
        'MaVoucher' => 'string',
        'TenVoucher' => 'string',
    ];
    protected $fillable = ['TenVoucher','PhanTramGiamGia','Active'];
}
