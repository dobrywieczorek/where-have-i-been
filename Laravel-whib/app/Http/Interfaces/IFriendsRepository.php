<?php

namespace App\Http\Interfaces;

interface IFriendsRepository
{
    function AddFriend($userId, $friendId);
    function DeleteFriend($userId, $friendId);
    function AlreadyFriends($userId, $friendId) : bool;
    function GetUserFriends($userId);
}
