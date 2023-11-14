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
     * @param string|null $category
     * @param string|null $pinName
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserPins($userId, $category = null, $pinName = null)
    {
        $query = $this->where('user_id', $userId);

        if ($category) {
            $query->where('category', $category);
        }

        if ($pinName) {
            $query->where('pin_name', 'like', '%' . $pinName . '%');
        }

        return $query->get();
    }
}
