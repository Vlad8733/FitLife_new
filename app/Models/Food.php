<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'foods';

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'calories',
    ];

    // Relation: Food belongs to a User (if tracking who added it)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
