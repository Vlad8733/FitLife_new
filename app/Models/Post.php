<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','content','photo_path'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy($userId) {
        return $this->likes()->where('user_id',$userId)->where('type','like')->exists();
    }

    public function isDislikedBy($userId) {
        return $this->likes()->where('user_id',$userId)->where('type','dislike')->exists();
    }
}
