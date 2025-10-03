<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealLog extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'meal',
        'food',
        'quantity',
        'calories',
    ];

    // Relation: MealLog belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
