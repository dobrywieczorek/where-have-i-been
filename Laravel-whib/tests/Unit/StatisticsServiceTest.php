<?php

namespace Tests\Unit;
use Mockery;
use Tests\TestCase;
use App\Http\Interfaces\IStatisticsRepostiory;
use App\Http\Interfaces\IUserAuthService;
use App\Http\Interfaces\IStatisticsService;
use App\Http\Services\StatisticsService;

class StatisticsServiceTest extends TestCase
{
    public function test_GetStatistics_CorrectData_ReturnsSuccessTrue()
    {
        $userAuthService = Mockery::mock(IUserAuthService::class);
        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $userAuthService->shouldReceive('GetUsersById')->andReturn(['name' => 'John', 'email' => 'john@example.com', 'users' => [['name' => 'mateusz']]]);

        $statisticsRepository = Mockery::mock(IStatisticsRepostiory::class);
        /** @var \Mockery\Mock|IUserAuthRepository $userAuthRepository */
        $statisticsRepository->shouldReceive('GetNumberOfUserPins')->andReturn(5);
        $statisticsRepository->shouldReceive('GetNumberOfUserFriends')->andReturn(5);
        $statisticsRepository->shouldReceive('GetNumberOfUsersObserving')->andReturn(5);
        $statisticsRepository->shouldReceive('GetUserMostPopularPinCategory')->andReturn(5);

        $statisticsService = new StatisticsService($statisticsRepository, $userAuthService);

        $result = $statisticsService->GetStatistics(6);
        $this->assertTrue($result['success']);
    }
}
