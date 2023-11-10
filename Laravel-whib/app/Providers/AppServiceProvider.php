<?php

namespace App\Providers;

use App\Http\Interfaces\IFriendsRepository;
use App\Http\Interfaces\IFriendsService;
use Illuminate\Support\ServiceProvider;
use App\Http\Interfaces\IUserAuthService;
use App\Http\Services\UserAuthService;
use App\Http\Interfaces\IUserAuthRepository;
use App\Http\Repositories\FriendsRepository;
use App\Http\Repositories\UserAuthRepository;
use App\Http\Services\FriendsService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserAuthService::class, UserAuthService::class);
        $this->app->bind(IUserAuthRepository::class, UserAuthRepository::class);
        $this->app->bind(IFriendsRepository::class, FriendsRepository::class);
        $this->app->bind(IFriendsService::class, FriendsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
