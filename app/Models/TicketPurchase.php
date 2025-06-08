<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'wahana_id',
        'schedule_id',
        'jumlah_tiket',
        'total_harga',
    ];
}