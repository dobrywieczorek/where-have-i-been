<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Friend;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'description',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function friends()
    {
        return $this->hasMany(Friend::class, 'user_id');
    }

    public function friendsWith()
    {
        return $this->hasMany(Friend::class, 'friend_with_user_id');
    }

    public function mapPins(): HasMany
    {
        return $this->hasMany(MapPin::class)->latest(); // Orders by the latest map pin first
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
