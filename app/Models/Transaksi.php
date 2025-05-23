<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'wahana_id', 'status_id', 'jumlah_tiket'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function wahana()
    {
        return $this->belongsTo(Wahana::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
