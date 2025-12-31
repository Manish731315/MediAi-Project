<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'total_amount',
    'status',
    'payment_method',
    'payment_id',
    'razorpay_order_id',
    'delivery_address', 
    'alternate_phone',  
    'city', 'state', 'country', 'pincode', 'landmark',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    /**
     * Get all prescriptions associated with the order.
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}