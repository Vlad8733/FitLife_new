<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'comment_id',
        'user_id',
        'type', // 'like' or 'dislike'
    ];

    // Relation: CommentLike belongs to a Comment
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    // Relation: CommentLike belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
