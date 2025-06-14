<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_status'];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'status_id');
    }
}
