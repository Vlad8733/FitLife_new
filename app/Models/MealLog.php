<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'meal', 'food', 'quantity', 'calories'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
