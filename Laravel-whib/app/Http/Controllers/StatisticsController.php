<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Interfaces\IStatisticsService;

class StatisticsController extends Controller
{
    function __construct(private readonly IStatisticsService $_statisticsService){}

    public function GetUserStatistics(Request $request)
    {

        if(!$request->has('user_id'))
        {
            return response()->json(['errors'=>"Invalid request"], 400);
        }

        $statistics = $this->_statisticsService->GetStatistics($request['user_id']);
        if($statistics['success']==true)
        {
            return response()->json([
                'numberOfPins' => $statistics['numberOfPins'],
                'numberOfFriends' => $statistics['numberOfFriends'],
                'numberOfObservers' => $statistics['numberOfObservers'],
                'mostUsedPinCategory' => $statistics['mostUsedPinCategory']
            ]);
        }
        return response()->json(['errors'=>$statistics['errors']], 400);
    }
}
