<?php

namespace App\Http\Interfaces;

interface IFriendsService
{
    function AddFriend($userId, $friendId);
    function DeleteFriend($userId, $friendId);
    function GetUserFriends($token);
}
