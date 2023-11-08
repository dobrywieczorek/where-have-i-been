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

    public function DeleteFriend($userId, $friendId)
    {
        $friendship = Friend::where('user_id', $userId)
            ->where('friend_with_user_id', $friendId)
            ->first();
        if ($friendship) {
            $friendship->delete();
        }
    }

    public function AlreadyFriends($userId, $friendId) : bool {
        $result = Friend::where('user_id', $userId)->where('friend_with_user_id', $friendId)->exists();
        return $result;
    }
}
