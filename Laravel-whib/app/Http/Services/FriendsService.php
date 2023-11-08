<?php

namespace App\Http\Services;

use App\Http\Interfaces\IFriendsRepository;
use App\Http\Interfaces\IFriendsService;

class FriendsService implements IFriendsService
{

    public function __construct(private readonly IFriendsRepository $_friendsRepository)
    {
        
    }
    public function AddFriend($userId, $friendId)
    {
        if($userId == $friendId)
        {
            return ['success' => false, 'errors' => "User can't befriend himself"];
        }

        if($this->_friendsRepository->AlreadyFriends($userId, $friendId))
        {
            return ['success' => false, 'errors' => "User is already friend"];
        }

        $result = $this->_friendsRepository->AddFriend($userId, $friendId);
        return ['success' => true, 'friend' => $result];
    }

}
