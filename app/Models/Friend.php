<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'friends';

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'friend_id',
        'status',
    ];

    // Enable timestamps
    public $timestamps = true;

    // Relation: Friend record belongs to a User (requester)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation: Friend record belongs to a User (requested friend)
    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }
}
