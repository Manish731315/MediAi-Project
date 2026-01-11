<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medicine extends Model
{
    // Ensure category_id is in your fillable array
    protected $fillable = [
        'name', 'description', 'price', 'stock', 'image', 
        'prescription_required', 'category_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}