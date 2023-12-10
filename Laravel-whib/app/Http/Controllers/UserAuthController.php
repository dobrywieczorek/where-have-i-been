<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IUserAuthService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\ErrorHandler\Debug;

class UserAuthController extends Controller
{
    function __construct(private readonly IUserAuthService $_userAuthService){}

    private array $rules = [
        'name' => 'required|string|max:255|regex:/^[A-Za-z0-9\s]+$/',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
    ];

    public function RegisterUser(Request $request)
    {

        if(!$request->has('name','email','password'))
        {
            return response()->json(['errors'=>"Invalid request"], 400);
        }


        $user = $this->_userAuthService->AddUser($request, $this->rules);
        if($user['success'] == false){
            return response()->json(['errors'=>$user['errors']], 400);
        }

        $token = $this->_userAuthService->CreateUserToken($user['user']);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function GetCurrentUser(Request $request){
        return $this->_userAuthService->GetCurrentUserWithToken($request);
    }

    public function LoginUser(Request $request)
    {
        if(!$request->has('email','password'))
        {
            return response()->json(['errors'=>"Invalid request"], 400);
        }

        $userLoginResponse = $this->_userAuthService->LoginUser($request);
        
        if($userLoginResponse['success']==false){
            return response()->json(['errors'=>$userLoginResponse['errors']], 401);
        }

        return response()->json([
                'access_token' => $userLoginResponse['access_token'],
                'token_type' => 'Bearer',
        ]);
    }
    
    public function LogoutUser(Request $request)
    {
        $this->_userAuthService->LogoutUser($request);
        return response()->json([]);
    }

    public function EditUser(Request $request)
    {
        if(!$request->has('name', 'password'))
        {
            return response()->json(['errors'=>"Invalid request"], 400);
        }

        $user = $this->_userAuthService->GetCurrentUserWithToken($request);

        $editRules = [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
            'description' => 'string|max:255'
        ];

        $newUser = $this->_userAuthService->UpdateUser($user, $request->only(['name', 'description', 'password']), $editRules);

        if($newUser['success'] == false){
            return response()->json(['errors'=>$newUser['errors']], 401);
        }

        return response()->json([
            'user' => $newUser
        ]);

    }

    public function GetUsersByName(Request $request)
    {
        if(!$request->has('name'))
        {
            return response()->json(['errors'=>"Invalid request"], 400);
        }

        $users = $this->_userAuthService->GetUsersByName($request['name']);

        if($users['success'] == false)
        {
            return response()->json(['errors'=>$users['errors']], 401);
        }

        return response()->json([
            'users' => $users
        ]);
    }

    public function GetUserById(Request $request)
    {
        if(!$request->has('id'))
        {
            return response()->json(['errors'=>"Invalid request"], 400);
        }

        $users = $this->_userAuthService->GetUsersById($request['id']);

        if($users['success'] == false)
        {
            return response()->json(['errors'=>$users['errors']], 401);
        }

        return response()->json([
            'users' => $users
        ]);
    }
}
