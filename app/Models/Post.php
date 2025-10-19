<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'content',
        'media_path',
        'media_type',
        'views',
    ];

    // Relation: Post belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation: Post has top-level comments (no parent)
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    // Relation: Post has all comments including replies
    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relation: Post has likes/dislikes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Check if post is liked by a specific user
    public function isLikedBy(int $userId): bool
    {
        return $this->likes()->where('user_id', $userId)->where('type', 'like')->exists();
    }

    // Check if post is disliked by a specific user
    public function isDislikedBy(int $userId): bool
    {
        return $this->likes()->where('user_id', $userId)->where('type', 'dislike')->exists();
    }
}