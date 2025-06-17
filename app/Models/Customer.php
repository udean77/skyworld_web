<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'customers';
    protected $primaryKey = 'kode_customer';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_customer',
        'nama',
        'email',
        'password',
        'no_telp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'kode_customer', 'kode_customer');
    }
}
