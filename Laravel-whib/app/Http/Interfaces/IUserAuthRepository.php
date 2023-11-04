<?php

namespace App\Http\Interfaces;

interface IUserAuthRepository
{
    function AddUserToken($user);
    function AddUser($userData);
}
