<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'wahana_id',
        'start_time',
        'end_time',
    ];

    public function wahana()
    {
        return $this->belongsTo(Wahana::class);
    }
}
