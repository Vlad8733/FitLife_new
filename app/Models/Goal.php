<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'target_value',
        'current_value',
        'end_date',
        'change',
    ];

    protected $casts = [
        'target_value' => 'decimal:2',
        'current_value' => 'decimal:2',
        'end_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(GoalLog::class);
    }

    public function progressPercent(): float
    {
        // Guard against division by zero or negative targets
        $target = (float) $this->target_value;
        $current = (float) $this->current_value;

        if ($target <= 0) {
            return 0.0;
        }

        $progress = ($current / $target) * 100.0;

        if ($progress < 0.0) {
            return 0.0;
        }

        return (float) min(100.0, round($progress, 2));
    }
}
