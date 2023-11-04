<?php

namespace App\Http\Repositories;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Interfaces\IUserAuthRepository;
use Illuminate\Support\Facades\Auth;

class UserAuthRepository implements IUserAuthRepository
{
    public function AddUser($userData){
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);
        return $user;
    }

    public function AddUserToken($user){
        $token = $user->createToken('auth_token')->plainTextToken;
        return $token;
    }

    public function GetCurrentUserWithToken($token){
        return $token->user();
    }

    public function GetUserWithEmail($email){
        return User::where('email', $email)->firstOrFail();
    }

    public function TryAuthUser($userDetails) : bool{
        return !Auth::attempt($userDetails->only('email', 'password'));
    }
}
