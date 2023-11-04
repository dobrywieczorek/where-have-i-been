<?php

namespace App\Http\Services;

use App\Http\Repositories\UserAuthRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Interfaces\IUserAuthService;
use App\Http\Interfaces\IUserAuthRepository;

class UserAuthService implements IUserAuthService
{
    function __construct(private readonly IUserAuthRepository $_userAuthRepository){}

    public function AddUser($userData, $rules){

        $messages = [
            'password.regex' => 'Password must contain one uppercase letter and a number',
        ];

        $validator = Validator::make($userData->all(), $rules, $messages);

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
}
