<?php

namespace App\Http\Interfaces;

interface IUserAuthService
{
    function AddUser($userData, $rules);
    function CreateUserToken($user);
    function GetCurrentUserWithToken($token);
    function LoginUser($userDetails);
    function UpdateUser($user, $newUserData, $rules);
    function GetUsersByName($name);
    function GetUsersById($id);
    function LogoutUser($request);
    function LoginUserWithGoogle();
    function LoginUserWithFacebook();
}
