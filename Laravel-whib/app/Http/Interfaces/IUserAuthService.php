<?php

namespace App\Http\Interfaces;

interface IUserAuthService
{
    function AddUser($userData);
    function CreateUserToken($user);
}
