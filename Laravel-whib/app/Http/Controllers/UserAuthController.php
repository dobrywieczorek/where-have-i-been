<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IUserAuthService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    function __construct(private readonly IUserAuthService $_userAuthService){}

}
