<?php

namespace App\Http\Interfaces;

interface IFriendsRepository
{
    function AddFriend($userId, $friendId);
}
