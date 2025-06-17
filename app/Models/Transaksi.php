<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'transaksi_id',
        'kode_customer',
        'wahana_id',
        'status_id',
        'jumlah_tiket',
        'total_harga',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi) {
            if (empty($transaksi->transaksi_id)) {
                $lastTransaksi = self::orderBy('id', 'desc')->first();
                $lastId = $lastTransaksi ? $lastTransaksi->id : 0;
                $transaksi->transaksi_id = 'TRX-' . str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'kode_customer', 'kode_customer');
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
