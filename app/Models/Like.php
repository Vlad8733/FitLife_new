<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'post_id',
        'user_id',
        'type',
    ];

    // Relation: Like belongs to a Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relation: Like belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
