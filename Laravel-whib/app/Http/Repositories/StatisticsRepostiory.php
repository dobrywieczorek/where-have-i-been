<?php

namespace App\Http\Repositories;
use App\Models\User;
use App\Models\Friend;
use App\Http\Interfaces\IStatisticsRepostiory;
use Illuminate\Support\Facades\DB;

class StatisticsRepostiory implements IStatisticsRepostiory
{
    public function GetNumberOfUserPins($user)
    {
        return $user->mapPins()->count();
    }

    public function GetNumberOfUserFriends($user)
    {
        return $user->friends()->count();
    }

    public function GetNumberOfUsersObserving($user)
    {
        return Friend::where('friend_with_user_id', $user['id'])->count();
    }

}
