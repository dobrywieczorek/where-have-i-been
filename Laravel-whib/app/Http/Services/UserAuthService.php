<?php

namespace App\Http\Services;

use App\Http\Repositories\UserAuthRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Interfaces\IUserAuthService;
use App\Http\Interfaces\IUserAuthRepository;
use Illuminate\Support\Facades\Auth;

class UserAuthService implements IUserAuthService
{
    function __construct(private readonly IUserAuthRepository $_userAuthRepository){}

    private $messages = [
        'password.regex' => 'Password must contain one uppercase letter and a number',
    ];

    public function AddUser($userData, $rules){

        $validator = Validator::make($userData->all(), $rules, $this->messages);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }

        $user = $this->_userAuthRepository->AddUser($userData);

        return ['success' => true, 'user' => $user];
    }

    public function CreateUserToken($user){
        $token = $this->_userAuthRepository->AddUserToken($user);
        return $token;
    }

    public function GetCurrentUserWithToken($token){
        return $this->_userAuthRepository->GetCurrentUserWithToken($token);
    }

    public function LoginUser($userDetails)
    {
        if(!$userDetails->has('email','password'))
        {
            return ['success' => false, 'errors' => "Invalid login details"];
        }

        if(!$this->_userAuthRepository->TryAuthUser($userDetails))
            return ['success' => false, 'errors' => "Invalid login details"];

        $user = $this->_userAuthRepository->GetUserWithEmail($userDetails['email']);    
        $token = $this->_userAuthRepository->AddUserToken($user);
        return ['success' => true, 'access_token' => $token];
    }

    public function UpdateUser($user, $newUserData, $rules){
        $validator = Validator::make($newUserData, $rules, $this->messages);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }

        $updatedUser = $this->_userAuthRepository->UpdateUser($user, $newUserData);

        return ['success' => true, 'user' => $updatedUser];
    }

    public function GetUsersByName($name)
    {
        if($name == null || $name == "")
        {
            return ['success' => false, 'errors' => "Invalid name"];
        }

        $users = $this->_userAuthRepository->GetUsersByName($name);

        return ['success' => true, 'users' => $users];
    }

    public function GetUsersById($id)
    {
        if($id == null || $id == 0)
        {
            return ['success' => false, 'errors' => "Invalid id"];
        }

        $users = $this->_userAuthRepository->GetUserById($id);

        return ['success' => true, 'users' => $users];
    }

    public function LogoutUser($request){
        $this->_userAuthRepository->LogoutUser($request);
    }
}
