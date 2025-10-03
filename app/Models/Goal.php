<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'type',
        'target_value',
        'current_value',
        'end_date',
    ];

    // Relation: Goal has many logs
    public function logs()
    {
        return $this->hasMany(GoalLog::class);
    }

    // Calculate progress percentage (max 100%)
    public function progressPercent()
    {
        return $this->target_value > 0
            ? min(100, ($this->current_value / $this->target_value) * 100)
            : 0;
    }
}
