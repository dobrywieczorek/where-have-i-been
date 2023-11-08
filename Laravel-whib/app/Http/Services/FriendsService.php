<?php

namespace App\Http\Services;

use App\Http\Interfaces\IFriendsRepository;
use App\Http\Interfaces\IFriendsService;

class FriendsService implements IFriendsService
{

    public function __construct(private readonly IFriendsRepository $_friendsRepository)
    {
        
    }
}
