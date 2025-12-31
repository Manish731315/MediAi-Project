<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'medicine_id',
        'quantity',
        'price',
    ];

    /**
     * Get the medicine associated with the order item.
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}