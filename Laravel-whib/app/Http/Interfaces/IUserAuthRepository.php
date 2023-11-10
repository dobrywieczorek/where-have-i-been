<?php

namespace App\Http\Interfaces;

interface IUserAuthRepository
{
    function AddUserToken($user);
    function AddUser($userData);
    function GetCurrentUserWithToken($token);
    function GetUserWithEmail($email);
    function TryAuthUser($userDetails) : bool;
    function UpdateUser($user, $newUserData);
    function GetUsersByName($name);
    function GetUserById($id);
}
