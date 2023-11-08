<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\IFriendsRepository;
use App\Models\Friend;

class FriendsRepository implements IFriendsRepository
{
    public function AddFriend($userId, $friendId)
    {
        $friendship = Friend::create([
            'user_id' => $userId,
            'friend_with_user_id' => $friendId,
        ]);

        return $friendship;
    }

}
