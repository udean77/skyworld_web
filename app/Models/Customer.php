<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // <--- ganti ini
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'customers';

    protected $fillable = [
        'kode_customer', 'nama', 'email', 'no_telp', 'password'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function transaksis()
    {
        return $this->hasMany(\App\Models\Transaksi::class);
    }
}
