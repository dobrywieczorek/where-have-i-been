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

    /**
     * Get all map pins for a user.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getUserPins($userId)
    {
        return self::where('user_id', $userId)->get();
    }

    /**
     * Get user pins by category and name.
     *
     * @param int    $userId
     * @param string $category
     * @param string $pin_name
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getUserPinsByCategoryAndName($userId, $category, $pin_name)
    {
        return self::where('user_id', $userId)
            ->when($category, function ($query) use ($category) {
                return $query->where('category', $category);
            })
            ->when($pin_name, function ($query) use ($pin_name) {
                return $query->where('pin_name', 'like', '%' . $pin_name . '%');
            })
            ->get();
    }
}


