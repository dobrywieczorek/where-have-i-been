<?php

namespace App\Http\Services;

use App\Http\Interfaces\IFriendsRepository;
use App\Http\Interfaces\IFriendsService;
use App\Http\Interfaces\IUserAuthService;

class FriendsService implements IFriendsService
{

    public function __construct(private readonly IFriendsRepository $_friendsRepository, private readonly IUserAuthService $_userAuthService)
    {
        
    }
    public function AddFriend($userId, $friendId)
    {

        if($userId == 0 || $friendId == 0)
        {
            return ['success' => false, 'errors' => "Id can't be 0"];
        }

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

    public function DeleteFriend($userId, $friendId)
    {
        if($userId == 0 || $friendId == 0)
        {
            return ['success' => false, 'errors' => "Id can't be 0"];
        }

        if($userId == $friendId)
        {
            return ['success' => false, 'errors' => "User can't befriend himself"];
        }

        if(!$this->_friendsRepository->AlreadyFriends($userId, $friendId))
        {
            return ['success' => false, 'errors' => "User doenst have friend with this id"];
        }
        $this->_friendsRepository->DeleteFriend($userId, $friendId);
        return ['success' => true];
    }

    public function GetUserFriends($token){
        $user = $this->_userAuthService->GetCurrentUserWithToken($token);
        $friends = $this->_friendsRepository->GetUserFriends($user['id']);
        return ['success' => true, 'friends' => $friends];
    }
}
