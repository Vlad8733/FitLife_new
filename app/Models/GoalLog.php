<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoalLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'value',
        'date',
        'notes',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'date' => 'datetime',
    ];

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }
}
