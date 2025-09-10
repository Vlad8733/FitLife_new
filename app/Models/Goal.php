<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'target_value', 'current_value', 'end_date'];

    public function logs()
    {
        return $this->hasMany(GoalLog::class);
    }

    public function progressPercent()
    {
        return min(100, ($this->current_value / $this->target_value) * 100);
    }
}
