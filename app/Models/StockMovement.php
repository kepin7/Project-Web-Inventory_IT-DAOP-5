<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    /** @use HasFactory<\Database\Factories\StockMovementFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
