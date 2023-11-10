<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IFriendsService;
use Illuminate\Http\Request;
use App\Http\Interfaces\IUserAuthService;

class FriendsController extends Controller
{

    public function __construct(private readonly IFriendsService $_friendsService, private readonly IUserAuthService $_userAuthService)
    {
        
    }
    public function AddFriend(Request $request)
    {
        if(!$request->has('friend_id'))
        {
            return response()->json(['errors'=>"Invalid request"], 400);
        }

        $user = $this->_userAuthService->GetCurrentUserWithToken($request);

        $result = $this->_friendsService->AddFriend($user['id'], $request['friend_id']);
        if($result['success'] == false)
        {
            return response()->json(['errors'=>$result['errors']], 401);
        }

        return response()->json([
            'friends' => $result
        ]);
    }

    public function DeleteFriend(Request $request){
        
        if(!$request->has('friend_id'))
        {
            return response()->json(['errors'=>"Invalid request"], 400);
        }

        $user = $this->_userAuthService->GetCurrentUserWithToken($request);

        $result = $this->_friendsService->DeleteFriend($user['id'], $request['friend_id']);
        if($result['success'] == false)
        {
            return response()->json(['errors'=>$result['errors']], 401);
        }

        return response()->json();
    }

    public function GetUserFriends(Request $request){
        $result = $this->_friendsService->GetUserFriends($request);
        return response()->json([
            'friends' => $result['friends']
        ]);
    }
}
