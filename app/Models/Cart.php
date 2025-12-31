<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    // Add fillable properties to allow mass assignment
    protected $fillable = [
        'user_id',
        'medicine_id',
        'quantity',
    ];

    // Optional: if you want Laravel to automatically manage timestamps
    public $timestamps = true;

    // Relationships (optional but recommended)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}

