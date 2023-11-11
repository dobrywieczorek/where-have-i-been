<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MapPin extends Model
{
    use HasApiTokens, Notifiable, HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pin_name',
        'description',
        'favourite',
        'latitude',
        'longitude',
        'user_id',
        'category',
        // Add other attributes as needed
    ];
}
