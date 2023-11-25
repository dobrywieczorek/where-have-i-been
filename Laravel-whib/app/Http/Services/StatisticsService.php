<?php

namespace App\Http\Services;
use App\Http\Interfaces\IStatisticsRepostiory;
use App\Http\Interfaces\IUserAuthService;
use App\Http\Interfaces\IStatisticsService;

class StatisticsService implements IStatisticsService
{
    function __construct(private readonly IStatisticsRepostiory $_statisticsRepostiory, private readonly IUserAuthService $_userAuthService){}

    public function GetStatistics($request)
    {
        $user = $this->_userAuthService->GetCurrentUserWithToken($request);
        if($user)
        {
            $numberOfPins = $this->_statisticsRepostiory->GetNumberOfUserPins($user);
            $numberOfFriends = $this->_statisticsRepostiory->GetNumberOfUserFriends($user);
            $numberOfObservers = $this->_statisticsRepostiory->GetNumberOfUsersObserving($user);
            $mostUsedPinCategory = $this->_statisticsRepostiory->GetUserMostPopularPinCategory($user);
            return 
            [
                'success' => true,
                'numberOfPins' => $numberOfPins,
                'numberOfFriends' => $numberOfFriends,
                'numberOfObservers' => $numberOfObservers,
                'mostUsedPinCategory' => $mostUsedPinCategory
            ];
        }
        return ['success' => false, 'errors' => 'No user with such token'];
    }
}
