<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IFriendsService;
use Illuminate\Http\Request;
use App\Http\Interfaces\IUserAuthService;

class FriendsController extends Controller
{

    public function __construct(private readonly IFriendsService $_friendsService, private readonly IUserAuthService $_userAuthService)
    {
        
    }
}
