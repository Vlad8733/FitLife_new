<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'type',
        'description',
        'completed',
    ];

    protected $casts = [
        'date' => 'date',
        'completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}