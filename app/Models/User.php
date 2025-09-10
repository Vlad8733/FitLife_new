<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'weight',
        'height',
        'age',
        'activity_level',
        'goal_type'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sleeps()
    {
        return $this->hasMany(Sleep::class);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }

    // ===== Связь с биографией =====
    public function biography()
    {
        return $this->hasOne(Biography::class);
    }
}
