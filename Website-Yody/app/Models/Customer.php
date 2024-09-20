<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model implements UserContract
{
    use \Illuminate\Auth\Authenticatable; // Laravel's implementation of UserContract

    // Specify the table associated with the model
    protected $table = 'khachhang';

    // Specify the primary key of the table
    protected $primaryKey = 'MaKH';
    
    protected $casts = [
      
        'MaKH' => 'string',
      
    ];

    // Specify the attributes that are mass assignable
    protected $fillable = ['MaKH', 'HoTen', 'Email', 'SDT', 'LoaiKH', 'Username', 'Password'];

    // Disable timestamps if they are not used in the table
    public $timestamps = false;

    // Use this attribute for the password field
    protected $hidden = [
        'Password',
    ];

    // Implement the methods required by the Authenticatable contract
    public function getAuthPassword()
    {
        return $this->Password;
    }
}