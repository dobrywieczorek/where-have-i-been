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

    public function RegisterUser(Request $request)
    {
        $user = $this->_userAuthService->AddUser($request);
        if($user['success'] == false){
            return response()->json(['errors'=>$user['errors']], 400);
        }

        $token = $this->_userAuthService->CreateUserToken($user['user']);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
