<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Interfaces\IStatisticsService;

class StatisticsController extends Controller
{
    function __construct(private readonly IStatisticsService $_statisticsService){}

}
