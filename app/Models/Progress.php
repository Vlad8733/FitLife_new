<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'photo',        // path to the progress photo
        'description',  // optional description
    ];

    // Relation: Progress photo belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
