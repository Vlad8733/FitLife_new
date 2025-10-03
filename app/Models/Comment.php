<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content',
    ];

    // Relation: Comment belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation: Comment belongs to a Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relation: Comment may have a parent comment
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Relation: Comment may have many replies
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Relation: Comment may have many likes/dislikes
    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }
}
