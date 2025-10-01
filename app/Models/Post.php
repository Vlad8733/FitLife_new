<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'content', 'photo_path', 'views'];

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the top-level comments for the post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    /**
     * Get all comments for the post, including replies.
     */
    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the likes/dislikes for the post.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Check if the post is liked by a specific user.
     *
     * @param int $userId
     * @return bool
     */
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->where('type', 'like')->exists();
    }

    /**
     * Check if the post is disliked by a specific user.
     *
     * @param int $userId
     * @return bool
     */
    public function isDislikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->where('type', 'dislike')->exists();
    }

    
}