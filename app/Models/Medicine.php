<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    // Add fillable properties
    protected $fillable = [
        'name', 'description', 'price', 'image', 'stock', 'category', 'prescription_required'
    ];
}
