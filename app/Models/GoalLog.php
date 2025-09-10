<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalLog extends Model
{
    use HasFactory;

    protected $fillable = ['goal_id', 'value', 'date'];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}
