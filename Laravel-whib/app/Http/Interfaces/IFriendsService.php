<?php

namespace App\Http\Interfaces;

interface IFriendsService
{
    function AddFriend($userId, $friendId);
}
