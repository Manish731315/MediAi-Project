<?php

namespace App\Models; // <-- Correct backslash

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SymptomSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'symptoms_input',
        'ai_response',
    ];

    /**
     * Get the user who owned the chat session.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}