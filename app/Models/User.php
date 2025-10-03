<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'username', 'email', 'password', 'avatar', 'banner',
        'weight', 'height', 'age', 'activity_level', 'goal_type',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function biography()
    {
        return $this->hasOne(Biography::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }

    public function sleeps()
    {
        return $this->hasMany(Sleep::class);
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->wherePivot('status', 'accepted')
                    ->withPivot('status')
                    ->distinct();
    }

    public function sentFriendRequests()
    {
        return $this->hasMany(Friend::class, 'user_id');
    }

    public function receivedFriendRequests()
    {
        return $this->hasMany(Friend::class, 'friend_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isFriendWith(User $user)
    {
        return $this->friends()->where('friend_id', $user->id)->exists();
    }

    public function hasPendingRequestTo(User $user)
    {
        return $this->sentFriendRequests()->where('friend_id', $user->id)
                                          ->where('status', 'pending')
                                          ->exists();
    }

    public function hasPendingRequestFrom(User $user)
    {
        return $this->receivedFriendRequests()->where('user_id', $user->id)
                                             ->where('status', 'pending')
                                             ->exists();
    }
}