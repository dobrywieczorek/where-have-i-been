<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MapPin extends Model
{
    use HasApiTokens, Notifiable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pin_name',
        'favourite',
        'latitude',
        'longitude',
        'user_id',
        'category',
        'description',
        'IsTrip',
        'TripDate'
    ];

    /**
     * Get all map pins for a user.
     *
     * @param int $userId
     * @param string|null $category
     * @param string|null $pinName
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserPins($userId, $category = null, $pinName = null, $isTrip = null)
    {
        $query = $this->where('user_id', $userId);

        if ($category) {
            $query->where('category', $category);
        }

        if ($pinName) {
            $query->where('pin_name', 'like', '%' . $pinName . '%');
        }

        if ($isTrip !== null) {
            $query->where('IsTrip', $isTrip);
        }

        return $query->get();
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
