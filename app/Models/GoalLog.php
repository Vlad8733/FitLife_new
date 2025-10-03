<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalLog extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'goal_id',
        'value',
        'date',
    ];

    // Relation: GoalLog belongs to a Goal
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}
