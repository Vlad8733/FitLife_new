<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biography extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'full_name',
        'age',
        'height',
        'weight',
        'gender',
    ];

    // Relation: Biography belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
