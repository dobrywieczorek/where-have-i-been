<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Interfaces\IUserAuthService;
use App\Http\Services\UserAuthService;
use App\Http\Interfaces\IUserAuthRepository;
use App\Http\Repositories\UserAuthRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserAuthService::class, UserAuthService::class);
        $this->app->bind(IUserAuthRepository::class, UserAuthRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
