<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Biography extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'age',
        'height',
        'weight',
        'gender'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
