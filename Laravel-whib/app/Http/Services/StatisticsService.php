<?php

namespace App\Http\Services;
use App\Http\Interfaces\IStatisticsRepostiory;
use App\Http\Interfaces\IUserAuthService;
use App\Http\Interfaces\IStatisticsService;

class StatisticsService implements IStatisticsService
{
    function __construct(private readonly IStatisticsRepostiory $_statisticsRepostiory, private readonly IUserAuthService $_userAuthService){}

}
