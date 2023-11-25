<?php

namespace App\Http\Interfaces;

interface IStatisticsRepostiory
{
    function GetNumberOfUserPins($user);
    function GetNumberOfUserFriends($user);
    function GetNumberOfUsersObserving($user);
    function GetUserMostPopularPinCategory($user);
}
