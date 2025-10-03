<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterLog extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'amount',
    ];

    // Relation: Water log belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
